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
$GLOBALS['strWelcomeTitle'] = "Willkommen bei {$PRODUCT_NAME}";
$GLOBALS['strInstallIntro'] = "Vielen Dank, dass Sie {$PRODUCT_NAME} gewählt haben. Dieser Assistent führt Sie durch die Installation von {$PRODUCT_NAME}.";
$GLOBALS['strUpgradeIntro'] = "Vielen Dank, dass Sie {$PRODUCT_NAME} gewählt haben. Dieser Assistent führt Sie durch das Upgrade von {$PRODUCT_NAME}.";
$GLOBALS['strInstallerHelpIntro'] = "Um Sie mit der Installation {$PRODUCT_NAME} unterstützen, finden Sie in der <a href='{$PRODUCT_DOCSURL}' target='_blank'> Dokumentation</a>.";
$GLOBALS['strTermsIntro'] = "{$PRODUCT_NAME} wird frei verfügbar unter einer Open Source Lizenz, der GNU General Public License vertrieben. Überprüfen und akzeptieren Sie die folgenden Dokumente, um die Installation fortzusetzen.";

/** check step * */
$GLOBALS['strSystemCheck'] = "Systemüberprüfung";
$GLOBALS['strSystemCheckIntro'] = "Der Installationsassistent überprüft die Einstellungen Ihres Webservers, um sicherzustellen, dass die Installation erfolgreich durchgeführt werden kann.
<br>Bitte korrigieren Sie alle markierten Warnungen, um die Installation zu vervollständigen.";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Die Konfiguration Ihres Webservers erfüllt nicht die Vorasusetzungen von {$PRODUCT_NAME}.
<br>Bitte beheben Sie alle Fehler, um fortzufahren.
Für weitere Hilfe, lesen Sie bitte unsere <a href='{$PRODUCT_DOCSURL}'>Anleitung</a> und<a href='http://{$PRODUCT_URL}/faq'>FAQs</a>";

$GLOBALS['strAppCheckErrors'] = "Es wurden Fehler bei einer älteren Installation von {$PRODUCT_NAME} gefunden";
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
$GLOBALS['strAdminLoginTitle'] = "Bitte als {$PRODUCT_NAME} Administrator anmelden";
$GLOBALS['strAdminLoginIntro'] = "Um fortzufahren, geben Sie bitte Ihre Login-Daten für {$PRODUCT_NAME} System Administrator Konto ein.";
$GLOBALS['strLoginProgressMessage'] = 'Einloggen...';

/** database step * */
$GLOBALS['strDbSetupTitle'] = "Bitte Datenbank angeben";
$GLOBALS['strDbSetupIntro'] = "Bitte Details angeben, um mit der Datenbank von {$PRODUCT_NAME} zu verbinden.";
$GLOBALS['strDbUpgradeTitle'] = "Die Datenbank wurde erkannt";
$GLOBALS['strDbUpgradeIntro'] = "Die folgende Datenbank wurde für die Installation von {$PRODUCT_NAME} erkannt.                                                    Bitte stellen Sie sicher, dass dies richtig ist, dann klicken Sie auf \"Weiter\" um fortzufahren.";
$GLOBALS['strDbProgressMessageInstall'] = 'Installiere Datenbank...';
$GLOBALS['strDbProgressMessageUpgrade'] = 'Upgrade Datenbank...';
$GLOBALS['strDbSeeMoreFields'] = 'Weitere Datenbankfelder anzeigen...';
$GLOBALS['strDbTimeZoneWarning'] = "<p>Ab dieser Version {$PRODUCT_NAME} werden Datumsangaben als UTC-Zeit und nicht in Server-Zeit gespeichert.</p>                                                    <p>Möchten Sie historische Statistiken mit der richtigen Zeitzone angezeigen, werden Ihre Daten manuell aktualisiert.  Erfahren Sie mehr <a target='help' href='%s'> hier</a>.                                                       Die Statistikwerte werden präzise bleiben, auch wenn Sie Ihre Daten unberührt lassen.                                                    </p>";
$GLOBALS['strDbTimeZoneNoWarnings'] = "Zeige in Zukunft keine Warnungen zur Zeitzone mehr an";
$GLOBALS['strDBInstallSuccess'] = "Datenbank wurde erfolgreich erstellt";
$GLOBALS['strDBUpgradeSuccess'] = "Datenbank erfolgreich aktualisiert";

$GLOBALS['strDetectedVersion'] = "Version {$PRODUCT_NAME} erkannt";

