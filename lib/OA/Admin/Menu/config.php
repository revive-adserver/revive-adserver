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
            $oMenu->add(new OA_Admin_Menu_Section("dashboard", $GLOBALS['strHome'], "dashboard.php"));

            // Note: The stats screens haven't been updated to use the new menuing names...
            $oMenu->add(new OA_Admin_Menu_Section("2", $GLOBALS['strStats'], "stats.php"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("2.1", $GLOBALS['strClientsAndCampaigns'], "stats.php?1=1"));
                $oMenu->addTo("2.1", new OA_Admin_Menu_Section("2.1.1", $GLOBALS['strClientHistory'], "stats.php?entity=advertiser&breakdown=history&clientid={clientid}"));
                $oMenu->addTo("2.1.1", new OA_Admin_Menu_Section("2.1.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&day={day}"));
                $oMenu->addTo("2.1", new OA_Admin_Menu_Section("2.1.2", $GLOBALS['strCampaigns'], "stats.php?entity=advertiser&breakdown=campaigns&clientid={clientid}"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.1", $GLOBALS['strCampaignHistory'], "stats.php?entity=campaign&breakdown=history&clientid={clientid}&campaignid={campaignid}"));
                $oMenu->addTo("2.1.2.1", new OA_Admin_Menu_Section("2.1.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&day={day}"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.2", $GLOBALS['strBanners'], "stats.php?entity=campaign&breakdown=banners&clientid={clientid}&campaignid={campaignid}"));
                $oMenu->addTo("2.1.2.2", new OA_Admin_Menu_Section("2.1.2.2.1", $GLOBALS['strBannerHistory'], "stats.php?entity=banner&breakdown=history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}"));
                $oMenu->addTo("2.1.2.2.1", new OA_Admin_Menu_Section("2.1.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&day={day}"));
                $oMenu->addTo("2.1.2.2", new OA_Admin_Menu_Section("2.1.2.2.2", $GLOBALS['strPublisherDistribution'], "stats.php?entity=banner&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}"));
                $oMenu->addTo("2.1.2.2.2", new OA_Admin_Menu_Section("2.1.2.2.2.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=banner&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}"));
                $oMenu->addTo("2.1.2.2.2.1", new OA_Admin_Menu_Section("2.1.2.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&day={day}"));
                $oMenu->addTo("2.1.2.2.2", new OA_Admin_Menu_Section("2.1.2.2.2.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=banner&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}"));
                $oMenu->addTo("2.1.2.2.2.2", new OA_Admin_Menu_Section("2.1.2.2.2.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("2.1.2.2", new OA_Admin_Menu_Section("2.1.2.2.3", $GLOBALS['strTargetStats'], "stats.php?entity=banner&breakdown=targeting&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}"));
                $oMenu->addTo("2.1.2.2.3", new OA_Admin_Menu_Section("2.1.2.2.3.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=targeting-daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.3", $GLOBALS['strPublisherDistribution'], "stats.php?entity=campaign&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}"));
                $oMenu->addTo("2.1.2.3", new OA_Admin_Menu_Section("2.1.2.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=campaign&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}"));
                $oMenu->addTo("2.1.2.3.1", new OA_Admin_Menu_Section("2.1.2.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&day={day}"));
                $oMenu->addTo("2.1.2.3", new OA_Admin_Menu_Section("2.1.2.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=campaign&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}"));
                $oMenu->addTo("2.1.2.3.2", new OA_Admin_Menu_Section("2.1.2.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.4", $GLOBALS['strTargetStats'], "stats.php?entity=campaign&breakdown=targeting&clientid={clientid}&campaignid={campaignid}"));
                $oMenu->addTo("2.1.2.4", new OA_Admin_Menu_Section("2.1.2.4.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=targeting-daily&clientid={clientid}&campaignid={campaignid}"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.5", $GLOBALS['strOptimise'], "stats.php?entity=campaign&breakdown=optimise&clientid={clientid}&campaignid={campaignid}"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.6", $GLOBALS['strKeywordStatistics'], "stats.php?entity=campaign&breakdown=keywords&clientid={clientid}&campaignid={campaignid}"));
                $oMenu->addTo("2.1", new OA_Admin_Menu_Section("2.1.3", $GLOBALS['strPublisherDistribution'], "stats.php?entity=advertiser&breakdown=affiliates&clientid={clientid}"));
                $oMenu->addTo("2.1.3", new OA_Admin_Menu_Section("2.1.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=advertiser&breakdown=affiliate-history&clientid={clientid}&affiliateid={affiliateid}"));
                $oMenu->addTo("2.1.3.1", new OA_Admin_Menu_Section("2.1.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&day={day}"));
                $oMenu->addTo("2.1.3", new OA_Admin_Menu_Section("2.1.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=advertiser&breakdown=zone-history&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}"));
                $oMenu->addTo("2.1.3.2", new OA_Admin_Menu_Section("2.1.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("2.4", $GLOBALS['strAffiliatesAndZones'], "stats.php?entity=global&breakdown=affiliates"));
                $oMenu->addTo("2.4", new OA_Admin_Menu_Section("2.4.1", $GLOBALS['strAffiliateHistory'], "stats.php?entity=affiliate&breakdown=history&affiliateid={affiliateid}"));
                $oMenu->addTo("2.4.1", new OA_Admin_Menu_Section("2.4.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&day={day}"));
                $oMenu->addTo("2.4", new OA_Admin_Menu_Section("2.4.2", $GLOBALS['strZones'], "stats.php?entity=affiliate&breakdown=zones&affiliateid={affiliateid}"));
                $oMenu->addTo("2.4.2", new OA_Admin_Menu_Section("2.4.2.1", $GLOBALS['strZoneHistory'], "stats.php?entity=zone&breakdown=history&affiliateid={affiliateid}&zoneid={zoneid}"));
                $oMenu->addTo("2.4.2.1", new OA_Admin_Menu_Section("2.4.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("2.4.2", new OA_Admin_Menu_Section("2.4.2.2", $GLOBALS['strCampaignDistribution'], "stats.php?entity=zone&breakdown=campaigns&affiliateid={affiliateid}&zoneid={zoneid}"));
                $oMenu->addTo("2.4.2.2", new OA_Admin_Menu_Section("2.4.2.2.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=zone&breakdown=campaign-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}"));
                $oMenu->addTo("2.4.2.2.1", new OA_Admin_Menu_Section("2.4.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&day={day}"));
                $oMenu->addTo("2.4.2.2", new OA_Admin_Menu_Section("2.4.2.2.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=zone&breakdown=banner-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}"));
                $oMenu->addTo("2.4.2.2.2", new OA_Admin_Menu_Section("2.4.2.2.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}&day={day}"));
                $oMenu->addTo("2.4", new OA_Admin_Menu_Section("2.4.3", $GLOBALS['strCampaignDistribution'], "stats.php?entity=affiliate&breakdown=campaigns&affiliateid={affiliateid}"));
                $oMenu->addTo("2.4.3", new OA_Admin_Menu_Section("2.4.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=affiliate&breakdown=campaign-history&affiliateid={affiliateid}&campaignid={campaignid}"));
                $oMenu->addTo("2.4.3.1", new OA_Admin_Menu_Section("2.4.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&day={day}"));
                $oMenu->addTo("2.4.3", new OA_Admin_Menu_Section("2.4.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=affiliate&breakdown=banner-history&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}"));
                $oMenu->addTo("2.4.3.2", new OA_Admin_Menu_Section("2.4.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}&day={day}"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("2.2", $GLOBALS['strGlobalHistory'], "stats.php?entity=global&breakdown=history"));
                $oMenu->addTo("2.2", new OA_Admin_Menu_Section("2.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=global&breakdown=daily&day={day}"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("report-index", $GLOBALS['strAdvancedReports'], "report-index.php"));

            $oMenu->add(new OA_Admin_Menu_Section("inventory", $GLOBALS['strAdminstration'], "agency-index.php"));
                $oMenu->addTo("inventory", new OA_Admin_Menu_Section("agency-index", $GLOBALS['strAgencyManagement'], "agency-index.php"));
                    $oMenu->addTo("agency-index", new OA_Admin_Menu_Section("agency-edit_new", $GLOBALS['strAddAgency'], "agency-index.php", true));
                    $oMenu->addTo("agency-index", new OA_Admin_Menu_Section("agency-edit", $GLOBALS['strAgencyProperties'], "agency-edit.php?agencyid={agencyid}"));
                    $oMenu->addTo("agency-index", new OA_Admin_Menu_Section("agency-access", $GLOBALS['strUserAccess'], "agency-access.php?agencyid={agencyid}"));
                $oMenu->addTo("inventory", new OA_Admin_Menu_Section("admin-generate", $GLOBALS['strGenerateBannercode'], "admin-generate.php"));
                $oMenu->addTo("inventory", new OA_Admin_Menu_Section("admin-access", $GLOBALS['strAdminAccess'], "admin-access.php"));

            $oMenu->add(new OA_Admin_Menu_Section("account-index", $GLOBALS['strMyAccount'], "account-index.php"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-user-index", $GLOBALS['strUserPreferences'], "account-user-index.php"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-preferences-index", $GLOBALS['strPreferences'], "account-preferences-index.php"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("userlog-index", $GLOBALS['strUserLog'], "userlog-index.php"));
                
            $oMenu->add(new OA_Admin_Menu_Section("configuration", $GLOBALS['strConfiguration'], "account-settings-index.php"));
                $oMenu->addTo("configuration", new OA_Admin_Menu_Section("account-settings-index", $GLOBALS['strGlobalSettings'], "account-settings-index.php"));
                $oMenu->addTo("configuration", new OA_Admin_Menu_Section("maintenance-index", $GLOBALS['strMaintenance'], "maintenance-index.php"));
                $oMenu->addTo("configuration", new OA_Admin_Menu_Section("updates-index", $GLOBALS['strProductUpdates'], "updates-product.php"));
                
        break;
        case OA_ACCOUNT_MANAGER:
            $oMenu->add(new OA_Admin_Menu_Section("dashboard", $GLOBALS['strHome'], "dashboard.php"));

            // Note: The stats screens haven't been updated to use the new menuing names...
            $oMenu->add(new OA_Admin_Menu_Section("2", $GLOBALS['strStats'], "stats.php"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("2.1", $GLOBALS['strClientsAndCampaigns'], "stats.php?1=1"));
                $oMenu->addTo("2.1", new OA_Admin_Menu_Section("2.1.1", $GLOBALS['strClientHistory'], "stats.php?entity=advertiser&breakdown=history&clientid={clientid}"));
                $oMenu->addTo("2.1.1", new OA_Admin_Menu_Section("2.1.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&day={day}"));
                $oMenu->addTo("2.1", new OA_Admin_Menu_Section("2.1.2", $GLOBALS['strCampaigns'], "stats.php?entity=advertiser&breakdown=campaigns&clientid={clientid}"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.1", $GLOBALS['strCampaignHistory'], "stats.php?entity=campaign&breakdown=history&clientid={clientid}&campaignid={campaignid}"));
                $oMenu->addTo("2.1.2.1", new OA_Admin_Menu_Section("2.1.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&day={day}"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.2", $GLOBALS['strBanners'], "stats.php?entity=campaign&breakdown=banners&clientid={clientid}&campaignid={campaignid}"));
                $oMenu->addTo("2.1.2.2", new OA_Admin_Menu_Section("2.1.2.2.1", $GLOBALS['strBannerHistory'], "stats.php?entity=banner&breakdown=history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}"));
                $oMenu->addTo("2.1.2.2.1", new OA_Admin_Menu_Section("2.1.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&day={day}"));
                $oMenu->addTo("2.1.2.2", new OA_Admin_Menu_Section("2.1.2.2.2", $GLOBALS['strPublisherDistribution'], "stats.php?entity=banner&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}"));
                $oMenu->addTo("2.1.2.2.2", new OA_Admin_Menu_Section("2.1.2.2.2.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=banner&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}"));
                $oMenu->addTo("2.1.2.2.2.1", new OA_Admin_Menu_Section("2.1.2.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&day={day}"));
                $oMenu->addTo("2.1.2.2.2", new OA_Admin_Menu_Section("2.1.2.2.2.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=banner&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}"));
                $oMenu->addTo("2.1.2.2.2.2", new OA_Admin_Menu_Section("2.1.2.2.2.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("2.1.2.2", new OA_Admin_Menu_Section("2.1.2.2.3", $GLOBALS['strTargetStats'], "stats.php?entity=banner&breakdown=targeting&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}"));
                $oMenu->addTo("2.1.2.2.3", new OA_Admin_Menu_Section("2.1.2.2.3.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=targeting-daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.3", $GLOBALS['strPublisherDistribution'], "stats.php?entity=campaign&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}"));
                $oMenu->addTo("2.1.2.3", new OA_Admin_Menu_Section("2.1.2.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=campaign&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}"));
                $oMenu->addTo("2.1.2.3.1", new OA_Admin_Menu_Section("2.1.2.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&day={day}"));
                $oMenu->addTo("2.1.2.3", new OA_Admin_Menu_Section("2.1.2.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=campaign&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}"));
                $oMenu->addTo("2.1.2.3.2", new OA_Admin_Menu_Section("2.1.2.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.4", $GLOBALS['strTargetStats'], "stats.php?entity=campaign&breakdown=targeting&clientid={clientid}&campaignid={campaignid}"));
                $oMenu->addTo("2.1.2.4", new OA_Admin_Menu_Section("2.1.2.4.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=targeting-daily&clientid={clientid}&campaignid={campaignid}"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.5", $GLOBALS['strOptimise'], "stats.php?entity=campaign&breakdown=optimise&clientid={clientid}&campaignid={campaignid}"));
                $oMenu->addTo("2.1.2", new OA_Admin_Menu_Section("2.1.2.6", $GLOBALS['strKeywordStatistics'], "stats.php?entity=campaign&breakdown=keywords&clientid={clientid}&campaignid={campaignid}"));
                $oMenu->addTo("2.1", new OA_Admin_Menu_Section("2.1.3", $GLOBALS['strPublisherDistribution'], "stats.php?entity=advertiser&breakdown=affiliates&clientid={clientid}"));
                $oMenu->addTo("2.1.3", new OA_Admin_Menu_Section("2.1.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=advertiser&breakdown=affiliate-history&clientid={clientid}&affiliateid={affiliateid}"));
                $oMenu->addTo("2.1.3.1", new OA_Admin_Menu_Section("2.1.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&day={day}"));
                $oMenu->addTo("2.1.3", new OA_Admin_Menu_Section("2.1.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=advertiser&breakdown=zone-history&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}"));
                $oMenu->addTo("2.1.3.2", new OA_Admin_Menu_Section("2.1.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("2.2", $GLOBALS['strGlobalHistory'], "stats.php?entity=global&breakdown=history"));
                $oMenu->addTo("2.2", new OA_Admin_Menu_Section("2.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=global&breakdown=daily&day={day}"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("2.4", $GLOBALS['strAffiliatesAndZones'], "stats.php?entity=global&breakdown=affiliates"));
                $oMenu->addTo("2.4", new OA_Admin_Menu_Section("2.4.1", $GLOBALS['strAffiliateHistory'], "stats.php?entity=affiliate&breakdown=history&affiliateid={affiliateid}"));
                $oMenu->addTo("2.4.1", new OA_Admin_Menu_Section("2.4.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&day={day}"));
                $oMenu->addTo("2.4", new OA_Admin_Menu_Section("2.4.2", $GLOBALS['strZones'], "stats.php?entity=affiliate&breakdown=zones&affiliateid={affiliateid}"));
                $oMenu->addTo("2.4.2", new OA_Admin_Menu_Section("2.4.2.1", $GLOBALS['strZoneHistory'], "stats.php?entity=zone&breakdown=history&affiliateid={affiliateid}&zoneid={zoneid}"));
                $oMenu->addTo("2.4.2.1", new OA_Admin_Menu_Section("2.4.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("2.4.2", new OA_Admin_Menu_Section("2.4.2.2", $GLOBALS['strCampaignDistribution'], "stats.php?entity=zone&breakdown=campaigns&affiliateid={affiliateid}&zoneid={zoneid}"));
                $oMenu->addTo("2.4.2.2", new OA_Admin_Menu_Section("2.4.2.2.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=zone&breakdown=campaign-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}"));
                $oMenu->addTo("2.4.2.2.1", new OA_Admin_Menu_Section("2.4.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&day={day}"));
                $oMenu->addTo("2.4.2.2", new OA_Admin_Menu_Section("2.4.2.2.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=zone&breakdown=banner-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}"));
                $oMenu->addTo("2.4.2.2.2", new OA_Admin_Menu_Section("2.4.2.2.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}&day={day}"));
                $oMenu->addTo("2.4", new OA_Admin_Menu_Section("2.4.3", $GLOBALS['strCampaignDistribution'], "stats.php?entity=affiliate&breakdown=campaigns&affiliateid={affiliateid}"));
                $oMenu->addTo("2.4.3", new OA_Admin_Menu_Section("2.4.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=affiliate&breakdown=campaign-history&affiliateid={affiliateid}&campaignid={campaignid}"));
                $oMenu->addTo("2.4.3.1", new OA_Admin_Menu_Section("2.4.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&day={day}"));
                $oMenu->addTo("2.4.3", new OA_Admin_Menu_Section("2.4.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=affiliate&breakdown=banner-history&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}"));
                $oMenu->addTo("2.4.3.2", new OA_Admin_Menu_Section("2.4.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}&day={day}"));
                $oMenu->addTo("2", new OA_Admin_Menu_Section("report-index", $GLOBALS['strAdvancedReports'], "report-index.php"));
            
            $oMenu->add(new OA_Admin_Menu_Section("inventory", $GLOBALS['strAdminstration'], "advertiser-index.php"));

            $oMenu->addTo("inventory", new OA_Admin_Menu_Section("advertiser-index", $GLOBALS['strClientsAndCampaigns'], "advertiser-index.php"));
                $oMenu->addTo("advertiser-index", new OA_Admin_Menu_Section("advertiser-edit_new", $GLOBALS['strAddClient'], "advertiser-edit.php", true));
                $oMenu->addTo("advertiser-index", new OA_Admin_Menu_Section("advertiser-edit", $GLOBALS['strClientProperties'], "advertiser-edit.php?clientid={clientid}"));
                $oMenu->addTo("advertiser-index", new OA_Admin_Menu_Section("advertiser-campaigns", $GLOBALS['strCampaigns'], "advertiser-campaigns.php?clientid={clientid}"));
                    $oMenu->addTo("advertiser-campaigns", new OA_Admin_Menu_Section("campaign-edit_new", $GLOBALS['strAddCampaign'], "campaign-edit.php?clientid={clientid}", true));
                    $oMenu->addTo("advertiser-campaigns", new OA_Admin_Menu_Section("campaign-edit", $GLOBALS['strCampaignProperties'], "campaign-edit.php?clientid={clientid}&campaignid={campaignid}"));
                    $oMenu->addTo("advertiser-campaigns", new OA_Admin_Menu_Section("campaign-zone", $GLOBALS['strLinkedZones'], "campaign-zone.php?clientid={clientid}&campaignid={campaignid}"));
                    $oMenu->addTo("advertiser-campaigns", new OA_Admin_Menu_Section("campaign-banners", $GLOBALS['strBanners'], "campaign-banners.php?clientid={clientid}&campaignid={campaignid}"));
                        $oMenu->addTo("campaign-banners", new OA_Admin_Menu_Section("banner-edit_new", $GLOBALS['strAddBanner'], "banner-edit.php?clientid={clientid}&campaignid={campaignid}", true));
                        $oMenu->addTo("campaign-banners", new OA_Admin_Menu_Section("banner-edit", $GLOBALS['strBannerProperties'], "banner-edit.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}"));
                        $oMenu->addTo("campaign-banners", new OA_Admin_Menu_Section("banner-acl", $GLOBALS['strModifyBannerAcl'], "banner-acl.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}"));
                        $oMenu->addTo("campaign-banners", new OA_Admin_Menu_Section("banner-zone", $GLOBALS['strLinkedZones'], "banner-zone.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}"));
                        $oMenu->addTo("campaign-banners", new OA_Admin_Menu_Section("banner-advanced", $GLOBALS['strAdvanced'], "banner-advanced.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}"));
                if ($aConf['logging']['trackerImpressions']) {
                    $oMenu->addTo("advertiser-campaigns", new OA_Admin_Menu_Section("campaign-trackers", $GLOBALS['strLinkedTrackers'], "campaign-trackers.php?clientid={clientid}&campaignid={campaignid}"));
                        $oMenu->addTo("advertiser-index", new OA_Admin_Menu_Section("advertiser-trackers", $GLOBALS['strTrackers'], "advertiser-trackers.php?clientid={clientid}"));
                            $oMenu->addTo("advertiser-trackers", new OA_Admin_Menu_Section("tracker-edit_new", $GLOBALS['strAddTracker'], "tracker-edit.php?clientid={clientid}", true));
                            $oMenu->addTo("advertiser-trackers", new OA_Admin_Menu_Section("tracker-edit", $GLOBALS['strTrackerProperties'], "tracker-edit.php?clientid={clientid}&trackerid={trackerid}"));
                            $oMenu->addTo("advertiser-trackers", new OA_Admin_Menu_Section("tracker-campaigns", $GLOBALS['strLinkedCampaigns'], "tracker-campaigns.php?clientid={clientid}&trackerid={trackerid}"));
                            $oMenu->addTo("advertiser-trackers", new OA_Admin_Menu_Section("tracker-variables", $GLOBALS['strVariables'], "tracker-variables.php?clientid={clientid}&trackerid={trackerid}"));
                            $oMenu->addTo("advertiser-trackers", new OA_Admin_Menu_Section("tracker-append", $GLOBALS['strAppendTrackerCode'], "tracker-append.php?clientid={clientid}&trackerid={trackerid}"));
                            $oMenu->addTo("advertiser-trackers", new OA_Admin_Menu_Section("tracker-invocation", $GLOBALS['strInvocationcode'], "tracker-invocation.php?clientid={clientid}&trackerid={trackerid}"));
                }
                $oMenu->addTo("advertiser-index", new OA_Admin_Menu_Section("advertiser-access", $GLOBALS['strUserAccess'], "advertiser-access.php?clientid={clientid}"));

            $oMenu->addTo("inventory", new OA_Admin_Menu_Section("affiliate-index", $GLOBALS['strAffiliatesAndZones'], "affiliate-index.php"));
                $oMenu->addTo("affiliate-index", new OA_Admin_Menu_Section("affiliate-edit_new", $GLOBALS['strAddAffiliate'], "affiliate-edit.php", true));
                $oMenu->addTo("affiliate-index", new OA_Admin_Menu_Section("affiliate-edit", $GLOBALS['strAffiliateProperties'], "affiliate-edit.php?affiliateid={affiliateid}"));
                $oMenu->addTo('affiliate-index', new OA_Admin_Menu_Section('affiliate-zones', $GLOBALS['strZones'], 'affiliate-zones.php?affiliateid={affiliateid}'));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-edit_new', $GLOBALS['strAddNewZone'], 'zone-edit.php?affiliateid={affiliateid}', true));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-edit', $GLOBALS['strZoneProperties'], 'zone-edit.php?affiliateid={affiliateid}&zoneid={zoneid}'));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-advanced', $GLOBALS['strAdvanced'], 'zone-advanced.php?affiliateid={affiliateid}&zoneid={zoneid}'));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-include', $GLOBALS['strIncludedBanners'], 'zone-include.php?affiliateid={affiliateid}&zoneid={zoneid}'));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-probability', $GLOBALS['strProbability'], 'zone-probability.php?affiliateid={affiliateid}&zoneid={zoneid}'));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-invocation', $GLOBALS['strInvocationcode'], 'zone-invocation.php?affiliateid={affiliateid}&zoneid={zoneid}'));
                $oMenu->addTo('affiliate-index', new OA_Admin_Menu_Section('affiliate-channels', $GLOBALS['strChannels'], 'affiliate-channels.php?affiliateid={affiliateid}'));
                    $oMenu->addTo('affiliate-channels', new OA_Admin_Menu_Section('channel-edit-affiliate_new', $GLOBALS['strAddNewChannel'], 'channel-edit.php?affiliateid={affiliateid}', true));
                    $oMenu->addTo('affiliate-channels', new OA_Admin_Menu_Section('channel-edit-affiliate', $GLOBALS['strAddNewChannel'], 'channel-edit.php?affiliateid={affiliateid}&channelid={channelid}', true));
                $oMenu->addTo('affiliate-index', new OA_Admin_Menu_Section('affiliate-invocation', $GLOBALS['strInvocationcode'], 'affiliate-invocation.php?affiliateid={affiliateid}'));
                $oMenu->addTo('affiliate-index', new OA_Admin_Menu_Section('affiliate-access', $GLOBALS['strUserAccess'], 'affiliate-access.php?affiliateid={affiliateid}'));

            $oMenu->addTo("inventory", new OA_Admin_Menu_Section("admin-generate", $GLOBALS['strGenerateBannercode'], "admin-generate.php"));
            $oMenu->addTo("inventory", new OA_Admin_Menu_Section("agency-access", $GLOBALS['strUserAccess'], "agency-access.php?agencyid={agencyid}"));

            $oMenu->add(new OA_Admin_Menu_Section("account-index", $GLOBALS['strMyAccount'], "account-index.php"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-user-index", $GLOBALS['strUserPreferences'], "account-user-index.php"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-preferences-index", $GLOBALS['strPreferences'], "account-preferences-index.php"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("userlog-index", $GLOBALS['strUserLog'], "userlog-index.php"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("channel-index", $GLOBALS['strChannelManagement'], "channel-index.php"));
                    $oMenu->addTo("channel-index", new OA_Admin_Menu_Section("channel-edit_new", $GLOBALS['strAddNewChannel'], "channel-edit.php?agencyid={agencyid}", true));
                    $oMenu->addTo("channel-index", new OA_Admin_Menu_Section("channel-edit", $GLOBALS['strChannelProperties'], "channel-edit.php?agencyid={agencyid}&channelid={channelid}"));
                    $oMenu->addTo("channel-index", new OA_Admin_Menu_Section("channel-acl", $GLOBALS['strModifyBannerAcl'], "channel-acl.php?agencyid={agencyid}&channelid={channelid}"));
            break;
        case OA_ACCOUNT_TRAFFICKER:
            // Note: The stats screens haven't been updated to use the new menuing names...
            $oMenu->add(new OA_Admin_Menu_Section("1", $GLOBALS['strStats'], "stats.php?entity=affiliate&breakdown=history&affiliateid={affiliateid}"));
                $oMenu->addTo("1", new OA_Admin_Menu_Section("1.1", $GLOBALS['strAffiliateHistory'], "stats.php?entity=affiliate&breakdown=history&affiliateid={affiliateid}"));
                $oMenu->addTo("1.1", new OA_Admin_Menu_Section("1.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&day={day}"));
                $oMenu->addTo("1", new OA_Admin_Menu_Section("1.2", $GLOBALS['strZones'], "stats.php?entity=affiliate&breakdown=zones&affiliateid={affiliateid}"));
                $oMenu->addTo("1.2", new OA_Admin_Menu_Section("1.2.1", $GLOBALS['strZoneHistory'], "stats.php?entity=zone&breakdown=history&affiliateid={affiliateid}&zoneid={zoneid}"));
                $oMenu->addTo("1.2.1", new OA_Admin_Menu_Section("1.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
                $oMenu->addTo("1.2", new OA_Admin_Menu_Section("1.2.2", $GLOBALS['strCampaignDistribution'], "stats.php?entity=zone&breakdown=campaigns&affiliateid={affiliateid}&zoneid={zoneid}"));
                $oMenu->addTo("1.2.2", new OA_Admin_Menu_Section("1.2.2.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=zone&breakdown=campaign-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}"));
                $oMenu->addTo("1.2.2.1", new OA_Admin_Menu_Section("1.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&day={day}"));
                $oMenu->addTo("1.2.2", new OA_Admin_Menu_Section("1.2.2.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=zone&breakdown=banner-history&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}"));
                $oMenu->addTo("1.2.2.2", new OA_Admin_Menu_Section("1.2.2.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=zone&breakdown=daily&affiliateid={affiliateid}&zoneid={zoneid}&campaignid={campaignid}&bannerid={bannerid}&day={day}"));
                $oMenu->addTo("1", new OA_Admin_Menu_Section("1.3", $GLOBALS['strCampaignDistribution'], "stats.php?entity=affiliate&breakdown=campaigns&affiliateid={affiliateid}"));
                $oMenu->addTo("1.3", new OA_Admin_Menu_Section("1.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=affiliate&breakdown=campaign-history&affiliateid={affiliateid}&campaignid={campaignid}"));
                $oMenu->addTo("1.3.1", new OA_Admin_Menu_Section("1.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&day={day}"));
                $oMenu->addTo("1.3", new OA_Admin_Menu_Section("1.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=affiliate&breakdown=banner-history&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}"));
                $oMenu->addTo("1.3.2", new OA_Admin_Menu_Section("1.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=affiliate&breakdown=daily&affiliateid={affiliateid}&campaignid={campaignid}&bannerid={bannerid}&day={day}"));
                $oMenu->addTo("1", new OA_Admin_Menu_Section("report-index", $GLOBALS['strAdvancedReports'], "report-index.php?affiliateid={affiliateid}"));

            $oMenu->add(new OA_Admin_Menu_Section("inventory", $GLOBALS['strAdminstration'], "affiliate-zones.php?affiliateid={affiliateid}"));
                $oMenu->addTo("inventory", new OA_Admin_Menu_Section("affiliate-zones", $GLOBALS['strZones'], "affiliate-zones.php?affiliateid={affiliateid}"));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-edit_new', $GLOBALS['strAddNewZone'], 'zone-edit.php?affiliateid={affiliateid}', true));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-edit', $GLOBALS['strZoneProperties'], 'zone-edit.php?affiliateid={affiliateid}&zoneid={zoneid}'));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-include', $GLOBALS['strIncludedBanners'], 'zone-include.php?affiliateid={affiliateid}&zoneid={zoneid}'));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-probability', $GLOBALS['strProbability'], 'zone-probability.php?affiliateid={affiliateid}&zoneid={zoneid}'));
                    $oMenu->addTo('affiliate-zones', new OA_Admin_Menu_Section('zone-invocation', $GLOBALS['strInvocationcode'], 'zone-invocation.php?affiliateid={affiliateid}&zoneid={zoneid}'));
                $oMenu->addTo('inventory', new OA_Admin_Menu_Section('affiliate-invocation', $GLOBALS['strInvocationcode'], 'affiliate-invocation.php?affiliateid={affiliateid}'));
                $oMenu->addTo('inventory', new OA_Admin_Menu_Section('affiliate-access', $GLOBALS['strUserAccess'], 'affiliate-access.php?affiliateid={affiliateid}'));
            $oMenu->add(new OA_Admin_Menu_Section("account-index", $GLOBALS['strMyAccount'], "account-index.php"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-user-index", $GLOBALS['strUserPreferences'], "account-user-index.php"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-preferences-index", $GLOBALS['strPreferences'], "account-preferences-index.php"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("userlog-index", $GLOBALS['strUserLog'], "userlog-index.php"));
        break;
        case OA_ACCOUNT_ADVERTISER:
            // Note: The stats screens haven't been updated to use the new menuing names...
            $oMenu->add(new OA_Admin_Menu_Section("1", $GLOBALS['strStats'], "stats.php?entity=advertiser&breakdown=history&clientid={clientid}"));
            $oMenu->addTo("1", new OA_Admin_Menu_Section("1.1", $GLOBALS['strClientHistory'], "stats.php?entity=advertiser&breakdown=history&clientid={clientid}"));
            $oMenu->addTo("1.1", new OA_Admin_Menu_Section("1.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&day={day}"));
            $oMenu->addTo("1", new OA_Admin_Menu_Section("1.2", $GLOBALS['strCampaigns'], "stats.php?entity=advertiser&breakdown=campaigns&clientid={clientid}"));
            $oMenu->addTo("1.2", new OA_Admin_Menu_Section("1.2.1", $GLOBALS['strCampaignHistory'], "stats.php?entity=campaign&breakdown=history&clientid={clientid}&campaignid={campaignid}"));
            $oMenu->addTo("1.2.1", new OA_Admin_Menu_Section("1.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&day={day}"));
            $oMenu->addTo("1.2", new OA_Admin_Menu_Section("1.2.2", $GLOBALS['strBanners'], "stats.php?entity=campaign&breakdown=banners&clientid={clientid}&campaignid={campaignid}"));
            $oMenu->addTo("1.2.2", new OA_Admin_Menu_Section("1.2.2.1", $GLOBALS['strBannerHistory'], "stats.php?entity=banner&breakdown=history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}"));
            $oMenu->addTo("1.2.2.1", new OA_Admin_Menu_Section("1.2.2.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&day={day}"));
            $oMenu->addTo("1.2.2", new OA_Admin_Menu_Section("1.2.2.2", $GLOBALS['strBannerProperties'], "banner-edit.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}"));
            $oMenu->addTo("1.2.2", new OA_Admin_Menu_Section("1.2.2.3", $GLOBALS['strConvertSWFLinks'], "banner-swf.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}"));
            $oMenu->addTo("1.2.2", new OA_Admin_Menu_Section("1.2.2.4", $GLOBALS['strPublisherDistribution'], "stats.php?entity=banner&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}"));
            $oMenu->addTo("1.2.2.4", new OA_Admin_Menu_Section("1.2.2.4.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=banner&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}"));
            $oMenu->addTo("1.2.2.4.1", new OA_Admin_Menu_Section("1.2.2.4.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&day={day}"));
            $oMenu->addTo("1.2.2.4", new OA_Admin_Menu_Section("1.2.2.4.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=banner&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}"));
            $oMenu->addTo("1.2.2.4.2", new OA_Admin_Menu_Section("1.2.2.4.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=banner&breakdown=daily&clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
            $oMenu->addTo("1.2", new OA_Admin_Menu_Section("1.2.3", $GLOBALS['strPublisherDistribution'], "stats.php?entity=campaign&breakdown=affiliates&clientid={clientid}&campaignid={campaignid}"));
            $oMenu->addTo("1.2.3", new OA_Admin_Menu_Section("1.2.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=campaign&breakdown=affiliate-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}"));
            $oMenu->addTo("1.2.3.1", new OA_Admin_Menu_Section("1.2.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=campaign&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&day={day}"));
            $oMenu->addTo("1.2.3", new OA_Admin_Menu_Section("1.2.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=campaign&breakdown=zone-history&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}"));
            $oMenu->addTo("1.2.3.2", new OA_Admin_Menu_Section("1.2.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&campaignid={campaignid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
            $oMenu->addTo("1", new OA_Admin_Menu_Section("1.3", $GLOBALS['strPublisherDistribution'], "stats.php?entity=advertiser&breakdown=affiliates&clientid={clientid}"));
            $oMenu->addTo("1.3", new OA_Admin_Menu_Section("1.3.1", $GLOBALS['strDistributionHistory'], "stats.php?entity=advertiser&breakdown=affiliate-history&clientid={clientid}&affiliateid={affiliateid}"));
            $oMenu->addTo("1.3.1", new OA_Admin_Menu_Section("1.3.1.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&day={day}"));
            $oMenu->addTo("1.3", new OA_Admin_Menu_Section("1.3.2", $GLOBALS['strDistributionHistory'], "stats.php?entity=advertiser&breakdown=zone-history&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}"));
            $oMenu->addTo("1.3.2", new OA_Admin_Menu_Section("1.3.2.1", $GLOBALS['strDailyStats'], "stats.php?entity=advertiser&breakdown=daily&clientid={clientid}&affiliateid={affiliateid}&zoneid={zoneid}&day={day}"));
            $oMenu->addTo("1", new OA_Admin_Menu_Section("report-index", $GLOBALS['strAdvancedReports'], "report-index.php?clientid={clientid}"));

            $oMenu->add(new OA_Admin_Menu_Section("inventory", $GLOBALS['strAdminstration'], "advertiser-campaigns.php?clientid={clientid}"));
                $oMenu->addTo("inventory", new OA_Admin_Menu_Section("advertiser-campaigns", $GLOBALS['strCampaigns'], "advertiser-campaigns.php?clientid={clientid}"));
                    $oMenu->addTo("advertiser-campaigns", new OA_Admin_Menu_Section("campaign-banners", $GLOBALS['strBanners'], "campaign-banners.php?clientid={clientid}&campaignid={campaignid}"));
                        $oMenu->addTo("campaign-banners", new OA_Admin_Menu_Section("banner-edit", $GLOBALS['strBannerProperties'], "banner-edit.php?clientid={clientid}&campaignid={campaignid}&bannerid={bannerid}"));
                $oMenu->addTo("inventory", new OA_Admin_Menu_Section("advertiser-access", $GLOBALS['strUserAccess'], "advertiser-access.php?clientid={clientid}"));
            $oMenu->add(new OA_Admin_Menu_Section("account-index", $GLOBALS['strMyAccount'], "account-index.php"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-user-index", $GLOBALS['strUserPreferences'], "account-user-index.php"));
                $oMenu->addTo("account-index", new OA_Admin_Menu_Section("account-preferences-index", $GLOBALS['strPreferences'], "account-preferences-index.php"));
        break;
    }

    $GLOBALS['_MAX']['MENU_OBJECT'][$accountType] = &$oMenu;
    return $oMenu;
}

?>
