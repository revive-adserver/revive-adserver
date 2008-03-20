<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

// German
// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']  		= "ltr";  // links nach rechts
$GLOBALS['phpAds_TextAlignRight'] 		= "right";
$GLOBALS['phpAds_TextAlignLeft']  		= "left";

$GLOBALS['phpAds_DecimalPoint']			= ',';
$GLOBALS['phpAds_ThousandsSeperator']		= '.';

// Date & time configuration
$GLOBALS['date_format']				= "%d.%m.%Y";
$GLOBALS['time_format']				= "%H:%M:%S";
$GLOBALS['minute_format']			= "%H:%M";
$GLOBALS['month_format']			= "%m-%Y";
$GLOBALS['day_format']				= "%d-%m";
$GLOBALS['week_format']				= "%W-%Y";
$GLOBALS['weekiso_format']			= "%V-%G";

// formats used by PEAR Spreadsheet_Excel_Writer packate
$GLOBALS['excel_integer_formatting'] = '#,##0';
$GLOBALS['excel_decimal_formatting'] = '#,##0.000';


/*-------------------------------------------------------*/
/* Translations                                          */
/*-------------------------------------------------------*/

$GLOBALS['strHome'] 				= "Startseite";
$GLOBALS['strHelp']				= "Hilfe";
$GLOBALS['strStartOver']		= "Neustart";
$GLOBALS['strNavigation'] 			= "Navigation";
$GLOBALS['strShortcuts'] 			= "Schnellnavigation";
$GLOBALS['strAdminstration'] 			= "Bannerverwaltung";
$GLOBALS['strMaintenance']			= "Wartung";
$GLOBALS['strProbability']			= "Wahrscheinlichkeit";
$GLOBALS['strInvocationcode']			= "Bannercode (in HTML-Seite)";
$GLOBALS['strTrackerVariables']			= "Tracker-Variablen";
$GLOBALS['strBasicInformation'] 		= "Basisinformationen";
$GLOBALS['strContractInformation'] 		= "Vertragsinformationen";
$GLOBALS['strLoginInformation']		 	= "Login-Informationen";
$GLOBALS['strLogoutURL']			= 'URL auf die beim Logout verwiesen wird. <br />Leerlassen verlinkt auf Standardseite';
$GLOBALS['strAppendTrackerCode']	= "Tracker Code anhängen";
$GLOBALS['strOverview']				= "Übersicht";
$GLOBALS['strSearch']				= "<u>S</u>uchen";
$GLOBALS['strHistory']				= "Entwicklung";
$GLOBALS['strPreferences'] 			= "Präferenz";
$GLOBALS['strSyncSettings']             = "Synchronizationseinstellungen";
$GLOBALS['strDetails']				= "Details";
$GLOBALS['strCompact']				= "Kompakt";
$GLOBALS['strVerbose']				= "Detailliert";
$GLOBALS['strUser']				= "Benutzer";
$GLOBALS['strEdit']				= "Bearbeiten";
$GLOBALS['strCreate']				= "Erstellen";
$GLOBALS['strDuplicate']			= "Kopieren";
$GLOBALS['strMoveTo']				= "Verschieben nach";
$GLOBALS['strDelete'] 				= "Löschen";
$GLOBALS['strActivate']				= "Aktivieren";
$GLOBALS['strDeActivate'] 			= "Deaktivieren";
$GLOBALS['strConvert']				= "Konvertieren";
$GLOBALS['strRefresh']				= "Aktualisieren";
$GLOBALS['strSaveChanges']			= "Änderungen speichern";
$GLOBALS['strUp'] 				= "Oben";
$GLOBALS['strDown'] 				= "Unten";
$GLOBALS['strSave'] 				= "Speichern";
$GLOBALS['strCancel']				= "Abbrechen";
$GLOBALS['strPrevious'] 			= "Zurück";
$GLOBALS['strPrevious_Key'] 			= "<u>Z</u>urück";
$GLOBALS['strNext'] 				= "Weiter";
$GLOBALS['strNext_Key'] 			= "<u>W</u>eiter";
$GLOBALS['strYes']				= "Ja";
$GLOBALS['strNo']				= "Nein";
$GLOBALS['strNone'] 				= "Keiner";
$GLOBALS['strCustom']				= "Benutzerdefiniert";
$GLOBALS['strDefault'] 				= "Standard";
$GLOBALS['strOther']				= "Andere(r)";
$GLOBALS['strUnknown']				= "Unbekannt";
$GLOBALS['strUnlimited'] 			= "Unbegrenzt";
$GLOBALS['strUntitled']				= "Ohne Titel";
$GLOBALS['strAll'] 				= "alle";
$GLOBALS['strAvg'] 				= "Ø";
$GLOBALS['strAverage']				= "Durchschnitt";
$GLOBALS['strOverall'] 				= "Gesamt";
$GLOBALS['strTotal'] 				= "Summe";
$GLOBALS['strUnfilteredTotal']		= "Alle (ungefiltert)";
$GLOBALS['strFilteredTotal']		= "Alle (gefiltert)";
$GLOBALS['strActive'] 				= "aktive";
$GLOBALS['strFrom']				= "Von";
$GLOBALS['strTo']				= "bis";
$GLOBALS['strLinkedTo'] 			= "verknüpft mit";
$GLOBALS['strDaysLeft'] 			= "Verbliebene Tage";
$GLOBALS['strCheckAllNone']			= "Prüfe alle / keine";
$GLOBALS['strKiloByte']				= "KB";
$GLOBALS['strExpandAll']			= "Alle <u>a</u>usklappen";
$GLOBALS['strCollapseAll']			= "Alle <u>z</u>usammenklappen";
$GLOBALS['strShowAll']				= "Alle anzeigen";
$GLOBALS['strNoAdminInteface']			= "Service nicht verfügbar ...";
$GLOBALS['strFilterBySource']			= "filtern nach Quelle";
$GLOBALS['strFieldContainsErrors']		= "Folgende Felder sind fehlerhaft:";
$GLOBALS['strFieldFixBeforeContinue1']		= "Bevor Sie fortgefahren können, müssen Sie";
$GLOBALS['strFieldFixBeforeContinue2']		= "diese Fehler beheben.";
$GLOBALS['strDelimiter']			= "Trennzeichen";
$GLOBALS['strMiscellaneous']			= "Sonstiges";

$GLOBALS['strCollectedAll']			= "Alle gesammelten Statistiken";
$GLOBALS['strCollectedToday']			= "Statistiken nur für heute";
$GLOBALS['strCollected7Days']			= " Statistiken nur für die letzten 7 Tage";
$GLOBALS['strCollectedMonth']			= " Statistiken nur für den laufenden Monat";
$GLOBALS['strCollectedYesterday']		= "Gestern";
$GLOBALS['strCollectedLast7Days']		= "Letzten 7 Tage";
$GLOBALS['strCollectedThisWeek']		= "Diese Woche (Mon-Son)";
$GLOBALS['strCollectedLastWeek']		= "Letzte Woche (Mon-Son)";
$GLOBALS['strCollectedThisMonth']		= "Diesen Monat";
$GLOBALS['strCollectedLastMonth']		= "Letzten Monat";
$GLOBALS['strCollectedAllStats']		= "Alle Statistiken";
$GLOBALS['strCollectedSpecificDates']   = "Bestimmtes Datum";
//neu in MMM 0.3
$GLOBALS['strDifference']			= 'Differenz (%)';
$GLOBALS['strPercentageOfTotal']        = '% Gesamtsumme';
$GLOBALS['strValue']                    = 'Wert';
$GLOBALS['strAdmin']                    = 'Admin';

// Dashboard
$GLOBALS['strDashboardCommunity']       = 'Community';
$GLOBALS['strDashboardDashboard']       = 'Dashboard';
$GLOBALS['strDashboardForum']           = 'OpenX Forum';
$GLOBALS['strDashboardDocs']            = 'OpenX Dokumentation';

// Priority
$GLOBALS['strPriority']				= "Dringlichkeit";
$GLOBALS['strPriorityLevel']		= "Dringlichkeitsstufe";
$GLOBALS['strPriorityTargeting']	= "Auslieferung";
$GLOBALS['strPriorityOptimisation']	= "Verschiedenes";
$GLOBALS['strExclusiveAds']         = "Exklusive Kampagnen";
$GLOBALS['strHighAds']              = "Vorrangige Kampagnen";
$GLOBALS['strLowAds']               = "Nachrangige Kampagnen";
$GLOBALS['strLimitations']          = "Einschränkungen";
$GLOBALS['strNoLimitations']        = "Keine Einschränkungen";
$GLOBALS['strCapping']              = 'Kappung';
$GLOBALS['strCapped']               = 'gekappt';
$GLOBALS['strNoCapping']            = 'Nicht gekappt';

// Properties
$GLOBALS['strName']				= "Name";
$GLOBALS['strSize']				= "Größe";
$GLOBALS['strWidth'] 				= "Breite";
$GLOBALS['strHeight'] 				= "Höhe";
$GLOBALS['strURL2']				= "URL";
$GLOBALS['strTarget']				= "Zielfenster";
$GLOBALS['strLanguage'] 			= "Sprache";
$GLOBALS['strDescription'] 			= "Beschreibung";
$GLOBALS['strID']				= "ID";

//neu in MMM 0.3
$GLOBALS['strVariables'] 			= "Variablen";
$GLOBALS['strComments']             = "Kommentare";

