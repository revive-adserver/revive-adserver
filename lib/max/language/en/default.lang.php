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

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection'] = "ltr";
$GLOBALS['phpAds_TextAlignRight'] = "right";
$GLOBALS['phpAds_TextAlignLeft'] = "left";
$GLOBALS['phpAds_CharSet'] = "UTF-8";

$GLOBALS['phpAds_DecimalPoint'] = ".";
$GLOBALS['phpAds_ThousandsSeperator'] = ",";

// Date & time configuration
$GLOBALS['date_format'] = "%d-%m-%Y";
$GLOBALS['time_format'] = "%H:%M:%S";
$GLOBALS['minute_format'] = "%H:%M";
$GLOBALS['month_format'] = "%m-%Y";
$GLOBALS['day_format'] = "%d-%m";
$GLOBALS['week_format'] = "%W-%Y";
$GLOBALS['weekiso_format'] = "%V-%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate
$GLOBALS['excel_integer_formatting'] = "#,##0;-#,##0;-";
$GLOBALS['excel_decimal_formatting'] = "#,##0.000;-#,##0.000;-";

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "Home";
$GLOBALS['strHelp'] = "Help";
$GLOBALS['strStartOver'] = "Start over";
$GLOBALS['strShortcuts'] = "Shortcuts";
$GLOBALS['strActions'] = "Actions";
$GLOBALS['strAndXMore'] = "and %s more";
$GLOBALS['strAdminstration'] = "Inventory";
$GLOBALS['strMaintenance'] = "Maintenance";
$GLOBALS['strProbability'] = "Probability";
$GLOBALS['strInvocationcode'] = "Invocation Code";
$GLOBALS['strBasicInformation'] = "Basic information";
$GLOBALS['strAppendTrackerCode'] = "Append Tracker Code";
$GLOBALS['strOverview'] = "Overview";
$GLOBALS['strSearch'] = "<u>S</u>earch";
$GLOBALS['strDetails'] = "Details";
$GLOBALS['strUpdateSettings'] = "Update Settings";
$GLOBALS['strCheckForUpdates'] = "Check for updates";
$GLOBALS['strWhenCheckingForUpdates'] = "When checking for updates";
$GLOBALS['strCompact'] = "Compact";
$GLOBALS['strUser'] = "User";
$GLOBALS['strDuplicate'] = "Duplicate";
$GLOBALS['strCopyOf'] = "Copy of";
$GLOBALS['strMoveTo'] = "Move to";
$GLOBALS['strDelete'] = "Delete";
$GLOBALS['strActivate'] = "Activate";
$GLOBALS['strConvert'] = "Convert";
$GLOBALS['strRefresh'] = "Refresh";
$GLOBALS['strSaveChanges'] = "Save Changes";
$GLOBALS['strUp'] = "Up";
$GLOBALS['strDown'] = "Down";
$GLOBALS['strSave'] = "Save";
$GLOBALS['strCancel'] = "Cancel";
$GLOBALS['strBack'] = "Back";
$GLOBALS['strPrevious'] = "Previous";
$GLOBALS['strNext'] = "Next";
$GLOBALS['strYes'] = "Yes";
$GLOBALS['strNo'] = "No";
$GLOBALS['strNone'] = "None";
$GLOBALS['strCustom'] = "Custom";
$GLOBALS['strDefault'] = "Default";
$GLOBALS['strUnknown'] = "Unknown";
$GLOBALS['strUnlimited'] = "Unlimited";
$GLOBALS['strUntitled'] = "Untitled";
$GLOBALS['strAll'] = "all";
$GLOBALS['strAverage'] = "Average";
$GLOBALS['strOverall'] = "Overall";
$GLOBALS['strTotal'] = "Total";
$GLOBALS['strFrom'] = "From";
$GLOBALS['strTo'] = "to";
$GLOBALS['strAdd'] = "Add";
$GLOBALS['strLinkedTo'] = "linked to";
$GLOBALS['strDaysLeft'] = "Days left";
$GLOBALS['strCheckAllNone'] = "Check all / none";
$GLOBALS['strKiloByte'] = "KB";
$GLOBALS['strExpandAll'] = "<u>E</u>xpand all";
$GLOBALS['strCollapseAll'] = "<u>C</u>ollapse all";
$GLOBALS['strShowAll'] = "Show All";
$GLOBALS['strNoAdminInterface'] = "The admin screen has been turned off for maintenance.  This does not affect the delivery of your campaigns.";
$GLOBALS['strFieldStartDateBeforeEnd'] = "'From' date must be earlier then 'To' date";
$GLOBALS['strFieldContainsErrors'] = "The following fields contain errors:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Before you can continue you need";
$GLOBALS['strFieldFixBeforeContinue2'] = "to correct these errors.";
$GLOBALS['strMiscellaneous'] = "Miscellaneous";
$GLOBALS['strCollectedAllStats'] = "All statistics";
$GLOBALS['strCollectedToday'] = "Today";
$GLOBALS['strCollectedYesterday'] = "Yesterday";
$GLOBALS['strCollectedThisWeek'] = "This week";
$GLOBALS['strCollectedLastWeek'] = "Last week";
$GLOBALS['strCollectedThisMonth'] = "This month";
$GLOBALS['strCollectedLastMonth'] = "Last month";
$GLOBALS['strCollectedLast7Days'] = "Last 7 days";
$GLOBALS['strCollectedSpecificDates'] = "Specific dates";
$GLOBALS['strValue'] = "Value";
$GLOBALS['strWarning'] = "Warning";
$GLOBALS['strNotice'] = "Notice";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "The dashboard can not be displayed";
$GLOBALS['strNoCheckForUpdates'] = "The dashboard cannot be displayed unless the<br />check for updates setting is enabled.";
$GLOBALS['strEnableCheckForUpdates'] = "Please enable the <a href='account-settings-update.php' target='_top'>check for updates</a> setting on the<br/><a href='account-settings-update.php' target='_top'>update settings</a> page.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "code";
$GLOBALS['strDashboardSystemMessage'] = "System message";
$GLOBALS['strDashboardErrorHelp'] = "If this error repeats please describe your problem in detail and post it on <a href='http://forum.revive-adserver.com/'>forum.revive-adserver.com/</a>.";

// Priority
$GLOBALS['strPriority'] = "Priority";
$GLOBALS['strPriorityLevel'] = "Priority level";
$GLOBALS['strOverrideAds'] = "Override Campaign Advertisements";
$GLOBALS['strHighAds'] = "Contract Campaign Advertisements";
$GLOBALS['strECPMAds'] = "eCPM Campaign Advertisements";
$GLOBALS['strLowAds'] = "Remnant Campaign Advertisements";
$GLOBALS['strLimitations'] = "Limitations";
$GLOBALS['strNoLimitations'] = "No Limitations";
$GLOBALS['strCapping'] = "Capping";

// Properties
$GLOBALS['strName'] = "Name";
$GLOBALS['strSize'] = "Size";
$GLOBALS['strWidth'] = "Width";
$GLOBALS['strHeight'] = "Height";
$GLOBALS['strTarget'] = "Target";
$GLOBALS['strLanguage'] = "Language";
$GLOBALS['strDescription'] = "Description";
$GLOBALS['strVariables'] = "Variables";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "Comments";

// User access
$GLOBALS['strWorkingAs'] = "Working as";
$GLOBALS['strWorkingAs_Key'] = "<u>W</u>orking as";
$GLOBALS['strWorkingAs'] = "Working as";
$GLOBALS['strSwitchTo'] = "Switch to";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "Use the switcher's search box to find more accounts";
$GLOBALS['strWorkingFor'] = "%s for...";
$GLOBALS['strNoAccountWithXInNameFound'] = "No accounts with \"%s\" in name found";
$GLOBALS['strRecentlyUsed'] = "Recently used";
$GLOBALS['strLinkUser'] = "Add user";
$GLOBALS['strLinkUser_Key'] = "Add <u>u</u>ser";
$GLOBALS['strUsernameToLink'] = "Username of user to add";
$GLOBALS['strNewUserWillBeCreated'] = "New user will be created";
$GLOBALS['strToLinkProvideEmail'] = "To add user, provide user's email";
$GLOBALS['strToLinkProvideUsername'] = "To add user, provide username";
$GLOBALS['strUserLinkedToAccount'] = "User has been added to account";
$GLOBALS['strUserAccountUpdated'] = "User account updated";
$GLOBALS['strUserUnlinkedFromAccount'] = "User has been removed from account";
$GLOBALS['strUserWasDeleted'] = "User has been deleted";
$GLOBALS['strUserNotLinkedWithAccount'] = "Such user is not linked with account";
$GLOBALS['strCantDeleteOneAdminUser'] = "You can't delete a user. At least one user needs to be linked with admin account.";
$GLOBALS['strLinkUserHelp'] = "To add an <b>existing user</b>, type the %1\$s and click %2\$s <br />To add a <b>new user</b>, type the desired %1\$s and click %2\$s";
$GLOBALS['strLinkUserHelpUser'] = "username";
$GLOBALS['strLinkUserHelpEmail'] = "email address";
$GLOBALS['strLastLoggedIn'] = "Last logged in";
$GLOBALS['strDateLinked'] = "Date linked";

