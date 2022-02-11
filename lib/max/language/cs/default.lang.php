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
$GLOBALS['phpAds_ThousandsSeperator'] = " ";

// Date & time configuration
$GLOBALS['date_format'] = "%d.%m.%Y";
$GLOBALS['month_format'] = "%m.%Y";
$GLOBALS['day_format'] = "%d.%m";
$GLOBALS['week_format'] = "%W.%Y";
$GLOBALS['weekiso_format'] = "%V.%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "Domů";
$GLOBALS['strHelp'] = "Nápověda";
$GLOBALS['strStartOver'] = "Začít znovu";
$GLOBALS['strShortcuts'] = "Zkratka";
$GLOBALS['strActions'] = "Akce";
$GLOBALS['strAndXMore'] = "a %s více";
$GLOBALS['strAdminstration'] = "Inventář";
$GLOBALS['strMaintenance'] = "Správa";
$GLOBALS['strProbability'] = "Pravděpodobnost";
$GLOBALS['strInvocationcode'] = "Zobrazovací kód";
$GLOBALS['strBasicInformation'] = "Základní údaje";
$GLOBALS['strAppendTrackerCode'] = "Přidat Tracker kód";
$GLOBALS['strOverview'] = "Přehled";
$GLOBALS['strSearch'] = "<u>V</u>yhledávání";
$GLOBALS['strDetails'] = "Detaily";
$GLOBALS['strUpdateSettings'] = "Aktualizace nastavení";
$GLOBALS['strCheckForUpdates'] = "Kontrolovat aktualizace";
$GLOBALS['strWhenCheckingForUpdates'] = "Při kontrole aktualizací";
$GLOBALS['strCompact'] = "Kompaktní";
$GLOBALS['strUser'] = "Uživatel";
$GLOBALS['strDuplicate'] = "Duplikovat";
$GLOBALS['strCopyOf'] = "Kopírovat z";
$GLOBALS['strMoveTo'] = "Přesunout";
$GLOBALS['strDelete'] = "Smazat";
$GLOBALS['strActivate'] = "Aktivovat";
$GLOBALS['strConvert'] = "Konvertovat";
$GLOBALS['strRefresh'] = "Obnovit";
$GLOBALS['strSaveChanges'] = "Uložit změny";
$GLOBALS['strUp'] = "Nahoru";
$GLOBALS['strDown'] = "Dolů";
$GLOBALS['strSave'] = "Uložit";
$GLOBALS['strCancel'] = "Zrušit";
$GLOBALS['strBack'] = "Zpět";
$GLOBALS['strPrevious'] = "Předchozí";
$GLOBALS['strNext'] = "Následující";
$GLOBALS['strYes'] = "Ano";
$GLOBALS['strNo'] = "Ne";
$GLOBALS['strNone'] = "Žádné";
$GLOBALS['strCustom'] = "Vlastní";
$GLOBALS['strDefault'] = "Implicitní";
$GLOBALS['strUnknown'] = "Neznámé";
$GLOBALS['strUnlimited'] = "Neomezené";
$GLOBALS['strUntitled'] = "Bezejména";
$GLOBALS['strAll'] = "všechny";
$GLOBALS['strAverage'] = "Průměr";
$GLOBALS['strOverall'] = "Celkový přehled";
$GLOBALS['strTotal'] = "Celkem";
$GLOBALS['strFrom'] = "Od";
$GLOBALS['strTo'] = "do";
$GLOBALS['strAdd'] = "Přidat";
$GLOBALS['strLinkedTo'] = "připojení k";
$GLOBALS['strDaysLeft'] = "Zbývá dnů";
$GLOBALS['strCheckAllNone'] = "Označit vše / nic";
$GLOBALS['strKiloByte'] = "KB";
$GLOBALS['strExpandAll'] = "<u>R</u>ozšířit vše";
$GLOBALS['strCollapseAll'] = "<u>S</u>loučit vše";
$GLOBALS['strShowAll'] = "Ukázat vše";
$GLOBALS['strNoAdminInterface'] = "Služba není dostupná...";
$GLOBALS['strFieldStartDateBeforeEnd'] = "'Z' data musí být dříve, než 'Do' data";
$GLOBALS['strFieldContainsErrors'] = "Následující položky obsahují chyby:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Než budete moci pokračovat potřebujete";
$GLOBALS['strFieldFixBeforeContinue2'] = "opravit tyto chyby.";
$GLOBALS['strMiscellaneous'] = "Různé";
$GLOBALS['strCollectedAllStats'] = "Všechny statistiky";
$GLOBALS['strCollectedToday'] = "Dnes";
$GLOBALS['strCollectedYesterday'] = "Včera";
$GLOBALS['strCollectedThisWeek'] = "Tento týden (Po-Ne)";
$GLOBALS['strCollectedLastWeek'] = "Minulý týden (Po-Ne)";
$GLOBALS['strCollectedThisMonth'] = "Tento měsíc";
$GLOBALS['strCollectedLastMonth'] = "Minulý měsíc";
$GLOBALS['strCollectedLast7Days'] = "Posledních 7 dní";
$GLOBALS['strCollectedSpecificDates'] = "Konkrétní data";
$GLOBALS['strValue'] = "Hodnota";
$GLOBALS['strWarning'] = "Varování";
$GLOBALS['strNotice'] = "Oznámení";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "Řídicí panel nelze zobrazit";
$GLOBALS['strNoCheckForUpdates'] = "Přístrojovou desku nelze zobrazit, pokud je povolena kontrola<br />pro nastavení aktualizace.";
$GLOBALS['strEnableCheckForUpdates'] = "Prosím povolte položku <a href='account-settings-update.php' target='_top'> Zkontrolovat aktualizace</a> na stránce<br/> <a href='account-settings-update.php' target='_top'> aktualizovat nastavení</a>.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "kód";
$GLOBALS['strDashboardSystemMessage'] = "Systémová zpráva";
$GLOBALS['strDashboardErrorHelp'] = "Pokud tato chyba přetrvává popište váš problém podrobně a uveřejněte na <a href='http://forum.revive-adserver.com/'> forum.revive-adserver.com/</a>.";

