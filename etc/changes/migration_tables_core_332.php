<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_332 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__lb_local';
		$this->aTaskList_constructive[] = 'afterAddTable__lb_local';
		$this->aTaskList_constructive[] = 'beforeAddField__banners__transparent';
		$this->aTaskList_constructive[] = 'afterAddField__banners__transparent';
		$this->aTaskList_constructive[] = 'beforeAddField__clients__lb_reporting';
		$this->aTaskList_constructive[] = 'afterAddField__clients__lb_reporting';
		$this->aTaskList_constructive[] = 'beforeAddField__preference__maintenance_cron_timestamp';
		$this->aTaskList_constructive[] = 'afterAddField__preference__maintenance_cron_timestamp';


		$this->aObjectMap['banners']['transparent'] = array('fromTable'=>'banners', 'fromField'=>'transparent');
		$this->aObjectMap['clients']['lb_reporting'] = array('fromTable'=>'clients', 'fromField'=>'lb_reporting');
		$this->aObjectMap['preference']['maintenance_cron_timestamp'] = array('fromTable'=>'preference', 'fromField'=>'maintenance_cron_timestamp');
    }



	function beforeAddTable__lb_local()
	{
		return $this->beforeAddTable('lb_local');
	}

	function afterAddTable__lb_local()
	{
		return $this->afterAddTable('lb_local');
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

}

?>