<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: default.lang.php 5884 2006-11-08 13:48:31Z dawid@arlenmedia.com $
*/

/**
 * A file for holding the "default" English translation information.
 *
 * @package    MaxUI
 * @subpackage Languages
 */

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']        = "ltr";
$GLOBALS['phpAds_TextAlignRight']       = "right";
$GLOBALS['phpAds_TextAlignLeft']        = "left";
$GLOBALS['phpAds_CharSet']              = "UTF-8";

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']        = "ltr";
$GLOBALS['phpAds_TextAlignRight']       = "right";
$GLOBALS['phpAds_TextAlignLeft']        = "left";

$GLOBALS['phpAds_DecimalPoint']         = '.';
$GLOBALS['phpAds_ThousandsSeperator']   = ',';

// Date & time configuration
$GLOBALS['date_format']                 = "%d-%m-%Y";
$GLOBALS['time_format']                 = "%H:%M:%S";
$GLOBALS['minute_format']               = "%H:%M";
$GLOBALS['month_format']                = "%m-%Y";
$GLOBALS['day_format']                  = "%d-%m";
$GLOBALS['week_format']                 = "%W-%Y";
$GLOBALS['weekiso_format']              = "%V-%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate
$GLOBALS['excel_integer_formatting']    = '#,##0;-#,##0;-';
$GLOBALS['excel_decimal_formatting']    = '#,##0.000;-#,##0.000;-';

/*-------------------------------------------------------*/
/* Translations                                          */
/*-------------------------------------------------------*/

$GLOBALS['strHome']                     = "Home";
$GLOBALS['strHelp']                     = "Help";
$GLOBALS['strNavigation']               = "Navigation";
$GLOBALS['strShortcuts']                = "Shortcuts";
$GLOBALS['strAdminstration']            = "Inventory";
$GLOBALS['strMaintenance']              = "Maintenance";
$GLOBALS['strProbability']              = "Probability";
$GLOBALS['strInvocationcode']           = "Invocation code";
$GLOBALS['strTrackerVariables']         = "Tracker Variables";
$GLOBALS['strBasicInformation']         = "Basic information";
$GLOBALS['strContractInformation']      = "Contract information";
$GLOBALS['strLoginInformation']         = "Login information";
$GLOBALS['strLogoutURL']                = 'URL to redirect to on logout. <br />Blank for default';
$GLOBALS['strAppendTrackerCode']        = "Append tracker code";
$GLOBALS['strOverview']                 = "Overview";
$GLOBALS['strSearch']                   = "<u>S</u>earch";
$GLOBALS['strHistory']                  = "History";
$GLOBALS['strPreferences']              = "Preferences";
$GLOBALS['strDetails']                  = "Details";
$GLOBALS['strCompact']                  = "Compact";
$GLOBALS['strVerbose']                  = "Verbose";
$GLOBALS['strUser']                     = "User";
$GLOBALS['strEdit']                     = "Edit";
$GLOBALS['strCreate']                   = "Create";
$GLOBALS['strDuplicate']                = "Duplicate";
$GLOBALS['strMoveTo']                   = "Move to";
$GLOBALS['strDelete']                   = "Delete";
$GLOBALS['strActivate']                 = "Activate";
$GLOBALS['strDeActivate']               = "Deactivate";
$GLOBALS['strConvert']                  = "Convert";
$GLOBALS['strRefresh']                  = "Refresh";
$GLOBALS['strSaveChanges']              = "Save Changes";
$GLOBALS['strUp']                       = "Up";
$GLOBALS['strDown']                     = "Down";
$GLOBALS['strSave']                     = "Save";
$GLOBALS['strCancel']                   = "Cancel";
$GLOBALS['strPrevious']                 = "Previous";
$GLOBALS['strPrevious_Key']             = "<u>P</u>revious";
$GLOBALS['strNext']                     = "Next";
$GLOBALS['strNext_Key']                 = "<u>N</u>ext";
$GLOBALS['strYes']                      = "Yes";
$GLOBALS['strNo']                       = "No";
$GLOBALS['strNone']                     = "None";
$GLOBALS['strCustom']                   = "Custom";
$GLOBALS['strDefault']                  = "Default";
$GLOBALS['strOther']                    = "Other";
$GLOBALS['strUnknown']                  = "Unknown";
$GLOBALS['strUnlimited']                = "Unlimited";
$GLOBALS['strUntitled']                 = "Untitled";
$GLOBALS['strAll']                      = "all";
$GLOBALS['strAvg']                      = "Avg.";
$GLOBALS['strAverage']                  = "Average";
$GLOBALS['strOverall']                  = "Overall";
$GLOBALS['strTotal']                    = "Total";
$GLOBALS['strUnfilteredTotal']          = "Total (unfiltered)";
$GLOBALS['strFilteredTotal']            = "Total (filtered)";
$GLOBALS['strActive']                   = "active";
$GLOBALS['strFrom']                     = "From";
$GLOBALS['strTo']                       = "to";
$GLOBALS['strLinkedTo']                 = "linked to";
$GLOBALS['strDaysLeft']                 = "Days left";
$GLOBALS['strCheckAllNone']             = "Check all / none";
$GLOBALS['strKiloByte']                 = "KB";
$GLOBALS['strExpandAll']                = "<u>E</u>xpand all";
$GLOBALS['strCollapseAll']              = "<u>C</u>ollapse all";
$GLOBALS['strShowAll']                    = "Show All";
$GLOBALS['strNoAdminInteface']            = "The admin screen has been turned off for maintenance.  This does not affect the delivery of your campaigns.";
$GLOBALS['strFilterBySource']            = "filter by source";
$GLOBALS['strFieldContainsErrors']        = "The following fields contain errors:";
$GLOBALS['strFieldFixBeforeContinue1']    = "Before you can continue you need";
$GLOBALS['strFieldFixBeforeContinue2']    = "to correct these errors.";
$GLOBALS['strDelimiter']                = "Delimiter";
$GLOBALS['strMiscellaneous']            = "Miscellaneous";
$GLOBALS['strCollectedAllStats']        = "All statistics";
$GLOBALS['strCollectedToday']            = "Today";
$GLOBALS['strCollectedYesterday']       = "Yesterday";
$GLOBALS['strCollectedThisWeek']        = "This week";
$GLOBALS['strCollectedLastWeek']        = "Last week";
$GLOBALS['strCollectedThisMonth']       = "This month";
$GLOBALS['strCollectedLastMonth']       = "Last month";
$GLOBALS['strCollectedLast7Days']        = "Last 7 days";
$GLOBALS['strCollectedSpecificDates']   = "Specific dates";
$GLOBALS['strDifference']               = 'Difference (%)';
$GLOBALS['strPercentageOfTotal']        = '% Total';
$GLOBALS['strValue']                    = 'Value';
$GLOBALS['strAdmin']                    = "Admin";

// Priority
$GLOBALS['strPriority']                 = "Priority";
$GLOBALS['strPriorityLevel']            = "Priority level";
$GLOBALS['strPriorityTargeting']        = "Distribution";
$GLOBALS['strPriorityOptimisation']     = "Miscellaneous";
$GLOBALS['strExclusiveAds']             = "Exclusive Advertisements";
$GLOBALS['strHighAds']                  = "High-Priority Advertisements";
$GLOBALS['strLowAds']                   = "Low-Priority Advertisements";
$GLOBALS['strLimitations']              = "Limitations";
$GLOBALS['strNoLimitations']            = "No Limitations";
$GLOBALS['strCapping']                  = 'Capping';
$GLOBALS['strCapped']                   = 'Capped';
$GLOBALS['strNoCapping']                = 'No capping';

// Properties
$GLOBALS['strName']                     = "Name";
$GLOBALS['strSize']                     = "Size";
$GLOBALS['strWidth']                    = "Width";
$GLOBALS['strHeight']                   = "Height";
$GLOBALS['strURL2']                     = "URL";
$GLOBALS['strTarget']                   = "Target";
$GLOBALS['strLanguage']                 = "Language";
$GLOBALS['strDescription']              = "Description";
$GLOBALS['strVariables']                = "Variables";
$GLOBALS['strID']                       = "ID";
$GLOBALS['strComments']                 = "Comments";

