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
require_once MAX_PATH . '/lib/OA/Admin/UI/UserAccess.php';

/**
 * A class for testing the OA_Email class.
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
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
     */
    function testPreparePlacementDeliveryEmail()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['webpath']['admin'] = 'example.com';
        $aConf['email']['fromAddress'] = 'send@example.com';
        $aConf['email']['fromName'] = 'Andrew Hill';
        $aConf['email']['fromCompany'] = 'OpenX Limited';

        $mockName = uniqid('PartialMockOA_Email_');
        Mock::generatePartial(
            'OA_Email',
            $mockName,
            array('sendMail')
        );

        $oEmail = new $mockName();
        $oEmail->setReturnValue('sendMail', true);

        // Prepare valid test data
        $advertiserId = 1;
        $oStartDate   = new Date('2007-05-13 23:59:59');
        $oEndDate     = new Date('2007-05-19 00:00:00');
        $email        = 'andrew.hill@openx.org';
        $user_name    = 'Andrew Hill';
        $clientName   = 'Foo Client';

        // Setup a User array, but with no data
        $aUser = array('username', 'contact_name', 'email_address');

        // Test with no advertiser data in the database, and ensure that
        // false is returned
        $result = $oEmail->preparePlacementDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate);
        $this->assertFalse($result);

        // Generate an advertiser with reports disabled and test, ensuring
        // that false is returned
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = $clientName;
        $doClients->email      = '';
        $doClients->contact    = '';
        $doClients->report     = 'f';
        $advertiserId = DataGenerator::generateOne($doClients);
        $result = $oEmail->preparePlacementDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate);
        $this->assertFalse($result);

        // Generate an advertiser with reports enabled, but no other data,
        // and test, ensuring that false is returned
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = $clientName;
        $doClients->email      = '';
        $doClients->contact    = '';
        $doClients->report     = 't';
        $advertiserId = DataGenerator::generateOne($doClients);
        $result = $oEmail->preparePlacementDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate);
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
        $result = $oEmail->preparePlacementDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate);
        $this->assertFalse($result);

        // Generate an advertiser with reports enabled & an email address,
        // and a sigle placement, but no ads, ensuring that the correct report
        // is generated
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = $clientName;
        $doClients->email      = $email;
        $doClients->contact    = $user_name;
        $doClients->report     = 't';
        $advertiserId = DataGenerator::generateOne($doClients);

        // Create a user to link to this account
        $doUser = OA_Dal::factoryDO('users');
        $doUser->contact_name = $user_name;
        $doUser->email_address = $email;
        $doUser->language = 'en';
        $userId = DataGenerator::generateOne($doUser);
        $aUser = $doUser->toArray();

        // Link the user to the account
        $oUserAccess = new OA_Admin_UI_UserAccess();
        $oUserAccess->linkUserToAccount($userId, $advertiserId, array(), array());

        $doPlacements = OA_Dal::factoryDO('campaigns');
        $doPlacements->clientid = $advertiserId;
        $doPlacements->status = '0';
        $placementId1 = DataGenerator::generateOne($doPlacements);

        Language_Default::load($doUser->language);
        $aResult = $oEmail->preparePlacementDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate);

        $expectedSubject = "Advertiser report: $clientName";
        $expectedContents  = "Dear $user_name,\n\n";
        $expectedContents .= "Below you will find the banner statistics for $clientName:\n";
        global $date_format;
        $startDate = $oStartDate->format($date_format);
        $endDate   = $oEndDate->format($date_format);
        $expectedContents .= "This report includes statistics from $startDate up to $endDate.\n\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId1\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= "There are no statistics available for this campaign\n\n\n\n";
        $expectedContents .= "Regards,\n   Andrew Hill, OpenX Limited";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 3);
        $this->assertEqual($aResult['subject'], $expectedSubject);
        $this->assertEqual($aResult['contents'], $expectedContents);

        // Add another placement with no ads to the above advertiser, and test
        // that the correct report is generated
        $doPlacements = OA_Dal::factoryDO('campaigns');
        $doPlacements->clientid = $advertiserId;
        $placementId2 = DataGenerator::generateOne($doPlacements);
        $aResult = $oEmail->preparePlacementDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate);
        $expectedSubject = "Advertiser report: $clientName";
        $expectedContents  = "Dear $user_name,\n\n";
        $expectedContents .= "Below you will find the banner statistics for $clientName:\n";
        global $date_format;
        $startDate = $oStartDate->format($date_format);
        $endDate   = $oEndDate->format($date_format);
        $expectedContents .= "This report includes statistics from $startDate up to $endDate.\n\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId1\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= "There are no statistics available for this campaign\n\n\n";
        $expectedContents .= "\nCampaign [id$placementId2] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId2\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= "There are no statistics available for this campaign\n\n\n\n";
        $expectedContents .= "Regards,\n   Andrew Hill, OpenX Limited";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 3);
        $this->assertEqual($aResult['subject'], $expectedSubject);
        $this->assertEqual($aResult['contents'], $expectedContents);

        // Add an ad to the second placements, but with no delivery data, and
        // ensure the correct email is generated (no change to previous!)
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId2;
        $adId1 = DataGenerator::generateOne($doBanners);
        $aResult = $oEmail->preparePlacementDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 3);
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
        $aResult = $oEmail->preparePlacementDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate);
        $expectedSubject = "Advertiser report: $clientName";
        $expectedContents  = "Dear $user_name,\n\n";
        $expectedContents .= "Below you will find the banner statistics for $clientName:\n";
        global $date_format;
        $startDate = $oStartDate->format($date_format);
        $endDate   = $oEndDate->format($date_format);
        $expectedContents .= "This report includes statistics from $startDate up to $endDate.\n\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId1\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= "There are no statistics available for this campaign\n\n\n";
        $expectedContents .= "\nCampaign [id$placementId2] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId2\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$adId2] 1\n";
        $expectedContents .= " ------------------------------------------------------\n";
        $expectedContents .= " Impressions (Total):           5,000\n";
        $expectedContents .= "  No Impressions were logged during the span of this report\n";
        $expectedContents .= "\n\n";
        $expectedContents .= "Regards,\n   Andrew Hill, OpenX Limited";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 3);
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
        $aResult = $oEmail->preparePlacementDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate);
        $expectedSubject = "Advertiser report: $clientName";
        $expectedContents  = "Dear $user_name,\n\n";
        $expectedContents .= "Below you will find the banner statistics for $clientName:\n";
        global $date_format;
        $startDate = $oStartDate->format($date_format);
        $endDate   = $oEndDate->format($date_format);
        $expectedContents .= "This report includes statistics from $startDate up to $endDate.\n\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId1\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= "There are no statistics available for this campaign\n\n\n";
        $expectedContents .= "\nCampaign [id$placementId2] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId2\n";
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
        $this->assertEqual(count($aResult), 3);
        $this->assertEqual($aResult['subject'], $expectedSubject);
        $this->assertEqual($aResult['contents'], $expectedContents);

