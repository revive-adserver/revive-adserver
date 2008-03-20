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
$GLOBALS['phpAds_TextDirection']  			= "ltr";
$GLOBALS['phpAds_TextAlignRight'] 			= "right";
$GLOBALS['phpAds_TextAlignLeft']  			= "left";

$GLOBALS['phpAds_DecimalPoint']				= '.';
$GLOBALS['phpAds_ThousandsSeperator']		= ',';


// Date & time configuration
$GLOBALS['date_format']						= "%m/%d/%Y";
$GLOBALS['time_format']						= "%H:%M:%S";
$GLOBALS['minute_format']					= "%H:%M";
$GLOBALS['month_format']					= "%m/%Y";
$GLOBALS['day_format']						= "%m/%d";
$GLOBALS['week_format']						= "%W/%Y";
$GLOBALS['weekiso_format']					= "%V/%G";



/*-------------------------------------------------------*/
/* Translations                                          */
/*-------------------------------------------------------*/

$GLOBALS['strHome'] 						= "Home";
$GLOBALS['strHelp']							= "Ayuda";
$GLOBALS['strNavigation'] 					= "Navegación";
$GLOBALS['strShortcuts'] 					= "Atajos";
$GLOBALS['strAdminstration'] 				= "Inventario";
$GLOBALS['strMaintenance']					= "Mantenimiento";
$GLOBALS['strProbability']					= "Probabilidad";
$GLOBALS['strInvocationcode']				= "Código";
$GLOBALS['strBasicInformation'] 			= "Información básica";
$GLOBALS['strContractInformation'] 			= "Contraer información";
$GLOBALS['strLoginInformation'] 			= "Login info";
$GLOBALS['strOverview']						= "Resumen";
$GLOBALS['strSearch']						= "Buscar";
$GLOBALS['strHistory']						= "Historial";
$GLOBALS['strPreferences'] 					= "Preferencias";
$GLOBALS['strDetails']						= "Detalles";
$GLOBALS['strCompact']						= "Compactar";
$GLOBALS['strVerbose']						= "Verbose";
$GLOBALS['strUser']							= "Usuario";
$GLOBALS['strEdit']							= "Editar";
$GLOBALS['strCreate']						= "Crear";
$GLOBALS['strDuplicate']					= "Duplicar";
$GLOBALS['strMoveTo']						= "Mover a";
$GLOBALS['strDelete'] 						= "Borrar";
$GLOBALS['strActivate']						= "Activar";
$GLOBALS['strDeActivate'] 					= "Desactivar";
$GLOBALS['strConvert']						= "Convertir";
$GLOBALS['strRefresh']						= "Actualizar";
$GLOBALS['strSaveChanges']		 			= "Guardar Cambios";
$GLOBALS['strUp'] 							= "Arriba";
$GLOBALS['strDown'] 						= "Abajo";
$GLOBALS['strSave'] 						= "Guardar";
$GLOBALS['strCancel']						= "Cancelar";
$GLOBALS['strPrevious'] 					= "Anterior";
$GLOBALS['strNext'] 						= "Siguiente";
$GLOBALS['strYes']							= "Si";
$GLOBALS['strNo']							= "No";
$GLOBALS['strNone'] 						= "Nada";
$GLOBALS['strCustom']						= "Común";
$GLOBALS['strDefault'] 						= "Predeterminado";
$GLOBALS['strOther']						= "Otro";
$GLOBALS['strUnknown']						= "Desconocido";
$GLOBALS['strUnlimited'] 					= "Ilimitado";
$GLOBALS['strUntitled']						= "Intitulado";
$GLOBALS['strAll'] 							= "todo";
$GLOBALS['strAvg'] 							= "Prom.";
$GLOBALS['strAverage']						= "Promedio";
$GLOBALS['strOverall'] 						= "General";
$GLOBALS['strTotal'] 						= "Total";
$GLOBALS['strActive'] 						= "activo";
$GLOBALS['strFrom']							= "De";
$GLOBALS['strTo']							= "a";
$GLOBALS['strLinkedTo'] 					= "relacionado a";
$GLOBALS['strDaysLeft'] 					= "Días restantes";
$GLOBALS['strCheckAllNone']					= "Checkea todo / nada";
$GLOBALS['strKiloByte']						= "KB";
$GLOBALS['strExpandAll']					= "Expandir todo";
$GLOBALS['strCollapseAll']					= "Contraer todo";
$GLOBALS['strShowAll']						= "Ver todo";
$GLOBALS['strNoAdminInterface']				= "Servicio no disponible...";
$GLOBALS['strFilterBySource']				= "filtrar por fuente";
$GLOBALS['strDelimiter']			= "Delimitador";

