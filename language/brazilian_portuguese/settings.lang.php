<?php // $Revision$
//*LINHA 81 - REMOVER ISTO
/****************************************************************************/
/* phpAdsNew 2                                                              */
/* ===========                                                              */
/*                                                                          */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                      */
/* For more information visit: http://www.phpadsnew.com                     */
/*                                                                          */
/*Translated to Brazilian_portuguese by: Luiz Alberto de Moraes - purasorte */
/*For any comments/suggestions: purasorte@yahoo.com.br                      */
/*http://wwww.ojogodobicho.com                                              */
/* tradução deste arquivo em andamento                                                                         */
/* This program is free software. You can redistribute it and/or modify     */
/* it under the terms of the GNU General Public License as published by     */
/* the Free Software Foundation; either version 2 of the License.           */
/****************************************************************************/



// Installer translation strings
$GLOBALS['strInstall']				    = "Instale";
$GLOBALS['strChooseInstallLanguage']	= "Escolha o idioma para o procedimento de instalação";
$GLOBALS['strLanguageSelection']		= "Seleção de idioma";
$GLOBALS['strDatabaseSettings']			= "Ajustes da base de dados";
$GLOBALS['strAdminSettings']			= "Ajustes da base do Administrador";
$GLOBALS['strAdvancedSettings']			= "Ajustes avançados da base de dados";
$GLOBALS['strOtherSettings']			= "Outros ajustes";
$GLOBALS['strLicenseInformation']		= "Informação da licença";
$GLOBALS['strAdministratorAccount']		= "A conta do Administrador";
$GLOBALS['strDatabasePage']				= "A ".$phpAds_dbmsname." base de dados";
$GLOBALS['strInstallWarning']			= "Servidor e verificação da integridade";
$GLOBALS['strCongratulations']			= "Parabéns!";
$GLOBALS['strInstallFailed']			= "A instalação falhou!";
$GLOBALS['strSpecifyAdmin']				= "Configurar a conta do administrador";
$GLOBALS['strSpecifyLocaton']			= "Especifique a localização do ".$phpAds_productname." no servidor";


