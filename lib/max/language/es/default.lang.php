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
$GLOBALS['date_format'] = "%d/%m/%Y";
$GLOBALS['minute_format'] = "%H:%M";
$GLOBALS['month_format'] = "%m/%Y";
$GLOBALS['day_format'] = "%m/%d";
$GLOBALS['week_format'] = "%W/%Y";
$GLOBALS['weekiso_format'] = "%V/%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "Inicio";
$GLOBALS['strHelp'] = "Ayuda";
$GLOBALS['strStartOver'] = "Comenzar de nuevo";
$GLOBALS['strShortcuts'] = "Atajos";
$GLOBALS['strActions'] = "Acciones";
$GLOBALS['strAndXMore'] = "y %s más";
$GLOBALS['strAdminstration'] = "Inventario";
$GLOBALS['strMaintenance'] = "Mantenimiento";
$GLOBALS['strProbability'] = "Probabilidad";
$GLOBALS['strInvocationcode'] = "Código de invocación";
$GLOBALS['strBasicInformation'] = "Informaci&oacute;n B&aacute;sica";
$GLOBALS['strAppendTrackerCode'] = "Añadir código de tracker";
$GLOBALS['strOverview'] = "Resumen";
$GLOBALS['strSearch'] = "<u>B</u>uscar";
$GLOBALS['strDetails'] = "Detalles";
$GLOBALS['strUpdateSettings'] = "Configuración de Actualizaciones";
$GLOBALS['strCheckForUpdates'] = "Comprobar actualizaciones";
$GLOBALS['strWhenCheckingForUpdates'] = "Al comprobar si hay actualizaciones";
$GLOBALS['strCompact'] = "Compactar";
$GLOBALS['strUser'] = "Usuario";
$GLOBALS['strDuplicate'] = "Duplicado";
$GLOBALS['strCopyOf'] = "Copia de";
$GLOBALS['strMoveTo'] = "Mover a";
$GLOBALS['strDelete'] = "Borrar";
$GLOBALS['strActivate'] = "Activar";
$GLOBALS['strConvert'] = "Convertir";
$GLOBALS['strRefresh'] = "Actualizar";
$GLOBALS['strSaveChanges'] = "Guardar Cambios";
$GLOBALS['strUp'] = "Arriba";
$GLOBALS['strDown'] = "Abajo";
$GLOBALS['strSave'] = "Guardar";
$GLOBALS['strCancel'] = "Cancelar";
$GLOBALS['strBack'] = "Atrás";
$GLOBALS['strPrevious'] = "Anterior";
$GLOBALS['strNext'] = "Siguiente";
$GLOBALS['strYes'] = "Sí";
$GLOBALS['strNo'] = "No";
$GLOBALS['strNone'] = "Nada";
$GLOBALS['strCustom'] = "Común";
$GLOBALS['strDefault'] = "Predeterminado";
$GLOBALS['strUnknown'] = "Desconocido";
$GLOBALS['strUnlimited'] = "Ilimitado";
$GLOBALS['strUntitled'] = "Sin título";
$GLOBALS['strAll'] = "todos";
$GLOBALS['strAverage'] = "Promedio";
$GLOBALS['strOverall'] = "General";
$GLOBALS['strTotal'] = "Total";
$GLOBALS['strFrom'] = "De";
$GLOBALS['strTo'] = "a";
$GLOBALS['strAdd'] = "Agregar";
$GLOBALS['strLinkedTo'] = "relacionado con";
$GLOBALS['strDaysLeft'] = "Días restantes";
$GLOBALS['strCheckAllNone'] = "Marcar todo / nada";
$GLOBALS['strKiloByte'] = "KB";
$GLOBALS['strExpandAll'] = "<u>E</u>xpandir todo";
$GLOBALS['strCollapseAll'] = "<u>C</u>ontraer todo";
$GLOBALS['strShowAll'] = "Ver todo";
$GLOBALS['strNoAdminInterface'] = "La pantalla de administración está desactivada por mantenimiento. Esto no afecta la entrega de campañas.";
$GLOBALS['strFieldStartDateBeforeEnd'] = "La fecha 'Desde' debe ser anterior a la fecha 'Hasta'";
$GLOBALS['strFieldContainsErrors'] = "Los siguientes campos contienen errores:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Antes de continuar necesita";
$GLOBALS['strFieldFixBeforeContinue2'] = "corregir estos errores.";
$GLOBALS['strMiscellaneous'] = "Miscelánea";
$GLOBALS['strCollectedAllStats'] = "Todas las estadísticas";
$GLOBALS['strCollectedToday'] = "Hoy";
$GLOBALS['strCollectedYesterday'] = "Ayer";
$GLOBALS['strCollectedThisWeek'] = "Esta semana";
$GLOBALS['strCollectedLastWeek'] = "La semana pasada";
$GLOBALS['strCollectedThisMonth'] = "Este mes";
$GLOBALS['strCollectedLastMonth'] = "El mes pasado";
$GLOBALS['strCollectedLast7Days'] = "Últimos 7 días";
$GLOBALS['strCollectedSpecificDates'] = "Fechas específicas";
$GLOBALS['strValue'] = "Valor";
$GLOBALS['strWarning'] = "Advertencia";
$GLOBALS['strNotice'] = "Atención";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "El panel de control no puede ser mostrado";
$GLOBALS['strNoCheckForUpdates'] = "El panel de control no puede mostrarse a no ser que<br />esté habilitada la comprobación de actualizaciones.";
$GLOBALS['strEnableCheckForUpdates'] = "Por favor activa la configuración <a href='account-settings-update.php' target='_top'> Buscar actualizaciones</a> en la página <br/> <a href='account-settings-update.php' target='_top'> actualizar la configuración</a>.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "código";
$GLOBALS['strDashboardSystemMessage'] = "Mensaje del sistema";
$GLOBALS['strDashboardErrorHelp'] = "Si este error se ha repetido por favor describa detalladamente el problema y publicalo en <a href='http://forum.openx.org/'>OpenX forum</a>. ";

// Priority
$GLOBALS['strPriority'] = "Prioridad";
$GLOBALS['strPriorityLevel'] = "Nivel de prioridad";
$GLOBALS['strHighAds'] = "Publicidades con contrato";
$GLOBALS['strLowAds'] = "Publicidades remanentes";
$GLOBALS['strLimitations'] = "Limitaciones";
$GLOBALS['strNoLimitations'] = "Sin limitaciones";
$GLOBALS['strCapping'] = "Límites";

// Properties
$GLOBALS['strName'] = "Nombre";
$GLOBALS['strSize'] = "Tamaño";
$GLOBALS['strWidth'] = "Ancho";
$GLOBALS['strHeight'] = "Alto";
$GLOBALS['strLanguage'] = "Idioma";
$GLOBALS['strDescription'] = "Descripción";
$GLOBALS['strVariables'] = "Variables";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "Comentarios";

// User access
$GLOBALS['strWorkingAs'] = "Trabajando como";
$GLOBALS['strWorkingAs_Key'] = "Trabajando como";
$GLOBALS['strWorkingAs'] = "Trabajando como";
$GLOBALS['strSwitchTo'] = "Cambiar a";
$GLOBALS['strWorkingFor'] = "%s para…";
$GLOBALS['strNoAccountWithXInNameFound'] = "No han sido encontradas cuentas con \"%s\" en el nombre";
$GLOBALS['strRecentlyUsed'] = "Recientemente usados";
$GLOBALS['strLinkUser'] = "Agregar usuario";
$GLOBALS['strLinkUser_Key'] = "Agregar <u>u</u>suario";
$GLOBALS['strUsernameToLink'] = "Nombre de usuario del usuario a agregar";
$GLOBALS['strNewUserWillBeCreated'] = "Se creará un nuevo usuario";
$GLOBALS['strToLinkProvideEmail'] = "Para agregar un usuario, indique el e-mail del usuario";
$GLOBALS['strToLinkProvideUsername'] = "Para agregar un usuario, indique el nombre de usuario";
$GLOBALS['strUserLinkedToAccount'] = "Usuario agregado a la cuenta";
$GLOBALS['strUserAccountUpdated'] = "Cuenta de usuario actualizada";
$GLOBALS['strUserUnlinkedFromAccount'] = "Usuario eliminado de la cuenta";
$GLOBALS['strUserWasDeleted'] = "Usuario ha sido borrado";
$GLOBALS['strUserNotLinkedWithAccount'] = "El usuario no está asignado a la cuenta";
$GLOBALS['strCantDeleteOneAdminUser'] = "No puede borrar el usuario. Almenos un usuario necesita estar asignado a la cuenta de admin.";
$GLOBALS['strLinkUserHelp'] = "Para añadir un <b>usuario existente</b>, escriba el %1\$s y haga click %2\$s <br />Para añadir un <b>nuevo usuario</b>, escriba el %1\$s deseado y haga click %2\$s";
$GLOBALS['strLinkUserHelpUser'] = "Nombre de usuario";
$GLOBALS['strLinkUserHelpEmail'] = "Dirección e-mail";
$GLOBALS['strLastLoggedIn'] = "Último registro de ingreso";
$GLOBALS['strDateLinked'] = "Fecha enlazada";

