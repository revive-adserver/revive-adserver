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

$GLOBALS['phpAds_DecimalPoint'] = ",";
$GLOBALS['phpAds_ThousandsSeperator'] = ".";

// Date & time configuration
$GLOBALS['date_format'] = "%Y-%m-%d";
$GLOBALS['time_format'] = "%H:%M:%S";
$GLOBALS['minute_format'] = "%H:%M";
$GLOBALS['month_format'] = "%Y-%m";
$GLOBALS['day_format'] = "%m-%d";
$GLOBALS['week_format'] = "%Y-%W";
$GLOBALS['weekiso_format'] = "%V-%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate
$GLOBALS['excel_integer_formatting'] = "#,##0;-#,##0;-";
$GLOBALS['excel_decimal_formatting'] = "#,##0.000;-#,##0.000;-";

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "Főoldal";
$GLOBALS['strHelp'] = "Segítség";
$GLOBALS['strStartOver'] = "Újrakezdés";
$GLOBALS['strShortcuts'] = "Gyorsgombok";
$GLOBALS['strActions'] = "Műveletek";
$GLOBALS['strAndXMore'] = "és %s további";
$GLOBALS['strAdminstration'] = "Leltár";
$GLOBALS['strMaintenance'] = "Karbantartás";
$GLOBALS['strProbability'] = "Valószínűség";
$GLOBALS['strInvocationcode'] = "Beillesztő programkód";
$GLOBALS['strBasicInformation'] = "Alapinformáció";
$GLOBALS['strAppendTrackerCode'] = "Követőkód hozzáadása";
$GLOBALS['strOverview'] = "�?ttekintés";
$GLOBALS['strSearch'] = "Kere<u>s</u>és";
$GLOBALS['strDetails'] = "Részletek";
$GLOBALS['strUpdateSettings'] = "Beállítások Mentése";
$GLOBALS['strCheckForUpdates'] = "Elérhető frissítések keresése";
$GLOBALS['strWhenCheckingForUpdates'] = "When checking for updates";
$GLOBALS['strCompact'] = "Tömör";
$GLOBALS['strUser'] = "Felhasználó";
$GLOBALS['strDuplicate'] = "Duplikál";
$GLOBALS['strCopyOf'] = "Copy of";
$GLOBALS['strMoveTo'] = "Mozgat";
$GLOBALS['strDelete'] = "Törlés";
$GLOBALS['strActivate'] = "Aktivál";
$GLOBALS['strConvert'] = "Konvertál";
$GLOBALS['strRefresh'] = "Frissít";
$GLOBALS['strSaveChanges'] = "Változtatások mentése";
$GLOBALS['strUp'] = "Fel";
$GLOBALS['strDown'] = "Le";
$GLOBALS['strSave'] = "Mentés";
$GLOBALS['strCancel'] = "Mégsem";
$GLOBALS['strBack'] = "Vissza";
$GLOBALS['strPrevious'] = "Előző";
$GLOBALS['strNext'] = "Következő";
$GLOBALS['strYes'] = "Igen";
$GLOBALS['strNo'] = "Nem";
$GLOBALS['strNone'] = "Nincs";
$GLOBALS['strCustom'] = "Egyedi";
$GLOBALS['strDefault'] = "Alapértelmezett";
$GLOBALS['strUnknown'] = "Ismeretlen";
$GLOBALS['strUnlimited'] = "Korlátlan";
$GLOBALS['strUntitled'] = "Címtelen";
$GLOBALS['strAll'] = "mind";
$GLOBALS['strAverage'] = "�?tlag";
$GLOBALS['strOverall'] = "Teljes";
$GLOBALS['strTotal'] = "Összesen";
$GLOBALS['strFrom'] = "Mettől";
$GLOBALS['strTo'] = "meddig";
$GLOBALS['strAdd'] = "Hozzáad";
$GLOBALS['strLinkedTo'] = "csatolva";
$GLOBALS['strDaysLeft'] = "Hátralévő napok";
$GLOBALS['strCheckAllNone'] = "Összes kijelölve/üres";
$GLOBALS['strKiloByte'] = "KB";
$GLOBALS['strExpandAll'] = "Össz<u>e</u>s kibontása";
$GLOBALS['strCollapseAll'] = "Összes be<u>c</u>sukása";
$GLOBALS['strShowAll'] = "Összes megjelenítése";
$GLOBALS['strNoAdminInterface'] = "Az adminisztrációs felület jelenleg karbantartás miatt nem elérhető. A kampányok kiszolgálását ez nem akadályozza.";
$GLOBALS['strFieldStartDateBeforeEnd'] = "'Kezdő' dátumnak kisebbnek kell lennie mint a 'Záró' dátumnak";
$GLOBALS['strFieldContainsErrors'] = "A következő mezők hibá(ka)t tartalmaznak:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Folytatás előtt szükséges";
$GLOBALS['strFieldFixBeforeContinue2'] = "javítani kell ezeket a hibákat.";
$GLOBALS['strMiscellaneous'] = "Vegyes";
$GLOBALS['strCollectedAllStats'] = "Minden statisztika";
$GLOBALS['strCollectedToday'] = "Ma";
$GLOBALS['strCollectedYesterday'] = "Tegnap";
$GLOBALS['strCollectedThisWeek'] = "Ezen a héten";
$GLOBALS['strCollectedLastWeek'] = "Előző héten";
$GLOBALS['strCollectedThisMonth'] = "Ebben a hónapban";
$GLOBALS['strCollectedLastMonth'] = "Előző hónap";
$GLOBALS['strCollectedLast7Days'] = "Előző 7 nap";
$GLOBALS['strCollectedSpecificDates'] = "Egyedi dátumok";
$GLOBALS['strValue'] = "Érték";
$GLOBALS['strWarning'] = "Figyelmeztetés";
$GLOBALS['strNotice'] = "Értesítés";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "The dashboard can not be displayed";
$GLOBALS['strNoCheckForUpdates'] = "The dashboard cannot be displayed unless the<br />check for updates setting is enabled.";
$GLOBALS['strEnableCheckForUpdates'] = "Please enable the <a href='account-settings-update.php' target='_top'>check for updates</a> setting on the<br/><a href='account-settings-update.php' target='_top'>update settings</a> page.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "kód";
$GLOBALS['strDashboardSystemMessage'] = "Rendszerüzenet";
$GLOBALS['strDashboardErrorHelp'] = "If this error repeats please describe your problem in detail and post it on <a href='http://forum.revive-adserver.com/'>forum.revive-adserver.com/</a>.";

// Priority
$GLOBALS['strPriority'] = "Prioritás";
$GLOBALS['strPriorityLevel'] = "Prioritási szint";
$GLOBALS['strOverrideAds'] = "Override Campaign Advertisements";
$GLOBALS['strHighAds'] = "Contract Campaign Advertisements";
$GLOBALS['strECPMAds'] = "eCPM Campaign Advertisements";
$GLOBALS['strLowAds'] = "Remnant Campaign Advertisements";
$GLOBALS['strLimitations'] = "Delivery rules";
$GLOBALS['strNoLimitations'] = "No delivery rules";
$GLOBALS['strCapping'] = "Felső határérték";

// Properties
$GLOBALS['strName'] = "Név";
$GLOBALS['strSize'] = "Méret";
$GLOBALS['strWidth'] = "Szélesség";
$GLOBALS['strHeight'] = "Magasság";
$GLOBALS['strTarget'] = "Cél";
$GLOBALS['strLanguage'] = "Nyelv";
$GLOBALS['strDescription'] = "Leírás";
$GLOBALS['strVariables'] = "Változók";
$GLOBALS['strID'] = "Azonosító";
$GLOBALS['strComments'] = "Megjegyzések";

