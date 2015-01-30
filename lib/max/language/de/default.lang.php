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
$GLOBALS['strMore'] = "Mehr";
$GLOBALS['strLess'] = "Weniger";
$GLOBALS['strAdminstration'] = "Inventar-Seiten";
$GLOBALS['strMaintenance'] = "Wartung (Programm)";
$GLOBALS['strProbability'] = "Wahrscheinlichkeit";
$GLOBALS['strInvocationcode'] = "Bannercode";
$GLOBALS['strTrackerVariables'] = "Tracker-Variablen";
$GLOBALS['strBasicInformation'] = "Basisinformationen";
$GLOBALS['strAdditionalInformation'] = "Weitere Informationen";
$GLOBALS['strContractInformation'] = "Vertragsinformationen";
$GLOBALS['strLoginInformation'] = "Login-Informationen";
$GLOBALS['strLogoutURL'] = "URL auf die beim Logout verwiesen wird. <br />Leerlassen verlinkt auf Standardseite";
$GLOBALS['strAppendTrackerCode'] = "Tracker Code anhängen";
$GLOBALS['strOverview'] = "Übersicht";
$GLOBALS['strSearch'] = "<u>S</u>uchen";
$GLOBALS['strHistory'] = "Entwicklung";
$GLOBALS['strUpdateSettings'] = "Update Einstellungen";
$GLOBALS['strCheckForUpdates'] = "Auf neue Programmversionen prüfen";
$GLOBALS['strWhenCheckingForUpdates'] = "Bei der Prüfung auf Updates";
$GLOBALS['strCompact'] = "Kompakt";
$GLOBALS['strVerbose'] = "Detailliert";
$GLOBALS['strUser'] = "Benutzer";
$GLOBALS['strEdit'] = "Bearbeiten";
$GLOBALS['strCreate'] = "Erstellen";
$GLOBALS['strDuplicate'] = "Kopieren";
$GLOBALS['strMoveTo'] = "Verschieben nach";
$GLOBALS['strDelete'] = "Löschen";
$GLOBALS['strActivate'] = "Aktivieren";
$GLOBALS['strDeActivate'] = "Deaktivieren";
$GLOBALS['strConvert'] = "Konvertieren";
$GLOBALS['strRefresh'] = "Aktualisieren";
$GLOBALS['strSaveChanges'] = "Änderungen speichern";
$GLOBALS['strUp'] = "Oben";
$GLOBALS['strDown'] = "Unten";
$GLOBALS['strSave'] = "Speichern";
$GLOBALS['strCancel'] = "Abbrechen";
$GLOBALS['strBack'] = "Zurück";
$GLOBALS['strPrevious'] = "Zurück";
$GLOBALS['strPrevious_Key'] = "<u>Z</u>urück";
$GLOBALS['strNext'] = "Weiter";
$GLOBALS['strNext_Key'] = "<u>W</u>eiter";
$GLOBALS['strYes'] = "Ja";
$GLOBALS['strNo'] = "Nein";
$GLOBALS['strNone'] = "Keiner";
$GLOBALS['strCustom'] = "Benutzerdefiniert";
$GLOBALS['strDefault'] = "Standard";
$GLOBALS['strOther'] = "Andere(r)";
$GLOBALS['strUnknown'] = "Unbekannt";
$GLOBALS['strUnlimited'] = "Unbegrenzt";
$GLOBALS['strUntitled'] = "Ohne Titel";
$GLOBALS['strAll'] = "alle";
$GLOBALS['strAvg'] = "Ø";
$GLOBALS['strAverage'] = "Durchschnitt";
$GLOBALS['strOverall'] = "Gesamt";
$GLOBALS['strTotal'] = "Summe";
$GLOBALS['strUnfilteredTotal'] = "Alle (ungefiltert)";
$GLOBALS['strFilteredTotal'] = "Alle (gefiltert)";
$GLOBALS['strActive'] = "aktive";
$GLOBALS['strFrom'] = "Von";
$GLOBALS['strTo'] = "bis";
$GLOBALS['strAdd'] = "Hinzufügen";
$GLOBALS['strLinkedTo'] = "verknüpft mit";
$GLOBALS['strDaysLeft'] = "Verbliebene Tage";
$GLOBALS['strCheckAllNone'] = "Prüfe alle / keine";
$GLOBALS['strExpandAll'] = "Alle <u>a</u>usklappen";
$GLOBALS['strCollapseAll'] = "Alle <u>z</u>usammenklappen";
$GLOBALS['strShowAll'] = "Alle anzeigen";
$GLOBALS['strNoAdminInterface'] = "Service nicht verfügbar ...";
$GLOBALS['strFilterBySource'] = "filtern nach Quelle";
$GLOBALS['strFieldStartDateBeforeEnd'] = "Das 'Von-Datum' muß vor dem 'Bis-Datum' liegen";
$GLOBALS['strFieldContainsErrors'] = "Folgende Felder sind fehlerhaft:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Bevor Sie fortgefahren können, müssen Sie";
$GLOBALS['strFieldFixBeforeContinue2'] = "diese Fehler beheben.";
$GLOBALS['strDelimiter'] = "Trennzeichen";
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
$GLOBALS['strDifference'] = "Unterschied (%)";
$GLOBALS['strPercentageOfTotal'] = "% Gesamt";
$GLOBALS['strValue'] = "Wert";
$GLOBALS['strNotice'] = "Hinweis";
$GLOBALS['strRequiredField'] = "Benötigtes Eingabefeld";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "Das Dashboard kann nicht angezeigt werden";
$GLOBALS['strNoCheckForUpdates'] = "Das Dashboard kann nicht angezeigt werden da die Einstellung<br/>'Prüfung auf Updates' deaktiviert ist.";
$GLOBALS['strEnableCheckForUpdates'] = "Bitte aktivieren Sie die Option <a href='account-settings-update.php'>Auf Updates prüfen</a><br/>auf der Seite <a href='account-settings-update.php'>Update Einstellungen</a>.";
$GLOBALS['strChoosenDisableHomePage'] = "Sie haben ausgewählt Ihre Homepage zu deaktivieren.";
$GLOBALS['strAccessHomePage'] = "Klicken Sie hier um auf Ihre Homepage zuzugreifen";
$GLOBALS['strEditSyncSettings'] = "und ändern Sie die Einstellungen zur Synchronisation";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "Code";
$GLOBALS['strDashboardSystemMessage'] = "Systemnachricht";
$GLOBALS['strDashboardErrorHelp'] = "Sollte dieser Fehler wiederholt vorkommen, schreiben Sie uns bitte einen detailierten Fehlerbericht im<a href='http://forum.openx.org/'>OpenX Forum</a>.";

// Priority
$GLOBALS['strPriority'] = "Priorität";
$GLOBALS['strPriorityLevel'] = "Dringlichkeitsstufe";
$GLOBALS['strPriorityTargeting'] = "Auslieferung";
$GLOBALS['strPriorityOptimisation'] = "Sonstiges"; // Er, what?
$GLOBALS['strHighAds'] = "Vertrags-Werbeanzeigen";
$GLOBALS['strLowAds'] = "Verbleibende-Werbeanzeigen";
$GLOBALS['strLimitations'] = "Einschränkungen";
$GLOBALS['strNoLimitations'] = "Keine Beschränkungen";
$GLOBALS['strCapping'] = "Kappung";
$GLOBALS['strCapped'] = "Kappung";
$GLOBALS['strNoCapping'] = "keine Kappung";

// Properties
$GLOBALS['strSize'] = "Größe";
$GLOBALS['strWidth'] = "Breite";
$GLOBALS['strHeight'] = "Höhe";
$GLOBALS['strTarget'] = "Zielfenster";
$GLOBALS['strLanguage'] = "Sprache";
$GLOBALS['strDescription'] = "Beschreibung";
$GLOBALS['strVariables'] = "Variablen";
$GLOBALS['strComments'] = "Kommentare";

// User access
$GLOBALS['strWorkingAs'] = "Verwendung als";
$GLOBALS['strWorkingAs'] = "Verwendung als";
$GLOBALS['strSwitchTo'] = "Wechseln zu";
$GLOBALS['strWorkingFor'] = "%s für";
$GLOBALS['strLinkUser'] = "Benutzer hinzufügen";
$GLOBALS['strLinkUser_Key'] = "<u>B</u>enutzer hinzufügen";
$GLOBALS['strUsernameToLink'] = "Benutzername des hinzuzufügenden Benutzers";
$GLOBALS['strEmailToLink'] = "E-Mail des hinzuzufügenden Benutzers";
$GLOBALS['strNewUserWillBeCreated'] = "Ein neuer Benutzer wird angelegt";
$GLOBALS['strToLinkProvideEmail'] = "Eintragen der E-Mail um den Benutzer hinzuzufügen";
$GLOBALS['strToLinkProvideUsername'] = "Eintragen des Benutzernamens um ihn hinzuzufügen";
$GLOBALS['strErrorWhileCreatingUser'] = "Fehler beim Anlegen eines neuen Benutzerkontos: %s";
$GLOBALS['strUserLinkedToAccount'] = "Benutzer wurde diesem Benutzerkonto hinzugefügt";
$GLOBALS['strUserAccountUpdated'] = "Benutzerkonto geändert";
$GLOBALS['strUserUnlinkedFromAccount'] = "Benutzer wurde von diesem Benutzerkonto entfernt";
$GLOBALS['strUserWasDeleted'] = "Benutzer wurde gelöscht";
$GLOBALS['strUserNotLinkedWithAccount'] = "Dieser Benutzer ist nicht mit diesem Benutzerkonto verknüpft";
$GLOBALS['strCantDeleteOneAdminUser'] = "Dieser Benutzer kann nicht gelöscht werden. Mindestens ein Benutzer muß mit dem Administratorkonto verknüpft sein.";
$GLOBALS['strLinkUserHelp'] = "Um einen bereits <b>existierenden Benutzer</b> hinzuzufügen, schreiben Sie %s and klicken auf {$GLOBALS['strLinkUser']} <br />Um einen <b>neuen Benutzer</b> anzulegen, schreiben Sie den gewünschten %s und klicken Sie {$GLOBALS['strLinkUser']}";
$GLOBALS['strLinkUserHelpUser'] = "Benutzername";
$GLOBALS['strLinkUserHelpEmail'] = "E-Mail Adresse";
$GLOBALS['strLastLoggedIn'] = "Zuletzt eingeloggt";
$GLOBALS['strDateLinked'] = "Datum verlinkt";
$GLOBALS['strUnlink'] = "Löschen";
$GLOBALS['strUnlinkingFromLastEntity'] = "Entfernen der letzten Benutzerverknüpfung";
$GLOBALS['strUnlinkingFromLastEntityBody'] = "Das Entfernen der letzten Benutzerverknüpfung löscht diesen Benutzer. Wollen Sie diesen Benutzer löschen?";
$GLOBALS['strUnlinkAndDelete'] = "Entferne &amp; lösche diesen Benutzer";
$GLOBALS['strUnlinkUser'] = "Benutzer löschen";
$GLOBALS['strUnlinkUserConfirmBody'] = "Sind Sie sicher das Sie diesen Benutzer löschen möchten?";