// Login & Permissions
$GLOBALS['strUserAccess'] = "Acceso de usuario";
$GLOBALS['strAdminAccess'] = "Acceso de administrador";
$GLOBALS['strUserProperties'] = "Propiedades de usuario";
$GLOBALS['strPermissions'] = "Permisos";
$GLOBALS['strAuthentification'] = "Autenticación";
$GLOBALS['strWelcomeTo'] = "Bienvenido a";
$GLOBALS['strEnterUsername'] = "Introduzca su nombre de usuario y contraseña para entrar";
$GLOBALS['strEnterBoth'] = "Por favor, introduzca ambos, nombre de usuario y contraseña";
$GLOBALS['strEnableCookies'] = "Necesitas habilitar las cookies antes de que se pueda utilizar {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "Error de cookie de sesión, por favor ingrese de nuevo.";
$GLOBALS['strLogin'] = "Iniciar sesión";
$GLOBALS['strLogout'] = "Cerrar sesión";
$GLOBALS['strUsername'] = "Nombre de usuario";
$GLOBALS['strPassword'] = "Contraseña";
$GLOBALS['strPasswordRepeat'] = "Repetir contraseña";
$GLOBALS['strAccessDenied'] = "Acceso denegado";
$GLOBALS['strUsernameOrPasswordWrong'] = "El nombre de usuario y/o la contraseña no son correctos. Por favor, inténtelo de nuevo.";
$GLOBALS['strPasswordWrong'] = "La contraseña no es correcta.";
$GLOBALS['strNotAdmin'] = "Puede que no tenga suficientes privilegios; si conoce los datos de usuario correctos, puede iniciar sesión a continuación";
$GLOBALS['strDuplicateClientName'] = "El nombre de usuario que ha facilitado ya existe, por favor use un nombre de usuario diferente.";
$GLOBALS['strInvalidPassword'] = "La nueva contraseña no es válida, por favor, utilice una contraseña diferente.";
$GLOBALS['strInvalidEmail'] = "El formato de esta dirección de e-mail no es válido, por favor introduzca una dirección de e-mail válida.";
$GLOBALS['strNotSamePasswords'] = "Las dos contraseñas que ha escrito no son iguales";
$GLOBALS['strRepeatPassword'] = "Repetir contraseña";
$GLOBALS['strDeadLink'] = "Su enlace es inválido.";
$GLOBALS['strNoPlacement'] = "La campaña seleccionada no existe. Intente con este <a href='{link}'>enlace</a> en lugar del otro";
$GLOBALS['strNoAdvertiser'] = "El anunciante seleccionado no existe. Intente con este <a href='{link}'>enlace</a> en lugar del otro";

// General advertising
$GLOBALS['strRequests'] = "Peticiones";
$GLOBALS['strImpressions'] = "Impresiones";
$GLOBALS['strClicks'] = "Clics";
$GLOBALS['strConversions'] = "Conversiones";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "Clics totales";
$GLOBALS['strTotalConversions'] = "Conversiones totales";
$GLOBALS['strDateTime'] = "Fecha y hora";
$GLOBALS['strTrackerID'] = "ID Tracker";
$GLOBALS['strTrackerName'] = "Nombre del Tracker";
$GLOBALS['strTrackerImageTag'] = "Tag de Imagen";
$GLOBALS['strTrackerJsTag'] = "Tag de Javascript";
$GLOBALS['strTrackerAlwaysAppend'] = "¿Mostrar siempre código anexado, aunque no haya una conversión registrada por el rastreador?";
$GLOBALS['strBanners'] = "Banners";
$GLOBALS['strCampaigns'] = "Campañas";
$GLOBALS['strCampaignID'] = "ID Campaña";
$GLOBALS['strCampaignName'] = "Nombre de la Campaña";
$GLOBALS['strCountry'] = "País";
$GLOBALS['strStatsAction'] = "Acción";
$GLOBALS['strWindowDelay'] = "Retardo de Ventana";
$GLOBALS['strStatsVariables'] = "Variables";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Alquiler mensual";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strFinanceCR'] = "CR";

// Time and date related
$GLOBALS['strDate'] = "Fecha";
$GLOBALS['strDay'] = "Día";
$GLOBALS['strDays'] = "Días";
$GLOBALS['strWeek'] = "Semana";
$GLOBALS['strWeeks'] = "Semanas";
$GLOBALS['strSingleMonth'] = "Mes";
$GLOBALS['strMonths'] = "Meses";
$GLOBALS['strDayOfWeek'] = "Día de la semana";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = array();
}
$GLOBALS['strDayFullNames'][0] = 'Domingo';
$GLOBALS['strDayFullNames'][1] = 'Lunes';
$GLOBALS['strDayFullNames'][2] = 'Martes';
$GLOBALS['strDayFullNames'][3] = 'Miercoles';
$GLOBALS['strDayFullNames'][4] = 'Jueves';
$GLOBALS['strDayFullNames'][5] = 'Viernes';
$GLOBALS['strDayFullNames'][6] = 'Sábado';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = array();
}
$GLOBALS['strDayShortCuts'][0] = 'Do';
$GLOBALS['strDayShortCuts'][1] = 'Lu';
$GLOBALS['strDayShortCuts'][2] = 'Ma';
$GLOBALS['strDayShortCuts'][3] = 'Mi';
$GLOBALS['strDayShortCuts'][4] = 'Ju';
$GLOBALS['strDayShortCuts'][5] = 'Vi';
$GLOBALS['strDayShortCuts'][6] = 'Sa';

$GLOBALS['strHour'] = "Hora";
$GLOBALS['strSeconds'] = "segundos";
$GLOBALS['strMinutes'] = "minutos";
$GLOBALS['strHours'] = "horas";

// Advertiser
$GLOBALS['strClient'] = "Anunciante";
$GLOBALS['strClients'] = "Anunciantes";
$GLOBALS['strClientsAndCampaigns'] = "Anunciantes & Campañas";
$GLOBALS['strAddClient'] = "Agregar nuevo anunciante";
$GLOBALS['strClientProperties'] = "Propiedades del anunciante";
$GLOBALS['strClientHistory'] = "Historial del anunciante";
$GLOBALS['strNoClients'] = "No hay actualmente anunciantes definidos . Para crear una campaña, <a href='advertiser-edit.php'>agregue un anunciante</a> primero.";
$GLOBALS['strConfirmDeleteClient'] = "Está seguro de querer borrar este anunciante?";
$GLOBALS['strConfirmDeleteClients'] = "Está seguro de querer borrar este anunciante?";
$GLOBALS['strHideInactive'] = "Ocultar inactivos";
$GLOBALS['strInactiveAdvertisersHidden'] = "anunciante(s) inactivo(s) oculto(s)";
$GLOBALS['strAdvertiserSignup'] = "Alta de anunciante";
$GLOBALS['strAdvertiserCampaigns'] = "Anunciantes & Campañas";

// Advertisers properties
$GLOBALS['strContact'] = "Contacto";
$GLOBALS['strContactName'] = "Nombre de contacto";
$GLOBALS['strEMail'] = "E-mail";
$GLOBALS['strSendAdvertisingReport'] = "Enviar informes de entrega de campañas vía email";
$GLOBALS['strNoDaysBetweenReports'] = "Número de días entre informes de entrega de campañas";
$GLOBALS['strSendDeactivationWarning'] = "Enviar un Alerta cuando una campaña sea desactivada automáticamente";
$GLOBALS['strAllowClientModifyBanner'] = "Permitir a este usuario modificar sus propios banners";
$GLOBALS['strAllowClientDisableBanner'] = "Permitir a este usuario desactivar sus propios banners";
$GLOBALS['strAllowClientActivateBanner'] = "Permitir a este usuario activar sus propios banners";
$GLOBALS['strAllowCreateAccounts'] = "Permitir a este usuario crear cuentas nuevas";
$GLOBALS['strAdvertiserLimitation'] = "Mostrar sólo un banner de este anunciante en una misma página web";
$GLOBALS['strAllowAuditTrailAccess'] = "Permitir a este usuario acceder al audit trail";

