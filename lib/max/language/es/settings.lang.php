<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$GLOBALS['strLanguageSelection']		= "Selección de idioma";
$GLOBALS['strDatabaseSettings']			= "Configuración de Base de Datos";
$GLOBALS['strAdminSettings']			= "Opciones de Administrador";
$GLOBALS['strAdvancedSettings']			= "Configuración avanzada";
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
$GLOBALS['strInstallSuccess']			= "Haciendo click en 'Continuar' entrará a su servidor de publicidad.	<p><strong>¿Qué es lo siguiente?</strong></p>	<div class='psub'>	  <p><b>Registrese para recibir actualizaciones del producto</b><br>	    <a href='". OX_PRODUCT_DOCSURL ."/wizard/join' target='_blank'>Unirse a  la lista de correo de ". MAX_PRODUCT_NAME ."</a> para actualizaciones del producto, alertas de seguridad y nuevos anuncios del producto.	  </p>	  <p><b>Sirviendo su primera camapaña de plublicidad</b><br>	    Use nuestra <a href='". OX_PRODUCT_DOCSURL ."/wizard/qsg-firstcampaign' target='_blank'>guía de inicio rápido para empezar a servir su primera campaña de publicidad</a>.	  </p>	</div>	<p><strong>Pasos opcionales de instalación</strong></p>	<div class='psub'>	  <p><b>Bloquee sus archivos de opciones</b><br>	    Este es un buen paso de seguridad extra para proteger que sus archivos de opciones sean modificados. <a href='". OX_PRODUCT_DOCSURL ."/wizard/lock-config' target='_blank'>Saber más</a>.	  </p>	  <p><b>Configurar una tarea de mantenimiento regular</b><br>	    Un script de mantenimiento es recomendado para asegurar puntualidad en la generación informes  y el mejor rendimiento posible sirviendo anuncios.  <a href='". OX_PRODUCT_DOCSURL ."/wizard/setup-cron' target='_blank'>Saber más</a>	  </p>	  <p><b>Revisar las opciones de su sistema</b><br>	    Antes de comenzar a usar ". MAX_PRODUCT_NAME ." le sugerimos que revise sus opciones en la pestaña 'Opciones'.	  </p>	</div>";
$GLOBALS['strUpdateSuccess']			= "<b>La actualización de ".$phpAds_productname." ha sido completada.</b><br /><br />Para que ".$phpAds_productname." funcione correctamente deberá\n										   asegurarse de que el archivo de mantenimiento sea ejecutado cada hora.Para mayor infromación sobre este tema, lea la documentación.\n										   <br /><br />Clickee en <b>Proceder</b> para dirigirse a la página de configuración, donde podrá establecer otras configuraciones.\n										Por favor no bloquee el archivo config.inc.php cuando termine.";
$GLOBALS['strInstallNotSuccessful']		= " <b>La instalación de ". MAX_PRODUCT_NAME ." no ha concluido satisfactoriamente</b><br /><br />Algunas partes del proceso de instalación no se han podido completar.\n                                                Es posible que esos problemas no sean sólo temporales, en ese caso puede simplemente hacer clic en <b>Proceder</b> y volver al primer paso del proceso de instalación. Si quiere saber más sobre lo que significa el mensaje de abajo y cómo solucionarlo, por favor, consulte la documentación disponible";
$GLOBALS['strErrorOccured']				= "Ha ocurrido el siguiente error:";
$GLOBALS['strErrorInstallDatabase']		= "No se puede crear la estructura de la base de datos.";
$GLOBALS['strErrorUpgrade'] = 'The existing installation\'s database could not be upgraded.';
$GLOBALS['strErrorInstallConfig']		= "El archivo de configuración o la base de datos no pudieron ser actualizados.";
$GLOBALS['strErrorInstallDbConnect']	= "No fue posible conectarse con la base de datos.";

$GLOBALS['strUrlPrefix']				= "Prefijo URL";

$GLOBALS['strProceed']					= "Proceder >";
$GLOBALS['strRepeatPassword']			= "Repetir contraseña";
$GLOBALS['strNotSamePasswords']			= "Las contraseñas facilitadas no concuerdan";
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
$GLOBALS['strDayFullNames'][3] = "Miércoles";
$GLOBALS['strDayFullNames'][4] = "Jueves";
$GLOBALS['strDayFullNames'][5] = "Viernes";
$GLOBALS['strDayFullNames'][6] = "Sábado";

