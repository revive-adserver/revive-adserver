<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_004 extends Migration
{

    function Migration_004()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__ext_market_plugin_variable';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_market_plugin_variable';


    }



	function beforeAddTable__ext_market_plugin_variable()
	{
		return $this->beforeAddTable('ext_market_plugin_variable');
	}

	function afterAddTable__ext_market_plugin_variable()
	{
		return $this->afterAddTable('ext_market_plugin_variable');
	}

}

?>