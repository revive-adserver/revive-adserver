<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_100 extends Migration
{

    function Migration_100()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__lb_local';
		$this->aTaskList_constructive[] = 'afterAddTable__lb_local';
		$this->aTaskList_constructive[] = 'beforeAddField__clients__lb_reporting';
		$this->aTaskList_constructive[] = 'afterAddField__clients__lb_reporting';


		$this->aObjectMap['clients']['lb_reporting'] = array('fromTable'=>'clients', 'fromField'=>'lb_reporting');
    }



	function beforeAddTable__lb_local()
	{
		return $this->beforeAddTable('lb_local');
	}

	function afterAddTable__lb_local()
	{
		return $this->afterAddTable('lb_local');
	}

	function beforeAddField__clients__lb_reporting()
	{
		return $this->beforeAddField('clients', 'lb_reporting');
	}

	function afterAddField__clients__lb_reporting()
	{
		return $this->afterAddField('clients', 'lb_reporting');
	}

}

?>
