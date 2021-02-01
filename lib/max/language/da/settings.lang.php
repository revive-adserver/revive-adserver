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
$GLOBALS['strWarningRegisterArgcArv'] = "PHP konfigurator variable register_argc_argv skal tændes for at kunne køre vedligeholdelse fra kommando linien.";
$GLOBALS['strTablesPrefix'] = "Table names prefix";
$GLOBALS['strTablesType'] = "Tabel type";

$GLOBALS['strRecoveryRequiredTitle'] = "Dit tidligere forsøg på at upgradere udløste en fejl";
$GLOBALS['strRecoveryRequired'] = "Der var en fejl under behandlingen af din tidligere opdatering og {$PRODUCT_NAME} skal forsøge at genskabe opgraderings processen. Venligst klik på Genskab knappen herunder.";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} is up to date";
$GLOBALS['strOaUpToDate'] = "Din {$PRODUCT_NAME} database og filstrktur bruger begge den nyeste version of derfor er det ikke nødvendig med at opdatere på dette tidspunkt. Venligst klik 'Fortsæt' for at komme videre til OpenX administrations panelet.";
$GLOBALS['strOaUpToDateCantRemove'] = "Advarsel: UPGRADE filen er stadig inde i din var folder. Vi kan ikke fjerne denne fil på grund af manglede adgang og tilladelse. Venligst slet denne fil selv.";
$GLOBALS['strErrorWritePermissions'] = "Der er fundet nogle fil adgangs fejl, og disse skal repareres inden du kan fortsætte.<br />For at reparere fejlene på en Linux system, prøv at skrive følgende kommando(er):";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod -R a+w %s</i>";
$GLOBALS['strNotWriteable'] = "NOT writeable";
$GLOBALS['strDirNotWriteableError'] = "Directory must be writeable";

$GLOBALS['strErrorWritePermissionsWin'] = "Der er fundet nogle fil adgangs fejl, og disse skal repareres inden du kan fortsætte";
$GLOBALS['strCheckDocumentation'] = "For mere hjælp se <a href='http://{$PRODUCT_DOCSURL}'>{$PRODUCT_NAME} documentation</a>.";
$GLOBALS['strSystemCheckBadPHPConfig'] = "Your current PHP configuration does not meet requirements of {$PRODUCT_NAME}. To resolve the problems, please modify settings in your 'php.ini' file.";

$GLOBALS['strAdminUrlPrefix'] = "Administrator interface URL";
$GLOBALS['strDeliveryUrlPrefix'] = "Delivery Engine URL";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "Delivery Engine URL (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "Image Store URL";
$GLOBALS['strImagesUrlPrefixSSL'] = "Image Store URL (SSL)";


$GLOBALS['strUpgrade'] = "Upgrade";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Vælg sektion";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons.
    If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues.
    If you want to secure your system, you need to lock the configuration file for this installation.";
