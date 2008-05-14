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

// Installer translation strings
$GLOBALS['strInstall']					= "Instalación";
$GLOBALS['strChooseInstallLanguage']	= "Escoja un idioma para proceder con la instalación";
$GLOBALS['strLanguageSelection']		= "Selecci&oacute;n de idioma";
$GLOBALS['strDatabaseSettings']			= "Configuraci&oacute;n de base de datos";
$GLOBALS['strAdminSettings']			= "Configuración del Administrador";
$GLOBALS['strAdvancedSettings']			= "Configuraci&oacute;n avanzada";
$GLOBALS['strOtherSettings']			= "Otras configuraciones";

$GLOBALS['strWarning']					= "Advertencia";
$GLOBALS['strFatalError']				= "Ha ocurrido un error fatal";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname." ya se encuentra instalado en el sistema. Si desea configurarlo vaya a <a href='settings-index.php'>Configuración de Interface</a>";
$GLOBALS['strCouldNotConnectToDB']		= "No se puede conectar a la base de datos, por favor verifique la configuración especificada para la misma";
$GLOBALS['strCreateTableTestFailed']	= "El usuario especificado no tiene permisos suficientes para crear o actualizar la estructura de la base de datos, por favor contacte al administrador de la base de datos.";
$GLOBALS['strUpdateTableTestFailed']	= "El usuario especificado no tiene permisos suficientes para actualizar la estructura de la base de datos, por favor contacte al administrador de la base de datos.";
$GLOBALS['strTablePrefixInvalid']		= "El prefijo de tabla contiene caracteres inválidos";
$GLOBALS['strTableInUse']				= "La base de datos especificada ya se encuentra utilizada por ".$phpAds_productname.", por favor use un prefijo de tabla diferente, o lea el manual de instrucciones para actualizar.";
$GLOBALS['strMayNotFunction']			= "Antes de continuar por favor corrija estos potenciales problemas:";
$GLOBALS['strIgnoreWarnings']			= "Ignorar advertencias";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." requiere PHP 4.0 o mayor para funcionar correctamente. Ud. está usando {php_version}.";
$GLOBALS['strWarningRegisterGlobals']	= "Configuración PHP : la variable register_globals tiene que tener el valor on.";
$GLOBALS['strWarningMagicQuotesGPC']	= "Configuración PHP : la variable magic_quotes_gpc tiene que tener el valor on.";
$GLOBALS['strWarningMagicQuotesRuntime']= "Configuración PHP : la variable magic_quotes_runtime tiene que tener el valor off.";
$GLOBALS['strWarningFileUploads']		= "Configuración PHP : la variable file_uploads tiene que tener el valor on.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." ha detectado que su <b>config.inc.php</b> no tiene permiso de escritura por el server.<br /> Ud. no podrá proseguir si no cambia los permisos del archivo. <br />Lea la documentación suministrada si no sabe como hacerlo.";
$GLOBALS['strCantUpdateDB']  			= "No es posible actualizar la base de datos en este momento. si desea proceder, todos los bannes, estadísticas y anunciantes existentes serán borrados.";
$GLOBALS['strTableNames']				= "Nombre de Tablas";
$GLOBALS['strTablesPrefix']				= "Prefijo del nombre de las tablas";
$GLOBALS['strTablesType']				= "Tipo de tablas";

