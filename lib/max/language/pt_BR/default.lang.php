<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

// * Note - This file still contains some non-UTF-8 characters
// * however these don't seem to be in the translation memory (deprecated?)

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']  		= "ltr";
$GLOBALS['phpAds_TextAlignRight'] 		= "right";
$GLOBALS['phpAds_TextAlignLeft']  		= "left";

$GLOBALS['phpAds_DecimalPoint']			= ',';
$GLOBALS['phpAds_ThousandsSeperator']	= '.';

// Date & time configuration
$GLOBALS['date_format']				= "%m/%d/%Y";
$GLOBALS['time_format']				= "%H:%M:%S";
$GLOBALS['minute_format']			= "%H:%M";
$GLOBALS['month_format']			= "%m/%Y";
$GLOBALS['day_format']				= "%m/%d";
$GLOBALS['week_format']				= "%W/%Y";
$GLOBALS['weekiso_format']			= "%V/%G";

/*-------------------------------------------------------*/
/* Translations                                          */
/*-------------------------------------------------------*/

$GLOBALS['strHome'] 				= "Principal";
$GLOBALS['strHelp']					= "Ajuda";
$GLOBALS['strNavigation'] 			= "Navegação";
$GLOBALS['strShortcuts'] 			= "Atalhos";
$GLOBALS['strAdminstration'] 		= "Inventário";
$GLOBALS['strMaintenance']			= "Manutenção";
$GLOBALS['strProbability']			= "Probabilidade";
$GLOBALS['strInvocationcode']		= "Código de invocação";
$GLOBALS['strBasicInformation'] 	= "Informações básicas";
$GLOBALS['strContractInformation'] 	= "Informaï¿œï¿œo contractual";
$GLOBALS['strLoginInformation'] 	= "Informações de login";
$GLOBALS['strOverview']				= "Visão geral";
$GLOBALS['strSearch']				= "Bu<u>s</u>ca";
$GLOBALS['strHistory']				= "Historial";
$GLOBALS['strPreferences'] 			= "Preferências";
$GLOBALS['strDetails']				= "Detalhes";
$GLOBALS['strCompact']				= "Compactar";
$GLOBALS['strVerbose']				= "Completo";
$GLOBALS['strUser']					= "Usuário";
$GLOBALS['strEdit']					= "Editar";
$GLOBALS['strCreate']				= "Criar";
$GLOBALS['strDuplicate']			= "Duplicar";
$GLOBALS['strMoveTo']				= "Mover para";
$GLOBALS['strDelete'] 				= "Remover";
$GLOBALS['strActivate']				= "Ativar";
$GLOBALS['strDeActivate'] 			= "Desativar";
$GLOBALS['strConvert']				= "Converter";
$GLOBALS['strRefresh']				= "Recarregar";
$GLOBALS['strSaveChanges']		 	= "Salvar alterações";
$GLOBALS['strUp'] 					= "Para cima";
$GLOBALS['strDown'] 				= "Para baixo";
$GLOBALS['strSave'] 				= "Salvar";
$GLOBALS['strCancel']				= "Cancelar";
$GLOBALS['strPrevious'] 			= "Anterior";
$GLOBALS['strNext'] 				= "Próximo";
$GLOBALS['strYes']					= "Sim";
$GLOBALS['strNo']					= "Não";
$GLOBALS['strNone'] 				= "Nenhum";
$GLOBALS['strCustom']				= "Personalizado";
$GLOBALS['strDefault'] 				= "Padrão";
$GLOBALS['strOther']				= "Outro";
$GLOBALS['strUnknown']				= "Desconhecido";
$GLOBALS['strUnlimited'] 			= "Ilimitado";
$GLOBALS['strUntitled']				= "Sem título";
$GLOBALS['strAll'] 					= "todos";
$GLOBALS['strAvg'] 					= "Méd.";
$GLOBALS['strAverage']				= "Média";
$GLOBALS['strOverall'] 				= "Geral";
$GLOBALS['strTotal'] 				= "Total";
$GLOBALS['strActive'] 				= "ativo";
$GLOBALS['strFrom']					= "De";
$GLOBALS['strTo']					= "para";
$GLOBALS['strLinkedTo'] 			= "vinculado com";
$GLOBALS['strDaysLeft'] 			= "Dias restantes";
$GLOBALS['strCheckAllNone']			= "Selecionar todos/nenhum";
$GLOBALS['strKiloByte']				= "KB";
$GLOBALS['strExpandAll']			= "<u>E</u>xpandir todos";
$GLOBALS['strCollapseAll']			= "Fe<u>c</u>har todos";
$GLOBALS['strShowAll']				= "Mostrar todos";
$GLOBALS['strNoAdminInteface']		= "Serviï¿œo indisponï¿œvel...";
$GLOBALS['strFilterBySource']		= "filtrar pela fonte";
$GLOBALS['strFieldContainsErrors']		= "Estes campos contêm erros:";
$GLOBALS['strFieldFixBeforeContinue1']	= "Antes de continuar você precisa";
$GLOBALS['strFieldFixBeforeContinue2']	= "para corrigir estes erros.";
$GLOBALS['strDelimiter']				= "Delimitador";

// Properties
$GLOBALS['strName']					= "Nome";
$GLOBALS['strSize']					= "Tamanho";
$GLOBALS['strWidth'] 				= "Largura";
$GLOBALS['strHeight'] 				= "Altura";
$GLOBALS['strURL2']					= "URL";
$GLOBALS['strTarget']				= "Alvo (target)";
$GLOBALS['strLanguage'] 			= "Língua";
$GLOBALS['strDescription'] 			= "Descrição";
$GLOBALS['strID']					= "ID";

// Login & Permissions
$GLOBALS['strAuthentification'] 	= "Autenticação";
$GLOBALS['strWelcomeTo']			= "Bem vindo a";
$GLOBALS['strEnterUsername']		= "Entre com seu nome de usuário e senha para se logar";
$GLOBALS['strEnterBoth']			= "Por favor digite ambos seu nome de usuário e senha";
$GLOBALS['strEnableCookies']		= "Vocï¿œ tem de ter os <i>cookies</i> activos para usar ".$phpAds_productname;
$GLOBALS['strLogin'] 				= "Entrar";
$GLOBALS['strLogout'] 				= "Sair";
$GLOBALS['strUsername'] 			= "Nome de usuário";
$GLOBALS['strPassword']				= "Senha";
$GLOBALS['strAccessDenied']			= "Acesso negado";
$GLOBALS['strPasswordWrong']		= "A senha esta incorreta.";
$GLOBALS['strNotAdmin']				= "Você talvez não tenha privilégios o bastante,se você sabe os dados corretos pode fazer login abaixo novamente";
$GLOBALS['strDuplicateClientName']	= "O nome de usuário fornecido já existe, por favor escolha outro.";

// General advertising
$GLOBALS['strImpressions'] 				= "Impressões";
$GLOBALS['strClicks']				= "Cliques";
$GLOBALS['strCTRShort'] 			= "CTR";
$GLOBALS['strCTR'] 					= "Proporção de cliques (CTR)";
$GLOBALS['strTotalViews'] 			= "Total ".$GLOBALS['strImpressions'];
$GLOBALS['strTotalClicks'] 			= "Total ".$GLOBALS['strClicks'];
$GLOBALS['strViewCredits'] 			= "Créditos de ".$GLOBALS['strImpressions'];
$GLOBALS['strClickCredits'] 		= "Créditos de ".$GLOBALS['strClicks'];

// Time and date related
$GLOBALS['strDate'] 				= "Data";
$GLOBALS['strToday'] 				= "Hoje";
$GLOBALS['strDay']					= "Dia";
$GLOBALS['strDays']					= "Dias";
$GLOBALS['strLast7Days']			= "ï¿œltimos 7 dias";
$GLOBALS['strWeek'] 				= "Semana";
$GLOBALS['strWeeks']				= "Semanas";
$GLOBALS['strMonths']				= "Meses";
$GLOBALS['strThisMonth'] 			= "Este mï¿œs";
$GLOBALS['strMonth'][0] = "Janeiro";
$GLOBALS['strMonth'][1] = "Fevereiro";
$GLOBALS['strMonth'][2] = "Março";
$GLOBALS['strMonth'][3] = "Abril";
$GLOBALS['strMonth'][4] = "Maio";
$GLOBALS['strMonth'][5] = "Junho";
$GLOBALS['strMonth'][6] = "Julho";
$GLOBALS['strMonth'][7] = "Agosto";
$GLOBALS['strMonth'][8] = "Setembro";
$GLOBALS['strMonth'][9] = "Outubro";
$GLOBALS['strMonth'][10] = "Novembro";
$GLOBALS['strMonth'][11] = "Dezembro";

$GLOBALS['strDayShortCuts'][0] = "Dom";
$GLOBALS['strDayShortCuts'][1] = "Seg";
$GLOBALS['strDayShortCuts'][2] = "Ter";
$GLOBALS['strDayShortCuts'][3] = "Qua";
$GLOBALS['strDayShortCuts'][4] = "Qui";
$GLOBALS['strDayShortCuts'][5] = "Sex";
$GLOBALS['strDayShortCuts'][6] = "Sáb";

