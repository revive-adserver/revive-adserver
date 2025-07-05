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
$GLOBALS['date_format'] = "%d.%m.%Y";
$GLOBALS['minute_format'] = "%H:%M";
$GLOBALS['day_format'] = "%d-%m";

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
$GLOBALS['strAdminstration'] = "Inventar";
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
$GLOBALS['strWhenCheckingForUpdates'] = "Bei der Suche nach neuen Versionen";
$GLOBALS['strCompact'] = "Kompakt";
$GLOBALS['strUser'] = "Benutzer";
$GLOBALS['strDuplicate'] = "Duplizieren";
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
$GLOBALS['strOverrideAds'] = "Überschreibe Kampagnen-Anzeigen";
$GLOBALS['strHighAds'] = "Vertrags-Werbeanzeigen";
$GLOBALS['strECPMAds'] = "eCPM Werbeanzeigen";
$GLOBALS['strLowAds'] = "Verbleibende-Werbeanzeigen";
$GLOBALS['strLimitations'] = "Auslieferungsregeln";
$GLOBALS['strNoLimitations'] = "Keine Auslieferungsregeln";
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
$GLOBALS['strUserLinkedToAccount'] = "Benutzer wurde zum Konto hinzugefügt";
$GLOBALS['strUserLinkedAndWelcomeSent'] = "Benutzer wurde zum Benutzerkonto hinzugefügt. Eine E-Mail mit dem Passwort wurde an den Benutzer gesendet.";
$GLOBALS['strUserAccountUpdated'] = "Benutzerkonto geändert";
$GLOBALS['strUserUnlinkedFromAccount'] = "Benutzer wurde aus dem Benutzerkonto entfernt";
$GLOBALS['strUserWasDeleted'] = "Benutzer wurde gelöscht";
$GLOBALS['strUserNotLinkedWithAccount'] = "Dieser Benutzer ist nicht mit diesem Benutzerkonto verknüpft";
$GLOBALS['strCantDeleteOneAdminUser'] = "Das Löschen des Benutzers ist nicht möglich. Mindestens ein Benutzer muss mit dem Admin-Konto verknüpft sein.";
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
$GLOBALS['strEnableCookies'] = "Sie müssen Cookies im Browser aktivieren bevor die {$PRODUCT_NAME} verwenden können";
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
    $GLOBALS['strDayFullNames'] = [];
}
$GLOBALS['strDayFullNames'][0] = 'Sonntag';
$GLOBALS['strDayFullNames'][1] = 'Montag';
$GLOBALS['strDayFullNames'][2] = 'Dienstag';
$GLOBALS['strDayFullNames'][3] = 'Mittwoch';
$GLOBALS['strDayFullNames'][4] = 'Donnerstag';
$GLOBALS['strDayFullNames'][5] = 'Freitag';
$GLOBALS['strDayFullNames'][6] = 'Samstag';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = [];
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
$GLOBALS['strClientHistory'] = "Statistiken Werbetreibender";
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
$GLOBALS['strAllowCreateAccounts'] = "Erlaube diesem Benutzer die Benutzer des Kontos zu verwalten";
$GLOBALS['strAdvertiserLimitation'] = "Nur ein einziges Banner von diesem Werbetreibenden auf einer Webseite anzeigen";
$GLOBALS['strAllowAuditTrailAccess'] = "Diesem Benutzer die Ansicht des Prüfprotokolls erlauben";
$GLOBALS['strAllowDeleteItems'] = "Erlaube diesem Benutzer Einträge zu löschen";

// Campaign
$GLOBALS['strCampaign'] = "Kampagne";
$GLOBALS['strCampaigns'] = "Kampagnen";
$GLOBALS['strAddCampaign'] = "Neue Kampagnen hinzufügen";
$GLOBALS['strAddCampaign_Key'] = "<u>N</u>eue Kampagnen hinzufügen";
$GLOBALS['strCampaignForAdvertiser'] = "für Werbetreibende";
$GLOBALS['strLinkedCampaigns'] = "Verknüpfte Kampagnen";
$GLOBALS['strCampaignProperties'] = "Merkmale Kampagnen";
$GLOBALS['strCampaignOverview'] = "Übersicht Kampagnen";
$GLOBALS['strCampaignHistory'] = "Statistiken Kampagnen";
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
$GLOBALS['strHiddenZone'] = "Zone";
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
$GLOBALS['strCampaignWarningOverrideNoWeight'] = "Der Typ dieser Kampagne ist auf Überschreiben gesetzt,
aber die Gewichtung ist auf 0 gesetzt oder 
nicht festgelegt. Dies führt dazu, dass die 
Kampagne deaktiviert wird und ihre Anzeigen 
nicht ausgeliefert werden bis die Gewichtung
auf einen gültigen Wert gesetzt wird.