// Login & Permissions
$GLOBALS['strUserAccess'] = "User Access";
$GLOBALS['strAdminAccess'] = "Admin Access";
$GLOBALS['strUserProperties'] = "User Properties";
$GLOBALS['strPermissions'] = "Permissions";
$GLOBALS['strAuthentification'] = "Authentication";
$GLOBALS['strWelcomeTo'] = "Welcome to";
$GLOBALS['strEnterUsername'] = "Enter your username and password to log in";
$GLOBALS['strEnterBoth'] = "Please enter both your username and password";
$GLOBALS['strEnableCookies'] = "You need to enable cookies before you can use {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "Session cookie error, please log in again";
$GLOBALS['strLogin'] = "Login";
$GLOBALS['strLogout'] = "Logout";
$GLOBALS['strUsername'] = "Username";
$GLOBALS['strPassword'] = "Password";
$GLOBALS['strPasswordRepeat'] = "Repeat password";
$GLOBALS['strAccessDenied'] = "Access denied";
$GLOBALS['strUsernameOrPasswordWrong'] = "The username and/or password were not correct. Please try again.";
$GLOBALS['strPasswordWrong'] = "The password is not correct";
$GLOBALS['strNotAdmin'] = "Your account does not have the required permissions to use this feature, you can log into another account to use it.";
$GLOBALS['strDuplicateClientName'] = "The username you provided already exists, please use a different username.";
$GLOBALS['strInvalidPassword'] = "The new password is invalid, please use a different password.";
$GLOBALS['strInvalidEmail'] = "The email is not correctly formatted, please put a correct email address.";
$GLOBALS['strNotSamePasswords'] = "The two passwords you supplied are not the same";
$GLOBALS['strRepeatPassword'] = "Repeat Password";
$GLOBALS['strDeadLink'] = "Your link is invalid.";
$GLOBALS['strNoPlacement'] = "Selected campaign does not exist. Try this <a href='{link}'>link</a> instead";
$GLOBALS['strNoAdvertiser'] = "Selected advertiser does not exist. Try this <a href='{link}'>link</a> instead";

// General advertising
$GLOBALS['strRequests'] = "Requests";
$GLOBALS['strImpressions'] = "Impressions";
$GLOBALS['strClicks'] = "Clicks";
$GLOBALS['strConversions'] = "Conversions";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCTR'] = "Click-Through Ratio";
$GLOBALS['strTotalClicks'] = "Total Clicks";
$GLOBALS['strTotalConversions'] = "Total Conversions";
$GLOBALS['strDateTime'] = "Date Time";
$GLOBALS['strTrackerID'] = "Tracker ID";
$GLOBALS['strTrackerName'] = "Tracker Name";
$GLOBALS['strTrackerImageTag'] = "Image Tag";
$GLOBALS['strTrackerJsTag'] = "Javascript Tag";
$GLOBALS['strTrackerAlwaysAppend'] = "Always display appended code, even if no conversion is recorded by the tracker?";
$GLOBALS['strBanners'] = "Banners";
$GLOBALS['strCampaigns'] = "Campaigns";
$GLOBALS['strCampaignID'] = "Campaign ID";
$GLOBALS['strCampaignName'] = "Campaign Name";
$GLOBALS['strCountry'] = "Country";
$GLOBALS['strStatsAction'] = "Action";
$GLOBALS['strWindowDelay'] = "Window delay";
$GLOBALS['strStatsVariables'] = "Variables";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Tenancy";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strFinanceCR'] = "CR";

// Time and date related
$GLOBALS['strDate'] = "Date";
$GLOBALS['strDay'] = "Day";
$GLOBALS['strDays'] = "Days";
$GLOBALS['strWeek'] = "Week";
$GLOBALS['strWeeks'] = "Weeks";
$GLOBALS['strSingleMonth'] = "Month";
$GLOBALS['strMonths'] = "Months";
$GLOBALS['strDayOfWeek'] = "Day of week";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = array();
}
$GLOBALS['strDayFullNames'][0] = 'Sunday';
$GLOBALS['strDayFullNames'][1] = 'Monday';
$GLOBALS['strDayFullNames'][2] = 'Tuesday';
$GLOBALS['strDayFullNames'][3] = 'Wednesday';
$GLOBALS['strDayFullNames'][4] = 'Thursday';
$GLOBALS['strDayFullNames'][5] = 'Friday';
$GLOBALS['strDayFullNames'][6] = 'Saturday';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = array();
}
$GLOBALS['strDayShortCuts'][0] = 'Su';
$GLOBALS['strDayShortCuts'][1] = 'Mo';
$GLOBALS['strDayShortCuts'][2] = 'Tu';
$GLOBALS['strDayShortCuts'][3] = 'We';
$GLOBALS['strDayShortCuts'][4] = 'Th';
$GLOBALS['strDayShortCuts'][5] = 'Fr';
$GLOBALS['strDayShortCuts'][6] = 'Sa';

$GLOBALS['strHour'] = "Hour";
$GLOBALS['strSeconds'] = "seconds";
$GLOBALS['strMinutes'] = "minutes";
$GLOBALS['strHours'] = "hours";

// Advertiser
$GLOBALS['strClient'] = "Advertiser";
$GLOBALS['strClients'] = "Advertisers";
$GLOBALS['strClientsAndCampaigns'] = "Advertisers & Campaigns";
$GLOBALS['strAddClient'] = "Add new advertiser";
$GLOBALS['strClientProperties'] = "Advertiser Properties";
$GLOBALS['strClientHistory'] = "Advertiser History";
$GLOBALS['strNoClients'] = "There are currently no advertisers defined. To create a campaign, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
$GLOBALS['strConfirmDeleteClient'] = "Do you really want to delete this advertiser?";
$GLOBALS['strConfirmDeleteClients'] = "Do you really want to delete the selected advertisers?";
$GLOBALS['strHideInactive'] = "Hide inactive";
$GLOBALS['strInactiveAdvertisersHidden'] = "inactive advertiser(s) hidden";
$GLOBALS['strAdvertiserSignup'] = "Advertiser Sign Up";
$GLOBALS['strAdvertiserCampaigns'] = "Advertiser's Campaigns";

// Advertisers properties
$GLOBALS['strContact'] = "Contact";
$GLOBALS['strContactName'] = "Contact Name";
$GLOBALS['strEMail'] = "Email";
$GLOBALS['strSendAdvertisingReport'] = "Email campaign delivery reports";
$GLOBALS['strNoDaysBetweenReports'] = "Number of days between campaign delivery reports";
$GLOBALS['strSendDeactivationWarning'] = "Email when a campaign is automatically activated/deactivated";
$GLOBALS['strAllowClientModifyBanner'] = "Allow this user to modify their own banners";
$GLOBALS['strAllowClientDisableBanner'] = "Allow this user to deactivate their own banners";
$GLOBALS['strAllowClientActivateBanner'] = "Allow this user to activate their own banners";
$GLOBALS['strAllowCreateAccounts'] = "Allow this user to create new accounts";
$GLOBALS['strAdvertiserLimitation'] = "Display only one banner from this advertiser on a web page";
$GLOBALS['strAllowAuditTrailAccess'] = "Allow this user to access the audit trail";

// Campaign
$GLOBALS['strCampaign'] = "Campaign";
$GLOBALS['strCampaigns'] = "Campaigns";
$GLOBALS['strAddCampaign'] = "Add new campaign";
$GLOBALS['strAddCampaign_Key'] = "Add <u>n</u>ew campaign";
$GLOBALS['strCampaignForAdvertiser'] = "for advertiser";
$GLOBALS['strLinkedCampaigns'] = "Linked Campaigns";
$GLOBALS['strCampaignProperties'] = "Campaign Properties";
$GLOBALS['strCampaignOverview'] = "Campaign Overview";
$GLOBALS['strCampaignHistory'] = "Campaign History";
$GLOBALS['strNoCampaigns'] = "There are currently no campaigns defined for this advertiser.";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "There are currently no campaigns defined, because there are no advertisers. To create a campaign, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
$GLOBALS['strConfirmDeleteCampaign'] = "Do you really want to delete this campaign?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Do you really want to delete the selected campaigns?";
$GLOBALS['strShowParentAdvertisers'] = "Show parent advertisers";
$GLOBALS['strHideParentAdvertisers'] = "Hide parent advertisers";
$GLOBALS['strHideInactiveCampaigns'] = "Hide inactive campaigns";
$GLOBALS['strInactiveCampaignsHidden'] = "inactive campaign(s) hidden";
$GLOBALS['strPriorityInformation'] = "Priority in relation to other campaigns";
$GLOBALS['strECPMInformation'] = "eCPM prioritization";
$GLOBALS['strRemnantEcpmDescription'] = "eCPM is automatically calculated based on this campaign's performance.<br />It will be used to prioritise Remnant campaigns relative to each other.";
$GLOBALS['strEcpmMinImpsDescription'] = "Set this to your desired minium basis on which to calculate this campaign's eCPM.";
$GLOBALS['strHiddenCampaign'] = "Campaign";
$GLOBALS['strHiddenAd'] = "Advertisement";
$GLOBALS['strHiddenAdvertiser'] = "Advertiser";
$GLOBALS['strHiddenTracker'] = "Tracker";
$GLOBALS['strHiddenWebsite'] = "Website";
$GLOBALS['strHiddenZone'] = "Zone";
$GLOBALS['strCampaignDelivery'] = "Campaign delivery";
$GLOBALS['strCompanionPositioning'] = "Companion positioning";
$GLOBALS['strSelectUnselectAll'] = "Select / Unselect All";
$GLOBALS['strCampaignsOfAdvertiser'] = "of"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'
$GLOBALS['strShowCappedNoCookie'] = "Show capped ads if cookies are disabled";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "Calculated for all campaigns";
$GLOBALS['strCalculatedForThisCampaign'] = "Calculated for this campaign";
$GLOBALS['strLinkingZonesProblem'] = "Problem occurred when linking zones";
$GLOBALS['strUnlinkingZonesProblem'] = "Problem occurred when unlinking zones";
$GLOBALS['strZonesLinked'] = "zone(s) linked";
$GLOBALS['strZonesUnlinked'] = "zone(s) unlinked";
$GLOBALS['strZonesSearch'] = "Search";
$GLOBALS['strZonesSearchTitle'] = "Search zones and websites by name";
$GLOBALS['strNoWebsitesAndZones'] = "No websites and zones";
$GLOBALS['strNoWebsitesAndZonesText'] = "with \"%s\" in name";
$GLOBALS['strToLink'] = "to link";
$GLOBALS['strToUnlink'] = "to unlink";
$GLOBALS['strLinked'] = "Linked";
$GLOBALS['strAvailable'] = "Available";
$GLOBALS['strShowing'] = "Showing";
$GLOBALS['strEditZone'] = "Edit zone";
$GLOBALS['strEditWebsite'] = "Edit website";


