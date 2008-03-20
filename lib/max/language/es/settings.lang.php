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
$GLOBALS['strLanguageSelection']		= "Selección del Idioma";
$GLOBALS['strDatabaseSettings']			= "Configuración de la Base de Datos";
$GLOBALS['strAdminSettings']			= "Configuración del Administrador";
$GLOBALS['strAdvancedSettings']			= "Configuración Avanzada";
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
$GLOBALS['strTablesPrefix']				= "Prefijo de Nombre de Tablas";
$GLOBALS['strTablesType']				= "Tipo de Tablas";

$GLOBALS['strInstallWelcome']			= "Bienvenido a ".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "Antes de poder usar ".$phpAds_productname." necesitará configurarlo y <br /> deberá crear la base de datos. Clickee en <b>Proceder</b> para continuar.";
$GLOBALS['strInstallSuccess']			= "<b>La instalación de ".$phpAds_productname." se encuentra completa.</b><br /><br />Para que ".$phpAds_productname." funcione correctamente, deberá asegurarse
										que el archivo de mantenimiento sea ejecutado cada hora. Para mayor infromación sobre este tema, lea la documentación.
										<br /><br />Clickee en <b>Proceder</b> para dirigirse a la página de configuración, donde podrá establecer otras configuraciones.
										Por favor no bloquee el archivo config.inc.php cuando termine.";
$GLOBALS['strUpdateSuccess']			= "<b>La actualización de ".$phpAds_productname." ha sido completada.</b><br /><br />Para que ".$phpAds_productname." funcione correctamente deberá
										   asegurarse de que el archivo de mantenimiento sea ejecutado cada hora.Para mayor infromación sobre este tema, lea la documentación.
										   <br /><br />Clickee en <b>Proceder</b> para dirigirse a la página de configuración, donde podrá establecer otras configuraciones.
										Por favor no bloquee el archivo config.inc.php cuando termine.";
$GLOBALS['strInstallNotSuccessful']		= "<b>La instalación de ".$phpAds_productname." no ha finalizado</b><br /><br />Algunos puntos durante la instalación no pudieron ser completados.
										   Es posible que estos problemas sean solamente temporarios, en este caso simplemente clickee en <b>Proceder</b> y vuelva al
										   primer paso del proceso de instalación. Si desea saber más sobre sobre los mensajes de error y como resolverlos, 
										   consulte la documentación suministrada.";
$GLOBALS['strErrorOccured']				= "Ha ocurrido el siguiente error:";
$GLOBALS['strErrorInstallDatabase']		= "No se puede crear la estructura de la base de datos.";
$GLOBALS['strErrorUpgrade'] = 'The existing installation\'s database could not be upgraded.';
$GLOBALS['strErrorInstallConfig']		= "El archivo de configuración o la base de datos no pudieron ser actualizados.";
$GLOBALS['strErrorInstallDbConnect']	= "No fue posible conectarse con la base de datos.";

$GLOBALS['strUrlPrefix']				= "Prefijo URL";

$GLOBALS['strProceed']					= "Proceder >";
$GLOBALS['strRepeatPassword']			= "Repetir Password";
$GLOBALS['strNotSamePasswords']			= "Los passwords no concuerdan";
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
$GLOBALS['strDayFullNames'] 			= array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
$GLOBALS['strEditConfigNotPossible']    = "No es posible editar esta configuración debido a que el archivo de configuración se encuentra bloqueado por razones de seguridad.<br /> ".
										  "Si desea hacer cambios, deberá desbloquear primero el archivo config.inc.php.";
$GLOBALS['strEditConfigPossible']		= "Es posible editar las configuraciones ya que el archivo de configuraciones no está bloqueado, pero esto puede transformarse en un problema de seguridad.<br /> ".
										  "Si quiere asegurar su sistema, necesita bloquear el archivoconfig.inc.php.";



// Database
$GLOBALS['strDatabaseSettings']			= "Configuración de Base de Datos";
$GLOBALS['strDatabaseServer']			= "Servidor de Base de Datos";
$GLOBALS['strDbHost']					= "Nombre de host de la base de datos";
$GLOBALS['strDbUser']					= "Nombre de usuario de la base de datos";
$GLOBALS['strDbPassword']				= "Password de la base de datos";
$GLOBALS['strDbName']					= "Nombre de la base de datos";

