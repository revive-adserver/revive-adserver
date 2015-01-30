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

// Installer translation strings
$GLOBALS['strInstall'] = "Instalación";
$GLOBALS['strDatabaseSettings'] = "Configuración de Base de Datos";
$GLOBALS['strAdminSettings'] = "Opciones de Administrador";
$GLOBALS['strAdminAccount'] = "Cuenta de Administrador";
$GLOBALS['strAdvancedSettings'] = "Configuración avanzada";
$GLOBALS['strWarning'] = "Advertencia";
$GLOBALS['strBtnContinue'] = "Continuar »";
$GLOBALS['strBtnRecover'] = "Recuperar »";
$GLOBALS['strBtnStartAgain'] = "Empezar actualización de nuevo »";
$GLOBALS['strBtnGoBack'] = "« Volver";
$GLOBALS['strBtnAgree'] = "Acepto »";
$GLOBALS['strBtnDontAgree'] = "« No acepto";
$GLOBALS['strBtnRetry'] = "Reintentar";
$GLOBALS['strWarningRegisterArgcArv'] = "La variable de configuración de PHP register_argc_argv necesita estar activa para ejecutar el mantenimiento desde la línea de comandos.";
$GLOBALS['strTablesType'] = "Tipo de tablas";


$GLOBALS['strRecoveryRequiredTitle'] = "El intento de actualización ha encontrado errores";
$GLOBALS['strRecoveryRequired'] = "Ha ocurrido un error al procesar la actualización anterior y {$PRODUCT_NAME} necesita intentar recuperar el proceso de actualización. Por favor, haga clic en el botón Recuperar.";

$GLOBALS['strOaUpToDate'] = "Su base de datos {$PRODUCT_NAME} y estructura de archivos están usando la versión más reciente, por lo tanto no hace falta realizar una actualización en este momento. Por favor, haga clic en Continuar para proceder al panel de administración de {$PRODUCT_NAME}.";
$GLOBALS['strOaUpToDateCantRemove'] = "Aviso: el archivo de ACTUALIZACIÓN sigue presente en el directorio var. No podemos borrar dicho archivo debido a permisos insuficientes. Por favor, borre este archivo usted mismo.";
$GLOBALS['strRemoveUpgradeFile'] = "Debe borrar el archivo de ACTUALIZACIÓN del directorio var.";
$GLOBALS['strInstallSuccess'] = "Haciendo click en 'Continuar' entrará a su servidor de publicidad.	<p><strong>¿Qué es lo siguiente?</strong></p>	<div class='psub'>	  <p><b>Registrese para recibir actualizaciones del producto</b><br>	    <a href='{$PRODUCT_DOCSURL}/wizard/join' target='_blank'>Unirse a  la lista de correo de {$PRODUCT_NAME}</a> para actualizaciones del producto, alertas de seguridad y nuevos anuncios del producto.	  </p>	  <p><b>Sirviendo su primera camapaña de plublicidad</b><br>	    Use nuestra <a href='{$PRODUCT_DOCSURL}/wizard/qsg-firstcampaign' target='_blank'>guía de inicio rápido para empezar a servir su primera campaña de publicidad</a>.	  </p>	</div>	<p><strong>Pasos opcionales de instalación</strong></p>	<div class='psub'>	  <p><b>Bloquee sus archivos de opciones</b><br>	    Este es un buen paso de seguridad extra para proteger que sus archivos de opciones sean modificados. <a href='{$PRODUCT_DOCSURL}/wizard/lock-config' target='_blank'>Saber más</a>.	  </p>	  <p><b>Configurar una tarea de mantenimiento regular</b><br>	    Un script de mantenimiento es recomendado para asegurar puntualidad en la generación informes  y el mejor rendimiento posible sirviendo anuncios.  <a href='{$PRODUCT_DOCSURL}/wizard/setup-cron' target='_blank'>Saber más</a>	  </p>	  <p><b>Revisar las opciones de su sistema</b><br>	    Antes de comenzar a usar {$PRODUCT_NAME} le sugerimos que revise sus opciones en la pestaña 'Opciones'.	  </p>	</div>";
$GLOBALS['strInstallNotSuccessful'] = " <b>La instalación de {$PRODUCT_NAME} no ha concluido satisfactoriamente</b><br /><br />Algunas partes del proceso de instalación no se han podido completar.
                                                Es posible que esos problemas no sean sólo temporales, en ese caso puede simplemente hacer clic en <b>Proceder</b> y volver al primer paso del proceso de instalación. Si quiere saber más sobre lo que significa el mensaje de abajo y cómo solucionarlo, por favor, consulte la documentación disponible";
