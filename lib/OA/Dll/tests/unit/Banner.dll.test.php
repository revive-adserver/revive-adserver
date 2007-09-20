<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                           |
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
$Id:$
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
 * @package    OpenadsDll
 * @subpackage TestSuite
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 */


class OA_Dll_BannerTest extends DllUnitTestCase
{

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
            array('checkPermissions')
        );
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
        $dllCampaignPartialMock = new PartialMockOA_Dll_Campaign($this);
        $dllBannerPartialMock = new PartialMockOA_Dll_Banner($this);

        $dllAdvertiserPartialMock->setReturnValue('checkPermissions', true);
        $dllAdvertiserPartialMock->expectCallCount('checkPermissions', 1);
        
        $dllCampaignPartialMock->setReturnValue('checkPermissions', true);
        $dllCampaignPartialMock->expectCallCount('checkPermissions', 1);

        $dllBannerPartialMock->setReturnValue('checkPermissions', true);
        $dllBannerPartialMock->expectCallCount('checkPermissions', 5);

        $oAdvertiserInfo = new OA_Dll_AdvertiserInfo();
        $oAdvertiserInfo->advertiserName = 'test Advertiser name';

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

        $dllAdvertiserPartialMock->setReturnValue('checkPermissions', true);
        $dllAdvertiserPartialMock->expectCallCount('checkPermissions', 1);
        
        $dllCampaignPartialMock->setReturnValue('checkPermissions', true);
        $dllCampaignPartialMock->expectCallCount('checkPermissions', 1);

        $dllBannerPartialMock->setReturnValue('checkPermissions', true);
        $dllBannerPartialMock->expectCallCount('checkPermissions', 5);

        $oAdvertiserInfo = new OA_Dll_AdvertiserInfo();
        $oAdvertiserInfo->advertiserName = 'test Advertiser name';

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