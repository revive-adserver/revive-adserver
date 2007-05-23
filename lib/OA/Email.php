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

require_once MAX_PATH . '/lib/max/Admin/Preferences.php';
require_once MAX_PATH . '/lib/max/language/Default.php';
require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once 'Date.php';

/**
 * A class to provide support for sending of email-based reports and
 * alerts.
 *
 * @package    Openads
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class OA_Email
{

    /**
     * A static method for preparing an advertiser's "placement delivery" report
     * email.
     *
     * @static
     * @param integer    $advertiserId The advertiser's ID.
     * @param PEAR::Date $oStartDate   The start date of the report, inclusive.
     * @param PEAR::Date $oEndDate     The end date of the report, inclusive.
     * @return boolean|array False, if the report could not be created, otherwise
     *                       an array of four elements:
     *                          'subject'   => The email subject line.
     *                          'contents'  => The body of the email report.
     *                          'userEmail' => The email address to send the report to.
     *                          'userName'  => The real name of the email address, or null.
     *
     * @copyright 2003-2007 Openads Limited
     * @copyright 2000-2003 The phpAdsNew developers
     */
    function preparePlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate)
    {
        OA::debug('   - Preparing "placement delivery" report for advertiser ID ' . $advertiserId . '.', PEAR_LOG_DEBUG);
        $aPref = OA_Email::_loadPrefs();
        Language_Default::load();

        // Load the required strings
        global $strMailHeader, $strSirMadam, $strMailBannerStats, $strMailReportPeriodAll,
               $strMailReportPeriod, $date_format, $strMailSubject;

        // Prepare the result array
        $aResult = array(
            'subject'   => '',
            'contents'  => '',
            'userEmail' => '',
            'userName'  => null
        );

        // Get the advertiser's details
        $aAdvertiser = OA_Email::_loadAdvertiser($advertiserId);
        if ($aAdvertiser === false) {
            return false;
        }

        // Check the advertiser wants to have reports sent
        if ($aAdvertiser['report'] != 't') {
            OA::debug('   - Reports disabled for advertiser ID ' . $advertiserId . '.', PEAR_LOG_ERR);
            return false;
        }
        // Does the advertiser have an email address?
        if (empty($aAdvertiser['email'])) {
            OA::debug('   - No email for advertiser ID ' . $advertiserId . '.', PEAR_LOG_ERR);
            return false;
        }

        // Prepare the email body
        $emailBody = OA_Email::_preparePlacementDeliveryEmailBody($advertiserId, $oStartDate, $oEndDate);

        // Was anything found?
        if ($emailBody == '') {
            OA::debug('   - No placements with delivery for advertiser ID ' . $advertiserId . '.', PEAR_LOG_DEBUG);
            return false;
        }

        // Prepare the final email - add the greeting to the advertiser
        $email = "$strMailHeader\n";
        if (!empty($aAdvertiser['contact'])) {
            $greetingTo = $aAdvertiser['contact'];
        } else if (!empty($aAdvertiser['clientname'])) {
            $greetingTo = $aAdvertiser['clientname'];
        } else {
            $greetingTo = $strSirMadam;
        }
        $email = str_replace("{contact}", $greetingTo, $email);

        // Prepare the final email - add the report type description
        // and the name of the advertiser the report is about
        $email .= "$strMailBannerStats\n";
        $email = str_replace("{clientname}", $aAdvertiser['clientname'], $email);

        // Prepare the final email - add the report period span
        if (is_null($oStartDate)) {
            $email .= "$strMailReportPeriodAll\n\n";
        } else {
            $email .= "$strMailReportPeriod\n\n";
        }
        $email = str_replace("{startdate}", (is_null($oStartDate) ? '' : $oStartDate->format($date_format)), $email);
        $email = str_replace("{enddate}", $oEndDate->format($date_format), $email);

        // Prepare the final email - add the report body
        $email .= "$emailBody\n";

        // Prepare the final email - add the "regards" signature
        $email .= OA_Email::_prepareRegards($aAdvertiser['agencyid']);

        // Prepare & return the final email array
        $aResult['subject']   = $strMailSubject . ': ' . $aAdvertiser['clientname'];
        $aResult['contents']  = $email;
        $aResult['userEmail'] = $aAdvertiser['email'];
        $aResult['userName']  = $aAdvertiser['contact'];
        return $aResult;
    }

    /**
     * A private, static method to prepare the body of an advertiser's "placement delivery"
     * report email.
     *
     * @access private
     * @static
     * @param integer    $advertiserId The advertiser's ID.
     * @param PEAR::Date $oStartDate   The start date of the report, inclusive.
     * @param PEAR::Date $oEndDate     The end date of the report, inclusive.
     */
    function _preparePlacementDeliveryEmailBody($advertiserId, $oStartDate, $oEndDate)
    {
        // Load the preferences and default language
        $aPref = OA_Email::_loadPrefs();
        Language_Default::load();

        // Load the "Campaign" and "Banner" strings, and prepare formatting strings
        global $strCampaign, $strBanner;
        $strCampaignLength = strlen($strCampaign);
        $strBannerLength   = strlen($strBanner);
        $maxLength         = max($strCampaignLength, $strBannerLength);
        $strCampaignPrint  = '%-'  . $maxLength . 's';
        $strBannerPrint    = ' %-'  . ($maxLength - 1) . 's';

        // Load the impression, click and conversion delivery strings, and
        // prepare formatting strings
        global $strImpressions, $strClicks, $strConversions, $strTotal,
               $strTotalThisPeriodLength;
        $strTotalImpressions       = $strImpressions . ' (' . $strTotal . ')';
        $strTotalClicks            = $strClicks      . ' (' . $strTotal . ')';
        $strTotalConversions       = $strConversions . ' (' . $strTotal . ')';
        $strTotalImpressionsLength = strlen($strTotalImpressions);
        $strTotalClicksLength      = strlen($strTotalClicks);
        $strTotalConversionsLength = strlen($strTotalConversions);
        $strTotalThisPeriodLength  = strlen($strTotalThisPeriod);
        $maxLength   = max($strTotalImpressionsLength, $strTotalClicksLength, $strTotalConversionsLength, $strTotalThisPeriodLength);
        $adTextPrint = ' %'  . $maxLength . 's';

        // Load remaining required strings
        global $strLinkedTo, $strNoStatsForCampaign;

        // Prepare the result
        $emailBody = '';

        // Fetch all the advertiser's placements
        $doPlacements = OA_Dal::factoryDO('campaigns');
        $doPlacements->clientid = $advertiserId;
        $doPlacements->find();
        if ($doPlacements->getRowCount() > 0) {
            while ($doPlacements->fetch()) {
                $aPlacement = $doPlacements->toArray();
                // Add the name of the placement to the report
                $emailBody .= "\n" . sprintf($strCampaignPrint, $strCampaign) . ' ';
                $emailBody .= strip_tags(phpAds_buildName($aPlacement['campaignid'], $aPlacement['campaignname'])) . "\n";
                // Add a URL link to the placement
                $page = 'campaign-edit.php?clientid=' . $advertiserId . '&campaignid=' . $aPlacement['campaignid'];
                $emailBody .= MAX::constructURL(MAX_URL_ADMIN, $page) . "\n";
                // Add a nice divider
                $emailBody .= "=======================================================\n\n";
                // Fetch all ads in the placement
                $doBanners = OA_Dal::factoryDO('banners');
                $doBanners->campaignid = $aPlacement['campaignid'];
                $doBanners->find();
                if ($doBanners->getRowCount() > 0) {
                    $adsWithDelivery = false;
                    while ($doBanners->fetch()) {
                        $aAd = $doBanners->toArray();
                        // Get the total impressions, clicks and conversions delivered by this ad
                        $adImpressions = phpAds_totalViews($aAd['bannerid']);
                        $adClicks      = phpAds_totalClicks($aAd['bannerid']);
                        $adConversions = phpAds_totalConversions($aAd['bannerid']);
                        if ($adImpressions > 0 || $adClicks > 0 || $adConversions > 0) {
                            $adsWithDelivery = true;
                            // This ad has delivered at some stage, add the name of the ad to the report
                            $emailBody .= sprintf($strBannerPrint, $strBanner) . ' ';
                            $emailBody .= strip_tags(phpAds_buildBannerName($aAd['bannerid'], $aAd['description'], $aAd['alt'])) . "\n";
                            // If the ad has a URL, add the URL the add is linked to to the report
                            if (!empty($aAd['URL'])) {
                                $emailBody .= $strLinkedTo . ': ' . $aAd['URL'] . "\n";
                            }
                            // Add a divider before the ad's stats
                            $emailBody .= " ------------------------------------------------------\n";
                            $adHasStats = false;
                            if ($adImpressions > 0) {
                                // The ad has impressions
                                $adHasStats = true;
                                $emailBody .= sprintf($adTextPrint, $strTotalImpressions) . ': ';
                                $emailBody .= sprintf('%15s', phpAds_formatNumber($adImpressions)) . "\n";
                                // Fetch the ad's impressions for the report period, grouped by day
                                $emailBody .= OA_Email::_preparePlacementDeliveryEmailBodyStats($aAd['bannerid'], $oStartDate, $oEndDate, 'impressions', $adTextPrint);
                            }
                            if ($adClicks > 0) {
                                // The ad has clicks
                                $adHasStats = true;
                                $emailBody .= "\n" . sprintf($adTextPrint, $strTotalClicks) . ': ';
                                $emailBody .= sprintf('%15s', phpAds_formatNumber($adClicks)) . "\n";
                                // Fetch the ad's clicks for the report period, grouped by day
                                $emailBody .= OA_Email::_preparePlacementDeliveryEmailBodyStats($aAd['bannerid'], $oStartDate, $oEndDate, 'clicks', $adTextPrint);
                            }
                            if ($adConversions > 0) {
                                // The ad has conversions
                                $adHasStats = true;
                                $emailBody .= "\n" . sprintf($adTextPrint, $strTotalConversions) . ': ';
                                $emailBody .= sprintf('%15s', phpAds_formatNumber($adConversions)) . "\n";
                                // Fetch the ad's conversions for the report period, grouped by day
                                $emailBody .= OA_Email::_preparePlacementDeliveryEmailBodyStats($aAd['bannerid'], $oStartDate, $oEndDate, 'conversions', $adTextPrint);
                            }
                            $emailBody .= "\n";
                        }
                    }
                }
                // Did the placement have any stats?
                if ($adsWithDelivery != true) {
                    $emailBody .= $strNoStatsForCampaign . "\n\n\n";
                }
            }
        }

        // Return the email body
        return $emailBody;
    }

    /**
     * A private, static method to prepare the statistics part of the body of an
     * advertiser's "placement delivery" report email.
     *
     * @access private
     * @static
     * @param integer    $advertiserId The advertiser's ID.
     * @param PEAR::Date $oStartDate   The start date of the report, inclusive.
     * @param PEAR::Date $oEndDate     The end date of the report, inclusive.
     * @param string     $type         One of "impressions", "clicks" or "conversions".
     * @param string     $adTextPrint  An sprintf compatible formatting string for use
     *                                 with the $strTotalThisPeriod global string.
     * @return string The ad statistics part of the report.
     */
    function _preparePlacementDeliveryEmailBodyStats($adId, $oStartDate, $oEndDate, $type, $adTextPrint)
    {
        $oDbh =& OA_DB::singleton();

        // Load the preferences and default language
        $aPref = OA_Email::_loadPrefs();
        Language_Default::load();

        // Obtain the required date format
        global $date_format;

        // Obtain the impressions, clicks and conversions string, and prepare
        // these strings for use, including formatting strings
        global $strNoViewLoggedInInterval, $strNoClickLoggedInInterval, $strNoConversionLoggedInInterval,
               $strTotalThisPeriod;

        if ($type == 'impressions') {
            $nothingLogged = $strNoViewLoggedInInterval;
        } else if ($type == 'clicks') {
            $nothingLogged = $strNoClickLoggedInInterval;
        } else if ($type == 'conversions') {
            $nothingLogged = $strNoConversionLoggedInInterval;
        } else {
            return '';
        }

        // Prepare the result
        $emailBodyStats = '';

        // Fetch the ad's stats for the report period, grouped by day
        $doDataSummaryAdHourly = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->selectAdd("SUM($type) as quantity");
        $doDataSummaryAdHourly->selectAdd("DATE_FORMAT(day, '$date_format') as t_stamp_f");
        $doDataSummaryAdHourly->ad_id = $adId;
        $doDataSummaryAdHourly->whereAdd('impressions > 0');
        if (!is_null($oStartDate)) {
            $doDataSummaryAdHourly->whereAdd('day >= ' . $oDbh->quote($oStartDate->format('%Y-%m-%d'), 'timestamp'));
        }
        $doDataSummaryAdHourly->whereAdd('day <= ' . $oDbh->quote($oEndDate->format('%Y-%m-%d'), 'timestamp'));
        $doDataSummaryAdHourly->groupBy('day');
        $doDataSummaryAdHourly->orderBy('day DESC');
        $doDataSummaryAdHourly->find();
        if ($doDataSummaryAdHourly->getRowCount() > 0) {
            // The ad has statistics this period, add them to the report
            $total = 0;
            while ($doDataSummaryAdHourly->fetch()) {
                // Add this day's statistics
                $aAdQuantity = $doDataSummaryAdHourly->toArray();
                $emailBodyStats .= sprintf($adTextPrint, $aAdQuantity['t_stamp_f']) . ': ';
                $emailBodyStats .= sprintf('%15s', phpAds_formatNumber($aAdQuantity['quantity'])) . "\n";
                $total += $aAdQuantity['quantity'];
            }
            // Add the total statistics for the period
            $emailBodyStats .= sprintf($adTextPrint, $strTotalThisPeriod) . ': ';
            $emailBodyStats .= sprintf('%15s', phpAds_formatNumber($total)) . "\n";
        } else {
            // Simply note that there were no statistics this period
            $emailBodyStats .= '  ' . $nothingLogged . "\n";
        }

        // Return the result for the ad's stats
        return $emailBodyStats;
    }

    /**
     * A static method for preparing an advertiser's "impending placement expiry" report.
     *
     * @static
     * @param integer $advertiserId The advertiser's ID.
     * @param integer $placementId  The advertiser's ID.
     * @param string  $reason       The reason for expiration. One of:
     *                              "date", "impressions".
     * @param mixed   $value        The limit reason (ie. the date or value limit)
     *                              used to decide that the placement is about to
     *                              expire.
     * @return boolean|array False, if the report could not be created, otherwise
     *                       an array or arrays of four elements:
     *                          'subject'   => The email subject line.
     *                          'contents'  => The body of the email report.
     *                          'userEmail' => The email address to send the report to.
     *                          'userName'  => The real name of the email address, or null.
     */
    function prepareplacementImpendingExpiryEmail($advertiserId, $placementId, $reason, $value)
    {
        OA::debug('   - Preparing "impending expiry" report for advertiser ID ' . $advertiserId . '.', PEAR_LOG_DEBUG);
        $aPref = OA_Email::_loadPrefs();
        Language_Default::load();

        // Load the required strings
        global $strImpendingCampaignExpiryDateBody, $strImpendingCampaignExpiryImpsBody, $strMailHeader,
               $strSirMadam, $strTheCampiaignBelongingTo, $strYourCampaign, $strImpendingCampaignExpiryBody,
               $strMailFooter, $strImpendingCampaignExpiry;

        // Prepare the result array
        $aResult = array();

        // Prepare the sub-result array
        $aSubResult = array(
            'subject'   => '',
            'contents'  => '',
            'userEmail' => '',
            'userName'  => null
        );

        // Prepare the expiration email body
        if ($reason == 'date') {
            $reason = $strImpendingCampaignExpiryDateBody;
        } else if ($reason == 'impressions') {
            $reason = $strImpendingCampaignExpiryImpsBody;
        } else {
            return false;
        }

        // Prepare the array of users that want warning emails
        $aUsers = array();
        if ($aPref['warn_admin'] == 't') {
            $aUsers['admin'] = 'admin';
        }
        if ($aPref['warn_agency'] == 't') {
            $aUsers['agency'] = 'agency';
        }
        if ($aPref['warn_client'] == 't') {
            $aUsers['advertiser'] = 'advertiser';
        }
        if (empty($aUsers)) {
            return false;
        }

        // Get the advertiser's details
        $aAdvertiser = OA_Email::_loadAdvertiser($advertiserId);
        if ($aAdvertiser === false) {
            return false;
        }

        // Is warning the agency is set, is the agency ID the same as the admin ID?
        if (isset($aUsers['agency']) && $aAdvertiser['agencyid'] == 0) {
            OA::debug('   - Advertiser ID ' . $advertiserId . ' is owned by admin, no need to warn agency.', PEAR_LOG_ERR);
            $aUsers['admin'] = 'admin';
            unset($aUsers['agency']);
        }

        // Get & test the admin user's email address details, if required
        if (isset($aUsers['admin'])) {
            $aAdminOwner = OA_Email::_loadAdminPreferences();
            if ($aAdminOwner === false) {
                unset($aUsers['admin']);
            } else if (empty($aAdminOwner['admin_email'])) {
                OA::debug('   - No email for admin.', PEAR_LOG_ERR);
                unset($aUsers['admin']);
            }
        }

        // Get & test the agency user's email address details, if required
        if (isset($aUsers['agency'])) {
            $aAgencyOwner = OA_Email::_loadAgency($aAdvertiser['agencyid']);
            if ($aAgencyOwner === false) {
                unset($aUsers['agency']);
            } else if (empty($aAgencyOwner['email'])) {
                OA::debug('   - No email for agency.', PEAR_LOG_ERR);
                unset($aUsers['agency']);
            }
        }

        // Test the advertiser's email address details, if required
        if (isset($aUsers['advertiser'])) {
            if (empty($aAdvertiser['email'])) {
                OA::debug('   - No email for advertiser ID ' . $advertiserId . '.', PEAR_LOG_ERR);
                unset($aUsers['advertiser']);
            }
        }

        // Re-test that there is still at least one user to report to
        if (empty($aUsers)) {
            return false;
        }

        // Double-check that the placement ID is owned by the advertiser
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignid = $placementId;
        $doCampaigns->find();
        if (!$doCampaigns->fetch()) {
            return false;
        }
        $aPlacement = $doCampaigns->toArray();
        if ($aPlacement['clientid'] != $advertiserId) {
            return false;
        }

        // Prepare the email body
        $emailBody  = OA_Email::_prepareplacementImpendingExpiryEmailBody($advertiserId, $aPlacement);

        // Was anything found?
        if ($emailBody == '') {
            OA::debug('   - No placements with delivery for advertiser ID ' . $advertiserId . '.', PEAR_LOG_DEBUG);
            return false;
        }

        foreach ($aUsers as $user) {
            // Prepare the final email - add the greeting to the user
            $email = "$strMailHeader\n";
            if ($user == 'admin') {
                if (!empty($aAdminOwner['admin_fullname'])) {
                    $contactName = $aAdminOwner['admin_fullname'];
                } else if (!empty($aAdminOwner['company_name'])) {
                    $contactName = $aAdminOwner['company_name'];
                } else {
                    $contactName = $strSirMadam;
                }
            } else if ($user == 'agency') {
                if (!empty($aAgencyOwner['contact'])) {
                    $contactName = $aAgencyOwner['contact'];
                } else if (!empty($aAgencyOwner['name'])) {
                    $contactName = $aAgencyOwner['name'];
                } else {
                    $contactName = $strSirMadam;
                }
            } else if ($user == 'advertiser') {
                if (!empty($aAdvertiser['contact'])) {
                    $contactName = $aAdvertiser['contact'];
                } else if (!empty($aAdvertiser['clientname'])) {
                    $contactName = $aAdvertiser['clientname'];
                } else {
                    $contactName = $strSirMadam;
                }
            }
            $email = str_replace("{contact}", $contactName, $email);

            // Prepare the final email - add the report type description
            // and the name of the advertiser the report is about
            $email .= $reason . "\n\n";
            if ($user == 'admin') {
                $campaignReplace = $strTheCampiaignBelongingTo . ' ' . trim($aAdvertiser['clientname']);
            } else if ($user == 'agency') {
                $campaignReplace = $strTheCampiaignBelongingTo . ' ' . trim($aAdvertiser['clientname']);
            } else if ($user == 'advertiser') {
                $campaignReplace = $strYourCampaign;
            }
            $email = str_replace("{clientname}", $campaignReplace, $email);
            $email = str_replace("{date}",  $value, $email);
            $email = str_replace("{limit}", $value, $email);
            $email .= $strImpendingCampaignExpiryBody . "\n\n";

            // Prepare the final email - add the report body
            $email .= "$emailBody\n";

            // Prepare the final email - add the "regards" signature
            if ($user == 'admin') {
                $email .= OA_Email::_prepareRegards(0);
            } else {
                $email .= OA_Email::_prepareRegards($aAdvertiser['agencyid']);
            }

            // Prepare the user's final email array
            $aSubResult['subject']   = $strImpendingCampaignExpiry . ': ' . $aAdvertiser['clientname'];
            $aSubResult['contents']  = $email;
            if ($user == 'admin') {
                $aSubResult['userEmail'] = $aAdminOwner['admin_email'];
                $aSubResult['userName']  = $aAdminOwner['admin_fullname'];
            } else if ($user == 'agency') {
                $aSubResult['userEmail'] = $aAgencyOwner['email'];
                $aSubResult['userName']  = $aAgencyOwner['contact'];
            } else if ($user == 'advertiser') {
                $aSubResult['userEmail'] = $aAdvertiser['email'];
                $aSubResult['userName']  = $aAdvertiser['contact'];
            }

            // Store the final email array
            $aResult[] = $aSubResult;
        }

        // Return the emails to be sent
        return $aResult;
    }

    /**
     * A private, static method to prepare the body of an advertiser's "impending placement
     * expiry" report email.
     *
     * @access private
     * @static
     * @param integer $advertiserId The advertiser's ID.
     * @param array   $aPlacement   The placement details.
     */
    function _prepareplacementImpendingExpiryEmailBody($advertiserId, $aPlacement)
    {
        // Load the preferences and default language
        $aPref = OA_Email::_loadPrefs();
        Language_Default::load();

        // Load required strings
        global $strCampaign, $strBanner, $strLinkedTo, $strNoBanners;

        // Prepare the result
        $emailBody = '';

        // Add the name of the placement to the report
        $emailBody .= $strCampaign . ' ';
        $emailBody .= strip_tags(phpAds_buildName($aPlacement['campaignid'], $aPlacement['campaignname'])) . "\n";
        // Add a URL link to the placement
        $page = 'campaign-edit.php?clientid=' . $advertiserId . '&campaignid=' . $aPlacement['campaignid'];
        $emailBody .= MAX::constructURL(MAX_URL_ADMIN, $page) . "\n";
        // Add a separator after the placement and before the ads
        $emailBody .= "-------------------------------------------------------\n\n";
        // Get the ads in the placement
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $aPlacement['campaignid'];
        $doBanners->find();
        if ($doBanners->getRowCount() > 0) {
            // List the ads that will be deactivated along with the placement
            while ($doBanners->fetch()) {
                $aAd = $doBanners->toArray();
                $emailBody .= ' ' . $strBanner . ' ';
                $emailBody .= strip_tags(phpAds_buildBannerName($aAd['bannerid'], $aAd['description'], $aAd['alt'])) . "\n";
                // If the ad has a URL, add the URL the add is linked to to the report
                if (!empty($aAd['url'])) {
                    $emailBody .= '  ' . $strLinkedTo . ': ' . $aAd['url'] . "\n";
                }
                $emailBody .= "\n";
            }
        } else {
            // No ads in the placement!
            $emailBody .= ' ' . $strNoBanners . "\n\n";
        }
        // Add closing divider
        $emailBody .= "-------------------------------------------------------\n\n";

        // Return the email body
        return $emailBody;
    }

    /**
     * A static method for premaring e-mails, advising of the activation of a
     * placement.
     *
     * @static
     * @param string $contactName   The name of the placement contact.
     * @param string $placementName The name of the deactivated placement.
     * @param array  $aAds          An array of ads in the placement, indexed by
     *                              ad_id, of an array containing the description,
     *                              alt description, and destination URL of the ad.
     * @return string The email that has been prepared.
     */
    function prepareActivatePlacementEmail($contactName, $placementName, $aAds)
    {
        OA::debug('   - Preparing "placement activation" email for advertiser ID ' . $placementId. '.', PEAR_LOG_DEBUG);
        $aPref = OA_Email::_loadPrefs();
        Language_Default::load();

        $message  = "Dear $contactName,\n\n";
        $message .= 'The following ads have been activated because ' . "\n";
        $message .= 'the campaign activation date has been reached.';
        $message .= "\n\n";
        $message .= "-------------------------------------------------------\n";
        foreach ($aAds as $ad_id => $aData) {
            $message .= "Ad [ID $ad_id] ";
            if ($aData[0] != '') {
                $message .= $aData[0];
            } elseif ($aData[1] != '') {
                $message .= $aData[1];
            } else {
                $message .= 'Untitled';
            }
            $message .= "\n";
            $message .= "Linked to: {$aData[2]}\n";
            $message .= "-------------------------------------------------------\n";
        }
        $message .= "\nThank you for advertising with us.\n\n";
        $message .= "Regards,\n\n";
        $message .= $aPref['admin_fullname'];
        return $message;
    }

    /**
     * A static method for preparing e-mails, advising of the deactivation of a
     * placement.
     *
     * @static
     * @param string  $contactName   The name of the placement contact.
     * @param string  $placementName The name of the deactivated placement.
     * @param integer $reason        A binary flag field containting the reason(s) the
     *                               placement was deactivated:
     *                                   2  - No more impressions
     *                                   4  - No more clicks
     *                                   8  - No more conversions
     *                                   16 - Placement ended (due to date)
     * @param array   $aAds          An array of ads in the placement, indexed by
     *                               ad_id, of an array containing the description,
     *                               alt description, and destination URL of the ad.
     * @return string The email that has been prepared.
     */
    function prepareDeactivatePlacementEmail($contactName, $placementName, $reason, $aAds)
    {
        OA::debug('   - Preparing "placement deactivation" email for advertiser ID ' . $placementId. '.', PEAR_LOG_DEBUG);
        $aPref = OA_Email::_loadPrefs();
        Language_Default::load();

        $message  = "Dear $contactName,\n\n";
        $message .= 'The following ads have been disabled because:' . "\n";
        if ($reason & MAX_PLACEMENT_DISABLED_IMPRESSIONS) {
            $message .= '  - There are no impressions remaining' . "\n";
        }
        if ($reason & MAX_PLACEMENT_DISABLED_CLICKS) {
            $message .= '  - There are no clicks remaining' . "\n";
        }
        if ($reason & MAX_PLACEMENT_DISABLED_CONVERSIONS) {
            $message .= '  - There are no conversions remaining' . "\n";
        }
        if ($reason & MAX_PLACEMENT_DISABLED_DATE) {
            $message .= '  - The campaign deactivation date has been reached' . "\n";
        }
        $message .= "\n";
        $message .= '-------------------------------------------------------' . "\n";
        foreach ($aAds as $ad_id => $aData) {
            $message .= "Ad [ID $ad_id] ";
            if ($aData[0] != '') {
                $message .= $aData[0];
            } elseif ($aData[1] != '') {
                $message .= $aData[1];
            } else {
                $message .= 'Untitled';
            }
            $message .= "\n";
            $message .= "Linked to: {$aData[2]}\n";
            $message .= '-------------------------------------------------------' . "\n";
        }
        $message .= "\n" . 'If you would like to continue advertising on our website,' . "\n";
        $message .= 'please feel free to contact us.' . "\n";
        $message .= 'We\'d be glad to hear from you.' . "\n\n";
        $message .= 'Regards,' . "\n\n";
        $message .= "{$aPref['admin_fullname']}";
        return $message;
    }

    /**
     * A private, static method to load the preferences required when generating reports.
     *
     * @access private
     * @static
     * @return array The loaded preference array.
     */
    function _loadPrefs()
    {
        $aPref = $GLOBALS['_MAX']['PREF'];
        if (is_null($aPref)) {
            $aPref = MAX_Admin_Preferences::loadPrefs();
        }
        return $aPref;
    }

    /**
     * A private, static method to load the details of an advertiser from the database.
     *
     * @param integer $advertiserId The ID of the advertiser to load.
     * @return false|array False if the advertiser cannot be loaded, an array of the
     *                     advertiser's details from the database otherwise.
     */
    function _loadAdvertiser($advertiserId)
    {
        // Get the advertiser's details
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientid = $advertiserId;
        $doClients->find();
        if (!$doClients->fetch()) {
            OA::debug('   - Error obtaining details for advertiser ID ' . $advertiserId . '.', PEAR_LOG_ERR);
            return false;
        }
        $aAdvertiser = $doClients->toArray();
        return $aAdvertiser;
    }

    /**
     * A private, static method to load the details of an agency from the database.
     *
     * @param integer $agencyId The ID of the agency to load.
     * @return false|array False if the agency cannot be loaded, an array of the
     *                     agency's details from the database otherwise.
     */
    function _loadAgency($agencyId)
    {
        // Get the agency's details
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->agencyid = $agencyId;
        $doAgency->find();
        if (!$doAgency->fetch()) {
            OA::debug('   - Error obtaining details for agency ID ' . $agencyId . '.', PEAR_LOG_ERR);
            return false;
        }
        $aAgency = $doAgency->toArray();
        return $aAgency;
    }

    /**
     * A private, static method to load the admin user's preferences.
     *
     * @return false|array False if the preferences cannot be loaded, an array of the
     *                     admin user's preferences from the database otherwise.
     */
    function _loadAdminPreferences()
    {
        $doPreference = OA_Dal::factoryDO('preference');
        $doPreference->agencyid = 0;
        $doPreference->find();
        if (!$doPreference->fetch()) {
            OA::debug('   - Error obtaining preferences for the admin user.', PEAR_LOG_ERR);
            return false;
        }
        $aAdminPrefs = $doPreference->toArray();
        return $aAdminPrefs;
    }

    /**
     * A private, static method to prepare the "regards" sign off for email reports,
     * based on the "owning" agnecy ID (which can be 0, in the case the "owner" is
     * the admin user).
     *
     * @param integer $agencyId The owning agency ID.
     * @return string The "regards" string to sign off an email with.
     */
    function _prepareRegards($agencyId)
    {
        $aPref = OA_Email::_loadPrefs();
        Language_Default::load();
        global $strMailFooter, $strDefaultMailFooter;

        $regards   = '';
        $useAgency = false;
        if ($agencyId != 0) {
            // Send regards of the owning agency
            $aAgency = OA_Email::_loadAgency($agencyId);
            if ($aAgency !== false) {
                if (!empty($aAgency['contact'])) {
                    $regards .= $aAgency['contact'];
                }
                if (!empty($aAgency['name'])) {
                    if (!empty($regards)) {
                        $regards .= ', ';
                    }
                    $regards .= $aAgency['name'];
                }
            }
            if (empty($regards)) {
                // Didn't find any agency details! Send
                // regards of admin user
                $useAgency = true;
            }
        }
        if ($agencyId == 0 || $useAgency) {
            // Send regards of the admin user
            if (!empty($aPref['admin_fullname'])) {
                $regards .= $aPref['admin_fullname'];
            }
            if (!empty($aPref['company_name'])) {
                if (!empty($regards)) {
                    $regards .= ', ';
                }
                $regards .= $aPref['company_name'];
            }
        }
        if (!empty($regards)) {
            $result = str_replace("{adminfullname}", $regards, $strMailFooter);
        } else {
            $result = $strDefaultMailFooter;
        }
        return $result;
    }

    /**
     * A static method to send an email.
     *
     * @static
     * @param string $subject   The subject line of the email.
     * @param string $contents  The body of the email.
     * @param string $userEmail The email address to send the report to.
     * @param string $userName  The readable name of the user. Optional.
     * @return boolean True if the mail was send, false otherwise.
     *
     * @copyright 2003-2007 Openads Limited
     * @copyright 2000-2003 The phpAdsNew developers
     */
    function sendMail($subject, $contents, $userEmail, $userName = null)
    {
        if (defined('DISABLE_ALL_EMAILS')) {
            return true;
        }

        $aPref = $GLOBALS['_MAX']['PREF'];
        if (is_null($aPref)) {
            $aPref = MAX_Admin_Preferences::loadPrefs();
        }

    	global $phpAds_CharSet;
    	// Build the "to:" header for the email
    	if (!get_cfg_var('SMTP')) {
    		$toParam = '"'.$userName.'" <'.$userEmail.'>';
    	} else {
    		$toParam = $userEmail;
    	}
    	// Build additional email headers
    	$headersParam = "Content-Transfer-Encoding: 8bit\r\n";
    	if (isset($phpAds_CharSet)) {
    		$headersParam .= "Content-Type: text/plain; charset=" . $phpAds_CharSet . "\r\n";
    	}
    	if (get_cfg_var('SMTP')) {
    		$headersParam .= 'To: "' . $userName . '" <' . $userEmail . ">\r\n";
    	}
    	$headersParam .= 'From: "' . $aPref['admin_fullname'] . '" <' . $aPref['admin_email'].'>' . "\r\n";
    	// Use only \n as header separator when qmail is used
    	if ($aPref['qmail_patch']) {
    		$headersParam = str_replace("\r", '', $headersParam);
    	}
    	// Add \r to linebreaks in the contents for MS Exchange compatibility
    	$contents = str_replace("\n", "\r\n", $contents);
    	return @mail($toParam, $subject, $contents, $headersParam);
    }

}

?>
