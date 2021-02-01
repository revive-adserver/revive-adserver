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
$GLOBALS['strTablesPrefix'] = "Prefijo del nombre de las tablas";
$GLOBALS['strTablesType'] = "Tipo de tablas";

$GLOBALS['strRecoveryRequiredTitle'] = "El intento de actualización ha encontrado errores";
$GLOBALS['strRecoveryRequired'] = "Ha ocurrido un error al procesar la actualización anterior y {$PRODUCT_NAME} necesita intentar recuperar el proceso de actualización. Por favor, haga clic en el botón Recuperar.";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} está actualizado";
$GLOBALS['strOaUpToDate'] = "Su base de datos {$PRODUCT_NAME} y estructura de archivos están usando la versión más reciente, por lo tanto no hace falta realizar una actualización en este momento. Por favor, haga clic en Continuar para proceder al panel de administración de {$PRODUCT_NAME}.";
$GLOBALS['strOaUpToDateCantRemove'] = "Aviso: el archivo de ACTUALIZACIÓN sigue presente en el directorio var. No podemos borrar dicho archivo debido a permisos insuficientes. Por favor, borre este archivo usted mismo.";
$GLOBALS['strErrorWritePermissions'] = "Se han detectado errores de permisos de archivos y deben ser solucionados para poder continuar.<br />Para solucionar los errores en un sistema Linux intente teclear el/los siguiente(s) comando(s).";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod -R a+w %s</i>";
$GLOBALS['strNotWriteable'] = "NO escribible";
$GLOBALS['strDirNotWriteableError'] = "El directorio debe ser escribible";

$GLOBALS['strErrorWritePermissionsWin'] = "La isntalación de Openads necesita que el archivo de configuración se pueda modificar. Al finalizar las modificaciones de configuración, es altamente recomendable mantener un simple acceso de lectura a este archivo, para mayor seguridad. Para más información sobre esto, por favor lea la referencia en la <a href='http://MAX_PRODUCT_DOCSURL' target='_blank'><strong>documentación</strong></a>.</p>";
$GLOBALS['strCheckDocumentation'] = "Para más ayuda, por favor lea la <a href='{$PRODUCT_DOCSURL}'>documentación de {$PRODUCT_NAME}</a>.";
$GLOBALS['strSystemCheckBadPHPConfig'] = "La configuración actual de PHP no cumple con los requisitos de {$PRODUCT_NAME}. Para resolver los problemas, por favor, modifique la configuración en el archivo \"php.ini\".";

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
$GLOBALS['strChooseSection'] = "Elija la sección";
$GLOBALS['strEditConfigNotPossible'] = "No es posible editar todas las configuraciones porque el archivo de configuración está bloqueado por motivos de seguridad. 
   Si desea realizar cambios, puede que necesite desbloquear primero el archivo de configuración para esta instalación.";
$GLOBALS['strEditConfigPossible'] = "Es posible editar todas las configuraciones porque el archivo de configuración no está bloqueado, pero esto podría conducir a problemas de seguridad. 
   Si desea asegurar su sistema, necesitará bloquear el archivo de configuración para esta instalación.";
