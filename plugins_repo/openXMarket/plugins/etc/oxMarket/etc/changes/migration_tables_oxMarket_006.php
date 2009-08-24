<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_006 extends Migration
{

    function Migration_006()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__ext_market_zone_pref';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_market_zone_pref';


    }



	function beforeAddTable__ext_market_zone_pref()
	{
		return $this->beforeAddTable('ext_market_zone_pref');
	}

	function afterAddTable__ext_market_zone_pref()
	{
		return $this->afterAddTable('ext_market_zone_pref');
	}

}

?>