// Login & Permissions
$GLOBALS['strAuthentification']         = "Authentication";
$GLOBALS['strWelcomeTo']                = "Welcome to";
$GLOBALS['strEnterUsername']            = "Enter your username and password to log in";
$GLOBALS['strEnterBoth']                = "Please enter both your username and password";
$GLOBALS['strEnableCookies']            = "You need to enable cookies before you can use ".MAX_PRODUCT_NAME;
$GLOBALS['strLogin']                    = "Login";
$GLOBALS['strLogout']                   = "Logout";
$GLOBALS['strUsername']                 = "Username";
$GLOBALS['strPassword']                 = "Password";
$GLOBALS['strAccessDenied']             = "Access denied";
$GLOBALS['strPasswordWrong']            = "The password is not correct";
$GLOBALS['strParametersWrong']          = "The parameters you supplied are not correct";
$GLOBALS['strNotAdmin']                 = "You may not have enough privileges, if you know the correct user details, you may login again below";
$GLOBALS['strDuplicateClientName']      = "The username you provided already exists, please use a different username.";
$GLOBALS['strDuplicateAgencyName']      = "The username you provided already exists, please use a different username.";
$GLOBALS['strInvalidPassword']          = "The new password is invalid, please use a different password.";
$GLOBALS['strNotSamePasswords']         = "The two passwords you supplied are not the same";
$GLOBALS['strRepeatPassword']           = "Repeat Password";
$GLOBALS['strOldPassword']              = "Old Password";
$GLOBALS['strNewPassword']              = "New Password";
$GLOBALS['strNoBannerId']               = "No banner ID";


// General advertising
$GLOBALS['strRequests']                 = 'Requests';
$GLOBALS['strImpressions']              = "Impressions";
$GLOBALS['strClicks']                   = "Clicks";
$GLOBALS['strConversions']              = "Conversions";
$GLOBALS['strCTRShort']                 = "CTR";
$GLOBALS['strCTRShortHigh']             = "CTR for High";
$GLOBALS['strCTRShortLow']              = "CTR for Low";
$GLOBALS['strCNVRShort']                = "SR";
$GLOBALS['strCTR']                      = "Click-Through Ratio";
$GLOBALS['strCNVR']                     = "Sales Ratio";
$GLOBALS['strCPC']                      = "Cost Per Click";
$GLOBALS['strCPCo']                     = "Cost Per Conversion";
$GLOBALS['strCPCoShort']                = "CPCo";
$GLOBALS['strCPCShort']                 = "CPC";
$GLOBALS['strTotalCost']                = "Total Cost";
$GLOBALS['strTotalViews']               = "Total Impressions";
$GLOBALS['strTotalClicks']              = "Total Clicks";
$GLOBALS['strTotalConversions']         = "Total Conversions";
$GLOBALS['strViewCredits']              = "Impression Credits";
$GLOBALS['strClickCredits']             = "Click Credits";
$GLOBALS['strConversionCredits']        = "Conversion Credits";
$GLOBALS['strImportStats']              = "Import Statistics";
$GLOBALS['strDateTime']                 = "Date Time";
$GLOBALS['strTrackerID']                = "Tracker ID";
$GLOBALS['strTrackerName']              = "Tracker Name";
$GLOBALS['strCampaignID']               = "Campaign ID";
$GLOBALS['strCampaignName']             = "Campaign Name";
$GLOBALS['strCountry']                  = "Country";
$GLOBALS['strStatsAction']              = "Action";
$GLOBALS['strWindowDelay']              = "Window delay";
$GLOBALS['strStatsVariables']           = "Variables";

// Finance
$GLOBALS['strFinanceCPM']               = 'CPM';
$GLOBALS['strFinanceCPC']               = 'CPC';
$GLOBALS['strFinanceCPA']               = 'CPA';
$GLOBALS['strFinanceMT']                = 'Monthly Tenancy';

// Time and date related
$GLOBALS['strDate']                     = "Date";
$GLOBALS['strToday']                    = "Today";
$GLOBALS['strDay']                      = "Day";
$GLOBALS['strDays']                     = "Days";
$GLOBALS['strLast7Days']                = "Last 7 days";
$GLOBALS['strWeek']                     = "Week";
$GLOBALS['strWeeks']                    = "Weeks";
$GLOBALS['strSingleMonth']              = "Month";
$GLOBALS['strMonths']                   = "Months";
$GLOBALS['strDayOfWeek']                = "Day of week";
$GLOBALS['strThisMonth']                = "This month";
$GLOBALS['strMonth']                    = array("January","February","March","April","May","June","July", "August", "September", "October", "November", "December");
$GLOBALS['strDayFullNames']             = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
$GLOBALS['strDayShortCuts']             = array("Su","Mo","Tu","We","Th","Fr","Sa");
$GLOBALS['strHour']                     = "Hour";
$GLOBALS['strHourFilter']               = "Hour Filter";
$GLOBALS['strSeconds']                  = "seconds";
$GLOBALS['strMinutes']                  = "minutes";
$GLOBALS['strHours']                    = "hours";
$GLOBALS['strTimes']                    = "times";

// Advertiser
$GLOBALS['strClient']                       = "Advertiser";
$GLOBALS['strClients']                      = "Advertisers";
$GLOBALS['strClientsAndCampaigns']          = "Advertisers & Campaigns";
$GLOBALS['strAddClient']                    = "Add new advertiser";
$GLOBALS['strAddClient_Key']                = "Add <u>n</u>ew advertiser";
$GLOBALS['strTotalClients']                 = "Total advertisers";
$GLOBALS['strClientProperties']             = "Advertiser properties";
$GLOBALS['strClientHistory']                = "Advertiser history";
$GLOBALS['strNoClients']                    = "There are currently no advertisers defined";
$GLOBALS['strConfirmDeleteClient']          = "Do you really want to delete this advertiser?";
$GLOBALS['strConfirmResetClientStats']      = "Do you really want to delete all existing statistics for this advertiser?";
$GLOBALS['strSite']                         = 'Site';
$GLOBALS['strHideInactive']                 = "Hide inactive";
$GLOBALS['strHideInactiveAdvertisers']      = "Hide inactive advertisers";
$GLOBALS['strInactiveAdvertisersHidden']    = "inactive advertiser(s) hidden";


// Advertisers properties
$GLOBALS['strContact']                          = "Contact";
$GLOBALS['strEMail']                            = "E-mail";
$GLOBALS['strChars']                            = "chars";
$GLOBALS['strSendAdvertisingReport']            = "Send an advertising report via e-mail";
$GLOBALS['strNoDaysBetweenReports']             = "Number of days between reports";
$GLOBALS['strSendDeactivationWarning']          = "Send a warning when a campaign is deactivated";
$GLOBALS['strAllowClientModifyInfo']            = "Allow this user to modify his own settings";
$GLOBALS['strAllowClientModifyBanner']          = "Allow this user to modify his own banners";
$GLOBALS['strAllowClientAddBanner']             = "Allow this user to add his own banners";
$GLOBALS['strAllowClientDisableBanner']         = "Allow this user to deactivate his own banners";
$GLOBALS['strAllowClientActivateBanner']        = "Allow this user to activate his own banners";
$GLOBALS['strAllowClientViewTargetingStats']    = "Allow this user to view targeting statistics";
$GLOBALS['strCsvImportConversions']             = "Allow this user to import offline conversions";

