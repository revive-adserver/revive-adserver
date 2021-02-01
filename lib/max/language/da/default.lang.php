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

$GLOBALS['strHome'] = "Start";
$GLOBALS['strHelp'] = "Hjælp";
$GLOBALS['strStartOver'] = "Start forfra";
$GLOBALS['strShortcuts'] = "Genveje";
$GLOBALS['strActions'] = "Aktion";
$GLOBALS['strAndXMore'] = "and %s more";
$GLOBALS['strAdminstration'] = "Portfolio";
$GLOBALS['strMaintenance'] = "Vedligholdelse";
$GLOBALS['strProbability'] = "Sandsynlighed";
$GLOBALS['strInvocationcode'] = "Kalde Kode";
$GLOBALS['strBasicInformation'] = "Basis information";
$GLOBALS['strAppendTrackerCode'] = "Vedhæft Tracker Kode";
$GLOBALS['strOverview'] = "oversigt";
$GLOBALS['strSearch'] = "<u>S</u>øg";
$GLOBALS['strDetails'] = "Detaljer";
$GLOBALS['strUpdateSettings'] = "Update Settings";
$GLOBALS['strCheckForUpdates'] = "Tjek for opdateringer";
$GLOBALS['strWhenCheckingForUpdates'] = "When checking for updates";
$GLOBALS['strCompact'] = "Kompakt";
$GLOBALS['strUser'] = "Bruger";
$GLOBALS['strDuplicate'] = "Kopier";
$GLOBALS['strCopyOf'] = "Copy of";
$GLOBALS['strMoveTo'] = "Flyt til";
$GLOBALS['strDelete'] = "Slet";
$GLOBALS['strActivate'] = "Aktiver";
$GLOBALS['strConvert'] = "Konverter";
$GLOBALS['strRefresh'] = "Opdater";
$GLOBALS['strSaveChanges'] = "Gem ændringer";
$GLOBALS['strUp'] = "Op";
$GLOBALS['strDown'] = "Ned";
$GLOBALS['strSave'] = "Gem";
$GLOBALS['strCancel'] = "Fortryd";
$GLOBALS['strBack'] = "Tilbage";
$GLOBALS['strPrevious'] = "Forrige";
$GLOBALS['strNext'] = "Næste";
$GLOBALS['strYes'] = "Ja";
$GLOBALS['strNo'] = "Nej";
$GLOBALS['strNone'] = "Ingen";
$GLOBALS['strCustom'] = "Tilpas";
$GLOBALS['strDefault'] = "Standard";
$GLOBALS['strUnknown'] = "Unknown";
$GLOBALS['strUnlimited'] = "Ubegrænset";
$GLOBALS['strUntitled'] = "Uden titel";
$GLOBALS['strAll'] = "all";
$GLOBALS['strAverage'] = "Gennemsnit";
$GLOBALS['strOverall'] = "Total";
$GLOBALS['strTotal'] = "Total";
$GLOBALS['strFrom'] = "From";
$GLOBALS['strTo'] = "til";
$GLOBALS['strAdd'] = "Add";
$GLOBALS['strLinkedTo'] = "linked til";
$GLOBALS['strDaysLeft'] = "Dage tilbage";
$GLOBALS['strCheckAllNone'] = "Kontroller alt / intet";
$GLOBALS['strKiloByte'] = "kb";
$GLOBALS['strExpandAll'] = "<u>V</u>is alle";
$GLOBALS['strCollapseAll'] = "<u>S</u>kjul alle";
$GLOBALS['strShowAll'] = "Vis alt";
$GLOBALS['strNoAdminInterface'] = "Administrators skærmbillede er slukket på grund af vedligeholdelse. Dette påvirker ikke leveringen af din kampagne.";
$GLOBALS['strFieldStartDateBeforeEnd'] = "'From' date must be earlier then 'To' date";
$GLOBALS['strFieldContainsErrors'] = "Følgende felter indeholder fejl:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Før du kan fortsætte behøver du";
$GLOBALS['strFieldFixBeforeContinue2'] = "at rette følgende fejl.";
$GLOBALS['strMiscellaneous'] = "Tilbehør";
$GLOBALS['strCollectedAllStats'] = "Komplet statistik";
$GLOBALS['strCollectedToday'] = "Idag";
$GLOBALS['strCollectedYesterday'] = "I går";
$GLOBALS['strCollectedThisWeek'] = "Denne uge";
$GLOBALS['strCollectedLastWeek'] = "Sidste uge";
$GLOBALS['strCollectedThisMonth'] = "Denne måned";
$GLOBALS['strCollectedLastMonth'] = "Sidste måned";
$GLOBALS['strCollectedLast7Days'] = "Seneste 7 dage";
$GLOBALS['strCollectedSpecificDates'] = "Specifikke dage";
$GLOBALS['strValue'] = "Værdi";
$GLOBALS['strWarning'] = "Advarsel";
$GLOBALS['strNotice'] = "Besked";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "The dashboard can not be displayed";
$GLOBALS['strNoCheckForUpdates'] = "The dashboard cannot be displayed unless the<br />check for updates setting is enabled.";
$GLOBALS['strEnableCheckForUpdates'] = "Please enable the <a href='account-settings-update.php' target='_top'>check for updates</a> setting on the<br/><a href='account-settings-update.php' target='_top'>update settings</a> page.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "code";
$GLOBALS['strDashboardSystemMessage'] = "System message";
$GLOBALS['strDashboardErrorHelp'] = "If this error repeats please describe your problem in detail and post it on <a href='http://forum.revive-adserver.com/'>forum.revive-adserver.com/</a>.";

// Priority
$GLOBALS['strPriority'] = "Prioritet";
$GLOBALS['strPriorityLevel'] = "Prioritets niveau";
$GLOBALS['strOverrideAds'] = "Override Campaign Advertisements";
$GLOBALS['strHighAds'] = "Contract Campaign Advertisements";
$GLOBALS['strECPMAds'] = "eCPM Campaign Advertisements";
$GLOBALS['strLowAds'] = "Remnant Campaign Advertisements";
$GLOBALS['strLimitations'] = "Delivery rules";
$GLOBALS['strNoLimitations'] = "No delivery rules";
$GLOBALS['strCapping'] = "Rammer";

// Properties
$GLOBALS['strName'] = "Navn";
$GLOBALS['strSize'] = "Størrelse";
$GLOBALS['strWidth'] = "Bredde";
$GLOBALS['strHeight'] = "Højde";
$GLOBALS['strTarget'] = "Mål";
$GLOBALS['strLanguage'] = "Sprog";
$GLOBALS['strDescription'] = "Beskrivelse";
$GLOBALS['strVariables'] = "Variabler";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "Kommentarer";