// Campaign
$GLOBALS['strCampaign'] = "Campaña";
$GLOBALS['strCampaigns'] = "Campañas";
$GLOBALS['strAddCampaign'] = "Agregar nueva campaña";
$GLOBALS['strAddCampaign_Key'] = "Agregar <u>n</u>ueva campaña";
$GLOBALS['strCampaignForAdvertiser'] = "para el anunciante";
$GLOBALS['strLinkedCampaigns'] = "Campañas enlazadas";
$GLOBALS['strCampaignProperties'] = "Propiedades de la campaña";
$GLOBALS['strCampaignOverview'] = "Resumen de campañas";
$GLOBALS['strCampaignHistory'] = "Historial de la campaña";
$GLOBALS['strNoCampaigns'] = "No hay campañas definidas";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "Actualmente no hay campañas definidas, porque no hay anunciantes. Para crear una campaña, <a href='advertiser-edit.php'> primero añada un nuevo anunciante</a>.";
$GLOBALS['strConfirmDeleteCampaign'] = "¿Está seguro de querer borrar esta campaña?";
$GLOBALS['strConfirmDeleteCampaigns'] = "¿Está seguro de querer borrar esta campaña?";
$GLOBALS['strShowParentAdvertisers'] = "Mostrar anunciantes superiores";
$GLOBALS['strHideParentAdvertisers'] = "Ocultar anunciantes superiores";
$GLOBALS['strHideInactiveCampaigns'] = "Ocultar campañas inactivas";
$GLOBALS['strInactiveCampaignsHidden'] = "campaña(s) inactiva(s) oculta(s)";
$GLOBALS['strPriorityInformation'] = "Prioridad en relación a otras campañas";
$GLOBALS['strECPMInformation'] = "priorización eCPM";
$GLOBALS['strRemnantEcpmDescription'] = "El eCPM es calculado automáticamente basado en el rendimiento de esta campaña.<br />Se utilizará para priorizar las campañas remanentes en relación con las demás.";
$GLOBALS['strHiddenCampaign'] = "Campaña";
$GLOBALS['strHiddenAd'] = "Anuncio";
$GLOBALS['strHiddenAdvertiser'] = "Anunciante";
$GLOBALS['strHiddenWebsite'] = "Página web";
$GLOBALS['strHiddenZone'] = "Zona";
$GLOBALS['strCompanionPositioning'] = "Mostrar compañeros (No mostrar banners de esta campaña junto a banners de otras campañas)";
$GLOBALS['strSelectUnselectAll'] = "Seleccionar / Deseleccionar todo";
$GLOBALS['strCampaignsOfAdvertiser'] = "de"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "Calculado para todas las campañas";
$GLOBALS['strCalculatedForThisCampaign'] = "Calculado para esta campaña";
$GLOBALS['strLinkingZonesProblem'] = "Ocurrió un problema cuando se vincluaban zonas";
$GLOBALS['strUnlinkingZonesProblem'] = "Ocurrió un problema cuando se desvincluaban zonas";
$GLOBALS['strZonesLinked'] = "zona(s) vinculadas";
$GLOBALS['strZonesUnlinked'] = "zona(s) no vinculadas";
$GLOBALS['strZonesSearch'] = "Buscar";
$GLOBALS['strZonesSearchTitle'] = "Búsqueda de zonas y sitios web por nombre";
$GLOBALS['strNoWebsitesAndZones'] = "No hay zonas y sitios web";
$GLOBALS['strNoWebsitesAndZonesText'] = "con \"%s\" en el nombre";
$GLOBALS['strToLink'] = "para vincular";
$GLOBALS['strToUnlink'] = "para desvincular";
$GLOBALS['strLinked'] = "vinculados";
$GLOBALS['strAvailable'] = "Disponible";
$GLOBALS['strShowing'] = "Mostrando";
$GLOBALS['strEditZone'] = "Editar zona";
$GLOBALS['strEditWebsite'] = "Editar página web";


// Campaign properties
$GLOBALS['strDontExpire'] = "No expirar";
$GLOBALS['strActivateNow'] = "Activar inmediatamente";
$GLOBALS['strSetSpecificDate'] = "Indique una fecha específica";
$GLOBALS['strLow'] = "Bajo";
$GLOBALS['strHigh'] = "Alto";
$GLOBALS['strExpirationDate'] = "Fecha de finalización";
$GLOBALS['strExpirationDateComment'] = "La campaña expirará al final del día";
$GLOBALS['strActivationDate'] = "Fecha de inicio";
$GLOBALS['strActivationDateComment'] = "La campaña comenzará al principio del día";
$GLOBALS['strImpressionsRemaining'] = "Impresiones restantes";
$GLOBALS['strClicksRemaining'] = "Clics restantes";
$GLOBALS['strConversionsRemaining'] = "Conversiones restantes";
$GLOBALS['strImpressionsBooked'] = "Impresiones contratadas";
$GLOBALS['strClicksBooked'] = "Clics contratados";
$GLOBALS['strConversionsBooked'] = "Conversiones contratadas";
$GLOBALS['strCampaignWeight'] = "Fijar el peso de la campaña";
$GLOBALS['strAnonymous'] = "Ocultar el anunciante y las páginas web de esta campaña.";
$GLOBALS['strTargetPerDay'] = "por día.";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "El tipo de esta campaña ha sido fijado como Remanente, pero el peso se ha establecido a cero o no se ha especificado. Esto hará que la campaña se desactive y sus banners no se entregarán hasta que se establezca un número válido para el peso. 

 ¿Está seguro de que desea continuar?";
$GLOBALS['strCampaignWarningEcpmNoRevenue'] = "Esta campaña utiliza optimización eCPM, pero los 'beneficios' están a cero o no se ha especificado. Esto hará que la campaña sea desactivada y sus banners no se entreguen hasta que establezca un número valido para los los ingresos .  

¿Está seguro de que desea continuar?";
$GLOBALS['strCampaignWarningOverrideNoWeight'] = "El tipo de esta campaña ha sido fijado como Override, pero el peso se ha establecido a cero o no se ha especificado. Esto hará que la campaña se desactive y sus banners no se entregarán hasta que se establezca un número válido para el peso.  

¿Está seguro de que desea continuar?";
$GLOBALS['strCampaignWarningNoTarget'] = "El tipo de esta campaña ha sido fijado como Contract, pero el límite por día no se ha especificado. Esto hará que la campaña se desactive y sus banners no se entregarán hasta que se establezca un límite válido.

¿Está seguro de que desea continuar?";
$GLOBALS['strCampaignStatusPending'] = "Pendiente";
$GLOBALS['strCampaignStatusInactive'] = "activo";
$GLOBALS['strCampaignStatusRunning'] = "Ejecutándose";
$GLOBALS['strCampaignStatusPaused'] = "Pausada";
$GLOBALS['strCampaignStatusAwaiting'] = "Añadida";
$GLOBALS['strCampaignStatusExpired'] = "Completada";
$GLOBALS['strCampaignStatusApproval'] = "Esperando aprobación »";
$GLOBALS['strCampaignStatusRejected'] = "Rechazada";
$GLOBALS['strCampaignStatusAdded'] = "Añadido";
$GLOBALS['strCampaignStatusStarted'] = "Iniciado";
$GLOBALS['strCampaignStatusRestarted'] = "Reiniciado";
$GLOBALS['strCampaignStatusDeleted'] = "Borrado";
$GLOBALS['strCampaignType'] = "Nombre de la Campaña";
$GLOBALS['strType'] = "Tipo";
$GLOBALS['strContract'] = "Contacto";
$GLOBALS['strStandardContract'] = "Contacto";
$GLOBALS['strSelectPricingModel'] = "-- Seleccione un modelo --";
$GLOBALS['strMinimumImpressions'] = "Impresiones mínimas diarias";
$GLOBALS['strLimit'] = "Límite";
$GLOBALS['strCannotSetBothDateAndLimit'] = "No se puede establecer una fecha de finalización y el límite a la vez para campaña remanente o exclusiva. <br>Si es necesita establecer tanto una fecha de finalización y límites de impresiones/clicks/conversiones por favor utilice una campaña de contrato no exclusivo.";
$GLOBALS['strWhyDisabled'] = "¿por qué está desactivado?";
$GLOBALS['strBackToCampaigns'] = "Volver a campañas";
$GLOBALS['strCampaignBanners'] = "Banners de campañas";
$GLOBALS['strCookies'] = "\"Cookies\"";

// Tracker
$GLOBALS['strTrackers'] = "Seguidores";
$GLOBALS['strTrackerPreferences'] = "Preferencias del tracker";
$GLOBALS['strAddTracker'] = "Añadir nuevo tracker";
$GLOBALS['strTrackerForAdvertiser'] = "para el anunciante";
$GLOBALS['strNoTrackers'] = "No hay trackers definidos";
$GLOBALS['strConfirmDeleteTrackers'] = "¿Está seguro de querer borrar este tracker?";
$GLOBALS['strConfirmDeleteTracker'] = "¿Está seguro de querer borrar este tracker?";
$GLOBALS['strTrackerProperties'] = "Propiedades de trackers";
$GLOBALS['strDefaultStatus'] = "Estado por defecto";
$GLOBALS['strStatus'] = "Estado";
$GLOBALS['strLinkedTrackers'] = "Trackers enlazados";
$GLOBALS['strConversionWindow'] = "Ventana de conversión";
$GLOBALS['strUniqueWindow'] = "Ventana de único";
$GLOBALS['strClick'] = "Clic";
$GLOBALS['strView'] = "Vista";
$GLOBALS['strManual'] = "Manual";
$GLOBALS['strConversionType'] = "Tipo de Conversión";
$GLOBALS['strLinkCampaignsByDefault'] = "Enlazar campañas nuevas por defecto";
$GLOBALS['strIPAddress'] = "Dirección IP";

