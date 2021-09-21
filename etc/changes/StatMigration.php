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

require_once MAX_PATH . '/lib/OA/Upgrade/Migration.php';
require_once MAX_PATH . '/lib/OA/Upgrade/phpAdsNew.php';

require_once LIB_PATH . '/OperationInterval.php';
require_once OX_PATH . '/lib/wact/db/db.inc.php';

class StatMigration extends Migration
{
    // 0.1 didn't have an option for compact stats, it was "always on"
    // Use this property to instruct the stats migration to do the right thing.
    public $compactStats = false;

    public function __construct()
    {
    }


    public function migrateData()
    {
        if (!$this->init(OA_DB::singleton())) {
            return false;
        }
        if ($this->statsCompacted()) {
            return $this->migrateCompactStats();
        } else {
            return $this->migrateRawStats();
        }
    }

    public function migrateCompactStats()
    {
        $tableAdStats = $this->_modifyTableName('adstats');
        $tableDataIntermediateAd = $this->_modifyTableName('data_intermediate_ad');

        $timestamp = date('Y-m-d H:i:s', time());

        $this->_getOperationIntervalInfo($operationIntervalId, $operationInterval, $dateStart, $dateEnd);

        $sql = "
	       INSERT INTO $tableDataIntermediateAd
	           (day,hour,ad_id,creative_id,zone_id,impressions,clicks,operation_interval, operation_interval_id, interval_start, interval_end, updated)
	           SELECT day, hour, bannerid, 0, zoneid, views, clicks, $operationInterval, $operationIntervalId, $dateStart, $dateEnd, '$timestamp'
	           FROM $tableAdStats";

        return $this->migrateStats($sql);
    }


    public function migrateRawStats()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        $tableAdViews = $this->_modifyTableName('adviews');
        $tableAdClicks = $this->_modifyTableName('adclicks');
        $tableDataIntermediateAd = $this->_modifyTableName('data_intermediate_ad');

        $timestamp = date('Y-m-d H:i:s', time());

        $this->_getOperationIntervalInfo($operationIntervalId, $operationInterval, $dateStart, $dateEnd);

        $tableTmpStatistics = 'tmp_statistics';

        // The temporary table doesn't get deleted on purpose -- it would obscure the code as
        // it does exists now.

        if ($this->oDBH->dbsyntax == 'mysql' || $this->oDBH->dbsyntax == 'mysqli') {
            $tmpTableInformation = "ENGINE={$aConf['table']['type']}";
            $tmpCastDate = '';
            $tmpCastInt = '';
        } else {
            // pgsql
            $tmpTableInformation = "AS";
            $tmpCastDate = '::date';
            $tmpCastInt = '::integer';
        }

        $sql = "
            CREATE TEMPORARY TABLE $tableTmpStatistics
                $tmpTableInformation
            SELECT bannerid AS ad_id, zoneid AS zone_id, date_format(t_stamp, '%Y-%m-%d')$tmpCastDate AS day, date_format(t_stamp, '%H')$tmpCastInt AS hour, count(*) AS impressions, 0 AS clicks
                FROM $tableAdViews
                GROUP BY bannerid, zoneid, date_format(t_stamp, '%Y-%m-%d'), date_format(t_stamp, '%H')
            UNION ALL
            SELECT bannerid AS ad_id, zoneid AS zone_id, date_format(t_stamp, '%Y-%m-%d')$tmpCastDate AS day, date_format(t_stamp, '%H')$tmpCastInt AS hour, 0 AS impressions, count(*) AS clicks
                FROM $tableAdClicks
                GROUP BY bannerid, zoneid, date_format(t_stamp, '%Y-%m-%d'), date_format(t_stamp, '%H')
        ";

        $this->_log('Starting creating temporary table for adclicks data migration');

        $result = $this->oDBH->exec($sql);

        if (PEAR::isError($result)) {
            return $this->_logErrorAndReturnFalse('Error migrating raw stats: ' . $result->getUserInfo());
        }
        $this->_log('Completed creating temporary table for adclicks data migration');

        $sql = "
            INSERT INTO $tableDataIntermediateAd
            (ad_id, zone_id, creative_id, day, hour, impressions, clicks, operation_interval, operation_interval_id, interval_start, interval_end, updated)
            SELECT ad_id, zone_id, 0, day, hour, sum(impressions), sum(clicks), $operationInterval, $operationIntervalId, $dateStart, $dateEnd, '$timestamp'
            FROM $tableTmpStatistics
                GROUP BY ad_id, zone_id, day, hour
        ";

