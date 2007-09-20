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

require_once MAX_PATH . '/lib/OA/Dll/Publisher.php';
require_once MAX_PATH . '/lib/OA/Dll/PublisherInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/Zone.php';
require_once MAX_PATH . '/lib/OA/Dll/ZoneInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/tests/util/DllUnitTestCase.php';

/**
 * A class for testing DLL Zone methods
 *
 * @package    OpenadsDll
 * @subpackage TestSuite
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 */


class OA_Dll_ZoneTest extends DllUnitTestCase
{

    /**
     * Errors
     *
     */
    var $unknownIdError = 'Unknown zoneId Error';

    /**
     * The constructor method.
     */
    function OA_Dll_ZoneTest()
    {
        $this->UnitTestCase();
        Mock::generatePartial(
            'OA_Dll_Publisher',
            'PartialMockOA_Dll_Publisher',
            array('checkPermissions')
        );
        Mock::generatePartial(
            'OA_Dll_Zone',
            'PartialMockOA_Dll_Zone',
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
        $dllPublisherPartialMock = new PartialMockOA_Dll_Publisher($this);
        $dllZonePartialMock      = new PartialMockOA_Dll_Zone($this);

        $dllPublisherPartialMock->setReturnValue('checkPermissions', true);
        $dllPublisherPartialMock->expectCallCount('checkPermissions', 1);

        $dllZonePartialMock->setReturnValue('checkPermissions', true);
        $dllZonePartialMock->expectCallCount('checkPermissions', 5);

        $oZoneInfo      = new OA_DLL_ZoneInfo();
        $oPublisherInfo = new OA_DLL_PublisherInfo();

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
     * Method to run all tests for zone statistics
     *
     * @access private
     *
     * @param string $methodName  Method name in Dll
     */
    function _testStatistics($methodName)
    {
        $dllPublisherPartialMock = new PartialMockOA_Dll_Publisher($this);
        $dllZonePartialMock      = new PartialMockOA_Dll_Zone($this);

        $dllPublisherPartialMock->setReturnValue('checkPermissions', true);
        $dllPublisherPartialMock->expectCallCount('checkPermissions', 1);

        $dllZonePartialMock->setReturnValue('checkPermissions', true);
        $dllZonePartialMock->expectCallCount('checkPermissions', 5);

        $oZoneInfo      = new OA_DLL_ZoneInfo();
        $oPublisherInfo = new OA_DLL_PublisherInfo();

        $dllPublisherPartialMock->modify($oPublisherInfo);
        $oZoneInfo->publisherId = $oPublisherInfo->publisherId;

        // Add
        $this->assertTrue($dllZonePartialMock->modify($oZoneInfo),
            $dllZonePartialMock->getLastError());

        // Get no data
        $rsZoneStatistics = null;
        $this->assertTrue($dllZonePartialMock->$methodName(
                $oZoneInfo->zoneId, new Date('2001-12-01'),
                new Date('2007-09-19'), $rsZoneStatistics),
            $dllZonePartialMock->getLastError());

        $this->assertTrue(isset($rsZoneStatistics) &&
                ($rsZoneStatistics->getRowCount() == 0),
                'No records should be returned');

        // Test for wrong date order
        $rsZoneStatistics = null;
        $this->assertTrue((!$dllZonePartialMock->$methodName(
                    $oZoneInfo->zoneId, new Date('2007-09-19'),
                    new Date('2001-12-01'),
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
                    new Date('2007-09-19'),
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


}

?>