// Login & Permissions
$GLOBALS['strAuthentification']		 	= "Authentifikation";
$GLOBALS['strWelcomeTo']			= "Willkommen bei";
$GLOBALS['strEnterUsername']			= "Geben Sie Benutzername und Passwort ein";
$GLOBALS['strEnterBoth']			= "Bitte beides eingeben; Benutzername und Passwort";
$GLOBALS['strEnableCookies']			= "Es müssen Cookies aktiviert werden, damit ".$phpAds_productname." genutzt werden kann.";
$GLOBALS['strLogin'] 				= "Login";
$GLOBALS['strLogout'] 				= "Logout";
$GLOBALS['strUsername'] 			= "Benutzername";
$GLOBALS['strPassword']				= "Passwort";
$GLOBALS['strAccessDenied']			= "Zugang verweigert";
$GLOBALS['strUsernameOrPasswordWrong']  = "Der Benutzername und/oder das Passwort sind nicht korrekt. Bitte erneut versuchen.";
$GLOBALS['strPasswordWrong']			= "Das Passwort ist nicht korrekt";
$GLOBALS['strParametersWrong']		= "Die von Ihnen angegebenen Parameter sind falsch.";
$GLOBALS['strNotAdmin']				= "Sie haben nicht ausreichend Privilegien";
$GLOBALS['strDuplicateClientName']		= "Der gewählte Benutzername existiert bereits. Bitte einen anderen wählen.";
$GLOBALS['strDuplicateAgencyName']	= "Der von Ihnen gewünschte Nutzername ist bereits vergeben. Bitte nehmen Sie einen anderen.";
$GLOBALS['strInvalidPassword']			= "Das neue Passwort ist ungültig. Bitte wählen Sie ein anderes.";
$GLOBALS['strNotSamePasswords']			= "Die beiden eingegebenen Passwörter stimmen nicht überein ";
$GLOBALS['strRepeatPassword']			= "Wiederhole Passwort";
$GLOBALS['strOldPassword']			= "Altes Passwort";
$GLOBALS['strNewPassword']			= "Neues Passwort";
$GLOBALS['strNoBannerId']               = "Keine Banner ID";



// General advertising
$GLOBALS['strRequests']             = 'Zugriffe';
$GLOBALS['strImpressions'] 			= "Impressions";
$GLOBALS['strClicks']				= "Klicks";
$GLOBALS['strConversions']			= "Konversionen";
$GLOBALS['strCTRShort'] 			= "CTR";
$GLOBALS['strCTRShortHigh'] 		= "CTR for High";
$GLOBALS['strCTRShortLow'] 			= "CTR for Low";
$GLOBALS['strCNVRShort'] 			= "SR";
$GLOBALS['strCTR'] 					= "Klickrate";
$GLOBALS['strCNVR'] 				= "Sales Ratio";
$GLOBALS['strCPC']	 				= "Kosten pro Klick";
$GLOBALS['strCPCo']	 				= "Kosten pro Konversion";
$GLOBALS['strCPCoShort']	 		= "CPCo";
$GLOBALS['strCPCShort']	 			= "CPC";
$GLOBALS['strTotalCost']	 		= "Summe der Kosten";
$GLOBALS['strTotalViews'] 			= "Summe der Impressions";
$GLOBALS['strTotalClicks'] 			= "Summe der Klicks";
$GLOBALS['strTotalConversions'] 	= "Summe der Konversionen";
$GLOBALS['strViewCredits'] 			= "Impression-Guthaben";
$GLOBALS['strClickCredits'] 		= "Klickguthaben";
$GLOBALS['strConversionCredits'] 	= "Konversionsguthaben";
$GLOBALS['strImportStats']			= "Statistiken importieren";
$GLOBALS['strDateTime']			    = "Datum Zeit";
$GLOBALS['strTrackerID']		    = "Tracker-ID";
$GLOBALS['strTrackerName']		    = "Tracker-Name";
$GLOBALS['strCampaignID']		    = "Kampagnen-ID";
$GLOBALS['strCampaignName']		    = "Kampagnenname";
$GLOBALS['strCountry']		        = "Land";
$GLOBALS['strStatsAction']	        = "Aktion";
$GLOBALS['strWindowDelay']	        = "Verzögerung";
$GLOBALS['strStatsVariables']       = "Variablen";

// Finance
$GLOBALS['strFinanceCPM']           = 'TKP';
$GLOBALS['strFinanceCPC']           = 'CPC';
$GLOBALS['strFinanceCPA']           = 'CPA';
$GLOBALS['strFinanceMT']            = 'Monatlicher Fixbetrag';

