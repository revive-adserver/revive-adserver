<?php // $Revision: 1.17.2.5 $

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/*                                                                      */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/




// German 
// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']  		= "ltr";  // links nach rechts
$GLOBALS['phpAds_TextAlignRight'] 		= "right";
$GLOBALS['phpAds_TextAlignLeft']  		= "left";

$GLOBALS['phpAds_DecimalPoint']			= ','; 
$GLOBALS['phpAds_ThousandsSeperator']	= '.';


// Date & time configuration
$GLOBALS['date_format']				= "%d-%m-%Y";
$GLOBALS['time_format']				= "%H:%M:%S";
$GLOBALS['minute_format']			= "%H:%M";
$GLOBALS['month_format']			= "%m-%Y";
$GLOBALS['day_format']				= "%d-%m";
$GLOBALS['week_format']				= "%W-%Y";
$GLOBALS['weekiso_format']			= "%V-%G";



/*********************************************************/
/* Translations                                          */
/*********************************************************/

$GLOBALS['strHome'] 				= "Startseite";
$GLOBALS['strHelp']					= "Hilfe";
$GLOBALS['strNavigation'] 			= "Navigation";
$GLOBALS['strShortcuts'] 			= "Schnellnavigation";
$GLOBALS['strAdminstration'] 		= "Bannerverwaltung";
$GLOBALS['strMaintenance']			= "Wartung";
$GLOBALS['strProbability']			= "Wahrscheinlichkeit";
$GLOBALS['strInvocationcode']		= "Bannercode (in HTML-Seite)";
$GLOBALS['strBasicInformation'] 	= "Stammdaten";
$GLOBALS['strContractInformation'] 	= "Vertragsinformationen";
$GLOBALS['strLoginInformation'] 	= "Login-Information";
$GLOBALS['strOverview']				= "Übersicht";
$GLOBALS['strSearch']				= "<u>S</u>uchen";
$GLOBALS['strHistory']				= "Entwicklung";
$GLOBALS['strPreferences'] 			= "(persönliche) Einstellungen";
$GLOBALS['strDetails']				= "Details";
$GLOBALS['strCompact']				= "Kompakt";
$GLOBALS['strVerbose']				= "Detailliert";
$GLOBALS['strUser']					= "Benutzer"; 
$GLOBALS['strEdit']					= "Bearbeiten";
$GLOBALS['strCreate']				= "Erstellen";
$GLOBALS['strDuplicate']			= "Kopieren";
$GLOBALS['strMoveTo']				= "Verschieben nach";
$GLOBALS['strDelete'] 				= "Löschen";
$GLOBALS['strActivate']				= "Aktivieren";
$GLOBALS['strDeActivate'] 			= "Deaktivieren";
$GLOBALS['strConvert']				= "Konvertieren";
$GLOBALS['strRefresh']				= "Aktualisieren";
$GLOBALS['strSaveChanges']			= "Änderungen speichern";
$GLOBALS['strUp'] 					= "Oben";
$GLOBALS['strDown'] 				= "Unten";
$GLOBALS['strSave'] 				= "Speichern";
$GLOBALS['strCancel']				= "Abbrechen";
$GLOBALS['strPrevious'] 			= "Zurück";
$GLOBALS['strPrevious_Key'] 		= "<u>Z</u>urück";
$GLOBALS['strNext'] 				= "Weiter";
$GLOBALS['strNext_Key'] 			= "<u>W</u>eiter";
$GLOBALS['strYes']					= "Ja";
$GLOBALS['strNo']					= "Nein";
$GLOBALS['strNone'] 				= "Keine";
$GLOBALS['strCustom']				= "Benutzerdefiniert";
$GLOBALS['strDefault'] 				= "Voreinstellung";
$GLOBALS['strOther']				= "Andere(r)";
$GLOBALS['strUnknown']				= "Unbekannt";
$GLOBALS['strUnlimited'] 			= "Unbegrenzt";
$GLOBALS['strUntitled']				= "Ohne Titel";
$GLOBALS['strAll'] 					= "alle";
$GLOBALS['strAvg'] 					= "&Oslash;";
$GLOBALS['strAverage']				= "Durchschnitt";
$GLOBALS['strOverall'] 				= "Gesamt";
$GLOBALS['strTotal'] 				= "Summe";
$GLOBALS['strActive'] 				= "aktive";
$GLOBALS['strFrom']					= "Von";
$GLOBALS['strTo']					= "bis";
$GLOBALS['strLinkedTo'] 			= "verknüpft mit";
$GLOBALS['strDaysLeft'] 			= "Verbliebene Tage";
$GLOBALS['strCheckAllNone']			= "Prüfe alle / keine";
$GLOBALS['strKiloByte']				= "KB";
$GLOBALS['strExpandAll']			= "Alle <u>a</u>usklappen"; 
$GLOBALS['strCollapseAll']			= "Alle <u>z</u>usammenklappen"; 
$GLOBALS['strShowAll']				= "Alle anzeigen";
$GLOBALS['strNoAdminInteface']		= "Service nicht verfügbar ...";
$GLOBALS['strFilterBySource']			= "filtern nach Quelle";
$GLOBALS['strFieldContainsErrors']		= "[phpAds] Folgende Felder sind fehlerhaft:";
$GLOBALS['strFieldFixBeforeContinue1']	= "Bevor Sie fortgefahren können, müssen Sie";
$GLOBALS['strFieldFixBeforeContinue2']	= "diese Fehler beheben.";
$GLOBALS['strDelimiter']			= "Trennzeichen";
$GLOBALS['strMiscellaneous']		= "Weitere Auswertungen";

$GLOBALS['strUseQuotes']			= "Anführungszeichen";


