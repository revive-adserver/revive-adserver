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
$GLOBALS['strInstallStatusUpgrade'] = 'Atualizando para Revive Adserver %s';
$GLOBALS['strInstallStatusUpToDate'] = 'Detectado Revive Adserver %s';

/** welcome step * */
$GLOBALS['strWelcomeTitle'] = "Bem-vindo ao {$PRODUCT_NAME}";
$GLOBALS['strInstallIntro'] = "Obrigado por escolher {$PRODUCT_NAME}. Este assistente irá guiá-lo através do processo de instalação {$PRODUCT_NAME}.";
$GLOBALS['strUpgradeIntro'] = "Obrigado por escolher {$PRODUCT_NAME}. Este assistente irá guiá-lo através do processo de atualização {$PRODUCT_NAME}.";
$GLOBALS['strInstallerHelpIntro'] = "Para ajudá-lo com o processo de instalação do {$PRODUCT_NAME}, por favor, consulte a <a href='{$PRODUCT_DOCSURL}' target='_blank'> documentação</a>.";
$GLOBALS['strTermsIntro'] = "{$PRODUCT_NAME} é distribuído livremente sob uma licença Open Source, a GNU General Public License. Por favor, leia e concorde com os seguintes documentos para continuar a instalação.";

/** check step * */
$GLOBALS['strSystemCheck'] = "Verificação do sistema";
$GLOBALS['strSystemCheckIntro'] = "O assistente de instação efetuou uma verificação de suas configurações de servidor web para assegurar que o processo de instalação pode ser concluído com sucesso.                                                   <br>Por favor verifique qualquer questões destacada para completar o processo de instalação.";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Configuration of your webserver does not meet the requirements of the {$PRODUCT_NAME}.
                                                   <br>In order to proceed with installation, please fix all errors.
                                                   For help, please see our <a href='{$PRODUCT_DOCSURL}'>documentation</a> and <a href='http://{$PRODUCT_URL}/faq'>FAQs</a>";

$GLOBALS['strAppCheckErrors'] = "Errors were found when detecting previous installations of {$PRODUCT_NAME}";
$GLOBALS['strAppCheckDbIntegrityError'] = "Nós detectamos problemas de integridade com seu banco de dados. Isto significa que o layout de seu banco de dados                                                    está diferente do que esperamos que seja. Isto pode ser devido a personalização de seu banco de dados.";

$GLOBALS['strSyscheckProgressMessage'] = "Verificando parâmetros do sistema...";
$GLOBALS['strError'] = "Erro";
$GLOBALS['strWarning'] = "Alerta";
$GLOBALS['strOK'] = "OK";
$GLOBALS['strSyscheckName'] = "Verificar nome";
$GLOBALS['strSyscheckValue'] = "Valor atual";
$GLOBALS['strSyscheckStatus'] = "Estado";
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
$GLOBALS['strDbProgressMessageInstall'] = 'Instalando o banco de dados...';
$GLOBALS['strDbProgressMessageUpgrade'] = 'Atualizando o banco de dados...';
$GLOBALS['strDbSeeMoreFields'] = 'Ver mais campos de banco de dados...';
$GLOBALS['strDbTimeZoneWarning'] = "<p>As of this version {$PRODUCT_NAME} stores dates in UTC time rather than in server time.</p>
                                                   <p>If you want historical statistics to be displayed with the correct timezone, upgrade your data manually.  Learn more <a target='help' href='%s'>here</a>.
                                                      Your statistics values will remain accurate even if you leave your data untouched.
                                                   </p>";
$GLOBALS['strDbTimeZoneNoWarnings'] = "Do not display timezone warnings in the future";
$GLOBALS['strDBInstallSuccess'] = "Banco de dados criado com sucesso";
$GLOBALS['strDBUpgradeSuccess'] = "Banco de dados atualizado com sucesso";

$GLOBALS['strDetectedVersion'] = "Versão {$PRODUCT_NAME} detectada";

