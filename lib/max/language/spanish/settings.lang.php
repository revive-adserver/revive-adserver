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
$GLOBALS['strInstall']					= "Instalaci&oacute;n";
$GLOBALS['strChooseInstallLanguage']	= "Escoja un idioma para proceder con la instalaci&oacute;n";
$GLOBALS['strLanguageSelection']		= "Selecci&oacute;n del Idioma";
$GLOBALS['strDatabaseSettings']			= "Configuraci&oacute;n de la Base de Datos";
$GLOBALS['strAdminSettings']			= "Configuraci&oacute;n del Administrador";
$GLOBALS['strAdvancedSettings']			= "Configuraci&oacute;n Avanzada";
$GLOBALS['strOtherSettings']			= "Otras configuraciones";

$GLOBALS['strWarning']					= "Advertencia";
$GLOBALS['strFatalError']				= "Ha ocurrido un error fatal";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname." ya se encuentra instalado en el sistema. Si desea configurarlo vaya a <a href='settings-index.php'>Configuraci&oacute;n de Interface</a>";
$GLOBALS['strCouldNotConnectToDB']		= "No se puede conectar a la base de datos, por favor verifique la configuraci&oacute;n especificada para la misma";
$GLOBALS['strCreateTableTestFailed']	= "El usuario especificado no tiene permisos suficientes para crear o actualizar la estructura de la base de datos, por favor contacte al administrador de la base de datos.";
$GLOBALS['strUpdateTableTestFailed']	= "El usuario especificado no tiene permisos suficientes para actualizar la estructura de la base de datos, por favor contacte al administrador de la base de datos.";
$GLOBALS['strTablePrefixInvalid']		= "El prefijo de tabla contiene caracteres inv&aacute;lidos";
$GLOBALS['strTableInUse']				= "La base de datos especificada ya se encuentra utilizada por ".$phpAds_productname.", por favor use un prefijo de tabla diferente, o lea el manual de instrucciones para actualizar.";
$GLOBALS['strMayNotFunction']			= "Antes de continuar por favor corrija estos potenciales problemas:";
$GLOBALS['strIgnoreWarnings']			= "Ignorar advertencias";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." requiere PHP 4.0 o mayor para funcionar correctamente. Ud. est&aacute; usando {php_version}.";
$GLOBALS['strWarningRegisterGlobals']	= "Configuraci&oacute;n PHP : la variable register_globals tiene que tener el valor on.";
$GLOBALS['strWarningMagicQuotesGPC']	= "Configuraci&oacute;n PHP : la variable magic_quotes_gpc tiene que tener el valor on.";
$GLOBALS['strWarningMagicQuotesRuntime']= "Configuraci&oacute;n PHP : la variable magic_quotes_runtime tiene que tener el valor off.";
$GLOBALS['strWarningFileUploads']		= "Configuraci&oacute;n PHP : la variable file_uploads tiene que tener el valor on.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." ha detectado que su <b>config.inc.php</b> no tiene permiso de escritura por el server.<br /> Ud. no podr&aacute; proseguir si no cambia los permisos del archivo. <br />Lea la documentaci&oacute;n suministrada si no sabe como hacerlo.";
$GLOBALS['strCantUpdateDB']  			= "No es posible actualizar la base de datos en este momento. si desea proceder, todos los bannes, estad&iacute;sticas y anunciantes existentes ser&aacute;n borrados.";
$GLOBALS['strTableNames']				= "Nombre de Tablas";
$GLOBALS['strTablesPrefix']				= "Prefijo de Nombre de Tablas";
$GLOBALS['strTablesType']				= "Tipo de Tablas";

$GLOBALS['strInstallWelcome']			= "Bienvenido a ".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "Antes de poder usar ".$phpAds_productname." necesitar&aacute; configurarlo y <br /> deber&aacute; crear la base de datos. Clickee en <b>Proceder</b> para continuar.";
$GLOBALS['strInstallSuccess']			= "<b>La instalaci&oacute;n de ".$phpAds_productname." se encuentra completa.</b><br /><br />Para que ".$phpAds_productname." funcione correctamente, deber&aacute; asegurarse
										que el archivo de mantenimiento sea ejecutado cada hora. Para mayor infromaci&oacute;n sobre este tema, lea la documentaci&oacute;n.
										<br /><br />Clickee en <b>Proceder</b> para dirigirse a la p&aacute;gina de configuraci&oacute;n, donde podr&aacute; establecer otras configuraciones.
										Por favor no bloquee el archivo config.inc.php cuando termine.";
