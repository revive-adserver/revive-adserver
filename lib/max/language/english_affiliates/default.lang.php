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

$GLOBALS['strInvocationcode']               = "Tags";
$GLOBALS['strCampaignID']                   = "Program ID";
$GLOBALS['strCampaignName']                 = "Program Name";
$GLOBALS['strClient']                       = "Merchant";
$GLOBALS['strClients']                      = "Merchants";
$GLOBALS['strClientsAndCampaigns']          = "Merchants & Programs";
$GLOBALS['strAddClient']                    = "Add new merchant";
$GLOBALS['strAddClient_Key']                = "Add <u>n</u>ew merchant";
$GLOBALS['strTotalClients']                 = "Total merchants";
$GLOBALS['strClientProperties']             = "Merchant properties";
$GLOBALS['strClientHistory']                = "Merchant history";
$GLOBALS['strNoClients']                    = "There are currently no merchants defined";
$GLOBALS['strConfirmDeleteClient']          = "Do you really want to delete this merchant?";
$GLOBALS['strConfirmResetClientStats']      = "Do you really want to delete all existing statistics for this merchant?";
$GLOBALS['strHideInactiveAdvertisers']      = "Hide inactive merchants";
$GLOBALS['strInactiveAdvertisersHidden']    = "inactive merchant(s) hidden";
$GLOBALS['strSendDeactivationWarning']      = "Send a warning when a program is deactivated";
$GLOBALS['strCampaign']                     = "Program";
$GLOBALS['strCampaigns']                    = "Programs";
$GLOBALS['strTotalCampaigns']               = "Total programs";
$GLOBALS['strActiveCampaigns']              = "Active programs";
$GLOBALS['strAddCampaign']                  = "Add new program";
$GLOBALS['strAddCampaign_Key']              = "Add <u>n</u>ew program";
$GLOBALS['strCreateNewCampaign']            = "Create new program";
$GLOBALS['strModifyCampaign']               = "Modify program";
$GLOBALS['strMoveToNewCampaign']            = "Move to a new program";
$GLOBALS['strBannersWithoutCampaign']       = "Banners without a program";
$GLOBALS['strDeleteAllCampaigns']           = "Delete all programs";
$GLOBALS['strLinkedCampaigns']              = "Linked programs";
$GLOBALS['strCampaignStats']                = "Program statistics";
$GLOBALS['strCampaignProperties']           = "Program properties";
$GLOBALS['strCampaignOverview']             = "Program overview";
$GLOBALS['strCampaignHistory']              = "Program history";
$GLOBALS['strNoCampaigns']                  = "There are currently no active programs defined";
$GLOBALS['strConfirmDeleteAllCampaigns']    = "Do you really want to delete all programs owned by this merchant?";
$GLOBALS['strConfirmDeleteCampaign']        = "Do you really want to delete this program?";
$GLOBALS['strConfirmResetCampaignStats']    = "Do you really want to delete all existing statistics for this program?";
$GLOBALS['strShowParentAdvertisers']        = "Show parent merchants";
$GLOBALS['strHideParentAdvertisers']        = "Hide parent merchants";
$GLOBALS['strHideInactiveCampaigns']        = "Hide inactive programs";
$GLOBALS['strInactiveCampaignsHidden']      = "inactive program(s) hidden";
$GLOBALS['strPriorityExclusive']            = "- Overrides other linked programs";
$GLOBALS['strPriorityHigh']                 = "- Paid programs";
$GLOBALS['strPriorityLow']                  = "- House and unpaid programs";
$GLOBALS['strHiddenCampaign']               = "Hidden program";
$GLOBALS['strUnderdeliveringCampaigns']     = "Underdelivering Programs";
$GLOBALS['strCampaignDelivery']             = "Program delivery";
$GLOBALS['strDontExpire']                   = "Don't expire this program on a specific date";
$GLOBALS['strActivateNow']                  = "Activate this program immediately";
$GLOBALS['strExpirationDateComment']        = "Program will finish at the end of this day";
$GLOBALS['strActivationDateComment']        = "Program will commence at the start of this day";
$GLOBALS['strCampaignWeight']               = "None - Set the program weight to";
$GLOBALS['strOptimise']                     = "Optimise delivery of this program.";
$GLOBALS['strAnonymous']                    = "Hide the merchant and affiliate of this program.";
$GLOBALS['strHighPriority']                 = "Show banners in this program with high priority.<br />If you use this option ".MAX_PRODUCT_NAME." will try to distribute the number of Impressions evenly over the course of the day.";
$GLOBALS['strLowPriority']                  = "Show banner in this campaign with low priority.<br /> This campaign is used to show the left over Impressions which aren't used by high priority programs.";
$GLOBALS['strCampaignWarningNoWeight']      = "The priority of this campaign has been set to low,
but the weight is set to zero or it has not been
specified. This will cause the program to be
deactivated and its banners won't be delivered
until the weight has been set to a valid number.

