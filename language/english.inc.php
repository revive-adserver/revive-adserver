<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// Set translation strings
$GLOBALS['strHome'] = "Home";
$GLOBALS['date_format'] = "%m/%d/%Y";
$GLOBALS['time_format'] = "%H:%i:%S";
$GLOBALS['strMySQLError'] = "MySQL-Error:";
$GLOBALS['strAdminstration'] = "Administration";
$GLOBALS['strAddClient'] = "Add new client";
$GLOBALS['strModifyClient'] = "Modify client";
$GLOBALS['strDeleteClient'] = "Delete client";
$GLOBALS['strViewClientStats'] = "View client's statistics";
$GLOBALS['strClientName'] = "Client";
$GLOBALS['strContact'] = "Contact";
$GLOBALS['strEMail'] = "EMail";
$GLOBALS['strViews'] = "AdViews";
$GLOBALS['strClicks'] = "AdClicks";
$GLOBALS['strTotalViews'] = "Total AdViews";
$GLOBALS['strTotalClicks'] = "Total AdClicks";
$GLOBALS['strCTR'] = "Click-Through Ratio";
$GLOBALS['strTotalClients'] = "Total clients";
$GLOBALS['strActiveClients'] = "Active clients";
$GLOBALS['strActiveBanners'] = "Active banners";
$GLOBALS['strLogout'] = "Logout";
$GLOBALS['strCreditStats'] = "Credit Stats";
$GLOBALS['strViewCredits'] = "Adview credits";
$GLOBALS['strClickCredits'] = "Adclick credits";
$GLOBALS['strPrevious'] = "Previous";
$GLOBALS['strNext'] = "Next";
$GLOBALS['strNone'] = "None";
$GLOBALS['strViewsPurchased'] = "AdViews purchased";
$GLOBALS['strClicksPurchased'] = "AdClicks purchased";
$GLOBALS['strDaysPurchased'] = "AdDays purchased";
$GLOBALS['strHTML'] = "HTML";
$GLOBALS['strAddSep'] = "Fill in EITHER the fields above OR the field below!";
$GLOBALS['strTextBelow'] = "Text below image";
$GLOBALS['strSubmit'] = "Submit ad";
$GLOBALS['strUsername'] = "Username";
$GLOBALS['strPassword'] = "Password";
$GLOBALS['strBannerAdmin'] = "Banner administration for";
$GLOBALS['strBannerAdminAcl'] = "Banner ACL administration for";
$GLOBALS['strNoBanners'] = "No banners found";
$GLOBALS['strBanner'] = "Banner";
$GLOBALS['strCurrentBanner'] = "Current banner";
$GLOBALS['strDelete'] = "Delete";
$GLOBALS['strAddBanner'] = "Add new banner";
$GLOBALS['strModifyBanner'] = "Modify banner";
$GLOBALS['strModifyBannerAcl'] = "Modify banner ACL";
$GLOBALS['strURL'] = "Linked to URL (incl. http://)";
$GLOBALS['strKeyword'] = "Keyword";
$GLOBALS['strWeight'] = "Weight";
$GLOBALS['strAlt'] = "Alt-Text";
$GLOBALS['strUsername'] = "Username";
$GLOBALS['strPassword'] = "Password";
$GLOBALS['strAccessDenied'] = "Access denied";
$GLOBALS['strPasswordWrong'] = "The password is not correct";
$GLOBALS['strNotAdmin'] = "You may not have enough privileges";
$GLOBALS['strClientAdded'] = "The client has been added.";
$GLOBALS['strClientModified'] = "The client has been modified.";
$GLOBALS['strClientDeleted'] = "The client has been deleted.";
$GLOBALS['strBannerAdmin'] = "Banner Administration";
$GLOBALS['strBannerAdded'] = "The banner has been added.";
$GLOBALS['strBannerModified'] = "The banner has been modified.";
$GLOBALS['strBannerDeleted'] = "The banner has been deleted";
$GLOBALS['strBannerChanged'] = "The banner has been changed";
$GLOBALS['strStats'] = "Statistics";
$GLOBALS['strDailyStats'] = "Daily statistics";
$GLOBALS['strDetailStats'] = "Detailed statistics";
$GLOBALS['strCreditStats'] = "Credit statistics";
$GLOBALS['strActive'] = "active";
$GLOBALS['strActivate'] = "Activate";
$GLOBALS['strDeActivate'] = "De-activate";
$GLOBALS['strAuthentification'] = "Authentication";
$GLOBALS['strGo'] = "Go";
$GLOBALS['strLinkedTo'] = "linked to";
$GLOBALS['strBannerID'] = "Banner-ID";
$GLOBALS['strClientID'] = "Client ID";
$GLOBALS['strMailSubject'] = "Advertising Report";
$GLOBALS['strMailSubjectDeleted'] = "Deactivated Ads";
$GLOBALS['strMailHeader'] = "Dear ".(isset($client["contact"]) ? $client["contact"] : '').",\n";
$GLOBALS['strMailBannerStats'] = "Below you will find the banner statistics for ".(isset($client["clientname"]) ? $client["clientname"] : '').":";
$GLOBALS['strMailFooter'] = "Regards,\n   ".$GLOBALS['phpAds_admin_fullname'];
$GLOBALS['strLogMailSent'] = "[phpAds] Statistics successfully sent.";
$GLOBALS['strLogErrorClients'] = "[phpAds] An error occurred while trying to fetch the clients from the database.";
$GLOBALS['strLogErrorBanners'] = "[phpAds] An error occurred while trying to fetch the banners from the database.";
$GLOBALS['strLogErrorViews'] = "[phpAds] An error occurred while trying to fetch the adviews from the database.";
$GLOBALS['strLogErrorClicks'] = "[phpAds] An error occurred while trying to fetch the adclicks from the database.";
$GLOBALS['strLogErrorDisactivate'] = "[phpAds] An error occurred while trying to disactivate a banner.";
$GLOBALS['strRatio'] = "Click-Through Ratio";
$GLOBALS['strChooseBanner'] = "Please choose the type of the banner.";
$GLOBALS['strMySQLBanner'] = "Banner stored in MySQL";
$GLOBALS['strWebBanner'] = "Banner stored on the Webserver";
$GLOBALS['strURLBanner'] = "Banner referred to through URL";
$GLOBALS['strHTMLBanner'] = "HTML banner";
$GLOBALS['strNewBannerFile'] = "New banner file";
$GLOBALS['strNewBannerURL'] = "New banner URL (incl. http://)";
$GLOBALS['strWidth'] = "Width";
$GLOBALS['strHeight'] = "Height";
$GLOBALS['strTotalViews7Days'] = "Total AdViews in past 7 days";
$GLOBALS['strTotalClicks7Days'] = "Total AdClicks in past 7 days";
$GLOBALS['strAvgViews7Days'] = "Average AdViews in past 7 days";
$GLOBALS['strAvgClicks7Days'] = "Average AdClicks in past 7 days";
$GLOBALS['strTopTenHosts'] = "Top ten requesting hosts";
$GLOBALS['strConfirmDeleteClient'] = "Do you really want to delete this client?";
$GLOBALS['strClientIP'] = "Client IP";
$GLOBALS['strUserAgent'] = "User agent regexp";
$GLOBALS['strWeekDay'] = "Week day (0 - 6)";
$GLOBALS['strDomain'] = "Domain (excluding dot)";
$GLOBALS['strSource'] = "Source";
$GLOBALS['strTime'] = "Time";
$GLOBALS['strAllow'] = "Allow";
$GLOBALS['strDeny'] = "Deny";
$GLOBALS['strResetStats'] = "Reset Statistics";
$GLOBALS['strConfirmResetStats'] = "Do you really want to reset stats for this client ?";
$GLOBALS['strExpiration'] = "Expiration";
$GLOBALS['strNoExpiration'] = "No expiration date set";
$GLOBALS['strDaysLeft'] = "Days left";
$GLOBALS['strEstimated'] = "Estimated expiration";
$GLOBALS['strConfirm'] = "Are you sure ?";
$GLOBALS['strBannerNoStats'] = "No statistics available for this banner!";
$GLOBALS['strWeek'] = "Week";
$GLOBALS['strWeeklyStats'] = "Weekly statistics";
$GLOBALS['strWeekDay'] = "Weekday";
$GLOBALS['strDate'] = "Date";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strDayShortCuts'] = array("Su","Mo","Tu","We","Th","Fr","Sa");
$GLOBALS['strShowWeeks'] = "Max. weeks to display";
$GLOBALS['strAll'] = "all";
$GLOBALS['strAvg'] = "Avg.";
$GLOBALS['strHourly'] = "Views/Clicks by hour";
$GLOBALS['strTotal'] = "Total";
$GLOBALS['strUnlimited'] = "Unlimited";
$GLOBALS['strSave'] = "Save";
$GLOBALS['strUp'] = "Up";
$GLOBALS['strDown'] = "Down";
$GLOBALS['strSaved'] = "was saved!";
$GLOBALS['strDeleted'] = "was deleted!";
$GLOBALS['strMovedUp'] = "was moved up";
$GLOBALS['strMovedDown'] = "was moved down";
$GLOBALS['strUpdated'] = "was updated";
$GLOBALS['strACL'] = "ACL";
$GLOBALS['strNoMoveUp'] = "Can't move up first row";
$GLOBALS['strACLAdd'] = "Add new ".$GLOBALS["strACL"];
$GLOBALS['strACLExist'] = "Existing ".$GLOBALS["strACL"].":";
$GLOBALS['strLogin'] = "Login";
$GLOBALS['strPreferences'] = "Preferences";
$GLOBALS['strAllowClientModifyInfo'] = "Allow this user to modify his own client information";
$GLOBALS['strAllowClientModifyBanner'] = "Allow this user to modify his own banners";
$GLOBALS['strAllowClientAddBanner'] = "Allow this user to add his own banners";
$GLOBALS['strLanguage'] = "Language";
$GLOBALS['strDefault'] = "Default";
$GLOBALS['strErrorViews'] = "You must enter the number of views or select the unlimited box !";
$GLOBALS['strErrorNegViews'] = "Negative views are not allowed";
$GLOBALS['strErrorClicks'] =  "You must enter the number of clicks or select the unlimited box !";
$GLOBALS['strErrorNegClicks'] = "Negative clicks are not allowed";
$GLOBALS['strErrorDays'] = "You must enter the number of days or select the unlimited box !";
$GLOBALS['strErrorNegDays'] = "Negative days are not allowed";
$GLOBALS['strTrackerImage'] = "Tracker image:";

