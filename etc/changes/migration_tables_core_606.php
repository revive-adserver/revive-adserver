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

class Migration_606 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__campaigns__ecpm';
        $this->aTaskList_constructive[] = 'afterAddField__campaigns__ecpm';
        $this->aTaskList_constructive[] = 'beforeAddField__campaigns__min_impressions';
        $this->aTaskList_constructive[] = 'afterAddField__campaigns__min_impressions';


        $this->aObjectMap['campaigns']['ecpm'] = ['fromTable' => 'campaigns', 'fromField' => 'ecpm'];
        $this->aObjectMap['campaigns']['min_impressions'] = ['fromTable' => 'campaigns', 'fromField' => 'min_impressions'];
    }



    public function beforeAddField__campaigns__ecpm()
    {
        return $this->beforeAddField('campaigns', 'ecpm');
    }

    public function afterAddField__campaigns__ecpm()
    {
        return $this->afterAddField('campaigns', 'ecpm');
    }

    public function beforeAddField__campaigns__min_impressions()
    {
        return $this->beforeAddField('campaigns', 'min_impressions');
    }

    public function afterAddField__campaigns__min_impressions()
    {
        return $this->afterAddField('campaigns', 'min_impressions');
    }
}