// Priority
$GLOBALS['strPriority'] = "Priorita";
$GLOBALS['strPriorityLevel'] = "Úroveň priority";
$GLOBALS['strOverrideAds'] = "Přepsat reklamní kampaň";
$GLOBALS['strHighAds'] = "Smlouva reklamní kampaně";
$GLOBALS['strECPMAds'] = "eCPM reklamní kampaň";
$GLOBALS['strLowAds'] = "Reklamy s nízkou prioritou";
$GLOBALS['strCapping'] = "Omezení";

// Properties
$GLOBALS['strName'] = "Jméno";
$GLOBALS['strSize'] = "Velikost";
$GLOBALS['strWidth'] = "Šířka";
$GLOBALS['strHeight'] = "Výška";
$GLOBALS['strTarget'] = "Cíl";
$GLOBALS['strLanguage'] = "Jazyk";
$GLOBALS['strDescription'] = "Popis";
$GLOBALS['strVariables'] = "Proměnné";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "Komentáře";

// User access
$GLOBALS['strWorkingAs'] = "Pracovat jako";
$GLOBALS['strWorkingAs_Key'] = "<u>P</u>racovat jako";
$GLOBALS['strWorkingAs'] = "Pracovat jako";
$GLOBALS['strSwitchTo'] = "Přepnout do";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "Pomocí přepínače pole pro vyhledávání najdete více účtů";
$GLOBALS['strWorkingFor'] = "%s pro...";
$GLOBALS['strNoAccountWithXInNameFound'] = "Žádné účty s \"%s\" ve jménu nalezen";
$GLOBALS['strRecentlyUsed'] = "Naposledy použitých";
$GLOBALS['strLinkUser'] = "Přidat uživatele";
$GLOBALS['strLinkUser_Key'] = "Přidat <u>u</u>živatele";
$GLOBALS['strUsernameToLink'] = "Přidat uživatelské jméno uživatele";
$GLOBALS['strNewUserWillBeCreated'] = "Bude vytvořen nový uživatel";
$GLOBALS['strToLinkProvideEmail'] = "Chcete-li přidat uživatele, zadejte jeho e-mail";
$GLOBALS['strToLinkProvideUsername'] = "Chcete-li přidat uživatele, zadejte jeho uživatelské jméno";
$GLOBALS['strUserAccountUpdated'] = "Uživatelský účet aktualizován";
$GLOBALS['strUserWasDeleted'] = "Uživatel byl odstraněn";
$GLOBALS['strUserNotLinkedWithAccount'] = "Takový uživatel není propojen s účtem";
$GLOBALS['strLinkUserHelp'] = "Chcete-li přidat <b>existující uživatele</b>, zadejte %1\$s a klepněte na tlačítko %2\$s < br / > přidat <b>nového uživatele</b>, zadejte požadovanou %1\$s a klepněte na %2\$s";
$GLOBALS['strLinkUserHelpUser'] = "Jméno";
$GLOBALS['strLinkUserHelpEmail'] = "e-mailová adresa";
$GLOBALS['strLastLoggedIn'] = "Poslední přihlášení";

// Login & Permissions
$GLOBALS['strUserAccess'] = "Uživatelský přístup";
$GLOBALS['strAdminAccess'] = "Přístup správce";
$GLOBALS['strUserProperties'] = "Nastavení banneru";
$GLOBALS['strPermissions'] = "Oprávnění";
$GLOBALS['strAuthentification'] = "Autentifikace";
$GLOBALS['strWelcomeTo'] = "Vítejte do";
$GLOBALS['strEnterUsername'] = "Pro přihlásení zadejte vaše uživatelské jméno a heslo";
$GLOBALS['strEnterBoth'] = "Prosím zadejte vaše jméno i heslo";
$GLOBALS['strEnableCookies'] = "Je třeba povolit soubory cookie, než budete moci použít {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "Chyba relace cookie, přihlaste se znovu";
$GLOBALS['strLogin'] = "Přihlásit";
$GLOBALS['strLogout'] = "Odhlásit";
$GLOBALS['strUsername'] = "Jméno";
$GLOBALS['strPassword'] = "Heslo";
$GLOBALS['strPasswordRepeat'] = "Zopakujte heslo";
$GLOBALS['strAccessDenied'] = "Přístup odepřen";
$GLOBALS['strUsernameOrPasswordWrong'] = "Uživatelské jméno nebo heslo nejsou správné. Opakujte akci.";
$GLOBALS['strPasswordWrong'] = "Toto není správné heslo";
$GLOBALS['strNotAdmin'] = "Zřejmě nemáte dostatečné oprávnění";
$GLOBALS['strDuplicateClientName'] = "Zadané uživatelské jméno již existuje. Prosím zadejte jiné jméno.";
$GLOBALS['strInvalidPassword'] = "Zadané heslo je špatné. Prosím zadejte jiné heslo.";
$GLOBALS['strInvalidEmail'] = "E-mail nemá správný formát, prosím vložte správnou e-mailovou adresu.";
$GLOBALS['strNotSamePasswords'] = "Dvě hesla která jste zadal nejsou stejná.";
$GLOBALS['strRepeatPassword'] = "Zopakujte heslo";
$GLOBALS['strDeadLink'] = "Váš odkaz je neplatný.";
$GLOBALS['strNoPlacement'] = "Výbraná kampaň neexistuje. Místo toho zkuste tento <a href='{link}'>odkaz</a>";
$GLOBALS['strNoAdvertiser'] = "Vybraný inzerent neexistuje. Místo toho zkuste tento <a href='{link}'> odkaz</a>";

// General advertising
$GLOBALS['strRequests'] = "Požadavky";
$GLOBALS['strImpressions'] = "Zobrazení";
$GLOBALS['strClicks'] = "Kliknutí";
$GLOBALS['strConversions'] = "Prodeje";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "Celkem kliknutí";
$GLOBALS['strTotalConversions'] = "Celkem prodejů";
$GLOBALS['strDateTime'] = "Datum, Čas";
$GLOBALS['strTrackerID'] = "Sledování ID";
$GLOBALS['strTrackerName'] = "Název sledování";
$GLOBALS['strTrackerImageTag'] = "Tag obrázku";
$GLOBALS['strTrackerJsTag'] = "JavaScript Tag";
$GLOBALS['strTrackerAlwaysAppend'] = "Vždy zobrazit připojených kód, i v případě, že žádná konverze není zaznamenána trackerem?";
$GLOBALS['strBanners'] = "Bannery";
$GLOBALS['strCampaigns'] = "Kampaně";
$GLOBALS['strCampaignID'] = "ID kampaně";
$GLOBALS['strCampaignName'] = "Historie kampaně";
$GLOBALS['strCountry'] = "Země";
$GLOBALS['strStatsAction'] = "Akce";
$GLOBALS['strWindowDelay'] = "Zpoždění okna";
$GLOBALS['strStatsVariables'] = "Proměnné";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Nájem";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strFinanceCR'] = "CR";

