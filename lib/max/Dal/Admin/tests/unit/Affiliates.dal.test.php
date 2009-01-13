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
        $this->dalAffiliates = OA_Dal::factoryDAL('affiliates');
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testGetAffiliateByKeyword()
    {
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->name = 'foo';
        $doAffiliates->agencyid = 1;
        $aAffiliateId1 = DataGenerator::generateOne($doAffiliates);

        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->name = 'foobar';
        $doAffiliates->agencyid = 2;
        $aAffiliateId12= DataGenerator::generateOne($doAffiliates);

        // Search by name
        $expectedRows = 2;
        $rsAffiliates = $this->dalAffiliates->getAffiliateByKeyword('foo');
        $rsAffiliates->find();
        $actualRows = $rsAffiliates->getRowCount();
        $this->assertEqual($actualRows, $expectedRows);

        // Search by id
        $expectedRows = 1;
        $rsAffiliates = $this->dalAffiliates->getAffiliateByKeyword($aAffiliateId1);
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
        $doCampaignsTrackers = OA_Dal::factoryDO('campaigns_trackers');
        $doCampaignsTrackers->campaignid = $campaignId;
        $doCampaignsTrackers->trackerid = 1;
        $aCampaignTrackerId = DataGenerator::generate($doCampaignsTrackers, 2);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $campaignId;
        $doBanners->acls_updated = '2007-04-03 18:39:45';
        $bannerId = DataGenerator::generateOne($doBanners, true);

        // Add a couple of affiliates
        $aAffiliateId = DataGenerator::generate('affiliates', 2);

        $doZones = OA_Dal::factoryDO('zones');
        $doZones->affiliateid = $aAffiliateId[0];
        $zoneId = DataGenerator::generateOne($doZones);

        $doAddZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
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