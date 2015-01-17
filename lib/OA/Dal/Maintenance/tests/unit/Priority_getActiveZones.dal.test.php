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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the getActiveZones() method of the non-DB specific
 * OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 */
class Test_OA_Dal_Maintenance_Priority_getActiveZones extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * The method to test the getActiveZones() method.
     */
    function testGetActiveZones()
    {
        $oDal = new OA_Dal_Maintenance_Priority();


        // Add campaign
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'Active Campaign';
        $doCampaigns->status = OA_ENTITY_STATUS_RUNNING;
        $doCampaigns->priority = 9;
        $idCampaign = DataGenerator::generateOne($doCampaigns);

        // Test with no zones in the system
        $aResult = $oDal->getActiveZones();
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test with two zones in the system, but with no banners linked
        $doZones = OA_Dal::factoryDO('zones');
        $oNow = new Date();
        $doZones->zonename = 'First Zone';
        $doZones->zonetype = 3;
        $doZones->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $idZoneFirst = DataGenerator::generateOne($doZones);

        $doZones = OA_Dal::factoryDO('zones');
        $oNow = new Date();
        $doZones->zonename = 'Second Zone';
        $doZones->zonetype = 3;
        $doZones->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $idZoneSecond = DataGenerator::generateOne($doZones);

        $aResult = $oDal->getActiveZones();
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test with active and inactive banners in the system, but not linked
        $doBanners = OA_Dal::factoryDO('banners');
        $oNow = new Date();
        $doBanners->status = OA_ENTITY_STATUS_RUNNING;
        $doBanners->campaignid = $idCampaign;
        $doBanners->acls_updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $idBannerActive = DataGenerator::generateOne($doBanners, true);

        $doBanners = OA_Dal::factoryDO('banners');
        $oNow = new Date();
        $doBanners->status = OA_ENTITY_STATUS_INACTIVE;
        $doBanners->campaignid = $idCampaign;
        $doBanners->acls_updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $idBannerInactive = DataGenerator::generateOne($doBanners, true);

        $aResult = $oDal->getActiveZones();
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Link the active and inactive banners to different zones, and
        // check only the active zone is returned
        $doAdZone = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZone->ad_id = $idBannerActive;
        $doAdZone->zone_id = $idZoneFirst;
        $doAdZone->priority = 0;
        $doAdZone->link_type = 1;
        $doAdZone->priority_factor = 1;
        $doAdZone->to_be_delivered = 1;
        $idAdZone = DataGenerator::generateOne($doAdZone);

        $doAdZone = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZone->ad_id = $idBannerInactive;
        $doAdZone->zone_id = $idZoneSecond;
        $doAdZone->priority = 0;
        $doAdZone->link_type = 1;
        $doAdZone->priority_factor = 1;
        $doAdZone->to_be_delivered = 1;
        $idAdZone = DataGenerator::generateOne($doAdZone);

        $aResult = $oDal->getActiveZones();
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $aZone = $aResult[0];
        $this->assertTrue(array_key_exists('zoneid'  , $aZone));
        $this->assertTrue(array_key_exists('zonename', $aZone));
        $this->assertTrue(array_key_exists('zonetype', $aZone));
        $this->assertEqual($aZone['zoneid'], $idZoneFirst);
        $this->assertEqual($aZone['zonename'], 'First Zone');
        $this->assertEqual($aZone['zonetype'], 3);

        // Now link the active banner to the second zone, and check
        // both zones are returned
        $doAdZone = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZone->ad_id = $idBannerActive;
        $doAdZone->zone_id = $idZoneSecond;
        $doAdZone->priority = 0;
        $doAdZone->link_type = 1;
        $doAdZone->priority_factor = 1;
        $doAdZone->to_be_delivered = 1;
        $idAdZone = DataGenerator::generateOne($doAdZone);

        $aResult = $oDal->getActiveZones();
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $aZone = $aResult[0];
        $this->assertTrue(array_key_exists('zoneid'  , $aZone));
        $this->assertTrue(array_key_exists('zonename', $aZone));
        $this->assertTrue(array_key_exists('zonetype', $aZone));
        $this->assertEqual($aZone['zoneid'], $idZoneFirst);
        $this->assertEqual($aZone['zonename'], 'First Zone');
        $this->assertEqual($aZone['zonetype'], 3);
        $aZone = $aResult[1];
        $this->assertTrue(array_key_exists('zoneid'  , $aZone));
        $this->assertTrue(array_key_exists('zonename', $aZone));
        $this->assertTrue(array_key_exists('zonetype', $aZone));
        $this->assertEqual($aZone['zoneid'], $idZoneSecond);
        $this->assertEqual($aZone['zonename'], 'Second Zone');
        $this->assertEqual($aZone['zonetype'], 3);

        DataGenerator::cleanUp();
    }

}

?>