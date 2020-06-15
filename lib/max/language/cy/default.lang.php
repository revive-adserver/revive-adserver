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
$GLOBALS['strHelp'] = "Cymorth";
$GLOBALS['strStartOver'] = "Cychwyn eto";
$GLOBALS['strShortcuts'] = "Llwybrau Byr";
$GLOBALS['strActions'] = "Gweithred";
$GLOBALS['strAndXMore'] = "and %s more";
$GLOBALS['strAdminstration'] = "Rhestren";
$GLOBALS['strMaintenance'] = "Cynnal";
$GLOBALS['strProbability'] = "Tebygolrwydd";
$GLOBALS['strInvocationcode'] = "Cod Actifadu";
$GLOBALS['strBasicInformation'] = "Gwybodaeth Sylfaenol";
$GLOBALS['strAppendTrackerCode'] = "Atodi Cod Traciwr";
$GLOBALS['strOverview'] = "Trosolwg";
$GLOBALS['strSearch'] = "Chwilio";
$GLOBALS['strDetails'] = "Manylion";
$GLOBALS['strUpdateSettings'] = "Update Settings";
$GLOBALS['strCheckForUpdates'] = "Gwirio am Ddiweddariadau";
$GLOBALS['strWhenCheckingForUpdates'] = "When checking for updates";
$GLOBALS['strCompact'] = "Cywasgu";
$GLOBALS['strUser'] = "Defnyddiwr";
$GLOBALS['strDuplicate'] = "Dyblygu";
$GLOBALS['strCopyOf'] = "Copy of";
$GLOBALS['strMoveTo'] = "Symud i";
$GLOBALS['strDelete'] = "Dileu";
$GLOBALS['strActivate'] = "Ysgogi";
$GLOBALS['strConvert'] = "Trosi";
$GLOBALS['strRefresh'] = "Ail-lwytho";
$GLOBALS['strSaveChanges'] = "Cadw newidiadau";
$GLOBALS['strUp'] = "I fyny";
$GLOBALS['strDown'] = "I lawr";
$GLOBALS['strSave'] = "Cadw";
$GLOBALS['strCancel'] = "Canslo";
$GLOBALS['strBack'] = "Back";
$GLOBALS['strPrevious'] = "Blaenorol";
$GLOBALS['strNext'] = "Nesaf";
$GLOBALS['strYes'] = "Iawn";
$GLOBALS['strNo'] = "Na";
$GLOBALS['strNone'] = "Dim";
$GLOBALS['strCustom'] = "Addasu";
$GLOBALS['strDefault'] = "Rhagosodiad";
$GLOBALS['strUnknown'] = "Unknown";
$GLOBALS['strUnlimited'] = "Diderfyn";
$GLOBALS['strUntitled'] = "Di-deitl";
$GLOBALS['strAll'] = "all";
$GLOBALS['strAverage'] = "Cyfartaledd";
$GLOBALS['strOverall'] = "Cyffredinol";
$GLOBALS['strTotal'] = "Cyfanswm";
$GLOBALS['strFrom'] = "From";
$GLOBALS['strTo'] = "i";
$GLOBALS['strAdd'] = "Add";
$GLOBALS['strLinkedTo'] = "wedi cysylltu â";
$GLOBALS['strDaysLeft'] = "Dyddiau ar ôl";
$GLOBALS['strCheckAllNone'] = "Gwirio popeth / dim";
$GLOBALS['strKiloByte'] = "KB";
$GLOBALS['strExpandAll'] = "<u>E</u>hangu popeth";
$GLOBALS['strCollapseAll'] = "<u>C</u>ywasgu popeth";
$GLOBALS['strShowAll'] = "Dangos popeth";
$GLOBALS['strNoAdminInterface'] = "Mae'r sgrin gweinyddu wedi cael ei ddiffodd ar gyfer gwaith cynnal a chadw.  Ni fydd hyn yn effeithio ar eich ymgyrchoedd.";
$GLOBALS['strFieldStartDateBeforeEnd'] = "'From' date must be earlier then 'To' date";
$GLOBALS['strFieldContainsErrors'] = "Mae'r meysydd canlynol yn cynnwys gwallau:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Cyn parhau, bydd angen i chi";
$GLOBALS['strFieldFixBeforeContinue2'] = "gywiro'r gwallau yma.";
$GLOBALS['strMiscellaneous'] = "Amrywiol";
$GLOBALS['strCollectedAllStats'] = "Holl ystadegau";
$GLOBALS['strCollectedToday'] = "Heddiw";
$GLOBALS['strCollectedYesterday'] = "Ddoe";
$GLOBALS['strCollectedThisWeek'] = "Yr wythnos hon";
$GLOBALS['strCollectedLastWeek'] = "Wythnos diwethaf";
$GLOBALS['strCollectedThisMonth'] = "Y mis hwn";
$GLOBALS['strCollectedLastMonth'] = "Mis diwethaf";
$GLOBALS['strCollectedLast7Days'] = "7 niwrnod diwethaf";
$GLOBALS['strCollectedSpecificDates'] = "Dyddiadau penodol";
$GLOBALS['strValue'] = "Value";
$GLOBALS['strWarning'] = "Rhybudd";
$GLOBALS['strNotice'] = "Hysbysiad";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "The dashboard can not be displayed";
$GLOBALS['strNoCheckForUpdates'] = "The dashboard cannot be displayed unless the<br />check for updates setting is enabled.";
$GLOBALS['strEnableCheckForUpdates'] = "Please enable the <a href='account-settings-update.php' target='_top'>check for updates</a> setting on the<br/><a href='account-settings-update.php' target='_top'>update settings</a> page.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "code";
$GLOBALS['strDashboardSystemMessage'] = "System message";
$GLOBALS['strDashboardErrorHelp'] = "If this error repeats please describe your problem in detail and post it on <a href='http://forum.revive-adserver.com/'>forum.revive-adserver.com/</a>.";

// Priority
$GLOBALS['strPriority'] = "Blaenoriaeth";
$GLOBALS['strPriorityLevel'] = "Lefel blaenoriaeth";
$GLOBALS['strOverrideAds'] = "Override Campaign Advertisements";
$GLOBALS['strHighAds'] = "Contract Campaign Advertisements";
$GLOBALS['strECPMAds'] = "eCPM Campaign Advertisements";
$GLOBALS['strLowAds'] = "Remnant Campaign Advertisements";
$GLOBALS['strLimitations'] = "Delivery rules";
$GLOBALS['strNoLimitations'] = "No delivery rules";
$GLOBALS['strCapping'] = "Terfyn Uchaf";

// Properties
$GLOBALS['strName'] = "Enw";
$GLOBALS['strSize'] = "Maint";
$GLOBALS['strWidth'] = "Lled";
$GLOBALS['strHeight'] = "Uchder";
$GLOBALS['strTarget'] = "Targed";
$GLOBALS['strLanguage'] = "Iaith";
$GLOBALS['strDescription'] = "Disgrifiad";
$GLOBALS['strVariables'] = "Newidynnau";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "Sylwadau";

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
$GLOBALS['strLinkUserHelpUser'] = "Enw Defnyddiwr";
$GLOBALS['strLinkUserHelpEmail'] = "email address";
$GLOBALS['strLastLoggedIn'] = "Last logged in";
$GLOBALS['strDateLinked'] = "Date linked";

