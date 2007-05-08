<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_130 extends Migration
{

    function Migration_130()
    {
        //$this->__construct();



    }

	function migrateData()
	{
	    // @todo - Must run only if compact_stats was NOT enabled
	    $prefix              = $this->getPrefix();
	    $tableAdViews        = $prefix . 'adviews';
	    $tableDataRawAdImp   = $prefix . 'data_raw_ad_impression';

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
	       INSERT INTO {$tableDataRawAdImp} (
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
	           {$tableAdViews}
	       WHERE
	           t_stamp >= ? AND
	           t_stamp < ?
	    ";

	    $oImpLog = $this->oDBH->prepare(
	       $sQuery,
	       array('timestamp', 'timestamp')
	    );

	    $rImp = $oImpLog->execute(
            array(
                $oStart->format('%Y-%m-%d %H:%M:%S'),
                $oEnd->format('%Y-%m-%d %H:%M:%S')
            )
        );
    }

}

?>