// Campaign
$GLOBALS['strCampaign']                     = "Campaign";
$GLOBALS['strCampaigns']                    = "Campaigns";
$GLOBALS['strTotalCampaigns']               = "Total campaigns";
$GLOBALS['strActiveCampaigns']              = "Active campaigns";
$GLOBALS['strAddCampaign']                  = "Add new campaign";
$GLOBALS['strAddCampaign_Key']              = "Add <u>n</u>ew campaign";
$GLOBALS['strCreateNewCampaign']            = "Create new campaign";
$GLOBALS['strModifyCampaign']               = "Modify campaign";
$GLOBALS['strMoveToNewCampaign']            = "Move to a new campaign";
$GLOBALS['strBannersWithoutCampaign']       = "Banners without a campaign";
$GLOBALS['strDeleteAllCampaigns']           = "Delete all campaigns";
$GLOBALS['strLinkedCampaigns']              = "Linked campaigns";
$GLOBALS['strCampaignStats']                = "Campaign statistics";
$GLOBALS['strCampaignProperties']           = "Campaign properties";
$GLOBALS['strCampaignOverview']             = "Campaign overview";
$GLOBALS['strCampaignHistory']              = "Campaign history";
$GLOBALS['strNoCampaigns']                  = "There are currently no active campaigns defined";
$GLOBALS['strConfirmDeleteAllCampaigns']    = "Do you really want to delete all campaigns owned by this advertiser?";
$GLOBALS['strConfirmDeleteCampaign']        = "Do you really want to delete this campaign?";
$GLOBALS['strConfirmResetCampaignStats']    = "Do you really want to delete all existing statistics for this campaign?";
$GLOBALS['strShowParentAdvertisers']        = "Show parent advertisers";
$GLOBALS['strHideParentAdvertisers']        = "Hide parent advertisers";
$GLOBALS['strHideInactiveCampaigns']        = "Hide inactive campaigns";
$GLOBALS['strInactiveCampaignsHidden']      = "inactive campaign(s) hidden";
$GLOBALS['strContractDetails']              = "Contract details";
$GLOBALS['strInventoryDetails']             = "Inventory details";
$GLOBALS['strPriorityInformation']          = "Priority information";
$GLOBALS['strPriorityExclusive']            = "- Overrides other linked campaigns";
$GLOBALS['strPriorityHigh']                 = "- Paid campaigns";
$GLOBALS['strPriorityLow']                  = "- House and unpaid campaigns";
$GLOBALS['strPriorityHighShort']            = "High";
$GLOBALS['strPriorityLowShort']             = "Low";
$GLOBALS['strHiddenCampaign']               = "Campaign";
$GLOBALS['strHiddenAd']                     = "Advertisement";
$GLOBALS['strHiddenAdvertiser']             = "Advertiser";
$GLOBALS['strHiddenTracker']                = "Tracker";
$GLOBALS['strHiddenPublisher']              = "Publisher";
$GLOBALS['strHiddenZone']                   = "Zone";
$GLOBALS['strUnderdeliveringCampaigns']     = "Underdelivering Campaigns";
$GLOBALS['strCampaignDelivery']             = "Campaign delivery";
$GLOBALS['strBookedMetric']                 = "Booked Metric";
$GLOBALS['strValueBooked']                  = "Value Booked";
$GLOBALS['strRemaining']                    = "Remaining";
$GLOBALS['strCompanionPositioning']         = "Companion positioning";
$GLOBALS['strSelectUnselectAll']            = "Select / Unselect All";
$GLOBALS['strConfirmOverwrite']             = "Saving these changes will overwrite any individual banner-zone links. Are you sure?";

// Campaign properties
$GLOBALS['strDontExpire']                = "Don't expire this campaign on a specific date";
$GLOBALS['strActivateNow']                 = "Activate this campaign immediately";
$GLOBALS['strLow']                        = "Low";
$GLOBALS['strHigh']                        = "High";
$GLOBALS['strExclusive']                = "Exclusive";
$GLOBALS['strExpirationDate']            = "Expiration date";
$GLOBALS['strExpirationDateComment']    = "Campaign will finish at the end of this day";
$GLOBALS['strActivationDate']            = "Activation date";
$GLOBALS['strActivationDateComment']    = "Campaign will commence at the start of this day";
$GLOBALS['strRevenueInfo']              = 'Revenue Information';
$GLOBALS['strImpressionsRemaining']     = "Impressions Remaining";
$GLOBALS['strClicksRemaining']             = "Clicks Remaining";
$GLOBALS['strConversionsRemaining']     = "Conversions Remaining";
$GLOBALS['strImpressionsBooked']         = "Impressions Booked";
$GLOBALS['strClicksBooked']             = "Clicks Booked";
$GLOBALS['strConversionsBooked']         = "Conversions Booked";
$GLOBALS['strCampaignWeight']            = "None - Set the campaign weight to";
$GLOBALS['strOptimise']                    = "Optimise delivery of this campaign.";
$GLOBALS['strAnonymous']                = "Hide the advertiser and publisher of this campaign.";
$GLOBALS['strHighPriority']                = "Show banners in this campaign with high priority.<br />If you use this option ".MAX_PRODUCT_NAME." will try to distribute the number of Impressions evenly over the course of the day.";
$GLOBALS['strLowPriority']                = "Show banner in this campaign with low priority.<br /> This campaign is used to show the left over Impressions which aren't used by high priority campaigns.";
$GLOBALS['strTargetPerDay']                = "per day.";
$GLOBALS['strPriorityAutoTargeting']    = "Automatic - Distribute the remaining inventory evenly over the remaining number of days.";
$GLOBALS['strCampaignWarningNoWeight']     = "The priority of this campaign has been set to low, \nbut the weight is set to zero or it has not been \nspecified. This will cause the campaign to be \ndeactivated and its banners won't be delivered \nuntil the weight has been set to a valid number. \n\nAre you sure you want to continue?";
$GLOBALS['strCampaignWarningNoTarget']     = "The priority of this campaign has been set to high, \nbut the target number of Impressions are not specified. \nThis will cause the campaign to be deactivated and \nits banners won't be delivered until a valid target \nnumber of Impressions has been set. \n\nAre you sure you want to continue?";

// Tracker
$GLOBALS['strTracker']                    = "Tracker";
$GLOBALS['strTrackerOverview']            = "Tracker overview";
$GLOBALS['strAddTracker']                 = "Add new tracker";
$GLOBALS['strAddTracker_Key']             = "Add <u>n</u>ew tracker";
$GLOBALS['strNoTrackers']                = "There are currently no trackers defined";
$GLOBALS['strConfirmDeleteAllTrackers']    = "Do you really want to delete all trackers owned by this advertiser?";
$GLOBALS['strConfirmDeleteTracker']        = "Do you really want to delete this tracker?";
$GLOBALS['strDeleteAllTrackers']        = "Delete all trackers";
$GLOBALS['strTrackerProperties']        = "Tracker properties";
$GLOBALS['strTrackerOverview']            = "Tracker overview";
$GLOBALS['strModifyTracker']            = "Modify tracker";
$GLOBALS['strLog']                        = "Log?";
$GLOBALS['strDefaultStatus']              = "Default Status";
$GLOBALS['strStatus']                    = "Status";
$GLOBALS['strLinkedTrackers']            = "Linked Trackers";
$GLOBALS['strDefaultConversionRules']    = "Default conversion rules";
$GLOBALS['strConversionWindow']            = "Conversion window";
$GLOBALS['strClickWindow']                = "Click window";
$GLOBALS['strViewWindow']                = "View window";
$GLOBALS['strUniqueWindow']                = "Unique window";
$GLOBALS['strClick']                    = "Click";
$GLOBALS['strView']                        = "View";
$GLOBALS['strArrival']                        = "Arrival";
$GLOBALS['strManual']                        = "Manual";
$GLOBALS['strConversionClickWindow']    = "Count conversions which occur within this number of seconds of a click";
$GLOBALS['strConversionViewWindow']        = "Count conversions which occur within this number of seconds of a view";
$GLOBALS['strTotalTrackerImpressions']    = "Total Impressions";
$GLOBALS['strTotalTrackerConnections']    = "Total Connections";
$GLOBALS['strTotalTrackerConversions']    = "Total Conversions";
$GLOBALS['strTrackerImpressions']        = "Impressions";
$GLOBALS['strTrackerImprConnections']   = "Impression Connections";
$GLOBALS['strTrackerClickConnections']  = "Click Connections";
$GLOBALS['strTrackerImprConversions']   = "Impression Conversions";
$GLOBALS['strTrackerClickConversions']  = "Click Conversions";
$GLOBALS['strLinkCampaignsByDefault']   = "Link newly created campaigns by default";

