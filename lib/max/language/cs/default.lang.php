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
$GLOBALS['phpAds_ThousandsSeperator'] = " ";

// Date & time configuration
$GLOBALS['date_format'] = "%d.%m.%Y";
$GLOBALS['time_format'] = "%H:%M:%S";
$GLOBALS['minute_format'] = "%H:%M";
$GLOBALS['month_format'] = "%m.%Y";
$GLOBALS['day_format'] = "%d.%m";
$GLOBALS['week_format'] = "%W.%Y";
$GLOBALS['weekiso_format'] = "%V.%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate
$GLOBALS['excel_integer_formatting'] = "#,##0;-#,##0;-";
$GLOBALS['excel_decimal_formatting'] = "#,##0.000;-#,##0.000;-";

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
$GLOBALS['strLimitations'] = "Delivery rules";
$GLOBALS['strNoLimitations'] = "No delivery rules";
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
$GLOBALS['strUserLinkedToAccount'] = "Uživatel byl přidán k účtu";
$GLOBALS['strUserAccountUpdated'] = "Uživatelský účet aktualizován";
$GLOBALS['strUserUnlinkedFromAccount'] = "Uživatel byl odebrán z účtu";
$GLOBALS['strUserWasDeleted'] = "Uživatel byl odstraněn";
$GLOBALS['strUserNotLinkedWithAccount'] = "Takový uživatel není propojen s účtem";
$GLOBALS['strCantDeleteOneAdminUser'] = "Nelze odstranit uživatele. Alespoň jeden uživatel musí být propojeny s účtem správce.";
$GLOBALS['strLinkUserHelp'] = "Chcete-li přidat <b>existující uživatele</b>, zadejte %1\$s a klepněte na tlačítko %2\$s < br / > přidat <b>nového uživatele</b>, zadejte požadovanou %1\$s a klepněte na %2\$s";
$GLOBALS['strLinkUserHelpUser'] = "Jméno";
$GLOBALS['strLinkUserHelpEmail'] = "e-mailová adresa";
$GLOBALS['strLastLoggedIn'] = "Poslední přihlášení";
$GLOBALS['strDateLinked'] = "Date linked";

