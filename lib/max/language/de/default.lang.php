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
$GLOBALS['date_format'] = "%d.%m.%Y";
$GLOBALS['time_format'] = "%H:%M:%S";
$GLOBALS['minute_format'] = "%H:%M";
$GLOBALS['month_format'] = "%m-%Y";
$GLOBALS['day_format'] = "%d-%m";
$GLOBALS['week_format'] = "%W-%Y";
$GLOBALS['weekiso_format'] = "%V-%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate
$GLOBALS['excel_integer_formatting'] = "#,##0";
$GLOBALS['excel_decimal_formatting'] = "#,##0.000";

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "Startseite";
$GLOBALS['strHelp'] = "Hilfe";
$GLOBALS['strStartOver'] = "Neustart";
$GLOBALS['strShortcuts'] = "Schnellnavigation";
$GLOBALS['strActions'] = "Aktionen";
$GLOBALS['strAndXMore'] = "und %s mehr";
$GLOBALS['strAdminstration'] = "Inventar-Seiten";
$GLOBALS['strMaintenance'] = "Wartung (Programm)";
$GLOBALS['strProbability'] = "Wahrscheinlichkeit";
$GLOBALS['strInvocationcode'] = "Bannercode";
$GLOBALS['strBasicInformation'] = "Basisinformationen";
$GLOBALS['strAppendTrackerCode'] = "Tracker Code anhängen";
$GLOBALS['strOverview'] = "Übersicht";
$GLOBALS['strSearch'] = "<u>S</u>uchen";
$GLOBALS['strDetails'] = "Details";
$GLOBALS['strUpdateSettings'] = "Update Einstellungen";
$GLOBALS['strCheckForUpdates'] = "Auf neue Programmversionen prüfen";
$GLOBALS['strWhenCheckingForUpdates'] = "Bei der Prüfung auf Updates";
$GLOBALS['strCompact'] = "Kompakt";
$GLOBALS['strUser'] = "Benutzer";
$GLOBALS['strDuplicate'] = "Kopieren";
$GLOBALS['strCopyOf'] = "Kopie von";
$GLOBALS['strMoveTo'] = "Verschieben nach";
$GLOBALS['strDelete'] = "Löschen";
$GLOBALS['strActivate'] = "Aktivieren";
$GLOBALS['strConvert'] = "Konvertieren";
$GLOBALS['strRefresh'] = "Aktualisieren";
$GLOBALS['strSaveChanges'] = "Änderungen speichern";
$GLOBALS['strUp'] = "Oben";
$GLOBALS['strDown'] = "Unten";
$GLOBALS['strSave'] = "Speichern";
$GLOBALS['strCancel'] = "Abbrechen";
$GLOBALS['strBack'] = "Zurück";
$GLOBALS['strPrevious'] = "Zurück";
$GLOBALS['strNext'] = "Weiter";
$GLOBALS['strYes'] = "Ja";
$GLOBALS['strNo'] = "Nein";
$GLOBALS['strNone'] = "Keiner";
$GLOBALS['strCustom'] = "Benutzerdefiniert";
$GLOBALS['strDefault'] = "Standard";
$GLOBALS['strUnknown'] = "Unbekannt";
$GLOBALS['strUnlimited'] = "Unbegrenzt";
$GLOBALS['strUntitled'] = "Ohne Titel";
$GLOBALS['strAll'] = "alle";
$GLOBALS['strAverage'] = "Durchschnitt";
$GLOBALS['strOverall'] = "Gesamt";
$GLOBALS['strTotal'] = "Summe";
$GLOBALS['strFrom'] = "Von";
$GLOBALS['strTo'] = "bis";
$GLOBALS['strAdd'] = "Hinzufügen";
$GLOBALS['strLinkedTo'] = "verknüpft mit";
$GLOBALS['strDaysLeft'] = "Verbliebene Tage";
$GLOBALS['strCheckAllNone'] = "Prüfe alle / keine";
$GLOBALS['strKiloByte'] = "KB";
$GLOBALS['strExpandAll'] = "Alle <u>a</u>usklappen";
$GLOBALS['strCollapseAll'] = "Alle <u>z</u>usammenklappen";
$GLOBALS['strShowAll'] = "Alle anzeigen";
$GLOBALS['strNoAdminInterface'] = "Service nicht verfügbar ...";
$GLOBALS['strFieldStartDateBeforeEnd'] = "Das 'Von-Datum' muß vor dem 'Bis-Datum' liegen";
$GLOBALS['strFieldContainsErrors'] = "Folgende Felder sind fehlerhaft:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Bevor Sie fortgefahren können, müssen Sie";
$GLOBALS['strFieldFixBeforeContinue2'] = "diese Fehler beheben.";
$GLOBALS['strMiscellaneous'] = "Sonstiges";
$GLOBALS['strCollectedAllStats'] = "Alle Statistiken";
$GLOBALS['strCollectedToday'] = "Statistiken nur für heute";
$GLOBALS['strCollectedYesterday'] = "Gestern";
$GLOBALS['strCollectedThisWeek'] = "Diese Woche (Mon-Son)";
$GLOBALS['strCollectedLastWeek'] = "Letzte Woche (Mon-Son)";
$GLOBALS['strCollectedThisMonth'] = "Diesen Monat";
$GLOBALS['strCollectedLastMonth'] = "Letzten Monat";
$GLOBALS['strCollectedLast7Days'] = "Letzten 7 Tage";
$GLOBALS['strCollectedSpecificDates'] = "Bestimmtes Datum";
$GLOBALS['strValue'] = "Wert";
$GLOBALS['strWarning'] = "Warnung";
$GLOBALS['strNotice'] = "Hinweis";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "Das Dashboard kann nicht angezeigt werden";
$GLOBALS['strNoCheckForUpdates'] = "Das Dashboard kann nicht angezeigt werden da die Einstellung<br/>'Prüfung auf Updates' deaktiviert ist.";
$GLOBALS['strEnableCheckForUpdates'] = "Bitte aktivieren Sie die Option <a href='account-settings-update.php'>Auf Updates prüfen</a><br/>auf der Seite <a href='account-settings-update.php'>Update Einstellungen</a>.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "Code";
$GLOBALS['strDashboardSystemMessage'] = "Systemnachricht";
$GLOBALS['strDashboardErrorHelp'] = "Sollte dieser Fehler wiederholt vorkommen, schreiben Sie uns bitte einen detailierten Fehlerbericht im<a href='http://forum.revive-adserver.com/'>Revive Adserver/</a> Forum.";

// Priority
$GLOBALS['strPriority'] = "Priorität";
$GLOBALS['strPriorityLevel'] = "Dringlichkeitsstufe";
$GLOBALS['strOverrideAds'] = "Override Campaign Advertisements";
$GLOBALS['strHighAds'] = "Vertrags-Werbeanzeigen";
$GLOBALS['strECPMAds'] = "eCPM Werbeanzeigen";
$GLOBALS['strLowAds'] = "Verbleibende-Werbeanzeigen";
$GLOBALS['strLimitations'] = "Delivery rules";
$GLOBALS['strNoLimitations'] = "No delivery rules";
$GLOBALS['strCapping'] = "Kappung";

// Properties
$GLOBALS['strName'] = "Name";
$GLOBALS['strSize'] = "Größe";
$GLOBALS['strWidth'] = "Breite";
$GLOBALS['strHeight'] = "Höhe";
$GLOBALS['strTarget'] = "Zielfenster";
$GLOBALS['strLanguage'] = "Sprache";
$GLOBALS['strDescription'] = "Beschreibung";
$GLOBALS['strVariables'] = "Variablen";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "Kommentare";

// User access
$GLOBALS['strWorkingAs'] = "Verwendung als";
$GLOBALS['strWorkingAs_Key'] = "<u>A</u>rbeiten als";
$GLOBALS['strWorkingAs'] = "Verwendung als";
$GLOBALS['strSwitchTo'] = "Wechseln zu";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "Das \"Wechseln zu\" Suchfeld benutzen, um weitere Accounts zu finden";
$GLOBALS['strWorkingFor'] = "%s für";
$GLOBALS['strNoAccountWithXInNameFound'] = "Keine Konten mit \"%s\" im Namen gefunden";
$GLOBALS['strRecentlyUsed'] = "Zuletzt verwendet";
$GLOBALS['strLinkUser'] = "Benutzer hinzufügen";
$GLOBALS['strLinkUser_Key'] = "<u>B</u>enutzer hinzufügen";
$GLOBALS['strUsernameToLink'] = "Benutzername des hinzuzufügenden Benutzers";
$GLOBALS['strNewUserWillBeCreated'] = "Ein neuer Benutzer wird angelegt";
$GLOBALS['strToLinkProvideEmail'] = "Eintragen der E-Mail um den Benutzer hinzuzufügen";
$GLOBALS['strToLinkProvideUsername'] = "Eintragen des Benutzernamens um ihn hinzuzufügen";
$GLOBALS['strUserLinkedToAccount'] = "Benutzer wurde diesem Benutzerkonto hinzugefügt";
$GLOBALS['strUserAccountUpdated'] = "Benutzerkonto geändert";
$GLOBALS['strUserUnlinkedFromAccount'] = "Benutzer wurde von diesem Benutzerkonto entfernt";
$GLOBALS['strUserWasDeleted'] = "Benutzer wurde gelöscht";
$GLOBALS['strUserNotLinkedWithAccount'] = "Dieser Benutzer ist nicht mit diesem Benutzerkonto verknüpft";
$GLOBALS['strCantDeleteOneAdminUser'] = "Dieser Benutzer kann nicht gelöscht werden. Mindestens ein Benutzer muß mit dem Administratorkonto verknüpft sein.";
$GLOBALS['strLinkUserHelp'] = "Um einen <b>existierenden Benutzer</b> hinzuzufügen, schreiben Sie %1\$s und klicken auf %2\$s <br />Um einen <b>neuen Benutzer</b>, schreiben Sie den gewünschten %1\$s und klicken Sie %2\$s";
$GLOBALS['strLinkUserHelpUser'] = "Benutzername";
$GLOBALS['strLinkUserHelpEmail'] = "E-Mail Adresse";
$GLOBALS['strLastLoggedIn'] = "Zuletzt eingeloggt";
$GLOBALS['strDateLinked'] = "Datum verlinkt";

