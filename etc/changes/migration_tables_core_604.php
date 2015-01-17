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

class Migration_604 extends Migration
{

    function __construct()
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