$GLOBALS['strInstallWelcome']			= "Bienvenido a ".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "Antes de poder usar ".$phpAds_productname." necesitará configurarlo y <br /> deberá crear la base de datos. Clickee en <b>Proceder</b> para continuar.";
$GLOBALS['strInstallSuccess']			= "Hacer clic en \'Continuar\' le identificar&aacute; en el adserver. <p><strong>Qu&eacute; es lo siguiente?</strong></p><div class=\'psub\'> \n<p><b>Ap&uacute;ntese a los avisos de actualizaci&oacute;n del producto</b><br> \n<a href=\'\"\".rtrim(OA_DOCUMENTATION_BASE_URL, \'/\') . \'/\' . rtrim(OA_DOCUMENTATION_PATH, \'/\') . \'/\'.OA_DOCUMENTATION_VERSION.\"\"/wizard/join\' target=\'_blank\'>Unirse a la lista de correo \"\".MAX_PRODUCT_NAME.\"\"</a> para avisos de actualizaci&oacute;n, alertas de seguridad y anuncios de nuevos productios. </p> \n<p><b>Sirviendo la primera campa&ntilde;a de anuncios</b><br> \nUse nuestra <a href=\'\"\".rtrim(OA_DOCUMENTATION_BASE_URL, \'/\') . \'/\' . rtrim(OA_DOCUMENTATION_PATH, \'/\') . \'/\'.OA_DOCUMENTATION_VERSION.\"\"/wizard/qsg-firstcampaign\' target=\'_blank\'>gu&iacute;a de inicio r&aacute;pido a servir la primera campa&ntilde;a</a>. \n</p> \n</div> \n<p><strong>Pasos de instalaci&oacute;n opcionales</strong></p> \n<div class=\'psub\'> \n<p><b>Bloquee los archivos de configuraci&oacute;n</b><br> \nEste es un buen paso extra de seguridad para proteger las opciones de configuraci&oacute;n de su adserver de modificaciones. <a href=\'\"\".rtrim(OA_DOCUMENTATION_BASE_URL, \'/\') . \'/\' . rtrim(OA_DOCUMENTATION_PATH, \'/\') . \'/\'.OA_DOCUMENTATION_VERSION.\"\"/wizard/lock-config\' target=\'_blank\'>Leer m&aacute;s</a>. \n</p> \n<p><b>Creando una tarea regular de mantenimiento</b><br> \nSe recomienda un script de mantenimiento para asegurar el correcto funcionamiento de los reportes y la eficiencia de entrega mejor posible. <a href=\'\"\".rtrim(OA_DOCUMENTATION_BASE_URL, \'/\') . \'/\' . rtrim(OA_DOCUMENTATION_PATH, \'/\') . \'/\'.OA_DOCUMENTATION_VERSION.\"\"/wizard/setup-cron\' target=\'_blank\'>Leer m&aacute;s</a> \n</p> \n<p><b>Revise las opciones de configuraci&oacute;n del sistema</b><br> \nAntes de empezar a usar \"\".MAX_PRODUCT_NAME.\"\" le sugerimos que revise sus opciones de configuraci&oacute;n en la pesta;a de Configuraci&oacute;n. \n</p> \n</div>\"";
$GLOBALS['strUpdateSuccess']			= "<b>La actualización de ".$phpAds_productname." ha sido completada.</b><br /><br />Para que ".$phpAds_productname." funcione correctamente deberá\n										   asegurarse de que el archivo de mantenimiento sea ejecutado cada hora.Para mayor infromación sobre este tema, lea la documentación.\n										   <br /><br />Clickee en <b>Proceder</b> para dirigirse a la página de configuración, donde podrá establecer otras configuraciones.\n										Por favor no bloquee el archivo config.inc.php cuando termine.";
$GLOBALS['strInstallNotSuccessful']		= " <b>La instalaci&oacute;n de \".MAX_PRODUCT_NAME.\" no ha concluido satisfactoriamente</b><br /><br />Algunas partes del proceso de instalaci&oacute;n no se han podido completar.\n                                                Es posible que esos problemas no sean s&oacute;lo temporales, en ese caso puede simplemente hacer clic en <b>Proceder</b> y volver al primer paso del proceso de instalaci&oacute;n. Si quiere saber m&aacute;s sobre lo que significa el mensaje de abajo y c&oacute;mo solucionarlo, por favor, consulte la documentaci&oacute;n disponible";
$GLOBALS['strErrorOccured']				= "Ha ocurrido el siguiente error:";
$GLOBALS['strErrorInstallDatabase']		= "No se puede crear la estructura de la base de datos.";
$GLOBALS['strErrorUpgrade'] = 'The existing installation\'s database could not be upgraded.';
$GLOBALS['strErrorInstallConfig']		= "El archivo de configuración o la base de datos no pudieron ser actualizados.";
$GLOBALS['strErrorInstallDbConnect']	= "No fue posible conectarse con la base de datos.";

$GLOBALS['strUrlPrefix']				= "Prefijo URL";