$GLOBALS['strWarning']				    = "AVISO";
$GLOBALS['strFatalError']			    = "Ocorreu um erro fatal";
$GLOBALS['strUpdateError']			    = "ocorreu um erro durante a atualização";
$GLOBALS['strUpdateDatabaseError']	    = "Devido a razões desconhecidas não foi possivel atualizar a estrutura da base de dados. The recommended way to proceed is to click <b>Retry updating</b> to try to correct these potential problems. If you are sure these errors won't affect the functionality of ".$phpAds_productname." you can click <b>Ignore errors</b> to continue. Ignoring these errors may cause serious problems and is not recommended!";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname." já esta instalado neste sistema. Se você quer configura-lo, vá para <a href='settings-index.php'>inreface de ajustes</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Não foi possivel conectar com a base de dados, por favor verifique suas especificações. Também tenha certeza de que uma base de dados com o nome que você especificou existe no servidor ".$phpAds_productname." will not create the database for you, you must create it manually before running the installer.";
$GLOBALS['strCreateTableTestFailed']	= "O usuário que você especificou não tem a permissão para criar ou para atualizar a estrutura da base de dados, contate por favor o administrador da base de dados.";
$GLOBALS['strUpdateTableTestFailed']	= "O usuário que você especificou não tem a permissão atualizar a estrutura da base de dados, contate por favor o administrador da base de dados.";
$GLOBALS['strTablePrefixInvalid']		= "O prefixo da tabela contém caracteres inválidos";
$GLOBALS['strTableInUse']		  	    = "A base de dados que voc6e especificou já esta em uso pelo ".$phpAds_productname.", por favor use um prefixo de tabela diferente, ou leia no Manual a respeito das atualizações.";
$GLOBALS['strTableWrongType']		    = "O tipo de tabela selecionado não é suportado pela sua instalação do ".$phpAds_dbmsname;
$GLOBALS['strMayNotFunction']			= "Antes de continuar, por favor corrija os seguintes problemas potenciais:";
$GLOBALS['strFixProblemsBefore']		= "O(s) item(ns) a seguir precisam ser corrigidos antes que possa instalar ".$phpAds_productname.". Se você tiver quaisquer perguntas sobre esta mensagem de erro, leia por favor <i>Administrator guide</i>, que é parte do pacote baixado.";
$GLOBALS['strFixProblemsAfter']			= "Se você não puder corrigir os problemas listados acima, contate por favor o administrador do servidor que você está tentando instalar ".$phpAds_productname." . O administrador do servidor está apto a ajuda-lo.";
$GLOBALS['strIgnoreWarnings']			= "Ignorar avisos";
$GLOBALS['strWarningDBavailable']		= "A versão de PHP que você se está usando não tem suporte para conectar a ".$phpAds_dbmsname." banco de dados. Você necessita habilitar a extensão PHP ".$phpAds_dbmsname." antes de prosseguir.";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." requee PHP 4.0.3 ou superior para funcionar corretamente. Você está usando atualmente {php_version}.";
$GLOBALS['strWarningPHP5beta']			= "Você está tentando instalar ".$phpAds_productname." usando uma versão de testes do PHP 5. Esta versão não está pronta para uso em produção e usualmente contem BUGS. Não é recomendado rodar ".$phpAds_productname." em PHP 5, exceto para efeito de testes.";
$GLOBALS['strWarningRegisterGlobals']		= "Na configuração do PHP a variavel register_global precisa estar definida como <b>ON</b>.";
$GLOBALS['strWarningMagicQuotesGPC']		= "Na configuração do PHP a variavel magic_quotes_gpc precisa estar definida como <b>ON</b>";
$GLOBALS['strWarningMagicQuotesRuntime']	= "Na configuração do PHP a variavel magic_quotes_runtime precisa estar definida como <b>OFF</b>.";
$GLOBALS['strWarningMagicQuotesSybase']	= "Na configuração do PHP a variavel magic_quotes_sybase precisa estar definida como <b>OFF</b>.";
$GLOBALS['strWarningFileUploads']		= "Na configuração do PHP a variavel file_uploads precisa estar definida como <b>ON</b>.";
$GLOBALS['strWarningTrackVars']			= "Na configuração do PHP a variavel track_vars precisa estar definida como <b>ON</b>.";
$GLOBALS['strWarningPREG']				= "Na versão do PHP que você está usando não há suporte para PERL (compatible regular expressions). Você precisa habilitar a extensão PRG antes de prosseguir";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." detectou que seu  <b>config.inc.php</b> não tem permissão de escrita. Você não poderá proseguir até que tenha mudado a permissão. Leia a documentação fornecida se você não souber como fazer isto";
$GLOBALS['strCacheLockedDetected']		    = "Você está usando arquivos de cache para entrega ".$phpAds_productname." detectou que <b>cache</b> o diretório não tem permissão de escrita no servidor. Você não pode prosseguir até que altere a permissão do diretório. Leia a documentação para saber como alterar permissões.";
$GLOBALS['strCantUpdateDB']  		= "No momento não é possivel atualizar a base de dados. Se você prosseguir, todos os banners existentes, estatísticas e anunciantes serão deletados.";
$GLOBALS['strIgnoreErrors']			= "Ignorar erros";
$GLOBALS['strRetryUpdate']			= "Retry updating";
$GLOBALS['strTableNames']			= "Nome das tabelas";
$GLOBALS['strTablesPrefix']			= "Prefixo das tabelas";
$GLOBALS['strTablesType']			= "Tipo de tabelas";

$GLOBALS['strRevCorrupt']			= "O arquivo <b>{filename}</b> está corrompido ou foi alterada. Se você não alterou este arquivo, por favor tente fazer novo upload deste arquivo para seu servidor. Se você alterou este arquivo, ignore este aviso.";
$GLOBALS['strRevTooOld']			= "O arquivo <b>{filename}</b> é mais antigo do que o arquivo usado para esta versão do ".$phpAds_productname." Por favor tente fazer novo upload deste arquivo para seu servidor.";
$GLOBALS['strRevMissing']			= "O arquivo <b>{filename}</b> não foi localizado. Por favor tente fazer novo upload deste arquivo para seu servidor.";
$GLOBALS['strRevCVS']				= "Voce está tentando instalar um arquivo CVS ".$phpAds_productname.". ESta não é uma versão oficial e poderá ser instavel ou não será funcional. Você tem certeza de que deseja continuar?";

