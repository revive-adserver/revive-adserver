<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_616 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_destructive[] = 'beforeRemoveField__banners__an_banner_id';
		$this->aTaskList_destructive[] = 'afterRemoveField__banners__an_banner_id';
		$this->aTaskList_destructive[] = 'beforeRemoveField__banners__as_banner_id';
		$this->aTaskList_destructive[] = 'afterRemoveField__banners__as_banner_id';
		$this->aTaskList_destructive[] = 'beforeRemoveField__banners__ad_direct_status';
		$this->aTaskList_destructive[] = 'afterRemoveField__banners__ad_direct_status';
		$this->aTaskList_destructive[] = 'beforeRemoveField__banners__ad_direct_rejection_reason_id';
		$this->aTaskList_destructive[] = 'afterRemoveField__banners__ad_direct_rejection_reason_id';


    }



	function beforeRemoveField__banners__an_banner_id()
	{
		return $this->beforeRemoveField('banners', 'an_banner_id');
	}

	function afterRemoveField__banners__an_banner_id()
	{
		return $this->afterRemoveField('banners', 'an_banner_id');
	}

	function beforeRemoveField__banners__as_banner_id()
	{
		return $this->beforeRemoveField('banners', 'as_banner_id');
	}

	function afterRemoveField__banners__as_banner_id()
	{
		return $this->afterRemoveField('banners', 'as_banner_id');
	}

	function beforeRemoveField__banners__ad_direct_status()
	{
		return $this->beforeRemoveField('banners', 'ad_direct_status');
	}

	function afterRemoveField__banners__ad_direct_status()
	{
		return $this->afterRemoveField('banners', 'ad_direct_status');
	}

	function beforeRemoveField__banners__ad_direct_rejection_reason_id()
	{
		return $this->beforeRemoveField('banners', 'ad_direct_rejection_reason_id');
	}

	function afterRemoveField__banners__ad_direct_rejection_reason_id()
	{
		return $this->afterRemoveField('banners', 'ad_direct_rejection_reason_id');
	}

}

?>