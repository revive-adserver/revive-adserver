<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

    var $oDalCampaigns;

    /**
     * The constructor method.
     */
    function MAX_Dal_Admin_CampaignsTest()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        $this->oDalCampaigns = OA_Dal::factoryDAL('campaigns');
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
        $aCampaigns = $this->oDalCampaigns->getAllCampaigns('name', 'up');

        // Test same number of campaigns are returned.
        $this->assertEqual(count($aCampaigns), $numCampaigns);
    }


    function testCountActiveCampaigns()
    {
        // Insert an active campaign
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->status = 1;
        $activeId = DataGenerator::generateOne($doCampaigns);

        // Insert an inactive campaign
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->status = 0;
        $inactiveId = DataGenerator::generateOne($doCampaigns);

        // Count the active campaigns
        $activeCount = $this->oDalCampaigns->countActiveCampaigns();

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
        $doCampaigns->status = 1;
        $doCampaigns->clientid = $agencyClientId;
        $agencyCampaignIdActive = DataGenerator::generateOne($doCampaigns);

        // Insert an inactive campaign with this client
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->status = 0;
        $doCampaigns->clientid = $agencyClientId;
        $agencyCampaignInactiveId = DataGenerator::generateOne($doCampaigns);

        // Insert an advertiser under no agency.
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = 0;
        $doClients->reportlastdate = '2007-04-03 19:14:59';
        $noAgencyClientId = DataGenerator::generateOne($doClients);

         // Insert an active campaign with this client
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->status = 1;
        $doCampaigns->clientid = $noAgencyClientId;
        $noAgencyCampaignIdActive = DataGenerator::generateOne($doCampaigns);

        // Count the active campaigns
        $expected = 1;
        $activeCount = $this->oDalCampaigns->countActiveCampaignsUnderAgency($agencyId);

        $this->assertEqual($activeCount, $expected);
    }

    function testGetCampaignAndClientByKeyword()
    {
        // Search for campaigns when none exist.
        $expected = 0;
        $rsCampaigns = $this->oDalCampaigns->getCampaignAndClientByKeyword('foo');
        $rsCampaigns->find();
        $actual = $rsCampaigns->getRowCount();
        $this->assertEqual($actual, $expected);

        $agencyId = 1;
        $rsCampaigns = $this->oDalCampaigns->getCampaignAndClientByKeyword('foo', $agencyId);
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
        $rsCampaigns = $this->oDalCampaigns->getCampaignAndClientByKeyword('bar');
        $rsCampaigns->find();
        $actual = $rsCampaigns->getRowCount();
        $this->assertEqual($actual, $expected);

        $expected = 1;
        $rsCampaigns = $this->oDalCampaigns->getCampaignAndClientByKeyword('foo');
        $rsCampaigns->find();
        $actual = $rsCampaigns->getRowCount();
        $this->assertEqual($actual, $expected);

        // Restrict the search to agency (defaults to 1)
        $rsCampaigns = $this->oDalCampaigns->getCampaignAndClientByKeyword('foo', $agencyId);
        $rsCampaigns->find();
        $actual = $rsCampaigns->getRowCount();
        $this->assertEqual($actual, $expected);
    }


    /**
     * A method to test the getDaysLeftString() method.
     */
    function test_getDaysLeftString()
    {
        $GLOBALS['strExpiration']   = 'Expiration';
        $GLOBALS['strEstimated']    = 'Estimated Expiration';
        $GLOBALS['strNoExpiration'] = 'No expiration date set';
        $GLOBALS['date_format']     = '%d.%m.%Y';
        $GLOBALS['strDaysLeft']     = 'Days left';



        // Test an unlimited campaign with no expiration date
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->views       = 0;
        $doCampaigns->clicks      = 0;
        $doCampaigns->conversions = 0;
        $aData = array(
            'reportlastdate' => array('2007-04-03 18:39:45')
        );
        $dg = new DataGenerator();
        $dg->setData('clients', $aData);
        $aCampaignIds = $dg->generate($doCampaigns, 1, true);
        $campaignId = $aCampaignIds[0];

        $expected = $GLOBALS['strExpiration'].": ".$GLOBALS['strNoExpiration'];
        $actual = $this->oDalCampaigns->getDaysLeftString($campaignId);
        $this->assertEqual($actual, $expected);



        // Prepare a date 10 days in the future
        $daysLeft = 10;
        $oDate = new Date();
        $oDate->addSeconds($daysLeft * SECONDS_PER_DAY);



        // Test an unlimited campaign which expires 10 days in the future
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->views       = 0;
        $doCampaigns->clicks      = 0;
        $doCampaigns->conversions = 0;
        $doCampaigns->expire      = $oDate->format('%Y-%m-%d');
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

        $expected = $GLOBALS['strExpiration'] . ': ' . $oDate->format('%d.%m.%Y') . " (".$GLOBALS['strDaysLeft'].": " . $daysLeft. ')';
        $actual = $this->oDalCampaigns->getDaysLeftString($campaignId);
        $this->assertEqual($actual, $expected);



        // Test an impression limited campaign with no expiration date
        $totalImpressions = 1000;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->views       = $totalImpressions;
        $doCampaigns->clicks      = 0;
        $doCampaigns->conversions = 0;
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

        // Insert impression delivery data occurring today
        $oDate = new Date();
        $impressions = 50;
        $clicks      = 5;
        $conversions = 1;
        $doDSAH = OA_Dal::factoryDO('data_intermediate_ad');
        $doDSAH->day         = $oDate->format('%Y-%m-%d');
        $doDSAH->hour        = 10;
        $doDSAH->ad_id       = $bannerId;
        $doDSAH->impressions = $impressions;
        $doDSAH->clicks      = $clicks;
        $doDSAH->conversions = $conversions;
        $dsahId = DataGenerator::generateOne($doDSAH);

        $daysLeft = 19; // Delivered 50 impressions in 1 day. So, expect to take 19 days to deliver remaining 950
        $oExpirationDate = new Date();
        $oExpirationDate->copy($oDate);
        $oExpirationDate->addSeconds($daysLeft * SECONDS_PER_DAY);
        $expected = $GLOBALS['strEstimated'] . ': ' . $oExpirationDate->format('%d.%m.%Y') . " (".$GLOBALS['strDaysLeft'].": " . $daysLeft .")";
        $actual = $this->oDalCampaigns->getDaysLeftString($campaignId);
        $this->assertEqual($actual, $expected);



        // Test a click limited campaign with no expiration date
        $totalClicks = 500;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->views       = 0;
        $doCampaigns->clicks      = $totalClicks;
        $doCampaigns->conversions = 0;
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

        // Insert click delivery data occurring today
        $oDate = new Date();
        $impressions = 50;
        $clicks      = 5;
        $conversions = 1;
        $doDSAH = OA_Dal::factoryDO('data_intermediate_ad');
        $doDSAH->day         = $oDate->format('%Y-%m-%d');
        $doDSAH->hour        = 10;
        $doDSAH->ad_id       = $bannerId;
        $doDSAH->impressions = $impressions;
        $doDSAH->clicks      = $clicks;
        $doDSAH->conversions = $conversions;
        $dsahId = DataGenerator::generateOne($doDSAH);

        $daysLeft = 99; // Delivered 5 clicks in 1 day. So, expect to take 99 days to deliver remaining 495
        $oExpirationDate = new Date();
        $oExpirationDate->copy($oDate);
        $oExpirationDate->addSeconds($daysLeft * SECONDS_PER_DAY);
        $expected = $GLOBALS['strEstimated'] . ': ' . $oExpirationDate->format('%d.%m.%Y') . " (".$GLOBALS['strDaysLeft'].": " . $daysLeft .")";
        $actual = $this->oDalCampaigns->getDaysLeftString($campaignId);
        $this->assertEqual($actual, $expected);



        // Test a conversion limited campaign with no expiration date
        $totalConversions = 10;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->views       = 0;
        $doCampaigns->clicks      = 0;
        $doCampaigns->conversions = $totalConversions;
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

        // Insert conversion delivery data occurring today
        $oDate = new Date();
        $impressions = 50;
        $clicks      = 5;
        $conversions = 1;
        $doDSAH = OA_Dal::factoryDO('data_intermediate_ad');
        $doDSAH->day         = $oDate->format('%Y-%m-%d');
        $doDSAH->hour        = 10;
        $doDSAH->ad_id       = $bannerId;
        $doDSAH->impressions = $impressions;
        $doDSAH->clicks      = $clicks;
        $doDSAH->conversions = $conversions;
        $dsahId = DataGenerator::generateOne($doDSAH);

        $daysLeft = 9; // Delivered 1 conversion in 1 day. So, expect to take 9 days to deliver remaining 9
        $oExpirationDate = new Date();
        $oExpirationDate->copy($oDate);
        $oExpirationDate->addSeconds($daysLeft * SECONDS_PER_DAY);
        $expected = $GLOBALS['strEstimated'] . ': ' . $oExpirationDate->format('%d.%m.%Y') . " (".$GLOBALS['strDaysLeft'].": " . $daysLeft .")";
        $actual = $this->oDalCampaigns->getDaysLeftString($campaignId);
        $this->assertEqual($actual, $expected);



        // Test a triple limited campaign with no expiration date
        $totalImpressions = 1000;
        $totalClicks      = 500;
        $totalConversions = 10;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->views       = $totalImpressions;
        $doCampaigns->clicks      = $totalClicks;
        $doCampaigns->conversions = $totalConversions;
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

        // Insert conversion delivery data occurring today
        $oDate = new Date();
        $impressions = 50;
        $clicks      = 5;
        $conversions = 1;
        $doDSAH = OA_Dal::factoryDO('data_intermediate_ad');
        $doDSAH->day         = $oDate->format('%Y-%m-%d');
        $doDSAH->hour        = 10;
        $doDSAH->ad_id       = $bannerId;
        $doDSAH->impressions = $impressions;
        $doDSAH->clicks      = $clicks;
        $doDSAH->conversions = $conversions;
        $dsahId = DataGenerator::generateOne($doDSAH);

        // Delivered 50 impressions in 1 day. So, expect to take 19 days to deliver remaining 950
        // Delivered 5 clicks in 1 day. So, expect to take 99 days to deliver remaining 495
        // Delivered 1 conversion in 1 day. So, expect to take 9 days to deliver remaining 9
        $daysLeft = 9; // Smallest of the above 3 values!
        $oExpirationDate = new Date();
        $oExpirationDate->copy($oDate);
        $oExpirationDate->addSeconds($daysLeft * SECONDS_PER_DAY);
        $expected = $GLOBALS['strEstimated'] . ': ' . $oExpirationDate->format('%d.%m.%Y') . " (".$GLOBALS['strDaysLeft'].": " . $daysLeft .")";
        $actual = $this->oDalCampaigns->getDaysLeftString($campaignId);
        $this->assertEqual($actual, $expected);



        // Prepare a date 10 days in the future
        $daysLeft = 10;
        $oDate = new Date();
        $oDate->addSeconds($daysLeft * SECONDS_PER_DAY);



        // Test a triple limited campaign with an expiration date 10 days in the future
        $totalImpressions = 1000;
        $totalClicks      = 500;
        $totalConversions = 10;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->views       = $totalImpressions;
        $doCampaigns->clicks      = $totalClicks;
        $doCampaigns->conversions = $totalConversions;
        $doCampaigns->expire      = $oDate->format('%Y-%m-%d');
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

        // Insert conversion delivery data occurring today
        $oDate = new Date();
        $impressions = 50;
        $clicks      = 5;
        $conversions = 1;
        $doDSAH = OA_Dal::factoryDO('data_intermediate_ad');
        $doDSAH->day         = $oDate->format('%Y-%m-%d');
        $doDSAH->hour        = 10;
        $doDSAH->ad_id       = $bannerId;
        $doDSAH->impressions = $impressions;
        $doDSAH->clicks      = $clicks;
        $doDSAH->conversions = $conversions;
        $dsahId = DataGenerator::generateOne($doDSAH);

        // Expiration date is in 10 days
        // Delivered 50 impressions in 1 day. So, expect to take 19 days to deliver remaining 950
        // Delivered 5 clicks in 1 day. So, expect to take 99 days to deliver remaining 495
        // Delivered 1 conversion in 1 day. So, expect to take 9 days to deliver remaining 9
        $daysLeft = 9; // Smallest of the above 4 values!
        $oExpirationDate = new Date();
        $oExpirationDate->copy($oDate);
        $oExpirationDate->addSeconds($daysLeft * SECONDS_PER_DAY);
        $expected = $GLOBALS['strEstimated'] . ': ' . $oExpirationDate->format('%d.%m.%Y') . " (".$GLOBALS['strDaysLeft'].": " . $daysLeft .")";
        $actual = $this->oDalCampaigns->getDaysLeftString($campaignId);
        $this->assertEqual($actual, $expected);



        // Prepare a date 8 days in the future
        $daysLeft = 8;
        $oDate = new Date();
        $oDate->addSeconds($daysLeft * SECONDS_PER_DAY);



        // Test a triple limited campaign with an expiration date 8 days in the future
        $totalImpressions = 1000;
        $totalClicks      = 500;
        $totalConversions = 10;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->views       = $totalImpressions;
        $doCampaigns->clicks      = $totalClicks;
        $doCampaigns->conversions = $totalConversions;
        $doCampaigns->expire      = $oDate->format('%Y-%m-%d');
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

        // Insert conversion delivery data occurring today
        $oDate = new Date();
        $impressions = 50;
        $clicks      = 5;
        $conversions = 1;
        $doDSAH = OA_Dal::factoryDO('data_intermediate_ad');
        $doDSAH->day         = $oDate->format('%Y-%m-%d');
        $doDSAH->hour        = 10;
        $doDSAH->ad_id       = $bannerId;
        $doDSAH->impressions = $impressions;
        $doDSAH->clicks      = $clicks;
        $doDSAH->conversions = $conversions;
        $dsahId = DataGenerator::generateOne($doDSAH);

        // Expiration date is in 8 days
        // Delivered 50 impressions in 1 day. So, expect to take 19 days to deliver remaining 950
        // Delivered 5 clicks in 1 day. So, expect to take 99 days to deliver remaining 495
        // Delivered 1 conversion in 1 day. So, expect to take 9 days to deliver remaining 9
        $daysLeft = 8; // Smallest of the above 4 values!
        $oExpirationDate = new Date();
        $oExpirationDate->copy($oDate);
        $oExpirationDate->addSeconds($daysLeft * SECONDS_PER_DAY);
        $expected = $GLOBALS['strExpiration'] . ': ' . $oExpirationDate->format('%d.%m.%Y') . " (".$GLOBALS['strDaysLeft'].": " . $daysLeft .")";
        $actual = $this->oDalCampaigns->getDaysLeftString($campaignId);
        $this->assertEqual($actual, $expected);
    }

    function testGetAdClicksLeft()
    {
        // Insert a campaign
        $numClicks = 100;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clicks = $numClicks;
        $campaignId = DataGenerator::generateOne($doCampaigns);

        $this->assertEqual($this->oDalCampaigns->getAdClicksLeft($campaignId), $numClicks);

        // Set the clicks to unlimited
        $numClicks = -1;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clicks = $numClicks;
        $campaignId = DataGenerator::generateOne($doCampaigns);

        global $strUnlimited;
        $expected = $strUnlimited;
        $this->assertEqual($this->oDalCampaigns->getAdClicksLeft($campaignId), $expected);
    }

    function testGetAdImpressionsLeft()
    {
        // Insert a campaign
        $numViews = 100;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->views = $numViews;
        $campaignId = DataGenerator::generateOne($doCampaigns);

        $this->assertEqual($this->oDalCampaigns->getAdImpressionsLeft($campaignId), $numViews);

        // Set the views to unlimited
        $numViews = -1;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->views = $numViews;
        $campaignId = DataGenerator::generateOne($doCampaigns);

        global $strUnlimited;
        $expected = $strUnlimited;
        $this->assertEqual($this->oDalCampaigns->getAdImpressionsLeft($campaignId), $expected);
    }

    function testGetAllCampaignsUnderAgency()
    {
        // Test it doesn't return any data if no records are added
        $this->assertEqual(count($this->oDalCampaigns->getAllCampaignsUnderAgency(123,'name','up')), 0);

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
        $aCampaigns = $this->oDalCampaigns->getAllCampaignsUnderAgency($agencyId2,'name','up');
        $this->assertEqual(count($aCampaigns), $numCampaigns2);
        // Make sure that both arrays have the same sorting
        ksort($aCampaigns);
        sort($aCampaigns2);
        $this->assertEqual(array_keys($aCampaigns), array_values($aCampaigns2));
    }


}