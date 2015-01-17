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

require_once MAX_PATH . '/lib/OA/Dll/Publisher.php';
require_once MAX_PATH . '/lib/OA/Dll/PublisherInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/Zone.php';
require_once MAX_PATH . '/lib/OA/Dll/ZoneInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/tests/util/DllUnitTestCase.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Campaigns.php';

/**
 * A class for testing DLL Zone methods
 *
 * @package    OpenXDll
 * @subpackage TestSuite
 */


class OA_Dll_ZoneTest extends DllUnitTestCase
{
    /**
     * @var int
     */
    var $agencyId;

    /**
     * Errors
     *
     */
    var $unknownIdError = 'Unknown zoneId Error';
    var $chainError = 'Cannot chain a zone to itself';

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
        Mock::generatePartial(
            'OA_Dll_Publisher',
            'PartialMockOA_Dll_Publisher_ZoneTest',
            array('checkPermissions', 'getDefaultAgencyId')
        );
        Mock::generatePartial(
            'OA_Dll_Zone',
            'PartialMockOA_Dll_Zone',
            array('checkPermissions')
        );
    }

    function setUp()
    {
        $this->agencyId = DataGenerator::generateOne('agency');
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    /**
     * A method to test Add, Modify and Delete.
     */
    function testAddModifyDelete()
    {
        $dllPublisherPartialMock = new PartialMockOA_Dll_Publisher_ZoneTest($this);
        $dllZonePartialMock      = new PartialMockOA_Dll_Zone($this);

        $dllPublisherPartialMock->setReturnValue('getDefaultAgencyId', $this->agencyId);
        $dllPublisherPartialMock->setReturnValue('checkPermissions', true);
        $dllPublisherPartialMock->expectCallCount('checkPermissions', 2);

        $dllZonePartialMock->setReturnValue('checkPermissions', true);
        $dllZonePartialMock->expectCallCount('checkPermissions', 10);

        $oZoneInfo      = new OA_DLL_ZoneInfo();
        $oPublisherInfo = new OA_DLL_PublisherInfo();
        $oPublisherInfo->publisherName = "Publisher";
        $oPublisherInfo->agencyId = $this->agencyId;

        $dllPublisherPartialMock->modify($oPublisherInfo);

        $oZoneInfo->zoneName = 'test zone';
        $oZoneInfo->publisherId = $oPublisherInfo->publisherId;

        // Add
        $this->assertTrue($dllZonePartialMock->modify($oZoneInfo),
            $dllZonePartialMock->getLastError());

        // Modify
        $oZoneInfo->zoneName = 'modified zone';

        $this->assertTrue($dllZonePartialMock->modify($oZoneInfo),
            $dllZonePartialMock->getLastError());

        // Chain zone to itself
        $oZoneInfo->chainedZoneId = $oZoneInfo->zoneId;
        $this->assertTrue((!$dllZonePartialMock->modify($oZoneInfo) &&
                $dllZonePartialMock->getLastError() == $this->chainError),
            $this->_getMethodShouldReturnError($this->chainError));

        // Chain zone to non existing zone
        $oZoneInfo->chainedZoneId = 100000;
        $this->assertTrue((!$dllZonePartialMock->modify($oZoneInfo) &&
                $dllZonePartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        // Delete
        $this->assertTrue($dllZonePartialMock->delete($oZoneInfo->zoneId),
            $dllZonePartialMock->getLastError());

        // Modify not existing id
        $this->assertTrue((!$dllZonePartialMock->modify($oZoneInfo) &&
                $dllZonePartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        // Delete not existing id
        $this->assertTrue((!$dllZonePartialMock->delete($oZoneInfo->zoneId) &&
                $dllZonePartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        $dllZonePartialMock   ->tally();
    }

    /**
     * A method to test get and getList method.
     */
    function testGetAndGetList()
    {
        $dllPublisherPartialMock = new PartialMockOA_Dll_Publisher_ZoneTest($this);
        $dllZonePartialMock      = new PartialMockOA_Dll_Zone($this);

        $dllPublisherPartialMock->setReturnValue('getDefaultAgencyId', $this->agencyId);
        $dllPublisherPartialMock->setReturnValue('checkPermissions', true);
        $dllPublisherPartialMock->expectCallCount('checkPermissions', 2);

        $dllZonePartialMock->setReturnValue('checkPermissions', true);
        $dllZonePartialMock->expectCallCount('checkPermissions', 7);

        $oPublisherInfo = new OA_DLL_PublisherInfo();
        $oPublisherInfo->publisherName = "Publisher";
        $oPublisherInfo->agencyId = $this->agencyId;
        $dllPublisherPartialMock->modify($oPublisherInfo);

        $oZoneInfo1              = new OA_Dll_ZoneInfo();
        $oZoneInfo1->publisherId = $oPublisherInfo->publisherId;
        $oZoneInfo1->zoneName    = 'test name 1';
        $oZoneInfo1->type        = 2;
        $oZoneInfo1->width       = 4;
        $oZoneInfo1->height      = 5;

        $oZoneInfo2                 = new OA_Dll_ZoneInfo();
        $oZoneInfo2->publisherId    = $oPublisherInfo->publisherId;
        $oZoneInfo2->zoneName       = 'test name 2';

        // Add zone 1
        $this->assertTrue($dllZonePartialMock->modify($oZoneInfo1),
                          $dllZonePartialMock->getLastError());

        // Chain zone 2 to 1
        $oZoneInfo2->chainedZoneId = $oZoneInfo1->zoneId;

        // Add zone 2
        $this->assertTrue($dllZonePartialMock->modify($oZoneInfo2),
                          $dllZonePartialMock->getLastError());

        $oZoneInfo1Get = null;
        $oZoneInfo2Get = null;

        // Get
        $this->assertTrue($dllZonePartialMock->getZone($oZoneInfo1->zoneId,
                                                                   $oZoneInfo1Get),
                          $dllZonePartialMock->getLastError());
        $this->assertTrue($dllZonePartialMock->getZone($oZoneInfo2->zoneId,
                                                                   $oZoneInfo2Get),
                          $dllZonePartialMock->getLastError());

        // Check field value
        $this->assertFieldEqual($oZoneInfo1, $oZoneInfo1Get, 'zoneName');
        $this->assertFieldEqual($oZoneInfo1, $oZoneInfo1Get, 'publisherId');
        $this->assertFieldEqual($oZoneInfo1, $oZoneInfo1Get, 'type');
        $this->assertFieldEqual($oZoneInfo1, $oZoneInfo1Get, 'width');
        $this->assertFieldEqual($oZoneInfo1, $oZoneInfo1Get, 'height');
        $this->assertFieldEqual($oZoneInfo2, $oZoneInfo2Get, 'zoneName');
        $this->assertFieldEqual($oZoneInfo2, $oZoneInfo2Get, 'chainedZoneId');

        // Get List
        $aZoneList = array();
        $this->assertTrue($dllZonePartialMock->getZoneListByPublisherId($oPublisherInfo->publisherId,
                                                                        $aZoneList),
                          $dllZonePartialMock->getLastError());
        $this->assertEqual(count($aZoneList) == 2,
                           '2 records should be returned');
        $oZoneInfo1Get = $aZoneList[0];
        $oZoneInfo2Get = $aZoneList[1];
        if ($oZoneInfo1->zoneId == $oZoneInfo2Get->zoneId) {
            $oZoneInfo1Get = $aZoneList[1];
            $oZoneInfo2Get = $aZoneList[0];
        }
        // Check field value from list
        $this->assertFieldEqual($oZoneInfo1, $oZoneInfo1Get, 'zoneName');
        $this->assertFieldEqual($oZoneInfo2, $oZoneInfo2Get, 'zoneName');


        // Delete
        $this->assertTrue($dllZonePartialMock->delete($oZoneInfo1->zoneId),
            $dllZonePartialMock->getLastError());

        // Get not existing id
        $this->assertTrue((!$dllZonePartialMock->getZone($oZoneInfo1->zoneId,
                                                                     $oZoneInfo1Get) &&
                          $dllZonePartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        $dllZonePartialMock->tally();
    }

    /**
     * Method to run all tests for zone statistics
     *
     * @access private
     *
     * @param string $methodName  Method name in Dll
     */
    function _testStatistics($methodName)
    {
        $dllPublisherPartialMock = new PartialMockOA_Dll_Publisher_ZoneTest($this);
        $dllZonePartialMock      = new PartialMockOA_Dll_Zone($this);

        $dllPublisherPartialMock->setReturnValue('getDefaultAgencyId', $this->agencyId);
        $dllPublisherPartialMock->setReturnValue('checkPermissions', true);
        $dllPublisherPartialMock->expectCallCount('checkPermissions', 2);

        $dllZonePartialMock->setReturnValue('checkPermissions', true);
        $dllZonePartialMock->expectCallCount('checkPermissions', 5);

        $oZoneInfo      = new OA_DLL_ZoneInfo();
        $oPublisherInfo = new OA_DLL_PublisherInfo();
        $oPublisherInfo->publisherName = "Publisher";
        $oPublisherInfo->agencyId = $this->agencyId;

        $dllPublisherPartialMock->modify($oPublisherInfo);
        $oZoneInfo->publisherId = $oPublisherInfo->publisherId;

        // Add
        $this->assertTrue($dllZonePartialMock->modify($oZoneInfo),
            $dllZonePartialMock->getLastError());

        // Get no data
        $rsZoneStatistics = null;
        $this->assertTrue($dllZonePartialMock->$methodName(
                $oZoneInfo->zoneId, new Date('2001-12-01'),
                new Date('2007-09-19'), false, $rsZoneStatistics),
            $dllZonePartialMock->getLastError());

        $this->assertTrue(isset($rsZoneStatistics));
        if (is_array($rsZoneStatistics)) {
            $this->assertEqual(count($rsZoneStatistics), 0, 'No records should be returned');
        } else {
            $this->assertEqual($rsZoneStatistics->getRowCount(), 0, 'No records should be returned');
        }

        // Test for wrong date order
        $rsZoneStatistics = null;
        $this->assertTrue((!$dllZonePartialMock->$methodName(
                    $oZoneInfo->zoneId, new Date('2007-09-19'),
                    new Date('2001-12-01'), false,
                $rsZoneStatistics) &&
            $dllZonePartialMock->getLastError() == $this->wrongDateError),
            $this->_getMethodShouldReturnError($this->wrongDateError));

        // Delete
        $this->assertTrue($dllZonePartialMock->delete($oZoneInfo->zoneId),
            $dllZonePartialMock->getLastError());

        // Test statistics for not existing id
        $rsZoneStatistics = null;
        $this->assertTrue((!$dllZonePartialMock->$methodName(
                    $oZoneInfo->zoneId, new Date('2001-12-01'),
                    new Date('2007-09-19'), false,
                $rsZoneStatistics) &&
            $dllZonePartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        $dllZonePartialMock->tally();
    }

    /**
     * A method to test getZoneDailyStatistics.
     */
    function testDailyStatistics()
    {
        $this->_testStatistics('getZoneDailyStatistics');
    }

    /**
     * A method to test getZoneAdvertiserStatistics.
     */
    function testAdvertiserStatistics()
    {
        $this->_testStatistics('getZoneAdvertiserStatistics');
    }

    /**
     * A method to test getZoneCampaignStatistics.
     */
    function testCampaignStatistics()
    {
        $this->_testStatistics('getZoneCampaignStatistics');
    }

    /**
     * A method to test getZoneBannerStatistics.
     */
    function testBannerStatistics()
    {
        $this->_testStatistics('getZoneBannerStatistics');
    }

    function testLinkUnlinkBanner()
    {
        $dllZonePartialMock = new PartialMockOA_Dll_Zone($this);

        $dllZonePartialMock->setReturnValue('checkPermissions', true);
        $dllZonePartialMock->expectCallCount('checkPermissions', 5);

        // Non existent zone
        $this->assertFalse($dllZonePartialMock->linkBanner(1, 1));

        $doZones = OA_Dal::factoryDO('zones');
        $doZones->width  = '468';
        $doZones->height = '60';
        $zoneId = DataGenerator::generateOne($doZones);

        // Non existent banner
        $this->assertFalse($dllZonePartialMock->linkBanner($zoneId, 1));

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->width  = '468';
        $doBanners->height = '60';
        $bannerId = DataGenerator::generateOne($doBanners);

        // Matching banner
        $this->assertTrue($dllZonePartialMock->linkBanner($zoneId, $bannerId));

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->width  = '234';
        $doBanners->height = '60';
        $bannerId2 = DataGenerator::generateOne($doBanners);

        // Non matching banner
        $this->assertFalse($dllZonePartialMock->linkBanner($zoneId, $bannerId2));

        // Matching banner
        $this->assertTrue($dllZonePartialMock->unlinkBanner($zoneId, $bannerId));

        // Non matching banner
        $this->assertFalse($dllZonePartialMock->unlinkBanner($zoneId, $bannerId2));
    }

    function testLinkUnlinkCampaign()
    {
        $dllZonePartialMock = new PartialMockOA_Dll_Zone($this);

        $dllZonePartialMock->setReturnValue('checkPermissions', true);
        $dllZonePartialMock->expectCallCount('checkPermissions', 3);

        // Non existent zone
        $this->assertFalse($dllZonePartialMock->linkCampaign(1, 1));

        $doZones = OA_Dal::factoryDO('zones');
        $doZones->width  = '468';
        $doZones->height = '60';
        $zoneId = DataGenerator::generateOne($doZones);

        // Non existent banner
        $this->assertFalse($dllZonePartialMock->linkCampaign($zoneId, 1));

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->width  = '468';
        $doBanners->height = '60';
        $bannerId = DataGenerator::generateOne($doBanners, true);

        $doBanners  = OA_Dal::staticGetDO('banners', $bannerId);
        $campaignId = $doBanners->campaignid;

        $this->assertTrue($dllZonePartialMock->linkCampaign($zoneId, $campaignId));

        $this->assertTrue($dllZonePartialMock->unlinkCampaign($zoneId, $campaignId));
    }

    function testGenerateTags()
    {
        TestEnv::installPluginPackage('openXInvocationTags');
        $dllZonePartialMock = new PartialMockOA_Dll_Zone($this);

        $dllZonePartialMock->setReturnValue('checkPermissions', true);
        $dllZonePartialMock->expectCallCount('checkPermissions', 4);

        // Non existent zone
        $this->assertFalse($dllZonePartialMock->generateTags(1, 'foo'));

        $doZones = OA_Dal::factoryDO('zones');
        $doZones->width  = '468';
        $doZones->height = '60';
        $zoneId = DataGenerator::generateOne($doZones);

        // Non existent code type
        $this->assertFalse($dllZonePartialMock->generateTags($zoneId, 'foo'));

        // Not allowed code type
        $isAllowedAdjsTags = $GLOBALS['_MAX']['CONF']['oxInvocationTags']['isAllowedAdjs'];
        $GLOBALS['_MAX']['CONF']['oxInvocationTags']['isAllowedAdjs'] = false;
        $this->assertFalse($dllZonePartialMock->generateTags($zoneId, 'adjs'));

        // Allowed code type
        $GLOBALS['_MAX']['CONF']['oxInvocationTags']['isAllowedAdjs'] = true;
        $tag1 = $dllZonePartialMock->generateTags($zoneId, 'adjs');
        $tag2 = $dllZonePartialMock->generateTags($zoneId, 'adjs', array('source' => 'x'));

        $this->assertTrue($tag1);
        $this->assertTrue($tag2);
        $this->assertNotEqual($tag1, $tag2);
        $GLOBALS['_MAX']['CONF']['oxInvocationTags']['isAllowedAdjs'] = $isAllowedAdjsTags;
        TestEnv::uninstallPluginPackage('openXInvocationTags');
    }

    function testGetAllowedTags()
    {
        TestEnv::installPluginPackage('openXInvocationTags');
        $dllZone = new OA_Dll_Zone();
        $aZoneAllowedTags = $dllZone->getAllowedTags();
        // Test if only and all allowed tags are returned
        $count = 0;
        $invocationTags =& OX_Component::getComponents('invocationTags');
        foreach($invocationTags as $pluginKey => $invocationTag) {
            if ($invocationTag->isAllowed(null, null)){
                $count++;
                $this->assertTrue(in_array($pluginKey, $aZoneAllowedTags));
            } else {
                $this->assertFalse(in_array($pluginKey, $aZoneAllowedTags));
            }
        }
        $this->assertEqual($count, count($aZoneAllowedTags));
        // tests if spc is disallowed anyway
        $GLOBALS['_MAX']['CONF']['spc']['allowed'] = true;
        $aZoneAllowedTags = $dllZone->getAllowedTags();
        $this->assertFalse(in_array('spc',$aZoneAllowedTags));
        unset ($GLOBALS['_MAX']['CONF']['spc']['allowed']);
        TestEnv::uninstallPluginPackage('openXInvocationTags');
    }
}

?>