$GLOBALS['strDbSuccessIntro'] = "La base de datos de {$PRODUCT_NAME} ha sido creada. Por favor haga click el en botón continuar para proceder con las configuraciones del Administrador y de la Entrega de {$PRODUCT_NAME}.";
$GLOBALS['strDbSuccessIntroUpgrade'] = "Su sistema ha sido actualizado correctamente. Las siguientes pantallas le ayudarán a actualizar la configuración de su nuevo adserver.";
$GLOBALS['strErrorOccured'] = "Ha ocurrido el siguiente error:";
$GLOBALS['strErrorInstallDatabase'] = "No se puede crear la estructura de la base de datos.";
$GLOBALS['strErrorInstallDbConnect'] = "No fue posible conectarse con la base de datos.";

$GLOBALS['strErrorWritePermissions'] = "Se han detectado errores de permisos de archivos y deben ser solucionados para poder continuar.<br />Para solucionar los errores en un sistema Linux intente teclear el/los siguiente(s) comando(s).";
$GLOBALS['strErrorFixPermissionsCommand'] = "<p><strong>Seguridad</strong><br>";

$GLOBALS['strErrorWritePermissionsWin'] = "La isntalación de Openads necesita que el archivo de configuración se pueda modificar. Al finalizar las modificaciones de configuración, es altamente recomendable mantener un simple acceso de lectura a este archivo, para mayor seguridad. Para más información sobre esto, por favor lea la referencia en la <a href='http://MAX_PRODUCT_DOCSURL' target='_blank'><strong>documentación</strong></a>.</p>";
$GLOBALS['strCheckDocumentation'] = "Para más ayuda, por favor lea la <a href='{$PRODUCT_DOCSURL}'>documentación de {$PRODUCT_NAME}</a>.";

