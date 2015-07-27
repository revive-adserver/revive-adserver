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

// Set text direction and characterset

$GLOBALS['phpAds_DecimalPoint'] = ",";
$GLOBALS['phpAds_ThousandsSeperator'] = ".";

// Date & time configuration
$GLOBALS['date_format'] = "%m/%d/%Y";
$GLOBALS['month_format'] = "%m/%Y";
$GLOBALS['day_format'] = "%m/%d";
$GLOBALS['week_format'] = "%W/%Y";
$GLOBALS['weekiso_format'] = "%V/%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "Principal";
$GLOBALS['strHelp'] = "Ajuda";
$GLOBALS['strStartOver'] = "Re-iniciar";
$GLOBALS['strShortcuts'] = "Atalhos";
$GLOBALS['strActions'] = "Ações";
$GLOBALS['strAndXMore'] = "e mais %s";
$GLOBALS['strAdminstration'] = "Inventário";
$GLOBALS['strMaintenance'] = "Manutenção";
$GLOBALS['strProbability'] = "Probabilidade";
$GLOBALS['strInvocationcode'] = "Código de inserção";
$GLOBALS['strBasicInformation'] = "Informações básicas";
$GLOBALS['strAppendTrackerCode'] = "Anexar código de rastreamento";
$GLOBALS['strOverview'] = "Visão geral";
$GLOBALS['strSearch'] = "Bu<u>s</u>ca";
$GLOBALS['strDetails'] = "Detalhes";
$GLOBALS['strUpdateSettings'] = "Configurações de Atualização";
$GLOBALS['strCheckForUpdates'] = "Procurar atualizações";
$GLOBALS['strWhenCheckingForUpdates'] = "Quando há verificação de atualizações";
$GLOBALS['strCompact'] = "Compactar";
$GLOBALS['strUser'] = "Usuário";
$GLOBALS['strDuplicate'] = "Duplicar";
$GLOBALS['strCopyOf'] = "Cópia de";
$GLOBALS['strMoveTo'] = "Mover para";
$GLOBALS['strDelete'] = "Remover";
$GLOBALS['strActivate'] = "Ativar";
$GLOBALS['strConvert'] = "Converter";
$GLOBALS['strRefresh'] = "Recarregar";
$GLOBALS['strSaveChanges'] = "Salvar alterações";
$GLOBALS['strUp'] = "Para cima";
$GLOBALS['strDown'] = "Para baixo";
$GLOBALS['strSave'] = "Salvar";
$GLOBALS['strCancel'] = "Cancelar";
$GLOBALS['strBack'] = "Voltar";
$GLOBALS['strPrevious'] = "Anterior";
$GLOBALS['strNext'] = "Próximo";
$GLOBALS['strYes'] = "Sim";
$GLOBALS['strNo'] = "Não";
$GLOBALS['strNone'] = "Nenhum";
$GLOBALS['strCustom'] = "Personalizado";
$GLOBALS['strDefault'] = "Padrão";
$GLOBALS['strUnknown'] = "Desconhecido";
$GLOBALS['strUnlimited'] = "Ilimitado";
$GLOBALS['strUntitled'] = "Sem título";
$GLOBALS['strAll'] = "todos";
$GLOBALS['strAverage'] = "Média";
$GLOBALS['strOverall'] = "Geral";
$GLOBALS['strTotal'] = "Total";
$GLOBALS['strFrom'] = "De";
$GLOBALS['strTo'] = "para";
$GLOBALS['strAdd'] = "Adicionar";
$GLOBALS['strLinkedTo'] = "vinculado com";
$GLOBALS['strDaysLeft'] = "Dias restantes";
$GLOBALS['strCheckAllNone'] = "Selecionar todos/nenhum";
$GLOBALS['strKiloByte'] = "KB";
$GLOBALS['strExpandAll'] = "<u>E</u>xpandir todos";
$GLOBALS['strCollapseAll'] = "Fe<u>c</u>har todos";
$GLOBALS['strShowAll'] = "Mostrar todos";
$GLOBALS['strNoAdminInterface'] = "A tela de administração foi desligada para manutenção. Isso não afeta a entrega de suas campanhas.";
$GLOBALS['strFieldStartDateBeforeEnd'] = "A data 'De' deve ser anterior à data 'Até'";
$GLOBALS['strFieldContainsErrors'] = "Estes campos contêm erros:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Antes de continuar você precisa";
$GLOBALS['strFieldFixBeforeContinue2'] = "para corrigir estes erros.";
$GLOBALS['strMiscellaneous'] = "Miscelânea";
$GLOBALS['strCollectedAllStats'] = "Todas estatísticas";
$GLOBALS['strCollectedToday'] = "Hoje";
$GLOBALS['strCollectedYesterday'] = "Ontem";
$GLOBALS['strCollectedThisWeek'] = "Esta semana";
$GLOBALS['strCollectedLastWeek'] = "Semana passada";
$GLOBALS['strCollectedThisMonth'] = "Este mês";
$GLOBALS['strCollectedLastMonth'] = "Mês passado";
$GLOBALS['strCollectedLast7Days'] = "Últimos 7 dias";
$GLOBALS['strCollectedSpecificDates'] = "Datas específicas";
$GLOBALS['strValue'] = "Valor";
$GLOBALS['strWarning'] = "Alerta";
$GLOBALS['strNotice'] = "Aviso";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "O painel de controle não pode ser exibido";
$GLOBALS['strNoCheckForUpdates'] = "O painel de controle não pode ser exibido  a menos que a <br /> configuração  de verificação de atualizações esteja habilitada.";
$GLOBALS['strEnableCheckForUpdates'] = "Por favor, ative a configuração <a href='account-settings-update.php' target='_top'> verificar se há atualizações</a> na página <br/> <a href='account-settings-update.php' target='_top'>  Configuração de atualizações</a>.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "código";
$GLOBALS['strDashboardSystemMessage'] = "Mensagem do Sistema";
$GLOBALS['strDashboardErrorHelp'] = "Caso este erro ocorra novamente, po favor descreva em detalhes no <a href='http://forum.openx.org/'>Fórum OpenX</a>.";

// Priority
$GLOBALS['strPriority'] = "Prioridade";
$GLOBALS['strPriorityLevel'] = "Nível de prioridade";
$GLOBALS['strOverrideAds'] = "Anúncios de Campanhas de Sobreposição";
$GLOBALS['strHighAds'] = "Anúncios com Alta prioridade";
$GLOBALS['strECPMAds'] = "eCPM dos Anúncios da Campanha";
$GLOBALS['strLowAds'] = "Anúncios com Baixa prioridade";
$GLOBALS['strLimitations'] = "Limites";
$GLOBALS['strNoLimitations'] = "Sem limites";
$GLOBALS['strCapping'] = "Excesso";

// Properties
$GLOBALS['strName'] = "Nome";
$GLOBALS['strSize'] = "Tamanho";
$GLOBALS['strWidth'] = "Largura";
$GLOBALS['strHeight'] = "Altura";
$GLOBALS['strTarget'] = "Alvo (target)";
$GLOBALS['strLanguage'] = "Idioma";
$GLOBALS['strDescription'] = "Descrição";
$GLOBALS['strVariables'] = "Variáveis";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "Comentários";