// User access
$GLOBALS['strWorkingAs'] = "Arbejder som";
$GLOBALS['strWorkingAs_Key'] = "<u>W</u>orking as";
$GLOBALS['strWorkingAs'] = "Arbejder som";
$GLOBALS['strSwitchTo'] = "Skift til";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "Use the switcher's search box to find more accounts";
$GLOBALS['strWorkingFor'] = "%s for...";
$GLOBALS['strNoAccountWithXInNameFound'] = "No accounts with \"%s\" in name found";
$GLOBALS['strRecentlyUsed'] = "Recently used";
$GLOBALS['strLinkUser'] = "Add user";
$GLOBALS['strLinkUser_Key'] = "Link <u>b</u>ruger";
$GLOBALS['strUsernameToLink'] = "Username of user to add";
$GLOBALS['strNewUserWillBeCreated'] = "Ny bruger vil blive oprettet";
$GLOBALS['strToLinkProvideEmail'] = "For at tilføje brugere, angiv brugerens email";
$GLOBALS['strToLinkProvideUsername'] = "For at tilføje bruger, angiv brugernavn";
$GLOBALS['strUserLinkedToAccount'] = "Bruger er blevet tilføjet til konto";
$GLOBALS['strUserAccountUpdated'] = "Bruger konto opdateret";
$GLOBALS['strUserUnlinkedFromAccount'] = "Bruger er fjernet fra konto";
$GLOBALS['strUserWasDeleted'] = "Bruger er blevet slettet";
$GLOBALS['strUserNotLinkedWithAccount'] = "Such user is not linked with account";
$GLOBALS['strCantDeleteOneAdminUser'] = "You can't delete a user. At least one user needs to be linked with admin account.";
$GLOBALS['strLinkUserHelp'] = "To add an <b>existing user</b>, type the %1\$s and click %2\$s <br />To add a <b>new user</b>, type the desired %1\$s and click %2\$s";
$GLOBALS['strLinkUserHelpUser'] = "Brugernavn";
$GLOBALS['strLinkUserHelpEmail'] = "Email adresse";
$GLOBALS['strLastLoggedIn'] = "Last logged in";
$GLOBALS['strDateLinked'] = "Date linked";

// Login & Permissions
$GLOBALS['strUserAccess'] = "Bruger Adgang";
$GLOBALS['strAdminAccess'] = "Admin Access";
$GLOBALS['strUserProperties'] = "Bruger Indstillinger";
$GLOBALS['strPermissions'] = "Tilladelser";
$GLOBALS['strAuthentification'] = "Ægtheds kontrol";
$GLOBALS['strWelcomeTo'] = "Velkommen til";
$GLOBALS['strEnterUsername'] = "Indtast dit brugernavn og kodeord for at logge ind";
$GLOBALS['strEnterBoth'] = "Indtast venligs både dit brugernavn og kodeord";
$GLOBALS['strEnableCookies'] = "You need to enable cookies before you can use {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "Session cookie error, please log in again";
$GLOBALS['strLogin'] = "Log ind";
$GLOBALS['strLogout'] = "Log ud";
$GLOBALS['strUsername'] = "Brugernavn";
$GLOBALS['strPassword'] = "Kodeord";
$GLOBALS['strPasswordRepeat'] = "Gentag kodeordet";
$GLOBALS['strAccessDenied'] = "Adgang nægtet";
$GLOBALS['strUsernameOrPasswordWrong'] = "Brugernavnet og/eller kodeordet er ikke korrekt. Venligst prøv igen.";
$GLOBALS['strPasswordWrong'] = "Kodeordet er ikke korrekt.";
$GLOBALS['strNotAdmin'] = "Your account does not have the required permissions to use this feature, you can log into another account to use it.";
$GLOBALS['strDuplicateClientName'] = "Brugernavnet du har oplyst eksistere allerede, venligst anvend en anden brugenavn";
$GLOBALS['strInvalidPassword'] = "Kodeorder er ikke korrekt. Venligst anvend et andet kodeord.";
$GLOBALS['strInvalidEmail'] = "The email is not correctly formatted, please put a correct email address.";
$GLOBALS['strNotSamePasswords'] = "De to kodeord du har oplyst er ikke ens.";
$GLOBALS['strRepeatPassword'] = "Gentag kodeordet";
$GLOBALS['strDeadLink'] = "Your link is invalid.";
$GLOBALS['strNoPlacement'] = "Selected campaign does not exist. Try this <a href='{link}'>link</a> instead";
$GLOBALS['strNoAdvertiser'] = "Selected advertiser does not exist. Try this <a href='{link}'>link</a> instead";

// General advertising
$GLOBALS['strRequests'] = "Forespørgelser";
$GLOBALS['strImpressions'] = "Visninger";
$GLOBALS['strClicks'] = "Klik";
$GLOBALS['strConversions'] = "Conversions";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "Total antal klik";
$GLOBALS['strTotalConversions'] = "Total Antal Conversions";
$GLOBALS['strDateTime'] = "Dato tid";
$GLOBALS['strTrackerID'] = "Tracker ID";
$GLOBALS['strTrackerName'] = "Tracker navn";
$GLOBALS['strTrackerImageTag'] = "Image Tag";
$GLOBALS['strTrackerJsTag'] = "Javascript Tag";
$GLOBALS['strTrackerAlwaysAppend'] = "Always display appended code, even if no conversion is recorded by the tracker?";
$GLOBALS['strBanners'] = "Banner";
$GLOBALS['strCampaigns'] = "Kampagne";
$GLOBALS['strCampaignID'] = "Kampagne ID";
$GLOBALS['strCampaignName'] = "Kampagne navn";
$GLOBALS['strCountry'] = "Land";
$GLOBALS['strStatsAction'] = "Aktion";
$GLOBALS['strWindowDelay'] = "Vindues forsinkelse";
$GLOBALS['strStatsVariables'] = "Variabler";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Månedelig afgift";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strFinanceCR'] = "CR";

// Time and date related
$GLOBALS['strDate'] = "Dato";
$GLOBALS['strDay'] = "Dag";
$GLOBALS['strDays'] = "Dage";
$GLOBALS['strWeek'] = "Uge";
$GLOBALS['strWeeks'] = "Uger";
$GLOBALS['strSingleMonth'] = "Måned";
$GLOBALS['strMonths'] = "Måneder";
$GLOBALS['strDayOfWeek'] = "Ugedag";


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

$GLOBALS['strHour'] = "Time";
$GLOBALS['strSeconds'] = "Sekunder";
$GLOBALS['strMinutes'] = "minutter";
$GLOBALS['strHours'] = "timer";

// Advertiser
$GLOBALS['strClient'] = "Annoncør";
$GLOBALS['strClients'] = "Annoncører";
$GLOBALS['strClientsAndCampaigns'] = "Annoncører & Kampagne";
$GLOBALS['strAddClient'] = "Tilføj ny annoncør";
$GLOBALS['strClientProperties'] = "Annoncør egenskaber";
$GLOBALS['strClientHistory'] = "Advertiser Statistics";
$GLOBALS['strNoClients'] = "Der er ikke valgt nogen annoncør. For at oprette en kampagne <a href='advertiser-edit.php'>kan du oprette en annoncør</a> først.";
$GLOBALS['strConfirmDeleteClient'] = "Vil du virkelig slette denne annoncør?";
$GLOBALS['strConfirmDeleteClients'] = "Vil du virkelig slette denne annoncør?";
$GLOBALS['strHideInactive'] = "Hide inactive";
$GLOBALS['strInactiveAdvertisersHidden'] = "Inaktive annoncør(er) er skjult";
$GLOBALS['strAdvertiserSignup'] = "Annoncør Oprettelse";
$GLOBALS['strAdvertiserCampaigns'] = "Annoncører & Kampagne";