// Properties
$GLOBALS['strName']							= "Nombre";
$GLOBALS['strSize']							= "Tamaño";
$GLOBALS['strWidth'] 						= "Ancho";
$GLOBALS['strHeight'] 						= "Alto";
$GLOBALS['strURL2']							= "URL";
$GLOBALS['strTarget']						= "Target";
$GLOBALS['strLanguage'] 					= "Idioma";
$GLOBALS['strDescription'] 					= "Descripción";
$GLOBALS['strID']				 			= "ID";


// Login & Permissions
$GLOBALS['strAuthentification'] 			= "Autenticación";
$GLOBALS['strWelcomeTo']					= "Bienvenido a";
$GLOBALS['strEnterUsername']				= "Ingrese su Usuario y Password para loguearse";
$GLOBALS['strLogin'] 						= "Ingresar";
$GLOBALS['strLogout'] 						= "Salir";
$GLOBALS['strUsername'] 					= "Nombre de Usuario";
$GLOBALS['strPassword']						= "Password";
$GLOBALS['strAccessDenied']					= "Acceso denegado";
$GLOBALS['strPasswordWrong']				= "Password INCORRECTO";
$GLOBALS['strNotAdmin']						= "Ud. no tiene los privilegios suficientes.";
$GLOBALS['strDuplicateClientName']			= "Ese usuario ya existe, ingrese uno diferente.";


// General advertising
$GLOBALS['strImpressions'] 						= "Impresiones";
$GLOBALS['strClicks']						= "Clicks";
$GLOBALS['strCTRShort'] 					= "CTR";
$GLOBALS['strCTR'] 							= "Click-Through Ratio (Promedio de Clicks)";
$GLOBALS['strTotalViews'] 					= "Total de Impresiones";
$GLOBALS['strTotalClicks'] 					= "Total de Clicks";
$GLOBALS['strViewCredits'] 					= "Créditos de Impresiones";
$GLOBALS['strClickCredits'] 				= "Créditos de Clicks";


// Time and date related
$GLOBALS['strDate'] 						= "Fecha";
$GLOBALS['strToday'] 						= "Hoy";
$GLOBALS['strDay']							= "Día";
$GLOBALS['strDays']							= "Días";
$GLOBALS['strLast7Days']					= "Últimos 7 días";
$GLOBALS['strWeek'] 						= "Semana";
$GLOBALS['strWeeks']						= "Semanas";
$GLOBALS['strMonths']						= "Meses";
$GLOBALS['strThisMonth'] 					= "Este Mes";
$GLOBALS['strMonth'] 						= array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$GLOBALS['strDayShortCuts'] 				= array("Dom","Lu","Ma","Mie","Jue","Vie","Sab");
$GLOBALS['strHour']							= "Hora";
$GLOBALS['strSeconds']						= "segundos";
$GLOBALS['strMinutes']						= "minutos";
$GLOBALS['strHours']						= "horas";
$GLOBALS['strTimes']						= "veces";


// Advertiser
$GLOBALS['strClient']						= "Anunciante";
$GLOBALS['strClients'] 						= "Anunciantes";
$GLOBALS['strClientsAndCampaigns']			= "Anunciantes & Campañas";
$GLOBALS['strAddClient'] 					= "Agregar Nuevo Anunciante";
$GLOBALS['strTotalClients'] 				= "Total de Anunciantes";
$GLOBALS['strClientProperties']				= "Propiedades del Anunciante";
$GLOBALS['strClientHistory']				= "Historial del Anunciante";
$GLOBALS['strNoClients']					= "No hay anunciantes definidos";
$GLOBALS['strConfirmDeleteClient'] 			= "Está seguro de querer borrar este Anunciante?";
$GLOBALS['strConfirmResetClientStats']		= "Está seguro de querer borrar todas las estadísticas de este Anunciante?";
$GLOBALS['strHideInactiveAdvertisers']		= "Ocultar Anunciantes inactivos";
$GLOBALS['strInactiveAdvertisersHidden']	= "Anunciante(s) inactivos ocultos";


