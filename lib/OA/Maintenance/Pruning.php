<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/OA.php';

/**
 * A wrapper class for running the Maintenance Priority Engine process.
 *
 * @static
 * @package    OpenXMaintenance
 * @subpackage Pruning
 */
class OA_Maintenance_Pruning extends MAX_Dal_Common
{
    /**
     * The class constructor method.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function run()
    {
        $this->_pruneDataSummaryAdZoneAssoc();
    }

    /**
     * Method to remove records from the data_summary_ad_zone_assoc table
     * Makes 3 passes and logs the results of each
     * The 3rd pass takes a param 'max number of records to delete'
     * Finally the table is queried for reserved diskspace and reports
     *
     */
    public function _pruneDataSummaryAdZoneAssoc()
    {
        OA::debug('Begin pruning old records from data_summary_ad_zone_assoc', PEAR_LOG_INFO);
        $pruned = $this->_pruneDataSummaryAdZoneAssocOldData();
        OA::debug('Finished pruning old records from data_summary_ad_zone_assoc: ' . $pruned . ' records deleted', PEAR_LOG_INFO);
        OA::debug('Begin pruning records for expired inactive campaigns from data_summary_ad_zone_assoc', PEAR_LOG_INFO);
        $pruned = $this->_pruneDataSummaryAdZoneAssocInactiveExpired();
        OA::debug('Finished pruning expired inactive campaigns from data_summary_ad_zone_assoc: ' . $pruned . ' records deleted', PEAR_LOG_INFO);
        OA::debug('Begin pruning records for completed inactive campaigns from data_summary_ad_zone_assoc', PEAR_LOG_INFO);
        if ($GLOBALS['_MAX']['CONF']['maintenance']['pruneCompletedCampaignsSummaryData']) {
            $pruned = $this->_pruneDataSummaryAdZoneAssocInactiveTargetReached(1000);
            OA::debug('Finished pruning inactive completed campaigns from data_summary_ad_zone_assoc: ' . $pruned . ' records deleted', PEAR_LOG_INFO);
        }

        // log the table status/overhead
        $this->_logTableOverhead('data_summary_ad_zone_assoc');
    }

