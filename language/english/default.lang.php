<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/*                                                                      */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']  			= "ltr";
$GLOBALS['phpAds_TextAlignRight'] 			= "right";
$GLOBALS['phpAds_TextAlignLeft']  			= "left";


// Date & time configuration
$GLOBALS['date_format']						= "%m/%d/%Y";
$GLOBALS['time_format']						= "%H:%i:%S";
$GLOBALS['minute_format']					= "%H:%M";
$GLOBALS['month_format']					= "%m/%Y";
$GLOBALS['day_format']						= "%m/%d";
$GLOBALS['week_format']						= "%W/%Y";
$GLOBALS['weekiso_format']					= "%V/%G";



/*********************************************************/
/* Translations                                          */
/*********************************************************/

$GLOBALS['strHome'] 						= "Home";
$GLOBALS['strHelp']							= "Help";
$GLOBALS['strNavigation'] 					= "Navigation";
$GLOBALS['strShortcuts'] 					= "Shortcuts";
$GLOBALS['strAdminstration'] 				= "Administration";
$GLOBALS['strMaintenance']					= "Maintenance";
$GLOBALS['strProbability']					= "Probability";
$GLOBALS['strInvocationcode']				= "Invocationcode";
$GLOBALS['strBasicInformation'] 			= "Basic information";
$GLOBALS['strContractInformation'] 			= "Contract information";
$GLOBALS['strLoginInformation'] 			= "Login information";
$GLOBALS['strOverview']						= "Overview";
$GLOBALS['strSearch']						= "Search";
$GLOBALS['strHistory']						= "History";
$GLOBALS['strPreferences'] 					= "Preferences";
$GLOBALS['strDetails']						= "Details";
$GLOBALS['strCompact']						= "Compact";
$GLOBALS['strVerbose']						= "Verbose";
$GLOBALS['strUser']							= "User";
$GLOBALS['strEdit']							= "Edit";
$GLOBALS['strCreate']						= "Create";
$GLOBALS['strDuplicate']					= "Duplicate";
$GLOBALS['strMoveTo']						= "Move to";
$GLOBALS['strDelete'] 						= "Delete";
$GLOBALS['strActivate']						= "Activate";
$GLOBALS['strDeActivate'] 					= "Deactivate";
$GLOBALS['strConvert']						= "Convert";
$GLOBALS['strSaveChanges']		 			= "Save Changes";
$GLOBALS['strUp'] 							= "Up";
$GLOBALS['strDown'] 						= "Down";
$GLOBALS['strSave'] 						= "Save";
$GLOBALS['strCancel']						= "Cancel";
$GLOBALS['strPrevious'] 					= "Previous";
$GLOBALS['strNext'] 						= "Next";
$GLOBALS['strYes']							= "Yes";
$GLOBALS['strNo']							= "No";
$GLOBALS['strNone'] 						= "None";
$GLOBALS['strCustom']						= "Custom";
$GLOBALS['strDefault'] 						= "Default";
$GLOBALS['strOther']						= "Other";
$GLOBALS['strUnknown']						= "Unknown";
$GLOBALS['strUnlimited'] 					= "Unlimited";
$GLOBALS['strUntitled']						= "Untitled";
$GLOBALS['strAll'] 							= "all";
$GLOBALS['strAvg'] 							= "Avg.";
$GLOBALS['strAverage']						= "Average";
$GLOBALS['strOverall'] 						= "Overall";
$GLOBALS['strTotal'] 						= "Total";
$GLOBALS['strActive'] 						= "active";
$GLOBALS['strFrom']							= "From";
$GLOBALS['strTo']							= "to";
$GLOBALS['strLinkedTo'] 					= "linked to";
$GLOBALS['strDaysLeft'] 					= "Days left";
$GLOBALS['strCheckAllNone']					= "Check all / none";
$GLOBALS['strKiloByte']						= "KB";


// Properties
$GLOBALS['strName']							= "Name";
$GLOBALS['strSize']							= "Size";
$GLOBALS['strWidth'] 						= "Width";
$GLOBALS['strHeight'] 						= "Height";
$GLOBALS['strURL2']							= "URL";
$GLOBALS['strTarget']						= "Target";
$GLOBALS['strLanguage'] 					= "Language";
$GLOBALS['strDescription'] 					= "Description";
$GLOBALS['strID']				 			= "ID";


