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
$GLOBALS['strInstall'] = "Namesti";
$GLOBALS['strDatabaseSettings'] = "Nastavitve podatkovne baze";
$GLOBALS['strAdminAccount'] = "Nadzorniški račun";
$GLOBALS['strAdvancedSettings'] = "Napredne nastavitve";
$GLOBALS['strWarning'] = "Opozorilo";
$GLOBALS['strBtnContinue'] = "Nadaljuj »";
$GLOBALS['strBtnRecover'] = "Povrni »";
$GLOBALS['strBtnAgree'] = "Strinjam se »";
$GLOBALS['strBtnRetry'] = "Poizkusi znova";
$GLOBALS['strWarningRegisterArgcArv'] = "PHP nastavitvena spremenljivka register_argc_argv mora biti omogočena za zagon vzdrževanja iz ukazne vrstice.";
$GLOBALS['strTablesPrefix'] = "Table names prefix";
$GLOBALS['strTablesType'] = "Tip tabele";

$GLOBALS['strRecoveryRequiredTitle'] = "Vaš prejšnji poizkus posodobitve je naletel na težavo";
$GLOBALS['strRecoveryRequired'] = "Prišlo je do napake med procesiranjem vaše prejšnje posodobitve. {$PRODUCT_NAME} bo poizkusil povrniti posodobitveni postopek. Prosimo, potrdite z klikom na gumb Povrni.";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} is up to date";
$GLOBALS['strOaUpToDate'] = "Vaša {$PRODUCT_NAME} podatkovna baza in struktura datotek uporabljata najnovejšo različico in zato posodobitev v tem trenutku ni potrebna. Kliknite \"Nadaljuj\" za napotitev v {$PRODUCT_NAME} Nadzorno ploščo.";
$GLOBALS['strOaUpToDateCantRemove'] = "Opozorilo: Posodobitvena datoteka je še vedno v vaši mapi. Zaradi varnostnih razlogov je ne moremo odstraniti. Prosimo, datoteko izbrišite ročno.";
$GLOBALS['strErrorWritePermissions'] = "Prišlo je do napak pri dostopu do datotek. Pred nadaljevanjem jih morate odpraviti.<br />Pri odpravi teh napak v sistemu Linux vtipkajte naslednji ukazni niz:";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod -R a+w %s</i>";
$GLOBALS['strNotWriteable'] = "NOT writeable";
$GLOBALS['strDirNotWriteableError'] = "Directory must be writeable";

$GLOBALS['strErrorWritePermissionsWin'] = "Prišlo je do napak pri dostopu do datotek. Pred nadaljevanjem jih morate odpraviti.";
$GLOBALS['strCheckDocumentation'] = "Za več pomoči si prosimo oglejte <a href='{$PRODUCT_DOCSURL}'>{$PRODUCT_NAME}  dokumentacijo</a>.";
$GLOBALS['strSystemCheckBadPHPConfig'] = "Your current PHP configuration does not meet requirements of {$PRODUCT_NAME}. To resolve the problems, please modify settings in your 'php.ini' file.";

$GLOBALS['strAdminUrlPrefix'] = "URL Nadzorniškega vmesnika";
$GLOBALS['strDeliveryUrlPrefix'] = "URL Dostavnega orodja";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL (SSL) Dostavnega orodja";
$GLOBALS['strImagesUrlPrefix'] = "URL Hrambe slik";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL (SSL) Hrambe slik";


$GLOBALS['strUpgrade'] = "Upgrade";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Izberi oddelek";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons.
    If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues.
    If you want to secure your system, you need to lock the configuration file for this installation.";