// Campaign properties
$GLOBALS['strDontExpire'] = "Don't expire";
$GLOBALS['strActivateNow'] = "Start immediately";
$GLOBALS['strSetSpecificDate'] = "Set specific date";
$GLOBALS['strLow'] = "Low";
$GLOBALS['strHigh'] = "High";
$GLOBALS['strExpirationDate'] = "End date";
$GLOBALS['strExpirationDateComment'] = "Campaign will finish at the end of this day";
$GLOBALS['strActivationDate'] = "Start date";
$GLOBALS['strActivationDateComment'] = "Campaign will commence at the start of this day";
$GLOBALS['strImpressionsRemaining'] = "Impressions Remaining";
$GLOBALS['strClicksRemaining'] = "Clicks Remaining";
$GLOBALS['strConversionsRemaining'] = "Conversions Remaining";
$GLOBALS['strImpressionsBooked'] = "Impressions Booked";
$GLOBALS['strClicksBooked'] = "Clicks Booked";
$GLOBALS['strConversionsBooked'] = "Conversions Booked";
$GLOBALS['strCampaignWeight'] = "Set the campaign weight";
$GLOBALS['strAnonymous'] = "Hide the advertiser and websites of this campaign.";
$GLOBALS['strTargetPerDay'] = "per day.";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "The type of this campaign has been set to Remnant,
but the weight is set to zero or it has not been
specified. This will cause the campaign to be
deactivated and its banners won't be delivered
until the weight has been set to a valid number.

Are you sure you want to continue?";
$GLOBALS['strCampaignWarningEcpmNoRevenue'] = "This campaign uses eCPM optimisation
but the 'revenue' is set to zero or it has not been specified.
This will cause the campaign to be deactivated
and its banners won't be delivered until the
revenue has been set to a valid number.

Are you sure you want to continue?";
$GLOBALS['strCampaignWarningOverrideNoWeight'] = "The type of this campaign has been set to Override,
but the weight is set to zero or it has not been
specified. This will cause the campaign to be
deactivated and its banners won't be delivered
until the weight has been set to a valid number.

Are you sure you want to continue?";
$GLOBALS['strCampaignWarningNoTarget'] = "The type of this campaign has been set to Contract,
but Limit per day is not specified.
This will cause the campaign to be deactivated and
its banners won't be delivered until a valid Limit per day has been set.

Are you sure you want to continue?";
$GLOBALS['strCampaignStatusPending'] = "Pending";
$GLOBALS['strCampaignStatusInactive'] = "Inactive";
$GLOBALS['strCampaignStatusRunning'] = "Running";
$GLOBALS['strCampaignStatusPaused'] = "Paused";
$GLOBALS['strCampaignStatusAwaiting'] = "Awaiting";
$GLOBALS['strCampaignStatusExpired'] = "Completed";
$GLOBALS['strCampaignStatusApproval'] = "Awaiting approval »";
$GLOBALS['strCampaignStatusRejected'] = "Rejected";
$GLOBALS['strCampaignStatusAdded'] = "Added";
$GLOBALS['strCampaignStatusStarted'] = "Started";
$GLOBALS['strCampaignStatusRestarted'] = "Restarted";
$GLOBALS['strCampaignStatusDeleted'] = "Deleted";
$GLOBALS['strCampaignType'] = "Campaign type";
$GLOBALS['strType'] = "Type";
$GLOBALS['strContract'] = "Contract";
$GLOBALS['strOverride'] = "Override";
$GLOBALS['strOverrideInfo'] = "Override campaigns are a special campaign type specifically to
    override (i.e. take priority over) Remnant and Contract campaigns. Override campaigns are generally used with
    specific targeting and/or capping rules to ensure that the campaign banners are always displayed in certain
    locations, to certain users, and perhaps a certain number of times, as part of a specific promotion. (This campaign
    type was previously known as 'Contract (Exclusive)'.)";
$GLOBALS['strStandardContract'] = "Contract";
$GLOBALS['strStandardContractInfo'] = "Contract campaigns are for smoothly delivering the impressions
    required to achieve a specified time-critical performance requirement. That is, Contract campaigns are for when
    an advertiser has paid specifically to have a given number of impressions, clicks and/or conversions to be
    achieved either between two dates, or per day.";
$GLOBALS['strRemnant'] = "Remnant";
$GLOBALS['strRemnantInfo'] = "The default campaign type. Remnant campaigns have lots of different
    delivery options, and you should ideally always have at least one Remnant campaign linked to every zone, to ensure
    that there is always something to show. Use Remnant campaigns to display house banners, ad-network banners, or even
    direct advertising that has been sold, but where there is not a time-critical performance requirement for the
    campaign to adhere to.";
$GLOBALS['strECPMInfo'] = "This is a standard campaign which can be constrained with either an end date or a specific limit. Based on current settings it will be prioritised using eCPM.";
$GLOBALS['strPricing'] = "Pricing";
$GLOBALS['strPricingModel'] = "Pricing model";
$GLOBALS['strSelectPricingModel'] = "-- select model --";
$GLOBALS['strRatePrice'] = "Rate / Price";
$GLOBALS['strMinimumImpressions'] = "Minimum daily impressions";
$GLOBALS['strLimit'] = "Limit";
$GLOBALS['strLowExclusiveDisabled'] = "You cannot change this campaign to Remnant or Exclusive, since both an end date and either of impressions/clicks/conversions limit are set. <br>In order to change type, you need to set no expiry date or remove limits.";
$GLOBALS['strCannotSetBothDateAndLimit'] = "You cannot set both an end date and limit for a Remnant or Exclusive campaign.<br>If you need to set both an end date and limit impressions/clicks/conversions please use a non-exclusive Contract campaign.";
$GLOBALS['strWhyDisabled'] = "why is it disabled?";
$GLOBALS['strBackToCampaigns'] = "Back to campaigns";
$GLOBALS['strCampaignBanners'] = "Campaign's banners";
$GLOBALS['strCookies'] = "Cookies";

// Tracker
$GLOBALS['strTracker'] = "Tracker";
$GLOBALS['strTrackers'] = "Trackers";
$GLOBALS['strTrackerPreferences'] = "Tracker Preferences";
$GLOBALS['strAddTracker'] = "Add new tracker";
$GLOBALS['strTrackerForAdvertiser'] = "for advertiser";
$GLOBALS['strNoTrackers'] = "There are currently no trackers defined for this advertiser";
$GLOBALS['strConfirmDeleteTrackers'] = "Do you really want to delete all selected trackers?";
$GLOBALS['strConfirmDeleteTracker'] = "Do you really want to delete this tracker?";
$GLOBALS['strTrackerProperties'] = "Tracker Properties";
$GLOBALS['strDefaultStatus'] = "Default Status";
$GLOBALS['strStatus'] = "Status";
$GLOBALS['strLinkedTrackers'] = "Linked Trackers";
$GLOBALS['strTrackerInformation'] = "Tracker Information";
$GLOBALS['strConversionWindow'] = "Conversion window";
$GLOBALS['strUniqueWindow'] = "Unique window";
$GLOBALS['strClick'] = "Click";
$GLOBALS['strView'] = "View";
$GLOBALS['strArrival'] = "Arrival";
$GLOBALS['strManual'] = "Manual";
$GLOBALS['strImpression'] = "Impression";
$GLOBALS['strConversionType'] = "Conversion Type";
$GLOBALS['strLinkCampaignsByDefault'] = "Link newly created campaigns by default";
$GLOBALS['strBackToTrackers'] = "Back to trackers";
$GLOBALS['strIPAddress'] = "IP Address";

