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


// Date & time configuration
$GLOBALS['date_format'] = "%d/%m/%Y";
$GLOBALS['month_format'] = "%m/%Y";
$GLOBALS['day_format'] = "%d/%m";
$GLOBALS['week_format'] = "%W/%Y";
$GLOBALS['weekiso_format'] = "%V/%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "Inicio";
$GLOBALS['strHelp'] = "Ayuda";
$GLOBALS['strStartOver'] = "Comenzar de nuevo";
$GLOBALS['strNavigation'] = "Navegación";
$GLOBALS['strShortcuts'] = "Atajos";
$GLOBALS['strActions'] = "Acción";
$GLOBALS['strAdminstration'] = "Inventario";
$GLOBALS['strMaintenance'] = "Mantenimiento";
$GLOBALS['strProbability'] = "Probabilidad";
$GLOBALS['strInvocationcode'] = "Código de invocación";
$GLOBALS['strTrackerVariables'] = "Variables de Tracker";
$GLOBALS['strBasicInformation'] = "Informaci&oacute;n B&aacute;sica";
$GLOBALS['strContractInformation'] = "Contraer información";
$GLOBALS['strLoginInformation'] = "Información de autenticación";
$GLOBALS['strLogoutURL'] = "URL de destino en cierre de sesión. <br /> Dejar en blanco para valor por defecto";
$GLOBALS['strAppendTrackerCode'] = "Añadir código de tracker";
$GLOBALS['strOverview'] = "Resumen";
$GLOBALS['strSearch'] = "<u>B</u>uscar";
$GLOBALS['strHistory'] = "Historial";
$GLOBALS['strDetails'] = "Detalles";
$GLOBALS['strUpdateSettings'] = "Configuración de Actualizaciones";
$GLOBALS['strCheckForUpdates'] = "Comprobar actualizaciones";
$GLOBALS['strWhenCheckingForUpdates'] = "Al comprobar si hay actualizaciones";
$GLOBALS['strCompact'] = "Compactar";
$GLOBALS['strUser'] = "Usuario";
$GLOBALS['strEdit'] = "Editar";
$GLOBALS['strCreate'] = "Crear";
$GLOBALS['strDuplicate'] = "Duplicado";
$GLOBALS['strMoveTo'] = "Mover a";
$GLOBALS['strDelete'] = "Borrar";
$GLOBALS['strActivate'] = "Activar";
$GLOBALS['strDeActivate'] = "Desactivar";
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
$GLOBALS['strNone'] = "Nada";
$GLOBALS['strCustom'] = "Común";
$GLOBALS['strDefault'] = "Predeterminado";
$GLOBALS['strOther'] = "Otro";
$GLOBALS['strUnknown'] = "Desconocido";
$GLOBALS['strUnlimited'] = "Ilimitado";
$GLOBALS['strUntitled'] = "Sin título";
$GLOBALS['strAll'] = "todo";
$GLOBALS['strAvg'] = "Prom.";
$GLOBALS['strAverage'] = "Promedio";
$GLOBALS['strOverall'] = "General";
$GLOBALS['strActive'] = "activo";
$GLOBALS['strFrom'] = "De";
$GLOBALS['strTo'] = "a";
$GLOBALS['strAdd'] = "Agregar";
$GLOBALS['strLinkedTo'] = "relacionado con";
$GLOBALS['strDaysLeft'] = "Días restantes";
$GLOBALS['strCheckAllNone'] = "Marcar todo / nada";
$GLOBALS['strExpandAll'] = "<u>E</u>xpandir todo";
$GLOBALS['strCollapseAll'] = "<u>C</u>ontraer todo";
$GLOBALS['strShowAll'] = "Ver todo";
$GLOBALS['strNoAdminInterface'] = "La pantalla de administración está desactivada por mantenimiento. Esto no afecta la entrega de campañas.";
$GLOBALS['strFilterBySource'] = "filtrar por fuente";
$GLOBALS['strFieldStartDateBeforeEnd'] = "La fecha 'Desde' debe ser anterior a la fecha 'Hasta'";
$GLOBALS['strFieldContainsErrors'] = "Los siguientes campos contienen errores:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Antes de continuar necesita";
$GLOBALS['strFieldFixBeforeContinue2'] = "corregir estos errores.";
$GLOBALS['strDelimiter'] = "Delimitador";
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
$GLOBALS['strNotice'] = "Atención";
$GLOBALS['strRequiredField'] = "Campo requerido";

// Dashboard
$GLOBALS['strChoosenDisableHomePage'] = "Ha escogido deshabilitar su Página Principal.";
$GLOBALS['strAccessHomePage'] = "Haga clic aquí para acceder a su Página Principal";
$GLOBALS['strEditSyncSettings'] = "y editar sus configuraciones de sincronización";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "código";
$GLOBALS['strDashboardSystemMessage'] = "Mensaje del sistema";
$GLOBALS['strDashboardErrorHelp'] = "Si este error se ha repetido por favor describa detalladamente el problema y publicalo en <a href='http://forum.openx.org/'>OpenX forum</a>. ";

// Priority
$GLOBALS['strPriority'] = "Prioridad";
$GLOBALS['strPriorityLevel'] = "Nivel de prioridad";
$GLOBALS['strPriorityTargeting'] = "Distribución";
$GLOBALS['strPriorityOptimisation'] = "Miscelánea"; // Er, what?
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
$GLOBALS['strComments'] = "Comentarios";

// User access
$GLOBALS['strWorkingAs'] = "Trabajando como";
$GLOBALS['strWorkingAs'] = "Trabajando como";
$GLOBALS['strSwitchTo'] = "Cambiar a";
$GLOBALS['strWorkingFor'] = "%s para…";
$GLOBALS['strLinkUser'] = "Agregar usuario";
$GLOBALS['strLinkUser_Key'] = "Agregar <u>u</u>suario";
$GLOBALS['strUsernameToLink'] = "Nombre de usuario del usuario a agregar";
$GLOBALS['strEmailToLink'] = "E-mail del usuario a agregar";
$GLOBALS['strNewUserWillBeCreated'] = "Se creará un nuevo usuario";
$GLOBALS['strToLinkProvideEmail'] = "Para agregar un usuario, indique el e-mail del usuario";
$GLOBALS['strToLinkProvideUsername'] = "Para agregar un usuario, indique el nombre de usuario";
$GLOBALS['strErrorWhileCreatingUser'] = "Error al crear usuario: %s";
$GLOBALS['strUserLinkedToAccount'] = "Usuario agregado a la cuenta";
$GLOBALS['strUserAccountUpdated'] = "Cuenta de usuario actualizada";
$GLOBALS['strUserUnlinkedFromAccount'] = "Usuario eliminado de la cuenta";
$GLOBALS['strUserWasDeleted'] = "Usuario ha sido borrado";
$GLOBALS['strUserNotLinkedWithAccount'] = "El usuario no está asignado a la cuenta";
$GLOBALS['strCantDeleteOneAdminUser'] = "No puede borrar el usuario. Almenos un usuario necesita estar asignado a la cuenta de admin.";
$GLOBALS['strLinkUserHelp'] = "Para agregar a un <b>usuario existente</b>, escriba %s y presione en {$GLOBALS['strLinkUser']} <br />Para agregar un  <b>nuevo usuario</b>, escriba lo deseado %s y presione en {$GLOBALS['strLinkUser']}";
$GLOBALS['strLinkUserHelpUser'] = "Nombre de usuario";
$GLOBALS['strLinkUserHelpEmail'] = "Dirección e-mail";
$GLOBALS['strLastLoggedIn'] = "Último registro de ingreso";
$GLOBALS['strDateLinked'] = "Fecha enlazada";
$GLOBALS['strUnlink'] = "Remover";
$GLOBALS['strUnlinkingFromLastEntity'] = "Remover usuario desde la última entidad";
$GLOBALS['strUnlinkingFromLastEntityBody'] = "Remover el usuario desde la última entidad puede causar que el usuario sea borrado. ¿Quiere eliminar este usuario?";
$GLOBALS['strUnlinkAndDelete'] = "Remover &amp; eliminar usuario";
$GLOBALS['strUnlinkUser'] = "Remover usuario";
$GLOBALS['strUnlinkUserConfirmBody'] = "¿Está seguro de querer remover este usuario?";

