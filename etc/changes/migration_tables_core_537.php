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

class Migration_537 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__audit';
		$this->aTaskList_constructive[] = 'afterAddTable__audit';


    }



	function beforeAddTable__audit()
	{
		return $this->beforeAddTable('audit');
	}

	function afterAddTable__audit()
	{
		return $this->afterAddTable('audit');
	}

}

?>