// Advertisers properties
$GLOBALS['strContact'] = "Kontakt";
$GLOBALS['strContactName'] = "Kontakt Navn";
$GLOBALS['strEMail'] = "E-mail";
$GLOBALS['strSendAdvertisingReport'] = "Leverings rapport for E-mail kampagne";
$GLOBALS['strNoDaysBetweenReports'] = "Antal dage mellem kampagne leverings rapport";
$GLOBALS['strSendDeactivationWarning'] = "E-mail når en kampagne automatisk er aktiveret/deaktiveret";
$GLOBALS['strAllowClientModifyBanner'] = "Tillad denne bruger at modificere egne bannere";
$GLOBALS['strAllowClientDisableBanner'] = "Tillad denne bruger at deaktivere egne bannere";
$GLOBALS['strAllowClientActivateBanner'] = "Tillad denne bruger at aktivere egen bannere";
$GLOBALS['strAllowCreateAccounts'] = "Allow this user to manage this account's users";
$GLOBALS['strAdvertiserLimitation'] = "Display only one banner from this advertiser on a web page";
$GLOBALS['strAllowAuditTrailAccess'] = "Allow this user to access the audit trail";
$GLOBALS['strAllowDeleteItems'] = "Allow this user to delete items";

// Campaign
$GLOBALS['strCampaign'] = "Kampagne";
$GLOBALS['strCampaigns'] = "Kampagne";
$GLOBALS['strAddCampaign'] = "Tilføj ny kampagne";
$GLOBALS['strAddCampaign_Key'] = "Tilføj <u>n/u>ew kampagne";
$GLOBALS['strCampaignForAdvertiser'] = "for advertiser";
$GLOBALS['strLinkedCampaigns'] = "Relaterede kampagner";
$GLOBALS['strCampaignProperties'] = "Kampagne egenskaber";
$GLOBALS['strCampaignOverview'] = "Kampagne oversigt";
$GLOBALS['strCampaignHistory'] = "Campaign Statistics";
$GLOBALS['strNoCampaigns'] = "There are currently no campaigns defined for this advertiser.";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "There are currently no campaigns defined, because there are no advertisers. To create a campaign, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
$GLOBALS['strConfirmDeleteCampaign'] = "Vil du virkelig slette denne aktive kampagne?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Vil du virkelig slette denne aktive kampagne?";
$GLOBALS['strShowParentAdvertisers'] = "Vis oprindelig annoncør";
$GLOBALS['strHideParentAdvertisers'] = "Skjul oprindelig annoncør";
$GLOBALS['strHideInactiveCampaigns'] = "Skjul inaktive kampagner";
$GLOBALS['strInactiveCampaignsHidden'] = "Inaktive kampagne(r) er skjult";
$GLOBALS['strPriorityInformation'] = "Priority in relation to other campaigns";
$GLOBALS['strECPMInformation'] = "eCPM prioritization";
$GLOBALS['strRemnantEcpmDescription'] = "eCPM is automatically calculated based on this campaign's performance.<br />It will be used to prioritise Remnant campaigns relative to each other.";
$GLOBALS['strEcpmMinImpsDescription'] = "Set this to your desired minium basis on which to calculate this campaign's eCPM.";
$GLOBALS['strHiddenCampaign'] = "Kampagne";
$GLOBALS['strHiddenAd'] = "Annonce";
$GLOBALS['strHiddenAdvertiser'] = "Annoncør";
$GLOBALS['strHiddenTracker'] = "Tracker";
$GLOBALS['strHiddenWebsite'] = "Webside";
$GLOBALS['strHiddenZone'] = "Zone";
$GLOBALS['strCampaignDelivery'] = "Campaign delivery";
$GLOBALS['strCompanionPositioning'] = "Ledsagende positionering";
$GLOBALS['strSelectUnselectAll'] = "Vælg/fravælg alt";
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
$GLOBALS['strLow'] = "Lav";
$GLOBALS['strHigh'] = "Høj";
$GLOBALS['strExpirationDate'] = "Slut dato";
$GLOBALS['strExpirationDateComment'] = "Kampagnen vil udløbe ved afslutningen på denne dag";
$GLOBALS['strActivationDate'] = "Start dato";
$GLOBALS['strActivationDateComment'] = "Kampagnen vil begynde ved starten af denne dag";
$GLOBALS['strImpressionsRemaining'] = "Tilbageværende impressions";
$GLOBALS['strClicksRemaining'] = "Tilbageværende kliks";
$GLOBALS['strConversionsRemaining'] = "Tilbageværende Conversions";
$GLOBALS['strImpressionsBooked'] = "Reserverede visninger";
$GLOBALS['strClicksBooked'] = "Reserverede kliks";
$GLOBALS['strConversionsBooked'] = "Reserverede conversions";
$GLOBALS['strCampaignWeight'] = "Set the campaign weight";
$GLOBALS['strAnonymous'] = "Skjul annoncør og webside af denne kampagne";
$GLOBALS['strTargetPerDay'] = "per dag.";
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
$GLOBALS['strCampaignStatusPending'] = "Under behandling";
$GLOBALS['strCampaignStatusInactive'] = "Aktive";
$GLOBALS['strCampaignStatusRunning'] = "Kører";
$GLOBALS['strCampaignStatusPaused'] = "Pauset";
$GLOBALS['strCampaignStatusAwaiting'] = "Afventer";
$GLOBALS['strCampaignStatusExpired'] = "Gennemført";
$GLOBALS['strCampaignStatusApproval'] = "Afventer godkendelse »";
$GLOBALS['strCampaignStatusRejected'] = "Afvist";
$GLOBALS['strCampaignStatusAdded'] = "Added";
$GLOBALS['strCampaignStatusStarted'] = "Started";
$GLOBALS['strCampaignStatusRestarted'] = "Restarted";
$GLOBALS['strCampaignStatusDeleted'] = "Slet";
$GLOBALS['strCampaignType'] = "Kampagne navn";
$GLOBALS['strType'] = "Type";
$GLOBALS['strContract'] = "Kontakt";
$GLOBALS['strOverride'] = "Override";
$GLOBALS['strOverrideInfo'] = "Override campaigns are a special campaign type specifically to
    override (i.e. take priority over) Remnant and Contract campaigns. Override campaigns are generally used with
    specific targeting and/or capping rules to ensure that the campaign banners are always displayed in certain
    locations, to certain users, and perhaps a certain number of times, as part of a specific promotion. (This campaign
    type was previously known as 'Contract (Exclusive)'.)";
$GLOBALS['strStandardContract'] = "Kontakt";
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
$GLOBALS['strTrackers'] = "Tracker";
$GLOBALS['strTrackerPreferences'] = "Tracker Præferencer";
$GLOBALS['strAddTracker'] = "Tilføj ny tracker";
$GLOBALS['strTrackerForAdvertiser'] = "for advertiser";
$GLOBALS['strNoTrackers'] = "There are currently no trackers defined for this advertiser";
$GLOBALS['strConfirmDeleteTrackers'] = "Vil du virkelig slette denne tracker?";
$GLOBALS['strConfirmDeleteTracker'] = "Vil du virkelig slette denne tracker?";
$GLOBALS['strTrackerProperties'] = "Tracker egenskaber";
$GLOBALS['strDefaultStatus'] = "Normal status";
$GLOBALS['strStatus'] = "Status";
$GLOBALS['strLinkedTrackers'] = "Sammenhængende sporer";
$GLOBALS['strTrackerInformation'] = "Tracker Information";
$GLOBALS['strConversionWindow'] = "Conversions vindue";
$GLOBALS['strUniqueWindow'] = "Unik vindue";
$GLOBALS['strClick'] = "Klik";
$GLOBALS['strView'] = "Oversigt";
$GLOBALS['strArrival'] = "Arrival";
$GLOBALS['strManual'] = "Manual";
$GLOBALS['strImpression'] = "Impression";
$GLOBALS['strConversionType'] = "Conversion Type";
$GLOBALS['strLinkCampaignsByDefault'] = "Link de ny oprettede kampagner som udgangspunkt";
$GLOBALS['strBackToTrackers'] = "Back to trackers";
$GLOBALS['strIPAddress'] = "IP Address";