// Time and date related
$GLOBALS['strDate'] = "Datum";
$GLOBALS['strDay'] = "Den";
$GLOBALS['strDays'] = "Dní";
$GLOBALS['strWeek'] = "Týden";
$GLOBALS['strWeeks'] = "Týdnů";
$GLOBALS['strSingleMonth'] = "Měsíců";
$GLOBALS['strMonths'] = "Měsíců";
$GLOBALS['strDayOfWeek'] = "Den v týdnu";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = [];
}
$GLOBALS['strDayFullNames'][0] = 'Neděle';
$GLOBALS['strDayFullNames'][1] = 'Pondělí';
$GLOBALS['strDayFullNames'][2] = 'Úterý';
$GLOBALS['strDayFullNames'][3] = 'Středa';
$GLOBALS['strDayFullNames'][4] = 'Čtvrtek';
$GLOBALS['strDayFullNames'][5] = 'Pátek';
$GLOBALS['strDayFullNames'][6] = 'Sobota';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = [];
}
$GLOBALS['strDayShortCuts'][0] = 'Ne';
$GLOBALS['strDayShortCuts'][1] = 'Po';
$GLOBALS['strDayShortCuts'][2] = 'Út';
$GLOBALS['strDayShortCuts'][3] = 'St';
$GLOBALS['strDayShortCuts'][4] = 'Čt';
$GLOBALS['strDayShortCuts'][5] = 'Pá';
$GLOBALS['strDayShortCuts'][6] = 'So';

$GLOBALS['strHour'] = "Hodina";
$GLOBALS['strSeconds'] = "vteřin";
$GLOBALS['strMinutes'] = "minut";
$GLOBALS['strHours'] = "hodin";

// Advertiser
$GLOBALS['strClient'] = "Inzerent";
$GLOBALS['strClients'] = "Inzerenti";
$GLOBALS['strClientsAndCampaigns'] = "Inzerenti & Kampaně";
$GLOBALS['strAddClient'] = "Přidat inzerenta";
$GLOBALS['strClientProperties'] = "Nastavení inzerenta";
$GLOBALS['strNoClients'] = "Zatím nejsou definováni žádní inzerenti. Pro vytvoření kampaně, nejprve <a href='advertiser-edit.php'>přidejte nového inzerenta</a>.";
$GLOBALS['strConfirmDeleteClient'] = "Opravdu chcete smazat tohoto inzerenta?";
$GLOBALS['strConfirmDeleteClients'] = "Opravdu chcete smazat tohoto inzerenta?";
$GLOBALS['strHideInactive'] = "Skrýt neaktivní";
$GLOBALS['strInactiveAdvertisersHidden'] = "nekativních inzerent(ů) skryto";
$GLOBALS['strAdvertiserSignup'] = "Inzerent přihlásit se";
$GLOBALS['strAdvertiserCampaigns'] = "Inzerenti & Kampaně";

// Advertisers properties
$GLOBALS['strContact'] = "Kontakt";
$GLOBALS['strContactName'] = "Jméno kontaktu";
$GLOBALS['strEMail'] = "E-mail";
$GLOBALS['strSendAdvertisingReport'] = "Zaslat přehled inzerce e-mailem";
$GLOBALS['strNoDaysBetweenReports'] = "Počet dní mezi přehledy";
$GLOBALS['strSendDeactivationWarning'] = "Zaslat upozornění při deaktivaci kampaně";
$GLOBALS['strAllowClientModifyBanner'] = "Povolit uživateli měnit vlastní bannery";
$GLOBALS['strAllowClientDisableBanner'] = "Povolit uživateli deaktivovat vlastní bannery";
$GLOBALS['strAllowClientActivateBanner'] = "Povolit uživateli aktivovat vlastní bannery";
$GLOBALS['strAdvertiserLimitation'] = "Na webové stránce zobrazit pouze jeden banner od tohoto inzerenta";
$GLOBALS['strAllowAuditTrailAccess'] = "Povolit tomuto uživateli přístup auditu";

// Campaign
$GLOBALS['strCampaign'] = "Kampaň";
$GLOBALS['strCampaigns'] = "Kampaně";
$GLOBALS['strAddCampaign'] = "Přidat kampaň";
$GLOBALS['strAddCampaign_Key'] = "Přidat <u>k</u>ampaň";
$GLOBALS['strCampaignForAdvertiser'] = "pro inzerenta";
$GLOBALS['strLinkedCampaigns'] = "Připojené kampaně";
$GLOBALS['strCampaignProperties'] = "Nastavení kampaně";
$GLOBALS['strCampaignOverview'] = "Přehled kampaně";
$GLOBALS['strNoCampaigns'] = "V tuto chvíli nejsou definované žádné kampaně";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "Momentálně zde nejsou žádné kampaně definované, protože zde nejsou žádní inzerenti. Chcete-li vytvořit kampaň, musíte nejdříve <a href='advertiser-edit.php'>přidat nového inzerenta </a>.";
$GLOBALS['strConfirmDeleteCampaign'] = "Opravdu chcete smazat tuto kampaň?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Opravdu chcete smazat tuto kampaň?";
$GLOBALS['strHideInactiveCampaigns'] = "Skrýt neaktivní kampaně";
$GLOBALS['strInactiveCampaignsHidden'] = "neaktivních kampaní skryto";
$GLOBALS['strPriorityInformation'] = "Informace o prioritě";
$GLOBALS['strHiddenCampaign'] = "Kampaň";
$GLOBALS['strHiddenAdvertiser'] = "Inzerent";
$GLOBALS['strHiddenTracker'] = "Sledovač";
$GLOBALS['strHiddenWebsite'] = "Webová stránka";
$GLOBALS['strHiddenZone'] = "Zóna";
$GLOBALS['strCampaignDelivery'] = "Doručování kampaně";
$GLOBALS['strSelectUnselectAll'] = "Vybrat / zrušit výběr všech";

