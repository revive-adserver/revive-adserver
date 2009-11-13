<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_006 extends Migration
{

    function Migration_006()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__ext_market_advertiser';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_market_advertiser';
		$this->aTaskList_constructive[] = 'beforeAddTable__ext_market_stats';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_market_stats';


    }



	function beforeAddTable__ext_market_advertiser()
	{
		return $this->beforeAddTable('ext_market_advertiser');
	}

	function afterAddTable__ext_market_advertiser()
	{
		return $this->afterAddTable('ext_market_advertiser');
	}

	function beforeAddTable__ext_market_stats()
	{
		return $this->beforeAddTable('ext_market_stats');
	}

	function afterAddTable__ext_market_stats()
	{
		return $this->afterAddTable('ext_market_stats');
	}

}

?>