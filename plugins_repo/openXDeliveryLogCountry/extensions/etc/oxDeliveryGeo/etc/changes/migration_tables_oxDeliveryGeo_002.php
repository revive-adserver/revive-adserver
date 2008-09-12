<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_002 extends Migration
{

    function Migration_002()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__stats_country';
		$this->aTaskList_constructive[] = 'afterAddTable__stats_country';


    }



	function beforeAddTable__stats_country()
	{
		return $this->beforeAddTable('stats_country');
	}

	function afterAddTable__stats_country()
	{
		return $this->afterAddTable('stats_country');
	}

}

?>