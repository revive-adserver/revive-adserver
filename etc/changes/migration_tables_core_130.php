<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_130 extends Migration
{

    function Migration_130()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAlterField__acls__logical';
		$this->aTaskList_constructive[] = 'afterAlterField__acls__logical';


    }



	function beforeAlterField__acls__logical()
	{
		return $this->beforeAlterField('acls', 'logical');
	}

	function afterAlterField__acls__logical()
	{
		return $this->afterAlterField('acls', 'logical');
	}

}

?>