// User access
$GLOBALS['strWorkingAs'] = "Trabalhando como";
$GLOBALS['strWorkingAs_Key'] = "<u>T</u>rabalhando como";
$GLOBALS['strWorkingAs'] = "Trabalhando como";
$GLOBALS['strSwitchTo'] = "Alternar para";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "Use caixa de seleção para encontrar mais contas";
$GLOBALS['strWorkingFor'] = "%s para ....";
$GLOBALS['strNoAccountWithXInNameFound'] = "Nenhuma conta econtrada com \"%s\" no nome";
$GLOBALS['strRecentlyUsed'] = "Usado recentemente";
$GLOBALS['strLinkUser'] = "Adicionar usuário";
$GLOBALS['strLinkUser_Key'] = "Vincular <u>u</u>suário";
$GLOBALS['strUsernameToLink'] = "Nome do usuário do usuário que será adicionado";
$GLOBALS['strNewUserWillBeCreated'] = "Novo usuário será criado";
$GLOBALS['strToLinkProvideEmail'] = "Para adicionar um usuário, informe o e-mail do mesmo";
$GLOBALS['strToLinkProvideUsername'] = "Para adicionar um usuário, informe o nome de usuário";
$GLOBALS['strUserLinkedToAccount'] = "O usuário foi adicionado à conta";
$GLOBALS['strUserAccountUpdated'] = "Conta de usuário atualizada";
$GLOBALS['strUserUnlinkedFromAccount'] = "O usuário foi removido da conta";
$GLOBALS['strUserWasDeleted'] = "O usuário foi removido";
$GLOBALS['strUserNotLinkedWithAccount'] = "Este usuário não esta vinculado a esta conta";
$GLOBALS['strCantDeleteOneAdminUser'] = "Você não pode remover um usuário. Pelo menos um usuário deve estar vinculado à conta de administração";
$GLOBALS['strLinkUserHelpUser'] = "Nome de usuário";
$GLOBALS['strLinkUserHelpEmail'] = "Endereço de e-mail";
$GLOBALS['strLastLoggedIn'] = "Adicionar <u>u</u>suário";
$GLOBALS['strDateLinked'] = "Data de vinculação";

// Login & Permissions
$GLOBALS['strUserAccess'] = "Acesso de usuário";
$GLOBALS['strAdminAccess'] = "Acesso de administrador";
$GLOBALS['strUserProperties'] = "Dados do usuário";
$GLOBALS['strPermissions'] = "Permissões";
$GLOBALS['strAuthentification'] = "Autenticação";
$GLOBALS['strWelcomeTo'] = "Bem vindo a";
$GLOBALS['strEnterUsername'] = "Entre com seu nome de usuário e senha para se logar";
$GLOBALS['strEnterBoth'] = "Por favor digite ambos seu nome de usuário e senha";
$GLOBALS['strEnableCookies'] = "Você precisa habilitar \"cookies\" em seu navegador para utilizar {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "Erro no cookie de sessão, por favor faça login novamente";
$GLOBALS['strLogin'] = "Login ";
$GLOBALS['strLogout'] = "Sair";
$GLOBALS['strUsername'] = "Nome de usuário";
$GLOBALS['strPassword'] = "Senha";
$GLOBALS['strPasswordRepeat'] = "Repita a senha";
$GLOBALS['strAccessDenied'] = "Acesso negado";
$GLOBALS['strUsernameOrPasswordWrong'] = "O nome de usuário e/ou senha estão incorretos. Por favor tente novamente.";
$GLOBALS['strPasswordWrong'] = "A senha esta incorreta.";
$GLOBALS['strNotAdmin'] = "Sua conta não possui as permissões necessárias para utilizar esta função, você pode logar em outra conta para utilizá-la. Clique <a href='logout.php'>aqui</a> para logar como um usuário diferente.";
$GLOBALS['strDuplicateClientName'] = "O nome de usuário fornecido já existe, por favor escolha outro.";
$GLOBALS['strInvalidPassword'] = "A nova senha é inválida, use uma senha diferente.";
$GLOBALS['strInvalidEmail'] = "O e-mail não possui a formatação correta, por favor informe um e-mail válido.";
$GLOBALS['strNotSamePasswords'] = "As senhas fornecidas não são iguais";
$GLOBALS['strRepeatPassword'] = "Repetir senha";
$GLOBALS['strDeadLink'] = "Seu link é inválido";
$GLOBALS['strNoPlacement'] = "A campanha selecionada não existe. Tente este <a href='{link}'>link</a>.";
$GLOBALS['strNoAdvertiser'] = "O anunciante escolhido não existe. Tente este <a href='{link}'>link</a>.";

// General advertising
$GLOBALS['strRequests'] = "Requisições";
$GLOBALS['strImpressions'] = "Impressões";
$GLOBALS['strClicks'] = "Cliques";
$GLOBALS['strConversions'] = "Conversões";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "Total de cliques";
$GLOBALS['strTotalConversions'] = "Total de conversões";
$GLOBALS['strDateTime'] = "Data e Hora";
$GLOBALS['strTrackerID'] = "ID do rastreador";
$GLOBALS['strTrackerName'] = "Nome do rastreador";
$GLOBALS['strTrackerImageTag'] = "Tag de imagem";
$GLOBALS['strTrackerJsTag'] = "Tag de javascript";
$GLOBALS['strTrackerAlwaysAppend'] = "Sempre exibir código acrescentado, mesmo se nenhuma conversão for gravada pelo rastreador?";
$GLOBALS['strBanners'] = "Anúncios";
$GLOBALS['strCampaigns'] = "Campanhas";
$GLOBALS['strCampaignID'] = "ID da campanha";
$GLOBALS['strCampaignName'] = "Nome da campanha";
$GLOBALS['strCountry'] = "País";
$GLOBALS['strStatsAction'] = "Ação";
$GLOBALS['strWindowDelay'] = "Atraso da janela";
$GLOBALS['strStatsVariables'] = "Variáveis";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM ";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Locação mensal";
$GLOBALS['strFinanceCTR'] = "CTR";

// Time and date related
$GLOBALS['strDate'] = "Data";
$GLOBALS['strDay'] = "Dia";
$GLOBALS['strDays'] = "Dias";
$GLOBALS['strWeek'] = "Semana";
$GLOBALS['strWeeks'] = "Semanas";
$GLOBALS['strSingleMonth'] = "Mês";
$GLOBALS['strMonths'] = "Meses";
$GLOBALS['strDayOfWeek'] = "Dia da semana";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = array();
}
$GLOBALS['strDayFullNames'][0] = 'Domingo';
$GLOBALS['strDayFullNames'][1] = 'Segunda';
$GLOBALS['strDayFullNames'][2] = 'Terça';
$GLOBALS['strDayFullNames'][3] = 'Quarta';
$GLOBALS['strDayFullNames'][4] = 'Quinta';
$GLOBALS['strDayFullNames'][5] = 'Sexta';
$GLOBALS['strDayFullNames'][6] = 'Sábado';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = array();
}
$GLOBALS['strDayShortCuts'][0] = 'Dom';
$GLOBALS['strDayShortCuts'][1] = 'Seg';
$GLOBALS['strDayShortCuts'][2] = 'Ter';
$GLOBALS['strDayShortCuts'][3] = 'Qua';
$GLOBALS['strDayShortCuts'][4] = 'Qui';
$GLOBALS['strDayShortCuts'][5] = 'Sex';
$GLOBALS['strDayShortCuts'][6] = 'Sáb';

