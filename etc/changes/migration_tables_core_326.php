<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_326 extends Migration
{

    function Migration_326()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__target_impression';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__target_impression';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__target_click';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__target_click';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__target_conversion';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__target_conversion';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__companion';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__companion';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__comments';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__comments';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__revenue';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__revenue';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__revenue_type';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__revenue_type';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__updated';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__updated';


		$this->aObjectMap['campaigns']['target_impression'] = array('fromTable'=>'campaigns', 'fromField'=>'target_impression');
		$this->aObjectMap['campaigns']['target_click'] = array('fromTable'=>'campaigns', 'fromField'=>'target_click');
		$this->aObjectMap['campaigns']['target_conversion'] = array('fromTable'=>'campaigns', 'fromField'=>'target_conversion');
		$this->aObjectMap['campaigns']['companion'] = array('fromTable'=>'campaigns', 'fromField'=>'companion');
		$this->aObjectMap['campaigns']['comments'] = array('fromTable'=>'campaigns', 'fromField'=>'comments');
		$this->aObjectMap['campaigns']['revenue'] = array('fromTable'=>'campaigns', 'fromField'=>'revenue');
		$this->aObjectMap['campaigns']['revenue_type'] = array('fromTable'=>'campaigns', 'fromField'=>'revenue_type');
		$this->aObjectMap['campaigns']['updated'] = array('fromTable'=>'campaigns', 'fromField'=>'updated');
    }



	function beforeAddField__campaigns__target_impression()
	{
		return $this->beforeAddField('campaigns', 'target_impression');
	}

	function afterAddField__campaigns__target_impression()
	{
		return $this->afterAddField('campaigns', 'target_impression');
	}

	function beforeAddField__campaigns__target_click()
	{
		return $this->beforeAddField('campaigns', 'target_click');
	}

	function afterAddField__campaigns__target_click()
	{
		return $this->afterAddField('campaigns', 'target_click');
	}

	function beforeAddField__campaigns__target_conversion()
	{
		return $this->beforeAddField('campaigns', 'target_conversion');
	}

	function afterAddField__campaigns__target_conversion()
	{
		return $this->afterAddField('campaigns', 'target_conversion');
	}

	function beforeAddField__campaigns__companion()
	{
		return $this->beforeAddField('campaigns', 'companion');
	}

	function afterAddField__campaigns__companion()
	{
		return $this->afterAddField('campaigns', 'companion');
	}

	function beforeAddField__campaigns__comments()
	{
		return $this->beforeAddField('campaigns', 'comments');
	}

	function afterAddField__campaigns__comments()
	{
		return $this->afterAddField('campaigns', 'comments');
	}

	function beforeAddField__campaigns__revenue()
	{
		return $this->beforeAddField('campaigns', 'revenue');
	}

	function afterAddField__campaigns__revenue()
	{
		return $this->afterAddField('campaigns', 'revenue');
	}

	function beforeAddField__campaigns__revenue_type()
	{
		return $this->beforeAddField('campaigns', 'revenue_type');
	}

	function afterAddField__campaigns__revenue_type()
	{
		return $this->afterAddField('campaigns', 'revenue_type');
	}

	function beforeAddField__campaigns__updated()
	{
		return $this->beforeAddField('campaigns', 'updated');
	}

	function afterAddField__campaigns__updated()
	{
		return $this->afterAddField('campaigns', 'updated');
	}

}

?>