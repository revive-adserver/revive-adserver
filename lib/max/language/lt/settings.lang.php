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
$GLOBALS['strInstall'] = "Įdiegti";
$GLOBALS['strDatabaseSettings'] = "Duomenų bazės nustatymai";
$GLOBALS['strAdminAccount'] = "Administratoriaus sąskaita";
$GLOBALS['strAdvancedSettings'] = "Papildomi nustatymai";
$GLOBALS['strWarning'] = "Perspėjimas";
$GLOBALS['strBtnContinue'] = "Tęsti »";
$GLOBALS['strBtnRecover'] = "Atnaujinti »";
$GLOBALS['strBtnAgree'] = "Aš sutinku »";
$GLOBALS['strBtnRetry'] = "Bandyti dar kartą";
$GLOBALS['strWarningRegisterArgcArv'] = " PHP registracijos konfigūracija _argc_argv turi būti įjungta, tam kad būtų paleistas aptarnavimo komanda.";
$GLOBALS['strTablesPrefix'] = "Table names prefix";
$GLOBALS['strTablesType'] = "Lentelės tipas";

$GLOBALS['strRecoveryRequiredTitle'] = "Jūsų pastarasis bandymas buvo su klaida";
$GLOBALS['strRecoveryRequired'] = "There was an error while processing your previous upgrade and {$PRODUCT_NAME} must attempt to recover the upgrade process. Please click the Recover button below.";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} is up to date";
$GLOBALS['strOaUpToDate'] = "Your {$PRODUCT_NAME} database and file structure are both using the most recent version and therefore no upgrade is required at this time. Please click Continue to proceed to the administration panel.";
$GLOBALS['strOaUpToDateCantRemove'] = "Įspėjimas: Atnaujinimo failas vis dar yra Jūsų var aplanke. Mes negalime pašalinti šio failo dėl tam tikrų prieigos draudimų. Prašome ištrinkite šį failą patys.";
$GLOBALS['strErrorWritePermissions'] = "Aptiktos failo leidimų klaidos, jos turibūti ištaisytos prieš tęsiant. <br/> Tam kad pataisytumėte klaidas Linux sistemoje, pabandykite įvesti sekančias komandas:";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod -R a+w %s</i>";
$GLOBALS['strNotWriteable'] = "NOT writeable";
$GLOBALS['strDirNotWriteableError'] = "Directory must be writeable";

$GLOBALS['strErrorWritePermissionsWin'] = "Rasta failo leidimo klaidų ir jos turi būti pataisytos prieš tęsiant. ";
$GLOBALS['strCheckDocumentation'] = "For more help, please see the <a href=\"{$PRODUCT_DOCSURL}\">{$PRODUCT_NAME} documentation</a>.";
$GLOBALS['strSystemCheckBadPHPConfig'] = "Your current PHP configuration does not meet requirements of {$PRODUCT_NAME}. To resolve the problems, please modify settings in your 'php.ini' file.";

$GLOBALS['strAdminUrlPrefix'] = "Administartoriaus sąsaja su URL";
$GLOBALS['strDeliveryUrlPrefix'] = "Pristatymo variklio URL";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "Pristatymo variklio URL (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "Vaizdų išsaugojimo URL";
$GLOBALS['strImagesUrlPrefixSSL'] = "Vaizdų išsaugojimo URL (SSL)";


$GLOBALS['strUpgrade'] = "Upgrade";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Pasirinkti dalį";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons.
    If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues.
    If you want to secure your system, you need to lock the configuration file for this installation.";