// Login & Permissions
$GLOBALS['strUserAccess'] = "Uživatelský přístup";
$GLOBALS['strAdminAccess'] = "Přístup správce";
$GLOBALS['strUserProperties'] = "Nastavení banneru";
$GLOBALS['strPermissions'] = "Oprávnění";
$GLOBALS['strAuthentification'] = "Autentifikace";
$GLOBALS['strWelcomeTo'] = "Vítejte do";
$GLOBALS['strEnterUsername'] = "Pro přihlásení zadejte vaše uživatelské jméno a heslo";
$GLOBALS['strEnterBoth'] = "Prosím zadejte vaše jméno i heslo";
$GLOBALS['strEnableCookies'] = "You need to enable cookies before you can use {$PRODUCT_NAME}";
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
    $GLOBALS['strDayFullNames'] = array();
}
$GLOBALS['strDayFullNames'][0] = 'Neděle';
$GLOBALS['strDayFullNames'][1] = 'Pondělí';
$GLOBALS['strDayFullNames'][2] = 'Úterý';
$GLOBALS['strDayFullNames'][3] = 'Středa';
$GLOBALS['strDayFullNames'][4] = 'Čtvrtek';
$GLOBALS['strDayFullNames'][5] = 'Pátek';
$GLOBALS['strDayFullNames'][6] = 'Sobota';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = array();
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
$GLOBALS['strClientHistory'] = "Advertiser Statistics";
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
$GLOBALS['strAllowCreateAccounts'] = "Allow this user to manage this account's users";
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
$GLOBALS['strCampaignHistory'] = "Campaign Statistics";
$GLOBALS['strNoCampaigns'] = "V tuto chvíli nejsou definované žádné kampaně";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "Momentálně zde nejsou žádné kampaně definované, protože zde nejsou žádní inzerenti. Chcete-li vytvořit kampaň, musíte nejdříve <a href='advertiser-edit.php'>přidat nového inzerenta </a>.";
$GLOBALS['strConfirmDeleteCampaign'] = "Opravdu chcete smazat tuto kampaň?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Opravdu chcete smazat tuto kampaň?";
$GLOBALS['strShowParentAdvertisers'] = "Show parent advertisers";
$GLOBALS['strHideParentAdvertisers'] = "Hide parent advertisers";
$GLOBALS['strHideInactiveCampaigns'] = "Skrýt neaktivní kampaně";
$GLOBALS['strInactiveCampaignsHidden'] = "neaktivních kampaní skryto";
$GLOBALS['strPriorityInformation'] = "Informace o prioritě";
$GLOBALS['strECPMInformation'] = "eCPM prioritization";
$GLOBALS['strRemnantEcpmDescription'] = "eCPM is automatically calculated based on this campaign's performance.<br />It will be used to prioritise Remnant campaigns relative to each other.";
$GLOBALS['strEcpmMinImpsDescription'] = "Set this to your desired minium basis on which to calculate this campaign's eCPM.";
$GLOBALS['strHiddenCampaign'] = "Kampaň";
$GLOBALS['strHiddenAd'] = "Advertisement";
$GLOBALS['strHiddenAdvertiser'] = "Inzerent";
$GLOBALS['strHiddenTracker'] = "Sledovač";
$GLOBALS['strHiddenWebsite'] = "Webová stránka";
$GLOBALS['strHiddenZone'] = "Zóna";
$GLOBALS['strCampaignDelivery'] = "Doručování kampaně";
$GLOBALS['strCompanionPositioning'] = "Companion positioning";
$GLOBALS['strSelectUnselectAll'] = "Vybrat / zrušit výběr všech";
$GLOBALS['strCampaignsOfAdvertiser'] = "of"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'
$GLOBALS['strShowCappedNoCookie'] = "Show capped ads if cookies are disabled";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "Calculated for all campaigns";
$GLOBALS['strCalculatedForThisCampaign'] = "Calculated for this campaign";
$GLOBALS['strLinkingZonesProblem'] = "Problem occurred when linking zones";
$GLOBALS['strUnlinkingZonesProblem'] = "Problem occurred when unlinking zones";
$GLOBALS['strZonesLinked'] = "zone(s) linked";
$GLOBALS['strZonesUnlinked'] = "zone(s) unlinked";
$GLOBALS['strZonesSearch'] = "Hledání";
$GLOBALS['strZonesSearchTitle'] = "Search zones and websites by name";
$GLOBALS['strNoWebsitesAndZones'] = "No websites and zones";
$GLOBALS['strNoWebsitesAndZonesText'] = "with \"%s\" in name";
$GLOBALS['strToLink'] = "to link";
$GLOBALS['strToUnlink'] = "to unlink";
$GLOBALS['strLinked'] = "Linked";
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
$GLOBALS['strImpressionsRemaining'] = "Impressions Remaining";
$GLOBALS['strClicksRemaining'] = "Clicks Remaining";
$GLOBALS['strConversionsRemaining'] = "Conversions Remaining";
$GLOBALS['strImpressionsBooked'] = "Impressions Booked";
$GLOBALS['strClicksBooked'] = "Clicks Booked";
$GLOBALS['strConversionsBooked'] = "Conversions Booked";
$GLOBALS['strCampaignWeight'] = "Váha kampaně";
$GLOBALS['strAnonymous'] = "Skrýt inzerenta a vydavatele této kampaně.";
$GLOBALS['strTargetPerDay'] = "za den.";
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
$GLOBALS['strCampaignStatusPending'] = "Čekající";
$GLOBALS['strCampaignStatusInactive'] = "aktivní";
$GLOBALS['strCampaignStatusRunning'] = "Spuštěné";
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
$GLOBALS['strRemnant'] = "Zbytek";
$GLOBALS['strRemnantInfo'] = "The default campaign type. Remnant campaigns have lots of different
    delivery options, and you should ideally always have at least one Remnant campaign linked to every zone, to ensure
    that there is always something to show. Use Remnant campaigns to display house banners, ad-network banners, or even
    direct advertising that has been sold, but where there is not a time-critical performance requirement for the
    campaign to adhere to.";