// Login & Permissions
$GLOBALS['strUserAccess'] = "Benutzerzugang";
$GLOBALS['strAdminAccess'] = "Administrator-Zugang";
$GLOBALS['strUserProperties'] = "Eigenschaften Benutzer";
$GLOBALS['strLinkNewUser'] = "Verknüpfe neuen Benutzer";
$GLOBALS['strPermissions'] = "Erlaubnis";
$GLOBALS['strAuthentification'] = "Authentifikation";
$GLOBALS['strWelcomeTo'] = "Willkommen bei";
$GLOBALS['strEnterUsername'] = "Geben Sie Benutzername und Passwort ein";
$GLOBALS['strEnterBoth'] = "Bitte beides eingeben; Benutzername und Passwort";
$GLOBALS['strEnableCookies'] = "Sie müssen Cookies im Browser aktivieren bevor die {$PRODUCT_NAME} verwenden können.";
$GLOBALS['strSessionIDNotMatch'] = "Sitzungs-Cookie fehlerhaft, bitte loggen Sie sich erneut ein.";
$GLOBALS['strLogin'] = "Anmelden";
$GLOBALS['strLogout'] = "Ausloggen";
$GLOBALS['strUsername'] = "Benutzername";
$GLOBALS['strPassword'] = "Passwort";
$GLOBALS['strPasswordRepeat'] = "Wiederhole Passwort";
$GLOBALS['strAccessDenied'] = "Zugang verweigert";
$GLOBALS['strUsernameOrPasswordWrong'] = "Der Benutzername und/oder das Passwort sind nicht korrekt. Bitte erneut versuchen.";
$GLOBALS['strPasswordWrong'] = "Das Passwort ist nicht korrekt";
$GLOBALS['strParametersWrong'] = "Die von Ihnen angegebenen Parameter sind falsch.";
$GLOBALS['strNotAdmin'] = "Ihr Benutzerkonto hat nicht die erforderlichen Rechte um diese Funktion zu verwenden, Sie müssen ein anderes Benutzerkonto verwenden. Klicken Sie <a href='logout.php'>hier</a> um sich neu anzumelden.";
$GLOBALS['strDuplicateClientName'] = "Der gewählte Benutzername existiert bereits. Bitte einen anderen wählen.";
$GLOBALS['strDuplicateAgencyName'] = "Der gewählte Benutzername existiert bereits. Bitte einen anderen wählen.";
$GLOBALS['strInvalidPassword'] = "Das neue Passwort ist ungültig. Bitte wählen Sie ein anderes.";
$GLOBALS['strInvalidEmail'] = "Diese E-Mail Adresse ist nicht korrekt geschrieben, bitte tragen Sie eine korrekte E-Mail Adresse ein.";
$GLOBALS['strNotSamePasswords'] = "Die beiden eingegebenen Passwörter stimmen nicht überein ";
$GLOBALS['strRepeatPassword'] = "Wiederhole Passwort";
$GLOBALS['strOldPassword'] = "Altes Passwort";
$GLOBALS['strNewPassword'] = "Neues Passwort";
$GLOBALS['strNoBannerId'] = "Keine Banner ID";
$GLOBALS['strDeadLink'] = "Ihr Link ist ungültig.";
$GLOBALS['strNoPlacement'] = "Die ausgewählte Kampagne existiert nicht. Versuchen Sie stattdessen diesen <a href='{link}'>Link</a>.";
$GLOBALS['strNoAdvertiser'] = "Der ausgewählte Werbetreibende existiert nicht. Versuchen Sie stattdessen diesen <a href='{link}'>Link</a>.";

// General advertising
$GLOBALS['strRequests'] = "Zugriffe";
$GLOBALS['strClicks'] = "Klicks";
$GLOBALS['strConversions'] = "Konversionen";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strCPC'] = "Kosten pro Klick";
$GLOBALS['strCPCo'] = "Kosten pro Konversion";
$GLOBALS['strTotalViews'] = "Summe der Impressions";
$GLOBALS['strTotalClicks'] = "Summe der Klicks";
$GLOBALS['strTotalConversions'] = "Summe der Konversionen";
$GLOBALS['strViewCredits'] = "Impression-Guthaben";
$GLOBALS['strClickCredits'] = "Klickguthaben";
$GLOBALS['strConversionCredits'] = "Konversionsguthaben";
$GLOBALS['strImportStats'] = "Statistiken importieren";
$GLOBALS['strDateTime'] = "Datum Zeit";
$GLOBALS['strTrackerID'] = "Tracker-ID";
$GLOBALS['strTrackerName'] = "Tracker-Name";
$GLOBALS['strTrackerImageTag'] = "Bilder Tag";
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
$GLOBALS['strFinanceMT'] = "Monatlicher Fixbetrag";
$GLOBALS['strFinanceCR'] = "KR";
$GLOBALS['strPercentRevenueSplit'] = "% Umsatzaufteilung";
$GLOBALS['strPercentBasketValue'] = "% Warenkorb Werte";
$GLOBALS['strAmountPerItem'] = "Anzahl pro Stück";
$GLOBALS['strPercentCustomVariable'] = "% Benutzerdefinierte Variable";
$GLOBALS['strPercentSumVariables'] = "% Summe der Variablen";

// Time and date related
$GLOBALS['strDate'] = "Datum";
$GLOBALS['strToday'] = "Heute";
$GLOBALS['strDay'] = "Tag";
$GLOBALS['strDays'] = "Tage";
$GLOBALS['strLast7Days'] = "letzten 7 Tage";
$GLOBALS['strWeek'] = "Woche";
$GLOBALS['strWeeks'] = "Wochen";
$GLOBALS['strSingleMonth'] = "Monat";
$GLOBALS['strMonths'] = "Monate";
$GLOBALS['strDayOfWeek'] = "Wochentag";
$GLOBALS['strThisMonth'] = "In diesem Monat";

$GLOBALS['strMonth'] = array();
$GLOBALS['strMonth'][0] = "Januar";
$GLOBALS['strMonth'][1] = "Februar";
$GLOBALS['strMonth'][2] = "März";
$GLOBALS['strMonth'][4] = "Mai";
$GLOBALS['strMonth'][5] = "Juni";
$GLOBALS['strMonth'][6] = "Juli";
$GLOBALS['strMonth'][9] = "Oktober";
$GLOBALS['strMonth'][11] = "Dezember";

$GLOBALS['strDayFullNames'] = array();
$GLOBALS['strDayFullNames'][0] = 'Sonntag';
$GLOBALS['strDayFullNames'][1] = 'Montag';
$GLOBALS['strDayFullNames'][2] = 'Dienstag';
$GLOBALS['strDayFullNames'][3] = 'Mittwoch';
$GLOBALS['strDayFullNames'][4] = 'Donnerstag';
$GLOBALS['strDayFullNames'][5] = 'Freitag';
$GLOBALS['strDayFullNames'][6] = 'Samstag';

$GLOBALS['strDayShortCuts'] = array();
$GLOBALS['strDayShortCuts'][0] = 'So';
$GLOBALS['strDayShortCuts'][2] = 'Di';
$GLOBALS['strDayShortCuts'][3] = 'Mi';
$GLOBALS['strDayShortCuts'][4] = 'Do';

$GLOBALS['strHour'] = "Stunde";
$GLOBALS['strHourFilter'] = "Stundenfilter";
$GLOBALS['strSeconds'] = "Sekunden";
$GLOBALS['strMinutes'] = "Minuten";
$GLOBALS['strHours'] = "Stunden";
$GLOBALS['strTimes'] = "mal";

// Advertiser
$GLOBALS['strClient'] = "Werbetreibender";
$GLOBALS['strClients'] = "Werbetreibende";
$GLOBALS['strClientsAndCampaigns'] = "Werbetreibende & Kampagnen";
$GLOBALS['strAddClient'] = "Neuen Werbetreibenden hinzufügen";
$GLOBALS['strAddClient_Key'] = "<u>N</u>euen Werbetreibenden hinzufügen";
$GLOBALS['strTotalClients'] = "Summe Werbetreibende";
$GLOBALS['strClientProperties'] = "Merkmale Werbetreibender";
$GLOBALS['strClientHistory'] = "Entwicklung Werbetreibende";
$GLOBALS['strNoClients'] = "Es sind keine Werbetreibenden angelegt. Um eine Werbekampagne anzulegen, müssen Sie zuerst einen <a href='advertiser-edit.php'>Werbetreibenden hinzufügen</a>.";
$GLOBALS['strNoClientsForBanners'] = "Es sind keine Werbetreibenden angelegt. Um einen Banner anzulegen, müssen Sie zuerst einen <a href='advertiser-edit.php'>Werbetreibenden hinzufügen</a> und eine Kampagne anlegen.";
$GLOBALS['strConfirmDeleteClient'] = "Soll dieser Werbetreibende wirklich gelöscht werden?";
$GLOBALS['strConfirmDeleteClients'] = "Möchten Sie die ausgewählten Werbetreibenden wirklich löschen?";
$GLOBALS['strConfirmResetClientStats'] = "Sollen wirklich alle Statistiken dieses Werbetreibenden gelöscht werden?";
$GLOBALS['strSite'] = "Webseite";
$GLOBALS['strHideInactive'] = "Verberge inaktive";
$GLOBALS['strHideInactiveAdvertisers'] = "Verberge inaktive Werbetreibende";
$GLOBALS['strInactiveAdvertisersHidden'] = "Inaktive Werbetreibende sind verborgen";
$GLOBALS['strOverallAdvertisers'] = "Werbetreibende";
$GLOBALS['strAdvertiserSignup'] = "Anmeldung Werbetreibender";
$GLOBALS['strAdvertiserSignupDesc'] = "Anmeldung als Werbetreibender (Selbstbedienung und Zahlung)";
$GLOBALS['strAdvertiserSignupLink'] = "Link Anmeldung Werbetreibender";
$GLOBALS['strAdvertiserSignupLinkDesc'] = "Um einen Anmeldelink für einen Werbetreibenden zu Ihrer Webseite hinzuzufügen, kopieren Sie bitte den folgenden HTML-Code:";
$GLOBALS['strAdvertiserSignupOption'] = "Einstellungen für die Anmeldemöglichkeit der Werbetreibende";
$GLOBALS['strAdvertiserSignunOptionDesc'] = "Um die Einstellungen für die Anmeldemöglichkeit der Werbetreibende zu ändern, fahren Sie fort mit";
$GLOBALS['strAdvertiserCampaigns'] = "Die Kampagnen des Werbetreibenden";

// Advertisers properties
$GLOBALS['strContact'] = "Name der Kontaktperson";
$GLOBALS['strContactName'] = "Kontakt (Name)";
$GLOBALS['strEMail'] = "E-Mail";
$GLOBALS['strChars'] = "Zeichen";
$GLOBALS['strSendAdvertisingReport'] = "Versenden eines Kampagnen-Auswertung via E-Mail";
$GLOBALS['strNoDaysBetweenReports'] = "Anzahl Tage zwischen zwei Berichten";
$GLOBALS['strSendDeactivationWarning'] = "Versenden eine Benachrichtigungsmail, wenn eine Kampagne automatisch aktiviert oder deaktiviert wurde";
$GLOBALS['strAllowClientModifyInfo'] = "Werbetreibender darf eigene Einstellungen verändern";
$GLOBALS['strAllowClientModifyBanner'] = "Werbetreibender darf eigene Banner verändern";
$GLOBALS['strAllowClientAddBanner'] = "Werbetreibender darf eigene Banner hinzufügen";
$GLOBALS['strAllowClientDisableBanner'] = "Werbetreibender darf eigene Banner deaktivieren";
$GLOBALS['strAllowClientActivateBanner'] = "Werbetreibender darf eigene Banner aktiveren";
$GLOBALS['strAllowClientViewTargetingStats'] = "Werbetreibender bekommt Ziel-Statistiken angezeigt";
$GLOBALS['strAllowCreateAccounts'] = "Erlaube diesem Benutzer neue Benutzerkonten anzulegen";
$GLOBALS['strCsvImportConversions'] = "Werbetreibender darf offline Konversionen uploaden";
$GLOBALS['strAdvertiserLimitation'] = "Zeige nur Banner von diesem Werbetreibenden auf der Seite";
$GLOBALS['strAllowAuditTrailAccess'] = "Diesem Benutzer die Ansicht des Prüfprotokolls erlauben";

