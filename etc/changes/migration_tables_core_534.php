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

class Migration_534 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__data_summary_zone_impression_history__est';
        $this->aTaskList_constructive[] = 'afterAddField__data_summary_zone_impression_history__est';


        $this->aObjectMap['data_summary_zone_impression_history']['est'] = ['fromTable' => 'data_summary_zone_impression_history', 'fromField' => 'est'];
    }



    public function beforeAddField__data_summary_zone_impression_history__est()
    {
        return $this->beforeAddField('data_summary_zone_impression_history', 'est');
    }

    public function afterAddField__data_summary_zone_impression_history__est()
    {
        return $this->afterAddField('data_summary_zone_impression_history', 'est');
    }
}