// Login & Permissions
$GLOBALS['strUserAccess'] = "Benutzerzugang";
$GLOBALS['strAdminAccess'] = "Administrator-Zugang";
$GLOBALS['strUserProperties'] = "Eigenschaften Benutzer";
$GLOBALS['strPermissions'] = "Erlaubnis";
$GLOBALS['strAuthentification'] = "Authentifikation";
$GLOBALS['strWelcomeTo'] = "Willkommen bei";
$GLOBALS['strEnterUsername'] = "Geben Sie Benutzername und Passwort ein";
$GLOBALS['strEnterBoth'] = "Bitte beides eingeben; Benutzername und Passwort";
$GLOBALS['strEnableCookies'] = "You need to enable cookies before you can use {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "Sitzungs-Cookie fehlerhaft, bitte loggen Sie sich erneut ein.";
$GLOBALS['strLogin'] = "Anmelden";
$GLOBALS['strLogout'] = "Ausloggen";
$GLOBALS['strUsername'] = "Benutzername";
$GLOBALS['strPassword'] = "Passwort";
$GLOBALS['strPasswordRepeat'] = "Wiederhole Passwort";
$GLOBALS['strAccessDenied'] = "Zugang verweigert";
$GLOBALS['strUsernameOrPasswordWrong'] = "Der Benutzername und/oder das Passwort sind nicht korrekt. Bitte erneut versuchen.";
$GLOBALS['strPasswordWrong'] = "Das Passwort ist nicht korrekt";
$GLOBALS['strNotAdmin'] = "Ihr Benutzerkonto hat nicht die erforderlichen Rechte um diese Funktion zu verwenden, Sie müssen ein anderes Benutzerkonto verwenden. Klicken Sie <a href='logout.php'>hier</a> um sich neu anzumelden.";
$GLOBALS['strDuplicateClientName'] = "Der gewählte Benutzername existiert bereits. Bitte einen anderen wählen.";
$GLOBALS['strInvalidPassword'] = "Das neue Passwort ist ungültig. Bitte wählen Sie ein anderes.";
$GLOBALS['strInvalidEmail'] = "Diese E-Mail Adresse ist nicht korrekt geschrieben, bitte tragen Sie eine korrekte E-Mail Adresse ein.";
$GLOBALS['strNotSamePasswords'] = "Die beiden eingegebenen Passwörter stimmen nicht überein ";
$GLOBALS['strRepeatPassword'] = "Wiederhole Passwort";
$GLOBALS['strDeadLink'] = "Ihr Link ist ungültig.";
$GLOBALS['strNoPlacement'] = "Die ausgewählte Kampagne existiert nicht. Versuchen Sie stattdessen diesen <a href='{link}'>Link</a>.";
$GLOBALS['strNoAdvertiser'] = "Der ausgewählte Werbetreibende existiert nicht. Versuchen Sie stattdessen diesen <a href='{link}'>Link</a>.";

// General advertising
$GLOBALS['strRequests'] = "Zugriffe";
$GLOBALS['strImpressions'] = "Impressions";
$GLOBALS['strClicks'] = "Klicks";
$GLOBALS['strConversions'] = "Konversionen";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "Summe der Klicks";
$GLOBALS['strTotalConversions'] = "Summe der Konversionen";
$GLOBALS['strDateTime'] = "Datum Zeit";
$GLOBALS['strTrackerID'] = "Tracker-ID";
$GLOBALS['strTrackerName'] = "Tracker-Name";
$GLOBALS['strTrackerImageTag'] = "Bilder Tag";
$GLOBALS['strTrackerJsTag'] = "JavaScript-Tag";
$GLOBALS['strTrackerAlwaysAppend'] = "Zeige angehängten Code immer an, auch wenn keine Konversion vom Tracker aufgezeichnet wurde?";
$GLOBALS['strBanners'] = "Banner";
$GLOBALS['strCampaigns'] = "Kampagnen";
$GLOBALS['strCampaignID'] = "Kampagnen-ID";
$GLOBALS['strCampaignName'] = "Kampagnenname";
$GLOBALS['strCountry'] = "Land";
$GLOBALS['strStatsAction'] = "Aktion";
$GLOBALS['strWindowDelay'] = "Zeitrahmen";
$GLOBALS['strStatsVariables'] = "Variablen";

// Finance
$GLOBALS['strFinanceCPM'] = "TKP";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Monatlicher Fixbetrag";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strFinanceCR'] = "KR";

// Time and date related
$GLOBALS['strDate'] = "Datum";
$GLOBALS['strDay'] = "Tag";
$GLOBALS['strDays'] = "Tage";
$GLOBALS['strWeek'] = "Woche";
$GLOBALS['strWeeks'] = "Wochen";
$GLOBALS['strSingleMonth'] = "Monat";
$GLOBALS['strMonths'] = "Monate";
$GLOBALS['strDayOfWeek'] = "Wochentag";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = array();
}
$GLOBALS['strDayFullNames'][0] = 'Sonntag';
$GLOBALS['strDayFullNames'][1] = 'Montag';
$GLOBALS['strDayFullNames'][2] = 'Dienstag';
$GLOBALS['strDayFullNames'][3] = 'Mittwoch';
$GLOBALS['strDayFullNames'][4] = 'Donnerstag';
$GLOBALS['strDayFullNames'][5] = 'Freitag';
$GLOBALS['strDayFullNames'][6] = 'Samstag';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = array();
}
$GLOBALS['strDayShortCuts'][0] = 'So';
$GLOBALS['strDayShortCuts'][1] = 'Mo';
$GLOBALS['strDayShortCuts'][2] = 'Di';
$GLOBALS['strDayShortCuts'][3] = 'Mi';
$GLOBALS['strDayShortCuts'][4] = 'Do';
$GLOBALS['strDayShortCuts'][5] = 'Fr';
$GLOBALS['strDayShortCuts'][6] = 'Sa';

$GLOBALS['strHour'] = "Stunde";
$GLOBALS['strSeconds'] = "Sekunden";
$GLOBALS['strMinutes'] = "Minuten";
$GLOBALS['strHours'] = "Stunden";

// Advertiser
$GLOBALS['strClient'] = "Werbetreibender";
$GLOBALS['strClients'] = "Werbetreibende";
$GLOBALS['strClientsAndCampaigns'] = "Werbetreibende & Kampagnen";
$GLOBALS['strAddClient'] = "Neuen Werbetreibenden hinzufügen";
$GLOBALS['strClientProperties'] = "Merkmale Werbetreibender";
$GLOBALS['strClientHistory'] = "Advertiser Statistics";
$GLOBALS['strNoClients'] = "Es sind keine Werbetreibenden angelegt. Um eine Werbekampagne anzulegen, müssen Sie zuerst einen <a href='advertiser-edit.php'>Werbetreibenden hinzufügen</a>.";
$GLOBALS['strConfirmDeleteClient'] = "Soll dieser Werbetreibende wirklich gelöscht werden?";
$GLOBALS['strConfirmDeleteClients'] = "Möchten Sie die ausgewählten Werbetreibenden wirklich löschen?";
$GLOBALS['strHideInactive'] = "Verberge inaktive";
$GLOBALS['strInactiveAdvertisersHidden'] = "Inaktive Werbetreibende sind verborgen";
$GLOBALS['strAdvertiserSignup'] = "Anmeldung Werbetreibender";
$GLOBALS['strAdvertiserCampaigns'] = "Die Kampagnen des Werbetreibenden";

// Advertisers properties
$GLOBALS['strContact'] = "Name der Kontaktperson";
$GLOBALS['strContactName'] = "Kontakt (Name)";
$GLOBALS['strEMail'] = "E-Mail";
$GLOBALS['strSendAdvertisingReport'] = "Versenden eines Kampagnen-Auswertung via E-Mail";
$GLOBALS['strNoDaysBetweenReports'] = "Anzahl Tage zwischen zwei Berichten";
$GLOBALS['strSendDeactivationWarning'] = "Versenden eine Benachrichtigungsmail, wenn eine Kampagne automatisch aktiviert oder deaktiviert wurde";
$GLOBALS['strAllowClientModifyBanner'] = "Werbetreibender darf eigene Banner verändern";
$GLOBALS['strAllowClientDisableBanner'] = "Werbetreibender darf eigene Banner deaktivieren";
$GLOBALS['strAllowClientActivateBanner'] = "Werbetreibender darf eigene Banner aktiveren";
$GLOBALS['strAllowCreateAccounts'] = "Allow this user to manage this account's users";
$GLOBALS['strAdvertiserLimitation'] = "Nur ein einziges Banner von diesem Werbetreibenden auf einer Webseite anzeigen";
$GLOBALS['strAllowAuditTrailAccess'] = "Diesem Benutzer die Ansicht des Prüfprotokolls erlauben";

// Campaign
$GLOBALS['strCampaign'] = "Kampagne";
$GLOBALS['strCampaigns'] = "Kampagnen";
$GLOBALS['strAddCampaign'] = "Neue Kampagnen hinzufügen";
$GLOBALS['strAddCampaign_Key'] = "<u>N</u>eue Kampagnen hinzufügen";
$GLOBALS['strCampaignForAdvertiser'] = "für Werbetreibende";
$GLOBALS['strLinkedCampaigns'] = "Verknüpfte Kampagnen";
$GLOBALS['strCampaignProperties'] = "Merkmale Kampagnen";
$GLOBALS['strCampaignOverview'] = "Übersicht Kampagnen";
$GLOBALS['strCampaignHistory'] = "Campaign Statistics";
$GLOBALS['strNoCampaigns'] = "Für diesen Werbetreibenden sind derzeit keine Kampagnen definiert.";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "Momentan sind keine Kampagnen definiert, da keine  Werbetreibenden angelegt wurden. Um eine Kampagne zu erstellen, bitte erst einen <a href='advertiser-edit.php'>Webetreibenden anlegen</a>.";
$GLOBALS['strConfirmDeleteCampaign'] = "Soll diese Kampagne wirklich gelöscht werden?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Möchten Sie die ausgewählten Kampagnen wirklich löschen?";
$GLOBALS['strShowParentAdvertisers'] = "Zugehörige Werbetreibende anzeigen";
$GLOBALS['strHideParentAdvertisers'] = "Verberge zugehörige Werbetreibende";
$GLOBALS['strHideInactiveCampaigns'] = "Verberge inaktive Kampagnen";
$GLOBALS['strInactiveCampaignsHidden'] = "inaktive Kampagne sind verborgen";
$GLOBALS['strPriorityInformation'] = "Priorität in Beziehung zu anderen Kampagnen";
$GLOBALS['strECPMInformation'] = "eCPM Priorisierung";
$GLOBALS['strRemnantEcpmDescription'] = "eCPM wird automatisch aus der Performance der Kampagne errechnet.<br />Es wird dazu benutzt, die übriggebliebenen Kampagnen untereinander zu priorisieren.";
$GLOBALS['strEcpmMinImpsDescription'] = "Setzen Sie den Wert auf das gewünschte Minmum, mit dem der eCPM der Kampagne berechnet werden soll.";
$GLOBALS['strHiddenCampaign'] = "Kampagne";
$GLOBALS['strHiddenAd'] = "Verborgene Werbung";
$GLOBALS['strHiddenAdvertiser'] = "Werbetreibender";
$GLOBALS['strHiddenTracker'] = "Verborgene Tracker";
$GLOBALS['strHiddenWebsite'] = "Webseite";
$GLOBALS['strHiddenZone'] = "Verborgene Zone";
$GLOBALS['strCampaignDelivery'] = "Kampagnen Auslieferung";
$GLOBALS['strCompanionPositioning'] = "Tandem-Ads";
$GLOBALS['strSelectUnselectAll'] = "Alle aus- und abwählen";
$GLOBALS['strCampaignsOfAdvertiser'] = "von"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'
$GLOBALS['strShowCappedNoCookie'] = "Zeige gekappte Anzeigen, falls Cookies deaktiviert sind";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "Berechnet für alle Kampagnen";
$GLOBALS['strCalculatedForThisCampaign'] = "Berechnet für diese Kampagne";
$GLOBALS['strLinkingZonesProblem'] = "Das Problem ist beim Verlinken der Zonen aufgetreten";
$GLOBALS['strUnlinkingZonesProblem'] = "Das Problem ist beim Aufheben der Zonenverlinkung aufgetreten";
$GLOBALS['strZonesLinked'] = "Zone(n) verlinkt";
$GLOBALS['strZonesUnlinked'] = "Zonenverlinkung aufgehoben";
$GLOBALS['strZonesSearch'] = "Suchen";
$GLOBALS['strZonesSearchTitle'] = "Suche Zonen und Webseiten nach Namen";
$GLOBALS['strNoWebsitesAndZones'] = "Keine Webseiten und Zonen";
$GLOBALS['strNoWebsitesAndZonesText'] = "mit \"%s\" im Namen";
$GLOBALS['strToLink'] = "zum Verlinken";
$GLOBALS['strToUnlink'] = "zum Aufheben der Verlinkung";
$GLOBALS['strLinked'] = "Verlinkt";
$GLOBALS['strAvailable'] = "Verfügbar";
$GLOBALS['strShowing'] = "Angezeigt";
$GLOBALS['strEditZone'] = "Zone ändern";
$GLOBALS['strEditWebsite'] = "Webseite ändern";


