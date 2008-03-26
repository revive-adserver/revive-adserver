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

// Required files
require_once MAX_PATH . '/lib/max/language/Default.php';
require_once MAX_PATH . '/lib/max/other/lib-io.inc.php';
require_once MAX_PATH . '/lib/max/other/lib-userlog.inc.php';
require_once MAX_PATH . '/www/admin/lib-gui.inc.php';

require_once MAX_PATH . '/lib/OA/Preferences.php';
require_once MAX_PATH . '/lib/OA/Permission.php';
require_once MAX_PATH . '/lib/OA/Auth.php';

$oDbh = OA_DB::singleton();
if (PEAR::isError($oDbh))
{
    // Check if UI is enabled
    if (!$conf['ui']['enabled']) {
        Language_Default::load();
        phpAds_PageHeader(OA_Auth::login($checkRedirectFunc));
        phpAds_ShowBreak();
        echo "<br /><img src='images/info.gif' align='absmiddle'>&nbsp;";
        echo $strNoAdminInterface;
        phpAds_PageFooter();
        exit;
    }

    // This text isn't translated, because if it is shown the language files are not yet loaded
    phpAds_Die ("A fatal error occurred", MAX_PRODUCT_NAME." can't connect to the database.
                Because of this it isn't possible to use the administrator interface. The delivery
                of banners might also be affected. Possible reasons for the problem are:
                <ul><li>The database server isn't functioning at the moment</li>
                <li>The location of the database server has changed</li>
                <li>The username or password used to contact the database server are not correct</li>
                <li>PHP has not loaded the MySQL Extension</li>
                </ul>");
}

// First thing to do is clear the $session variable to
// prevent users from pretending to be logged in.
unset($session);

// Authorize the user
OA_Start();

// Load the account's preferences
OA_Preferences::loadPreferences();
$pref = $GLOBALS['_MAX']['PREF'];

// Set time zone to local
OA_setTimeZoneLocal();

// Load the required language files
Language_Default::load();

// Register variables
phpAds_registerGlobalUnslashed(
     'affiliateid'
    ,'agencyid'
    ,'bannerid'
    ,'campaignid'
    ,'channelid'
    ,'clientid'
    ,'day'
    ,'trackerid'
    ,'userlogid'
    ,'zoneid'
);

if (!isset($affiliateid))   $affiliateid = (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) ? OA_Permission::getEntityId() : '';
if (!isset($agencyid))      $agencyid = (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) ? '' : OA_Permission::getAgencyId();
if (!isset($bannerid))      $bannerid = '';
if (!isset($campaignid))    $campaignid = '';
if (!isset($channelid))     $channelid = '';
if (!isset($clientid))      $clientid = (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) ? OA_Permission::getEntityId() : '';
if (!isset($day))           $day = '';
if (!isset($trackerid))     $trackerid = '';
if (!isset($userlogid))     $userlogid = '';
if (!isset($zoneid))        $zoneid = '';

/**
 * Starts or continue existing session
 *
 * @param unknown_type $checkRedirectFunc
 */
function OA_Start($checkRedirectFunc = null)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    global $session;

    // XXX: Why not try loading session data when OpenX is not installed?
    //if ($conf['openads']['installed'])
    if (OA_INSTALLATION_STATUS == OA_INSTALLATION_STATUS_INSTALLED)
    {
        phpAds_SessionDataFetch();
    }
    if (!OA_Auth::isLoggedIn() || OA_Auth::suppliedCredentials()) {
        // Required files
        include_once MAX_PATH . '/lib/max/language/Default.php';
        // Load the required language files
        Language_Default::load();

        phpAds_SessionDataRegister(OA_Auth::login($checkRedirectFunc));
    }
    // Overwrite certain preset preferences
    if (!empty($session['language']) && $session['language'] != $GLOBALS['pref']['language']) {
        $GLOBALS['_MAX']['CONF']['max']['language'] = $session['language'];
    }

}

