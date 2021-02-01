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

// Installer translation strings
$GLOBALS['strInstall'] = "Instalar";
$GLOBALS['strDatabaseSettings'] = "Configurações de base de dados";
$GLOBALS['strAdminAccount'] = "Conta de Administrador";
$GLOBALS['strAdvancedSettings'] = "Configurações avançadas";
$GLOBALS['strWarning'] = "Alerta";
$GLOBALS['strBtnContinue'] = "Prosseguir »";
$GLOBALS['strBtnRecover'] = "Recuperar »";
$GLOBALS['strBtnAgree'] = "Eu concordo »";
$GLOBALS['strBtnRetry'] = "Tentar novamente";
$GLOBALS['strWarningRegisterArgcArv'] = "A variável register_argc_argv da configuração do PHP deve estar habilitada para que a manutenção seja executada pela linha de comando";
$GLOBALS['strTablesPrefix'] = "Table names prefix";
$GLOBALS['strTablesType'] = "Tipo das tabelas";

$GLOBALS['strRecoveryRequiredTitle'] = "Sua última tentativa de atualizar o sistema encontrou um erro";
$GLOBALS['strRecoveryRequired'] = "Um erro foi encontrado durante a última atualização e o {$PRODUCT_NAME} deve tentar recuperar esta atualização. Por favor clique no botão de Recuperação abaixo.";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} is up to date";
$GLOBALS['strOaUpToDate'] = "Sua base de dados {$PRODUCT_NAME} e a estrutura de arquivos estão ambos utilizando a versão mais recente e portanto nenhuma atualização é necessária neste momento. Por favor clique Prosseguir para continuar até o painel de Administração do {$PRODUCT_NAME}.";
$GLOBALS['strOaUpToDateCantRemove'] = "Atenção: o arquivo UPGRADE ainda está presente no seu diretório var. Foi impossível remover este arquivo devido a falta de permissão. Por favor remova o arquivo manualmente.";
$GLOBALS['strErrorWritePermissions'] = "Erros de permissão em arquivos foram detectados, e devem ser corrigidos antes de prosseguir.<br />Para corrigir estes erros em um sistema Linux, tente digitar o(s) seguinte(s) comando(s):";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod -R a+w %s</i>";
$GLOBALS['strNotWriteable'] = "NOT writeable";
$GLOBALS['strDirNotWriteableError'] = "Directory must be writeable";

$GLOBALS['strErrorWritePermissionsWin'] = "Erros de permissão em arquivos foram detectados, e devem ser corrigidos antes de prosseguir.";
$GLOBALS['strCheckDocumentation'] = "Para mais ajuda, verifique a <a href='{$PRODUCT_DOCSURL}'>documentação do {$PRODUCT_NAME}</a>.";
$GLOBALS['strSystemCheckBadPHPConfig'] = "Your current PHP configuration does not meet requirements of {$PRODUCT_NAME}. To resolve the problems, please modify settings in your 'php.ini' file.";

