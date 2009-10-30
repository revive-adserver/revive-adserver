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

require_once MAX_PATH . '/lib/OA/Dll/Advertiser.php';
require_once MAX_PATH . '/lib/OA/Dll/AdvertiserInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/Campaign.php';
require_once MAX_PATH . '/lib/OA/Dll/CampaignInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/tests/util/DllUnitTestCase.php';

/**
 * A class for testing DLL Campaign methods
 *
 * @package    OpenXDll
 * @subpackage TestSuite
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 */


class OA_Dll_CampaignTest extends DllUnitTestCase
{
    /**
     * @var int
     */
    var $agencyId;

    /**
     * Errors
     *
     */
    var $unknownIdError = 'Unknown campaignId Error';

    /**
     * The constructor method.
     */
    function OA_Dll_CampaignTest()
    {
        $this->UnitTestCase();
        Mock::generatePartial(
            'OA_Dll_Campaign',
            'PartialMockOA_Dll_Campaign_CampaignTest',
            array('checkPermissions')
        );
        Mock::generatePartial(
            'OA_Dll_Advertiser',
            'PartialMockOA_Dll_Advertiser_CampaignTest',
            array('checkPermissions', 'getDefaultAgencyId')
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
        $dllAdvertiserPartialMock = new PartialMockOA_Dll_Advertiser_CampaignTest($this);
        $dllCampaignPartialMock = new PartialMockOA_Dll_Campaign_CampaignTest($this);

        $dllAdvertiserPartialMock->setReturnValue('getDefaultAgencyId', $this->agencyId);
        $dllAdvertiserPartialMock->setReturnValue('checkPermissions', true);
        $dllAdvertiserPartialMock->expectCallCount('checkPermissions', 2);

        $dllCampaignPartialMock->setReturnValue('checkPermissions', true);
        $dllCampaignPartialMock->expectCallCount('checkPermissions', 5);

        $oAdvertiserInfo = new OA_Dll_AdvertiserInfo();
        $oAdvertiserInfo->advertiserName = 'test Advertiser name';
        $oAdvertiserInfo->agencyId       = $this->agencyId;

        $dllAdvertiserPartialMock->modify($oAdvertiserInfo);

        $oCampaignInfo = new OA_Dll_CampaignInfo();

        $oCampaignInfo->advertiserId = $oAdvertiserInfo->advertiserId;

        // Add
        $this->assertTrue($dllCampaignPartialMock->modify($oCampaignInfo),
                          $dllCampaignPartialMock->getLastError());

        // Modify
        $this->assertTrue($dllCampaignPartialMock->modify($oCampaignInfo),
                          $dllCampaignPartialMock->getLastError());

        // Delete
        $this->assertTrue($dllCampaignPartialMock->delete($oCampaignInfo->campaignId),
            $dllCampaignPartialMock->getLastError());

        // Modify not existing id
        $this->assertTrue((!$dllCampaignPartialMock->modify($oCampaignInfo) &&
                          $dllCampaignPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        // Delete not existing id
        $this->assertTrue((!$dllCampaignPartialMock->delete($oCampaignInfo->campaignId) &&
                           $dllCampaignPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        $dllCampaignPartialMock->tally();
    }

    /**
     * A method to test get and getList method.
     */
    function testGetAndGetList()
    {
        $dllAdvertiserPartialMock = new PartialMockOA_Dll_Advertiser_CampaignTest($this);
        $dllCampaignPartialMock = new PartialMockOA_Dll_Campaign_CampaignTest($this);

        $dllAdvertiserPartialMock->setReturnValue('getDefaultAgencyId', $this->agencyId);
        $dllAdvertiserPartialMock->setReturnValue('checkPermissions', true);
        $dllAdvertiserPartialMock->expectCallCount('checkPermissions', 2);

        $dllCampaignPartialMock->setReturnValue('checkPermissions', true);
        $dllCampaignPartialMock->expectCallCount('checkPermissions', 6);

        $oAdvertiserInfo = new OA_Dll_AdvertiserInfo();
        $oAdvertiserInfo->advertiserName = 'test Advertiser name';
        $oAdvertiserInfo->agencyId       = $this->agencyId;

        $dllAdvertiserPartialMock->modify($oAdvertiserInfo);

        $oCampaignInfo1               = new OA_Dll_CampaignInfo();
        $oCampaignInfo1->campaignName = 'test name 1';
        $oCampaignInfo1->impressions  = 10;
        $oCampaignInfo1->clicks       = 2;
        $oCampaignInfo1->priority     = 5;
        $oCampaignInfo1->weight       = 0;
        $oCampaignInfo1->advertiserId = $oAdvertiserInfo->advertiserId;

        $oCampaignInfo2               = new OA_Dll_CampaignInfo();
        $oCampaignInfo2->campaignName = 'test name 2';
        $oCampaignInfo2->startDate    = new Date('2001-01-01 00:00:00');
        $oCampaignInfo2->endDate      = new Date('2021-01-01 23:59:59');
        $oCampaignInfo2->advertiserId = $oAdvertiserInfo->advertiserId;
        // Add
        $this->assertTrue($dllCampaignPartialMock->modify($oCampaignInfo1),
                          $dllCampaignPartialMock->getLastError());

        $this->assertTrue($dllCampaignPartialMock->modify($oCampaignInfo2),
                          $dllCampaignPartialMock->getLastError());

        $oCampaignInfo1Get = null;
        $oCampaignInfo2Get = null;
        // Get
        $this->assertTrue($dllCampaignPartialMock->getCampaign($oCampaignInfo1->campaignId,
                                                                   $oCampaignInfo1Get),
                          $dllCampaignPartialMock->getLastError());
        $this->assertTrue($dllCampaignPartialMock->getCampaign($oCampaignInfo2->campaignId,
                                                                   $oCampaignInfo2Get),
                          $dllCampaignPartialMock->getLastError());

        // Check field value
        $this->assertFieldEqual($oCampaignInfo1, $oCampaignInfo1Get, 'campaignName');
        $this->assertFieldEqual($oCampaignInfo1, $oCampaignInfo1Get, 'startDate');
        $this->assertFieldEqual($oCampaignInfo1, $oCampaignInfo1Get, 'endDate');
        $this->assertFieldEqual($oCampaignInfo1, $oCampaignInfo1Get, 'impressions');
        $this->assertFieldEqual($oCampaignInfo1, $oCampaignInfo1Get, 'clicks');
        $this->assertFieldEqual($oCampaignInfo1, $oCampaignInfo1Get, 'priority');
        $this->assertFieldEqual($oCampaignInfo1, $oCampaignInfo1Get, 'weight');
        $this->assertFieldEqual($oCampaignInfo1, $oCampaignInfo1Get, 'advertiserId');
        $this->assertFieldEqual($oCampaignInfo2, $oCampaignInfo2Get, 'campaignName');
        $this->assertFieldEqual($oCampaignInfo2, $oCampaignInfo2Get, 'startDate');
        $this->assertFieldEqual($oCampaignInfo2, $oCampaignInfo2Get, 'endDate');

        // Get List
        $aCampaignList = array();
        $this->assertTrue($dllCampaignPartialMock->getCampaignListByAdvertiserId($oAdvertiserInfo->advertiserId,
                                                                                 $aCampaignList),
                          $dllCampaignPartialMock->getLastError());
        $this->assertEqual(count($aCampaignList) == 2,
                           '2 records should be returned');
        $oCampaignInfo1Get = $aCampaignList[0];
        $oCampaignInfo2Get = $aCampaignList[1];
        if ($oCampaignInfo1->campaignId == $oCampaignInfo2Get->campaignId) {
            $oCampaignInfo1Get = $aCampaignList[1];
            $oCampaignInfo2Get = $aCampaignList[0];
        }
        // Check field value from list
        $this->assertFieldEqual($oCampaignInfo1, $oCampaignInfo1Get, 'campaignName');
        $this->assertFieldEqual($oCampaignInfo2, $oCampaignInfo2Get, 'campaignName');


        // Delete
        $this->assertTrue($dllCampaignPartialMock->delete($oCampaignInfo1->campaignId),
            $dllCampaignPartialMock->getLastError());

        // Get not existing id
        $this->assertTrue((!$dllCampaignPartialMock->getCampaign($oCampaignInfo1->campaignId,
                                                                     $oCampaignInfo1Get) &&
                          $dllCampaignPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        $dllCampaignPartialMock->tally();
    }

    /**
     * Method to run all tests for campaign statistics
     *
     * @access private
     *
     * @param string $methodName  Method name in Dll
     */
    function _testStatistics($methodName)
    {
        $dllAdvertiserPartialMock = new PartialMockOA_Dll_Advertiser_CampaignTest($this);
        $dllCampaignPartialMock = new PartialMockOA_Dll_Campaign_CampaignTest($this);

        $dllAdvertiserPartialMock->setReturnValue('getDefaultAgencyId', $this->agencyId);
        $dllAdvertiserPartialMock->setReturnValue('checkPermissions', true);
        $dllAdvertiserPartialMock->expectCallCount('checkPermissions', 2);

        $dllCampaignPartialMock->setReturnValue('checkPermissions', true);
        $dllCampaignPartialMock->expectCallCount('checkPermissions', 5);

        $oAdvertiserInfo = new OA_Dll_AdvertiserInfo();
        $oAdvertiserInfo->advertiserName = 'test Advertiser name';
        $oAdvertiserInfo->agencyId       = $this->agencyId;

        $dllAdvertiserPartialMock->modify($oAdvertiserInfo);

        $oCampaignInfo = new OA_Dll_CampaignInfo();

        $oCampaignInfo->advertiserId = $oAdvertiserInfo->advertiserId;

        // Add
        $this->assertTrue($dllCampaignPartialMock->modify($oCampaignInfo),
                          $dllCampaignPartialMock->getLastError());

        // Get no data
        $rsCampaignStatistics = null;
        $this->assertTrue($dllCampaignPartialMock->$methodName(
            $oCampaignInfo->campaignId, new Date('2001-12-01'), new Date('2007-09-19'), false,
            $rsCampaignStatistics), $dllCampaignPartialMock->getLastError());

        $this->assertTrue(isset($rsCampaignStatistics));

        // Handle array result sets
        if (is_array($rsCampaignStatistics)) {
            $this->assertEqual(count($rsCampaignStatistics), 0, 'No records should be returned');

        // Handle MDB2 result sets
        } else if ($rsCampaignStatistics instanceof MDB2_Result_Common) {
            $this->assertEqual($rsCampaignStatistics->numRows(), 0, 'No records should be returned');

        // Handle DBC (deprecated) result sets
        } else {
            $this->assertEqual($rsCampaignStatistics->getRowCount(), 0, 'No records should be returned');
        }

        // Test for wrong date order
        $rsCampaignStatistics = null;
        $this->assertTrue((!$dllCampaignPartialMock->$methodName(
                $oCampaignInfo->campaignId, new Date('2007-09-19'),  new Date('2001-12-01'), false,
                $rsCampaignStatistics) &&
            $dllCampaignPartialMock->getLastError() == $this->wrongDateError),
            $this->_getMethodShouldReturnError($this->wrongDateError));

        // Delete
        $this->assertTrue($dllCampaignPartialMock->delete($oCampaignInfo->campaignId),
            $dllCampaignPartialMock->getLastError());

        // Test statistics for not existing id
        $rsCampaignStatistics = null;
        $this->assertTrue((!$dllCampaignPartialMock->$methodName(
                $oCampaignInfo->campaignId, new Date('2001-12-01'),  new Date('2007-09-19'), false,
                $rsCampaignStatistics) &&
            $dllCampaignPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        $dllCampaignPartialMock->tally();
    }

    /**
     * A method to test getCampaignZoneStatistics.
     */
    function testDailyStatistics()
    {
        $this->_testStatistics('getCampaignDailyStatistics');
    }

    /**
     * A method to test getCampaignZoneStatistics.
     */
    function testBannerStatistics()
    {
        $this->_testStatistics('getCampaignBannerStatistics');
    }

    /**
     * A method to test getCampaignZoneStatistics.
     */
    function testPublisherStatistics()
    {
        $this->_testStatistics('getCampaignPublisherStatistics');
    }

    /**
     * A method to test getCampaignZoneStatistics.
     */
    function testZoneStatistics()
    {
        $this->_testStatistics('getCampaignZoneStatistics');
    }

    function testConversionStatistics()
    {
        $this->_testStatistics('getCampaignConversionStatistics');
    }

}

?>