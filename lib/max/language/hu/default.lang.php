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

$GLOBALS['phpAds_DecimalPoint'] = ",";
$GLOBALS['phpAds_ThousandsSeperator'] = ".";

// Date & time configuration
$GLOBALS['date_format'] = "%Y-%m-%d";
$GLOBALS['month_format'] = "%Y-%m";
$GLOBALS['day_format'] = "%m-%d";
$GLOBALS['week_format'] = "%Y-%W";

// Formats used by PEAR Spreadsheet_Excel_Writer packate

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "Kezdőlap";
$GLOBALS['strHelp'] = "Segítség";
$GLOBALS['strStartOver'] = "Újrakezdés";
$GLOBALS['strShortcuts'] = "Gyorsgombok";
$GLOBALS['strActions'] = "Műveletek";
$GLOBALS['strAdminstration'] = "Leltár";
$GLOBALS['strMaintenance'] = "Karbantartás";
$GLOBALS['strProbability'] = "Valószínűség";
$GLOBALS['strInvocationcode'] = "Beillesztő programkód";
$GLOBALS['strBasicInformation'] = "Alapinformáció";
$GLOBALS['strAppendTrackerCode'] = "Követő kód hozzáadása";
$GLOBALS['strOverview'] = "�?ttekintés";
$GLOBALS['strSearch'] = "Kere<u>s</u>és";
$GLOBALS['strDetails'] = "Részletek";
$GLOBALS['strCheckForUpdates'] = "Elérhető frissítések keresése";
$GLOBALS['strCompact'] = "Tömör";
$GLOBALS['strUser'] = "Felhasználó";
$GLOBALS['strDuplicate'] = "Duplikál";
$GLOBALS['strMoveTo'] = "Mozgat";
$GLOBALS['strDelete'] = "Töröl";
$GLOBALS['strActivate'] = "Aktivál";
$GLOBALS['strConvert'] = "Konvertál";
$GLOBALS['strRefresh'] = "Frissít";
$GLOBALS['strSaveChanges'] = "Változtatások mentése";
$GLOBALS['strUp'] = "Föl";
$GLOBALS['strDown'] = "Le";
$GLOBALS['strSave'] = "Mentés";
$GLOBALS['strCancel'] = "Mégse";
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
$GLOBALS['strAverage'] = "�?tlag";
$GLOBALS['strOverall'] = "Teljes";
$GLOBALS['strTotal'] = "Összesen";
$GLOBALS['strFrom'] = "Mettől";
$GLOBALS['strTo'] = "meddig";
$GLOBALS['strLinkedTo'] = "csatolva";
$GLOBALS['strDaysLeft'] = "Hátralévő napok";
$GLOBALS['strCheckAllNone'] = "Összes kijelölve/üres";
$GLOBALS['strExpandAll'] = "Össz<u>e</u>s kibontása";
$GLOBALS['strCollapseAll'] = "Összes be<u>c</u>sukása";
$GLOBALS['strShowAll'] = "Összes megjelenítése";
$GLOBALS['strNoAdminInterface'] = "Az adminisztrációs felület jelenleg karbantartás miatt nem elérhető. A kampányok kiszolgálását ez nem akadályozza.";
$GLOBALS['strFieldContainsErrors'] = "A következő mezők hibá(ka)t tartalmaznak:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Folytatás előtt szükséges";
$GLOBALS['strFieldFixBeforeContinue2'] = "javítani kell ezeket a hibákat.";
$GLOBALS['strMiscellaneous'] = "Vegyes";
$GLOBALS['strCollectedAllStats'] = "Minden statisztika";
$GLOBALS['strCollectedToday'] = "Ma";
$GLOBALS['strCollectedYesterday'] = "Tegnap";
$GLOBALS['strCollectedThisWeek'] = "Aktuális hét";
$GLOBALS['strCollectedLastWeek'] = "Előző hét";
$GLOBALS['strCollectedThisMonth'] = "Aktuális hónap";
$GLOBALS['strCollectedLastMonth'] = "Előző hónap";
$GLOBALS['strCollectedLast7Days'] = "Előző 7 nap";
$GLOBALS['strCollectedSpecificDates'] = "Egyedi dátumok";
$GLOBALS['strNotice'] = "Értesítés";

// Dashboard
// Dashboard Errors

