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
        // Clean up userlog
        $doUserLog = OA_Dal::factoryDO('userlog');
        $doUserLog->whereAdd('1=1');
        $doUserLog->delete(DB_DATAOBJECT_WHEREADD_ONLY);
    }

    /**
     * Tests that an e-mail reporting on placement delivery is able to be
     * generated correctly.
     */
    function testPrepareCampaignDeliveryEmail()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['webpath']['admin'] = 'example.com';
        $aConf['email']['fromAddress'] = 'send@example.com';
        $aConf['email']['fromName'] = 'Miguel Correa';
        $aConf['email']['fromCompany'] = 'OpenX Limited';
        $aConf['email']['useManagerDetails'] = true;

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
        $result = $oEmail->prepareCampaignDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate);
        $this->assertFalse($result);

        // Generate an advertiser with reports disabled and test, ensuring
        // that false is returned
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = $clientName;
        $doClients->email      = '';
        $doClients->contact    = '';
        $doClients->report     = 'f';
        $advertiserId = DataGenerator::generateOne($doClients);
        $result = $oEmail->prepareCampaignDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate);
        $this->assertFalse($result);

        // Generate an advertiser with reports enabled, but no other data,
        // and test, ensuring that false is returned
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = $clientName;
        $doClients->email      = '';
        $doClients->contact    = '';
        $doClients->report     = 't';
        $advertiserId = DataGenerator::generateOne($doClients);
        $result = $oEmail->prepareCampaignDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate);
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
        $result = $oEmail->prepareCampaignDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate);
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
        $doPlacements->campaignname = 'Default Campaign';
        $placementId1 = DataGenerator::generateOne($doPlacements);

        Language_Loader::load('default', $doUser->language);
        $aResult = $oEmail->prepareCampaignDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate);

        $expectedSubject = "Advertiser report: $clientName";
        $expectedContents  = "Dear $user_name,\n\n";
        $expectedContents .= "Below you will find the banner statistics for $clientName:\n";
        global $date_format;
        $startDate = $oStartDate->format($date_format);
        $endDate   = $oEndDate->format($date_format);
        $expectedContents .= "This report includes statistics from $startDate up to $endDate.\n\n";
        $expectedContents .= "\nCampaign [id$placementId1] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId&campaignid=$placementId1&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= "There are no statistics available for this campaign\n\n\n\n";
        $expectedContents .= "Regards,\n   Miguel Correa, OpenX Limited";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 3);
        $this->assertEqual($aResult['subject'], $expectedSubject);
        $this->assertEqual($aResult['contents'], $expectedContents);

        // Add another placement with no ads to the above advertiser, and test
        // that the correct report is generated
        $doPlacements = OA_Dal::factoryDO('campaigns');
        $doPlacements->clientid = $advertiserId;
        $doPlacements->campaignname = 'Default Campaign';
        $placementId2 = DataGenerator::generateOne($doPlacements);
        $aResult = $oEmail->prepareCampaignDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate);
        $expectedSubject = "Advertiser report: $clientName";
        $expectedContents  = "Dear $user_name,\n\n";
        $expectedContents .= "Below you will find the banner statistics for $clientName:\n";
        global $date_format;
        $startDate = $oStartDate->format($date_format);
        $endDate   = $oEndDate->format($date_format);
        $expectedContents .= "This report includes statistics from $startDate up to $endDate.\n\n";
        $expectedContents .= "\nCampaign [id$placementId1] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId&campaignid=$placementId1&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= "There are no statistics available for this campaign\n\n\n";
        $expectedContents .= "\nCampaign [id$placementId2] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId&campaignid=$placementId2&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= "There are no statistics available for this campaign\n\n\n\n";
        $expectedContents .= "Regards,\n   Miguel Correa, OpenX Limited";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 3);
        $this->assertEqual($aResult['subject'], $expectedSubject);
        $this->assertEqual($aResult['contents'], $expectedContents);

        // Add an ad to the second placements, but with no delivery data, and
        // ensure the correct email is generated (no change to previous!)
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId2;
        $doPlacements->campaignname = 'Default Campaign';
        $adId1 = DataGenerator::generateOne($doBanners);
        $aResult = $oEmail->prepareCampaignDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 3);
        $this->assertEqual($aResult['subject'], $expectedSubject);
        $this->assertEqual($aResult['contents'], $expectedContents);

        // Add an ad to the second placements, with delivery data outside
        // the current date range, and ensure the correct email is generated
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId2;
        $doBanners->description = 'Test Banner';
        $adId2 = DataGenerator::generateOne($doBanners);
        $doDataSummaryAdHourly = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->date_time   = '2007-05-12 12:00:00';
        $doDataSummaryAdHourly->ad_id       = $adId2;
        $doDataSummaryAdHourly->impressions = 5000;
        $doDataSummaryAdHourly->clicks      = 0;
        $doDataSummaryAdHourly->conversions = 0;
        DataGenerator::generateOne($doDataSummaryAdHourly);
        $aResult = $oEmail->prepareCampaignDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate);
        $expectedSubject = "Advertiser report: $clientName";
        $expectedContents  = "Dear $user_name,\n\n";
        $expectedContents .= "Below you will find the banner statistics for $clientName:\n";
        global $date_format;
        $startDate = $oStartDate->format($date_format);
        $endDate   = $oEndDate->format($date_format);
        $expectedContents .= "This report includes statistics from $startDate up to $endDate.\n\n";
        $expectedContents .= "\nCampaign [id$placementId1] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId&campaignid=$placementId1&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= "There are no statistics available for this campaign\n\n\n";
        $expectedContents .= "\nCampaign [id$placementId2] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId&campaignid=$placementId2&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$adId2] Test Banner\n";
        $expectedContents .= " ------------------------------------------------------\n";
        $expectedContents .= " Impressions (Total):           5,000\n";
        $expectedContents .= "  No Impressions were logged during the span of this report\n";
        $expectedContents .= "\n\n";
        $expectedContents .= "Regards,\n   Miguel Correa, OpenX Limited";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 3);
        $this->assertEqual($aResult['subject'], $expectedSubject);
        $this->assertEqual($aResult['contents'], $expectedContents);

        // Add an ad to the second placements, with delivery data in the
        // report range, and ensure the correct email is generated
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId2;
        $doBanners->description = 'Test Banner';
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
        $aResult = $oEmail->prepareCampaignDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate);
        $expectedSubject = "Advertiser report: $clientName";
        $expectedContents  = "Dear $user_name,\n\n";
        $expectedContents .= "Below you will find the banner statistics for $clientName:\n";
        global $date_format;
        $startDate = $oStartDate->format($date_format);
        $endDate   = $oEndDate->format($date_format);
        $expectedContents .= "This report includes statistics from $startDate up to $endDate.\n\n";
        $expectedContents .= "\nCampaign [id$placementId1] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId&campaignid=$placementId1&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= "There are no statistics available for this campaign\n\n\n";
        $expectedContents .= "\nCampaign [id$placementId2] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId&campaignid=$placementId2&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$adId2] Test Banner\n";
        $expectedContents .= " ------------------------------------------------------\n";
        $expectedContents .= " Impressions (Total):           5,000\n";
        $expectedContents .= "  No Impressions were logged during the span of this report\n";
        $expectedContents .= "\n";
        $expectedContents .= " Banner  [id$adId3] Test Banner\n";
        $expectedContents .= " ------------------------------------------------------\n";
        $expectedContents .= " Impressions (Total):          15,000\n";
        $expectedContents .= "          15-05-2007:           5,000\n";
        $expectedContents .= "          14-05-2007:          10,000\n";
        $expectedContents .= "   Total this period:          15,000\n";
        $expectedContents .= "\n\n";
        $expectedContents .= "Regards,\n   Miguel Correa, OpenX Limited";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 3);
        $this->assertEqual($aResult['subject'], $expectedSubject);
        $this->assertEqual($aResult['contents'], $expectedContents);

        DataGenerator::cleanUp();

        $aConf['webpath']['admin'] = 'example.com';
        $aConf['email']['fromAddress'] = 'send@example.com';
        $aConf['email']['fromName'] = 'Andrew Hill';
        $aConf['email']['fromCompany'] = 'OpenX Limited';
        $aConf['email']['useManagerDetails'] = true;

        // Test with no start date
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname = $clientName;
        $doClients->email      = $email;
        $doClients->contact    = $user_name;
        $doClients->report     = 't';
        $advertiserId = DataGenerator::generateOne($doClients);
        $doPlacements = OA_Dal::factoryDO('campaigns');
        $doPlacements->clientid = $advertiserId;
        $doPlacements->campaignname = 'Default Campaign';
        $placementId1 = DataGenerator::generateOne($doPlacements);
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId1;
        $doBanners->description = 'Test Banner';
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
        $aResult = $oEmail->prepareCampaignDeliveryEmail($aUser, $advertiserId, null, $oEndDate);
        $expectedSubject = "Advertiser report: $clientName";
        $expectedContents  = "Dear $user_name,\n\n";
        $expectedContents .= "Below you will find the banner statistics for $clientName:\n";
        global $date_format;
        $startDate = $oStartDate->format($date_format);
        $endDate   = $oEndDate->format($date_format);
        $expectedContents .= "This report includes all statistics up to $endDate.\n\n";
        $expectedContents .= "\nCampaign [id$placementId1] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId&campaignid=$placementId1&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$adId1] Test Banner\n";
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
        DataGenerator::cleanUp(array('accounts', 'account_user_assoc'));
    }

    function testSendCampaignDeliveryEmail()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['webpath']['admin'] = 'example.com';
        $aConf['email']['fromAddress'] = 'send@example.com';
        $aConf['email']['fromName'] = 'Andrew Hill';
        $aConf['email']['fromCompany'] = 'OpenX Limited';
        $aConf['email']['useManagerDetails'] = true;
        $aConf['email']['logOutgoing'] = true;

        $mockName = uniqid('PartialMockOA_Email_');
        Mock::generatePartial(
            'OA_Email',
            $mockName,
            array('sendMail')
        );

        $oEmail = new $mockName();
        $oEmail->setReturnValue('sendMail', true);
        $oEmail->expectCallCount('sendMail', 7);

        // Prepare valid test data
        $oStartDate   = new Date('2007-05-13 23:59:59');
        $oEndDate     = new Date('2007-05-19 00:00:00');
        $email        = 'andrew.hill@openx.org';
        $name         = 'Andrew Hill';
        $clientName   = 'Foo Client';

        // Test with no advertiser data in the database, and ensure that
        // false is returned
        $doClients1 = OA_Dal::factoryDO('clients');
        $doClients1->clientname = $clientName;
        $doClients1->email      = 'advertiser_default@example.com';
        $doClients1->contact    = 'Advertiser Default';
        $doClients1->report     = 't';
        $advertiserId = DataGenerator::generateOne($doClients1);
        $aAdvertiser1 = $doClients1->toArray();
        $result = $oEmail->sendCampaignDeliveryEmail($aAdvertiser1, $oStartDate, $oEndDate);
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
        $doClients->email      = 'miguel.correa@openx.org';
        $doClients->contact    = '';
        $doClients->report     = 'f';
        $advertiserId = DataGenerator::generateOne($doClients);
        $aAdvertiser = $doClients->toArray();
        $result = $oEmail->sendCampaignDeliveryEmail($aAdvertiser, $oStartDate, $oEndDate);
        $this->assertFalse($result);

        $doClients = OA_Dal::factoryDO('clients');
        $doClients->get('clientid', $advertiserId);

        // Generate an advertiser with reports enabled, but no other data,
        // and test, ensuring that false is returned
        $doClients->report     = 't';
        $doClients->update();
        $aAdvertiser = $doClients->toArray();
        $result = $oEmail->sendCampaignDeliveryEmail($aAdvertiser, $oStartDate, $oEndDate);
        $this->assertFalse($result);

        $doPlacements = OA_Dal::factoryDO('campaigns');
        $doPlacements->clientid = $advertiserId;
        $placementId = DataGenerator::generateOne($doPlacements);

        $result = $oEmail->sendCampaignDeliveryEmail($aAdvertiser, $oStartDate, $oEndDate);
        $this->assertFalse($result);

        // No entries in userlog
        $doUserLog = OA_Dal::factoryDO('userlog');
        $doUserLog->find();
        $this->assertFalse($doUserLog->fetch());

        // Link the user
        $oUserAccess = new OA_Admin_UI_UserAccess();
        $oUserAccess->linkUserToAccount($userId, $advertiserId, array(), array());

        // With no stats, no email should be sent
        $result = $oEmail->sendCampaignDeliveryEmail($aAdvertiser, $oStartDate, $oEndDate);
        $this->assertEqual($result, 0);

        // Still no entries in userlog
        $doUserLog = OA_Dal::factoryDO('userlog');
        $doUserLog->find();
        $this->assertFalse($doUserLog->fetch());

        // Create a banner
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId;
        $bannerId = DataGenerator::generateOne($doBanners);

        // With no stats, no email should be sent
        $result = $oEmail->sendCampaignDeliveryEmail($aAdvertiser, $oStartDate, $oEndDate);
        $this->assertEqual($result, 0);

        // No entries in userlog
        $doUserLog = OA_Dal::factoryDO('userlog');
        $doUserLog->find();
        $this->assertFalse($doUserLog->fetch());

        // Load up some stats
        $doDataSummaryAdHourly = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->date_time   = '2007-05-14 12:00:00';
        $doDataSummaryAdHourly->ad_id       = $bannerId;
        $doDataSummaryAdHourly->impressions = 5000;
        $doDataSummaryAdHourly->clicks      = 0;
        $doDataSummaryAdHourly->conversions = 0;
        DataGenerator::generateOne($doDataSummaryAdHourly);

        // With some stats and a linked user, one email should be sent
        $result = $oEmail->sendCampaignDeliveryEmail($aAdvertiser, $oStartDate, $oEndDate);
        $this->assertEqual($result, 2);

        // Now email should be stored in userlog
        $doUserLog = OA_Dal::factoryDO('userlog');
        $doUserLog->find();
        $this->assertTrue($doUserLog->fetch());
        $userLogRow = $doUserLog->toArray();
        $this->assertEqual($userLogRow['action'], phpAds_actionAdvertiserReportMailed);
        $this->assertTrue((strpos($userLogRow['details'], $clientName)!==false));
        $this->assertTrue((strpos($userLogRow['details'], $email)!==false));
        // Clear userlog table
        $doUserLog = OA_Dal::factoryDO('userlog');
        $doUserLog->whereAdd('1=1');
        $doUserLog->delete(DB_DATAOBJECT_WHEREADD_ONLY);

        // Turn off email logging and send mail again
        $aConf['email']['logOutgoing'] = false;
        $result = $oEmail->sendCampaignDeliveryEmail($aAdvertiser, $oStartDate, $oEndDate);
        $this->assertEqual($result, 2);

        // No entries in userlog
        $doUserLog = OA_Dal::factoryDO('userlog');
        $doUserLog->find();
        $this->assertFalse($doUserLog->fetch());

        // Set email logging back to true
        $aConf['email']['logOutgoing'] = true;

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

        $result = $oEmail->sendCampaignDeliveryEmail($aAdvertiser, $oStartDate, $oEndDate);
        $this->assertEqual($result, 3);

        // Check if there are two entries in userlog
        $doUserLog = OA_Dal::factoryDO('userlog');
        $aUserLog = $doUserLog->getAll();
        $this->assertEqual(count($aUserLog), 3);
        $this->assertEqual($aUserLog[0]['action'], phpAds_actionAdvertiserReportMailed);
        $this->assertEqual($aUserLog[1]['action'], phpAds_actionAdvertiserReportMailed);


        DataGenerator::cleanUp(array('accounts', 'account_user_assoc'));
    }

    /**
     * Tests that an e-mail reporting on impending campaign expiration
     * is able to be generated correctly.
     */
    function testSendAndPrepareCampaignImpendingExpiryEmail()
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
        $aConf['email']['useManagerDetails'] = true;
        $aConf['email']['logOutgoing']  = true;

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

        // Create an user
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
        $doPlacements->campaignname = 'Default Campaign';
        $doPlacements->views = 50;
        $doPlacements->expire = $oCampaignDate->format('%Y-%m-%d');
        $placementId = DataGenerator::generateOne($doPlacements);
        $doPlacements = OA_Dal::staticGetDO('campaigns', $placementId);
        $aCampaign = $doPlacements->toArray();

        $result = $oEmail->sendCampaignImpendingExpiryEmail($oNowDate, $placementId);
        // No emails should be sent yet because the preferences weren't set
        $this->assertEqual($result, 0);

        // No entries in userlog
        $doUserLog = OA_Dal::factoryDO('userlog');
        $doUserLog->find();
        $this->assertFalse($doUserLog->fetch());

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
        $expectedContents .= "\nCampaign [id$placementId] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid=$placementId&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " There are currently no banners defined for this campaign.\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $adminName, $adminCompany";

        Language_Loader::load('default', $aAdminUser['language']);
        $numSent = $oEmail->sendCampaignImpendingExpiryEmail($oTwoDaysPriorDate, $placementId);
        $aResult = $oEmail->prepareCampaignImpendingExpiryEmail($aAdminUser, $advertiserId1, $placementId, $dateReason, $dateValue, 'admin');

        $this->assertEqual($numSent, 1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        // One entry in userlog
        $doUserLog = OA_Dal::factoryDO('userlog');
        $aUserLog = $doUserLog->getAll();
        $this->assertEqual(count($aUserLog), 1);
        $this->assertEqual($aUserLog[0]['action'], phpAds_actionWarningMailed);

         // Turn off email logging and send mail again
        $aConf['email']['logOutgoing'] = false;
        $numSent = $oEmail->sendCampaignImpendingExpiryEmail($oTwoDaysPriorDate, $placementId);
        $this->assertEqual($numSent, 1);

        // Still one entry in userlog
        $doUserLog = OA_Dal::factoryDO('userlog');
        $aUserLog = $doUserLog->getAll();
        $this->assertEqual(count($aUserLog), 1);

        // Set email logging back to true
        $aConf['email']['logOutgoing'] = true;

        // Manager user
        $expectedSubject = "Impending campaign expiration: $advertiserName";
        $expectedContents  = "Dear {$aAgencyUser['contact_name']},\n\n";
        $expectedContents .= "The campaign belonging to $advertiserName shown below is due to end on $dateValue.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid=$placementId&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " There are currently no banners defined for this campaign.\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   ".$aConf['email']['fromName'].", ".$aConf['email']['fromCompany'];

        Language_Loader::load('default', $aAgencyUser['language']);
        $numSent = $oEmail->sendCampaignImpendingExpiryEmail($oTwoDaysPriorDate, $placementId);
        $aResult = $oEmail->prepareCampaignImpendingExpiryEmail($aAgencyUser, $advertiserId1, $placementId, $dateReason, $dateValue, 'manager');

        $this->assertEqual($numSent, 1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        // Should create another entry in userlog
        $doUserLog = OA_Dal::factoryDO('userlog');
        $doUserLog->action = phpAds_actionWarningMailed;
        $aUserLog = $doUserLog->getAll();
        $this->assertEqual(count($aUserLog), 2);

        // Use email from details instead of the owning account's details
        $aConf['email']['useManagerDetails'] = false;

        // Manager user
        $expectedSubject = "Impending campaign expiration: $advertiserName";
        $expectedContents  = "Dear {$aAgencyUser['contact_name']},\n\n";
        $expectedContents .= "The campaign belonging to $advertiserName shown below is due to end on $dateValue.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid=$placementId&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " There are currently no banners defined for this campaign.\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   ".$aConf['email']['fromName'].", ".$aConf['email']['fromCompany'];

        Language_Loader::load('default', $aAgencyUser['language']);
        $numSent = $oEmail->sendCampaignImpendingExpiryEmail($oTwoDaysPriorDate, $placementId);
        $aResult = $oEmail->prepareCampaignImpendingExpiryEmail($aAgencyUser, $advertiserId1, $placementId, $dateReason, $dateValue, 'manager');

        $this->assertEqual($numSent, 1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);


        // Use email from empty details and test that not Regards are added
        $aConf['email']['fromAddress']  = '';
        $aConf['email']['fromName']     = '';
        $aConf['email']['fromCompany']  = '';

        // Manager user
        $expectedSubject = "Impending campaign expiration: $advertiserName";
        $expectedContents  = "Dear {$aAgencyUser['contact_name']},\n\n";
        $expectedContents .= "The campaign belonging to $advertiserName shown below is due to end on $dateValue.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid=$placementId&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " There are currently no banners defined for this campaign.\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";

        Language_Loader::load('default', $aAgencyUser['language']);
        $numSent = $oEmail->sendCampaignImpendingExpiryEmail($oTwoDaysPriorDate, $placementId);
        $aResult = $oEmail->prepareCampaignImpendingExpiryEmail($aAgencyUser, $advertiserId1, $placementId, $dateReason, $dateValue, 'manager');

        $this->assertEqual($numSent, 1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        $aConf['email']['useManagerDetails'] = true;
        $aConf['email']['fromAddress']  = $adminMail;
        $aConf['email']['fromName']     = $adminName;
        $aConf['email']['fromCompany']  = $adminCompany;

        // Should create another entry in userlog
        $doUserLog = OA_Dal::factoryDO('userlog');
        $doUserLog->action = phpAds_actionWarningMailed;
        $aUserLog = $doUserLog->getAll();
        $this->assertEqual(count($aUserLog), 4);

        // The following should never be sent because a campaign without banners should never deliver (and therefore never reach the "remaining" threshold)
        $expectedSubject = "Impending campaign expiration: $advertiserName";
        $expectedContents  = "Dear {$aAdminUser['contact_name']},\n\n";
        $expectedContents .= "The campaign belonging to $advertiserName shown below has less than $impValue impressions remaining.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid=$placementId&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " There are currently no banners defined for this campaign.\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $adminName, $adminCompany";

        Language_Loader::load('default', $aAdminUser['language']);
        $numSent = $oEmail->sendCampaignImpendingExpiryEmail($oNowDate, $placementId);
        $aResult = $oEmail->prepareCampaignImpendingExpiryEmail($aAdminUser, $advertiserId1, $placementId, $impReason, $impValue, 'admin');
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
        $expectedContents .= "\nCampaign [id$placementId] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid=$placementId&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " There are currently no banners defined for this campaign.\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   ".$aConf['email']['fromName'].", ".$aConf['email']['fromCompany'];

        Language_Loader::load('default', $aAgencyUser['language']);
        $numSent = $oEmail->sendCampaignImpendingExpiryEmail($oNowDate, $placementId);
        $aResult = $oEmail->prepareCampaignImpendingExpiryEmail($aAgencyUser, $advertiserId1, $placementId, $impReason, $impValue, 'manager');
        $this->assertEqual($numSent, 0);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        // Emails not sent, nothing new in userlog
        $doUserLog = OA_Dal::factoryDO('userlog');
        $doUserLog->action = phpAds_actionWarningMailed;
        $aUserLog = $doUserLog->getAll();
        $this->assertEqual(count($aUserLog), 4);

        // Add some banners and retest
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId;
        $doBanners->description = 'Test Banner';
        $doBanners->url        = '';
        $bannerId1 = DataGenerator::generateOne($doBanners);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId;
        $doBanners->description = 'Test Banner';
        $doBanners->url        = 'http://www.fornax.net/';
        $bannerId2 = DataGenerator::generateOne($doBanners);

        $expectedSubject = "Impending campaign expiration: $advertiserName";
        $expectedContents  = "Dear {$aAdminUser['contact_name']},\n\n";
        $expectedContents .= "The campaign belonging to $advertiserName shown below is due to end on $dateValue.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid=$placementId&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] Test Banner\n\n";
        $expectedContents .= " Banner [id$bannerId2] Test Banner\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $adminName, $adminCompany";

        Language_Loader::load('default', $aAdminUser['language']);
        $numSent = $oEmail->sendCampaignImpendingExpiryEmail($oTwoDaysPriorDate, $placementId);
        $aResult = $oEmail->prepareCampaignImpendingExpiryEmail($aAdminUser, $advertiserId1, $placementId1, $dateReason, $dateValue, 'admin');
        $this->assertEqual($numSent, 1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        $doUserLog = OA_Dal::factoryDO('userlog');
        $doUserLog->action = phpAds_actionWarningMailed;
        $aUserLog = $doUserLog->getAll();
        $this->assertEqual(count($aUserLog), 5);

        $expectedSubject = "Impending campaign expiration: $advertiserName";
        $expectedContents  = "Dear {$aAdvertiserUser['contact_name']},\n\n";
        $expectedContents .= "Your campaign shown below is due to end on $dateValue.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid=$placementId&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] Test Banner\n\n";
        $expectedContents .= " Banner [id$bannerId2] Test Banner\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $agencyContact, $agencyName";

        Language_Loader::load('default', $aAdvertiserUser['language']);
        $numSent = $oEmail->sendCampaignImpendingExpiryEmail($oTwoDaysPriorDate, $placementId);
        $aResult = $oEmail->prepareCampaignImpendingExpiryEmail($aAdvertiserUser, $advertiserId1, $placementId, $dateReason, $dateValue, 'advertiser');
        $this->assertEqual($numSent, 1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        $doUserLog = OA_Dal::factoryDO('userlog');
        $doUserLog->action = phpAds_actionWarningMailed;
        $aUserLog = $doUserLog->getAll();
        $this->assertEqual(count($aUserLog), 6);

        // Clear userlog table
        $doUserLog = OA_Dal::factoryDO('userlog');
        $doUserLog->whereAdd('1=1');
        $doUserLog->delete(DB_DATAOBJECT_WHEREADD_ONLY);

        // Enable the warn_email_advertiser preference and retest
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $advertiserAccountId;
        $doAccount_Preference_Assoc->preference_id = $warnEmailAdvertiserPreferenceId;
        $doAccount_Preference_Assoc->value = 1;
        $doAccount_Preference_Assoc->update();

        // So should now send 1 admin and 2 advertiser emails
        $numSent = $oEmail->sendCampaignImpendingExpiryEmail($oTwoDaysPriorDate, $placementId);
        $this->assertEqual($numSent, 3);

        $doUserLog = OA_Dal::factoryDO('userlog');
        $doUserLog->action = phpAds_actionWarningMailed;
        $aUserLog = $doUserLog->getAll();
        $this->assertEqual(count($aUserLog), 3);

        $expectedSubject = "Impending campaign expiration: $advertiserName";
        $expectedContents  = "Dear $adminContact,\n\n";
        $expectedContents .= "The campaign belonging to $advertiserName shown below has less than $impValue impressions remaining.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid=$placementId&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] Test Banner\n\n";
        $expectedContents .= " Banner [id$bannerId2] Test Banner\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $adminName, $adminCompany";

        $aResult = $oEmail->prepareCampaignImpendingExpiryEmail($aAdminUser, $advertiserId1, $placementId, $impReason, $impValue, 'admin');
        $numSent = $oEmail->sendCampaignImpendingExpiryEmail($oTwoDaysPriorDate, $placementId);
        $this->assertEqual($numSent, 3);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        $doUserLog = OA_Dal::factoryDO('userlog');
        $doUserLog->action = phpAds_actionWarningMailed;
        $aUserLog = $doUserLog->getAll();
        $this->assertEqual(count($aUserLog), 6);

        // Enable the warn_email_manager preference and retest
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $agencyAccountId;
        $doAccount_Preference_Assoc->preference_id = $warnEmailManagerPreferenceId;
        $doAccount_Preference_Assoc->value = 1;
        $doAccount_Preference_Assoc->update();
        $numSent = $oEmail->sendCampaignImpendingExpiryEmail($oTwoDaysPriorDate, $placementId);
        $this->assertEqual($numSent, 4);

        $doUserLog = OA_Dal::factoryDO('userlog');
        $doUserLog->action = phpAds_actionWarningMailed;
        $aUserLog = $doUserLog->getAll();
        $this->assertEqual(count($aUserLog), 10);

        // Turn off email logging and send mail again
        $aConf['email']['logOutgoing'] = false;
        $numSent = $oEmail->sendCampaignImpendingExpiryEmail($oTwoDaysPriorDate, $placementId);
        $this->assertEqual($numSent, 4);

        // No new entries in user log
        $doUserLog = OA_Dal::factoryDO('userlog');
        $doUserLog->action = phpAds_actionWarningMailed;
        $aUserLog = $doUserLog->getAll();
        $this->assertEqual(count($aUserLog), 10);

        // Set email logging back to true
        $aConf['email']['logOutgoing'] = true;

        $expectedSubject = "Impending campaign expiration: $advertiserName";
        $expectedContents  = "Dear {$aAdvertiserUser['contact_name']},\n\n";
        $expectedContents .= "Your campaign shown below has less than $impValue impressions remaining.\n\n";
        $expectedContents .= "As a result, the campaign will soon be automatically disabled, and the\n";
        $expectedContents .= "following banners in the campaign will also be disabled:\n";
        $expectedContents .= "\nCampaign [id$placementId] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid=$placementId&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] Test Banner\n\n";
        $expectedContents .= " Banner [id$bannerId2] Test Banner\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Regards,\n   $agencyContact, $agencyName";

        $aResult = $oEmail->prepareCampaignImpendingExpiryEmail($aAdvertiserUser, $advertiserId1, $placementId, $impReason, $impValue, 'advertiser');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        // Check that advertiser2's email is send in their desired language (german)
        $expectedSubject = "Bevorstehende Deaktivierung der Kampagne: $advertiserName";
        $expectedContents  = "Sehr geehrte(r) {$aAdvertiserUser2['contact_name']},\n\n";
        $expectedContents .= "Unten angegebene Ihre Kampagne hat weniger als {$impValue} Impressions �brig.\n\n";
        $expectedContents .= "Auf Grund dessen wird die Kampagne bald deaktiviert und weiter unten angegebene Banner aus dieser Kampagne werden deaktiviert.\n";
        $expectedContents .= "\nKampagne [id$placementId] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid=$placementId&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "-------------------------------------------------------\n\n";
        $expectedContents .= " Banner [id$bannerId1] Test Banner\n\n";
        $expectedContents .= " Banner [id$bannerId2] Test Banner\n";
        $expectedContents .= "  verknüpft mit: http://www.fornax.net/\n\n";
        $expectedContents .= "-------------------------------------------------------\n\n\n";
        $expectedContents .= "Mit freundlichem Gruß\n   $agencyContact, $agencyName";
        $aResult = $oEmail->prepareCampaignImpendingExpiryEmail($aAdvertiserUser2, $advertiserId1, $placementId, $impReason, $impValue, 'advertiser');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        DataGenerator::cleanUp(array('accounts','account_user_assoc'));
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
        $aConf['email']['useManagerDetails'] = true;
        $aConf['email']['logOutgoing']  = true;

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
        $doClients->email      = 'advertiser_default@example.com';
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
        $doPlacements->campaignname = 'Default Campaign';
        $placementId = DataGenerator::generateOne($doPlacements);

        // Prepare banners
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId;
        $doBanners->description = 'Test Banner';
        $doBanners->url        = '';
        $bannerId1 = DataGenerator::generateOne($doBanners);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $placementId;
        $doBanners->description = 'Test Banner';
        $doBanners->url        = 'http://www.fornax.net/';
        $bannerId2 = DataGenerator::generateOne($doBanners);

        // Two copy should be sent (different emails addresses)
        // One copy to the user and another one to the Advertiser
        $result = $oEmail->sendCampaignActivatedDeactivatedEmail($placementId);
        $this->assertEqual($result, 2);

        $doUserLog = OA_Dal::factoryDO('userlog');
        $aUserLog = $doUserLog->getAll();
        $this->assertEqual(count($aUserLog), 2);
        $this->assertEqual($aUserLog[0]['action'], phpAds_actionActivationMailed);

        // Turn off email logging and send mail again
        $aConf['email']['logOutgoing'] = false;
        $result = $oEmail->sendCampaignActivatedDeactivatedEmail($placementId);
        $this->assertEqual($result, 2);

        // No new entries in user log
        $doUserLog = OA_Dal::factoryDO('userlog');
        $aUserLog = $doUserLog->getAll();
        $this->assertEqual(count($aUserLog), 2);

        // Set email logging back to true
        $aConf['email']['logOutgoing'] = true;

        $aResult = $oEmail->prepareCampaignActivatedDeactivatedEmail($aAdvertiserUser, $placementId);

        // Check the contents of the generated email are correct
        $expectedSubject = 'Campaign activated: Foo Client';
        $expectedContents  = "Dear {$aAdvertiserUser['contact_name']},\n\n";
        $expectedContents .= 'Your campaign shown below has been activated because'. "\n";
        $expectedContents .= 'the campaign activation date has been reached.' . "\n";
        $expectedContents .= "\nCampaign [id$placementId] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid={$placementId}&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$bannerId1] Test Banner\n\n";
        $expectedContents .= " Banner  [id$bannerId2] Test Banner\n";
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
        $expectedContents .= "\nCampaign [id$placementId] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid={$placementId}&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$bannerId1] Test Banner\n\n";
        $expectedContents .= " Banner  [id$bannerId2] Test Banner\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "\n";
        $expectedContents .= "Regards,\n   {$agencyContact}, {$agencyName}";
        $aResult = $oEmail->prepareCampaignActivatedDeactivatedEmail($aAdvertiserUser, $placementId, OX_CAMPAIGN_DISABLED_IMPRESSIONS);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        $aResult = $oEmail->prepareCampaignActivatedDeactivatedEmail($aAdvertiserUser, $placementId, OX_CAMPAIGN_DISABLED_CLICKS);
        $expectedSubject = 'Campaign deactivated: Foo Client';
        $expectedContents  = "Dear {$aAdvertiserUser['contact_name']},\n\n";
        $expectedContents .= 'Your campaign shown below has been deactivated because:'. "\n";
        $expectedContents .= '  - there are no Clicks remaining.' . "\n";
        $expectedContents .= "\nCampaign [id$placementId] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid={$placementId}&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$bannerId1] Test Banner\n\n";
        $expectedContents .= " Banner  [id$bannerId2] Test Banner\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "\n";
        $expectedContents .= "Regards,\n   {$agencyContact}, {$agencyName}";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        $aResult = $oEmail->prepareCampaignActivatedDeactivatedEmail($aAdvertiserUser, $placementId, OX_CAMPAIGN_DISABLED_CONVERSIONS);
        $expectedSubject = 'Campaign deactivated: Foo Client';
        $expectedContents  = "Dear {$aAdvertiserUser['contact_name']},\n\n";
        $expectedContents .= 'Your campaign shown below has been deactivated because:'. "\n";
        $expectedContents .= '  - there are no Sales remaining.' . "\n";
        $expectedContents .= "\nCampaign [id$placementId] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid={$placementId}&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$bannerId1] Test Banner\n\n";
        $expectedContents .= " Banner  [id$bannerId2] Test Banner\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "\n";
        $expectedContents .= "Regards,\n   {$agencyContact}, {$agencyName}";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        $aResult = $oEmail->prepareCampaignActivatedDeactivatedEmail($aAdvertiserUser, $placementId, OX_CAMPAIGN_DISABLED_DATE);
        $expectedSubject = 'Campaign deactivated: Foo Client';
        $expectedContents  = "Dear {$aAdvertiserUser['contact_name']},\n\n";
        $expectedContents .= 'Your campaign shown below has been deactivated because:'. "\n";
        $expectedContents .= '  - the expiration date has been reached.' . "\n";
        $expectedContents .= "\nCampaign [id$placementId] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid={$placementId}&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$bannerId1] Test Banner\n\n";
        $expectedContents .= " Banner  [id$bannerId2] Test Banner\n";
        $expectedContents .= "  linked to: http://www.fornax.net/\n\n";
        $expectedContents .= "\n";
        $expectedContents .= "Regards,\n   {$agencyContact}, {$agencyName}";
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult['subject'],   $expectedSubject);
        $this->assertEqual($aResult['contents'],  $expectedContents);

        $reason = 0 | OX_CAMPAIGN_DISABLED_IMPRESSIONS | OX_CAMPAIGN_DISABLED_CLICKS | OX_CAMPAIGN_DISABLED_DATE;
        $aResult = $oEmail->prepareCampaignActivatedDeactivatedEmail($aAdvertiserUser, $placementId, $reason);
        $expectedSubject = 'Campaign deactivated: Foo Client';
        $expectedContents  = "Dear {$aAdvertiserUser['contact_name']},\n\n";
        $expectedContents .= 'Your campaign shown below has been deactivated because:'. "\n";
        $expectedContents .= '  - there are no Impressions remaining' . "\n";
        $expectedContents .= '  - there are no Clicks remaining' . "\n";
        $expectedContents .= '  - the expiration date has been reached.' . "\n";
        $expectedContents .= "\nCampaign [id$placementId] Default Campaign\n";
        $expectedContents .= "http://{$aConf['webpath']['admin']}/stats.php?clientid=$advertiserId1&campaignid={$placementId}&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=\n";
        $expectedContents .= "=======================================================\n\n";
        $expectedContents .= " Banner  [id$bannerId1] Test Banner\n\n";
        $expectedContents .= " Banner  [id$bannerId2] Test Banner\n";
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