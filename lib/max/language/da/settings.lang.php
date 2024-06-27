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
$GLOBALS['strInstall'] = "Installer";
$GLOBALS['strDatabaseSettings'] = "Database opsætning";
$GLOBALS['strAdminAccount'] = "Administrator konto";
$GLOBALS['strAdvancedSettings'] = "Avanceret opsætning";
$GLOBALS['strWarning'] = "Advarsel";
$GLOBALS['strBtnContinue'] = "Fortsæt »";
$GLOBALS['strBtnRecover'] = "Genskab »";
$GLOBALS['strBtnAgree'] = "Jeg acceptere »";
$GLOBALS['strBtnRetry'] = "Forsøg igen";
$GLOBALS['strTablesPrefix'] = "Tabel navne prefix";
$GLOBALS['strTablesType'] = "Tabel type";

$GLOBALS['strRecoveryRequiredTitle'] = "Dit tidligere forsøg på at upgradere udløste en fejl";
$GLOBALS['strRecoveryRequired'] = "Der var en fejl under behandlingen af din tidligere opdatering og {{PRODUCT_NAME}} skal forsøge at genskabe opgraderings processen. Venligst klik på Genskab knappen herunder.";

$GLOBALS['strProductUpToDateTitle'] = "";
$GLOBALS['strOaUpToDate'] = "Din {{PRODUCT_NAME}} database og filstrktur bruger begge den nyeste version of derfor er det ikke nødvendig med at opdatere på dette tidspunkt. Venligst klik 'Fortsæt' for at komme videre til OpenX administrations panelet.";
$GLOBALS['strOaUpToDateCantRemove'] = "Advarsel: UPGRADE filen er stadig inde i din var folder. Vi kan ikke fjerne denne fil på grund af manglede adgang og tilladelse. Venligst slet denne fil selv.";
$GLOBALS['strErrorWritePermissions'] = "Der er fundet nogle fil adgangs fejl, og disse skal repareres inden du kan fortsætte.<br />For at reparere fejlene på en Linux system, prøv at skrive følgende kommando(er):";
$GLOBALS['strErrorFixPermissionsRCommand'] = "";
$GLOBALS['strNotWriteable'] = "";
$GLOBALS['strDirNotWriteableError'] = "";

$GLOBALS['strErrorWritePermissionsWin'] = "Der er fundet nogle fil adgangs fejl, og disse skal repareres inden du kan fortsætte";
$GLOBALS['strCheckDocumentation'] = "For mere hjælp se <a href='http://{{PRODUCT_DOCSURL}}'>{{PRODUCT_NAME}} documentation</a>.";
$GLOBALS['strSystemCheckBadPHPConfig'] = "";

$GLOBALS['strAdminUrlPrefix'] = "Administrator interface URL";
$GLOBALS['strDeliveryUrlPrefix'] = "";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "";
$GLOBALS['strImagesUrlPrefix'] = "";
$GLOBALS['strImagesUrlPrefixSSL'] = "";


$GLOBALS['strUpgrade'] = "";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Vælg sektion";
$GLOBALS['strEditConfigNotPossible'] = "";
$GLOBALS['strEditConfigPossible'] = "";
$GLOBALS['strUnableToWriteConfig'] = "Ude af stand til at skrive ændringer til config filen";
$GLOBALS['strUnableToWritePrefs'] = "Ude af stand til at binde referencer til databasen";
$GLOBALS['strImageDirLockedDetected'] = "Den leverede <b>Billede Mappe</b> er ikke skrivebar af serveren. <br>Du kan ikke fortsætte indtil du enten ændrer adgangstilladdelse til mappen eller opretter mappen.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Administrator  brugernavn";
$GLOBALS['strAdminPassword'] = "Administrator  password";
$GLOBALS['strInvalidUsername'] = "Ugyldig brugernavn";
$GLOBALS['strBasicInformation'] = "Basis information";
$GLOBALS['strAdministratorEmail'] = "Administrators email adresse";
$GLOBALS['strAdminCheckUpdates'] = "";
$GLOBALS['strAdminShareStack'] = "";
$GLOBALS['strNovice'] = "";
$GLOBALS['strUserlogEmail'] = "Log alle udgående email beskeder";
$GLOBALS['strEnableDashboard'] = "";
$GLOBALS['strEnableDashboardSyncNotice'] = "";
$GLOBALS['strTimezone'] = "Tidszone";
$GLOBALS['strEnableAutoMaintenance'] = "Automatisk udfør vedligeholdelse under levering if planlagt vedligehold ikke er sat op";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Database opsætning";
$GLOBALS['strDatabaseServer'] = "Global database server opsætninger";
$GLOBALS['strDbLocal'] = "";
$GLOBALS['strDbType'] = "Database type";
$GLOBALS['strDbHost'] = "Database host navn";
$GLOBALS['strDbSocket'] = "";
$GLOBALS['strDbPort'] = "Database port nummer";
$GLOBALS['strDbUser'] = "Database bruger navn";
$GLOBALS['strDbPassword'] = "Database password";
$GLOBALS['strDbName'] = "Database navn";
$GLOBALS['strDbNameHint'] = "";
$GLOBALS['strDatabaseOptimalisations'] = "Database optimiserings opsætning";
$GLOBALS['strPersistentConnections'] = "Brug Persistent tilslutning";
$GLOBALS['strCantConnectToDb'] = "Kan ikke tilslutte til databasen";
$GLOBALS['strCantConnectToDbDelivery'] = '';

