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

require_once MAX_PATH . '/lib/max/language/Loader.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/OperationInterval.php';
require_once MAX_PATH . '/lib/OA/Preferences.php';

require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';

require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A class to provide support for sending of email-based reports and
 * alerts.
 *
 * @package    OpenX
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Email
{

    /**
     * A method for preparing an advertiser's "placement delivery" report
     * email.
     *
     * @param integer    $advertiserId The advertiser's ID.
     * @param PEAR::Date $oStartDate   The start date of the report, inclusive.
     * @param PEAR::Date $oEndDate     The end date of the report, inclusive.
     * @return boolean|array False, if the report could not be created, otherwise
     *                       an array of four elements:
     *                          'subject'   => The email subject line.
     *                          'contents'  => The body of the email report.
     *                          'userEmail' => The email address to send the report to.
     *                          'userName'  => The real name of the email address, or null.
     */
    function preparePlacementDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate)
    {

        Language_Loader::load('default',$aUser['language']);

        OA::debug('   - Preparing "placement delivery" report for advertiser ID ' . $advertiserId . '.', PEAR_LOG_DEBUG);

        /**
         * @doing: Need to update this to load the correct language for the owning advertiser - which
         *        probably means sending a separate email report to every user linked to the advertiser
         *        account, based on that user's language (once language has been set as a user property).
         */

        // Load the required strings
        global $strMailHeader, $strSirMadam, $strMailBannerStats, $strMailReportPeriodAll,
               $strMailReportPeriod, $date_format, $strMailSubject;

        // Prepare the result array
        $aResult = array(
            'subject'   => '',
            'contents'  => '',
            'hasAdviews' => false,
        );

        // Get the advertiser's details
        $aAdvertiser = $this->_loadAdvertiser($advertiserId);
        if ($aAdvertiser === false) {
            return false;
        }

        // Check the advertiser wants to have reports sent
        if ($aAdvertiser['report'] != 't') {
            OA::debug('   - Reports disabled for advertiser ID ' . $advertiserId . '.', PEAR_LOG_ERR);
            return false;
        }
        // Does the advertiser have an email address?
        if (empty($aUser['email_address'])) {
            OA::debug('   - No email for User ID ' . $aUser['user_id']. '.', PEAR_LOG_ERR);
            return false;
        }

        // Prepare the email body
        $aEmailBody = $this->_preparePlacementDeliveryEmailBody($advertiserId, $oStartDate, $oEndDate);

        // Was anything found?
        if ($aEmailBody['body'] == '') {
            OA::debug('   - No placements with delivery for advertiser ID ' . $advertiserId . '.', PEAR_LOG_DEBUG);
            return false;
        }

        // Prepare the final email - add the greeting to the advertiser
        $email = "$strMailHeader\n";
        if (!empty($aUser['contact_name'])) {
            $greetingTo = $aUser['contact_name'];
        } else if (!empty($aAdvertiser['contact'])) {
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
        $email .= "{$aEmailBody['body']}\n";

        // Prepare the final email - add the "regards" signature
        $email .= $this->_prepareRegards($aAdvertiser['agencyid']);

        // Prepare & return the final email array
        $aResult['subject']    = $strMailSubject . ': ' . $aAdvertiser['clientname'];
        $aResult['contents']   = $email;
        $aResult['hasAdviews'] = ($aEmailBody['adviews'] > 0);
        return $aResult;
    }

    function sendPlacementDeliveryEmail($advertiserId, $oStartDate, $oEndDate) {

        $aLinkedUsers = $this->getUsersLinkedToAccount('clients', $advertiserId);
        $copiesSent = 0;
        if (!empty($aLinkedUsers) && is_array($aLinkedUsers)) {
            foreach ($aLinkedUsers as $aUser) {
                $aEmail = $this->preparePlacementDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate);
                if ($aEmail !== false) {
                    if (!isset($aEmail['hasAdviews']) || $aEmail['hasAdviews'] !== false) {
                        if ($this->sendMail($aEmail['subject'], $aEmail['contents'], $aUser['email_address'], $aUser['contact_name'])) {
                            $copiesSent++;
                        }
                    }
                }
            }
        }

        // Only update the last sent date if we actually sent out at least one copy of the email
        if ($copiesSent) {
            // Update the last run date to "today"
            OA::debug('   - Updating the date the report was last sent for advertiser ID ' . $advertiserId . '.', PEAR_LOG_DEBUG);
            $doUpdateClients = OA_Dal::factoryDO('clients');
            $doUpdateClients->clientid = $advertiserId;
            $doUpdateClients->reportlastdate = OA::getNow();
            $doUpdateClients->update();
        }
        return $copiesSent;
    }

    /**
     * A private method to prepare the body of an advertiser's "placement delivery"
     * report email.
     *
     * @access private
     * @param integer    $advertiserId The advertiser's ID.
     * @param PEAR::Date $oStartDate   The start date of the report, inclusive.
     * @param PEAR::Date $oEndDate     The end date of the report, inclusive.
     */
    function _preparePlacementDeliveryEmailBody($advertiserId, $oStartDate, $oEndDate)
    {
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
        $totalAdviewsInPeriod = 0;

        // Fetch all the advertiser's placements
        $doPlacements = OA_Dal::factoryDO('campaigns');
        $doPlacements->clientid = $advertiserId;
        $doPlacements->orderBy('campaignid');
        $doPlacements->find();
        if ($doPlacements->getRowCount() > 0) {
            while ($doPlacements->fetch()) {
            	$aPlacement = $doPlacements->toArray();
            	if ($aPlacement['status'] == '0') {
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
                    $doBanners->orderBy('bannerid');
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
                                    $aEmailBody = $this->_preparePlacementDeliveryEmailBodyStats($aAd['bannerid'], $oStartDate, $oEndDate, 'impressions', $adTextPrint);
                                    $emailBody .= $aEmailBody['body'];
                                    $totalAdviewsInPeriod += $aEmailBody['adviews'];
                                }
                                if ($adClicks > 0) {
                                    // The ad has clicks
                                    $adHasStats = true;
                                    $emailBody .= "\n" . sprintf($adTextPrint, $strTotalClicks) . ': ';
                                    $emailBody .= sprintf('%15s', phpAds_formatNumber($adClicks)) . "\n";
                                    // Fetch the ad's clicks for the report period, grouped by day
                                    $aEmailBody = $this->_preparePlacementDeliveryEmailBodyStats($aAd['bannerid'], $oStartDate, $oEndDate, 'clicks', $adTextPrint);
                                    $emailBody .= $aEmailBody['body'];
                                    $totalAdviewsInPeriod += $aEmailBody['adviews'];
                                }
                                if ($adConversions > 0) {
                                    // The ad has conversions
                                    $adHasStats = true;
                                    $emailBody .= "\n" . sprintf($adTextPrint, $strTotalConversions) . ': ';
                                    $emailBody .= sprintf('%15s', phpAds_formatNumber($adConversions)) . "\n";
                                    // Fetch the ad's conversions for the report period, grouped by day
                                    $aEmailBody = $this->_preparePlacementDeliveryEmailBodyStats($aAd['bannerid'], $oStartDate, $oEndDate, 'conversions', $adTextPrint);
                                    $emailBody .= $aEmailBody['body'];
                                    $totalAdviewsInPeriod += $aEmailBody['adviews'];
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
        }

        // Return the email body
        return array(
            'body'    => $emailBody,
            'adviews' => $totalAdviewsInPeriod,
        );
    }

    /**
     * A private method to prepare the statistics part of the body of an
     * advertiser's "placement delivery" report email.
     *
     * @access private
     * @param integer    $advertiserId The advertiser's ID.
     * @param PEAR::Date $oStartDate   The start date of the report, inclusive.
     * @param PEAR::Date $oEndDate     The end date of the report, inclusive.
     * @param string     $type         One of "impressions", "clicks" or "conversions".
     * @param string     $adTextPrint  An sprintf compatible formatting string for use
     *                                 with the $strTotalThisPeriod global string.
     * @return an array with
     *      'body'      => string The ad statistics part of the report.
     *      'adviews'   => int    Adviews in this period
     */
    function _preparePlacementDeliveryEmailBodyStats($adId, $oStartDate, $oEndDate, $type, $adTextPrint)
    {
        $oDbh =& OA_DB::singleton();

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
            return array (
                'body'    => '',
                'adviews' => 0,
            );
        }

        // Prepare the result
        $emailBodyStats = '';

        $total = 0;

        // Fetch the ad's stats for the report period, grouped by day
        $doDataSummaryAdHourly = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDataSummaryAdHourly->selectAdd();
        $doDataSummaryAdHourly->selectAdd("SUM($type) as quantity");
        $doDataSummaryAdHourly->selectAdd("DATE_FORMAT(date_time, '%Y-%m-%d') AS day");
        $doDataSummaryAdHourly->selectAdd("DATE_FORMAT(date_time, '$date_format') as t_stamp_f");
        $doDataSummaryAdHourly->ad_id = $adId;
        $doDataSummaryAdHourly->whereAdd('impressions > 0');
        if (!is_null($oStartDate)) {
            $doDataSummaryAdHourly->whereAdd('date_time >= ' . $oDbh->quote($oStartDate->format('%Y-%m-%d 00:00:00'), 'timestamp'));
        }
        $doDataSummaryAdHourly->whereAdd('date_time <= ' . $oDbh->quote($oEndDate->format('%Y-%m-%d 23:59:59'), 'timestamp'));
        $doDataSummaryAdHourly->groupBy('day');
        $doDataSummaryAdHourly->groupBy('t_stamp_f');
        $doDataSummaryAdHourly->orderBy('day DESC');
        $doDataSummaryAdHourly->find();
        if ($doDataSummaryAdHourly->getRowCount() > 0) {
            // The ad has statistics this period, add them to the report
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
        return array(
            'body'    => $emailBodyStats,
            'adviews' => $total,
        );
    }

    function sendPlacementImpendingExpiryEmail($oDate, $placementId) {
        $aConf = $GLOBALS['_MAX']['CONF'];
        global $date_format;

        $doPlacement = OA_Dal::staticGetDO('campaigns', $placementId);
        $aPlacement = $doPlacement->toArray();

        $aPreviousOIDates = OA_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);

        $aLinkedUsers['advertiser'] = $this->getUsersLinkedToAccount('clients', $aPlacement['clientid']);

        $doClients = OA_Dal::staticGetDO('clients', $aPlacement['clientid']);
        $doAgency = OA_Dal::staticGetDO('agency', $doClients->agencyid);

        $aLinkedUsers['manager']    = $this->getUsersLinkedToAccount('agency',  $doClients->agencyid);
        $aLinkedUsers['admin']      = $this->getAdminUsersLinkedToAccount();

        $oPreference = new OA_Preferences();

        $aPrefs['advertiser'] = $oPreference->loadAccountPreferences($doClients->account_id, true);
        $aPrefs['manager']    = $oPreference->loadAccountPreferences($doAgency->account_id, true);
        $aPrefs['admin']    = $oPreference->loadPreferences(false, true, false, true);

        $copiesSent = 0;
        foreach ($aLinkedUsers as $accountType => $aUsers) {
            if ($aPrefs[$accountType]['warn_email_' . $accountType]) {
                // Does the account type want warnings when the impressions are low?
                if ($aPrefs[$accountType]['warn_email_' . $accountType . '_impression_limit'] > 0 && $aPlacement['views'] > 0) {
                    // Test to see if the placements impressions remaining are less than the limit
                    $dalCampaigns = OA_Dal::factoryDAL('campaigns');
                    $remainingImpressions = $dalCampaigns->getAdImpressionsLeft($aPlacement['campaignid']);
                    if ($remainingImpressions < $aPrefs[$accountType]['warn_email_' . $accountType . '_impression_limit']) {
                        // Yes, the placement will expire soon! But did the placement just reach
                        // the point where it is about to expire, or did it happen a while ago?
                        $previousRemainingImpressions =
                            $dalCampaigns->getAdImpressionsLeft($aPlacement['campaignid'], $aPreviousOIDates['end']);
                        if ($previousRemainingImpressions >= $aPrefs[$accountType]['warn_email_' . $accountType . '_impression_limit']) {
                            // Yes! This is the operation interval that the boundary
                            // was crossed to the point where it's about to expire,
                            // so send that email, baby!
                            foreach ($aUsers as $aUser) {
                                $aEmail = $this->preparePlacementImpendingExpiryEmail(
                                    $aUser,
                                    $aPlacement['clientid'],
                                    $aPlacement['campaignid'],
                                    'impressions',
                                    $aPrefs[$accountType]['warn_email_' . $accountType . '_impression_limit'],
                                    $accountType
                                );

                                if ($aEmail !== false) {
                                    if ($this->sendMail($aEmail['subject'], $aEmail['contents'], $aUser['email_address'], $aUser['contact_name'])) {
                                        $copiesSent++;
                                    }
                                }
                            }
                        }
                    }
                }
                // Does the account type want warnings when the days are low?
                if ($aPrefs[$accountType]['warn_email_' . $accountType . '_day_limit'] > 0 && $aPlacement['expire'] != OA_Dal::noDateValue()) {
                    // Calculate the date that should be used to see if the warning needs to be sent
                    $warnSeconds = (int) ($aPrefs[$accountType]['warn_email_' . $accountType . '_day_limit'] + 1) * SECONDS_PER_DAY;
                    $oEndDate = new Date($aPlacement['expire'] . ' 23:59:59');  // Convert day to end of Date
                    $oTestDate = new Date();
                    $oTestDate->copy($oDate);
                    $oTestDate->addSeconds($warnSeconds);
                    // Test to see if the test date is after the placement's expiration date
                    if ($oTestDate->after($oEndDate)) {
                        // Yes, the placement will expire soon! But did the placement just reach
                        // the point where it is about to expire, or did it happen a while ago?
                        $oiSeconds = (int) $aConf['maintenance']['operationInterval'] * 60;
                        $oTestDate->subtractSeconds($oiSeconds);
                        if (!$oTestDate->after($oEndDate)) {
                            // Yes! This is the operation interval that the boundary
                            // was crossed to the point where it's about to expire,
                            // so send those emails, baby!
                            foreach ($aUsers as $aUser) {
                                $aEmail = $this->preparePlacementImpendingExpiryEmail(
                                    $aUser,
                                    $aPlacement['clientid'],
                                    $aPlacement['campaignid'],
                                    'date',
                                    $oEndDate->format($date_format),
                                    $accountType
                                );
                                if ($aEmail !== false) {
                                    if ($this->sendMail($aEmail['subject'], $aEmail['contents'], $aUser['email_address'], $aUser['contact_name'])) {
                                        $copiesSent++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        // Restore the default language strings
        Language_Loader::load('default');
        return $copiesSent;
    }

    /**
     * A method for preparing an advertiser's "impending placement expiry" report.
     *
     * @param integer $advertiserId The advertiser's ID.
     * @param integer $placementId  The advertiser's ID.
     * @param string  $reason       The reason for expiration. One of:
     *                              "date", "impressions".
     * @param mixed   $value        The limit reason (ie. the date or value limit)
     *                              used to decide that the placement is about to
     *                              expire.
     * @param string  $type         One of "admin", "manager" or "advertiser", describing
     *                              which of the account types the email should be
     *                              prepared for.
     * @return boolean|array False, if the report could not be created, otherwise
     *                       an array or arrays of four elements:
     *                          'subject'   => The email subject line.
     *                          'contents'  => The body of the email report.
     *                          'userEmail' => The email address to send the report to.
     *                          'userName'  => The real name of the email address, or null.
     */
    function preparePlacementImpendingExpiryEmail($aUser, $advertiserId, $placementId, $reason, $value, $type)
    {
        OA::debug('   - Preparing "impending expiry" report for advertiser ID ' . $advertiserId . '.', PEAR_LOG_DEBUG);

        Language_Loader::load('default',$aUser['language']);

        // Load the required strings
        global $strImpendingCampaignExpiryDateBody, $strImpendingCampaignExpiryImpsBody, $strMailHeader,
               $strSirMadam, $strTheCampiaignBelongingTo, $strYourCampaign, $strImpendingCampaignExpiryBody,
               $strMailFooter, $strImpendingCampaignExpiry;

        // Prepare the expiration email body
        if ($reason == 'date') {
            $reason = $strImpendingCampaignExpiryDateBody;
        } else if ($reason == 'impressions') {
            $reason = $strImpendingCampaignExpiryImpsBody;
        } else {
            return false;
        }

        // Get the advertiser's details
        $aAdvertiser = $this->_loadAdvertiser($advertiserId);
        if ($aAdvertiser === false) {
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
        $emailBody  = $this->_preparePlacementImpendingExpiryEmailBody($advertiserId, $aPlacement);

        // Was anything found?
        if ($emailBody == '') {
            OA::debug('   - No placements with delivery for advertiser ID ' . $advertiserId . '.', PEAR_LOG_DEBUG);
            return false;
        }

        $email = "$strMailHeader\n";
        // Set the correct greeting, start with username, then advertiser contact/name,
        // then admin name/company, fallback to generic
        if (!empty($aUser['contact_name'])) {
            $greetingTo = $aUser['contact_name'];
        } else if (!empty($aAdvertiser['contact'])) {
            $greetingTo = $aAdvertiser['contact'];
        } else if (!empty($aAdvertiser['clientname'])) {
            $greetingTo = $aAdvertiser['clientname'];
        } else if (!empty($conf['email']['fromName'])) {
            $greetingTo = $conf['email']['fromName'];
        } else if (!empty($conf['email']['fromCompany'])) {
            $greetingTo = $conf['email']['fromCompany'];
        } else {
            $greetingTo = $strSirMadam;
        }

        $email = str_replace("{contact}", $greetingTo, $email);

        // Prepare the final email - add the report type description
        // and the name of the advertiser the report is about
        $email .= $reason . "\n\n";
        if ($type == 'advertiser') {
            $campaignReplace = $strYourCampaign;
        } else {
            $campaignReplace = $strTheCampiaignBelongingTo . ' ' . trim($aAdvertiser['clientname']);
        }
        $email = str_replace("{clientname}", $campaignReplace, $email);
        $email = str_replace("{date}",  $value, $email);
        $email = str_replace("{limit}", $value, $email);
        $email .= $strImpendingCampaignExpiryBody . "\n\n";

        // Prepare the final email - add the report body
        $email .= "$emailBody\n";

        // Prepare the final email - add the "regards" signature
        if ($type == 'admin') {
            $email .= $this->_prepareRegards(0);
        } else {
            $email .= $this->_prepareRegards($aAdvertiser['agencyid']);
        }

        // Return the emails to be sent
        return array(
            'subject'   => $strImpendingCampaignExpiry . ': ' . $aAdvertiser['clientname'],
            'contents'  => $email,
        );
    }

    /**
     * A private  method to prepare the body of an advertiser's "impending placement
     * expiry" report email.
     *
     * @access private
     * @param integer $advertiserId The advertiser's ID.
     * @param array   $aPlacement   The placement details.
     */
    function _preparePlacementImpendingExpiryEmailBody($advertiserId, $aPlacement)
    {
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
        $doBanners->orderBy('bannerid');
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
     * A method for preparing an advertiser's "placement activated" or
     * "placement deactivated" report.
     *
     * @param string  $placementId The ID of the activated placement.
     * @param integer $reason      An optional binary flag field containting the
     *                             representation of the reason(s) the placement
     *                             was deactivated:
     *                                   2  - No more impressions
     *                                   4  - No more clicks
     *                                   8  - No more conversions
     *                                   16 - Placement ended (due to date)
     * @return boolean|array False, if the report could not be created, otherwise
     *                       an array of four elements:
     *                          'subject'   => The email subject line.
     *                          'contents'  => The body of the email report.
     *                          'userEmail' => The email address to send the report to.
     *                          'userName'  => The real name of the email address, or null.
     */
    function preparePlacementActivatedDeactivatedEmail($aUser, $placementId, $reason = null)
    {
        Language_Loader::load('default',$aUser['language']);

        if (is_null($reason)) {
            OA::debug('   - Preparing "placement activated" email for placement ID ' . $placementId. '.', PEAR_LOG_DEBUG);
        } else {
            OA::debug('   - Preparing "placement deactivated" email for placement ID ' . $placementId. '.', PEAR_LOG_DEBUG);
        }

        // Load the required strings
        global $strMailHeader, $strSirMadam,
               $strMailBannerActivatedSubject, $strMailBannerDeactivatedSubject,
               $strMailBannerActivated, $strMailBannerDeactivated,
               $strNoMoreImpressions, $strNoMoreClicks, $strNoMoreConversions,
               $strAfterExpire;

        // Fetch the placement
        $aPlacement = $this->_loadPlacement($placementId);
        if ($aPlacement === false) {
            return false;
        }

        // Fetch the placement's owning advertiser
        $aAdvertiser = $this->_loadAdvertiser($aPlacement['clientid']);
        if ($aAdvertiser === false) {
            return false;
        }

        // Prepare the email body
        $emailBody = $this->_preparePlacementActivatedDeactivatedEmailBody($aPlacement);

        // Prepare the final email - add the greeting to the advertiser
        $email = "$strMailHeader\n";
        if (!empty($aUser['contact_name'])) {
            $greetingTo = $aUser['contact_name'];
        } else if (!empty($aAdvertiser['contact'])) {
            $greetingTo = $aAdvertiser['contact'];
        } else if (!empty($aAdvertiser['clientname'])) {
            $greetingTo = $aAdvertiser['clientname'];
        } else {
            $greetingTo = $strSirMadam;
        }
        $email = str_replace("{contact}", $greetingTo, $email);

        // Prepare the final email - add the report type description
        // and the name of the advertiser the report is about
        if (is_null($reason)) {
            $email .= "$strMailBannerActivated\n";
        } else {
            $email .= "$strMailBannerDeactivated:";
            if ($reason & OA_PLACEMENT_DISABLED_IMPRESSIONS) {
                $email .= "\n  - " . $strNoMoreImpressions;
            }
            if ($reason & OA_PLACEMENT_DISABLED_CLICKS) {
                $email .= "\n  - " . $strNoMoreClicks;
            }
            if ($reason & OA_PLACEMENT_DISABLED_CONVERSIONS) {
                $email .= "\n  - " . $strNoMoreConversions;
            }
            if ($reason & OA_PLACEMENT_DISABLED_DATE) {
                $email .= "\n  - " . $strAfterExpire;
            }
            $email .= ".\n";
        }

        // Prepare the final email - add the report body
        $email .= "$emailBody\n";

        // Prepare the final email - add the "regards" signature
        $email .= $this->_prepareRegards($aAdvertiser['agencyid']);

        // Prepare & return the final email array
        if (is_null($reason)) {
            $aResult['subject']   = $strMailBannerActivatedSubject . ': ' . $aAdvertiser['clientname'];
        } else {
            $aResult['subject']   = $strMailBannerDeactivatedSubject . ': ' . $aAdvertiser['clientname'];
        }
        $aResult['contents']  = $email;
        return $aResult;
    }

    function sendPlacementActivatedDeactivatedEmail($placementId, $reason = null)
    {
        $doPlacement = OA_Dal::factoryDO('campaigns');
        $doClient = OA_Dal::factoryDO('clients');
        $doPlacement->joinAdd($doClient);
        $doPlacement->get('campaignid', $placementId);
        $aLinkedUsers = $this->getUsersLinkedToAccount('clients', $doPlacement->clientid);
        $copiesSent = 0;

        if (!empty($aLinkedUsers) && is_array($aLinkedUsers)) {
            foreach ($aLinkedUsers as $aUser) {
                $aEmail = $this->preparePlacementActivatedDeactivatedEmail($aUser, $doPlacement->campaignid, $reason);
                if ($aEmail !== false) {
                    if ($this->sendMail($aEmail['subject'], $aEmail['contents'], $aUser['email_address'], $aUser['contact_name'])) {
                        $copiesSent++;
                    }
                }
            }
            // Restore the default language strings
            Language_Loader::load('default');
        }
        return $copiesSent;
    }

    /**
     * A private method to prepare the body of an advertiser's "placement activated"
     * or "placement deactivated" report email.
     *
     * @access private
     * @param integer $advertiserId The advertiser's ID.
     * @param array   $aPlacement   The placement details.
     */
    function _preparePlacementActivatedDeactivatedEmailBody($aPlacement)
    {
        // Load the "Campaign" and "Banner" strings, and prepare formatting strings
        global $strCampaign, $strBanner;
        $strCampaignLength = strlen($strCampaign);
        $strBannerLength   = strlen($strBanner);
        $maxLength         = max($strCampaignLength, $strBannerLength);
        $strCampaignPrint  = '%-'  . $maxLength . 's';
        $strBannerPrint    = ' %-'  . ($maxLength - 1) . 's';

        // Load remaining strings
        global $strLinkedTo;

        // Prepare the result
        $emailBody = '';

        // Add the name of the placement to the report
        $emailBody .= "\n" . sprintf($strCampaignPrint, $strCampaign) . ' ';
        $emailBody .= strip_tags(phpAds_buildName($aPlacement['campaignid'], $aPlacement['campaignname'])) . "\n";

        // Add a URL link to the stats page of the campaign
        $page = 'stats.php?clientid='. $aPlacement['clientid'] . '&campaignid=' . $aPlacement['campaignid'] .'&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=';
        $emailBody .= MAX::constructURL(MAX_URL_ADMIN, $page) . "\n";
        // Add a nice divider
        $emailBody .= "=======================================================\n\n";
        // Fetch all ads in the placement
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $aPlacement['campaignid'];
        $doBanners->orderBy('bannerid');
        $doBanners->find();
        if ($doBanners->getRowCount() > 0) {
            while ($doBanners->fetch()) {
                $aAd = $doBanners->toArray();
                // Add the name of the ad to the report
                $emailBody .= sprintf($strBannerPrint, $strBanner) . ' ';
                $emailBody .= strip_tags(phpAds_buildBannerName($aAd['bannerid'], $aAd['description'], $aAd['alt'])) . "\n";
                // If the ad has a URL, add the URL the add is linked to to the report
                if (!empty($aAd['url'])) {
                    $emailBody .= '  ' . $strLinkedTo . ': ' . $aAd['url'] . "\n";
                }
                $emailBody .= "\n";
            }
        }
        return $emailBody;
    }

    /**
     * A private method to load the preferences required when generating reports.
     *
     * @access private
     * @return array The loaded preference array.
     */
    function _loadPrefs()
    {
        $aPref = $GLOBALS['_MAX']['PREF'];
        if (is_null($aPref)) {
            $aPref = OA_Preferences::loadAdminAccountPreferences(true);
        }
        return $aPref;
    }

    /**
     * A private method to load the details of an placement from the database.
     *
     * @param integer $placementId The ID of the placement to load.
     * @return false|array False if the placement cannot be loaded, an array of the
     *                     placement's details from the database otherwise.
     */
    function _loadPlacement($placementId)
    {
        // Get the placement's details
        $doPlacements = OA_Dal::factoryDO('campaigns');
        $doPlacements->campaignid = $placementId;
        $doPlacements->find();
        if (!$doPlacements->fetch()) {
            OA::debug('   - Error obtaining details for placement ID ' . $placementId . '.', PEAR_LOG_ERR);
            return false;
        }
        $aPlacement = $doPlacements->toArray();
        return $aPlacement;
    }

    /**
     * A private method to load the details of an advertiser from the database.
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
     * A private method to load the details of an agency from the database.
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
     * A private method to prepare the "regards" sign off for email reports,
     * based on the "owning" agency ID (which can be 0, in the case the "owner" is
     * the admin user).
     *
     * @param integer $agencyId The owning agency ID.
     * @return string The "regards" string to sign off an email with.
     */
    function _prepareRegards($agencyId)
    {
        $aPref = $this->_loadPrefs();
        $aConf = $GLOBALS['_MAX']['CONF'];

        global $strMailFooter, $strDefaultMailFooter;

        $regards   = '';
        $useAgency = false;
        if ($agencyId != 0) {
            // Send regards of the owning agency
            $aAgency = $this->_loadAgency($agencyId);
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
            if (!empty($aConf['email']['fromName'])) {
                $regards .= $aConf['email']['fromName'];
            }
            if (!empty($aConf['email']['fromCompany'])) {
                if (!empty($regards)) {
                    $regards .= ', ';
                }
                $regards .= $aConf['email']['fromCompany'];
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
     * This method gets all users linked to a particular account
     * This may not be required, but I thought that in the future, this would be a per-user setting
     * So wrapping it here should make that functionality easier to implement
     *
     * @param string $entityName  Inventory entity name (affiliates, clients, etc)
     * @param integer $entityId  Inventory entity ID
     * @return array
     */
    function getUsersLinkedToAccount($entityName, $entityId)
    {
        // Get any users linked to this account
        $doUsers = OA_Dal::factoryDO('users');
        return $doUsers->getAccountUsersByEntity($entityName, $entityId);
    }

    function getAdminUsersLinkedToAccount()
    {
        // Get any users linked to the admin account
        $doUsers = OA_Dal::factoryDO('users');
        return $doUsers->getAdminUsers();
    }

    /**
     * A method to send an email.
     *
     * @param string $subject   The subject line of the email.
     * @param string $contents  The body of the email.
     * @param string $userEmail The email address to send the report to.
     * @param string $userName  The readable name of the user. Optional.
     * @return boolean True if the mail was send, false otherwise.
     */
    function sendMail($subject, $contents, $userEmail, $userName = null)
    {
        if (defined('DISABLE_ALL_EMAILS')) {
            return true;
        }

        $aConf = $GLOBALS['_MAX']['CONF'];

    	global $phpAds_CharSet;

    	// For the time being we're sending plain text emails only, so decode any HTML entities
    	$contents = html_entity_decode($contents, ENT_QUOTES);

    	// Build the "to:" header for the email
    	if (!get_cfg_var('SMTP')) {
    		$toParam = '"'.$userName.'" <'.$userEmail.'>';
    	} else {
    		$toParam = $userEmail;
    	}
    	// Build additional email headers
    	$headersParam = "MIME-Versions: 1.0\r\n";
    	if (isset($phpAds_CharSet)) {
    		$headersParam .= "Content-Type: text/plain; charset=" . $phpAds_CharSet . "\r\n";
    	}
    	$headersParam .= "Content-Transfer-Encoding: 8bit\r\n";
    	if (get_cfg_var('SMTP')) {
    		$headersParam .= 'To: "' . $userName . '" <' . $userEmail . ">\r\n";
    	}
    	$headersParam .= 'From: "' . $aConf['email']['fromName'] . '" <' . $aConf['email']['fromAddress'] . '>' . "\r\n";
    	// Use only \n as header separator when qmail is used
    	if ($aConf['email']['qmailPatch']) {
    		$headersParam = str_replace("\r", '', $headersParam);
    	}
    	// Add \r to linebreaks in the contents for MS Exchange compatibility
    	$contents = str_replace("\n", "\r\n", $contents);
    	// Send email, if possible!
    	if (function_exists('mail')) {
    	   $value = @mail($toParam, $subject, $contents, $headersParam);
    	   return $value;
    	} else {
    	    OA::debug('Cannot send emails - mail() does not exist!', PEAR_LOG_ERR);
    	    return false;
    	}
    }

}

?>
