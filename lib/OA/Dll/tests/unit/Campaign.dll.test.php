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
require_once MAX_PATH . '/lib/OA/Dll/tests/util/DllUnitTestCase.php';

/**
 * A class for testing DLL Campaign methods
 *
 * @package    OpenadsDll
 * @subpackage TestSuite
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 */


class OA_Dll_CampaignTest extends DllUnitTestCase
{

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

        $dllAdvertiserPartialMock->setReturnValue('checkPermissions', true);
        $dllAdvertiserPartialMock->expectCallCount('checkPermissions', 1);
        
        $dllCampaignPartialMock->setReturnValue('checkPermissions', true);
        $dllCampaignPartialMock->expectCallCount('checkPermissions', 5);

        $oAdvertiserInfo = new OA_Dll_AdvertiserInfo();
        $oAdvertiserInfo->advertiserName = 'test Advertiser name';

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
     * Method to run all tests for campaign statistics
     * 
     * @access private
     *
     * @param string $methodName  Method name in Dll
     */
    function _testStatistics($methodName)
    {
        $dllAdvertiserPartialMock = new PartialMockOA_Dll_Advertiser($this);
        $dllCampaignPartialMock = new PartialMockOA_Dll_Campaign($this);

        $dllAdvertiserPartialMock->setReturnValue('checkPermissions', true);
        $dllAdvertiserPartialMock->expectCallCount('checkPermissions', 1);
        
        $dllCampaignPartialMock->setReturnValue('checkPermissions', true);
        $dllCampaignPartialMock->expectCallCount('checkPermissions', 5);

        $oAdvertiserInfo = new OA_Dll_AdvertiserInfo();
        $oAdvertiserInfo->advertiserName = 'test Advertiser name';

        $dllAdvertiserPartialMock->modify($oAdvertiserInfo);

        $oCampaignInfo = new OA_Dll_CampaignInfo();

        $oCampaignInfo->advertiserId = $oAdvertiserInfo->advertiserId;

        // Add
        $this->assertTrue($dllCampaignPartialMock->modify($oCampaignInfo),
                          $dllCampaignPartialMock->getLastError());

        // Get no data
        $rsCampaignStatistics = null;
        $this->assertTrue($dllCampaignPartialMock->$methodName(
            $oCampaignInfo->advertiserId, new Date('2001-12-01'), new Date('2007-09-19'),
            $rsCampaignStatistics), $dllCampaignPartialMock->getLastError());

        $this->assertTrue(isset($rsCampaignStatistics) &&
            ($rsCampaignStatistics->getRowCount() == 0), 'No records should be returned');

        // Test for wrong date order
        $rsCampaignStatistics = null;
        $this->assertTrue((!$dllCampaignPartialMock->$methodName(
                $oCampaignInfo->advertiserId, new Date('2007-09-19'),  new Date('2001-12-01'),
                $rsCampaignStatistics) &&
            $dllCampaignPartialMock->getLastError() == $this->wrongDateError),
            $this->_getMethodShouldReturnError($this->wrongDateError));

        // Delete
        $this->assertTrue($dllCampaignPartialMock->delete($oCampaignInfo->campaignId),
            $dllCampaignPartialMock->getLastError());

        // Test statistics for not existing id
        $rsCampaignStatistics = null;
        $this->assertTrue((!$dllCampaignPartialMock->$methodName(
                $oCampaignInfo->advertiserId, new Date('2001-12-01'),  new Date('2007-09-19'),
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

}

?>