<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_543 extends Migration
{

    function Migration_543()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__accounts';
		$this->aTaskList_constructive[] = 'afterAddTable__accounts';
		$this->aTaskList_constructive[] = 'beforeAddTable__gacl_acl';
		$this->aTaskList_constructive[] = 'afterAddTable__gacl_acl';
		$this->aTaskList_constructive[] = 'beforeAddTable__gacl_acl_sections';
		$this->aTaskList_constructive[] = 'afterAddTable__gacl_acl_sections';
		$this->aTaskList_constructive[] = 'beforeAddTable__gacl_aco';
		$this->aTaskList_constructive[] = 'afterAddTable__gacl_aco';
		$this->aTaskList_constructive[] = 'beforeAddTable__gacl_aco_map';
		$this->aTaskList_constructive[] = 'afterAddTable__gacl_aco_map';
		$this->aTaskList_constructive[] = 'beforeAddTable__gacl_aco_sections';
		$this->aTaskList_constructive[] = 'afterAddTable__gacl_aco_sections';
		$this->aTaskList_constructive[] = 'beforeAddTable__gacl_aro';
		$this->aTaskList_constructive[] = 'afterAddTable__gacl_aro';
		$this->aTaskList_constructive[] = 'beforeAddTable__gacl_aro_groups';
		$this->aTaskList_constructive[] = 'afterAddTable__gacl_aro_groups';
		$this->aTaskList_constructive[] = 'beforeAddTable__gacl_aro_groups_map';
		$this->aTaskList_constructive[] = 'afterAddTable__gacl_aro_groups_map';
		$this->aTaskList_constructive[] = 'beforeAddTable__gacl_aro_map';
		$this->aTaskList_constructive[] = 'afterAddTable__gacl_aro_map';
		$this->aTaskList_constructive[] = 'beforeAddTable__gacl_aro_sections';
		$this->aTaskList_constructive[] = 'afterAddTable__gacl_aro_sections';
		$this->aTaskList_constructive[] = 'beforeAddTable__gacl_axo';
		$this->aTaskList_constructive[] = 'afterAddTable__gacl_axo';
		$this->aTaskList_constructive[] = 'beforeAddTable__gacl_axo_groups';
		$this->aTaskList_constructive[] = 'afterAddTable__gacl_axo_groups';
		$this->aTaskList_constructive[] = 'beforeAddTable__gacl_axo_groups_map';
		$this->aTaskList_constructive[] = 'afterAddTable__gacl_axo_groups_map';
		$this->aTaskList_constructive[] = 'beforeAddTable__gacl_axo_map';
		$this->aTaskList_constructive[] = 'afterAddTable__gacl_axo_map';
		$this->aTaskList_constructive[] = 'beforeAddTable__gacl_axo_sections';
		$this->aTaskList_constructive[] = 'afterAddTable__gacl_axo_sections';
		$this->aTaskList_constructive[] = 'beforeAddTable__gacl_groups_aro_map';
		$this->aTaskList_constructive[] = 'afterAddTable__gacl_groups_aro_map';
		$this->aTaskList_constructive[] = 'beforeAddTable__gacl_groups_axo_map';
		$this->aTaskList_constructive[] = 'afterAddTable__gacl_groups_axo_map';
		$this->aTaskList_constructive[] = 'beforeAddTable__gacl_phpgacl';
		$this->aTaskList_constructive[] = 'afterAddTable__gacl_phpgacl';
		$this->aTaskList_constructive[] = 'beforeAddTable__users';
		$this->aTaskList_constructive[] = 'afterAddTable__users';
		$this->aTaskList_constructive[] = 'beforeAddField__affiliates__account_id';
		$this->aTaskList_constructive[] = 'afterAddField__affiliates__account_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__affiliates__account_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__affiliates__account_id';
		$this->aTaskList_constructive[] = 'beforeAddField__agency__account_id';
		$this->aTaskList_constructive[] = 'afterAddField__agency__account_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__agency__account_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__agency__account_id';
		$this->aTaskList_constructive[] = 'beforeAddField__clients__account_id';
		$this->aTaskList_constructive[] = 'afterAddField__clients__account_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__clients__account_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__clients__account_id';


		$this->aObjectMap['affiliates']['account_id'] = array('fromTable'=>'affiliates', 'fromField'=>'account_id');
		$this->aObjectMap['agency']['account_id'] = array('fromTable'=>'agency', 'fromField'=>'account_id');
		$this->aObjectMap['clients']['account_id'] = array('fromTable'=>'clients', 'fromField'=>'account_id');
    }



	function beforeAddTable__accounts()
	{
		return $this->beforeAddTable('accounts');
	}

	function afterAddTable__accounts()
	{
		return $this->afterAddTable('accounts');
	}

	function beforeAddTable__gacl_acl()
	{
		return $this->beforeAddTable('gacl_acl');
	}

	function afterAddTable__gacl_acl()
	{
		return $this->afterAddTable('gacl_acl');
	}

	function beforeAddTable__gacl_acl_sections()
	{
		return $this->beforeAddTable('gacl_acl_sections');
	}

	function afterAddTable__gacl_acl_sections()
	{
		return $this->afterAddTable('gacl_acl_sections');
	}

	function beforeAddTable__gacl_aco()
	{
		return $this->beforeAddTable('gacl_aco');
	}

	function afterAddTable__gacl_aco()
	{
		return $this->afterAddTable('gacl_aco');
	}

	function beforeAddTable__gacl_aco_map()
	{
		return $this->beforeAddTable('gacl_aco_map');
	}

	function afterAddTable__gacl_aco_map()
	{
		return $this->afterAddTable('gacl_aco_map');
	}

	function beforeAddTable__gacl_aco_sections()
	{
		return $this->beforeAddTable('gacl_aco_sections');
	}

	function afterAddTable__gacl_aco_sections()
	{
		return $this->afterAddTable('gacl_aco_sections');
	}

	function beforeAddTable__gacl_aro()
	{
		return $this->beforeAddTable('gacl_aro');
	}

	function afterAddTable__gacl_aro()
	{
		return $this->afterAddTable('gacl_aro');
	}

	function beforeAddTable__gacl_aro_groups()
	{
		return $this->beforeAddTable('gacl_aro_groups');
	}

	function afterAddTable__gacl_aro_groups()
	{
		return $this->afterAddTable('gacl_aro_groups');
	}

	function beforeAddTable__gacl_aro_groups_map()
	{
		return $this->beforeAddTable('gacl_aro_groups_map');
	}

	function afterAddTable__gacl_aro_groups_map()
	{
		return $this->afterAddTable('gacl_aro_groups_map');
	}

	function beforeAddTable__gacl_aro_map()
	{
		return $this->beforeAddTable('gacl_aro_map');
	}

	function afterAddTable__gacl_aro_map()
	{
		return $this->afterAddTable('gacl_aro_map');
	}

	function beforeAddTable__gacl_aro_sections()
	{
		return $this->beforeAddTable('gacl_aro_sections');
	}

	function afterAddTable__gacl_aro_sections()
	{
		return $this->afterAddTable('gacl_aro_sections');
	}

	function beforeAddTable__gacl_axo()
	{
		return $this->beforeAddTable('gacl_axo');
	}

	function afterAddTable__gacl_axo()
	{
		return $this->afterAddTable('gacl_axo');
	}

	function beforeAddTable__gacl_axo_groups()
	{
		return $this->beforeAddTable('gacl_axo_groups');
	}

	function afterAddTable__gacl_axo_groups()
	{
		return $this->afterAddTable('gacl_axo_groups');
	}

	function beforeAddTable__gacl_axo_groups_map()
	{
		return $this->beforeAddTable('gacl_axo_groups_map');
	}

	function afterAddTable__gacl_axo_groups_map()
	{
		return $this->afterAddTable('gacl_axo_groups_map');
	}

	function beforeAddTable__gacl_axo_map()
	{
		return $this->beforeAddTable('gacl_axo_map');
	}

	function afterAddTable__gacl_axo_map()
	{
		return $this->afterAddTable('gacl_axo_map');
	}

	function beforeAddTable__gacl_axo_sections()
	{
		return $this->beforeAddTable('gacl_axo_sections');
	}

	function afterAddTable__gacl_axo_sections()
	{
		return $this->afterAddTable('gacl_axo_sections');
	}

	function beforeAddTable__gacl_groups_aro_map()
	{
		return $this->beforeAddTable('gacl_groups_aro_map');
	}

	function afterAddTable__gacl_groups_aro_map()
	{
		return $this->afterAddTable('gacl_groups_aro_map');
	}

	function beforeAddTable__gacl_groups_axo_map()
	{
		return $this->beforeAddTable('gacl_groups_axo_map');
	}

	function afterAddTable__gacl_groups_axo_map()
	{
		return $this->afterAddTable('gacl_groups_axo_map');
	}

	function beforeAddTable__gacl_phpgacl()
	{
		return $this->beforeAddTable('gacl_phpgacl');
	}

	function afterAddTable__gacl_phpgacl()
	{
		return $this->afterAddTable('gacl_phpgacl');
	}

	function beforeAddTable__users()
	{
		return $this->beforeAddTable('users');
	}

	function afterAddTable__users()
	{
		return $this->afterAddTable('users');
	}

	function beforeAddField__affiliates__account_id()
	{
		return $this->beforeAddField('affiliates', 'account_id');
	}

	function afterAddField__affiliates__account_id()
	{
		return $this->afterAddField('affiliates', 'account_id');
	}

	function beforeAddIndex__affiliates__account_id()
	{
		return $this->beforeAddIndex('affiliates', 'account_id');
	}

	function afterAddIndex__affiliates__account_id()
	{
		return $this->afterAddIndex('affiliates', 'account_id');
	}

	function beforeAddField__agency__account_id()
	{
		return $this->beforeAddField('agency', 'account_id');
	}

	function afterAddField__agency__account_id()
	{
		return $this->afterAddField('agency', 'account_id');
	}

	function beforeAddIndex__agency__account_id()
	{
		return $this->beforeAddIndex('agency', 'account_id');
	}

	function afterAddIndex__agency__account_id()
	{
		return $this->afterAddIndex('agency', 'account_id');
	}

	function beforeAddField__clients__account_id()
	{
		return $this->beforeAddField('clients', 'account_id');
	}

	function afterAddField__clients__account_id()
	{
		return $this->afterAddField('clients', 'account_id');
	}

	function beforeAddIndex__clients__account_id()
	{
		return $this->beforeAddIndex('clients', 'account_id');
	}

	function afterAddIndex__clients__account_id()
	{
		return $this->afterAddIndex('clients', 'account_id');
	}

}

?>