// Banners (General)
$GLOBALS['strBanner']                       = "Banner";
$GLOBALS['strBanners']                       = "Banners";
$GLOBALS['strBannerFilter']                  = "Banner Filter";
$GLOBALS['strAddBanner']                   = "Add new banner";
$GLOBALS['strAddBanner_Key']               = "Add <u>n</u>ew banner";
$GLOBALS['strModifyBanner']               = "Modify banner";
$GLOBALS['strActiveBanners']               = "Active banners";
$GLOBALS['strTotalBanners']               = "Total banners";
$GLOBALS['strShowBanner']                  = "Show banner";
$GLOBALS['strShowAllBanners']               = "Show all banners";
$GLOBALS['strShowBannersNoAdViews']          = "Show banners without Impressions";
$GLOBALS['strShowBannersNoAdClicks']      = "Show banners without Clicks";
$GLOBALS['strShowBannersNoAdConversions'] = "Show banners without Sales";
$GLOBALS['strDeleteAllBanners']               = "Delete all banners";
$GLOBALS['strActivateAllBanners']          = "Activate all banners";
$GLOBALS['strDeactivateAllBanners']          = "Deactivate all banners";
$GLOBALS['strBannerOverview']              = "Banner overview";
$GLOBALS['strBannerProperties']              = "Banner properties";
$GLOBALS['strBannerHistory']              = "Banner history";
$GLOBALS['strBannerNoStats']               = "There are no statistics available for this banner";
$GLOBALS['strNoBanners']                  = "There are currently no banners defined";
$GLOBALS['strConfirmDeleteBanner']          = "Do you really want to delete this banner?";
$GLOBALS['strConfirmDeleteAllBanners']      = "Do you really want to delete all banners which are owned by this campaign?";
$GLOBALS['strConfirmResetBannerStats']      = "Do you really want to delete all existing statistics for this banner?";
$GLOBALS['strShowParentCampaigns']          = "Show parent campaigns";
$GLOBALS['strHideParentCampaigns']          = "Hide parent campaigns";
$GLOBALS['strHideInactiveBanners']          = "Hide inactive banners";
$GLOBALS['strInactiveBannersHidden']      = "inactive banner(s) hidden";
$GLOBALS['strAppendOthers']                  = "Append others";
$GLOBALS['strAppendTextAdNotPossible']      = "It is not possible to append other banners to text ads.";
$GLOBALS['strHiddenBanner']               = "Hidden banner";
$GLOBALS['strWarningTag1']                  = 'Warning, tag ';
$GLOBALS['strWarningTag2']                  = ' possibly is not closed/opened';
$GLOBALS['strWarningMissing']              = 'Warning, possibly missing ';
$GLOBALS['strWarningMissingClosing']       = ' closing tag ">"';
$GLOBALS['strWarningMissingOpening']       = ' opening tag "<"';
$GLOBALS['strSubmitAnyway']       		   = 'Submit Anyway';


// Banner (Properties)
$GLOBALS['strChooseBanner']         = "Please choose the type of the banner";
$GLOBALS['strMySQLBanner']             = "Local banner (SQL)";
$GLOBALS['strWebBanner']             = "Local banner (Webserver)";
$GLOBALS['strURLBanner']             = "External banner";
$GLOBALS['strHTMLBanner']             = "HTML banner";
$GLOBALS['strTextBanner']             = "Text ad";
$GLOBALS['strAutoChangeHTML']        = "Alter HTML to enable tracking of Clicks";
$GLOBALS['strUploadOrKeep']            = "Do you wish to keep your <br />existing image, or do you <br />want to upload another?";
$GLOBALS['strUploadOrKeepAlt']        = "Do you wish to keep your <br />existing backup image, or do you <br />want to upload another?";
$GLOBALS['strNewBannerFile']         = "Select the image you want <br />to use for this banner<br /><br />";
$GLOBALS['strNewBannerFileAlt']     = "Select a backup image you <br />want to use in case browsers<br />don't support rich media<br /><br />";
$GLOBALS['strNewBannerURL']         = "Image URL (incl. http://)";
$GLOBALS['strURL']                     = "Destination URL (incl. http://)";
$GLOBALS['strHTML']                 = "HTML";
$GLOBALS['strTextBelow']             = "Text below image";
$GLOBALS['strWeight']                 = "Weight";
$GLOBALS['strAlt']                     = "Alt text";
$GLOBALS['strStatusText']            = "Status text";
$GLOBALS['strBannerWeight']            = "Banner weight";
$GLOBALS['strBannerType']           = "Ad Type";
$GLOBALS['strAdserverTypeGeneric']  = "Generic HTML Banner";
$GLOBALS['strAdserverTypeMax']      = "Rich Media - m3 Max Media Manager";
$GLOBALS['strAdserverTypeAtlas']    = "Rich Media - Atlas";
$GLOBALS['strAdserverTypeBluestreak']   = "Rich Media - Bluestreak";
$GLOBALS['strAdserverTypeDoubleclick']  = "Rich Media - DoubleClick";
$GLOBALS['strAdserverTypeEyeblaster']   = "Rich Media - Eyeblaster";
$GLOBALS['strAdserverTypeFalk']         = "Rich Media - Falk";
$GLOBALS['strAdserverTypeMediaplex']    = "Rich Media - Mediaplex";
$GLOBALS['strAdserverTypeTangozebra']   = "Rich Media - Tango Zebra";
$GLOBALS['strGenericOutputAdServer'] = "Generic";

// Banner (swf)
$GLOBALS['strCheckSWF']                = "Check for hard-coded links inside the Flash file";
$GLOBALS['strConvertSWFLinks']        = "Convert Flash links";
$GLOBALS['strHardcodedLinks']        = "Hard-coded links";
$GLOBALS['strConvertSWF']            = "<br />The Flash file you just uploaded contains hard-coded urls. ".MAX_PRODUCT_NAME." won't be able to track the number of Clicks for this banner unless you convert these hard-coded urls. Below you will find a list of all urls inside the Flash file. If you want to convert the urls, simply click <b>Convert</b>, otherwise click <b>Cancel</b>.<br /><br />Please note: if you click <b>Convert</b> the Flash file you just uploaded will be physically altered. <br />Please keep a backup of the original file. Regardless of in which version this banner was created, the resulting file will need the Flash 4 player (or higher) to display correctly.<br /><br />";
$GLOBALS['strCompressSWF']            = "Compress SWF file for faster downloading (Flash 6 player required)";
$GLOBALS['strOverwriteSource']        = "Overwrite source parameter";
$GLOBALS['strLinkToShort']            = "Warning: Hard-coded URLs detected - However the URL it too short to be automatically modified";

// Banner (network)
$GLOBALS['strBannerNetwork']        = "HTML template";
$GLOBALS['strChooseNetwork']        = "Choose the template you want to use";
$GLOBALS['strMoreInformation']        = "More information...";
$GLOBALS['strRichMedia']            = "Richmedia";
$GLOBALS['strTrackAdClicks']        = "Track Clicks";

// Display limitations
$GLOBALS['strModifyBannerAcl']             = "Delivery options";
$GLOBALS['strACL']                         = "Delivery";
$GLOBALS['strACLAdd']                     = "Add new limitation";
$GLOBALS['strACLAdd_Key']                 = "Add <u>n</u>ew limitation";
$GLOBALS['strNoLimitations']            = "No limitations";
$GLOBALS['strApplyLimitationsTo']        = "Apply limitations to";
$GLOBALS['strRemoveAllLimitations']        = "Remove all limitations";
$GLOBALS['strEqualTo']                    = "is equal to";
$GLOBALS['strDifferentFrom']            = "is different from";
$GLOBALS['strLaterThan']                = "is later than";
$GLOBALS['strLaterThanOrEqual']            = "is later than or equal to";
$GLOBALS['strEarlierThan']                = "is earlier than";
$GLOBALS['strEarlierThanOrEqual']        = "is earlier than or equal to";
$GLOBALS['strContains']                    = "contains";
$GLOBALS['strNotContains']                = "doesn't contain";
$GLOBALS['strAND']                        = "AND";                          // logical operator
$GLOBALS['strOR']                        = "OR";                         // logical operator
$GLOBALS['strOnlyDisplayWhen']            = "Only display this banner when:";
$GLOBALS['strWeekDay']                     = "Weekday";
$GLOBALS['strWeekDays']                     = "Weekdays";
$GLOBALS['strTime']                     = "Time";
$GLOBALS['strUserAgent']                 = "Useragent";
$GLOBALS['strDomain']                     = "Domain";
$GLOBALS['strClientIP']                 = "Client IP";
$GLOBALS['strSource']                     = "Source";
$GLOBALS['strSourceFilter']                = "Source Filter";
$GLOBALS['strBrowser']                     = "Browser";
$GLOBALS['strOS']                         = "OS";
$GLOBALS['strCountryCode']                 = "Country Code (ISO 3166)";
$GLOBALS['strCountryName']                 = "Country Name";
$GLOBALS['strRegion']                    = "Region Code (ISO-3166-2 or FIPS 10-4)";
$GLOBALS['strCity']                        = "City Name";
$GLOBALS['strPostalCode']                = "US/Canada ZIP/Postcode";
$GLOBALS['strLatitude']                    = "Latitude";
$GLOBALS['strLongitude']                = "Longitude";
$GLOBALS['strDMA']                         = "US DMA Code";
$GLOBALS['strArea']                         = "US Telephone Area Prefix Code";
$GLOBALS['strOrg']                         = "Organisation Name";
$GLOBALS['strIsp']                         = "ISP Name";
$GLOBALS['strNetspeed']                      = "Internet Connection Speed";
$GLOBALS['strReferer']                     = "Referring page";
$GLOBALS['strDeliveryLimitations']        = "Delivery limitations";

