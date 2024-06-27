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
$GLOBALS['strInstall'] = "Instal·la";
$GLOBALS['strDatabaseSettings'] = "Configuració de la base de dades";
$GLOBALS['strAdminAccount'] = "Compte d'administrador del sistema";
$GLOBALS['strAdvancedSettings'] = "Configuració avançada";
$GLOBALS['strWarning'] = "Advertència";
$GLOBALS['strBtnContinue'] = "Continua »";
$GLOBALS['strBtnRecover'] = "Recupera »";
$GLOBALS['strBtnAgree'] = "Hi estic d'acord »";
$GLOBALS['strBtnRetry'] = "Reintenta";
$GLOBALS['strTablesPrefix'] = "Prefix de les taules";
$GLOBALS['strTablesType'] = "Tipus de taula";

$GLOBALS['strRecoveryRequiredTitle'] = "El vostre intent d’actualització anterior ha detectat un error";
$GLOBALS['strRecoveryRequired'] = "";

$GLOBALS['strProductUpToDateTitle'] = "{{PRODUCT_NAME}} està al dia";
$GLOBALS['strOaUpToDate'] = "";
$GLOBALS['strOaUpToDateCantRemove'] = "";
$GLOBALS['strErrorWritePermissions'] = "";
$GLOBALS['strErrorFixPermissionsRCommand'] = "";
$GLOBALS['strNotWriteable'] = "";
$GLOBALS['strDirNotWriteableError'] = "El directori ha de tenir permisos d'escriptura";

$GLOBALS['strErrorWritePermissionsWin'] = "";
$GLOBALS['strCheckDocumentation'] = "";
$GLOBALS['strSystemCheckBadPHPConfig'] = "";

$GLOBALS['strAdminUrlPrefix'] = "";
$GLOBALS['strDeliveryUrlPrefix'] = "";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "";
$GLOBALS['strImagesUrlPrefix'] = "";
$GLOBALS['strImagesUrlPrefixSSL'] = "";


$GLOBALS['strUpgrade'] = "Actualitza";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Escull secció";
$GLOBALS['strEditConfigNotPossible'] = "";
$GLOBALS['strEditConfigPossible'] = "";
$GLOBALS['strUnableToWriteConfig'] = "";
$GLOBALS['strUnableToWritePrefs'] = "";
$GLOBALS['strImageDirLockedDetected'] = "";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Preferències de configuració";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Nom d'usuari administrador";
$GLOBALS['strAdminPassword'] = "Contrasenya d'administrador";
$GLOBALS['strInvalidUsername'] = "Nom d'usuari incorrecte";
$GLOBALS['strBasicInformation'] = "Informació bàsica";
$GLOBALS['strAdministratorEmail'] = "Adreça de correu electrònic de l'administrador/a";
$GLOBALS['strAdminCheckUpdates'] = "";
$GLOBALS['strAdminShareStack'] = "";
$GLOBALS['strNovice'] = "";
$GLOBALS['strUserlogEmail'] = "";
$GLOBALS['strEnableDashboard'] = "Activa el panell";
$GLOBALS['strEnableDashboardSyncNotice'] = "";
$GLOBALS['strTimezone'] = "Fus horari";
$GLOBALS['strEnableAutoMaintenance'] = "";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Configuració de la base de dades";
$GLOBALS['strDatabaseServer'] = "Configuració del servidor de base de dades";
$GLOBALS['strDbLocal'] = "";
$GLOBALS['strDbType'] = "Tipus de base de dades";
$GLOBALS['strDbHost'] = "Amfitrió de la base de dades";
$GLOBALS['strDbSocket'] = "Socket de la base de dades";
$GLOBALS['strDbPort'] = "Port de la base de dades";
$GLOBALS['strDbUser'] = "Usuari de la base de dades";
$GLOBALS['strDbPassword'] = "Contrasenya de la base de dades";
$GLOBALS['strDbName'] = "Nom de la base de dades";
$GLOBALS['strDbNameHint'] = "La base de dades es crearà si no existeix";
$GLOBALS['strDatabaseOptimalisations'] = "Configuració d’optimització de bases de dades";
$GLOBALS['strPersistentConnections'] = "Utilitza una connexió persistent";
$GLOBALS['strCantConnectToDb'] = "No s’ha pogut connectar amb la base de dades";
$GLOBALS['strCantConnectToDbDelivery'] = 'Configuració d’optimització de bases de dades per l\'entrega';

// Email Settings
$GLOBALS['strEmailSettings'] = "Configuració de correu electrònic";
$GLOBALS['strEmailAddresses'] = "";
$GLOBALS['strEmailFromName'] = "";
$GLOBALS['strEmailFromAddress'] = "";
$GLOBALS['strEmailFromCompany'] = "";
$GLOBALS['strUseManagerDetails'] = '';
$GLOBALS['strQmailPatch'] = "";
$GLOBALS['strEnableQmailPatch'] = "";
$GLOBALS['strEmailHeader'] = "Encapçalament dels correus";
$GLOBALS['strEmailLog'] = "";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "";
$GLOBALS['strEnableAudit'] = "";
$GLOBALS['strEnableAuditForZoneLinking'] = "";

