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

class Migration_331 extends Migration
{

    function Migration_331()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddIndex__affiliates__agencyid';
		$this->aTaskList_constructive[] = 'afterAddIndex__affiliates__agencyid';
		$this->aTaskList_constructive[] = 'beforeAddIndex__campaigns__clientid';
		$this->aTaskList_constructive[] = 'afterAddIndex__campaigns__clientid';
		$this->aTaskList_constructive[] = 'beforeAddIndex__clients__agencyid';
		$this->aTaskList_constructive[] = 'afterAddIndex__clients__agencyid';
		$this->aTaskList_constructive[] = 'beforeAddIndex__trackers__clientid';
		$this->aTaskList_constructive[] = 'afterAddIndex__trackers__clientid';
		$this->aTaskList_constructive[] = 'beforeAddIndex__variables__variables_is_unique';
		$this->aTaskList_constructive[] = 'afterAddIndex__variables__variables_is_unique';
		$this->aTaskList_constructive[] = 'beforeAddIndex__variables__trackerid';
		$this->aTaskList_constructive[] = 'afterAddIndex__variables__trackerid';
		$this->aTaskList_constructive[] = 'beforeAddIndex__zones__affiliateid';
		$this->aTaskList_constructive[] = 'afterAddIndex__zones__affiliateid';


    }



	function beforeAddIndex__affiliates__agencyid()
	{
		return $this->beforeAddIndex('affiliates', 'agencyid');
	}

	function afterAddIndex__affiliates__agencyid()
	{
		return $this->afterAddIndex('affiliates', 'agencyid');
	}

	function beforeAddIndex__campaigns__clientid()
	{
		return $this->beforeAddIndex('campaigns', 'clientid');
	}

	function afterAddIndex__campaigns__clientid()
	{
		return $this->afterAddIndex('campaigns', 'clientid');
	}

	function beforeAddIndex__clients__agencyid()
	{
		return $this->beforeAddIndex('clients', 'agencyid');
	}

	function afterAddIndex__clients__agencyid()
	{
		return $this->afterAddIndex('clients', 'agencyid');
	}

	function beforeAddIndex__trackers__clientid()
	{
		return $this->beforeAddIndex('trackers', 'clientid');
	}

	function afterAddIndex__trackers__clientid()
	{
		return $this->afterAddIndex('trackers', 'clientid');
	}

	function beforeAddIndex__variables__variables_is_unique()
	{
		return $this->beforeAddIndex('variables', 'variables_is_unique');
	}

	function afterAddIndex__variables__variables_is_unique()
	{
		return $this->afterAddIndex('variables', 'variables_is_unique');
	}

	function beforeAddIndex__variables__trackerid()
	{
		return $this->beforeAddIndex('variables', 'trackerid');
	}

	function afterAddIndex__variables__trackerid()
	{
		return $this->afterAddIndex('variables', 'trackerid');
	}

	function beforeAddIndex__zones__affiliateid()
	{
		return $this->beforeAddIndex('zones', 'affiliateid');
	}

	function afterAddIndex__zones__affiliateid()
	{
		return $this->afterAddIndex('zones', 'affiliateid');
	}

}

?>