// Login & Permissions
$GLOBALS['strUserAccess'] = "Acceso de usuario";
$GLOBALS['strAdminAccess'] = "Acceso de administrador";
$GLOBALS['strUserProperties'] = "Propiedades de usuario";
$GLOBALS['strLinkNewUser'] = "Asignar nuevo usuario";
$GLOBALS['strPermissions'] = "Permisos";
$GLOBALS['strAuthentification'] = "Autenticación";
$GLOBALS['strWelcomeTo'] = "Bienvenido a";
$GLOBALS['strEnterUsername'] = "Introduzca su nombre de usuario y contraseña para entrar";
$GLOBALS['strEnterBoth'] = "Por favor, introduzca ambos, nombre de usuario y contraseña";
$GLOBALS['strEnableCookies'] = "Debe habilitar las cookies antes de usar {$PRODUCT_NAME}";
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
$GLOBALS['strDuplicateAgencyName'] = "El nombre de usuario que ha facilitado ya existe, por favor use un nombre de usuario diferente.";
$GLOBALS['strInvalidEmail'] = "El formato de esta dirección de e-mail no es válido, por favor introduzca una dirección de e-mail válida.";
$GLOBALS['strDeadLink'] = "Su enlace es inválido.";
$GLOBALS['strNoPlacement'] = "La campaña seleccionada no existe. Intente con este <a href='{link}'>enlace</a> en lugar del otro";
$GLOBALS['strNoAdvertiser'] = "El anunciante seleccionado no existe. Intente con este <a href='{link}'>enlace</a> en lugar del otro";

// General advertising
$GLOBALS['strRequests'] = "Peticiones";
$GLOBALS['strImpressions'] = "Impresiones";
$GLOBALS['strClicks'] = "Clics";
$GLOBALS['strConversions'] = "Conversiones";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strCNVR'] = "Promedio de ventas";
$GLOBALS['strTotalViews'] = "Total de Impresiones";
$GLOBALS['strTotalClicks'] = "Clics totales";
$GLOBALS['strTotalConversions'] = "Conversiones totales";
$GLOBALS['strViewCredits'] = "Créditos de impresiones";
$GLOBALS['strClickCredits'] = "Créditos de clics";
$GLOBALS['strConversionCredits'] = "Créditos de conversión";
$GLOBALS['strDateTime'] = "Fecha y hora";
$GLOBALS['strTrackerID'] = "ID Tracker";
$GLOBALS['strTrackerName'] = "Nombre del Tracker";
$GLOBALS['strTrackerImageTag'] = "Tag de Imagen";
$GLOBALS['strTrackerJsTag'] = "Tag de Javascript";
$GLOBALS['strCampaigns'] = "Campañas";
$GLOBALS['strCampaignID'] = "ID Campaña";
$GLOBALS['strCampaignName'] = "Nombre de la Campaña";
$GLOBALS['strCountry'] = "País";
$GLOBALS['strStatsAction'] = "Acción";
$GLOBALS['strWindowDelay'] = "Retardo de Ventana";

// Finance
$GLOBALS['strFinanceMT'] = "Alquiler mensual";
$GLOBALS['strPercentRevenueSplit'] = "% de recorte de ganancias";
$GLOBALS['strPercentBasketValue'] = "% Valor de cesta";
$GLOBALS['strAmountPerItem'] = "Monto por item";
$GLOBALS['strPercentCustomVariable'] = "% Variable Personalizada";
$GLOBALS['strPercentSumVariables'] = "% Suma de Variables";

// Time and date related
$GLOBALS['strDate'] = "Fecha";
$GLOBALS['strToday'] = "Hoy";
$GLOBALS['strDay'] = "Día";
$GLOBALS['strDays'] = "Días";
$GLOBALS['strLast7Days'] = "Últimos 7 días";
$GLOBALS['strWeek'] = "Semana";
$GLOBALS['strWeeks'] = "Semanas";
$GLOBALS['strSingleMonth'] = "Mes";
$GLOBALS['strMonths'] = "Meses";
$GLOBALS['strDayOfWeek'] = "Día de la semana";
$GLOBALS['strThisMonth'] = "Este Mes";

$GLOBALS['strMonth'] = array();
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

$GLOBALS['strDayFullNames'] = array();

$GLOBALS['strDayShortCuts'] = array();
$GLOBALS['strDayShortCuts'][0] = 'Do';
$GLOBALS['strDayShortCuts'][1] = 'Lu';
$GLOBALS['strDayShortCuts'][2] = 'Ma';
$GLOBALS['strDayShortCuts'][3] = 'Mi';
$GLOBALS['strDayShortCuts'][4] = 'Ju';
$GLOBALS['strDayShortCuts'][5] = 'Vi';

$GLOBALS['strHour'] = "Hora";
$GLOBALS['strSeconds'] = "segundos";
$GLOBALS['strMinutes'] = "minutos";
$GLOBALS['strHours'] = "horas";
$GLOBALS['strTimes'] = "veces";

// Advertiser
$GLOBALS['strClient'] = "Anunciante";
$GLOBALS['strClients'] = "Anunciantes";
$GLOBALS['strClientsAndCampaigns'] = "Anunciantes & Campañas";
$GLOBALS['strAddClient'] = "Agregar nuevo anunciante";
$GLOBALS['strAddClient_Key'] = "Agregar <u>n</u>uevo anunciante";
$GLOBALS['strTotalClients'] = "Anunciantes totales";
$GLOBALS['strClientProperties'] = "Propiedades del anunciante";
$GLOBALS['strClientHistory'] = "Historial del anunciante";
$GLOBALS['strNoClients'] = "No hay actualmente anunciantes definidos . Para crear una campaña, <a href='advertiser-edit.php'>agregue un anunciante</a> primero.";
$GLOBALS['strNoClientsForBanners'] = "No hay actualmente anunciantes definidos . Para crear una campaña, <a href='advertiser-edit.php'>agregue un anunciante</a> primero.";
$GLOBALS['strConfirmDeleteClient'] = "Está seguro de querer borrar este anunciante?";
$GLOBALS['strConfirmDeleteClients'] = "Está seguro de querer borrar este anunciante?";
$GLOBALS['strConfirmResetClientStats'] = "Está seguro de querer borrar todas las estadísticas de este Anunciante?";
$GLOBALS['strSite'] = "Tamaño";
$GLOBALS['strHideInactiveAdvertisers'] = "Ocultar anunciantes inactivos";
$GLOBALS['strInactiveAdvertisersHidden'] = "anunciante(s) inactivo(s) oculto(s)";
$GLOBALS['strOverallAdvertisers'] = "anunciante(s)";
$GLOBALS['strAdvertiserSignup'] = "Alta de anunciante";
$GLOBALS['strAdvertiserSignupDesc'] = "Regístrese para disponer de autoservicio de anunciante y pagos";
$GLOBALS['strAdvertiserSignupLink'] = "Enlace de Alta de Anunciante";
$GLOBALS['strAdvertiserSignupLinkDesc'] = "Para agregar un link de Alta de Anunciante a tu sitio web, por favor copia el código HTML de abajo:";
$GLOBALS['strAdvertiserSignupOption'] = "Opción de Alta de Anunciante";
$GLOBALS['strAdvertiserSignunOptionDesc'] = "Para editar tus opciones de Alta de Anunciante, vaya a";
$GLOBALS['strAdvertiserCampaigns'] = "Anunciantes & Campañas";

// Advertisers properties
$GLOBALS['strContact'] = "Contacto";
$GLOBALS['strContactName'] = "Nombre de contacto";
$GLOBALS['strEMail'] = "E-mail";
$GLOBALS['strChars'] = "caracteres";
$GLOBALS['strSendAdvertisingReport'] = "Enviar informes de entrega de campañas vía email";
$GLOBALS['strNoDaysBetweenReports'] = "Número de días entre informes de entrega de campañas";
$GLOBALS['strSendDeactivationWarning'] = "Enviar un Alerta cuando una campaña sea desactivada automáticamente";
$GLOBALS['strAllowClientModifyInfo'] = "Permitir a este usuario modificar sus propiedades";
$GLOBALS['strAllowClientModifyBanner'] = "Permitir a este usuario modificar sus propios banners";
$GLOBALS['strAllowClientAddBanner'] = "Permitir a este usuario agregar sus propios banners";
$GLOBALS['strAllowClientDisableBanner'] = "Permitir a este usuario desactivar sus propios banners";
$GLOBALS['strAllowClientActivateBanner'] = "Permitir a este usuario activar sus propios banners";
$GLOBALS['strAllowClientViewTargetingStats'] = "Permitir a este usuario ver estadísticas de targeting";
$GLOBALS['strAllowCreateAccounts'] = "Permitir a este usuario crear cuentas nuevas";
$GLOBALS['strCsvImportConversions'] = "Permitir a este usuario importar conversiones offline";
$GLOBALS['strAdvertiserLimitation'] = "Mostrar sólo un banner de este anunciante en una misma página web";
$GLOBALS['strAllowAuditTrailAccess'] = "Permitir a este usuario acceder al audit trail";