// Setup navigation
function MMM_buildNavigation()
{
    global $affiliateid, $agencyid, $bannerid, $campaignid, $channelid, $clientid, $day, $trackerid, $userlogid, $zoneid;
    global $pref;

    $aConf = $GLOBALS['_MAX']['CONF'];

    $GLOBALS['OA_Navigation'] = array (
        OA_ACCOUNT_ADMIN => array (
            "1"                         =>  array("dashboard.php" => $GLOBALS['strHome']),
            "2"                         =>  array("stats.php" => $GLOBALS['strStats']),
              "2.1"                     =>  array("stats.php?1=1" => $GLOBALS['strClientsAndCampaigns']),
                "2.1.1"                 =>  array("stats.php?entity=advertiser&breakdown=history&clientid=$clientid" => $GLOBALS['strClientHistory']),
                  "2.1.1.1"             =>  array("stats.php?entity=advertiser&breakdown=daily&clientid=$clientid&day=$day" => $GLOBALS['strDailyStats']),
                "2.1.2"                 =>  array("stats.php?entity=advertiser&breakdown=campaigns&clientid=$clientid" => $GLOBALS['strCampaignOverview']),
                  "2.1.2.1"             =>  array("stats.php?entity=campaign&breakdown=history&clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strCampaignHistory']),
                    "2.1.2.1.1"         =>  array("stats.php?entity=campaign&breakdown=daily&clientid=$clientid&campaignid=$campaignid&day=$day" => $GLOBALS['strDailyStats']),
                  "2.1.2.2"             =>  array("stats.php?entity=campaign&breakdown=banners&clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strBannerOverview']),
                    "2.1.2.2.1"         =>  array("stats.php?entity=banner&breakdown=history&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strBannerHistory']),
                      "2.1.2.2.1.1"     =>  array("stats.php?entity=banner&breakdown=daily&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&day=$day" => $GLOBALS['strDailyStats']),
                    "2.1.2.2.2"         =>  array("stats.php?entity=banner&breakdown=affiliates&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strPublisherDistribution']),
                      "2.1.2.2.2.1"     =>  array("stats.php?entity=banner&breakdown=affiliate-history&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&affiliateid=$affiliateid" => $GLOBALS['strDistributionHistory']),
                        "2.1.2.2.2.1.1" =>  array("stats.php?entity=banner&breakdown=daily&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&affiliateid=$affiliateid&day=$day" => $GLOBALS['strDailyStats']),
                      "2.1.2.2.2.2"     =>  array("stats.php?entity=banner&breakdown=zone-history&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strDistributionHistory']),
                        "2.1.2.2.2.2.1" =>  array("stats.php?entity=banner&breakdown=daily&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $GLOBALS['strDailyStats']),
                    "2.1.2.2.3"         =>  array("stats.php?entity=banner&breakdown=targeting&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strTargetStats']),
                      "2.1.2.2.3.1"     =>  array("stats.php?entity=banner&breakdown=targeting-daily&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strDailyStats']),
                  "2.1.2.3"             =>  array("stats.php?entity=campaign&breakdown=affiliates&clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strPublisherDistribution']),
                    "2.1.2.3.1"         =>  array("stats.php?entity=campaign&breakdown=affiliate-history&clientid=$clientid&campaignid=$campaignid&affiliateid=$affiliateid" => $GLOBALS['strDistributionHistory']),
                      "2.1.2.3.1.1"     =>  array("stats.php?entity=campaign&breakdown=daily&clientid=$clientid&campaignid=$campaignid&affiliateid=$affiliateid&day=$day" => $GLOBALS['strDailyStats']),
                    "2.1.2.3.2"         =>  array("stats.php?entity=campaign&breakdown=zone-history&clientid=$clientid&campaignid=$campaignid&affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strDistributionHistory']),
                      "2.1.2.3.2.1"     =>  array("stats.php?entity=advertiser&breakdown=daily&clientid=$clientid&campaignid=$campaignid&affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $GLOBALS['strDailyStats']),
                  "2.1.2.4"             =>  array("stats.php?entity=campaign&breakdown=targeting&clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strTargetStats']),
                    "2.1.2.4.1"         =>  array("stats.php?entity=campaign&breakdown=targeting-daily&clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strDailyStats']),
                  "2.1.2.5"             =>  array("stats.php?entity=campaign&breakdown=optimise&clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strOptimise']),
                  "2.1.2.6"             =>  array("stats.php?entity=campaign&breakdown=keywords&clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strKeywordStatistics']),
                "2.1.3"                 =>  array("stats.php?entity=advertiser&breakdown=affiliates&clientid=$clientid" => $GLOBALS['strPublisherDistribution']),
                  "2.1.3.1"             =>  array("stats.php?entity=advertiser&breakdown=affiliate-history&clientid=$clientid&affiliateid=$affiliateid" => $GLOBALS['strDistributionHistory']),
                    "2.1.3.1.1"         =>  array("stats.php?entity=advertiser&breakdown=daily&clientid=$clientid&affiliateid=$affiliateid&day=$day" => $GLOBALS['strDailyStats']),
                  "2.1.3.2"             =>  array("stats.php?entity=advertiser&breakdown=zone-history&clientid=$clientid&affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strDistributionHistory']),
                    "2.1.3.2.1"         =>  array("stats.php?entity=advertiser&breakdown=daily&clientid=$clientid&affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $GLOBALS['strDailyStats']),
              "2.2"                     =>  array("stats.php?entity=global&breakdown=history" => $GLOBALS['strGlobalHistory']),
                "2.2.1"                 =>  array("stats.php?entity=global&breakdown=daily&day=$day" => $GLOBALS['strDailyStats']),
              "2.4"                     =>  array("stats.php?entity=global&breakdown=affiliates" => $GLOBALS['strAffiliatesAndZones']),
                "2.4.1"                 =>  array("stats.php?entity=affiliate&breakdown=history&affiliateid=$affiliateid" => $GLOBALS['strAffiliateHistory']),
                  "2.4.1.1"             =>  array("stats.php?entity=affiliate&breakdown=daily&affiliateid=$affiliateid&day=$day" => $GLOBALS['strDailyStats']),
                "2.4.2"                 =>  array("stats.php?entity=affiliate&breakdown=zones&affiliateid=$affiliateid" => $GLOBALS['strZoneOverview']),
                  "2.4.2.1"             =>  array("stats.php?entity=zone&breakdown=history&affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strZoneHistory']),
                    "2.4.2.1.1"         =>  array("stats.php?entity=zone&breakdown=daily&affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $GLOBALS['strDailyStats']),
                  "2.4.2.2"             =>  array("stats.php?entity=zone&breakdown=campaigns&affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strCampaignDistribution']),
                    "2.4.2.2.1"         =>  array("stats.php?entity=zone&breakdown=campaign-history&affiliateid=$affiliateid&zoneid=$zoneid&campaignid=$campaignid" => $GLOBALS['strDistributionHistory']),
                      "2.4.2.2.1.1"     =>  array("stats.php?entity=zone&breakdown=daily&affiliateid=$affiliateid&zoneid=$zoneid&campaignid=$campaignid&day=$day" => $GLOBALS['strDailyStats']),
                    "2.4.2.2.2"         =>  array("stats.php?entity=zone&breakdown=banner-history&affiliateid=$affiliateid&zoneid=$zoneid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strDistributionHistory']),
                      "2.4.2.2.2.1"     =>  array("stats.php?entity=zone&breakdown=daily&affiliateid=$affiliateid&zoneid=$zoneid&campaignid=$campaignid&bannerid=$bannerid&day=$day" => $GLOBALS['strDailyStats']),
                "2.4.3"                 =>  array("stats.php?entity=affiliate&breakdown=campaigns&affiliateid=$affiliateid" => $GLOBALS['strCampaignDistribution']),
                  "2.4.3.1"             =>  array("stats.php?entity=affiliate&breakdown=campaign-history&affiliateid=$affiliateid&campaignid=$campaignid" => $GLOBALS['strDistributionHistory']),
                    "2.4.3.1.1"         =>  array("stats.php?entity=affiliate&breakdown=daily&affiliateid=$affiliateid&campaignid=$campaignid&day=$day" => $GLOBALS['strDailyStats']),
                  "2.4.3.2"             =>  array("stats.php?entity=affiliate&breakdown=banner-history&affiliateid=$affiliateid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strDistributionHistory']),
                    "2.4.3.2.1"         =>  array("stats.php?entity=affiliate&breakdown=daily&affiliateid=$affiliateid&campaignid=$campaignid&bannerid=$bannerid&day=$day" => $GLOBALS['strDailyStats']),
              "2.5"                     =>  array("stats.php?entity=global&breakdown=misc" => $GLOBALS['strMiscellaneous']),
            "3"                         =>  array("report-index.php" => $GLOBALS['strReports']),
            "4"                         =>  array("agency-index.php" => $GLOBALS['strAdminstration']),
              "4.1"                     =>  array("agency-index.php" => $GLOBALS['strAgencyManagement']),
                "4.1.1"                 =>  array("agency-edit.php" => $GLOBALS['strAddAgency']),
                "4.1.2"                 =>  array("agency-edit.php?agencyid=$agencyid" => $GLOBALS['strAgencyProperties']),
                "4.1.3"                 =>  array("agency-access.php?agencyid=$agencyid" => $GLOBALS['strUserAccess']),
                  "4.1.3.1"             =>  array("agency-user-start.php?agencyid=$agencyid" => $GLOBALS['strLinkNewUser']),
                  "4.1.3.2"             =>  array("agency-user.php?agencyid=$agencyid&userid=".$_GET['userid'] => $GLOBALS['strUserProperties']),
              "4.3"                     =>  array("admin-generate.php" => $GLOBALS['strGenerateBannercode']),
              "4.4"                     =>  array("admin-access.php" => $GLOBALS['strAdminAccess']),
                "4.4.1"                 =>  array("admin-user-start.php" => $GLOBALS['strLinkNewUser']),
                "4.4.2"                 =>  array("admin-user.php?userid=".$_GET['userid'] => $GLOBALS['strUserProperties']),
            "5"                         =>  array("account-index.php" => $GLOBALS['strMyAccount']),
              "5.1"                     =>  array("account-user-name-language-timezone.php" => $GLOBALS['strUserPreferences']),
              "5.2"                     =>  array("account-preferences-index.php" => $GLOBALS['strAccountPreferences']),
              "5.3"                     =>  array("account-settings-index.php" => $GLOBALS['strGlobalSettings']),
              "5.4"                     =>  array("userlog-index.php" => $GLOBALS['strUserLog']),
                "5.4.1"                 =>  array("userlog-details.php?userlogid=$userlogid" => $GLOBALS['strUserLogDetails']),
              "5.5"                     =>  array("maintenance-index.php" => $GLOBALS['strMaintenance']),
              "5.6"                     =>  array("updates-product.php" => $GLOBALS['strProductUpdates']),
              "5.7"                     =>  array("channel-index.php" => $GLOBALS['strChannelManagement']),
                "5.7.1"                 =>  array("channel-edit.php?agencyid=$agencyid" => $GLOBALS['strAddNewChannel']),
                "5.7.2"                 =>  array("channel-edit.php?agencyid=$agencyid&channelid=$channelid" => $GLOBALS['strChannelProperties']),
                "5.7.3"                 =>  array("channel-acl.php?agencyid=$agencyid&channelid=$channelid" => $GLOBALS['strChannelLimitations'])
        ),

        OA_ACCOUNT_MANAGER => array (
            "1"                         =>  array("dashboard.php" => $GLOBALS['strHome']),
            "2"                         =>  array("stats.php" => $GLOBALS['strStats']),
              "2.1"                     =>  array("stats.php?1=1" => $GLOBALS['strClientsAndCampaigns']),
                "2.1.1"                 =>  array("stats.php?entity=advertiser&breakdown=history&clientid=$clientid" => $GLOBALS['strClientHistory']),
                  "2.1.1.1"             =>  array("stats.php?entity=advertiser&breakdown=daily&clientid=$clientid&day=$day" => $GLOBALS['strDailyStats']),
                "2.1.2"                 =>  array("stats.php?entity=advertiser&breakdown=campaigns&clientid=$clientid" => $GLOBALS['strCampaignOverview']),
                  "2.1.2.1"             =>  array("stats.php?entity=campaign&breakdown=history&clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strCampaignHistory']),
                    "2.1.2.1.1"         =>  array("stats.php?entity=campaign&breakdown=daily&clientid=$clientid&campaignid=$campaignid&day=$day" => $GLOBALS['strDailyStats']),
                  "2.1.2.2"             =>  array("stats.php?entity=campaign&breakdown=banners&clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strBannerOverview']),
                    "2.1.2.2.1"         =>  array("stats.php?entity=banner&breakdown=history&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strBannerHistory']),
                      "2.1.2.2.1.1"     =>  array("stats.php?entity=banner&breakdown=daily&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&day=$day" => $GLOBALS['strDailyStats']),
                    "2.1.2.2.2"         =>  array("stats.php?entity=banner&breakdown=affiliates&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strPublisherDistribution']),
                      "2.1.2.2.2.1"     =>  array("stats.php?entity=banner&breakdown=affiliate-history&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&affiliateid=$affiliateid" => $GLOBALS['strDistributionHistory']),
                        "2.1.2.2.2.1.1" =>  array("stats.php?entity=banner&breakdown=daily&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&affiliateid=$affiliateid&day=$day" => $GLOBALS['strDailyStats']),
                      "2.1.2.2.2.2"     =>  array("stats.php?entity=banner&breakdown=zone-history&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strDistributionHistory']),
                        "2.1.2.2.2.2.1" =>  array("stats.php?entity=banner&breakdown=daily&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $GLOBALS['strDailyStats']),
                    "2.1.2.2.3"         =>  array("stats.php?entity=banner&breakdown=targeting&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strTargetStats']),
                      "2.1.2.2.3.1"     =>  array("stats.php?entity=banner&breakdown=targeting-daily&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strDailyStats']),
                  "2.1.2.3"             =>  array("stats.php?entity=campaign&breakdown=affiliates&clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strPublisherDistribution']),
                    "2.1.2.3.1"         =>  array("stats.php?entity=campaign&breakdown=affiliate-history&clientid=$clientid&campaignid=$campaignid&affiliateid=$affiliateid" => $GLOBALS['strDistributionHistory']),
                      "2.1.2.3.1.1"     =>  array("stats.php?entity=campaign&breakdown=daily&clientid=$clientid&campaignid=$campaignid&affiliateid=$affiliateid&day=$day" => $GLOBALS['strDailyStats']),
                    "2.1.2.3.2"         =>  array("stats.php?entity=campaign&breakdown=zone-history&clientid=$clientid&campaignid=$campaignid&affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strDistributionHistory']),
                      "2.1.2.3.2.1"     =>  array("stats.php?entity=advertiser&breakdown=daily&clientid=$clientid&campaignid=$campaignid&affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $GLOBALS['strDailyStats']),
                  "2.1.2.4"             =>  array("stats.php?entity=campaign&breakdown=targeting&clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strTargetStats']),
                    "2.1.2.4.1"         =>  array("stats.php?entity=campaign&breakdown=targeting-daily&clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strDailyStats']),
                  "2.1.2.5"             =>  array("stats.php?entity=campaign&breakdown=optimise&clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strOptimise']),
                  "2.1.2.6"             =>  array("stats.php?entity=campaign&breakdown=keywords&clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strKeywordStatistics']),
                "2.1.3"                 =>  array("stats.php?entity=advertiser&breakdown=affiliates&clientid=$clientid" => $GLOBALS['strPublisherDistribution']),
                  "2.1.3.1"             =>  array("stats.php?entity=advertiser&breakdown=affiliate-history&clientid=$clientid&affiliateid=$affiliateid" => $GLOBALS['strDistributionHistory']),
                    "2.1.3.1.1"         =>  array("stats.php?entity=advertiser&breakdown=daily&clientid=$clientid&affiliateid=$affiliateid&day=$day" => $GLOBALS['strDailyStats']),
                  "2.1.3.2"             =>  array("stats.php?entity=advertiser&breakdown=zone-history&clientid=$clientid&affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strDistributionHistory']),
                    "2.1.3.2.1"         =>  array("stats.php?entity=advertiser&breakdown=daily&clientid=$clientid&affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $GLOBALS['strDailyStats']),
              "2.2"                     =>  array("stats.php?entity=global&breakdown=history" => $GLOBALS['strGlobalHistory']),
                "2.2.1"                 =>  array("stats.php?entity=global&breakdown=daily&day=$day" => $GLOBALS['strDailyStats']),
              "2.4"                     =>  array("stats.php?entity=global&breakdown=affiliates" => $GLOBALS['strAffiliatesAndZones']),
                "2.4.1"                 =>  array("stats.php?entity=affiliate&breakdown=history&affiliateid=$affiliateid" => $GLOBALS['strAffiliateHistory']),
                  "2.4.1.1"             =>  array("stats.php?entity=affiliate&breakdown=daily&affiliateid=$affiliateid&day=$day" => $GLOBALS['strDailyStats']),
                "2.4.2"                 =>  array("stats.php?entity=affiliate&breakdown=zones&affiliateid=$affiliateid" => $GLOBALS['strZoneOverview']),
                  "2.4.2.1"             =>  array("stats.php?entity=zone&breakdown=history&affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strZoneHistory']),
                    "2.4.2.1.1"         =>  array("stats.php?entity=zone&breakdown=daily&affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $GLOBALS['strDailyStats']),
                  "2.4.2.2"             =>  array("stats.php?entity=zone&breakdown=campaigns&affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strCampaignDistribution']),
                    "2.4.2.2.1"         =>  array("stats.php?entity=zone&breakdown=campaign-history&affiliateid=$affiliateid&zoneid=$zoneid&campaignid=$campaignid" => $GLOBALS['strDistributionHistory']),
                      "2.4.2.2.1.1"     =>  array("stats.php?entity=zone&breakdown=daily&affiliateid=$affiliateid&zoneid=$zoneid&campaignid=$campaignid&day=$day" => $GLOBALS['strDailyStats']),
                    "2.4.2.2.2"         =>  array("stats.php?entity=zone&breakdown=banner-history&affiliateid=$affiliateid&zoneid=$zoneid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strDistributionHistory']),
                      "2.4.2.2.2.1"     =>  array("stats.php?entity=zone&breakdown=daily&affiliateid=$affiliateid&zoneid=$zoneid&campaignid=$campaignid&bannerid=$bannerid&day=$day" => $GLOBALS['strDailyStats']),
                "2.4.3"                 =>  array("stats.php?entity=affiliate&breakdown=campaigns&affiliateid=$affiliateid" => $GLOBALS['strCampaignDistribution']),
                  "2.4.3.1"             =>  array("stats.php?entity=affiliate&breakdown=campaign-history&affiliateid=$affiliateid&campaignid=$campaignid" => $GLOBALS['strDistributionHistory']),
                    "2.4.3.1.1"         =>  array("stats.php?entity=affiliate&breakdown=daily&affiliateid=$affiliateid&campaignid=$campaignid&day=$day" => $GLOBALS['strDailyStats']),
                  "2.4.3.2"             =>  array("stats.php?entity=affiliate&breakdown=banner-history&affiliateid=$affiliateid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strDistributionHistory']),
                    "2.4.3.2.1"         =>  array("stats.php?entity=affiliate&breakdown=daily&affiliateid=$affiliateid&campaignid=$campaignid&bannerid=$bannerid&day=$day" => $GLOBALS['strDailyStats']),
              "2.5"                     =>  array("stats.php?entity=global&breakdown=misc" => $GLOBALS['strMiscellaneous']),
            "3"                         =>  array("report-index.php" => $GLOBALS['strReports']),
            "4"                         =>  array("advertiser-index.php" => $GLOBALS['strAdminstration']),
              "4.1"                     =>  array("advertiser-index.php" => $GLOBALS['strClientsAndCampaigns']),
                "4.1.1"                 =>  array("advertiser-edit.php" => $GLOBALS['strAddClient']),
                "4.1.2"                 =>  array("advertiser-edit.php?clientid=$clientid" => $GLOBALS['strClientProperties']),
                "4.1.3"                 =>  array("advertiser-campaigns.php?clientid=$clientid" => $GLOBALS['strCampaignOverview']),
                  "4.1.3.1"             =>  array("campaign-edit.php?clientid=$clientid" => $GLOBALS['strAddCampaign']),
                  "4.1.3.2"             =>  array("campaign-edit.php?clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strCampaignProperties']),
                  "4.1.3.3"             =>  array("campaign-zone.php?clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strLinkedZones']),
                  "4.1.3.4"             =>  array("campaign-banners.php?clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strBannerOverview']),
                    "4.1.3.4.1"         =>  array("banner-edit.php?clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strAddBanner']),
                    "4.1.3.4.2"         =>  array("banner-edit.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strBannerProperties']),
                    "4.1.3.4.3"         =>  array("banner-acl.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strModifyBannerAcl']),
                    "4.1.3.4.4"         =>  array("banner-zone.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strLinkedZones']),
                    "4.1.3.4.5"         =>  array("banner-swf.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strConvertSWFLinks']),
                    "4.1.3.4.6"         =>  array("banner-advanced.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strAdvanced']),
                    "4.1.3.4.7"         =>  array("adsense-accounts.php" => $GLOBALS['strAdSenseAccounts']),
                       "4.1.3.4.7.1"    =>  array("adsense-link.php" => $GLOBALS['strLinkAdSenseAccount']),
                       "4.1.3.4.7.2"    =>  array("adsense-create.php" => $GLOBALS['strCreateAdSenseAccount']),
                       "4.1.3.4.7.3"    =>  array("adsense-edit.php" => $GLOBALS['strEditAdSenseAccount']),
                  "4.1.3.5"             =>  array("campaign-trackers.php?clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strLinkedTrackers']),
                "4.1.4"                 =>  array("advertiser-trackers.php?clientid=$clientid" => $GLOBALS['strTrackerOverview']),
                  "4.1.4.1"             =>  array("tracker-edit.php?clientid=$clientid" => $GLOBALS['strAddTracker']),
                  "4.1.4.2"             =>  array("tracker-edit.php?clientid=$clientid&trackerid=$trackerid" => $GLOBALS['strTrackerProperties']),
                  "4.1.4.3"             =>  array("tracker-campaigns.php?clientid=$clientid&trackerid=$trackerid" => $GLOBALS['strLinkedCampaigns']),
                  "4.1.4.4"             =>  array("tracker-invocation.php?clientid=$clientid&trackerid=$trackerid" => $GLOBALS['strInvocationcode']),
                  "4.1.4.6"             =>  array("tracker-append.php?clientid=$clientid&trackerid=$trackerid" => $GLOBALS['strAppendTrackerCode']),
                  "4.1.4.5"             =>  array("tracker-variables.php?clientid=$clientid&trackerid=$trackerid" => $GLOBALS['strTrackerVariables']),
                  "4.1.5"                 =>  array("advertiser-access.php?clientid=$clientid" => $GLOBALS['strUserAccess']),
                    "4.1.5.1"             =>  array("advertiser-user-start.php?clientid=$clientid" => $GLOBALS['strLinkNewUser']),
                    "4.1.5.2"             =>  array("advertiser-user.php?clientid=$clientid&userid=".$_GET['userid'] => $GLOBALS['strUserProperties']),
              "4.2"                     =>  array("affiliate-index.php" => $GLOBALS['strAffiliatesAndZones']),
                "4.2.1"                 =>  array("affiliate-edit.php" => $GLOBALS['strAddNewAffiliate']),
                "4.2.2"                 =>  array("affiliate-edit.php?affiliateid=$affiliateid" => $GLOBALS['strAffiliateProperties']),
                "4.2.3"                 =>  array("affiliate-zones.php?affiliateid=$affiliateid" => $GLOBALS['strZoneOverview']),
                  "4.2.3.1"             =>  array("zone-edit.php?affiliateid=$affiliateid" => $GLOBALS['strAddNewZone']),
                  "4.2.3.2"             =>  array("zone-edit.php?affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strZoneProperties']),
                  "4.2.3.3"             =>  array("zone-include.php?affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strIncludedBanners']),
                  "4.2.3.4"             =>  array("zone-probability.php?affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strProbability']),
                  "4.2.3.5"             =>  array("zone-invocation.php?affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strInvocationcode']),
                  "4.2.3.6"             =>  array("zone-advanced.php?affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strAdvanced']),
                "4.2.4"                 =>  array("affiliate-channels.php?affiliateid=$affiliateid" => $GLOBALS['strChannelOverview']),
                  "4.2.4.1"             =>  array("channel-edit.php?affiliateid=$affiliateid" => $GLOBALS['strAddNewChannel']),
                  "4.2.4.2"             =>  array("channel-edit.php?affiliateid=$affiliateid&channelid=$channelid" => $GLOBALS['strChannelProperties']),
                  "4.2.4.3"             =>  array("channel-acl.php?affiliateid=$affiliateid&channelid=$channelid" => $GLOBALS['strChannelLimitations']),
                "4.2.5"                 =>  array("affiliate-invocation.php?affiliateid=$affiliateid" => $GLOBALS['strAffiliateInvocation']),
                "4.2.7"                 =>  array("affiliate-access.php?affiliateid=$affiliateid" => $GLOBALS['strUserAccess']),
                  "4.2.7.1"             =>  array("affiliate-user-start.php?affiliateid=$affiliateid" => $GLOBALS['strLinkNewUser']),
                  "4.2.7.2"             =>  array("affiliate-user.php?affiliateid=$affiliateid&userid=".$_GET['userid'] => $GLOBALS['strUserProperties']),
              "4.3"                     =>  array("admin-generate.php" => $GLOBALS['strGenerateBannercode']),
              "4.4"                 =>  array("agency-access.php?agencyid=$agencyid" => $GLOBALS['strUserAccess']),
                "4.4.1"             =>  array("agency-user-start.php?agencyid=$agencyid" => $GLOBALS['strLinkNewUser']),
                "4.4.2"             =>  array("agency-user.php?userid=".$_GET['userid'] => $GLOBALS['strUserProperties']),
            "5"                         =>  array("account-index.php" => $GLOBALS['strMyAccount']),
              "5.1"                     =>  array("account-user-name-language-timezone.php" => $GLOBALS['strUserPreferences']),
              "5.2"                     =>  array("account-preferences-index.php" => $GLOBALS['strAccountPreferences']),
              "5.4"                     =>  array("userlog-index.php" => $GLOBALS['strUserLog']),
              "5.7"                     =>  array("channel-index.php" => $GLOBALS['strChannelManagement']),
                "5.7.1"                 =>  array("channel-edit.php?agencyid=$agencyid" => $GLOBALS['strAddNewChannel']),
                "5.7.2"                 =>  array("channel-edit.php?agencyid=$agencyid&channelid=$channelid" => $GLOBALS['strChannelProperties']),
                "5.7.3"                 =>  array("channel-acl.php?agencyid=$agencyid&channelid=$channelid" => $GLOBALS['strChannelLimitations'])
        ),

        OA_ACCOUNT_ADVERTISER => array (
            "1"                         =>  array("stats.php?entity=advertiser&breakdown=history&clientid=$clientid" => $GLOBALS['strStats']),
              "1.1"                     =>  array("stats.php?entity=advertiser&breakdown=history&clientid=$clientid" => $GLOBALS['strClientHistory']),
                "1.1.1"                 =>  array("stats.php?entity=advertiser&breakdown=daily&clientid=$clientid&day=$day" => $GLOBALS['strDailyStats']),
              "1.2"                     =>  array("stats.php?entity=advertiser&breakdown=campaigns&clientid=$clientid" => $GLOBALS['strCampaignOverview']),
                "1.2.1"                 =>  array("stats.php?entity=campaign&breakdown=history&clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strCampaignHistory']),
                  "1.2.1.1"             =>  array("stats.php?entity=campaign&breakdown=daily&clientid=$clientid&campaignid=$campaignid&day=$day" => $GLOBALS['strDailyStats']),
                "1.2.2"                 =>  array("stats.php?entity=campaign&breakdown=banners&clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strBannerOverview']),
                  "1.2.2.1"             =>  array("stats.php?entity=banner&breakdown=history&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strBannerHistory']),
                    "1.2.2.1.1"         =>  array("stats.php?entity=banner&breakdown=daily&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&day=$day" => $GLOBALS['strDailyStats']),
                  "1.2.2.2"             =>  array("banner-edit.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strBannerProperties']),
                  "1.2.2.3"             =>  array("banner-swf.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strConvertSWFLinks']),
                  "1.2.2.4"             =>  array("stats.php?entity=banner&breakdown=affiliates&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strPublisherDistribution']),
                    "1.2.2.4.1"         =>  array("stats.php?entity=banner&breakdown=affiliate-history&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&affiliateid=$affiliateid" => $GLOBALS['strDistributionHistory']),
                      "1.2.2.4.1.1"     =>  array("stats.php?entity=banner&breakdown=daily&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&affiliateid=$affiliateid&day=$day" => $GLOBALS['strDailyStats']),
                    "1.2.2.4.2"         =>  array("stats.php?entity=banner&breakdown=zone-history&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strDistributionHistory']),
                      "1.2.2.4.2.1"     =>  array("stats.php?entity=banner&breakdown=daily&clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $GLOBALS['strDailyStats']),
                "1.2.3"                 =>  array("stats.php?entity=campaign&breakdown=affiliates&clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strPublisherDistribution']),
                  "1.2.3.1"             =>  array("stats.php?entity=campaign&breakdown=affiliate-history&clientid=$clientid&campaignid=$campaignid&affiliateid=$affiliateid" => $GLOBALS['strDistributionHistory']),
                    "1.2.3.1.1"         =>  array("stats.php?entity=campaign&breakdown=daily&clientid=$clientid&campaignid=$campaignid&affiliateid=$affiliateid&day=$day" => $GLOBALS['strDailyStats']),
                  "1.2.3.2"             =>  array("stats.php?entity=campaign&breakdown=zone-history&clientid=$clientid&campaignid=$campaignid&affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strDistributionHistory']),
                    "1.2.3.2.1"         =>  array("stats.php?entity=advertiser&breakdown=daily&clientid=$clientid&campaignid=$campaignid&affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $GLOBALS['strDailyStats']),
                //"1.2.4"                   =>  array("stats-placement-target.php?clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strTargetStats']),
              "1.3"                     =>  array("stats.php?entity=advertiser&breakdown=affiliates&clientid=$clientid" => $GLOBALS['strPublisherDistribution']),
                  "1.3.1"               =>  array("stats.php?entity=advertiser&breakdown=affiliate-history&clientid=$clientid&affiliateid=$affiliateid" => $GLOBALS['strDistributionHistory']),
                    "1.3.1.1"           =>  array("stats.php?entity=advertiser&breakdown=daily&clientid=$clientid&affiliateid=$affiliateid&day=$day" => $GLOBALS['strDailyStats']),
                  "1.3.2"               =>  array("stats.php?entity=advertiser&breakdown=zone-history&clientid=$clientid&affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strDistributionHistory']),
                    "1.3.2.1"           =>  array("stats.php?entity=advertiser&breakdown=daily&clientid=$clientid&affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $GLOBALS['strDailyStats']),
            /*
            '2'                         =>  array("advertiser-campaigns.php?clientid=$clientid" => $GLOBALS['strAdminstration']),
                '2.1'                   =>  array("advertiser-campaigns.php?clientid=$clientid" => $GLOBALS['strCampaignOverview']),
                  '2.1.1'               =>  array("campaign-banners.php?clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strBannerOverview']),
                    '2.1.1.1'           =>  array("banner-edit.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strBannerProperties']),
                    '2.1.1.2'           =>  array("banner-acl.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strModifyBannerAcl']),
                    '2.1.1.3'           =>  array("banner-advanced.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strAdvanced']),
            */
              "2.3"                     =>  array("advertiser-access.php?clientid=$clientid" => $GLOBALS['strUserAccess']),
                "2.3.1"                 =>  array("advertiser-user-start.php?clientid=$clientid" => $GLOBALS['strLinkNewUser']),
                "2.3.2"                 =>  array("advertiser-user.php?clientid=$clientid&userid=".$_GET['userid'] => $GLOBALS['strUserProperties']),
            "3"                         =>  array("report-index.php?clientid=$clientid" => $GLOBALS['strReports']),
            "5"                         =>  array("account-index.php" => $GLOBALS['strMyAccount']),
              "5.1"                     =>  array("account-user-name-language-timezone.php" => $GLOBALS['strUserPreferences']),
              "5.2"                     =>  array("account-preferences-index.php" => $GLOBALS['strAccountPreferences'])

        ),

        OA_ACCOUNT_TRAFFICKER => array (
            "1"                     =>  array("stats.php?entity=affiliate&breakdown=history&affiliateid=$affiliateid" => $GLOBALS['strStats']),
              "1.1"                 =>  array("stats.php?entity=affiliate&breakdown=history&affiliateid=$affiliateid" => $GLOBALS['strAffiliateHistory']),
                "1.1.1"             =>  array("stats.php?entity=affiliate&breakdown=daily&affiliateid=$affiliateid&day=$day" => $GLOBALS['strDailyStats']),
              "1.2"                 =>  array("stats.php?entity=affiliate&breakdown=zones&affiliateid=$affiliateid" => $GLOBALS['strZoneOverview']),
                "1.2.1"             =>  array("stats.php?entity=zone&breakdown=history&affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strZoneHistory']),
                  "1.2.1.1"         =>  array("stats.php?entity=zone&breakdown=daily&affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $GLOBALS['strDailyStats']),
                "1.2.2"             =>  array("stats.php?entity=zone&breakdown=campaigns&affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strCampaignDistribution']),
                  "1.2.2.1"         =>  array("stats.php?entity=zone&breakdown=campaign-history&affiliateid=$affiliateid&zoneid=$zoneid&campaignid=$campaignid" => $GLOBALS['strDistributionHistory']),
                    "1.2.2.1.1"     =>  array("stats.php?entity=zone&breakdown=daily&affiliateid=$affiliateid&zoneid=$zoneid&campaignid=$campaignid&day=$day" => $GLOBALS['strDailyStats']),
                  "1.2.2.2"         =>  array("stats.php?entity=zone&breakdown=banner-history&affiliateid=$affiliateid&zoneid=$zoneid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strDistributionHistory']),
                    "1.2.2.2.1"     =>  array("stats.php?entity=zone&breakdown=daily&affiliateid=$affiliateid&zoneid=$zoneid&campaignid=$campaignid&bannerid=$bannerid&day=$day" => $GLOBALS['strDailyStats']),
              "1.3"                 =>  array("stats.php?entity=affiliate&breakdown=campaigns&affiliateid=$affiliateid" => $GLOBALS['strCampaignDistribution']),
                "1.3.1"             =>  array("stats.php?entity=affiliate&breakdown=campaign-history&affiliateid=$affiliateid&campaignid=$campaignid" => $GLOBALS['strDistributionHistory']),
                  "1.3.1.1"         =>  array("stats.php?entity=affiliate&breakdown=daily&affiliateid=$affiliateid&campaignid=$campaignid&day=$day" => $GLOBALS['strDailyStats']),
                "1.3.2"             =>  array("stats.php?entity=affiliate&breakdown=banner-history&affiliateid=$affiliateid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strDistributionHistory']),
                  "1.3.2.1"         =>  array("stats.php?entity=affiliate&breakdown=daily&affiliateid=$affiliateid&campaignid=$campaignid&bannerid=$bannerid&day=$day" => $GLOBALS['strDailyStats']),
            "3"                     =>  array("report-index.php?affiliateid=$affiliateid" => $GLOBALS['strReports']),
            "2"                     =>  array("affiliate-zones.php?affiliateid=$affiliateid" => $GLOBALS['strAdminstration']),
              "2.1"                 =>  array("affiliate-zones.php?affiliateid=$affiliateid" => $GLOBALS['strZoneOverview']),
                "2.1.3"             =>  array("zone-probability.php?affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strProbability']),
              "2.3"                 =>  array("affiliate-access.php?affiliateid=$affiliateid" => $GLOBALS['strUserAccess']),
                "2.3.1"             =>  array("affiliate-user-start.php?affiliateid=$affiliateid" => $GLOBALS['strLinkNewUser']),
                "2.3.2"             =>  array("affiliate-user.php?affiliateid=$affiliateid&userid=".$_GET['userid'] => $GLOBALS['strUserProperties']),
            "5"                         =>  array("account-index.php" => $GLOBALS['strMyAccount']),
              "5.1"                 =>  array("account-user-name-language-timezone.php" => $GLOBALS['strUserPreferences']),
              "5.2"                 =>  array("account-preferences-index.php" => $GLOBALS['strAccountPreferences']),

        ),
    );

    if (defined('OA_AD_DIRECT_ENABLED') && OA_AD_DIRECT_ENABLED === true) {
       $GLOBALS['OA_Navigation'][OA_ACCOUNT_MANAGER]['4.2.6'] = array("affiliate-advsetup.php?affiliateid=$affiliateid" => $GLOBALS['strAdvertiserSetup']);
    }

    if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
        $myAccount = $GLOBALS['OA_Navigation'][OA_ACCOUNT_ADVERTISER]['5'];
        unset( $GLOBALS['OA_Navigation'][OA_ACCOUNT_ADVERTISER]['5']);

        if (OA_Permission::hasPermission(OA_PERM_BANNER_ACTIVATE) || OA_Permission::hasPermission(OA_PERM_BANNER_DEACTIVATE) || OA_Permission::hasPermission(OA_PERM_BANNER_EDIT)) {
            $GLOBALS['OA_Navigation'][OA_ACCOUNT_ADVERTISER]['2'] = array("advertiser-campaigns.php?clientid=$clientid" => $GLOBALS['strAdminstration']);
            $GLOBALS['OA_Navigation'][OA_ACCOUNT_ADVERTISER]['2.1'] = array("campaign-banners.php?clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strBannerOverview']);
            if (OA_Permission::hasPermission(OA_PERM_BANNER_EDIT)) {
                $GLOBALS['OA_Navigation'][OA_ACCOUNT_ADVERTISER]['2.1.1'] = array("banner-edit.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strBannerProperties']);
            }
            $GLOBALS['OA_Navigation'][OA_ACCOUNT_ADVERTISER]['2.2'] = array("advertiser-campaigns.php?clientid=$clientid" => $GLOBALS['strCampaignOverview']);
        } else if (OA_Permission::hasPermission(OA_PERM_SUPER_ACCOUNT)) {
            $GLOBALS['OA_Navigation'][OA_ACCOUNT_ADVERTISER]['2'] = array("advertiser-access.php?clientid=$clientid" => $GLOBALS['strUserAccess']);
        }
        $GLOBALS['OA_Navigation'][OA_ACCOUNT_ADVERTISER]['5'] = $myAccount;
        
        //add user log link for advertisers if allowed
        if (OA_Permission::hasPermission(OA_PERM_USER_LOG_ACCESS)) {
            $GLOBALS['OA_Navigation'][OA_ACCOUNT_ADVERTISER]["5.4"] =  array("userlog-index.php" => $GLOBALS['strUserLog']);
        }
    } 
    elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
        if (OA_Permission::hasPermission(OA_PERM_ZONE_EDIT) || OA_Permission::hasPermission(OA_PERM_ZONE_ADD)) {
            $GLOBALS['OA_Navigation'][OA_ACCOUNT_TRAFFICKER]['2.1.1'] = array("zone-edit.php?affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strZoneProperties']);
        }
        if (OA_Permission::hasPermission(OA_PERM_ZONE_LINK)) {
            $GLOBALS['OA_Navigation'][OA_ACCOUNT_TRAFFICKER]['2.1.2'] = array("zone-include.php?affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strIncludedBanners']);
        }
        if (OA_Permission::hasPermission(OA_PERM_ZONE_INVOCATION)) {
            $GLOBALS['OA_Navigation'][OA_ACCOUNT_TRAFFICKER]['2.1.4'] = array("zone-invocation.php?affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strInvocationcode']);
            $GLOBALS['OA_Navigation'][OA_ACCOUNT_TRAFFICKER]['2.2']   = array("affiliate-invocation.php?affiliateid=$affiliateid" => $GLOBALS['strInvocationcode']);
        }
        //add user log link for traffickers if allowed
        if (OA_Permission::hasPermission(OA_PERM_USER_LOG_ACCESS)) {
            $GLOBALS['OA_Navigation'][OA_ACCOUNT_TRAFFICKER]["5.4"] =  array("userlog-index.php" => $GLOBALS['strUserLog']);
        }
        
    } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        if (!$aConf['sync']['checkForUpdates'] || !OA::getAvailableSSLExtensions()) {
            unset($GLOBALS['OA_Navigation'][OA_ACCOUNT_MANAGER]['1']);
        }
    }

    /**
    *
    * DO NOT EDIT THIS ARRAY
    * navi2help array - an array containing links to different documentation pages.
    * Please notify the doc team if the array values needs changing
    * The doc team must make sure that any changes to the URLs point to a valid documentation page
    *
    */
    $GLOBALS['OA_NavigationHelp'] = array(
        OA_ACCOUNT_ADMIN => array (
            "2"                         =>  array('statistics'),
              "2.1"                     =>  array('statistics/advertisersAndCampaigns'),
                "2.1.1"                 =>  array('statistics/advertiserHistory'),
                  "2.1.1.1"             =>  array('statistics/advertiserHistory/daily'),
                "2.1.2"                 =>  array('statistics/campaignOverview'),
                  "2.1.2.1"             =>  array('statistics/campaignHistory'),
                    "2.1.2.1.1"         =>  array('statistics/campaignHistory/daily'),
                  "2.1.2.2"             =>  array('statistics/bannerOverview'),
                    "2.1.2.2.1"         =>  array('statistics/bannerHistory'),
                      "2.1.2.2.1.1"     =>  array('statistics/bannerHistory/daily'),
                    "2.1.2.2.2"         =>  array('statistics/publisherDistribution'),
                      "2.1.2.2.2.1"     =>  array('statistics/publisherDistribution/history'),
                        "2.1.2.2.2.1.1" =>  array('statistics/publisherDistribution/history/daily'),
                      "2.1.2.2.2.2"     =>  array(),
                        "2.1.2.2.2.2.1" =>  array(),
                    "2.1.2.2.3"         =>  array('statistics/targetingStatistics'),
                      "2.1.2.2.3.1"     =>  array('statistics/targetingStatistics/daily'),
                  "2.1.2.3"             =>  array('statistics/publisherDistribution'),
                    "2.1.2.3.1"         =>  array('statistics/publisherDistribution/history'),
                      "2.1.2.3.1.1"     =>  array('statistics/publisherDistribution/history/daily'),
                    "2.1.2.3.2"         =>  array(),
                      "2.1.2.3.2.1"     =>  array(),
                  "2.1.2.4"             =>  array('statistics/targetingStatistics'),
                    "2.1.2.4.1"         =>  array('statistics/targetingStatistics/daily'),
                  "2.1.2.5"             =>  array(),   // -- optimize
                  "2.1.2.6"             =>  array(),   // -- keywords
                "2.1.3"                 =>  array('statistics/publisherDistribution'),
                  "2.1.3.1"             =>  array('statistics/publisherDistribution/history'),
                    "2.1.3.1.1"         =>  array('statistics/publisherDistribution/history/daily'),
                  "2.1.3.2"             =>  array(),
                    "2.1.3.2.1"         =>  array(),
              "2.2"                     =>  array('statistics/global'),
                "2.2.1"                 =>  array('statistics/global/daily'),
              "2.4"                     =>  array('statistics/publishersAndZones'),
                "2.4.1"                 =>  array('statistics/publisherHistory'),
                  "2.4.1.1"             =>  array('statistics/publisherHistory/daily'),
                "2.4.2"                 =>  array('statistics/zoneOverview'),
                  "2.4.2.1"             =>  array('statistics/zoneHistory'),
                    "2.4.2.1.1"         =>  array('statistics/zoneHistory/daily'),
                  "2.4.2.2"             =>  array('statistics/campaignDistribution'),
                    "2.4.2.2.1"         =>  array('statistics/campaignDistribution/history'),
                      "2.4.2.2.1.1"     =>  array('statistics/campaignDistribution/history/daily'),
                    "2.4.2.2.2"         =>  array(),
                      "2.4.2.2.2.1"     =>  array(),
                "2.4.3"                 =>  array('statistics/campaignDistribution'),
                  "2.4.3.1"             =>  array('statistics/campaignDistribution/history'),
                    "2.4.3.1.1"         =>  array('statistics/campaignDistribution/history/daily'),
                  "2.4.3.2"             =>  array(),
                    "2.4.3.2.1"         =>  array(),
              "2.5"                     =>  array(),    // GLOBAL BRKDN - MISC
            "3"                         =>  array('reports'),
            "4"                         =>  array('inventory'),
              "4.1"                     =>  array('settings/agencyManagement'),
                "4.1.1"                 =>  array('settings/agencyManagement/addagency'),
                "4.1.2"                 =>  array('settings/agencyManagement/editagency'),
              "4.3"                     =>  array('inventory/directSelection'),
            "5"                         =>  array('settings'),
              "5.1"                     =>  array('settings/preferences'),
              "5.2"                     =>  array('settings/mainSettings'),
              "5.3"                     =>  array('settings/userLog'),
                "5.3.1"                 =>  array('settings/userLog/details'),
              "5.4"                     =>  array('settings/maintenance'),
              "5.5"                     =>  array('settings/productUpdates'),

        ),

        OA_ACCOUNT_MANAGER => array (
            "2"                         =>  array('statistics'),
              "2.1"                     =>  array('statistics/advertisersAndCampaigns/'),
                "2.1.1"                 =>  array('statistics/advertiserHistory'),
                  "2.1.1.1"             =>  array('statistics/advertiserHistory/daily'),
                "2.1.2"                 =>  array('statistics/campaignOverview'),
                  "2.1.2.1"             =>  array('statistics/campaignHistory'),
                    "2.1.2.1.1"         =>  array('statistics/campaignHistory/daily'),
                  "2.1.2.2"             =>  array('statistics/bannerOverview'),
                    "2.1.2.2.1"         =>  array('statistics/bannerHistory'),
                      "2.1.2.2.1.1"     =>  array('statistics/bannerHistory/daily'),
                    "2.1.2.2.2"         =>  array('statistics/publisherDistribution'),
                      "2.1.2.2.2.1"     =>  array('statistics/publisherDistribution/history'),
                        "2.1.2.2.2.1.1" =>  array('statistics/publisherDistribution/history/daily'),
                      "2.1.2.2.2.2"     =>  array(),
                        "2.1.2.2.2.2.1" =>  array(),
                    "2.1.2.2.3"         =>  array('statistics/targetingStatistics'),
                      "2.1.2.2.3.1"     =>  array('statistics/targetingStatistics/daily'),
                  "2.1.2.3"             =>  array('statistics/publisherDistribution'),
                    "2.1.2.3.1"         =>  array('statistics/publisherDistribution/history'),
                      "2.1.2.3.1.1"     =>  array('statistics/publisherDistribution/history/daily'),
                    "2.1.2.3.2"         =>  array(),
                      "2.1.2.3.2.1"     =>  array(),
                  "2.1.2.4"             =>  array('statistics/targetingStatistics'),
                    "2.1.2.4.1"         =>  array('statistics/targetingStatistics/daily'),
                  "2.1.2.5"             =>  array(),   // -- optimize
                  "2.1.2.6"             =>  array(),   // -- keywords
                "2.1.3"                 =>  array('statistics/publisherDistribution'),
                  "2.1.3.1"             =>  array('statistics/publisherDistribution/history'),
                    "2.1.3.1.1"         =>  array('statistics/publisherDistribution/history/daily'),
                  "2.1.3.2"             =>  array(),
                    "2.1.3.2.1"         =>  array(),
              "2.2"                     =>  array('statistics/global'),
                "2.2.1"                 =>  array('statistics/global/daily'),
              "2.4"                     =>  array('statistics/publishersAndZones'),
                "2.4.1"                 =>  array('statistics/publisherHistory'),
                  "2.4.1.1"             =>  array('statistics/publisherHistory/daily'),
                "2.4.2"                 =>  array('statistics/zoneOverview'),
                  "2.4.2.1"             =>  array('statistics/zoneHistory'),
                    "2.4.2.1.1"         =>  array('statistics/zoneHistory/daily'),
                  "2.4.2.2"             =>  array('statistics/campaignDistribution'),
                    "2.4.2.2.1"         =>  array('statistics/campaignDistribution/history'),
                      "2.4.2.2.1.1"     =>  array('statistics/campaignDistribution/history/daily'),
                    "2.4.2.2.2"         =>  array(),
                      "2.4.2.2.2.1"     =>  array(),
                "2.4.3"                 =>  array('statistics/campaignDistribution'),
                  "2.4.3.1"             =>  array('statistics/campaignDistribution/history'),
                    "2.4.3.1.1"         =>  array('statistics/campaignDistribution/history/daily'),
                  "2.4.3.2"             =>  array(),
                    "2.4.3.2.1"         =>  array(),
              "2.5"                     =>  array(),    // GLOBAL BRKDN - MISC
            "3"                         =>  array('reports'),
            "4"                         =>  array('inventory'),
              "4.1"                     =>  array('inventory/advertisersAndCampaigns'),
                "4.1.1"                 =>  array('inventory/advertisersAndCampaigns/addAdvertiser'),
                "4.1.2"                 =>  array('inventory/advertisersAndCampaigns/editAdvertiser'),
                "4.1.3"                 =>  array('inventory/advertisersAndCampaigns/campaigns'),
                  "4.1.3.1"             =>  array('inventory/advertisersAndCampaigns/campaigns/addCampaign'),
                  "4.1.3.2"             =>  array('inventory/advertisersAndCampaigns/campaigns/editCampaign'),
                  "4.1.3.3"             =>  array('inventory/advertisersAndCampaigns/campaigns/linkedZones'),
                  "4.1.3.4"             =>  array('inventory/advertisersAndCampaigns/campaigns/banners'),
                    "4.1.3.4.1"         =>  array('inventory/advertisersAndCampaigns/campaigns/banners/addBanner'),
                    "4.1.3.4.2"         =>  array('inventory/advertisersAndCampaigns/campaigns/banners/editBanner'),
                    "4.1.3.4.3"         =>  array('inventory/advertisersAndCampaigns/campaigns/banners/editBanner/deliveryOptions'),
                    "4.1.3.4.4"         =>  array('inventory/advertisersAndCampaigns/campaigns/banners/editBanner/linkedZones'),
                    "4.1.3.4.5"         =>  array('inventory/advertisersAndCampaigns/campaigns/banners/editBanner/convertFlashLinks'),
                    "4.1.3.4.6"         =>  array('inventory/advertisersAndCampaigns/campaigns/banners/editBanner/advanced'),
                  "4.1.3.5"             =>  array('inventory/advertisersAndCampaigns/campaigns/linkedTrackers'),
                "4.1.4"                 =>  array('inventory/advertisersAndCampaigns/trackers'),
                  "4.1.4.1"             =>  array('inventory/advertisersAndCampaigns/trackers/addTracker'),
                  "4.1.4.2"             =>  array('inventory/advertisersAndCampaigns/trackers/editTracker'),
                  "4.1.4.3"             =>  array('inventory/advertisersAndCampaigns/trackers/editTracker/linkedCampaigns'),
                  "4.1.4.5"             =>  array('inventory/advertisersAndCampaigns/trackers/editTracker/variables'),
                  "4.1.4.6"             =>  array('inventory/advertisersAndCampaigns/trackers/editTracker/appendCode'),
                  "4.1.4.4"             =>  array('inventory/advertisersAndCampaigns/trackers/editTracker/invocationCode'),
              "4.2"                     =>  array('inventory/publishersAndZones'),
                "4.2.1"                 =>  array('inventory/publishersAndZones/addPublisher'),
                "4.2.2"                 =>  array('inventory/publishersAndZones/editPublisher'),
                "4.2.3"                 =>  array('inventory/publishersAndZones/zones'),
                  "4.2.3.1"             =>  array('inventory/publishersAndZones/zones/addZone'),
                  "4.2.3.2"             =>  array('inventory/publishersAndZones/zones/editZone'),
                  "4.2.3.6"             =>  array('inventory/publishersAndZones/zones/editZone/advanced'),
                  "4.2.3.3"             =>  array('inventory/publishersAndZones/zones/editZone/linkedBanners'),
                  "4.2.3.4"             =>  array('inventory/publishersAndZones/zones/editZone/probability'),
                  "4.2.3.5"             =>  array('inventory/publishersAndZones/zones/editZone/invocationCode'),
                "4.2.4"                 =>  array('inventory/publishersAndZones/channels'),
                  "4.2.4.1"             =>  array('inventory/publishersAndZones/channels/addChannel'),
                  "4.2.4.2"             =>  array('inventory/publishersAndZones/channels/editChannel'),
                  "4.2.4.3"             =>  array('inventory/publishersAndZones/channels/editChannel/deliveryOptions'),
                "4.2.5"                 =>  array('inventory/affiliateInvocation'),
              "4.3"                     =>  array('inventory/directSelection'),
            "5"                         =>  array('settings'),
              "5.1"                     =>  array('settings/mainSettings'),
              "5.3"                     =>  array('settings/userLog'),
                "5.3.1"                 =>  array('settings/userLog/details'),
              "5.7"                     =>  array('settings/channelManagement'),
                "5.7.1"                 =>  array('settings/channelManagement/addChannel'),
                "5.7.2"                 =>  array('settings/channelManagement/editChannel'),
                "5.7.3"                 =>  array('settings/channelManagement/editChannel/deliveryOptions'),

// Switched off
//              "5.3"                   =>  array()
        ),

        OA_ACCOUNT_ADVERTISER => array (
            "1"                     =>  array('statistics/advertiserHistory'),
              "1.1"                 =>  array('statistics/advertiserHistory'),
                "1.1.1"             =>  array('statistics/advertiserHistory/daily'),
              "1.2"                 =>  array('statistics/campaignOverview'),
                "1.2.1"             =>  array('statistics/campaignHistory'),
                  "1.2.1.1"         =>  array('statistics/campaignHistory/daily'),
                "1.2.2"             =>  array('statistics/bannerOverview'),
                  "1.2.2.1"         =>  array('statistics/bannerHistory'),
                    "1.2.2.1.1"     =>  array('statistics/bannerHistory/daily'),
                  "1.2.2.4"         =>  array('statistics/publisherDistribution'),
                    "1.2.2.4.1"     =>  array('statistics/publisherDistribution/history'),
                      "1.2.2.4.1.1" =>  array('statistics/publisherDistribution/history/daily'),
                    "1.2.2.4.2"     =>  array(),
                      "1.2.2.4.2.1" =>  array(),
                "1.2.3"             =>  array('statistics/publisherDistribution'),
                  "1.2.3.1"         =>  array('statistics/publisherDistribution/history'),
                    "1.2.3.1.1"     =>  array('statistics/publisherDistribution/history/daily'),
                  "1.2.3.2"         =>  array(),
                    "2.1.2.3.2.1"   =>  array(),
              "1.3"                 =>  array('statistics/publisherDistribution'),
                "1.3.1"             =>  array('statistics/publisherDistribution/history'),
                  "1.3.1.1"         =>  array('statistics/publisherDistribution/history/daily'),
                "1.3.2"             =>  array(),
                  "1.3.2.1"         =>  array(),
            "2"                     =>  array('inventory/advertisersAndCampaigns/campaigns'),
              "2.1"                 =>  array('inventory/advertisersAndCampaigns/campaigns/banners'),
              "2.1.1"               =>  array('inventory/advertisersAndCampaigns/campaigns/banners/editBanner'),
            "3"                     =>  array('reports'),
            "4"                     =>  array('settings/mainSettings'),
              "4.1"                 =>  array('settings/mainSettings'),
            "4"                     =>  array('inventory'),
              "4.1"                 =>  array('inventory/advertisersAndCampaigns'),
        ),

        OA_ACCOUNT_TRAFFICKER => array (
            "1"                     =>  array('statistics/publisherHistory'),
              "1.1"                 =>  array('statistics/publisherHistory'),
                "1.1.1"             =>  array('statistics/publisherHistory/daily'),
              "1.2"                 =>  array('statistics/zoneOverview'),
                "1.2.1"             =>  array('statistics/zoneHistory'),
                  "1.2.1.1"         =>  array('statistics/zoneHistory/daily'),
                "1.2.2"             =>  array('statistics/campaignDistribution'),
                  "1.2.2.1"         =>  array('statistics/campaignDistribution/history'),
                    "1.2.2.1.1"     =>  array('statistics/campaignDistribution/history/daily'),
                  "1.2.2.2"         =>  array(),
                    "1.2.2.2.1"     =>  array(),
              "1.3"                 =>  array('statistics/campaignDistribution'),
                "1.3.1"             =>  array('statistics/campaignDistribution/history'),
                  "1.3.1.1"         =>  array('statistics/campaignDistribution/history/daily'),
                "1.3.2"             =>  array(),
                  "1.3.2.1"         =>  array(),
            "2"                     =>  array('inventory/publishersAndZones/zones'),
              "2.1"                 =>  array('inventory/publishersAndZones/zones'),
                "2.1.1"             =>  array('inventory/publishersAndZones/zones/editZone'),
                "2.1.2"             =>  array('inventory/publishersAndZones/zones/editZone/linkedBanners'),
                "2.1.3"             =>  array('inventory/publishersAndZones/zones/editZone/probability'),
                "2.1.4"             =>  array('inventory/publishersAndZones/zones/editZone/invocationCode'),
              "2.2"                 =>  array('inventory/affiliateInvocation'),
            "3"                     =>  array('reports'),
            "4"                     =>  array('settings/mainSettings'),
              "4.1"                 =>  array('settings/mainSettings'),
        )
    );

}

MMM_buildNavigation();

?>
