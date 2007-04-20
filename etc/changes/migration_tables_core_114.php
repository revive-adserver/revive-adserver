<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_114 extends Migration
{

    function Migration_114()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__campaigns';
		$this->aTaskList_constructive[] = 'afterAddTable__campaigns';


    }



	function beforeAddTable__campaigns()
	{
		return $this->beforeAddTable('campaigns');
	}

	function afterAddTable__campaigns()
	{
		return $this->afterAddTable('campaigns');
	}

}

?>