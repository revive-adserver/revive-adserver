<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/


// Set text direction and characterset
$GLOBALS['phpAds_TextDirection'] 		= "ltr";
$GLOBALS['phpAds_TextAlignRight'] 		= "right";
$GLOBALS['phpAds_TextAlignLeft'] 		= "left";

$GLOBALS['phpAds_DecimalPoint']	 		= ',';
$GLOBALS['phpAds_ThousandsSeperator'] 		= ' ';


// Date & time configuration
$GLOBALS['date_format'] 			= "%d.%m.%Y";
$GLOBALS['time_format'] 			= "%H:%M:%S";
$GLOBALS['minute_format'] 			= "%H:%M";
$GLOBALS['month_format'] 			= "%m.%Y";
$GLOBALS['day_format'] 				= "%d.%m";
$GLOBALS['week_format'] 			= "%W.%Y";
$GLOBALS['weekiso_format'] 			= "%V.%G";



/*********************************************************/
/* Translations                                          */
/*********************************************************/


$GLOBALS['strHome']				= "Home";
$GLOBALS['strHelp']				= "Nápověda";
$GLOBALS['strNavigation']			= "Navigace";
$GLOBALS['strShortcuts']			= "Zkratka";
$GLOBALS['strAdminstration']			= "Inventář";
$GLOBALS['strMaintenance']			= "Správa";
$GLOBALS['strProbability']			= "Pravděpodobnost";
$GLOBALS['strInvocationcode']			= "Zobrazovací kód";
$GLOBALS['strTrackerVariables']			= "Proměnné Sledova�?e";
$GLOBALS['strBasicInformation']			= "Základní údaje";
$GLOBALS['strContractInformation']		= "Obchodní údaje";
$GLOBALS['strLoginInformation']			= "Přihlašovací údaje";
$GLOBALS['strOverview']				= "Přehled";
$GLOBALS['strSearch']				= "<u>V</u>yhledávání";
$GLOBALS['strHistory']				= "Historie";
$GLOBALS['strPreferences']			= "Předvolby";
$GLOBALS['strDetails']				= "Detaily";
$GLOBALS['strCompact']				= "Kompaktní";
$GLOBALS['strVerbose']				= "Podrobné";
$GLOBALS['strUser']				= "Uživatel";
$GLOBALS['strEdit']				= "Upravit";
$GLOBALS['strCreate']				= "Vytvořit";
$GLOBALS['strDuplicate']			= "Duplikovat";
$GLOBALS['strMoveTo']				= "Přesunout";
$GLOBALS['strDelete']				= "Smazat";
$GLOBALS['strActivate']				= "Aktivovat";
$GLOBALS['strDeActivate']			= "Deaktivovat";
$GLOBALS['strConvert']				= "Konvertovat";
$GLOBALS['strRefresh']				= "Obnovit";
$GLOBALS['strSaveChanges']			= "Uložit změny";
$GLOBALS['strUp']				= "Nahoru";
$GLOBALS['strDown']				= "Dolů";
$GLOBALS['strSave']				= "Uložit";
$GLOBALS['strCancel']				= "Zrušit";
$GLOBALS['strPrevious']				= "Předchozí";
$GLOBALS['strPrevious_Key']			= "<u>P</u>ředchozí";
$GLOBALS['strNext']				= "Následující";
$GLOBALS['strNext_Key']				= "<u>N</u>ásledující";
$GLOBALS['strYes']				= "Ano";
$GLOBALS['strNo']				= "Ne";
$GLOBALS['strNone']				= "Žádné";
$GLOBALS['strCustom']				= "Vlastní";
$GLOBALS['strDefault']				= "Implicitní";
$GLOBALS['strOther']				= "Jiné";
$GLOBALS['strUnknown']				= "Neznámé";
$GLOBALS['strUnlimited']			= "Neomezené";
$GLOBALS['strUntitled']				= "Bezejména";
$GLOBALS['strAll']				= "všechny";
$GLOBALS['strAvg']				= "Prům.";
$GLOBALS['strAverage']				= "Průměr";
$GLOBALS['strOverall']				= "Celkový přehled";
$GLOBALS['strTotal']				= "Celkem";
$GLOBALS['strUnfilteredTotal']			= "Total (nefiltrovaných)";
$GLOBALS['strFilteredTotal']			= "Total (filtrovaných)";
$GLOBALS['strActive']				= "aktivní";
$GLOBALS['strFrom']				= "Od";
$GLOBALS['strTo']				= "do";
$GLOBALS['strLinkedTo']				= "připojení k";
$GLOBALS['strDaysLeft']				= "Zbývá dnů";
$GLOBALS['strCheckAllNone']			= "Ozna�?it vše / nic";
$GLOBALS['strKiloByte']				= "KB";
$GLOBALS['strExpandAll']			= "<u>R</u>ozšířit vše";
$GLOBALS['strCollapseAll']			= "<u>S</u>lou�?it vše";
$GLOBALS['strShowAll']				= "Ukázat vše";
$GLOBALS['strNoAdminInteface']			= "Služba není dostupná...";
$GLOBALS['strFilterBySource']			= "filtrovat podle zdroje";
$GLOBALS['strFieldContainsErrors']		= "Následující položky obsahují chyby:";
$GLOBALS['strFieldFixBeforeContinue1']		= "Než budete moci pokra�?ovat potřebujete";
$GLOBALS['strFieldFixBeforeContinue2']		= "opravit tyto chyby.";
$GLOBALS['strDelimiter']			= "Oddělova�?";
$GLOBALS['strMiscellaneous']			= "Různé";
$GLOBALS['strCollectedAllStats']		= "Všechny statistiky";
$GLOBALS['strCollectedToday']			= "Dnes";
$GLOBALS['strCollectedYesterday']		= "V�?era";
$GLOBALS['strCollectedThisWeek']		= "Tento týden (Po-Ne)";
$GLOBALS['strCollectedLastWeek']		= "Minulý týden (Po-Ne)";
$GLOBALS['strCollectedThisMonth']		= "Tento měsíc";
$GLOBALS['strCollectedLastMonth']		= "Minulý měsíc";
$GLOBALS['strCollectedLast7Days']		= "Posledních 7 dní";

// Priority
$GLOBALS['strPriority']				= "Priorita";
$GLOBALS['strPriorityLevel']			= "Úroveň priority";
$GLOBALS['strPriorityTargeting']		= "Distribuce";
$GLOBALS['strPriorityOptimisation']		= "Různé";



// Properties
$GLOBALS['strName']				= "Jméno";
$GLOBALS['strSize']				= "Velikost";
$GLOBALS['strWidth']				= "Šířka";
$GLOBALS['strHeight']				= "Výška";
$GLOBALS['strURL2']				= "URL";
$GLOBALS['strTarget']				= "Cíl";
$GLOBALS['strLanguage']				= "Jazyk";
$GLOBALS['strDescription']			= "Popis";
$GLOBALS['strVariables']			= "Proměnné";
$GLOBALS['strID']				= "ID";