// Campaign properties
$GLOBALS['strDontExpire'] = "Nicht beenden";
$GLOBALS['strActivateNow'] = "Sofort beginnen";
$GLOBALS['strSetSpecificDate'] = "Ein bestimmtes Datum setzen";
$GLOBALS['strLow'] = "Niedrig";
$GLOBALS['strHigh'] = "Dringlichkeit";
$GLOBALS['strExpirationDate'] = "Enddatum";
$GLOBALS['strExpirationDateComment'] = "Kampagne wird am Ende dieses Tages auslaufen.";
$GLOBALS['strActivationDate'] = "Startdatum";
$GLOBALS['strActivationDateComment'] = "Kampagne wird zu Beginn dieses Tages starten.";
$GLOBALS['strImpressionsRemaining'] = "Verbleibende Werbemittelauslieferungen";
$GLOBALS['strClicksRemaining'] = "Verbleibende Klicks";
$GLOBALS['strConversionsRemaining'] = "Verbleibende Konversionen";
$GLOBALS['strImpressionsBooked'] = "Gebuchte Werbemittelauslieferungen";
$GLOBALS['strClicksBooked'] = "Gebuchte Klicks";
$GLOBALS['strConversionsBooked'] = "Gebuchte Konversionen";
$GLOBALS['strCampaignWeight'] = "Gewichtung der Kampagne";
$GLOBALS['strAnonymous'] = "Verberge den Werbetreibenden und die Webseite dieser Kampagne.";
$GLOBALS['strTargetPerDay'] = "pro Tag.";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "Der Kampagnentyp ist auf Verbleibende gesetzt,
aber die Gewichtung ist 0 (oder sie ist undefiniert) -
 hierdurch wird diese Kampagne inaktiv bleiben und
 die Banner werden nicht ausgeliefert bis eine gültige
 Gewichtung eingegeben wird.

Sind Sie sicher dass Sie fortfahren möchten?";
$GLOBALS['strCampaignWarningEcpmNoRevenue'] = "Diese Kampagne benutzt eCPM Optimierung, 
aber das 'Einkommen' wurde auf '0' gesetzt oder ist leer - 
hierdurch wird diese Kampagne inaktiv bleiben und 
die Banner werden nicht ausgeliefert bis das 
Einkommen auf einen gültigen Wert gesetzt wurde. 

Sind Sie sicher dass Sie fortfahren möchten?";
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
$GLOBALS['strCampaignStatusPending'] = "wartet auf Überprüfung";
$GLOBALS['strCampaignStatusInactive'] = "inaktiv";
$GLOBALS['strCampaignStatusRunning'] = "In Bearbeitung";
$GLOBALS['strCampaignStatusPaused'] = "Pausiert";
$GLOBALS['strCampaignStatusAwaiting'] = "Erwarten";
$GLOBALS['strCampaignStatusExpired'] = "Beendet";
$GLOBALS['strCampaignStatusApproval'] = "Wartet auf Zustimmung »";
$GLOBALS['strCampaignStatusRejected'] = "Abgeleht";
$GLOBALS['strCampaignStatusAdded'] = "Hinzugefügt";
$GLOBALS['strCampaignStatusStarted'] = "Gestartet";
$GLOBALS['strCampaignStatusRestarted'] = "Neu gestartet";
$GLOBALS['strCampaignStatusDeleted'] = "Gelöscht";
$GLOBALS['strCampaignType'] = "Typ der Kampagnen";
$GLOBALS['strType'] = "Art";
$GLOBALS['strContract'] = "Vertrag";
$GLOBALS['strOverride'] = "Override";
$GLOBALS['strOverrideInfo'] = "Override campaigns are a special campaign type specifically to
    override (i.e. take priority over) Remnant and Contract campaigns. Override campaigns are generally used with
    specific targeting and/or capping rules to ensure that the campaign banners are always displayed in certain
    locations, to certain users, and perhaps a certain number of times, as part of a specific promotion. (This campaign
    type was previously known as 'Contract (Exclusive)'.)";
$GLOBALS['strStandardContract'] = "Vertrag";
$GLOBALS['strStandardContractInfo'] = "Diese Kampagne hat ein Tageslimit und wird gleichmäßig ausgeliefert bis das Enddatum erreicht ist oder das spezifizierte Limit erfüllt ist";
$GLOBALS['strRemnant'] = "Verbleibende";
$GLOBALS['strRemnantInfo'] = "Dies ist eine Standard-Kampagne, sie kann mit einem Enddatum oder einem bestimmten Limit versehen werden";
$GLOBALS['strECPMInfo'] = "This is a standard campaign which can be constrained with either an end date or a specific limit. Based on current settings it will be prioritised using eCPM.";
$GLOBALS['strPricing'] = "Preiskalkulation";
$GLOBALS['strPricingModel'] = "Preiskalkulationsmodell";
$GLOBALS['strSelectPricingModel'] = "\\-- Modell auswählen --";
$GLOBALS['strRatePrice'] = "Rate / Preis";
$GLOBALS['strMinimumImpressions'] = "Minimum daily impressions";
$GLOBALS['strLimit'] = "Limit";
$GLOBALS['strLowExclusiveDisabled'] = "Diese Kampagne kann nicht auf Verbleibende oder Exklusive geändert werden, da sowohl ein Ende-Datum als auch ein Impressionen/Klicks/Konversionen-Limit gesetzt ist.<br />Um den Typ der Kampagne zu ändern muß das Ende-Datum oder das Limit entfernt werden.";
$GLOBALS['strCannotSetBothDateAndLimit'] = "Für eine Verbleibende oder Exklusive Kampagne kann kein Ende-Datum zusammen mit einem Auslieferungslimit gesetzt werden.<br />Wenn ein Ende-Datum zusammen mit einem Limit auf Impressionen/Klicks/Konversionen benötigt wird, kann nur eine nicht-exklusive Vertrags-Kampagne verwendet werden.";
$GLOBALS['strWhyDisabled'] = "warum ist sie deaktiviert?";
$GLOBALS['strBackToCampaigns'] = "Zurück zu den Kampagnen";
$GLOBALS['strCampaignBanners'] = "Banner der Kampagne";
$GLOBALS['strCookies'] = "Cookies";

// Tracker
$GLOBALS['strTracker'] = "Verborgene Tracker";
$GLOBALS['strTrackers'] = "Tracker";
$GLOBALS['strTrackerPreferences'] = "Voreinstellungen Tracker";
$GLOBALS['strAddTracker'] = "Neuen Tracker hinzufügen";
$GLOBALS['strTrackerForAdvertiser'] = "für Werbetreibende";
$GLOBALS['strNoTrackers'] = "Für diesen Werbetreibenden sind zur Zeit keine Tracker angelegt";
$GLOBALS['strConfirmDeleteTrackers'] = "Wollen Sie die ausgewählten Tracker wirklich löschen?";
$GLOBALS['strConfirmDeleteTracker'] = "Wollen Sie diesen Tracker wirklich löschen?";
$GLOBALS['strTrackerProperties'] = "Tracker Merkmale";
$GLOBALS['strDefaultStatus'] = "Standardstatus";
$GLOBALS['strStatus'] = "Status";
$GLOBALS['strLinkedTrackers'] = "verlinkte Tracker";
$GLOBALS['strTrackerInformation'] = "Tracker Informationen";
$GLOBALS['strConversionWindow'] = "Konversionsintervall";
$GLOBALS['strUniqueWindow'] = "Eindeutiger Zeitrahmen";
$GLOBALS['strClick'] = "Klick";
$GLOBALS['strView'] = "View";
$GLOBALS['strArrival'] = "Arrival";
$GLOBALS['strManual'] = "Manual";
$GLOBALS['strImpression'] = "Impression";
$GLOBALS['strConversionType'] = "Konversionstyp";
$GLOBALS['strLinkCampaignsByDefault'] = "Verlinke neu erstellte Kampagnen automatisch";
$GLOBALS['strBackToTrackers'] = "Zurück zu den Trackern";
$GLOBALS['strIPAddress'] = "IP Adresse";