// Login & Permissions
$GLOBALS['strUserAccess'] = "User Access";
$GLOBALS['strAdminAccess'] = "Admin Access";
$GLOBALS['strUserProperties'] = "Priodweddau Baner";
$GLOBALS['strPermissions'] = "Permissions";
$GLOBALS['strAuthentification'] = "Dilysiad ";
$GLOBALS['strWelcomeTo'] = "Croeso i";
$GLOBALS['strEnterUsername'] = "Rhowch eich enw defnyddiwr a'ch cyfrinair i fewngofnodi";
$GLOBALS['strEnterBoth'] = "Rhowch eich enw defnyddiwr a'ch cyfrinair os gwelwch yn dda";
$GLOBALS['strEnableCookies'] = "You need to enable cookies before you can use {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "Session cookie error, please log in again";
$GLOBALS['strLogin'] = "Mewngofnodi";
$GLOBALS['strLogout'] = "Allgofnodi";
$GLOBALS['strUsername'] = "Enw Defnyddiwr";
$GLOBALS['strPassword'] = "Cyfrinair";
$GLOBALS['strPasswordRepeat'] = "Ailadroddwch y cyfrinair";
$GLOBALS['strAccessDenied'] = "Gwadwyd mynediad";
$GLOBALS['strUsernameOrPasswordWrong'] = "Nid oedd yr enw defnyddiwr na'r/neu'r cyfrinair yn gywir. Rhowch gynnig arall arni.";
$GLOBALS['strPasswordWrong'] = "Nid yw'r cyfrinair yn gywir";
$GLOBALS['strNotAdmin'] = "Your account does not have the required permissions to use this feature, you can log into another account to use it.";
$GLOBALS['strDuplicateClientName'] = "Mae'r enw defnyddiwr yn bodoli eisoes, defnyddiwch enw defnyddiwr gwahanol.";
$GLOBALS['strInvalidPassword'] = "Nid yw'r cyfrinair newydd yn ddilys, defnyddiwch gyfrinair gwahanol.";
$GLOBALS['strInvalidEmail'] = "The email is not correctly formatted, please put a correct email address.";
$GLOBALS['strNotSamePasswords'] = "Nid yw'r ddau gyfrinair a ddarparwyd gennych yr un peth";
$GLOBALS['strRepeatPassword'] = "Ailadroddwch y cyfrinair";
$GLOBALS['strDeadLink'] = "Your link is invalid.";
$GLOBALS['strNoPlacement'] = "Selected campaign does not exist. Try this <a href='{link}'>link</a> instead";
$GLOBALS['strNoAdvertiser'] = "Selected advertiser does not exist. Try this <a href='{link}'>link</a> instead";

// General advertising
$GLOBALS['strRequests'] = "Ceisiadau";
$GLOBALS['strImpressions'] = "Argraffiadau";
$GLOBALS['strClicks'] = "Cliciau";
$GLOBALS['strConversions'] = "Trawsnewidiadau";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "Cyfanswm Cliciau";
$GLOBALS['strTotalConversions'] = "Cyfanswm Trawsnewidiadau";
$GLOBALS['strDateTime'] = "Dyddiad Amser";
$GLOBALS['strTrackerID'] = "ID Traciwr";
$GLOBALS['strTrackerName'] = "Enw Traciwr";
$GLOBALS['strTrackerImageTag'] = "Image Tag";
$GLOBALS['strTrackerJsTag'] = "Javascript Tag";
$GLOBALS['strTrackerAlwaysAppend'] = "Always display appended code, even if no conversion is recorded by the tracker?";
$GLOBALS['strBanners'] = "Baneri";
$GLOBALS['strCampaigns'] = "Ymgyrch";
$GLOBALS['strCampaignID'] = "ID Ymgyrch";
$GLOBALS['strCampaignName'] = "Enw Ymgyrch";
$GLOBALS['strCountry'] = "Gwlad";
$GLOBALS['strStatsAction'] = "Gweithred";
$GLOBALS['strWindowDelay'] = "Oediad Ffenest";
$GLOBALS['strStatsVariables'] = "Newidynnau";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Tenantiaeth Misol";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strFinanceCR'] = "CR";

// Time and date related
$GLOBALS['strDate'] = "Dyddiad";
$GLOBALS['strDay'] = "Diwrnod";
$GLOBALS['strDays'] = "Diwrnodau";
$GLOBALS['strWeek'] = "Wythnos";
$GLOBALS['strWeeks'] = "Wythnosau";
$GLOBALS['strSingleMonth'] = "Mis";
$GLOBALS['strMonths'] = "Misoedd";
$GLOBALS['strDayOfWeek'] = "Diwrnod yr wythnos";


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

$GLOBALS['strHour'] = "Awr";
$GLOBALS['strSeconds'] = "eiliadau";
$GLOBALS['strMinutes'] = "munudau";
$GLOBALS['strHours'] = "oriau";

// Advertiser
$GLOBALS['strClient'] = "Hysbysebwr";
$GLOBALS['strClients'] = "Hysbysebwyr";
$GLOBALS['strClientsAndCampaigns'] = "Hysbysebwyr a Ymgyrchoedd";
$GLOBALS['strAddClient'] = "Ychwanegu hysbysebwr newydd";
$GLOBALS['strClientProperties'] = "Priodweddau Hysbysebwr";
$GLOBALS['strClientHistory'] = "Advertiser Statistics";
$GLOBALS['strNoClients'] = "Nid oes unrhyw hysbysebwr wedi ei ddiffinio hyd yma. Er mwyn creu ymgyrch, <a href='advertiser-edit.php'>ychwanegwch hysbysebwrnewydd</a>.";
$GLOBALS['strConfirmDeleteClient'] = "Ydych chi wir am ddileu'r hysbysebwr yma?";
$GLOBALS['strConfirmDeleteClients'] = "Ydych chi wir am ddileu'r hysbysebwr yma?";
$GLOBALS['strHideInactive'] = "Cuddio anweithredol";
$GLOBALS['strInactiveAdvertisersHidden'] = "hysbysebw(y)r anweithredol wedi cuddio";
$GLOBALS['strAdvertiserSignup'] = "Advertiser Sign Up";
$GLOBALS['strAdvertiserCampaigns'] = "Hysbysebwyr a Ymgyrchoedd";

// Advertisers properties
$GLOBALS['strContact'] = "Cysylltu";
$GLOBALS['strContactName'] = "Contact Name";
$GLOBALS['strEMail'] = "Ebost";
$GLOBALS['strSendAdvertisingReport'] = "Ebostio adroddiadau trosglwyddo ymgyrch";
$GLOBALS['strNoDaysBetweenReports'] = "Nifer o ddyddiau rhwng adroddiadau trosglwyddo ymgyrch";
$GLOBALS['strSendDeactivationWarning'] = "Ebostio pan mae ymgyrch wedi ysgogi/dad-ysgogi yn awtomatig";
$GLOBALS['strAllowClientModifyBanner'] = "Caniatáu y defnyddiwr i newid ei faneri";
$GLOBALS['strAllowClientDisableBanner'] = "Caniatáu y defnyddiwr i ddad-ysgogi ei faneri";
$GLOBALS['strAllowClientActivateBanner'] = "Caniatáu y defnyddiwr i ysgogi ei faneri";
$GLOBALS['strAllowCreateAccounts'] = "Allow this user to manage this account's users";
$GLOBALS['strAdvertiserLimitation'] = "Display only one banner from this advertiser on a web page";
$GLOBALS['strAllowAuditTrailAccess'] = "Caniatáu i'r defnyddiwr gyrchu y trywydd archwilio";