// Login & Permissions
$GLOBALS['strAuthentification']			= "Autentifikace";
$GLOBALS['strWelcomeTo']			= "Vítejte do";
$GLOBALS['strEnterUsername']			= "Pro přihlásení zadejte vaše uživatelské jméno a heslo";
$GLOBALS['strEnterBoth']			= "Prosím zadejte vaše jméno i heslo";
$GLOBALS['strEnableCookies']			= "Musíte povolit cookees než budete moci používat ".MAX_PRODUCT_NAME;
$GLOBALS['strLogin']				= "Přihlásit";
$GLOBALS['strLogout']				= "Odhlásit";
$GLOBALS['strUsername']				= "Jméno";
$GLOBALS['strPassword']				= "Heslo";
$GLOBALS['strAccessDenied']			= "Přístup odepřen";
$GLOBALS['strPasswordWrong']			= "Toto není správné heslo";
$GLOBALS['strParametersWrong']			= "Parametry, které jste zadal nejsou správné";
$GLOBALS['strNotAdmin']				= "Zřejmě nemáte dostate�?né oprávnění";
$GLOBALS['strDuplicateClientName']		= "Zadané uživatelské jméno již existuje. Prosím zadejte jiné jméno.";
$GLOBALS['strDuplicateAgencyName']		= "Zadané uživatelské jméno již existuje. Prosím zadejte jiné jméno.";
$GLOBALS['strInvalidPassword']			= "Zadané heslo je špatné. Prosím zadejte jiné heslo.";
$GLOBALS['strNotSamePasswords']			= "Dvě hesla která jste zadal nejsou stejná.";
$GLOBALS['strRepeatPassword']			= "Zopakujte heslo";
$GLOBALS['strOldPassword']			= "Staré heslo";
$GLOBALS['strNewPassword']			= "Nové heslo";



// General advertising
$GLOBALS['strViews']				= "Zobrazení";
$GLOBALS['strClicks']				= "Kliknutí";
$GLOBALS['strConversions']			= "Prodeje";
$GLOBALS['strCTRShort']                         = "CTR";
$GLOBALS['strCNVRShort'] 			= "SR";
$GLOBALS['strCTR']				= "CTR";
$GLOBALS['strCNVR'] 				= "Poměr prodeje";
$GLOBALS['strCPC']	 			= "Náklad na klik";
$GLOBALS['strCPCo']				= "Náklad na prodej";
$GLOBALS['strCPCoShort']	 		= "CPCo";
$GLOBALS['strCPCShort']	 			= "CPC";
$GLOBALS['strTotalCost']	 		= "Celkem náklady";
$GLOBALS['strTotalViews']			= "Celkem zobrazení";
$GLOBALS['strTotalClicks']			= "Celkem kliknutí";
$GLOBALS['strTotalConversions']			= "Celkem prodejů";
$GLOBALS['strViewCredits']			= "Kreditůzobrazení";
$GLOBALS['strClickCredits']			= "Kredit kliknutí";
$GLOBALS['strConversionCredits']		= "Kredit prodeje";
$GLOBALS['strImportStats']			= "Import statistik";


// Time and date related
$GLOBALS['strDate']				= "Datum";
$GLOBALS['strToday']				= "Dnes";
$GLOBALS['strDay']				= "Den";
$GLOBALS['strDays']				= "Dní";
$GLOBALS['strLast7Days']			= "Posledních 7 dní";
$GLOBALS['strWeek']				= "Týden";
$GLOBALS['strWeeks']				= "Týdnů";
$GLOBALS['strMonths']				= "Měsíců";
$GLOBALS['strThisMonth']			= "Tento měsíc";
$GLOBALS['strMonth'][0] = "Leden";
$GLOBALS['strMonth'][1] = "Únor";
$GLOBALS['strMonth'][2] = "Březen";
$GLOBALS['strMonth'][3] = "Duben";
$GLOBALS['strMonth'][4] = "Květen";
$GLOBALS['strMonth'][5] = "Červen";
$GLOBALS['strMonth'][6] = "Červenec";
$GLOBALS['strMonth'][7] = "Srpen";
$GLOBALS['strMonth'][8] = "Září";
$GLOBALS['strMonth'][9] = "Říjen";
$GLOBALS['strMonth'][10] = "Listopad";
$GLOBALS['strMonth'][11] = "Prosinec";

$GLOBALS['strDayShortCuts'][0] = "Ne";
$GLOBALS['strDayShortCuts'][1] = "Po";
$GLOBALS['strDayShortCuts'][2] = "Út";
$GLOBALS['strDayShortCuts'][3] = "St";
$GLOBALS['strDayShortCuts'][4] = "Čt";
$GLOBALS['strDayShortCuts'][5] = "Pá";
$GLOBALS['strDayShortCuts'][6] = "So";

$GLOBALS['strHour']				= "Hodina";
$GLOBALS['strHourFilter']			= "Filtr hodin";
$GLOBALS['strSeconds']				= "vteřin";
$GLOBALS['strMinutes']				= "minut";
$GLOBALS['strHours']				= "hodin";
$GLOBALS['strTimes']				= "krát";


// Advertiser
$GLOBALS['strClient']				= "Inzerent";
$GLOBALS['strClients']				= "Inzerenti";
$GLOBALS['strClientsAndCampaigns']		= "Inzerenti & Kampaně";
$GLOBALS['strAddClient']			= "Přidat inzerenta";
$GLOBALS['strAddClient_Key']			= "Přidat <u>i</u>nzerenta";
$GLOBALS['strTotalClients']			= "Celkem inzerentů";
$GLOBALS['strClientProperties']			= "Nastavení inzerenta";
$GLOBALS['strClientHistory']			= "Historie inzerenta";
$GLOBALS['strNoClients']                        = "Zatím nejsou definování žádní inzerenti";
$GLOBALS['strConfirmDeleteClient']		= "Opravdu chcete smazat tohoto inzerenta?";
$GLOBALS['strConfirmResetClientStats']		= "Opravdu chcete smazat všechny existující statistiky tohoto inzerenta?";
$GLOBALS['strHideInactiveAdvertisers']		= "Skrýt neaktivní inzerenty";
$GLOBALS['strInactiveAdvertisersHidden']        = "nekativních inzerent(ů) skryto";
$GLOBALS['strHideInactiveCampaigns']		= "Skrýt neaktivní kampaně";
$GLOBALS['strInactiveCampaignsHidden']		= "neaktivních kampaní skryto";
$GLOBALS['strHideInactivePublishers']		= "Skrýt neaktivní vydavatele";
$GLOBALS['strInactivePublishersHidden']		= "neaktivních vydavatelů skryto";


// Advertisers properties
$GLOBALS['strContact']				= "Kontakt";
$GLOBALS['strEMail']				= "E-mail";
$GLOBALS['strSendAdvertisingReport']		= "Zaslat přehled inzerce e-mailem";
$GLOBALS['strNoDaysBetweenReports']		= "Po�?et dní mezi přehledy";
$GLOBALS['strSendDeactivationWarning']		= "Zaslat upozornění při deaktivaci kampaně";
$GLOBALS['strAllowClientModifyInfo']		= "Povolit tomuto uživateli měnit vlastní nastavení";
$GLOBALS['strAllowClientModifyBanner']		= "Povolit uživateli měnit vlastní bannery";
$GLOBALS['strAllowClientAddBanner']		= "Povolit uživateli vkládat vlastní bannery";
$GLOBALS['strAllowClientDisableBanner']		= "Povolit uživateli deaktivovat vlastní bannery";
$GLOBALS['strAllowClientActivateBanner']	= "Povolit uživateli aktivovat vlastní bannery";
$GLOBALS['strAllowClientViewTargetingStats']	= "Povolit uživateli prohlížet statistiky cílení";