// Banners (General)
$GLOBALS['strBanner'] = "Banner";
$GLOBALS['strBanners'] = "Banner";
$GLOBALS['strAddBanner'] = "Tilføj ny banner";
$GLOBALS['strAddBanner_Key'] = "Tilføj <u>n</u>y banner";
$GLOBALS['strBannerToCampaign'] = "Din kampagne";
$GLOBALS['strShowBanner'] = "Vis banner";
$GLOBALS['strBannerProperties'] = "Banner egenskaber";
$GLOBALS['strBannerHistory'] = "Banner Statistics";
$GLOBALS['strNoBanners'] = "There are currently no banners defined for this campaign.";
$GLOBALS['strNoBannersAddCampaign'] = "Der er ikke valgt noget website. For at oprette en zone, skal du <a href='affiliate-edit.php'>tilføje et nyt website</a> først.";
$GLOBALS['strNoBannersAddAdvertiser'] = "Der er ikke valgt noget website. For at oprette en zone, skal du <a href='affiliate-edit.php'>tilføje et nyt website</a> først.";
$GLOBALS['strConfirmDeleteBanner'] = "Vil du virkelig slette denne banner?";
$GLOBALS['strConfirmDeleteBanners'] = "Vil du virkelig slette denne banner?";
$GLOBALS['strShowParentCampaigns'] = "Vis oprindelige kampagner";
$GLOBALS['strHideParentCampaigns'] = "Skjul oprindelige kampagner";
$GLOBALS['strHideInactiveBanners'] = "Skjul inaktive bannere";
$GLOBALS['strInactiveBannersHidden'] = "Inaktive banner(e) er skjult";
$GLOBALS['strWarningMissing'] = "Advarsel, der mangler muligvis_";
$GLOBALS['strWarningMissingClosing'] = " lukke mærke \">\"";
$GLOBALS['strWarningMissingOpening'] = " åbne mærke \"<\"";
$GLOBALS['strSubmitAnyway'] = "Fremsende alligevel";
$GLOBALS['strBannersOfCampaign'] = "i"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "Banner Præferencer";
$GLOBALS['strCampaignPreferences'] = "Campaign Preferences";
$GLOBALS['strDefaultBanners'] = "Standard banner";
$GLOBALS['strDefaultBannerUrl'] = "Default Image URL";
$GLOBALS['strDefaultBannerDestination'] = "Standard destination URL";
$GLOBALS['strAllowedBannerTypes'] = "Tilladte banner typer";
$GLOBALS['strTypeSqlAllow'] = "Tillad SQL lokale bannere";
$GLOBALS['strTypeWebAllow'] = "Tillad Webserver lokale bannere";
$GLOBALS['strTypeUrlAllow'] = "Tillad eksterne bannere";
$GLOBALS['strTypeHtmlAllow'] = "Tillad HTML bannere";
$GLOBALS['strTypeTxtAllow'] = "Tillad tekst reklamer";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Venligst vælg den type banner";
$GLOBALS['strMySQLBanner'] = "Upload a local banner to the database";
$GLOBALS['strWebBanner'] = "Upload a local banner to the webserver";
$GLOBALS['strURLBanner'] = "Link an external banner";
$GLOBALS['strHTMLBanner'] = "Create an HTML banner";
$GLOBALS['strTextBanner'] = "Create a Text banner";
$GLOBALS['strAlterHTML'] = "Alter HTML to enable click tracking for:";
$GLOBALS['strIframeFriendly'] = "This banner can be safely displayed inside an iframe (e.g. is not expandable)";
$GLOBALS['strUploadOrKeep'] = "Ønsker du at beholde din <br /> eksisterende billede, eller du <br /> ønsker måske at uploade en anden?";
$GLOBALS['strNewBannerFile'] = "Vælg det billede du ønsker <br /> at bruge til denne banner <br /><br />";
$GLOBALS['strNewBannerFileAlt'] = "Vægl en backup billede du <br /> ønsker at brugei tilfælde af at browseren <br /> ikke supportere rich media <br /><br />";
$GLOBALS['strNewBannerURL'] = "Billede URL (inkl. http://)";
$GLOBALS['strURL'] = "Destination URL (inkl. http://)";
$GLOBALS['strKeyword'] = "Nøgleord";
$GLOBALS['strTextBelow'] = "Tekst under billedet";
$GLOBALS['strWeight'] = "Vægt";
$GLOBALS['strAlt'] = "Alt text";
$GLOBALS['strStatusText'] = "Status tekst";
$GLOBALS['strCampaignsWeight'] = "Campaign's Weight";
$GLOBALS['strBannerWeight'] = "Banner vægt";
$GLOBALS['strBannersWeight'] = "Banner's Weight";
$GLOBALS['strAdserverTypeGeneric'] = "Generisk HTML Banner";
$GLOBALS['strDoNotAlterHtml'] = "Do not alter HTML";
$GLOBALS['strGenericOutputAdServer'] = "Generisk";
$GLOBALS['strBackToBanners'] = "Back to banners";
$GLOBALS['strUseWyswygHtmlEditor'] = "Use WYSIWYG HTML Editor";
$GLOBALS['strChangeDefault'] = "Change default";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "Always prepend the following HTML code to this banner";
$GLOBALS['strBannerAppendHTML'] = "Always append the following HTML code to this banner";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "Leverings optioner";
$GLOBALS['strACL'] = "Leverings optioner";
$GLOBALS['strACLAdd'] = "Add delivery rule";
$GLOBALS['strApplyLimitationsTo'] = "Apply delivery rules to";
$GLOBALS['strAllBannersInCampaign'] = "All banners in this campaign";
$GLOBALS['strRemoveAllLimitations'] = "Remove all delivery rules";
$GLOBALS['strEqualTo'] = "er lig med";
$GLOBALS['strDifferentFrom'] = "er forskellig fra";
$GLOBALS['strLaterThan'] = "is later than";
$GLOBALS['strLaterThanOrEqual'] = "is later than or equal to";
$GLOBALS['strEarlierThan'] = "is earlier than";
$GLOBALS['strEarlierThanOrEqual'] = "is earlier than or equal to";
$GLOBALS['strContains'] = "contains";
$GLOBALS['strNotContains'] = "doesn't contain";
$GLOBALS['strGreaterThan'] = "er større end";
$GLOBALS['strLessThan'] = "er mindre end";
$GLOBALS['strGreaterOrEqualTo'] = "is greater or equal to";
$GLOBALS['strLessOrEqualTo'] = "is less or equal to";
$GLOBALS['strAND'] = "OG";                          // logical operator
$GLOBALS['strOR'] = "ELLER";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Vis kun denne banner når:";
$GLOBALS['strWeekDays'] = "Ugedage";
$GLOBALS['strTime'] = "Time";
$GLOBALS['strDomain'] = "Domain";
$GLOBALS['strSource'] = "Kilde";
$GLOBALS['strBrowser'] = "Browser";
$GLOBALS['strOS'] = "OS";
$GLOBALS['strDeliveryLimitations'] = "Delivery Rules";

