<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_129 extends Migration
{

    function Migration_129()
    {
        //$this->__construct();



    }


	function migrateData()
	{
	    // @todo - Must run only if compact_stats was enabled
	    $prefix              = $this->getPrefix();
	    $tableAdStats        = $prefix . 'adstats';
	    $tableDataRawAdImp   = $prefix . 'data_raw_ad_impression';
	    $tableDataRawAdClick = $prefix . 'data_raw_ad_click';

	    $sQuery = "
	       INSERT INTO %s (
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

	    $oStats = $this->oDBH->prepare(
	       "SELECT views, clicks, bannerid, zoneid, day, hour, source FROM {$tableAdStats} WHERE day = ?",
	       array('date'),
	       array('integer', 'integer', 'text', 'integer', 'text')
	    );
	    $oImpLog = $this->oDBH->prepare(
	       sprintf($sQuery, $tableDataRawAdImp),
	       array('integer', 'integer', 'timestamp', 'text')
	    );
	    $oClickLog = $this->oDBH->prepare(
	       sprintf($sQuery, $tableDataRawAdClick),
	       array('integer', 'integer', 'timestamp', 'text')
	    );

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
            while ($aStats = $rStats->fetchRow()) {
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
                }
            }

            $oDay->addSpan($oSpan);
	    }
    }

}

?>