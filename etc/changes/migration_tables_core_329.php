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

class Migration_329 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__campaigns_trackers__status';
        $this->aTaskList_constructive[] = 'afterAddField__campaigns_trackers__status';


        $this->aObjectMap['campaigns_trackers']['status'] = ['fromTable' => 'campaigns_trackers', 'fromField' => 'status'];
    }



    public function beforeAddField__campaigns_trackers__status()
    {
        return $this->beforeAddField('campaigns_trackers', 'status');
    }

    public function afterAddField__campaigns_trackers__status()
    {
        return $this->afterAddField('campaigns_trackers', 'status');
    }
}
