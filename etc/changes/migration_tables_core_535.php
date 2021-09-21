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

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_535 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_destructive[] = 'beforeRemoveTable__data_raw_tracker_click';
        $this->aTaskList_destructive[] = 'afterRemoveTable__data_raw_tracker_click';
    }



    public function beforeRemoveTable__data_raw_tracker_click()
    {
        return $this->beforeRemoveTable('data_raw_tracker_click');
    }

    public function afterRemoveTable__data_raw_tracker_click()
    {
        return $this->afterRemoveTable('data_raw_tracker_click');
    }
}
