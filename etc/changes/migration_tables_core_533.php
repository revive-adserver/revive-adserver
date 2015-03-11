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

class Migration_533 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__affiliates__oac_country_code';
		$this->aTaskList_constructive[] = 'afterAddField__affiliates__oac_country_code';
		$this->aTaskList_constructive[] = 'beforeAddField__affiliates__oac_language_id';
		$this->aTaskList_constructive[] = 'afterAddField__affiliates__oac_language_id';
		$this->aTaskList_constructive[] = 'beforeAddField__affiliates__oac_category_id';
		$this->aTaskList_constructive[] = 'afterAddField__affiliates__oac_category_id';


		$this->aObjectMap['affiliates']['oac_country_code'] = array('fromTable'=>'affiliates', 'fromField'=>'oac_country_code');
		$this->aObjectMap['affiliates']['oac_language_id'] = array('fromTable'=>'affiliates', 'fromField'=>'oac_language_id');
		$this->aObjectMap['affiliates']['oac_category_id'] = array('fromTable'=>'affiliates', 'fromField'=>'oac_category_id');
    }



	function beforeAddField__affiliates__oac_country_code()
	{
		return $this->beforeAddField('affiliates', 'oac_country_code');
	}

	function afterAddField__affiliates__oac_country_code()
	{
		return $this->afterAddField('affiliates', 'oac_country_code');
	}

	function beforeAddField__affiliates__oac_language_id()
	{
		return $this->beforeAddField('affiliates', 'oac_language_id');
	}

	function afterAddField__affiliates__oac_language_id()
	{
		return $this->afterAddField('affiliates', 'oac_language_id');
	}

	function beforeAddField__affiliates__oac_category_id()
	{
		return $this->beforeAddField('affiliates', 'oac_category_id');
	}

	function afterAddField__affiliates__oac_category_id()
	{
		return $this->afterAddField('affiliates', 'oac_category_id');
	}

}

?>