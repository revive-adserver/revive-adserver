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
$GLOBALS['strInstallStatusRecovery'] = 'Recuperando Revive Adserver %s';
$GLOBALS['strInstallStatusInstall'] = 'Instalando Revive Adserver %s';
$GLOBALS['strInstallStatusUpgrade'] = 'Actualizando a Revive Adserver %s';
$GLOBALS['strInstallStatusUpToDate'] = 'Detectada Revive Adserver %s';

/** welcome step * */
$GLOBALS['strWelcomeTitle'] = "Bienvenido a {$PRODUCT_NAME}";
$GLOBALS['strInstallIntro'] = "Gracias por elegir {$PRODUCT_NAME}. Este asistente le guiará por el proceso de instalación de {$PRODUCT_NAME}.";
$GLOBALS['strUpgradeIntro'] = "Gracias por elegir {$PRODUCT_NAME}. Este asistente le guiará a través del proceso de actualización {$PRODUCT_NAME}.";
$GLOBALS['strInstallerHelpIntro'] = "Para ayudarle con el proceso de instalación de {$PRODUCT_NAME}, por favor, consulte la <a href='{$PRODUCT_DOCSURL}' target='_blank'> documentación</a>.";
$GLOBALS['strTermsIntro'] = "{$PRODUCT_NAME} se distribuye libremente bajo una licencia de código abierto, la Licencia Pública General de GNU. Por favor revisar y aceptar los siguientes documentos para continuar la instalación.";

/** check step * */
$GLOBALS['strSystemCheck'] = "Comprobación del sistema";
$GLOBALS['strSystemCheckIntro'] = "The install wizard perfomed a check of your web server settings to ensure that the installation process can complete successfully.
                                                  <br>Please check any highlighted issues to complete the installation process.";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Configuration of your webserver does not meet the requirements of the {$PRODUCT_NAME}.
                                                   <br>In order to proceed with installation, please fix all errors.
                                                   For help, please see our <a href='{$PRODUCT_DOCSURL}'>documentation</a> and <a href='http://{$PRODUCT_URL}/faq'>FAQs</a>";

$GLOBALS['strAppCheckErrors'] = "Se encontraron errores al detectar instalaciones previas de {$PRODUCT_NAME}";
$GLOBALS['strAppCheckDbIntegrityError'] = "We have detected integrity issues with your database. This means that the layout of your database
                                                   differs from what we expect it to be. This could be due to customization of your database.";

$GLOBALS['strSyscheckProgressMessage'] = "Checking system parameters...";
$GLOBALS['strError'] = "Error";
$GLOBALS['strWarning'] = "Advertencia";
$GLOBALS['strOK'] = "Aceptar";
$GLOBALS['strSyscheckName'] = "Comprobar nombre";
$GLOBALS['strSyscheckValue'] = "Valor actual";
$GLOBALS['strSyscheckStatus'] = "Estado";
$GLOBALS['strSyscheckSeeFullReport'] = "Mostrar la verificación detallada del sistema";
$GLOBALS['strSyscheckSeeShortReport'] = "Mostrar sólo errores y advertencias";
$GLOBALS['strBrowserCookies'] = 'Cookies de navegador';
$GLOBALS['strPHPConfiguration'] = 'Configuración de PHP';
$GLOBALS['strCheckError'] = 'error';
$GLOBALS['strCheckErrors'] = 'errores';
$GLOBALS['strCheckWarning'] = 'advertencia';
$GLOBALS['strCheckWarnings'] = 'advertencias';

/** admin login step * */
$GLOBALS['strAdminLoginTitle'] = "Inicie sesión como el administrador de {$PRODUCT_NAME}";
$GLOBALS['strAdminLoginIntro'] = "Para continuar, ingrese la información de inicio de sesión de la cuenta del administrador de {$PRODUCT_NAME}.";
$GLOBALS['strLoginProgressMessage'] = 'Iniciando la sesión...';

/** database step * */
$GLOBALS['strDbSetupTitle'] = "Provide your database";
$GLOBALS['strDbSetupIntro'] = "Provide the details to connect to your {$PRODUCT_NAME} database.";
$GLOBALS['strDbUpgradeTitle'] = "Se ha detectado su base de datos";
$GLOBALS['strDbUpgradeIntro'] = "The following database has been detected for your installation of {$PRODUCT_NAME}.
                                                   Please verify that this is correct then click \"Continue\" to proceed.";
$GLOBALS['strDbProgressMessageInstall'] = 'Instalando base de datos...';
$GLOBALS['strDbProgressMessageUpgrade'] = 'Actualizando base de datos...';
$GLOBALS['strDbSeeMoreFields'] = 'Ver más campos de la base de datos...';
$GLOBALS['strDbTimeZoneWarning'] = "<p>As of this version {$PRODUCT_NAME} stores dates in UTC time rather than in server time.</p>
                                                   <p>If you want historical statistics to be displayed with the correct timezone, upgrade your data manually.  Learn more <a target='help' href='%s'>here</a>.
                                                      Your statistics values will remain accurate even if you leave your data untouched.
                                                   </p>";
$GLOBALS['strDbTimeZoneNoWarnings'] = "Do not display timezone warnings in the future";
$GLOBALS['strDBInstallSuccess'] = "Base de datos creada con éxito";
$GLOBALS['strDBUpgradeSuccess'] = "Base de datos actualizada con éxito";

$GLOBALS['strDetectedVersion'] = "Versión {$PRODUCT_NAME} detectada";

/** config step * */
$GLOBALS['strConfigureInstallTitle'] = "Configure your local {$PRODUCT_NAME} system administrator account";
$GLOBALS['strConfigureInstallIntro'] = "Please provide the desired login information for your local {$PRODUCT_NAME} system administrator account.";
$GLOBALS['strConfigureUpgradeTitle'] = "Ajustes de configuración";
$GLOBALS['strConfigureUpgradeIntro'] = "Proporcione la ruta a la instalación anterior de {$PRODUCT_NAME}.";
$GLOBALS['strConfigSeeMoreFields'] = "Ver más campos de configuración...";
$GLOBALS['strPreviousInstallTitle'] = "Instalación anterior";
$GLOBALS['strPathToPrevious'] = "Path to previous {$PRODUCT_NAME} installation";
$GLOBALS['strPathToPreviousError'] = "One or more plugin files couldn't be located, check the install.log file for more information";
$GLOBALS['strConfigureProgressMessage'] = "Configurando {$PRODUCT_NAME}...";

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