$GLOBALS['strInstallWelcome']			= "Bem-vindo a ".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "Antes de usar ".$phpAds_productname." precisa estar configurado <br> e uma base de dados precisa ser criada. Clique <b>Proceed</b> para continuar.";
$GLOBALS['strInstallMessageCheck']		= $phpAds_productname." verificou a integridade dos arquivos que você fez upload para o servidor e verificou onde o servidor é compativel ".$phpAds_productname.". O(s) seguinte(s) item(ns) precisam sua atenção antes de continuar";
$GLOBALS['strInstallMessageAdmin']		= "Antes de continuar você precisa configurar a conta do Administrador. Você pode usar esta conta para logar na interface do Administrador, gerenciar seu inventário e visualizar as estatísticas.";
$GLOBALS['strInstallMessageDatabase']	= $phpAds_productname." usa uma ".$phpAds_dbmsname." a base de dados armazena o inventário e todas as estatísticas. Antes que possa continuar você precisa informar qual base de dados usar e qual nome de usuario e senha ".$phpAds_productname." usados para conectar a base de dados. Se você não sabe que tipo de informações inserir aqui, por favor contacte o Administrador do servidor.";
$GLOBALS['strInstallSuccess']			= "<b>The installation of ".$phpAds_productname." is now complete.</b><br><br>In order for ".$phpAds_productname." to function correctly you also need
						   to make sure the maintenance file is run every hour. More information about this subject can be found in the documentation.
						   <br><br>Click <b>Proceed</b> to go the configuration page, where you can 
						   set up more settings. Please do not forget to lock the config.inc.php file when you are finished to prevent security
						   breaches.";
$GLOBALS['strUpdateSuccess']			= "<b>The upgrade of ".$phpAds_productname." was succesful.</b><br><br>In order for ".$phpAds_productname." to function correctly you also need
						   to make sure the maintenance file is run every hour (previously this was every day). More information about this subject can be found in the documentation.
						   <br><br>Click <b>Proceed</b> to go to the administration interface. Please do not forget to lock the config.inc.php file 
						   to prevent security breaches.";
$GLOBALS['strInstallNotSuccessful']		= "<b>The installation of ".$phpAds_productname." was not succesful</b><br><br>Some portions of the install process could not be completed.
						   It is possible these problems are only temporarily, in that case you can simply click <b>Proceed</b> and return to the
						   first step of the install process. If you want to know more on what the error message below means, and how to solve it, 
						   please consult the supplied documentation.";
$GLOBALS['strErrorOccured']			= "The following error occured:";
$GLOBALS['strErrorInstallDatabase']		= "The database structure could not be created.";
$GLOBALS['strErrorInstallConfig']		= "The configuration file or database could not be updated.";
$GLOBALS['strErrorInstallDbConnect']		= "It was not possible to open a connection to the database.";

$GLOBALS['strUrlPrefix']			= "URL Prefixo";

$GLOBALS['strProceed']				= "Continuar";
$GLOBALS['strInvalidUserPwd']			= "Usuário ou senha invalidos";

$GLOBALS['strUpgrade']				= "Upgrade";
$GLOBALS['strSystemUpToDate']			= "Seu sistema já esta atualizado, nenhuma atualização e necessário agora. <br>Click em  <b>Continuar</b> para voltar a pagina principal.";
$GLOBALS['strSystemNeedsUpgrade']		= "A estrutura da base de dados econfiguração dos arquivos precisam ser atualizados para o perfeito funcionamento. Click <b>Continuar</b> para iniciar o processo de atualização. <br><br>Dependendo da versão atual utilizada e da quantidade de registros inseridos em sua base de dados o processo poderá causar um grande carga em sua base dados, por favor seja paciente. O processo poderá demorar alguns minutos.";
$GLOBALS['strSystemUpgradeBusy']		= "Sistema em atualização, por favor aguarde...";
$GLOBALS['strSystemRebuildingCache']		= "Reconstruindo o cache, por favor aguarde...";
$GLOBALS['strServiceUnavalable']		= "O serviço está temporariamente indisponivel. Sistema em atualização";