//        TestEnv::restoreConfig();
        DataGenerator::cleanUp();

//        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['webpath']['admin'] = 'example.com';
        $aConf['email']['fromAddress'] = 'send@example.com';
        $aConf['email']['fromName'] = 'Andrew Hill';
        $aConf['email']['fromCompany'] = 'OpenX Limited';

        // Test with no start date
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = $clientName;
        $doClients->email      = $email;
        $doClients->contact    = $user_name;
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
        $aResult = $oEmail->preparePlacementDeliveryEmail($aUser, $advertiserId, null, $oEndDate);
        $expectedSubject = "Advertiser report: $clientName";
        $expectedContents  = "Dear $user_name,\n\n";
        $expectedContents .= "Below you will find the banner statistics for $clientName:\n";
        global $date_format;
        $startDate = $oStartDate->format($date_format);
        $endDate   = $oEndDate->format($date_format);
        $expectedContents .= "This report includes all statistics up to $endDate.\n\n";
        $expectedContents .= "\nCampaign [id$placementId1] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/campaign-edit.php?clientid=$advertiserId&campaignid=$placementId1\n";
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
        $this->assertEqual(count($aResult), 3);
        $this->assertEqual($aResult['subject'], $expectedSubject);
        $this->assertEqual($aResult['contents'], $expectedContents);
        DataGenerator::cleanUp(array('accounts'));
