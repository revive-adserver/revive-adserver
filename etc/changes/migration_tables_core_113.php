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

class Migration_113 extends Migration
{

    function Migration_113()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__agency';
		$this->aTaskList_constructive[] = 'afterAddTable__agency';


    }



	function beforeAddTable__agency()
	{
		return $this->beforeAddTable('agency');
	}

	function afterAddTable__agency()
	{
		return $this->afterAddTable('agency');
	}

}

?>