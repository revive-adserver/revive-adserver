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

		$this->aTaskList_destructive[] = 'beforeRemoveTable__data_bkt_m_backup';
		$this->aTaskList_destructive[] = 'afterRemoveTable__data_bkt_m_backup';


    }



	function beforeRemoveTable__data_bkt_m_backup()
	{
		return $this->beforeRemoveTable('data_bkt_m_backup');
	}

	function afterRemoveTable__data_bkt_m_backup()
	{
		return $this->afterRemoveTable('data_bkt_m_backup');
	}

}

?>