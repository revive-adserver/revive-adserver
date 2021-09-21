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

class Migration_547 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__accounts__m2m_password';
        $this->aTaskList_constructive[] = 'afterAddField__accounts__m2m_password';
        $this->aTaskList_constructive[] = 'beforeAddField__accounts__m2m_ticket';
        $this->aTaskList_constructive[] = 'afterAddField__accounts__m2m_ticket';


        $this->aObjectMap['accounts']['m2m_password'] = ['fromTable' => 'accounts', 'fromField' => 'm2m_password'];
        $this->aObjectMap['accounts']['m2m_ticket'] = ['fromTable' => 'accounts', 'fromField' => 'm2m_ticket'];
    }



    public function beforeAddField__accounts__m2m_password()
    {
        return $this->beforeAddField('accounts', 'm2m_password');
    }

    public function afterAddField__accounts__m2m_password()
    {
        return $this->afterAddField('accounts', 'm2m_password');
    }

    public function beforeAddField__accounts__m2m_ticket()
    {
        return $this->beforeAddField('accounts', 'm2m_ticket');
    }

    public function afterAddField__accounts__m2m_ticket()
    {
        return $this->afterAddField('accounts', 'm2m_ticket');
    }
}