// Priority
$GLOBALS['strPriority'] = "Prioritás";
$GLOBALS['strPriorityLevel'] = "Prioritási szint";
$GLOBALS['strLimitations'] = "Korlátozások";
$GLOBALS['strNoLimitations'] = "Nincsenek korlátozások";

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
$GLOBALS['strLinkUser'] = "Felhasználó hozzáadása";
$GLOBALS['strUsernameToLink'] = "Add meg a felhasználói nevet";
$GLOBALS['strNewUserWillBeCreated'] = "Új felhasználó lesz létrehozva";
$GLOBALS['strLinkUserHelpUser'] = "Felhasználónév";
$GLOBALS['strDateLinked'] = "Összekapcsolás ideje";

// Login & Permissions
$GLOBALS['strUserProperties'] = "Felhasználó tulajdonságai";
$GLOBALS['strPermissions'] = "Jogosultságok";
$GLOBALS['strAuthentification'] = "Hitelesítés";
$GLOBALS['strWelcomeTo'] = "Üdvözli az";
$GLOBALS['strEnterUsername'] = "Adja meg felhasználónevét és jelszavát";
$GLOBALS['strEnterBoth'] = "Felhasználói nevét és jelszavát is adja meg";
$GLOBALS['strLogin'] = "Login név (FTP felhasználó)";
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
$GLOBALS['strNotSamePasswords'] = "A két jelszó különbözik.";
$GLOBALS['strRepeatPassword'] = "Jelszó ismét";

// General advertising
$GLOBALS['strRequests'] = "Kérések";
$GLOBALS['strImpressions'] = "Megjelenés";
$GLOBALS['strClicks'] = "Kattintás";
$GLOBALS['strConversions'] = "Konverzió";
$GLOBALS['strCTRShort'] = "�?tkattintás";
$GLOBALS['strCTR'] = "Átkattintási arány";
$GLOBALS['strTotalClicks'] = "Összes kattintás";
$GLOBALS['strTotalConversions'] = "Összes konverzió";
$GLOBALS['strBanners'] = "Reklámok";
$GLOBALS['strCampaigns'] = "Kampány";
$GLOBALS['strCampaignID'] = "Kampány azonosító";
$GLOBALS['strCampaignName'] = "Kampány név";
$GLOBALS['strCountry'] = "Ország";
$GLOBALS['strStatsVariables'] = "Változók";

// Finance
$GLOBALS['strFinanceCTR'] = "�?tkattintás";

// Time and date related
$GLOBALS['strDate'] = "Dátum";
$GLOBALS['strDay'] = "Nap";
$GLOBALS['strDays'] = "Nap";
$GLOBALS['strWeek'] = "Hét";
$GLOBALS['strWeeks'] = "Hét";
$GLOBALS['strSingleMonth'] = "Hónap";
$GLOBALS['strMonths'] = "Hónap";
$GLOBALS['strDayOfWeek'] = "A hét napja";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = array();
}
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
$GLOBALS['strClientHistory'] = "Hirdető előzményei";
$GLOBALS['strConfirmDeleteClient'] = "Valóban törli ezt a hirdetőt?";
$GLOBALS['strHideInactive'] = "Inaktív elrejtése";
$GLOBALS['strInactiveAdvertisersHidden'] = "inaktív hirdető elrejtve";
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
$GLOBALS['strAllowCreateAccounts'] = "Engedélyezi, hogy ez a felhasználó új fiókokat hozzon létre";

// Campaign
$GLOBALS['strCampaign'] = "Kampány";
$GLOBALS['strCampaigns'] = "Kampányok";
$GLOBALS['strAddCampaign'] = "Új kampány";
$GLOBALS['strAddCampaign_Key'] = "Ú<u>j</u> kampány";
$GLOBALS['strCampaignProperties'] = "Kampány tulajdonságai";
$GLOBALS['strCampaignOverview'] = "Kampány áttekintése";
$GLOBALS['strCampaignHistory'] = "Kampány előzményei";
$GLOBALS['strNoCampaigns'] = "Jelenleg nincsenek kampányok";
$GLOBALS['strConfirmDeleteCampaign'] = "Valóban törli ezt a kampányt?";
$GLOBALS['strHideInactiveCampaigns'] = "Inaktív kampányok elrejtése";
$GLOBALS['strInactiveCampaignsHidden'] = "inaktív kampány elrejtve";
$GLOBALS['strHiddenCampaign'] = "Kampány";
$GLOBALS['strHiddenAdvertiser'] = "Hirdető";
$GLOBALS['strHiddenZone'] = "Nincs";

