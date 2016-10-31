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
$GLOBALS['strWelcomeTitle'] = "Welkom bij {$PRODUCT_NAME}";
$GLOBALS['strInstallIntro'] = "Dank u voor het kiezen van {$PRODUCT_NAME}. Deze wizard begeleidt u door het proces van het installeren van {$PRODUCT_NAME}.";
$GLOBALS['strUpgradeIntro'] = "Dank u voor het kiezen van {$PRODUCT_NAME}. Deze wizard begeleidt u door het upgrade proces  van {$PRODUCT_NAME}.";
$GLOBALS['strInstallerHelpIntro'] = "Om u te helpen met het installatieproces van {$PRODUCT_NAME}, adviseren we u de <a href='{$PRODUCT_DOCSURL}' target='_blank'> documentatie</a> te raadplegen.";
$GLOBALS['strTermsIntro'] = "{$PRODUCT_NAME} wordt vrij gedistribueerd onder een Open Source licentie, de GNU General Public License. Bekijk en ga akkoord met de volgende documenten om verder te gaan met de installatie.";

/** check step * */
$GLOBALS['strSystemCheck'] = "Systeemcontrole";
$GLOBALS['strSystemCheckIntro'] = "De installatiewizard heeft een controle uitgevoerd van uw webserver-instellingen, om zeker te weten dat het installatieproces goed kan worden uitgevoerd..
                                                  <br>Controleer de aangegeven punten om het installatieproces te completeren.";
$GLOBALS['strFixErrorsBeforeContinuing'] = "De configuratie van uw webserver voldoet niet aan de eisen van {$PRODUCT_NAME}.                                                    <br>Om verder te gaan met de installatie, moet u eerst alle fouten corrigeren.                                                    Voor hulp, zie onze <a href='{$PRODUCT_DOCSURL}'> documentatie</a> en <a href='http://{$PRODUCT_URL}/faq'>Veel gestelde gestelde vragen</a>.";

$GLOBALS['strAppCheckErrors'] = "Er zijn fouten gevonden bij het opsporen van vorige installaties van {$PRODUCT_NAME}";
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
$GLOBALS['strAdminLoginTitle'] = "Gelieve in te loggen als uw {$PRODUCT_NAME} administrator";
$GLOBALS['strAdminLoginIntro'] = "Voer uw inloggegevens voor {$PRODUCT_NAME} systeembeheerder account in om verder te gaan.";
$GLOBALS['strLoginProgressMessage'] = 'Inloggen...';

/** database step * */
$GLOBALS['strDbSetupTitle'] = "Geef uw database informatie";
$GLOBALS['strDbSetupIntro'] = "Voer de informatie in om verbinding te maken met uw database voor  {$PRODUCT_NAME}.";
$GLOBALS['strDbUpgradeTitle'] = "Uw database is gedetecteerd";
$GLOBALS['strDbUpgradeIntro'] = "De volgende database is gedetecteerd voor uw installatie van {$PRODUCT_NAME}.                                                    Gelieve te verifiëren dat dit correct is en klik op \"Doorgaan\" om verder te gaan.";
$GLOBALS['strDbProgressMessageInstall'] = 'Database aanmaken...';
$GLOBALS['strDbProgressMessageUpgrade'] = 'Database bijwerken...';
$GLOBALS['strDbSeeMoreFields'] = 'Bekijk extra databasevelden...';
$GLOBALS['strDbTimeZoneWarning'] = "<p>Vanaf deze versie van {$PRODUCT_NAME} worden datums in UTC-tijd in plaats van servertijd opgeslagen.</p>                                                    <p>Als u wilt dat historische statistieken moet worden weergegeven met de juiste tijdzone, upgrade dan uw gegevens handmatig.  Meer informatie <a target='help' href='%s'> hier</a>.                                                       Uw statistieken waarden zal nauwkeurig blijven, zelfs als u uw gegevens ongewijzigd laat.                                                    </p>";
$GLOBALS['strDbTimeZoneNoWarnings'] = "Toon in de toekomst geen waarschuwingen over tijdzones";
$GLOBALS['strDBInstallSuccess'] = "Database correct aangemaakt";
$GLOBALS['strDBUpgradeSuccess'] = "Database met success bijgewerkt";

$GLOBALS['strDetectedVersion'] = "Gedetecteerde {$PRODUCT_NAME} versie";

