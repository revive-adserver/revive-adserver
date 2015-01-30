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
$GLOBALS['strAdminSettings'] = "Setări Administrator";
$GLOBALS['strAdminAccount'] = "Cont Administrator";
$GLOBALS['strAdvancedSettings'] = "Setări Avansate";
$GLOBALS['strWarning'] = "Avertisment";
$GLOBALS['strBtnContinue'] = "Continuă »";
$GLOBALS['strBtnRecover'] = "Recuperează »";
$GLOBALS['strBtnStartAgain'] = "Începe Actualizarea Din Nou »";
$GLOBALS['strBtnGoBack'] = "« Întoarce-te";
$GLOBALS['strBtnAgree'] = "Sunt de acord »";
$GLOBALS['strBtnDontAgree'] = "« Nu sunt de acord";
$GLOBALS['strBtnRetry'] = "Reîncearcă";
$GLOBALS['strWarningRegisterArgcArv'] = "Variabila register_argc_argv din configuraţia PHP trebuie setată pe on pentru a executa mentenanţa din linia de comandă.";
$GLOBALS['strTablesType'] = "Tip tabelă";


$GLOBALS['strRecoveryRequiredTitle'] = "Încercarea ta anterioară de actualizare a întâmpinat o eroare";
$GLOBALS['strRecoveryRequired'] = "A intervenit o eroare în timpul procesării actualizării anterioare şi {$PRODUCT_NAME} trebuie să încerce recuperarea procesului de actualizare. Te rugăm să faci click pe butonul Recuperează de mai jos.";

$GLOBALS['strOaUpToDate'] = "Atât baza ta de date {$PRODUCT_NAME} cât şi structura de fişiere utilizează cea mai nouă versiune; ca atare nu este nevoie de nici o actualizare acum. Te rugăm să faci click pe Continuă pentru a accesa panoul de administrare {$PRODUCT_NAME}.";
$GLOBALS['strOaUpToDateCantRemove'] = "Atenţie: fişierul de ACTUALIZARE încă este prezent în dosarul var. Nu am putut şterge acest fişier din cauza permisiunilor insuficiente. Te rugăm să ştergi acest fişier.";
$GLOBALS['strRemoveUpgradeFile'] = "Trebuie să ştergi fişierul de ACTUALIZARE din dosarul var.";
$GLOBALS['strInstallSuccess'] = "Apăsând 'Continuă' vei fi autentificat în server-ul tău de reclame.	<p><strong>Ce urmează?</strong></p>	<div class='psub'>	 <p><b>Înscrie-te pentru actualizările produsului</b><br>	 <a href='{$PRODUCT_DOCSURL}/wizard/join' target='_blank'>Înscrie-te în lista de mesaje a {$PRODUCT_NAME}</a> pentru actualizări de produs, alerte de securitate şi anunţuri noi legate de produs.	 </p>	 <p><b>Livrarea primei tale campanii</b><br>	 Use our <a href='{$PRODUCT_DOCSURL}/wizard/qsg-firstcampaign' target='_blank'>ghid rapid de început pentru a începe livrarea primei tale campanii</a>.	 </p>	</div>	<p><strong>Paşi opţionali de instalare</strong></p>	<div class='psub'>	 <p><b>Protejează-ţi fişierele de configurare</b><br>	 Acesta este un pas foarte bun de securitate pentru a-ţi proteja setările de configurarea ale server-ului tău de reclame de a fi alterate. <a href='{$PRODUCT_DOCSURL}/wizard/lock-config' target='_blank'>Află mai multe</a>.	 </p>	 <p><b>Setează o sarcină de întreţinere periodică</b><br>	 Este recomandat un script de întreţinere pentru a asigura raportarea la timp şi cea mai bună performanţă posibilă pentru livrarea reclamelor. <a href='{$PRODUCT_DOCSURL}/wizard/setup-cron' target='_blank'>Află mai multe</a>	 </p>	 <p><b>Revizuieşte setările de configurare ale sistemului tău</b><br>	 Înainte de a începe folosirea {$PRODUCT_NAME} îţi sugerăm să revizuieşti setările tale din secţiune 'Setări'.	 </p>	</div>";
$GLOBALS['strInstallNotSuccessful'] = "<b>Instalarea {$PRODUCT_NAME} nu a avut succes</b><br /><br />Unii paşi din procesul de instalare nu au putut fi finalizaţi.
Este posibil ca aceste probleme să fie doar temporare, în acest caz doar apeşi pe <b>Începe</b> şi te întorci la
primul pas al procesului de instalare. Dacă doreşti să afli mai multe despre semnificaţia mesajelor de eroare de mai jos, şi cum să le rezolvi,
te rugăm să consulţi documentaţia oferită.";
$GLOBALS['strDbSuccessIntro'] = "Baza de date {$PRODUCT_NAME} a fost acum creată. Te rugăm să faci click pe butonul 'Continuă' pentru a revizui setările legate de Livrarea şi Administrarea {$PRODUCT_NAME}.";
$GLOBALS['strDbSuccessIntroUpgrade'] = "Sistemul tău a fost actualizat cu succes. Următoarele pagini ce vor fi afişate te vor ajuta să actualizezi configuraţia noului server de reclame.";