// Debug Logging Settings
$GLOBALS['strDebug'] = "";
$GLOBALS['strEnableDebug'] = "";
$GLOBALS['strDebugMethodNames'] = "";
$GLOBALS['strDebugLineNumbers'] = "";
$GLOBALS['strDebugType'] = "";
$GLOBALS['strDebugTypeFile'] = "Fitxer";
$GLOBALS['strDebugTypeMcal'] = "";
$GLOBALS['strDebugTypeSql'] = "Base de dades SQL";
$GLOBALS['strDebugTypeSyslog'] = "";
$GLOBALS['strDebugName'] = "";
$GLOBALS['strDebugPriority'] = "";
$GLOBALS['strPEAR_LOG_DEBUG'] = "";
$GLOBALS['strPEAR_LOG_INFO'] = "";
$GLOBALS['strPEAR_LOG_NOTICE'] = "";
$GLOBALS['strPEAR_LOG_WARNING'] = "";
$GLOBALS['strPEAR_LOG_ERR'] = "";
$GLOBALS['strPEAR_LOG_CRIT'] = "";
$GLOBALS['strPEAR_LOG_ALERT'] = "";
$GLOBALS['strPEAR_LOG_EMERG'] = "";
$GLOBALS['strDebugIdent'] = "";
$GLOBALS['strDebugUsername'] = "";
$GLOBALS['strDebugPassword'] = "";
$GLOBALS['strProductionSystem'] = "Sistema de producció";

// Delivery Settings
$GLOBALS['strWebPath'] = "";
$GLOBALS['strWebPathSimple'] = "";
$GLOBALS['strDeliveryPath'] = "";
$GLOBALS['strImagePath'] = "";
$GLOBALS['strDeliverySslPath'] = "";
$GLOBALS['strImageSslPath'] = "";
$GLOBALS['strImageStore'] = "Carpeta d'imatges";
$GLOBALS['strTypeWebSettings'] = "";
$GLOBALS['strTypeWebMode'] = "Mètode d'emmagatzematge";
$GLOBALS['strTypeWebModeLocal'] = "Directori local";
$GLOBALS['strTypeDirError'] = "";
$GLOBALS['strTypeWebModeFtp'] = "Servidor FTP extern";
$GLOBALS['strTypeWebDir'] = "Directori local";
$GLOBALS['strTypeFTPHost'] = "Amfitrió FTP";
$GLOBALS['strTypeFTPDirectory'] = "";
$GLOBALS['strTypeFTPUsername'] = "Inicia sessió";
$GLOBALS['strTypeFTPPassword'] = "Contrasenya";
$GLOBALS['strTypeFTPPassive'] = "";
$GLOBALS['strTypeFTPErrorDir'] = "";
$GLOBALS['strTypeFTPErrorConnect'] = "";
$GLOBALS['strTypeFTPErrorNoSupport'] = "";
$GLOBALS['strTypeFTPErrorUpload'] = "";
$GLOBALS['strTypeFTPErrorHost'] = "";
$GLOBALS['strDeliveryFilenames'] = "";
$GLOBALS['strDeliveryFilenamesAdClick'] = "";
$GLOBALS['strDeliveryFilenamesSignedAdClick'] = "";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "";
$GLOBALS['strDeliveryFilenamesAdContent'] = "";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "";
$GLOBALS['strDeliveryFilenamesAdImage'] = "";
$GLOBALS['strDeliveryFilenamesAdJS'] = "";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "";
$GLOBALS['strDeliveryFilenamesAdLog'] = "";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "";
$GLOBALS['strDeliveryFilenamesAdView'] = "";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "";
$GLOBALS['strDeliveryFilenamesLocal'] = "";
$GLOBALS['strDeliveryFilenamesFrontController'] = "";
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "";
$GLOBALS['strDeliveryFilenamesAsyncJS'] = "";
$GLOBALS['strDeliveryFilenamesAsyncPHP'] = "";
$GLOBALS['strDeliveryFilenamesAsyncSPC'] = "";
$GLOBALS['strDeliveryCaching'] = "";
$GLOBALS['strDeliveryCacheLimit'] = "";
$GLOBALS['strDeliveryCacheStore'] = "";
$GLOBALS['strDeliveryAcls'] = "";
$GLOBALS['strDeliveryAclsDirectSelection'] = "";
$GLOBALS['strDeliveryObfuscate'] = "";
$GLOBALS['strDeliveryClickUrlValidity'] = "";
$GLOBALS['strDeliveryRelAttribute'] = "";
$GLOBALS['strGlobalDefaultBannerInvalidZone'] = "";
$GLOBALS['strGlobalDefaultBannerSuspendedAccount'] = "";
$GLOBALS['strGlobalDefaultBannerInactiveAccount'] = "";
$GLOBALS['strP3PSettings'] = "";
$GLOBALS['strUseP3P'] = "";
$GLOBALS['strP3PCompactPolicy'] = "";
$GLOBALS['strP3PPolicyLocation'] = "";
$GLOBALS['strPrivacySettings'] = "Configuració de privacitat";
$GLOBALS['strDisableViewerId'] = "";
$GLOBALS['strAnonymiseIp'] = "";