$GLOBALS['strConfigNotWritable']		= "Seu arquivo config.inc.php não tem permissão de escrita";
$GLOBALS['strPhpBug20144']				= "Sua versão do PHP tem um <a href='http://bugs.php.net/bug.php?id=20114' target='_blank'>bug</a> o ".$phpAds_productname." poderá não funcionar corretamente.
							Atualização para PHP 4.3.0+ é requerida antes de instalar ".$phpAds_productname.".";
$GLOBALS['strPhpBug24652']				= "Você está tentando instalar o ".$phpAds_productname." em um servidor com uma versão do PHP 5 que contem erros.
										   Esta versão não é direcionada a produção poderá causar erros.
										   Um destes errros não permite que o ".$phpAds_productname." funcione corretamente.
										   Estes <a href='http://bugs.php.net/bug.php?id=24652' target='_blank'>erros</a> já estão corrigidos
										   na versão final do PHP 5 .";





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= "Choose Section";
$GLOBALS['strDayFullNames'] 			= array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
$GLOBALS['strEditConfigNotPossible']   		= "It is not possible to edit these settings because the configuration file is locked for security reasons. ".
										  "If you want to make changes, you need to unlock the config.inc.php file first.";
$GLOBALS['strEditConfigPossible']		= "It is possible to edit all settings because the configuration file is not locked, but this could lead to security leaks. ".
										  "If you want to secure your system, you need to lock the config.inc.php file.";



// Database
$GLOBALS['strDatabaseSettings']			= "Database settings";
$GLOBALS['strDatabaseServer']			= "Database server";
$GLOBALS['strDbLocal']				= "Connect to local server using sockets"; // Pg only
$GLOBALS['strDbHost']				= "Database hostname";
$GLOBALS['strDbPort']				= "Database port number";
$GLOBALS['strDbUser']				= "Database username";
$GLOBALS['strDbPassword']			= "Database password";
$GLOBALS['strDbName']				= "Database name";

$GLOBALS['strDatabaseOptimalisations']		= "Database optimalisations";
$GLOBALS['strPersistentConnections']		= "Use persistent connections";
$GLOBALS['strInsertDelayed']			= "Use delayed inserts";
$GLOBALS['strCompatibilityMode']		= "Use database compatibility mode";
$GLOBALS['strCantConnectToDb']			= "Can't connect to database";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "Invocation and delivery settings";

$GLOBALS['strAllowedInvocationTypes']		= "Allowed invocation types";
$GLOBALS['strAllowRemoteInvocation']		= "Allow Remote Invocation";
$GLOBALS['strAllowRemoteJavascript']		= "Allow Remote Invocation for Javascript";
$GLOBALS['strAllowRemoteFrames']		= "Allow Remote Invocation for Frames";
$GLOBALS['strAllowRemoteXMLRPC']		= "Allow Remote Invocation using XML-RPC";
$GLOBALS['strAllowLocalmode']			= "Allow Local mode";
$GLOBALS['strAllowInterstitial']		= "Allow Interstitials";
$GLOBALS['strAllowPopups']			= "Allow Popups";

$GLOBALS['strUseAcl']				= "Evaluate delivery limitations during delivery";

