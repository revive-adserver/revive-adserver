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
$GLOBALS['strInstall'] = "Kurulum";
$GLOBALS['strDatabaseSettings'] = "Veritabanı ayarları";
$GLOBALS['strAdminAccount'] = "Sistem Yöneticisi Hesabı";
$GLOBALS['strAdvancedSettings'] = "Gelişmiş Ayarlar";
$GLOBALS['strWarning'] = "Uyarı";
$GLOBALS['strBtnContinue'] = "Devam »";
$GLOBALS['strBtnRecover'] = "Recover »";
$GLOBALS['strBtnAgree'] = "I Agree »";
$GLOBALS['strBtnRetry'] = "Yeniden Dene";
$GLOBALS['strWarningRegisterArgcArv'] = "Bakım komut satırında çalışmak için PHP yapılandırma değişkeni register_argc_argv açık olmalıdır.";
$GLOBALS['strTablesPrefix'] = "Tablo isim önadları";
$GLOBALS['strTablesType'] = "Tablo tipleri";

$GLOBALS['strRecoveryRequiredTitle'] = "Önceki yükseltme girişiminiz bir hatayla karşılaştı";
$GLOBALS['strRecoveryRequired'] = "Önceki yükseltmenizi işleme koyarken bir hata oluştu ve {$PRODUCT_NAME}, yükseltme işlemini kurtarmaya çalışmalıdır. Lütfen aşağıdaki İyileştir düğmesine tıklayın.";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} is up to date";
$GLOBALS['strOaUpToDate'] = "Your {$PRODUCT_NAME} database and file structure are both using the most recent version and therefore no upgrade is required at this time. Please click Continue to proceed to the administration panel.";
$GLOBALS['strOaUpToDateCantRemove'] = "YÜKSELTME dosyası hala 'var' klasörünüzün içinde bulunuyor. İzinler nedeniyle bu dosyayı kaldıramıyoruz. Lütfen bu dosyayı kendiniz silin.";
$GLOBALS['strErrorWritePermissions'] = "Dosya izin hataları tespit edildi ve devam etmeden önce düzeltilmesi gerekiyor. <br/> Bir Linux sistemindeki hataları düzeltmek için aşağıdaki komutları yazmayı deneyin:";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod -R a+w %s</i>";
$GLOBALS['strNotWriteable'] = "NOT writeable";
$GLOBALS['strDirNotWriteableError'] = "Directory must be writeable";

$GLOBALS['strErrorWritePermissionsWin'] = "Dosya izin hataları tespit edildi ve devam etmeden önce düzeltilmesi gerekiyor.";
$GLOBALS['strCheckDocumentation'] = "For more help, please see the <a href=\"{$PRODUCT_DOCSURL}\">{$PRODUCT_NAME} documentation</a>.";
$GLOBALS['strSystemCheckBadPHPConfig'] = "Geçerli PHP yapılandırmanız {$PRODUCT_NAME} şartlarını karşılamıyor. Sorunları çözmek için lütfen 'php.ini' dosyanızdaki ayarları değiştirin.";

$GLOBALS['strAdminUrlPrefix'] = "Admin Interface URL";
$GLOBALS['strDeliveryUrlPrefix'] = "Teslimat Motoru";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "Teslimat Motoru";
$GLOBALS['strImagesUrlPrefix'] = "Resim Mağazası URL'si";
$GLOBALS['strImagesUrlPrefixSSL'] = "Resim Mağazası URL'si (SSL)";


$GLOBALS['strUpgrade'] = "Yükselt";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Bölüm Seçiniz";
$GLOBALS['strEditConfigNotPossible'] = "Güvenlik nedeniyle yapılandırma dosyası kilitlendiğinden tüm ayarları düzenlemek mümkün değildir.
     Değişiklik yapmak istiyorsanız, önce bu kurulum için yapılandırma dosyasının kilidini açmanız gerekebilir.";