$GLOBALS['strEditConfigNotPossible']    = "No es posible editar esta configuración debido a que el archivo de configuración se encuentra bloqueado por razones de seguridad.<br /> Si desea hacer cambios, deberá desbloquear primero el archivo config.inc.php.";
$GLOBALS['strEditConfigPossible']		= "Es posible editar las configuraciones ya que el archivo de configuraciones no está bloqueado, pero esto puede transformarse en un problema de seguridad.<br /> Si quiere asegurar su sistema, necesita bloquear el archivo config.inc.php.";



// Database
$GLOBALS['strDatabaseSettings']			= "Configuración de Base de Datos";
$GLOBALS['strDatabaseServer']			= "Opciones globales del servidor de base de datos";
$GLOBALS['strDbHost']					= "Nombre de host de la base de datos";
$GLOBALS['strDbUser']					= "Nombre de usuario de la base de datos";
$GLOBALS['strDbPassword']				= "Contraseña de la base de datos";
$GLOBALS['strDbName']					= "Nombre de la base de datos";

$GLOBALS['strDatabaseOptimalisations']	= "Opciones de optimización de la base de datos";
$GLOBALS['strPersistentConnections']	= "Usar conexiones persistentes";
$GLOBALS['strCompatibilityMode']		= "Usar modo de compatibilidad de base de datos";
$GLOBALS['strCantConnectToDb']			= "No se puede conectar a la base de datos";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']	= "Opciones de invocación";

$GLOBALS['strAllowedInvocationTypes']	= "Tipos de invocación permitidos";
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
$GLOBALS['strTypeTxtAllow']				= "Permitir Anuncios de Texto";

$GLOBALS['strTypeWebSettings']			= "Configuración de banner local (Webserver)";
$GLOBALS['strTypeWebMode']				= "Método de almacenamiento";
$GLOBALS['strTypeWebModeLocal']			= "Directorio local";
$GLOBALS['strTypeWebModeFtp']			= "Servidor FTP externo";
$GLOBALS['strTypeWebDir']				= "Directorio local";
$GLOBALS['strTypeWebFtp']				= "Modo FTP";
$GLOBALS['strTypeWebUrl']				= "URL pública";
$GLOBALS['strTypeWebSslUrl']			= "URL pública (SSL)";
$GLOBALS['strTypeFTPHost']				= "Host FTP";
$GLOBALS['strTypeFTPDirectory']			= "Directorio del host";
$GLOBALS['strTypeFTPUsername']			= "Iniciar sesión";
$GLOBALS['strTypeFTPPassword']			= "Contraseña";

$GLOBALS['strDefaultBanners']			= "Banners predeterminados";
$GLOBALS['strDefaultBannerUrl']			= "URL de imagen predeterminada";
$GLOBALS['strDefaultBannerTarget']		= "URL de destino predeterminada";

$GLOBALS['strTypeHtmlSettings']			= "Opciones de banners HTML";
$GLOBALS['strTypeHtmlAuto']				= "Alterar banners HTML automáticamente para forzar el seguimiento de clics";
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

$GLOBALS['strEmailWarnings']			= "Alertas vía E-mail";
$GLOBALS['strAdminEmailHeaders']		= "Añadir las siguientes cabeceras a cada e-mail enviado por ". MAX_PRODUCT_NAME ."";
$GLOBALS['strWarnLimit']				= "Enviar un aviso cuando el número de impresiones restantes sea menos que el especificado aquí";
$GLOBALS['strWarnLimitErr']				= "El límite de aviso debe ser un entero positivo";
$GLOBALS['strWarnAdmin']				= "Enviar un aviso al administrador cada vez que una campaña vaya a expirar";
$GLOBALS['strWarnClient']				= "Enviar un aviso al anunciante cada vez que una campaña vaya a expirar";
$GLOBALS['strQmailPatch']				= "parche qmail";

$GLOBALS['strRemoteHosts']				= "Hosts remotos";
$GLOBALS['strIgnoreHosts']				= "No guardar estadísticas para visitantes que usan alguna de las siguientes Ips o hostnames:";
$GLOBALS['strReverseLookup']			= "Hacer un reverse lookup de los hostnames de los visitantes cuando no se facilite";
$GLOBALS['strProxyLookup']				= "Intentar determinar la dirección IP real de los visitantes tras un servidor proxy";