// Campaign-zone linking page


// Campaign properties
$GLOBALS['strDontExpire'] = "A kampány nem jár le a megadott napon";
$GLOBALS['strActivateNow'] = "A kampány azonnali aktiválása";
$GLOBALS['strLow'] = "Alacsony";
$GLOBALS['strHigh'] = "Magas";
$GLOBALS['strExpirationDate'] = "Lejárat dátuma";
$GLOBALS['strActivationDate'] = "Aktiválás dátuma";
$GLOBALS['strCampaignWeight'] = "A kampány fontossága";
$GLOBALS['strTargetPerDay'] = "naponta.";
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

// Tracker
$GLOBALS['strStatus'] = "Állapot";
$GLOBALS['strClick'] = "Kattintás";
$GLOBALS['strIPAddress'] = "IP cím";

// Banners (General)
$GLOBALS['strBanner'] = "Reklám";
$GLOBALS['strBanners'] = "Reklámok";
$GLOBALS['strAddBanner'] = "Új reklám";
$GLOBALS['strAddBanner_Key'] = "Ú<u>j</u> reklám";
$GLOBALS['strShowBanner'] = "Nézet";
$GLOBALS['strBannerProperties'] = "Reklám tulajdonságai";
$GLOBALS['strBannerHistory'] = "Reklám előzményei";
$GLOBALS['strNoBanners'] = "Jelenleg nincsenek reklámok";
$GLOBALS['strConfirmDeleteBanner'] = "Valóban törli ezt a reklámot?";
$GLOBALS['strShowParentCampaigns'] = "Szülő kampányok megjelenítése";
$GLOBALS['strHideParentCampaigns'] = "Szülő kampányok elrejtése";
$GLOBALS['strHideInactiveBanners'] = "Inaktív reklámok elrejtése";
$GLOBALS['strInactiveBannersHidden'] = "inaktív reklám elrejtve";

// Banner Preferences
$GLOBALS['strDefaultBannerDestination'] = "Alapértelmezett cél URL";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Válassza ki a reklámtípust";
$GLOBALS['strMySQLBanner'] = "Helyi reklám (SQL)";
$GLOBALS['strWebBanner'] = "Helyi reklám (Webkiszolgáló)";
$GLOBALS['strURLBanner'] = "Külső reklám";
$GLOBALS['strHTMLBanner'] = "HTML reklám";
$GLOBALS['strTextBanner'] = "Szöveges hirdetés";
$GLOBALS['strUploadOrKeep'] = "Megtartja a létező képet, <br>vagy tölt fel egy másikat?";
$GLOBALS['strNewBannerFile'] = "Válassza ki a reklámként <br>használni kívánt képet<br><br>";
$GLOBALS['strNewBannerURL'] = "Kép hivatkozása (tart. http://)";
$GLOBALS['strURL'] = "Cél hivatkozása (tart. http://)";
$GLOBALS['strKeyword'] = "Kulcsszó";
$GLOBALS['strTextBelow'] = "A kép alatti szöveg";
$GLOBALS['strWeight'] = "Magasság";
$GLOBALS['strAlt'] = "ALT szöveg";
$GLOBALS['strStatusText'] = "Szöveg az állapotsoron";
$GLOBALS['strBannerWeight'] = "Reklám fontossága";

// Banner (advanced)

// Banner (swf)
$GLOBALS['strCheckSWF'] = "Nehezen módosítható hivatkozások keresése a Flash fájlban";
$GLOBALS['strConvertSWFLinks'] = "Flash hivatkozások konvertálása";
$GLOBALS['strHardcodedLinks'] = "Nehezen módosítható hivatkozások";
$GLOBALS['strCompressSWF'] = "Az SWF fájl tömörítése a gyorsabb letöltés céljából (Flash 6 lejátszó szükséges)";
$GLOBALS['strOverwriteSource'] = "Forrás tulajdonságok felülírása";