$GLOBALS['strDatabaseOptimalisations']	= "Optimización de la base de datos";
$GLOBALS['strPersistentConnections']	= "Usar conexiones persistentes";
$GLOBALS['strCompatibilityMode']		= "Usar modo de compatibilidad de base de datos";
$GLOBALS['strCantConnectToDb']			= "No se puede conectar a la base de datos";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']	= "Configuración de Invocación y envío";

$GLOBALS['strAllowedInvocationTypes']	= "Tipos de Invocación Permitidos";
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
$GLOBALS['strBannerSettings']			= "Configuración de Banner";

$GLOBALS['strAllowedBannerTypes']		= "Tipos de banner permitidos";
$GLOBALS['strTypeSqlAllow']				= "Permitir banners locales (SQL)";
$GLOBALS['strTypeWebAllow']				= "Permitir banners locales (Webserver)";
$GLOBALS['strTypeUrlAllow']				= "Permitir banners externos";
$GLOBALS['strTypeHtmlAllow']			= "Permitir HTML banners";
$GLOBALS['strTypeTxtAllow']				= "Permitir Textos";

$GLOBALS['strTypeWebSettings']			= "Configuración de banner local (Webserver)";
$GLOBALS['strTypeWebMode']				= "Metodo de almacenamiento";
$GLOBALS['strTypeWebModeLocal']			= "Directorio Local";
$GLOBALS['strTypeWebModeFtp']			= "Servidor FTP externo";
$GLOBALS['strTypeWebDir']				= "Directorio Local";
$GLOBALS['strTypeWebFtp']				= "Modo FTP";
$GLOBALS['strTypeWebUrl']				= "URL pública";
$GLOBALS['strTypeWebSslUrl']			= "URL pública (SSL)";
$GLOBALS['strTypeFTPHost']				= "Host FTP";
$GLOBALS['strTypeFTPDirectory']			= "Directory del host";
$GLOBALS['strTypeFTPUsername']			= "Login";
$GLOBALS['strTypeFTPPassword']			= "Password";

$GLOBALS['strDefaultBanners']			= "Banners predefinidos";
$GLOBALS['strDefaultBannerUrl']			= "URL de imagen predeterminada";
$GLOBALS['strDefaultBannerTarget']		= "URL de destino predeterminada";

$GLOBALS['strTypeHtmlSettings']			= "Opciones de Banners HTML";
$GLOBALS['strTypeHtmlAuto']				= "Alterar banners HTML automaticamente para forzar el seguimiento de Clicks";
$GLOBALS['strTypeHtmlPhp']				= "Permitir ejecutar expresiones PHP desde un banner HTML";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Configuración de Estadísticas";

$GLOBALS['strStatisticsFormat']			= "Formato de Estadísticas";
$GLOBALS['strLogBeacon']				= "Usar beacons para loguear las Impresiones";
$GLOBALS['strCompactStats']				= "Usar estadísticas Compactas";
$GLOBALS['strLogAdviews']				= "Loguear Impresiones";
$GLOBALS['strBlockAdviews']				= "Protección contra logueo múltiple de Impresiones (segs.)";
$GLOBALS['strLogAdclicks']				= "Loguear Clicks";
$GLOBALS['strBlockAdclicks']			= "Protección contra logueo múltiple de Clicks (segs.)";

$GLOBALS['strEmailWarnings']			= "Alertas via E-mail";
$GLOBALS['strAdminEmailHeaders']		= "Encabezados de Mail para reflejar el Remitente del envio diario de reportes";
$GLOBALS['strWarnLimit']				= "Advertir Límites";
$GLOBALS['strWarnLimitErr']				= "Advertencia de Límites debe ser un número entero positivo";
$GLOBALS['strWarnAdmin']				= "Adveritr al Administrador";
$GLOBALS['strWarnClient']				= "Advertir al Auspiciante";
$GLOBALS['strQmailPatch']				= "Habilitar parche para qmail";

$GLOBALS['strRemoteHosts']				= "Hosts remotos";
$GLOBALS['strIgnoreHosts']				= "Ignorar Hosts";
$GLOBALS['strReverseLookup']			= "Reverse DNS Lookup";
$GLOBALS['strProxyLookup']				= "Proxy Lookup";

