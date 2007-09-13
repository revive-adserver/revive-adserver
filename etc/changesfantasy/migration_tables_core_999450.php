<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_999450 extends Migration
{

    function Migration_999450()
    {
        //$this->__construct();

		$this->aTaskList_destructive[] = 'beforeRenameTable__klapaucius';
		$this->aTaskList_destructive[] = 'afterRenameTable__klapaucius';


    }

	function beforeRenameTable__klapaucius()
	{
		return $this->beforeRenameTable('klapaucius');
	}

	function afterRenameTable__klapaucius()
	{
		return $this->afterRenameTable('klapaucius');
	}

}

?>