// Banners (General)
$GLOBALS['strBanner'] = "Banner";
$GLOBALS['strBanners'] = "Banner";
$GLOBALS['strAddBanner'] = "Neues Banner hinzufügen";
$GLOBALS['strAddBanner_Key'] = "<u>N</u>eues Banner hinzufügen ";
$GLOBALS['strBannerToCampaign'] = "Zur Kampagne";
$GLOBALS['strShowBanner'] = "Banner anzeigen";
$GLOBALS['strBannerProperties'] = "Bannermerkmale";
$GLOBALS['strBannerHistory'] = "Banner Statistics";
$GLOBALS['strNoBanners'] = "Für diese Kampagne sind zur Zeit keine Banner definiert";
$GLOBALS['strNoBannersAddCampaign'] = "Es sind keine Banner angelegt, da es noch keine Kampagnen gibt. Um einen Banner anzulegen, müssen Sie zuerst eine <a href='campaign-edit.php?clientid=%s'>neue Kampagne hinzufügen</a>.";
$GLOBALS['strNoBannersAddAdvertiser'] = "Es sind keine Banner angelegt, da es noch keine Werbetreibenden gibt. Um einen Banner anzulegen, müssen Sie zuerst einen <a href='advertiser-edit.php'>neue Werbetreibenden hinzufügen</a>.";
$GLOBALS['strConfirmDeleteBanner'] = "Soll dieser Banner wirklich gelöscht werden?";
$GLOBALS['strConfirmDeleteBanners'] = "Möchten Sie die ausgewählten Banner wirklich löschen?";
$GLOBALS['strShowParentCampaigns'] = "Zugehörige Kampagnen anzeigen";
$GLOBALS['strHideParentCampaigns'] = "Zugehörige Kampagnen verbergen";
$GLOBALS['strHideInactiveBanners'] = "Inaktive Banner verbergen";
$GLOBALS['strInactiveBannersHidden'] = "inaktive Banner sind verborgen";
$GLOBALS['strWarningMissing'] = "Warnung, wahrscheinlich fehlt ";
$GLOBALS['strWarningMissingClosing'] = "der schließender HTML-Tag '>'";
$GLOBALS['strWarningMissingOpening'] = "der öffnende HTML-Tag '<'";
$GLOBALS['strSubmitAnyway'] = "Trotzdem absenden?";
$GLOBALS['strBannersOfCampaign'] = "in"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "Voreinstellungen Banner";
$GLOBALS['strCampaignPreferences'] = "Campaign Preferences";
$GLOBALS['strDefaultBanners'] = "Default Banners";
$GLOBALS['strDefaultBannerUrl'] = "Default Image URL";
$GLOBALS['strDefaultBannerDestination'] = "Default Destination URL";
$GLOBALS['strAllowedBannerTypes'] = "Allowed Banner Types";
$GLOBALS['strTypeSqlAllow'] = "Allow SQL Local Banners";
$GLOBALS['strTypeWebAllow'] = "Allow Webserver Local Banners";
$GLOBALS['strTypeUrlAllow'] = "Allow External Banners";
$GLOBALS['strTypeHtmlAllow'] = "Allow HTML Banners";
$GLOBALS['strTypeTxtAllow'] = "Allow Text Ads";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Bannertype auswählen";
$GLOBALS['strMySQLBanner'] = "Einen lokal gespeicherten Banner in Datenbank laden";
$GLOBALS['strWebBanner'] = "Einen lokal gespeicherten Banner auf den Webserver laden";
$GLOBALS['strURLBanner'] = "Verlinke einen externen Banner";
$GLOBALS['strHTMLBanner'] = "Einen HTML-Banner anlegen";
$GLOBALS['strTextBanner'] = "Einen Text-Banner anlegen";
$GLOBALS['strAlterHTML'] = "Alter HTML to enable click tracking for:";
$GLOBALS['strIframeFriendly'] = "Dieser Banner kann ohne Einschränkungen innerhalb eines iFrames angezeigt werden (d.h. nicht expandierend)";
$GLOBALS['strUploadOrKeep'] = "Soll die vorhandene <br />Bilddatei behalten werden, oder soll <br />ein neues geladen werden?";
$GLOBALS['strNewBannerFile'] = "Wählen Sie die Bilddatei <br />für dieses Banner<br /><br />";
$GLOBALS['strNewBannerFileAlt'] = "Wählen Sie eine Alternativdatei (JPG, GIF, ...) aus<br />für den Fall, daß ein Besucher<br />das RichMedia-Werbemittel nicht darstellen kann<br /><br />";
$GLOBALS['strNewBannerURL'] = "Bild-URL (incl. http://)";
$GLOBALS['strURL'] = "Ziel-URL (incl. http://)";
$GLOBALS['strKeyword'] = "Schlüsselwörter";
$GLOBALS['strTextBelow'] = "Text unterhalb Banner";
$GLOBALS['strWeight'] = "Gewichtung";
$GLOBALS['strAlt'] = "Alt-Text";
$GLOBALS['strStatusText'] = "Status-Text";
$GLOBALS['strCampaignsWeight'] = "Campaign's Weight";
$GLOBALS['strBannerWeight'] = "Bannergewichtung";
$GLOBALS['strBannersWeight'] = "Bannergewichtung";
$GLOBALS['strAdserverTypeGeneric'] = "Standard HTML-Banner";
$GLOBALS['strDoNotAlterHtml'] = "HTML nicht ändern";
$GLOBALS['strGenericOutputAdServer'] = "Generisch";
$GLOBALS['strSwfTransparency'] = "Transparenten Hintergrund zulassen";
$GLOBALS['strBackToBanners'] = "Zurück zu den Bannern";
$GLOBALS['strUseWyswygHtmlEditor'] = "WYSIWYG HTML-Editor verwenden";
$GLOBALS['strChangeDefault'] = "Change default";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "Always prepend the following HTML code to this banner";
$GLOBALS['strBannerAppendHTML'] = "Always append the following HTML code to this banner";

// Banner (swf)
$GLOBALS['strCheckSWF'] = "Prüfung auf direkte Links (hard-coded) innerhalb der Flash-Datei";
$GLOBALS['strConvertSWFLinks'] = "direkten Flash-Link konvertieren";
$GLOBALS['strHardcodedLinks'] = "direkter Link (hard-coded)";
$GLOBALS['strConvertSWF'] = "<br />The Flash file you just uploaded contains hard-coded urls. {$PRODUCT_NAME} won't be able to track the number of Clicks for this banner unless you convert these hard-coded urls. Below you will find a list of all urls inside the Flash file. If you want to convert the urls, simply click <b>Convert</b>, otherwise click <b>Cancel</b>.<br /><br />Please note: if you click <b>Convert</b> the Flash file you just uploaded will be physically altered. <br />Please keep a backup of the original file. Regardless of in which version this banner was created, the resulting file will need the Flash 4 player (or higher) to display correctly.<br /><br />";
$GLOBALS['strCompressSWF'] = "Komprimieren der SWF-Datei für eine schnellere Übertragung zum Browser (Flash-Player 6 wird benötigt)";
$GLOBALS['strOverwriteSource'] = "Überschreiben der Parameter im Quelltext";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "Auslieferungsoptionen";
$GLOBALS['strACL'] = "Auslieferungsoptionen";
$GLOBALS['strACLAdd'] = "Add delivery rule";
$GLOBALS['strApplyLimitationsTo'] = "Apply delivery rules to";
$GLOBALS['strAllBannersInCampaign'] = "All banners in this campaign";
$GLOBALS['strRemoveAllLimitations'] = "Remove all delivery rules";
$GLOBALS['strEqualTo'] = "ist gleich";
$GLOBALS['strDifferentFrom'] = "ist ungleich";
$GLOBALS['strLaterThan'] = "ist später als";
$GLOBALS['strLaterThanOrEqual'] = "is later than or equal to";
$GLOBALS['strEarlierThan'] = "ist früher als";
$GLOBALS['strEarlierThanOrEqual'] = "is earlier than or equal to";
$GLOBALS['strContains'] = "enthält";
$GLOBALS['strNotContains'] = "beinhaltet nicht";
$GLOBALS['strGreaterThan'] = "ist größer als";
$GLOBALS['strLessThan'] = "ist kleiner als";
$GLOBALS['strGreaterOrEqualTo'] = "is greater or equal to";
$GLOBALS['strLessOrEqualTo'] = "is less or equal to";
$GLOBALS['strAND'] = "UND";                          // logical operator
$GLOBALS['strOR'] = "ODER";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Diesen Banner nur anzeigen, wenn:";
$GLOBALS['strWeekDays'] = "Wochentage";
$GLOBALS['strTime'] = "Zeit";
$GLOBALS['strDomain'] = "Domain";
$GLOBALS['strSource'] = "Quelle";
$GLOBALS['strBrowser'] = "Browser";
$GLOBALS['strOS'] = "OS";
$GLOBALS['strDeliveryLimitations'] = "Delivery Rules";

$GLOBALS['strDeliveryCappingReset'] = "Rücksetzen AdView-Zählers nach";
$GLOBALS['strDeliveryCappingTotal'] = "insgesamt";
$GLOBALS['strDeliveryCappingSession'] = "pro Session";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['title'] = "Kappung der Auslieferung pro Besucher";
$GLOBALS['strCappingBanner']['limit'] = "Banner Ausliferungen kappen auf:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['title'] = "Kappung der Auslieferung pro Besucher";
$GLOBALS['strCappingCampaign']['limit'] = "Kampagnen kappen auf:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['title'] = "Kappung der Auslieferung pro Besucher";
$GLOBALS['strCappingZone']['limit'] = "Zone kappen auf:";

// Website
$GLOBALS['strAffiliate'] = "Webseite";
$GLOBALS['strAffiliates'] = "Webseiten";
$GLOBALS['strAffiliatesAndZones'] = "Webseiten & Zonen";
$GLOBALS['strAddNewAffiliate'] = "Neuen Webseite anlegen";
$GLOBALS['strAffiliateProperties'] = "Webseite Merkmale";
$GLOBALS['strAffiliateHistory'] = "Website Statistics";
$GLOBALS['strNoAffiliates'] = "Es sind keine Webseiten angelegt. Um eine Zone anzulegen, müssen Sie zuerst eine <a href='affiliate-edit.php'>Webseite hinzufügen</a>.";
$GLOBALS['strConfirmDeleteAffiliate'] = "Soll diese Webseite tatsächlich gelöscht werden?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Möchten Sie die ausgewählten Webseiten wirklich löschen?";
$GLOBALS['strInactiveAffiliatesHidden'] = "Inaktive Webseiten ausgeblendet";
$GLOBALS['strShowParentAffiliates'] = "Zugehörige Webseiten anzeigen";
$GLOBALS['strHideParentAffiliates'] = "Zugehörige Webseite verbergen";

// Website (properties)
$GLOBALS['strWebsite'] = "Webseite";
$GLOBALS['strWebsiteURL'] = "URL der Webseite";
$GLOBALS['strAllowAffiliateModifyZones'] = "Werbeträger darf eigene Zonen ändern ";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Werbeträger darf Banner seinen Zonen hinzufügen ";
$GLOBALS['strAllowAffiliateAddZone'] = "Werbeträger darf neue eigene Zonen hinzufügen ";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Werbeträger darf eigene Zonen löschen ";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Werbeträger darf Bannercode erstellen";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "PLZ";
$GLOBALS['strCountry'] = "Land";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Zonen der Webseite";