// Campaign
$GLOBALS['strCampaign']				= "Skrytá kampaň";
$GLOBALS['strCampaigns']			= "Skrytá kampaň";
$GLOBALS['strTotalCampaigns']			= "Celkem kampaní";
$GLOBALS['strActiveCampaigns']			= "Aktivních kampaní";
$GLOBALS['strAddCampaign']			= "Přidat kampaň";
$GLOBALS['strAddCampaign_Key']			= "Přidat <u>k</u>ampaň";
$GLOBALS['strCreateNewCampaign']		= "Vytvořit novou kampaň";
$GLOBALS['strModifyCampaign']			= "Upravit kampaň";
$GLOBALS['strMoveToNewCampaign']                = "Přesunout do nové kampaně";
$GLOBALS['strBannersWithoutCampaign']		= "Bannery bez kampaně";
$GLOBALS['strDeleteAllCampaigns']		= "Smazat všechny kampaně";
$GLOBALS['strLinkedCampaigns']			= "Připojené kampaně";
$GLOBALS['strCampaignStats']			= "Statistiky kampaně";
$GLOBALS['strCampaignProperties']		= "Nastavení kampaně";
$GLOBALS['strCampaignOverview']			= "Přehled kampaně";
$GLOBALS['strCampaignHistory']			= "Historie kampaně";
$GLOBALS['strNoCampaigns']			= "V tuto chvíli nejsou definované žádné kampaně";
$GLOBALS['strConfirmDeleteAllCampaigns']        = "Opravdu chcete smazat všechny kampaně tohoto inzerenta?";
$GLOBALS['strConfirmDeleteCampaign']		= "Opravdu chcete smazat tuto kampaň?";
$GLOBALS['strConfirmResetCampaignStats']	= "Opravdu chcete smazat všechny statistiky pro tuto kampaň?";
$GLOBALS['strHideInactiveCampaigns']		= "Skrýt neaktivní kampaně";
$GLOBALS['strInactiveCampaignsHidden']		= "neaktivních kampaní skryto";
$GLOBALS['strContractDetails']			= "Detail zakázky";
$GLOBALS['strInventoryDetails']			= "Detail inventáře";
$GLOBALS['strPriorityInformation']		= "Informace o prioritě";
$GLOBALS['strPriorityHigh']			= "Vysoká - placené kampaně";
$GLOBALS['strPriorityMedium']			= "Střední - velkoprodej a důleité kampaně";
$GLOBALS['strPriorityLow']			= "Nízká - vlastní a neplacené kampaně";
$GLOBALS['strHiddenCampaign']			= "Skrytá kampaň";
$GLOBALS['strUnderdeliveringCampaigns']		= "Neplnící kampaně";
$GLOBALS['strCampaignDelivery']			= "Doru�?ování kampaně";


// Campaign properties
$GLOBALS['strDontExpire']			= "Tato kampaň nikdy automaticky neexpiruje";
$GLOBALS['strActivateNow']			= "Okamžitě aktivovat tuto kampaň";
$GLOBALS['strLow']				= "Nízká";
$GLOBALS['strHigh']				= "Vysoká";
$GLOBALS['strExpirationDate']			= "Koncové datum";
$GLOBALS['strExpirationDateComment']		= "Kampaňskon�?í na konci tohoto dne";
$GLOBALS['strActivationDate']			= "Po�?áte�?ní datum";
$GLOBALS['strActivationDateComment']		= "Kampaň za�?ne na za�?atku tohoto dne";
$GLOBALS['strViewsPurchased']			= "Objednaných zobrazení";
$GLOBALS['strClicksPurchased']			= "Objednaných kliknutí";
$GLOBALS['strConversionsPurchased']		= "Objednaných prodejů";
$GLOBALS['strCampaignWeight']			= "Váha kampaně";
$GLOBALS['strOptimise']				= "Optimalizace";
$GLOBALS['strAnonymous']			= "Skrýt inzerenta a vydavatele této kampaně.";
$GLOBALS['strHighPriority']			= "Zobrazit bannery této kampaně s vysokou prioritou.<br>Pokud použijete tuto volbu, systém se pokusí distribuovat požadovaný po�?et zobrazení rovnoměrně po celý den.";
$GLOBALS['strLowPriority']			= "Zobrazit bannery této kampaně s nízkou prioritou.<br> Tato kampaň se používá pro zbytková zobrazení, která nejsou využita kampaněmi s vysokou prioritou.";
$GLOBALS['strTargetLimitAdviews']		= "Omezit po�?et AdViews na";
$GLOBALS['strTargetPerDay']			= "za den.";
$GLOBALS['strPriorityAutoTargeting']		= "Distribuovat zbývající po�?et AdViews rovnoměrně na zbývající dny. Zbývající po�?et AdViews bude vypo�?ítán přiměřeně každý den.";
$GLOBALS['strCampaignWarningNoWeight']		= "Priorita této kampaně byla nastavena na nízkou, \nale váha byla nastavena na nulu nebo nebyla \nzadána. Takto bude kampaň okamžitě \ndeaktivována a její bannery nebudou doru�?eny \ndokud její váha nebude nastavena na platné �?íslo. \n\nJste si jist že chcete pokra�?ovat?";
$GLOBALS['strCampaignWarningNoTarget']		= "Priorita této kampaně byla nastavena na vysokou, \nale cílový po�?et AdViews nebyl zadán. \nTakto bude kampaň okamžitě deaktivována a\njejí bannery nebudou doru�?eny dokdu nebude \nnastaven platný po�?et AdViews. \n\nJste si jist že chcete pokra�?ovat?";


// Tracker
$GLOBALS['strTracker']				= "Sledova�?";
$GLOBALS['strTrackerOverview']			= "Přehled sledova�?e";
$GLOBALS['strAddTracker'] 			= "Přidat nový sledova�?";
$GLOBALS['strAddTracker_Key'] 			= "Přidat <u>n</u>ový sledova�?";
$GLOBALS['strNoTrackers']			= "V tuto chvíli nejsou definovány ádné sledova�?e";
$GLOBALS['strConfirmDeleteAllTrackers']		= "Opravdu chcete smazat všechny sledova�?e tohoto inzerenta?";
$GLOBALS['strConfirmDeleteTracker']		= "Opravdu chcete smazat tento sledova�??";
$GLOBALS['strDeleteAllTrackers']		= "Smazat všechny sledova�?e";
$GLOBALS['strTrackerProperties']		= "Vlastnosti sledova�?e";
$GLOBALS['strTrackerOverview']			= "Přehled sledova�?e";
$GLOBALS['strModifyTracker']			= "Upravit sledova�?";
$GLOBALS['strLog']				= "Log?";
$GLOBALS['strLinkedTrackers']			= "Připojené sledova�?e";
$GLOBALS['strDefaultConversionRules']		= "Implicitní pravidla prodeje";
$GLOBALS['strConversionWindow']			= "Okno převodu";
$GLOBALS['strClickWindow']			= "Okno kliknutí";
$GLOBALS['strViewWindow']			= "Okno zobrazení";
$GLOBALS['strClick']				= "Klik";
$GLOBALS['strView']				= "Zobrazení";
$GLOBALS['strConversionClickWindow']		= "Měřit prodeje které proběhnou během uvedeného �?asového rozmezí (vteřin) od kliknutí";
$GLOBALS['strConversionViewWindow']		= "Měřit prodeje které proběhnou během uvedeného �?asového rozmezí (vteřin) od zobrazení";
$GLOBALS['strTotalTrackerImpressions']		= "Celkem zobrazení";
$GLOBALS['strTotalTrackerConnections']		= "Celkem spojení";
$GLOBALS['strTotalTrackerConversions']		= "Celkem prodejů";
$GLOBALS['strTrackerImpressions']		= "Zobrazení";
$GLOBALS['strTrackerImprConnections']		= "Spojení zobrazení";
$GLOBALS['strTrackerClickConnections']		= "Spojení kliknutí";
$GLOBALS['strTrackerImprConversions']		= "Prodejních zobrazení";
$GLOBALS['strTrackerClickConversions']		= "Prodejních kliknutí";