$GLOBALS['strUnableToWriteConfig'] = "V konfiguracijsko datoteko je bilo nemožno zapisati spremembe";
$GLOBALS['strUnableToWritePrefs'] = "Podatkovni bazi je bilo nemožno izročiti izbiro";
$GLOBALS['strImageDirLockedDetected'] = "Strežnik ne more zapisovati v <b>Mapo z slikami</b>. <br>Ne morete nadaljevati, dokler ne spremenite dovoljenj za to mapo ali pa ustvarite novo.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Konfiguracijske nastavitve";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Administrator  Uporabniško ime";
$GLOBALS['strAdminPassword'] = "Administrator  Geslo";
$GLOBALS['strInvalidUsername'] = "Napačno uporabniško ime";
$GLOBALS['strBasicInformation'] = "Osnovne informacije";
$GLOBALS['strAdministratorEmail'] = "E-pošta Administratorja";
$GLOBALS['strAdminCheckUpdates'] = "Samodejni preveri za posodobitve izdelka in varnostna opozorila (Priporočeno)";
$GLOBALS['strAdminShareStack'] = "Delite tehnične informacije z OpenX ekipo pri nadaljnem razvoju in testiranju.";
$GLOBALS['strNovice'] = "Zaradi varnostnih razlogov potrebujejo postopki o izbrisu potrditev";
$GLOBALS['strUserlogEmail'] = "Beleži vsa odhodna e-poštna sporočila";
$GLOBALS['strEnableDashboard'] = "Enable dashboard";
$GLOBALS['strEnableDashboardSyncNotice'] = "Prosimo, omogočite <a href='account-settings-update.php'>Preveri za posodobitve</a> , če bi želeli uporabljati Nadzorno ploščo.";
$GLOBALS['strTimezone'] = "Časovno področje";
$GLOBALS['strEnableAutoMaintenance'] = "Samodejno izvrši vzdrževalna dela med dostavo, če načrtovana vzdrževalna dela niso omogočena";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Nastavitve podatkovne baze";
$GLOBALS['strDatabaseServer'] = "Globalne nastavitve podatkovne strežniške baze (Global database server)";
$GLOBALS['strDbLocal'] = "Uporabi lokalni povezovalni vtič (socket connection)";
$GLOBALS['strDbType'] = "Tip podatkovne baze";
$GLOBALS['strDbHost'] = "Gostiteljsko ime podatkovne baze (Hostname)";
$GLOBALS['strDbSocket'] = "Vtičnica podatkovne baze";
$GLOBALS['strDbPort'] = "Številka vtiča podatkovne baze (Port number)";
$GLOBALS['strDbUser'] = "Uporabniško ime za podatkovno bazo";
$GLOBALS['strDbPassword'] = "Geslo za podatkovno bazo";
$GLOBALS['strDbName'] = "Ime podatkovne baze";
$GLOBALS['strDbNameHint'] = "Podatkovna baza bo ustvarjena, če ne obstaja";
$GLOBALS['strDatabaseOptimalisations'] = "Optimizacijske nastavitve podatkovne baze";
$GLOBALS['strPersistentConnections'] = "Uporabi trajne povezave (persistent connections)";
$GLOBALS['strCantConnectToDb'] = "Ne morem se povezati s podatkovno bazo";
$GLOBALS['strCantConnectToDbDelivery'] = 'Ne morem se povezati z podatkovno bazo';

// Email Settings
$GLOBALS['strEmailSettings'] = "Nastavitve za e-pošto";
$GLOBALS['strEmailAddresses'] = "Naslov \"From\" e-pošte";
$GLOBALS['strEmailFromName'] = "Ime \"From\" e-pošte";
$GLOBALS['strEmailFromAddress'] = "E-pošta \"From\" e-poštnega naslova";
$GLOBALS['strEmailFromCompany'] = "E-pošta \"From\" podjetja";
$GLOBALS['strUseManagerDetails'] = 'Use the owning account\'s Contact, Email and Name instead of the above Name, Email Address and Company when emailing reports to Advertiser or Website accounts.';
$GLOBALS['strQmailPatch'] = "qmail popravek";
$GLOBALS['strEnableQmailPatch'] = "Omogoči qmail popravek";
$GLOBALS['strEmailHeader'] = "Glava za e-pošto";
$GLOBALS['strEmailLog'] = "Beležka za e-pošto";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Nastavitve za pregled poti (audit trail)";
$GLOBALS['strEnableAudit'] = "Omogoči pregled poti (audit trail)";
$GLOBALS['strEnableAuditForZoneLinking'] = "Enable Audit Trail for Zone Linking screen (introduces huge performance penalty when linking large amounts of zones)";

// Debug Logging Settings
$GLOBALS['strDebug'] = "Nastavitve beleženja iskanja in odstranjevanja napak (debug)";
$GLOBALS['strEnableDebug'] = "Omogoči beleženje iskanja in odstranjevanja napak (debug)";
$GLOBALS['strDebugMethodNames'] = "Vključi imena postopkov v \"debug\" beležko";
$GLOBALS['strDebugLineNumbers'] = "Vključi številke nizov v \"debug\" beležko";
$GLOBALS['strDebugType'] = "Tip beležke za iskanje in odstranjevanje napak (debug)";
$GLOBALS['strDebugTypeFile'] = "Datoteka";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "SQL podatkovna baza";
$GLOBALS['strDebugTypeSyslog'] = "Sistemska beležka (syslog)";
$GLOBALS['strDebugName'] = "Ime beležke, Kolendar, SQL Tabela,<br />ali Sistemska beležka";
$GLOBALS['strDebugPriority'] = "Prioritetni nivo iskanja in odstranjevanja napak";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Največ informacij";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Privzete informacije";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - Najmanj informacij";
$GLOBALS['strDebugIdent'] = "\"Debug\" identifikacijski niz";
$GLOBALS['strDebugUsername'] = "mCal, SQL Uporabniško ime strežnika";
$GLOBALS['strDebugPassword'] = "mCal, SQL Geslo strežnika";
$GLOBALS['strProductionSystem'] = "Sistem produkcije";

