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

// German
// Main strings
$GLOBALS['strChooseSection']			= "Auswahlbereich";


// Priority
$GLOBALS['strRecalculatePriority']		= "Neuberechnung der Prioritäten";
$GLOBALS['strHighPriorityCampaigns']		= "Kampagnen mit hoher Priorität";
$GLOBALS['strAdViewsAssigned']		= "Festgelegte AdViews";
$GLOBALS['strLowPriorityCampaigns']		= " Kampagnen mit geringer Priorität ";
$GLOBALS['strPredictedAdViews']		= "Prognostizierte AdViews";
$GLOBALS['strPriorityDaysRunning']		= "Die Prognose für die tägliche Bannerauslieferung basiert auf Statistiken von {days} Tagen. ";
$GLOBALS['strPriorityBasedLastWeek']		= "Die Prognose basiert auf den Daten dieser und der vergangenen Woche. ";
$GLOBALS['strPriorityBasedLastDays']		= "Die Prognose basiert auf den Daten der letzten Tage. ";
$GLOBALS['strPriorityBasedYesterday']		= "Die Prognose basiert auf den Daten von gestern. ";
$GLOBALS['strPriorityNoData']			= "Für eine zuverlässige Prognose über die heute mögliche Anzahl von AdViews stehen nicht ausreichend Daten zur Verfügung. Die Festlegung der Prioritäten wird daher nur auf in Echtzeit erstellte Statistiken gestützt sein. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Es werden ausreichend AdViews zur Verfügung stehen, um die Kampagnen mit hoher Priorität bedienen zu können. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Es ist ungewiß, ob ausreichend AdViews zur Verfügung stehen werden, um die Anforderungen durch Kampagnen mit hoher Priorität befriedigen zu können.";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Bannercache erneuern";
$GLOBALS['strBannerCacheExplaination']		= "Im Bannercache werden Kopien der HTML-Codes, die für die Bannerdarstellung notwendig sind, vorgehalten. Dies beschleunigt die Bannerauslieferung, da der HTML-Code nicht jedesmal neu generiert werden. Da im Cache die URL als Direktadressierung, verknüpft mit dem Standort von ".MAX_PRODUCT_NAME." nebst dem Banner vorliegt, muß der Bannercache aktualisiert werden, wenn <ul><li>Sie Ihre Version von OpenX aktualisieren</li><li>Sie den Server wechseln</li></ul>";


// Cache
$GLOBALS['strCache']			= "Cache für Bannerauslieferung";
$GLOBALS['strAge']				= "Alter";
$GLOBALS['strRebuildDeliveryCache']			= "Cache wird erneuert";
$GLOBALS['strDeliveryCacheExplaination']		= "\n	Der Cache für die Bannerauslieferung wird zur Beschleunigung der Bannerauslieferung benötigt. Im Cache sind Kopien von jedem Banner, der mit der Zone verbunden (verlinkt) ist. Dadurch, das die aktuellen Banner im Cache vorgehalten sind,  wird eine Reihe von Datenbankabfragen gespart. Der Cache wird jedesmal bei Änderungen der Zone oder dem verknüpften Banner erneuert. Um dennoch einer Überalterung vorzubeugen, wird der Cache stündlich automatisch erneuert. Der Vorgang kann zusätzlich manuell angestoßen werden.";
$GLOBALS['strDeliveryCacheSharedMem']		= "\n	Der gemeinsam genutzte Speicher wird vom Cache für Bannerauslieferung benutzt.";
$GLOBALS['strDeliveryCacheDatabase']		= "\n	Die Datenbank wird zur Zeit vom Cache für Bannerauslieferung benutzt.";
$GLOBALS['strDeliveryCacheFiles']		= "\n	Der Cache für Bannerauslieferung wird zur Zeit in mehrere Dateien gespeichert.";


// Storage
$GLOBALS['strStorage']				= "Speicherung";
$GLOBALS['strMoveToDirectory']		= "Bilder aus der Datenbank in ein Verzeichnis verschieben ";
$GLOBALS['strStorageExplaination']		= "\n	Bilddateien für lokale Banner werden in der Datenbank oder in einem lokalen Verzeichnis gespeichert.\n	Das Speichern in einem lokalen Verzeichnis anstelle in der Datenbank vermindert die Ladezeit.";


