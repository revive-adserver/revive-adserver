<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_583 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__audit__advertiser_account_id';
		$this->aTaskList_constructive[] = 'afterAddField__audit__advertiser_account_id';
		$this->aTaskList_constructive[] = 'beforeAddField__audit__website_account_id';
		$this->aTaskList_constructive[] = 'afterAddField__audit__website_account_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__audit__advertiser_account_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__audit__advertiser_account_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__audit__website_account_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__audit__website_account_id';


		$this->aObjectMap['audit']['advertiser_account_id'] = array('fromTable'=>'audit', 'fromField'=>'advertiser_account_id');
		$this->aObjectMap['audit']['website_account_id'] = array('fromTable'=>'audit', 'fromField'=>'website_account_id');
    }



	function beforeAddField__audit__advertiser_account_id()
	{
		return $this->beforeAddField('audit', 'advertiser_account_id');
	}

	function afterAddField__audit__advertiser_account_id()
	{
		return $this->afterAddField('audit', 'advertiser_account_id');
	}

	function beforeAddField__audit__website_account_id()
	{
		return $this->beforeAddField('audit', 'website_account_id');
	}

	function afterAddField__audit__website_account_id()
	{
		return $this->afterAddField('audit', 'website_account_id');
	}

	function beforeAddIndex__audit__advertiser_account_id()
	{
		return $this->beforeAddIndex('audit', 'advertiser_account_id');
	}

	function afterAddIndex__audit__advertiser_account_id()
	{
		return $this->afterAddIndex('audit', 'advertiser_account_id');
	}

	function beforeAddIndex__audit__website_account_id()
	{
		return $this->beforeAddIndex('audit', 'website_account_id');
	}

	function afterAddIndex__audit__website_account_id()
	{
		return $this->afterAddIndex('audit', 'website_account_id');
	}

}

?>