$GLOBALS['strECPMInfo'] = "Jedná se o standardní kampaň, která může být omezena buď s datumem ukončení nebo konkrétním omezení. Na základě aktuálního nastavení bude mít prioritu pomocí eCPM.";
$GLOBALS['strPricing'] = "Stanovení ceny";
$GLOBALS['strPricingModel'] = "Cenový model";
$GLOBALS['strSelectPricingModel'] = "--Vyberte model –";
$GLOBALS['strRatePrice'] = "Sazba / cena";
$GLOBALS['strMinimumImpressions'] = "Minimální denní zobrazení";
$GLOBALS['strLimit'] = "Limit";
$GLOBALS['strLowExclusiveDisabled'] = "You cannot change this campaign to Remnant or Exclusive, since both an end date and either of impressions/clicks/conversions limit are set. <br>In order to change type, you need to set no expiry date or remove limits.";
$GLOBALS['strCannotSetBothDateAndLimit'] = "You cannot set both an end date and limit for a Remnant or Exclusive campaign.<br>If you need to set both an end date and limit impressions/clicks/conversions please use a non-exclusive Contract campaign.";
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
$GLOBALS['strTrackerInformation'] = "Tracker Information";
$GLOBALS['strConversionWindow'] = "Okno převodu";
$GLOBALS['strUniqueWindow'] = "Jedinečné okno";
$GLOBALS['strClick'] = "Klik";
$GLOBALS['strView'] = "Zobrazení";
$GLOBALS['strArrival'] = "Příjezd";
$GLOBALS['strManual'] = "Manuál";
$GLOBALS['strImpression'] = "Zobrazení";
$GLOBALS['strConversionType'] = "Typ konverze";
$GLOBALS['strLinkCampaignsByDefault'] = "Link newly created campaigns by default";
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
$GLOBALS['strBannerHistory'] = "Banner Statistics";
$GLOBALS['strNoBanners'] = "Zatím nejsou definovány žádné bannery";
$GLOBALS['strNoBannersAddCampaign'] = "There are currently no banners defined, because there are no campaigns. To create a banner, <a href='campaign-edit.php?clientid=%s'>add a new campaign</a> first.";
$GLOBALS['strNoBannersAddAdvertiser'] = "There are currently no banners defined, because there are no advertisers. To create a banner, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
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
$GLOBALS['strAlterHTML'] = "Alter HTML to enable click tracking for:";
$GLOBALS['strIframeFriendly'] = "This banner can be safely displayed inside an iframe (e.g. is not expandable)";
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
$GLOBALS['strCampaignsWeight'] = "Campaign's Weight";
$GLOBALS['strBannerWeight'] = "Váha banneru";
$GLOBALS['strBannersWeight'] = "Banner's Weight";
$GLOBALS['strAdserverTypeGeneric'] = "Generický HTML Banner";
$GLOBALS['strDoNotAlterHtml'] = "Neměňte HTML";
$GLOBALS['strGenericOutputAdServer'] = "Generic";
$GLOBALS['strSwfTransparency'] = "Povolit průhledné pozadí";
$GLOBALS['strBackToBanners'] = "Zpět na bannery";
$GLOBALS['strUseWyswygHtmlEditor'] = "Use WYSIWYG HTML Editor";
$GLOBALS['strChangeDefault'] = "Change default";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "Always prepend the following HTML code to this banner";
$GLOBALS['strBannerAppendHTML'] = "Always append the following HTML code to this banner";

// Banner (swf)
$GLOBALS['strCheckSWF'] = "Převést pevné odkazy uvnitř Flash souboru";
$GLOBALS['strConvertSWFLinks'] = "Převést Flash odkazy";
$GLOBALS['strHardcodedLinks'] = "Pevné odkazy";
$GLOBALS['strConvertSWF'] = "<br />The Flash file you just uploaded contains hard-coded urls. {$PRODUCT_NAME} won't be able to track the number of Clicks for this banner unless you convert these hard-coded urls. Below you will find a list of all urls inside the Flash file. If you want to convert the urls, simply click <b>Convert</b>, otherwise click <b>Cancel</b>.<br /><br />Please note: if you click <b>Convert</b> the Flash file you just uploaded will be physically altered. <br />Please keep a backup of the original file. Regardless of in which version this banner was created, the resulting file will need the Flash 4 player (or higher) to display correctly.<br /><br />";
$GLOBALS['strCompressSWF'] = "Komprimovat SWF soubor pro rychlejší stahování (vyžaduje přehrávač Flash 6)";
$GLOBALS['strOverwriteSource'] = "Přepsat zdrojový parametr";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "Nastavení doručování";
$GLOBALS['strACL'] = "Nastavení doručování";
$GLOBALS['strACLAdd'] = "Add delivery rule";
$GLOBALS['strApplyLimitationsTo'] = "Apply delivery rules to";
$GLOBALS['strAllBannersInCampaign'] = "Všechny bannery v této kampani";
$GLOBALS['strRemoveAllLimitations'] = "Remove all delivery rules";
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
$GLOBALS['strGreaterOrEqualTo'] = "is greater or equal to";
$GLOBALS['strLessOrEqualTo'] = "is less or equal to";
$GLOBALS['strAND'] = "A";                          // logical operator
$GLOBALS['strOR'] = "NEBO";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Zobrazit tento banner pouze:";
$GLOBALS['strWeekDays'] = "V pracovní den";
$GLOBALS['strTime'] = "Čas";
$GLOBALS['strDomain'] = "Doména";
$GLOBALS['strSource'] = "Zdroj";
$GLOBALS['strBrowser'] = "Prohlížeč";
$GLOBALS['strOS'] = "OS";
$GLOBALS['strDeliveryLimitations'] = "Delivery Rules";

