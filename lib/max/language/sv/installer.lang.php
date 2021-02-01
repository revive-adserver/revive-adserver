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
$GLOBALS['strInstallStatusRecovery'] = 'Återställa Revive Adserver %s';
$GLOBALS['strInstallStatusInstall'] = 'Installera ReviveAdserver %s';
$GLOBALS['strInstallStatusUpgrade'] = 'Uppgradera till Revive Adserver %s';
$GLOBALS['strInstallStatusUpToDate'] = 'Upptäckte Revive Adserver %s';

/** welcome step * */
$GLOBALS['strWelcomeTitle'] = "Välkommen till {$PRODUCT_NAME}";
$GLOBALS['strInstallIntro'] = "Tack för att du valde {$PRODUCT_NAME}. Guiden vägleder dig genom processen att installera {$PRODUCT_NAME}.";
$GLOBALS['strUpgradeIntro'] = "Tack för att du valde {$PRODUCT_NAME}. Guiden vägleder dig genom processen att uppgradera {$PRODUCT_NAME}.";
$GLOBALS['strInstallerHelpIntro'] = "För att hjälpa dig med installationen av {$PRODUCT_NAME}, se <a href='{$PRODUCT_DOCSURL}' target='_blank'>dokumentationen</a>.";
$GLOBALS['strTermsIntro'] = "{$PRODUCT_NAME} distribueras fritt under en öppen källkodslicens, GNU General Public License. Vänligen läs och godkänn följande dokument för att fortsätta installationen.";

/** check step * */
$GLOBALS['strSystemCheck'] = "Systemkontroll";
$GLOBALS['strSystemCheckIntro'] = "Installationsguiden har utfört en kontroll av dina serverinställningar för att försäkra sig om  att installationen kan slutföras.
                                                  <br>Vänligen kontrollera eventuella markerade problem för att slutföra installationsprocessen.";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Konfigurationen på din webbserver uppfyller inte kraven för {$PRODUCT_NAME}.
                                                   <br>för att fortsätta med installationen, vänligen åtgärda alla fel.
                                                   för hjälp, se vår <a href='{$PRODUCT_DOCSURL}'>dokumentation</a> och <a href='http://{$PRODUCT_URL}/faq'>vanliga frågor</a>";

$GLOBALS['strAppCheckErrors'] = "Fel påträffades med upptäckt av tidigare installationer av {$PRODUCT_NAME}";
$GLOBALS['strAppCheckDbIntegrityError'] = "Vi har upptäckt integritetsproblem med databasen. Detta innebär att strukturen för din databas
                                                   skiljer sig från vad vi förväntar oss att det ska vara. Detta kan bero på anpassningar av databasen.";

$GLOBALS['strSyscheckProgressMessage'] = "Kontrollera systemparametrar...";
$GLOBALS['strError'] = "Fel";
$GLOBALS['strWarning'] = "Varning";
$GLOBALS['strOK'] = "OK";
$GLOBALS['strSyscheckName'] = "Kontrollera namn";
$GLOBALS['strSyscheckValue'] = "Nuvarande värde";
$GLOBALS['strSyscheckStatus'] = "Status";
$GLOBALS['strSyscheckSeeFullReport'] = "Visa detaljerad systemkontroll";
$GLOBALS['strSyscheckSeeShortReport'] = "Visa bara fel och varningar";
$GLOBALS['strBrowserCookies'] = 'Cookies i webbläsaren';
$GLOBALS['strPHPConfiguration'] = 'PHP-konfigurationen';
$GLOBALS['strCheckError'] = 'fel';
$GLOBALS['strCheckErrors'] = 'fel';
$GLOBALS['strCheckWarning'] = 'varning';
$GLOBALS['strCheckWarnings'] = 'varningar';

/** admin login step * */
$GLOBALS['strAdminLoginTitle'] = "Vänligen logga in som administratör för {$PRODUCT_NAME}";
$GLOBALS['strAdminLoginIntro'] = "To continue, please enter your {$PRODUCT_NAME} system administrator account login information.";
$GLOBALS['strLoginProgressMessage'] = 'Loggar in...';

/** database step * */
$GLOBALS['strDbSetupTitle'] = "Ange din databas";
$GLOBALS['strDbSetupIntro'] = "Ange uppgifter för att ansluta till {$PRODUCT_NAME} -databasen.";
$GLOBALS['strDbUpgradeTitle'] = "Din databas har hittats";
$GLOBALS['strDbUpgradeIntro'] = "Följande databaser har hittats för din installation av {$PRODUCT_NAME}.
                                                   vänligen kontrollera att detta är korrekt och klicka sedan ”Fortsätt” för att fortsätta.";
