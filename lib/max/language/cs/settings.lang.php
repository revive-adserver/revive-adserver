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
$GLOBALS['strInstall'] = "Instalace";
$GLOBALS['strDatabaseSettings'] = "Nastavení databáze";
$GLOBALS['strAdminAccount'] = "Účet správce systému";
$GLOBALS['strAdvancedSettings'] = "Rozsirena nastaveni databaze";
$GLOBALS['strWarning'] = "Varování";
$GLOBALS['strBtnContinue'] = "Pokračovat»";
$GLOBALS['strBtnRecover'] = "Obnovit»";
$GLOBALS['strBtnAgree'] = "Souhlasím»";
$GLOBALS['strBtnRetry'] = "Opakovat";
$GLOBALS['strTablesPrefix'] = "Prefix názvů tabulek";
$GLOBALS['strTablesType'] = "Typ tabulky";

$GLOBALS['strRecoveryRequiredTitle'] = "Váš předchozí pokus o upgrade zjistil chybu";
$GLOBALS['strRecoveryRequired'] = "";

$GLOBALS['strProductUpToDateTitle'] = "";
$GLOBALS['strOaUpToDate'] = "";
$GLOBALS['strOaUpToDateCantRemove'] = "";
$GLOBALS['strErrorWritePermissions'] = "";
$GLOBALS['strErrorFixPermissionsRCommand'] = "";
$GLOBALS['strNotWriteable'] = "NELZE zapisovat";
$GLOBALS['strDirNotWriteableError'] = "Adresář musí být zapisovatelný";

$GLOBALS['strErrorWritePermissionsWin'] = "";
$GLOBALS['strCheckDocumentation'] = "";
$GLOBALS['strSystemCheckBadPHPConfig'] = "";

$GLOBALS['strAdminUrlPrefix'] = "URL admin rozhraní";
$GLOBALS['strDeliveryUrlPrefix'] = "Doručovací engine";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "Doručovací engine";
$GLOBALS['strImagesUrlPrefix'] = "URL adresa úložiště obrázků";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL adresa úložiště obrázků (SSL)";


$GLOBALS['strUpgrade'] = "Aktualizace";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Vyberte sekci";
$GLOBALS['strEditConfigNotPossible'] = "";
$GLOBALS['strEditConfigPossible'] = "";
$GLOBALS['strUnableToWriteConfig'] = "";
$GLOBALS['strUnableToWritePrefs'] = "";
$GLOBALS['strImageDirLockedDetected'] = "";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Nastavení konfigurace";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Jméno Admina";
$GLOBALS['strAdminPassword'] = "";
$GLOBALS['strInvalidUsername'] = "Špatné Jméno";
$GLOBALS['strBasicInformation'] = "Základní údaje";
$GLOBALS['strAdministratorEmail'] = "";
$GLOBALS['strAdminCheckUpdates'] = "Kontrolovat aktualizace";
$GLOBALS['strAdminShareStack'] = "";
$GLOBALS['strNovice'] = "";
$GLOBALS['strUserlogEmail'] = "Logovat veškerou odchozí poštu";
$GLOBALS['strEnableDashboard'] = "";
$GLOBALS['strEnableDashboardSyncNotice'] = "";
$GLOBALS['strTimezone'] = "Časové pásmo";
$GLOBALS['strEnableAutoMaintenance'] = "";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Nastavení databáze";
$GLOBALS['strDatabaseServer'] = "Databázový server";
$GLOBALS['strDbLocal'] = "Připojit k lokálnímu serveru pomocí soketů";
$GLOBALS['strDbType'] = "Jméno databáze";
$GLOBALS['strDbHost'] = "Hostname databáze";
$GLOBALS['strDbSocket'] = "";
$GLOBALS['strDbPort'] = "Port databáze";
$GLOBALS['strDbUser'] = "Uživatel databáze";
$GLOBALS['strDbPassword'] = "Heslo databáze";
$GLOBALS['strDbName'] = "Jméno databáze";
$GLOBALS['strDbNameHint'] = "";
$GLOBALS['strDatabaseOptimalisations'] = "Optimalizace databáze";
$GLOBALS['strPersistentConnections'] = "Použít trvalé připojení";
$GLOBALS['strCantConnectToDb'] = "Nemohu se připojit k databázi";
$GLOBALS['strCantConnectToDbDelivery'] = '';