// Campaign-zone linking page
$GLOBALS['strZonesSearch'] = "Hledání";
$GLOBALS['strAvailable'] = "Dostupný";
$GLOBALS['strShowing'] = "Zobrazuji";
$GLOBALS['strEditZone'] = "Upravit zónu";
$GLOBALS['strEditWebsite'] = "Editovat stránku";


// Campaign properties
$GLOBALS['strDontExpire'] = "Tato kampaň nikdy automaticky neexpiruje";
$GLOBALS['strActivateNow'] = "Okamžitě aktivovat tuto kampaň";
$GLOBALS['strSetSpecificDate'] = "Nastavit konkrétní datum";
$GLOBALS['strLow'] = "Nízká";
$GLOBALS['strHigh'] = "Vysoká";
$GLOBALS['strExpirationDate'] = "Koncové datum";
$GLOBALS['strExpirationDateComment'] = "Kampaň skončí na konci tohoto dne";
$GLOBALS['strActivationDate'] = "Počáteční datum";
$GLOBALS['strActivationDateComment'] = "Kampaň začne na začatku tohoto dne";
$GLOBALS['strCampaignWeight'] = "Váha kampaně";
$GLOBALS['strAnonymous'] = "Skrýt inzerenta a vydavatele této kampaně.";
$GLOBALS['strTargetPerDay'] = "za den.";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "Priorita této kampaně byla nastavena na nízkou,
ale váha byla nastavena na nulu nebo nebyla
zadána. Takto bude kampaň okamžitě
deaktivována a její bannery nebudou doručeny
dokud její váha nebude nastavena na platné číslo.

Jste si jist že chcete pokračovat?";
$GLOBALS['strCampaignWarningNoTarget'] = "Priorita této kampaně byla nastavena na vysokou,
ale cílový počet AdViews nebyl zadán.
Takto bude kampaň okamžitě deaktivována a
její bannery nebudou doručeny dokdu nebude
nastaven platný počet AdViews.

Jste si jist že chcete pokračovat?";
$GLOBALS['strCampaignStatusPending'] = "Čekající";
$GLOBALS['strCampaignStatusInactive'] = "aktivní";
$GLOBALS['strCampaignStatusRunning'] = "Probíhající";
$GLOBALS['strCampaignStatusPaused'] = "Pozastaveno";
$GLOBALS['strCampaignStatusAwaiting'] = "Čekající";
$GLOBALS['strCampaignStatusExpired'] = "Kompletní";
$GLOBALS['strCampaignStatusApproval'] = "Čeká na schválení »";
$GLOBALS['strCampaignStatusRejected'] = "Odmítnuto";
$GLOBALS['strCampaignStatusAdded'] = "Přidáno";
$GLOBALS['strCampaignStatusStarted'] = "Spuštěno";
$GLOBALS['strCampaignStatusRestarted'] = "Restartován";
$GLOBALS['strCampaignStatusDeleted'] = "Smazat";
$GLOBALS['strCampaignType'] = "Historie kampaně";
$GLOBALS['strType'] = "Typ";
$GLOBALS['strContract'] = "Kontakt";
$GLOBALS['strOverride'] = "Přepsat";
$GLOBALS['strStandardContract'] = "Kontakt";
$GLOBALS['strRemnant'] = "Zbytek";
$GLOBALS['strECPMInfo'] = "Jedná se o standardní kampaň, která může být omezena buď s datumem ukončení nebo konkrétním omezení. Na základě aktuálního nastavení bude mít prioritu pomocí eCPM.";
$GLOBALS['strPricing'] = "Stanovení ceny";
$GLOBALS['strPricingModel'] = "Cenový model";
$GLOBALS['strSelectPricingModel'] = "--Vyberte model –";
$GLOBALS['strRatePrice'] = "Sazba / cena";
$GLOBALS['strMinimumImpressions'] = "Minimální denní zobrazení";
$GLOBALS['strLimit'] = "Limit";
$GLOBALS['strWhyDisabled'] = "proč je to zakázáno?";
$GLOBALS['strBackToCampaigns'] = "Zpět do kampaně";
$GLOBALS['strCampaignBanners'] = "Bannery kampaně";
$GLOBALS['strCookies'] = "Cookies";

// Tracker
$GLOBALS['strTracker'] = "Sledovač";
$GLOBALS['strTrackers'] = "Sledovač";
$GLOBALS['strTrackerPreferences'] = "Předvoleby Trackeru";
$GLOBALS['strAddTracker'] = "Přidat nový sledovač";
$GLOBALS['strTrackerForAdvertiser'] = "pro inzerenta";
$GLOBALS['strNoTrackers'] = "V tuto chvíli nejsou definovány ádné sledovače";
$GLOBALS['strConfirmDeleteTrackers'] = "Opravdu chcete smazat tento sledovač?";
$GLOBALS['strConfirmDeleteTracker'] = "Opravdu chcete smazat tento sledovač?";
$GLOBALS['strTrackerProperties'] = "Vlastnosti sledovače";
$GLOBALS['strDefaultStatus'] = "Výchozí stav";
$GLOBALS['strStatus'] = "Stav";
$GLOBALS['strLinkedTrackers'] = "Připojené sledovače";
$GLOBALS['strConversionWindow'] = "Okno převodu";
$GLOBALS['strUniqueWindow'] = "Jedinečné okno";
$GLOBALS['strClick'] = "Klik";
$GLOBALS['strView'] = "Zobrazení";
$GLOBALS['strArrival'] = "Příjezd";
$GLOBALS['strManual'] = "Manuál";
$GLOBALS['strImpression'] = "Zobrazení";
$GLOBALS['strConversionType'] = "Typ konverze";
$GLOBALS['strBackToTrackers'] = "Zpět na trackery";
$GLOBALS['strIPAddress'] = "IP adresa";