// Advertisers properties
$GLOBALS['strContact'] 						= "Contacto";
$GLOBALS['strEMail'] 						= "E-mail";
$GLOBALS['strSendAdvertisingReport']		= "Enviar Reporte de Anunciante via e-mail";
$GLOBALS['strNoDaysBetweenReports']			= "Cant. de días entre reportes";
$GLOBALS['strSendDeactivationWarning']  	= "Enviar un Alerta cuando una campaña sea desactivada";
$GLOBALS['strAllowClientModifyInfo'] 		= "Permitir a este usuario modificar sus propiedades";
$GLOBALS['strAllowClientModifyBanner'] 		= "Permitir a este usuario modificar sus propios banners";
$GLOBALS['strAllowClientAddBanner'] 		= "Permitir a este usuario agregar sus propios banners";
$GLOBALS['strAllowClientDisableBanner'] 	= "Permitir a este usuario desactivar sus propios banners";
$GLOBALS['strAllowClientActivateBanner'] 	= "Permitir a este usuario activar sus propios banners";


// Campaign
$GLOBALS['strCampaign']						= "Campaña";
$GLOBALS['strCampaigns']					= "Campañas";
$GLOBALS['strTotalCampaigns'] 				= "Total de Campañas";
$GLOBALS['strActiveCampaigns'] 				= "Campañas Activas";
$GLOBALS['strAddCampaign'] 					= "Agregar Nueva Campaña";
$GLOBALS['strCreateNewCampaign']			= "Crear Nueva Campaña";
$GLOBALS['strModifyCampaign']				= "Modificar Campaña";
$GLOBALS['strMoveToNewCampaign']			= "Mover a una nueva Campaña";
$GLOBALS['strBannersWithoutCampaign']		= "Banners sin una Campaña";
$GLOBALS['strDeleteAllCampaigns']			= "Borrar todas las Campañas";
$GLOBALS['strCampaignStats']				= "Estadísticas de la Campaña";
$GLOBALS['strCampaignProperties']			= "Propiedades de Campaña";
$GLOBALS['strCampaignOverview']				= "Resumen de Campaña";
$GLOBALS['strCampaignHistory']				= "Historial de Campaña";
$GLOBALS['strNoCampaigns']					= "No hay Campañas definidas.";
$GLOBALS['strConfirmDeleteAllCampaigns']	= "Está seguro de querer borrar todas las campañas de este Anunciante?";
$GLOBALS['strConfirmDeleteCampaign']		= "Está de querer borrar esta campaña?";
$GLOBALS['strHideInactiveCampaigns']		= "Ocultar campañas inactivas.";
$GLOBALS['strInactiveCampaignsHidden']		= "campaña(s) inactivas ocultas";


// Campaign properties
$GLOBALS['strDontExpire']					= "No caducar esta campaña en una fecha determinada.";
$GLOBALS['strActivateNow'] 					= "Activar esta campaña inmediatamente.";
$GLOBALS['strLow']							= "Bajo";
$GLOBALS['strHigh']							= "Alto";
$GLOBALS['strExpirationDate']				= "Fecha de caducidad";
$GLOBALS['strActivationDate']				= "Fecha de activación";
$GLOBALS['strImpressionsPurchased'] 				= "Impresiones restantes";
$GLOBALS['strClicksPurchased'] 				= "Clicks restantes";
$GLOBALS['strCampaignWeight']				= "Peso de Campaña";
$GLOBALS['strHighPriority']					= "Mostrar los banners con Alta Prioridad en esta campaña.<br />
											Si Ud. usa esta opción el programa tratará de
											distribuir el nr. de Impresiones uniformemente durante el curso
											del día.";
