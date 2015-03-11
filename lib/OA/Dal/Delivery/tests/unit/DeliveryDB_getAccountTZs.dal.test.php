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

require_once MAX_PATH . '/lib/max/Dal/Delivery.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for performing extended testing on the Delivery Engine DAL class'
 * OA_Dal_Delivery_getAccountTZs() function.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 */
class Test_OA_Dal_Delivery_getAccountTZs extends UnitTestCase
{
    var $oDbh;
    var $prefix;

    function __construct()
    {
        parent::__construct();
        $this->oDbh = OA_DB::singleton();
        $this->prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];

        // Disable caching
        $GLOBALS['OA_Delivery_Cache']['expiry'] = -1;

        MAX_Dal_Delivery_Include();
    }

    function test_DeliveryDB_getAdminTZ()
    {
        // Create the admin account
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_name = 'System Administrator';
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $adminAccountId = DataGenerator::generateOne($doAccounts);

        $aExpect = array(
            'default' => 'UTC',
            'aAccounts' => array(),
            'adminAccountId' => 1
        );

        $aResult = OA_Dal_Delivery_getAccountTZs();
        $this->assertEqual($aResult, $aExpect);

        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'timezone';
        $preferenceId = $doPreferences->insert();

        $doAPA = OA_Dal::factoryDO('account_preference_assoc');
        $doAPA->account_id = $adminAccountId;
        $doAPA->preference_id = $preferenceId;
        $doAPA->value = '';
        $doAPA->insert();

        $aResult = OA_Dal_Delivery_getAccountTZs();
        $this->assertEqual($aResult, $aExpect);

        $doAPA = OA_Dal::factoryDO('account_preference_assoc');
        $doAPA->account_id = $adminAccountId;
        $doAPA->preference_id = $preferenceId;
        $doAPA->value = 'Europe/Rome';
        $doAPA->update();

        $aExpect = array(
            'default' => 'Europe/Rome',
            'aAccounts' => array(),
            'adminAccountId' => 1
        );

        $aResult = OA_Dal_Delivery_getAccountTZs();
        $this->assertEqual($aResult, $aExpect);

        // Create a couple of manager accounts
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_name = 'Manager Account 1';
        $doAccounts->account_type = OA_ACCOUNT_MANAGER;
        $managerAccountId1 = DataGenerator::generateOne($doAccounts);

        $doAPA = OA_Dal::factoryDO('account_preference_assoc');
        $doAPA->account_id = $managerAccountId1;
        $doAPA->preference_id = $preferenceId;
        $doAPA->value = 'Europe/London';
        $doAPA->insert();

        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_name = 'Manager Account 2';
        $doAccounts->account_type = OA_ACCOUNT_MANAGER;
        $managerAccountId2 = DataGenerator::generateOne($doAccounts);

        $doAPA = OA_Dal::factoryDO('account_preference_assoc');
        $doAPA->account_id = $managerAccountId2;
        $doAPA->preference_id = $preferenceId;
        $doAPA->value = 'CEST';
        $doAPA->insert();

        $aExpect = array(
            'default' => 'Europe/Rome',
            'aAccounts' => array(
                $managerAccountId1 => 'Europe/London',
                $managerAccountId2 => 'CEST'
            ),
            'adminAccountId' => 1
        );

        $aResult = OA_Dal_Delivery_getAccountTZs();
        $this->assertEqual($aResult, $aExpect);
    }

}

?>