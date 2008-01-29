<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_539 extends Migration
{

    function Migration_539()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__banners__statustext';
		$this->aTaskList_constructive[] = 'afterAddField__banners__statustext';
		$this->aTaskList_destructive[] = 'beforeRemoveField__banners__status';
		$this->aTaskList_destructive[] = 'afterRemoveField__banners__status';


		$this->aObjectMap['banners']['statustext'] = array('fromTable'=>'banners', 'fromField'=>'status');
    }



	function beforeAddField__banners__statustext()
	{
		return $this->beforeAddField('banners', 'statustext');
	}

	function afterAddField__banners__statustext()
	{
		return $this->afterAddField('banners', 'statustext');
	}

	function beforeRemoveField__banners__status()
	{
		return $this->beforeRemoveField('banners', 'status');
	}

	function afterRemoveField__banners__status()
	{
		return $this->afterRemoveField('banners', 'status');
	}

}

?>