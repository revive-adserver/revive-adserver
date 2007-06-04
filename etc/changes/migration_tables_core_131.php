<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_131 extends Migration
{

    function Migration_131()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddIndex__affiliates__agencyid';
		$this->aTaskList_constructive[] = 'afterAddIndex__affiliates__agencyid';


    }



	function beforeAddIndex__affiliates__agencyid()
	{
		return $this->beforeAddIndex('affiliates', 'agencyid');
	}

	function afterAddIndex__affiliates__agencyid()
	{
		return $this->afterAddIndex('affiliates', 'agencyid');
	}

}

?>