Sind Sie sicher dass Sie fortfahren möchten?";
$GLOBALS['strCampaignWarningNoTarget'] = "Der Kampagnentyp ist auf Vertrag gesetzt ohne ein Tageslimit anzugeben, hierdurch wird die Kampagne inaktiv bleiben.
Es werden keine Banner ausgeliefert, bis eine
gültiger Wert für das Tageslimit vorliegt.

 Wollen Sie fortfahren?";
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
$GLOBALS['strOverride'] = "Überschreiben";
$GLOBALS['strOverrideInfo'] = "Kampagnen vom Typ Überschreiben sind besondere Kampagnen mit höherer Priorität
    als Kampagnen vom Typ Vertrag oder Verbleibend. Kampagnen dieses Typs werden in der Regel mit festgelegten
    Targeting-Zielen und/oder Kappungsregeln kombiniert, um sicherzustellen, dass die Anzeigen dieser Kampagnen nur in 
    bestimmten Regionen, bei bestimmten Benutzern, nur in bestimmter Häufigkeit oder als Teil von bestimmter Werbung 
    angezeigt werden. (Diese Art von Kampagnen wurde in früheren Versionen als 'Vertrag (Exklusiv)' bezeichnet.)";
$GLOBALS['strStandardContract'] = "Vertrag";
$GLOBALS['strStandardContractInfo'] = "Diese Kampagne hat ein Tageslimit und wird gleichmäßig ausgeliefert bis das Enddatum erreicht ist oder das spezifizierte Limit erfüllt ist";
$GLOBALS['strRemnant'] = "Verbleibende";
$GLOBALS['strRemnantInfo'] = "Dies ist eine Standard-Kampagne, sie kann mit einem Enddatum oder einem bestimmten Limit versehen werden";
$GLOBALS['strECPMInfo'] = "Dies ist eine Standard-Kampagne, sie kann mit einem Enddatum oder einem bestimmten Limit versehen werden. Basierend auf den aktuellen Einstellungen wird sie mit Hilfe von eCPM priorisiert.";
$GLOBALS['strPricing'] = "Preiskalkulation";
$GLOBALS['strPricingModel'] = "Preiskalkulationsmodell";
$GLOBALS['strSelectPricingModel'] = "\\-- Modell auswählen --";
$GLOBALS['strRatePrice'] = "Rate / Preis";
$GLOBALS['strMinimumImpressions'] = "Mindestwert tägliche Impressionen";
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
$GLOBALS['strArrival'] = "Eingangsbenachrichtigung";
$GLOBALS['strManual'] = "Handbuch";
$GLOBALS['strImpression'] = "Impressionen";
$GLOBALS['strConversionType'] = "Konversionstyp";
$GLOBALS['strLinkCampaignsByDefault'] = "Verlinke neu erstellte Kampagnen automatisch";
$GLOBALS['strBackToTrackers'] = "Zurück zu den Trackern";
$GLOBALS['strIPAddress'] = "IP-Adresse";