// Login & Permissions
$GLOBALS['strAuthentification'] 			= "Authentication";
$GLOBALS['strWelcomeTo']					= "Welcome to";
$GLOBALS['strEnterUsername']				= "Enter your username and password to log in";
$GLOBALS['strLogin'] 						= "Login";
$GLOBALS['strLogout'] 						= "Logout";
$GLOBALS['strUsername'] 					= "Username";
$GLOBALS['strPassword']						= "Password";
$GLOBALS['strAccessDenied']					= "Access denied";
$GLOBALS['strPasswordWrong']				= "The password is not correct";
$GLOBALS['strNotAdmin']						= "You may not have enough privileges";
$GLOBALS['strDuplicateClientName']			= "The username you provided already exists, please enter a different username.";


// General advertising
$GLOBALS['strViews'] 						= "AdViews";
$GLOBALS['strClicks']						= "AdClicks";
$GLOBALS['strCTRShort'] 					= "CTR";
$GLOBALS['strCTR'] 							= "Click-Through Ratio";
$GLOBALS['strTotalViews'] 					= "Total AdViews";
$GLOBALS['strTotalClicks'] 					= "Total AdClicks";
$GLOBALS['strViewCredits'] 					= "AdView credits";
$GLOBALS['strClickCredits'] 				= "AdClick credits";


// Time and date related
$GLOBALS['strDate'] 						= "Date";
$GLOBALS['strToday'] 						= "Today";
$GLOBALS['strDay']							= "Day";
$GLOBALS['strDays']							= "Days";
$GLOBALS['strLast7Days']					= "Last 7 days";
$GLOBALS['strWeek'] 						= "Week";
$GLOBALS['strWeeks']						= "Weeks";
$GLOBALS['strMonths']						= "Months";
$GLOBALS['strThisMonth'] 					= "This month";
$GLOBALS['strMonth'] 						= array("January","February","March","April","May","June","July", "August", "September", "October", "November", "December");
$GLOBALS['strDayShortCuts'] 				= array("Su","Mo","Tu","We","Th","Fr","Sa");
$GLOBALS['strHour']							= "Hour";
$GLOBALS['strSeconds']						= "seconds";


// Advertiser
$GLOBALS['strClient']						= "Advertiser";
$GLOBALS['strClients'] 						= "Advertisers";
$GLOBALS['strClientsAndCampaigns']			= "Advertisers & Campaigns";
$GLOBALS['strAddClient'] 					= "Add new advertiser";
$GLOBALS['strTotalClients'] 				= "Total advertisers";
$GLOBALS['strClientProperties']				= "Advertiser properties";
$GLOBALS['strClientHistory']				= "Advertiser history";
$GLOBALS['strNoClients']					= "There are currently no advertisers defined";
$GLOBALS['strConfirmDeleteClient'] 			= "Do you really want to delete this advertiser?";
$GLOBALS['strConfirmResetClientStats']		= "Do you really want to delete all existing statistics for this advertiser?";


// Advertisers properties
$GLOBALS['strContact'] 						= "Contact";
$GLOBALS['strEMail'] 						= "E-mail";
$GLOBALS['strSendAdvertisingReport']		= "Send an advertising report via e-mail";
$GLOBALS['strNoDaysBetweenReports']			= "Number of days between reports";
$GLOBALS['strSendDeactivationWarning']  	= "Send a warning when a campaign is deactivated";
$GLOBALS['strAllowClientModifyInfo'] 		= "Allow this user to modify his own settings";
$GLOBALS['strAllowClientModifyBanner'] 		= "Allow this user to modify his own banners";
$GLOBALS['strAllowClientAddBanner'] 		= "Allow this user to add his own banners";
$GLOBALS['strAllowClientDisableBanner'] 	= "Allow this user to deactivate his own banners";
$GLOBALS['strAllowClientActivateBanner'] 	= "Allow this user to activate his own banners";


