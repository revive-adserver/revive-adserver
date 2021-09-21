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

/**
 * @package    Plugin
 * @subpackage openxDeliveryLog
 */
class Migration_001 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddTable__data_bkt_c';
        $this->aTaskList_constructive[] = 'afterAddTable__data_bkt_c';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_bkt_m_backup';
        $this->aTaskList_constructive[] = 'afterAddTable__data_bkt_m_backup';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_bkt_m';
        $this->aTaskList_constructive[] = 'afterAddTable__data_bkt_m';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_bkt_r';
        $this->aTaskList_constructive[] = 'afterAddTable__data_bkt_r';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_bkt_a';
        $this->aTaskList_constructive[] = 'afterAddTable__data_bkt_a';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_bkt_a_var';
        $this->aTaskList_constructive[] = 'afterAddTable__data_bkt_a_var';
    }



    public function beforeAddTable__data_bkt_c()
    {
        return $this->beforeAddTable('data_bkt_c');
    }

    public function afterAddTable__data_bkt_c()
    {
        return $this->afterAddTable('data_bkt_c');
    }

    public function beforeAddTable__data_bkt_m_backup()
    {
        return $this->beforeAddTable('data_bkt_m_backup');
    }

    public function afterAddTable__data_bkt_m_backup()
    {
        return $this->afterAddTable('data_bkt_m_backup');
    }

    public function beforeAddTable__data_bkt_m()
    {
        return $this->beforeAddTable('data_bkt_m');
    }

    public function afterAddTable__data_bkt_m()
    {
        return $this->afterAddTable('data_bkt_m');
    }

    public function beforeAddTable__data_bkt_r()
    {
        return $this->beforeAddTable('data_bkt_r');
    }

    public function afterAddTable__data_bkt_r()
    {
        return $this->afterAddTable('data_bkt_r');
    }

    public function beforeAddTable__data_bkt_a()
    {
        return $this->beforeAddTable('data_bkt_a');
    }

    public function afterAddTable__data_bkt_a()
    {
        return $this->afterAddTable('data_bkt_a');
    }

    public function beforeAddTable__data_bkt_a_var()
    {
        return $this->beforeAddTable('data_bkt_a_var');
    }

    public function afterAddTable__data_bkt_a_var()
    {
        return $this->afterAddTable('data_bkt_a_var');
    }
}