$GLOBALS['strHour'] = "Hora";
$GLOBALS['strSeconds'] = "segundos";
$GLOBALS['strMinutes'] = "minutos";
$GLOBALS['strHours'] = "horas";

// Advertiser
$GLOBALS['strClient'] = "Anunciante";
$GLOBALS['strClients'] = "Anunciantes";
$GLOBALS['strClientsAndCampaigns'] = "Anunciantes e campanhas";
$GLOBALS['strAddClient'] = "Adicionar novo anunciante";
$GLOBALS['strClientProperties'] = "Dados do anunciante";
$GLOBALS['strClientHistory'] = "Histórico do anunciante";
$GLOBALS['strNoClients'] = "Nenhum anunciante definido. Para criar uma campanha, <a href='advertiser-edit.php'>adicione um anunciante</a> primeiro.";
$GLOBALS['strConfirmDeleteClient'] = "Deseja realmente remover este anunciante?";
$GLOBALS['strConfirmDeleteClients'] = "Deseja realmente remover este anunciante?";
$GLOBALS['strHideInactive'] = "Ocultar inativos";
$GLOBALS['strInactiveAdvertisersHidden'] = "anunciante(s) inativo(s) ocultado(s)";
$GLOBALS['strAdvertiserSignup'] = "Inscrição de anunciante";
$GLOBALS['strAdvertiserCampaigns'] = "Anunciantes e campanhas";

// Advertisers properties
$GLOBALS['strContact'] = "Contato";
$GLOBALS['strContactName'] = "Nome de contato";
$GLOBALS['strEMail'] = "E-mail";
$GLOBALS['strSendAdvertisingReport'] = "Relatório de entrega e e-mails de campanha";
$GLOBALS['strNoDaysBetweenReports'] = "Número de dias entre relatórios de entrega de campanha";
$GLOBALS['strSendDeactivationWarning'] = "Enviar e-mail quando a campanha for automaticamente ativada/desativada";
$GLOBALS['strAllowClientModifyBanner'] = "Permitir que este usuário altere seus banners";
$GLOBALS['strAllowClientDisableBanner'] = "Permitir que este usuário desative seus próprios banners";
$GLOBALS['strAllowClientActivateBanner'] = "Permitir que este usuário ative seus próprios banners";
$GLOBALS['strAllowCreateAccounts'] = "Permitir que este usuário crie novas contas";
$GLOBALS['strAdvertiserLimitation'] = "Mostre apenas um anúncio deste anunciante em uma página";
$GLOBALS['strAllowAuditTrailAccess'] = "Permitir que este usuário acesse o rastro de auditoria";

// Campaign
$GLOBALS['strCampaign'] = "Campanha";
$GLOBALS['strCampaigns'] = "Campanhas";
$GLOBALS['strAddCampaign'] = "Adicionar uma nova campanha";
$GLOBALS['strAddCampaign_Key'] = "Adicionar <u>n</u>ova campanha";
$GLOBALS['strCampaignForAdvertiser'] = "Campanha para anunciante";
$GLOBALS['strLinkedCampaigns'] = "Campanhas vinculadas";
$GLOBALS['strCampaignProperties'] = "Dados da campanha";
$GLOBALS['strCampaignOverview'] = "Visão geral da campanha";
$GLOBALS['strCampaignHistory'] = "Histórico da campanha";
$GLOBALS['strNoCampaigns'] = "Nenhuma campanha ativa definida";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "Não há campanhas definidas, porque não há anunciantes. Para criar uma campanha, <a href='advertiser-edit.php'> Adicione um novo anunciante</a> primeiro.";
$GLOBALS['strConfirmDeleteCampaign'] = "Deseja realmente remover esta campanha?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Deseja realmente remover esta campanha?";
$GLOBALS['strShowParentAdvertisers'] = "Mostrar anunciantes superiores";
$GLOBALS['strHideParentAdvertisers'] = "Esconder anunciantes superiores";
$GLOBALS['strHideInactiveCampaigns'] = "Esconder campanhas inativas";
$GLOBALS['strInactiveCampaignsHidden'] = "campanha(s) inativa(s) ocultada(s)";
$GLOBALS['strPriorityInformation'] = "Prioridade em relação a outras campanhas";
$GLOBALS['strHiddenCampaign'] = "Campanha";
$GLOBALS['strHiddenAd'] = "Anúncio";
$GLOBALS['strHiddenAdvertiser'] = "Anunciante";
$GLOBALS['strHiddenTracker'] = "Rastreador";
$GLOBALS['strHiddenWebsite'] = "Site";
$GLOBALS['strHiddenZone'] = "Zona";
$GLOBALS['strCompanionPositioning'] = "Entrega casada (com outras peças)";
$GLOBALS['strSelectUnselectAll'] = "Selecionar / Deselecionar Todos";
$GLOBALS['strShowCappedNoCookie'] = "Mostrar anúncios tampados se os cookies estiverem desabilitados";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "Calculado para todas as campanhas";
$GLOBALS['strCalculatedForThisCampaign'] = "Calculado para esta campanha";
$GLOBALS['strLinkingZonesProblem'] = "Problema ocorreu quando vinculando zonas";
$GLOBALS['strUnlinkingZonesProblem'] = "Problema ocorreu quando desvinculando zonas";
$GLOBALS['strZonesLinked'] = "zona(s) vinculada(s)";
$GLOBALS['strZonesUnlinked'] = "zona(s) desvinculada(s)";
$GLOBALS['strZonesSearch'] = "Busca";
$GLOBALS['strZonesSearchTitle'] = "Busca de zonas e sites por nome";
$GLOBALS['strLinked'] = "Vinculado";
$GLOBALS['strAvailable'] = "Disponível";
$GLOBALS['strShowing'] = "Exibindo";
$GLOBALS['strEditZone'] = "Editar zona";
$GLOBALS['strEditWebsite'] = "Editar site";


// Campaign properties
$GLOBALS['strDontExpire'] = "Não desativar";
$GLOBALS['strActivateNow'] = "Ativar imediatamente";
$GLOBALS['strSetSpecificDate'] = "Definir data específica";
$GLOBALS['strLow'] = "Baixa";
$GLOBALS['strHigh'] = "Alta";
$GLOBALS['strExpirationDate'] = "Data de término";
$GLOBALS['strExpirationDateComment'] = "A campanha terminará ao final deste dia";
$GLOBALS['strActivationDate'] = "Data de início";
$GLOBALS['strActivationDateComment'] = "A Campanha iniciará ao início deste dia";
$GLOBALS['strImpressionsRemaining'] = "Impressões restantes";
$GLOBALS['strClicksRemaining'] = "Cliques restantes";
$GLOBALS['strConversionsRemaining'] = "Conversões restantes";
$GLOBALS['strImpressionsBooked'] = "Impressões contratadas";
$GLOBALS['strClicksBooked'] = "Cliques contratados";
$GLOBALS['strConversionsBooked'] = "Conversões contratadas";
$GLOBALS['strCampaignWeight'] = "Definir o peso da campanha";
$GLOBALS['strAnonymous'] = "Esconder o anunciante e o site desta campanha";
$GLOBALS['strTargetPerDay'] = "por dia.";
$GLOBALS['strCampaignStatusPending'] = "Pendente";
$GLOBALS['strCampaignStatusInactive'] = "ativo";
$GLOBALS['strCampaignStatusRunning'] = "Executando";
$GLOBALS['strCampaignStatusPaused'] = "Pausado";
$GLOBALS['strCampaignStatusAwaiting'] = "Aguardando";
$GLOBALS['strCampaignStatusExpired'] = "Finalizado";
$GLOBALS['strCampaignStatusApproval'] = "Aguardando aprovação »";
$GLOBALS['strCampaignStatusRejected'] = "Rejeitado";
$GLOBALS['strCampaignStatusAdded'] = "Adicionado";
$GLOBALS['strCampaignStatusStarted'] = "Inicializado";
$GLOBALS['strCampaignStatusRestarted'] = "Re-iniciado";
$GLOBALS['strCampaignStatusDeleted'] = "Remover";
$GLOBALS['strCampaignType'] = "Nome da campanha";
$GLOBALS['strType'] = "Tipo";
$GLOBALS['strContract'] = "Contato";
$GLOBALS['strStandardContract'] = "Contato";
$GLOBALS['strBackToCampaigns'] = "Voltar às campanhas";
$GLOBALS['strCampaignBanners'] = "Banners da campanha";

