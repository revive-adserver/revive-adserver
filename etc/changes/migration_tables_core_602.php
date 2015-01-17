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

class Migration_602 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_destructive[] = 'beforeRemoveTable__lb_local';
		$this->aTaskList_destructive[] = 'afterRemoveTable__lb_local';
    }

	function beforeRemoveTable__lb_local()
	{
		return $this->beforeRemoveTable('lb_local');
	}

	function afterRemoveTable__lb_local()
	{
		return $this->afterRemoveTable('lb_local');
	}

}

?>