// Banners (General)
$GLOBALS['strBanner'] = "Banner";
$GLOBALS['strBanners'] = "Banners";
$GLOBALS['strAddBanner'] = "Agregar nuevo banner";
$GLOBALS['strAddBanner_Key'] = "Agregar <u>n</u>uevo banner";
$GLOBALS['strBannerToCampaign'] = "Su campaña";
$GLOBALS['strShowBanner'] = "Mostrar banner";
$GLOBALS['strBannerProperties'] = "Propiedades del banner";
$GLOBALS['strBannerHistory'] = "Historial del banner";
$GLOBALS['strNoBanners'] = "No hay actualmente banners definidos";
$GLOBALS['strNoBannersAddCampaign'] = "Actualmente no hay páginas web definidas. Para crear una zona, <a href='affiliate-edit.php'>agregue una página web</a> primero.";
$GLOBALS['strNoBannersAddAdvertiser'] = "Actualmente no hay páginas web definidas. Para crear una zona, <a href='affiliate-edit.php'>agregue una página web</a> primero.";
$GLOBALS['strConfirmDeleteBanner'] = "¿Está seguro de querer borrar este banner?";
$GLOBALS['strConfirmDeleteBanners'] = "¿Está seguro de querer borrar este banner?";
$GLOBALS['strShowParentCampaigns'] = "Mostrar campañas relacionadas";
$GLOBALS['strHideParentCampaigns'] = "Ocultar campañas relacionadas";
$GLOBALS['strHideInactiveBanners'] = "Ocultar banners inactivos";
$GLOBALS['strInactiveBannersHidden'] = "banner(s) inactivo(s) oculto(s)";
$GLOBALS['strWarningMissing'] = "Aviso, probablemente falta";
$GLOBALS['strWarningMissingClosing'] = " tag de cierre \">\"";
$GLOBALS['strWarningMissingOpening'] = " tag de apertura \"<\"";
$GLOBALS['strSubmitAnyway'] = "Enviar de todas maneras";
$GLOBALS['strBannersOfCampaign'] = "en"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "Preferencias de banner";
$GLOBALS['strCampaignPreferences'] = "Preferencias de campaña";
$GLOBALS['strDefaultBanners'] = "Banners por defecto";
$GLOBALS['strDefaultBannerUrl'] = "URL de imagen por defecto";
$GLOBALS['strDefaultBannerDestination'] = "URL de destino predeterminada";
$GLOBALS['strAllowedBannerTypes'] = "Tipos de banners permitidos";
$GLOBALS['strTypeSqlAllow'] = "Permitir banners SQL locales";
$GLOBALS['strTypeWebAllow'] = "Permitir banners locales Webserver";
$GLOBALS['strTypeUrlAllow'] = "Permitir Banners externos";
$GLOBALS['strTypeHtmlAllow'] = "Permitir Banners HTML";
$GLOBALS['strTypeTxtAllow'] = "Permitir anuncios de texto";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Por favor, elija el tipo de banner";
$GLOBALS['strMySQLBanner'] = "Banner Local (SQL)";
$GLOBALS['strWebBanner'] = "Banner Local (Webserver)";
$GLOBALS['strURLBanner'] = "Banner Externo";
$GLOBALS['strHTMLBanner'] = "Banner HTML";
$GLOBALS['strTextBanner'] = "Banner de texto";
$GLOBALS['strAlterHTML'] = "Modificar HTML para permitir seguimiento de click para:";
$GLOBALS['strIframeFriendly'] = "Este banner puede visualizarse con seguridad dentro de un iframe (por ejemplo no es ampliable)";
$GLOBALS['strUploadOrKeep'] = "¿Desea conservar<br />la imagen existente,<br />o desea subir una nueva?";
$GLOBALS['strNewBannerFile'] = "Seleccione la imagen que quiere <br />usar para este banner.<br /><br />";
$GLOBALS['strNewBannerFileAlt'] = "Seleccione la imagen de reserva que <br />quiere usar en el caso de que los navegadores </br /> no soporten multimedia";
$GLOBALS['strNewBannerURL'] = "URL de la imagen (incluir http://)";
$GLOBALS['strURL'] = "URL de destino (incluir http://)";
$GLOBALS['strKeyword'] = "Palabras clave";
$GLOBALS['strTextBelow'] = "Texto posterior a la imagen";
$GLOBALS['strWeight'] = "Peso";
$GLOBALS['strAlt'] = "Texto alternativo";
$GLOBALS['strStatusText'] = "Texto de barra de estado";
$GLOBALS['strBannerWeight'] = "Peso del banner";
$GLOBALS['strAdserverTypeGeneric'] = "Banner HTML genérico";
$GLOBALS['strDoNotAlterHtml'] = "No alterar HTML";
$GLOBALS['strGenericOutputAdServer'] = "Genérico";
$GLOBALS['strSwfTransparency'] = "Permitir fondo transparente";
$GLOBALS['strBackToBanners'] = "Volver a banners";

// Banner (advanced)

// Banner (swf)
$GLOBALS['strCheckSWF'] = "Comprobar enlaces <i>hard-coded</i> en el archivo Flash";
$GLOBALS['strConvertSWFLinks'] = "Convertir enlaces Flash";
$GLOBALS['strHardcodedLinks'] = "Enlaces <i>hard-coded</i>";
$GLOBALS['strCompressSWF'] = "Comprimir el archivo SWF para descargarlo más rápidamente (Reproductor Flash 6 es requerido)";
$GLOBALS['strOverwriteSource'] = "Sobreescribir parámetro de origen";

// Display limitations
$GLOBALS['strModifyBannerAcl'] = "Opciones de entrega";
$GLOBALS['strACL'] = "Entrega";
$GLOBALS['strACLAdd'] = "Agregar nuevas limitaciones";
$GLOBALS['strNoLimitations'] = "Sin limitaciones";
$GLOBALS['strApplyLimitationsTo'] = "Aplicar limitaciones a";
$GLOBALS['strAllBannersInCampaign'] = "Todos los banners en esta campaña";
$GLOBALS['strRemoveAllLimitations'] = "Quitar todas las limitaciones";
$GLOBALS['strEqualTo'] = "es igual a";
$GLOBALS['strDifferentFrom'] = "es diferente de";
$GLOBALS['strContains'] = "contiene";
$GLOBALS['strGreaterThan'] = "es mayor que";
$GLOBALS['strLessThan'] = "es menor que";
$GLOBALS['strAND'] = "Y";                          // logical operator
$GLOBALS['strOR'] = "O";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Mostrar este banner solamente cuando:";
$GLOBALS['strWeekDays'] = "Días de la semana";
$GLOBALS['strTime'] = "Hora";
$GLOBALS['strDomain'] = "Dominio";
$GLOBALS['strSource'] = "Origen";
$GLOBALS['strBrowser'] = "Navegador";
$GLOBALS['strOS'] = "Sistema Operativo";
$GLOBALS['strDeliveryLimitations'] = "Limitaciones de entrega";

$GLOBALS['strDeliveryCappingReset'] = "Resetear contadores de vistas después de:";
$GLOBALS['strDeliveryCappingTotal'] = "en total";
$GLOBALS['strDeliveryCappingSession'] = "por sesión";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['title'] = "Límite de entrega por visitante";
$GLOBALS['strCappingBanner']['limit'] = "Limitar vistas de banners a:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['title'] = "Límite de entrega por visitante";
$GLOBALS['strCappingCampaign']['limit'] = "Limitar vistas de campa&ntilde;a a:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['title'] = "Límite de entrega por visitante";
$GLOBALS['strCappingZone']['limit'] = "Limitar vistas de zonas a:";

// Website
$GLOBALS['strAffiliate'] = "Página web";
$GLOBALS['strAffiliates'] = "Páginas web";
$GLOBALS['strAffiliatesAndZones'] = "Páginas web y Zonas";
$GLOBALS['strAddNewAffiliate'] = "Agregar nueva página web";
$GLOBALS['strAffiliateProperties'] = "Propiedades de la página web";
$GLOBALS['strAffiliateHistory'] = "Historial de la página web";
$GLOBALS['strNoAffiliates'] = "Actualmente no hay páginas web definidas. Para crear una zona, <a href='affiliate-edit.php'>agregue una página web</a> primero.";
$GLOBALS['strConfirmDeleteAffiliate'] = "Está seguro de querer borrar esta página web?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Está seguro de querer borrar esta página web?";
$GLOBALS['strInactiveAffiliatesHidden'] = "página web(s) inactiva(s) oculta(s)";
$GLOBALS['strShowParentAffiliates'] = "Mostrar páginas web relacionadas";
$GLOBALS['strHideParentAffiliates'] = "Ocultar páginas web relacionadas";

// Website (properties)
$GLOBALS['strWebsite'] = "Página web";
$GLOBALS['strWebsiteURL'] = "URL del Sitio Web";
$GLOBALS['strAllowAffiliateModifyZones'] = "Permitir a este usuario modificar sus zonas";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Permitir a este usuario enlazar banners a sus zonas";
$GLOBALS['strAllowAffiliateAddZone'] = "Permitir a este usuario definir nuevas zonas";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Permitir a este usuario borrar zonas existentes";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Permitir a este usuario generar código de invocación";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "Código postal";
$GLOBALS['strCountry'] = "País";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Páginas web y Zonas";

