<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
$GLOBALS['phpAds_CharSet'] 			= "iso-8859-2";
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
$GLOBALS['strHelp']				= "Nápovìda";
$GLOBALS['strNavigation']			= "Navigace";
$GLOBALS['strShortcuts']			= "Zkratka";
$GLOBALS['strAdminstration']			= "Inventáø";
$GLOBALS['strMaintenance']			= "Správa";
$GLOBALS['strProbability']			= "Pravdìpodobnost";
$GLOBALS['strInvocationcode']			= "Zobrazovací kód";
$GLOBALS['strTrackerVariables']			= "Promìnné Sledovaèe";
$GLOBALS['strBasicInformation']			= "Základní údaje";
$GLOBALS['strContractInformation']		= "Obchodní údaje";
$GLOBALS['strLoginInformation']			= "Pøihla¹ovací údaje";
$GLOBALS['strOverview']				= "Pøehled";
$GLOBALS['strSearch']				= "<u>V</u>yhledávání";
$GLOBALS['strHistory']				= "Historie";
$GLOBALS['strPreferences']			= "Pøedvolby";
$GLOBALS['strDetails']				= "Detaily";
$GLOBALS['strCompact']				= "Kompaktní";
$GLOBALS['strVerbose']				= "Podrobné";
$GLOBALS['strUser']				= "U¾ivatel";
$GLOBALS['strEdit']				= "Upravit";
$GLOBALS['strCreate']				= "Vytvoøit";
$GLOBALS['strDuplicate']			= "Duplikovat";
$GLOBALS['strMoveTo']				= "Pøesunout";
$GLOBALS['strDelete']				= "Smazat";
$GLOBALS['strActivate']				= "Aktivovat";
$GLOBALS['strDeActivate']			= "Deaktivovat";
$GLOBALS['strConvert']				= "Konvertovat";
$GLOBALS['strRefresh']				= "Obnovit";
$GLOBALS['strSaveChanges']			= "Ulo¾it zmìny";
$GLOBALS['strUp']				= "Nahoru";
$GLOBALS['strDown']				= "Dolù";
$GLOBALS['strSave']				= "Ulo¾it";
$GLOBALS['strCancel']				= "Zru¹it";
$GLOBALS['strPrevious']				= "Pøedchozí";
$GLOBALS['strPrevious_Key']			= "<u>P</u>øedchozí";
$GLOBALS['strNext']				= "Následující";
$GLOBALS['strNext_Key']				= "<u>N</u>ásledující";
$GLOBALS['strYes']				= "Ano";
$GLOBALS['strNo']				= "Ne";
$GLOBALS['strNone']				= "®ádné";
$GLOBALS['strCustom']				= "Vlastní";
$GLOBALS['strDefault']				= "Implicitní";
$GLOBALS['strOther']				= "Jiné";
$GLOBALS['strUnknown']				= "Neznámé";
$GLOBALS['strUnlimited']			= "Neomezené";
$GLOBALS['strUntitled']				= "Bezejména";
$GLOBALS['strAll']				= "v¹echny";
$GLOBALS['strAvg']				= "Prùm.";
$GLOBALS['strAverage']				= "Prùmìr";
$GLOBALS['strOverall']				= "Celkový pøehled";
$GLOBALS['strTotal']				= "Celkem";
$GLOBALS['strUnfilteredTotal']			= "Total (nefiltrovaných)";
$GLOBALS['strFilteredTotal']			= "Total (filtrovaných)";
$GLOBALS['strActive']				= "aktivní";
$GLOBALS['strFrom']				= "Od";
$GLOBALS['strTo']				= "do";
$GLOBALS['strLinkedTo']				= "pøipojení k";
$GLOBALS['strDaysLeft']				= "Zbývá dnù";
$GLOBALS['strCheckAllNone']			= "Oznaèit v¹e / nic";
$GLOBALS['strKiloByte']				= "KB";
$GLOBALS['strExpandAll']			= "<u>R</u>oz¹íøit v¹e";
$GLOBALS['strCollapseAll']			= "<u>S</u>louèit v¹e";
$GLOBALS['strShowAll']				= "Ukázat v¹e";
$GLOBALS['strNoAdminInteface']			= "Slu¾ba není dostupná...";
$GLOBALS['strFilterBySource']			= "filtrovat podle zdroje";
$GLOBALS['strFieldContainsErrors']		= "Následující polo¾ky obsahují chyby:";
$GLOBALS['strFieldFixBeforeContinue1']		= "Ne¾ budete moci pokraèovat potøebujete";
$GLOBALS['strFieldFixBeforeContinue2']		= "opravit tyto chyby.";
$GLOBALS['strDelimiter']			= "Oddìlovaè";
$GLOBALS['strMiscellaneous']			= "Rùzné";
$GLOBALS['strCollectedAllStats']		= "Všechny statistiky";
$GLOBALS['strCollectedToday']			= "Dnes";
$GLOBALS['strCollectedYesterday']		= "Vèera";
$GLOBALS['strCollectedThisWeek']		= "Tento týden (Po-Ne)";
$GLOBALS['strCollectedLastWeek']		= "Minulý týden (Po-Ne)";
$GLOBALS['strCollectedThisMonth']		= "Tento mìsíc";
$GLOBALS['strCollectedLastMonth']		= "Minulý mìsíc";
$GLOBALS['strCollectedLast7Days']		= "Posledních 7 dní";

// Priority
$GLOBALS['strPriority']				= "Priorita";
$GLOBALS['strPriorityLevel']			= "Úroveò priority";
$GLOBALS['strPriorityTargeting']		= "Distribuce";
$GLOBALS['strPriorityOptimisation']		= "Rùzné";



// Properties
$GLOBALS['strName']				= "Jméno";
$GLOBALS['strSize']				= "Velikost";
$GLOBALS['strWidth']				= "©íøka";
$GLOBALS['strHeight']				= "Vý¹ka";
$GLOBALS['strURL2']				= "URL";
$GLOBALS['strTarget']				= "Cíl";
$GLOBALS['strLanguage']				= "Jazyk";
$GLOBALS['strDescription']			= "Popis";
$GLOBALS['strVariables']			= "Promìnné";
$GLOBALS['strID']				= "ID";


