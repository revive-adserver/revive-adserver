<?php // $Revision: 1.6 $

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/* Translations by Stefan Morgenroth (dandra@users.sf.net)              */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Installer translation strings
$GLOBALS['strInstall']					= "Installation";
$GLOBALS['strChooseInstallLanguage']	= "Wähle die Sprache für die Installation";
$GLOBALS['strLanguageSelection']		= "Sprachauswahl";
$GLOBALS['strDatabaseSettings']			= "Datenbankeinstellungen";
$GLOBALS['strAdminSettings']			= "Administratoreinstellungen";
$GLOBALS['strAdvancedSettings']			= "Erweiterte Einstellungen";
$GLOBALS['strOtherSettings']			= "Sonstige Einstellungen";

$GLOBALS['strWarning']					= "Warnung";
$GLOBALS['strFatalError']				= "Ein fataler Fehler ist aufgetreten";
$GLOBALS['strAlreadyInstalled']			= "phpAdsNew ist bereits auf diesem System installiert. Zur Konfiguration bitte das <a href='settings-index.php'>Einstellungsinterface</a> nutzen.";
$GLOBALS['strCouldNotConnectToDB']		= "Es kann keine Verbindung zu Datenbank hergestellt werden. Bitte überprüfe die vorgenommenen Einstellungen";
$GLOBALS['strCreateTableTestFailed']	= "Der gewählte User hat keine Rechte eine Datenbankstruktur zu erstellen bzw. zu verändern. Bitte kontaktiere den Datenbankadministrator.";
$GLOBALS['strUpdateTableTestFailed']	= "Der gewählte User hat keine Rechte eine Datenbankstruktur zu erstellen bzw. zu verändern. Bitte kontaktiere den Datenbankadministrator.";
$GLOBALS['strTablePrefixInvalid']		= "Die Tabellennamensvorgabe enthält ungültige Zeichen";
$GLOBALS['strMayNotFunction']			= "Before you continue, please correct these potential problems:";
$GLOBALS['strIgnoreWarnings']			= "Ignore warnings";
$GLOBALS['strWarningPHPversion']		= "phpAdsNew requires PHP 3.0.8 or higher to function correctly. You are currently using {php_version}.";
$GLOBALS['strWarningRegisterGlobals']	= "The PHP configuration variable register_globals needs to be turned on.";
$GLOBALS['strWarningMagicQuotesGPC']	= "The PHP configuration variable magic_quote_gpc needs to be turned on.";
$GLOBALS['strWarningMagicQuotesRuntime']= "The PHP configuration variable magic_quotes_runtime needs to be turned off.";
$GLOBALS['strConfigLockedDetected']		= "phpAdsNew hat festgestellt, daß die Datei <b>config.inc.php</b> vom Server nicht verändert werden kann (keine Schreibrechte). <br>Der Vorgang kann nicht forgesetzt werden bis die Schreib-Lese-Rechte für diese Datei freigegeben wurden. <br>Bitte lies die beiliegende Dokumentation, um zu erfahren, wie dies funktioniert.";
$GLOBALS['strCantUpdateDB']  			= "Es ist z.Z. nicht möglich ein Update der Datenbank durchzuführen. Wenn dennoch fortgefahren wird, werden alle existierenden Banner, Statistiken und Clients unwiderruflich gelöscht!";
$GLOBALS['strTableNames']				= "Tabellennamen";
$GLOBALS['strTablesPrefix']				= "Tabellennamenvorgabe";
$GLOBALS['strTablesType']				= "Tabellentyp";

$GLOBALS['strInstallWelcome']			= "Welcome to phpAdsNew";
$GLOBALS['strInstallMessage']			= "Before you can use phpAdsNew it needs to be configured and <br> the database needs to be created. Click <b>Proceed</b> to continue.";
$GLOBALS['strInstallSuccess']			= "<b>The installation of phpAdsNew is now complete.</b><br><br>In order for phpAdsNew to function correctly you also need
										   to make sure the maintenance file is run every day. More information about this subject can be found in the documentation.
										   <br><br>Click <b>Proceed</b> to go the configuration page, where you can 
										   set up more settings. Please do not forget to lock the config.inc.php file when you are finished to prevent security
										   breaches.";