$GLOBALS['strHour']					= "Hora";
$GLOBALS['strSeconds']				= "segundos";
$GLOBALS['strMinutes']				= "minutos";
$GLOBALS['strHours']				= "horas";
$GLOBALS['strTimes']				= "tempos";

// Advertiser
$GLOBALS['strClient']				= "Anunciante";
$GLOBALS['strClients'] 				= "Anunciantes";
$GLOBALS['strClientsAndCampaigns']	= "Anunciantes e campanhas";
$GLOBALS['strAddClient'] 			= "Adicionar anunciante";
$GLOBALS['strTotalClients'] 		= "Total de anunciantes";
$GLOBALS['strClientProperties']		= "Dados do anunciante";
$GLOBALS['strClientHistory']		= "Histórico do anunciante";
$GLOBALS['strNoClients']			 		= "Nenhum anunciante definido";
$GLOBALS['strConfirmDeleteClient'] 			= "Deseja realmente remover este anunciante?";
$GLOBALS['strConfirmResetClientStats']		= "Quer mesmo remover as estatï¿œsticas deste anunciante?";
$GLOBALS['strHideInactiveAdvertisers']		= "Ocultar anunciantes inativos";
$GLOBALS['strInactiveAdvertisersHidden']	= "anunciante(s) inativo(s) ocultado(s)";

// Advertisers properties
$GLOBALS['strContact'] 						= "Contato";
$GLOBALS['strEMail'] 						= "E-mail";
$GLOBALS['strSendAdvertisingReport']		= "Relatório de entrega e e-mails de campanha";
$GLOBALS['strNoDaysBetweenReports']			= "Número de dias entre relatórios de entrega de campanha";
$GLOBALS['strSendDeactivationWarning']  	= "Enviar e-mail quando a campanha for automaticamente ativada/desativada";
$GLOBALS['strAllowClientModifyInfo'] 		= "Permitir que este usuário altere suas configurações";
$GLOBALS['strAllowClientModifyBanner'] 		= "Permitir que este usuário altere seus banners";
$GLOBALS['strAllowClientAddBanner'] 		= "Permitir que o utilizador adicione os seus anï¿œncios";
$GLOBALS['strAllowClientDisableBanner'] 	= "Permitir que este usuário desative seus próprios banners";
$GLOBALS['strAllowClientActivateBanner'] 	= "Permitir que este usuário ative seus próprios banners";

// Campaign
$GLOBALS['strCampaign']						= "Campanha";
$GLOBALS['strCampaigns']					= "Campanhas";
$GLOBALS['strTotalCampaigns'] 				= "Total de campanhas";
$GLOBALS['strActiveCampaigns'] 				= "Campanhas ativas";
$GLOBALS['strAddCampaign'] 					= "Adicionar uma nova campanha";
$GLOBALS['strCreateNewCampaign']			= "Criar campanha";
$GLOBALS['strModifyCampaign']				= "Modificar campanha";
$GLOBALS['strMoveToNewCampaign']			= "Mover para nova campanha";
$GLOBALS['strBannersWithoutCampaign']		= "Anï¿œncios sem campanha";
$GLOBALS['strDeleteAllCampaigns']			= "Remover todas campanhas";
$GLOBALS['strCampaignStats']				= "Estatï¿œsticas da campanha";
$GLOBALS['strCampaignProperties']			= "Dados da campanha";
$GLOBALS['strCampaignOverview']				= "Visão geral de Campanhas";
$GLOBALS['strCampaignHistory']				= "Histórico da campanha";
$GLOBALS['strNoCampaigns']					= "Nenhuma campanha ativa definida";
$GLOBALS['strConfirmDeleteAllCampaigns']	= "Deseja realmente remover todas campanhas deste anunciante?";
$GLOBALS['strConfirmDeleteCampaign']		= "Deseja realmente remover esta campanha?";
$GLOBALS['strHideInactiveCampaigns']		= "Esconder campanhas inativas";
$GLOBALS['strInactiveCampaignsHidden']		= "campanha(s) inativa(s) ocultada(s)";

// Campaign properties
$GLOBALS['strDontExpire']				= "Não desativar esta campanha em uma data específica";
$GLOBALS['strActivateNow'] 				= "Ativar campanha imediatamente";
$GLOBALS['strLow']						= "Baixa";
$GLOBALS['strHigh']						= "Alta";
$GLOBALS['strExpirationDate']			= "Data de vencimento";
$GLOBALS['strActivationDate']			= "Data de ativação";
$GLOBALS['strImpressionsPurchased'] 			= $GLOBALS['strImpressions']." restantes";
$GLOBALS['strClicksPurchased'] 			= $GLOBALS['strClicks']." restantes";
$GLOBALS['strCampaignWeight']			= "Nenhum - Definir o peso da campanha para";
$GLOBALS['strHighPriority']				= "Mostrar anï¿œncios desta campanha com alta prioridade.<br />Se usar esta opï¿œï¿œo ".$phpAds_productname." tentarï¿œ distribuir igualmente o nï¿œmero de ".$GLOBALS['strImpressions']." durante o decurso do dia.";
$GLOBALS['strLowPriority']				= "Mostrar anï¿œncios desta campanha com baixa prioridade.<br />Esta campanha serï¿œ usada para ocupar as sobras de ".$GLOBALS['strImpressions']." deixadas pelas campanha prioritï¿œrias.";
$GLOBALS['strTargetLimitAdviews']		= "Limitar o nï¿œmero de ".$GLOBALS['strImpressions']." a ";
$GLOBALS['strTargetPerDay']				= "por dia.";
$GLOBALS['strPriorityAutoTargeting']	= "Automático - Distribuir o restante do contratado homogeneamente pelos dias restantes.";

// Banners (General)
$GLOBALS['strBanner'] 					= "Banner";
$GLOBALS['strBanners'] 					= "Banners";
$GLOBALS['strAddBanner'] 				= "Adicionar novo banner";
$GLOBALS['strModifyBanner'] 			= "Modificar banner";
$GLOBALS['strActiveBanners'] 			= "Banners ativos";
$GLOBALS['strTotalBanners'] 			= "Total de banners";
$GLOBALS['strShowBanner']				= "Mostrar banners";
$GLOBALS['strShowAllBanners']	 		= "Mostrar todos os anï¿œncios";
$GLOBALS['strShowBannersNoAdClicks']	= "Mostrar anï¿œncios sem ".$GLOBALS['strClicks'];
$GLOBALS['strShowBannersNoAdViews']		= "Mostrar anï¿œncios sem ".$GLOBALS['strImpressions'];
$GLOBALS['strDeleteAllBanners']	 		= "Remover todos os banners";
$GLOBALS['strActivateAllBanners']		= "Ativar todos os banners";
$GLOBALS['strDeactivateAllBanners']		= "Desativar todos os banners";
$GLOBALS['strBannerOverview']			= "Visão geral dos banners";
$GLOBALS['strBannerProperties']			= "Informações do banner";
$GLOBALS['strBannerHistory']			= "Histórico do banner";
$GLOBALS['strBannerNoStats'] 			= "Nï¿œo existem estatï¿œsticas para ese anï¿œncio";
$GLOBALS['strNoBanners']				= "Nenhum banner definido";
$GLOBALS['strConfirmDeleteBanner']		= "Deseja realmente remover este banner?";
$GLOBALS['strConfirmDeleteAllBanners']	= "Deseja realmente remover todos banners desta campanha?";
$GLOBALS['strConfirmResetBannerStats']	= "Quer mesmo remover todas as estatï¿œsticas pertencentes a esta campanha?";
$GLOBALS['strShowParentCampaigns']		= "Mostrar campanhas superiores";
$GLOBALS['strHideParentCampaigns']		= "Ocultar campanhas superiores";
$GLOBALS['strHideInactiveBanners']		= "Ocultar banners inativos";
$GLOBALS['strInactiveBannersHidden']	= "banner(s) inativo(s) ocultado(s)";

// Banner (Properties)
$GLOBALS['strChooseBanner'] 	= "Por favor escolha o tipo de banner";
$GLOBALS['strMySQLBanner'] 		= "Banner Local (SQL)";
$GLOBALS['strWebBanner'] 		= "Banner Local (Servidor)";
$GLOBALS['strURLBanner'] 		= "Banner externo";
$GLOBALS['strHTMLBanner'] 		= "Banner HTML";
$GLOBALS['strTextBanner'] 		= "Anúncio de texto";
$GLOBALS['strAutoChangeHTML']	= "HTML alternativo para permitir controle de ".$GLOBALS['strClicks'];
$GLOBALS['strUploadOrKeep']		= "Deseja manter sua <br />imagem atual ou fazer<br />upload de uma nova?";
$GLOBALS['strNewBannerFile'] 	= "Selecione a imagem que deseja <br />usar para este banner<br /><br />";
$GLOBALS['strNewBannerURL'] 	= "URL da Imagem (incl. http://)";
$GLOBALS['strURL'] 				= "URL de destino (incl. http://)";
$GLOBALS['strHTML'] 			= "HTML";
$GLOBALS['strTextBelow'] 		= "Texto abaixo  da imagem";
$GLOBALS['strKeyword'] 			= "Palavras-chave";
$GLOBALS['strWeight'] 			= "Peso";
$GLOBALS['strAlt'] 				= "Texto alternativo";
$GLOBALS['strStatusText']		= "Texto de status";
$GLOBALS['strBannerWeight']		= "Peso do banner";

