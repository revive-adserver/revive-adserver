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

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']  		= "ltr";
$GLOBALS['phpAds_TextAlignRight'] 		= "right";
$GLOBALS['phpAds_TextAlignLeft']  		= "left";
$GLOBALS['phpAds_CharSet']              = 'iso-8859-15';

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

$GLOBALS['strHome'] 				= "In�cio";
$GLOBALS['strHelp']					= "Ajuda";
$GLOBALS['strNavigation'] 			= "Menu";
$GLOBALS['strShortcuts'] 			= "Atalhos";
$GLOBALS['strAdminstration'] 		= "Invent�rio";
$GLOBALS['strMaintenance']			= "Manuten��o";
$GLOBALS['strProbability']			= "Probabilidade";
$GLOBALS['strInvocationcode']		= "C�digo Invocativo";
$GLOBALS['strBasicInformation'] 	= "Informa��o b�sica";
$GLOBALS['strContractInformation'] 	= "Informa��o contractual";
$GLOBALS['strLoginInformation'] 	= "Informa��o acesso";
$GLOBALS['strOverview']				= "Descri��o";
$GLOBALS['strSearch']				= "Pesquisar";
$GLOBALS['strHistory']				= "Historial";
$GLOBALS['strPreferences'] 			= "Prefer�ncias";
$GLOBALS['strDetails']				= "Detalhes";
$GLOBALS['strCompact']				= "Compacto";
$GLOBALS['strVerbose']				= "Completo";
$GLOBALS['strUser']					= "Utilizador";
$GLOBALS['strEdit']					= "Editar";
$GLOBALS['strCreate']				= "Criar";
$GLOBALS['strDuplicate']			= "Duplicar";
$GLOBALS['strMoveTo']				= "Mover para";
$GLOBALS['strDelete'] 				= "Apagar";
$GLOBALS['strActivate']				= "Activar";
$GLOBALS['strDeActivate'] 			= "Desactivar";
$GLOBALS['strConvert']				= "Converter";
$GLOBALS['strRefresh']				= "Renovar";
$GLOBALS['strSaveChanges']		 	= "Salvar Altera��es";
$GLOBALS['strUp'] 					= "Acima";
$GLOBALS['strDown'] 				= "Abaixo";
$GLOBALS['strSave'] 				= "Salvar";
$GLOBALS['strCancel']				= "Cancelar";
$GLOBALS['strPrevious'] 			= "Anterior";
$GLOBALS['strNext'] 				= "Seguinte";
$GLOBALS['strYes']					= "Sim";
$GLOBALS['strNo']					= "N�o";
$GLOBALS['strNone'] 				= "Nenhum";
$GLOBALS['strCustom']				= "Definir";
$GLOBALS['strDefault'] 				= "Defeito";
$GLOBALS['strOther']				= "Outro";
$GLOBALS['strUnknown']				= "Desconhecido";
$GLOBALS['strUnlimited'] 			= "Ilimitado";
$GLOBALS['strUntitled']				= "Sem T�tulo";
$GLOBALS['strAll'] 					= "tudo";
$GLOBALS['strAvg'] 					= "M�dia";
$GLOBALS['strAverage']				= "M�dia";
$GLOBALS['strOverall'] 				= "Geral";
$GLOBALS['strTotal'] 				= "Total";
$GLOBALS['strActive'] 				= "activa";
$GLOBALS['strFrom']					= "De";
$GLOBALS['strTo']					= "para";
$GLOBALS['strLinkedTo'] 			= "ligado a";
$GLOBALS['strDaysLeft'] 			= "Dias restantes";
$GLOBALS['strCheckAllNone']			= "Marcar tudo / nada";
$GLOBALS['strKiloByte']				= "KB";
$GLOBALS['strExpandAll']			= "Expandir tudo";
$GLOBALS['strCollapseAll']			= "Comprimir tudo";
$GLOBALS['strShowAll']				= "Mostrar tudo";
$GLOBALS['strNoAdminInterface']		= "Servi�o indispon�vel...";
$GLOBALS['strFilterBySource']		= "filtrar pela fonte";
$GLOBALS['strFieldContainsErrors']		= "Os seguintes campos cont�m erros:";
$GLOBALS['strFieldFixBeforeContinue1']	= "Antes de poder continuar tem de";
$GLOBALS['strFieldFixBeforeContinue2']	= "corrigir esses erros.";
$GLOBALS['strDelimiter']				= "Delimitador";

