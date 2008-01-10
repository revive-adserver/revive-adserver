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
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Test_OA_Dal_DeliveryDB_getZoneInfo extends UnitTestCase
{
    var $oDbh;
    var $prefix;

    function Test_OA_Dal_DeliveryDB_getZoneInfo()
    {
        $this->UnitTestCase();
        $this->oDbh = OA_DB::singleton();
        $this->prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
    }

    function test_DeliveryDB_getZoneInfo()
    {
        // Create the admin account
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_name = 'Administrator Account';
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $adminAccountId = DataGenerator::generateOne($doAccounts);

        // Create a manager "agency" and account
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name = 'Manager Account';
        $doAgency->contact = 'Andrew Hill';
        $doAgency->email = 'andrew.hill@openads.org';
        $managerAgencyId = DataGenerator::generateOne($doAgency);

        // Get the account ID for the manager "agency"
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->agency_id = $managerAgencyId;
        $doAgency->find();
        $doAgency->fetch();
        $aAgency = $doAgency->toArray();
        $managerAccountId = $aAgency['account_id'];

        // Create a trafficker "affiliate" and account, owned by the manager
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->name = 'Trafficker Account';
        $doAffiliates->contact = 'Andrew Hill';
        $doAffiliates->email = 'andrew.hill@openads.org';
        $doAffiliates->agencyid = $managerAgencyId;
        $traffickerAffiliateId = DataGenerator::generateOne($doAffiliates);

        // Get the account ID for the trafficker "affiliate"
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->clientid = $traffickerAffiliateId;
        $doAffiliates->find();
        $doAffiliates->fetch();
        $aTrafficker = $doAffiliates->toArray();
        $traffickerAccountId = $aTrafficker['account_id'];

        // Test 1: Test with no zone present
        $aResult = OA_Dal_Delivery_getZoneInfo(1);
        $this->assertFalse($aResult);

        // Create a zone
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->zonename                = 'Zone 1';
        $doZones->delivery                = 0;
        $doZones->description             = 'Zone Description';
        $doZones->width                   = 468;
        $doZones->height                  = 60;
        $doZones->chain                   = 500;
        $doZones->prepend                 = 'foo!';
        $doZones->append                  = 'bar!';
        $doZones->appendtype              = 0;
        $doZones->forceappend             = 't';
        $doZones->inventory_forecast_type = '0';
        $doZones->block                   = 14400;
        $doZones->capping                 = 100;
        $doZones->session_capping         = 10;
        $zoneId = DataGenerator::generateOne($doZones);

        // Test 2: Test with a non-existing zone
        $aResult = OA_Dal_Delivery_getZoneInfo($zoneId + 1);
        $this->assertFalse($aResult);

        // Test 3: Test with an existing zone, no preferences
        //         or preference associations
        $aResult = OA_Dal_Delivery_getZoneInfo($zoneId);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 17);
        $this->assertEqual($aResult['zone_id'], $zoneId);
        $this->assertEqual($aResult['name'], 'Zone 1');
        $this->assertEqual($aResult['type'], 0);
        $this->assertEqual($aResult['description'], 'Zone Description');
        $this->assertEqual($aResult['width'], 468);
        $this->assertEqual($aResult['height'], 60);


    }

}

?>