// Banner (swf)
$GLOBALS['strCheckSWF']			= "Verificar por link codificados dentro do arquivo Flash";
$GLOBALS['strConvertSWFLinks']	= "Converter links do Flash";
$GLOBALS['strConvertSWF']		= "<br />O arquivo flash enviado possui links definidos dentro do código fonte. \".MAX_PRODUCT_NAME.\" não poderá rastrear o número de cliques para este banner caso estes links não sejam convertidos. Abaixo você verá uma lista de todos links encontrados no arquivo. Se desejar converter os links, clique em <b>Converter</b>, caso contrário clique em <b>Cancelar</b>.<br /><br />Atenção: caso clique em <b>Converter</b> o arquivo enviado será fisicamente alterado. <br />Por favor mantenha um backup do arquivo original. Independentemente da versão em que este arquivo foi criado, o arquivo final necessitará do Flash Player 4 (ou maior) para ser corretamente apresentado.<br /><br />";
$GLOBALS['strCompressSWF']		= "Comprimir arquivo SWF para download mais rápido(Flash Player 6 necessário)";

// Banner (network)
$GLOBALS['strBannerNetwork']	= "Template HTML";
$GLOBALS['strChooseNetwork']	= "Escolha o <i>modelo</i> que quer usar";
$GLOBALS['strMoreInformation']	= "Mais informaï¿œï¿œo...";
$GLOBALS['strRichMedia']		= "Richmedia";
$GLOBALS['strTrackAdClicks']	= "Controlar ".$GLOBALS['strClicks'];

// Display limitations
$GLOBALS['strModifyBannerAcl'] 			= "Opções de entrega";
$GLOBALS['strACL'] 						= "Entrega";
$GLOBALS['strACLAdd'] 					= "Adicionar nova limitaï¿œï¿œo";
$GLOBALS['strNoLimitations']			= "Sem limites";
$GLOBALS['strApplyLimitationsTo']		= "Aplicar limites a";
$GLOBALS['strRemoveAllLimitations']		= "Remover todos limites";
$GLOBALS['strEqualTo']					= "é igual a";
$GLOBALS['strDifferentFrom']			= "é diferente de";
$GLOBALS['strAND']						= "E";  						// logical operator
$GLOBALS['strOR']						= "OU"; 						// logical operator
$GLOBALS['strOnlyDisplayWhen']			= "Somente mostrar este banner quando:";
$GLOBALS['strWeekDay'] 					= "Dia da semana";
$GLOBALS['strTime'] 					= "Horário";
$GLOBALS['strUserAgent'] 				= "Useragent";
$GLOBALS['strDomain'] 					= "Dominio";
$GLOBALS['strClientIP'] 				= "IP do Cliente";
$GLOBALS['strSource'] 					= "Fonte/Origem";
$GLOBALS['strBrowser'] 					= "Browser";
$GLOBALS['strOS'] 						= "Sistema Operativo";
$GLOBALS['strCountry'] 					= "País";
$GLOBALS['strContinent'] 				= "Continente";
$GLOBALS['strDeliveryLimitations']		= "Limitações de entrega";
$GLOBALS['strDeliveryCapping']			= "Limite de entrega";
$GLOBALS['strTimeCapping']				= "Uma vez que este anï¿œncio tenha sido mostrado a um dado visitante, nï¿œo mostrar por:";
$GLOBALS['strImpressionCapping']		= "Nï¿œo mostrar este anï¿œncio ao mesmo visitante mais do que:";

// Publisher
$GLOBALS['strAffiliate']				= "Editor";
$GLOBALS['strAffiliates']				= "Editores";
$GLOBALS['strAffiliatesAndZones']		= "Editores & Zonas";
$GLOBALS['strAddNewAffiliate']			= "Adicionar editor";
$GLOBALS['strAddAffiliate']				= "Criar editor";
$GLOBALS['strAffiliateProperties']		= "Propriedades do editor";
$GLOBALS['strAffiliateOverview']		= "Visão Geral de Sites";
$GLOBALS['strAffiliateHistory']			= "Histórico do site";
$GLOBALS['strZonesWithoutAffiliate']	= "Zonas sem editor";
$GLOBALS['strMoveToNewAffiliate']		= "Mover para novo editor";
$GLOBALS['strNoAffiliates']				= "Nenhum site definido";
$GLOBALS['strConfirmDeleteAffiliate']	= "Quer mesmo apagar este editor?";
$GLOBALS['strMakePublisherPublic']		= "Transformar zonas deste site em zonas publicamente acessíveis";

// Publisher (properties)
$GLOBALS['strWebsite']						= "Site";
$GLOBALS['strAllowAffiliateModifyInfo'] 	= "Permitir que este usuário modifique suas configurações";
$GLOBALS['strAllowAffiliateModifyZones'] 	= "Permitir que este usuário modifique suas zonas";
$GLOBALS['strAllowAffiliateLinkBanners'] 	= "Permitir que este usuário ligue banners às suas zonas";
$GLOBALS['strAllowAffiliateAddZone'] 		= "Permitir que este usuário defina novas zonas";
$GLOBALS['strAllowAffiliateDeleteZone'] 	= "Permitir que este usuário remova zonas existentes";

// Zone
$GLOBALS['strZone']					= "Zona";
$GLOBALS['strZones']				= "Zonas";
$GLOBALS['strAddNewZone']			= "Adicionar nova zona";
$GLOBALS['strAddZone']				= "Criar zona";
$GLOBALS['strModifyZone']			= "Modificar Zona";
$GLOBALS['strLinkedZones']			= "Zonas vinculadas";
$GLOBALS['strZoneOverview']			= "Visão Geral da Zona";
$GLOBALS['strZoneProperties']		= "Informações da Zona";
$GLOBALS['strZoneHistory']			= "Histórico da Zona";
$GLOBALS['strNoZones']				= "Nenhuma zona definida";
$GLOBALS['strConfirmDeleteZone']	= "Deseja realmente remover esta zona?";
$GLOBALS['strZoneType']				= "Tipo de zona";
$GLOBALS['strBannerButtonRectangle']		= "Banner, Botão ou retângulo";
$GLOBALS['strInterstitial']			= "Intersticial ou DHTML Flutuante";
$GLOBALS['strPopup']				= "Popup";
$GLOBALS['strTextAdZone']			= "Anúncio de texto";
$GLOBALS['strShowMatchingBanners']	= "Mostrar banners compatíveis";
$GLOBALS['strHideMatchingBanners']	= "Ocultar banners compatíveis";

// Advanced zone settings
$GLOBALS['strAdvanced']				= "Avançado";
$GLOBALS['strChains']				= "Ligaï¿œï¿œes";
$GLOBALS['strChainSettings']		= "Configurações de corrente";
$GLOBALS['strZoneNoDelivery']		= "Se nenhum banner desta zona puder ser mostrado, tente...";
$GLOBALS['strZoneStopDelivery']		= "Parar entrega e não mostrar nenhum banner";
$GLOBALS['strZoneOtherZone']		= "Mostrar a seguinte zona";
$GLOBALS['strZoneUseKeywords']		= "Selecionar anï¿œncio usando palavras conforme definidas abaixo";
$GLOBALS['strZoneAppend']			= "Sempre inserir este código HTML após anúncios de texto apresentados por esta zona";
$GLOBALS['strAppendSettings']		= "Configurações de Anexos e prefixos";
$GLOBALS['strZonePrependHTML']		= "Sempre inserir este código HTML antes de anúncios de texto apresentados por esta zona";
$GLOBALS['strZoneAppendHTML']		= "Sempre inserir este código HTML após anúncios de texto apresentados por esta zona";

// Linked banners/campaigns
$GLOBALS['strSelectZoneType']			= "Por favor escolha o que vincular com esta zona";
$GLOBALS['strBannerSelection']			= "Selecï¿œï¿œo de Anï¿œncios";
$GLOBALS['strCampaignSelection']		= "Selecï¿œï¿œo de Campanhas";
$GLOBALS['strInteractive']				= "Interactiva";
$GLOBALS['strRawQueryString']			= "Palavra-chave";
$GLOBALS['strIncludedBanners']			= "Banners vinculados";
$GLOBALS['strLinkedBannersOverview']	= "Descriï¿œï¿œo de anï¿œncios";
$GLOBALS['strLinkedBannerHistory']		= "Histï¿œrico de anï¿œncios";
$GLOBALS['strNoZonesToLink']			= "Não existem zonas compatíveis com este banner";
$GLOBALS['strNoBannersToLink']			= "Nï¿œo existem anï¿œncios disponï¿œveis que possam ser ligados a esta zona";
$GLOBALS['strNoLinkedBanners']			= "Nï¿œo existem anï¿œncios disponï¿œveis que estejam ligados a esta zona";
$GLOBALS['strMatchingBanners']			= "{count} banners compatíveis";
$GLOBALS['strNoCampaignsToLink']		= "Nenhuma campanha compatível com esta zona esta disponível";
$GLOBALS['strNoZonesToLinkToCampaign']  = "Nenhuma zona compatível com esta campanha esta disponível";
$GLOBALS['strSelectBannerToLink']		= "Selecione o banner que deseja vincular a esta zona:";
$GLOBALS['strSelectCampaignToLink']		= "Selecione a campanha que deseja vincular a esta zona:";