// Zone
$GLOBALS['strZone'] = "Verborgene Zone";
$GLOBALS['strZones'] = "Zonen";
$GLOBALS['strAddNewZone'] = "Neue Zone hinzufügen";
$GLOBALS['strAddNewZone_Key'] = "<u>N</u>eue Zone hinzufügen";
$GLOBALS['strZoneToWebsite'] = "Zur Webseite";
$GLOBALS['strLinkedZones'] = "Verknüpfte Zonen";
$GLOBALS['strAvailableZones'] = "Verfügbare Zonen";
$GLOBALS['strLinkingNotSuccess'] = "Verlinkung nicht erfolgreich, bitte versuchen Sie es erneut";
$GLOBALS['strZoneProperties'] = "Zonenmerkmale";
$GLOBALS['strZoneHistory'] = "Entwicklung Zonen";
$GLOBALS['strNoZones'] = "Für diese Webseite sind zur Zeit keine Zonen angelegt.";
$GLOBALS['strNoZonesAddWebsite'] = "Es sind keine Zonen angelegt, da es noch keine Webseiten gibt. Um eine Zone anzulegen, müssen Sie zuerst eine <a href='affiliate-edit.php'>neue Webseite hinzufügen</a>.";
$GLOBALS['strConfirmDeleteZone'] = "Soll diese Zone tatsächlich gelöscht werden?";
$GLOBALS['strConfirmDeleteZones'] = "Möchten Sie die ausgewählten Zonen wirklich löschen?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "Es sind noch Kampagnen auf diese Zone verlinkt. Wenn Sie diese jetzt löschen, werden die Kampagnen nicht laufen und Sie erhalten hierfür keine Vergütung.";
$GLOBALS['strZoneType'] = "Zonentyp";
$GLOBALS['strBannerButtonRectangle'] = "Banner, Button oder Rechteck";
$GLOBALS['strInterstitial'] = "Interstitial oder Floating DHTML";
$GLOBALS['strPopup'] = "Popup";
$GLOBALS['strTextAdZone'] = "Textanzeige";
$GLOBALS['strEmailAdZone'] = "E-Mail/Newsletter";
$GLOBALS['strZoneVideoInstream'] = "Inline Video ad";
$GLOBALS['strZoneVideoOverlay'] = "Overlay Video ad";
$GLOBALS['strShowMatchingBanners'] = "Anzeige zugehörende Banner";
$GLOBALS['strHideMatchingBanners'] = "Verbergen zugehörende Banner";
$GLOBALS['strBannerLinkedAds'] = "Mit dieser Zone verknüpfte Werbemittel";
$GLOBALS['strCampaignLinkedAds'] = "Mit dieser Zone verknüpfte Kampagnen";
$GLOBALS['strInactiveZonesHidden'] = "deaktivierte Zone(n) verborgen";
$GLOBALS['strWarnChangeZoneType'] = "Die Änderung der Zone auf EMail/Newsletter entfernt alle verknüpften Banner/Kampagnen aufgrund der folgenden Restriktionenen dieses Zonentyps
<ul>
<li>Text-Zonen können nur mit Text-Bannern verknüpft werden</li>
<li>Kampagnen für EMail-Zonen dürfen jeweils nur einen aktiven Banner haben</li>
</ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Die Änderung der Zonengröße wird die Verknüpfung zu allen Bannern aufheben die nicht der neuen Größe entsprechen und alle Banner aus verknüpften Kampagnen hinzufügen die mit der neuen Größe übereinstimmen.';
$GLOBALS['strWarnChangeBannerSize'] = 'Eine Änderung der Bannergröße hebt die Verlinkung dieses Banners mit allen Zonen auf, die dieser Größe nicht entsprechen. Wenn die <b>Kampagne</b> dieses Banners mit einer Zone der neuen Größe verlinkt ist, ist dieser Banner automatisch mit verlinkt.';
$GLOBALS['strWarnBannerReadonly'] = 'Dieser Banner kann nicht geändert werden da eine nötige Erweiterung deaktiviert wurde. Bitte kontaktieren Sie Ihren Administrator für weitere Informationen.';
$GLOBALS['strZonesOfWebsite'] = 'in'; //this is added between page name and website name eg. 'Zones in www.example.com'
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
$GLOBALS['strAdvanced'] = "Erweiterte Merkmale";
$GLOBALS['strChainSettings'] = "Verkettungseinstellungen";
$GLOBALS['strZoneNoDelivery'] = "Wenn kein Banner dieser Zone <br />ausgeliefert werden kann, dann...";
$GLOBALS['strZoneStopDelivery'] = "stoppe die Werbemittelauslieferung und zeige kein Werbemittel an.";
$GLOBALS['strZoneOtherZone'] = "zeige statt dessen die Werbemittel der unten gewählten Zone an.";
$GLOBALS['strZoneAppend'] = "Immer diesen HTML-Code den Bannern aus dieser Zone anhängen ";
$GLOBALS['strAppendSettings'] = "HTML-Ergänzungen (Anhängen und Voranstellen)";
$GLOBALS['strZonePrependHTML'] = "Immer diesen HTML-Code den Testanzeigen aus dieser Zone voranstellen ";
$GLOBALS['strZoneAppendNoBanner'] = "Hinzufügen, auch wenn kein Banner ausgeliefert wird";
$GLOBALS['strZoneAppendHTMLCode'] = "HTML-Code";
$GLOBALS['strZoneAppendZoneSelection'] = "Pop-Up oder Interstitial";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "Die Banner dieser Zone(n) sind nicht aktiv. Die Zonen sind miteinander verkettet.<br />Die Verkettung ist (von links nach rechts):";
$GLOBALS['strZoneProbNullPri'] = "Alle Banner dieser Zone sind nicht aktiv";
$GLOBALS['strZoneProbListChainLoop'] = "Die Verkettung dieser Zone(n) ist eine Endlosschleife. Die Bannerauslieferung ist angehalten ";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Einbindungsmöglichkeiten für Banner ";
$GLOBALS['strLinkedBanners'] = "Werbemittel individuell verlinken";
$GLOBALS['strCampaignDefaults'] = "Werbemittel aufgrund zugehöriger Kampagne verlinken";
$GLOBALS['strLinkedCategories'] = "Werbemittel nach Kategorien verlinken";
$GLOBALS['strWithXBanners'] = "%d Banner";
$GLOBALS['strRawQueryString'] = "Schlüsselwort";
$GLOBALS['strIncludedBanners'] = "Verknüpfte Banner";
$GLOBALS['strMatchingBanners'] = "{count} zugehörende Banner";
$GLOBALS['strNoCampaignsToLink'] = "Es sind keine Kampagnen vorhanden, die mit dieser Zone verknüpft werden können";
$GLOBALS['strNoTrackersToLink'] = "Zur Zeit sind keine Tracker vorhanden, die mit dieser Kampagne verknüpft werden können.";
$GLOBALS['strNoZonesToLinkToCampaign'] = "Es sind keine Zonen vorhanden, die mit dieser Kampagne verknüpft werden können";
$GLOBALS['strSelectBannerToLink'] = "Wählen Sie einen Banner, der dieser Zone zugeordnet werden soll:";
$GLOBALS['strSelectCampaignToLink'] = "Wählen Sie eine Kampagne, die dieser Zone zugeordnet werden soll:";
$GLOBALS['strSelectAdvertiser'] = "Werbetreibenden auswählen";
$GLOBALS['strSelectPlacement'] = "Kampagne auswählen";
$GLOBALS['strSelectAd'] = "Werbemittel auswählen";
$GLOBALS['strSelectPublisher'] = "Webseite auswählen";
$GLOBALS['strSelectZone'] = "Zone auswählen";
$GLOBALS['strStatusPending'] = "wartet auf Überprüfung";
$GLOBALS['strStatusApproved'] = "Freigegeben";
$GLOBALS['strStatusDisapproved'] = "Abgelehnt";
$GLOBALS['strStatusDuplicate'] = "Kopieren";
$GLOBALS['strStatusOnHold'] = "On Hold";
$GLOBALS['strStatusIgnore'] = "Ignore";
$GLOBALS['strConnectionType'] = "Art";
$GLOBALS['strConnTypeSale'] = "Sale";
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Signup";
$GLOBALS['strShortcutEditStatuses'] = "Status bearbeiten";
$GLOBALS['strShortcutShowStatuses'] = "Status anzeigen";

// Statistics
$GLOBALS['strStats'] = "Statistiken";
$GLOBALS['strNoStats'] = "Zur Zeit sind keine Statistiken vorhanden";
$GLOBALS['strNoStatsForPeriod'] = "Es sind derzeit keine Statistiken für den Zeitraum %s bis %s vorhanden";
$GLOBALS['strGlobalHistory'] = "Global Statistics";
$GLOBALS['strDailyHistory'] = "Daily Statistics";
$GLOBALS['strDailyStats'] = "Daily Statistics";
$GLOBALS['strWeeklyHistory'] = "Weekly Statistics";
$GLOBALS['strMonthlyHistory'] = "Monthly Statistics";
$GLOBALS['strTotalThisPeriod'] = "Summe in der Periode";
$GLOBALS['strPublisherDistribution'] = "Verteilung auf die Webseiten";
$GLOBALS['strCampaignDistribution'] = "Verteilung auf die Kampagnen";
$GLOBALS['strViewBreakdown'] = "Nach Views";
$GLOBALS['strBreakdownByDay'] = "Tag";
$GLOBALS['strBreakdownByWeek'] = "Woche";
$GLOBALS['strBreakdownByMonth'] = "Monat";
$GLOBALS['strBreakdownByDow'] = "Wochentag";
$GLOBALS['strBreakdownByHour'] = "Stunde";
$GLOBALS['strItemsPerPage'] = "Anzeigen pro Seite";
$GLOBALS['strDistributionHistoryCampaign'] = "Distribution Statistics (Campaign)";
$GLOBALS['strDistributionHistoryBanner'] = "Distribution Statistics (Banner)";
$GLOBALS['strDistributionHistoryWebsite'] = "Distribution Statistics (Website)";
$GLOBALS['strDistributionHistoryZone'] = "Distribution Statistics (Zone)";
$GLOBALS['strShowGraphOfStatistics'] = "Statistiken <u>g</u>raphisch darstellen";
$GLOBALS['strExportStatisticsToExcel'] = "Statistiken nach Excel <u>e</u>xportieren";
$GLOBALS['strGDnotEnabled'] = "Um grafische Statistiken anzeigen zu können, muss in PHP die GD Erweiterung aktiviert sein. <br />Bitte schauen Sie bei <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> für weitere Informationen.";
$GLOBALS['strStatsArea'] = "Bereich";

// Expiration
$GLOBALS['strNoExpiration'] = "Kein Auslaufdatum festgelegt";
$GLOBALS['strEstimated'] = "Voraussichtliches Auslaufdatum";
$GLOBALS['strNoExpirationEstimation'] = "Noch kein Ablaufen abgeschätzt";
$GLOBALS['strDaysAgo'] = "Tage her";
$GLOBALS['strCampaignStop'] = "Kampagnen Ende";