$GLOBALS['strLowPriority']					= "Mostrar los banner con Baja Prioridad en esta campaña.<br />
											Esta campaña es usada para mostrar las Impresiones
											restantes que no son usadas por las campaña de Alta
											Prioridad.";
$GLOBALS['strTargetLimitAdviews']			= "Limitar el número de Impresiones a";
$GLOBALS['strTargetPerDay']					= "por día.";
$GLOBALS['strPriorityAutoTargeting']		= "Distribuir las Impresiones restantes uniformemente durante los días restantes.";



// Banners (General)
$GLOBALS['strBanner'] 						= "Banner";
$GLOBALS['strBanners'] 						= "Banners";
$GLOBALS['strAddBanner'] 					= "Agregar Nuevo banner";
$GLOBALS['strModifyBanner'] 				= "Modificar banner";
$GLOBALS['strActiveBanners'] 				= "Banners Activos";
$GLOBALS['strTotalBanners'] 				= "Total de Banners";
$GLOBALS['strShowBanner']					= "Mostrar banner";
$GLOBALS['strShowAllBanners']	 			= "Mostrar todos los banners";
$GLOBALS['strShowBannersNoAdClicks']		= "Mostrar banners sin Clicks";
$GLOBALS['strShowBannersNoAdViews']			= "Mostrar banners sin impresiones";
$GLOBALS['strDeleteAllBanners']	 			= "Borrar todos los banners";
$GLOBALS['strActivateAllBanners']			= "Activar todos los banners";
$GLOBALS['strDeactivateAllBanners']			= "Desactivar todos los banners";
$GLOBALS['strBannerOverview']				= "Resumen del Banner";
$GLOBALS['strBannerProperties']				= "Propiedades del Banner";
$GLOBALS['strBannerHistory']				= "Historial del Banner";
$GLOBALS['strBannerNoStats'] 				= "No hay estadísticas disponibles para este banner.";
$GLOBALS['strNoBanners']					= "No hay banners definidos.";
$GLOBALS['strConfirmDeleteBanner']			= "Está seguro de querer borrar este banner?";
$GLOBALS['strConfirmDeleteAllBanners']		= "Está seguro de querer borrar todos los banners de esta campaña?";
$GLOBALS['strConfirmResetBannerStats']		= "Está seguro de querer borrar todas las estadísticas de este banner?";
$GLOBALS['strShowParentCampaigns']			= "Mostrar Campañas relacionadas";
$GLOBALS['strHideParentCampaigns']			= "Ocultar Campañas relacionadas";
$GLOBALS['strHideInactiveBanners']			= "Ocultar banners inactivos";
$GLOBALS['strInactiveBannersHidden']		= "banner(s) inactivos ocultos";



// Banner (Properties)
$GLOBALS['strChooseBanner'] 				= "Elija el tipo de banner por favor.";
$GLOBALS['strMySQLBanner'] 					= "Banner Local(SQL)";
$GLOBALS['strWebBanner'] 					= "Banner Local(Webserver)";
$GLOBALS['strURLBanner'] 					= "Banner Externo";
$GLOBALS['strHTMLBanner'] 					= "Banner HTML";
$GLOBALS['strTextBanner'] 					= "Texto";
$GLOBALS['strAutoChangeHTML']				= "Alterar HTML para habilitar el rastreo de Clicks";
$GLOBALS['strUploadOrKeep']					= "Desea conservar<br />la imagen existente,<br />o desea subir una nueva?";
$GLOBALS['strNewBannerFile'] 				= "Seleccione la imagen que quiera <br />usar para este banner.<br /><br />";
$GLOBALS['strNewBannerURL'] 				= "URL de la Imagen (incluir http://)";
$GLOBALS['strURL'] 							= "URL Destino (incluir. http://)";
$GLOBALS['strHTML'] 						= "HTML";
$GLOBALS['strTextBelow'] 					= "Texto posterior a la imagen";
$GLOBALS['strKeyword'] 						= "Palabras Clave";
$GLOBALS['strWeight'] 						= "Peso";
$GLOBALS['strAlt'] 							= "Texto Alternativo";
$GLOBALS['strStatusText']					= "Texto de Status";
$GLOBALS['strBannerWeight']					= "Peso del Banner";


