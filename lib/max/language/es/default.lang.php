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

$GLOBALS['strHome'] 						= "Inicio";
$GLOBALS['strHelp']							= "Ayuda";
$GLOBALS['strNavigation'] 					= "Navegación";
$GLOBALS['strShortcuts'] 					= "Atajos";
$GLOBALS['strAdminstration'] 				= "Inventario";
$GLOBALS['strMaintenance']					= "Mantenimiento";
$GLOBALS['strProbability']					= "Probabilidad";
$GLOBALS['strInvocationcode']				= "Código";
$GLOBALS['strBasicInformation'] 			= "Informaci&oacute;n B&aacute;sica";
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
$GLOBALS['strUntitled']						= "Sin t&iacute;tulo";
$GLOBALS['strAll'] 							= "todo";
$GLOBALS['strAvg'] 							= "Prom.";
$GLOBALS['strAverage']						= "Promedio";
$GLOBALS['strOverall'] 						= "General";
$GLOBALS['strTotal'] 						= "Total";
$GLOBALS['strActive'] 						= "activo";
$GLOBALS['strFrom']							= "De";
$GLOBALS['strTo']							= "a";
$GLOBALS['strLinkedTo'] 					= "relacionado con";
$GLOBALS['strDaysLeft'] 					= "Días restantes";
$GLOBALS['strCheckAllNone']					= "Marcar todo / nada";
$GLOBALS['strKiloByte']						= "KB";
$GLOBALS['strExpandAll']					= "Expandir todo";
$GLOBALS['strCollapseAll']					= "Contraer todo";
$GLOBALS['strShowAll']						= "Ver todo";
$GLOBALS['strNoAdminInterface']				= "La pantalla de administraci&oacute;n est&aacute; desactivada por mantenimiento. Esto no afecta la entrega de campa&ntilde;as.";
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
$GLOBALS['strEnterUsername']				= "Introduzca su nombre de usuario y contrase&ntilde;a para entrar";
$GLOBALS['strLogin'] 						= "Iniciar sesi&oacute;n";
$GLOBALS['strLogout'] 						= "Cerrar sesi&oacute;n";
$GLOBALS['strUsername'] 					= "Nombre de usuario";
$GLOBALS['strPassword']						= "Contrase&ntilde;a";
$GLOBALS['strAccessDenied']					= "Acceso denegado";
$GLOBALS['strPasswordWrong']				= "La contrase&ntilde;a no es correcta.";
$GLOBALS['strNotAdmin']						= "Puede que no tenga suficientes privilegios; si conoce los datos de usuario correctos, puede iniciar sesi&oacute;n a continuaci&oacute;n";
$GLOBALS['strDuplicateClientName']			= "El nombre de usuario que ha facilitado ya existe, por favor use un nombre de usuario diferente.";


// General advertising
$GLOBALS['strImpressions'] 						= "Impresiones";
$GLOBALS['strClicks']						= "Clics";
$GLOBALS['strCTRShort'] 					= "CTR";
$GLOBALS['strCTR'] 							= "Click-Through Ratio (Promedio de Clics)";
$GLOBALS['strTotalViews'] 					= "Total de Impresiones";
$GLOBALS['strTotalClicks'] 					= "Clics totales";
$GLOBALS['strViewCredits'] 					= "Cr&eacute;ditos de impresiones";
$GLOBALS['strClickCredits'] 				= "Cr&eacute;ditos de clics";


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
$GLOBALS['strMonth'][0] = "Enero";
$GLOBALS['strMonth'][1] = "Febrero";
$GLOBALS['strMonth'][2] = "Marzo";
$GLOBALS['strMonth'][3] = "Abril";
$GLOBALS['strMonth'][4] = "Mayo";
$GLOBALS['strMonth'][5] = "Junio";
$GLOBALS['strMonth'][6] = "Julio";
$GLOBALS['strMonth'][7] = "Agosto";
$GLOBALS['strMonth'][8] = "Septiembre";
$GLOBALS['strMonth'][9] = "Octubre";
$GLOBALS['strMonth'][10] = "Noviembre";
$GLOBALS['strMonth'][11] = "Diciembre";

$GLOBALS['strDayShortCuts'][0] = "Do";
$GLOBALS['strDayShortCuts'][1] = "Lu";
$GLOBALS['strDayShortCuts'][2] = "Ma";
$GLOBALS['strDayShortCuts'][3] = "Mi";
$GLOBALS['strDayShortCuts'][4] = "Ju";
$GLOBALS['strDayShortCuts'][5] = "Vi";
$GLOBALS['strDayShortCuts'][6] = "S&aacute;";

$GLOBALS['strHour']							= "Hora";
$GLOBALS['strSeconds']						= "segundos";
$GLOBALS['strMinutes']						= "minutos";
$GLOBALS['strHours']						= "horas";
$GLOBALS['strTimes']						= "veces";


// Advertiser
$GLOBALS['strClient']						= "Anunciante";
$GLOBALS['strClients'] 						= "Anunciantes";
$GLOBALS['strClientsAndCampaigns']			= "Anunciantes & Campañas";
$GLOBALS['strAddClient'] 					= "Agregar nuevo anunciante";
$GLOBALS['strTotalClients'] 				= "Anunciantes totales";
$GLOBALS['strClientProperties']				= "Propiedades del anunciante";
$GLOBALS['strClientHistory']				= "Historial del anunciante";
$GLOBALS['strNoClients']					= "No hay anunciantes definidos";
$GLOBALS['strConfirmDeleteClient'] 			= "Est&aacute; seguro de querer borrar este anunciante?";
$GLOBALS['strConfirmResetClientStats']		= "Está seguro de querer borrar todas las estadísticas de este Anunciante?";
$GLOBALS['strHideInactiveAdvertisers']		= "Ocultar anunciantes inactivos";
$GLOBALS['strInactiveAdvertisersHidden']	= "anunciante(s) inactivo(s) oculto(s)";


// Advertisers properties
$GLOBALS['strContact'] 						= "Contacto";
$GLOBALS['strEMail'] 						= "E-mail";
$GLOBALS['strSendAdvertisingReport']		= "Enviar informes de entrega de campa&ntilde;as v&iacute;a email";
$GLOBALS['strNoDaysBetweenReports']			= "N&uacute;mero de d&iacute;as entre informes de entrega de campa&ntilde;as";
$GLOBALS['strSendDeactivationWarning']  	= "Enviar un Alerta cuando una campa&ntilde;a sea desactivada autom&aacute;ticamente";
$GLOBALS['strAllowClientModifyInfo'] 		= "Permitir a este usuario modificar sus propiedades";
$GLOBALS['strAllowClientModifyBanner'] 		= "Permitir a este usuario modificar sus propios banners";
$GLOBALS['strAllowClientAddBanner'] 		= "Permitir a este usuario agregar sus propios banners";
$GLOBALS['strAllowClientDisableBanner'] 	= "Permitir a este usuario desactivar sus propios banners";
$GLOBALS['strAllowClientActivateBanner'] 	= "Permitir a este usuario activar sus propios banners";


// Campaign
$GLOBALS['strCampaign']						= "Campaña";
$GLOBALS['strCampaigns']					= "Campañas";
$GLOBALS['strTotalCampaigns'] 				= "Campa&ntilde;as totales";
$GLOBALS['strActiveCampaigns'] 				= "Campa&ntilde;as activas";
$GLOBALS['strAddCampaign'] 					= "Agregar nueva campa&ntilde;a";
$GLOBALS['strCreateNewCampaign']			= "Crear Nueva Campaña";
$GLOBALS['strModifyCampaign']				= "Modificar campa&ntilde;a";
$GLOBALS['strMoveToNewCampaign']			= "Mover a una nueva Campaña";
$GLOBALS['strBannersWithoutCampaign']		= "Banners sin una Campaña";
$GLOBALS['strDeleteAllCampaigns']			= "Borrar todas las campa&ntilde;as";
$GLOBALS['strCampaignStats']				= "Estadísticas de la Campaña";
$GLOBALS['strCampaignProperties']			= "Propiedades de la campa&ntilde;a";
$GLOBALS['strCampaignOverview']				= "Resumen de campa&ntilde;as";
$GLOBALS['strCampaignHistory']				= "Historial de la campa&ntilde;a";
$GLOBALS['strNoCampaigns']					= "No hay campa&ntilde;as definidas";
$GLOBALS['strConfirmDeleteAllCampaigns']	= "Est&aacute; seguro de querer borrar todas las campa&ntilde;as de este anunciante?";
$GLOBALS['strConfirmDeleteCampaign']		= "Est&aacute; seguro de querer borrar esta campa&ntilde;a?";
$GLOBALS['strHideInactiveCampaigns']		= "Ocultar campa&ntilde;as inactivas";
$GLOBALS['strInactiveCampaignsHidden']		= "campa&ntilde;a(s) inactiva(s) oculta(s)";


// Campaign properties
$GLOBALS['strDontExpire']					= "No caducar esta campa&ntilde;a en una fecha determinada";
$GLOBALS['strActivateNow'] 					= "Activar esta campa&ntilde;a inmediatamente";
$GLOBALS['strLow']							= "Bajo";
$GLOBALS['strHigh']							= "Alto";
$GLOBALS['strExpirationDate']				= "Fecha de caducidad";
$GLOBALS['strActivationDate']				= "Fecha de activación";
$GLOBALS['strImpressionsPurchased'] 				= "Impresiones restantes";
$GLOBALS['strClicksPurchased'] 				= "Clicks restantes";
$GLOBALS['strCampaignWeight']				= "Ninguno - fijar el peso de la campa&ntilde;a como";
$GLOBALS['strHighPriority']					= "Mostrar los banners con Alta Prioridad en esta campaña.<br />\n											Si Ud. usa esta opción el programa tratará de\n											distribuir el nr. de Impresiones uniformemente durante el curso\n											del día.";
$GLOBALS['strLowPriority']					= "Mostrar los banner con Baja Prioridad en esta campaña.<br />\n											Esta campaña es usada para mostrar las Impresiones\n											restantes que no son usadas por las campaña de Alta\n											Prioridad.";
$GLOBALS['strTargetLimitAdviews']			= "Limitar el número de Impresiones a";
$GLOBALS['strTargetPerDay']					= "por día.";
$GLOBALS['strPriorityAutoTargeting']		= "Autom&aacute;tico - Distribuir las impresiones restantes uniformemente durante los d&iacute;as restantes.";



// Banners (General)
$GLOBALS['strBanner'] 						= "Banner";
$GLOBALS['strBanners'] 						= "Banners";
$GLOBALS['strAddBanner'] 					= "Agregar nuevo banner";
$GLOBALS['strModifyBanner'] 				= "Modificar banner";
$GLOBALS['strActiveBanners'] 				= "Banners activos";
$GLOBALS['strTotalBanners'] 				= "Banners totales";
$GLOBALS['strShowBanner']					= "Mostrar banner";
$GLOBALS['strShowAllBanners']	 			= "Mostrar todos los banners";
$GLOBALS['strShowBannersNoAdClicks']		= "Mostrar banners sin Clicks";
$GLOBALS['strShowBannersNoAdViews']			= "Mostrar banners sin impresiones";
$GLOBALS['strDeleteAllBanners']	 			= "Borrar todos los banners";
$GLOBALS['strActivateAllBanners']			= "Activar todos los banners";
$GLOBALS['strDeactivateAllBanners']			= "Desactivar todos los banners";
$GLOBALS['strBannerOverview']				= "Resumen de banners";
$GLOBALS['strBannerProperties']				= "Propiedades del banner";
$GLOBALS['strBannerHistory']				= "Historial del banner";
$GLOBALS['strBannerNoStats'] 				= "No hay estadísticas disponibles para este banner.";
$GLOBALS['strNoBanners']					= "No hay actualmente banners definidos";
$GLOBALS['strConfirmDeleteBanner']			= "Está seguro de querer borrar este banner?";
$GLOBALS['strConfirmDeleteAllBanners']		= "Est&aacute; seguro de querer borrar todos los banners pertenecientes a esta campa&ntilde;a?";
$GLOBALS['strConfirmResetBannerStats']		= "Está seguro de querer borrar todas las estadísticas de este banner?";
$GLOBALS['strShowParentCampaigns']			= "Mostrar campa&ntilde;as relacionadas";
$GLOBALS['strHideParentCampaigns']			= "Ocultar campa&ntilde;as relacionadas";
$GLOBALS['strHideInactiveBanners']			= "Ocultar banners inactivos";
$GLOBALS['strInactiveBannersHidden']		= "banner(s) inactivo(s) oculto(s)";