$GLOBALS['strUpdateSuccess']			= "<b>La actualizaci&oacute;n de ".$phpAds_productname." ha sido completada.</b><br /><br />Para que ".$phpAds_productname." funcione correctamente deber&aacute;
										   asegurarse de que el archivo de mantenimiento sea ejecutado cada hora.Para mayor infromaci&oacute;n sobre este tema, lea la documentaci&oacute;n.
										   <br /><br />Clickee en <b>Proceder</b> para dirigirse a la p&aacute;gina de configuraci&oacute;n, donde podr&aacute; establecer otras configuraciones.
										Por favor no bloquee el archivo config.inc.php cuando termine.";
$GLOBALS['strInstallNotSuccessful']		= "<b>La instalaci&oacute;n de ".$phpAds_productname." no ha finalizado</b><br /><br />Algunos puntos durante la instalaci&oacute;n no pudieron ser completados.
										   Es posible que estos problemas sean solamente temporarios, en este caso simplemente clickee en <b>Proceder</b> y vuelva al
										   primer paso del proceso de instalaci&oacute;n. Si desea saber m&aacute;s sobre sobre los mensajes de error y como resolverlos, 
										   consulte la documentaci&oacute;n suministrada.";
$GLOBALS['strErrorOccured']				= "Ha ocurrido el siguiente error:";
$GLOBALS['strErrorInstallDatabase']		= "No se puede crear la estructura de la base de datos.";
$GLOBALS['strErrorUpgrade'] = 'The existing installation\'s database could not be upgraded.';
$GLOBALS['strErrorInstallConfig']		= "El archivo de configuraci&oacute;n o la base de datos no pudieron ser actualizados.";
$GLOBALS['strErrorInstallDbConnect']	= "No fue posible conectarse con la base de datos.";

$GLOBALS['strUrlPrefix']				= "Prefijo URL";

$GLOBALS['strProceed']					= "Proceder &gt;";
$GLOBALS['strRepeatPassword']			= "Repetir Password";
$GLOBALS['strNotSamePasswords']			= "Los passwords no concuerdan";
$GLOBALS['strInvalidUserPwd']			= "Nombre de usuario o password incorrecto.";

$GLOBALS['strUpgrade']					= "Actualizaci&oacute;n";
$GLOBALS['strSystemUpToDate']			= "Su sistema se encuentra actualizado. <br />Clickee en<b>Proceder</b> para regresar a la p&aacute;gina de inicio.";
$GLOBALS['strSystemNeedsUpgrade']		= "La estructura de la base de datos y el archivo de configuraci&oacute;n deber&aacute;n actualizarse para funcionar correctamente. Clickee en <b>Proceder</b> para comenzar el proceso de actualizaci&oacute;n. <br />Por favor tenga paciencia, la actualizaci&oacute;n puede tardar algunos minutos.";
$GLOBALS['strSystemUpgradeBusy']		= "Actualizaci&oacute;n del sistema en progreso, por favor espere...";
$GLOBALS['strSystemRebuildingCache']	= "Reconstruyendo cache, por favor espere...";
$GLOBALS['strServiceUnavalable']		= "El sistema no se encuentra disponible temporariamente. Se encuentra en proceso de actualizaci&oacute;n.";

$GLOBALS['strConfigNotWritable']		= "Su archivo config.inc.php no puede escribirse.";





/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']			= "Elija la Secci&oacute;n";
$GLOBALS['strDayFullNames'] 			= array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
$GLOBALS['strEditConfigNotPossible']    = "No es posible editar esta configuraci&oacute;n debido a que el archivo de configuraci&oacute;n se encuentra bloqueado por razones de seguridad.<br /> ".
										  "Si desea hacer cambios, deber&aacute; desbloquear primero el archivo config.inc.php.";
$GLOBALS['strEditConfigPossible']		= "Es posible editar las configuraciones ya que el archivo de configuraciones no est&aacute; bloqueado, pero esto puede transformarse en un problema de seguridad.<br /> ".
										  "Si quiere asegurar su sistema, necesita bloquear el archivoconfig.inc.php.";