$GLOBALS['strUnableToWriteConfig'] = "Neįmano įrašyti pakeitimų į šiuos konfigūracijos failus";
$GLOBALS['strUnableToWritePrefs'] = "Neįmanoma nustatyti pirmenybių duomenų bazėje";
$GLOBALS['strImageDirLockedDetected'] = "Pateiktas <b>Paveikslėlių aplankas</b> nėra įrašomas per serverį. <br> Jūs negalite tęsti kol nepakeitėte aplankų galimų leidimų arba nesukūrėte naujo aplanko.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Konfigūracijos nustatymai";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Administratoriaus vartotojo avrdas";
$GLOBALS['strAdminPassword'] = "Administratoriaus slaptažodis";
$GLOBALS['strInvalidUsername'] = "Netinkamas vartotojo vardas";
$GLOBALS['strBasicInformation'] = "Pradinė informacija";
$GLOBALS['strAdministratorEmail'] = "Administratoriaus el.pašto adresas";
$GLOBALS['strAdminCheckUpdates'] = "Automatically check for product updates and security alerts (Recommended).";
$GLOBALS['strAdminShareStack'] = "Share technical information with the {$PRODUCT_NAME} Team to help with development and testing.";
$GLOBALS['strNovice'] = "Ištrinimo veiksmai reikalaujami dėl saugumo tikslų";
$GLOBALS['strUserlogEmail'] = "Įrašyti visas išsiunčiamas elektroninio pašto žinutes";
$GLOBALS['strEnableDashboard'] = "Enable dashboard";
$GLOBALS['strEnableDashboardSyncNotice'] = "Please enable <a href='account-settings-update.php'>check for updates</a> to use the dashboard.";
$GLOBALS['strTimezone'] = "Laiko zona";
$GLOBALS['strEnableAutoMaintenance'] = "Automatiškai atlikite aptarnavimo darbus per pristatymą jei nėra pagal grafiką sudarytų aptarvimų darbų sąrašo";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Duomenų bazės nustatymai";
$GLOBALS['strDatabaseServer'] = "Pasauliniai duomenų bazės serverio nustatymai";
$GLOBALS['strDbLocal'] = "Naudoti vietinę socket jungtį";
$GLOBALS['strDbType'] = "Duomenų bazės tipas";
$GLOBALS['strDbHost'] = "Duomenų bazės Hostname";
$GLOBALS['strDbSocket'] = "Duomenų bazės Socket";
$GLOBALS['strDbPort'] = "Duomenų bazės jungties numeris";
$GLOBALS['strDbUser'] = "Duomenų bazės vartotojo vardas";
$GLOBALS['strDbPassword'] = "Duomenų bazės slaptažodis";
$GLOBALS['strDbName'] = "Duomenų bazės pavadinimas";
$GLOBALS['strDbNameHint'] = "Database will be created if it does not exist";
$GLOBALS['strDatabaseOptimalisations'] = "Duomenų bazės optimizavimo nustatymai";
$GLOBALS['strPersistentConnections'] = "Naudokite nuolaitines jungtis";
$GLOBALS['strCantConnectToDb'] = "Neiįmanoma susjungti su duomenų baze";
$GLOBALS['strCantConnectToDbDelivery'] = 'Can\'t Connect to Database for Delivery';

// Email Settings
$GLOBALS['strEmailSettings'] = "El. pašto nustatymai";
$GLOBALS['strEmailAddresses'] = "El. paštas  el. pašto adresas";
$GLOBALS['strEmailFromName'] = "Email 'From' Name";
$GLOBALS['strEmailFromAddress'] = "El. paštas  el. pašto adresas";
$GLOBALS['strEmailFromCompany'] = "Email 'From' Company";
$GLOBALS['strUseManagerDetails'] = 'Use the owning account\'s Contact, Email and Name instead of the above Name, Email Address and Company when emailing reports to Advertiser or Website accounts.';
$GLOBALS['strQmailPatch'] = "qmail patch";
$GLOBALS['strEnableQmailPatch'] = "Įgalinti pašto taisymą";
$GLOBALS['strEmailHeader'] = "El. pašto antraštė";
$GLOBALS['strEmailLog'] = "El. pašto registras";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Audit trail nustatymai";
$GLOBALS['strEnableAudit'] = "Įgalinti Audit trail";
$GLOBALS['strEnableAuditForZoneLinking'] = "Enable Audit Trail for Zone Linking screen (introduces huge performance penalty when linking large amounts of zones)";

// Debug Logging Settings
$GLOBALS['strDebug'] = "Suderinti prisijungimo nustatymus";
$GLOBALS['strEnableDebug'] = "Įgalinti prisijungimo suderinimą";
$GLOBALS['strDebugMethodNames'] = "Įterpti metodinius vardus suderinant prisijungimą";
$GLOBALS['strDebugLineNumbers'] = "įterpti linijų numerius derinant prisijungimą";
$GLOBALS['strDebugType'] = "Suderinti prisijungimo tipą";
$GLOBALS['strDebugTypeFile'] = "Failas";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "SQL duomenų bazė";
$GLOBALS['strDebugTypeSyslog'] = "Sistemos registras";
$GLOBALS['strDebugName'] = "Suderinti Prisijungimo vardą, Kalendarių, SQL lentelę,<br />arba Syslog Facility";
$GLOBALS['strDebugPriority'] = "Suderinti pirmenybinį lygį ";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Dauguma informacijos";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Pagrindinė informacija";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_PRIMINIMAS";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_ĮSPĖJIMAS";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_KLAIDA";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_PAVOJUS";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - Mažiausiai informacijos";
$GLOBALS['strDebugIdent'] = "Suderinti identifikacijos grandinę";
$GLOBALS['strDebugUsername'] = "mCal, SQL serverio vartotojo vardas";
$GLOBALS['strDebugPassword'] = "mCal, SQL serverio slaptažodis";
$GLOBALS['strProductionSystem'] = "Production System";