// Delivery Settings
$GLOBALS['strWebPath'] = "{$PRODUCT_NAME} Server Access Paths";
$GLOBALS['strWebPathSimple'] = "Omrežna pot";
$GLOBALS['strDeliveryPath'] = "Dostavna pot";
$GLOBALS['strImagePath'] = "Pot slik";
$GLOBALS['strDeliverySslPath'] = "SSL Dostavna pot";
$GLOBALS['strImageSslPath'] = "SSL Pot slik";
$GLOBALS['strImageStore'] = "Mapa za slike";
$GLOBALS['strTypeWebSettings'] = "Nastavitve hrambe spletnega strežnika lokalne pasice";
$GLOBALS['strTypeWebMode'] = "Shranjevalni način";
$GLOBALS['strTypeWebModeLocal'] = "Lokalni imenik";
$GLOBALS['strTypeDirError'] = "Mrežni strežnik ne more zapisovati v lokalni imenik";
$GLOBALS['strTypeWebModeFtp'] = "Zunanji FTP strežnik";
$GLOBALS['strTypeWebDir'] = "Lokalni imenik";
$GLOBALS['strTypeFTPHost'] = "FTP gostitelj";
$GLOBALS['strTypeFTPDirectory'] = "Imenik gostitelja";
$GLOBALS['strTypeFTPUsername'] = "Prijava";
$GLOBALS['strTypeFTPPassword'] = "Geslo";
$GLOBALS['strTypeFTPPassive'] = "Uporabi pasivni FTP";
$GLOBALS['strTypeFTPErrorDir'] = "FTP imenik gostitelja ne obstaja";
$GLOBALS['strTypeFTPErrorConnect'] = "Ne morem se povezati s FTP strežnikom. Uporabniško ime ali geslo ni pravilno";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Vaša PHP namestitev ne podpira FTP-ja";
$GLOBALS['strTypeFTPErrorUpload'] = "Datoteke ni bilo mogoče naložiti na FTP strežnik. Preverite vse nastavitve.";
$GLOBALS['strTypeFTPErrorHost'] = "FTP gostitelj ni pravilen";
$GLOBALS['strDeliveryFilenames'] = "Dostavna imena datotek";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Klikov na oglas";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "Pretvorbenih spremenljivk oglasa";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Vsebina oglasa";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "Pretvorba oglasa";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "Pretvorba oglasa (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Okvir oglasa";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Slika oglasa";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Oglas (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Sloj oglasa";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Beležka oglasa";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Prikazujoč (Popup) oglas";
$GLOBALS['strDeliveryFilenamesAdView'] = "Prikaz oglasa";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "XML RPC Poziv";
$GLOBALS['strDeliveryFilenamesLocal'] = "Lokalni poziv";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Sprednji preglednik";
$GLOBALS['strDeliveryFilenamesFlash'] = "Vključujoč FLASH (lahko je poln URL)";
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "Single Page Call";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "Single Page Call (JavaScript)";
$GLOBALS['strDeliveryCaching'] = "Nastavitve dostavnega pomnilnika pasice";
$GLOBALS['strDeliveryCacheLimit'] = "Čas med posodobitvami pomnilnika pasice (v sekundah)";
$GLOBALS['strDeliveryCacheStore'] = "Tip hrambe pomnilnika dostavljanja pasice ";
$GLOBALS['strDeliveryAcls'] = "Evaluate banner delivery rules during delivery";
$GLOBALS['strDeliveryAclsDirectSelection'] = "Evaluate banner delivery rules for direct selected ads";
$GLOBALS['strDeliveryObfuscate'] = "Obfuscate delivery rule set when delivering ads";
$GLOBALS['strDeliveryExecPhp'] = "Dovoli izvedbo PHP kode v oglasih<br />(Opozorilo: Varnostno tveganje)";
$GLOBALS['strDeliveryCtDelimiter'] = "Omejitev zunanjih (3rd party) sledilnikov klikov";
$GLOBALS['strGlobalDefaultBannerUrl'] = "Privzet URL slikovne pasice ";
$GLOBALS['strP3PSettings'] = "P3P Varovanje zasebnosti";
$GLOBALS['strUseP3P'] = "Uporabi P3P polico";
$GLOBALS['strP3PCompactPolicy'] = "P3P pogodbena polica";
$GLOBALS['strP3PPolicyLocation'] = "Lokacija P3P police";
$GLOBALS['strPrivacySettings'] = "Privacy Settings";
$GLOBALS['strDisableViewerId'] = "Disable unique Viewer Id cookie";
$GLOBALS['strAnonymiseIp'] = "Anonymise viewer IP addresses";

