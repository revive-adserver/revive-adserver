<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';

class Migration_531 extends Migration
{

    function Migration_531()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__affiliates__oac_website_id';
		$this->aTaskList_constructive[] = 'afterAddField__affiliates__oac_website_id';
		$this->aTaskList_constructive[] = 'beforeAddField__banners__oac_banner_id';
		$this->aTaskList_constructive[] = 'afterAddField__banners__oac_banner_id';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__oac_campaign_id';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__oac_campaign_id';
		$this->aTaskList_destructive[] = 'beforeRemoveField__preference__instance_id';
		$this->aTaskList_destructive[] = 'afterRemoveField__preference__instance_id';


		$this->aObjectMap['affiliates']['oac_website_id'] = array('fromTable'=>'affiliates', 'fromField'=>'oac_website_id');
		$this->aObjectMap['banners']['oac_banner_id'] = array('fromTable'=>'banners', 'fromField'=>'oac_banner_id');
		$this->aObjectMap['campaigns']['oac_campaign_id'] = array('fromTable'=>'campaigns', 'fromField'=>'oac_campaign_id');
    }



	function beforeAddField__affiliates__oac_website_id()
	{
		return $this->beforeAddField('affiliates', 'oac_website_id');
	}

	function afterAddField__affiliates__oac_website_id()
	{
		return $this->afterAddField('affiliates', 'oac_website_id');
	}

	function beforeAddField__banners__oac_banner_id()
	{
		return $this->beforeAddField('banners', 'oac_banner_id');
	}

	function afterAddField__banners__oac_banner_id()
	{
		return $this->afterAddField('banners', 'oac_banner_id');
	}

	function beforeAddField__campaigns__oac_campaign_id()
	{
		return $this->beforeAddField('campaigns', 'oac_campaign_id');
	}

	function afterAddField__campaigns__oac_campaign_id()
	{
		return $this->afterAddField('campaigns', 'oac_campaign_id');
	}

	function beforeRemoveField__preference__instance_id()
	{
		return $this->migrateInstanceId() && $this->beforeRemoveField('preference', 'instance_id');
	}

	function afterRemoveField__preference__instance_id()
	{
		return $this->afterRemoveField('preference', 'instance_id');
	}

	function migrateInstanceId()
	{
	    $doPreference = OA_Dal::factoryDO('preference');
	    $doPreference->agencyid = 0;
	    $doPreference->find();

	    if (!$doPreference->fetch()) {
	       return $this->_logErrorAndReturnFalse("Couldn't find instance_id");
	    }

	    if (!OA_Dal_ApplicationVariables::set('platform_hash', $doPreference->instance_id)) {
	       return $this->_logErrorAndReturnFalse("Couldn't not migrate Instance ID to Platform Hash");
	    }

	    return true;
	}
}

?>