$GLOBALS['strDeliverySettings']			= "Delivery settings";
$GLOBALS['strCacheType']				= "Delivery cache type";
$GLOBALS['strCacheFiles']				= "Files";
$GLOBALS['strCacheDatabase']			= "Database";
$GLOBALS['strCacheShmop']				= "Shared memory/Shmop";
$GLOBALS['strCacheSysvshm']				= "Shared memory/Sysvshm";
$GLOBALS['strExperimental']				= "Experimental";
$GLOBALS['strKeywordRetrieval']			= "Keyword retrieval";
$GLOBALS['strBannerRetrieval']			= "Banner retrieval method";
$GLOBALS['strRetrieveRandom']			= "Random banner retrieval (default)";
$GLOBALS['strRetrieveNormalSeq']		= "Normal sequental banner retrieval";
$GLOBALS['strWeightSeq']			= "Weight based sequential banner retrieval";
$GLOBALS['strFullSeq']				= "Full sequential banner retrieval";
$GLOBALS['strUseConditionalKeys']		= "Allow logical operators when using direct selection";
$GLOBALS['strUseMultipleKeys']			= "Allow multiple keywords when using direct selection";

$GLOBALS['strZonesSettings']			= "Zone retrieval";
$GLOBALS['strZoneCache']			= "Cache zones, this should speed things up when using zones";
$GLOBALS['strZoneCacheLimit']			= "Time between cache updates (in seconds)";
$GLOBALS['strZoneCacheLimitErr']		= "Time between cache updates should be a positive integer";

$GLOBALS['strP3PSettings']			= "P3P Privacy Policies";
$GLOBALS['strUseP3P']				= "Use P3P Policies";
$GLOBALS['strP3PCompactPolicy']			= "P3P Compact Policy";
$GLOBALS['strP3PPolicyLocation']		= "P3P Policy Location"; 



// Banner Settings
$GLOBALS['strBannerSettings']			= "Banner settings";

$GLOBALS['strAllowedBannerTypes']		= "Allowed banner types";
$GLOBALS['strTypeSqlAllow']			= "Allow local banners (SQL)";
$GLOBALS['strTypeWebAllow']			= "Allow local banners (Webserver)";
$GLOBALS['strTypeUrlAllow']			= "Allow external banners";
$GLOBALS['strTypeHtmlAllow']			= "Allow HTML banners";
$GLOBALS['strTypeTxtAllow']			= "Allow Text ads";

$GLOBALS['strTypeWebSettings']			= "Local banner (Webserver) configuration";
$GLOBALS['strTypeWebMode']			= "Storing method";
$GLOBALS['strTypeWebModeLocal']			= "Local directory";
$GLOBALS['strTypeWebModeFtp']			= "External FTP server";
$GLOBALS['strTypeWebDir']			= "Local directory";
$GLOBALS['strTypeWebFtp']			= "FTP mode Web banner server";
$GLOBALS['strTypeWebUrl']			= "Public URL";
$GLOBALS['strTypeFTPHost']			= "FTP Host";
$GLOBALS['strTypeFTPDirectory']			= "Host directory";
$GLOBALS['strTypeFTPUsername']			= "Login";
$GLOBALS['strTypeFTPPassword']			= "Password";
$GLOBALS['strTypeFTPErrorDir']			= "The host directory does not exist";
$GLOBALS['strTypeFTPErrorConnect']		= "Could not connect to the FTP server, the login or password are not correct";
$GLOBALS['strTypeFTPErrorHost']			= "The hostname of the FTP server is not correct";
$GLOBALS['strTypeDirError']				= "The local directory does not exist";



$GLOBALS['strDefaultBanners']			= "Default banners";
$GLOBALS['strDefaultBannerUrl']			= "Default image URL";
$GLOBALS['strDefaultBannerTarget']		= "Default destination URL";

$GLOBALS['strTypeHtmlSettings']			= "HTML banner options";
$GLOBALS['strTypeHtmlAuto']			= "Automatically alter HTML banners in order to force click tracking";
$GLOBALS['strTypeHtmlPhp']			= "Allow PHP expressions to be executed from within a HTML banner";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']				= "Host information and Geotargeting";

$GLOBALS['strRemoteHost']				= "Remote host";
$GLOBALS['strReverseLookup']			= "Try to determine the hostname of the visitor if it is not supplied by the server";
$GLOBALS['strProxyLookup']				= "Try to determine the real IP address of the visitor if he is using a proxy server";