$GLOBALS['strDeliveryCapping']            = "Delivery capping";
$GLOBALS['strCappingBanner'] = array();
$GLOBALS['strCappingBanner']['title'] = $GLOBALS['strDeliveryCapping'];
$GLOBALS['strCappingBanner']['time'] = "Once this banner has been delivered once, don't show this banner again to the same user for:";
$GLOBALS['strCappingBanner']['user'] = "Do not show this banner to the same user more than:";
$GLOBALS['strCappingBanner']['session'] = "Do not show this banner during the same session more than:";

$GLOBALS['strCappingZone'] = array();
$GLOBALS['strCappingZone']['title'] = $GLOBALS['strDeliveryCapping'];
$GLOBALS['strCappingZone']['time'] = "Once banner from this zone has been delivered, don't show any banner from this zone again to the same user for:";
$GLOBALS['strCappingZone']['user'] = "Do not show banners from this zone to the same user more than:";
$GLOBALS['strCappingZone']['session'] = "Do not show banners from this zone during the same session more than:";

// Publisher
$GLOBALS['strAffiliate']                = "Publisher";
$GLOBALS['strAffiliates']                 = "Publishers";
$GLOBALS['strAffiliatesAndZones']        = "Publishers & Zones";
$GLOBALS['strAddNewAffiliate']            = "Add new publisher";
$GLOBALS['strAddNewAffiliate_Key']        = "Add <u>n</u>ew publisher";
$GLOBALS['strAddAffiliate']                = "Create publisher";
$GLOBALS['strAffiliateProperties']        = "Publisher properties";
$GLOBALS['strAffiliateOverview']        = "Publisher overview";
$GLOBALS['strAffiliateHistory']            = "Publisher history";
$GLOBALS['strZonesWithoutAffiliate']    = "Zones without publisher";
$GLOBALS['strMoveToNewAffiliate']        = "Move to new publisher";
$GLOBALS['strNoAffiliates']                = "There are currently no publishers defined";
$GLOBALS['strConfirmDeleteAffiliate']    = "Do you really want to delete this publisher?";
$GLOBALS['strMakePublisherPublic']        = "Make the zones owned by this publisher publically available";
$GLOBALS['strAffiliateInvocation']      = 'Invocation Code';
$GLOBALS['strTotalAffiliates']          = 'Total publishers';
$GLOBALS['strInactiveAffiliatesHidden'] = "inactive publisher(s) hidden";
$GLOBALS['strShowParentAffiliates']     = "Show parent publishers";
$GLOBALS['strHideParentAffiliates']     = "Hide parent publishers";

// Publisher (properties)
$GLOBALS['strWebsite']                      = "Website";
$GLOBALS['strMnemonic']                     = "Mnemonic";
$GLOBALS['strAllowAffiliateModifyInfo']     = "Allow this user to modify his own settings";
$GLOBALS['strAllowAffiliateModifyZones']    = "Allow this user to modify his own zones";
$GLOBALS['strAllowAffiliateLinkBanners']    = "Allow this user to link banners to his own zones";
$GLOBALS['strAllowAffiliateAddZone']        = "Allow this user to define new zones";
$GLOBALS['strAllowAffiliateDeleteZone']     = "Allow this user to delete existing zones";
$GLOBALS['strAllowAffiliateGenerateCode']   = "Allow this user to generate invocation code";
$GLOBALS['strAllowAffiliateZoneStats']      = "Allow this user to view zone statistics";
$GLOBALS['strAllowAffiliateApprPendConv']   = "Allow this user to only view approved or pending conversions";

// Publisher (properties - payment information)
$GLOBALS['strPaymentInformation']           = "Payment information";
$GLOBALS['strAddress']                      = "Address";
$GLOBALS['strPostcode']                     = "Postcode";
$GLOBALS['strCity']                         = "City";
$GLOBALS['strCountry']                      = "Country";
$GLOBALS['strPhone']                        = "Phone";
$GLOBALS['strFax']                          = "Fax";
$GLOBALS['strAccountContact']               = "Account contact";
$GLOBALS['strPayeeName']                    = "Payee name";
$GLOBALS['strTaxID']                        = "Tax ID";
$GLOBALS['strModeOfPayment']                = "Mode of payment";
$GLOBALS['strPaymentChequeByPost']          = "Cheque by post";
$GLOBALS['strCurrency']                     = "Currency";
$GLOBALS['strCurrencyGBP']                  = "GBP";

// Publisher (properties - other information)
$GLOBALS['strOtherInformation']             = "Other information";
$GLOBALS['strUniqueUsersMonth']             = "Unique users/month";
$GLOBALS['strUniqueViewsMonth']             = "Unique views/month";
$GLOBALS['strPageRank']                     = "Page rank";
$GLOBALS['strCategory']                     = "Category";
$GLOBALS['strHelpFile']                     = "Help file";
$GLOBALS['strApprovedTandC']                = "Approved terms and conditions";

// Zone
$GLOBALS['strChooseZone']                   = "Choose Zone";
$GLOBALS['strZone']                         = "Zone";
$GLOBALS['strZones']                        = "Zones";
$GLOBALS['strAddNewZone']                   = "Add new zone";
$GLOBALS['strAddNewZone_Key']               = "Add <u>n</u>ew zone";
$GLOBALS['strAddZone']                      = "Create zone";
$GLOBALS['strModifyZone']                   = "Modify zone";
$GLOBALS['strLinkedZones']                  = "Linked zones";
$GLOBALS['strZoneOverview']                 = "Zone overview";
$GLOBALS['strZoneProperties']               = "Zone properties";
$GLOBALS['strZoneHistory']                  = "Zone history";
$GLOBALS['strNoZones']                      = "There are currently no zones defined";
$GLOBALS['strConfirmDeleteZone']            = "Do you really want to delete this zone?";
$GLOBALS['strZoneType']                     = "Zone type";
$GLOBALS['strBannerButtonRectangle']        = "Banner, Button or Rectangle";
$GLOBALS['strInterstitial']                 = "Interstitial or Floating DHTML";
$GLOBALS['strPopup']                        = "Popup";
$GLOBALS['strTextAdZone']                   = "Text ad";
$GLOBALS['strEmailAdZone']                  = "Email/Newsletter zone";
$GLOBALS['strZoneClick']                    = "Click tracking zone";
$GLOBALS['strShowMatchingBanners']          = "Show matching banners";
$GLOBALS['strHideMatchingBanners']          = "Hide matching banners";
$GLOBALS['strBannerLinkedAds']              = "Banners linked to the zone";
$GLOBALS['strCampaignLinkedAds']            = "Campaigns linked to the zone";
$GLOBALS['strTotalZones']                   = 'Total zones';
$GLOBALS['strCostInfo']                     = 'Media Cost';
$GLOBALS['strTechnologyCost']               = 'Technology Cost';
$GLOBALS['strInactiveZonesHidden']          = "inactive zone(s) hidden";