// Campaign
$GLOBALS['strCampaign'] = "Kampagne";
$GLOBALS['strCampaigns'] = "Kampagnen";
$GLOBALS['strOverallCampaigns'] = "Kampagne(n)";
$GLOBALS['strTotalCampaigns'] = "Summe Kampagnen";
$GLOBALS['strActiveCampaigns'] = "Aktive Kampagnen";
$GLOBALS['strAddCampaign'] = "Neue Kampagnen hinzufügen";
$GLOBALS['strAddCampaign_Key'] = "<u>N</u>eue Kampagnen hinzufügen";
$GLOBALS['strCampaignForAdvertiser'] = "für Werbetreibende";
$GLOBALS['strCreateNewCampaign'] = "Kampagne erstellen";
$GLOBALS['strModifyCampaign'] = "Kampagne ändern";
$GLOBALS['strMoveToNewCampaign'] = "Verschieben zu einer neuen Kampagne";
$GLOBALS['strBannersWithoutCampaign'] = "Banner ohne Kampagne";
$GLOBALS['strDeleteAllCampaigns'] = "Alle Kampagnen löschen";
$GLOBALS['strLinkedCampaigns'] = "Verknüpfte Kampagnen";
$GLOBALS['strCampaignStats'] = "Kampagnen Statistik";
$GLOBALS['strCampaignProperties'] = "Merkmale Kampagnen";
$GLOBALS['strCampaignOverview'] = "Übersicht Kampagnen";
$GLOBALS['strCampaignHistory'] = "Entwicklung Kampagnen";
$GLOBALS['strNoCampaigns'] = "Für diesen Werbetreibenden sind derzeit keine Kampagnen definiert.";
$GLOBALS['strNoCampaignsForBanners'] = "Dieser Werbetreibende hat keine Kampagnen. Um einen Banner anzulegen, müssen Sie zuerst eine <a href='campaign-edit.php?clientid=%s'>Kampagne hinzufügen</a>.";
$GLOBALS['strConfirmDeleteAllCampaigns'] = "Sollen wirklich alle Kampagnen dieses Werbetreibenden gelöscht werden?";
$GLOBALS['strConfirmDeleteCampaign'] = "Soll diese Kampagne wirklich gelöscht werden?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Möchten Sie die ausgewählten Kampagnen wirklich löschen?";
$GLOBALS['strConfirmResetCampaignStats'] = "Sollen wirklich alle Statistiken dieser Kampagne gelöscht werden?";
$GLOBALS['strShowParentAdvertisers'] = "Zugehörige Werbetreibende anzeigen";
$GLOBALS['strHideParentAdvertisers'] = "Verberge zugehörige Werbetreibende";
$GLOBALS['strHideInactiveCampaigns'] = "Verberge inaktive Kampagnen";
$GLOBALS['strInactiveCampaignsHidden'] = "inaktive Kampagne sind verborgen";
$GLOBALS['strContractDetails'] = "Vertragsdetails";
$GLOBALS['strInventoryDetails'] = "Inventardetails";
$GLOBALS['strPriorityInformation'] = "Priorität in Beziehung zu anderen Kampagnen";
$GLOBALS['strHiddenCampaign'] = "Kampagne";
$GLOBALS['strHiddenAd'] = "Verborgene Werbung";
$GLOBALS['strHiddenAdvertiser'] = "Werbetreibender";
$GLOBALS['strHiddenTracker'] = "Verborgene Tracker";
$GLOBALS['strHiddenWebsite'] = "Webseite";
$GLOBALS['strHiddenZone'] = "Verborgene Zone";
$GLOBALS['strUnderdeliveringCampaigns'] = "Nicht erfüllte Kampagnen";
$GLOBALS['strCampaignDelivery'] = "Kampagnen Auslieferung";
$GLOBALS['strBookedMetric'] = "gebuchter Kampagnentyp";
$GLOBALS['strValueBooked'] = "Auftragsvolumen";
$GLOBALS['strRemaining'] = "Verbleibende";
$GLOBALS['strCompanionPositioning'] = "Tandem-Ads";
$GLOBALS['strSelectUnselectAll'] = "Alle aus- und abwählen";
$GLOBALS['strConfirmOverwrite'] = "Die Banner-Zone Verknüpfungen werden überschrieben, wenn diese Änderungen gespeichert werden. Möchten Sie fortfahren?";
$GLOBALS['strCampaignsOfAdvertiser'] = "von"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'$GLOBALS['strShowCappedNoCookie'] = "Show capped ads if cookies are disabled";

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
$GLOBALS['strNoWebsitesAndZonesCategory'] = "in der Kategorie";
$GLOBALS['strNoWebsitesAndZonesText'] = "mit \"%s\" im Namen";
$GLOBALS['strToLink'] = "zum Verlinken";
$GLOBALS['strToUnlink'] = "zum Aufheben der Verlinkung";
$GLOBALS['strLinked'] = "Verlinkt";
$GLOBALS['strAvailable'] = "Verfügbar";
$GLOBALS['strShowing'] = "Angezeigt";
$GLOBALS['strAllCategories'] = "alle Kategorien";
$GLOBALS['strUncategorized'] = "nicht kategorisiert";
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
$GLOBALS['strRevenueInfo'] = "Umsatzinformationen";
$GLOBALS['strTotalRevenue'] = "Gesamtumsatz";
$GLOBALS['strImpressionsRemaining'] = "Verbleibende Werbemittelauslieferungen";
$GLOBALS['strClicksRemaining'] = "Verbleibende Klicks";
$GLOBALS['strConversionsRemaining'] = "Verbleibende Konversionen";
$GLOBALS['strImpressionsBooked'] = "Gebuchte Werbemittelauslieferungen";
$GLOBALS['strClicksBooked'] = "Gebuchte Klicks";
$GLOBALS['strConversionsBooked'] = "Gebuchte Konversionen";
$GLOBALS['strCampaignWeight'] = "Gewichtung der Kampagne";
$GLOBALS['strTargetLimitAdImpressions'] = "Begrenzung der AdViews auf";
$GLOBALS['strOptimise'] = "Optimieren";
$GLOBALS['strAnonymous'] = "Verberge den Werbetreibenden und die Webseite dieser Kampagne.";
$GLOBALS['strHighPriority'] = "Anzeige von Bannern aus dieser Kampagne mit hoher Priorität.<br />Bei Auswahl dieser Option wird {$PRODUCT_NAME} zunächst vorrangig diese Banner und über den Tag gleichmäßig verteilt ausliefern.";
$GLOBALS['strLowPriority'] = " Anzeige von Bannern aus dieser Kampagne mit geringer Priorität.<br />Diese Kampagne nutzt die überzähligen, nicht von Kampagnen mit höherer Priorität benötigten AdViews.";
$GLOBALS['strTargetPerDay'] = "pro Tag.";
$GLOBALS['strPriorityAutoTargeting'] = "Gleichmäßiges Verteilen der verbleibenden AdViews über die verbleibenden Tage. Täglich erfolgt eine Neuberechnung.";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "Der Kampagnentyp ist auf Verbleibende gesetzt,
aber die Gewichtung ist 0 (oder sie ist undefiniert) -
 hierdurch wird diese Kampagne inaktiv bleiben und
 die Banner werden nicht ausgeliefert bis eine gültige
 Gewichtung eingegeben wird.

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
$GLOBALS['strCampaignApprove'] = "Genehmingen";
$GLOBALS['strCampaignApproveDescription'] = "diese Kampagne akzeptieren";
$GLOBALS['strCampaignReject'] = "Ablehen";
$GLOBALS['strCampaignRejectDescription'] = "diese Kampagne ablehnen";
$GLOBALS['strCampaignPause'] = "Pausieren";
$GLOBALS['strCampaignPauseDescription'] = "diese Kampagne vorübergehend pausieren";
$GLOBALS['strCampaignRestart'] = "Fortsetzen";
$GLOBALS['strCampaignRestartDescription'] = "diese Kampagne fortsetzen";
$GLOBALS['strCampaignStatus'] = "Status der Kampagne";
$GLOBALS['strReasonForRejection'] = "Grund für die Ablehnung";
$GLOBALS['strReasonSiteNotLive'] = "Webseite nicht aktiv";
$GLOBALS['strReasonBadCreative'] = "Inakzeptabler Inhalt";
$GLOBALS['strReasonBadUrl'] = "Nicht angebrachte Ziel-URL";
$GLOBALS['strReasonBreakTerms'] = "Webseite widerspricht den Geschäftsbedingungen";
$GLOBALS['strChangeStatus'] = "Status ändern";
$GLOBALS['strCampaignType'] = "Typ der Kampagnen";
$GLOBALS['strType'] = "Art";
$GLOBALS['strContract'] = "Vertrag";
$GLOBALS['strStandardContract'] = "Vertrag";
$GLOBALS['strStandardContractInfo'] = "Diese Kampagne hat ein Tageslimit und wird gleichmäßig ausgeliefert bis das Enddatum erreicht ist oder das spezifizierte Limit erfüllt ist";
$GLOBALS['strRemnant'] = "Verbleibende";
$GLOBALS['strRemnantInfo'] = "Dies ist eine Standard-Kampagne, sie kann mit einem Enddatum oder einem bestimmten Limit versehen werden";
$GLOBALS['strContractCampaign'] = "Vertrag Kampagne";
$GLOBALS['strRemnantCampaign'] = "Verbleibende Kampagne";
$GLOBALS['strPricing'] = "Preiskalkulation";
$GLOBALS['strPricingModel'] = "Preiskalkulationsmodell";
$GLOBALS['strSelectPricingModel'] = "\\-- Modell auswählen --";
$GLOBALS['strRatePrice'] = "Rate / Preis";
$GLOBALS['strLowExclusiveDisabled'] = "Diese Kampagne kann nicht auf Verbleibende oder Exklusive geändert werden, da sowohl ein Ende-Datum als auch ein Impressionen/Klicks/Konversionen-Limit gesetzt ist.<br />Um den Typ der Kampagne zu ändern muß das Ende-Datum oder das Limit entfernt werden.";
$GLOBALS['strCannotSetBothDateAndLimit'] = "Für eine Verbleibende oder Exklusive Kampagne kann kein Ende-Datum zusammen mit einem Auslieferungslimit gesetzt werden.<br />Wenn ein Ende-Datum zusammen mit einem Limit auf Impressionen/Klicks/Konversionen benötigt wird, kann nur eine nicht-exklusive Vertrags-Kampagne verwendet werden.";
$GLOBALS['strWhyDisabled'] = "warum ist sie deaktiviert?";
$GLOBALS['strBackToCampaigns'] = "Zurück zu den Kampagnen";
$GLOBALS['strCampaignBanners'] = "Banner der Kampagne";

// Tracker
$GLOBALS['strTracker'] = "Verborgene Tracker";
$GLOBALS['strTrackers'] = "Tracker";
$GLOBALS['strTrackerOverview'] = "Überblick Tracker";
$GLOBALS['strTrackerPreferences'] = "Voreinstellungen Tracker";
$GLOBALS['strAddTracker'] = "Neuen Tracker hinzufügen";
$GLOBALS['strAddTracker_Key'] = "<u>N</u>euen Tracker hinzufügen";
$GLOBALS['strTrackerForAdvertiser'] = "für Werbetreibende";
$GLOBALS['strNoTrackers'] = "Für diesen Werbetreibenden sind zur Zeit keine Tracker angelegt";
$GLOBALS['strConfirmDeleteAllTrackers'] = "Wollen Sie wirklich alle zu diesem Werbetreibenden gehörenden Tracker löschen?";
$GLOBALS['strConfirmDeleteTrackers'] = "Wollen Sie die ausgewählten Tracker wirklich löschen?";
$GLOBALS['strConfirmDeleteTracker'] = "Wollen Sie diesen Tracker wirklich löschen?";
$GLOBALS['strDeleteAllTrackers'] = "Alle Tracker löschen";
$GLOBALS['strTrackerProperties'] = "Tracker Merkmale";
$GLOBALS['strTrackerOverview'] = "Überblick Tracker";
$GLOBALS['strModifyTracker'] = "Tracker anpassen";
$GLOBALS['strDefaultStatus'] = "Standardstatus";
$GLOBALS['strLinkedTrackers'] = "verlinkte Tracker";
$GLOBALS['strTrackerInformation'] = "Tracker Informationen";
$GLOBALS['strConversionWindow'] = "Konversionsintervall";
$GLOBALS['strUniqueWindow'] = "Eindeutiger Zeitrahmen";
$GLOBALS['strClick'] = "Klick";
$GLOBALS['strArrival'] = "Eingangsbenachrichtigung";
$GLOBALS['strManual'] = "Handbuch";
$GLOBALS['strImpression'] = "Impressionen";
$GLOBALS['strConversionClickWindow'] = "Zähle Konversionen, die innerhalb der angegebenen Sekundenzahl nach einem Klick stattfinden.";
$GLOBALS['strConversionViewWindow'] = "Zähle Konversionen, die innerhalb der angegebenen Sekundenzahl nach einem View stattfinden.";
$GLOBALS['strTotalTrackerImpressions'] = "Summe der ausgelieferten Impressions";
$GLOBALS['strTotalTrackerConnections'] = "Summe der Connections";
$GLOBALS['strTotalTrackerConversions'] = "Summe der Konversionen";
$GLOBALS['strTrackerClickConnections'] = "Klick Connections";
$GLOBALS['strTrackerImprConversions'] = "Impression Konversionen";
$GLOBALS['strTrackerClickConversions'] = "Klick Konversionen";
$GLOBALS['strConversionType'] = "Konversionstyp";
$GLOBALS['strLinkCampaignsByDefault'] = "Verlinke neu erstellte Kampagnen automatisch";
$GLOBALS['strNoLinkedTrackersDropdown'] = "\\-- Keine verlinkten Tracker --";
$GLOBALS['strPerSingleImpression'] = "pro einzelne Impression";
$GLOBALS['strBackToTrackers'] = "Zurück zu den Trackern";



