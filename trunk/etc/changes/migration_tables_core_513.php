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

class Migration_513 extends Migration
{

    function Migration_513()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__preference__warn_limit_days';
		$this->aTaskList_constructive[] = 'afterAddField__preference__warn_limit_days';


		$this->aObjectMap['preference']['warn_limit_days'] = array('fromTable'=>'preference', 'fromField'=>'warn_limit_days');
    }



	function beforeAddField__preference__warn_limit_days()
	{
		return $this->beforeAddField('preference', 'warn_limit_days');
	}

	function afterAddField__preference__warn_limit_days()
	{
		return $this->afterAddField('preference', 'warn_limit_days');
	}

}

?>