Are you sure you want to continue?";
$GLOBALS['strCampaignWarningNoTarget']      = "The priority of this campaign has been set to high,
but the target number of Impressions are not specified.
This will cause the program to be deactivated and
its banners won't be delivered until a valid target
number of Impressions has been set.

Are you sure you want to continue?";
$GLOBALS['strConfirmDeleteAllTrackers']     = "Do you really want to delete all trackers owned by this merchant?";
$GLOBALS['strLinkCampaignsByDefault']       = "Link newly created programs by default";
$GLOBALS['strConfirmDeleteAllBanners']      = "Do you really want to delete all banners which are owned by this program?";
$GLOBALS['strShowParentCampaigns']          = "Show parent programs";
$GLOBALS['strHideParentCampaigns']          = "Hide parent programs";
$GLOBALS['strAffiliate']                    = "Affiliate";
$GLOBALS['strAffiliates']                   = "Affiliates";
$GLOBALS['strAffiliatesAndZones']           = "Affiliates & Zones";
$GLOBALS['strAddNewAffiliate']              = "Add new affiliate";
$GLOBALS['strAddNewAffiliate_Key']          = "Add <u>n</u>ew affiliate";
$GLOBALS['strAddAffiliate']                 = "Create affiliate";
$GLOBALS['strAffiliateProperties']          = "Details";
$GLOBALS['strAffiliateOverview']            = "Affiliate overview";
$GLOBALS['strAffiliateHistory']             = "History";
$GLOBALS['strZonesWithoutAffiliate']        = "Zones without affiliate";
$GLOBALS['strMoveToNewAffiliate']           = "Move to new affiliate";
$GLOBALS['strNoAffiliates']                 = "There are currently no affiliates defined";
$GLOBALS['strConfirmDeleteAffiliate']       = "Do you really want to delete this affiliate?";
$GLOBALS['strMakePublisherPublic']          = "Make the zones owned by this affiliate publically available";
$GLOBALS['strHiddenWebsite']                = 'Affiliate';
$GLOBALS['strTotalAffiliates']              = 'Total affiliates';
$GLOBALS['strInactiveAffiliatesHidden']     = "inactive affiliate(s) hidden";
$GLOBALS['strShowParentAffiliates']         = "Show parent affiliates";
$GLOBALS['strCampaignLinkedAds']            = "Programs linked to the zone";
$GLOBALS['strCampaignDefaults']             = "Link banners by parent program";
$GLOBALS['strNoCampaignsToLink']            = "There are currently no programs available which can be linked to this zone";
$GLOBALS['strNoTrackersToLink']             = "There are currently no trackers available which can be linked to this program";
$GLOBALS['strNoZonesToLinkToCampaign']      = "There are no zones available to which this program can be linked";
$GLOBALS['strSelectCampaignToLink']         = "Select the program you would like to link to this zone:";
$GLOBALS['strSelectAdvertiser']             = 'Select Merchant';
$GLOBALS['strSelectPlacement']              = 'Select Program';
$GLOBALS['strStats']                        = "Home";
$GLOBALS['strPublisherDistribution']        = "Affiliate distribution";
$GLOBALS['strCampaignDistribution']         = "Programs";
$GLOBALS['strAdvertiserReports']            = "Merchant Reports";
$GLOBALS['strPublisherReports']             = "Affiliate Reports";
$GLOBALS['strAllAdvertisers']               = "All merchants";
$GLOBALS['strAnonAdvertisers']              = "Anonymous merchants";
$GLOBALS['strAllPublishers']                = "All affiliates";
$GLOBALS['strAnonPublishers']               = "Anonymous affiliates";
$GLOBALS['strLogErrorClients']              = "[phpAds] An error occurred while trying to fetch the merchants from the database.";
$GLOBALS['strErrorEditingCampaign']         = "Error updating program:";
$GLOBALS['strEmailNoDates']                 = 'Email zone programs must have a start and end date';
$GLOBALS['strMailSubject']                  = "Merchant report";
$GLOBALS['strAdReportSent']                 = "Merchant report sent";
$GLOBALS['strClientDeactivated']            = "This program is currently not active because";
$GLOBALS['strNoStatsForCampaign']           = "There are no statistics available for this program";
$GLOBALS['strVariableHidden']               = "Hide variable to affiliates?";

?>