// Banners (General)
$GLOBALS['strBanners'] = "Banner";
$GLOBALS['strBannerFilter'] = "Werbemittelfilter";
$GLOBALS['strAddBanner'] = "Neues Banner hinzufügen";
$GLOBALS['strAddBanner_Key'] = "<u>N</u>eues Banner hinzufügen ";
$GLOBALS['strBannerToCampaign'] = "Zur Kampagne";
$GLOBALS['strModifyBanner'] = "Banner verändern";
$GLOBALS['strActiveBanners'] = "Aktivierte Banner";
$GLOBALS['strTotalBanners'] = "Summe Banner";
$GLOBALS['strShowBanner'] = "Banner anzeigen";
$GLOBALS['strShowAllBanners'] = "Alle Banner anzeigen";
$GLOBALS['strShowBannersNoAdViews'] = " Alle Banner ohne AdViews anzeigen ";
$GLOBALS['strShowBannersNoAdClicks'] = " Alle Banner ohne AdClicks anzeigen";
$GLOBALS['strShowBannersNoAdConversions'] = "Zeige Werbemittel, die nicht zu einer Konversion geführt haben";
$GLOBALS['strDeleteAllBanners'] = "Alle Banner löschen";
$GLOBALS['strActivateAllBanners'] = "Alle Banner aktivieren";
$GLOBALS['strDeactivateAllBanners'] = "Alle Banner deaktivieren";
$GLOBALS['strBannerOverview'] = "Übersicht Banner";
$GLOBALS['strBannerProperties'] = "Bannermerkmale";
$GLOBALS['strBannerHistory'] = "Entwicklung Banner";
$GLOBALS['strBannerNoStats'] = "Keine Statistiken für den Banner vorhanden ";
$GLOBALS['strNoBanners'] = "Für diese Kampagne sind zur Zeit keine Banner definiert";
$GLOBALS['strNoBannersAddCampaign'] = "Es sind keine Banner angelegt, da es noch keine Kampagnen gibt. Um einen Banner anzulegen, müssen Sie zuerst eine <a href='campaign-edit.php?clientid=%s'>neue Kampagne hinzufügen</a>.";
$GLOBALS['strNoBannersAddAdvertiser'] = "Es sind keine Banner angelegt, da es noch keine Werbetreibenden gibt. Um einen Banner anzulegen, müssen Sie zuerst einen <a href='advertiser-edit.php'>neue Werbetreibenden hinzufügen</a>.";
$GLOBALS['strConfirmDeleteBanner'] = "Soll dieser Banner wirklich gelöscht werden?";
$GLOBALS['strConfirmDeleteBanners'] = "Möchten Sie die ausgewählten Banner wirklich löschen?";
$GLOBALS['strConfirmDeleteAllBanners'] = "Sollen tatsächlich alle Banner dieser Kampagne gelöscht werden?";
$GLOBALS['strConfirmResetBannerStats'] = "Sollen tatsächlich alle Statistiken für diesen Banner gelöscht werden?";
$GLOBALS['strShowParentCampaigns'] = "Zugehörige Kampagnen anzeigen";
$GLOBALS['strHideParentCampaigns'] = "Zugehörige Kampagnen verbergen";
$GLOBALS['strHideInactiveBanners'] = "Inaktive Banner verbergen";
$GLOBALS['strInactiveBannersHidden'] = "inaktive Banner sind verborgen";
$GLOBALS['strAppendOthers'] = "Andere anhängen";
$GLOBALS['strAppendTextAdNotPossible'] = "Es ist nicht möglich, ein Banner an eine Textanzeige anzuhängen.";
$GLOBALS['strHiddenBanner'] = "verborgene Werbemittel";
$GLOBALS['strWarningTag1'] = "Warnung, Tag";
$GLOBALS['strWarningTag2'] = "wahrscheinlich nicht geschlossen/geöffnet";
$GLOBALS['strWarningMissing'] = "Warnung, wahrscheinlich fehlt ";
$GLOBALS['strWarningMissingClosing'] = "der schließender HTML-Tag '>'";
$GLOBALS['strWarningMissingOpening'] = "der öffnende HTML-Tag '<'";
$GLOBALS['strSubmitAnyway'] = "Trotzdem absenden?";
$GLOBALS['strOverallBanners'] = "Banner";
$GLOBALS['strBannerPreferences'] = "Voreinstellungen Banner";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Bannertype auswählen";
$GLOBALS['strMySQLBanner'] = "Einen lokal gespeicherten Banner in Datenbank laden";
$GLOBALS['strWebBanner'] = "Einen lokal gespeicherten Banner auf den Webserver laden";
$GLOBALS['strURLBanner'] = "Verlinke einen externen Banner";
$GLOBALS['strHTMLBanner'] = "Einen HTML-Banner anlegen";
$GLOBALS['strTextBanner'] = "Einen Text-Banner anlegen";
$GLOBALS['strUploadOrKeep'] = "Soll die vorhandene <br />Bilddatei behalten werden, oder soll <br />ein neues geladen werden?";
$GLOBALS['strUploadOrKeepAlt'] = "Wollen Sie die bestehende<br />Bilddatei behalten oder<br />eine neue hochladen?";
$GLOBALS['strNewBannerFile'] = "Wählen Sie die Bilddatei <br />für dieses Banner<br /><br />";
$GLOBALS['strNewBannerFileAlt'] = "Wählen Sie eine Alternativdatei (JPG, GIF, ...) aus<br />für den Fall, daß ein Besucher<br />das RichMedia-Werbemittel nicht darstellen kann<br /><br />";
$GLOBALS['strNewBannerURL'] = "Bild-URL (incl. http://)";
$GLOBALS['strURL'] = "Ziel-URL (incl. http://)";
$GLOBALS['strKeyword'] = "Schlüsselwörter";
$GLOBALS['strTextBelow'] = "Text unterhalb Banner";
$GLOBALS['strWeight'] = "Gewichtung";
$GLOBALS['strAlt'] = "Alt-Text";
$GLOBALS['strStatusText'] = "Status-Text";
$GLOBALS['strBannerWeight'] = "Bannergewichtung";
$GLOBALS['strBannerType'] = "Werbemitteltyp";
$GLOBALS['strAdserverTypeGeneric'] = "Standard HTML-Banner";
$GLOBALS['strGenericOutputAdServer'] = "Generisch";
$GLOBALS['strSwfTransparency'] = "Transparenten Hintergrund zulassen";
$GLOBALS['strBackToBanners'] = "Zurück zu den Bannern";

// Banner (advanced)

// Banner (swf)
$GLOBALS['strCheckSWF'] = "Prüfung auf direkte Links (hard-coded) innerhalb der Flash-Datei";
$GLOBALS['strConvertSWFLinks'] = "direkten Flash-Link konvertieren";
$GLOBALS['strHardcodedLinks'] = "direkter Link (hard-coded)";
$GLOBALS['strConvertSWF'] = "<br />
In der gerade geladenen Flash-Datei befinden sich direkte URL-Links (hard-coded). Direkte URL-Links können von {$PRODUCT_NAME} nicht aufgezeichnet werden. Sie müssen hierfür entsprechend konvertiert werden. Nachfolgend finden Sie eine Auflistung aller URL-Links innerhalb der Flash-Datei. Für die Konvertierung dieser URL-Links muß <i><b>Konvertieren</i></b> geklickt werden. Mit <i><b>Abbrechen</i></b> wird der Vorgang ohne Veränderung des Banners beendet.<br /><br />
Bitte beachten Sie, daß die Flash-Datei nach <i><b>Konvertieren</i></b> im Programmcode verändert ist. Erstellen Sie vorab eine Sicherungskopie. Unabhängig der verwendeten Flash-Version benötigt die neu erstellte Flash-Datei für eine korrekte Darstellung Flash 4 oder höher.<br /><br />";
$GLOBALS['strCompressSWF'] = "Komprimieren der SWF-Datei für eine schnellere Übertragung zum Browser (Flash-Player 6 wird benötigt)";
$GLOBALS['strOverwriteSource'] = "Überschreiben der Parameter im Quelltext";
$GLOBALS['strLinkToShort'] = "Warnung: Direkte URL-Links gefunden - Die Links sind zu kurz, um automatisch konvertiert zu werden.";

// Banner (network)
$GLOBALS['strBannerNetwork'] = "HTML-Template";
$GLOBALS['strChooseNetwork'] = "Auswahl des HTML-Template";
$GLOBALS['strMoreInformation'] = "Weitere Informationen...";
$GLOBALS['strTrackAdClicks'] = "Aufzeichen der AdClicks";

// Banner (AdSense)
$GLOBALS['strAdSenseAccounts'] = "Google AdSense Benutzerkonto";
$GLOBALS['strLinkAdSenseAccount'] = "Verknüpfe Google AdSense Benutzerkonto";
$GLOBALS['strCreateAdSenseAccount'] = "Google AdSense Benutzerkonto anlegen";
$GLOBALS['strEditAdSenseAccount'] = "Google AdSense Benutzerkonto ändern";

// Display limitations
$GLOBALS['strModifyBannerAcl'] = "Auslieferungsoptionen";
$GLOBALS['strACL'] = "Bannerauslieferung";
$GLOBALS['strACLAdd'] = "Auslieferungsbeschränkung hinzufügen";
$GLOBALS['strACLAdd_Key'] = " <u>N</u>eue Beschränkung hinzufügen ";
$GLOBALS['strNoLimitations'] = "Keine Beschränkungen";
$GLOBALS['strApplyLimitationsTo'] = "Beschränkungen anwenden bei";
$GLOBALS['strRemoveAllLimitations'] = "Alle Beschränkungen löschen";
$GLOBALS['strEqualTo'] = "ist gleich";
$GLOBALS['strDifferentFrom'] = "ist ungleich";
$GLOBALS['strLaterThan'] = "ist später als";
$GLOBALS['strLaterThanOrEqual'] = "ist später als oder gleichzeitig mit";
$GLOBALS['strEarlierThan'] = "ist früher als";
$GLOBALS['strEarlierThanOrEqual'] = "ist früher als oder gleichzeitig mit";
$GLOBALS['strContains'] = "beinhaltet";
$GLOBALS['strNotContains'] = "beinhaltet nicht";
$GLOBALS['strGreaterThan'] = "ist größer als";
$GLOBALS['strLessThan'] = "ist kleiner als";
$GLOBALS['strAND'] = "UND";                          // logical operator
$GLOBALS['strOR'] = "ODER";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Diesen Banner nur anzeigen, wenn:";
$GLOBALS['strWeekDay'] = "Wochentag";
$GLOBALS['strWeekDays'] = "Wochentage";
$GLOBALS['strTime'] = "Zeit";
$GLOBALS['strUserAgent'] = "Browsertype";
$GLOBALS['strClientIP'] = "IP-Adresse";
$GLOBALS['strSource'] = "Quelle";
$GLOBALS['strSourceFilter'] = "Filtern nach Quelle";
$GLOBALS['strOS'] = "BS";
$GLOBALS['strCountryCode'] = "Ländercode (ISO 3166)";
$GLOBALS['strCountryName'] = "Ländername";
$GLOBALS['strRegion'] = "Regionalcode (ISO-3166-2 or FIPS 10-4)";
$GLOBALS['strCity'] = "Stadt";
$GLOBALS['strLatitude'] = "Breitengrad";
$GLOBALS['strLongitude'] = "Längengrad";
$GLOBALS['strDMA'] = "DMA Code (nur USA)";
$GLOBALS['strArea'] = "Telephonvorwahl (nur USA)";
$GLOBALS['strOrg'] = "Firmenname";
$GLOBALS['strIsp'] = "ISP-Name";
$GLOBALS['strNetspeed'] = "Verbindungsgeschwindigkeit";
$GLOBALS['strReferer'] = "Referenzseite";
$GLOBALS['strDeliveryLimitations'] = "Auslieferungsbeschränkungen";

