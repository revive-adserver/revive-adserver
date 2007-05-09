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

class StatMigration extends Migration
{
    function migrateData()
    {
        if ($this->statsCompacted()) {
            return $this->migrateCompactStats();
        }
        else {
            return $this->migrateImpressions() & $this->migrateClicks();
        }
    }
    
    function &_getPsInsertDataRaw($tableDataRaw)
    {
	    $sql = "
	       INSERT INTO $tableDataRaw (
	           ad_id,
	           zone_id,
	           date_time,
	           channel,
	           creative_id
	       ) VALUES (
	           ?,
	           ?,
	           ?,
	           ?,
	           0
	       )
	    ";
	    $psInsertDataRaw = $this->oDBH->prepare(
	       $sql, array('integer', 'integer', 'timestamp', 'text'));
	    return $psInsertDataRaw;
    }
    
    function migrateCompactStats()
    {
	    $prefix              = $this->getPrefix();
	    $tableAdStats        = $prefix . 'adstats';
	    $tableDataRawAdImp   = $prefix . 'data_raw_ad_impression';
	    $tableDataRawAdClick = $prefix . 'data_raw_ad_click';

	    $oStats = $this->oDBH->prepare(
	       "SELECT views, clicks, bannerid, zoneid, day, hour, source FROM {$tableAdStats} WHERE day = ?",
	       array('date'),
	       array('integer', 'integer', 'text', 'integer', 'text')
	    );
	    if (PEAR::isError($oStats)) {
	        $this->_logError($oStats);
	        return false;
	    }
	    $oImpLog = $this->_getPsInsertDataRaw($tableDataRawAdImp);
	    if (PEAR::isError($oImpLog)) {
	        $this->_logError($oImpLog);
	        return false;
	    }
	    $oClickLog = $this->_getPsInsertDataRaw($tableDataRawAdClick);
	    if (PEAR::isError($oClickLog)) {
	        $this->_logError($oClickLog);
	        return false;
	    }

	    $oEnd = new Date();
	    $oEnd->setHour(0);
	    $oEnd->setMinute(0);
	    $oEnd->setSecond(0);

	    $oSpan = new Date_Span('15,0,0,0');
	    $oDay = new Date($oEnd);
	    $oDay->subtractSpan($oSpan);

	    $oSpan = new Date_Span('1,0,0,0');

	    while (!$oDay->after($oEnd)) {
	        $oCurrent = new Date($oDay);
            $rStats = $oStats->execute(
                array($oCurrent->format('%Y-%m-%d %H:%M:%S'))
            );
            if (PEAR::isError($rStats)) {
                $this->_logError($rStats);
                return false;
            }
            
            while ($aStats = $rStats->fetchRow()) {
                if (PEAR::isError($aStats)) {
                    return $this->_logErrorAndReturnFalse($aStats);
                }
                $oCurrent->setHour($aStats['hour']);
                $sDateTime = $oCurrent->format('%Y-%m-%d %H:%M:%S');
                for ($v = 0; $v < $aStats['views']; $v++) {
                    $rImp = $oImpLog->execute(
                        array(
                            (int)$aStats['bannerid'],
                            (int)$aStats['zoneid'],
                            $sDateTime,
                            empty($aStats['source']) ? null : $aStats['source']
                        )
                    );
                    if (PEAR::isError($rImp)) {
                        return $this->_logErrorAndReturnFalse($rImp);
                    }
                }
                for ($c = 0; $c < $aStats['clicks']; $c++) {
                    $rClick = $oClickLog->execute(
                        array(
                            (int)$aStats['bannerid'],
                            (int)$aStats['zoneid'],
                            $sDateTime,
                            empty($aStats['source']) ? null : $aStats['source']
                        )
                    );
                    if (PEAR::isError($rClick)) {
                        return $this->_logErrorAndReturnFalse($rImp);
                    }
                }
            }

            $oDay->addSpan($oSpan);
	    }
	    return true;
    }
    
    
    function migrateImpressions()
    {
        return $this->_migrateDataRaw('adviews', 'data_raw_ad_impression');
    }
    
    
    function migrateClicks()
    {
        return $this->_migrateDataRaw('adclicks', 'data_raw_ad_click');
    }

    
    function _migrateDataRaw($tableSource, $tableDataRaw)
    {
	    $prefix              = $this->getPrefix();
	    $tableSource = $prefix . $tableSource;
	    $tableDataRaw = $prefix . $tableDataRaw;

	    $oEnd = new Date();
	    $oEnd->setHour(0);
	    $oEnd->setMinute(0);
	    $oEnd->setSecond(0);

	    $oSpan = new Date_Span('15,0,0,0');
	    $oStart = new Date($oEnd);
	    $oStart->subtractSpan($oSpan);

	    $oSpan = new Date_Span('1,0,0,0');
	    $oEnd->addSpan($oSpan);

	    $sQuery = "
	       INSERT INTO {$tableDataRaw} (
	           ad_id,
	           zone_id,
	           date_time,
	           channel,
	           creative_id,
	           ip_address,
	           host_name,
	           country
	       ) SELECT
	           bannerid,
	           zoneid,
	           t_stamp,
	           source,
	           0,
	           host,
	           host,
	           country
	       FROM
	           {$tableSource}
	       WHERE
	           t_stamp >= ? AND
	           t_stamp < ?
	    ";

	    $psDataRawLog = $this->oDBH->prepare(
	       $sQuery,
	       array('timestamp', 'timestamp')
	    );
	    if (PEAR::isError($psDataRawLog)) {
	        return $this->_logErrorAndReturnFalse($psDataRawLog);
	    }

	    $result = $psDataRawLog->execute(
            array(
                $oStart->format('%Y-%m-%d %H:%M:%S'),
                $oEnd->format('%Y-%m-%d %H:%M:%S')
            )
        );
	    if (PEAR::isError($result)) {
	        return $this->_logErrorAndReturnFalse($result);
	    }
        return true;
    }
    
    
    function statsCompacted()
    {
        $phpAdsNew = new OA_phpAdsNew();
        $aConfig = $phpAdsNew->_getPANConfig();
        return $aConfig['compact_stats'];
    }
}

?>