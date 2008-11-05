<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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
$Id$
*/

require_once MAX_PATH . '/lib/max/Dal/Delivery.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for performing extended testing on the Delivery Engine DAL class'
 * OA_Dal_Delivery_getZoneInfo() function.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class Test_OA_Dal_DeliveryDB_TZ extends UnitTestCase
{
    var $zoneId;
    var $aBannerId;
    var $adminAccountId;
    var $managerAccountId;
    var $preferenceId;

    function Test_OA_Dal_DeliveryDB_TZ()
    {
        $this->UnitTestCase();

        // Disable caching
        $GLOBALS['OA_Delivery_Cache']['expiry'] = -1;

        MAX_Dal_Delivery_Include();

        // Create the admin account
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_name = 'Administrator Account';
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $this->adminAccountId = DataGenerator::generateOne($doAccounts);

        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'timezone';
        $this->preferenceId = DataGenerator::generateOne($doPreferences);

        $doAPA = OA_Dal::factoryDO('account_preference_assoc');
        $doAPA->account_id = $this->adminAccountId;
        $doAPA->preference_id = $this->preferenceId;
        $doAPA->value = 'Europe/Rome';
        DataGenerator::generateOne($doAPA);

        // Managers
        $doAgency = OA_Dal::factoryDO('agency');
        $aAgencyId[] = DataGenerator::generateOne($doAgency);

        $doAgency = OA_Dal::factoryDO('agency');
        $aAgencyId[] = DataGenerator::generateOne($doAgency);

        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->agencyid = $aAgencyId[1];
        list($this->managerAccountId) = $doAgency->getAll(array('account_id'));

        $doAPA = OA_Dal::factoryDO('account_preference_assoc');
        $doAPA->account_id = $this->managerAccountId;
        $doAPA->preference_id = $this->preferenceId;
        $doAPA->value = 'Europe/London';
        DataGenerator::generateOne($doAPA);

        // Advertisers
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $aAgencyId[0];
        $aClientId[] = DataGenerator::generateOne($doClients);

        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $aAgencyId[1];
        $aClientId[] = DataGenerator::generateOne($doClients);

        // Campaigns
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid = $aClientId[0];
        $doCampaigns->status = OA_ENTITY_STATUS_RUNNING;
        $doCampaigns->priority = 0;
        $aCampaignId[] = DataGenerator::generateOne($doCampaigns);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid = $aClientId[1];
        $doCampaigns->status = OA_ENTITY_STATUS_RUNNING;
        $doCampaigns->priority = 0;
        $aCampaignId[] = DataGenerator::generateOne($doCampaigns);

        // Banners
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $aCampaignId[0];
        $doBanners->width = 468;
        $doBanners->height = 60;
        $doBanners->status = OA_ENTITY_STATUS_RUNNING;
        $this->aBannerId[] = DataGenerator::generateOne($doBanners);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $aCampaignId[1];
        $doBanners->width = 468;
        $doBanners->height = 60;
        $doBanners->status = OA_ENTITY_STATUS_RUNNING;
        $this->aBannerId[] = DataGenerator::generateOne($doBanners);

        // Zones
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->zonetype = 3;
        $doZones->delivery = 0;
        $doZones->width = 468;
        $doZones->height = 60;
        $this->zoneId = DataGenerator::generateOne($doZones);

        Admin_DA::addPlacementZone(array('placement_id' => $aCampaignId[0], 'zone_id' => $this->zoneId));
        Admin_DA::addPlacementZone(array('placement_id' => $aCampaignId[1], 'zone_id' => $this->zoneId));
    }

    function testDirectSelection()
    {
        $aResult = OA_Dal_Delivery_getLinkedAds('468x60');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult['lAds']), 2);
        $this->assertTrue(is_array($aResult['lAds'][$this->aBannerId[0]]));
        $this->assertTrue(is_array($aResult['lAds'][$this->aBannerId[1]]));
        $this->assertEqual($aResult['lAds'][$this->aBannerId[0]]['timezone'], 'Europe/Rome');
        $this->assertEqual($aResult['lAds'][$this->aBannerId[1]]['timezone'], 'Europe/London');
    }

    function testZone()
    {
        $aResult = OA_Dal_Delivery_getZoneLinkedAds($this->zoneId);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult['lAds']), 2);
        $this->assertTrue(is_array($aResult['lAds'][$this->aBannerId[0]]));
        $this->assertTrue(is_array($aResult['lAds'][$this->aBannerId[1]]));
        $this->assertEqual($aResult['lAds'][$this->aBannerId[0]]['timezone'], 'Europe/Rome');
        $this->assertEqual($aResult['lAds'][$this->aBannerId[1]]['timezone'], 'Europe/London');
    }

    function test_OA_976()
    {
        // Clean up prefs
        $doAPA = OA_Dal::factoryDO('account_preference_assoc');
        $doAPA->account_id = $this->managerAccountId;
        $doAPA->delete();

        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'foo';
        $fooId = DataGenerator::generateOne($doPreferences);

        $doPreferences->preference_name = 'bar';
        $barId = DataGenerator::generateOne($doPreferences);

        $doAPA = OA_Dal::factoryDO('account_preference_assoc');
        $doAPA->account_id = $this->managerAccountId;
        $doAPA->preference_id = $fooId;
        $doAPA->value = 'FOO';
        DataGenerator::generateOne($doAPA);

        $aResult = OA_Dal_Delivery_getZoneLinkedAds($this->zoneId);
        $this->assertEqual($aResult['count_active'], 2);
        $this->assertEqual($aResult['lAds'][$this->aBannerId[1]]['timezone'], 'Europe/Rome');

        $aResult = OA_Dal_Delivery_getLinkedAds('468x60');
        $this->assertEqual($aResult['count_active'], 2);
        $this->assertEqual($aResult['lAds'][$this->aBannerId[1]]['timezone'], 'Europe/Rome');

        $doAPA->preference_id = $barId;
        $doAPA->value = 'BAR';
        DataGenerator::generateOne($doAPA);

        $aResult = OA_Dal_Delivery_getZoneLinkedAds($this->zoneId);
        $this->assertEqual($aResult['count_active'], 2);
        $this->assertEqual($aResult['lAds'][$this->aBannerId[1]]['timezone'], 'Europe/Rome');

        $aResult = OA_Dal_Delivery_getLinkedAds('468x60');
        $this->assertEqual($aResult['count_active'], 2);
        $this->assertEqual($aResult['lAds'][$this->aBannerId[1]]['timezone'], 'Europe/Rome');

        $doAPA->preference_id = $this->preferenceId;
        $doAPA->value = 'GMT-06';
        DataGenerator::generateOne($doAPA);

        $aResult = OA_Dal_Delivery_getZoneLinkedAds($this->zoneId);
        $this->assertEqual($aResult['count_active'], 2);
        $this->assertEqual($aResult['lAds'][$this->aBannerId[1]]['timezone'], 'GMT-06');

        $aResult = OA_Dal_Delivery_getLinkedAds('468x60');
        $this->assertEqual($aResult['count_active'], 2);
        $this->assertEqual($aResult['lAds'][$this->aBannerId[1]]['timezone'], 'GMT-06');
    }
}

?>