// User access
$GLOBALS['strWorkingAs'] = "Munkavégzés mint";
$GLOBALS['strWorkingAs_Key'] = "<u>W</u>orking as";
$GLOBALS['strWorkingAs'] = "Munkavégzés mint";
$GLOBALS['strSwitchTo'] = "Átváltás";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "Use the switcher's search box to find more accounts";
$GLOBALS['strWorkingFor'] = "%s for...";
$GLOBALS['strNoAccountWithXInNameFound'] = "No accounts with \"%s\" in name found";
$GLOBALS['strRecentlyUsed'] = "Recently used";
$GLOBALS['strLinkUser'] = "Felhasználó hozzáadása";
$GLOBALS['strLinkUser_Key'] = "Felhasználó <u>h</u>ozzáadása";
$GLOBALS['strUsernameToLink'] = "Add meg a felhasználói nevet";
$GLOBALS['strNewUserWillBeCreated'] = "Új felhasználó lesz létrehozva";
$GLOBALS['strToLinkProvideEmail'] = "To add user, provide user's email";
$GLOBALS['strToLinkProvideUsername'] = "To add user, provide username";
$GLOBALS['strUserLinkedToAccount'] = "User has been added to account";
$GLOBALS['strUserAccountUpdated'] = "User account updated";
$GLOBALS['strUserUnlinkedFromAccount'] = "User has been removed from account";
$GLOBALS['strUserWasDeleted'] = "User has been deleted";
$GLOBALS['strUserNotLinkedWithAccount'] = "Such user is not linked with account";
$GLOBALS['strCantDeleteOneAdminUser'] = "You can't delete a user. At least one user needs to be linked with admin account.";
$GLOBALS['strLinkUserHelp'] = "To add an <b>existing user</b>, type the %1\$s and click %2\$s <br />To add a <b>new user</b>, type the desired %1\$s and click %2\$s";
$GLOBALS['strLinkUserHelpUser'] = "Felhasználónév";
$GLOBALS['strLinkUserHelpEmail'] = "e-mail cím";
$GLOBALS['strLastLoggedIn'] = "Utoljára bejelentkezve";
$GLOBALS['strDateLinked'] = "Összekapcsolás ideje";

// Login & Permissions
$GLOBALS['strUserAccess'] = "Felhasználói hozzáférés";
$GLOBALS['strAdminAccess'] = "Admin hozzáférés";
$GLOBALS['strUserProperties'] = "Felhasználó tulajdonságai";
$GLOBALS['strPermissions'] = "Jogosultságok";
$GLOBALS['strAuthentification'] = "Hitelesítés";
$GLOBALS['strWelcomeTo'] = "Üdvözli az";
$GLOBALS['strEnterUsername'] = "Adja meg felhasználónevét és jelszavát a bejelentkezéshez";
$GLOBALS['strEnterBoth'] = "Felhasználói nevét és jelszavát is adja meg";
$GLOBALS['strEnableCookies'] = "You need to enable cookies before you can use {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "Session cookie hiba, kérjük, jelentkezzen be újra";
$GLOBALS['strLogin'] = "Bejelentkezés";
$GLOBALS['strLogout'] = "Kilépés";
$GLOBALS['strUsername'] = "Felhasználónév";
$GLOBALS['strPassword'] = "Jelszó";
$GLOBALS['strPasswordRepeat'] = "Jelszó ismét";
$GLOBALS['strAccessDenied'] = "Hozzáférés megtagadva";
$GLOBALS['strUsernameOrPasswordWrong'] = "Hibás felhasználónév vagy jelszó. Próbálja meg újra!";
$GLOBALS['strPasswordWrong'] = "Hibás jelszó.";
$GLOBALS['strNotAdmin'] = "Lehet, hogy ön nem rendelkezik megfelelő jogosultsággal";
$GLOBALS['strDuplicateClientName'] = "A megadott felhasználónév foglalt, adjon meg másikat.";
$GLOBALS['strInvalidPassword'] = "Az új jelszó érvénytelen, adjon meg másikat.";
$GLOBALS['strInvalidEmail'] = "Az e-mail nem megfelelően formátumú, kérjük, adja meg a helyes e-mail címet.";
$GLOBALS['strNotSamePasswords'] = "A két jelszó különbözik.";
$GLOBALS['strRepeatPassword'] = "Jelszó ismét";
$GLOBALS['strDeadLink'] = "Your link is invalid.";
$GLOBALS['strNoPlacement'] = "Selected campaign does not exist. Try this <a href='{link}'>link</a> instead";
$GLOBALS['strNoAdvertiser'] = "Selected advertiser does not exist. Try this <a href='{link}'>link</a> instead";

// General advertising
$GLOBALS['strRequests'] = "Kérések";
$GLOBALS['strImpressions'] = "Megjelenés";
$GLOBALS['strClicks'] = "Kattintás";
$GLOBALS['strConversions'] = "Konverzió";
$GLOBALS['strCTRShort'] = "CTR- Átkattintás";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCTR'] = "Átkattintási arány";
$GLOBALS['strTotalClicks'] = "Összes kattintás";
$GLOBALS['strTotalConversions'] = "Összes konverzió";
$GLOBALS['strDateTime'] = "Dátum/idő";
$GLOBALS['strTrackerID'] = "Követőkód ID";
$GLOBALS['strTrackerName'] = "Követőkód neve";
$GLOBALS['strTrackerImageTag'] = "Képi elemként";
$GLOBALS['strTrackerJsTag'] = "Javascript elemként";
$GLOBALS['strTrackerAlwaysAppend'] = "Always display appended code, even if no conversion is recorded by the tracker?";
$GLOBALS['strBanners'] = "Reklámok";
$GLOBALS['strCampaigns'] = "Kampány";
$GLOBALS['strCampaignID'] = "Kampány azonosító";
$GLOBALS['strCampaignName'] = "Kampány név";
$GLOBALS['strCountry'] = "Ország";
$GLOBALS['strStatsAction'] = "Művelet";
$GLOBALS['strWindowDelay'] = "Window delay";
$GLOBALS['strStatsVariables'] = "Változók";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC (kattintás alapú)";
$GLOBALS['strFinanceCPA'] = "CPA (konverzió alapú)";
$GLOBALS['strFinanceMT'] = "Tenancy";
$GLOBALS['strFinanceCTR'] = "CTR- Átkattintás";
$GLOBALS['strFinanceCR'] = "CR";

// Time and date related
$GLOBALS['strDate'] = "Dátum";
$GLOBALS['strDay'] = "Nap";
$GLOBALS['strDays'] = "Napok";
$GLOBALS['strWeek'] = "Hét";
$GLOBALS['strWeeks'] = "Hetek";
$GLOBALS['strSingleMonth'] = "Hónap";
$GLOBALS['strMonths'] = "Hónapok";
$GLOBALS['strDayOfWeek'] = "A hét napja";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = array();
}
$GLOBALS['strDayFullNames'][0] = 'Vasárnap';
$GLOBALS['strDayFullNames'][1] = 'Hétfő';
$GLOBALS['strDayFullNames'][2] = 'Kedd';
$GLOBALS['strDayFullNames'][3] = 'Szerda';
$GLOBALS['strDayFullNames'][4] = 'Csütörtök';
$GLOBALS['strDayFullNames'][5] = 'Péntek';
$GLOBALS['strDayFullNames'][6] = 'Szombat';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = array();
}
$GLOBALS['strDayShortCuts'][0] = 'V';
$GLOBALS['strDayShortCuts'][1] = 'H';
$GLOBALS['strDayShortCuts'][2] = 'K';
$GLOBALS['strDayShortCuts'][3] = 'Sze';
$GLOBALS['strDayShortCuts'][4] = 'Cs';
$GLOBALS['strDayShortCuts'][5] = 'P';
$GLOBALS['strDayShortCuts'][6] = 'Szo';