// Login & Permissions
$GLOBALS['strAuthentification']			= "Autentifikace";
$GLOBALS['strWelcomeTo']			= "Vítejte do";
$GLOBALS['strEnterUsername']			= "Pro pøihlásení zadejte va¹e u¾ivatelské jméno a heslo";
$GLOBALS['strEnterBoth']			= "Prosím zadejte va¹e jméno i heslo";
$GLOBALS['strEnableCookies']			= "Musíte povolit cookees ne¾ budete moci pou¾ívat ".$phpAds_productname;
$GLOBALS['strLogin']				= "Pøihlásit";
$GLOBALS['strLogout']				= "Odhlásit";
$GLOBALS['strUsername']				= "Jméno";
$GLOBALS['strPassword']				= "Heslo";
$GLOBALS['strAccessDenied']			= "Pøístup odepøen";
$GLOBALS['strPasswordWrong']			= "Toto není správné heslo";
$GLOBALS['strParametersWrong']			= "Parametry, které jste zadal nejsou správné";
$GLOBALS['strNotAdmin']				= "Zøejmì nemáte dostateèné oprávnìní";
$GLOBALS['strDuplicateClientName']		= "Zadané u¾ivatelské jméno ji¾ existuje. Prosím zadejte jiné jméno.";
$GLOBALS['strDuplicateAgencyName']		= "Zadané u¾ivatelské jméno ji¾ existuje. Prosím zadejte jiné jméno.";
$GLOBALS['strInvalidPassword']			= "Zadané heslo je ¹patné. Prosím zadejte jiné heslo.";
$GLOBALS['strNotSamePasswords']			= "Dvì hesla která jste zadal nejsou stejná.";
$GLOBALS['strRepeatPassword']			= "Zopakujte heslo";
$GLOBALS['strOldPassword']			= "Staré heslo";
$GLOBALS['strNewPassword']			= "Nové heslo";



// General advertising
$GLOBALS['strViews']				= "Zobrazení";
$GLOBALS['strClicks']				= "Kliknutí";
$GLOBALS['strConversions']			= "Prodeje";
$GLOBALS['strCTRShort']                         = "CTR";
$GLOBALS['strCNVRShort'] 			= "SR";
$GLOBALS['strCTR']				= "Pomìr kliknutí";
$GLOBALS['strCNVR'] 				= "Pomìr prodeje";
$GLOBALS['strCPC']	 			= "Náklad na klik";
$GLOBALS['strCPCo']				= "Náklad na prodej";
$GLOBALS['strCPCoShort']	 		= "CPCo";
$GLOBALS['strCPCShort']	 			= "CPC";
$GLOBALS['strTotalCost']	 		= "Celkem náklady";
$GLOBALS['strTotalViews']			= "Celkem zobrazení";
$GLOBALS['strTotalClicks']			= "Celkem kliknutí";
$GLOBALS['strTotalConversions']			= "Celkem prodejù";
$GLOBALS['strViewCredits']			= "Kreditùzobrazení";
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
$GLOBALS['strWeeks']				= "Týdnù";
$GLOBALS['strMonths']				= "Mìsícù";
$GLOBALS['strThisMonth']			= "Tento mìsíc";
$GLOBALS['strMonth']				= array("Leden","Únor","Bøezen","Duben","Kvìten","Èerven","Èervenec", "Srpen", "Záøí", "Øíjen", "Listopad", "Prosinec");
$GLOBALS['strDayShortCuts']			= array("Ne","Po","Út","St","Èt","Pá","So");
$GLOBALS['strHour']				= "Hodina";
$GLOBALS['strHourFilter']			= "Filtr hodin";
$GLOBALS['strSeconds']				= "vteøin";
$GLOBALS['strMinutes']				= "minut";
$GLOBALS['strHours']				= "hodin";
$GLOBALS['strTimes']				= "krát";


// Advertiser
$GLOBALS['strClient']				= "Inzerent";
$GLOBALS['strClients']				= "Inzerenti";
$GLOBALS['strClientsAndCampaigns']		= "Inzerenti & Kampanì";
$GLOBALS['strAddClient']			= "Pøidat inzerenta";
$GLOBALS['strAddClient_Key']			= "Pøidat <u>i</u>nzerenta";
$GLOBALS['strTotalClients']			= "Celkem inzerentù";
$GLOBALS['strClientProperties']			= "Nastavení inzerenta";
$GLOBALS['strClientHistory']			= "Historie inzerenta";
$GLOBALS['strNoClients']                        = "Zatím nejsou definování ¾ádní inzerenti";
$GLOBALS['strConfirmDeleteClient']		= "Opravdu chcete smazat tohoto inzerenta?";
$GLOBALS['strConfirmResetClientStats']		= "Opravdu chcete smazat v¹echny existující statistiky tohoto inzerenta?";
$GLOBALS['strHideInactiveAdvertisers']		= "Skrýt neaktivní inzerenty";
$GLOBALS['strInactiveAdvertisersHidden']        = "nekativních inzerent(ù) skryto";
$GLOBALS['strHideInactiveCampaigns']		= "Skrýt neaktívní kampanì";
$GLOBALS['strInactiveCampaignsHidden']		= "neaktivních kampaní skryto";
$GLOBALS['strHideInactivePublishers']		= "Skrýt neaktivní vydavatele";
$GLOBALS['strInactivePublishersHidden']		= "neaktivních vydavatelù skryto";


// Advertisers properties
$GLOBALS['strContact']				= "Kontakt";
$GLOBALS['strEMail']				= "E-mail";
$GLOBALS['strSendAdvertisingReport']		= "Zaslat pøehled inzerce e-mailem";
$GLOBALS['strNoDaysBetweenReports']		= "Poèet dní mezi pøehledy";
$GLOBALS['strSendDeactivationWarning']		= "Zaslat upozornìní pøi deaktivaci kampanì";
$GLOBALS['strAllowClientModifyInfo']		= "Povolit u¾ivateli mìnit vlastní nastavení";
$GLOBALS['strAllowClientModifyBanner']		= "Povolit u¾ivateli mìnit vlastní bannery";
$GLOBALS['strAllowClientAddBanner']		= "Povolit u¾ivateli vkládat vlastní bannery";
$GLOBALS['strAllowClientDisableBanner']		= "Povolit u¾ivateli deaktivovat vlastní bannery";
$GLOBALS['strAllowClientActivateBanner']	= "Povolit u¾ivateli aktivovat vlastní bannery";
$GLOBALS['strAllowClientViewTargetingStats']	= "Povolit uživateli prohlížet statistiky cílení";


