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
require_once MAX_PATH . '/lib/OA/Dll/tests/util/DllUnitTestCase.php';

/**
 * A class for testing DLL Publisher methods
 *
 * @package    OpenadsDll
 * @subpackage TestSuite
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 */


class OA_Dll_PublisherTest extends DllUnitTestCase
{

    /**
     * Errors
     *
     */
    var $unknownIdError = 'Unknown publisherId Error';

    /**
     * The constructor method.
     */
    function OA_Dll_PublisherTest()
    {
        $this->UnitTestCase();
        Mock::generatePartial(
            'OA_Dll_Publisher',
            'PartialMockOA_Dll_Publisher',
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

        $dllPublisherPartialMock->setReturnValue('checkPermissions', true);
        $dllPublisherPartialMock->expectCallCount('checkPermissions', 5);

        $oPublisherInfo = new OA_DLL_PublisherInfo();

        $oPublisherInfo->publisherName = 'test Publisher';

        // Add
        $this->assertTrue($dllPublisherPartialMock->modify($oPublisherInfo),
            $dllPublisherPartialMock->getLastError());

        // Modify
        $oPublisherInfo->publisherName = 'modified Publisher';

        $this->assertTrue($dllPublisherPartialMock->modify($oPublisherInfo),
            $dllPublisherPartialMock->getLastError());

        // Delete
        $this->assertTrue(
            $dllPublisherPartialMock->delete($oPublisherInfo->publisherId),
            $dllPublisherPartialMock->getLastError());

        // Modify not existing id
        $this->assertTrue((!$dllPublisherPartialMock->modify($oPublisherInfo) &&
                          $dllPublisherPartialMock->getLastError() ==
                            $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        // Delete not existing id
        $this->assertTrue(
            (!$dllPublisherPartialMock->delete($oPublisherInfo->publisherId) &&
             $dllPublisherPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        $dllPublisherPartialMock   ->tally();
    }

    /**
     * Method to run all tests for publisher statistics
     *
     * @access private
     *
     * @param string $methodName  Method name in Dll
     */
    function _testStatistics($methodName)
    {
        $dllPublisherPartialMock = new PartialMockOA_Dll_Publisher($this);

        $dllPublisherPartialMock->setReturnValue('checkPermissions', true);
        $dllPublisherPartialMock->expectCallCount('checkPermissions', 5);

        $oPublisherInfo = new OA_DLL_PublisherInfo();

        $oPublisherInfo->publisherName = 'test Publisher';

        // Add
        $this->assertTrue($dllPublisherPartialMock->modify($oPublisherInfo),
            $dllPublisherPartialMock->getLastError());

        // Get no data
        $rsPublisherStatistics = null;
        $this->assertTrue($dllPublisherPartialMock->$methodName(
                $oPublisherInfo->publisherId, new Date('2001-12-01'),
                new Date('2007-09-19'), $rsPublisherStatistics),
                $dllPublisherPartialMock->getLastError());

        $this->assertTrue(isset($rsPublisherStatistics) &&
            ($rsPublisherStatistics->getRowCount() == 0),
             'No records should be returned');

        // Test for wrong date order
        $rsPublisherStatistics = null;
        $this->assertTrue((!$dllPublisherPartialMock->$methodName(
                $oPublisherInfo->publisherId, new Date('2007-09-19'),
                new Date('2001-12-01'), $rsPublisherStatistics) &&
            $dllPublisherPartialMock->getLastError() == $this->wrongDateError),
            $this->_getMethodShouldReturnError($this->wrongDateError));

        // Delete
        $this->assertTrue(
            $dllPublisherPartialMock->delete($oPublisherInfo->publisherId),
            $dllPublisherPartialMock->getLastError());

        // Test statistics for not existing id
        $rsPublisherStatistics = null;
        $this->assertTrue((!$dllPublisherPartialMock->$methodName(
                $oPublisherInfo->publisherId, new Date('2001-12-01'),
                new Date('2007-09-19'), $rsPublisherStatistics) &&
            $dllPublisherPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        $dllPublisherPartialMock->tally();
    }

    /**
     * A method to test getPublisherDailyStatistics.
     */
    function testDailyStatistics()
    {
        $this->_testStatistics('getPublisherDailyStatistics');
    }

    /**
     * A method to test getPublisherZoneStatistics.
     */
    function testZoneStatistics()
    {
        $this->_testStatistics('getPublisherZoneStatistics');
    }

    /**
     * A method to test getPublisherAdvertiserStatistics.
     */
    function testAdvertiserStatistics()
    {
        $this->_testStatistics('getPublisherAdvertiserStatistics');
    }

    /**
     * A method to test getPublisherCampaignStatistics.
     */
    function testCampaignStatistics()
    {
        $this->_testStatistics('getPublisherCampaignStatistics');
    }

    /**
     * A method to test getPublisherBannerStatistics.
     */
    function testBannerStatistics()
    {
        $this->_testStatistics('getPublisherBannerStatistics');
    }


}

?>