// Email Settings
$GLOBALS['strEmailSettings'] = "Základní nastavení";
$GLOBALS['strEmailAddresses'] = "";
$GLOBALS['strEmailFromName'] = "";
$GLOBALS['strEmailFromAddress'] = "";
$GLOBALS['strEmailFromCompany'] = "";
$GLOBALS['strUseManagerDetails'] = '';
$GLOBALS['strQmailPatch'] = "Zapnout qmail patch";
$GLOBALS['strEnableQmailPatch'] = "Zapnout qmail patch";
$GLOBALS['strEmailHeader'] = "Záhlaví e-mailů";
$GLOBALS['strEmailLog'] = "E-Mail log";

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
$GLOBALS['strDebugTypeFile'] = "Soubory";
$GLOBALS['strDebugTypeMcal'] = "";
$GLOBALS['strDebugTypeSql'] = "";
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
$GLOBALS['strProductionSystem'] = "";

// Delivery Settings
$GLOBALS['strWebPath'] = "";
$GLOBALS['strWebPathSimple'] = "";
$GLOBALS['strDeliveryPath'] = "Cache doručování";
$GLOBALS['strImagePath'] = "";
$GLOBALS['strDeliverySslPath'] = "Cache doručování";
$GLOBALS['strImageSslPath'] = "";
$GLOBALS['strImageStore'] = "";
$GLOBALS['strTypeWebSettings'] = "Nastavení lokálních bannerů (Webserver)";
$GLOBALS['strTypeWebMode'] = "Typ ukládání";
$GLOBALS['strTypeWebModeLocal'] = "Lokální adresář";
$GLOBALS['strTypeDirError'] = "Lokální adresář neexistuje";
$GLOBALS['strTypeWebModeFtp'] = "Externí FTP server";
$GLOBALS['strTypeWebDir'] = "Lokální adresář";
$GLOBALS['strTypeFTPHost'] = "Server FTP";
$GLOBALS['strTypeFTPDirectory'] = "Adresář serveru";
$GLOBALS['strTypeFTPUsername'] = "Přihlásit";
$GLOBALS['strTypeFTPPassword'] = "Heslo";
$GLOBALS['strTypeFTPPassive'] = "";
$GLOBALS['strTypeFTPErrorDir'] = "Adresář serveru neexistuje";
$GLOBALS['strTypeFTPErrorConnect'] = "Nemohu se přihlásit k FTP serveru. Uživatelské jméno a heslo nejsou správné";
$GLOBALS['strTypeFTPErrorNoSupport'] = "";
$GLOBALS['strTypeFTPErrorUpload'] = "";
$GLOBALS['strTypeFTPErrorHost'] = "Jméno FTP server není správné";
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
$GLOBALS['strP3PSettings'] = "Pravidla soukromí P3P";
$GLOBALS['strUseP3P'] = "Použít P3P pravidla";
$GLOBALS['strP3PCompactPolicy'] = "Kompaktní P3P pravidlo";
$GLOBALS['strP3PPolicyLocation'] = "Umístění P3P pravidla";
$GLOBALS['strPrivacySettings'] = "";
$GLOBALS['strDisableViewerId'] = "";
$GLOBALS['strAnonymiseIp'] = "";

// General Settings
$GLOBALS['generalSettings'] = "";
$GLOBALS['uiEnabled'] = "";
$GLOBALS['defaultLanguage'] = "";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Geocílení";
$GLOBALS['strGeotargeting'] = "Geocílení";
$GLOBALS['strGeotargetingType'] = "";
$GLOBALS['strGeoShowUnavailable'] = "";