// Banners (General)
$GLOBALS['strBanner'] = "Banner";
$GLOBALS['strBanners'] = "Banner";
$GLOBALS['strAddBanner'] = "Neues Banner hinzufügen";
$GLOBALS['strAddBanner_Key'] = "<u>N</u>eues Banner hinzufügen ";
$GLOBALS['strBannerToCampaign'] = "Zur Kampagne";
$GLOBALS['strShowBanner'] = "Banner anzeigen";
$GLOBALS['strBannerProperties'] = "Bannermerkmale";
$GLOBALS['strBannerHistory'] = "Banner Statistiken";
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
$GLOBALS['strCampaignPreferences'] = "Voreinstellungen Kampagnen";
$GLOBALS['strDefaultBanners'] = "Standard Banner";
$GLOBALS['strDefaultBannerUrl'] = "Standard Bild-URL";
$GLOBALS['strDefaultBannerDestination'] = "Standard Ziel-URL";
$GLOBALS['strAllowedBannerTypes'] = "Erlaubte Banner-Typen";
$GLOBALS['strTypeSqlAllow'] = "Lokale SQL-Banner erlauben";
$GLOBALS['strTypeWebAllow'] = "Lokale Webserver-Banner erlauben";
$GLOBALS['strTypeUrlAllow'] = "Externe Banner erlauben";
$GLOBALS['strTypeHtmlAllow'] = "HTML-Banner erlauben";
$GLOBALS['strTypeTxtAllow'] = "Textanzeigen erlauben";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Bannertype auswählen";
$GLOBALS['strMySQLBanner'] = "Einen lokal gespeicherten Banner in Datenbank laden";
$GLOBALS['strWebBanner'] = "Einen lokal gespeicherten Banner auf den Webserver laden";
$GLOBALS['strURLBanner'] = "Verlinke einen externen Banner";
$GLOBALS['strHTMLBanner'] = "Einen HTML-Banner anlegen";
$GLOBALS['strTextBanner'] = "Einen Text-Banner anlegen";
$GLOBALS['strAlterHTML'] = "HTML anpassen, um die Aufzeichnung von Klicks zu ermöglichen für:";
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
$GLOBALS['strCampaignsWeight'] = "Gewichtung der Kampagne";
$GLOBALS['strBannerWeight'] = "Bannergewichtung";
$GLOBALS['strBannersWeight'] = "Bannergewichtung";
$GLOBALS['strAdserverTypeGeneric'] = "Standard HTML-Banner";
$GLOBALS['strDoNotAlterHtml'] = "HTML nicht ändern";
$GLOBALS['strGenericOutputAdServer'] = "Generisch";
$GLOBALS['strBackToBanners'] = "Zurück zu den Bannern";
$GLOBALS['strUseWyswygHtmlEditor'] = "WYSIWYG HTML-Editor verwenden";
$GLOBALS['strChangeDefault'] = "Standard ändern";
$GLOBALS['strBannerNotSslCompliant'] = "Banner enthält nicht HTTPS-Assets und wird nicht auf HTTPS-Seiten angezeigt";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "Diesem Banner immer den folgenden HTML-Code voranstellen";
$GLOBALS['strBannerAppendHTML'] = "An diesen Banner immer den folgenden HTML-Code anhängen";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "Auslieferungsoptionen";
$GLOBALS['strACL'] = "Auslieferungsoptionen";
$GLOBALS['strACLAdd'] = "Auslieferungsregel hinzufügen";
$GLOBALS['strApplyLimitationsTo'] = "Auslieferungsregeln anwenden auf";
$GLOBALS['strAllBannersInCampaign'] = "Alle Banner in dieser Kampagne";
$GLOBALS['strRemoveAllLimitations'] = "Entferne alle Auslieferungsregeln";
$GLOBALS['strEqualTo'] = "ist gleich";
$GLOBALS['strDifferentFrom'] = "ist ungleich";
$GLOBALS['strLaterThan'] = "ist später als";
$GLOBALS['strLaterThanOrEqual'] = "ist später als oder gleichzeitig mit";
$GLOBALS['strEarlierThan'] = "ist früher als";
$GLOBALS['strEarlierThanOrEqual'] = "ist früher als oder gleichzeitig mit";
$GLOBALS['strContains'] = "enthält";
$GLOBALS['strNotContains'] = "beinhaltet nicht";
$GLOBALS['strGreaterThan'] = "ist größer als";
$GLOBALS['strLessThan'] = "ist kleiner als";
$GLOBALS['strGreaterOrEqualTo'] = "ist größer oder gleich zu";
$GLOBALS['strLessOrEqualTo'] = "ist kleiner oder gleich zu";
$GLOBALS['strAND'] = "UND";                          // logical operator
$GLOBALS['strOR'] = "ODER";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Diesen Banner nur anzeigen, wenn:";
$GLOBALS['strWeekDays'] = "Wochentage";
$GLOBALS['strTime'] = "Zeit";
$GLOBALS['strDomain'] = "Domäne";
$GLOBALS['strSource'] = "Quelle";
$GLOBALS['strBrowser'] = "Browser";
$GLOBALS['strOS'] = "BS";
$GLOBALS['strDeliveryLimitations'] = "Auslieferungsregeln";

$GLOBALS['strDeliveryCappingReset'] = "Rücksetzen AdView-Zählers nach";
$GLOBALS['strDeliveryCappingTotal'] = "insgesamt";
$GLOBALS['strDeliveryCappingSession'] = "pro Session";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = [];
}
$GLOBALS['strCappingBanner']['title'] = "Kappung der Auslieferung pro Besucher";
$GLOBALS['strCappingBanner']['limit'] = "Banner Ausliferungen kappen auf:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = [];
}
$GLOBALS['strCappingCampaign']['title'] = "Kappung der Auslieferung pro Besucher";
$GLOBALS['strCappingCampaign']['limit'] = "Kampagnen kappen auf:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = [];
}
$GLOBALS['strCappingZone']['title'] = "Kappung der Auslieferung pro Besucher";
$GLOBALS['strCappingZone']['limit'] = "Zone kappen auf:";