// Campaign
$GLOBALS['strCampaign'] = "Ymgyrch";
$GLOBALS['strCampaigns'] = "Ymgyrch";
$GLOBALS['strAddCampaign'] = "Ychwanegu ymgyrch newydd";
$GLOBALS['strAddCampaign_Key'] = "Ychwanegu ymgyrch <u>n</u>ewydd";
$GLOBALS['strCampaignForAdvertiser'] = "for advertiser";
$GLOBALS['strLinkedCampaigns'] = "Ymgyrchoedd Cysylltiedig";
$GLOBALS['strCampaignProperties'] = "Priodoleddau Ymgyrch";
$GLOBALS['strCampaignOverview'] = "Trosolwg ymgyrch";
$GLOBALS['strCampaignHistory'] = "Campaign Statistics";
$GLOBALS['strNoCampaigns'] = "There are currently no campaigns defined for this advertiser.";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "There are currently no campaigns defined, because there are no advertisers. To create a campaign, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
$GLOBALS['strConfirmDeleteCampaign'] = "Ydych chi wir am ddileu yr ymgyrch yma?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Ydych chi wir am ddileu yr ymgyrch yma?";
$GLOBALS['strShowParentAdvertisers'] = "Dangos hysbysebwyr rhiant";
$GLOBALS['strHideParentAdvertisers'] = "Cuddio hysbysebwyr rhiant";
$GLOBALS['strHideInactiveCampaigns'] = "Cuddio ymgyrchoedd sydd ddim yn weithredol";
$GLOBALS['strInactiveCampaignsHidden'] = "Ymgyrchoedd anweithredol wedi cuddio";
$GLOBALS['strPriorityInformation'] = "Blaenoriaeth mewn perthynas ag ymgyrchoedd eraill";
$GLOBALS['strECPMInformation'] = "eCPM prioritization";
$GLOBALS['strRemnantEcpmDescription'] = "eCPM is automatically calculated based on this campaign's performance.<br />It will be used to prioritise Remnant campaigns relative to each other.";
$GLOBALS['strEcpmMinImpsDescription'] = "Set this to your desired minium basis on which to calculate this campaign's eCPM.";
$GLOBALS['strHiddenCampaign'] = "Ymgyrch";
$GLOBALS['strHiddenAd'] = "Hysbyseb";
$GLOBALS['strHiddenAdvertiser'] = "Hysbysebwr";
$GLOBALS['strHiddenTracker'] = "Traciwr";
$GLOBALS['strHiddenWebsite'] = "Gwefan";
$GLOBALS['strHiddenZone'] = "Ardal";
$GLOBALS['strCampaignDelivery'] = "Campaign delivery";
$GLOBALS['strCompanionPositioning'] = "Safleoli cymar";
$GLOBALS['strSelectUnselectAll'] = "Dewis / Dad-ddewis popeth";
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
$GLOBALS['strLow'] = "Isel";
$GLOBALS['strHigh'] = "Uchel";
$GLOBALS['strExpirationDate'] = "Dyddiad Gorffen";
$GLOBALS['strExpirationDateComment'] = "Bydd yr ymgyrch yn gorffen ar ddiwedd y diwrnod yma";
$GLOBALS['strActivationDate'] = "Dyddiad Cychwyn";
$GLOBALS['strActivationDateComment'] = "Bydd yr ymgyrch yn cychwyn ar gychwyn y diwrnod yma";
$GLOBALS['strImpressionsRemaining'] = "Argraffiadau sy'n weddill";
$GLOBALS['strClicksRemaining'] = "Cliciau sy'n weddill";
$GLOBALS['strConversionsRemaining'] = "Trawsnewidiadau sy'n weddill";
$GLOBALS['strImpressionsBooked'] = "Argraffiadau a Archebwyd";
$GLOBALS['strClicksBooked'] = "Cliciau a Archebwyd";
$GLOBALS['strConversionsBooked'] = "Trawsnewidiadau a Archebwyd";
$GLOBALS['strCampaignWeight'] = "Set the campaign weight";
$GLOBALS['strAnonymous'] = "Cuddio hysbysebwr a gwefannau'r ymgyrch hwn.";
$GLOBALS['strTargetPerDay'] = "y diwrnod.";
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
$GLOBALS['strCampaignStatusPending'] = "Dan Ystyriaeth";
$GLOBALS['strCampaignStatusInactive'] = "gweithredol";
$GLOBALS['strCampaignStatusRunning'] = "Running";
$GLOBALS['strCampaignStatusPaused'] = "Saib";
$GLOBALS['strCampaignStatusAwaiting'] = "Awaiting";
$GLOBALS['strCampaignStatusExpired'] = "Completed";
$GLOBALS['strCampaignStatusApproval'] = "Awaiting approval »";
$GLOBALS['strCampaignStatusRejected'] = "Rejected";
$GLOBALS['strCampaignStatusAdded'] = "Added";
$GLOBALS['strCampaignStatusStarted'] = "Started";
$GLOBALS['strCampaignStatusRestarted'] = "Ailgychwyn";
$GLOBALS['strCampaignStatusDeleted'] = "Dileu";
$GLOBALS['strCampaignType'] = "Enw Ymgyrch";
$GLOBALS['strType'] = "Math";
$GLOBALS['strContract'] = "Cysylltu";
$GLOBALS['strOverride'] = "Override";
$GLOBALS['strOverrideInfo'] = "Override campaigns are a special campaign type specifically to
    override (i.e. take priority over) Remnant and Contract campaigns. Override campaigns are generally used with
    specific targeting and/or capping rules to ensure that the campaign banners are always displayed in certain
    locations, to certain users, and perhaps a certain number of times, as part of a specific promotion. (This campaign
    type was previously known as 'Contract (Exclusive)'.)";
$GLOBALS['strStandardContract'] = "Cysylltu";
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
$GLOBALS['strTracker'] = "Traciwr";
$GLOBALS['strTrackers'] = "Traciwr";
$GLOBALS['strTrackerPreferences'] = "Tracker Preferences";
$GLOBALS['strAddTracker'] = "Ychwanegu traciwr newydd";
$GLOBALS['strTrackerForAdvertiser'] = "for advertiser";
$GLOBALS['strNoTrackers'] = "There are currently no trackers defined for this advertiser";
$GLOBALS['strConfirmDeleteTrackers'] = "Ydych chi wir am ddileu'r traciwr yma?";
$GLOBALS['strConfirmDeleteTracker'] = "Ydych chi wir am ddileu'r traciwr yma?";
$GLOBALS['strTrackerProperties'] = "Priodweddau Traciwr";
$GLOBALS['strDefaultStatus'] = "Rhagosodiad Statws";
$GLOBALS['strStatus'] = "Statws";
$GLOBALS['strLinkedTrackers'] = "Tracwyr Cysylltiedig";
$GLOBALS['strTrackerInformation'] = "Tracker Information";
$GLOBALS['strConversionWindow'] = "Ffenest trawsnewidiadau";
$GLOBALS['strUniqueWindow'] = "Ffenest unigryw";
$GLOBALS['strClick'] = "Clic";
$GLOBALS['strView'] = "Golwg";
$GLOBALS['strArrival'] = "Arrival";
$GLOBALS['strManual'] = "Manual";
$GLOBALS['strImpression'] = "Impression";
$GLOBALS['strConversionType'] = "Math trawsnewidiad";
$GLOBALS['strLinkCampaignsByDefault'] = "Cysylltwch ymgyrchoedd newydd yn ddiofyn";
$GLOBALS['strBackToTrackers'] = "Back to trackers";
$GLOBALS['strIPAddress'] = "IP Address";

