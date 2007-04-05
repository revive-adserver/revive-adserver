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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';
require_once MAX_PATH . '/lib/max/Dal/Admin/Campaigns.php';

/**
 * A class for testing DAL Campaigns methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class MAX_Dal_Admin_CampaignsTest extends DalUnitTestCase
{
    var $dalCampaigns;

    /**
     * The constructor method.
     */
    function MAX_Dal_Admin_CampaignsTest()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        $this->dalCampaigns = OA_Dal::factoryDAL('campaigns');
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    /**
     * Tests all campaigns are returned.
     *
     */
    function testGetAllCampaigns()
    {
        // Insert campaigns
        $numCampaigns = 2;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $aCampaignId = DataGenerator::generate($doCampaigns, $numCampaigns);

        // Call method
        $aCampaigns = $this->dalCampaigns->getAllCampaigns('name', 'up');

        // Test same number of campaigns are returned.
        $this->assertEqual(count($aCampaigns), $numCampaigns);
    }


    function testCountActiveCampaigns()
    {
        // Insert an active campaign
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->active = 't';
        $activeId = DataGenerator::generateOne($doCampaigns);

        // Insert an inactive campaign
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->active = 'f';
        $inactiveId = DataGenerator::generateOne($doCampaigns);

        // Count the active campaigns
        $activeCount = $this->dalCampaigns->countActiveCampaigns();

        $expected = 1;
        $this->assertEqual($activeCount, $expected);
    }

    function testCountActiveCampaignsUnderAgency()
    {
        $agencyId = 1;

        // Insert an advertiser under this agency.
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $agencyId;
        $doClients->reportlastdate = '2007-04-03 19:14:59';
        $agencyClientId = DataGenerator::generateOne($doClients);

        // Insert an active campaign with this client
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->active = 't';
        $doCampaigns->clientid = $agencyClientId;
        $agencyCampaignIdActive = DataGenerator::generateOne($doCampaigns);

        // Insert an inactive campaign with this client
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->active = 'f';
        $doCampaigns->clientid = $agencyClientId;
        $agencyCampaignInactiveId = DataGenerator::generateOne($doCampaigns);

        // Insert an advertiser under no agency.
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = 0;
        $doClients->reportlastdate = '2007-04-03 19:14:59';
        $noAgencyClientId = DataGenerator::generateOne($doClients);

         // Insert an active campaign with this client
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->active = 't';
        $doCampaigns->clientid = $noAgencyClientId;
        $noAgencyCampaignIdActive = DataGenerator::generateOne($doCampaigns);

        // Count the active campaigns
        $expected = 1;
        $activeCount = $this->dalCampaigns->countActiveCampaignsUnderAgency($agencyId);

        $this->assertEqual($activeCount, $expected);
    }

    function testGetCampaignAndClientByKeyword()
    {
        // Search for campaigns when none exist.
        $expected = 0;
        $rsCampaigns = $this->dalCampaigns->getCampaignAndClientByKeyword('foo');
        $rsCampaigns->find();
        $actual = $rsCampaigns->getRowCount();
        $this->assertEqual($actual, $expected);

        $agencyId = 1;
        $rsCampaigns = $this->dalCampaigns->getCampaignAndClientByKeyword('foo', $agencyId);
        $rsCampaigns->find();
        $actual = $rsCampaigns->getRowCount();
        $this->assertEqual($actual, $expected);

        // Create a campaign
        $doCampaign = OA_Dal::factoryDO('campaigns');
        $doCampaign->campaignname = 'foo';
        $aData = array(
            'reportlastdate' => array('2007-04-03 18:39:45')
        );
        $dg = new DataGenerator();
        $dg->setData('clients', $aData);
        $dg->generate($doCampaign, 1, true);
        $agencyId = DataGenerator::getReferenceId('agency');

        // Search for the campaign
        $expected = 0;
        $rsCampaigns = $this->dalCampaigns->getCampaignAndClientByKeyword('bar');
        $rsCampaigns->find();
        $actual = $rsCampaigns->getRowCount();
        $this->assertEqual($actual, $expected);

        $expected = 1;
        $rsCampaigns = $this->dalCampaigns->getCampaignAndClientByKeyword('foo');
        $rsCampaigns->find();
        $actual = $rsCampaigns->getRowCount();
        $this->assertEqual($actual, $expected);

        // Restrict the search to agency (defaults to 1)
        $rsCampaigns = $this->dalCampaigns->getCampaignAndClientByKeyword('foo', $agencyId);
        $rsCampaigns->find();
        $actual = $rsCampaigns->getRowCount();
        $this->assertEqual($actual, $expected);
    }

    /**
     *
     * @todo The method this tests is very large so this test could be expanded
     *       or, better, getDaysLeft() could be refactored.
     */
    function testGetDaysLeft()
    {
        $GLOBALS['strExpiration'] = 'Expiration';
        $GLOBALS['strEstimated'] = 'Estimated Expiration';
        $GLOBALS['strNoExpiration'] = 'No expiration date set';
        $GLOBALS['date_format'] = '%d.%m.%Y';
        $GLOBALS['strDaysLeft'] = 'Days left';

        // Test an unlimited campaign with no expiration date
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->acls_updated = '2007-04-03 18:39:45';
        $aData = array(
            'reportlastdate' => array('2007-04-03 18:39:45')
        );
        $dg = new DataGenerator();
        $dg->setData('clients', $aData);
        $bannerId = $dg->generateOne($doBanners, 1, true);
        $campaignId = DataGenerator::getReferenceId('campaigns');

        $expected = array($GLOBALS['strExpiration'].": ".$GLOBALS['strNoExpiration'],'', '');
        $actual = $this->dalCampaigns->getDaysLeft($campaignId);
        $this->assertEqual($actual, $expected);

        // Test an unlimited campaign with an expiration date of today + 10 days
        $daysLeft = 10;
        $now = time();
        $expirationDate = mktime(0, 0, 0, date("m", $now), date("d", $now) + $daysLeft, date("Y", $now));
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->views = -1;
        $doCampaigns->clicks = -1;
        $doCampaigns->expire = date('Y-m-d', $expirationDate);
        $aData = array(
            'reportlastdate' => array('2007-04-03 18:39:45')
        );
        $dg = new DataGenerator();
        $dg->setData('clients', $aData);
        $aCampaignIds = $dg->generate($doCampaigns, 1, true);
        $campaignId = $aCampaignIds[0];

        // Link a banner to this campaign
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $campaignId;
        $doBanners->acls_updated = '2007-04-03 18:39:45';
        $bannerId = DataGenerator::generateOne($doBanners);

        $expected = array(
            $GLOBALS['strExpiration'] . ': ' . date('d.m.Y', $expirationDate) . " (".$GLOBALS['strDaysLeft'].": " . $daysLeft .")",
            date('d.m.Y', $expirationDate),
            $daysLeft
        );
        $actual = $this->dalCampaigns->getDaysLeft($campaignId);
        $this->assertEqual($actual, $expected);

        // Test a view limited campaign
        $views = 1000;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->views = $views;
        $doCampaigns->clicks = -1;
        $aData = array(
            'reportlastdate' => array('2007-04-03 18:39:45')
        );
        $dg = new DataGenerator();
        $dg->setData('clients', $aData);
        $aCampaignIds = $dg->generate($doCampaigns, 1, true);
        $campaignId = $aCampaignIds[0];

        // Link a banner to this campaign
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $campaignId;
        $doBanners->acls_updated = '2007-04-03 18:39:45';
        $bannerId = DataGenerator::generateOne($doBanners);

        // Insert some dsah data
        $impressions = 50;
        $clicks = 5;
        $doDSAH = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDSAH->day = date('Y-m-d', $now);
        $doDSAH->hour = 10;
        $doDSAH->ad_id = $bannerId;
        $doDSAH->impressions = $impressions;
        $doDSAH->clicks = $clicks;
        $dsahId = DataGenerator::generateOne($doDSAH);

        $daysLeft = round($views / ($impressions / 1));
        $expirationDate = mktime(0, 0, 0, date("m", $now), date("d", $now) + $daysLeft, date("Y", $now));
        $expected = array(
            $GLOBALS['strEstimated'] . ': ' . date('d.m.Y', $expirationDate) . " (".$GLOBALS['strDaysLeft'].": " . $daysLeft .")",
            date('d.m.Y', $expirationDate),
            $daysLeft
        );
        $actual = $this->dalCampaigns->getDaysLeft($campaignId);
        $this->assertEqual($actual, $expected);

        // Test a click limited campaign
        $campaignClicks = 500;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->views = -1;
        $doCampaigns->clicks = $campaignClicks;
        $aData = array(
            'reportlastdate' => array('2007-04-03 18:39:45')
        );
        $dg = new DataGenerator();
        $dg->setData('clients', $aData);
        $aCampaignIds = $dg->generate($doCampaigns, 1, true);
        $campaignId = $aCampaignIds[0];

        // Link a banner to this campaign
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $campaignId;
        $doBanners->acls_updated = '2007-04-03 18:39:45';
        $bannerId = DataGenerator::generateOne($doBanners);

        // Insert some dsah data
        $impressions = 50;
        $clicks = 5;
        $doDSAH = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDSAH->day = date('Y-m-d', $now);
        $doDSAH->hour = 10;
        $doDSAH->ad_id = $bannerId;
        $doDSAH->impressions = $impressions;
        $doDSAH->clicks = $clicks;
        $dsahId = DataGenerator::generateOne($doDSAH);

        $daysLeft = round($campaignClicks / ($clicks / 1));
        $expirationDate = mktime(0, 0, 0, date("m", $now), date("d", $now) + $daysLeft, date("Y", $now));
        $expected = array(
            $GLOBALS['strEstimated'] . ': ' . date('d.m.Y', $expirationDate) . " (".$GLOBALS['strDaysLeft'].": " . $daysLeft .")",
            date('d.m.Y', $expirationDate),
            $daysLeft
        );
        $actual = $this->dalCampaigns->getDaysLeft($campaignId);
        $this->assertEqual($actual, $expected);
    }

    function testGetAdClicksLeft()
    {
        // Insert a campaign
        $numClicks = 100;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clicks = $numClicks;
        $campaignId = DataGenerator::generateOne($doCampaigns);

        $this->assertEqual($this->dalCampaigns->getAdClicksLeft($campaignId), $numClicks);

        // Set the clicks to unlimited
        $numClicks = -1;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clicks = $numClicks;
        $campaignId = DataGenerator::generateOne($doCampaigns);

        global $strUnlimited;
        $expected = $strUnlimited;
        $this->assertEqual($this->dalCampaigns->getAdClicksLeft($campaignId), $expected);
    }

    function testGetAdViewsLeft()
    {
        // Insert a campaign
        $numViews = 100;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->views = $numViews;
        $campaignId = DataGenerator::generateOne($doCampaigns);

        $this->assertEqual($this->dalCampaigns->getAdViewsLeft($campaignId), $numViews);

        // Set the views to unlimited
        $numViews = -1;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->views = $numViews;
        $campaignId = DataGenerator::generateOne($doCampaigns);

        global $strUnlimited;
        $expected = $strUnlimited;
        $this->assertEqual($this->dalCampaigns->getAdViewsLeft($campaignId), $expected);
    }

    function testGetAllCampaignsUnderAgency()
    {
        // Test it doesn't return any data if no records are added
        $this->assertEqual(count($this->dalCampaigns->getAllCampaignsUnderAgency(123,'name','up')), 0);

        // Add test data (add a little bit more than required)
        $numCampaigns1 = 3;
        $aData = array(
            'reportlastdate' => array('2007-04-03 18:39:45')
        );
        $dg = new DataGenerator();
        $dg->setData('clients', $aData);
        $aCampaigns1 = $dg->generate('campaigns', $numCampaigns1, true);
        $agencyId1 = DataGenerator::getReferenceId('agency');

        $numCampaigns2 = 2;
        $aData = array(
            'reportlastdate' => array('2007-04-03 18:39:45')
        );
        $dg = new DataGenerator();
        $dg->setData('clients', $aData);
        $aCampaigns2 = $dg->generate('campaigns', $numCampaigns2, true);
        $agencyId2 = DataGenerator::getReferenceId('agency');

        // Take test data
        $aCampaigns = $this->dalCampaigns->getAllCampaignsUnderAgency($agencyId2,'name','up');
        $this->assertEqual(count($aCampaigns), $numCampaigns2);
        $this->assertEqual(array_keys($aCampaigns), $aCampaigns2);
    }


}