// Banner (Properties)
$GLOBALS['strChooseBanner'] 				= "Por favor, elija el tipo de banner";
$GLOBALS['strMySQLBanner'] 					= "Banner Local (SQL)";
$GLOBALS['strWebBanner'] 					= "Banner Local (Webserver)";
$GLOBALS['strURLBanner'] 					= "Banner Externo";
$GLOBALS['strHTMLBanner'] 					= "Banner HTML";
$GLOBALS['strTextBanner'] 					= "Banner de texto";
$GLOBALS['strAutoChangeHTML']				= "Alterar HTML para habilitar el rastreo de clicks";
$GLOBALS['strUploadOrKeep']					= "Desea conservar<br />la imagen existente,<br />o desea subir una nueva?";
$GLOBALS['strNewBannerFile'] 				= "Seleccione la imagen que quiere <br />usar para este banner.<br /><br />";
$GLOBALS['strNewBannerURL'] 				= "URL de la imagen (incluir http://)";
$GLOBALS['strURL'] 							= "URL destino (incluir. http://)";
$GLOBALS['strHTML'] 						= "HTML";
$GLOBALS['strTextBelow'] 					= "Texto posterior a la imagen";
$GLOBALS['strKeyword'] 						= "Palabras clave";
$GLOBALS['strWeight'] 						= "Peso";
$GLOBALS['strAlt'] 							= "Texto alternativo";
$GLOBALS['strStatusText']					= "Texto de barra de estado";
$GLOBALS['strBannerWeight']					= "Peso del banner";


// Banner (swf)
$GLOBALS['strCheckSWF']						= "Comprobar enlaces <i>hard-coded</i> en el archivo Flash";
$GLOBALS['strConvertSWFLinks']				= "Convertir enlaces Flash";
$GLOBALS['strConvertSWF']					= "<br />El archivo Flash que acaba de subir contiene enlaces <i>hard-coded</i>. ".MAX_PRODUCT_NAME." no podr&aacute; rastrear el n&uacute;mero de clics para este banner si no convierte los enlaces <i>hard-coded</i>. A continuaci&oacute;n encontrar&aacute; una lista de todos los enlaces correspondientes al archivo Flash. Si quiere convertir los enlaces, simplemente haga clic en <b>Convertir</b>; si no haga clic en <b>Cancelar</b>.<br /><br />Si hace clic en <b>Convertir</b>, el archivo Flash ser&aacute; alterado fisicamente. <br />Conserve una copia de seguridad del archivo original. Sin importar la versi&oacute;n en la cual fue creado el banner, el archivo resultante podr&aacute; ser visto correctamente con \"Flash 4 player\" (o posterior).<br /><br />";
$GLOBALS['strCompressSWF']					= "Comprimir el archivo SWF para descargarlo m&aacute;s r&aacute;pidamente (requiere \"Flash 6 player\")";


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
$GLOBALS['strRemoveAllLimitations']			= "Quitar todas las limitaciones";
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
$GLOBALS['strSource'] 						= "Origen";
$GLOBALS['strDeliveryLimitations']			= "Limitaciones de entrega";
$GLOBALS['strDeliveryCapping']				= "L&iacute;mites de entrega";
$GLOBALS['strTimeCapping']					= "Una vez que el banner sea entregado una vez, no mostrarlo nuevamente al mismo usuario por:";
$GLOBALS['strImpressionCapping']			= "No mostrar este banner a un Usuario mas de:";


// Publisher
$GLOBALS['strAffiliate']					= "P&aacute;gina web";
$GLOBALS['strAffiliates']					= "P&aacute;ginas web";
$GLOBALS['strAffiliatesAndZones']			= "P&aacute;ginas web y Zonas";
$GLOBALS['strAddNewAffiliate']				= "Agregar nueva p&aacute;gina web";
$GLOBALS['strAddAffiliate']					= "Crear p&aacute;gina web";
$GLOBALS['strAffiliateProperties']			= "Propiedades de la p&aacute;gina web";
$GLOBALS['strAffiliateOverview']			= "Resumen de p&aacute;ginas web";
$GLOBALS['strAffiliateHistory']				= "Historial de la p&aacute;gina web";
$GLOBALS['strZonesWithoutAffiliate']		= "Zonas sin p&aacute;gina web";
$GLOBALS['strMoveToNewAffiliate']			= "Mover a nueva p&aacute;gina web";
$GLOBALS['strNoAffiliates']					= "No hay p&aacute;ginas web  definidas actualmente";
$GLOBALS['strConfirmDeleteAffiliate']		= "Est&aacute; seguro de querer borrar esta p&aacute;gina web?";
$GLOBALS['strMakePublisherPublic']			= "Convertir en p&uacute;blicas las zonas de esta p&aacute;gina web";


// Publisher (properties)
$GLOBALS['strAllowAffiliateModifyInfo'] 	= "Permitir a este usuario modificar sus propiedades";
$GLOBALS['strAllowAffiliateModifyZones'] 	= "Permitir a este usuario modificar sus zonas";
$GLOBALS['strAllowAffiliateLinkBanners'] 	= "Permitir a este usuario enlazar banners a sus zonas";
$GLOBALS['strAllowAffiliateAddZone'] 		= "Permitir a este usuario definir nuevas zonas";
$GLOBALS['strAllowAffiliateDeleteZone'] 	= "Permitir a este usuario borrar zonas existentes";


// Zone
$GLOBALS['strZone']							= "Zona";
$GLOBALS['strZones']						= "Zonas";
$GLOBALS['strAddNewZone']					= "Agregar nueva zona";
$GLOBALS['strAddZone']						= "Crear Zona";
$GLOBALS['strModifyZone']					= "Modificar zona";
$GLOBALS['strLinkedZones']					= "Zonas enlazadas";
$GLOBALS['strZoneOverview']					= "Resumen de zonas";
$GLOBALS['strZoneProperties']				= "Propiedades de la zona";
$GLOBALS['strZoneHistory']					= "Historial de la zona";
$GLOBALS['strNoZones']						= "No hay zonas definidas actualmente";
$GLOBALS['strConfirmDeleteZone']			= "Está seguro de querer borrar esta zona?";
$GLOBALS['strZoneType']						= "Tipo de zona";
$GLOBALS['strBannerButtonRectangle']		= "Banner, Botón o Rectángulo";
$GLOBALS['strInterstitial']					= "Interstitial o DHTML flotante";
$GLOBALS['strPopup']						= "Popup";
$GLOBALS['strTextAdZone']					= "Texto";
$GLOBALS['strShowMatchingBanners']			= "Mostrar banners correspondientes";
$GLOBALS['strHideMatchingBanners']			= "Ocultar banners correspondientes";


// Advanced zone settings
$GLOBALS['strAdvanced']						= "Avanzado";
$GLOBALS['strChains']						= "Cadenas";
$GLOBALS['strChainSettings']				= "Propiedades de encadenaci&oacute;n";
$GLOBALS['strZoneNoDelivery']				= "Si ning&uacute;n banner de esta zona <br />puede ser entregado, tratar de...";
$GLOBALS['strZoneStopDelivery']				= "Detener la entrega y no mostrar un banner";
$GLOBALS['strZoneOtherZone']				= "Mostrar la siguiente zona en su lugar";
$GLOBALS['strZoneUseKeywords']				= "Seleccionar un banner usando las siguientes palabras claves";
$GLOBALS['strZoneAppend']					= "Adjuntar siempre el siguiente popup o interstitial a los banners mostrados en esta zona";
$GLOBALS['strAppendSettings']				= "Opciones de adjuntos";
$GLOBALS['strZonePrependHTML']				= "Pre-a&ntilde;adir siempre el c&oacute;digo HTML al banner de texto mostrado por esta zona";
$GLOBALS['strZoneAppendHTML']				= "A&ntilde;adir siempre el c&oacute;digo HTML al texto publicitario mostrado por esta zona";


// Linked banners/campaigns
$GLOBALS['strSelectZoneType']				= "Por favor, elija qu&eacute; enlazar a esta zona";
$GLOBALS['strBannerSelection']				= "Selección de banner";
$GLOBALS['strCampaignSelection']			= "Selección de Campaña";
$GLOBALS['strInteractive']					= "Interactivo";
$GLOBALS['strRawQueryString']				= "Palabra clave";
$GLOBALS['strIncludedBanners']				= "Banners relacionados";
$GLOBALS['strLinkedBannersOverview']		= "Resumen de banners relacionados";
$GLOBALS['strLinkedBannerHistory']			= "Historial de banners relacionados";
$GLOBALS['strNoZonesToLink']				= "No hay zonas disponibles donde enlazar este banner";
$GLOBALS['strNoBannersToLink']				= "No hay banners disponibles para linkear a esta zona";
$GLOBALS['strNoLinkedBanners']				= "No hay banners relacionados a esta zona";
$GLOBALS['strMatchingBanners']				= "{count} banners correspondientes";
$GLOBALS['strNoCampaignsToLink']			= "No hay actualmente campa&ntilde;as disponibles para enlazar a esta zona";
$GLOBALS['strNoZonesToLinkToCampaign']  	= "No hay zonas disponibles donde enlazar esta campa&ntilde;a";
$GLOBALS['strSelectBannerToLink']			= "Seleccione el banner que desea enlazar a esta zona:";
$GLOBALS['strSelectCampaignToLink']			= "Seleccione la campa&ntilde;a que desea enlazar a esta zona:";


// Statistics
$GLOBALS['strStats'] 						= "Estadísticas";
$GLOBALS['strNoStats']						= "No hay estadísticas disponibles";
$GLOBALS['strConfirmResetStats']			= "Est&aacute seguro de querer borrar todas las estadísticas?";
$GLOBALS['strGlobalHistory']				= "Historial global";
$GLOBALS['strDailyHistory']					= "Historial diario";
$GLOBALS['strDailyStats'] 					= "Estadísticas diarias";
$GLOBALS['strWeeklyHistory']				= "Historial semanal";
$GLOBALS['strMonthlyHistory']				= "Historial mensual";
$GLOBALS['strCreditStats'] 					= "Estad&iacute;sticas de cr&eacute;ditos";
$GLOBALS['strDetailStats'] 					= "Estadísticas detalladas";
$GLOBALS['strTotalThisPeriod']				= "Total en este periodo";
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
$GLOBALS['strReports']						= "Informes";
$GLOBALS['strSelectReport']					= "Elija el reporte que desea generar";


// Userlog
$GLOBALS['strUserLog']						= "Log de usuarios";
$GLOBALS['strUserLogDetails']				= "Detalle del log de usuarios";
$GLOBALS['strDeleteLog']					= "Borrar log";
$GLOBALS['strAction']						= "Acción";
$GLOBALS['strNoActionsLogged']				= "No hay acciones grabadas";


// Code generation
$GLOBALS['strGenerateBannercode']			= "Selecci&oacute;n directa";
$GLOBALS['strChooseInvocationType']			= "Por favor, elija el tipo de invocaci&oacute;n de banner";
$GLOBALS['strGenerate']						= "Generar";
$GLOBALS['strParameters']					= "Opciones de tag";
$GLOBALS['strFrameSize']					= "Tama&ntilde;o del marco (frame)";
$GLOBALS['strBannercode']					= "C&oacute;digo del banner";