        return $this->migrateStats($sql);
    }


    public function migrateStats($sql)
    {
        $this->_log('Starting migration of adstats data into data_intermediate_ad table');
        $tableDataIntermediateAd = $this->_modifyTableName('data_intermediate_ad');
        $tableDataSummaryAdHourly = $this->_modifyTableName('data_summary_ad_hourly');

        $result = $this->oDBH->exec($sql);

        if (PEAR::isError($result)) {
            return $this->_logErrorAndReturnFalse('Error migrating raw stats: ' . $result->getUserInfo());
        }
        $this->_log('Successfully migrated adstats data into data_intermediate table');

        $this->_log('Starting migration of adstats data into data_summary_ad_hourly table');
        $sql = "
	       INSERT INTO $tableDataSummaryAdHourly
	           (ad_id, zone_id, creative_id, day, hour, impressions, clicks, updated)
    	       SELECT ad_id, zone_id, creative_id, day, hour, impressions, clicks, updated
    	       FROM $tableDataIntermediateAd";
        $result = $this->oDBH->exec($sql);

        if (PEAR::isError($result)) {
            return $this->_logErrorAndReturnFalse('Error migrating stats: ' . $result->getUserInfo());
        }
        $this->_log('Successfully migrated adstats data into data_summary_ad_hourly table');

        return true;
    }

    public function _getOperationIntervalInfo(&$operationIntervalId, &$operationInterval, &$dateStart, &$dateEnd)
    {
        $date = new Date();
        $operationInterval = new OX_OperationInterval();
        $operationIntervalId = $operationInterval->convertDateToOperationIntervalID($date);
        $operationInterval = OX_OperationInterval::getOperationInterval();
        $aOperationIntervalDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($date);
        $dateStart = DBC::makeLiteral($aOperationIntervalDates['start']->format(TIMESTAMP_FORMAT));
        $dateEnd = DBC::makeLiteral($aOperationIntervalDates['end']->format(TIMESTAMP_FORMAT));
    }

    public function statsCompacted()
    {
        $phpAdsNew = new OA_phpAdsNew();
        $aConfig = $phpAdsNew->_getPANConfig();
        return ($this->compactStats || $aConfig['compact_stats']);
    }

    public function _modifyTableName($table)
    {
        return $this->_getQuotedTableName($table);
    }

    public function correctCampaignTargets()
    {
        $prefix = $this->getPrefix();

        $tblBanners = $this->_modifyTableName('banners');
        $tblCampaigns = $this->_modifyTableName('campaigns');
        $tblSummary = $this->_modifyTableName('data_summary_ad_hourly');

        // We need to add delivered stats to the "Booked" amount to correctly port campaign targets from 2.0
        $statsSQL = "
            SELECT
                c.campaignid,
                SUM(dsah.impressions) AS sum_views,
                SUM(dsah.clicks) AS sum_clicks,
                SUM(dsah.conversions) AS sum_conversions
            FROM
                {$tblBanners} AS b,
                {$tblCampaigns} AS c,
                {$tblSummary} AS dsah
            WHERE
                b.bannerid=dsah.ad_id
              AND c.campaignid=b.campaignid
            GROUP BY
                c.campaignid";
        $rStats = $this->oDBH->query($statsSQL);
        if (PEAR::isError($rStats)) {
            return $this->_logErrorAndReturnFalse('Error getting stats during migration 122: ' . $rStats->getUserInfo());
        }

        $stats = [];
        while ($row = $rStats->fetchRow()) {
            if (PEAR::isError($row)) {
                return $this->_logErrorAndReturnFalse('Error getting stats data during migration 127: ' . $rStats->getUserInfo());
            }
            $stats[$row['campaignid']] = $row;
        }

        $highCampaignsSQL = "
            SELECT
                campaignid AS campaignid,
                views AS views,
                clicks AS clicks,
                conversions AS conversions
            FROM
                {$tblCampaigns}
            WHERE
                views >= 0
              OR clicks >= 0
              OR conversions >= 0
        ";

        $rsCampaigns = $this->oDBH->query($highCampaignsSQL);
        if (PEAR::isError($rsCampaigns)) {
            return $this->_logErrorAndReturnFalse('Error campaigns with targets in migration 122: ' . $rsCampaigns->getUserInfo());
        }
        while ($rowCampaign = $rsCampaigns->fetchRow()) {
            if (PEAR::isError($rsCampaign)) {
                return $this->_logErrorAndReturnFalse('Error getting stats data during migration 127: ' . $rsCampaigns->getUserInfo());
            }
            if (!empty($stats[$rowCampaign['campaignid']]['sum_views']) || !empty($stats[$rowCampaign['campaignid']]['sum_clicks']) || !empty($stats[$rowCampaign['campaignid']]['sum_conversions'])) {
                $result = $this->oDBH->exec("
                    UPDATE
                        {$tblCampaigns}
                    SET
                        views = IF(views >= 0, views+{$stats[$rowCampaign['campaignid']]['sum_views']}, views),
                        clicks = IF(clicks >= 0, clicks+{$stats[$rowCampaign['campaignid']]['sum_clicks']}, clicks),
                        conversions = IF(conversions > 0, conversions+{$stats[$rowCampaign['campaignid']]['sum_conversions']}, conversions)
                    WHERE
                        campaignid = {$rowCampaign['campaignid']}
                ");
                if (PEAR::isError($result)) {
                    return $this->_logErrorAndReturnFalse('Error updating campaigns table: ' . $result->getUserInfo());
                }
            }
        }
        return true;
    }
}
