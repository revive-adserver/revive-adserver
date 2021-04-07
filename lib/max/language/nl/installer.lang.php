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
$GLOBALS['strInstallStatusRecovery'] = 'Revive Adserver %s herstellen';
$GLOBALS['strInstallStatusInstall'] = 'Revive Adserver %s installeren';
$GLOBALS['strInstallStatusUpgrade'] = 'Upgrade naar Revive Adserver %s';
$GLOBALS['strInstallStatusUpToDate'] = 'Revive Adserver %s gedetecteerd';

/** welcome step * */

/** check step * */
$GLOBALS['strSystemCheck'] = "Systeemcontrole";
$GLOBALS['strSystemCheckIntro'] = "De installatiewizard heeft een controle uitgevoerd van uw webserver-instellingen, om zeker te weten dat het installatieproces goed kan worden uitgevoerd..
                                                  <br>Controleer de aangegeven punten om het installatieproces te completeren.";

$GLOBALS['strAppCheckDbIntegrityError'] = "We hebben integriteitsproblemen gevonden in uw database. Dat betekent dat de layout van uw database verschilt van wat er werd verwacht. Dit kan komen door aanpassingen aan uw database.";

$GLOBALS['strSyscheckProgressMessage'] = "Systeemparameters controleren...";
$GLOBALS['strError'] = "Fout";
$GLOBALS['strWarning'] = "Waarschuwing";
$GLOBALS['strOK'] = "OK";
$GLOBALS['strSyscheckName'] = "Naam van de controle";
$GLOBALS['strSyscheckValue'] = "Huidige waarde";
$GLOBALS['strSyscheckStatus'] = "Status";
$GLOBALS['strSyscheckSeeFullReport'] = "Toon gedetailleerde systeemcontrole";
$GLOBALS['strSyscheckSeeShortReport'] = "Alleen fouten en waarschuwingen weergeven";
$GLOBALS['strBrowserCookies'] = 'Browsercookies';
$GLOBALS['strPHPConfiguration'] = 'PHP configuratie';
$GLOBALS['strCheckError'] = 'fout';
$GLOBALS['strCheckErrors'] = 'fouten';
$GLOBALS['strCheckWarning'] = 'waarschuwing';
$GLOBALS['strCheckWarnings'] = 'waarschuwingen';

/** admin login step * */
$GLOBALS['strLoginProgressMessage'] = 'Inloggen...';

/** database step * */
$GLOBALS['strDbSetupTitle'] = "Geef uw database informatie";
$GLOBALS['strDbUpgradeTitle'] = "Uw database is gedetecteerd";
$GLOBALS['strDbProgressMessageInstall'] = 'Database aanmaken...';
$GLOBALS['strDbProgressMessageUpgrade'] = 'Database bijwerken...';
$GLOBALS['strDbSeeMoreFields'] = 'Bekijk extra databasevelden...';
$GLOBALS['strDbTimeZoneNoWarnings'] = "Toon in de toekomst geen waarschuwingen over tijdzones";
$GLOBALS['strDBInstallSuccess'] = "Database correct aangemaakt";
$GLOBALS['strDBUpgradeSuccess'] = "Database met success bijgewerkt";


/** config step * */
$GLOBALS['strConfigureUpgradeTitle'] = "Configuratie-instellingen";
$GLOBALS['strConfigSeeMoreFields'] = "Bekijk meer configuratie-velden...";
$GLOBALS['strPreviousInstallTitle'] = "Vorige installatie";
$GLOBALS['strPathToPreviousError'] = "Een of meerdere plugin bestanden konden niet worden gevonden, bekijk het bestand install.log voor meer informatie";

/** jobs step * */
$GLOBALS['strJobsInstallTitle'] = "De taken van de installatie worden uitgevoerd";
$GLOBALS['strJobsInstallIntro'] = "De Installer voert nu de laatste installatie-taken uit.";
$GLOBALS['strJobsUpgradeTitle'] = "Upgrade taken uitvoeren";
$GLOBALS['strJobsUpgradeIntro'] = "De Installer voert nu de laatste upgrade taken uit.";
$GLOBALS['strJobsProgressInstallMessage'] = "Installatie taken uitvoeren...";
$GLOBALS['strJobsProgressUpgradeMessage'] = "Upgrade taken uitvoeren...";

$GLOBALS['strPostInstallTaskRunning'] = "Taak uitvoeren";

/** finish step * */
$GLOBALS['strDetailedTaskErrorList'] = "Gedetailleerde lijst van gevonden fouten";
$GLOBALS['strPluginInstallFailed'] = "Installatie van plugin '%s' is mislukt:";
$GLOBALS['strTaskInstallFailed'] = "Fout opgetreden bij het uitvoeren van installatie taak '%s':";

$GLOBALS['strUnableToCreateAdmin'] = "We zijn niet in staat om een systeembeheerder-account te maken, is de database toegankelijk?";