// Time and date related
$GLOBALS['strDate'] 				= "Datum";
$GLOBALS['strToday'] 				= "Heute";
$GLOBALS['strDay']				= "Tag";
$GLOBALS['strDays']				= "Tage";
$GLOBALS['strLast7Days']			= "letzten 7 Tage";
$GLOBALS['strWeek'] 				= "Woche";
$GLOBALS['strWeeks']				= "Wochen";
$GLOBALS['strSingleMonth']              = "Month";
$GLOBALS['strMonths']				= "Monate";
$GLOBALS['strDayOfWeek']                = "Wochentag";
$GLOBALS['strThisMonth'] 			= "In diesem Monat";
$GLOBALS['strMonth'] 				= array("Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
$GLOBALS['strDayFullNames']             = array('Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag');
$GLOBALS['strDayShortCuts'] 			= array("So","Mo","Di","Mi","Do","Fr","Sa");
$GLOBALS['strHour']				= "Stunde";
$GLOBALS['strHourFilter']			= "Stundenfilter";
$GLOBALS['strSeconds']				= "Sekunden";
$GLOBALS['strMinutes']				= "Minuten";
$GLOBALS['strHours']				= "Stunden";
$GLOBALS['strTimes']				= "mal";

// Advertiser
$GLOBALS['strClient']				= "Werbetreibender";
$GLOBALS['strClients'] 				= "Werbetreibende";
$GLOBALS['strClientsAndCampaigns']		= "Werbetreibende & Kampagnen";
$GLOBALS['strAddClient'] 			= "Neuen Werbetreibenden hinzufügen";
$GLOBALS['strAddClient_Key'] 			= "<u>N</u>euen Werbetreibenden hinzufügen";
$GLOBALS['strTotalClients'] 			= "Summe Werbetreibende";
$GLOBALS['strClientProperties']			= "Merkmale Werbetreibender";
$GLOBALS['strClientHistory']			= "Entwicklung Werbetreibende";
$GLOBALS['strNoClients']			= "Derzeit sind keine Werbetreibende definiert";
$GLOBALS['strConfirmDeleteClient'] 		= "Soll dieser Werbetreibende wirklich gelöscht werden?";
$GLOBALS['strConfirmResetClientStats']		= "Sollen wirklich alle Statistiken dieses Werbetreibenden gelöscht werden?";
$GLOBALS['strSite'] = 'Web-Site';
$GLOBALS['strHideInactive']                 = "Verberge inaktive";
$GLOBALS['strHideInactiveAdvertisers']		= "Verberge inaktive Werbetreibende";
$GLOBALS['strInactiveAdvertisersHidden']	= "Inaktive Werbetreibende sind verborgen";


// Advertisers properties
$GLOBALS['strContact'] 				= "Name der Kontaktperson";
$GLOBALS['strEMail'] 				= "E-Mail";
$GLOBALS['strChars']                            = "Zeichen";
$GLOBALS['strSendAdvertisingReport']		= "Versenden eines Berichtes via E-Mail";
$GLOBALS['strNoDaysBetweenReports']		= "Anzahl Tage zwischen zwei Berichten";
$GLOBALS['strSendDeactivationWarning']		= "Versenden einer Warnung, wenn Kampagne deaktiviert ist";
$GLOBALS['strAllowClientModifyInfo'] 		= "Werbetreibender darf eigene Einstellungen verändern";
$GLOBALS['strAllowClientModifyBanner'] 		= "Werbetreibender darf eigene Banner verändern";
$GLOBALS['strAllowClientAddBanner'] 		= "Werbetreibender darf eigene Banner hinzufügen";
$GLOBALS['strAllowClientDisableBanner'] 	= "Werbetreibender darf eigene Banner deaktivieren";
$GLOBALS['strAllowClientActivateBanner'] 	= "Werbetreibender darf eigene Banner aktiveren";
$GLOBALS['strAllowClientViewTargetingStats'] 	= "Werbetreibender bekommt Targeting-Statistiken angezeigt";
$GLOBALS['strCsvImportConversions']             = "Werbetreibender darf offline Konversionen uploaden";

// Campaign
$GLOBALS['strCampaign']				= "Kampagne";
$GLOBALS['strCampaigns']			= "Kampagnen";
$GLOBALS['strTotalCampaigns'] 			= "Summe Kampagnen";
$GLOBALS['strActiveCampaigns'] 			= "Aktive Kampagnen";
$GLOBALS['strAddCampaign'] 			= "Neue Kampagnen hinzufügen";
$GLOBALS['strAddCampaign_Key'] 			= "<u>N</u>eue Kampagnen hinzufügen";
$GLOBALS['strCreateNewCampaign']		= "Kampagne erstellen";
$GLOBALS['strModifyCampaign']			= "Kampagne ändern";
$GLOBALS['strMoveToNewCampaign']		= "Verschieben zu einer neuen Kampagne";
$GLOBALS['strBannersWithoutCampaign']		= "Banner ohne Kampagne";
$GLOBALS['strDeleteAllCampaigns']		= "Alle Kampagnen löschen";
$GLOBALS['strLinkedCampaigns']			= "Verknüpfte Kampagnen";
$GLOBALS['strCampaignStats']			= "Kampagnenstatistik";
$GLOBALS['strCampaignProperties']		= "Merkmale Kampagnen";
$GLOBALS['strCampaignOverview']			= "Übersicht Kampagnen";
$GLOBALS['strCampaignHistory']			= "Entwicklung Kampagnen";
$GLOBALS['strNoCampaigns']			= "Derzeit keine Kampagnen definiert";
$GLOBALS['strConfirmDeleteAllCampaigns']	= "Sollen wirklich alle Kampagnen dieses Werbetreibenden gelöscht werden?";
$GLOBALS['strConfirmDeleteCampaign']		= "Soll diese Kampagne wirklich gelöscht werden?";
$GLOBALS['strConfirmResetCampaignStats']	= "Sollen wirklich alle Statistiken dieser Kampagne gelöscht werden?";
$GLOBALS['strShowParentAdvertisers']        = "Zugehörige Werbetreibende anzeigen";
$GLOBALS['strHideParentAdvertisers']        = "Verberge zugehörige Werbetreibende";
$GLOBALS['strHideInactiveCampaigns']		= "Verberge inaktive Kampagnen";
$GLOBALS['strInactiveCampaignsHidden']		= "inaktive Kampagne sind verborgen";
$GLOBALS['strContractDetails']		= "Vertragsdetails";
$GLOBALS['strInventoryDetails']		= "Inventardetails";
$GLOBALS['strPriorityInformation']	= "Dringlichkeitsinformationen";
$GLOBALS['strPriorityExclusive']    = "- überschreibt andere verknpüfte Kampagnen";
$GLOBALS['strPriorityHigh']			= "- bezahlte Kampagnen";
$GLOBALS['strPriorityLow']			= "- Eigenwerbung und unbezahlte Kampagnen";
$GLOBALS['strPriorityHighShort']    = "Hoch";
$GLOBALS['strPriorityLowShort']		= "Niedrig";
$GLOBALS['strHiddenCampaign']			= "Verborgene Kampagne";
$GLOBALS['strHiddenAd']                     = "Verborgene Werbung";
$GLOBALS['strHiddenAdvertiser']             = "Verborgene Werbetreibende";
$GLOBALS['strHiddenTracker']                = "Verborgene Tracker";
$GLOBALS['strHiddenWebsite']                = "Verborgene Werbeträger";
$GLOBALS['strHiddenZone']                   = "Verborgene Zone";
$GLOBALS['strUnderdeliveringCampaigns']		= "Nicht erfüllte Kampagnen";
$GLOBALS['strCampaignDelivery']			= "Kampagnen Auslieferung";
$GLOBALS['strBookedMetric']             = "gebuchter Kampagnentyp";
$GLOBALS['strValueBooked']              = "Auftragsvolumen";
$GLOBALS['strRemaining']                = "Verbleibende";
$GLOBALS['strCompanionPositioning']     = "Tandem-Ads";
$GLOBALS['strSelectUnselectAll']            = "Alle aus- und abwählen";
$GLOBALS['strConfirmOverwrite']             = "Die Banner-Zone Verknüpfungen werden überschrieben, wenn diese Änderungen gespeichert werden. Möchten Sie fortfahren?";


// Campaign properties
$GLOBALS['strDontExpire']			= "Kampagne nicht zu einem bestimmten Datum beenden ";
$GLOBALS['strActivateNow'] 			= "Kampagne sofort beginnen";
$GLOBALS['strLow']				= "Niedrig";
$GLOBALS['strHigh']				= "Dringlichkeit";
$GLOBALS['strExclusive']				= "Exklusiv";
$GLOBALS['strExpirationDate']			= "Auslaufdatum";
$GLOBALS['strExpirationDateComment']	= "Kampagne wird am Ende dieses Tages auslaufen.";
$GLOBALS['strActivationDate']			= "Aktivierungsdatum";
$GLOBALS['strActivationDateComment']	= "Kampagne wird zu Beginn dieses Tages starten.";
$GLOBALS['strRevenueInfo']              = 'Umsatzinformationen';
$GLOBALS['strImpressionsRemaining'] 	= "Verbleibende Werbemittelauslieferungen";
$GLOBALS['strClicksRemaining'] 			= "Verbleibende Klicks";
$GLOBALS['strConversionsRemaining'] 	= "Verbleibende Konversionen";
$GLOBALS['strImpressionsBooked'] 	    = "Gebuchte Werbemittelauslieferungen";
$GLOBALS['strClicksBooked'] 			= "Gebuchte Klicks";
$GLOBALS['strConversionsBooked'] 	    = "Gebuchte Konversionen";
$GLOBALS['strCampaignWeight']			= "Gewichtung der Kampagne";
$GLOBALS['strTargetLimitAdImpressions'] = "Begrenzung der AdViews auf";
$GLOBALS['strOptimise']					= "Die Auslieferung dieser Kampagne optimieren.";
$GLOBALS['strAnonymous']				= "Werbeträger und Werbetreibenden dieser Kampagne nicht anzeigen.";
$GLOBALS['strHighPriority']			= "Anzeige von Bannern aus dieser Kampagne mit hoher Priorität.<br />Bei Auswahl dieser Option wird ".$phpAds_productname." zunächst vorrangig diese Banner und über den Tag gleichmäßig verteilt ausliefern.";
$GLOBALS['strLowPriority']			= " Anzeige von Bannern aus dieser Kampagne mit geringer Priorität.<br />Diese Kampagne nutzt die überzähligen, nicht von Kampagnen mit höherer Priorität benötigten AdViews.";
$GLOBALS['strTargetPerDay']			= "pro Tag.";
$GLOBALS['strPriorityAutoTargeting']		= "Gleichmäßiges Verteilen der verbleibenden AdViews über die verbleibenden Tage. Täglich erfolgt eine Neuberechnung.";
$GLOBALS['strCampaignWarningNoWeight']		= "Die Priorität der Kampagne ist niedrig gesetzt. \nAber die Gewichtung ist 0 (Null)oder sie ist \nnicht definiert. Dadurch wird diese Kampagne inaktiv \nbleiben. Banner werden nicht ausgeliefert bis\neine gültige Gewichtung eingegeben wurde. \n\nWollen Sie fortfahren?";
$GLOBALS['strCampaignWarningNoTarget']		= "Die Priorität dieser Kampagne ist hoch gesetzt. \nAber die Anzahl der AdViews sind nicht angegeben. \nDadurch wird die Kampagne inaktiv bleiben. \nBanner werden nicht ausgeliefert, bis eine\ngültige Eingabe über die Höhe \der AdViews eingegeben wurde. \n\n Wollen Sie fortfahren?";


// Tracker
$GLOBALS['strTracker']					= "Tracker";
$GLOBALS['strTrackerOverview']			= "Überblick Tracker";
$GLOBALS['strAddTracker'] 				= "Neuen Tracker hinzufügen";
$GLOBALS['strAddTracker_Key'] 			= "<u>N</u>euen Tracker hinzufügen";
$GLOBALS['strNoTrackers']				= "Zur Zeit sind keine Tracker angelegt";
$GLOBALS['strConfirmDeleteAllTrackers']	= "Wollen Sie wirklich alle zu diesem Werbetreibenden gehörenden Tracker löschen?";
$GLOBALS['strConfirmDeleteTracker']		= "Wollen Sie diesen Tracker wirklich löschen?";
$GLOBALS['strDeleteAllTrackers']		= "Alle Tracker löschen";
$GLOBALS['strTrackerProperties']		= "Tracker Merkmale";
$GLOBALS['strTrackerOverview']			= "Überblick Tracker";
$GLOBALS['strModifyTracker']			= "Tracker anpassen";
$GLOBALS['strLog']						= "Log?";
$GLOBALS['strDefaultStatus']			= "Standardstatus";
$GLOBALS['strStatus']					= "Status";
$GLOBALS['strLinkedTrackers']			= "verlinkte Tracker";
$GLOBALS['strDefaultConversionRules']	= "Standardkonversionsregel";
$GLOBALS['strConversionWindow']			= "Konversionsintervall";
$GLOBALS['strClickWindow']				= "Klickintervall";
$GLOBALS['strViewWindow']				= "View window";
$GLOBALS['strUniqueWindow']				= "Unique window";
$GLOBALS['strClick']					= "Klick";
$GLOBALS['strView']						= "View";
$GLOBALS['strArrival']                        = "Eingangsbenachrichtigung";
$GLOBALS['strManual']                        = "Handbuch";
$GLOBALS['strConversionClickWindow']	= "Zähle Konversionen, die innerhalb der angegebenen Sekundenzahl nach einem Klick stattfinden.";
$GLOBALS['strConversionViewWindow']		= "Zähle Konversionen, die innerhalb der angegebenen Sekundenzahl nach einem View stattfinden.";
$GLOBALS['strTotalTrackerImpressions']	= "Summe der ausgelieferten Impressions";
$GLOBALS['strTotalTrackerConnections']	= "Summe der Connections";
$GLOBALS['strTotalTrackerConversions']	= "Summe der Konversionen";
$GLOBALS['strTrackerImpressions']	    = "Impressions";
$GLOBALS['strTrackerImprConnections']   = "Impression Connections";
$GLOBALS['strTrackerClickConnections']  = "Klick Connections";
$GLOBALS['strTrackerImprConversions']   = "Impression Konversionen";
$GLOBALS['strTrackerClickConversions']  = "Klick Konversionen";
$GLOBALS['strLinkCampaignsByDefault']   = "Verlinke neu erstellte Kampagnen defaultmäßig";

// Banners (General)
$GLOBALS['strBanner'] 				= "Banner";
$GLOBALS['strBanners'] 				= "Banner";
$GLOBALS['strBannerFilter']				  = "Werbemittelfilter";
$GLOBALS['strAddBanner'] 			= "Neues Banner hinzufügen";
$GLOBALS['strAddBanner_Key'] 			= " <u>N</u>eues Banner hinzufügen ";
$GLOBALS['strModifyBanner'] 			= "Banner verändern";
$GLOBALS['strActiveBanners'] 			= "Aktivierte Banner";
$GLOBALS['strTotalBanners'] 			= "Summe Banner";
$GLOBALS['strShowBanner']			= "Banner anzeigen";
$GLOBALS['strShowAllBanners']	 		= "Alle Banner anzeigen";
$GLOBALS['strShowBannersNoAdViews']		= " Alle Banner ohne AdViews anzeigen ";
$GLOBALS['strShowBannersNoAdClicks']		= " Alle Banner ohne AdClicks anzeigen";
$GLOBALS['strShowBannersNoAdConversions'] = "Zeige Werbemittel, die nicht zu einer Konversion geführt haben";
$GLOBALS['strDeleteAllBanners']	 		= "Alle Banner löschen";
$GLOBALS['strActivateAllBanners']		= "Alle Banner aktivieren";
$GLOBALS['strDeactivateAllBanners']		= "Alle Banner deaktivieren";
$GLOBALS['strBannerOverview']			= "Übersicht Banner";
$GLOBALS['strBannerProperties']			= "Bannermerkmale";
$GLOBALS['strBannerHistory']			= "Entwicklung Banner";
$GLOBALS['strBannerNoStats'] 			= "Keine Statistiken für den Banner vorhanden ";
$GLOBALS['strNoBanners']			= "Zur Zeit keine Banner definiert";
$GLOBALS['strConfirmDeleteBanner']		= "Soll dieser Banner wirklich gelöscht werden?";
$GLOBALS['strConfirmDeleteAllBanners']		= "Sollen tatsächlich alle Banner dieser Kampagne gelöscht werden?";
$GLOBALS['strConfirmResetBannerStats']		= "Sollen tatsächlich alle Statistiken für diesen Banner gelöscht werden?";
$GLOBALS['strShowParentCampaigns']		= "Zugehörige Kampagnen anzeigen";
$GLOBALS['strHideParentCampaigns']		= "Zugehörige Kampagnen verbergen";
$GLOBALS['strHideInactiveBanners']		= "Inaktive Banner verbergen";
$GLOBALS['strInactiveBannersHidden']		= "inaktive Banner sind verborgen";
$GLOBALS['strAppendOthers']			= "Andere anhängen";
$GLOBALS['strAppendTextAdNotPossible']		= "Es ist nicht möglich, ein Banner an eine Textanzeige anzuhängen.";
$GLOBALS['strHiddenBanner']               = "verborgene Werbemittel";
$GLOBALS['strWarningTag1']                  = 'Warnung, der HTML-Tag ';
$GLOBALS['strWarningTag2']                  = ' ist wahrscheinlich nicht geschlossen bzw. geöffnet.';
$GLOBALS['strWarningMissing']              = 'Warnung, wahrscheinlich fehlt ';
$GLOBALS['strWarningMissingClosing']       = ' der schliessender HTML-Tag ">"';
$GLOBALS['strWarningMissingOpening']       = ' der öffnende HTML-Tag "<"';
$GLOBALS['strSubmitAnyway']       		   = 'Dennoch absenden?';


// Banner (Properties)
$GLOBALS['strChooseBanner'] 			= "Bannertype auswählen";
$GLOBALS['strMySQLBanner'] 			= "Banner in Datenbank speichern (SQL)";
$GLOBALS['strWebBanner'] 			= " Banner auf Webserver (lokal)";
$GLOBALS['strURLBanner'] 			= " Banner über URL verwalten ";
$GLOBALS['strHTMLBanner'] 			= "HTML-Banner";
$GLOBALS['strTextBanner'] 			= " Textanzeige";
$GLOBALS['strAutoChangeHTML']			= " HTML-Code zum Aufzeichnen der AdClicks modifizieren ";
$GLOBALS['strUploadOrKeep']			= "Soll die vorhandene <br />Bilddatei behalten werden, oder soll <br />ein neues geladen werden?";
$GLOBALS['strUploadOrKeepAlt']		= "Wollen Sie die bestehende<br />Grafik (JPG, GIF) behalten oder<br />eine neue hochladen?";
$GLOBALS['strNewBannerFile'] 			= "Wählen Sie die Bilddatei <br />für dieses Banner<br /><br />";
$GLOBALS['strNewBannerFileAlt'] 	= "Wählen Sie eine Grafik (JPG, GIF) aus<br />für den Fall, daß ein Besucher<br />das RichMedia-Werbemittel nicht darstellen kann<br /><br />";
$GLOBALS['strNewBannerURL'] 			= " Bild-URL (incl. http://)";
$GLOBALS['strURL'] 				= "Ziel-URL (incl. http://)";
$GLOBALS['strHTML'] 				= "HTML";
$GLOBALS['strKeyword'] 				= "Schlüsselwörter";
$GLOBALS['strTextBelow'] 			= "Text unterhalb Banner";
$GLOBALS['strWeight'] 				= "Gewichtung";
$GLOBALS['strAlt'] 				= "Alt-Text";
$GLOBALS['strStatusText']			= "Status-Text";
$GLOBALS['strBannerWeight']			= "Bannergewichtung";
$GLOBALS['strBannerType']           = "Werbemitteltyp";
$GLOBALS['strAdserverTypeGeneric']  = "Standard HTML-Banner";
$GLOBALS['strAdserverTypeMax']      = "Rich Media - OpenX";
$GLOBALS['strAdserverTypeAtlas']    = "Rich Media - Atlas";
$GLOBALS['strAdserverTypeBluestreak']   = "Rich Media - Bluestreak";
$GLOBALS['strAdserverTypeDoubleclick']  = "Rich Media - DoubleClick";
$GLOBALS['strAdserverTypeEyeblaster']   = "Rich Media - Eyeblaster";
$GLOBALS['strAdserverTypeFalk']         = "Rich Media - Falk";
$GLOBALS['strAdserverTypeMediaplex']    = "Rich Media - Mediaplex";
$GLOBALS['strAdserverTypeTangozebra']   = "Rich Media - Tango Zebra";
$GLOBALS['strGenericOutputAdServer'] = "Generisch";
$GLOBALS['strSwfTransparency']		= "Transparener Hintergrund (nur bei Flash)";

// Banner (swf)
$GLOBALS['strCheckSWF']				= "Prüfung nach direktem Link (hard-coded) innerhalb der Flash-Datei";
$GLOBALS['strConvertSWFLinks']			= "direkten Flash-Link konvertieren";
$GLOBALS['strHardcodedLinks']			= "direkter Link (hard-coded)";
$GLOBALS['strConvertSWF']			= "<br />
In der gerade geladenen Flash-Datei befinden sich direkte URL-Links (hard-coded). Direkte URL-Links können von ".MAX_PRODUCT_NAME." nicht aufgezeichnet werden. Sie müssen hierfür entsprechend konvertiert werden. Nachfolgend finden Sie eine Auflistung aller URL-Links innerhalb der Flash-Datei. Für die Konvertierung dieser URL-Links muß <i><b>Konvertieren</i></b> gedrückt werden. Mit <i><b>Abbrechen</i></b> wird der Vorgang ohne Veränderung beendet.<br /><br />
Bitte beachten Sie, daß die Flash-Datei nach <i><b>Konvertieren</i></b> im Programmcode verändert ist. Erstellen Sie vorab eine Sicherungskopie. Unabhängig der verwendeten Flash-Version benötigt die neu erstellte Flash-Datei für eine korrekte Darstellung Flash 4 oder höher.<br /><br />";
$GLOBALS['strCompressSWF']			= "Komprimieren der SWF-Datei für eine schnellere übertragung zum Browser (Flash 6 wird benötigt)";
$GLOBALS['strOverwriteSource']			= "Überschreiben der Parameter im Quelltext";
$GLOBALS['strLinkToShort']            = "Warnung: Direkte URL-Links gefunden - Die Links sind zu kurz, um automatisch konvertiert zu werden.";

// Banner (network)
$GLOBALS['strBannerNetwork']			= "HTML-Template";
$GLOBALS['strChooseNetwork']			= "Auswahl des HTML-Template";
$GLOBALS['strMoreInformation']			= "Weitere Informationen...";
$GLOBALS['strRichMedia']			= "Richmedia";
$GLOBALS['strTrackAdClicks']			= "Aufzeichen der AdClicks";


// Display limitations
$GLOBALS['strModifyBannerAcl'] 			= "Auslieferungsoptionen";
$GLOBALS['strACL'] 				= "Bannerauslieferung";
$GLOBALS['strACLAdd'] 				= "Neue Beschränkung hinzufügen";
$GLOBALS['strACLAdd_Key'] 			= " <u>N</u>eue Beschränkung hinzufügen ";
$GLOBALS['strNoLimitations']			= "Keine Beschränkungen";
$GLOBALS['strApplyLimitationsTo']		= "Beschränkungen anwenden bei";
$GLOBALS['strRemoveAllLimitations']		= "Alle Beschränkungen löschen";
$GLOBALS['strEqualTo']				= "ist gleich";
$GLOBALS['strDifferentFrom']			= "ist ungleich";
$GLOBALS['strLaterThan']			= "ist später als";
$GLOBALS['strLaterThanOrEqual']			= "ist später als oder gleichzeitig mit";
$GLOBALS['strEarlierThan']			= "ist früher als";
$GLOBALS['strEarlierThanOrEqual']		= "ist früher als oder gleichzeitig mit";
$GLOBALS['strContains']				= "beinhaltet";
$GLOBALS['strNotContains']			= "beinhaltet nicht";
$GLOBALS['strAND']				= "'UND"; 	// logical operator
$GLOBALS['strOR']				= "ODER"; 	// logical operator
$GLOBALS['strOnlyDisplayWhen']			= "Diesen Banner nur anzeigen, wenn:";
$GLOBALS['strWeekDay'] 				= "Wochentag";
$GLOBALS['strWeekDays'] 				= "Wochentage";
$GLOBALS['strTime'] 				= "Zeit";
$GLOBALS['strUserAgent'] 			= "Browsertype";
$GLOBALS['strDomain'] 				= "Domain";
$GLOBALS['strClientIP'] 			= "IP-Adresse";
$GLOBALS['strSource'] 				= "Quelle";
$GLOBALS['strSourceFilter']				= "Filtern nach Quelle";
$GLOBALS['strBrowser'] 				= "Browser";
$GLOBALS['strOS'] 				= "BS";
$GLOBALS['strCountryCode'] 				= "Ländercode (ISO 3166)";
$GLOBALS['strCountryName'] 				= "Ländername";
$GLOBALS['strContinent'] 			= "Kontinent";
$GLOBALS['strRegion']					= "Regionalcode (ISO-3166-2 or FIPS 10-4)";
$GLOBALS['strCity']					    = "Stadtname";
$GLOBALS['strPostalCode']			    = "US/Canada ZIP/Postcode";
$GLOBALS['strLatitude']			        = "Breitengrad";
$GLOBALS['strLongitude']			    = "Längengrad";
$GLOBALS['strDMA']	         		    = "DMA Code (nur USA)";
$GLOBALS['strArea']	         		    = "Telephonvorwahl (nur USA)";
$GLOBALS['strOrg']	         		    = "Firmenname";
$GLOBALS['strIsp']	         		    = "ISP-Name";
$GLOBALS['strNetspeed']	      		    = "Verbindungsgeschwindigkeit";
$GLOBALS['strReferer'] 				= "Referenzseite";
$GLOBALS['strDeliveryLimitations']		= "Auslieferungsbeschränkungen";
$GLOBALS['strDeliveryCapping']			= "Bannereinblendung kappen";

$GLOBALS['strDeliveryCappingReset']       = "Reset view counters after:";
$GLOBALS['strDeliveryCappingTotal']       = "insgesamt";
$GLOBALS['strDeliveryCappingSession']     = "pro Session";

$GLOBALS['strCappingBanner'] = array();
$GLOBALS['strCappingBanner']['title'] = $GLOBALS['strDeliveryCapping'];
$GLOBALS['strCappingBanner']['limit'] = 'Banner Ausliferungen kappen auf:';

$GLOBALS['strCappingCampaign'] = array();
$GLOBALS['strCappingCampaign']['title'] = $GLOBALS['strDeliveryCapping'];
$GLOBALS['strCappingCampaign']['limit'] = 'Kampagnen kappen auf:';

$GLOBALS['strCappingZone'] = array();
$GLOBALS['strCappingZone']['title'] = $GLOBALS['strDeliveryCapping'];
$GLOBALS['strCappingZone']['limit'] = 'Zone kappen auf:';

// Publisher
$GLOBALS['strAffiliate']			= "Werbeträger";
$GLOBALS['strAffiliates']			= " Werbeträger";
$GLOBALS['strAffiliatesAndZones']		= " Werbeträger & Zonen";
$GLOBALS['strAddNewAffiliate']			= " Neuen Werbeträger hinzufügen";
$GLOBALS['strAddNewAffiliate_Key']		= " <u>N</u>euen Werbeträger hinzufügen";
$GLOBALS['strAddAffiliate']			= " Werbeträger hinzufügen";
$GLOBALS['strAffiliateProperties']		= " Werbeträger: Merkmale";
$GLOBALS['strAffiliateOverview']		= " Übersicht Werbeträger";
$GLOBALS['strAffiliateHistory']			= "Entwicklung Werbeträger";
$GLOBALS['strZonesWithoutAffiliate']		= "Zonen ohne Werbeträger";
$GLOBALS['strMoveToNewAffiliate']		= "Verschiebe zu neuem Werbeträger";
$GLOBALS['strNoAffiliates']			= "Derzeit sind keine Werbeträger definiert";
$GLOBALS['strConfirmDeleteAffiliate']		= "Soll dieser Werbeträger tatsächlich gelöscht werden?";
$GLOBALS['strMakePublisherPublic']		= "Mache die Zonen dieses Werbeträgers öffentlich zugänglich ";
$GLOBALS['strAffiliateInvocation']      = 'Bannercode';
$GLOBALS['strTotalAffiliates']          = 'Alle Werbeträger';
$GLOBALS['strInactiveAffiliatesHidden'] = "Inaktive Werbetreibende ausgeblendet";
$GLOBALS['strShowParentAffiliates']     = "Zugehörige Werbetreibende anzeigen";
$GLOBALS['strHideParentAffiliates']     = "Zugehörige Werbetreibende verbergen";

// Publisher (properties)
$GLOBALS['strWebsite']				= "Web-Site";
$GLOBALS['strMnemonic']                     = "Kürzel";
$GLOBALS['strAllowAffiliateModifyInfo']	 	= "Werbeträger darf eigene Einstellungen ändern ";
$GLOBALS['strAllowAffiliateModifyZones'] 	= "Werbeträger darf eigene Zonen ändern ";
$GLOBALS['strAllowAffiliateLinkBanners'] 	= "Werbeträger darf Banner seinen Zonen hinzufügen ";
$GLOBALS['strAllowAffiliateAddZone'] 		= "Werbeträger darf neue eigene Zonen hinzufügen ";
$GLOBALS['strAllowAffiliateDeleteZone']	 	= "Werbeträger darf eigene Zonen löschen ";
$GLOBALS['strAllowAffiliateGenerateCode']   = "Werbeträger darf Bannercode erstellen";
$GLOBALS['strAllowAffiliateZoneStats']      = "Werbeträger darf Zonen Statistiken einsehen";
$GLOBALS['strAllowAffiliateApprPendConv']   = "Werbeträger darf nur bestätigte oder noch anhängige Konversionen einsehen";

// Publisher (properties - payment information)
$GLOBALS['strPaymentInformation']           = "Zahlungsinformationen";
$GLOBALS['strAddress']                      = "Adresse";
$GLOBALS['strPostcode']                     = "PLZ";
$GLOBALS['strCity']                         = "Stadt";
$GLOBALS['strCountry']                      = "Land";
$GLOBALS['strPhone']                        = "Telefon";
$GLOBALS['strFax']                          = "Fax";
$GLOBALS['strAccountContact']               = "Kundenkontakt";
$GLOBALS['strPayeeName']                    = "Zahlungsempfänger";
$GLOBALS['strTaxID']                        = "Steuernummer";
$GLOBALS['strModeOfPayment']                = "Zahlungsart";
$GLOBALS['strPaymentChequeByPost']          = "Scheck";
$GLOBALS['strCurrency']                     = "Währung";
$GLOBALS['strCurrencyGBP']                  = "GBP";

// Publisher (properties - other information)
$GLOBALS['strOtherInformation']             = "Weitere Informationen";
$GLOBALS['strUniqueUsersMonth']             = "Eindeutige Besucher pro Monat";
$GLOBALS['strUniqueViewsMonth']             = "AdViews pro Monat";
$GLOBALS['strPageRank']                     = "Google Pagerank";
$GLOBALS['strCategory']                     = "Kategorie";
$GLOBALS['strHelpFile']                     = "Hilfedatei";
$GLOBALS['strApprovedTandC']                = "AGB zugestimmt";


// Zone
$GLOBALS['strChooseZone']                   = "Zone wählen";
$GLOBALS['strZone']				= "Zone";
$GLOBALS['strZones']				= "Zonen";
$GLOBALS['strAddNewZone']			= "Neue Zone hinzufügen";
$GLOBALS['strAddNewZone_Key']			= " <u>N</u>eue Zone hinzufügen ";
$GLOBALS['strAddZone']				= "Zone erstellen";
$GLOBALS['strModifyZone']			= "Zone ändern";
$GLOBALS['strLinkedZones']			= "Verknüpfte Zonen";
$GLOBALS['strZoneOverview']			= "Übersicht Zonen";
$GLOBALS['strZoneProperties']			= "Zonenmerkmale";
$GLOBALS['strZoneHistory']			= "Entwicklung Zonen";
$GLOBALS['strNoZones']				= "Zur Zeit keine Zonen festgelegt";
$GLOBALS['strConfirmDeleteZone']		= "Soll diese Zone tatsächlich gelöscht werden?";
$GLOBALS['strZoneType']				= "Zonentyp";
$GLOBALS['strBannerButtonRectangle']		= "Banner, Button oder Rechteck";
$GLOBALS['strInterstitial']			= "Interstitial oder Floating DHTML";
$GLOBALS['strPopUp']				= "Pop-Up";
$GLOBALS['strTextAdZone']			= "Textanzeige";
$GLOBALS['strEmailAdZone']				= "E-Mail/Newsletter";
$GLOBALS['strShowMatchingBanners']		= "Anzeige zugehörende Banner";
$GLOBALS['strHideMatchingBanners']		= "Verbergen zugehörende Banner";
$GLOBALS['strBannerLinkedAds']          = "Mit dieser Zone verknüpfte Werbemittel";
$GLOBALS['strCampaignLinkedAds']        = "Mit dieser Zone verknüpfte Kampagnen";
$GLOBALS['strTotalZones']               = 'Alle Zonen';
$GLOBALS['strCostInfo']                 = 'Buchungsart';
$GLOBALS['strTechnologyCost']               = 'Serverkosten';
$GLOBALS['strInactiveZonesHidden']          = "deaktivierte Zone(n) verborgen";

// Advanced zone settings
$GLOBALS['strAdvanced']				= "Erweiterte Merkmale";
$GLOBALS['strChains']				= "Verkettung";
$GLOBALS['strChainSettings']			= "Verkettungseinstellungen";
$GLOBALS['strZoneNoDelivery']			= "Wenn kein Banner dieser Zone <br />ausgeliefert werden kann, dann...";
$GLOBALS['strZoneStopDelivery']			= "stoppe die Werbemittelauslieferung und zeige kein Werbemittel an.";
$GLOBALS['strZoneOtherZone']			= "zeige statt dessen die Werbemittel der unten gewählten Zone an.";
$GLOBALS['strZoneUseKeywords']			= "Banner auswählen, welches nachfolgende Schlüsselwörter hat ";
$GLOBALS['strZoneAppend']			= "Immer diesen HTML-Code den Bannern aus dieser Zone anhängen ";
$GLOBALS['strAppendSettings']			= "HTML-Ergänzungen (Anhängen und Voranstellen)";
$GLOBALS['strZoneForecasting']			= "Einstellung Zonenprognose";
$GLOBALS['strZonePrependHTML']			= "Immer diesen HTML-Code den Testanzeigen aus dieser Zone voranstellen ";
$GLOBALS['strZoneAppendHTML']			= "Immer diesen HTML-Code den Testanzeigen aus dieser Zone anhängen ";
$GLOBALS['strZoneAppendType']			= "Type (Anhang)";
$GLOBALS['strZoneAppendNoBanner']        = "Hinzufügen, auch wenn kein Banner ausgeliefert wird";
$GLOBALS['strZoneAppendHTMLCode']		= "HTML-Code";
$GLOBALS['strZoneAppendZoneSelection']		= "Pop-Up oder Interstitial";
$GLOBALS['strZoneAppendSelectZone']		= "Immer das nebenstehende Pop-Up oder Intersitial-Banner zusätzlich mit den Bannern dieser Zone ausliefern";


// Zone probability
$GLOBALS['strZoneProbListChain']		= "Die Banner dieser Zone(n) sind nicht aktiv. Die Zonen sind miteinander verkettet.<br />Die Verkettung ist (von links nach rechts):";
$GLOBALS['strZoneProbNullPri']			= "Alle Banner dieser Zone sind nicht aktiv";
$GLOBALS['strZoneProbListChainLoop']		= "Die Verkettung dieser Zone(n) ist eine Endlosschleife. Die Bannerauslieferung ist angehalten ";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType']			= "Einbindungsmöglichkeiten für Banner ";
$GLOBALS['strLinkedBanners']			= "Werbemittel individuell verlinken";
$GLOBALS['strCampaignDefaults']		    = "Werbemittel aufgrund zugehöriger Kampagne verlinken";
$GLOBALS['strLinkedCategories']         = "Werbemittel nach Kategorien verlinken";
$GLOBALS['strInteractive']			= "Interaktive";
$GLOBALS['strRawQueryString']			= "Schlüsselwort";
$GLOBALS['strIncludedBanners']			= "Verknüpfte Banner";
$GLOBALS['strLinkedBannersOverview']		= "Übersicht verknüpfte Banner";
$GLOBALS['strLinkedBannerHistory']		= "Entwicklung Banner";
$GLOBALS['strNoZonesToLink']			= "Es sind keine Zonen vorhanden, denen der Banner zugeordnet werden kann";
$GLOBALS['strNoBannersToLink']			= "Es sind derzeit keine Banner vorhanden, die dieser Zone zugeordnet werden können";
$GLOBALS['strNoLinkedBanners']			= "Es sind keine Banner dieser Zone zugeordnet (mit ihr verknüpft)";
$GLOBALS['strMatchingBanners']			= "{count} zugehörende Banner";
$GLOBALS['strNoCampaignsToLink']		= "Es sind keine Kampagnen vorhanden, die mit dieser Zone verknüpft werden können";
$GLOBALS['strNoTrackersToLink']			= "Zur Zeit sind keine Tracker vorhanden, die mit dieser Kampagne verknüpft werden können.";
$GLOBALS['strNoZonesToLinkToCampaign']		= "Es sind keine Zonen vorhanden, die mit dieser Kampagne verknüpft werden können";
$GLOBALS['strSelectBannerToLink']		= "Wählen Sie einen Banner, der dieser Zone zugeordnet werden soll:";
$GLOBALS['strSelectCampaignToLink']		= "Wählen Sie eine Kampagne, die dieser Zone zugeordnet werden soll:";
$GLOBALS['strSelectAdvertiser']         = 'Werbetreibenden auswählen';
$GLOBALS['strSelectPlacement']          = 'Kampagne auswählen';
$GLOBALS['strSelectAd']                 = 'Werbemittel auswählen';
$GLOBALS['strTrackerCode']      	    = 'Liefere folgenden Code zusätzlich zu jeder Auslieferung eines Javascript Trackers aus.';
$GLOBALS['strTrackerCodeSubject']      	= 'Tracker-Code amhängen';
$GLOBALS['strAppendTrackerNotPossible']	= 'Dieser Tracker kann nicht angeängt werden.';
$GLOBALS['strStatusPending']            = 'wartet auf Überprüfung';
$GLOBALS['strStatusApproved']           = 'Freigegeben';
$GLOBALS['strStatusDisapproved']        = 'Abgelehnt';
$GLOBALS['strStatusDuplicate']          = 'Dublette';
$GLOBALS['strStatusOnHold']             = 'in der Warteschleife';
$GLOBALS['strStatusIgnore']             = 'Ignorieren';
$GLOBALS['strConnectionType']           = 'Art';
$GLOBALS['strConnTypeSale']             = 'Sale';
$GLOBALS['strConnTypeLead']             = 'Lead';
$GLOBALS['strConnTypeSignUp']           = 'Anmeldung';
$GLOBALS['strShortcutEditStatuses'] = 'Status bearbeiten';
$GLOBALS['strShortcutShowStatuses'] = 'Status anzeigen';
//neu in MMM 0.3

// Statistics
$GLOBALS['strStats'] 				= "Statistiken";
$GLOBALS['strNoStats']				= "Zur Zeit sind keine Statistiken vorhanden";
$GLOBALS['strNoTargetStats']			= "Es sind derzeit keine Statistiken für Ziele vorhanden ";
$GLOBALS['strNoStatsForPeriod']          = "Es sind derzeit keine Statistiken für den Zeitraum %s bis %s vorhanden";
$GLOBALS['strNoTargetingStatsForPeriod'] = "Es sind derzeit keine Targeting Statistiken für den Zeitraum %s bis %s vorhanden";
$GLOBALS['strConfirmResetStats']		= "Sollen tatsächlich alle vorhandenen Statistiken gelöscht werden?";
$GLOBALS['strGlobalHistory']			= "Generelle Entwicklung";
$GLOBALS['strDailyHistory']			= "Entwicklung Tag";
$GLOBALS['strDailyStats'] 			= "Tagesstatistik";
$GLOBALS['strWeeklyHistory']			= "Entwicklung Woche";
$GLOBALS['strMonthlyHistory']			= "Entwicklung Monat";
$GLOBALS['strCreditStats'] 			= "Guthabenstatistik";
$GLOBALS['strDetailStats'] 			= "Detaillierte Statistik";
$GLOBALS['strTotalThisPeriod']			= "Summe in der Periode";
$GLOBALS['strAverageThisPeriod']		= "Durchschnitt in der Periode";
$GLOBALS['strPublisherDistribution'] = "Verteilung auf die Werbeträger";
$GLOBALS['strCampaignDistribution']      = "Verteilung auf die Kampagnen";
$GLOBALS['strDistributionBy']		= "Verteilung nach";
$GLOBALS['strOptimise']				= "Optimieren";
$GLOBALS['strKeywordStatistics']	= "Schlüsselwortstatistiken";
$GLOBALS['strResetStats'] 			= "Statistiken zurücksetzen";
$GLOBALS['strSourceStats']			= "Quellstatistiken";
$GLOBALS['strSources']                   = "Quellen";
$GLOBALS['strAvailableSources']		= "Verfügbare Quellen";
$GLOBALS['strSelectSource']			= "Auswahl der Quelle, die angezeigt werden soll:";
$GLOBALS['strSizeDistribution']			= "Verteilung nach Größe";
$GLOBALS['strCountryDistribution']		= "Verteilung nach Land";
$GLOBALS['strEffectivity']			= "Effektivität";
$GLOBALS['strTargetStats']			= "Zielstatistiken";
$GLOBALS['strCampaignTarget']			= "Ziel";
$GLOBALS['strTargetRatio']			= "Ziel im Verhältnis";
$GLOBALS['strTargetModifiedDay']		= "Die Ziele wurden an diesem Tag verändert. Die Berechnungen können u.U. nicht korrekt sein";
$GLOBALS['strTargetModifiedWeek']		= "Die Ziele wurden in dieser Woche verändert. Die Berechnungen können u.U. nicht korrekt sein";
$GLOBALS['strTargetModifiedMonth']		= "Die Ziele wurden in diesem Monat verändert. Die Berechnungen können u.U. nicht korrekt sein";
$GLOBALS['strNoTargetStats']             = "There are currently no statistics about targeting available";
$GLOBALS['strOVerall']                   = "Gesamt";
$GLOBALS['strByZone']                    = "Nach Zone";
$GLOBALS['strImpressionsRequestsRatio']  = "Verhältnis Views/Requests (%)";
$GLOBALS['strViewBreakdown']             = "Nach Views";
$GLOBALS['strBreakdownByDay']            = "Tag";
$GLOBALS['strBreakdownByWeek']           = "Woche";
$GLOBALS['strBreakdownByMonth']          = "Monat";
$GLOBALS['strBreakdownByDow']            = "Wochentag";
$GLOBALS['strBreakdownByHour']           = "Stunde";
$GLOBALS['strItemsPerPage']              = "Anzeigen pro Seite";

$GLOBALS['strDistributionHistory']       = "Entwicklung der Verteilung";
$GLOBALS['strShowGraphOfStatistics']     = "Statistiken <u>g</u>raphisch darstellen";
$GLOBALS['strExportStatisticsToExcel']   = "Statistiken nach Excel <u>e</u>xportieren";
$GLOBALS['strGDnotEnabled']              = "Um grafische Statistiken anzeigen zu können, muss in PHP die GD Erweiterung aktiviert sein. <br />Bitte schauen Sie bei <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> für weitere Informationen.";
$GLOBALS['strTTFnotEnabled']             = "Sie haben die GD-Erweiterung in PHP aktiviert, jedoch gibt es ein Problem mit der Freetype Unterstützung.<br />FreeType wird benötigt, um grafische Statistiken anzuzeigen. Bitte kontrollieren Sie Ihre Server Konfiguration.";

// Hosts
$GLOBALS['strHosts']				= "Besucherhost";
$GLOBALS['strTopHosts'] 			= "Aktivsten Besucherhosts";
$GLOBALS['strTopCountries'] 			= "Aktivsten Länder";
$GLOBALS['strRecentHosts'] 			= "Besucherhost mit den größten Anfragen";

// Expiration
$GLOBALS['strExpired']				= "Ausgelaufen";
$GLOBALS['strExpiration'] 			= "Auslaufdatum";
$GLOBALS['strNoExpiration'] 			= "Kein Auslaufdatum festgelegt";
$GLOBALS['strEstimated'] 			= "Voraussichtliches Auslaufdatum";

// Reports
$GLOBALS['strReports']				= "Berichte";
$GLOBALS['strAdminReports']         = "Berichte für Administratoren";
$GLOBALS['strAdvertiserReports']    = "Berichte für Werbetreibende";
$GLOBALS['strAgencyReports']        = "Berichte für Agenturen";
$GLOBALS['strPublisherReports']     = "Berichte für Werbeträger";
$GLOBALS['strSelectReport']			= "Wählen Sie den zu erstellenden Bericht";
$GLOBALS['strStartDate']			= "Startdatum";
$GLOBALS['strEndDate']				= "Enddatum";
$GLOBALS['strNoData']				= "Für den ausgewählten Zeitraum liegen keine Daten vor.";


// Admin_UI_Fields
$GLOBALS['strAllAdvertisers']            = "Alle Werbetreibende";
$GLOBALS['strAnonAdvertisers']           = "Deaktivierte Werbetreibende";
$GLOBALS['strAllPublishers']             = "Alle Werbeträger";
$GLOBALS['strAnonPublishers']            = "Deaktivierte Werbeträger";
$GLOBALS['strAllAvailZones']             = "Alle verfügbaren Zonen";


// Userlog
$GLOBALS['strUserLog']				= "Benutzerprotokoll";
$GLOBALS['strUserLogDetails']			= "Details Benutzerprotokoll";
$GLOBALS['strDeleteLog']			= "Protokoll löschen";
$GLOBALS['strAction']				= "Aktion";
$GLOBALS['strNoActionsLogged']			= "Keine Aktionen protokolliert";

// Code generation
$GLOBALS['strGenerateBannercode']		= "Bannercode erstellen";
$GLOBALS['strChooseInvocationType']		= "Bitte wählen Sie die Auslieferungsart für die Werbemittel";
$GLOBALS['strGenerate']				= "Generiere";
$GLOBALS['strParameters']			= "Parameter";
$GLOBALS['strFrameSize']			= "Rahmengrüße";
$GLOBALS['strBannercode']			= "Bannercode";
$GLOBALS['strTrackercode']				= "Trackercode";
$GLOBALS['strOptional']				= "optional";
$GLOBALS['strBackToTheList']        = "Zur�ck zur Berichtsliste";
$GLOBALS['strGoToReportBuilder']    = "Zum ausgew�hlten Bericht";

// Errors
$GLOBALS['strMySQLError'] 			= "SQL Fehler:";
$GLOBALS['strLogErrorClients'] 			= "[phpAds] Ein Fehler ist beim Versuch aufgetreten, den Werbetreibenden aus der Datenbank zu laden.";
$GLOBALS['strLogErrorBanners'] 			= "[phpAds] Ein Fehler ist beim Versuch aufgetreten, den Banner aus der Datenbank zu laden.";
$GLOBALS['strLogErrorViews']			= "[phpAds] Ein Fehler ist beim Versuch aufgetreten, die AdViews aus der Datenbank zu laden.";
$GLOBALS['strLogErrorClicks'] 			= "[phpAds] Ein Fehler ist beim Versuch aufgetreten, die AdClicks aus der Datenbank zu laden.";
$GLOBALS['strLogErrorConversions'] 	    = "[phpAds] Beim Auslesen der Konversionsraten aus der Datenbank trat ein Fehler auf.";
$GLOBALS['strErrorViews'] 			= "Sie müssen die Anzahl der AdViews eingeben oder unbegrenzt wählen!";
$GLOBALS['strErrorNegViews'] 			= "Negative AdViews sind nicht möglich";
$GLOBALS['strErrorClicks'] 			= "Sie müssen die Anzahl der AdClicks eingeben oder unbegrenzt wählen!";
$GLOBALS['strErrorNegClicks'] 			= "Negative AdClicks sind nicht möglich";
$GLOBALS['strErrorNegConversions'] 		= "Negative Konversionen sind nicht zulässig.";
$GLOBALS['strErrorConversions'] 		= "Bitte geben Sie die Zahl der Konversinen ein oder markieren Sie das Feld unlimitiert!";
$GLOBALS['strNoMatchesFound']			= "Kein Objekt gefunden";
$GLOBALS['strErrorOccurred']			= "Ein Fehler ist aufgetreten";
$GLOBALS['strErrorUploadSecurity']		= "Ein mögliches Sicherheitsproblem wurde erkannt. Ladevorgang (Upload) wurde gestoppt!";
$GLOBALS['strErrorUploadBasedir']		= "Zugriff auf die zu ladende Datei konnte nicht erfolgen. Die Ursache liegt möglicherweise im <i>safemode </i> oder der Einschränkung von <i>open_basedir </i>";
$GLOBALS['strErrorUploadUnknown']		= "Zugriff auf die zu ladende Datei konnte aus unbekanntem Grund nicht erfolgen. Bitte die PHP-Konfiguration prüfen.";
$GLOBALS['strErrorStoreLocal']			= "Ein Fehler ist beim Versuch aufgetreten, den Banner in das lokale Verzeichnis zu speichern. Möglicherweise ist in der Konfiguration der lokale Verzeichnispfad nicht korrekt eingegeben.";
$GLOBALS['strErrorStoreFTP']			= " Ein Fehler ist beim Versuch aufgetreten, den Banner zum FTP-Server zu übertragen.. Möglicherweise ist der FTP-Server nicht verfügbar oder in der Konfiguration erfolgte die Einstellung für den FTP-Server nicht korrekt ";
$GLOBALS['strErrorDBPlain']			= "Beim Zugriff auf die Datenbank ist ein Fehler aufgetreten ";
$GLOBALS['strErrorDBSerious']			= "Ein schwerwiegendes Problem mit der Datenbank wurde erkannt";
$GLOBALS['strErrorDBNoDataPlain']		= "Aufgrund eines Fehlers mit der Datenbank konnte ".$phpAds_productname." weder aus der Datenbank lesen noch in sie schreiben. ";
$GLOBALS['strErrorDBNoDataSerious']		= "Aufgrund eines schweren Problems mit der Datenbank konnte ".$phpAds_productname." keine Daten suchen";
$GLOBALS['strErrorDBCorrupt']			= "Die Datenbanktabelle ist wahrscheinlich zerstört und mu&szlig wiederhergestellt werden. Informationen über die Wiederherstellung zerstörter Tabellen finden sich im Handbuch.";
$GLOBALS['strErrorDBContact']			= "Bitte nehmen Sie Kontakt mit dem Systemverwalter Ihres Servers auf und schildern Sie ihm das Problem. Nur er kann helfen.";
$GLOBALS['strErrorDBSubmitBug']			= "Wenn das Problem wiederholt auftritt, kann es ein Fehler in ".$phpAds_productname." sein. Bitte protokollieren Sie die Fehlermeldung uns senden sie diese an die Programmierer von ".$phpAds_productname.". Bitte beschreiben Sie alle Aktivitäten, die zu diesem Fehler führten.";
$GLOBALS['strMaintenanceNotActive']		= "Das Wartungsprogramm lief während der letzen 24 Stunden nicht. \\nDamit ".$phpAds_productname." korrekt arbeiten kann, muß das Wartungsprogramm stündlich \\naufgerufen werden. \\n\\nIm Handbuch finden sich weitere Informationen \\nzur Konfiguration des Wartungsprogrammes.";
$GLOBALS['strErrorBadUserType']         = "Das System war nicht in der Lage, Ihren Nutzertyp zu identifizieren!";
$GLOBALS['strErrorLinkingBanner']       = "Es gabe Fehler bei der Verkn�pfung von Bannern mit Zonen:";
$GLOBALS['strUnableToLinkBanner']       = "Folgende Verkn�pfung(en) sind fehlgeschlagen: ";
$GLOBALS['strErrorEditingCampaign']     = "Fehler beim Aktualisieren der Kampagne:";
$GLOBALS['strUnableToChangeCampaign']   = "Diese Änderung ist unwirksam weil:";
$GLOBALS['strDatesConflict']            = "Datumskonflikt mit:";
$GLOBALS['strEmailNoDates']             = 'E-Mail- und Newsletter-Kampagnen müssen ein Start- und ein Enddatum haben.';

// eMail
$GLOBALS['strSirMadam']                         = "Sehr geehrte Damen und Herren";
$GLOBALS['strMailSubject'] 			= "Bericht für Werbetreibende";
$GLOBALS['strAdReportSent']			= "Bericht für Werbetreibende versandt";
$GLOBALS['strMailHeader'] 			= "Sehr geehrte(r) {contact},\n";
$GLOBALS['strMailBannerStats'] 			= "Sie erhalten nachfolgend die Bannerstatistik für {clientname}:";
$GLOBALS['strMailBannerActivatedSubject']       = "Kampagne aktiviert";
$GLOBALS['strMailBannerDeactivatedSubject']     = "Kampagne deaktiviert";
$GLOBALS['strMailBannerActivated']              = "Die unten angegebene Kampagne wurde aktiviert, weil\ndas Kampagnen Startdatum erreicht wurde.";
$GLOBALS['strMailBannerDeactivated']            = "Die unten angegebene Kampagne wurde deaktiviert, weil";
$GLOBALS['strMailFooter'] 			= "Mit freundlichem Gruß\n   {adminfullname}";
$GLOBALS['strMailClientDeactivated'] 		= "Die folgenden Banner wurden deaktiviert, weil";
$GLOBALS['strMailNothingLeft'] 			= "Wir danken für Ihr Vertrauen, das wir Ihre Werbung auf unseren WEB-Seiten präsentieren durften. Gern werden wir Ihnen weiterhin zur Verfügung stehen.";
$GLOBALS['strClientDeactivated']		= "Diese Kampagne ist zur Zeit nicht aktiv, weil";
$GLOBALS['strBeforeActivate']			= "das Aktivierungsdatum noch nicht erreicht wurde ";
$GLOBALS['strAfterExpire']			= "das Auslaufdatum erreicht wurde ";
$GLOBALS['strNoMoreClicks']			= "Alle gebuchten Klicks sind aufgebraucht";
$GLOBALS['strNoMoreImpressions']	        = "Alle gebuchten Impressions sind aufgebraucht";
$GLOBALS['strNoMoreConversions']		    = "Alle gebuchten Konversionen sind aufgebraucht";
$GLOBALS['strWeightIsNull']			= "die Gewichtung auf 0 (Null) gesetzt wurde.";
$GLOBALS['strWarnClientTxt']			= "Die AdClicks oder die AdViews für Ihre Banner haben das Limit von {limit} erreicht. \n. ";
$GLOBALS['strImpressionsClicksConversionsLow']    = "Die Zahl der zur Verfügung stehenden Impressions/Klicks/Konversionen geht zur Neige.";
$GLOBALS['strNoViewLoggedInInterval']		= "Für den Berichtszeitraum wurden keine AdViews protokolliert";
$GLOBALS['strNoClickLoggedInInterval'] 		= "Für den Berichtszeitraum wurden keine AdClicks protokolliert";
$GLOBALS['strNoConversionLoggedInInterval'] = "Im Berichtsintervall fanden keine Konversionen statt.";
$GLOBALS['strMailReportPeriod']			= "Die Statistiken in diesem Bericht sind für den Zeitraum von {startdate} bis {enddate}.";
$GLOBALS['strMailReportPeriodAll']		= "Der Bericht enthält alle Statistiken bis {enddate}.";
$GLOBALS['strNoStatsForCampaign'] 		= "Für die Kampagne liegen keine Statistiken vor ";
$GLOBALS['strImpendingCampaignExpiry']          = "Bevorstehende Deaktivierung der Kampagne";
$GLOBALS['strYourCampaign']                     = "Ihre Kampagne";
$GLOBALS['strTheCampiaignBelongingTo']          = "Die Kampagne gehörend zu";
$GLOBALS['strImpendingCampaignExpiryDateBody']  = "Unten angegebene {clientname} wird am {date} auslaufen.";
$GLOBALS['strImpendingCampaignExpiryImpsBody']  = "Unten angegebene {clientname} hat weniger als {limit} Impressions �brig.";
$GLOBALS['strImpendingCampaignExpiryBody']      = "Auf Grund dessen wird die Kampagne bald deaktiviert und weiter unten angegebene Banner aus dieser Kampagne werden deaktiviert.";

// Priority
$GLOBALS['strPriority']				= "Priorität";
$GLOBALS['strSourceEdit']			= "Sources editieren";

// Settings
$GLOBALS['strSettings'] 			= "Einstellungen";
$GLOBALS['strGeneralSettings']		= "Allgemeine Einstellungen";
$GLOBALS['strMainSettings']			= "Haupteinstellungen";
$GLOBALS['strAdminSettings']		= "Einstellungen für die Administration";

// Product Updates
$GLOBALS['strProductUpdates']			= "Produkt-Update";
$GLOBALS['strCheckForUpdates']          = "Nach einem Update suchen";
$GLOBALS['strViewPastUpdates']          = "Vergangene Updates und Backups anzeigen";

// Agency
$GLOBALS['strAgencyManagement']		      = "Agenturverwaltung";
$GLOBALS['strAgency']				      = "Agentur";
$GLOBALS['strAgencies'] 			      = "Agenturen";
$GLOBALS['strAddAgency'] 			      = "Neue Agentur hinzufügen";
$GLOBALS['strAddAgency_Key'] 		      = "<u>N</u>eue Agentur hinzufügen";
$GLOBALS['strTotalAgencies'] 		      = "Alle Agenturen";
$GLOBALS['strAgencyProperties']		      = "Basisinformationen";
$GLOBALS['strNoAgencies']                 = "Zur Zeit sind keine Agenturen angelegt.";
$GLOBALS['strConfirmDeleteAgency'] 	      = "Wollen Sie diese Agentur wirklich löschen?";
$GLOBALS['strHideInactiveAgencies']	      = "Inaktive Agenturen ausblenden";
$GLOBALS['strInactiveAgenciesHidden']     = "Inaktive Agentur(en) ausgeblendet";
$GLOBALS['strAllowAgencyEditConversions'] = "Dieser Nutzer darf Konversionen bearbeiten";
$GLOBALS['strAllowMoreReports']           = "Zeige 'Weitere Reports' Button";

// Channels
$GLOBALS['strChannel']                    = "Gruppe";
$GLOBALS['strChannels']                   = "Gruppen";
$GLOBALS['strChannelOverview']		      = "Gruppenüberblick";
$GLOBALS['strChannelManagement']          = "Gruppenverwaltung";
$GLOBALS['strAddNewChannel']              = "Neue Gruppe hinzufügen";
$GLOBALS['strAddNewChannel_Key']          = "<u>N</u>eue Gruppe hinzufügen";
$GLOBALS['strNoChannels']                 = "Zur Zeit sind keine Gruppen angelegt.";
$GLOBALS['strEditChannelLimitations']     = "Gruppenbeschränkungen bearbeiten";
$GLOBALS['strChannelProperties']          = "Gruppeneigenschaften";
$GLOBALS['strChannelLimitations']         = "Auslieferungsoptionen";
$GLOBALS['strConfirmDeleteChannel']       = "Wollen Sie diese Gruppe wirklich löschen?";
$GLOBALS['strModifychannel']              = "Gruppen editieren";

// Tracker Variables
$GLOBALS['strVariableName']			 = "Variablenname";
$GLOBALS['strVariableDescription']	 = "Beschreibung";
$GLOBALS['strVariableDataType']		 = "Datentyp";
$GLOBALS['strVariablePurpose']       = "Grund";
$GLOBALS['strGeneric']               = "Generisch";
$GLOBALS['strBasketValue']           = "Warenkorb Werte";
$GLOBALS['strNumItems']              = "Anzahl der Einträge";
$GLOBALS['strVariableIsUnique']      = "Konversionen doublettenbereingt?";
$GLOBALS['strJavascript']			 = "Javascript";
$GLOBALS['strRefererQuerystring']	 = "Referer Abfragezeichenkette";
$GLOBALS['strQuerystring']	         = "Abfragezeichenkette";
$GLOBALS['strInteger']				 = "Ganzzahl";
$GLOBALS['strNumber']				 = "Zahl";
$GLOBALS['strString']				 = "Zeichenkette";
$GLOBALS['strTrackFollowingVars']	 = "Die folgende Variable tracken";
$GLOBALS['strAddVariable']			 = "Variable hinzufügen";
$GLOBALS['strNoVarsToTrack']		 = "Zur Zeit gibt es keine trackbaren Variablen.";
$GLOBALS['strVariableHidden']       = "Variable Werbetreibenden nicht anzeigen?";
$GLOBALS['strVariableRejectEmpty']  = "Wenn leer, ablehnen?";
$GLOBALS['strTrackingSettings']     = "Tracking Einstellungen";
$GLOBALS['strTrackerType']          = "Tracker Art";
$GLOBALS['strTrackerTypeJS']        = "Track JavaScript Variablen";
$GLOBALS['strTrackerTypeDefault']   = "Track JavaScript Variablen (backwards compatible, escaping needed)";
$GLOBALS['strTrackerTypeDOM']       = "Track HTML elements using DOM";
$GLOBALS['strTrackerTypeCustom']    = "Eigener JS code";
$GLOBALS['strVariableCode']         = "Javascript tracking code";


// Upload conversions
$GLOBALS['strRecordLengthTooBig']   = 'Record length too big';
$GLOBALS['strRecordNonInt']         = 'Value needs to be numeric';
$GLOBALS['strRecordWasNotInserted'] = 'Record was not inserted';
$GLOBALS['strWrongColumnPart1']     = '<br>Error in CSV file! Column <b>';
$GLOBALS['strWrongColumnPart2']     = '</b> is not allowed for this tracker';
$GLOBALS['strMissingColumnPart1']   = '<br>Error in CSV file! Column <b>';
$GLOBALS['strMissingColumnPart2']   = '</b> is missing';
$GLOBALS['strYouHaveNoTrackers']    = 'Advertiser has no trackers!';
$GLOBALS['strYouHaveNoCampaigns']   = 'Advertiser has no campaigns!';
$GLOBALS['strYouHaveNoBanners']     = 'Campaign has no banners!';
$GLOBALS['strYouHaveNoZones']       = 'Banner not linked to any zones!';
$GLOBALS['strNoBannersDropdown']    = '--No Banners Found--';
$GLOBALS['strNoZonesDropdown']      = '--No Zones Found--';
$GLOBALS['strInsertErrorPart1']     = '<br><br><center><b> Error, ';
$GLOBALS['strInsertErrorPart2']     = 'records was not inserted! </b></center>';
$GLOBALS['strDuplicatedValue']      = 'Duplicated Value!';
$GLOBALS['strInsertCorrect']        = '<br><br><center><b> File was uploaded correctly </b></center>';
$GLOBALS['strReuploadCsvFile']      = 'Reupload CSV File';
$GLOBALS['strConfirmUpload']        = 'Confirm Upload';
$GLOBALS['strLoadedRecords']        = 'Loaded Records';
$GLOBALS['strBrokenRecords']        = 'Broken Fields in all Records';
$GLOBALS['strWrongDateFormat']      = 'Wrong Date Format';


// Password recovery
$GLOBALS['strForgotPassword']         = "Passwort vergessen?";
$GLOBALS['strPasswordRecovery']       = "Password wiederherstellen";
$GLOBALS['strEmailRequired']          = "Das Feld E-mail muss belegt sein";
$GLOBALS['strPwdRecEmailSent']        = "Wiederherstellungsemail wurde versandt.";
$GLOBALS['strPwdRecEmailNotFound']    = "E-mail Adresse nicht gefunden";
$GLOBALS['strPwdRecPasswordSaved']    = "Das neue Passwort wurde gespeichert. Klicken Sie nun <a href='index.php'>hier</a>, um sich einzuloggen.";
$GLOBALS['strPwdRecWrongId']          = "Falsche ID";
$GLOBALS['strPwdRecEnterEmail']       = "Geben Sie nachfolgend Ihre eMail Adresse ein";
$GLOBALS['strPwdRecEnterPassword']    = "Geben Sie nachfolgend Ihr neues Passwort ein";
$GLOBALS['strPwdRecResetLink']        = "Link zum Passwort zur�cksetzen";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "%s Passwort wiederherstellen";
$GLOBALS['strProceed']                = "Weiter >";


/*-------------------------------------------------------*/
/* Keyboard shortcut assignments                         */
/*-------------------------------------------------------*/

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome']				= 'h';
$GLOBALS['keyUp']				= 'u';
$GLOBALS['keyNextItem']				= '.';
$GLOBALS['keyPreviousItem']			= ',';
$GLOBALS['keyList']				= 'l';

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch']				= 's'; //suche
$GLOBALS['keyCollapseAll']			= 'z'; //zusammenklappen
$GLOBALS['keyExpandAll']			= 'a'; // aufklappen
$GLOBALS['keyAddNew']				= 'n'; //Neu
$GLOBALS['keyNext']				= 'w'; //weiter
$GLOBALS['keyPrevious']				= 'z'; // zurück

?>