// Reports
$GLOBALS['strAdvancedReports'] = "Erweiterte Berichte";
$GLOBALS['strStartDate'] = "Start Date";
$GLOBALS['strEndDate'] = "End Date";
$GLOBALS['strPeriod'] = "Zeitraum";
$GLOBALS['strLimitations'] = "Delivery Rules";
$GLOBALS['strWorksheets'] = "Worksheets";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "Alle Werbetreibende";
$GLOBALS['strAnonAdvertisers'] = "Deaktivierte Werbetreibende";
$GLOBALS['strAllPublishers'] = "Alle Webseiten";
$GLOBALS['strAnonPublishers'] = "Anonyme Webseiten";
$GLOBALS['strAllAvailZones'] = "Alle verfügbaren Zonen";

// Userlog
$GLOBALS['strUserLog'] = "Benutzerprotokoll";
$GLOBALS['strUserLogDetails'] = "Details Benutzerprotokoll";
$GLOBALS['strDeleteLog'] = "Protokoll löschen";
$GLOBALS['strAction'] = "Aktion";
$GLOBALS['strNoActionsLogged'] = "Keine Aktionen protokolliert";

// Code generation
$GLOBALS['strGenerateBannercode'] = "Bannercode erstellen";
$GLOBALS['strChooseInvocationType'] = "Bitte wählen Sie die Auslieferungsart für die Werbemittel";
$GLOBALS['strGenerate'] = "Generiere";
$GLOBALS['strParameters'] = "Einstellungen: Parameter";
$GLOBALS['strFrameSize'] = "Fenstergröße";
$GLOBALS['strBannercode'] = "Bannercode";
$GLOBALS['strTrackercode'] = "Den folgenden Javascript-Code an jede Tracker-Impression anhängen";
$GLOBALS['strBackToTheList'] = "Zurück zur Berichtsliste";
$GLOBALS['strCharset'] = "Zeichensatz";
$GLOBALS['strAutoDetect'] = "automatisch herausfinden";
$GLOBALS['strCacheBusterComment'] = "  * Ersetzen Sie alle Vorkommen von {random} mit
  * einem generierten Zufallswert (oder Zeitstempel).
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
$GLOBALS['strErrorDatabaseConnection'] = "Datenbankverbindungsfehler.";
$GLOBALS['strErrorCantConnectToDatabase'] = "A fatal error occurred %1\$s can't connect to the database. Because
                                                   of this it isn't possible to use the administrator interface. The delivery
                                                   of banners might also be affected. Possible reasons for the problem are:
                                                   <ul>
                                                     <li>The database server isn't functioning at the moment</li>
                                                     <li>The location of the database server has changed</li>
                                                     <li>The username or password used to contact the database server are not correct</li>
                                                     <li>PHP has not loaded the <i>%2\$s</i> extension</li>
                                                   </ul>";
$GLOBALS['strNoMatchesFound'] = "Kein Objekt gefunden";
$GLOBALS['strErrorOccurred'] = "Ein Fehler ist aufgetreten";
$GLOBALS['strErrorDBPlain'] = "Beim Zugriff auf die Datenbank ist ein Fehler aufgetreten ";
$GLOBALS['strErrorDBSerious'] = "Ein schwerwiegendes Problem mit der Datenbank wurde erkannt";
$GLOBALS['strErrorDBNoDataPlain'] = "Aufgrund eines Fehlers mit der Datenbank konnte {$PRODUCT_NAME} weder aus der Datenbank lesen noch in sie schreiben. ";
$GLOBALS['strErrorDBNoDataSerious'] = "Due to a serious problem with the database, {$PRODUCT_NAME} couldn't retrieve data";
$GLOBALS['strErrorDBCorrupt'] = "Die Datenbanktabelle ist wahrscheinlich zerstört und mu&szlig wiederhergestellt werden. Informationen über die Wiederherstellung zerstörter Tabellen finden sich im Handbuch.";
$GLOBALS['strErrorDBContact'] = "Bitte nehmen Sie Kontakt mit dem Systemverwalter Ihres Servers auf und schildern Sie ihm das Problem. Nur er kann helfen.";
$GLOBALS['strErrorDBSubmitBug'] = "If this problem is reproducable it might be caused by a bug in {$PRODUCT_NAME}. Please report the following information to the creators of {$PRODUCT_NAME}. Also try to describe the actions that led to this error as clearly as possible.";
$GLOBALS['strMaintenanceNotActive'] = "The maintenance script has not been run in the last 24 hours.
In order for the application to function correctly it needs to run
every hour.

Please read the Administrator guide for more information
about configuring the maintenance script.";
$GLOBALS['strErrorLinkingBanner'] = "Es gab Fehler bei der Verknüpfung von Bannern mit Zonen:";
$GLOBALS['strUnableToLinkBanner'] = "Folgende Verknüpfung(en) sind fehlgeschlagen: ";
$GLOBALS['strErrorEditingCampaignRevenue'] = "Ungültiges Zahlenformat im Feld Umsatzinformationen";
$GLOBALS['strErrorEditingCampaignECPM'] = "incorrect number format in ECPM Information field";
$GLOBALS['strErrorEditingZone'] = "Fehler beim Update der Zone:";
$GLOBALS['strUnableToChangeZone'] = "Diese Änderung ist unwirksam weil:";
$GLOBALS['strDatesConflict'] = "Datumskonflikt mit:";
$GLOBALS['strEmailNoDates'] = "Campaigns linked to Email Zones must have a start and end date set. {$PRODUCT_NAME} ensures that on a given date, only one active banner is linked to an Email Zone. Please ensure that the campaigns already linked to the zone do not have overlapping dates with the campaign you are trying to link.";
$GLOBALS['strWarningInaccurateStats'] = "Einige der Statistikdaten sind nicht in der UTC-Zeitzone erfasst worden. Diese werden möglicherweise nicht in der richtigen Zeitzone dargestellt.";
$GLOBALS['strWarningInaccurateReadMore'] = "Lesen Sie mehr hierüber";
$GLOBALS['strWarningInaccurateReport'] = "Einige der Statistikdaten dieses Berichts sind nicht in der UTC-Zeitzone erfasst worden. Diese werden möglicherweise nicht in der richtigen Zeitzone dargestellt.";

//Validation
$GLOBALS['strRequiredFieldLegend'] = "bezeichnet ein erforderliches Feld";
$GLOBALS['strFormContainsErrors'] = "Die Eingabe enthält Fehler, bitte berichtigen Sie die unten markierten Eingabefelder.";
$GLOBALS['strXRequiredField'] = "%s ist erforderlich";
$GLOBALS['strEmailField'] = "Bitte geben Sie eine gültige E-Mail Adresse ein";
$GLOBALS['strNumericField'] = "Bitte geben Sie einen numerischen Wert ein (nur Ziffern sind erlaubt)";
$GLOBALS['strGreaterThanZeroField'] = "Muß größer als 0 sein";
$GLOBALS['strXGreaterThanZeroField'] = "%s muß größer als 0 sein";
$GLOBALS['strXPositiveWholeNumberField'] = "%s muß eine positive ganze Zahl sein";
$GLOBALS['strInvalidWebsiteURL'] = "Ungültige Webseiten-URL";

// Email
$GLOBALS['strSirMadam'] = "Sehr geehrte Damen und Herren";
$GLOBALS['strMailSubject'] = "Bericht für Werbetreibende";
$GLOBALS['strMailHeader'] = "Sehr geehrte(r) {contact},";
$GLOBALS['strMailBannerStats'] = "Sie erhalten nachfolgend die Bannerstatistik für {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Kampagne aktiviert";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Kampagne deaktiviert";
$GLOBALS['strMailBannerActivated'] = "Your campaign shown below has been activated because
the campaign activation date has been reached.";
$GLOBALS['strMailBannerDeactivated'] = "Die unten angegebene Kampagne wurde deaktiviert, weil";
$GLOBALS['strMailFooter'] = "Mit freundlichem Gruß
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "Diese Kampagne ist zur Zeit nicht aktiv, weil";
$GLOBALS['strBeforeActivate'] = "das Aktivierungsdatum noch nicht erreicht wurde ";
$GLOBALS['strAfterExpire'] = "das Auslaufdatum erreicht wurde ";
$GLOBALS['strNoMoreImpressions'] = "Alle gebuchten Impressions sind aufgebraucht";
$GLOBALS['strNoMoreClicks'] = "Alle gebuchten Klicks sind aufgebraucht";
$GLOBALS['strNoMoreConversions'] = "Alle gebuchten Konversionen sind aufgebraucht";
$GLOBALS['strWeightIsNull'] = "die Gewichtung auf 0 (Null) gesetzt wurde.";
$GLOBALS['strRevenueIsNull'] = "its revenue is set to zero";
$GLOBALS['strTargetIsNull'] = "das Tageslimit ist auf null gesetzt - Sie müssen entweder ein Enddatum und eine Wert oder ein Tageslimit erfassen";
$GLOBALS['strNoViewLoggedInInterval'] = "Für den Berichtszeitraum wurden keine AdViews protokolliert";
$GLOBALS['strNoClickLoggedInInterval'] = "Für den Berichtszeitraum wurden keine AdClicks protokolliert";
$GLOBALS['strNoConversionLoggedInInterval'] = "Im Berichtsintervall fanden keine Konversionen statt.";
$GLOBALS['strMailReportPeriod'] = "Die Statistiken in diesem Bericht sind für den Zeitraum von {startdate} bis {enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "Der Bericht enthält alle Statistiken bis {enddate}.";
$GLOBALS['strNoStatsForCampaign'] = "Für die Kampagne liegen keine Statistiken vor ";
$GLOBALS['strImpendingCampaignExpiry'] = "Bevorstehende Deaktivierung der Kampagne";
$GLOBALS['strYourCampaign'] = "Ihre Kampagne";
$GLOBALS['strTheCampiaignBelongingTo'] = "Die Kampagne gehörend zu";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "Unten angegebene {clientname} wird am {date} auslaufen.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "Unten angegebene {clientname} hat weniger als {limit} Impressions übrig.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "Auf Grund dessen wird die Kampagne bald deaktiviert und weiter unten angegebene Banner aus dieser Kampagne werden deaktiviert:";

// Priority
$GLOBALS['strPriority'] = "Priorität";
$GLOBALS['strSourceEdit'] = "Quellcode editieren";

