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

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_581 extends Migration
{
    public function __construct()
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


        $this->aObjectMap['banners']['ad_direct_status'] = ['fromTable' => 'banners', 'fromField' => 'ad_direct_status'];
        $this->aObjectMap['banners']['ad_direct_rejection_reason_id'] = ['fromTable' => 'banners', 'fromField' => 'ad_direct_rejection_reason_id'];
        $this->aObjectMap['campaigns']['hosted_views'] = ['fromTable' => 'campaigns', 'fromField' => 'hosted_views'];
        $this->aObjectMap['campaigns']['hosted_clicks'] = ['fromTable' => 'campaigns', 'fromField' => 'hosted_clicks'];
        $this->aObjectMap['users']['date_created'] = ['fromTable' => 'users', 'fromField' => 'date_created'];
        $this->aObjectMap['users']['date_last_login'] = ['fromTable' => 'users', 'fromField' => 'date_last_login'];
        $this->aObjectMap['zones']['is_in_ad_direct'] = ['fromTable' => 'zones', 'fromField' => 'is_in_ad_direct'];
        $this->aObjectMap['zones']['rate'] = ['fromTable' => 'zones', 'fromField' => 'rate'];
        $this->aObjectMap['zones']['pricing'] = ['fromTable' => 'zones', 'fromField' => 'pricing'];
    }



    public function beforeAddField__banners__ad_direct_status()
    {
        return $this->beforeAddField('banners', 'ad_direct_status');
    }

    public function afterAddField__banners__ad_direct_status()
    {
        return $this->afterAddField('banners', 'ad_direct_status');
    }

    public function beforeAddField__banners__ad_direct_rejection_reason_id()
    {
        return $this->beforeAddField('banners', 'ad_direct_rejection_reason_id');
    }

    public function afterAddField__banners__ad_direct_rejection_reason_id()
    {
        return $this->afterAddField('banners', 'ad_direct_rejection_reason_id');
    }

    public function beforeAddField__campaigns__hosted_views()
    {
        return $this->beforeAddField('campaigns', 'hosted_views');
    }

    public function afterAddField__campaigns__hosted_views()
    {
        return $this->afterAddField('campaigns', 'hosted_views');
    }

    public function beforeAddField__campaigns__hosted_clicks()
    {
        return $this->beforeAddField('campaigns', 'hosted_clicks');
    }

    public function afterAddField__campaigns__hosted_clicks()
    {
        return $this->afterAddField('campaigns', 'hosted_clicks');
    }

    public function beforeAddField__zones__is_in_ad_direct()
    {
        return $this->beforeAddField('zones', 'is_in_ad_direct');
    }

    public function afterAddField__zones__is_in_ad_direct()
    {
        return $this->afterAddField('zones', 'is_in_ad_direct');
    }

    public function beforeAddField__zones__rate()
    {
        return $this->beforeAddField('zones', 'rate');
    }

    public function afterAddField__zones__rate()
    {
        return $this->afterAddField('zones', 'rate');
    }

    public function beforeAddField__zones__pricing()
    {
        return $this->beforeAddField('zones', 'pricing');
    }

    public function afterAddField__zones__pricing()
    {
        return $this->afterAddField('zones', 'pricing');
    }

    public function beforeAddField__users__date_created()
    {
        return $this->beforeAddField('users', 'date_created');
    }

    public function afterAddField__users__date_created()
    {
        return $this->afterAddField('users', 'date_created');
    }

    public function beforeAddField__users__date_last_login()
    {
        return $this->beforeAddField('users', 'date_last_login');
    }

    public function afterAddField__users__date_last_login()
    {
        return $this->afterAddField('users', 'date_last_login');
    }
}