// Campaign
$GLOBALS['strCampaign']				= "Kampaò";
$GLOBALS['strCampaigns']			= "Kampanì";
$GLOBALS['strTotalCampaigns']			= "Celkem kampaní";
$GLOBALS['strActiveCampaigns']			= "Aktivních kampaní";
$GLOBALS['strAddCampaign']			= "Pøidat kampaò";
$GLOBALS['strAddCampaign_Key']			= "Pøidat <u>k</u>ampaò";
$GLOBALS['strCreateNewCampaign']		= "Vytvoøit novou kampaò";
$GLOBALS['strModifyCampaign']			= "Upravit kampaò";
$GLOBALS['strMoveToNewCampaign']                = "Pøesunout do nové kampanì";
$GLOBALS['strBannersWithoutCampaign']		= "Bannery bez kampanì";
$GLOBALS['strDeleteAllCampaigns']		= "Smazat v¹echny kampanì";
$GLOBALS['strLinkedCampaigns']			= "Pøipojené kampanì";
$GLOBALS['strCampaignStats']			= "Statistiky kampanì";
$GLOBALS['strCampaignProperties']		= "Nastavení kampanì";
$GLOBALS['strCampaignOverview']			= "Pøehled kampanì";
$GLOBALS['strCampaignHistory']			= "Historie kampanì";
$GLOBALS['strNoCampaigns']			= "V tuto chvíli nejsou definované ¾ádné kampanì";
$GLOBALS['strConfirmDeleteAllCampaigns']        = "Opravdu chcete smazat v¹echny kampanì tohoto inzerenta?";
$GLOBALS['strConfirmDeleteCampaign']		= "Opravdu chcete smazat tuto kampaò?";
$GLOBALS['strConfirmResetCampaignStats']	= "Opravdu chcete smazat v¹echny statistiky pro tuto kampaò?";
$GLOBALS['strHideInactiveCampaigns']		= "Skrýt neaktivní kampanì";
$GLOBALS['strInactiveCampaignsHidden']		= "neaktivních kampaní skryto";
$GLOBALS['strContractDetails']			= "Detail zakázky";
$GLOBALS['strInventoryDetails']			= "Detail inventáøe";
$GLOBALS['strPriorityInformation']		= "Informace o prioritì";
$GLOBALS['strPriorityHigh']			= "Vysoká - placené kampanì";
$GLOBALS['strPriorityMedium']			= "Støední - velkoprodej a dùležité kampanì";
$GLOBALS['strPriorityLow']			= "Nízká - vlastní a neplacené kampanì";
$GLOBALS['strHiddenCampaign']			= "Skrytá kampaò";
$GLOBALS['strUnderdeliveringCampaigns']		= "Neplnící kampanì";
$GLOBALS['strCampaignDelivery']			= "Doruèování kampanì";


// Campaign properties
$GLOBALS['strDontExpire']			= "Tato kampaò nikdy automaticky neexpiruje";
$GLOBALS['strActivateNow']			= "Okam¾itì aktivovat tuto kampaò";
$GLOBALS['strLow']				= "Nízká";
$GLOBALS['strHigh']				= "Vysoká";
$GLOBALS['strExpirationDate']			= "Datum expirace";
$GLOBALS['strExpirationDateComment']		= "Kampaòskonèí na konci tohoto dne";
$GLOBALS['strActivationDate']			= "Datum aktivace";
$GLOBALS['strActivationDateComment']		= "Kampaò zaène na zaèatku tohoto dne";
$GLOBALS['strViewsPurchased']			= "Objednaných zobrazení";
$GLOBALS['strClicksPurchased']			= "Objednaných kliknutí";
$GLOBALS['strConversionsPurchased']		= "Objednaných prodejù";
$GLOBALS['strCampaignWeight']			= "Váha kampanì";
$GLOBALS['strOptimise']				= "Optimalizovat doruèování této kampanì.";
$GLOBALS['strAnonymous']			= "Skrýt inzerenta a vydavatele této kampanì.";
$GLOBALS['strHighPriority']			= "Zobrazit bannery této kampanì s vysokou prioritou.<br>Pokud pou¾ijete tuto volbu, systém se pokusí distribuovat po¾adovaný poèet zobrazení rovnomìrnì po celý den.";
$GLOBALS['strLowPriority']			= "Zobrazit bannery této kampanì s nízkou prioritou.<br> Tato kampaò se pou¾ívá pro zbytková zobrazení, která nejsou vyu¾ita kampanìmi s vysokou prioritou.";
$GLOBALS['strTargetLimitAdviews']		= "Omezit poèet AdViews na";
$GLOBALS['strTargetPerDay']			= "za den.";
$GLOBALS['strPriorityAutoTargeting']		= "Distribuovat zbývající poèet AdViews rovnomìrnì na zbývající dny. Zbývající poèet AdViews bude vypoèítán pøimìøenì ka¾dý den.";
$GLOBALS['strCampaignWarningNoWeight']		= "Priorita této kampanì byla nastavena na nízkou, \nale váha byla nastavena na nulu nebo nebyla \nzadána. Takto bude kampaò okam¾itì \ndeaktivována a její bannery nebudou doruèeny \ndokud její váha nebude nastavena na platné èíslo. \n\nJste si jist ¾e chcete pokraèovat?";
$GLOBALS['strCampaignWarningNoTarget']		= "Priorita této kampanì byla nastavena na vysokou, \nale cílový poèet AdViews nebyl zadán. \nTakto bude kampaò okam¾itì deaktivována a\njejí bannery nebudou doruèeny dokdu nebude \nnastaven platný poèet AdViews. \n\nJste si jist ¾e chcete pokraèovat?";