// Email Settings
$GLOBALS['strEmailSettings'] = "Email Indstillinger";
$GLOBALS['strEmailAddresses'] = "";
$GLOBALS['strEmailFromName'] = "";
$GLOBALS['strEmailFromAddress'] = "";
$GLOBALS['strEmailFromCompany'] = "";
$GLOBALS['strUseManagerDetails'] = '';
$GLOBALS['strQmailPatch'] = "";
$GLOBALS['strEnableQmailPatch'] = "";
$GLOBALS['strEmailHeader'] = "Email Titel";
$GLOBALS['strEmailLog'] = "Email Log";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Handlings Log Indstillinger";
$GLOBALS['strEnableAudit'] = "Aktiver Handlings Log";
$GLOBALS['strEnableAuditForZoneLinking'] = "";

// Debug Logging Settings
$GLOBALS['strDebug'] = "Opsætning af debug logning";
$GLOBALS['strEnableDebug'] = "Tillad debug logning";
$GLOBALS['strDebugMethodNames'] = "Inkluder metode navn i debug loggen";
$GLOBALS['strDebugLineNumbers'] = "Inkluder linie nummer i degub loggen";
$GLOBALS['strDebugType'] = "Debug log type";
$GLOBALS['strDebugTypeFile'] = "Fil";
$GLOBALS['strDebugTypeMcal'] = "";
$GLOBALS['strDebugTypeSql'] = "SQL database";
$GLOBALS['strDebugTypeSyslog'] = "";
$GLOBALS['strDebugName'] = "Debug log navn, kalender, SQL tabel,<br />eller Syslog funktion";
$GLOBALS['strDebugPriority'] = "Debug prioritets niveau";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Informations majoriteten";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Standard information";
$GLOBALS['strPEAR_LOG_NOTICE'] = "";
$GLOBALS['strPEAR_LOG_WARNING'] = "";
$GLOBALS['strPEAR_LOG_ERR'] = "";
$GLOBALS['strPEAR_LOG_CRIT'] = "";
$GLOBALS['strPEAR_LOG_ALERT'] = "";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_DEBUG - Informations majoriteten";
$GLOBALS['strDebugIdent'] = "Debug identifikations streng";
$GLOBALS['strDebugUsername'] = "mCal, SQL Server brugernavn";
$GLOBALS['strDebugPassword'] = "mCal, SQL Server kodeord";
$GLOBALS['strProductionSystem'] = "";