// Display limitations
$GLOBALS['strModifyBannerAcl'] = "Továbbítás beállításai";
$GLOBALS['strACL'] = "Továbbítás";
$GLOBALS['strACLAdd'] = "Új korlátozás hozzáadása";
$GLOBALS['strApplyLimitationsTo'] = "Korlátozás alkalmazása a következőre";
$GLOBALS['strRemoveAllLimitations'] = "Minden korlátozás eltávolítása";
$GLOBALS['strEqualTo'] = "Egyenlő ezzel:";
$GLOBALS['strDifferentFrom'] = "Eltérő ettől:";
$GLOBALS['strContains'] = "Tartalmazza ezt:";
$GLOBALS['strNotContains'] = "Nem tartalmazza ezt:";
$GLOBALS['strGreaterThan'] = "Nagyobb mint:";
$GLOBALS['strLessThan'] = "Kisebb mint:";
$GLOBALS['strGreaterOrEqualTo'] = "Nagyobb vagy egyenlő mint:";
$GLOBALS['strLessOrEqualTo'] = "Kisebb vagy egyenlő mint:";
$GLOBALS['strAND'] = "ÉS";                          // logical operator
$GLOBALS['strOR'] = "VAGY";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "A reklám megjelenítése csak ekkor:";
$GLOBALS['strSource'] = "Forrás";
$GLOBALS['strDeliveryLimitations'] = "Továbbítás korlátozásai";


if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}

// Website
$GLOBALS['strAffiliate'] = "Kiadó";
$GLOBALS['strAffiliates'] = "Kiadók";
$GLOBALS['strAffiliatesAndZones'] = "Kiadók és zónák";
$GLOBALS['strAddNewAffiliate'] = "Új kiadó";
$GLOBALS['strAffiliateProperties'] = "Kiadó tulajdonságai";
$GLOBALS['strAffiliateHistory'] = "Kiadó előzményei";
$GLOBALS['strNoAffiliates'] = "Jelenleg nincsenek kiadók";
$GLOBALS['strConfirmDeleteAffiliate'] = "Valóban törli ezt a kiadót?";
$GLOBALS['strInactiveAffiliatesHidden'] = "inaktív weboldal elrejtve";
$GLOBALS['strShowParentAffiliates'] = "A szülő weboldalak mutatása";
$GLOBALS['strHideParentAffiliates'] = "A szülő weboldalak elrejtése";

// Website (properties)
$GLOBALS['strAllowAffiliateModifyZones'] = "A felhasználó módosíthatja a saját zónáit";
$GLOBALS['strAllowAffiliateLinkBanners'] = "A felhasználó kapcsolhat reklámokat a saját zónáihoz";
$GLOBALS['strAllowAffiliateAddZone'] = "A felhasználó adhat meg új zónákat";
$GLOBALS['strAllowAffiliateDeleteZone'] = "A felhasználó törölhet létező zónákat";

// Website (properties - payment information)
$GLOBALS['strCountry'] = "Ország";

// Website (properties - other information)

// Zone
$GLOBALS['strZone'] = "Nincs";
$GLOBALS['strZones'] = "Nincs";
$GLOBALS['strAddNewZone'] = "Új zóna";
$GLOBALS['strAddNewZone_Key'] = "Ú<u>j</u> zóna";
$GLOBALS['strLinkedZones'] = "Zónák kapcsolása";
$GLOBALS['strZoneProperties'] = "Zóna tulajdonságai";
$GLOBALS['strZoneHistory'] = "Zóna előzményei";
$GLOBALS['strNoZones'] = "Jelenleg nincsenek zónák";
$GLOBALS['strConfirmDeleteZone'] = "Valóban törölni akarja ezt a zónát?";
$GLOBALS['strZoneType'] = "Zóna típusa";
$GLOBALS['strBannerButtonRectangle'] = "Reklám, gomb vagy négyszög";
$GLOBALS['strInterstitial'] = "Interstíciós vagy lebegő DHTML";
$GLOBALS['strPopup'] = "Felbukkanó ablak";
$GLOBALS['strTextAdZone'] = "Szöveges hirdetés";
$GLOBALS['strShowMatchingBanners'] = "Egyező reklámok megjelenítése";
$GLOBALS['strHideMatchingBanners'] = "Egyező reklámok elrejtése";
$GLOBALS['strInactiveZonesHidden'] = "inaktív zóna elrejtve";