// Statistics
$GLOBALS['strStats'] 				= "Estatísticas";
$GLOBALS['strNoStats']				= "Nenhum dado estatístico disponível";
$GLOBALS['strConfirmResetStats']	= "Quer realmente apagar todas as estatï¿œsticas?";
$GLOBALS['strGlobalHistory']		= "Histórico Global";
$GLOBALS['strDailyHistory']			= "Histórico diário";
$GLOBALS['strDailyStats'] 			= "Estatísticas diárias";
$GLOBALS['strWeeklyHistory']		= "Histórico semanal";
$GLOBALS['strMonthlyHistory']		= "Histórico mensal";
$GLOBALS['strCreditStats'] 			= "Estatísticas de crédito";
$GLOBALS['strDetailStats'] 			= "Estatï¿œsticas detalhadas";
$GLOBALS['strTotalThisPeriod']		= "Total para este período";
$GLOBALS['strAverageThisPeriod']	= "Mï¿œdia do perï¿œodo";
$GLOBALS['strDistribution']			= "Distribuiï¿œï¿œo";
$GLOBALS['strResetStats'] 			= "Re-iniciar estatï¿œsticas";
$GLOBALS['strSourceStats']			= "Tipo de estatï¿œsticas";
$GLOBALS['strSelectSource']			= "Selecione o tipo que quer vï¿œr:";

// Hosts
$GLOBALS['strHosts']				= "Servidores";
$GLOBALS['strTopTenHosts'] 			= "Top dos Servidores";

// Expiration
$GLOBALS['strExpired']				= "Expirado";
$GLOBALS['strExpiration'] 			= "Vencimento";
$GLOBALS['strNoExpiration'] 		= "Sem data de vencimento";
$GLOBALS['strEstimated'] 			= "Vencimento estimado";

// Reports
$GLOBALS['strReports']				= "Relatórios";
$GLOBALS['strSelectReport']			= "Selecione que relatï¿œrio quer gerar";

// Userlog
$GLOBALS['strUserLog']				= "Log de usuários";
$GLOBALS['strUserLogDetails']		= "Detalhes do log de usuários";
$GLOBALS['strDeleteLog']			= "Remover log";
$GLOBALS['strAction']				= "Ação";
$GLOBALS['strNoActionsLogged']		= "Nenhuma ação registrada";

// Code generation
$GLOBALS['strGenerateBannercode']	= "Seleção direta";
$GLOBALS['strChooseInvocationType']	= "Por favor escolha o tipo de invocação de banner";
$GLOBALS['strGenerate']				= "Gerar";
$GLOBALS['strParameters']			= "Parâmetros das tags";
$GLOBALS['strFrameSize']			= "Tamanho da moldura";
$GLOBALS['strBannercode']			= "Código do banner";

// Errors
$GLOBALS['strMySQLError'] 			= "Erro SQL:";
$GLOBALS['strLogErrorClients'] 		= "[phpAds] Um erro ocorreu enquanto pegava anunciantes da base de dados.";
$GLOBALS['strLogErrorBanners'] 		= "[phpAds] Um erro ocorreu enquanto pegava banners da base de dados.";
$GLOBALS['strLogErrorViews'] 		= "[phpAds] Um erro ocorreu enquanto pegava impressões da base de dados.";
$GLOBALS['strLogErrorClicks'] 		= "[phpAds] Um erro ocorreu enquanto pegava cliques da base de dados.";
$GLOBALS['strErrorViews'] 			= "Tem de definir o nï¿œmero de visualizaï¿œï¿œes ou selecionar Ilimitadas !";
$GLOBALS['strErrorNegViews'] 		= "Visualizaï¿œï¿œes negativas nï¿œo sï¿œo permitidas";
$GLOBALS['strErrorClicks'] 			= "Tem de definir o nï¿œmero de visualizaï¿œï¿œes ou selecionar Ilimitadoas !";
$GLOBALS['strErrorNegClicks'] 		= "Cliques negativos nï¿œo sï¿œo permitidos";
$GLOBALS['strNoMatchesFound']		= "Nenhum resultado encontrado";
$GLOBALS['strErrorOccurred']		= "Um erro ocorreu";
$GLOBALS['strErrorUploadSecurity']	= "Foi detectado um possível problema de segurança, upload interrompido!";
$GLOBALS['strErrorUploadBasedir']	= "Não foi possível acessar o arquivo enviado, provavelmente devido a uma restrição de safemode ou open_basedir";
$GLOBALS['strErrorUploadUnknown']	= "Não foi possível acessar o arquivo enviado, devido a um erro desconhecido. Verifique a configuração de seu PHP";
$GLOBALS['strErrorStoreLocal']		= "Um erro ocorreu ao tentar salvar o 'anï¿œncio' na directoria local. Isto ï¿œ um provï¿œvel resultado de mï¿œ configuraï¿œï¿œo do direito de acesso ï¿œ mesma.";
$GLOBALS['strErrorStoreFTP']		= "Um erro ocorreu ao tentar importar o ficheiro para o servidor FTP. Isto pode ser causado por indisponibilidade do servidor, ou devido a uma mï¿œ configuraï¿œï¿œo do servidor FTP.";

// E-mail
$GLOBALS['strMailSubject'] 				= "Relatório de Anunciante";
$GLOBALS['strAdReportSent']				= "Relatï¿œrio de Anunciante enviado";
$GLOBALS['strMailSubjectDeleted'] 		= "Anï¿œncios desactivados";
$GLOBALS['strMailHeader'] 				= "Caro(a) {contact},
";
$GLOBALS['strMailBannerStats'] 			= "Abaixo poderá ver as estatísticas de banners para {clientname}:";
$GLOBALS['strMailFooter'] 				= "Atenciosamente,
   {adminfullname}";
$GLOBALS['strMailClientDeactivated']	= "Os seguintes anï¿œncios foram desactivados porque";
$GLOBALS['strMailNothingLeft'] 			= "Se deseja continuar anunciando em nosso site, sinta-se a vontade em nos contactar.
Estaremos felizes em lhe receber.";
$GLOBALS['strClientDeactivated']		= "Esta campanha não esta ativa porque";
$GLOBALS['strBeforeActivate']			= "a data de ativação ainda não foi alcançada";
$GLOBALS['strAfterExpire']				= "a data de vencimento foi alcançada";
$GLOBALS['strNoMoreClicks']				= "não há mais Cliques restantes";
$GLOBALS['strNoMoreViews']				= "nï¿œo tem mais Visualizaï¿œï¿œes adquiridas";
$GLOBALS['strWarnClientTxt']			= "As Impressões, Cliques, ou conversões restantes para este banner estão chegando ao fim {limit}.
Seu banner será desativado quando não houver nenhuma restante. ";
$GLOBALS['strImpressionsClicksLow']			= "Visualizacoes/Cliques estï¿œo baixos";
$GLOBALS['strNoViewLoggedInInterval']   = "Nenhum Impressão foi registrada durante o período deste relatório";
$GLOBALS['strNoClickLoggedInInterval']  = "Nenhum Clique foi registrada durante o período deste relatório";
$GLOBALS['strMailReportPeriod']			= "Este relatório inclui estatísticas de {startdate} até {enddate}.";
$GLOBALS['strMailReportPeriodAll']		= "Este relatório possui todas estatísticas até {enddate}.";
$GLOBALS['strNoStatsForCampaign'] 		= "Nenhum dado estatístico disponível para esta campanha";

// Priority
$GLOBALS['strPriority']				= "Prioridade";

// Settings
$GLOBALS['strSettings'] 			= "Configurações";
$GLOBALS['strGeneralSettings']		= "Configurações gerais";
$GLOBALS['strMainSettings']			= "Principais configurações";
$GLOBALS['strAdminSettings']		= "Configurações de administração";

// Product Updates
$GLOBALS['strProductUpdates']		= "Atualizações do produto";