$GLOBALS['strInstallNotSuccessful']		= "<b>The installation of phpAdsNew was not succesful</b><br><br>Some portions of the install process could not be completed.
										   It is possible these problems are only temporarily, in that case you can simply click <b>Proceed</b> and return to the
										   first step of the install process. If you want to know more on what the error message below means, and how to solve it, 
										   please consult the supplied documentation.";
$GLOBALS['strErrorOccured']				= "The following error occured:";
$GLOBALS['strErrorInstallDatabase']		= "The database structure could not be created.";
$GLOBALS['strErrorInstallConfig']		= "The configuration file or database could not be updated.";
$GLOBALS['strErrorInstallDbConnect']	= "It was not possible to open a connection to the database.";

$GLOBALS['strUrlPrefix']				= "URL Vorgabe";

$GLOBALS['strProceed']					= "Fortsetzen &gt;";
$GLOBALS['strInstallDatabase']			= "Datenbankstruktur Installation";
$GLOBALS['strFunctionAlreadyExists']	= "Funktion %s existiert bereits";
$GLOBALS['strFunctionInAllDotSqlErr']	= "Kann keine Funktion aus 'all.sql' erzeugen";
$GLOBALS['strFunctionClickProceed']		= "Sollen bereits bestehende Funktionen überschrieben werden?";
$GLOBALS['strYes']						= "Ja";
$GLOBALS['strNo']						= "Nein";
$GLOBALS['strDatabaseCreated']			= "Datenbankstruktur erfolgreich erzeugt:";
$GLOBALS['strTableCreated']				= "Tabelle <b>%s</b> erfolgreich erzeugt";
$GLOBALS['strSequenceCreated']			= "Sequenz <b>%s</b> erfolgreich erzeugt";
$GLOBALS['strIndexCreated']				= "Index <b>%s</b> erfolgreich erzeugt";
$GLOBALS['strFunctionCreated']			= "Funktion <b>%s</b> erfolgreich erzeugt";
$GLOBALS['strFunctionReplaced']			= "Funktion <b>%s</b> erfolgreich erzeugt";
$GLOBALS['strUnknownStatementExec']		= "Unbekanntes Statement ausgeführt";
$GLOBALS['strAdminPasswordSetup']		= "Admin Passwort Setup";
$GLOBALS['strRepeatPassword']			= "Wiederhole Passwort";
$GLOBALS['strNotSamePasswords']			= "Passworte sind nicht identisch";
$GLOBALS['strInvalidUserPwd']			= "Ungültiger Username oder Passwort";
$GLOBALS['strInstallCompleted']			= "Installation abgeschlossen";
$GLOBALS['strInstallCompleted2']		= "Klick <b>Fortsetzen</b>, um zur Konfiguration zu gelangen und um die sontigen Einstellungen anzupassen.";

$GLOBALS['strUpgrade']					= "Upgrade";
$GLOBALS['strSystemUpToDate']			= "Your system is up to date, no upgrade needed at the moment. <br>Click on <b>Proceed</b> to go to home page.";
$GLOBALS['strSystemNeedsUpgrade']		= "The database structure and configuration file need to be upgraded in order to function correctly. Click <b>Proceed</b> to start the upgrade process. <br>Please be patient, the upgrade can take up to a couple of minutes.";
$GLOBALS['strSystemUpgradeBusy']		= "System upgrade in progress, please wait...";
$GLOBALS['strServiceUnavalable']		= "Der Dienst ist zeitweise nicht verfügbar. Systemupgrade läuft...";
$GLOBALS['strDownloadConfig']			= "Downloade die <b>config.inc.php</b> und uploade sie auf den Server, dann klicke <b>Fortsetzen</b>.";
$GLOBALS['strDownload']					= "Download";