$GLOBALS['strDeliveryCappingReset'] = "Obnovit počítadlo zobrazení po:";
$GLOBALS['strDeliveryCappingTotal'] = "celkem";
$GLOBALS['strDeliveryCappingSession'] = "za relaci";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingBanner']['limit'] = "Limit banner views to:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingCampaign']['limit'] = "Omezit zobrazení kampaně na:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingZone']['limit'] = "Omezit zobrazení zóny na:";

// Website
$GLOBALS['strAffiliate'] = "Webová stránka";
$GLOBALS['strAffiliates'] = "Vydavatelé";
$GLOBALS['strAffiliatesAndZones'] = "Vydavatelé & Zóny";
$GLOBALS['strAddNewAffiliate'] = "Přidat vydavatele";
$GLOBALS['strAffiliateProperties'] = "Nastavení vydavatele";
$GLOBALS['strAffiliateHistory'] = "Website Statistics";
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
$GLOBALS['strNoZonesAddWebsite'] = "There are currently no zones defined, because there are no websites. To create a zone, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strConfirmDeleteZone'] = "Opravdu chcete smazat tuto zónu?";
$GLOBALS['strConfirmDeleteZones'] = "Opravdu chcete smazat tuto zónu?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "There are campaigns still linked to this zone, if you delete it these will not be able to run and you will not be paid for them.";
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
$GLOBALS['strWarnChangeZoneType'] = "Changing the zone type to text or email will unlink all banners/campaigns due to restrictions of these zone types
                                                <ul>
                                                    <li>Text zones can only be linked to text ads</li>
                                                    <li>Email zone campaigns can only have one active banner at a time</li>
                                                </ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Changing the zone size will unlink any banners that are not the new size, and will add any banners from linked campaigns which are the new size';
$GLOBALS['strWarnChangeBannerSize'] = 'Changing the banner size will unlink this banner from any zones that are not the new size, and if this banner\'s <strong>campaign</strong> is linked to a zone of the new size, this banner will be automatically linked';
$GLOBALS['strWarnBannerReadonly'] = 'This banner is read-only because an extension has been disabled. Contact your system administrator for more information.';
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
$GLOBALS['strZoneAppendNoBanner'] = "Prepend/Append even if no banner delivered";
$GLOBALS['strZoneAppendHTMLCode'] = "HTML kód";
$GLOBALS['strZoneAppendZoneSelection'] = "Popup nebo interstitial";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "Žádný z bannerů připojených k této zóně není aktivní. <br>Toto je vazba zóny která bude následována:";
$GLOBALS['strZoneProbNullPri'] = "Žádný z bannerů připojených k této zóně není aktivní.";
$GLOBALS['strZoneProbListChainLoop'] = "Následování vazeb zóny může vytvořit cyklickou smyčku. Doručování pro tuto zónu je zastaveno.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Prosím zvolte typ připojených bannerů";
$GLOBALS['strLinkedBanners'] = "Spojení jednotlivých bannerů";
$GLOBALS['strCampaignDefaults'] = "Link banners by parent campaign";
$GLOBALS['strLinkedCategories'] = "Link banners by category";
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
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Registrace";
$GLOBALS['strShortcutEditStatuses'] = "Upravit statusy";
$GLOBALS['strShortcutShowStatuses'] = "Zobrazit statusy";