// Banners (General)
$GLOBALS['strBanner']				= "Banner";
$GLOBALS['strBanners']				= "Bannery";
$GLOBALS['strBannerFilter']			= "Filtr bannerů";
$GLOBALS['strAddBanner']			= "Přidat banner";
$GLOBALS['strAddBanner_Key']			= "Přidat <u>b</u>anner";
$GLOBALS['strModifyBanner']			= "Upravit banner";
$GLOBALS['strActiveBanners']			= "Aktivních bannerů";
$GLOBALS['strTotalBanners']			= "Celkem bannerů";
$GLOBALS['strShowBanner']			= "Zobrazit banner";
$GLOBALS['strShowAllBanners']			= "Zobrazit všechny bannery";
$GLOBALS['strShowBannersNoAdClicks']		= "Zobrazit bannery bez kliknutů";
$GLOBALS['strShowBannersNoAdViews']		= "Zobrazit bannery bez zobrazení";
$GLOBALS['strShowBannersNoAdConversions']	= "Zobrazit bannery bez prodeje";
$GLOBALS['strDeleteAllBanners']			= "Smazat všechny bannery";
$GLOBALS['strActivateAllBanners']		= "Aktivovat všechny bannery";
$GLOBALS['strDeactivateAllBanners']		= "Deaktivovat všechny bannery";
$GLOBALS['strBannerOverview']			= "Přehled bannerů";
$GLOBALS['strBannerProperties']			= "Nastavení banneru";
$GLOBALS['strBannerHistory']			= "Historie banneru";
$GLOBALS['strBannerNoStats']			= "Pro tento banner zatím nejsou žádné statistiky";
$GLOBALS['strNoBanners']			= "Zatím nejsou definovány žádné bannery";
$GLOBALS['strConfirmDeleteBanner']		= "Opravdu chcete smazat tento banner?";
$GLOBALS['strConfirmDeleteAllBanners']		= "Opravdu chcete smazat všechny bannery které patří k této kampani?";
$GLOBALS['strConfirmResetBannerStats']		= "Opravdu chcete smazat všechny statistiky tohoto banneru?";
$GLOBALS['strShowParentCampaigns']		= "Zobrazit nadřazené kampaně";
$GLOBALS['strHideParentCampaigns']		= "Skrýt nadřazené kampaně";
$GLOBALS['strHideInactiveBanners']		= "Skrýt neaktivní bannery";
$GLOBALS['strInactiveBannersHidden']		= "neaktivních bannerů skryto";
$GLOBALS['strAppendOthers']			= "Připojit jiné";
$GLOBALS['strAppendTextAdNotPossible']		= "Není možné připojit jiné bannery k textové reklamě.";
$GLOBALS['strHiddenBanner']			= "Skrytý banner";
$GLOBALS['strConfirmDeactivate']		= "Tato změna deaktivuje tento banner dokud nebude zkontrolován partnerem.";


// Banner (Properties)
$GLOBALS['strChooseBanner']			= "Prosím vyberte typ banneru";
$GLOBALS['strMySQLBanner']			= "Lokální banner (SQL)";
$GLOBALS['strWebBanner']			= "Lokální banner (Webserver)";
$GLOBALS['strURLBanner']			= "Externí banner";
$GLOBALS['strHTMLBanner']			= "HTML banner";
$GLOBALS['strTextBanner']			= "Textová reklama";
$GLOBALS['strAutoChangeHTML']			= "Upravit HTML aby bylo možné sledovat AdClicks";
$GLOBALS['strUploadOrKeep']			= "Přejete se zachovat <br>sou�?asný obrázek, nebo <br>chcete nahrát jiný?";
$GLOBALS['strUploadOrKeepAlt']			= "Přejete se zachovat <br>sou�?asný alternativní obrázek, nebo <br>chcete nahrát jiný?";
$GLOBALS['strNewBannerFile']			= "Zvolte obrázek, který <br>chcete použít pro tento banner<br><br>";
$GLOBALS['strNewBannerFileAlt']			= "Vyberte alternativní obrázek, který <br>chcete použít pro prohlíže�?e,<br>které nepodporují rich-media<br><br>";
$GLOBALS['strNewBannerURL']			= "URL obrázku (v�?etně http://)";
$GLOBALS['strURL']				= "Cílová URL (incl. http://)";
$GLOBALS['strHTML']				= "HTML";
$GLOBALS['strTextBelow']			= "Text pod obrázkem";
$GLOBALS['strKeyword']				= "Klí�?ová slova";
$GLOBALS['strWeight']				= "Váha";
$GLOBALS['strAlt']				= "Alt text";
$GLOBALS['strStatusText']			= "Stavový text";
$GLOBALS['strBannerWeight']			= "Váha banneru";


// Banner (swf)
$GLOBALS['strCheckSWF']				= "Převést pevné odkazy uvnitř Flash souboru";
$GLOBALS['strConvertSWFLinks']			= "Převést Flash odkazy";
$GLOBALS['strHardcodedLinks']			= "Pevné odkazy";
$GLOBALS['strConvertSWF']			= "<br>Flash soubor, který jste právě vložil obsahuje pevné odkazy. Systém nebude schopen po�?ítat AdClicks pro tento banner dokud nepřevedete tyto pevné odkazy. Níže najdete seznam odkazů nalezených uvnitř Flash souboru. Pokud si přejete převést odkazy jednoduše klikněte na <b>Převést</b>, jinak zvolte <b>Zrušit</b>.<br><br>Prosím nezapomeňte: pokud kliknete na <b>Převést</b>, Flash soubor který jste právě nahrál bude upraven. <br>Prosím uchovejte si záložní kopii původního souboru. Nezávisle na verzi ve které byl tento banner vytvořen, výsledný soubor bude potřebovat přehráva�? Flash 4 (nebo novější) aby se korektně zobrazil.<br><br>";
$GLOBALS['strCompressSWF']			= "Komprimovat SWF soubor pro rychlejší stahování (vyžaduje přehráva�? Flash 6)";
$GLOBALS['strOverwriteSource']			= "Přepsat zdrojový parametr";


// Banner (network)
$GLOBALS['strBannerNetwork']			= "HTML vzor";
$GLOBALS['strChooseNetwork']			= "Zvolte vzor který chcete použít";
$GLOBALS['strMoreInformation']			= "Více informací...";
$GLOBALS['strRichMedia']			= "Richmedia";
$GLOBALS['strTrackAdClicks']			= "Sledovat AdClicks";