$GLOBALS['strAutoCleanTables']			= "Auto-depurar la base de datos";
$GLOBALS['strAutoCleanEnable']			= "Habilitar Auto-depuración";
$GLOBALS['strAutoCleanWeeks']			= "Guardar logs y estadísticas ed las últimas (semanas)";
$GLOBALS['strAutoCleanErr']				= "El tiempo mínimo es de 2 semanas";
$GLOBALS['strAutoCleanVacuum']			= "VACUUM ANALYZE tables every night"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']	= "Configuración de Administrador";

$GLOBALS['strLoginCredentials']			= "Credenciales de Login";
$GLOBALS['strAdminUsername']			= "Nombre de Usuario del Administrador";
$GLOBALS['strOldPassword']				= "Password Anterior";
$GLOBALS['strNewPassword']				= "Nuevo Password";
$GLOBALS['strInvalidUsername']			= "usuario incorrecto";
$GLOBALS['strInvalidPassword']			= "password incorrecto";

$GLOBALS['strBasicInformation']			= "información Básica";
$GLOBALS['strAdminFullName']			= "Nombre completo del Administrador";
$GLOBALS['strAdminEmail']				= "Dirección de e-mail del Administrador";
$GLOBALS['strCompanyName']				= "Nombre de la Compañía";

$GLOBALS['strAdminCheckUpdates']		= "Buscar Actualizaciones";
$GLOBALS['strAdminCheckEveryLogin']		= "En cada logueo";
$GLOBALS['strAdminCheckDaily']			= "A diario";
$GLOBALS['strAdminCheckWeekly']			= "Semanalmente";
$GLOBALS['strAdminCheckMonthly']		= "Mensualmente";
$GLOBALS['strAdminCheckNever']			= "Nunca";

$GLOBALS['strAdminNovice']				= "Pedir confirmación ante acciones de borrado del Administrador";
$GLOBALS['strUserlogEmail']				= "Loguear todos los mensajes de e-mail salientes";
$GLOBALS['strUserlogPriority']			= "Loguear cálculos de priorida horaria";
$GLOBALS['strUserlogAutoClean']			= "Loguear depuraciones automáticas de la base de datos";


// User interface settings
$GLOBALS['strGuiSettings']				= "Configuración de la Interfaz de Usuario";

$GLOBALS['strGeneralSettings']			= "Configuración General";
$GLOBALS['strAppName']					= "Nombre de la Aplicación";
$GLOBALS['strMyHeader']					= "Mi encabezado";
$GLOBALS['strMyFooter']					= "Mi pie de página";
$GLOBALS['strGzipContentCompression']	= "Usar GZIP para compresión de contenido";

$GLOBALS['strClientInterface']			= "Interface de Auspiciante";
$GLOBALS['strClientWelcomeEnabled']		= "Habilitar mensaje de bienvenida para el Auspiciante";
$GLOBALS['strClientWelcomeText']		= "texto de bienvenida<br />(código HTML permitido)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Defaults de Interface";

$GLOBALS['strInventory']				= "Inventario";
$GLOBALS['strShowCampaignInfo']			= "Mostrar información extra de la campaña en la página <i>Resumen de Campaña</i>";
$GLOBALS['strShowBannerInfo']			= "Mostrar información extra del banner en la página <i>Resumen de Banner</i>";
$GLOBALS['strShowCampaignPreview']		= "Mostrar vista previa de todos los banners en la página <i>resumen de Banner</i>";
$GLOBALS['strShowBannerHTML']			= "Mostrar banner actual en lugar del código HTML plano para la vista previa de Banners HTML";
$GLOBALS['strShowBannerPreview']		= "Mostrar la vista previa del banner al principio de las páginas correspondientes al banner";
$GLOBALS['strHideInactive']				= "Ocultar items inactivos de las páginas de Resumen";
$GLOBALS['strGUIShowMatchingBanners']	= "Mostrar banners relacionados en la página <i>Banner Relacionado</i>";
$GLOBALS['strGUIShowParentCampaigns']	= "Mostrar campaña principal en la páginae <i>Banner Relacionado</i>";
$GLOBALS['strGUILinkCompactLimit']		= "Ocultar campañas o banners no relacionadas en la página <i>Banner Relacionado</i> cuando hayan mas de";

$GLOBALS['strStatisticsDefaults'] 		= "Estadísticas";
$GLOBALS['strBeginOfWeek']				= "Comienzo de la semana";
$GLOBALS['strPercentageDecimals']		= "Cantidad de decimales en los Porcentajes";

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

?>