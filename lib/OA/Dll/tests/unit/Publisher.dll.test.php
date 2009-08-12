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

require_once MAX_PATH . '/lib/OA/Dll/Agency.php';
require_once MAX_PATH . '/lib/OA/Dll/AgencyInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/Publisher.php';
require_once MAX_PATH . '/lib/OA/Dll/PublisherInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/tests/util/DllUnitTestCase.php';

/**
 * A class for testing DLL Publisher methods
 *
 * @package    OpenXDll
 * @subpackage TestSuite
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 */
class OA_Dll_PublisherTest extends DllUnitTestCase
{
    /**
     * @var int
     */
    var $agencyId;

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
            'OA_Dll_Agency',
            'PartialMockOA_Dll_Agency_PublisherTest',
            array('checkPermissions')
        );
        $this->UnitTestCase();
        Mock::generatePartial(
            'OA_Dll_Publisher',
            'PartialMockOA_Dll_Publisher_PublisherTest',
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
        $dllPublisherPartialMock = new PartialMockOA_Dll_Publisher_PublisherTest($this);

        $dllPublisherPartialMock->setReturnValue('getDefaultAgencyId', $this->agencyId);
        $dllPublisherPartialMock->setReturnValue('checkPermissions', true);
        $dllPublisherPartialMock->expectCallCount('checkPermissions', 7);

        $oPublisherInfo = new OA_DLL_PublisherInfo();

        $oPublisherInfo->publisherName = 'test Publisher';
        $oPublisherInfo->agencyId      = $this->agencyId;

        // Add
        $this->assertTrue($dllPublisherPartialMock->modify($oPublisherInfo),
            $dllPublisherPartialMock->getLastError());

        $this->assertTrue($oPublisherInfo->accountId);

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
     * A method to test get and getList method.
     */
    function testGetAndGetList()
    {
        $dllPublisherPartialMock = new PartialMockOA_Dll_Publisher_PublisherTest($this);
        $dllAgencyPartialMock    = new PartialMockOA_Dll_Agency_PublisherTest($this);

        $dllPublisherPartialMock->setReturnValue('checkPermissions', true);
        $dllPublisherPartialMock->expectCallCount('checkPermissions', 8);

        $dllAgencyPartialMock->setReturnValue('checkPermissions', true);
        $dllAgencyPartialMock->expectCallCount('checkPermissions', 1);

        $oAgencyInfo             = new OA_Dll_AgencyInfo();
        $oAgencyInfo->agencyName = 'agency name';
        $oAgencyInfo->password   = 'password';
        $this->assertTrue($dllAgencyPartialMock->modify($oAgencyInfo),
                          $dllAgencyPartialMock->getLastError());

        $dllPublisherPartialMock->setReturnValue('getDefaultAgencyId', $oAgencyInfo->agencyId);

        $oPublisherInfo1                 = new OA_Dll_PublisherInfo();
        $oPublisherInfo1->agencyId       = $oAgencyInfo->agencyId;
        $oPublisherInfo1->publisherName  = 'test name 1';
        $oPublisherInfo1->contactName    = 'contact';
        $oPublisherInfo1->emailAddress   = 'name@domain.com';

        $oPublisherInfo2                 = new OA_Dll_PublisherInfo();
        $oPublisherInfo2->agencyId       = $oAgencyInfo->agencyId;
        $oPublisherInfo2->publisherName = 'test name 2';
        // Add
        $this->assertTrue($dllPublisherPartialMock->modify($oPublisherInfo1),
                          $dllPublisherPartialMock->getLastError());

        $this->assertTrue($dllPublisherPartialMock->modify($oPublisherInfo2),
                          $dllPublisherPartialMock->getLastError());
        $this->assertTrue($oPublisherInfo1->accountId);
        $this->assertTrue($oPublisherInfo2->accountId);

        $oPublisherInfo1Get = null;
        $oPublisherInfo2Get = null;
        // Get
        $this->assertTrue($dllPublisherPartialMock->getPublisher($oPublisherInfo1->publisherId,
                                                                   $oPublisherInfo1Get),
                          $dllPublisherPartialMock->getLastError());
        $this->assertTrue($dllPublisherPartialMock->getPublisher($oPublisherInfo2->publisherId,
                                                                   $oPublisherInfo2Get),
                          $dllPublisherPartialMock->getLastError());

        // Check field value
        $this->assertFieldEqual($oPublisherInfo1, $oPublisherInfo1Get, 'publisherName');
        $this->assertFieldEqual($oPublisherInfo1, $oPublisherInfo1Get, 'contactName');
        $this->assertFieldEqual($oPublisherInfo1, $oPublisherInfo1Get, 'emailAddress');
        $this->assertNull($oPublisherInfo1Get->password,
                          'Field \'password\' must be null');
        $this->assertFieldEqual($oPublisherInfo2, $oPublisherInfo2Get, 'publisherName');

        // Get List
        $aPublisherList = array();
        $this->assertTrue($dllPublisherPartialMock->getPublisherListByAgencyId($oAgencyInfo->agencyId,
                                                                     $aPublisherList),
                          $dllPublisherPartialMock->getLastError());
        $this->assertEqual(count($aPublisherList) == 2,
                           '2 records should be returned');
        $oPublisherInfo1Get = $aPublisherList[0];
        $oPublisherInfo2Get = $aPublisherList[1];
        if ($oPublisherInfo1->publisherId == $oPublisherInfo2Get->publisherId) {
            $oPublisherInfo1Get = $aPublisherList[1];
            $oPublisherInfo2Get = $aPublisherList[0];
        }
        // Check field value from list
        $this->assertFieldEqual($oPublisherInfo1, $oPublisherInfo1Get, 'publisherName');
        $this->assertFieldEqual($oPublisherInfo2, $oPublisherInfo2Get, 'publisherName');
        $this->assertTrue($oPublisherInfo1->accountId);
        $this->assertTrue($oPublisherInfo2->accountId);


        // Delete
        $this->assertTrue($dllPublisherPartialMock->delete($oPublisherInfo1->publisherId),
            $dllPublisherPartialMock->getLastError());

        // Get not existing id
        $this->assertTrue((!$dllPublisherPartialMock->getPublisher($oPublisherInfo1->publisherId,
                                                                     $oPublisherInfo1Get) &&
                          $dllPublisherPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        $dllPublisherPartialMock->tally();
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
        $dllPublisherPartialMock = new PartialMockOA_Dll_Publisher_PublisherTest($this);

        $dllPublisherPartialMock->setReturnValue('getDefaultAgencyId', $this->agencyId);
        $dllPublisherPartialMock->setReturnValue('checkPermissions', true);
        $dllPublisherPartialMock->expectCallCount('checkPermissions', 6);

        $oPublisherInfo = new OA_DLL_PublisherInfo();

        $oPublisherInfo->publisherName = 'test Publisher';
        $oPublisherInfo->agencyId      = $this->agencyId;

        // Add
        $this->assertTrue($dllPublisherPartialMock->modify($oPublisherInfo),
            $dllPublisherPartialMock->getLastError());

        // Get no data
        $rsPublisherStatistics = null;
        $this->assertTrue($dllPublisherPartialMock->$methodName(
                $oPublisherInfo->publisherId, new Date('2001-12-01'),
                new Date('2007-09-19'), false, $rsPublisherStatistics),
                $dllPublisherPartialMock->getLastError());

        $this->assertTrue(isset($rsPublisherStatistics));
        if (is_array($rsPublisherStatistics)) {
            $this->assertEqual(count($rsPublisherStatistics), 0, 'No records should be returned');
        } else {
            $this->assertEqual($rsPublisherStatistics->getRowCount(), 0, 'No records should be returned');
        }

        // Test for wrong date order
        $rsPublisherStatistics = null;
        $this->assertTrue((!$dllPublisherPartialMock->$methodName(
                $oPublisherInfo->publisherId, new Date('2007-09-19'),
                new Date('2001-12-01'), false, $rsPublisherStatistics) &&
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
                new Date('2007-09-19'), false, $rsPublisherStatistics) &&
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