// Campaign
$GLOBALS['strCampaign'] = "Campaña";
$GLOBALS['strCampaigns'] = "Campañas";
$GLOBALS['strOverallCampaigns'] = "campaña(s)";
$GLOBALS['strTotalCampaigns'] = "Campañas totales";
$GLOBALS['strActiveCampaigns'] = "Campañas activas";
$GLOBALS['strAddCampaign'] = "Agregar nueva campaña";
$GLOBALS['strAddCampaign_Key'] = "Agregar <u>n</u>ueva campaña";
$GLOBALS['strCreateNewCampaign'] = "Crear Nueva Campaña";
$GLOBALS['strModifyCampaign'] = "Modificar campaña";
$GLOBALS['strMoveToNewCampaign'] = "Mover a una nueva Campaña";
$GLOBALS['strBannersWithoutCampaign'] = "Banners sin una Campaña";
$GLOBALS['strDeleteAllCampaigns'] = "Borrar todas las campañas";
$GLOBALS['strLinkedCampaigns'] = "Campañas enlazadas";
$GLOBALS['strCampaignStats'] = "Estadísticas de Campaña";
$GLOBALS['strCampaignProperties'] = "Propiedades de la campaña";
$GLOBALS['strCampaignOverview'] = "Resumen de campañas";
$GLOBALS['strCampaignHistory'] = "Historial de la campaña";
$GLOBALS['strNoCampaigns'] = "No hay campañas definidas";
$GLOBALS['strConfirmDeleteAllCampaigns'] = "¿Está seguro de querer borrar todas las campañas de este anunciante?";
$GLOBALS['strConfirmDeleteCampaign'] = "¿Está seguro de querer borrar esta campaña?";
$GLOBALS['strConfirmDeleteCampaigns'] = "¿Está seguro de querer borrar esta campaña?";
$GLOBALS['strShowParentAdvertisers'] = "Mostrar anunciantes superiores";
$GLOBALS['strHideParentAdvertisers'] = "Ocultar anunciantes superiores";
$GLOBALS['strHideInactiveCampaigns'] = "Ocultar campañas inactivas";
$GLOBALS['strInactiveCampaignsHidden'] = "campaña(s) inactiva(s) oculta(s)";
$GLOBALS['strContractDetails'] = "Detalles de contrato";
$GLOBALS['strInventoryDetails'] = "Detalles de inventario";
$GLOBALS['strPriorityInformation'] = "Prioridad en relación a otras campañas";
$GLOBALS['strHiddenCampaign'] = "Campaña";
$GLOBALS['strHiddenAd'] = "Anuncio";
$GLOBALS['strHiddenAdvertiser'] = "Anunciante";
$GLOBALS['strHiddenWebsite'] = "Página web";
$GLOBALS['strHiddenZone'] = "Zona";
$GLOBALS['strCompanionPositioning'] = "Mostrar compañeros (No mostrar banners de esta campaña junto a banners de otras campañas)";
$GLOBALS['strSelectUnselectAll'] = "Seleccionar / Deseleccionar todo";

// Campaign-zone linking page


// Campaign properties
$GLOBALS['strDontExpire'] = "No expirar";
$GLOBALS['strActivateNow'] = "Activar inmediatamente";
$GLOBALS['strLow'] = "Bajo";
$GLOBALS['strHigh'] = "Alto";
$GLOBALS['strExpirationDate'] = "Fecha de finalización";
$GLOBALS['strExpirationDateComment'] = "La campaña expirará al final del día";
$GLOBALS['strActivationDate'] = "Fecha de inicio";
$GLOBALS['strActivationDateComment'] = "La campaña comenzará al principio del día";
$GLOBALS['strRevenueInfo'] = "Información de ingresos";
$GLOBALS['strTotalRevenue'] = "Facturación total";
$GLOBALS['strImpressionsRemaining'] = "Impresiones restantes";
$GLOBALS['strClicksRemaining'] = "Clics restantes";
$GLOBALS['strConversionsRemaining'] = "Conversiones restantes";
$GLOBALS['strImpressionsBooked'] = "Impresiones contratadas";
$GLOBALS['strClicksBooked'] = "Clics contratados";
$GLOBALS['strConversionsBooked'] = "Conversiones contratadas";
$GLOBALS['strCampaignWeight'] = "Fijar el peso de la campaña";
$GLOBALS['strOptimise'] = "Optimizar";
$GLOBALS['strAnonymous'] = "Ocultar el anunciante y las páginas web de esta campaña.";
$GLOBALS['strHighPriority'] = "Mostrar los banners con Alta Prioridad en esta campaña.<br />
											Si Ud. usa esta opción el programa tratará de
											distribuir el nr. de Impresiones uniformemente durante el curso
											del día.";
$GLOBALS['strLowPriority'] = "Mostrar los banner con Baja Prioridad en esta campaña.<br />
											Esta campaña es usada para mostrar las Impresiones
											restantes que no son usadas por las campaña de Alta
											Prioridad.";
$GLOBALS['strTargetPerDay'] = "por día.";
$GLOBALS['strPriorityAutoTargeting'] = "Automático - Distribuir las impresiones restantes uniformemente durante los días restantes.";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "La tipo de esta campaña se ha marcado como exclusiva,
pero el peso está fijado como cero o no ha sido
especificado. Esto hará que la campaña se desactive
y sus banners no se muestren hasta que se fije
un número válido en el peso.

¿Está seguro de querer continuar?";
$GLOBALS['strCampaignWarningNoTarget'] = "La prioridad de esta campaña se ha marcado como alta,
pero el objetivo de número de impresiones no está
especificado. Esto hará que la campaña se desactive
y sus banners no se muestren hasta que se fije un
objetivo válido de impresiones.

¿Está seguro de querer continuar?";
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
$GLOBALS['strCampaignApprove'] = "Aprobada";
$GLOBALS['strCampaignApproveDescription'] = "aceptar esta campaña";
$GLOBALS['strCampaignReject'] = "Rechazar";
$GLOBALS['strCampaignRejectDescription'] = "rechazar esta campaña";
$GLOBALS['strCampaignPause'] = "Pausar";
$GLOBALS['strCampaignPauseDescription'] = "pausar esta campaña";
$GLOBALS['strCampaignRestart'] = "Resumir";
$GLOBALS['strCampaignRestartDescription'] = "resumir esta campaña";
$GLOBALS['strCampaignStatus'] = "Estado de campaña";
$GLOBALS['strReasonForRejection'] = "Razón para rechazo";
$GLOBALS['strReasonSiteNotLive'] = "Página no accesible";
$GLOBALS['strReasonBadCreative'] = "Creatividad inapropiada";
$GLOBALS['strReasonBadUrl'] = "URL de destino inapropiada";
$GLOBALS['strReasonBreakTerms'] = "Página web no cumple de términos y condiciones";
$GLOBALS['strChangeStatus'] = "Cambiar estado";
$GLOBALS['strCampaignType'] = "Nombre de la Campaña";
$GLOBALS['strContract'] = "Contacto";
$GLOBALS['strStandardContract'] = "Contacto";

// Tracker
$GLOBALS['strTrackers'] = "Seguidores";
$GLOBALS['strTrackerOverview'] = "Resumen de trackers";
$GLOBALS['strTrackerPreferences'] = "Preferencias del tracker";
$GLOBALS['strAddTracker'] = "Añadir nuevo tracker";
$GLOBALS['strAddTracker_Key'] = "Añadir <u>n</u>uevo tracker";
$GLOBALS['strNoTrackers'] = "No hay trackers definidos";
$GLOBALS['strConfirmDeleteAllTrackers'] = "¿Está seguro de querer borrar todos los trackers pertenecientes a este anunciante?";
$GLOBALS['strConfirmDeleteTrackers'] = "¿Está seguro de querer borrar este tracker?";
$GLOBALS['strConfirmDeleteTracker'] = "¿Está seguro de querer borrar este tracker?";
$GLOBALS['strDeleteAllTrackers'] = "Borrar todos los trackers";
$GLOBALS['strTrackerProperties'] = "Propiedades de trackers";
$GLOBALS['strTrackerOverview'] = "Resumen de trackers";
$GLOBALS['strModifyTracker'] = "Modificar tracker";
$GLOBALS['strLog'] = "¿Grabar?";
$GLOBALS['strDefaultStatus'] = "Estado por defecto";
$GLOBALS['strStatus'] = "Estado";
$GLOBALS['strLinkedTrackers'] = "Trackers enlazados";
$GLOBALS['strConversionWindow'] = "Ventana de conversión";
$GLOBALS['strUniqueWindow'] = "Ventana de único";
$GLOBALS['strClick'] = "Clic";
$GLOBALS['strView'] = "Vista";
$GLOBALS['strImpression'] = "Impresión";
$GLOBALS['strConversionType'] = "Tipo de Conversión";
$GLOBALS['strLinkCampaignsByDefault'] = "Enlazar campañas nuevas por defecto";
$GLOBALS['strPerSingleImpression'] = "por cada impresión";