$GLOBALS['strAutoCleanTables']			= "Auto-depurar la base de datos";
$GLOBALS['strAutoCleanEnable']			= "Habilitar Auto-depuración";
$GLOBALS['strAutoCleanWeeks']			= "Guardar logs y estadísticas ed las últimas (semanas)";
$GLOBALS['strAutoCleanErr']				= "El tiempo mínimo es de 2 semanas";
$GLOBALS['strAutoCleanVacuum']			= "VACUUM ANALYZE tables every night"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']	= "Opciones de Administrador";

$GLOBALS['strLoginCredentials']			= "Credenciales de inicio de sesión";
$GLOBALS['strAdminUsername']			= "Nombre de usuario del administrador";
$GLOBALS['strOldPassword']				= "Contraseña antigua";
$GLOBALS['strNewPassword']				= "Contraseña nueva";
$GLOBALS['strInvalidUsername']			= "Nombre de usuario incorrecto";
$GLOBALS['strInvalidPassword']			= "La nueva contraseña no es válida, por favor, use una contraseña diferente.";

$GLOBALS['strBasicInformation']			= "Información Básica";
$GLOBALS['strAdminFullName']			= "Nombre completo del admin";
$GLOBALS['strAdminEmail']				= "Dirección e-mail del admin";
$GLOBALS['strCompanyName']				= "Nombre de la compañía";

$GLOBALS['strAdminCheckUpdates']		= "Comprobar automáticamente si hay actualizaciones de producto y alertas de seguridad (Recomendado).";
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
$GLOBALS['strAppName']					= "Nombre de la aplicación";
$GLOBALS['strMyHeader']					= "Ubicación del archivo header";
$GLOBALS['strMyFooter']					= "Ubicación del archivo footer";
$GLOBALS['strGzipContentCompression']	= "Usar GZIP para compresión de contenido";

$GLOBALS['strClientInterface']			= "Interfaz del anunciante";
$GLOBALS['strClientWelcomeEnabled']		= "Habilitar mensaje de bienvenida para el anunciante";
$GLOBALS['strClientWelcomeText']		= "Texto de bienvenida<br />(código HTML permitido)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Opciones por defecto del interfaz";

