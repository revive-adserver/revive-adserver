<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_606 extends Migration
{

    function Migration_606()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__ecpm';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__ecpm';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__min_impressions';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__min_impressions';


		$this->aObjectMap['campaigns']['ecpm'] = array('fromTable'=>'campaigns', 'fromField'=>'ecpm');
		$this->aObjectMap['campaigns']['min_impressions'] = array('fromTable'=>'campaigns', 'fromField'=>'min_impressions');
    }



	function beforeAddField__campaigns__ecpm()
	{
		return $this->beforeAddField('campaigns', 'ecpm');
	}

	function afterAddField__campaigns__ecpm()
	{
		return $this->afterAddField('campaigns', 'ecpm');
	}

	function beforeAddField__campaigns__min_impressions()
	{
		return $this->beforeAddField('campaigns', 'min_impressions');
	}

	function afterAddField__campaigns__min_impressions()
	{
		return $this->afterAddField('campaigns', 'min_impressions');
	}

}

?>