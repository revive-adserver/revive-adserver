<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_542 extends Migration
{

    function Migration_542()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__as_reject_reason';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__as_reject_reason';


		$this->aObjectMap['campaigns']['as_reject_reason'] = array('fromTable'=>'campaigns', 'fromField'=>'as_reject_reason');
    }



	function beforeAddField__campaigns__as_reject_reason()
	{
		return $this->beforeAddField('campaigns', 'as_reject_reason');
	}

	function afterAddField__campaigns__as_reject_reason()
	{
		return $this->afterAddField('campaigns', 'as_reject_reason');
	}

}

?>