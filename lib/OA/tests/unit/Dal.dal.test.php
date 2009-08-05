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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the OA_Dal class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to clean up DataGenerator created records at the end of each test.
     */
    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    /**
     * Test that method returns correct object when DataObject exists and false otherwise.
     *
     * @TODO Add PEAR_Error expectations to simpletest in order to catch them
     */
    function testFactoryDO()
    {
        // Test when object exists
        $doBanners = OA_Dal::factoryDO('banners');
        $this->assertIsA($doBanners, 'DataObjects_Banners');

        // Test when object doesn't exist
        PEAR::staticPushErrorHandling(PEAR_ERROR_RETURN);
        $doBanners = OA_Dal::factoryDO('foo'.rand());
        PEAR::staticPopErrorHandling();

        $this->assertFalse($doBanners);
    }

    function testCheckIfDoExists()
    {
        // Test when object exists
        $this->assertTrue(OA_Dal::checkIfDoExists('banners'));

        // Test when object doesn't exist
        $this->assertFalse(OA_Dal::checkIfDoExists('foo_1234'));
    }

    function testStaticGetDO()
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
    function testFactoryDAL()
    {
        // Test when object exists
        $dalBanners = OA_Dal::factoryDAL('banners');
        $this->assertIsA($dalBanners, 'MAX_Dal_Admin_Banners');

        // Test when object doesn't exist
        PEAR::staticPushErrorHandling(PEAR_ERROR_RETURN);
        $dalBanners = OA_Dal::factoryDAL('foo'.rand());
        PEAR::staticPopErrorHandling();

        $this->assertFalse($dalBanners);
    }


    function testIsValidDate()
    {
        $this->assertTrue(OA_Dal::isValidDate('2007-03-01'));
        $this->assertFalse(OA_Dal::isValidDate('0'));
        $this->assertFalse(OA_Dal::isValidDate(null));
    }

    function testBachInsertLoadInfile()
    {
        $this->_testBatchInsert('batchInsert');
    }

    function testBachInsertPlain()
    {
        $this->_testBatchInsert('batchInsertPlain');
    }

    function _testBatchInsert($method)
    {
        $oTable =& OA_DB_Table_Priority::singleton();
        $oTable->createTable('tmp_ad_required_impression');

        $this->assertEqual(array(), $this->_getbatchInsertRecords());
        $aData = array(
            array(
                'ad_id' => '23',
                'required_impressions' => '140',
            ),
            array(
                'ad_id' => '29',
                'required_impressions' => '120',
            )
        );
        $result = OA_Dal::$method('tmp_ad_required_impression', array('ad_id', 'required_impressions'), $aData);
        $this->assertEqual($result, 2);

        $result = $this->_getbatchInsertRecords();
        $this->assertTrue(count($result) == 2);
        $this->assertEqual($result, $aData);

        $oneMoreRow = array (
            array(100,2)
        );
        $result = OA_Dal::$method('tmp_ad_required_impression', array('ad_id', 'required_impressions'), $oneMoreRow);
        $this->assertEqual($result, 1);
        $result = $this->_getbatchInsertRecords();
        $this->assertTrue(count($result) == 3);
        $this->assertEqual($result, array_merge($aData, array (
            array(
                'ad_id' => 100,
                'required_impressions' => 2
            ))));
        TestEnv::dropTempTables();
    }

    function _getbatchInsertRecords()
    {
        $oDbh = OA_DB::singleton();
        $query = "SELECT *
        		FROM ".$oDbh->quoteIdentifier('tmp_ad_required_impression',true)."
        		ORDER BY ad_id ASC";
        return $oDbh->query($query)->fetchAll();
    }

}

?>