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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Email.php';

/**
 * A class for testing the OA_Email class.
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Test_OA_Email extends UnitTestCase
{

    /**
     * Local storage for retaining the value of $GLOBALS['_MAX']['HTTP']
     * during testing.
     *
     * @var string
     */
    var $http;

    /**
     * The constructor method.
     */
    function Test_OA_Email()
    {
        $this->UnitTestCase();

    }

    function setUp()
    {
        // Store the current value of $GLOBALS['_MAX']['HTTP']
        // and set the required value for testing
        $this->http = $GLOBALS['_MAX']['HTTP'];
        $GLOBALS['_MAX']['HTTP'] = 'http://';
    }

    function tearDown()
    {
        // Restore the original value of $GLOBALS['_MAX']['HTTP']
        $GLOBALS['_MAX']['HTTP'] = $this->http;
    }

    /**
     * Tests that an e-mail reporting on placement delivery is able to be
     * generated correctly.
     *
     * @TODO Re-enable test once the method has been fixed - see comments in method
     *       about issues with language & new user/account properties/preferences.
     *
     */
    function XXXtestPreparePlacementDeliveryEmail()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['webpath']['admin'] = 'example.com';

        $oEmail = new OA_Email();

        // Prepare valid test data
        $advertiserId = 1;
        $oStartDate   = new Date('2007-05-13 23:59:59');
        $oEndDate     = new Date('2007-05-19 00:00:00');
        $email        = 'andrew.hill@openads.org';
        $name         = 'Andrew Hill';
        $clientName   = 'Foo Client';

        // Prepare the admin email address and name
        $oPreference = OA_Dal::factoryDO('preferences');
        $oPreference->agencyid       = 0;
        $oPreference->admin_fullname = 'Andrew Hill';
        $oPreference->company_name   = 'OpenX Limited';
        $oPreference->admin_email    = 'send@example.com';
        DataGenerator::generateOne($oPreference);

        // Test with no advertiser data in the database, and ensure that
        // false is returned
        $result = $oEmail->preparePlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $this->assertFalse($result);

        // Generate an advertiser with reports disabled and test, ensuring
        // that false is returned
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = $clientName;
        $doClients->email      = '';
        $doClients->contact    = '';
        $doClients->report     = 'f';
        $advertiserId = DataGenerator::generateOne($doClients);
        $result = $oEmail->preparePlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $this->assertFalse($result);

        // Generate an advertiser with reports enabled, but no other data,
        // and test, ensuring that false is returned
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = $clientName;
        $doClients->email      = '';
        $doClients->contact    = '';
        $doClients->report     = 't';
        $advertiserId = DataGenerator::generateOne($doClients);
        $result = $oEmail->preparePlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
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
        $result = $oEmail->preparePlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
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
        $aResult = $oEmail->preparePlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $expectedSubject = "Advertiser report: $clientName";
        $expectedContents  = "Dear $name,\n\n";
        $expectedContents .= "Below you will find the banner statistics for $clientName:\n";
        global $date_format;
        $startDate = $oStartDate->format($date_format);
        $endDate   = $oEndDate->format($date_format);
        $expectedContents .= "This report includes statistics from $startDate up to $endDate.\n\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId1\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= "There are no statistics available for this campaign\n\n\n\n";
        $expectedContents .= "Regards,\n   Andrew Hill, Opens Ltd.";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 5);
        $this->assertEqual($aResult['userEmail'], $email);
        $this->assertEqual($aResult['userName'], $name);
        $this->assertEqual($aResult['subject'], $expectedSubject);
        $this->assertEqual($aResult['contents'], $expectedContents);

        // Add another placement with no ads to the above advertiser, and test
        // that the correct report is generated
        $doPlacements = OA_Dal::factoryDO('campaigns');
        $doPlacements->clientid = $advertiserId;
        $placementId2 = DataGenerator::generateOne($doPlacements);
        $aResult = $oEmail->preparePlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $expectedSubject = "Advertiser report: $clientName";
        $expectedContents  = "Dear $name,\n\n";
        $expectedContents .= "Below you will find the banner statistics for $clientName:\n";
        global $date_format;
        $startDate = $oStartDate->format($date_format);
        $endDate   = $oEndDate->format($date_format);
        $expectedContents .= "This report includes statistics from $startDate up to $endDate.\n\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId1\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= "There are no statistics available for this campaign\n\n\n";
        $expectedContents .= "\nCampaign [id$placementId2] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId2\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= "There are no statistics available for this campaign\n\n\n\n";
        $expectedContents .= "Regards,\n   Andrew Hill, OpenX Limited";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 5);
        $this->assertEqual($aResult['userEmail'], $email);
        $this->assertEqual($aResult['userName'], $name);
        $this->assertEqual($aResult['subject'], $expectedSubject);
        $this->assertEqual($aResult['contents'], $expectedContents);

        // Add an ad to the second placements, but with no delivery data, and
        // ensure the correct email is generated (no change to previous!)
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId2;
        $adId1 = DataGenerator::generateOne($doBanners);
        $aResult = $oEmail->preparePlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 5);
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
        $doDataSummaryAdHourly->date_time   = '2007-05-12 12:00:00';
        $doDataSummaryAdHourly->ad_id       = $adId2;
        $doDataSummaryAdHourly->impressions = 5000;
        $doDataSummaryAdHourly->clicks      = 0;
        $doDataSummaryAdHourly->conversions = 0;
        DataGenerator::generateOne($doDataSummaryAdHourly);
        $aResult = $oEmail->preparePlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $expectedSubject = "Advertiser report: $clientName";
        $expectedContents  = "Dear $name,\n\n";
        $expectedContents .= "Below you will find the banner statistics for $clientName:\n";
        global $date_format;
        $startDate = $oStartDate->format($date_format);
        $endDate   = $oEndDate->format($date_format);
        $expectedContents .= "This report includes statistics from $startDate up to $endDate.\n\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId1\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= "There are no statistics available for this campaign\n\n\n";
        $expectedContents .= "\nCampaign [id$placementId2] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId2\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$adId2] 1\n";
        $expectedContents .= " ------------------------------------------------------\n";
        $expectedContents .= " Impressions (Total):           5,000\n";
        $expectedContents .= "  No Impressions were logged during the span of this report\n";
        $expectedContents .= "\n\n";
        $expectedContents .= "Regards,\n   Andrew Hill, OpenX Limited";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 5);
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
        $doDataSummaryAdHourly->date_time   = '2007-05-14 12:00:00';
        $doDataSummaryAdHourly->ad_id       = $adId3;
        $doDataSummaryAdHourly->impressions = 5000;
        $doDataSummaryAdHourly->clicks      = 0;
        $doDataSummaryAdHourly->conversions = 0;
        DataGenerator::generateOne($doDataSummaryAdHourly);
        $doDataSummaryAdHourly->date_time   = '2007-05-14 13:00:00';
        $doDataSummaryAdHourly->ad_id       = $adId3;
        $doDataSummaryAdHourly->impressions = 5000;
        $doDataSummaryAdHourly->clicks      = 0;
        $doDataSummaryAdHourly->conversions = 0;
        DataGenerator::generateOne($doDataSummaryAdHourly);
        $doDataSummaryAdHourly->date_time   = '2007-05-15 13:00:00';
        $doDataSummaryAdHourly->ad_id       = $adId3;
        $doDataSummaryAdHourly->impressions = 5000;
        $doDataSummaryAdHourly->clicks      = 0;
        $doDataSummaryAdHourly->conversions = 0;
        DataGenerator::generateOne($doDataSummaryAdHourly);
        $aResult = $oEmail->preparePlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $expectedSubject = "Advertiser report: $clientName";
        $expectedContents  = "Dear $name,\n\n";
        $expectedContents .= "Below you will find the banner statistics for $clientName:\n";
        global $date_format;
        $startDate = $oStartDate->format($date_format);
        $endDate   = $oEndDate->format($date_format);
        $expectedContents .= "This report includes statistics from $startDate up to $endDate.\n\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId1\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= "There are no statistics available for this campaign\n\n\n";
        $expectedContents .= "\nCampaign [id$placementId2] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId2\n";
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
        $expectedContents .= "Regards,\n   Andrew Hill, OpenX Limited";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 5);
        $this->assertEqual($aResult['userEmail'], $email);
        $this->assertEqual($aResult['userName'], $name);
        $this->assertEqual($aResult['subject'], $expectedSubject);
        $this->assertEqual($aResult['contents'], $expectedContents);

        TestEnv::restoreConfig();
        DataGenerator::cleanUp();

        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['webpath']['admin'] = 'example.com';

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
        $doDataSummaryAdHourly->date_time   = '2007-05-14 12:00:00';
        $doDataSummaryAdHourly->ad_id       = $adId1;
        $doDataSummaryAdHourly->impressions = 5000;
        $doDataSummaryAdHourly->clicks      = 0;
        $doDataSummaryAdHourly->conversions = 0;
        DataGenerator::generateOne($doDataSummaryAdHourly);
        $doDataSummaryAdHourly->date_time   = '2007-05-14 13:00:00';
        $doDataSummaryAdHourly->ad_id       = $adId1;
        $doDataSummaryAdHourly->impressions = 5000;
        $doDataSummaryAdHourly->clicks      = 0;
        $doDataSummaryAdHourly->conversions = 0;
        DataGenerator::generateOne($doDataSummaryAdHourly);
        $doDataSummaryAdHourly->date_time   = '2007-05-15 13:00:00';
        $doDataSummaryAdHourly->ad_id       = $adId1;
        $doDataSummaryAdHourly->impressions = 5000;
        $doDataSummaryAdHourly->clicks      = 0;
        $doDataSummaryAdHourly->conversions = 0;
        DataGenerator::generateOne($doDataSummaryAdHourly);
        $aResult = $oEmail->preparePlacementDeliveryEmail($advertiserId, null, $oEndDate);
        $expectedSubject = "Advertiser report: $clientName";
        $expectedContents  = "Dear $name,\n\n";
        $expectedContents .= "Below you will find the banner statistics for $clientName:\n";
        global $date_format;
        $startDate = $oStartDate->format($date_format);
        $endDate   = $oEndDate->format($date_format);
        $expectedContents .= "This report includes all statistics up to $endDate.\n\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId1\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$adId1] 1\n";
        $expectedContents .= " ------------------------------------------------------\n";
        $expectedContents .= " Impressions (Total):          15,000\n";
        $expectedContents .= "          15-05-2007:           5,000\n";
        $expectedContents .= "          14-05-2007:          10,000\n";
        $expectedContents .= "   Total this period:          15,000\n";
        $expectedContents .= "\n\n";
        $expectedContents .= "Regards,\n   Andrew Hill, OpenX Limited";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 5);
        $this->assertEqual($aResult['userEmail'], $email);
        $this->assertEqual($aResult['userName'], $name);
        $this->assertEqual($aResult['subject'], $expectedSubject);
        $this->assertEqual($aResult['contents'], $expectedContents);

        TestEnv::restoreEnv();
    }

    /**
     * Tests that an e-mail reporting on impending placement expiration
     * is able to be generated correctly.
     *
     * @TODO Re-enable test once the method has been fixed - see comments in method
     *       about issues with language & new user/account properties/preferences.
     *
     */
    function XXXtestPrepareplacementImpendingExpiryEmail()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['webpath']['admin'] = 'example.com';

        $oEmail = new OA_Email();

        // Prepare valid test data
        $dateReason    = 'date';
        $dateValue     = '17-05-2007';
        $impReason     = 'impressions';
        $impValue      = 100;

        $adminContact  = 'Andrew Hill';
        $adminName     = 'OpenX Limited';
        $adminMail     = 'send@example.com';
        $agencyName    = 'Agency Ltd.';
        $agencyContact = 'Mr. Foo Bar Agency';
        $agencyMail    = 'send@agency.com';
        $clientName    = 'Foo Client';

        // Prepare the admin email address and name, and set
        // all users to receive warnings
        $oPreference = OA_Dal::factoryDO('preferences');
        $oPreference->agencyid       = 0;
        $oPreference->admin_fullname = $adminContact;
        $oPreference->admin_email    = $adminMail;
        $oPreference->company_name   = $adminName;
        $oPreference->warn_admin     = 't';
        $oPreference->warn_agency    = 't';
        $oPreference->warn_client    = 't';
        DataGenerator::generateOne($oPreference);

        // Prepare an agency
        $oAgency = OA_Dal::factoryDO('agency');
        $oAgency->name    = $agencyName;
        $oAgency->contact = $agencyContact;
        $oAgency->email   = $agencyMail;
        $agencyId = DataGenerator::generateOne($oAgency);

        // Test with no advertiser in the database and ensure false is returned
        $result = $oEmail->preparePlacementImpendingExpiryEmail(1, 1, $dateReason, $dateValue);
        $this->assertFalse($result);
        $result = $oEmail->preparePlacementImpendingExpiryEmail(1, 1, $impReason, $impValue);
        $this->assertFalse($result);

        // Generate an advertiser owned by the agency with no email adddress,
        // but no placements, and ensure false is returned
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid   = 1;
        $doClients->clientname = $clientName;
        $doClients->email      = '';
        $advertiserId1 = DataGenerator::generateOne($doClients);
        $result = $oEmail->preparePlacementImpendingExpiryEmail($advertiserId1, 1, $dateReason, $dateValue);
        $this->assertFalse($result);
        $result = $oEmail->preparePlacementImpendingExpiryEmail($advertiserId1, 1, $impReason, $impValue);
        $this->assertFalse($result);

        // Generate a placement owned by the advertiser, and test with a
        // different placement ID, and ensure false is returned
        $doPlacements = OA_Dal::factoryDO('campaigns');
        $doPlacements->clientid = $advertiserId1;
        $placementId1 = DataGenerator::generateOne($doPlacements);
        $result = $oEmail->preparePlacementImpendingExpiryEmail($advertiserId1, $placementId1 + 1, $dateReason, $dateValue);
        $this->assertFalse($result);
        $result = $oEmail->preparePlacementImpendingExpiryEmail($advertiserId1, $placementId1 + 1, $impReason, $impValue);
        $this->assertFalse($result);

        // Test with the matching advertiser and placement IDs, and
        // ensure the expected email is generated
        $aResult = $oEmail->preparePlacementImpendingExpiryEmail($advertiserId1, $placementId1, $dateReason, $dateValue);

        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $adminContact,\n\n";
        $expectedContents .= "The campaign belonging to $clientName shown below is due to end on $dateValue.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " There are currently no banners defined\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $adminContact, $adminName";
        $this->assertTrue(is_array($aResult[0]));
        $this->assertEqual(count($aResult[0]), 4);
        $this->assertEqual($aResult[0]['userEmail'], $adminMail);
        $this->assertEqual($aResult[0]['userName'],  $adminContact);
        $this->assertEqual($aResult[0]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[0]['contents'],  $expectedContents);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $agencyContact,\n\n";
        $expectedContents .= "The campaign belonging to $clientName shown below is due to end on $dateValue.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " There are currently no banners defined\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $agencyContact, $agencyName";
        $this->assertTrue(is_array($aResult[1]));
        $this->assertEqual(count($aResult[1]), 4);
        $this->assertEqual($aResult[1]['userEmail'], $agencyMail);
        $this->assertEqual($aResult[1]['userName'],  $agencyContact);
        $this->assertEqual($aResult[1]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[1]['contents'],  $expectedContents);

        $aResult = $oEmail->preparePlacementImpendingExpiryEmail($advertiserId1, $placementId1, $impReason, $impValue);

        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $adminContact,\n\n";
        $expectedContents .= "The campaign belonging to $clientName shown below has less than $impValue impressions remaining.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " There are currently no banners defined\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $adminContact, $adminName";
        $this->assertTrue(is_array($aResult[0]));
        $this->assertEqual(count($aResult[0]), 4);
        $this->assertEqual($aResult[0]['userEmail'], $adminMail);
        $this->assertEqual($aResult[0]['userName'],  $adminContact);
        $this->assertEqual($aResult[0]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[0]['contents'],  $expectedContents);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $agencyContact,\n\n";
        $expectedContents .= "The campaign belonging to $clientName shown below has less than $impValue impressions remaining.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " There are currently no banners defined\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $agencyContact, $agencyName";
        $this->assertTrue(is_array($aResult[1]));
        $this->assertEqual(count($aResult[1]), 4);
        $this->assertEqual($aResult[1]['userEmail'], $agencyMail);
        $this->assertEqual($aResult[1]['userName'],  $agencyContact);
        $this->assertEqual($aResult[1]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[1]['contents'],  $expectedContents);

        // Update the advertiser to be owned by admin, set an email
        // address for the advertiser, and add some banners to the
        // campaign and re-test
        $advertiserName = 'Andrew Hill';
        $advertiserMail = 'andrew.hill@openads.org';

        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientid   = $advertiserId1;
        $doClients->agencyid   = 0;
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

        $aResult = $oEmail->preparePlacementImpendingExpiryEmail($advertiserId1, $placementId1, $dateReason, $dateValue);

        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $adminContact,\n\n";
        $expectedContents .= "The campaign belonging to $clientName shown below is due to end on $dateValue.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $adminContact, $adminName";
        $this->assertTrue(is_array($aResult[0]));
        $this->assertEqual(count($aResult[0]), 4);
        $this->assertEqual($aResult[0]['userEmail'], $adminMail);
        $this->assertEqual($aResult[0]['userName'],  $adminContact);
        $this->assertEqual($aResult[0]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[0]['contents'],  $expectedContents);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $advertiserName,\n\n";
        $expectedContents .= "Your campaign shown below is due to end on $dateValue.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $adminContact, $adminName";
        $this->assertTrue(is_array($aResult[1]));
        $this->assertEqual(count($aResult[1]), 4);
        $this->assertEqual($aResult[1]['userEmail'], $advertiserMail);
        $this->assertEqual($aResult[1]['userName'],  $advertiserName);
        $this->assertEqual($aResult[1]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[1]['contents'],  $expectedContents);

        $aResult = $oEmail->preparePlacementImpendingExpiryEmail($advertiserId1, $placementId1, $impReason, $impValue);

        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $adminContact,\n\n";
        $expectedContents .= "The campaign belonging to $clientName shown below has less than $impValue impressions remaining.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $adminContact, $adminName";
        $this->assertTrue(is_array($aResult[0]));
        $this->assertEqual(count($aResult[0]), 4);
        $this->assertEqual($aResult[0]['userEmail'], $adminMail);
        $this->assertEqual($aResult[0]['userName'],  $adminContact);
        $this->assertEqual($aResult[0]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[0]['contents'],  $expectedContents);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $advertiserName,\n\n";
        $expectedContents .= "Your campaign shown below has less than $impValue impressions remaining.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $adminContact, $adminName";
        $this->assertTrue(is_array($aResult[1]));
        $this->assertEqual(count($aResult[1]), 4);
        $this->assertEqual($aResult[1]['userEmail'], $advertiserMail);
        $this->assertEqual($aResult[1]['userName'],  $advertiserName);
        $this->assertEqual($aResult[1]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[1]['contents'],  $expectedContents);

        // Repeat above tests, but have advertiser owned by agency
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientid   = $advertiserId1;
        $doClients->agencyid   = $agencyId;
        $doClients->contact    = $advertiserName;
        $doClients->email      = $advertiserMail;
        $doClients->update();

        $aResult = $oEmail->preparePlacementImpendingExpiryEmail($advertiserId1, $placementId1, $dateReason, $dateValue);

        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 3);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $adminContact,\n\n";
        $expectedContents .= "The campaign belonging to $clientName shown below is due to end on $dateValue.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $adminContact, $adminName";
        $this->assertTrue(is_array($aResult[0]));
        $this->assertEqual(count($aResult[0]), 4);
        $this->assertEqual($aResult[0]['userEmail'], $adminMail);
        $this->assertEqual($aResult[0]['userName'],  $adminContact);
        $this->assertEqual($aResult[0]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[0]['contents'],  $expectedContents);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $agencyContact,\n\n";
        $expectedContents .= "The campaign belonging to $clientName shown below is due to end on $dateValue.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $agencyContact, $agencyName";
        $this->assertTrue(is_array($aResult[1]));
        $this->assertEqual(count($aResult[1]), 4);
        $this->assertEqual($aResult[1]['userEmail'], $agencyMail);
        $this->assertEqual($aResult[1]['userName'],  $agencyContact);
        $this->assertEqual($aResult[1]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[1]['contents'],  $expectedContents);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $advertiserName,\n\n";
        $expectedContents .= "Your campaign shown below is due to end on $dateValue.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $agencyContact, $agencyName";
        $this->assertTrue(is_array($aResult[2]));
        $this->assertEqual(count($aResult[2]), 4);
        $this->assertEqual($aResult[2]['userEmail'], $advertiserMail);
        $this->assertEqual($aResult[2]['userName'],  $advertiserName);
        $this->assertEqual($aResult[2]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[2]['contents'],  $expectedContents);

        $aResult = $oEmail->preparePlacementImpendingExpiryEmail($advertiserId1, $placementId1, $impReason, $impValue);

        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 3);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $adminContact,\n\n";
        $expectedContents .= "The campaign belonging to $clientName shown below has less than $impValue impressions remaining.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $adminContact, $adminName";
        $this->assertTrue(is_array($aResult[0]));
        $this->assertEqual(count($aResult[0]), 4);
        $this->assertEqual($aResult[0]['userEmail'], $adminMail);
        $this->assertEqual($aResult[0]['userName'],  $adminContact);
        $this->assertEqual($aResult[0]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[0]['contents'],  $expectedContents);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $agencyContact,\n\n";
        $expectedContents .= "The campaign belonging to $clientName shown below has less than $impValue impressions remaining.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $agencyContact, $agencyName";
        $this->assertTrue(is_array($aResult[1]));
        $this->assertEqual(count($aResult[1]), 4);
        $this->assertEqual($aResult[1]['userEmail'], $agencyMail);
        $this->assertEqual($aResult[1]['userName'],  $agencyContact);
        $this->assertEqual($aResult[1]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[1]['contents'],  $expectedContents);

        $expectedSubject = "Impending campaign expiration: $clientName";
        $expectedContents  = "Dear $advertiserName,\n\n";
        $expectedContents .= "Your campaign shown below has less than $impValue impressions remaining.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId1\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $agencyContact, $agencyName";
        $this->assertTrue(is_array($aResult[2]));
        $this->assertEqual(count($aResult[2]), 4);
        $this->assertEqual($aResult[2]['userEmail'], $advertiserMail);
        $this->assertEqual($aResult[2]['userName'],  $advertiserName);
        $this->assertEqual($aResult[2]['subject'],   $expectedSubject);
        $this->assertEqual($aResult[2]['contents'],  $expectedContents);

        TestEnv::restoreEnv();
    }

    /**
     * Tests that an e-mail advising a placement has been activated is able to
     * be generated correctly.
     *
     * @TODO Re-enable test once the method has been fixed - see comments in method
     *       about issues with language & new user/account properties/preferences.
     *
     */
    function XXXtestPrepareActivatePlacementEmail()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['webpath']['admin'] = 'example.com';

        $oEmail = new OA_Email();

        unset($GLOBALS['_MAX']['PREF']);

        $email        = 'andrew.hill@openads.org';
        $name         = 'Andrew Hill';
        $clientName   = 'Foo Client';

        // Prepare the admin email address and name
        $oPreference = OA_Dal::factoryDO('preferences');
        $oPreference->agencyid       = 0;
        $oPreference->admin_fullname = 'Andrew Hill';
        $oPreference->company_name   = 'OpenX Limited';
        $oPreference->admin_email    = 'send@example.com';
        DataGenerator::generateOne($oPreference);

        // Prepare an advertiser
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = $clientName;
        $doClients->email      = $email;
        $doClients->contact    = $name;
        $doClients->report     = 't';
        $advertiserId = DataGenerator::generateOne($doClients);

        // Prepare a placement
        $doPlacements = OA_Dal::factoryDO('campaigns');
        $doPlacements->clientid = $advertiserId;
        $placementId = DataGenerator::generateOne($doPlacements);

        // Prepare banners
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId;
        $doBanners->url        = '';
        $bannerId1 = DataGenerator::generateOne($doBanners);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId;
        $doBanners->url        = 'http://www.fornax.net/';
        $bannerId2 = DataGenerator::generateOne($doBanners);

        $aResult = $oEmail->preparePlacementActivatedDeactivatedEmail($placementId);
        $expectedSubject = 'Campiagn activated: Foo Client';
        $expectedContents  = "Dear $name,\n\n";
        $expectedContents .= 'Your campaign shown below has been activated because'. "\n";
        $expectedContents .= 'the campaign activation date has been reached.' . "\n";
        $expectedContents .= "\nCampaign [id$placementId] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner  [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "\n";
        $expectedContents .= "Regards,\n   Andrew Hill, OpenX Limited";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 4);
        $this->assertEqual($aResult['userEmail'], $email);
        $this->assertEqual($aResult['userName'],  $name);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        TestEnv::restoreEnv();
    }

    /**
     * Tests that e-mails advising a placement has been deactivated is able to
     * be generated correctly.
     *
     * @TODO Re-enable test once the method has been fixed - see comments in method
     *       about issues with language & new user/account properties/preferences.
     *
     */
    function XXXtestSendDeactivatePlacementEmail()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['webpath']['admin'] = 'example.com';

        $oEmail = new OA_Email();

        unset($GLOBALS['_MAX']['PREF']);

        $email        = 'andrew.hill@openads.org';
        $name         = 'Andrew Hill';
        $clientName   = 'Foo Client';

        // Prepare the admin email address and name
        $oPreference = OA_Dal::factoryDO('preferences');
        $oPreference->agencyid       = 0;
        $oPreference->admin_fullname = 'Andrew Hill';
        $oPreference->company_name   = 'OpenX Limited';
        $oPreference->admin_email    = 'send@example.com';
        DataGenerator::generateOne($oPreference);

        // Prepare an advertiser
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = $clientName;
        $doClients->email      = $email;
        $doClients->contact    = $name;
        $doClients->report     = 't';
        $advertiserId = DataGenerator::generateOne($doClients);

        // Prepare a placement
        $doPlacements = OA_Dal::factoryDO('campaigns');
        $doPlacements->clientid = $advertiserId;
        $placementId = DataGenerator::generateOne($doPlacements);

        // Prepare banners
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId;
        $doBanners->url        = '';
        $bannerId1 = DataGenerator::generateOne($doBanners);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId;
        $doBanners->url        = 'http://www.fornax.net/';
        $bannerId2 = DataGenerator::generateOne($doBanners);

        $aResult = $oEmail->preparePlacementActivatedDeactivatedEmail($placementId, OA_PLACEMENT_DISABLED_IMPRESSIONS);
        $expectedSubject = 'Campaign deactivated: Foo Client';
        $expectedContents  = "Dear $name,\n\n";
        $expectedContents .= 'Your campaign shown below has been deactivated because:'. "\n";
        $expectedContents .= '  - there are no Impressions remaining.' . "\n";
        $expectedContents .= "\nCampaign [id$placementId] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner  [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "\n";
        $expectedContents .= "Regards,\n   Andrew Hill, OpenX Limited";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 4);
        $this->assertEqual($aResult['userEmail'], $email);
        $this->assertEqual($aResult['userName'],  $name);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        $aResult = $oEmail->preparePlacementActivatedDeactivatedEmail($placementId, OA_PLACEMENT_DISABLED_CLICKS);
        $expectedSubject = 'Campaign deactivated: Foo Client';
        $expectedContents  = "Dear $name,\n\n";
        $expectedContents .= 'Your campaign shown below has been deactivated because:'. "\n";
        $expectedContents .= '  - there are no Clicks remaining.' . "\n";
        $expectedContents .= "\nCampaign [id$placementId] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner  [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "\n";
        $expectedContents .= "Regards,\n   Andrew Hill, OpenX Limited";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 4);
        $this->assertEqual($aResult['userEmail'], $email);
        $this->assertEqual($aResult['userName'],  $name);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        $aResult = $oEmail->preparePlacementActivatedDeactivatedEmail($placementId, OA_PLACEMENT_DISABLED_CONVERSIONS);
        $expectedSubject = 'Campaign deactivated: Foo Client';
        $expectedContents  = "Dear $name,\n\n";
        $expectedContents .= 'Your campaign shown below has been deactivated because:'. "\n";
        $expectedContents .= '  - there are no Sales remaining.' . "\n";
        $expectedContents .= "\nCampaign [id$placementId] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner  [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "\n";
        $expectedContents .= "Regards,\n   Andrew Hill, OpenX Limited";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 4);
        $this->assertEqual($aResult['userEmail'], $email);
        $this->assertEqual($aResult['userName'],  $name);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        $aResult = $oEmail->preparePlacementActivatedDeactivatedEmail($placementId, OA_PLACEMENT_DISABLED_DATE);
        $expectedSubject = 'Campaign deactivated: Foo Client';
        $expectedContents  = "Dear $name,\n\n";
        $expectedContents .= 'Your campaign shown below has been deactivated because:'. "\n";
        $expectedContents .= '  - the expiration date has been reached.' . "\n";
        $expectedContents .= "\nCampaign [id$placementId] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner  [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "\n";
        $expectedContents .= "Regards,\n   Andrew Hill, OpenX Limited";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 4);
        $this->assertEqual($aResult['userEmail'], $email);
        $this->assertEqual($aResult['userName'],  $name);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        $reason = 0 | OA_PLACEMENT_DISABLED_IMPRESSIONS | OA_PLACEMENT_DISABLED_CLICKS | OA_PLACEMENT_DISABLED_DATE;
        $aResult = $oEmail->preparePlacementActivatedDeactivatedEmail($placementId, $reason);
        $expectedSubject = 'Campaign deactivated: Foo Client';
        $expectedContents  = "Dear $name,\n\n";
        $expectedContents .= 'Your campaign shown below has been deactivated because:'. "\n";
        $expectedContents .= '  - there are no Impressions remaining' . "\n";
        $expectedContents .= '  - there are no Clicks remaining' . "\n";
        $expectedContents .= '  - the expiration date has been reached.' . "\n";
        $expectedContents .= "\nCampaign [id$placementId] 1\n";
        $expectedContents .= "http://example.com/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner  [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "\n";
        $expectedContents .= "Regards,\n   Andrew Hill, OpenX Limited";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 4);
        $this->assertEqual($aResult['userEmail'], $email);
        $this->assertEqual($aResult['userName'],  $name);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        DataGenerator::cleanUp();
    }

}

?>