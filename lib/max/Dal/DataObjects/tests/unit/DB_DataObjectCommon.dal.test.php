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
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Banners.php';
require_once MAX_PATH . '/lib/max/tests/util/DataGenerator.php';

/**
 * A class for testing DB_DataObjectsCommon
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 * @TODO No tests written yet...
 */
class DB_DataObjectCommonTest extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function DB_DataObjectCommonTest()
    {
        $this->UnitTestCase();
    }
    
    function tearDown()
    {
        TestEnv::restoreEnv();
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
        $aCampaignId = DataGenerator::generate($doCampaigns, 2);
        // and few additional required for testing filters
        $doCampaigns->campaignname = $campaignName = 'test name';
        $doCampaigns->clientid = $clientId = 123;
        $aCampaignId = DataGenerator::generate($doCampaigns, 2);
        
        // test getting all records
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $aCheck = $doCampaigns->getAll();
        $this->assertEqual(count($aCheck), 4);
        
        $doCampaignsFilter = MAX_DB::factoryDO('campaigns');
        $doCampaignsFilter->clientid = $clientId;
        
        // test filtering and test that rows are not indexed by primary key
        $doCampaigns = clone($doCampaignsFilter);
        $aCheck = $doCampaigns->getAll();
        $this->assertEqual(count($aCheck), 2);
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
    }
    
    /**
     * Tests deleting linked objects
     *
     */
    function testDelete()
    {
        // Insert advertiser
        $doClients = MAX_DB::factoryDO('clients');
        $doClients->clientname = 'test advertiser';
        $doClients->agencyid = 0;
        $clientId = DataGenerator::generateOne($doClients);
        
        // Insert advertiser_preferences
        $doPreferenceAdvertiser = MAX_DB::factoryDO('preference_advertiser');
        $doPreferenceAdvertiser->advertiser_id = $clientId;
        $doPreferenceAdvertiser->preference = 'foo';
        $doPreferenceAdvertiser->value = 'bar';
        $preferenceAdvertiserId = DataGenerator::generateOne($doPreferenceAdvertiser);
        
        // Insert campaigns
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $doCampaigns->clientid = $clientId;
        $aCampaignId = DataGenerator::generate($doCampaigns, 2);
        
        // Insert linked banners
        $doBanners = MAX_DB::factoryDO('banners');
        $doBanners->campaignid = $campaignId;
        $aBannerId = DataGenerator::generate($doBanners, 2);
        
        // Insert linked trackers
        $doTrackers = MAX_DB::factoryDO('trackers');
        $doTrackers->clientid = $clientId;
        $aTrackerId = DataGenerator::generate($doTrackers, 2);
        
        // Call delete on the inserted client.
        $doClients = MAX_DB::staticGetDO('clients', $clientId);
        $doClients->delete();
        
        // Check advertiser is deleted
        $doClients = MAX_DB::staticGetDO('clients', $clientId);
        $this->assertFalse($doClients, 'Client should not exist');
        
        // Check all campaigns are deleted
        $doCampaigns = MAX_DB::factoryDO('campaigns');
        $doCampaigns->clientid = $clientId;
        $doCampaigns->find();
        $this->assertEqual($doCampaigns->getRowCount(), 0, 'No campaigns should be found');
        
        // Check all banners are deleted
        $doBanners = MAX_DB::factoryDO('banners');
        $doBanners->whereAdd('campaignid in (' . implode(',', $aCampaignId) . ')');
        $doBanners->find();
        $this->assertEqual($doCampaigns->getRowCount(), 0, 'No banners should be found');

        // Check all trackers are deleted
        $doTrackers = MAX_DB::factoryDO('trackers');
        $doTrackers->client = $clientId;
        $doTrackers->find();
        $this->assertEqual($doTrackers->getRowCount(), 0, 'No trackers should be found');
        
        // Check all preferences are deleted
        $doPreferenceAdvertiser = MAX_DB::factoryDO('preference_advertiser');
        $doPreferenceAdvertiser->advertiserid = $clientId;
        $doPreferenceAdvertiser->find();
        $this->assertEqual($doPreferenceAdvertiser->getRowCount(), 0, 'No advertiser preferences should be found');
    }
    
    function testBelongToUser()
    {
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
        
    }
}
