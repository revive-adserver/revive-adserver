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
$GLOBALS['strNoLimitations'] = "Bez omezení";
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

// Login & Permissions
$GLOBALS['strUserProperties'] = "Nastavení banneru";
$GLOBALS['strAuthentification'] = "Autentifikace";
$GLOBALS['strWelcomeTo'] = "Vítejte do";
$GLOBALS['strEnterUsername'] = "Pro přihlásení zadejte vaše uživatelské jméno a heslo";
$GLOBALS['strEnterBoth'] = "Prosím zadejte vaše jméno i heslo";
$GLOBALS['strLogin'] = "Přihlásit";
$GLOBALS['strLogout'] = "Odhlásit";
$GLOBALS['strUsername'] = "Jméno";
$GLOBALS['strPassword'] = "Heslo";
$GLOBALS['strPasswordRepeat'] = "Zopakujte heslo";
$GLOBALS['strAccessDenied'] = "Přístup odepřen";
$GLOBALS['strPasswordWrong'] = "Toto není správné heslo";
$GLOBALS['strNotAdmin'] = "Zřejmě nemáte dostatečné oprávnění";
$GLOBALS['strDuplicateClientName'] = "Zadané uživatelské jméno již existuje. Prosím zadejte jiné jméno.";
$GLOBALS['strInvalidPassword'] = "Zadané heslo je špatné. Prosím zadejte jiné heslo.";
$GLOBALS['strNotSamePasswords'] = "Dvě hesla která jste zadal nejsou stejná.";
$GLOBALS['strRepeatPassword'] = "Zopakujte heslo";

// General advertising
$GLOBALS['strClicks'] = "Kliknutí";
$GLOBALS['strConversions'] = "Prodeje";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "Celkem kliknutí";
$GLOBALS['strTotalConversions'] = "Celkem prodejů";
$GLOBALS['strBanners'] = "Bannery";
$GLOBALS['strCampaigns'] = "Skrytá kampaň";
$GLOBALS['strCampaignName'] = "Historie kampaně";
$GLOBALS['strCountry'] = "Země";
$GLOBALS['strStatsAction'] = "Akce";
$GLOBALS['strStatsVariables'] = "Proměnné";

// Finance

// Time and date related
$GLOBALS['strDate'] = "Datum";
$GLOBALS['strDay'] = "Den";
$GLOBALS['strDays'] = "Dní";
$GLOBALS['strWeek'] = "Týden";
$GLOBALS['strWeeks'] = "Týdnů";
$GLOBALS['strSingleMonth'] = "Měsíců";
$GLOBALS['strMonths'] = "Měsíců";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = array();
}

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = array();
}

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
$GLOBALS['strClientHistory'] = "Historie inzerenta";
$GLOBALS['strConfirmDeleteClient'] = "Opravdu chcete smazat tohoto inzerenta?";
$GLOBALS['strConfirmDeleteClients'] = "Opravdu chcete smazat tohoto inzerenta?";
$GLOBALS['strInactiveAdvertisersHidden'] = "nekativních inzerent(ů) skryto";
$GLOBALS['strAdvertiserCampaigns'] = "Inzerenti & Kampaně";

// Advertisers properties
$GLOBALS['strContact'] = "Kontakt";
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
$GLOBALS['strCampaign'] = "Skrytá kampaň";
$GLOBALS['strCampaigns'] = "Skrytá kampaň";
$GLOBALS['strAddCampaign'] = "Přidat kampaň";
$GLOBALS['strAddCampaign_Key'] = "Přidat <u>k</u>ampaň";
$GLOBALS['strCampaignForAdvertiser'] = "pro inzerenta";
$GLOBALS['strLinkedCampaigns'] = "Připojené kampaně";
$GLOBALS['strCampaignProperties'] = "Nastavení kampaně";
$GLOBALS['strCampaignOverview'] = "Přehled kampaně";
$GLOBALS['strCampaignHistory'] = "Historie kampaně";
$GLOBALS['strNoCampaigns'] = "V tuto chvíli nejsou definované žádné kampaně";
$GLOBALS['strConfirmDeleteCampaign'] = "Opravdu chcete smazat tuto kampaň?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Opravdu chcete smazat tuto kampaň?";
$GLOBALS['strHideInactiveCampaigns'] = "Skrýt neaktivní kampaně";
$GLOBALS['strInactiveCampaignsHidden'] = "neaktivních kampaní skryto";
$GLOBALS['strPriorityInformation'] = "Informace o prioritě";
$GLOBALS['strHiddenCampaign'] = "Skrytá kampaň";
$GLOBALS['strHiddenAdvertiser'] = "Inzerent";
$GLOBALS['strHiddenTracker'] = "Sledovač";
$GLOBALS['strHiddenZone'] = "Zóna";
$GLOBALS['strCampaignDelivery'] = "Doručování kampaně";