$GLOBALS['strHour'] = "Óra";
$GLOBALS['strSeconds'] = "másodperc";
$GLOBALS['strMinutes'] = "perc";
$GLOBALS['strHours'] = "óra";

// Advertiser
$GLOBALS['strClient'] = "Hirdető";
$GLOBALS['strClients'] = "Hirdetők";
$GLOBALS['strClientsAndCampaigns'] = "Hirdetők és kampányok";
$GLOBALS['strAddClient'] = "Új hirdető hozzáadása";
$GLOBALS['strClientProperties'] = "Hirdető tulajdonságai";
$GLOBALS['strClientHistory'] = "Hirdető statisztikája";
$GLOBALS['strNoClients'] = "There are currently no advertisers defined. To create a campaign, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
$GLOBALS['strConfirmDeleteClient'] = "Valóban törli ezt a hirdetőt?";
$GLOBALS['strConfirmDeleteClients'] = "Do you really want to delete the selected advertisers?";
$GLOBALS['strHideInactive'] = "Inaktív elrejtése";
$GLOBALS['strInactiveAdvertisersHidden'] = "inaktív hirdető elrejtve";
$GLOBALS['strAdvertiserSignup'] = "Hirdetői regisztrálása";
$GLOBALS['strAdvertiserCampaigns'] = "Hirdetők és kampányok";

// Advertisers properties
$GLOBALS['strContact'] = "Kapcsolattartó";
$GLOBALS['strContactName'] = "Kapcsolattartó neve";
$GLOBALS['strEMail'] = "E-mail";
$GLOBALS['strSendAdvertisingReport'] = "Hirdetési jelentés küldése e-mailben";
$GLOBALS['strNoDaysBetweenReports'] = "A jelentések közti napok száma";
$GLOBALS['strSendDeactivationWarning'] = "Figyelmeztetés küldése a kampány deaktiválásakor";
$GLOBALS['strAllowClientModifyBanner'] = "A felhasználó módosíthatja a reklámait";
$GLOBALS['strAllowClientDisableBanner'] = "A felhasználó deaktiválhatja a saját reklámait";
$GLOBALS['strAllowClientActivateBanner'] = "A felhasználó aktiválhatja a saját reklámait";
$GLOBALS['strAllowCreateAccounts'] = "Allow this user to manage this account's users";
$GLOBALS['strAdvertiserLimitation'] = "Display only one banner from this advertiser on a web page";
$GLOBALS['strAllowAuditTrailAccess'] = "Allow this user to access the audit trail";
$GLOBALS['strAllowDeleteItems'] = "Allow this user to delete items";

// Campaign
$GLOBALS['strCampaign'] = "Kampány";
$GLOBALS['strCampaigns'] = "Kampány";
$GLOBALS['strAddCampaign'] = "Új kampány";
$GLOBALS['strAddCampaign_Key'] = "Ú<u>j</u> kampány";
$GLOBALS['strCampaignForAdvertiser'] = "for advertiser";
$GLOBALS['strLinkedCampaigns'] = "Hozzákapcsolt kampányok";
$GLOBALS['strCampaignProperties'] = "Kampány tulajdonságai";
$GLOBALS['strCampaignOverview'] = "Kampány áttekintése";
$GLOBALS['strCampaignHistory'] = "Kampány statisztika";
$GLOBALS['strNoCampaigns'] = "Jelenleg nincsenek kampányok";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "There are currently no campaigns defined, because there are no advertisers. To create a campaign, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
$GLOBALS['strConfirmDeleteCampaign'] = "Valóban törli ezt a kampányt?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Do you really want to delete the selected campaigns?";
$GLOBALS['strShowParentAdvertisers'] = "Szülő hirdetők mutatása";
$GLOBALS['strHideParentAdvertisers'] = "Szülő hirdetők elrejtése";
$GLOBALS['strHideInactiveCampaigns'] = "Inaktív kampányok elrejtése";
$GLOBALS['strInactiveCampaignsHidden'] = "inaktív kampány elrejtve";
$GLOBALS['strPriorityInformation'] = "Prioritás más kampányokhoz képest";
$GLOBALS['strECPMInformation'] = "eCPM prioritás";
$GLOBALS['strRemnantEcpmDescription'] = "eCPM is automatically calculated based on this campaign's performance.<br />It will be used to prioritise Remnant campaigns relative to each other.";
$GLOBALS['strEcpmMinImpsDescription'] = "Set this to your desired minium basis on which to calculate this campaign's eCPM.";
$GLOBALS['strHiddenCampaign'] = "Kampány";
$GLOBALS['strHiddenAd'] = "Advertisement";
$GLOBALS['strHiddenAdvertiser'] = "Hirdető";
$GLOBALS['strHiddenTracker'] = "Tracker";
$GLOBALS['strHiddenWebsite'] = "Weboldal";
$GLOBALS['strHiddenZone'] = "Zóna";
$GLOBALS['strCampaignDelivery'] = "Kampány továbbítás";
$GLOBALS['strCompanionPositioning'] = "Companion positioning";
$GLOBALS['strSelectUnselectAll'] = "Összes kijelöl / visszavon";
$GLOBALS['strCampaignsOfAdvertiser'] = "itt:"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'
$GLOBALS['strShowCappedNoCookie'] = "Show capped ads if cookies are disabled";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "Calculated for all campaigns";
$GLOBALS['strCalculatedForThisCampaign'] = "Calculated for this campaign";
$GLOBALS['strLinkingZonesProblem'] = "Problem occurred when linking zones";
$GLOBALS['strUnlinkingZonesProblem'] = "Problem occurred when unlinking zones";
$GLOBALS['strZonesLinked'] = "zone(s) linked";
$GLOBALS['strZonesUnlinked'] = "zone(s) unlinked";
$GLOBALS['strZonesSearch'] = "Keresés";
$GLOBALS['strZonesSearchTitle'] = "Zónák és weboldalak keresése név szerint";
$GLOBALS['strNoWebsitesAndZones'] = "Nincsenek weboldalak és zónák";
$GLOBALS['strNoWebsitesAndZonesText'] = "with \"%s\" in name";
$GLOBALS['strToLink'] = "to link";
$GLOBALS['strToUnlink'] = "to unlink";
$GLOBALS['strLinked'] = "Összekapcsolva";
$GLOBALS['strAvailable'] = "Elérhető";
$GLOBALS['strShowing'] = "Mutatva";
$GLOBALS['strEditZone'] = "Zóna szerkesztése";
$GLOBALS['strEditWebsite'] = "Weboldal szerkesztés";