// Website
$GLOBALS['strAffiliate'] = "Webseite";
$GLOBALS['strAffiliates'] = "Webseiten";
$GLOBALS['strAffiliatesAndZones'] = "Webseiten & Zonen";
$GLOBALS['strAddNewAffiliate'] = "Neuen Webseite anlegen";
$GLOBALS['strAffiliateProperties'] = "Webseite Merkmale";
$GLOBALS['strAffiliateHistory'] = "Webseite Statistiken";
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
$GLOBALS['strZone'] = "Zone";
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
$GLOBALS['strZoneVideoInstream'] = "Inline-Video-Anzeige";
$GLOBALS['strZoneVideoOverlay'] = "Overlay-Video-Anzeige";
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
$GLOBALS['strBackToZones'] = "Zurück zu den Zonen";

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
$GLOBALS['strStatusDuplicate'] = "Duplizieren";
$GLOBALS['strStatusOnHold'] = "in der Warteschleife";
$GLOBALS['strStatusIgnore'] = "Ignorieren";
$GLOBALS['strConnectionType'] = "Art";
$GLOBALS['strConnTypeSale'] = "Sale";
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Anmeldung";
$GLOBALS['strShortcutEditStatuses'] = "Status bearbeiten";
$GLOBALS['strShortcutShowStatuses'] = "Status anzeigen";

// Statistics
$GLOBALS['strStats'] = "Statistiken";
$GLOBALS['strNoStats'] = "Zur Zeit sind keine Statistiken vorhanden";
$GLOBALS['strNoStatsForPeriod'] = "Es sind derzeit keine Statistiken für den Zeitraum %s bis %s vorhanden";
$GLOBALS['strGlobalHistory'] = "Globale Statistiken";
$GLOBALS['strDailyHistory'] = "Tägliche Statistiken";
$GLOBALS['strDailyStats'] = "Tägliche Statistiken";
$GLOBALS['strWeeklyHistory'] = "Wöchentliche Statistiken";
$GLOBALS['strMonthlyHistory'] = "Monatliche Statistiken";
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
$GLOBALS['strDistributionHistoryCampaign'] = "Auslieferungsstatistiken (Kampagne)";
$GLOBALS['strDistributionHistoryBanner'] = "Auslieferungsstatistiken (Banner)";
$GLOBALS['strDistributionHistoryWebsite'] = "Auslieferungsstatistiken (Webseite)";
$GLOBALS['strDistributionHistoryZone'] = "Auslieferungsstatistiken (Zone)";
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
$GLOBALS['strStartDate'] = "Startdatum";
$GLOBALS['strEndDate'] = "Enddatum";
$GLOBALS['strPeriod'] = "Zeitraum";
$GLOBALS['strLimitations'] = "Auslieferungsregeln";
$GLOBALS['strWorksheets'] = "Arbeitsblätter";

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
$GLOBALS['strGenerateHttpsTags'] = "Generiere Tags unter Verwendung des HTTPS-Protokolls";

// Errors
$GLOBALS['strErrorDatabaseConnection'] = "Datenbankverbindungsfehler.";
$GLOBALS['strErrorCantConnectToDatabase'] = "Ein fataler Fehler ist aufgetreten %1\$s kann sich nicht mit der Datenbank verbinden. 
Daher ist eine Benutzung der Administations-Oberfläche nicht möglich.
Die Auslieferung von Anzeigen ist möglicherweise ebenfalls betroffen.  
Mögliche Gründe für dieses Problem sind:
<ul>
<li>Der Datenbank-Server funktioniert im Moment nicht.</li>
<li>Die Adresse des Datenbank-Servers hat sich geändert.</li>
<li>Die Zugangsdaten für den Zugriff auf den Datenbank-Server sind nicht korrekt.</li>
<li>Die PHP-Erweiterung <i>%2\$s</i> wurde nicht geladen.</li>
</ul>";
$GLOBALS['strNoMatchesFound'] = "Kein Objekt gefunden";
$GLOBALS['strErrorOccurred'] = "Ein Fehler ist aufgetreten";
$GLOBALS['strErrorDBPlain'] = "Beim Zugriff auf die Datenbank ist ein Fehler aufgetreten ";
$GLOBALS['strErrorDBSerious'] = "Ein schwerwiegendes Problem mit der Datenbank wurde erkannt";
$GLOBALS['strErrorDBNoDataPlain'] = "Aufgrund eines Fehlers mit der Datenbank konnte {$PRODUCT_NAME} weder aus der Datenbank lesen noch in sie schreiben. ";
$GLOBALS['strErrorDBNoDataSerious'] = "Aufgrund eines schweren Problems mit der Datenbank konnte {$PRODUCT_NAME}  keine Daten suchen";
$GLOBALS['strErrorDBCorrupt'] = "Die Datenbanktabelle ist wahrscheinlich zerstört und mu&szlig wiederhergestellt werden. Informationen über die Wiederherstellung zerstörter Tabellen finden sich im Handbuch.";
$GLOBALS['strErrorDBContact'] = "Bitte nehmen Sie Kontakt mit dem Systemverwalter Ihres Servers auf und schildern Sie ihm das Problem. Nur er kann helfen.";
$GLOBALS['strErrorDBSubmitBug'] = "Wenn das Problem wiederholt auftritt, kann es ein Fehler in {$PRODUCT_NAME} sein. Bitte protokollieren Sie die Fehlermeldung uns senden sie diese an den Support von {$PRODUCT_NAME}. Bitte versuchen Sie, alle Aktivitäten, die zu diesem Fehler führten, so genau wie möglich zu beschreiben.";
$GLOBALS['strMaintenanceNotActive'] = "Das Wartungsprogramm lief während der letzen 24 Stunden nicht.
Damit {$PRODUCT_NAME} korrekt arbeiten kann, muß das Wartungsprogramm stündlich
aufgerufen werden.