// Tracker
$GLOBALS['strTracker'] = "Rastreador";
$GLOBALS['strTrackers'] = "Rastreadores";
$GLOBALS['strTrackerPreferences'] = "Preferências do Rastreador";
$GLOBALS['strAddTracker'] = "Adicionar no rastreador";
$GLOBALS['strTrackerForAdvertiser'] = "Campanha para anunciante";
$GLOBALS['strNoTrackers'] = "Nenhum rastreador definido";
$GLOBALS['strConfirmDeleteTrackers'] = "Deseja realmente remover este rastreador?";
$GLOBALS['strConfirmDeleteTracker'] = "Deseja realmente remover este rastreador?";
$GLOBALS['strTrackerProperties'] = "Dados do rastreador";
$GLOBALS['strDefaultStatus'] = "Estado padrão";
$GLOBALS['strStatus'] = "Estado";
$GLOBALS['strLinkedTrackers'] = "Rastreadores vinculados";
$GLOBALS['strConversionWindow'] = "Janela de conversão";
$GLOBALS['strUniqueWindow'] = "Janela única";
$GLOBALS['strClick'] = "Clique";
$GLOBALS['strView'] = "Visualizar";
$GLOBALS['strConversionType'] = "Tipo de conversão";
$GLOBALS['strLinkCampaignsByDefault'] = "vincular campanhas novas por padrão";
$GLOBALS['strBackToTrackers'] = "Voltar para rastreadores";
$GLOBALS['strIPAddress'] = "Endereço IP";

// Banners (General)
$GLOBALS['strBanner'] = "Anúncio";
$GLOBALS['strBanners'] = "Anúncios";
$GLOBALS['strAddBanner'] = "Adicionar novo banner";
$GLOBALS['strAddBanner_Key'] = "Adicionar <u>n</u>ovo banner";
$GLOBALS['strBannerToCampaign'] = "Sua campanha";
$GLOBALS['strShowBanner'] = "Mostrar banners";
$GLOBALS['strBannerProperties'] = "Informações do banner";
$GLOBALS['strBannerHistory'] = "Histórico do banner";
$GLOBALS['strNoBanners'] = "Nenhum banner definido";
$GLOBALS['strNoBannersAddCampaign'] = "Atualmente nenhum website esta definido. Para criar uma zona, <a href='affiliate-edit.php'>adicione um website</a> primeiro.";
$GLOBALS['strNoBannersAddAdvertiser'] = "Atualmente nenhum website esta definido. Para criar uma zona, <a href='affiliate-edit.php'>adicione um website</a> primeiro.";
$GLOBALS['strConfirmDeleteBanner'] = "Deseja realmente remover este banner?";
$GLOBALS['strConfirmDeleteBanners'] = "Deseja realmente remover este banner?";
$GLOBALS['strShowParentCampaigns'] = "Mostrar campanhas superiores";
$GLOBALS['strHideParentCampaigns'] = "Ocultar campanhas superiores";
$GLOBALS['strHideInactiveBanners'] = "Ocultar banners inativos";
$GLOBALS['strInactiveBannersHidden'] = "banner(s) inativo(s) ocultado(s)";
$GLOBALS['strWarningMissing'] = "Atenção, possivelmente falta uma";
$GLOBALS['strWarningMissingClosing'] = "tag de fechamento '>'";
$GLOBALS['strWarningMissingOpening'] = "tag de abertura '<'";
$GLOBALS['strSubmitAnyway'] = "Enviar de qualquer forma";
$GLOBALS['strBannersOfCampaign'] = "em"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "Preferências dos Anúncios";
$GLOBALS['strCampaignPreferences'] = "Preferências de campanha";
$GLOBALS['strDefaultBanners'] = "Banners padrão";
$GLOBALS['strDefaultBannerUrl'] = "URL padrão de imagens";
$GLOBALS['strDefaultBannerDestination'] = "URL padrão de destino";
$GLOBALS['strAllowedBannerTypes'] = "Tipos de banner permitidos";
$GLOBALS['strTypeSqlAllow'] = "Permitir banners locais em SQL";
$GLOBALS['strTypeWebAllow'] = "Permitir banners locais em disco";
$GLOBALS['strTypeUrlAllow'] = "Permitir banners externos";
$GLOBALS['strTypeHtmlAllow'] = "Permitir banners em HTML";
$GLOBALS['strTypeTxtAllow'] = "Permitir Anúncios de texto";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Por favor escolha o tipo de banner";
$GLOBALS['strMySQLBanner'] = "Banner Local (SQL)";
$GLOBALS['strWebBanner'] = "Banner Local (Servidor)";
$GLOBALS['strURLBanner'] = "Banner externo";
$GLOBALS['strHTMLBanner'] = "Banner HTML";
$GLOBALS['strTextBanner'] = "Anúncio de texto";
$GLOBALS['strUploadOrKeep'] = "Deseja manter sua <br />imagem atual ou fazer<br />upload de uma nova?";
$GLOBALS['strNewBannerFile'] = "Selecione a imagem que deseja <br />usar para este banner<br /><br />";
$GLOBALS['strNewBannerFileAlt'] = "Selecione a imagem de backup que deseja <br />usar caso o navegador<br />não aceite rich media<br /><br />";
$GLOBALS['strNewBannerURL'] = "URL da Imagem (incl. http://)";
$GLOBALS['strURL'] = "URL de destino (incl. http://)";
$GLOBALS['strKeyword'] = "Palavras-chave";
$GLOBALS['strTextBelow'] = "Texto abaixo  da imagem";
$GLOBALS['strWeight'] = "Peso";
$GLOBALS['strAlt'] = "Texto alternativo";
$GLOBALS['strStatusText'] = "Texto de status";
$GLOBALS['strBannerWeight'] = "Peso do banner";
$GLOBALS['strAdserverTypeGeneric'] = "Banner HTML genérico";
$GLOBALS['strGenericOutputAdServer'] = "Genérico";
$GLOBALS['strSwfTransparency'] = "Permitir fundo transparente";

// Banner (advanced)

// Banner (swf)
$GLOBALS['strCheckSWF'] = "Verificar por link codificados dentro do arquivo Flash";
$GLOBALS['strConvertSWFLinks'] = "Converter links do Flash";
$GLOBALS['strHardcodedLinks'] = "Links codificados no Flash";
$GLOBALS['strCompressSWF'] = "Comprimir arquivo SWF para download mais rápido(Flash Player 6 necessário)";
$GLOBALS['strOverwriteSource'] = "Sobrescrever parâmetro original";

