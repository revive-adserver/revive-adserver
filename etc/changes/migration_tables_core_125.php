<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_125 extends Migration
{

    function Migration_125()
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