$GLOBALS['strAdminUrlPrefix'] = "URL da interface de administração";
$GLOBALS['strDeliveryUrlPrefix'] = "URL da engine de entrega";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL da engine de entrega (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL do armazenamento de imagens";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL do armazenamento de imagens (SSL)";


$GLOBALS['strUpgrade'] = "Upgrade";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Choose Section";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons.
    If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues.
    If you want to secure your system, you need to lock the configuration file for this installation.";
$GLOBALS['strUnableToWriteConfig'] = "Não é possível editar todas as configurações pois o arquivo de configuração esta travado por questões de segurança. Se deseja fazer alterações destrave o arquivo de configurações primeiro.";
$GLOBALS['strUnableToWritePrefs'] = "É possível editar toas configurações pois o arquivo de configuração esta liberado, mas isto pode levar a problemas de segurança. Se deseja tornar seus sistema seguro é necessário travar o arquivo de configuração.";
$GLOBALS['strImageDirLockedDetected'] = "O <b>Diretório de imagens</b> fornecido não possui permissão de escrita pelo servidor. <br>Você não poderá prosseguir até alterar as permissões ou criar a pasta.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Configuration settings";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Usuário administrativo";
$GLOBALS['strAdminPassword'] = "Senha de administração";
$GLOBALS['strInvalidUsername'] = "Nome de usuário inválido";
$GLOBALS['strBasicInformation'] = "Basic Information";
$GLOBALS['strAdministratorEmail'] = "E-mail do administrador";
$GLOBALS['strAdminCheckUpdates'] = "Automatically check for product updates and security alerts (Recommended).";
$GLOBALS['strAdminShareStack'] = "Share technical information with the {$PRODUCT_NAME} Team to help with development and testing.";
$GLOBALS['strNovice'] = "Delete actions require confirmation for safety";
$GLOBALS['strUserlogEmail'] = "Registrar todos e-mail enviados";
$GLOBALS['strEnableDashboard'] = "Enable dashboard";
$GLOBALS['strEnableDashboardSyncNotice'] = "Por favor habilite <a href='account-settings-update.php'>Verificar atualizações</a> se deseja usar o Painel de Controle.";
$GLOBALS['strTimezone'] = "Fuso horário";
$GLOBALS['strEnableAutoMaintenance'] = "Executar a manutenção automaticamente durante a entrega de anúncios se a manutenção não estiver agendada";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Configurações de base de dados";
$GLOBALS['strDatabaseServer'] = "Configurações globais do servidor de base de dados";
$GLOBALS['strDbLocal'] = "Usar conexão local por socket";
$GLOBALS['strDbType'] = "Tipo de banco";
$GLOBALS['strDbHost'] = "Endereço do banco";
$GLOBALS['strDbSocket'] = "Socket do Bando de dados";
$GLOBALS['strDbPort'] = "Porta do banco";
$GLOBALS['strDbUser'] = "Nome de usuário do banco";
$GLOBALS['strDbPassword'] = "Senha do banco";
$GLOBALS['strDbName'] = "Nome da base";
$GLOBALS['strDbNameHint'] = "A base de dados será criada caso não exista";
$GLOBALS['strDatabaseOptimalisations'] = "Configurações de otimização de banco de dados";
$GLOBALS['strPersistentConnections'] = "Usar conexões persistentes";
$GLOBALS['strCantConnectToDb'] = "Impossível conectar à base de dados";
$GLOBALS['strCantConnectToDbDelivery'] = 'Impossível conectar ao Banco de dados para entrega';

// Email Settings
$GLOBALS['strEmailSettings'] = "Email Settings";
$GLOBALS['strEmailAddresses'] = "Endereço de remetente de E-mails";
$GLOBALS['strEmailFromName'] = "Nome do remetente de E-mails";
$GLOBALS['strEmailFromAddress'] = "Endereço do remetente do e-mail";
$GLOBALS['strEmailFromCompany'] = "Nome da Companhia de E-mails";
$GLOBALS['strUseManagerDetails'] = 'Use the owning account\'s Contact, Email and Name instead of the above Name, Email Address and Company when emailing reports to Advertiser or Website accounts.';
$GLOBALS['strQmailPatch'] = "patch para qmail";
$GLOBALS['strEnableQmailPatch'] = "Enable qmail patch";
$GLOBALS['strEmailHeader'] = "Email headers";
$GLOBALS['strEmailLog'] = "Email log";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Configurações de Auditoria de percurso";
$GLOBALS['strEnableAudit'] = "Enable Audit Trail";
$GLOBALS['strEnableAuditForZoneLinking'] = "Enable Audit Trail for Zone Linking screen (introduces huge performance penalty when linking large amounts of zones)";

// Debug Logging Settings
$GLOBALS['strDebug'] = "Configurações de log de debug";
$GLOBALS['strEnableDebug'] = "Habilitar registro de debug";
$GLOBALS['strDebugMethodNames'] = "Incluir nome de métodos no log de debug";
$GLOBALS['strDebugLineNumbers'] = "Incluir número da linha no log de debug";
$GLOBALS['strDebugType'] = "Tipo de log de debug";
$GLOBALS['strDebugTypeFile'] = "Arquivo";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "Base de dados SQL";
$GLOBALS['strDebugTypeSyslog'] = "Syslog";
$GLOBALS['strDebugName'] = "Nome do log, Calendário, Tabela SQL,<br /> ou SysLog";
$GLOBALS['strDebugPriority'] = "Nível de prioridade do debug";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Mais Informação";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Informação padrão";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - Menos informação";
$GLOBALS['strDebugIdent'] = "String de identificação de debug";
$GLOBALS['strDebugUsername'] = "Nome de usuário do mCal, SQL Server";
$GLOBALS['strDebugPassword'] = "Senha do mCal, SQL Server";
$GLOBALS['strProductionSystem'] = "Sistema em Produção";

// Delivery Settings
$GLOBALS['strWebPath'] = "{$PRODUCT_NAME} Server Access Paths";
$GLOBALS['strWebPathSimple'] = "Caminho pela Web";
$GLOBALS['strDeliveryPath'] = "Caminho de entrega";
$GLOBALS['strImagePath'] = "Caminho de Imagens";
$GLOBALS['strDeliverySslPath'] = "Caminho de entrega SSL";
$GLOBALS['strImageSslPath'] = "Caminho de imagens SSL";
$GLOBALS['strImageStore'] = "Diretório de imagens";
$GLOBALS['strTypeWebSettings'] = "Configurações de armazenamento local de banners";
$GLOBALS['strTypeWebMode'] = "Forma de armazenamento";
$GLOBALS['strTypeWebModeLocal'] = "Diretório local";
$GLOBALS['strTypeDirError'] = "O diretório local não possui permissão de escrita pelo servidor";
$GLOBALS['strTypeWebModeFtp'] = "Servidor de FTP externo";
$GLOBALS['strTypeWebDir'] = "Diretório local";
$GLOBALS['strTypeFTPHost'] = "Endereço do FTP";
$GLOBALS['strTypeFTPDirectory'] = "Diretório do servidor";
$GLOBALS['strTypeFTPUsername'] = "Login ";
$GLOBALS['strTypeFTPPassword'] = "Senha";
$GLOBALS['strTypeFTPPassive'] = "Use FTP Passivo";
$GLOBALS['strTypeFTPErrorDir'] = "O Diretório não existe no Servidor de FTP";
$GLOBALS['strTypeFTPErrorConnect'] = "Impossível conectar ao servidor de FTP, o login ou senha estão incorretos";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Your installation of PHP does not support FTP.";
$GLOBALS['strTypeFTPErrorUpload'] = "Impossível realizar upload para o servidor FTP, verifique as permissões no diretório do Host";
$GLOBALS['strTypeFTPErrorHost'] = "O endereço do Servidor FTP está incorreto";
$GLOBALS['strDeliveryFilenames'] = "Nome de arquivos de entrega";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Clique em anúncio";
$GLOBALS['strDeliveryFilenamesSignedAdClick'] = "Signed Ad Click";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "Variáveis de conversão de anúncios";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Conteúdo de anúncios";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "Conversão de anúncios";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "Conversão de anúncios (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Frame de anúncios";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Imagem do anúncio";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Anúncio (Javascript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Layer de anúncio";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Log de anúncio";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Popup de Anúncio";
$GLOBALS['strDeliveryFilenamesAdView'] = "Visualização de anúncio";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "Inclusão por XML RPC";
$GLOBALS['strDeliveryFilenamesLocal'] = "Inserção local";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Ponto de entrada único (Front Controller)";
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "Single Page Call";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "Single Page Call (JavaScript)";
$GLOBALS['strDeliveryFilenamesAsyncJS'] = "Async JavaScript (source file)";
$GLOBALS['strDeliveryFilenamesAsyncPHP'] = "Async JavaScript";
$GLOBALS['strDeliveryFilenamesAsyncSPC'] = "Async JavaScript Single Page Call";
$GLOBALS['strDeliveryCaching'] = "Configurações de Cache de Entrega de Banners";
$GLOBALS['strDeliveryCacheLimit'] = "Tempo entre atualizações do Cache de Banners(segundos)";
$GLOBALS['strDeliveryCacheStore'] = "Banner Delivery Cache Store Type";
$GLOBALS['strDeliveryAcls'] = "Evaluate banner delivery rules during delivery";
$GLOBALS['strDeliveryAclsDirectSelection'] = "Evaluate banner delivery rules for direct selected ads";
$GLOBALS['strDeliveryObfuscate'] = "Obfuscate delivery rule set when delivering ads";
$GLOBALS['strDeliveryCtDelimiter'] = "Delimitador de rastreadores de cliques de terceiros";
$GLOBALS['strGlobalDefaultBannerUrl'] = "URL padrão de banners de imagem (Global)";
$GLOBALS['strGlobalDefaultBannerInvalidZone'] = "Global default HTML Banner for non-existing zones";
$GLOBALS['strGlobalDefaultBannerSuspendedAccount'] = "Global default HTML Banner for suspended accounts";
$GLOBALS['strGlobalDefaultBannerInactiveAccount'] = "Global default HTML Banner for inactive accounts";
$GLOBALS['strP3PSettings'] = "Políticas de Privacidade P3P";
$GLOBALS['strUseP3P'] = "Usar políticas P3P";
$GLOBALS['strP3PCompactPolicy'] = "Política P3P compacta";
$GLOBALS['strP3PPolicyLocation'] = "Localização da política P3P";
$GLOBALS['strPrivacySettings'] = "Privacy Settings";
$GLOBALS['strDisableViewerId'] = "Disable unique Viewer Id cookie";
$GLOBALS['strAnonymiseIp'] = "Anonymise viewer IP addresses";

// General Settings
$GLOBALS['generalSettings'] = "Global General System Settings";
$GLOBALS['uiEnabled'] = "Interface do usuário habilitada";
$GLOBALS['defaultLanguage'] = "Default System Language<br />(Each user can select their own language)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Configurações de Direcionamento Geográfico (GeoTargeting)";
$GLOBALS['strGeotargeting'] = "Configurações de Direcionamento Geográfico (GeoTargeting)";
$GLOBALS['strGeotargetingType'] = "Tipo de módulo de direcionamento";
$GLOBALS['strGeoShowUnavailable'] = "Show geotargeting delivery rules even if GeoIP data unavailable";

// Interface Settings
$GLOBALS['strInventory'] = "Inventário";
$GLOBALS['strShowCampaignInfo'] = "Mostrar dados extras de campanhas na página de <i>Campanhas</i>";
$GLOBALS['strShowBannerInfo'] = "Mostrar dados extras de banners na página de <i>Banners</i>";
$GLOBALS['strShowCampaignPreview'] = "Mostrar pre-visualização de banners na página de <i>Banners</i>";
$GLOBALS['strShowBannerHTML'] = "Mostrar banner ao invés de código HTML na pré-visualização de banners HTML";
$GLOBALS['strShowBannerPreview'] = "Mostrar pré-visualização do banner em páginas que lidam com banners";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "Use the WYSIWYG HTML Editor by default when creating or editing HTML banners";
$GLOBALS['strHideInactive'] = "Hide inactive items from all overview pages";
$GLOBALS['strGUIShowMatchingBanners'] = "Mostrar banners compatíveis na página de <i>Banners vinculados</i>";
$GLOBALS['strGUIShowParentCampaigns'] = "Mostrar campanhas superiores na página de <i>Banners vinculados</i>";
$GLOBALS['strShowEntityId'] = "Show entity identifiers";
$GLOBALS['strStatisticsDefaults'] = "Estatísticas";
$GLOBALS['strBeginOfWeek'] = "Início da semana";
$GLOBALS['strPercentageDecimals'] = "Decimais de percentagens";
$GLOBALS['strWeightDefaults'] = "Peso padrão";
$GLOBALS['strDefaultBannerWeight'] = "Peso padrão de banners";
$GLOBALS['strDefaultCampaignWeight'] = "Peso padrão de campanhas";
$GLOBALS['strConfirmationUI'] = "Confirmation in User Interface";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "Padrões de inserção";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Habilitar por padrão o rastreamento de cliques de terceiros";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Configurações de Entrega de Banners";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Configurações de Log estatístico de banners";
$GLOBALS['strLogAdRequests'] = "Logar uma requisição a cada vez que um anúncio é requisitado";
$GLOBALS['strLogAdImpressions'] = "Logar uma impressão a cada vez que um anúncio é visualizado";
$GLOBALS['strLogAdClicks'] = "Logar um clique cada vez que um visualizador clique em um anúncio";
$GLOBALS['strReverseLookup'] = "Realizar um lookup reverso de visualizadores quando não for fornecido o endereço (hostname)";
$GLOBALS['strProxyLookup'] = "Tentar determinar o endereço IP real de visualizadores atrás de servidores proxy";
$GLOBALS['strPreventLogging'] = "Bloquear configurações de Log estatístico de banners";
$GLOBALS['strIgnoreHosts'] = "Não armazenar estatísticas para visualizadores usando os seguintes IPs e Hostnames";
$GLOBALS['strIgnoreUserAgents'] = "<b>Não</b> registre estatísticas de clientes com qualquer uma das palavras abaixo em seu user-agent (um por linha)";
$GLOBALS['strEnforceUserAgents'] = "<b>Somente</b> registre estatísticas de clientes com qualquer uma das palavras abaixo em seu user-agent (um por linha)";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "Banner Storage Settings";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "Use eCPM optimized priorities instead of remnant-weighted priorities";
$GLOBALS['strEnableContractECPM'] = "Use eCPM optimized priorities instead of standard contract priorities";
$GLOBALS['strEnableECPMfromRemnant'] = "(If you enable this feature all your remnant campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strEnableECPMfromECPM'] = "(If you disable this feature some of your active eCPM campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strInactivatedCampaigns'] = "List of campaigns which became inactive due to the changes in preferences:";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "Maintenance Settings";
$GLOBALS['strConversionTracking'] = "Configurações de acompanhamento de Conversões";
$GLOBALS['strEnableConversionTracking'] = "Habilitar acompanhamento de Conversões";
$GLOBALS['strBlockInactiveBanners'] = "Don't count ad impressions, clicks or re-direct the user to the target URL if the viewer clicks on a banner that is inactive";
$GLOBALS['strBlockAdClicks'] = "Não contar cliques se o visualizador clicar o mesmo par de anúncio/zona dentro do tempo especificado (segundos)";
$GLOBALS['strMaintenanceOI'] = "Intervalo de operações de manutenção (minutos)";
$GLOBALS['strPrioritySettings'] = "Configurações de prioridade";
$GLOBALS['strPriorityInstantUpdate'] = "Atualizar prioridade de anúncios imediatamente após mudanças na interface";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "Intentionally over-deliver Contract Campaigns<br />(% over-delivery)";
$GLOBALS['strDefaultImpConvWindow'] = "Default Ad Impression Conversion Window (seconds)";
$GLOBALS['strDefaultCliConvWindow'] = "Default Ad Click Conversion Window (seconds)";
$GLOBALS['strAdminEmailHeaders'] = "Add the following headers to each email message sent by {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Enviar um alerta quando o número de impressões restantes for menor que o número especificado";
$GLOBALS['strWarnLimitDays'] = "Enviar um alerta quando os dias restantes forem menor que o número especificado";
$GLOBALS['strWarnAdmin'] = "Enviar um alerta para o administrador quando uma campanha estiver quase expirada";
$GLOBALS['strWarnClient'] = "Enviar um alerta para o anunciante sempre que uma campanha estiver quase expirada";
$GLOBALS['strWarnAgency'] = "Enviar um alerta para a agência sempre que uma campanha estiver quase expirada";

// UI Settings
$GLOBALS['strGuiSettings'] = "Configurações da Interface de usuários";
$GLOBALS['strGeneralSettings'] = "Configurações gerais";
$GLOBALS['strAppName'] = "Nome da aplicação";
$GLOBALS['strMyHeader'] = "Localização do arquivo de cabeçalho";
$GLOBALS['strMyFooter'] = "Localização do arquivo de rodapé";
$GLOBALS['strDefaultTrackerStatus'] = "Estado padrão do rastreador";
$GLOBALS['strDefaultTrackerType'] = "Tipo padrão do rastreador";
$GLOBALS['strSSLSettings'] = "SSL Settings";
$GLOBALS['requireSSL'] = "Forçar acesso por SSL na interface de usuários";
$GLOBALS['sslPort'] = "Porta SSL usada pelo servidor";
$GLOBALS['strDashboardSettings'] = "Configurações do Painel de Controle";
$GLOBALS['strMyLogo'] = "Nome do arquivo da logomarca padrão";
$GLOBALS['strGuiHeaderForegroundColor'] = "Cor do primeiro plano no cabeçalho";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Cor do fundo no cabeçalho";
$GLOBALS['strGuiActiveTabColor'] = "Cor da aba ativa";
$GLOBALS['strGuiHeaderTextColor'] = "Cor do texto no cabeçalho";
$GLOBALS['strGuiSupportLink'] = "Custom URL for 'Support' link in header";
$GLOBALS['strGzipContentCompression'] = "Usar compressão GZIP no conteúdo";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "Platform Hash Regenerate";
$GLOBALS['strNewPlatformHash'] = "Your new Platform Hash is:";
$GLOBALS['strPlatformHashInsertingError'] = "Error inserting Platform Hash into database";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "Plugin Settings";
$GLOBALS['strEnableNewPlugins'] = "Enable newly installed plugins";
$GLOBALS['strUseMergedFunctions'] = "Use merged delivery functions file";