// Banner (swf)
$GLOBALS['strCheckSWF']						= "Chequear hard-coded links en el archivo Flash";
$GLOBALS['strConvertSWFLinks']				= "Convertir Flash links";
$GLOBALS['strConvertSWF']					= "<br />El archivo Flash que acaba de subir contiene hard-coded urls. El programa no podrá ".
											  "rastrear el nr. de Clicks para este banner si Ud. no convierte las ".
											  "hard-coded urls. A continuación encontrará una lista de todas las urls correspodnientes al archivo Flash. ".
											  "Si quiere convertir las urls, simplemente haga click en <b>Convertir</b>, de otro modo clickee ".
											  "<b>Cancelar</b>.<br /><br />".
											  "Note que si clickea <b>Convertir</b>, el archivo Flash ".
									  		  "será alterado fisicamente. <br />Conserve una copia de seguridad del ".
											  "archivo original. Sin importar en que version fue creado el banner, el archivo ".
											  "resultante podrá ser visto correctamente con \"Flash 4 player\" (o posterior).<br /><br />";
$GLOBALS['strCompressSWF']					= "Comprimir el archivo SWF para bajarlo más rápidamente (requiere \"Flash 6 player\")";


// Banner (network)
$GLOBALS['strBannerNetwork']				= "plantilla HTML";
$GLOBALS['strChooseNetwork']				= "Elija la plantilla que quiera usar";
$GLOBALS['strMoreInformation']				= "Mas información...";
$GLOBALS['strRichMedia']					= "Richmedia";
$GLOBALS['strTrackAdClicks']				= "Rastrear Clicks";


// Display limitations
$GLOBALS['strModifyBannerAcl'] 				= "Opciones de entrega";
$GLOBALS['strACL'] 							= "Entrega";
$GLOBALS['strACLAdd'] 						= "Agregar nuevas limitaciones";
$GLOBALS['strNoLimitations']				= "Sin limitaciones";
$GLOBALS['strApplyLimitationsTo']			= "Aplicar limitaciones a";
$GLOBALS['strRemoveAllLimitations']			= "Remover todas las limitaciones";
$GLOBALS['strEqualTo']						= "es igual a";
$GLOBALS['strDifferentFrom']				= "es diferente de";
$GLOBALS['strAND']							= "Y";  						// logical operator
$GLOBALS['strOR']							= "O"; 						// logical operator
$GLOBALS['strOnlyDisplayWhen']				= "Mostrar este banner solamente cuando:";
$GLOBALS['strWeekDay'] 						= "Día de semana";
$GLOBALS['strTime'] 						= "Hora";
$GLOBALS['strUserAgent'] 					= "Browser";
$GLOBALS['strDomain'] 						= "Dominio";
$GLOBALS['strClientIP'] 					= "IP del Cliente";
$GLOBALS['strSource'] 						= "Fuente";
$GLOBALS['strDeliveryLimitations']			= "Limitaciones de Entrega";
$GLOBALS['strDeliveryCapping']				= "Entrega capsulada";
$GLOBALS['strTimeCapping']					= "Una vez que el banner sea entregado una vez, no mostrarlo nuevamente al mismo usuario por:";
$GLOBALS['strImpressionCapping']			= "No mostrar este banner a un Usuario mas de:";


// Publisher
$GLOBALS['strAffiliate']					= "Afiliado";
$GLOBALS['strAffiliates']					= "Afiliados";
$GLOBALS['strAffiliatesAndZones']			= "Afiliados & Zonas";
$GLOBALS['strAddNewAffiliate']				= "Agregar Nuevo Afiliado";
$GLOBALS['strAddAffiliate']					= "Crear Afiliado";
$GLOBALS['strAffiliateProperties']			= "Propiedades del Afiliado";
$GLOBALS['strAffiliateOverview']			= "Resumen del Afiliado";
$GLOBALS['strAffiliateHistory']				= "Historial del Afiliado";
$GLOBALS['strZonesWithoutAffiliate']		= "Zonas sin Afiliado";
$GLOBALS['strMoveToNewAffiliate']			= "Mover a nuevo Afiliado";
$GLOBALS['strNoAffiliates']					= "No hay Afiliados definidos.";
$GLOBALS['strConfirmDeleteAffiliate']		= "Está seguro de querer borrar este Afiliado?";
$GLOBALS['strMakePublisherPublic']			= "Hacer públicas las zonas de este Afiliado";