// Advanced zone settings
$GLOBALS['strAdvanced']                    = "Advanced";
$GLOBALS['strChains']                    = "Chains";
$GLOBALS['strChainSettings']            = "Chain settings";
$GLOBALS['strZoneNoDelivery']            = "If no banners from this zone <br />can be delivered, try to...";
$GLOBALS['strZoneStopDelivery']            = "Stop delivery and don't show a banner";
$GLOBALS['strZoneOtherZone']            = "Display the selected zone instead";
$GLOBALS['strZoneUseKeywords']            = "Select a banner using the keywords entered below";
$GLOBALS['strZoneAppend']                = "Always append the following HTML code to banners displayed by this zone";
$GLOBALS['strAppendSettings']            = "Append and prepend settings";
$GLOBALS['strZoneForecasting']            = "Zone Forecasting settings";
$GLOBALS['strZonePrependHTML']            = "Always prepend the HTML code to text ads displayed by this zone";
$GLOBALS['strZoneAppendHTML']            = "Always append the HTML code to text ads displayed by this zone";
$GLOBALS['strZoneAppendNoBanner']        = "Append even if no banner delivered";
$GLOBALS['strZoneAppendType']            = "Append type";
$GLOBALS['strZoneAppendHTMLCode']        = "HTML code";
$GLOBALS['strZoneAppendZoneSelection']    = "Popup or interstitial";
$GLOBALS['strZoneAppendSelectZone']        = "Always append the following popup or intersitial to banners displayed by this zone";

// Zone probability
$GLOBALS['strZoneProbListChain']        = "All the banners linked to the selected zone are currently not active. <br />This is the zone chain that will be followed:";
$GLOBALS['strZoneProbNullPri']            = "There are no active banners linked to this zone.";
$GLOBALS['strZoneProbListChainLoop']    = "Following the zone chain would cause a circular loop. Delivery for this zone is halted.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType']            = "Please choose what to link to this zone";
$GLOBALS['strLinkedBanners']            = "Link individual banners";
$GLOBALS['strCampaignDefaults']            = "Link banners by parent campaign";
$GLOBALS['strLinkedCategories']         = "Link banners by category";
$GLOBALS['strInteractive']                = "Interactive";
$GLOBALS['strRawQueryString']            = "Keyword";
$GLOBALS['strIncludedBanners']            = "Linked banners";
$GLOBALS['strLinkedBannersOverview']    = "Linked banners overview";
$GLOBALS['strLinkedBannerHistory']        = "Linked banner history";
$GLOBALS['strNoZonesToLink']            = "There are no zones available to which this banner can be linked";
$GLOBALS['strNoBannersToLink']            = "There are currently no banners available which can be linked to this zone";
$GLOBALS['strNoLinkedBanners']            = "There are no banners available which are linked to this zone";
$GLOBALS['strMatchingBanners']            = "{count} matching banners";
$GLOBALS['strNoCampaignsToLink']        = "There are currently no campaigns available which can be linked to this zone";
$GLOBALS['strNoTrackersToLink']            = "There are currently no trackers available which can be linked to this campaign";
$GLOBALS['strNoZonesToLinkToCampaign']  = "There are no zones available to which this campaign can be linked";
$GLOBALS['strSelectBannerToLink']        = "Select the banner you would like to link to this zone:";
$GLOBALS['strSelectCampaignToLink']        = "Select the campaign you would like to link to this zone:";
$GLOBALS['strSelectAdvertiser']         = 'Select Advertiser';
$GLOBALS['strSelectPlacement']          = 'Select Campaign';
$GLOBALS['strSelectAd']                 = 'Select Banner';
$GLOBALS['strTrackerCode']              = 'Append the following code to each Javascript tracker impression';
$GLOBALS['strTrackerCodeSubject']          = 'Append tracker code';
$GLOBALS['strAppendTrackerNotPossible']    = 'It is not possible to append that tracker.';
$GLOBALS['strStatusPending']            = 'Pending';
$GLOBALS['strStatusApproved']           = 'Approved';
$GLOBALS['strStatusDisapproved']        = 'Disapproved';
$GLOBALS['strStatusDuplicate']          = 'Duplicate';
$GLOBALS['strStatusOnHold']             = 'On Hold';
$GLOBALS['strStatusIgnore']             = 'Ignore';
$GLOBALS['strConnectionType']           = 'Type';
$GLOBALS['strConnTypeSale']             = 'Sale';
$GLOBALS['strConnTypeLead']             = 'Lead';
$GLOBALS['strConnTypeSignUp']           = 'Signup';
$GLOBALS['strShortcutEditStatuses'] = 'Edit statuses';
$GLOBALS['strShortcutShowStatuses'] = 'Show statuses';

// Statistics
$GLOBALS['strStats']                 = "Statistics";
$GLOBALS['strNoStats']                = "There are currently no statistics available";
$GLOBALS['strNoStatsForPeriod']        = "There are currently no statistics available for the period %s to %s";
$GLOBALS['strConfirmResetStats']    = "Do you really want to delete all existing statistics?";
$GLOBALS['strGlobalHistory']        = "Global history";
$GLOBALS['strDailyHistory']            = "Daily history";
$GLOBALS['strDailyStats']             = "Daily statistics";
$GLOBALS['strWeeklyHistory']        = "Weekly history";
$GLOBALS['strMonthlyHistory']        = "Monthly history";
$GLOBALS['strCreditStats']             = "Credit statistics";
$GLOBALS['strDetailStats']             = "Detailed statistics";
$GLOBALS['strTotalThisPeriod']        = "Total this period";
$GLOBALS['strAverageThisPeriod']    = "Average this period";
$GLOBALS['strPublisherDistribution'] = "Publisher distribution";
$GLOBALS['strCampaignDistribution'] = "Campaign distribution";
$GLOBALS['strDistributionBy']        = "Distribution by";
$GLOBALS['strOptimise']                = "Optimise";
$GLOBALS['strKeywordStatistics']    = "Keyword Statistics";
$GLOBALS['strResetStats']             = "Reset statistics";
$GLOBALS['strSourceStats']            = "Source statistics";
$GLOBALS['strSources']                = "Sources";
$GLOBALS['strAvailableSources']        = "Available Sources";
$GLOBALS['strSelectSource']            = "Select the source you want to view:";
$GLOBALS['strSizeDistribution']        = "Distribution by size";
$GLOBALS['strCountryDistribution']    = "Distribution by country";
$GLOBALS['strEffectivity']            = "Effectivity";
$GLOBALS['strTargetStats']            = "Targeting statistics";
$GLOBALS['strCampaignTarget']        = "Target";
$GLOBALS['strTargetRatio']            = "Target Ratio";
$GLOBALS['strTargetModifiedDay']    = "Targets were modified during the day, targeting could be not accurate";
$GLOBALS['strTargetModifiedWeek']    = "Targets were modified during the week, targeting could be not accurate";
$GLOBALS['strTargetModifiedMonth']    = "Targets were modified during the month, targeting could be not accurate";
$GLOBALS['strNoTargetStats']        = "There are currently no statistics about targeting available";
$GLOBALS['strOVerall']                = "Overall";
$GLOBALS['strByZone']                = "By Zone";
$GLOBALS['strImpressionsRequestsRatio']   = "View Request Ratio (%)";
$GLOBALS['strViewBreakdown']        = "View";
$GLOBALS['strBreakdownByDay']       = "Day";
$GLOBALS['strBreakdownByWeek']      = "Week";
$GLOBALS['strBreakdownByMonth']     = "Month";
$GLOBALS['strBreakdownByDow']       = "Day of week";
$GLOBALS['strBreakdownByHour']      = "Hour";
$GLOBALS['strItemsPerPage']         = "Items per page";
$GLOBALS['strDistributionHistory']  = "Distribution history";
$GLOBALS['strShowGraphOfStatistics']  = "Show <u>G</u>raph of Statistics";
$GLOBALS['strExportStatisticsToExcel']  = "<u>E</u>xport Statistics to Excel";
$GLOBALS['strGDnotEnabled']         = "You must have GD enabled in PHP to display graphs. <br />Please see <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> for more information, including how to install GD on your server.";
$GLOBALS['strTTFnotEnabled']         = "You have GD enabled in PHP but there is a problem with FreeType support. <br /> Freetype is needed in order to show the graph. <br />Please check your server configuration.";

