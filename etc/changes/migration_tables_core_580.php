<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_580 extends Migration
{

    function Migration_580()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__users__sso_user_id';
		$this->aTaskList_constructive[] = 'afterAddField__users__sso_user_id';


		$this->aObjectMap['users']['sso_user_id'] = array('fromTable'=>'users', 'fromField'=>'sso_user_id');
    }



	function beforeAddField__users__sso_user_id()
	{
		return $this->beforeAddField('users', 'sso_user_id');
	}

	function afterAddField__users__sso_user_id()
	{
		return $this->afterAddField('users', 'sso_user_id');
	}

}

?>