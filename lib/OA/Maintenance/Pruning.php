<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

require_once MAX_PATH . '/lib/OA.php';
/*require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/pear/Date.php';
*/
/**
 * A wrapper class for running the Maintenance Priority Engine process.
 *
 * @static
 * @package    OpenXMaintenance
 * @subpackage Pruning
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Pruning extends MAX_Dal_Common
{

    /**
     * The class constructor method.
     */
    function OA_Maintenance_Pruning()
    {
        parent::MAX_Dal_Common();
    }

    function run()
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
    function _pruneDataSummaryAdZoneAssoc()
    {
        OA::debug('Begin pruning old records from data_summary_ad_zone_assoc', PEAR_LOG_INFO);
        $pruned = $this->_pruneDataSummaryAdZoneAssocOldData();
        OA::debug('Finished pruning old records from data_summary_ad_zone_assoc: '.$pruned.' records deleted', PEAR_LOG_INFO);
        OA::debug('Begin pruning records for expired inactive campaigns from data_summary_ad_zone_assoc', PEAR_LOG_INFO);
        $pruned = $this->_pruneDataSummaryAdZoneAssocInactiveExpired();
        OA::debug('Finished pruning expired inactive campaigns from data_summary_ad_zone_assoc: '.$pruned.' records deleted', PEAR_LOG_INFO);
        OA::debug('Begin pruning records for completed inactive campaigns from data_summary_ad_zone_assoc', PEAR_LOG_INFO);
        if ($GLOBALS['_MAX']['CONF']['maintenance']['pruneCompletedCampaignsSummaryData'])
        {
            $pruned = $this->_pruneDataSummaryAdZoneAssocInactiveTargetReached(1000);
            OA::debug('Finished pruning inactive completed campaigns from data_summary_ad_zone_assoc: '.$pruned.' records deleted', PEAR_LOG_INFO);
        }

        // log the table status/overhead
        $this->_logTableOverhead('data_summary_ad_zone_assoc');
    }

    /**
     * A method to prune the data_summary_ad_zone_assoc table
     * Pruning can be performed where zone_id = 0 (i.e. for direct selection) and where the entry is older than MAX_PREVIOUS_AD_DELIVERY_INFO_LIMIT minutes ago.
     *
     * @return integer : number of records deleted
     */
    function _pruneDataSummaryAdZoneAssocOldData()
    {
        $doDSAZA = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
        $doDSAZA->whereAdd('zone_id=0', 'AND');
        $doDSAZA->whereAdd('created < DATE_ADD('
                            .$this->oDbh->quote(OA::getNow()).', '
                            .OA_Dal::quoteInterval(-MAX_PREVIOUS_AD_DELIVERY_INFO_LIMIT, 'SECOND')
                            .')'
                            ,'AND');
        return $doDSAZA->delete(true, false);
    }

    /**
     * A method to prune the data_summary_ad_zone_assoc table
     * Prune all entries where the ad_id is for a banner in a High Priority Campaign where:
    * The campaign does not have any booked lifetime target values AND the caMpaign has an end date AND the end date has been passed AND the campaign is not active.
     *
     * @return integer : number of records deleted
     */
    function _pruneDataSummaryAdZoneAssocInactiveExpired()
    {
        $tblAssoc       = $this->_getTablename('data_summary_ad_zone_assoc');
        $tblBanners     = $this->_getTablename('banners');
        $tblCampaigns   = $this->_getTablename('campaigns');

        $queryEnd = ''
            .' LEFT JOIN '.$tblCampaigns.' AS c ON b.campaignid = c.campaignid'
            .' WHERE ( ( c.status <> '. OA_ENTITY_STATUS_RUNNING.') AND (c.priority > 0 )) '
            .' AND'
            .'('
            .'      ('
            .'          (c.target_impression < 1)'
            .'          AND'
            .'          (c.target_click < 1)'
            .'          AND'
            .'          (c.target_conversion < 1)'
            .'      )'
            .'      AND'
            .'      (UNIX_TIMESTAMP(c.expire) > 0)'
            .'      AND'
            .'      (c.expire < '.$this->oDbh->quote(OA::getNow('Y-m-d')).')'
            .')'
            ;

        if ($this->oDbh->dbsyntax == 'pgsql') {
            $query = 'DELETE FROM '.$tblAssoc
                    .' WHERE data_summary_ad_zone_assoc_id IN ('
                    .'  SELECT dsaza.data_summary_ad_zone_assoc_id FROM'
                    .'  '.$tblAssoc.' AS dsaza'
                    .' LEFT JOIN '.$tblBanners.' AS b ON dsaza.ad_id = b.bannerid'
                    .$queryEnd
                    .')';
        } else {
            $query = 'DELETE FROM '.$tblAssoc
                    .' USING '.$tblAssoc
                    .' LEFT JOIN '.$tblBanners.' AS b ON '.$tblAssoc.'.ad_id = b.bannerid'
                    .$queryEnd;
        }
        return $this->oDbh->exec($query);
    }

    /**
     * A method to prune the data_summary_ad_zone_assoc table
     * Prune all entries where the ad_id is for a banner in a High Priority Campaign where:
     * The campaign has a booked number of lifetime target impressions and/or clicks and/or conversions AND the campaign is not active AND at least one of the booked lifetime target values has been reached.
     *
     * @param integer : the max number of records to delete
     * @return integer : number of records deleted
     */
    function _pruneDataSummaryAdZoneAssocInactiveTargetReached($numberToDelete=100)
    {
        $tblInter       = $this->_getTablename('data_intermediate_ad');
        $tblAssoc       = $this->_getTablename('data_summary_ad_zone_assoc');
        $tblBanners     = $this->_getTablename('banners');
        $tblCampaigns   = $this->_getTablename('campaigns');

        $query = 'SELECT
                     daz.data_summary_ad_zone_assoc_id,
                     IF( (SUM( dia.impressions ) >= c.views)
                     OR  (SUM( dia.clicks ) >= c.clicks)
                     OR  (SUM( dia.conversions ) >= c.conversions), 1, 0) AS target_reached
                 FROM '.$tblAssoc.' daz
                 LEFT JOIN '.$tblInter.' AS dia ON dia.ad_id = daz.ad_id
                 LEFT JOIN '.$tblBanners.' AS b ON daz.ad_id = b.bannerid
                 LEFT JOIN '.$tblCampaigns.' AS c ON b.campaignid = c.campaignid
                 WHERE ( ( c.status <> '.OA_ENTITY_STATUS_RUNNING.') AND (c.priority > 0 ))
                 GROUP BY daz.data_summary_ad_zone_assoc_id, c.views, c.clicks, c.conversions
                 ORDER BY target_reached DESC';

        $aRows = $this->oDbh->queryAll($query);

        $numberToDelete = min(count($aRows),$numberToDelete);
        $aIds = array();
        $result = 0;
        foreach ($aRows as $k => $aRec)
        {
            if ( (count($aIds) == $numberToDelete) || ($aRec['target_reached'] == 0) )
            {
                break;
            }
            if ( $aRec['target_reached'] == 1)
            {
                $aIds[] = $aRec['data_summary_ad_zone_assoc_id'];
            }
        }
        if (!empty($aIds))
        {
            $doDSAZA = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
            $doDSAZA->whereAdd('data_summary_ad_zone_assoc_id IN ('.implode(',',$aIds).')');
            $result = $doDSAZA->delete(true, false);
        }
       return $result;
    }

    /**
     * logs the overhead of a table
     *
     * @param string $table : name of table without prefix
     */
    function _logTableOverhead($table)
    {
        $table = $this->_getTablenameUnquoted($table);
        $aResult = $this->oDbh->manager->getTableStatus($table);
        if (isset($aResult[0]['data_free']) && is_numeric($aResult[0]['data_free']))
        {
            $overhead = $aResult[0]['data_free'];
            OA::debug('Table '.$table.' overhead (number of allocated but unused bytes) = '.$overhead);
            if ($overhead > 0)
            {
                OA::debug('To reclaim diskspace, consider optimising this table');
            }
        }
        else
        {
            OA::debug('Table '.$table.' overhead (number of allocated but unused bytes) = unkown');
        }
    }
}

?>
