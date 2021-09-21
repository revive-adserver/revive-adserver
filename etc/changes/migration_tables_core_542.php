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

class Migration_542 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__campaigns__as_reject_reason';
        $this->aTaskList_constructive[] = 'afterAddField__campaigns__as_reject_reason';


        $this->aObjectMap['campaigns']['as_reject_reason'] = ['fromTable' => 'campaigns', 'fromField' => 'as_reject_reason'];
    }



    public function beforeAddField__campaigns__as_reject_reason()
    {
        return $this->beforeAddField('campaigns', 'as_reject_reason');
    }

    public function afterAddField__campaigns__as_reject_reason()
    {
        return $this->afterAddField('campaigns', 'as_reject_reason');
    }
}
