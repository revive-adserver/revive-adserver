<?php
/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/**
 * A class for testing DB_DataObjectsCommon
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 * @TODO No tests written yet...
 */
class DB_DataObjectCommonTest extends DalUnitTestCase
{
    /**
     * The constructor method.
     */
    function DB_DataObjectCommonTest()
    {
        $this->UnitTestCase();
    }
    
    function setUpFixture()
    {
        //TestEnv::restoreEnv();
    }
    
    function tearDown()
    {
        // assuming that all test data was created by DataGenerator
        // If it is necessary to recreate entire database we still could do it on the end
        // of each test by calling TestEnv::restoreEnv();
        DataGenerator::cleanUp(array('banners'));
    }
    
    function testFactoryDAL()
    {
        $doClients = MAX_DB::factoryDO('clients');
        $dalClients = $doClients->factoryDAL();
        $this->assertIsA($dalClients, 'MAX_Dal_Common');
    }
    
    function testGetAll()
    {
        // test it returns empty array when no data
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $aCheck = $doCampaigns->getAll();
        $this->assertEqual($aCheck, array());
        
        // Insert campaigns with default data
        // and few additional required for testing filters
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $doCampaigns->campaignname = $campaignName = 'test name';
        $aCampaignId = DataGenerator::generate($doCampaigns, 2, $generateParents = true);
        $clientId = DataGenerator::getReferenceId('clients');
        
        $aCampaignId2 = DataGenerator::generate('campaigns', 2, $generateParents = true);
        $clientId2 = DataGenerator::getReferenceId('clients');
        
        // test getting all records
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $aCheck = $doCampaigns->getAll();
        $this->assertEqual(count($aCheck), 4);
        
        $doCampaignsFilter = MAX_DB::factoryDO('campaigns');
        $doCampaignsFilter->clientid = $clientId;
        
        // test filtering and test that rows are not indexed by primary key
        $doCampaigns = clone($doCampaignsFilter);
        $aCheck = $doCampaigns->getAll();
        $this->assertEqual(count($aCheck), count($aCampaignId));
        $this->assertEqual(array_keys($aCheck), array(0, 1));
        
        // test indexing with primary keys
        $doCampaigns = clone($doCampaignsFilter);
        $aCheck = $doCampaigns->getAll(array(), $indexWithPrimaryKey = true);
        $this->assertEqual($aCampaignId, array_keys($aCheck));
        foreach ($aCheck as $check) {
            $this->assertEqual($check['campaignname'], $campaignName);
        }
        
        // test flattening if only one field
        $doCampaigns = clone($doCampaignsFilter);
        $aCheck = $doCampaigns->getAll(array('campaignname'), $indexWithPrimaryKey = false, $flatten = true);
        foreach ($aCheck as $check) {
            $this->assertEqual($check, $campaignName);
        }
        // test that we don't have to use array if only one field is set
        $doCampaigns = clone($doCampaignsFilter);
        $aCheck2 = $doCampaigns->getAll('campaignname', $indexWithPrimaryKey = false, $flatten = true);
        $this->assertEqual($aCheck, $aCheck2);
        
        // test we could index by any field - not only by primary key
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $aCheck = $doCampaigns->getAll('campaignname', $indexBy = 'clientid', $flatten = true);
        $this->assertEqual(count($aCheck), 2);
        $this->assertEqual(array_keys($aCheck), array($clientId, $clientId2));
    }
    
    function testBelongToUser()
    {
        //TestEnv::restoreEnv();
        // Test that user belong to itself
        $agencyid = DataGenerator::generateOne('agency');
        $doAgency = MAX_DB::staticGetDO('agency', $agencyid);
        $this->assertTrue($doAgency->belongToUser('agency', $agencyid));
        $this->assertFalse($doAgency->belongToUser('agency', 222));
        
        // Create necessary test data
        $doClients = MAX_DB::factoryDO('clients');
        $doClients->agencyid = $agencyid;
        $clientId = DataGenerator::generateOne($doClients);
        
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $doCampaigns->clientid = $clientId;
        $campaignId = DataGenerator::generateOne($doCampaigns);
        
        $doBanners = MAX_DB::factoryDO('banners');
        $doBanners->campaignid = $campaignId;
        $bannerId = DataGenerator::generateOne($doBanners);
        
        // Test dependency on one level
        $doClients = MAX_DB::staticGetDO('clients', $clientId);
        $this->assertTrue($doClients->belongToUser('agency', $agencyid));
        $this->assertFalse($doClients->belongToUser('agency', 222));
        
        // Test dependency on two and more levels
        $doCampaigns = MAX_DB::staticGetDO('campaigns', $campaignId);
        $this->assertTrue($doCampaigns->belongToUser('agency', $agencyid));
        $this->assertFalse($doCampaigns->belongToUser('agency', 222));
        
        $doBanners = MAX_DB::staticGetDO('banners', $bannerId);
        $this->assertTrue($doBanners->belongToUser('agency', $agencyid));
        $this->assertFalse($doBanners->belongToUser('agency', 222));    
        
        // Test that belongToUser() will find and fetch data by itself
        $doBanners = MAX_DB::factoryDO('banners');
        $doBanners->bannerid = $bannerId;
        $this->assertTrue($doBanners->belongToUser('agency', $agencyid));
        $this->assertFalse($doBanners->belongToUser('agency', 222));    
    }
    
