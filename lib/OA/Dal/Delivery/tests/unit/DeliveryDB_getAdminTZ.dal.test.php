<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id $
*/

require_once MAX_PATH . '/lib/OA/Dal/Delivery/'.$GLOBALS['_MAX']['CONF']['database']['type'].'.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for performing extended testing on the Delivery Engine DAL class'
 * OA_Dal_Delivery_getZoneInfo() function.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openads.org>
 */
class Test_OA_Dal_DeliveryDB_getAdminTZ extends UnitTestCase
{
    var $oDbh;
    var $prefix;

    function Test_OA_Dal_DeliveryDB_getAdminTZ()
    {
        $this->UnitTestCase();
        $this->oDbh = OA_DB::singleton();
        $this->prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
    }

    function test_DeliveryDB_getAdminTZ()
    {
        // Create the admin account
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_name = 'Administrator Account';
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $adminAccountId = DataGenerator::generateOne($doAccounts);

        $result = OA_Dal_Delivery_getAdminTZ();
        $this->assertEqual($result, 'UTC');

        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'timezone';
        $preferenceId = $doPreferences->insert();

        $doAPA = OA_Dal::factoryDO('account_preference_assoc');
        $doAPA->account_id = $adminAccountId;
        $doAPA->preference_id = $preferenceId;
        $doAPA->value = '';
        $doAPA->insert();

        $result = OA_Dal_Delivery_getAdminTZ();
        $this->assertEqual($result, 'UTC');

        $doAPA = OA_Dal::factoryDO('account_preference_assoc');
        $doAPA->account_id = $adminAccountId;
        $doAPA->preference_id = $preferenceId;
        $doAPA->value = 'Europe/Rome';
        $doAPA->update();

        $result = OA_Dal_Delivery_getAdminTZ();
        $this->assertEqual($result, 'Europe/Rome');
    }

}

?>