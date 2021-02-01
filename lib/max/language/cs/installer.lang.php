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
$GLOBALS['strInstallStatusRecovery'] = 'Obnovení Revive Adserver %s';
$GLOBALS['strInstallStatusInstall'] = 'Instalace Revive Adserver %s';
$GLOBALS['strInstallStatusUpgrade'] = 'Upgrade Revive Adserver %s';
$GLOBALS['strInstallStatusUpToDate'] = 'Zjištěn Revive Adserver %s';

/** welcome step * */
$GLOBALS['strWelcomeTitle'] = "Vítejte na {$PRODUCT_NAME}";
$GLOBALS['strInstallIntro'] = "Děkujeme vám za {$PRODUCT_NAME}. Tento průvodce vás provede procesem instalace {$PRODUCT_NAME}.";
$GLOBALS['strUpgradeIntro'] = "Děkujeme vám za {$PRODUCT_NAME}. Tento průvodce vás provede procesem aktualizace {$PRODUCT_NAME}.";
$GLOBALS['strInstallerHelpIntro'] = "To help you with the {$PRODUCT_NAME} installation process, please see the <a href='{$PRODUCT_DOCSURL}' target='_blank'>Documentation</a>.";
$GLOBALS['strTermsIntro'] = "{$PRODUCT_NAME} is distributed freely under an Open Source license, the GNU General Public License. Please review and agree to the following documents to continue the installation.";

/** check step * */
$GLOBALS['strSystemCheck'] = "Kontrola systému";
$GLOBALS['strSystemCheckIntro'] = "Průvodce instalací provedl kontrolu nastavení vašeho webového serveru, aby zajistily, že proces instalace může úspěšně dokončit.<br>Prosím, zkontrolujte všechny zvýrazněné problémy, dokončete proces instalace.";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Configuration of your webserver does not meet the requirements of the {$PRODUCT_NAME}.
                                                   <br>In order to proceed with installation, please fix all errors.
                                                   For help, please see our <a href='{$PRODUCT_DOCSURL}'>documentation</a> and <a href='http://{$PRODUCT_URL}/faq'>FAQs</a>";

$GLOBALS['strAppCheckErrors'] = "Errors were found when detecting previous installations of {$PRODUCT_NAME}";
$GLOBALS['strAppCheckDbIntegrityError'] = "We have detected integrity issues with your database. This means that the layout of your database
                                                   differs from what we expect it to be. This could be due to customization of your database.";

$GLOBALS['strSyscheckProgressMessage'] = "Kontrola parametrů systému...";
$GLOBALS['strError'] = "Chyba";
$GLOBALS['strWarning'] = "Varování";
$GLOBALS['strOK'] = "Ok";
$GLOBALS['strSyscheckName'] = "Zkontrolovat jméno";
$GLOBALS['strSyscheckValue'] = "Současná hodnota";
$GLOBALS['strSyscheckStatus'] = "Stav";
$GLOBALS['strSyscheckSeeFullReport'] = "Zobrazit podrobnou kontrolu systému";
$GLOBALS['strSyscheckSeeShortReport'] = "Zobrazit pouze chyby a varování";
$GLOBALS['strBrowserCookies'] = 'Cookie prohlížeče';
$GLOBALS['strPHPConfiguration'] = 'Konfigurace PHP';
$GLOBALS['strCheckError'] = 'Chyba';
$GLOBALS['strCheckErrors'] = 'chyby';
$GLOBALS['strCheckWarning'] = 'varování';
$GLOBALS['strCheckWarnings'] = 'varování';

/** admin login step * */
$GLOBALS['strAdminLoginTitle'] = "Přihlaste se jako správce {$PRODUCT_NAME}";
$GLOBALS['strAdminLoginIntro'] = "To continue, please enter your {$PRODUCT_NAME} system administrator account login information.";
$GLOBALS['strLoginProgressMessage'] = 'Přihlašování...';