// Campaign-zone linking page


// Campaign properties
$GLOBALS['strDontExpire'] = "Tato kampaň nikdy automaticky neexpiruje";
$GLOBALS['strActivateNow'] = "Okamžitě aktivovat tuto kampaň";
$GLOBALS['strLow'] = "Nízká";
$GLOBALS['strHigh'] = "Vysoká";
$GLOBALS['strExpirationDate'] = "Koncové datum";
$GLOBALS['strExpirationDateComment'] = "Kampaň skončí na konci tohoto dne";
$GLOBALS['strActivationDate'] = "Počáteční datum";
$GLOBALS['strActivationDateComment'] = "Kampaň začne na začatku tohoto dne";
$GLOBALS['strCampaignWeight'] = "Váha kampaně";
$GLOBALS['strAnonymous'] = "Skrýt inzerenta a vydavatele této kampaně.";
$GLOBALS['strTargetPerDay'] = "za den.";
$GLOBALS['strCampaignStatusInactive'] = "aktivní";
$GLOBALS['strCampaignStatusDeleted'] = "Smazat";
$GLOBALS['strCampaignType'] = "Historie kampaně";
$GLOBALS['strContract'] = "Kontakt";
$GLOBALS['strStandardContract'] = "Kontakt";

// Tracker
$GLOBALS['strTracker'] = "Sledovač";
$GLOBALS['strTrackers'] = "Sledovač";
$GLOBALS['strAddTracker'] = "Přidat nový sledovač";
$GLOBALS['strTrackerForAdvertiser'] = "pro inzerenta";
$GLOBALS['strNoTrackers'] = "V tuto chvíli nejsou definovány ádné sledovače";
$GLOBALS['strConfirmDeleteTrackers'] = "Opravdu chcete smazat tento sledovač?";
$GLOBALS['strConfirmDeleteTracker'] = "Opravdu chcete smazat tento sledovač?";
$GLOBALS['strTrackerProperties'] = "Vlastnosti sledovače";
$GLOBALS['strLinkedTrackers'] = "Připojené sledovače";
$GLOBALS['strConversionWindow'] = "Okno převodu";
$GLOBALS['strClick'] = "Klik";
$GLOBALS['strView'] = "Zobrazení";
$GLOBALS['strIPAddress'] = "IP adresa";

// Banners (General)
$GLOBALS['strBanners'] = "Bannery";
$GLOBALS['strAddBanner'] = "Přidat banner";
$GLOBALS['strAddBanner_Key'] = "Přidat <u>b</u>anner";
$GLOBALS['strShowBanner'] = "Zobrazit banner";
$GLOBALS['strBannerProperties'] = "Nastavení banneru";
$GLOBALS['strBannerHistory'] = "Historie banneru";
$GLOBALS['strNoBanners'] = "Zatím nejsou definovány žádné bannery";
$GLOBALS['strConfirmDeleteBanner'] = "Opravdu chcete smazat tento banner?";
$GLOBALS['strConfirmDeleteBanners'] = "Opravdu chcete smazat tento banner?";
$GLOBALS['strShowParentCampaigns'] = "Zobrazit nadřazené kampaně";
$GLOBALS['strHideParentCampaigns'] = "Skrýt nadřazené kampaně";
$GLOBALS['strHideInactiveBanners'] = "Skrýt neaktivní bannery";
$GLOBALS['strInactiveBannersHidden'] = "neaktivních bannerů skryto";

// Banner Preferences

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
$GLOBALS['strStatusText'] = "Stavový text";
$GLOBALS['strBannerWeight'] = "Váha banneru";

