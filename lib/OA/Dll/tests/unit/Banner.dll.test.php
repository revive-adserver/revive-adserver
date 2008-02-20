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

require_once MAX_PATH . '/lib/OA/Dll/Advertiser.php';
require_once MAX_PATH . '/lib/OA/Dll/AdvertiserInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/Campaign.php';
require_once MAX_PATH . '/lib/OA/Dll/CampaignInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/Banner.php';
require_once MAX_PATH . '/lib/OA/Dll/BannerInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/tests/util/DllUnitTestCase.php';

/**
 * A class for testing DLL Banner methods
 *
 * @package    OpenXDll
 * @subpackage TestSuite
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 */


class OA_Dll_BannerTest extends DllUnitTestCase
{
    /**
     * @var int
     */
    var $agencyId;

    /**
     * Errors
     *
     */
    var $unknownIdError = 'Unknown bannerId Error';

    /**
     * The constructor method.
     */
    function OA_Dll_BannerTest()
    {
        $this->UnitTestCase();
        Mock::generatePartial(
            'OA_Dll_Banner',
            'PartialMockOA_Dll_Banner',
            array('checkPermissions')
        );
        Mock::generatePartial(
            'OA_Dll_Campaign',
            'PartialMockOA_Dll_Campaign',
            array('checkPermissions')
        );
        Mock::generatePartial(
            'OA_Dll_Advertiser',
            'PartialMockOA_Dll_Advertiser',
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
        $dllAdvertiserPartialMock = new PartialMockOA_Dll_Advertiser($this);
        $dllCampaignPartialMock   = new PartialMockOA_Dll_Campaign($this);
        $dllBannerPartialMock     = new PartialMockOA_Dll_Banner($this);

        $dllAdvertiserPartialMock->setReturnValue('getDefaultAgencyId', $this->agencyId);
        $dllAdvertiserPartialMock->setReturnValue('checkPermissions', true);
        $dllAdvertiserPartialMock->expectCallCount('checkPermissions', 2);

        $dllCampaignPartialMock->setReturnValue('checkPermissions', true);
        $dllCampaignPartialMock->expectCallCount('checkPermissions', 1);

        $dllBannerPartialMock->setReturnValue('checkPermissions', true);
        $dllBannerPartialMock->expectCallCount('checkPermissions', 5);

        $oAdvertiserInfo = new OA_Dll_AdvertiserInfo();
        $oAdvertiserInfo->advertiserName = 'test Advertiser name';
        $oAdvertiserInfo->agencyId       = $this->agencyId;

        $this->assertTrue($dllAdvertiserPartialMock->modify($oAdvertiserInfo),
                          $dllAdvertiserPartialMock->getLastError());

        $oCampaignInfo = new OA_Dll_CampaignInfo();

        $oCampaignInfo->advertiserId = $oAdvertiserInfo->advertiserId;

        // Add
        $this->assertTrue($dllCampaignPartialMock->modify($oCampaignInfo),
                          $dllCampaignPartialMock->getLastError());

        $oBannerInfo = new OA_Dll_BannerInfo();
        $oBannerInfo->campaignId = $oCampaignInfo->campaignId;

        $this->assertTrue($dllBannerPartialMock->modify($oBannerInfo),
                          $dllBannerPartialMock->getLastError());

        // Modify
        $this->assertTrue($dllBannerPartialMock->modify($oBannerInfo),
                          $dllBannerPartialMock->getLastError());

        // Delete
        $this->assertTrue($dllBannerPartialMock->delete($oBannerInfo->bannerId),
                          $dllBannerPartialMock->getLastError());

        // Modify not existing id
        $this->assertTrue((!$dllBannerPartialMock->modify($oBannerInfo) &&
                          $dllBannerPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        // Delete not existing id
        $this->assertTrue((!$dllBannerPartialMock->delete($oBannerInfo->bannerId) &&
                           $dllBannerPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        $dllBannerPartialMock->tally();
    }

    /**
     * A method to test get and getList method.
     */
    function testGetAndGetList()
    {
        $dllAdvertiserPartialMock = new PartialMockOA_Dll_Advertiser($this);
        $dllCampaignPartialMock   = new PartialMockOA_Dll_Campaign($this);
        $dllBannerPartialMock     = new PartialMockOA_Dll_Banner($this);

        $dllAdvertiserPartialMock->setReturnValue('getDefaultAgencyId', $this->agencyId);
        $dllAdvertiserPartialMock->setReturnValue('checkPermissions', true);
        $dllAdvertiserPartialMock->expectCallCount('checkPermissions', 2);

        $dllCampaignPartialMock->setReturnValue('checkPermissions', true);
        $dllCampaignPartialMock->expectCallCount('checkPermissions', 1);

        $dllBannerPartialMock->setReturnValue('checkPermissions', true);
        $dllBannerPartialMock->expectCallCount('checkPermissions', 6);

        $oAdvertiserInfo = new OA_Dll_AdvertiserInfo();
        $oAdvertiserInfo->advertiserName = 'test Advertiser name';
        $oAdvertiserInfo->agencyId       = $this->agencyId;

        $this->assertTrue($dllAdvertiserPartialMock->modify($oAdvertiserInfo),
                          $dllAdvertiserPartialMock->getLastError());

        $oCampaignInfo = new OA_Dll_CampaignInfo();

        $oCampaignInfo->advertiserId = $oAdvertiserInfo->advertiserId;

        $this->assertTrue($dllCampaignPartialMock->modify($oCampaignInfo),
                          $dllCampaignPartialMock->getLastError());


        // Add
        $oBannerInfo1               = new OA_Dll_BannerInfo();
        $oBannerInfo1->bannerName   = 'test name 1';
        $oBannerInfo1->storageType  = 'url';
        $oBannerInfo1->fileName     = 'file name';
        $oBannerInfo1->imageURL     = 'image url';
        $oBannerInfo1->htmlTemplate = 'html Template';
        $oBannerInfo1->width        = 2;
        $oBannerInfo1->height       = 3;
        $oBannerInfo1->url          = 'url';
        $oBannerInfo1->campaignId   = $oCampaignInfo->campaignId;

        $oBannerInfo2               = new OA_Dll_BannerInfo();
        $oBannerInfo2->bannerName = 'test name 2';
        $oBannerInfo2->campaignId   = $oCampaignInfo->campaignId;
        // Add
        $this->assertTrue($dllBannerPartialMock->modify($oBannerInfo1),
                          $dllBannerPartialMock->getLastError());

        $this->assertTrue($dllBannerPartialMock->modify($oBannerInfo2),
                          $dllBannerPartialMock->getLastError());

        $oBannerInfo1Get = null;
        $oBannerInfo2Get = null;
        // Get
        $this->assertTrue($dllBannerPartialMock->getBanner($oBannerInfo1->bannerId,
                                                                   $oBannerInfo1Get),
                          $dllBannerPartialMock->getLastError());
        $this->assertTrue($dllBannerPartialMock->getBanner($oBannerInfo2->bannerId,
                                                                   $oBannerInfo2Get),
                          $dllBannerPartialMock->getLastError());

        // Check field value
        $this->assertFieldEqual($oBannerInfo1, $oBannerInfo1Get, 'bannerName');
        $this->assertFieldEqual($oBannerInfo1, $oBannerInfo1Get, 'storageType');
        $this->assertFieldEqual($oBannerInfo1, $oBannerInfo1Get, 'fileName');
        $this->assertFieldEqual($oBannerInfo1, $oBannerInfo1Get, 'imageURL');
        $this->assertFieldEqual($oBannerInfo1, $oBannerInfo1Get, 'htmlTemplate');
        $this->assertFieldEqual($oBannerInfo1, $oBannerInfo1Get, 'width');
        $this->assertFieldEqual($oBannerInfo1, $oBannerInfo1Get, 'height');
        $this->assertFieldEqual($oBannerInfo1, $oBannerInfo1Get, 'url');
        $this->assertFieldEqual($oBannerInfo1, $oBannerInfo1Get, 'campaignId');
        $this->assertFieldEqual($oBannerInfo2, $oBannerInfo2Get, 'bannerName');

        // Get List
        $aBannerList = array();
        $this->assertTrue($dllBannerPartialMock->getBannerListByCampaignId($oCampaignInfo->campaignId,
                                                                           $aBannerList),
                          $dllBannerPartialMock->getLastError());
        $this->assertEqual(count($aBannerList) == 2,
                           '2 records should be returned');
        $oBannerInfo1Get = $aBannerList[0];
        $oBannerInfo2Get = $aBannerList[1];
        if ($oBannerInfo1->bannerId == $oBannerInfo2Get->bannerId) {
            $oBannerInfo1Get = $aBannerList[1];
            $oBannerInfo2Get = $aBannerList[0];
        }
        // Check field value from list
        $this->assertFieldEqual($oBannerInfo1, $oBannerInfo1Get, 'bannerName');
        $this->assertFieldEqual($obannerInfo2, $obannerInfo2Get, 'bannerName');


        // Delete
        $this->assertTrue($dllBannerPartialMock->delete($oBannerInfo1->bannerId),
            $dllBannerPartialMock->getLastError());

        // Get not existing id
        $this->assertTrue((!$dllBannerPartialMock->getBanner($oBannerInfo1->bannerId,
                                                                     $oBannerInfo1Get) &&
                          $dllBannerPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        $dllBannerPartialMock->tally();
    }

    /**
     * Method to run all tests for banner statistics
     *
     * @access private
     *
     * @param string $methodName  Method name in Dll
     */
    function _testStatistics($methodName)
    {
        $dllAdvertiserPartialMock = new PartialMockOA_Dll_Advertiser($this);
        $dllCampaignPartialMock = new PartialMockOA_Dll_Campaign($this);
        $dllBannerPartialMock = new PartialMockOA_Dll_Banner($this);

        $dllAdvertiserPartialMock->setReturnValue('getDefaultAgencyId', $this->agencyId);
        $dllAdvertiserPartialMock->setReturnValue('checkPermissions', true);
        $dllAdvertiserPartialMock->expectCallCount('checkPermissions', 2);

        $dllCampaignPartialMock->setReturnValue('checkPermissions', true);
        $dllCampaignPartialMock->expectCallCount('checkPermissions', 1);

        $dllBannerPartialMock->setReturnValue('checkPermissions', true);
        $dllBannerPartialMock->expectCallCount('checkPermissions', 5);

        $oAdvertiserInfo = new OA_Dll_AdvertiserInfo();
        $oAdvertiserInfo->advertiserName = 'test Advertiser name';
        $oAdvertiserInfo->agencyId       = $this->agencyId;

        $this->assertTrue($dllAdvertiserPartialMock->modify($oAdvertiserInfo),
                          $dllAdvertiserPartialMock->getLastError());

        $oCampaignInfo = new OA_Dll_CampaignInfo();

        $oCampaignInfo->advertiserId = $oAdvertiserInfo->advertiserId;

        // Add
        $this->assertTrue($dllCampaignPartialMock->modify($oCampaignInfo),
                          $dllCampaignPartialMock->getLastError());

        $oBannerInfo = new OA_Dll_BannerInfo();
        $oBannerInfo->campaignId = $oCampaignInfo->campaignId;

        $this->assertTrue($dllBannerPartialMock->modify($oBannerInfo),
                          $dllBannerPartialMock->getLastError());

        // Get no data
        $rsBannerStatistics = null;
        $this->assertTrue($dllBannerPartialMock->$methodName(
            $oBannerInfo->bannerId, new Date('2001-12-01'), new Date('2007-09-19'),
            $rsBannerStatistics), $dllBannerPartialMock->getLastError());

        $this->assertTrue(isset($rsBannerStatistics) &&
            ($rsBannerStatistics->getRowCount() == 0), 'No records should be returned');

        // Test for wrong date order
        $rsBannerStatistics = null;
        $this->assertTrue((!$dllBannerPartialMock->$methodName(
                $oBannerInfo->bannerId, new Date('2007-09-19'),  new Date('2001-12-01'),
                $rsBannerStatistics) &&
            $dllBannerPartialMock->getLastError() == $this->wrongDateError),
            $this->_getMethodShouldReturnError($this->wrongDateError));

        // Delete
        $this->assertTrue($dllBannerPartialMock->delete($oBannerInfo->bannerId),
            $dllBannerPartialMock->getLastError());

        // Test statistics for not existing id
        $rsBannerStatistics = null;
        $this->assertTrue((!$dllBannerPartialMock->$methodName(
                $oBannerInfo->bannerId, new Date('2001-12-01'),  new Date('2007-09-19'),
                $rsBannerStatistics) &&
            $dllBannerPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        $dllBannerPartialMock->tally();
    }

    /**
     * A method to test getBannerDailyStatistics.
     */
    function testDailyStatistics()
    {
        $this->_testStatistics('getBannerDailyStatistics');
    }

    /**
     * A method to test getBannerPublisherStatistics.
     */
    function testPublisherStatistics()
    {
        $this->_testStatistics('getBannerPublisherStatistics');
    }

    /**
     * A method to test getBannerZoneStatistics.
     */
    function testZoneStatistics()
    {
        $this->_testStatistics('getBannerZoneStatistics');
    }

}

?>