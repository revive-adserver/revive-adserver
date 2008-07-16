<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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


// Setup navigation
function _buildNavigation()
{
    $oMenu = new OA_Admin_Menu;
    $oMenu->add(new OA_Admin_MenuSection("1", $GLOBALS['strHome'], "dashboard.php", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->add(new OA_Admin_MenuSection("2", $GLOBALS['strStats'], "stats.php", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2", new OA_Admin_MenuSection("2.1", $GLOBALS['strClientsAndCampaigns'], "stats.php?1=1", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1", new OA_Admin_MenuSection("2.1.1", $GLOBALS['strClientHistory'], "stats.php?entity=advertiser&breakdown=history&clientid={clientid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.1", new OA_Admin_MenuSection("2.1.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&day={day}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1", new OA_Admin_MenuSection("2.1.2", $GLOBALS['strCampaignOverview'], "stats.php?entity=advertiser&breakdown=campaigns&clientid={clientid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2", new OA_Admin_MenuSection("2.1.2.1", $GLOBALS['strCampaignHistory'], "stats.php?entity=campaign&breakdown=history&clientid={clientid}&campaignid={campaignid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2.1", new OA_Admin_MenuSection("2.1.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&day={day}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2", new OA_Admin_MenuSection("2.1.2.2", $GLOBALS['strBannerOverview'], "stats.php?entity=campaign&breakdown=banners&clientid={clientid}&campaignid={campaignid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2.2", new OA_Admin_MenuSection("2.1.2.2.1", $GLOBALS['strBannerHistory'], "stats.php?entity=banner&breakdown=history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2.2.1", new OA_Admin_MenuSection("2.1.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&day={day}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2.2", new OA_Admin_MenuSection("2.1.2.2.2", $GLOBALS['strPublisherDistribution'], "stats.php?entity=banner&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2.2.2", new OA_Admin_MenuSection("2.1.2.2.2.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=banner&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2.2.2.1", new OA_Admin_MenuSection("2.1.2.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&day={day}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2.2.2", new OA_Admin_MenuSection("2.1.2.2.2.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=banner&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2.2.2.2", new OA_Admin_MenuSection("2.1.2.2.2.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2.2", new OA_Admin_MenuSection("2.1.2.2.3", $GLOBALS['strTargetStats'], "stats.php?entity=banner&breakdown=targeting&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2.2.3", new OA_Admin_MenuSection("2.1.2.2.3.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=targeting-daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2", new OA_Admin_MenuSection("2.1.2.3", $GLOBALS['strPublisherDistribution'], "stats.php?entity=campaign&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2.3", new OA_Admin_MenuSection("2.1.2.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=campaign&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2.3.1", new OA_Admin_MenuSection("2.1.2.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&day={day}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2.3", new OA_Admin_MenuSection("2.1.2.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=campaign&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2.3.2", new OA_Admin_MenuSection("2.1.2.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2", new OA_Admin_MenuSection("2.1.2.4", $GLOBALS['strTargetStats'], "stats.php?entity=campaign&breakdown=targeting&clientid={clientid}&campaignid={campaignid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2.4", new OA_Admin_MenuSection("2.1.2.4.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=targeting-daily&clientid={clientid}&campaignid={campaignid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2", new OA_Admin_MenuSection("2.1.2.5", $GLOBALS['strOptimise'], "stats.php?entity=campaign&breakdown=optimise&clientid={clientid}&campaignid={campaignid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.2", new OA_Admin_MenuSection("2.1.2.6", $GLOBALS['strKeywordStatistics'], "stats.php?entity=campaign&breakdown=keywords&clientid={clientid}&campaignid={campaignid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1", new OA_Admin_MenuSection("2.1.3", $GLOBALS['strPublisherDistribution'], "stats.php?entity=advertiser&breakdown=affiliates&clientid={clientid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.3", new OA_Admin_MenuSection("2.1.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=advertiser&breakdown=affiliate-history&clientid={clientid}&affiliateid={affiliateid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.3.1", new OA_Admin_MenuSection("2.1.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&day={day}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.3", new OA_Admin_MenuSection("2.1.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=advertiser&breakdown=zone-history&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.1.3.2", new OA_Admin_MenuSection("2.1.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2", new OA_Admin_MenuSection("2.2", $GLOBALS['strGlobalHistory'], "stats.php?entity=global&breakdown=history", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.2", new OA_Admin_MenuSection("2.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=global&breakdown=daily&day={day}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2", new OA_Admin_MenuSection("2.4", $GLOBALS['strAffiliatesAndZones'], "stats.php?entity=global&breakdown=affiliates", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.4", new OA_Admin_MenuSection("2.4.1", $GLOBALS['strAffiliateHistory'], "stats.php?entity=affiliate&breakdown=history&affiliateid={affiliateid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.4.1", new OA_Admin_MenuSection("2.4.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&day={day}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.4", new OA_Admin_MenuSection("2.4.2", $GLOBALS['strZoneOverview'], "stats.php?entity=affiliate&breakdown=zones&affiliateid={affiliateid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.4.2", new OA_Admin_MenuSection("2.4.2.1", $GLOBALS['strZoneHistory'], "stats.php?entity=zone&breakdown=history&affiliateid={affiliateid}&zoneid={zoneid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.4.2.1", new OA_Admin_MenuSection("2.4.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&day={day}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.4.2", new OA_Admin_MenuSection("2.4.2.2", $GLOBALS['strCampaignDistribution'], "stats.php?entity=zone&breakdown=campaigns&affiliateid={affiliateid}&zoneid={zoneid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.4.2.2", new OA_Admin_MenuSection("2.4.2.2.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=zone&breakdown=campaign-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.4.2.2.1", new OA_Admin_MenuSection("2.4.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&day={day}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.4.2.2", new OA_Admin_MenuSection("2.4.2.2.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=zone&breakdown=banner-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.4.2.2.2", new OA_Admin_MenuSection("2.4.2.2.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}&day={day}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.4", new OA_Admin_MenuSection("2.4.3", $GLOBALS['strCampaignDistribution'], "stats.php?entity=affiliate&breakdown=campaigns&affiliateid={affiliateid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.4.3", new OA_Admin_MenuSection("2.4.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=affiliate&breakdown=campaign-history&affiliateid={affiliateid}&campaignid={campaignid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.4.3.1", new OA_Admin_MenuSection("2.4.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&day={day}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.4.3", new OA_Admin_MenuSection("2.4.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=affiliate&breakdown=banner-history&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2.4.3.2", new OA_Admin_MenuSection("2.4.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}&day={day}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("2", new OA_Admin_MenuSection("2.5", $GLOBALS['strMiscellaneous'], "stats.php?entity=global&breakdown=misc", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->add(new OA_Admin_MenuSection("3", $GLOBALS['strReports'], "report-index.php", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->add(new OA_Admin_MenuSection("4", $GLOBALS['strAdminstration'], "agency-index.php", null, array(OA_ACCOUNT_ADMIN)));
    $oMenu->addTo("4", new OA_Admin_MenuSection("4.1", $GLOBALS['strAgencyManagement'], "agency-index.php", null, array(OA_ACCOUNT_ADMIN)));
    $oMenu->addTo("4.1", new OA_Admin_MenuSection("4.1.1", $GLOBALS['strAddAgency'], "agency-edit.php", null, array(OA_ACCOUNT_ADMIN), 1, true));
    $oMenu->addTo("4.1", new OA_Admin_MenuSection("4.1.2", $GLOBALS['strAgencyProperties'], "agency-edit.php?agencyid={agencyid}", null, array(OA_ACCOUNT_ADMIN)));
    $oMenu->addTo("4.1", new OA_Admin_MenuSection("4.1.3", $GLOBALS['strUserAccess'], "agency-access.php?agencyid={agencyid}", null, array(OA_ACCOUNT_ADMIN)));
    $oMenu->addTo("4.1.3", new OA_Admin_MenuSection("4.1.3.1", $GLOBALS['strLinkNewUser'], "agency-user-start.php?agencyid={agencyid}", null, array(OA_ACCOUNT_ADMIN)));
    $oMenu->addTo("4.1.3", new OA_Admin_MenuSection("4.1.3.2", $GLOBALS['strUserProperties'], "agency-user.php?agencyid={agencyid}&userid=", null, array(OA_ACCOUNT_ADMIN)));
    $oMenu->addTo("4", new OA_Admin_MenuSection("4.3", $GLOBALS['strGenerateBannercode'], "admin-generate.php", null, array(OA_ACCOUNT_ADMIN)));
    $oMenu->addTo("4", new OA_Admin_MenuSection("4.4", $GLOBALS['strAdminAccess'], "admin-access.php", null, array(OA_ACCOUNT_ADMIN)));
    $oMenu->addTo("4.4", new OA_Admin_MenuSection("4.4.1", $GLOBALS['strLinkNewUser'], "admin-user-start.php", null, array(OA_ACCOUNT_ADMIN), 1, false, true));
    $oMenu->addTo("4.4", new OA_Admin_MenuSection("4.4.2", $GLOBALS['strUserProperties'], "admin-user.php?userid=", null, array(OA_ACCOUNT_ADMIN), 1, false, true));
    $oMenu->add(new OA_Admin_MenuSection("5", $GLOBALS['strMyAccount'], "account-index.php", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("5", new OA_Admin_MenuSection("5.1", $GLOBALS['strPreferences'], "account-preferences-index.php", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("5", new OA_Admin_MenuSection("5.2", $GLOBALS['strGlobalSettings'], "account-settings-index.php", null, array(OA_ACCOUNT_ADMIN)));
    $oMenu->addTo("5", new OA_Admin_MenuSection("5.3", $GLOBALS['strUserLog'], "userlog-index.php", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("5.3", new OA_Admin_MenuSection("5.3.1", $GLOBALS['strUserLogDetails'], "userlog-details.php?userlogid={userlogid}", null, array(OA_ACCOUNT_ADMIN)));
    $oMenu->addTo("5", new OA_Admin_MenuSection("5.4", $GLOBALS['strMaintenance'], "maintenance-index.php", null, array(OA_ACCOUNT_ADMIN)));
    $oMenu->addTo("5", new OA_Admin_MenuSection("5.5", $GLOBALS['strProductUpdates'], "updates-product.php", null, array(OA_ACCOUNT_ADMIN)));
    $oMenu->addTo("5", new OA_Admin_MenuSection("5.6", Plugins, "plugin-index.php", null, array(OA_ACCOUNT_ADMIN)));
    $oMenu->addTo("5", new OA_Admin_MenuSection("5.7", $GLOBALS['strChannelManagement'], "channel-index.php", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("5.7", new OA_Admin_MenuSection("5.7.1", $GLOBALS['strAddNewChannel'], "channel-edit.php?agencyid={agencyid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("5.7", new OA_Admin_MenuSection("5.7.2", $GLOBALS['strChannelProperties'], "channel-edit.php?agencyid={agencyid}&channelid={channelid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("5.7", new OA_Admin_MenuSection("5.7.3", $GLOBALS['strModifyBannerAcl'], "channel-acl.php?agencyid={agencyid}&channelid={channelid}", null, array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)));
    $oMenu->add(new OA_Admin_MenuSection("MANAGER_4", $GLOBALS['strAdminstration'], "advertiser-index.php", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4", new OA_Admin_MenuSection("MANAGER_4.1", $GLOBALS['strClientsAndCampaigns'], "advertiser-index.php", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1", new OA_Admin_MenuSection("MANAGER_4.1.1", $GLOBALS['strAddClient'], "advertiser-edit.php", null, array(OA_ACCOUNT_MANAGER), 1, true));
    $oMenu->addTo("MANAGER_4.1", new OA_Admin_MenuSection("MANAGER_4.1.2", $GLOBALS['strClientProperties'], "advertiser-edit.php?clientid={clientid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1", new OA_Admin_MenuSection("MANAGER_4.1.3", $GLOBALS['strCampaignOverview'], "advertiser-campaigns.php?clientid={clientid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.3", new OA_Admin_MenuSection("MANAGER_4.1.3.1", $GLOBALS['strAddCampaign'], "campaign-edit.php?clientid={clientid}", null, array(OA_ACCOUNT_MANAGER), false, true));
    $oMenu->addTo("MANAGER_4.1.3", new OA_Admin_MenuSection("MANAGER_4.1.3.2", $GLOBALS['strCampaignProperties'], "campaign-edit.php?clientid={clientid}&campaignid={campaignid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.3", new OA_Admin_MenuSection("MANAGER_4.1.3.3", $GLOBALS['strLinkedZones'], "campaign-zone.php?clientid={clientid}&campaignid={campaignid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.3", new OA_Admin_MenuSection("MANAGER_4.1.3.4", $GLOBALS['strBannerOverview'], "campaign-banners.php?clientid={clientid}&campaignid={campaignid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.3.4", new OA_Admin_MenuSection("MANAGER_4.1.3.4.1", $GLOBALS['strAddBanner'], "banner-edit.php?clientid={clientid}&campaignid={campaignid}", null, array(OA_ACCOUNT_MANAGER), false, true));
    $oMenu->addTo("MANAGER_4.1.3.4", new OA_Admin_MenuSection("MANAGER_4.1.3.4.2", $GLOBALS['strBannerProperties'], "banner-edit.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.3.4", new OA_Admin_MenuSection("MANAGER_4.1.3.4.3", $GLOBALS['strModifyBannerAcl'], "banner-acl.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.3.4", new OA_Admin_MenuSection("MANAGER_4.1.3.4.4", $GLOBALS['strLinkedZones'], "banner-zone.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.3.4", new OA_Admin_MenuSection("MANAGER_4.1.3.4.5", $GLOBALS['strConvertSWFLinks'], "banner-swf.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.3.4", new OA_Admin_MenuSection("MANAGER_4.1.3.4.6", $GLOBALS['strAdvanced'], "banner-advanced.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.3.4", new OA_Admin_MenuSection("MANAGER_4.1.3.4.7", $GLOBALS['strAdSenseAccounts'], "adsense-accounts.php", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.3.4.7", new OA_Admin_MenuSection("MANAGER_4.1.3.4.7.1", $GLOBALS['strLinkAdSenseAccount'], "adsense-link.php", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.3.4.7", new OA_Admin_MenuSection("MANAGER_4.1.3.4.7.2", $GLOBALS['strCreateAdSenseAccount'], "adsense-create.php", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.3.4.7", new OA_Admin_MenuSection("MANAGER_4.1.3.4.7.3", $GLOBALS['strEditAdSenseAccount'], "adsense-edit.php", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.3", new OA_Admin_MenuSection("MANAGER_4.1.3.5", $GLOBALS['strLinkedTrackers'], "campaign-trackers.php?clientid={clientid}&campaignid={campaignid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1", new OA_Admin_MenuSection("MANAGER_4.1.4", $GLOBALS['strTrackerOverview'], "advertiser-trackers.php?clientid={clientid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.4", new OA_Admin_MenuSection("MANAGER_4.1.4.1", $GLOBALS['strAddTracker'], "tracker-edit.php?clientid={clientid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.4", new OA_Admin_MenuSection("MANAGER_4.1.4.2", $GLOBALS['strTrackerProperties'], "tracker-edit.php?clientid={clientid}&trackerid=", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.4", new OA_Admin_MenuSection("MANAGER_4.1.4.3", $GLOBALS['strLinkedCampaigns'], "tracker-campaigns.php?clientid={clientid}&trackerid=", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.4", new OA_Admin_MenuSection("MANAGER_4.1.4.4", $GLOBALS['strInvocationcode'], "tracker-invocation.php?clientid={clientid}&trackerid=", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.4", new OA_Admin_MenuSection("MANAGER_4.1.4.6", $GLOBALS['strAppendTrackerCode'], "tracker-append.php?clientid={clientid}&trackerid=", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.4", new OA_Admin_MenuSection("MANAGER_4.1.4.5", $GLOBALS['strTrackerVariables'], "tracker-variables.php?clientid={clientid}&trackerid=", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1", new OA_Admin_MenuSection("MANAGER_4.1.5", $GLOBALS['strUserAccess'], "advertiser-access.php?clientid={clientid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.5", new OA_Admin_MenuSection("MANAGER_4.1.5.1", $GLOBALS['strLinkNewUser'], "advertiser-user-start.php?clientid={clientid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.1.5", new OA_Admin_MenuSection("MANAGER_4.1.5.2", $GLOBALS['strUserProperties'], "advertiser-user.php?clientid={clientid}&userid=", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4", new OA_Admin_MenuSection("MANAGER_4.2", $GLOBALS['strAffiliatesAndZones'], "affiliate-index.php", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.2", new OA_Admin_MenuSection("MANAGER_4.2.1", $GLOBALS['strAddNewAffiliate'], "affiliate-edit.php", null, array(OA_ACCOUNT_MANAGER), 1, true));
    $oMenu->addTo("MANAGER_4.2", new OA_Admin_MenuSection("MANAGER_4.2.2", $GLOBALS['strAffiliateProperties'], "affiliate-edit.php?affiliateid={affiliateid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.2", new OA_Admin_MenuSection("MANAGER_4.2.3", $GLOBALS['strZoneOverview'], "affiliate-zones.php?affiliateid={affiliateid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.2.3", new OA_Admin_MenuSection("MANAGER_4.2.3.1", $GLOBALS['strAddNewZone'], "zone-edit.php?affiliateid={affiliateid}", null, array(OA_ACCOUNT_MANAGER), 1, true));
    $oMenu->addTo("MANAGER_4.2.3", new OA_Admin_MenuSection("MANAGER_4.2.3.2", $GLOBALS['strZoneProperties'], "zone-edit.php?affiliateid={affiliateid}&zoneid={zoneid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.2.3", new OA_Admin_MenuSection("MANAGER_4.2.3.3", $GLOBALS['strIncludedBanners'], "zone-include.php?affiliateid={affiliateid}&zoneid={zoneid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.2.3", new OA_Admin_MenuSection("MANAGER_4.2.3.4", $GLOBALS['strProbability'], "zone-probability.php?affiliateid={affiliateid}&zoneid={zoneid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.2.3", new OA_Admin_MenuSection("MANAGER_4.2.3.5", $GLOBALS['strInvocationcode'], "zone-invocation.php?affiliateid={affiliateid}&zoneid={zoneid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.2.3", new OA_Admin_MenuSection("MANAGER_4.2.3.6", $GLOBALS['strAdvanced'], "zone-advanced.php?affiliateid={affiliateid}&zoneid={zoneid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.2", new OA_Admin_MenuSection("MANAGER_4.2.4", $GLOBALS['strChannelOverview'], "affiliate-channels.php?affiliateid={affiliateid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.2.4", new OA_Admin_MenuSection("MANAGER_4.2.4.1", $GLOBALS['strAddNewChannel'], "channel-edit.php?affiliateid={affiliateid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.2.4", new OA_Admin_MenuSection("MANAGER_4.2.4.2", $GLOBALS['strChannelProperties'], "channel-edit.php?affiliateid={affiliateid}&channelid={channelid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.2.4", new OA_Admin_MenuSection("MANAGER_4.2.4.3", $GLOBALS['strModifyBannerAcl'], "channel-acl.php?affiliateid={affiliateid}&channelid={channelid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.2", new OA_Admin_MenuSection("MANAGER_4.2.5", $GLOBALS['strAffiliateInvocation'], "affiliate-invocation.php?affiliateid={affiliateid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.2", new OA_Admin_MenuSection("MANAGER_4.2.7", $GLOBALS['strUserAccess'], "affiliate-access.php?affiliateid={affiliateid}", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.2.7", new OA_Admin_MenuSection("MANAGER_4.2.7.1", $GLOBALS['strLinkNewUser'], "affiliate-user-start.php?affiliateid={affiliateid}", null, array(OA_ACCOUNT_MANAGER), 1, true));
    $oMenu->addTo("MANAGER_4.2.7", new OA_Admin_MenuSection("MANAGER_4.2.7.2", $GLOBALS['strUserProperties'], "affiliate-user.php?affiliateid={affiliateid}&userid=", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4", new OA_Admin_MenuSection("MANAGER_4.3", $GLOBALS['strGenerateBannercode'], "admin-generate.php", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4", new OA_Admin_MenuSection("MANAGER_4.4", $GLOBALS['strUserAccess'], "agency-access.php", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.4", new OA_Admin_MenuSection("MANAGER_4.4.1", $GLOBALS['strLinkNewUser'], "agency-user-start.php", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->addTo("MANAGER_4.4", new OA_Admin_MenuSection("MANAGER_4.4.2", $GLOBALS['strUserProperties'], "agency-user.php?userid=", null, array(OA_ACCOUNT_MANAGER)));
    $oMenu->add(new OA_Admin_MenuSection("ADVERTISER_1", $GLOBALS['strStats'], "stats.php?entity=advertiser&breakdown=history&clientid={clientid}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1", new OA_Admin_MenuSection("ADVERTISER_1.1", $GLOBALS['strClientHistory'], "stats.php?entity=advertiser&breakdown=history&clientid={clientid}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.1", new OA_Admin_MenuSection("ADVERTISER_1.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&day={day}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1", new OA_Admin_MenuSection("ADVERTISER_1.2", $GLOBALS['strCampaignOverview'], "stats.php?entity=advertiser&breakdown=campaigns&clientid={clientid}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.2", new OA_Admin_MenuSection("ADVERTISER_1.2.1", $GLOBALS['strCampaignHistory'], "stats.php?entity=campaign&breakdown=history&clientid={clientid}&campaignid={campaignid}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.2.1", new OA_Admin_MenuSection("ADVERTISER_1.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&day={day}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.2", new OA_Admin_MenuSection("ADVERTISER_1.2.2", $GLOBALS['strBannerOverview'], "stats.php?entity=campaign&breakdown=banners&clientid={clientid}&campaignid={campaignid}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.2.2", new OA_Admin_MenuSection("ADVERTISER_1.2.2.1", $GLOBALS['strBannerHistory'], "stats.php?entity=banner&breakdown=history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.2.2.1", new OA_Admin_MenuSection("ADVERTISER_1.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&day={day}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.2.2", new OA_Admin_MenuSection("ADVERTISER_1.2.2.2", $GLOBALS['strBannerProperties'], "banner-edit.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.2.2", new OA_Admin_MenuSection("ADVERTISER_1.2.2.3", $GLOBALS['strConvertSWFLinks'], "banner-swf.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.2.2", new OA_Admin_MenuSection("ADVERTISER_1.2.2.4", $GLOBALS['strPublisherDistribution'], "stats.php?entity=banner&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.2.2.4", new OA_Admin_MenuSection("ADVERTISER_1.2.2.4.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=banner&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.2.2.4.1", new OA_Admin_MenuSection("ADVERTISER_1.2.2.4.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&day={day}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.2.2.4", new OA_Admin_MenuSection("ADVERTISER_1.2.2.4.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=banner&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.2.2.4.2", new OA_Admin_MenuSection("ADVERTISER_1.2.2.4.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.2", new OA_Admin_MenuSection("ADVERTISER_1.2.3", $GLOBALS['strPublisherDistribution'], "stats.php?entity=campaign&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.2.3", new OA_Admin_MenuSection("ADVERTISER_1.2.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=campaign&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.2.3.1", new OA_Admin_MenuSection("ADVERTISER_1.2.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&day={day}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.2.3", new OA_Admin_MenuSection("ADVERTISER_1.2.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=campaign&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.2.3.2", new OA_Admin_MenuSection("ADVERTISER_1.2.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1", new OA_Admin_MenuSection("ADVERTISER_1.3", $GLOBALS['strPublisherDistribution'], "stats.php?entity=advertiser&breakdown=affiliates&clientid={clientid}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.3", new OA_Admin_MenuSection("ADVERTISER_1.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=advertiser&breakdown=affiliate-history&clientid={clientid}&affiliateid={affiliateid}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.3.1", new OA_Admin_MenuSection("ADVERTISER_1.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&day={day}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.3", new OA_Admin_MenuSection("ADVERTISER_1.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=advertiser&breakdown=zone-history&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("ADVERTISER_1.3.2", new OA_Admin_MenuSection("ADVERTISER_1.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("2", new OA_Admin_MenuSection("2.3", $GLOBALS['strUserAccess'], "advertiser-access.php?clientid={clientid}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("2.3", new OA_Admin_MenuSection("2.3.1", $GLOBALS['strLinkNewUser'], "advertiser-user-start.php?clientid={clientid}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->addTo("2.3", new OA_Admin_MenuSection("2.3.2", $GLOBALS['strUserProperties'], "advertiser-user.php?clientid={clientid}&userid=", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->add(new OA_Admin_MenuSection("ADVERTISER_3", $GLOBALS['strReports'], "report-index.php?clientid={clientid}", null, array(OA_ACCOUNT_ADVERTISER)));
    $oMenu->add(new OA_Admin_MenuSection("TRAFFICKER_1", $GLOBALS['strStats'], "stats.php?entity=affiliate&breakdown=history&affiliateid={affiliateid}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("TRAFFICKER_1", new OA_Admin_MenuSection("TRAFFICKER_1.1", $GLOBALS['strAffiliateHistory'], "stats.php?entity=affiliate&breakdown=history&affiliateid={affiliateid}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("TRAFFICKER_1.1", new OA_Admin_MenuSection("TRAFFICKER_1.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&day={day}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("TRAFFICKER_1", new OA_Admin_MenuSection("TRAFFICKER_1.2", $GLOBALS['strZoneOverview'], "stats.php?entity=affiliate&breakdown=zones&affiliateid={affiliateid}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("TRAFFICKER_1.2", new OA_Admin_MenuSection("TRAFFICKER_1.2.1", $GLOBALS['strZoneHistory'], "stats.php?entity=zone&breakdown=history&affiliateid={affiliateid}&zoneid={zoneid}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("TRAFFICKER_1.2.1", new OA_Admin_MenuSection("TRAFFICKER_1.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&day={day}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("TRAFFICKER_1.2", new OA_Admin_MenuSection("TRAFFICKER_1.2.2", $GLOBALS['strCampaignDistribution'], "stats.php?entity=zone&breakdown=campaigns&affiliateid={affiliateid}&zoneid={zoneid}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("TRAFFICKER_1.2.2", new OA_Admin_MenuSection("TRAFFICKER_1.2.2.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=zone&breakdown=campaign-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("TRAFFICKER_1.2.2.1", new OA_Admin_MenuSection("TRAFFICKER_1.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&day={day}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("TRAFFICKER_1.2.2", new OA_Admin_MenuSection("TRAFFICKER_1.2.2.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=zone&breakdown=banner-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("TRAFFICKER_1.2.2.2", new OA_Admin_MenuSection("TRAFFICKER_1.2.2.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}&day={day}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("TRAFFICKER_1", new OA_Admin_MenuSection("TRAFFICKER_1.3", $GLOBALS['strCampaignDistribution'], "stats.php?entity=affiliate&breakdown=campaigns&affiliateid={affiliateid}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("TRAFFICKER_1.3", new OA_Admin_MenuSection("TRAFFICKER_1.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=affiliate&breakdown=campaign-history&affiliateid={affiliateid}&campaignid={campaignid}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("TRAFFICKER_1.3.1", new OA_Admin_MenuSection("TRAFFICKER_1.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&day={day}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("TRAFFICKER_1.3", new OA_Admin_MenuSection("TRAFFICKER_1.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=affiliate&breakdown=banner-history&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("TRAFFICKER_1.3.2", new OA_Admin_MenuSection("TRAFFICKER_1.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}&day={day}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->add(new OA_Admin_MenuSection("TRAFFICKER_3", $GLOBALS['strReports'], "report-index.php?affiliateid={affiliateid}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->add(new OA_Admin_MenuSection("TRAFFICKER_2", $GLOBALS['strAdminstration'], "affiliate-zones.php?affiliateid={affiliateid}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("TRAFFICKER_2", new OA_Admin_MenuSection("TRAFFICKER_2.1", $GLOBALS['strZoneOverview'], "affiliate-zones.php?affiliateid={affiliateid}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("TRAFFICKER_2.1", new OA_Admin_MenuSection("TRAFFICKER_2.1.3", $GLOBALS['strProbability'], "zone-probability.php?affiliateid={affiliateid}&zoneid={zoneid}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("TRAFFICKER_2", new OA_Admin_MenuSection("TRAFFICKER_2.3", $GLOBALS['strUserAccess'], "affiliate-access.php?affiliateid={affiliateid}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("TRAFFICKER_2.3", new OA_Admin_MenuSection("TRAFFICKER_2.3.1", $GLOBALS['strLinkNewUser'], "affiliate-user-start.php?affiliateid={affiliateid}", null, array(OA_ACCOUNT_TRAFFICKER)));
    $oMenu->addTo("TRAFFICKER_2.3", new OA_Admin_MenuSection("TRAFFICKER_2.3.2", $GLOBALS['strUserProperties'], "affiliate-user.php?affiliateid={affiliateid}&userid=", null, array(OA_ACCOUNT_TRAFFICKER)));

    $GLOBALS['_MAX']['MENU_OBJECT'] = &$oMenu;
    return $oMenu;
}

?>
