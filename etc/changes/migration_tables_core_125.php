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

class Migration_125 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__preference__maintenance_cron_timestamp';
		$this->aTaskList_constructive[] = 'afterAddField__preference__maintenance_cron_timestamp';


		$this->aObjectMap['preference']['maintenance_cron_timestamp'] = array('fromTable'=>'preference', 'fromField'=>'maintenance_cron_timestamp');
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