<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_535 extends Migration
{

    function Migration_535()
    {
        //$this->__construct();

		$this->aTaskList_destructive[] = 'beforeRemoveTable__data_raw_tracker_click';
		$this->aTaskList_destructive[] = 'afterRemoveTable__data_raw_tracker_click';


    }



	function beforeRemoveTable__data_raw_tracker_click()
	{
		return $this->beforeRemoveTable('data_raw_tracker_click');
	}

	function afterRemoveTable__data_raw_tracker_click()
	{
		return $this->afterRemoveTable('data_raw_tracker_click');
	}

}

?>