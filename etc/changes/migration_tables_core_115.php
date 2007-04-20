<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_115 extends Migration
{

    function Migration_115()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__acls_channel';
		$this->aTaskList_constructive[] = 'afterAddTable__acls_channel';
		$this->aTaskList_constructive[] = 'beforeAddTable__channel';
		$this->aTaskList_constructive[] = 'afterAddTable__channel';


    }



	function beforeAddTable__acls_channel()
	{
		return $this->beforeAddTable('acls_channel');
	}

	function afterAddTable__acls_channel()
	{
		return $this->afterAddTable('acls_channel');
	}

	function beforeAddTable__channel()
	{
		return $this->beforeAddTable('channel');
	}

	function afterAddTable__channel()
	{
		return $this->afterAddTable('channel');
	}

}

?>