// Banners (General)
$GLOBALS['strAddBanner'] = "Agregar nuevo banner";
$GLOBALS['strAddBanner_Key'] = "Agregar <u>n</u>uevo banner";
$GLOBALS['strBannerToCampaign'] = "Su campaña";
$GLOBALS['strModifyBanner'] = "Modificar banner";
$GLOBALS['strActiveBanners'] = "Banners activos";
$GLOBALS['strTotalBanners'] = "Banners totales";
$GLOBALS['strShowBanner'] = "Mostrar banner";
$GLOBALS['strShowAllBanners'] = "Mostrar todos los banners";
$GLOBALS['strShowBannersNoAdViews'] = "Mostrar banners sin impresiones";
$GLOBALS['strShowBannersNoAdClicks'] = "Mostrar banners sin Clicks";
$GLOBALS['strDeleteAllBanners'] = "Borrar todos los banners";
$GLOBALS['strActivateAllBanners'] = "Activar todos los banners";
$GLOBALS['strDeactivateAllBanners'] = "Desactivar todos los banners";
$GLOBALS['strBannerOverview'] = "Resumen de banners";
$GLOBALS['strBannerProperties'] = "Propiedades del banner";
$GLOBALS['strBannerHistory'] = "Historial del banner";
$GLOBALS['strBannerNoStats'] = "No hay estadísticas disponibles para este banner.";
$GLOBALS['strNoBanners'] = "No hay actualmente banners definidos";
$GLOBALS['strNoBannersAddCampaign'] = "Actualmente no hay páginas web definidas. Para crear una zona, <a href='affiliate-edit.php'>agregue una página web</a> primero.";
$GLOBALS['strNoBannersAddAdvertiser'] = "Actualmente no hay páginas web definidas. Para crear una zona, <a href='affiliate-edit.php'>agregue una página web</a> primero.";
$GLOBALS['strConfirmDeleteBanner'] = "¿Está seguro de querer borrar este banner?";
$GLOBALS['strConfirmDeleteBanners'] = "¿Está seguro de querer borrar este banner?";
$GLOBALS['strConfirmDeleteAllBanners'] = "¿Está seguro de querer borrar todos los banners pertenecientes a esta campaña?";
$GLOBALS['strConfirmResetBannerStats'] = "Está seguro de querer borrar todas las estadísticas de este banner?";
$GLOBALS['strShowParentCampaigns'] = "Mostrar campañas relacionadas";
$GLOBALS['strHideParentCampaigns'] = "Ocultar campañas relacionadas";
$GLOBALS['strHideInactiveBanners'] = "Ocultar banners inactivos";
$GLOBALS['strInactiveBannersHidden'] = "banner(s) inactivo(s) oculto(s)";
$GLOBALS['strAppendTextAdNotPossible'] = "No es posible añadir otros banners a banners de texto.";
$GLOBALS['strWarningMissing'] = "Aviso, probablemente falta";
$GLOBALS['strWarningMissingClosing'] = " tag de cierre \">\"";
$GLOBALS['strWarningMissingOpening'] = " tag de apertura \"<\"";
$GLOBALS['strSubmitAnyway'] = "Enviar de todas maneras";
$GLOBALS['strBannersOfCampaign'] = "en"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'// Banner Preferences
$GLOBALS['strBannerPreferences'] = "Preferencias de banner";
$GLOBALS['strDefaultBannerDestination'] = "URL de destino predeterminada";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Por favor, elija el tipo de banner";
$GLOBALS['strMySQLBanner'] = "Banner Local (SQL)";
$GLOBALS['strWebBanner'] = "Banner Local (Webserver)";
$GLOBALS['strURLBanner'] = "Banner Externo";
$GLOBALS['strHTMLBanner'] = "Banner HTML";
$GLOBALS['strTextBanner'] = "Banner de texto";
$GLOBALS['strUploadOrKeep'] = "¿Desea conservar<br />la imagen existente,<br />o desea subir una nueva?";
$GLOBALS['strUploadOrKeepAlt'] = "¿Desea conservar<br />la imagen de reserva,<br />o desea subir una nueva?";
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
$GLOBALS['strGenericOutputAdServer'] = "Genérico";
$GLOBALS['strSwfTransparency'] = "Permitir fondo transparente";

// Banner (advanced)

// Banner (swf)
$GLOBALS['strCheckSWF'] = "Comprobar enlaces <i>hard-coded</i> en el archivo Flash";
$GLOBALS['strConvertSWFLinks'] = "Convertir enlaces Flash";
$GLOBALS['strHardcodedLinks'] = "Enlaces <i>hard-coded</i>";
$GLOBALS['strConvertSWF'] = "<br />El archivo Flash que acaba de subir contiene enlaces <i>hard-coded</i>. {$PRODUCT_NAME} no podrá rastrear el número de clics para este banner si no convierte los enlaces <i>hard-coded</i>. A continuación encontrará una lista de todos los enlaces correspondientes al archivo Flash. Si quiere convertir los enlaces, simplemente haga clic en <b>Convertir</b>; si no haga clic en <b>Cancelar</b>.<br /><br />Advierta que si hace clic en <b>Convertir</b>, el archivo Flash será alterado físicamente. <br />Conserve una copia de seguridad del archivo original. Sin importar la versión en la cual fue creado el banner, el archivo resultante podrá ser visto correctamente con Flash 4 player (o posterior).<br /><br />";
$GLOBALS['strCompressSWF'] = "Comprimir el archivo SWF para descargarlo más rápidamente (Reproductor Flash 6 es requerido)";
$GLOBALS['strOverwriteSource'] = "Sobreescribir parámetro de origen";

// Banner (network)
$GLOBALS['strBannerNetwork'] = "plantilla HTML";
$GLOBALS['strChooseNetwork'] = "Elija la plantilla que quiera usar";
$GLOBALS['strMoreInformation'] = "Mas información...";
$GLOBALS['strTrackAdClicks'] = "Rastrear Clicks";

// Banner (AdSense)
$GLOBALS['strAdSenseAccounts'] = "Cuentas AdSense";
$GLOBALS['strLinkAdSenseAccount'] = "Enlazar cuenta AdSense";
$GLOBALS['strCreateAdSenseAccount'] = "Crear cuenta AdSense";
$GLOBALS['strEditAdSenseAccount'] = "Editar cuenta AdSense";

// Display limitations
$GLOBALS['strModifyBannerAcl'] = "Opciones de entrega";
$GLOBALS['strACL'] = "Entrega";
$GLOBALS['strACLAdd'] = "Agregar nuevas limitaciones";
$GLOBALS['strNoLimitations'] = "Sin limitaciones";
$GLOBALS['strApplyLimitationsTo'] = "Aplicar limitaciones a";
$GLOBALS['strRemoveAllLimitations'] = "Quitar todas las limitaciones";
$GLOBALS['strEqualTo'] = "es igual a";
$GLOBALS['strDifferentFrom'] = "es diferente de";
$GLOBALS['strLaterThan'] = "es más tarde de";
$GLOBALS['strLaterThanOrEqual'] = "es más tarde o igual a";
$GLOBALS['strEarlierThan'] = "es antes de";
$GLOBALS['strEarlierThanOrEqual'] = "es antes o igual a";
$GLOBALS['strGreaterThan'] = "es mayor que";
$GLOBALS['strLessThan'] = "es menor que";
$GLOBALS['strAND'] = "Y";                          // logical operator
$GLOBALS['strOR'] = "O";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Mostrar este banner solamente cuando:";
$GLOBALS['strWeekDay'] = "Día de semana";
$GLOBALS['strWeekDays'] = "Días de la semana";
$GLOBALS['strTime'] = "Hora";
$GLOBALS['strUserAgent'] = "Browser";
$GLOBALS['strDomain'] = "Dominio";
$GLOBALS['strClientIP'] = "IP del Cliente";
$GLOBALS['strSource'] = "Origen";
$GLOBALS['strCity'] = "Ciudad";
$GLOBALS['strDeliveryLimitations'] = "Limitaciones de entrega";

$GLOBALS['strDeliveryCapping'] = "Límite de entrega por visitante";
$GLOBALS['strDeliveryCappingReset'] = "Resetear contadores de vistas después de:";
$GLOBALS['strDeliveryCappingTotal'] = "en total";
$GLOBALS['strDeliveryCappingSession'] = "por sesión";

$GLOBALS['strCappingBanner'] = array();
$GLOBALS['strCappingBanner']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingBanner']['limit'] = "Limitar vistas de banners a:";

$GLOBALS['strCappingCampaign'] = array();
$GLOBALS['strCappingCampaign']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingCampaign']['limit'] = "Limitar vistas de campa&ntilde;a a:";

$GLOBALS['strCappingZone'] = array();
$GLOBALS['strCappingZone']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingZone']['limit'] = "Limitar vistas de zonas a:";

