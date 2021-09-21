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

class Migration_507 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_impression_history__data_summary_zone_impression_history_zone_id';
        $this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_impression_history__data_summary_zone_impression_history_zone_id';
    }



    public function beforeAddIndex__data_summary_zone_impression_history__data_summary_zone_impression_history_zone_id()
    {
        return $this->beforeAddIndex('data_summary_zone_impression_history', 'data_summary_zone_impression_history_zone_id');
    }

    public function afterAddIndex__data_summary_zone_impression_history__data_summary_zone_impression_history_zone_id()
    {
        return $this->afterAddIndex('data_summary_zone_impression_history', 'data_summary_zone_impression_history_zone_id');
    }
}