// Campaign
$GLOBALS['strCampaign']						= "Campaign";
$GLOBALS['strCampaigns']					= "Campaigns";
$GLOBALS['strTotalCampaigns'] 				= "Total campaigns";
$GLOBALS['strActiveCampaigns'] 				= "Active campaigns";
$GLOBALS['strAddCampaign'] 					= "Add new campaign";
$GLOBALS['strCreateNewCampaign']			= "Create new campaign";
$GLOBALS['strModifyCampaign']				= "Modify campaign";
$GLOBALS['strMoveToNewCampaign']			= "Move to a new campaign";
$GLOBALS['strBannersWithoutCampaign']		= "Banners without a campaign";
$GLOBALS['strDeleteAllCampaigns']			= "Delete all campaigns";
$GLOBALS['strCampaignStats']				= "Campaign statistics";
$GLOBALS['strCampaignProperties']			= "Campaign properties";
$GLOBALS['strCampaignOverview']				= "Campaign overview";
$GLOBALS['strCampaignHistory']				= "Campaign history";
$GLOBALS['strNoCampaigns']					= "There are currently no campaigns defined";
$GLOBALS['strConfirmDeleteAllCampaigns']	= "Do you really want to delete all campaigns owned by this advertiser?";
$GLOBALS['strConfirmDeleteCampaign']		= "Do you really want to delete this campaign?";


// Campaign properties
$GLOBALS['strDontExpire']					= "Don't expire this campaign on a specific date";
$GLOBALS['strActivateNow'] 					= "Activate this campaign immediately";
$GLOBALS['strLow']							= "Low";
$GLOBALS['strHigh']							= "High";
$GLOBALS['strExpirationDate']				= "Expiration date";
$GLOBALS['strActivationDate']				= "Activation date";
$GLOBALS['strViewsPurchased'] 				= "AdViews remaining";
$GLOBALS['strClicksPurchased'] 				= "AdClicks remaining";
$GLOBALS['strCampaignWeight']				= "Campaign weight";
$GLOBALS['strHighPriority']					= "Show banners in this campaign with high priority.<br>
											   If you use this option phpAdsNew will try to distribute the 
											   number of AdViews evenly over the course of the day.";
$GLOBALS['strLowPriority']					= "Show banner in this campaign with low priority.<br>
											   This campaign is used to show the left over AdViews which 
											   aren't used by high priority campaigns.";
$GLOBALS['strTargetLimitAdviews']			= "Limit the number of AdViews to";
$GLOBALS['strTargetPerDay']					= "per day.";
$GLOBALS['strPriorityAutoTargeting']		= "Distribute the remaining AdViews evenly over the remaining number of days. The target number of AdViews will be set accordingly every day.";



// Banners (General)
$GLOBALS['strBanner'] 						= "Banner";
$GLOBALS['strBanners'] 						= "Banners";
$GLOBALS['strAddBanner'] 					= "Add new banner";
$GLOBALS['strModifyBanner'] 				= "Modify banner";
$GLOBALS['strActiveBanners'] 				= "Active banners";
$GLOBALS['strTotalBanners'] 				= "Total banners";
$GLOBALS['strShowBanner']					= "Show banner";
$GLOBALS['strShowAllBanners']	 			= "Show all banners";
$GLOBALS['strShowBannersNoAdClicks']		= "Show banners without AdClicks";
$GLOBALS['strShowBannersNoAdViews']			= "Show banners without AdViews";
$GLOBALS['strDeleteAllBanners']	 			= "Delete all banners";
$GLOBALS['strActivateAllBanners']			= "Activate all banners";
$GLOBALS['strDeactivateAllBanners']			= "Deactivate all banners";
$GLOBALS['strBannerOverview']				= "Banner overview";
$GLOBALS['strBannerProperties']				= "Banner properties";
$GLOBALS['strBannerHistory']				= "Banner history";
$GLOBALS['strBannerNoStats'] 				= "There are no statistics available for this banner";
$GLOBALS['strNoBanners']					= "There are currently no banners defined";
$GLOBALS['strConfirmDeleteBanner']			= "Do you really want to delete this banner?";
$GLOBALS['strConfirmDeleteAllBanners']		= "Do you really want to delete all banners which are owned by this campaign?";
$GLOBALS['strConfirmResetBannerStats']		= "Do you really want to delete all existing statistics for this banner?";


