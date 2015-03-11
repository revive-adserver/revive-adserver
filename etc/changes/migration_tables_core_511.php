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

class Migration_511 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__ad_zone_assoc__priority_factor';
		$this->aTaskList_constructive[] = 'afterAddField__ad_zone_assoc__priority_factor';
		$this->aTaskList_constructive[] = 'beforeAddField__ad_zone_assoc__to_be_delivered';
		$this->aTaskList_constructive[] = 'afterAddField__ad_zone_assoc__to_be_delivered';
		$this->aTaskList_constructive[] = 'beforeAddField__data_summary_ad_zone_assoc__to_be_delivered';
		$this->aTaskList_constructive[] = 'afterAddField__data_summary_ad_zone_assoc__to_be_delivered';


		$this->aObjectMap['ad_zone_assoc']['priority_factor'] = array('fromTable'=>'ad_zone_assoc', 'fromField'=>'priority_factor');
		$this->aObjectMap['ad_zone_assoc']['to_be_delivered'] = array('fromTable'=>'ad_zone_assoc', 'fromField'=>'to_be_delivered');
		$this->aObjectMap['data_summary_ad_zone_assoc']['to_be_delivered'] = array('fromTable'=>'data_summary_ad_zone_assoc', 'fromField'=>'to_be_delivered');
    }



	function beforeAddField__ad_zone_assoc__priority_factor()
	{
		return $this->beforeAddField('ad_zone_assoc', 'priority_factor');
	}

	function afterAddField__ad_zone_assoc__priority_factor()
	{
		return $this->afterAddField('ad_zone_assoc', 'priority_factor');
	}

	function beforeAddField__ad_zone_assoc__to_be_delivered()
	{
		return $this->beforeAddField('ad_zone_assoc', 'to_be_delivered');
	}

	function afterAddField__ad_zone_assoc__to_be_delivered()
	{
		return $this->afterAddField('ad_zone_assoc', 'to_be_delivered');
	}

	function beforeAddField__data_summary_ad_zone_assoc__to_be_delivered()
	{
		return $this->beforeAddField('data_summary_ad_zone_assoc', 'to_be_delivered');
	}

	function afterAddField__data_summary_ad_zone_assoc__to_be_delivered()
	{
		return $this->afterAddField('data_summary_ad_zone_assoc', 'to_be_delivered');
	}

}

?>