// Properties
$GLOBALS['strName']					= "Nome";
$GLOBALS['strSize']					= "Dimens�es";
$GLOBALS['strWidth'] 				= "Largura";
$GLOBALS['strHeight'] 				= "Altura";
$GLOBALS['strURL2']					= "URL";
$GLOBALS['strTarget']				= "Destino";
$GLOBALS['strLanguage'] 			= "Idioma";
$GLOBALS['strDescription'] 			= "Descri��o";
$GLOBALS['strID']					= "ID";

// Login & Permissions
$GLOBALS['strAuthentification'] 	= "Autentica��o";
$GLOBALS['strWelcomeTo']			= "Bem vindo(a) a";
$GLOBALS['strEnterUsername']		= "Introduza seu nome de utilizador e senha para entrar";
$GLOBALS['strEnterBoth']			= "Por favor introduza utilizador e senha";
$GLOBALS['strEnableCookies']		= "Voc� tem de ter os <i>cookies</i> activos para usar ".$phpAds_productname;
$GLOBALS['strLogin'] 				= "Acesso";
$GLOBALS['strLogout'] 				= "Sair";
$GLOBALS['strUsername'] 			= "Utilizador";
$GLOBALS['strPassword']				= "Senha";
$GLOBALS['strAccessDenied']			= "Acesso negado";
$GLOBALS['strPasswordWrong']		= "Senha incorrecta";
$GLOBALS['strNotAdmin']				= "Voc� pode n�o ter previl�gios suficientes";
$GLOBALS['strDuplicateClientName']	= "O utilizador que introduziu j� existe, escolha outro por favor.";

// General advertising
$GLOBALS['strImpressions'] 				= "Visualiza��es";
$GLOBALS['strClicks']				= "Cliques";
$GLOBALS['strCTRShort'] 			= "CTR";
$GLOBALS['strCTR'] 					= "Click-Through Ratio";
$GLOBALS['strTotalViews'] 			= "Total ".$GLOBALS['strImpressions'];
$GLOBALS['strTotalClicks'] 			= "Total ".$GLOBALS['strClicks'];
$GLOBALS['strViewCredits'] 			= "Cr�ditos de ".$GLOBALS['strImpressions'];
$GLOBALS['strClickCredits'] 		= "Cr�ditos de ".$GLOBALS['strClicks'];