/** config step * */
$GLOBALS['strConfigureInstallTitle'] = "Configure your local {$PRODUCT_NAME} system administrator account";
$GLOBALS['strConfigureInstallIntro'] = "Please provide the desired login information for your local {$PRODUCT_NAME} system administrator account.";
$GLOBALS['strConfigureUpgradeTitle'] = "Configuration settings";
$GLOBALS['strConfigureUpgradeIntro'] = "Provide the path to your previous {$PRODUCT_NAME} installation.";
$GLOBALS['strConfigSeeMoreFields'] = "See more configuration fields...";
$GLOBALS['strPreviousInstallTitle'] = "Instalação anterior";
$GLOBALS['strPathToPrevious'] = "Path to previous {$PRODUCT_NAME} installation";
$GLOBALS['strPathToPreviousError'] = "One or more plugin files couldn't be located, check the install.log file for more information";
$GLOBALS['strConfigureProgressMessage'] = "Configuring {$PRODUCT_NAME}...";

/** jobs step * */
$GLOBALS['strJobsInstallTitle'] = "Performing installation tasks";
$GLOBALS['strJobsInstallIntro'] = "Installer is now performing final installation tasks.";
$GLOBALS['strJobsUpgradeTitle'] = "Performing upgrade tasks";
$GLOBALS['strJobsUpgradeIntro'] = "Installer is now performing final upgrade tasks.";
$GLOBALS['strJobsProgressInstallMessage'] = "Executando tarefas de instalação...";
$GLOBALS['strJobsProgressUpgradeMessage'] = "Executando tarefas de atualização...";

$GLOBALS['strPluginTaskChecking'] = "Verificando Plugin {$PRODUCT_NAME}";
$GLOBALS['strPluginTaskInstalling'] = "Instalando Plugin {$PRODUCT_NAME}";
$GLOBALS['strPostInstallTaskRunning'] = "Executando tarefas";

/** finish step * */
$GLOBALS['strFinishInstallTitle'] = "Sua instalação {$PRODUCT_NAME} está completa.";
$GLOBALS['strFinishUpgradeWithErrorsTitle'] = "Sua atualização {$PRODUCT_NAME} está completa. Por favor, verifique as questões destacadas.";
$GLOBALS['strFinishUpgradeTitle'] = "Sua atualização {$PRODUCT_NAME} está completa.";
$GLOBALS['strFinishInstallWithErrorsTitle'] = "Sua instalação {$PRODUCT_NAME} está completa. Por favor, verifique as questões destacadas.";
$GLOBALS['strDetailedTaskErrorList'] = "Detailed list of errors found";
$GLOBALS['strPluginInstallFailed'] = "Falha na instalação do plugin \"%s\":";
$GLOBALS['strTaskInstallFailed'] = "Ocorreu um erro ao executar a tarefa de instalação \"%s\":";
$GLOBALS['strContinueToLogin'] = "Clique \"Continuar\" para logar em sua instância de {$PRODUCT_NAME}.";

$GLOBALS['strUnableCreateConfFile'] = "We are unable to create your configuration file. Please re-check the permissions of the {$PRODUCT_NAME} var folder.";
$GLOBALS['strUnableUpdateConfFile'] = "We are unable to update your configuration file. Please re-check the permissions of the {$PRODUCT_NAME} var folder, and also check the permissions of the previous install's config file that you copied into this folder.";
$GLOBALS['strUnableToCreateAdmin'] = "We are unable to create a system administrator account, is your database accessible?";
$GLOBALS['strTimezoneLocal'] = "{$PRODUCT_NAME} has detected that your PHP installation is returning \"System/Localtime\" as the timezone
of your server. This is because of a patch to PHP applied by some Linux distributions.
Unfortunately, this is not a valid PHP timezone. Please edit your php.ini file and set the \"date.timezone\"property to the correct value for your server.";

$GLOBALS['strInstallNonBlockingErrors'] = "An error occurred when performing installation tasks. Please check the 
<a class=\"show-errors\" href=\"#\">error list</a> and install log at \\'%s\\' for details.
You will still be able to login to your {$PRODUCT_NAME} instance.";