$GLOBALS['strProceed']					= "Proceder >";
$GLOBALS['strRepeatPassword']			= "Repetir contrase&ntilde;a";
$GLOBALS['strNotSamePasswords']			= "Las contrase&ntilde;as facilitadas no concuerdan";
$GLOBALS['strInvalidUserPwd']			= "Nombre de usuario o password incorrecto.";

$GLOBALS['strUpgrade']					= "Actualización";
$GLOBALS['strSystemUpToDate']			= "Su sistema se encuentra actualizado. <br />Clickee en<b>Proceder</b> para regresar a la página de inicio.";
$GLOBALS['strSystemNeedsUpgrade']		= "La estructura de la base de datos y el archivo de configuración deberán actualizarse para funcionar correctamente. Clickee en <b>Proceder</b> para comenzar el proceso de actualización. <br />Por favor tenga paciencia, la actualización puede tardar algunos minutos.";
$GLOBALS['strSystemUpgradeBusy']		= "Actualización del sistema en progreso, por favor espere...";
$GLOBALS['strSystemRebuildingCache']	= "Reconstruyendo cache, por favor espere...";
$GLOBALS['strServiceUnavalable']		= "El sistema no se encuentra disponible temporariamente. Se encuentra en proceso de actualización.";

$GLOBALS['strConfigNotWritable']		= "Su archivo config.inc.php no puede escribirse.";





/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']			= "Elija la Sección";
$GLOBALS['strDayFullNames'][0] = "Domingo";
$GLOBALS['strDayFullNames'][1] = "Lunes";
$GLOBALS['strDayFullNames'][2] = "Martes";
$GLOBALS['strDayFullNames'][3] = "Mi&eacute;rcoles";
$GLOBALS['strDayFullNames'][4] = "Jueves";
$GLOBALS['strDayFullNames'][5] = "Viernes";
$GLOBALS['strDayFullNames'][6] = "S&aacute;bado";

$GLOBALS['strEditConfigNotPossible']    = "No es posible editar esta configuraci&oacute;n debido a que el archivo de configuraci&oacute;n se encuentra bloqueado por razones de seguridad.<br /> Si desea hacer cambios, deber&aacute; desbloquear primero el archivo config.inc.php.";
$GLOBALS['strEditConfigPossible']		= "Es posible editar las configuraciones ya que el archivo de configuraciones no est&aacute; bloqueado, pero esto puede transformarse en un problema de seguridad.<br /> Si quiere asegurar su sistema, necesita bloquear el archivoconfig.inc.php.";



// Database
$GLOBALS['strDatabaseSettings']			= "Configuración de Base de Datos";
$GLOBALS['strDatabaseServer']			= "Opciones globales del servidor de base de datos";
$GLOBALS['strDbHost']					= "Nombre de host de la base de datos";
$GLOBALS['strDbUser']					= "Nombre de usuario de la base de datos";
$GLOBALS['strDbPassword']				= "Contrase&ntilde;a de la base de datos";
$GLOBALS['strDbName']					= "Nombre de la base de datos";

$GLOBALS['strDatabaseOptimalisations']	= "Opciones de optimizaci&oacute;n de la base de datos";
$GLOBALS['strPersistentConnections']	= "Usar conexiones persistentes";
$GLOBALS['strCompatibilityMode']		= "Usar modo de compatibilidad de base de datos";
$GLOBALS['strCantConnectToDb']			= "No se puede conectar a la base de datos";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']	= "Opciones de invocaci&oacute;n";

$GLOBALS['strAllowedInvocationTypes']	= "Tipos de invocaci&oacute;n permitidos";
$GLOBALS['strAllowRemoteInvocation']	= "Permitir Invocación Remota";
$GLOBALS['strAllowRemoteJavascript']	= "Permitir Invocación Remota para JavaScriptAllow";
$GLOBALS['strAllowRemoteFrames']		= "Permitir Invocación Remota para Frames";
$GLOBALS['strAllowRemoteXMLRPC']		= "Permitir Invocación Remota usando XML-RPC";
$GLOBALS['strAllowLocalmode']			= "Permitir modo Local";
$GLOBALS['strAllowInterstitial']		= "Permitir Interstitials";
$GLOBALS['strAllowPopups']				= "Permitir Popups";

