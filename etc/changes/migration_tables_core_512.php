<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_512 extends Migration
{

    function Migration_512()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__banners__parameters';
		$this->aTaskList_constructive[] = 'afterAddField__banners__parameters';


		$this->aObjectMap['banners']['parameters'] = array('fromTable'=>'banners', 'fromField'=>'parameters');
    }



	function beforeAddField__banners__parameters()
	{
		return $this->beforeAddField('banners', 'parameters');
	}

	function afterAddField__banners__parameters()
	{
		return $this->afterAddField('banners', 'parameters');
	}

}

?>