// Delivery Settings
$GLOBALS['strWebPath'] = "{$PRODUCT_NAME} Server Access Paths";
$GLOBALS['strWebPathSimple'] = "Web kelias";
$GLOBALS['strDeliveryPath'] = "Pristatymo kelias";
$GLOBALS['strImagePath'] = "Vaizdų kelias";
$GLOBALS['strDeliverySslPath'] = "SSL pristatymo kelias";
$GLOBALS['strImageSslPath'] = "SSL vaizdų kelias";
$GLOBALS['strImageStore'] = "Vaizdų aplankai";
$GLOBALS['strTypeWebSettings'] = "Web serverių ir vietinių banerių išsaugojimo nustatymai";
$GLOBALS['strTypeWebMode'] = "Išsaugojimo metodas";
$GLOBALS['strTypeWebModeLocal'] = "Vietinis katalogas";
$GLOBALS['strTypeDirError'] = "Vietinis katalogas negali būti įrašytas per we serverį";
$GLOBALS['strTypeWebModeFtp'] = "Išorinis FTP serveris";
$GLOBALS['strTypeWebDir'] = "Vietinis katalogas";
$GLOBALS['strTypeFTPHost'] = "FTP Hostingas";
$GLOBALS['strTypeFTPDirectory'] = "Hostingo aplankas";
$GLOBALS['strTypeFTPUsername'] = "Prisijungti";
$GLOBALS['strTypeFTPPassword'] = "Slaptažodis";
$GLOBALS['strTypeFTPPassive'] = "Naudoti pasyvų FTP";
$GLOBALS['strTypeFTPErrorDir'] = "FTP hostingo aplankas neegiztuoja";
$GLOBALS['strTypeFTPErrorConnect'] = "Neįmanoma prisijungti prie FTP serverio, prisijungimo vardas arba slaptažodis neteisingi";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Jūsų PHP instaliacija nepalaiko Jūsų FTP";
$GLOBALS['strTypeFTPErrorUpload'] = "Could not upload file to the FTP Server, check set proper rights to Host Directory";
$GLOBALS['strTypeFTPErrorHost'] = "FTP hostingas neteisingas";
$GLOBALS['strDeliveryFilenames'] = "Pristatymo failų vardai";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Ad paspaudimas";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "Ad konvertavimo kintamuosius";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Ad turinys";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "Ad konvertacija";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "Ad konvertacija (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Ad rėmeliai";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Ad paveikslėlis";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Ad (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Ad lygmuo";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Ad registras";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Ad Popup";
$GLOBALS['strDeliveryFilenamesAdView'] = "Ad rodymas";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "XML RPC kreipimasis";
$GLOBALS['strDeliveryFilenamesLocal'] = "Vietinis kreipimasis";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Priekinis tikrintojas";
$GLOBALS['strDeliveryFilenamesFlash'] = "Pridėti Flash (gali būti pilnas URL)";
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "Single Page Call";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "Single Page Call (JavaScript)";
$GLOBALS['strDeliveryCaching'] = "Banerio pristatymo kelio nustatymai";
$GLOBALS['strDeliveryCacheLimit'] = "Laikas ";
$GLOBALS['strDeliveryCacheStore'] = "Banner Delivery Cache Store Type";
$GLOBALS['strDeliveryAcls'] = "Evaluate banner delivery rules during delivery";
$GLOBALS['strDeliveryAclsDirectSelection'] = "Evaluate banner delivery rules for direct selected ads";
$GLOBALS['strDeliveryObfuscate'] = "Obfuscate delivery rule set when delivering ads";
$GLOBALS['strDeliveryExecPhp'] = "Leisti PHP kodui, kai pridedamas būti pašalintam<br />(Įspėjimas: Security risk)";
$GLOBALS['strDeliveryCtDelimiter'] = "Trečiosios šalies paspaudimų seklio delimiter";
$GLOBALS['strGlobalDefaultBannerUrl'] = "Global default Banner Image URL";
$GLOBALS['strP3PSettings'] = "P3P privatumo politika";
$GLOBALS['strUseP3P'] = "Naudoti P3P politiką";
$GLOBALS['strP3PCompactPolicy'] = "P3P susitarimo politika";
$GLOBALS['strP3PPolicyLocation'] = "P3P vietos politika";
$GLOBALS['strPrivacySettings'] = "Privacy Settings";
$GLOBALS['strDisableViewerId'] = "Disable unique Viewer Id cookie";
$GLOBALS['strAnonymiseIp'] = "Anonymise viewer IP addresses";