// Banners (General)
$GLOBALS['strBanner'] = "Banner";
$GLOBALS['strBanners'] = "Banners";
$GLOBALS['strAddBanner'] = "Add new banner";
$GLOBALS['strAddBanner_Key'] = "Add <u>n</u>ew banner";
$GLOBALS['strBannerToCampaign'] = "to campaign";
$GLOBALS['strShowBanner'] = "Show banner";
$GLOBALS['strBannerProperties'] = "Banner Properties";
$GLOBALS['strBannerHistory'] = "Banner History";
$GLOBALS['strNoBanners'] = "There are currently no banners defined for this campaign.";
$GLOBALS['strNoBannersAddCampaign'] = "There are currently no banners defined, because there are no campaigns. To create a banner, <a href='campaign-edit.php?clientid=%s'>add a new campaign</a> first.";
$GLOBALS['strNoBannersAddAdvertiser'] = "There are currently no banners defined, because there are no advertisers. To create a banner, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
$GLOBALS['strConfirmDeleteBanner'] = "Deleting this banner will also remove its statistics.\\nDo you really want to delete this banner?";
$GLOBALS['strConfirmDeleteBanners'] = "Deleting these banners will also remove their statistics.\\nDo you really want to delete the selected banners?";
$GLOBALS['strShowParentCampaigns'] = "Show parent campaigns";
$GLOBALS['strHideParentCampaigns'] = "Hide parent campaigns";
$GLOBALS['strHideInactiveBanners'] = "Hide inactive banners";
$GLOBALS['strInactiveBannersHidden'] = "inactive banner(s) hidden";
$GLOBALS['strWarningMissing'] = "Warning, possibly missing ";
$GLOBALS['strWarningMissingClosing'] = " closing tag '>'";
$GLOBALS['strWarningMissingOpening'] = " opening tag '<'";
$GLOBALS['strSubmitAnyway'] = "Submit Anyway";
$GLOBALS['strBannersOfCampaign'] = "in"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "Banner Preferences";
$GLOBALS['strCampaignPreferences'] = "Campaign Preferences";
$GLOBALS['strDefaultBanners'] = "Default Banners";
$GLOBALS['strDefaultBannerUrl'] = "Default Image URL";
$GLOBALS['strDefaultBannerDestination'] = "Default Destination URL";
$GLOBALS['strAllowedBannerTypes'] = "Allowed Banner Types";
$GLOBALS['strTypeSqlAllow'] = "Allow SQL Local Banners";
$GLOBALS['strTypeWebAllow'] = "Allow Webserver Local Banners";
$GLOBALS['strTypeUrlAllow'] = "Allow External Banners";
$GLOBALS['strTypeHtmlAllow'] = "Allow HTML Banners";
$GLOBALS['strTypeTxtAllow'] = "Allow Text Ads";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Please choose the type of the banner";
$GLOBALS['strMySQLBanner'] = "Upload a local banner to the database";
$GLOBALS['strWebBanner'] = "Upload a local banner to the webserver";
$GLOBALS['strURLBanner'] = "Link an external banner";
$GLOBALS['strHTMLBanner'] = "Create an HTML banner";
$GLOBALS['strTextBanner'] = "Create a Text banner";
$GLOBALS['strAlterHTML'] = "Alter HTML to enable click tracking for:";
$GLOBALS['strIframeFriendly'] = "This banner can be safely displayed inside an iframe (e.g. is not expandable)";
$GLOBALS['strUploadOrKeep'] = "Do you wish to keep your <br />existing image, or do you <br />want to upload another?";
$GLOBALS['strNewBannerFile'] = "Select the image you want <br />to use for this banner<br /><br />";
$GLOBALS['strNewBannerFileAlt'] = "Select a backup image you <br />want to use in case browsers<br />don't support rich media<br /><br />";
$GLOBALS['strNewBannerURL'] = "Image URL (incl. http://)";
$GLOBALS['strURL'] = "Destination URL (incl. http://)";
$GLOBALS['strKeyword'] = "Keywords";
$GLOBALS['strTextBelow'] = "Text below image";
$GLOBALS['strWeight'] = "Weight";
$GLOBALS['strAlt'] = "Alt text";
$GLOBALS['strStatusText'] = "Status text";
$GLOBALS['strBannerWeight'] = "Banner weight";
$GLOBALS['strAdserverTypeGeneric'] = "Generic HTML Banner";
$GLOBALS['strDoNotAlterHtml'] = "Do not alter HTML";
$GLOBALS['strGenericOutputAdServer'] = "Generic";
$GLOBALS['strSwfTransparency'] = "Allow transparent background";
$GLOBALS['strBackToBanners'] = "Back to banners";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "Always prepend the following HTML code to this banner";
$GLOBALS['strBannerAppendHTML'] = "Always append the following HTML code to this banner";

// Banner (swf)
$GLOBALS['strCheckSWF'] = "Check for hard-coded links inside the Flash file";
$GLOBALS['strConvertSWFLinks'] = "Convert Flash links";
$GLOBALS['strHardcodedLinks'] = "Hard-coded links";
$GLOBALS['strConvertSWF'] = "<br />The Flash file you just uploaded contains hard-coded urls. {$PRODUCT_NAME} won't be able to track the number of Clicks for this banner unless you convert these hard-coded urls. Below you will find a list of all urls inside the Flash file. If you want to convert the urls, simply click <b>Convert</b>, otherwise click <b>Cancel</b>.<br /><br />Please note: if you click <b>Convert</b> the Flash file you just uploaded will be physically altered. <br />Please keep a backup of the original file. Regardless of in which version this banner was created, the resulting file will need the Flash 4 player (or higher) to display correctly.<br /><br />";
$GLOBALS['strCompressSWF'] = "Compress SWF file for faster downloading (Flash 6 player required)";
$GLOBALS['strOverwriteSource'] = "Overwrite source parameter";

// Display limitations
$GLOBALS['strModifyBannerAcl'] = "Delivery Options";
$GLOBALS['strACL'] = "Delivery";
$GLOBALS['strACLAdd'] = "Add delivery limitation";
$GLOBALS['strNoLimitations'] = "No limitations";
$GLOBALS['strApplyLimitationsTo'] = "Apply limitations to";
$GLOBALS['strAllBannersInCampaign'] = "All banners in this campaign";
$GLOBALS['strRemoveAllLimitations'] = "Remove all limitations";
$GLOBALS['strEqualTo'] = "is equal to";
$GLOBALS['strDifferentFrom'] = "is different from";
$GLOBALS['strLaterThan'] = "is later than";
$GLOBALS['strLaterThanOrEqual'] = "is later than or equal to";
$GLOBALS['strEarlierThan'] = "is earlier than";
$GLOBALS['strEarlierThanOrEqual'] = "is earlier than or equal to";
$GLOBALS['strContains'] = "contains";
$GLOBALS['strNotContains'] = "doesn't contain";
$GLOBALS['strGreaterThan'] = "is greater than";
$GLOBALS['strLessThan'] = "is less than";
$GLOBALS['strAND'] = "AND";                          // logical operator
$GLOBALS['strOR'] = "OR";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Only display this banner when:";
$GLOBALS['strWeekDays'] = "Weekdays";
$GLOBALS['strTime'] = "Time";
$GLOBALS['strDomain'] = "Domain";
$GLOBALS['strSource'] = "Source";
$GLOBALS['strBrowser'] = "Browser";
$GLOBALS['strOS'] = "OS";
$GLOBALS['strDeliveryLimitations'] = "Delivery Limitations";

$GLOBALS['strDeliveryCappingReset'] = "Reset view counters after:";
$GLOBALS['strDeliveryCappingTotal'] = "in total";
$GLOBALS['strDeliveryCappingSession'] = "per session";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingBanner']['limit'] = "Limit banner views to:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingCampaign']['limit'] = "Limit campaign views to:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingZone']['limit'] = "Limit zone views to:";

// Website
$GLOBALS['strAffiliate'] = "Website";
$GLOBALS['strAffiliates'] = "Websites";
$GLOBALS['strAffiliatesAndZones'] = "Websites & Zones";
$GLOBALS['strAddNewAffiliate'] = "Add new website";
$GLOBALS['strAffiliateProperties'] = "Website Properties";
$GLOBALS['strAffiliateHistory'] = "Website History";
$GLOBALS['strNoAffiliates'] = "There are currently no websites defined. To create a zone, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strConfirmDeleteAffiliate'] = "Do you really want to delete this website?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Do you really want to delete the selected websites?";
$GLOBALS['strInactiveAffiliatesHidden'] = "inactive website(s) hidden";
$GLOBALS['strShowParentAffiliates'] = "Show parent websites";
$GLOBALS['strHideParentAffiliates'] = "Hide parent websites";

// Website (properties)
$GLOBALS['strWebsite'] = "Website";
$GLOBALS['strWebsiteURL'] = "Website URL";
$GLOBALS['strAllowAffiliateModifyZones'] = "Allow this user to modify their own zones";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Allow this user to link banners to their own zones";
$GLOBALS['strAllowAffiliateAddZone'] = "Allow this user to define new zones";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Allow this user to delete existing zones";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Allow this user to generate invocation code";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "Postcode";
$GLOBALS['strCountry'] = "Country";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Website's zones";

