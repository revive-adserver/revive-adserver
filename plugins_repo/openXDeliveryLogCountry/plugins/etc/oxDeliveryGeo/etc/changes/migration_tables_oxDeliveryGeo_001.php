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
 * @subpackage openxDeliveryLogCountry
 */
class Migration_001 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddTable__data_bkt_country_m';
        $this->aTaskList_constructive[] = 'afterAddTable__data_bkt_country_m';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_bkt_country_c';
        $this->aTaskList_constructive[] = 'afterAddTable__data_bkt_country_c';
    }


    public function beforeAddTable__data_bkt_country_m()
    {
        return $this->beforeAddTable('data_bkt_country_m');
    }

    public function afterAddTable__data_bkt_country_m()
    {
        return $this->afterAddTable('data_bkt_country_m');
    }

    public function beforeAddTable__data_bkt_country_c()
    {
        return $this->beforeAddTable('data_bkt_country_c');
    }

    public function afterAddTable__data_bkt_country_c()
    {
        return $this->afterAddTable('data_bkt_country_c');
    }
}
