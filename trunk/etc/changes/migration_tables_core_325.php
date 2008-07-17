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

class Migration_325 extends Migration
{

    function Migration_325()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__agency__logout_url';
		$this->aTaskList_constructive[] = 'afterAddField__agency__logout_url';
		$this->aTaskList_constructive[] = 'beforeAddField__agency__active';
		$this->aTaskList_constructive[] = 'afterAddField__agency__active';
		$this->aTaskList_constructive[] = 'beforeAddField__agency__updated';
		$this->aTaskList_constructive[] = 'afterAddField__agency__updated';


		$this->aObjectMap['agency']['logout_url'] = array('fromTable'=>'agency', 'fromField'=>'logout_url');
		$this->aObjectMap['agency']['active'] = array('fromTable'=>'agency', 'fromField'=>'active');
		$this->aObjectMap['agency']['updated'] = array('fromTable'=>'agency', 'fromField'=>'updated');
    }



	function beforeAddField__agency__logout_url()
	{
		return $this->beforeAddField('agency', 'logout_url');
	}

	function afterAddField__agency__logout_url()
	{
		return $this->afterAddField('agency', 'logout_url');
	}

	function beforeAddField__agency__active()
	{
		return $this->beforeAddField('agency', 'active');
	}

	function afterAddField__agency__active()
	{
		return $this->afterAddField('agency', 'active');
	}

	function beforeAddField__agency__updated()
	{
		return $this->beforeAddField('agency', 'updated');
	}

	function afterAddField__agency__updated()
	{
		return $this->afterAddField('agency', 'updated');
	}

}

?>