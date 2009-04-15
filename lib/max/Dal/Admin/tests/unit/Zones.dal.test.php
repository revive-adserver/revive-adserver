<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';
require_once MAX_PATH . '/lib/OA/Dll/Zone.php';
require_once MAX_PATH . '/lib/OA/Central/AdNetworks.php';

/**
 * A class for testing DAL Zones methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class MAX_Dal_Admin_ZonesTest extends DalUnitTestCase
{
    var $dalZones;

    /**
     * A sample structure for tests containing websites and zones
     *
     * @var array
     */
    var $_aWebsitesAndZones = array ( 1 => array (
                                            'name' => 'website 1',
                                            'oac_category_id' => 6510,
                                            'zones' =>
                                                 array (
                                                   1 => array ( 'zonename' => 'zone 1 on web 1', 'oac_category_id' => 6510 ),
                                                   2 => array ( 'zonename' => 'zone 2 on web 1', 'oac_category_id' => 6502 ),
                                                   3 => array ( 'zonename' => 'zone 3 on web 1', 'oac_category_id' => 'null' )
                                                 )
                                          ),
                                     2 => array (
                                            'name' => 'website 2',
                                            'oac_category_id' => 'null',
                                            'zones' =>
                                                 array (
                                                   1 => array ( 'zonename' => 'zone 1 on web 2', 'oac_category_id' => 6581 ),
                                                   2 => array ( 'zonename' => 'zone 2 on web 2', 'oac_category_id' => 6502 ),
                                                 )
                                          ),
                                     3 => array (
                                            'name' => 'website 3',
                                            'oac_category_id' => 6581,
                                            'zones' => 'null'
                                          )
                             );

    /**
     * A sample structure for tests containing advertisers and campaigns
     *
     * @var array
     */
     var $_aAdvertisersAndCampaigns = array ( 1 => array (
                                            'clientname' => 'Advertiser 1',
                                            'campaigns' =>
                                                 array (
                                                   1 => array ( 'campaignname' => 'campaign 1 adv 1'),
                                                   2 => array ( 'campaignname' => 'campaign 2 adv 1'),
                                                 )
                                          ),
                                          2 => array (
                                            'clientname' => 'Advertiser 2',
                                            'campaigns' =>
                                                 array (
                                                   1 => array ( 'campaignname' => 'campaign 1 adv 2'),
                                                 )
                                          )
                                   );
     /**
      * A sample structure for tests containing categories
      *
      * @var array
      */
     var $_aCategories = array(
            65 => array(
                'name' => 'Micro processor',
                'subcategories' => array(
                    6502 => 'Apple II',
                    6510 => 'Commedore 64',
                    6581 => 'C64 SID'
                )
            )
        );

    /**
     * The constructor method.
     */
    function MAX_Dal_Admin_ZonesTest()
    {
        $this->UnitTestCase();
        Mock::generatePartial(
            'OA_Dll_Zone',
            'PartialMockOA_Dll_Zone',
            array('checkPermissions')
        );

        // PartialMock of OA_Central_AdNetworks
        Mock::generatePartial(
            'OA_Central_AdNetworks',
            'PartialMockOA_Central_AdNetworks',
            array('retrievePermanentCache')
        );
    }

    function setUp()
    {
        $this->dalZones = OA_Dal::factoryDAL('zones');
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testGetZoneByKeyword()
    {
        // Search for zones when none exist.
        $expected = 0;
        $rsZones = $this->dalZones->getZoneByKeyword('foo');
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);

        $agencyId = 1;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', $agencyId);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);

        $affiliateId = 1;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', null, $affiliateId);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);

        $affiliateId = 1;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', $agencyId, $affiliateId);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);

        // Add a zone (and parent objects)
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->zonename = 'foo';
        $doZones->description = 'bar';
        $zoneId = DataGenerator::generateOne($doZones, true);
        $affiliateId1 = DataGenerator::getReferenceId('affiliates');
        $agencyId1 = DataGenerator::getReferenceId('agency');

        // Add another zone
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->zonename = 'baz';
        $doZones->description = 'quux';
        $zoneId = DataGenerator::generateOne($doZones, true);
        $agencyId2 = DataGenerator::getReferenceId('agency');

        // Search for the zone by string
        $expected = 1;
        $rsZones = $this->dalZones->getZoneByKeyword('foo');
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);

        $rsZones = $this->dalZones->getZoneByKeyword('bar');
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);

        // Restrict the search to agency ID
        $expected = 0;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', $agencyId = 0);
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);

        $expected = 1;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', $agencyId1);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);

        // Restrict the search to affiliate ID
        $expected = 0;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', $agencyId, $affiliateId = 0);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);

        $expected = 1;
        $rsZones = $this->dalZones->getZoneByKeyword('foo', $agencyId1, $affiliateId1);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);

        $rsZones = $this->dalZones->getZoneByKeyword('bar', null, $affiliateId1);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);


        // Search for zone by zone ID
        $expected = 1;
        $rsZones = $this->dalZones->getZoneByKeyword($zoneId);
        $rsZones->find();
        $actual = $rsZones->getRowCount();
        $this->assertEqual($actual, $expected);
    }

    function testGetZoneForInvocationForm()
    {
        // Insert a publisher
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->website = 'http://example.com';
        $affiliateId = DataGenerator::generateOne($doAffiliates);

        // Insert a zone
        $doZone = OA_Dal::factoryDO('zones');
        $doZone->affiliateid = $affiliateId;
        $doZone->height = 5;
        $doZone->width = 10;
        $doZone->delivery = 1;
        $zoneId = DataGenerator::generateOne($doZone);

        $aExpected = array(
            'affiliateid' => $affiliateId,
            'height' => 5,
            'width' => 10,
            'delivery' => 1,
            'website' => 'http://example.com'
        );
        $aActual = $this->dalZones->getZoneForInvocationForm($zoneId);

        ksort($aExpected);
        ksort($aActual);

        $this->assertEqual($aActual, $aExpected);
    }

    /**
     * Tests getWebsitesAndZonesListByCategory method
     *
     */
    function testGetWebsitesAndZonesListByCategory()
    {
        $dalZones = OA_Dal::factoryDAL('zones');
        // Set categories mockup
        $dalZones->_oOaCentralAdNetworks = $this->_setCategoriesMockup($this->_aCategories);
        $aFlatCategories = $dalZones->_oOaCentralAdNetworks->getCategoriesFlat();

        // Test get all zones on empty database
        $aResult   = $dalZones->getWebsitesAndZonesListByCategory($agencyId);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Create agency
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name = 'Ad Network Manager';
        $agencyId = DataGenerator::generateOne($doAgency);

        // Generate websites and zones
        $aAffiliatesIds = array();
        $aZonesIds = array();
        $this->_createWebsitesAndZones($this->_aWebsitesAndZones, $agencyId, $aAffiliatesIds, $aZonesIds);

        // Create agency 2 - to check if returned zones are only from one agency
        $doAgency->name = 'Ad Network Manager 2';
        $agencyId2 = DataGenerator::generateOne($doAgency);

        // Generate websites and zones for 2nd agency
        $aAffiliatesIds2 = array();
        $aZonesIds2 = array();
        $this->_createWebsitesAndZones($this->_aWebsitesAndZones, $agencyId2, $aAffiliatesIds2, $aZonesIds2);

        // Test get all zones (no categories)
        $aResult   = $dalZones->getWebsitesAndZonesListByCategory($agencyId);
        $aExpected = $this->_buildExpectedArrayOfWebsitesAndZones($this->_aWebsitesAndZones, $aAffiliatesIds, $aZonesIds, null, $aFlatCategories );

        $this->assertEqual($aResult, $aExpected);
        $this->assertEqual(count($aResult),2);                              // We should get 2 websites
        $this->assertEqual(count($aResult[$aAffiliatesIds[1]]['zones']),3); // First website has 3 zones

        // Test get zones with category 6502
        $aResult   = $dalZones->getWebsitesAndZonesListByCategory($agencyId, 6502);
        $aExpected = $this->_buildExpectedArrayOfWebsitesAndZones($this->_aWebsitesAndZones, $aAffiliatesIds, $aZonesIds, array(6502), $aFlatCategories );
        $this->assertEqual($aResult, $aExpected);
        $this->assertEqual(count($aResult),2);                              // We should get 2 websites
        $this->assertEqual(count($aResult[$aAffiliatesIds[1]]['zones']),1); // First website has 1 zone

        // Test get zones with category 6581
        $aResult   = $dalZones->getWebsitesAndZonesListByCategory($agencyId, 6581);
        $aExpected = $this->_buildExpectedArrayOfWebsitesAndZones($this->_aWebsitesAndZones, $aAffiliatesIds, $aZonesIds, array(6581), $aFlatCategories );
        $this->assertEqual($aResult, $aExpected);
        $this->assertEqual(count($aResult),1);                              // We should get 1 website
        $this->assertEqual(count($aResult[$aAffiliatesIds[2]]['zones']),1); // only one zone matches

        // Test get zones when category not assigned to zones
        $aResult = $dalZones->getWebsitesAndZonesListByCategory($agencyId, 1234567);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test get zones when category has subcategories
        $aResult = $dalZones->getWebsitesAndZonesListByCategory($agencyId, 65);
        $aExpected = $this->_buildExpectedArrayOfWebsitesAndZones($this->_aWebsitesAndZones, $aAffiliatesIds, $aZonesIds, array(65, 6502, 6510, 6581), $aFlatCategories );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult),2);                              // We should get 2 websites
        $this->assertEqual(count($aResult[$aAffiliatesIds[1]]['zones']),3); // 1st website has 3 zones
        $this->assertEqual(count($aResult[$aAffiliatesIds[2]]['zones']),2); // 2nd website has 2 zones

        // Generate advertisers and campaigns
        $aClientsIds = array();
        $aCampaignsIds = array();
        $this->_createAdvertisersAndCampaigns($this->_aAdvertisersAndCampaigns, $agencyId, $aClientsIds, $aCampaignsIds);

        // Link campaigns to zones
        $dllZonePartialMock = new PartialMockOA_Dll_Zone($this);
        $dllZonePartialMock->setReturnValue('checkPermissions', true);

        $dllZonePartialMock->linkCampaign($aZonesIds[1][1],$aCampaignsIds[1][1]);
        $dllZonePartialMock->linkCampaign($aZonesIds[1][1],$aCampaignsIds[1][2]);
        $dllZonePartialMock->linkCampaign($aZonesIds[1][1],$aCampaignsIds[2][1]);
        $dllZonePartialMock->linkCampaign($aZonesIds[1][2],$aCampaignsIds[1][1]);
        $dllZonePartialMock->linkCampaign($aZonesIds[1][3],$aCampaignsIds[1][1]);
        $dllZonePartialMock->linkCampaign($aZonesIds[2][1],$aCampaignsIds[2][1]);

        // Test no category, and linked
        $aResult   = $dalZones->getWebsitesAndZonesListByCategory($agencyId, null,$aCampaignsIds[1][1]);
        $aExpected = $this->_buildExpectedArrayOfWebsitesAndZones($this->_aWebsitesAndZones, $aAffiliatesIds, $aZonesIds, null, $aFlatCategories );
        // Manually set isLinked
        foreach ($aExpected as $affiliateId => $aWebsite) {
            foreach ($aWebsite['zones'] as $zoneId => $aZone) {
                // If zone is linked with campaign[1][1]
                if ($zoneId == $aZonesIds[1][1] ||
                    $zoneId == $aZonesIds[1][2] ||
                    $zoneId == $aZonesIds[1][3])
                {
                    $aExpected[$affiliateId]['zones'][$zoneId]['linked'] = true;
                } else {
                    $aExpected[$affiliateId]['zones'][$zoneId]['linked'] = false;
                }
            }
        }
        $this->assertEqual($aResult, $aExpected);

        // Test get category 6510 and linked
        $aResult   = $dalZones->getWebsitesAndZonesListByCategory($agencyId, 6510, $aCampaignsIds[1][2]);
        $aExpected = $this->_buildExpectedArrayOfWebsitesAndZones($this->_aWebsitesAndZones, $aAffiliatesIds, $aZonesIds, array(6510), $aFlatCategories);
        // Manually set isLinked
        foreach ($aExpected as $affiliateId => $aWebsite) {
            foreach ($aWebsite['zones'] as $zoneId => $aZone) {
                    $aExpected[$affiliateId]['zones'][$zoneId]['linked'] = false;
            }
        }
        $aExpected[$affiliateId]['zones'][$aZonesIds[1][1]]['linked'] = true; // In selected category only one is linked
        $this->assertEqual($aResult, $aExpected);

        // Test get category 6502 and linked
        $aResult   = $dalZones->getWebsitesAndZonesListByCategory($agencyId, 6502, $aCampaignsIds[2][1]);
        $aExpected = $this->_buildExpectedArrayOfWebsitesAndZones($this->_aWebsitesAndZones, $aAffiliatesIds, $aZonesIds, array(6502), $aFlatCategories);
        // Manually set isLinked to false ( no linked campaigns in selected category)
        foreach ($aExpected as $affiliateId => $aWebsite) {
            foreach ($aWebsite['zones'] as $zoneId => $aZone) {
                    $aExpected[$affiliateId]['zones'][$zoneId]['linked'] = false;
            }
        }
        $this->assertEqual($aResult, $aExpected);
    }

    /**
     * Tests getZonesListByCategory method
     *
     */
    function testGetZonesListByCategory()
    {
        $dalZones = OA_Dal::factoryDAL('zones');

        // Test get all zones on empty database
        $aResult   = $dalZones->getZonesListByCategory($agencyId);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Create agency
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name = 'Ad Network Manager';
        $agencyId = DataGenerator::generateOne($doAgency);

        // Generate websites and zones
        $aAffiliatesIds = array();
        $aZonesIds = array();
        $this->_createWebsitesAndZones($this->_aWebsitesAndZones, $agencyId, $aAffiliatesIds, $aZonesIds);

        // Set categories mockup
        $dalZones->_oOaCentralAdNetworks = $this->_setCategoriesMockup($this->_aCategories);

        // Test get all zones (no categories)
        $aResult   = $dalZones->getZonesListByCategory($agencyId);
        $aExpected = $this->_buildExpectedArrayOfZones($this->_aWebsitesAndZones, $aAffiliatesIds, $aZonesIds);
        $this->assertEqual($aResult, $aExpected);
        $this->assertEqual(count($aResult),5);      // found 5 zones

        // Test get zones with category 6502
        $aResult   = $dalZones->getZonesListByCategory($agencyId, 6502);
        $aExpected = $this->_buildExpectedArrayOfZones($this->_aWebsitesAndZones, $aAffiliatesIds, $aZonesIds, array(6502));
        $this->assertEqual($aResult, $aExpected);
        $this->assertEqual(count($aResult),2);     // found 2 zones

        // Test get zones with category 6581
        $aResult   = $dalZones->getZonesListByCategory($agencyId, 6581);
        $aExpected = $this->_buildExpectedArrayOfZones($this->_aWebsitesAndZones, $aAffiliatesIds, $aZonesIds, array(6581));
        $this->assertEqual($aResult, $aExpected);
        $this->assertEqual(count($aResult),1);     // found 1 zone

        // Test get zones when category not assigned to zones
        $aResult = $dalZones->getZonesListByCategory($agencyId, 1234567);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test get zones when category ID is a parent
        $aResult = $dalZones->getZonesListByCategory($agencyId, 65);
        $aExpected = $this->_buildExpectedArrayOfZones($this->_aWebsitesAndZones, $aAffiliatesIds, $aZonesIds, array(65, 6502, 6510, 6581));
        $this->assertEqual($aResult, $aExpected);
        $this->assertEqual(count($aResult), 5);

        // Test get zones with no category
        $aResult = $dalZones->getZonesListByCategory($agencyId, -1);
        $aExpected = $this->_buildExpectedArrayOfZones($this->_aWebsitesAndZones, $aAffiliatesIds, $aZonesIds, -1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);

        // Generate advertisers and campaigns
        $aClientsIds = array();
        $aCampaignsIds = array();
        $this->_createAdvertisersAndCampaigns($this->_aAdvertisersAndCampaigns, $agencyId, $aClientsIds, $aCampaignsIds);

        // Link campaigns to zones
        $dllZonePartialMock = new PartialMockOA_Dll_Zone($this);
        $dllZonePartialMock->setReturnValue('checkPermissions', true);

        $dllZonePartialMock->linkCampaign($aZonesIds[1][1],$aCampaignsIds[1][1]);
        $dllZonePartialMock->linkCampaign($aZonesIds[1][1],$aCampaignsIds[1][2]);
        $dllZonePartialMock->linkCampaign($aZonesIds[1][1],$aCampaignsIds[2][1]);
        $dllZonePartialMock->linkCampaign($aZonesIds[1][2],$aCampaignsIds[1][1]);
        $dllZonePartialMock->linkCampaign($aZonesIds[1][3],$aCampaignsIds[1][1]);
        $dllZonePartialMock->linkCampaign($aZonesIds[2][1],$aCampaignsIds[2][1]);

        // Test no category, and linked
        $aResult   = $dalZones->getZonesListByCategory($agencyId, null,$aCampaignsIds[1][1]);
        $aExpected = $this->_buildExpectedArrayOfZones($this->_aWebsitesAndZones, $aAffiliatesIds, $aZonesIds);
        // Manually set isLinked
        foreach ($aExpected as $key => $aZone) {
            // If zone is linked with campaign[1][1]
            if ($aZone['zoneid'] == $aZonesIds[1][1] ||
                $aZone['zoneid'] == $aZonesIds[1][2] ||
                $aZone['zoneid'] == $aZonesIds[1][3])
            {
                $aExpected[$key]['islinked'] = true;
            } else {
                $aExpected[$key]['islinked'] = false;
            }
        }
        $this->assertEqual($aResult, $aExpected);

        // Test get category 6510 and linked
        $aResult   = $dalZones->getZonesListByCategory($agencyId, 6510, $aCampaignsIds[1][2]);
        $aExpected = $this->_buildExpectedArrayOfZones($this->_aWebsitesAndZones, $aAffiliatesIds, $aZonesIds, array(6510));
        $aExpectedLinked    = array();
        $aExpectedAvailable = array();
        // Manually set isLinked and fill linked and available
        foreach ($aExpected as $key => $aZone) {
            if ($aZone['zoneid'] == $aZonesIds[1][1]) {
                $aExpected[$key]['islinked'] = true; // In selected category only one is linked
                $aExpectedLinked[] = $aExpected[$key];
            } else {
                $aExpected[$key]['islinked'] = false;
                $aExpectedAvailable[] = $aExpected[$key];
            }
        }
        $this->assertEqual($aResult, $aExpected);

        // Repeat prevoious test but select only linked zones
        $aResult = $dalZones->getZonesListByCategory($agencyId, 6510, $aCampaignsIds[1][2], true);
        $this->assertEqual($aResult, $aExpectedLinked);

        // Repeat prevoious test but select only available zones
        $aResult = $dalZones->getZonesListByCategory($agencyId, 6510, $aCampaignsIds[1][2], false);
        $this->assertEqual($aResult, $aExpectedAvailable);


        // Test get category 6502 and linked
        $aResult   = $dalZones->getZonesListByCategory($agencyId, 6502, $aCampaignsIds[2][1]);
        $aExpected = $this->_buildExpectedArrayOfZones($this->_aWebsitesAndZones, $aAffiliatesIds, $aZonesIds, array(6502));

        // Manually set isLinked to false ( no linked campaigns in selected category)
        foreach ($aExpected as $key => $aZone) {
            $aExpected[$key]['islinked'] = false;
        }
        $this->assertEqual($aResult, $aExpected);

        // Repeat prevoious test but select only linked zones
        $aResult   = $dalZones->getZonesListByCategory($agencyId, 6502, $aCampaignsIds[2][1], true);
        $this->assertEqual(count($aResult), 0);

        // Repeat prevoious test but select only available zones
        $aResult   = $dalZones->getZonesListByCategory($agencyId, 6502, $aCampaignsIds[2][1], false);
        $this->assertEqual($aResult, $aExpected);

        // Test get 3 zones from first website by search string
        $aResult   = $dalZones->getZonesListByCategory($agencyId, null, null, null, 'web 1');
        $aExpected = $this->_buildExpectedArrayOfZones($this->_aWebsitesAndZones, $aAffiliatesIds, $aZonesIds, null, 'web 1');
        $this->assertEqual($aResult, $aExpected);
    }

    /**
     * Add websites and zones to database
     *
     * @param array $aWebsitesAndZones formated as var _aWebsitesAndZones
     * @param int $agencyId agency Id of existing agency
     * @param array $aAffiliatesIds return array with affiliates Ids
     * @param array $aZonesIds      return array with zones Ids
     */
    function _createWebsitesAndZones($aWebsitesAndZones, $agencyId, &$aAffiliatesIds, &$aZonesIds)
    {
        $doAffiliate = OA_Dal::factoryDO('affiliates');
        $doZones = OA_Dal::factoryDO('zones');
        foreach ($aWebsitesAndZones as $websiteKey => $aWebsite) {
            $doAffiliate->name            = $aWebsite['name'];
            $doAffiliate->oac_category_id = $aWebsite['oac_category_id'];
            $doAffiliate->agencyid        = $agencyId;
            $aAffiliatesIds[$websiteKey] = DataGenerator::generateOne($doAffiliate);
            if (is_array($aWebsite['zones'])) {
                foreach ($aWebsite['zones'] as $zoneKey => $aZone) {
                    $doZones->zonename        = $aZone['zonename'];
                    $doZones->affiliateid     = $aAffiliatesIds[$websiteKey];
                    $doZones->oac_category_id = $aZone['oac_category_id'];
                    if (array_key_exists('width',$aZone) && array_key_exists('height',$aZone)) {
                        $doZones->width       = $aZone['width'];
                        $doZones->height      = $aZone['height'];
                    }
                    if (array_key_exists('delivery',$aZone)) {
                        $doZones->delivery    = $aZone['delivery'];
                    }
                    $aZonesIds[$websiteKey][$zoneKey] = DataGenerator::generateOne($doZones);
                }
            }
        }
    }

   /**
    * Add advertiosers and campaigns to database
    *
    * @param array $aAdvertisersAndCampaigns formated as var _aAdvertisersAndCampaigns
    * @param int $agencyId agency Id of existing agency
    * @param array $aClientsIds   return array with clients Ids
    * @param array $aCampaignsIds return array with campaigns Ids
    */
    function _createAdvertisersAndCampaigns($aAdvertisersAndCampaigns, $agencyId, &$aClientsIds, &$aCampaignsIds)
    {
        $doClients = OA_Dal::factoryDO('clients');
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        foreach ($aAdvertisersAndCampaigns as $advKey => $aAdvertiser) {
            $doClients->clientname        = $aAdvertiser['clientname'];
            $doClients->agencyid          = $agencyId;
            $aClientsIds[$advKey] = DataGenerator::generateOne($doClients);
            if (is_array($aAdvertiser['campaigns'])) {
                foreach ($aAdvertiser['campaigns'] as $campaignKey => $aCampaign) {
                    $doCampaigns->campaignname = $aCampaign['campaignname'];
                    $doCampaigns->clientid     = $aClientsIds[$advKey];
                    $aCampaignsIds[$advKey][$campaignKey] = DataGenerator::generateOne($doCampaigns);
                }
            }
        }
    }

    /**
     * Function returns expected array of websites and zones for given array of websites and zones and selected category
     * Sets category names if flat list of categories is given
     * Sets all statistics to null
     *
     * supplementary function to test getWebsitesAndZonesListByCategory
     *
     * @param array $aWebsitesAndZones formated as var _aWebsitesAndZones
     * @param array $aAffiliatesIds array of affiliates Id
     * @param array $aZonesIds array of zones Id
     * @param array $aCategoriesIds checked category/categories
     * @param array $aCategoriesList Flat list of categories
     * @return array
     */
    function _buildExpectedArrayOfWebsitesAndZones($aWebsitesAndZones, $aAffiliatesIds, $aZonesIds, $aCategoriesIds = null, $aCategoriesList)
    {
        $aZones = $this->_buildExpectedArrayOfZones($aWebsitesAndZones, $aAffiliatesIds, $aZonesIds, $aCategoriesIds);
        $aExpected = array();
        foreach($aZones as $aZone) {
            if (!array_key_exists($aZone['affiliateid'], $aExpected)) {
                if (array_key_exists($aZone['affiliate_oac_category_id'], $aCategoriesList)) {
                    $category = $aCategoriesList[$aZone['affiliate_oac_category_id']];
                } else {
                    $category = null;
                }
                $aExpected[$aZone['affiliateid']] =
                    array (
                        'name'            => $aZone['affiliatename'],
                        'oac_category_id' => $aZone['affiliate_oac_category_id'],
                        'category'        => $category,
                        'linked'        => null,
                    );
            }
            if (array_key_exists($aZone['zone_oac_category_id'], $aCategoriesList)) {
                $category = $aCategoriesList[$aZone['zone_oac_category_id']];
            } else {
                $category = null;
            }
            $aExpected[$aZone['affiliateid']]['zones'][$aZone['zoneid']] =
                array (
                    'name'            => $aZone['zonename'],
                    'oac_category_id' => $aZone['zone_oac_category_id'],
                    'category'        => $aCategoriesList[$aZone['zone_oac_category_id']],
                    'campaign_stats'  => false,
                    'ecpm'            => null,
                    'cr'              => null,
                    'ctr'             => null,
                    'linked'          => $aZone['islinked']
                );
        }
        return $aExpected;
    }

    /**
     * Function returns expected array of zones for given array of websites and zones and selected category
     *
     * supplementary function to test getZonesListByCategory
     *
     * @param array $aWebsitesAndZones formated as var _aWebsitesAndZones
     * @param array $aAffiliatesIds array of affiliates Id
     * @param array $aZonesIds array of zones Id
     * @param array $aCategoriesIds checked category/categories
     * @param boolean $linked true - return only linked zones, false - return only unlinked zones
     * @param string $serachString string matched to zones/websites names
     * @return array
     */
    function _buildExpectedArrayOfZones($aWebsitesAndZones, $aAffiliatesIds, $aZonesIds, $aCategoriesIds = null, $serachString = null)
    {
        $aExpected = array();
        $zone_oac_category_id = null;
        $website_oac_category_id = null;
        foreach ($aWebsitesAndZones as $websiteKey => $aWebsite) {
            if (is_array($aWebsite['zones'])) {
                if ($aWebsitesAndZones[$websiteKey]['oac_category_id'] == 'null') {
                    $website_oac_category_id = null;
                } else {
                    $website_oac_category_id = $aWebsitesAndZones[$websiteKey]['oac_category_id'];
                }
                foreach ($aWebsite['zones'] as $zoneKey => $aZone) {
                    // Add zone to list if:
                    //   - category of zone or parent website matches to given categories
                    //   AND
                    //   - zone name or parent website name includes search string
                    if ((
                            (!is_array($aCategoriesIds) ||
                                (in_array($aWebsitesAndZones[$websiteKey]['zones'][$zoneKey]['oac_category_id'], $aCategoriesIds) ||
                                in_array($aWebsitesAndZones[$websiteKey]['oac_category_id'], $aCategoriesIds)
                                )
                            ) ||
                            ($aCategoriesIds == -1 &&
                                $aWebsitesAndZones[$websiteKey]['zones'][$zoneKey]['oac_category_id'] == 'null'
                            )
                         ) &&
                         (is_null($serachString) ||
                             ((stripos($aWebsitesAndZones[$websiteKey]['name'], $serachString) !== false) ||
                              (stripos($aWebsitesAndZones[$websiteKey]['zones'][$zoneKey]['zonename'], $serachString) !== false)
                             )
                         )
                       )
                    {
                        if ( $aWebsitesAndZones[$websiteKey]['zones'][$zoneKey]['oac_category_id'] == 'null') {
                            $zone_oac_category_id = null;
                        } else {
                            $zone_oac_category_id = $aWebsitesAndZones[$websiteKey]['zones'][$zoneKey]['oac_category_id'];
                        }
                        $aExpected[] = array (
                                        'zoneid'                    => $aZonesIds[$websiteKey][$zoneKey],
                                        'zonename'                  => $aWebsitesAndZones[$websiteKey]['zones'][$zoneKey]['zonename'],
                                        'zone_oac_category_id'      => $zone_oac_category_id,
                                        'affiliateid'               => $aAffiliatesIds[$websiteKey],
                                        'affiliate_oac_category_id' => $website_oac_category_id,
                                        'affiliatename'             => $aWebsitesAndZones[$websiteKey]['name'],
                                        'islinked'                  => null
                                      );
                    }
                }
            }
        }
        return $aExpected;
    }

    /**
     * Method to test countZones method
     *
     */
    function testcountZones() {
        $dalZones = OA_Dal::factoryDAL('zones');

        // Create agency
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name = 'Ad Network Manager';
        $agencyId = DataGenerator::generateOne($doAgency);

        $result = $dalZones->countZones($agencyId, null, true);
        $this->assertEqual($result, 0);
        $result = $dalZones->countZones($agencyId, null, false);
        $this->assertEqual($result, 0);

        // Generate websites and zones
        $aAffiliatesIds = array();
        $aZonesIds = array();
        $this->_createWebsitesAndZones($this->_aWebsitesAndZones, $agencyId, $aAffiliatesIds, $aZonesIds);

        // Generate advertisers and campaigns
        $aClientsIds = array();
        $aCampaignsIds = array();
        $this->_createAdvertisersAndCampaigns($this->_aAdvertisersAndCampaigns, $agencyId, $aClientsIds, $aCampaignsIds);

        // Create agency 2
        $doAgency->name = 'Ad Network Manager 2';
        $agencyId2 = DataGenerator::generateOne($doAgency);

        // Generate websites and zones for agency 2
        $aAffiliatesIds2 = array();
        $aZonesIds2 = array();
        $this->_createWebsitesAndZones($this->_aWebsitesAndZones, $agencyId2, $aAffiliatesIds2, $aZonesIds2);

        // Generate advertisers and campaigns for agency 2
        $aClientsIds2 = array();
        $aCampaignsIds2 = array();
        $this->_createAdvertisersAndCampaigns($this->_aAdvertisersAndCampaigns, $agencyId2, $aClientsIds2, $aCampaignsIds2);

        $result = $dalZones->countZones($agencyId, null, null, true);
        $this->assertEqual($result, 0);
        $result = $dalZones->countZones($agencyId, null, null, false);
        $this->assertEqual($result, 5);

        $result = $dalZones->countZones($agencyId, null, $aCampaignsIds[1][1], true);
        $this->assertEqual($result, 0);
        $result = $dalZones->countZones($agencyId, null, $aCampaignsIds[1][1], false);
        $this->assertEqual($result, 5);

        // Link zones to campaigns
        $aFlatZonesIds1 = array($aZonesIds[1][1], $aZonesIds[1][2], $aZonesIds[2][1], $aZonesIds[2][2]);
        $result = $dalZones->linkZonesToCampaign($aFlatZonesIds1, $aCampaignsIds[1][1]);
        $aFlatZonesIds2 = array($aZonesIds[1][1], $aZonesIds[2][1]);
        $result = $dalZones->linkZonesToCampaign($aFlatZonesIds2, $aCampaignsIds[1][2]);

        $result = $dalZones->countZones($agencyId, null, $aCampaignsIds[1][1], true);
        $this->assertEqual($result, 4);
        $result = $dalZones->countZones($agencyId, null, $aCampaignsIds[1][1], false);
        $this->assertEqual($result, 1);

        $result = $dalZones->countZones($agencyId, null, null, true);
        $this->assertEqual($result, 0);
        $result = $dalZones->countZones($agencyId, null, null, false);
        $this->assertEqual($result, 5);
    }

    /**
     * Create OA_Central_AdNetworks mockup to returns given categories
     *
     * @param array $aCategories
     * @return PartialMockOA_Central_AdNetworks
     */
    function _setCategoriesMockup($aCategories)
    {
        $oAdNetworksPartialMock = new PartialMockOA_Central_AdNetworks($this);
        $oAdNetworksPartialMock->setReturnValue('retrievePermanentCache', $aCategories);
        return $oAdNetworksPartialMock;
    }

    /**
     * Method to test _getParentAndSubCategoriesIds method
     *
     */
    function test_getParentAndSubCategoriesIds()
    {
        $dalZones = OA_Dal::factoryDAL('zones');
        // Set categories mockup
        $dalZones->_oOaCentralAdNetworks = $this->_setCategoriesMockup($this->_aCategories);

        // Test get all subcategories
        $aResult = $dalZones->_getParentAndSubCategoriesIds(65);
        $aExpected = array(65, 6502, 6510, 6581);
        sort($aResult);
        sort($aExpected);
        $this->assertEqual($aResult,$aExpected);

        // Test when subcategory ID is passed
        $aResult = $dalZones->_getParentAndSubCategoriesIds(6502);
        $this->assertEqual($aResult,array(6502));
    }

    /**
     * Method to test linkZonesToCampaign method
     *
     */
    function _internalTestLinkZonesToCampaign()
    {
        $dalZones = OA_Dal::factoryDAL('zones');

        // Create agency
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name = 'Ad Network Manager';
        $agencyId = DataGenerator::generateOne($doAgency);

        // Generate websites and zones
        $aWebsitesAndZones = $this->_aWebsitesAndZones;
        $aWebsitesAndZones[1]['zones'][1]['width']    = 468;
        $aWebsitesAndZones[1]['zones'][1]['height']   = 60;
        $aWebsitesAndZones[1]['zones'][1]['delivery'] = phpAds_ZoneBanner;
        $aWebsitesAndZones[1]['zones'][2]['width']    = 468;
        $aWebsitesAndZones[1]['zones'][2]['height']   = 60;
        $aWebsitesAndZones[1]['zones'][2]['delivery'] = phpAds_ZoneText;
        $aWebsitesAndZones[1]['zones'][3]['width']    = 468;
        $aWebsitesAndZones[1]['zones'][3]['height']   = 60;
        $aWebsitesAndZones[1]['zones'][3]['delivery'] = MAX_ZoneEmail;
        $aWebsitesAndZones[2]['zones'][1]['width']    = -1;
        $aWebsitesAndZones[2]['zones'][1]['height']   = 60;
        $aWebsitesAndZones[2]['zones'][1]['delivery'] = phpAds_ZoneBanner;
        $aWebsitesAndZones[2]['zones'][2]['width']    = 120;
        $aWebsitesAndZones[2]['zones'][2]['height']   = -1;
        $aWebsitesAndZones[2]['zones'][1]['delivery'] = phpAds_ZoneBanner;

        $aAffiliatesIds = array();
        $aZonesIds = array();
        $this->_createWebsitesAndZones($aWebsitesAndZones, $agencyId, $aAffiliatesIds, $aZonesIds);

        // Generate advertisers and campaigns
        $aClientsIds = array();
        $aCampaignsIds = array();
        $this->_createAdvertisersAndCampaigns($this->_aAdvertisersAndCampaigns, $agencyId, $aClientsIds, $aCampaignsIds);

        // Create agency 2
        $doAgency->name = 'Ad Network Manager 2';
        $agencyId2 = DataGenerator::generateOne($doAgency);

        // Generate websites and zones for agency 2
        $aAffiliatesIds2 = array();
        $aZonesIds2 = array();
        $this->_createWebsitesAndZones($aWebsitesAndZones, $agencyId2, $aAffiliatesIds2, $aZonesIds2);

        // Generate advertisers and campaigns for agency 2
        $aClientsIds2 = array();
        $aCampaignsIds2 = array();
        $this->_createAdvertisersAndCampaigns($this->_aAdvertisersAndCampaigns, $agencyId2, $aClientsIds2, $aCampaignsIds2);

        $aBannerIds = array();

        // Add banners to campaigns
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->width       = 468;
        $doBanners->height      = 60;
        $doBanners->storagetype = 'web';

        $doBanners->name       = 'Banner 1 campaign 1 adv 1';
        $doBanners->campaignid = $aCampaignsIds[1][1];
        $aBannerIds[1][1][1]   = DataGenerator::generateOne($doBanners);

        $doBanners->name       = 'Banner 1 campaign 1 adv 2';
        $doBanners->campaignid = $aCampaignsIds[2][1];
        $aBannerIds[2][1][1]   = DataGenerator::generateOne($doBanners);

        $doBanners->width      = 120;
        $doBanners->height     = 600;

        $doBanners->name       = 'Banner 2 campaign 1 adv 1';
        $doBanners->campaignid = $aCampaignsIds[1][1];
        $aBannerIds[1][1][2]   = DataGenerator::generateOne($doBanners);


        $doBanners->name       = 'Banner 1 campaign 2 adv 1';
        $doBanners->campaignid = $aCampaignsIds[1][2];
        $aBannerIds[1][2][1]   = DataGenerator::generateOne($doBanners);

        // One banner for agency 2
        $doBanners->name       = 'Banner 1 campaign 1 adv 1 (agency 2)';
        $doBanners->campaignid = $aCampaignsIds2[1][1];
        $aBannerIds2[1][1][1]   = DataGenerator::generateOne($doBanners);

        // One text banner
        $doBanners->storagetype = 'txt';
        $doBanners->width      = 0;
        $doBanners->height     = 0;

        $doBanners->name       = 'Banner 3 campaign 1 adv 1';
        $doBanners->campaignid = $aCampaignsIds[1][1];
        $aBannerIds[1][1][3]   = DataGenerator::generateOne($doBanners);

        // Empty zones array
        $result = $dalZones->linkZonesToCampaign(array(),$aCampaignsIds[1][1]);
        $this->assertEqual($result, -1);

        $doPlacementZoneAssoc = OA_Dal::factoryDO('placement_zone_assoc');
        $this->assertEqual($doPlacementZoneAssoc->count(),0);

        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->whereAdd('zone_id <> 0');
        $this->assertEqual($doAdZoneAssoc->count(),0);

        // One of zones is from different agency
        $result = $dalZones->linkZonesToCampaign(array($aZonesIds2[1][1], $aZonesIds[1][1]), $aCampaignsIds[1][1]);
        $this->assertEqual($result, -1);

        $doPlacementZoneAssoc = OA_Dal::factoryDO('placement_zone_assoc');
        $this->assertEqual($doPlacementZoneAssoc->count(),0);

        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->whereAdd('zone_id <> 0');
        $this->assertEqual($doAdZoneAssoc->count(),0);

        // Add 5 zones to campaign
        $aFlatZonesIds = array($aZonesIds[1][1], $aZonesIds[1][2], $aZonesIds[1][3], $aZonesIds[2][1], $aZonesIds[2][2]);
        $result = $dalZones->linkZonesToCampaign($aFlatZonesIds, $aCampaignsIds[1][1]);
        $this->assertEqual($result, 4);

        $doPlacementZoneAssoc = OA_Dal::factoryDO('placement_zone_assoc');
        $this->assertEqual($doPlacementZoneAssoc->count(),4);

        $doPlacementZoneAssoc->orderBy('zone_id');
        $doPlacementZoneAssoc->find();
        $counter = 0;
        $aExpectedLinkedZonesIds = array($aZonesIds[1][1], $aZonesIds[1][2], $aZonesIds[2][1], $aZonesIds[2][2]);
        while($doPlacementZoneAssoc->fetch()) {
            $aPlacementZoneAssoc = $doPlacementZoneAssoc->toArray();
            $this->assertEqual($aPlacementZoneAssoc['zone_id'], $aExpectedLinkedZonesIds[$counter]);
            $this->assertEqual($aPlacementZoneAssoc['placement_id'], $aCampaignsIds[1][1]);
            $counter++;
        }

        // expected result:
        //  $aBannerIds[1][1][1] (468x60)  should be linked to $ZonesIds[1][1], $ZonesIds[2][1]
        //  $aBannerIds[1][1][2] (120x600) should be linked to $ZonesIds[2][2]
        //  $aBannerIds[1][1][3] (txt    ) should be linked to $ZonesIds[1][2]
        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->whereAdd('zone_id <> 0');
        $this->assertEqual($doAdZoneAssoc->count(), 4);

        $aExpectedAdZoneAssocs = array(
                        array ('zone_id' => $aZonesIds[1][1], 'ad_id' => $aBannerIds[1][1][1]),
                        array ('zone_id' => $aZonesIds[2][1], 'ad_id' => $aBannerIds[1][1][1]),
                        array ('zone_id' => $aZonesIds[2][2], 'ad_id' => $aBannerIds[1][1][2]),
                        array ('zone_id' => $aZonesIds[1][2], 'ad_id' => $aBannerIds[1][1][3])
                );
        foreach($aExpectedAdZoneAssocs as $row => $aExpectedAdZoneAssoc) {
            $doAdZoneAssoc          = OA_Dal::factoryDO('ad_zone_assoc');
            $doAdZoneAssoc->zone_id = $aExpectedAdZoneAssoc['zone_id'];
            $doAdZoneAssoc->ad_id   = $aExpectedAdZoneAssoc['ad_id'];
            $this->assertEqual($doAdZoneAssoc->count(), 1, "found {$doAdZoneAssoc->count()} row ad_zone_assoc for \$aExpectedAdZoneAssocs[{$row}] when expected 1 row");
        }
    }

    
    function testLinkZonesToCampaignWithAuditTrail()
    {
        $GLOBALS['_MAX']['CONF']['audit']['enabledForZoneLinking'] = true;
        $this->_internalTestLinkZonesToCampaign();
    }
    
    
    function testLinkZonesToCampaignWithNoAuditTrail()
    {
        $GLOBALS['_MAX']['CONF']['audit']['enabledForZoneLinking'] = false;
        $this->_internalTestLinkZonesToCampaign();
    }
    

    /**
     * Method to test checkZonesCampaignRealm method
     *
     */
    function test_checkZonesCampaignRealm()
    {
        $dalZones = OA_Dal::factoryDAL('zones');

        // Create agency
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name = 'Ad Network Manager';
        $agencyId = DataGenerator::generateOne($doAgency);

        // Generate websites and zones
        $aAffiliatesIds = array();
        $aZonesIds = array();
        $this->_createWebsitesAndZones($this->_aWebsitesAndZones, $agencyId, $aAffiliatesIds, $aZonesIds);

        // Generate advertisers and campaigns
        $aClientsIds = array();
        $aCampaignsIds = array();
        $this->_createAdvertisersAndCampaigns($this->_aAdvertisersAndCampaigns, $agencyId, $aClientsIds, $aCampaignsIds);

        // Create agency 2
        $doAgency->name = 'Ad Network Manager 2';
        $agencyId2 = DataGenerator::generateOne($doAgency);

        // Generate websites and zones for agency 2
        $aAffiliatesIds2 = array();
        $aZonesIds2 = array();
        $this->_createWebsitesAndZones($this->_aWebsitesAndZones, $agencyId2, $aAffiliatesIds2, $aZonesIds2);

        // Generate advertisers and campaigns for agency 2
        $aClientsIds2 = array();
        $aCampaignsIds2 = array();
        $this->_createAdvertisersAndCampaigns($this->_aAdvertisersAndCampaigns, $agencyId2, $aClientsIds2, $aCampaignsIds2);

        // Test empty zones
        $result = $dalZones->_checkZonesCampaignRealm(array(), $aCampaignsIds[1][1]);
        $this->assertFalse($result);

        // Test one matching zone and one from other agency
        $result = $dalZones->_checkZonesCampaignRealm(array($aZonesIds2[1][1], $aZonesIds[1][1]), $aCampaignsIds[1][1]);
        $this->assertFalse($result);

        // Test zones from the same agency
        $result = $dalZones->_checkZonesCampaignRealm(array($aZonesIds[1][1], $aZonesIds[1][3], $aZonesIds[2][1]), $aCampaignsIds[1][1]);
        $this->assertTrue($result);

        // Test non existing campaign
        $result = $dalZones->_checkZonesCampaignRealm(array($aZonesIds[1][1], $aZonesIds[1][3], $aZonesIds[2][1]), -1);
        $this->assertFalse($result);
    }

    /**
     * Tests unlinkZonesFromCampaign method
     *
     */
    function testUnlinkZonesFromCampaign()
    {
        $dalZones = OA_Dal::factoryDAL('zones');

        // Create agency
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name = 'Ad Network Manager';
        $agencyId = DataGenerator::generateOne($doAgency);

        // Generate websites and zones
        $aWebsitesAndZones = $this->_aWebsitesAndZones;
        foreach($aWebsitesAndZones as $websiteKey => $aWebsite) {
            if (is_array($aWebsite['zones'])) {
                foreach($aWebsite['zones'] as $zoneKey => $aZone) {
                     $aWebsitesAndZones[$websiteKey]['zones'][$zoneKey]['width']    = 468;
                     $aWebsitesAndZones[$websiteKey]['zones'][$zoneKey]['height']   = 60;
                     $aWebsitesAndZones[$websiteKey]['zones'][$zoneKey]['delivery'] = phpAds_ZoneBanner;
                }
            }
        }

        $aAffiliatesIds = array();
        $aZonesIds = array();
        $this->_createWebsitesAndZones($aWebsitesAndZones, $agencyId, $aAffiliatesIds, $aZonesIds);

        // Generate advertisers and campaigns
        $aClientsIds = array();
        $aCampaignsIds = array();
        $this->_createAdvertisersAndCampaigns($this->_aAdvertisersAndCampaigns, $agencyId, $aClientsIds, $aCampaignsIds);

        $aBannerIds = array();

        // Add banners to campaigns
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->width      = 468;
        $doBanners->height     = 60;

        $doBanners->name       = 'Banner 1 campaign 1 adv 1';
        $doBanners->campaignid = $aCampaignsIds[1][1];
        $aBannerIds[1][1][1]   = DataGenerator::generateOne($doBanners);

        $doBanners->name       = 'Banner 2 campaign 1 adv 1';
        $doBanners->campaignid = $aCampaignsIds[1][1];
        $aBannerIds[1][1][2]   = DataGenerator::generateOne($doBanners);

        $doBanners->name       = 'Banner 1 campaign 1 adv 2';
        $doBanners->campaignid = $aCampaignsIds[2][1];
        $aBannerIds[2][1][1]   = DataGenerator::generateOne($doBanners);

        $doBanners->name       = 'Banner 1 campaign 2 adv 1';
        $doBanners->campaignid = $aCampaignsIds[1][2];
        $aBannerIds[1][2][1]   = DataGenerator::generateOne($doBanners);

        // Link banners and zones to campaigns
        $aFlatZonesIds1 = array($aZonesIds[1][1], $aZonesIds[1][2], $aZonesIds[1][3], $aZonesIds[2][1], $aZonesIds[2][2]);
        $result = $dalZones->linkZonesToCampaign($aFlatZonesIds1, $aCampaignsIds[1][1]);
        $aFlatZonesIds2 = array($aZonesIds[1][1], $aZonesIds[2][1]);
        $result = $dalZones->linkZonesToCampaign($aFlatZonesIds2, $aCampaignsIds[1][2]);

        // Empty zones array
        $result = $dalZones->unlinkZonesFromCampaign(array(),$aCampaignsIds[1][1]);
        $this->assertEqual($result, 0);

        // Check if there is still 7 placement_zone_assoc (5 zones linked to $aCampaignsIds[1][1] and 2 zones linked to $aCampaignsIds[1][2])
        $doPlacementZoneAssoc = OA_Dal::factoryDO('placement_zone_assoc');
        $this->assertEqual($doPlacementZoneAssoc->count(),7);

        // Check if there is still 12 ad_zone_assoc (5*2=10 banners linked to $aCampaignsIds[1][1] and 2*1=2 banners linked to $aCampaignsIds[1][2])
        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->whereAdd('zone_id <> 0');
        $this->assertEqual($doAdZoneAssoc->count(),12);

        // remove all zones from $aCampaignsIds[1][2]
        $result = $dalZones->unlinkZonesFromCampaign($aFlatZonesIds2, $aCampaignsIds[1][2]);
        $this->assertEqual($result, 2);

        $doPlacementZoneAssoc = OA_Dal::factoryDO('placement_zone_assoc');
        $this->assertEqual($doPlacementZoneAssoc->count(),5);

        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->whereAdd('zone_id <> 0');
        $this->assertEqual($doAdZoneAssoc->count(),10);

        $doPlacementZoneAssoc = OA_Dal::factoryDO('placement_zone_assoc');
        $doPlacementZoneAssoc->placement_id =  $aCampaignsIds[1][2];
        $this->assertEqual($doPlacementZoneAssoc->count(),0);

        // Remove 4 zones from campaign 1
        $aFlatZonesIds3 = array($aZonesIds[1][2], $aZonesIds[1][3], $aZonesIds[2][1], $aZonesIds[2][2]);
        $result = $dalZones->unlinkZonesFromCampaign($aFlatZonesIds3, $aCampaignsIds[1][1]);
        $this->assertEqual($result, 4);

        $doPlacementZoneAssoc = OA_Dal::factoryDO('placement_zone_assoc');
        $this->assertEqual($doPlacementZoneAssoc->count(),1);       // one zone<->campaing

        $doPlacementZoneAssoc->find();
        $doPlacementZoneAssoc->fetch();
        $aPlacementZoneAssoc = $doPlacementZoneAssoc->toArray();
        $this->assertEqual($aPlacementZoneAssoc['zone_id'], $aZonesIds[1][1]);
        $this->assertEqual($aPlacementZoneAssoc['placement_id'], $aCampaignsIds[1][1]);

        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->whereAdd('zone_id <> 0');
        $this->assertEqual($doAdZoneAssoc->count(),2);              // zone with 2 banners

        // expected result:
        //  $aBannerIds[1][1][1] linked to zone $aZonesIds[1][1]
        //  $aBannerIds[1][1][2] linked to zone $aZonesIds[1][1]

        $aExpectedAdZoneAssocs = array(
                        array ('zone_id' => $aZonesIds[1][1], 'ad_id' => $aBannerIds[1][1][1]),
                        array ('zone_id' => $aZonesIds[1][1], 'ad_id' => $aBannerIds[1][1][2]),
                );
        foreach($aExpectedAdZoneAssocs as $aExpectedAdZoneAssoc) {
            $doAdZoneAssoc          = OA_Dal::factoryDO('ad_zone_assoc');
            $doAdZoneAssoc->zone_id = $aExpectedAdZoneAssoc['zone_id'];
            $doAdZoneAssoc->ad_id   = $aExpectedAdZoneAssoc['ad_id'];
            $this->assertEqual($doAdZoneAssoc->count(), 1, "ad_zone_assoc not found for zone_id={$aExpectedAdZoneAssoc['zone_id']} and ad_id={$aExpectedAdZoneAssoc['ad_id']}");
        }

        // Remove last linked zone
        $result = $dalZones->unlinkZonesFromCampaign(array($aZonesIds[1][1]), $aCampaignsIds[1][1]);
        $this->assertEqual($result, 1);

        $doPlacementZoneAssoc = OA_Dal::factoryDO('placement_zone_assoc');
        $this->assertEqual($doPlacementZoneAssoc->count(),0);

        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->whereAdd('zone_id <> 0');
        $this->assertEqual($doAdZoneAssoc->count(),0);
    }

    /**
     * Tests getCategoriesIdsFromZones method
     *
     */
    function testGetCategoriesIdsFromZones() {
        $dalZones = OA_Dal::factoryDAL('zones');

        // Create agency
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name = 'Ad Network Manager';
        $agencyId = DataGenerator::generateOne($doAgency);

        // Generate websites and zones
        $aAffiliatesIds = array();
        $aZonesIds = array();
        $this->_createWebsitesAndZones($this->_aWebsitesAndZones, $agencyId, $aAffiliatesIds, $aZonesIds);


        // Test invocation with no parameters
        $result = $dalZones->getCategoriesIdsFromZones();
        $this->assertFalse($result);

        // Test empty array
        $aResult = $dalZones->getCategoriesIdsFromZones(array());
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test if this doesn't duplicate categories ids, and deal with null values
        $aResult = $dalZones->getCategoriesIdsFromZones(array($aZonesIds[1][2], $aZonesIds[2][2], $aZonesIds[1][3]), false);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[0], 6502);

        // Test the same but include parent websites categories
        $aResult = $dalZones->getCategoriesIdsFromZones(array($aZonesIds[1][2], $aZonesIds[2][2], $aZonesIds[1][3]), true);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        sort($aResult);
        $this->assertEqual($aResult[0], 6502);
        $this->assertEqual($aResult[1], 6510);

        // Test dealing with duplicate categories - to previous test add zone [1][1] witch have the same category as website
        $aResult = $dalZones->getCategoriesIdsFromZones(array($aZonesIds[1][1], $aZonesIds[1][2], $aZonesIds[2][2], $aZonesIds[1][3]), true);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        sort($aResult);
        $this->assertEqual($aResult[0], 6502);
        $this->assertEqual($aResult[1], 6510);
    }

    /**
     * Method to test getCategoriesIdsFromWebsitesAndZones method
     *
     */
    function testGetCategoriesIdsFromWebsitesAndZones() {
        $dalZones = OA_Dal::factoryDAL('zones');
        // Set categories mockup
        $dalZones->_oOaCentralAdNetworks = $this->_setCategoriesMockup($this->_aCategories);
        $aFlatCategories = $dalZones->_oOaCentralAdNetworks->getCategoriesFlat();

        $aAffiliatesIds = array(1=>1, 2=>2, 3=>3);
        $aZonesIds = array( 1 => array(1=>1, 2=>2, 3=>3),
                            2 => array(1=>4, 2=>5));
        $aWebsites = $this->_buildExpectedArrayOfWebsitesAndZones($this->_aWebsitesAndZones, $aAffiliatesIds, $aZonesIds, null, $aFlatCategories );
        $aResult = $dalZones->getCategoriesIdsFromWebsitesAndZones($aWebsites);
        sort($aResult);
        $this->assertEqual($aResult, array (6502, 6510, 6581));
    }

   function testCheckZoneLinkedToActiveCampaign()
    {
        $dllZonePartialMock = new PartialMockOA_Dll_Zone();
        $dllZonePartialMock->setReturnValue('checkPermissions', true);

        $doZones = OA_Dal::factoryDO('zones');
        $doZones->width  = '468';
        $doZones->height = '60';
        $zoneId  = DataGenerator::generateOne($doZones);
        $zoneId2 = DataGenerator::generateOne($doZones);

        $doCampaigns = OA_Dal::factoryDo('campaigns');
        $campaignId1 = DataGenerator::generateOne($doCampaigns);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->width  = '468';
        $doBanners->height = '60';
        $doBanners->campaignid=$campaignId1;
        $bannerId = DataGenerator::generateOne($doBanners);

        $doCampaigns = OA_Dal::factoryDo('campaigns');
        $campaignId2 = DataGenerator::generateOne($doCampaigns);

        // Test zone without banners or campaigns
        $this->assertFalse($this->dalZones->checkZoneLinkedToActiveCampaign($zoneId));

        $dllZonePartialMock->linkBanner($zoneId, $bannerId);
        $dllZonePartialMock->linkCampaign($zoneId2, $campaignId2);

        // Test one zone with banner and one with empty campaign
        $this->assertTrue($this->dalZones->checkZoneLinkedToActiveCampaign($zoneId));
        $this->assertTrue($this->dalZones->checkZoneLinkedToActiveCampaign($zoneId2));

        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId2);
        $doCampaigns->active = 'f';
        $doCampaigns->expire = '1970-01-01'; // This date expires campaign
        $doCampaigns->update();

        // Test zone with expired campaign
        $this->assertFalse($this->dalZones->checkZoneLinkedToActiveCampaign($zoneId2));
    }
}
?>
