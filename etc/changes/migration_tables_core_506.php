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
$Id$
*/

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_506 extends Migration
{

    function Migration_506()
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


		$this->aObjectMap['campaigns']['block'] = array('fromTable'=>'campaigns', 'fromField'=>'block');
		$this->aObjectMap['campaigns']['capping'] = array('fromTable'=>'campaigns', 'fromField'=>'capping');
		$this->aObjectMap['campaigns']['session_capping'] = array('fromTable'=>'campaigns', 'fromField'=>'session_capping');
		$this->aObjectMap['data_intermediate_ad_connection']['tracker_channel_ids'] = array('fromTable'=>'data_intermediate_ad_connection', 'fromField'=>'tracker_channel_ids');
		$this->aObjectMap['data_intermediate_ad_connection']['connection_channel_ids'] = array('fromTable'=>'data_intermediate_ad_connection', 'fromField'=>'connection_channel_ids');
		$this->aObjectMap['data_raw_ad_click']['channel_ids'] = array('fromTable'=>'data_raw_ad_click', 'fromField'=>'channel_ids');
		$this->aObjectMap['data_raw_ad_impression']['channel_ids'] = array('fromTable'=>'data_raw_ad_impression', 'fromField'=>'channel_ids');
		$this->aObjectMap['data_raw_ad_request']['channel_ids'] = array('fromTable'=>'data_raw_ad_request', 'fromField'=>'channel_ids');
		$this->aObjectMap['data_raw_tracker_click']['channel_ids'] = array('fromTable'=>'data_raw_tracker_click', 'fromField'=>'channel_ids');
		$this->aObjectMap['data_raw_tracker_impression']['channel_ids'] = array('fromTable'=>'data_raw_tracker_impression', 'fromField'=>'channel_ids');
    }



	function beforeAddField__campaigns__block()
	{
		return $this->beforeAddField('campaigns', 'block');
	}

	function afterAddField__campaigns__block()
	{
		return $this->afterAddField('campaigns', 'block');
	}

	function beforeAddField__campaigns__capping()
	{
		return $this->beforeAddField('campaigns', 'capping');
	}

	function afterAddField__campaigns__capping()
	{
		return $this->afterAddField('campaigns', 'capping');
	}

	function beforeAddField__campaigns__session_capping()
	{
		return $this->beforeAddField('campaigns', 'session_capping');
	}

	function afterAddField__campaigns__session_capping()
	{
		return $this->afterAddField('campaigns', 'session_capping');
	}

	function beforeAddField__data_intermediate_ad_connection__tracker_channel_ids()
	{
		return $this->beforeAddField('data_intermediate_ad_connection', 'tracker_channel_ids');
	}

	function afterAddField__data_intermediate_ad_connection__tracker_channel_ids()
	{
		return $this->afterAddField('data_intermediate_ad_connection', 'tracker_channel_ids');
	}

	function beforeAddField__data_intermediate_ad_connection__connection_channel_ids()
	{
		return $this->beforeAddField('data_intermediate_ad_connection', 'connection_channel_ids');
	}

	function afterAddField__data_intermediate_ad_connection__connection_channel_ids()
	{
		return $this->afterAddField('data_intermediate_ad_connection', 'connection_channel_ids');
	}

	function beforeAddField__data_raw_ad_click__channel_ids()
	{
		return $this->beforeAddField('data_raw_ad_click', 'channel_ids');
	}

	function afterAddField__data_raw_ad_click__channel_ids()
	{
		return $this->afterAddField('data_raw_ad_click', 'channel_ids');
	}

	function beforeAddField__data_raw_ad_impression__channel_ids()
	{
		return $this->beforeAddField('data_raw_ad_impression', 'channel_ids');
	}

	function afterAddField__data_raw_ad_impression__channel_ids()
	{
		return $this->afterAddField('data_raw_ad_impression', 'channel_ids');
	}

	function beforeAddField__data_raw_ad_request__channel_ids()
	{
		return $this->beforeAddField('data_raw_ad_request', 'channel_ids');
	}

	function afterAddField__data_raw_ad_request__channel_ids()
	{
		return $this->afterAddField('data_raw_ad_request', 'channel_ids');
	}

	function beforeAddField__data_raw_tracker_click__channel_ids()
	{
		return $this->beforeAddField('data_raw_tracker_click', 'channel_ids');
	}

	function afterAddField__data_raw_tracker_click__channel_ids()
	{
		return $this->afterAddField('data_raw_tracker_click', 'channel_ids');
	}

	function beforeAddField__data_raw_tracker_impression__channel_ids()
	{
		return $this->beforeAddField('data_raw_tracker_impression', 'channel_ids');
	}

	function afterAddField__data_raw_tracker_impression__channel_ids()
	{
		return $this->afterAddField('data_raw_tracker_impression', 'channel_ids');
	}

}

?>