// Banners (General)
$GLOBALS['strBanner'] = "Banner";
$GLOBALS['strBanners'] = "Bannery";
$GLOBALS['strAddBanner'] = "Přidat banner";
$GLOBALS['strAddBanner_Key'] = "Přidat <u>b</u>anner";
$GLOBALS['strBannerToCampaign'] = "na kampaň";
$GLOBALS['strShowBanner'] = "Zobrazit banner";
$GLOBALS['strBannerProperties'] = "Nastavení banneru";
$GLOBALS['strNoBanners'] = "Zatím nejsou definovány žádné bannery";
$GLOBALS['strConfirmDeleteBanner'] = "Opravdu chcete smazat tento banner?";
$GLOBALS['strConfirmDeleteBanners'] = "Opravdu chcete smazat tento banner?";
$GLOBALS['strShowParentCampaigns'] = "Zobrazit nadřazené kampaně";
$GLOBALS['strHideParentCampaigns'] = "Skrýt nadřazené kampaně";
$GLOBALS['strHideInactiveBanners'] = "Skrýt neaktivní bannery";
$GLOBALS['strInactiveBannersHidden'] = "neaktivních bannerů skryto";
$GLOBALS['strWarningMissing'] = "Pozor, možná chybí ";
$GLOBALS['strWarningMissingClosing'] = " uzavírací tag '>'";
$GLOBALS['strWarningMissingOpening'] = " otevírací tag '<'";
$GLOBALS['strSubmitAnyway'] = "Přesto odeslat";
$GLOBALS['strBannersOfCampaign'] = "v"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "Předvolby Banneru";
$GLOBALS['strCampaignPreferences'] = "Nastavení kampaně";
$GLOBALS['strDefaultBanners'] = "Výchozí Bannery";
$GLOBALS['strDefaultBannerUrl'] = "Výchozí adresa URL obrázku";
$GLOBALS['strDefaultBannerDestination'] = "Výchozí cílová adresa URL";
$GLOBALS['strAllowedBannerTypes'] = "Povolené typy Banneru";
$GLOBALS['strTypeSqlAllow'] = "Povolit SQL lokální Bannery";
$GLOBALS['strTypeWebAllow'] = "Povolit Webserver lokální Bannery";
$GLOBALS['strTypeUrlAllow'] = "Povolit externí Bannery";
$GLOBALS['strTypeHtmlAllow'] = "Povolit HTML Bannery";
$GLOBALS['strTypeTxtAllow'] = "Povolit textové reklamy";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Prosím vyberte typ banneru";
$GLOBALS['strMySQLBanner'] = "Lokální banner (SQL)";
$GLOBALS['strWebBanner'] = "Lokální banner (Webserver)";
$GLOBALS['strURLBanner'] = "Externí banner";
$GLOBALS['strHTMLBanner'] = "HTML banner";
$GLOBALS['strTextBanner'] = "Textová reklama";
$GLOBALS['strUploadOrKeep'] = "Přejete se zachovat <br>současný obrázek, nebo <br>chcete nahrát jiný?";
$GLOBALS['strNewBannerFile'] = "Zvolte obrázek, který <br>chcete použít pro tento banner<br><br>";
$GLOBALS['strNewBannerFileAlt'] = "Vyberte alternativní obrázek, který <br>chcete použít pro prohlížeče,<br>které nepodporují rich-media<br><br>";
$GLOBALS['strNewBannerURL'] = "URL obrázku (včetně http://)";
$GLOBALS['strURL'] = "Cílová URL (incl. http://)";
$GLOBALS['strKeyword'] = "Klíčová slova";
$GLOBALS['strTextBelow'] = "Text pod obrázkem";
$GLOBALS['strWeight'] = "Váha";
$GLOBALS['strAlt'] = "Alt text";
$GLOBALS['strStatusText'] = "Stavový text";
$GLOBALS['strBannerWeight'] = "Váha banneru";
$GLOBALS['strAdserverTypeGeneric'] = "Generický HTML Banner";
$GLOBALS['strDoNotAlterHtml'] = "Neměňte HTML";
$GLOBALS['strBackToBanners'] = "Zpět na bannery";

// Banner (advanced)

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "Nastavení doručování";
$GLOBALS['strACL'] = "Nastavení doručování";
$GLOBALS['strAllBannersInCampaign'] = "Všechny bannery v této kampani";
$GLOBALS['strEqualTo'] = "je rovno";
$GLOBALS['strDifferentFrom'] = "liší se od";
$GLOBALS['strLaterThan'] = "je později než";
$GLOBALS['strLaterThanOrEqual'] = "je později nebo rovno";
$GLOBALS['strEarlierThan'] = "je dříve než";
$GLOBALS['strEarlierThanOrEqual'] = "je dříve nebo rovno";
$GLOBALS['strContains'] = "obsahuje";
$GLOBALS['strNotContains'] = "neobsahuje";
$GLOBALS['strGreaterThan'] = "je později než";
$GLOBALS['strLessThan'] = "je menší než";
$GLOBALS['strAND'] = "A";                          // logical operator
$GLOBALS['strOR'] = "NEBO";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Zobrazit tento banner pouze:";
$GLOBALS['strWeekDays'] = "V pracovní den";
$GLOBALS['strTime'] = "Čas";
$GLOBALS['strDomain'] = "Doména";
$GLOBALS['strSource'] = "Zdroj";
$GLOBALS['strBrowser'] = "Prohlížeč";
$GLOBALS['strOS'] = "OS";

$GLOBALS['strDeliveryCappingReset'] = "Obnovit počítadlo zobrazení po:";
$GLOBALS['strDeliveryCappingTotal'] = "celkem";
$GLOBALS['strDeliveryCappingSession'] = "za relaci";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = [];
}

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = [];
}
$GLOBALS['strCappingCampaign']['limit'] = "Omezit zobrazení kampaně na:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = [];
}
$GLOBALS['strCappingZone']['limit'] = "Omezit zobrazení zóny na:";

