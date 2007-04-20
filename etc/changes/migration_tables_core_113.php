<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_113 extends Migration
{

    function Migration_113()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__agency';
		$this->aTaskList_constructive[] = 'afterAddTable__agency';


    }



	function beforeAddTable__agency()
	{
		return $this->beforeAddTable('agency');
	}

	function afterAddTable__agency()
	{
		return $this->afterAddTable('agency');
	}

}

?>