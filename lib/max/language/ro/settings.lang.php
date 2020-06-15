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
$GLOBALS['strInstall'] = "Instalează";
$GLOBALS['strDatabaseSettings'] = "Setări bază de date";
$GLOBALS['strAdminAccount'] = "Cont Administrator";
$GLOBALS['strAdvancedSettings'] = "Setări Avansate";
$GLOBALS['strWarning'] = "Avertisment";
$GLOBALS['strBtnContinue'] = "Continuă »";
$GLOBALS['strBtnRecover'] = "Recuperează »";
$GLOBALS['strBtnAgree'] = "Sunt de acord »";
$GLOBALS['strBtnRetry'] = "Reîncearcă";
$GLOBALS['strWarningRegisterArgcArv'] = "Variabila register_argc_argv din configuraţia PHP trebuie setată pe on pentru a executa mentenanţa din linia de comandă.";
$GLOBALS['strTablesPrefix'] = "Table names prefix";
$GLOBALS['strTablesType'] = "Tip tabelă";

$GLOBALS['strRecoveryRequiredTitle'] = "Încercarea ta anterioară de actualizare a întâmpinat o eroare";
$GLOBALS['strRecoveryRequired'] = "A intervenit o eroare în timpul procesării actualizării anterioare şi {$PRODUCT_NAME} trebuie să încerce recuperarea procesului de actualizare. Te rugăm să faci click pe butonul Recuperează de mai jos.";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} is up to date";
$GLOBALS['strOaUpToDate'] = "Atât baza ta de date {$PRODUCT_NAME} cât şi structura de fişiere utilizează cea mai nouă versiune; ca atare nu este nevoie de nici o actualizare acum. Te rugăm să faci click pe Continuă pentru a accesa panoul de administrare {$PRODUCT_NAME}.";
$GLOBALS['strOaUpToDateCantRemove'] = "Atenţie: fişierul de ACTUALIZARE încă este prezent în dosarul var. Nu am putut şterge acest fişier din cauza permisiunilor insuficiente. Te rugăm să ştergi acest fişier.";
$GLOBALS['strErrorWritePermissions'] = "Au fost detectate erori legate de permisiunile fişierelor pe care trebuie să le corectezi înainte de a continua.<br />Pentru a repara aceste erori pe un sistem Linux, încearcă să introduci următoarele comenzi:";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod -R a+w %s</i>";
$GLOBALS['strNotWriteable'] = "NOT writeable";
$GLOBALS['strDirNotWriteableError'] = "Directory must be writeable";

$GLOBALS['strErrorWritePermissionsWin'] = "Au fost detectate erori legate de permisiunile fişierelor pe care trebuie să le corectezi înainte de a continua.";
$GLOBALS['strCheckDocumentation'] = "Pentru mai multe informaţii, te rugăm să citeşti <a href='{$PRODUCT_DOCSURL}'>documentaţia {$PRODUCT_NAME}</a>.";
$GLOBALS['strSystemCheckBadPHPConfig'] = "Your current PHP configuration does not meet requirements of {$PRODUCT_NAME}. To resolve the problems, please modify settings in your 'php.ini' file.";