//        TestEnv::restoreEnv();
    }

    function testSendPlacementDeliveryEmail()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['webpath']['admin'] = 'example.com';
        $aConf['email']['fromAddress'] = 'send@example.com';
        $aConf['email']['fromName'] = 'Andrew Hill';
        $aConf['email']['fromCompany'] = 'OpenX Limited';

        $mockName = uniqid('PartialMockOA_Email_');
        Mock::generatePartial(
            'OA_Email',
            $mockName,
            array('sendMail')
        );

        $oEmail = new $mockName();
        $oEmail->setReturnValue('sendMail', true);
        $oEmail->expectCallCount('sendMail', 3);

        // Prepare valid test data
        $oStartDate   = new Date('2007-05-13 23:59:59');
        $oEndDate     = new Date('2007-05-19 00:00:00');
        $email        = 'andrew.hill@openx.org';
        $name         = 'Andrew Hill';
        $clientName   = 'Foo Client';

        // Test with no advertiser data in the database, and ensure that
        // false is returned
        $result = $oEmail->sendPlacementDeliveryEmail(1, $oStartDate, $oEndDate);
        $this->assertFalse($result);

        // Create a user to link to this account (but don't link it yet)
        $doUser = OA_Dal::factoryDO('users');
        $doUser->contact_name = $clientName;
        $doUser->email_address = $email;
        $doUser->username = $clientName;
        $doUser->language = 'en';
        $userId = DataGenerator::generateOne($doUser);

        // Generate an advertiser with reports disabled and test, ensuring
        // that false is returned
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = $clientName;
        $doClients->email      = '';
        $doClients->contact    = '';
        $doClients->report     = 'f';
        $advertiserId = DataGenerator::generateOne($doClients);
        $result = $oEmail->sendPlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $this->assertFalse($result);

        $doClients = OA_Dal::factoryDO('clients');
        $doClients->get('clientid', $advertiserId);

        // Generate an advertiser with reports enabled, but no other data,
        // and test, ensuring that false is returned
        $doClients->report     = 't';
        $doClients->update();
        $result = $oEmail->sendPlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $this->assertFalse($result);

        $doPlacements = OA_Dal::factoryDO('campaigns');
        $doPlacements->clientid = $advertiserId;
        $placementId = DataGenerator::generateOne($doPlacements);

        $result = $oEmail->sendPlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $this->assertFalse($result);

        // Link the user
        $oUserAccess = new OA_Admin_UI_UserAccess();
        $oUserAccess->linkUserToAccount($userId, $advertiserId, array(), array());

        // With no stats, no email should be sent
        $result = $oEmail->sendPlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $this->assertEqual($result, 0);

        // Create a banner
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId;
        $nammerId = DataGenerator::generateOne($doBanners);

        // With no stats, no email should be sent
        $result = $oEmail->sendPlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $this->assertEqual($result, 0);

        // Load up some stats
        $doDataSummaryAdHourly = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->date_time   = '2007-05-14 12:00:00';
        $doDataSummaryAdHourly->ad_id       = $bannerId;
        $doDataSummaryAdHourly->impressions = 5000;
        $doDataSummaryAdHourly->clicks      = 0;
        $doDataSummaryAdHourly->conversions = 0;
        DataGenerator::generateOne($doDataSummaryAdHourly);

        // With some stats and a linked user, one email should be sent
        $result = $oEmail->sendPlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $this->assertEqual($result, 1);

        // Link another user to this account and ensure that two email are sent (may as well use a different language
        $doUser = OA_Dal::factoryDO('users');
        $doUser->contact_name = 'german_' . $clientName;
        $doUser->email_address = 'german_' . $email;
        $doUser->username = 'german_' . $clientName;
        $doUser->language = 'de';
        $userId2 = DataGenerator::generateOne($doUser);

        // Link the user and ensure that 2 emails are sent
        $oUserAccess = new OA_Admin_UI_UserAccess();
        $oUserAccess->linkUserToAccount($userId2, $advertiserId, array(), array());

        $result = $oEmail->sendPlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate);
        $this->assertEqual($result, 2);