// General Settings
$GLOBALS['generalSettings'] = "Globalne nastavitve sistema";
$GLOBALS['uiEnabled'] = "Uporabniški vmesnik je omogočen";
$GLOBALS['defaultLanguage'] = "Privzeti jezik sistema<br />(Vask uporabnik lahko izbere svoj jezik)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Geociljne nastavitve";
$GLOBALS['strGeotargeting'] = "Geociljne nastavitve";
$GLOBALS['strGeotargetingType'] = "Tip geociljnega modula";
$GLOBALS['strGeoShowUnavailable'] = "Show geotargeting delivery rules even if GeoIP data unavailable";

// Interface Settings
$GLOBALS['strInventory'] = "Inventar";
$GLOBALS['strShowCampaignInfo'] = "Prikaži dodatne informacije o kampanji na strani <i>Kampanje</i>";
$GLOBALS['strShowBannerInfo'] = "Prikaži dodatne informacije o pasici na strani <i>Pasice</i>";
$GLOBALS['strShowCampaignPreview'] = "Prikaži predogled vseh pasic na strani <i>Pasice</i>";
$GLOBALS['strShowBannerHTML'] = "Prikaži dejansko pasico namesto enostavne HTML kode pri predogledu HTML pasice";
$GLOBALS['strShowBannerPreview'] = "Prikaži predogled pasice na vrhu strani, ki obravnavajo pasice";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "Use the WYSIWYG HTML Editor by default when creating or editing HTML banners";
$GLOBALS['strHideInactive'] = "Skrij neaktivne";
$GLOBALS['strGUIShowMatchingBanners'] = "Prikaži ujemajoče pasice na strani <i>Pasica s povezavo</i>";
$GLOBALS['strGUIShowParentCampaigns'] = "Prikaži izvorne kampanje na strani <i>Pasica s povezavo</i>";
$GLOBALS['strShowEntityId'] = "Show entity identifiers";
$GLOBALS['strStatisticsDefaults'] = "Statistika";
$GLOBALS['strBeginOfWeek'] = "Začetek tedna";
$GLOBALS['strPercentageDecimals'] = "Decimalke po odstotkih";
$GLOBALS['strWeightDefaults'] = "Privzeta vrednost";
$GLOBALS['strDefaultBannerWeight'] = "Privzeta vrednost pasice";
$GLOBALS['strDefaultCampaignWeight'] = "Privzeta vrednost kampanje";
$GLOBALS['strConfirmationUI'] = "Potrditev v Uporabniškem vmesniku";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "Privzete pozivne nastavitve";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Omogoči privzeto zunanje sledenje klikov (3rd party)";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Nastavitve dostave pasice";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Nastavitve beleženja pasice";
$GLOBALS['strLogAdRequests'] = "Beleži zahtevo ob vsaki zahtevani pasici";
$GLOBALS['strLogAdImpressions'] = "Beleži ogled ob vsakem ogledu pasice";
$GLOBALS['strLogAdClicks'] = "Beleži klik ob vsakem kliku na pasico";
$GLOBALS['strReverseLookup'] = "Preglej imena gostiteljev obiskovalcev, če niso podana";
$GLOBALS['strProxyLookup'] = "Poizkusi ugotoviti prave IP naslove obiskovalcev, ki uporabljajo proxy strežnik";
$GLOBALS['strPreventLogging'] = "Blokiraj nastavitve beleženja pasic";
$GLOBALS['strIgnoreHosts'] = "Ne beleži statistike za uporabnike, ki uporabljajo naslednje IP naslove ali gostitelje";
$GLOBALS['strIgnoreUserAgents'] = "<b>Ne</b> beleži statistike odjemalcev z naslednjimi nizi v njihovem uporabniškem zastopniku (user-agent)(ena na vrstico)";
$GLOBALS['strEnforceUserAgents'] = "<b>Samo</b> beleži statistike odjemalcev z naslednjimi nizi v njihovem uporabniškem zastopniku (user-agent)(ena na vrstico)";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "Nastavitve hrambe pasic";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "Use eCPM optimized priorities instead of remnant-weighted priorities";
$GLOBALS['strEnableContractECPM'] = "Use eCPM optimized priorities instead of standard contract priorities";
$GLOBALS['strEnableECPMfromRemnant'] = "(If you enable this feature all your remnant campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strEnableECPMfromECPM'] = "(If you disable this feature some of your active eCPM campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strInactivatedCampaigns'] = "List of campaigns which became inactive due to the changes in preferences:";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "Vzdrževalne nastavitve";
$GLOBALS['strConversionTracking'] = "Nastavitve sledilnika pretvorb";
$GLOBALS['strEnableConversionTracking'] = "Omogoči sledenje pretvorb";
$GLOBALS['strBlockInactiveBanners'] = "Don't count ad impressions, clicks or re-direct the user to the target URL if the viewer clicks on a banner that is inactive";
$GLOBALS['strBlockAdClicks'] = "Ne štej klikov oglasa, če je obiskovalec kliknil na enak oglas/področje znotraj označenega časa (v sekundah)";
$GLOBALS['strMaintenanceOI'] = "Presledek vzdrževalnega postopka (v minutah)";
$GLOBALS['strPrioritySettings'] = "Prednostne nastavitve";
$GLOBALS['strPriorityInstantUpdate'] = "Takoj posodobi oglasne prioritete po spremembi uporabniškega vmesnika (UI)";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "Intentionally over-deliver Contract Campaigns<br />(% over-delivery)";
$GLOBALS['strDefaultImpConvWindow'] = "Default Ad Impression Conversion Window (seconds)";
$GLOBALS['strDefaultCliConvWindow'] = "Default Ad Click Conversion Window (seconds)";
$GLOBALS['strAdminEmailHeaders'] = "Add the following headers to each email message sent by {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Pošlji opozorilo ko je število preostalih učinkov manjše kot navedeno tukaj";
$GLOBALS['strWarnLimitDays'] = "Pošlji opozorilo ko je število preostalih dni manjše kot navedeno tukaj";
$GLOBALS['strWarnAdmin'] = "Pošlji opozorilo administratorju, ko se kampanja bliža svojemu koncu";
$GLOBALS['strWarnClient'] = "Pošlji opozorilo oglaševalcu, ko se kampanja bliža svojemu koncu";
$GLOBALS['strWarnAgency'] = "Pošlji opozorilo agenciji, ko se kampanja bliža svojemu koncu";

// UI Settings
$GLOBALS['strGuiSettings'] = "Nastavitve uporabniškega vmesnika";
$GLOBALS['strGeneralSettings'] = "Splošne nastavitve";
$GLOBALS['strAppName'] = "Ime aplikacije";
$GLOBALS['strMyHeader'] = "Lokacija header datoteke";
$GLOBALS['strMyFooter'] = "Lokacija footer datoteke";
$GLOBALS['strDefaultTrackerStatus'] = "Privzeto stanje sledilnika";
$GLOBALS['strDefaultTrackerType'] = "Privzeti tip sledilnika";
$GLOBALS['strSSLSettings'] = "SSL nastavitve";
$GLOBALS['requireSSL'] = "Vsili SSL dostop do uporabniškega vmesnika";
$GLOBALS['sslPort'] = "SSL port, ki ga uporablja Web Server";
$GLOBALS['strDashboardSettings'] = "Nastavitve Nadzorne plošče";
$GLOBALS['strMyLogo'] = "Ime datoteke po meri za logotip";
$GLOBALS['strGuiHeaderForegroundColor'] = "Barva header-ja v ospredju";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Barva header-ja v ozadju";
$GLOBALS['strGuiActiveTabColor'] = "Barva aktivnega zaznamka";
$GLOBALS['strGuiHeaderTextColor'] = "Barva besedila v header-ju";
$GLOBALS['strGuiSupportLink'] = "Custom URL for 'Support' link in header";
$GLOBALS['strGzipContentCompression'] = "Uporabi GZIP za stiskanje vsebine";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "Platform Hash Regenerate";
$GLOBALS['strNewPlatformHash'] = "Your new Platform Hash is:";
$GLOBALS['strPlatformHashInsertingError'] = "Error inserting Platform Hash into database";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "Plugin Settings";
$GLOBALS['strEnableNewPlugins'] = "Enable newly installed plugins";
$GLOBALS['strUseMergedFunctions'] = "Use merged delivery functions file";
