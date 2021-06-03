<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/OA/Dll/Agency.php';
require_once MAX_PATH . '/lib/OA/Dll/AgencyInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/Advertiser.php';
require_once MAX_PATH . '/lib/OA/Dll/AdvertiserInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/tests/util/DllUnitTestCase.php';

/**
 * A class for testing DLL Advertiser methods
 *
 * @package    OpenXDll
 * @subpackage TestSuite
 */


class OA_Dll_AdvertiserTest extends DllUnitTestCase
{
    /**
     * @var int
     */
    var $agencyId;

    /**
     * Errors
     *
     */
    var $unknownIdError = 'Unknown advertiserId Error';

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
        Mock::generatePartial(
            'OA_Dll_Agency',
            'PartialMockOA_Dll_Agency_AdvertiserTest',
            array('checkPermissions')
        );
        parent::__construct();
        Mock::generatePartial(
            'OA_Dll_Advertiser',
            'PartialMockOA_Dll_Advertiser_AdvertiserTest',
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
        $dllAdvertiserPartialMock = new PartialMockOA_Dll_Advertiser_AdvertiserTest($this);

        $dllAdvertiserPartialMock->setReturnValue('getDefaultAgencyId', $this->agencyId);
        $dllAdvertiserPartialMock->setReturnValue('checkPermissions', true);
        $dllAdvertiserPartialMock->expectCallCount('checkPermissions', 7);


        $oAdvertiserInfo = new OA_DLL_AdvertiserInfo();

        $oAdvertiserInfo->advertiserName = 'test Advertiser';
        $oAdvertiserInfo->agencyId       = $this->agencyId;

        // Add
        $this->assertTrue($dllAdvertiserPartialMock->modify($oAdvertiserInfo),
                          $dllAdvertiserPartialMock->getLastError());

        $this->assertTrue($oAdvertiserInfo->accountId);

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

        $dllAdvertiserPartialMock->tally();
    }