// Banner (Properties)
$GLOBALS['strChooseBanner'] 				= "Please choose the type of the banner";
$GLOBALS['strMySQLBanner'] 					= "Local banner (SQL)";
$GLOBALS['strWebBanner'] 					= "Local banner (Webserver)";
$GLOBALS['strURLBanner'] 					= "External banner";
$GLOBALS['strHTMLBanner'] 					= "HTML banner";
$GLOBALS['strAutoChangeHTML']				= "Alter HTML to enable tracking of AdClicks";
$GLOBALS['strUploadOrKeep']					= "Do you wish to keep your <br>existing image, or do you <br>want to upload another?";
$GLOBALS['strNewBannerFile'] 				= "Select the image you want <br>to use for this banner<br><br>";
$GLOBALS['strNewBannerURL'] 				= "Image URL (incl. http://)";
$GLOBALS['strURL'] 							= "Destination URL (incl. http://)";
$GLOBALS['strHTML'] 						= "HTML";
$GLOBALS['strTextBelow'] 					= "Text below image";
$GLOBALS['strKeyword'] 						= "Keywords";
$GLOBALS['strWeight'] 						= "Weight";
$GLOBALS['strAlt'] 							= "Alt text";
$GLOBALS['strStatusText']					= "Status text";
$GLOBALS['strBannerWeight']					= "Banner weight";


// Banner (swf)
$GLOBALS['strCheckSWF']						= "Check for hard-coded links inside the Flash file";
$GLOBALS['strConvertSWFLinks']				= "Convert Flash links";
$GLOBALS['strConvertSWF']					= "<br>The Flash file you just uploaded contains hard-coded urls. phpAdsNew won't be ".
											  "able to track the number of AdClicks for this banner unless you convert these ".
											  "hard-coded urls. Below you will find a list of all urls inside the Flash file. ".
											  "If you want to convert the urls, simply click <b>Convert</b>, otherwise click ".
											  "<b>Cancel</b>.<br><br>".
											  "Please note: if you click <b>Convert</b> the Flash file ".
									  		  "you just uploaded will be physically altered. <br>Please keep a backup of the ".
											  "original file. Regardless of in which version this banner was created, the resulting ".
											  "file will need the Flash 4 player (or higher) to display correctly.<br><br>";


// Banner (network)
$GLOBALS['strBannerNetwork']				= "Banner network";
$GLOBALS['strChooseNetwork']				= "Choose the banner network you want to use";
$GLOBALS['strMoreInformation']				= "More information...";
$GLOBALS['strRichMedia']					= "Richmedia";
$GLOBALS['strTrackAdClicks']				= "Track AdClicks";


// Display limitations
$GLOBALS['strModifyBannerAcl'] 				= "Display limitations";
$GLOBALS['strACL'] 							= "Limitations";
$GLOBALS['strACLAdd'] 						= "Add new limitation";
$GLOBALS['strNoLimitations']				= "No limitations";
$GLOBALS['strApplyLimitationsTo']			= "Apply limitations to";
$GLOBALS['strEqualTo']						= "is equal to";
$GLOBALS['strDifferentFrom']				= "is different from";
$GLOBALS['strAND']							= "AND";  						// logical operator
$GLOBALS['strOR']							= "OR"; 						// logical operator
$GLOBALS['strOnlyDisplayWhen']				= "Only display this banner when:";
$GLOBALS['strWeekDay'] 						= "Weekday";
$GLOBALS['strTime'] 						= "Time";
$GLOBALS['strUserAgent'] 					= "Browser";
$GLOBALS['strDomain'] 						= "Domain";
$GLOBALS['strClientIP'] 					= "Client IP";
$GLOBALS['strSource'] 						= "Source";


// Publisher
$GLOBALS['strAffiliate']					= "Publisher";
$GLOBALS['strAffiliates']					= "Publishers";
$GLOBALS['strAffiliatesAndZones']			= "Publishers & Zones";
$GLOBALS['strAddNewAffiliate']				= "Add new publisher";
$GLOBALS['strAddAffiliate']					= "Create publisher";
$GLOBALS['strAffiliateProperties']			= "Publisher properties";
$GLOBALS['strAffiliateOverview']			= "Publisher overview";
$GLOBALS['strAffiliateHistory']				= "Publisher history";
$GLOBALS['strZonesWithoutAffiliate']		= "Zones without publisher";
$GLOBALS['strMoveToNewAffiliate']			= "Move to new publisher";
$GLOBALS['strNoAffiliates']					= "There are currently no publishers defined";
$GLOBALS['strConfirmDeleteAffiliate']		= "Do you really want to delete this publisher?";


