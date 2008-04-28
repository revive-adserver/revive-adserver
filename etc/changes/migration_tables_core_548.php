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

class Migration_548 extends Migration
{

    function Migration_548()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__audit__account_id';
		$this->aTaskList_constructive[] = 'afterAddField__audit__account_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__audit__account_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__audit__account_id';


		$this->aObjectMap['audit']['account_id'] = array('fromTable'=>'audit', 'fromField'=>'account_id');
    }



	function beforeAddField__audit__account_id()
	{
		return $this->beforeAddField('audit', 'account_id');
	}

	function afterAddField__audit__account_id()
	{
		return $this->afterAddField('audit', 'account_id');
	}

	function beforeAddIndex__audit__account_id()
	{
		return $this->beforeAddIndex('audit', 'account_id');
	}

	function afterAddIndex__audit__account_id()
	{
		return $this->afterAddIndex('audit', 'account_id');
	}

}

?>