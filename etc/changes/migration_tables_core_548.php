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

class Migration_548 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__audit__account_id';
        $this->aTaskList_constructive[] = 'afterAddField__audit__account_id';
        $this->aTaskList_constructive[] = 'beforeAddIndex__audit__account_id';
        $this->aTaskList_constructive[] = 'afterAddIndex__audit__account_id';


        $this->aObjectMap['audit']['account_id'] = ['fromTable' => 'audit', 'fromField' => 'account_id'];
    }



    public function beforeAddField__audit__account_id()
    {
        return $this->beforeAddField('audit', 'account_id');
    }

    public function afterAddField__audit__account_id()
    {
        return $this->afterAddField('audit', 'account_id');
    }

    public function beforeAddIndex__audit__account_id()
    {
        return $this->beforeAddIndex('audit', 'account_id');
    }

    public function afterAddIndex__audit__account_id()
    {
        return $this->afterAddIndex('audit', 'account_id');
    }
}