// Banner (advanced)

// Banner (swf)
$GLOBALS['strCheckSWF'] = "Převést pevné odkazy uvnitř Flash souboru";
$GLOBALS['strConvertSWFLinks'] = "Převést Flash odkazy";
$GLOBALS['strHardcodedLinks'] = "Pevné odkazy";
$GLOBALS['strCompressSWF'] = "Komprimovat SWF soubor pro rychlejší stahování (vyžaduje přehrávač Flash 6)";
$GLOBALS['strOverwriteSource'] = "Přepsat zdrojový parametr";

// Display limitations
$GLOBALS['strModifyBannerAcl'] = "Nastavení doručování";
$GLOBALS['strACL'] = "Doručování";
$GLOBALS['strACLAdd'] = "Přidat omezení";
$GLOBALS['strNoLimitations'] = "Bez omezení";
$GLOBALS['strApplyLimitationsTo'] = "Aplikovat omezení na";
$GLOBALS['strRemoveAllLimitations'] = "Odstranit všechna omezení";
$GLOBALS['strEqualTo'] = "je rovno";
$GLOBALS['strDifferentFrom'] = "liší se od";
$GLOBALS['strGreaterThan'] = "je později než";
$GLOBALS['strAND'] = "A";                          // logical operator
$GLOBALS['strOR'] = "NEBO";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Zobrazit tento banner pouze:";
$GLOBALS['strWeekDays'] = "V pracovní den";
$GLOBALS['strSource'] = "Zdroj";
$GLOBALS['strDeliveryLimitations'] = "Omezení doručování";


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
$GLOBALS['strAffiliates'] = "Vydavatelé";
$GLOBALS['strAffiliatesAndZones'] = "Vydavatelé & Zóny";
$GLOBALS['strAddNewAffiliate'] = "Přidat vydavatele";
$GLOBALS['strAffiliateProperties'] = "Nastavení vydavatele";
$GLOBALS['strAffiliateHistory'] = "Historie vydavatele";
$GLOBALS['strNoAffiliates'] = "V tuto chvíli nejsou zadáni žádní vydavatelé";
$GLOBALS['strConfirmDeleteAffiliate'] = "Opravdu si přejete smazat tohoto vydavatele?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Opravdu si přejete smazat tohoto vydavatele?";
$GLOBALS['strInactiveAffiliatesHidden'] = "neaktivních bannerů skryto";

// Website (properties)
$GLOBALS['strAllowAffiliateModifyZones'] = "Povolit tomuto uživateli měnit vlastní zóny";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Povolit tomuto uživateli připojovat vlastní bannery k zónám";
$GLOBALS['strAllowAffiliateAddZone'] = "Povolit tomuto uživateli přidávat vlastní zóny";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Povolit tomuto uživateli mazat existující zóny";

// Website (properties - payment information)
$GLOBALS['strCountry'] = "Země";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Vydavatelé & Zóny";

// Zone
$GLOBALS['strZone'] = "Zóna";
$GLOBALS['strZones'] = "Zóny";
$GLOBALS['strAddNewZone'] = "Přidat zónu";
$GLOBALS['strAddNewZone_Key'] = "Přidat <u>z</u>ónu";
$GLOBALS['strLinkedZones'] = "Připojené zóny";
$GLOBALS['strZoneProperties'] = "Nastavení zóny";
$GLOBALS['strZoneHistory'] = "Historie zóny";
$GLOBALS['strNoZones'] = "Zatím nejsou definované žádné zóny";
$GLOBALS['strConfirmDeleteZone'] = "Opravdu chcete smazat tuto zónu?";
$GLOBALS['strConfirmDeleteZones'] = "Opravdu chcete smazat tuto zónu?";
$GLOBALS['strZoneType'] = "Typ zóny";
$GLOBALS['strBannerButtonRectangle'] = "Banner, Button nebo Čtverec";
$GLOBALS['strInterstitial'] = "Interstitial nebo Plovoucí DHTML";
$GLOBALS['strTextAdZone'] = "Textová reklama";
$GLOBALS['strShowMatchingBanners'] = "Zobrazit odpovídající bannery";
$GLOBALS['strHideMatchingBanners'] = "Skrýt odpovídající bannery";
$GLOBALS['strInactiveZonesHidden'] = "neaktivních bannerů skryto";


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
$GLOBALS['strStatusDuplicate'] = "Duplikovat";

