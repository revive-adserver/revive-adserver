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

/** status messages * */
$GLOBALS['strInstallStatusRecovery'] = 'Revive Adserver %s wiederherstellen';
$GLOBALS['strInstallStatusInstall'] = 'Revive Adserver %s installieren';
$GLOBALS['strInstallStatusUpgrade'] = 'Auf Revive Adserver %s upgraden';
$GLOBALS['strInstallStatusUpToDate'] = 'Revive Adserver %s gefunden';

/** welcome step * */

/** check step * */
$GLOBALS['strSystemCheck'] = "Systemüberprüfung";
$GLOBALS['strSystemCheckIntro'] = "Der Installationsassistent überprüft die Einstellungen Ihres Webservers, um sicherzustellen, dass die Installation erfolgreich durchgeführt werden kann.
<br>Bitte korrigieren Sie alle markierten Warnungen, um die Installation zu vervollständigen.";

$GLOBALS['strAppCheckDbIntegrityError'] = "Wir haben Unstimmigkeiten der Integrität Ihrer Datenbank gefunden. D.h. die Struktur Ihrer Datenbank unterscheidet sich von dem, was erwartet wird. Dies könnte durch manuelle Änderungen an Ihrer  Datenbank kommen.";

$GLOBALS['strSyscheckProgressMessage'] = "Systemparameter überprüfen...";
$GLOBALS['strError'] = "Fehler";
$GLOBALS['strWarning'] = "Warnung";
$GLOBALS['strOK'] = "Ok";
$GLOBALS['strSyscheckName'] = "Namen überprüfen";
$GLOBALS['strSyscheckValue'] = "Aktueller Wert";
$GLOBALS['strSyscheckStatus'] = "Status";
$GLOBALS['strSyscheckSeeFullReport'] = "Zeige detailliertere Systemprüfung";
$GLOBALS['strSyscheckSeeShortReport'] = "Zeige nur Fehler und Warnungen";
$GLOBALS['strBrowserCookies'] = 'Browser-Cookies';
$GLOBALS['strPHPConfiguration'] = 'PHP-Konfiguration';
$GLOBALS['strCheckError'] = 'Fehler';
$GLOBALS['strCheckErrors'] = 'Fehler';
$GLOBALS['strCheckWarning'] = 'Warnung';
$GLOBALS['strCheckWarnings'] = 'Warnungen';

/** admin login step * */
$GLOBALS['strLoginProgressMessage'] = 'Einloggen...';

/** database step * */
$GLOBALS['strDbSetupTitle'] = "Bitte Datenbank angeben";
$GLOBALS['strDbUpgradeTitle'] = "Die Datenbank wurde erkannt";
$GLOBALS['strDbProgressMessageInstall'] = 'Installiere Datenbank...';
$GLOBALS['strDbProgressMessageUpgrade'] = 'Upgrade Datenbank...';
$GLOBALS['strDbSeeMoreFields'] = 'Weitere Datenbankfelder anzeigen...';
$GLOBALS['strDbTimeZoneNoWarnings'] = "Zeige in Zukunft keine Warnungen zur Zeitzone mehr an";
$GLOBALS['strDBInstallSuccess'] = "Datenbank wurde erfolgreich erstellt";
$GLOBALS['strDBUpgradeSuccess'] = "Datenbank erfolgreich aktualisiert";


/** config step * */
$GLOBALS['strConfigureUpgradeTitle'] = "Konfigurationseinstellungen";
$GLOBALS['strConfigSeeMoreFields'] = "Mehr Konfigurationsfelder zeigen...";
$GLOBALS['strPreviousInstallTitle'] = "Vorherige Installation";
$GLOBALS['strPathToPreviousError'] = "Eine oder mehrere Plugin-Dateien konnte nicht gefunden werden. Bitte die Datei install.log für weitere Details ansehen";

/** jobs step * */
$GLOBALS['strJobsInstallTitle'] = "Installationsschritte durchführen";
$GLOBALS['strJobsInstallIntro'] = "Der Installer führt letzte Installationsschritte durch.";
$GLOBALS['strJobsUpgradeTitle'] = "Updateschritte durchführen";
$GLOBALS['strJobsUpgradeIntro'] = "Der Installer führt letzte Updateschritte durch.";
$GLOBALS['strJobsProgressInstallMessage'] = "Führe Installation durch...";
$GLOBALS['strJobsProgressUpgradeMessage'] = "Führe Upgrade durch...";

$GLOBALS['strPostInstallTaskRunning'] = "Ausführen";

/** finish step * */
$GLOBALS['strDetailedTaskErrorList'] = "Detaillierte Fehlerliste gefunden";
$GLOBALS['strPluginInstallFailed'] = "Die Installation des Plugins \"%s\" ist fehlgeschlagen:";
$GLOBALS['strTaskInstallFailed'] = "Fehler beim Installationsschritt \"%s\" aufgetreten:";

$GLOBALS['strUnableToCreateAdmin'] = "Wir können keinen Adminstrator-Account anlegen. Ist Ihre Datenbank ansprechbar?";