// Properties
$GLOBALS['strName']					= "Name";
$GLOBALS['strSize']					= "Größe";
$GLOBALS['strWidth'] 				= "Breite";
$GLOBALS['strHeight'] 				= "Höhe";
$GLOBALS['strURL2']					= "URL";
$GLOBALS['strTarget']				= "Zielfenster";
$GLOBALS['strLanguage'] 			= "Sprache";
$GLOBALS['strDescription'] 			= "Beschreibung";
$GLOBALS['strID']					= "ID";


// Login & Permissions
$GLOBALS['strAuthentification'] 	= "Authentifikation"; 
$GLOBALS['strWelcomeTo']			= "Willkommen bei";
$GLOBALS['strEnterUsername']		= "Geben Sie Benutzername und Kennwort ein";
$GLOBALS['strEnterBoth']			= "Bitte beides eingeben; Benutzername und Kennwort";
$GLOBALS['strEnableCookies']		= "Es müssen Cookies aktiviert werden, damit ".$phpAds_productname." genutzt werden kann.";
$GLOBALS['strLogin'] 				= "Login";
$GLOBALS['strLogout'] 				= "Logout";
$GLOBALS['strUsername'] 			= "Benutzername";
$GLOBALS['strPassword']				= "Kennwort";
$GLOBALS['strAccessDenied']			= "Zugang verweigert";
$GLOBALS['strPasswordWrong']		= "Das Kennwort ist nicht korrekt";
$GLOBALS['strNotAdmin']				= "Sie haben nicht ausreichend Privilegien";
$GLOBALS['strDuplicateClientName']	= "Der gewählte Benutzername existiert bereits. Bitte einen anderen wählen.";
$GLOBALS['strInvalidPassword']		= "Das neue Kennwort ist ungültig. Bitte wählen Sie ein anderes.";
$GLOBALS['strNotSamePasswords']		= "Die beiden eingegebenen Kennwörter stimmen nicht überein ";
$GLOBALS['strRepeatPassword']		= "Wiederhole Kennwort";
$GLOBALS['strOldPassword']			= "Altes Kennwort";
$GLOBALS['strNewPassword']			= "Neues Kennwort";




// General advertising
$GLOBALS['strViews'] 				= "AdViews";
$GLOBALS['strClicks']				= "AdClicks";
$GLOBALS['strCTRShort'] 			= "Klickrate (CTR)";
$GLOBALS['strCTR'] 					= "Klickrate (CTR)";
$GLOBALS['strTotalViews'] 			= "Summe AdViews";
$GLOBALS['strTotalClicks'] 			= "Summe AdClicks";
$GLOBALS['strViewCredits'] 			= "Guthaben AdViews";
$GLOBALS['strClickCredits'] 		= "Guthaben AdClicks";


