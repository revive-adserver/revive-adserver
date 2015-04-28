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

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "Der automatische Wartungslauf ist aktiviert, wurde aber noch nicht ausgeführt. Der automatische Wartungslauf wird ausgeführt wenn {$PRODUCT_NAME} Werbemittel ausliefert. Für die bestmögliche Ausführungsgeschwindigkeit sollten Sie den <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>regelmäßigen Wartungslauf einrichten</a>.";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "Der automatische Wartungslauf ist im Moment deaktiviert, wenn {$PRODUCT_NAME} Werbemittel ausliefert, wird kein automatischer Wartungslauf ausgeführt wird. Um die bestmögliche Ausführungsgeschwindigkeit zu erreichen sollten Sie den <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>regelmäßigen Wartungslauf</a> einrichten. Wenn Sie den <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>regelmäßigen Wartungslauf</a> nicht einrichten möchten, <i>müssen</i> Sie den <a href='account-settings-maintenance.php'>automatischen Wartungslauf einrichten</a> um sicherzustellen das {$PRODUCT_NAME} korrekt arbeitet.";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "Der automatische Wartungslauf ist aktiviert und wird nach Bedarf ausgeführt wenn {$PRODUCT_NAME} Werbemittel ausliefert. Für die bestmögliche Ausführungsgeschwindigkeit sollten Sie den <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>regelmäßigen Wartungslauf einrichten</a>.";

$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "Der automatische Wartungslauf wurde jedoch vor kurzem deaktiviert. Um sicherzustellen das {$PRODUCT_NAME} korrekt arbeitet, müssen Sie entweder den <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>regelmäßigen Wartungslauf</a> einrichten, oder den <a href='account-settings-maintenance.php'>automatischen Wartungslauf wieder aktivieren</a>.<br><br>Die die bestmögliche Ausführungsgeschwindigkeit sollten Sie den <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>regelmäßigen Wartungslauf</a> einrichten.";

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
$GLOBALS['strBannerCacheExplaination'] = "Im Bannercache werden Kopien der HTML-Codes, die für die Bannerdarstellung notwendig sind, vorgehalten. Dies beschleunigt die Bannerauslieferung, da der HTML-Code nicht jedesmal neu generiert werden. Da im Cache die URL als Direktadressierung, verknüpft mit dem Standort von {$PRODUCT_NAME} nebst dem Banner vorliegt, muß der Bannercache aktualisiert werden, wenn <ul><li>Sie Ihre Version von OpenX aktualisieren</li><li>Sie den Server wechseln</li></ul>";

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
$GLOBALS['strEncodingExplaination'] = "{$PRODUCT_NAME} speichert jetzt alle Daten im UTF-8 Format. Wenn möglich wurden Ihre Daten automatisch in diese Kodierung überführt.<br />Sie können diesen Übersetzer verwenden, wenn Sie nach dem Update fehlerhafte Zeichen finden und Sie die verwendete Kodierung kennen, um die Zeichen in UTF-8 umzuwandeln.";
$GLOBALS['strEncodingConvertFrom'] = "Umwandeln aus der Kodierung:";
$GLOBALS['strEncodingConvertTest'] = "Konversion prüfen";
$GLOBALS['strConvertThese'] = "Die folgenden Daten werden verändert wenn Sie fortfahren";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Suche nach neuen Updates. Bitte warten...";
$GLOBALS['strAvailableUpdates'] = "Verfügbare Updates";
$GLOBALS['strDownloadZip'] = "Download (.zip)";
$GLOBALS['strDownloadGZip'] = "Download (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "Eine neue Version von {$PRODUCT_NAME} ist verfügbar.

Wünschen Sie weitere Informationen über dieses Update?";
$GLOBALS['strUpdateAlertSecurity'] = "Eine neue Version von {$PRODUCT_NAME} ist verfügbar.


Eine kurzfristige Aktualisierung  Ihres Systems

wird empfohlen, da in der neuen Version eine oder

mehrere sicherheitsrelevante Probleme überarbeitet wurden.";

$GLOBALS['strUpdateServerDown'] = "    Aus unbekannten Gründen ist es nicht möglich, nach Informationen <br />
	zu neuen Updates zu prüfen. Versuchen Sie es später noch einmal.";

$GLOBALS['strNoNewVersionAvailable'] = "	Ihre Version von {$PRODUCT_NAME} ist aktuell. Es sind keine Updates verfügbar.";

$GLOBALS['strServerCommunicationError'] = "<b>Die Kommunikation mit dem Updateserver wurde mit einem Timeout beendet. {$PRODUCT_NAME} kann zu diesem Zeitpunkt nicht feststellen ob eine neuere Version verfügbar ist. Bitte versuchen Sie es später noch einmal.</b>";

