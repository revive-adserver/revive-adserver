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

require_once MAX_PATH . '/lib/max/Dal/Delivery.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for performing extended testing on the Delivery Engine DAL class'
 * OA_Dal_Delivery_getZoneInfo() function.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openads.org>
 */
class Test_OA_Dal_DeliveryDB_TZ extends UnitTestCase
{
    var $zoneId;

    function Test_OA_Dal_DeliveryDB_TZ()
    {
        $this->UnitTestCase();

        // Disable caching
        $GLOBALS['_MAX']['CONF']['delivery']['cacheExpire'] = 0;

        MAX_Dal_Delivery_Include();

        // Create the admin account
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_name = 'Administrator Account';
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $adminAccountId = DataGenerator::generateOne($doAccounts);

        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'timezone';
        $preferenceId = DataGenerator::generateOne($doPreferences);

        $doAPA = OA_Dal::factoryDO('account_preference_assoc');
        $doAPA->account_id = $adminAccountId;
        $doAPA->preference_id = $preferenceId;
        $doAPA->value = 'Europe/Rome';
        DataGenerator::generateOne($doAPA);

        // Managers
        $doAgency = OA_Dal::factoryDO('agency');
        $aAgencyId[] = DataGenerator::generateOne($doAgency);

        $doAgency = OA_Dal::factoryDO('agency');
        $aAgencyId[] = DataGenerator::generateOne($doAgency);

        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->agencyid = $aAgencyId[1];
        list($managerAccountId) = $doAgency->getAll(array('account_id'));

        $doAPA = OA_Dal::factoryDO('account_preference_assoc');
        $doAPA->account_id = $managerAccountId;
        $doAPA->preference_id = $preferenceId;
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
        $aBannerId[] = DataGenerator::generateOne($doBanners);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $aCampaignId[1];
        $doBanners->width = 468;
        $doBanners->height = 60;
        $doBanners->status = OA_ENTITY_STATUS_RUNNING;
        $aBannerId[] = DataGenerator::generateOne($doBanners);

        // Zones
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->zonetype = 3;
        $doZones->delivery = 0;
        $doZones->width = 468;
        $doZones->height = 60;
        $this->zoneId = DataGenerator::generateOne($doZones);

        Admin_DA::addPlacementZone(array('placement_id' => $aCampaignId[0], 'zone_id' => $this->zoneId));
        Admin_DA::addPlacementZone(array('placement_id' => $aCampaignId[1], 'zone_id' => $this->zoneId));

        // Force cache recreation of getAdminTZ
        MAX_cacheGetAdminTZ(false);
    }

    function testDirectSelection()
    {
        $aResult = OA_Dal_Delivery_getLinkedAds('468x60');
        $this->assertEqual($aResult['lAds'][1]['timezone'], 'Europe/Rome');
        $this->assertEqual($aResult['lAds'][2]['timezone'], 'Europe/London');
    }

    function testZone()
    {
        $aResult = OA_Dal_Delivery_getZoneLinkedAds($this->zoneId);
        $this->assertEqual($aResult['lAds'][1]['timezone'], 'Europe/Rome');
        $this->assertEqual($aResult['lAds'][2]['timezone'], 'Europe/London');
    }
}

?>