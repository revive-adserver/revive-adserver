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

class Migration_100 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddTable__lb_local';
        $this->aTaskList_constructive[] = 'afterAddTable__lb_local';
        $this->aTaskList_constructive[] = 'beforeAddField__clients__lb_reporting';
        $this->aTaskList_constructive[] = 'afterAddField__clients__lb_reporting';


        $this->aObjectMap['clients']['lb_reporting'] = ['fromTable' => 'clients', 'fromField' => 'lb_reporting'];
    }



    public function beforeAddTable__lb_local()
    {
        return $this->beforeAddTable('lb_local');
    }

    public function afterAddTable__lb_local()
    {
        return $this->afterAddTable('lb_local');
    }

    public function beforeAddField__clients__lb_reporting()
    {
        return $this->beforeAddField('clients', 'lb_reporting');
    }

    public function afterAddField__clients__lb_reporting()
    {
        return $this->afterAddField('clients', 'lb_reporting');
    }
}