$GLOBALS['strDeliveryCapping'] = "Kappung der Auslieferung per User";
$GLOBALS['strDeliveryCappingReset'] = "Rücksetzen AdView-Zählers nach";
$GLOBALS['strDeliveryCappingTotal'] = "insgesamt";
$GLOBALS['strDeliveryCappingSession'] = "pro Session";

$GLOBALS['strCappingBanner'] = array();
$GLOBALS['strCappingBanner']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingBanner']['limit'] = "Banner Ausliferungen kappen auf:";

$GLOBALS['strCappingCampaign'] = array();
$GLOBALS['strCappingCampaign']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingCampaign']['limit'] = "Kampagnen kappen auf:";

$GLOBALS['strCappingZone'] = array();
$GLOBALS['strCappingZone']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingZone']['limit'] = "Zone kappen auf:";

// Website
$GLOBALS['strAffiliate'] = "Webseite";
$GLOBALS['strAffiliates'] = "Webseiten";
$GLOBALS['strAffiliatesAndZones'] = "Webseiten & Zonen";
$GLOBALS['strAddNewAffiliate'] = "Neuen Webseite anlegen";
$GLOBALS['strAddNewAffiliate_Key'] = "<u>N</u>euen Webseite anlegen";
$GLOBALS['strAddAffiliate'] = "Webseite anlegen";
$GLOBALS['strAffiliateProperties'] = "Webseite Merkmale";
$GLOBALS['strAffiliateOverview'] = "Übersicht Webseiten";
$GLOBALS['strAffiliateHistory'] = "Entwicklung Webseite";
$GLOBALS['strZonesWithoutAffiliate'] = "Zonen ohne Webseite";
$GLOBALS['strMoveToNewAffiliate'] = "Verschiebe zu neuer Webseite";
$GLOBALS['strNoAffiliates'] = "Es sind keine Webseiten angelegt. Um eine Zone anzulegen, müssen Sie zuerst eine <a href='affiliate-edit.php'>Webseite hinzufügen</a>.";
$GLOBALS['strConfirmDeleteAffiliate'] = "Soll diese Webseite tatsächlich gelöscht werden?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Möchten Sie die ausgewählten Webseiten wirklich löschen?";
$GLOBALS['strMakePublisherPublic'] = "Mache die Zonen dieses Webseite öffentlich zugänglich ";
$GLOBALS['strAffiliateInvocation'] = "Bannercode";
$GLOBALS['strAdvertiserSetup'] = "Anmeldung Werbetreibender";
$GLOBALS['strTotalAffiliates'] = "Alle Webseiten";
$GLOBALS['strInactiveAffiliatesHidden'] = "Inaktive Webseiten ausgeblendet";
$GLOBALS['strShowParentAffiliates'] = "Zugehörige Webseiten anzeigen";
$GLOBALS['strHideParentAffiliates'] = "Zugehörige Webseite verbergen";

// Website (properties)
$GLOBALS['strWebsite'] = "Webseite";
$GLOBALS['strWebsiteURL'] = "URL der Webseite";
$GLOBALS['strMnemonic'] = "Kürzel";
$GLOBALS['strAllowAffiliateModifyInfo'] = "Werbetreibender darf eigene Einstellungen verändern";
$GLOBALS['strAllowAffiliateModifyZones'] = "Werbeträger darf eigene Zonen ändern ";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Werbeträger darf Banner seinen Zonen hinzufügen ";
$GLOBALS['strAllowAffiliateAddZone'] = "Werbeträger darf neue eigene Zonen hinzufügen ";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Werbeträger darf eigene Zonen löschen ";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Werbeträger darf Bannercode erstellen";
$GLOBALS['strAllowAffiliateZoneStats'] = "Werbeträger darf Zonen Statistiken einsehen";
$GLOBALS['strAllowAffiliateApprPendConv'] = "Werbeträger darf nur bestätigte oder noch anhängige Konversionen einsehen";

// Website (properties - payment information)
$GLOBALS['strPaymentInformation'] = "Zahlungsinformationen";
$GLOBALS['strAddress'] = "Adresse";
$GLOBALS['strPostcode'] = "PLZ";
$GLOBALS['strCity'] = "Stadt";
$GLOBALS['strCountry'] = "Land";
$GLOBALS['strPhone'] = "Telefon";
$GLOBALS['strAccountContact'] = "Kundenkontakt";
$GLOBALS['strPayeeName'] = "Zahlungsempfänger";
$GLOBALS['strTaxID'] = "Steuer-Nr.";
$GLOBALS['strModeOfPayment'] = "Zahlungsart";
$GLOBALS['strPaymentChequeByPost'] = "Scheck";
$GLOBALS['strCurrency'] = "Währung";

// Website (properties - other information)
$GLOBALS['strOtherInformation'] = "Weitere Informationen";
$GLOBALS['strUniqueUsersMonth'] = "Eindeutige Besucher pro Monat";
$GLOBALS['strUniqueViewsMonth'] = "AdViews pro Monat";
$GLOBALS['strPageRank'] = "Google Pagerank";
$GLOBALS['strCategory'] = "Kategorie";
$GLOBALS['strPrimaryCategory'] = "Hauptkategorie";
$GLOBALS['strSecondaryCategory'] = "Unterkategorie";
$GLOBALS['strHelpFile'] = "Hilfedatei";
$GLOBALS['strApprovedTandC'] = "AGB zugestimmt";
$GLOBALS['strWebsiteZones'] = "Zonen der Webseite";

// Zone
$GLOBALS['strChooseZone'] = "Zone wählen";
$GLOBALS['strZone'] = "Verborgene Zone";
$GLOBALS['strZones'] = "Zonen";
$GLOBALS['strAddNewZone'] = "Neue Zone hinzufügen";
$GLOBALS['strAddNewZone_Key'] = "<u>N</u>eue Zone hinzufügen";
$GLOBALS['strAddZone'] = "Zone erstellen";
$GLOBALS['strModifyZone'] = "Zone ändern";
$GLOBALS['strZoneToWebsite'] = "Zur Webseite";
$GLOBALS['strLinkedZones'] = "Verknüpfte Zonen";
$GLOBALS['strAvailableZones'] = "Verfügbare Zonen";
$GLOBALS['strLinkingNotSuccess'] = "Verlinkung nicht erfolgreich, bitte versuchen Sie es erneut";
$GLOBALS['strZoneOverview'] = "Übersicht Zonen";
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
$GLOBALS['strTextAdZone'] = "Textanzeige";
$GLOBALS['strEmailAdZone'] = "E-Mail/Newsletter";
$GLOBALS['strZoneClick'] = "Klick-Zähler-Zone";
$GLOBALS['strShowMatchingBanners'] = "Anzeige zugehörende Banner";
$GLOBALS['strHideMatchingBanners'] = "Verbergen zugehörende Banner";
$GLOBALS['strBannerLinkedAds'] = "Mit dieser Zone verknüpfte Werbemittel";
$GLOBALS['strCampaignLinkedAds'] = "Mit dieser Zone verknüpfte Kampagnen";
$GLOBALS['strTotalZones'] = "Alle Zonen";
$GLOBALS['strInactiveZonesHidden'] = "deaktivierte Zone(n) verborgen";
$GLOBALS['strWarnChangeZoneType'] = "Die Änderung der Zone auf EMail/Newsletter entfernt alle verknüpften Banner/Kampagnen aufgrund der folgenden Restriktionenen dieses Zonentyps
<ul>
<li>Text-Zonen können nur mit Text-Bannern verknüpft werden</li>
<li>Kampagnen für EMail-Zonen dürfen jeweils nur einen aktiven Banner haben</li>
</ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Die Änderung der Zonengröße wird die Verknüpfung zu allen Bannern aufheben die nicht der neuen Größe entsprechen und alle Banner aus verknüpften Kampagnen hinzufügen die mit der neuen Größe übereinstimmen.';
$GLOBALS['strWarnChangeBannerSize'] = 'Eine Änderung der Bannergröße hebt die Verlinkung dieses Banners mit allen Zonen auf, die dieser Größe nicht entsprechen. Wenn die <b>Kampagne</b> dieses Banners mit einer Zone der neuen Größe verlinkt ist, ist dieser Banner automatisch mit verlinkt.';
$GLOBALS['strWarnBannerReadonly'] = 'Dieser Banner kann nicht geändert werden da eine nötige Erweiterung deaktiviert wurde. Bitte kontaktieren Sie Ihren Administrator für weitere Informationen.';
$GLOBALS['strInventoryForecasting'] = 'Vorausplanung des Bannerbestands';


// Advanced zone settings
$GLOBALS['strAdvanced'] = "Erweiterte Merkmale";
$GLOBALS['strChains'] = "Verkettung";
$GLOBALS['strChainSettings'] = "Verkettungseinstellungen";
$GLOBALS['strZoneNoDelivery'] = "Wenn kein Banner dieser Zone <br />ausgeliefert werden kann, dann...";
$GLOBALS['strZoneStopDelivery'] = "stoppe die Werbemittelauslieferung und zeige kein Werbemittel an.";
$GLOBALS['strZoneOtherZone'] = "zeige statt dessen die Werbemittel der unten gewählten Zone an.";
$GLOBALS['strZoneUseKeywords'] = "Banner auswählen, welches nachfolgende Schlüsselwörter hat ";
$GLOBALS['strZoneAppend'] = "Immer diesen HTML-Code den Bannern aus dieser Zone anhängen ";
$GLOBALS['strAppendSettings'] = "HTML-Ergänzungen (Anhängen und Voranstellen)";
$GLOBALS['strZoneForecasting'] = "Einstellung Zonenprognose";
$GLOBALS['strZonePrependHTML'] = "Immer diesen HTML-Code den Testanzeigen aus dieser Zone voranstellen ";
$GLOBALS['strZoneAppendHTML'] = "Immer diesen HTML-Code den Testanzeigen aus dieser Zone anhängen ";
$GLOBALS['strZoneAppendNoBanner'] = "Hinzufügen, auch wenn kein Banner ausgeliefert wird";
$GLOBALS['strZoneAppendType'] = "Type (Anhang)";
$GLOBALS['strZoneAppendHTMLCode'] = "HTML-Code";
$GLOBALS['strZoneAppendZoneSelection'] = "Pop-Up oder Interstitial";
$GLOBALS['strZoneAppendSelectZone'] = "Immer das nebenstehende Pop-Up oder Intersitial-Banner zusätzlich mit den Bannern dieser Zone ausliefern";

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
$GLOBALS['strInteractive'] = "Interaktive";
$GLOBALS['strRawQueryString'] = "Schlüsselwort";
$GLOBALS['strIncludedBanners'] = "Verknüpfte Banner";
$GLOBALS['strLinkedBannersOverview'] = "Übersicht verknüpfte Banner";
$GLOBALS['strLinkedBannerHistory'] = "Entwicklung Banner";
$GLOBALS['strNoZonesToLink'] = "Es sind keine Zonen vorhanden, denen der Banner zugeordnet werden kann";
$GLOBALS['strNoBannersToLink'] = "Es sind derzeit keine Banner vorhanden, die dieser Zone zugeordnet werden können";
$GLOBALS['strNoLinkedBanners'] = "Es sind keine Banner dieser Zone zugeordnet (mit ihr verknüpft)";
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
$GLOBALS['strTrackerCode'] = "Liefere folgenden Code zusätzlich zu jeder Auslieferung eines Javascript Trackers aus.";
$GLOBALS['strTrackerCodeSubject'] = "Tracker Code anhängen";
$GLOBALS['strAppendTrackerNotPossible'] = "Es ist nicht möglich diesen Tracker anzuhängen.";
$GLOBALS['strStatusPending'] = "wartet auf Überprüfung";
$GLOBALS['strStatusApproved'] = "Freigegeben";
$GLOBALS['strStatusDisapproved'] = "Abgelehnt";
$GLOBALS['strStatusDuplicate'] = "Kopieren";
$GLOBALS['strStatusOnHold'] = "in der Warteschleife";
$GLOBALS['strStatusIgnore'] = "Ignorieren";
$GLOBALS['strConnectionType'] = "Art";
$GLOBALS['strConnTypeSignUp'] = "Anmeldung";
$GLOBALS['strShortcutEditStatuses'] = "Status bearbeiten";
$GLOBALS['strShortcutShowStatuses'] = "Status anzeigen";