// Delivery Settings
$GLOBALS['strWebPath'] = "";
$GLOBALS['strWebPathSimple'] = "Web sti";
$GLOBALS['strDeliveryPath'] = "Cache levering";
$GLOBALS['strImagePath'] = "";
$GLOBALS['strDeliverySslPath'] = "Cache levering";
$GLOBALS['strImageSslPath'] = "";
$GLOBALS['strImageStore'] = "";
$GLOBALS['strTypeWebSettings'] = "";
$GLOBALS['strTypeWebMode'] = "";
$GLOBALS['strTypeWebModeLocal'] = "";
$GLOBALS['strTypeDirError'] = "";
$GLOBALS['strTypeWebModeFtp'] = "";
$GLOBALS['strTypeWebDir'] = "";
$GLOBALS['strTypeFTPHost'] = "";
$GLOBALS['strTypeFTPDirectory'] = "";
$GLOBALS['strTypeFTPUsername'] = "Log ind";
$GLOBALS['strTypeFTPPassword'] = "Kodeord";
$GLOBALS['strTypeFTPPassive'] = "";
$GLOBALS['strTypeFTPErrorDir'] = "";
$GLOBALS['strTypeFTPErrorConnect'] = "";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Din PHP installation understøtter ikke FTP.";
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
$GLOBALS['strDeliveryFilenamesAdImage'] = "Tilføj Billede";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Tilføj (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Tilføj Layer";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Tilføj Log";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Tilføj Popup";
$GLOBALS['strDeliveryFilenamesAdView'] = "";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "";
$GLOBALS['strDeliveryFilenamesLocal'] = "Lokal Invocation";
$GLOBALS['strDeliveryFilenamesFrontController'] = "";
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "";
$GLOBALS['strDeliveryFilenamesAsyncJS'] = "";
$GLOBALS['strDeliveryFilenamesAsyncPHP'] = "";
$GLOBALS['strDeliveryFilenamesAsyncSPC'] = "";
$GLOBALS['strDeliveryCaching'] = "Banner Levering Cache Indstillinger";
$GLOBALS['strDeliveryCacheLimit'] = "Tid imellem Banner Cache Updatering (sekunder)";
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
$GLOBALS['strPrivacySettings'] = "";
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
$GLOBALS['strInventory'] = "Portfolio";
$GLOBALS['strShowCampaignInfo'] = "";
$GLOBALS['strShowBannerInfo'] = "";
$GLOBALS['strShowCampaignPreview'] = "";
$GLOBALS['strShowBannerHTML'] = "";
$GLOBALS['strShowBannerPreview'] = "";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "";
$GLOBALS['strHideInactive'] = "";
$GLOBALS['strGUIShowMatchingBanners'] = "";
$GLOBALS['strGUIShowParentCampaigns'] = "";
$GLOBALS['strShowEntityId'] = "";
$GLOBALS['strStatisticsDefaults'] = "Statistikker";
$GLOBALS['strBeginOfWeek'] = "";
$GLOBALS['strPercentageDecimals'] = "";
$GLOBALS['strWeightDefaults'] = "";
$GLOBALS['strDefaultBannerWeight'] = "";
$GLOBALS['strDefaultCampaignWeight'] = "";
$GLOBALS['strConfirmationUI'] = "Bekræftigelse for Bruger Grænseflade";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Banner Leverings Indstillinger";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Banner Log Indstillinger";
$GLOBALS['strLogAdRequests'] = "";
$GLOBALS['strLogAdImpressions'] = "";
$GLOBALS['strLogAdClicks'] = "";
$GLOBALS['strReverseLookup'] = "";
$GLOBALS['strProxyLookup'] = "";
$GLOBALS['strPreventLogging'] = "Banner Log Indstillinger";
$GLOBALS['strIgnoreHosts'] = "";
$GLOBALS['strIgnoreUserAgents'] = "";
$GLOBALS['strEnforceUserAgents'] = "";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "Indstillinger for Banner Lagring";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "";
$GLOBALS['strEnableContractECPM'] = "";
$GLOBALS['strEnableECPMfromRemnant'] = "";
$GLOBALS['strEnableECPMfromECPM'] = "";
$GLOBALS['strInactivatedCampaigns'] = "";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "Vedligeholdelses Indstillinger";
$GLOBALS['strConversionTracking'] = "";
$GLOBALS['strEnableConversionTracking'] = "";
$GLOBALS['strBlockInactiveBanners'] = "";
$GLOBALS['strBlockAdClicks'] = "";
$GLOBALS['strMaintenanceOI'] = "";
$GLOBALS['strPrioritySettings'] = "";
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
$GLOBALS['strGeneralSettings'] = "Generel opsætninger";
$GLOBALS['strAppName'] = "";
$GLOBALS['strMyHeader'] = "";
$GLOBALS['strMyFooter'] = "";
$GLOBALS['strDefaultTrackerStatus'] = "";
$GLOBALS['strDefaultTrackerType'] = "";
$GLOBALS['strSSLSettings'] = "SSL Indstillinger";
$GLOBALS['requireSSL'] = "Tving SSL adgang i Bruger Grænseflade";
$GLOBALS['sslPort'] = "SSL Port Brugt af Web Server";
$GLOBALS['strDashboardSettings'] = "";
$GLOBALS['strMyLogo'] = "";
$GLOBALS['strGuiHeaderForegroundColor'] = "";
$GLOBALS['strGuiHeaderBackgroundColor'] = "";
$GLOBALS['strGuiActiveTabColor'] = "";
$GLOBALS['strGuiHeaderTextColor'] = "";
$GLOBALS['strGuiSupportLink'] = "";
$GLOBALS['strGzipContentCompression'] = "";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "";
$GLOBALS['strNewPlatformHash'] = "";
$GLOBALS['strPlatformHashInsertingError'] = "";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "";
$GLOBALS['strEnableNewPlugins'] = "";
$GLOBALS['strUseMergedFunctions'] = "";