// Display limitations
$GLOBALS['strModifyBannerAcl']			= "Nastavení doru�?ování";
$GLOBALS['strACL']				= "Doru�?ování";
$GLOBALS['strACLAdd']				= "Přidat omezení";
$GLOBALS['strACLAdd_Key']			= "Přidat <u>o</u>mezení";
$GLOBALS['strNoLimitations']			= "Bez omezení";
$GLOBALS['strApplyLimitationsTo']		= "Aplikovat omezení na";
$GLOBALS['strRemoveAllLimitations']		= "Odstranit všechna omezení";
$GLOBALS['strEqualTo']				= "je rovno";
$GLOBALS['strDifferentFrom']			= "liší se od";
$GLOBALS['strLaterThan']			= "je později než";
$GLOBALS['strLaterThanOrEqual']			= "je později nebo rovno";
$GLOBALS['strEarlierThan']			= "je dříve než";
$GLOBALS['strEarlierThanOrEqual']		= "je dříve nebo rovno";
$GLOBALS['strContains']				= "obsahuje";
$GLOBALS['strNotContains']			= "neobsahuje";
$GLOBALS['strAND']				= "A"; 			// logical operator
$GLOBALS['strOR']				= "NEBO"; 		// logical operator
$GLOBALS['strOnlyDisplayWhen']			= "Zobrazit tento banner pouze:";
$GLOBALS['strWeekDay']				= "V pracovní den";
$GLOBALS['strTime']				= "Čas";
$GLOBALS['strUserAgent']			= "Useragent";
$GLOBALS['strDomain']				= "Doména";
$GLOBALS['strClientIP']				= "IP klienta";
$GLOBALS['strSource']				= "Zdroj";
$GLOBALS['strSourceFilter']			= "Filtr zdroje";
$GLOBALS['strBrowser']				= "Prohlíže�?";
$GLOBALS['strOS']				= "OS";
$GLOBALS['strCountry']				= "Země";
$GLOBALS['strContinent']			= "Kontinent";
$GLOBALS['strUSState']				= "US stát";
$GLOBALS['strReferer']				= "Odkazující stránka";
$GLOBALS['strDeliveryLimitations']		= "Omezení doru�?ování";
$GLOBALS['strDeliveryCapping']			= "Upřesnění doru�?ování";
$GLOBALS['strTimeCapping']			= "Pokud již byl tento banner uživateli zobrazen, nezobrazovat tento banner uživateli po příštích:";
$GLOBALS['strImpressionCapping']		= "Nezobrazovat jednomu uživateli tento banner vícekrát než:";
$GLOBALS['strImpressionCappingSession']		= "Nezobrazovat tento banner běhěm jednoho sezení vícekrát než:";

// Publisher
$GLOBALS['strAffiliate']			= "Website";
$GLOBALS['strAffiliates']			= "Vydavatelé";
$GLOBALS['strAffiliatesAndZones']		= "Vydavatelé & Zóny";
$GLOBALS['strAddNewAffiliate']			= "Přidat vydavatele";
$GLOBALS['strAddNewAffiliate_Key']		= "Přidat <u>v</u>ydavatele";
$GLOBALS['strAddAffiliate']			= "Vytvořit vydavatele";
$GLOBALS['strAffiliateProperties']		= "Nastavení vydavatele";
$GLOBALS['strAffiliateOverview']		= "Přehled vydavatele";
$GLOBALS['strAffiliateHistory']			= "Historie vydavatele";
$GLOBALS['strZonesWithoutAffiliate']		= "Zóny bez vydavatele";
$GLOBALS['strMoveToNewAffiliate']		= "Přesunout k novému vydavateli";
$GLOBALS['strNoAffiliates']			= "V tuto chvíli nejsou zadáni žádní vydavatelé";
$GLOBALS['strConfirmDeleteAffiliate']		= "Opravdu si přejete smazat tohoto vydavatele?";
$GLOBALS['strMakePublisherPublic']		= "Zóny tohoto vydavatele nastavit jako veřejné";
$GLOBALS['strHiddenPublisher']			= "Website";
$GLOBALS['strAffiliateInvocation']		= "Zobrazovací kód";
$GLOBALS['strTotalAffiliates']			= "Celkem vydavatelů";


// Publisher (properties)
$GLOBALS['strWebsite']				= "Website";
$GLOBALS['strMnemonic']				= "Mnemonic";
$GLOBALS['strAllowAffiliateModifyInfo']		= "Povolit tomuto uživateli měnit vlastní nastavení";
$GLOBALS['strAllowAffiliateModifyZones']	= "Povolit tomuto uživateli měnit vlastní zóny";
$GLOBALS['strAllowAffiliateLinkBanners']	= "Povolit tomuto uživateli připojovat vlastní bannery k zónám";
$GLOBALS['strAllowAffiliateAddZone']		= "Povolit tomuto uživateli přidávat vlastní zóny";
$GLOBALS['strAllowAffiliateDeleteZone']         = "Povolit tomuto uživateli mazat existující zóny";


// Zone
$GLOBALS['strZone']				= "Zóna";
$GLOBALS['strZones']				= "Zóny";
$GLOBALS['strAddNewZone']			= "Přidat zónu";
$GLOBALS['strAddNewZone_Key']			= "Přidat <u>z</u>ónu";
$GLOBALS['strAddZone']				= "Vytvořit zónu";
$GLOBALS['strModifyZone']			= "Upravit zónu";
$GLOBALS['strLinkedZones']			= "Připojené zóny";
$GLOBALS['strZoneOverview']			= "Přehled zóny";
$GLOBALS['strZoneProperties']			= "Nastavení zóny";
$GLOBALS['strZoneHistory']			= "Historie zóny";
$GLOBALS['strNoZones']				= "Zatím nejsou definované žádné zóny";
$GLOBALS['strConfirmDeleteZone']		= "Opravdu chcete smazat tuto zónu?";
$GLOBALS['strZoneType']				= "Typ zóny";
$GLOBALS['strBannerButtonRectangle']		= "Banner, Button nebo Čtverec";
$GLOBALS['strInterstitial']			= "Interstitial nebo Plovoucí DHTML";
$GLOBALS['strPopup']				= "Popup";
$GLOBALS['strTextAdZone']			= "Textová reklama";
$GLOBALS['strShowMatchingBanners']		= "Zobrazit odpovídající bannery";
$GLOBALS['strHideMatchingBanners']		= "Skrýt odpovídající bannery";
$GLOBALS['strTotalZones']			= 'Celkem zón';


// Advanced zone settings
$GLOBALS['strAdvanced']				= "Rozšířené";
$GLOBALS['strChains']				= "Vazby";
$GLOBALS['strChainSettings']			= "Nastavení vazby";
$GLOBALS['strZoneNoDelivery']			= "Pokud žádné bannery z této zóny <br>nemohou být zobrazeny snaž se...";
$GLOBALS['strZoneStopDelivery']			= "Ukon�?i doru�?ování a nezobrazuj bannery";
$GLOBALS['strZoneOtherZone']			= "Zobraz místo toho jinou zónu";
$GLOBALS['strZoneUseKeywords']			= "Vyber banner na základě níže uvedených klí�?ových slov";
$GLOBALS['strZoneAppend']			= "Vždy přidej následující HTML kód k bannerům v této zóně";
$GLOBALS['strAppendSettings']			= "Nastavení přiložení a předložení";
$GLOBALS['strZonePrependHTML']			= "Vždy předlož HTML kód k textové inzerci v této zóně";
$GLOBALS['strZoneAppendHTML']			= "Vždy přilož HTML kód k textové inzerci v této zóně";
$GLOBALS['strZoneAppendType']			= "Druh připojení";
$GLOBALS['strZoneAppendHTMLCode']		= "HTML kód";
$GLOBALS['strZoneAppendZoneSelection']		= "Popup nebo interstitial";
$GLOBALS['strZoneAppendSelectZone']		= "Vždy přilož následující popup nebo intersitial k bannerům v této zóně";


