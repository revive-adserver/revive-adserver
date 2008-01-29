<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_537 extends Migration
{

    function Migration_537()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__audit';
		$this->aTaskList_constructive[] = 'afterAddTable__audit';


    }



	function beforeAddTable__audit()
	{
		return $this->beforeAddTable('audit');
	}

	function afterAddTable__audit()
	{
		return $this->afterAddTable('audit');
	}

}

?>