// Banners (General)
$GLOBALS['strBanner'] = "Baner";
$GLOBALS['strBanners'] = "Baneri";
$GLOBALS['strAddBanner'] = "Ychwanegu baner newydd";
$GLOBALS['strAddBanner_Key'] = "Ychwanegu baner <u>n</u>ewydd";
$GLOBALS['strBannerToCampaign'] = "Eich ymgyrch";
$GLOBALS['strShowBanner'] = "Dangos baner";
$GLOBALS['strBannerProperties'] = "Priodweddau Baner";
$GLOBALS['strBannerHistory'] = "Banner Statistics";
$GLOBALS['strNoBanners'] = "There are currently no banners defined for this campaign.";
$GLOBALS['strNoBannersAddCampaign'] = "There are currently no banners defined, because there are no campaigns. To create a banner, <a href='campaign-edit.php?clientid=%s'>add a new campaign</a> first.";
$GLOBALS['strNoBannersAddAdvertiser'] = "Nid oes unrhyw wefan wedi cael ei ddiffinio hyd yma. I greu ardal, <a href='affiliate-edit.php'>ychwanegwch wefan newydd</a> yn gyntaf.";
$GLOBALS['strConfirmDeleteBanner'] = "Ydych chi wir am ddileu'r faner yma?";
$GLOBALS['strConfirmDeleteBanners'] = "Ydych chi wir am ddileu'r faner yma?";
$GLOBALS['strShowParentCampaigns'] = "Dangos ymgyrchoedd rhiant";
$GLOBALS['strHideParentCampaigns'] = "Cuddio ymgyrchoedd rhiant";
$GLOBALS['strHideInactiveBanners'] = "Cuddio baneri anweithredol";
$GLOBALS['strInactiveBannersHidden'] = "baner(i) anweithredol wedi cuddio";
$GLOBALS['strWarningMissing'] = "Rhybudd, y canlynol o bosib ar goll";
$GLOBALS['strWarningMissingClosing'] = " closing tag \">\"";
$GLOBALS['strWarningMissingOpening'] = " opening tag \"<\"";
$GLOBALS['strSubmitAnyway'] = "Argymell Beth Bynnag";
$GLOBALS['strBannersOfCampaign'] = "in"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "Banner Preferences";
$GLOBALS['strCampaignPreferences'] = "Campaign Preferences";
$GLOBALS['strDefaultBanners'] = "Default Banners";
$GLOBALS['strDefaultBannerUrl'] = "Default Image URL";
$GLOBALS['strDefaultBannerDestination'] = "Default Destination URL";
$GLOBALS['strAllowedBannerTypes'] = "Allowed Banner Types";
$GLOBALS['strTypeSqlAllow'] = "Caniatáu Baneri Lleol SQL";
$GLOBALS['strTypeWebAllow'] = "Caniatáu Baneri Lleol Gwe-weinydd";
$GLOBALS['strTypeUrlAllow'] = "Caniatáu Baneri Allanol";
$GLOBALS['strTypeHtmlAllow'] = "Caniatáu Baneri HTML";
$GLOBALS['strTypeTxtAllow'] = "Caniatáu Hysbysebion Testun";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Dewiswch math y baner";
$GLOBALS['strMySQLBanner'] = "Upload a local banner to the database";
$GLOBALS['strWebBanner'] = "Upload a local banner to the webserver";
$GLOBALS['strURLBanner'] = "Link an external banner";
$GLOBALS['strHTMLBanner'] = "Create an HTML banner";
$GLOBALS['strTextBanner'] = "Create a Text banner";
$GLOBALS['strAlterHTML'] = "Alter HTML to enable click tracking for:";
$GLOBALS['strIframeFriendly'] = "This banner can be safely displayed inside an iframe (e.g. is not expandable)";
$GLOBALS['strUploadOrKeep'] = "Ydych chi am gadw eich <br />llun presennol, neu ydych chi am <br />lanlwytho un arall?";
$GLOBALS['strNewBannerFile'] = "Dewiswch y llun yr ydych <br />am ei ddefnyddio ar gyfer y faner<br /><br />";
$GLOBALS['strNewBannerFileAlt'] = "Dewiswch y llun wrth gefn yr ydych <br />am ei ddefnyddio rhag ofn <br />nad yw'r porwr yn cefnogi cyfryngau cyfoethog<br />";
$GLOBALS['strNewBannerURL'] = "URL Llun (cynnwys. http://)";
$GLOBALS['strURL'] = "URL Gwefan (cynnwys. http://)";
$GLOBALS['strKeyword'] = "Allweddeiriau";
$GLOBALS['strTextBelow'] = "Testun dan y llun";
$GLOBALS['strWeight'] = "Pwysau";
$GLOBALS['strAlt'] = "Testun Alt";
$GLOBALS['strStatusText'] = "Testun statws";
$GLOBALS['strCampaignsWeight'] = "Campaign's Weight";
$GLOBALS['strBannerWeight'] = "Pwysau baner";
$GLOBALS['strBannersWeight'] = "Banner's Weight";
$GLOBALS['strAdserverTypeGeneric'] = "Baner HTML Generig";
$GLOBALS['strDoNotAlterHtml'] = "Do not alter HTML";
$GLOBALS['strGenericOutputAdServer'] = "Generig";
$GLOBALS['strSwfTransparency'] = "Caniatáu cefndir tryloyw";
$GLOBALS['strBackToBanners'] = "Back to banners";
$GLOBALS['strUseWyswygHtmlEditor'] = "Use WYSIWYG HTML Editor";
$GLOBALS['strChangeDefault'] = "Change default";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "Always prepend the following HTML code to this banner";
$GLOBALS['strBannerAppendHTML'] = "Always append the following HTML code to this banner";