$GLOBALS['strCheckForUpdatesDisabled'] = "<b>Die Prüfung auf Updates ist ausgeschaltet. Bitte aktivieren Sie die Prüfung auf der <a href='account-settings-update.php'>Update Einstellungsseite</a>.</b>";

$GLOBALS['strNewVersionAvailable'] = "	<b>Eine neue Version von {$PRODUCT_NAME} ist verfügbar. </b><br />Eine kurzfristige Aktualisierung Ihres Systems wird empfohlen,
 	da in der neuen Version eine oder mehrere sicherheitsrelevante Probleme überarbeitet wurden. Zusätzlich wurden neue Leistungsmerkmale integriert. Weiterführende Information
 	finden Sie in den unten stehenden Dokumenten.";

$GLOBALS['strSecurityUpdate'] = "	<b>Die schnellstmögliche Durchführung dieses Updates wird empfohlen, da eine Reihe von Sicherheitsproblemen behoben wurden.</b>
	Ihre Version von {$PRODUCT_NAME} ist gegen illegale Angriffe möglicherweise nicht ausreichend gesichert. Ausführlichere Informationen
 	finden Sie in den unten stehenden Dokumenten.";

$GLOBALS['strNotAbleToCheck'] = "	Auf Ihrem Server ist die XML-Erweiterung nicht verfügbar. {$PRODUCT_NAME} kann nicht prüfen, ob eine neuere Version verfügbar ist.";

$GLOBALS['strForUpdatesLookOnWebsite'] = "	Informationen über neue Versionen befinden sich auf unserer Webseite.";

$GLOBALS['strClickToVisitWebsite'] = "Zu unserer Webseite ";
$GLOBALS['strCurrentlyUsing'] = "Sie nutzen derzeit";
$GLOBALS['strRunningOn'] = "laufend auf";
$GLOBALS['strAndPlain'] = "und";

//  Deliver Limitations
$GLOBALS['strDeliveryLimitations'] = "Auslieferungsbeschränkungen";
$GLOBALS['strAllBannerChannelCompiled'] = "Alle Auslieferungsbeschränkungen der Banner und Gruppen wurden neu übersetzt.";
$GLOBALS['strBannerChannelResult'] = "Hier die Ergebnisse der Übersetzung und Überprüfung der Auslieferungsbeschränkungen der Banner und Gruppen";
$GLOBALS['strChannelCompiledLimitationsValid'] = "Alle Auslieferungsbeschränkungen der Gruppen ist gültig.";
$GLOBALS['strBannerCompiledLimitationsValid'] = "Alle Auslieferungsbeschränkungen der Banner ist gültig.";
$GLOBALS['strErrorsFound'] = "Fehler gefunden";
$GLOBALS['strRepairCompiledLimitations'] = "Obige Inkonsistenzen wurden ermittelt. Sie können diese reparieren durch die Verwendung des unten stehenden Buttons. Hierbei wird das System die Auslieferungsbeschränkungen jedes Banners und jeder Gruppe im System neu übersetzen.<br />";
$GLOBALS['strRecompile'] = "Neu übersetzen";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "Unter manchen Umständen kann das Auslieferungsmodul die gespeicherten ACLs der Banner und Gruppen nicht korrekt verarbeiten. Verwenden Sie den folgenden Link um die in der Datenbank gespeicherten ACLs zu überprüfen.";
$GLOBALS['strCheckACLs'] = "ACLs überprüfen";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "Unter manchen Umständen kann das Auslieferungsmodul den gespeicherten Code-Anhang der Tracker nicht korrekt verarbeiten. Verwenden Sie den folgenden Link um die in der Datenbank gespeicherten Codes zu überprüfen.";
$GLOBALS['strCheckAppendCodes'] = "Code Anhänge prüfen";
$GLOBALS['strAppendCodesRecompiled'] = "Alle übersetzten Code Anhänge wurden neu übersetzt";
$GLOBALS['strAppendCodesResult'] = "Hier sind die Ergebnisse der Überprüfung des Code Anhänge";
$GLOBALS['strAppendCodesValid'] = "Alle Tracker Code Anhänge sind korrekt";
$GLOBALS['strRepairAppenedCodes'] = "Obige Inkonsistenzen wurden ermittelt. Sie können diese reparieren durch die Verwendung des unten stehenden Buttons. Hierbei wird das System die Code Anhänge jedes Trackers im System neu übersetzen.";

$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strPluginsPrecis'] = "Probleme mit den OpenX-Plugins überprüfen und reparieren";

$GLOBALS['strMenus'] = "Menüs";
$GLOBALS['strMenusPrecis'] = "Den Menü-Cache wiederaufbauen";
$GLOBALS['strMenusCachedOk'] = "Der Menü-Cache wurde wiederaufgebaut";
