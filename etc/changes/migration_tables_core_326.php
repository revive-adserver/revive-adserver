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
$Id$
*/

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_326 extends Migration
{

    function Migration_326()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__target_impression';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__target_impression';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__target_click';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__target_click';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__target_conversion';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__target_conversion';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__companion';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__companion';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__comments';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__comments';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__revenue';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__revenue';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__revenue_type';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__revenue_type';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__updated';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__updated';


		$this->aObjectMap['campaigns']['target_impression'] = array('fromTable'=>'campaigns', 'fromField'=>'target_impression');
		$this->aObjectMap['campaigns']['target_click'] = array('fromTable'=>'campaigns', 'fromField'=>'target_click');
		$this->aObjectMap['campaigns']['target_conversion'] = array('fromTable'=>'campaigns', 'fromField'=>'target_conversion');
		$this->aObjectMap['campaigns']['companion'] = array('fromTable'=>'campaigns', 'fromField'=>'companion');
		$this->aObjectMap['campaigns']['comments'] = array('fromTable'=>'campaigns', 'fromField'=>'comments');
		$this->aObjectMap['campaigns']['revenue'] = array('fromTable'=>'campaigns', 'fromField'=>'revenue');
		$this->aObjectMap['campaigns']['revenue_type'] = array('fromTable'=>'campaigns', 'fromField'=>'revenue_type');
		$this->aObjectMap['campaigns']['updated'] = array('fromTable'=>'campaigns', 'fromField'=>'updated');
    }



	function beforeAddField__campaigns__target_impression()
	{
		return $this->beforeAddField('campaigns', 'target_impression');
	}

	function afterAddField__campaigns__target_impression()
	{
		return $this->afterAddField('campaigns', 'target_impression');
	}

	function beforeAddField__campaigns__target_click()
	{
		return $this->beforeAddField('campaigns', 'target_click');
	}

	function afterAddField__campaigns__target_click()
	{
		return $this->afterAddField('campaigns', 'target_click');
	}

	function beforeAddField__campaigns__target_conversion()
	{
		return $this->beforeAddField('campaigns', 'target_conversion');
	}

	function afterAddField__campaigns__target_conversion()
	{
		return $this->afterAddField('campaigns', 'target_conversion');
	}

	function beforeAddField__campaigns__companion()
	{
		return $this->beforeAddField('campaigns', 'companion');
	}

	function afterAddField__campaigns__companion()
	{
		return $this->afterAddField('campaigns', 'companion');
	}

	function beforeAddField__campaigns__comments()
	{
		return $this->beforeAddField('campaigns', 'comments');
	}

	function afterAddField__campaigns__comments()
	{
		return $this->afterAddField('campaigns', 'comments');
	}

	function beforeAddField__campaigns__revenue()
	{
		return $this->beforeAddField('campaigns', 'revenue');
	}

	function afterAddField__campaigns__revenue()
	{
		return $this->afterAddField('campaigns', 'revenue');
	}

	function beforeAddField__campaigns__revenue_type()
	{
		return $this->beforeAddField('campaigns', 'revenue_type');
	}

	function afterAddField__campaigns__revenue_type()
	{
		return $this->afterAddField('campaigns', 'revenue_type');
	}

	function beforeAddField__campaigns__updated()
	{
		return $this->beforeAddField('campaigns', 'updated');
	}

	function afterAddField__campaigns__updated()
	{
		return $this->afterAddField('campaigns', 'updated');
	}

}

?>