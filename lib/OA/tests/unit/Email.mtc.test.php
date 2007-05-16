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

        $aConf['admin_fullname'] = 'Openads Ltd.';

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
     * Tests that an e-mail advising a placement has been activated is able to
     * be generated correctly.
     */
    function testPrepareActivatePlacementEmail()
    {
        $contactName = 'Andrew Hill';
        $placementName = 'Test Activation Placement';
        $ads[0] = array('First Test Banner', '', 'http://example.com/');
        $ads[1] = array('Second Test Banner', 'Alt. Description', 'http://example.com/');
        $ads[2] = array('', 'Third Test Banner', 'http://example.com/foo/bar.html');
        $ads[3] = array('', '', 'http://example.com/foo.html');
        $email = OA_Email::prepareActivatePlacementEmail($contactName, $placementName, $ads);
        $desiredEmail  = 'Dear Andrew Hill,' . "\n\n";
        $desiredEmail .= 'The following ads have been activated because '. "\n";
        $desiredEmail .= 'the placement activation date has been reached.' . "\n\n";
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
        $desiredEmail .= $conf['email']['admin_name'];
        $this->assertEqual($email, $desiredEmail);
    }

    /**
     * Tests that e-mails advising a placement has been deactivated is able to
     * be generated correctly.
     */
    function testSendDeactivatePlacementEmail()
    {
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
        $desiredEmail .= $conf['email']['admin_name'];
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
        $desiredEmail .= $conf['email']['admin_name'];
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
        $desiredEmail .= $conf['email']['admin_name'];
        $this->assertEqual($email, $desiredEmail);
        $email = OA_Email::prepareDeactivatePlacementEmail($contactName, $placementName, 16, $ads);
        $desiredEmail  = 'Dear Andrew Hill,' . "\n\n";
        $desiredEmail .= 'The following ads have been disabled because:' . "\n";
        $desiredEmail .= '  - The placement deactivation date has been reached' . "\n\n";
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
        $desiredEmail .= $conf['email']['admin_name'];
        $this->assertEqual($email, $desiredEmail);
        $value = 0 | 2 | 4 | 8 | 16;
        $email = OA_Email::prepareDeactivatePlacementEmail($contactName, $placementName, $value, $ads);
        $desiredEmail  = 'Dear Andrew Hill,' . "\n\n";
        $desiredEmail .= 'The following ads have been disabled because:' . "\n";
        $desiredEmail .= '  - There are no impressions remaining' . "\n";
        $desiredEmail .= '  - There are no clicks remaining' . "\n";
        $desiredEmail .= '  - There are no conversions remaining' . "\n";
        $desiredEmail .= '  - The placement deactivation date has been reached' . "\n\n";
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
        $desiredEmail .= $conf['email']['admin_name'];
        $this->assertEqual($email, $desiredEmail);
    }

}

?>