// Website
$GLOBALS['strAffiliate'] = "Página web";
$GLOBALS['strAffiliates'] = "Páginas web";
$GLOBALS['strAffiliatesAndZones'] = "Páginas web y Zonas";
$GLOBALS['strAddNewAffiliate'] = "Agregar nueva página web";
$GLOBALS['strAddNewAffiliate_Key'] = "Agregar <u>n</u>ueva página web";
$GLOBALS['strAddAffiliate'] = "Crear página web";
$GLOBALS['strAffiliateProperties'] = "Propiedades de la página web";
$GLOBALS['strAffiliateOverview'] = "Resumen de páginas web";
$GLOBALS['strAffiliateHistory'] = "Historial de la página web";
$GLOBALS['strZonesWithoutAffiliate'] = "Zonas sin página web";
$GLOBALS['strMoveToNewAffiliate'] = "Mover a nueva página web";
$GLOBALS['strNoAffiliates'] = "Actualmente no hay páginas web definidas. Para crear una zona, <a href='affiliate-edit.php'>agregue una página web</a> primero.";
$GLOBALS['strConfirmDeleteAffiliate'] = "Está seguro de querer borrar esta página web?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Está seguro de querer borrar esta página web?";
$GLOBALS['strMakePublisherPublic'] = "Convertir en públicas las zonas de esta página web";
$GLOBALS['strAffiliateInvocation'] = "Código de invocación";
$GLOBALS['strAdvertiserSetup'] = "Alta de anunciante";
$GLOBALS['strTotalAffiliates'] = "Páginas web totales";
$GLOBALS['strInactiveAffiliatesHidden'] = "página web(s) inactiva(s) oculta(s)";
$GLOBALS['strShowParentAffiliates'] = "Mostrar páginas web relacionadas";
$GLOBALS['strHideParentAffiliates'] = "Ocultar páginas web relacionadas";

// Website (properties)
$GLOBALS['strWebsite'] = "Página web";
$GLOBALS['strWebsiteURL'] = "URL del Sitio Web";
$GLOBALS['strMnemonic'] = "Mnemónico";
$GLOBALS['strAllowAffiliateModifyInfo'] = "Permitir a este usuario modificar sus propiedades";
$GLOBALS['strAllowAffiliateModifyZones'] = "Permitir a este usuario modificar sus zonas";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Permitir a este usuario enlazar banners a sus zonas";
$GLOBALS['strAllowAffiliateAddZone'] = "Permitir a este usuario definir nuevas zonas";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Permitir a este usuario borrar zonas existentes";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Permitir a este usuario generar código de invocación";
$GLOBALS['strAllowAffiliateZoneStats'] = "Permitir a este usuario ver estadísticas de zonas";
$GLOBALS['strAllowAffiliateApprPendConv'] = "Permitir a este usuario ver sólo conversiones aprobadas o pendientes";

// Website (properties - payment information)
$GLOBALS['strPaymentInformation'] = "Información de pagos";
$GLOBALS['strAddress'] = "Dirección";
$GLOBALS['strPostcode'] = "Código postal";
$GLOBALS['strCity'] = "Ciudad";
$GLOBALS['strCountry'] = "País";
$GLOBALS['strPhone'] = "Teléfono";
$GLOBALS['strAccountContact'] = "Contacto de cuenta";
$GLOBALS['strPayeeName'] = "Nombre del Beneficiario";
$GLOBALS['strTaxID'] = "ID del Impuesto";
$GLOBALS['strModeOfPayment'] = "Modo de pago";
$GLOBALS['strPaymentChequeByPost'] = "Cheque postal";
$GLOBALS['strCurrency'] = "Moneda";

// Website (properties - other information)
$GLOBALS['strOtherInformation'] = "Otra información";
$GLOBALS['strUniqueUsersMonth'] = "Usuarios únicos/mes";
$GLOBALS['strUniqueViewsMonth'] = "Vistas únicas/mes";
$GLOBALS['strCategory'] = "Categoría";
$GLOBALS['strHelpFile'] = "Archivo de ayuda";
$GLOBALS['strWebsiteZones'] = "Páginas web y Zonas";

// Zone
$GLOBALS['strZone'] = "Zona";
$GLOBALS['strZones'] = "Zonas";
$GLOBALS['strAddNewZone'] = "Agregar nueva zona";
$GLOBALS['strAddNewZone_Key'] = "Agregar <u>n</u>ueva zona";
$GLOBALS['strAddZone'] = "Crear Zona";
$GLOBALS['strModifyZone'] = "Modificar zona";
$GLOBALS['strZoneToWebsite'] = "Sin sitio web";
$GLOBALS['strLinkedZones'] = "Zonas enlazadas";
$GLOBALS['strZoneOverview'] = "Resumen de zonas";
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
$GLOBALS['strTextAdZone'] = "Texto";
$GLOBALS['strEmailAdZone'] = "Zona de E-mail/Boletín";
$GLOBALS['strZoneClick'] = "Zona de tracking de clics";
$GLOBALS['strShowMatchingBanners'] = "Mostrar banners correspondientes";
$GLOBALS['strHideMatchingBanners'] = "Ocultar banners correspondientes";
$GLOBALS['strBannerLinkedAds'] = "Banners enlazados a la zona";
$GLOBALS['strCampaignLinkedAds'] = "Campañas enlazadas a la zona";
$GLOBALS['strTotalZones'] = "Zonas totales";
$GLOBALS['strInactiveZonesHidden'] = "zona(s) inactiva(s) oculta(s)";
$GLOBALS['strWarnChangeZoneType'] = "Cambiar el tipo de zona a texto o a e-mail desenlazara todos los banners/campañas debido a restricciones en esos tipos de zonas
   <ul>
      <li>Zonas de texto sólo pueden enlazarse con banners de texto</li>
      <li>Campañas en zonas de e-mail sólo pueden tener un banner activo a la vez</li>
   </ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Cambiar la zona desenlazará cualquier banner que no tenga el nuevo tamaño, y añadirá banners de campañas enlazadas que coincidan con el nuevo tamaño';
$GLOBALS['strWarnChangeBannerSize'] = 'Cambiar el tamaño del banner lo desmarcará de todas las zonas que no tengan el nuevo tamaño, y si la <b>campaña</b> del banner está enlazada con una zona del nuevo tamaño, el banner se asignará automáticamente';
$GLOBALS['strInventoryForecasting'] = 'Pronóstico del Inventario';
$GLOBALS['strZonesOfWebsite'] = 'en'; //this is added between page name and website name eg. 'Zones in www.example.com'$GLOBALS['strBackToZones'] = "Back to zones";

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "IAB Banner Clásico (468 x 60)";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "IAB Rascacielos (120 x 600)";
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

