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

require_once MAX_PATH . '/lib/OA/Dll/Agency.php';
require_once MAX_PATH . '/lib/OA/Dll/AgencyInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/tests/util/DllUnitTestCase.php';

/**
 * A class for testing DLL Agency methods
 *
 * @package    OpenadsDll
 * @subpackage TestSuite
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 */


class OA_Dll_AgencyTest extends DllUnitTestCase
{

    /**
     * Errors
     *
     */
    var $unknownIdError = 'Unknown agencyId Error';

    /**
     * The constructor method.
     */
    function OA_Dll_AgencyTest()
    {
        $this->UnitTestCase();
        Mock::generatePartial(
            'OA_Dll_Agency',
            'PartialMockOA_Dll_Agency',
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
        $dllAgencyPartialMock = new PartialMockOA_Dll_Agency($this);

        $dllAgencyPartialMock->setReturnValue('checkPermissions', true);
        $dllAgencyPartialMock->expectCallCount('checkPermissions', 5);

        $oAgencyInfo = new OA_Dll_AgencyInfo();

        $oAgencyInfo->agencyName = 'testAgency';
        $oAgencyInfo->contactName = 'Mike';

        // Add
        $this->assertTrue($dllAgencyPartialMock->modify($oAgencyInfo),
                          $dllAgencyPartialMock->getLastError());

        // Modify
        $oAgencyInfo->agencyName = 'modified Agency';

        $this->assertTrue($dllAgencyPartialMock->modify($oAgencyInfo),
                          $dllAgencyPartialMock->getLastError());

        // Delete
        $this->assertTrue($dllAgencyPartialMock->delete($oAgencyInfo->agencyId),
            $dllAgencyPartialMock->getLastError());

        // Modify not existing id
        $this->assertTrue((!$dllAgencyPartialMock->modify($oAgencyInfo) &&
                          $dllAgencyPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        // Delete not existing id
        $this->assertTrue((!$dllAgencyPartialMock->delete($oAgencyInfo->agencyId) &&
                           $dllAgencyPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        $dllAgencyPartialMock->tally();
    }
    
    /**
     * Method to run all tests for agency statistics
     * 
     * @access private
     *
     * @param string $methodName  Method name in Dll
     */
    function _testStatistics($methodName)
    {
        $dllAgencyPartialMock = new PartialMockOA_Dll_Agency($this);

        $dllAgencyPartialMock->setReturnValue('checkPermissions', true);
        $dllAgencyPartialMock->expectCallCount('checkPermissions', 5);

        $oAgencyInfo = new OA_Dll_AgencyInfo();

        $oAgencyInfo->agencyName = 'testAgency';

        // Add
        $this->assertTrue($dllAgencyPartialMock->modify($oAgencyInfo),
                          $dllAgencyPartialMock->getLastError());

        // Get no data
        $rsAgencyStatistics = null;
        $this->assertTrue($dllAgencyPartialMock->$methodName(
            $oAgencyInfo->agencyId, new Date('2001-12-01'), new Date('2007-09-19'),
            $rsAgencyStatistics), $dllAgencyPartialMock->getLastError());

        $this->assertTrue(isset($rsAgencyStatistics) &&
            ($rsAgencyStatistics->getRowCount() == 0), 'No records should be returned');

        // Test for wrong date order
        $rsAgencyStatistics = null;
        $this->assertTrue((!$dllAgencyPartialMock->$methodName(
                $oAgencyInfo->agencyId, new Date('2007-09-19'),  new Date('2001-12-01'),
                $rsAgencyStatistics) &&
            $dllAgencyPartialMock->getLastError() == $this->wrongDateError),
            $this->_getMethodShouldReturnError($this->wrongDateError));

        // Delete
        $this->assertTrue($dllAgencyPartialMock->delete($oAgencyInfo->agencyId),
            $dllAgencyPartialMock->getLastError());

        // Test statistics for not existing id
        $rsAgencyStatistics = null;
        $this->assertTrue((!$dllAgencyPartialMock->$methodName(
                $oAgencyInfo->agencyId, new Date('2001-12-01'),  new Date('2007-09-19'),
                $rsAgencyStatistics) &&
            $dllAgencyPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        $dllAgencyPartialMock->tally();
    }

    /**
     * A method to test getAgencyDailyStatistics.
     */
    function testDailyStatistics()
    {
        $this->_testStatistics('getAgencyDailyStatistics');
    }

    /**
     * A method to test getAgencyAdvertiserStatistics.
     */
    function testAdvertiserStatistics()
    {
        $this->_testStatistics('getAgencyAdvertiserStatistics');
    }

    /**
     * A method to test getAgencyCampaignStatistics.
     */
    function testCampaignStatistics()
    {
        $this->_testStatistics('getAgencyCampaignStatistics');
    }

    /**
     * A method to test getAgencyBannerStatistics.
     */
    function testBannerStatistics()
    {
        $this->_testStatistics('getAgencyBannerStatistics');
    }

    /**
     * A method to test getAgencyPublisherStatistics.
     */
    function testPublisherStatistics()
    {
        $this->_testStatistics('getAgencyPublisherStatistics');
    }

    /**
     * A method to test getAgencyZoneStatistics.
     */
    function testZoneStatistics()
    {
        $this->_testStatistics('getAgencyZoneStatistics');
    }


}

?>