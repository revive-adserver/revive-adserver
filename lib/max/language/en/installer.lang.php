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
$GLOBALS['strInstallStatusRecovery'] = 'Recovering Revive Adserver %s';
$GLOBALS['strInstallStatusInstall'] = 'Installing Revive Adserver %s';
$GLOBALS['strInstallStatusUpgrade'] = 'Upgrading to Revive Adserver %s';
$GLOBALS['strInstallStatusUpToDate'] = 'Detected Revive Adserver %s';

/** welcome step * */
$GLOBALS['strWelcomeTitle'] = "Welcome to {$PRODUCT_NAME}";
$GLOBALS['strInstallIntro'] = "Thank you for choosing {$PRODUCT_NAME}. This wizard will guide you through the process of installing {$PRODUCT_NAME} .";
$GLOBALS['strUpgradeIntro'] = "Thank you for choosing {$PRODUCT_NAME}. This wizard will guide you through the process of upgrading {$PRODUCT_NAME}.";
$GLOBALS['strInstallerHelpIntro'] = "To help you with the {$PRODUCT_NAME} installation process, please see the <a href='{$PRODUCT_DOCSURL}' target='_blank'>Documentation</a>.";
$GLOBALS['strTermsIntro'] = "{$PRODUCT_NAME} is distributed freely under an Open Source license, the GNU General Public License. Please review and agree to the following documents to continue the installation.";

/** check step * */
$GLOBALS['strSystemCheck'] = "System check";
$GLOBALS['strSystemCheckIntro'] = "The install wizard perfomed a check of your web server settings to ensure that the installation process can complete successfully.
                                                  <br>Please check any highlighted issues to complete the installation process.";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Configuration of your webserver does not meet the requirements of the {$PRODUCT_NAME}.
                                                   <br>In order to proceed with installation, please fix all errors.
                                                   For help, please see our <a href='{$PRODUCT_DOCSURL}'>documentation</a> and <a href='http://{$PRODUCT_URL}/faq'>FAQs</a>";

$GLOBALS['strAppCheckErrors'] = "Errors were found when detecting previous installations of {$PRODUCT_NAME}";
$GLOBALS['strAppCheckDbIntegrityError'] = "We have detected integrity issues with your database. This means that the layout of your database
                                                   differs from what we expect it to be. This could be due to customization of your database.";

$GLOBALS['strSyscheckProgressMessage'] = "Checking system parameters...";
$GLOBALS['strError'] = "Error";
$GLOBALS['strWarning'] = "Warning";
$GLOBALS['strOK'] = "OK";
$GLOBALS['strSyscheckName'] = "Check name";
$GLOBALS['strSyscheckValue'] = "Current value";
$GLOBALS['strSyscheckStatus'] = "Status";
$GLOBALS['strSyscheckSeeFullReport'] = "Show detailed system check";
$GLOBALS['strSyscheckSeeShortReport'] = "Show only errors and warnings";
$GLOBALS['strBrowserCookies'] = 'Browser Cookies';
$GLOBALS['strPHPConfiguration'] = 'PHP Configuration';
$GLOBALS['strCheckError'] = 'error';
$GLOBALS['strCheckErrors'] = 'errors';
$GLOBALS['strCheckWarning'] = 'warning';
$GLOBALS['strCheckWarnings'] = 'warnings';

/** admin login step * */
$GLOBALS['strAdminLoginTitle'] = "Please login as your {$PRODUCT_NAME} administrator";
$GLOBALS['strAdminLoginIntro'] = "To continue, please enter your {$PRODUCT_NAME} system administrator account login information.";
$GLOBALS['strLoginProgressMessage'] = 'Logging in...';

/** database step * */
$GLOBALS['strDbSetupTitle'] = "Provide your database";
$GLOBALS['strDbSetupIntro'] = "Provide the details to connect to your {$PRODUCT_NAME} database.";
$GLOBALS['strDbUpgradeTitle'] = "Your database has been detected";
$GLOBALS['strDbUpgradeIntro'] = "The following database has been detected for your installation of {$PRODUCT_NAME}.
                                                   Please verify that this is correct then click \"Continue\" to proceed.";
$GLOBALS['strDbProgressMessageInstall'] = 'Installing database...';
$GLOBALS['strDbProgressMessageUpgrade'] = 'Upgrading database...';
$GLOBALS['strDbSeeMoreFields'] = 'See more database fields...';
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
$GLOBALS['strConfigureUpgradeTitle'] = "Configuration settings";
$GLOBALS['strConfigureUpgradeIntro'] = "Provide the path to your previous {$PRODUCT_NAME} installation.";
$GLOBALS['strConfigSeeMoreFields'] = "See more configuration fields...";
$GLOBALS['strPreviousInstallTitle'] = "Previous installation";
$GLOBALS['strPathToPrevious'] = "Path to previous {$PRODUCT_NAME} installation";
$GLOBALS['strPathToPreviousError'] = "One or more plugin files couln't be located, check the install.log file for more information";
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

$GLOBALS['strUnableCreateConfFile'] = "We are unable to create your configuration file. Please re-check the permissions of the {$PRODUCT_NAME} var folder.";
$GLOBALS['strUnableUpdateConfFile'] = "We are unable to update your configuration file. Please re-check the permissions of the {$PRODUCT_NAME} var folder, and also check the permissions of the previous install's config file that you copied into this folder.";
$GLOBALS['strUnableToCreateAdmin'] = "We are unable to create a system administrator account, is your database accessible?";
$GLOBALS['strTimezoneLocal'] = "{$PRODUCT_NAME} has detected that your PHP installation is returning \"System/Localtime\" as the timezone
of your server. This is because of a patch to PHP applied by some Linux distributions.
Unfortunately, this is not a valid PHP timezone. Please edit your php.ini file and set the \"date.timezone\"property to the correct value for your server.";