$GLOBALS['strUnableToWriteConfig'] = "No se puede escribir los cambios al archivo config";
$GLOBALS['strUnableToWritePrefs'] = "Unable to commit preferences to the database";
$GLOBALS['strImageDirLockedDetected'] = "El servidor no puede escribir en el <b>Directorio de Imágenes</b> suministrado. <br>No puede continuar hasta que haya cambiado los permisos del directorio o haya creado otro directorio.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Ajustes de configuración";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Nombre de usuario del administrador";
$GLOBALS['strAdminPassword'] = "Contraseña del administrador";
$GLOBALS['strInvalidUsername'] = "Nombre de usuario incorrecto";
$GLOBALS['strBasicInformation'] = "Información Básica";
$GLOBALS['strAdministratorEmail'] = "Dirección de correo electrónico del administrador";
$GLOBALS['strAdminCheckUpdates'] = "Comprobar automáticamente si hay actualizaciones de producto y alertas de seguridad (Recomendado).";
$GLOBALS['strAdminShareStack'] = "Comparta información técnica con el equipo de OpenX a fin de colaborar con el desarrollo y testeo.";
$GLOBALS['strNovice'] = "Las acciones de eliminación requieren confirmación por seguridad";
$GLOBALS['strUserlogEmail'] = "Grabar todos los e-mails salientes";
$GLOBALS['strEnableDashboard'] = "Habilitar dashboard";
$GLOBALS['strEnableDashboardSyncNotice'] = "Por favor, permita el <a href='account-settings-update.php'>chequeo de actualizaciones</a> si desea usar el Tablero.";
$GLOBALS['strTimezone'] = "Zona horaria";
$GLOBALS['strEnableAutoMaintenance'] = "Ejecutar automáticamente el mantenimiento durante la entrega si el mantenimiento programado no está activo";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Configuración de Base de Datos";
$GLOBALS['strDatabaseServer'] = "Opciones globales del servidor de base de datos";
$GLOBALS['strDbLocal'] = "Usar como conexión socket local";
$GLOBALS['strDbType'] = "Tipo de base de datos";
$GLOBALS['strDbHost'] = "Nombre de host de la base de datos";
$GLOBALS['strDbSocket'] = "Socket de Base de Datos";
$GLOBALS['strDbPort'] = "Número de puerto de la base de datos";
$GLOBALS['strDbUser'] = "Nombre de usuario de la base de datos";
$GLOBALS['strDbPassword'] = "Contraseña de la base de datos";
$GLOBALS['strDbName'] = "Nombre de la base de datos";
$GLOBALS['strDbNameHint'] = "La Base de datos será creada si no existe";
$GLOBALS['strDatabaseOptimalisations'] = "Opciones de optimización de la base de datos";
$GLOBALS['strPersistentConnections'] = "Usar conexiones persistentes";
$GLOBALS['strCantConnectToDb'] = "No se puede conectar a la base de datos";
$GLOBALS['strCantConnectToDbDelivery'] = 'No se puede conectar con la base de datos para la entrega de avisos';

// Email Settings
$GLOBALS['strEmailSettings'] = "Configuración del correo electrónico";
$GLOBALS['strEmailAddresses'] = "Email 'From' Address";
$GLOBALS['strEmailFromName'] = "Email 'From' Name";
$GLOBALS['strEmailFromAddress'] = "Email 'From' Email Address";
$GLOBALS['strEmailFromCompany'] = "Compañía del Emisor";
$GLOBALS['strUseManagerDetails'] = 'Use the owning account\'s Contact, Email and Name instead of the above Name, Email Address and Company when emailing reports to Advertiser or Website accounts.';
$GLOBALS['strQmailPatch'] = "parche qmail";
$GLOBALS['strEnableQmailPatch'] = "Enable qmail patch";
$GLOBALS['strEmailHeader'] = "Encabezados de correo";
$GLOBALS['strEmailLog'] = "Registro de correo electrónico";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Log Audit";
$GLOBALS['strEnableAudit'] = "Habilitar Registro De Auditoría";
$GLOBALS['strEnableAuditForZoneLinking'] = "Enable Audit Trail for Zone Linking screen (introduces huge performance penalty when linking large amounts of zones)";

// Debug Logging Settings
$GLOBALS['strDebug'] = "Debug Logging Settings";
$GLOBALS['strEnableDebug'] = "Enable Debug Logging";
$GLOBALS['strDebugMethodNames'] = "Incluyen nombres de métodos en el registro de depuración";
$GLOBALS['strDebugLineNumbers'] = "Incluir números de línea en el registro de depuración";
$GLOBALS['strDebugType'] = "Tipo de Registro de Depuración";
$GLOBALS['strDebugTypeFile'] = "Archivo";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "Base de datos SQL";
$GLOBALS['strDebugTypeSyslog'] = "Syslog";
$GLOBALS['strDebugName'] = "Debug Log Name, Calendar, SQL Table,<br />or Syslog Facility";
$GLOBALS['strDebugPriority'] = "Debug Priority Level";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Most Information";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Default Information";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - Least Information";
$GLOBALS['strDebugIdent'] = "Debug Identification String";
$GLOBALS['strDebugUsername'] = "mCal, SQL Server Username";
$GLOBALS['strDebugPassword'] = "mCal, SQL Server Password";
$GLOBALS['strProductionSystem'] = "Sistema de Producción";