// Statistics
$GLOBALS['strStats'] = "Statistiken";
$GLOBALS['strNoStats'] = "Zur Zeit sind keine Statistiken vorhanden";
$GLOBALS['strNoTargetingStats'] = "Zur Zeit sind keine Ziel-Statistiken vorhanden";
$GLOBALS['strNoStatsForPeriod'] = "Es sind derzeit keine Statistiken für den Zeitraum %s bis %s vorhanden";
$GLOBALS['strNoTargetingStatsForPeriod'] = "Es sind derzeit keine Ziel Statistiken für den Zeitraum %s bis %s vorhanden";
$GLOBALS['strConfirmResetStats'] = "Sollen tatsächlich alle vorhandenen Statistiken gelöscht werden?";
$GLOBALS['strGlobalHistory'] = "Bisherige Entwicklung";
$GLOBALS['strDailyHistory'] = "Entwicklung Tag";
$GLOBALS['strDailyStats'] = "Tagesstatistik";
$GLOBALS['strWeeklyHistory'] = "Entwicklung Woche";
$GLOBALS['strMonthlyHistory'] = "Entwicklung Monat";
$GLOBALS['strCreditStats'] = "Guthabenstatistik";
$GLOBALS['strDetailStats'] = "Detaillierte Statistik";
$GLOBALS['strTotalThisPeriod'] = "Summe in der Periode";
$GLOBALS['strAverageThisPeriod'] = "Durchschnitt in der Periode";
$GLOBALS['strPublisherDistribution'] = "Verteilung auf die Webseiten";
$GLOBALS['strCampaignDistribution'] = "Verteilung auf die Kampagnen";
$GLOBALS['strDistributionBy'] = "Verteilung nach";
$GLOBALS['strResetStats'] = "Statistiken zurücksetzen";
$GLOBALS['strSourceStats'] = "Quellstatistiken";
$GLOBALS['strSources'] = "Quellen";
$GLOBALS['strAvailableSources'] = "Verfügbare Quellen";
$GLOBALS['strSelectSource'] = "Auswahl der Quelle, die angezeigt werden soll:";
$GLOBALS['strSizeDistribution'] = "Verteilung nach Größe";
$GLOBALS['strCountryDistribution'] = "Verteilung nach Land";
$GLOBALS['strEffectivity'] = "Effektivität";
$GLOBALS['strTargetStats'] = "Zielstatistiken";
$GLOBALS['strCampaignTarget'] = "Ziel";
$GLOBALS['strTargetRatio'] = "Ziel im Verhältnis";
$GLOBALS['strTargetModifiedDay'] = "Die Ziele wurden an diesem Tag verändert. Die Berechnungen können u.U. nicht korrekt sein";
$GLOBALS['strTargetModifiedWeek'] = "Die Ziele wurden in dieser Woche verändert. Die Berechnungen können u.U. nicht korrekt sein";
$GLOBALS['strTargetModifiedMonth'] = "Die Ziele wurden in diesem Monat verändert. Die Berechnungen können u.U. nicht korrekt sein";
$GLOBALS['strNoTargetStats'] = "Es sind derzeit keine Statistiken für Ziele vorhanden ";
$GLOBALS['strOVerall'] = "Gesamt";
$GLOBALS['strByZone'] = "Nach Zone";
$GLOBALS['strImpressionsRequestsRatio'] = "Verhältnis Views/Requests (%)";
$GLOBALS['strViewBreakdown'] = "Nach Views";
$GLOBALS['strBreakdownByDay'] = "Tag";
$GLOBALS['strBreakdownByWeek'] = "Woche";
$GLOBALS['strBreakdownByMonth'] = "Monat";
$GLOBALS['strBreakdownByDow'] = "Wochentag";
$GLOBALS['strBreakdownByHour'] = "Stunde";
$GLOBALS['strItemsPerPage'] = "Anzeigen pro Seite";
$GLOBALS['strDistributionHistory'] = "Entwicklung der Verteilung";
$GLOBALS['strDistributionHistoryCampaign'] = "Auslieferungsverlauf (Kampagne)";
$GLOBALS['strDistributionHistoryBanner'] = "Auslieferungsverlauf (Banner)";
$GLOBALS['strDistributionHistoryWebsite'] = "Auslieferungsverlauf (Webseite)";
$GLOBALS['strDistributionHistoryZone'] = "Auslieferungsverlauf (Zone)";
$GLOBALS['strShowGraphOfStatistics'] = "Statistiken <u>g</u>raphisch darstellen";
$GLOBALS['strExportStatisticsToExcel'] = "Statistiken nach Excel <u>e</u>xportieren";
$GLOBALS['strGDnotEnabled'] = "Um grafische Statistiken anzeigen zu können, muss in PHP die GD Erweiterung aktiviert sein. <br />Bitte schauen Sie bei <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> für weitere Informationen.";
$GLOBALS['strTTFnotEnabled'] = "Sie haben die GD-Erweiterung in PHP aktiviert, jedoch gibt es ein Problem mit der Freetype Unterstützung.<br />FreeType wird benötigt, um grafische Statistiken anzuzeigen. Bitte kontrollieren Sie Ihre Server Konfiguration.";
$GLOBALS['strStatsArea'] = "Bereich";

// Hosts
$GLOBALS['strHosts'] = "Besucherhost";
$GLOBALS['strTopHosts'] = "Aktivsten Besucherhosts";
$GLOBALS['strTopCountries'] = "Aktivsten Länder";
$GLOBALS['strRecentHosts'] = "Besucherhost mit den größten Anfragen";

// Expiration
$GLOBALS['strExpired'] = "Ausgelaufen";
$GLOBALS['strExpiration'] = "Auslaufdatum";
$GLOBALS['strNoExpiration'] = "Kein Auslaufdatum festgelegt";
$GLOBALS['strEstimated'] = "Voraussichtliches Auslaufdatum";
$GLOBALS['strNoExpirationEstimation'] = "Noch kein Ablaufen abgeschätzt";
$GLOBALS['strDaysAgo'] = "Tage her";
$GLOBALS['strCampaignStop'] = "Kampagnen Ende";

// Reports
$GLOBALS['strReports'] = "Berichte";
$GLOBALS['strAdvancedReports'] = "Erweiterte Berichte";
$GLOBALS['strAdminReports'] = "Berichte für Administratoren";
$GLOBALS['strAdvertiserReports'] = "Berichte für Werbetreibende";
$GLOBALS['strAgencyReports'] = "Berichte für Agenturen";
$GLOBALS['strPublisherReports'] = "Berichte: Webseiten";
$GLOBALS['strSelectReport'] = "Wählen Sie den zu erstellenden Bericht";
$GLOBALS['strStartDate'] = "Startdatum";
$GLOBALS['strEndDate'] = "Enddatum";
$GLOBALS['strNoData'] = "Für den ausgewählten Zeitraum liegen keine Daten vor.";
$GLOBALS['strPeriod'] = "Zeitraum";
$GLOBALS['strLimitations'] = "Einschränkungen";
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
$GLOBALS['strTrackercode'] = "Den folgenden Javascript-Code an jede Tracker-Impression anhängen";
$GLOBALS['strBackToTheList'] = "Zurück zur Berichtsliste";
$GLOBALS['strGoToReportBuilder'] = "Zum ausgew�hlten Bericht";
$GLOBALS['strCharset'] = "Zeichensatz";
$GLOBALS['strAutoDetect'] = "automatisch herausfinden";
$GLOBALS['strCacheBusterComment'] = "  * Ersetzen Sie alle Vorkommen von {random} mit
  * einem generierten Zufallswert (oder Zeitstempel).
  *";
$GLOBALS['strSSLBackupComment'] = "* Der Ersatzbannerbereich dieses Bannercodes wurde für eine nicht-SSL	* Webseite generiert. Wenn Sie den Bannercode auf eine SSL-Webseite	* plazieren, ändern Sie bitte alle Vorkommen von	*   'http://%s/...' 	* in 	*   'https://%s/...' 	*";
$GLOBALS['strSSLDeliveryComment'] = "* Dieser Bannercodes wurde für eine nicht-SSL	* Webseite generiert.	* Wenn Sie den Bannercode auf eine SSL-Webseite plazieren, ändern Sie	* bitte alle Vorkommen von	*   'http://%s/...' 	* in 	*   'https://%s/...' 	*";

$GLOBALS['strThirdPartyComment'] = "* Bitte vergessen Sie nicht den Text '{clickurl}' mit	* der Klick-Tracking-URL zu ersetzen, falls dieses Werbemittel	* über einen anderen (nicht OpenX) AdServer ausgeliefert wird.	*";

