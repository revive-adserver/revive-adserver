<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_121 extends Migration
{

    function Migration_121()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAlterField__acls__type';
		$this->aTaskList_constructive[] = 'afterAlterField__acls__type';


    }



	function beforeAlterField__acls__type()
	{
		return $this->beforeAlterField('acls', 'type');
	}

	function afterAlterField__acls__type()
	{
		return $this->afterAlterField('acls', 'type');
	}

}

?>