// Delivery Settings
$GLOBALS['strWebPath'] = "{$PRODUCT_NAME} Server Access Paths";
$GLOBALS['strWebPathSimple'] = "Web path";
$GLOBALS['strDeliveryPath'] = "Delivery path";
$GLOBALS['strImagePath'] = "Images path";
$GLOBALS['strDeliverySslPath'] = "Delivery SSL path";
$GLOBALS['strImageSslPath'] = "Images SSL path";
$GLOBALS['strImageStore'] = "Carpeta de imágenes";
$GLOBALS['strTypeWebSettings'] = "Configuración de banner local (Webserver)";
$GLOBALS['strTypeWebMode'] = "Método de almacenamiento";
$GLOBALS['strTypeWebModeLocal'] = "Directorio local";
$GLOBALS['strTypeDirError'] = "El directorio local no puede ser escrito por el servidor web";
$GLOBALS['strTypeWebModeFtp'] = "Servidor FTP externo";
$GLOBALS['strTypeWebDir'] = "Directorio local";
$GLOBALS['strTypeFTPHost'] = "Host FTP";
$GLOBALS['strTypeFTPDirectory'] = "Directorio del host";
$GLOBALS['strTypeFTPUsername'] = "Iniciar sesión";
$GLOBALS['strTypeFTPPassword'] = "Contraseña";
$GLOBALS['strTypeFTPPassive'] = "Usar FTP pasivo";
$GLOBALS['strTypeFTPErrorDir'] = "No existe el directorio FTP Host";
$GLOBALS['strTypeFTPErrorConnect'] = "No se pudo conectar al servidor FTP, el usuario o la contraseña no es correcta";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Su instalación de PHP no soporta FTP.";
$GLOBALS['strTypeFTPErrorUpload'] = "No se pudo subir el archivo al Servidor FTP, verífique que el directorio en el servidor tiene los permisos correctos";
$GLOBALS['strTypeFTPErrorHost'] = "El FTP Host no es correcto";
$GLOBALS['strDeliveryFilenames'] = "Nombres de Archivo de Entrega";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Ad Click";
$GLOBALS['strDeliveryFilenamesSignedAdClick'] = "Signed Ad Click";
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
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "XML RPC Invocation";
$GLOBALS['strDeliveryFilenamesLocal'] = "Local Invocation";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Front Controller";
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "Single Page Call";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "Single Page Call (JavaScript)";
$GLOBALS['strDeliveryFilenamesAsyncJS'] = "Async JavaScript (source file)";
$GLOBALS['strDeliveryFilenamesAsyncPHP'] = "Async JavaScript";
$GLOBALS['strDeliveryFilenamesAsyncSPC'] = "Async JavaScript Single Page Call";
$GLOBALS['strDeliveryCaching'] = "Banner Delivery Cache Settings";
$GLOBALS['strDeliveryCacheLimit'] = "Time Between Banner Cache Updates (seconds)";
$GLOBALS['strDeliveryCacheStore'] = "Banner Delivery Cache Store Type";
$GLOBALS['strDeliveryAcls'] = "Evaluate banner delivery rules during delivery";
$GLOBALS['strDeliveryAclsDirectSelection'] = "Evaluate banner delivery rules for direct selected ads";
$GLOBALS['strDeliveryObfuscate'] = "Obfuscate delivery rule set when delivering ads";
$GLOBALS['strDeliveryCtDelimiter'] = "3rd Party Click Tracking Delimiter";
$GLOBALS['strGlobalDefaultBannerUrl'] = "URL de la imagen del banner global por defecto";
$GLOBALS['strGlobalDefaultBannerInvalidZone'] = "Global default HTML Banner for non-existing zones";
$GLOBALS['strGlobalDefaultBannerSuspendedAccount'] = "Global default HTML Banner for suspended accounts";
$GLOBALS['strGlobalDefaultBannerInactiveAccount'] = "Global default HTML Banner for inactive accounts";
$GLOBALS['strP3PSettings'] = "Políticas de Privacidad P3P";
$GLOBALS['strUseP3P'] = "Usar Politicas P3P";
$GLOBALS['strP3PCompactPolicy'] = "Politica Compacta P3P";
$GLOBALS['strP3PPolicyLocation'] = "Ubicación de Politica P3P";
$GLOBALS['strPrivacySettings'] = "Privacy Settings";
$GLOBALS['strDisableViewerId'] = "Disable unique Viewer Id cookie";
$GLOBALS['strAnonymiseIp'] = "Anonymise viewer IP addresses";