$GLOBALS['strDeliveryCappingReset'] = "Nulstil visnings tæller efter:";
$GLOBALS['strDeliveryCappingTotal'] = "total";
$GLOBALS['strDeliveryCappingSession'] = "per session";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingBanner']['limit'] = "Begræns kampagne visninger til:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingCampaign']['limit'] = "Begræns zone visninger til:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingZone']['limit'] = "Begræns zone visninger til:";

// Website
$GLOBALS['strAffiliate'] = "Webside";
$GLOBALS['strAffiliates'] = "Websider";
$GLOBALS['strAffiliatesAndZones'] = "Websider og zoner";
$GLOBALS['strAddNewAffiliate'] = "Tilføj nye websider";
$GLOBALS['strAffiliateProperties'] = "Webside egenskab";
$GLOBALS['strAffiliateHistory'] = "Website Statistics";
$GLOBALS['strNoAffiliates'] = "Der er ikke valgt noget website. For at oprette en zone, skal du <a href='affiliate-edit.php'>tilføje et nyt website</a> først.";
$GLOBALS['strConfirmDeleteAffiliate'] = "Vil du virkelig slette denne webside?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Vil du virkelig slette denne webside?";
$GLOBALS['strInactiveAffiliatesHidden'] = "Inaktiv webside(r) som er skjult";
$GLOBALS['strShowParentAffiliates'] = "Vis oprindelig websider";
$GLOBALS['strHideParentAffiliates'] = "Skjul oprindelig websider";

// Website (properties)
$GLOBALS['strWebsite'] = "Webside";
$GLOBALS['strWebsiteURL'] = "Website URL";
$GLOBALS['strAllowAffiliateModifyZones'] = "Tillad denne bruger at modificere egne zoner";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Tillad denne bruger at linke banner til egne zoner";
$GLOBALS['strAllowAffiliateAddZone'] = "Tillad denne burger at definere nye zoner";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Tillad denne bruger at slette eksisterende zoner";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Tillad denne bruger at genere invocation kode";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "Post nummer";
$GLOBALS['strCountry'] = "Land";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Websider og zoner";

// Zone
$GLOBALS['strZone'] = "Zone";
$GLOBALS['strZones'] = "Zoner";
$GLOBALS['strAddNewZone'] = "Tilføj nye zoner";
$GLOBALS['strAddNewZone_Key'] = "Tilføj <u>n</u>y zone";
$GLOBALS['strZoneToWebsite'] = "Alle websider";
$GLOBALS['strLinkedZones'] = "Sammenhængende zoner";
$GLOBALS['strAvailableZones'] = "Available Zones";
$GLOBALS['strLinkingNotSuccess'] = "Linking not successful, please try again";
$GLOBALS['strZoneProperties'] = "Zone egenskaber";
$GLOBALS['strZoneHistory'] = "Zone historik";
$GLOBALS['strNoZones'] = "There are currently no zones defined for this website.";
$GLOBALS['strNoZonesAddWebsite'] = "Der er ikke valgt noget website. For at oprette en zone, skal du <a href='affiliate-edit.php'>tilføje et nyt website</a> først.";
$GLOBALS['strConfirmDeleteZone'] = "Vil du virkelig slette denne zone?";
$GLOBALS['strConfirmDeleteZones'] = "Vil du virkelig slette denne zone?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "There are campaigns still linked to this zone, if you delete it these will not be able to run and you will not be paid for them.";
$GLOBALS['strZoneType'] = "Zone type";
$GLOBALS['strBannerButtonRectangle'] = "Banner, Button eller Retangulær";
$GLOBALS['strInterstitial'] = "Mellemliggende eller flydende DHTML";
$GLOBALS['strPopup'] = "Pop op";
$GLOBALS['strTextAdZone'] = "Tekst reklame";
$GLOBALS['strEmailAdZone'] = "Email/Nyhedsbrev zone";
$GLOBALS['strZoneVideoInstream'] = "Inline Video ad";
$GLOBALS['strZoneVideoOverlay'] = "Overlay Video ad";
$GLOBALS['strShowMatchingBanners'] = "Vis matchende bannere";
$GLOBALS['strHideMatchingBanners'] = "Skjul matchende bannere";
$GLOBALS['strBannerLinkedAds'] = "Bannere tilknyttet til zonen";
$GLOBALS['strCampaignLinkedAds'] = "Kampagner tilknyttet til zonen";
$GLOBALS['strInactiveZonesHidden'] = "inaktive zone(r) er skjult";
$GLOBALS['strWarnChangeZoneType'] = "Ved at skifte zone type til tekst eller email vil fjerne all links til bannere/kampagner på grund af restriktioner på disse zoner
<ul>
<li>Tekst zoner kan kun linkes til tekst reklamer</li>
<li>Email zoner kan kun have en aktic banner på samme tid</li>
</ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Skifte zone størrelse vil fjerne link til all bannnere som ikke er i den nye størrelse, og vil tilføje enhver banner fra tilsvarend kampagner som har den nye størrelse';
$GLOBALS['strWarnChangeBannerSize'] = 'Changing the banner size will unlink this banner from any zones that are not the new size, and if this banner\'s <strong>campaign</strong> is linked to a zone of the new size, this banner will be automatically linked';
$GLOBALS['strWarnBannerReadonly'] = 'This banner is read-only because an extension has been disabled. Contact your system administrator for more information.';
$GLOBALS['strZonesOfWebsite'] = 'i'; //this is added between page name and website name eg. 'Zones in www.example.com'
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
$GLOBALS['strAdvanced'] = "Avanceret";
$GLOBALS['strChainSettings'] = "Kæde opsætning";
$GLOBALS['strZoneNoDelivery'] = "Hvis ingen bannere fra denne zone <br /> kan blive leveret, prøv at...";
$GLOBALS['strZoneStopDelivery'] = "Stop levering og vis ikke nogen banner";
$GLOBALS['strZoneOtherZone'] = "Vis den valgte zone i stedet";
$GLOBALS['strZoneAppend'] = "Tilføj altid den følgende HTML kode til bannere som er vist i denne zone";
$GLOBALS['strAppendSettings'] = "Tilføj og forbered opsætninger";
$GLOBALS['strZonePrependHTML'] = "Forbered altid HTML koden til tekst reklamer som er vist i denne zone";
$GLOBALS['strZoneAppendNoBanner'] = "Vedhæft selv om der ikke er leveret bannere";
$GLOBALS['strZoneAppendHTMLCode'] = "HTML kode";
$GLOBALS['strZoneAppendZoneSelection'] = "Pop up eller interstitial";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "Alle bannere som er linket sammen to den valgte zone er i øjeblikket ikke aktive. <br />Dette er zone kæden som vil blive anvendt:";
$GLOBALS['strZoneProbNullPri'] = "Der er ikke nogle aktive bannere tilknyttet denne zone.";
$GLOBALS['strZoneProbListChainLoop'] = "Resultatet ved at anvende zone kæden er en loop. Levering for denne zone er standset.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Venligst vælg hvad som ønskes tilknyttet til denne zone";
$GLOBALS['strLinkedBanners'] = "Tilknyt individuelle bannere";
$GLOBALS['strCampaignDefaults'] = "Tilknyt banner til oprindelig kampagne";
$GLOBALS['strLinkedCategories'] = "Tilknyt bannere ved kategori";
$GLOBALS['strWithXBanners'] = "%d banner(s)";
$GLOBALS['strRawQueryString'] = "Nøgleord";
$GLOBALS['strIncludedBanners'] = "Tilknyttede bannere";
$GLOBALS['strMatchingBanners'] = "{count} matchende bannere";
$GLOBALS['strNoCampaignsToLink'] = "Der er for øjeblikket ikke nogle kampagner tilgængelige, der kan blive linkes til denne zone";
$GLOBALS['strNoTrackersToLink'] = "Der er for øjeblikke ikke nogle tracker tilgængelige, der kan linkes til denne kampagne";
$GLOBALS['strNoZonesToLinkToCampaign'] = "Der er ikke nogle zoner tilgængelige som denne kampagne kan blive sammenkædet med";
$GLOBALS['strSelectBannerToLink'] = "Vælg den banner som du vil linke til denne zone:";
$GLOBALS['strSelectCampaignToLink'] = "Vælg den kampagne som du vil linke til denne zone:";
$GLOBALS['strSelectAdvertiser'] = "Vælg annoncør";
$GLOBALS['strSelectPlacement'] = "Vælg kampagne";
$GLOBALS['strSelectAd'] = "Vælg banner";
$GLOBALS['strSelectPublisher'] = "Vælg Website";
$GLOBALS['strSelectZone'] = "Vælg Zone";
$GLOBALS['strStatusPending'] = "Under behandling";
$GLOBALS['strStatusApproved'] = "Approved";
$GLOBALS['strStatusDisapproved'] = "Disapproved";
$GLOBALS['strStatusDuplicate'] = "Kopier";
$GLOBALS['strStatusOnHold'] = "On Hold";
$GLOBALS['strStatusIgnore'] = "Ignore";
$GLOBALS['strConnectionType'] = "Type";
$GLOBALS['strConnTypeSale'] = "Sale";
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Signup";
$GLOBALS['strShortcutEditStatuses'] = "Editere status";
$GLOBALS['strShortcutShowStatuses'] = "Vis status";