// Publisher (properties)
$GLOBALS['strAllowAffiliateModifyInfo'] 	= "Permitir a este usuario modificar sus propiedades";
$GLOBALS['strAllowAffiliateModifyZones'] 	= "Permitir a este usuario modificar sus zonas";
$GLOBALS['strAllowAffiliateLinkBanners'] 	= "Permitir a este usuario linkear banners a sus zonas";
$GLOBALS['strAllowAffiliateAddZone'] 		= "Permitir a este usuario definir nuevas zonas";
$GLOBALS['strAllowAffiliateDeleteZone'] 	= "Permitir a este usuario borrar zonas existentes";


// Zone
$GLOBALS['strZone']							= "Zona";
$GLOBALS['strZones']						= "Zonas";
$GLOBALS['strAddNewZone']					= "Agregar Nueva Zona";
$GLOBALS['strAddZone']						= "Crear Zona";
$GLOBALS['strModifyZone']					= "Modificar Zona";
$GLOBALS['strLinkedZones']					= "Zonas Linkeadas";
$GLOBALS['strZoneOverview']					= "Resumen de Zona";
$GLOBALS['strZoneProperties']				= "Propiedades de Zona";
$GLOBALS['strZoneHistory']					= "Historial de Zona";
$GLOBALS['strNoZones']						= "No hay zonas definidas";
$GLOBALS['strConfirmDeleteZone']			= "Está seguro de querer borrar esta zona?";
$GLOBALS['strZoneType']						= "Tipo de zona";
$GLOBALS['strBannerButtonRectangle']		= "Banner, Botón o Rectángulo";
$GLOBALS['strInterstitial']					= "Interstitial o DHTML Flotante";
$GLOBALS['strPopup']						= "Popup";
$GLOBALS['strTextAdZone']					= "Texto";
$GLOBALS['strShowMatchingBanners']			= "Mostrar banners correspondientes";
$GLOBALS['strHideMatchingBanners']			= "Ocultar banners correspondientes";


// Advanced zone settings
$GLOBALS['strAdvanced']						= "Avanzado";
$GLOBALS['strChains']						= "Cadenas";
$GLOBALS['strChainSettings']				= "Propiedades de Cadena";
$GLOBALS['strZoneNoDelivery']				= "Si ningun banner de esta zona <br />puede ser entregado, tratar de...";
$GLOBALS['strZoneStopDelivery']				= "Detener la entrega y no mostrar un banner";
$GLOBALS['strZoneOtherZone']				= "Mostrar la siguiente zona en su lugar";
$GLOBALS['strZoneUseKeywords']				= "Seleccionar un banner usando las siguientes palabras claves";
$GLOBALS['strZoneAppend']					= "Adjuntar siempre el siguiente popup o interstitial a los banners mostrados en esta zona";
$GLOBALS['strAppendSettings']				= "Adjuntar propiedades";
$GLOBALS['strZonePrependHTML']				= "Desagregar siempre el código HTML al texto publicitario mostrado por esta zona";
$GLOBALS['strZoneAppendHTML']				= "Agregar siempre el código HTML al texto publicitario mostrado por esta zona";


