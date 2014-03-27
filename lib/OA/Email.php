<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/max/language/Loader.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Preferences.php';
require_once MAX_PATH . '/lib/max/other/lib-userlog.inc.php';

require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';

require_once LIB_PATH . '/OperationInterval.php';
require_once OX_PATH . '/lib/pear/Date.php';

/**
 * A class to provide support for sending of email-based reports and
 * alerts.
 *
 * @package    OpenX
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Email
{
    // Cache variables
    var $aAdminCache;
    var $aClientCache;
    var $aAgencyCache;

    function sendCampaignDeliveryEmail($aAdvertiser, $oStartDate = null, $oEndDate = null, $campaignId = null) {
        $aConf = $GLOBALS['_MAX']['CONF'];

        $aAdvertiserPrefs = OA_Preferences::loadAccountPreferences($aAdvertiser['account_id'], true);
        $oTimezone = new Date_Timezone($aAdvertiserPrefs['timezone']);

        $this->convertStartEndDate($oStartDate, $oEndDate, $oTimezone);

        $aLinkedUsers = $this->getUsersLinkedToAccount('clients', $aAdvertiser['clientid']);
        // Add the advertiser to the linked users if there isn't any linked user with the advertiser's email address
        $aLinkedUsers = $this->_addAdvertiser($aAdvertiser, $aLinkedUsers);
        $copiesSent = 0;
        if (!empty($aLinkedUsers) && is_array($aLinkedUsers)) {
            if ($aConf['email']['useManagerDetails']) {
                $aFromDetails = $this->_getAgencyFromDetails($aAdvertiser['agencyid']);
            }
            foreach ($aLinkedUsers as $aUser) {
                $aEmail = $this->prepareCampaignDeliveryEmail($aUser, $aAdvertiser['clientid'], $oStartDate, $oEndDate, $campaignId);
                if ($aEmail !== false) {
                    if (!isset($aEmail['hasAdviews']) || $aEmail['hasAdviews'] !== false) {
                        if ($this->sendMail($aEmail['subject'], $aEmail['contents'], $aUser['email_address'], $aUser['contact_name'], $aFromDetails)) {
                            $copiesSent++;
                            if ($aConf['email']['logOutgoing']) {
                                phpAds_userlogSetUser(phpAds_userMaintenance);
                                phpAds_userlogAdd(phpAds_actionAdvertiserReportMailed, $aAdvertiser['clientid'],
                                    "{$aEmail['subject']}\n\n
                                     {$aUser['contact_name']}({$aUser['email_address']})\n\n
                                     {$aEmail['contents']}"
                                );
                            }
                        }
                    }
                }
            }
        }

        // Only update the last sent date if we actually sent out at least one copy of the email
        if ($copiesSent) {
            // Update the last run date to "today"
            OA::debug('   - Updating the date the report was last sent for advertiser ID ' . $aAdvertiser['clientid'] . '.', PEAR_LOG_DEBUG);
            $doUpdateClients = OA_Dal::factoryDO('clients');
            $doUpdateClients->clientid = $aAdvertiser['clientid'];
            $doUpdateClients->reportlastdate = OA::getNow();
            $doUpdateClients->update();
        }
        return $copiesSent;
    }

    /**
     * A method for preparing an advertiser's "campaign delivery" report
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
    function prepareCampaignDeliveryEmail($aUser, $advertiserId, $oStartDate, $oEndDate, $campaignId = null)
    {

        Language_Loader::load('default',$aUser['language']);

        OA::debug('   - Preparing "campaign delivery" report for advertiser ID ' . $advertiserId . '.', PEAR_LOG_DEBUG);

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
        $aEmailBody = $this->_prepareCampaignDeliveryEmailBody($advertiserId, $oStartDate, $oEndDate, $campaignId);

        // Was anything found?
        if ($aEmailBody['body'] == '') {
            OA::debug('   - No campaigns with delivery for advertiser ID ' . $advertiserId . '.', PEAR_LOG_DEBUG);
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

    /**
     * A private method to prepare the body of an advertiser's "campaign delivery"
     * report email.
     *
     * @access private
     * @param integer    $advertiserId The advertiser's ID.
     * @param PEAR::Date $oStartDate   The start date of the report, inclusive.
     * @param PEAR::Date $oEndDate     The end date of the report, inclusive.
     * @param integer    $campaignId   Restrict the report to a single campaign.
     */
    function _prepareCampaignDeliveryEmailBody($advertiserId, $oStartDate, $oEndDate, $campaignId)
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

        // Fetch all the advertiser's campaigns
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid = $advertiserId;

        if (!empty($campaignId)) {
            $doCampaigns->campaignid = $campaignId;
        }

        $doCampaigns->orderBy('campaignid');
        $doCampaigns->find();
        if ($doCampaigns->getRowCount() > 0) {
            while ($doCampaigns->fetch()) {
            	$aCampaign = $doCampaigns->toArray();

                // If campaign is active or we are running the report for a single campaign.
            	if ($aCampaign['status'] == '0' || !empty($campaignId)) {
            		// Add the name of the campaign to the report
            		$emailBody .= "\n" . sprintf($strCampaignPrint, $strCampaign) . ' ';
                    $emailBody .= strip_tags(phpAds_buildName($aCampaign['campaignid'], $aCampaign['campaignname'])) . "\n";
                    // Add a URL link to the stats page of the campaign
                    $page = 'stats.php?clientid='. $advertiserId . '&campaignid=' . $aCampaign['campaignid'] .'&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=';
                    $emailBody .= MAX::constructURL(MAX_URL_ADMIN, $page) . "\n";
                    // Add a nice divider
                    $emailBody .= "=======================================================\n\n";
                    // Fetch all ads in the campaign
                    $doBanners = OA_Dal::factoryDO('banners');
                    $doBanners->campaignid = $aCampaign['campaignid'];
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
                                    $aEmailBody = $this->_prepareCampaignDeliveryEmailBodyStats($aAd['bannerid'], $oStartDate, $oEndDate, 'impressions', $adTextPrint);
                                    $emailBody .= $aEmailBody['body'];
                                    $totalAdviewsInPeriod += $aEmailBody['adviews'];
                                }
                                if ($adClicks > 0) {
                                    // The ad has clicks
                                    $adHasStats = true;
                                    $emailBody .= "\n" . sprintf($adTextPrint, $strTotalClicks) . ': ';
                                    $emailBody .= sprintf('%15s', phpAds_formatNumber($adClicks)) . "\n";
                                    // Fetch the ad's clicks for the report period, grouped by day
                                    $aEmailBody = $this->_prepareCampaignDeliveryEmailBodyStats($aAd['bannerid'], $oStartDate, $oEndDate, 'clicks', $adTextPrint);
                                    $emailBody .= $aEmailBody['body'];
                                    $totalAdviewsInPeriod += $aEmailBody['adviews'];
                                }
                                if ($adConversions > 0) {
                                    // The ad has conversions
                                    $adHasStats = true;
                                    $emailBody .= "\n" . sprintf($adTextPrint, $strTotalConversions) . ': ';
                                    $emailBody .= sprintf('%15s', phpAds_formatNumber($adConversions)) . "\n";
                                    // Fetch the ad's conversions for the report period, grouped by day
                                    $aEmailBody = $this->_prepareCampaignDeliveryEmailBodyStats($aAd['bannerid'], $oStartDate, $oEndDate, 'conversions', $adTextPrint);
                                    $emailBody .= $aEmailBody['body'];
                                    $totalAdviewsInPeriod += $aEmailBody['adviews'];
                                }
                                $emailBody .= "\n";
                            }
                        }
                    }
                    // Did the campaign have any stats?
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
     * advertiser's "campaign delivery" report email.
     *
     * @access private
     * @param integer    $advertiserId The advertiser's ID.
     * @param Date $oStartDate   The start date of the report, inclusive.
     * @param Date $oEndDate     The end date of the report, inclusive.
     * @param string     $type         One of "impressions", "clicks" or "conversions".
     * @param string     $adTextPrint  An sprintf compatible formatting string for use
     *                                 with the $strTotalThisPeriod global string.
     * @return an array with
     *      'body'      => string The ad statistics part of the report.
     *      'adviews'   => int    Adviews in this period
     */
    function _prepareCampaignDeliveryEmailBodyStats($adId, $oStartDate, $oEndDate, $type, $adTextPrint)
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
        $doDataSummaryAdHourly->selectAdd("date_time");
        $doDataSummaryAdHourly->selectAdd("SUM($type) as quantity");
        $doDataSummaryAdHourly->ad_id = $adId;
        $doDataSummaryAdHourly->whereAdd("impressions > 0");
        if (!is_null($oStartDate)) {
            $oDate = new Date($oStartDate);
            $oDate->toUTC();
            $doDataSummaryAdHourly->whereAdd('date_time >= ' . $oDbh->quote($oDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp'));
        }
        $oDate = new Date($oEndDate);
        $oDate->toUTC();
        $doDataSummaryAdHourly->whereAdd('date_time <= ' . $oDbh->quote($oDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp'));
        $doDataSummaryAdHourly->groupBy('date_time');
        $doDataSummaryAdHourly->orderBy('date_time DESC');
        $doDataSummaryAdHourly->find();
        if ($doDataSummaryAdHourly->getRowCount() > 0) {
            // The ad has statistics this period, perform time zone conversion and summarize
            $aAdQuantity = array();
            while($doDataSummaryAdHourly->fetch()) {
                $v = $doDataSummaryAdHourly->toArray();
                $oDate = new Date($v['date_time']);
                $oDate->setTZbyID('UTC');
                $oDate->convertTZ($oEndDate->tz);
                $k = $oDate->format($date_format);
                if (!isset($aAdQuantity[$k])) {
                    $aAdQuantity[$k] = 0;
                }
                $aAdQuantity[$k] += $v['quantity'];
            }
            foreach ($aAdQuantity as $day => $quantity) {
                // Add this day
                $emailBodyStats .= sprintf($adTextPrint, $day) . ': ';
                $emailBodyStats .= sprintf('%15s', phpAds_formatNumber($quantity)) . "\n";
                $total += $quantity;
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

    /**
     * @param $oDate
     * @param $campaignId
     * @return int Number of emails sent
     */
    function sendCampaignImpendingExpiryEmail($oDate, $campaignId) {
        $aConf = $GLOBALS['_MAX']['CONF'];
        global $date_format;

        $oPreference = new OA_Preferences();

        if (!isset($this->aAdminCache)) {
            // Get admin account ID
            $adminAccountId = OA_Dal_ApplicationVariables::get('admin_account_id');

            // Get admin prefs
            $adminPrefsNames = $this->_createPrefsListPerAccount(OA_ACCOUNT_ADMIN);
            $aAdminPrefs = $oPreference->loadAccountPreferences($adminAccountId,
                $adminPrefsNames, OA_ACCOUNT_ADMIN);

            // Get admin users
            $aAdminUsers = $this->getAdminUsersLinkedToAccount();

            // Store admin cache
            $this->aAdminCache = array($aAdminPrefs, $aAdminUsers);
        } else {
            // Retrieve admin cache
            list($aAdminPrefs, $aAdminUsers) = $this->aAdminCache;
        }

        $aPreviousOIDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aPreviousOIDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aPreviousOIDates['start']);

        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        if (!$doCampaigns) {
            return 0;
        }
        $aCampaign = $doCampaigns->toArray();

        if (!isset($this->aClientCache[$aCampaign['clientid']])) {
            $doClients = OA_Dal::staticGetDO('clients', $aCampaign['clientid']);

            // Add advertiser linked users
            $aLinkedUsers['advertiser'] = $this->getUsersLinkedToAccount('clients', $aCampaign['clientid']);

            // Add advertiser prefs
            $advertiserPrefsNames = $this->_createPrefsListPerAccount(OA_ACCOUNT_ADVERTISER);
            $aPrefs['advertiser'] = $oPreference->loadAccountPreferences($doClients->account_id,
                $advertiserPrefsNames, OA_ACCOUNT_ADVERTISER);

            if (!isset($aAgencyCache[$doClients->agencyid])) {
                // Add manager linked users
                $doAgency = OA_Dal::staticGetDO('agency', $doClients->agencyid);
                $aLinkedUsers['manager']    = $this->getUsersLinkedToAccount('agency',  $doClients->agencyid);

                // Add manager preferences
                $managerPrefsNames = $this->_createPrefsListPerAccount(OA_ACCOUNT_MANAGER);
                $aPrefs['manager'] = $oPreference->loadAccountPreferences($doAgency->account_id,
                    $managerPrefsNames, OA_ACCOUNT_MANAGER);

                // Get agency "From" details
                $aAgencyFromDetails = $this->_getAgencyFromDetails($doAgency->agencyid);

                // Store in the agency cache
                $this->aAgencyCache = array(
                    $doClients->agencyid => array($aLinkedUsers['manager'], $aPrefs['manager'], $aAgencyFromDetails)
                );
            } else {
                // Retrieve agency cache
                list($aLinkedUsers['manager'], $aPrefs['manager'], $aAgencyFromDetails) = $this->aAgencyCache[$doClients->agencyid];
            }

            // Add admin linked users and preferences
            $aLinkedUsers['admin'] = $aAdminUsers;
            $aPrefs['admin']       = $aAdminPrefs;

            // Create a linked user 'special' for the advertiser that will take the admin preferences for advertiser
            $aLinkedUsers['special']['advertiser'] = $doClients->toArray();
            $aLinkedUsers['special']['advertiser']['contact_name']  = $aLinkedUsers['special']['advertiser']['contact'];
            $aLinkedUsers['special']['advertiser']['email_address'] = $aLinkedUsers['special']['advertiser']['email'];
            $aLinkedUsers['special']['advertiser']['language']      = '';
            $aLinkedUsers['special']['advertiser']['user_id']       = 0;

            // Check that every user is not going to receive more than one email if they
            // are linked to more than one account
            $aLinkedUsers = $this->_deleteDuplicatedUser($aLinkedUsers);

            // Create the linked special user preferences from the admin preferences
            // the special user is the client that doesn't have preferences in the database
            $aPrefs['special'] = $aPrefs['admin'];
            $aPrefs['special']['warn_email_special']                  = $aPrefs['special']['warn_email_advertiser'];
            $aPrefs['special']['warn_email_special_day_limit']        = $aPrefs['special']['warn_email_advertiser_day_limit'];
            $aPrefs['special']['warn_email_special_impression_limit'] = $aPrefs['special']['warn_email_advertiser_impression_limit'];

            // Store in the client cache
            $this->aClientCache = array(
                $aCampaign['clientid'] => array($aLinkedUsers, $aPrefs, $aAgencyFromDetails)
            );
        } else {
            // Retrieve client cache
            list($aLinkedUsers, $aPrefs, $aAgencyFromDetails) = $this->aClientCache[$aCampaign['clientid']];
        }

        $copiesSent = 0;
        foreach ($aLinkedUsers as $accountType => $aUsers) {
            if ($accountType == 'special' || $accountType == 'advertiser') {
                // Get the agency details and use them for emailing advertisers
                $aFromDetails = $aAgencyFromDetails;
            } else {
                // Use the Admin details
                $aFromDetails = '';
            }
            if ($aPrefs[$accountType]['warn_email_' . $accountType]) {
                // Does the account type want warnings when the impressions are low?
                if ($aPrefs[$accountType]['warn_email_' . $accountType . '_impression_limit'] > 0 && $aCampaign['views'] > 0) {
                    // Test to see if the placements impressions remaining are less than the limit
                    $dalCampaigns = OA_Dal::factoryDAL('campaigns');
                    $remainingImpressions = $dalCampaigns->getAdImpressionsLeft($aCampaign['campaignid']);
                    if ($remainingImpressions < $aPrefs[$accountType]['warn_email_' . $accountType . '_impression_limit']) {
                        // Yes, the placement will expire soon! But did the placement just reach
                        // the point where it is about to expire, or did it happen a while ago?
                        $previousRemainingImpressions =
                            $dalCampaigns->getAdImpressionsLeft($aCampaign['campaignid'], $aPreviousOIDates['end']);
                        if ($previousRemainingImpressions >= $aPrefs[$accountType]['warn_email_' . $accountType . '_impression_limit']) {
                            // Yes! This is the operation interval that the boundary
                            // was crossed to the point where it's about to expire,
                            // so send that email, baby!
                            foreach ($aUsers as $aUser) {
                                $aEmail = $this->prepareCampaignImpendingExpiryEmail(
                                    $aUser,
                                    $aCampaign['clientid'],
                                    $aCampaign['campaignid'],
                                    'impressions',
                                    $aPrefs[$accountType]['warn_email_' . $accountType . '_impression_limit'],
                                    $accountType
                                );

                                if ($aEmail !== false) {
                                    if ($this->sendMail($aEmail['subject'], $aEmail['contents'], $aUser['email_address'], $aUser['contact_name'], $aFromDetails)) {
                                        $copiesSent++;
                                        if ($aConf['email']['logOutgoing']) {
                                            phpAds_userlogSetUser(phpAds_userMaintenance);
                                            phpAds_userlogAdd(phpAds_actionWarningMailed, $aPlacement['campaignid'],
                                                "{$aEmail['subject']}\n\n
                                                 {$aUser['contact_name']}({$aUser['email_address']})\n\n
                                                 {$aEmail['contents']}"
                                            );
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                // Does the account type want warnings when the days are low?
                if ($aPrefs[$accountType]['warn_email_' . $accountType . '_day_limit'] > 0 && !empty($aCampaign['expire_time'])) {
                    // Calculate the date that should be used to see if the warning needs to be sent
                    $warnSeconds = (int) ($aPrefs[$accountType]['warn_email_' . $accountType . '_day_limit'] + 1) * SECONDS_PER_DAY;
                    $oEndDate = new Date($aCampaign['expire_time']);
                    $oEndDate->setTZbyID('UTC');
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
                                $aEmail = $this->prepareCampaignImpendingExpiryEmail(
                                    $aUser,
                                    $aCampaign['clientid'],
                                    $aCampaign['campaignid'],
                                    'date',
                                    $oEndDate->format($date_format),
                                    $accountType
                                );
                                if ($aEmail !== false) {
                                    if ($this->sendMail($aEmail['subject'], $aEmail['contents'], $aUser['email_address'], $aUser['contact_name'], $aFromDetails)) {
                                        $copiesSent++;
                                        if ($aConf['email']['logOutgoing']) {
                                            phpAds_userlogSetUser(phpAds_userMaintenance);
                                            phpAds_userlogAdd(phpAds_actionWarningMailed, $aPlacement['campaignid'],
                                                "{$aEmail['subject']}\n\n
                                                 {$aUser['contact_name']}({$aUser['email_address']})\n\n
                                                 {$aEmail['contents']}"
                                            );
                                        }
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
    function prepareCampaignImpendingExpiryEmail($aUser, $advertiserId, $placementId, $reason, $value, $type)
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
        $aCampaign = $doCampaigns->toArray();
        if ($aCampaign['clientid'] != $advertiserId) {
            return false;
        }

        // Prepare the email body
        $emailBody  = $this->_prepareCampaignImpendingExpiryEmailBody($advertiserId, $aCampaign);

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
        if ($type == 'advertiser' || $type == 'special') {
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
        if ($type == 'special' || $type == 'advertiser') {
            $email .= $this->_prepareRegards($aAdvertiser['agencyid']);
        } else {
            $email .= $this->_prepareRegards(0);
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
     * @param array   $aCampaign   The placement details.
     */
    function _prepareCampaignImpendingExpiryEmailBody($advertiserId, $aCampaign)
    {
        // Load required strings
        global $strCampaign, $strBanner, $strLinkedTo, $strNoBanners;

        // Prepare the result
        $emailBody = '';

        // Add the name of the placement to the report
        $emailBody .= $strCampaign . ' ';
        $emailBody .= strip_tags(phpAds_buildName($aCampaign['campaignid'], $aCampaign['campaignname'])) . "\n";
        // Add a URL link to the stats page of the campaign
        $page = 'stats.php?clientid='. $advertiserId . '&campaignid=' . $aCampaign['campaignid'] .'&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=';
        $emailBody .= MAX::constructURL(MAX_URL_ADMIN, $page) . "\n";
        // Add a separator after the placement and before the ads
        $emailBody .= "-------------------------------------------------------\n\n";
        // Get the ads in the placement
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $aCampaign['campaignid'];
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
            // No ads in the campaign!
            $emailBody .= ' ' . $strNoBanners . "\n\n";
        }
        // Add closing divider
        $emailBody .= "-------------------------------------------------------\n\n";

        // Return the email body
        return $emailBody;
    }

    function sendCampaignActivatedDeactivatedEmail($campaignId, $reason = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doClient = OA_Dal::factoryDO('clients');
        $doCampaigns->joinAdd($doClient);
        $doCampaigns->get('campaignid', $campaignId);
        $aLinkedUsers = $this->getUsersLinkedToAccount('clients', $doCampaigns->clientid);
        $aAdvertiser = $this->_loadAdvertiser($doCampaigns->clientid);
        // Add the advertiser to the linked users if there isn't any linked user with the advertiser's email address
        $aLinkedUsers = $this->_addAdvertiser($aAdvertiser, $aLinkedUsers);
        $copiesSent = 0;

        if (!empty($aLinkedUsers) && is_array($aLinkedUsers)) {
            if ($aConf['email']['useManagerDetails'])
                $aFromDetails = $this->_getAgencyFromDetails($aAdvertiser['agencyid']);
            foreach ($aLinkedUsers as $aUser) {
                $aEmail = $this->prepareCampaignActivatedDeactivatedEmail($aUser, $doCampaigns->campaignid, $reason);
                if ($aEmail !== false) {
                    if ($this->sendMail($aEmail['subject'], $aEmail['contents'], $aUser['email_address'], $aUser['contact_name'], $aFromDetails)) {
                        $copiesSent++;
                        if ($aConf['email']['logOutgoing']) {
                            phpAds_userlogSetUser(phpAds_userMaintenance);
                            phpAds_userlogAdd(
                                ((is_null($reason)) ? phpAds_actionActivationMailed : phpAds_actionDeactivationMailed),
                                $doPlacement->campaignid,
                                "{$aEmail['subject']}\n\n
                                 {$aUser['contact_name']}({$aUser['email_address']})\n\n
                                 {$aEmail['contents']}"
                            );
                        }
                    }
                }
                        }
            // Restore the default language strings
            Language_Loader::load('default');
        }
        return $copiesSent;
    }

    /**
     * A method for preparing an advertiser's "campaign activated" or
     * "campaign deactivated" report.
     *
     * @param string  $campaignId The ID of the activated campaign.
     * @param integer $reason      An optional binary flag field containting the
     *                             representation of the reason(s) the campaign
     *                             was deactivated:
     *                                   2  - No more impressions
     *                                   4  - No more clicks
     *                                   8  - No more conversions
     *                                   16 - Campaign ended (due to date)
     * @return boolean|array False, if the report could not be created, otherwise
     *                       an array of four elements:
     *                          'subject'   => The email subject line.
     *                          'contents'  => The body of the email report.
     *                          'userEmail' => The email address to send the report to.
     *                          'userName'  => The real name of the email address, or null.
     */
    function prepareCampaignActivatedDeactivatedEmail($aUser, $campaignId, $reason = null)
    {
        Language_Loader::load('default',$aUser['language']);

        if (is_null($reason)) {
            OA::debug('   - Preparing "campaign activated" email for campaign ID ' . $campaignId. '.', PEAR_LOG_DEBUG);
        } else {
            OA::debug('   - Preparing "campaign deactivated" email for campaign ID ' . $campaignId. '.', PEAR_LOG_DEBUG);
        }

        // Load the required strings
        global $strMailHeader, $strSirMadam,
               $strMailBannerActivatedSubject, $strMailBannerDeactivatedSubject,
               $strMailBannerActivated, $strMailBannerDeactivated,
               $strNoMoreImpressions, $strNoMoreClicks, $strNoMoreConversions,
               $strAfterExpire;

        // Fetch the campaign
        $aCampaign = $this->_loadCampaign($campaignId);
        if ($aCampaign === false) {
            return false;
        }

        // Fetch the campaign's owning advertiser
        $aAdvertiser = $this->_loadAdvertiser($aCampaign['clientid']);
        if ($aAdvertiser === false) {
            return false;
        }

        // Prepare the email body
        $emailBody = $this->_prepareCampaignActivatedDeactivatedEmailBody($aCampaign);

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
            if ($reason & OX_CAMPAIGN_DISABLED_IMPRESSIONS) {
                $email .= "\n  - " . $strNoMoreImpressions;
            }
            if ($reason & OX_CAMPAIGN_DISABLED_CLICKS) {
                $email .= "\n  - " . $strNoMoreClicks;
            }
            if ($reason & OX_CAMPAIGN_DISABLED_CONVERSIONS) {
                $email .= "\n  - " . $strNoMoreConversions;
            }
            if ($reason & OX_CAMPAIGN_DISABLED_DATE) {
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

    /**
     * A private method to prepare the body of an advertiser's "campaign activated"
     * or "campaign deactivated" report email.
     *
     * @access private
     * @param integer $advertiserId The advertiser's ID.
     * @param array   $acampaign    The campaign details.
     */
    function _prepareCampaignActivatedDeactivatedEmailBody($aCampaign)
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

        // Add the name of the campaign to the report
        $emailBody .= "\n" . sprintf($strCampaignPrint, $strCampaign) . ' ';
        $emailBody .= strip_tags(phpAds_buildName($aCampaign['campaignid'], $aCampaign['campaignname'])) . "\n";

        // Add a URL link to the stats page of the campaign
        $page = 'stats.php?clientid='. $aCampaign['clientid'] . '&campaignid=' . $aCampaign['campaignid'] .'&statsBreakdown=day&entity=campaign&breakdown=history&period_preset=all_stats&period_start=&period_end=';
        $emailBody .= MAX::constructURL(MAX_URL_ADMIN, $page) . "\n";
        // Add a nice divider
        $emailBody .= "=======================================================\n\n";
        // Fetch all ads in the campaign
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $aCampaign['campaignid'];
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

    function _createPrefsListPerAccount($accountType)
    {
        $type = strtolower($accountType);
        return array(
            'warn_email_' . $type,
            'warn_email_' . $type . '_impression_limit',
            'warn_email_' . $type . '_day_limit',
        );
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
     * A private method to load the details of a campaign from the database.
     *
     * @param integer $campaignId The ID of the campaign to load.
     * @return false|array False if the campaign cannot be loaded, an array of the
     *                     campaign's details from the database otherwise.
     */
    function _loadCampaign($campaignId)
    {
        // Get the campaign's details
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignid = $campaignId;
        $doCampaigns->find();
        if (!$doCampaigns->fetch()) {
            OA::debug('   - Error obtaining details for campaign ID ' . $campaignId . '.', PEAR_LOG_ERR);
            return false;
        }
        $aCampaign = $doCampaigns->toArray();
        return $aCampaign;
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

        global $strMailFooter;

        $regards   = '';
        $useAgency = false;
        if ($agencyId != 0 && $aConf['email']['useManagerDetails']) {
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
        if ($agencyId == 0 || !$aConf['email']['useManagerDetails'] || $useAgency) {
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
            return;
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
    function sendMail($subject, $contents, $userEmail, $userName = null, $fromDetails = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        if (defined('DISABLE_ALL_EMAILS') || $aConf['debug']['disableSendEmails']) {
            return true;
        }
        global $phpAds_CharSet;

        // If not Agency details send email using Administrator's details
        if (empty($fromDetails)) {
            $fromDetails['name'] = $aConf['email']['fromName'];
            $fromDetails['emailAddress'] = $aConf['email']['fromAddress'];
        }

    	// For the time being we're sending plain text emails only, so decode any HTML entities
    	$contents = html_entity_decode($contents, ENT_QUOTES);

    	// Build the "to:" header for the email
    	if (!get_cfg_var('SMTP')) {
    		$toParam = '"'.$userName.'" <'.$userEmail.'>';
    	} else {
    		$toParam = $userEmail;
    	}
    	// Build additional email headers
    	$headersParam = "MIME-Version: 1.0\r\n";
    	if (isset($phpAds_CharSet)) {
    		$headersParam .= "Content-Type: text/plain; charset=" . $phpAds_CharSet . "\r\n";
    	}
    	$headersParam .= "Content-Transfer-Encoding: 8bit\r\n";
    	if (get_cfg_var('SMTP')) {
    		$headersParam .= 'To: "' . $userName . '" <' . $userEmail . ">\r\n";
    	}
    	$headersParam .= 'From: "' . $fromDetails['name'] . '" <' . $fromDetails['emailAddress'] . '>' . "\r\n";
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

    /**
     * A private method to add the advertiser in the mailing list. If advertiser's email address already
     * exists as a linked user email address the advertiser will not be added again to the mailing list.
     *
     * @access private
     * @param array $aAdvertiser   The Advertiser to be added in the mailing list.
     * @param array $aLinkedUsers  The linked users to an account.
     *
     * @return array $aLinkedUsers  The linked users that are going to be mailed
     */
    function _addAdvertiser($aAdvertiser, $aLinkedUsers)
    {
        $duplicatedEmail = false;
        if (!is_array($aLinkedUsers) || empty($aLinkedUsers)) {
            $aLinkedUsers = array();
        } else {
            foreach ($aLinkedUsers as $aUser) {
                if ($aUser['email_address'] == $aAdvertiser['email']) {
                    $duplicatedEmail = true;
                    break;
                }
            }
        }
        if (!$duplicatedEmail) {
            $aLinkedUsers[] = array(
                                  'email_address' => $aAdvertiser['email'],
                                  'contact_name'  => $aAdvertiser['contact'],
                                  'language'      => null,
                                  'user_id'       => 0
                                 );
        }

        return $aLinkedUsers;
    }

    /**
     * Check if any of the email address that are going to be used to send the
     * impending expiration emails are duplicated and remove the duplicated users
     * that own the email address from the linked users list. The order for removing
     * duplicated users is: Advertiser, linked users to advertiser, and Manager
     *
     * @param  array $aLinkedUsers         The linked user list that has to be checked
     * @return array $aLinkedUsersToEmail  The linked user list that are going to be emailed
     */
    function _deleteDuplicatedUser($aLinkedUsers)
    {
        $aLinkedUsersToEmail = array();
        $aEmailAddressUsed = array();

        foreach ($aLinkedUsers['admin'] as $aUser) {
            $aEmailAddressUsed[] = $aUser['email_address'];
        }
        $aLinkedUsersToEmail['admin'] = $aLinkedUsers['admin'];

        foreach ($aLinkedUsers['manager'] as $aUser) {
            if (!in_array($aUser['email_address'], $aEmailAddressUsed)) {
                $aEmailAddressUsed[] = $aUser['email_address'];
                $aLinkedUsersToEmail['manager'][] = $aUser;
            }
        }

        foreach ($aLinkedUsers['advertiser'] as $aUser) {
            if (!in_array($aUser['email_address'], $aEmailAddressUsed)) {
                $aEmailAddressUsed[] = $aUser['email_address'];
                $aLinkedUsersToEmail['advertiser'][] = $aUser;
            }
        }

        if (!in_array($aLinkedUsers['special']['advertiser']['email_address'], $aEmailAddressUsed))
            $aLinkedUsersToEmail['special']['advertiser'] = $aLinkedUsers['special']['advertiser'];

        return $aLinkedUsersToEmail;
    }

    function _getAgencyFromDetails($agencyId)
    {
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->get($agencyId);
        $aAgency = $doAgency->toArray();
        if (!empty($aAgency['email'])) {
            $aFromDetails['emailAddress'] = $aAgency['email'];
            $aFromDetails['name'] = $aAgency['name'];
            return $aFromDetails;
        }
        return;
    }

    function clearCache()
    {
        unset($this->aAdminCache);
        unset($this->aAdminCache);
        unset($this->aClientCache);
    }

    function convertStartEndDate(&$oStartDate, &$oEndDate, $oTimezone)
    {
        if (isset($oStartDate)) {
            $oStartTz = new Date($oStartDate);
            $oStartTz->convertTZ($oTimezone);
            $oStartTz->setHour(0);
            $oStartTz->setMinute(0);
            $oStartTz->setSecond(0);
            if ($oStartTz->after($oStartDate)) {
                $oStartTz->subtractSpan(new Date_Span('1-0-0-0'));
            }
        } else {
            $oStartTz = null;
        }


        if (!isset($oEndDate)) {
            $oEndDate = new Date();
        }

        $oEndTz   = new Date($oEndDate);
        $oEndTz->convertTZ($oTimezone);
        $oEndTz->setHour(0);
        $oEndTz->setMinute(0);
        $oEndTz->setSecond(0);
        $oEndTz->subtractSeconds(1);
        if ($oEndTz->after($oEndDate)) {
            $oEndTz->subtractSpan(new Date_Span('1-0-0-0'));
        }

        $oStartDate = $oStartTz;
        $oEndDate   = $oEndTz;
    }

}

?>