// Errors
$GLOBALS['strMySQLError'] = "SQL Fehler:";
$GLOBALS['strErrorDatabaseConnetion'] = "Datenbankverbindungsfehler.";
$GLOBALS['strErrorCantConnectToDatabase'] = "Es wurde ein schwerwiegender Fehler festgestellt: %s kann keine Verbindung zur Datenbank herstellen. Aus diesem Grund ist es nicht möglich die Benutzeroberfläche des Administrators zu verwenden. Die Bannerauslieferung könnte ebenfalls betroffen sein. Mögliche Ursachen für dieses Problem sind:<ul><li>Der Datenbankserver ist heruntergefahren oder nicht verfügbar</li><li>Die Adresse des Datenbankservers hat sich geändert</li><li>Der Benutzername oder das Passwort für die datenbank hat sich geändert</li><li>PHP hat die Datenbankextension (MySQL) nicht geladen</li></ul>";
$GLOBALS['strLogErrorClients'] = "[phpAds] Ein Fehler ist beim Versuch aufgetreten, den Werbetreibenden aus der Datenbank zu laden.";
$GLOBALS['strLogErrorBanners'] = "[phpAds] Ein Fehler ist beim Versuch aufgetreten, den Banner aus der Datenbank zu laden.";
$GLOBALS['strLogErrorViews'] = "[phpAds] Ein Fehler ist beim Versuch aufgetreten, die AdViews aus der Datenbank zu laden.";
$GLOBALS['strLogErrorClicks'] = "[phpAds] Ein Fehler ist beim Versuch aufgetreten, die AdClicks aus der Datenbank zu laden.";
$GLOBALS['strLogErrorConversions'] = "[phpAds] Beim Auslesen der Konversionsraten aus der Datenbank trat ein Fehler auf.";
$GLOBALS['strErrorViews'] = "Sie müssen die Anzahl der AdViews eingeben oder unbegrenzt wählen!";
$GLOBALS['strErrorNegViews'] = "Negative AdViews sind nicht möglich";
$GLOBALS['strErrorClicks'] = "Sie müssen die Anzahl der AdClicks eingeben oder unbegrenzt wählen!";
$GLOBALS['strErrorNegClicks'] = "Negative AdClicks sind nicht möglich";
$GLOBALS['strErrorConversions'] = "Bitte geben Sie die Zahl der Konversinen ein oder markieren Sie das Feld unlimitiert!";
$GLOBALS['strErrorNegConversions'] = "Negative Konversionen sind nicht zulässig.";
$GLOBALS['strNoMatchesFound'] = "Kein Objekt gefunden";
$GLOBALS['strErrorOccurred'] = "Ein Fehler ist aufgetreten";
$GLOBALS['strErrorUploadSecurity'] = "Ein mögliches Sicherheitsproblem wurde erkannt. Ladevorgang (Upload) wurde gestoppt!";
$GLOBALS['strErrorUploadBasedir'] = "Zugriff auf die zu ladende Datei konnte nicht erfolgen. Die Ursache liegt möglicherweise im <i>safemode </i> oder der Einschränkung von <i>open_basedir </i>";
$GLOBALS['strErrorUploadUnknown'] = "Zugriff auf die zu ladende Datei konnte aus unbekanntem Grund nicht erfolgen. Bitte die PHP-Konfiguration prüfen.";
$GLOBALS['strErrorStoreLocal'] = "Ein Fehler ist beim Versuch aufgetreten, den Banner in das lokale Verzeichnis zu speichern. Möglicherweise ist in der Konfiguration der lokale Verzeichnispfad nicht korrekt eingegeben.";
$GLOBALS['strErrorStoreFTP'] = " Ein Fehler ist beim Versuch aufgetreten, den Banner zum FTP-Server zu übertragen.. Möglicherweise ist der FTP-Server nicht verfügbar oder in der Konfiguration erfolgte die Einstellung für den FTP-Server nicht korrekt ";
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
$GLOBALS['strErrorBadUserType'] = "Das System war nicht in der Lage, Ihren Nutzertyp zu identifizieren!";
$GLOBALS['strErrorLinkingBanner'] = "Es gab Fehler bei der Verknüpfung von Bannern mit Zonen:";
$GLOBALS['strUnableToLinkBanner'] = "Folgende Verknüpfung(en) sind fehlgeschlagen: ";
$GLOBALS['strErrorEditingCampaign'] = "Fehler beim Aktualisieren der Kampagne:";
$GLOBALS['strUnableToChangeCampaign'] = "Diese Änderung ist unwirksam weil:";
$GLOBALS['strErrorEditingCampaignRevenue'] = "Ungültiges Zahlenformat im Feld Umsatzinformationen";
$GLOBALS['strErrorEditingZone'] = "Fehler beim Update der Zone:";
$GLOBALS['strUnableToChangeZone'] = "Diese Änderung ist unwirksam weil:";
$GLOBALS['strDatesConflict'] = "Datumskonflikt mit:";
$GLOBALS['strEmailNoDates'] = "E-Mail- und Newsletter-Kampagnen müssen ein Start- und ein Enddatum haben.";
$GLOBALS['strWarningInaccurateStats'] = "Einige der Statistikdaten sind nicht in der UTC-Zeitzone erfasst worden. Diese werden möglicherweise nicht in der richtigen Zeitzone dargestellt.";
$GLOBALS['strWarningInaccurateReadMore'] = "Lesen Sie mehr hierüber";
$GLOBALS['strWarningInaccurateReport'] = "Einige der Statistikdaten dieses Berichts sind nicht in der UTC-Zeitzone erfasst worden. Diese werden möglicherweise nicht in der richtigen Zeitzone dargestellt.";

//Validation
$GLOBALS['strRequiredFieldLegend'] = "bezeichnet ein erforderliches Feld";
$GLOBALS['strFormContainsErrors'] = "Diese Seite enthält Fehler, bitte berichtigen Sie die unten markierten Eingabefelder.";
$GLOBALS['strRequiredField'] = "Benötigtes Eingabefeld";
$GLOBALS['strXRequiredField'] = "%s ist erforderlich";
$GLOBALS['strEmailField'] = "Bitte geben Sie eine gültige E-Mail Adresse ein";
$GLOBALS['strNumericField'] = "Bitte geben Sie einen numerischen Wert ein (nur Ziffern sind erlaubt)";
$GLOBALS['strGreaterThanZeroField'] = "Muß größer als 0 sein";
$GLOBALS['strXGreaterThanZeroField'] = "%s muß größer als 0 sein";
$GLOBALS['strXPositiveWholeNumberField'] = "%s muß eine positive ganze Zahl sein";
$GLOBALS['strXUniqueField'] = "%s zusammen mit %s existiert bereits";
$GLOBALS['strXDecimalFieldWithDecimalPlaces'] = "Muß ein numerischer Wert mit maximal %s Stellen sein";
$GLOBALS['strInvalidWebsiteURL'] = "Ungültige Webseiten-URL";


// Email
$GLOBALS['strSirMadam'] = "Sehr geehrte Damen und Herren";
$GLOBALS['strMailSubject'] = "Bericht für Werbetreibende";
$GLOBALS['strAdReportSent'] = "Bericht für Werbetreibende versandt";
$GLOBALS['strMailHeader'] = "Sehr geehrte(r) {contact},";
$GLOBALS['strMailBannerStats'] = "Sie erhalten nachfolgend die Bannerstatistik für {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Kampagne aktiviert";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Kampagne deaktiviert";
$GLOBALS['strMailBannerActivated'] = "Die unten angegebene Kampagne wurde aktiviert, weil
das Kampagnen Startdatum erreicht wurde.";
$GLOBALS['strMailBannerDeactivated'] = "Die unten angegebene Kampagne wurde deaktiviert, weil";
$GLOBALS['strMailFooter'] = "Mit freundlichem Gruß
   {adminfullname}";
$GLOBALS['strMailClientDeactivated'] = "Die folgenden Banner wurden deaktiviert, weil";
$GLOBALS['strMailNothingLeft'] = "Wir danken für Ihr Vertrauen, das wir Ihre Werbung auf unseren WEB-Seiten präsentieren durften. Gern werden wir Ihnen weiterhin zur Verfügung stehen.";
$GLOBALS['strClientDeactivated'] = "Diese Kampagne ist zur Zeit nicht aktiv, weil";
$GLOBALS['strBeforeActivate'] = "das Aktivierungsdatum noch nicht erreicht wurde ";
$GLOBALS['strAfterExpire'] = "das Auslaufdatum erreicht wurde ";
$GLOBALS['strNoMoreImpressions'] = "Alle gebuchten Impressions sind aufgebraucht";
$GLOBALS['strNoMoreClicks'] = "Alle gebuchten Klicks sind aufgebraucht";
$GLOBALS['strNoMoreConversions'] = "Alle gebuchten Konversionen sind aufgebraucht";
$GLOBALS['strWeightIsNull'] = "die Gewichtung auf 0 (Null) gesetzt wurde.";
$GLOBALS['strTargetIsNull'] = "das Tageslimit ist auf null gesetzt - Sie müssen entweder ein Enddatum und eine Wert oder ein Tageslimit erfassen";
$GLOBALS['strWarnClientTxt'] = "Die AdClicks, AdViews oder Konversionen für Ihre Banner haben das Limit von {limit} erreicht.
. ";
$GLOBALS['strImpressionsClicksConversionsLow'] = "Die Zahl der zur Verfügung stehenden Impressions/Klicks/Konversionen geht zur Neige.";
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
$GLOBALS['strImpendingCampaignExpiryBody'] = "Auf Grund dessen wird die Kampagne bald deaktiviert und weiter unten angegebene Banner aus dieser Kampagne werden deaktiviert.";

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
$GLOBALS['strUserDetails'] = "Benutzerdetails";
$GLOBALS['strLanguageTimezone'] = "Sprache & Zeitzone";
$GLOBALS['strLanguageTimezonePreferences'] = "Voreinstellungen Sprache und Zeitzone";
$GLOBALS['strUserInterfacePreferences'] = "Voreinstellungen Benutzeroberfläche";
$GLOBALS['strPluginPreferences'] = "Plugin Voreinstellungen";
$GLOBALS['strInvocationPreferences'] = "Voreinstellungen (Banner-)code";
$GLOBALS['strColumnName'] = "Spaltenname";
$GLOBALS['strShowColumn'] = "Spalte zeigen";
$GLOBALS['strCustomColumnName'] = "Eigener Spaltenname";
$GLOBALS['strColumnRank'] = "Reihenfolge der Spalten";


// Statistics columns
// Long names
$GLOBALS['strRevenue'] = "Einkommen";
$GLOBALS['strNumberOfItems'] = "Anzahl der Einträge";
$GLOBALS['strRevenueCPC'] = "Einkommen CPC";
$GLOBALS['strECPM'] = "ECPM";
$GLOBALS['strPendingConversions'] = "schwebende Konversionen";
$GLOBALS['strClickSR'] = "Klick Rate";
$GLOBALS['strRequiredImpressions'] = "Benötigte Impressionen";
$GLOBALS['strRequestedImpressions'] = "Angeforderte Impressionen";
$GLOBALS['strZoneForecast'] = "Zonenprognose";
$GLOBALS['strZonesForecast'] = "Summe Zonenprognose";
$GLOBALS['strZoneImpressions'] = "Impressionen Zone";
$GLOBALS['strZonesImpressions'] = "Summe Impressionen Zone";

// Short names
$GLOBALS['strRevenue_short'] = "Eink.";
$GLOBALS['strBasketValue_short'] = "WW";
$GLOBALS['strNumberOfItems_short'] = "Anzahl";
$GLOBALS['strRevenueCPC_short'] = "Eink. CPC";
$GLOBALS['strRequests_short'] = "Zugr.";
$GLOBALS['strClicks_short'] = "Klicks";
$GLOBALS['strConversions_short'] = "Konv.";
$GLOBALS['strPendingConversions_short'] = "schweb.Konv.";
$GLOBALS['strClickSR_short'] = "Klick Rate";

// Global Settings
$GLOBALS['strConfiguration'] = "Konfiguration";
$GLOBALS['strGlobalSettings'] = "Grundeinstellungen des Systems";
$GLOBALS['strGeneralSettings'] = "Allgemeine Einstellungen";
$GLOBALS['strMainSettings'] = "Haupteinstellungen";
$GLOBALS['strAdminSettings'] = "Einstellungen für die Administration";


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
$GLOBALS['strAgencies'] = "Benutzerkonten";
$GLOBALS['strAddAgency'] = "Benutzerkonto hinzufügen";
$GLOBALS['strAddAgency_Key'] = "<u>N</u>eues Benutzerkonto hinzufügen";
$GLOBALS['strTotalAgencies'] = "Gesamtzahl Benutzerkonten";
$GLOBALS['strAgencyProperties'] = "Merkmale Benutzerkonto";
$GLOBALS['strNoAgencies'] = "Zur Zeit sind keine Benutzerkonten angelegt.";
$GLOBALS['strConfirmDeleteAgency'] = "Soll dieses Benutzerkonto tatsächlich gelöscht werden?";
$GLOBALS['strHideInactiveAgencies'] = "deaktivierte Benutzerkonten ausblenden";
$GLOBALS['strInactiveAgenciesHidden'] = "deaktivierte Benutzerkonten verborgen";
$GLOBALS['strAllowAgencyEditConversions'] = "Dieser Nutzer darf Konversionen bearbeiten";
$GLOBALS['strAllowMoreReports'] = "Zeige 'Weitere Reports' Button";
$GLOBALS['strSwitchAccount'] = "Zu diesem Benutzerzugang wechseln";

// Channels
$GLOBALS['strChannel'] = "Zielgruppe";
$GLOBALS['strChannels'] = "Zielgruppen";
$GLOBALS['strChannelOverview'] = "Übersicht Zielgruppen";
$GLOBALS['strChannelManagement'] = "Zielgruppe bearbeiten ";
$GLOBALS['strAddNewChannel'] = "Eine neue Zielgruppe hinzufügen";
$GLOBALS['strAddNewChannel_Key'] = "<u>N</u>eue Zielgruppe anlegen";
$GLOBALS['strChannelToWebsite'] = "zur Webseite";
$GLOBALS['strNoChannels'] = "Zur Zeit sind keine Zielgruppen angelegt.";
$GLOBALS['strNoChannelsAddWebsite'] = "Es sind keine Zielgruppen angelegt, da es noch keine Webseiten gibt. Um eine Zielgruppe anzulegen, müssen Sie zuerst eine <a href='affiliate-edit.php'>neue Webseite hinzufügen</a>.";