$GLOBALS['strDbProgressMessageInstall'] = 'Installerar databas...';
$GLOBALS['strDbProgressMessageUpgrade'] = 'Uppgraderar databas...';
$GLOBALS['strDbSeeMoreFields'] = 'Se mer databasfält...';
$GLOBALS['strDbTimeZoneWarning'] = "<p>As of this version {$PRODUCT_NAME} stores dates in UTC time rather than in server time.</p>
                                                   <p>If you want historical statistics to be displayed with the correct timezone, upgrade your data manually.  Learn more <a target='help' href='%s'>here</a>.
                                                      Your statistics values will remain accurate even if you leave your data untouched.
                                                   </p>";
$GLOBALS['strDbTimeZoneNoWarnings'] = "Do not display timezone warnings in the future";
$GLOBALS['strDBInstallSuccess'] = "Database created successfully";
$GLOBALS['strDBUpgradeSuccess'] = "Database upgraded successfully";

$GLOBALS['strDetectedVersion'] = "Detected {$PRODUCT_NAME} version";

/** config step * */
$GLOBALS['strConfigureInstallTitle'] = "Configure your local {$PRODUCT_NAME} system administrator account";
$GLOBALS['strConfigureInstallIntro'] = "Please provide the desired login information for your local {$PRODUCT_NAME} system administrator account.";
$GLOBALS['strConfigureUpgradeTitle'] = "Konfigurationsinställningar";
$GLOBALS['strConfigureUpgradeIntro'] = "Provide the path to your previous {$PRODUCT_NAME} installation.";
$GLOBALS['strConfigSeeMoreFields'] = "See more configuration fields...";
$GLOBALS['strPreviousInstallTitle'] = "Tidigare installation";
$GLOBALS['strPathToPrevious'] = "Path to previous {$PRODUCT_NAME} installation";
$GLOBALS['strPathToPreviousError'] = "One or more plugin files couldn't be located, check the install.log file for more information";
$GLOBALS['strConfigureProgressMessage'] = "Configuring {$PRODUCT_NAME}...";

/** jobs step * */
$GLOBALS['strJobsInstallTitle'] = "Performing installation tasks";
$GLOBALS['strJobsInstallIntro'] = "Installer is now performing final installation tasks.";
$GLOBALS['strJobsUpgradeTitle'] = "Performing upgrade tasks";
$GLOBALS['strJobsUpgradeIntro'] = "Installer is now performing final upgrade tasks.";
$GLOBALS['strJobsProgressInstallMessage'] = "Running installation tasks...";
$GLOBALS['strJobsProgressUpgradeMessage'] = "Running upgrade tasks...";

$GLOBALS['strPluginTaskChecking'] = "Checking {$PRODUCT_NAME} Plugin";
$GLOBALS['strPluginTaskInstalling'] = "Installing {$PRODUCT_NAME} Plugin";
$GLOBALS['strPostInstallTaskRunning'] = "Running task";

/** finish step * */
$GLOBALS['strFinishInstallTitle'] = "Your {$PRODUCT_NAME} installation is complete.";
$GLOBALS['strFinishUpgradeWithErrorsTitle'] = "Your {$PRODUCT_NAME} upgrade is complete. Please check the highlighted issues.";
$GLOBALS['strFinishUpgradeTitle'] = "Your {$PRODUCT_NAME} upgrade is complete.";
$GLOBALS['strFinishInstallWithErrorsTitle'] = "Your {$PRODUCT_NAME} installation is complete. Please check the highlighted issues.";
$GLOBALS['strDetailedTaskErrorList'] = "Detailed list of errors found";
$GLOBALS['strPluginInstallFailed'] = "Installation of plugin \"%s\" failed:";
$GLOBALS['strTaskInstallFailed'] = "Error occurred when running installation task \"%s\":";
$GLOBALS['strContinueToLogin'] = "Click \"Continue\" to login to your {$PRODUCT_NAME} instance.";

$GLOBALS['strUnableCreateConfFile'] = "Vi lyckades inte skapa din konfigurationsfil. Vänligen kontrollera rättigheterna till {$PRODUCT_NAME} var mappen.";
$GLOBALS['strUnableUpdateConfFile'] = "Vi lyckades inte uppdatera din konfigurationsfil. Vänligen kontrollera rättigheterna till {$PRODUCT_NAME} var mappen samt kontrollera rättigheterna i tidigare installations konfigurationsfil som kan ha kopierats till den här mappen.";
$GLOBALS['strUnableToCreateAdmin'] = "We are unable to create a system administrator account, is your database accessible?";
$GLOBALS['strTimezoneLocal'] = "{$PRODUCT_NAME} has detected that your PHP installation is returning \"System/Localtime\" as the timezone
of your server. This is because of a patch to PHP applied by some Linux distributions.
Unfortunately, this is not a valid PHP timezone. Please edit your php.ini file and set the \"date.timezone\"property to the correct value for your server.";

$GLOBALS['strInstallNonBlockingErrors'] = "An error occurred when performing installation tasks. Please check the 
<a class=\"show-errors\" href=\"#\">error list</a> and install log at \\'%s\\' for details.
You will still be able to login to your {$PRODUCT_NAME} instance.";