$GLOBALS['strErrorWritePermissions'] = "Au fost detectate erori legate de permisiunile fişierelor pe care trebuie să le corectezi înainte de a continua.<br />Pentru a repara aceste erori pe un sistem Linux, încearcă să introduci următoarele comenzi:";

$GLOBALS['strErrorWritePermissionsWin'] = "Au fost detectate erori legate de permisiunile fişierelor pe care trebuie să le corectezi înainte de a continua.";
$GLOBALS['strCheckDocumentation'] = "Pentru mai multe informaţii, te rugăm să citeşti <a href='{$PRODUCT_DOCSURL}'>documentaţia {$PRODUCT_NAME}</a>.";

$GLOBALS['strAdminUrlPrefix'] = "URL Interfaţă Admin";
$GLOBALS['strDeliveryUrlPrefix'] = "URL Motor de Livrare";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL Motor de Livrare (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL Stocare Imagini";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL Stocare Imagini (SSL)";



/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Alege Secţiune";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons. " .
    "If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues. " .
    "If you want to secure your system, you need to lock the configuration file for this installation.";
$GLOBALS['strUnableToWriteConfig'] = "Nu pot efectua modificările în fişierul de configurare";
$GLOBALS['strUnableToWritePrefs'] = "Nu pot introduce aceste preferinţe în baza de date";
$GLOBALS['strImageDirLockedDetected'] = "<b>Dosarul de Imagini</b> furnizat nu poate fi scris de către server. <br>Nu poţi continua până când nu modifici permisiunile sau creezi acel dosar.";

// Configuration Settings
$GLOBALS['strConfigurationSetup'] = "Lista de configurare";
$GLOBALS['strConfigurationSettings'] = "Setări configurare";

// Administrator Settings
$GLOBALS['strAdministratorSettings'] = "Setări Administrator";
$GLOBALS['strLoginCredentials'] = "Drepturi Autentificare";
$GLOBALS['strAdminUsername'] = "Utilizator Administrator";
$GLOBALS['strAdminPassword'] = "Parolă Administrator";
$GLOBALS['strInvalidUsername'] = "Utilizator Greşit";
$GLOBALS['strBasicInformation'] = "Informaţii de Bază";
$GLOBALS['strAdminFullName'] = "Numele Complet al Administratorului";
$GLOBALS['strAdminEmail'] = "Adresa de E-mail a Administratorului";
$GLOBALS['strAdministratorEmail'] = "Adresa de E-mail a Administratorului";
$GLOBALS['strCompanyName'] = "Numele Companiei";
$GLOBALS['strNovice'] = "Acţiunile de ştergere necesită confirmare pentru siguranţă";
$GLOBALS['strUserlogEmail'] = "Păstrează jurnalul tuturor mesajelor email trimise";
$GLOBALS['strEnableDashboardSyncNotice'] = "Te rugăm să activezi <a href='account-settings-update.php'>Verificare Actualizări</a> dacă doriţi să utilizaţi Panoul Principal.";
$GLOBALS['strTimezone'] = "Fus Orar";
$GLOBALS['strTimezoneEstimated'] = "Fus Orar Estimat";
$GLOBALS['strTimezoneGuessedValue'] = "Fusul Orar al server-ul nu este setat corect în PHP";
$GLOBALS['strTimezoneSeeDocs'] = "Te rugăm să citeşti %DOCS% legat de setarea acestei variabile pentru PHP.";
$GLOBALS['strTimezoneDocumentation'] = "documentaţie";
$GLOBALS['strAdminSettingsTitle'] = "Creează un cont de administrator";
$GLOBALS['strAdminSettingsIntro'] = "Te rugăm să completezi acest formular pentru a-ţi crea contul de administrator pentru acest server de reclame.";
$GLOBALS['strConfigSettingsIntro'] = "Te rugăm să verifici setările de configurare de mai jos şi să faci orice schimbări necesare înainte de a continua. Dacă nu eşti sigur, lasă valorile implicite.";

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
$GLOBALS['strDemoDataInstall'] = "Instalează Date Demonstrative";
$GLOBALS['strDemoDataIntro'] = "Datele implicite ale instalării pot fi încărcate în {$PRODUCT_NAME} pentru a te ajuta să începi livrarea de reclame online. Majoritatea tipurilor de bannere comune, ca de altfel şi câteva campanii iniţiale pot fi încărcate şi pre-configurate. Această opţiune este recomandată pentru instalările noi.";



// Email Settings
$GLOBALS['strEmailSettings'] = "Setări Email";
$GLOBALS['strEmailAddresses'] = "Adresă \"Expeditor\" Email";
$GLOBALS['strEmailFromName'] = "Nume \"Expeditor\" Email";
$GLOBALS['strEmailFromAddress'] = "Adresă de E-mail \"Expeditor\" Email";
$GLOBALS['strEmailFromCompany'] = "Firmă \"Expeditor\" Email";
$GLOBALS['strQmailPatch'] = "patch qmail";
$GLOBALS['strEnableQmailPatch'] = "Activează patch-ul qmail";
$GLOBALS['strEmailHeader'] = "Headere email";
$GLOBALS['strEmailLog'] = "Jurnal email";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Setări ale Urmăririi Bilanţului";
$GLOBALS['strEnableAudit'] = "Activează Urmărirea Bilanţului";

// Debug Logging Settings
$GLOBALS['strDebug'] = "Setări Jurnal Depanare";
$GLOBALS['strProduction'] = "Server de producţie";
$GLOBALS['strEnableDebug'] = "Activează Jurnalul de Depanare";
$GLOBALS['strDebugMethodNames'] = "Include numele metodelor în jurnalul de depanare";
$GLOBALS['strDebugLineNumbers'] = "Include numerele liniilor în jurnalul de depanare";
$GLOBALS['strDebugType'] = "Tip Jurnal de Depanare";
$GLOBALS['strDebugTypeFile'] = "Fişier";
$GLOBALS['strDebugTypeSql'] = "Bază de Date SQL";
$GLOBALS['strDebugName'] = "Nume Jurnal de Depanare, Calendar, Tabela SQL,<br /> sau Facilitatea Syslog";
$GLOBALS['strDebugPriority'] = "Nivel de Prioritate pentru Depanare";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Majoritatea Informaţiilor";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Informaţii Implicite";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - Ultimele Informaţii";
$GLOBALS['strDebugIdent'] = "Cuvânt Identificare Depanare";
$GLOBALS['strDebugUsername'] = "Utilizator mCal, SQL Server";
$GLOBALS['strDebugPassword'] = "Parolă mCal, SQL Server";
$GLOBALS['strProductionSystem'] = "Sistem de Producţie";

// Delivery Settings
$GLOBALS['strDeliverySettings'] = "Setări Livrare";
$GLOBALS['strWebPath'] = "$PRODUCT_NAME Server Access Paths";
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
$GLOBALS['strDeliveryCaching'] = "Setări Cache Distribuţie Banner";
$GLOBALS['strDeliveryCacheLimit'] = "Perioada între actualizările Cache-ului de Bannere (secunde)";


$GLOBALS['strOrigin'] = "Foloseşte de la distanţă server principal";
$GLOBALS['strOriginType'] = "Tip server principal";
$GLOBALS['strOriginHost'] = "Nume Gazdă pentru server principal";
$GLOBALS['strOriginPort'] = "Număr port pentru baza de date principală";
$GLOBALS['strOriginScript'] = "Fişier script pentru baza de date principală";
$GLOBALS['strOriginTimeout'] = "Timeout Principal (secunde)";
$GLOBALS['strOriginProtocol'] = "Protocol server principal";

$GLOBALS['strDeliveryAcls'] = "Evaluează limitările de distribuţie ale banner-ului în timpul livrării";
$GLOBALS['strDeliveryObfuscate'] = "Ascunde canalul în timpul livrării reclamelor";
$GLOBALS['strDeliveryExecPhp'] = "Permite execuţia codului PHP în reclame<br />(Atenţie: Risc de Securitate)";
$GLOBALS['strDeliveryCtDelimiter'] = "Separator Urmărire Click-uri pentru Terţe Părţi";
$GLOBALS['strGlobalDefaultBannerUrl'] = "URL Global către bannerul imagine implicit";
$GLOBALS['strP3PSettings'] = "Politici de Confidenţialitate P3P";
$GLOBALS['strUseP3P'] = "Foloseşte Politici P3P";
$GLOBALS['strP3PCompactPolicy'] = "Politică Compactă P3P";
$GLOBALS['strP3PPolicyLocation'] = "Locaţie Politică P3P";

// General Settings
$GLOBALS['uiEnabled'] = "Interfaţa Utilizatorului Activată";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Setări de Localizare";
$GLOBALS['strGeotargeting'] = "Setări de Localizare";
$GLOBALS['strGeotargetingType'] = "Tip Modul de Localizare";
$GLOBALS['strGeotargetingUseBundledCountryDb'] = "Foloseşte baza de date MaxMind GeoLiteCountry inclusă";
$GLOBALS['strGeotargetingGeoipCountryLocation'] = "Locaţia Bazei de Date MaxMind GeoIP cu Ţări";
$GLOBALS['strGeotargetingGeoipRegionLocation'] = "Locaţia Bazei de Date MaxMind GeoIP cu Regiuni";
$GLOBALS['strGeotargetingGeoipCityLocation'] = "Locaţia Bazei de Date MaxMind GeoIP cu Oraşe";
$GLOBALS['strGeotargetingGeoipAreaLocation'] = "Locaţia Bazei de Date MaxMind GeoIP cu Judeţe";
$GLOBALS['strGeotargetingGeoipDmaLocation'] = "Locaţia Bazei de Date MaxMind GeoIP cu DMA";
$GLOBALS['strGeotargetingGeoipOrgLocation'] = "Locaţia Bazei de Date MaxMind GeoIP cu Organizaţii";
$GLOBALS['strGeotargetingGeoipIspLocation'] = "Locaţia Bazei de Date MaxMind GeoIP cu ISP";
$GLOBALS['strGeotargetingGeoipNetspeedLocation'] = "Locaţia Bazei de Date MaxMind GeoIP cu Viteza Internet-ului";
$GLOBALS['strGeoShowUnavailable'] = "Afişează limitările de livrare în funcţie de localizare chiar dacă GeoIP nu este valabil";
$GLOBALS['strGeotrackingGeoipCountryLocationError'] = "Baza de Date MaxMind GeoIP cu Ţări nu există în locaţia specificată ";
$GLOBALS['strGeotrackingGeoipRegionLocationError'] = "Baza de Date MaxMind GeoIP cu Regiuni nu există în locaţia specificată ";
$GLOBALS['strGeotrackingGeoipCityLocationError'] = "Baza de Date MaxMind GeoIP cu Oraşe nu există în locaţia specificată ";
$GLOBALS['strGeotrackingGeoipAreaLocationError'] = "Baza de Date MaxMind GeoIP cu Judeţe nu există în locaţia specificată ";
$GLOBALS['strGeotrackingGeoipDmaLocationError'] = "Baza de Date MaxMind GeoIP cu DMA nu există în locaţia specificată ";
$GLOBALS['strGeotrackingGeoipOrgLocationError'] = "Baza de Date MaxMind GeoIP cu Organizaţii nu există în locaţia specificată ";
$GLOBALS['strGeotrackingGeoipIspLocationError'] = "Baza de Date MaxMind GeoIP cu ISP nu există în locaţia specificată ";
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = "Baza de Date MaxMind GeoIP cu Viteza Internet-ului nu există în locaţia specificată ";

// Interface Settings
$GLOBALS['strInventory'] = "Inventar";
$GLOBALS['strShowCampaignInfo'] = "Arată informaţii suplimentare ale campaniei în pagina de <i>Campanii</i>";
$GLOBALS['strShowBannerInfo'] = "Arată informaţii suplimentare despre banner în pagina de <i>Bannere</i>";
$GLOBALS['strShowCampaignPreview'] = "Afişează o previzualizare a tuturor banner-elor din pagina de <i>Bannere</i>";
$GLOBALS['strShowBannerHTML'] = "Arată banner-ul utilizat în locul codului HTML în pagina de previzualizare a banner-ului HTML";
$GLOBALS['strShowBannerPreview'] = "Afişează previzualizarea banner-ului în partea de sus a paginiilor care se ocupă cu bannere";
$GLOBALS['strHideInactive'] = "Ascunde inactivi";
$GLOBALS['strGUIShowMatchingBanners'] = "Afişează bannere care se potrivesc pe paginile de <i>Bannere asociate</i>";
$GLOBALS['strGUIShowParentCampaigns'] = "Afişează campaniile părinte pe paginile de <i>Bannere asociate</i>";
$GLOBALS['strGUIAnonymousCampaignsByDefault'] = "Campanii Implicite pentru Anonimi";
$GLOBALS['strStatisticsDefaults'] = "Statistici";
$GLOBALS['strBeginOfWeek'] = "Începutul Săptămânii";
$GLOBALS['strPercentageDecimals'] = "Zecimale Procent";
$GLOBALS['strWeightDefaults'] = "Lăţime Implicită";
$GLOBALS['strDefaultBannerWeight'] = "Lăţime Banner Implicită";
$GLOBALS['strDefaultCampaignWeight'] = "Lăţime Campanie Implicită";
$GLOBALS['strConfirmationUI'] = "Confirmare în Interfaţa Utilizatorului";

$GLOBALS['strPublisherDefaults'] = "Setări website implicite";
$GLOBALS['strModesOfPayment'] = "Modalitate de plată";
$GLOBALS['strCurrencies'] = "Valute";
$GLOBALS['strCategories'] = "Categorii";
$GLOBALS['strHelpFiles'] = "Fişiere ajutor";
$GLOBALS['strHasTaxID'] = "Nr. de înregistrare";
$GLOBALS['strDefaultApproved'] = "Căsuţă de selectare aprobat";

// CSV Import Settings
$GLOBALS['strDefaultConversionStatus'] = "Reguli implicite de conversie";
$GLOBALS['strDefaultConversionType'] = "Reguli implicite de conversie";

/**
 * @todo remove strBannerSettings if banner is only configurable as a preference
 *       rename // Banner Settings to  // Banner Preferences
 */
// Invocation Settings
$GLOBALS['strAllowedInvocationTypes'] = "Tipuri de Cod pentru Reclame Permise";
$GLOBALS['strInvocationDefaults'] = "Codul pentru reclame implicit";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Activează Implicit Urmărirea Click-urilor pentru a 3-a parte";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Setări Livrare Banner";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Setări Jurnal pentru Banner";
$GLOBALS['strLogAdRequests'] = "Înregistrează o cerere de fiecare dată când un banner este cerut";
$GLOBALS['strLogAdImpressions'] = "Înregistrează o vizualizare de fiecare dată când un banner este vizualizat";
$GLOBALS['strLogAdClicks'] = "Înregistrează un click de fiecare dată când un vizitator face click pe un banner";
$GLOBALS['strLogTrackerImpressions'] = "Înregistrează o vizualizare a contorului de fiecare dată când contorul este vizualizat";
$GLOBALS['strReverseLookup'] = "Determină numele gazdă ale vizitatorilor prin reverse lookup când nu este furnizat";
$GLOBALS['strProxyLookup'] = "Încearcă aflarea adresei IP reale a vizitatorilor care se află în spatele unui server proxy";
$GLOBALS['strPreventLogging'] = "Blochează Setările de Înregistrare Jurnal pentru Bannere";
$GLOBALS['strIgnoreHosts'] = "Nu înregistra nici o statistică pentru vizitatorii care au oricare dintre următoarele adrese IP sau nume gazdă";
$GLOBALS['strIgnoreUserAgents'] = "<b>Nu</b> înregistra statistici pentru clienţii care au oricare din următoarele cuvinte în user-agent (unu-pe-linie)";
$GLOBALS['strEnforceUserAgents'] = "Înregistrează statistici <b>doar</b> pentru clienţii care au oricare din următoarele cuvinte în user-agent (unu-pe-linie)";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "Setări Stocare Banner";

// Campaign ECPM settings

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "Setări Întreţinere";
$GLOBALS['strConversionTracking'] = "Setări pentru Urmărirea Conversiilor";
$GLOBALS['strEnableConversionTracking'] = "Activează Urmărirea Conversiilor";
$GLOBALS['strCsvImport'] = "Permite încărcarea de conversii offline";
$GLOBALS['strBlockAdViews'] = "Nu contoriza Vizualizările Reclamei daca vizitatorul a mai văzut perechea reclamă/zonă în timpul specificat (secunde)";
$GLOBALS['strBlockAdViewsError'] = "Valorea de blocare a Vizualizării Reclamelor trebuie să fie un număr întreg pozitiv";
$GLOBALS['strBlockAdClicks'] = "Nu contoriza Click-urile pe Reclame dacă vizitatorul a mai făcut click pe aceeaşi pereche reclamă/zonă în timpul specificat (secunde)";
$GLOBALS['strBlockAdClicksError'] = "Valorea de blocare a Click-urilor pe Reclame trebuie să fie un număr întreg pozitiv";
$GLOBALS['strMaintenanceOI'] = "Intervalul Operaţiunii de Întreţinere (minute)";
$GLOBALS['strMaintenanceOIError'] = "Intervalul Operaţiunii de Întreţinere nu este corect - citeşte documentaţia pentru valorile valide";
$GLOBALS['strPrioritySettings'] = "Setări de Prioritate";
$GLOBALS['strPriorityInstantUpdate'] = "Actualizează priorităţile reclamelor imediat ce sunt făcute schimbări în Interfaţa Utilizatorului";
$GLOBALS['strDefaultImpConWindow'] = "Fereastra Implicită de Conectare a Vizualizării Reclamei (secunde)";
$GLOBALS['strDefaultImpConWindowError'] = "Dacă este setată, Fereastra Implicită de Conectare a Vizualizării Reclamei trebuie să fie un număr întreg pozitiv";
$GLOBALS['strDefaultCliConWindow'] = "Fereastra Implicită de Conectare a Click-ului pe Reclamă";
$GLOBALS['strDefaultCliConWindowError'] = "Dacă este setată, Fereastra Implicită de Conectare a Click-ului pe Reclamă trebuie să fie un număr întreg pozitiv";
$GLOBALS['strWarnLimit'] = "Trimite o atenţionare când numărul de vizualizări rămase este mai mic decât cel specificat aici";
$GLOBALS['strWarnLimitErr'] = "Limita de Atenţionare trebuie să fie un număr întreg pozitiv";
$GLOBALS['strWarnLimitDays'] = "Trimite o atenţionare când numărul de zile rămas este mai mic decât cel specificat aici";
$GLOBALS['strWarnLimitDaysErr'] = "Limita de Atenţionare pentru Zile trebuie să fie un număr întreg pozitiv";
$GLOBALS['strAllowEmail'] = "Permite tuturor trimiterea de e-mailuri";
$GLOBALS['strEmailAddressFrom'] = "Adresa de e-mail de unde să se trimită rapoartele";
$GLOBALS['strEmailAddressName'] = "Companie sau nume personal pentru semnarea e-mail-ului";
$GLOBALS['strWarnAdmin'] = "Trimite o atenţionare administratorului de fiecare dată când o campanie se apropie de expirare";
$GLOBALS['strWarnClient'] = "Trimite o atenţionare advertiserului de fiecare dată când o campanie se apropie de expirare";
$GLOBALS['strWarnAgency'] = "Trimite o atenţionare agenţiei de fiecare dată când o campanie se apropie de expirare";

// UI Settings
$GLOBALS['strGuiSettings'] = "Setări Interfaţă Utilizator";
$GLOBALS['strGeneralSettings'] = "Setări Generale";
$GLOBALS['strAppName'] = "Nume Aplicaţie";
$GLOBALS['strMyHeader'] = "Locaţie Fişier Antet";
$GLOBALS['strMyHeaderError'] = "Fişierul antet nu există în locaţia specificată";
$GLOBALS['strMyFooter'] = "Locaţie Fişier Subsol";
$GLOBALS['strMyFooterError'] = "Fişierul subsol nu există în locaţia specificată";
$GLOBALS['strDefaultTrackerStatus'] = "Starea implicită a contorului";
$GLOBALS['strDefaultTrackerType'] = "Tipul implicit al contorului";
$GLOBALS['strSSLSettings'] = "Setări SSL";
$GLOBALS['requireSSL'] = "Forţează Accesul prin SSL la Interfaţa Utilizatorului";
$GLOBALS['sslPort'] = "Port SSL Folosit de Server-ul Web";
$GLOBALS['strDashboardSettings'] = "Setări Panou Principal";

$GLOBALS['strMyLogo'] = "Numele fişierului cu emblema personalizată";
$GLOBALS['strMyLogoError'] = "Fişierul cu emblema nu există în dosarul admin/images";
$GLOBALS['strGuiHeaderForegroundColor'] = "Culoarea de prim-plan a antetului";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Culoarea de fundal a antetului";
$GLOBALS['strGuiActiveTabColor'] = "Culoarea secţiunii active";
$GLOBALS['strGuiHeaderTextColor'] = "Culoarea textului din antet";
$GLOBALS['strColorError'] = "Te rugăm să introduci culorile în format RGB, precum '0066CC'";

$GLOBALS['strGzipContentCompression'] = "Foloseşte Compresia GZIP pentru Conţinut";
$GLOBALS['strClientInterface'] = "Interfaţă Advertiser";
$GLOBALS['strReportsInterface'] = "Interfaţă Rapoarte";
$GLOBALS['strClientWelcomeEnabled'] = "Activează Mesajul de Întâmpinare al Advertiserului";
$GLOBALS['strClientWelcomeText'] = "Text de Întâmpinare<br />(Tag-uri HTML Permise)";

$GLOBALS['strPublisherInterface'] = "Interfaţă Întâmpinare";
$GLOBALS['strPublisherAgreementEnabled'] = "Permite autentificarea website-urilor care nu au acceptat Termenii şi Condiţiile";
$GLOBALS['strPublisherAgreementText'] = "Text autentificare (Tag-uri HTML permise)";

// Regenerate Platfor Hash script

// Plugin Settings

/* ------------------------------------------------------- */
/* Unknown (unused?) translations                        */
/* ------------------------------------------------------- */