$GLOBALS['strEditChannelLimitations'] = "Limitierungen in dieser Zielgruppen ändern";
$GLOBALS['strChannelProperties'] = "Merkmale Zielgruppe";
$GLOBALS['strChannelLimitations'] = "Auslieferungsoptionen";
$GLOBALS['strConfirmDeleteChannel'] = "Wollen Sie diese Zielgruppe wirklich löschen?";
$GLOBALS['strConfirmDeleteChannels'] = "Wollen Sie die ausgewählten Zielgruppen wirklich löschen?";
$GLOBALS['strModifychannel'] = "Ändern der Zielgruppe";
$GLOBALS['strVariableName'] = "Variablenname";
$GLOBALS['strVariableDescription'] = "Beschreibung";
$GLOBALS['strVariableDataType'] = "Datentyp";
$GLOBALS['strVariablePurpose'] = "Grund";
$GLOBALS['strGeneric'] = "Generisch";
$GLOBALS['strBasketValue'] = "Warenkorb Wert";
$GLOBALS['strNumItems'] = "Anzahl der Einträge";
$GLOBALS['strVariableIsUnique'] = "Konversionen doublettenbereingt?";
$GLOBALS['strRefererQuerystring'] = "Referer Abfragezeichenkette";
$GLOBALS['strQuerystring'] = "Abfragezeichenkette";
$GLOBALS['strInteger'] = "Ganzzahl";
$GLOBALS['strNumber'] = "Zahl";
$GLOBALS['strString'] = "Zeichenkette";
$GLOBALS['strTrackFollowingVars'] = "Die folgende Variable tracken";
$GLOBALS['strAddVariable'] = "Variable hinzufügen";
$GLOBALS['strNoVarsToTrack'] = "Zur Zeit gibt es keine trackbaren Variablen.";
$GLOBALS['strVariableHidden'] = "Verstecke die Variablen vor den Webseiten?";
$GLOBALS['strVariableRejectEmpty'] = "Wenn leer, ablehnen?";
$GLOBALS['strTrackingSettings'] = "Tracking Einstellungen";
$GLOBALS['strTrackerType'] = "Tracker Art";
$GLOBALS['strTrackerTypeJS'] = "Tracke JavaScript Variablen";
$GLOBALS['strTrackerTypeDefault'] = "Tracke JavaScript Variablen (abwärtskompatibel, Escape erforderlich)";
$GLOBALS['strTrackerTypeDOM'] = "Tracke HTML Elemente mittels DOM";
$GLOBALS['strTrackerTypeCustom'] = "Eigener JS code";


// Upload conversions
$GLOBALS['strRecordLengthTooBig'] = "Datensatzlänge zu groß";
$GLOBALS['strRecordNonInt'] = "Der Wert muß numerisch sein";
$GLOBALS['strRecordWasNotInserted'] = "Datensatz wurde nicht eingefügt";
$GLOBALS['strWrongColumnPart1'] = "<br>Fehler in CSV Datei! Spalte <b>";
$GLOBALS['strWrongColumnPart2'] = "</b> ist nicht erlaubt für diesen Tracker";
$GLOBALS['strMissingColumnPart1'] = "<br>Fehler in CSV Datei! Spalte <b>";
$GLOBALS['strMissingColumnPart2'] = "</b> fehlt";
$GLOBALS['strYouHaveNoTrackers'] = "Der Werbetreibende hat keine Tracker";
$GLOBALS['strYouHaveNoCampaigns'] = "Der Werbetreibende hat keine Kampagnen";
$GLOBALS['strYouHaveNoBanners'] = "Die Kampagne hat keine Banner";
$GLOBALS['strYouHaveNoZones'] = "Der Banner ist mit keiner Zone verlinkt!";
$GLOBALS['strNoBannersDropdown'] = "-- Keine Banner gefunden --";
$GLOBALS['strNoZonesDropdown'] = "-- Keine Zonen gefunden --";
$GLOBALS['strInsertErrorPart1'] = "<br><br><center><b> Fehler, ";
$GLOBALS['strDuplicatedValue'] = "Doppelte Werte!";
$GLOBALS['strInsertCorrect'] = "<br><br><center><b> Datei wurde fehlerfrei hochgeladen </b></center>";
$GLOBALS['strReuploadCsvFile'] = "CSV Datei erneut hochladen";
$GLOBALS['strConfirmUpload'] = "Hochladen bestätigen";
$GLOBALS['strLoadedRecords'] = "Datensätze geladen";
$GLOBALS['strBrokenRecords'] = "Fehlerhafte Felder in allen Datensätzen";
$GLOBALS['strWrongDateFormat'] = "Falsches Datumsformat";


// Password recovery
$GLOBALS['strForgotPassword'] = "Passwort vergessen?";
$GLOBALS['strPasswordRecovery'] = "Password wiederherstellen";
$GLOBALS['strEmailRequired'] = "Das Eingabefeld e-Mail muss ausgefüllt sein";
$GLOBALS['strPwdRecEmailSent'] = "Wiederherstellungsemail wurde versandt.";
$GLOBALS['strPwdRecEmailNotFound'] = "Die e-Mail Adresse konnte nicht gefunden werden";
$GLOBALS['strPwdRecPasswordSaved'] = "Das neue Passwort wurde gespeichert. Klicken Sie nun <a href='index.php'>hier</a>, um sich einzuloggen.";
$GLOBALS['strPwdRecWrongId'] = "Falsche ID";
$GLOBALS['strPwdRecEnterEmail'] = "Geben Sie nachfolgend Ihre eMail Adresse ein";
$GLOBALS['strPwdRecEnterPassword'] = "Geben Sie nachfolgend Ihr neues Passwort ein";
$GLOBALS['strPwdRecReset'] = "Passwort zurücksetzen";
$GLOBALS['strPwdRecResetLink'] = "Link zum Passwort zurücksetzen";
$GLOBALS['strPwdRecResetPwdThisUser'] = "Passwort für diesen Benutzer zurücksetzen";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "%s Passwort wiederherstellen";
$GLOBALS['strProceed'] = "Weiter >";
$GLOBALS['strNotifyPageMessage'] = "Ihnen wurde ein Link zum Zurücksetzen des Passworts per E-Mail zugeschickt, bitte warten Sie einige Minuten auf die Zustellung.<br />Sollte die E-Mail nicht eintreffen, überprüfen Sie bitte auch Ihren Spam-Ordner.<br /><a href='index.php'>Zurück zur Login-Seite.</a>";

// Audit
$GLOBALS['strAdditionalItems'] = "und weitere Einträge";
$GLOBALS['strFor'] = "für";
$GLOBALS['strHas'] = "hat";
$GLOBALS['strAdZoneAsscociation'] = "Verbindung zur Banner-Zone";
$GLOBALS['strBinaryData'] = "Binäre Daten";
$GLOBALS['strAuditTrailDisabled'] = "Das Prüfprotokoll wurde vom Administrator deaktiviert. Es werden keine weiteren Ereignisse protokolliert.";
$GLOBALS['strAccount'] = "Benutzerkonto";
$GLOBALS['strAccountUserAssociation'] = "Verbindung zum Benutzerkonto";
$GLOBALS['strEvent'] = "Ereignis";
$GLOBALS['strImage'] = "Bild";
$GLOBALS['strCampaignZoneAssociation'] = "Verbindung Kampagne Zone";
$GLOBALS['strAccountPreferenceAssociation'] = "Verbindung Vorgaben Benutzerkonto";


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
$GLOBALS['strDeliveryLimitationsDisagree'] = "WARNUNG: Das Auslieferungsmodul stimmt mit den folgenden Auslieferungsbeschränkungen <strong>NICHT ÜBEREIN</strong>. Bitte klicken Sie Änderungen speichern um die Regeln des Auslieferungsmoduls zu berichtigen.";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Hier einige der nicht korrekten Werte des Banner Targeting Reports:";

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

$GLOBALS['strChannelHasBeenAdded'] = "Zielgruppe <a href='%s'>%s</a> wurde hinzugefügt, <a href='%s'>ändern der Auslieferungsoptionen</a>";
$GLOBALS['strChannelHasBeenUpdated'] = "Die Zielgruppe <a href='%s'>%s</a> wurde aktualisiert";
$GLOBALS['strChannelAclHasBeenUpdated'] = "Auslieferungsoptionen für die Zielgruppe <a href='%s'>%s</a> wurden geändert";
$GLOBALS['strChannelHasBeenDeleted'] = "Zielgruppe <b>%s</b> wurde gelöscht";
$GLOBALS['strChannelsHaveBeenDeleted'] = "Alle ausgewählten Zielgruppen wurden gelöscht";
$GLOBALS['strChannelHasBeenDuplicated'] = "Die Zielgruppe <a href='%s'>%s</a> wurde nach <a href='%s'>%s</a> kopiert";

$GLOBALS['strUserPreferencesUpdated'] = "Ihre Voreinstellungen <b>%s</b> wurden geändert";
$GLOBALS['strPreferencesHaveBeenUpdated'] = "Voreinstellungen wurden geändert";
$GLOBALS['strEmailChanged'] = "Ihre E-Mail Adresse wurde geändert";
$GLOBALS['strPasswordChanged'] = "Ihr Passwort wurde geändert";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "<b>%s</b> wurde geändert";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "<b>%s</b> wurde geändert";


/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keyCollapseAll'] = "z";
$GLOBALS['keyExpandAll'] = "a";
$GLOBALS['keyNext'] = "w";
$GLOBALS['keyPrevious'] = "z";
$GLOBALS['keyLinkUser'] = "b";

/* ------------------------------------------------------- */
/* Languages Names                                       */
/* ------------------------------------------------------- */

$GLOBALS['str_ar'] = "Arabisch";
$GLOBALS['str_bg'] = "Bulgarisch";
$GLOBALS['str_cs'] = "Tschechisch";
$GLOBALS['str_cy'] = "Walisisch";
$GLOBALS['str_da'] = "Dänisch";
$GLOBALS['str_de'] = "Deutsch";
$GLOBALS['str_el'] = "Griechisch";
$GLOBALS['str_en'] = "Englisch";
$GLOBALS['str_es'] = "Spanisch";
$GLOBALS['str_fa'] = "Persisch";
$GLOBALS['str_fr'] = "Französisch";
$GLOBALS['str_he'] = "Hebräisch";
$GLOBALS['str_hr'] = "Kroatisch";
$GLOBALS['str_hu'] = "Ungarisch";
$GLOBALS['str_id'] = "Indonesisch";
$GLOBALS['str_it'] = "Italienisch";
$GLOBALS['str_ja'] = "Japanisch";
$GLOBALS['str_ko'] = "Koreanisch";
$GLOBALS['str_lt'] = "Litauisch";
$GLOBALS['str_ms'] = "Malaiisch";
$GLOBALS['str_nb'] = "Norwegisch";
$GLOBALS['str_nl'] = "Holländisch";
$GLOBALS['str_pl'] = "Polnisch";
$GLOBALS['str_pt_BR'] = "Portugiesisches Brasilianisch";
$GLOBALS['str_pt_PT'] = "Portugiesisch";
$GLOBALS['str_ro'] = "Rumänisch";
$GLOBALS['str_ru'] = "Russisch";
$GLOBALS['str_sk'] = "Slovakisch";
$GLOBALS['str_sl'] = "Slowenisch";
$GLOBALS['str_sq'] = "Albanisch";
$GLOBALS['str_sv'] = "Schwedisch";
$GLOBALS['str_tr'] = "Türkisch";
$GLOBALS['str_uk'] = "Ukrainisch";
$GLOBALS['str_zh_CN'] = "Einfaches Chinesisch";
$GLOBALS['str_zh_TW'] = "Traditionelles Chinesisch";
?>
