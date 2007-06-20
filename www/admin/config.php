<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
require_once MAX_PATH . '/lib/max/Admin/Preferences.php';
require_once MAX_PATH . '/lib/max/language/Default.php';
require_once MAX_PATH . '/lib/max/other/lib-io.inc.php';
require_once MAX_PATH . '/lib/max/other/lib-db.inc.php';
require_once MAX_PATH . '/lib/max/other/lib-userlog.inc.php';
require_once MAX_PATH . '/www/admin/lib-gui.inc.php';
require_once MAX_PATH . '/www/admin/lib-permissions.inc.php';
require_once MAX_PATH . '/lib/max/Permission.php';

$link = phpAds_dbConnect();
if (!$link) {
    // Check if UI is enabled
    if (!$conf['max']['uiEnabled']) {
        Language_Default::load();
        phpAds_PageHeader(phpAds_Login);
        phpAds_ShowBreak();
        echo "<br /><img src='images/info.gif' align='absmiddle'>&nbsp;";
        echo $strNoAdminInteface;
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
                </ul>");
}

// Load the user preferences from the database
$pref = MAX_Admin_Preferences::loadPrefs();

// First thing to do is clear the $session variable to
// prevent users from pretending to be logged in.
unset($session);

// Authorize the user
phpAds_Start();

if (!phpAds_isUser(phpAds_Admin)) {
    // Reload user preferences from the database because we are using
    // agency/advertiser/publisher settings
    $pref = MAX_Admin_Preferences::loadPrefs(phpAds_getAgencyID());
}

// Rewrite column preferences
$pref = MAX_Admin_Preferences::expandColumnPrefs();

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

if (!isset($affiliateid))   $affiliateid = '';
if (!isset($agencyid))      $agencyid = phpAds_getAgencyID();
if (!isset($bannerid))      $bannerid = '';
if (!isset($campaignid))    $campaignid = '';
if (!isset($channelid))     $channelid = '';
if (!isset($clientid))      $clientid = '';
if (!isset($day))           $day = '';
if (!isset($trackerid))     $trackerid = '';
if (!isset($userlogid))     $userlogid = '';
if (!isset($zoneid))        $zoneid = '';

// Setup navigation
function MMM_buildNavigation()
{
    global $affiliateid, $agencyid, $bannerid, $campaignid, $channelid, $clientid, $day, $trackerid, $userlogid, $zoneid;
    global $pref;

    $GLOBALS['phpAds_nav'] = array (
        "admin" => array (
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
                  "4.1.3.5"             =>  array("campaign-trackers.php?clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strLinkedTrackers']),
                "4.1.4"                 =>  array("advertiser-trackers.php?clientid=$clientid" => $GLOBALS['strTrackerOverview']),
                  "4.1.4.1"             =>  array("tracker-edit.php?clientid=$clientid" => $GLOBALS['strAddTracker']),
                  "4.1.4.2"             =>  array("tracker-edit.php?clientid=$clientid&trackerid=$trackerid" => $GLOBALS['strTrackerProperties']),
                  "4.1.4.3"             =>  array("tracker-campaigns.php?clientid=$clientid&trackerid=$trackerid" => $GLOBALS['strLinkedCampaigns']),
                  "4.1.4.4"             =>  array("tracker-invocation.php?clientid=$clientid&trackerid=$trackerid" => $GLOBALS['strInvocationcode']),
                  "4.1.4.6"             =>  array("tracker-append.php?clientid=$clientid&trackerid=$trackerid" => $GLOBALS['strAppendTrackerCode']),
                  "4.1.4.5"             =>  array("tracker-variables.php?clientid=$clientid&trackerid=$trackerid" => $GLOBALS['strTrackerVariables']),
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
              "4.3"                     =>  array("admin-generate.php" => $GLOBALS['strGenerateBannercode']),
            "5"                         =>  array("settings-index.php" => $GLOBALS['strSettings']),
              "5.1"                     =>  array("settings-index.php" => $GLOBALS['strMainSettings']),
              "5.2"                     =>  array("userlog-index.php" => $GLOBALS['strUserLog']),
                "5.2.1"                 =>  array("userlog-details.php?userlogid=$userlogid" => $GLOBALS['strUserLogDetails']),
              "5.3"                     =>  array("maintenance-index.php" => $GLOBALS['strMaintenance']),
              "5.4"                     =>  array("maintenance-updates.php" => $GLOBALS['strProductUpdates']),
              "5.5"                     =>  array("agency-index.php" => $GLOBALS['strAgencyManagement']),
                "5.5.1"                 =>  array("agency-edit.php" => $GLOBALS['strAddAgency']),
                "5.5.2"                 =>  array("agency-edit.php?agencyid=$agencyid" => $GLOBALS['strAgencyProperties']),
                "5.5.3"                 =>  array("channel-index.php?agencyid=$agencyid" => $GLOBALS['strChannelOverview']),
                  "5.5.3.1"             =>  array("channel-edit.php?agencyid=$agencyid" => $GLOBALS['strAddNewChannel']),
                  "5.5.3.2"             =>  array("channel-edit.php?agencyid=$agencyid&channelid=$channelid" => $GLOBALS['strChannelProperties']),
                  "5.5.3.3"             =>  array("channel-acl.php?agencyid=$agencyid&channelid=$channelid" => $GLOBALS['strChannelLimitations']),
              "5.6"                     =>  array("channel-index.php" => $GLOBALS['strChannelManagement']),
                "5.6.1"                 =>  array("channel-edit.php?agencyid=$agencyid" => $GLOBALS['strAddNewChannel']),
                "5.6.2"                 =>  array("channel-edit.php?agencyid=$agencyid&channelid=$channelid" => $GLOBALS['strChannelProperties']),
                "5.6.3"                 =>  array("channel-acl.php?agencyid=$agencyid&channelid=$channelid" => $GLOBALS['strChannelLimitations'])
        ),

        "agency"    => array (
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
                  "2.1.2.3"             =>  array("stats.php?entity=campaign&breakdown=affiliates&clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strPublisherDistribution']),
                    "2.1.2.3.1"         =>  array("stats.php?entity=campaign&breakdown=affiliate-history&clientid=$clientid&campaignid=$campaignid&affiliateid=$affiliateid" => $GLOBALS['strDistributionHistory']),
                      "2.1.2.3.1.1"     =>  array("stats.php?entity=campaign&breakdown=daily&clientid=$clientid&campaignid=$campaignid&affiliateid=$affiliateid&day=$day" => $GLOBALS['strDailyStats']),
                    "2.1.2.3.2"         =>  array("stats.php?entity=campaign&breakdown=zone-history&clientid=$clientid&campaignid=$campaignid&affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strDistributionHistory']),
                      "2.1.2.3.2.1"     =>  array("stats.php?entity=advertiser&breakdown=daily&clientid=$clientid&campaignid=$campaignid&affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $GLOBALS['strDailyStats']),
                  //"2.1.2.4"               =>  array("stats-placement-target.php?clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strTargetStats']),
                    //"2.1.2.4.1"           =>  array("stats-placement-target-daily.php?clientid=$clientid&campaignid=$campaignid&day=$day" => $GLOBALS['strDailyStats']),
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
                  "4.1.3.5"             =>  array("campaign-trackers.php?clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strLinkedTrackers']),
                "4.1.4"                 =>  array("advertiser-trackers.php?clientid=$clientid" => $GLOBALS['strTrackerOverview']),
                  "4.1.4.1"             =>  array("tracker-edit.php?clientid=$clientid" => $GLOBALS['strAddTracker']),
                  "4.1.4.2"             =>  array("tracker-edit.php?clientid=$clientid&trackerid=$trackerid" => $GLOBALS['strTrackerProperties']),
                  "4.1.4.3"             =>  array("tracker-campaigns.php?clientid=$clientid&trackerid=$trackerid" => $GLOBALS['strLinkedCampaigns']),
                  "4.1.4.4"             =>  array("tracker-invocation.php?clientid=$clientid&trackerid=$trackerid" => $GLOBALS['strInvocationcode']),
                  "4.1.4.6"             =>  array("tracker-append.php?clientid=$clientid&trackerid=$trackerid" => $GLOBALS['strAppendTrackerCode']),
                  "4.1.4.5"             =>  array("tracker-variables.php?clientid=$clientid&trackerid=$trackerid" => $GLOBALS['strTrackerVariables']),
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
              "4.3"                     =>  array("admin-generate.php" => $GLOBALS['strGenerateBannercode']),
            "5"                         =>  array("settings-index.php" => $GLOBALS['strSettings']),
              "5.1"                     =>  array("settings-index.php" => $GLOBALS['strMainSettings']),
              "5.2"                     =>  array("channel-index.php" => $GLOBALS['strChannelManagement']),
              "5.2.1"                   =>  array("channel-edit.php" => $GLOBALS['strAddNewChannel']),
              "5.2.2"                   =>  array("channel-edit.php?channelid=$channelid" => $GLOBALS['strChannelProperties']),
              "5.2.3"                   =>  array("channel-acl.php?channelid=$channelid" => $GLOBALS['strChannelLimitations']),
// Switched off
//              "5.3"                     =>  array("maintenance-index.php" => $GLOBALS['strMaintenance'])
        ),

        "client" => array (
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
            "3"                         =>  array("report-index.php?clientid=$clientid" => $GLOBALS['strReports']),
            "4"                         =>  array("settings-index.php?clientid=$clientid" => $GLOBALS['strSettings']),
              "4.1"                     =>  array("settings-index.php?clientid=$clientid" => $GLOBALS['strMainSettings'])
        ),

        "affiliate" => array (
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
            "3"                     =>  array("report-index.php?affiliateid=$affiliateid" => $GLOBALS['strReports'])

        )
    );

    if (phpAds_isUser(phpAds_Client)) {
        if (phpAds_isAllowed(phpAds_ActivateBanner) || phpAds_isAllowed(phpAds_ModifyBanner)) {
            $GLOBALS['phpAds_nav']['client']['2'] = array("advertiser-campaigns.php?clientid=$clientid" => $GLOBALS['strAdminstration']);
            $GLOBALS['phpAds_nav']['client']['2.1'] = array("campaign-banners.php?clientid=$clientid&campaignid=$campaignid" => $GLOBALS['strBannerOverview']);
            if (phpAds_isAllowed(phpAds_ModifyBanner)) {
                $GLOBALS['phpAds_nav']['client']['2.1.1'] = array("banner-edit.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $GLOBALS['strBannerProperties']);
            }
        }
        if (phpAds_isAllowed(phpAds_ModifyInfo)) {
            $GLOBALS['phpAds_nav']["client"]["4"] =  array("advertiser-edit.php?clientid=$clientid" => $GLOBALS['strPreferences']);
        }
        if (phpAds_isAllowed(phpAds_ViewTargetingStats)) {

        }
    } elseif (phpAds_isUser(phpAds_Affiliate)) {
        if (phpAds_isAllowed(MAX_AffiliateIsReallyAffiliate)) {
            $reports = $GLOBALS['phpAds_nav']['affiliate']['3'];
            unset ($GLOBALS['phpAds_nav']['affiliate']['3']);
            $GLOBALS['phpAds_nav']['affiliate']['1'] = array("stats.php?entity=affiliate&breakdown=campaigns&affiliateid=$affiliateid" => $GLOBALS['strStats']);
            $GLOBALS['phpAds_nav']['affiliate']['2'] = array("affiliate-invocation.php?affiliateid=$affiliateid" => $GLOBALS['strInvocationcode']);
            $GLOBALS['phpAds_nav']['affiliate']['4'] = array("affiliate-edit.php?affiliateid=$affiliateid" => $GLOBALS['strAffiliateProperties']);
            $GLOBALS['phpAds_nav']['affiliate']['3'] = $reports;
        } else {
            $GLOBALS['phpAds_nav']['affiliate']['2'] = array("affiliate-zones.php?affiliateid=$affiliateid" => $GLOBALS['strAdminstration']);
            $GLOBALS['phpAds_nav']['affiliate']['2.1'] = array("affiliate-zones.php?affiliateid=$affiliateid" => $GLOBALS['strZoneOverview']);
            $GLOBALS['phpAds_nav']['affiliate']['2.1.3'] = array("zone-probability.php?affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strProbability']);

            if (phpAds_isAllowed(phpAds_EditZone) || phpAds_isAllowed(phpAds_AddZone)) {
                $GLOBALS['phpAds_nav']['affiliate']['2.1.1'] = array("zone-edit.php?affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strZoneProperties']);
            }
            if (phpAds_isAllowed(phpAds_LinkBanners)) {
                $GLOBALS['phpAds_nav']['affiliate']['2.1.2'] = array("zone-include.php?affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strIncludedBanners']);
            }
            if (phpAds_isAllowed(MAX_AffiliateGenerateCode)) {
                $GLOBALS['phpAds_nav']['affiliate']['2.1.4'] = array("zone-invocation.php?affiliateid=$affiliateid&zoneid=$zoneid" => $GLOBALS['strInvocationcode']);
                $GLOBALS['phpAds_nav']['affiliate']['2.2']   = array("affiliate-invocation.php?affiliateid=$affiliateid" => $GLOBALS['strInvocationcode']);
            }

            // Add settings to the end
            $GLOBALS['phpAds_nav']['affiliate']['4']   = array("settings-index.php?affiliateid=$affiliateid" => $GLOBALS['strSettings']);
            $GLOBALS['phpAds_nav']['affiliate']['4.1'] = array("settings-index.php?affiliateid=$affiliateid" => $GLOBALS['strMainSettings']);

            if (phpAds_isAllowed(phpAds_ModifyInfo)) {
                $GLOBALS['phpAds_nav']['affiliate']['4.2'] = array("affiliate-edit.php?affiliateid=$affiliateid" => $GLOBALS['strAffiliateProperties']);
            }
        }
    }

    define( 'OPENADS_HELP_PAGES_ROTATE_CONSTRAINT_ANCHOR',        1 );

    $GLOBALS['aHelpPages'] = array('elements' => array());

    $GLOBALS['aHelpPages']['elements']['inventory'] = array(
        'link'     => 'managing-your-inventory.html',
        'id'       => 127,
        'itemId'   => 189,
        'name'     => 'Inventory overview',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['inventory']['elements']['managing-your-inventory'] = array(
        'link'     => 'managing-your-inventory.html',
        'id'       => 127,
        'itemId'   => 189,
        'name'     => 'Managing your inventory',
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['inventory']['elements']['managing-your-inventory']['elements']['banners'] = array(
        'link'     => 'managing-your-inventory/banners.html',
        'itemId'   => 192,
        'id'       => 29,
        'name'     => 'Banners',
    );

    $GLOBALS['aHelpPages']['elements']['inventory']['elements']['managing-your-inventory']['elements']['advertisers'] = array(
        'link'     => 'managing-your-inventory/advertisers.html',
        'itemId'   => 190,
        'id'       => 128,
        'name'     => 'Advertisers',
    );

    $GLOBALS['aHelpPages']['elements']['inventory']['elements']['managing-your-inventory']['elements']['campaigns'] = array(
        'link'     => 'managing-your-inventory/campaigns.html',
        'itemId'   => 191,
        'id'       => 130,
        'name'     => 'Advertisers',
    );

    $GLOBALS['aHelpPages']['elements']['inventory']['elements']['advanced-inventory-management'] = array(
        'link'     => 'advanced-inventory-management/displaying-banners-using-direct-selection.html',
        'id'       => 141,
        'itemId'   => 205,
        'name'     => 'Advanced inventory management',
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['inventory']['elements']['advanced-inventory-management']['elements']['direct-selection'] = array(
        'link'     => 'advanced-inventory-management/displaying-banners-using-direct-selection.html',
        'id'       => 141,
        'itemId'   => 205,
        'name'     => 'Displaying banners using direct selection',
    );

    $GLOBALS['aHelpPages']['elements']['inventory']['elements']['displaying-banners'] = array(
        'link'     => 'displaying-banners-on-your-website/displaying-banners-on-your-website.html',
        'id'       => 137,
        'itemId'   => 201,
        'name'     => 'Displaying banners on your website',
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['inventory']['elements']['displaying-banners']['elements']['publishers'] = array(
        'link'     => 'displaying-banners-on-your-website/publishers.html',
        'id'       => 139,
        'itemId'   => 203,
        'name'     => 'Publishers',
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['inventory']['elements']['displaying-banners']['elements']['zones'] = array(
        'link'     => 'displaying-banners-on-your-website/zones.html',
        'id'       => 137,
        'itemId'   => 201,
        'name'     => 'Publishers',
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['inventory']['elements']['displaying-banners']['elements']['invocation-tags'] = array(
        'link'     => 'unknown.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Invocation tags',
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['inventory']['elements']['targeting'] = array(
        'link'     => 'targeting-your-advertising/overview-of-delivery-limitations.html',
        'id'       => 132,
        'itemId'   => 195,
        'name'     => 'Targeting your advertising',
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['inventory']['elements']['targeting']['elements']['delivery-limitations'] = array(
        'link'     => 'targeting-your-advertising/overview-of-delivery-limitations.html',
        'id'       => 132,
        'itemId'   => 195,
        'name'     => 'Overview of delivery limitations',
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['inventory']['elements']['targeting']['elements']['website-properties'] = array(
        'link'     => 'unknown.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Targeting by website properties',
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['inventory']['elements']['targeting']['elements']['browser-properties'] = array(
        'link'     => 'unknown.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Targeting by client browser properties',
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['inventory']['elements']['targeting']['elements']['geography'] = array(
        'link'     => 'unknown.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Targeting by geography',
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['inventory']['elements']['targeting']['elements']['time-of-day'] = array(
        'link'     => 'unknown/in/the/time/of/writing.html',
        'id'       => 10000,
        'itemId'   => 20000,
        'name'     => 'Targeting by time of day',
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['inventory']['elements']['targeting']['elements']['delivery-capping'] = array(
        'link'     => 'unknown/in/the/time/of/writing.html',
        'id'       => 10000,
        'itemId'   => 20000,
        'name'     => 'Delivery capping',
        'elements' => array(),
    );


    $GLOBALS['aHelpPages']['elements']['statistics'] = array(
        'link'     => 'unknown.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Statistics',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['statistics']['elements']['advertisers-and-campaigns'] = array(
        'link'     => 'unknown_advertisers_and_campaigns.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Advertisers & Campaigns',
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['statistics']['elements']['publishers-and-zones'] = array(
        'link'     => 'unknown_publisher_and_zones.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Publishers & Zones',
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['statistics']['elements']['global-history'] = array(
        'link'     => 'unknown_global_history.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Global History',
        'elements' => array(),
    );


    $GLOBALS['aHelpPages']['elements']['reports'] = array(
        'link'     => 'unknown.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Reports',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['reports']['elements']['advertiser-reports'] = array(
        'link'     => 'unknown.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Advertiser Reports',
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['reports']['elements']['agency-reports'] = array(
        'link'     => 'unknown.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Agency Reports',
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['reports']['elements']['publisher-reports'] = array(
        'link'     => 'unknown.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Publisher Reports',
        'elements' => array(),
    );


    $GLOBALS['aHelpPages']['elements']['settings'] = array(
        'link'     => 'unknown.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Settings',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['settings']['elements']['main-settings'] = array(
        'link'     => 'unknown.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Main Settings',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['settings']['elements']['main-settings']['elements']['maintenance'] = array(
        'link'     => 'unknown_maintenance.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Maintenance',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['settings']['elements']['main-settings']['elements']['maintenance']['elements']['finance'] = array(
        'link'     => 'unknown.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Settings',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['settings']['elements']['main-settings']['elements']['admin'] = array(
        'link'     => 'unknown_admin.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Administrator Settings',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['settings']['elements']['main-settings']['elements']['banner'] = array(
        'link'     => 'unknown_banner.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Banner Settings',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['settings']['elements']['main-settings']['elements']['database'] = array(
        'link'     => 'unknown_db.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Banner Settings',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['settings']['elements']['main-settings']['elements']['debug'] = array(
        'link'     => 'unknown_debug.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Debug Logging',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['settings']['elements']['main-settings']['elements']['delivery'] = array(
        'link'     => 'unknown_delivery.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Delivery Settings',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['settings']['elements']['main-settings']['elements']['general'] = array(
        'link'     => 'unknown_general.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'General Settings',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['settings']['elements']['main-settings']['elements']['geotargeting'] = array(
        'link'     => 'unknown_geo.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Geotargeting Settings',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['settings']['elements']['main-settings']['elements']['interface-defaults'] = array(
        'link'     => 'unknown_interface_defaults.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Interface Defaults',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['settings']['elements']['main-settings']['elements']['invocation'] = array(
        'link'     => 'unknown_invocation.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Invocation Settings',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['settings']['elements']['main-settings']['elements']['statistics-and-maintenance'] = array(
        'link'     => 'unknown_stats_maintenance.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Statistics &amp; Maintenance Settings',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['settings']['elements']['main-settings']['elements']['user-interface'] = array(
        'link'     => 'unknown_user_interface.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'User Interface Settings',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['advanced-configuration'] = array(
        'link'     => 'unknown_adv_conf.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Advanced configuration',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['advanced-configuration']['elements']['using-agencies'] = array(
        'link'     => 'unknown_using_agencies.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Devolved user administration using Agencies',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['advanced-configuration']['elements']['using-channels'] = array(
        'link'     => 'unknown_using_channels.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Grouping delivery limitations using Channels',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['advanced-configuration']['elements']['customizing-interface'] = array(
        'link'     => 'unknown.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Customising the admin interface',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['advanced-configuration']['elements']['affiliate-network'] = array(
        'link'     => 'unknown.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Running an affiliate network',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['advanced-configuration']['elements']['conversion-tracking'] = array(
        'link'     => 'unknown.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => 'Conversion tracking',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['aHelpPages']['elements']['advanced-configuration']['elements']['improve-performance'] = array(
        'link'     => 'unknown.html',
        'id'       => 100000,
        'itemId'   => 200000,
        'name'     => '10 ways to improve performance',
        'anchors'  => array(),
        'elements' => array(),
    );

    $GLOBALS['navi2help'] = array(
        "admin" => array (
            "2"                         =>  array('statistics'),
              "2.1"                     =>  array('statistics.advertisers-and-campaigns'),
                "2.1.1"                 =>  array('statistics.advertisers-and-campaigns'),
                  "2.1.1.1"             =>  array('statistics.advertisers-and-campaigns'),
                "2.1.2"                 =>  array('statistics.advertisers-and-campaigns'),
                  "2.1.2.1"             =>  array(),
                    "2.1.2.1.1"         =>  array(),
                  "2.1.2.2"             =>  array(),
                    "2.1.2.2.1"         =>  array(),
                      "2.1.2.2.1.1"     =>  array(),
                    "2.1.2.2.2"         =>  array('statistics.publisher-and-zones'),
                      "2.1.2.2.2.1"     =>  array(),
                        "2.1.2.2.2.1.1" =>  array(),
                      "2.1.2.2.2.2"     =>  array(),
                        "2.1.2.2.2.2.1" =>  array(),
                    "2.1.2.2.3"         =>  array(),
                      "2.1.2.2.3.1"     =>  array(),
                  "2.1.2.3"             =>  array(),
                    "2.1.2.3.1"         =>  array(),
                      "2.1.2.3.1.1"     =>  array(),
                    "2.1.2.3.2"         =>  array(),
                      "2.1.2.3.2.1"     =>  array(),
                  "2.1.2.4"             =>  array(),
                    "2.1.2.4.1"         =>  array(),
                  "2.1.2.5"             =>  array(),
                  "2.1.2.6"             =>  array(),
                "2.1.3"                 =>  array(),
                  "2.1.3.1"             =>  array(),
                    "2.1.3.1.1"         =>  array(),
                  "2.1.3.2"             =>  array(),
                    "2.1.3.2.1"         =>  array(),
              "2.2"                     =>  array('statistics.global-history'),
                "2.2.1"                 =>  array(),
              "2.4"                     =>  array('statistics.publishers-and-zones'),
                "2.4.1"                 =>  array(),
                  "2.4.1.1"             =>  array(),
                "2.4.2"                 =>  array(),
                  "2.4.2.1"             =>  array(),
                    "2.4.2.1.1"         =>  array(),
                  "2.4.2.2"             =>  array(),
                    "2.4.2.2.1"         =>  array(),
                      "2.4.2.2.1.1"     =>  array(),
                    "2.4.2.2.2"         =>  array(),
                      "2.4.2.2.2.1"     =>  array(),
                "2.4.3"                 =>  array(),
                  "2.4.3.1"             =>  array(),
                    "2.4.3.1.1"         =>  array(),
                  "2.4.3.2"             =>  array(),
                    "2.4.3.2.1"         =>  array(),
              "2.5"                     =>  array(),
            "3"                         =>  array('reports'),
            "4"                         =>  array(),
              "4.1"                     =>  array(),
                "4.1.1"                 =>  array('inventory.managing-your-inventory.advertisers'),
                "4.1.2"                 =>  array('inventory.managing-your-inventory.advertisers'),
                "4.1.3"                 =>  array(),
                  "4.1.3.1"             =>  array('inventory.managing-your-inventory.campaigns'),
                  "4.1.3.2"             =>  array('inventory.managing-your-inventory.campaigns'),
                  "4.1.3.3"             =>  array(),
                  "4.1.3.4"             =>  array('inventory.managing-your-inventory.banners'),
                    "4.1.3.4.1"         =>  array('inventory.managing-your-inventory.banners'),
                    "4.1.3.4.2"         =>  array('inventory.managing-your-inventory.banners'),
                    "4.1.3.4.3"         =>  array('inventory.targeting.delivery-limitations'),
                    "4.1.3.4.4"         =>  array(),
                    "4.1.3.4.5"         =>  array(),
                    "4.1.3.4.6"         =>  array(),
                  "4.1.3.5"             =>  array(),
                "4.1.4"                 =>  array(),
                  "4.1.4.1"             =>  array(),
                  "4.1.4.2"             =>  array(),
                  "4.1.4.3"             =>  array(),
                  "4.1.4.4"             =>  array(),
                  "4.1.4.6"             =>  array(),
                  "4.1.4.5"             =>  array(),
              "4.2"                     =>  array(),
                "4.2.1"                 =>  array('inventory.displaying-banners.publishers'),
                "4.2.2"                 =>  array('inventory.displaying-banners.publishers'),
                "4.2.3"                 =>  array('inventory.displaying-banners.zones'),
                  "4.2.3.1"             =>  array(),
                  "4.2.3.2"             =>  array(),
                  "4.2.3.3"             =>  array(),
                  "4.2.3.4"             =>  array(),
                  "4.2.3.5"             =>  array(),
                  "4.2.3.6"             =>  array(),
                "4.2.4"                 =>  array(),
                  "4.2.4.1"             =>  array(),
                  "4.2.4.2"             =>  array(),
                  "4.2.4.3"             =>  array(),
                "4.2.5"                 =>  array(),
              "4.3"                     =>  array('inventory.advanced-inventory-management.direct-selection'),
            "5"                         =>  array('settigns'),
              "5.1"                     =>  array('settings',
                                              'use_file' => array(
                                                'settings-db.php'             => array('settings.main-settings.database'),
                                                'settings-invocation.php'     => array('settings.main-settings.invocation'),
                                                'settings-geotargeting.php'   => array('settings.main-settings.geotargeting'),
                                                'settings-stats.php'          => array('settings.main-settings.statistics-and-maintenance'),
                                                'settings-banner.php'         => array('settings.main-settings.banner'),
                                                'settings-admin.php'          => array('settings.main-settings.admin'),
                                                'settings-interface.php'      => array('settings.main-settings.user-interface'),
                                                'settings-defaults.php'       => array('settings.main-settings.interface-defaults'),
                                                'settings-delivery.php'       => array('settings.main-settings.delivery'),
                                                'settings-general.php'        => array('settings.main-settings.general'),
                                              )
                                        ),
              "5.2"                     =>  array(),
                "5.2.1"                 =>  array(),
              "5.3"                     =>  array(),
              "5.4"                     =>  array(),
              "5.5"                     =>  array(),
                "5.5.1"                 =>  array(),
                "5.5.2"                 =>  array(),
                "5.5.3"                 =>  array(),
                  "5.5.3.1"             =>  array(),
                  "5.5.3.2"             =>  array(),
                  "5.5.3.3"             =>  array(),
              "5.6"                     =>  array(),
                "5.6.1"                 =>  array(),
                "5.6.2"                 =>  array(),
                "5.6.3"                 =>  array()
        ),

        "agency"    => array (
            "2"                         =>  array(),
              "2.1"                     =>  array(),
                "2.1.1"                 =>  array(),
                  "2.1.1.1"             =>  array(),
                "2.1.2"                 =>  array(),
                  "2.1.2.1"             =>  array(),
                    "2.1.2.1.1"         =>  array(),
                  "2.1.2.2"             =>  array(),
                    "2.1.2.2.1"         =>  array(),
                      "2.1.2.2.1.1"     =>  array(),
                    "2.1.2.2.2"         =>  array(),
                      "2.1.2.2.2.1"     =>  array(),
                        "2.1.2.2.2.1.1" =>  array(),
                      "2.1.2.2.2.2"     =>  array(),
                        "2.1.2.2.2.2.1" =>  array(),
                  "2.1.2.3"             =>  array(),
                    "2.1.2.3.1"         =>  array(),
                      "2.1.2.3.1.1"     =>  array(),
                    "2.1.2.3.2"         =>  array(),
                      "2.1.2.3.2.1"     =>  array(),
                  //"2.1.2.4"               =>  array(),
                    //"2.1.2.4.1"           =>  array(),
                  "2.1.2.5"             =>  array(),
                  "2.1.2.6"             =>  array(),
                "2.1.3"                 =>  array(),
                  "2.1.3.1"             =>  array(),
                    "2.1.3.1.1"         =>  array(),
                  "2.1.3.2"             =>  array(),
                    "2.1.3.2.1"         =>  array(),
              "2.2"                     =>  array(),
                "2.2.1"                 =>  array(),
              "2.4"                     =>  array(),
                "2.4.1"                 =>  array(),
                  "2.4.1.1"             =>  array(),
                "2.4.2"                 =>  array(),
                  "2.4.2.1"             =>  array(),
                    "2.4.2.1.1"         =>  array(),
                  "2.4.2.2"             =>  array(),
                    "2.4.2.2.1"         =>  array(),
                      "2.4.2.2.1.1"     =>  array(),
                    "2.4.2.2.2"         =>  array(),
                      "2.4.2.2.2.1"     =>  array(),
                "2.4.3"                 =>  array(),
                  "2.4.3.1"             =>  array(),
                    "2.4.3.1.1"         =>  array(),
                  "2.4.3.2"             =>  array(),
                    "2.4.3.2.1"         =>  array(),
              "2.5"                     =>  array(),
            "3"                         =>  array(),
            "4"                         =>  array(),
              "4.1"                     =>  array(),
                "4.1.1"                 =>  array('inventory.managing-your-inventory.advertisers'),
                "4.1.2"                 =>  array('inventory.managing-your-inventory.advertisers'),
                "4.1.3"                 =>  array(),
                  "4.1.3.1"             =>  array(),
                  "4.1.3.2"             =>  array(),
                  "4.1.3.3"             =>  array(),
                  "4.1.3.4"             =>  array('inventory.managing-your-inventory.banners'),
                    "4.1.3.4.1"         =>  array('inventory.managing-your-inventory.banners'),
                    "4.1.3.4.2"         =>  array('inventory.managing-your-inventory.banners'),
                    "4.1.3.4.3"         =>  array(),
                    "4.1.3.4.4"         =>  array(),
                    "4.1.3.4.5"         =>  array(),
                    "4.1.3.4.6"         =>  array(),
                  "4.1.3.5"             =>  array(),
                "4.1.4"                 =>  array(),
                  "4.1.4.1"             =>  array(),
                  "4.1.4.2"             =>  array(),
                  "4.1.4.3"             =>  array(),
                  "4.1.4.4"             =>  array(),
                  "4.1.4.6"             =>  array(),
                  "4.1.4.5"             =>  array(),
              "4.2"                     =>  array(),
                "4.2.1"                 =>  array('inventory.displaying-banners.publishers'),
                "4.2.2"                 =>  array('inventory.displaying-banners.publishers'),
                "4.2.3"                 =>  array('inventory.displaying-banners.publishers'),
                  "4.2.3.1"             =>  array(),
                  "4.2.3.2"             =>  array(),
                  "4.2.3.3"             =>  array(),
                  "4.2.3.4"             =>  array(),
                  "4.2.3.5"             =>  array(),
                  "4.2.3.6"             =>  array(),
                "4.2.4"                 =>  array(),
                  "4.2.4.1"             =>  array(),
                  "4.2.4.2"             =>  array(),
                  "4.2.4.3"             =>  array(),
                "4.2.5"                 =>  array(),
              "4.3"                     =>  array(),
            "5"                         =>  array(),
              "5.1"                     =>  array(),
              "5.2"                     =>  array(),
              "5.2.1"                   =>  array(),
              "5.2.2"                   =>  array(),
              "5.2.3"                   =>  array(),
// Switched off
//              "5.3"                     =>  array()
        ),

        "client" => array (
            "1"                         =>  array(),
              "1.1"                     =>  array(),
                "1.1.1"                 =>  array(),
              "1.2"                     =>  array(),
                "1.2.1"                 =>  array(),
                  "1.2.1.1"             =>  array(),
                "1.2.2"                 =>  array(),
                  "1.2.2.1"             =>  array(),
                    "1.2.2.1.1"         =>  array(),
                  "1.2.2.2"             =>  array('inventory.managing-your-inventory.banners'),
                  "1.2.2.3"             =>  array(),
                  "1.2.2.4"             =>  array(),
                    "1.2.2.4.1"         =>  array(),
                      "1.2.2.4.1.1"     =>  array(),
                    "1.2.2.4.2"         =>  array(),
                      "1.2.2.4.2.1"     =>  array(),
                "1.2.3"                 =>  array(),
                  "1.2.3.1"             =>  array(),
                    "1.2.3.1.1"         =>  array(),
                  "1.2.3.2"             =>  array(),
                    "1.2.3.2.1"         =>  array(),
              "1.3"                     =>  array(),
                  "1.3.1"               =>  array(),
                    "1.3.1.1"           =>  array(),
                  "1.3.2"               =>  array(),
                    "1.3.2.1"           =>  array(),
            /*
            '2'                         =>  array(),
                '2.1'                   =>  array(),
                  '2.1.1'               =>  array(),
                    '2.1.1.1'           =>  array(),
                    '2.1.1.2'           =>  array(),
                    '2.1.1.3'           =>  array(),
            */
            "3"                         =>  array(),
            "4"                         =>  array(),
              "4.1"                     =>  array(),
        ),

        "affiliate" => array (
            "1"                     =>  array(),
              "1.1"                 =>  array(),
                "1.1.1"             =>  array(),
              "1.2"                 =>  array(),
                "1.2.1"             =>  array(),
                  "1.2.1.1"         =>  array(),
                "1.2.2"             =>  array(),
                  "1.2.2.1"         =>  array(),
                    "1.2.2.1.1"     =>  array(),
                  "1.2.2.2"         =>  array('inventory.managing-your-inventory.banners'),
                    "1.2.2.2.1"     =>  array(),
              "1.3"                 =>  array(),
                "1.3.1"             =>  array(),
                  "1.3.1.1"         =>  array(),
                "1.3.2"             =>  array(),
                  "1.3.2.1"         =>  array(),
            "3"                     =>  array(),

        )
    );

}
MMM_buildNavigation();

?>