// Zone
$GLOBALS['strZone'] = "Zone";
$GLOBALS['strZones'] = "Zones";
$GLOBALS['strAddNewZone'] = "Add new zone";
$GLOBALS['strAddNewZone_Key'] = "Add <u>n</u>ew zone";
$GLOBALS['strZoneToWebsite'] = "to website";
$GLOBALS['strLinkedZones'] = "Linked Zones";
$GLOBALS['strAvailableZones'] = "Available Zones";
$GLOBALS['strLinkingNotSuccess'] = "Linking not successful, please try again";
$GLOBALS['strZoneProperties'] = "Zone Properties";
$GLOBALS['strZoneHistory'] = "Zone History";
$GLOBALS['strNoZones'] = "There are currently no zones defined for this website.";
$GLOBALS['strNoZonesAddWebsite'] = "There are currently no zones defined, because there are no websites. To create a zone, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strConfirmDeleteZone'] = "Do you really want to delete this zone?";
$GLOBALS['strConfirmDeleteZones'] = "Do you really want to delete the selected zones?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "There are campaigns still linked to this zone, if you delete it these will not be able to run and you will not be paid for them.";
$GLOBALS['strZoneType'] = "Zone type";
$GLOBALS['strBannerButtonRectangle'] = "Banner, Button or Rectangle";
$GLOBALS['strInterstitial'] = "Interstitial or Floating DHTML";
$GLOBALS['strPopup'] = "Popup";
$GLOBALS['strTextAdZone'] = "Text ad";
$GLOBALS['strEmailAdZone'] = "Email/Newsletter zone";
$GLOBALS['strZoneVideoInstream'] = "Inline Video ad";
$GLOBALS['strZoneVideoOverlay'] = "Overlay Video ad";
$GLOBALS['strShowMatchingBanners'] = "Show matching banners";
$GLOBALS['strHideMatchingBanners'] = "Hide matching banners";
$GLOBALS['strBannerLinkedAds'] = "Banners linked to the zone";
$GLOBALS['strCampaignLinkedAds'] = "Campaigns linked to the zone";
$GLOBALS['strInactiveZonesHidden'] = "inactive zone(s) hidden";
$GLOBALS['strWarnChangeZoneType'] = "Changing the zone type to text or email will unlink all banners/campaigns due to restrictions of these zone types
                                                <ul>
                                                    <li>Text zones can only be linked to text ads</li>
                                                    <li>Email zone campaigns can only have one active banner at a time</li>
                                                </ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Changing the zone size will unlink any banners that are not the new size, and will add any banners from linked campaigns which are the new size';
$GLOBALS['strWarnChangeBannerSize'] = 'Changing the banner size will unlink this banner from any zones that are not the new size, and if this banner\'s <strong>campaign</strong> is linked to a zone of the new size, this banner will be automatically linked';
$GLOBALS['strWarnBannerReadonly'] = 'This banner is read-only because an extension has been disabled. Contact your system administrator for more information.';
$GLOBALS['strZonesOfWebsite'] = 'in'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "Back to zones";

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "IAB Full Banner (468 x 60)";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "IAB Skyscraper (120 x 600)";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "IAB Leaderboard (728 x 90)";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "IAB Button 1 (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "IAB Button 2 (120 x 60)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "IAB Half Banner (234 x 60)";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "IAB Micro Bar (88 x 31)";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "IAB Square Button (125 x 125)";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "IAB Rectangle (180 x 150)";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "IAB Square Pop-up (250 x 250)";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "IAB Vertical Banner (120 x 240)";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "IAB Medium Rectangle (300 x 250)";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "IAB Large Rectangle (336 x 280)";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "IAB Vertical Rectangle (240 x 400)";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "IAB Wide Skyscraper (160 x 600)";
$GLOBALS['strIab']['IAB_Pop-Under(720x300)'] = "IAB Pop-Under (720 x 300)";
$GLOBALS['strIab']['IAB_3:1Rectangle(300x100)'] = "IAB 3:1 Rectangle (300 x 100)";

// Advanced zone settings
$GLOBALS['strAdvanced'] = "Advanced";
$GLOBALS['strChainSettings'] = "Chain settings";
$GLOBALS['strZoneNoDelivery'] = "If no banners from this zone <br />can be delivered, try to...";
$GLOBALS['strZoneStopDelivery'] = "Stop delivery and don't show a banner";
$GLOBALS['strZoneOtherZone'] = "Display the selected zone instead";
$GLOBALS['strZoneAppend'] = "Always append the following HTML code to banners displayed by this zone";
$GLOBALS['strAppendSettings'] = "Append and prepend settings";
$GLOBALS['strZonePrependHTML'] = "Always prepend the following HTML code to banners displayed by this zone";
$GLOBALS['strZoneAppendNoBanner'] = "Prepend/Append even if no banner delivered";
$GLOBALS['strZoneAppendHTMLCode'] = "HTML code";
$GLOBALS['strZoneAppendZoneSelection'] = "Popup or interstitial";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "All the banners linked to the selected zone are currently not active. <br />This is the zone chain that will be followed:";
$GLOBALS['strZoneProbNullPri'] = "There are no active banners linked to this zone.";
$GLOBALS['strZoneProbListChainLoop'] = "Following the zone chain would cause a circular loop. Delivery for this zone is halted.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Please choose what to link to this zone";
$GLOBALS['strLinkedBanners'] = "Link individual banners";
$GLOBALS['strCampaignDefaults'] = "Link banners by parent campaign";
$GLOBALS['strLinkedCategories'] = "Link banners by category";
$GLOBALS['strWithXBanners'] = "%d banner(s)";
$GLOBALS['strRawQueryString'] = "Keyword";
$GLOBALS['strIncludedBanners'] = "Linked Banners";
$GLOBALS['strMatchingBanners'] = "{count} matching banners";
$GLOBALS['strNoCampaignsToLink'] = "There are currently no campaigns available which can be linked to this zone";
$GLOBALS['strNoTrackersToLink'] = "There are currently no trackers available which can be linked to this campaign";
$GLOBALS['strNoZonesToLinkToCampaign'] = "There are no zones available to which this campaign can be linked";
$GLOBALS['strSelectBannerToLink'] = "Select the banner you would like to link to this zone:";
$GLOBALS['strSelectCampaignToLink'] = "Select the campaign you would like to link to this zone:";
$GLOBALS['strSelectAdvertiser'] = "Select Advertiser";
$GLOBALS['strSelectPlacement'] = "Select Campaign";
$GLOBALS['strSelectAd'] = "Select Banner";
$GLOBALS['strSelectPublisher'] = "Select Website";
$GLOBALS['strSelectZone'] = "Select Zone";
$GLOBALS['strConnectionType'] = "Type";
$GLOBALS['strStatusPending'] = "Pending";
$GLOBALS['strStatusApproved'] = "Approved";
$GLOBALS['strStatusDisapproved'] = "Disapproved";
$GLOBALS['strStatusDuplicate'] = "Duplicate";
$GLOBALS['strStatusOnHold'] = "On Hold";
$GLOBALS['strStatusIgnore'] = "Ignore";
$GLOBALS['strConnectionType'] = "Type";
$GLOBALS['strConnTypeSale'] = "Sale";
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Signup";
$GLOBALS['strShortcutEditStatuses'] = "Edit statuses";
$GLOBALS['strShortcutShowStatuses'] = "Show statuses";

// Statistics
$GLOBALS['strStats'] = "Statistics";
$GLOBALS['strNoStats'] = "There are currently no statistics available";
$GLOBALS['strNoStatsForPeriod'] = "There are currently no statistics available for the period %s to %s";
$GLOBALS['strGlobalHistory'] = "Global History";
$GLOBALS['strDailyHistory'] = "Daily history";
$GLOBALS['strDailyStats'] = "Daily statistics";
$GLOBALS['strWeeklyHistory'] = "Weekly history";
$GLOBALS['strMonthlyHistory'] = "Monthly history";
$GLOBALS['strTotalThisPeriod'] = "Total this period";
$GLOBALS['strPublisherDistribution'] = "Website Distribution";
$GLOBALS['strCampaignDistribution'] = "Campaign Distribution";
$GLOBALS['strViewBreakdown'] = "View by";
$GLOBALS['strBreakdownByDay'] = "Day";
$GLOBALS['strBreakdownByWeek'] = "Week";
$GLOBALS['strBreakdownByMonth'] = "Month";
$GLOBALS['strBreakdownByDow'] = "Day of week";
$GLOBALS['strBreakdownByHour'] = "Hour";
$GLOBALS['strItemsPerPage'] = "Items per page";
$GLOBALS['strDistributionHistoryCampaign'] = "Distribution history (Campaign)";
$GLOBALS['strDistributionHistoryBanner'] = "Distribution history (Banner)";
$GLOBALS['strDistributionHistoryWebsite'] = "Distribution history (Website)";
$GLOBALS['strDistributionHistoryZone'] = "Distribution history (Zone)";
$GLOBALS['strShowGraphOfStatistics'] = "Show <u>G</u>raph of Statistics";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>xport Statistics to Excel";
$GLOBALS['strGDnotEnabled'] = "You must have GD enabled in PHP to display graphs. <br />Please see <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> for more information, including how to install GD on your server.";
$GLOBALS['strStatsArea'] = "Area";

// Expiration
$GLOBALS['strNoExpiration'] = "No expiration date set";
$GLOBALS['strEstimated'] = "Estimated expiration date";
$GLOBALS['strNoExpirationEstimation'] = "No expiration estimated yet";
$GLOBALS['strDaysAgo'] = "days ago";
$GLOBALS['strCampaignStop'] = "Campaign stop";

// Reports
$GLOBALS['strAdvancedReports'] = "Advanced Reports";
$GLOBALS['strStartDate'] = "Start Date";
$GLOBALS['strEndDate'] = "End Date";
$GLOBALS['strPeriod'] = "Period";
$GLOBALS['strLimitations'] = "Limitations";
$GLOBALS['strWorksheets'] = "Worksheets";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "All advertisers";
$GLOBALS['strAnonAdvertisers'] = "Anonymous advertisers";
$GLOBALS['strAllPublishers'] = "All websites";
$GLOBALS['strAnonPublishers'] = "Anonymous websites";
$GLOBALS['strAllAvailZones'] = "All available zones";

