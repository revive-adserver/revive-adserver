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
require_once MAX_PATH . '/lib/max/Dal/DataObjects/tests/util/DataGenerator.php';

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
    
       /**
     * Tests advertiser and any linked objects are deleted.
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
        
        // Restore env
        TestEnv::restoreEnv();
    }
}
