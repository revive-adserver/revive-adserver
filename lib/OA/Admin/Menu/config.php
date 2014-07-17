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

require_once(MAX_PATH . '/lib/OA/Permission.php');

// Setup navigation
function _buildNavigation($accountType)
{
    $oMenu = new OA_Admin_Menu;

    $aConf = $GLOBALS['_MAX']['CONF'];

    switch ($accountType) {
        case OA_ACCOUNT_ADMIN:
            if ($GLOBALS['_MAX']['CONF']['ui']['dashboardEnabled']) {
                $oMenu->add(new OA_Admin_Menu_Section("dashboard", 'Home', "dashboard.php", false, ""));
            }

            // Note: The stats screens haven't been updated to use the new menuing names...
            $oMenu->add(new OA_Admin_Menu_Section("2", 'Stats', "stats.php", false, "statistics"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("2.1", 'ClientsAndCampaigns', "stats.php?1=1", false, "statistics/advertisersAndCampaigns"));
                $oMenu->addTo("2.1", new OA_Admin_Menu_Section("2.1.1", 'ClientHistory', "stats.php?entity=advertiser&breakdown=history&clientid={clientid}", false, "statistics/advertiserHistory"));
                $oMenu->addTo("2.1.1", new OA_Admin_Menu_Section("2.1.1.1", 'DailyStats', "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&day={day}", false, "statistics/advertiserHistory/daily"));
                $oMenu->addTo("2.1", new OA_Admin_Menu_Section("2.1.2", 'Campaigns', "stats.php?entity=advertiser&breakdown=campaigns&clientid={clientid}", false, "statistics/campaignOverview"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.1", 'CampaignHistory', "stats.php?entity=campaign&breakdown=history&clientid={clientid}&campaignid={campaignid}", false, "statistics/campaignHistory"));
                $oMenu->addTo("2.1.2.1", new OA_Admin_Menu_Section("2.1.2.1.1", 'DailyStats', "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&day={day}", false, "statistics/campaignHistory/daily"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.2", 'Banners', "stats.php?entity=campaign&breakdown=banners&clientid={clientid}&campaignid={campaignid}", false, "statistics/bannerOverview"));
                $oMenu->addTo("2.1.2.2", new OA_Admin_Menu_Section("2.1.2.2.1", 'BannerHistory', "stats.php?entity=banner&breakdown=history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "statistics/bannerHistory"));
                $oMenu->addTo("2.1.2.2.1", new OA_Admin_Menu_Section("2.1.2.2.1.1", 'DailyStats', "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&day={day}", false, "statistics/bannerHistory/daily"));
                $oMenu->addTo("2.1.2.2", new OA_Admin_Menu_Section("2.1.2.2.2", 'PublisherDistribution', "stats.php?entity=banner&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "statistics/publisherDistribution"));
                $oMenu->addTo("2.1.2.2.2", new OA_Admin_Menu_Section("2.1.2.2.2.1", 'DistributionHistoryWebsite', "stats.php?entity=banner&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}", true, "statistics/publisherDistribution/history"));
                $oMenu->addTo("2.1.2.2.2.1", new OA_Admin_Menu_Section("2.1.2.2.2.1.1", 'DailyStats', "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&day={day}", false, "statistics/publisherDistribution/history/daily"));
                $oMenu->addTo("2.1.2.2.2", new OA_Admin_Menu_Section("2.1.2.2.2.2", 'DistributionHistoryZone', "stats.php?entity=banner&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}", true));
                $oMenu->addTo("2.1.2.2.2.2", new OA_Admin_Menu_Section("2.1.2.2.2.2.1", 'DailyStats', "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.3", 'PublisherDistribution', "stats.php?entity=campaign&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}", false, "statistics/publisherDistribution"));
                $oMenu->addTo("2.1.2.3", new OA_Admin_Menu_Section("2.1.2.3.1", 'DistributionHistoryWebsite', "stats.php?entity=campaign&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}", true, "statistics/publisherDistribution/history"));
                $oMenu->addTo("2.1.2.3.1", new OA_Admin_Menu_Section("2.1.2.3.1.1", 'DailyStats', "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&day={day}", false, "statistics/publisherDistribution/history/daily"));
                $oMenu->addTo("2.1.2.3", new OA_Admin_Menu_Section("2.1.2.3.2", 'DistributionHistoryZone', "stats.php?entity=campaign&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}", true));
                $oMenu->addTo("2.1.2.3.2", new OA_Admin_Menu_Section("2.1.2.3.2.1", 'DailyStats', "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("2.1", new OA_Admin_Menu_Section("2.1.3", 'PublisherDistribution', "stats.php?entity=advertiser&breakdown=affiliates&clientid={clientid}", false, "statistics/publisherDistribution"));
                $oMenu->addTo("2.1.3", new OA_Admin_Menu_Section("2.1.3.1", 'DistributionHistoryWebsite', "stats.php?entity=advertiser&breakdown=affiliate-history&clientid={clientid}&affiliateid={affiliateid}", true, "statistics/publisherDistribution/history"));
                $oMenu->addTo("2.1.3.1", new OA_Admin_Menu_Section("2.1.3.1.1", 'DailyStats', "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&day={day}", false, "statistics/publisherDistribution/history/daily"));
                $oMenu->addTo("2.1.3", new OA_Admin_Menu_Section("2.1.3.2", 'DistributionHistoryZone', "stats.php?entity=advertiser&breakdown=zone-history&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}", true));
                $oMenu->addTo("2.1.3.2", new OA_Admin_Menu_Section("2.1.3.2.1", 'DailyStats', "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("2.4", 'AffiliatesAndZones', "stats.php?entity=global&breakdown=affiliates", false, "statistics/publishersAndZones"));
                $oMenu->addTo("2.4", new OA_Admin_Menu_Section("2.4.1", 'AffiliateHistory', "stats.php?entity=affiliate&breakdown=history&affiliateid={affiliateid}", false, "statistics/publisherHistory"));
                $oMenu->addTo("2.4.1", new OA_Admin_Menu_Section("2.4.1.1", 'DailyStats', "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&day={day}", false, "statistics/publisherHistory/daily"));
                $oMenu->addTo("2.4", new OA_Admin_Menu_Section("2.4.2", 'Zones', "stats.php?entity=affiliate&breakdown=zones&affiliateid={affiliateid}", false, "statistics/zoneOverview"));
                $oMenu->addTo("2.4.2", new OA_Admin_Menu_Section("2.4.2.1", 'ZoneHistory', "stats.php?entity=zone&breakdown=history&affiliateid={affiliateid}&zoneid={zoneid}", false, "statistics/zoneHistory"));
                $oMenu->addTo("2.4.2.1", new OA_Admin_Menu_Section("2.4.2.1.1", 'DailyStats', "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&day={day}", false, "statistics/zoneHistory/daily"));
                $oMenu->addTo("2.4.2", new OA_Admin_Menu_Section("2.4.2.2", 'CampaignDistribution', "stats.php?entity=zone&breakdown=campaigns&affiliateid={affiliateid}&zoneid={zoneid}", false, "statistics/campaignDistribution"));
                $oMenu->addTo("2.4.2.2", new OA_Admin_Menu_Section("2.4.2.2.1", 'DistributionHistoryCampaign', "stats.php?entity=zone&breakdown=campaign-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}", true, "statistics/campaignDistribution/history"));
                $oMenu->addTo("2.4.2.2.1", new OA_Admin_Menu_Section("2.4.2.2.1.1", 'DailyStats', "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&day={day}", false, "statistics/campaignDistribution/history/daily"));
                $oMenu->addTo("2.4.2.2", new OA_Admin_Menu_Section("2.4.2.2.2", 'DistributionHistoryBanner', "stats.php?entity=zone&breakdown=banner-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}", true));
                $oMenu->addTo("2.4.2.2.2", new OA_Admin_Menu_Section("2.4.2.2.2.1", 'DailyStats', "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}&day={day}"));
                $oMenu->addTo("2.4", new OA_Admin_Menu_Section("2.4.3", 'CampaignDistribution', "stats.php?entity=affiliate&breakdown=campaigns&affiliateid={affiliateid}", false, "statistics/campaignDistribution"));
                $oMenu->addTo("2.4.3", new OA_Admin_Menu_Section("2.4.3.1", 'DistributionHistoryCampaign', "stats.php?entity=affiliate&breakdown=campaign-history&affiliateid={affiliateid}&campaignid={campaignid}", true, "statistics/campaignDistribution/history"));
                $oMenu->addTo("2.4.3.1", new OA_Admin_Menu_Section("2.4.3.1.1", 'DailyStats', "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&day={day}", false, "statistics/campaignDistribution/history/daily"));
                $oMenu->addTo("2.4.3", new OA_Admin_Menu_Section("2.4.3.2", 'DistributionHistoryBanner', "stats.php?entity=affiliate&breakdown=banner-history&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}", true));
                $oMenu->addTo("2.4.3.2", new OA_Admin_Menu_Section("2.4.3.2.1", 'DailyStats', "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}&day={day}"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("2.2", 'GlobalHistory', "stats.php?entity=global&breakdown=history", false, "statistics/global"));
                $oMenu->addTo("2.2", new OA_Admin_Menu_Section("2.2.1", 'DailyStats', "stats.php?entity=global&breakdown=daily&day={day}", false, "statistics/global/daily"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("report-index", 'AdvancedReports', "report-index.php", false, "statistics"));

            $oMenu->add(new OA_Admin_Menu_Section("inventory", 'Adminstration', "agency-index.php", false, "inventory"));
                $oMenu->addTo("inventory", new OA_Admin_Menu_Section("agency-index", 'AgencyManagement', "agency-index.php", false, "settings/agencyManagement"));
                $oMenu->addTo("agency-index", new OA_Admin_Menu_Section("agency-edit_new", 'AddAgency', "agency-edit.php", true, "settings/agencyManagement/addagency"));
                $oMenu->addTo("agency-index", new OA_Admin_Menu_Section("agency-edit", 'AgencyProperties', "agency-edit.php?agencyid={agencyid}", false, "settings/agencyManagement/editagency"));
                $oMenu->addTo("agency-index", new OA_Admin_Menu_Section("agency-access", 'UserAccess', "agency-access.php?agencyid={agencyid}", false, "inventory/directSelection"));
                if (empty($aConf['ui']['disableDirectSelection'])) {
                    $oMenu->addTo("inventory", new OA_Admin_Menu_Section("admin-generate", 'GenerateBannercode', "admin-generate.php"));
                }
                $oMenu->addTo("inventory", new OA_Admin_Menu_Section("admin-access", 'AdminAccess', "admin-access.php"));
                $oMenu->addTo("admin-access", new OA_Admin_Menu_Section("admin-user", 'AdminAccess', "admin-user.php?userid={userid}"));

            $oMenu->add(new OA_Admin_Menu_Section("account-index", 'Preferences', "account-index.php", false, "settings/preferences"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-user-index", 'UserPreferences', "account-user-index.php", false, ""));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-preferences-index", 'AccountPreferences', "account-preferences-index.php", false, "settings/preferences"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("userlog-index", 'UserLog', "userlog-index.php", false, "settings/userLog"));
                $oMenu->addTo("userlog-index", new OA_Admin_Menu_Section("userlog-details", 'UserLogDetails', "userlog-audit-detailed.php", false, "settings/userLog/details"));

            $oMenu->add(new OA_Admin_Menu_Section("configuration", 'Configuration', "account-settings-index.php", false, "settings"));
                $oMenu->addTo("configuration", new OA_Admin_Menu_Section("account-settings-index", 'GlobalSettings', "account-settings-index.php", false, ""));
                $oMenu->addTo("configuration", new OA_Admin_Menu_Section("maintenance-index", 'Maintenance', "maintenance-index.php", false, "settings/maintenance"));
                $oMenu->addTo("configuration", new OA_Admin_Menu_Section("updates-index", 'ProductUpdates', "updates-product.php", false, "settings/productUpdates"));
            $oMenu->add(new OA_Admin_Menu_Section("plugin-index", 'Plugins', "plugin-index.php"));

        break;
        case OA_ACCOUNT_MANAGER:
            if ($GLOBALS['_MAX']['CONF']['ui']['dashboardEnabled'] && $aConf['sync']['checkForUpdates']) {
                $oMenu->add(new OA_Admin_Menu_Section("dashboard", 'Home', "dashboard.php", false, "dashboard"));
            }

            // Note: The stats screens haven't been updated to use the new menuing names...
            $oMenu->add(new OA_Admin_Menu_Section("2", 'Stats', "stats.php", false, "statistics"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("2.1", 'ClientsAndCampaigns', "stats.php?1=1", false, "statistics/advertisersAndCampaigns"));
                $oMenu->addTo("2.1", new OA_Admin_Menu_Section("2.1.1", 'ClientHistory', "stats.php?entity=advertiser&breakdown=history&clientid={clientid}", false, "statistics/advertiserHistory"));
                $oMenu->addTo("2.1.1", new OA_Admin_Menu_Section("2.1.1.1", 'DailyStats', "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&day={day}", false, "statistics/advertiserHistory/daily"));
                $oMenu->addTo("2.1", new OA_Admin_Menu_Section("2.1.2", 'Campaigns', "stats.php?entity=advertiser&breakdown=campaigns&clientid={clientid}", false, "statistics/campaignOverview"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.1", 'CampaignHistory', "stats.php?entity=campaign&breakdown=history&clientid={clientid}&campaignid={campaignid}", false, "statistics/campaignHistory"));
                $oMenu->addTo("2.1.2.1", new OA_Admin_Menu_Section("2.1.2.1.1", 'DailyStats', "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&day={day}", false, "statistics/campaignHistory/daily"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.2", 'Banners', "stats.php?entity=campaign&breakdown=banners&clientid={clientid}&campaignid={campaignid}", false, "statistics/bannerOverview"));
                $oMenu->addTo("2.1.2.2", new OA_Admin_Menu_Section("2.1.2.2.1", 'BannerHistory', "stats.php?entity=banner&breakdown=history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "statistics/bannerHistory"));
                $oMenu->addTo("2.1.2.2.1", new OA_Admin_Menu_Section("2.1.2.2.1.1", 'DailyStats', "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&day={day}", false, "statistics/bannerHistory/daily"));
                $oMenu->addTo("2.1.2.2", new OA_Admin_Menu_Section("2.1.2.2.2", 'PublisherDistribution', "stats.php?entity=banner&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "statistics/publisherDistribution"));
                $oMenu->addTo("2.1.2.2.2", new OA_Admin_Menu_Section("2.1.2.2.2.1", 'DistributionHistoryWebsite', "stats.php?entity=banner&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}", true, "statistics/publisherDistribution/history"));
                $oMenu->addTo("2.1.2.2.2.1", new OA_Admin_Menu_Section("2.1.2.2.2.1.1", 'DailyStats', "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&day={day}", false, "statistics/publisherDistribution/history/daily"));
                $oMenu->addTo("2.1.2.2.2", new OA_Admin_Menu_Section("2.1.2.2.2.2", 'DistributionHistoryZone', "stats.php?entity=banner&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}", true));
                $oMenu->addTo("2.1.2.2.2.2", new OA_Admin_Menu_Section("2.1.2.2.2.2.1", 'DailyStats', "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.3", 'PublisherDistribution', "stats.php?entity=campaign&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}", false, "statistics/publisherDistribution"));
                $oMenu->addTo("2.1.2.3", new OA_Admin_Menu_Section("2.1.2.3.1", 'DistributionHistoryWebsite', "stats.php?entity=campaign&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}", true, "statistics/publisherDistribution/history"));
                $oMenu->addTo("2.1.2.3.1", new OA_Admin_Menu_Section("2.1.2.3.1.1", 'DailyStats', "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&day={day}", false, "statistics/publisherDistribution/history/daily"));
                $oMenu->addTo("2.1.2.3", new OA_Admin_Menu_Section("2.1.2.3.2", 'DistributionHistoryZone', "stats.php?entity=campaign&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}", true));
                $oMenu->addTo("2.1.2.3.2", new OA_Admin_Menu_Section("2.1.2.3.2.1", 'DailyStats', "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("2.1", new OA_Admin_Menu_Section("2.1.3", 'PublisherDistribution', "stats.php?entity=advertiser&breakdown=affiliates&clientid={clientid}", false, "statistics/publisherDistribution"));
                $oMenu->addTo("2.1.3", new OA_Admin_Menu_Section("2.1.3.1", 'DistributionHistoryWebsite', "stats.php?entity=advertiser&breakdown=affiliate-history&clientid={clientid}&affiliateid={affiliateid}", true, "statistics/publisherDistribution/history"));
                $oMenu->addTo("2.1.3.1", new OA_Admin_Menu_Section("2.1.3.1.1", 'DailyStats', "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&day={day}", false, "statistics/publisherDistribution/history/daily"));
                $oMenu->addTo("2.1.3", new OA_Admin_Menu_Section("2.1.3.2", 'DistributionHistoryZone', "stats.php?entity=advertiser&breakdown=zone-history&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}", true));
                $oMenu->addTo("2.1.3.2", new OA_Admin_Menu_Section("2.1.3.2.1", 'DailyStats', "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("2.2", 'GlobalHistory', "stats.php?entity=global&breakdown=history", false, "statistics/global"));
                $oMenu->addTo("2.2", new OA_Admin_Menu_Section("2.2.1", 'DailyStats', "stats.php?entity=global&breakdown=daily&day={day}", false, "statistics/global/daily"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("2.4", 'AffiliatesAndZones', "stats.php?entity=global&breakdown=affiliates", false, "statistics/publishersAndZones"));
                $oMenu->addTo("2.4", new OA_Admin_Menu_Section("2.4.1", 'AffiliateHistory', "stats.php?entity=affiliate&breakdown=history&affiliateid={affiliateid}", false, "statistics/publisherHistory"));
                $oMenu->addTo("2.4.1", new OA_Admin_Menu_Section("2.4.1.1", 'DailyStats', "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&day={day}", false, "statistics/publisherHistory/daily"));
                $oMenu->addTo("2.4", new OA_Admin_Menu_Section("2.4.2", 'Zones', "stats.php?entity=affiliate&breakdown=zones&affiliateid={affiliateid}", false, "statistics/zoneOverview"));
                $oMenu->addTo("2.4.2", new OA_Admin_Menu_Section("2.4.2.1", 'ZoneHistory', "stats.php?entity=zone&breakdown=history&affiliateid={affiliateid}&zoneid={zoneid}", false, "statistics/zoneHistory"));
                $oMenu->addTo("2.4.2.1", new OA_Admin_Menu_Section("2.4.2.1.1", 'DailyStats', "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&day={day}", false, "statistics/zoneHistory/daily"));
                $oMenu->addTo("2.4.2", new OA_Admin_Menu_Section("2.4.2.2", 'CampaignDistribution', "stats.php?entity=zone&breakdown=campaigns&affiliateid={affiliateid}&zoneid={zoneid}", false, "statistics/campaignDistribution"));
                $oMenu->addTo("2.4.2.2", new OA_Admin_Menu_Section("2.4.2.2.1", 'DistributionHistoryCampaign', "stats.php?entity=zone&breakdown=campaign-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}", true, "statistics/campaignDistribution/history"));
                $oMenu->addTo("2.4.2.2.1", new OA_Admin_Menu_Section("2.4.2.2.1.1", 'DailyStats', "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&day={day}", false, "statistics/campaignDistribution/history/daily"));
                $oMenu->addTo("2.4.2.2", new OA_Admin_Menu_Section("2.4.2.2.2", 'DistributionHistoryBanner', "stats.php?entity=zone&breakdown=banner-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}", true));
                $oMenu->addTo("2.4.2.2.2", new OA_Admin_Menu_Section("2.4.2.2.2.1", 'DailyStats', "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}&day={day}"));
                $oMenu->addTo("2.4", new OA_Admin_Menu_Section("2.4.3", 'CampaignDistribution', "stats.php?entity=affiliate&breakdown=campaigns&affiliateid={affiliateid}", false, "statistics/campaignDistribution"));
                $oMenu->addTo("2.4.3", new OA_Admin_Menu_Section("2.4.3.1", 'DistributionHistoryCampaign', "stats.php?entity=affiliate&breakdown=campaign-history&affiliateid={affiliateid}&campaignid={campaignid}", true, "statistics/campaignDistribution/history"));
                $oMenu->addTo("2.4.3.1", new OA_Admin_Menu_Section("2.4.3.1.1", 'DailyStats', "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&day={day}", false, "statistics/campaignDistribution/history/daily"));
                $oMenu->addTo("2.4.3", new OA_Admin_Menu_Section("2.4.3.2", 'DistributionHistoryBanner', "stats.php?entity=affiliate&breakdown=banner-history&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}", true));
                $oMenu->addTo("2.4.3.2", new OA_Admin_Menu_Section("2.4.3.2.1", 'DailyStats', "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}&day={day}"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("report-index", 'AdvancedReports', "report-index.php", false, "statistics"));

            $oMenu->add(new OA_Admin_Menu_Section("inventory", 'Adminstration', "advertiser-index.php", false, ""));

            $oMenu->addTo("inventory", new OA_Admin_Menu_Section("advertiser-index", 'Clients', "advertiser-index.php", false, "inventory", null, 1, false, 'g_adv'));
                $oMenu->addTo("advertiser-index", new OA_Admin_Menu_Section("advertiser-edit_new", 'AddClient', "advertiser-edit.php", true, "inventory/advertiserAndCampaings/addAdvertiser"));
                $oMenu->addTo("advertiser-index", new OA_Admin_Menu_Section("advertiser-edit", 'ClientProperties', "advertiser-edit.php?clientid={clientid}", false, "inventory/advertiserAndCampaings/editAdvertiser"));
                if ($aConf['logging']['trackerImpressions']) {
                    $oMenu->addTo("advertiser-index", new OA_Admin_Menu_Section("advertiser-trackers", 'Trackers', "advertiser-trackers.php?clientid={clientid}", false, "inventory/advertisersAndCampaigns/trackers"));
                        $oMenu->addTo("advertiser-trackers", new OA_Admin_Menu_Section("tracker-edit_new", 'AddTracker', "tracker-edit.php?clientid={clientid}", true, "inventory/advertisersAndCampaigns/trackers/addTracker"));
                        $oMenu->addTo("advertiser-trackers", new OA_Admin_Menu_Section("tracker-edit", 'TrackerProperties', "tracker-edit.php?clientid={clientid}&trackerid={trackerid}", false, "inventory/advertisersAndCampaigns/trackers/editTracker"));
                        $oMenu->addTo("advertiser-trackers", new OA_Admin_Menu_Section("tracker-campaigns", 'LinkedCampaigns', "tracker-campaigns.php?clientid={clientid}&trackerid={trackerid}", false, "inventory/advertisersAndCampaigns/trackers/editTracker/linkedCampaigns"));
                        $oMenu->addTo("advertiser-trackers", new OA_Admin_Menu_Section("tracker-variables", 'Variables', "tracker-variables.php?clientid={clientid}&trackerid={trackerid}", false, "inventory/advertisersAndCampaigns/trackers/editTracker/variables"));
                        $oMenu->addTo("advertiser-trackers", new OA_Admin_Menu_Section("tracker-append", 'AppendTrackerCode', "tracker-append.php?clientid={clientid}&trackerid={trackerid}", false, "inventory/advertisersAndCampaigns/trackers/editTracker/appendCode"));
                        $oMenu->addTo("advertiser-trackers", new OA_Admin_Menu_Section("tracker-invocation", 'Invocationcode', "tracker-invocation.php?clientid={clientid}&trackerid={trackerid}", false, "inventory/advertisersAndCampaigns/trackers/editTracker/invocationCode"));
                }
                $oMenu->addTo("advertiser-index", new OA_Admin_Menu_Section("advertiser-access", 'UserAccess', "advertiser-access.php?clientid={clientid}", false, ""));

            $oMenu->addTo("inventory", new OA_Admin_Menu_Section("advertiser-campaigns", 'Campaigns', "advertiser-campaigns.php", false, "inventory/advertiserAndCampaings/campaigns", null, 1, false, 'g_adv'));
                $oMenu->addTo("advertiser-campaigns", new OA_Admin_Menu_Section("campaign-edit_new", 'AddCampaign', "campaign-edit.php?clientid={clientid}", true, "inventory/advertiserAndCampaings/campaigns/addCampaign"));
                $oMenu->addTo("advertiser-campaigns", new OA_Admin_Menu_Section("campaign-edit", 'CampaignProperties', "campaign-edit.php?clientid={clientid}&campaignid={campaignid}", false, "inventory/advertisersAndCampaigns/campaigns/editCampaign"));
                $oMenu->addTo("advertiser-campaigns", new OA_Admin_Menu_Section("campaign-zone", 'LinkedZones', "campaign-zone.php?clientid={clientid}&campaignid={campaignid}", false, "inventory/advertisersAndCampaigns/campaigns/linkedZones"));
                if ($aConf['logging']['trackerImpressions']) {
                    $oMenu->addTo("advertiser-campaigns", new OA_Admin_Menu_Section("campaign-trackers", 'LinkedTrackers', "campaign-trackers.php?clientid={clientid}&campaignid={campaignid}", false, "inventory/advertisersAndCampaigns/campaigns/linkedTrackers"));
                }

            $oMenu->addTo("inventory", new OA_Admin_Menu_Section("campaign-banners", 'Banners', "campaign-banners.php", false, "inventory/advertisersAndCampaigns/campaigns/banners", null, 1, false, 'g_adv'));
                $oMenu->addTo("campaign-banners", new OA_Admin_Menu_Section("banner-edit_new", 'AddBanner', "banner-edit.php?clientid={clientid}&campaignid={campaignid}", true, "inventory/advertisersAndCampaigns/campaigns/banners/addBanner"));
                $oMenu->addTo("campaign-banners", new OA_Admin_Menu_Section("banner-edit", 'BannerProperties', "banner-edit.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "inventory/advertisersAndCampaigns/campaigns/banners/editBanner"));
                $oMenu->addTo("campaign-banners", new OA_Admin_Menu_Section("banner-swf", 'ConvertSWFLinks', "banner-swf.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, null, array(), 1, true));
                $oMenu->addTo("campaign-banners", new OA_Admin_Menu_Section("banner-acl", 'ModifyBannerAcl', "banner-acl.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "inventory/advertisersAndCampaigns/campaigns/banners/editBanner/deliveryOptions"));
                $oMenu->addTo("campaign-banners", new OA_Admin_Menu_Section("banner-zone", 'LinkedZones', "banner-zone.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "inventory/advertisersAndCampaigns/campaigns/banners/editBanner/linkedZones"));
                $oMenu->addTo("campaign-banners", new OA_Admin_Menu_Section("banner-advanced", 'Advanced', "banner-advanced.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "inventory/advertisersAndCampaigns/campaigns/banners/editBanner/convertFlashLinks"));

            $oMenu->addTo("inventory", new OA_Admin_Menu_Section("website-index", 'Affiliates', "website-index.php", false, "inventory/publishersAndZones", null, 1, false, 'g_website'));
                $oMenu->addTo("website-index", new OA_Admin_Menu_Section("affiliate-edit_new", 'AddNewAffiliate', "affiliate-edit.php", true, "inventory/publishersAndZones/addPublisher"));
                $oMenu->addTo("website-index", new OA_Admin_Menu_Section("affiliate-edit", 'AffiliateProperties', "affiliate-edit.php?affiliateid={affiliateid}", false, "inventory/publishersAndZones/editPublisher"));
                $oMenu->addTo('website-index', new OA_Admin_Menu_Section('affiliate-invocation', 'Invocationcode', 'affiliate-invocation.php?affiliateid={affiliateid}', false, "inventory/affiliateInvocation"));
                    $oMenu->addTo('affiliate-invocation', new OA_Admin_Menu_Section('affiliate-preview', 'InvocationcodePreview', 'affiliate-preview.php'));
                $oMenu->addTo('website-index', new OA_Admin_Menu_Section('affiliate-access', 'UserAccess', 'affiliate-access.php?affiliateid={affiliateid}'));

            $oMenu->addTo('inventory', new OA_Admin_Menu_Section('affiliate-zones', 'Zones', 'affiliate-zones.php', false, "inventory/publishersAndZones/zones", null, 1, false, 'g_website'));
                $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-edit_new', 'AddNewZone', 'zone-edit.php?affiliateid={affiliateid}', true, "inventory/publishersAndZones/zones/addZone"));
                $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-edit', 'ZoneProperties', 'zone-edit.php?affiliateid={affiliateid}&zoneid={zoneid}', false, "inventory/publishersAndZones/zones/editZone"));
                $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-advanced', 'Advanced', 'zone-advanced.php?affiliateid={affiliateid}&zoneid={zoneid}', false, "inventory/publishersAndZones/zones/editZone/advanced"));
                $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-include', 'IncludedBanners', 'zone-include.php?affiliateid={affiliateid}&zoneid={zoneid}', false, "inventory/publishersAndZones/zones/editZone/linkedBanners"));
                $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-probability', 'Probability', 'zone-probability.php?affiliateid={affiliateid}&zoneid={zoneid}', false, "inventory/publishersAndZones/zones/editZone/probability"));
                $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-invocation', 'Invocationcode', 'zone-invocation.php?affiliateid={affiliateid}&zoneid={zoneid}', false, "inventory/publishersAndZones/zones/editZone/invocationCode"));

            $oMenu->addTo('inventory', new OA_Admin_Menu_Section('affiliate-channels', 'Channels', 'affiliate-channels.php', false, "inventory/publishersAndZones/channels", null, 1, false, 'g_website'));
                $oMenu->addTo('affiliate-channels', new OA_Admin_Menu_Section('channel-edit-affiliate_new', 'AddNewChannel', 'channel-edit.php?affiliateid={affiliateid}', true, "inventory/publishersAndZones/channels/addChannel"));
                $oMenu->addTo('affiliate-channels', new OA_Admin_Menu_Section('channel-edit-affiliate', 'ChannelProperties', 'channel-edit.php?affiliateid={affiliateid}&channelid={channelid}', false, "inventory/publishersAndZones/channels/editChannel"));
                $oMenu->addTo('affiliate-channels', new OA_Admin_Menu_Section('channel-affiliate-acl', 'ChannelLimitations', 'channel-acl.php?affiliateid={affiliateid}&channelid={channelid}', false, "inventory/publishersAndZones/channels/editChannel/deliveryOptions"));


            if (empty($aConf['ui']['disableDirectSelection'])) {
                $oMenu->addTo("inventory", new OA_Admin_Menu_Section("admin-generate", 'GenerateBannercode', "admin-generate.php", false, ""));
            }
            $oMenu->addTo("inventory", new OA_Admin_Menu_Section("agency-access", 'UserAccess', "agency-access.php?agencyid={agencyid}", false, "", array(array(OA_ACCOUNT_MANAGER => OA_PERM_SUPER_ACCOUNT))));
                $oMenu->addTo("agency-access", new OA_Admin_Menu_Section("agency-user", 'UserProperties', "agency-user.php?userid={userid}&agencyid={agencyid}", false, ""));

            $oMenu->add(new OA_Admin_Menu_Section("account-index", 'Preferences', "account-index.php", false, "settings"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-user-index", 'UserPreferences', "account-user-index.php", false, ""));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-preferences-index", 'AccountPreferences', "account-preferences-index.php", false, "settings/preferences"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("userlog-index", 'UserLog', "userlog-index.php", false, "settings/userLog"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("channel-index", 'ChannelManagement', "channel-index.php", false, "settings/channelManagement"));
                    $oMenu->addTo("channel-index", new OA_Admin_Menu_Section("channel-edit_new", 'AddNewChannel', "channel-edit.php?agencyid={agencyid}", true, "settings/channelManagement/addChannel"));
                    $oMenu->addTo("channel-index", new OA_Admin_Menu_Section("channel-edit", 'ChannelProperties', "channel-edit.php?agencyid={agencyid}&channelid={channelid}", false, "settings/channelManagement/editChannel"));
                    $oMenu->addTo("channel-index", new OA_Admin_Menu_Section("channel-acl", 'ChannelLimitations', "channel-acl.php?agencyid={agencyid}&channelid={channelid}", false, "settings/channelManagement/editChannel/deliveryOptions"));
            break;
        case OA_ACCOUNT_TRAFFICKER:
            // Note: The stats screens haven't been updated to use the new menuing names...
            $oMenu->add(new OA_Admin_Menu_Section("1", 'Stats', "stats.php?entity=affiliate&breakdown=history&affiliateid={affiliateid}", false, "statistics/publisherHistory"));
                $oMenu->addTo("1", new OA_Admin_Menu_Section("1.1", 'AffiliateHistory', "stats.php?entity=affiliate&breakdown=history&affiliateid={affiliateid}", false, "statistics/publisherHistory"));
                $oMenu->addTo("1.1", new OA_Admin_Menu_Section("1.1.1", 'DailyStats', "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&day={day}", false, "statistics/publisherHistory/daily"));
                $oMenu->addTo("1", new OA_Admin_Menu_Section("1.2", 'Zones', "stats.php?entity=affiliate&breakdown=zones&affiliateid={affiliateid}", false, "statistics/zoneOverview"));
                $oMenu->addTo("1.2", new OA_Admin_Menu_Section("1.2.1", 'ZoneHistory', "stats.php?entity=zone&breakdown=history&affiliateid={affiliateid}&zoneid={zoneid}", false, "statistics/zoneHistory"));
                $oMenu->addTo("1.2.1", new OA_Admin_Menu_Section("1.2.1.1", 'DailyStats', "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&day={day}", false, "statistics/zoneHistory"));
                $oMenu->addTo("1.2", new OA_Admin_Menu_Section("1.2.2", 'CampaignDistribution', "stats.php?entity=zone&breakdown=campaigns&affiliateid={affiliateid}&zoneid={zoneid}", false, "statistics/zoneHistory/daily"));
                $oMenu->addTo("1.2.2", new OA_Admin_Menu_Section("1.2.2.1", 'DistributionHistoryCampaign', "stats.php?entity=zone&breakdown=campaign-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}", true, "statistics/campaignDistribution"));
                $oMenu->addTo("1.2.2.1", new OA_Admin_Menu_Section("1.2.2.1.1", 'DailyStats', "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&day={day}", false, "statistics/campaignDistribution/history"));
                $oMenu->addTo("1.2.2", new OA_Admin_Menu_Section("1.2.2.2", 'DistributionHistoryBanner', "stats.php?entity=zone&breakdown=banner-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}", true, "statistics/campaignDistribution/history/daily"));
                $oMenu->addTo("1.2.2.2", new OA_Admin_Menu_Section("1.2.2.2.1", 'DailyStats', "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}&day={day}"));
                $oMenu->addTo("1", new OA_Admin_Menu_Section("1.3", 'CampaignDistribution', "stats.php?entity=affiliate&breakdown=campaigns&affiliateid={affiliateid}", false, "statistics/campaignDistribution"));
                $oMenu->addTo("1.3", new OA_Admin_Menu_Section("1.3.1", 'DistributionHistoryCampaign', "stats.php?entity=affiliate&breakdown=campaign-history&affiliateid={affiliateid}&campaignid={campaignid}", true, "statistics/campaignDistribution/history"));
                $oMenu->addTo("1.3.1", new OA_Admin_Menu_Section("1.3.1.1", 'DailyStats', "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&day={day}", false, "statistics/campaignDistribution/history/daily"));
                $oMenu->addTo("1.3", new OA_Admin_Menu_Section("1.3.2", 'DistributionHistoryBanner', "stats.php?entity=affiliate&breakdown=banner-history&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}", true));
                $oMenu->addTo("1.3.2", new OA_Admin_Menu_Section("1.3.2.1", 'DailyStats', "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}&day={day}", true));
                $oMenu->addTo("1", new OA_Admin_Menu_Section("report-index", 'AdvancedReports', "report-index.php?affiliateid={affiliateid}", false, "reports"));

            $oMenu->add(new OA_Admin_Menu_Section("inventory", 'Adminstration', "affiliate-zones.php?affiliateid={affiliateid}", false, "inventory/publishersAndZones/zones"));
                $oMenu->addTo("inventory", new OA_Admin_Menu_Section("affiliate-zones", 'Zones', "affiliate-zones.php?affiliateid={affiliateid}", false, "inventory/publishersAndZones/zones"));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-edit_new', 'AddNewZone', 'zone-edit.php?affiliateid={affiliateid}', true, "inventory/publishersAndZones/zones/addZone", array(array(OA_ACCOUNT_TRAFFICKER => OA_PERM_ZONE_ADD))));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-edit', 'ZoneProperties', 'zone-edit.php?affiliateid={affiliateid}&zoneid={zoneid}', false, "inventory/publishersAndZones/zones/editZone", array(array(OA_ACCOUNT_TRAFFICKER => OA_PERM_ZONE_EDIT))));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-include', 'IncludedBanners', 'zone-include.php?affiliateid={affiliateid}&zoneid={zoneid}', false, "inventory/publishersAndZones/zones/editZone/linkedBanners", array(array(OA_ACCOUNT_TRAFFICKER => OA_PERM_ZONE_LINK))));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-probability', 'Probability', 'zone-probability.php?affiliateid={affiliateid}&zoneid={zoneid}', false, "inventory/publishersAndZones/zones/editZone/linkedBanners/probability"));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-invocation', 'Invocationcode', 'zone-invocation.php?affiliateid={affiliateid}&zoneid={zoneid}', false, "inventory/publishersAndZones/zones/editZone/linkedBanners/invocationCode", array(array(OA_ACCOUNT_TRAFFICKER => OA_PERM_ZONE_INVOCATION))));
                $oMenu->addTo('inventory', new OA_Admin_Menu_Section('affiliate-invocation', 'Invocationcode', 'affiliate-invocation.php?affiliateid={affiliateid}', false, "inventory/affiliateInvocation", array(array(OA_ACCOUNT_TRAFFICKER => OA_PERM_ZONE_INVOCATION))));
                    $oMenu->addTo('affiliate-invocation', new OA_Admin_Menu_Section('affiliate-preview', 'InvocationcodePreview', 'affiliate-preview.php', false, "", array(array(OA_ACCOUNT_TRAFFICKER => OA_PERM_ZONE_INVOCATION))));
                $oMenu->addTo('inventory', new OA_Admin_Menu_Section('affiliate-access', 'UserAccess', 'affiliate-access.php?affiliateid={affiliateid}', false, "", array(array(OA_ACCOUNT_TRAFFICKER => OA_PERM_SUPER_ACCOUNT))));
            $oMenu->add(new OA_Admin_Menu_Section("account-index", 'Preferences', "account-index.php", false, "settings"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-user-index", 'UserPreferences', "account-user-index.php", false, "settings/preferences"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-preferences-index", 'AccountPreferences', "account-preferences-index.php", false, "settings/preferences"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("userlog-index", 'UserLog', "userlog-index.php", false, "settings/userLog", array(array(OA_ACCOUNT_TRAFFICKER => OA_PERM_USER_LOG_ACCESS))));
        break;
        case OA_ACCOUNT_ADVERTISER:
            // Note: The stats screens haven't been updated to use the new menuing names...
            $oMenu->add(new OA_Admin_Menu_Section("1", 'Stats', "stats.php?entity=advertiser&breakdown=history&clientid={clientid}", false, "statistics/advertiserHistory"));
            $oMenu->addTo("1", new OA_Admin_Menu_Section("1.1", 'ClientHistory', "stats.php?entity=advertiser&breakdown=history&clientid={clientid}", false, "statistics/advertiserHistory"));
            $oMenu->addTo("1.1", new OA_Admin_Menu_Section("1.1.1", 'DailyStats', "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&day={day}", false, "statistics/advertiserHistory/daily"));
            $oMenu->addTo("1", new OA_Admin_Menu_Section("1.2", 'Campaigns', "stats.php?entity=advertiser&breakdown=campaigns&clientid={clientid}", false, "statistics/campaignOverview"));
            $oMenu->addTo("1.2", new OA_Admin_Menu_Section("1.2.1", 'CampaignHistory', "stats.php?entity=campaign&breakdown=history&clientid={clientid}&campaignid={campaignid}", false, "statistics/campaignHistory"));
            $oMenu->addTo("1.2.1", new OA_Admin_Menu_Section("1.2.1.1", 'DailyStats', "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&day={day}", false, "statistics/campaignHistory/daily"));
            $oMenu->addTo("1.2", new OA_Admin_Menu_Section("1.2.2", 'Banners', "stats.php?entity=campaign&breakdown=banners&clientid={clientid}&campaignid={campaignid}", false, "statistics/bannerOverview"));
            $oMenu->addTo("1.2.2", new OA_Admin_Menu_Section("1.2.2.1", 'BannerHistory', "stats.php?entity=banner&breakdown=history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "statistics/bannerHistory"));
            $oMenu->addTo("1.2.2.1", new OA_Admin_Menu_Section("1.2.2.1.1", 'DailyStats', "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&day={day}", false, "statistics/bannerHistory/daily"));
            $oMenu->addTo("1.2.2", new OA_Admin_Menu_Section("1.2.2.4", 'PublisherDistribution', "stats.php?entity=banner&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "statistics/publisherDistribution"));
            $oMenu->addTo("1.2.2.4", new OA_Admin_Menu_Section("1.2.2.4.1", 'DistributionHistoryWebsite', "stats.php?entity=banner&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}", true, "statistics/publisherDistribution/history"));
            $oMenu->addTo("1.2.2.4.1", new OA_Admin_Menu_Section("1.2.2.4.1.1", 'DailyStats', "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&day={day}", false, "statistics/publisherDistribution/history/daily"));
            $oMenu->addTo("1.2.2.4", new OA_Admin_Menu_Section("1.2.2.4.2", 'DistributionHistoryZone', "stats.php?entity=banner&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}", true));
            $oMenu->addTo("1.2.2.4.2", new OA_Admin_Menu_Section("1.2.2.4.2.1", 'DailyStats', "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
            $oMenu->addTo("1.2", new OA_Admin_Menu_Section("1.2.3", 'PublisherDistribution', "stats.php?entity=campaign&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}", false, "statistics/publisherDistribution"));
            $oMenu->addTo("1.2.3", new OA_Admin_Menu_Section("1.2.3.1", 'DistributionHistoryWebsite', "stats.php?entity=campaign&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}", true, "statistics/publisherDistribution/history"));
            $oMenu->addTo("1.2.3.1", new OA_Admin_Menu_Section("1.2.3.1.1", 'DailyStats', "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&day={day}", false, "statistics/publisherDistribution/history/daily"));
            $oMenu->addTo("1.2.3", new OA_Admin_Menu_Section("1.2.3.2", 'DistributionHistoryZone', "stats.php?entity=campaign&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}", true));
            $oMenu->addTo("1.2.3.2", new OA_Admin_Menu_Section("1.2.3.2.1", 'DailyStats', "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
            $oMenu->addTo("1", new OA_Admin_Menu_Section("1.3", 'PublisherDistribution', "stats.php?entity=advertiser&breakdown=affiliates&clientid={clientid}", false, "statistics/publisherDistribution"));
            $oMenu->addTo("1.3", new OA_Admin_Menu_Section("1.3.1", 'DistributionHistoryWebsite', "stats.php?entity=advertiser&breakdown=affiliate-history&clientid={clientid}&affiliateid={affiliateid}", true, "statistics/publisherDistribution/hisotry"));
            $oMenu->addTo("1.3.1", new OA_Admin_Menu_Section("1.3.1.1", 'DailyStats', "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&day={day}", false, "statistics/publisherDistribution/history/daily"));
            $oMenu->addTo("1.3", new OA_Admin_Menu_Section("1.3.2", 'DistributionHistoryZone', "stats.php?entity=advertiser&breakdown=zone-history&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}", true));
            $oMenu->addTo("1.3.2", new OA_Admin_Menu_Section("1.3.2.1", 'DailyStats', "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
            $oMenu->addTo("1", new OA_Admin_Menu_Section("report-index", 'AdvancedReports', "report-index.php?clientid={clientid}", false, "reports"));

            $oMenu->add(new OA_Admin_Menu_Section("inventory", 'Adminstration', "advertiser-campaigns.php?clientid={clientid}", false, "inventory/advertisersAndCampaigns/campaigns"));
                $oMenu->addTo("inventory", new OA_Admin_Menu_Section("advertiser-campaigns", 'Campaigns', "advertiser-campaigns.php?clientid={clientid}", false, "inventory/advertisersAndCampaigns/campaigns"));
                    $oMenu->addTo("advertiser-campaigns", new OA_Admin_Menu_Section("campaign-banners", 'Banners', "campaign-banners.php?clientid={clientid}&campaignid={campaignid}", false, "inventory/advertisersAndCampaigns/campaigns/banners"));
                        $oMenu->addTo("campaign-banners", new OA_Admin_Menu_Section("banner-edit", 'BannerProperties', "banner-edit.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}", false, "inventory/advertisersAndCampaigns/campaigns/editBanner", array(array(OA_ACCOUNT_ADVERTISER => OA_PERM_BANNER_EDIT))));
                $oMenu->addTo("inventory", new OA_Admin_Menu_Section("advertiser-access", 'UserAccess', "advertiser-access.php?clientid={clientid}", false, "", array(array(OA_ACCOUNT_ADVERTISER => OA_PERM_SUPER_ACCOUNT))));
                    $oMenu->addTo("advertiser-access", new OA_Admin_Menu_Section("advertiser-user", 'UserProperties', "advertiser-user.php?userid={userid}&clientid={clientid}", false, "", array(array(OA_ACCOUNT_ADVERTISER => OA_PERM_SUPER_ACCOUNT))));

            $oMenu->add(new OA_Admin_Menu_Section("account-index", 'Preferences', "account-index.php", false, "settings"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-user-index", 'UserPreferences', "account-user-index.php", false, ""));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-preferences-index", 'AccountPreferences', "account-preferences-index.php", false, "settings/prefrences"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("userlog-index", 'UserLog', "userlog-index.php", false, "settings/userLog", array(array(OA_ACCOUNT_ADVERTISER => OA_PERM_USER_LOG_ACCESS))));
        break;
        default:
            // If the user is not logged in then $accountType will be null
    }

    $GLOBALS['_MAX']['MENU_OBJECT'][$accountType] = &$oMenu;
    return $oMenu;
}

?>