// Userlog
$GLOBALS['strUserLog'] = "User Log";
$GLOBALS['strUserLogDetails'] = "User log details";
$GLOBALS['strDeleteLog'] = "Delete log";
$GLOBALS['strAction'] = "Action";
$GLOBALS['strNoActionsLogged'] = "No actions are logged";

// Code generation
$GLOBALS['strGenerateBannercode'] = "Direct Selection";
$GLOBALS['strChooseInvocationType'] = "Please choose the type of banner invocation";
$GLOBALS['strGenerate'] = "Generate";
$GLOBALS['strParameters'] = "Tag settings";
$GLOBALS['strFrameSize'] = "Frame size";
$GLOBALS['strBannercode'] = "Bannercode";
$GLOBALS['strTrackercode'] = "Trackercode";
$GLOBALS['strBackToTheList'] = "Go back to report list";
$GLOBALS['strCharset'] = "Character set";
$GLOBALS['strAutoDetect'] = "Auto-detect";
$GLOBALS['strCacheBusterComment'] = "  * Replace all instances of {random} with
  * a generated random number (or timestamp).
  *";
$GLOBALS['strSSLBackupComment'] = "
  * The backup image section of this tag has been generated for use on a
  * non-SSL page. If this tag is to be placed on an SSL page, change the
  *   'http://%s/...'
  * to
  *   'https://%s/...'
  *";
$GLOBALS['strSSLDeliveryComment'] = "
  * This tag has been generated for use on a non-SSL page. If this tag
  * is to be placed on an SSL page, change the
  *   'http://%s/...'
  * to
  *   'https://%s/...'
  *";

$GLOBALS['strThirdPartyComment'] = "
  * Don't forget to replace the '{clickurl}' text with
  * the click tracking URL if this ad is to be delivered through a 3rd
  * party (non-Max) adserver.
  *";

// Errors
$GLOBALS['strErrorDatabaseConnetion'] = "Database connection error.";
$GLOBALS['strErrorCantConnectToDatabase'] = "A fatal error occurred %s can't connect to the database. Because
                                                   of this it isn't possible to use the administrator interface. The delivery
                                                   of banners might also be affected. Possible reasons for the problem are:
                                                   <ul>
                                                     <li>The database server isn't functioning at the moment</li>
                                                     <li>The location of the database server has changed</li>
                                                     <li>The username or password used to contact the database server are not correct</li>
                                                     <li>PHP has not loaded the MySQL Extension</li>
                                                   </ul>";
$GLOBALS['strNoMatchesFound'] = "No matches were found";
$GLOBALS['strErrorOccurred'] = "An error occurred";
$GLOBALS['strErrorDBPlain'] = "An error occurred while accessing the database";
$GLOBALS['strErrorDBSerious'] = "A serious problem with the database has been detected";
$GLOBALS['strErrorDBNoDataPlain'] = "Due to a problem with the database {$PRODUCT_NAME} couldn't retrieve or store data. ";
$GLOBALS['strErrorDBNoDataSerious'] = "Due to a serious problem with the database, {$PRODUCT_NAME} couldn't retrieve data";
$GLOBALS['strErrorDBCorrupt'] = "The database table is probably corrupt and needs to be repaired. For more information about repairing corrupted tables please read the chapter <i>Troubleshooting</i> of the <i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact'] = "Please contact the administrator of this server and notify him or her of the problem.";
$GLOBALS['strErrorDBSubmitBug'] = "If this problem is reproducable it might be caused by a bug in {$PRODUCT_NAME}. Please report the following information to the creators of {$PRODUCT_NAME}. Also try to describe the actions that led to this error as clearly as possible.";
$GLOBALS['strMaintenanceNotActive'] = "The maintenance script has not been run in the last 24 hours.
In order for the application to function correctly it needs to run
every hour.

Please read the Administrator guide for more information
about configuring the maintenance script.";
$GLOBALS['strErrorLinkingBanner'] = "It was not possible to link this banner to this zone because:";
$GLOBALS['strUnableToLinkBanner'] = "Cannot link this banner: ";
$GLOBALS['strErrorEditingCampaignRevenue'] = "incorrect number format in Revenue Information field";
$GLOBALS['strErrorEditingCampaignECPM'] = "incorrect number format in ECPM Information field";
$GLOBALS['strErrorEditingZone'] = "Error updating zone:";
$GLOBALS['strUnableToChangeZone'] = "Cannot apply this change because:";
$GLOBALS['strDatesConflict'] = "Dates of the campaign you are trying to link overlap with the dates of a campaign already linked ";
$GLOBALS['strEmailNoDates'] = "Campaigns linked to Email Zones must have a start and end date set. {$PRODUCT_NAME} ensures that on a given date, only one active banner is linked to an Email Zone. Please ensure that the campaigns already linked to the zone do not have overlapping dates with the campaign you are trying to link.";
$GLOBALS['strWarningInaccurateStats'] = "Some of these statistics were logged in a non-UTC timezone, and may not be displayed in the correct timezone.";
$GLOBALS['strWarningInaccurateReadMore'] = "Read more about this";
$GLOBALS['strWarningInaccurateReport'] = "Some of the statistics in this report were logged in a non-UTC timezone, and may not be displayed in the correct timezone";

//Validation
$GLOBALS['strRequiredFieldLegend'] = "denotes required field";
$GLOBALS['strFormContainsErrors'] = "Form contains errors, please correct the marked fields below.";
$GLOBALS['strXRequiredField'] = "%s is required";
$GLOBALS['strEmailField'] = "Please enter a valid email";
$GLOBALS['strNumericField'] = "Please enter a number (only digits allowed)";
$GLOBALS['strGreaterThanZeroField'] = "Must be greater than 0";
$GLOBALS['strXGreaterThanZeroField'] = "%s must be greater than 0";
$GLOBALS['strXPositiveWholeNumberField'] = "%s must be a positive whole number";
$GLOBALS['strInvalidWebsiteURL'] = "Invalid Website URL";

// Email
$GLOBALS['strSirMadam'] = "Sir/Madam";
$GLOBALS['strMailSubject'] = "Advertiser report";
$GLOBALS['strMailHeader'] = "Dear {contact},";
$GLOBALS['strMailBannerStats'] = "Below you will find the banner statistics for {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Campaign activated";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Campaign deactivated";
$GLOBALS['strMailBannerActivated'] = "Your campaign shown below has been activated because
the campaign activation date has been reached.";
$GLOBALS['strMailBannerDeactivated'] = "Your campaign shown below has been deactivated because";
$GLOBALS['strMailFooter'] = "Regards,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "This campaign is currently not active because";
$GLOBALS['strBeforeActivate'] = "the activation date has not yet been reached";
$GLOBALS['strAfterExpire'] = "the expiration date has been reached";
$GLOBALS['strNoMoreImpressions'] = "there are no Impressions remaining";
$GLOBALS['strNoMoreClicks'] = "there are no Clicks remaining";
$GLOBALS['strNoMoreConversions'] = "there are no Sales remaining";
$GLOBALS['strWeightIsNull'] = "its weight is set to zero";
$GLOBALS['strRevenueIsNull'] = "its revenue is set to zero";
$GLOBALS['strTargetIsNull'] = "its limit per day is set to zero - you need to either specify both an end date and a limit or set Limit per day value";
$GLOBALS['strNoViewLoggedInInterval'] = "No Impressions were logged during the span of this report";
$GLOBALS['strNoClickLoggedInInterval'] = "No Clicks were logged during the span of this report";
$GLOBALS['strNoConversionLoggedInInterval'] = "No Conversions were logged during the span of this report";
$GLOBALS['strMailReportPeriod'] = "This report includes statistics from {startdate} up to {enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "This report includes all statistics up to {enddate}.";
$GLOBALS['strNoStatsForCampaign'] = "There are no statistics available for this campaign";
$GLOBALS['strImpendingCampaignExpiry'] = "Impending campaign expiration";
$GLOBALS['strYourCampaign'] = "Your campaign";
$GLOBALS['strTheCampiaignBelongingTo'] = "The campaign belonging to";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} shown below is due to end on {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} shown below has less than {limit} impressions remaining.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "As a result, the campaign will soon be automatically disabled, and the
following banners in the campaign will also be disabled:";

// Priority
$GLOBALS['strPriority'] = "Priority";
$GLOBALS['strSourceEdit'] = "Edit Sources";

// Preferences
$GLOBALS['strPreferences'] = "Preferences";
$GLOBALS['strUserPreferences'] = "User Preferences";
$GLOBALS['strChangePassword'] = "Change Password";
$GLOBALS['strChangeEmail'] = "Change E-mail";
$GLOBALS['strCurrentPassword'] = "Current Password";
$GLOBALS['strChooseNewPassword'] = "Choose a new password";
$GLOBALS['strReenterNewPassword'] = "Re-enter new password";
$GLOBALS['strNameLanguage'] = "Name & Language";
$GLOBALS['strAccountPreferences'] = "Account Preferences";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Campaign email Reports Preferences";
$GLOBALS['strTimezonePreferences'] = "Timezone Preferences";
$GLOBALS['strAdminEmailWarnings'] = "System administrator email Warnings";
$GLOBALS['strAgencyEmailWarnings'] = "Account email Warnings";
$GLOBALS['strAdveEmailWarnings'] = "Advertiser email Warnings";
$GLOBALS['strFullName'] = "Full Name";
$GLOBALS['strEmailAddress'] = "Email address";
$GLOBALS['strUserDetails'] = "User Details";
$GLOBALS['strUserInterfacePreferences'] = "User Interface Preferences";
$GLOBALS['strPluginPreferences'] = "Plugin Preferences";
$GLOBALS['strColumnName'] = "Column Name";
$GLOBALS['strShowColumn'] = "Show Column";
$GLOBALS['strCustomColumnName'] = "Custom Column Name";
$GLOBALS['strColumnRank'] = "Column Rank";