$GLOBALS['strConfigNotWritable']		= "Die Datei <b>config.inc.php</b> ist nicht beschreibbar";

// Settings translation strings
$GLOBALS['strChooseSection']			= "Abschnitt schließen";

$GLOBALS['strDbHost']					= "Datenbank Hostname";
$GLOBALS['strDbUser']					= "Datenbank Username";
$GLOBALS['strDbPassword']				= "Datenbank Passwort";
$GLOBALS['strDbName']					= "Datenbankname";
$GLOBALS['strPersistentConnections']	= "Ständige Dantenbankverbindung nutzen (persistent)";
$GLOBALS['strInsertDelayed']			= "Verzögerte Inserts (Einfügungen) nutzen";
$GLOBALS['strCompatibilityMode']		= "Use database compatibility mode";
$GLOBALS['strCantConnectToDb']			= "Es kann keine Verbindung zur Datenbank aufgebaut werden";

$GLOBALS['strAdminUsername']			= "Admins Username";
$GLOBALS['strAdminFullName']			= "Admins voller Vor-,Nachname";
$GLOBALS['strAdminEmail']				= "Admins E-Mail Adresse";
$GLOBALS['strAdminEmailHeaders']		= "Mailkopf zur Wiedergabe des Senders der täglichen Werbeberichte";
$GLOBALS['strAdminNovice']				= "Des Admins Löschvorgänge benötigen zur Sicherheit eine Bestätigung";
$GLOBALS['strOldPassword']				= "Altes Passwort";
$GLOBALS['strNewPassword']				= "Neues Passwort";
$GLOBALS['strInvalidUsername']			= "Ungültiger Username";
$GLOBALS['strInvalidPassword']			= "Ungültiges Passwort";

$GLOBALS['strGuiSettings']				= "User Interface Konfiguration";
$GLOBALS['strMyHeader']					= "Mein Header";
$GLOBALS['strMyFooter']					= "Mein Footer";
$GLOBALS['strTableBorderColor']			= "Tabellenrahmenfarbe";
$GLOBALS['strTableBackColor']			= "Tabellenhintergrundfarbe";
$GLOBALS['strTableBackColorAlt']		= "Tabellenhintergrundfarbe (alternativ)";
$GLOBALS['strMainBackColor']			= "Seiten Haupthintergrundfarbe";
$GLOBALS['strAppName']					= "Applikationsname";
$GLOBALS['strCompanyName']				= "Unternehmensname";
$GLOBALS['strOverrideGD']				= "Überschreiben des GD-Bildformats";
$GLOBALS['strTimeZone']					= "Zeitzone";

$GLOBALS['strDayFullNames'] = array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Sonnabend");

$GLOBALS['strIgnoreHosts']				= "Ignoriere Hosts";
$GLOBALS['strWarnLimit']				= "Limitwarnung";
$GLOBALS['strWarnLimitErr']				= "Limitwarnung sollte eine positive ganze Zahl sein";
$GLOBALS['strBeginOfWeek']				= "Beginn der Woche";
$GLOBALS['strPercentageDecimals']		= "Percentage Decimals";
$GLOBALS['strCompactStats']				= "Nutze kompackte Statistik";
$GLOBALS['strLogAdviews']				= "Log Adviews";
$GLOBALS['strLogAdclicks']				= "Log Adclicks";
$GLOBALS['strReverseLookup']			= "Reverse DNS Lookup";
$GLOBALS['strWarnAdmin']				= "Adminwarnung";
$GLOBALS['strWarnClient']				= "Clientwarnung";