// Tracker
$GLOBALS['strTracker']				= "Sledovaè";
$GLOBALS['strTrackerOverview']			= "Pøehled sledovaèe";
$GLOBALS['strAddTracker'] 			= "Pøidat nový sledovaè";
$GLOBALS['strAddTracker_Key'] 			= "Pøidat <u>n</u>ový sledovaè";
$GLOBALS['strNoTrackers']			= "V tuto chvíli nejsou definovány žádné sledovaèe";
$GLOBALS['strConfirmDeleteAllTrackers']		= "Opravdu chcete smazat všechny sledovaèe tohoto inzerenta?";
$GLOBALS['strConfirmDeleteTracker']		= "Opravdu chcete smazat tento sledovaè?";
$GLOBALS['strDeleteAllTrackers']		= "Smazat všechny sledovaèe";
$GLOBALS['strTrackerProperties']		= "Vlastnosti sledovaèe";
$GLOBALS['strTrackerOverview']			= "Pøehled sledovaèe";
$GLOBALS['strModifyTracker']			= "Upravit sledovaè";
$GLOBALS['strLog']				= "Log?";
$GLOBALS['strLinkedTrackers']			= "Pøipojené sledovaèe";
$GLOBALS['strDefaultConversionRules']		= "Implicitní pravidla prodeje";
$GLOBALS['strConversionWindow']			= "Okno pøevodu";
$GLOBALS['strClickWindow']			= "Okno kliknutí";
$GLOBALS['strViewWindow']			= "Okno zobrazení";
$GLOBALS['strClick']				= "Klik";
$GLOBALS['strView']				= "Zobrazení";
$GLOBALS['strConversionClickWindow']		= "Mìøit prodeje které probìhnou bìhem uvedeného èasového rozmezí (vteøin) od kliknutí";
$GLOBALS['strConversionViewWindow']		= "Mìøit prodeje které probìhnou bìhem uvedeného èasového rozmezí (vteøin) od zobrazení";
$GLOBALS['strTotalTrackerImpressions']		= "Celkem zobrazení";
$GLOBALS['strTotalTrackerConnections']		= "Celkem spojení";
$GLOBALS['strTotalTrackerConversions']		= "Celkem prodejù";
$GLOBALS['strTrackerImpressions']		= "Zobrazení";
$GLOBALS['strTrackerImprConnections']		= "Spojení zobrazení";
$GLOBALS['strTrackerClickConnections']		= "Spojení kliknutí";
$GLOBALS['strTrackerImprConversions']		= "Prodejních zobrazení";
$GLOBALS['strTrackerClickConversions']		= "Prodejních kliknutí";

// Banners (General)
$GLOBALS['strBanner']				= "Banner";
$GLOBALS['strBanners']				= "Bannery";
$GLOBALS['strBannerFilter']			= "Filtr bannerù";
$GLOBALS['strAddBanner']			= "Pøidat banner";
$GLOBALS['strAddBanner_Key']			= "Pøidat <u>b</u>anner";
$GLOBALS['strModifyBanner']			= "Upravit banner";
$GLOBALS['strActiveBanners']			= "Aktivních bannerù";
$GLOBALS['strTotalBanners']			= "Celkem bannerù";
$GLOBALS['strShowBanner']			= "Zobrazit banner";
$GLOBALS['strShowAllBanners']			= "Zobrazit v¹echny bannery";
$GLOBALS['strShowBannersNoAdClicks']		= "Zobrazit bannery bez kliknutù";
$GLOBALS['strShowBannersNoAdViews']		= "Zobrazit bannery bez zobrazení";
$GLOBALS['strShowBannersNoAdConversions']	= "Zobrazit bannery bez prodeje";
$GLOBALS['strDeleteAllBanners']			= "Smazat v¹echny bannery";
$GLOBALS['strActivateAllBanners']		= "Aktivovat v¹echny bannery";
$GLOBALS['strDeactivateAllBanners']		= "Deaktivovat v¹echny bannery";
$GLOBALS['strBannerOverview']			= "Pøehled bannerù";
$GLOBALS['strBannerProperties']			= "Nastavení banneru";
$GLOBALS['strBannerHistory']			= "Historie banneru";
$GLOBALS['strBannerNoStats']			= "Pro tento banner zatím nejsou ¾ádné statistiky";
$GLOBALS['strNoBanners']			= "Zatím nejsou definovány ¾ádné bannery";
$GLOBALS['strConfirmDeleteBanner']		= "Opravdu chcete smazat tento banner?";
$GLOBALS['strConfirmDeleteAllBanners']		= "Opravdu chcete smazat v¹echny bannery které patøí k této kampani?";
$GLOBALS['strConfirmResetBannerStats']		= "Opravdu chcete smazat v¹echny statistiky tohoto banneru?";
$GLOBALS['strShowParentCampaigns']		= "Zobrazit nadøazené kampanì";
$GLOBALS['strHideParentCampaigns']		= "Skrýt nadøazené kampanì";
$GLOBALS['strHideInactiveBanners']		= "Skrýt neaktivní bannery";
$GLOBALS['strInactiveBannersHidden']		= "neaktivních bannerù skryto";
$GLOBALS['strAppendOthers']			= "Pøipojit jiné";
$GLOBALS['strAppendTextAdNotPossible']		= "Není mo¾né pøipojit jiné bannery k textové reklamì.";
$GLOBALS['strHiddenBanner']			= "Skrytý banner";
$GLOBALS['strConfirmDeactivate']		= "Tato zmìna deaktivuje tento banner dokud nebude zkontrolován partnerem.";


// Banner (Properties)
$GLOBALS['strChooseBanner']			= "Prosím vyberte typ banneru";
$GLOBALS['strMySQLBanner']			= "Lokální banner (SQL)";
$GLOBALS['strWebBanner']			= "Lokální banner (Webserver)";
$GLOBALS['strURLBanner']			= "Externí banner";
$GLOBALS['strHTMLBanner']			= "HTML banner";
$GLOBALS['strTextBanner']			= "Textová reklama";
$GLOBALS['strAutoChangeHTML']			= "Upravit HTML aby bylo mo¾né sledovat AdClicks";
$GLOBALS['strUploadOrKeep']			= "Pøejete se zachovat <br>souèasný obrázek, nebo <br>chcete nahrát jiný?";
$GLOBALS['strUploadOrKeepAlt']			= "Pøejete se zachovat <br>souèasný alternativní obrázek, nebo <br>chcete nahrát jiný?";
$GLOBALS['strNewBannerFile']			= "Zvolte obrázek, který <br>chcete pou¾ít pro tento banner<br><br>";
$GLOBALS['strNewBannerFileAlt']			= "Vyberte alternativní obrázek, který <br>chcete použít pro prohlížeèe,<br>které nepodporují rich-media<br><br>";
$GLOBALS['strNewBannerURL']			= "URL obrázku (vèetnì http://)";
$GLOBALS['strURL']				= "Cílová URL (incl. http://)";
$GLOBALS['strHTML']				= "HTML";
$GLOBALS['strTextBelow']			= "Text pod obrázkem";
$GLOBALS['strKeyword']				= "Klíèová slova";
$GLOBALS['strWeight']				= "Váha";
$GLOBALS['strAlt']				= "Alt text";
$GLOBALS['strStatusText']			= "Stavový text";
$GLOBALS['strBannerWeight']			= "Váha banneru";