/** database step * */
$GLOBALS['strDbSetupTitle'] = "Zadejte Vaší databázi";
$GLOBALS['strDbSetupIntro'] = "Poskytnout informace o připojení k databázi {$PRODUCT_NAME}.";
$GLOBALS['strDbUpgradeTitle'] = "Byla zjištěna vaše databáze";
$GLOBALS['strDbUpgradeIntro'] = "Následující databáze byla zjištěna pro vaši instalaci {$PRODUCT_NAME}. Prosím ověřte, že tato databáze je správna, pak klikněte na \"Pokračovat\" pro pokračování..";
$GLOBALS['strDbProgressMessageInstall'] = 'Instalace databáze...';
$GLOBALS['strDbProgressMessageUpgrade'] = 'Upgradování databáze...';
$GLOBALS['strDbSeeMoreFields'] = 'Více databázových polí...';
$GLOBALS['strDbTimeZoneWarning'] = "<p>As of this version {$PRODUCT_NAME} stores dates in UTC time rather than in server time.</p>
                                                   <p>If you want historical statistics to be displayed with the correct timezone, upgrade your data manually.  Learn more <a target='help' href='%s'>here</a>.
                                                      Your statistics values will remain accurate even if you leave your data untouched.
                                                   </p>";
$GLOBALS['strDbTimeZoneNoWarnings'] = "Do not display timezone warnings in the future";
$GLOBALS['strDBInstallSuccess'] = "Databáze byla úspěšně vytvořena";
$GLOBALS['strDBUpgradeSuccess'] = "Databáze úspěšně upgradována";

$GLOBALS['strDetectedVersion'] = "Zjištěný {$PRODUCT_NAME} verze";

/** config step * */
$GLOBALS['strConfigureInstallTitle'] = "Configure your local {$PRODUCT_NAME} system administrator account";
$GLOBALS['strConfigureInstallIntro'] = "Please provide the desired login information for your local {$PRODUCT_NAME} system administrator account.";
$GLOBALS['strConfigureUpgradeTitle'] = "Nastavení konfigurace";
$GLOBALS['strConfigureUpgradeIntro'] = "Zadejte cestu k instalaci předchozí {$PRODUCT_NAME}.";
$GLOBALS['strConfigSeeMoreFields'] = "Více konfiguračních polí...";
$GLOBALS['strPreviousInstallTitle'] = "Předchozí instalace";
$GLOBALS['strPathToPrevious'] = "Path to previous {$PRODUCT_NAME} installation";
$GLOBALS['strPathToPreviousError'] = "One or more plugin files couldn't be located, check the install.log file for more information";
$GLOBALS['strConfigureProgressMessage'] = "Konfigurace {$PRODUCT_NAME}...";

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

$GLOBALS['strUnableCreateConfFile'] = "We are unable to create your configuration file. Please re-check the permissions of the {$PRODUCT_NAME} var folder.";
$GLOBALS['strUnableUpdateConfFile'] = "We are unable to update your configuration file. Please re-check the permissions of the {$PRODUCT_NAME} var folder, and also check the permissions of the previous install's config file that you copied into this folder.";
$GLOBALS['strUnableToCreateAdmin'] = "We are unable to create a system administrator account, is your database accessible?";
$GLOBALS['strTimezoneLocal'] = "{$PRODUCT_NAME} has detected that your PHP installation is returning \"System/Localtime\" as the timezone
of your server. This is because of a patch to PHP applied by some Linux distributions.
Unfortunately, this is not a valid PHP timezone. Please edit your php.ini file and set the \"date.timezone\"property to the correct value for your server.";

$GLOBALS['strInstallNonBlockingErrors'] = "An error occurred when performing installation tasks. Please check the 
<a class=\"show-errors\" href=\"#\">error list</a> and install log at \\'%s\\' for details.
You will still be able to login to your {$PRODUCT_NAME} instance.";