/** config step * */
$GLOBALS['strConfigureInstallTitle'] = "Uw lokale {$PRODUCT_NAME} systeem administrator-account configureren";
$GLOBALS['strConfigureInstallIntro'] = "Geef de gewenste aanmeldingsgegevens voor uw lokale {$PRODUCT_NAME} systeem administrator-account.";
$GLOBALS['strConfigureUpgradeTitle'] = "Configuratie-instellingen";
$GLOBALS['strConfigureUpgradeIntro'] = "Geef het pad naar uw vorige installatie van {$PRODUCT_NAME}.";
$GLOBALS['strConfigSeeMoreFields'] = "Bekijk meer configuratie-velden...";
$GLOBALS['strPreviousInstallTitle'] = "Vorige installatie";
$GLOBALS['strPathToPrevious'] = "Pad naar eerdere {$PRODUCT_NAME} installatie";
$GLOBALS['strPathToPreviousError'] = "Een of meerdere plugin bestanden konden niet worden gevonden, bekijk het bestand install.log voor meer informatie";
$GLOBALS['strConfigureProgressMessage'] = "Configureren van {$PRODUCT_NAME}...";

/** jobs step * */
$GLOBALS['strJobsInstallTitle'] = "De taken van de installatie worden uitgevoerd";
$GLOBALS['strJobsInstallIntro'] = "De Installer voert nu de laatste installatie-taken uit.";
$GLOBALS['strJobsUpgradeTitle'] = "Upgrade taken uitvoeren";
$GLOBALS['strJobsUpgradeIntro'] = "De Installer voert nu de laatste upgrade taken uit.";
$GLOBALS['strJobsProgressInstallMessage'] = "Installatie taken uitvoeren...";
$GLOBALS['strJobsProgressUpgradeMessage'] = "Upgrade taken uitvoeren...";

$GLOBALS['strPluginTaskChecking'] = "Controle {$PRODUCT_NAME} Plugin";
$GLOBALS['strPluginTaskInstalling'] = "Installeren van {$PRODUCT_NAME} Plugin";
$GLOBALS['strPostInstallTaskRunning'] = "Taak uitvoeren";

/** finish step * */
$GLOBALS['strFinishInstallTitle'] = "Uw {$PRODUCT_NAME}-installatie is voltooid.";
$GLOBALS['strFinishUpgradeWithErrorsTitle'] = "Uw {$PRODUCT_NAME}-upgrade is voltooid. Controleer de aangegeven punten.";
$GLOBALS['strFinishUpgradeTitle'] = "Uw {$PRODUCT_NAME}-upgrade is voltooid.";
$GLOBALS['strFinishInstallWithErrorsTitle'] = "Uw {$PRODUCT_NAME}-installatie is voltooid. Controleer alstublieft de aangegeven punten.";
$GLOBALS['strDetailedTaskErrorList'] = "Gedetailleerde lijst van gevonden fouten";
$GLOBALS['strPluginInstallFailed'] = "Installatie van plugin '%s' is mislukt:";
$GLOBALS['strTaskInstallFailed'] = "Fout opgetreden bij het uitvoeren van installatie taak '%s':";
$GLOBALS['strContinueToLogin'] = "Klik op \"Doorgaan\" om in te loggen in uw {$PRODUCT_NAME}-installatie.";

$GLOBALS['strUnableCreateConfFile'] = "Wij zijn niet in staat om uw configuratiebestand te maken. Controleer de permissies van de map {$PRODUCT_NAME} var opnieuw.";
$GLOBALS['strUnableUpdateConfFile'] = "Wij zijn niet in staat om uw configuratiebestand bij te werken. Controleer de permissies  van de map {$PRODUCT_NAME} var opnieuw, en ook de permissies van het configuratiebestand van de vorige installatie dat u heeft gekopieerd naar deze map.";
$GLOBALS['strUnableToCreateAdmin'] = "We zijn niet in staat om een systeembeheerder-account te maken, is de database toegankelijk?";
$GLOBALS['strTimezoneLocal'] = "{$PRODUCT_NAME} heeft gedetecteerd dat uw PHP installatie \"Systeem/Localtime\" als de tijdzone van uw server terug meldt. Dit is vanwege een patch aan PHP, toegepast door sommige Linuxdistributies. Helaas, dit is niet een geldige PHP tijdzone. Gelieve je php.ini-bestand bewerken en instellen van de \"date.timezone\"property op de juiste waarde voor uw server.";

$GLOBALS['strInstallNonBlockingErrors'] = "Er is een fout opgetreden bij het uitvoeren van installatietaken. Bestudeer alstublieft de <a class=\"show-errors\" href=\"#\">lijst met fouten</a> en het bestand install. log in \\'%s\\' voor meer details.
U kunt nog steeds inloggen op uw {$PRODUCT_NAME} installatie.";
