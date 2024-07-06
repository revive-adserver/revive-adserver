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
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the OA_Dal class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 */
class Test_OA_Dal extends UnitTestCase
{
    /**
     * A method to clean up DataGenerator created records at the end of each test.
     */
    public function tearDown()
    {
        DataGenerator::cleanUp();
    }

    /**
     * Test that method returns correct object when DataObject exists and false otherwise.
     *
     * @TODO Add PEAR_Error expectations to simpletest in order to catch them
     */
    public function testFactoryDO()
    {
        // Test when object exists
        $doBanners = OA_Dal::factoryDO('banners');
        $this->assertIsA($doBanners, 'DataObjects_Banners');

        // Test when object doesn't exist
        PEAR::staticPushErrorHandling(PEAR_ERROR_RETURN);
        $doBanners = OA_Dal::factoryDO('foo' . rand());
        PEAR::staticPopErrorHandling();

        $this->assertFalse($doBanners);
    }

    public function testCheckIfDoExists()
    {
        // Test when object exists
        $this->assertTrue(OA_Dal::checkIfDoExists('banners'));

        // Test when object doesn't exist
        $this->assertFalse(OA_Dal::checkIfDoExists('foo_1234'));
    }

    public function testStaticGetDO()
    {
        // create test record
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->acls_updated = '2007-04-03 20:41:33';
        $bannerId = DataGenerator::generateOne($doBanners);

        // Test that we retreived that record from database
        $doBanners = OA_Dal::staticGetDO('banners', $bannerId);
        $this->assertIsA($doBanners, 'DataObjects_Banners');
        $this->assertEqual($doBanners->bannerid, $bannerId);

        // Test that false is returned if record doesn't exist
        $doBanners = OA_Dal::staticGetDO('banners', $id = 123);
        $this->assertFalse($doBanners);
    }

    /**
     * Test that method returns correct object when DataObject exists and false otherwise.
     *
     * @TODO Add PEAR_Error expectations to simpletest in order to catch them
     */
    public function testFactoryDAL()
    {
        // Test when object exists
        $dalBanners = OA_Dal::factoryDAL('banners');
        $this->assertIsA($dalBanners, 'MAX_Dal_Admin_Banners');

        // Test when object doesn't exist
        PEAR::staticPushErrorHandling(PEAR_ERROR_RETURN);
        $dalBanners = OA_Dal::factoryDAL('foo' . rand());
        PEAR::staticPopErrorHandling();

        $this->assertFalse($dalBanners);
    }


    public function testIsValidDate()
    {
        $this->assertTrue(OA_Dal::isValidDate('2007-03-01'));
        $this->assertFalse(OA_Dal::isValidDate('0'));
        $this->assertFalse(OA_Dal::isValidDate(null));
    }

    public function testBachInsertLoadInfile()
    {
        $this->_testBatchInsert('batchInsert');
    }

    public function testBachInsertPlain()
    {
        $this->_testBatchInsert('batchInsertPlain');
    }

    public function _testBatchInsert($method)
    {
        $oTable = &OA_DB_Table_Priority::singleton();
        $oTable->createTable('tmp_ad_required_impression');

        $this->assertEqual([], $this->_getbatchInsertRecords());
        $aData = [
            [
                'ad_id' => '23',
                'required_impressions' => '140',
            ],
            [
                'ad_id' => '29',
                'required_impressions' => '120',
            ],
        ];
        $result = OA_Dal::$method('tmp_ad_required_impression', ['ad_id', 'required_impressions'], $aData);
        $this->assertEqual($result, 2);

        $result = $this->_getbatchInsertRecords();
        $this->assertTrue(count($result) == 2);
        $this->assertEqual($result, $aData);

        $oneMoreRow = [
            [100, 2],
        ];
        $result = OA_Dal::$method('tmp_ad_required_impression', ['ad_id', 'required_impressions'], $oneMoreRow);
        $this->assertEqual($result, 1);
        $result = $this->_getbatchInsertRecords();
        $this->assertTrue(count($result) == 3);
        $this->assertEqual($result, array_merge($aData, [
            [
                'ad_id' => 100,
                'required_impressions' => 2,
            ]]));
        TestEnv::dropTempTables();
    }

    public function _getbatchInsertRecords()
    {
        $oDbh = OA_DB::singleton();
        $query = "SELECT *
        		FROM " . $oDbh->quoteIdentifier('tmp_ad_required_impression', true) . "
        		ORDER BY ad_id ASC";
        return $oDbh->query($query)->fetchAll();
    }
}