// Website
$GLOBALS['strAffiliate'] = "Webová stránka";
$GLOBALS['strAffiliates'] = "Vydavatelé";
$GLOBALS['strAffiliatesAndZones'] = "Vydavatelé & Zóny";
$GLOBALS['strAddNewAffiliate'] = "Přidat vydavatele";
$GLOBALS['strAffiliateProperties'] = "Nastavení vydavatele";
$GLOBALS['strNoAffiliates'] = "V tuto chvíli nejsou zadáni žádní vydavatelé";
$GLOBALS['strConfirmDeleteAffiliate'] = "Opravdu si přejete smazat tohoto vydavatele?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Opravdu si přejete smazat tohoto vydavatele?";
$GLOBALS['strInactiveAffiliatesHidden'] = "neaktivních bannerů skryto";
$GLOBALS['strShowParentAffiliates'] = "Zobrazit nadřazené weby";
$GLOBALS['strHideParentAffiliates'] = "Skrytí nadřazených webů";

// Website (properties)
$GLOBALS['strWebsite'] = "Webová stránka";
$GLOBALS['strWebsiteURL'] = "URL webové stránky";
$GLOBALS['strAllowAffiliateModifyZones'] = "Povolit tomuto uživateli měnit vlastní zóny";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Povolit tomuto uživateli připojovat vlastní bannery k zónám";
$GLOBALS['strAllowAffiliateAddZone'] = "Povolit tomuto uživateli přidávat vlastní zóny";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Povolit tomuto uživateli mazat existující zóny";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Povolit tomuto uživateli generovat kód vyvolání";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "PSČ";
$GLOBALS['strCountry'] = "Země";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Vydavatelé & Zóny";

// Zone
$GLOBALS['strZone'] = "Zóna";
$GLOBALS['strZones'] = "Zóny";
$GLOBALS['strAddNewZone'] = "Přidat zónu";
$GLOBALS['strAddNewZone_Key'] = "Přidat <u>z</u>ónu";
$GLOBALS['strZoneToWebsite'] = "na webové stránky";
$GLOBALS['strLinkedZones'] = "Připojené zóny";
$GLOBALS['strAvailableZones'] = "Dostupné zóny";
$GLOBALS['strLinkingNotSuccess'] = "Propojení nebylo úspěšné, zkuste to prosím znovu";
$GLOBALS['strZoneProperties'] = "Nastavení zóny";
$GLOBALS['strZoneHistory'] = "Historie zóny";
$GLOBALS['strNoZones'] = "Zatím nejsou definované žádné zóny";
$GLOBALS['strConfirmDeleteZone'] = "Opravdu chcete smazat tuto zónu?";
$GLOBALS['strConfirmDeleteZones'] = "Opravdu chcete smazat tuto zónu?";
$GLOBALS['strZoneType'] = "Typ zóny";
$GLOBALS['strBannerButtonRectangle'] = "Banner, Button nebo Čtverec";
$GLOBALS['strInterstitial'] = "Interstitial nebo Plovoucí DHTML";
$GLOBALS['strPopup'] = "Vyskakovací okno";
$GLOBALS['strTextAdZone'] = "Textová reklama";
$GLOBALS['strEmailAdZone'] = "Email/Newsletter zóna";
$GLOBALS['strZoneVideoInstream'] = "Vložené Video reklama";
$GLOBALS['strZoneVideoOverlay'] = "Překrytí Video ad";
$GLOBALS['strShowMatchingBanners'] = "Zobrazit odpovídající bannery";
$GLOBALS['strHideMatchingBanners'] = "Skrýt odpovídající bannery";
$GLOBALS['strBannerLinkedAds'] = "Bannery, které jsou spojeny s zónou";
$GLOBALS['strCampaignLinkedAds'] = "Kampaně spojené s zóny";
$GLOBALS['strInactiveZonesHidden'] = "neaktivních bannerů skryto";
$GLOBALS['strZonesOfWebsite'] = 'v'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "Zpět do zón";

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
$GLOBALS['strAdvanced'] = "Rozšířené";
$GLOBALS['strChainSettings'] = "Nastavení vazby";
$GLOBALS['strZoneNoDelivery'] = "Pokud žádné bannery z této zóny <br>nemohou být zobrazeny snaž se...";
$GLOBALS['strZoneStopDelivery'] = "Ukonči doručování a nezobrazuj bannery";
$GLOBALS['strZoneOtherZone'] = "Zobraz místo toho jinou zónu";
$GLOBALS['strZoneAppend'] = "Vždy přidej následující HTML kód k bannerům v této zóně";
$GLOBALS['strAppendSettings'] = "Nastavení přiložení a předložení";
$GLOBALS['strZonePrependHTML'] = "Vždy předlož HTML kód k textové inzerci v této zóně";
$GLOBALS['strZoneAppendHTMLCode'] = "HTML kód";
$GLOBALS['strZoneAppendZoneSelection'] = "Popup nebo interstitial";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "Žádný z bannerů připojených k této zóně není aktivní. <br>Toto je vazba zóny která bude následována:";
$GLOBALS['strZoneProbNullPri'] = "Žádný z bannerů připojených k této zóně není aktivní.";
$GLOBALS['strZoneProbListChainLoop'] = "Následování vazeb zóny může vytvořit cyklickou smyčku. Doručování pro tuto zónu je zastaveno.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Prosím zvolte typ připojených bannerů";
$GLOBALS['strLinkedBanners'] = "Spojení jednotlivých bannerů";
$GLOBALS['strWithXBanners'] = "%d banner(ů)";
$GLOBALS['strRawQueryString'] = "Klíčové slovo";
$GLOBALS['strIncludedBanners'] = "Připojené bannery";
$GLOBALS['strMatchingBanners'] = "{count} odpovídajících bannerů";
$GLOBALS['strNoCampaignsToLink'] = "Nejsou k dispozici žádné kampaně které by mohly být připojeny k této zóně";
$GLOBALS['strNoTrackersToLink'] = "Nejsou k dispozici žádné sledovače které by mohly být připojeny k této zóně";
$GLOBALS['strNoZonesToLinkToCampaign'] = "Nejsou k dispozici žádné zóny ke kterým by mohla být tato kampaň připojena";
$GLOBALS['strSelectBannerToLink'] = "Zvolte banner který chcete připojit k této zóně:";
$GLOBALS['strSelectCampaignToLink'] = "Zvolte kampaň kterou chcete připojit k této zóně:";
$GLOBALS['strSelectAdvertiser'] = "Zvolte inzerenta";
$GLOBALS['strSelectPlacement'] = "Zvolte kampaň";
$GLOBALS['strSelectAd'] = "Zvolte banner";
$GLOBALS['strSelectPublisher'] = "Zvolte webovou stránku";
$GLOBALS['strSelectZone'] = "Vyberte zónu";
$GLOBALS['strStatusPending'] = "Čekající";
$GLOBALS['strStatusApproved'] = "Schváleno";
$GLOBALS['strStatusDisapproved'] = "Zamítnout";
$GLOBALS['strStatusDuplicate'] = "Duplikovat";
$GLOBALS['strStatusOnHold'] = "Pozastaveno";
$GLOBALS['strStatusIgnore'] = "Ignorovat";
$GLOBALS['strConnectionType'] = "Typ";
$GLOBALS['strConnTypeSale'] = "Prodej";
$GLOBALS['strConnTypeSignUp'] = "Registrace";
$GLOBALS['strShortcutEditStatuses'] = "Upravit statusy";
$GLOBALS['strShortcutShowStatuses'] = "Zobrazit statusy";

