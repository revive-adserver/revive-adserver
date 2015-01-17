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

class Migration_123 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__affiliates__agencyid';
		$this->aTaskList_constructive[] = 'afterAddField__affiliates__agencyid';
		$this->aTaskList_constructive[] = 'beforeAddField__affiliates__mnemonic';
		$this->aTaskList_constructive[] = 'afterAddField__affiliates__mnemonic';
		$this->aTaskList_constructive[] = 'beforeAddField__affiliates__comments';
		$this->aTaskList_constructive[] = 'afterAddField__affiliates__comments';
		$this->aTaskList_constructive[] = 'beforeAddField__affiliates__last_accepted_agency_agreement';
		$this->aTaskList_constructive[] = 'afterAddField__affiliates__last_accepted_agency_agreement';
		$this->aTaskList_constructive[] = 'beforeAddField__affiliates__updated';
		$this->aTaskList_constructive[] = 'afterAddField__affiliates__updated';


		$this->aObjectMap['affiliates']['agencyid'] = array('fromTable'=>'affiliates', 'fromField'=>'agencyid');
		$this->aObjectMap['affiliates']['mnemonic'] = array('fromTable'=>'affiliates', 'fromField'=>'mnemonic');
		$this->aObjectMap['affiliates']['comments'] = array('fromTable'=>'affiliates', 'fromField'=>'comments');
		$this->aObjectMap['affiliates']['last_accepted_agency_agreement'] = array('fromTable'=>'affiliates', 'fromField'=>'last_accepted_agency_agreement');
		$this->aObjectMap['affiliates']['updated'] = array('fromTable'=>'affiliates', 'fromField'=>'updated');
    }



	function beforeAddField__affiliates__agencyid()
	{
		return $this->beforeAddField('affiliates', 'agencyid');
	}

	function afterAddField__affiliates__agencyid()
	{
		return $this->afterAddField('affiliates', 'agencyid');
	}

	function beforeAddField__affiliates__mnemonic()
	{
		return $this->beforeAddField('affiliates', 'mnemonic');
	}

	function afterAddField__affiliates__mnemonic()
	{
		return $this->afterAddField('affiliates', 'mnemonic');
	}

	function beforeAddField__affiliates__comments()
	{
		return $this->beforeAddField('affiliates', 'comments');
	}

	function afterAddField__affiliates__comments()
	{
		return $this->afterAddField('affiliates', 'comments');
	}

	function beforeAddField__affiliates__last_accepted_agency_agreement()
	{
		return $this->beforeAddField('affiliates', 'last_accepted_agency_agreement');
	}

	function afterAddField__affiliates__last_accepted_agency_agreement()
	{
		return $this->afterAddField('affiliates', 'last_accepted_agency_agreement');
	}

	function beforeAddField__affiliates__updated()
	{
		return $this->beforeAddField('affiliates', 'updated');
	}

	function afterAddField__affiliates__updated()
	{
		return $this->afterAddField('affiliates', 'updated');
	}
}

?>