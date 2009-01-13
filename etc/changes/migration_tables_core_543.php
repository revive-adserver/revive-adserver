<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id: migration_tables_core_546.php 17724 2008-03-17 17:32:14Z andrew.hill@openx.org $
*/

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_543 extends Migration
{

    function Migration_543()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__account_user_assoc';
		$this->aTaskList_constructive[] = 'afterAddTable__account_user_assoc';
		$this->aTaskList_constructive[] = 'beforeAddTable__account_user_permission_assoc';
		$this->aTaskList_constructive[] = 'afterAddTable__account_user_permission_assoc';
		$this->aTaskList_constructive[] = 'beforeAddTable__accounts';
		$this->aTaskList_constructive[] = 'afterAddTable__accounts';
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



	function beforeAddTable__account_user_assoc()
	{
		return $this->beforeAddTable('account_user_assoc');
	}

	function afterAddTable__account_user_assoc()
	{
		return $this->afterAddTable('account_user_assoc');
	}

	function beforeAddTable__account_user_permission_assoc()
	{
		return $this->beforeAddTable('account_user_permission_assoc');
	}

	function afterAddTable__account_user_permission_assoc()
	{
		return $this->afterAddTable('account_user_permission_assoc');
	}

	function beforeAddTable__accounts()
	{
		return $this->beforeAddTable('accounts');
	}

	function afterAddTable__accounts()
	{
		return $this->afterAddTable('accounts');
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