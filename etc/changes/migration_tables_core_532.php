<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_532 extends Migration
{

    function Migration_532()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__clients__oac_adnetwork_id';
		$this->aTaskList_constructive[] = 'afterAddField__clients__oac_adnetwork_id';


		$this->aObjectMap['clients']['oac_adnetwork_id'] = array('fromTable'=>'clients', 'fromField'=>'oac_adnetwork_id');
    }



	function beforeAddField__clients__oac_adnetwork_id()
	{
		return $this->beforeAddField('clients', 'oac_adnetwork_id');
	}

	function afterAddField__clients__oac_adnetwork_id()
	{
		return $this->afterAddField('clients', 'oac_adnetwork_id');
	}

}

?>