// Errors
$GLOBALS['strMySQLError'] 					= "Error SQL:";
$GLOBALS['strLogErrorClients'] 				= "[phpAds] Ha ocurrido un error al recoger los anunciantes de la base de datos.";
$GLOBALS['strLogErrorBanners'] 				= "[phpAds] Ha ocurrido un error al recoger los banners de la base de datos.";
$GLOBALS['strLogErrorViews'] 				= "[phpAds] Ha ocurrido un error al recoger los adviews de la base de datos.";
$GLOBALS['strLogErrorClicks'] 				= "[phpAds] Ha ocurrido un error al recoger los adclicks de la base de datos.";
$GLOBALS['strErrorViews'] 					= "Debe ingresar el numero de Impresiones o seleccionar la casilla de Ilimitadas !";
$GLOBALS['strErrorNegViews'] 				= "No están permitidas Impresiones negativas !";
$GLOBALS['strErrorClicks'] 					= "Debe ingresar el numero de Clicks o seleccionar la casilla de Ilimitadas !";
$GLOBALS['strErrorNegClicks'] 				= "No están permitidos los Clicks negativos";
$GLOBALS['strNoMatchesFound']				= "No se han encontrado resultados.";
$GLOBALS['strErrorOccurred']				= "Ha ocurrido un error";
$GLOBALS['strErrorUploadSecurity']		= "Se ha detectado un posible problema de seguridad. &iexcl;Upload cancelado!";
$GLOBALS['strErrorUploadBasedir']		= "No se puede acceder al archivo recibido, probablemente debido al modo seguro (safemode) o restrcciones sobre open_basedir";
$GLOBALS['strErrorUploadUnknown']		= "No se puede acceder al archivo recibido y se desconoce la raz&oacute;n. Compruebe su configuraci&oacute;n de PHP";
$GLOBALS['strErrorStoreLocal']			= "Ha ocurrido un error mientras se intentaba guardar el banner en el directorio local. Probablemente se deba a una mala configuración del directorio local";
$GLOBALS['strErrorStoreFTP']			= "Ha ocurrido un error mientras se intentaba subir el banner al servidor FTP. Puede deberse a que el servidor FTP no se encuentra disponible o bien a una mala configuración del mismo";

// E-mail
$GLOBALS['strMailSubject'] 					= "Informe de anunciante";
$GLOBALS['strAdReportSent']					= "Reporte de Anunciante enviado";
$GLOBALS['strMailSubjectDeleted'] 			= "Desactivar banners";
$GLOBALS['strMailHeader'] 					= "Estimado/a {contact},\n";
$GLOBALS['strMailBannerStats'] 				= "A continuación encontrará las estadísticas de banners de {clientname}:";
$GLOBALS['strMailFooter'] 					= "Le saluda atentamente,\n   {adminfullname}";
$GLOBALS['strMailClientDeactivated'] 		= "Los siguientes banners fueron deshabilitados porque";
$GLOBALS['strMailNothingLeft'] 				= "Si desea seguir colaborando con nosotros poniendo anuncios, por favor, contacte con nosotros. Estaremos encantados de hablar con usted.\n Nos alegrar&aacute; volver a oir de usted.";
$GLOBALS['strClientDeactivated']			= "Esta campaña no se encuentra activada porque";
$GLOBALS['strBeforeActivate']				= "la fecha de activaci&oacute;n a&uacute;n no ha llegado";
$GLOBALS['strAfterExpire']					= "ha llegado la fecha de caducidad";
$GLOBALS['strNoMoreClicks']					= "no quedan clics disponibles";
$GLOBALS['strNoMoreViews']					= "ya no dispone de Impresiones";
$GLOBALS['strWarnClientTxt']				= "Las impresiones, clics o conversiones restantes para sus banners est&aacute;n llegando por debajo de {limit}.\nSus banners se desactivar&aacute;n cuando ya no queden impresiones, clics o conversiones.";
$GLOBALS['strImpressionsClicksLow']				= "Dispone de pocos Clicks/Impresiones";
$GLOBALS['strNoViewLoggedInInterval']   	= "No se ha grabado ninguna impresi&oacute;n durante el periodo de este informe";
$GLOBALS['strNoClickLoggedInInterval']  	= "No se ha grabado ning&uacute;n clic durante el periodo de este informe";
$GLOBALS['strMailReportPeriod']				= "Este informe incluye estad&iacute;sticas desde {startdate} hasta {enddate}.";
$GLOBALS['strMailReportPeriodAll']			= "Este informe incluye todas las estad&iacute;sticas hasta {enddate}.";
$GLOBALS['strNoStatsForCampaign'] 			= "No hay estadísticas disponibles para esta campaña";


// Priority
$GLOBALS['strPriority']						= "Prioridad";


// Settings
$GLOBALS['strSettings'] 					= "Configuraci&oacute;n";
$GLOBALS['strGeneralSettings']				= "Configuraci&oacute;n general";
$GLOBALS['strMainSettings']					= "Configuraci&oacute;n principal";
$GLOBALS['strAdminSettings']				= "Opciones de administraci&oacute;n";


// Product Updates
$GLOBALS['strProductUpdates']				= "Actualizaci&oacute;n del producto";