// Linked banners/campaigns
$GLOBALS['strSelectZoneType']				= "Elija el tipo de linkeo de banners";
$GLOBALS['strBannerSelection']				= "Selección de banner";
$GLOBALS['strCampaignSelection']			= "Selección de Campaña";
$GLOBALS['strInteractive']					= "Interactivo";
$GLOBALS['strRawQueryString']				= "Palabra Clave";
$GLOBALS['strIncludedBanners']				= "Banners relacionados";
$GLOBALS['strLinkedBannersOverview']		= "Resumen de banners relacionados";
$GLOBALS['strLinkedBannerHistory']			= "Historial de banners relacionados";
$GLOBALS['strNoZonesToLink']				= "No hay zonas disponibles donde linkear este banner";
$GLOBALS['strNoBannersToLink']				= "No hay banners disponibles para linkear a esta zona";
$GLOBALS['strNoLinkedBanners']				= "No hay banners relacionados a esta zona";
$GLOBALS['strMatchingBanners']				= "{count} banners correspondientes";
$GLOBALS['strNoCampaignsToLink']			= "No hay campañas disponibles para linkear a esta zona";
$GLOBALS['strNoZonesToLinkToCampaign']  	= "No hay zonas disponibles donde linkear esta campaña";
$GLOBALS['strSelectBannerToLink']			= "Seleccione el banner que desea linkear a esta zona:";
$GLOBALS['strSelectCampaignToLink']			= "Seleccione la campañ que desea linkear a esta zona:";


// Statistics
$GLOBALS['strStats'] 						= "Estadísticas";
$GLOBALS['strNoStats']						= "No hay estadísticas disponibles";
$GLOBALS['strConfirmResetStats']			= "Est&aacute seguro de querer borrar todas las estadísticas?";
$GLOBALS['strGlobalHistory']				= "Historial Global";
$GLOBALS['strDailyHistory']					= "Historial diario";
$GLOBALS['strDailyStats'] 					= "Estadísticas diarias";
$GLOBALS['strWeeklyHistory']				= "Historial semanal";
$GLOBALS['strMonthlyHistory']				= "Historial mensual";
$GLOBALS['strCreditStats'] 					= "Estadísticas de crédito";
$GLOBALS['strDetailStats'] 					= "Estadísticas detalladas";
$GLOBALS['strTotalThisPeriod']				= "Total del período";
$GLOBALS['strAverageThisPeriod']			= "Promedio del período";
$GLOBALS['strDistribution']					= "Distribución";
$GLOBALS['strResetStats'] 					= "Resetear Estadísticas";
$GLOBALS['strSourceStats']					= "Estadísticas de fuente";
$GLOBALS['strSelectSource']					= "Seleccione la fuente que desea ver:";


// Hosts
$GLOBALS['strHosts']						= "Hosts";
$GLOBALS['strTopTenHosts'] 					= "Hosts - TOP TEN";


// Expiration
$GLOBALS['strExpired']						= "Caducado";
$GLOBALS['strExpiration'] 					= "Caducidad";
$GLOBALS['strNoExpiration'] 				= "Sin fecha de caducidad";
$GLOBALS['strEstimated'] 					= "Caducidad estimada";


// Reports
$GLOBALS['strReports']						= "Reportes";
$GLOBALS['strSelectReport']					= "Elija el reporte que desea generar";


// Userlog
$GLOBALS['strUserLog']						= "Log de Usuario";
$GLOBALS['strUserLogDetails']				= "Detalle de log de Usuarios";
$GLOBALS['strDeleteLog']					= "Borrar log";
$GLOBALS['strAction']						= "Acción";
$GLOBALS['strNoActionsLogged']				= "No hay acciones logueadas";


// Code generation
$GLOBALS['strGenerateBannercode']			= "Generar código de banner";
$GLOBALS['strChooseInvocationType']			= "Elija el tipo de invocación del banner";
$GLOBALS['strGenerate']						= "Generar";
$GLOBALS['strParameters']					= "Parametros";
$GLOBALS['strFrameSize']					= "Tamaño del Frame";
$GLOBALS['strBannercode']					= "Código del Banner";


