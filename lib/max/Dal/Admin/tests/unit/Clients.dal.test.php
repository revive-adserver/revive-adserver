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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/**
 * A class for testing DAL Clients methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 */
class MAX_Dal_Admin_ClientsTest extends DalUnitTestCase
{
    /** @var MAX_Dal_Admin_Clients */
    public $dalClients;

    public function setUp()
    {
        $this->dalClients = OA_Dal::factoryDAL('clients');
    }

    public function tearDown()
    {
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the getClientByKeyword() method.
     *
     * Requirements:
     * Test 1: Test with no advertisers.
     * Test 2: Test with an advertiser that does not match the search string.
     * Test 3: Test with an advertiser that does match the search string.
     * Test 4: Test with multiple advertisers, none match.
     * Test 5: Test with multiple advertisers, one matches.
     * Test 6: Test with multiple advertisers, both match.
     * Test 7: Test with multiple advertisers, both match, but limit owning agency.
     */
    public function testGetClientByKeyword()
    {
        // Restore the test environment - tests rely on the fact that the
        // clients generated will start with client ID 1
        TestEnv::truncateAllTables();

        // Test 1
        $rsClients = $this->dalClients->getClientByKeyword('foo');
        $rsClients->reset();
        $this->assertEqual($rsClients->getRowCount(), 0);

        // Insert a single advertiser
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = 'Advertiser 1';
        $doClients->agencyid = 1;
        $doClients->reportlastdate = '2007-04-03 19:14:59';
        $aClientId = DataGenerator::generateOne($doClients);

        // Test 2
        $rsClients = $this->dalClients->getClientByKeyword('foo');
        $rsClients->reset();
        $this->assertEqual($rsClients->getRowCount(), 0);

        // Test 3
        $rsClients = $this->dalClients->getClientByKeyword('Advertiser');
        $rsClients->reset();
        $this->assertEqual($rsClients->getRowCount(), 1);
        $rsClients->fetch();
        $aRow = $rsClients->toArray();
        $this->assertEqual($aRow['clientid'], 1);
        $this->assertEqual($aRow['clientname'], 'Advertiser 1');

        // Insert a second advertiser
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = 'Advertiser 2';
        $doClients->agencyid = 2;
        $doClients->reportlastdate = '2007-04-03 19:14:59';
        $aClientId = DataGenerator::generateOne($doClients);
        $rsClients->fetch();
        $aRow = $rsClients->toArray();

        // Test 4
        $rsClients = $this->dalClients->getClientByKeyword('foo');
        $rsClients->reset();
        $this->assertEqual($rsClients->getRowCount(), 0);

        // Test 5
        $rsClients = $this->dalClients->getClientByKeyword('2');
        $rsClients->reset();
        $this->assertEqual($rsClients->getRowCount(), 1);
        $rsClients->fetch();
        $aRow = $rsClients->toArray();
        $this->assertEqual($aRow['clientid'], 2);
        $this->assertEqual($aRow['clientname'], 'Advertiser 2');

        // Test 6
        $rsClients = $this->dalClients->getClientByKeyword('Advertiser');
        $rsClients->reset();
        $this->assertEqual($rsClients->getRowCount(), 2);
        $rsClients->fetch();
        $aRow = $rsClients->toArray();
        $this->assertEqual($aRow['clientid'], 1);
        $this->assertEqual($aRow['clientname'], 'Advertiser 1');
        $rsClients->fetch();
        $aRow = $rsClients->toArray();
        $this->assertEqual($aRow['clientid'], 2);
        $this->assertEqual($aRow['clientname'], 'Advertiser 2');

        // Test 7
        $rsClients = $this->dalClients->getClientByKeyword('Advertiser', 1);
        $rsClients->reset();
        $this->assertEqual($rsClients->getRowCount(), 1);
        $rsClients->fetch();
        $aRow = $rsClients->toArray();
        $this->assertEqual($aRow['clientid'], 1);
        $this->assertEqual($aRow['clientname'], 'Advertiser 1');

        // Test 8 - SQL injection on MySQL (CVE-2025-52664)
        $rsClients = $this->dalClients->getClientByKeyword('FUZZ\') AND EXTRACTVALUE(8429,CONCAT(0x5c,0x716a7a6a71,(SELECT (ELT(8429=8429,1))),0x7178787871))-- Nqvq', 1);
        $rsClients->reset();
        $this->assertEqual($rsClients->getRowCount(), 0);

        TestEnv::truncateAllTables();
    }

    /**
     * A method to test the getAdvertiserDetails() method.
     *
     * Requirements:
     * Test 1: Test with no advertisers.
     * Test 2: Test with an advertiser that does not exist.
     * Test 3: Test with an existing advertiser.
     */
    public function testGetAdvertiserDetails()
    {
        // Test 1
        $aClients = $this->dalClients->getAdvertiserDetails(2);
        $this->assertNull($aClients);

        // Insert a single advertiser
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->reportlastdate = '2007-04-03 19:14:59';
        $aClientId = DataGenerator::generateOne($doClients);

        // Test 2
        $aClients = $this->dalClients->getAdvertiserDetails(2);
        $this->assertNull($aClients);

        // Insert a second advertiser
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->reportlastdate = '2007-04-03 19:14:59';
        $aClientId = DataGenerator::generateOne($doClients);

        // Test 3
        $aClients = $this->dalClients->getAdvertiserDetails(2);
        $this->assertTrue(is_array($aClients));
        $this->assertEqual(count($aClients), 14);
        $this->assertEqual($aClients['clientid'], 2);
        $this->assertTrue(array_key_exists('agencyid', $aClients));
        $this->assertTrue(array_key_exists('clientname', $aClients));
        $this->assertTrue(array_key_exists('comments', $aClients));
        $this->assertTrue(array_key_exists('contact', $aClients));
        $this->assertTrue(array_key_exists('email', $aClients));
        $this->assertTrue(array_key_exists('report', $aClients));
        $this->assertTrue(array_key_exists('reportdeactivate', $aClients));
        $this->assertTrue(array_key_exists('reportinterval', $aClients));
        $this->assertTrue(array_key_exists('reportlastdate', $aClients));
        $this->assertTrue(array_key_exists('updated', $aClients));
        $this->assertTrue(array_key_exists('advertiser_limitation', $aClients));
        $this->assertTrue(array_key_exists('type', $aClients));

        TestEnv::truncateAllTables();
    }

    /**
     * A method to test the getAllAdvertisers() method.
     *
     * Requirements:
     * Test 1: Test with no advertisers.
     * Test 2: Test with one advertiser.
     * Test 3: Test with tree advertisers (one market advertiser).
     * Test 4: Test with tree advertisers, reverse sort order.
     * Test 5: Test with tree advertisers, but limit owning agency.
     */
    public function testGetAllAdvertisers()
    {
        // Test 1
        $aClients = $this->dalClients->getAllAdvertisers('name', 'up');
        $this->assertTrue(is_array($aClients));
        $this->assertEqual(count($aClients), 0);

        // Insert a single advertiser
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = 'Advertiser 1';
        $doClients->agencyid = 1;
        $doClients->reportlastdate = '2007-04-03 19:14:59';
        $doClients->type = DataObjects_Clients::ADVERTISER_TYPE_DEFAULT;
        $aClientId = DataGenerator::generateOne($doClients);

        // Test 2
        $aClients = $this->dalClients->getAllAdvertisers('name', 'up');
        $this->assertTrue(is_array($aClients));
        $this->assertEqual(count($aClients), 1);
        $this->assertTrue(is_array($aClients[1]));
        $this->assertEqual(count($aClients[1]), 3);
        $this->assertEqual($aClients[1]['clientname'], 'Advertiser 1');
        $this->assertEqual($aClients[1]['type'], DataObjects_Clients::ADVERTISER_TYPE_DEFAULT);

        // Insert a second advertiser
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = 'Advertiser 2';
        $doClients->agencyid = 2;
        $doClients->reportlastdate = '2007-04-03 19:14:59';
        $doClients->type = DataObjects_Clients::ADVERTISER_TYPE_MARKET;
        $aClientId = DataGenerator::generateOne($doClients);
        // Insert a third advertiser
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = 'Advertiser 3';
        $doClients->agencyid = 2;
        $doClients->reportlastdate = '2007-04-03 19:14:59';
        $doClients->type = DataObjects_Clients::ADVERTISER_TYPE_DEFAULT;
        $aClientId = DataGenerator::generateOne($doClients);

        // Test 3
        $aClients = $this->dalClients->getAllAdvertisers('name', 'up');
        $this->assertTrue(is_array($aClients));
        $this->assertEqual(count($aClients), 2);
        $this->assertEqual(count($aClients[1]), 3);
        $this->assertEqual($aClients[1]['clientname'], 'Advertiser 1');
        $this->assertEqual($aClients[1]['type'], DataObjects_Clients::ADVERTISER_TYPE_DEFAULT);
        $this->assertEqual(count($aClients[3]), 3);
        $this->assertEqual($aClients[3]['clientname'], 'Advertiser 3');
        $this->assertEqual($aClients[3]['type'], DataObjects_Clients::ADVERTISER_TYPE_DEFAULT);
        $aClients = $this->dalClients->getAllAdvertisers(
            'name',
            'up',
            null,
            [DataObjects_Clients::ADVERTISER_TYPE_MARKET],
        );
        $this->assertTrue(is_array($aClients));
        $this->assertEqual(count($aClients), 3);
        $this->assertTrue(is_array($aClients[1]));
        $this->assertEqual(count($aClients[1]), 3);
        $this->assertEqual($aClients[1]['clientname'], 'Advertiser 1');
        $this->assertEqual($aClients[1]['type'], DataObjects_Clients::ADVERTISER_TYPE_DEFAULT);
        $this->assertTrue(is_array($aClients[2]));
        $this->assertEqual(count($aClients[2]), 3);
        $this->assertEqual($aClients[2]['clientname'], 'Advertiser 2');
        $this->assertEqual($aClients[2]['type'], DataObjects_Clients::ADVERTISER_TYPE_MARKET);
        $this->assertEqual(count($aClients[3]), 3);
        $this->assertEqual($aClients[3]['clientname'], 'Advertiser 3');
        $this->assertEqual($aClients[3]['type'], DataObjects_Clients::ADVERTISER_TYPE_DEFAULT);
        // Test ordering in REVERSE of the order, as popping elements off end of array!
        reset($aClients);
        $aValue = array_pop($aClients);
        $this->assertTrue(is_array($aValue));
        $this->assertEqual(count($aValue), 3);
        $this->assertEqual($aValue['clientname'], 'Advertiser 3');
        $aValue = array_pop($aClients);
        $this->assertTrue(is_array($aValue));
        $this->assertEqual(count($aValue), 3);
        $this->assertEqual($aValue['clientname'], 'Advertiser 1');
        $aValue = array_pop($aClients);
        $this->assertTrue(is_array($aValue));
        $this->assertEqual(count($aValue), 3);
        $this->assertEqual($aValue['clientname'], 'Advertiser 2');

        // Test 4
        $aClients = $this->dalClients->getAllAdvertisers('name', 'down');
        $this->assertTrue(is_array($aClients));
        $this->assertEqual(count($aClients), 2);
        $this->assertEqual(count($aClients[1]), 3);
        $this->assertEqual($aClients[1]['clientname'], 'Advertiser 1');
        $this->assertEqual($aClients[1]['type'], DataObjects_Clients::ADVERTISER_TYPE_DEFAULT);
        $this->assertEqual(count($aClients[3]), 3);
        $this->assertEqual($aClients[3]['clientname'], 'Advertiser 3');
        $this->assertEqual($aClients[3]['type'], DataObjects_Clients::ADVERTISER_TYPE_DEFAULT);
        $aClients = $this->dalClients->getAllAdvertisers(
            'name',
            'down',
            null,
            [DataObjects_Clients::ADVERTISER_TYPE_MARKET],
        );
        $this->assertTrue(is_array($aClients));
        $this->assertEqual(count($aClients), 3);
        $this->assertTrue(is_array($aClients[1]));
        $this->assertEqual(count($aClients[1]), 3);
        $this->assertEqual($aClients[1]['clientname'], 'Advertiser 1');
        $this->assertEqual($aClients[1]['type'], DataObjects_Clients::ADVERTISER_TYPE_DEFAULT);
        $this->assertTrue(is_array($aClients[2]));
        $this->assertEqual(count($aClients[2]), 3);
        $this->assertEqual($aClients[2]['clientname'], 'Advertiser 2');
        $this->assertEqual($aClients[2]['type'], DataObjects_Clients::ADVERTISER_TYPE_MARKET);
        $this->assertEqual(count($aClients[3]), 3);
        $this->assertEqual($aClients[3]['clientname'], 'Advertiser 3');
        $this->assertEqual($aClients[3]['type'], DataObjects_Clients::ADVERTISER_TYPE_DEFAULT);
        // Test ordering in REVERSE of the order, as popping elements off end of array!
        reset($aClients);
        $aValue = array_pop($aClients);
        $this->assertTrue(is_array($aValue));
        $this->assertEqual(count($aValue), 3);
        $this->assertEqual($aValue['clientname'], 'Advertiser 1');
        $aValue = array_pop($aClients);
        $this->assertTrue(is_array($aValue));
        $this->assertEqual(count($aValue), 3);
        $this->assertEqual($aValue['clientname'], 'Advertiser 3');
        $aValue = array_pop($aClients);
        $this->assertTrue(is_array($aValue));
        $this->assertEqual(count($aValue), 3);
        $this->assertEqual($aValue['clientname'], 'Advertiser 2');

        // Test 5
        $aClients = $this->dalClients->getAllAdvertisers('name', 'up', 1);
        $this->assertTrue(is_array($aClients));
        $this->assertEqual(count($aClients), 1);
        $this->assertTrue(is_array($aClients[1]));
        $this->assertEqual(count($aClients[1]), 3);
        $this->assertEqual($aClients[1]['clientname'], 'Advertiser 1');
        $this->assertEqual($aClients[1]['type'], DataObjects_Clients::ADVERTISER_TYPE_DEFAULT);

        TestEnv::truncateAllTables();
    }

    /**
     * A method to test the getAllAdvertisersForAgency() method.
     *
     * Requirements:
     * Test 1: Re-perform Test 5 from above.
     */
    public function testGetAllAdvertisersForAgency()
    {
        // Insert a single advertiser
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = 'Advertiser 1';
        $doClients->agencyid = 1;
        $doClients->reportlastdate = '2007-04-03 19:14:59';
        $doClients->type = DataObjects_Clients::ADVERTISER_TYPE_DEFAULT;
        $aClientId = DataGenerator::generateOne($doClients);

        // Test 1
        $aClients = $this->dalClients->getAllAdvertisersForAgency(1, 'name', 'up');
        $this->assertTrue(is_array($aClients));
        $this->assertEqual(count($aClients), 1);
        $this->assertTrue(is_array($aClients[1]));
        $this->assertEqual(count($aClients[1]), 3);
        $this->assertEqual($aClients[1]['clientname'], 'Advertiser 1');
        $this->assertEqual($aClients[1]['type'], DataObjects_Clients::ADVERTISER_TYPE_DEFAULT);

        TestEnv::truncateAllTables();
    }
}