// Display limitations
$GLOBALS['strModifyBannerAcl'] = "Opções de entrega";
$GLOBALS['strACL'] = "Entrega";
$GLOBALS['strACLAdd'] = "Adicionar limitação";
$GLOBALS['strNoLimitations'] = "Sem limites";
$GLOBALS['strApplyLimitationsTo'] = "Aplicar limites a";
$GLOBALS['strRemoveAllLimitations'] = "Remover todos limites";
$GLOBALS['strEqualTo'] = "é igual a";
$GLOBALS['strDifferentFrom'] = "é diferente de";
$GLOBALS['strGreaterThan'] = "maior que";
$GLOBALS['strLessThan'] = "menor que";
$GLOBALS['strAND'] = "E";                          // logical operator
$GLOBALS['strOR'] = "OU";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Somente mostrar este banner quando:";
$GLOBALS['strWeekDays'] = "Dias da semana";
$GLOBALS['strSource'] = "Fonte";
$GLOBALS['strDeliveryLimitations'] = "Limitações de entrega";

$GLOBALS['strDeliveryCappingReset'] = "Resetar contadores de visualização após:";
$GLOBALS['strDeliveryCappingTotal'] = "no total";
$GLOBALS['strDeliveryCappingSession'] = "por sessão";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['limit'] = "Limitar visualização de banners a:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['limit'] = "Limitar visualizações da campanha a:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['limit'] = "Limitar visualizações de zonas a:";

// Website
$GLOBALS['strAffiliate'] = "Site";
$GLOBALS['strAffiliates'] = "Sites";
$GLOBALS['strAffiliatesAndZones'] = "Sites e Zonas";
$GLOBALS['strAddNewAffiliate'] = "Adicionar novo site";
$GLOBALS['strAffiliateProperties'] = "Informações do site";
$GLOBALS['strAffiliateHistory'] = "Histórico do site";
$GLOBALS['strNoAffiliates'] = "Atualmente nenhum website esta definido. Para criar uma zona, <a href='affiliate-edit.php'>adicione um website</a> primeiro.";
$GLOBALS['strConfirmDeleteAffiliate'] = "Deseja realmente remover este site?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Deseja realmente remover este site?";
$GLOBALS['strInactiveAffiliatesHidden'] = "site(s) inativo(s) ocultado(s)";
$GLOBALS['strShowParentAffiliates'] = "Mostrar sites superiores";
$GLOBALS['strHideParentAffiliates'] = "Ocultar sites superiores";

// Website (properties)
$GLOBALS['strWebsite'] = "Site";
$GLOBALS['strWebsiteURL'] = "URL do website";
$GLOBALS['strAllowAffiliateModifyZones'] = "Permitir que este usuário modifique suas zonas";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Permitir que este usuário ligue banners às suas zonas";
$GLOBALS['strAllowAffiliateAddZone'] = "Permitir que este usuário defina novas zonas";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Permitir que este usuário remova zonas existentes";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Permitir que este usuário gere o código de inserção";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "Código Postal (CEP)";
$GLOBALS['strCountry'] = "País";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Sites e Zonas";

// Zone
$GLOBALS['strZone'] = "Zona";
$GLOBALS['strZones'] = "Zonas";
$GLOBALS['strAddNewZone'] = "Adicionar nova zona";
$GLOBALS['strAddNewZone_Key'] = "Adicionar <u>n</u>ova zona";
$GLOBALS['strZoneToWebsite'] = "Nenhum site";
$GLOBALS['strLinkedZones'] = "Zonas vinculadas";
$GLOBALS['strZoneProperties'] = "Informações da Zona";
$GLOBALS['strZoneHistory'] = "Histórico da Zona";
$GLOBALS['strNoZones'] = "Nenhuma zona definida";
$GLOBALS['strNoZonesAddWebsite'] = "Atualmente nenhum website esta definido. Para criar uma zona, <a href='affiliate-edit.php'>adicione um website</a> primeiro.";
$GLOBALS['strConfirmDeleteZone'] = "Deseja realmente remover esta zona?";
$GLOBALS['strConfirmDeleteZones'] = "Deseja realmente remover esta zona?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "Ainda existem campanhas ligadas a esta zona, caso você a remova estas campanhas não serão executadas e você não será pago por elas";
$GLOBALS['strZoneType'] = "Tipo de zona";
$GLOBALS['strBannerButtonRectangle'] = "Banner, Botão ou retângulo";
$GLOBALS['strInterstitial'] = "Intersticial ou DHTML Flutuante";
$GLOBALS['strTextAdZone'] = "Anúncio de texto";
$GLOBALS['strEmailAdZone'] = "Zona de E-mail/Newsletter";
$GLOBALS['strShowMatchingBanners'] = "Mostrar banners compatíveis";
$GLOBALS['strHideMatchingBanners'] = "Ocultar banners compatíveis";
$GLOBALS['strBannerLinkedAds'] = "Banners vinculados a esta zona";
$GLOBALS['strCampaignLinkedAds'] = "Campanhas vinculadas a esta zona";
$GLOBALS['strInactiveZonesHidden'] = "zona(s) inativa(s) oculta(s)";
$GLOBALS['strWarnChangeZoneType'] = "Alterar o tipo de zona para texto ou e-mail irá remover vinculo com todos banners/campanhas devido a restrições destes tipos de zonas
                                                <ul>
                                                    <li>Zonas de texto podem te apenas anúncios de texto</li>
                                                    <li>Zonas de E-mail podem ter apenas um banner ativo por vez</li>
                                                </ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Alterar o tamanho da zona irá remover vínculos de banners incompatíveis com o novo tamanho, e irá adicionar qualquer banner de campanhas vinculadas que seja compatível';
$GLOBALS['strWarnChangeBannerSize'] = 'Alterar o tamanho do banner irá remover seu vínculo de qualquer zona que não for compatível com o novo tamanho, se a <strong>campanha</strong> deste banner estiver ligada a uma zona do novo tamanho, o banner será automaticamente vinculado.';
$GLOBALS['strZonesOfWebsite'] = 'em'; //this is added between page name and website name eg. 'Zones in www.example.com'

$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "IAB Rectangle (180 x 150) *";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "IAB Medium Rectangle (300 x 250) *";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "IAB Wide Skyscraper (160 x 600) *";