// Statistics
$GLOBALS['strStats'] = "Statistikker";
$GLOBALS['strNoStats'] = "Der er for øjeblikket ingen statistik tilgængelig";
$GLOBALS['strNoStatsForPeriod'] = "Der er for øjeblikket ingen statistik tilgængelig for perioden %s til %s";
$GLOBALS['strGlobalHistory'] = "Global Statistics";
$GLOBALS['strDailyHistory'] = "Daily Statistics";
$GLOBALS['strDailyStats'] = "Daily Statistics";
$GLOBALS['strWeeklyHistory'] = "Weekly Statistics";
$GLOBALS['strMonthlyHistory'] = "Monthly Statistics";
$GLOBALS['strTotalThisPeriod'] = "Total for denne periode";
$GLOBALS['strPublisherDistribution'] = "Webside distribution";
$GLOBALS['strCampaignDistribution'] = "Kampagne distribution";
$GLOBALS['strViewBreakdown'] = "Vis efter";
$GLOBALS['strBreakdownByDay'] = "Dag";
$GLOBALS['strBreakdownByWeek'] = "Uge";
$GLOBALS['strBreakdownByMonth'] = "Måned";
$GLOBALS['strBreakdownByDow'] = "Ugedag";
$GLOBALS['strBreakdownByHour'] = "Time";
$GLOBALS['strItemsPerPage'] = "Antal pr. side";
$GLOBALS['strDistributionHistoryCampaign'] = "Distribution Statistics (Campaign)";
$GLOBALS['strDistributionHistoryBanner'] = "Distribution Statistics (Banner)";
$GLOBALS['strDistributionHistoryWebsite'] = "Distribution Statistics (Website)";
$GLOBALS['strDistributionHistoryZone'] = "Distribution Statistics (Zone)";
$GLOBALS['strShowGraphOfStatistics'] = "Vis <u>g</u>raf af statistik";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>ksport statistik til Excel";
$GLOBALS['strGDnotEnabled'] = "Du skal have GD aktiveret i PHP for at vise grafer. <br />Venligst se<a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> for yderligere information, inklusiv hvordan du installerer GD på din server.";
$GLOBALS['strStatsArea'] = "Area";

// Expiration
$GLOBALS['strNoExpiration'] = "Der er ikke defineret en udløbsdato";
$GLOBALS['strEstimated'] = "Estimeret udløbs dato";
$GLOBALS['strNoExpirationEstimation'] = "No expiration estimated yet";
$GLOBALS['strDaysAgo'] = "days ago";
$GLOBALS['strCampaignStop'] = "Kampagne historik";

// Reports
$GLOBALS['strAdvancedReports'] = "Advanced Reports";
$GLOBALS['strStartDate'] = "Start Date";
$GLOBALS['strEndDate'] = "End Date";
$GLOBALS['strPeriod'] = "Period";
$GLOBALS['strLimitations'] = "Delivery Rules";
$GLOBALS['strWorksheets'] = "Worksheets";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "All annoncører";
$GLOBALS['strAnonAdvertisers'] = "Annonyme annoncører";
$GLOBALS['strAllPublishers'] = "Alle websider";
$GLOBALS['strAnonPublishers'] = "Annonyme websider";
$GLOBALS['strAllAvailZones'] = "Alle tilgængelige zoner";

// Userlog
$GLOBALS['strUserLog'] = "Bruger log";
$GLOBALS['strUserLogDetails'] = "Bruger log detaljer";
$GLOBALS['strDeleteLog'] = "Slet log";
$GLOBALS['strAction'] = "Aktion";
$GLOBALS['strNoActionsLogged'] = "Der er ikke logget nogle hændelser";

// Code generation
$GLOBALS['strGenerateBannercode'] = "Direkte udvælgelse";
$GLOBALS['strChooseInvocationType'] = "Venligst vælg den type af banner invocation";
$GLOBALS['strGenerate'] = "Generere";
$GLOBALS['strParameters'] = "Tag opsætning";
$GLOBALS['strFrameSize'] = "Ramme størrelse";
$GLOBALS['strBannercode'] = "Banner kode";
$GLOBALS['strTrackercode'] = "Trackercode";
$GLOBALS['strBackToTheList'] = "Gå tilbage til rapport listen";
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
$GLOBALS['strNoMatchesFound'] = "Der er ikke fundet nogle matchende resultater";
$GLOBALS['strErrorOccurred'] = "Der opstod en fejl";
$GLOBALS['strErrorDBPlain'] = "Der opstod en fejl under adgangsforsøget til databasen.";
$GLOBALS['strErrorDBSerious'] = "Der er detekteret et avorligt problem med databasen.";
$GLOBALS['strErrorDBNoDataPlain'] = "Due to a problem with the database {$PRODUCT_NAME} couldn't retrieve or store data. ";
$GLOBALS['strErrorDBNoDataSerious'] = "Due to a serious problem with the database, {$PRODUCT_NAME} couldn't retrieve data";
$GLOBALS['strErrorDBCorrupt'] = "Database tabellen er sandsynligvis fejlbehæftet og behøver at blive repareret. For yderligere information om at reparere fejlbehæftede tabeller, venligst læs kapitlet <i>Troubleshooting</i> i <i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact'] = "Venligst kontakt administratoren af denne server og meddel ham eller hende om dette problem.";
$GLOBALS['strErrorDBSubmitBug'] = "If this problem is reproducable it might be caused by a bug in {$PRODUCT_NAME}. Please report the following information to the creators of {$PRODUCT_NAME}. Also try to describe the actions that led to this error as clearly as possible.";
$GLOBALS['strMaintenanceNotActive'] = "The maintenance script has not been run in the last 24 hours.
In order for the application to function correctly it needs to run
every hour.