// Time and date related
$GLOBALS['strDate'] 				= "Data";
$GLOBALS['strToday'] 				= "Hoje";
$GLOBALS['strDay']					= "Dia";
$GLOBALS['strDays']					= "Dias";
$GLOBALS['strLast7Days']			= "�ltimos 7 dias";
$GLOBALS['strWeek'] 				= "Semana";
$GLOBALS['strWeeks']				= "Semanas";
$GLOBALS['strMonths']				= "Meses";
$GLOBALS['strThisMonth'] 			= "Este m�s";
$GLOBALS['strMonth'] 				= array("Janeiro","Fevereiro","Mar�o","Abril","Maio","Junho","Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
$GLOBALS['strDayShortCuts'] 		= array("Dom","Seg","Ter","Qua","Qui","Sex","S�b");
$GLOBALS['strHour']					= "Hora";
$GLOBALS['strSeconds']				= "segundos";
$GLOBALS['strMinutes']				= "minutos";
$GLOBALS['strHours']				= "horas";
$GLOBALS['strTimes']				= "tempos";

// Advertiser
$GLOBALS['strClient']				= "Anunciante";
$GLOBALS['strClients'] 				= "Anuncioantes";
$GLOBALS['strClientsAndCampaigns']	= "Anunciantes & Campanhas";
$GLOBALS['strAddClient'] 			= "Adicionar anunciante";
$GLOBALS['strTotalClients'] 		= "Total de anunciantes";
$GLOBALS['strClientProperties']		= "Propriedades do anunciante";
$GLOBALS['strClientHistory']		= "Hist�rico do anunciante";
$GLOBALS['strNoClients']			 		= "N�o existem anunciantes definidos";
$GLOBALS['strConfirmDeleteClient'] 			= "Quer mesmo remover este anunciante?";
$GLOBALS['strConfirmResetClientStats']		= "Quer mesmo remover as estat�sticas deste anunciante?";
$GLOBALS['strHideInactiveAdvertisers']		= "Ocultar anunciantes inactivos";
$GLOBALS['strInactiveAdvertisersHidden']	= "anunciante(s) inactivo(s) ocultos";

// Advertisers properties
$GLOBALS['strContact'] 						= "Contacto";
$GLOBALS['strEMail'] 						= "E-mail";
$GLOBALS['strSendAdvertisingReport']		= "Enviar relat�rio via e-mail";
$GLOBALS['strNoDaysBetweenReports']			= "N�mero de dias entre relat�rios";
$GLOBALS['strSendDeactivationWarning']  	= "Enviar aviso quando a campanha f�r desactivada";
$GLOBALS['strAllowClientModifyInfo'] 		= "Permitir que o utilizador modifique os seus dados";
$GLOBALS['strAllowClientModifyBanner'] 		= "Permitir que o utilizador modifique os seus an�ncios";
$GLOBALS['strAllowClientAddBanner'] 		= "Permitir que o utilizador adicione os seus an�ncios";
$GLOBALS['strAllowClientDisableBanner'] 	= "Permitir que o utilizador desactive os seus an�ncios";
$GLOBALS['strAllowClientActivateBanner'] 	= "Permitir que o utilizador active os seus an�ncios";

// Campaign
$GLOBALS['strCampaign']						= "Campanha";
$GLOBALS['strCampaigns']					= "Campanhas";
$GLOBALS['strTotalCampaigns'] 				= "Total campanhas";
$GLOBALS['strActiveCampaigns'] 				= "Campanhas Activas";
$GLOBALS['strAddCampaign'] 					= "Adicionar campanha";
$GLOBALS['strCreateNewCampaign']			= "Criar campanha";
$GLOBALS['strModifyCampaign']				= "Modificar campanha";
$GLOBALS['strMoveToNewCampaign']			= "Mover para nova campanha";
$GLOBALS['strBannersWithoutCampaign']		= "An�ncios sem campanha";
$GLOBALS['strDeleteAllCampaigns']			= "Remover todas as campanhas";
$GLOBALS['strCampaignStats']				= "Estat�sticas da campanha";
$GLOBALS['strCampaignProperties']			= "Propriedades da campanha";
$GLOBALS['strCampaignOverview']				= "Descri��o da campanha";
$GLOBALS['strCampaignHistory']				= "Hist�rico da campanha";
$GLOBALS['strNoCampaigns']					= "N�o existem campanhas definidas";
$GLOBALS['strConfirmDeleteAllCampaigns']	= "Quer mesmo remover todas as campanhas deste anunciante?";
$GLOBALS['strConfirmDeleteCampaign']		= "Quer mesmo remover esta campanha?";
$GLOBALS['strHideInactiveCampaigns']		= "Ocultar campanhas inactivas";
$GLOBALS['strInactiveCampaignsHidden']		= "campanha(s) inactiva(s) oculta(s)";

// Campaign properties
$GLOBALS['strDontExpire']				= "N�o expirar esta campanha em nenhuma data espec�fica";
$GLOBALS['strActivateNow'] 				= "Activar esta campanha imediatamente";
$GLOBALS['strLow']						= "Baixa";
$GLOBALS['strHigh']						= "Alta";
$GLOBALS['strExpirationDate']			= "Data de expira��o";
$GLOBALS['strActivationDate']			= "Data de activa��o";
$GLOBALS['strImpressionsPurchased'] 			= $GLOBALS['strImpressions']." restantes";
$GLOBALS['strClicksPurchased'] 			= $GLOBALS['strClicks']." restantes";
$GLOBALS['strCampaignWeight']			= "Peso da campanha";
$GLOBALS['strHighPriority']				= "Mostrar an�ncios desta campanha com alta prioridade.<br />Se usar esta op��o ".$phpAds_productname." tentar� distribuir igualmente o n�mero de ".$GLOBALS['strImpressions']." durante o decurso do dia.";
$GLOBALS['strLowPriority']				= "Mostrar an�ncios desta campanha com baixa prioridade.<br />Esta campanha ser� usada para ocupar as sobras de ".$GLOBALS['strImpressions']." deixadas pelas campanha priorit�rias.";
$GLOBALS['strTargetLimitAdviews']		= "Limitar o n�mero de ".$GLOBALS['strImpressions']." a ";
$GLOBALS['strTargetPerDay']				= "por dia.";
$GLOBALS['strPriorityAutoTargeting']	= "Distribua as restantes ".$GLOBALS['strImpressions']." igualmente pelo restante n�mero de dias. O n�mero previsto de ".$GLOBALS['strImpressions']." ser� definido de acordo cada dia.";

// Banners (General)
$GLOBALS['strBanner'] 					= "An�ncio";
$GLOBALS['strBanners'] 					= "An�ncios";
$GLOBALS['strAddBanner'] 				= "Adicionar an�ncio";
$GLOBALS['strModifyBanner'] 			= "Modificar an�ncio";
$GLOBALS['strActiveBanners'] 			= "Activar an�ncio";
$GLOBALS['strTotalBanners'] 			= "Total an�ncios";
$GLOBALS['strShowBanner']				= "Mostrar an�ncios";
$GLOBALS['strShowAllBanners']	 		= "Mostrar todos os an�ncios";
$GLOBALS['strShowBannersNoAdClicks']	= "Mostrar an�ncios sem ".$GLOBALS['strClicks'];
$GLOBALS['strShowBannersNoAdViews']		= "Mostrar an�ncios sem ".$GLOBALS['strImpressions'];
$GLOBALS['strDeleteAllBanners']	 		= "Apagar todos os an�ncios";
$GLOBALS['strActivateAllBanners']		= "Activar todos os an�ncios";
$GLOBALS['strDeactivateAllBanners']		= "Desactivar todos os an�ncios";
$GLOBALS['strBannerOverview']			= "Descri��o do an�ncio";
$GLOBALS['strBannerProperties']			= "Propriedades do an�ncio";
$GLOBALS['strBannerHistory']			= "Hist�rico do an�ncio";
$GLOBALS['strBannerNoStats'] 			= "N�o existem estat�sticas para ese an�ncio";
$GLOBALS['strNoBanners']				= "N�o existem an�ncios definidos";
$GLOBALS['strConfirmDeleteBanner']		= "Quer mesmo remover este an�ncio?";
$GLOBALS['strConfirmDeleteAllBanners']	= "Quer mesmo remover todos os an�ncios pertencentes a esta campanha?";
$GLOBALS['strConfirmResetBannerStats']	= "Quer mesmo remover todas as estat�sticas pertencentes a esta campanha?";
$GLOBALS['strShowParentCampaigns']		= "Mostrar campanhas superiores";
$GLOBALS['strHideParentCampaigns']		= "Ocultar campanhas superiores";
$GLOBALS['strHideInactiveBanners']		= "Ocultar an�ncios inactivos";
$GLOBALS['strInactiveBannersHidden']	= "an�ncios inactivos ocultos";

// Banner (Properties)
$GLOBALS['strChooseBanner'] 	= "Escolha, por favor, o tipo de an�ncio";
$GLOBALS['strMySQLBanner'] 		= "Local (SQL)";
$GLOBALS['strWebBanner'] 		= "Local (Webserver)";
$GLOBALS['strURLBanner'] 		= "Externo";
$GLOBALS['strHTMLBanner'] 		= "HTML";
$GLOBALS['strTextBanner'] 		= "Texto";
$GLOBALS['strAutoChangeHTML']	= "HTML alternativo para permitir controle de ".$GLOBALS['strClicks'];
$GLOBALS['strUploadOrKeep']		= "pretende manter a <br />imagem existe, ou quer<br />escolher outra?";
$GLOBALS['strNewBannerFile'] 	= "Selecione a image que quer<br />usar neste an�ncio<br /><br />";
$GLOBALS['strNewBannerURL'] 	= "URL da imagem (incl. http://)";
$GLOBALS['strURL'] 				= "URL do destino(incl. http://)";
$GLOBALS['strHTML'] 			= "HTML";
$GLOBALS['strTextBelow'] 		= "Texto abaixo da imagem";
$GLOBALS['strKeyword'] 			= "Palavras-chave";
$GLOBALS['strWeight'] 			= "Peso";
$GLOBALS['strAlt'] 				= "Texto <i>Alt</i>";
$GLOBALS['strStatusText']		= "Texto <i>Status</i>";
$GLOBALS['strBannerWeight']		= "Peso do an�ncio";

// Banner (swf)
$GLOBALS['strCheckSWF']			= "Verifique por <i>links</i> dentro do ficheiro Flash";
$GLOBALS['strConvertSWFLinks']	= "Converta Flash <i>links</i>";
$GLOBALS['strConvertSWF']		= "<br />O ficheiro Flash que acabou de carregar  cont�m <i>urls</i>. ".$phpAds_productname." n�o conseguir� calcular o n�mero de ".$GLOBALS['strClicks']." para este an�ncio a menos que os converta. Abaixo encontrar� uma lista de todos os <i>urls</i> que se encontram no ficheiro. Se desejar convert�-los, clique simplesmente em <b>Converter</b>, caso contr�rio clique <b>Cancelar</b>.<br /><br />Nota: se clicar <b>Converter</b> o ficheiro Flash que acabou de carregar ser� fisicamente alterado. <br />Por favor mantenha uma c�pia de seguran�a do ficheiro original. N�o obstante a vers�o em que o ficheiro tenha sido criado, o ficheiro resultante necessitar� o <i>Flash 4 player</i> (ou maior) para visualiza��o correcta.<br /><br />";
$GLOBALS['strCompressSWF']		= "Comprima o ficheiro SWF para recep��o mais r�pida (Flash 6 player necess�rio)";

// Banner (network)
$GLOBALS['strBannerNetwork']	= "Template HTML";
$GLOBALS['strChooseNetwork']	= "Escolha o <i>modelo</i> que quer usar";
$GLOBALS['strMoreInformation']	= "Mais informa��o...";
$GLOBALS['strRichMedia']		= "Richmedia";
$GLOBALS['strTrackAdClicks']	= "Controlar ".$GLOBALS['strClicks'];

// Display limitations
$GLOBALS['strModifyBannerAcl'] 			= "Op��es de entrega";
$GLOBALS['strACL'] 						= "Entrega";
$GLOBALS['strACLAdd'] 					= "Adicionar nova limita��o";
$GLOBALS['strNoLimitations']			= "Sem limita��es";
$GLOBALS['strApplyLimitationsTo']		= "Aplicar limita��es a";
$GLOBALS['strRemoveAllLimitations']		= "Remover todas as limita��es";
$GLOBALS['strEqualTo']					= "� igual a";
$GLOBALS['strDifferentFrom']			= "� diferente de";
$GLOBALS['strAND']						= "AND";  						// logical operator
$GLOBALS['strOR']						= "OR"; 						// logical operator
$GLOBALS['strOnlyDisplayWhen']			= "S� mostrar este an�ncio quando:";
$GLOBALS['strWeekDay'] 					= "Dia da Semana";
$GLOBALS['strTime'] 					= "Hora";
$GLOBALS['strUserAgent'] 				= "Useragent";
$GLOBALS['strDomain'] 					= "Dominio";
$GLOBALS['strClientIP'] 				= "IP do Cliente";
$GLOBALS['strSource'] 					= "Fonte";
$GLOBALS['strBrowser'] 					= "Browser";
$GLOBALS['strOS'] 						= "Sistema Operativo";
$GLOBALS['strCountry'] 					= "Pa�s";
$GLOBALS['strContinent'] 				= "Continente";
$GLOBALS['strDeliveryLimitations']		= "Limita��es de entrega";
$GLOBALS['strDeliveryCapping']			= "Limites de repeti��o";
$GLOBALS['strTimeCapping']				= "Uma vez que este an�ncio tenha sido mostrado a um dado visitante, n�o mostrar por:";
$GLOBALS['strImpressionCapping']		= "N�o mostrar este an�ncio ao mesmo visitante mais do que:";

// Publisher
$GLOBALS['strAffiliate']				= "Editor";
$GLOBALS['strAffiliates']				= "Editores";
$GLOBALS['strAffiliatesAndZones']		= "Editores & Zonas";
$GLOBALS['strAddNewAffiliate']			= "Adicionar editor";
$GLOBALS['strAddAffiliate']				= "Criar editor";
$GLOBALS['strAffiliateProperties']		= "Propriedades do editor";
$GLOBALS['strAffiliateOverview']		= "Descri��o do editor";
$GLOBALS['strAffiliateHistory']			= "Hist�rico do editor";
$GLOBALS['strZonesWithoutAffiliate']	= "Zonas sem editor";
$GLOBALS['strMoveToNewAffiliate']		= "Mover para novo editor";
$GLOBALS['strNoAffiliates']				= "N�o existem editores definidos";
$GLOBALS['strConfirmDeleteAffiliate']	= "Quer mesmo apagar este editor?";
$GLOBALS['strMakePublisherPublic']		= "As zonas pertencentes a este editor s�o p�blicas";

// Publisher (properties)
$GLOBALS['strWebsite']						= "Website";
$GLOBALS['strAllowAffiliateModifyInfo'] 	= "Permitir a este utilizador que modifique as suas defini��es";
$GLOBALS['strAllowAffiliateModifyZones'] 	= "Permitir a este utilizador que modifique as suas zonas";
$GLOBALS['strAllowAffiliateLinkBanners'] 	= "Permitir a este utilizador que ligue an�ncios �s suas zonas";
$GLOBALS['strAllowAffiliateAddZone'] 		= "Permitir a este utilizador que defina novas zonas";
$GLOBALS['strAllowAffiliateDeleteZone'] 	= "Permitir a este utilizador que apague zonas";

// Zone
$GLOBALS['strZone']					= "Zona";
$GLOBALS['strZones']				= "Zonas";
$GLOBALS['strAddNewZone']			= "Adicionar zona";
$GLOBALS['strAddZone']				= "Criar zona";
$GLOBALS['strModifyZone']			= "Modificar zona";
$GLOBALS['strLinkedZones']			= "Zonas conectadas";
$GLOBALS['strZoneOverview']			= "Descri��o da zona";
$GLOBALS['strZoneProperties']		= "Propriedades da zona";
$GLOBALS['strZoneHistory']			= "Hist�rico da zona";
$GLOBALS['strNoZones']				= "N�o existem zonas definidas";
$GLOBALS['strConfirmDeleteZone']	= "Quer mesmo remover esta zona?";
$GLOBALS['strZoneType']				= "Zona tipo";
$GLOBALS['strBannerButtonRectangle']		= "An�ncio, Bot�o ou Rect�ngulo";
$GLOBALS['strInterstitial']			= "Intersticial ou DHTML Flutuante";
$GLOBALS['strPopup']				= "Popup";
$GLOBALS['strTextAdZone']			= "An�ncio de Texto";
$GLOBALS['strShowMatchingBanners']	= "Mostrar an�ncios compat�veis";
$GLOBALS['strHideMatchingBanners']	= "Ocultar an�ncios compat�veis";

// Advanced zone settings
$GLOBALS['strAdvanced']				= "Avan�ado";
$GLOBALS['strChains']				= "Liga��es";
$GLOBALS['strChainSettings']		= "Defini��o de Liga��es";
$GLOBALS['strZoneNoDelivery']		= "Se nenhum an�ncio desta zona<br />puder ser entregue deve...";
$GLOBALS['strZoneStopDelivery']		= "Parar entrega e n�o mostrar an�ncio";
$GLOBALS['strZoneOtherZone']		= "Mostrar de outra zona";
$GLOBALS['strZoneUseKeywords']		= "Selecionar an�ncio usando palavras conforme definidas abaixo";
$GLOBALS['strZoneAppend']			= "Sempre adicionar o seguinte c�digo de invoca��o de popup ou interstitial para an�ncios mostrados por esta zona";
$GLOBALS['strAppendSettings']		= "Adicionar e pr�-adicionar defini��es";
$GLOBALS['strZonePrependHTML']		= "Sempre pr�-adicionar o c�digo HTML aos an�ncios em texto visualizados nesta zona";
$GLOBALS['strZoneAppendHTML']		= "Sempre adicionar o c�digo HTML aos an�ncios em texto visualizados nesta zona";

// Linked banners/campaigns
$GLOBALS['strSelectZoneType']			= "Escolha o tipo de Zona";
$GLOBALS['strBannerSelection']			= "Selec��o de An�ncios";
$GLOBALS['strCampaignSelection']		= "Selec��o de Campanhas";
$GLOBALS['strInteractive']				= "Interactiva";
$GLOBALS['strRawQueryString']			= "Palavra-Chave";
$GLOBALS['strIncludedBanners']			= "An�ncios inclu�dos";
$GLOBALS['strLinkedBannersOverview']	= "Descri��o de an�ncios";
$GLOBALS['strLinkedBannerHistory']		= "Hist�rico de an�ncios";
$GLOBALS['strNoZonesToLink']			= "N�o existem zonas dispon�veis �s quais ligar este an�ncio";
$GLOBALS['strNoBannersToLink']			= "N�o existem an�ncios dispon�veis que possam ser ligados a esta zona";
$GLOBALS['strNoLinkedBanners']			= "N�o existem an�ncios dispon�veis que estejam ligados a esta zona";
$GLOBALS['strMatchingBanners']			= "{count} an�ncios";
$GLOBALS['strNoCampaignsToLink']		= "N�o existem campanhas dispon�veis que possam ser ligados a esta zona";
$GLOBALS['strNoZonesToLinkToCampaign']  = "N�o existem zonas dispon�veis �s quais ligar esta campanha";
$GLOBALS['strSelectBannerToLink']		= "Selecione o an�ncio que quer ligar a esta zona:";
$GLOBALS['strSelectCampaignToLink']		= "Selecione a campanha que quer ligar a esta zona:";

// Statistics
$GLOBALS['strStats'] 				= "Estat�sticas";
$GLOBALS['strNoStats']				= "N�o existem estat�sticas dispon�veis";
$GLOBALS['strConfirmResetStats']	= "Quer realmente apagar todas as estat�sticas?";
$GLOBALS['strGlobalHistory']		= "Hist�rico global";
$GLOBALS['strDailyHistory']			= "Hist�rico di�rio";
$GLOBALS['strDailyStats'] 			= "Estat�sticas di�rias";
$GLOBALS['strWeeklyHistory']		= "Hist�rico semanal";
$GLOBALS['strMonthlyHistory']		= "Hist�rico mensal";
$GLOBALS['strCreditStats'] 			= "Estat�sticas de cr�ditos";
$GLOBALS['strDetailStats'] 			= "Estat�sticas detalhadas";
$GLOBALS['strTotalThisPeriod']		= "Total do per�odo";
$GLOBALS['strAverageThisPeriod']	= "M�dia do per�odo";
$GLOBALS['strDistribution']			= "Distribui��o";
$GLOBALS['strResetStats'] 			= "Re-iniciar estat�sticas";
$GLOBALS['strSourceStats']			= "Tipo de estat�sticas";
$GLOBALS['strSelectSource']			= "Selecione o tipo que quer v�r:";

// Hosts
$GLOBALS['strHosts']				= "Servidores";
$GLOBALS['strTopTenHosts'] 			= "Top dos Servidores";

// Expiration
$GLOBALS['strExpired']				= "Expirado";
$GLOBALS['strExpiration'] 			= "Expira��o";
$GLOBALS['strNoExpiration'] 		= "Sem data para expirar";
$GLOBALS['strEstimated'] 			= "Expira��o estimada";

// Reports
$GLOBALS['strReports']				= "Relat�rios";
$GLOBALS['strSelectReport']			= "Selecione que relat�rio quer gerar";

// Userlog
$GLOBALS['strUserLog']				= "Registo de Utilizadores";
$GLOBALS['strUserLogDetails']		= "Detalhes do Registo";
$GLOBALS['strDeleteLog']			= "Apagar registo";
$GLOBALS['strAction']				= "Ac��o";
$GLOBALS['strNoActionsLogged']		= "Nenhuma ac��o registada";

// Code generation
$GLOBALS['strGenerateBannercode']	= "Gerar C�digo";
$GLOBALS['strChooseInvocationType']	= "Escolha o tipo de invoca��o";
$GLOBALS['strGenerate']				= "Gerar";
$GLOBALS['strParameters']			= "Par�metros";
$GLOBALS['strFrameSize']			= "Dimens�o da Janela";
$GLOBALS['strBannercode']			= "C�digo";

// Errors
$GLOBALS['strMySQLError'] 			= "Erro SQL:";
$GLOBALS['strLogErrorClients'] 		= "[phpAds] Um erro ocorreu enquanto a pesquisar Anunciantes da base de dados.";
$GLOBALS['strLogErrorBanners'] 		= "[phpAds] Um erro ocorreu enquanto a pesquisar An�ncios da base de dados.";
$GLOBALS['strLogErrorViews'] 		= "[phpAds] Um erro ocorreu enquanto a pesquisar Visualiza��es da base de dados.";
$GLOBALS['strLogErrorClicks'] 		= "[phpAds] Um erro ocorreu enquanto a pesquisar Cliques da base de dados.";
$GLOBALS['strErrorViews'] 			= "Tem de definir o n�mero de visualiza��es ou selecionar Ilimitadas !";
$GLOBALS['strErrorNegViews'] 		= "Visualiza��es negativas n�o s�o permitidas";
$GLOBALS['strErrorClicks'] 			= "Tem de definir o n�mero de visualiza��es ou selecionar Ilimitadoas !";
$GLOBALS['strErrorNegClicks'] 		= "Cliques negativos n�o s�o permitidos";
$GLOBALS['strNoMatchesFound']		= "N�o foram encontrados registos";
$GLOBALS['strErrorOccurred']		= "Ocorreu um erro";
$GLOBALS['strErrorUploadSecurity']	= "Detectado um poss�vel problema de seguran�a, importa��o bloqueada!";
$GLOBALS['strErrorUploadBasedir']	= "N�o � poss�vel aceder ao ficheiro importado, provavelmente devido a restri��es de 'safemode' ou 'open_basedir'";
$GLOBALS['strErrorUploadUnknown']	= "N�o � poss�vel aceder ao ficheiro importado, devido a raz�o desconhecida. Verifique a sua configura��o do PHP";
$GLOBALS['strErrorStoreLocal']		= "Um erro ocorreu ao tentar salvar o 'an�ncio' na directoria local. Isto � um prov�vel resultado de m� configura��o do direito de acesso � mesma.";
$GLOBALS['strErrorStoreFTP']		= "Um erro ocorreu ao tentar importar o ficheiro para o servidor FTP. Isto pode ser causado por indisponibilidade do servidor, ou devido a uma m� configura��o do servidor FTP.";

// E-mail
$GLOBALS['strMailSubject'] 				= "Relat�rio de Anunciante";
$GLOBALS['strAdReportSent']				= "Relat�rio de Anunciante enviado";
$GLOBALS['strMailSubjectDeleted'] 		= "An�ncios desactivados";
$GLOBALS['strMailHeader'] 				= "Caro(a) {contact},\n";
$GLOBALS['strMailBannerStats'] 			= "Abaixo encontrar� as estat�sticas para {clientname}:";
$GLOBALS['strMailFooter'] 				= "Com os melhores cumprimentos,\n   {adminfullname}";
$GLOBALS['strMailClientDeactivated']	= "Os seguintes an�ncios foram desactivados porque";
$GLOBALS['strMailNothingLeft'] 			= "Se quiser continuar a anunciar no nosso website, contacte-nos.\nTeremos todo o prazer o receber novamente.";
$GLOBALS['strClientDeactivated']		= "A campanha est� actualmente inactiva porque";
$GLOBALS['strBeforeActivate']			= "a data de activa��o ainda n�o foi atingida";
$GLOBALS['strAfterExpire']				= "a data de expira��o foi atingida";
$GLOBALS['strNoMoreClicks']				= "n�o tem mais Cliques adquiridos";
$GLOBALS['strNoMoreViews']				= "n�o tem mais Visualiza��es adquiridas";
$GLOBALS['strWarnClientTxt']			= "Os Cliques ou Visualizacoes que restam para os seus An�ncios est�o abaixo de {limit}. \nOs seus an�ncios ser�o desactivados quando acabarem os Cliques ou as Visualiza��es adquiridas. ";
$GLOBALS['strImpressionsClicksLow']			= "Visualizacoes/Cliques est�o baixos";
$GLOBALS['strNoViewLoggedInInterval']   = "Nenhuma Visualiza��o foi registada durante o per�odo deste relat�rio";
$GLOBALS['strNoClickLoggedInInterval']  = "Nenhum Clique foi registado durante o per�odo deste relat�rio";
$GLOBALS['strMailReportPeriod']			= "Este relat�rio inclui estat�sticas desde {startdate} at� {enddate}.";
$GLOBALS['strMailReportPeriodAll']		= "Este relat�rio inclui todas as estat�sticas at� {enddate}.";
$GLOBALS['strNoStatsForCampaign'] 		= "N�o existem estat�sticas dispon�veis para esta campanha";

// Priority
$GLOBALS['strPriority']				= "Prioridade";

// Settings
$GLOBALS['strSettings'] 			= "Defini��es";
$GLOBALS['strGeneralSettings']		= "Defini��es gerais";
$GLOBALS['strMainSettings']			= "Defini��es principais";
$GLOBALS['strAdminSettings']		= "Defini��es de administra��o";

// Product Updates
$GLOBALS['strProductUpdates']		= "Actualiza��o do Sistema";

?>
