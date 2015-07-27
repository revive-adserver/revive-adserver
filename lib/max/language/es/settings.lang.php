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
$GLOBALS['strAdminAccount'] = "Cuenta de Administrador";
$GLOBALS['strAdvancedSettings'] = "Configuración avanzada";
$GLOBALS['strWarning'] = "Advertencia";
$GLOBALS['strBtnContinue'] = "Continuar »";
$GLOBALS['strBtnRecover'] = "Recuperar »";
$GLOBALS['strBtnAgree'] = "Acepto »";
$GLOBALS['strBtnRetry'] = "Reintentar";
$GLOBALS['strWarningRegisterArgcArv'] = "La variable de configuración de PHP register_argc_argv necesita estar activa para ejecutar el mantenimiento desde la línea de comandos.";
$GLOBALS['strTablesType'] = "Tipo de tablas";

$GLOBALS['strRecoveryRequiredTitle'] = "El intento de actualización ha encontrado errores";
$GLOBALS['strRecoveryRequired'] = "Ha ocurrido un error al procesar la actualización anterior y {$PRODUCT_NAME} necesita intentar recuperar el proceso de actualización. Por favor, haga clic en el botón Recuperar.";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} está actualizado";
$GLOBALS['strOaUpToDate'] = "Su base de datos {$PRODUCT_NAME} y estructura de archivos están usando la versión más reciente, por lo tanto no hace falta realizar una actualización en este momento. Por favor, haga clic en Continuar para proceder al panel de administración de {$PRODUCT_NAME}.";
$GLOBALS['strOaUpToDateCantRemove'] = "Aviso: el archivo de ACTUALIZACIÓN sigue presente en el directorio var. No podemos borrar dicho archivo debido a permisos insuficientes. Por favor, borre este archivo usted mismo.";
$GLOBALS['strErrorWritePermissions'] = "Se han detectado errores de permisos de archivos y deben ser solucionados para poder continuar.<br />Para solucionar los errores en un sistema Linux intente teclear el/los siguiente(s) comando(s).";

$GLOBALS['strErrorWritePermissionsWin'] = "La isntalación de Openads necesita que el archivo de configuración se pueda modificar. Al finalizar las modificaciones de configuración, es altamente recomendable mantener un simple acceso de lectura a este archivo, para mayor seguridad. Para más información sobre esto, por favor lea la referencia en la <a href='http://MAX_PRODUCT_DOCSURL' target='_blank'><strong>documentación</strong></a>.</p>";
$GLOBALS['strCheckDocumentation'] = "Para más ayuda, por favor lea la <a href='{$PRODUCT_DOCSURL}'>documentación de {$PRODUCT_NAME}</a>.";

$GLOBALS['strAdminUrlPrefix'] = "URL de la Interfaz de Administración";
$GLOBALS['strDeliveryUrlPrefix'] = "URL del Motor de Entrega";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL motor de entrega (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL de almacenamiento de imagen";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL de almacenamiento de imagen (SSL)";


$GLOBALS['strUpgrade'] = "Actualización";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Elija la Sección";
$GLOBALS['strImageDirLockedDetected'] = "El servidor no puede escribir en el <b>Directorio de Imágenes</b> suministrado. <br>No puede continuar hasta que haya cambiado los permisos del directorio o haya creado otro directorio.";

// Configuration Settings

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Nombre de usuario del administrador";
$GLOBALS['strInvalidUsername'] = "Nombre de usuario incorrecto";
$GLOBALS['strBasicInformation'] = "Información Básica";
$GLOBALS['strAdminCheckUpdates'] = "Comprobar automáticamente si hay actualizaciones de producto y alertas de seguridad (Recomendado).";
$GLOBALS['strAdminShareStack'] = "Comparta información técnica con el equipo de OpenX a fin de colaborar con el desarrollo y testeo.";
$GLOBALS['strUserlogEmail'] = "Grabar todos los e-mails salientes";
$GLOBALS['strEnableDashboardSyncNotice'] = "Por favor, permita el <a href='account-settings-update.php'>chequeo de actualizaciones</a> si desea usar el Tablero.";
$GLOBALS['strTimezone'] = "Zona horaria";
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
$GLOBALS['strDebugTypeFile'] = "Archivo";
$GLOBALS['strDebugTypeSql'] = "Base de datos SQL";
$GLOBALS['strDebugTypeSyslog'] = "Syslog";
$GLOBALS['strProductionSystem'] = "Sistema de Producción";

// Delivery Settings
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

// Invocation Settings

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
$GLOBALS['strPrioritySettings'] = "Configuración de la prioridad";
$GLOBALS['strAdminEmailHeaders'] = "Añadir las siguientes cabeceras a cada e-mail enviado por {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Enviar un aviso cuando el número de impresiones restantes sea menos que el especificado aquí";
$GLOBALS['strWarnAdmin'] = "Enviar un aviso al administrador cada vez que una campaña vaya a expirar";
$GLOBALS['strWarnClient'] = "Enviar un aviso al anunciante cada vez que una campaña vaya a expirar";

// UI Settings
$GLOBALS['strGuiSettings'] = "Opciones de la interfaz de usuario";
$GLOBALS['strGeneralSettings'] = "Configuración General";
$GLOBALS['strAppName'] = "Nombre de la aplicación";
$GLOBALS['strMyHeader'] = "Ubicación del archivo header";
$GLOBALS['strMyFooter'] = "Ubicación del archivo footer";
$GLOBALS['strSSLSettings'] = "Configuración de SSL";
$GLOBALS['strDashboardSettings'] = "Configuración del Tablero";
$GLOBALS['strGzipContentCompression'] = "Usar GZIP para compresión de contenido";

// Regenerate Platfor Hash script

// Plugin Settings
