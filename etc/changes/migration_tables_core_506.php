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

class Migration_506 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__campaigns__block';
        $this->aTaskList_constructive[] = 'afterAddField__campaigns__block';
        $this->aTaskList_constructive[] = 'beforeAddField__campaigns__capping';
        $this->aTaskList_constructive[] = 'afterAddField__campaigns__capping';
        $this->aTaskList_constructive[] = 'beforeAddField__campaigns__session_capping';
        $this->aTaskList_constructive[] = 'afterAddField__campaigns__session_capping';
        $this->aTaskList_constructive[] = 'beforeAddField__data_intermediate_ad_connection__tracker_channel_ids';
        $this->aTaskList_constructive[] = 'afterAddField__data_intermediate_ad_connection__tracker_channel_ids';
        $this->aTaskList_constructive[] = 'beforeAddField__data_intermediate_ad_connection__connection_channel_ids';
        $this->aTaskList_constructive[] = 'afterAddField__data_intermediate_ad_connection__connection_channel_ids';
        $this->aTaskList_constructive[] = 'beforeAddField__data_raw_ad_click__channel_ids';
        $this->aTaskList_constructive[] = 'afterAddField__data_raw_ad_click__channel_ids';
        $this->aTaskList_constructive[] = 'beforeAddField__data_raw_ad_impression__channel_ids';
        $this->aTaskList_constructive[] = 'afterAddField__data_raw_ad_impression__channel_ids';
        $this->aTaskList_constructive[] = 'beforeAddField__data_raw_ad_request__channel_ids';
        $this->aTaskList_constructive[] = 'afterAddField__data_raw_ad_request__channel_ids';
        $this->aTaskList_constructive[] = 'beforeAddField__data_raw_tracker_click__channel_ids';
        $this->aTaskList_constructive[] = 'afterAddField__data_raw_tracker_click__channel_ids';
        $this->aTaskList_constructive[] = 'beforeAddField__data_raw_tracker_impression__channel_ids';
        $this->aTaskList_constructive[] = 'afterAddField__data_raw_tracker_impression__channel_ids';


        $this->aObjectMap['campaigns']['block'] = ['fromTable' => 'campaigns', 'fromField' => 'block'];
        $this->aObjectMap['campaigns']['capping'] = ['fromTable' => 'campaigns', 'fromField' => 'capping'];
        $this->aObjectMap['campaigns']['session_capping'] = ['fromTable' => 'campaigns', 'fromField' => 'session_capping'];
        $this->aObjectMap['data_intermediate_ad_connection']['tracker_channel_ids'] = ['fromTable' => 'data_intermediate_ad_connection', 'fromField' => 'tracker_channel_ids'];
        $this->aObjectMap['data_intermediate_ad_connection']['connection_channel_ids'] = ['fromTable' => 'data_intermediate_ad_connection', 'fromField' => 'connection_channel_ids'];
        $this->aObjectMap['data_raw_ad_click']['channel_ids'] = ['fromTable' => 'data_raw_ad_click', 'fromField' => 'channel_ids'];
        $this->aObjectMap['data_raw_ad_impression']['channel_ids'] = ['fromTable' => 'data_raw_ad_impression', 'fromField' => 'channel_ids'];
        $this->aObjectMap['data_raw_ad_request']['channel_ids'] = ['fromTable' => 'data_raw_ad_request', 'fromField' => 'channel_ids'];
        $this->aObjectMap['data_raw_tracker_click']['channel_ids'] = ['fromTable' => 'data_raw_tracker_click', 'fromField' => 'channel_ids'];
        $this->aObjectMap['data_raw_tracker_impression']['channel_ids'] = ['fromTable' => 'data_raw_tracker_impression', 'fromField' => 'channel_ids'];
    }



    public function beforeAddField__campaigns__block()
    {
        return $this->beforeAddField('campaigns', 'block');
    }

    public function afterAddField__campaigns__block()
    {
        return $this->afterAddField('campaigns', 'block');
    }

    public function beforeAddField__campaigns__capping()
    {
        return $this->beforeAddField('campaigns', 'capping');
    }

    public function afterAddField__campaigns__capping()
    {
        return $this->afterAddField('campaigns', 'capping');
    }

    public function beforeAddField__campaigns__session_capping()
    {
        return $this->beforeAddField('campaigns', 'session_capping');
    }

    public function afterAddField__campaigns__session_capping()
    {
        return $this->afterAddField('campaigns', 'session_capping');
    }

    public function beforeAddField__data_intermediate_ad_connection__tracker_channel_ids()
    {
        return $this->beforeAddField('data_intermediate_ad_connection', 'tracker_channel_ids');
    }

    public function afterAddField__data_intermediate_ad_connection__tracker_channel_ids()
    {
        return $this->afterAddField('data_intermediate_ad_connection', 'tracker_channel_ids');
    }

    public function beforeAddField__data_intermediate_ad_connection__connection_channel_ids()
    {
        return $this->beforeAddField('data_intermediate_ad_connection', 'connection_channel_ids');
    }

    public function afterAddField__data_intermediate_ad_connection__connection_channel_ids()
    {
        return $this->afterAddField('data_intermediate_ad_connection', 'connection_channel_ids');
    }

    public function beforeAddField__data_raw_ad_click__channel_ids()
    {
        return $this->beforeAddField('data_raw_ad_click', 'channel_ids');
    }

    public function afterAddField__data_raw_ad_click__channel_ids()
    {
        return $this->afterAddField('data_raw_ad_click', 'channel_ids');
    }

    public function beforeAddField__data_raw_ad_impression__channel_ids()
    {
        return $this->beforeAddField('data_raw_ad_impression', 'channel_ids');
    }

    public function afterAddField__data_raw_ad_impression__channel_ids()
    {
        return $this->afterAddField('data_raw_ad_impression', 'channel_ids');
    }

    public function beforeAddField__data_raw_ad_request__channel_ids()
    {
        return $this->beforeAddField('data_raw_ad_request', 'channel_ids');
    }

    public function afterAddField__data_raw_ad_request__channel_ids()
    {
        return $this->afterAddField('data_raw_ad_request', 'channel_ids');
    }

    public function beforeAddField__data_raw_tracker_click__channel_ids()
    {
        return $this->beforeAddField('data_raw_tracker_click', 'channel_ids');
    }

    public function afterAddField__data_raw_tracker_click__channel_ids()
    {
        return $this->afterAddField('data_raw_tracker_click', 'channel_ids');
    }

    public function beforeAddField__data_raw_tracker_impression__channel_ids()
    {
        return $this->beforeAddField('data_raw_tracker_impression', 'channel_ids');
    }

    public function afterAddField__data_raw_tracker_impression__channel_ids()
    {
        return $this->afterAddField('data_raw_tracker_impression', 'channel_ids');
    }
}