// Zone probability
$GLOBALS['strZoneProbListChain']		= "Žádný z bannerů připojených k této zóně není aktivní. <br>Toto je vazba zóny která bude následována:";
$GLOBALS['strZoneProbNullPri']			= "Žádný z bannerů připojených k této zóně není aktivní.";
$GLOBALS['strZoneProbListChainLoop']		= "Následování vazeb zóny může vytvořit cyklickou smy�?ku. Doru�?ování pro tuto zónu je zastaveno.";


// Linked banners/campaigns
$GLOBALS['strSelectZoneType']			= "Prosím zvolte typ připojených bannerů";
$GLOBALS['strBannerSelection']			= "Volba banneru";
$GLOBALS['strCampaignSelection']		= "Volba kampaně";
$GLOBALS['strInteractive']			= "Interaktivní";
$GLOBALS['strRawQueryString']			= "Klí�?ové slovo";
$GLOBALS['strIncludedBanners']			= "Připojené bannery";
$GLOBALS['strLinkedBannersOverview']		= "Přehled připojených bannerů";
$GLOBALS['strLinkedBannerHistory']		= "Historie připojených bannerů";
$GLOBALS['strNoZonesToLink']			= "Nejsou k dispozici žádné zóny ke kterým by mohl být tento banner připojen";
$GLOBALS['strNoBannersToLink']			= "Nejsou k dispozici žádné bannery které by mohly být připojeny k této zoně";
$GLOBALS['strNoLinkedBanners']			= "Nejsou k dispozici žádné bannery připojené k této zóně";
$GLOBALS['strMatchingBanners']			= "{count} odpovídajících bannerů";
$GLOBALS['strNoCampaignsToLink']                = "Nejsou k dispozici žádné kampaně které by mohly být připojeny k této zóně";
$GLOBALS['strNoTrackersToLink']			= "Nejsou k dispozici žádné sledova�?e které by mohly být připojeny k této zóně";
$GLOBALS['strNoZonesToLinkToCampaign']		= "Nejsou k dispozici žádné zóny ke kterým by mohla být tato kampaň připojena";
$GLOBALS['strSelectBannerToLink']		= "Zvolte banner který chcete připojit k této zóně:";
$GLOBALS['strSelectCampaignToLink']		= "Zvolte kampaň kterou chcete připojit k této zóně:";
$GLOBALS['strSelectAdvertiser']			= 'Zvolte inzerenta';
$GLOBALS['strSelectPlacement']			= 'Zvolte kampaň';
$GLOBALS['strSelectAd']				= 'Zvolte banner';


// Statistics
$GLOBALS['strStats']				= "Statistiky";
$GLOBALS['strNoStats']				= "V tuto chvíli nejsou k dispozici žádné statistiky";
$GLOBALS['strConfirmResetStats']		= "Opravdu chcete smazat všechny existující statistiky?";
$GLOBALS['strGlobalHistory']			= "Globální historie";
$GLOBALS['strDailyHistory']			= "Denní historie";
$GLOBALS['strDailyStats']			= "Denní statistiky";
$GLOBALS['strWeeklyHistory']			= "Týdenní historie";
$GLOBALS['strMonthlyHistory']			= "Měsí�?ní historie";
$GLOBALS['strCreditStats']			= "Statistiky kreditů";
$GLOBALS['strDetailStats']			= "Detailní statistiky";
$GLOBALS['strTotalThisPeriod']			= "Celkem v tomto období";
$GLOBALS['strAverageThisPeriod']		= "Průměr v tomto odbobí";
$GLOBALS['strPublisherDistribution']		= "Rozdělení vydavatelů";
$GLOBALS['strDistribution']			= "Rozdělení";
$GLOBALS['strOptimise']				= "Optimalizace";
$GLOBALS['strKeywordStatistics']		= "Statistiky klí�?ových slov";
$GLOBALS['strResetStats']			= "Vynulovat statistiky";
$GLOBALS['strSourceStats']			= "Statistiky zdroje";
$GLOBALS['strSources']				= "Zdroje";
$GLOBALS['strAvailableSources']			= "Dostupné zdroje";
$GLOBALS['strSelectSource']			= "Zvolte zdroj který chcete vidět:";
$GLOBALS['strSizeDistribution']			= "Rozdělení podle velikosti";
$GLOBALS['strCountryDistribution']		= "Rozdělení podle země";
$GLOBALS['strEffectivity']			= "Úspěšnost";
$GLOBALS['strTargetStats']			= "Statistiky cílení";
$GLOBALS['strCampaignTarget']			= "Cílení";
$GLOBALS['strTargetRatio']			= "Poměr cílení";
$GLOBALS['strTargetModifiedDay']		= "Cílení bylo v průbehu dne upravováno a cílení nemůže být přesné";
$GLOBALS['strTargetModifiedWeek']		= "Cílení bylo v průbehu týdne upravováno a cílení nemůže být přesné";
$GLOBALS['strTargetModifiedMonth']		= "Cílení bylo v průbehu měsíce upravováno a cílení nemůže být přesné";
$GLOBALS['strNoTargetStats']			= "V tuto chvíli nejsou k dispozici žádné statistiky cílení";
$GLOBALS['strOVerall']				= "Celkové";
$GLOBALS['strByZone']				= "Podle zón";


// Hosts
$GLOBALS['strHosts']				= "Hosté";
$GLOBALS['strTopHosts']				= "Hosté s nejvyšším po�?tem dotazů";
$GLOBALS['strTopCountries']			= "Země s nejvyšším poštem dotazů";
$GLOBALS['strRecentHosts']			= "Poslední hosté";


// Expiration
$GLOBALS['strExpired']				= "Expirované";
$GLOBALS['strExpiration']			= "Expirace";
$GLOBALS['strNoExpiration']			= "Není zadáno datum expirace";
$GLOBALS['strEstimated']			= "Předpokládaná expirace";


// Reports
$GLOBALS['strReports']				= "Přehledy";
$GLOBALS['strSelectReport']			= "Vyberte přehled který chcete vygenerovat";
$GLOBALS['strStartDate']			= "Po�?áte�?ní datum";
$GLOBALS['strEndDate']				= "Koncové datum";


// Userlog
$GLOBALS['strUserLog']				= "Uživatelský log";
$GLOBALS['strUserLogDetails']			= "Datily uživatelského logu";
$GLOBALS['strDeleteLog']			= "Smazat log";
$GLOBALS['strAction']				= "Akce";
$GLOBALS['strNoActionsLogged']			= "Žádné akce se nelogují";


// Code generation
$GLOBALS['strGenerateBannercode']		= "Přímá volba";
$GLOBALS['strChooseInvocationType']		= "Prosím zvolte typ volání banneru";
$GLOBALS['strGenerate']				= "Vygenerovat";
$GLOBALS['strParameters']			= "Parametry";
$GLOBALS['strFrameSize']			= "Velikost frame";
$GLOBALS['strBannercode']			= "Kód banneru";
$GLOBALS['strTrackercode']			= "Kód sledova�?e";
$GLOBALS['strOptional']				= "volitelný";