// Hosts
$GLOBALS['strHosts']                = "Hosts";
$GLOBALS['strTopHosts']             = "Top requesting hosts";
$GLOBALS['strTopCountries']         = "Top requesting countries";
$GLOBALS['strRecentHosts']             = "Most recent requesting hosts";

// Expiration
$GLOBALS['strExpired']                = "Expired";
$GLOBALS['strExpiration']             = "Expiration";
$GLOBALS['strNoExpiration']         = "No expiration date set";
$GLOBALS['strEstimated']             = "Estimated expiration";

// Reports
$GLOBALS['strReports']                = "Reports";
$GLOBALS['strAdminReports']         = "Admin Reports";
$GLOBALS['strAdvertiserReports']    = "Advertiser Reports";
$GLOBALS['strAgencyReports']        = "Agency Reports";
$GLOBALS['strPublisherReports']     = "Publisher Reports";
$GLOBALS['strSelectReport']            = "Select the report you want to generate";
$GLOBALS['strStartDate']            = "Start Date";
$GLOBALS['strEndDate']                = "End Date";
$GLOBALS['strNoData']                = "There is no data available for this time period";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers']            = "All advertisers";
$GLOBALS['strAnonAdvertisers']           = "Anonymous advertisers";
$GLOBALS['strAllPublishers']             = "All publishers";
$GLOBALS['strAnonPublishers']            = "Anonymous publishers";
$GLOBALS['strAllAvailZones']             = "All available zones";

// Userlog
$GLOBALS['strUserLog']                = "User log";
$GLOBALS['strUserLogDetails']        = "User log details";
$GLOBALS['strDeleteLog']            = "Delete log";
$GLOBALS['strAction']                = "Action";
$GLOBALS['strNoActionsLogged']        = "No actions are logged";

// Code generation
$GLOBALS['strGenerateBannercode']        = "Direct selection";
$GLOBALS['strChooseInvocationType']        = "Please choose the type of banner invocation";
$GLOBALS['strGenerate']                    = "Generate";
$GLOBALS['strParameters']                = "Parameters";
$GLOBALS['strFrameSize']                = "Frame size";
$GLOBALS['strBannercode']                = "Bannercode";
$GLOBALS['strTrackercode']                = "Trackercode";
$GLOBALS['strOptional']                    = "optional";
$GLOBALS['strBackToTheList']            = "Go back to report list";
$GLOBALS['strGoToReportBuilder']        = "Go to the selected report";

// Errors
$GLOBALS['strMySQLError']                 = "SQL Error:";
$GLOBALS['strLogErrorClients']             = "[phpAds] An error occurred while trying to fetch the advertisers from the database.";
$GLOBALS['strLogErrorBanners']             = "[phpAds] An error occurred while trying to fetch the banners from the database.";
$GLOBALS['strLogErrorViews']             = "[phpAds] An error occurred while trying to fetch the Impressions from the database.";
$GLOBALS['strLogErrorClicks']             = "[phpAds] An error occurred while trying to fetch the Clicks from the database.";
$GLOBALS['strLogErrorConversions']         = "[phpAds] An error occurred while trying to fetch the Conversions from the database.";
$GLOBALS['strErrorViews']                 = "You must enter the number of impressions or select the unlimited box !";
$GLOBALS['strErrorNegViews']             = "Negative impressions are not allowed";
$GLOBALS['strErrorClicks']                 = "You must enter the number of clicks or select the unlimited box !";
$GLOBALS['strErrorNegClicks']             = "Negative clicks are not allowed";
$GLOBALS['strErrorConversions']         = "You must enter the number of conversions or select the unlimited box !";
$GLOBALS['strErrorNegConversions']         = "Negative conversions are not allowed";
$GLOBALS['strNoMatchesFound']            = "No matches were found";
$GLOBALS['strErrorOccurred']            = "An error occurred";
$GLOBALS['strErrorUploadSecurity']        = "Detected a possible security problem, upload halted!";
$GLOBALS['strErrorUploadBasedir']        = "Could not access uploaded file, probably due to safemode or open_basedir restrictions";
$GLOBALS['strErrorUploadUnknown']        = "Could not access uploaded file, due to an unknown reason. Please check your PHP configuration";
$GLOBALS['strErrorStoreLocal']            = "An error occcured while trying to save the banner in the local directory. This is probably the result of a misconfiguration of the local directory path settings";
$GLOBALS['strErrorStoreFTP']            = "An error occcured while trying to upload the banner to the FTP server. This could be because the server is not available, or because of a misconfiguration of the FTP server settings";
$GLOBALS['strErrorDBPlain']                = "An error occurred while accessing the database";
$GLOBALS['strErrorDBSerious']            = "A serious problem with the database has been detected";
$GLOBALS['strErrorDBNoDataPlain']        = "Due to a problem with the database ".MAX_PRODUCT_NAME." couldn't retrieve or store data. ";
$GLOBALS['strErrorDBNoDataSerious']        = "Due to a serious problem with the database, ".MAX_PRODUCT_NAME." couldn't retrieve data";
$GLOBALS['strErrorDBCorrupt']            = "The database table is probably corrupt and needs to be repaired. For more information about repairing corrupted tables please read the chapter <i>Troubleshooting</i> of the <i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact']            = "Please contact the administrator of this server and notify him or her of the problem.";
$GLOBALS['strErrorDBSubmitBug']            = "If this problem is reproducable it might be caused by a bug in ".MAX_PRODUCT_NAME.". Please report the following information to the creators of ".MAX_PRODUCT_NAME.". Also try to describe the actions that led to this error as clearly as possible.";
$GLOBALS['strMaintenanceNotActive']        = "The maintenance script has not been run in the last 24 hours. \\nIn order for ".MAX_PRODUCT_NAME." to function correctly it needs to run \\nevery hour. \\n\\nPlease read the Administrator guide for more information \\nabout configuring the maintenance script.";
$GLOBALS['strErrorBadUserType']         = "The system was unable to determine your account user type!";
$GLOBALS['strErrorLinkingBanner']       = "There were errors linking banners to zones:";
$GLOBALS['strUnableToLinkBanner']       = "Unable to link: ";
$GLOBALS['strErrorEditingCampaign']     = "Error updating campaign:";
$GLOBALS['strUnableToChangeCampaign']   = "Cannot apply this change because:";
$GLOBALS['strDatesConflict']            = "dates conflict with:";
$GLOBALS['strEmailNoDates']             = 'Email zone campaigns must have a start and end date';

// E-mail
$GLOBALS['strMailSubject']                     = "Advertiser report";
$GLOBALS['strAdReportSent']                    = "Advertiser report sent";
$GLOBALS['strMailSubjectDeleted']             = "Deactivated banners";
$GLOBALS['strMailHeader']                     = "Dear {contact},\n";
$GLOBALS['strMailBannerStats']                 = "Below you will find the banner statistics for {clientname}:";
$GLOBALS['strMailFooter']                     = "Regards,\n   {adminfullname}";
$GLOBALS['strMailClientDeactivated']         = "The following banners have been disabled because";
$GLOBALS['strMailNothingLeft']                 = "If you would like to continue advertising on our website, please feel free to contact us.\nWe'd be glad to hear from you.";
$GLOBALS['strClientDeactivated']            = "This campaign is currently not active because";
$GLOBALS['strBeforeActivate']                = "the activation date has not yet been reached";
$GLOBALS['strAfterExpire']                    = "the expiration date has been reached";
$GLOBALS['strNoMoreImpressions']            = "there are no Impressions remaining";
$GLOBALS['strNoMoreClicks']                    = "there are no Clicks remaining";
$GLOBALS['strNoMoreConversions']            = "there are no Sales remaining";
$GLOBALS['strWeightIsNull']                    = "its weight is set to zero";
$GLOBALS['strWarnClientTxt']                = "The Impressions, Clicks, or Conversions left for your banners are getting below {limit}. \nYour banners will be disabled when there are no Impressions, Clicks, or Conversions left. ";
$GLOBALS['strImpressionsClicksConversionsLow']    = "Impressions/Clicks/Conversions are low";
$GLOBALS['strNoViewLoggedInInterval']       = "No Impressions were logged during the span of this report";
$GLOBALS['strNoClickLoggedInInterval']      = "No Clicks were logged during the span of this report";
$GLOBALS['strNoConversionLoggedInInterval'] = "No Conversions were logged during the span of this report";
$GLOBALS['strMailReportPeriod']                = "This report includes statistics from {startdate} up to {enddate}.";
$GLOBALS['strMailReportPeriodAll']            = "This report includes all statistics up to {enddate}.";
$GLOBALS['strNoStatsForCampaign']             = "There are no statistics available for this campaign";