$GLOBALS['strUnableToWriteConfig'] = "Ude af stand til at skrive ændringer til config filen";
$GLOBALS['strUnableToWritePrefs'] = "Ude af stand til at binde referencer til databasen";
$GLOBALS['strImageDirLockedDetected'] = "Den leverede <b>Billede Mappe</b> er ikke skrivebar af serveren. <br>Du kan ikke fortsætte indtil du enten ændrer adgangstilladdelse til mappen eller opretter mappen.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Configuration settings";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Administrator  brugernavn";
$GLOBALS['strAdminPassword'] = "Administrator  password";
$GLOBALS['strInvalidUsername'] = "Ugyldig brugernavn";
$GLOBALS['strBasicInformation'] = "Basis information";
$GLOBALS['strAdministratorEmail'] = "Administrators email adresse";
$GLOBALS['strAdminCheckUpdates'] = "Automatically check for product updates and security alerts (Recommended).";
$GLOBALS['strAdminShareStack'] = "Share technical information with the {$PRODUCT_NAME} Team to help with development and testing.";
$GLOBALS['strNovice'] = "Delete actions require confirmation for safety";
$GLOBALS['strUserlogEmail'] = "Log alle udgående email beskeder";
$GLOBALS['strEnableDashboard'] = "Enable dashboard";
$GLOBALS['strEnableDashboardSyncNotice'] = "Please enable <a href='account-settings-update.php'>check for updates</a> to use the dashboard.";
$GLOBALS['strTimezone'] = "Tidszone";
$GLOBALS['strEnableAutoMaintenance'] = "Automatisk udfør vedligeholdelse under levering if planlagt vedligehold ikke er sat op";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Database opsætning";
$GLOBALS['strDatabaseServer'] = "Global database server opsætninger";
$GLOBALS['strDbLocal'] = "Use local socket connection";
$GLOBALS['strDbType'] = "Database type";
$GLOBALS['strDbHost'] = "Database host navn";
$GLOBALS['strDbSocket'] = "Database Socket";
$GLOBALS['strDbPort'] = "Database port nummer";
$GLOBALS['strDbUser'] = "Database bruger navn";
$GLOBALS['strDbPassword'] = "Database password";
$GLOBALS['strDbName'] = "Database navn";
$GLOBALS['strDbNameHint'] = "Database will be created if it does not exist";
$GLOBALS['strDatabaseOptimalisations'] = "Database optimiserings opsætning";
$GLOBALS['strPersistentConnections'] = "Brug Persistent tilslutning";
$GLOBALS['strCantConnectToDb'] = "Kan ikke tilslutte til databasen";
$GLOBALS['strCantConnectToDbDelivery'] = 'Can\'t Connect to Database for Delivery';

// Email Settings
$GLOBALS['strEmailSettings'] = "Email Indstillinger";
$GLOBALS['strEmailAddresses'] = "Email 'From' Address";
$GLOBALS['strEmailFromName'] = "Email 'From' Name";
$GLOBALS['strEmailFromAddress'] = "Email 'From' Email Address";
$GLOBALS['strEmailFromCompany'] = "Email 'From' Company";
$GLOBALS['strUseManagerDetails'] = 'Use the owning account\'s Contact, Email and Name instead of the above Name, Email Address and Company when emailing reports to Advertiser or Website accounts.';
$GLOBALS['strQmailPatch'] = "qmail patch";
$GLOBALS['strEnableQmailPatch'] = "Enable qmail patch";
$GLOBALS['strEmailHeader'] = "Email Titel";
$GLOBALS['strEmailLog'] = "Email Log";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Handlings Log Indstillinger";
$GLOBALS['strEnableAudit'] = "Aktiver Handlings Log";
$GLOBALS['strEnableAuditForZoneLinking'] = "Enable Audit Trail for Zone Linking screen (introduces huge performance penalty when linking large amounts of zones)";

// Debug Logging Settings
$GLOBALS['strDebug'] = "Opsætning af debug logning";
$GLOBALS['strEnableDebug'] = "Tillad debug logning";
$GLOBALS['strDebugMethodNames'] = "Inkluder metode navn i debug loggen";
$GLOBALS['strDebugLineNumbers'] = "Inkluder linie nummer i degub loggen";
$GLOBALS['strDebugType'] = "Debug log type";
$GLOBALS['strDebugTypeFile'] = "Fil";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "SQL database";
$GLOBALS['strDebugTypeSyslog'] = "Syslog";
$GLOBALS['strDebugName'] = "Debug log navn, kalender, SQL tabel,<br />eller Syslog funktion";
$GLOBALS['strDebugPriority'] = "Debug prioritets niveau";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Informations majoriteten";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Standard information";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_DEBUG - Informations majoriteten";
$GLOBALS['strDebugIdent'] = "Debug identifikations streng";
$GLOBALS['strDebugUsername'] = "mCal, SQL Server brugernavn";
$GLOBALS['strDebugPassword'] = "mCal, SQL Server kodeord";
$GLOBALS['strProductionSystem'] = "Production System";

