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

class Migration_002 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__stats_country';
		$this->aTaskList_constructive[] = 'afterAddTable__stats_country';


    }



	function beforeAddTable__stats_country()
	{
		return $this->beforeAddTable('stats_country');
	}

	function afterAddTable__stats_country()
	{
		return $this->afterAddTable('stats_country');
	}

}

?>