/** config step * */
$GLOBALS['strConfigureInstallTitle'] = "Konfigurieren Sie Ihr lokales {$PRODUCT_NAME} System-Administrator-Konto";
$GLOBALS['strConfigureInstallIntro'] = "Bitte die gewünschten Login-Informationen für Ihr lokales {$PRODUCT_NAME} System-Administrator Konto angeben.";
$GLOBALS['strConfigureUpgradeTitle'] = "Konfigurationseinstellungen";
$GLOBALS['strConfigureUpgradeIntro'] = "Bitte Pfad zur vorherigen {$PRODUCT_NAME} Installation angeben.";
$GLOBALS['strConfigSeeMoreFields'] = "Mehr Konfigurationsfelder zeigen...";
$GLOBALS['strPreviousInstallTitle'] = "Vorherige Installation";
$GLOBALS['strPathToPrevious'] = "Pfad zu vorheriger {$PRODUCT_NAME} Installation";
$GLOBALS['strPathToPreviousError'] = "Eine oder mehrere Plugin-Dateien konnte nicht gefunden werden. Bitte die Datei install.log für weitere Details ansehen";
$GLOBALS['strConfigureProgressMessage'] = "Konfigurieren von {$PRODUCT_NAME}...";

/** jobs step * */
$GLOBALS['strJobsInstallTitle'] = "Installationsschritte durchführen";
$GLOBALS['strJobsInstallIntro'] = "Der Installer führt letzte Installationsschritte durch.";
$GLOBALS['strJobsUpgradeTitle'] = "Updateschritte durchführen";
$GLOBALS['strJobsUpgradeIntro'] = "Der Installer führt letzte Updateschritte durch.";
$GLOBALS['strJobsProgressInstallMessage'] = "Führe Installation durch...";
$GLOBALS['strJobsProgressUpgradeMessage'] = "Führe Upgrade durch...";

$GLOBALS['strPluginTaskChecking'] = "Prüfe {$PRODUCT_NAME} Plugin";
$GLOBALS['strPluginTaskInstalling'] = "Installiere {$PRODUCT_NAME} Plugin";
$GLOBALS['strPostInstallTaskRunning'] = "Ausführen";

/** finish step * */
$GLOBALS['strFinishInstallTitle'] = "Ihre {$PRODUCT_NAME} Installation ist beendet.";
$GLOBALS['strFinishUpgradeWithErrorsTitle'] = "Ihr {$PRODUCT_NAME} Upgrade ist beendet. Bitte überprüfen Sie die markierten Fehler.";
$GLOBALS['strFinishUpgradeTitle'] = "Ihr {$PRODUCT_NAME} Upgrade ist beendet.";
$GLOBALS['strFinishInstallWithErrorsTitle'] = "Ihre {$PRODUCT_NAME} Installation ist beendet. Bitte überprüfen Sie die markierten Fehler.";
$GLOBALS['strDetailedTaskErrorList'] = "Detaillierte Fehlerliste gefunden";
$GLOBALS['strPluginInstallFailed'] = "Die Installation des Plugins \"%s\" ist fehlgeschlagen:";
$GLOBALS['strTaskInstallFailed'] = "Fehler beim Installationsschritt \"%s\" aufgetreten:";
$GLOBALS['strContinueToLogin'] = "Klicken Sie \"Weiter\", um sich in Ihrer {$PRODUCT_NAME} Installation einzuloggen.";

$GLOBALS['strUnableCreateConfFile'] = "Die Konfigurationsdatei konnte nicht erzeugt werden. Bitte prüfen Sie die Rechte des {$PRODUCT_NAME} var Verzeichnisses.";
$GLOBALS['strUnableUpdateConfFile'] = "Es ist nicht möglich die Konfigurationsdatei zu ändern. Bitte überprüfen Sie die Lese- und Schreibrechte des {$PRODUCT_NAME} var-Verzeichnisses, sowie der Konfigurationsdatei der Vorgängerversion die Sie in dieses Verzeichnis kopiert haben.";
$GLOBALS['strUnableToCreateAdmin'] = "Wir können keinen Adminstrator-Account anlegen. Ist Ihre Datenbank ansprechbar?";
$GLOBALS['strTimezoneLocal'] = "{$PRODUCT_NAME} hat festgestellt, dass Ihre PHP Installation 'System/Localtime' als Zeitzone des
Servers zurückliefert. Dies wurde durch eine gepatchte PHP hervorgerufen, die bei manchen Linux-Distributionen durchgeführt wird.
Leider ist das keine gültige PHP-Zeitzone. Bitte ändern Sie ihre php.ini Datei und setzen den Wert für 'date.timezone' auf einen gültigen Wert für Ihren Server.";