// Note: new translatiosn not found in original lang files but found in CSV
$GLOBALS['strWarning'] = "Alerta";
$GLOBALS['strHideInactive'] = "Ocultar itens inativos de todas páginas de dados gerais";
$GLOBALS['strStartOver'] = "Re-iniciar";
$GLOBALS['strTrackerVariables'] = "Variáveis de rastreamento";
$GLOBALS['strLogoutURL'] = "URL para redirecionar após logout. <br />Em branco para valor padrão.";
$GLOBALS['strAppendTrackerCode'] = "Anexar código de rastreamento";
$GLOBALS['strSyncSettings'] = "Configurações de Sincronização";
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
$GLOBALS['strAdmin'] = "Admin";
$GLOBALS['strNotice'] = "Aviso";
$GLOBALS['strPriorityLevel'] = "Nível de prioridade";
$GLOBALS['strPriorityTargeting'] = "Distribuição";
$GLOBALS['strPriorityOptimisation'] = "Miscelânea";
$GLOBALS['strExclusiveAds'] = "Anúncios exclusivos";
$GLOBALS['strHighAds'] = "Anúncios com Alta prioridade";
$GLOBALS['strLowAds'] = "Anúncios com Baixa prioridade";
$GLOBALS['strLimitations'] = "Limitações";
$GLOBALS['strCapping'] = "Excesso";
$GLOBALS['strVariables'] = "Variáveis";
$GLOBALS['strComments'] = "Comentários";
$GLOBALS['strUsernameOrPasswordWrong'] = "O nome de usuário e/ou senha estão incorretos. Por favor tente novamente.";
$GLOBALS['strDuplicateAgencyName'] = "O nome de usuário fornecido já existe, por favor escolha outro.";
$GLOBALS['strInvalidPassword'] = "A nova senha é inválida, use uma senha diferente.";
$GLOBALS['strNotSamePasswords'] = "As senhas fornecidas não são iguais";
$GLOBALS['strRepeatPassword'] = "Repetir senha";
$GLOBALS['strOldPassword'] = "Senha antiga";
$GLOBALS['strNewPassword'] = "Nova senha";
$GLOBALS['strRequests'] = "Requisições";
$GLOBALS['strConversions'] = "Conversões";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCNVR'] = "Proporção de vendas";
$GLOBALS['strTotalClicks'] = "Total de cliques";
$GLOBALS['strTotalConversions'] = "Total de conversões";
$GLOBALS['strViewCredits'] = "Créditos de Impressão";
$GLOBALS['strClickCredits'] = "Créditos de Cliques";
$GLOBALS['strConversionCredits'] = "Créditos de Conversão";
$GLOBALS['strDateTime'] = "Data e Hora";
$GLOBALS['strTrackerID'] = "ID do rastreador";
$GLOBALS['strTrackerName'] = "Nome do rastreador";
$GLOBALS['strCampaignID'] = "ID da campanha";
$GLOBALS['strCampaignName'] = "Nome da campanha";
$GLOBALS['strStatsAction'] = "Ação";
$GLOBALS['strWindowDelay'] = "Atraso da janela";
$GLOBALS['strStatsVariables'] = "Variáveis";
$GLOBALS['strFinanceCPM'] = "CPM ";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Locação mensal";
$GLOBALS['strSingleMonth'] = "Mês";
$GLOBALS['strDayOfWeek'] = "Dia da semana";
$GLOBALS['strDayFullNames'][''] = "Sábado";
$GLOBALS['strChars'] = "caracteres";
$GLOBALS['strAllowClientViewTargetingStats'] = "Permitir que este usuário veja estatísticas de direcionamento";
$GLOBALS['strCsvImportConversions'] = "Permitir que este usuário importe conversões 'offline'";
$GLOBALS['strAddCampaign_Key'] = "Adicionar <u>n</u>ova campanha";
$GLOBALS['strLinkedCampaigns'] = "Campanhas vinculadas";
$GLOBALS['strShowParentAdvertisers'] = "Mostrar anunciantes superiores";
$GLOBALS['strHideParentAdvertisers'] = "Esconder anunciantes superiores";
$GLOBALS['strContractDetails'] = "Detalhes do contrato";
$GLOBALS['strInventoryDetails'] = "Detalhes do inventário";
$GLOBALS['strPriorityInformation'] = "Informação de prioridade";
$GLOBALS['strPriorityExclusive'] = "Sobrepõe outras campanhas vinculadas";
$GLOBALS['strPriorityHigh'] = "Campanhas pagas";
$GLOBALS['strPriorityLow'] = "Campanhas internas e não-pagas";
$GLOBALS['strHiddenCampaign'] = "Campanha";
$GLOBALS['strHiddenAd'] = "Anúncio";
$GLOBALS['strHiddenAdvertiser'] = "Anunciante";
$GLOBALS['strHiddenTracker'] = "Rastreador";
$GLOBALS['strHiddenZone'] = "Zona";
$GLOBALS['strCompanionPositioning'] = "Entrega casada (com outras peças)";
$GLOBALS['strSelectUnselectAll'] = "Selecionar / Deselecionar Todos";
$GLOBALS['strExclusive'] = "Exclusiva";
$GLOBALS['strExpirationDateComment'] = "A campanha terminará ao final deste dia";
$GLOBALS['strActivationDateComment'] = "A Campanha iniciará ao início deste dia";
$GLOBALS['strRevenueInfo'] = "Orçamento";
$GLOBALS['strImpressionsRemaining'] = "Impressões restantes";
$GLOBALS['strClicksRemaining'] = "Cliques restantes";
$GLOBALS['strConversionsRemaining'] = "Conversões restantes";
$GLOBALS['strImpressionsBooked'] = "Impressões contratadas";
$GLOBALS['strClicksBooked'] = "Cliques contratados";
$GLOBALS['strConversionsBooked'] = "Conversões contratadas";
$GLOBALS['strOptimise'] = "Otimizar";
$GLOBALS['strCampaignWarningNoWeight'] = "A prioridade desta campanha foi configurada para baixa, \nmas seu peso configurado para zero ou não informado.\nIsto causará a campanha a ser desativada e seus banners\nnão serão entregues até o peso  ser alterado para um número\nválido.\n\nDeseja continuar?";
$GLOBALS['strCampaignWarningNoTarget'] = "A prioridade desta campanha foi configurada para alta,\nmas o número alvejado de impressões não foi especificado\nIsto causará a campanha a ser desativada e seus banners não\nserão entregues até que um número válido seja cadastrado.\n\nDeseja continuar?";
$GLOBALS['strTracker'] = "Rastreador";
$GLOBALS['strTrackerOverview'] = "Visão geral do rastreador";
$GLOBALS['strAddTracker'] = "Adicionar no rastreador";
$GLOBALS['strAddTracker_Key'] = "Adicionar <u>n</u>ovo rastreador";
$GLOBALS['strNoTrackers'] = "Nenhum rastreador definido";
$GLOBALS['strConfirmDeleteAllTrackers'] = "Deseja realmente remover todos rastreadores deste anunciante?";
$GLOBALS['strConfirmDeleteTracker'] = "Deseja realmente remover este rastreador?";
$GLOBALS['strDeleteAllTrackers'] = "Remover todos rastreadores";
$GLOBALS['strTrackerProperties'] = "Dados do rastreador";
$GLOBALS['strModifyTracker'] = "Modificar rastreador";
$GLOBALS['strLog'] = "Gravar?";
$GLOBALS['strDefaultStatus'] = "Estado padrão";
$GLOBALS['strStatus'] = "Estado";
$GLOBALS['strLinkedTrackers'] = "Rastreadores vinculados";
$GLOBALS['strDefaultConversionRules'] = "Regras padrões de conversão";
$GLOBALS['strConversionWindow'] = "Janela de conversão";
$GLOBALS['strClickWindow'] = "Janela de clique";
$GLOBALS['strViewWindow'] = "Janela de visualização";
$GLOBALS['strUniqueWindow'] = "Janela única";
$GLOBALS['strClick'] = "Clique";
$GLOBALS['strView'] = "Visualizar";
$GLOBALS['strLinkCampaignsByDefault'] = "vincular campanhas novas por padrão";
$GLOBALS['strAddBanner_Key'] = "Adicionar <u>n</u>ovo banner";
$GLOBALS['strAppendTextAdNotPossible'] = "Impossível anexar outros banners a anúncios de texto.";
$GLOBALS['strWarningMissing'] = "Atenção, possivelmente falta uma";
$GLOBALS['strWarningMissingClosing'] = "tag de fechamento \">\"";
$GLOBALS['strWarningMissingOpening'] = "tag de abertura \"<\"";
$GLOBALS['strSubmitAnyway'] = "Enviar de qualquer forma";
$GLOBALS['strAutoChangeHTML'] = "Alterar HTML para permitir rastreamento de cliques";
$GLOBALS['strUploadOrKeepAlt'] = "Deseja manter sua <br />imagem de backup atual ou fazer <br />upload de uma nova?";
$GLOBALS['strNewBannerFileAlt'] = "Selecione a imagem de backup que deseja <br />usar caso o navegador<br />não aceite rich media<br /><br />";
$GLOBALS['strAdserverTypeGeneric'] = "Banner HTML genérico";
$GLOBALS['strGenericOutputAdServer'] = "Genérico";
$GLOBALS['strSwfTransparency'] = "Fundo transparente (Apenas Flash)";
$GLOBALS['strHardcodedLinks'] = "Links codificados no Flash";
$GLOBALS['strOverwriteSource'] = "Sobrescrever parâmetro original";
$GLOBALS['strLaterThan'] = "depois de";
$GLOBALS['strLaterThanOrEqual'] = "depois de ou igual a";
$GLOBALS['strEarlierThan'] = "antes de";
$GLOBALS['strEarlierThanOrEqual'] = "antes de  ou igual a";
$GLOBALS['strWeekDays'] = "Dias da semana";
$GLOBALS['strCity'] = "Cidade";
$GLOBALS['strDeliveryCappingReset'] = "Resetar contadores de visualização após:";
$GLOBALS['strDeliveryCappingTotal'] = "no total";
$GLOBALS['strDeliveryCappingSession'] = "por sessão";
$GLOBALS['strAffiliateInvocation'] = "Código de inserção";
$GLOBALS['strMnemonic'] = "Mnemônica";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Permitir que este usuário gere o código de inserção";
$GLOBALS['strAllowAffiliateZoneStats'] = "Permitir que este usuário veja estatísticas da zona";
$GLOBALS['strAllowAffiliateApprPendConv'] = "Permitir que este usuário veja apenas conversões aprovadas ou pendentes";
$GLOBALS['strPaymentInformation'] = "Informações de pagamento";
$GLOBALS['strAddress'] = "Endereço";
$GLOBALS['strPostcode'] = "Código Postal (CEP)";
$GLOBALS['strPhone'] = "Telefone";
$GLOBALS['strFax'] = "Fax";
$GLOBALS['strAccountContact'] = "Contato da conta";
$GLOBALS['strPayeeName'] = "Nome do recipiente";
$GLOBALS['strTaxID'] = "ID da Taxa";
$GLOBALS['strModeOfPayment'] = "Forma de pagamento";
$GLOBALS['strPaymentChequeByPost'] = "Cheque pelo correio";
$GLOBALS['strCurrency'] = "Moeda";
$GLOBALS['strCurrencyGBP'] = "GBP";
$GLOBALS['strOtherInformation'] = "Outros dados";
$GLOBALS['strUniqueUsersMonth'] = "Visitantes únicos/mês";
$GLOBALS['strUniqueViewsMonth'] = "Visualizações únicas/mês";
$GLOBALS['strPageRank'] = "Rank da página";
$GLOBALS['strCategory'] = "Categoria";
$GLOBALS['strHelpFile'] = "Arquivo de ajuda";
$GLOBALS['strAddNewZone_Key'] = "Adicionar <u>n</u>ova zona";
$GLOBALS['strEmailAdZone'] = "Zona de E-mail/Newsletter";
$GLOBALS['strZoneClick'] = "Zona de rastreamento de cliques";
$GLOBALS['strBannerLinkedAds'] = "Banners vinculados a esta zona";
$GLOBALS['strCampaignLinkedAds'] = "Campanhas vinculadas a esta zona";
$GLOBALS['strTotalZones'] = "Total de Zonas";
$GLOBALS['strCostInfo'] = "Custo da mídia";
$GLOBALS['strTechnologyCost'] = "Custo da tecnologia";
$GLOBALS['strInactiveZonesHidden'] = "zona(s) inativa(s) oculta(s)";
$GLOBALS['strWarnChangeZoneType'] = "\"Alterar o tipo de zona para texto ou e-mail irá remover vinculo com todos banners/campanhas devido a restrições destes tipos de zonas\\n                                                <ul>\\n                                                    <li>Zonas de texto podem te apenas anúncios de texto</li>\\n                                                    <li>Zonas de E-mail podem ter apenas um banner ativo por vez</li>\\n                                                </ul>\"\\n";
$GLOBALS['strWarnChangeZoneSize'] = "Alterar o tamanho da zona irá remover vínculos de banners incompatíveis com o novo tamanho, e irá adicionar qualquer banner de campanhas vinculadas que seja compatível";
$GLOBALS['strZoneForecasting'] = "Configurações de Previsão da Zona";
$GLOBALS['strZoneAppendNoBanner'] = "Anexar mesmo que nenhum banner seja apresentado";
$GLOBALS['strZoneAppendType'] = "Tipo de sufixo";
$GLOBALS['strZoneAppendHTMLCode'] = "Código HTML";
$GLOBALS['strZoneAppendZoneSelection'] = "Popup ou Intersticial";
$GLOBALS['strZoneAppendSelectZone'] = "Sempre anexar o seguinte popup ou intersticial para banners mostrados por esta zona";
$GLOBALS['strZoneProbListChain'] = "Todos banners ligados a esta zona estão inativos <br />Essa é a corrente que será seguida:";
$GLOBALS['strZoneProbNullPri'] = "Nenhum banner ativo vinculado a esta zona.";
$GLOBALS['strZoneProbListChainLoop'] = "Seguir esta corrente causará uma referência circular. Entrega para esta zona foi interrompida.";
$GLOBALS['strLinkedBanners'] = "vincular banners individuais";
$GLOBALS['strCampaignDefaults'] = "vincular banners pelas campanhas a que pertencem";
$GLOBALS['strLinkedCategories'] = "Vincular banners por categoria";
$GLOBALS['strNoTrackersToLink'] = "Nenhum rastreador compatível com esta campanha esta disponível";
$GLOBALS['strSelectAdvertiser'] = "Selecionar anunciante";
$GLOBALS['strSelectPlacement'] = "Selecionar campanha";
$GLOBALS['strSelectAd'] = "Selecionar banner";
$GLOBALS['strStatusPending'] = "Pendente";
$GLOBALS['strStatusApproved'] = "Aprovado";
$GLOBALS['strStatusDisapproved'] = "Rejeitado";
$GLOBALS['strStatusDuplicate'] = "Duplicado";
$GLOBALS['strStatusOnHold'] = "Em espera";
$GLOBALS['strStatusIgnore'] = "Ignorar";
$GLOBALS['strConnectionType'] = "Tipo";
$GLOBALS['strConnTypeSale'] = "Venda";
$GLOBALS['strConnTypeLead'] = "Chamada";
$GLOBALS['strConnTypeSignUp'] = "Registrar-se";
$GLOBALS['strShortcutEditStatuses'] = "Editar estados";
$GLOBALS['strShortcutShowStatuses'] = "Mostrar estados";
$GLOBALS['strNoTargetingStats'] = "Nenhum dado estatístico de direcionamento disponível";
$GLOBALS['strNoStatsForPeriod'] = "Nenhum dado estatístico disponível para o período de %s a %s";
$GLOBALS['strNoTargetingStatsForPeriod'] = "Nenhum dado estatístico de direcionamento disponível para o período de %s a %s";
$GLOBALS['strCampaignDistribution'] = "Distribuição por campanha";
$GLOBALS['strKeywordStatistics'] = "Estatísticas de palavras-chaves";
$GLOBALS['strTargetStats'] = "Estatísticas de direcionamento";
$GLOBALS['strViewBreakdown'] = "Visualizar por";
$GLOBALS['strBreakdownByDay'] = "Dia";
$GLOBALS['strBreakdownByWeek'] = "Semana";
$GLOBALS['strBreakdownByMonth'] = "Mês";
$GLOBALS['strBreakdownByDow'] = "Dia da semana";
$GLOBALS['strBreakdownByHour'] = "Hora";
$GLOBALS['strItemsPerPage'] = "Itens por página";
$GLOBALS['strDistributionHistory'] = "Histórico de distribuição";
$GLOBALS['strShowGraphOfStatistics'] = "Mostrar <u>G</u>ráfico de estatísticas";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>xportar estatísticas para o Excel";
$GLOBALS['strGDnotEnabled'] = "Você precisa ter a biblioteca GD para PHP habilitada para exibir gráficos. <br />Por favor veja <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> para maiores informações, inclusive como instalar GD em seu servidor.";
$GLOBALS['strStartDate'] = "Data de início";
$GLOBALS['strEndDate'] = "Data de término";
$GLOBALS['strAllAdvertisers'] = "Todos anunciantes";
$GLOBALS['strAnonAdvertisers'] = "Anunciantes anônimos";
$GLOBALS['strAllAvailZones'] = "Todas zonas disponíveis";
$GLOBALS['strTrackercode'] = "Código do rastreador";
$GLOBALS['strBackToTheList'] = "Voltar para lista de relatórios";
$GLOBALS['strLogErrorConversions'] = "[phpAds] Um erro ocorreu enquanto pegava conversões da base de dados.";
$GLOBALS['strErrorDBPlain'] = "Um erro ocorreu ao acessar a base de dados";
$GLOBALS['strErrorDBSerious'] = "Um grave problema foi detectado com a base de dados";
$GLOBALS['strErrorDBNoDataPlain'] = "Devido a um problema na base de dados, \".MAX_PRODUCT_NAME.\" não pode resgatar ou armazenar os dados.";
$GLOBALS['strErrorDBNoDataSerious'] = "Devido a um grave problema na base de dados, \".MAX_PRODUCT_NAME.\" não pode resgatar dados";
$GLOBALS['strErrorDBCorrupt'] = "A tabela da base de dados pode estar corrompida e necessita de reparos. Para mais informações sobre tabelas corrompidas leia o capitulo <i>Troubleshooting</i> do <i>Guia do Administrador</i>.";
$GLOBALS['strErrorDBContact'] = "Por favor notifique o administrador deste sistema sobre este problema.";
$GLOBALS['strErrorDBSubmitBug'] = "Se este erro pode ser reproduzido ele pode ser causado por um bug no \".MAX_PRODUCT_NAME.\". Por favor envie os seguintes dados aos desenvolvedores do \".MAX_PRODUCT_NAME.\". Tente também descrever as ações que levaram a este erro de forma clara.";
$GLOBALS['strMaintenanceNotActive'] = "O script de manutenção não foi executado nas últimas 24 horas. \\\\nPara que \".MAX_PRODUCT_NAME.\" funcione corretamente ele precisa ser executado \\\\na cada hora. \\\\n\\\\nPor favor leia o Guia do Administrador para mais informações sobre \\\\nconfigurar o script de manutenção.";
$GLOBALS['strErrorLinkingBanner'] = "Não foi possível vincular este banner a esta zona pois:";
$GLOBALS['strUnableToLinkBanner'] = "Impossível vincular este banner:";
$GLOBALS['strErrorEditingCampaign'] = "Erro ao atualizar a campanha:";
$GLOBALS['strUnableToChangeCampaign'] = "Impossível aplicar esta alteração pois:";
$GLOBALS['strDatesConflict'] = "datas conflitam com:";
$GLOBALS['strEmailNoDates'] = "Campanhas de zonas de E-mail devem ter uma data de início e de término";
$GLOBALS['strSirMadam'] = "Sr./Sra.";
$GLOBALS['strMailBannerActivatedSubject'] = "Campanha ativada";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Campanha desativada";
$GLOBALS['strMailBannerActivated'] = "A sua campanha demonstrada abaixo foi ativada pois \na data de ativação foi alcançada.";
$GLOBALS['strMailBannerDeactivated'] = "A sua campanha demonstrada abaixo foi desativada porque";
$GLOBALS['strNoMoreImpressions'] = "não há mais Impressões restantes";
$GLOBALS['strNoMoreConversions'] = "não há mais Vendas restantes";
$GLOBALS['strWeightIsNull'] = "seu peso esta definido para zero";
$GLOBALS['strTargetIsNull'] = "seu objetivo está definido como zero";
$GLOBALS['strImpressionsClicksConversionsLow'] = "Impressões/Cliques/Conversões estão no fim";
$GLOBALS['strNoConversionLoggedInInterval'] = "Nenhum Conversão foi registrada durante o período deste relatório";
$GLOBALS['strImpendingCampaignExpiry'] = "Vencimento de campanha iminente";
$GLOBALS['strYourCampaign'] = "Sua campanha";
$GLOBALS['strTheCampiaignBelongingTo'] = "A campanha pertencente a";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} apresentada abaixo vencerá dia {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} apresenta abaixo tem menos de {limit} impressões restantes.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "Por conseqüência, a campanha será em breve automaticamente desabilitada e \nos seguintes banners também:";
$GLOBALS['strSourceEdit'] = "Editar fontes";
$GLOBALS['strCheckForUpdates'] = "Verificar por atualizações";
$GLOBALS['strViewPastUpdates'] = "Gerenciar Atualizações anteriores e backups";
$GLOBALS['strAgencyManagement'] = "Gerenciar Agências";
$GLOBALS['strAgency'] = "Agência";
$GLOBALS['strAddAgency'] = "Adicionar nova Agência";
$GLOBALS['strAddAgency_Key'] = "Adicionar <u>n</u>ova Agência";
$GLOBALS['strTotalAgencies'] = "Total de agências";
$GLOBALS['strAgencyProperties'] = "Informações da agência";
$GLOBALS['strNoAgencies'] = "Nenhuma agência definida";
$GLOBALS['strConfirmDeleteAgency'] = "Deseja realmente remover esta agência?";
$GLOBALS['strHideInactiveAgencies'] = "Ocultar agências inativas";
$GLOBALS['strInactiveAgenciesHidden'] = "agência(s) inativa(s) oculta(das)";
$GLOBALS['strAllowAgencyEditConversions'] = "Permitir que este usuário altere conversões";
$GLOBALS['strAllowMoreReports'] = "Permitir botão de 'Mais Relatórios'";
$GLOBALS['strChannel'] = "Canal";
$GLOBALS['strChannels'] = "Canais";
$GLOBALS['strChannelOverview'] = "Visão Geral do Canal";
$GLOBALS['strChannelManagement'] = "Gerenciamento de canais";
$GLOBALS['strAddNewChannel'] = "Adicionar novo canal";
$GLOBALS['strAddNewChannel_Key'] = "Adicionar <u>n</u>ovo canal";
$GLOBALS['strNoChannels'] = "Nenhum canal definido";
$GLOBALS['strEditChannelLimitations'] = "Editar limitações do canal";
$GLOBALS['strChannelProperties'] = "Informações do canal";
$GLOBALS['strChannelLimitations'] = "Opções de entrega";
$GLOBALS['strConfirmDeleteChannel'] = "Deseja realmente remover este canal?";
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
$GLOBALS['strForgotPassword'] = "Esqueceu sua senha?";
$GLOBALS['strPasswordRecovery'] = "Recuperação de senha";
$GLOBALS['strEmailRequired'] = "E-mail é um campo obrigatório";
$GLOBALS['strPwdRecEmailSent'] = "E-mail de recuperação de senha enviado";
$GLOBALS['strPwdRecEmailNotFound'] = "E-mail não encontrado";
$GLOBALS['strPwdRecPasswordSaved'] = "A nova senha foi armazenada, prossiga para fazer <a href='index.php'>login</a>";
$GLOBALS['strPwdRecWrongId'] = "ID incorreto";
$GLOBALS['strPwdRecEnterEmail'] = "Digite seu e-mail abaixo";
$GLOBALS['strPwdRecEnterPassword'] = "Digite sua nova senha abaixo";
$GLOBALS['strPwdRecResetLink'] = "Link para resetar a senha";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "%s recuperação de senha";
$GLOBALS['strProceed'] = "Prosseguir >";
$GLOBALS['strDayFullNames'][''] = "Domingo";
$GLOBALS['strDayFullNames'][''] = "Segunda";
$GLOBALS['strDayFullNames'][''] = "Terça";
$GLOBALS['strDayFullNames'][''] = "Quarta";
$GLOBALS['strDayFullNames'][''] = "Quinta";
$GLOBALS['strDayFullNames'][''] = "Sexta";
$GLOBALS['strValue'] = "Valor";
$GLOBALS['strOpenadsIdSettings'] = "Configurações de ID ".MAX_PRODUCT_NAME;
$GLOBALS['strNovice'] = "Ações de remoção realizadas pelo Administrador necessitam confirmação, por segurança";
$GLOBALS['strNoAdminInterface'] = "A tela de administração foi desligada para manutenção. Isso não afeta a entrega de suas campanhas.";
$GLOBALS['strGreaterThan'] = "maior que";
$GLOBALS['strLessThan'] = "menor que";
$GLOBALS['strCappingBanner']['limit'] = "Limitar visualização de banners a:";
$GLOBALS['strCappingCampaign']['limit'] = "Limitar visualizações da campanha a:";
$GLOBALS['strCappingZone']['limit'] = "Limitar visualizações de zonas a:";
$GLOBALS['strOpenadsEmail'] = "".MAX_PRODUCT_NAME." . \" E-mail";
$GLOBALS['strEmailSettings'] = "Configurações de e-mail";
$GLOBALS['strEnableQmailPatch'] = "Habilitar patch para Qmail";
$GLOBALS['strEmailHeader'] = "Cabeçalhos do e-mail";
$GLOBALS['strEmailLog'] = "Registro de e-mail (Log)";
$GLOBALS['strAudit'] = "Log de auditoria";
$GLOBALS['strEnableAudit'] = "Habilitar Auditoria de percurso";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Sua instalação de PHP não suporta FTP";
$GLOBALS['strGeotargetingUseBundledCountryDb'] = "Usar a base MaxMind GeoLiteCountry inclusa no pacote";
$GLOBALS['strConfirmationUI'] = "Confirmação na interface do usuário";
$GLOBALS['strBannerStorage'] = "Configurações  de armazenamento de banners";
$GLOBALS['strMaintenanceSettings'] = "Configurações de manutenção";
$GLOBALS['strSSLSettings'] = "Configurações de SSL";
$GLOBALS['strLogging'] = "Logs";
$GLOBALS['strDebugLog'] = "Log de depuração";
$GLOBALS['strEvent'] = "Evento";
$GLOBALS['strTimestamp'] = "Hora";
$GLOBALS['strDeleted'] = "removido";
$GLOBALS['strInserted'] = "inserido";
$GLOBALS['strUpdated'] = "atualizado";
$GLOBALS['strInsert'] = "Inserir";
$GLOBALS['strUpdate'] = "Atualizar";
$GLOBALS['strHas'] = "tem";
$GLOBALS['strFilters'] = "Filtros";
$GLOBALS['strAdvertiser'] = "Anunciante";
$GLOBALS['strType'] = "Tipo";
$GLOBALS['strParameter'] = "Parâmetro";
$GLOBALS['strDetailedView'] = "Visão detalhada";
$GLOBALS['strReturnAuditTrail'] = "Voltar para Auditoria de percurso";
$GLOBALS['strAuditTrail'] = "Rastros de auditoria";
$GLOBALS['strMaintenanceLog'] = "Log de manutenção";
$GLOBALS['strAuditResultsNotFound'] = "Nenhum evento encontrado com os critérios informados";
$GLOBALS['strCollectedAllEvents'] = "Todos eventos";
$GLOBALS['strClear'] = "Limpar";
$GLOBALS['strLinkNewUser'] = "Vincular novo usuário";
$GLOBALS['strLinkNewUser_Key'] = "Vincular <u>u</u>suário";
$GLOBALS['strUserAccess'] = "Acesso de usuário";
$GLOBALS['strMyAccount'] = "Minha conta";
$GLOBALS['strCampaignStatusRunning'] = "Inicializado";
$GLOBALS['strCampaignStatusPaused'] = "Pausado";
$GLOBALS['strCampaignStatusAwaiting'] = "Adicionado";
$GLOBALS['strCampaignStatusExpired'] = "Finalizado";
$GLOBALS['strCampaignStatusApproval'] = "Aguardando aprovação »";
$GLOBALS['strCampaignStatusRejected'] = "Rejeitado";
$GLOBALS['strCampaignApprove'] = "Aprovado";
$GLOBALS['strCampaignApproveDescription'] = "aceitar esta campanha";
$GLOBALS['strCampaignReject'] = "Rejeitar";
$GLOBALS['strCampaignRejectDescription'] = "rejeitar esta campanha";
$GLOBALS['strCampaignPause'] = "Pausar";
$GLOBALS['strCampaignPauseDescription'] = "pausar esta campanha temporariamente";
$GLOBALS['strCampaignRestart'] = "Continuar";
$GLOBALS['strCampaignRestartDescription'] = "continuar esta campanha";
$GLOBALS['strCampaignStatus'] = "Estado da campanha";
$GLOBALS['strReasonForRejection'] = "Justificativa da rejeição";
$GLOBALS['strReasonSiteNotLive'] = "Site fora do ar";
$GLOBALS['strReasonBadCreative'] = "Anúncio inapropriado";
$GLOBALS['strReasonBadUrl'] = "URL de destino inapropriada";
$GLOBALS['strReasonBreakTerms'] = "Site fere os termos e condições";
$GLOBALS['strTrackerPreferences'] = "Preferências do Rastreador";
$GLOBALS['strBannerPreferences'] = "Preferências dos Anúncios";
$GLOBALS['strAdvertiserSetup'] = "Inscrição de anunciante";
$GLOBALS['strSelectZone'] = "Escolher zona";
$GLOBALS['strMainPreferences'] = "Preferências gerais";
$GLOBALS['strAccountPreferences'] = "Preferências da conta";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Preferências de E-mails com relatórios de campanhas";
$GLOBALS['strAdminEmailWarnings'] = "Alertas de e-mail do Administrador";
$GLOBALS['strAgencyEmailWarnings'] = "Alertas de e-mail de Agências";
$GLOBALS['strAdveEmailWarnings'] = "Alertas de e-mail de Anunciantes";
$GLOBALS['strFullName'] = "Nome completo";
$GLOBALS['strUserDetails'] = "Detalhes do usuário";
$GLOBALS['strLanguageTimezone'] = "Línguas e Fusos Horários";
$GLOBALS['strLanguageTimezonePreferences'] = "Preferências de Idiomas e Fusos Horários";
$GLOBALS['strUserInterfacePreferences'] = "Preferências da Interface de usuários";
$GLOBALS['strInvocationPreferences'] = "Preferências de invocação";
$GLOBALS['strAlreadyInstalled'] = "".MAX_PRODUCT_NAME.".\" já esta instalado neste sistema. Se você deseja configurá-lo acesse a<a href=\'account-index.php\'>interface de configuração</a>\";";
$GLOBALS['strAdminEmailHeaders'] = "Adicionar os seguintes cabeçalhos nos e-mails enviados pelo MAX_PRODUCT NAME";
$GLOBALS['strEmailAddressFrom'] = "Endereço de remetente de relatórios";
$GLOBALS['strUserProperties'] = "Dados do usuário";
$GLOBALS['strBack'] = "Voltar";
$GLOBALS['strUsernameToLink'] = "Nome do usuário do usuário que será vinculado";
$GLOBALS['strEmailToLink'] = "E-mail do usuário que será vinculado";
$GLOBALS['strNewUserWillBeCreated'] = "Novo usuário será criado";
$GLOBALS['strToLinkProvideEmail'] = "Para vincular o usuário, informe seu e-mail";
$GLOBALS['strToLinkProvideUsername'] = "Para vincular o usuário, informe o nome de usuário";
$GLOBALS['strPermissions'] = "Permissões";
$GLOBALS['strContactName'] = "Nome de contato";
$GLOBALS['strPwdRecReset'] = "Resetar senha";
$GLOBALS['strPwdRecResetPwdThisUser'] = "Resetar senha para este usuário";
$GLOBALS['keyLinkUser'] = "u";
$GLOBALS['strAllowCreateAccounts'] = "Permitir que este usuário crie novas contas";
$GLOBALS['strErrorWhileCreatingUser'] = "Erro ao criar usuário: %s";
$GLOBALS['strUserLinkedToAccount'] = "O usuário foi vinculado à conta";
$GLOBALS['strUserAccountUpdated'] = "Conta de usuário atualizada";
$GLOBALS['strUserUnlinkedFromAccount'] = "Vinculo de usuário com conta removido";
$GLOBALS['strUserWasDeleted'] = "Usuário removido";
$GLOBALS['strUserNotLinkedWithAccount'] = "Este usuário não esta vinculado a esta conta";
$GLOBALS['strWorkingAs'] = "Trabalhando como";
$GLOBALS['strWorkingFor'] = "%s para ....";
$GLOBALS['strCantDeleteOneAdminUser'] = "Você não pode remover um usuário. Pelo menos um usuário deve estar vinculado à conta de administração";
$GLOBALS['strWarnChangeBannerSize'] = "Alterar o tamanho do banner irá remover seu vínculo de qualquer zona que não for compatível com o novo tamanho, se a <strong>campanha</strong> deste banner estiver ligada a uma zona do novo tamanho, o banner será automaticamente vinculado.";
$GLOBALS['strLinkUserHelp'] = "<br /> Digite o nome de usuário. Para vincular <ul><li>usuário existente, digite o nome de usuário e clique em \"vincular usuário\"</li><li>novo usuário, digite o nome de usuário desejado e clique em \"vincular usuário\"</li></ul>";
$GLOBALS['strAuditNoData'] = "Nenhuma atividade dos usuários registrada do período escolhido.";
$GLOBALS['strCampaignGoTo'] = "Ir para página de campanhas";
$GLOBALS['strCampaignSetUp'] = "Configurar uma campanha hoje";
$GLOBALS['strCampaignNoRecords'] = "<li>Campanhas permitem agrupar qualquer número de banner de diversos tamanhos que possuam necessidades de publicação em comum</li> \\n<li>Economize tempo agrupando banners dentro de campanhas e não defina mais configurações de entrega uma a uma</li>  \\n<li>Verifique a <a class=\"site-link\" href=\"http://".OX_PRODUCT_DOCSURL."/inventory/advertisersAndCampaigns/campaigns\">Documentação de Campanhas</a>!</li>";
$GLOBALS['strCampaignNoDataTimeSpan'] = "Nenhuma campanha começou ou terminou no prazo escolhido";
$GLOBALS['strCampaignAuditNotActivated'] = "Para poder visualizar campanhas que iniciaram ou terminaram no prazo escolhido, os Rastros de Auditoria devem estar ligado";
$GLOBALS['strAuditTrailSetup'] = "Configurar o Rastreamento de Auditoria hoje";
$GLOBALS['strAuditTrailGoTo'] = "Ir para log de Auditoria";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>O Log de Auditoria permite verificar quem fez o que e quando. Ou, em outras palavras, ele aompanha todas mudanças de sistema do ".MAX_PRODUCT_NAME."</li> \n<li>Você esta vendo esta mensagem porque ativou o Log de Auditoria</li> \n<li>Quer saber mais detalhes? Leia a <a href='http://".OX_PRODUCT_DOCSURL."/settings/auditTrail' target='_blank'>Documentação de Log de Auditoria</a></li>";
$GLOBALS['strAdminAccess'] = "Acesso de administrador";
$GLOBALS['strOverallAdvertisers'] = "anunciante(s)";
$GLOBALS['strAdvertiserSignup'] = "Registro de Anunciantes";
$GLOBALS['strAdvertiserSignupDesc'] = "Registre-se para serviço próprio de Anunciante e pagamentos";
$GLOBALS['strOverallCampaigns'] = "campanha(s)";
$GLOBALS['strTotalRevenue'] = "Receita total";
$GLOBALS['strOpenadsImpressionsRemaining'] = "Impressões do ".MAX_PRODUCT_NAME." restantes";
$GLOBALS['strOpenadsImpressionsRemainingHelp'] = "O número de impressões restantes da campanha é muito pequeno para atender o número contratado pelo anunciante. Significa dizer que o número local de cliques é mais baixo que o número geral de cliques remanescentes e você deve aumentar o número de impressões contratadas pelo número que falta.";
$GLOBALS['strOpenadsClicksRemaining'] = "Cliques do ".MAX_PRODUCT_NAME." restantes";
$GLOBALS['strOpenadsConversionsRemaining'] = "Conversões do ".MAX_PRODUCT_NAME." restantes";
$GLOBALS['strChangeStatus'] = "Mudar estado";
$GLOBALS['strImpression'] = "Impressão";
$GLOBALS['strOverallBanners'] = "banner(s)";
$GLOBALS['strPeriod'] = "Período";
$GLOBALS['strWorksheets'] = "Planilhas";
$GLOBALS['strSwitchAccount'] = "Trocar para esta conta";
$GLOBALS['strAdditionalItems'] = "e itens adicionais";
$GLOBALS['strFor'] = "para";
?>