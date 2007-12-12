<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.5                                                              |
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
require_once MAX_PATH . '/lib/OA/Dll/Publisher.php';
require_once MAX_PATH . '/lib/OA/Dll/PublisherInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/tests/util/DllUnitTestCase.php';
require_once MAX_PATH . '/lib/OA/Upgrade/GaclPermissions.php';
require_once MAX_PATH . '/lib/gacl/tests/unit/acl.mol.test.php';

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
            'OA_Dll_Agency',
            'PartialMockOA_Dll_Agency',
            array('checkPermissions')
        );
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
     * A method to test get and getList method.
     */
    function testGetAndGetList()
    {
        $aclSetup = new acl_setup($options = array());
        $aclSetup->cleanUp();
        OA_GaclPermissions::insert();
        
        $dllPublisherPartialMock = new PartialMockOA_Dll_Publisher($this);
        $dllAgencyPartialMock    = new PartialMockOA_Dll_Agency($this);

        $dllPublisherPartialMock->setReturnValue('checkPermissions', true);
        $dllPublisherPartialMock->expectCallCount('checkPermissions', 6);

        $dllAgencyPartialMock->setReturnValue('checkPermissions', true);
        $dllAgencyPartialMock->expectCallCount('checkPermissions', 1);

        $oAgencyInfo             = new OA_Dll_AgencyInfo();
        $oAgencyInfo->agencyName = 'agency name';
        $this->assertTrue($dllAgencyPartialMock->modify($oAgencyInfo),
                          $dllAgencyPartialMock->getLastError());

        $oPublisherInfo1                 = new OA_Dll_PublisherInfo();
        $oPublisherInfo1->agencyId     = $oAgencyInfo->agencyId;
        $oPublisherInfo1->publisherName  = 'test name 1';
        $oPublisherInfo1->contactName    = 'contact';
        $oPublisherInfo1->emailAddress   = 'name@domain.com';
        $oPublisherInfo1->username       = 'publisher   user'.rand(1, 20);
        $oPublisherInfo1->password       = 'password';

        $oPublisherInfo2                 = new OA_Dll_PublisherInfo();
        $oPublisherInfo2->agencyId       = $oAgencyInfo->agencyId;
        $oPublisherInfo2->publisherName = 'test name 2';
        // Add
        $this->assertTrue($dllPublisherPartialMock->modify($oPublisherInfo1),
                          $dllPublisherPartialMock->getLastError());

        $this->assertTrue($dllPublisherPartialMock->modify($oPublisherInfo2),
                          $dllPublisherPartialMock->getLastError());

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