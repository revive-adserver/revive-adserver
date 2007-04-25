<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_122 extends Migration
{

    function Migration_122()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__clients__agencyid';
		$this->aTaskList_constructive[] = 'afterAddField__clients__agencyid';
		$this->aTaskList_constructive[] = 'beforeAddField__clients__comments';
		$this->aTaskList_constructive[] = 'afterAddField__clients__comments';
		$this->aTaskList_constructive[] = 'beforeAddField__clients__updated';
		$this->aTaskList_constructive[] = 'afterAddField__clients__updated';
		$this->aTaskList_destructive[] = 'beforeRemoveField__clients__views';
		$this->aTaskList_destructive[] = 'afterRemoveField__clients__views';
		$this->aTaskList_destructive[] = 'beforeRemoveField__clients__clicks';
		$this->aTaskList_destructive[] = 'afterRemoveField__clients__clicks';
		$this->aTaskList_destructive[] = 'beforeRemoveField__clients__expire';
		$this->aTaskList_destructive[] = 'afterRemoveField__clients__expire';
		$this->aTaskList_destructive[] = 'beforeRemoveField__clients__activate';
		$this->aTaskList_destructive[] = 'afterRemoveField__clients__activate';
		$this->aTaskList_destructive[] = 'beforeRemoveField__clients__active';
		$this->aTaskList_destructive[] = 'afterRemoveField__clients__active';
		$this->aTaskList_destructive[] = 'beforeRemoveField__clients__weight';
		$this->aTaskList_destructive[] = 'afterRemoveField__clients__weight';
		$this->aTaskList_destructive[] = 'beforeRemoveField__clients__target';
		$this->aTaskList_destructive[] = 'afterRemoveField__clients__target';
		$this->aTaskList_destructive[] = 'beforeRemoveField__clients__parent';
		$this->aTaskList_destructive[] = 'afterRemoveField__clients__parent';


		$this->aObjectMap['clients']['agencyid'] = array('fromTable'=>'clients', 'fromField'=>'agencyid');
		$this->aObjectMap['clients']['comments'] = array('fromTable'=>'clients', 'fromField'=>'comments');
		$this->aObjectMap['clients']['updated'] = array('fromTable'=>'clients', 'fromField'=>'updated');
    }



	function beforeAddField__clients__agencyid()
	{
		return $this->beforeAddField('clients', 'agencyid');
	}

	function afterAddField__clients__agencyid()
	{
		return $this->afterAddField('clients', 'agencyid');
	}

	function beforeAddField__clients__comments()
	{
		return $this->beforeAddField('clients', 'comments');
	}

	function afterAddField__clients__comments()
	{
		return $this->afterAddField('clients', 'comments');
	}

	function beforeAddField__clients__updated()
	{
		return $this->beforeAddField('clients', 'updated');
	}

	function afterAddField__clients__updated()
	{
		return $this->afterAddField('clients', 'updated');
	}

	function beforeRemoveField__clients__views()
	{
		return $this->beforeRemoveField('clients', 'views');
	}

	function afterRemoveField__clients__views()
	{
		return $this->afterRemoveField('clients', 'views');
	}

	function beforeRemoveField__clients__clicks()
	{
		return $this->beforeRemoveField('clients', 'clicks');
	}

	function afterRemoveField__clients__clicks()
	{
		return $this->afterRemoveField('clients', 'clicks');
	}

	function beforeRemoveField__clients__expire()
	{
		return $this->beforeRemoveField('clients', 'expire');
	}

	function afterRemoveField__clients__expire()
	{
		return $this->afterRemoveField('clients', 'expire');
	}

	function beforeRemoveField__clients__activate()
	{
		return $this->beforeRemoveField('clients', 'activate');
	}

	function afterRemoveField__clients__activate()
	{
		return $this->afterRemoveField('clients', 'activate');
	}

	function beforeRemoveField__clients__active()
	{
		return $this->beforeRemoveField('clients', 'active');
	}

	function afterRemoveField__clients__active()
	{
		return $this->afterRemoveField('clients', 'active');
	}

	function beforeRemoveField__clients__weight()
	{
		return $this->beforeRemoveField('clients', 'weight');
	}

	function afterRemoveField__clients__weight()
	{
		return $this->afterRemoveField('clients', 'weight');
	}

	function beforeRemoveField__clients__target()
	{
		return $this->beforeRemoveField('clients', 'target');
	}

	function afterRemoveField__clients__target()
	{
		return $this->afterRemoveField('clients', 'target');
	}

	function beforeRemoveField__clients__parent()
	{
		return $this->beforeRemoveField('clients', 'parent');
	}

	function afterRemoveField__clients__parent()
	{
		return $this->afterRemoveField('clients', 'parent');
	}

}

?>