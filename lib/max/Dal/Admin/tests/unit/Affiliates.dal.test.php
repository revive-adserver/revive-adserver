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
require_once MAX_PATH . '/lib/max/Dal/Admin/Affiliates.php';

/**
 * A class for testing DAL Affiliates methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class MAX_Dal_Admin_AffiliatesTest extends DalUnitTestCase
{
    var $dalAffiliates;
    
    /**
     * The constructor method.
     */
    function MAX_Dal_Admin_AffiliatesTest()
    {
        $this->UnitTestCase();
    }
    
    function setUp()
    {
        $this->dalAffiliates = MAX_DB::factoryDAL('affiliates');
    }
    
    function tearDown()
    {
        DataGenerator::cleanUp();
    }
    
    function testGetAffiliateByKeyword()
    {
        // Insert some affiliates
        $aData = array(
            'name' => array('foo', 'foobar'),
            'agencyid' => array(1, 2)
        );
        $dg = new DataGenerator();
        $dg->setData('affiliates', $aData);
        $aAffiliateId = $dg->generate('affiliates', 2);
        
        // Search by name
        $expectedRows = 2;
        $rsAffiliates = $this->dalAffiliates->getAffiliateByKeyword('foo');
        $rsAffiliates->find();
        $actualRows = $rsAffiliates->getRowCount();
        $this->assertEqual($actualRows, $expectedRows);
        
        // Search by id
        $expectedRows = 1;
        $rsAffiliates = $this->dalAffiliates->getAffiliateByKeyword($aAffiliateId[0]);
        $rsAffiliates->find();
        $actualRows = $rsAffiliates->getRowCount();
        $this->assertEqual($actualRows, $expectedRows);
        
        // Restrict to agency
        $expectedRows = 1;
        $rsAffiliates = $this->dalAffiliates->getAffiliateByKeyword('foo', 1);
        $rsAffiliates->find();
        $actualRows = $rsAffiliates->getRowCount();
        $this->assertEqual($actualRows, $expectedRows);
    }
    
    function testGetPublishersByTracker()
    {
        $campaignId = 1;
        
        // Add a couple of campaign_trackers
        $doCampaignsTrackers = MAX_DB::factoryDO('campaigns_trackers');
        $doCampaignsTrackers->campaignid = $campaignId;
        $doCampaignsTrackers->trackerid = 1;
        $aCampaignTrackerId = DataGenerator::generate($doCampaignsTrackers, 2);
        
        $doBanners = MAX_DB::factoryDO('banners');
        $doBanners->campaignid = $campaignId;
        $bannerId = DataGenerator::generateOne($doBanners);
        
        // Add a couple of affiliates
        $aAffiliateId = DataGenerator::generate('affiliates', 2);
        
        $doZones = MAX_DB::factoryDO('zones');
        $doZones->affiliateid = $aAffiliateId[0];
        $zoneId = DataGenerator::generateOne($doZones);
        
        $doAddZoneAssoc = MAX_DB::factoryDO('ad_zone_assoc');
        $doAddZoneAssoc->zone_id = $zoneId;
        $doAddZoneAssoc->ad_id = $BannerId;
        $adZoneAssocId = DataGenerator::generateOne($doAddZoneAssoc);

        // Test the correct number of rows is returned.
        $expectedRows = 1;
        $rsAffiliates = $this->dalAffiliates->getPublishersByTracker($aCampaignTrackerId[0]);
        $rsAffiliates->find();
        $actualRows = $rsAffiliates->getRowCount();
        $this->assertEqual($actualRows, $expectedRows);
    }
    
}
?>