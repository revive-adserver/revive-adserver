<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_001 extends Migration
{

    function Migration_001()
    {
		$this->aTaskList_constructive[] = 'beforeAddTable__ext_thorium_campaign_pref';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_thorium_campaign_pref';
		$this->aTaskList_constructive[] = 'beforeAddTable__ext_thorium_website_pref';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_thorium_website_pref';
    }


	function beforeAddTable__ext_thorium_campaign_pref()
	{
		return $this->beforeAddTable('ext_thorium_campaign_pref');
	}

	function afterAddTable__ext_thorium_campaign_pref()
	{
		return $this->afterAddTable('ext_thorium_campaign_pref');
	}

	function beforeAddTable__ext_thorium_website_pref()
	{
		return $this->beforeAddTable('ext_thorium_website_pref');
	}

	function afterAddTable__ext_thorium_website_pref()
	{
		return $this->afterAddTable('ext_thorium_website_pref');
	}
}

?>