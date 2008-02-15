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

require_once MAX_PATH . '/lib/OA/Dll/Publisher.php';
require_once MAX_PATH . '/lib/OA/Dll/PublisherInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/Zone.php';
require_once MAX_PATH . '/lib/OA/Dll/ZoneInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/tests/util/DllUnitTestCase.php';

/**
 * A class for testing DLL Zone methods
 *
 * @package    OpenXDll
 * @subpackage TestSuite
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
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

    /**
     * The constructor method.
     */
    function OA_Dll_ZoneTest()
    {
        $this->UnitTestCase();
        Mock::generatePartial(
            'OA_Dll_Publisher',
            'PartialMockOA_Dll_Publisher',
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
        $dllPublisherPartialMock = new PartialMockOA_Dll_Publisher($this);
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
     * A method to test get and getList method.
     */
    function testGetAndGetList()
    {
        $dllPublisherPartialMock = new PartialMockOA_Dll_Publisher($this);
        $dllZonePartialMock      = new PartialMockOA_Dll_Zone($this);

        $dllPublisherPartialMock->setReturnValue('getDefaultAgencyId', $this->agencyId);
        $dllPublisherPartialMock->setReturnValue('checkPermissions', true);
        $dllPublisherPartialMock->expectCallCount('checkPermissions', 2);

        $dllZonePartialMock->setReturnValue('checkPermissions', true);
        $dllZonePartialMock->expectCallCount('checkPermissions', 6);

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
        // Add
        $this->assertTrue($dllZonePartialMock->modify($oZoneInfo1),
                          $dllZonePartialMock->getLastError());

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
        $dllPublisherPartialMock = new PartialMockOA_Dll_Publisher($this);
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