Please read the Administrator guide for more information
about configuring the maintenance script.";
$GLOBALS['strErrorLinkingBanner'] = "Det var ikke muligt at linke banner til denne zone fordi:";
$GLOBALS['strUnableToLinkBanner'] = "Kan ikke linke denne banner:_";
$GLOBALS['strErrorEditingCampaignRevenue'] = "incorrect number format in Revenue Information field";
$GLOBALS['strErrorEditingCampaignECPM'] = "incorrect number format in ECPM Information field";
$GLOBALS['strErrorEditingZone'] = "Error updating zone:";
$GLOBALS['strUnableToChangeZone'] = "Kan ikke tilføje denne ændring på grund af:";
$GLOBALS['strDatesConflict'] = "datoer konflikter med:";
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
$GLOBALS['strSirMadam'] = "Hr/Fru";
$GLOBALS['strMailSubject'] = "Annoncør rapport";
$GLOBALS['strMailHeader'] = "Dear {contact},";
$GLOBALS['strMailBannerStats'] = "Nedenfor vil få finde banner statistik for {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Kampagne aktiveret";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Kampagne deaktiveret";
$GLOBALS['strMailBannerActivated'] = "Your campaign shown below has been activated because
the campaign activation date has been reached.";
$GLOBALS['strMailBannerDeactivated'] = "Din kampagne som er vist nedenfor er deaktiveret fordi";
$GLOBALS['strMailFooter'] = "Regards,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "Kampagnen er for øjeblikket ikke aktiv fordi";
$GLOBALS['strBeforeActivate'] = "aktiverings datoen er endu ikke opnået";
$GLOBALS['strAfterExpire'] = "udløbsdatoen er opnået";
$GLOBALS['strNoMoreImpressions'] = "der er ikke nogle Impressions tilbage";
$GLOBALS['strNoMoreClicks'] = "der er ikke nogle klik's tilbage";
$GLOBALS['strNoMoreConversions'] = "der er ikke noglet salg tilbage";
$GLOBALS['strWeightIsNull'] = "vægten er sat til nul";
$GLOBALS['strRevenueIsNull'] = "its revenue is set to zero";
$GLOBALS['strTargetIsNull'] = "its limit per day is set to zero - you need to either specify both an end date and a limit or set Limit per day value";
$GLOBALS['strNoViewLoggedInInterval'] = "Der blev ikke logget nogle Impressions i tidsrummet under denne rapport";
$GLOBALS['strNoClickLoggedInInterval'] = "Der blev ikke logget nogle Kliks i tidsrummet under denne rapport";
$GLOBALS['strNoConversionLoggedInInterval'] = "Der blev ikke logget nogle Conversions i tidsrummet under denne rapport";
$GLOBALS['strMailReportPeriod'] = "Denne rapport inkludere statistik fra {startdate} til {enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "Denne rapport indeholder alt statistik op til {enddate}";
$GLOBALS['strNoStatsForCampaign'] = "Der er ikke statistik tilgængelig for denne kampagne";
$GLOBALS['strImpendingCampaignExpiry'] = "Forestående kampagne udløber";
$GLOBALS['strYourCampaign'] = "Din kampagne";
$GLOBALS['strTheCampiaignBelongingTo'] = "Kampagnen som hører til";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} vist nedenfor er sat til at slutte på {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} vist nedenfor har mindre end {limit} impressions tilbage.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "As a result, the campaign will soon be automatically disabled, and the
following banners in the campaign will also be disabled:";

// Priority
$GLOBALS['strPriority'] = "Prioritet";
$GLOBALS['strSourceEdit'] = "Rediger kilde";

// Preferences
$GLOBALS['strPreferences'] = "Præferencer";
$GLOBALS['strUserPreferences'] = "Bruger Indstillinger";
$GLOBALS['strChangePassword'] = "Skift Password";
$GLOBALS['strChangeEmail'] = "Skift Email";
$GLOBALS['strCurrentPassword'] = "Nuværende password";
$GLOBALS['strChooseNewPassword'] = "Vælg et nyt password";
$GLOBALS['strReenterNewPassword'] = "Gentag det nye password";
$GLOBALS['strNameLanguage'] = "Navn & sprog";
$GLOBALS['strAccountPreferences'] = "Konto Indstillinger";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Kampagne email Rapport Indstillinger";
$GLOBALS['strTimezonePreferences'] = "Timezone Preferences";
$GLOBALS['strAdminEmailWarnings'] = "Administrator email Advarsler";
$GLOBALS['strAgencyEmailWarnings'] = "Bureau email Advarsler";
$GLOBALS['strAdveEmailWarnings'] = "Annoncør email Advarsler";
$GLOBALS['strFullName'] = "Fulde Navn";
$GLOBALS['strEmailAddress'] = "Email adresse";
$GLOBALS['strUserDetails'] = "Bruger Information";
$GLOBALS['strUserInterfacePreferences'] = "Bruger Grænseflade Indstillinger";
$GLOBALS['strPluginPreferences'] = "Generelle Indstillinger";
$GLOBALS['strColumnName'] = "Column Name";
$GLOBALS['strShowColumn'] = "Show Column";
$GLOBALS['strCustomColumnName'] = "Custom Column Name";
$GLOBALS['strColumnRank'] = "Column Rank";

// Long names
$GLOBALS['strRevenue'] = "Revenue";
$GLOBALS['strNumberOfItems'] = "Antal poster";
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
$GLOBALS['strImpressionSR'] = "Visninger";
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
$GLOBALS['strClicks_short'] = "Klik";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "Conv.";
$GLOBALS['strPendingConversions_short'] = "Pend conv.";
$GLOBALS['strImpressionSR_short'] = "Impr. SR";
$GLOBALS['strClickSR_short'] = "Click SR";

// Global Settings
$GLOBALS['strConfiguration'] = "Configuration";
$GLOBALS['strGlobalSettings'] = "Overordnede Indstillinger";
$GLOBALS['strGeneralSettings'] = "Generel opsætninger";
$GLOBALS['strMainSettings'] = "Hoved opsætninger";
$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strChooseSection'] = 'Vælg sektion';