// Statistics
$GLOBALS['strStats'] = "Statistiky";
$GLOBALS['strNoStats'] = "V tuto chvíli nejsou k dispozici žádné statistiky";
$GLOBALS['strNoStatsForPeriod'] = "Neexistují v současné době žádné statistiky dostupné pro období %s na %s";
$GLOBALS['strGlobalHistory'] = "Global Statistics";
$GLOBALS['strDailyHistory'] = "Daily Statistics";
$GLOBALS['strDailyStats'] = "Daily Statistics";
$GLOBALS['strWeeklyHistory'] = "Weekly Statistics";
$GLOBALS['strMonthlyHistory'] = "Monthly Statistics";
$GLOBALS['strTotalThisPeriod'] = "Celkem v tomto období";
$GLOBALS['strPublisherDistribution'] = "Rozdělení vydavatelů";
$GLOBALS['strCampaignDistribution'] = "Campaign Distribution";
$GLOBALS['strViewBreakdown'] = "Zobrazit podle";
$GLOBALS['strBreakdownByDay'] = "Den";
$GLOBALS['strBreakdownByWeek'] = "Týden";
$GLOBALS['strBreakdownByMonth'] = "Měsíců";
$GLOBALS['strBreakdownByDow'] = "Den v týdnu";
$GLOBALS['strBreakdownByHour'] = "Hodina";
$GLOBALS['strItemsPerPage'] = "Položek na stránku";
$GLOBALS['strDistributionHistoryCampaign'] = "Distribution Statistics (Campaign)";
$GLOBALS['strDistributionHistoryBanner'] = "Distribution Statistics (Banner)";
$GLOBALS['strDistributionHistoryWebsite'] = "Distribution Statistics (Website)";
$GLOBALS['strDistributionHistoryZone'] = "Distribution Statistics (Zone)";
$GLOBALS['strShowGraphOfStatistics'] = "Zobrazit <u>G</u>raf statistiky";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>xport Statistics to Excel";
$GLOBALS['strGDnotEnabled'] = "You must have GD enabled in PHP to display graphs. <br />Please see <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> for more information, including how to install GD on your server.";
$GLOBALS['strStatsArea'] = "Oblast";

// Expiration
$GLOBALS['strNoExpiration'] = "Není zadáno datum expirace";
$GLOBALS['strEstimated'] = "Předpokládaná expirace";
$GLOBALS['strNoExpirationEstimation'] = "No expiration estimated yet";
$GLOBALS['strDaysAgo'] = "dnů před";
$GLOBALS['strCampaignStop'] = "Historie kampaně";

// Reports
$GLOBALS['strAdvancedReports'] = "Rozšířené reporty";
$GLOBALS['strStartDate'] = "Počáteční datum";
$GLOBALS['strEndDate'] = "Datum ukončení";
$GLOBALS['strPeriod'] = "Období";
$GLOBALS['strLimitations'] = "Delivery Rules";
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
$GLOBALS['strNoMatchesFound'] = "Žedné odpovídající záznamy nebyly nalezeny";
$GLOBALS['strErrorOccurred'] = "Nastala chyba";
$GLOBALS['strErrorDBPlain'] = "Nastala chyba při přístupu do databáze";
$GLOBALS['strErrorDBSerious'] = "Byl zjištěn závažný problém při přístupu do databáze";
$GLOBALS['strErrorDBNoDataPlain'] = "Due to a problem with the database {$PRODUCT_NAME} couldn't retrieve or store data. ";
$GLOBALS['strErrorDBNoDataSerious'] = "Due to a serious problem with the database, {$PRODUCT_NAME} couldn't retrieve data";
$GLOBALS['strErrorDBCorrupt'] = "Databázová tabulka je pravděpodobně poškozena a potřebuje opravit. Pro více informací o opravování poškozených tabulek prosím čtěte kapitolu <i>Troubleshooting</i> v příručce <i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact'] = "Prosím kontaktujte správce tohoto serveru a oznamte jemu nebo jí tento problém.";
$GLOBALS['strErrorDBSubmitBug'] = "If this problem is reproducable it might be caused by a bug in {$PRODUCT_NAME}. Please report the following information to the creators of {$PRODUCT_NAME}. Also try to describe the actions that led to this error as clearly as possible.";
$GLOBALS['strMaintenanceNotActive'] = "The maintenance script has not been run in the last 24 hours.
In order for the application to function correctly it needs to run
every hour.

