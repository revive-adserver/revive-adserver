<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_112 extends Migration
{

    function Migration_112()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__plugins_channel_delivery_assoc';
		$this->aTaskList_constructive[] = 'afterAddTable__plugins_channel_delivery_assoc';
		$this->aTaskList_constructive[] = 'beforeAddTable__plugins_channel_delivery_domains';
		$this->aTaskList_constructive[] = 'afterAddTable__plugins_channel_delivery_domains';
		$this->aTaskList_constructive[] = 'beforeAddTable__plugins_channel_delivery_rules';
		$this->aTaskList_constructive[] = 'afterAddTable__plugins_channel_delivery_rules';


    }



	function beforeAddTable__plugins_channel_delivery_assoc()
	{
		return $this->beforeAddTable('plugins_channel_delivery_assoc');
	}

	function afterAddTable__plugins_channel_delivery_assoc()
	{
		return $this->afterAddTable('plugins_channel_delivery_assoc');
	}

	function beforeAddTable__plugins_channel_delivery_domains()
	{
		return $this->beforeAddTable('plugins_channel_delivery_domains');
	}

	function afterAddTable__plugins_channel_delivery_domains()
	{
		return $this->afterAddTable('plugins_channel_delivery_domains');
	}

	function beforeAddTable__plugins_channel_delivery_rules()
	{
		return $this->beforeAddTable('plugins_channel_delivery_rules');
	}

	function afterAddTable__plugins_channel_delivery_rules()
	{
		return $this->afterAddTable('plugins_channel_delivery_rules');
	}

}

?>