// New strings for version 2
$GLOBALS['strNavigation'] 			= "Navigation";
$GLOBALS['strShortcuts'] 				= "Shortcuts";
$GLOBALS['strDescription'] 			= "Description";
$GLOBALS['strClients'] 				= "Clients";
$GLOBALS['strID']				 		= "ID";
$GLOBALS['strOverall'] 				= "Overall";
$GLOBALS['strTotalBanners'] 			= "Total banners";
$GLOBALS['strToday'] 					= "Today";
$GLOBALS['strThisWeek'] 				= "This week";
$GLOBALS['strThisMonth'] 				= "This month";
$GLOBALS['strBasicInformation'] 		= "Basic information";
$GLOBALS['strContractInformation'] 	= "Contract information";
$GLOBALS['strLoginInformation'] 		= "Login information";
$GLOBALS['strPermissions'] 			= "Permissions";
$GLOBALS['strGeneralSettings']		= "General settings";
$GLOBALS['strSaveChanges']		 	= "Save Changes";
$GLOBALS['strCompact']				= "Compact";
$GLOBALS['strVerbose']				= "Verbose";
$GLOBALS['strOrderBy']				= "order by";
$GLOBALS['strShowAllBanners']	 		= "Show all banners";
$GLOBALS['strShowBannersNoAdClicks']	= "Show banners without AdClicks";
$GLOBALS['strShowBannersNoAdViews']	= "Show banners without AdViews";
$GLOBALS['strShowAllClients'] 		= "Show all clients";
$GLOBALS['strShowClientsActive'] 		= "Show clients with active banners";
$GLOBALS['strShowClientsInactive']	= "Show clients with inactive banners";
$GLOBALS['strSize']					= "Size";

$GLOBALS['strMonth'] 				= array("January","February","March","April","May","June","July", "August", "September", "October", "November", "December");
$GLOBALS['strDontExpire']			= "Don't expire this client on a specific date";
$GLOBALS['strActivateNow'] 			= "Activate this client immediately";
$GLOBALS['strExpirationDate']		= "Expiration date";
$GLOBALS['strActivationDate']		= "Activation date";

$GLOBALS['strMailClientDeactivated'] 	= "Your banners have been disabled because";
$GLOBALS['strMailNothingLeft'] 			= "If you would like to continue advertising on our website, please feel free to contact us. We'd be glad to hear from you.";
$GLOBALS['strClientDeactivated']		= "This client is currently not active because";
$GLOBALS['strBeforeActivate']			= "the activation date has not yet been reached";
$GLOBALS['strAfterExpire']				= "the expiration date has been reached";
$GLOBALS['strNoMoreClicks']				= "the amount of AdClicks purchased are used";
$GLOBALS['strNoMoreViews']				= "the amount of AdViews purchased are used";
?>