// Banner (swf)
$GLOBALS['strCheckSWF']				= "Pøevést pevné odkazy uvnitø Flash souboru";
$GLOBALS['strConvertSWFLinks']			= "Pøevést Flash odkazy";
$GLOBALS['strHardcodedLinks']			= "Pevné odkazy";
$GLOBALS['strConvertSWF']			= "<br>Flash soubor, který jste právì vlo¾il obsahuje pevné odkazy. Systém nebude schopen poèítat AdClicks pro tento banner dokud nepøevedete tyto pevné odkazy. Ní¾e najdete seznam odkazù nalezených uvnitø Flash souboru. Pokud si pøejete pøevést odkazy jednodu¹e kliknìte na <b>Pøevést</b>, jinak zvolte <b>Zru¹it</b>.<br><br>Prosím nezapomeòte: pokud kliknete na <b>Pøevést</b>, Flash soubor který jste právì nahrál bude upraven. <br>Prosím uchovejte si zálo¾ní kopii pùvodního souboru. Nezávisle na verzi ve které byl tento banner vytvoøen, výsledný soubor bude potøebovat pøehrávaè Flash 4 (nebo novìj¹í) aby se korektnì zobrazil.<br><br>";
$GLOBALS['strCompressSWF']			= "Komprimovat SWF soubor pro rychlej¹í stahování (vy¾aduje pøehrávaè Flash 6)";
$GLOBALS['strOverwriteSource']			= "Pøepsat zdrojový parametr";


// Banner (network)
$GLOBALS['strBannerNetwork']			= "HTML vzor";
$GLOBALS['strChooseNetwork']			= "Zvolte vzor který chcete pou¾ít";
$GLOBALS['strMoreInformation']			= "Více informací...";
$GLOBALS['strRichMedia']			= "Richmedia";
$GLOBALS['strTrackAdClicks']			= "Sledovat AdClicks";


// Display limitations
$GLOBALS['strModifyBannerAcl']			= "Nastavení doruèování";
$GLOBALS['strACL']				= "Doruèování";
$GLOBALS['strACLAdd']				= "Pøidat omezení";
$GLOBALS['strACLAdd_Key']			= "Pøidat <u>o</u>mezení";
$GLOBALS['strNoLimitations']			= "Bez omezení";
$GLOBALS['strApplyLimitationsTo']		= "Aplikovat omezení na";
$GLOBALS['strRemoveAllLimitations']		= "Odstranit v¹echna omezení";
$GLOBALS['strEqualTo']				= "je rovno";
$GLOBALS['strDifferentFrom']			= "li¹í se od";
$GLOBALS['strLaterThan']			= "je pozdìji ne¾";
$GLOBALS['strLaterThanOrEqual']			= "je pozdìji nebo rovno";
$GLOBALS['strEarlierThan']			= "je døíve ne¾";
$GLOBALS['strEarlierThanOrEqual']		= "je døíve nebo rovno";
$GLOBALS['strContains']				= "obsahuje";
$GLOBALS['strNotContains']			= "neobsahuje";
$GLOBALS['strAND']				= "A"; 			// logical operator
$GLOBALS['strOR']				= "NEBO"; 		// logical operator
$GLOBALS['strOnlyDisplayWhen']			= "Zobrazit tento banner pouze:";
$GLOBALS['strWeekDay']				= "V pracovní den";
$GLOBALS['strTime']				= "Èas";
$GLOBALS['strUserAgent']			= "Useragent";
$GLOBALS['strDomain']				= "Doména";
$GLOBALS['strClientIP']				= "IP klienta";
$GLOBALS['strSource']				= "Zdroj";
$GLOBALS['strSourceFilter']			= "Filtr zdroje";
$GLOBALS['strBrowser']				= "Prohlí¾eè";
$GLOBALS['strOS']				= "OS";
$GLOBALS['strCountry']				= "Zemì";
$GLOBALS['strContinent']			= "Kontinent";
$GLOBALS['strUSState']				= "US stát";
$GLOBALS['strReferer']				= "Odkazující stránka";
$GLOBALS['strDeliveryLimitations']		= "Omezení doruèování";
$GLOBALS['strDeliveryCapping']			= "Upøesnìní doruèování";
$GLOBALS['strTimeCapping']			= "Pokud ji¾ byl tento banner u¾ivateli zobrazen, nezobrazovat tento banner u¾ivateli po pøí¹tích:";
$GLOBALS['strImpressionCapping']		= "Nezobrazovat jednomu u¾ivateli tento banner vícekrát ne¾:";
$GLOBALS['strImpressionCappingSession']		= "Nezobrazovat tento banner bìhìm jednoho sezení vícekrát ne¾:";

// Publisher
$GLOBALS['strAffiliate']			= "Vydavatel";
$GLOBALS['strAffiliates']			= "Vydavatelé";
$GLOBALS['strAffiliatesAndZones']		= "Vydavatelé & Zóny";
$GLOBALS['strAddNewAffiliate']			= "Pøidat vydavatele";
$GLOBALS['strAddNewAffiliate_Key']		= "Pøidat <u>v</u>ydavatele";
$GLOBALS['strAddAffiliate']			= "Vytvoøit vydavatele";
$GLOBALS['strAffiliateProperties']		= "Nastavení vydavatele";
$GLOBALS['strAffiliateOverview']		= "Pøehled vydavatele";
$GLOBALS['strAffiliateHistory']			= "Historie vydavatele";
$GLOBALS['strZonesWithoutAffiliate']		= "Zóny bez vydavatele";
$GLOBALS['strMoveToNewAffiliate']		= "Pøesunout k novému vydavateli";
$GLOBALS['strNoAffiliates']			= "V tuto chvíli nejsou zadáni ¾ádní vydavatelé";
$GLOBALS['strConfirmDeleteAffiliate']		= "Opravdu si pøejete smazat tohoto vydavatele?";
$GLOBALS['strMakePublisherPublic']		= "Zóny tohoto vydavatele nastavit jako veøejné";
$GLOBALS['strHiddenPublisher']			= "Skrytý vydavatel";
$GLOBALS['strAffiliateInvocation']		= "Zobrazovací kód";
$GLOBALS['strTotalAffiliates']			= "Celkem vydavatelù";


