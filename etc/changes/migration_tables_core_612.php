<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_612 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__type';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__type';
		$this->aTaskList_constructive[] = 'beforeAddField__clients__type';
		$this->aTaskList_constructive[] = 'afterAddField__clients__type';
		$this->aTaskList_constructive[] = 'beforeAddIndex__clients__clients_agencyid_type';
		$this->aTaskList_constructive[] = 'afterAddIndex__clients__clients_agencyid_type';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__clients__clients_agencyid';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__clients__clients_agencyid';


		$this->aObjectMap['campaigns']['type'] = array('fromTable'=>'campaigns', 'fromField'=>'type');
		$this->aObjectMap['clients']['type'] = array('fromTable'=>'clients', 'fromField'=>'type');
    }



	function beforeAddField__campaigns__type()
	{
		return $this->beforeAddField('campaigns', 'type');
	}

	function afterAddField__campaigns__type()
	{
		return $this->afterAddField('campaigns', 'type');
	}

	function beforeAddField__clients__type()
	{
		return $this->beforeAddField('clients', 'type');
	}

	function afterAddField__clients__type()
	{
		return $this->afterAddField('clients', 'type');
	}

	function beforeAddIndex__clients__clients_agencyid_type()
	{
		return $this->beforeAddIndex('clients', 'clients_agencyid_type');
	}

	function afterAddIndex__clients__clients_agencyid_type()
	{
		return $this->afterAddIndex('clients', 'clients_agencyid_type');
	}

	function beforeRemoveIndex__clients__clients_agencyid()
	{
		return $this->beforeRemoveIndex('clients', 'clients_agencyid');
	}

	function afterRemoveIndex__clients__clients_agencyid()
	{
		return $this->afterRemoveIndex('clients', 'clients_agencyid');
	}

}

?>