// Zone
$GLOBALS['strZone'] = "Zona";
$GLOBALS['strZones'] = "Zonas";
$GLOBALS['strAddNewZone'] = "Agregar nueva zona";
$GLOBALS['strAddNewZone_Key'] = "Agregar <u>n</u>ueva zona";
$GLOBALS['strZoneToWebsite'] = "Sin sitio web";
$GLOBALS['strLinkedZones'] = "Zonas enlazadas";
$GLOBALS['strAvailableZones'] = "Zonas disponibles";
$GLOBALS['strLinkingNotSuccess'] = "Vinculación fallida, por favor inténtelo nuevamente";
$GLOBALS['strZoneProperties'] = "Propiedades de la zona";
$GLOBALS['strZoneHistory'] = "Historial de la zona";
$GLOBALS['strNoZones'] = "No hay zonas definidas actualmente";
$GLOBALS['strNoZonesAddWebsite'] = "Actualmente no hay páginas web definidas. Para crear una zona, <a href='affiliate-edit.php'>agregue una página web</a> primero.";
$GLOBALS['strConfirmDeleteZone'] = "¿Está seguro de querer borrar esta zona?";
$GLOBALS['strConfirmDeleteZones'] = "¿Está seguro de querer borrar esta zona?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "Hay campañas de pago todavía enlazadas a esta zona, si la borra estas campañas no se ejecutarán y no recibirá los pagos correspondientes.";
$GLOBALS['strZoneType'] = "Tipo de zona";
$GLOBALS['strBannerButtonRectangle'] = "Banner, Botón o Rectángulo";
$GLOBALS['strInterstitial'] = "Interstitial o DHTML flotante";
$GLOBALS['strPopup'] = "Popup";
$GLOBALS['strTextAdZone'] = "Texto";
$GLOBALS['strEmailAdZone'] = "Zona de E-mail/Boletín";
$GLOBALS['strShowMatchingBanners'] = "Mostrar banners correspondientes";
$GLOBALS['strHideMatchingBanners'] = "Ocultar banners correspondientes";
$GLOBALS['strBannerLinkedAds'] = "Banners enlazados a la zona";
$GLOBALS['strCampaignLinkedAds'] = "Campañas enlazadas a la zona";
$GLOBALS['strInactiveZonesHidden'] = "zona(s) inactiva(s) oculta(s)";
$GLOBALS['strWarnChangeZoneType'] = "Cambiar el tipo de zona a texto o a e-mail desenlazara todos los banners/campañas debido a restricciones en esos tipos de zonas
   <ul>
      <li>Zonas de texto sólo pueden enlazarse con banners de texto</li>
      <li>Campañas en zonas de e-mail sólo pueden tener un banner activo a la vez</li>
   </ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Cambiar la zona desenlazará cualquier banner que no tenga el nuevo tamaño, y añadirá banners de campañas enlazadas que coincidan con el nuevo tamaño';
$GLOBALS['strWarnChangeBannerSize'] = 'Cambiar el tamaño del banner lo desmarcará de todas las zonas que no tengan el nuevo tamaño, y si la <b>campaña</b> del banner está enlazada con una zona del nuevo tamaño, el banner se asignará automáticamente';
$GLOBALS['strWarnBannerReadonly'] = 'Este banner es de sólo lectura porque una extensión ha sido desactivada. Para obtener más información, póngase en contacto con el administrador del sistema.';
$GLOBALS['strZonesOfWebsite'] = 'en'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "Volver a las zonas";

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "IAB Banner Clásico (468 x 60)";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "IAB Rascacielos (120 x 600)";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "IAB Leaderboard (728 x 90)";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "IAB Botón 1 (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "IAB Botón 2 (120 x 60)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "IAB Medio Banner (234 x 60)";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "IAB Micro Barra (88 x 31)";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "IAB Botón Cuadrado (125 x 125)";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "IAB Rectángulo (180 x 150)";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "IAB Pop-up Cuadrado (250 x 250)";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "IAB Banner Vertical (120 x 240)";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "IAB Rectángulo Medio (300 x 250)";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "IAB Rectángulo Grande (336 x 280)";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "IAB Rectángulo Vertical (240 x 400)";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "IAB Rascacielos Ancho (160 x 600)";
$GLOBALS['strIab']['IAB_Pop-Under(720x300)'] = "IAB Pop-Under (720 x 300)";
$GLOBALS['strIab']['IAB_3:1Rectangle(300x100)'] = "IAB 3:1 rectángulo (300 x 100)";

// Advanced zone settings
$GLOBALS['strAdvanced'] = "Avanzado";
$GLOBALS['strChainSettings'] = "Propiedades de encadenación";
$GLOBALS['strZoneNoDelivery'] = "Si ningún banner de esta zona <br />puede ser entregado, tratar de...";
$GLOBALS['strZoneStopDelivery'] = "Detener la entrega y no mostrar un banner";
$GLOBALS['strZoneOtherZone'] = "Mostrar la siguiente zona en su lugar";
$GLOBALS['strZoneAppend'] = "Adjuntar siempre el siguiente popup o interstitial a los banners mostrados en esta zona";
$GLOBALS['strAppendSettings'] = "Opciones de adjuntos";
$GLOBALS['strZonePrependHTML'] = "Pre-añadir siempre el código HTML al banner de texto mostrado por esta zona";
$GLOBALS['strZoneAppendNoBanner'] = "Añadir incluso si no hay banners que mostrar";
$GLOBALS['strZoneAppendHTMLCode'] = "Código HTML";
$GLOBALS['strZoneAppendZoneSelection'] = "Popup o interstitial";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "Todos los banners enlazados a esta zona están actualmente desactivados. <br />Esta es la cadena de zonas:";
$GLOBALS['strZoneProbNullPri'] = "No hay banners activos enlazados a esta zona.";
$GLOBALS['strZoneProbListChainLoop'] = "Continuar con la cadena de zonas provocará un bucle circular. Se ha detenido la entrega de esta zona.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Por favor, elija qué enlazar a esta zona";
$GLOBALS['strLinkedBanners'] = "Enlazar banners individuales";
$GLOBALS['strCampaignDefaults'] = "Enlazar banners por campaña padre";
$GLOBALS['strLinkedCategories'] = "Enlazar banners por categoría";
$GLOBALS['strWithXBanners'] = "%d banner(s)";
$GLOBALS['strRawQueryString'] = "Palabra clave";
$GLOBALS['strIncludedBanners'] = "Banners relacionados";
$GLOBALS['strMatchingBanners'] = "{count} banners correspondientes";
$GLOBALS['strNoCampaignsToLink'] = "No hay actualmente campañas disponibles para enlazar a esta zona";
$GLOBALS['strNoTrackersToLink'] = "No hay actualmente trackers disponibles que puedan enlazarse a esta campaña";
$GLOBALS['strNoZonesToLinkToCampaign'] = "No hay zonas disponibles donde enlazar esta campaña";
$GLOBALS['strSelectBannerToLink'] = "Seleccione el banner que desea enlazar a esta zona:";
$GLOBALS['strSelectCampaignToLink'] = "Seleccione la campaña que desea enlazar a esta zona:";
$GLOBALS['strSelectAdvertiser'] = "Seleccione anunciante";
$GLOBALS['strSelectPlacement'] = "Seleccione campaña";
$GLOBALS['strSelectAd'] = "Seleccione banner";
$GLOBALS['strSelectPublisher'] = "Seleccionar página web";
$GLOBALS['strSelectZone'] = "Seleccionar zona";
$GLOBALS['strConnectionType'] = "Tipo";
$GLOBALS['strStatusPending'] = "Pendiente";
$GLOBALS['strStatusApproved'] = "Aprobado";
$GLOBALS['strStatusDisapproved'] = "No aprobado";
$GLOBALS['strStatusDuplicate'] = "Duplicado";
$GLOBALS['strStatusOnHold'] = "En espera";
$GLOBALS['strStatusIgnore'] = "Ignorar";
$GLOBALS['strConnectionType'] = "Tipo";
$GLOBALS['strConnTypeSale'] = "Venta";
$GLOBALS['strConnTypeSignUp'] = "Alta";
$GLOBALS['strShortcutEditStatuses'] = "Editar estados";
$GLOBALS['strShortcutShowStatuses'] = "Mostrar estados";

// Statistics
$GLOBALS['strStats'] = "Estadísticas";
$GLOBALS['strNoStats'] = "No hay estadísticas disponibles";
$GLOBALS['strNoStatsForPeriod'] = "No hay estadísticas disponibles para el periodo del %s al %s";
$GLOBALS['strGlobalHistory'] = "Historial global";
$GLOBALS['strDailyHistory'] = "Historial diario";
$GLOBALS['strDailyStats'] = "Estadísticas diarias";
$GLOBALS['strWeeklyHistory'] = "Historial semanal";
$GLOBALS['strMonthlyHistory'] = "Historial mensual";
$GLOBALS['strTotalThisPeriod'] = "Total en este periodo";
$GLOBALS['strPublisherDistribution'] = "Distribución de páginas web";
$GLOBALS['strCampaignDistribution'] = "Distribución de campañas";
$GLOBALS['strViewBreakdown'] = "Ver por";
$GLOBALS['strBreakdownByDay'] = "Día";
$GLOBALS['strBreakdownByWeek'] = "Semana";
$GLOBALS['strBreakdownByMonth'] = "Mes";
$GLOBALS['strBreakdownByDow'] = "Día de la semana";
$GLOBALS['strBreakdownByHour'] = "Hora";
$GLOBALS['strItemsPerPage'] = "Elementos por página";
$GLOBALS['strShowGraphOfStatistics'] = "Mostrar <u>g</u>ráfica de estadísticas";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>xportar estadísticas a Excel";
$GLOBALS['strGDnotEnabled'] = "Debe tener GD activado en PHP para poder mostrar gráficas. Por favor, vea <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> para más información, incluyendo cómo instalar GD en su servidor.";
$GLOBALS['strStatsArea'] = "Área";

// Expiration
$GLOBALS['strNoExpiration'] = "Sin fecha de expiración fijada";
$GLOBALS['strEstimated'] = "Expiración estimada";
$GLOBALS['strNoExpirationEstimation'] = "Sin expiración estimada todavía";
$GLOBALS['strDaysAgo'] = "días atrás";
$GLOBALS['strCampaignStop'] = "Detener campaña";

// Reports
$GLOBALS['strAdvancedReports'] = "Informes avanzados";
$GLOBALS['strPeriod'] = "Periodo";
$GLOBALS['strLimitations'] = "Limitaciones";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "Todos los anunciantes";
$GLOBALS['strAnonAdvertisers'] = "Anunciantes anónimos";
$GLOBALS['strAllPublishers'] = "Todas las páginas web";
$GLOBALS['strAnonPublishers'] = "Páginas web anónimas";
$GLOBALS['strAllAvailZones'] = "Todas las zonas disponibles";