// Campaign properties
$GLOBALS['strDontExpire'] = "A kampány nem jár le";
$GLOBALS['strActivateNow'] = "A kampány azonnali aktiválása";
$GLOBALS['strSetSpecificDate'] = "Adott dátum";
$GLOBALS['strLow'] = "Alacsony";
$GLOBALS['strHigh'] = "Magas";
$GLOBALS['strExpirationDate'] = "Lejárat dátuma";
$GLOBALS['strExpirationDateComment'] = "Campaign will finish at the end of this day";
$GLOBALS['strActivationDate'] = "Kezdés dátuma";
$GLOBALS['strActivationDateComment'] = "A kampány az adott nap elején kezdődik";
$GLOBALS['strImpressionsRemaining'] = "Fennmaradó megjelenések";
$GLOBALS['strClicksRemaining'] = "Fennmaradó kattintások";
$GLOBALS['strConversionsRemaining'] = "Fennmaradó konverziók";
$GLOBALS['strImpressionsBooked'] = "Megjelenés előjegyezve";
$GLOBALS['strClicksBooked'] = "Kattintások előjegyezve";
$GLOBALS['strConversionsBooked'] = "Konverzió előjegyezve";
$GLOBALS['strCampaignWeight'] = "A kampány beállított súlya";
$GLOBALS['strAnonymous'] = "Hide the advertiser and websites of this campaign.";
$GLOBALS['strTargetPerDay'] = "naponta.";
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
$GLOBALS['strCampaignStatusPending'] = "Függőben";
$GLOBALS['strCampaignStatusInactive'] = "aktív";
$GLOBALS['strCampaignStatusRunning'] = "Fut";
$GLOBALS['strCampaignStatusPaused'] = "Szüneteltetve";
$GLOBALS['strCampaignStatusAwaiting'] = "Várakozik";
$GLOBALS['strCampaignStatusExpired'] = "Befejezve";
$GLOBALS['strCampaignStatusApproval'] = "Jóváhagyásra vár";
$GLOBALS['strCampaignStatusRejected'] = "Elutasítva";
$GLOBALS['strCampaignStatusAdded'] = "Hozzáadva";
$GLOBALS['strCampaignStatusStarted'] = "Elindítva";
$GLOBALS['strCampaignStatusRestarted'] = "Újraindítva";
$GLOBALS['strCampaignStatusDeleted'] = "Törölt";
$GLOBALS['strCampaignType'] = "Kampány típus";
$GLOBALS['strType'] = "Típus";
$GLOBALS['strContract'] = "Szerződés";
$GLOBALS['strOverride'] = "Override";
$GLOBALS['strOverrideInfo'] = "Override campaigns are a special campaign type specifically to
    override (i.e. take priority over) Remnant and Contract campaigns. Override campaigns are generally used with
    specific targeting and/or capping rules to ensure that the campaign banners are always displayed in certain
    locations, to certain users, and perhaps a certain number of times, as part of a specific promotion. (This campaign
    type was previously known as 'Contract (Exclusive)'.)";
$GLOBALS['strStandardContract'] = "Szerződés";
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
$GLOBALS['strPricing'] = "Árazás";
$GLOBALS['strPricingModel'] = "Árazási modell";
$GLOBALS['strSelectPricingModel'] = "--válassz modellt--";
$GLOBALS['strRatePrice'] = "Egységár";
$GLOBALS['strMinimumImpressions'] = "Minimum daily impressions";
$GLOBALS['strLimit'] = "Korlát";
$GLOBALS['strLowExclusiveDisabled'] = "You cannot change this campaign to Remnant or Exclusive, since both an end date and either of impressions/clicks/conversions limit are set. <br>In order to change type, you need to set no expiry date or remove limits.";
$GLOBALS['strCannotSetBothDateAndLimit'] = "Nem állíthat be egyszerre záró dátumot és limit is Remnant és Exclusive kampány esetén. <br> Ha be kell állítani a záró dátumot is és a limitet is a megjelenésre/kattintásra/konverzióra, akkor használj no-exclusive kampányt.";
$GLOBALS['strWhyDisabled'] = "Miért van letiltva?";
$GLOBALS['strBackToCampaigns'] = "Back to campaigns";
$GLOBALS['strCampaignBanners'] = "Campaign's banners";
$GLOBALS['strCookies'] = "Cookie-k";

// Tracker
$GLOBALS['strTracker'] = "Tracker";
$GLOBALS['strTrackers'] = "Követőkód";
$GLOBALS['strTrackerPreferences'] = "Tracker Preferences";
$GLOBALS['strAddTracker'] = "Új követőkód";
$GLOBALS['strTrackerForAdvertiser'] = "for advertiser";
$GLOBALS['strNoTrackers'] = "There are currently no trackers defined for this advertiser";
$GLOBALS['strConfirmDeleteTrackers'] = "Do you really want to delete all selected trackers?";
$GLOBALS['strConfirmDeleteTracker'] = "Do you really want to delete this tracker?";
$GLOBALS['strTrackerProperties'] = "Követőkód tulajdonságai";
$GLOBALS['strDefaultStatus'] = "Alapértelmezett státusz";
$GLOBALS['strStatus'] = "Állapot";
$GLOBALS['strLinkedTrackers'] = "Linked Trackers";
$GLOBALS['strTrackerInformation'] = "Tracker Information";
$GLOBALS['strConversionWindow'] = "Konverziós ablak";
$GLOBALS['strUniqueWindow'] = "Unique window";
$GLOBALS['strClick'] = "Kattintás";
$GLOBALS['strView'] = "Megnéz";
$GLOBALS['strArrival'] = "Arrival";
$GLOBALS['strManual'] = "Manuális";
$GLOBALS['strImpression'] = "Impression";
$GLOBALS['strConversionType'] = "Konverzió típusa";
$GLOBALS['strLinkCampaignsByDefault'] = "Alapértelmezetten kapcsolja össze az újonnan létrehozott kampányokkal";
$GLOBALS['strBackToTrackers'] = "Back to trackers";
$GLOBALS['strIPAddress'] = "IP cím";