// Statistics
$GLOBALS['strStats'] = "Statistiky";
$GLOBALS['strNoStats'] = "V tuto chvíli nejsou k dispozici žádné statistiky";
$GLOBALS['strNoStatsForPeriod'] = "Neexistují v současné době žádné statistiky dostupné pro období %s na %s";
$GLOBALS['strTotalThisPeriod'] = "Celkem v tomto období";
$GLOBALS['strPublisherDistribution'] = "Rozdělení vydavatelů";
$GLOBALS['strViewBreakdown'] = "Zobrazit podle";
$GLOBALS['strBreakdownByDay'] = "Den";
$GLOBALS['strBreakdownByWeek'] = "Týden";
$GLOBALS['strBreakdownByMonth'] = "Měsíců";
$GLOBALS['strBreakdownByDow'] = "Den v týdnu";
$GLOBALS['strBreakdownByHour'] = "Hodina";
$GLOBALS['strItemsPerPage'] = "Položek na stránku";
$GLOBALS['strShowGraphOfStatistics'] = "Zobrazit <u>G</u>raf statistiky";
$GLOBALS['strStatsArea'] = "Oblast";

// Expiration
$GLOBALS['strNoExpiration'] = "Není zadáno datum expirace";
$GLOBALS['strEstimated'] = "Předpokládaná expirace";
$GLOBALS['strDaysAgo'] = "dnů před";
$GLOBALS['strCampaignStop'] = "Historie kampaně";

// Reports
$GLOBALS['strAdvancedReports'] = "Rozšířené reporty";
$GLOBALS['strStartDate'] = "Počáteční datum";
$GLOBALS['strEndDate'] = "Datum ukončení";
$GLOBALS['strPeriod'] = "Období";
$GLOBALS['strWorksheets'] = "Pracovní výkaz";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "Celkem inzerentů";
$GLOBALS['strAnonAdvertisers'] = "Anonymní inzerenti";
$GLOBALS['strAllPublishers'] = "Všechny weby";
$GLOBALS['strAnonPublishers'] = "Anonymní webové stránky";
$GLOBALS['strAllAvailZones'] = "Všechny dostupné zóny";

// Userlog
$GLOBALS['strUserLog'] = "Uživatelský log";
$GLOBALS['strUserLogDetails'] = "Datily uživatelského logu";
$GLOBALS['strDeleteLog'] = "Smazat log";
$GLOBALS['strAction'] = "Akce";
$GLOBALS['strNoActionsLogged'] = "Žádné akce se nelogují";

// Code generation
$GLOBALS['strGenerateBannercode'] = "Přímá volba";
$GLOBALS['strChooseInvocationType'] = "Prosím zvolte typ volání banneru";
$GLOBALS['strGenerate'] = "Vygenerovat";
$GLOBALS['strParameters'] = "Parametry";
$GLOBALS['strFrameSize'] = "Velikost frame";
$GLOBALS['strBannercode'] = "Kód banneru";
$GLOBALS['strTrackercode'] = "Kód sledovače";
$GLOBALS['strBackToTheList'] = "Přejít zpět na výpis reportů";
$GLOBALS['strCharset'] = "Znaková sada";
$GLOBALS['strAutoDetect'] = "Automatický výběr";

// Errors
$GLOBALS['strNoMatchesFound'] = "Žedné odpovídající záznamy nebyly nalezeny";
$GLOBALS['strErrorOccurred'] = "Nastala chyba";
$GLOBALS['strErrorDBPlain'] = "Nastala chyba při přístupu do databáze";
$GLOBALS['strErrorDBSerious'] = "Byl zjištěn závažný problém při přístupu do databáze";
$GLOBALS['strErrorDBNoDataPlain'] = "Vzhledem k promlémům s databází, {$PRODUCT_NAME} nemůže načíst ani ukládat data.";
$GLOBALS['strErrorDBNoDataSerious'] = "Vzhledem k závažným promlémům s databází, {$PRODUCT_NAME} nemůže načíst data";
$GLOBALS['strErrorDBCorrupt'] = "Databázová tabulka je pravděpodobně poškozena a potřebuje opravit. Pro více informací o opravování poškozených tabulek prosím čtěte kapitolu <i>Troubleshooting</i> v příručce <i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact'] = "Prosím kontaktujte správce tohoto serveru a oznamte jemu nebo jí tento problém.";
$GLOBALS['strErrorDBSubmitBug'] = "Pokud je tento problém reprodukovatelný, může být způsoben chybou v {$PRODUCT_NAME}. Prosím poskytněte následující informace tvůrcům {$PRODUCT_NAME}. Také se pokuste popsat kroky které vedly k této chybě jak nejpřesněji je to jen možné.";
$GLOBALS['strMaintenanceNotActive'] = "Skript pro správu systému nebyl spuštěn v průběhu posledních 24 hodin.
Aby mohl {$PRODUCT_NAME} korektně fungovat je nutné aby běžel každou
hodinu.

Prosím přečtěte si příručku Administrators guide pro informace
o konfiguraci skriptu pro správu systému.";
$GLOBALS['strUnableToLinkBanner'] = "Nelze propojit tento banner: ";
$GLOBALS['strErrorEditingZone'] = "Chyba při aktualizaci zóny:";

//Validation

