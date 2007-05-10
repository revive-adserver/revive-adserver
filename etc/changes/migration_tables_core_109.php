<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_109 extends Migration
{

    function Migration_109()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__application_variable';
		$this->aTaskList_constructive[] = 'afterAddTable__application_variable';


    }

	function beforeAddTable__application_variable()
	{
		return $this->beforeAddTable('application_variable');
	}

	function afterAddTable__application_variable()
	{
		return $this->afterAddTable('application_variable');
	}

}

?>