// Affiliates (properties)
$GLOBALS['strAllowAffiliateModifyInfo'] 	= "Allow this user to modify his own settings";
$GLOBALS['strAllowAffiliateModifyZones'] 	= "Allow this user to modify his own zones";
$GLOBALS['strAllowAffiliateLinkBanners'] 	= "Allow this user to link banners to his own zones";
$GLOBALS['strAllowAffiliateAddZone'] 		= "Allow this user to define new zones";
$GLOBALS['strAllowAffiliateDeleteZone'] 	= "Allow this user to delete existing zones";


// Zone
$GLOBALS['strZone']							= "Zone";
$GLOBALS['strZones']						= "Zones";
$GLOBALS['strAddNewZone']					= "Add new zone";
$GLOBALS['strAddZone']						= "Create zone";
$GLOBALS['strModifyZone']					= "Modify zone";
$GLOBALS['strLinkedZones']					= "Linked zones";
$GLOBALS['strZoneOverview']					= "Zone overview";
$GLOBALS['strZoneProperties']				= "Zone properties";
$GLOBALS['strZoneHistory']					= "Zone history";
$GLOBALS['strNoZones']						= "There are currently no zones defined";
$GLOBALS['strConfirmDeleteZone']			= "Do you really want to delete this zone?";


// Linked banners/campaigns
$GLOBALS['strSelectZoneType']				= "Please choose the type of linking banners";
$GLOBALS['strBannerSelection']				= "Banner selection";
$GLOBALS['strCampaignSelection']			= "Campaign selection";
$GLOBALS['strInteractive']					= "Interactive";
$GLOBALS['strRawQueryString']				= "Keyword";
$GLOBALS['strIncludedBanners']				= "Linked banners";
$GLOBALS['strLinkedBannersOverview']		= "Linked banners overview";
$GLOBALS['strLinkedBannerHistory']			= "Linked banner history";
$GLOBALS['strNoZonesToLink']				= "There are no zones available to which this banner can be linked";
$GLOBALS['strNoBannersToLink']				= "There are currently no banners available which can be linked to this zone";
$GLOBALS['strNoLinkedBanners']				= "There are no banners available which are linked to this zone";
$GLOBALS['strMatchingBanners']				= "{count} matching banners";
$GLOBALS['strNoCampaignsToLink']			= "There are currently no campaigns available which can be linked to this zone";
$GLOBALS['strNoZonesToLinkToCampaign']  	= "There are no zones available to which this campaign can be linked";
$GLOBALS['strSelectBannerToLink']			= "Select the banner you would like to link to this zone:";
$GLOBALS['strSelectCampaignToLink']			= "Select the campaign you would like to link to this zone:";


// Statistics
$GLOBALS['strStats'] 						= "Statistics";
$GLOBALS['strNoStats']						= "There are currently no statistics available";
$GLOBALS['strConfirmResetStats']			= "Do you really want to delete all existing statistics?";
$GLOBALS['strGlobalHistory']				= "Global history";
$GLOBALS['strDailyHistory']					= "Daily history";
$GLOBALS['strDailyStats'] 					= "Daily statistics";
$GLOBALS['strWeeklyHistory']				= "Weekly history";
$GLOBALS['strMonthlyHistory']				= "Monthly history";
$GLOBALS['strCreditStats'] 					= "Credit statistics";
$GLOBALS['strDetailStats'] 					= "Detailed statistics";
$GLOBALS['strTotalThisPeriod']				= "Total this period";
$GLOBALS['strAverageThisPeriod']			= "Average this period";
$GLOBALS['strDistribution']					= "Distribution";
$GLOBALS['strResetStats'] 					= "Reset statistics";
$GLOBALS['strSourceStats']					= "Source statistics";
$GLOBALS['strSelectSource']					= "Select the source you want to view:";


// Hosts
$GLOBALS['strHosts']						= "Hosts";
$GLOBALS['strTopTenHosts'] 					= "Top ten requesting hosts";


// Expiration
$GLOBALS['strExpired']						= "Expired";
$GLOBALS['strExpiration'] 					= "Expiration";
$GLOBALS['strNoExpiration'] 				= "No expiration date set";
$GLOBALS['strEstimated'] 					= "Estimated expiration";


// Reports
$GLOBALS['strReports']						= "Reports";
$GLOBALS['strSelectReport']					= "Select the report you want to generate";