// Banners (General)
$GLOBALS['strBanner'] = "Reklám";
$GLOBALS['strBanners'] = "Reklámok";
$GLOBALS['strAddBanner'] = "Új banner hozzáadása";
$GLOBALS['strAddBanner_Key'] = "Ú<u>j</u> reklám";
$GLOBALS['strBannerToCampaign'] = "to campaign";
$GLOBALS['strShowBanner'] = "Reklám megnézése";
$GLOBALS['strBannerProperties'] = "Reklám tulajdonságai";
$GLOBALS['strBannerHistory'] = "Banner Statistics";
$GLOBALS['strNoBanners'] = "Jelenleg nincsenek reklámok";
$GLOBALS['strNoBannersAddCampaign'] = "There are currently no banners defined, because there are no campaigns. To create a banner, <a href='campaign-edit.php?clientid=%s'>add a new campaign</a> first.";
$GLOBALS['strNoBannersAddAdvertiser'] = "There are currently no banners defined, because there are no advertisers. To create a banner, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
$GLOBALS['strConfirmDeleteBanner'] = "Valóban törli ezt a reklámot?";
$GLOBALS['strConfirmDeleteBanners'] = "Deleting these banners will also remove their statistics.\\nDo you really want to delete the selected banners?";
$GLOBALS['strShowParentCampaigns'] = "Szülő kampányok megjelenítése";
$GLOBALS['strHideParentCampaigns'] = "Szülő kampányok elrejtése";
$GLOBALS['strHideInactiveBanners'] = "Inaktív reklámok elrejtése";
$GLOBALS['strInactiveBannersHidden'] = "inaktív reklám elrejtve";
$GLOBALS['strWarningMissing'] = "Warning, possibly missing ";
$GLOBALS['strWarningMissingClosing'] = " closing tag '>'";
$GLOBALS['strWarningMissingOpening'] = " opening tag '<'";
$GLOBALS['strSubmitAnyway'] = "Submit Anyway";
$GLOBALS['strBannersOfCampaign'] = "itt:"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "Reklám tulajdonságok";
$GLOBALS['strCampaignPreferences'] = "Kampány tulajdonságok";
$GLOBALS['strDefaultBanners'] = "Alapértelmezett reklámok";
$GLOBALS['strDefaultBannerUrl'] = "Alapértelmezett kép URL";
$GLOBALS['strDefaultBannerDestination'] = "Alapértelmezett cél URL";
$GLOBALS['strAllowedBannerTypes'] = "Allowed Banner Types";
$GLOBALS['strTypeSqlAllow'] = "Allow SQL Local Banners";
$GLOBALS['strTypeWebAllow'] = "Allow Webserver Local Banners";
$GLOBALS['strTypeUrlAllow'] = "Allow External Banners";
$GLOBALS['strTypeHtmlAllow'] = "Allow HTML Banners";
$GLOBALS['strTypeTxtAllow'] = "Allow Text Ads";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Válassza ki a reklámtípust";
$GLOBALS['strMySQLBanner'] = "Helyi reklám (SQL)";
$GLOBALS['strWebBanner'] = "Helyi reklám (Webkiszolgáló)";
$GLOBALS['strURLBanner'] = "Külső reklám";
$GLOBALS['strHTMLBanner'] = "HTML reklám";
$GLOBALS['strTextBanner'] = "Szöveges hirdetés";
$GLOBALS['strAlterHTML'] = "Alter HTML to enable click tracking for:";
$GLOBALS['strIframeFriendly'] = "This banner can be safely displayed inside an iframe (e.g. is not expandable)";
$GLOBALS['strUploadOrKeep'] = "Megtartja a létező képet, <br>vagy tölt fel egy másikat?";
$GLOBALS['strNewBannerFile'] = "Válassza ki a reklámként <br>használni kívánt képet<br><br>";
$GLOBALS['strNewBannerFileAlt'] = "Select a backup image you <br />want to use in case browsers<br />don't support rich media<br /><br />";
$GLOBALS['strNewBannerURL'] = "Kép hivatkozása (tart. http://)";
$GLOBALS['strURL'] = "Cél hivatkozása (tart. http://)";
$GLOBALS['strKeyword'] = "Kulcsszó";
$GLOBALS['strTextBelow'] = "A kép alatti szöveg";
$GLOBALS['strWeight'] = "Súlyozás";
$GLOBALS['strAlt'] = "ALT szöveg";
$GLOBALS['strStatusText'] = "Szöveg az állapotsoron";
$GLOBALS['strCampaignsWeight'] = "Campaign's Weight";
$GLOBALS['strBannerWeight'] = "Reklám súlyozása";
$GLOBALS['strBannersWeight'] = "Banner's Weight";
$GLOBALS['strAdserverTypeGeneric'] = "Generic HTML Banner";
$GLOBALS['strDoNotAlterHtml'] = "Do not alter HTML";
$GLOBALS['strGenericOutputAdServer'] = "Általános";
$GLOBALS['strBackToBanners'] = "Back to banners";
$GLOBALS['strUseWyswygHtmlEditor'] = "Use WYSIWYG HTML Editor";
$GLOBALS['strChangeDefault'] = "Change default";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "A HTML-kód hozzáfűzése a reklám elé";
$GLOBALS['strBannerAppendHTML'] = "A HTML-kód hozzáfűzése a reklám elé";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "Kézbesítés beállításai";
$GLOBALS['strACL'] = "Kézbesítés beállításai";
$GLOBALS['strACLAdd'] = "Add delivery rule";
$GLOBALS['strApplyLimitationsTo'] = "Apply delivery rules to";
$GLOBALS['strAllBannersInCampaign'] = "All banners in this campaign";
$GLOBALS['strRemoveAllLimitations'] = "Remove all delivery rules";
$GLOBALS['strEqualTo'] = "Egyenlő ezzel:";
$GLOBALS['strDifferentFrom'] = "Eltérő ettől:";
$GLOBALS['strLaterThan'] = "is later than";
$GLOBALS['strLaterThanOrEqual'] = "is later than or equal to";
$GLOBALS['strEarlierThan'] = "is earlier than";
$GLOBALS['strEarlierThanOrEqual'] = "is earlier than or equal to";
$GLOBALS['strContains'] = "Tartalmazza ezt:";
$GLOBALS['strNotContains'] = "Nem tartalmazza ezt:";
$GLOBALS['strGreaterThan'] = "Nagyobb mint:";
$GLOBALS['strLessThan'] = "Kisebb mint:";
$GLOBALS['strGreaterOrEqualTo'] = "Nagyobb vagy egyenlő mint:";
$GLOBALS['strLessOrEqualTo'] = "Kisebb vagy egyenlő mint:";
$GLOBALS['strAND'] = "ÉS";                          // logical operator
$GLOBALS['strOR'] = "VAGY";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "A reklám megjelenítése csak ekkor:";
$GLOBALS['strWeekDays'] = "Hétköznap";
$GLOBALS['strTime'] = "Idő";
$GLOBALS['strDomain'] = "Domain";
$GLOBALS['strSource'] = "Forrás";
$GLOBALS['strBrowser'] = "Böngésző";
$GLOBALS['strOS'] = "OS";
$GLOBALS['strDeliveryLimitations'] = "Delivery Rules";

$GLOBALS['strDeliveryCappingReset'] = "Ennyi idő után a számlálók visszaállítása:";
$GLOBALS['strDeliveryCappingTotal'] = "összesen";
$GLOBALS['strDeliveryCappingSession'] = "egy session alatt";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['title'] = "Kézbesítési plafon látogatónként";
$GLOBALS['strCappingBanner']['limit'] = "Reklám megmutatva ennyiszer:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['title'] = "Kézbesítési plafon látogatónként";
$GLOBALS['strCappingCampaign']['limit'] = "Limit campaign views to:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['title'] = "Kézbesítési plafon látogatónként";
$GLOBALS['strCappingZone']['limit'] = "Limit zone views to:";

// Website
$GLOBALS['strAffiliate'] = "Weboldal";
$GLOBALS['strAffiliates'] = "Weboldalak";
$GLOBALS['strAffiliatesAndZones'] = "Weboldalak & zónák";
$GLOBALS['strAddNewAffiliate'] = "Új weboldal";
$GLOBALS['strAffiliateProperties'] = "Weboldal tulajdonságai";
$GLOBALS['strAffiliateHistory'] = "Weboldal statisztika";
$GLOBALS['strNoAffiliates'] = "Jelenleg nincsenek weboldalak. Zóna létrehozásához először <a href='affiliate-edit.php'>adj hozzá egy új weboldalt</a>.";
$GLOBALS['strConfirmDeleteAffiliate'] = "Valóban törli ezt a weboldalt?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Do you really want to delete the selected websites?";
$GLOBALS['strInactiveAffiliatesHidden'] = "inaktív weboldal elrejtve";
$GLOBALS['strShowParentAffiliates'] = "A szülő weboldalak mutatása";
$GLOBALS['strHideParentAffiliates'] = "A szülő weboldalak elrejtése";

// Website (properties)
$GLOBALS['strWebsite'] = "Weboldal";
$GLOBALS['strWebsiteURL'] = "Weboldal URL";
$GLOBALS['strAllowAffiliateModifyZones'] = "A felhasználó módosíthatja a saját zónáit";
$GLOBALS['strAllowAffiliateLinkBanners'] = "A felhasználó kapcsolhat reklámokat a saját zónáihoz";
$GLOBALS['strAllowAffiliateAddZone'] = "A felhasználó adhat meg új zónákat";
$GLOBALS['strAllowAffiliateDeleteZone'] = "A felhasználó törölhet létező zónákat";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Allow this user to generate invocation code";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "Irányítószám";
$GLOBALS['strCountry'] = "Ország";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Weboldal zónái";

