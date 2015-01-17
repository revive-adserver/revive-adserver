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

class Migration_001 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__banners_demo';
		$this->aTaskList_constructive[] = 'afterAddTable__banners_demo';


    }



	function beforeAddTable__banners_demo()
	{
		return $this->beforeAddTable('banners_demo');
	}

	function afterAddTable__banners_demo()
	{
		return $this->afterAddTable('banners_demo');
	}

}

?>