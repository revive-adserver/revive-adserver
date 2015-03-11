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
 * A class for testing the getZonesAllocationsForEcpmRemnantByAgency()
 * methods of the non-DB specific
 * OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 */
class Test_OA_Dal_Maintenance_Priority_getZonesAllocationsByAgency extends UnitTestCase
{
    public $idZone1;

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Method to test the getZonesAllocationsByAgency method.
     *
     * Requirements:
     * Test 1: Test with no data, and ensure no data returned.
     * Test 2: Test with sample data, and ensure the correct data is returned.
     */
    function testGetZonesAllocationsForEcpmRemnantByAgency()
    {
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

        list($agencyId1, $agencyId2) = $this->_generateData(DataObjects_Campaigns::PRIORITY_ECPM);

        // Test 1
        $result = $oMaxDalMaintenance->getZonesAllocationsForEcpmRemnantByAgency($agencyId2);
        $this->assertEqual(0, count($result));

        // Test 2
        $aResult = $oMaxDalMaintenance->getZonesAllocationsForEcpmRemnantByAgency($agencyId1);

        $this->assertEqual(1, count($aResult));
        $this->assertEqual(2, $aResult[$this->idZone1]);

        TestEnv::restoreEnv();
    }

    /**
     * Method to test the getZonesAllocationsByAgencyAndCampaignPriority method.
     *
     * Requirements:
     * Test 1: Test with no data, and ensure no data returned.
     * Test 2: Test with sample data, and ensure the correct data is returned.
     */
    function testGetZonesAllocationsByAgencyAndCampaignPriority()
    {
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

        list($agencyId1, $agencyId2) = $this->_generateData($priority = 5);
        $priority--; // always bigger priority is summed up

        // Test 1
        $result = $oMaxDalMaintenance->getZonesAllocationsByAgencyAndCampaignPriority($agencyId2, $priority);
        $this->assertEqual(0, count($result));

        // Test 2
        $aResult = $oMaxDalMaintenance->getZonesAllocationsByAgencyAndCampaignPriority($agencyId1, $priority);

        $this->assertEqual(1, count($aResult));
        $this->assertEqual(7, $aResult[$this->idZone1]);

        TestEnv::restoreEnv();
    }

    public function _generateData($priority)
    {
        $oDbh = &OA_DB::singleton();

        // Create the required temporary table for the tests
        $oTable = &OA_DB_Table_Priority::singleton();
        $oTable->createTable('tmp_ad_zone_impression');

        // set up agencies, affiliates and zones
        $idClient1 = DataGenerator::generateOne('clients', true);
        $agencyId1 = DataGenerator::getReferenceId('agency');
        $idClient2 = DataGenerator::generateOne('clients', true);
        $agencyId2 = DataGenerator::getReferenceId('agency');
        $idClient3 = DataGenerator::generateOne('clients', true);
        $agencyId3 = DataGenerator::getReferenceId('agency');

        // Add affiliates (websites)
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->agencyid = $agencyId1;
        $affiliateId1 = DataGenerator::generateOne($doAffiliates);

        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->agencyid = $agencyId3;
        $affiliateId2 = DataGenerator::generateOne($doAffiliates);

        $doZones = OA_Dal::factoryDO('zones');
        $doZones->description = 'Test zone';
        $doZones->affiliateid = $affiliateId1;
        $this->idZone1 = DataGenerator::generateOne($doZones);

        $doZones = OA_Dal::factoryDO('zones');
        $doZones->description = 'Test zone';
        $doZones->affiliateid = $affiliateId2;
        $idZone2 = DataGenerator::generateOne($doZones);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid = $idClient1;
        $doCampaigns->priority = --$priority;
        $doCampaigns->ecpm_enabled = 1;
        $idCampaign1 = DataGenerator::generateOne($doCampaigns);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $idCampaign1;
        $idAd1 = DataGenerator::generateOne($doBanners);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid = $idClient1;
        $doCampaigns->priority = ++$priority;
        $doCampaigns->ecpm_enabled = 1;
        $idCampaign2 = DataGenerator::generateOne($doCampaigns);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $idCampaign2;
        $idAd2 = DataGenerator::generateOne($doBanners);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid = $idClient1;
        $doCampaigns->priority = ++$priority;
        $doCampaigns->ecpm_enabled = 1;
        $idCampaign3 = DataGenerator::generateOne($doCampaigns);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $idCampaign3;
        $idAd3 = DataGenerator::generateOne($doBanners);

        $query = "
            INSERT INTO
                tmp_ad_zone_impression
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    to_be_delivered
                )
            VALUES
                (
                    1,
                    {$idZone2},
                    2,
                    3,
                    1
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                tmp_ad_zone_impression
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    to_be_delivered
                )
            VALUES
                (
                    {$idAd1},
                    {$this->idZone1},
                    1,
                    5,
                    1
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                tmp_ad_zone_impression
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    to_be_delivered
                )
            VALUES
                (
                    {$idAd2},
                    {$this->idZone1},
                    2,
                    5,
                    1
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                tmp_ad_zone_impression
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    to_be_delivered
                )
            VALUES
                (
                    {$idAd3},
                    {$this->idZone1},
                    5,
                    5,
                    1
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                tmp_ad_zone_impression
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    to_be_delivered
                )
            VALUES
                (
                    2,
                    {$this->idZone1},
                    6,
                    7,
                    0
                )";
        $rows = $oDbh->exec($query);

        return array($agencyId1, $agencyId2);
    }
}

?>
