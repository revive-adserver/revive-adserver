<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_999 extends Migration
{

    function Migration_999()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__bandicoot';
		$this->aTaskList_constructive[] = 'afterAddTable__bandicoot';
		$this->aTaskList_constructive[] = 'beforeRenameField__campaigns__campaign_id';
		$this->aTaskList_constructive[] = 'afterRenameField__campaigns__campaign_id';
		$this->aTaskList_constructive[] = 'beforeAlterField__campaigns__fields';
		$this->aTaskList_constructive[] = 'afterAlterField__campaigns__fields';
		$this->aTaskList_constructive[] = 'beforeRemoveTable__affiliates';
		$this->aTaskList_constructive[] = 'afterRemoveTable__affiliates';


		$this->aObjectMap['campaigns']['campaign_id'] = array('fromTable'=>'campaigns', 'fromField'=>'campaignid');
    }



	function beforeAddTable__bandicoot()
	{
		return $this->beforeAddTable('bandicoot');
	}

	function afterAddTable__bandicoot()
	{
		return $this->afterAddTable('bandicoot');
	}

	function beforeRenameField__campaigns__campaign_id()
	{
		return $this->beforeRenameField('campaigns', 'campaign_id');
	}

	function afterRenameField__campaigns__campaign_id()
	{
		return $this->afterRenameField('campaigns', 'campaign_id');
	}

	function beforeAlterField__campaigns__fields()
	{
		return $this->beforeAlterField('campaigns', 'fields');
	}

	function afterAlterField__campaigns__fields()
	{
		return $this->afterAlterField('campaigns', 'fields');
	}

	function beforeRemoveTable__affiliates()
	{
		return $this->beforeRemoveTable('affiliates');
	}

	function afterRemoveTable__affiliates()
	{
		return $this->afterRemoveTable('affiliates');
	}

}

?>