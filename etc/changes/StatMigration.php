<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/phpAdsNew.php');
require_once(MAX_PATH.'/lib/max/OperationInterval.php');
require_once(MAX_PATH.'/lib/max/Dal/db/db.inc.php');

class StatMigration extends Migration
{
    function migrateData()
    {
        if ($this->statsCompacted()) {
            return $this->migrateCompactStats();
        }
        else {
            return $this->migrateRawStats();
        }
    }


    function migrateCompactStats()
    {
	    $prefix              = $this->getPrefix();
	    $tableAdStats        = $prefix . 'adstats';
	    $tableDataIntermediateAd = $prefix . 'data_intermediate_ad';

	    $timestamp = date('Y-m-d H:i:s', time());

	    $this->_getOperationIntervalInfo($operationIntervalId, $operationInterval, $dateStart, $dateEnd);

	    $sql = "
	       INSERT INTO $tableDataIntermediateAd
	           (day,hour,ad_id,creative_id,zone_id,impressions,clicks,operation_interval, operation_interval_id, interval_start, interval_end, updated)
	           SELECT day, hour, bannerid, 0, zoneid, views, clicks, $operationInterval, $operationIntervalId, $dateStart, $dateEnd, '$timestamp'
	           FROM $tableAdStats";

	    return $this->migrateStats($sql);
    }


    function migrateRawStats()
    {
	    $prefix              = $this->getPrefix();
	    $tableAdViews        = $prefix . 'adviews';
	    $tableAdClicks        = $prefix . 'adclicks';
	    $tableDataIntermediateAd = $prefix . 'data_intermediate_ad';

	    $timestamp = date('Y-m-d H:i:s', time());

	    $this->_getOperationIntervalInfo($operationIntervalId, $operationInterval, $dateStart, $dateEnd);

	    $sql = "
	       INSERT INTO $tableDataIntermediateAd
	           (ad_id, zone_id, creative_id, day, hour, impressions, clicks, operation_interval, operation_interval_id, interval_start, interval_end, updated)
	           SELECT ad_id, zone_id, 0 creative_id, day, hour, sum(impressions) impressions, sum(clicks) clicks, $operationInterval, $operationIntervalId, $dateStart, $dateEnd, '$timestamp'
	           FROM
	               (SELECT bannerid ad_id, zoneid zone_id, date_format(t_stamp, '%Y-%m-%d') day, date_format(t_stamp, '%H') hour, count(*) impressions, 0 clicks
	               FROM $tableAdViews
	               GROUP BY bannerid, zoneid, date_format(t_stamp, '%Y-%m-%d'), date_format(t_stamp, '%H')
	               UNION ALL
	               SELECT bannerid ad_id, zoneid zone_id, date_format(t_stamp, '%Y-%m-%d') day, date_format(t_stamp, '%H') hour, 0 impressions, count(*) clicks
	               FROM $tableAdClicks
	               GROUP BY bannerid, zoneid, date_format(t_stamp, '%Y-%m-%d'), date_format(t_stamp, '%H'))
	                   united
	               GROUP BY ad_id, zone_id, day, hour";

	    return $this->migrateStats($sql);
    }


    function migrateStats($sql)
    {
	    $prefix              = $this->getPrefix();
	    $tableDataIntermediateAd = $prefix . 'data_intermediate_ad';
	    $tableDataSummaryAdHourly = $prefix . 'data_summary_ad_hourly';

	    $result = $this->oDBH->exec($sql);

	    if (PEAR::isError($result)) {
	        return $this->_logErrorAndReturnFalse($result);
	    }

	    $sql = "
	       INSERT INTO $tableDataSummaryAdHourly
	           (ad_id, zone_id, creative_id, day, hour, impressions, clicks, updated)
    	       SELECT ad_id, zone_id, creative_id, day, hour, impressions, clicks, updated
    	       FROM $tableDataIntermediateAd";
	    $result = $this->oDBH->exec($sql);

	    if (PEAR::isError($result)) {
	        return $this->_logErrorAndReturnFalse($result);
	    }

	    return true;
    }

    function _getOperationIntervalInfo(&$operationIntervalId, &$operationInterval, &$dateStart, &$dateEnd)
    {
	    $date = new Date();
	    $operationInterval = new MAX_OperationInterval();
	    $operationIntervalId =
	       $operationInterval->convertDateToOperationIntervalID($date);
	    $operationInterval = MAX_OperationInterval::getOperationInterval();
	    $aOperationIntervalDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($date);
	    $dateStart = DBC::makeLiteral($aOperationIntervalDates['start']->format(TIMESTAMP_FORMAT));
	    $dateEnd = DBC::makeLiteral($aOperationIntervalDates['end']->format(TIMESTAMP_FORMAT));
    }


    function statsCompacted()
    {
        $phpAdsNew = new OA_phpAdsNew();
        $aConfig = $phpAdsNew->_getPANConfig();
        return $aConfig['compact_stats'];
    }
}

?>