// Userlog
$GLOBALS['strUserLog'] = "Log de usuarios";
$GLOBALS['strUserLogDetails'] = "Detalle del log de usuarios";
$GLOBALS['strDeleteLog'] = "Borrar log";
$GLOBALS['strAction'] = "Acción";
$GLOBALS['strNoActionsLogged'] = "No hay acciones grabadas";

// Code generation
$GLOBALS['strGenerateBannercode'] = "Selección directa";
$GLOBALS['strChooseInvocationType'] = "Por favor, elija el tipo de invocación de banner";
$GLOBALS['strGenerate'] = "Generar";
$GLOBALS['strParameters'] = "Opciones de tag";
$GLOBALS['strFrameSize'] = "Tamaño del marco (frame)";
$GLOBALS['strBannercode'] = "Código del banner";
$GLOBALS['strTrackercode'] = "C&oacute;digo del tracker";
$GLOBALS['strBackToTheList'] = "Volver a la lista de informes";
$GLOBALS['strCharset'] = "Juego de caracteres";
$GLOBALS['strAutoDetect'] = "Autodetectar";

$GLOBALS['strThirdPartyComment'] = "
* No olvide de reemplazar el texto de '{clickurl}' con 
* la URL de seguimiento de click si este anuncio va a ser entregado a través de un
* adserver de terceros (no-Max)
*";

// Errors
$GLOBALS['strErrorDatabaseConnetion'] = "Error de conexión a la Base de Datos.";
$GLOBALS['strErrorCantConnectToDatabase'] = "Un error fatal se ha producido en %s y no es posible conectarse a la base de datos. Por esta razón no es posible conectarse con la interfaz de administración. La entrega de banners también puede verse afectada. Algunas posibles razones para el problema son: <ul> <li>El servidor de la base de datos puede no estar funcionando en este momento</li> <li>La dirección del servidor de la base de datos ha cambiado</li> <li>El nombre de usuario o clave usados para ingresar en la base de datos no es el correcto</li> <li>PHP no ha cargado la extensión MySQL</li> </ul>";
$GLOBALS['strNoMatchesFound'] = "No se han encontrado resultados.";
$GLOBALS['strErrorOccurred'] = "Ha ocurrido un error";
$GLOBALS['strErrorDBPlain'] = "Ha ocurrido un error al intentar acceder a la base de datos";
$GLOBALS['strErrorDBSerious'] = "Se ha detectado un problema serio con la base de datos";
$GLOBALS['strErrorDBNoDataPlain'] = "Debido a un problema con la base de datos {$PRODUCT_NAME} no se ha podido recuperar o guardar los datos. ";
$GLOBALS['strErrorDBNoDataSerious'] = "Debido a un problema serio con la base de datos, {$PRODUCT_NAME} no se ha podido cargar los datos";
$GLOBALS['strErrorDBCorrupt'] = "La tabla de base de datos está probablemente corrupta y necesita ser reparada. Para más información sobre reparación de tablas corruptas, por favor, lea el capítulo <i>Troubleshooting</i> (resolución de problemas) de la <i>Guía del Administrador</i>.";
$GLOBALS['strErrorDBContact'] = "Por favor, contacte con el administrador de este servidor y notifíquele el problema.";
$GLOBALS['strErrorDBSubmitBug'] = "Si el problema es reproducible puede ser debido a un bug en {$PRODUCT_NAME}. Por favor, envíe la siguiente información a los creadores de {$PRODUCT_NAME}. También intente describir las acciones que le han llevado hasta este error tan claramente como le sea posible.";
$GLOBALS['strMaintenanceNotActive'] = "No se ha ejecutado el script de mantenimiento en las últimas 24 horas. Para asegurar que la aplicación funcione correctamente es necesario ejecutarlo cada hora.  Por favor lea a la guía del administrador para obtener más información acerca de cómo configurar el script de mantenimiento.";
$GLOBALS['strErrorLinkingBanner'] = "No ha sido posible enlazar el banner a esta zona porque:";
$GLOBALS['strUnableToLinkBanner'] = "No se puede enlazar este banner:";
$GLOBALS['strErrorEditingCampaignRevenue'] = "formato incorrecto de número en el campo de Información de Ingresos";
$GLOBALS['strErrorEditingCampaignECPM'] = "formato de número incorrecto en campo ECPM";
$GLOBALS['strErrorEditingZone'] = "Error actualizando zona:";
$GLOBALS['strUnableToChangeZone'] = "No se pueden aplicar los cambios porque:";
$GLOBALS['strDatesConflict'] = "las fechas son conflictivas con:";
$GLOBALS['strEmailNoDates'] = "Campañas vinculadas a las zonas de correo electrónico deben tener una fecha inicial y final. {$PRODUCT_NAME} asegura que en una fecha determinada, sólo un banner activo está ligado a una zona de correo electrónico. Por favor asegúrese de que las campañas ya vinculadas a la zona no tienen superposición de fechas con la campaña que está tratando de vincular.";
$GLOBALS['strWarningInaccurateStats'] = "Algunas de estas estadísticas no fueron logueadas en un huso horario UTC por lo que podrían ser mostradas en un huso horario incorrecto.";
$GLOBALS['strWarningInaccurateReadMore'] = "Leer más sobre esto";
$GLOBALS['strWarningInaccurateReport'] = "Algunas estadísticas en este informe no fueron logueadas en un huso horario UTC por lo que podrían ser mostradas en un huso horario incorrecto.";

//Validation
$GLOBALS['strRequiredFieldLegend'] = "indica campo obligatorio";
$GLOBALS['strFormContainsErrors'] = "El formulario tiene errores, por favor corrija los campos marcados a continuación.";
$GLOBALS['strXRequiredField'] = "%s es obligatorio";
$GLOBALS['strEmailField'] = "Por favor escriba un correo electrónico válido";
$GLOBALS['strNumericField'] = "Introduce un número (sólo dígitos permitidos)";
$GLOBALS['strGreaterThanZeroField'] = "Debe ser mayor que 0";
$GLOBALS['strXGreaterThanZeroField'] = "%s debe ser mayor que 0";
$GLOBALS['strXPositiveWholeNumberField'] = "%s debe ser un número positivo entero";
$GLOBALS['strInvalidWebsiteURL'] = "URL inválida";

// Email
$GLOBALS['strSirMadam'] = "Sr/a.";
$GLOBALS['strMailSubject'] = "Informe de anunciante";
$GLOBALS['strMailHeader'] = "Estimado/a {contact},";
$GLOBALS['strMailBannerStats'] = "A continuación encontrará las estadísticas de banners de {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Campaña activada";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Campaña desactivada";
$GLOBALS['strMailBannerActivated'] = "La campaña mostrada debajo ha sido activada porque
la fecha de activación de la campaña ha llegado.";
$GLOBALS['strMailBannerDeactivated'] = "La campaña mostrada debajo ha sido desactivada porque";
$GLOBALS['strMailFooter'] = "Le saluda atentamente,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "Esta campaña no se encuentra activada porque";
$GLOBALS['strBeforeActivate'] = "la fecha de activación aún no ha llegado";
$GLOBALS['strAfterExpire'] = "ha llegado la fecha de caducidad";
$GLOBALS['strNoMoreImpressions'] = "no quedan impresiones disponibles";
$GLOBALS['strNoMoreClicks'] = "no quedan clics disponibles";
$GLOBALS['strNoMoreConversions'] = "no quedan ventas disponibles";
$GLOBALS['strWeightIsNull'] = "el peso es cero";
$GLOBALS['strRevenueIsNull'] = "sus ingresos son cero";
$GLOBALS['strTargetIsNull'] = "el target es cero";
$GLOBALS['strNoViewLoggedInInterval'] = "No se ha grabado ninguna impresión durante el periodo de este informe";
$GLOBALS['strNoClickLoggedInInterval'] = "No se ha grabado ningún clic durante el periodo de este informe";
$GLOBALS['strNoConversionLoggedInInterval'] = "No se ha grabado ninguna conversión durante el periodo de este informe";
$GLOBALS['strMailReportPeriod'] = "Este informe incluye estadísticas desde {startdate} hasta {enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "Este informe incluye todas las estadísticas hasta {enddate}.";
$GLOBALS['strNoStatsForCampaign'] = "No hay estadísticas disponibles para esta campaña";
$GLOBALS['strImpendingCampaignExpiry'] = "Fecha de expiración de campaña próxima";
$GLOBALS['strYourCampaign'] = "Su campaña";
$GLOBALS['strTheCampiaignBelongingTo'] = "La campaña perteneciente a";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} mostrada a continuación caducará en la fecha {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} mostrada a continuación tiene menos de {limit} impresiones restantes.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "Como resultado, la campaña será pronto desactivada automáticamente, y los
siguientes banners en la campaña también se desactivarán:";

// Priority
$GLOBALS['strPriority'] = "Prioridad";
$GLOBALS['strSourceEdit'] = "Editar orígenes";