// Database
$GLOBALS['strDatabaseSettings']			= "Configuraci&oacute;n de Base de Datos";
$GLOBALS['strDatabaseServer']			= "Servidor de Base de Datos";
$GLOBALS['strDbHost']					= "Nombre de host de la base de datos";
$GLOBALS['strDbUser']					= "Nombre de usuario de la base de datos";
$GLOBALS['strDbPassword']				= "Password de la base de datos";
$GLOBALS['strDbName']					= "Nombre de la base de datos";

$GLOBALS['strDatabaseOptimalisations']	= "Optimizaci&oacute;n de la base de datos";
$GLOBALS['strPersistentConnections']	= "Usar conexiones persistentes";
$GLOBALS['strCompatibilityMode']		= "Usar modo de compatibilidad de base de datos";
$GLOBALS['strCantConnectToDb']			= "No se puede conectar a la base de datos";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']	= "Configuraci&oacute;n de Invocaci&oacute;n y env&iacute;o";

$GLOBALS['strAllowedInvocationTypes']	= "Tipos de Invocaci&oacute;n Permitidos";
$GLOBALS['strAllowRemoteInvocation']	= "Permitir Invocaci&oacute;n Remota";
$GLOBALS['strAllowRemoteJavascript']	= "Permitir Invocaci&oacute;n Remota para JavaScriptAllow";
$GLOBALS['strAllowRemoteFrames']		= "Permitir Invocaci&oacute;n Remota para Frames";
$GLOBALS['strAllowRemoteXMLRPC']		= "Permitir Invocaci&oacute;n Remota usando XML-RPC";
$GLOBALS['strAllowLocalmode']			= "Permitir modo Local";
$GLOBALS['strAllowInterstitial']		= "Permitir Interstitials";
$GLOBALS['strAllowPopups']				= "Permitir Popups";

$GLOBALS['strKeywordRetrieval']			= "Recuperaci&oacute;n de Palabra Clave";
$GLOBALS['strBannerRetrieval']			= "Metodo de Recuperaci&oacute;n de Banner";
$GLOBALS['strRetrieveRandom']			= "Randomizaci&oacute;n de Recuperaci&oacute;n de banner (predeterminado)";
$GLOBALS['strRetrieveNormalSeq']		= "Recuperaci&oacute;n secuencial de banner normal";
$GLOBALS['strWeightSeq']				= "Recuperaci&oacute;n secuencial de banner basada en peso";
$GLOBALS['strFullSeq']					= "Recuperaci&oacute;n secuencial de banner completa";
$GLOBALS['strUseConditionalKeys']		= "Usar palabra clave condicionales";
$GLOBALS['strUseMultipleKeys']			= "Usar multiples palabras claves";
$GLOBALS['strUseAcl']					= "Usar limitaciones de exposici&oacute;n";

$GLOBALS['strZonesSettings']			= "Recuperaci&oacute;n de Zonas";
$GLOBALS['strZoneCache']				= "Cache de zonas, esto deber&iacute;a acelerar los procesos en zonas";
$GLOBALS['strZoneCacheLimit']			= "Tiempo entre actualizaciones de cache (en segundos)";
$GLOBALS['strZoneCacheLimitErr']		= "El tiempo entre actualizaciones de cache debe ser un n&uacute;mero entero positivo";

$GLOBALS['strP3PSettings']				= "Pol&iacute;ticas de Privacidad P3P";
$GLOBALS['strUseP3P']					= "Usar Politicas P3P";
$GLOBALS['strP3PCompactPolicy']			= "Politica Compacta P3P";
$GLOBALS['strP3PPolicyLocation']		= "Ubicaci&oacute;n de Politica P3P";



// Banner Settings
$GLOBALS['strBannerSettings']			= "Configuraci&oacute;n de Banner";

$GLOBALS['strAllowedBannerTypes']		= "Tipos de banner permitidos";
$GLOBALS['strTypeSqlAllow']				= "Permitir banners locales (SQL)";
$GLOBALS['strTypeWebAllow']				= "Permitir banners locales (Webserver)";
$GLOBALS['strTypeUrlAllow']				= "Permitir banners externos";
$GLOBALS['strTypeHtmlAllow']			= "Permitir HTML banners";
$GLOBALS['strTypeTxtAllow']				= "Permitir Textos";

