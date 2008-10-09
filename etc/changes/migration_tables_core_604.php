<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_604 extends Migration
{

    function Migration_604()
    {
        //$this->__construct();

		$this->aTaskList_destructive[] = 'beforeRemoveField__banners__autohtml';
		$this->aTaskList_destructive[] = 'afterRemoveField__banners__autohtml';


    }



	function beforeRemoveField__banners__autohtml()
	{
		return $this->beforeRemoveField('banners', 'autohtml');
	}

	function afterRemoveField__banners__autohtml()
	{
		return $this->afterRemoveField('banners', 'autohtml');
	}

}

?>