// Preferences
$GLOBALS['strPreferences'] = "Preferencias";
$GLOBALS['strUserPreferences'] = "Preferencias de usuario";
$GLOBALS['strChangePassword'] = "Cambiar Contraseña";
$GLOBALS['strChangeEmail'] = "Cambiar E-mail";
$GLOBALS['strCurrentPassword'] = "Contraseña actual";
$GLOBALS['strChooseNewPassword'] = "Elija una nueva contraseña";
$GLOBALS['strReenterNewPassword'] = "Confirme la nueva contraseña";
$GLOBALS['strNameLanguage'] = "Nombre e Idioma";
$GLOBALS['strAccountPreferences'] = "Preferencias de cuenta";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Preferencias de informes de campaña por e-mail";
$GLOBALS['strTimezonePreferences'] = "Preferencias de zona horaria";
$GLOBALS['strAdminEmailWarnings'] = "Avisos e-mail de administrador";
$GLOBALS['strAgencyEmailWarnings'] = "Avisos e-mail de agencia";
$GLOBALS['strAdveEmailWarnings'] = "Avisos e-mail de anunciante";
$GLOBALS['strFullName'] = "Nombre completo";
$GLOBALS['strEmailAddress'] = "Dirección e-mail";
$GLOBALS['strUserDetails'] = "Detalles usuario";
$GLOBALS['strUserInterfacePreferences'] = "Preferencias de interfaz de usuario";
$GLOBALS['strPluginPreferences'] = "Opciones principales";
$GLOBALS['strColumnName'] = "Nombre de Columna";
$GLOBALS['strShowColumn'] = "Mostrar Columna";
$GLOBALS['strCustomColumnName'] = "Nombre de Columna Personalizada";
$GLOBALS['strColumnRank'] = "Rango de Columna";

// Long names
$GLOBALS['strRevenue'] = "Ganancias";
$GLOBALS['strNumberOfItems'] = "Número de elementos";
$GLOBALS['strRevenueCPC'] = "Ingresos CPC";
$GLOBALS['strERPM'] = "ERPM";
$GLOBALS['strERPC'] = "ERPC";
$GLOBALS['strERPS'] = "ERPS";
$GLOBALS['strEIPM'] = "EIPM";
$GLOBALS['strEIPC'] = "EIPC";
$GLOBALS['strEIPS'] = "EIPS";
$GLOBALS['strECPM'] = "ECPM";
$GLOBALS['strECPC'] = "ECPC";
$GLOBALS['strECPS'] = "ECPS";
$GLOBALS['strPendingConversions'] = "Conversiones pendientes";
$GLOBALS['strImpressionSR'] = "Impresión SR";
$GLOBALS['strClickSR'] = "Clic SR";

// Short names
$GLOBALS['strRevenue_short'] = "Fact.";
$GLOBALS['strBasketValue_short'] = "VC";
$GLOBALS['strNumberOfItems_short'] = "Num. Ítems";
$GLOBALS['strRevenueCPC_short'] = "CPC Rev.";
$GLOBALS['strERPM_short'] = "ERPM";
$GLOBALS['strERPC_short'] = "ERPC";
$GLOBALS['strERPS_short'] = "ERPS";
$GLOBALS['strEIPM_short'] = "EIPM";
$GLOBALS['strEIPC_short'] = "EIPC";
$GLOBALS['strEIPS_short'] = "EIPS";
$GLOBALS['strECPM_short'] = "ECPM";
$GLOBALS['strECPC_short'] = "ECPC";
$GLOBALS['strECPS_short'] = "ECPS";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strRequests_short'] = "Petic.";
$GLOBALS['strImpressions_short'] = "Impr.";
$GLOBALS['strClicks_short'] = "Clics";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "Conv.";
$GLOBALS['strPendingConversions_short'] = "Conv. pendientes";
$GLOBALS['strImpressionSR_short'] = "SR Impr.";
$GLOBALS['strClickSR_short'] = "Clic SR";

// Global Settings
$GLOBALS['strConfiguration'] = "Configuración";
$GLOBALS['strGlobalSettings'] = "Opciones Globales";
$GLOBALS['strGeneralSettings'] = "Configuraci&oacute;n general";
$GLOBALS['strMainSettings'] = "Configuración Principal";
$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strChooseSection'] = 'Elija la sección';

// Product Updates
$GLOBALS['strProductUpdates'] = "Actualización del producto";
$GLOBALS['strViewPastUpdates'] = "Administrar actualizaciones anteriores y copias de seguridad";
$GLOBALS['strFromVersion'] = "De la Versión";
$GLOBALS['strToVersion'] = "a la Versión";
$GLOBALS['strToggleDataBackupDetails'] = "Detalles de la Palanca del respaldo de datos";
$GLOBALS['strClickViewBackupDetails'] = "haga clic para ver los detalles del respaldo";
$GLOBALS['strClickHideBackupDetails'] = "haga clic para esconder los detalles del respaldo";
$GLOBALS['strShowBackupDetails'] = "Mostrar los detalles de la data del respaldo";
$GLOBALS['strHideBackupDetails'] = "Esconder los detalles de la data del respaldo";
$GLOBALS['strBackupDeleteConfirm'] = "¿Realmente deseas borrar todos los respaldos creados desde esta actualización?";
$GLOBALS['strDeleteArtifacts'] = "Borrar Artefactos";
$GLOBALS['strArtifacts'] = "Artefactos";
$GLOBALS['strBackupDbTables'] = "Respaldar tablas de la Base de Datos";
$GLOBALS['strLogFiles'] = "Archivos de Registro";
$GLOBALS['strConfigBackups'] = "Conf respaldos";
$GLOBALS['strUpdatedDbVersionStamp'] = "Sello de actualización de versión de Base de Datos";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "ACTUALIZACIÓN COMPLETA";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "FALLO EN LA ACTUALIZACIÓN";

// Agency
$GLOBALS['strAgencyManagement'] = "Gestión de Cuentas";
$GLOBALS['strAgency'] = "Cuenta";
$GLOBALS['strAddAgency'] = "Agregar nueva cuenta";
$GLOBALS['strAddAgency_Key'] = "Agregar <u>n</u>ueva cuenta";
$GLOBALS['strTotalAgencies'] = "Cuentas totales";
$GLOBALS['strAgencyProperties'] = "Propiedades de cuenta";
$GLOBALS['strNoAgencies'] = "No hay cuentas definidas actualmente";
$GLOBALS['strConfirmDeleteAgency'] = "¿Está seguro de querer borrar esta zona?";
$GLOBALS['strHideInactiveAgencies'] = "Ocultar cuentas inactivas";
$GLOBALS['strInactiveAgenciesHidden'] = "cuentas(s) inactiva(s) ocultada(s)";
$GLOBALS['strSwitchAccount'] = "Cambiar a esta cuenta";

// Channels
$GLOBALS['strChannel'] = "Canal de Direccionamiento";
$GLOBALS['strChannels'] = "Canales de Direccionamiento";
$GLOBALS['strChannelManagement'] = "Gestión de Canales de Direccionamiento";
$GLOBALS['strAddNewChannel'] = "Agregar nuevo canal de Direccionamiento";
$GLOBALS['strAddNewChannel_Key'] = "Agregar <u>n</u>uevo canal de Direccionamiento";
$GLOBALS['strChannelToWebsite'] = "Sin sitio web";
$GLOBALS['strNoChannels'] = "No hay canales de Direccionamiento definidos actualmente";
$GLOBALS['strNoChannelsAddWebsite'] = "Actualmente no hay páginas web definidas. Para crear una zona, <a href='affiliate-edit.php'>agregue una página web</a> primero.";
$GLOBALS['strEditChannelLimitations'] = "Editar limitaciones de canal de Direccionamiento";
$GLOBALS['strChannelProperties'] = "Propiedades del Canal de Direccionamiento";
$GLOBALS['strChannelLimitations'] = "Opciones de entrega";
$GLOBALS['strConfirmDeleteChannel'] = "¿Está seguro de querer borrar este canal de direccionamiento?";
$GLOBALS['strConfirmDeleteChannels'] = "¿Está seguro de querer borrar este canal de direccionamiento?";
$GLOBALS['strChannelsOfWebsite'] = 'en'; //this is added between page name and website name eg. 'Targeting channels in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "Nombre de variable";
$GLOBALS['strVariableDescription'] = "Descripción";
$GLOBALS['strVariableDataType'] = "Tipo de dato";
$GLOBALS['strVariablePurpose'] = "Objetivo";
$GLOBALS['strGeneric'] = "Genérico";
$GLOBALS['strBasketValue'] = "Valor de cesta";
$GLOBALS['strNumItems'] = "Número de elementos";
$GLOBALS['strVariableIsUnique'] = "De-duplicar conversiones?";
$GLOBALS['strNumber'] = "Número";
$GLOBALS['strString'] = "Cadena de caracteres (string)";
$GLOBALS['strTrackFollowingVars'] = "Controlar la siguiente variable";
$GLOBALS['strAddVariable'] = "Agregar variable";
$GLOBALS['strNoVarsToTrack'] = "No hay variables que controlar.";
$GLOBALS['strVariableRejectEmpty'] = "¿Rechazar si está vacío?";
$GLOBALS['strTrackingSettings'] = "Opciones de tracking";
$GLOBALS['strTrackerType'] = "Tipo de tracker";
$GLOBALS['strTrackerTypeJS'] = "Variables Javascript de tracker";
$GLOBALS['strTrackerTypeDefault'] = "Variables Javascript de tracker (modo compatible, se necesita escapar caracteres)";
$GLOBALS['strTrackerTypeDOM'] = "Controlar elementos HTML usando DOM";
$GLOBALS['strTrackerTypeCustom'] = "Código Javascript personalizado";
$GLOBALS['strVariableCode'] = "Código Javascript de tracking";