// Product Updates
$GLOBALS['strProductUpdates'] = "Produkt opdateringer";
$GLOBALS['strViewPastUpdates'] = "Håndtere tidligere opdateringer og back-up's";
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
$GLOBALS['strAgencyManagement'] = "Konto Administration";
$GLOBALS['strAgency'] = "Konto";
$GLOBALS['strAddAgency'] = "Tilføj ny konto";
$GLOBALS['strAddAgency_Key'] = "Tilføj <u>n</u>y zone";
$GLOBALS['strTotalAgencies'] = "Total antal kontoer";
$GLOBALS['strAgencyProperties'] = "Account Properties";
$GLOBALS['strNoAgencies'] = "Der er i øjeblikket ikke defineret nogle zoner";
$GLOBALS['strConfirmDeleteAgency'] = "Vil du virkelig slette denne zone?";
$GLOBALS['strHideInactiveAgencies'] = "Hide inactive accounts";
$GLOBALS['strInactiveAgenciesHidden'] = "inaktive zone(r) er skjult";
$GLOBALS['strSwitchAccount'] = "Switch to this account";
$GLOBALS['strAgencyStatusRunning'] = "Active";
$GLOBALS['strAgencyStatusInactive'] = "Aktive";
$GLOBALS['strAgencyStatusPaused'] = "Suspended";

// Channels
$GLOBALS['strChannel'] = "Delivery Rule Set";
$GLOBALS['strChannels'] = "Delivery Rule Sets";
$GLOBALS['strChannelManagement'] = "Delivery Rule Set Management";
$GLOBALS['strAddNewChannel'] = "Add new Delivery Rule Set";
$GLOBALS['strAddNewChannel_Key'] = "Add <u>n</u>ew Delivery Rule Set";
$GLOBALS['strChannelToWebsite'] = "Alle websider";
$GLOBALS['strNoChannels'] = "There are currently no delivery rule sets defined";
$GLOBALS['strNoChannelsAddWebsite'] = "There are currently no delivery rule sets defined, because there are no websites. To create a delivery rule set, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strEditChannelLimitations'] = "Edit delivery rules for the delivery rule set";
$GLOBALS['strChannelProperties'] = "Delivery Rule Set Properties";
$GLOBALS['strChannelLimitations'] = "Leverings optioner";
$GLOBALS['strConfirmDeleteChannel'] = "Do you really want to delete this delivery rule set?";
$GLOBALS['strConfirmDeleteChannels'] = "Do you really want to delete the selected delivery rule sets?";
$GLOBALS['strChannelsOfWebsite'] = 'i'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "Variable Navn";
$GLOBALS['strVariableDescription'] = "Beskrivelse";
$GLOBALS['strVariableDataType'] = "Data Type";
$GLOBALS['strVariablePurpose'] = "Formål";
$GLOBALS['strGeneric'] = "Generisk";
$GLOBALS['strBasketValue'] = "Værdi af kurv";
$GLOBALS['strNumItems'] = "Antal poster";
$GLOBALS['strVariableIsUnique'] = "Dedup conversions?";
$GLOBALS['strNumber'] = "Nummer";
$GLOBALS['strString'] = "Streng";
$GLOBALS['strTrackFollowingVars'] = "Spor de følgende variabler";
$GLOBALS['strAddVariable'] = "Tilføj variabel";
$GLOBALS['strNoVarsToTrack'] = "Der er ingen variabler at spore.";
$GLOBALS['strVariableRejectEmpty'] = "Afvise hvis tom?";
$GLOBALS['strTrackingSettings'] = "Sporer opsætninger";
$GLOBALS['strTrackerType'] = "Sporer type";
$GLOBALS['strTrackerTypeJS'] = "Spor JavaScript variabler";
$GLOBALS['strTrackerTypeDefault'] = "Spor JavaScript variabler (bagud kompertibel, escape er nødvendig)";
$GLOBALS['strTrackerTypeDOM'] = "Spor HTML elementer ved brug af DOM";
$GLOBALS['strTrackerTypeCustom'] = "Tilpasset JS kode";
$GLOBALS['strVariableCode'] = "Javascript sporer kode";

// Password recovery
$GLOBALS['strForgotPassword'] = "Glemt dit password?";
$GLOBALS['strPasswordRecovery'] = "Password reset";
$GLOBALS['strEmailRequired'] = "Email er et krævet felt";
$GLOBALS['strPwdRecWrongId'] = "Forkert ID";
$GLOBALS['strPwdRecEnterEmail'] = "Skriv din email adresse nedefor";
$GLOBALS['strPwdRecEnterPassword'] = "Skriv dit nye password nedenfor";
$GLOBALS['strProceed'] = "Fortsæt >";
$GLOBALS['strNotifyPageMessage'] = "An e-mail has been sent to you, which includes a link that will allow you
                                         to reset your password and log in.<br />Please allow a few minutes for the e-mail to arrive.<br />
                                         If you do not receive the e-mail, please check your spam folder.<br />
                                         <a href=\"index.php\">Return to the main login page.</a>";

$GLOBALS['strPwdRecEmailPwdRecovery'] = "Reset Your %s Password";
$GLOBALS['strPwdRecEmailBody'] = "Dear {name},

You, or someone pretending to be you, recently requested that your {$PRODUCT_NAME} password be reset.

If this request was made by you, then you can reset the password for your username '{username}' by
clicking on the following link:

{reset_link}

If you submitted the password reset request by mistake, or if you didn't make a request at all, simply
ignore this email. No changes have been made to your password and the password reset link will expire
automatically.

If you continue to receive these password reset mails, then it may indicate that someone is attempting
to gain access to your username. In that case, please contact the support team or system administrator
for your {$PRODUCT_NAME} system, and notify them of the situation.

{admin_signature}";
$GLOBALS['strPwdRecEmailSincerely'] = "Sincerely,";

// Audit
$GLOBALS['strAdditionalItems'] = "and additional items";
$GLOBALS['strFor'] = "for";
$GLOBALS['strHas'] = "has";
$GLOBALS['strBinaryData'] = "Binær date";
$GLOBALS['strAuditTrailDisabled'] = "Audit Trail has been disabled by the system administrator. No further events are logged and shown in Audit Trail list.";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "No user activity has been recorded during the timeframe you have selected.";
$GLOBALS['strAuditTrail'] = "Handlings Log";
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
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>Der er ikke nogle kampagne aktiviteret at vise. </li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "No campaigns have started or finished during the timeframe you have selected";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>In order to view campaigns which have started or finished during the timeframe you have selected, the Audit Trail must be activated</li>
        <li>You are seeing this message because you didn't activate the Audit Trail</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Activate Audit Trail to start viewing Campaigns";

$GLOBALS['strUnsavedChanges'] = "You have unsaved changes on this page, make sure you press &quot;Save Changes&quot; when finished";
$GLOBALS['strDeliveryLimitationsDisagree'] = "WARNING: The cached delivery rules <strong>DO NOT AGREE</strong> with the delivery rules shown below<br />Please hit save changes to update the cached delivery rules";
$GLOBALS['strDeliveryRulesDbError'] = "WARNING: When saving the delivery rules, a database error occured. Please check the delivery rules below carefully, and update, if required.";
$GLOBALS['strDeliveryRulesTruncation'] = "WARNING: When saving the delivery rules, MySQL truncated the data, so the original values were restored. Please reduce your rule size, and try again.";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Some delivery rules report incorrect values:";

//confirmation messages
$GLOBALS['strYouAreNowWorkingAsX'] = "Du arbejder nu som <b>%s</b>";
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