// Banner (swf)
$GLOBALS['strCheckSWF'] = "Chwilio am ddolenni cod-caled tu fewn i'r ffeil Flash";
$GLOBALS['strConvertSWFLinks'] = "Trosi dolenni Flash";
$GLOBALS['strHardcodedLinks'] = "Dolenni cod-caled";
$GLOBALS['strConvertSWF'] = "<br />The Flash file you just uploaded contains hard-coded urls. {$PRODUCT_NAME} won't be able to track the number of Clicks for this banner unless you convert these hard-coded urls. Below you will find a list of all urls inside the Flash file. If you want to convert the urls, simply click <b>Convert</b>, otherwise click <b>Cancel</b>.<br /><br />Please note: if you click <b>Convert</b> the Flash file you just uploaded will be physically altered. <br />Please keep a backup of the original file. Regardless of in which version this banner was created, the resulting file will need the Flash 4 player (or higher) to display correctly.<br /><br />";
$GLOBALS['strCompressSWF'] = "Cywasgu ffeil SWF ar gyfer lawrlwytho cynt (Chwaraewr Flash 6 yn ofynnol)";
$GLOBALS['strOverwriteSource'] = "Trosysgrifo paramedr ffynhonnell";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "Dewisiadau Trosglwyddiad";
$GLOBALS['strACL'] = "Dewisiadau Trosglwyddiad";
$GLOBALS['strACLAdd'] = "Add delivery rule";
$GLOBALS['strApplyLimitationsTo'] = "Apply delivery rules to";
$GLOBALS['strAllBannersInCampaign'] = "All banners in this campaign";
$GLOBALS['strRemoveAllLimitations'] = "Remove all delivery rules";
$GLOBALS['strEqualTo'] = "yn hafal i";
$GLOBALS['strDifferentFrom'] = "yn wahanol i";
$GLOBALS['strLaterThan'] = "is later than";
$GLOBALS['strLaterThanOrEqual'] = "is later than or equal to";
$GLOBALS['strEarlierThan'] = "is earlier than";
$GLOBALS['strEarlierThanOrEqual'] = "is earlier than or equal to";
$GLOBALS['strContains'] = "contains";
$GLOBALS['strNotContains'] = "doesn't contain";
$GLOBALS['strGreaterThan'] = "yn fwy na";
$GLOBALS['strLessThan'] = "yn llai na";
$GLOBALS['strGreaterOrEqualTo'] = "is greater or equal to";
$GLOBALS['strLessOrEqualTo'] = "is less or equal to";
$GLOBALS['strAND'] = "A";                          // logical operator
$GLOBALS['strOR'] = "NEU";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Dangos y faner yma yn unig pan:";
$GLOBALS['strWeekDays'] = "Dyddiau o'r wythnos";
$GLOBALS['strTime'] = "Time";
$GLOBALS['strDomain'] = "Domain";
$GLOBALS['strSource'] = "Ffynhonnell";
$GLOBALS['strBrowser'] = "Browser";
$GLOBALS['strOS'] = "OS";
$GLOBALS['strDeliveryLimitations'] = "Delivery Rules";

$GLOBALS['strDeliveryCappingReset'] = "Ailosod rhifydd golwg ar ôl:";
$GLOBALS['strDeliveryCappingTotal'] = "mewn cyfanswm";
$GLOBALS['strDeliveryCappingSession'] = "y sesiwn ";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingBanner']['limit'] = "Cyfyngu golygon baner i:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingCampaign']['limit'] = "Cyfyngu golygon ymgyrch i:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingZone']['limit'] = "Cyfyngu golygon ardal i:";

// Website
$GLOBALS['strAffiliate'] = "Gwefan";
$GLOBALS['strAffiliates'] = "Gwefannau";
$GLOBALS['strAffiliatesAndZones'] = "Gwefannau ac Ardaloedd";
$GLOBALS['strAddNewAffiliate'] = "Ychwanegu gwefan newydd";
$GLOBALS['strAffiliateProperties'] = "Priodweddau Gwefan";
$GLOBALS['strAffiliateHistory'] = "Website Statistics";
$GLOBALS['strNoAffiliates'] = "Nid oes unrhyw wefan wedi cael ei ddiffinio hyd yma. I greu ardal, <a href='affiliate-edit.php'>ychwanegwch wefan newydd</a> yn gyntaf.";
$GLOBALS['strConfirmDeleteAffiliate'] = "Ydych chi wir am ddileu'r wefan yma?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Ydych chi wir am ddileu'r wefan yma?";
$GLOBALS['strInactiveAffiliatesHidden'] = "gwefan(nau) anweithredol wedi cuddio";
$GLOBALS['strShowParentAffiliates'] = "Dangos gwefannau rhiant";
$GLOBALS['strHideParentAffiliates'] = "Cuddio gwefannau rhiant";

// Website (properties)
$GLOBALS['strWebsite'] = "Gwefan";
$GLOBALS['strWebsiteURL'] = "Website URL";
$GLOBALS['strAllowAffiliateModifyZones'] = "Caniatáu i'r defnyddiwr newid ei ardaloedd ei hunan";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Caniatáu i'r defnyddiwr gysylltu baneri i'w ardaloedd ei hunan";
$GLOBALS['strAllowAffiliateAddZone'] = "Caniatáu i'r defnyddiwr ddiffinio ardaloedd newydd";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Caniatáu i'r defnyddiwr ddileu ardaloedd presennol";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Caniatáu i'r defnyddiwr gynhyrchu cod actifadu ei hunan";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "Cod Post";
$GLOBALS['strCountry'] = "Gwlad";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Gwefannau ac Ardaloedd";