// Time and date related
$GLOBALS['strDate'] 				= "Datum";
$GLOBALS['strToday'] 				= "Heute";
$GLOBALS['strDay']					= "Tag";
$GLOBALS['strDays']					= "Tage";
$GLOBALS['strLast7Days']			= "letzten 7 Tage";
$GLOBALS['strWeek'] 				= "Woche";
$GLOBALS['strWeeks']				= "Wochen";
$GLOBALS['strMonths']				= "Monate";
$GLOBALS['strThisMonth'] 			= "In diesem Monat";
$GLOBALS['strMonth'] 				= array("Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
$GLOBALS['strDayShortCuts'] 		= array("So","Mo","Di","Mi","Do","Fr","Sa");
$GLOBALS['strHour']					= "Stunde";
$GLOBALS['strSeconds']				= "Sekunden";
$GLOBALS['strMinutes']				= "Minuten";
$GLOBALS['strHours']				= "Stunden";
$GLOBALS['strTimes']				= "mal";


// Advertiser
$GLOBALS['strClient']				= "Inserent";
$GLOBALS['strClients'] 				= "Inserenten";
$GLOBALS['strClientsAndCampaigns']	= "Inserenten &amp; Kampagnen";
$GLOBALS['strAddClient'] 			= "Neuen Inserenten hinzufügen";
$GLOBALS['strAddClient_Key'] 		= "<u>N</u>euen Inserenten hinzufügen";
$GLOBALS['strTotalClients'] 		= "Summe Inserenten";
$GLOBALS['strClientProperties']		= "Inserentenmerkmale";
$GLOBALS['strClientHistory']		= "Entwicklung Inserenten";
$GLOBALS['strNoClients']			= "Derzeit sind keine Inserenten definiert";
$GLOBALS['strConfirmDeleteClient'] 		= "Soll dieser Inserent wirklich gelöscht werden?";
$GLOBALS['strConfirmResetClientStats']	= "Sollen wirklich alle Statistiken dieses Inserenten gelöscht werden?";
$GLOBALS['strHideInactiveAdvertisers']	= "Verberge inaktive Inserenten";
$GLOBALS['strInactiveAdvertisersHidden']	= "inaktive Inserenten sind verborgen";


// Advertisers properties
$GLOBALS['strContact'] 				= "Name der Kontaktperson";
$GLOBALS['strEMail'] 				= "eMail";
$GLOBALS['strSendAdvertisingReport']	= "Versenden eines Berichtes via eMail";
$GLOBALS['strNoDaysBetweenReports']		= "Anzahl Tage zwischen zwei Berichten";
$GLOBALS['strSendDeactivationWarning']  = "Versenden einer Warnung, wenn Kampagne deaktiviert ist";
$GLOBALS['strAllowClientModifyInfo'] 	= "Inserent darf eigene Einstellungen verändern";
$GLOBALS['strAllowClientModifyBanner'] 	= "Inserent darf eigene Banner verändern";
$GLOBALS['strAllowClientAddBanner'] 	= "Inserent darf eigene Banner hinzufügen";
$GLOBALS['strAllowClientDisableBanner'] = "Inserent darf eigene Banner deaktivieren";
$GLOBALS['strAllowClientActivateBanner'] 	= "Inserent darf eigene Banner aktiveren";


// Campaign
$GLOBALS['strCampaign']				= "Kampagne";
$GLOBALS['strCampaigns']			= "Kampagnen";
$GLOBALS['strTotalCampaigns'] 		= "Summe Kampagnen";
$GLOBALS['strActiveCampaigns'] 		= "Aktive Kampagnen";
$GLOBALS['strAddCampaign'] 			= "Neue Kampagnen hinzufügen";
$GLOBALS['strAddCampaign_Key'] 		= "<u>N</u>eue Kampagnen hinzufügen";
$GLOBALS['strCreateNewCampaign']	= "Kampagne erstellen";
$GLOBALS['strModifyCampaign']		= "Kampagne ändern";
$GLOBALS['strMoveToNewCampaign']	= "Verschieben zu einer neuen Kampagne";
$GLOBALS['strBannersWithoutCampaign']	= "Banner ohne Kampagne";
$GLOBALS['strDeleteAllCampaigns']		= "Alle Kampagnen löschen";
$GLOBALS['strCampaignStats']			= "Kampagnenstatistik";
$GLOBALS['strCampaignProperties']		= "Kampagnenmerkmale";
$GLOBALS['strCampaignOverview']			= "Übersicht Kampagnen";
$GLOBALS['strCampaignHistory']			= "Entwicklung Kampagnen";
$GLOBALS['strNoCampaigns']			= "Derzeit keine Kampagnen definiert";
$GLOBALS['strConfirmDeleteAllCampaigns']	= "Sollen wirklich alle Kampagnen dieses Inserenten gelöscht werden?";
$GLOBALS['strConfirmDeleteCampaign']		= "Soll diese Kampagne wirklich gelöscht werden?";
$GLOBALS['strConfirmResetCampaignStats']	= "Sollen wirklich alle Statistiken dieser Kampagne gelöscht werden?";
$GLOBALS['strHideInactiveCampaigns']		= "Verberge inaktive Kampagnen";
$GLOBALS['strInactiveCampaignsHidden']		= "inaktive Kampagne sind verborgen";

///
// Campaign properties
$GLOBALS['strDontExpire']			= "Kampagne nicht zu einem bestimmten Datum beenden ";
$GLOBALS['strActivateNow'] 			= "Kampagne sofort beginnen";
$GLOBALS['strLow']					= "Gering";
$GLOBALS['strHigh']					= "Hoch";
$GLOBALS['strExpirationDate']		= "Auslaufdatum";
$GLOBALS['strActivationDate']		= "Aktivierungsdatum";
$GLOBALS['strViewsPurchased'] 		= "Guthaben AdViews";
$GLOBALS['strClicksPurchased'] 		= "Guthaben AdClicks";
$GLOBALS['strCampaignWeight']		= "Gewichtung der Kampagne";
$GLOBALS['strHighPriority']			= "Anzeige von Bannern aus dieser Kampagne mit hoher Priorität.<br>Bei Auswahl dieser Option wird ".$phpAds_productname." zunächst vorrangig diese Banner und über den Tag gleichmäßig verteilt ausliefern.";
$GLOBALS['strLowPriority']			= " Anzeige von Bannern aus dieser Kampagne mit geringer Priorität.<br>Diese Kampagne nutzt die überzählingen, nicht von Kampagnen mit höherer Priorität benötigten AdViews.";
$GLOBALS['strTargetLimitAdViews']	= "Begrenzung der AdViews auf";
$GLOBALS['strTargetPerDay']			= "pro Tag.";
$GLOBALS['strPriorityAutoTargeting']	= "Gleichmäßiges Verteilen der verbleibenden AdViews über die verbleibenden Tage. Täglich erfolgt eine Neuberechnung.";
$GLOBALS['strCampaignWarningNoWeight']	= "Die Priorität der Kampagne ist niedrig gesetzt. \nAber die Gewichtung ist 0 (Null)oder sie ist \nnicht definiert. Dadurch wird diese Kampagne inaktiv \nbleiben. Banner werden nicht ausgeliefert bis\neine gültige Gewichtung eingegeben wurde. \n\nWollen Sie fortfahren?";

$GLOBALS['strCampaignWarningNoTarget']	= "Die Priorität dieser Kampagne ist hoch gesetzt. \nAber die Anzahl der AdViews sind nicht angegeben. \nDadurch wird die Kampagne inaktiv bleiben. \nBanner werden nicht ausgeliefert, bis eine\ngültige Eingabe über die Höhe \der AdViews eingegeben wurde. \n\n Wollen Sie fortfahren?";


// Banners (General)
$GLOBALS['strBanner'] 				= "Banner";
$GLOBALS['strBanners'] 				= "Banner";
$GLOBALS['strAddBanner'] 			= "Neuen Banner hinzufügen";
$GLOBALS['strAddBanner_Key'] 		= " <u>N</u>euen Banner hinzufügen ";
$GLOBALS['strModifyBanner'] 		= "Banner verändern";
$GLOBALS['strActiveBanners'] 		= "Aktive Banner";
$GLOBALS['strTotalBanners'] 		= "Summe Banner";
$GLOBALS['strShowBanner']			= "Banner anzeigen";
$GLOBALS['strShowAllBanners']	 	= "Alle Banner anzeigen";
$GLOBALS['strShowBannersNoAdClicks']	= " Alle Banner ohne AdClicks anzeigen";
$GLOBALS['strShowBannersNoAdViews']		= " Alle Banner ohne AdViews anzeigen ";
$GLOBALS['strDeleteAllBanners']	 		= "Alle Banner löschen";
$GLOBALS['strActivateAllBanners']		= "Alle Banner aktivieren";
$GLOBALS['strDeactivateAllBanners']		= "Alle Banner deaktivieren";
$GLOBALS['strBannerOverview']		= "Übersicht Banner";
$GLOBALS['strBannerProperties']		= "Bannermerkmale";
$GLOBALS['strBannerHistory']		= "Entwicklung Banner";
$GLOBALS['strBannerNoStats'] 		= "Keine Statistiken für den Banner vorhanden ";
$GLOBALS['strNoBanners']			= "Zur Zeit keine Banner definiert";
$GLOBALS['strConfirmDeleteBanner']	= "Soll dieser Banner wirklich gelöscht werden?";
$GLOBALS['strConfirmDeleteAllBanners']	= "Sollen tatsächlich alle Banner dieser Kampagne gelöscht werden?";
$GLOBALS['strConfirmResetBannerStats']	= "Sollen tatsächlich alle Statistiken für diesen Banner gelöscht werden?";
$GLOBALS['strShowParentCampaigns']		= "Zugehörige Kampagnen anzeigen"; 
$GLOBALS['strHideParentCampaigns']		= "Zugehörige Kampagnen verbergen";
$GLOBALS['strHideInactiveBanners']		= "Inaktive Banner verbergen";
$GLOBALS['strInactiveBannersHidden']	= "inaktive Banner sind verborgen";
$GLOBALS['strAppendOthers']			= "Anhänge/Ergänzungen";
$GLOBALS['strAppendTextAdNotPossible']	= "Es ist nicht möglich, ein Banner an eine Textanzeige anzuhängen.";


// Banner (Properties)
$GLOBALS['strChooseBanner'] 		= "Bannertype auswählen";
$GLOBALS['strMySQLBanner'] 			= "Banner in Datenbank speichern (SQL)";
$GLOBALS['strWebBanner'] 			= " Banner auf Webserver (lokal)";
$GLOBALS['strURLBanner'] 			= " Banner über URL verwalten ";
$GLOBALS['strHTMLBanner'] 			= "HTML-Banner";
$GLOBALS['strTextBanner'] 			= " Textanzeige";
$GLOBALS['strAutoChangeHTML']		= " HTML-Code zum Aufzeichnen der AdClicks modifizieren ";
$GLOBALS['strUploadOrKeep']			= "Soll die vorhandene <br>Bilddatei behalten werden, oder soll <br>ein neues geladen werden?";
$GLOBALS['strNewBannerFile'] 		= "Wählen Sie die Bilddatei <br>für diesen Banner<br><br>";
$GLOBALS['strNewBannerURL'] 		= " Bild-URL (incl. http://)";
$GLOBALS['strURL'] 				= "Ziel-URL (incl. http://)";
$GLOBALS['strHTML'] 				= "HTML";
$GLOBALS['strTextBelow'] 			= "Text unterhalb Banner";
$GLOBALS['strKeyword'] 				= "Schlüsselwörter";
$GLOBALS['strWeight'] 				= "Gewichtung";
$GLOBALS['strAlt'] 					= "Alt-Text";
$GLOBALS['strStatusText']			= "Status-Text";
$GLOBALS['strBannerWeight']			= "Bannergewichtung";


// Banner (swf)
$GLOBALS['strCheckSWF']				= "Prüfung nach direktem Link (hard-coded) innerhalb der Flash-Datei";
$GLOBALS['strConvertSWFLinks']		= "direkten Flash-Link konvertieren";
$GLOBALS['strHardcodedLinks']		= "direkter Link (hard-coded)";
$GLOBALS['strConvertSWF']			= "<br>
In der gerade geladenen Flash-Datei befinden sich direkte URL-Links (hard-coded). Direkte URL-Links können von ".$phpAds_productname." nicht aufgezeichnet werden. Sie müssen hierfür entsprechend konvertiert werden. Nachfolgend finden Sie eine Auflistung aller URL-Links innerhalb der Flash-Datei. Für die Konvertierung dieser URL-Links muß <i><b>Konvertieren</i></b> gedrückt werden. Mit <i><b>Abbrechen</i></b> wird der Vorgang ohne Veränderung beendet.<br><br>
Bitte beachten Sie, daß die Flash-Datei nach <i><b>Konvertieren</i></b> im Programmcode verändert ist. Erstellen Sie vorab eine Sicherungskopie. Unabhängig der verwendeten Flash-Version benötigt die neu erstellte Flash-Datei für eine korrekte Darstellung Flash 4 oder höher.<br><br>";
$GLOBALS['strCompressSWF']			= "Komprimieren der SWF-Datei für eine schnellere Übertragung zum Browser (Flash 6 wird benötigt)";
$GLOBALS['strOverwriteSource']		= "Überschreiben der Parameter im Quelltext";


// Banner (network)
$GLOBALS['strBannerNetwork']		= "HTML-Template";
$GLOBALS['strChooseNetwork']		= "Auswahl des HTML-Template";
$GLOBALS['strMoreInformation']		= "Weitere Informationen...";
$GLOBALS['strRichMedia']			= "Richmedia";
$GLOBALS['strTrackAdClicks']		= "Aufzeichen der AdClicks";


// Display limitations
$GLOBALS['strModifyBannerAcl'] 		= "Auslieferungsoptionen";
$GLOBALS['strACL'] 					= "Auslieferungsoptionen";  // war vorher "Bannerauslieferung" ggf. zurueckaendern
$GLOBALS['strACLAdd'] 				= "Neue Beschränkung hinzufügen";
$GLOBALS['strACLAdd_Key'] 			= " <u>N</u>eue Beschränkung hinzufügen ";
$GLOBALS['strNoLimitations']		= "Keine Beschränkungen";
$GLOBALS['strApplyLimitationsTo']	= "Beschränkungen anwenden bei";
$GLOBALS['strRemoveAllLimitations']	= "Alle Beschränkungen löschen";
$GLOBALS['strEqualTo']				= "ist gleich";
$GLOBALS['strDifferentFrom']		= "ist ungleich";
$GLOBALS['strLaterThan']			= "ist später als";
$GLOBALS['strLaterThanOrEqual']		= "ist später als oder genau am";
$GLOBALS['strEarlierThan']			= "ist früher als";
$GLOBALS['strEarlierThanOrEqual']	= "ist früher als oder genau am";
$GLOBALS['strContains']				= "beinhaltet";
$GLOBALS['strNotContains']			= "beinhaltet nicht";
$GLOBALS['strAND']					= "UND"; 	// logical operator
$GLOBALS['strOR']					= "ODER"; 	// logical operator
$GLOBALS['strOnlyDisplayWhen']		= "Diesen Banner nur anzeigen, wenn:";
$GLOBALS['strWeekDay'] 				= "Wochentag";
$GLOBALS['strTime'] 				= "Zeit";
$GLOBALS['strUserAgent'] 			= "User Agent"; 
$GLOBALS['strDomain'] 				= "Domain";
$GLOBALS['strClientIP'] 			= "IP-Adresse";
$GLOBALS['strSource'] 				= "Quelle";
$GLOBALS['strBrowser'] 				= "Browser";
$GLOBALS['strOS'] 					= "Betriebsystem";
$GLOBALS['strCountry'] 				= "Land";
$GLOBALS['strContinent'] 			= "Kontinent";
$GLOBALS['strUSState']				= "US-Bundesstaaten";
$GLOBALS['strReferer'] 				= "Referenzseite";
$GLOBALS['strDeliveryLimitations']	= "Auslieferungsbeschränkungen";
$GLOBALS['strDeliveryCapping']		= "Bannereinblendung kappen <i>(nach Anzahl oder zeitlich)</i>"; 
$GLOBALS['strTimeCapping']			= " Diesen Banner Besuchern erst wieder zeigen nach:";
$GLOBALS['strImpressionCapping']	= "Diesen Banner einem Besucher nicht mehrmals zeigen als:";


// Publisher
$GLOBALS['strAffiliate']				= "Verleger";
$GLOBALS['strAffiliates']				= " Verleger ";
$GLOBALS['strAffiliatesAndZones']		= " Verleger &amp; Zonen";
$GLOBALS['strAddNewAffiliate']			= " Neuen Verleger hinzufügen";
$GLOBALS['strAddNewAffiliate_Key']		= " <u>N</u>euen Verleger hinzufügen";
$GLOBALS['strAddAffiliate']				= " Verleger erstellen";
$GLOBALS['strAffiliateProperties']		= " Verlegermerkmale"; 
$GLOBALS['strAffiliateOverview']		= " Übersicht Verleger";
$GLOBALS['strAffiliateHistory']			= "Entwicklung Verleger";
$GLOBALS['strZonesWithoutAffiliate']	= "Zonen ohne Verleger";
$GLOBALS['strMoveToNewAffiliate']		= "Verschiebe zu neuem Verleger ";
$GLOBALS['strNoAffiliates']				= "Derzeit sind keine Verleger definiert";
$GLOBALS['strConfirmDeleteAffiliate']	= "Soll dieser Verleger tatsächlich gelöscht werden?";
$GLOBALS['strMakePublisherPublic']		= "Mache die Zonen dieses Verleger öffentlich zugänglich ";


// Publisher (properties)
$GLOBALS['strWebsite']						= "Webseite";
$GLOBALS['strAllowAffiliateModifyInfo']	 	= "Verleger darf eigene Einstellungen ändern ";
$GLOBALS['strAllowAffiliateModifyZones'] 	= "Verleger darf eigene Zonen ändern ";
$GLOBALS['strAllowAffiliateLinkBanners'] 	= "Verleger darf Banner seinen Zonen hinzufügen ";
$GLOBALS['strAllowAffiliateAddZone'] 		= "Verleger darf neue eigene Zonen hinzufügen ";
$GLOBALS['strAllowAffiliateDeleteZone']	 	= "Verleger darf eigene Zonen löschen ";


// Zone
$GLOBALS['strZone']					= "Zone";
$GLOBALS['strZones']				= "Zonen";
$GLOBALS['strAddNewZone']			= "Neue Zone hinzufügen";
$GLOBALS['strAddNewZone_Key']		= " <u>N</u>eue Zone hinzufügen ";
$GLOBALS['strAddZone']				= "Zone erstellen";
$GLOBALS['strModifyZone']			= "Zone ändern";
$GLOBALS['strLinkedZones']			= "Verknüpfte Zonen";
$GLOBALS['strZoneOverview']			= "Übersicht Zonen";
$GLOBALS['strZoneProperties']		= "Zonenmerkmale";
$GLOBALS['strZoneHistory']			= "Entwicklung Zonen";
$GLOBALS['strNoZones']				= "Zur Zeit keine Zonen festgelegt";
$GLOBALS['strConfirmDeleteZone']	= "Soll diese Zone tatsächlich gelöscht werden?";
$GLOBALS['strZoneType']				= "Zonentype";
$GLOBALS['strBannerButtonRectangle']	= "Banner, Button oder Rechteck";
$GLOBALS['strInterstitial']			= "Interstitial oder Floating DHTML";
$GLOBALS['strPopup']				= "PopUp";
$GLOBALS['strTextAdZone']			= "Textanzeige";
$GLOBALS['strShowMatchingBanners']	= "Anzeige zugehörende Banner";
$GLOBALS['strHideMatchingBanners']	= "Verbergen zugehörende Banner";


// Advanced zone settings
$GLOBALS['strAdvanced']				= "Erweitert";
$GLOBALS['strChains']				= "Verkettung";
$GLOBALS['strChainSettings']		= "Einstellung Verkettung"; 
$GLOBALS['strZoneNoDelivery']		= "Wenn kein Banner dieser Zone <br>ausgeliefert werden kann, dann versuche...";
$GLOBALS['strZoneStopDelivery']		= "Bannerauslieferung stoppen; keine Banner anzeigen";
$GLOBALS['strZoneOtherZone']		= "Die gewählte Zone wird anstelle dessen angezeigt";
$GLOBALS['strZoneUseKeywords']		= "Banner auswählen, welches nachfolgende Schlüsselwörter hat ";
$GLOBALS['strZoneAppend']			= "Immer diesen HTML-Code den Bannern aus dieser Zone anhängen ";
$GLOBALS['strAppendSettings']		= "Einstellungen für Anhänge/Ergänzungen";
$GLOBALS['strZonePrependHTML']		= "Immer diesen HTML-Code den Testanzeigen aus dieser Zone voranstellen ";
$GLOBALS['strZoneAppendHTML']		= "Immer diesen HTML-Code den Testanzeigen aus dieser Zone anhängen ";

$GLOBALS['strZoneAppendType']			= "Type (Anhang)";

// Zone probability
$GLOBALS['strZoneProbListChain']		= "Die Banner dieser Zone(n) sind nicht aktiv. Die Zonen sind miteinander verkettet.<br>
Die Verkettung ist (von links nach rechts):"; 
$GLOBALS['strZoneProbNullPri']			= "Alle Banner dieser Zone sind nicht aktiv";
$GLOBALS['strZoneProbListChainLoop']	= "Die Verkettung dieser Zone(n) ist eine Endlosschleife. Die Bannerauslieferung ist angehalten ";


// Linked banners/campaigns
$GLOBALS['strSelectZoneType']			= "Einbindungsmöglichkeiten für Banner ";
$GLOBALS['strBannerSelection']			= "Banner (Auswahl)";
$GLOBALS['strCampaignSelection']		= "Kampagne (Auswahl)";
$GLOBALS['strInteractive']				= "Interaktive";
$GLOBALS['strRawQueryString']			= "Schlüsselwort";
$GLOBALS['strIncludedBanners']			= "Verknüpfte Banner";
$GLOBALS['strLinkedBannersOverview']	= "Übersicht verknüpfte Banner";
$GLOBALS['strLinkedBannerHistory']		= "Entwicklung Banner";
$GLOBALS['strNoZonesToLink']			= "Es sind keine Zonen vorhanden, denen der Banner zugeordnet werden kann";
$GLOBALS['strNoBannersToLink']			= "Es sind derzeit keine Banner vorhanden, die dieser Zone zugeordnet werden können";
$GLOBALS['strNoLinkedBanners']			= "Es sind keine Banner dieser Zone zugeordnet (mit ihr verknüpft)";
$GLOBALS['strMatchingBanners']			= "{count} zugehörende Banner";
$GLOBALS['strNoCampaignsToLink']		= "Es sind keine Kampagnen vorhanden, die mit dieser Zone verknüpft werden können";
$GLOBALS['strNoZonesToLinkToCampaign']  = "Es sind keine Zonen vorhanden, die mit dieser Kampagne verknüpft werden können";
$GLOBALS['strSelectBannerToLink']		= "Wählen Sie einen Banner, der dieser Zone zugeordnet werden soll:";
$GLOBALS['strSelectCampaignToLink']		= "Wählen Sie eine Kampagne, die dieser Zone zugeordnet werden soll:";

// Append
$GLOBALS['strAppendType']				= " Type (Anhang)";
$GLOBALS['strAppendHTMLCode']			= "HTML-Code";
$GLOBALS['strAppendWhat']				= "Was soll angehängt werden?";
$GLOBALS['strAppendZone']				= "Eine spezielle Zone anhängen";
$GLOBALS['strAppendErrorZone']			= "Es muß eine Zone ausgewählt werden, \\n um fortfahren zu können.. Andernfalls wird kein Banner \\n angehängt.";
$GLOBALS['strAppendBanner']				= "Anhängen eines oder mehrere Banner";
$GLOBALS['strAppendErrorBanner']		= "Es muß ein oder mehrere Banner bestimmt werden \\num fortfahren zu können. Andernfalls wird kein Banner \\n angehängt.";
$GLOBALS['strAppendKeyword']			= "Banner anhängen aufgrund Schlüsselworte";
$GLOBALS['strAppendErrorKeyword']		= "Es muß mindestens ein Schlüsselwort definiert werden\\num fortfahren zu können. Andernfalls wird kein Banner \\n angehängt.";






// Statistics
$GLOBALS['strStats'] 				= "Statistiken";
$GLOBALS['strNoStats']				= "Zur Zeit sind keine Statistiken vorhanden";
$GLOBALS['strConfirmResetStats']	= "Sollen tatsächlich alle vorhandenen Statistiken gelöscht werden?";
$GLOBALS['strGlobalHistory']		= "Generelle Entwicklung";
$GLOBALS['strDailyHistory']			= "Entwicklung Tag";
$GLOBALS['strDailyStats'] 			= "Tagesstatistik";
$GLOBALS['strWeeklyHistory']		= "Entwicklung Woche";
$GLOBALS['strMonthlyHistory']		= "Entwicklung Monat";
$GLOBALS['strCreditStats'] 			= "Guthabenstatistik";
$GLOBALS['strDetailStats'] 			= "Detaillierte Statistik";
$GLOBALS['strTotalThisPeriod']		= "Summe in dieser Periode";
$GLOBALS['strAverageThisPeriod']	= "Durchschnitt in dieser Periode";
$GLOBALS['strDistribution']			= "Verteilung";
$GLOBALS['strResetStats'] 			= "Statistiken zurücksetzen";
$GLOBALS['strSourceStats']			= "Quellstatistiken";
$GLOBALS['strSelectSource']			= "Auswahl der Quelle, die angezeigt werden soll:";
$GLOBALS['strSizeDistribution']		= "Verteilung nach Größe";
$GLOBALS['strCountryDistribution']	= "Verteilung nach Land";
$GLOBALS['strEffectivity']			= "Effektivität";
$GLOBALS['strTargetStats']			= "Soll-/Ist-Vergleich";
$GLOBALS['strCampaignTarget']		= "Soll (AdViews)";
$GLOBALS['strTargetRatio']			= "Sollerfüllung";
$GLOBALS['strTargetModifiedDay']	= "Die Sollvorgaben wurden an diesem Tag verändert. Die Berechnungen können u.U. nicht korrekt sein";
$GLOBALS['strTargetModifiedWeek']	= "Die Sollvorgaben wurden in dieser Woche verändert. Die Berechnungen können u.U. nicht korrekt sein";
$GLOBALS['strTargetModifiedMonth']	= "Die Sollvorgaben wurden in diesem Monat verändert. Die Berechnungen können u.U. nicht korrekt sein";
$GLOBALS['strNoTargetStats']		= "Es ist kein Soll-/Ist-Vergleich vorhanden ";


$GLOBALS['strCollectedAll']			= "Alle gesammelten Statistiken";
$GLOBALS['strCollectedToday']		= "Statistiken nur für heute";
$GLOBALS['strCollected7Days']		= " Statistiken nur für die letzten 7 Tage";
$GLOBALS['strCollectedMonth']		= " Statistiken nur für den laufenden Monat";
$GLOBALS['strCollectedYesterday']	= "Statistiken nur für gestern";
$GLOBALS['strCollectedRange']		= "Wählen Sie einen Zeitraum";


// Hosts
$GLOBALS['strHosts']				= "Besucherhost";
$GLOBALS['strTopHosts'] 			= "Besucherhost <i>(nach Zugriffen)</i>";
$GLOBALS['strTopCountries'] 		= "Aktivitäten <i>(nach Ländern)</I>";
$GLOBALS['strRecentHosts'] 			= "Besucherhost <i>(zeitlich absteigend)</i>";


// Expiration
$GLOBALS['strExpired']				= "Ausgelaufen";
$GLOBALS['strExpiration'] 			= "Auslaufdatum";
$GLOBALS['strNoExpiration'] 		= "Kein Auslaufdatum festgelegt";
$GLOBALS['strEstimated'] 			= "Voraussichtliches Auslaufdatum";


// Reports
$GLOBALS['strReports']				= "Berichte";
$GLOBALS['strSelectReport']			= "Wählen Sie den zu erstellenden Bericht";


// Userlog
$GLOBALS['strUserLog']				= "Benutzerprotokoll";
$GLOBALS['strUserLogDetails']		= "Details Benutzerprotokoll";
$GLOBALS['strDeleteLog']			= "Protokoll löschen";
$GLOBALS['strAction']				= "Aktion";
$GLOBALS['strNoActionsLogged']		= "Keine Aktionen protokolliert";


// Code generation
$GLOBALS['strGenerateBannercode']		= "Bannercode erstellen";
$GLOBALS['strChooseInvocationType']		= "Bitte wählen Sie für die Banner die Auslieferungsart";
$GLOBALS['strGenerate']				= "Generiere";
$GLOBALS['strParameters']			= "Parameter";
$GLOBALS['strFrameSize']			= "Rahmengröße";
$GLOBALS['strBannercode']			= "Bannercode";
$GLOBALS['strOptional']				= "optional";


// Errors
$GLOBALS['strMySQLError'] 			= "[phpAds] SQL Fehler:";
$GLOBALS['strLogErrorClients'] 		= "[phpAds] Ein Fehler ist beim Versuch aufgetreten, den Inserenten aus der Datenbank zu laden.";
$GLOBALS['strLogErrorBanners'] 		= "[phpAds] Ein Fehler ist beim Versuch aufgetreten, den Banner aus der Datenbank zu laden.";
$GLOBALS['strLogErrorViews']		= "[phpAds] Ein Fehler ist beim Versuch aufgetreten, die AdViews aus der Datenbank zu laden.";
$GLOBALS['strLogErrorClicks'] 		= "[phpAds] Ein Fehler ist beim Versuch aufgetreten, die AdClicks aus der Datenbank zu laden.";
$GLOBALS['strErrorViews'] 			= "Sie müssen die Anzahl der AdViews eingeben oder unbegrenzt wählen!";
$GLOBALS['strErrorNegViews'] 		= "Negative AdViews sind nicht möglich";
$GLOBALS['strErrorClicks'] 			= "Sie müssen die Anzahl der AdClicks eingeben oder unbegrenzt wählen!";
$GLOBALS['strErrorNegClicks'] 		= "Negative AdClicks sind nicht möglich";
$GLOBALS['strNoMatchesFound']		= "Kein Objekt gefunden";
$GLOBALS['strErrorOccurred']		= "Ein Fehler ist aufgetreten";
$GLOBALS['strErrorUploadSecurity']	= "Ein mögliches Sicherheitsproblem wurde erkannt. Ladevorgang (Upload) wurde gestoppt!";
$GLOBALS['strErrorUploadBasedir']	= "Zugriff auf die zu ladende Datei konnte nicht erfolgen. Die Ursache liegt möglicherweise im <i>safemode </i> oder der Einschränkung von <i>open_basedir </i>";
$GLOBALS['strErrorUploadUnknown']	= "Zugriff auf die zu ladende Datei konnte aus unbekanntem Grund nicht erfolgen. Bitte die PHP-Konfiguration prüfen.";
$GLOBALS['strErrorStoreLocal']		= "Ein Fehler ist beim Versuch aufgetreten, den Banner in das lokale Verzeichnis zu speichern. Möglicherweise ist in der Konfiguration der lokale Verzeichnispfad nicht korrekt eingegeben.";
$GLOBALS['strErrorStoreFTP']		= " Ein Fehler ist beim Versuch aufgetreten, den Banner zum FTP-Server zu übertragen.. Möglicherweise ist der FTP-Server nicht verfügbar oder in der Konfiguration erfolgte die Einstellung für den FTP-Server nicht korrekt ";
$GLOBALS['strErrorDBPlain']			= "Beim Zugriff auf die Datenbank ist ein Fehler aufgetreten ";
$GLOBALS['strErrorDBSerious']		= "Ein schwerwiegendes Problem mit der Datenbank wurde erkannt";
$GLOBALS['strErrorDBNoDataPlain']	= "Aufgrund eines Fehlers mit der Datenbank konnte ".$phpAds_productname." weder aus der Datenbank lesen noch in sie schreiben. ";
$GLOBALS['strErrorDBNoDataSerious']	= "Aufgrund eines schweren Problems mit der Datenbank konnte ".$phpAds_productname." keine Daten suchen";
$GLOBALS['strErrorDBCorrupt']		= "Die Datenbanktabelle ist wahrscheinlich zerstört und muß wiederhergestellt werden. Informationen über die Wiederherstellung zerstörter Tabellen finden sich im Handbuch.";
$GLOBALS['strErrorDBContact']		= "Bitte nehmen Sie Kontakt mit dem Systemverwalter Ihres Servers auf und schildern Sie ihm das Problem. Nur er kann helfen.";
$GLOBALS['strErrorDBSubmitBug']		= "Wenn das Problem wiederholt auftritt, kann es ein Fehler in ".$phpAds_productname." sein. Bitte protokollieren Sie die Fehlermeldung uns senden sie diese an die Programmierer von ".$phpAds_productname.". Bitte beschreiben Sie alle Aktivitäten, die zu diesem Fehler führten.";
$GLOBALS['strMaintenanceNotActive']	= "Das Wartungsprogramm lief während der letzen 24 Stunden nicht. \\nDamit ".$phpAds_productname." korrekt arbeiten kann, muß das Wartungsprogramm stündlich \\naufgerufen werden. \\n\\nIm Handbuch finden sich weitere Informationen \\nzur Konfiguration des Wartungsprogrammes.";



// eMail
$GLOBALS['strMailSubject'] 			= "Bericht für Inserenten";
$GLOBALS['strAdReportSent']			= "Bericht für Inserenten versandt";
$GLOBALS['strMailSubjectDeleted'] 	= "Deaktivierte Banner";
$GLOBALS['strMailHeader'] 			= "Sehr geehrte(r) {contact},\n";
$GLOBALS['strMailBannerStats'] 		= "Sie erhalten nachfolgend eine statistische Auswertung für {clientname}:";
$GLOBALS['strMailFooter'] 			= "Mit freundlichem Gruss \n   {adminfullname}";
$GLOBALS['strMailClientDeactivated'] 	= "Die folgenden Banner wurden deaktiviert, weil";
$GLOBALS['strMailNothingLeft'] 		= "Wir danken für Ihr Vertrauen, dass wir Ihre Werbung auf unseren WEB-Seiten präsentieren durften. Gern werden wir Ihnen weiterhin zur Verfügung stehen.";
$GLOBALS['strClientDeactivated']	= "Diese Kampagne ist zur Zeit nicht aktiv, weil";
$GLOBALS['strBeforeActivate']		= "das Aktivierungsdatum noch nicht erreicht wurde ";
$GLOBALS['strAfterExpire']			= "das Auslaufdatum erreicht wurde ";
$GLOBALS['strNoMoreClicks']			= "kein Guthaben für AdClicks vorhanden ist.";
$GLOBALS['strNoMoreViews']			= "kein Guthaben für AdViews vorhanden ist. ";
$GLOBALS['strWeightIsNull']			= "die Gewichtung auf 0 (Null) gesetzt wurde.";
$GLOBALS['strWarnClientTxt']		= "Das Guthaben für  AdClicks bzw. für AdViews Ihrer Kampagne ist unter {limit} und wird in Kürze auslaufen \n. ";
$GLOBALS['strViewsClicksLow']		= "Guthaben für AdViews/AdClicks sind beinah vollständig aufgebraucht";
$GLOBALS['strNoViewLoggedInInterval']   = "Für den Berichtszeitraum wurden keine AdViews protokolliert";
$GLOBALS['strNoClickLoggedInInterval'] 	= "Für den Berichtszeitraum wurden keine AdClicks protokolliert";
$GLOBALS['strMailReportPeriod']		= "Die Statistiken in diesem Bericht sind für den Zeitraum: {startdate} bis {enddate}.";
$GLOBALS['strMailReportPeriodAll']	= "Der Bericht enthält alle Statistiken bis {enddate}.";
$GLOBALS['strNoStatsForCampaign'] 	= "Für diese Kampagne liegen keine Statistiken vor ";


// Priority
$GLOBALS['strPriority']				= "Priorität";


// Settings
$GLOBALS['strSettings'] 			= "Einstellungen";
$GLOBALS['strGeneralSettings']		= "Allgemeine Einstellungen";
$GLOBALS['strMainSettings']			= "Grundeinstellungen";
$GLOBALS['strAdminSettings']		= "Einstellungen für die Administration";


// Product Updates
$GLOBALS['strProductUpdates']		= "Produkt Update";




/*********************************************************/
/* Keyboard shortcut assignments                         */
/*********************************************************/


// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome']			= 'h';
$GLOBALS['keyUp']			= 'u';
$GLOBALS['keyNextItem']		= '.';
$GLOBALS['keyPreviousItem']	= ',';
$GLOBALS['keyList']			= 'l';


// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch']		= 's'; //suche
$GLOBALS['keyCollapseAll']	= 'z'; //zusammenklappen
$GLOBALS['keyExpandAll']	= 'a'; // aufklappen
$GLOBALS['keyAddNew']		= 'n'; //Neu
$GLOBALS['keyNext']			= 'w'; //weiter
$GLOBALS['keyPrevious']		= 'z'; // zurück

?>