// Statistics
$GLOBALS['strStats'] = "Statistiky";
$GLOBALS['strNoStats'] = "V tuto chvíli nejsou k dispozici žádné statistiky";
$GLOBALS['strGlobalHistory'] = "Globální historie";
$GLOBALS['strDailyHistory'] = "Denní historie";
$GLOBALS['strDailyStats'] = "Denní statistiky";
$GLOBALS['strWeeklyHistory'] = "Týdenní historie";
$GLOBALS['strMonthlyHistory'] = "Měsíční historie";
$GLOBALS['strTotalThisPeriod'] = "Celkem v tomto období";
$GLOBALS['strPublisherDistribution'] = "Rozdělení vydavatelů";
$GLOBALS['strBreakdownByDay'] = "Den";
$GLOBALS['strBreakdownByWeek'] = "Týden";
$GLOBALS['strBreakdownByMonth'] = "Měsíců";
$GLOBALS['strBreakdownByHour'] = "Hodina";

// Expiration
$GLOBALS['strNoExpiration'] = "Není zadáno datum expirace";
$GLOBALS['strEstimated'] = "Předpokládaná expirace";
$GLOBALS['strCampaignStop'] = "Historie kampaně";

// Reports
$GLOBALS['strPeriod'] = "Období";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "Celkem inzerentů";

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


// Errors
$GLOBALS['strNoMatchesFound'] = "Žedné odpovídající záznamy nebyly nalezeny";
$GLOBALS['strErrorOccurred'] = "Nastala chyba";
$GLOBALS['strErrorDBPlain'] = "Nastala chyba při přístupu do databáze";
$GLOBALS['strErrorDBSerious'] = "Byl zjištěn závažný problém při přístupu do databáze";
$GLOBALS['strErrorDBCorrupt'] = "Databázová tabulka je pravděpodobně poškozena a potřebuje opravit. Pro více informací o opravování poškozených tabulek prosím čtěte kapitolu <i>Troubleshooting</i> v příručce <i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact'] = "Prosím kontaktujte správce tohoto serveru a oznamte jemu nebo jí tento problém.";

//Validation

// Email
$GLOBALS['strMailSubject'] = "Prehled inzerenta";
$GLOBALS['strMailBannerStats'] = "Nize najdete statistiky banneru pro {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Kampaň aktivována";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Kampaň {id} aktivována";
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

// Priority
$GLOBALS['strPriority'] = "Priorita";
$GLOBALS['strSourceEdit'] = "Upravit zdroje";

// Preferences
$GLOBALS['strPreferences'] = "Předvolby";

// Long names

// Short names
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strClicks_short'] = "Kliknutí";

// Global Settings
$GLOBALS['strGlobalSettings'] = "Základní nastavení";
$GLOBALS['strGeneralSettings'] = "Obecná nastavení";
$GLOBALS['strMainSettings'] = "Základní nastavení";

// Product Updates
$GLOBALS['strProductUpdates'] = "Aktualizace produktu";

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

// Channels
$GLOBALS['strNoChannels'] = "Zatím nejsou definovány žádné bannery";
$GLOBALS['strChannelLimitations'] = "Nastavení doručování";
$GLOBALS['strConfirmDeleteChannel'] = "Opravdu chcete smazat tento banner?";
$GLOBALS['strConfirmDeleteChannels'] = "Opravdu chcete smazat tento banner?";

// Tracker Variables
$GLOBALS['strVariableName'] = "Název proměnné";
$GLOBALS['strVariableDescription'] = "Popis";
$GLOBALS['strVariableDataType'] = "Datový typ";
$GLOBALS['strTrackFollowingVars'] = "Sledovat tuto proměnnou";
$GLOBALS['strAddVariable'] = "Přidat proměnnou";
$GLOBALS['strNoVarsToTrack'] = "Žádné proměnné ke sledování.";

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
$GLOBALS['keyPreviousItem'] = " ";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
