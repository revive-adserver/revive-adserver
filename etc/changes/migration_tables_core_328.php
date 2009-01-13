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

class Migration_328 extends Migration
{

    function Migration_328()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__trackers__status';
		$this->aTaskList_constructive[] = 'afterAddField__trackers__status';
		$this->aTaskList_constructive[] = 'beforeAddField__trackers__type';
		$this->aTaskList_constructive[] = 'afterAddField__trackers__type';
		$this->aTaskList_constructive[] = 'beforeAddField__trackers__linkcampaigns';
		$this->aTaskList_constructive[] = 'afterAddField__trackers__linkcampaigns';
		$this->aTaskList_constructive[] = 'beforeAddField__trackers__variablemethod';
		$this->aTaskList_constructive[] = 'afterAddField__trackers__variablemethod';
		$this->aTaskList_constructive[] = 'beforeAddField__trackers__appendcode';
		$this->aTaskList_constructive[] = 'afterAddField__trackers__appendcode';
		$this->aTaskList_constructive[] = 'beforeAddField__trackers__updated';
		$this->aTaskList_constructive[] = 'afterAddField__trackers__updated';


		$this->aObjectMap['trackers']['status'] = array('fromTable'=>'trackers', 'fromField'=>'status');
		$this->aObjectMap['trackers']['type'] = array('fromTable'=>'trackers', 'fromField'=>'type');
		$this->aObjectMap['trackers']['linkcampaigns'] = array('fromTable'=>'trackers', 'fromField'=>'linkcampaigns');
		$this->aObjectMap['trackers']['variablemethod'] = array('fromTable'=>'trackers', 'fromField'=>'variablemethod');
		$this->aObjectMap['trackers']['appendcode'] = array('fromTable'=>'trackers', 'fromField'=>'appendcode');
		$this->aObjectMap['trackers']['updated'] = array('fromTable'=>'trackers', 'fromField'=>'updated');
    }



	function beforeAddField__trackers__status()
	{
		return $this->beforeAddField('trackers', 'status');
	}

	function afterAddField__trackers__status()
	{
		return $this->afterAddField('trackers', 'status');
	}

	function beforeAddField__trackers__type()
	{
		return $this->beforeAddField('trackers', 'type');
	}

	function afterAddField__trackers__type()
	{
		return $this->afterAddField('trackers', 'type');
	}

	function beforeAddField__trackers__linkcampaigns()
	{
		return $this->beforeAddField('trackers', 'linkcampaigns');
	}

	function afterAddField__trackers__linkcampaigns()
	{
		return $this->afterAddField('trackers', 'linkcampaigns');
	}

	function beforeAddField__trackers__variablemethod()
	{
		return $this->beforeAddField('trackers', 'variablemethod');
	}

	function afterAddField__trackers__variablemethod()
	{
		return $this->afterAddField('trackers', 'variablemethod');
	}

	function beforeAddField__trackers__appendcode()
	{
		return $this->beforeAddField('trackers', 'appendcode');
	}

	function afterAddField__trackers__appendcode()
	{
		return $this->afterAddField('trackers', 'appendcode');
	}

	function beforeAddField__trackers__updated()
	{
		return $this->beforeAddField('trackers', 'updated');
	}

	function afterAddField__trackers__updated()
	{
		return $this->afterAddField('trackers', 'updated');
	}

}

?>