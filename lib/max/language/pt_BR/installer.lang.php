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

$GLOBALS['strAppCheckDbIntegrityError'] = "Nós detectamos problemas de integridade com seu banco de dados. Isto significa que o layout de seu banco de dados                                                    está diferente do que esperamos que seja. Isto pode ser devido a personalização de seu banco de dados.";

$GLOBALS['strSyscheckProgressMessage'] = "Verificando parâmetros do sistema...";
$GLOBALS['strError'] = "Erro";
$GLOBALS['strWarning'] = "Alerta";
$GLOBALS['strOK'] = "OK";
$GLOBALS['strSyscheckName'] = "Verificar nome";
$GLOBALS['strSyscheckValue'] = "Valor atual";
$GLOBALS['strSyscheckStatus'] = "Estado";

/** admin login step * */

/** database step * */
$GLOBALS['strDbProgressMessageInstall'] = 'Instalando o banco de dados...';
$GLOBALS['strDbProgressMessageUpgrade'] = 'Atualizando o banco de dados...';
$GLOBALS['strDbSeeMoreFields'] = 'Ver mais campos de banco de dados...';
$GLOBALS['strDBInstallSuccess'] = "Banco de dados criado com sucesso";
$GLOBALS['strDBUpgradeSuccess'] = "Banco de dados atualizado com sucesso";

$GLOBALS['strDetectedVersion'] = "Versão {$PRODUCT_NAME} detectada";

/** config step * */
$GLOBALS['strPreviousInstallTitle'] = "Instalação anterior";

/** jobs step * */
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
$GLOBALS['strPluginInstallFailed'] = "Falha na instalação do plugin \"%s\":";
$GLOBALS['strTaskInstallFailed'] = "Ocorreu um erro ao executar a tarefa de instalação \"%s\":";
$GLOBALS['strContinueToLogin'] = "Clique \"Continuar\" para logar em sua instância de {$PRODUCT_NAME}.";