// Note: new translatiosn not found in original lang files but found in CSV
$GLOBALS['strStartOver'] = "Comenzar de nuevo";
$GLOBALS['strTrackerVariables'] = "Variables de Tracker";
$GLOBALS['strAppendTrackerCode'] = "A&ntilde;adir c&oacute;digo de tracker";
$GLOBALS['strSyncSettings'] = "Opciones de sincronizaci&oacute;n";
$GLOBALS['strFieldContainsErrors'] = "Los siguientes campos contienen errores:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Antes de continuar necesita";
$GLOBALS['strFieldFixBeforeContinue2'] = "corregir estos errores.";
$GLOBALS['strMiscellaneous'] = "Miscel&aacute;nea";
$GLOBALS['strCollectedAllStats'] = "Todas las estad&iacute;sticas";
$GLOBALS['strCollectedToday'] = "Hoy";
$GLOBALS['strCollectedYesterday'] = "Ayer";
$GLOBALS['strCollectedThisWeek'] = "Esta semana";
$GLOBALS['strCollectedLastWeek'] = "La semana pasada";
$GLOBALS['strCollectedThisMonth'] = "Este mes";
$GLOBALS['strCollectedLastMonth'] = "El mes pasado";
$GLOBALS['strCollectedLast7Days'] = "&Uacute;ltimos 7 d&iacute;as";
$GLOBALS['strCollectedSpecificDates'] = "Fechas espec&iacute;ficas";
$GLOBALS['strPriorityLevel'] = "Nivel de prioridad";
$GLOBALS['strPriorityTargeting'] = "Distribuci&oacute;n";
$GLOBALS['strPriorityOptimisation'] = "Miscel&aacute;nea";
$GLOBALS['strExclusiveAds'] = "Anuncios exclusivos";
$GLOBALS['strHighAds'] = "Anuncios de alta prioridad";
$GLOBALS['strLowAds'] = "Anuncios de baja prioridad";
$GLOBALS['strLimitations'] = "Limitaciones";
$GLOBALS['strVariables'] = "Variables";
$GLOBALS['strComments'] = "Comentarios";
$GLOBALS['strEnterBoth'] = "Por favor, introduzca ambos, nombre de usuario y contrase&ntilde;a";
$GLOBALS['strUsernameOrPasswordWrong'] = "El nombre de usuario y/o la contrase&ntilde;a no son correctos. Por favor, int&eacute;ntelo de nuevo.";
$GLOBALS['strDuplicateAgencyName'] = "El nombre de usuario que ha facilitado ya existe, por favor use un nombre de usuario diferente.";
$GLOBALS['strConversions'] = "Conversiones";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCNVR'] = "Promedio de ventas";
$GLOBALS['strTotalConversions'] = "Conversiones totales";
$GLOBALS['strConversionCredits'] = "Cr&eacute;ditos de conversi&oacute;n";
$GLOBALS['strDateTime'] = "Fecha y hora";
$GLOBALS['strTrackerID'] = "ID Tracker";
$GLOBALS['strTrackerName'] = "Nombre Tracker";
$GLOBALS['strCampaignID'] = "ID Campa&ntilde;a";
$GLOBALS['strCampaignName'] = "Nombre Campa&ntilde;a";
$GLOBALS['strCountry'] = "Pa&iacute;s";
$GLOBALS['strStatsAction'] = "Acci&oacute;n";
$GLOBALS['strWindowDelay'] = "Ventana de retardo";
$GLOBALS['strStatsVariables'] = "Variables";
$GLOBALS['strSingleMonth'] = "Mes";
$GLOBALS['strDayOfWeek'] = "D&iacute;a de la semana";
$GLOBALS['strAddClient_Key'] = "Agregar <u>n</u>uevo anunciante";
$GLOBALS['strChars'] = "caracteres";
$GLOBALS['strAllowClientViewTargetingStats'] = "Permitir a este usuario ver estad&iacute;sticas de targeting";
$GLOBALS['strCsvImportConversions'] = "Permitir a este usuario importar conversiones offline";
$GLOBALS['strAddCampaign_Key'] = "Agregar <u>n</u>ueva campa&ntilde;a";
$GLOBALS['strLinkedCampaigns'] = "Campa&ntilde;as enlazadas";
$GLOBALS['strShowParentAdvertisers'] = "Mostrar anunciantes superiores";
$GLOBALS['strHideParentAdvertisers'] = "Ocultar anunciantes superiores";
$GLOBALS['strContractDetails'] = "Detalles de contrato";
$GLOBALS['strInventoryDetails'] = "Detalles de inventario";
$GLOBALS['strPriorityInformation'] = "Informaci&oacute;n de prioridades";
$GLOBALS['strPriorityExclusive'] = "&middot; Sobreescribe otras campa&ntilde;as enlazadas";
$GLOBALS['strPriorityHigh'] = "&middot; Campa&ntilde;as de pago";
$GLOBALS['strPriorityLow'] = "&middot; Campa&ntilde;as gratis y propias";
$GLOBALS['strHiddenCampaign'] = "Campa&ntilde;a";
$GLOBALS['strHiddenAd'] = "Anuncio";
$GLOBALS['strHiddenAdvertiser'] = "Anunciante";
$GLOBALS['strHiddenTracker'] = "Tracker";
$GLOBALS['strHiddenZone'] = "Zona";
$GLOBALS['strCompanionPositioning'] = "Posicionamiento de campa&ntilde;a";
$GLOBALS['strSelectUnselectAll'] = "Seleccionar / Deseleccionar todo";
$GLOBALS['strExclusive'] = "Exclusivo";
$GLOBALS['strExpirationDateComment'] = "La campa&ntilde;a terminar&aacute; al final del d&iacute;a";
$GLOBALS['strActivationDateComment'] = "La campa&ntilde;a comenzar&aacute; al principio del d&iacute;a";
$GLOBALS['strImpressionsRemaining'] = "Impresiones restantes";
$GLOBALS['strClicksRemaining'] = "Clics restantes";
$GLOBALS['strConversionsRemaining'] = "Conversiones restantes";
$GLOBALS['strImpressionsBooked'] = "Impresiones contratadas";
$GLOBALS['strClicksBooked'] = "Clics contratados";
$GLOBALS['strConversionsBooked'] = "Conversiones contratadas";
$GLOBALS['strOptimise'] = "Optimizar";
$GLOBALS['strAnonymous'] = "Ocultar el anunciante y las p&aacute;ginas web de esta campa&ntilde;a.";
$GLOBALS['strCampaignWarningNoWeight'] = "La prioridad de esta campa&ntilde;a se ha marcado como baja,\npero el peso est&aacute; fijado como cero o no ha sido\nespecificado. Esto har&aacute; que la campa&ntilde;a se desactive \ny sus banners no se muestren hasta que se fije \nun n&uacute;mero v&aacute;lido en el peso.\n\nEst&aacute; seguro de querer continuar?";
$GLOBALS['strCampaignWarningNoTarget'] = "La prioridad de esta campa&ntilde;a se ha marcado como alta,\npero el objetivo de n&uacute;mero de impresiones no est&aacute;\nespecificado. Esto har&aacute; que la campa&ntilde;a se desactive\ny sus banners no se muestren hasta que se fije un \nobjetivo v&aacute;lido de impresiones.\n\nEst&aacute; seguro de querer continuar?";
$GLOBALS['strTracker'] = "Tracker";
$GLOBALS['strTrackerOverview'] = "Resumen de trackers";
$GLOBALS['strAddTracker'] = "A&ntilde;adir nuevo tracker";
$GLOBALS['strAddTracker_Key'] = "A&ntilde;adir <u>n</u>uevo tracker";
$GLOBALS['strNoTrackers'] = "No hay trackers definidos";
$GLOBALS['strConfirmDeleteAllTrackers'] = "Est&aacute; seguro de querer borrar todos los trackers pertenecientes a este anunciante?";
$GLOBALS['strConfirmDeleteTracker'] = "Est&aacute; seguro de querer borrar este tracker?";
$GLOBALS['strDeleteAllTrackers'] = "Borrar todos los trackers";
$GLOBALS['strTrackerProperties'] = "Propiedades de trackers";
$GLOBALS['strModifyTracker'] = "Modificar tracker";
$GLOBALS['strLog'] = "Log?";
$GLOBALS['strDefaultStatus'] = "Estado por defecto";
$GLOBALS['strStatus'] = "Estado";
$GLOBALS['strLinkedTrackers'] = "Trackers enlazados";
$GLOBALS['strDefaultConversionRules'] = "Reglas de conversi&oacute;n por defecto";
$GLOBALS['strConversionWindow'] = "Ventana de conversi&oacute;n";
$GLOBALS['strClickWindow'] = "Ventana de clic";
$GLOBALS['strViewWindow'] = "Ventana de vista";
$GLOBALS['strUniqueWindow'] = "Ventana de &uacute;nico";
$GLOBALS['strClick'] = "Clic";
$GLOBALS['strView'] = "Vista";
$GLOBALS['strLinkCampaignsByDefault'] = "Enlazar campa&ntilde;as nuevas por defecto";
$GLOBALS['strAddBanner_Key'] = "Agregar <u>n</u>uevo banner";
$GLOBALS['strAppendTextAdNotPossible'] = "No es posible a&ntilde;adir otros banners a banners de texto.";
$GLOBALS['strUploadOrKeepAlt'] = "Desea conservar<br />la imagen de reserva,<br />o desea subir una nueva?";
$GLOBALS['strNewBannerFileAlt'] = "Seleccione la imagen de reserva que <br />quiere usar en el caso de que los navegadores </br /> no soporten multimedia";
$GLOBALS['strAdserverTypeGeneric'] = "Banner HTML gen&eacute;rico";
$GLOBALS['strGenericOutputAdServer'] = "Gen&eacute;rico";
$GLOBALS['strSwfTransparency'] = "Fondo transparente (s&oacute;lo Flash)";
$GLOBALS['strHardcodedLinks'] = "Enlaces <i>hard-coded</i>";
$GLOBALS['strOverwriteSource'] = "Sobreescribir par&aacute;metro \"origen\"";
$GLOBALS['strLaterThan'] = "es m&aacute;s tarde de";
$GLOBALS['strLaterThanOrEqual'] = "es m&aacute;s tarde o igual a";
$GLOBALS['strEarlierThan'] = "es antes de";
$GLOBALS['strEarlierThanOrEqual'] = "es antes o igual a";
$GLOBALS['strWeekDays'] = "D&iacute;as de la semana";
$GLOBALS['strCity'] = "Ciudad";
$GLOBALS['strDeliveryCappingReset'] = "Resetear contadores de vistas despu&eacute;s de:";
$GLOBALS['strDeliveryCappingTotal'] = "en total";
$GLOBALS['strDeliveryCappingSession'] = "por sesi&oacute;n";
$GLOBALS['strAddNewAffiliate_Key'] = "Agregar <u>n</u>ueva p&aacute;gina web";
$GLOBALS['strInactiveAffiliatesHidden'] = "p&aacute;gina web(s) inactiva(s) oculta(s)";
$GLOBALS['strShowParentAffiliates'] = "Mostrar p&aacute;ginas web relacionadas";
$GLOBALS['strHideParentAffiliates'] = "Ocultar p&aacute;ginas web relacionadas";
$GLOBALS['strWebsite'] = "Web";
$GLOBALS['strMnemonic'] = "Mnem&oacute;nico";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Permitir a este usuario generar c&oacute;digo de invocaci&oacute;n";
$GLOBALS['strAllowAffiliateZoneStats'] = "Permitor a este usuario ver estad&iacute;sticas de zonas";
$GLOBALS['strAllowAffiliateApprPendConv'] = "Permitor a este usuario ver s&oacute;lo conversiones aprobadas o pendientes";
$GLOBALS['strPaymentInformation'] = "Informaci&oacute;n de pagos";
$GLOBALS['strAddress'] = "Direcci&oacute;n";
$GLOBALS['strPostcode'] = "C&oacute;digo postal";
$GLOBALS['strPhone'] = "Tel&eacute;fono";
$GLOBALS['strFax'] = "Fax";
$GLOBALS['strAccountContact'] = "Cuenta de contrato";
$GLOBALS['strPayeeName'] = "Nombre del cobrador";
$GLOBALS['strTaxID'] = "ID tasas";
$GLOBALS['strModeOfPayment'] = "Modo de pago";
$GLOBALS['strPaymentChequeByPost'] = "Cheque postal";
$GLOBALS['strCurrency'] = "Moneda";
$GLOBALS['strCurrencyGBP'] = "GBP";
$GLOBALS['strOtherInformation'] = "Otra informaci&oacute;n";
$GLOBALS['strUniqueUsersMonth'] = "Usuarios &uacute;nicos/mes";
$GLOBALS['strUniqueViewsMonth'] = "Vistas &uacute;nicas/mes";
$GLOBALS['strPageRank'] = "Page rank";
$GLOBALS['strCategory'] = "Categor&iacute;a";
$GLOBALS['strHelpFile'] = "Archivo de ayuda";
$GLOBALS['strAddNewZone_Key'] = "Agregar <u>n</u>ueva zona";
$GLOBALS['strEmailAdZone'] = "Zona de E-mail/bolet&iacute;n";
$GLOBALS['strZoneClick'] = "Zona de tracking de clics";
$GLOBALS['strBannerLinkedAds'] = "Banners enlazados a la zona";
$GLOBALS['strCampaignLinkedAds'] = "Campa&ntilde;as enlazadas a la zona";
$GLOBALS['strInactiveZonesHidden'] = "zona(s) inactiva(s) oculta(s)";
$GLOBALS['strZoneForecasting'] = "Opciones de previsi&oacute;n de zonas";
$GLOBALS['strZoneAppendNoBanner'] = "A&ntilde;adir incluso si no hay banners que mostrar";
$GLOBALS['strZoneAppendType'] = "Tipo de zona";
$GLOBALS['strZoneAppendHTMLCode'] = "C&oacute;digo HTML";
$GLOBALS['strZoneAppendZoneSelection'] = "Popul o interstitial";
$GLOBALS['strZoneAppendSelectZone'] = "Siempre a&ntilde;adir el siguiente popup o interstitial a los banners mostrados por esta zona";
$GLOBALS['strZoneProbListChain'] = "Todos los banners enlazados a esta zona est&aacute;n actualmente desactivados. <br />Esta es la cadena de zonas:";
$GLOBALS['strZoneProbNullPri'] = "No hay banners activos enlazados a esta zona.";
$GLOBALS['strZoneProbListChainLoop'] = "Continuar con la cadena de zonas provocar&aacute; un bucle circular. Se ha detenido la entrega de esta zona.";
$GLOBALS['strLinkedBanners'] = "Enlazar banners individuales";
$GLOBALS['strCampaignDefaults'] = "Enlazar banners por campa&ntilde;a padre";
$GLOBALS['strLinkedCategories'] = "Enlazar banners por categor&iacute;a";
$GLOBALS['strNoTrackersToLink'] = "No hay actualmente trackers disponibles que puedan enlazarse a esta campa&ntilde;a";
$GLOBALS['strNoTargetingStats'] = "No hay estad&iacute;sticas de targeting disponibles";
$GLOBALS['strNoStatsForPeriod'] = "No hay estad&iacute;sticas disponibles para el periodo del %s al %s";
$GLOBALS['strNoTargetingStatsForPeriod'] = "No hay estad&iacute;sticas de targeting disponibles para el periodo del %s al %s";
$GLOBALS['strPublisherDistribution'] = "Distribuci&oacute;n de p&aacute;ginas web";
$GLOBALS['strCampaignDistribution'] = "Distribuci&oacute;n de campa&ntilde;as";
$GLOBALS['strKeywordStatistics'] = "Estad&iacute;sticas de palabras clave";
$GLOBALS['strTargetStats'] = "Estad&iacute;sticas de targeting";
$GLOBALS['strViewBreakdown'] = "Ver por";
$GLOBALS['strBreakdownByDay'] = "D&iacute;a";
$GLOBALS['strBreakdownByWeek'] = "Semana";
$GLOBALS['strBreakdownByMonth'] = "Mes";
$GLOBALS['strBreakdownByDow'] = "D&iacute;a de la semana";
$GLOBALS['strBreakdownByHour'] = "Hora";
$GLOBALS['strItemsPerPage'] = "Elementos por p&aacute;gina";
$GLOBALS['strDistributionHistory'] = "Distribuci&oacute;n de hist&oacute;rico";
$GLOBALS['strShowGraphOfStatistics'] = "Mostrar <u>g</u>r&aacute;fica de estad&iacute;sticas";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>xportar estad&iacute;sticas a Excel";
$GLOBALS['strGDnotEnabled'] = "Debe tener GD activado en PHP para poder mostrar gr&aacute;ficas. Por favor, vea <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> para m&aacute;s informaci&oacute;n, incluyendo c&oacute;mo instalar GD en su servidor.";
$GLOBALS['strStartDate'] = "Fecha de inicio";
$GLOBALS['strEndDate'] = "Fecha de finalizaci&oacute;n";
$GLOBALS['strAllAdvertisers'] = "Todos los anunciantes";
$GLOBALS['strAnonAdvertisers'] = "Anunciantes an&oacute;nimos";
$GLOBALS['strAllPublishers'] = "Todas las p&aacute;ginas web";
$GLOBALS['strAnonPublishers'] = "P&aacute;ginas web an&oacute;nimas";
$GLOBALS['strAllAvailZones'] = "Todas las zonas disponibles";
$GLOBALS['strTrackercode'] = "C&oacute;digo del tracker";
$GLOBALS['strBackToTheList'] = "Volver a la lista de informes";
$GLOBALS['strLogErrorConversions'] = "[phpAds] Ha ocurrido un error al recoger las conversiones de la base de datos.";
$GLOBALS['strErrorDBPlain'] = "Ha ocurrido un error al intentar acceder a la base de datos";
$GLOBALS['strErrorDBSerious'] = "Se ha detectado un problema serio con la base de datos";
$GLOBALS['strErrorDBNoDataPlain'] = "Debido a un problema con la base de datos, ".MAX_PRODUCT_NAME." no ha podido cargar o guardar los datos.";
$GLOBALS['strErrorDBNoDataSerious'] = "Debido a un problema serio con la base de datos, ".MAX_PRODUCT_NAME." no ha podido cargar los datos.";
$GLOBALS['strErrorDBCorrupt'] = "La tabla de base de datos est&aacute; probablemente corrupta y necesita ser reparada. Para m&aacute;s informaci&oacute;n sobre reparaci&oacute;n de tablas corruptas, por favor, lea el cap&iacute;tulo <i>Troubleshooting</i> (resoluci&oacute;n de problemas) de la <i>Gu&iacute;a del Administrador</i>.";
$GLOBALS['strErrorDBContact'] = "Por favor, contacte con el administrador de este servidor y notif&iacute;quele el problema.";
$GLOBALS['strErrorDBSubmitBug'] = "Si el problema es reproducible puede ser debido a un bug en ".MAX_PRODUCT_NAME.". Por favor, env&iacute;e la siguiente informaci&oacute;n a los creadores de ".MAX_PRODUCT_NAME.". Tambi&eacute;n intente describir las acciones que le han llevado hasta este error tan claramente como le sea posible.";
$GLOBALS['strMaintenanceNotActive'] = "El script de mantenimiento no ha sido ejecutado en las &uacute;ltimas 24 horas. \nPara asegurar el buen funcionamiento de ".MAX_PRODUCT_NAME.", necesita ejecutarse \ncada hora. \n\nPor favor, lea la Gu&iacute;a del Administrador para m&aacute;s informaci&oacute;n \nsobre la configuraci&oacute;n del script de mantenimiento.";
$GLOBALS['strErrorLinkingBanner'] = "No ha sido posible enlazar el banner a esta zona porque:";
$GLOBALS['strUnableToLinkBanner'] = "No se puede enlazar este banner:";
$GLOBALS['strErrorEditingCampaign'] = "Error actualizando campa&ntilde;a:";
$GLOBALS['strUnableToChangeCampaign'] = "No se pueden aplicar los cambios porque:";
$GLOBALS['strDatesConflict'] = "las fechas son conflictivas con:";
$GLOBALS['strSirMadam'] = "Sr/a.";
$GLOBALS['strMailBannerActivatedSubject'] = "Campa&ntilde;a activada";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Campa&ntilde;a desactivada";
$GLOBALS['strMailBannerActivated'] = "La campa&ntilde;a mostrada debajo ha sido activada porque\nla fecha de activaci&oacute;n de la campa&ntilde;a ha llegado.";
$GLOBALS['strMailBannerDeactivated'] = "La campa&ntilde;a mostrada debajo ha sido desactivada porque";
$GLOBALS['strNoMoreImpressions'] = "no quedan impresiones disponibles";
$GLOBALS['strNoMoreConversions'] = "no quedan ventas disponibles";
$GLOBALS['strWeightIsNull'] = "el peso es cero";
$GLOBALS['strTargetIsNull'] = "el target es cero";
$GLOBALS['strImpressionsClicksConversionsLow'] = "Las impresiones/clics/conversiones son bajas";
$GLOBALS['strNoConversionLoggedInInterval'] = "No se ha grabado ninguna conversi&oacute;n durante el periodo de este informe";
$GLOBALS['strImpendingCampaignExpiry'] = "Fecha de expiraci&oacute;n de campa&ntilde;a pr&oacute;xima";
$GLOBALS['strYourCampaign'] = "Su campa&ntilde;a";
$GLOBALS['strTheCampiaignBelongingTo'] = "La campa&ntilde;a perteneciente a";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} mostrada a continuaci&oacute;n caducar&aacute; en la fecha {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} mostrada a continuaci&oacute;n tiene menos de {limit} impresiones restantes.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "Como resultado, pronto la campa&ntilde;a ser&aacute; desactivada autom&aacute;ticamente, y los\nsiguientes banners en la campa&ntilde;a tambi&eacute;n se desactivar&aacute;n:";
$GLOBALS['strSourceEdit'] = "Editar or&iacute;genes";
$GLOBALS['strCheckForUpdates'] = "Comprobar actualizaciones";
$GLOBALS['strViewPastUpdates'] = "Administrar actualizaciones anteriores y copias de seguridad";
$GLOBALS['strAgencyManagement'] = "Administraci&oacute;n de agencias";
$GLOBALS['strAgency'] = "Agencia";
$GLOBALS['strAddAgency'] = "Agregar nueva agencia";
$GLOBALS['strAddAgency_Key'] = "Agregar <u>n</u>ueva agencia";
$GLOBALS['strTotalAgencies'] = "Total agencias";
$GLOBALS['strAgencyProperties'] = "Propiedades de agencia";
$GLOBALS['strNoAgencies'] = "No hay agencias definidas actualmente";
$GLOBALS['strConfirmDeleteAgency'] = "Est&aacute; seguro de querer borrar esta agencia?";
$GLOBALS['strHideInactiveAgencies'] = "Ocultar agencias inactivas";
$GLOBALS['strInactiveAgenciesHidden'] = "agencia(s) inactiva(s) oculta(s)";
$GLOBALS['strAllowAgencyEditConversions'] = "Permitir a este usuario editar conversiones";
$GLOBALS['strAllowMoreReports'] = "Permitir bot&oacute;n de \"m&aacute;s informes\"";
$GLOBALS['strChannel'] = "Canal";
$GLOBALS['strChannels'] = "Canales";
$GLOBALS['strChannelOverview'] = "Resumen de canales";
$GLOBALS['strChannelManagement'] = "Administraci&oacute;n de canales";
$GLOBALS['strAddNewChannel'] = "Agregar nuevo canal";
$GLOBALS['strAddNewChannel_Key'] = "Agregar <u>n</u>uevo canal";
$GLOBALS['strNoChannels'] = "No hay canales definidos actualmente";
$GLOBALS['strEditChannelLimitations'] = "Editar limitaciones de canales";
$GLOBALS['strChannelProperties'] = "Propiedades de canales";
$GLOBALS['strChannelLimitations'] = "Opciones de entrega";
$GLOBALS['strConfirmDeleteChannel'] = "Est&aacute; seguro de querer borrar este canal?";
$GLOBALS['strVariableName'] = "Nombre de variable";
$GLOBALS['strVariableDescription'] = "Descripci&oacute;n";
$GLOBALS['strVariableDataType'] = "Tipo de dato";
$GLOBALS['strVariablePurpose'] = "Objetivo";
$GLOBALS['strGeneric'] = "Gen&eacute;rico";
$GLOBALS['strBasketValue'] = "Valor de cesta";
$GLOBALS['strNumItems'] = "N&uacute;mero de elementos";
$GLOBALS['strVariableIsUnique'] = "De-duplicar conversiones?";
$GLOBALS['strNumber'] = "N&uacute;mero";
$GLOBALS['strString'] = "Cadena de caracteres (string)";
$GLOBALS['strTrackFollowingVars'] = "Controlar la siguiente variable";
$GLOBALS['strAddVariable'] = "Agregar variable";
$GLOBALS['strNoVarsToTrack'] = "No hay variables que controlar.";
$GLOBALS['strVariableRejectEmpty'] = "Rechazar si est&aacute; vac&iacute;o?";
$GLOBALS['strTrackingSettings'] = "Opciones de tracking";
$GLOBALS['strTrackerType'] = "Tipo de tracker";
$GLOBALS['strTrackerTypeJS'] = "Variables Javascript de tracker";
$GLOBALS['strTrackerTypeDefault'] = "Variables Javascript de tracker (modo compatible, se necesita escapar caracteres)";
$GLOBALS['strTrackerTypeDOM'] = "Controlar elementos HTML usando DOM";
$GLOBALS['strTrackerTypeCustom'] = "C&oacute;digo Javascript personalizado";
$GLOBALS['strVariableCode'] = "C&oacute;digo Javascript de tracking";
$GLOBALS['strForgotPassword'] = "Ha olvidado su contrase&ntilde;a?";
$GLOBALS['strPasswordRecovery'] = "Recuperar contrase&ntilde;a";
$GLOBALS['strEmailRequired'] = "E-mail es un campo requerido";
$GLOBALS['strPwdRecEmailSent'] = "E-mail de recuperaci&oacute;n de contrase&ntilde;a enviado";
$GLOBALS['strPwdRecEmailNotFound'] = "Direcci&oacute;n e-mail no encontrada";
$GLOBALS['strPwdRecPasswordSaved'] = "Se ha guardado la nueva contrase&ntilde;a, proceda a <a href='index.php'>iniciar sesi&oacute;n</a>";
$GLOBALS['strPwdRecWrongId'] = "ID err&oacute;neo";
$GLOBALS['strPwdRecEnterEmail'] = "Introduzca su direcci&oacute;n e-mail a continuaci&oacute;n";
$GLOBALS['strPwdRecEnterPassword'] = "Introduzca su nueva contrase&ntilde;a a continuaci&oacute;n";
$GLOBALS['strPwdRecResetLink'] = "Enlace de reset de contrase&ntilde;a";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "Recuperaci&oacute;n de contrase&ntilde;a %s";
$GLOBALS['strAuditTrail'] = "Audit Trail";
$GLOBALS['strLinkNewUser'] = "Asignar nuevo usuario";
$GLOBALS['strUserAccess'] = "Acceso de usuario";
$GLOBALS['strMyAccount'] = "Mi cuenta";
$GLOBALS['strCampaignStatusRunning'] = "Empezada";
$GLOBALS['strCampaignStatusPaused'] = "Pausada";
$GLOBALS['strCampaignStatusAwaiting'] = "A&ntilde;adida";
$GLOBALS['strCampaignStatusExpired'] = "Completada";
$GLOBALS['strCampaignStatusApproval'] = "Esperando aprobaci&oacute;n &raquo;";
$GLOBALS['strCampaignStatusRejected'] = "Rechazada";
$GLOBALS['strCampaignApprove'] = "Aprobada";
$GLOBALS['strCampaignApproveDescription'] = "aceptar esta campa&ntilde;a";
$GLOBALS['strCampaignReject'] = "Rechazar";
$GLOBALS['strCampaignRejectDescription'] = "rechazar esta campa&ntilde;a";
$GLOBALS['strCampaignPause'] = "Pausar";
$GLOBALS['strCampaignPauseDescription'] = "pausar esta campa&ntilde;a";
$GLOBALS['strCampaignRestart'] = "Resumir";
$GLOBALS['strCampaignRestartDescription'] = "resumir esta campa&ntilde;a";
$GLOBALS['strCampaignStatus'] = "Estado de campa&ntilde;a";
$GLOBALS['strReasonForRejection'] = "Raz&oacute;n para rechazo";
$GLOBALS['strReasonSiteNotLive'] = "P&aacute;gina no accesible";
$GLOBALS['strReasonBadCreative'] = "Creatividad inapropiada";
$GLOBALS['strReasonBadUrl'] = "URL de destino inapropiada";
$GLOBALS['strReasonBreakTerms'] = "P&aacute;gina web no cumple de t&eacute;rminos y condiciones";
$GLOBALS['strTrackerPreferences'] = "Preferencias del tracker";
$GLOBALS['strSelectPublisher'] = "Seleccionar p&aacute;gina web";
$GLOBALS['strSelectZone'] = "Seleccionar zona";
$GLOBALS['strMainPreferences'] = "Opciones principales";
$GLOBALS['strAccountPreferences'] = "Preferencias de cuenta";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Preferencias de informes de campa&ntilde;a por e-mail";
$GLOBALS['strAdminEmailWarnings'] = "Avisos e-mail de administrador";
$GLOBALS['strAgencyEmailWarnings'] = "Avisos e-mail de agencia";
$GLOBALS['strAdveEmailWarnings'] = "Avisos e-mail de anunciante";
$GLOBALS['strFullName'] = "Nombre completo";
$GLOBALS['strEmailAddress'] = "Direcci&oacute;n e-mail";
$GLOBALS['strUserDetails'] = "Detalles usuario";
$GLOBALS['strLanguageTimezone'] = "Idioma y zona horaria";
$GLOBALS['strLanguageTimezonePreferences'] = "Preferencias de idioma y zona horaria";
$GLOBALS['strUserProperties'] = "Propiedades de usuario";
$GLOBALS['strBack'] = "Atr&aacute;s";
$GLOBALS['strUsernameToLink'] = "Nombre de usuario del usuario a asignar";
$GLOBALS['strEmailToLink'] = "E-mail del usuario a asignar";
$GLOBALS['strNewUserWillBeCreated'] = "Se crear&aacute; un nuevo usuario";
$GLOBALS['strToLinkProvideEmail'] = "Para asignar un usuario, indique el e-mail";
$GLOBALS['strToLinkProvideUsername'] = "Para asignar un usuario, indique el username";
$GLOBALS['strPermissions'] = "Permisos";
$GLOBALS['strContactName'] = "Nombre de contacto";
$GLOBALS['strPwdRecReset'] = "Borrar password";
$GLOBALS['strPwdRecResetPwdThisUser'] = "Borrar password para este usuario";
$GLOBALS['strAdSenseAccounts'] = "Cuentas AdSense";
$GLOBALS['strLinkAdSenseAccount'] = "Enlazar cuenta AdSense";
$GLOBALS['strCreateAdSenseAccount'] = "Crear cuenta AdSense";
$GLOBALS['strEditAdSenseAccount'] = "Editar cuenta AdSense";
$GLOBALS['strAllowCreateAccounts'] = "Permitir a este usuario crear cuentas nuevas";
$GLOBALS['strErrorWhileCreatingUser'] = "Error al crear usuario: %s";
$GLOBALS['strAuditNoData'] = "No se ha guardado actividad de usuario durante el espacio de tiempo que ha seleccionado.";
$GLOBALS['strPublisherReports'] = "Informes de p&aacute;ginas web";
$GLOBALS['strVariableHidden'] = "&iquest;Esconder variable a p&aacute;ginas web?";
$GLOBALS['strAuditTrailSetup'] = "Configurar hoy Audit Trail";
$GLOBALS['strAuditTrailGoTo'] = "Ir a p&aacute;gina de Audit Trail";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Audit Trail permite ver qui&eacute;n ha hecho qu&eacute;. O dicho de otra manera, guarda todos los cambios en el sistema de Openads</li> \\n<li>Si ve este mensaje, es porque no ha activado Audit Trail</li> \\n<li>Interesado en aprender m&aacute;s? Lea la <a href=\'\".OA_DOCUMENTATION_BASE_URL.\"/help/2.5/settings/userLog/\' class=\'site-link\' target=\'help\' >documentaci&oacute;n de Audit Trail</a></li>";
$GLOBALS['strAdminAccess'] = "Acceso de administrador";
$GLOBALS['strOverallAdvertisers'] = "anunciante(s)";
$GLOBALS['strAdvertiserSignup'] = "Alta de anunciante";
$GLOBALS['strAdvertiserSignupDesc'] = "Reg&iacute;strese para disponer de autoservicio de anunciante y pagos";
$GLOBALS['strOverallCampaigns'] = "campa&ntilde;a(s)";
$GLOBALS['strChangeStatus'] = "Cambiar estado";
$GLOBALS['strImpression'] = "Impresi&oacute;n";
$GLOBALS['strSwitchAccount'] = "Cambiar a esta cuenta";
$GLOBALS['strCampaignAuditTrailSetup'] = "Activar Audit Trail para empezar a ver Campa&ntilde;as";
$GLOBALS['strUnsavedChanges'] = "Hay cambios sin guardar en esta p&aacute;gina; aseg&uacute;rese de pulsar \"Guardar cambios\" al finalizar";
$GLOBALS['strDeliveryLimitationsDisagree'] = "ADVERTENCIA> Las limitaciones del sistema de entrega <b>NO EST&Aacute;N DE ACUERDO</b> con las limitaciones mostradas a continuaci&oacute;n<br />Por favor, haga clic en guardar cambios para actualizar las reglas del sistema de entrega";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "Hay campa&ntilde;as de pago todav&iacute;a enlazadas a esta zona, si la borra estas campa&ntilde;as no se ejecutar&aacute;n y no recibir&aacute; los pagos correspondientes.";
$GLOBALS['strTrackers'] = "Trackers";
$GLOBALS['strFieldStartDateBeforeEnd'] = "La fecha \'desde\' debe ser anterior a la fecha de \'hasta\'";
$GLOBALS['strFromVersion'] = "De la versi&oacute;n";
$GLOBALS['strToVersion'] = "A versi&oacute;n";
$GLOBALS['strToggleDataBackupDetails'] = "clic para cambiar estado de detalles de copia de seguridad";
$GLOBALS['strClickViewBackupDetails'] = "clic aqu&iacute; para mostrar detalles de copia de seguridad";
$GLOBALS['strClickHideBackupDetails'] = "clic aqu&iacute; para ocultar detalles de copia de seguridad";
$GLOBALS['strShowBackupDetails'] = "Mostrar detalles de copia de seguridad de datos";
$GLOBALS['strHideBackupDetails'] = "Ocultar detalles de copia de seguridad de datos";
$GLOBALS['strInstallation'] = "Instalaci&oacute;n";
$GLOBALS['strBackupDeleteConfirm'] = "Realmente desea borrar todas las copias de seguridad creadas por esta actualizaci&oacute;n?";
$GLOBALS['strDeleteArtifacts'] = "Borrar artefactos";
$GLOBALS['strArtifacts'] = "Artefactos";
$GLOBALS['strBackupDbTables'] = "Copia de seguridad de la base de datos";
$GLOBALS['strUnableToWriteConfig'] = "No se ha podido escribir los datos en el archivo de configuraci&oacute;n";
$GLOBALS['strUnableToWritePrefs'] = "No se ha podido guardar las preferencias en la base de datos";
$GLOBALS['strConfigurationSetup'] = "Lista de comprobaci&oacute;n de la configuraci&oacute;n";
$GLOBALS['strConfigurationSettings'] = "Opciones de configuraci&oacute;n";
$GLOBALS['strAdminPassword'] = "Contrase&ntilde;a de administrador";
$GLOBALS['strAdministratorEmail'] = "Direcci&oacute;n e-mail del administrador";
$GLOBALS['strNovice'] = "Las acciones de borrado necesitan confirmaci&oacute;n por seguridad";
$GLOBALS['strTimezoneInformation'] = "Informaci&oacute;n de zona horaria (modificar la zona horaria afectar&aacute; a las estad&iacute;sticas)";
$GLOBALS['strDefaultBannerDestination'] = "URL de destino predeterminada";
$GLOBALS['strDbType'] = "Tipo de base de datos";
$GLOBALS['strDbPort'] = "Puerto de la base de datos";
$GLOBALS['strDemoDataInstall'] = "Instalar datos de demostraci&oacute;n";
$GLOBALS['strDemoDataIntro'] = "Se pueden cargar datos iniciales predeterminados en ".MAX_PRODUCT_NAME." para ayudarle a empezar a servir anuncios online. Los tipos de banners m&aacute;s comunes, as&iacute; como algunas campa&ntilde;as iniciales se pueden cargar y pre-configurar. Altamente recomendado para instalaciones nuevas.";
$GLOBALS['strDebugSettings'] = "Grabar debug";
$GLOBALS['strDebug'] = "Opciones globales de grabaci&oacute;n de debug";
$GLOBALS['strProduction'] = "Servidor en producci&oacute;n";
$GLOBALS['strEnableDebug'] = "Activar grabaci&oacute;n de debug";
$GLOBALS['strDebugMethodNames'] = "Incluir nombres de m&eacute;todos en el log del debug";
$GLOBALS['strDebugLineNumbers'] = "Incluir n&uacute;meros de l&iacute;nea en el log del debug";
$GLOBALS['strDebugType'] = "Tipo de log de debug";
$GLOBALS['strDebugTypeFile'] = "Archivo";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "Base de datos SQL";
$GLOBALS['strDebugTypeSyslog'] = "Syslog";
$GLOBALS['strDebugName'] = "Nombre de log de debug, Calendario, tabla SQL, <br /> o elemento Syslog";
$GLOBALS['strDebugPriority'] = "Nivel de prioridad del debug";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - M&aacute;s informaci&oacute;n";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Informaci&oacute;n por defecto";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - Menos informaci&oacute;n";
$GLOBALS['strDebugIdent'] = "Cadena de identificaci&oacute;n del debug";
$GLOBALS['strDebugUsername'] = "mCal, nombre de usuario de servidor SQL";
$GLOBALS['strDebugPassword'] = "mCal, contrase&ntilde;a de servidor SQL";
$GLOBALS['strDeliverySettings'] = "Opciones de entrega";
$GLOBALS['strWebPath'] = "Paths de acceso al servidor ";
$GLOBALS['strWebPathSimple'] = "Path de la web";
$GLOBALS['strDeliveryPath'] = "Path de entrega";
$GLOBALS['strImagePath'] = "Path de im&aacute;genes";
$GLOBALS['strDeliverySslPath'] = "Path de entrega SSL";
$GLOBALS['strImageSslPath'] = "Path de im&aacute;genes SSL";
$GLOBALS['strImageStore'] = "Carpeta de im&aacute;genes";
$GLOBALS['strTypeDirError'] = "No se puede escribir en el directorio local";
$GLOBALS['strTypeFTPPassive'] = "Usar FTP pasivo";
$GLOBALS['strTypeFTPErrorDir'] = "El directorio del host FTP no existe";
$GLOBALS['strTypeFTPErrorConnect'] = "No se ha podido conectar al servidor FTP, el usuario o la contrase&ntilde;a son incorrectos.";
$GLOBALS['strTypeFTPErrorHost'] = "El host FTP no es correcto";
$GLOBALS['strDeliveryFilenames'] = "Nombre de archivos de entrega";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Ad Click";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "Ad Conversion Variables";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Ad Content";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "Ad Conversion";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "Ad Conversion (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Ad Frame";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Ad Image";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Ad (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Ad Layer";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Ad Log";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Ad Popup";
$GLOBALS['strDeliveryFilenamesAdView'] = "Ad View";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "Invocaci&oacute;n XML RPC";
$GLOBALS['strDeliveryFilenamesLocal'] = "Invocaci&oacute;n local";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Controlador frontal";
$GLOBALS['strDeliveryFilenamesFlash'] = "Incluir Flash (puede ser una URL completa)";
$GLOBALS['strDeliveryCaching'] = "Opciones de cache de entrega";
$GLOBALS['strCacheFiles'] = "Archivo";
$GLOBALS['strDeliveryCacheLimit'] = "Tiempo entre refresco de cache de banners (segundos)";
$GLOBALS['strOrigin'] = "Usar servidor de origen remoto";
$GLOBALS['strOriginType'] = "Tipo de servidor de origen";
$GLOBALS['strOriginHost'] = "Nombre de host para el servidor remoto";
$GLOBALS['strOriginPort'] = "Puerto para la base de datos de origen";
$GLOBALS['strOriginScript'] = "Archivo script para la base de datos de origen";
$GLOBALS['strOriginTypeXMLRPC'] = "XMLRPC";
$GLOBALS['strOriginTimeout'] = "Tiempo de espera en origen (segundos)";
$GLOBALS['strOriginProtocol'] = "Protocolo del servidor origen";
$GLOBALS['strDeliveryBanner'] = "Opciones globales de entrega de banners";
$GLOBALS['strDeliveryAcls'] = "Evaluar limitaciones de entrega de banners durante la entrega";
$GLOBALS['strDeliveryObfuscate'] = "Ofuscar el canal durante la entrega de anuncios";
$GLOBALS['strDeliveryExecPhp'] = "Permitir ejecutar c&oacute;digo PHP en anuncios <br /> (Peligro: riesgo de seguridad)";
$GLOBALS['strDeliveryCtDelimiter'] = "Delimitador de tracking de cookies de terceros";
$GLOBALS['strGeotargetingSettings'] = "Opciones de Geotargeting";
$GLOBALS['strGeotargeting'] = "Opciones globales de Geotargeting";
$GLOBALS['strGeotargetingType'] = "Tipo de m&oacute;dulo de Geotargeting";
$GLOBALS['strGeotargetingGeoipCountryLocation'] = "Ubicaci&oacute;n de la base de datos de pa&iacute;ses de MaxMind GeoIP<br />(Dejar en blanco para usar la base de datos gratuita)";
$GLOBALS['strGeotargetingGeoipRegionLocation'] = "Ubicaci&oacute;n de la base de datos de regiones de MaxMind GeoIP";
$GLOBALS['strGeotargetingGeoipCityLocation'] = "Ubicaci&oacute;n de la base de datos de ciudades de MaxMind GeoIP";
$GLOBALS['strGeotargetingGeoipAreaLocation'] = "Ubicaci&oacute;n de la base de datos de &aacute;reas de MaxMind GeoIP";
$GLOBALS['strGeotargetingGeoipDmaLocation'] = "Ubicaci&oacute;n de la base de datos de DMA de MaxMind GeoIP";
$GLOBALS['strGeotargetingGeoipOrgLocation'] = "Ubicaci&oacute;n de la base de datos de organizaciones de MaxMind GeoIP";
$GLOBALS['strGeotargetingGeoipIspLocation'] = "Ubicaci&oacute;n de la base de datos de ISPs de MaxMind GeoIP";
$GLOBALS['strGeotargetingGeoipNetspeedLocation'] = "Ubicaci&oacute;n de la base de datos de Netspeed de MaxMind GeoIP";
$GLOBALS['strGeoSaveStats'] = "Guardar los datos de GeoIP en los logs de la base de datos";
$GLOBALS['strGeoShowUnavailable'] = "Mostrar limitaciones de entrega de Geotargeting incluso si GeoIP no est&aacute; disponible";
$GLOBALS['strGeotrackingGeoipCountryLocationError'] = "La base de datos de pa&iacute;ses de MaxMind GeoIP no existe en la ubicaci&oacute;n especificada";
$GLOBALS['strGeotrackingGeoipRegionLocationError'] = "La base de datos de regiones de MaxMind GeoIP no existe en la ubicaci&oacute;n especificada";
$GLOBALS['strGeotrackingGeoipCityLocationError'] = "La base de datos de ciudades de MaxMind GeoIP no existe en la ubicaci&oacute;n especificada";
$GLOBALS['strGeotrackingGeoipAreaLocationError'] = "La base de datos de &aacute;reas de MaxMind GeoIP no existe en la ubicaci&oacute;n especificada";
$GLOBALS['strGeotrackingGeoipDmaLocationError'] = "La base de datos de DMA de MaxMind GeoIP no existe en la ubicaci&oacute;n especificada";
$GLOBALS['strGeotrackingGeoipOrgLocationError'] = "La base de datos de organizaciones de MaxMind GeoIP no existe en la ubicaci&oacute;n especificada";
$GLOBALS['strGeotrackingGeoipIspLocationError'] = "La base de datos de ISPs de MaxMind GeoIP no existe en la ubicaci&oacute;n especificada";
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = "La base de datos de Netspeed de MaxMind GeoIP no existe en la ubicaci&oacute;n especificada";
$GLOBALS['strGUIAnonymousCampaignsByDefault'] = "Marcar campa&ntilde;as como an&oacute;nimas por defecto";
$GLOBALS['strPublisherDefaults'] = "Valores predeterminados de la web";
$GLOBALS['strModesOfPayment'] = "Modos de pago";
$GLOBALS['strCurrencies'] = "Monedas";
$GLOBALS['strCategories'] = "Categor&iacute;as";
$GLOBALS['strHelpFiles'] = "Archivos de ayuda";
$GLOBALS['strHasTaxID'] = "ID tasas";
$GLOBALS['strDefaultApproved'] = "Checkbox aprobado";
$GLOBALS['strInvocationDefaults'] = "Valores predeterminados de invocaci&oacute;n";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Activar <i>clicktracking</i> de terceros por defecto";
$GLOBALS['strStatisticsLogging'] = "Opciones globales de log de estad&iacute;sticas";
$GLOBALS['strCsvImport'] = "Permitir upload de conversiones offline";
$GLOBALS['strLogAdRequests'] = "Grabar una petici&oacute;n (Ad Request) cada vez que se pida un banner";
$GLOBALS['strLogAdImpressions'] = "Grabar una impresi&oacute;n (Ad Impression) cada vez que se vea un banner";
$GLOBALS['strLogAdClicks'] = "Grabar un clic (Ad Click) cada vez que un visitante haga clic en un banner";
$GLOBALS['strLogTrackerImpressions'] = "Grabar una impresi&oacute;n de tracker (Tracker Impression) cada vez que se vea un puntero de un tracker";
$GLOBALS['strSniff'] = "Extraer informaci&oacute;n sobre sistema operativo y navegador del visitante usando phpSniff";
$GLOBALS['strPreventLogging'] = "Opciones de prevenci&oacute;n de grabado de estad&iacute;sticas";
$GLOBALS['strBlockAdViews'] = "No contar impresiones si el visitante ha visto el mismo par de anuncios/zonas en un rango de tiempo espec&iacute;fico (segundos)";
$GLOBALS['strBlockAdViewsError'] = "El valor de bloqueo de una Ad Impression debe ser un n&uacute;mero entero positivo";
$GLOBALS['strBlockAdClicks'] = "No contar clics (Ad Clicks) si el visitante ha hecho clic en el mismo par de anuncios/zonas en un rango de tiempo espec&iacute;fico (segundos)";
$GLOBALS['strBlockAdClicksError'] = "El valor de bloqueo de un Ad Click debe ser un n&uacute;mero entero positivo";
$GLOBALS['strMaintenaceSettings'] = "Opciones globales de mantenimiento";
$GLOBALS['strMaintenanceOI'] = "Intervalo de operaci&oacute;n de mantenimiento (minutos)";
$GLOBALS['strMaintenanceOIError'] = "El intervalo de operaci&oacute;n de mantenimiento no es v&aacute;lido - lea la documentaci&oacute;n para ver los valores v&aacute;lidos";
$GLOBALS['strMaintenanceCompactStats'] = "&iquest;Borrar estad&iacute;sticas brutas despu&eacute;s de procesar?";
$GLOBALS['strMaintenanceCompactStatsGrace'] = "Periodo de gracia antes de borrar estad&iacute;sticas procesadas (segundos)";
$GLOBALS['strPrioritySettings'] = "Opciones de prioridad";
$GLOBALS['strPriorityInstantUpdate'] = "Actualizar prioridades de anuncios inmediatamente al realizar cambios en la UI";
$GLOBALS['strWarnCompactStatsGrace'] = "El periodo de gracia de estad&iacute;sticas compactas debe ser un entero positivo";
$GLOBALS['strDefaultImpConWindow'] = "Ventana de conexi&oacute;n de Ad Impression por defecto (segundos)";
$GLOBALS['strDefaultImpConWindowError'] = "Al marcarse, la ventana de conexi&oacute;n de Ad Impression por defecto debe ser un entero positivo";
$GLOBALS['strDefaultCliConWindow'] = "Ventana de conexi&oacute;n de Ad Click por defecto (segundos)";
$GLOBALS['strDefaultCliConWindowError'] = " Al marcarse, la ventana de conexi&oacute;n de Ad Click por defecto debe ser un entero positivo";
$GLOBALS['strWarnLimitDays'] = "Enviar un aviso cuando los d&iacute;as restantes sean menos que los especificados aqu&iacute;";
$GLOBALS['strWarnLimitDaysErr'] = "El l&iacute;mite de aviso de d&iacute;as debe ser un entero positivo";
$GLOBALS['strWarnAgency'] = "Enviar un aviso a la agencia cada vez que una campa&ntilde;a vaya a expirar";
$GLOBALS['strMyHeaderError'] = "El archivo header no existe en la ubicaci&oacute;n que ha especificado";
$GLOBALS['strMyFooterError'] = "El archivo footer no existe en la ubicaci&oacute;n que ha especificado";
$GLOBALS['strDefaultTrackerStatus'] = "Estado por defecto del tracker";
$GLOBALS['strDefaultTrackerType'] = "Tipo predeterminado del tracker";
$GLOBALS['strMyLogo'] = "Nombre del archivo del logotipo personalizado";
$GLOBALS['strMyLogoError'] = "El archivo del logotipo no existe en el directorio admin/images";
$GLOBALS['strGuiHeaderForegroundColor'] = "Color principal de la cabecera";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Color secundario de la cabecera";
$GLOBALS['strGuiActiveTabColor'] = "Color de la pesta&ntilde;a activa";
$GLOBALS['strGuiHeaderTextColor'] = "Color del texto del header";
$GLOBALS['strColorError'] = "Por favor, introduzca los colores en formato RGB, como '0066CC'";
$GLOBALS['strReportsInterface'] = "Interfaz de informes";
$GLOBALS['strPublisherInterface'] = "Interfaz de la p&aacute;gina web";
$GLOBALS['strPublisherAgreementEnabled'] = "Activar control de inicio de sesi&oacute;n para p&aacute;ginas web que no han aceptado los T&eacute;rminos y condiciones";
$GLOBALS['strPublisherAgreementText'] = "Texto de inicio de sesi&oacute;n (c&oacute;digo HTML permitido)";
$GLOBALS['strLogoutURL'] = "URL de destino en cierre de sesi&oacute;n. <br /> Dejar en blanco para valor por defecto";
$GLOBALS['strAdmin'] = "Admin";
$GLOBALS['strNotice'] = "Atenci&oacute;n";
$GLOBALS['strCapping'] = "L&iacute;mites";
$GLOBALS['strRequests'] = "Peticiones";
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Alquiler mensual";
$GLOBALS['strHiddenPublisher'] = "P&aacute;gina web";
$GLOBALS['strRevenueInfo'] = "Informaci&oacute;n de ingresos";
$GLOBALS['strWarningMissing'] = "Aviso, probablemente falta";
$GLOBALS['strWarningMissingClosing'] = "tag de cierre \">\"";
$GLOBALS['strWarningMissingOpening'] = "tag de apertura \"<\"";
$GLOBALS['strSubmitAnyway'] = "Enviar de todas maneras";
$GLOBALS['strGreaterThan'] = "es mayor que";
$GLOBALS['strLessThan'] = "es menor que";
$GLOBALS['strAffiliateInvocation'] = "C&oacute;digo de invocaci&oacute;n";
$GLOBALS['strTotalAffiliates'] = "P&aacute;ginas web totales";
$GLOBALS['strTotalZones'] = "Zonas totales";
$GLOBALS['strCostInfo'] = "Coste medi&aacute;tico";
$GLOBALS['strTechnologyCost'] = "Coste tecnol&oacute;gico";
$GLOBALS['strWarnChangeZoneType'] = "Cambiar el tipo de zona a texto o a e-mail desenlazara todos los banners/campa&ntilde;as debido a restricciones en esos tipos de zonas\n   <ul>\n      <li>Zonas de texto s&oacute;lo pueden enlazarse con banners de texto</li>\n      <li>Campa&ntilde;as en zonas de e-mail s&oacute;lo pueden tener un banner activo a la vez</li>\n   </ul>";
$GLOBALS['strWarnChangeZoneSize'] = "Cambiar la zona desenlazar&aacute; cualquier banner que no tenga el nuevo tama&ntilde;o, y a&ntilde;adir&aacute; banners de campa&ntilde;as enlazadas que coincidan con el nuevo tama&ntilde;o";
$GLOBALS['strSelectAdvertiser'] = "Seleccione anunciante";
$GLOBALS['strSelectPlacement'] = "Seleccione campa&ntilde;a";
$GLOBALS['strSelectAd'] = "Seleccione banner";
$GLOBALS['strStatusPending'] = "Pendiente";
$GLOBALS['strStatusApproved'] = "Aprobado";
$GLOBALS['strStatusDisapproved'] = "No aprobado";
$GLOBALS['strStatusDuplicate'] = "Duplicado";
$GLOBALS['strStatusOnHold'] = "En espera";
$GLOBALS['strStatusIgnore'] = "Ignorar";
$GLOBALS['strConnectionType'] = "Tipo";
$GLOBALS['strConnTypeSale'] = "Venta";
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Alta";
$GLOBALS['strShortcutEditStatuses'] = "Editat estados";
$GLOBALS['strShortcutShowStatuses'] = "Mostrar estados";
$GLOBALS['strEmailNoDates'] = "Las zonas de campa&ntilde;as de e-mails deben tener fecha de inicio y finalizaci&oacute;n";
$GLOBALS['strCappingBanner']['limit'] = "Limitar vistas de banners a:";
$GLOBALS['strCappingCampaign']['limit'] = "Limitar vistas de campa&ntilde;a a:";
$GLOBALS['strCappingZone']['limit'] = "Limitar vistas de zonas a:";
$GLOBALS['strOpenadsEmail'] = "".MAX_PRODUCT_NAME." . \" E-mail";
$GLOBALS['strEmailSettings'] = "Configuraci&oacute;n e-mail";
$GLOBALS['strEnableQmailPatch'] = "Activar parche qmail";
$GLOBALS['strEmailHeader'] = "Cabeceras e-mail";
$GLOBALS['strEmailLog'] = "Log e-mail";
$GLOBALS['strEnableAudit'] = "Activar Audit Trail";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Su instalaci&oacute;n de PHP no soporta FTP.";
$GLOBALS['strGeotargetingUseBundledCountryDb'] = "Usar la base de datos MaxMind GeoLiteCountry adjunta";
$GLOBALS['strConfirmationUI'] = "Confirmaci&oacute;n en interfaz de usuario";
$GLOBALS['strBannerStorage'] = "Configuraci&oacute;n de almacenamiento de banners";
$GLOBALS['strMaintenanceSettings'] = "Configuraci&oacute;n del mantenimento";
$GLOBALS['strSSLSettings'] = "Configuraci&oacute;n SSL";
$GLOBALS['requireSSL'] = "Forzar acceso SSL en interfaz de usuario";
$GLOBALS['sslPort'] = "Puerto SSL usado por el servidor web";
$GLOBALS['strLinkNewUser_Key'] = "Enlazar <u>u</u>suario";
$GLOBALS['strBannerPreferences'] = "Preferencias de banner";
$GLOBALS['strAdvertiserSetup'] = "Alta de anunciante";
$GLOBALS['strUserInterfacePreferences'] = "Preferencias de interfaz de usuario";
$GLOBALS['strInvocationPreferences'] = "Preferencias de invocaci&oacute;n";
$GLOBALS['strAlreadyInstalled'] = "".MAX_PRODUCT_NAME.".\" ya est&aacute; instalado en este sistema. Si quiere configurarlo vaya a <a href=\'account-index.php\'>opciones de interfaz</a>\";";
$GLOBALS['strAllowEmail'] = "Permitir el env&iacute;o de e-mails globalmente";
$GLOBALS['strEmailAddressFrom'] = "Direcci&oacute;n e-mail desde donde enviar los informes";
$GLOBALS['strEmailAddressName'] = "Compa&ntilde;&iacute;a o nombre para firmar los e-mails";
$GLOBALS['keyLinkUser'] = "u";
$GLOBALS['strUserLinkedToAccount'] = "El usuario ha sido asignado a la cuenta";
$GLOBALS['strUserAccountUpdated'] = "Cuenta de usuario actualizada";
$GLOBALS['strUserUnlinkedFromAccount'] = "El usuario ha sido separado de la cuenta";
$GLOBALS['strUserWasDeleted'] = "El usuario ha sido borrado";
$GLOBALS['strUserNotLinkedWithAccount'] = "El usuario no est&aacute; asignado a la cuenta";
$GLOBALS['strWorkingAs'] = "Trabajando como";
$GLOBALS['strWorkingFor'] = "%s para&hellip;";
$GLOBALS['strCantDeleteOneAdminUser'] = "No puede borrar el usuario. Almenos un usuario necesita estar asignado a la cuenta de admin.";
$GLOBALS['strWarnChangeBannerSize'] = "Cambiar el tama&ntilde;o del banner lo desmarcar&aacute; de todas las zonas que no tengan el nuevo tama&ntilde;o, y si la <b>campa&ntilde;a</b> del banner est&aacute; enlazada con una zona del nuevo tama&ntilde;o, el banner se asignar&aacute; autom&aacute;ticamente";
$GLOBALS['strLinkUserHelp'] = "Para asignar un <b>usuario existente</b>, escriba username y haga clic en \"\' . $GLOBALS[\'strLinkUser\'] . \'\". Para asignar un <b>nuevo usuario</b>, escriba el username deseado y haga clic en \"\' . $GLOBALS[\'strLinkUser\'] . \'\".";
$GLOBALS['strCampaignGoTo'] = "Ir a p&aacute;gina de campa&ntilde;as";
$GLOBALS['strCampaignSetUp'] = "Registrar hoy una campa&ntilde;a";
$GLOBALS['strCampaignNoRecords'] = "<li>Las campa&ntilde;as permiten agrupar cualquier n&uacute;mero de banners, de cualquier tama&ntilde;o, que comparten ciertos requisitos</li> \\n<li>Ahorre tiempo agrupando banners en una campa&ntilde;a y sin tener que definir opciones de entrega para cada uno por separado</li>  \\n<li>&iexcl;Lea la <a class=\"site-link\" target=\"help\" href=\"\'.OA_DOCUMENTATION_BASE_URL.\'/help/2.5/inventory/advertisersAndCampaigns/campaigns/\">documentaci&oacute;n sobre Campa&ntilde;as</a>!</li>";
$GLOBALS['strPublisherHistoryDescription'] = "Informe de distribuci&oacute;n de p&aacute;gina web para anunciante.";
$GLOBALS['strPublisherZoneHistoryDescription'] = "Informe de distribuci&oacute;n de p&aacute;gina web y zonas para anunciante.";
$GLOBALS['strPublisherConversionTrackingAnalysisDescription'] = "Este informe muestra un desglose de toda la actividad de conversi&oacute;n para una p&aacute;gina web particular (afiliado).";
$GLOBALS['strCampaignNoDataTimeSpan'] = "No se han encontrado campa&ntilde;as que empiecen o terminen en el espacio de tiempo que ha seleccionado";
$GLOBALS['strCampaignAuditNotActivated'] = "Para ver campa&ntilde;as que hayan empezado o terminado en el espacio de tiempos eleccionado, Audit Trail debe estar activado";
$GLOBALS['strTotalRevenue'] = "Facturaci&oacute;n total";
$GLOBALS['strOpenadsImpressionsRemaining'] = "Impresiones de Openads pendientes";
$GLOBALS['strOpenadsImpressionsRemainingHelp'] = "El n&uacute;mero de impresiones pendientes es demasiado bajo para satisfacer el n&uacute;mero solicitado por el anunciante. Esto significa que el n&uacute;mero de clics locales es m&aacute;s bajo que el n&uacute;mero de clics central y deber&iacute;a aumentar el n&uacute;mero de impresiones contratadas por el valor que falta.";
$GLOBALS['strOpenadsClicksRemaining'] = "Clics de Openads pendientes";
$GLOBALS['strOpenadsConversionsRemaining'] = "Conversiones de Openads pendientes";
$GLOBALS['strOverallBanners'] = "banner(s)";
$GLOBALS['strPeriod'] = "Periodo";
$GLOBALS['strWorksheets'] = "Hojas de trabajo";
$GLOBALS['strAdditionalItems'] = "e &iacute;tems adicionales";
$GLOBALS['strFor'] = "para";
$GLOBALS['strTermsIntro'] = "".MAX_PRODUCT_NAME." . \" es distribuido libremente bajo una licencia de C&oacute;digo Abierto, la GNU Public License v2.";
$GLOBALS['strPercentRevenueSplit'] = "% Divisi&oacute;n de facturaci&oacute;n";
$GLOBALS['strPercentBasketValue'] = "% Valor de cesta";
$GLOBALS['strAmountPerItem'] = "Cantidad por &iacute;tem";
$GLOBALS['strPercentCustomVariable'] = "% Variable personalizada";
$GLOBALS['strPercentSumVariables'] = "% Suma de variables";
$GLOBALS['strInventoryForecasting'] = "Predicci&oacute;n de inventario";
$GLOBALS['strIab']['IAB Full Banner (468 x 60)'] = "IAB Banner (468 x 60)";
$GLOBALS['strIab']['IAB Skyscraper (120 x 600)'] = "IAB Rascacielos (120 x 600)";
$GLOBALS['strIab']['IAB Leaderboard (728 x 90)'] = "IAB Jumbo (728 x 90)";
$GLOBALS['strIab']['IAB Button 1 (120 x 90)'] = "IAB Bot&oacute;n 1 (120 x 90)";
$GLOBALS['strIab']['IAB Button 2 (120 x 60)'] = "IAB Bot&oacute;n 2 (120 x 60)";
$GLOBALS['strIab']['IAB Half Banner (234 x 60)'] = "IAB Medio banner (234 x 60)";
$GLOBALS['strIab']['IAB Leader Board (728 x 90) *'] = "IAB Jumbo (728 x 90)";
$GLOBALS['strIab']['IAB Micro Bar (88 x 31)'] = "IAB Micro Barra (88 x 31)";
$GLOBALS['strIab']['IAB Square Button (125 x 125)'] = "IAB Bot&oacute;n Cuadrado (125 x 125)";
$GLOBALS['strIab']['IAB Rectangle (180 x 150) *'] = "IAB Rect&aacute;ngulo (180 x 150) *";
$GLOBALS['strIab']['IAB Square Pop-up (250 x 250)'] = "IAB Pop-up Cuadrado (250 x 250)";
$GLOBALS['strIab']['IAB Vertical Banner (120 x 240)'] = "IAB Banner Vertical (120 x 240)";
$GLOBALS['strIab']['IAB Medium Rectangle (300 x 250) *'] = "IAB Robap&aacute;ginas (300 x 250) *";
$GLOBALS['strIab']['IAB Large Rectangle (336 x 280)'] = "IAB Rect&aacute;ngulo Grande (336 x 280)";
$GLOBALS['strIab']['IAB Vertical Rectangle (240 x 400)'] = "IAB Rect&aacute;ngulo Vertical (240 x 400)";
$GLOBALS['strIab']['IAB Wide Skyscraper (160 x 600) *']'] = "IAB Rascacielos Ancho (160 x 600) *";
$GLOBALS['strDateLinked'] = "Fecha de enlace";
$GLOBALS['strAdvertiserSignupLink'] = "Enlace de alta de anunciante";
$GLOBALS['strAdvertiserSignupLinkDesc'] = "Para a&ntilde;adir un enlace de alta de anunciante a su p&aacute;gina, por favor copie el HTML a continuaci&oacute;n:";
$GLOBALS['strAdvertiserSignupOption'] = "Opciones de alta de anunciante";
$GLOBALS['strAdvertiserSignunOptionDesc'] = "Para editar las opciones de alta de anunciante, siga";
$GLOBALS['strEmailAddresses'] = "Direcci&oacute;n del remitente del email";
$GLOBALS['strEmailFromName'] = "Nombre del remitente del email";
$GLOBALS['strEmailFromAddress'] = "Direcci&oacute;n email del remitente del email";
$GLOBALS['strAccount'] = "Cuenta";
$GLOBALS['strAccountUserAssociation'] = "Asociaci&oacute;n de cuenta a usuario";
$GLOBALS['strAdZoneAssociation'] = "Asociaci&oacute;n de anuncio a zona";
$GLOBALS['strImage'] = "Imagen";
$GLOBALS['strCampaignZoneAssociation'] = "Asociaci&oacute;n de campa&ntilde;a a zona";
$GLOBALS['strAccountPreferenceAssociation'] = "Asociaci&oacute;n de preferencias de cuenta";
$GLOBALS['strHomePageDisabled'] = "Su p&aacute;gina de inicio est&aacute; deshabilitada";
$GLOBALS['strNoSslSupport'] = "Su instalaci&oacute;n no soporta actualmente SSL";
$GLOBALS['strSslAccessCentralSys'] = "Para acceder a la p&aacute;gina de inicio, su adserver debe ser capaz de identificarse en modo seguro en nuestro sistema central, usando secure socket layer (SSL).";
$GLOBALS['strInstallSslExtension'] = "Es necesario instalar una extensi&oacute;n de PHP para comunicarse v&iacute;a SSL, bien openssl o curl con SSL activado. Para m&aacute;s informaci&oacute;n contacte con su administrador de sistemas.";
$GLOBALS['strChoosenDisableHomePage'] = "Ha seleccionado deshabilitar su p&aacute;gina de inicio";
$GLOBALS['strAccessHomePage'] = "Haga clic aqu&iacute; para acceder a su p&aacute;gina de inicio";
$GLOBALS['strEditSyncSettings'] = "y edita sus opciones de sincronizaci&oacute;n";
$GLOBALS['strLogFiles'] = "Archivos de log";
$GLOBALS['strConfigBackups'] = "Conf. copias de seguridad";
$GLOBALS['strUpdatedDbVersionStamp'] = "Actualizada la versi&oacute;n de la base de datos";
$GLOBALS['aProductStatus']['UPGRADE COMPLETE'] = "ACTUALIZACI&Oacute;N COMPLETADA";
$GLOBALS['aProductStatus']['UPGRADE FAILED'] = "ACTUALIZACI&Oacute;N FALLIDA";
?>