// Password recovery
$GLOBALS['strForgotPassword'] = "¿Ha olvidado su contraseña?";
$GLOBALS['strPasswordRecovery'] = "Recuperar contraseña";
$GLOBALS['strEmailRequired'] = "E-mail es un campo requerido";
$GLOBALS['strPwdRecEmailNotFound'] = "Dirección e-mail no encontrada";
$GLOBALS['strPwdRecWrongId'] = "ID erróneo";
$GLOBALS['strPwdRecEnterEmail'] = "Introduzca su dirección e-mail a continuación";
$GLOBALS['strPwdRecEnterPassword'] = "Introduzca su nueva contraseña a continuación";
$GLOBALS['strPwdRecResetLink'] = "Enlace de reset de contraseña";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "Recuperación de contraseña %s";
$GLOBALS['strProceed'] = "Continuar >";
$GLOBALS['strNotifyPageMessage'] = "Se le ha enviado un e-mail, el cual incluye un enlace que le permitirá restaurar su contraseña y entrar en el sistema.<br />Por favor de varios minutos al e-mail para recibirlo.<br />Si no recibe el e-mail, por favor revise su carpeta de spam.<br /><a href='index.php'>Volver a la página principal de entrada al sistema.</a>";

// Audit
$GLOBALS['strAdditionalItems'] = "e ítems adicionales";
$GLOBALS['strFor'] = "para";
$GLOBALS['strHas'] = "tiene";
$GLOBALS['strBinaryData'] = "Datos binarios";
$GLOBALS['strAuditTrailDisabled'] = "Audit Trail ha sido deshabilitado por el administrador. No son grabados y mostrados más eventos en la lista de Audit Trail";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "No ha sido guardada ninguna actividad de usuario durante el espacio de tiempo que ha seleccionado.";
$GLOBALS['strAuditTrail'] = "Auditoría";
$GLOBALS['strAuditTrailSetup'] = "Configurar hoy Audit Trail";
$GLOBALS['strAuditTrailGoTo'] = "Ir a página de Audit Trail";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Ir a página de campañas";
$GLOBALS['strCampaignSetUp'] = "Registrar hoy una campaña";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>No hay actividad para mostrar de la campaña.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "No se han encontrado campañas que empiecen o terminen en el espacio de tiempo que ha seleccionado";
$GLOBALS['strCampaignAuditTrailSetup'] = "Activar Audit Trail para empezar a ver Campañas";

$GLOBALS['strUnsavedChanges'] = "Tiene cambios no guardados en esta página, asegúrese de presionar \"Guardar Cambios\" cuando finalice";
$GLOBALS['strDeliveryLimitationsDisagree'] = "ADVERTENCIA: Las limitaciones del motor de entrega <strong>NO ESTÁ DE ACUERDO</strong> con las limitaciones que se muestran debajo<br />Por favor guarde los cambios y actualice las reglas del motor de entrega";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Algunos valores incorrectos de reportes de limitaciones de entrega:";

//confirmation messages
$GLOBALS['strYouAreNowWorkingAsX'] = "Ahora esta trabajando como <b>%s</b>";

$GLOBALS['strAdvertiserHasBeenUpdated'] = "La zona <a href='%s'>%s</a> ha sido actualizada";
$GLOBALS['strAdvertisersHaveBeenDeleted'] = "El sitio web completo ha sido eliminado";

$GLOBALS['strTrackerHasBeenAdded'] = "La zona <a href='%s'>%s</a> ha sido actualizada";
$GLOBALS['strTrackerHasBeenUpdated'] = "La zona <a href='%s'>%s</a> ha sido actualizada";
$GLOBALS['strTrackersHaveBeenDeleted'] = "Todas las zonas seleccionadas han sido eliminadas";
$GLOBALS['strTrackerHasBeenDuplicated'] = "La zona <a href='%s'>%s</a> ha sido copiada como <a href='%s'>%s</a>";
$GLOBALS['strTrackerHasBeenMoved'] = "La zona <b>%s</b> ha sido movida al sitio <b>%s</b>";

$GLOBALS['strCampaignHasBeenAdded'] = "La campaña <a href='%s'> %s</a> se ha añadido, <a href='%s'> añada un banner</a>";
$GLOBALS['strCampaignHasBeenUpdated'] = "La zona <a href='%s'>%s</a> ha sido actualizada";
$GLOBALS['strCampaignsHaveBeenDeleted'] = "Todas las zonas seleccionadas han sido eliminadas";
$GLOBALS['strCampaignHasBeenDuplicated'] = "La zona <a href='%s'>%s</a> ha sido copiada como <a href='%s'>%s</a>";
$GLOBALS['strCampaignHasBeenMoved'] = "La zona <b>%s</b> ha sido movida al sitio <b>%s</b>";

$GLOBALS['strBannerHasBeenAdded'] = "La zona <a href='%s'>%s</a> ha sido actualizada";
$GLOBALS['strBannerHasBeenUpdated'] = "La zona <a href='%s'>%s</a> ha sido actualizada";
$GLOBALS['strBannerAdvancedHasBeenUpdated'] = "Las opciones avanzadas para la zona <a href='%s'>%s</a> han sido actualizadas";
$GLOBALS['strBannerAclHasBeenUpdated'] = "Las opciones de entrega para el canal de segmentación <a href='%s'>%s</a> han sido actualizadas";
$GLOBALS['strBannersHaveBeenDeleted'] = "Todas las zonas seleccionadas han sido eliminadas";
$GLOBALS['strBannerHasBeenDuplicated'] = "La zona <a href='%s'>%s</a> ha sido copiada como <a href='%s'>%s</a>";
$GLOBALS['strBannerHasBeenMoved'] = "La zona <b>%s</b> ha sido movida al sitio <b>%s</b>";
$GLOBALS['strBannerHasBeenActivated'] = "La zona <a href='%s'>%s</a> ha sido actualizada";
$GLOBALS['strBannerHasBeenDeactivated'] = "La zona <a href='%s'>%s</a> ha sido actualizada";

$GLOBALS['strXZonesLinked'] = "<b>%s</b> zona(s) vinculada(s)";
$GLOBALS['strXZonesUnlinked'] = "<b>%s</b> zona(s) desvinculada(s)";

$GLOBALS['strWebsiteHasBeenUpdated'] = "La zona <a href='%s'>%s</a> ha sido actualizada";
$GLOBALS['strWebsitesHaveBeenDeleted'] = "El sitio web completo ha sido eliminado";

$GLOBALS['strZoneHasBeenAdded'] = "La zona <a href='%s'>%s</a> ha sido actualizada";
$GLOBALS['strZoneHasBeenUpdated'] = "La zona <a href='%s'>%s</a> ha sido actualizada";
$GLOBALS['strZoneAdvancedHasBeenUpdated'] = "Las opciones avanzadas para la zona <a href='%s'>%s</a> han sido actualizadas";
$GLOBALS['strZoneHasBeenDeleted'] = "La zona <b>%s</b> se ha eliminado";
$GLOBALS['strZonesHaveBeenDeleted'] = "Todas las zonas seleccionadas han sido eliminadas";
$GLOBALS['strZoneHasBeenDuplicated'] = "La zona <a href='%s'>%s</a> ha sido copiada como <a href='%s'>%s</a>";
$GLOBALS['strZoneHasBeenMoved'] = "La zona <b>%s</b> ha sido movida al sitio <b>%s</b>";
$GLOBALS['strZoneLinkedBanner'] = "El baner ha sido vinculado a la zona <a href='%s'>%s</a>";
$GLOBALS['strZoneLinkedCampaign'] = "La campaña ha sido vinculada a la zona <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedBanner'] = "El baner ha sido desvinculado de la zona <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedCampaign'] = "La campaña ha sido desvinculada de la zona <a href='%s'>%s</a>";

$GLOBALS['strChannelHasBeenUpdated'] = "El canal de segmentación <a href='%s'>%s</a> ha sido actualizado";
$GLOBALS['strChannelAclHasBeenUpdated'] = "Las opciones de entrega para el canal de segmentación <a href='%s'>%s</a> han sido actualizadas";
$GLOBALS['strChannelsHaveBeenDeleted'] = "Todos los canales de segmentación han sido eliminados";
$GLOBALS['strChannelHasBeenDuplicated'] = "El canal de segmentación <a href='%s'>%s</a> ha sido copiado como <a href='%s'>%s</a>";

$GLOBALS['strUserPreferencesUpdated'] = "Sus preferencias de <b>%s</b> han sido actualizadas";
$GLOBALS['strEmailChanged'] = "Su correo electrónico ha sido actualizado";
$GLOBALS['strPasswordChanged'] = "Su clave ha sido actualizada";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "<b>%s</b> ha sido actualizado";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "<b>%s</b> ha sido actualizado";

// Report error messages
$GLOBALS['strReportErrorMissingSheets'] = "No ha seleccionado hoja de trabajo para el informe";
$GLOBALS['strReportErrorUnknownCode'] = "Código de error desconocido #";

/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyUp'] = "u";
$GLOBALS['keyNextItem'] = ",";
$GLOBALS['keyPreviousItem'] = ".";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch'] = "s";
$GLOBALS['keyCollapseAll'] = "c";
$GLOBALS['keyExpandAll'] = "e";
$GLOBALS['keyAddNew'] = "n";
$GLOBALS['keyNext'] = "n";
$GLOBALS['keyPrevious'] = "p";
$GLOBALS['keyLinkUser'] = "Enlace del Usuario";
