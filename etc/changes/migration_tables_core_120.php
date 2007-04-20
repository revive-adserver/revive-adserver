<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_120 extends Migration
{

    function Migration_120()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__affiliates_extra';
		$this->aTaskList_constructive[] = 'afterAddTable__affiliates_extra';
		$this->aTaskList_constructive[] = 'beforeAddTable__application_variable';
		$this->aTaskList_constructive[] = 'afterAddTable__application_variable';
		$this->aTaskList_constructive[] = 'beforeAddTable__password_recovery';
		$this->aTaskList_constructive[] = 'afterAddTable__password_recovery';


    }



	function beforeAddTable__affiliates_extra()
	{
		return $this->beforeAddTable('affiliates_extra');
	}

	function afterAddTable__affiliates_extra()
	{
		return $this->afterAddTable('affiliates_extra');
	}

	function beforeAddTable__application_variable()
	{
		return $this->beforeAddTable('application_variable');
	}

	function afterAddTable__application_variable()
	{
		return $this->afterAddTable('application_variable');
	}

	function beforeAddTable__password_recovery()
	{
		return $this->beforeAddTable('password_recovery');
	}

	function afterAddTable__password_recovery()
	{
		return $this->afterAddTable('password_recovery');
	}

}

?>