$GLOBALS['strKeywordRetrieval']			= "Recuperación de Palabra Clave";
$GLOBALS['strBannerRetrieval']			= "Metodo de Recuperación de Banner";
$GLOBALS['strRetrieveRandom']			= "Randomización de Recuperación de banner (predeterminado)";
$GLOBALS['strRetrieveNormalSeq']		= "Recuperación secuencial de banner normal";
$GLOBALS['strWeightSeq']				= "Recuperación secuencial de banner basada en peso";
$GLOBALS['strFullSeq']					= "Recuperación secuencial de banner completa";
$GLOBALS['strUseConditionalKeys']		= "Usar palabra clave condicionales";
$GLOBALS['strUseMultipleKeys']			= "Usar multiples palabras claves";
$GLOBALS['strUseAcl']					= "Usar limitaciones de exposición";

$GLOBALS['strZonesSettings']			= "Recuperación de Zonas";
$GLOBALS['strZoneCache']				= "Cache de zonas, esto debería acelerar los procesos en zonas";
$GLOBALS['strZoneCacheLimit']			= "Tiempo entre actualizaciones de cache (en segundos)";
$GLOBALS['strZoneCacheLimitErr']		= "El tiempo entre actualizaciones de cache debe ser un número entero positivo";

$GLOBALS['strP3PSettings']				= "Políticas de Privacidad P3P";
$GLOBALS['strUseP3P']					= "Usar Politicas P3P";
$GLOBALS['strP3PCompactPolicy']			= "Politica Compacta P3P";
$GLOBALS['strP3PPolicyLocation']		= "Ubicación de Politica P3P";



// Banner Settings
$GLOBALS['strBannerSettings']			= "Opciones del banner";

$GLOBALS['strAllowedBannerTypes']		= "Tipos de banners permitidos";
$GLOBALS['strTypeSqlAllow']				= "Permitir banners locales (SQL)";
$GLOBALS['strTypeWebAllow']				= "Permitir banners locales (Webserver)";
$GLOBALS['strTypeUrlAllow']				= "Permitir banners externos";
$GLOBALS['strTypeHtmlAllow']			= "Permitir HTML banners";
$GLOBALS['strTypeTxtAllow']				= "Permitir textos";

$GLOBALS['strTypeWebSettings']			= "Configuración de banner local (Webserver)";
$GLOBALS['strTypeWebMode']				= "M&eacute;todo de almacenamiento";
$GLOBALS['strTypeWebModeLocal']			= "Directorio local";
$GLOBALS['strTypeWebModeFtp']			= "Servidor FTP externo";
$GLOBALS['strTypeWebDir']				= "Directorio local";
$GLOBALS['strTypeWebFtp']				= "Modo FTP";
$GLOBALS['strTypeWebUrl']				= "URL pública";
$GLOBALS['strTypeWebSslUrl']			= "URL pública (SSL)";
$GLOBALS['strTypeFTPHost']				= "Host FTP";
$GLOBALS['strTypeFTPDirectory']			= "Directorio del host";
$GLOBALS['strTypeFTPUsername']			= "Inicio de sesi&oacute;n";
$GLOBALS['strTypeFTPPassword']			= "Contrase&ntilde;a";

$GLOBALS['strDefaultBanners']			= "Banners predeterminados";
$GLOBALS['strDefaultBannerUrl']			= "URL de imagen predeterminada";
$GLOBALS['strDefaultBannerTarget']		= "URL de destino predeterminada";

$GLOBALS['strTypeHtmlSettings']			= "Opciones de banners HTML";
$GLOBALS['strTypeHtmlAuto']				= "Alterar banners HTML autom&aacute;ticamente para forzar el seguimiento de clics";
$GLOBALS['strTypeHtmlPhp']				= "Permitir ejecutar expresiones PHP desde dentro de un banner";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Configuración de Estadísticas";