// Userlog
$GLOBALS['strUserLog']						= "User log";
$GLOBALS['strUserLogDetails']				= "User log details";
$GLOBALS['strDeleteLog']					= "Delete log";
$GLOBALS['strAction']						= "Action";
$GLOBALS['strNoActionsLogged']				= "No actions are logged";


// Code generation
$GLOBALS['strGenerateBannercode']			= "Generate bannercode";
$GLOBALS['strChooseInvocationType']			= "Please choose the type of banner invocation";
$GLOBALS['strGenerate']						= "Generate";
$GLOBALS['strParameters']					= "Parameters";
$GLOBALS['strFrameSize']					= "Frame size";
$GLOBALS['strBannercode']					= "Bannercode";


// Errors
$GLOBALS['strMySQLError'] 					= "SQL Error:";
$GLOBALS['strLogErrorClients'] 				= "[phpAds] An error occurred while trying to fetch the advertisers from the database.";
$GLOBALS['strLogErrorBanners'] 				= "[phpAds] An error occurred while trying to fetch the banners from the database.";
$GLOBALS['strLogErrorViews'] 				= "[phpAds] An error occurred while trying to fetch the adviews from the database.";
$GLOBALS['strLogErrorClicks'] 				= "[phpAds] An error occurred while trying to fetch the adclicks from the database.";
$GLOBALS['strErrorViews'] 					= "You must enter the number of views or select the unlimited box !";
$GLOBALS['strErrorNegViews'] 				= "Negative views are not allowed";
$GLOBALS['strErrorClicks'] 					= "You must enter the number of clicks or select the unlimited box !";
$GLOBALS['strErrorNegClicks'] 				= "Negative clicks are not allowed";
$GLOBALS['strNoMatchesFound']				= "No matches were found";
$GLOBALS['strErrorOccurred']				= "An error occurred";


// E-mail
$GLOBALS['strMailSubject'] 					= "Advertiser report";
$GLOBALS['strAdReportSent']					= "Advertiser report sent";
$GLOBALS['strMailSubjectDeleted'] 			= "Deactivated banners";
$GLOBALS['strMailHeader'] 					= "Dear {contact},\n";
$GLOBALS['strMailBannerStats'] 				= "Below you will find the banner statistics for {clientname}:";
$GLOBALS['strMailFooter'] 					= "Regards,\n   {adminfullname}";
$GLOBALS['strMailClientDeactivated'] 		= "The following banners have been disabled because";
$GLOBALS['strMailNothingLeft'] 				= "If you would like to continue advertising on our website, please feel free to contact us.\nWe'd be glad to hear from you.";
$GLOBALS['strClientDeactivated']			= "This campaign is currently not active because";
$GLOBALS['strBeforeActivate']				= "the activation date has not yet been reached";
$GLOBALS['strAfterExpire']					= "the expiration date has been reached";
$GLOBALS['strNoMoreClicks']					= "the amount of AdClicks purchased are used";
$GLOBALS['strNoMoreViews']					= "the amount of AdViews purchased are used";
$GLOBALS['strWarnClientTxt']				= "The AdClicks or AdViews left for your banners are getting below {limit}. \nYour banners will be disabled when there are no AdClicks or AdViews left. ";
$GLOBALS['strViewsClicksLow']				= "AdViews/AdClicks are low";
$GLOBALS['strNoViewLoggedInInterval']   	= "No AdViews were logged during the span of this report";
$GLOBALS['strNoClickLoggedInInterval']  	= "No AdClicks were logged during the span of this report";
$GLOBALS['strMailReportPeriod']				= "This report includes statistics from {startdate} up to {enddate}.";
$GLOBALS['strMailReportPeriodAll']			= "This report includes all statistics up to {enddate}.";
$GLOBALS['strNoStatsForCampaign'] 			= "There are no statistics available for this campaign";


// Priority
$GLOBALS['strPriority']						= "Priority";


// Settings
$GLOBALS['strSettings'] 					= "Settings";
$GLOBALS['strGeneralSettings']				= "General settings";
$GLOBALS['strMainSettings']					= "Main settings";
$GLOBALS['strAdminSettings']				= "Administration settings";


// Product Updates
$GLOBALS['strProductUpdates']				= "Product updates";

?>