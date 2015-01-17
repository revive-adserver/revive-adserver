<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_608 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__banners__prepend';
		$this->aTaskList_constructive[] = 'afterAddField__banners__prepend';
		$this->aTaskList_destructive[] = 'beforeRemoveField__banners__appendtype';
		$this->aTaskList_destructive[] = 'afterRemoveField__banners__appendtype';


		$this->aObjectMap['banners']['prepend'] = array('fromTable'=>'banners', 'fromField'=>'prepend');
    }



	function beforeAddField__banners__prepend()
	{
		return $this->beforeAddField('banners', 'prepend');
	}

	function afterAddField__banners__prepend()
	{
		return $this->afterAddField('banners', 'prepend');
	}

	function beforeRemoveField__banners__appendtype()
	{
		return $this->beforeRemoveField('banners', 'appendtype');
	}

	function afterRemoveField__banners__appendtype()
	{
		return $this->afterRemoveField('banners', 'appendtype');
	}

}

?>