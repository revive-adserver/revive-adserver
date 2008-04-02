<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_582 extends Migration
{

    function Migration_582()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__clients__advertiser_limitation';
		$this->aTaskList_constructive[] = 'afterAddField__clients__advertiser_limitation';


		$this->aObjectMap['clients']['advertiser_limitation'] = array('fromTable'=>'clients', 'fromField'=>'advertiser_limitation');
    }



	function beforeAddField__clients__advertiser_limitation()
	{
		return $this->beforeAddField('clients', 'advertiser_limitation');
	}

	function afterAddField__clients__advertiser_limitation()
	{
		return $this->afterAddField('clients', 'advertiser_limitation');
	}

}

?>