// Publisher (properties)
$GLOBALS['strWebsite']				= "Website";
$GLOBALS['strMnemonic']				= "Mnemonic";
$GLOBALS['strAllowAffiliateModifyInfo']		= "Povolit tomuto u¾ivateli mìnit vlastní nastavení";
$GLOBALS['strAllowAffiliateModifyZones']	= "Povolit tomuto u¾ivateli mìnit vlastní zóny";
$GLOBALS['strAllowAffiliateLinkBanners']	= "Povolit tomuto u¾ivateli pøipojovat vlastní bannery k zónám";
$GLOBALS['strAllowAffiliateAddZone']		= "Povolit tomuto u¾ivateli pøidávat vlastní zóny";
$GLOBALS['strAllowAffiliateDeleteZone']         = "Povolit tomuto u¾ivateli mazat existující zóny";


// Zone
$GLOBALS['strZone']				= "Zóna";
$GLOBALS['strZones']				= "Zóny";
$GLOBALS['strAddNewZone']			= "Pøidat zónu";
$GLOBALS['strAddNewZone_Key']			= "Pøidat <u>z</u>ónu";
$GLOBALS['strAddZone']				= "Vytvoøit zónu";
$GLOBALS['strModifyZone']			= "Upravit zónu";
$GLOBALS['strLinkedZones']			= "Pøipojené zóny";
$GLOBALS['strZoneOverview']			= "Pøehled zóny";
$GLOBALS['strZoneProperties']			= "Nastavení zóny";
$GLOBALS['strZoneHistory']			= "Historie zóny";
$GLOBALS['strNoZones']				= "Zatím nejsou definované ¾ádné zóny";
$GLOBALS['strConfirmDeleteZone']		= "Opravdu chcete smazat tuto zónu?";
$GLOBALS['strZoneType']				= "Typ zóny";
$GLOBALS['strBannerButtonRectangle']		= "Banner, Button nebo Ètverec";
$GLOBALS['strInterstitial']			= "Interstitial nebo Plovoucí DHTML";
$GLOBALS['strPopup']				= "Popup";
$GLOBALS['strTextAdZone']			= "Textová reklama";
$GLOBALS['strShowMatchingBanners']		= "Zobrazit odpovídající bannery";
$GLOBALS['strHideMatchingBanners']		= "Skrýt odpovídající bannery";
$GLOBALS['strTotalZones']			= 'Celkem zón';


// Advanced zone settings
$GLOBALS['strAdvanced']				= "Roz¹íøené";
$GLOBALS['strChains']				= "Vazby";
$GLOBALS['strChainSettings']			= "Nastavení vazby";
$GLOBALS['strZoneNoDelivery']			= "Pokud ¾ádné bannery z této zóny <br>nemohou být zobrazeny sna¾ se...";
$GLOBALS['strZoneStopDelivery']			= "Ukonèi doruèování a nezobrazuj bannery";
$GLOBALS['strZoneOtherZone']			= "Zobraz místo toho jinou zónu";
$GLOBALS['strZoneUseKeywords']			= "Vyber banner na základì ní¾e uvedených klíèových slov";
$GLOBALS['strZoneAppend']			= "V¾dy pøidej následující HTML kód k bannerùm v této zónì";
$GLOBALS['strAppendSettings']			= "Nastavení pøilo¾ení a pøedlo¾ení";
$GLOBALS['strZonePrependHTML']			= "V¾dy pøedlo¾ HTML kód k textové inzerci v této zónì";
$GLOBALS['strZoneAppendHTML']			= "V¾dy pøilo¾ HTML kód k textové inzerci v této zónì";
$GLOBALS['strZoneAppendType']			= "Druh pøipojení";
$GLOBALS['strZoneAppendHTMLCode']		= "HTML kód";
$GLOBALS['strZoneAppendZoneSelection']		= "Popup nebo interstitial";
$GLOBALS['strZoneAppendSelectZone']		= "V¾dy pøilo¾ následující popup nebo intersitial k bannerùm v této zónì";


// Zone probability
$GLOBALS['strZoneProbListChain']		= "®ádný z bannerù pøipojených k této zónì není aktivní. <br>Toto je vazba zóny která bude následována:";
$GLOBALS['strZoneProbNullPri']			= "®ádný z bannerù pøipojených k této zónì není aktivní.";
$GLOBALS['strZoneProbListChainLoop']		= "Následování vazeb zóny mù¾e vytvoøit cyklickou smyèku. Doruèování pro tuto zónu je zastaveno.";


