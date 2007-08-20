<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_530 extends Migration
{

    function Migration_530()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddIndex__application_variable__application_variable_pkey';
		$this->aTaskList_constructive[] = 'afterAddIndex__application_variable__application_variable_pkey';


    }



	function beforeAddIndex__application_variable__application_variable_pkey()
	{
		return $this->beforeAddIndex('application_variable', 'application_variable_pkey');
	}

	function afterAddIndex__application_variable__application_variable_pkey()
	{
		return $this->afterAddIndex('application_variable', 'application_variable_pkey');
	}

}

?>