// Long names
$GLOBALS['strRevenue'] = "Revenue";
$GLOBALS['strNumberOfItems'] = "Number of items";
$GLOBALS['strRevenueCPC'] = "Revenue CPC";
$GLOBALS['strERPM'] = "ERPM";
$GLOBALS['strERPC'] = "ERPC";
$GLOBALS['strERPS'] = "ERPS";
$GLOBALS['strEIPM'] = "EIPM";
$GLOBALS['strEIPC'] = "EIPC";
$GLOBALS['strEIPS'] = "EIPS";
$GLOBALS['strECPM'] = "eCPM";
$GLOBALS['strECPC'] = "ECPC";
$GLOBALS['strECPS'] = "ECPS";
$GLOBALS['strPendingConversions'] = "Pending conversions";
$GLOBALS['strImpressionSR'] = "Impression SR";
$GLOBALS['strClickSR'] = "Click SR";

// Short names
$GLOBALS['strRevenue_short'] = "Rev.";
$GLOBALS['strBasketValue_short'] = "BV";
$GLOBALS['strNumberOfItems_short'] = "Num. Items";
$GLOBALS['strRevenueCPC_short'] = "Rev. CPC";
$GLOBALS['strERPM_short'] = "ERPM";
$GLOBALS['strERPC_short'] = "ERPC";
$GLOBALS['strERPS_short'] = "ERPS";
$GLOBALS['strEIPM_short'] = "EIPM";
$GLOBALS['strEIPC_short'] = "EIPC";
$GLOBALS['strEIPS_short'] = "EIPS";
$GLOBALS['strECPM_short'] = "ECPM";
$GLOBALS['strECPC_short'] = "ECPC";
$GLOBALS['strECPS_short'] = "ECPS";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strRequests_short'] = "Req.";
$GLOBALS['strImpressions_short'] = "Impr.";
$GLOBALS['strClicks_short'] = "Clicks";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "Conv.";
$GLOBALS['strPendingConversions_short'] = "Pend conv.";
$GLOBALS['strImpressionSR_short'] = "Impr. SR";
$GLOBALS['strClickSR_short'] = "Click SR";

// Global Settings
$GLOBALS['strConfiguration'] = "Configuration";
$GLOBALS['strGlobalSettings'] = "Global Settings";
$GLOBALS['strGeneralSettings'] = "General Settings";
$GLOBALS['strMainSettings'] = "Main Settings";
$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strChooseSection'] = 'Choose Section';

// Product Updates
$GLOBALS['strProductUpdates'] = "Product Updates";
$GLOBALS['strViewPastUpdates'] = "Manage Past Updates and Backups";
$GLOBALS['strFromVersion'] = "From Version";
$GLOBALS['strToVersion'] = "To Version";
$GLOBALS['strToggleDataBackupDetails'] = "Toggle data backup details";
$GLOBALS['strClickViewBackupDetails'] = "click to view backup details";
$GLOBALS['strClickHideBackupDetails'] = "click to hide backup details";
$GLOBALS['strShowBackupDetails'] = "Show data backup details";
$GLOBALS['strHideBackupDetails'] = "Hide data backup details";
$GLOBALS['strBackupDeleteConfirm'] = "Do you really want to delete all backups created from this upgrade?";
$GLOBALS['strDeleteArtifacts'] = "Delete Artifacts";
$GLOBALS['strArtifacts'] = "Artifacts";
$GLOBALS['strBackupDbTables'] = "Backup database tables";
$GLOBALS['strLogFiles'] = "Log files";
$GLOBALS['strConfigBackups'] = "Conf backups";
$GLOBALS['strUpdatedDbVersionStamp'] = "Updated database version stamp";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "UPGRADE COMPLETE";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "UPGRADE FAILED";

// Agency
$GLOBALS['strAgencyManagement'] = "Account Management";
$GLOBALS['strAgency'] = "Account";
$GLOBALS['strAddAgency'] = "Add new account";
$GLOBALS['strAddAgency_Key'] = "Add <u>n</u>ew account";
$GLOBALS['strTotalAgencies'] = "Total accounts";
$GLOBALS['strAgencyProperties'] = "Account Properties";
$GLOBALS['strNoAgencies'] = "There are currently no accounts defined";
$GLOBALS['strConfirmDeleteAgency'] = "Do you really want to delete this account?";
$GLOBALS['strHideInactiveAgencies'] = "Hide inactive accounts";
$GLOBALS['strInactiveAgenciesHidden'] = "inactive account(s) hidden";
$GLOBALS['strSwitchAccount'] = "Switch to this account";

// Channels
$GLOBALS['strChannel'] = "Targeting Channel";
$GLOBALS['strChannels'] = "Targeting Channels";
$GLOBALS['strChannelManagement'] = "Targeting Channel Management";
$GLOBALS['strAddNewChannel'] = "Add new Targeting Channel";
$GLOBALS['strAddNewChannel_Key'] = "Add <u>n</u>ew Targeting Channel";
$GLOBALS['strChannelToWebsite'] = "to website";
$GLOBALS['strNoChannels'] = "There are currently no targeting channels defined";
$GLOBALS['strNoChannelsAddWebsite'] = "There are currently no targeting channels defined, because there are no websites. To create a targeting channel, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strEditChannelLimitations'] = "Edit targeting channel limitations";
$GLOBALS['strChannelProperties'] = "Targeting Channel properties";
$GLOBALS['strChannelLimitations'] = "Delivery Options";
$GLOBALS['strConfirmDeleteChannel'] = "Do you really want to delete this targeting channel?";
$GLOBALS['strConfirmDeleteChannels'] = "Do you really want to delete the selected targeting channels?";
$GLOBALS['strChannelsOfWebsite'] = 'in'; //this is added between page name and website name eg. 'Targeting channels in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "Variable Name";
$GLOBALS['strVariableDescription'] = "Description";
$GLOBALS['strVariableDataType'] = "Data Type";
$GLOBALS['strVariablePurpose'] = "Purpose";
$GLOBALS['strGeneric'] = "Generic";
$GLOBALS['strBasketValue'] = "Basket value";
$GLOBALS['strNumItems'] = "Number of items";
$GLOBALS['strVariableIsUnique'] = "Dedup conversions?";
$GLOBALS['strNumber'] = "Number";
$GLOBALS['strString'] = "String";
$GLOBALS['strTrackFollowingVars'] = "Track the following variable";
$GLOBALS['strAddVariable'] = "Add Variable";
$GLOBALS['strNoVarsToTrack'] = "No Variables to track.";
$GLOBALS['strVariableRejectEmpty'] = "Reject if empty?";
$GLOBALS['strTrackingSettings'] = "Tracking settings";
$GLOBALS['strTrackerType'] = "Tracker type";
$GLOBALS['strTrackerTypeJS'] = "Track JavaScript variables";
$GLOBALS['strTrackerTypeDefault'] = "Track JavaScript variables (backwards compatible, escaping needed)";
$GLOBALS['strTrackerTypeDOM'] = "Track HTML elements using DOM";
$GLOBALS['strTrackerTypeCustom'] = "Custom JS code";
$GLOBALS['strVariableCode'] = "Javascript tracking code";

// Password recovery
$GLOBALS['strForgotPassword'] = "Forgot your password?";
$GLOBALS['strPasswordRecovery'] = "Password recovery";
$GLOBALS['strEmailRequired'] = "Email is a required field";
$GLOBALS['strPwdRecWrongId'] = "Wrong ID";
$GLOBALS['strPwdRecEnterEmail'] = "Enter your email address below";
$GLOBALS['strPwdRecEnterPassword'] = "Enter your new password below";
$GLOBALS['strPwdRecResetLink'] = "Password reset link";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "%s password recovery";
$GLOBALS['strProceed'] = "Proceed >";
$GLOBALS['strNotifyPageMessage'] = "An e-mail has been sent to you, which includes a link that will allow you
                                         to re-set your password and log in.<br />Please allow a few minutes for the e-mail to arrive.<br />
                                         If you do not receive the e-mail, please check your spam folder.<br />
                                         <a href=\"index.php\">Return the the main login page.</a>";

// Audit
$GLOBALS['strAdditionalItems'] = "and additional items";
$GLOBALS['strFor'] = "for";
$GLOBALS['strHas'] = "has";
$GLOBALS['strBinaryData'] = "Binary data";
$GLOBALS['strAuditTrailDisabled'] = "Audit Trail has been disabled by the system administrator. No further events are logged and shown in Audit Trail list.";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "No user activity has been recorded during the timeframe you have selected.";
$GLOBALS['strAuditTrail'] = "Audit Trail";
$GLOBALS['strAuditTrailSetup'] = "Setup the Audit Trail today";
$GLOBALS['strAuditTrailGoTo'] = "Go to Audit Trail page";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Audit Trail allows you to see who did what and when. Or to put it another way, it keeps track of system changes within {$PRODUCT_NAME}</li>
        <li>You are seeing this message, because you have not activated the Audit Trail</li>
        <li>Interested in learning more? Read the <a href='{$PRODUCT_DOCSURL}/admin/settings/auditTrail' class='site-link' target='help' >Audit Trail documentation</a></li>";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Go to Campaigns page";