$GLOBALS['strTypeWebSettings']			= "Configuraci&oacute;n de banner local (Webserver)";
$GLOBALS['strTypeWebMode']				= "Metodo de almacenamiento";
$GLOBALS['strTypeWebModeLocal']			= "Directorio Local";
$GLOBALS['strTypeWebModeFtp']			= "Servidor FTP externo";
$GLOBALS['strTypeWebDir']				= "Directorio Local";
$GLOBALS['strTypeWebFtp']				= "Modo FTP";
$GLOBALS['strTypeWebUrl']				= "URL p&uacute;blica";
$GLOBALS['strTypeWebSslUrl']			= "URL p&uacute;blica (SSL)";
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
$GLOBALS['strStatisticsSettings']		= "Configuraci&oacute;n de Estad&iacute;sticas";

$GLOBALS['strStatisticsFormat']			= "Formato de Estad&iacute;sticas";
$GLOBALS['strLogBeacon']				= "Usar beacons para loguear las Impresiones";
$GLOBALS['strCompactStats']				= "Usar estad&iacute;sticas Compactas";
$GLOBALS['strLogAdviews']				= "Loguear Impresiones";
$GLOBALS['strBlockAdviews']				= "Protecci&oacute;n contra logueo m&uacute;ltiple de Impresiones (segs.)";
$GLOBALS['strLogAdclicks']				= "Loguear Clicks";
$GLOBALS['strBlockAdclicks']			= "Protecci&oacute;n contra logueo m&uacute;ltiple de Clicks (segs.)";

$GLOBALS['strEmailWarnings']			= "Alertas via E-mail";
$GLOBALS['strAdminEmailHeaders']		= "Encabezados de Mail para reflejar el Remitente del envio diario de reportes";
$GLOBALS['strWarnLimit']				= "Advertir L&iacute;mites";
$GLOBALS['strWarnLimitErr']				= "Advertencia de L&iacute;mites debe ser un n&uacute;mero entero positivo";
$GLOBALS['strWarnAdmin']				= "Adveritr al Administrador";
$GLOBALS['strWarnClient']				= "Advertir al Auspiciante";
$GLOBALS['strQmailPatch']				= "Habilitar parche para qmail";

$GLOBALS['strRemoteHosts']				= "Hosts remotos";
$GLOBALS['strIgnoreHosts']				= "Ignorar Hosts";
$GLOBALS['strReverseLookup']			= "Reverse DNS Lookup";
$GLOBALS['strProxyLookup']				= "Proxy Lookup";

$GLOBALS['strAutoCleanTables']			= "Auto-depurar la base de datos";
$GLOBALS['strAutoCleanEnable']			= "Habilitar Auto-depuraci&oacute;n";
$GLOBALS['strAutoCleanWeeks']			= "Guardar logs y estad&iacute;sticas ed las &uacute;ltimas (semanas)";
$GLOBALS['strAutoCleanErr']				= "El tiempo m&iacute;nimo es de 2 semanas";
$GLOBALS['strAutoCleanVacuum']			= "VACUUM ANALYZE tables every night"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']	= "Configuraci&oacute;n de Administrador";

$GLOBALS['strLoginCredentials']			= "Credenciales de Login";
$GLOBALS['strAdminUsername']			= "Nombre de Usuario del Administrador";
$GLOBALS['strOldPassword']				= "Password Anterior";
$GLOBALS['strNewPassword']				= "Nuevo Password";
$GLOBALS['strInvalidUsername']			= "usuario incorrecto";
$GLOBALS['strInvalidPassword']			= "password incorrecto";

$GLOBALS['strBasicInformation']			= "informaci&oacute;n B&aacute;sica";
$GLOBALS['strAdminFullName']			= "Nombre completo del Administrador";
$GLOBALS['strAdminEmail']				= "Direcci&oacute;n de e-mail del Administrador";
$GLOBALS['strCompanyName']				= "Nombre de la Compa&ntilde;&iacute;a";

$GLOBALS['strAdminCheckUpdates']		= "Buscar Actualizaciones";
$GLOBALS['strAdminCheckEveryLogin']		= "En cada logueo";
$GLOBALS['strAdminCheckDaily']			= "A diario";
$GLOBALS['strAdminCheckWeekly']			= "Semanalmente";
$GLOBALS['strAdminCheckMonthly']		= "Mensualmente";
$GLOBALS['strAdminCheckNever']			= "Nunca";