// Zone
$GLOBALS['strZone'] = "Zóna";
$GLOBALS['strZones'] = "Zónák";
$GLOBALS['strAddNewZone'] = "Új zóna";
$GLOBALS['strAddNewZone_Key'] = "Ú<u>j</u> zóna";
$GLOBALS['strZoneToWebsite'] = "to website";
$GLOBALS['strLinkedZones'] = "Zónák kapcsolása";
$GLOBALS['strAvailableZones'] = "Elérhető zónák";
$GLOBALS['strLinkingNotSuccess'] = "Linking not successful, please try again";
$GLOBALS['strZoneProperties'] = "Zóna tulajdonságai";
$GLOBALS['strZoneHistory'] = "Zóna előzményei";
$GLOBALS['strNoZones'] = "Jelenleg nincsenek zónák ezen a weboldalon.";
$GLOBALS['strNoZonesAddWebsite'] = "There are currently no zones defined, because there are no websites. To create a zone, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strConfirmDeleteZone'] = "Valóban törölni akarja ezt a zónát?";
$GLOBALS['strConfirmDeleteZones'] = "Do you really want to delete the selected zones?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "There are campaigns still linked to this zone, if you delete it these will not be able to run and you will not be paid for them.";
$GLOBALS['strZoneType'] = "Zóna típusa";
$GLOBALS['strBannerButtonRectangle'] = "Reklám, gomb vagy négyszög";
$GLOBALS['strInterstitial'] = "Interstíciós vagy lebegő DHTML";
$GLOBALS['strPopup'] = "Felbukkanó ablak";
$GLOBALS['strTextAdZone'] = "Szöveges hirdetés";
$GLOBALS['strEmailAdZone'] = "Email/Newsletter zone";
$GLOBALS['strZoneVideoInstream'] = "Inline Video ad";
$GLOBALS['strZoneVideoOverlay'] = "Overlay Video ad";
$GLOBALS['strShowMatchingBanners'] = "Egyező reklámok megjelenítése";
$GLOBALS['strHideMatchingBanners'] = "Egyező reklámok elrejtése";
$GLOBALS['strBannerLinkedAds'] = "Banners linked to the zone";
$GLOBALS['strCampaignLinkedAds'] = "Campaigns linked to the zone";
$GLOBALS['strInactiveZonesHidden'] = "inaktív zóna elrejtve";
$GLOBALS['strWarnChangeZoneType'] = "Changing the zone type to text or email will unlink all banners/campaigns due to restrictions of these zone types
                                                <ul>
                                                    <li>Text zones can only be linked to text ads</li>
                                                    <li>Email zone campaigns can only have one active banner at a time</li>
                                                </ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Changing the zone size will unlink any banners that are not the new size, and will add any banners from linked campaigns which are the new size';
$GLOBALS['strWarnChangeBannerSize'] = 'Changing the banner size will unlink this banner from any zones that are not the new size, and if this banner\'s <strong>campaign</strong> is linked to a zone of the new size, this banner will be automatically linked';
$GLOBALS['strWarnBannerReadonly'] = 'This banner is read-only because an extension has been disabled. Contact your system administrator for more information.';
$GLOBALS['strZonesOfWebsite'] = 'itt:'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "Vissza a zónákhoz";

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
$GLOBALS['strAdvanced'] = "Speciális";
$GLOBALS['strChainSettings'] = "Lánc beállításai";
$GLOBALS['strZoneNoDelivery'] = "Ha nem továbbíthatók reklámok <br>ebból a zónából, akkor próbálja meg...";
$GLOBALS['strZoneStopDelivery'] = "A továbbítás leállítása, és nincs reklám megjelenítés";
$GLOBALS['strZoneOtherZone'] = "A kiválasztott zóna megjelenítése ehelyett";
$GLOBALS['strZoneAppend'] = "A következő HTML kód mindenkori hozzáfűzése a zóna által megjelenített reklámokhoz";
$GLOBALS['strAppendSettings'] = "Hozzáfűzés beállításai";
$GLOBALS['strZonePrependHTML'] = "A HTML-kód hozzáfűzése a zóna által megjelenített szöveges reklám előtt";
$GLOBALS['strZoneAppendNoBanner'] = "Prepend/Append even if no banner delivered";
$GLOBALS['strZoneAppendHTMLCode'] = "HTML kód";
$GLOBALS['strZoneAppendZoneSelection'] = "Felbukkanó vagy interstíciós ablak";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "A kiválasztott zónához kapcsolt reklámok jelenleg nem aktívak. <br>Ez az a zónalánc, ami után következik:";
$GLOBALS['strZoneProbNullPri'] = "Jelenleg nem aktívak a zónához kapcsolt reklámok.";
$GLOBALS['strZoneProbListChainLoop'] = "A zónalánc követése ismétlődő ciklust okozhat. A zónához történő továbbítás leáll.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Válassza ki a kapcsolt reklámok típusát";
$GLOBALS['strLinkedBanners'] = "Link individual banners";
$GLOBALS['strCampaignDefaults'] = "Link banners by parent campaign";
$GLOBALS['strLinkedCategories'] = "Link banners by category";
$GLOBALS['strWithXBanners'] = "%d banner(s)";
$GLOBALS['strRawQueryString'] = "Kulcsszó";
$GLOBALS['strIncludedBanners'] = "Reklámok kapcsolása";
$GLOBALS['strMatchingBanners'] = "{szám} egyező reklámok";
$GLOBALS['strNoCampaignsToLink'] = "Jelenleg nincsenek ehhez a zónához kapcsolt kampányok";
$GLOBALS['strNoTrackersToLink'] = "There are currently no trackers available which can be linked to this campaign";
$GLOBALS['strNoZonesToLinkToCampaign'] = "Nincsenek ehhez a kampányhoz kapcsolható zónák";
$GLOBALS['strSelectBannerToLink'] = "Válassza ki a zónához kapcsolni kívánt reklámot:";
$GLOBALS['strSelectCampaignToLink'] = "Válassza ki a zónához kapcsolni kívánt kampányt:";
$GLOBALS['strSelectAdvertiser'] = "Válassz egy hirdetőt";
$GLOBALS['strSelectPlacement'] = "Válassz egy kampányt";
$GLOBALS['strSelectAd'] = "Válassz egy reklámot";
$GLOBALS['strSelectPublisher'] = "Válassz egy weboldalt";
$GLOBALS['strSelectZone'] = "Válassz egy zónát";
$GLOBALS['strStatusPending'] = "Függőben";
$GLOBALS['strStatusApproved'] = "Jóváhagyva";
$GLOBALS['strStatusDisapproved'] = "Disapproved";
$GLOBALS['strStatusDuplicate'] = "Duplikál";
$GLOBALS['strStatusOnHold'] = "On Hold";
$GLOBALS['strStatusIgnore'] = "Kihagyás";
$GLOBALS['strConnectionType'] = "Típus";
$GLOBALS['strConnTypeSale'] = "Eladás";
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Regisztráció";
$GLOBALS['strShortcutEditStatuses'] = "Edit statuses";
$GLOBALS['strShortcutShowStatuses'] = "Show statuses";

// Statistics
$GLOBALS['strStats'] = "Statisztikák";
$GLOBALS['strNoStats'] = "Jelenleg nincs statisztika";
$GLOBALS['strNoStatsForPeriod'] = "There are currently no statistics available for the period %s to %s";
$GLOBALS['strGlobalHistory'] = "Global Statistics";
$GLOBALS['strDailyHistory'] = "Napi statisztikák";
$GLOBALS['strDailyStats'] = "Napi statisztikák";
$GLOBALS['strWeeklyHistory'] = "Heti statisztikák";
$GLOBALS['strMonthlyHistory'] = "Havi statisztikák";
$GLOBALS['strTotalThisPeriod'] = "Időszak összes";
$GLOBALS['strPublisherDistribution'] = "Website Distribution";
$GLOBALS['strCampaignDistribution'] = "Campaign Distribution";
$GLOBALS['strViewBreakdown'] = "Megnéz";
$GLOBALS['strBreakdownByDay'] = "Nap";
$GLOBALS['strBreakdownByWeek'] = "Hét";
$GLOBALS['strBreakdownByMonth'] = "Hónap";
$GLOBALS['strBreakdownByDow'] = "A hét napja";
$GLOBALS['strBreakdownByHour'] = "Óra";
$GLOBALS['strItemsPerPage'] = "Listázás oldalanként";
$GLOBALS['strDistributionHistoryCampaign'] = "Distribution Statistics (Campaign)";
$GLOBALS['strDistributionHistoryBanner'] = "Distribution Statistics (Banner)";
$GLOBALS['strDistributionHistoryWebsite'] = "Distribution Statistics (Website)";
$GLOBALS['strDistributionHistoryZone'] = "Distribution Statistics (Zone)";
$GLOBALS['strShowGraphOfStatistics'] = "Show <u>G</u>raph of Statistics";
$GLOBALS['strExportStatisticsToExcel'] = "Statisztikák <u>E</u>xportálása Excel-be";
$GLOBALS['strGDnotEnabled'] = "You must have GD enabled in PHP to display graphs. <br />Please see <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> for more information, including how to install GD on your server.";
$GLOBALS['strStatsArea'] = "Area";