// Priority
$GLOBALS['strPriority']                = "Priority";
$GLOBALS['strSourceEdit']            = "Edit Sources";

// Settings
$GLOBALS['strSettings']             = "Settings";
$GLOBALS['strGeneralSettings']        = "General Settings";
$GLOBALS['strMainSettings']            = "Main Settings";
$GLOBALS['strAdminSettings']        = "Administration Settings";

// Product Updates
$GLOBALS['strProductUpdates']          = "Product Updates";

// Agency
$GLOBALS['strAgencyManagement']              = "Agency Management";
$GLOBALS['strAgency']                      = "Agency";
$GLOBALS['strAgencies']                   = "Agencies";
$GLOBALS['strAddAgency']                   = "Add new agency";
$GLOBALS['strAddAgency_Key']               = "Add <u>n</u>ew agency";
$GLOBALS['strTotalAgencies']               = "Total agencies";
$GLOBALS['strAgencyProperties']              = "Agency properties";
$GLOBALS['strNoAgencies']                 = "There are currently no agencies defined";
$GLOBALS['strConfirmDeleteAgency']           = "Do you really want to delete this agency?";
$GLOBALS['strHideInactiveAgencies']          = "Hide inactive agencies";
$GLOBALS['strInactiveAgenciesHidden']     = "inactive agency(ies) hidden";
$GLOBALS['strAllowAgencyEditConversions'] = "Allow this user to edit conversions";
$GLOBALS['strAllowMoreReports']           = "Allow 'More Reports' button";

// Channels
$GLOBALS['strChannel']                    = "Channel";
$GLOBALS['strChannels']                   = "Channels";
$GLOBALS['strChannelOverview']              = "Channel overview";
$GLOBALS['strChannelManagement']          = "Channel management";
$GLOBALS['strAddNewChannel']              = "Add new channel";
$GLOBALS['strAddNewChannel_Key']          = "Add <u>n</u>ew channel";
$GLOBALS['strNoChannels']                 = "There are currently no channels defined";
$GLOBALS['strEditChannelLimitations']     = "Edit channel limitations";
$GLOBALS['strChannelProperties']          = "Channel properties";
$GLOBALS['strChannelLimitations']         = "Delivery options";
$GLOBALS['strConfirmDeleteChannel']       = "Do you really want to delete this channel?";

// Tracker Variables
$GLOBALS['strVariableName']             = "Variable Name";
$GLOBALS['strVariableDescription']     = "Description";
$GLOBALS['strVariableDataType']         = "Data Type";
$GLOBALS['strVariablePurpose']       = "Purpose";
$GLOBALS['strGeneric']               = "Generic";
$GLOBALS['strBasketValue']           = "Basket value";
$GLOBALS['strNumItems']              = "Number of items";
$GLOBALS['strVariableIsUnique']      = "Dedup conversions?";
$GLOBALS['strJavascript']             = "Javascript";
$GLOBALS['strRefererQuerystring']     = "Referer Querystring";
$GLOBALS['strQuerystring']             = "Querystring";
$GLOBALS['strInteger']                 = "Integer";
$GLOBALS['strNumber']                 = "Number";
$GLOBALS['strString']                 = "String";
$GLOBALS['strTrackFollowingVars']     = "Track the following variable";
$GLOBALS['strAddVariable']             = "Add Variable";
$GLOBALS['strNoVarsToTrack']         = "No Variables to track.";
$GLOBALS['strVariableHidden']       = "Hide variable to publishers?";
$GLOBALS['strVariableRejectEmpty']  = "Reject if empty?";
$GLOBALS['strTrackingSettings']     = "Tracking settings";
$GLOBALS['strTrackerType']          = "Tracker type";
$GLOBALS['strTrackerTypeJS']        = "Track JavaScript variables";
$GLOBALS['strTrackerTypeDefault']   = "Track JavaScript variables (backwards compatible, escaping needed)";
$GLOBALS['strTrackerTypeDOM']       = "Track HTML elements using DOM";
$GLOBALS['strTrackerTypeCustom']    = "Custom JS code";
$GLOBALS['strVariableCode']         = "Javascript tracking code";


//Upload conversions 
$GLOBALS['strRecordLengthTooBig']   = 'Record length too big';
$GLOBALS['strRecordNonInt']         = 'Value needs to be numeric';
$GLOBALS['strRecordWasNotInserted'] = 'Record was not inserted';
$GLOBALS['strWrongColumnPart1']     = '<br>Error in CSV file! Column <b>';
$GLOBALS['strWrongColumnPart2']     = '</b> is not allowed for this tracker';
$GLOBALS['strMissingColumnPart1']   = '<br>Error in CSV file! Column <b>';
$GLOBALS['strMissingColumnPart2']   = '</b> is missing';
$GLOBALS['strYouHaveNoTrackers']    = 'Advertiser has no trackers!';
$GLOBALS['strYouHaveNoCampaigns']   = 'Advertiser has no campaigns!';
$GLOBALS['strYouHaveNoBanners']     = 'Campaign has no banners!';
$GLOBALS['strYouHaveNoZones']       = 'Banner not linked to any zones!';
$GLOBALS['strNoBannersDropdown']    = '--No Banners Found--';
$GLOBALS['strNoZonesDropdown']      = '--No Zones Found--';
$GLOBALS['strInsertErrorPart1']     = '<br><br><center><b> Error, ';
$GLOBALS['strInsertErrorPart2']     = 'records was not inserted! </b></center>';
$GLOBALS['strDuplicatedValue']      = 'Duplicated Value!';
$GLOBALS['strInsertCorrect']        = '<br><br><center><b> File was uploaded correctly </b></center>';
$GLOBALS['strReuploadCsvFile']      = 'Reupload CSV File';
$GLOBALS['strConfirmUpload']        = 'Confirm Upload';
$GLOBALS['strLoadedRecords']        = 'Loaded Records';
$GLOBALS['strBrokenRecords']        = 'Broken Fields in all Records';
$GLOBALS['strWrongDateFormat']      = 'Wrong Date Format';


// Password recovery
$GLOBALS['strForgotPassword']         = "Forgot your password?";
$GLOBALS['strPasswordRecovery']       = "Password recovery";
$GLOBALS['strEmailRequired']          = "E-mail is a required field";
$GLOBALS['strPwdRecEmailSent']        = "Recovery e-mail sent";
$GLOBALS['strPwdRecEmailNotFound']    = "E-mail address not found";
$GLOBALS['strPwdRecPasswordSaved']    = "The new password was saved, proceed to <a href='index.php'>login</a>";
$GLOBALS['strPwdRecWrongId']          = "Wrong ID";
$GLOBALS['strPwdRecEnterEmail']       = "Enter your e-mail address below";
$GLOBALS['strPwdRecEnterPassword']    = "Enter your new password address below";
$GLOBALS['strPwdRecResetLink']        = "Password reset link";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "%s password recovery";
$GLOBALS['strProceed']                = "Proceed &gt;";



/*-------------------------------------------------------*/
/* Keyboard shortcut assignments                         */
/*-------------------------------------------------------*/

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome']            = 'h';
$GLOBALS['keyUp']            = 'u';
$GLOBALS['keyNextItem']        = '.';
$GLOBALS['keyPreviousItem']    = ',';
$GLOBALS['keyList']            = 'l';

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch']        = 's';
$GLOBALS['keyCollapseAll']    = 'c';
$GLOBALS['keyExpandAll']    = 'e';
$GLOBALS['keyAddNew']        = 'n';
$GLOBALS['keyNext']            = 'n';
$GLOBALS['keyPrevious']        = 'p';

?>