$GLOBALS['strCampaignSetUp'] = "Set up a Campaign today";
$GLOBALS['strCampaignNoRecords'] = "<li>Campaigns let you group together any number of banner ads, of any size, that share common advertising requirements</li>
        <li>Save time by grouping banners within a campaign and no longer define delivery settings for each ad separately</li>
        <li>Check out the <a class='site-link' target='help' href='{$PRODUCT_DOCSURL}/user/inventory/advertisersAndCampaigns/campaigns'>Campaign documentation</a>!</li>";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>There is no campaign activity to display.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "No campaigns have started or finished during the timeframe you have selected";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>In order to view campaigns which have started or finished during the timeframe you have selected, the Audit Trail must be activated</li>
        <li>You are seeing this message because you didn't activate the Audit Trail</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Activate Audit Trail to start viewing Campaigns";

$GLOBALS['strUnsavedChanges'] = "You have unsaved changes on this page, make sure you press &quot;Save Changes&quot; when finished";
$GLOBALS['strDeliveryLimitationsDisagree'] = "WARNING: The delivery engine limitations <strong>DO NOT AGREE</strong> with the limitations shown below<br />Please hit save changes to update the delivery engine's rules";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Some of delivery limitations reports incorrect values:";

//confirmation messages
$GLOBALS['strYouAreNowWorkingAsX'] = "You are now working as <b>%s</b>";
$GLOBALS['strYouDontHaveAccess'] = "You don't have access to that page. You have been re-directed.";

$GLOBALS['strAdvertiserHasBeenAdded'] = "Advertiser <a href='%s'>%s</a> has been added, <a href='%s'>add a campaign</a>";
$GLOBALS['strAdvertiserHasBeenUpdated'] = "Advertiser <a href='%s'>%s</a> has been updated";
$GLOBALS['strAdvertiserHasBeenDeleted'] = "Advertiser <b>%s</b> has been deleted";
$GLOBALS['strAdvertisersHaveBeenDeleted'] = "All selected advertisers have been deleted";

$GLOBALS['strTrackerHasBeenAdded'] = "Tracker <a href='%s'>%s</a> has been added";
$GLOBALS['strTrackerHasBeenUpdated'] = "Tracker <a href='%s'>%s</a> has been updated";
$GLOBALS['strTrackerVarsHaveBeenUpdated'] = "Variables of tracker <a href='%s'>%s</a> have been updated";
$GLOBALS['strTrackerCampaignsHaveBeenUpdated'] = "Linked campaigns of tracker <a href='%s'>%s</a> have been updated";
$GLOBALS['strTrackerAppendHasBeenUpdated'] = "Append tracker code of tracker <a href='%s'>%s</a> has been updated";
$GLOBALS['strTrackerHasBeenDeleted'] = "Tracker <b>%s</b> has been deleted";
$GLOBALS['strTrackersHaveBeenDeleted'] = "All selected trackers have been deleted";
$GLOBALS['strTrackerHasBeenDuplicated'] = "Tracker <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strTrackerHasBeenMoved'] = "Tracker <b>%s</b> has been moved to advertiser <b>%s</b>";

$GLOBALS['strCampaignHasBeenAdded'] = "Campaign <a href='%s'>%s</a> has been added, <a href='%s'>add a banner</a>";
$GLOBALS['strCampaignHasBeenUpdated'] = "Campaign <a href='%s'>%s</a> has been updated";
$GLOBALS['strCampaignTrackersHaveBeenUpdated'] = "Linked trackers of campaign <a href='%s'>%s</a> have been updated";
$GLOBALS['strCampaignHasBeenDeleted'] = "Campaign <b>%s</b> has been deleted";
$GLOBALS['strCampaignsHaveBeenDeleted'] = "All selected campaigns have been deleted";
$GLOBALS['strCampaignHasBeenDuplicated'] = "Campaign <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strCampaignHasBeenMoved'] = "Campaign <b>%s</b> has been moved to advertiser <b>%s</b>";

$GLOBALS['strBannerHasBeenAdded'] = "Banner <a href='%s'>%s</a> has been added";
$GLOBALS['strBannerHasBeenUpdated'] = "Banner <a href='%s'>%s</a> has been updated";
$GLOBALS['strBannerAdvancedHasBeenUpdated'] = "Advanced settings for banner <a href='%s'>%s</a> have been updated";
$GLOBALS['strBannerAclHasBeenUpdated'] = "Delivery options for banner <a href='%s'>%s</a> have been updated";
$GLOBALS['strBannerAclHasBeenAppliedTo'] = "Delivery options for banner <a href='%s'>%s</a> have been applied to %d banners";
$GLOBALS['strBannerHasBeenDeleted'] = "Banner <b>%s</b> has been deleted";
$GLOBALS['strBannersHaveBeenDeleted'] = "All selected banners have been deleted";
$GLOBALS['strBannerHasBeenDuplicated'] = "Banner <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strBannerHasBeenMoved'] = "Banner <b>%s</b> has been moved to campaign <b>%s</b>";
$GLOBALS['strBannerHasBeenActivated'] = "Banner <a href='%s'>%s</a> has been activated";
$GLOBALS['strBannerHasBeenDeactivated'] = "Banner <a href='%s'>%s</a> has been deactivated";

$GLOBALS['strXZonesLinked'] = "<b>%s</b> zone(s) linked";
$GLOBALS['strXZonesUnlinked'] = "<b>%s</b> zone(s) unlinked";

$GLOBALS['strWebsiteHasBeenAdded'] = "Website <a href='%s'>%s</a> has been added, <a href='%s'>add a zone</a>";
$GLOBALS['strWebsiteHasBeenUpdated'] = "Website <a href='%s'>%s</a> has been updated";
$GLOBALS['strWebsiteHasBeenDeleted'] = "Website <b>%s</b> has been deleted";
$GLOBALS['strWebsitesHaveBeenDeleted'] = "All selected website have been deleted";

$GLOBALS['strZoneHasBeenAdded'] = "Zone <a href='%s'>%s</a> has been added";
$GLOBALS['strZoneHasBeenUpdated'] = "Zone <a href='%s'>%s</a> has been updated";
$GLOBALS['strZoneAdvancedHasBeenUpdated'] = "Advanced settings for zone <a href='%s'>%s</a> have been updated";
$GLOBALS['strZoneHasBeenDeleted'] = "Zone <b>%s</b> has been deleted";
$GLOBALS['strZonesHaveBeenDeleted'] = "All selected zone have been deleted";
$GLOBALS['strZoneHasBeenDuplicated'] = "Zone <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strZoneHasBeenMoved'] = "Zone <b>%s</b> has been moved to website <b>%s</b>";
$GLOBALS['strZoneLinkedBanner'] = "Banner has been linked to zone <a href='%s'>%s</a>";
$GLOBALS['strZoneLinkedCampaign'] = "Campaign has been linked to zone <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedBanner'] = "Banner has been unlinked from zone <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedCampaign'] = "Campaign has been unlinked from zone <a href='%s'>%s</a>";

$GLOBALS['strChannelHasBeenAdded'] = "Targeting channel <a href='%s'>%s</a> has been added, <a href='%s'>change the delivery options</a>";
$GLOBALS['strChannelHasBeenUpdated'] = "Targeting channel <a href='%s'>%s</a> has been updated";
$GLOBALS['strChannelAclHasBeenUpdated'] = "Delivery options for targeting channel <a href='%s'>%s</a> have been updated";
$GLOBALS['strChannelHasBeenDeleted'] = "Targeting channel <b>%s</b> has been deleted";
$GLOBALS['strChannelsHaveBeenDeleted'] = "All selected Targeting Channels have been deleted";
$GLOBALS['strChannelHasBeenDuplicated'] = "Targeting channel <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";

$GLOBALS['strUserPreferencesUpdated'] = "Your <b>%s</b> preferences has been updated";
$GLOBALS['strEmailChanged'] = "Your E-mail has been changed";
$GLOBALS['strPasswordChanged'] = "Your password has been changed";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "<b>%s</b> have been updated";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "<b>%s</b> have been updated";
$GLOBALS['strTZPreferencesWarning'] = "However, campaign activation and expiry were not updated, nor time-based banner limitations.<br />You will need to update them manually if you wish them to use the new timezone";

// Report error messages
$GLOBALS['strReportErrorMissingSheets'] = "No worksheet was selected for report";
$GLOBALS['strReportErrorUnknownCode'] = "Unknown error code #";

/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome'] = "h";
$GLOBALS['keyUp'] = "u";
$GLOBALS['keyNextItem'] = ".";
$GLOBALS['keyPreviousItem'] = ",";
$GLOBALS['keyList'] = "l";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch'] = "s";
$GLOBALS['keyCollapseAll'] = "c";
$GLOBALS['keyExpandAll'] = "e";
$GLOBALS['keyAddNew'] = "n";
$GLOBALS['keyNext'] = "n";
$GLOBALS['keyPrevious'] = "p";
$GLOBALS['keyLinkUser'] = "u";
$GLOBALS['keyWorkingAs'] = "w";