// Zone
$GLOBALS['strZone'] = "Ardal";
$GLOBALS['strZones'] = "Ardaloedd";
$GLOBALS['strAddNewZone'] = "Ychwanegu ardal newydd";
$GLOBALS['strAddNewZone_Key'] = "Ychwanegu ardal <u>n</u>ewydd";
$GLOBALS['strZoneToWebsite'] = "Pob gwefan";
$GLOBALS['strLinkedZones'] = "Ardaloedd cysylltiedig";
$GLOBALS['strAvailableZones'] = "Available Zones";
$GLOBALS['strLinkingNotSuccess'] = "Linking not successful, please try again";
$GLOBALS['strZoneProperties'] = "Priodweddau Ardal";
$GLOBALS['strZoneHistory'] = "Hanes Ardal";
$GLOBALS['strNoZones'] = "There are currently no zones defined for this website.";
$GLOBALS['strNoZonesAddWebsite'] = "Nid oes unrhyw wefan wedi cael ei ddiffinio hyd yma. I greu ardal, <a href='affiliate-edit.php'>ychwanegwch wefan newydd</a> yn gyntaf.";
$GLOBALS['strConfirmDeleteZone'] = "Ydych chi wir am ddileu yr ardal yma?";
$GLOBALS['strConfirmDeleteZones'] = "Ydych chi wir am ddileu yr ardal yma?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "There are campaigns still linked to this zone, if you delete it these will not be able to run and you will not be paid for them.";
$GLOBALS['strZoneType'] = "Math ardal";
$GLOBALS['strBannerButtonRectangle'] = "Baner, Botwm neu Betryal";
$GLOBALS['strInterstitial'] = "DHTML Interstitaidd neu Arnawf";
$GLOBALS['strPopup'] = "Naidlen";
$GLOBALS['strTextAdZone'] = "Hysbyseb Testun";
$GLOBALS['strEmailAdZone'] = "Ardal Ebost/Cylchlythyr";
$GLOBALS['strZoneVideoInstream'] = "Inline Video ad";
$GLOBALS['strZoneVideoOverlay'] = "Overlay Video ad";
$GLOBALS['strShowMatchingBanners'] = "Dangos baneri sy'n cydweddu";
$GLOBALS['strHideMatchingBanners'] = "Cuddio baneri sy'n cydweddu";
$GLOBALS['strBannerLinkedAds'] = "Baneri sy'n gysylltiedig i'r ardal";
$GLOBALS['strCampaignLinkedAds'] = "Ymgyrchoedd sy'n gysylltiedig i'r ardal";
$GLOBALS['strInactiveZonesHidden'] = "ardal(oedd) anweithredol wedi cuddio";
$GLOBALS['strWarnChangeZoneType'] = "Bydd newid math yr ardal i testun neu ebost yn dad-gysylltu pob baner/ymgyrch oherwydd cyfyngderau'r mathau yma o ardaloedd
<ul>
<li>Gall ardaloedd testun gysylltu i hysbysebion testun yn unig</li>
<li>Gall ymgyrchoedd ardal ebost ddim ond gael un faner weithredol ar y tro</li>
</ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Bydd newid maint yr ardal yn dad-gysylltu unrhyw faneri sydd ddim o\'r maint newydd, ac yn ychwanegu unrhyw faneri o ymgyrchoedd cysylltiedig sydd o\'r maint newydd';
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
$GLOBALS['strAdvanced'] = "Uwch";
$GLOBALS['strChainSettings'] = "Gosodiadau cadwyn";
$GLOBALS['strZoneNoDelivery'] = "Os na ellir trosglwyddo unrhyw <br />faneri o'r ardal hon, ceisiwch...";
$GLOBALS['strZoneStopDelivery'] = "Atal trosglwyddo a peidio dangos baner";
$GLOBALS['strZoneOtherZone'] = "Arddangos yr ardal dewisedig yn lle";
$GLOBALS['strZoneAppend'] = "Atodi y cod HTML canlynol i faneri sy'n cael eu harddangos gan yr ardal hon bob tro";
$GLOBALS['strAppendSettings'] = "Gosodiadau Atodi a Rhagddodi";
$GLOBALS['strZonePrependHTML'] = "Rhagddodi y cod HTML i hysbysebion testun sy'n cael eu harddangos gan yr ardal hon bob tro";
$GLOBALS['strZoneAppendNoBanner'] = "Atodi hyd yn oed os na drosglwyddir baner";
$GLOBALS['strZoneAppendHTMLCode'] = "Cod HTML";
$GLOBALS['strZoneAppendZoneSelection'] = "Naidlen neu interstitaidd";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "Mae'r holl faneri sydd wedi'u cysylltu i'r ardal dewisedig yn anweithredol ar hyn o bryd. <br />Dyma'r gadwyn ardal a fydd yn cael ei ddilyn:";
$GLOBALS['strZoneProbNullPri'] = "Nid oes unrhyw faneri gweithredol wedi'u cysylltu i'r ardal hon.";
$GLOBALS['strZoneProbListChainLoop'] = "Byddai dilyn y gadwyn ardal yn achosi dolen gron. Mae trosglwyddo i'r ardal hon wedi ei atal.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Dewiswch beth i gysylltu i'r ardal hon";
$GLOBALS['strLinkedBanners'] = "Cysylltu baneri unigol";
$GLOBALS['strCampaignDefaults'] = "Cysylltu baneri wrth yr ymgyrch rhiant";
$GLOBALS['strLinkedCategories'] = "Cysylltu baneri wrth y categori";
$GLOBALS['strWithXBanners'] = "%d banner(s)";
$GLOBALS['strRawQueryString'] = "Allweddair";
$GLOBALS['strIncludedBanners'] = "Baneri Cysylltiedig";
$GLOBALS['strMatchingBanners'] = "{count} baner sy'n cydweddu";
$GLOBALS['strNoCampaignsToLink'] = "Nid oes unrhyw ymgyrch ar gael y gellir ei gysylltu i'r ardal hon";
$GLOBALS['strNoTrackersToLink'] = "Nid oes unrhyw draciwr ar gael y gellir ei gysylltu i'r ymgyrch hon";
$GLOBALS['strNoZonesToLinkToCampaign'] = "Nid oes unrhyw ardal ar gael y gellir cysylltu'r ymgyrch â hi";
$GLOBALS['strSelectBannerToLink'] = "Dewiswch y faner yr hoffech chi gysylltu â'r ardal hon:";
$GLOBALS['strSelectCampaignToLink'] = "Dewiswch yr ymgyrch yr hoffech chi gysylltu â'r ardal hon:";
$GLOBALS['strSelectAdvertiser'] = "Dewiswch Hysbysebwr";
$GLOBALS['strSelectPlacement'] = "Dewiswch Ymgyrch";
$GLOBALS['strSelectAd'] = "Dewiswch Faner";
$GLOBALS['strSelectPublisher'] = "Select Website";
$GLOBALS['strSelectZone'] = "Select Zone";
$GLOBALS['strStatusPending'] = "Dan Ystyriaeth";
$GLOBALS['strStatusApproved'] = "Approved";
$GLOBALS['strStatusDisapproved'] = "Disapproved";
$GLOBALS['strStatusDuplicate'] = "Dyblygu";
$GLOBALS['strStatusOnHold'] = "On Hold";
$GLOBALS['strStatusIgnore'] = "Ignore";
$GLOBALS['strConnectionType'] = "Math";
$GLOBALS['strConnTypeSale'] = "Sale";
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Signup";
$GLOBALS['strShortcutEditStatuses'] = "Golygu statysau";
$GLOBALS['strShortcutShowStatuses'] = "Dangos statysau";

// Statistics
$GLOBALS['strStats'] = "Ystadegau";
$GLOBALS['strNoStats'] = "Nid oes unrhyw ystadegau ar gael ar hyn o bryd";
$GLOBALS['strNoStatsForPeriod'] = "Nid oes unrhyw ystadegau ar gael ar gyfer cyfnod %s i %s ar hyn o bryd";
$GLOBALS['strGlobalHistory'] = "Global Statistics";
$GLOBALS['strDailyHistory'] = "Daily Statistics";
$GLOBALS['strDailyStats'] = "Daily Statistics";
$GLOBALS['strWeeklyHistory'] = "Weekly Statistics";
$GLOBALS['strMonthlyHistory'] = "Monthly Statistics";
$GLOBALS['strTotalThisPeriod'] = "Cyfanswm ar gyfer cyfnod";
$GLOBALS['strPublisherDistribution'] = "Dosbarthiad gwefan";
$GLOBALS['strCampaignDistribution'] = "Dosbarthiad Ymgyrch";
$GLOBALS['strViewBreakdown'] = "Golwg gan";
$GLOBALS['strBreakdownByDay'] = "Diwrnod";
$GLOBALS['strBreakdownByWeek'] = "Wythnos";
$GLOBALS['strBreakdownByMonth'] = "Mis";
$GLOBALS['strBreakdownByDow'] = "Diwrnod yr wythnos";
$GLOBALS['strBreakdownByHour'] = "Awr";
$GLOBALS['strItemsPerPage'] = "Eitem y tudalen";
$GLOBALS['strDistributionHistoryCampaign'] = "Distribution Statistics (Campaign)";
$GLOBALS['strDistributionHistoryBanner'] = "Distribution Statistics (Banner)";
$GLOBALS['strDistributionHistoryWebsite'] = "Distribution Statistics (Website)";
$GLOBALS['strDistributionHistoryZone'] = "Distribution Statistics (Zone)";
$GLOBALS['strShowGraphOfStatistics'] = "Dangos yr Ystadegau fel <u>G</u>raff";
$GLOBALS['strExportStatisticsToExcel'] = "Allforio'r Ystadegau i Excel";
$GLOBALS['strGDnotEnabled'] = "You must have GD enabled in PHP to display graphs. <br />Please see <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> for more information, including how to install GD on your server.";
$GLOBALS['strStatsArea'] = "Area";

// Expiration
$GLOBALS['strNoExpiration'] = "Dyddiad dod i ben heb ei osod";
$GLOBALS['strEstimated'] = "Dyddiad dod i ben amcangyfrifol";
$GLOBALS['strNoExpirationEstimation'] = "No expiration estimated yet";
$GLOBALS['strDaysAgo'] = "days ago";
$GLOBALS['strCampaignStop'] = "Hanes ymgyrch";

