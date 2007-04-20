<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_117 extends Migration
{

    function Migration_117()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__ad_zone_assoc';
		$this->aTaskList_constructive[] = 'afterAddTable__ad_zone_assoc';
		$this->aTaskList_constructive[] = 'beforeAddTable__placement_zone_assoc';
		$this->aTaskList_constructive[] = 'afterAddTable__placement_zone_assoc';


    }



	function beforeAddTable__ad_zone_assoc()
	{
		return $this->beforeAddTable('ad_zone_assoc');
	}

	function afterAddTable__ad_zone_assoc()
	{
		return $this->afterAddTable('ad_zone_assoc');
	}

	function beforeAddTable__placement_zone_assoc()
	{
		return $this->beforeAddTable('placement_zone_assoc');
	}

	function afterAddTable__placement_zone_assoc()
	{
		return $this->afterAddTable('placement_zone_assoc');
	}

}

?>