$GLOBALS['strStatisticsFormat']			= "Formato de Estadísticas";
$GLOBALS['strLogBeacon']				= "Usar beacons para loguear las Impresiones";
$GLOBALS['strCompactStats']				= "Usar estadísticas Compactas";
$GLOBALS['strLogAdviews']				= "Loguear Impresiones";
$GLOBALS['strBlockAdviews']				= "Protección contra logueo múltiple de Impresiones (segs.)";
$GLOBALS['strLogAdclicks']				= "Loguear Clicks";
$GLOBALS['strBlockAdclicks']			= "Protección contra logueo múltiple de Clicks (segs.)";

$GLOBALS['strEmailWarnings']			= "Alertas v&iacute;a E-mail";
$GLOBALS['strAdminEmailHeaders']		= "A&ntilde;adir las siguientes cabeceras a cada e-mail enviado por ' . ";
$GLOBALS['strWarnLimit']				= "Enviar un aviso cuando el n&uacute;mero de impresiones restantes sea menos que el especificado aqu&iacute;";
$GLOBALS['strWarnLimitErr']				= "El l&iacute;mite de aviso debe ser un entero positivo";
$GLOBALS['strWarnAdmin']				= "Enviar un aviso al administrador cada vez que una campa&ntilde;a vaya a expirar";
$GLOBALS['strWarnClient']				= "Enviar un aviso al anunciante cada vez que una campa&ntilde;a vaya a expirar";
$GLOBALS['strQmailPatch']				= "parche qmail";

$GLOBALS['strRemoteHosts']				= "Hosts remotos";
$GLOBALS['strIgnoreHosts']				= "No guardar estad&iacute;sticas para visitantes que usan alguna de las siguientes Ips o hostnames:";
$GLOBALS['strReverseLookup']			= "Hacer un reverse lookup de los hostnames de los visitantes cuando no se facilite";
$GLOBALS['strProxyLookup']				= "Intentar determinar la direcci&oacute;n IP real de los visitantes tras un servidor proxy";

$GLOBALS['strAutoCleanTables']			= "Auto-depurar la base de datos";
$GLOBALS['strAutoCleanEnable']			= "Habilitar Auto-depuración";
$GLOBALS['strAutoCleanWeeks']			= "Guardar logs y estadísticas ed las últimas (semanas)";
$GLOBALS['strAutoCleanErr']				= "El tiempo mínimo es de 2 semanas";
$GLOBALS['strAutoCleanVacuum']			= "VACUUM ANALYZE tables every night"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']	= "Opciones de administrador";

$GLOBALS['strLoginCredentials']			= "Credenciales de inicio de sesi&oacute;n";
$GLOBALS['strAdminUsername']			= "Nombre de usuario del administrador";
$GLOBALS['strOldPassword']				= "Contrase&ntilde;a antigua";
$GLOBALS['strNewPassword']				= "Contrase&ntilde;a nueva";
$GLOBALS['strInvalidUsername']			= "Nombre de usuario incorrecto";
$GLOBALS['strInvalidPassword']			= "La nueva contrase&ntilde;a no es v&aacute;lida, por favor, use una contrase&ntilde;a diferente.";

$GLOBALS['strBasicInformation']			= "información Básica";
$GLOBALS['strAdminFullName']			= "Nombre completo del admin";
$GLOBALS['strAdminEmail']				= "Direcci&oacute;n e-mail del admin";
$GLOBALS['strCompanyName']				= "Nombre de la compa&ntilde;&iacute;a";

$GLOBALS['strAdminCheckUpdates']		= "Buscar actualizaciones";
$GLOBALS['strAdminCheckEveryLogin']		= "En cada logueo";
$GLOBALS['strAdminCheckDaily']			= "A diario";
$GLOBALS['strAdminCheckWeekly']			= "Semanalmente";
$GLOBALS['strAdminCheckMonthly']		= "Mensualmente";
$GLOBALS['strAdminCheckNever']			= "Nunca";

$GLOBALS['strAdminNovice']				= "Pedir confirmación ante acciones de borrado del Administrador";
$GLOBALS['strUserlogEmail']				= "Grabar todos los e-mails salientes";
$GLOBALS['strUserlogPriority']			= "Loguear cálculos de priorida horaria";
$GLOBALS['strUserlogAutoClean']			= "Loguear depuraciones automáticas de la base de datos";


