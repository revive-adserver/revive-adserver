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
$GLOBALS['strInstallStatusRecovery'] = '';
$GLOBALS['strInstallStatusInstall'] = '';
$GLOBALS['strInstallStatusUpgrade'] = '';
$GLOBALS['strInstallStatusUpToDate'] = '';

/** welcome step * */
$GLOBALS['strWelcomeTitle'] = "欢迎来到 {{PRODUCT_NAME}}";
$GLOBALS['strInstallIntro'] = "";
$GLOBALS['strUpgradeIntro'] = "";
$GLOBALS['strInstallerHelpIntro'] = "";
$GLOBALS['strTermsIntro'] = "";

/** check step * */
$GLOBALS['strSystemCheck'] = "";
$GLOBALS['strSystemCheckIntro'] = "The install wizard perfomed a check of your web server settings to ensure that the installation process can complete successfully.
                                                 <br>Please check any highlighted issues to complete the installation process.";
$GLOBALS['strFixErrorsBeforeContinuing'] = "";

$GLOBALS['strAppCheckErrors'] = "";
$GLOBALS['strAppCheckDbIntegrityError'] = "We have detected integrity issues with your database. This means that the layout of your database 
                                                  differs from what we expect it to be. This could be due to customization of your database.";

$GLOBALS['strSyscheckProgressMessage'] = "";
$GLOBALS['strError'] = "错误";
$GLOBALS['strWarning'] = "警告";
$GLOBALS['strOK'] = "OK";
$GLOBALS['strSyscheckName'] = "";
$GLOBALS['strSyscheckValue'] = "";
$GLOBALS['strSyscheckStatus'] = "状态";
$GLOBALS['strSyscheckSeeFullReport'] = "";
$GLOBALS['strSyscheckSeeShortReport'] = "";
$GLOBALS['strBrowserCookies'] = '浏览器 Cookie';
$GLOBALS['strPHPConfiguration'] = 'PHP 配置';
$GLOBALS['strCheckError'] = '';
$GLOBALS['strCheckErrors'] = '';
$GLOBALS['strCheckWarning'] = '';
$GLOBALS['strCheckWarnings'] = '';

/** admin login step * */
$GLOBALS['strAdminLoginTitle'] = "";
$GLOBALS['strAdminLoginIntro'] = "";
$GLOBALS['strLoginProgressMessage'] = '';

/** database step * */
$GLOBALS['strDbSetupTitle'] = "";
$GLOBALS['strDbSetupIntro'] = "";
$GLOBALS['strDbUpgradeTitle'] = "";
$GLOBALS['strDbUpgradeIntro'] = "";
$GLOBALS['strDbProgressMessageInstall'] = '';
$GLOBALS['strDbProgressMessageUpgrade'] = '';
$GLOBALS['strDbSeeMoreFields'] = '';
$GLOBALS['strDbTimeZoneWarning'] = "";
$GLOBALS['strDbTimeZoneNoWarnings'] = "";
$GLOBALS['strDBInstallSuccess'] = "";
$GLOBALS['strDBUpgradeSuccess'] = "";

$GLOBALS['strDetectedVersion'] = "";

/** config step * */
$GLOBALS['strConfigureInstallTitle'] = "";
$GLOBALS['strConfigureInstallIntro'] = "";
$GLOBALS['strConfigureUpgradeTitle'] = "";
$GLOBALS['strConfigureUpgradeIntro'] = "";
$GLOBALS['strConfigSeeMoreFields'] = "";
$GLOBALS['strPreviousInstallTitle'] = "";
$GLOBALS['strPathToPrevious'] = "";
$GLOBALS['strPathToPreviousError'] = "";
$GLOBALS['strConfigureProgressMessage'] = "";

/** jobs step * */
$GLOBALS['strJobsInstallTitle'] = "";
$GLOBALS['strJobsInstallIntro'] = "";
$GLOBALS['strJobsUpgradeTitle'] = "";
$GLOBALS['strJobsUpgradeIntro'] = "";
$GLOBALS['strJobsProgressInstallMessage'] = "";
$GLOBALS['strJobsProgressUpgradeMessage'] = "";

$GLOBALS['strPluginTaskChecking'] = "";
$GLOBALS['strPluginTaskInstalling'] = "";
$GLOBALS['strPostInstallTaskRunning'] = "";

/** finish step * */
$GLOBALS['strFinishInstallTitle'] = "";
$GLOBALS['strFinishUpgradeWithErrorsTitle'] = "";
$GLOBALS['strFinishUpgradeTitle'] = "";
$GLOBALS['strFinishInstallWithErrorsTitle'] = "";
$GLOBALS['strDetailedTaskErrorList'] = "";
$GLOBALS['strPluginInstallFailed'] = "Installation of plugin '%s' failed:";
$GLOBALS['strTaskInstallFailed'] = "Error occured when running installation task '%s':";
$GLOBALS['strContinueToLogin'] = "";

$GLOBALS['strUnableCreateConfFile'] = "";
$GLOBALS['strUnableUpdateConfFile'] = "";
$GLOBALS['strUnableToCreateAdmin'] = "We are unable to create an administrator account, is your database accessible?";
$GLOBALS['strTimezoneLocal'] = "";

$GLOBALS['strInstallNonBlockingErrors'] = "";