// Advanced zone settings
$GLOBALS['strAdvanced'] = "Avançado";
$GLOBALS['strChainSettings'] = "Configurações de corrente";
$GLOBALS['strZoneNoDelivery'] = "Se nenhum banner desta zona puder ser mostrado, tente...";
$GLOBALS['strZoneStopDelivery'] = "Parar entrega e não mostrar nenhum banner";
$GLOBALS['strZoneOtherZone'] = "Mostrar a seguinte zona";
$GLOBALS['strZoneAppend'] = "Sempre inserir este código HTML após anúncios de texto apresentados por esta zona";
$GLOBALS['strAppendSettings'] = "Configurações de Anexos e prefixos";
$GLOBALS['strZonePrependHTML'] = "Sempre inserir este código HTML antes de anúncios de texto apresentados por esta zona";
$GLOBALS['strZoneAppendNoBanner'] = "Anexar mesmo que nenhum banner seja apresentado";
$GLOBALS['strZoneAppendHTMLCode'] = "Código HTML";
$GLOBALS['strZoneAppendZoneSelection'] = "Popup ou Intersticial";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "Todos banners ligados a esta zona estão inativos <br />Essa é a corrente que será seguida:";
$GLOBALS['strZoneProbNullPri'] = "Nenhum banner ativo vinculado a esta zona.";
$GLOBALS['strZoneProbListChainLoop'] = "Seguir esta corrente causará uma referência circular. Entrega para esta zona foi interrompida.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Por favor escolha o que vincular com esta zona";
$GLOBALS['strLinkedBanners'] = "vincular banners individuais";
$GLOBALS['strCampaignDefaults'] = "vincular banners pelas campanhas a que pertencem";
$GLOBALS['strLinkedCategories'] = "Vincular banners por categoria";
$GLOBALS['strRawQueryString'] = "Palavra-chave";
$GLOBALS['strIncludedBanners'] = "Banners vinculados";
$GLOBALS['strMatchingBanners'] = "{count} banners compatíveis";
$GLOBALS['strNoCampaignsToLink'] = "Nenhuma campanha compatível com esta zona esta disponível";
$GLOBALS['strNoTrackersToLink'] = "Nenhum rastreador compatível com esta campanha esta disponível";
$GLOBALS['strNoZonesToLinkToCampaign'] = "Nenhuma zona compatível com esta campanha esta disponível";
$GLOBALS['strSelectBannerToLink'] = "Selecione o banner que deseja vincular a esta zona:";
$GLOBALS['strSelectCampaignToLink'] = "Selecione a campanha que deseja vincular a esta zona:";
$GLOBALS['strSelectAdvertiser'] = "Selecionar anunciante";
$GLOBALS['strSelectPlacement'] = "Selecionar campanha";
$GLOBALS['strSelectAd'] = "Selecionar banner";
$GLOBALS['strSelectPublisher'] = "Escolher o site";
$GLOBALS['strSelectZone'] = "Escolher zona";
$GLOBALS['strConnectionType'] = "Tipo";
$GLOBALS['strStatusPending'] = "Pendente";
$GLOBALS['strStatusDuplicate'] = "Duplicar";
$GLOBALS['strConnectionType'] = "Tipo";
$GLOBALS['strShortcutEditStatuses'] = "Editar estados";
$GLOBALS['strShortcutShowStatuses'] = "Mostrar estados";

// Statistics
$GLOBALS['strStats'] = "Estatísticas";
$GLOBALS['strNoStats'] = "Nenhum dado estatístico disponível";
$GLOBALS['strNoStatsForPeriod'] = "Nenhum dado estatístico disponível para o período de %s a %s";
$GLOBALS['strGlobalHistory'] = "Histórico Global";
$GLOBALS['strDailyHistory'] = "Histórico diário";
$GLOBALS['strDailyStats'] = "Estatísticas diárias";
$GLOBALS['strWeeklyHistory'] = "Histórico semanal";
$GLOBALS['strMonthlyHistory'] = "Histórico mensal";
$GLOBALS['strTotalThisPeriod'] = "Total para este período";
$GLOBALS['strPublisherDistribution'] = "Distribuição por site";
$GLOBALS['strCampaignDistribution'] = "Distribuição por campanha";
$GLOBALS['strViewBreakdown'] = "Visualizar por";
$GLOBALS['strBreakdownByDay'] = "Dia";
$GLOBALS['strBreakdownByWeek'] = "Semana";
$GLOBALS['strBreakdownByMonth'] = "Mês";
$GLOBALS['strBreakdownByDow'] = "Dia da semana";
$GLOBALS['strBreakdownByHour'] = "Hora";
$GLOBALS['strItemsPerPage'] = "Itens por página";
$GLOBALS['strShowGraphOfStatistics'] = "Mostrar <u>G</u>ráfico de estatísticas";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>xportar estatísticas para o Excel";
$GLOBALS['strGDnotEnabled'] = "Você precisa ter a biblioteca GD para PHP habilitada para exibir gráficos. <br />Por favor veja <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> para maiores informações, inclusive como instalar GD em seu servidor.";
$GLOBALS['strStatsArea'] = "�?rea";

// Expiration
$GLOBALS['strNoExpiration'] = "Sem data de vencimento";
$GLOBALS['strEstimated'] = "Vencimento estimado";
$GLOBALS['strNoExpirationEstimation'] = "Sem prazo estimado de vencimento ainda";
$GLOBALS['strDaysAgo'] = "dias atás";
$GLOBALS['strCampaignStop'] = "Fim da Campanha";

// Reports
$GLOBALS['strPeriod'] = "Período";
$GLOBALS['strLimitations'] = "Limites";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "Todos anunciantes";
$GLOBALS['strAnonAdvertisers'] = "Anunciantes anônimos";
$GLOBALS['strAllPublishers'] = "Todos sites";
$GLOBALS['strAnonPublishers'] = "Sites anônimos";
$GLOBALS['strAllAvailZones'] = "Todas zonas disponíveis";

// Userlog
$GLOBALS['strUserLog'] = "Log de usuários";
$GLOBALS['strUserLogDetails'] = "Detalhes do log de usuários";
$GLOBALS['strDeleteLog'] = "Remover log";
$GLOBALS['strAction'] = "Ação";
$GLOBALS['strNoActionsLogged'] = "Nenhuma ação registrada";

// Code generation
$GLOBALS['strGenerateBannercode'] = "Seleção direta";
$GLOBALS['strChooseInvocationType'] = "Por favor escolha o tipo de inserção de banner";
$GLOBALS['strGenerate'] = "Gerar";
$GLOBALS['strParameters'] = "Parâmetros das tags";
$GLOBALS['strFrameSize'] = "Tamanho da moldura";
$GLOBALS['strBannercode'] = "Código do banner";
$GLOBALS['strTrackercode'] = "Código do rastreador";
$GLOBALS['strBackToTheList'] = "Voltar para lista de relatórios";
$GLOBALS['strCharset'] = "Conjunto de caracteres";
$GLOBALS['strAutoDetect'] = "Auto-detectar";