$GLOBALS['strEditConfigPossible'] = "Yapılandırma dosyası kilitlenmediğinden tüm ayarları düzenlemek mümkündür, ancak bu güvenlik sorunlarına neden olabilir.
     Sisteminizi güvence altına almak istiyorsanız, bu yükleme için yapılandırma dosyasını kilitlemeniz gerekir.";
$GLOBALS['strUnableToWriteConfig'] = "Yapılandırma dosyasına değişiklik yazılamadı";
$GLOBALS['strUnableToWritePrefs'] = "Veritabanına tercihler konması yapılamıyor";
$GLOBALS['strImageDirLockedDetected'] = "The supplied <b>Images Folder</b> is not writeable by the server. <br>You can't proceed until you either change permissions of the folder or create the folder.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Yapılandırma Ayarları";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Yönetici ismi";
$GLOBALS['strAdminPassword'] = "Yönetici parolası";
$GLOBALS['strInvalidUsername'] = "Geçersiz Kullanıcı Adı";
$GLOBALS['strBasicInformation'] = "Temel Bilgiler";
$GLOBALS['strAdministratorEmail'] = "Yönetici e-posta adresi";
$GLOBALS['strAdminCheckUpdates'] = "Güncellemeleri kontrol et";
$GLOBALS['strAdminShareStack'] = "Geliştirme ve testte yardımcı olması için {$PRODUCT_NAME} Ekibi ile teknik bilgi paylaşın.";
$GLOBALS['strNovice'] = "Sil eylemleri, güvenlik için onay gerektirir";
$GLOBALS['strUserlogEmail'] = "Tüm giden e-mailleri logla";
$GLOBALS['strEnableDashboard'] = "Gösterge tablosunu etkinleştir";
$GLOBALS['strEnableDashboardSyncNotice'] = "Please enable <a href='account-settings-update.php'>check for updates</a> to use the dashboard.";
$GLOBALS['strTimezone'] = "Zaman Dilimi";
$GLOBALS['strEnableAutoMaintenance'] = "Planlanan bakım kurulmamışsa, teslimat sırasında otomatik olarak bakım gerçekleştirin";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Veritabanı ayarları";
$GLOBALS['strDatabaseServer'] = "Veritabanı server";
$GLOBALS['strDbLocal'] = "Yerel soket bağlantısını kullan";
$GLOBALS['strDbType'] = "Veritabanı adı";
$GLOBALS['strDbHost'] = "Veritabanı sunucu";
$GLOBALS['strDbSocket'] = "Veritabanı Soketi";
$GLOBALS['strDbPort'] = "Veritabanı Bağlantı Noktası Numarası";
$GLOBALS['strDbUser'] = "Veritabanı kullanıcı adı";
$GLOBALS['strDbPassword'] = "Veritabanı parolası";
$GLOBALS['strDbName'] = "Veritabanı adı";
$GLOBALS['strDbNameHint'] = "Veritabanı yoksa oluşturulacak";
$GLOBALS['strDatabaseOptimalisations'] = "Veritabanı Uygunluğu";
$GLOBALS['strPersistentConnections'] = "Israrlı bağlantıları kullan";
$GLOBALS['strCantConnectToDb'] = "Veritabanına bağlanılamıyor";
$GLOBALS['strCantConnectToDbDelivery'] = 'Teslimat için Veritabanına Bağlanılamıyor';

// Email Settings
$GLOBALS['strEmailSettings'] = "Ana Ayarlar";
$GLOBALS['strEmailAddresses'] = "E-posta 'Kimden' adresi";
$GLOBALS['strEmailFromName'] = "Email 'From' Name";
$GLOBALS['strEmailFromAddress'] = "Email 'From' Email Address";
$GLOBALS['strEmailFromCompany'] = "Email 'From' Company";
$GLOBALS['strUseManagerDetails'] = 'Raporları Reklamverene veya Web sitesi hesaplarına e-postayla gönderirken, sahibi olduğunuz hesabın yukarıdaki Adı, E-posta Adresi ve Şirket adı yerine Kişi, E-posta ve Adı\'nı kullanın.';
$GLOBALS['strQmailPatch'] = "qmail patchini kullanın";
$GLOBALS['strEnableQmailPatch'] = "qmail patchini kullanın";
$GLOBALS['strEmailHeader'] = "E-posta başlıkları";
$GLOBALS['strEmailLog'] = "Email log";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Audit Trail Settings";
$GLOBALS['strEnableAudit'] = "Enable Audit Trail";
$GLOBALS['strEnableAuditForZoneLinking'] = "Bölge bağlama ekranında Denetim İznini etkinleştirin (büyük miktarda bölgeyi bağlamak büyük performans gerektirir)";