$GLOBALS['strAdminUrlPrefix'] = "URL de la Interfaz de Administración";
$GLOBALS['strDeliveryUrlPrefix'] = "URL del Motor de Entrega";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL motor de entrega (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL de almacenamiento de imagen";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL de almacenamiento de imagen (SSL)";

$GLOBALS['strInvalidUserPwd'] = "Nombre de usuario o password incorrecto.";

$GLOBALS['strUpgrade'] = "Actualización";
$GLOBALS['strSystemUpToDate'] = "Su sistema se encuentra actualizado. <br />Clickee en<b>Proceder</b> para regresar a la página de inicio.";
$GLOBALS['strSystemNeedsUpgrade'] = "La estructura de la base de datos y el archivo de configuración deberán actualizarse para funcionar correctamente. Clickee en <b>Proceder</b> para comenzar el proceso de actualización. <br />Por favor tenga paciencia, la actualización puede tardar algunos minutos.";
$GLOBALS['strSystemUpgradeBusy'] = "Actualización del sistema en progreso, por favor espere...";
$GLOBALS['strSystemRebuildingCache'] = "Reconstruyendo cache, por favor espere...";
$GLOBALS['strServiceUnavalable'] = "El sistema no se encuentra disponible temporariamente. Se encuentra en proceso de actualización.";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Elija la Sección";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons. " .
    "If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues. " .
    "If you want to secure your system, you need to lock the configuration file for this installation.";
$GLOBALS['strImageDirLockedDetected'] = "El servidor no puede escribir en el <b>Directorio de Imágenes</b> suministrado. <br>No puede continuar hasta que haya cambiado los permisos del directorio o haya creado otro directorio.";

// Configuration Settings

// Administrator Settings
$GLOBALS['strAdministratorSettings'] = "Opciones de Administrador";
$GLOBALS['strLoginCredentials'] = "Credenciales de inicio de sesión";
$GLOBALS['strAdminUsername'] = "Nombre de usuario del administrador";
$GLOBALS['strInvalidUsername'] = "Nombre de usuario incorrecto";
$GLOBALS['strBasicInformation'] = "Información Básica";
$GLOBALS['strAdminFullName'] = "Nombre completo del admin";
$GLOBALS['strAdminEmail'] = "Dirección e-mail del admin";
$GLOBALS['strCompanyName'] = "Nombre de la compañía";
$GLOBALS['strAdminCheckUpdates'] = "Comprobar automáticamente si hay actualizaciones de producto y alertas de seguridad (Recomendado).";
$GLOBALS['strAdminShareStack'] = "Comparta información técnica con el equipo de OpenX a fin de colaborar con el desarrollo y testeo.";
$GLOBALS['strAdminCheckEveryLogin'] = "En cada logueo";
$GLOBALS['strAdminCheckDaily'] = "A diario";
$GLOBALS['strAdminCheckWeekly'] = "Semanalmente";
$GLOBALS['strAdminCheckMonthly'] = "Mensualmente";
$GLOBALS['strAdminCheckNever'] = "Nunca";
$GLOBALS['strUserlogEmail'] = "Grabar todos los e-mails salientes";
$GLOBALS['strEnableDashboardSyncNotice'] = "Por favor, permita el <a href='account-settings-update.php'>chequeo de actualizaciones</a> si desea usar el Tablero.";
$GLOBALS['strTimezone'] = "Zona horaria";
$GLOBALS['strTimezoneEstimated'] = "Zona horaria estimada";
$GLOBALS['strTimezoneGuessedValue'] = "La zona horaria del servidor no está correctamente configurada en PHP";
$GLOBALS['strTimezoneSeeDocs'] = "Por favor, lea los %DOCS% acerca de configurar esta variable para PHP.";
$GLOBALS['strTimezoneDocumentation'] = "documentación";
$GLOBALS['strAdminSettingsTitle'] = "Crear cuenta de administrador";
$GLOBALS['strAdminSettingsIntro'] = "Por favor, complete este formulario para crear su cuenta de administración del adserver.";
$GLOBALS['strConfigSettingsIntro'] = "Por favor revise la configuración que hay a continuación y realice cualquier cambio requerido antes de continuar. Si no está seguro, deje los valores por defecto.";

$GLOBALS['strEnableAutoMaintenance'] = "Ejecutar automáticamente el mantenimiento durante la entrega si el mantenimiento programado no está activo";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Configuración de Base de Datos";
$GLOBALS['strDatabaseServer'] = "Opciones globales del servidor de base de datos";
$GLOBALS['strDbLocal'] = "Usar como conexión socket local";
$GLOBALS['strDbHost'] = "Nombre de host de la base de datos";
$GLOBALS['strDbSocket'] = "Socket de Base de Datos";
$GLOBALS['strDbUser'] = "Nombre de usuario de la base de datos";
$GLOBALS['strDbPassword'] = "Contraseña de la base de datos";
$GLOBALS['strDbName'] = "Nombre de la base de datos";
$GLOBALS['strDbNameHint'] = "La Base de datos será creada si no existe";
$GLOBALS['strDatabaseOptimalisations'] = "Opciones de optimización de la base de datos";
$GLOBALS['strPersistentConnections'] = "Usar conexiones persistentes";
$GLOBALS['strCantConnectToDb'] = "No se puede conectar a la base de datos";
$GLOBALS['strCantConnectToDbDelivery'] = 'No se puede conectar con la base de datos para la entrega de avisos';



// Email Settings
$GLOBALS['strEmailFromCompany'] = "Compañía del Emisor";
$GLOBALS['strQmailPatch'] = "parche qmail";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Log Audit";

// Debug Logging Settings
$GLOBALS['strProductionSystem'] = "Sistema de Producción";

// Delivery Settings
$GLOBALS['strWebPath'] = "$PRODUCT_NAME Server Access Paths";
$GLOBALS['strTypeWebSettings'] = "Configuración de banner local (Webserver)";
$GLOBALS['strTypeWebMode'] = "Método de almacenamiento";
$GLOBALS['strTypeWebModeLocal'] = "Directorio local";
$GLOBALS['strTypeWebModeFtp'] = "Servidor FTP externo";
$GLOBALS['strTypeWebDir'] = "Directorio local";
$GLOBALS['strTypeFTPHost'] = "Host FTP";
$GLOBALS['strTypeFTPDirectory'] = "Directorio del host";
$GLOBALS['strTypeFTPUsername'] = "Iniciar sesión";
$GLOBALS['strTypeFTPPassword'] = "Contraseña";
$GLOBALS['strTypeFTPErrorUpload'] = "No se pudo subir el archivo al Servidor FTP, verífique que el directorio en el servidor tiene los permisos correctos";



$GLOBALS['strGlobalDefaultBannerUrl'] = "URL de la imagen del banner global por defecto";
$GLOBALS['strP3PSettings'] = "Políticas de Privacidad P3P";
$GLOBALS['strUseP3P'] = "Usar Politicas P3P";
$GLOBALS['strP3PCompactPolicy'] = "Politica Compacta P3P";
$GLOBALS['strP3PPolicyLocation'] = "Ubicación de Politica P3P";

// General Settings
$GLOBALS['uiEnabled'] = "Habilitar Interface de Usuario ";

// Geotargeting Settings

// Interface Settings
$GLOBALS['strInventory'] = "Inventario";
$GLOBALS['strShowCampaignInfo'] = "Mostrar información extra de la campaña en la página <i>Campañas</i>";
$GLOBALS['strShowBannerInfo'] = "Mostrar información extra del banner en la página <i>Banners</i>";
$GLOBALS['strShowCampaignPreview'] = "Mostrar vista previa de todos los banners en la página <i>Banner</i>";
$GLOBALS['strShowBannerHTML'] = "Mostrar banner actual en lugar del código HTML plano para la vista previa de Banners HTML";
$GLOBALS['strShowBannerPreview'] = "Mostrar la vista previa del banner al principio de las páginas correspondientes al banner";
$GLOBALS['strHideInactive'] = "Esconder inactivos";
$GLOBALS['strGUIShowMatchingBanners'] = "Mostrar banners relacionados en la página <i>Banner Relacionado</i>";
$GLOBALS['strGUIShowParentCampaigns'] = "Mostrar campaña principal en la páginae <i>Banner Relacionado</i>";
$GLOBALS['strStatisticsDefaults'] = "Estadísticas";
$GLOBALS['strBeginOfWeek'] = "Comienzo de la semana";
$GLOBALS['strPercentageDecimals'] = "Cantidad de decimales en los porcentajes";
$GLOBALS['strWeightDefaults'] = "Peso predeterminado";
$GLOBALS['strDefaultBannerWeight'] = "Peso predeterminado del banner";
$GLOBALS['strDefaultCampaignWeight'] = "Peso predeterminado de la campaña";
$GLOBALS['strDefaultBannerWErr'] = "El peso predetermindado del banner debe ser un número entero positivo";
$GLOBALS['strDefaultCampaignWErr'] = "El peso predeterminado de la campaña debe ser un número entero positivo";


// CSV Import Settings
$GLOBALS['strDefaultConversionStatus'] = "Reglas de conversión por defecto";
$GLOBALS['strDefaultConversionType'] = "Reglas de conversión por defecto";

/**
 * @todo remove strBannerSettings if banner is only configurable as a preference
 *       rename // Banner Settings to  // Banner Preferences
 */
// Invocation Settings
$GLOBALS['strAllowedInvocationTypes'] = "Tipos de invocación permitidos";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Opciones de entrega de banners";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Opciones de registro de banners";
$GLOBALS['strReverseLookup'] = "Hacer un reverse lookup de los hostnames de los visitantes cuando no se facilite";
$GLOBALS['strProxyLookup'] = "Intentar determinar la dirección IP real de los visitantes tras un servidor proxy";
$GLOBALS['strIgnoreHosts'] = "No guardar estadísticas para visitantes que usan alguna de las siguientes Ips o hostnames:";
$GLOBALS['strIgnoreUserAgents'] = "<b>No</b> loguear estadísticas de clientes que contengan alguna de las siguientes cadenas en su agente de usuario (una por línea)";
$GLOBALS['strEnforceUserAgents'] = "<b>Sólo</b> loguear estadísticas de clientes con alguna de las siguientes cadenas en su agente de usuario (una por línea)";

// Banner Storage Settings

// Campaign ECPM settings

// Statistics & Maintenance Settings
$GLOBALS['strConversionTracking'] = "Configuración de Conversion Tracking";
$GLOBALS['strEnableConversionTracking'] = "Habilitar Conversion Tracking";
$GLOBALS['strAdminEmailHeaders'] = "Añadir las siguientes cabeceras a cada e-mail enviado por {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Enviar un aviso cuando el número de impresiones restantes sea menos que el especificado aquí";
$GLOBALS['strWarnLimitErr'] = "El límite de aviso debe ser un entero positivo";
$GLOBALS['strWarnAdmin'] = "Enviar un aviso al administrador cada vez que una campaña vaya a expirar";
$GLOBALS['strWarnClient'] = "Enviar un aviso al anunciante cada vez que una campaña vaya a expirar";

// UI Settings
$GLOBALS['strGuiSettings'] = "Opciones de la interfaz de usuario";
$GLOBALS['strGeneralSettings'] = "Configuración General";
$GLOBALS['strAppName'] = "Nombre de la aplicación";
$GLOBALS['strMyHeader'] = "Ubicación del archivo header";
$GLOBALS['strMyFooter'] = "Ubicación del archivo footer";
$GLOBALS['strDashboardSettings'] = "Configuración del Tablero";


$GLOBALS['strGzipContentCompression'] = "Usar GZIP para compresión de contenido";
$GLOBALS['strClientInterface'] = "Interfaz del anunciante";
$GLOBALS['strClientWelcomeEnabled'] = "Habilitar mensaje de bienvenida para el anunciante";
$GLOBALS['strClientWelcomeText'] = "Texto de bienvenida<br />(código HTML permitido)";


// Regenerate Platfor Hash script

// Plugin Settings

/* ------------------------------------------------------- */
/* Unknown (unused?) translations                        */
/* ------------------------------------------------------- */

$GLOBALS['strKeywordRetrieval'] = "Recuperación de Palabra Clave";
$GLOBALS['strBannerRetrieval'] = "Metodo de Recuperación de Banner";
$GLOBALS['strRetrieveRandom'] = "Randomización de Recuperación de banner (predeterminado)";
$GLOBALS['strRetrieveNormalSeq'] = "Recuperación secuencial de banner normal";
$GLOBALS['strWeightSeq'] = "Recuperación secuencial de banner basada en peso";
$GLOBALS['strFullSeq'] = "Recuperación secuencial de banner completa";
$GLOBALS['strUseConditionalKeys'] = "Usar palabra clave condicionales";
$GLOBALS['strUseMultipleKeys'] = "Usar multiples palabras claves";