// Errors
$GLOBALS['strErrorDatabaseConnetion'] = "Erro de conexão ao banco de dados.";
$GLOBALS['strErrorCantConnectToDatabase'] = "Um erro fatal ocorreu o %s não pode conectar à base de dados. Por este motivo é impossível utilizar a interface de administração. A entrega de banners pode ter sido afetada. Possíveis causas deste problema podem ser: <ul> <li>O servidor de banco de dados não esta funcionando no momento</li> <li>A base de dados foi amovida para outra localidade</li> <li>O nome de usuário ou senha utilizados para acessar a base não estão corretos</li> <li>O PHP não carregou a extensão de MySQL</li> </ul>";
$GLOBALS['strNoMatchesFound'] = "Nenhum resultado encontrado";
$GLOBALS['strErrorOccurred'] = "Um erro ocorreu";
$GLOBALS['strErrorDBPlain'] = "Um erro ocorreu ao acessar a base de dados";
$GLOBALS['strErrorDBSerious'] = "Um grave problema foi detectado com a base de dados";
$GLOBALS['strErrorDBCorrupt'] = "A tabela da base de dados pode estar corrompida e necessita de reparos. Para mais informações sobre tabelas corrompidas leia o capitulo <i>Troubleshooting</i> do <i>Guia do Administrador</i>.";
$GLOBALS['strErrorDBContact'] = "Por favor notifique o administrador deste sistema sobre este problema.";
$GLOBALS['strErrorLinkingBanner'] = "Não foi possível vincular este banner a esta zona pois:";
$GLOBALS['strUnableToLinkBanner'] = "Impossível vincular este banner:";
$GLOBALS['strErrorEditingCampaignRevenue'] = "formatação incorreta de números no campo de Receita";
$GLOBALS['strErrorEditingZone'] = "Erro ao atualizar a zona:";
$GLOBALS['strUnableToChangeZone'] = "Impossível aplicar esta alteração pois:";
$GLOBALS['strDatesConflict'] = "datas conflitam com:";
$GLOBALS['strWarningInaccurateStats'] = "Algumas destas estatísticas foram logadas em um fuso horário não-UTC, e podem não ser apresentadas no fuso correto";
$GLOBALS['strWarningInaccurateReadMore'] = "Leia mais sobre isso";
$GLOBALS['strWarningInaccurateReport'] = "Algumas destas estatísticas neste relatório foram logadas em um fuso horário não-UTC, e podem não ser apresentadas no fuso correto";

//Validation

// Email
$GLOBALS['strSirMadam'] = "Sr./Sra.";
$GLOBALS['strMailSubject'] = "Relatório de Anunciante";
$GLOBALS['strMailBannerStats'] = "Abaixo poderá ver as estatísticas de banners para {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Campanha ativada";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Campanha desativada";
$GLOBALS['strMailBannerDeactivated'] = "A sua campanha demonstrada abaixo foi desativada porque";
$GLOBALS['strClientDeactivated'] = "Esta campanha não esta ativa porque";
$GLOBALS['strBeforeActivate'] = "a data de ativação ainda não foi alcançada";
$GLOBALS['strAfterExpire'] = "a data de vencimento foi alcançada";
$GLOBALS['strNoMoreImpressions'] = "não há mais Impressões restantes";
$GLOBALS['strNoMoreClicks'] = "não há mais Cliques restantes";
$GLOBALS['strNoMoreConversions'] = "não há mais Vendas restantes";
$GLOBALS['strWeightIsNull'] = "seu peso esta definido para zero";
$GLOBALS['strTargetIsNull'] = "seu objetivo está definido como zero";
$GLOBALS['strNoViewLoggedInInterval'] = "Nenhum Impressão foi registrada durante o período deste relatório";
$GLOBALS['strNoClickLoggedInInterval'] = "Nenhum Clique foi registrada durante o período deste relatório";
$GLOBALS['strNoConversionLoggedInInterval'] = "Nenhum Conversão foi registrada durante o período deste relatório";
$GLOBALS['strMailReportPeriod'] = "Este relatório inclui estatísticas de {startdate} até {enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "Este relatório possui todas estatísticas até {enddate}.";
$GLOBALS['strNoStatsForCampaign'] = "Nenhum dado estatístico disponível para esta campanha";
$GLOBALS['strImpendingCampaignExpiry'] = "Vencimento de campanha iminente";
$GLOBALS['strYourCampaign'] = "Sua campanha";
$GLOBALS['strTheCampiaignBelongingTo'] = "A campanha pertencente a";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} apresentada abaixo vencerá dia {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} apresenta abaixo tem menos de {limit} impressões restantes.";

// Priority
$GLOBALS['strPriority'] = "Prioridade";
$GLOBALS['strSourceEdit'] = "Editar fontes";

// Preferences
$GLOBALS['strPreferences'] = "Preferências";
$GLOBALS['strUserPreferences'] = "Preferências do Usuário";
$GLOBALS['strChangePassword'] = "Trocar senha";
$GLOBALS['strChangeEmail'] = "Trocar e-mail";
$GLOBALS['strCurrentPassword'] = "Senha Atual";
$GLOBALS['strChooseNewPassword'] = "Escolha uma nova senha";
$GLOBALS['strReenterNewPassword'] = "Re-digite a nova senha";
$GLOBALS['strNameLanguage'] = "Nome e Idioma";
$GLOBALS['strAccountPreferences'] = "Preferências da conta";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Preferências de E-mails com relatórios de campanhas";
$GLOBALS['strAdminEmailWarnings'] = "Alertas de e-mail do Administrador";
$GLOBALS['strAgencyEmailWarnings'] = "Alertas de e-mail de Agências";
$GLOBALS['strAdveEmailWarnings'] = "Alertas de e-mail de Anunciantes";
$GLOBALS['strFullName'] = "Nome completo";
$GLOBALS['strEmailAddress'] = "Endereço de e-mail";
$GLOBALS['strUserDetails'] = "Detalhes do usuário";
$GLOBALS['strUserInterfacePreferences'] = "Preferências da Interface de usuários";
$GLOBALS['strPluginPreferences'] = "Preferências gerais";
$GLOBALS['strColumnName'] = "Nome da coluna";
$GLOBALS['strShowColumn'] = "Mostrar Coluna";
$GLOBALS['strCustomColumnName'] = "Nome de coluna personalizado";
$GLOBALS['strColumnRank'] = "Ranking da coluna";

// Long names
$GLOBALS['strRevenue'] = "Receita";
$GLOBALS['strNumberOfItems'] = "Número de itens";
$GLOBALS['strRevenueCPC'] = "Receita de CPC";
$GLOBALS['strECPM'] = "ECPM";
$GLOBALS['strPendingConversions'] = "Conversões pendentes";
$GLOBALS['strImpressionSR'] = "Impressão SR";
$GLOBALS['strClickSR'] = "Cliques SR";

// Short names
$GLOBALS['strRevenue_short'] = "Rec.";
$GLOBALS['strBasketValue_short'] = "VM";
$GLOBALS['strNumberOfItems_short'] = "Num. itm.";
$GLOBALS['strRevenueCPC_short'] = "Rec. CPC";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strClicks_short'] = "Cliques";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strPendingConversions_short'] = "Conv. pendentes";
$GLOBALS['strClickSR_short'] = "Cliques SR";

// Global Settings
$GLOBALS['strGlobalSettings'] = "Configurações global";
$GLOBALS['strGeneralSettings'] = "Configurações gerais";
$GLOBALS['strMainSettings'] = "Principais configurações";
$GLOBALS['strChooseSection'] = 'Escolher seção';

// Product Updates
$GLOBALS['strProductUpdates'] = "Atualizações do produto";
$GLOBALS['strViewPastUpdates'] = "Gerenciar Atualizações anteriores e backups";
$GLOBALS['strFromVersion'] = "Da versão";
$GLOBALS['strToVersion'] = "Para versão";
$GLOBALS['strToggleDataBackupDetails'] = "Ligar/Desligar detalhes de backup de dados";
$GLOBALS['strClickViewBackupDetails'] = "clique aqui para mostrar detalhes de backup";
$GLOBALS['strClickHideBackupDetails'] = "clique aqui para esconder detalhes de bakup";
$GLOBALS['strShowBackupDetails'] = "Mostrar detalhes de bakup";
$GLOBALS['strHideBackupDetails'] = "Esconder detalhes de backup";
$GLOBALS['strBackupDeleteConfirm'] = "Deseja realmente remover todos backups criados por este upgrade?";
$GLOBALS['strDeleteArtifacts'] = "Remover artefatos";
$GLOBALS['strArtifacts'] = "Artefatos";
$GLOBALS['strBackupDbTables'] = "Fazer backup das tabelas da Base de dados";
$GLOBALS['strLogFiles'] = "Registrar arquivos";
$GLOBALS['strConfigBackups'] = "Backup de configurações";
$GLOBALS['strUpdatedDbVersionStamp'] = "Marca de versão da base de dados atualizada";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "ATUALIZAÇÃO CONCLU�?DA";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "FALHA NA ATUALIZAÇÃO";