Please read the Administrator guide for more information
about configuring the maintenance script.";
$GLOBALS['strErrorLinkingBanner'] = "It was not possible to link this banner to this zone because:";
$GLOBALS['strUnableToLinkBanner'] = "Nelze propojit tento banner: ";
$GLOBALS['strErrorEditingCampaignRevenue'] = "incorrect number format in Revenue Information field";
$GLOBALS['strErrorEditingCampaignECPM'] = "incorrect number format in ECPM Information field";
$GLOBALS['strErrorEditingZone'] = "Chyba při aktualizaci zóny:";
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
$GLOBALS['strMailSubject'] = "Prehled inzerenta";
$GLOBALS['strMailHeader'] = "Dear {contact},";
$GLOBALS['strMailBannerStats'] = "Nize najdete statistiky banneru pro {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Kampaň aktivována";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Kampaň {id} aktivována";
$GLOBALS['strMailBannerActivated'] = "Your campaign shown below has been activated because
the campaign activation date has been reached.";
$GLOBALS['strMailBannerDeactivated'] = "Your campaign shown below has been deactivated because";
$GLOBALS['strMailFooter'] = "Regards,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "Tato kampan neni v tuto chvili aktivni z duvodu";
$GLOBALS['strBeforeActivate'] = "datum aktivace zatim nenastalo";
$GLOBALS['strAfterExpire'] = "nastalo datum deaktivace";
$GLOBALS['strNoMoreImpressions'] = "there are no Impressions remaining";
$GLOBALS['strNoMoreClicks'] = "nezbyvaji jiz zadna kliknuti";
$GLOBALS['strNoMoreConversions'] = "nezbyvaji jiz zadne prodeje";
$GLOBALS['strWeightIsNull'] = "jeji vaha je nastavena na nulu";
$GLOBALS['strRevenueIsNull'] = "its revenue is set to zero";
$GLOBALS['strTargetIsNull'] = "its limit per day is set to zero - you need to either specify both an end date and a limit or set Limit per day value";
$GLOBALS['strNoViewLoggedInInterval'] = "Zadna zobrazeni nebyla za obdobi tohoto prehledu zaznamenana";
$GLOBALS['strNoClickLoggedInInterval'] = "Zadna kliknuti nebyla za obdobi tohoto prehledu zaznamenana";
$GLOBALS['strNoConversionLoggedInInterval'] = "Zadne prodeje nebyly za obdobi tohoto prehledu zaznamenany";
$GLOBALS['strMailReportPeriod'] = "Tento prehled obsahuje statistiky od {startdate} do {enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "Tento prehled obsahuje statistiky do {enddate}.";
$GLOBALS['strNoStatsForCampaign'] = "Nejsou k dispozici zadne statistiky pro tuto kampan";
$GLOBALS['strImpendingCampaignExpiry'] = "Hrozící vypršení platnosti kampaně";
$GLOBALS['strYourCampaign'] = "Vaše kampaň";
$GLOBALS['strTheCampiaignBelongingTo'] = "Kampaň, která patří do";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} shown below is due to end on {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} shown below has less than {limit} impressions remaining.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "As a result, the campaign will soon be automatically disabled, and the
following banners in the campaign will also be disabled:";

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
$GLOBALS['strCampaignEmailReportsPreferences'] = "Campaign email Reports Preferences";
$GLOBALS['strTimezonePreferences'] = "Timezone Preferences";
$GLOBALS['strAdminEmailWarnings'] = "System administrator email Warnings";
$GLOBALS['strAgencyEmailWarnings'] = "Account email Warnings";
$GLOBALS['strAdveEmailWarnings'] = "Advertiser email Warnings";
$GLOBALS['strFullName'] = "Celé jméno";
$GLOBALS['strEmailAddress'] = "E-mailová adresa";
$GLOBALS['strUserDetails'] = "Údaje o uživateli";
$GLOBALS['strUserInterfacePreferences'] = "User Interface Preferences";
$GLOBALS['strPluginPreferences'] = "Plugin Preferences";
$GLOBALS['strColumnName'] = "Column Name";
$GLOBALS['strShowColumn'] = "Zobrazit sloupec";
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
$GLOBALS['strClicks_short'] = "Kliknutí";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "Conv.";
$GLOBALS['strPendingConversions_short'] = "Pend conv.";
$GLOBALS['strImpressionSR_short'] = "Impr. SR";
$GLOBALS['strClickSR_short'] = "Click SR";

