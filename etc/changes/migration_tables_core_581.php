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

class Migration_581 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__banners__ad_direct_status';
		$this->aTaskList_constructive[] = 'afterAddField__banners__ad_direct_status';
		$this->aTaskList_constructive[] = 'beforeAddField__banners__ad_direct_rejection_reason_id';
		$this->aTaskList_constructive[] = 'afterAddField__banners__ad_direct_rejection_reason_id';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__hosted_views';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__hosted_views';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__hosted_clicks';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__hosted_clicks';
		$this->aTaskList_constructive[] = 'beforeAddField__users__date_created';
		$this->aTaskList_constructive[] = 'afterAddField__users__date_created';
		$this->aTaskList_constructive[] = 'beforeAddField__users__date_last_login';
		$this->aTaskList_constructive[] = 'afterAddField__users__date_last_login';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__is_in_ad_direct';
		$this->aTaskList_constructive[] = 'afterAddField__zones__is_in_ad_direct';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__rate';
		$this->aTaskList_constructive[] = 'afterAddField__zones__rate';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__pricing';
		$this->aTaskList_constructive[] = 'afterAddField__zones__pricing';


		$this->aObjectMap['banners']['ad_direct_status'] = array('fromTable'=>'banners', 'fromField'=>'ad_direct_status');
		$this->aObjectMap['banners']['ad_direct_rejection_reason_id'] = array('fromTable'=>'banners', 'fromField'=>'ad_direct_rejection_reason_id');
		$this->aObjectMap['campaigns']['hosted_views'] = array('fromTable'=>'campaigns', 'fromField'=>'hosted_views');
		$this->aObjectMap['campaigns']['hosted_clicks'] = array('fromTable'=>'campaigns', 'fromField'=>'hosted_clicks');
		$this->aObjectMap['users']['date_created'] = array('fromTable'=>'users', 'fromField'=>'date_created');
		$this->aObjectMap['users']['date_last_login'] = array('fromTable'=>'users', 'fromField'=>'date_last_login');
		$this->aObjectMap['zones']['is_in_ad_direct'] = array('fromTable'=>'zones', 'fromField'=>'is_in_ad_direct');
		$this->aObjectMap['zones']['rate'] = array('fromTable'=>'zones', 'fromField'=>'rate');
		$this->aObjectMap['zones']['pricing'] = array('fromTable'=>'zones', 'fromField'=>'pricing');
    }



	function beforeAddField__banners__ad_direct_status()
	{
		return $this->beforeAddField('banners', 'ad_direct_status');
	}

	function afterAddField__banners__ad_direct_status()
	{
		return $this->afterAddField('banners', 'ad_direct_status');
	}

	function beforeAddField__banners__ad_direct_rejection_reason_id()
	{
		return $this->beforeAddField('banners', 'ad_direct_rejection_reason_id');
	}

	function afterAddField__banners__ad_direct_rejection_reason_id()
	{
		return $this->afterAddField('banners', 'ad_direct_rejection_reason_id');
	}

	function beforeAddField__campaigns__hosted_views()
	{
		return $this->beforeAddField('campaigns', 'hosted_views');
	}

	function afterAddField__campaigns__hosted_views()
	{
		return $this->afterAddField('campaigns', 'hosted_views');
	}

	function beforeAddField__campaigns__hosted_clicks()
	{
		return $this->beforeAddField('campaigns', 'hosted_clicks');
	}

	function afterAddField__campaigns__hosted_clicks()
	{
		return $this->afterAddField('campaigns', 'hosted_clicks');
	}

	function beforeAddField__zones__is_in_ad_direct()
	{
		return $this->beforeAddField('zones', 'is_in_ad_direct');
	}

	function afterAddField__zones__is_in_ad_direct()
	{
		return $this->afterAddField('zones', 'is_in_ad_direct');
	}

	function beforeAddField__zones__rate()
	{
		return $this->beforeAddField('zones', 'rate');
	}

	function afterAddField__zones__rate()
	{
		return $this->afterAddField('zones', 'rate');
	}

	function beforeAddField__zones__pricing()
	{
		return $this->beforeAddField('zones', 'pricing');
	}

	function afterAddField__zones__pricing()
	{
		return $this->afterAddField('zones', 'pricing');
	}

	function beforeAddField__users__date_created()
	{
		return $this->beforeAddField('users', 'date_created');
	}

	function afterAddField__users__date_created()
	{
		return $this->afterAddField('users', 'date_created');
	}

	function beforeAddField__users__date_last_login()
	{
		return $this->beforeAddField('users', 'date_last_login');
	}

	function afterAddField__users__date_last_login()
	{
		return $this->afterAddField('users', 'date_last_login');
	}

}

?>