// Interface Settings
$GLOBALS['strInventory'] = "Inventář";
$GLOBALS['strShowCampaignInfo'] = "Zobrazit extra informace o kampani na stránce <i>Přehled kampaně</i>";
$GLOBALS['strShowBannerInfo'] = "Zobrazit extra informace o banneru na stránce <i>Přehled banneru</i>";
$GLOBALS['strShowCampaignPreview'] = "Zobrazit náhled všech bannerů na stránce <i>Přehled banneru</i>";
$GLOBALS['strShowBannerHTML'] = "Zobrazit banner místo HTML kódu pro náhled HTML banneru";
$GLOBALS['strShowBannerPreview'] = "Zobrazit náhled banneru na konci stránek které pracují s bannery";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "";
$GLOBALS['strHideInactive'] = "Skrýt neaktivní položky ze všech přehledových stránek";
$GLOBALS['strGUIShowMatchingBanners'] = "Zobrazit odpovídající bannery na stránce <i>Připojený banner</i>";
$GLOBALS['strGUIShowParentCampaigns'] = "Zobrazit nadřazenou kampaň na stránce <i>Připojený banner</i>";
$GLOBALS['strShowEntityId'] = "";
$GLOBALS['strStatisticsDefaults'] = "Statistiky";
$GLOBALS['strBeginOfWeek'] = "Počátek týdne";
$GLOBALS['strPercentageDecimals'] = "Desetinná místa procent";
$GLOBALS['strWeightDefaults'] = "Implicitní váha";
$GLOBALS['strDefaultBannerWeight'] = "Implicitní váha banneru";
$GLOBALS['strDefaultCampaignWeight'] = "Implicitní váha kampaně";
$GLOBALS['strConfirmationUI'] = "";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Zamezit logování";
$GLOBALS['strLogAdRequests'] = "";
$GLOBALS['strLogAdImpressions'] = "";
$GLOBALS['strLogAdClicks'] = "";
$GLOBALS['strReverseLookup'] = "Pokus se určit název hostitele návštěníka pokud není poskytnuto serverem";
$GLOBALS['strProxyLookup'] = "Pokus se určit pravou IP adresu navštěvníka, který používá proxy server";
$GLOBALS['strPreventLogging'] = "Zamezit logování";
$GLOBALS['strIgnoreHosts'] = "Neukládát statistiky pro návštěvníky užívající jednu z následujících IP adres nebo názvů hostitelů";
$GLOBALS['strIgnoreUserAgents'] = "";
$GLOBALS['strEnforceUserAgents'] = "";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "";
$GLOBALS['strEnableContractECPM'] = "";
$GLOBALS['strEnableECPMfromRemnant'] = "";
$GLOBALS['strEnableECPMfromECPM'] = "";
$GLOBALS['strInactivatedCampaigns'] = "";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "";
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
$GLOBALS['strAdminEmailHeaders'] = "Přidej následujíc hlavičku ke každé správě poslané {{PRODUCT_NAME}}";
$GLOBALS['strWarnLimit'] = "Poslat upozornění když počet zbývajících impresí je nižší než zde uvedený";
$GLOBALS['strWarnLimitDays'] = "";
$GLOBALS['strWarnAdmin'] = "Poslat upozornění správci kdykoliv je kampaň téměř vyčerpána";
$GLOBALS['strWarnClient'] = "Poslat upozornění inzerentovi kdykoliv je kampaň téměř vyčerpána";
$GLOBALS['strWarnAgency'] = "Poslat upozornění partnerovi kdykoliv je kampaň téměř vyčerpána";

// UI Settings
$GLOBALS['strGuiSettings'] = "Nastavení uživatelského rozhraní";
$GLOBALS['strGeneralSettings'] = "Obecná nastavení";
$GLOBALS['strAppName'] = "Název aplikace";
$GLOBALS['strMyHeader'] = "Umístění souboru hlavičky";
$GLOBALS['strMyFooter'] = "Umístění souboru patičky";
$GLOBALS['strDefaultTrackerStatus'] = "";
$GLOBALS['strDefaultTrackerType'] = "";
$GLOBALS['strSSLSettings'] = "";
$GLOBALS['requireSSL'] = "";
$GLOBALS['sslPort'] = "";
$GLOBALS['strDashboardSettings'] = "";
$GLOBALS['strMyLogo'] = "";
$GLOBALS['strGuiHeaderForegroundColor'] = "";
$GLOBALS['strGuiHeaderBackgroundColor'] = "";
$GLOBALS['strGuiActiveTabColor'] = "";
$GLOBALS['strGuiHeaderTextColor'] = "";
$GLOBALS['strGuiSupportLink'] = "";
$GLOBALS['strGzipContentCompression'] = "Použít kompresi obsahu GZIPem";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "";
$GLOBALS['strNewPlatformHash'] = "";
$GLOBALS['strPlatformHashInsertingError'] = "";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "";
$GLOBALS['strEnableNewPlugins'] = "";
$GLOBALS['strUseMergedFunctions'] = "";