$GLOBALS['strGeotargeting']				= "Geotargeting";
$GLOBALS['strGeotrackingType']			= "Type of geotargeting database";
$GLOBALS['strGeotrackingLocation'] 		= "Geotargeting database location";
$GLOBALS['strGeotrackingLocationError'] = "The geotargeting database does not exist in the location you specified";
$GLOBALS['strGeotrackingLocationNoHTTP']	= "The location you supplied is not a local directory on the hard drive of the server, but an URL to a file on a webserver. The location should look similar to this: <i>{example}</i>. The actual location depends on where you copied the database.";
$GLOBALS['strGeoStoreCookie']			= "Store the result in a cookie for future reference";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Statistics Settings";

$GLOBALS['strStatisticsFormat']			= "Statistics format";
$GLOBALS['strCompactStats']				= "Statistics format";
$GLOBALS['strLogAdviews']				= "Log an AdView everytime a banner is delivered";
$GLOBALS['strLogAdclicks']				= "Log an AdClick everytime a visitor clicks on a banner";
$GLOBALS['strLogSource']				= "Log the source parameter specified during invocation";
$GLOBALS['strGeoLogStats']				= "Log the country of the visitor in the statistics";
$GLOBALS['strLogHostnameOrIP']			= "Log the hostname or IP address of the visitor";
$GLOBALS['strLogIPOnly']				= "Only log the IP address of the visitor even if the hostname is known";
$GLOBALS['strLogIP']					= "Log the IP address of the visitor";
$GLOBALS['strLogBeacon']				= "Use a small beacon image to log AdViews to ensure only delivered banners are logged";

$GLOBALS['strRemoteHosts']				= "Remote hosts";
$GLOBALS['strIgnoreHosts']				= "Don't store statistics for visitors using one of the following IP addresses or hostnames";
$GLOBALS['strBlockAdviews']				= "Don't log AdViews if the visitor already seen the same banner within the specified number of seconds";
$GLOBALS['strBlockAdclicks']			= "Don't log AdClicks if the visitor already clicked on the same banner within the specified number of seconds";


$GLOBALS['strPreventLogging']			= "Previnir logging";
$GLOBALS['strEmailWarnings']			= "Alertas de e-mail";
$GLOBALS['strAdminEmailHeaders']		= "Adicione o seguinte cabeçalho nas mensagens enviadas através do ".$phpAds_productname;
$GLOBALS['strWarnLimit']				= "Enviar mensagem de alerta quando o número de impressões for menor do que";
$GLOBALS['strWarnLimitErr']				= "O limite para Alerta deve ser um número positivo";
$GLOBALS['strWarnAdmin']				= "Enviar uma mensagem de Alerta ao administrador sempre que uma campanha estiver expirando";
$GLOBALS['strWarnClient']				= "Send a warning to the advertiser every time a campaign is almost expired";
$GLOBALS['strQmailPatch']				= "Enable qmail patch";

$GLOBALS['strAutoCleanTables']			= "Database pruning";
$GLOBALS['strAutoCleanStats']			= "Prune statistics";
$GLOBALS['strAutoCleanUserlog']			= "Prune user log";
$GLOBALS['strAutoCleanStatsWeeks']		= "Periodo maximo para estatísticas <br>(3 semanas - maximo)";
$GLOBALS['strAutoCleanUserlogWeeks']	= "Maximum age of user log <br>(3 weeks minimum)";
$GLOBALS['strAutoCleanErr']				= "Maximum age must be at least 3 weeks";
$GLOBALS['strAutoCleanVacuum']			= "VACUUM ANALYZE tabelas todas a noites"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Definições do Administrador";

$GLOBALS['strLoginCredentials']			= "Informações de Login";
$GLOBALS['strAdminUsername']			= "Nome de usuário do administrador";
$GLOBALS['strInvalidUsername']			= "Nome de usuário inválido";

$GLOBALS['strBasicInformation']			= "Informações básicas";
$GLOBALS['strAdminFullName']			= "Nome completo";
$GLOBALS['strAdminEmail']			= "endereço de e-mail";
$GLOBALS['strCompanyName']			= "Nome da empresa";