//        TestEnv::restoreEnv();
        DataGenerator::cleanUp();
    }

    /**
     * Tests that an e-mail reporting on impending placement expiration
     * is able to be generated correctly.
     */
    function testSendAndPrepareplacementImpendingExpiryEmail()
    {
        $adminContact  = 'Andrew Hill';
        $adminName     = 'OpenX Limited';
        $adminMail     = 'send@example.com';
        $adminCompany  = 'Admin company name';

        $adminAccountId= 100;
        $agencyName    = 'Agency Ltd.';
        $agencyContact = 'Mr. Foo Bar Agency';
        $agencyMail    = 'send@agency.com';

        $advertiserName    = 'Foo Client';
        $advertiserMail    = 'advertiser@example.com';
        $advertiserUsername= 'advertiserusername';

        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['webpath']['admin'] = 'example.com';
        $aConf['email']['fromAddress']  = $adminMail;
        $aConf['email']['fromName']     = $adminName;
        $aConf['email']['fromCompany']  = $adminCompany;

        $mockName = uniqid('PartialMockOA_Email_');
        Mock::generatePartial(
            'OA_Email',
            $mockName,
            array('sendMail')
        );

        $oEmail = new $mockName();
        $oEmail->setReturnValue('sendMail', true);

        // Prepare valid test data
        $dateReason    = 'date';
        $dateValue     = '2007-05-15';
        $impReason     = 'impressions';
        $impValue      = 100;

        // The tests below assume that the number of days before a campaign expires when the
        $oCampaignDate = new Date($dateValue);
        $oTwoDaysPriorDate = new Date();
        $oTwoDaysPriorDate->copy($oCampaignDate);
        $oTwoDaysPriorDate->subtractSeconds((2*24*60*60)-10);

        $oNowDate = new Date($dateValue);

        // Prepare an admin user
         // Create the admin account
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_name = 'Administrator Account';
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $adminAccountId = DataGenerator::generateOne($doAccounts);

        // Setup the admin account id
        $doAppVar = OA_Dal::factoryDO('application_variable');
        $doAppVar->name='admin_account_id';
        $doAppVar->value=$adminAccountId;

        // Create a user
        $doAdminUser = OA_Dal::factoryDO('users');
        $doAdminUser->contact_name = $adminContact;
        $doAdminUser->email_address = $adminMail;
        $doAdminUser->username = $adminName;
        $doAdminUser->password = md5('password');
        $doAdminUser->language = 'en';
        $doAdminUser->default_account_id = $adminAccountId;
        $adminUserId = DataGenerator::generateOne($doAdminUser);
        $doAdminUser = OA_Dal::staticGetDO('users', $adminUserId);
        $aAdminUser = $doAdminUser->toArray();

        // Create admin account-user association
        $doAUA = OA_Dal::factoryDO('account_user_assoc');
        $doAUA->account_id = $adminAccountId;
        $doAUA->user_id = $adminUserId;
        $doAUA->insert();

        // Prepare an agency
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name    = $agencyName;
        $doAgency->contact = $agencyContact;
        $doAgency->email   = $agencyMail;
        $agencyId = DataGenerator::generateOne($doAgency);
        $doAgency = OA_Dal::staticGetDO('agency', $agencyId); //get('agencyid', $agencyId);
        $agencyAccountId = $doAgency->account_id;

        // Prepare an agency user
        $doUser = OA_Dal::factoryDO('users');
        $doUser->contact_name = $agencyContact;
        $doUser->email_address = $agencyMail;
        $doUser->username = $agencyName;
        $doUser->language = 'en';
        $agencyUserId = DataGenerator::generateOne($doUser);
        $doAgencyUser = OA_Dal::staticGetDO('users', $agencyUserId);
        $aAgencyUser = $doAgencyUser->toArray();

        $oUserAccess = new OA_Admin_UI_UserAccess();

        // Agency user
        $oUserAccess->linkUserToAccount($agencyUserId, $doAgency->account_id, array(), array());

        // Generate an advertiser owned by the agency with no email adddress,
        // but no placements, and ensure false is returned
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid   = $agencyId;
        $doClients->clientname = $advertiserName;
        $doClients->email      = '';
        $advertiserId1 = DataGenerator::generateOne($doClients);
        $doClients = OA_Dal::staticGetDO('clients', 'clientid', $advertiserId1); // ->get('clientid', $advertiserId1);
        $advertiserAccountId = $doClients->account_id;

        // Create an advertiser user
        $doUser = OA_Dal::factoryDO('users');
        $doUser->contact_name = $advertiserName;
        $doUser->email_address = $advertiserMail;
        $doUser->username = $advertiserUsername;
        $doUser->language = 'en';
        $userId = DataGenerator::generateOne($doUser);
        $doAdvertiserUser = OA_Dal::staticGetDO('users', $userId);
        $aAdvertiserUser = $doAdvertiserUser->toArray();

        // Link the advertiser user
        $oUserAccess->linkUserToAccount($userId, $doClients->account_id, array(), array());

        // Create a campaign
        $doPlacements = OA_Dal::factoryDO('campaigns');
        $doPlacements->clientid = $advertiserId1;
        $doPlacements->views = 50;
        $doPlacements->expire = $oCampaignDate->format('%Y-%m-%d');
        $placementId = DataGenerator::generateOne($doPlacements);
        $doPlacements = OA_Dal::staticGetDO('campaigns', $placementId);
        $aPlacement = $doPlacements->toArray();

        $result = $oEmail->sendPlacementImpendingExpiryEmail($oNowDate, $placementId);
        // No emails should be sent yet because the preferences weren't set
        $this->assertEqual($result, 0);

        // Create the preference
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'warn_email_admin';
        $doPreferences->account_type = OA_ACCOUNT_ADMIN;
        $warnEmailAdminPreferenceId = DataGenerator::generateOne($doPreferences);

        // Set the admin preference
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $adminAccountId;
        $doAccount_Preference_Assoc->preference_id = $warnEmailAdminPreferenceId;
        $doAccount_Preference_Assoc->value = 1;
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        // Create the admin threshold preference
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'warn_email_admin_impression_limit';
        $doPreferences->account_type = OA_ACCOUNT_ADMIN;
        $warnEmailAdminImpLimitPreferenceId = DataGenerator::generateOne($doPreferences);

        // Set the admin preference
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $adminAccountId;
        $doAccount_Preference_Assoc->preference_id = $warnEmailAdminImpLimitPreferenceId;
        $doAccount_Preference_Assoc->value = 100;
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        // Create the admin day warning
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'warn_email_admin_day_limit';
        $doPreferences->account_type = OA_ACCOUNT_ADMIN;
        $warnEmailAdminDayLimitPreferenceId = DataGenerator::generateOne($doPreferences);

        // Set the admin preference
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $adminAccountId;
        $doAccount_Preference_Assoc->preference_id = $warnEmailAdminDayLimitPreferenceId;
        $doAccount_Preference_Assoc->value = 2;
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        // Set the agency preferences
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'warn_email_manager';
        $doPreferences->account_type = OA_ACCOUNT_MANAGER;
        $warnEmailManagerPreferenceId = DataGenerator::generateOne($doPreferences);

        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $agencyAccountId;
        $doAccount_Preference_Assoc->preference_id = $warnEmailManagerPreferenceId;
        $doAccount_Preference_Assoc->value = 0;
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'warn_email_manager_impression_limit';
        $doPreferences->account_type = OA_ACCOUNT_MANAGER;
        $warnEmailManagerImpLimitPreferenceId = DataGenerator::generateOne($doPreferences);

        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $agencyAccountId;
        $doAccount_Preference_Assoc->preference_id = $warnEmailManagerImpLimitPreferenceId;
        $doAccount_Preference_Assoc->value = 100;
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'warn_email_manager_day_limit';
        $doPreferences->account_type = OA_ACCOUNT_MANAGER;
        $warnEmailManagerDayLimitPreferenceId = DataGenerator::generateOne($doPreferences);

        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $agencyAccountId;
        $doAccount_Preference_Assoc->preference_id = $warnEmailManagerDayLimitPreferenceId;
        $doAccount_Preference_Assoc->value = 2;
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        // Set the advertiser preferences
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'warn_email_advertiser';
        $doPreferences->account_type = OA_ACCOUNT_ADVERTISER;
        $warnEmailAdvertiserPreferenceId = DataGenerator::generateOne($doPreferences);

        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $advertiserAccountId;
        $doAccount_Preference_Assoc->preference_id = $warnEmailAdvertiserPreferenceId;
        $doAccount_Preference_Assoc->value = 0;
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'warn_email_advertiser_impression_limit';
        $doPreferences->account_type = OA_ACCOUNT_ADVERTISER;
        $warnEmailAdvertiserImpLimitPreferenceId = DataGenerator::generateOne($doPreferences);

        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $advertiserAccountId;
        $doAccount_Preference_Assoc->preference_id = $warnEmailAdvertiserImpLimitPreferenceId;
        $doAccount_Preference_Assoc->value = 100;
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'warn_email_advertiser_day_limit';
        $doPreferences->account_type = OA_ACCOUNT_ADVERTISER;
        $warnEmailAdvertiserDayLimitPreferenceId = DataGenerator::generateOne($doPreferences);

        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $advertiserAccountId;
        $doAccount_Preference_Assoc->preference_id = $warnEmailAdvertiserDayLimitPreferenceId;
        $doAccount_Preference_Assoc->value = 2;
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        // Create another user linked to the advertiser account and ensure that an additional email is sent
        $doUser = OA_Dal::factoryDO('users');
        $doUser->contact_name = '2_' . $advertiserName;
        $doUser->email_address = '2_' . $advertiserMail;
        $doUser->username = '2_' . $clientName;
        $doUser->language = 'de';
        $advertiserUserId2 = DataGenerator::generateOne($doUser);
        $doAdvertiserUser2 = OA_Dal::staticGetDO('users', $advertiserUserId2);
        $aAdvertiserUser2 = $doAdvertiserUser2->toArray();

        // Link the advertiser user
        $oUserAccess->linkUserToAccount($advertiserUserId2, $doClients->account_id, array(), array());

        // If the advertiser preference is off, then the advertiser should not be sent emails
        // even if the admin/manager preference is on
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $advertiserAccountId;
        $doAccount_Preference_Assoc->preference_id = $warnEmailAdvertiserPreferenceId;
        $doAccount_Preference_Assoc->value = 0;
        $doAccount_Preference_Assoc->update();

        // And turning off the manager preference should leave just agency emails (2)
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $agencyAccountId;
        $doAccount_Preference_Assoc->preference_id = $warnEmailManagerPreferenceId;
        $doAccount_Preference_Assoc->value = 0;
        $doAccount_Preference_Assoc->update();

        // -- The above sets up the environment for the tests below -- //

        // Check the body when passing in the admin user:
        $expectedSubject = "Impending campaign expiration: $advertiserName";
        $expectedContents  = "Dear $adminContact,\n\n";
        $expectedContents .= "The campaign belonging to $advertiserName shown below is due to end on $dateValue.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " There are currently no banners defined\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $adminName, $adminCompany";

        Language_Default::load($aAdminUser['language']);
        $numSent = $oEmail->sendPlacementImpendingExpiryEmail($oTwoDaysPriorDate, $placementId);
        $aResult = $oEmail->preparePlacementImpendingExpiryEmail($aAdminUser, $advertiserId1, $placementId, $dateReason, $dateValue, 'admin');

        $this->assertEqual($numSent, 1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        // Manager user
        $expectedSubject = "Impending campaign expiration: $advertiserName";
        $expectedContents  = "Dear {$aAgencyUser['contact_name']},\n\n";
        $expectedContents .= "The campaign belonging to $advertiserName shown below is due to end on $dateValue.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " There are currently no banners defined\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $agencyContact, $agencyName";

        Language_Default::load($aAgencyUser['language']);
        $numSent = $oEmail->sendPlacementImpendingExpiryEmail($oTwoDaysPriorDate, $placementId);
        $aResult = $oEmail->preparePlacementImpendingExpiryEmail($aAgencyUser, $advertiserId1, $placementId, $dateReason, $dateValue, 'manager');

        $this->assertEqual($numSent, 1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        // The following should never be sent because a campaign without banners should never deliver (and therefore never reach the "remaining" threshold)
        $expectedSubject = "Impending campaign expiration: $advertiserName";
        $expectedContents  = "Dear {$aAdminUser['contact_name']},\n\n";
        $expectedContents .= "The campaign belonging to $advertiserName shown below has less than $impValue impressions remaining.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " There are currently no banners defined\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $adminName, $adminCompany";

        Language_Default::load($aAdminUser['language']);
        $numSent = $oEmail->sendPlacementImpendingExpiryEmail($oNowDate, $placementId);
        $aResult = $oEmail->preparePlacementImpendingExpiryEmail($aAdminUser, $advertiserId1, $placementId, $impReason, $impValue, 'admin');
        $this->assertEqual($numSent, 0);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        $expectedSubject = "Impending campaign expiration: $advertiserName";
        $expectedContents  = "Dear {$aAgencyUser['contact_name']},\n\n";
        $expectedContents .= "The campaign belonging to $advertiserName shown below has less than $impValue impressions remaining.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " There are currently no banners defined\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $agencyContact, $agencyName";

        Language_Default::load($aAgencyUser['language']);
        $numSent = $oEmail->sendPlacementImpendingExpiryEmail($oNowDate, $placementId);
        $aResult = $oEmail->preparePlacementImpendingExpiryEmail($aAgencyUser, $advertiserId1, $placementId, $impReason, $impValue, 'manager');
        $this->assertEqual($numSent, 0);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        // Add some banners and retest
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId;
        $doBanners->url        = '';
        $bannerId1 = DataGenerator::generateOne($doBanners);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId;
        $doBanners->url        = 'http://www.fornax.net/';
        $bannerId2 = DataGenerator::generateOne($doBanners);

        $expectedSubject = "Impending campaign expiration: $advertiserName";
        $expectedContents  = "Dear {$aAdminUser['contact_name']},\n\n";
        $expectedContents .= "The campaign belonging to $advertiserName shown below is due to end on $dateValue.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $adminName, $adminCompany";

        Language_Default::load($aAdminUser['language']);
        $numSent = $oEmail->sendPlacementImpendingExpiryEmail($oTwoDaysPriorDate, $placementId);
        $aResult = $oEmail->preparePlacementImpendingExpiryEmail($aAdminUser, $advertiserId1, $placementId1, $dateReason, $dateValue, 'admin');
        $this->assertEqual($numSent, 1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        $expectedSubject = "Impending campaign expiration: $advertiserName";
        $expectedContents  = "Dear {$aAdvertiserUser['contact_name']},\n\n";
        $expectedContents .= "Your campaign shown below is due to end on $dateValue.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $agencyContact, $agencyName";

        Language_Default::load($aAdvertiserUser['language']);
        $numSent = $oEmail->sendPlacementImpendingExpiryEmail($oTwoDaysPriorDate, $placementId);
        $aResult = $oEmail->preparePlacementImpendingExpiryEmail($aAdvertiserUser, $advertiserId1, $placementId, $dateReason, $dateValue, 'advertiser');
        $this->assertEqual($numSent, 1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        // Enable the warn_email_advertiser preference and retest
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $advertiserAccountId;
        $doAccount_Preference_Assoc->preference_id = $warnEmailAdvertiserPreferenceId;
        $doAccount_Preference_Assoc->value = 1;
        $doAccount_Preference_Assoc->update();

        // So should now send 1 admin and 2 advertiser emails
        $numSent = $oEmail->sendPlacementImpendingExpiryEmail($oTwoDaysPriorDate, $placementId);
        $this->assertEqual($numSent, 3);

        $expectedSubject = "Impending campaign expiration: $advertiserName";
        $expectedContents  = "Dear $adminContact,\n\n";
        $expectedContents .= "The campaign belonging to $advertiserName shown below has less than $impValue impressions remaining.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $adminName, $adminCompany";

        $aResult = $oEmail->preparePlacementImpendingExpiryEmail($aAdminUser, $advertiserId1, $placementId, $impReason, $impValue, 'admin');
        $numSent = $oEmail->sendPlacementImpendingExpiryEmail($oTwoDaysPriorDate, $placementId);
        $this->assertEqual($numSent, 3);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        // Enable the warn_email_manager preference and retest
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $agencyAccountId;
        $doAccount_Preference_Assoc->preference_id = $warnEmailManagerPreferenceId;
        $doAccount_Preference_Assoc->value = 1;
        $doAccount_Preference_Assoc->update();
        $numSent = $oEmail->sendPlacementImpendingExpiryEmail($oTwoDaysPriorDate, $placementId);
        $this->assertEqual($numSent, 4);

        $expectedSubject = "Impending campaign expiration: $advertiserName";
        $expectedContents  = "Dear {$aAdvertiserUser['contact_name']},\n\n";
        $expectedContents .= "Your campaign shown below has less than $impValue impressions remaining.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $agencyContact, $agencyName";

        $aResult = $oEmail->preparePlacementImpendingExpiryEmail($aAdvertiserUser, $advertiserId1, $placementId, $impReason, $impValue, 'advertiser');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        // Check that advertiser2's email is send in their desired language (german)
        $expectedSubject = "Bevorstehende Deaktivierung der Kampagne: $advertiserName";
        $expectedContents  = "Sehr geehrte(r) {$aAdvertiserUser2['contact_name']},\n\n";
        $expectedContents .= "Unten angegebene Ihre Kampagne hat weniger als {$impValue} Impressions �brig.\n\n";
        $expectedContents .= "Auf Grund dessen wird die Kampagne bald deaktiviert und weiter unten angegebene Banner aus dieser Kampagne werden deaktiviert.\n";
        $expectedContents .= "\nKampagne [id$placementId] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/campaign-edit.php?clientid=$advertiserId1&campaignid=$placementId\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner [id$bannerId2] 1\n";
        $expectedContents .= "  verknüpft mit: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Mit freundlichem Gruß\n   $agencyContact, $agencyName";
        $aResult = $oEmail->preparePlacementImpendingExpiryEmail($aAdvertiserUser2, $advertiserId1, $placementId, $impReason, $impValue, 'advertiser');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        DataGenerator::cleanUp();
    }

    /**
     * Tests that an e-mail advising a placement has been activated is able to
     * be generated correctly.
     *
     */
    function testPrepareActivateDeactivatePlacementEmail()
    {
        $adminContact  = 'Andrew Hill';
        $adminName     = 'OpenX Limited';
        $adminMail     = 'send@example.com';
        $adminCompany  = 'Admin company name';

        $adminAccountId= 100;
        $agencyName    = 'Agency Ltd.';
        $agencyContact = 'Mr. Foo Bar Agency';
        $agencyMail    = 'send@agency.com';

        $advertiserName    = 'Foo Client';
        $advertiserMail    = 'advertiser@example.com';
        $advertiserUsername= 'advertiserusername';

        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['webpath']['admin'] = 'example.com';
        $aConf['email']['fromAddress']  = $adminMail;
        $aConf['email']['fromName']     = $adminName;
        $aConf['email']['fromCompany']  = $adminCompany;

        Mock::generatePartial(
            'OA_Email',
            'PartialMockOA_Email',
            array('sendMail')
        );

        $oEmail = new PartialMockOA_Email();
        $oEmail->setReturnValue('sendMail', true);

        unset($GLOBALS['_MAX']['PREF']);

        // Prepare an admin user
         // Create the admin account
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_name = 'Administrator Account';
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $adminAccountId = DataGenerator::generateOne($doAccounts);

        // Setup the admin account id
        $doAppVar = OA_Dal::factoryDO('application_variable');
        $doAppVar->name='admin_account_id';
        $doAppVar->value=$adminAccountId;

        // Create a user
        $doAdminUser = OA_Dal::factoryDO('users');
        $doAdminUser->contact_name = $adminContact;
        $doAdminUser->email_address = $adminMail;
        $doAdminUser->username = $adminName;
        $doAdminUser->password = md5('password');
        $doAdminUser->language = 'en';
        $doAdminUser->default_account_id = $adminAccountId;
        $adminUserId = DataGenerator::generateOne($doAdminUser);
        $doAdminUser = OA_Dal::staticGetDO('users', $adminUserId);
        $aAdminUser = $doAdminUser->toArray();

        // Create admin account-user association
        $doAUA = OA_Dal::factoryDO('account_user_assoc');
        $doAUA->account_id = $adminAccountId;
        $doAUA->user_id = $adminUserId;
        $doAUA->insert();

        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name    = $agencyName;
        $doAgency->contact = $agencyContact;
        $doAgency->email   = $agencyMail;
        $agencyId = DataGenerator::generateOne($doAgency);
        $doAgency = OA_Dal::staticGetDO('agency', $agencyId); //get('agencyid', $agencyId);
        $agencyAccountId = $doAgency->account_id;

        // Prepare an agency user
        $doUser = OA_Dal::factoryDO('users');
        $doUser->contact_name = $agencyContact;
        $doUser->email_address = $agencyMail;
        $doUser->username = $agencyName;
        $doUser->language = 'en';
        $agencyUserId = DataGenerator::generateOne($doUser);
        $doAgencyUser = OA_Dal::staticGetDO('users', $agencyUserId);
        $aAgencyUser = $doAgencyUser->toArray();

        $oUserAccess = new OA_Admin_UI_UserAccess();

        // Agency user
        $oUserAccess->linkUserToAccount($agencyUserId, $doAgency->account_id, array(), array());

        // Generate an advertiser owned by the agency
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid   = $agencyId;
        $doClients->clientname = $advertiserName;
        $doClients->email      = '';
        $advertiserId1 = DataGenerator::generateOne($doClients);
        $doClients = OA_Dal::staticGetDO('clients', 'clientid', $advertiserId1);
        $advertiserAccountId = $doClients->account_id;

        // Create an advertiser user
        $doUser = OA_Dal::factoryDO('users');
        $doUser->contact_name = $advertiserName;
        $doUser->email_address = $advertiserMail;
        $doUser->username = $advertiserUsername;
        $doUser->language = 'en';
        $userId = DataGenerator::generateOne($doUser);
        $doAdvertiserUser = OA_Dal::staticGetDO('users', $userId);
        $aAdvertiserUser = $doAdvertiserUser->toArray();

        // Link the advertiser user
        $oUserAccess->linkUserToAccount($userId, $doClients->account_id, array(), array());

        // Create a campaign
        $doPlacements = OA_Dal::factoryDO('campaigns');
        $doPlacements->clientid = $advertiserId1;
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

        // One copy should be sent
        $result = $oEmail->sendPlacementActivatedDeactivatedEmail($placementId);
        $this->assertEqual($result, 1);

        $aResult = $oEmail->preparePlacementActivatedDeactivatedEmail($aAdvertiserUser, $placementId);

        // Check the contents of the generated email are correct
        $expectedSubject = 'Campaign activated: Foo Client';
        $expectedContents  = "Dear {$aAdvertiserUser['contact_name']},\n\n";
        $expectedContents .= 'Your campaign shown below has been activated because'. "\n";
        $expectedContents .= 'the campaign activation date has been reached.' . "\n";
        $expectedContents .= "\nCampaign [id$placementId] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid={$placementId}&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner  [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "\n";
        $expectedContents .= "Regards,\n   {$agencyContact}, {$agencyName}";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        // Check for a campaign that should be deactivated
        $expectedSubject = 'Campaign deactivated: Foo Client';
        $expectedContents  = "Dear {$aAdvertiserUser['contact_name']},\n\n";
        $expectedContents .= 'Your campaign shown below has been deactivated because:'. "\n";
        $expectedContents .= '  - there are no Impressions remaining.' . "\n";
        $expectedContents .= "\nCampaign [id$placementId] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid={$placementId}&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner  [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "\n";
        $expectedContents .= "Regards,\n   {$agencyContact}, {$agencyName}";
        $aResult = $oEmail->preparePlacementActivatedDeactivatedEmail($aAdvertiserUser, $placementId, OA_PLACEMENT_DISABLED_IMPRESSIONS);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        $aResult = $oEmail->preparePlacementActivatedDeactivatedEmail($aAdvertiserUser, $placementId, OA_PLACEMENT_DISABLED_CLICKS);
        $expectedSubject = 'Campaign deactivated: Foo Client';
        $expectedContents  = "Dear {$aAdvertiserUser['contact_name']},\n\n";
        $expectedContents .= 'Your campaign shown below has been deactivated because:'. "\n";
        $expectedContents .= '  - there are no Clicks remaining.' . "\n";
        $expectedContents .= "\nCampaign [id$placementId] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid={$placementId}&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner  [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "\n";
        $expectedContents .= "Regards,\n   {$agencyContact}, {$agencyName}";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        $aResult = $oEmail->preparePlacementActivatedDeactivatedEmail($aAdvertiserUser, $placementId, OA_PLACEMENT_DISABLED_CONVERSIONS);
        $expectedSubject = 'Campaign deactivated: Foo Client';
        $expectedContents  = "Dear {$aAdvertiserUser['contact_name']},\n\n";
        $expectedContents .= 'Your campaign shown below has been deactivated because:'. "\n";
        $expectedContents .= '  - there are no Sales remaining.' . "\n";
        $expectedContents .= "\nCampaign [id$placementId] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid={$placementId}&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner  [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "\n";
        $expectedContents .= "Regards,\n   {$agencyContact}, {$agencyName}";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        $aResult = $oEmail->preparePlacementActivatedDeactivatedEmail($aAdvertiserUser, $placementId, OA_PLACEMENT_DISABLED_DATE);
        $expectedSubject = 'Campaign deactivated: Foo Client';
        $expectedContents  = "Dear {$aAdvertiserUser['contact_name']},\n\n";
        $expectedContents .= 'Your campaign shown below has been deactivated because:'. "\n";
        $expectedContents .= '  - the expiration date has been reached.' . "\n";
        $expectedContents .= "\nCampaign [id$placementId] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid={$placementId}&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner  [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "\n";
        $expectedContents .= "Regards,\n   {$agencyContact}, {$agencyName}";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        $reason = 0 | OA_PLACEMENT_DISABLED_IMPRESSIONS | OA_PLACEMENT_DISABLED_CLICKS | OA_PLACEMENT_DISABLED_DATE;
        $aResult = $oEmail->preparePlacementActivatedDeactivatedEmail($aAdvertiserUser, $placementId, $reason);
        $expectedSubject = 'Campaign deactivated: Foo Client';
        $expectedContents  = "Dear {$aAdvertiserUser['contact_name']},\n\n";
        $expectedContents .= 'Your campaign shown below has been deactivated because:'. "\n";
        $expectedContents .= '  - there are no Impressions remaining' . "\n";
        $expectedContents .= '  - there are no Clicks remaining' . "\n";
        $expectedContents .= '  - the expiration date has been reached.' . "\n";
        $expectedContents .= "\nCampaign [id$placementId] 1\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid={$placementId}&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$bannerId1] 1\n\n";
        $expectedContents .= " Banner  [id$bannerId2] 1\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "\n";
        $expectedContents .= "Regards,\n   {$agencyContact}, {$agencyName}";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        TestEnv::restoreEnv();
    }
}

?>