// Linked banners/campaigns
$GLOBALS['strSelectZoneType']			= "Prosím zvolte typ pøipojených bannerù";
$GLOBALS['strBannerSelection']			= "Volba banneru";
$GLOBALS['strCampaignSelection']		= "Volba kampanì";
$GLOBALS['strInteractive']			= "Interaktivní";
$GLOBALS['strRawQueryString']			= "Klíèové slovo";
$GLOBALS['strIncludedBanners']			= "Pøipojené bannery";
$GLOBALS['strLinkedBannersOverview']		= "Pøehled pøipojených bannerù";
$GLOBALS['strLinkedBannerHistory']		= "Historie pøipojených bannerù";
$GLOBALS['strNoZonesToLink']			= "Nejsou k dispozici ¾ádné zóny ke kterým by mohl být tento banner pøipojen";
$GLOBALS['strNoBannersToLink']			= "Nejsou k dispozici ¾ádné bannery které by mohly být pøipojeny k této zonì";
$GLOBALS['strNoLinkedBanners']			= "Nejsou k dispozici ¾ádné bannery pøipojené k této zónì";
$GLOBALS['strMatchingBanners']			= "{count} odpovídajících bannerù";
$GLOBALS['strNoCampaignsToLink']                = "Nejsou k dispozici ¾ádné kampanì které by mohly být pøipojeny k této zónì";
$GLOBALS['strNoTrackersToLink']			= "Nejsou k dispozici ¾ádné sledovaèe které by mohly být pøipojeny k této zónì";
$GLOBALS['strNoZonesToLinkToCampaign']		= "Nejsou k dispozici ¾ádné zóny ke kterým by mohla být tato kampaò pøipojena";
$GLOBALS['strSelectBannerToLink']		= "Zvolte banner který chcete pøipojit k této zónì:";
$GLOBALS['strSelectCampaignToLink']		= "Zvolte kampaò kterou chcete pøipojit k této zónì:";
$GLOBALS['strSelectAdvertiser']			= 'Zvolte inzerenta';
$GLOBALS['strSelectPlacement']			= 'Zvolte kampaò';
$GLOBALS['strSelectAd']				= 'Zvolte banner';


// Statistics
$GLOBALS['strStats']				= "Statistiky";
$GLOBALS['strNoStats']				= "V tuto chvíli nejsou k dispozici ¾ádné statistiky";
$GLOBALS['strConfirmResetStats']		= "Opravdu chcete smazat v¹echny existující statistiky?";
$GLOBALS['strGlobalHistory']			= "Globální historie";
$GLOBALS['strDailyHistory']			= "Denní historie";
$GLOBALS['strDailyStats']			= "Denní statistiky";
$GLOBALS['strWeeklyHistory']			= "Týdenní historie";
$GLOBALS['strMonthlyHistory']			= "Mìsíèní historie";
$GLOBALS['strCreditStats']			= "Statistiky kreditù";
$GLOBALS['strDetailStats']			= "Detailní statistiky";
$GLOBALS['strTotalThisPeriod']			= "Celkem v tomto období";
$GLOBALS['strAverageThisPeriod']		= "Prùmìr v tomto odbobí";
$GLOBALS['strPublisherDistribution']		= "Rozdìlení vydavatelù";
$GLOBALS['strDistribution']			= "Rozdìlení";
$GLOBALS['strOptimise']				= "Optimalizace";
$GLOBALS['strKeywordStatistics']		= "Statistiky klíèových slov";
$GLOBALS['strResetStats']			= "Vynulovat statistiky";
$GLOBALS['strSourceStats']			= "Statistiky zdroje";
$GLOBALS['strSources']				= "Zdroje";
$GLOBALS['strAvailableSources']			= "Dostupné zdroje";
$GLOBALS['strSelectSource']			= "Zvolte zdroj který chcete vidìt:";
$GLOBALS['strSizeDistribution']			= "Rozdìlení podle velikosti";
$GLOBALS['strCountryDistribution']		= "Rozdìlení podle zemì";
$GLOBALS['strEffectivity']			= "Úspì¹nost";
$GLOBALS['strTargetStats']			= "Statistiky cílení";
$GLOBALS['strCampaignTarget']			= "Cílení";
$GLOBALS['strTargetRatio']			= "Pomìr cílení";
$GLOBALS['strTargetModifiedDay']		= "Cílení bylo v prùbehu dne upravováno a cílení nemù¾e být pøesné";
$GLOBALS['strTargetModifiedWeek']		= "Cílení bylo v prùbehu týdne upravováno a cílení nemù¾e být pøesné";
$GLOBALS['strTargetModifiedMonth']		= "Cílení bylo v prùbehu mìsíce upravováno a cílení nemù¾e být pøesné";
$GLOBALS['strNoTargetStats']			= "V tuto chvíli nejsou k dispozici ¾ádné statistiky cílení";
$GLOBALS['strOVerall']				= "Celkové";
$GLOBALS['strByZone']				= "Podle zón";


// Hosts
$GLOBALS['strHosts']				= "Hosté";
$GLOBALS['strTopHosts']				= "Hosté s nejvy¹¹ím poètem dotazù";
$GLOBALS['strTopCountries']			= "Zemì s nejvy¹¹ím po¹tem dotazù";
$GLOBALS['strRecentHosts']			= "Poslední hosté";


// Expiration
$GLOBALS['strExpired']				= "Expirované";
$GLOBALS['strExpiration']			= "Expirace";
$GLOBALS['strNoExpiration']			= "Není zadáno datum expirace";
$GLOBALS['strEstimated']			= "Pøedpokládaná expirace";


// Reports
$GLOBALS['strReports']				= "Pøehledy";
$GLOBALS['strSelectReport']			= "Vyberte pøehled který chcete vygenerovat";
$GLOBALS['strStartDate']			= "Poèáteèní datum";
$GLOBALS['strEndDate']				= "Koncové datum";


// Userlog
$GLOBALS['strUserLog']				= "U¾ivatelský log";
$GLOBALS['strUserLogDetails']			= "Datily u¾ivatelského logu";
$GLOBALS['strDeleteLog']			= "Smazat log";
$GLOBALS['strAction']				= "Akce";
$GLOBALS['strNoActionsLogged']			= "®ádné akce se nelogují";


// Code generation
$GLOBALS['strGenerateBannercode']		= "Pøímá volba";
$GLOBALS['strChooseInvocationType']		= "Prosím zvolte typ volání banneru";
$GLOBALS['strGenerate']				= "Vygenerovat";
$GLOBALS['strParameters']			= "Parametry";
$GLOBALS['strFrameSize']			= "Velikost frame";
$GLOBALS['strBannercode']			= "Kód banneru";
$GLOBALS['strTrackercode']			= "Kód sledovaèe";
$GLOBALS['strOptional']				= "volitelný";