// Debug Logging Settings
$GLOBALS['strDebug'] = "Debug Logging Settings";
$GLOBALS['strEnableDebug'] = "Enable Debug Logging";
$GLOBALS['strDebugMethodNames'] = "Hata ayıklama günlüğüne yöntem adları ekleyin";
$GLOBALS['strDebugLineNumbers'] = "Satır numaralarını hata ayıklama günlüğüne ekle";
$GLOBALS['strDebugType'] = "Hata Ayıklama Günlüğü Türü";
$GLOBALS['strDebugTypeFile'] = "Dosya";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "SQL Database";
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
$GLOBALS['strProductionSystem'] = "Production System";

// Delivery Settings
$GLOBALS['strWebPath'] = "{$PRODUCT_NAME} Server Access Paths";
$GLOBALS['strWebPathSimple'] = "Web path";
$GLOBALS['strDeliveryPath'] = "Delivery path";
$GLOBALS['strImagePath'] = "Images path";
$GLOBALS['strDeliverySslPath'] = "Delivery SSL path";
$GLOBALS['strImageSslPath'] = "Images SSL path";
$GLOBALS['strImageStore'] = "Images folder";
$GLOBALS['strTypeWebSettings'] = "Yerel banner (Webserver) ayarları";
$GLOBALS['strTypeWebMode'] = "Depolama metodu";
$GLOBALS['strTypeWebModeLocal'] = "Yerel Klasörler";
$GLOBALS['strTypeDirError'] = "Yerel dizine web sunucusu tarafından yazılamaz";
$GLOBALS['strTypeWebModeFtp'] = "Harici FTP sunucu";
$GLOBALS['strTypeWebDir'] = "Yerel Klasörler";
$GLOBALS['strTypeFTPHost'] = "FTP Sunucu";
$GLOBALS['strTypeFTPDirectory'] = "Sunucu klasörü";
$GLOBALS['strTypeFTPUsername'] = "Giriş";
$GLOBALS['strTypeFTPPassword'] = "Parola";
$GLOBALS['strTypeFTPPassive'] = "Pasif FTP kullan";
$GLOBALS['strTypeFTPErrorDir'] = "The FTP Host Directory does not exist";
$GLOBALS['strTypeFTPErrorConnect'] = "FTP Sunucusuna bağlanılamadı, Giriş veya Parola doğru değil";
$GLOBALS['strTypeFTPErrorNoSupport'] = "PHP kurulumunuz FTP'yi desteklemez.";
$GLOBALS['strTypeFTPErrorUpload'] = "FTP Sunucusuna dosya yüklenemedi, Ana Dizin için uygun hakları ayarlayın kontrol edin";
$GLOBALS['strTypeFTPErrorHost'] = "The FTP Host is not correct";
$GLOBALS['strDeliveryFilenames'] = "Delivery File Names";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Reklam Tıklaması";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "Reklam Dönüştürme Değişkenleri";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Reklam İçeriği";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "Reklam Dönüştürme";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "Reklam Dönüştürme (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Reklam Çerçevesi";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Reklam Resmi";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Reklam (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Reklam Katmanı";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Reklam Günlüğü";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Reklam Açılır Penceresi";
$GLOBALS['strDeliveryFilenamesAdView'] = "Reklam Görünümü";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "XML RPC Çağrısı";
$GLOBALS['strDeliveryFilenamesLocal'] = "Yerel Çağrı";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Front Controller";
$GLOBALS['strDeliveryFilenamesFlash'] = "Flash Include (Can be a full URL)";
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "Single Page Call";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "Single Page Call (JavaScript)";
$GLOBALS['strDeliveryCaching'] = "Banner Delivery Cache Settings";
$GLOBALS['strDeliveryCacheLimit'] = "Time Between Banner Cache Updates (seconds)";
$GLOBALS['strDeliveryCacheStore'] = "Banner Delivery Cache Store Type";
$GLOBALS['strDeliveryAcls'] = "Evaluate banner delivery rules during delivery";
$GLOBALS['strDeliveryAclsDirectSelection'] = "Evaluate banner delivery rules for direct selected ads";
$GLOBALS['strDeliveryObfuscate'] = "Obfuscate delivery rule set when delivering ads";
$GLOBALS['strDeliveryExecPhp'] = "Reklamlarda PHP kodunun çalıştırılmasına izin ver<br/>(Uyarı: Güvenlik riski)";
$GLOBALS['strDeliveryCtDelimiter'] = "3rd Party Click Tracking Delimiter";
$GLOBALS['strGlobalDefaultBannerUrl'] = "Global default Banner Image URL";
$GLOBALS['strP3PSettings'] = "P3P Gizlilik Politikaları";
$GLOBALS['strUseP3P'] = "P3P Politikalarını kullan";
$GLOBALS['strP3PCompactPolicy'] = "P3P Yoğunlaştırılmış politika";
$GLOBALS['strP3PPolicyLocation'] = "P3P Politika yeri";
$GLOBALS['strPrivacySettings'] = "Privacy Settings";
$GLOBALS['strDisableViewerId'] = "Disable unique Viewer Id cookie";
$GLOBALS['strAnonymiseIp'] = "Anonymise viewer IP addresses";