$GLOBALS['strInventory']				= "Inventario";
$GLOBALS['strShowCampaignInfo']			= "Mostrar información extra de la campaña en la página <i>Campañas</i>";
$GLOBALS['strShowBannerInfo']			= "Mostrar información extra del banner en la página <i>Banners</i>";
$GLOBALS['strShowCampaignPreview']		= "Mostrar vista previa de todos los banners en la página <i>Banner</i>";
$GLOBALS['strShowBannerHTML']			= "Mostrar banner actual en lugar del código HTML plano para la vista previa de Banners HTML";
$GLOBALS['strShowBannerPreview']		= "Mostrar la vista previa del banner al principio de las páginas correspondientes al banner";
$GLOBALS['strHideInactive']				= "Esconder inactivos";
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
$GLOBALS['strSpecifySyncSettings'] = "Opciones de sincronización";
$GLOBALS['strOpenadsIdYour'] = "Su OpenX ID";
$GLOBALS['strOpenadsIdSettings'] = "Opciones de OpenX ID";
$GLOBALS['strBtnContinue'] = "Continuar »";
$GLOBALS['strBtnRecover'] = "Recuperar »";
$GLOBALS['strBtnStartAgain'] = "Empezar actualización de nuevo »";
$GLOBALS['strBtnGoBack'] = "« Volver";
$GLOBALS['strBtnAgree'] = "Acepto »";
$GLOBALS['strBtnDontAgree'] = "« No acepto";
$GLOBALS['strBtnRetry'] = "Reintentar";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Por favor, corrija todos los errores antes de continuar.";
$GLOBALS['strWarningRegisterArgcArv'] = "La variable de configuración de PHP register_argc_argv necesita estar activa para ejecutar el mantenimiento desde la línea de comandos.";
$GLOBALS['strInstallIntro'] = "Gracias por usar <a href='http://". MAX_PRODUCT_URL ."' target='_blank'><strong>". MAX_PRODUCT_NAME ."</strong></a>. <p>Este asistente le guiará en el proceso de instalación / actualización del servidor de publicidad ". MAX_PRODUCT_NAME .".</p><p>Para ayudarle con el proceso de instalación hemos creado una <a href='". OX_PRODUCT_DOCSURL ."/wizard/qsg-install' target='_blank'>Guía de instalación rápida</a> para iniciarle en el proceso de puesta en marcha. Para una guía más detallada de la instalación y configuración de ". MAX_PRODUCT_NAME ." visite la <a href='". OX_PRODUCT_DOCSURL ."/wizard/admin-guide' target='_blank'>Guía del Administrador</a>.";
$GLOBALS['strRecoveryRequiredTitle'] = "El intento de actualización ha encontrado errores";
$GLOBALS['strRecoveryRequired'] = "Ha ocurrido un error al procesar la actualización anterior y ". MAX_PRODUCT_NAME ." necesita intentar recuperar el proceso de actualización. Por favor, haga clic en el botón Recuperar.";
$GLOBALS['strTermsTitle'] = "Términos y Condiciones de Uso, Política de Privacidad";
$GLOBALS['strPolicyTitle'] = "Política de privacidad";
$GLOBALS['strPolicyIntro'] = "Por favor, revise y acepte el siguiente documento antes de continuar con la instalación.";
$GLOBALS['strDbSetupTitle'] = "Configuración de Base de Datos";
$GLOBALS['strDbUpgradeIntro'] = "A continuación se muestran los detalles detectados de su base de datos para la instalación de ". MAX_PRODUCT_NAME .". Por favor, compruebe que los valores sean correctos. <p>El siguiente paso actualizará su base de datos. Haga clic en 'Continuar' para actualizar su sistema</p>";
$GLOBALS['strOaUpToDate'] = "Su base de datos ". MAX_PRODUCT_NAME ." y estructura de archivos están usando la versión más reciente, por lo tanto no hace falta realizar una actualización en este momento. Por favor, haga clic en Continuar para proceder al panel de administración de ". MAX_PRODUCT_NAME .".";
$GLOBALS['strOaUpToDateCantRemove'] = "Aviso: el archivo de ACTUALIZACIÓN sigue presente en el directorio var. No podemos borrar dicho archivo debido a permisos insuficientes. Por favor, borre este archivo usted mismo.";
$GLOBALS['strRemoveUpgradeFile'] = "Debe borrar el archivo de ACTUALIZACIÓN del directorio var.";
$GLOBALS['strDbSuccessIntro'] = "La base de datos de ". MAX_PRODUCT_NAME ." ha sido creada. Por favor haga click el en botón continuar para proceder con las configuraciones del Administrador y de la Entrega de ". MAX_PRODUCT_NAME .".";
$GLOBALS['strDbSuccessIntroUpgrade'] = "Su sistema ha sido actualizado correctamente. Las siguientes pantallas le ayudarán a actualizar la configuración de su nuevo adserver.";
$GLOBALS['strErrorFixPermissionsCommand'] = "<p><strong>Seguridad</strong><br>";
$GLOBALS['strErrorWritePermissionsWin'] = "La isntalación de Openads necesita que el archivo de configuración se pueda modificar. Al finalizar las modificaciones de configuración, es altamente recomendable mantener un simple acceso de lectura a este archivo, para mayor seguridad. Para más información sobre esto, por favor lea la referencia en la <a href='http://MAX_PRODUCT_DOCSURL' target='_blank'><strong>documentación</strong></a>.</p>";
$GLOBALS['strCheckDocumentation'] = "Para más ayuda, por favor lea la <a href='". OX_PRODUCT_DOCSURL ."'>documentación de ". MAX_PRODUCT_NAME ."<a/>.";
$GLOBALS['strAdminUrlPrefix'] = "URL de la Interfaz de Administración";
$GLOBALS['strDeliveryUrlPrefix'] = "URL del Motor de Entrega";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL motor de entrega (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL de almacenamiento de imagen";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL de almacenamiento de imagen (SSL)";
$GLOBALS['strTimezone'] = "Zona horaria";
$GLOBALS['strTimezoneEstimated'] = "Zona horaria estimada";
$GLOBALS['strTimezoneGuessedValue'] = "La zona horaria del servidor no está correctamente configurada en PHP";
$GLOBALS['strTimezoneSeeDocs'] = "Por favor, lea los %DOCS% acerca de configurar esta variable para PHP.";
$GLOBALS['strTimezoneDocumentation'] = "documentación";
$GLOBALS['strLoginSettingsTitle'] = "Inicio de sesión de administrador";
$GLOBALS['strLoginSettingsIntro'] = "Para poder continuar con el proceso de actualización, por favor introduzca los detalles de su cuenta de administrador de ". MAX_PRODUCT_NAME .". Debe iniciar la sesión como administrador para continuar con el proceso de actualización.";
$GLOBALS['strAdminSettingsTitle'] = "Crear cuenta de administrador";
$GLOBALS['strAdminSettingsIntro'] = "Por favor, complete este formulario para crear su cuenta de administración del adserver.";
$GLOBALS['strEnableAutoMaintenance'] = "Ejecutar automáticamente el mantenimiento durante la entrega si el mantenimiento programado no está activo";
$GLOBALS['strDbSetupIntro'] = "Por favor introduzca los detalles para conectar a su base de datos. Si no está seguro acerca de los detalles, por favor contacte con su administrador de sistemas. <p>El próximo paso pondrá a punto su base de datos. Haga clic en 'continuar' para proceder.</p>";
$GLOBALS['strSystemCheckIntro'] = "El asistente de instalación está comprobando la configuración de su servidor web para asegurar que el proceso de instalación se puede completar satisfactoriamente. <p>Por favor compruebe los problemas marcados para completar el proceso de instalación.</p>";
$GLOBALS['strConfigSettingsIntro'] = "Por favor revise la configuración que hay a continuación y realice cualquier cambio requerido antes de continuar. Si no está seguro, deje los valores por defecto.";


// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strSystemCheck'] = "Inspección del sistema";
$GLOBALS['strErrorWritePermissions'] = "Se han detectado errores de permisos de archivos y deben ser solucionados para poder continuar.<br />Para solucionar los errores en un sistema Linux intente teclear el/los siguiente(s) comando(s).";
$GLOBALS['strImageDirLockedDetected'] = "El servidor no puede escribir en el <b>Directorio de Imágenes</b> suministrado. <br>No puede continuar hasta que haya cambiado los permisos del directorio o haya creado otro directorio.";
$GLOBALS['strOpenadsUsername'] = "". MAX_PRODUCT_NAME ." Nombre de usuario";
$GLOBALS['strOpenadsPassword'] = "". MAX_PRODUCT_NAME ." Contraseña";
$GLOBALS['uiEnabled'] = "Habilitar Interface de Usuario ";
$GLOBALS['strAuditTrailSettings'] = "Log Audit";
$GLOBALS['strDbLocal'] = "Usar como conexión socket local";
$GLOBALS['strDbSocket'] = "Socket de Base de Datos";
$GLOBALS['strEmailFromCompany'] = "Compañía del Emisor";
$GLOBALS['strIgnoreUserAgents'] = "<b>No</b> loguear estadísticas de clientes que contengan alguna de las siguientes cadenas en su agente de usuario (una por línea)";
$GLOBALS['strEnforceUserAgents'] = "<b>Sólo</b> loguear estadísticas de clientes con alguna de las siguientes cadenas en su agente de usuario (una por línea)";
$GLOBALS['strConversionTracking'] = "Configuración de Conversion Tracking";
$GLOBALS['strEnableConversionTracking'] = "Habilitar Conversion Tracking";
$GLOBALS['strDbNameHint'] = "La Base de datos será creada si no existe";
$GLOBALS['strProductionSystem'] = "Sistema de Producción";
$GLOBALS['strTypeFTPErrorUpload'] = "No se pudo subir el archivo al Servidor FTP, verífique que el directorio en el servidor tiene los permisos correctos";
$GLOBALS['strBannerLogging'] = "Opciones de registro de banners";
$GLOBALS['strBannerDelivery'] = "Opciones de entrega de banners";
$GLOBALS['strEnableDashboardSyncNotice'] = "Por favor, permita el <a href='account-settings-update.php'>chequeo de actualizaciones</a> si desea usar el Tablero.";
$GLOBALS['strDashboardSettings'] = "Configuración del Tablero";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod -R a+w %s</i>";
$GLOBALS['strGlobalDefaultBannerUrl'] = "URL de la imagen del banner global por defecto";
$GLOBALS['strAdminShareStack'] = "Comparta información técnica con el equipo de OpenX a fin de colaborar con el desarrollo y testeo.";
$GLOBALS['strAdminShareData'] = "Comparta anónimamente la información sobre el volumen de  anuncios para participar en el programa de datos compartidos por la comunidad.";
$GLOBALS['strCantConnectToDbDelivery'] = "No se puede conectar con la base de datos para la entrega de avisos";
$GLOBALS['strDefaultConversionStatus'] = "Reglas de conversión por defecto";
$GLOBALS['strDefaultConversionType'] = "Reglas de conversión por defecto";
?>