// Reports
$GLOBALS['strAdvancedReports'] = "Advanced Reports";
$GLOBALS['strStartDate'] = "Start Date";
$GLOBALS['strEndDate'] = "End Date";
$GLOBALS['strPeriod'] = "Period";
$GLOBALS['strLimitations'] = "Delivery Rules";
$GLOBALS['strWorksheets'] = "Worksheets";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "Pob hysbysebwr";
$GLOBALS['strAnonAdvertisers'] = "Hysbysebwyr anhysbys";
$GLOBALS['strAllPublishers'] = "Pob gwefan";
$GLOBALS['strAnonPublishers'] = "Gwefannau anhysbys";
$GLOBALS['strAllAvailZones'] = "Pob ardal posib";

// Userlog
$GLOBALS['strUserLog'] = "Log Defnyddiwr";
$GLOBALS['strUserLogDetails'] = "Manylion log defnyddiwr";
$GLOBALS['strDeleteLog'] = "Dileu log";
$GLOBALS['strAction'] = "Gweithred";
$GLOBALS['strNoActionsLogged'] = "Dim gweithredoedd wedi'u logio";

// Code generation
$GLOBALS['strGenerateBannercode'] = "Dewis uniongyrchol";
$GLOBALS['strChooseInvocationType'] = "Dewiswch y math o actifadu baneri";
$GLOBALS['strGenerate'] = "Cynhyrchu";
$GLOBALS['strParameters'] = "Gosodiadau Tagiau";
$GLOBALS['strFrameSize'] = "Maint ffram";
$GLOBALS['strBannercode'] = "Codbaner";
$GLOBALS['strTrackercode'] = "Trackercode";
$GLOBALS['strBackToTheList'] = "Mynd yn ôl i'r rhestr adroddiadau";
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
$GLOBALS['strErrorDatabaseConnection'] = "Database connection error.";
$GLOBALS['strErrorCantConnectToDatabase'] = "A fatal error occurred %1\$s can't connect to the database. Because
                                                   of this it isn't possible to use the administrator interface. The delivery
                                                   of banners might also be affected. Possible reasons for the problem are:
                                                   <ul>
                                                     <li>The database server isn't functioning at the moment</li>
                                                     <li>The location of the database server has changed</li>
                                                     <li>The username or password used to contact the database server are not correct</li>
                                                     <li>PHP has not loaded the <i>%2\$s</i> extension</li>
                                                   </ul>";
$GLOBALS['strNoMatchesFound'] = "Methwyd darganfod cydweddiadau";
$GLOBALS['strErrorOccurred'] = "Bu gwall";
$GLOBALS['strErrorDBPlain'] = "Bu gwall tra'n cyrchu'r gronfa ddata";
$GLOBALS['strErrorDBSerious'] = "Datgelwyd problem ddifrifol gyda'r gronfa ddata";
$GLOBALS['strErrorDBNoDataPlain'] = "Due to a problem with the database {$PRODUCT_NAME} couldn't retrieve or store data. ";
$GLOBALS['strErrorDBNoDataSerious'] = "Due to a serious problem with the database, {$PRODUCT_NAME} couldn't retrieve data";
$GLOBALS['strErrorDBCorrupt'] = "The database table is probably corrupt and needs to be repaired. For more information about repairing corrupted tables please read the chapter <i>Troubleshooting</i> of the <i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact'] = "Cysylltwch â gweinyddwr y gweinydd a'i hysbysu o'r broblem.";
$GLOBALS['strErrorDBSubmitBug'] = "If this problem is reproducable it might be caused by a bug in {$PRODUCT_NAME}. Please report the following information to the creators of {$PRODUCT_NAME}. Also try to describe the actions that led to this error as clearly as possible.";
$GLOBALS['strMaintenanceNotActive'] = "The maintenance script has not been run in the last 24 hours.
In order for the application to function correctly it needs to run
every hour.

Please read the Administrator guide for more information
about configuring the maintenance script.";
$GLOBALS['strErrorLinkingBanner'] = "It was not possible to link this banner to this zone because:";
$GLOBALS['strUnableToLinkBanner'] = "Methwyd cysylltu'r baner:";
$GLOBALS['strErrorEditingCampaignRevenue'] = "incorrect number format in Revenue Information field";
$GLOBALS['strErrorEditingCampaignECPM'] = "incorrect number format in ECPM Information field";
$GLOBALS['strErrorEditingZone'] = "Error updating zone:";
$GLOBALS['strUnableToChangeZone'] = "Methwyd gweithredu'r newidiad oherwydd:";
$GLOBALS['strDatesConflict'] = "dyddiadau'n gwrthdaro gyda:";
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
$GLOBALS['strSirMadam'] = "Syr/Madam";
$GLOBALS['strMailSubject'] = "Adroddiad Hysbysebwr";
$GLOBALS['strMailHeader'] = "Dear {contact},";
$GLOBALS['strMailBannerStats'] = "Isod byddwch yn darganfod ystadegau baner ar gyfer {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Ymgyrch wedi ysgogi";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Ymgyrch wedi dad-ysgogi";
$GLOBALS['strMailBannerActivated'] = "Your campaign shown below has been activated because
the campaign activation date has been reached.";
$GLOBALS['strMailBannerDeactivated'] = "Mae eich ymgyrch a ddangosir isod wedi cael ei ddad-ysgogi achos";
$GLOBALS['strMailFooter'] = "Regards,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "Nid yw'r ymgyrch yn weithredol ar hyn o bryd oherwydd";
$GLOBALS['strBeforeActivate'] = "nad yw'r dyddiad ysgogi wedi cyrraedd eto";
$GLOBALS['strAfterExpire'] = "nad yw'r dyddiad gorffen weddi cyrraedd";
$GLOBALS['strNoMoreImpressions'] = "nad oes Argraffiadau yn weddill";
$GLOBALS['strNoMoreClicks'] = "nad oes Cliciau yn weddill";
$GLOBALS['strNoMoreConversions'] = "nad oes gwerthiannau yn weddill";
$GLOBALS['strWeightIsNull'] = "bod y pwysau wedi ei osod i sero";
$GLOBALS['strRevenueIsNull'] = "its revenue is set to zero";
$GLOBALS['strTargetIsNull'] = "its limit per day is set to zero - you need to either specify both an end date and a limit or set Limit per day value";
$GLOBALS['strNoViewLoggedInInterval'] = "Ni logiwyd unrhyw Argraffiadau yn ystod cyfnod yr adroddiad hwn";
$GLOBALS['strNoClickLoggedInInterval'] = "Ni logiwyd unrhyw Gliciau yn ystod cyfnod yr adroddiad hwn";
$GLOBALS['strNoConversionLoggedInInterval'] = "Ni logiwyd unrhyw Drawsnewidiadau yn ystod cyfnod yr adroddiad hwn";
$GLOBALS['strMailReportPeriod'] = "Mae'r adroddiad hwn yn cynnwys ystadegau o {startdate} hyd at {enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "Mae'r adroddiad hwn yn cynnwys yr holl ystadegau hyd at {enddate}.";
$GLOBALS['strNoStatsForCampaign'] = "Nid oes ystadegau ar gael ar gyfer yr ymgyrch hon";
$GLOBALS['strImpendingCampaignExpiry'] = "Diwedd cyfnod yr ymgyrch yn agos";
$GLOBALS['strYourCampaign'] = "Eich ymgyrch";
$GLOBALS['strTheCampiaignBelongingTo'] = "Yr ymgyrch sy'n perthyn i";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "Mae {clientname} a ddangosir isod yn dod i ben ar {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "Mae gan {clientname} a ddangosir isod lai na {limit} argraffiad yn weddill.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "As a result, the campaign will soon be automatically disabled, and the
following banners in the campaign will also be disabled:";