// Errors
$GLOBALS['strMySQLError'] 					= "Error SQL:";
$GLOBALS['strLogErrorClients'] 				= "[phpAds] An error occurred while trying to fetch the advertisers from the database.";
$GLOBALS['strLogErrorBanners'] 				= "[phpAds] An error occurred while trying to fetch the banners from the database.";
$GLOBALS['strLogErrorViews'] 				= "[phpAds] An error occurred while trying to fetch the adviews from the database.";
$GLOBALS['strLogErrorClicks'] 				= "[phpAds] An error occurred while trying to fetch the adclicks from the database.";
$GLOBALS['strErrorViews'] 					= "Debe ingresar el numero de Impresiones o seleccionar la casilla de Ilimitadas !";
$GLOBALS['strErrorNegViews'] 				= "No están permitidas Impresiones negativas !";
$GLOBALS['strErrorClicks'] 					= "Debe ingresar el numero de Clicks o seleccionar la casilla de Ilimitadas !";
$GLOBALS['strErrorNegClicks'] 				= "No están permitidos los Clicks negativos";
$GLOBALS['strNoMatchesFound']				= "No se encontraron correspondencias.";
$GLOBALS['strErrorOccurred']				= "Ha ocurrido un error.";
$GLOBALS['strErrorUploadSecurity']		= "Se ha detectado un posible problema de seguridad. Upload Cancelado!";
$GLOBALS['strErrorUploadBasedir']		= "No se puede acceder al archivo recibido probablemente debido al modo seguro (safemode) o restrcciones sobre open_basedir";
$GLOBALS['strErrorUploadUnknown']		= "No se puede acceder al archivo recibido y se desconoce la razón. Chequee su configuración de PHP";
$GLOBALS['strErrorStoreLocal']			= "Ha ocurrido un error mientras se intentaba guardar el banner en el directorio local. Probablemente se deba a una mala configuración del directorio local";
$GLOBALS['strErrorStoreFTP']			= "Ha ocurrido un error mientras se intentaba subir el banner al servidor FTP. Puede deberse a que el servidor FTP no se encuentra disponible o bien a una mala configuración del mismo";

// E-mail
$GLOBALS['strMailSubject'] 					= "Reporte de Anunciante";
$GLOBALS['strAdReportSent']					= "Reporte de Anunciante enviado";
$GLOBALS['strMailSubjectDeleted'] 			= "Desactivar banners";
$GLOBALS['strMailHeader'] 					= "Estimado {contact},\n";
$GLOBALS['strMailBannerStats'] 				= "A continuación encontrará las estadísticas de banners de {clientname}:";
$GLOBALS['strMailFooter'] 					= "Lo saluda atentamente,\n   {adminfullname}";
$GLOBALS['strMailClientDeactivated'] 		= "Los siguientes banners fueron deshabilitados porque";
$GLOBALS['strMailNothingLeft'] 				= "Si desea seguir anunciando con nosotros, sientase en libertad de contactarnos nuevamente.\n Nos alegrará volver a oir de usted.";
$GLOBALS['strClientDeactivated']			= "Esta campaña no se encuentra activada porque";
$GLOBALS['strBeforeActivate']				= "la fecha de activación aún no ha sido alcanzada";
$GLOBALS['strAfterExpire']					= "ha pasado la fecha de caducidad";
$GLOBALS['strNoMoreClicks']					= "ya no dispone de Clicks";
$GLOBALS['strNoMoreViews']					= "ya no dispone de Impresiones";
$GLOBALS['strWarnClientTxt']				= "Sus Clicks o Impresiones estan llegando a {limit}. \nSus banners serán deshabilitados cuando ya no disponga de Clicks o Impresiones. ";
$GLOBALS['strImpressionsClicksLow']				= "Dispone de pocos Clicks/Impresiones";
$GLOBALS['strNoViewLoggedInInterval']   	= "Ninguna Impresion se ha detectado hasta la confección de este reporte";
$GLOBALS['strNoClickLoggedInInterval']  	= "Ningun Click se ha detectado hasta la confección de este reporte";
$GLOBALS['strMailReportPeriod']				= "Este reporte incluye estadísticas desde {startdate} hasta {enddate}.";
$GLOBALS['strMailReportPeriodAll']			= "Este reporte incluye todas las estadísticas hasta {enddate}.";
$GLOBALS['strNoStatsForCampaign'] 			= "No hay estadísticas disponibles para esta campaña";


// Priority
$GLOBALS['strPriority']						= "Prioridad";


// Settings
$GLOBALS['strSettings'] 					= "Propiedades";
$GLOBALS['strGeneralSettings']				= "Propiedades Generales";
$GLOBALS['strMainSettings']					= "Propiedades Principales";
$GLOBALS['strAdminSettings']				= "Propiedades de Administración";


// Product Updates
$GLOBALS['strProductUpdates']				= "Actualización del Producto";

?>