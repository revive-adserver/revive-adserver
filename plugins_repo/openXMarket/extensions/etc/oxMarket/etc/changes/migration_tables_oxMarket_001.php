<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_001 extends Migration
{

    function Migration_001()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__ext_market_assoc_data';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_market_assoc_data';
		$this->aTaskList_constructive[] = 'beforeAddTable__ext_market_campaign_pref';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_market_campaign_pref';
		$this->aTaskList_constructive[] = 'beforeAddTable__ext_market_setting';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_market_setting';
		$this->aTaskList_constructive[] = 'beforeAddTable__ext_market_web_stats';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_market_web_stats';
		$this->aTaskList_constructive[] = 'beforeAddTable__ext_market_website_pref';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_market_website_pref';


    }



	function beforeAddTable__ext_market_assoc_data()
	{
		return $this->beforeAddTable('ext_market_assoc_data');
	}

	function afterAddTable__ext_market_assoc_data()
	{
		return $this->afterAddTable('ext_market_assoc_data');
	}

	function beforeAddTable__ext_market_campaign_pref()
	{
		return $this->beforeAddTable('ext_market_campaign_pref');
	}

	function afterAddTable__ext_market_campaign_pref()
	{
		return $this->afterAddTable('ext_market_campaign_pref');
	}

	function beforeAddTable__ext_market_setting()
	{
		return $this->beforeAddTable('ext_market_setting');
	}

	function afterAddTable__ext_market_setting()
	{
		return $this->afterAddTable('ext_market_setting');
	}

	function beforeAddTable__ext_market_web_stats()
	{
		return $this->beforeAddTable('ext_market_web_stats');
	}

	function afterAddTable__ext_market_web_stats()
	{
		return $this->afterAddTable('ext_market_web_stats');
	}

	function beforeAddTable__ext_market_website_pref()
	{
		return $this->beforeAddTable('ext_market_website_pref');
	}

	function afterAddTable__ext_market_website_pref()
	{
		return $this->afterAddTable('ext_market_website_pref');
	}

}

?>