Im Administrations-Handbuch finden sich weitere Informationen
zur Konfiguration des Wartungsprogrammes.";
$GLOBALS['strErrorLinkingBanner'] = "Es gab Fehler bei der Verknüpfung von Bannern mit Zonen:";
$GLOBALS['strUnableToLinkBanner'] = "Folgende Verknüpfung(en) sind fehlgeschlagen: ";
$GLOBALS['strErrorEditingCampaignRevenue'] = "Ungültiges Zahlenformat im Feld Umsatzinformationen";
$GLOBALS['strErrorEditingCampaignECPM'] = "Ungültiges Zahlenformat im Feld ECPM-Information";
$GLOBALS['strErrorEditingZone'] = "Fehler beim Update der Zone:";
$GLOBALS['strUnableToChangeZone'] = "Diese Änderung ist unwirksam weil:";
$GLOBALS['strDatesConflict'] = "Datumskonflikt mit:";
$GLOBALS['strEmailNoDates'] = "E-Mail- und Newsletter-Kampagnen müssen ein Start- und ein Enddatum haben.";
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
$GLOBALS['strUploadedRequired'] = "Hochladen einer Datei ist erforderlich";
$GLOBALS['strUploadedFileTooBig'] = "Die hochgeladene Datei ist zu groß. Bitte stellen Sie sicher, dass sie unter %s Bytes ist";

// Email
$GLOBALS['strSirMadam'] = "Sehr geehrte Damen und Herren";
$GLOBALS['strMailSubject'] = "Bericht für Werbetreibende";
$GLOBALS['strMailHeader'] = "Sehr geehrte(r) {contact},";
$GLOBALS['strMailBannerStats'] = "Sie erhalten nachfolgend die Bannerstatistik für {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Kampagne aktiviert";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Kampagne deaktiviert";
$GLOBALS['strMailBannerActivated'] = "Die unten angegebene Kampagne wurde aktiviert, weil
das Kampagnen Startdatum erreicht wurde.";
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
$GLOBALS['strRevenueIsNull'] = "seine Einnahmen sind auf 0 (Null) gesetzt";
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
$GLOBALS['strEmailAddress'] = "E-Mail-Addresse";
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
$GLOBALS['strChooseSection'] = 'Bereichsauswahl';

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
$GLOBALS['strGlobalAgency'] = 'Konten';
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
$GLOBALS['strAgencyStatusRunning'] = "Aktiv";
$GLOBALS['strAgencyStatusInactive'] = "inaktiv";
$GLOBALS['strAgencyStatusPaused'] = "Angehalten";

// Channels
$GLOBALS['strChannel'] = "Auslieferungsregel-Satz";
$GLOBALS['strChannels'] = "Auslieferungsregel-Sätze";
$GLOBALS['strChannelManagement'] = "Verwaltung von Auslieferungsregel-Sätzen";
$GLOBALS['strAddNewChannel'] = "Neuen Auslieferungsregel-Satz hinzufügen";
$GLOBALS['strAddNewChannel_Key'] = "<u>n</u>euer Auslieferungsregel-Satz";
$GLOBALS['strChannelToWebsite'] = "Zur Webseite";
$GLOBALS['strNoChannels'] = "Es sind momentan keine Auslieferungsregel-Sätze definiert.";
$GLOBALS['strNoChannelsAddWebsite'] = "Es sind momentan keine Auslieferungsregel-Sätze festgelegt, weil es noch keine Webseiten gibt. Um einen Auslieferungsregel-Satz zu erstellen, müssen Sie zunächst <a href='affiliate-edit.php'>eine neue Webseite anlegen</a>.";
$GLOBALS['strEditChannelLimitations'] = "Regeln des Auslieferungsregel-Satzes bearbeiten";
$GLOBALS['strChannelProperties'] = "Eigenschaften des Auslieferungsregel-Satzes";
$GLOBALS['strChannelLimitations'] = "Auslieferungsoptionen";
$GLOBALS['strConfirmDeleteChannel'] = "Wollen Sie diesen Auslieferungsregel-Satz wirklich löschen?";
$GLOBALS['strConfirmDeleteChannels'] = "Wollen Sie die gewählten Auslieferungsregel-Sätze wirklich löschen?";
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
$GLOBALS['strVariableCode'] = "Javascript-Tracking-Code";

