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

// Main strings
$GLOBALS['strChooseSection'] = "Auswahlbereich";
$GLOBALS['strAppendCodes'] = "Code-Anhang";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>Der regelmäßige Wartungslauf ist in der vergangenen Stunde nicht gelaufen, d.h. Sie haben ihn noch nicht richtig eingerichtet.</b>";





$GLOBALS['strScheduledMantenaceRunning'] = "<b>Der regelmäßige Wartungslauf ist korrekt eingerichtet.</b>";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>Der automatische Wartungslauf läuft korrekt.</b>";

$GLOBALS['strAutoMantenaceEnabled'] = "Der automatische Wartungslauf ist jedoch immer noch aktiviert. Für eine bestmögliche Ausführungsgeschwindigkeit sollten Sie den <a href='account-settings-maintenance.php'>automatischen Wartungslauf deaktivieren</a>.";

// Priority
$GLOBALS['strRecalculatePriority'] = "Neuberechnung der Prioritäten";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "Überprüfung des Banner-Cache";
$GLOBALS['strBannerCacheErrorsFound'] = "Die Cache-Überprüfung hat einige Fehler gefunden. Diese Banner werden nicht funktionieren bis das Problem manuell behoben wurde.";
$GLOBALS['strBannerCacheOK'] = "Es wurden keine Fehler gefunden. Der Banner-Cache ist aktuell.";
$GLOBALS['strBannerCacheDifferencesFound'] = "Die Banner-Cache Überprüfung hat ergeben das einige Einträge nicht aktuell sind. Klicken Sie hier um den Cache automatisch zu aktualisieren.";
$GLOBALS['strBannerCacheRebuildButton'] = "Erneuern";
$GLOBALS['strRebuildDeliveryCache'] = "Cache wird erneuert";

// Cache
$GLOBALS['strCache'] = "Cache für Bannerauslieferung";
$GLOBALS['strDeliveryCacheSharedMem'] = "	Der gemeinsam genutzte Speicher wird vom Cache für Bannerauslieferung benutzt.";
$GLOBALS['strDeliveryCacheDatabase'] = "	Die Datenbank wird zur Zeit vom Cache für Bannerauslieferung benutzt.";
$GLOBALS['strDeliveryCacheFiles'] = "	Der Cache für Bannerauslieferung wird zur Zeit in mehrere Dateien gespeichert.";

// Storage
$GLOBALS['strStorage'] = "Speicherung";
$GLOBALS['strMoveToDirectory'] = "Bilder aus der Datenbank in ein Verzeichnis verschieben ";
$GLOBALS['strStorageExplaination'] = "	Bilddateien für lokale Banner werden in der Datenbank oder in einem lokalen Verzeichnis gespeichert.
	Das Speichern in einem lokalen Verzeichnis anstelle in der Datenbank vermindert die Ladezeit.";

// Encoding
$GLOBALS['strEncoding'] = "Kodierung";
$GLOBALS['strEncodingConvertFrom'] = "Umwandeln aus der Kodierung:";
$GLOBALS['strEncodingConvertTest'] = "Konversion prüfen";
$GLOBALS['strConvertThese'] = "Die folgenden Daten werden verändert wenn Sie fortfahren";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Suche nach neuen Updates. Bitte warten...";
$GLOBALS['strAvailableUpdates'] = "Verfügbare Updates";
$GLOBALS['strDownloadZip'] = "Download (.zip)";
$GLOBALS['strDownloadGZip'] = "Download (.tar.gz)";


$GLOBALS['strUpdateServerDown'] = "    Aus unbekannten Gründen ist es nicht möglich, nach Informationen <br />
	zu neuen Updates zu prüfen. Versuchen Sie es später noch einmal.";



$GLOBALS['strCheckForUpdatesDisabled'] = "<b>Die Prüfung auf Updates ist ausgeschaltet. Bitte aktivieren Sie die Prüfung auf der <a href='account-settings-update.php'>Update Einstellungsseite</a>.</b>";




$GLOBALS['strForUpdatesLookOnWebsite'] = "	Informationen über neue Versionen befinden sich auf unserer Webseite.";

$GLOBALS['strClickToVisitWebsite'] = "Zu unserer Webseite ";
$GLOBALS['strCurrentlyUsing'] = "Sie nutzen derzeit";
$GLOBALS['strRunningOn'] = "laufend auf";
$GLOBALS['strAndPlain'] = "und";

//  Deliver Limitations
$GLOBALS['strErrorsFound'] = "Fehler gefunden";
$GLOBALS['strRepairCompiledLimitations'] = "Obige Inkonsistenzen wurden ermittelt. Sie können diese reparieren durch die Verwendung des unten stehenden Buttons. Hierbei wird das System die Auslieferungsbeschränkungen jedes Banners und jeder Gruppe im System neu übersetzen.<br />";
$GLOBALS['strRecompile'] = "Neu übersetzen";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "Unter manchen Umständen kann das Auslieferungsmodul den gespeicherten Code-Anhang der Tracker nicht korrekt verarbeiten. Verwenden Sie den folgenden Link um die in der Datenbank gespeicherten Codes zu überprüfen.";
$GLOBALS['strCheckAppendCodes'] = "Code Anhänge prüfen";
$GLOBALS['strAppendCodesRecompiled'] = "Alle übersetzten Code Anhänge wurden neu übersetzt";
$GLOBALS['strAppendCodesResult'] = "Hier sind die Ergebnisse der Überprüfung des Code Anhänge";
$GLOBALS['strAppendCodesValid'] = "Alle Tracker Code Anhänge sind korrekt";
$GLOBALS['strRepairAppenedCodes'] = "Obige Inkonsistenzen wurden ermittelt. Sie können diese reparieren durch die Verwendung des unten stehenden Buttons. Hierbei wird das System die Code Anhänge jedes Trackers im System neu übersetzen.";


$GLOBALS['strMenus'] = "Menüs";
$GLOBALS['strMenusPrecis'] = "Den Menü-Cache wiederaufbauen";
$GLOBALS['strMenusCachedOk'] = "Der Menü-Cache wurde wiederaufgebaut";
