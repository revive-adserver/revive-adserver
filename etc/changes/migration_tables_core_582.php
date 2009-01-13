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

class Migration_582 extends Migration
{

    function Migration_582()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__clients__advertiser_limitation';
		$this->aTaskList_constructive[] = 'afterAddField__clients__advertiser_limitation';
		$this->aTaskList_constructive[] = 'beforeAddField__users__email_updated';
		$this->aTaskList_constructive[] = 'afterAddField__users__email_updated';


		$this->aObjectMap['clients']['advertiser_limitation'] = array('fromTable'=>'clients', 'fromField'=>'advertiser_limitation');
		$this->aObjectMap['users']['email_updated'] = array('fromTable'=>'users', 'fromField'=>'email_updated');
    }



	function beforeAddField__clients__advertiser_limitation()
	{
		return $this->beforeAddField('clients', 'advertiser_limitation');
	}

	function afterAddField__clients__advertiser_limitation()
	{
		return $this->afterAddField('clients', 'advertiser_limitation');
	}

	function beforeAddField__users__email_updated()
	{
		return $this->beforeAddField('users', 'email_updated');
	}

	function afterAddField__users__email_updated()
	{
		return $this->afterAddField('users', 'email_updated');
	}

}

?>