// Advanced zone settings
$GLOBALS['strAdvanced'] = "Speciális";
$GLOBALS['strChainSettings'] = "Lánc beállításai";
$GLOBALS['strZoneNoDelivery'] = "Ha nem továbbíthatók reklámok <br>ebból a zónából, akkor próbálja meg...";
$GLOBALS['strZoneStopDelivery'] = "A továbbítás leállítása, és nincs reklám megjelenítés";
$GLOBALS['strZoneOtherZone'] = "A kiválasztott zóna megjelenítése ehelyett";
$GLOBALS['strZoneAppend'] = "A következő HTML kód mindenkori hozzáfűzése a zóna által megjelenített reklámokhoz";
$GLOBALS['strAppendSettings'] = "Hozzáfűzés beállításai";
$GLOBALS['strZonePrependHTML'] = "A HTML-kód hozzáfűzése a zóna által megjelenített szöveges hirdetések előtt";
$GLOBALS['strZoneAppendHTMLCode'] = "HTML kód";
$GLOBALS['strZoneAppendZoneSelection'] = "Felbukkanó vagy interstíciós ablak";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "A kiválasztott zónához kapcsolt reklámok jelenleg nem aktívak. <br>Ez az a zónalánc, ami után következik:";
$GLOBALS['strZoneProbNullPri'] = "Jelenleg nem aktívak a zónához kapcsolt reklámok.";
$GLOBALS['strZoneProbListChainLoop'] = "A zónalánc követése ismétlődő ciklust okozhat. A zónához történő továbbítás leáll.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Válassza ki a kapcsolt reklámok típusát";
$GLOBALS['strRawQueryString'] = "Kulcsszó";
$GLOBALS['strIncludedBanners'] = "Reklámok kapcsolása";
$GLOBALS['strMatchingBanners'] = "{szám} egyező reklámok";
$GLOBALS['strNoCampaignsToLink'] = "Jelenleg nincsenek ehhez a zónához kapcsolt kampányok";
$GLOBALS['strNoZonesToLinkToCampaign'] = "Nincsenek ehhez a kampányhoz kapcsolható zónák";
$GLOBALS['strSelectBannerToLink'] = "Válassza ki a zónához kapcsolni kívánt reklámot:";
$GLOBALS['strSelectCampaignToLink'] = "Válassza ki a zónához kapcsolni kívánt kampányt:";
$GLOBALS['strStatusDuplicate'] = "Duplikál";
$GLOBALS['strConnectionType'] = "Típus";

// Statistics
$GLOBALS['strStats'] = "Statisztikák";
$GLOBALS['strNoStats'] = "Jelenleg nincs statisztika";
$GLOBALS['strGlobalHistory'] = "Globális előzmények";
$GLOBALS['strDailyHistory'] = "Napi előzmények";
$GLOBALS['strDailyStats'] = "Minden statisztika";
$GLOBALS['strWeeklyHistory'] = "Heti előzmények";
$GLOBALS['strMonthlyHistory'] = "Havi előzmények";
$GLOBALS['strTotalThisPeriod'] = "Időszak összes";
$GLOBALS['strBreakdownByDay'] = "Nap";
$GLOBALS['strBreakdownByWeek'] = "Hét";
$GLOBALS['strBreakdownByMonth'] = "Hónap";
$GLOBALS['strBreakdownByDow'] = "A hét napja";
$GLOBALS['strBreakdownByHour'] = "Óra";
$GLOBALS['strExportStatisticsToExcel'] = "Statisztikák <u>E</u>xportálása Excel-be";

// Expiration
$GLOBALS['strNoExpiration'] = "Nincs megadva a lejárat dátuma";
$GLOBALS['strEstimated'] = "Becsült lejárat";
$GLOBALS['strCampaignStop'] = "Kampány vége";

// Reports
$GLOBALS['strStartDate'] = "Kezdő dátum";
$GLOBALS['strEndDate'] = "Befejezés dátuma";
$GLOBALS['strLimitations'] = "Korlátozások";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "Összes hirdető";

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


