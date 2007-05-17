<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
$Id: Acls.dal.test.php 5552 2007-04-03 19:52:40Z andrew.hill@openads.org $
*/

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_118 extends Migration
{

    function Migration_118()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__campaigns_trackers';
		$this->aTaskList_constructive[] = 'afterAddTable__campaigns_trackers';
		$this->aTaskList_constructive[] = 'beforeAddTable__tracker_append';
		$this->aTaskList_constructive[] = 'afterAddTable__tracker_append';
		$this->aTaskList_constructive[] = 'beforeAddTable__trackers';
		$this->aTaskList_constructive[] = 'afterAddTable__trackers';
		$this->aTaskList_constructive[] = 'beforeAddTable__variable_publisher';
		$this->aTaskList_constructive[] = 'afterAddTable__variable_publisher';
		$this->aTaskList_constructive[] = 'beforeAddTable__variables';
		$this->aTaskList_constructive[] = 'afterAddTable__variables';


    }



	function beforeAddTable__campaigns_trackers()
	{
		return $this->beforeAddTable('campaigns_trackers');
	}

	function afterAddTable__campaigns_trackers()
	{
		return $this->afterAddTable('campaigns_trackers');
	}

	function beforeAddTable__tracker_append()
	{
		return $this->beforeAddTable('tracker_append');
	}

	function afterAddTable__tracker_append()
	{
		return $this->afterAddTable('tracker_append');
	}

	function beforeAddTable__trackers()
	{
		return $this->beforeAddTable('trackers');
	}

	function afterAddTable__trackers()
	{
		return $this->afterAddTable('trackers');
	}

	function beforeAddTable__variable_publisher()
	{
		return $this->beforeAddTable('variable_publisher');
	}

	function afterAddTable__variable_publisher()
	{
		return $this->afterAddTable('variable_publisher');
	}

	function beforeAddTable__variables()
	{
		return $this->beforeAddTable('variables');
	}

	function afterAddTable__variables()
	{
		return $this->afterAddTable('variables');
	}

}

?>