// Global Settings
$GLOBALS['strConfiguration'] = "Configuration";
$GLOBALS['strGlobalSettings'] = "Základní nastavení";
$GLOBALS['strGeneralSettings'] = "Obecná nastavení";
$GLOBALS['strMainSettings'] = "Základní nastavení";
$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strChooseSection'] = 'Choose Section';

// Product Updates
$GLOBALS['strProductUpdates'] = "Aktualizace produktu";
$GLOBALS['strViewPastUpdates'] = "Manage Past Updates and Backups";
$GLOBALS['strFromVersion'] = "Od verze";
$GLOBALS['strToVersion'] = "Na verzi";
$GLOBALS['strToggleDataBackupDetails'] = "Toggle data backup details";
$GLOBALS['strClickViewBackupDetails'] = "click to view backup details";
$GLOBALS['strClickHideBackupDetails'] = "click to hide backup details";
$GLOBALS['strShowBackupDetails'] = "Zobrazit podrobnosti zálohování dat.";
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
$GLOBALS['strSwitchAccount'] = "Switch to this account";

// Channels
$GLOBALS['strChannel'] = "Delivery Rule Set";
$GLOBALS['strChannels'] = "Delivery Rule Sets";
$GLOBALS['strChannelManagement'] = "Delivery Rule Set Management";
$GLOBALS['strAddNewChannel'] = "Add new Delivery Rule Set";
$GLOBALS['strAddNewChannel_Key'] = "Add <u>n</u>ew Delivery Rule Set";
$GLOBALS['strChannelToWebsite'] = "na webové stránky";
$GLOBALS['strNoChannels'] = "There are currently no delivery rule sets defined";
$GLOBALS['strNoChannelsAddWebsite'] = "There are currently no delivery rule sets defined, because there are no websites. To create a delivery rule set, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strEditChannelLimitations'] = "Edit delivery rules for the delivery rule set";
$GLOBALS['strChannelProperties'] = "Delivery Rule Set Properties";
$GLOBALS['strChannelLimitations'] = "Nastavení doručování";
$GLOBALS['strConfirmDeleteChannel'] = "Do you really want to delete this delivery rule set?";
$GLOBALS['strConfirmDeleteChannels'] = "Do you really want to delete the selected delivery rule sets?";
$GLOBALS['strChannelsOfWebsite'] = 'v'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "Název proměnné";
$GLOBALS['strVariableDescription'] = "Popis";
$GLOBALS['strVariableDataType'] = "Datový typ";
$GLOBALS['strVariablePurpose'] = "Purpose";
$GLOBALS['strGeneric'] = "Generic";
$GLOBALS['strBasketValue'] = "Basket value";
$GLOBALS['strNumItems'] = "Number of items";
$GLOBALS['strVariableIsUnique'] = "Dedup conversions?";
$GLOBALS['strNumber'] = "Number";
$GLOBALS['strString'] = "String";
$GLOBALS['strTrackFollowingVars'] = "Sledovat tuto proměnnou";
$GLOBALS['strAddVariable'] = "Přidat proměnnou";
$GLOBALS['strNoVarsToTrack'] = "Žádné proměnné ke sledování.";
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
$GLOBALS['strPwdRecEnterEmail'] = "Zadejte vaši e-mailovou adresu";
$GLOBALS['strPwdRecEnterPassword'] = "Zadejte své nové heslo";
$GLOBALS['strPwdRecResetLink'] = "Password reset link";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "%s password recovery";
$GLOBALS['strProceed'] = "Proceed >";
$GLOBALS['strNotifyPageMessage'] = "An e-mail has been sent to you, which includes a link that will allow you
                                         to re-set your password and log in.<br />Please allow a few minutes for the e-mail to arrive.<br />
                                         If you do not receive the e-mail, please check your spam folder.<br />
                                         <a href=\"index.php\">Return the the main login page.</a>";

// Audit
$GLOBALS['strAdditionalItems'] = "and additional items";
$GLOBALS['strFor'] = "pro";
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
$GLOBALS['strCampaignGoTo'] = "Přejděte na stránku kampaně";
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
$GLOBALS['keyNextItem'] = ",";
$GLOBALS['keyPreviousItem'] = " ";
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