// Agency
$GLOBALS['strAgencyManagement'] = "Gerenciamento de contas";
$GLOBALS['strAgency'] = "Conta";
$GLOBALS['strAddAgency'] = "Adicionar nova conta";
$GLOBALS['strAddAgency_Key'] = "Adicionar <u>n</u>ova conta";
$GLOBALS['strTotalAgencies'] = "Total de contas";
$GLOBALS['strAgencyProperties'] = "Propriedades da conta";
$GLOBALS['strNoAgencies'] = "Atualmente nenhuma conta esta definida";
$GLOBALS['strConfirmDeleteAgency'] = "Deseja realmente remover esta conta?";
$GLOBALS['strHideInactiveAgencies'] = "Escolher contas inativas";
$GLOBALS['strInactiveAgenciesHidden'] = "conta(s) inativa(s) oculta(s)";
$GLOBALS['strSwitchAccount'] = "Trocar para esta conta";

// Channels
$GLOBALS['strChannel'] = "Canal de direcionamento";
$GLOBALS['strChannels'] = "Canais de direcionamento";
$GLOBALS['strChannelManagement'] = "Gerenciamento de Canais de direcionamento";
$GLOBALS['strAddNewChannel'] = "Adicionar novo canal de direcionamento";
$GLOBALS['strAddNewChannel_Key'] = "Adicionar <u>n</u>ovo canal de direcionamento";
$GLOBALS['strChannelToWebsite'] = "Nenhum site";
$GLOBALS['strNoChannels'] = "Nenhum canal de direcionamento definido";
$GLOBALS['strNoChannelsAddWebsite'] = "Atualmente nenhum website esta definido. Para criar uma zona, <a href='affiliate-edit.php'>adicione um website</a> primeiro.";
$GLOBALS['strEditChannelLimitations'] = "Editar limitações do canal de direcionamento";
$GLOBALS['strChannelProperties'] = "Propriedades do canal de direcionamento";
$GLOBALS['strChannelLimitations'] = "Opções de entrega";
$GLOBALS['strConfirmDeleteChannel'] = "Deseja realmente remover este canal de direcionamento?";
$GLOBALS['strConfirmDeleteChannels'] = "Deseja realmente remover este canal de direcionamento?";
$GLOBALS['strChannelsOfWebsite'] = 'em'; //this is added between page name and website name eg. 'Targeting channels in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "Nome da variável";
$GLOBALS['strVariableDescription'] = "Descrição";
$GLOBALS['strVariableDataType'] = "Tipo de dado";
$GLOBALS['strVariablePurpose'] = "Função/Objetivo";
$GLOBALS['strGeneric'] = "Genérico";
$GLOBALS['strBasketValue'] = "Valor da cesta";
$GLOBALS['strNumItems'] = "Número de itens";
$GLOBALS['strVariableIsUnique'] = "Deduzir conversões?";
$GLOBALS['strNumber'] = "Número";
$GLOBALS['strString'] = "Texto";
$GLOBALS['strTrackFollowingVars'] = "Rastrear a seguinte variável";
$GLOBALS['strAddVariable'] = "Adicionar variável";
$GLOBALS['strNoVarsToTrack'] = "Nenhuma variável para rastrear.";
$GLOBALS['strVariableRejectEmpty'] = "Rejeitar se estiver vazio?";
$GLOBALS['strTrackingSettings'] = "Configurações de rastreamento";
$GLOBALS['strTrackerType'] = "Tipo de rastreador";
$GLOBALS['strTrackerTypeJS'] = "Rastrear variáveis de JavaScript";
$GLOBALS['strTrackerTypeDefault'] = "Rastrear variáveis de JavaScript (compatibilidade retroativa, é necessário usar 'escape')";
$GLOBALS['strTrackerTypeDOM'] = "Rastrear elementos HTML usando DOM";
$GLOBALS['strTrackerTypeCustom'] = "Código Javascript personalizado";
$GLOBALS['strVariableCode'] = "Código de rastreamento em Javascript";

// Password recovery
$GLOBALS['strForgotPassword'] = "Esqueceu sua senha?";
$GLOBALS['strPasswordRecovery'] = "Recuperação de senha";
$GLOBALS['strEmailRequired'] = "E-mail é um campo obrigatório";
$GLOBALS['strPwdRecEmailNotFound'] = "E-mail não encontrado";
$GLOBALS['strPwdRecWrongId'] = "ID incorreto";
$GLOBALS['strPwdRecEnterEmail'] = "Digite seu e-mail abaixo";
$GLOBALS['strPwdRecEnterPassword'] = "Digite sua nova senha abaixo";
$GLOBALS['strPwdRecResetLink'] = "Link para resetar a senha";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "%s recuperação de senha";
$GLOBALS['strProceed'] = "Prosseguir >";
$GLOBALS['strNotifyPageMessage'] = "Um e-mail foi enviado para o endereço informado, nele esta incluso um link que irá permitir a re-configuração de sua senha.<br />Permita alguns minutos para o e-mail chegar.<br />Caso não receba o e-mail, verifique a pasta de spam.<br /><a href='index.php'>Voltar para página de login.</a>";

// Audit
$GLOBALS['strAdditionalItems'] = "e itens adicionais";
$GLOBALS['strFor'] = "para";
$GLOBALS['strHas'] = "tem";
$GLOBALS['strBinaryData'] = "Dados binários";
$GLOBALS['strAuditTrailDisabled'] = "O Rastro de Auditoria foi desabilitado pelo administrador. Nenhum evento será logado e mostrado na lista da auditoria.";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "Nenhuma atividade dos usuários registrada do período escolhido.";
$GLOBALS['strAuditTrail'] = "Rastros de auditoria";
$GLOBALS['strAuditTrailSetup'] = "Configurar o Rastreamento de Auditoria hoje";
$GLOBALS['strAuditTrailGoTo'] = "Ir para log de Auditoria";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Ir para página de campanhas";
$GLOBALS['strCampaignSetUp'] = "Configurar uma campanha hoje";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>Não há atividade de campanha para apresentar.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "Nenhuma campanha começou ou terminou no prazo escolhido";
$GLOBALS['strCampaignAuditTrailSetup'] = "Ativar rastro de auditoria para começar a visualizar campanhas";

$GLOBALS['strUnsavedChanges'] = "Você tem alterações não salvas nesta página, não esqueça de apertar \"Salvar Alterações\" quando terminar";
$GLOBALS['strDeliveryLimitationsDisagree'] = "ATENÇÃO: As limitações do núcleo de entrega <strong>NÃO BATEM</strong> com as limitações mostradas abaixo<br />Aperta salvar alterações para atualizar as regras do núcleo de entrega";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Os valores de algumas limitações estão incorretas";

//confirmation messages










// Report error messages

/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyNextItem'] = ",";
$GLOBALS['keyPreviousItem'] = ".";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
