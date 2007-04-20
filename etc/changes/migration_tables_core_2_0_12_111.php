<?php

require_once(MAX_PATH.'/www/devel/lib/openads/Migration.php');

class Migration_111 extends Migration
{

    function Migration_111()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__log_maintenance_forecasting';
		$this->aTaskList_constructive[] = 'afterAddTable__log_maintenance_forecasting';
		$this->aTaskList_constructive[] = 'beforeAddTable__log_maintenance_priority';
		$this->aTaskList_constructive[] = 'afterAddTable__log_maintenance_priority';
		$this->aTaskList_constructive[] = 'beforeAddTable__log_maintenance_statistics';
		$this->aTaskList_constructive[] = 'afterAddTable__log_maintenance_statistics';


    }



	function beforeAddTable__log_maintenance_forecasting()
	{
		return $this->beforeAddTable('log_maintenance_forecasting');
	}

	function afterAddTable__log_maintenance_forecasting()
	{
		return $this->afterAddTable('log_maintenance_forecasting');
	}

	function beforeAddTable__log_maintenance_priority()
	{
		return $this->beforeAddTable('log_maintenance_priority');
	}

	function afterAddTable__log_maintenance_priority()
	{
		return $this->afterAddTable('log_maintenance_priority');
	}

	function beforeAddTable__log_maintenance_statistics()
	{
		return $this->beforeAddTable('log_maintenance_statistics');
	}

	function afterAddTable__log_maintenance_statistics()
	{
		return $this->afterAddTable('log_maintenance_statistics');
	}

}

?>