// General Settings
$GLOBALS['generalSettings'] = "Global Genel Sistem Ayarları";
$GLOBALS['uiEnabled'] = "Kullanıcı Arayüzü Etkin";
$GLOBALS['defaultLanguage'] = "Varsayılan Sistem Dili<br/>(Her kullanıcı kendi dilini seçebilir)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Geotargeting Settings";
$GLOBALS['strGeotargeting'] = "Geotargeting Settings";
$GLOBALS['strGeotargetingType'] = "Geotargeting Module Type";
$GLOBALS['strGeoShowUnavailable'] = "Show geotargeting delivery rules even if GeoIP data unavailable";

// Interface Settings
$GLOBALS['strInventory'] = "Envanter";
$GLOBALS['strShowCampaignInfo'] = "<i>Kampanya önizleme</i> sayfasında ekstra kampanya bigilerini göster";
$GLOBALS['strShowBannerInfo'] = "<i>Banner önizleme</i> sayfasında ekstra banner bilgilerini göster";
$GLOBALS['strShowCampaignPreview'] = "<i>Banner önizleme</i> sayfasında tüm bannerları göster";
$GLOBALS['strShowBannerHTML'] = "HTML banner önizlemede düz HTML kodlu bannerlar haricindeki asıl bannerları göster";
$GLOBALS['strShowBannerPreview'] = "Sayfanın en üstünde uyan banner önizlemeyi göster";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "Use the WYSIWYG HTML Editor by default when creating or editing HTML banners";
$GLOBALS['strHideInactive'] = "Etkin olmayanları gizle";
$GLOBALS['strGUIShowMatchingBanners'] = "<i>İlişkili Bannerlar</i> sayfalarında uyan bannerları göster";
$GLOBALS['strGUIShowParentCampaigns'] = "<i>ilişkili Bannerlar</i> sayfasında ebeveyn bannerları göster";
$GLOBALS['strShowEntityId'] = "Varlık tanımlayıcılarını göster";
$GLOBALS['strStatisticsDefaults'] = "İstatistikler";
$GLOBALS['strBeginOfWeek'] = "Haftanın Başlangıcı";
$GLOBALS['strPercentageDecimals'] = "Yüzdelik Basamağı";
$GLOBALS['strWeightDefaults'] = "öntanımlı ağırlık";
$GLOBALS['strDefaultBannerWeight'] = "öntanımlı banner ağırlığı";
$GLOBALS['strDefaultCampaignWeight'] = "öntanımlı kampanya ağırlığı";
$GLOBALS['strConfirmationUI'] = "Kullanıcı Arayüzünde Onaylama";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "Invocation Defaults";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Enable 3rd Party Clicktracking by Default";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Banner Delivery Settings";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Banner Logging Settings";
$GLOBALS['strLogAdRequests'] = "Log a request every time a banner is requested";
$GLOBALS['strLogAdImpressions'] = "Log an impression every time a banner is viewed";
$GLOBALS['strLogAdClicks'] = "Log a click every time a viewer clicks on a banner";
$GLOBALS['strReverseLookup'] = "DNS geri besleme";
$GLOBALS['strProxyLookup'] = "Proxy izleme";
$GLOBALS['strPreventLogging'] = "Block Banner Logging Settings";
$GLOBALS['strIgnoreHosts'] = "Sunuculara önem verme";
$GLOBALS['strIgnoreUserAgents'] = "<b>Don't</b> log statistics from clients with any of the following strings in their user-agent (one-per-line)";
$GLOBALS['strEnforceUserAgents'] = "<b>Only</b> log statistics from clients with any of the following strings in their user-agent (one-per-line)";

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
$GLOBALS['strAdminEmailHeaders'] = "Günlük raporlar için gönderici tanımlama mail başlığı";
$GLOBALS['strWarnLimit'] = "Uyarı Sınırı";
$GLOBALS['strWarnLimitDays'] = "Günler burada belirtilenden az olduğunda uyarı gönder";
$GLOBALS['strWarnAdmin'] = "Uyarı Yöneticisi";
$GLOBALS['strWarnClient'] = "Reklamcıya uyarı";
$GLOBALS['strWarnAgency'] = "Reklamcıya uyarı";

