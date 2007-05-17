<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Email.php';

/**
 * A class for testing the OA_Email class.
 *
 * @package    Openads
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Test_OA_Email extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Email()
    {
        $this->UnitTestCase();
    }

    /**
     * Tests that an e-mail reporting on placement delivery is able to be
     * generated correctly.
     */
    function testPreparePlacementDeliveryEmail()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];

        // Prepare valid test data
        $advertiserId = 1;
        $oStartDate   = new Date('2007-05-13 23:59:59');
        $oEndDate     = new Date('2007-05-19 00:00:00');
        $email        = 'andrew.hill@openads.org';
        $name         = 'Andrew Hill';
        $clientName   = 'Foo Client';

        // Prepare the admin email address and name
        $oPreference = OA_Dal::factoryDO('preference');
        $oPreference->agencyid       = 0;
        $oPreference->admin_fullname = 'Openads Ltd.';
        $oPreference->admin_email    = 'send@example.com';
        DataGenerator::generateOne($oPreference);

        // Test with no advertiser data in the database, and ensure that
        // false is returned
        $result = OA_Email::preparePlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $this->assertFalse($result);

        // Generate an advertiser with reports disabled and test, ensuring
        // that false is returned
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = $clientName;
        $doClients->email      = '';
        $doClients->contact    = '';
        $doClients->report     = 'f';
        $advertiserId = DataGenerator::generateOne($doClients);
        $result = OA_Email::preparePlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $this->assertFalse($result);

        // Generate an advertiser with reports enabled, but no other data,
        // and test, ensuring that false is returned
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = $clientName;
        $doClients->email      = '';
        $doClients->contact    = '';
        $doClients->report     = 't';
        $advertiserId = DataGenerator::generateOne($doClients);
        $result = OA_Email::preparePlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $this->assertFalse($result);

        // Generate an advertiser with reports enabled, and a sigle placement,
        // but no ads, ensuring that false is returned
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = $clientName;
        $doClients->email      = '';
        $doClients->contact    = '';
        $doClients->report     = 't';
        $advertiserId = DataGenerator::generateOne($doClients);
        $doPlacements = OA_Dal::factoryDO('campaigns');
        $doPlacements->clientid = $advertiserId;
        $placementId = DataGenerator::generateOne($doPlacements);
        $result = OA_Email::preparePlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $this->assertFalse($result);

        // Generate an advertiser with reports enabled & an email address,
        // and a sigle placement, but no ads, ensuring that the correct report
        // is generated
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = $clientName;
        $doClients->email      = $email;
        $doClients->contact    = $name;
        $doClients->report     = 't';
        $advertiserId = DataGenerator::generateOne($doClients);
        $doPlacements = OA_Dal::factoryDO('campaigns');
        $doPlacements->clientid = $advertiserId;
        $placementId1 = DataGenerator::generateOne($doPlacements);
        $aResult = OA_Email::preparePlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $expectedSubject = "Advertiser report: $clientName";
        $expectedContents  = "Dear $name,\n\n";
        $expectedContents .= "Below you will find the banner statistics for $clientName:\n";
        global $date_format;
        $startDate = $oStartDate->format($date_format);
        $endDate   = $oEndDate->format($date_format);
        $expectedContents .= "This report includes statistics from $startDate up to $endDate.\n\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= "There are no statistics available for this campaign\n\n\n\n";
        $expectedContents .= "Regards,\n   Openads Ltd.";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 4);
        $this->assertEqual($aResult['userEmail'], $email);
        $this->assertEqual($aResult['userName'], $name);
        $this->assertEqual($aResult['subject'], $expectedSubject);
        $this->assertEqual($aResult['contents'], $expectedContents);

        // Add another placement with no ads to the above advertiser, and test
        // that the correct report is generated
        $doPlacements = OA_Dal::factoryDO('campaigns');
        $doPlacements->clientid = $advertiserId;
        $placementId2 = DataGenerator::generateOne($doPlacements);
        $aResult = OA_Email::preparePlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $expectedSubject = "Advertiser report: $clientName";
        $expectedContents  = "Dear $name,\n\n";
        $expectedContents .= "Below you will find the banner statistics for $clientName:\n";
        global $date_format;
        $startDate = $oStartDate->format($date_format);
        $endDate   = $oEndDate->format($date_format);
        $expectedContents .= "This report includes statistics from $startDate up to $endDate.\n\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= "There are no statistics available for this campaign\n\n\n";
        $expectedContents .= "\nCampaign [id$placementId2] 1\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= "There are no statistics available for this campaign\n\n\n\n";
        $expectedContents .= "Regards,\n   Openads Ltd.";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 4);
        $this->assertEqual($aResult['userEmail'], $email);
        $this->assertEqual($aResult['userName'], $name);
        $this->assertEqual($aResult['subject'], $expectedSubject);
        $this->assertEqual($aResult['contents'], $expectedContents);

        // Add an ad to the second placements, but with no delivery data, and
        // ensure the correct email is generated (no change to previous!)
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId2;
        $adId1 = DataGenerator::generateOne($doBanners);
        $aResult = OA_Email::preparePlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 4);
        $this->assertEqual($aResult['userEmail'], $email);
        $this->assertEqual($aResult['userName'], $name);
        $this->assertEqual($aResult['subject'], $expectedSubject);
        $this->assertEqual($aResult['contents'], $expectedContents);

        // Add an ad to the second placements, with delivery data outside
        // the current date range, and ensure the correct email is generated
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId2;
        $adId2 = DataGenerator::generateOne($doBanners);
        $doDataSummaryAdHourly = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->day         = '2007-05-12';
        $doDataSummaryAdHourly->hour        = '12';
        $doDataSummaryAdHourly->ad_id       = $adId2;
        $doDataSummaryAdHourly->impressions = 5000;
        $doDataSummaryAdHourly->clicks      = 0;
        $doDataSummaryAdHourly->conversions = 0;
        DataGenerator::generateOne($doDataSummaryAdHourly);
        $aResult = OA_Email::preparePlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $expectedSubject = "Advertiser report: $clientName";
        $expectedContents  = "Dear $name,\n\n";
        $expectedContents .= "Below you will find the banner statistics for $clientName:\n";
        global $date_format;
        $startDate = $oStartDate->format($date_format);
        $endDate   = $oEndDate->format($date_format);
        $expectedContents .= "This report includes statistics from $startDate up to $endDate.\n\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= "There are no statistics available for this campaign\n\n\n";
        $expectedContents .= "\nCampaign [id$placementId2] 1\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$adId2] 1\n";
        $expectedContents .= " ------------------------------------------------------\n";
        $expectedContents .= " Impressions (Total):           5,000\n";
        $expectedContents .= "  No Impressions were logged during the span of this report\n";
        $expectedContents .= "\n\n";
        $expectedContents .= "Regards,\n   Openads Ltd.";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 4);
        $this->assertEqual($aResult['userEmail'], $email);
        $this->assertEqual($aResult['userName'], $name);
        $this->assertEqual($aResult['subject'], $expectedSubject);
        $this->assertEqual($aResult['contents'], $expectedContents);

        // Add an ad to the second placements, with delivery data in the
        // report range, and ensure the correct email is generated
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId2;
        $adId3 = DataGenerator::generateOne($doBanners);
        $doDataSummaryAdHourly = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->day         = '2007-05-14';
        $doDataSummaryAdHourly->hour        = '12';
        $doDataSummaryAdHourly->ad_id       = $adId3;
        $doDataSummaryAdHourly->impressions = 5000;
        $doDataSummaryAdHourly->clicks      = 0;
        $doDataSummaryAdHourly->conversions = 0;
        DataGenerator::generateOne($doDataSummaryAdHourly);
        $doDataSummaryAdHourly->day         = '2007-05-14';
        $doDataSummaryAdHourly->hour        = '13';
        $doDataSummaryAdHourly->ad_id       = $adId3;
        $doDataSummaryAdHourly->impressions = 5000;
        $doDataSummaryAdHourly->clicks      = 0;
        $doDataSummaryAdHourly->conversions = 0;
        DataGenerator::generateOne($doDataSummaryAdHourly);
        $doDataSummaryAdHourly->day         = '2007-05-15';
        $doDataSummaryAdHourly->hour        = '13';
        $doDataSummaryAdHourly->ad_id       = $adId3;
        $doDataSummaryAdHourly->impressions = 5000;
        $doDataSummaryAdHourly->clicks      = 0;
        $doDataSummaryAdHourly->conversions = 0;
        DataGenerator::generateOne($doDataSummaryAdHourly);
        $aResult = OA_Email::preparePlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $expectedSubject = "Advertiser report: $clientName";
        $expectedContents  = "Dear $name,\n\n";
        $expectedContents .= "Below you will find the banner statistics for $clientName:\n";
        global $date_format;
        $startDate = $oStartDate->format($date_format);
        $endDate   = $oEndDate->format($date_format);
        $expectedContents .= "This report includes statistics from $startDate up to $endDate.\n\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= "There are no statistics available for this campaign\n\n\n";
        $expectedContents .= "\nCampaign [id$placementId2] 1\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$adId2] 1\n";
        $expectedContents .= " ------------------------------------------------------\n";
        $expectedContents .= " Impressions (Total):           5,000\n";
        $expectedContents .= "  No Impressions were logged during the span of this report\n";
        $expectedContents .= "\n";
        $expectedContents .= " Banner  [id$adId3] 1\n";
        $expectedContents .= " ------------------------------------------------------\n";
        $expectedContents .= " Impressions (Total):          15,000\n";
        $expectedContents .= "          15-05-2007:           5,000\n";
        $expectedContents .= "          14-05-2007:          10,000\n";
        $expectedContents .= "   Total this period:          15,000\n";
        $expectedContents .= "\n\n";
        $expectedContents .= "Regards,\n   Openads Ltd.";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 4);
        $this->assertEqual($aResult['userEmail'], $email);
        $this->assertEqual($aResult['userName'], $name);
        $this->assertEqual($aResult['subject'], $expectedSubject);
        $this->assertEqual($aResult['contents'], $expectedContents);

        DataGenerator::cleanUp();
        TestEnv::restoreConfig();

        // Test with no start date
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = $clientName;
        $doClients->email      = $email;
        $doClients->contact    = $name;
        $doClients->report     = 't';
        $advertiserId = DataGenerator::generateOne($doClients);
        $doPlacements = OA_Dal::factoryDO('campaigns');
        $doPlacements->clientid = $advertiserId;
        $placementId1 = DataGenerator::generateOne($doPlacements);
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId1;
        $adId1= DataGenerator::generateOne($doBanners);
        $doDataSummaryAdHourly = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->day         = '2007-05-14';
        $doDataSummaryAdHourly->hour        = '12';
        $doDataSummaryAdHourly->ad_id       = $adId1;
        $doDataSummaryAdHourly->impressions = 5000;
        $doDataSummaryAdHourly->clicks      = 0;
        $doDataSummaryAdHourly->conversions = 0;
        DataGenerator::generateOne($doDataSummaryAdHourly);
        $doDataSummaryAdHourly->day         = '2007-05-14';
        $doDataSummaryAdHourly->hour        = '13';
        $doDataSummaryAdHourly->ad_id       = $adId1;
        $doDataSummaryAdHourly->impressions = 5000;
        $doDataSummaryAdHourly->clicks      = 0;
        $doDataSummaryAdHourly->conversions = 0;
        DataGenerator::generateOne($doDataSummaryAdHourly);
        $doDataSummaryAdHourly->day         = '2007-05-15';
        $doDataSummaryAdHourly->hour        = '13';
        $doDataSummaryAdHourly->ad_id       = $adId1;
        $doDataSummaryAdHourly->impressions = 5000;
        $doDataSummaryAdHourly->clicks      = 0;
        $doDataSummaryAdHourly->conversions = 0;
        DataGenerator::generateOne($doDataSummaryAdHourly);
        $aResult = OA_Email::preparePlacementDeliveryEmail($advertiserId, null, $oEndDate);
        $expectedSubject = "Advertiser report: $clientName";
        $expectedContents  = "Dear $name,\n\n";
        $expectedContents .= "Below you will find the banner statistics for $clientName:\n";
        global $date_format;
        $startDate = $oStartDate->format($date_format);
        $endDate   = $oEndDate->format($date_format);
        $expectedContents .= "This report includes all statistics up to $endDate.\n\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$adId1] 1\n";
        $expectedContents .= " ------------------------------------------------------\n";
        $expectedContents .= " Impressions (Total):          15,000\n";
        $expectedContents .= "          15-05-2007:           5,000\n";
        $expectedContents .= "          14-05-2007:          10,000\n";
        $expectedContents .= "   Total this period:          15,000\n";
        $expectedContents .= "\n\n";
        $expectedContents .= "Regards,\n   Openads Ltd.";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 4);
        $this->assertEqual($aResult['userEmail'], $email);
        $this->assertEqual($aResult['userName'], $name);
        $this->assertEqual($aResult['subject'], $expectedSubject);
        $this->assertEqual($aResult['contents'], $expectedContents);

        DataGenerator::cleanUp();
        TestEnv::restoreConfig();
    }

    /**
     * Tests that an e-mail reporting on impending placement expiration
     * is able to be generated correctly.
     */
    function testPrepareplacementImpendingExpiryEmail()
    {
        // Prepare valid test data
        $dateReason   = 'date';
        $dateValue    = '17-05-2007';
        $impReason    = 'impressions';
        $impValue     = 100;

        $adminName    = 'Openads Ltd.';
        $adminMail    = 'send@example.com';
        $agencyName   = 'Agency Ltd.';
        $agencyMail   = 'send@agency.com';
        $clientName   = 'Foo Client';

        // Prepare the admin email address and name, and set
        // all users to receive warnings
        $oPreference = OA_Dal::factoryDO('preference');
        $oPreference->agencyid       = 0;
        $oPreference->admin_fullname = $adminName;
        $oPreference->admin_email    = $adminMail;
        $oPreference->warn_admin     = 't';
        $oPreference->warn_agency    = 't';
        $oPreference->warn_client    = 't';
        DataGenerator::generateOne($oPreference);

        // Prepare an agency email address and name, and set
        // all users to receive warnings
        $oPreference = OA_Dal::factoryDO('preference');
        $oPreference->agencyid       = 1;
        $oPreference->admin_fullname = $agencyName;
        $oPreference->admin_email    = $agencyMail;
        $oPreference->warn_admin     = 't';
        $oPreference->warn_agency    = 't';
        $oPreference->warn_client    = 't';
        DataGenerator::generateOne($oPreference);

        // Test with no advertiser in the database and ensure false is returned
        $result = OA_Email::prepareplacementImpendingExpiryEmail(1, 1, $dateReason, $dateValue);
        $this->assertFalse($result);
        $result = OA_Email::prepareplacementImpendingExpiryEmail(1, 1, $impReason, $impValue);
        $this->assertFalse($result);

        // Generate an advertiser owned by the agency with no email adddress,
        // but no placements, and ensure false is returned
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid   = 1;
        $doClients->clientname = $clientName;
        $doClients->email      = '';
        $advertiserId1 = DataGenerator::generateOne($doClients);
        $result = OA_Email::prepareplacementImpendingExpiryEmail($advertiserId1, 1, $dateReason, $dateValue);
        $this->assertFalse($result);
        $result = OA_Email::prepareplacementImpendingExpiryEmail($advertiserId1, 1, $impReason, $impValue);
        $this->assertFalse($result);

        // Generate a placement owned by the advertiser, and test with a
        // different placement ID, and ensure false is returned
        $doPlacements = OA_Dal::factoryDO('campaigns');
        $doPlacements->clientid = $advertiserId1;
        $placementId1 = DataGenerator::generateOne($doPlacements);
        $result = OA_Email::prepareplacementImpendingExpiryEmail($advertiserId1, $placementId1 + 1, $dateReason, $dateValue);
        $this->assertFalse($result);
        $result = OA_Email::prepareplacementImpendingExpiryEmail($advertiserId1, $placementId1 + 1, $impReason, $impValue);
        $this->assertFalse($result);

        // Test with the matching advertiser and placement IDs, and
        // ensure the expected email is generated
        $aResult = OA_Email::prepareplacementImpendingExpiryEmail($advertiserId1, $placementId1, $dateReason, $dateValue);

        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $adminName,\n\n\n";
        $expectedContents .= "The campaign belonging to $clientName shown below is due to end on $dateValue.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " There are currently no banners defined\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= "Regards,\n   Openads Ltd.";
        $this->assertTrue(is_array($aResult[0]));
        $this->assertEqual(count($aResult[0]), 4);
        $this->assertEqual($aResult[0]['userEmail'], $adminMail);
        $this->assertEqual($aResult[0]['userName'],  $adminName);
        $this->assertEqual($aResult[0]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[0]['contents'],  $expectedContents);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $agencyName,\n\n\n";
        $expectedContents .= "The campaign belonging to $clientName shown below is due to end on $dateValue.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " There are currently no banners defined\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= "Regards,\n   Openads Ltd.";
        $this->assertTrue(is_array($aResult[1]));
        $this->assertEqual(count($aResult[1]), 4);
        $this->assertEqual($aResult[1]['userEmail'], $agencyMail);
        $this->assertEqual($aResult[1]['userName'],  $agencyName);
        $this->assertEqual($aResult[1]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[1]['contents'],  $expectedContents);

        $aResult = OA_Email::prepareplacementImpendingExpiryEmail($advertiserId1, $placementId1, $impReason, $impValue);

        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $adminName,\n\n\n";
        $expectedContents .= "The campaign belonging to $clientName shown below has less than $impValue impressions remaining.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " There are currently no banners defined\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= "Regards,\n   Openads Ltd.";
        $this->assertTrue(is_array($aResult[0]));
        $this->assertEqual(count($aResult[0]), 4);
        $this->assertEqual($aResult[0]['userEmail'], $adminMail);
        $this->assertEqual($aResult[0]['userName'],  $adminName);
        $this->assertEqual($aResult[0]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[0]['contents'],  $expectedContents);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $agencyName,\n\n\n";
        $expectedContents .= "The campaign belonging to $clientName shown below has less than $impValue impressions remaining.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " There are currently no banners defined\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= "Regards,\n   Openads Ltd.";
        $this->assertTrue(is_array($aResult[1]));
        $this->assertEqual(count($aResult[1]), 4);
        $this->assertEqual($aResult[1]['userEmail'], $agencyMail);
        $this->assertEqual($aResult[1]['userName'],  $agencyName);
        $this->assertEqual($aResult[1]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[1]['contents'],  $expectedContents);

        // Update the advertiser to be owned by admin, set an email
        // address for the advertiser, and add some banners to the
        // campaign and re-test
        $advertiserName = 'Andrew Hill';
        $advertiserMail = 'andrew.hill@openads.org';

        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientid   = $advertiserId1;
        $doClients->agencyid = 0;
        $doClients->contact    = $advertiserName;
        $doClients->email      = $advertiserMail;
        $doClients->update();

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId1;
        $doBanners->url        = '';
        $bannerId1 = DataGenerator::generateOne($doBanners);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId1;
        $doBanners->url        = 'http://www.fornax.net/';
        $bannerId2 = DataGenerator::generateOne($doBanners);

        $aResult = OA_Email::prepareplacementImpendingExpiryEmail($advertiserId1, $placementId1, $dateReason, $dateValue);

        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $adminName,\n\n\n";
        $expectedContents .= "The campaign belonging to $clientName shown below is due to end on $dateValue.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= "Regards,\n   Openads Ltd.";
        $this->assertTrue(is_array($aResult[0]));
        $this->assertEqual(count($aResult[0]), 4);
        $this->assertEqual($aResult[0]['userEmail'], $adminMail);
        $this->assertEqual($aResult[0]['userName'],  $adminName);
        $this->assertEqual($aResult[0]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[0]['contents'],  $expectedContents);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $advertiserName,\n\n\n";
        $expectedContents .= "Your campaign shown below is due to end on $dateValue.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= "Regards,\n   Openads Ltd.";
        $this->assertTrue(is_array($aResult[1]));
        $this->assertEqual(count($aResult[1]), 4);
        $this->assertEqual($aResult[1]['userEmail'], $advertiserMail);
        $this->assertEqual($aResult[1]['userName'],  $advertiserName);
        $this->assertEqual($aResult[1]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[1]['contents'],  $expectedContents);

        $aResult = OA_Email::prepareplacementImpendingExpiryEmail($advertiserId1, $placementId1, $impReason, $impValue);

        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $adminName,\n\n\n";
        $expectedContents .= "The campaign belonging to $clientName shown below has less than $impValue impressions remaining.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= "Regards,\n   Openads Ltd.";
        $this->assertTrue(is_array($aResult[0]));
        $this->assertEqual(count($aResult[0]), 4);
        $this->assertEqual($aResult[0]['userEmail'], $adminMail);
        $this->assertEqual($aResult[0]['userName'],  $adminName);
        $this->assertEqual($aResult[0]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[0]['contents'],  $expectedContents);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $advertiserName,\n\n\n";
        $expectedContents .= "Your campaign shown below has less than $impValue impressions remaining.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= "Regards,\n   Openads Ltd.";
        $this->assertTrue(is_array($aResult[1]));
        $this->assertEqual(count($aResult[1]), 4);
        $this->assertEqual($aResult[1]['userEmail'], $advertiserMail);
        $this->assertEqual($aResult[1]['userName'],  $advertiserName);
        $this->assertEqual($aResult[1]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[1]['contents'],  $expectedContents);

        DataGenerator::cleanUp();
        TestEnv::restoreConfig();
    }

    /**
     * Tests that an e-mail advising a placement has been activated is able to
     * be generated correctly.
     */
    function testPrepareActivatePlacementEmail()
    {
        // Prepare the admin email address and name
        $oPreference = OA_Dal::factoryDO('preference');
        $oPreference->agencyid       = 0;
        $oPreference->admin_fullname = 'Openads Ltd.';
        $oPreference->admin_email    = 'send@example.com';
        DataGenerator::generateOne($oPreference);

        $contactName = 'Andrew Hill';
        $placementName = 'Test Activation Placement';
        $ads[0] = array('First Test Banner', '', 'http://example.com/');
        $ads[1] = array('Second Test Banner', 'Alt. Description', 'http://example.com/');
        $ads[2] = array('', 'Third Test Banner', 'http://example.com/foo/bar.html');
        $ads[3] = array('', '', 'http://example.com/foo.html');
        $email = OA_Email::prepareActivatePlacementEmail($contactName, $placementName, $ads);
        $desiredEmail  = 'Dear Andrew Hill,' . "\n\n";
        $desiredEmail .= 'The following ads have been activated because '. "\n";
        $desiredEmail .= 'the campaign activation date has been reached.' . "\n\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 0] First Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 1] Second Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 2] Third Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo/bar.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 3] Untitled' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= "\nThank you for advertising with us.\n\n";
        $desiredEmail .= "Regards,\n\n";
        $desiredEmail .= 'Openads Ltd.';
        $this->assertEqual($email, $desiredEmail);

        DataGenerator::cleanUp();
    }

    /**
     * Tests that e-mails advising a placement has been deactivated is able to
     * be generated correctly.
     */
    function testSendDeactivatePlacementEmail()
    {
        // Prepare the admin email address and name
        $oPreference = OA_Dal::factoryDO('preference');
        $oPreference->agencyid       = 0;
        $oPreference->admin_fullname = 'Openads Ltd.';
        $oPreference->admin_email    = 'send@example.com';
        DataGenerator::generateOne($oPreference);

        $contactName = 'Andrew Hill';
        $placementName = 'Test Activation Placement';
        $ads[0] = array('First Test Banner', '', 'http://example.com/');
        $ads[1] = array('Second Test Banner', 'Alt. Description', 'http://example.com/');
        $ads[2] = array('', 'Third Test Banner', 'http://example.com/foo/bar.html');
        $ads[3] = array('', '', 'http://example.com/foo.html');
        $email = OA_Email::prepareDeactivatePlacementEmail($contactName, $placementName, 2, $ads);
        $desiredEmail  = 'Dear Andrew Hill,' . "\n\n";
        $desiredEmail .= 'The following ads have been disabled because:' . "\n";
        $desiredEmail .= '  - There are no impressions remaining' . "\n\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 0] First Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 1] Second Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 2] Third Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo/bar.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 3] Untitled' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= "\nIf you would like to continue advertising on our website,\n";
        $desiredEmail .= "please feel free to contact us.\n";
        $desiredEmail .= "We'd be glad to hear from you.\n\n";
        $desiredEmail .= "Regards,\n\n";
        $desiredEmail .= 'Openads Ltd.';
        $this->assertEqual($email, $desiredEmail);
        $email = OA_Email::prepareDeactivatePlacementEmail($contactName, $placementName, 4, $ads);
        $desiredEmail  = 'Dear Andrew Hill,' . "\n\n";
        $desiredEmail .= 'The following ads have been disabled because:' . "\n";
        $desiredEmail .= '  - There are no clicks remaining' . "\n\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 0] First Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 1] Second Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 2] Third Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo/bar.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 3] Untitled' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= "\nIf you would like to continue advertising on our website,\n";
        $desiredEmail .= "please feel free to contact us.\n";
        $desiredEmail .= "We'd be glad to hear from you.\n\n";
        $desiredEmail .= "Regards,\n\n";
        $desiredEmail .= 'Openads Ltd.';
        $this->assertEqual($email, $desiredEmail);
        $email = OA_Email::prepareDeactivatePlacementEmail($contactName, $placementName, 8, $ads);
        $desiredEmail  = 'Dear Andrew Hill,' . "\n\n";
        $desiredEmail .= 'The following ads have been disabled because:' . "\n";
        $desiredEmail .= '  - There are no conversions remaining' . "\n\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 0] First Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 1] Second Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 2] Third Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo/bar.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 3] Untitled' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= "\nIf you would like to continue advertising on our website,\n";
        $desiredEmail .= "please feel free to contact us.\n";
        $desiredEmail .= "We'd be glad to hear from you.\n\n";
        $desiredEmail .= "Regards,\n\n";
        $desiredEmail .= 'Openads Ltd.';
        $this->assertEqual($email, $desiredEmail);
        $email = OA_Email::prepareDeactivatePlacementEmail($contactName, $placementName, 16, $ads);
        $desiredEmail  = 'Dear Andrew Hill,' . "\n\n";
        $desiredEmail .= 'The following ads have been disabled because:' . "\n";
        $desiredEmail .= '  - The campaign deactivation date has been reached' . "\n\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 0] First Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 1] Second Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 2] Third Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo/bar.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 3] Untitled' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= "\nIf you would like to continue advertising on our website,\n";
        $desiredEmail .=  "please feel free to contact us.\n";
        $desiredEmail .= "We'd be glad to hear from you.\n\n";
        $desiredEmail .= "Regards,\n\n";
        $desiredEmail .= 'Openads Ltd.';
        $this->assertEqual($email, $desiredEmail);
        $value = 0 | 2 | 4 | 8 | 16;
        $email = OA_Email::prepareDeactivatePlacementEmail($contactName, $placementName, $value, $ads);
        $desiredEmail  = 'Dear Andrew Hill,' . "\n\n";
        $desiredEmail .= 'The following ads have been disabled because:' . "\n";
        $desiredEmail .= '  - There are no impressions remaining' . "\n";
        $desiredEmail .= '  - There are no clicks remaining' . "\n";
        $desiredEmail .= '  - There are no conversions remaining' . "\n";
        $desiredEmail .= '  - The campaign deactivation date has been reached' . "\n\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 0] First Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 1] Second Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 2] Third Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo/bar.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 3] Untitled' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= "\nIf you would like to continue advertising on our website,\n";
        $desiredEmail .=  "please feel free to contact us.\n";
        $desiredEmail .= "We'd be glad to hear from you.\n\n";
        $desiredEmail .= "Regards,\n\n";
        $desiredEmail .= 'Openads Ltd.';
        $this->assertEqual($email, $desiredEmail);

        DataGenerator::cleanUp();
    }

}

?>