// Delivery Settings
$GLOBALS['strWebPath'] = "{$PRODUCT_NAME} Server Access Paths";
$GLOBALS['strWebPathSimple'] = "Web sti";
$GLOBALS['strDeliveryPath'] = "Cache levering";
$GLOBALS['strImagePath'] = "Images path";
$GLOBALS['strDeliverySslPath'] = "Cache levering";
$GLOBALS['strImageSslPath'] = "Images SSL path";
$GLOBALS['strImageStore'] = "Images folder";
$GLOBALS['strTypeWebSettings'] = "Webserver Local Banner Storage Settings";
$GLOBALS['strTypeWebMode'] = "Storing Method";
$GLOBALS['strTypeWebModeLocal'] = "Local Directory";
$GLOBALS['strTypeDirError'] = "The local directory cannot be written to by the web server";
$GLOBALS['strTypeWebModeFtp'] = "External FTP Server";
$GLOBALS['strTypeWebDir'] = "Local Directory";
$GLOBALS['strTypeFTPHost'] = "FTP Host";
$GLOBALS['strTypeFTPDirectory'] = "Host Directory";
$GLOBALS['strTypeFTPUsername'] = "Log ind";
$GLOBALS['strTypeFTPPassword'] = "Kodeord";
$GLOBALS['strTypeFTPPassive'] = "Use passive FTP";
$GLOBALS['strTypeFTPErrorDir'] = "The FTP Host Directory does not exist";
$GLOBALS['strTypeFTPErrorConnect'] = "Could not connect to the FTP Server, the Login or Password is not correct";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Din PHP installation understøtter ikke FTP.";
$GLOBALS['strTypeFTPErrorUpload'] = "Could not upload file to the FTP Server, check set proper rights to Host Directory";
$GLOBALS['strTypeFTPErrorHost'] = "The FTP Host is not correct";
$GLOBALS['strDeliveryFilenames'] = "Delivery File Names";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Ad Click";
$GLOBALS['strDeliveryFilenamesSignedAdClick'] = "Signed Ad Click";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "Ad Conversion Variables";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Ad Content";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "Ad Conversion";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "Ad Conversion (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Ad Frame";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Tilføj Billede";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Tilføj (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Tilføj Layer";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Tilføj Log";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Tilføj Popup";
$GLOBALS['strDeliveryFilenamesAdView'] = "Ad View";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "XML RPC Invocation";
$GLOBALS['strDeliveryFilenamesLocal'] = "Lokal Invocation";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Front Controller";
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "Single Page Call";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "Single Page Call (JavaScript)";
$GLOBALS['strDeliveryFilenamesAsyncJS'] = "Async JavaScript (source file)";
$GLOBALS['strDeliveryFilenamesAsyncPHP'] = "Async JavaScript";
$GLOBALS['strDeliveryFilenamesAsyncSPC'] = "Async JavaScript Single Page Call";
$GLOBALS['strDeliveryCaching'] = "Banner Levering Cache Indstillinger";
$GLOBALS['strDeliveryCacheLimit'] = "Tid imellem Banner Cache Updatering (sekunder)";
$GLOBALS['strDeliveryCacheStore'] = "Banner Delivery Cache Store Type";
$GLOBALS['strDeliveryAcls'] = "Evaluate banner delivery rules during delivery";
$GLOBALS['strDeliveryAclsDirectSelection'] = "Evaluate banner delivery rules for direct selected ads";
$GLOBALS['strDeliveryObfuscate'] = "Obfuscate delivery rule set when delivering ads";
$GLOBALS['strDeliveryCtDelimiter'] = "3rd Party Click Tracking Delimiter";
$GLOBALS['strGlobalDefaultBannerUrl'] = "Global default Banner Image URL";
$GLOBALS['strGlobalDefaultBannerInvalidZone'] = "Global default HTML Banner for non-existing zones";
$GLOBALS['strGlobalDefaultBannerSuspendedAccount'] = "Global default HTML Banner for suspended accounts";
$GLOBALS['strGlobalDefaultBannerInactiveAccount'] = "Global default HTML Banner for inactive accounts";
$GLOBALS['strP3PSettings'] = "P3P Privacy Policies";
$GLOBALS['strUseP3P'] = "Use P3P Policies";
$GLOBALS['strP3PCompactPolicy'] = "P3P Compact Policy";
$GLOBALS['strP3PPolicyLocation'] = "P3P Policy Location";
$GLOBALS['strPrivacySettings'] = "Privacy Settings";
$GLOBALS['strDisableViewerId'] = "Disable unique Viewer Id cookie";
$GLOBALS['strAnonymiseIp'] = "Anonymise viewer IP addresses";

// General Settings
$GLOBALS['generalSettings'] = "Global General System Settings";
$GLOBALS['uiEnabled'] = "User Interface Enabled";
$GLOBALS['defaultLanguage'] = "Default System Language<br />(Each user can select their own language)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Geotargeting Settings";
$GLOBALS['strGeotargeting'] = "Geotargeting Settings";
$GLOBALS['strGeotargetingType'] = "Geotargeting Module Type";
$GLOBALS['strGeoShowUnavailable'] = "Show geotargeting delivery rules even if GeoIP data unavailable";

// Interface Settings
$GLOBALS['strInventory'] = "Portfolio";
$GLOBALS['strShowCampaignInfo'] = "Show extra campaign info on <i>Campaigns</i> page";
$GLOBALS['strShowBannerInfo'] = "Show extra banner info on <i>Banners</i> page";
$GLOBALS['strShowCampaignPreview'] = "Show preview of all banners on <i>Banners</i> page";
$GLOBALS['strShowBannerHTML'] = "Show actual banner instead of plain HTML code for HTML banner preview";
$GLOBALS['strShowBannerPreview'] = "Show banner preview at the top of pages which deal with banners";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "Use the WYSIWYG HTML Editor by default when creating or editing HTML banners";
$GLOBALS['strHideInactive'] = "Hide inactive items from all overview pages";
$GLOBALS['strGUIShowMatchingBanners'] = "Show matching banners on the <i>Linked banner</i> pages";
$GLOBALS['strGUIShowParentCampaigns'] = "Show parent campaigns on the <i>Linked banner</i> pages";
$GLOBALS['strShowEntityId'] = "Show entity identifiers";
$GLOBALS['strStatisticsDefaults'] = "Statistikker";
$GLOBALS['strBeginOfWeek'] = "Beginning of Week";
$GLOBALS['strPercentageDecimals'] = "Percentage Decimals";
$GLOBALS['strWeightDefaults'] = "Default Weight";
$GLOBALS['strDefaultBannerWeight'] = "Default Banner Weight";
$GLOBALS['strDefaultCampaignWeight'] = "Default Campaign Weight";
$GLOBALS['strConfirmationUI'] = "Bekræftigelse for Bruger Grænseflade";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "Invocation Defaults";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Enable 3rd Party Clicktracking by Default";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Banner Leverings Indstillinger";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Banner Log Indstillinger";
$GLOBALS['strLogAdRequests'] = "Log a request every time a banner is requested";
$GLOBALS['strLogAdImpressions'] = "Log an impression every time a banner is viewed";
$GLOBALS['strLogAdClicks'] = "Log a click every time a viewer clicks on a banner";
$GLOBALS['strReverseLookup'] = "Reverse lookup the hostnames of viewers when not supplied";
$GLOBALS['strProxyLookup'] = "Try to determine the real IP address of viewers behind a proxy server";
$GLOBALS['strPreventLogging'] = "Banner Log Indstillinger";
$GLOBALS['strIgnoreHosts'] = "Don't log any statistics for viewers using any of the following IP addresses or hostnames";
$GLOBALS['strIgnoreUserAgents'] = "<b>Don't</b> log statistics from clients with any of the following strings in their user-agent (one-per-line)";
$GLOBALS['strEnforceUserAgents'] = "<b>Only</b> log statistics from clients with any of the following strings in their user-agent (one-per-line)";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "Indstillinger for Banner Lagring";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "Use eCPM optimized priorities instead of remnant-weighted priorities";
$GLOBALS['strEnableContractECPM'] = "Use eCPM optimized priorities instead of standard contract priorities";
$GLOBALS['strEnableECPMfromRemnant'] = "(If you enable this feature all your remnant campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strEnableECPMfromECPM'] = "(If you disable this feature some of your active eCPM campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strInactivatedCampaigns'] = "List of campaigns which became inactive due to the changes in preferences:";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "Vedligeholdelses Indstillinger";
$GLOBALS['strConversionTracking'] = "Conversion Tracking Settings";
$GLOBALS['strEnableConversionTracking'] = "Enable Conversion Tracking";
$GLOBALS['strBlockInactiveBanners'] = "Don't count ad impressions, clicks or re-direct the user to the target URL if the viewer clicks on a banner that is inactive";
$GLOBALS['strBlockAdClicks'] = "Don't count ad clicks if the viewer has clicked on the same ad/zone pair within the specified time (seconds)";
$GLOBALS['strMaintenanceOI'] = "Maintenance Operation Interval (minutes)";
$GLOBALS['strPrioritySettings'] = "Priority Settings";
$GLOBALS['strPriorityInstantUpdate'] = "Update advertisement priorities immediately when changes made in the UI";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "Intentionally over-deliver Contract Campaigns<br />(% over-delivery)";
$GLOBALS['strDefaultImpConvWindow'] = "Default Ad Impression Conversion Window (seconds)";
$GLOBALS['strDefaultCliConvWindow'] = "Default Ad Click Conversion Window (seconds)";
$GLOBALS['strAdminEmailHeaders'] = "Add the following headers to each email message sent by {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Send a warning when the number of impressions left are less than specified here";
$GLOBALS['strWarnLimitDays'] = "Send a warning when the days left are less than specified here";
$GLOBALS['strWarnAdmin'] = "Send a warning to the administrator every time a campaign is almost expired";
$GLOBALS['strWarnClient'] = "Send a warning to the advertiser every time a campaign is almost expired";
$GLOBALS['strWarnAgency'] = "Send a warning to the account every time a campaign is almost expired";

// UI Settings
$GLOBALS['strGuiSettings'] = "User Interface Settings";
$GLOBALS['strGeneralSettings'] = "Generel opsætninger";
$GLOBALS['strAppName'] = "Application Name";
$GLOBALS['strMyHeader'] = "Header File Location";
$GLOBALS['strMyFooter'] = "Footer File Location";
$GLOBALS['strDefaultTrackerStatus'] = "Default tracker status";
$GLOBALS['strDefaultTrackerType'] = "Default tracker type";
$GLOBALS['strSSLSettings'] = "SSL Indstillinger";
$GLOBALS['requireSSL'] = "Tving SSL adgang i Bruger Grænseflade";
$GLOBALS['sslPort'] = "SSL Port Brugt af Web Server";
$GLOBALS['strDashboardSettings'] = "Dashboard Settings";
$GLOBALS['strMyLogo'] = "Name/URL of custom logo file";
$GLOBALS['strGuiHeaderForegroundColor'] = "Color of the header foreground";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Color of the header background";
$GLOBALS['strGuiActiveTabColor'] = "Color of the active tab";
$GLOBALS['strGuiHeaderTextColor'] = "Color of the text in the header";
$GLOBALS['strGuiSupportLink'] = "Custom URL for 'Support' link in header";
$GLOBALS['strGzipContentCompression'] = "Use GZIP Content Compression";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "Platform Hash Regenerate";
$GLOBALS['strNewPlatformHash'] = "Your new Platform Hash is:";
$GLOBALS['strPlatformHashInsertingError'] = "Error inserting Platform Hash into database";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "Plugin Settings";
$GLOBALS['strEnableNewPlugins'] = "Enable newly installed plugins";
$GLOBALS['strUseMergedFunctions'] = "Use merged delivery functions file";
