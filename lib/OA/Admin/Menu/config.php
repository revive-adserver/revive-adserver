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

require_once(MAX_PATH . '/lib/OA/Permission.php');

// Setup navigation
function _buildNavigation($accountType)
{
    $oMenu = new OA_Admin_Menu;

    $aConf = $GLOBALS['_MAX']['CONF'];

    switch ($accountType) {
        case OA_ACCOUNT_ADMIN:
            $oMenu->add(new OA_Admin_Menu_Section("dashboard", $GLOBALS['strHome'], "dashboard.php", false, ""));

            // Note: The stats screens haven't been updated to use the new menuing names...
            $oMenu->add(new OA_Admin_Menu_Section("2", $GLOBALS['strStats'], "stats.php", false, "statistics"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("2.1", $GLOBALS['strClientsAndCampaigns'], "stats.php?1=1", false, "statistics/advertisersAndCampaigns"));
                $oMenu->addTo("2.1", new OA_Admin_Menu_Section("2.1.1", $GLOBALS['strClientHistory'], "stats.php?entity=advertiser&breakdown=history&clientid={clientid}", false, "statistics/advertiserHistory"));
                $oMenu->addTo("2.1.1", new OA_Admin_Menu_Section("2.1.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&day={day}", false, "statistics/advertiserHistory/daily"));
                $oMenu->addTo("2.1", new OA_Admin_Menu_Section("2.1.2", $GLOBALS['strCampaigns'], "stats.php?entity=advertiser&breakdown=campaigns&clientid={clientid}", false, "statistics/campaignOverview"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.1", $GLOBALS['strCampaignHistory'], "stats.php?entity=campaign&breakdown=history&clientid={clientid}&campaignid={campaignid}", false, "statistics/campaignHistory"));
                $oMenu->addTo("2.1.2.1", new OA_Admin_Menu_Section("2.1.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&day={day}", false, "statistics/campaignHistory/daily"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.2", $GLOBALS['strBanners'], "stats.php?entity=campaign&breakdown=banners&clientid={clientid}&campaignid={campaignid}", false, "statistics/bannerOverview"));
                $oMenu->addTo("2.1.2.2", new OA_Admin_Menu_Section("2.1.2.2.1", $GLOBALS['strBannerHistory'], "stats.php?entity=banner&breakdown=history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "statistics/bannerHistory"));
                $oMenu->addTo("2.1.2.2.1", new OA_Admin_Menu_Section("2.1.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&day={day}", false, "statistics/bannerHistory/daily"));
                $oMenu->addTo("2.1.2.2", new OA_Admin_Menu_Section("2.1.2.2.2", $GLOBALS['strPublisherDistribution'], "stats.php?entity=banner&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "statistics/publisherDistribution"));
                $oMenu->addTo("2.1.2.2.2", new OA_Admin_Menu_Section("2.1.2.2.2.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=banner&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}", false, "statistics/publisherDistribution/history"));
                $oMenu->addTo("2.1.2.2.2.1", new OA_Admin_Menu_Section("2.1.2.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&day={day}", false, "statistics/publisherDistribution/history/daily"));
                $oMenu->addTo("2.1.2.2.2", new OA_Admin_Menu_Section("2.1.2.2.2.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=banner&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}"));
                $oMenu->addTo("2.1.2.2.2.2", new OA_Admin_Menu_Section("2.1.2.2.2.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("2.1.2.2", new OA_Admin_Menu_Section("2.1.2.2.3", $GLOBALS['strTargetStats'], "stats.php?entity=banner&breakdown=targeting&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "statistics/targetingStatistics"));
                $oMenu->addTo("2.1.2.2.3", new OA_Admin_Menu_Section("2.1.2.2.3.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=targeting-daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "statistics/targetingStatistics/daily"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.3", $GLOBALS['strPublisherDistribution'], "stats.php?entity=campaign&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}", false, "statistics/publisherDistribution"));
                $oMenu->addTo("2.1.2.3", new OA_Admin_Menu_Section("2.1.2.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=campaign&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}", false, "statistics/publisherDistribution/history"));
                $oMenu->addTo("2.1.2.3.1", new OA_Admin_Menu_Section("2.1.2.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&day={day}", false, "statistics/publisherDistribution/history/daily"));
                $oMenu->addTo("2.1.2.3", new OA_Admin_Menu_Section("2.1.2.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=campaign&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}"));
                $oMenu->addTo("2.1.2.3.2", new OA_Admin_Menu_Section("2.1.2.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.4", $GLOBALS['strTargetStats'], "stats.php?entity=campaign&breakdown=targeting&clientid={clientid}&campaignid={campaignid}", false, "statistics/targetingStatistics"));
                $oMenu->addTo("2.1.2.4", new OA_Admin_Menu_Section("2.1.2.4.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=targeting-daily&clientid={clientid}&campaignid={campaignid}", false, "statistics/targetingStatistics/daily"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.5", $GLOBALS['strOptimise'], "stats.php?entity=campaign&breakdown=optimise&clientid={clientid}&campaignid={campaignid}"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.6", $GLOBALS['strKeywordStatistics'], "stats.php?entity=campaign&breakdown=keywords&clientid={clientid}&campaignid={campaignid}"));
                $oMenu->addTo("2.1", new OA_Admin_Menu_Section("2.1.3", $GLOBALS['strPublisherDistribution'], "stats.php?entity=advertiser&breakdown=affiliates&clientid={clientid}", false, "statistics/publisherDistribution"));
                $oMenu->addTo("2.1.3", new OA_Admin_Menu_Section("2.1.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=advertiser&breakdown=affiliate-history&clientid={clientid}&affiliateid={affiliateid}", false, "statistics/publisherDistribution/history"));
                $oMenu->addTo("2.1.3.1", new OA_Admin_Menu_Section("2.1.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&day={day}", false, "statistics/publisherDistribution/history/daily"));
                $oMenu->addTo("2.1.3", new OA_Admin_Menu_Section("2.1.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=advertiser&breakdown=zone-history&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}"));
                $oMenu->addTo("2.1.3.2", new OA_Admin_Menu_Section("2.1.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("2.4", $GLOBALS['strAffiliatesAndZones'], "stats.php?entity=global&breakdown=affiliates", false, "statistics/publishersAndZones"));
                $oMenu->addTo("2.4", new OA_Admin_Menu_Section("2.4.1", $GLOBALS['strAffiliateHistory'], "stats.php?entity=affiliate&breakdown=history&affiliateid={affiliateid}", false, "statistics/publisherHistory"));
                $oMenu->addTo("2.4.1", new OA_Admin_Menu_Section("2.4.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&day={day}", false, "statistics/publisherHistory/daily"));
                $oMenu->addTo("2.4", new OA_Admin_Menu_Section("2.4.2", $GLOBALS['strZones'], "stats.php?entity=affiliate&breakdown=zones&affiliateid={affiliateid}", false, "statistics/zoneOverview"));
                $oMenu->addTo("2.4.2", new OA_Admin_Menu_Section("2.4.2.1", $GLOBALS['strZoneHistory'], "stats.php?entity=zone&breakdown=history&affiliateid={affiliateid}&zoneid={zoneid}", false, "statistics/zoneHistory"));
                $oMenu->addTo("2.4.2.1", new OA_Admin_Menu_Section("2.4.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&day={day}", false, "statistics/zoneHistory/daily"));
                $oMenu->addTo("2.4.2", new OA_Admin_Menu_Section("2.4.2.2", $GLOBALS['strCampaignDistribution'], "stats.php?entity=zone&breakdown=campaigns&affiliateid={affiliateid}&zoneid={zoneid}", false, "statistics/campaignDistribution"));
                $oMenu->addTo("2.4.2.2", new OA_Admin_Menu_Section("2.4.2.2.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=zone&breakdown=campaign-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}", false, "statistics/campaignDistribution/history"));
                $oMenu->addTo("2.4.2.2.1", new OA_Admin_Menu_Section("2.4.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&day={day}", false, "statistics/campaignDistribution/history/daily"));
                $oMenu->addTo("2.4.2.2", new OA_Admin_Menu_Section("2.4.2.2.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=zone&breakdown=banner-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}"));
                $oMenu->addTo("2.4.2.2.2", new OA_Admin_Menu_Section("2.4.2.2.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}&day={day}"));
                $oMenu->addTo("2.4", new OA_Admin_Menu_Section("2.4.3", $GLOBALS['strCampaignDistribution'], "stats.php?entity=affiliate&breakdown=campaigns&affiliateid={affiliateid}", false, "statistics/campaignDistribution"));
                $oMenu->addTo("2.4.3", new OA_Admin_Menu_Section("2.4.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=affiliate&breakdown=campaign-history&affiliateid={affiliateid}&campaignid={campaignid}", false, "statistics/campaignDistribution/history"));
                $oMenu->addTo("2.4.3.1", new OA_Admin_Menu_Section("2.4.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&day={day}", false, "statistics/campaignDistribution/history/daily"));
                $oMenu->addTo("2.4.3", new OA_Admin_Menu_Section("2.4.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=affiliate&breakdown=banner-history&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}"));
                $oMenu->addTo("2.4.3.2", new OA_Admin_Menu_Section("2.4.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}&day={day}"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("2.2", $GLOBALS['strGlobalHistory'], "stats.php?entity=global&breakdown=history", false, "statistics/global"));
                $oMenu->addTo("2.2", new OA_Admin_Menu_Section("2.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=global&breakdown=daily&day={day}", false, "statistics/global/daily"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("report-index", $GLOBALS['strAdvancedReports'], "report-index.php", false, "statistics"));

            $oMenu->add(new OA_Admin_Menu_Section("inventory", $GLOBALS['strAdminstration'], "agency-index.php", false, "inventory"));
                $oMenu->addTo("inventory", new OA_Admin_Menu_Section("agency-index", $GLOBALS['strAgencyManagement'], "agency-index.php", false, "settings/agencyManagement"));
                    $oMenu->addTo("agency-index", new OA_Admin_Menu_Section("agency-edit_new", $GLOBALS['strAddAgency'], "agency-index.php", true, false, "settings/agencyManagement/addagency"));
                    $oMenu->addTo("agency-index", new OA_Admin_Menu_Section("agency-edit", $GLOBALS['strAgencyProperties'], "agency-edit.php?agencyid={agencyid}", false, "settings/agencyManagement/editagency"));
                    $oMenu->addTo("agency-index", new OA_Admin_Menu_Section("agency-access", $GLOBALS['strUserAccess'], "agency-access.php?agencyid={agencyid}", false, "inventory/directSelection"));
                $oMenu->addTo("inventory", new OA_Admin_Menu_Section("admin-generate", $GLOBALS['strGenerateBannercode'], "admin-generate.php"));
                $oMenu->addTo("inventory", new OA_Admin_Menu_Section("admin-access", $GLOBALS['strAdminAccess'], "admin-access.php"));

            $oMenu->add(new OA_Admin_Menu_Section("account-index", $GLOBALS['strMyAccount'], "account-index.php", false, "settings/preferences"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-user-index", $GLOBALS['strUserPreferences'], "account-user-index.php", false, ""));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-preferences-index", $GLOBALS['strPreferences'], "account-preferences-index.php", false, "settings/preferences"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("userlog-index", $GLOBALS['strUserLog'], "userlog-index.php", false, "settings/userLog"));
                    $oMenu->addTo("userlog-index", new OA_Admin_Menu_Section("userlog-details", $GLOBALS['strUserLogDetails'], "userlog-audit-detailed.php", false, "settings/userLog/details"));

            $oMenu->add(new OA_Admin_Menu_Section("configuration", $GLOBALS['strConfiguration'], "account-settings-index.php", false, "settings"));
                $oMenu->addTo("configuration", new OA_Admin_Menu_Section("account-settings-index", $GLOBALS['strGlobalSettings'], "account-settings-index.php", false, ""));
                $oMenu->addTo("configuration", new OA_Admin_Menu_Section("maintenance-index", $GLOBALS['strMaintenance'], "maintenance-index.php", false, "settings/maintenance"));
                $oMenu->addTo("configuration", new OA_Admin_Menu_Section("updates-index", $GLOBALS['strProductUpdates'], "updates-product.php", false, "settings/productUpdates"));

        break;
        case OA_ACCOUNT_MANAGER:
            $oMenu->add(new OA_Admin_Menu_Section("dashboard", $GLOBALS['strHome'], "dashboard.php", false, "dashboard"));

            // Note: The stats screens haven't been updated to use the new menuing names...
            $oMenu->add(new OA_Admin_Menu_Section("2", $GLOBALS['strStats'], "stats.php", false, "statistics"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("2.1", $GLOBALS['strClientsAndCampaigns'], "stats.php?1=1", false, "statistics/advertisersAndCampaigns"));
                $oMenu->addTo("2.1", new OA_Admin_Menu_Section("2.1.1", $GLOBALS['strClientHistory'], "stats.php?entity=advertiser&breakdown=history&clientid={clientid}", false, "statistics/advertiserHistory"));
                $oMenu->addTo("2.1.1", new OA_Admin_Menu_Section("2.1.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&day={day}", false, "statistics/advertiserHistory/daily"));
                $oMenu->addTo("2.1", new OA_Admin_Menu_Section("2.1.2", $GLOBALS['strCampaigns'], "stats.php?entity=advertiser&breakdown=campaigns&clientid={clientid}", false, "statistics/campaignOverview"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.1", $GLOBALS['strCampaignHistory'], "stats.php?entity=campaign&breakdown=history&clientid={clientid}&campaignid={campaignid}", false, "statistics/campaignHistory"));
                $oMenu->addTo("2.1.2.1", new OA_Admin_Menu_Section("2.1.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&day={day}", false, "statistics/campaignHistory/daily"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.2", $GLOBALS['strBanners'], "stats.php?entity=campaign&breakdown=banners&clientid={clientid}&campaignid={campaignid}", false, "statistics/bannerOverview"));
                $oMenu->addTo("2.1.2.2", new OA_Admin_Menu_Section("2.1.2.2.1", $GLOBALS['strBannerHistory'], "stats.php?entity=banner&breakdown=history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "statistics/bannerHistory"));
                $oMenu->addTo("2.1.2.2.1", new OA_Admin_Menu_Section("2.1.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&day={day}", false, "statistics/bannerHistory/daily"));
                $oMenu->addTo("2.1.2.2", new OA_Admin_Menu_Section("2.1.2.2.2", $GLOBALS['strPublisherDistribution'], "stats.php?entity=banner&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "statistics/publisherDistribution"));
                $oMenu->addTo("2.1.2.2.2", new OA_Admin_Menu_Section("2.1.2.2.2.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=banner&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}", false, "statistics/publisherDistribution/history"));
                $oMenu->addTo("2.1.2.2.2.1", new OA_Admin_Menu_Section("2.1.2.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&day={day}", false, "statistics/publisherDistribution/history/daily"));
                $oMenu->addTo("2.1.2.2.2", new OA_Admin_Menu_Section("2.1.2.2.2.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=banner&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}"));
                $oMenu->addTo("2.1.2.2.2.2", new OA_Admin_Menu_Section("2.1.2.2.2.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("2.1.2.2", new OA_Admin_Menu_Section("2.1.2.2.3", $GLOBALS['strTargetStats'], "stats.php?entity=banner&breakdown=targeting&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "statistics/targetingStatistics"));
                $oMenu->addTo("2.1.2.2.3", new OA_Admin_Menu_Section("2.1.2.2.3.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=targeting-daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "statistics/targetingStatistics/daily"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.3", $GLOBALS['strPublisherDistribution'], "stats.php?entity=campaign&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}", false, "statistics/publisherDistribution"));
                $oMenu->addTo("2.1.2.3", new OA_Admin_Menu_Section("2.1.2.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=campaign&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}", false, "statistics/publisherDistribution/history"));
                $oMenu->addTo("2.1.2.3.1", new OA_Admin_Menu_Section("2.1.2.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&day={day}", false, "statistics/publisherDistribution/history/daily"));
                $oMenu->addTo("2.1.2.3", new OA_Admin_Menu_Section("2.1.2.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=campaign&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}"));
                $oMenu->addTo("2.1.2.3.2", new OA_Admin_Menu_Section("2.1.2.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.4", $GLOBALS['strTargetStats'], "stats.php?entity=campaign&breakdown=targeting&clientid={clientid}&campaignid={campaignid}", false, "statistics/targetingStatistics"));
                $oMenu->addTo("2.1.2.4", new OA_Admin_Menu_Section("2.1.2.4.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=targeting-daily&clientid={clientid}&campaignid={campaignid}", false, "statistics/targetingStatistics/daily"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.5", $GLOBALS['strOptimise'], "stats.php?entity=campaign&breakdown=optimise&clientid={clientid}&campaignid={campaignid}"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.6", $GLOBALS['strKeywordStatistics'], "stats.php?entity=campaign&breakdown=keywords&clientid={clientid}&campaignid={campaignid}"));
                $oMenu->addTo("2.1", new OA_Admin_Menu_Section("2.1.3", $GLOBALS['strPublisherDistribution'], "stats.php?entity=advertiser&breakdown=affiliates&clientid={clientid}", false, "statistics/publisherDistribution"));
                $oMenu->addTo("2.1.3", new OA_Admin_Menu_Section("2.1.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=advertiser&breakdown=affiliate-history&clientid={clientid}&affiliateid={affiliateid}", false, "statistics/publisherDistribution/history"));
                $oMenu->addTo("2.1.3.1", new OA_Admin_Menu_Section("2.1.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&day={day}", false, "statistics/publisherDistribution/history/daily"));
                $oMenu->addTo("2.1.3", new OA_Admin_Menu_Section("2.1.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=advertiser&breakdown=zone-history&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}"));
                $oMenu->addTo("2.1.3.2", new OA_Admin_Menu_Section("2.1.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("2.2", $GLOBALS['strGlobalHistory'], "stats.php?entity=global&breakdown=history", false, "statistics/global"));
                $oMenu->addTo("2.2", new OA_Admin_Menu_Section("2.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=global&breakdown=daily&day={day}", false, "statistics/global/daily"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("2.4", $GLOBALS['strAffiliatesAndZones'], "stats.php?entity=global&breakdown=affiliates", false, "statistics/publishersAndZones"));
                $oMenu->addTo("2.4", new OA_Admin_Menu_Section("2.4.1", $GLOBALS['strAffiliateHistory'], "stats.php?entity=affiliate&breakdown=history&affiliateid={affiliateid}", false, "statistics/publisherHistory"));
                $oMenu->addTo("2.4.1", new OA_Admin_Menu_Section("2.4.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&day={day}", false, "statistics/publisherHistory/daily"));
                $oMenu->addTo("2.4", new OA_Admin_Menu_Section("2.4.2", $GLOBALS['strZones'], "stats.php?entity=affiliate&breakdown=zones&affiliateid={affiliateid}", false, "statistics/zoneOverview"));
                $oMenu->addTo("2.4.2", new OA_Admin_Menu_Section("2.4.2.1", $GLOBALS['strZoneHistory'], "stats.php?entity=zone&breakdown=history&affiliateid={affiliateid}&zoneid={zoneid}", false, "statistics/zoneHistory"));
                $oMenu->addTo("2.4.2.1", new OA_Admin_Menu_Section("2.4.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&day={day}", false, "statistics/zoneHistory/daily"));
                $oMenu->addTo("2.4.2", new OA_Admin_Menu_Section("2.4.2.2", $GLOBALS['strCampaignDistribution'], "stats.php?entity=zone&breakdown=campaigns&affiliateid={affiliateid}&zoneid={zoneid}", false, "statistics/campaignDistribution"));
                $oMenu->addTo("2.4.2.2", new OA_Admin_Menu_Section("2.4.2.2.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=zone&breakdown=campaign-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}", false, "statistics/campaignDistribution/history"));
                $oMenu->addTo("2.4.2.2.1", new OA_Admin_Menu_Section("2.4.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&day={day}", false, "statistics/campaignDistribution/history/daily"));
                $oMenu->addTo("2.4.2.2", new OA_Admin_Menu_Section("2.4.2.2.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=zone&breakdown=banner-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}"));
                $oMenu->addTo("2.4.2.2.2", new OA_Admin_Menu_Section("2.4.2.2.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}&day={day}"));
                $oMenu->addTo("2.4", new OA_Admin_Menu_Section("2.4.3", $GLOBALS['strCampaignDistribution'], "stats.php?entity=affiliate&breakdown=campaigns&affiliateid={affiliateid}", false, "statistics/campaignDistribution"));
                $oMenu->addTo("2.4.3", new OA_Admin_Menu_Section("2.4.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=affiliate&breakdown=campaign-history&affiliateid={affiliateid}&campaignid={campaignid}", false, "statistics/campaignDistribution/history"));
                $oMenu->addTo("2.4.3.1", new OA_Admin_Menu_Section("2.4.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&day={day}", false, "statistics/campaignDistribution/history/daily"));
                $oMenu->addTo("2.4.3", new OA_Admin_Menu_Section("2.4.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=affiliate&breakdown=banner-history&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}"));
                $oMenu->addTo("2.4.3.2", new OA_Admin_Menu_Section("2.4.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}&day={day}"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("report-index", $GLOBALS['strAdvancedReports'], "report-index.php", false, "statistics"));

            $oMenu->add(new OA_Admin_Menu_Section("inventory", $GLOBALS['strAdminstration'], "advertiser-index.php", false, ""));

            $oMenu->addTo("inventory", new OA_Admin_Menu_Section("advertiser-index", $GLOBALS['strClientsAndCampaigns'], "advertiser-index.php", false, "inventory"));
                $oMenu->addTo("advertiser-index", new OA_Admin_Menu_Section("advertiser-edit_new", $GLOBALS['strAddClient'], "advertiser-edit.php", true, "inventory/advertiserAndCampaings/addAdvertiser"));
                $oMenu->addTo("advertiser-index", new OA_Admin_Menu_Section("advertiser-edit", $GLOBALS['strClientProperties'], "advertiser-edit.php?clientid={clientid}", false, "inventory/advertiserAndCampaings/editAdvertiser"));
                $oMenu->addTo("advertiser-index", new OA_Admin_Menu_Section("advertiser-campaigns", $GLOBALS['strCampaigns'], "advertiser-campaigns.php?clientid={clientid}", false, "inventory/advertiserAndCampaings/campaigns"));
                    $oMenu->addTo("advertiser-campaigns", new OA_Admin_Menu_Section("campaign-edit_new", $GLOBALS['strAddCampaign'], "campaign-edit.php?clientid={clientid}", true, "inventory/advertiserAndCampaings/campaigns/addCampaign"));
                    $oMenu->addTo("advertiser-campaigns", new OA_Admin_Menu_Section("campaign-edit", $GLOBALS['strCampaignProperties'], "campaign-edit.php?clientid={clientid}&campaignid={campaignid}", false, "inventory/advertisersAndCampaigns/campaigns/editCampaign"));
                    $oMenu->addTo("advertiser-campaigns", new OA_Admin_Menu_Section("campaign-zone", $GLOBALS['strLinkedZones'], "campaign-zone.php?clientid={clientid}&campaignid={campaignid}", false, "inventory/advertisersAndCampaigns/campaigns/linkedZones"));
                    $oMenu->addTo("advertiser-campaigns", new OA_Admin_Menu_Section("campaign-banners", $GLOBALS['strBanners'], "campaign-banners.php?clientid={clientid}&campaignid={campaignid}", false, "inventory/advertisersAndCampaigns/campaigns/banners"));
                        $oMenu->addTo("campaign-banners", new OA_Admin_Menu_Section("banner-edit_new", $GLOBALS['strAddBanner'], "banner-edit.php?clientid={clientid}&campaignid={campaignid}", true, "inventory/advertisersAndCampaigns/campaigns/banners/addBanner"));
                        $oMenu->addTo("campaign-banners", new OA_Admin_Menu_Section("banner-edit", $GLOBALS['strBannerProperties'], "banner-edit.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "inventory/advertisersAndCampaigns/campaigns/banners/editBanner"));
                        $oMenu->addTo("campaign-banners", new OA_Admin_Menu_Section("banner-swf", $GLOBALS['strConvertSWFLinks'], "banner-swf.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}"));
                        $oMenu->addTo("campaign-banners", new OA_Admin_Menu_Section("banner-acl", $GLOBALS['strModifyBannerAcl'], "banner-acl.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "inventory/advertisersAndCampaigns/campaigns/banners/editBanner/deliveryOptions"));
                        $oMenu->addTo("campaign-banners", new OA_Admin_Menu_Section("banner-zone", $GLOBALS['strLinkedZones'], "banner-zone.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "inventory/advertisersAndCampaigns/campaigns/banners/editBanner/linkedZones"));
                        $oMenu->addTo("campaign-banners", new OA_Admin_Menu_Section("banner-advanced", $GLOBALS['strAdvanced'], "banner-advanced.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "inventory/advertisersAndCampaigns/campaigns/banners/editBanner/convertFlashLinks"));
                if ($aConf['logging']['trackerImpressions']) {
                    $oMenu->addTo("advertiser-campaigns", new OA_Admin_Menu_Section("campaign-trackers", $GLOBALS['strLinkedTrackers'], "campaign-trackers.php?clientid={clientid}&campaignid={campaignid}", false, "inventory/advertisersAndCampaigns/campaigns/linkedTrackers"));
                        $oMenu->addTo("advertiser-index", new OA_Admin_Menu_Section("advertiser-trackers", $GLOBALS['strTrackers'], "advertiser-trackers.php?clientid={clientid}", false, "inventory/advertisersAndCampaigns/trackers"));
                            $oMenu->addTo("advertiser-trackers", new OA_Admin_Menu_Section("tracker-edit_new", $GLOBALS['strAddTracker'], "tracker-edit.php?clientid={clientid}", true, "inventory/advertisersAndCampaigns/trackers/addTracker"));
                            $oMenu->addTo("advertiser-trackers", new OA_Admin_Menu_Section("tracker-edit", $GLOBALS['strTrackerProperties'], "tracker-edit.php?clientid={clientid}&trackerid={trackerid}", false, "inventory/advertisersAndCampaigns/trackers/editTracker"));
                            $oMenu->addTo("advertiser-trackers", new OA_Admin_Menu_Section("tracker-campaigns", $GLOBALS['strLinkedCampaigns'], "tracker-campaigns.php?clientid={clientid}&trackerid={trackerid}", false, "inventory/advertisersAndCampaigns/trackers/editTracker/linkedCampaigns"));
                            $oMenu->addTo("advertiser-trackers", new OA_Admin_Menu_Section("tracker-variables", $GLOBALS['strVariables'], "tracker-variables.php?clientid={clientid}&trackerid={trackerid}", false, "inventory/advertisersAndCampaigns/trackers/editTracker/variables"));
                            $oMenu->addTo("advertiser-trackers", new OA_Admin_Menu_Section("tracker-append", $GLOBALS['strAppendTrackerCode'], "tracker-append.php?clientid={clientid}&trackerid={trackerid}", false, "inventory/advertisersAndCampaigns/trackers/editTracker/appendCode"));
                            $oMenu->addTo("advertiser-trackers", new OA_Admin_Menu_Section("tracker-invocation", $GLOBALS['strInvocationcode'], "tracker-invocation.php?clientid={clientid}&trackerid={trackerid}", false, "inventory/advertisersAndCampaigns/trackers/editTracker/invocationCode"));
                }
                $oMenu->addTo("advertiser-index", new OA_Admin_Menu_Section("advertiser-access", $GLOBALS['strUserAccess'], "advertiser-access.php?clientid={clientid}", false, ""));

            $oMenu->addTo("inventory", new OA_Admin_Menu_Section("affiliate-index", $GLOBALS['strAffiliatesAndZones'], "affiliate-index.php", false, "inventory/publishersAndZones"));
                $oMenu->addTo("affiliate-index", new OA_Admin_Menu_Section("affiliate-edit_new", $GLOBALS['strAddAffiliate'], "affiliate-edit.php", true, "inventory/publishersAndZones/addPublisher"));
                $oMenu->addTo("affiliate-index", new OA_Admin_Menu_Section("affiliate-edit", $GLOBALS['strAffiliateProperties'], "affiliate-edit.php?affiliateid={affiliateid}", false, "inventory/publishersAndZones/editPublisher"));
                $oMenu->addTo('affiliate-index', new OA_Admin_Menu_Section('affiliate-zones', $GLOBALS['strZones'], 'affiliate-zones.php?affiliateid={affiliateid}', false, "inventory/publishersAndZones/zones"));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-edit_new', $GLOBALS['strAddNewZone'], 'zone-edit.php?affiliateid={affiliateid}', true, "inventory/publishersAndZones/zones/addZone"));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-edit', $GLOBALS['strZoneProperties'], 'zone-edit.php?affiliateid={affiliateid}&zoneid={zoneid}', false, "inventory/publishersAndZones/zones/editZone"));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-advanced', $GLOBALS['strAdvanced'], 'zone-advanced.php?affiliateid={affiliateid}&zoneid={zoneid}', false, "inventory/publishersAndZones/zones/editZone/advanced"));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-include', $GLOBALS['strIncludedBanners'], 'zone-include.php?affiliateid={affiliateid}&zoneid={zoneid}', false, "inventory/publishersAndZones/zones/editZone/linkedBanners"));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-probability', $GLOBALS['strProbability'], 'zone-probability.php?affiliateid={affiliateid}&zoneid={zoneid}', false, "inventory/publishersAndZones/zones/editZone/probability"));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-invocation', $GLOBALS['strInvocationcode'], 'zone-invocation.php?affiliateid={affiliateid}&zoneid={zoneid}', false, "inventory/publishersAndZones/zones/editZone/invocationCode"));
                $oMenu->addTo('affiliate-index', new OA_Admin_Menu_Section('affiliate-channels', $GLOBALS['strChannels'], 'affiliate-channels.php?affiliateid={affiliateid}', false, "inventory/publishersAndZones/channels"));
                    $oMenu->addTo('affiliate-channels', new OA_Admin_Menu_Section('channel-edit-affiliate_new', $GLOBALS['strAddNewChannel'], 'channel-edit.php?affiliateid={affiliateid}', true, "inventory/publishersAndZones/channels/addChannel"));
                    $oMenu->addTo('affiliate-channels', new OA_Admin_Menu_Section('channel-edit-affiliate', $GLOBALS['strAddNewChannel'], 'channel-edit.php?affiliateid={affiliateid}&channelid={channelid}', true, "inventory/publishersAndZones/channels/editChannel"));
                    $oMenu->addTo('affiliate-channels', new OA_Admin_Menu_Section('channel-affiliate-acl', $GLOBALS['strAddNewChannel'], 'channel-acl.php?affiliateid={affiliateid}&channelid={channelid}', true, "inventory/publishersAndZones/channels/editChannel/deliveryOptions"));
                $oMenu->addTo('affiliate-index', new OA_Admin_Menu_Section('affiliate-invocation', $GLOBALS['strInvocationcode'], 'affiliate-invocation.php?affiliateid={affiliateid}', false, "inventory/affiliateInvocation"));
                $oMenu->addTo('affiliate-index', new OA_Admin_Menu_Section('affiliate-access', $GLOBALS['strUserAccess'], 'affiliate-access.php?affiliateid={affiliateid}'));

            $oMenu->addTo("inventory", new OA_Admin_Menu_Section("admin-generate", $GLOBALS['strGenerateBannercode'], "admin-generate.php", false, ""));
            $oMenu->addTo("inventory", new OA_Admin_Menu_Section("agency-access", $GLOBALS['strUserAccess'], "agency-access.php?agencyid={agencyid}", false, ""));

            $oMenu->add(new OA_Admin_Menu_Section("account-index", $GLOBALS['strMyAccount'], "account-index.php", false, "settings"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-user-index", $GLOBALS['strUserPreferences'], "account-user-index.php", false, ""));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-preferences-index", $GLOBALS['strPreferences'], "account-preferences-index.php", false, "settings/preferences"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("userlog-index", $GLOBALS['strUserLog'], "userlog-index.php", false, "settings/userLog"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("channel-index", $GLOBALS['strChannelManagement'], "channel-index.php", false, "settings/channelManagement"));
                    $oMenu->addTo("channel-index", new OA_Admin_Menu_Section("channel-edit_new", $GLOBALS['strAddNewChannel'], "channel-edit.php?agencyid={agencyid}", true, "settings/channelManagement/addChannel"));
                    $oMenu->addTo("channel-index", new OA_Admin_Menu_Section("channel-edit", $GLOBALS['strChannelProperties'], "channel-edit.php?agencyid={agencyid}&channelid={channelid}", false, "settings/channelManagement/editChannel"));
                        $oMenu->addTo("channel-edit", new OA_Admin_Menu_Section("channel-acl", $GLOBALS['strModifyBannerAcl'], "channel-acl.php?agencyid={agencyid}&channelid={channelid}", false, "settings/channelManagement/editChannel/deliveryOptions"));
            break;
        case OA_ACCOUNT_TRAFFICKER:
            // Note: The stats screens haven't been updated to use the new menuing names...
            $oMenu->add(new OA_Admin_Menu_Section("1", $GLOBALS['strStats'], "stats.php?entity=affiliate&breakdown=history&affiliateid={affiliateid}", false, "statistics/publisherHistory"));
                $oMenu->addTo("1", new OA_Admin_Menu_Section("1.1", $GLOBALS['strAffiliateHistory'], "stats.php?entity=affiliate&breakdown=history&affiliateid={affiliateid}", false, "statistics/publisherHistory"));
                $oMenu->addTo("1.1", new OA_Admin_Menu_Section("1.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&day={day}", false, "statistics/publisherHistory/daily"));
                $oMenu->addTo("1", new OA_Admin_Menu_Section("1.2", $GLOBALS['strZones'], "stats.php?entity=affiliate&breakdown=zones&affiliateid={affiliateid}", false, "statistics/zoneOverview"));
                $oMenu->addTo("1.2", new OA_Admin_Menu_Section("1.2.1", $GLOBALS['strZoneHistory'], "stats.php?entity=zone&breakdown=history&affiliateid={affiliateid}&zoneid={zoneid}", false, "statistics/zoneHistory"));
                $oMenu->addTo("1.2.1", new OA_Admin_Menu_Section("1.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&day={day}", false, "statistics/zoneHistory"));
                $oMenu->addTo("1.2", new OA_Admin_Menu_Section("1.2.2", $GLOBALS['strCampaignDistribution'], "stats.php?entity=zone&breakdown=campaigns&affiliateid={affiliateid}&zoneid={zoneid}", false, "statistics/zoneHistory/daily"));
                $oMenu->addTo("1.2.2", new OA_Admin_Menu_Section("1.2.2.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=zone&breakdown=campaign-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}", false, "statistics/campaignDistribution"));
                $oMenu->addTo("1.2.2.1", new OA_Admin_Menu_Section("1.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&day={day}", false, "statistics/campaignDistribution/history"));
                $oMenu->addTo("1.2.2", new OA_Admin_Menu_Section("1.2.2.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=zone&breakdown=banner-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}", false, "statistics/campaignDistribution/history/daily"));
                $oMenu->addTo("1.2.2.2", new OA_Admin_Menu_Section("1.2.2.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}&day={day}"));
                $oMenu->addTo("1", new OA_Admin_Menu_Section("1.3", $GLOBALS['strCampaignDistribution'], "stats.php?entity=affiliate&breakdown=campaigns&affiliateid={affiliateid}", false, "statistics/campaignDistribution"));
                $oMenu->addTo("1.3", new OA_Admin_Menu_Section("1.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=affiliate&breakdown=campaign-history&affiliateid={affiliateid}&campaignid={campaignid}", false, "statistics/campaignDistribution/history"));
                $oMenu->addTo("1.3.1", new OA_Admin_Menu_Section("1.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&day={day}", false, "statistics/campaignDistribution/history/daily"));
                $oMenu->addTo("1.3", new OA_Admin_Menu_Section("1.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=affiliate&breakdown=banner-history&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}"));
                $oMenu->addTo("1.3.2", new OA_Admin_Menu_Section("1.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}&day={day}"));
                $oMenu->addTo("1", new OA_Admin_Menu_Section("report-index", $GLOBALS['strAdvancedReports'], "report-index.php?affiliateid={affiliateid}", false, "reports"));

            $oMenu->add(new OA_Admin_Menu_Section("inventory", $GLOBALS['strAdminstration'], "affiliate-zones.php?affiliateid={affiliateid}", false, "inventory/publishersAndZones/zones"));
                $oMenu->addTo("inventory", new OA_Admin_Menu_Section("affiliate-zones", $GLOBALS['strZones'], "affiliate-zones.php?affiliateid={affiliateid}", false, "inventory/publishersAndZones/zones"));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-edit_new', $GLOBALS['strAddNewZone'], 'zone-edit.php?affiliateid={affiliateid}', true, "inventory/publishersAndZones/zones/addZone"));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-edit', $GLOBALS['strZoneProperties'], 'zone-edit.php?affiliateid={affiliateid}&zoneid={zoneid}', false, "inventory/publishersAndZones/zones/editZone"));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-include', $GLOBALS['strIncludedBanners'], 'zone-include.php?affiliateid={affiliateid}&zoneid={zoneid}', false, "inventory/publishersAndZones/zones/editZone/linkedBanners"));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-probability', $GLOBALS['strProbability'], 'zone-probability.php?affiliateid={affiliateid}&zoneid={zoneid}', false, "inventory/publishersAndZones/zones/editZone/linkedBanners/probability"));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-invocation', $GLOBALS['strInvocationcode'], 'zone-invocation.php?affiliateid={affiliateid}&zoneid={zoneid}', false, "inventory/publishersAndZones/zones/editZone/linkedBanners/invocationCode"));
                $oMenu->addTo('inventory', new OA_Admin_Menu_Section('affiliate-invocation', $GLOBALS['strInvocationcode'], 'affiliate-invocation.php?affiliateid={affiliateid}', false, "inventory/affiliateInvocation"));
                $oMenu->addTo('inventory', new OA_Admin_Menu_Section('affiliate-access', $GLOBALS['strUserAccess'], 'affiliate-access.php?affiliateid={affiliateid}', false, ""));
            $oMenu->add(new OA_Admin_Menu_Section("account-index", $GLOBALS['strMyAccount'], "account-index.php", false, "settings"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-user-index", $GLOBALS['strUserPreferences'], "account-user-index.php", false, "settings/preferences"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-preferences-index", $GLOBALS['strPreferences'], "account-preferences-index.php", false, "settings/preferences"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("userlog-index", $GLOBALS['strUserLog'], "userlog-index.php", false, "settings/userLog"));
        break;
        case OA_ACCOUNT_ADVERTISER:
            // Note: The stats screens haven't been updated to use the new menuing names...
            $oMenu->add(new OA_Admin_Menu_Section("1", $GLOBALS['strStats'], "stats.php?entity=advertiser&breakdown=history&clientid={clientid}", false, "statistics/advertiserHistory"));
            $oMenu->addTo("1", new OA_Admin_Menu_Section("1.1", $GLOBALS['strClientHistory'], "stats.php?entity=advertiser&breakdown=history&clientid={clientid}", false, "statistics/advertiserHistory"));
            $oMenu->addTo("1.1", new OA_Admin_Menu_Section("1.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&day={day}", false, "statistics/advertiserHistory/daily"));
            $oMenu->addTo("1", new OA_Admin_Menu_Section("1.2", $GLOBALS['strCampaigns'], "stats.php?entity=advertiser&breakdown=campaigns&clientid={clientid}", false, "statistics/campaignOverview"));
            $oMenu->addTo("1.2", new OA_Admin_Menu_Section("1.2.1", $GLOBALS['strCampaignHistory'], "stats.php?entity=campaign&breakdown=history&clientid={clientid}&campaignid={campaignid}", false, "statistics/campaignHistory"));
            $oMenu->addTo("1.2.1", new OA_Admin_Menu_Section("1.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&day={day}", false, "statistics/campaignHistory/daily"));
            $oMenu->addTo("1.2", new OA_Admin_Menu_Section("1.2.2", $GLOBALS['strBanners'], "stats.php?entity=campaign&breakdown=banners&clientid={clientid}&campaignid={campaignid}", false, "statistics/bannerOverview"));
            $oMenu->addTo("1.2.2", new OA_Admin_Menu_Section("1.2.2.1", $GLOBALS['strBannerHistory'], "stats.php?entity=banner&breakdown=history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "statistics/bannerHistory"));
            $oMenu->addTo("1.2.2.1", new OA_Admin_Menu_Section("1.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&day={day}", false, "statistics/bannerHistory/daily"));
            $oMenu->addTo("1.2.2", new OA_Admin_Menu_Section("1.2.2.2", $GLOBALS['strBannerProperties'], "banner-edit.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false));
            $oMenu->addTo("1.2.2", new OA_Admin_Menu_Section("1.2.2.3", $GLOBALS['strConvertSWFLinks'], "banner-swf.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false));
            $oMenu->addTo("1.2.2", new OA_Admin_Menu_Section("1.2.2.4", $GLOBALS['strPublisherDistribution'], "stats.php?entity=banner&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "statistics/publisherDistribution"));
            $oMenu->addTo("1.2.2.4", new OA_Admin_Menu_Section("1.2.2.4.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=banner&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}", false, "statistics/publisherDistribution/history"));
            $oMenu->addTo("1.2.2.4.1", new OA_Admin_Menu_Section("1.2.2.4.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&day={day}", false, "statistics/publisherDistribution/history/daily"));
            $oMenu->addTo("1.2.2.4", new OA_Admin_Menu_Section("1.2.2.4.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=banner&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}"));
            $oMenu->addTo("1.2.2.4.2", new OA_Admin_Menu_Section("1.2.2.4.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
            $oMenu->addTo("1.2", new OA_Admin_Menu_Section("1.2.3", $GLOBALS['strPublisherDistribution'], "stats.php?entity=campaign&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}", false, "statistics/publisherDistribution"));
            $oMenu->addTo("1.2.3", new OA_Admin_Menu_Section("1.2.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=campaign&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}", false, "statistics/publisherDistribution/history"));
            $oMenu->addTo("1.2.3.1", new OA_Admin_Menu_Section("1.2.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&day={day}", false, "statistics/publisherDistribution/history/daily"));
            $oMenu->addTo("1.2.3", new OA_Admin_Menu_Section("1.2.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=campaign&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}"));
            $oMenu->addTo("1.2.3.2", new OA_Admin_Menu_Section("1.2.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
            $oMenu->addTo("1", new OA_Admin_Menu_Section("1.3", $GLOBALS['strPublisherDistribution'], "stats.php?entity=advertiser&breakdown=affiliates&clientid={clientid}", false, "statistics/publisherDistribution"));
            $oMenu->addTo("1.3", new OA_Admin_Menu_Section("1.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=advertiser&breakdown=affiliate-history&clientid={clientid}&affiliateid={affiliateid}", false, "statistics/publisherDistribution/hisotry"));
            $oMenu->addTo("1.3.1", new OA_Admin_Menu_Section("1.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&day={day}", false, "statistics/publisherDistribution/history/daily"));
            $oMenu->addTo("1.3", new OA_Admin_Menu_Section("1.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=advertiser&breakdown=zone-history&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}"));
            $oMenu->addTo("1.3.2", new OA_Admin_Menu_Section("1.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
            $oMenu->addTo("1", new OA_Admin_Menu_Section("report-index", $GLOBALS['strAdvancedReports'], "report-index.php?clientid={clientid}", false, "reports"));

            $oMenu->add(new OA_Admin_Menu_Section("inventory", $GLOBALS['strAdminstration'], "advertiser-campaigns.php?clientid={clientid}", false, "inventory/advertisersAndCampaigns/campaigns"));
                $oMenu->addTo("inventory", new OA_Admin_Menu_Section("advertiser-campaigns", $GLOBALS['strCampaigns'], "advertiser-campaigns.php?clientid={clientid}", false, "inventory/advertisersAndCampaigns/campaigns"));
                    $oMenu->addTo("advertiser-campaigns", new OA_Admin_Menu_Section("campaign-banners", $GLOBALS['strBanners'], "campaign-banners.php?clientid={clientid}&campaignid={campaignid}", false, "inventory/advertisersAndCampaigns/campaigns/banners"));
                        $oMenu->addTo("campaign-banners", new OA_Admin_Menu_Section("banner-edit", $GLOBALS['strBannerProperties'], "banner-edit.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "inventory/advertisersAndCampaigns/campaigns/editBanner"));
                $oMenu->addTo("inventory", new OA_Admin_Menu_Section("advertiser-access", $GLOBALS['strUserAccess'], "advertiser-access.php?clientid={clientid}"));
            $oMenu->add(new OA_Admin_Menu_Section("account-index", $GLOBALS['strMyAccount'], "account-index.php", false, "settings"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-user-index", $GLOBALS['strUserPreferences'], "account-user-index.php", false, ""));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-preferences-index", $GLOBALS['strPreferences'], "account-preferences-index.php", false, "settings/prefrences"));
        break;
    }

    $GLOBALS['_MAX']['MENU_OBJECT'][$accountType] = &$oMenu;
    return $oMenu;
}

?>