// User interface settings
$GLOBALS['strGuiSettings']				= "Opciones de la interfaz de usuario";

$GLOBALS['strGeneralSettings']			= "Configuración General";
$GLOBALS['strAppName']					= "Nombre de la aplicaci&oacute;n";
$GLOBALS['strMyHeader']					= "Ubicaci&oacute;n del archivo header";
$GLOBALS['strMyFooter']					= "Ubicaci&oacute;n del archivo footer";
$GLOBALS['strGzipContentCompression']	= "Usar GZIP para compresión de contenido";

$GLOBALS['strClientInterface']			= "Interfaz del anunciante";
$GLOBALS['strClientWelcomeEnabled']		= "Habilitar mensaje de bienvenida para el anunciante";
$GLOBALS['strClientWelcomeText']		= "Texto de bienvenida<br />(c&oacute;digo HTML permitido)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Opciones por defecto del interfaz";

$GLOBALS['strInventory']				= "Inventario";
$GLOBALS['strShowCampaignInfo']			= "Mostrar información extra de la campaña en la página <i>Resumen de Campaña</i>";
$GLOBALS['strShowBannerInfo']			= "Mostrar información extra del banner en la página <i>Resumen de Banner</i>";
$GLOBALS['strShowCampaignPreview']		= "Mostrar vista previa de todos los banners en la página <i>resumen de Banner</i>";
$GLOBALS['strShowBannerHTML']			= "Mostrar banner actual en lugar del código HTML plano para la vista previa de Banners HTML";
$GLOBALS['strShowBannerPreview']		= "Mostrar la vista previa del banner al principio de las páginas correspondientes al banner";
$GLOBALS['strHideInactive']				= "Ocultar elementos inactivos de todas las p&aacute;ginas de resumen";
$GLOBALS['strGUIShowMatchingBanners']	= "Mostrar banners relacionados en la página <i>Banner Relacionado</i>";
$GLOBALS['strGUIShowParentCampaigns']	= "Mostrar campaña principal en la páginae <i>Banner Relacionado</i>";
$GLOBALS['strGUILinkCompactLimit']		= "Ocultar campañas o banners no relacionadas en la página <i>Banner Relacionado</i> cuando hayan mas de";

$GLOBALS['strStatisticsDefaults'] 		= "Estadísticas";
$GLOBALS['strBeginOfWeek']				= "Comienzo de la semana";
$GLOBALS['strPercentageDecimals']		= "Cantidad de decimales en los porcentajes";

$GLOBALS['strWeightDefaults']			= "Peso predeterminado";
$GLOBALS['strDefaultBannerWeight']		= "Peso predeterminado del banner";
$GLOBALS['strDefaultCampaignWeight']	= "Peso predeterminado de la campaña";
$GLOBALS['strDefaultBannerWErr']		= "El peso predetermindado del banner debe ser un número entero positivo";
$GLOBALS['strDefaultCampaignWErr']		= "El peso predeterminado de la campaña debe ser un número entero positivo";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "Table Border Color";
$GLOBALS['strTableBackColor']			= "Table Back Color";
$GLOBALS['strTableBackColorAlt']		= "Table Back Color (Alternative)";
$GLOBALS['strMainBackColor']			= "Main Back Color";
$GLOBALS['strOverrideGD']				= "Override GD Imageformat";
$GLOBALS['strTimeZone']					= "Time Zone";