// Preferences
$GLOBALS['strPreferences'] = "Präferenz";
$GLOBALS['strUserPreferences'] = "Voreinstellungen Benutzer";
$GLOBALS['strChangePassword'] = "Passwort ändern";
$GLOBALS['strChangeEmail'] = "E-Mail Adresse ändern";
$GLOBALS['strCurrentPassword'] = "Aktuelles Passwort";
$GLOBALS['strChooseNewPassword'] = "Wählen Sie ein neues Passwort";
$GLOBALS['strReenterNewPassword'] = "Wiederholung des Passwort";
$GLOBALS['strNameLanguage'] = "Name & Sprache";
$GLOBALS['strAccountPreferences'] = "Voreinstellungen für dieses Benutzerkonto";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Voreinstellungen Kampagnen E-Mail Berichte";
$GLOBALS['strTimezonePreferences'] = "Voreinstellung Zeitzone";
$GLOBALS['strAdminEmailWarnings'] = "E-Mail-Warnungen des Administrators";
$GLOBALS['strAgencyEmailWarnings'] = "E-Mail-Warnungen der Agenturen";
$GLOBALS['strAdveEmailWarnings'] = "E-Mail-Warnungen der Werbetreibenden";
$GLOBALS['strFullName'] = "Vor- und Nachname";
$GLOBALS['strEmailAddress'] = "Email address";
$GLOBALS['strUserDetails'] = "Benutzerdetails";
$GLOBALS['strUserInterfacePreferences'] = "Voreinstellungen Benutzeroberfläche";
$GLOBALS['strPluginPreferences'] = "Plugin Voreinstellungen";
$GLOBALS['strColumnName'] = "Spaltenname";
$GLOBALS['strShowColumn'] = "Spalte zeigen";
$GLOBALS['strCustomColumnName'] = "Eigener Spaltenname";
$GLOBALS['strColumnRank'] = "Reihenfolge der Spalten";

// Long names
$GLOBALS['strRevenue'] = "Einkommen";
$GLOBALS['strNumberOfItems'] = "Anzahl der Einträge";
$GLOBALS['strRevenueCPC'] = "Einkommen CPC";
$GLOBALS['strERPM'] = "ERPM";
$GLOBALS['strERPC'] = "ERPC";
$GLOBALS['strERPS'] = "ERPS";
$GLOBALS['strEIPM'] = "EIPM";
$GLOBALS['strEIPC'] = "EIPC";
$GLOBALS['strEIPS'] = "EIPS";
$GLOBALS['strECPM'] = "ECPM";
$GLOBALS['strECPC'] = "ECPC";
$GLOBALS['strECPS'] = "ECPS";
$GLOBALS['strPendingConversions'] = "schwebende Konversionen";
$GLOBALS['strImpressionSR'] = "Impression SR";
$GLOBALS['strClickSR'] = "Klick Rate";

// Short names
$GLOBALS['strRevenue_short'] = "Eink.";
$GLOBALS['strBasketValue_short'] = "WW";
$GLOBALS['strNumberOfItems_short'] = "Anzahl";
$GLOBALS['strRevenueCPC_short'] = "Eink. CPC";
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
$GLOBALS['strRequests_short'] = "Zugr.";
$GLOBALS['strImpressions_short'] = "Impr.";
$GLOBALS['strClicks_short'] = "Klicks";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "Konv.";
$GLOBALS['strPendingConversions_short'] = "schweb.Konv.";
$GLOBALS['strImpressionSR_short'] = "Impr. SR";
$GLOBALS['strClickSR_short'] = "Klick Rate";

// Global Settings
$GLOBALS['strConfiguration'] = "Konfiguration";
$GLOBALS['strGlobalSettings'] = "Grundeinstellungen des Systems";
$GLOBALS['strGeneralSettings'] = "Allgemeine Einstellungen";
$GLOBALS['strMainSettings'] = "Haupteinstellungen";
$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strChooseSection'] = 'Choose Section';

// Product Updates
$GLOBALS['strProductUpdates'] = "Produkt-Update";
$GLOBALS['strViewPastUpdates'] = "Vergangene Updates und Backups anzeigen";
$GLOBALS['strFromVersion'] = "Von Version";
$GLOBALS['strToVersion'] = "Nach Version";
$GLOBALS['strToggleDataBackupDetails'] = "Details zur Datensicherung";
$GLOBALS['strClickViewBackupDetails'] = "Hier klicken um die Sicherungsdetails anzuzeigen";
$GLOBALS['strClickHideBackupDetails'] = "Hier klicken zum Verbergen der Sicherungsdetails";
$GLOBALS['strShowBackupDetails'] = "Datensicherungsdetails zeigen";
$GLOBALS['strHideBackupDetails'] = "Datensicherungsdetails verbergen";
$GLOBALS['strBackupDeleteConfirm'] = "Wollen Sie wirklich alle während des Upgrades erstellten Sicherungen entfernen?";
$GLOBALS['strDeleteArtifacts'] = "Restbestandteil löschen";
$GLOBALS['strArtifacts'] = "Restbestandteil";
$GLOBALS['strBackupDbTables'] = "Sicherung der Datenbanktabellen";
$GLOBALS['strLogFiles'] = "Logfiles";
$GLOBALS['strConfigBackups'] = "Sicherung der Konfigurationsdatei";
$GLOBALS['strUpdatedDbVersionStamp'] = "Kennzeichnung der Datenbankversion geändert";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "UPGRADE ABGESCHLOSSEN";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "UPGRADE FEHLGESCHLAGEN";

// Agency
$GLOBALS['strAgencyManagement'] = "Bearbeiten der Benutzerkonten";
$GLOBALS['strAgency'] = "Benutzerkonto";
$GLOBALS['strAddAgency'] = "Benutzerkonto hinzufügen";
$GLOBALS['strAddAgency_Key'] = "<u>N</u>eues Benutzerkonto hinzufügen";
$GLOBALS['strTotalAgencies'] = "Gesamtzahl Benutzerkonten";
$GLOBALS['strAgencyProperties'] = "Merkmale Benutzerkonto";
$GLOBALS['strNoAgencies'] = "Zur Zeit sind keine Benutzerkonten angelegt.";
$GLOBALS['strConfirmDeleteAgency'] = "Soll dieses Benutzerkonto tatsächlich gelöscht werden?";
$GLOBALS['strHideInactiveAgencies'] = "deaktivierte Benutzerkonten ausblenden";
$GLOBALS['strInactiveAgenciesHidden'] = "deaktivierte Benutzerkonten verborgen";
$GLOBALS['strSwitchAccount'] = "Zu diesem Benutzerzugang wechseln";

// Channels
$GLOBALS['strChannel'] = "Delivery Rule Set";
$GLOBALS['strChannels'] = "Delivery Rule Sets";
$GLOBALS['strChannelManagement'] = "Delivery Rule Set Management";
$GLOBALS['strAddNewChannel'] = "Add new Delivery Rule Set";
$GLOBALS['strAddNewChannel_Key'] = "Add <u>n</u>ew Delivery Rule Set";
$GLOBALS['strChannelToWebsite'] = "zur Webseite";
$GLOBALS['strNoChannels'] = "There are currently no delivery rule sets defined";
$GLOBALS['strNoChannelsAddWebsite'] = "There are currently no delivery rule sets defined, because there are no websites. To create a delivery rule set, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strEditChannelLimitations'] = "Edit delivery rules for the delivery rule set";
$GLOBALS['strChannelProperties'] = "Delivery Rule Set Properties";
$GLOBALS['strChannelLimitations'] = "Auslieferungsoptionen";
$GLOBALS['strConfirmDeleteChannel'] = "Do you really want to delete this delivery rule set?";
$GLOBALS['strConfirmDeleteChannels'] = "Do you really want to delete the selected delivery rule sets?";
$GLOBALS['strChannelsOfWebsite'] = 'in'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "Variablenname";
$GLOBALS['strVariableDescription'] = "Beschreibung";
$GLOBALS['strVariableDataType'] = "Datentyp";
$GLOBALS['strVariablePurpose'] = "Grund";
$GLOBALS['strGeneric'] = "Generisch";
$GLOBALS['strBasketValue'] = "Warenkorb Wert";
$GLOBALS['strNumItems'] = "Anzahl der Einträge";
$GLOBALS['strVariableIsUnique'] = "Konversionen doublettenbereingt?";
$GLOBALS['strNumber'] = "Zahl";
$GLOBALS['strString'] = "Zeichenkette";
$GLOBALS['strTrackFollowingVars'] = "Die folgende Variable tracken";
$GLOBALS['strAddVariable'] = "Variable hinzufügen";
$GLOBALS['strNoVarsToTrack'] = "Zur Zeit gibt es keine trackbaren Variablen.";
$GLOBALS['strVariableRejectEmpty'] = "Wenn leer, ablehnen?";
$GLOBALS['strTrackingSettings'] = "Tracking Einstellungen";
$GLOBALS['strTrackerType'] = "Tracker Art";
$GLOBALS['strTrackerTypeJS'] = "Tracke JavaScript Variablen";
$GLOBALS['strTrackerTypeDefault'] = "Tracke JavaScript Variablen (abwärtskompatibel, Escape erforderlich)";
$GLOBALS['strTrackerTypeDOM'] = "Tracke HTML Elemente mittels DOM";
$GLOBALS['strTrackerTypeCustom'] = "Eigener JS code";
$GLOBALS['strVariableCode'] = "Javascript tracking code";

// Password recovery
$GLOBALS['strForgotPassword'] = "Passwort vergessen?";
$GLOBALS['strPasswordRecovery'] = "Password wiederherstellen";
$GLOBALS['strEmailRequired'] = "Das Eingabefeld e-Mail muss ausgefüllt sein";
$GLOBALS['strPwdRecWrongId'] = "Falsche ID";
$GLOBALS['strPwdRecEnterEmail'] = "Geben Sie nachfolgend Ihre eMail Adresse ein";
$GLOBALS['strPwdRecEnterPassword'] = "Geben Sie nachfolgend Ihr neues Passwort ein";
$GLOBALS['strPwdRecResetLink'] = "Link zum Passwort zurücksetzen";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "%s Passwort wiederherstellen";
$GLOBALS['strProceed'] = "Weiter >";
$GLOBALS['strNotifyPageMessage'] = "Ihnen wurde ein Link zum Zurücksetzen des Passworts per E-Mail zugeschickt, bitte warten Sie einige Minuten auf die Zustellung.<br />Sollte die E-Mail nicht eintreffen, überprüfen Sie bitte auch Ihren Spam-Ordner.<br /><a href='index.php'>Zurück zur Login-Seite.</a>";

// Audit
$GLOBALS['strAdditionalItems'] = "und weitere Einträge";
$GLOBALS['strFor'] = "für";
$GLOBALS['strHas'] = "hat";
$GLOBALS['strBinaryData'] = "Binäre Daten";
$GLOBALS['strAuditTrailDisabled'] = "Das Prüfprotokoll wurde vom Administrator deaktiviert. Es werden keine weiteren Ereignisse protokolliert.";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "Es wurde keine Benutzeraktivität innerhalb des ausgewählen Zeitrahmens protokolliert.";
$GLOBALS['strAuditTrail'] = "Prüfprotokoll";
$GLOBALS['strAuditTrailSetup'] = "Heute das Prüfprotokoll einrichten";
$GLOBALS['strAuditTrailGoTo'] = "Gehe zur Prüfprotokollseite";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Audit Trail allows you to see who did what and when. Or to put it another way, it keeps track of system changes within {$PRODUCT_NAME}</li>
        <li>You are seeing this message, because you have not activated the Audit Trail</li>
        <li>Interested in learning more? Read the <a href='{$PRODUCT_DOCSURL}/admin/settings/auditTrail' class='site-link' target='help' >Audit Trail documentation</a></li>";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Gehe zur Kampagne";
