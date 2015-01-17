<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_619 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_destructive[] = 'beforeRemoveField__zones__as_zone_id';
		$this->aTaskList_destructive[] = 'afterRemoveField__zones__as_zone_id';
		$this->aTaskList_destructive[] = 'beforeRemoveField__zones__is_in_ad_direct';
		$this->aTaskList_destructive[] = 'afterRemoveField__zones__is_in_ad_direct';


    }



	function beforeRemoveField__zones__as_zone_id()
	{
		return $this->beforeRemoveField('zones', 'as_zone_id');
	}

	function afterRemoveField__zones__as_zone_id()
	{
		return $this->afterRemoveField('zones', 'as_zone_id');
	}

	function beforeRemoveField__zones__is_in_ad_direct()
	{
		return $this->beforeRemoveField('zones', 'is_in_ad_direct');
	}

	function afterRemoveField__zones__is_in_ad_direct()
	{
		return $this->afterRemoveField('zones', 'is_in_ad_direct');
	}

}

?>