    function testAddReferenceFilter()
    {
        // Create test data
        $agencyId1 = DataGenerator::generateOne('agency');
        $agencyId2 = DataGenerator::generateOne('agency');
        
        $doClients = MAX_DB::factoryDO('clients');
        $doClients->agencyid = $agencyId1;
        $clientId1 = DataGenerator::generateOne($doClients);
        
        $doClients = MAX_DB::factoryDO('clients');
        $doClients->agencyid = $agencyId2;
        $clientId2 = DataGenerator::generateOne($doClients);
        
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $doCampaigns->clientid = $clientId1;
        $campaignId = DataGenerator::generate($doCampaigns, 2);
        
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $doCampaigns->clientid = $clientId2;
        $campaignId = DataGenerator::generate($doCampaigns, 3);
        
        // Test all
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $this->assertEqual($doCampaigns->find(), 5);
        
        // Test filter by $agencyId1
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $doCampaigns->addReferenceFilter('agency', $agencyId1);
        $this->assertEqual($doCampaigns->find(), 2);
        
        // Test filter by agency and client (should be the same as agency alone)
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $doCampaigns->addReferenceFilter('agency', $agencyId1);
        $doCampaigns->addReferenceFilter('clients', $clientId1);
        $this->assertEqual($doCampaigns->find(), 2);
        
        // Test by clientId2
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $doCampaigns->addReferenceFilter('clients', $clientId2);
        $this->assertEqual($doCampaigns->find(), 3);
        
        // Test that filtering by agencyId1 and clientId2 should give 0
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $doCampaigns->addReferenceFilter('agency', $agencyId1);
        $doCampaigns->addReferenceFilter('clients', $clientId2);
        $this->assertEqual($doCampaigns->find(), 0);
    }
    
    function testAddListOrderBy()
    {
        // very quick test
        $data = array(
            'name' => array('name 1', 'name 2')
        );
        $dg = new DataGenerator();
        $dg->setData('agency', $data);
        $dg->generate('agency', 2);
        
        // Test that its found data and sorted in ASCendently
        $doAgency = MAX_DB::factoryDO('agency');
        $doAgency->addListOrderBy('name', 'down');
        $aAgency = $doAgency->getAll('name');
        rsort($data['name']);
        $this->assertEqual($aAgency, $data['name']);
        
        // Test that its found data and sorted in DESCendently
        $doAgency = MAX_DB::factoryDO('agency');
        $doAgency->addListOrderBy('name', 'up');
        $aAgency = $doAgency->getAll('name');
        sort($data['name']);
        $this->assertEqual($aAgency, $data['name']);
    }
    
    function testGetTableWithoutPrefix()
    {
        $table = 'agency';
        $doAgency = MAX_DB::factoryDO($table);
        $this->assertEqual($doAgency->getTableWithoutPrefix(), $table);
        
        $prefix = 'abc';
        $doAgency->_prefix = $prefix;
        $doAgency->__table = $prefix.$table;
        $this->assertEqual($doAgency->getTableWithoutPrefix(), $table);
    }
    
    function testGetUniqueValuesFromColumn()
    {
        $data = array(
            'name' => array(1, 1, 2, 2, 3) // 3 unique
        );
        $dg = new DataGenerator();
        $dg->setData('agency', $data);
        $dg->generate('agency', 5);
        
        // Test that it takes 3 unique variables
        $doAgency = MAX_DB::factoryDO('agency');
        $aUnique = $doAgency->getUniqueValuesFromColumn('name');
        $this->assertEqual($aUnique, array(1,2,3));
        
        $doAgency = MAX_DB::factoryDO('agency');
        $aUnique = $doAgency->getUniqueValuesFromColumn('name', $exceptValue = 2);
        $this->assertEqual(array_values($aUnique), array(1,3));
    }
    
    function testGetUniqueNameForDuplication()
    {
        $doAgency = MAX_DB::factoryDO('agency');
        $doAgency->name = $name = 'test name';
        $agencyId = DataGenerator::generateOne($doAgency);
        
        // Test first duplication
        $doAgency = MAX_DB::staticGetDO('agency', $agencyId);
        $uniqueName = $doAgency->getUniqueNameForDuplication('name');
        $this->assertEqual($uniqueName, $name.' (2)');
        
        // Add that unique name to database
        $doAgency = MAX_DB::factoryDO('agency');
        $doAgency->name = $uniqueName;
        DataGenerator::generateOne($doAgency);
        
        // Test second duplication
        $doAgency = MAX_DB::staticGetDO('agency', $agencyId);
        $uniqueName = $doAgency->getUniqueNameForDuplication('name');
        $this->assertEqual($uniqueName, $name.' (3)');
    }
    