$GLOBALS['strAdminUrlPrefix'] = "URL Interfaţă Admin";
$GLOBALS['strDeliveryUrlPrefix'] = "URL Motor de Livrare";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL Motor de Livrare (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL Stocare Imagini";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL Stocare Imagini (SSL)";


$GLOBALS['strUpgrade'] = "Upgrade";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Alege Secţiune";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons.
    If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues.
    If you want to secure your system, you need to lock the configuration file for this installation.";
$GLOBALS['strUnableToWriteConfig'] = "Nu pot efectua modificările în fişierul de configurare";
$GLOBALS['strUnableToWritePrefs'] = "Nu pot introduce aceste preferinţe în baza de date";
$GLOBALS['strImageDirLockedDetected'] = "<b>Dosarul de Imagini</b> furnizat nu poate fi scris de către server. <br>Nu poţi continua până când nu modifici permisiunile sau creezi acel dosar.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Setări configurare";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Utilizator Administrator";
$GLOBALS['strAdminPassword'] = "Parolă Administrator";
$GLOBALS['strInvalidUsername'] = "Utilizator Greşit";
$GLOBALS['strBasicInformation'] = "Informaţii de Bază";
$GLOBALS['strAdministratorEmail'] = "Adresa de E-mail a Administratorului";
$GLOBALS['strAdminCheckUpdates'] = "Automatically check for product updates and security alerts (Recommended).";
$GLOBALS['strAdminShareStack'] = "Share technical information with the {$PRODUCT_NAME} Team to help with development and testing.";
$GLOBALS['strNovice'] = "Acţiunile de ştergere necesită confirmare pentru siguranţă";
$GLOBALS['strUserlogEmail'] = "Păstrează jurnalul tuturor mesajelor email trimise";
$GLOBALS['strEnableDashboard'] = "Enable dashboard";
$GLOBALS['strEnableDashboardSyncNotice'] = "Te rugăm să activezi <a href='account-settings-update.php'>Verificare Actualizări</a> dacă doriţi să utilizaţi Panoul Principal.";
$GLOBALS['strTimezone'] = "Fus Orar";
$GLOBALS['strEnableAutoMaintenance'] = "Execută întreţinerea automat în timpul livrării reclamelor dacă întreţinerea planificată nu este setată";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Setări bază de date";
$GLOBALS['strDatabaseServer'] = "Setări Globale legate de Baza de Date";
$GLOBALS['strDbLocal'] = "Foloseşte conectarea pe socket-ul local";
$GLOBALS['strDbType'] = "Tip bază de Date";
$GLOBALS['strDbHost'] = "Gazdă bază de Date";
$GLOBALS['strDbSocket'] = "Socket bază de date";
$GLOBALS['strDbPort'] = "Număr Port bază de date";
$GLOBALS['strDbUser'] = "Utilizator bază de date";
$GLOBALS['strDbPassword'] = "Parolă bază de date";
$GLOBALS['strDbName'] = "Nume bază de date";
$GLOBALS['strDbNameHint'] = "Baza de date va fi creată dacă nu există";
$GLOBALS['strDatabaseOptimalisations'] = "Setări Optimizare Bază de Date";
$GLOBALS['strPersistentConnections'] = "Foloseşte Conexiuni Persistente";
$GLOBALS['strCantConnectToDb'] = "Nu mă pot conecta la Baza de Date";
$GLOBALS['strCantConnectToDbDelivery'] = 'Nu mă pot conecta la baza de date pentru livrare';

// Email Settings
$GLOBALS['strEmailSettings'] = "Setări Email";
$GLOBALS['strEmailAddresses'] = "Adresă \"Expeditor\" Email";
$GLOBALS['strEmailFromName'] = "Nume \"Expeditor\" Email";
$GLOBALS['strEmailFromAddress'] = "Adresă de E-mail \"Expeditor\" Email";
$GLOBALS['strEmailFromCompany'] = "Firmă \"Expeditor\" Email";
$GLOBALS['strUseManagerDetails'] = 'Use the owning account\'s Contact, Email and Name instead of the above Name, Email Address and Company when emailing reports to Advertiser or Website accounts.';
$GLOBALS['strQmailPatch'] = "patch qmail";
$GLOBALS['strEnableQmailPatch'] = "Activează patch-ul qmail";
$GLOBALS['strEmailHeader'] = "Headere email";
$GLOBALS['strEmailLog'] = "Jurnal email";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Setări ale Urmăririi Bilanţului";
$GLOBALS['strEnableAudit'] = "Activează Urmărirea Bilanţului";
$GLOBALS['strEnableAuditForZoneLinking'] = "Enable Audit Trail for Zone Linking screen (introduces huge performance penalty when linking large amounts of zones)";

// Debug Logging Settings
$GLOBALS['strDebug'] = "Setări Jurnal Depanare";
$GLOBALS['strEnableDebug'] = "Activează Jurnalul de Depanare";
$GLOBALS['strDebugMethodNames'] = "Include numele metodelor în jurnalul de depanare";
$GLOBALS['strDebugLineNumbers'] = "Include numerele liniilor în jurnalul de depanare";
$GLOBALS['strDebugType'] = "Tip Jurnal de Depanare";
$GLOBALS['strDebugTypeFile'] = "Fişier";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "Bază de Date SQL";
$GLOBALS['strDebugTypeSyslog'] = "Syslog";
$GLOBALS['strDebugName'] = "Nume Jurnal de Depanare, Calendar, Tabela SQL,<br /> sau Facilitatea Syslog";
$GLOBALS['strDebugPriority'] = "Nivel de Prioritate pentru Depanare";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Majoritatea Informaţiilor";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Informaţii Implicite";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - Ultimele Informaţii";
$GLOBALS['strDebugIdent'] = "Cuvânt Identificare Depanare";
$GLOBALS['strDebugUsername'] = "Utilizator mCal, SQL Server";
$GLOBALS['strDebugPassword'] = "Parolă mCal, SQL Server";
$GLOBALS['strProductionSystem'] = "Sistem de Producţie";

// Delivery Settings
$GLOBALS['strWebPath'] = "{$PRODUCT_NAME} Server Access Paths";
$GLOBALS['strWebPathSimple'] = "Locaţie web";
$GLOBALS['strDeliveryPath'] = "Locaţie livrare";
$GLOBALS['strImagePath'] = "Locaţie imagini";
$GLOBALS['strDeliverySslPath'] = "Locaţie SSL livrare";
$GLOBALS['strImageSslPath'] = "Locaţie SSL Imagini";
$GLOBALS['strImageStore'] = "Dosar imagini";
$GLOBALS['strTypeWebSettings'] = "Setări webserver pentru stocarea locală de bannere";
$GLOBALS['strTypeWebMode'] = "Metodă Stocare";
$GLOBALS['strTypeWebModeLocal'] = "Dosar Local";
$GLOBALS['strTypeDirError'] = "Dosarul local nu poate fi scris de către server.";
$GLOBALS['strTypeWebModeFtp'] = "Server FTP extern";
$GLOBALS['strTypeWebDir'] = "Dosar Local";
$GLOBALS['strTypeFTPHost'] = "Gazdă GTP";
$GLOBALS['strTypeFTPDirectory'] = "Dosar Gazdă";
$GLOBALS['strTypeFTPUsername'] = "Autentificare";
$GLOBALS['strTypeFTPPassword'] = "Parola";
$GLOBALS['strTypeFTPPassive'] = "Foloseşte FTP pasiv";
$GLOBALS['strTypeFTPErrorDir'] = "Dosarul FTP Gazdă nu există";
$GLOBALS['strTypeFTPErrorConnect'] = "Nu mă pot conecta la server-ul FTP, Utilizatorul sau Parola este greşit(ă)";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Instalarea ta de PHP nu suportă FTP.";
$GLOBALS['strTypeFTPErrorUpload'] = "Nu pot încărca fişierul pe server-ul FTP, verifică drepturile de scriere ale Dosarului Gazdă";
$GLOBALS['strTypeFTPErrorHost'] = "Adresa gazdă FTP nu este corectă";
$GLOBALS['strDeliveryFilenames'] = "Nume Fişiere de Livrare";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Click Reclamă";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "Variabile Conversii Reclamă";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Conţinut Reclamă";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "Conversie Reclamă";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "Conversie Reclamă (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Frame Reclamă";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Imagine Reclamă";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Reclamă (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Layer Reclamă";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Jurnal Reclamă";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Popup Reclamă";
$GLOBALS['strDeliveryFilenamesAdView'] = "Vizualizare Reclamă";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "Invocare XML RPC";
$GLOBALS['strDeliveryFilenamesLocal'] = "Invocare Locală";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Controler Faţă";
$GLOBALS['strDeliveryFilenamesFlash'] = "Include Flash (Poate fi un URL complet)";
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "Single Page Call";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "Single Page Call (JavaScript)";
$GLOBALS['strDeliveryCaching'] = "Setări Cache Distribuţie Banner";
$GLOBALS['strDeliveryCacheLimit'] = "Perioada între actualizările Cache-ului de Bannere (secunde)";
$GLOBALS['strDeliveryCacheStore'] = "Banner Delivery Cache Store Type";
$GLOBALS['strDeliveryAcls'] = "Evaluate banner delivery rules during delivery";
$GLOBALS['strDeliveryAclsDirectSelection'] = "Evaluate banner delivery rules for direct selected ads";
$GLOBALS['strDeliveryObfuscate'] = "Obfuscate delivery rule set when delivering ads";
$GLOBALS['strDeliveryExecPhp'] = "Permite execuţia codului PHP în reclame<br />(Atenţie: Risc de Securitate)";
$GLOBALS['strDeliveryCtDelimiter'] = "Separator Urmărire Click-uri pentru Terţe Părţi";
$GLOBALS['strGlobalDefaultBannerUrl'] = "URL Global către bannerul imagine implicit";
$GLOBALS['strP3PSettings'] = "Politici de Confidenţialitate P3P";
$GLOBALS['strUseP3P'] = "Foloseşte Politici P3P";
$GLOBALS['strP3PCompactPolicy'] = "Politică Compactă P3P";
$GLOBALS['strP3PPolicyLocation'] = "Locaţie Politică P3P";
$GLOBALS['strPrivacySettings'] = "Privacy Settings";
$GLOBALS['strDisableViewerId'] = "Disable unique Viewer Id cookie";
$GLOBALS['strAnonymiseIp'] = "Anonymise viewer IP addresses";

// General Settings
$GLOBALS['generalSettings'] = "Global General System Settings";
$GLOBALS['uiEnabled'] = "Interfaţa Utilizatorului Activată";
$GLOBALS['defaultLanguage'] = "Default System Language<br />(Each user can select their own language)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Setări de Localizare";
$GLOBALS['strGeotargeting'] = "Setări de Localizare";
$GLOBALS['strGeotargetingType'] = "Tip Modul de Localizare";
$GLOBALS['strGeoShowUnavailable'] = "Show geotargeting delivery rules even if GeoIP data unavailable";

// Interface Settings
$GLOBALS['strInventory'] = "Inventar";
$GLOBALS['strShowCampaignInfo'] = "Arată informaţii suplimentare ale campaniei în pagina de <i>Campanii</i>";
$GLOBALS['strShowBannerInfo'] = "Arată informaţii suplimentare despre banner în pagina de <i>Bannere</i>";
$GLOBALS['strShowCampaignPreview'] = "Afişează o previzualizare a tuturor banner-elor din pagina de <i>Bannere</i>";
$GLOBALS['strShowBannerHTML'] = "Arată banner-ul utilizat în locul codului HTML în pagina de previzualizare a banner-ului HTML";
$GLOBALS['strShowBannerPreview'] = "Afişează previzualizarea banner-ului în partea de sus a paginiilor care se ocupă cu bannere";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "Use the WYSIWYG HTML Editor by default when creating or editing HTML banners";
$GLOBALS['strHideInactive'] = "Ascunde inactivi";
$GLOBALS['strGUIShowMatchingBanners'] = "Afişează bannere care se potrivesc pe paginile de <i>Bannere asociate</i>";
$GLOBALS['strGUIShowParentCampaigns'] = "Afişează campaniile părinte pe paginile de <i>Bannere asociate</i>";
$GLOBALS['strShowEntityId'] = "Show entity identifiers";
$GLOBALS['strStatisticsDefaults'] = "Statistici";
$GLOBALS['strBeginOfWeek'] = "Începutul Săptămânii";
$GLOBALS['strPercentageDecimals'] = "Zecimale Procent";
$GLOBALS['strWeightDefaults'] = "Lăţime Implicită";
$GLOBALS['strDefaultBannerWeight'] = "Lăţime Banner Implicită";
$GLOBALS['strDefaultCampaignWeight'] = "Lăţime Campanie Implicită";
$GLOBALS['strConfirmationUI'] = "Confirmare în Interfaţa Utilizatorului";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "Codul pentru reclame implicit";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Activează Implicit Urmărirea Click-urilor pentru a 3-a parte";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Setări Livrare Banner";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Setări Jurnal pentru Banner";
$GLOBALS['strLogAdRequests'] = "Înregistrează o cerere de fiecare dată când un banner este cerut";
$GLOBALS['strLogAdImpressions'] = "Înregistrează o vizualizare de fiecare dată când un banner este vizualizat";
$GLOBALS['strLogAdClicks'] = "Înregistrează un click de fiecare dată când un vizitator face click pe un banner";
$GLOBALS['strReverseLookup'] = "Determină numele gazdă ale vizitatorilor prin reverse lookup când nu este furnizat";
$GLOBALS['strProxyLookup'] = "Încearcă aflarea adresei IP reale a vizitatorilor care se află în spatele unui server proxy";
$GLOBALS['strPreventLogging'] = "Blochează Setările de Înregistrare Jurnal pentru Bannere";
$GLOBALS['strIgnoreHosts'] = "Nu înregistra nici o statistică pentru vizitatorii care au oricare dintre următoarele adrese IP sau nume gazdă";
$GLOBALS['strIgnoreUserAgents'] = "<b>Nu</b> înregistra statistici pentru clienţii care au oricare din următoarele cuvinte în user-agent (unu-pe-linie)";
$GLOBALS['strEnforceUserAgents'] = "Înregistrează statistici <b>doar</b> pentru clienţii care au oricare din următoarele cuvinte în user-agent (unu-pe-linie)";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "Setări Stocare Banner";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "Use eCPM optimized priorities instead of remnant-weighted priorities";
$GLOBALS['strEnableContractECPM'] = "Use eCPM optimized priorities instead of standard contract priorities";
$GLOBALS['strEnableECPMfromRemnant'] = "(If you enable this feature all your remnant campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strEnableECPMfromECPM'] = "(If you disable this feature some of your active eCPM campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strInactivatedCampaigns'] = "List of campaigns which became inactive due to the changes in preferences:";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "Setări Întreţinere";
$GLOBALS['strConversionTracking'] = "Setări pentru Urmărirea Conversiilor";
$GLOBALS['strEnableConversionTracking'] = "Activează Urmărirea Conversiilor";
$GLOBALS['strBlockInactiveBanners'] = "Don't count ad impressions, clicks or re-direct the user to the target URL if the viewer clicks on a banner that is inactive";
$GLOBALS['strBlockAdClicks'] = "Nu contoriza Click-urile pe Reclame dacă vizitatorul a mai făcut click pe aceeaşi pereche reclamă/zonă în timpul specificat (secunde)";
$GLOBALS['strMaintenanceOI'] = "Intervalul Operaţiunii de Întreţinere (minute)";
$GLOBALS['strPrioritySettings'] = "Setări de Prioritate";
$GLOBALS['strPriorityInstantUpdate'] = "Actualizează priorităţile reclamelor imediat ce sunt făcute schimbări în Interfaţa Utilizatorului";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "Intentionally over-deliver Contract Campaigns<br />(% over-delivery)";
$GLOBALS['strDefaultImpConvWindow'] = "Default Ad Impression Conversion Window (seconds)";
$GLOBALS['strDefaultCliConvWindow'] = "Default Ad Click Conversion Window (seconds)";
$GLOBALS['strAdminEmailHeaders'] = "Add the following headers to each email message sent by {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Trimite o atenţionare când numărul de vizualizări rămase este mai mic decât cel specificat aici";
$GLOBALS['strWarnLimitDays'] = "Trimite o atenţionare când numărul de zile rămas este mai mic decât cel specificat aici";
$GLOBALS['strWarnAdmin'] = "Trimite o atenţionare administratorului de fiecare dată când o campanie se apropie de expirare";
$GLOBALS['strWarnClient'] = "Trimite o atenţionare advertiserului de fiecare dată când o campanie se apropie de expirare";
$GLOBALS['strWarnAgency'] = "Trimite o atenţionare agenţiei de fiecare dată când o campanie se apropie de expirare";

// UI Settings
$GLOBALS['strGuiSettings'] = "Setări Interfaţă Utilizator";
$GLOBALS['strGeneralSettings'] = "Setări Generale";
$GLOBALS['strAppName'] = "Nume Aplicaţie";
$GLOBALS['strMyHeader'] = "Locaţie Fişier Antet";
$GLOBALS['strMyFooter'] = "Locaţie Fişier Subsol";
$GLOBALS['strDefaultTrackerStatus'] = "Starea implicită a contorului";
$GLOBALS['strDefaultTrackerType'] = "Tipul implicit al contorului";
$GLOBALS['strSSLSettings'] = "Setări SSL";
$GLOBALS['requireSSL'] = "Forţează Accesul prin SSL la Interfaţa Utilizatorului";
$GLOBALS['sslPort'] = "Port SSL Folosit de Server-ul Web";
$GLOBALS['strDashboardSettings'] = "Setări Panou Principal";
$GLOBALS['strMyLogo'] = "Numele fişierului cu emblema personalizată";
$GLOBALS['strGuiHeaderForegroundColor'] = "Culoarea de prim-plan a antetului";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Culoarea de fundal a antetului";
$GLOBALS['strGuiActiveTabColor'] = "Culoarea secţiunii active";
$GLOBALS['strGuiHeaderTextColor'] = "Culoarea textului din antet";
$GLOBALS['strGuiSupportLink'] = "Custom URL for 'Support' link in header";
$GLOBALS['strGzipContentCompression'] = "Foloseşte Compresia GZIP pentru Conţinut";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "Platform Hash Regenerate";
$GLOBALS['strNewPlatformHash'] = "Your new Platform Hash is:";
$GLOBALS['strPlatformHashInsertingError'] = "Error inserting Platform Hash into database";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "Plugin Settings";
$GLOBALS['strEnableNewPlugins'] = "Enable newly installed plugins";
$GLOBALS['strUseMergedFunctions'] = "Use merged delivery functions file";