// Storage
$GLOBALS['strStatisticsExplaination']		= "Sie haben in den Einstellungen die <i>kompakten Statistiken</i> aktiviert, Ihre bisherigen Statistiken liegen noch im ausführlichen Format vor. Möchten Sie Ihre diese Statistiken ebenfalls in das neue, kompakte Format umwandeln?";


// Product Updates
$GLOBALS['strSearchingUpdates']		= "Suche nach neuen Updates. Bitte warten...";
$GLOBALS['strAvailableUpdates']			= "Vorhandene Updates";
$GLOBALS['strDownloadZip']			= "Download (.zip)";
$GLOBALS['strDownloadGZip']			= "Download (.tar.gz)";

$GLOBALS['strUpdateAlert']		= "Eine neue Version von ".MAX_PRODUCT_NAME." ist verfügbar.                 \n\nWünschen Sie weitere Informationen über dieses Update?";
$GLOBALS['strUpdateAlertSecurity']	= "Eine neue Version von ".MAX_PRODUCT_NAME." ist verfügbar.                 \n\n\nEine kurzfristige Aktualisierung  Ihres Systems \n\nwird empfohlen, da in der neuen Version eine oder \n\nmehrere sicherheitsrelevante Probleme überarbeitet wurden.";

$GLOBALS['strUpdateServerDown']			= "\n    Aus unbekannten Gründen ist es nicht möglich, nach Informationen <br />\n	zu neuen Updates zu prüfen. Versuchen Sie es später noch einmal.\n";

$GLOBALS['strNoNewVersionAvailable']		= "\n	Ihre Version von ".MAX_PRODUCT_NAME." ist aktuell. Es sind keine Updates verfügbar.\n";

$GLOBALS['strNewVersionAvailable']		= "\n	<b>Eine neue Version von ".MAX_PRODUCT_NAME." ist verfügbar. </b><br />Eine kurzfristige Aktualisierung Ihres Systems wird empfohlen,\n 	da in der neuen Version eine oder mehrere sicherheitsrelevante Probleme überarbeitet wurden. Zusätzlich wurden neue Leistungsmerkmale integriert. Weiterführende Information\n 	finden Sie in den unten stehenden Dokumenten.";

$GLOBALS['strSecurityUpdate']			= "\n	<b>Die schnellstmögliche Durchführung dieses Updates wird empfohlen, da eine Reihe von Sicherheitsproblemen behoben wurden.</b>\n	Ihre Version von ".MAX_PRODUCT_NAME." ist gegen illegale Angriffe möglicherweise nicht ausreichend gesichert. Ausführlichere Informationen\n 	finden Sie in den unten stehenden Dokumenten.";


$GLOBALS['strNotAbleToCheck']			= "\n	Auf Ihrem Server ist die XML-Erweiterung nicht verfügbar. ".MAX_PRODUCT_NAME." kann nicht prüfen, ob eine neuere Version verfügbar ist.";

$GLOBALS['strForUpdatesLookOnWebsite']	= "\n	Informationen über neue Versionen .befinden sich auf unserer Webseite.";

$GLOBALS['strClickToVisitWebsite']		= "Zu unserer Webseite ";

$GLOBALS['strCurrentlyUsing'] 			= "Sie nutzen derzeit";
$GLOBALS['strRunningOn']				= "laufend auf";
$GLOBALS['strAndPlain']				= "und";



// Stats conversion
$GLOBALS['strConverting']			= "Konvertierung";
$GLOBALS['strConvertingStats']			= "Statistiken werden konvertiert...";
$GLOBALS['strConvertStats']			= "Statistiken konvertieren";
$GLOBALS['strConvertAdViews']			= "AdViews sind konvertiert,";
$GLOBALS['strConvertAdClicks']			= "AdClicks sind konvertiert...";
$GLOBALS['strConvertAdConversions']			= "AdConversions werden konvertiert...";
$GLOBALS['strConvertNothing']			= "Nichts zu konvertieren...";
$GLOBALS['strConvertFinished']			= "Fertig...";