    /**
     * A method to prune the data_summary_ad_zone_assoc table.
     *
     * Pruning can be performed where the entry is older than MAX_PREVIOUS_AD_DELIVERY_INFO_LIMIT minutes ago.
     * If the table has more than 100k rows and more than 60% of the rows is expected to be pruned,
     * the strategy changes: the rows to be kept are copied to a temporary table, the DSAZA table is truncated
     * and the
     *
     * @return integer : number of records deleted
     */
    public function _pruneDataSummaryAdZoneAssocOldData(int $useTruncateThreshold = 100000)
    {
        $tblAssoc = $this->_getTablename('data_summary_ad_zone_assoc');

        $oServiceLocator = OA_ServiceLocator::instance();
        /** @var Date $oDate */
        $oDate = clone $oServiceLocator->get('now');
        $oDate->subtractSeconds(MAX_PREVIOUS_AD_DELIVERY_INFO_LIMIT * 60);

        $qDate = $this->oDbh->quote($oDate->getDate());

        // Get total and old records
        $row = array_map('intval', $this->oDbh->queryRow("
            SELECT
                COUNT(*) AS cnt,
                COALESCE(SUM(IF(interval_start < {$qDate}, 1, 0)), 0) AS old
            FROM {$tblAssoc}
        "));

        if (0 === $row['cnt']) {
            return 0;
        }

        try {
            if ($row['cnt'] >= $useTruncateThreshold && $row['old'] / $row['cnt'] > 0.6) {
                OA::debug('Optimized pruning in use', PEAR_LOG_DEBUG);
                return $row['cnt'] - $this->pruneDSAZAOldDataWithTempTable($tblAssoc, $qDate);
            }
        } catch (\RuntimeException $e) {
            OA::debug("{$e->getMessage()}, falling back to regular DELETE-based pruning", PEAR_LOG_WARNING);
        }

        return $this->pruneDSAZAOldDataWithDelete($tblAssoc, $qDate);
    }

    /**
     * A method to prune the data_summary_ad_zone_assoc table
     * Prune all entries where the ad_id is for a banner in a High Priority Campaign where:
     * The campaign does not have any booked lifetime target values AND the campaign has an end date AND the end date has been passed AND the campaign is not active.
     *
     * @return integer : number of records deleted
     */
    public function _pruneDataSummaryAdZoneAssocInactiveExpired()
    {
        $tblAssoc = $this->_getTablename('data_summary_ad_zone_assoc');
        $tblBanners = $this->_getTablename('banners');
        $tblCampaigns = $this->_getTablename('campaigns');

        $queryEnd = ''
            . ' WHERE ( ( c.status <> ' . OA_ENTITY_STATUS_RUNNING . ') AND (c.priority > 0 )) '
            . ' AND'
            . '('
            . '      ('
            . '          (c.target_impression < 1)'
            . '          AND'
            . '          (c.target_click < 1)'
            . '          AND'
            . '          (c.target_conversion < 1)'
            . '      )'
            . '      AND'
            . '      (c.expire_time < ' . $this->oDbh->quote(OA::getNowUTC('Y-m-d H:i:s')) . ')'
            . ')';

        if ($this->oDbh->dbsyntax == 'pgsql') {
            $query = 'DELETE FROM ' . $tblAssoc
                . ' WHERE ad_id IN ('
                . '  SELECT b.bannerid FROM'
                . '  ' . $tblBanners . ' AS b'
                . '  JOIN ' . $tblCampaigns . ' AS c ON b.campaignid = c.campaignid'
                . $queryEnd
                . ')';
        } else {
            $query = 'DELETE FROM ' . $tblAssoc
                . ' USING ' . $tblAssoc
                . ' JOIN ' . $tblBanners . ' AS b ON ' . $tblAssoc . '.ad_id = b.bannerid'
                . ' JOIN ' . $tblCampaigns . ' AS c USE INDEX () ON b.campaignid = c.campaignid'
                . $queryEnd;
        }
        return $this->oDbh->exec($query);
    }

    /**
     * A method to prune the data_summary_ad_zone_assoc table
     * Prune all entries where the ad_id is for a banner in a High Priority Campaign where:
     * The campaign has a booked number of lifetime target impressions and/or clicks and/or conversions AND the campaign is not active AND at least one of the booked lifetime target values has been reached.
     *
     * @param integer : the max number of records to delete
     *
     * @return integer : number of records deleted
     */
    public function _pruneDataSummaryAdZoneAssocInactiveTargetReached($numberToDelete = 100)
    {
        $tblInter = $this->_getTablename('data_intermediate_ad');
        $tblAssoc = $this->_getTablename('data_summary_ad_zone_assoc');
        $tblBanners = $this->_getTablename('banners');
        $tblCampaigns = $this->_getTablename('campaigns');

        $query = 'SELECT
                     daz.data_summary_ad_zone_assoc_id,
                     IF( (SUM( dia.impressions ) >= c.views)
                     OR  (SUM( dia.clicks ) >= c.clicks)
                     OR  (SUM( dia.conversions ) >= c.conversions), 1, 0) AS target_reached
                 FROM ' . $tblAssoc . ' daz
                 LEFT JOIN ' . $tblInter . ' AS dia ON dia.ad_id = daz.ad_id
                 LEFT JOIN ' . $tblBanners . ' AS b ON daz.ad_id = b.bannerid
                 LEFT JOIN ' . $tblCampaigns . ' AS c ON b.campaignid = c.campaignid
                 WHERE ( ( c.status <> ' . OA_ENTITY_STATUS_RUNNING . ') AND (c.priority > 0 ))
                 GROUP BY daz.data_summary_ad_zone_assoc_id, c.views, c.clicks, c.conversions
                 ORDER BY target_reached DESC';

        $aRows = $this->oDbh->queryAll($query);

        $numberToDelete = min(count($aRows), $numberToDelete);
        $aIds = [];
        $result = 0;
        foreach ($aRows as $k => $aRec) {
            if ((count($aIds) == $numberToDelete) || ($aRec['target_reached'] == 0)) {
                break;
            }
            if ($aRec['target_reached'] == 1) {
                $aIds[] = $aRec['data_summary_ad_zone_assoc_id'];
            }
        }
        if (!empty($aIds)) {
            $doDSAZA = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
            $doDSAZA->whereAdd('data_summary_ad_zone_assoc_id IN (' . implode(',', $aIds) . ')');
            $result = $doDSAZA->delete(true, false);
        }
        return $result;
    }

    /**
     * logs the overhead of a table
     *
     * @param string $table : name of table without prefix
     */
    public function _logTableOverhead($table)
    {
        $table = $this->_getTablenameUnquoted($table);
        $aResult = $this->oDbh->manager->getTableStatus($table);
        if (isset($aResult[0]['data_free']) && is_numeric($aResult[0]['data_free'])) {
            $overhead = $aResult[0]['data_free'];
            OA::debug('Table ' . $table . ' overhead (number of allocated but unused bytes) = ' . $overhead);
            if ($overhead > 0) {
                OA::debug('To reclaim diskspace, consider optimising this table');
            }
        } else {
            OA::debug('Table ' . $table . ' overhead (number of allocated but unused bytes) = unkown');
        }
    }

    /**
     * Prune DSAZA with a regular delete statement.
     *
     * @return int|PEAR_Error Deleted rows if successful
     */
    private function pruneDSAZAOldDataWithDelete(string $tblAssoc, string $qDate)
    {
        return $this->oDbh->exec("DELETE FROM {$tblAssoc} WHERE interval_start < {$qDate}");
    }

    /**
     * Prune DSAZA using a temporary table and truncate.
     *
     * @return int|PEAR_Error Remaining rows if successful
     */
    private function pruneDSAZAOldDataWithTempTable(string $tblAssoc, string $qDate)
    {
        $tblPrune =  $this->_getTablename('data_summary_ad_zone_prune');

        $res = $this->oDbh->exec("CREATE TEMPORARY TABLE {$tblPrune} AS SELECT * FROM {$tblAssoc} WHERE interval_start >= {$qDate}");
        if (PEAR::isError($res)) {
            throw new \RuntimeException('Failed to create temporary table: ' . $res->getMessage());
        }

        $res = $this->oDbh->exec("TRUNCATE {$tblAssoc}");
        if (PEAR::isError($res)) {
            throw new \RuntimeException('Failed to truncate DSAZA: ' . $res->getMessage());
        }

        $records = $this->oDbh->exec("INSERT INTO {$tblAssoc} SELECT * FROM {$tblPrune}");
        if (PEAR::isError($records)) {
            OA::debug('Failed to insert records to data_summary_ad_zone_assoc after truncating the table', PEAR_LOG_WARNING);
            $records = 0;
        }

        // If the following fails, the table will be dropped at the end of the connection anyway
        $this->oDbh->exec("DROP TABLE {$tblPrune}");

        return $records;
    }
}