// General Settings
$GLOBALS['generalSettings'] = "Global General System Settings";
$GLOBALS['uiEnabled'] = "User Interface Enabled";
$GLOBALS['defaultLanguage'] = "Default System Language<br />(Each user can select their own language)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Geotargeting nustatymai";
$GLOBALS['strGeotargeting'] = "Geotargeting nustatymai";
$GLOBALS['strGeotargetingType'] = "Geotargeting modulio tipas";
$GLOBALS['strGeoShowUnavailable'] = "Show geotargeting delivery rules even if GeoIP data unavailable";

// Interface Settings
$GLOBALS['strInventory'] = "Inventorius";
$GLOBALS['strShowCampaignInfo'] = "Show extra campaign info on <i>Campaigns</i> page";
$GLOBALS['strShowBannerInfo'] = "Show extra banner info on <i>Banners</i> page";
$GLOBALS['strShowCampaignPreview'] = "Show preview of all banners on <i>Banners</i> page";
$GLOBALS['strShowBannerHTML'] = "Rodyti banerį vietoj HTML kodo per HTML banerio peržiūrą";
$GLOBALS['strShowBannerPreview'] = "Rodyti banerio peržiūrą, puslapių viršuje, tuose puslapiuose, kurie naudojami baneriams";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "Use the WYSIWYG HTML Editor by default when creating or editing HTML banners";
$GLOBALS['strHideInactive'] = "Hide inactive items from all overview pages";
$GLOBALS['strGUIShowMatchingBanners'] = "rodyti sutampančius banerius <i> Susieti baneriai</i> puspaliuose";
$GLOBALS['strGUIShowParentCampaigns'] = "Rodyti pirminias kampanijas per <i> Susieti  baneriai </i> puslapius";
$GLOBALS['strShowEntityId'] = "Show entity identifiers";
$GLOBALS['strStatisticsDefaults'] = "Statistika";
$GLOBALS['strBeginOfWeek'] = "Savaitės pradžia";
$GLOBALS['strPercentageDecimals'] = "Dešimtainė procento dalis";
$GLOBALS['strWeightDefaults'] = "Pagrindinis svoris";
$GLOBALS['strDefaultBannerWeight'] = "Pagrindinis banerio svoris";
$GLOBALS['strDefaultCampaignWeight'] = "Pagrindinis kampanijos svoris";
$GLOBALS['strConfirmationUI'] = "Vartotojo sąsajos patvirtinimas";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "Pasveikinimų pagrindinės frazės";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Įgalinti trečiosios šalies paspaudimų sekimą per pagrindinius nustatymus";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Banerio pristatymo kelio nustatymai";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Blokuoti  banerio prisijungimo nustatymus";
$GLOBALS['strLogAdRequests'] = "Įregistruoti prašymą kiekvieną kartą kai prašomas baneris";
$GLOBALS['strLogAdImpressions'] = "Įregistruoti įspūdį kiekvieną kartą kai baneris peržiūrimas";
$GLOBALS['strLogAdClicks'] = "Įregistruoti paspaudimus kiekvieną kartą kai vartotojas paspaudžia ant banerio";
$GLOBALS['strReverseLookup'] = "Pakeisti peržiūrinėjimo pavadinimus kai jie nepateikiami";
$GLOBALS['strProxyLookup'] = "Bandyti nustatyti tikrąjį IP adresą vartotojų besijungiančių per proxy serverį";
$GLOBALS['strPreventLogging'] = "Blokuoti  banerio prisijungimo nustatymus";
$GLOBALS['strIgnoreHosts'] = "Neišsaugokite jokios žemiau nurodytų vartotojų statistikos pagal nurodytus IP adresus arba pavadinimus";
$GLOBALS['strIgnoreUserAgents'] = "<b>Neregistruokite</b> jokios statistikos iš klientų, kurie naudoja bent vieną iš šių strings savo user-agent dalyje (vienas per liniją)";
$GLOBALS['strEnforceUserAgents'] = "<b>Registruokite</b> tik tą statistiką iš klientų, kurie naudoja strings savo user-agent dalyje (vienas per liniją)";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "Banerio išsaugojimo nustatymai";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "Use eCPM optimized priorities instead of remnant-weighted priorities";
$GLOBALS['strEnableContractECPM'] = "Use eCPM optimized priorities instead of standard contract priorities";
$GLOBALS['strEnableECPMfromRemnant'] = "(If you enable this feature all your remnant campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strEnableECPMfromECPM'] = "(If you disable this feature some of your active eCPM campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strInactivatedCampaigns'] = "List of campaigns which became inactive due to the changes in preferences:";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "Techninio aptarnavimo nustatymai";
$GLOBALS['strConversionTracking'] = "Agento konvertacijos nustatymai";
$GLOBALS['strEnableConversionTracking'] = "Įgalinti agento konvertaciją";
$GLOBALS['strBlockInactiveBanners'] = "Don't count ad impressions, clicks or re-direct the user to the target URL if the viewer clicks on a banner that is inactive";
$GLOBALS['strBlockAdClicks'] = "Neskaičiuoti paspaudimų jei peržiūrėtojas paspaudė ant tos pačios zonos poros per tam tikrą laiką (sekundės)";
$GLOBALS['strMaintenanceOI'] = "Techninio aptarnavimo intervalas (minutės)";
$GLOBALS['strPrioritySettings'] = "Pirmenybės nustatymai";
$GLOBALS['strPriorityInstantUpdate'] = "Atnaujinti reklamos pirmenybės iš karto kai tik atliekami bet kokie UI pasikeitimai";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "Intentionally over-deliver Contract Campaigns<br />(% over-delivery)";
$GLOBALS['strDefaultImpConvWindow'] = "Default Ad Impression Conversion Window (seconds)";
$GLOBALS['strDefaultCliConvWindow'] = "Default Ad Click Conversion Window (seconds)";
$GLOBALS['strAdminEmailHeaders'] = "Add the following headers to each email message sent by {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Išsiųsti įspėjimą kai įspūdžių/nuomonių skaičius yra mažesnis nei nurodyta čia";
$GLOBALS['strWarnLimitDays'] = "Siųsti įspėjimą kai likę dienų mažiau nei nurodyta čia";
$GLOBALS['strWarnAdmin'] = "Išsiųsti įspėjimą administratoriui kiekvieną kartą kai kampanijos galiojimo laikas beveik pasibaigė";
$GLOBALS['strWarnClient'] = "Išsiųsti įspėjimą reklamuotojui kiekvieną kartą kai kampanijos galiojimo laikas beveik pasibaigė";
$GLOBALS['strWarnAgency'] = "Išsiųsti įspėjimą agentūrai kiekvieną kartą kai kampanijos galiojimo laikas beveik pasibaigė";

// UI Settings
$GLOBALS['strGuiSettings'] = "Vartotojo sąsajų nustatymai ";
$GLOBALS['strGeneralSettings'] = "Bendri nustatymai";
$GLOBALS['strAppName'] = "Prašymo pavadinimas";
$GLOBALS['strMyHeader'] = "Antraštės failo vieta";
$GLOBALS['strMyFooter'] = "Paraštės  failo vieta";
$GLOBALS['strDefaultTrackerStatus'] = "Pagrindinis agento statusas";
$GLOBALS['strDefaultTrackerType'] = "Pagrindinis agento tipas";
$GLOBALS['strSSLSettings'] = "SSL nustatymai";
$GLOBALS['requireSSL'] = "Leisti SSL priėjimą vartotojo sąsajoje";
$GLOBALS['sslPort'] = "SSL sotis naudojama internetinio serverio";
$GLOBALS['strDashboardSettings'] = "Dashboard Settings";
$GLOBALS['strMyLogo'] = "Įprasto logo failo vardas";
$GLOBALS['strGuiHeaderForegroundColor'] = "Antraštės pirminė spalva";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Antraštės fono spalva";
$GLOBALS['strGuiActiveTabColor'] = "Aktyvios pozicijos spalva";
$GLOBALS['strGuiHeaderTextColor'] = "Teksto antraštėje spalva";
$GLOBALS['strGuiSupportLink'] = "Custom URL for 'Support' link in header";
$GLOBALS['strGzipContentCompression'] = "Naudokite GZIP turinio suspaudimo programą";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "Platform Hash Regenerate";
$GLOBALS['strNewPlatformHash'] = "Your new Platform Hash is:";
$GLOBALS['strPlatformHashInsertingError'] = "Error inserting Platform Hash into database";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "Plugin Settings";
$GLOBALS['strEnableNewPlugins'] = "Enable newly installed plugins";
$GLOBALS['strUseMergedFunctions'] = "Use merged delivery functions file";