// Advanced zone settings
$GLOBALS['strAdvanced'] = "Avanzado";
$GLOBALS['strChains'] = "Cadenas";
$GLOBALS['strChainSettings'] = "Propiedades de encadenación";
$GLOBALS['strZoneNoDelivery'] = "Si ningún banner de esta zona <br />puede ser entregado, tratar de...";
$GLOBALS['strZoneStopDelivery'] = "Detener la entrega y no mostrar un banner";
$GLOBALS['strZoneOtherZone'] = "Mostrar la siguiente zona en su lugar";
$GLOBALS['strZoneUseKeywords'] = "Seleccionar un banner usando las siguientes palabras claves";
$GLOBALS['strZoneAppend'] = "Adjuntar siempre el siguiente popup o interstitial a los banners mostrados en esta zona";
$GLOBALS['strAppendSettings'] = "Opciones de adjuntos";
$GLOBALS['strZoneForecasting'] = "Opciones de previsión de zonas";
$GLOBALS['strZonePrependHTML'] = "Pre-añadir siempre el código HTML al banner de texto mostrado por esta zona";
$GLOBALS['strZoneAppendHTML'] = "Añadir siempre el código HTML al texto publicitario mostrado por esta zona";
$GLOBALS['strZoneAppendNoBanner'] = "Añadir incluso si no hay banners que mostrar";
$GLOBALS['strZoneAppendType'] = "Tipo de zona";
$GLOBALS['strZoneAppendHTMLCode'] = "Código HTML";
$GLOBALS['strZoneAppendZoneSelection'] = "Popup o interstitial";
$GLOBALS['strZoneAppendSelectZone'] = "Siempre añadir el siguiente popup o interstitial a los banners mostrados por esta zona";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "Todos los banners enlazados a esta zona están actualmente desactivados. <br />Esta es la cadena de zonas:";
$GLOBALS['strZoneProbNullPri'] = "No hay banners activos enlazados a esta zona.";
$GLOBALS['strZoneProbListChainLoop'] = "Continuar con la cadena de zonas provocará un bucle circular. Se ha detenido la entrega de esta zona.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Por favor, elija qué enlazar a esta zona";
$GLOBALS['strLinkedBanners'] = "Enlazar banners individuales";
$GLOBALS['strCampaignDefaults'] = "Enlazar banners por campaña padre";
$GLOBALS['strLinkedCategories'] = "Enlazar banners por categoría";
$GLOBALS['strInteractive'] = "Interactivo";
$GLOBALS['strRawQueryString'] = "Palabra clave";
$GLOBALS['strIncludedBanners'] = "Banners relacionados";
$GLOBALS['strLinkedBannersOverview'] = "Resumen de banners relacionados";
$GLOBALS['strLinkedBannerHistory'] = "Historial de banners relacionados";
$GLOBALS['strNoZonesToLink'] = "No hay zonas disponibles donde enlazar este banner";
$GLOBALS['strNoBannersToLink'] = "No hay banners disponibles para linkear a esta zona";
$GLOBALS['strNoLinkedBanners'] = "No hay banners relacionados a esta zona";
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
$GLOBALS['strTrackerCodeSubject'] = "Añadir código de tracker";
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
$GLOBALS['strNoTargetingStats'] = "No hay estadísticas de targeting disponibles";
$GLOBALS['strNoStatsForPeriod'] = "No hay estadísticas disponibles para el periodo del %s al %s";
$GLOBALS['strNoTargetingStatsForPeriod'] = "No hay estadísticas de targeting disponibles para el periodo del %s al %s";
$GLOBALS['strConfirmResetStats'] = "Est&aacute seguro de querer borrar todas las estadísticas?";
$GLOBALS['strGlobalHistory'] = "Historial global";
$GLOBALS['strDailyHistory'] = "Historial diario";
$GLOBALS['strDailyStats'] = "Estadísticas diarias";
$GLOBALS['strWeeklyHistory'] = "Historial semanal";
$GLOBALS['strMonthlyHistory'] = "Historial mensual";
$GLOBALS['strCreditStats'] = "Estadísticas de créditos";
$GLOBALS['strDetailStats'] = "Estadísticas detalladas";
$GLOBALS['strTotalThisPeriod'] = "Total en este periodo";
$GLOBALS['strAverageThisPeriod'] = "Promedio del período";
$GLOBALS['strPublisherDistribution'] = "Distribución de páginas web";
$GLOBALS['strCampaignDistribution'] = "Distribución de campañas";
$GLOBALS['strResetStats'] = "Resetear Estadísticas";
$GLOBALS['strSourceStats'] = "Estadísticas de fuente";
$GLOBALS['strSelectSource'] = "Seleccione la fuente que desea ver:";
$GLOBALS['strTargetStats'] = "Estadísticas de targeting";
$GLOBALS['strViewBreakdown'] = "Ver por";
$GLOBALS['strBreakdownByDay'] = "Día";
$GLOBALS['strBreakdownByWeek'] = "Semana";
$GLOBALS['strBreakdownByMonth'] = "Mes";
$GLOBALS['strBreakdownByDow'] = "Día de la semana";
$GLOBALS['strBreakdownByHour'] = "Hora";
$GLOBALS['strItemsPerPage'] = "Elementos por página";
$GLOBALS['strDistributionHistory'] = "Distribución de histórico";
$GLOBALS['strShowGraphOfStatistics'] = "Mostrar <u>g</u>ráfica de estadísticas";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>xportar estadísticas a Excel";
$GLOBALS['strGDnotEnabled'] = "Debe tener GD activado en PHP para poder mostrar gráficas. Por favor, vea <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> para más información, incluyendo cómo instalar GD en su servidor.";
$GLOBALS['strStatsArea'] = "Área";

// Hosts

// Expiration
$GLOBALS['strExpired'] = "Caducado";
$GLOBALS['strExpiration'] = "Caducidad";
$GLOBALS['strNoExpiration'] = "Sin fecha de expiración fijada";
$GLOBALS['strEstimated'] = "Expiración estimada";
$GLOBALS['strNoExpirationEstimation'] = "Sin expiración estimada todavía";
$GLOBALS['strDaysAgo'] = "días atrás";
$GLOBALS['strCampaignStop'] = "Detener campaña";

// Reports
$GLOBALS['strReports'] = "Informes";
$GLOBALS['strPublisherReports'] = "Informes de páginas web";
$GLOBALS['strSelectReport'] = "Elija el reporte que desea generar";
$GLOBALS['strStartDate'] = "Fecha de inicio";
$GLOBALS['strEndDate'] = "Fecha de finalización";
$GLOBALS['strPeriod'] = "Periodo";
$GLOBALS['strLimitations'] = "Limitaciones";
$GLOBALS['strWorksheets'] = "Hojas de trabajo";

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


// Errors
$GLOBALS['strMySQLError'] = "Error SQL:";
$GLOBALS['strErrorDatabaseConnetion'] = "Error de conexión a la Base de Datos.";
$GLOBALS['strErrorCantConnectToDatabase'] = "Un error fatal se ha producido en %s y no es posible conectarse a la base de datos. Por esta razón no es posible conectarse con la interfaz de administración. La entrega de banners también puede verse afectada. Algunas posibles razones para el problema son: <ul> <li>El servidor de la base de datos puede no estar funcionando en este momento</li> <li>La dirección del servidor de la base de datos ha cambiado</li> <li>El nombre de usuario o clave usados para ingresar en la base de datos no es el correcto</li> <li>PHP no ha cargado la extensión MySQL</li> </ul>";
$GLOBALS['strLogErrorClients'] = "[phpAds] Ha ocurrido un error al recoger los anunciantes de la base de datos.";
$GLOBALS['strLogErrorBanners'] = "[phpAds] Ha ocurrido un error al recoger los banners de la base de datos.";
$GLOBALS['strLogErrorViews'] = "[phpAds] Ha ocurrido un error al recoger los adviews de la base de datos.";
$GLOBALS['strLogErrorClicks'] = "[phpAds] Ha ocurrido un error al recoger los adclicks de la base de datos.";
$GLOBALS['strLogErrorConversions'] = "[phpAds] Ha ocurrido un error al recoger las conversiones de la base de datos.";
$GLOBALS['strErrorViews'] = "Debe ingresar el numero de Impresiones o seleccionar la casilla de Ilimitadas !";
$GLOBALS['strErrorNegViews'] = "No están permitidas Impresiones negativas !";
$GLOBALS['strErrorClicks'] = "Debe ingresar el numero de Clicks o seleccionar la casilla de Ilimitadas !";
$GLOBALS['strErrorNegClicks'] = "No están permitidos los Clicks negativos";
$GLOBALS['strNoMatchesFound'] = "No se han encontrado resultados.";
$GLOBALS['strErrorOccurred'] = "Ha ocurrido un error";
$GLOBALS['strErrorUploadSecurity'] = "Se ha detectado un posible problema de seguridad. ¡Upload cancelado!";
$GLOBALS['strErrorUploadBasedir'] = "No se puede acceder al archivo recibido, probablemente debido al modo seguro (safemode) o restricciones sobre open_basedir";
$GLOBALS['strErrorUploadUnknown'] = "No se puede acceder al archivo recibido y se desconoce la razón. Compruebe su configuración de PHP";
$GLOBALS['strErrorStoreLocal'] = "Ha ocurrido un error mientras se intentaba guardar el banner en el directorio local. Probablemente se deba a una mala configuración del directorio local";
$GLOBALS['strErrorStoreFTP'] = "Ha ocurrido un error mientras se intentaba subir el banner al servidor FTP. Puede deberse a que el servidor FTP no se encuentra disponible o bien a una mala configuración del mismo";
$GLOBALS['strErrorDBPlain'] = "Ha ocurrido un error al intentar acceder a la base de datos";
$GLOBALS['strErrorDBSerious'] = "Se ha detectado un problema serio con la base de datos";
$GLOBALS['strErrorDBNoDataPlain'] = "Debido a un problema con la base de datos {$PRODUCT_NAME} no ha podido recuperar o guardar los datos.";
$GLOBALS['strErrorDBNoDataSerious'] = "Debido a un problema serio con la base de datos, {$PRODUCT_NAME} no ha podido cargar los datos.";
$GLOBALS['strErrorDBCorrupt'] = "La tabla de base de datos está probablemente corrupta y necesita ser reparada. Para más información sobre reparación de tablas corruptas, por favor, lea el capítulo <i>Troubleshooting</i> (resolución de problemas) de la <i>Guía del Administrador</i>.";
$GLOBALS['strErrorDBContact'] = "Por favor, contacte con el administrador de este servidor y notifíquele el problema.";
$GLOBALS['strErrorDBSubmitBug'] = "Si el problema es reproducible puede ser debido a un bug en {$PRODUCT_NAME}. Por favor, envíe la siguiente información a los creadores de {$PRODUCT_NAME}. También intente describir las acciones que le han llevado hasta este error tan claramente como le sea posible.";
$GLOBALS['strMaintenanceNotActive'] = "El script de mantenimiento no ha sido ejecutado en las últimas 24 horas.
Para asegurar el buen funcionamiento de {$PRODUCT_NAME}, necesita ejecutarse
cada hora.