// Expiration
$GLOBALS['strNoExpiration'] = "Nincs megadva a lejárat dátuma";
$GLOBALS['strEstimated'] = "Becsült lejárat";
$GLOBALS['strNoExpirationEstimation'] = "No expiration estimated yet";
$GLOBALS['strDaysAgo'] = "days ago";
$GLOBALS['strCampaignStop'] = "Kampány vége";

// Reports
$GLOBALS['strAdvancedReports'] = "Advanced Reports";
$GLOBALS['strStartDate'] = "Kezdő dátum";
$GLOBALS['strEndDate'] = "Befejezés dátuma";
$GLOBALS['strPeriod'] = "Periódus";
$GLOBALS['strLimitations'] = "Delivery Rules";
$GLOBALS['strWorksheets'] = "Worksheets";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "Összes hirdető";
$GLOBALS['strAnonAdvertisers'] = "Anonymous advertisers";
$GLOBALS['strAllPublishers'] = "All websites";
$GLOBALS['strAnonPublishers'] = "Anonymous websites";
$GLOBALS['strAllAvailZones'] = "Az összes elérhető zóna";

// Userlog
$GLOBALS['strUserLog'] = "Felhasználói napló";
$GLOBALS['strUserLogDetails'] = "Felhasználói napló részletei";
$GLOBALS['strDeleteLog'] = "Napló törlése";
$GLOBALS['strAction'] = "Művelet";
$GLOBALS['strNoActionsLogged'] = "Nincs naplózott művelet";

// Code generation
$GLOBALS['strGenerateBannercode'] = "Közvetlen kiválasztás";
$GLOBALS['strChooseInvocationType'] = "Válassza ki a reklámhívás típusát";
$GLOBALS['strGenerate'] = "Generálás";
$GLOBALS['strParameters'] = "Jellemzők";
$GLOBALS['strFrameSize'] = "Keret mérete";
$GLOBALS['strBannercode'] = "Reklámkód";
$GLOBALS['strTrackercode'] = "Követőkód";
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
$GLOBALS['strNoMatchesFound'] = "Nincs találat";
$GLOBALS['strErrorOccurred'] = "Hiba történt";
$GLOBALS['strErrorDBPlain'] = "Hiba történt az adatbázishoz történő hozzáféréskor";
$GLOBALS['strErrorDBSerious'] = "Komoly probléma állapítható meg az adatbázissal kapcsolatban";
$GLOBALS['strErrorDBNoDataPlain'] = "Due to a problem with the database {$PRODUCT_NAME} couldn't retrieve or store data. ";
$GLOBALS['strErrorDBNoDataSerious'] = "Due to a serious problem with the database, {$PRODUCT_NAME} couldn't retrieve data";
$GLOBALS['strErrorDBCorrupt'] = "Valószínűleg sérült az adatbázis tábla, ezért javításra szorul. A sérült táblákkal kapcsolatban további részleteket olvashat az <i>Administrator guide</i> <i>Troubleshooting</i> fejezetében.";
$GLOBALS['strErrorDBContact'] = "Vegye fel a kapcsolatot a kiszolgáló adminisztrátorával, és értesítse őt a problémáról.";
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
$GLOBALS['strRequiredFieldLegend'] = "a mező kitöltése kötelező";
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
$GLOBALS['strMailSubject'] = "Hirdetési jelentés";
$GLOBALS['strMailHeader'] = "Dear {contact},";
$GLOBALS['strMailBannerStats'] = "Kérem, tekintse át az alábbiakban a {clientname} reklámstatisztikáját:";
$GLOBALS['strMailBannerActivatedSubject'] = "Campaign activated";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Campaign deactivated";
$GLOBALS['strMailBannerActivated'] = "Your campaign shown below has been activated because
the campaign activation date has been reached.";
$GLOBALS['strMailBannerDeactivated'] = "Your campaign shown below has been deactivated because";
$GLOBALS['strMailFooter'] = "Regards,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "A kampány jelenleg nem aktív, mert";
$GLOBALS['strBeforeActivate'] = "még nem érkezett el az aktiválás dátuma";
$GLOBALS['strAfterExpire'] = "már elérkezett a lejárat dátuma";
$GLOBALS['strNoMoreImpressions'] = "there are no Impressions remaining";
$GLOBALS['strNoMoreClicks'] = "már nincs több kattintás";
$GLOBALS['strNoMoreConversions'] = "there are no Sales remaining";
$GLOBALS['strWeightIsNull'] = "súlyozást nullára állította";
$GLOBALS['strRevenueIsNull'] = "its revenue is set to zero";
$GLOBALS['strTargetIsNull'] = "its limit per day is set to zero - you need to either specify both an end date and a limit or set Limit per day value";
$GLOBALS['strNoViewLoggedInInterval'] = "Egy reklámletöltés sem került naplózásra a jelentés időtartama alatt";
$GLOBALS['strNoClickLoggedInInterval'] = "Egy kattintás sem került naplózásra a jelentés időtartama alatt";
$GLOBALS['strNoConversionLoggedInInterval'] = "No Conversions were logged during the span of this report";
$GLOBALS['strMailReportPeriod'] = "Ez a jelentés a {startdate} és {enddate} közti statisztikát tartalmazza.";
$GLOBALS['strMailReportPeriodAll'] = "Ez a jelentés a teljes statisztikát tartalmazza {enddate}-ig.";
$GLOBALS['strNoStatsForCampaign'] = "Nem áll rendelkezésre a kampány statisztikája";
$GLOBALS['strImpendingCampaignExpiry'] = "Impending campaign expiration";
$GLOBALS['strYourCampaign'] = "Your campaign";
$GLOBALS['strTheCampiaignBelongingTo'] = "The campaign belonging to";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} shown below is due to end on {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} shown below has less than {limit} impressions remaining.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "As a result, the campaign will soon be automatically disabled, and the
following banners in the campaign will also be disabled:";

// Priority
$GLOBALS['strPriority'] = "Prioritás";
$GLOBALS['strSourceEdit'] = "Edit Sources";

// Preferences
$GLOBALS['strPreferences'] = "Preferenciák";
$GLOBALS['strUserPreferences'] = "Felhasználói beállítások";
$GLOBALS['strChangePassword'] = "Jelszó módosítása";
$GLOBALS['strChangeEmail'] = "E-mail cím módosítása";
$GLOBALS['strCurrentPassword'] = "Jelenlegi jelszó";
$GLOBALS['strChooseNewPassword'] = "Válasszon egy jelszót";
$GLOBALS['strReenterNewPassword'] = "Írja be újra az új jelszót";
$GLOBALS['strNameLanguage'] = "Name & Language";
$GLOBALS['strAccountPreferences'] = "Fiókbeállítások";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Kampányok e-mail jelentéseinek beállítása";
$GLOBALS['strTimezonePreferences'] = "Időzóna beállítás";
$GLOBALS['strAdminEmailWarnings'] = "Adminisztrátor e-mail címe";
$GLOBALS['strAgencyEmailWarnings'] = "Felhasználói figyelmeztető e-mailek";
$GLOBALS['strAdveEmailWarnings'] = "Hirdetői figyelmeztető e-mailek";
$GLOBALS['strFullName'] = "Teljes név";
$GLOBALS['strEmailAddress'] = "E-mail cím";
$GLOBALS['strUserDetails'] = "Felhasználói adatok";
$GLOBALS['strUserInterfacePreferences'] = "Felhasználói felület beállítása";
$GLOBALS['strPluginPreferences'] = "Plugin Preferences";
$GLOBALS['strColumnName'] = "Column Name";
$GLOBALS['strShowColumn'] = "Show Column";
$GLOBALS['strCustomColumnName'] = "Custom Column Name";
$GLOBALS['strColumnRank'] = "Column Rank";

