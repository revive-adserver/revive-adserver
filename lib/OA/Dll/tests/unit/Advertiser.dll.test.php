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
require_once MAX_PATH . '/lib/OA/Dll/tests/util/DllUnitTestCase.php';

/**
 * A class for testing DLL Advertiser methods
 *
 * @package    OpenadsDll
 * @subpackage TestSuite
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 */


class OA_Dll_AdvertiserTest extends DllUnitTestCase
{

    /**
     * Errors
     *
     */
    var $unknownIdError = 'Unknown advertiserId Error';

    /**
     * The constructor method.
     */
    function OA_Dll_AdvertiserTest()
    {
        $this->UnitTestCase();
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

        $dllAdvertiserPartialMock->setReturnValue('checkPermissions', true);
        $dllAdvertiserPartialMock->expectCallCount('checkPermissions', 5);

        $oAdvertiserInfo = new OA_DLL_AdvertiserInfo();

        $oAdvertiserInfo->advertiserName = 'test Advertiser';

        // Add
        $this->assertTrue($dllAdvertiserPartialMock->modify($oAdvertiserInfo),
                          $dllAdvertiserPartialMock->getLastError());

        // Modify
        $oAdvertiserInfo->advertiserName = 'modified Advertiser';

        $this->assertTrue($dllAdvertiserPartialMock->modify($oAdvertiserInfo),
                          $dllAdvertiserPartialMock->getLastError());

        // Delete
        $this->assertTrue($dllAdvertiserPartialMock->delete($oAdvertiserInfo->advertiserId),
            $dllAdvertiserPartialMock->getLastError());

        // Modify not existing id
        $this->assertTrue((!$dllAdvertiserPartialMock->modify($oAdvertiserInfo) &&
                          $dllAdvertiserPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        // Delete not existing id
        $this->assertTrue((!$dllAdvertiserPartialMock->delete($oAdvertiserInfo->advertiserId) &&
                           $dllAdvertiserPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        $dllAdvertiserPartialMock   ->tally();
    }
    
    /**
     * Method to run all tests for advertiser statistics
     * 
     * @access private
     *
     * @param string $methodName  Method name in Dll
     */
    function _testStatistics($methodName)
    {
        $dllAdvertiserPartialMock = new PartialMockOA_Dll_Advertiser($this);

        $dllAdvertiserPartialMock->setReturnValue('checkPermissions', true);
        $dllAdvertiserPartialMock->expectCallCount('checkPermissions', 5);

        $oAdvertiserInfo = new OA_DLL_AdvertiserInfo();

        $oAdvertiserInfo->advertiserName = 'test Advertiser';

        // Add
        $this->assertTrue($dllAdvertiserPartialMock->modify($oAdvertiserInfo),
                          $dllAdvertiserPartialMock->getLastError());

        // Get no data
        $rsAdvertiserStatistics = null;
        $this->assertTrue($dllAdvertiserPartialMock->$methodName(
            $oAdvertiserInfo->advertiserId, new Date('2001-12-01'), new Date('2007-09-19'),
            $rsAdvertiserStatistics), $dllAdvertiserPartialMock->getLastError());

        $this->assertTrue(isset($rsAdvertiserStatistics) &&
            ($rsAdvertiserStatistics->getRowCount() == 0), 'No records should be returned');

        // Test for wrong date order
        $rsAdvertiserStatistics = null;
        $this->assertTrue((!$dllAdvertiserPartialMock->$methodName(
                $oAdvertiserInfo->advertiserId, new Date('2007-09-19'),  new Date('2001-12-01'),
                $rsAdvertiserStatistics) &&
            $dllAdvertiserPartialMock->getLastError() == $this->wrongDateError),
            $this->_getMethodShouldReturnError($this->wrongDateError));

        // Delete
        $this->assertTrue($dllAdvertiserPartialMock->delete($oAdvertiserInfo->advertiserId),
            $dllAdvertiserPartialMock->getLastError());

        // Test statistics for not existing id
        $rsAdvertiserStatistics = null;
        $this->assertTrue((!$dllAdvertiserPartialMock->$methodName(
                $oAdvertiserInfo->advertiserId, new Date('2001-12-01'),  new Date('2007-09-19'),
                $rsAdvertiserStatistics) &&
            $dllAdvertiserPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        $dllAdvertiserPartialMock->tally();
    }

    /**
     * A method to test getAdvertiserDailyStatistics.
     */
    function testDailyStatistics()
    {
        $this->_testStatistics('getAdvertiserDailyStatistics');
    }

    /**
     * A method to test getAdvertiserCampaignStatistics.
     */
    function testCampaignStatistics()
    {
        $this->_testStatistics('getAdvertiserCampaignStatistics');
    }

    /**
     * A method to test getAdvertiserBannerStatistics.
     */
    function testBannerStatistics()
    {
        $this->_testStatistics('getAdvertiserBannerStatistics');
    }

    /**
     * A method to test getAdvertiserPublisherStatistics.
     */
    function testPublisherStatistics()
    {
        $this->_testStatistics('getAdvertiserPublisherStatistics');
    }

    /**
     * A method to test getAdvertiserZoneStatistics.
     */
    function testZoneStatistics()
    {
        $this->_testStatistics('getAdvertiserZoneStatistics');
    }


}

?>