// Password recovery
$GLOBALS['strForgotPassword'] = "Passwort vergessen?";
$GLOBALS['strPasswordRecovery'] = "Passwort zurücksetzen";
$GLOBALS['strWelcomePage'] = "Willkommen neuer Nutzer!";
$GLOBALS['strWelcomePageText'] = "<b>Willkommen im {$PRODUCT_NAME}.</b><br>Als neuer Nutzer legen Sie bitte zunächst Ihr Passwort fest. Bitte wählen Sie ein sicheres und nur dafür verwendetes Passwort.";
$GLOBALS['strEmailRequired'] = "Das Eingabefeld e-Mail muss ausgefüllt sein";
$GLOBALS['strPwdRecWrongExpired'] = "Der Link zum Zurücksetzen des Passworts ist fehlerhaft. Bitte fordern Sie einen neuen Link an.";
$GLOBALS['strPwdRecEnterEmail'] = "Geben Sie nachfolgend Ihre eMail Adresse ein";
$GLOBALS['strPwdRecEnterPassword'] = "Geben Sie nachfolgend Ihr neues Passwort ein";
$GLOBALS['strProceed'] = "Weiter >";
$GLOBALS['strNotifyPageMessage'] = "Eine E-Mail mit einem Link wurde an Sie versendet. Bitte folgen Sie dem Link um
     ein neues Passwort festzulegen und sich anzumelden.<br />Bis die E-Mail bei Ihnen eintrifft, könnten ein paar Minuten vergehen.<br />
     Wenn Sie keine E-Mail erhalten, prüfen Sie bitte auch den SPAM- bzw. Junk-Ordner in Ihrem E-Mail-Postfach.<br />
     <a href=\\\"index.php\\\">Zurück zur Anmeldeseite</a>";

// Password recovery - Default
$GLOBALS['strPwdRecEmailPwdRecovery'] = "Setzen Sie Ihr %s Passwort zurück";
$GLOBALS['strPwdRecEmailBody'] = "Hallo {name},

Sie, oder jemand der sich für Sie ausgibt, hat kürzlich ein neues Passwort für {application_name} angefordert.

Wenn diese Anforderung tatsächlich von Ihnen stammt, können Sie das Passwort für den Benutzer '{username}' ändern
indem Sie auf den folgenden Link klicken:

{reset_link}

Wenn Sie versehentlich ein neues Passwort angefordert haben oder diese Anforderung nicht von Ihnen stammt, dann
ignorieren Sie bitte ganz einfach diese E-Mail. Noch wurde das Passwort nicht geändert und der Link zum Zurücksetzen
wird in Kürze automatisch ablaufen.

Wenn Sie weitere E-Mails dieser Art erhalten, könnte das ein Zeichen dafür sein, dass jemand versucht Zugriff auf Ihr
Benutzerkonto zu bekommen. In diesem Fall nehmen Sie bitte Kontakt zum Kundendienst oder System Administrator des 
{application_name} Systems auf und informieren Sie Ihn über den Vorfall.

{admin_signature}";

$GLOBALS['strPwdRecEmailSincerely'] = "Mit freundlichen Grüßen";

// Password recovery - Welcome email
$GLOBALS['strWelcomeEmailSubject'] = "Willkommen zu %s: Bitte legen Sie ein Passwort fest";
$GLOBALS['strWelcomeEmailBody'] = "Hallo {name},

Ein Benutzername wurde für Sie angelegt, der es Ihnen ermöglicht sich bei {application_name} anzumelden.

Ihr Benutzername lautet '{username}'.

Aus Sicherheitsgründen wurde noch kein Passwort für Ihren Benutzernamen festgelegt.

Um das Passwort festzulegen, klicken Sie bitte auf den folgenden Link:

{reset_link}

Bitte wählen Sie ein sicheres Passwort das Sie ausschließlich für diesen Zweck verwenden.

{admin_signature}";

// Password recovery - Hash update
$GLOBALS['strPasswordUpdateEmailSubject'] = "Bitte legen Sie für Ihren Benutzer %s ein neues Passwort fest";
$GLOBALS['strPasswordUpdateEmailBody'] = "Hallo {name},

Sie erhalten diese E-Mail, weil Sie ein Benutzerkonto bei {application_name} haben.

Die {application_name} Software wurde kürzlich auf eine neue Version aktualisiert, die eine neue und sicherere Methode 
zur Überprüfung von Passwörtern enthält. Diese Änderung macht {application_name} sicherer für Sie und alle anderen 
Nutzer.