    function testDeleteById()
    {
        // Create few records
        $aAgencyId = DataGenerator::generate('agency', 3);
        $agencyId = array_pop($aAgencyId);
        
        // Delete one
        $doAgency = MAX_DB::factoryDO('agency');
        $ret = $doAgency->deleteById($agencyId);
        $this->assertEqual($ret, 1); // one deleted
        
        // Test its deleted
        $doAgency = MAX_DB::factoryDO('agency');
        $aTestAgencyId = $doAgency->getAll('agencyid');
        $this->assertEqual(array_values($aTestAgencyId), array_values($aAgencyId));
        
        // Try to delete non-existing one
        $doAgency = MAX_DB::factoryDO('agency');
        $ret = $doAgency->deleteById(null);
        $this->assertEqual($ret, 0);
    }
    
    /**
     * Test delete() and deleteOnCascade()
     *
     */
    function testDelete()
    {
        // Create few records
        $aAgencyId = DataGenerator::generate('agency', 3);
        $agencyId = array_pop($aAgencyId);
        
        $aClientId1 = DataGenerator::generate('clients', 2);
        $doClients = MAX_DB::factoryDO('clients');
        $doClients->agencyid = $agencyId;
        $aClientId2 = DataGenerator::generate($doClients, 2);
        
        $doAgency = MAX_DB::staticGetDO('agency', $agencyId);
        // Test that onDeleteCascade is set
        $this->assertTrue($doAgency->onDeleteCascade);
        // Delete one agency
        $doAgency->delete();
        // Test that agency was deleted
        $doAgency = MAX_DB::factoryDO('agency');
        $aAgencyIdTest = $doAgency->getAll('agencyid');
        $this->assertEqual(array_values($aAgencyId), $aAgencyIdTest);
        // Test that associated clients were deleted as well
        $doClients = MAX_DB::factoryDO('clients');
        $aClientId1Test = $doClients->getAll('clientid');
        $this->assertEqual($aClientId1, $aClientId1Test); // only two should left
    }
    
    function testUpdate()
    {
        $bannerId1 = DataGenerator::generateOne('banners');
        $doBanners1 = MAX_DB::staticGetDO('banners', $bannerId1);
        
        // Update
        $comments = 'comments updated';
        $doBanners = MAX_DB::staticGetDO('banners', $bannerId1);
        $doBanners->comments = $comments;
        // wait 1s
        $time = time();
        $doBanners->update();
        
        $doBanners2 = MAX_DB::staticGetDO('banners', $bannerId1);
        
        // Test that it should update time automatically
        $this->assertTrue($doBanners2->refreshUpdatedFieldIfExists);
        
        // Test that comment was changed
        $this->assertNotEqual($doBanners1->comments, $doBanners2->comments);
        
        // Test that "updated" was updated
        $this->assertTrue(strtotime($doBanners1->updated) <= strtotime($doBanners2->updated));
        
        // Test updates is equal or greater than our checkpoint time
        $this->assertTrue($time <= strtotime($doBanners1->updated));
    }
    
    function testInsert()
    {
        $time = time();
        $doBanners = MAX_DB::factoryDO('banners');
        $doBanners->comments = $comments = 'test123';
        $bannerId = $doBanners->insert();
        
        $doBanners = MAX_DB::staticGetDO('banners', $bannerId);
        
        // Test comment is the same
        $this->assertEqual($doBanners->comments, $comments);
        
        // Test updates is equal or greater than our checkpoint time
        $this->assertTrue($time <= strtotime($doBanners->updated));
        
        // Test slashes
        $string = "some slashes ' ' \' \\";
        $doBanners = MAX_DB::factoryDO('banners');
        $doBanners->comments = $string;
        $bannerId = $doBanners->insert();
        
        $doBannersCheck = MAX_DB::staticGetDO('banners', $bannerId);
        $this->assertEqual($string, $doBannersCheck->comments);
    }
    
    function testGetFirstPrimaryKey()
    {
        $doBanners = MAX_DB::factoryDO('banners');
        $key = $doBanners->getFirstPrimaryKey();
        $this->assertEqual($key, 'bannerid');
    }
    
    function testConnection()
    {
        $dbh = &OA_DB::singleton();
        
        $doBanners = MAX_DB::factoryDO('banners');
        $doBanners->count();
        
        // First let's check if global object still keeps the correct reference
        global $_DB_DATAOBJECT;
        $dbh1 = &$_DB_DATAOBJECT['CONNECTIONS'][$doBanners->_database_dsn_md5];
        $this->assertReference($dbh, $dbh1);
        
        // Now take the connection from DataObject
        $dbh1 =& $doBanners->getDatabaseConnection();
        $this->assertIdentical($dbh, $dbh1);
        
        // But why this one doesn't work?
        // $this->assertReference($dbh, $dbh1);
    }
}
