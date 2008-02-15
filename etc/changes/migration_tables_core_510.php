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

class Migration_510 extends Migration
{

    function Migration_510()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__lb_local';
		$this->aTaskList_constructive[] = 'afterAddTable__lb_local';
		$this->aTaskList_constructive[] = 'beforeAddField__banners__keyword';
		$this->aTaskList_constructive[] = 'afterAddField__banners__keyword';
		$this->aTaskList_constructive[] = 'beforeAddField__banners__transparent';
		$this->aTaskList_constructive[] = 'afterAddField__banners__transparent';
		$this->aTaskList_constructive[] = 'beforeAddField__clients__lb_reporting';
		$this->aTaskList_constructive[] = 'afterAddField__clients__lb_reporting';
		$this->aTaskList_constructive[] = 'beforeAddField__preference__maintenance_cron_timestamp';
		$this->aTaskList_constructive[] = 'afterAddField__preference__maintenance_cron_timestamp';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__what';
		$this->aTaskList_constructive[] = 'afterAddField__zones__what';


		$this->aObjectMap['banners']['keyword'] = array('fromTable'=>'banners', 'fromField'=>'keyword');
		$this->aObjectMap['banners']['transparent'] = array('fromTable'=>'banners', 'fromField'=>'transparent');
		$this->aObjectMap['clients']['lb_reporting'] = array('fromTable'=>'clients', 'fromField'=>'lb_reporting');
		$this->aObjectMap['preference']['maintenance_cron_timestamp'] = array('fromTable'=>'preference', 'fromField'=>'maintenance_cron_timestamp');
		$this->aObjectMap['zones']['what'] = array('fromTable'=>'zones', 'fromField'=>'what');
    }



	function beforeAddTable__lb_local()
	{
		return $this->beforeAddTable('lb_local');
	}

	function afterAddTable__lb_local()
	{
		return $this->afterAddTable('lb_local');
	}

	function beforeAddField__banners__keyword()
	{
		return $this->beforeAddField('banners', 'keyword');
	}

	function afterAddField__banners__keyword()
	{
		return $this->afterAddField('banners', 'keyword');
	}

	function beforeAddField__banners__transparent()
	{
		return $this->beforeAddField('banners', 'transparent');
	}

	function afterAddField__banners__transparent()
	{
		return $this->afterAddField('banners', 'transparent');
	}

	function beforeAddField__clients__lb_reporting()
	{
		return $this->beforeAddField('clients', 'lb_reporting');
	}

	function afterAddField__clients__lb_reporting()
	{
		return $this->afterAddField('clients', 'lb_reporting');
	}

	function beforeAddField__preference__maintenance_cron_timestamp()
	{
		return $this->beforeAddField('preference', 'maintenance_cron_timestamp');
	}

	function afterAddField__preference__maintenance_cron_timestamp()
	{
		return $this->afterAddField('preference', 'maintenance_cron_timestamp');
	}

	function beforeAddField__zones__what()
	{
		return $this->beforeAddField('zones', 'what');
	}

	function afterAddField__zones__what()
	{
		return $this->afterAddField('zones', 'what');
	}

}

?>