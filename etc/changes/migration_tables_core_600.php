<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_600 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__banners__ext_bannertype';
		$this->aTaskList_constructive[] = 'afterAddField__banners__ext_bannertype';


		$this->aObjectMap['banners']['ext_bannertype'] = array('fromTable'=>'banners', 'fromField'=>'ext_bannertype');
    }



	function beforeAddField__banners__ext_bannertype()
	{
		return $this->beforeAddField('banners', 'ext_bannertype');
	}

	function afterAddField__banners__ext_bannertype()
	{
		return $this->afterAddField('banners', 'ext_bannertype');
	}

	function beforeRemoveTable__plugins_channel_delivery_assoc()
	{
		return $this->beforeRemoveTable('plugins_channel_delivery_assoc');
	}

	function afterRemoveTable__plugins_channel_delivery_assoc()
	{
		return $this->afterRemoveTable('plugins_channel_delivery_assoc');
	}

	function beforeRemoveTable__plugins_channel_delivery_domains()
	{
		return $this->beforeRemoveTable('plugins_channel_delivery_domains');
	}

	function afterRemoveTable__plugins_channel_delivery_domains()
	{
		return $this->afterRemoveTable('plugins_channel_delivery_domains');
	}

	function beforeRemoveTable__plugins_channel_delivery_rules()
	{
		return $this->beforeRemoveTable('plugins_channel_delivery_rules');
	}

	function afterRemoveTable__plugins_channel_delivery_rules()
	{
		return $this->afterRemoveTable('plugins_channel_delivery_rules');
	}

}

?>