// Email
$GLOBALS['strMailSubject'] = "Prehled inzerenta";
$GLOBALS['strMailHeader'] = "Vazeny {contact},";
$GLOBALS['strMailBannerStats'] = "Nize najdete statistiky banneru pro {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Kampaň aktivována";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Kampaň {id} aktivována";
$GLOBALS['strMailFooter'] = "S pozdravem,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "Tato kampan neni v tuto chvili aktivni z duvodu";
$GLOBALS['strBeforeActivate'] = "datum aktivace zatim nenastalo";
$GLOBALS['strAfterExpire'] = "nastalo datum deaktivace";
$GLOBALS['strNoMoreClicks'] = "nezbyvaji jiz zadna kliknuti";
$GLOBALS['strNoMoreConversions'] = "nezbyvaji jiz zadne prodeje";
$GLOBALS['strWeightIsNull'] = "jeji vaha je nastavena na nulu";
$GLOBALS['strNoViewLoggedInInterval'] = "Zadna zobrazeni nebyla za obdobi tohoto prehledu zaznamenana";
$GLOBALS['strNoClickLoggedInInterval'] = "Zadna kliknuti nebyla za obdobi tohoto prehledu zaznamenana";
$GLOBALS['strNoConversionLoggedInInterval'] = "Zadne prodeje nebyly za obdobi tohoto prehledu zaznamenany";
$GLOBALS['strMailReportPeriod'] = "Tento prehled obsahuje statistiky od {startdate} do {enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "Tento prehled obsahuje statistiky do {enddate}.";
$GLOBALS['strNoStatsForCampaign'] = "Nejsou k dispozici zadne statistiky pro tuto kampan";
$GLOBALS['strImpendingCampaignExpiry'] = "Hrozící vypršení platnosti kampaně";
$GLOBALS['strYourCampaign'] = "Vaše kampaň";
$GLOBALS['strTheCampiaignBelongingTo'] = "Kampaň, která patří do";

// Priority
$GLOBALS['strPriority'] = "Priorita";
$GLOBALS['strSourceEdit'] = "Upravit zdroje";

// Preferences
$GLOBALS['strPreferences'] = "Předvolby";
$GLOBALS['strUserPreferences'] = "Preference uživatele";
$GLOBALS['strChangePassword'] = "Změnit heslo";
$GLOBALS['strChangeEmail'] = "Změnit e-mail";
$GLOBALS['strCurrentPassword'] = "Aktuální heslo";
$GLOBALS['strChooseNewPassword'] = "Zvolte nové heslo";
$GLOBALS['strReenterNewPassword'] = "Zadejte znovu nové heslo";
$GLOBALS['strNameLanguage'] = "Jméno & jazyk";
$GLOBALS['strAccountPreferences'] = "Předvolby účtu";
$GLOBALS['strFullName'] = "Celé jméno";
$GLOBALS['strEmailAddress'] = "E-mailová adresa";
$GLOBALS['strUserDetails'] = "Údaje o uživateli";
$GLOBALS['strShowColumn'] = "Zobrazit sloupec";

// Long names

// Short names
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strImpressions_short'] = "Impr.";
$GLOBALS['strClicks_short'] = "Kliknutí";
$GLOBALS['strCTR_short'] = "CTR";

// Global Settings
$GLOBALS['strGlobalSettings'] = "Základní nastavení";
$GLOBALS['strGeneralSettings'] = "Obecná nastavení";
$GLOBALS['strMainSettings'] = "Základní nastavení";
$GLOBALS['strChooseSection'] = 'Vyberte sekci';

// Product Updates
$GLOBALS['strProductUpdates'] = "Aktualizace produktu";
$GLOBALS['strFromVersion'] = "Od verze";
$GLOBALS['strToVersion'] = "Na verzi";
$GLOBALS['strShowBackupDetails'] = "Zobrazit podrobnosti zálohování dat.";

// Agency
$GLOBALS['strAgencyManagement'] = "Správa partnerů";
$GLOBALS['strAgency'] = "Partner";
$GLOBALS['strAddAgency'] = "Přidat partnera";
$GLOBALS['strAddAgency_Key'] = "Přidat <u>z</u>ónu";
$GLOBALS['strTotalAgencies'] = "Celkem partnerů";
$GLOBALS['strAgencyProperties'] = "Vlastnosti partnera";
$GLOBALS['strNoAgencies'] = "Zatím nejsou definované žádné zóny";
$GLOBALS['strConfirmDeleteAgency'] = "Opravdu chcete smazat tuto zónu?";
$GLOBALS['strHideInactiveAgencies'] = "Skrýt neaktivní partnery";
$GLOBALS['strInactiveAgenciesHidden'] = "neaktivních bannerů skryto";
$GLOBALS['strAgencyStatusInactive'] = "aktivní";

// Channels
$GLOBALS['strChannelToWebsite'] = "na webové stránky";
$GLOBALS['strChannelLimitations'] = "Nastavení doručování";
$GLOBALS['strChannelsOfWebsite'] = 'v'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "Název proměnné";
$GLOBALS['strVariableDescription'] = "Popis";
$GLOBALS['strVariableDataType'] = "Datový typ";
$GLOBALS['strTrackFollowingVars'] = "Sledovat tuto proměnnou";
$GLOBALS['strAddVariable'] = "Přidat proměnnou";
$GLOBALS['strNoVarsToTrack'] = "Žádné proměnné ke sledování.";

// Password recovery
$GLOBALS['strPwdRecEnterEmail'] = "Zadejte vaši e-mailovou adresu";
$GLOBALS['strPwdRecEnterPassword'] = "Zadejte své nové heslo";

// Password recovery - Default


// Password recovery - Welcome email

// Password recovery - Hash update

// Password reset warning

// Audit
$GLOBALS['strFor'] = "pro";
$GLOBALS['strHas'] = "má";

// Widget - Audit

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Přejděte na stránku kampaně";



//confirmation messages










// Report error messages

/* ------------------------------------------------------- */
/* Password strength                                       */
/* ------------------------------------------------------- */


if (!isset($GLOBALS['strPasswordScore'])) {
    $GLOBALS['strPasswordScore'] = [];
}



/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyNextItem'] = ",";
$GLOBALS['keyPreviousItem'] = " ";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
