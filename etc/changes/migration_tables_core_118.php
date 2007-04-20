<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_118 extends Migration
{

    function Migration_118()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__campaigns_trackers';
		$this->aTaskList_constructive[] = 'afterAddTable__campaigns_trackers';
		$this->aTaskList_constructive[] = 'beforeAddTable__tracker_append';
		$this->aTaskList_constructive[] = 'afterAddTable__tracker_append';
		$this->aTaskList_constructive[] = 'beforeAddTable__trackers';
		$this->aTaskList_constructive[] = 'afterAddTable__trackers';
		$this->aTaskList_constructive[] = 'beforeAddTable__variable_publisher';
		$this->aTaskList_constructive[] = 'afterAddTable__variable_publisher';
		$this->aTaskList_constructive[] = 'beforeAddTable__variables';
		$this->aTaskList_constructive[] = 'afterAddTable__variables';


    }



	function beforeAddTable__campaigns_trackers()
	{
		return $this->beforeAddTable('campaigns_trackers');
	}

	function afterAddTable__campaigns_trackers()
	{
		return $this->afterAddTable('campaigns_trackers');
	}

	function beforeAddTable__tracker_append()
	{
		return $this->beforeAddTable('tracker_append');
	}

	function afterAddTable__tracker_append()
	{
		return $this->afterAddTable('tracker_append');
	}

	function beforeAddTable__trackers()
	{
		return $this->beforeAddTable('trackers');
	}

	function afterAddTable__trackers()
	{
		return $this->afterAddTable('trackers');
	}

	function beforeAddTable__variable_publisher()
	{
		return $this->beforeAddTable('variable_publisher');
	}

	function afterAddTable__variable_publisher()
	{
		return $this->afterAddTable('variable_publisher');
	}

	function beforeAddTable__variables()
	{
		return $this->beforeAddTable('variables');
	}

	function afterAddTable__variables()
	{
		return $this->afterAddTable('variables');
	}

}

?>