$GLOBALS['strAdminCheckUpdates']		= "Ver atualizações";
$GLOBALS['strAdminCheckEveryLogin']		= "A cada login";
$GLOBALS['strAdminCheckDaily']			= "Diariamente";
$GLOBALS['strAdminCheckWeekly']			= "Semanalmente";
$GLOBALS['strAdminCheckMonthly']		= "Mensalmente";
$GLOBALS['strAdminCheckNever']			= "Nunca";

$GLOBALS['strAdminNovice']			= "Confirmar quando o admistrador deletar arquivos por segurança";
$GLOBALS['strUserlogEmail']			= "Setar todas as mensagens de saida";
$GLOBALS['strUserlogPriority']			= "Setar calculos de prioridade a cada hora";
$GLOBALS['strUserlogAutoClean']			= "Setar limpeza automática da base de dados";


// User interface settings
$GLOBALS['strGuiSettings']			= "Configuração da Interface do usuário";

$GLOBALS['strGeneralSettings']			= "Definições Gerais";
$GLOBALS['strAppName']				= "Nome do Aplicativo";
$GLOBALS['strMyHeader']				= "Localização do arquivo de cabeçalho";
$GLOBALS['strMyHeaderError']		= "O arquivo de cabeçalho não existe no local informado";
$GLOBALS['strMyFooter']				= "Localização do arquivo de rodapé";
$GLOBALS['strMyFooterError']		= "O arquivo de rodapé não existe no local informado";
$GLOBALS['strGzipContentCompression']		= "Use compressão GZIP";

$GLOBALS['strClientInterface']			= "Interface do Anunciante";
$GLOBALS['strClientWelcomeEnabled']		= "Ativar mensagem de boas vindas ao anunciante";
$GLOBALS['strClientWelcomeText']		= "Texto de boas vindas<br>(Permitidas TAG HTML)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Interface defaults";

$GLOBALS['strInventory']			= "Inventário";
$GLOBALS['strShowCampaignInfo']			= "Mostrar informações adicionais da Campanha na página <i>Propriedades da Campanha</i>";
$GLOBALS['strShowBannerInfo']			= "Mostrar informações adicionais do banner na página  <i>Descrição do Anuncio</i>";
$GLOBALS['strShowCampaignPreview']		= "Mostrar todos os banners na página  <i>Descrição do Anuncio</i>";
$GLOBALS['strShowBannerHTML']			= "Mostrar o banner atual em vez do código HTML na previsão do banner HTML";
$GLOBALS['strShowBannerPreview']		= "Mostar a previsão do banner no topo da página";
$GLOBALS['strHideInactive']			= "Ocultar itens inativos em todas as páginas";
$GLOBALS['strGUIShowMatchingBanners']		= "Mostar banners semelhantes <i>Linked banner</i> paginas";
$GLOBALS['strGUIShowParentCampaigns']		= "Mostrar campanhas ligadas nas <i>Linked banner</i> paginas";
$GLOBALS['strGUILinkCompactLimit']		= "Ocultar campanhas ou banners não ligadas <i>Linked banner</i> páginas quando houver mais do que";

$GLOBALS['strStatisticsDefaults'] 		= "Estatísticas";
$GLOBALS['strBeginOfWeek']			= "Inicio da Semana";
$GLOBALS['strPercentageDecimals']		= "Porcentagem decimal";

$GLOBALS['strWeightDefaults']			= "Peso default";
$GLOBALS['strDefaultBannerWeight']		= "Peso do banner default";
$GLOBALS['strDefaultCampaignWeight']		= "Peso da campanha default";
$GLOBALS['strDefaultBannerWErr']		= "O peso do banner default deve ser um inteiro positivo";
$GLOBALS['strDefaultCampaignWErr']		= "O peso da campanha default deve ser um inteiro positivo";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "Tabela - côr da borda";
$GLOBALS['strTableBackColor']			= "Tabela - fundo";
$GLOBALS['strTableBackColorAlt']		= "Tabela - fundo (Alternativa)";
$GLOBALS['strMainBackColor']			= "Côr fundo principal";
$GLOBALS['strOverrideGD']			= "Override GD Imageformat";
$GLOBALS['strTimeZone']				= "Time Zone";

?>