$GLOBALS['strConvertExplaination']		= "\n	Für die statistische Auswertung verwenden Sie kompakte Darstellung. Es liegen <br />\n	noch ältere Statistiken in detailliertem Format vor. Solange diese detaillierten Statistiken <br />\n	nicht in das kompakte Format konvertiert sind, können sie auf dieser Seite nicht angezeigt<br />\n	werden. Eine Sicherung der Datenbank vor dem Konvertierungslauf wird empfohlen!  <br />\n	Wollen Sie die detaillierten Statistiken in das kompakte Format umwandeln? <br />\n";

$GLOBALS['strConvertingExplaination']		= "\n	Alle verbliebene Statistiken im detaillierten Format werden in das kompakte umgewandelt. <br />\n	Die Dauer des Vorganges ist abhängig von der Anzahl protokollierten Vorgänge. Es kann <br />\n	einige Minuten dauern. Bitte warten Sie bis zum Ende des Konvertierungslauf, bevor Sie <br />\n	andere Seiten aufrufen. Unten wird ein Protokoll der vorgenommenen Datenbankmodifikationen angezeigt. <br />\n";

$GLOBALS['strConvertFinishedExplaination']  	= "\n	Der Konvertierungslauf war erfolgreich.  Die Daten stehen nun wieder zur\n	Verfügung. Nachfolgend ist ein Protokoll aller vorgenommenen Datenbankmodifikationen.<br />\n";



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strCheckBannerCache'] = "Überprüfung des Banner-Cache";
$GLOBALS['strBannerCacheErrorsFound'] = "Die Cache-Überprüfung hat einige Fehler gefunden. Diese Banner werden nicht funktionieren bis das Problem manuell behoben wurde.";
$GLOBALS['strBannerCacheOK'] = "Es wurden keine Fehler gefunden. Der Banner-Cache ist aktuell.";
$GLOBALS['strBannerCacheDifferencesFound'] = "Die Banner-Cache Überprüfung hat ergeben das einige Einträge nicht aktuell sind. Klicken Sie hier um den Cache automatisch zu aktualisieren.";
$GLOBALS['strBannerCacheRebuildButton'] = "Erneuern";
$GLOBALS['strBannerCacheFixed'] = "Die Aktualisierung wurde erfolgreich abgeschlossen.";
$GLOBALS['strEncoding'] = "Kodierung";
$GLOBALS['strEncodingExplaination'] = "". MAX_PRODUCT_NAME ." speichert jetzt alle Daten im UTF-8 Format. Wenn möglich wurden Ihre Daten automatisch in diese Kodierung überführt.<br />Sie können diesen Übersetzer verwenden, wenn Sie nach dem Update fehlerhafte Zeichen finden und Sie die verwendete Kodierung kennen, um die Zeichen in UTF-8 umzuwandeln.";
$GLOBALS['strEncodingConvertFrom'] = "Umwandeln aus der Kodierung:";
$GLOBALS['strEncodingConvert'] = "Konvertieren";
$GLOBALS['strEncodingConvertTest'] = "Konversion prüfen";
$GLOBALS['strConvertThese'] = "Die folgenden Daten werden verändert wenn Sie fortfahren";
$GLOBALS['strAppendCodes'] = "Code-Anhang";
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>Der regelmäßige Wartungslauf ist in der vergangenen Stunde nicht gelaufen, d.h. Sie haben ihn noch nicht richtig eingerichtet.</b>";
$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "Der automatische Wartungslauf ist aktiviert, wurde aber noch nicht ausgeführt. Der automatische Wartungslauf wird ausgeführt wenn ". MAX_PRODUCT_NAME ." Werbemittel ausliefert. Für die bestmögliche Ausführungsgeschwindigkeit sollten Sie den <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>regelmäßigen Wartungslauf einrichten</a>.";
$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "Der automatische Wartungslauf ist im Moment deaktiviert, wenn ". MAX_PRODUCT_NAME ." Werbemittel ausliefert, wird kein automatischer Wartungslauf ausgeführt wird. Um die bestmögliche Ausführungsgeschwindigkeit zu erreichen sollten Sie den <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>regelmäßigen Wartungslauf</a> einrichten. Wenn Sie den <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>regelmäßigen Wartungslauf</a> nicht einrichten möchten, <i>müssen</i> Sie den <a href='account-settings-maintenance.php'>automatischen Wartungslauf einrichten</a> um sicherzustellen das ". MAX_PRODUCT_NAME ." korrekt arbeitet.";
$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "Der automatische Wartungslauf ist aktiviert und wird nach Bedarf ausgeführt wenn ". MAX_PRODUCT_NAME ." Werbemittel ausliefert. Für die bestmögliche Ausführungsgeschwindigkeit sollten Sie den <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>regelmäßigen Wartungslauf einrichten</a>.";
$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "Der automatische Wartungslauf wurde jedoch vor kurzem deaktiviert. Um sicherzustellen das ". MAX_PRODUCT_NAME ." korrekt arbeitet, müssen Sie entweder den <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>regelmäßigen Wartungslauf</a> einrichten, oder den <a href='account-settings-maintenance.php'>automatischen Wartungslauf wieder aktivieren</a>.<br><br>Die die bestmögliche Ausführungsgeschwindigkeit sollten Sie den <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>regelmäßigen Wartungslauf</a> einrichten.";
$GLOBALS['strScheduledMantenaceRunning'] = "<b>Der regelmäßige Wartungslauf ist korrekt eingerichtet.</b>";
$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>Der automatische Wartungslauf läuft korrekt.</b>";
$GLOBALS['strAutoMantenaceEnabled'] = "Der automatische Wartungslauf ist jedoch immer noch aktiviert. Für eine bestmögliche Ausführungsgeschwindigkeit sollten Sie den <a href='account-settings-maintenance.php'>automatischen Wartungslauf deaktivieren</a>.";
$GLOBALS['strAutoMaintenanceDisabled'] = "Der automatische Wartungslauf ist deaktiviert.";
$GLOBALS['strAutoMaintenanceEnabled'] = "Der automatische Wartungslauf ist aktiviert. Für eine bestmögliche Ausführungsgeschwindigkeit sollten Sie den <a href='settings-admin.php'>automatischen Wartungslauf deaktivieren</a>.";
$GLOBALS['strCheckACLs'] = "ACLs überprüfen";
$GLOBALS['strScheduledMaintenance'] = "Der regelmäßige Wartungslauf scheint korrekt eingerichtet zu sein.";
$GLOBALS['strAutoMaintenanceEnabledNotTriggered'] = "Der automatische Wartungslauf ist aktiviert, aber noch nicht ausgeführt worden. Bitte beachten Sie, das der automatische Wartungslauf nur durch die Auslieferung von Werbemitteln ausgeführt wird.";
$GLOBALS['strAutoMaintenanceBestPerformance'] = "Für eine bestmögliche Ausführungsgeschwindigkeit ist es ratsam den <a href='". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>regelmäßigen Wartungslauf einzurichten</a>.";
$GLOBALS['strAutoMaintenanceEnabledWilltTrigger'] = "Der automatische Wartungslauf ist aktiviert und wird den Wartungslauf jede Stunde einmal starten.";
$GLOBALS['strAutoMaintenanceDisabledMaintenanceRan'] = "Auch der automatische Wartungslauf ist deaktiviert, vor kurzem ist jedoch ein Wartungslauf ausgeführt worden. Um sicherzustellen das ". MAX_PRODUCT_NAME ." korrekt arbeitet sollten Sie entweder den <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>regelmäßigen Wartungslauf</a> einrichten oder den <a href='settings-admin.php'>automatischen Wartungslauf aktivieren</a>.";
$GLOBALS['strAutoMaintenanceDisabledNotTriggered'] = "Auch der automatische Wartungslauf ist deaktiviert, so daß wenn ". MAX_PRODUCT_NAME ." Werbemittel ausliefert kein Wartungslauf ausgeführt wird. Wenn Sie nicht vorhaben den <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>regelmäßigen Wartungslauf</a> einzurichten, müssen Sie den <a href='settings-admin.php'>automatischen Wartungslauf aktivieren</a> um sicherzustellen das ". MAX_PRODUCT_NAME ." korrekt arbeitet.";
$GLOBALS['strAllBannerChannelCompiled'] = "Alle Auslieferungsbeschränkungen der Banner und Gruppen wurden neu übersetzt.";
$GLOBALS['strBannerChannelResult'] = "Hier die Ergebnisse der Übersetzung und Überprüfung der Auslieferungsbeschränkungen der Banner und Gruppen";
$GLOBALS['strChannelCompiledLimitationsValid'] = "Alle Auslieferungsbeschränkungen der Gruppen ist gültig.";
$GLOBALS['strBannerCompiledLimitationsValid'] = "Alle Auslieferungsbeschränkungen der Banner ist gültig.";
$GLOBALS['strErrorsFound'] = "Fehler gefunden";
$GLOBALS['strRepairCompiledLimitations'] = "Obige Inkonsistenzen wurden ermittelt. Sie können diese reparieren durch die Verwendung des unten stehenden Buttons. Hierbei wird das System die Auslieferungsbeschränkungen jedes Banners und jeder Gruppe im System neu übersetzen.<br />";
$GLOBALS['strRecompile'] = "Neu übersetzen";
$GLOBALS['strAppendCodesDesc'] = "Unter manchen Umständen kann das Auslieferungsmodul den gespeicherten Code-Anhang der Tracker nicht korrekt verarbeiten. Verwenden Sie den folgenden Link um die in der Datenbank gespeicherten Codes zu überprüfen.";
$GLOBALS['strCheckAppendCodes'] = "Code Anhänge prüfen";
$GLOBALS['strAppendCodesRecompiled'] = "Alle übersetzten Code Anhänge wurden neu übersetzt";
$GLOBALS['strAppendCodesResult'] = "Hier sind die Ergebnisse der Überprüfung des Code Anhänge";
$GLOBALS['strAppendCodesValid'] = "Alle Tracker Code Anhänge sind korrekt";
$GLOBALS['strRepairAppenedCodes'] = "Obige Inkonsistenzen wurden ermittelt. Sie können diese reparieren durch die Verwendung des unten stehenden Buttons. Hierbei wird das System die Code Anhänge jedes Trackers im System neu übersetzen.";
$GLOBALS['strScheduledMaintenanceNotRun'] = "Der regelmäßige Wartungslauf ist in der vergangenen Stunde nicht gelaufen, dies könnte bedeuten das Sie ihn noch nicht richtig eingerichtet haben.";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "Unter manchen Umständen kann das Auslieferungsmodul die gespeicherten ACLs der Banner und Gruppen nicht korrekt verarbeiten. Verwenden Sie den folgenden Link um die in der Datenbank gespeicherten ACLs zu überprüfen.";
$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strPluginsPrecis'] = "Probleme mit den OpenX-Plugins überprüfen und reparieren";
$GLOBALS['strPluginsOk'] = "Keine Probleme gefunden";
$GLOBALS['strMenus'] = "Menüs";
$GLOBALS['strMenusPrecis'] = "Den Menü-Cache wiederaufbauen";
$GLOBALS['strMenusCachedOk'] = "Der Menü-Cache wurde wiederaufgebaut";
$GLOBALS['strMenusCachedErr'] = "Fehler beim Wiederaufbau des Menü-Caches";
$GLOBALS['strServerCommunicationError'] = "<b>Die Kommunikation mit dem Updateserver wurde mit einem Timeout beendet. ".MAX_PRODUCT_NAME." kann zu diesem Zeitpunkt nicht feststellen ob eine neuere Version verfügbar ist. Bitte versuchen Sie es später noch einmal.</b>";
$GLOBALS['strCheckForUpdatesDisabled'] = "<b>Die Prüfung auf Updates ist ausgeschaltet. Bitte aktivieren Sie die Prüfung auf der <a href='account-settings-update.php'>Update Einstellungsseite</a>.</b>";
?>