Um diese Verbesserung nutzen zu können ist es nötig, dass Sie ein neues Passwort für Ihr Benutzerkonto festlegen. 
Bitte wählen Sie ein möglichst sicheres Passwort das Sie ausschließlich für diesen Zweck nutzen.
Bei der Eingabe des neuen Passworts zeigt Ihnen der farbige Balken wie sicher das Passwort ist. 

Um jetzt ein neues Passwort für Ihren Benutzernamen '{username}' festzulegen, klicken Sie bitte auf den folgenden Link:

{reset_link}

Aus Sicherheitsgründen ist der oben stehende Link nur eine bestimmte Zeit lang gültig und läuft dann ab.
Wenn der Link nicht mehr gültig sein sollte, können Sie mit der Eingabe Ihrer E-Mail-Adresse den regulären Prozess
zum Zurücksetzen Ihres Passworts starten.

Danke, dass Sie mithelfen {application_name} sicherer für alle zu machen!

{admin_signature}";

// Password reset warning
$GLOBALS['strPasswordResetRequiredTitle'] = "Wichtiger Hinweis zur verbesserten Passwort-Sicherheit";
$GLOBALS['strPasswordResetRequired'] = "Kürzlich wurde die {$PRODUCT_NAME} Software auf eine neue Version aktualisiert die eine modernere und sicherere Art der Passwort-Speicherung beinhaltet. Daher ist es nötig, dass Sie ein neues Passwort festlegen um {$PRODUCT_NAME} weiter nutzen zu können.
Bitte prüfen Sie Ihr E-Mail-Postfach, ob Sie eine E-Mail zum Zurücksetzen des Passworts erhalten haben!
Eine E-Mail zum Zurücksetzen des Passworts wurde an die E-Mail-Adresse Ihres Benutzerkontos gesendet. Bitte öffnen Sie diese E-Mail und klicken Sie den Link darin an. Der Link führt zu einem Formular mit dem Sie ein neues Passwort festlegen können. 
Bis die E-Mail eintrifft, können unter Umständen einige Minuten vergehen. Wenn die E-Mail nicht im Posteingang zu finden ist, prüfen Sie bitte auch den SPAM- bzw. Junk-Ordner Ihres E-Mail-Postfachs.";
$GLOBALS['strPasswordUnsafeWarning'] = "Ihr Passwort wurde als nicht sicher genug eingeschätzt. Bitte <a href='%s'>ändern Sie es</a> so bald wie möglich.";

// Audit
$GLOBALS['strAdditionalItems'] = "und weitere Einträge";
$GLOBALS['strAuditSystem'] = "System";
$GLOBALS['strFor'] = "für";
$GLOBALS['strHas'] = "hat";
$GLOBALS['strBinaryData'] = "Binäre Daten";
$GLOBALS['strAuditTrailDisabled'] = "Das Prüfprotokoll wurde vom Administrator deaktiviert. Es werden keine weiteren Ereignisse protokolliert.";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "Es wurde keine Benutzeraktivität innerhalb des ausgewählen Zeitrahmens protokolliert.";
$GLOBALS['strAuditTrail'] = "Prüfprotokoll";
$GLOBALS['strAuditTrailSetup'] = "Heute das Prüfprotokoll einrichten";
$GLOBALS['strAuditTrailGoTo'] = "Gehe zur Prüfprotokollseite";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Prüfprotokolle gestatten Ihnen einen Einblick wer wann was geändert hat. Oder um es anders auszudrücken: {$PRODUCT_NAME} protokolliert für Sie alle Änderungen im System.</li><li>Diese Nachricht wird Ihnen angezeigt, weil das Prüfprotokoll aktuell deaktiviert ist.</li><li>Sie möchten mehr hierüber wissen? Lesen Sie die <a href='{$PRODUCT_DOCSURL}/settings/auditTrail' class='site-link' target='help' >Dokumentation über die Prüfprotokolle.</a></li>";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Gehe zur Kampagne";
$GLOBALS['strCampaignSetUp'] = "Heute eine Kampagne einrichten";
$GLOBALS['strCampaignNoRecords'] = "<li>In Kampagnen können Sie beliebig viele Banner unterschiedlicher Größe (Breite/Höhe) mit gleichen Eigenschaften zusammenfassen.</li><li>Sparen Sie Zeit indem Sie Banner mit gleichen Auslieferungsbeschränkungen in einer Kampagne zusammenfassen, und nicht in jedem Banner erneut definieren müssen.</li><li>Sehen Sie sich die <a class='site-link' target='help' href='{$PRODUCT_DOCSURL}/inventory/advertisersAndCampaigns/campaigns'>Dokumentation über die Kampagnen an.</a>!</li>";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>Es gibt keine Ereignisse zu den Kampagnen anzuzeigen.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "In dem angegebenen Zeitraum wurde keine Kampagne gestartet oder beendet.";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>Wenn Sie gestartete oder beendete Kampagnen im ausgewählten Zeitraum sehen möchten, muß das Prüfprotokoll aktiviert sein.</li><li>Sie sehen diese Mitteilung, da Sie das Prüfprotokoll nicht aktiviert haben.</lI>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Aktivieren Sie das Prüfprotokoll um Kampagnen anzuzeigen";

