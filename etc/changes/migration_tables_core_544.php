<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');
require_once(MAX_PATH.'/lib/OA/Dal/ApplicationVariables.php');

class Migration_544 extends Migration
{

    function Migration_544()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__account_preference_assoc';
		$this->aTaskList_constructive[] = 'afterAddTable__account_preference_assoc';
		$this->aTaskList_constructive[] = 'beforeAddTable__preferences';
		$this->aTaskList_constructive[] = 'afterAddTable__preferences';
		$this->aTaskList_constructive[] = 'beforeAddIndex__accounts__account_type';
		$this->aTaskList_constructive[] = 'afterAddIndex__accounts__account_type';
		$this->aTaskList_constructive[] = 'beforeAlterField__application_variable__value';
		$this->aTaskList_constructive[] = 'afterAlterField__application_variable__value';
		$this->aTaskList_destructive[] = 'beforeRemoveField__affiliates__username';
		$this->aTaskList_destructive[] = 'afterRemoveField__affiliates__username';
		$this->aTaskList_destructive[] = 'beforeRemoveField__affiliates__password';
		$this->aTaskList_destructive[] = 'afterRemoveField__affiliates__password';
		$this->aTaskList_destructive[] = 'beforeRemoveField__affiliates__permissions';
		$this->aTaskList_destructive[] = 'afterRemoveField__affiliates__permissions';
		$this->aTaskList_destructive[] = 'beforeRemoveField__affiliates__language';
		$this->aTaskList_destructive[] = 'afterRemoveField__affiliates__language';
		$this->aTaskList_destructive[] = 'beforeRemoveField__affiliates__publiczones';
		$this->aTaskList_destructive[] = 'afterRemoveField__affiliates__publiczones';
		$this->aTaskList_destructive[] = 'beforeRemoveField__affiliates__last_accepted_agency_agreement';
		$this->aTaskList_destructive[] = 'afterRemoveField__affiliates__last_accepted_agency_agreement';
		$this->aTaskList_destructive[] = 'beforeRemoveField__agency__username';
		$this->aTaskList_destructive[] = 'afterRemoveField__agency__username';
		$this->aTaskList_destructive[] = 'beforeRemoveField__agency__password';
		$this->aTaskList_destructive[] = 'afterRemoveField__agency__password';
		$this->aTaskList_destructive[] = 'beforeRemoveField__agency__permissions';
		$this->aTaskList_destructive[] = 'afterRemoveField__agency__permissions';
		$this->aTaskList_destructive[] = 'beforeRemoveField__agency__language';
		$this->aTaskList_destructive[] = 'afterRemoveField__agency__language';
		$this->aTaskList_destructive[] = 'beforeRemoveField__clients__clientusername';
		$this->aTaskList_destructive[] = 'afterRemoveField__clients__clientusername';
		$this->aTaskList_destructive[] = 'beforeRemoveField__clients__clientpassword';
		$this->aTaskList_destructive[] = 'afterRemoveField__clients__clientpassword';
		$this->aTaskList_destructive[] = 'beforeRemoveField__clients__permissions';
		$this->aTaskList_destructive[] = 'afterRemoveField__clients__permissions';
		$this->aTaskList_destructive[] = 'beforeRemoveField__clients__language';
		$this->aTaskList_destructive[] = 'afterRemoveField__clients__language';


    }



	function beforeAddTable__account_preference_assoc()
	{
		return $this->beforeAddTable('account_preference_assoc');
	}

	function afterAddTable__account_preference_assoc()
	{
		return $this->afterAddTable('account_preference_assoc');
	}

	function beforeAddTable__preferences()
	{
		return $this->beforeAddTable('preferences');
	}

	function afterAddTable__preferences()
	{
		return $this->afterAddTable('preferences');
	}

	function beforeAddIndex__accounts__account_type()
	{
		return $this->beforeAddIndex('accounts', 'account_type');
	}

	function afterAddIndex__accounts__account_type()
	{
		return $this->afterAddIndex('accounts', 'account_type');
	}

	function beforeAlterField__application_variable__value()
	{
		return $this->beforeAlterField('application_variable', 'value');
	}

	function afterAlterField__application_variable__value()
	{
		return $this->afterAlterField('application_variable', 'value');
	}

	function beforeRemoveField__affiliates__username()
	{
		return $this->migrateData() && $this->beforeRemoveField('affiliates', 'username');
	}

	function afterRemoveField__affiliates__username()
	{
		return $this->afterRemoveField('affiliates', 'username');
	}

	function beforeRemoveField__affiliates__password()
	{
		return $this->beforeRemoveField('affiliates', 'password');
	}

	function afterRemoveField__affiliates__password()
	{
		return $this->afterRemoveField('affiliates', 'password');
	}

	function beforeRemoveField__affiliates__permissions()
	{
		return $this->beforeRemoveField('affiliates', 'permissions');
	}

	function afterRemoveField__affiliates__permissions()
	{
		return $this->afterRemoveField('affiliates', 'permissions');
	}

	function beforeRemoveField__affiliates__language()
	{
		return $this->beforeRemoveField('affiliates', 'language');
	}

	function afterRemoveField__affiliates__language()
	{
		return $this->afterRemoveField('affiliates', 'language');
	}

	function beforeRemoveField__affiliates__publiczones()
	{
		return $this->beforeRemoveField('affiliates', 'publiczones');
	}

	function afterRemoveField__affiliates__publiczones()
	{
		return $this->afterRemoveField('affiliates', 'publiczones');
	}

	function beforeRemoveField__affiliates__last_accepted_agency_agreement()
	{
		return $this->beforeRemoveField('affiliates', 'last_accepted_agency_agreement');
	}

	function afterRemoveField__affiliates__last_accepted_agency_agreement()
	{
		return $this->afterRemoveField('affiliates', 'last_accepted_agency_agreement');
	}

	function beforeRemoveField__agency__username()
	{
		return $this->beforeRemoveField('agency', 'username');
	}

	function afterRemoveField__agency__username()
	{
		return $this->afterRemoveField('agency', 'username');
	}

	function beforeRemoveField__agency__password()
	{
		return $this->beforeRemoveField('agency', 'password');
	}

	function afterRemoveField__agency__password()
	{
		return $this->afterRemoveField('agency', 'password');
	}

	function beforeRemoveField__agency__permissions()
	{
		return $this->beforeRemoveField('agency', 'permissions');
	}

	function afterRemoveField__agency__permissions()
	{
		return $this->afterRemoveField('agency', 'permissions');
	}

	function beforeRemoveField__agency__language()
	{
		return $this->beforeRemoveField('agency', 'language');
	}

	function afterRemoveField__agency__language()
	{
		return $this->afterRemoveField('agency', 'language');
	}

	function beforeRemoveField__clients__clientusername()
	{
		return $this->beforeRemoveField('clients', 'clientusername');
	}

	function afterRemoveField__clients__clientusername()
	{
		return $this->afterRemoveField('clients', 'clientusername');
	}

	function beforeRemoveField__clients__clientpassword()
	{
		return $this->beforeRemoveField('clients', 'clientpassword');
	}

	function afterRemoveField__clients__clientpassword()
	{
		return $this->afterRemoveField('clients', 'clientpassword');
	}

	function beforeRemoveField__clients__permissions()
	{
		return $this->beforeRemoveField('clients', 'permissions');
	}

	function afterRemoveField__clients__permissions()
	{
		return $this->afterRemoveField('clients', 'permissions');
	}

	function beforeRemoveField__clients__language()
	{
		return $this->beforeRemoveField('clients', 'language');
	}

	function afterRemoveField__clients__language()
	{
		return $this->afterRemoveField('clients', 'language');
	}

	function migrateData()
	{
	    // Migrate preference table

	    // Migrate language from affiliates

	    // Migrate language/logout_url from agency

	    // Migrate language from clients

	    // Migrate timezone (is it needed?)

	    return true;
	}

}

?>