// Note: new translatiosn not found in original lang files but found in CSV
$GLOBALS['strAdminAccount'] = "Cuenta de Administrador";
$GLOBALS['strSpecifySyncSettings'] = "Opciones de sincronizaci&oacute;n";
$GLOBALS['strOpenadsIdYour'] = "Su Openads ID";
$GLOBALS['strOpenadsIdSettings'] = "Opciones de Openads ID";
$GLOBALS['strBtnContinue'] = "Continuar &raquo;";
$GLOBALS['strBtnRecover'] = "Recuperar &raquo;";
$GLOBALS['strBtnStartAgain'] = "Empezar actualizaci&oacute;n de nuevo &raquo;";
$GLOBALS['strBtnGoBack'] = "&laquo; Volver";
$GLOBALS['strBtnAgree'] = "Acepto &raquo;";
$GLOBALS['strBtnDontAgree'] = "&laquo; No acepto";
$GLOBALS['strBtnRetry'] = "Reintentar";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Por favor, corrija todos los errores antes de continuar.";
$GLOBALS['strWarningRegisterArgcArv'] = "La variable de configuraci&oacute;n de PHP register_argc_argv necesita estar activa para ejecutar el mantenimiento desde la l&iacute;nea de comandos.";
$GLOBALS['strInstallIntro'] = "Gracias por usar <a href=\'http://\".MAX_PRODUCT_URL.\"\' target=\'_blank\'><strong>\".MAX_PRODUCT_NAME.\"</strong></a>. \\n<p>Este asistente le guiar&aacute; en el proceso de instalaci&oacute;n / actualizaci&oacute;n del servidor de publicidad \".MAX_PRODUCT_NAME.\".</p> \\n<p>Para ayudarle con el proceso de instalaci&oacute;n hemos creado una <a href=\'\".rtrim(OA_DOCUMENTATION_BASE_URL, \'/\') . \'/\' . rtrim(OA_DOCUMENTATION_PATH, \'/\') . \'/\'.OA_DOCUMENTATION_VERSION.\"/wizard/qsg-install\' target=\'_blank\'>Gu&iacute;a de instalaci&oacute;n r&aacute;pida</a> para iniciarle en el proceso de puesta en marcha. Para una gu&iacute;a m&aacute;s detallada de la instalaci&oacute;n y configuraci&oacute;n de \".MAX_PRODUCT_NAME.\" visite la \\n<a href=\'\".rtrim(OA_DOCUMENTATION_BASE_URL, \'/\') . \'/\' . rtrim(OA_DOCUMENTATION_PATH, \'/\') . \'/\'.OA_DOCUMENTATION_VERSION.\"/wizard/admin-guide\' target=\'_blank\'>Gu&iacute;a del Administrador</a>.";
$GLOBALS['strRecoveryRequiredTitle'] = "El intento de actualizaci&oacute;n ha encontrado errores";
$GLOBALS['strRecoveryRequired'] = "Ha ocurrido un error al procesar la actualizaci&oacute;n anterior y Openads necesita intentar recuperar el proceso de actualizaci&oacute;n. Por favor, haga clic en el bot&oacute;n Recuperar.";
$GLOBALS['strTermsTitle'] = "Informaci&oacute;n de la licencia del software";
$GLOBALS['strPolicyTitle'] = "Pol&iacute;tica de privacidad y uso de datos";
$GLOBALS['strPolicyIntro'] = "Nuestro uso de datos y nuestra pol&iacute;tica de privacidad define c&oacute;mo \".MAX_PRODUCT_NAME.\" protege su privacidad. Por favor, revise la Pol&iacute;tica de privacidad y uso de datos antes de aceptar continuar con la instalaci&oacute;n.";
$GLOBALS['strDbSetupTitle'] = "Configuraci&oacute;n de la base de datos";
$GLOBALS['strDbUpgradeIntro'] = "A continuaci&oacute;n se muestran los detalles detectados de su base de datos para la instalaci&oacute;n de \"\" . MAX_PRODUCT_NAME . \"\". Por favor, compruebe que los valores sean correctos. <p>El siguiente paso actualizar&aacute; su base de datos. Haga clic en \'Continuar\' para actualizar su sistema</p>";
$GLOBALS['strOaUpToDate'] = "Su base de datos Openads y estructura de archivos est&aacute;n usando la versi&oacute;n m&aacute;s reciente, por lo tanto no hace falta realizar una actualizaci&oacute;n en este momento. Por favor, haga clic en Continuar para proceder al panel de administraci&oacute;n de Openads.";
$GLOBALS['strOaUpToDateCantRemove'] = "Aviso: el archivo de ACTUALIZACI&Oacute;N sigue presente en el directorio var. No podemos borrar dicho archivo debido a permisos insuficientes. Por favor, borre este archivo usted mismo.";
$GLOBALS['strRemoveUpgradeFile'] = "Debe borrar el archivo de ACTUALIZACI&Oacute;N del directorio var.";
$GLOBALS['strDbSuccessIntro'] = "<p><strong>Mantenimiento</strong><br>";
$GLOBALS['strDbSuccessIntroUpgrade'] = "Su sistema ha sido actualizado correctamente. Las siguientes pantallas le ayudar&aacute;n a actualizar la configuraci&oacute;n de su nuevo adserver.";
$GLOBALS['strErrorFixPermissionsCommand'] = "<p><strong>Seguridad</strong><br>";
$GLOBALS['strErrorWritePermissionsWin'] = "La isntalaci&oacute;n de Openads necesita que el archivo de configuraci&oacute;n se pueda modificar. Al finalizar las modificaciones de configuraci&oacute;n, es altamente recomendable mantener un simple acceso de lectura a este archivo, para mayor seguridad. Para m&aacute;s informaci&oacute;n sobre esto, por favor lea la referencia en la <a href='http://MAX_PRODUCT_DOCSURL' target='_blank'><strong>documentaci&oacute;n</strong></a>.</p>";
$GLOBALS['strCheckDocumentation'] = "Para m&aacute;s ayuda, por favor lea la <a href=\\\"http://\"\".OA_DOCUMENTATION_BASE_URL.\"\"\\\"\">documentaci&oacute;n de Openads<a/>.\"";
$GLOBALS['strAdminUrlPrefix'] = "<p>Ahora ya est&aacute; listo para empezar a usar Openads. Haga clic en Continuar para acceder a esta nueva/actualizada versi&oacute;n.</p>";
$GLOBALS['strDeliveryUrlPrefix'] = "<p>Antes de empezar a usar Openads, sugerimos que se tome un tiempo para revisar las opciones de configuraci&oacute;n que se encuentran en la pesta&ntilde;a de \"\"Opciones\"\". </p>";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL motor de entrega (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL de almacenamiento de imagen";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL de almacenamiento de imagen (SSL)";
$GLOBALS['strTimezone'] = "Zona horaria";
$GLOBALS['strTimezoneEstimated'] = "Zona horaria estimada";
$GLOBALS['strTimezoneGuessedValue'] = "La zona horaria del servidor no est&aacute; correctamente configurada en PHP";
$GLOBALS['strTimezoneSeeDocs'] = "Por favor, lea los %DOCS% acerca de configurar esta variable para PHP.";
$GLOBALS['strTimezoneDocumentation'] = "documentaci&oacute;n";
$GLOBALS['strLoginSettingsTitle'] = "Inicio de sesi&oacute;n de administrador";
$GLOBALS['strLoginSettingsIntro'] = "Para poder continuar con el proceso de actualizaci&oacute;n, por favor introduzca los detalles de su cuenta de administrador de ".MAX_PRODUCT_NAME.".. Debe iniciar la sesi&oacute;n como administrador para continuar con el proceso de actualizaci&oacute;n.";
$GLOBALS['strAdminSettingsTitle'] = "Crear cuenta de administrador";
$GLOBALS['strAdminSettingsIntro'] = "Por favor, complete este formulario para crear su cuenta de administraci&oacute;n del adserver.";
$GLOBALS['strEnableAutoMaintenance'] = "Ejecutar autom&aacute;ticamente el mantenimiento durante la entrega si el mantenimiento programado no est&aacute; activo";
$GLOBALS['strDbSetupIntro'] = "Por favor introduzca los detalles para conectar a su base de datos. Si no est&aacute; seguro acerca de los detalles, por favor contacte con su administrador de sistemas. <p>El pr&oacute;ximo paso pondr&aacute; a punto su base de datos. Haga clic en 'continuar' para proceder.</p>";
$GLOBALS['strSystemCheckIntro'] = "El asistente de instalaci&oacute;n est&aacute; comprobando la configuraci&oacute;n de su servidor web para asegurar que el proceso de instalaci&oacute;n se puede completar satisfactoriamente. <p>Por favor compruebe los problemas marcados para completar el proceso de instalaci&oacute;n.</p>";
$GLOBALS['strConfigSettingsIntro'] = "Por favor compruebe la siguiente configuraci&oacute;n y realice los cambios necesarios antes de continuar.";
?>