$GLOBALS['strCampaignSetUp'] = "Heute eine Kampagne einrichten";
$GLOBALS['strCampaignNoRecords'] = "<li>Campaigns let you group together any number of banner ads, of any size, that share common advertising requirements</li>
        <li>Save time by grouping banners within a campaign and no longer define delivery settings for each ad separately</li>
        <li>Check out the <a class='site-link' target='help' href='{$PRODUCT_DOCSURL}/user/inventory/advertisersAndCampaigns/campaigns'>Campaign documentation</a>!</li>";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>Es gibt keine Ereignisse zu den Kampagnen anzuzeigen.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "In dem angegebenen Zeitraum wurde keine Kampagne gestartet oder beendet.";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>In order to view campaigns which have started or finished during the timeframe you have selected, the Audit Trail must be activated</li>
        <li>You are seeing this message because you didn't activate the Audit Trail</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Aktivieren Sie das Prüfprotokoll um Kampagnen anzuzeigen";

$GLOBALS['strUnsavedChanges'] = "Sie haben noch ungesicherte Änderungen auf dieser Seite. Nur wenn Sie am Ende \"Speichern\" klicken werden diese Änderungen übernommen";
$GLOBALS['strDeliveryLimitationsDisagree'] = "WARNING: The cached delivery rules <strong>DO NOT AGREE</strong> with the delivery rules shown below<br />Please hit save changes to update the cached delivery rules";
$GLOBALS['strDeliveryRulesDbError'] = "WARNING: When saving the delivery rules, a database error occured. Please check the delivery rules below carefully, and update, if required.";
$GLOBALS['strDeliveryRulesTruncation'] = "WARNING: When saving the delivery rules, MySQL truncated the data, so the original values were restored. Please reduce your rule size, and try again.";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Some delivery rules report incorrect values:";

//confirmation messages
$GLOBALS['strYouAreNowWorkingAsX'] = "Sie arbeiten nun als <b>%s</b>";
$GLOBALS['strYouDontHaveAccess'] = "Sie haben keine Zugangsrechte für die Seite. Der Browser wurde umgeleitet.";

$GLOBALS['strAdvertiserHasBeenAdded'] = "Der Werbetreibende <a href='%s'>%s</a> wurde angelegt, <a href='%s'>jetzt eine Kampagne erstellen</a>";
$GLOBALS['strAdvertiserHasBeenUpdated'] = "Der Werbetreibende <a href='%s'>%s</a> wurde geändert";
$GLOBALS['strAdvertiserHasBeenDeleted'] = "Der Werbetreibende <b>%s</b> wurde gelöscht";
$GLOBALS['strAdvertisersHaveBeenDeleted'] = "Alle ausgewählten Werbetreibenden wurden gelöscht";

$GLOBALS['strTrackerHasBeenAdded'] = "Der Tracker <a href='%s'>%s</a> wurde hinzugefügt";
$GLOBALS['strTrackerHasBeenUpdated'] = "Der Tracker <a href='%s'>%s</a> wurde geändert";
$GLOBALS['strTrackerVarsHaveBeenUpdated'] = "Die Trackervariablen <a href='%s'>%s</a> wurden geändert";
$GLOBALS['strTrackerCampaignsHaveBeenUpdated'] = "Die verlinkten Kampagnen des Trackers <a href='%s'>%s</a> wurden geändert";
$GLOBALS['strTrackerAppendHasBeenUpdated'] = "Der dem Tracker <a href='%s'>%s</a> angehängte Code wurde geändert";
$GLOBALS['strTrackerHasBeenDeleted'] = "Der Tracker <b>%s</b> wurde gelöscht";
$GLOBALS['strTrackersHaveBeenDeleted'] = "Alle ausgewählten Tracker wurden gelöscht";
$GLOBALS['strTrackerHasBeenDuplicated'] = "Der Tracker <a href='%s'>%s</a> wurde nach <a href='%s'>%s</a> kopiert";
$GLOBALS['strTrackerHasBeenMoved'] = "Der Tracker <b>%s</b> wurde zu dem Werbetreibenden <b>%s</b> verschoben";

$GLOBALS['strCampaignHasBeenAdded'] = "Die Kampagne <a href='%s'>%s</a> wurde angelegt, <a href='%s'>jetzt einen Banner erstellen</a>";
$GLOBALS['strCampaignHasBeenUpdated'] = "Die Kampagne <a href='%s'>%s</a> wurde geändert";
$GLOBALS['strCampaignTrackersHaveBeenUpdated'] = "Mit der Kampagne <a href='%s'>%s</a> verlinkte Tracker wurden geändert";
$GLOBALS['strCampaignHasBeenDeleted'] = "Die Kampagne <b>%s</b> wurde gelöscht";
$GLOBALS['strCampaignsHaveBeenDeleted'] = "Alle ausgewählten Kampagnen wurden gelöscht";
$GLOBALS['strCampaignHasBeenDuplicated'] = "Die Kampagne <a href='%s'>%s</a> wurde nach <a href='%s'>%s</a> kopiert";
$GLOBALS['strCampaignHasBeenMoved'] = "Die Kampagne <b>%s</b> wurde zu dem Werbetreibenden <b>%s</b> verschoben";

$GLOBALS['strBannerHasBeenAdded'] = "Der Banner <a href='%s'>%s</a> wurde hinzugefügt";
$GLOBALS['strBannerHasBeenUpdated'] = "Der Banner <a href='%s'>%s</a> wurde geändert";
$GLOBALS['strBannerAdvancedHasBeenUpdated'] = "Die erweiterten Einstellungen des Banners <a href='%s'>%s</a> wurden geändert";
$GLOBALS['strBannerAclHasBeenUpdated'] = "Die Auslieferungsoptionen des Banners <a href='%s'>%s</a> wurden geändert";
$GLOBALS['strBannerAclHasBeenAppliedTo'] = "Delivery options for banner <a href='%s'>%s</a> have been applied to %d banners";
$GLOBALS['strBannerHasBeenDeleted'] = "Der Banner <b>%s</b> wurde gelöscht";
$GLOBALS['strBannersHaveBeenDeleted'] = "Alle ausgewählten Banner wurden gelöscht";
$GLOBALS['strBannerHasBeenDuplicated'] = "Der Banner <a href='%s'>%s</a> wurde nach <a href='%s'>%s</a> kopiert";
$GLOBALS['strBannerHasBeenMoved'] = "Der Banner <b>%s</b> wurde in die Kampagne <b>%s</b> verschoben";
$GLOBALS['strBannerHasBeenActivated'] = "Der Banner <a href='%s'>%s</a> wurde aktiviert";
$GLOBALS['strBannerHasBeenDeactivated'] = "Der Banner <a href='%s'>%s</a> wurde deaktiviert";

$GLOBALS['strXZonesLinked'] = "<b>%s</b> Zone(n) verlinkt";
$GLOBALS['strXZonesUnlinked'] = "<b>%s</b> Zonenverlinkungen aufgehoben";

$GLOBALS['strWebsiteHasBeenAdded'] = "Die Webseite <a href='%s'>%s</a> wurde angelegt, <a href='%s'>jetzt eine Zone erstellen</a>";
$GLOBALS['strWebsiteHasBeenUpdated'] = "Die Webseite <a href='%s'>%s</a> wurde geändert";
$GLOBALS['strWebsiteHasBeenDeleted'] = "Die Webseite <b>%s</b> wurde gelöscht";
$GLOBALS['strWebsitesHaveBeenDeleted'] = "Alle ausgewählten Webseiten wurden gelöscht";
$GLOBALS['strWebsiteHasBeenDuplicated'] = "Die Webseite <a href='%s'>%s</a> wurde nach <a href='%s'>%s</a> kopiert";

$GLOBALS['strZoneHasBeenAdded'] = "Die Zone <a href='%s'>%s</a> wurde hinzugefügt";
$GLOBALS['strZoneHasBeenUpdated'] = "Die Zone <a href='%s'>%s</a> wurde geändert";
$GLOBALS['strZoneAdvancedHasBeenUpdated'] = "Die erweiterten Einstellungen der Zone <a href='%s'>%s</a> wurden geändert";
$GLOBALS['strZoneHasBeenDeleted'] = "Die Zone <b>%s</b> wurde gelöscht";
$GLOBALS['strZonesHaveBeenDeleted'] = "Alle ausgewählten Zonen wurden gelöscht";
$GLOBALS['strZoneHasBeenDuplicated'] = "Die Zone <a href='%s'>%s</a> wurde nach <a href='%s'>%s</a> kopiert";
$GLOBALS['strZoneHasBeenMoved'] = "Die Zone <b>%s</b> wurde zur Webseite <b>%s</b> verschoben";
$GLOBALS['strZoneLinkedBanner'] = "Der Banner wurde mit der Zone <a href='%s'>%s</a> verlinkt";
$GLOBALS['strZoneLinkedCampaign'] = "Die Kampagne wurde mit der Zone <a href='%s'>%s</a> verlinkt";
$GLOBALS['strZoneRemovedBanner'] = "Die Verlinkung des Banners mit der Zone <a href='%s'>%s</a> wurde aufgehoben";
$GLOBALS['strZoneRemovedCampaign'] = "Die Verlinkung der Kampagne mit der Zone <a href='%s'>%s</a> wurde aufgehoben";

$GLOBALS['strChannelHasBeenAdded'] = "Delivery rule set <a href='%s'>%s</a> has been added. <a href='%s'>Set the delivery rules.</a>";
$GLOBALS['strChannelHasBeenUpdated'] = "Delivery rule set <a href='%s'>%s</a> has been updated";
$GLOBALS['strChannelAclHasBeenUpdated'] = "Delivery options for the delivery rule set <a href='%s'>%s</a> have been updated";
$GLOBALS['strChannelHasBeenDeleted'] = "Delivery rule set <b>%s</b> has been deleted";
$GLOBALS['strChannelsHaveBeenDeleted'] = "All selected delivery rule sets have been deleted";
$GLOBALS['strChannelHasBeenDuplicated'] = "Delivery rule set <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";

$GLOBALS['strUserPreferencesUpdated'] = "Ihre Voreinstellungen <b>%s</b> wurden geändert";
$GLOBALS['strEmailChanged'] = "Ihre E-Mail Adresse wurde geändert";
$GLOBALS['strPasswordChanged'] = "Ihr Passwort wurde geändert";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "<b>%s</b> wurde geändert";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "<b>%s</b> wurde geändert";
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
$GLOBALS['keySearch'] = "s";
$GLOBALS['keyCollapseAll'] = "z";
$GLOBALS['keyExpandAll'] = "a";
$GLOBALS['keyAddNew'] = "n";
$GLOBALS['keyNext'] = "w";
$GLOBALS['keyPrevious'] = "z";
$GLOBALS['keyLinkUser'] = "b";
$GLOBALS['keyWorkingAs'] = "w";