$GLOBALS['strAdminNovice']				= "Pedir confirmaci&oacute;n ante acciones de borrado del Administrador";
$GLOBALS['strUserlogEmail']				= "Loguear todos los mensajes de e-mail salientes";
$GLOBALS['strUserlogPriority']			= "Loguear c&aacute;lculos de priorida horaria";
$GLOBALS['strUserlogAutoClean']			= "Loguear depuraciones autom&aacute;ticas de la base de datos";


// User interface settings
$GLOBALS['strGuiSettings']				= "Configuraci&oacute;n de la Interfaz de Usuario";

$GLOBALS['strGeneralSettings']			= "Configuraci&oacute;n General";
$GLOBALS['strAppName']					= "Nombre de la Aplicaci&oacute;n";
$GLOBALS['strMyHeader']					= "Mi encabezado";
$GLOBALS['strMyFooter']					= "Mi pie de p&aacute;gina";
$GLOBALS['strGzipContentCompression']	= "Usar GZIP para compresi&oacute;n de contenido";

$GLOBALS['strClientInterface']			= "Interface de Auspiciante";
$GLOBALS['strClientWelcomeEnabled']		= "Habilitar mensaje de bienvenida para el Auspiciante";
$GLOBALS['strClientWelcomeText']		= "texto de bienvenida<br />(c&oacute;digo HTML permitido)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Defaults de Interface";

$GLOBALS['strInventory']				= "Inventario";
$GLOBALS['strShowCampaignInfo']			= "Mostrar informaci&oacute;n extra de la campa&ntilde;a en la p&aacute;gina <i>Resumen de Campa&ntilde;a</i>";
$GLOBALS['strShowBannerInfo']			= "Mostrar informaci&oacute;n extra del banner en la p&aacute;gina <i>Resumen de Banner</i>";
$GLOBALS['strShowCampaignPreview']		= "Mostrar vista previa de todos los banners en la p&aacute;gina <i>resumen de Banner</i>";
$GLOBALS['strShowBannerHTML']			= "Mostrar banner actual en lugar del c&oacute;digo HTML plano para la vista previa de Banners HTML";
$GLOBALS['strShowBannerPreview']		= "Mostrar la vista previa del banner al principio de las p&aacute;ginas correspondientes al banner";
$GLOBALS['strHideInactive']				= "Ocultar items inactivos de las p&aacute;ginas de Resumen";
$GLOBALS['strGUIShowMatchingBanners']	= "Mostrar banners relacionados en la p&aacute;gina <i>Banner Relacionado</i>";
$GLOBALS['strGUIShowParentCampaigns']	= "Mostrar campa&ntilde;a principal en la p&aacute;ginae <i>Banner Relacionado</i>";
$GLOBALS['strGUILinkCompactLimit']		= "Ocultar campa&ntilde;as o banners no relacionadas en la p&aacute;gina <i>Banner Relacionado</i> cuando hayan mas de";

$GLOBALS['strStatisticsDefaults'] 		= "Estad&iacute;sticas";
$GLOBALS['strBeginOfWeek']				= "Comienzo de la semana";
$GLOBALS['strPercentageDecimals']		= "Cantidad de decimales en los Porcentajes";

$GLOBALS['strWeightDefaults']			= "Peso predeterminado";
$GLOBALS['strDefaultBannerWeight']		= "Peso predeterminado del banner";
$GLOBALS['strDefaultCampaignWeight']	= "Peso predeterminado de la campa&ntilde;a";
$GLOBALS['strDefaultBannerWErr']		= "El peso predetermindado del banner debe ser un n&uacute;mero entero positivo";
$GLOBALS['strDefaultCampaignWErr']		= "El peso predeterminado de la campa&ntilde;a debe ser un n&uacute;mero entero positivo";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "Table Border Color";
$GLOBALS['strTableBackColor']			= "Table Back Color";
$GLOBALS['strTableBackColorAlt']		= "Table Back Color (Alternative)";
$GLOBALS['strMainBackColor']			= "Main Back Color";
$GLOBALS['strOverrideGD']				= "Override GD Imageformat";
$GLOBALS['strTimeZone']					= "Time Zone";

?>