// Errors
$GLOBALS['strMySQLError']			= "Chyba SQL:";
$GLOBALS['strLogErrorClients']			= "[phpAds] Nastala chyba pøi pokusu naèíst inzerenty z databáze.";
$GLOBALS['strLogErrorBanners']			= "[phpAds] Nastala chyba pøi pokusu naèíst bannery z databáze.";
$GLOBALS['strLogErrorViews']			= "[phpAds] Nastala chyba pøi pokusu naèíst zobrazení z databáze.";
$GLOBALS['strLogErrorClicks']			= "[phpAds] Nastala chyba pøi pokusu naèíst kliknutí z databáze.";
$GLOBALS['strLogErrorConversions']		= "[phpAds] Nastala chyba pøi pokusu naèíst prodeje z databáze.";
$GLOBALS['strErrorViews']			= "Musíte zadat poèet zobrazení nebo zvolit neomezený !";
$GLOBALS['strErrorNegViews']			= "Záporný poèet zobrazní není povolen";
$GLOBALS['strErrorClicks']			= "Musíte zadat poèet kliknutí nebo zvolit neomezený !";
$GLOBALS['strErrorNegClicks']			= "Záporný poèet kliknutí není povolen";
$GLOBALS['strErrorConversions'] 		= "Musíte zadat poèet prodejù nebo zvolit neomezený !";
$GLOBALS['strErrorNegConversions'] 		= "Záporný poèet prodejù není povolen";
$GLOBALS['strNoMatchesFound']			= "®edné odpovídající záznamy nebyly nalezeny";
$GLOBALS['strErrorOccurred']			= "Nastala chyba";
$GLOBALS['strErrorUploadSecurity']		= "Byl zji¹tìn potencionální bezpeèností problém, nahrávání ukonèeno !";
$GLOBALS['strErrorUploadBasedir']		= "Nemohu otevøít nahraný soubor zøejmì z dùvodu bezpeèného re¾imu nebo open_basedir omezení";
$GLOBALS['strErrorUploadUnknown']		= "Menohu otevøít nahraný soubor z neznámého dùvodu. Prosím zkontrolujte va¹i konfiguraci PHP";
$GLOBALS['strErrorStoreLocal']			= "Nastala chyba pøi pokusu o ulo¾ení banneru do lokálního adresáøe. Toto je zøejmì následek ¹patné konfigurace nastavení lokálních cest";
$GLOBALS['strErrorStoreFTP']			= "Nastala chyba pøi pokusu o nahrání banneru na FTP server. Toto mù¾e být zpùsobeno nedostupností serveru nebo ¹patnou konfigurací nastavení FTP serveru";
$GLOBALS['strErrorDBPlain']			= "Nastala chyba pøi pøístupu do databáze";
$GLOBALS['strErrorDBSerious']			= "Byl zji¹tìn záva¾ný problém pøi pøístupu do databáze";
$GLOBALS['strErrorDBNoDataPlain']		= "Vzhledem k promlémùm s databází, ".$phpAds_productname." nemù¾e naèíst ani ukládat data. ";
$GLOBALS['strErrorDBNoDataSerious']		= "Vzhledem k záva¾ným promlémùm s databází, ".$phpAds_productname." nemù¾e naèíst data";
$GLOBALS['strErrorDBCorrupt']			= "Databázová tabulka je pravdìpodobnì po¹kozena a potøebuje opravit. Pro více informací o opravování po¹kozených tabulek prosím ètìte kapitolu <i>Troubleshooting</i> v pøíruèce <i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact']			= "Prosím kontaktujte správce tohoto serveru a oznamte jemu nebo jí tento problém.";
$GLOBALS['strErrorDBSubmitBug']			= "Pokud je tento problém reprodukovatelný, mù¾e být zpùsoben chybou v ".$phpAds_productname.". Prosím poskytnìte následující informace tvùrcùm ".$phpAds_productname.". Také se pokuste popsat kroky které vedly k této chybì jak nejpøesnìji je to jen mo¾né.";
$GLOBALS['strMaintenanceNotActive']		= "Skript pro správu systému nebyl spu¹tìn v prùbìhu posledních 24 hodin. \\nAby mohl ".$phpAds_productname." korektnì fungovat je nutné aby bì¾el ka¾dou \\nhodinu. \\n\\nProsím pøeètìte si pøíruèku Administrators guide pro informace \\no konfiguraci skriptu pro správu systému.";
$GLOBALS['strErrorBadUserType']			= "Systém nedokázal urèit druh vašeho uživatelského úètu!";

// E-mail
$GLOBALS['strMailSubject']			= "Prehled inzerenta";
$GLOBALS['strAdReportSent']			= "Pøehled inzerenta odeslán";
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
$GLOBALS['strWarnClientTxt']			= "Zbyvajici kliknuti nebo zobrazeni pro vase bannery se blizi k {limit}. \nVa¹e bannery budou vypnuté a¾ nezbydou ¾ádné AdClicks nebo AdViews. ";
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
$GLOBALS['strAgencyManagement']			= "Správa partnerù";
$GLOBALS['strAgency']				= "Partner";
$GLOBALS['strAgencies']				= "Partneøi";
$GLOBALS['strAddAgency']			= "Pøidat partnera";
$GLOBALS['strAddAgency_Key']			= "Pøidat <u>n</u>ového partnera";
$GLOBALS['strTotalAgencies']			= "Celkem partnerù";
$GLOBALS['strAgencyProperties']			= "Vlastnosti partnera";
$GLOBALS['strNoAgencies']			= "V tuto chvíli nejsou definování žádní partneøi";
$GLOBALS['strConfirmDeleteAgency']		= "Opravdu chcete smazat tohoto partnera?";
$GLOBALS['strHideInactiveAgencies']		= "Skrýt neaktivní partnery";
$GLOBALS['strInactiveAgenciesHidden']		= "neaktivních partnerù skryto";

// Tracker Variables
$GLOBALS['strVariableName']			= "Název promìnné";
$GLOBALS['strVariableDescription']		= "Popis";
$GLOBALS['strVariableType']			= "Typ promìnné";
$GLOBALS['strVariableDataType']			= "Datový typ";
$GLOBALS['strJavascript']			= "Javascript";
$GLOBALS['strRefererQuerystring']		= "Øetìzec referera";
$GLOBALS['strQuerystring']	     		= "Øetìzec";
$GLOBALS['strInteger']				= "Èíslo";
$GLOBALS['strString']				= "String";
$GLOBALS['strTrackFollowingVars']		= "Sledovat tuto promìnnou";
$GLOBALS['strAddVariable']			= "Pøidat promìnnou";
$GLOBALS['strNoVarsToTrack']			= "Žádné promìnné ke sledování.";



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

?>
