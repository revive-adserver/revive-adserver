<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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

require_once MAX_PATH . '/lib/OA/Dll/Agency.php';
require_once MAX_PATH . '/lib/OA/Dll/AgencyInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/tests/util/DllUnitTestCase.php';

/**
 * A class for testing DLL Agency methods
 *
 * @package    OpenXDll
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
    var $duplicateAgencyNameError = 'Agency name must be unique';
    var $invalidLanguageError = 'Invalid language';

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
        $dllAgencyPartialMock->expectCallCount('checkPermissions', 9);

        $oAgencyInfo = new OA_Dll_AgencyInfo();

        $oAgencyInfo->agencyName = 'testAgency';
        $oAgencyInfo->contactName = 'Mike';

        // Add
        $this->assertTrue($dllAgencyPartialMock->modify($oAgencyInfo),
                          $dllAgencyPartialMock->getLastError());

        $this->assertTrue($oAgencyInfo->accountId);
        
        // Try adding a duplicate agency name.
        $oDupeAgencyInfo = new OA_Dll_AgencyInfo();
        $oDupeAgencyInfo->agencyName = $oAgencyInfo->agencyName;
        $oDupeAgencyInfo->contactName = $oAgencyInfo->contactName;
        
        $this->assertTrue((!$dllAgencyPartialMock->modify($oDupeAgencyInfo) && 
            $dllAgencyPartialMock->getLastError() == $this->duplicateAgencyNameError),
            $this->_getMethodShouldReturnError($this->duplicateAgencyNameError));
        

        // Modify
        $oAgencyInfo->agencyName = 'modified Agency';

        $this->assertTrue($dllAgencyPartialMock->modify($oAgencyInfo),
                          $dllAgencyPartialMock->getLastError());
                          
        // Try to modify to a duplicate agency name.
        $this->assertTrue($dllAgencyPartialMock->modify($oDupeAgencyInfo),
                          $dllAgencyPartialMock->getLastError());
        $oDupeAgencyInfo->agencyName = 'modified Agency';
        $this->assertTrue((!$dllAgencyPartialMock->modify($oDupeAgencyInfo) && 
            $dllAgencyPartialMock->getLastError() == $this->duplicateAgencyNameError),
            $this->_getMethodShouldReturnError($this->duplicateAgencyNameError));

        // Delete (both of the agencies)
        $this->assertTrue($dllAgencyPartialMock->delete($oAgencyInfo->agencyId),
            $dllAgencyPartialMock->getLastError());
        $this->assertTrue($dllAgencyPartialMock->delete($oDupeAgencyInfo->agencyId),
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
    
    function testAddAgencyWithUser()
    {
        $dllAgencyPartialMock = new PartialMockOA_Dll_Agency($this);

        $dllAgencyPartialMock->setReturnValue('checkPermissions', true);
        $dllAgencyPartialMock->expectCallCount('checkPermissions', 2);

        $oAgencyInfo = new OA_Dll_AgencyInfo();

        $oAgencyInfo->agencyName = 'testAgency';
        $oAgencyInfo->contactName = 'Bob';
        $oAgencyInfo->username = 'user';
        $oAgencyInfo->userEmail = 'bob@example.com';
        $oAgencyInfo->password = 'pass';
        $oAgencyInfo->language = 'de';

        // Add
        $this->assertTrue($dllAgencyPartialMock->modify($oAgencyInfo),
                          $dllAgencyPartialMock->getLastError());

        $this->assertTrue($oAgencyInfo->accountId);
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->default_account_id = $oAgencyInfo->accountId;
        $doUsers->find(true);
        $this->assertEqual(1, $doUsers->count(), 'Should be one user found.');
        $this->assertEqual($oAgencyInfo->username, $doUsers->username, 'Username does not match.');
        $this->assertEqual($oAgencyInfo->userEmail, $doUsers->email_address, 'User email does not match.');
        // Because the password gets unset.
        $this->assertEqual(md5('pass'), $doUsers->password, 'Password does not match.');
        $this->assertEqual($oAgencyInfo->language, $doUsers->language, 'Language does not match.');
        
        // Test a dodgy language
        $oBadLanguageInfo = clone $oAgencyInfo; 
        
        $oBadLanguageInfo->language = 'BAD_LANGUAGE';
        $this->assertTrue((!$dllAgencyPartialMock->modify($oBadLanguageInfo) && 
            $dllAgencyPartialMock->getLastError() == $this->invalidLanguageError),
            $this->_getMethodShouldReturnError($this->invalidLanguageError));
        
        $dllAgencyPartialMock->tally();
        
        DataGenerator::cleanUp(array('agency', 'users'));
    }
    
    /**
     * A method to test get and getList method.
     */
    function testGetAndGetList()
    {
        $dllAgencyPartialMock = new PartialMockOA_Dll_Agency($this);

        $dllAgencyPartialMock->setReturnValue('checkPermissions', true);
        $dllAgencyPartialMock->expectCallCount('checkPermissions', 6);

        $oAgencyInfo1               = new OA_Dll_AgencyInfo();
        $oAgencyInfo1->agencyName   = 'test name 1';
        $oAgencyInfo1->contactName  = 'contact';
        $oAgencyInfo1->emailAddress = 'name@domain.com';

        $oAgencyInfo2               = new OA_Dll_AgencyInfo();
        $oAgencyInfo2->agencyName   = 'test name 2';
        // Add
        $this->assertTrue($dllAgencyPartialMock->modify($oAgencyInfo1),
                          $dllAgencyPartialMock->getLastError());

        $this->assertTrue($dllAgencyPartialMock->modify($oAgencyInfo2),
                          $dllAgencyPartialMock->getLastError());

        $oAgencyInfo1Get = null;
        $oAgencyInfo2Get = null;
        // Get
        $this->assertTrue($dllAgencyPartialMock->getAgency($oAgencyInfo1->agencyId, $oAgencyInfo1Get),
                          $dllAgencyPartialMock->getLastError());
        $this->assertTrue($dllAgencyPartialMock->getAgency($oAgencyInfo2->agencyId, $oAgencyInfo2Get),
                          $dllAgencyPartialMock->getLastError());

        // Check field value
        $this->assertFieldEqual($oAgencyInfo1, $oAgencyInfo1Get, 'agencyName');
        $this->assertFieldEqual($oAgencyInfo1, $oAgencyInfo1Get, 'contactName');
        $this->assertFieldEqual($oAgencyInfo1, $oAgencyInfo1Get, 'emailAddress');
        $this->assertNull($oAgencyInfo1Get->password,
                          'Field \'password\' must be null');
        $this->assertFieldEqual($oAgencyInfo2, $oAgencyInfo2Get, 'agencyName');
        $this->assertTrue($oAgencyInfo1Get->accountId);
        $this->assertTrue($oAgencyInfo2Get->accountId);

        // Get List
        $aAgencyList = array();
        $this->assertTrue($dllAgencyPartialMock->getAgencyList($aAgencyList),
                          $dllAgencyPartialMock->getLastError());
        $this->assertEqual(count($aAgencyList) == 2,
                           '2 records should be returned');
        $oAgencyInfo1Get = $aAgencyList[0];
        $oAgencyInfo2Get = $aAgencyList[1];
        if ($oAgencyInfo1->agencyId == $oAgencyInfo2Get->agencyId) {
            $oAgencyInfo1Get = $aAgencyList[1];
            $oAgencyInfo2Get = $aAgencyList[0];
        }
        // Check field value from list
        $this->assertFieldEqual($oAgencyInfo1, $oAgencyInfo1Get, 'agencyName');
        $this->assertFieldEqual($oAgencyInfo2, $oAgencyInfo2Get, 'agencyName');
        $this->assertTrue($oAgencyInfo1Get->accountId);
        $this->assertTrue($oAgencyInfo2Get->accountId);


        // Delete
        $this->assertTrue($dllAgencyPartialMock->delete($oAgencyInfo1->agencyId),
            $dllAgencyPartialMock->getLastError());

        // Get not existing id
        $this->assertTrue((!$dllAgencyPartialMock->getAgency($oAgencyInfo1->agencyId, $oAgencyInfo1Get) &&
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