Por favor, lea la Guía del Administrador para más información
sobre la configuración del script de mantenimiento.";
$GLOBALS['strErrorLinkingBanner'] = "No ha sido posible enlazar el banner a esta zona porque:";
$GLOBALS['strUnableToLinkBanner'] = "No se puede enlazar este banner:";
$GLOBALS['strErrorEditingCampaign'] = "Error actualizando campaña:";
$GLOBALS['strUnableToChangeCampaign'] = "No se pueden aplicar los cambios porque:";
$GLOBALS['strErrorEditingCampaignRevenue'] = "formato incorrecto de número en el campo de Información de Ingresos";
$GLOBALS['strErrorEditingZone'] = "Error actualizando zona:";
$GLOBALS['strUnableToChangeZone'] = "No se pueden aplicar los cambios porque:";
$GLOBALS['strDatesConflict'] = "las fechas son conflictivas con:";
$GLOBALS['strEmailNoDates'] = "Las zonas de campañas de e-mails deben tener fecha de inicio y finalización";
$GLOBALS['strWarningInaccurateStats'] = "Algunas de estas estadísticas no fueron logueadas en un huso horario UTC por lo que podrían ser mostradas en un huso horario incorrecto.";
$GLOBALS['strWarningInaccurateReadMore'] = "Leer más sobre esto";
$GLOBALS['strWarningInaccurateReport'] = "Algunas estadísticas en este informe no fueron logueadas en un huso horario UTC por lo que podrían ser mostradas en un huso horario incorrecto.";

//Validation
$GLOBALS['strRequiredField'] = "Campo requerido";
$GLOBALS['strXPositiveWholeNumberField'] = "%s debe ser un número positivo entero";
$GLOBALS['strInvalidWebsiteURL'] = "URL inválida";


// Email
$GLOBALS['strSirMadam'] = "Sr/a.";
$GLOBALS['strMailSubject'] = "Informe de anunciante";
$GLOBALS['strAdReportSent'] = "Reporte de Anunciante enviado";
$GLOBALS['strMailHeader'] = "Estimado/a {contact},";
$GLOBALS['strMailBannerStats'] = "A continuación encontrará las estadísticas de banners de {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Campaña activada";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Campaña desactivada";
$GLOBALS['strMailBannerActivated'] = "La campaña mostrada debajo ha sido activada porque
la fecha de activación de la campaña ha llegado.";
$GLOBALS['strMailBannerDeactivated'] = "La campaña mostrada debajo ha sido desactivada porque";
$GLOBALS['strMailFooter'] = "Le saluda atentamente,
   {adminfullname}";
$GLOBALS['strMailClientDeactivated'] = "Los siguientes banners fueron deshabilitados porque";
$GLOBALS['strMailNothingLeft'] = "Si desea seguir colaborando con nosotros poniendo anuncios, por favor, contacte con nosotros. Estaremos encantados de hablar con usted.
Nos alegrará volver a saber de usted.";
$GLOBALS['strClientDeactivated'] = "Esta campaña no se encuentra activada porque";
$GLOBALS['strBeforeActivate'] = "la fecha de activación aún no ha llegado";
$GLOBALS['strAfterExpire'] = "ha llegado la fecha de caducidad";
$GLOBALS['strNoMoreImpressions'] = "no quedan impresiones disponibles";
$GLOBALS['strNoMoreClicks'] = "no quedan clics disponibles";
$GLOBALS['strNoMoreConversions'] = "no quedan ventas disponibles";
$GLOBALS['strWeightIsNull'] = "el peso es cero";
$GLOBALS['strTargetIsNull'] = "el target es cero";
$GLOBALS['strWarnClientTxt'] = "Las impresiones, clics o conversiones restantes para sus banners están llegando por debajo de {limit}.
Sus banners se desactivarán cuando ya no queden impresiones, clics o conversiones.";
$GLOBALS['strImpressionsClicksConversionsLow'] = "Las impresiones/clics/conversiones son bajas";
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
$GLOBALS['strImpendingCampaignExpiryBody'] = "Como resultado, pronto la campaña será desactivada automáticamente, y los
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
$GLOBALS['strAdminEmailWarnings'] = "Avisos e-mail de administrador";
$GLOBALS['strAgencyEmailWarnings'] = "Avisos e-mail de agencia";
$GLOBALS['strAdveEmailWarnings'] = "Avisos e-mail de anunciante";
$GLOBALS['strFullName'] = "Nombre completo";
$GLOBALS['strEmailAddress'] = "Dirección e-mail";
$GLOBALS['strUserDetails'] = "Detalles usuario";
$GLOBALS['strLanguageTimezone'] = "Idioma y zona horaria";
$GLOBALS['strLanguageTimezonePreferences'] = "Preferencias de Idiomas y Zona Horaria";
$GLOBALS['strUserInterfacePreferences'] = "Preferencias de interfaz de usuario";
$GLOBALS['strPluginPreferences'] = "Opciones principales";
$GLOBALS['strInvocationPreferences'] = "Preferencias de invocación";
$GLOBALS['strColumnName'] = "Nombre de Columna";
$GLOBALS['strShowColumn'] = "Mostrar Columna";
$GLOBALS['strCustomColumnName'] = "Nombre de Columna Personalizada";
$GLOBALS['strColumnRank'] = "Rango de Columna";


// Statistics columns
// Long names
$GLOBALS['strRevenue'] = "Ganancias";
$GLOBALS['strNumberOfItems'] = "Número de elementos";
$GLOBALS['strRevenueCPC'] = "Ingresos CPC";
$GLOBALS['strECPM'] = "ECPM";
$GLOBALS['strPendingConversions'] = "Conversiones pendientes";
$GLOBALS['strImpressionSR'] = "Impresión SR";
$GLOBALS['strClickSR'] = "Clic SR";
$GLOBALS['strActualImpressions'] = "Impresiones";

// Short names
$GLOBALS['strRevenue_short'] = "Fact.";
$GLOBALS['strBasketValue_short'] = "VC";
$GLOBALS['strNumberOfItems_short'] = "Num. Ítems";
$GLOBALS['strRequests_short'] = "Petic.";
$GLOBALS['strClicks_short'] = "Clics";
$GLOBALS['strPendingConversions_short'] = "Conv. pendientes";
$GLOBALS['strClickSR_short'] = "Clic SR";

// Global Settings
$GLOBALS['strGlobalSettings'] = "Opciones Globales";
$GLOBALS['strGeneralSettings'] = "Configuraci&oacute;n general";
$GLOBALS['strMainSettings'] = "Configuración Principal";
$GLOBALS['strAdminSettings'] = "Opciones de administraci&oacute;n";


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
$GLOBALS['strInstallation'] = "Instalación";
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
$GLOBALS['strAgencies'] = "Cuentas";
$GLOBALS['strAddAgency'] = "Agregar nueva cuenta";
$GLOBALS['strAddAgency_Key'] = "Agregar <u>n</u>ueva cuenta";
$GLOBALS['strTotalAgencies'] = "Cuentas totales";
$GLOBALS['strAgencyProperties'] = "Propiedades de cuenta";
$GLOBALS['strNoAgencies'] = "No hay cuentas definidas actualmente";
$GLOBALS['strConfirmDeleteAgency'] = "¿Está seguro de querer borrar esta zona?";
$GLOBALS['strHideInactiveAgencies'] = "Ocultar cuentas inactivas";
$GLOBALS['strInactiveAgenciesHidden'] = "cuentas(s) inactiva(s) ocultada(s)";
$GLOBALS['strAllowAgencyEditConversions'] = "Permitir a este usuario editar conversiones";
$GLOBALS['strAllowMoreReports'] = "Permitir botón de Más Informes";
$GLOBALS['strSwitchAccount'] = "Cambiar a esta cuenta";

// Channels
$GLOBALS['strChannel'] = "Canal de Direccionamiento";
$GLOBALS['strChannels'] = "Canales de Direccionamiento";
$GLOBALS['strChannelOverview'] = "Resumen de Canales de Direccionamiento";
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
$GLOBALS['strModifychannel'] = "Editar canal de targeting";
$GLOBALS['strChannelsOfWebsite'] = 'en'; //this is added between page name and website name eg. 'Targeting channels in www.example.com'// Tracker Variables
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
$GLOBALS['strVariableHidden'] = "¿Esconder variable a páginas web?";
$GLOBALS['strVariableRejectEmpty'] = "¿Rechazar si está vacío?";
$GLOBALS['strTrackingSettings'] = "Opciones de tracking";
$GLOBALS['strTrackerType'] = "Tipo de tracker";
$GLOBALS['strTrackerTypeJS'] = "Variables Javascript de tracker";
$GLOBALS['strTrackerTypeDefault'] = "Variables Javascript de tracker (modo compatible, se necesita escapar caracteres)";
$GLOBALS['strTrackerTypeDOM'] = "Controlar elementos HTML usando DOM";
$GLOBALS['strTrackerTypeCustom'] = "Código Javascript personalizado";
$GLOBALS['strVariableCode'] = "Código Javascript de tracking";