// General Settings
$GLOBALS['generalSettings'] = "";
$GLOBALS['uiEnabled'] = "";
$GLOBALS['defaultLanguage'] = "";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "";
$GLOBALS['strGeotargeting'] = "";
$GLOBALS['strGeotargetingType'] = "";
$GLOBALS['strGeoShowUnavailable'] = "";

// Interface Settings
$GLOBALS['strInventory'] = "Inventari";
$GLOBALS['strShowCampaignInfo'] = "";
$GLOBALS['strShowBannerInfo'] = "";
$GLOBALS['strShowCampaignPreview'] = "";
$GLOBALS['strShowBannerHTML'] = "";
$GLOBALS['strShowBannerPreview'] = "";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "";
$GLOBALS['strHideInactive'] = "Oculta items inactius de totes les pàgines";
$GLOBALS['strGUIShowMatchingBanners'] = "";
$GLOBALS['strGUIShowParentCampaigns'] = "";
$GLOBALS['strShowEntityId'] = "";
$GLOBALS['strStatisticsDefaults'] = "Estadístiques";
$GLOBALS['strBeginOfWeek'] = "Inici de setmana";
$GLOBALS['strPercentageDecimals'] = "";
$GLOBALS['strWeightDefaults'] = "Pes per defecte";
$GLOBALS['strDefaultBannerWeight'] = "Pes per defecte del bàner";
$GLOBALS['strDefaultCampaignWeight'] = "Pes per defecte de la campanya";
$GLOBALS['strConfirmationUI'] = "";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "";
$GLOBALS['strLogAdRequests'] = "";
$GLOBALS['strLogAdImpressions'] = "";
$GLOBALS['strLogAdClicks'] = "";
$GLOBALS['strReverseLookup'] = "";
$GLOBALS['strProxyLookup'] = "";
$GLOBALS['strPreventLogging'] = "";
$GLOBALS['strIgnoreHosts'] = "";
$GLOBALS['strIgnoreUserAgents'] = "";
$GLOBALS['strEnforceUserAgents'] = "";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "Configuració de l'emmagatzematge de bàners";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "";
$GLOBALS['strEnableContractECPM'] = "";
$GLOBALS['strEnableECPMfromRemnant'] = "";
$GLOBALS['strEnableECPMfromECPM'] = "";
$GLOBALS['strInactivatedCampaigns'] = "";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "Configuració de manteniment";
$GLOBALS['strConversionTracking'] = "";
$GLOBALS['strEnableConversionTracking'] = "";
$GLOBALS['strBlockInactiveBanners'] = "";
$GLOBALS['strBlockAdClicks'] = "";
$GLOBALS['strMaintenanceOI'] = "";
$GLOBALS['strPrioritySettings'] = "Configuració de prioritat";
$GLOBALS['strPriorityInstantUpdate'] = "";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "";
$GLOBALS['strDefaultImpConvWindow'] = "";
$GLOBALS['strDefaultCliConvWindow'] = "";
$GLOBALS['strAdminEmailHeaders'] = "";
$GLOBALS['strWarnLimit'] = "";
$GLOBALS['strWarnLimitDays'] = "";
$GLOBALS['strWarnAdmin'] = "";
$GLOBALS['strWarnClient'] = "";
$GLOBALS['strWarnAgency'] = "";

// UI Settings
$GLOBALS['strGuiSettings'] = "";
$GLOBALS['strGeneralSettings'] = "Configuració General";
$GLOBALS['strAppName'] = "Nom de l'aplicació";
$GLOBALS['strMyHeader'] = "";
$GLOBALS['strMyFooter'] = "";
$GLOBALS['strDefaultTrackerStatus'] = "";
$GLOBALS['strDefaultTrackerType'] = "";
$GLOBALS['strSSLSettings'] = "Configuració SSL";
$GLOBALS['requireSSL'] = "";
$GLOBALS['sslPort'] = "";
$GLOBALS['strDashboardSettings'] = "Configuració del panell";
$GLOBALS['strMyLogo'] = "";
$GLOBALS['strGuiHeaderForegroundColor'] = "";
$GLOBALS['strGuiHeaderBackgroundColor'] = "";
$GLOBALS['strGuiActiveTabColor'] = "Color de la pestanya activa";
$GLOBALS['strGuiHeaderTextColor'] = "";
$GLOBALS['strGuiSupportLink'] = "";
$GLOBALS['strGzipContentCompression'] = "";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "";
$GLOBALS['strNewPlatformHash'] = "";
$GLOBALS['strPlatformHashInsertingError'] = "";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "Configuració del plugin";
$GLOBALS['strEnableNewPlugins'] = "";
$GLOBALS['strUseMergedFunctions'] = "";