$GLOBALS['strAllowedBannerTypes']		= "Erlaubte Bannertypen";
$GLOBALS['strTypeSqlAllow']				= "Erlaube in Datenbank gespeicherte Banner";
$GLOBALS['strTypeWebAllow']				= "Erlaube auf Webserver gespeicherte Banner";
$GLOBALS['strTypeUrlAllow']				= "Erlaube URL verknüpfte Banner";
$GLOBALS['strTypeHtmlAllow']			= "Erlaube HTML-Banner";
$GLOBALS['strTypeWebSettings']			= "Webbanner Konfiguration";
$GLOBALS['strTypeWebMode']				= "Speichermethode";
$GLOBALS['strTypeWebModeLocal']			= "Local Mode (in einem lokalen Verzeichnis gespeichert)";
$GLOBALS['strTypeWebModeFtp']			= "FTP Mode (auf einem externen FTP-Server gespeichert)";
$GLOBALS['strTypeWebDir']				= "Local Mode Webbanner Verzeichnis";
$GLOBALS['strTypeWebFtp']				= "FTP Mode Webbanner Server";
$GLOBALS['strTypeWebUrl']				= "Öffentliche URL des lokalen Verzeichnisses / FTP-Servers";
$GLOBALS['strTypeHtmlSettings']			= "HTML-Banner Konfiguration";
$GLOBALS['strTypeHtmlAuto']				= "Automatisch HTML-Banner anpassen, um ein Adclick Loggen zu ermöglichen";
$GLOBALS['strTypeHtmlPhp']				= "Erlaube die Ausführung von PHP-Funktionen innerhalb eines HTML-Banners";

$GLOBALS['strBannerRetrieval']			= "Banner Einblendungsmethode";
$GLOBALS['strRetrieveRandom']			= "Zufällige Bannereinblendung (Standard)";
$GLOBALS['strRetrieveNormalSeq']		= "Normal sequentielle Bannereinblendung";
$GLOBALS['strWeightSeq']				= "Gewichtet sequentielle Bannereinblendung";
$GLOBALS['strFullSeq']					= "Volle sequentielle Bannereinblendung";
$GLOBALS['strDefaultBannerUrl']			= "Standard Banner-URL";
$GLOBALS['strDefaultBannerTarget']		= "Standard Banner Klick-Ziel";
$GLOBALS['strUseConditionalKeys']		= "Nutze bedingte Schlüsselwörter";
$GLOBALS['strUseMultipleKeys']			= "Nutze multiple Schlüsselwörter";
$GLOBALS['strUseAcl']					= "Nutze Einblendungsbegrenzungen (ACL)";

$GLOBALS['strZonesSettings']			= "Zonen Einstellungen";
$GLOBALS['strZoneCache']				= "Cache Zonen, dies sollte die Geschwindigkeit bei Zonennutzung erhöhen";
$GLOBALS['strZoneCacheLimit']			= "Zeit zwischen Cache Updates (in Sekunden)";
$GLOBALS['strZoneCacheLimitErr']		= "Zeit zwischen Cache Updates sollte eine positive ganze Zahl sein";

$GLOBALS['strP3PSettings']				= "P3P Einstellungen";
$GLOBALS['strUseP3P']					= "Nutze P3P Policies";
$GLOBALS['strP3PCompactPolicy']			= "P3P Compact Policy";
$GLOBALS['strP3PPolicyLocation']		= "P3P Policy Location";

$GLOBALS['strClientWelcomeMessage']		= "Client Willkommen Nachricht";
$GLOBALS['strClientWelcomeEnabled']		= "Aktiviere Client Willkommen Nachricht";
$GLOBALS['strClientWelcomeText']		= "Client Willkommen Text<br>(HTML-Tags erlaubt)";

$GLOBALS['strDefaultBannerWeight']		= "Standard Bannergewichtung";
$GLOBALS['strDefaultCampaignWeight']	= "Standard Kampagnengewichtung";

$GLOBALS['strDefaultBannerWErr']		= "Standard Bannergewichtung sollte eine positive ganze Zahl sein";
$GLOBALS['strDefaultCampaignWErr']		= "Standard Kampagnengewichtung sollte eine positive ganze Zahl sein";

?>