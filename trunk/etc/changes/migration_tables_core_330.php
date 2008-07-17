<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

class Migration_330 extends Migration
{

    function Migration_330()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__variables__purpose';
		$this->aTaskList_constructive[] = 'afterAddField__variables__purpose';
		$this->aTaskList_constructive[] = 'beforeAddField__variables__reject_if_empty';
		$this->aTaskList_constructive[] = 'afterAddField__variables__reject_if_empty';
		$this->aTaskList_constructive[] = 'beforeAddField__variables__is_unique';
		$this->aTaskList_constructive[] = 'afterAddField__variables__is_unique';
		$this->aTaskList_constructive[] = 'beforeAddField__variables__unique_window';
		$this->aTaskList_constructive[] = 'afterAddField__variables__unique_window';
		$this->aTaskList_constructive[] = 'beforeAddField__variables__variablecode';
		$this->aTaskList_constructive[] = 'afterAddField__variables__variablecode';
		$this->aTaskList_constructive[] = 'beforeAddField__variables__hidden';
		$this->aTaskList_constructive[] = 'afterAddField__variables__hidden';
		$this->aTaskList_constructive[] = 'beforeAddField__variables__updated';
		$this->aTaskList_constructive[] = 'afterAddField__variables__updated';


		$this->aObjectMap['variables']['purpose'] = array('fromTable'=>'variables', 'fromField'=>'purpose');
		$this->aObjectMap['variables']['reject_if_empty'] = array('fromTable'=>'variables', 'fromField'=>'reject_if_empty');
		$this->aObjectMap['variables']['is_unique'] = array('fromTable'=>'variables', 'fromField'=>'is_unique');
		$this->aObjectMap['variables']['unique_window'] = array('fromTable'=>'variables', 'fromField'=>'unique_window');
		$this->aObjectMap['variables']['variablecode'] = array('fromTable'=>'variables', 'fromField'=>'variablecode');
		$this->aObjectMap['variables']['hidden'] = array('fromTable'=>'variables', 'fromField'=>'hidden');
		$this->aObjectMap['variables']['updated'] = array('fromTable'=>'variables', 'fromField'=>'updated');
    }



	function beforeAddField__variables__purpose()
	{
		return $this->beforeAddField('variables', 'purpose');
	}

	function afterAddField__variables__purpose()
	{
		return $this->afterAddField('variables', 'purpose');
	}

	function beforeAddField__variables__reject_if_empty()
	{
		return $this->beforeAddField('variables', 'reject_if_empty');
	}

	function afterAddField__variables__reject_if_empty()
	{
		return $this->afterAddField('variables', 'reject_if_empty');
	}

	function beforeAddField__variables__is_unique()
	{
		return $this->beforeAddField('variables', 'is_unique');
	}

	function afterAddField__variables__is_unique()
	{
		return $this->afterAddField('variables', 'is_unique');
	}

	function beforeAddField__variables__unique_window()
	{
		return $this->beforeAddField('variables', 'unique_window');
	}

	function afterAddField__variables__unique_window()
	{
		return $this->afterAddField('variables', 'unique_window');
	}

	function beforeAddField__variables__variablecode()
	{
		return $this->beforeAddField('variables', 'variablecode');
	}

	function afterAddField__variables__variablecode()
	{
		return $this->afterAddField('variables', 'variablecode');
	}

	function beforeAddField__variables__hidden()
	{
		return $this->beforeAddField('variables', 'hidden');
	}

	function afterAddField__variables__hidden()
	{
		return $this->afterAddField('variables', 'hidden');
	}

	function beforeAddField__variables__updated()
	{
		return $this->beforeAddField('variables', 'updated');
	}

	function afterAddField__variables__updated()
	{
		return $this->afterAddField('variables', 'updated');
	}

}

?>