// General Settings
$GLOBALS['generalSettings'] = "Global General System Settings";
$GLOBALS['uiEnabled'] = "Habilitar Interface de Usuario ";
$GLOBALS['defaultLanguage'] = "Default System Language<br />(Each user can select their own language)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Geotargeting Settings";
$GLOBALS['strGeotargeting'] = "Geotargeting Settings";
$GLOBALS['strGeotargetingType'] = "Geotargeting Module Type";
$GLOBALS['strGeoShowUnavailable'] = "Show geotargeting delivery rules even if GeoIP data unavailable";

// Interface Settings
$GLOBALS['strInventory'] = "Inventario";
$GLOBALS['strShowCampaignInfo'] = "Mostrar información extra de la campaña en la página <i>Campañas</i>";
$GLOBALS['strShowBannerInfo'] = "Mostrar información extra del banner en la página <i>Banners</i>";
$GLOBALS['strShowCampaignPreview'] = "Mostrar vista previa de todos los banners en la página <i>Banner</i>";
$GLOBALS['strShowBannerHTML'] = "Mostrar banner actual en lugar del código HTML plano para la vista previa de Banners HTML";
$GLOBALS['strShowBannerPreview'] = "Mostrar la vista previa del banner al principio de las páginas correspondientes al banner";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "Use the WYSIWYG HTML Editor by default when creating or editing HTML banners";
$GLOBALS['strHideInactive'] = "Esconder inactivos";
$GLOBALS['strGUIShowMatchingBanners'] = "Mostrar banners relacionados en la página <i>Banner Relacionado</i>";
$GLOBALS['strGUIShowParentCampaigns'] = "Mostrar campaña principal en la páginae <i>Banner Relacionado</i>";
$GLOBALS['strShowEntityId'] = "Show entity identifiers";
$GLOBALS['strStatisticsDefaults'] = "Estadísticas";
$GLOBALS['strBeginOfWeek'] = "Comienzo de la semana";
$GLOBALS['strPercentageDecimals'] = "Cantidad de decimales en los porcentajes";
$GLOBALS['strWeightDefaults'] = "Peso predeterminado";
$GLOBALS['strDefaultBannerWeight'] = "Peso predeterminado del banner";
$GLOBALS['strDefaultCampaignWeight'] = "Peso predeterminado de la campaña";
$GLOBALS['strConfirmationUI'] = "Confirmation in User Interface";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "Invocation Defaults";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Enable 3rd Party Clicktracking by Default";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Opciones de entrega de banners";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Opciones de registro de banners";
$GLOBALS['strLogAdRequests'] = "Log a request every time a banner is requested";
$GLOBALS['strLogAdImpressions'] = "Log an impression every time a banner is viewed";
$GLOBALS['strLogAdClicks'] = "Log a click every time a viewer clicks on a banner";
$GLOBALS['strReverseLookup'] = "Hacer un reverse lookup de los hostnames de los visitantes cuando no se facilite";
$GLOBALS['strProxyLookup'] = "Intentar determinar la dirección IP real de los visitantes tras un servidor proxy";
$GLOBALS['strPreventLogging'] = "Block Banner Logging Settings";
$GLOBALS['strIgnoreHosts'] = "No guardar estadísticas para visitantes que usan alguna de las siguientes Ips o hostnames:";
$GLOBALS['strIgnoreUserAgents'] = "<b>No</b> loguear estadísticas de clientes que contengan alguna de las siguientes cadenas en su agente de usuario (una por línea)";
$GLOBALS['strEnforceUserAgents'] = "<b>Sólo</b> loguear estadísticas de clientes con alguna de las siguientes cadenas en su agente de usuario (una por línea)";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "Banner Storage Settings";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "Use eCPM optimized priorities instead of remnant-weighted priorities";
$GLOBALS['strEnableContractECPM'] = "Use eCPM optimized priorities instead of standard contract priorities";
$GLOBALS['strEnableECPMfromRemnant'] = "(If you enable this feature all your remnant campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strEnableECPMfromECPM'] = "(If you disable this feature some of your active eCPM campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strInactivatedCampaigns'] = "List of campaigns which became inactive due to the changes in preferences:";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "Maintenance Settings";
$GLOBALS['strConversionTracking'] = "Configuración de Conversion Tracking";
$GLOBALS['strEnableConversionTracking'] = "Habilitar Conversion Tracking";
$GLOBALS['strBlockInactiveBanners'] = "Don't count ad impressions, clicks or re-direct the user to the target URL if the viewer clicks on a banner that is inactive";
$GLOBALS['strBlockAdClicks'] = "Don't count ad clicks if the viewer has clicked on the same ad/zone pair within the specified time (seconds)";
$GLOBALS['strMaintenanceOI'] = "Maintenance Operation Interval (minutes)";
$GLOBALS['strPrioritySettings'] = "Configuración de la prioridad";
$GLOBALS['strPriorityInstantUpdate'] = "Update advertisement priorities immediately when changes made in the UI";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "Intentionally over-deliver Contract Campaigns<br />(% over-delivery)";
$GLOBALS['strDefaultImpConvWindow'] = "Default Ad Impression Conversion Window (seconds)";
$GLOBALS['strDefaultCliConvWindow'] = "Default Ad Click Conversion Window (seconds)";
$GLOBALS['strAdminEmailHeaders'] = "Añadir las siguientes cabeceras a cada e-mail enviado por {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Enviar un aviso cuando el número de impresiones restantes sea menos que el especificado aquí";
$GLOBALS['strWarnLimitDays'] = "Send a warning when the days left are less than specified here";
$GLOBALS['strWarnAdmin'] = "Enviar un aviso al administrador cada vez que una campaña vaya a expirar";
$GLOBALS['strWarnClient'] = "Enviar un aviso al anunciante cada vez que una campaña vaya a expirar";
$GLOBALS['strWarnAgency'] = "Send a warning to the account every time a campaign is almost expired";

// UI Settings
$GLOBALS['strGuiSettings'] = "Opciones de la interfaz de usuario";
$GLOBALS['strGeneralSettings'] = "Configuraci&oacute;n general";
$GLOBALS['strAppName'] = "Nombre de la aplicación";
$GLOBALS['strMyHeader'] = "Ubicación del archivo header";
$GLOBALS['strMyFooter'] = "Ubicación del archivo footer";
$GLOBALS['strDefaultTrackerStatus'] = "Default tracker status";
$GLOBALS['strDefaultTrackerType'] = "Default tracker type";
$GLOBALS['strSSLSettings'] = "Configuración de SSL";
$GLOBALS['requireSSL'] = "Force SSL Access on User Interface";
$GLOBALS['sslPort'] = "SSL Port Used by Web Server";
$GLOBALS['strDashboardSettings'] = "Configuración del Tablero";
$GLOBALS['strMyLogo'] = "Name/URL of custom logo file";
$GLOBALS['strGuiHeaderForegroundColor'] = "Color of the header foreground";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Color of the header background";
$GLOBALS['strGuiActiveTabColor'] = "Color of the active tab";
$GLOBALS['strGuiHeaderTextColor'] = "Color of the text in the header";
$GLOBALS['strGuiSupportLink'] = "Custom URL for 'Support' link in header";
$GLOBALS['strGzipContentCompression'] = "Usar GZIP para compresión de contenido";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "Platform Hash Regenerate";
$GLOBALS['strNewPlatformHash'] = "Your new Platform Hash is:";
$GLOBALS['strPlatformHashInsertingError'] = "Error inserting Platform Hash into database";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "Plugin Settings";
$GLOBALS['strEnableNewPlugins'] = "Enable newly installed plugins";
$GLOBALS['strUseMergedFunctions'] = "Use merged delivery functions file";
