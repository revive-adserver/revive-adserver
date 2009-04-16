<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_003 extends Migration
{

    function Migration_003()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__ext_market_assoc_data__api_key';
		$this->aTaskList_constructive[] = 'afterAddField__ext_market_assoc_data__api_key';


		$this->aObjectMap['ext_market_assoc_data']['api_key'] = array('fromTable'=>'ext_market_assoc_data', 'fromField'=>'api_key');
    }



	function beforeAddField__ext_market_assoc_data__api_key()
	{
		return $this->beforeAddField('ext_market_assoc_data', 'api_key');
	}

	function afterAddField__ext_market_assoc_data__api_key()
	{
		return $this->afterAddField('ext_market_assoc_data', 'api_key');
	}

}

?>