<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_610 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__zones__ext_adselection';
		$this->aTaskList_constructive[] = 'afterAddField__zones__ext_adselection';


		$this->aObjectMap['zones']['ext_adselection'] = array('fromTable'=>'zones', 'fromField'=>'ext_adselection');
    }



	function beforeAddField__zones__ext_adselection()
	{
		return $this->beforeAddField('zones', 'ext_adselection');
	}

	function afterAddField__zones__ext_adselection()
	{
		return $this->afterAddField('zones', 'ext_adselection');
	}

}

?>