// Upload conversions
$GLOBALS['strYouHaveNoCampaigns'] = "Anunciantes & Campañas";


// Password recovery
$GLOBALS['strForgotPassword'] = "¿Ha olvidado su contraseña?";
$GLOBALS['strPasswordRecovery'] = "Recuperar contraseña";
$GLOBALS['strEmailRequired'] = "E-mail es un campo requerido";
$GLOBALS['strPwdRecEmailSent'] = "Recuperar email enviados";
$GLOBALS['strPwdRecEmailNotFound'] = "Dirección e-mail no encontrada";
$GLOBALS['strPwdRecPasswordSaved'] = "Se ha guardado la nueva contraseña, proceda a <a href='index.php'>iniciar sesión</a>";
$GLOBALS['strPwdRecWrongId'] = "ID erróneo";
$GLOBALS['strPwdRecEnterEmail'] = "Introduzca su dirección e-mail a continuación";
$GLOBALS['strPwdRecEnterPassword'] = "Introduzca su nueva contraseña a continuación";
$GLOBALS['strPwdRecReset'] = "Borrar password";
$GLOBALS['strPwdRecResetLink'] = "Enlace de reset de contraseña";
$GLOBALS['strPwdRecResetPwdThisUser'] = "Borrar password para este usuario";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "Recuperación de contraseña %s";
$GLOBALS['strNotifyPageMessage'] = "Se le ha enviado un e-mail, el cual incluye un enlace que le permitirá restaurar su contraseña y entrar en el sistema.<br />Por favor de varios minutos al e-mail para recibirlo.<br />Si no recibe el e-mail, por favor revise su carpeta de spam.<br /><a href='index.php'>Volver a la página principal de entrada al sistema.</a>";

// Audit
$GLOBALS['strAdditionalItems'] = "e ítems adicionales";
$GLOBALS['strFor'] = "para";
$GLOBALS['strAdZoneAsscociation'] = "Asociación de Anuncio a Zona";
$GLOBALS['strBinaryData'] = "Datos binarios";
$GLOBALS['strAuditTrailDisabled'] = "Audit Trail ha sido deshabilitado por el administrador. No son grabados y mostrados más eventos en la lista de Audit Trail";
$GLOBALS['strAccount'] = "Cuenta";
$GLOBALS['strAccountUserAssociation'] = "Asociación de Cuenta de Usuario";
$GLOBALS['strImage'] = "Imagen";
$GLOBALS['strCampaignZoneAssociation'] = "Asociación de Zona de Campaña";
$GLOBALS['strAccountPreferenceAssociation'] = "Asociación de Preferencias de Cuenta";


// Widget - Audit
$GLOBALS['strAuditNoData'] = "No ha sido guardada ninguna actividad de usuario durante el espacio de tiempo que ha seleccionado.";
$GLOBALS['strAuditTrailSetup'] = "Configurar hoy Audit Trail";
$GLOBALS['strAuditTrailGoTo'] = "Ir a página de Audit Trail";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Audit Trail permite ver quién ha hecho qué. O dicho de otra manera, guarda todos los cambios en el sistema de {$PRODUCT_NAME}</li> <li>Si ve este mensaje, es porque no ha activado Audit Trail</li> <li>Interesado en aprender más? Lea la <a href='{$PRODUCT_DOCSURL}/settings/auditTrail' class='site-link' target='help' >documentación de Audit Trail</a></li>";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Ir a página de campañas";
$GLOBALS['strCampaignSetUp'] = "Registrar hoy una campaña";
$GLOBALS['strCampaignNoRecords'] = "<li>Las campañas permiten agrupar cualquier número de banners, de cualquier tamaño, que comparten ciertos requisitos</li><li>Ahorre tiempo agrupando banners en una campaña y sin tener que definir opciones de entrega para cada uno por separado</li><li>¡Lea la <a class='site-link' target='help' href='{$PRODUCT_DOCSURL}/inventory/advertisersAndCampaigns/campaigns'>documentación sobre Campañas</a>!</li>";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>No hay actividad para mostrar de la campaña.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "No se han encontrado campañas que empiecen o terminen en el espacio de tiempo que ha seleccionado";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>Para ver campañas que hayan empezado o terminado en el espacio de tiempos que ha seleccionado, Audit Trail debe estar activado</li>	<li>Está viendo este mensaje porque no activó Audit Trail</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Activar Audit Trail para empezar a ver Campañas";

$GLOBALS['strUnsavedChanges'] = "Tiene cambios no guardados en esta página, asegúrese de presionar \"Guardar Cambios\" cuando finalice";
$GLOBALS['strDeliveryLimitationsDisagree'] = "ADVERTENCIA: Las limitaciones del motor de entrega <strong>NO ESTÁ DE ACUERDO</strong> con las limitaciones que se muestran debajo<br />Por favor guarde los cambios y actualice las reglas del motor de entrega";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Algunos valores incorrectos de reportes de limitaciones de entrega:";

//confirmation messages

$GLOBALS['strAdvertiserHasBeenUpdated'] = "La zona <a href='%s'>%s</a> ha sido actualizada";
$GLOBALS['strAdvertisersHaveBeenDeleted'] = "El sitio web completo ha sido eliminado";

$GLOBALS['strTrackerHasBeenAdded'] = "La zona <a href='%s'>%s</a> ha sido actualizada";
$GLOBALS['strTrackerHasBeenUpdated'] = "La zona <a href='%s'>%s</a> ha sido actualizada";
$GLOBALS['strTrackersHaveBeenDeleted'] = "Todas las zonas seleccionadas han sido eliminadas";
$GLOBALS['strTrackerHasBeenDuplicated'] = "La zona <a href='%s'>%s</a> ha sido copiada como <a href='%s'>%s</a>";
$GLOBALS['strTrackerHasBeenMoved'] = "La zona <b>%s</b> ha sido movida al sitio <b>%s</b>";

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


$GLOBALS['strWebsiteHasBeenUpdated'] = "La zona <a href='%s'>%s</a> ha sido actualizada";
$GLOBALS['strWebsitesHaveBeenDeleted'] = "El sitio web completo ha sido eliminado";

$GLOBALS['strZoneHasBeenAdded'] = "La zona <a href='%s'>%s</a> ha sido actualizada";
$GLOBALS['strZoneHasBeenUpdated'] = "La zona <a href='%s'>%s</a> ha sido actualizada";
$GLOBALS['strZoneAdvancedHasBeenUpdated'] = "Las opciones avanzadas para la zona <a href='%s'>%s</a> han sido actualizadas";
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
$GLOBALS['strPreferencesHaveBeenUpdated'] = "Las preferencias han sido actualizadas";
$GLOBALS['strEmailChanged'] = "Su correo electrónico ha sido actualizado";
$GLOBALS['strPasswordChanged'] = "Su clave ha sido actualizada";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "<b>%s</b> ha sido actualizado";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "<b>%s</b> ha sido actualizado";


/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keyLinkUser'] = "Enlace del Usuario";

/* ------------------------------------------------------- */
/* Languages Names                                       */
/* ------------------------------------------------------- */

$GLOBALS['str_ar'] = "Árabe";
$GLOBALS['str_bg'] = "Búlgaro";
$GLOBALS['str_cs'] = "Checo";
$GLOBALS['str_cy'] = "Galés";
$GLOBALS['str_da'] = "Danés";
$GLOBALS['str_de'] = "Alemán";
$GLOBALS['str_el'] = "Griego";
$GLOBALS['str_en'] = "Inglés";
$GLOBALS['str_es'] = "Español";
$GLOBALS['str_fa'] = "Persa";
$GLOBALS['str_fr'] = "Francés";
$GLOBALS['str_he'] = "Hebreo";
$GLOBALS['str_hr'] = "Croata";
$GLOBALS['str_hu'] = "Húngaro";
$GLOBALS['str_id'] = "Indonesio";
$GLOBALS['str_it'] = "Italiano";
$GLOBALS['str_ja'] = "Japonés";
$GLOBALS['str_ko'] = "Coreano";
$GLOBALS['str_lt'] = "Lituano";
$GLOBALS['str_nb'] = "Bokmal Noruego";
$GLOBALS['str_nl'] = "Holandés";
$GLOBALS['str_pl'] = "Polaco";
$GLOBALS['str_ro'] = "Rumano";
$GLOBALS['str_ru'] = "Ruso";
$GLOBALS['str_sk'] = "Eslovaco";
$GLOBALS['str_sl'] = "Esloveno";
$GLOBALS['str_sv'] = "Sueco";
$GLOBALS['str_tr'] = "Turco";
$GLOBALS['str_uk'] = "Ucraniano";
?>
