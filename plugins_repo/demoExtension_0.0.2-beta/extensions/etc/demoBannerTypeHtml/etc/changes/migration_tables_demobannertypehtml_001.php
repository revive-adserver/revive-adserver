<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_001 extends Migration
{

    function Migration_001()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__banners_demo';
		$this->aTaskList_constructive[] = 'afterAddTable__banners_demo';


    }



	function beforeAddTable__banners_demo()
	{
		return $this->beforeAddTable('banners_demo');
	}

	function afterAddTable__banners_demo()
	{
		return $this->afterAddTable('banners_demo');
	}

}

?>