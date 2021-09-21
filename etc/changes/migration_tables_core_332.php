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

class Migration_332 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddTable__lb_local';
        $this->aTaskList_constructive[] = 'afterAddTable__lb_local';
        $this->aTaskList_constructive[] = 'beforeAddField__banners__transparent';
        $this->aTaskList_constructive[] = 'afterAddField__banners__transparent';
        $this->aTaskList_constructive[] = 'beforeAddField__clients__lb_reporting';
        $this->aTaskList_constructive[] = 'afterAddField__clients__lb_reporting';
        $this->aTaskList_constructive[] = 'beforeAddField__preference__maintenance_cron_timestamp';
        $this->aTaskList_constructive[] = 'afterAddField__preference__maintenance_cron_timestamp';


        $this->aObjectMap['banners']['transparent'] = ['fromTable' => 'banners', 'fromField' => 'transparent'];
        $this->aObjectMap['clients']['lb_reporting'] = ['fromTable' => 'clients', 'fromField' => 'lb_reporting'];
        $this->aObjectMap['preference']['maintenance_cron_timestamp'] = ['fromTable' => 'preference', 'fromField' => 'maintenance_cron_timestamp'];
    }



    public function beforeAddTable__lb_local()
    {
        return $this->beforeAddTable('lb_local');
    }

    public function afterAddTable__lb_local()
    {
        return $this->afterAddTable('lb_local');
    }

    public function beforeAddField__banners__transparent()
    {
        return $this->beforeAddField('banners', 'transparent');
    }

    public function afterAddField__banners__transparent()
    {
        return $this->afterAddField('banners', 'transparent');
    }

    public function beforeAddField__clients__lb_reporting()
    {
        return $this->beforeAddField('clients', 'lb_reporting');
    }

    public function afterAddField__clients__lb_reporting()
    {
        return $this->afterAddField('clients', 'lb_reporting');
    }

    public function beforeAddField__preference__maintenance_cron_timestamp()
    {
        return $this->beforeAddField('preference', 'maintenance_cron_timestamp');
    }

    public function afterAddField__preference__maintenance_cron_timestamp()
    {
        return $this->afterAddField('preference', 'maintenance_cron_timestamp');
    }
}
