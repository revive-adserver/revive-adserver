<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_001 extends Migration
{

    function Migration_001()
    {
		$this->aTaskList_constructive[] = 'beforeAddTable__ext_thorium_account_mapping';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_thorium_account_mapping';
		$this->aTaskList_constructive[] = 'beforeAddTable__ext_thorium_ad_size';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_thorium_ad_size';
		$this->aTaskList_constructive[] = 'beforeAddTable__ext_thorium_payment_details';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_thorium_payment_details';
		$this->aTaskList_constructive[] = 'beforeAddTable__ext_thorium_publisher_reporting';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_thorium_publisher_reporting';
     }



	function beforeAddTable__ext_thorium_account_mapping()
	{
		return $this->beforeAddTable('ext_thorium_account_mapping');
	}

	function afterAddTable__ext_thorium_account_mapping()
	{
		return $this->afterAddTable('ext_thorium_account_mapping');
	}

	function beforeAddTable__ext_thorium_ad_size()
	{
		return $this->beforeAddTable('ext_thorium_ad_size');
	}

	function afterAddTable__ext_thorium_ad_size()
	{
		return $this->afterAddTable('ext_thorium_ad_size');
	}

	function beforeAddTable__ext_thorium_payment_details()
	{
		return $this->beforeAddTable('ext_thorium_payment_details');
	}

	function afterAddTable__ext_thorium_payment_details()
	{
		return $this->afterAddTable('ext_thorium_payment_details');
	}

	function beforeAddTable__ext_thorium_publisher_reporting()
	{
		return $this->beforeAddTable('ext_thorium_publisher_reporting');
	}

	function afterAddTable__ext_thorium_publisher_reporting()
	{
		return $this->afterAddTable('ext_thorium_publisher_reporting');
	}

}

?>