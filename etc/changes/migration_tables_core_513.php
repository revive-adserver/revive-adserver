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

class Migration_513 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__preference__warn_limit_days';
        $this->aTaskList_constructive[] = 'afterAddField__preference__warn_limit_days';


        $this->aObjectMap['preference']['warn_limit_days'] = ['fromTable' => 'preference', 'fromField' => 'warn_limit_days'];
    }



    public function beforeAddField__preference__warn_limit_days()
    {
        return $this->beforeAddField('preference', 'warn_limit_days');
    }

    public function afterAddField__preference__warn_limit_days()
    {
        return $this->afterAddField('preference', 'warn_limit_days');
    }
}