// Errors
$GLOBALS['strMySQLError']			= "Chyba SQL:";
$GLOBALS['strLogErrorClients']			= "[phpAds] Nastala chyba při pokusu na�?íst inzerenty z databáze.";
$GLOBALS['strLogErrorBanners']			= "[phpAds] Nastala chyba při pokusu na�?íst bannery z databáze.";
$GLOBALS['strLogErrorViews']			= "[phpAds] Nastala chyba při pokusu na�?íst zobrazení z databáze.";
$GLOBALS['strLogErrorClicks']			= "[phpAds] Nastala chyba při pokusu na�?íst kliknutí z databáze.";
$GLOBALS['strLogErrorConversions']		= "[phpAds] Nastala chyba při pokusu na�?íst prodeje z databáze.";
$GLOBALS['strErrorViews']			= "Musíte zadat po�?et zobrazení nebo zvolit neomezený !";
$GLOBALS['strErrorNegViews']			= "Záporný po�?et zobrazní není povolen";
$GLOBALS['strErrorClicks']			= "Musíte zadat po�?et kliknutí nebo zvolit neomezený !";
$GLOBALS['strErrorNegClicks']			= "Záporný po�?et kliknutí není povolen";
$GLOBALS['strErrorConversions'] 		= "Musíte zadat po�?et prodejů nebo zvolit neomezený !";
$GLOBALS['strErrorNegConversions'] 		= "Záporný po�?et prodejů není povolen";
$GLOBALS['strNoMatchesFound']			= "Žedné odpovídající záznamy nebyly nalezeny";
$GLOBALS['strErrorOccurred']			= "Nastala chyba";
$GLOBALS['strErrorUploadSecurity']		= "Byl zjištěn potencionální bezpe�?ností problém, nahrávání ukon�?eno !";
$GLOBALS['strErrorUploadBasedir']		= "Nemohu otevřít nahraný soubor zřejmě z důvodu bezpe�?ného režimu nebo open_basedir omezení";
$GLOBALS['strErrorUploadUnknown']		= "Menohu otevřít nahraný soubor z neznámého důvodu. Prosím zkontrolujte vaši konfiguraci PHP";
$GLOBALS['strErrorStoreLocal']			= "Nastala chyba při pokusu o uložení banneru do lokálního adresáře. Toto je zřejmě následek špatné konfigurace nastavení lokálních cest";
$GLOBALS['strErrorStoreFTP']			= "Nastala chyba při pokusu o nahrání banneru na FTP server. Toto může být způsobeno nedostupností serveru nebo špatnou konfigurací nastavení FTP serveru";
$GLOBALS['strErrorDBPlain']			= "Nastala chyba při přístupu do databáze";
$GLOBALS['strErrorDBSerious']			= "Byl zjištěn závažný problém při přístupu do databáze";
$GLOBALS['strErrorDBNoDataPlain']		= "Vzhledem k promlémům s databází, ". MAX_PRODUCT_NAME ." nemůže na�?íst ani ukládat data.";
$GLOBALS['strErrorDBNoDataSerious']		= "Vzhledem k závažným promlémům s databází, ". MAX_PRODUCT_NAME ." nemůže na�?íst data";
$GLOBALS['strErrorDBCorrupt']			= "Databázová tabulka je pravděpodobně poškozena a potřebuje opravit. Pro více informací o opravování poškozených tabulek prosím �?těte kapitolu <i>Troubleshooting</i> v příru�?ce <i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact']			= "Prosím kontaktujte správce tohoto serveru a oznamte jemu nebo jí tento problém.";
$GLOBALS['strErrorDBSubmitBug']			= "Pokud je tento problém reprodukovatelný, může být způsoben chybou v ". MAX_PRODUCT_NAME .". Prosím poskytněte následující informace tvůrcům ". MAX_PRODUCT_NAME .". Také se pokuste popsat kroky které vedly k této chybě jak nejpřesněji je to jen možné.";
$GLOBALS['strMaintenanceNotActive']		= "Skript pro správu systému nebyl spuštěn v průběhu posledních 24 hodin. \nAby mohl ". MAX_PRODUCT_NAME ." korektně fungovat je nutné aby běžel každou \nhodinu. \n\nProsím pře�?těte si příru�?ku Administrators guide pro informace \no konfiguraci skriptu pro správu systému.";
$GLOBALS['strErrorBadUserType']			= "Systém nedokázal ur�?it druh vaeho uivatelského ú�?tu!";

// E-mail
$GLOBALS['strMailSubject']			= "Prehled inzerenta";
$GLOBALS['strAdReportSent']			= "Přehled inzerenta odeslán";
$GLOBALS['strMailSubjectDeleted']		= "Deaktivované bannery";
$GLOBALS['strMailHeader']			= "Vazeny {contact},\n";
$GLOBALS['strMailBannerStats']			= "Nize najdete statistiky banneru pro {clientname}:";
$GLOBALS['strMailFooter']			= "S pozdravem,\n   {adminfullname}";
$GLOBALS['strMailClientDeactivated']		= "Nasledujici bannery byly vypnute z duvodu";
$GLOBALS['strMailNothingLeft']			= "Pokud chcete i nadale inzerovat na nasich strankach nevahejte nas kontaktovat.\nRadi vas uslysime.";
$GLOBALS['strClientDeactivated']		= "Tato kampan neni v tuto chvili aktivni z duvodu";
$GLOBALS['strBeforeActivate']			= "datum aktivace zatim nenastalo";
$GLOBALS['strAfterExpire']			= "nastalo datum deaktivace";
$GLOBALS['strNoMoreClicks']			= "nezbyvaji jiz zadna kliknuti";
$GLOBALS['strNoMoreViews']			= "nezbyvaji jiz zadna zobrazeni";
$GLOBALS['strNoMoreConversions']		= "nezbyvaji jiz zadne prodeje";
$GLOBALS['strWeightIsNull']			= "jeji vaha je nastavena na nulu";
$GLOBALS['strWarnClientTxt']			= "Zbyvajici kliknuti nebo zobrazeni pro vase bannery se blizi k {limit}. \nVaše bannery budou vypnuté až nezbydou žádné AdClicks nebo AdViews. ";
$GLOBALS['strViewsClicksLow']			= "Nizky pocet zobrazeni/kliknuti";
$GLOBALS['strNoViewLoggedInInterval']		= "Zadna zobrazeni nebyla za obdobi tohoto prehledu zaznamenana";
$GLOBALS['strNoClickLoggedInInterval']		= "Zadna kliknuti nebyla za obdobi tohoto prehledu zaznamenana";
$GLOBALS['strNoConversionLoggedInInterval']	= "Zadne prodeje nebyly za obdobi tohoto prehledu zaznamenany";
$GLOBALS['strMailReportPeriod']			= "Tento prehled obsahuje statistiky od {startdate} do {enddate}.";
$GLOBALS['strMailReportPeriodAll']		= "Tento prehled obsahuje statistiky do {enddate}.";
$GLOBALS['strNoStatsForCampaign']		= "Nejsou k dispozici zadne statistiky pro tuto kampan";


// Priority
$GLOBALS['strPriority']				= "Priorita";
$GLOBALS['strSourceEdit']			= "Upravit zdroje";

// Settings
$GLOBALS['strSettings']                         = "Nastavení";
$GLOBALS['strGeneralSettings']			= "Obecná nastavení";
$GLOBALS['strMainSettings']			= "Základní nastavení";
$GLOBALS['strAdminSettings']			= "Nastavení administrace";


// Product Updates
$GLOBALS['strProductUpdates']			= "Aktualizace produktu";

