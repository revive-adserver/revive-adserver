<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_002 extends Migration
{

    function Migration_002()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__ext_market_general_pref';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_market_general_pref';


    }



	function beforeAddTable__ext_market_general_pref()
	{
		return $this->beforeAddTable('ext_market_general_pref');
	}

	function afterAddTable__ext_market_general_pref()
	{
		return $this->afterAddTable('ext_market_general_pref');
	}

}

?>