// Errors
$GLOBALS['strNoMatchesFound'] = "Nincs találat";
$GLOBALS['strErrorOccurred'] = "Hiba történt";
$GLOBALS['strErrorDBPlain'] = "Hiba történt az adatbázishoz történő hozzáféréskor";
$GLOBALS['strErrorDBSerious'] = "Komoly probléma állapítható meg az adatbázissal kapcsolatban";
$GLOBALS['strErrorDBCorrupt'] = "Valószínűleg sérült az adatbázis tábla, ezért javításra szorul. A sérült táblákkal kapcsolatban további részleteket olvashat az <i>Administrator guide</i> <i>Troubleshooting</i> fejezetében.";
$GLOBALS['strErrorDBContact'] = "Vegye fel a kapcsolatot a kiszolgáló adminisztrátorával, és értesítse őt a problémáról.";

//Validation

// Email
$GLOBALS['strMailSubject'] = "Hirdetési jelentés";
$GLOBALS['strMailBannerStats'] = "Kérem, tekintse át az alábbiakban a {clientname} reklámstatisztikáját:";
$GLOBALS['strClientDeactivated'] = "A kampány jelenleg nem aktív, mert";
$GLOBALS['strBeforeActivate'] = "még nem érkezett el az aktiválás dátuma";
$GLOBALS['strAfterExpire'] = "már elérkezett a lejárat dátuma";
$GLOBALS['strNoMoreClicks'] = "már nincs több kattintás";
$GLOBALS['strWeightIsNull'] = "fontosságát nullára állította";
$GLOBALS['strNoViewLoggedInInterval'] = "Egy reklámletöltés sem került naplózásra a jelentés időtartama alatt";
$GLOBALS['strNoClickLoggedInInterval'] = "Egy kattintás sem került naplózásra a jelentés időtartama alatt";
$GLOBALS['strMailReportPeriod'] = "Ez a jelentés a {startdate} és {enddate} közti statisztikát tartalmazza.";
$GLOBALS['strMailReportPeriodAll'] = "Ez a jelentés a teljes statisztikát tartalmazza {enddate}-ig.";
$GLOBALS['strNoStatsForCampaign'] = "Nem áll rendelkezésre a kampány statisztikája";

// Priority
$GLOBALS['strPriority'] = "Prioritás";

// Preferences
$GLOBALS['strPreferences'] = "Preferenciák";
$GLOBALS['strAdminEmailWarnings'] = "Adminisztrátor e-mail címe";
$GLOBALS['strUserDetails'] = "Felhasználói adatok";

// Long names
$GLOBALS['strImpressionSR'] = "Megjelenés";

// Short names
$GLOBALS['strID_short'] = "Azonosító";
$GLOBALS['strClicks_short'] = "Kattintás";
$GLOBALS['strCTR_short'] = "�?tkattintás";

// Global Settings
$GLOBALS['strGlobalSettings'] = "Globális beállítások";
$GLOBALS['strGeneralSettings'] = "Általános beállítások";
$GLOBALS['strMainSettings'] = "Alapbeállítások";

// Product Updates
$GLOBALS['strProductUpdates'] = "Termékfrissítés";

// Agency
$GLOBALS['strHideInactiveAgencies'] = "Inaktív fiókok elrejtése";
$GLOBALS['strInactiveAgenciesHidden'] = "inaktív fiók elrejtve";

// Channels
$GLOBALS['strChannel'] = "Célzási csatorna";
$GLOBALS['strChannels'] = "Célzási csatornák";
$GLOBALS['strChannelManagement'] = "Célzási csatorna kezelése";
$GLOBALS['strAddNewChannel'] = "Célzási csatorna hozzáadása";
$GLOBALS['strAddNewChannel_Key'] = "Célzási <u>c</u>satorna hozzáadása";
$GLOBALS['strEditChannelLimitations'] = "Célzási csatorna korlátozásainak szerkesztése";
$GLOBALS['strChannelProperties'] = "Célzási csatorna tulajdonságai";
$GLOBALS['strChannelLimitations'] = "Továbbítás beállításai";
$GLOBALS['strConfirmDeleteChannel'] = "Valóban törli ezt célzási csatornát?";

// Tracker Variables
$GLOBALS['strVariableDescription'] = "Leírás";

// Password recovery

// Audit

// Widget - Audit

// Widget - Campaign



//confirmation messages










// Report error messages

/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyNextItem'] = ",";
$GLOBALS['keyPreviousItem'] = ".";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch'] = "k";
$GLOBALS['keyExpandAll'] = "k";
$GLOBALS['keyAddNew'] = "j";
$GLOBALS['keyNext'] = "j";