// UI Settings
$GLOBALS['strGuiSettings'] = "Kullanıcı arabirimi ayarları";
$GLOBALS['strGeneralSettings'] = "Genel Ayarlar";
$GLOBALS['strAppName'] = "Uygulama Adı";
$GLOBALS['strMyHeader'] = "Altbilgi";
$GLOBALS['strMyFooter'] = "Altbilgi";
$GLOBALS['strDefaultTrackerStatus'] = "Default tracker status";
$GLOBALS['strDefaultTrackerType'] = "Default tracker type";
$GLOBALS['strSSLSettings'] = "SSL Settings";
$GLOBALS['requireSSL'] = "Kullanıcı Arabiriminde SSL Erişimini Zorla";
$GLOBALS['sslPort'] = "SSL Port Used by Web Server";
$GLOBALS['strDashboardSettings'] = "Dashboard Settings";
$GLOBALS['strMyLogo'] = "Name/URL of custom logo file";
$GLOBALS['strGuiHeaderForegroundColor'] = "Color of the header foreground";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Başlık arka planının rengi";
$GLOBALS['strGuiActiveTabColor'] = "Etkin sekmenin rengi";
$GLOBALS['strGuiHeaderTextColor'] = "Başlıktaki metnin rengi";
$GLOBALS['strGuiSupportLink'] = "Custom URL for 'Support' link in header";
$GLOBALS['strGzipContentCompression'] = "Sıkıştırma için GZIP içeriğini kullan";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "Platform Hash Regenerate";
$GLOBALS['strNewPlatformHash'] = "Your new Platform Hash is:";
$GLOBALS['strPlatformHashInsertingError'] = "Error inserting Platform Hash into database";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "Plugin Settings";
$GLOBALS['strEnableNewPlugins'] = "Enable newly installed plugins";
$GLOBALS['strUseMergedFunctions'] = "Use merged delivery functions file";
