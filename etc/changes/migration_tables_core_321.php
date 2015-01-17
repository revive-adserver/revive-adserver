<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_321 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAlterField__acls__type';
		$this->aTaskList_constructive[] = 'afterAlterField__acls__type';
		$this->aTaskList_constructive[] = 'beforeAlterField__acls__logical';
		$this->aTaskList_constructive[] = 'afterAlterField__acls__logical';


    }



	function beforeAlterField__acls__type()
	{
		return $this->beforeAlterField('acls', 'type');
	}

	function afterAlterField__acls__type()
	{
		return $this->afterAlterField('acls', 'type');
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