// Long names
$GLOBALS['strRevenue'] = "Revenue";
$GLOBALS['strNumberOfItems'] = "Elemek száma";
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
$GLOBALS['strImpressionSR'] = "Megjelenés";
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
$GLOBALS['strID_short'] = "Azonosító";
$GLOBALS['strRequests_short'] = "Req.";
$GLOBALS['strImpressions_short'] = "Impr.";
$GLOBALS['strClicks_short'] = "Kattintás";
$GLOBALS['strCTR_short'] = "CTR- Átkattintás";
$GLOBALS['strConversions_short'] = "Conv.";
$GLOBALS['strPendingConversions_short'] = "Pend conv.";
$GLOBALS['strImpressionSR_short'] = "Impr. SR";
$GLOBALS['strClickSR_short'] = "Click SR";

// Global Settings
$GLOBALS['strConfiguration'] = "Configuration";
$GLOBALS['strGlobalSettings'] = "Globális beállítások";
$GLOBALS['strGeneralSettings'] = "Általános beállítások";
$GLOBALS['strMainSettings'] = "Alapbeállítások";
$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strChooseSection'] = 'Válasszon egyet';

// Product Updates
$GLOBALS['strProductUpdates'] = "Termékfrissítés";
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
$GLOBALS['strAgencyManagement'] = "Fiók kezelő";
$GLOBALS['strAgency'] = "Account";
$GLOBALS['strAddAgency'] = "Add new account";
$GLOBALS['strAddAgency_Key'] = "Add <u>n</u>ew account";
$GLOBALS['strTotalAgencies'] = "Összes fiók";
$GLOBALS['strAgencyProperties'] = "Account Properties";
$GLOBALS['strNoAgencies'] = "There are currently no accounts defined";
$GLOBALS['strConfirmDeleteAgency'] = "Do you really want to delete this account?";
$GLOBALS['strHideInactiveAgencies'] = "Inaktív fiókok elrejtése";
$GLOBALS['strInactiveAgenciesHidden'] = "inaktív fiók elrejtve";
$GLOBALS['strSwitchAccount'] = "Átváltás erre a fiókra";
$GLOBALS['strAgencyStatusRunning'] = "Active";
$GLOBALS['strAgencyStatusInactive'] = "aktív";
$GLOBALS['strAgencyStatusPaused'] = "Suspended";

// Channels
$GLOBALS['strChannel'] = "Delivery Rule Set";
$GLOBALS['strChannels'] = "Delivery Rule Sets";
$GLOBALS['strChannelManagement'] = "Delivery Rule Set Management";
$GLOBALS['strAddNewChannel'] = "Add new Delivery Rule Set";
$GLOBALS['strAddNewChannel_Key'] = "Add <u>n</u>ew Delivery Rule Set";
$GLOBALS['strChannelToWebsite'] = "to website";
$GLOBALS['strNoChannels'] = "There are currently no delivery rule sets defined";
$GLOBALS['strNoChannelsAddWebsite'] = "There are currently no delivery rule sets defined, because there are no websites. To create a delivery rule set, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strEditChannelLimitations'] = "Edit delivery rules for the delivery rule set";
$GLOBALS['strChannelProperties'] = "Delivery Rule Set Properties";
$GLOBALS['strChannelLimitations'] = "Kézbesítés beállításai";
$GLOBALS['strConfirmDeleteChannel'] = "Do you really want to delete this delivery rule set?";
$GLOBALS['strConfirmDeleteChannels'] = "Do you really want to delete the selected delivery rule sets?";
$GLOBALS['strChannelsOfWebsite'] = 'itt:'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "Változó neve";
$GLOBALS['strVariableDescription'] = "Leírás";
$GLOBALS['strVariableDataType'] = "Adattípus";
$GLOBALS['strVariablePurpose'] = "Célja";
$GLOBALS['strGeneric'] = "Általános";
$GLOBALS['strBasketValue'] = "Kosár értéke";
$GLOBALS['strNumItems'] = "Elemek száma";
$GLOBALS['strVariableIsUnique'] = "Dedup conversions?";
$GLOBALS['strNumber'] = "Szám";
$GLOBALS['strString'] = "Szöveg";
$GLOBALS['strTrackFollowingVars'] = "Kövesse az alábbi változót";
$GLOBALS['strAddVariable'] = "Változó hozzáadása";
$GLOBALS['strNoVarsToTrack'] = "Nincsenek változók követési kódban.";
$GLOBALS['strVariableRejectEmpty'] = "Az üres érték legyen elutasítva?";
$GLOBALS['strTrackingSettings'] = "Követőkód beállításai";
$GLOBALS['strTrackerType'] = "Követőkód típusa";
$GLOBALS['strTrackerTypeJS'] = "Track JavaScript variables";
$GLOBALS['strTrackerTypeDefault'] = "Track JavaScript variables (backwards compatible, escaping needed)";
$GLOBALS['strTrackerTypeDOM'] = "Track HTML elements using DOM";
$GLOBALS['strTrackerTypeCustom'] = "Egyedi JS kód";
$GLOBALS['strVariableCode'] = "Javascript tracking code";

// Password recovery
$GLOBALS['strForgotPassword'] = "Elfelejtette a jelszavát?";
$GLOBALS['strPasswordRecovery'] = "Password reset";
$GLOBALS['strEmailRequired'] = "Email is a required field";
$GLOBALS['strPwdRecWrongId'] = "Hibás ID";
$GLOBALS['strPwdRecEnterEmail'] = "Enter your email address below";
$GLOBALS['strPwdRecEnterPassword'] = "Enter your new password below";
$GLOBALS['strProceed'] = "Proceed >";
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
$GLOBALS['strTrackerVarsHaveBeenUpdated'] = "A változó a <a href='%s'>%s</a> követőkódhoz beállítva";
$GLOBALS['strTrackerCampaignsHaveBeenUpdated'] = "Linked campaigns of tracker <a href='%s'>%s</a> have been updated";
$GLOBALS['strTrackerAppendHasBeenUpdated'] = "A kiegészítő kód a <a href='%s'>%s</a> követőkódhoz beállítva";
$GLOBALS['strTrackerHasBeenDeleted'] = "Tracker <b>%s</b> has been deleted";
$GLOBALS['strTrackersHaveBeenDeleted'] = "All selected trackers have been deleted";
$GLOBALS['strTrackerHasBeenDuplicated'] = "Tracker <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strTrackerHasBeenMoved'] = "Tracker <b>%s</b> has been moved to advertiser <b>%s</b>";

$GLOBALS['strCampaignHasBeenAdded'] = "Campaign <a href='%s'>%s</a> has been added, <a href='%s'>add a banner</a>";
$GLOBALS['strCampaignHasBeenUpdated'] = "A <a href='%s'>%s</a> kampány frissítve lett";
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
$GLOBALS['strEmailChanged'] = "Az e-mail címed megváltozott";
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
$GLOBALS['keyNextItem'] = ",";
$GLOBALS['keyPreviousItem'] = ".";
$GLOBALS['keyList'] = "l";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch'] = "k";
$GLOBALS['keyCollapseAll'] = "c";
$GLOBALS['keyExpandAll'] = "k";
$GLOBALS['keyAddNew'] = "j";
$GLOBALS['keyNext'] = "j";
$GLOBALS['keyPrevious'] = "p";
$GLOBALS['keyLinkUser'] = "u";
$GLOBALS['keyWorkingAs'] = "w";