$GLOBALS['strUnsavedChanges'] = "Sie haben noch ungesicherte Änderungen auf dieser Seite. Nur wenn Sie am Ende \"Speichern\" klicken werden diese Änderungen übernommen";
$GLOBALS['strDeliveryLimitationsDisagree'] = "WARNUNG: Die Auslieferungsregeln im Cache-Speicher <strong>stimmen nicht überein</strong> mit den unten angezeigten Auslieferungsregeln <br /> Bitte drücken Sie auf Speichern, um die Auslieferungsregeln im Cache-Speicher zu aktualisieren";
$GLOBALS['strDeliveryRulesDbError'] = "WARNUNG: Beim Speichern der Auslieferungsregeln ist ein Datenbank-Fehler aufgetreten. Bitte prüfen Sie die untenstehenden Auslieferungsregeln sorgfältig und passen Sie sie wenn nötig an.";
$GLOBALS['strDeliveryRulesTruncation'] = "WARNUNG: Beim Speichern der Auslieferungsregeln wurden Daten von MySQL gekürzt (truncated), daher wurden die ursprünglichen Daten wiederhergestellt. Bitte reduzieren Sie die Länge der Regel und versuchen Sie es erneut.";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Einige Auslieferungsregeln liefern falsche Werte:";

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
$GLOBALS['strBannerAclHasBeenAppliedTo'] = "Die Auslieferungsoptionen des Banners <a href='%s'>%s</a> wurden auf %d Banner angewendet";
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

$GLOBALS['strChannelHasBeenAdded'] = "Die Auslieferungsregel <a href='%s'>%s</a> wurde hinzugefügt. <a href='%s'>Auslieferungsregeln festlegen</a>";
$GLOBALS['strChannelHasBeenUpdated'] = "Die Auslieferungsregel <a href='%s'>%s</a> wurde aktualisiert";
$GLOBALS['strChannelAclHasBeenUpdated'] = "Die Auslieferungsregel für den Auslieferungsregel-Satz <a href='%s'>%s</a> wurde aktualisiert";
$GLOBALS['strChannelHasBeenDeleted'] = "Die Auslieferungsregel <b>%s</b> wurde gelöscht";
$GLOBALS['strChannelsHaveBeenDeleted'] = "Alle gewählten Auslieferungsregel-Sätze wurden gelöscht";
$GLOBALS['strChannelHasBeenDuplicated'] = "Der Auslieferungsregel-Satz <a href='%s'>%s</a> wurde kopiert nach <a href='%s'>%s</a>";

$GLOBALS['strUserPreferencesUpdated'] = "Ihre Voreinstellungen <b>%s</b> wurden geändert";
$GLOBALS['strEmailChanged'] = "Ihre E-Mail Adresse wurde geändert";
$GLOBALS['strPasswordChanged'] = "Ihr Passwort wurde geändert";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "<b>%s</b> wurde geändert";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "<b>%s</b> wurde geändert";
$GLOBALS['strTZPreferencesWarning'] = "Jedoch, Kampagnen-Aktivierung und -Ablauf wurden nicht aktualisiert und auch keine Zeit-basierten Auslieferungsregeln.<br />Sie müssen diese manuell aktualisieren, wenn sie die neue Zeitzone berücksichtigen sollen.";

// Report error messages
$GLOBALS['strReportErrorMissingSheets'] = "Für den Bericht wurde kein Arbeitsblatt ausgewählt";
$GLOBALS['strReportErrorUnknownCode'] = "Unbekannter Fehler Nr. #";

/* ------------------------------------------------------- */
/* Password strength                                       */
/* ------------------------------------------------------- */

$GLOBALS['strPasswordMinLength'] = 'Mind.-Länge von %d Zeichen';
$GLOBALS['strPasswordTooShort'] = "Zu kurz";

if (!isset($GLOBALS['strPasswordScore'])) {
    $GLOBALS['strPasswordScore'] = [];
}

$GLOBALS['strPasswordScore'][0] = "sehr schwach";
$GLOBALS['strPasswordScore'][1] = "schwach";
$GLOBALS['strPasswordScore'][2] = "ausreichend";
$GLOBALS['strPasswordScore'][3] = "gut";
$GLOBALS['strPasswordScore'][4] = "ausgezeichnet";


/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome'] = "h";
$GLOBALS['keyUp'] = "b";
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
