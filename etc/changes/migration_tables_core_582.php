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

class Migration_582 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__clients__advertiser_limitation';
        $this->aTaskList_constructive[] = 'afterAddField__clients__advertiser_limitation';
        $this->aTaskList_constructive[] = 'beforeAddField__users__email_updated';
        $this->aTaskList_constructive[] = 'afterAddField__users__email_updated';


        $this->aObjectMap['clients']['advertiser_limitation'] = ['fromTable' => 'clients', 'fromField' => 'advertiser_limitation'];
        $this->aObjectMap['users']['email_updated'] = ['fromTable' => 'users', 'fromField' => 'email_updated'];
    }



    public function beforeAddField__clients__advertiser_limitation()
    {
        return $this->beforeAddField('clients', 'advertiser_limitation');
    }

    public function afterAddField__clients__advertiser_limitation()
    {
        return $this->afterAddField('clients', 'advertiser_limitation');
    }

    public function beforeAddField__users__email_updated()
    {
        return $this->beforeAddField('users', 'email_updated');
    }

    public function afterAddField__users__email_updated()
    {
        return $this->afterAddField('users', 'email_updated');
    }
}