    /**
     * A method to test get and getList method.
     */
    function testGetAndGetList()
    {
        $dllAdvertiserPartialMock = new PartialMockOA_Dll_Advertiser_AdvertiserTest($this);
        $dllAgencyPartialMock     = new PartialMockOA_Dll_Agency_AdvertiserTest($this);

        $dllAgencyPartialMock->setReturnValue('checkPermissions', true);
        $dllAgencyPartialMock->expectCallCount('checkPermissions', 1);

        $dllAdvertiserPartialMock->setReturnValue('checkPermissions', true);
        $dllAdvertiserPartialMock->expectCallCount('checkPermissions', 8);

        $oAgencyInfo             = new OA_Dll_AgencyInfo();
        $oAgencyInfo->agencyName = 'agency name';
        $oAgencyInfo->password   = 'password';
        $this->assertTrue($dllAgencyPartialMock->modify($oAgencyInfo),
                          $dllAgencyPartialMock->getLastError());

        $dllAdvertiserPartialMock->setReturnValue('getDefaultAgencyId', $oAgencyInfo->agencyId);

        $oAdvertiserInfo1                 = new OA_Dll_AdvertiserInfo();
        $oAdvertiserInfo1->agencyId       = $oAgencyInfo->agencyId;
        $oAdvertiserInfo1->advertiserName = 'test name 1';
        $oAdvertiserInfo1->contactName    = 'contact';
        $oAdvertiserInfo1->emailAddress   = 'name@domain.com';

        $oAdvertiserInfo2                 = new OA_Dll_AdvertiserInfo();
        $oAdvertiserInfo2->agencyId       = $oAgencyInfo->agencyId;
        $oAdvertiserInfo2->advertiserName = 'test name 2';
        // Add
        $this->assertTrue($dllAdvertiserPartialMock->modify($oAdvertiserInfo1),
                          $dllAdvertiserPartialMock->getLastError());

        $this->assertTrue($dllAdvertiserPartialMock->modify($oAdvertiserInfo2),
                          $dllAdvertiserPartialMock->getLastError());
        $this->assertTrue($oAdvertiserInfo1->accountId);
        $this->assertTrue($oAdvertiserInfo2->accountId);

        $oAdvertiserInfo1Get = null;
        $oAdvertiserInfo2Get = null;
        // Get
        $this->assertTrue($dllAdvertiserPartialMock->getAdvertiser($oAdvertiserInfo1->advertiserId,
                                                                   $oAdvertiserInfo1Get),
                          $dllAdvertiserPartialMock->getLastError());
        $this->assertTrue($dllAdvertiserPartialMock->getAdvertiser($oAdvertiserInfo2->advertiserId,
                                                                   $oAdvertiserInfo2Get),
                          $dllAdvertiserPartialMock->getLastError());

        // Check field value
        $this->assertFieldEqual($oAdvertiserInfo1, $oAdvertiserInfo1Get, 'advertiserName');
        $this->assertFieldEqual($oAdvertiserInfo1, $oAdvertiserInfo1Get, 'contactName');
        $this->assertFieldEqual($oAdvertiserInfo1, $oAdvertiserInfo1Get, 'emailAddress');
        $this->assertFalse(isset($oAdvertiserInfo1Get->password),
                          'Field \'password\' must be null');
        $this->assertFieldEqual($oAdvertiserInfo2, $oAdvertiserInfo2Get, 'advertiserName');

        // Get List
        $aAdvertiserList = array();
        $this->assertTrue($dllAdvertiserPartialMock->getAdvertiserListByAgencyId($oAgencyInfo->agencyId,
                                                                                 $aAdvertiserList),
                          $dllAdvertiserPartialMock->getLastError());
        $this->assertEqual(count($aAdvertiserList) == 2,
                           '2 records should be returned');
        $oAdvertiserInfo1Get = $aAdvertiserList[0];
        $oAdvertiserInfo2Get = $aAdvertiserList[1];
        if ($oAdvertiserInfo1->advertiserId == $oAdvertiserInfo2Get->advertiserId) {
            $oAdvertiserInfo1Get = $aAdvertiserList[1];
            $oAdvertiserInfo2Get = $aAdvertiserList[0];
        }
        // Check field value from list
        $this->assertFieldEqual($oAdvertiserInfo1, $oAdvertiserInfo1Get, 'advertiserName');
        $this->assertFieldEqual($oAdvertiserInfo2, $oAdvertiserInfo2Get, 'advertiserName');
        $this->assertTrue($oAdvertiserInfo1->accountId);
        $this->assertTrue($oAdvertiserInfo2->accountId);


        // Delete
        $this->assertTrue($dllAdvertiserPartialMock->delete($oAdvertiserInfo1->advertiserId),
            $dllAdvertiserPartialMock->getLastError());

        // Get not existing id
        $this->assertTrue((!$dllAdvertiserPartialMock->getAdvertiser($oAdvertiserInfo1->advertiserId,
                                                                     $oAdvertiserInfo1Get) &&
                          $dllAdvertiserPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        $dllAdvertiserPartialMock->tally();
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
        $dllAdvertiserPartialMock = new PartialMockOA_Dll_Advertiser_AdvertiserTest($this);

        $dllAdvertiserPartialMock->setReturnValue('getDefaultAgencyId', $this->agencyId);
        $dllAdvertiserPartialMock->setReturnValue('checkPermissions', true);
        $dllAdvertiserPartialMock->expectCallCount('checkPermissions', 6);

        $oAdvertiserInfo = new OA_DLL_AdvertiserInfo();

        $oAdvertiserInfo->advertiserName = 'test Advertiser';
        $oAdvertiserInfo->agencyId       = $this->agencyId;

        // Add
        $this->assertTrue($dllAdvertiserPartialMock->modify($oAdvertiserInfo),
                          $dllAdvertiserPartialMock->getLastError());

        // Get no data
        $rsAdvertiserStatistics = null;
        $this->assertTrue($dllAdvertiserPartialMock->$methodName(
            $oAdvertiserInfo->advertiserId, new Date('2001-12-01'), new Date('2007-09-19'), false,
            $rsAdvertiserStatistics), $dllAdvertiserPartialMock->getLastError());

        $this->assertTrue(isset($rsAdvertiserStatistics));
        if (is_array($rsAdvertiserStatistics)) {
            $this->assertEqual(count($rsAdvertiserStatistics), 0, 'No records should be returned');
        } else {
            $this->assertEqual($rsAdvertiserStatistics->getRowCount(), 0, 'No records should be returned');
        }

        // Test for wrong date order
        $rsAdvertiserStatistics = null;
        $this->assertTrue((!$dllAdvertiserPartialMock->$methodName(
                $oAdvertiserInfo->advertiserId, new Date('2007-09-19'),  new Date('2001-12-01'), false,
                $rsAdvertiserStatistics) &&
            $dllAdvertiserPartialMock->getLastError() == $this->wrongDateError),
            $this->_getMethodShouldReturnError($this->wrongDateError));

        // Delete
        $this->assertTrue($dllAdvertiserPartialMock->delete($oAdvertiserInfo->advertiserId),
            $dllAdvertiserPartialMock->getLastError());

        // Test statistics for not existing id
        $rsAdvertiserStatistics = null;
        $this->assertTrue((!$dllAdvertiserPartialMock->$methodName(
                $oAdvertiserInfo->advertiserId, new Date('2001-12-01'),  new Date('2007-09-19'), false,
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
     * A method to test getAdvertiserHourlyStatistics.
     */
    function testHourlyStatistics()
    {
        $this->_testStatistics('getAdvertiserHourlyStatistics');
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