// Agency
$GLOBALS['strAgencyManagement']			= "Správa partnerů";
$GLOBALS['strAgency']				= "Partner";
$GLOBALS['strAgencies']				= "Partneři";
$GLOBALS['strAddAgency']			= "Přidat partnera";
$GLOBALS['strAddAgency_Key']			= "Přidat <u>z</u>ónu";
$GLOBALS['strTotalAgencies']			= "Celkem partnerů";
$GLOBALS['strAgencyProperties']			= "Vlastnosti partnera";
$GLOBALS['strNoAgencies']			= "Zatím nejsou definované žádné zóny";
$GLOBALS['strConfirmDeleteAgency']		= "Opravdu chcete smazat tuto zónu?";
$GLOBALS['strHideInactiveAgencies']		= "Skrýt neaktivní partnery";
$GLOBALS['strInactiveAgenciesHidden']		= "neaktivních bannerů skryto";

// Tracker Variables
$GLOBALS['strVariableName']			= "Název proměnné";
$GLOBALS['strVariableDescription']		= "Popis";
$GLOBALS['strVariableType']			= "Typ proměnné";
$GLOBALS['strVariableDataType']			= "Datový typ";
$GLOBALS['strJavascript']			= "Javascript";
$GLOBALS['strRefererQuerystring']		= "Řetězec referera";
$GLOBALS['strQuerystring']	     		= "Řetězec";
$GLOBALS['strInteger']				= "Číslo";
$GLOBALS['strString']				= "String";
$GLOBALS['strTrackFollowingVars']		= "Sledovat tuto proměnnou";
$GLOBALS['strAddVariable']			= "Přidat proměnnou";
$GLOBALS['strNoVarsToTrack']			= "Žádné proměnné ke sledování.";



/*********************************************************/
/* Keyboard shortcut assignments                         */
/*********************************************************/


// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome']                        	= 'h';
$GLOBALS['keyUp']                        	= 'u';
$GLOBALS['keyNextItem']                		= '.';
$GLOBALS['keyPreviousItem']        		= ',';
$GLOBALS['keyList']                        	= 'l';


// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch']                		= 's';
$GLOBALS['keyCollapseAll']        		= 'c';
$GLOBALS['keyExpandAll']        		= 'e';
$GLOBALS['keyAddNew']                		= 'n';
$GLOBALS['keyNext']                        	= 'n';
$GLOBALS['keyPrevious']                		= 'p';



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strStatusDuplicate'] = "Duplikovat";
$GLOBALS['strStatsVariables'] = "Proměnné";
$GLOBALS['strCampaignName'] = "Historie kampaně";
$GLOBALS['strStatsAction'] = "Akce";
$GLOBALS['strBreakdownByDay'] = "Den";
$GLOBALS['strBreakdownByWeek'] = "Týden";
$GLOBALS['strSingleMonth'] = "Měsíců";
$GLOBALS['strBreakdownByMonth'] = "Měsíců";
$GLOBALS['strBreakdownByHour'] = "Hodina";
$GLOBALS['strHiddenAdvertiser'] = "Inzerent";
$GLOBALS['strHiddenTracker'] = "Sledova�?";
$GLOBALS['strHiddenZone'] = "Zóna";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "Priorita této kampaně byla nastavena na nízkou, \nale váha byla nastavena na nulu nebo nebyla \nzadána. Takto bude kampaň okamžitě \ndeaktivována a její bannery nebudou doru�?eny \ndokud její váha nebude nastavena na platné �?íslo. \n\nJste si jist že chcete pokra�?ovat?";
$GLOBALS['strCampaignWarningExclusiveNoWeight'] = "Priorita této kampaně byla nastavena na nízkou, \nale váha byla nastavena na nulu nebo nebyla \nzadána. Takto bude kampaň okamžitě \ndeaktivována a její bannery nebudou doru�?eny \ndokud její váha nebude nastavena na platné �?íslo. \n\nJste si jist že chcete pokra�?ovat?";
$GLOBALS['strChannelLimitations'] = "Nastavení doru�?ování";
$GLOBALS['strGreaterThan'] = "je později než";
$GLOBALS['strWeekDays'] = "V pracovní den";
$GLOBALS['strInactiveAffiliatesHidden'] = "neaktivních bannerů skryto";
$GLOBALS['strAllowAffiliateZoneStats'] = "Povolit uživateli prohlížet statistiky cílení";
$GLOBALS['strInactiveZonesHidden'] = "neaktivních bannerů skryto";
$GLOBALS['strConnTypeSale'] = "Uložit";
$GLOBALS['strNoTargetingStats'] = "V tuto chvíli nejsou k dispozici žádné statistiky";
$GLOBALS['strAllAdvertisers'] = "Celkem inzerentů";
$GLOBALS['strMailBannerActivatedSubject'] = "Kampaň aktivována";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Kampaň {id} aktivována";
$GLOBALS['strNoChannels'] = "Zatím nejsou definovány žádné bannery";
$GLOBALS['strConfirmDeleteChannel'] = "Opravdu chcete smazat tento banner?";
$GLOBALS['strUserProperties'] = "Nastavení banneru";
$GLOBALS['strNoAdminInterface'] = "Služba není dostupná...";
$GLOBALS['strOverallAdvertisers'] = "Inzerenti";
$GLOBALS['strLinkUserHelpUser'] = "Jméno";
$GLOBALS['strPasswordRepeat'] = "Zopakujte heslo";
$GLOBALS['strCampaignStatusDeleted'] = "Smazat";
$GLOBALS['strTrackers'] = "Sledova�?";
$GLOBALS['strCampaignStop'] = "Historie kampaně";
$GLOBALS['strCheckForUpdates'] = "Kontrolovat aktualizace";
$GLOBALS['strGlobalSettings'] = "Základní nastavení";
$GLOBALS['strActions'] = "Akce";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strAdvertiserCampaigns'] = "Inzerenti & Kampaně";
$GLOBALS['strCampaignStatusInactive'] = "aktivní";
$GLOBALS['strCampaignType'] = "Historie kampaně";
$GLOBALS['strContract'] = "Kontakt";
$GLOBALS['strStandardContract'] = "Kontakt";
$GLOBALS['strWebsiteZones'] = "Vydavatelé & Zóny";
$GLOBALS['strConfirmDeleteClients'] = "Opravdu chcete smazat tohoto inzerenta?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Opravdu chcete smazat tuto kampaň?";
$GLOBALS['strConfirmDeleteTrackers'] = "Opravdu chcete smazat tento sledova�??";
$GLOBALS['strConfirmDeleteBanners'] = "Opravdu chcete smazat tento banner?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Opravdu si přejete smazat tohoto vydavatele?";
$GLOBALS['strConfirmDeleteZones'] = "Opravdu chcete smazat tuto zónu?";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strClicks_short'] = "Kliknutí";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConfirmDeleteChannels'] = "Opravdu chcete smazat tento banner?";
$GLOBALS['strSite'] = "Velikost";
$GLOBALS['strHiddenWebsite'] = "Website";
$GLOBALS['strYouHaveNoCampaigns'] = "Inzerenti & Kampaně";
$GLOBALS['strHideInactiveOverview'] = "Skrýt neaktivní položky ze všech přehledových stránek";
$GLOBALS['strNewWindow'] = "Okno zobrazení";
$GLOBALS['strClick-ThroughRatio'] = "Poměr kliknutí";
$GLOBALS['strClicksShort'] = "Kliknutí";
$GLOBALS['strVariable'] = "Proměnné";
$GLOBALS['strPreference'] = "Předvolby";
$GLOBALS['strDeliveryLimitation'] = "Omezení doru�?ování";
$GLOBALS['str_ID'] = "ID";
$GLOBALS['str_Clicks'] = "Kliknutí";
$GLOBALS['str_CTR'] = "CTR";
?>