// Priority
$GLOBALS['strPriority'] = "Blaenoriaeth";
$GLOBALS['strSourceEdit'] = "Golygu Ffynonellau";

// Preferences
$GLOBALS['strPreferences'] = "Dewisiadau";
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
$GLOBALS['strERPM'] = "CPM";
$GLOBALS['strERPC'] = "CPC";
$GLOBALS['strERPS'] = "CPM";
$GLOBALS['strEIPM'] = "CPM";
$GLOBALS['strEIPC'] = "CPC";
$GLOBALS['strEIPS'] = "CPM";
$GLOBALS['strECPM'] = "CPM";
$GLOBALS['strECPC'] = "CPC";
$GLOBALS['strECPS'] = "CPM";
$GLOBALS['strPendingConversions'] = "Pending conversions";
$GLOBALS['strImpressionSR'] = "Argraffiadau";
$GLOBALS['strClickSR'] = "Click SR";

// Short names
$GLOBALS['strRevenue_short'] = "Rev.";
$GLOBALS['strBasketValue_short'] = "BV";
$GLOBALS['strNumberOfItems_short'] = "Num. Items";
$GLOBALS['strRevenueCPC_short'] = "Rev. CPC";
$GLOBALS['strERPM_short'] = "CPM";
$GLOBALS['strERPC_short'] = "CPC";
$GLOBALS['strERPS_short'] = "CPM";
$GLOBALS['strEIPM_short'] = "CPM";
$GLOBALS['strEIPC_short'] = "CPC";
$GLOBALS['strEIPS_short'] = "CPM";
$GLOBALS['strECPM_short'] = "CPM";
$GLOBALS['strECPC_short'] = "CPC";
$GLOBALS['strECPS_short'] = "CPM";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strRequests_short'] = "Req.";
$GLOBALS['strImpressions_short'] = "Impr.";
$GLOBALS['strClicks_short'] = "Cliciau";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "Conv.";
$GLOBALS['strPendingConversions_short'] = "Pend conv.";
$GLOBALS['strImpressionSR_short'] = "Impr. SR";
$GLOBALS['strClickSR_short'] = "Click SR";

// Global Settings
$GLOBALS['strConfiguration'] = "Configuration";
$GLOBALS['strGlobalSettings'] = "Gosodiadau Cyffredinol";
$GLOBALS['strGeneralSettings'] = "Gosodiadau Cyffredinol";
$GLOBALS['strMainSettings'] = "Prif Osodiadau";
$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strChooseSection'] = 'Choose Section';

// Product Updates
$GLOBALS['strProductUpdates'] = "Diweddariadau Cynnyrch";
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
$GLOBALS['strAddAgency_Key'] = "Ychwanegu ardal <u>n</u>ewydd";
$GLOBALS['strTotalAgencies'] = "Total accounts";
$GLOBALS['strAgencyProperties'] = "Account Properties";
$GLOBALS['strNoAgencies'] = "Nid oes unrhyw gyfrifon wedi eu diffinio eto";
$GLOBALS['strConfirmDeleteAgency'] = "Ydych chi wir am ddileu y cyfrif yma?";
$GLOBALS['strHideInactiveAgencies'] = "Hide inactive accounts";
$GLOBALS['strInactiveAgenciesHidden'] = "cyfrif(on) anweithredol wedi cuddio";
$GLOBALS['strSwitchAccount'] = "Switch to this account";

// Channels
$GLOBALS['strChannel'] = "Delivery Rule Set";
$GLOBALS['strChannels'] = "Delivery Rule Sets";
$GLOBALS['strChannelManagement'] = "Delivery Rule Set Management";
$GLOBALS['strAddNewChannel'] = "Add new Delivery Rule Set";
$GLOBALS['strAddNewChannel_Key'] = "Add <u>n</u>ew Delivery Rule Set";
$GLOBALS['strChannelToWebsite'] = "Pob gwefan";
$GLOBALS['strNoChannels'] = "There are currently no delivery rule sets defined";
$GLOBALS['strNoChannelsAddWebsite'] = "There are currently no delivery rule sets defined, because there are no websites. To create a delivery rule set, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strEditChannelLimitations'] = "Edit delivery rules for the delivery rule set";
$GLOBALS['strChannelProperties'] = "Delivery Rule Set Properties";
$GLOBALS['strChannelLimitations'] = "Dewisiadau Trosglwyddiad";
$GLOBALS['strConfirmDeleteChannel'] = "Do you really want to delete this delivery rule set?";
$GLOBALS['strConfirmDeleteChannels'] = "Do you really want to delete the selected delivery rule sets?";
$GLOBALS['strChannelsOfWebsite'] = 'in'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "Variable Name";
$GLOBALS['strVariableDescription'] = "Disgrifiad";
$GLOBALS['strVariableDataType'] = "Data Type";
$GLOBALS['strVariablePurpose'] = "Purpose";
$GLOBALS['strGeneric'] = "Generig";
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
$GLOBALS['strTrackerType'] = "Enw Traciwr";
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
$GLOBALS['strCampaignAuditTrailSetup'] = "Ysgogi Trywydd Archwilio er mwyn cychwyn gweld Ymgyrchoedd";

$GLOBALS['strUnsavedChanges'] = "You have unsaved changes on this page, make sure you press &quot;Save Changes&quot; when finished";
$GLOBALS['strDeliveryLimitationsDisagree'] = "WARNING: The cached delivery rules <strong>DO NOT AGREE</strong> with the delivery rules shown below<br />Please hit save changes to update the cached delivery rules";
$GLOBALS['strDeliveryRulesDbError'] = "WARNING: When saving the delivery rules, a database error occured. Please check the delivery rules below carefully, and update, if required.";
$GLOBALS['strDeliveryRulesTruncation'] = "WARNING: When saving the delivery rules, MySQL truncated the data, so the original values were restored. Please reduce your rule size, and try again.";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Some delivery rules report incorrect values:";

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
$GLOBALS['strWebsiteHasBeenDuplicated'] = "Website <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";

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

$GLOBALS['strChannelHasBeenAdded'] = "Delivery rule set <a href='%s'>%s</a> has been added. <a href='%s'>Set the delivery rules.</a>";
$GLOBALS['strChannelHasBeenUpdated'] = "Delivery rule set <a href='%s'>%s</a> has been updated";
$GLOBALS['strChannelAclHasBeenUpdated'] = "Delivery options for the delivery rule set <a href='%s'>%s</a> have been updated";
$GLOBALS['strChannelHasBeenDeleted'] = "Delivery rule set <b>%s</b> has been deleted";
$GLOBALS['strChannelsHaveBeenDeleted'] = "All selected delivery rule sets have been deleted";
$GLOBALS['strChannelHasBeenDuplicated'] = "Delivery rule set <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";

$GLOBALS['strUserPreferencesUpdated'] = "Your <b>%s</b> preferences has been updated";
$GLOBALS['strEmailChanged'] = "Your E-mail has been changed";
$GLOBALS['strPasswordChanged'] = "Your password has been changed";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "<b>%s</b> have been updated";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "<b>%s</b> have been updated";
$GLOBALS['strTZPreferencesWarning'] = "However, campaign activation and expiry were not updated, nor time-based banner delivery rules.<br />You will need to update them manually if you wish them to use the new timezone";

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
