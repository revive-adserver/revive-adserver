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
$GLOBALS['strBtnRecover'] = "";
$GLOBALS['strBtnAgree'] = "";
$GLOBALS['strBtnRetry'] = "Yeniden Dene";
$GLOBALS['strTablesPrefix'] = "Tablo isim önadları";
$GLOBALS['strTablesType'] = "Tablo tipleri";

$GLOBALS['strRecoveryRequiredTitle'] = "Önceki yükseltme girişiminiz bir hatayla karşılaştı";
$GLOBALS['strRecoveryRequired'] = "Önceki yükseltmenizi işleme koyarken bir hata oluştu ve {{PRODUCT_NAME}}, yükseltme işlemini kurtarmaya çalışmalıdır. Lütfen aşağıdaki İyileştir düğmesine tıklayın.";

$GLOBALS['strProductUpToDateTitle'] = "";
$GLOBALS['strOaUpToDate'] = "";
$GLOBALS['strOaUpToDateCantRemove'] = "YÜKSELTME dosyası hala 'var' klasörünüzün içinde bulunuyor. İzinler nedeniyle bu dosyayı kaldıramıyoruz. Lütfen bu dosyayı kendiniz silin.";
$GLOBALS['strErrorWritePermissions'] = "Dosya izin hataları tespit edildi ve devam etmeden önce düzeltilmesi gerekiyor. <br/> Bir Linux sistemindeki hataları düzeltmek için aşağıdaki komutları yazmayı deneyin:";
$GLOBALS['strErrorFixPermissionsRCommand'] = "";
$GLOBALS['strNotWriteable'] = "";
$GLOBALS['strDirNotWriteableError'] = "";

$GLOBALS['strErrorWritePermissionsWin'] = "Dosya izin hataları tespit edildi ve devam etmeden önce düzeltilmesi gerekiyor.";
$GLOBALS['strCheckDocumentation'] = "";
$GLOBALS['strSystemCheckBadPHPConfig'] = "Geçerli PHP yapılandırmanız {{PRODUCT_NAME}} şartlarını karşılamıyor. Sorunları çözmek için lütfen 'php.ini' dosyanızdaki ayarları değiştirin.";

$GLOBALS['strAdminUrlPrefix'] = "";
$GLOBALS['strDeliveryUrlPrefix'] = "Teslimat Motoru";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "Teslimat Motoru";
$GLOBALS['strImagesUrlPrefix'] = "Resim Mağazası URL'si";
$GLOBALS['strImagesUrlPrefixSSL'] = "Resim Mağazası URL'si (SSL)";


$GLOBALS['strUpgrade'] = "Yükselt";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Bölüm seçin";
$GLOBALS['strEditConfigNotPossible'] = "Güvenlik nedeniyle yapılandırma dosyası kilitlendiğinden tüm ayarları düzenlemek mümkün değildir.
     Değişiklik yapmak istiyorsanız, önce bu kurulum için yapılandırma dosyasının kilidini açmanız gerekebilir.";
$GLOBALS['strEditConfigPossible'] = "Yapılandırma dosyası kilitlenmediğinden tüm ayarları düzenlemek mümkündür, ancak bu güvenlik sorunlarına neden olabilir.
     Sisteminizi güvence altına almak istiyorsanız, bu yükleme için yapılandırma dosyasını kilitlemeniz gerekir.";
$GLOBALS['strUnableToWriteConfig'] = "Yapılandırma dosyasına değişiklik yazılamadı";
$GLOBALS['strUnableToWritePrefs'] = "Veritabanına tercihler konması yapılamıyor";
$GLOBALS['strImageDirLockedDetected'] = "";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Yapılandırma Ayarları";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Yönetici ismi";
$GLOBALS['strAdminPassword'] = "Yönetici parolası";
$GLOBALS['strInvalidUsername'] = "Geçersiz Kullanıcı Adı";
$GLOBALS['strBasicInformation'] = "Temel Bilgiler";
$GLOBALS['strAdministratorEmail'] = "Yönetici e-posta adresi";
$GLOBALS['strAdminCheckUpdates'] = "Güncellemeleri kontrol et";
$GLOBALS['strAdminShareStack'] = "Geliştirme ve testte yardımcı olması için {{PRODUCT_NAME}} Ekibi ile teknik bilgi paylaşın.";
$GLOBALS['strNovice'] = "Sil eylemleri, güvenlik için onay gerektirir";
$GLOBALS['strUserlogEmail'] = "Tüm giden e-mailleri logla";
$GLOBALS['strEnableDashboard'] = "Gösterge tablosunu etkinleştir";
$GLOBALS['strEnableDashboardSyncNotice'] = "";
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
$GLOBALS['strEmailFromName'] = "";
$GLOBALS['strEmailFromAddress'] = "";
$GLOBALS['strEmailFromCompany'] = "";
$GLOBALS['strUseManagerDetails'] = 'Raporları Reklamverene veya Web sitesi hesaplarına e-postayla gönderirken, sahibi olduğunuz hesabın yukarıdaki Adı, E-posta Adresi ve Şirket adı yerine Kişi, E-posta ve Adı\'nı kullanın.';
$GLOBALS['strQmailPatch'] = "qmail patchini kullanın";
$GLOBALS['strEnableQmailPatch'] = "qmail patchini kullanın";
$GLOBALS['strEmailHeader'] = "E-posta başlıkları";
$GLOBALS['strEmailLog'] = "";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "";
$GLOBALS['strEnableAudit'] = "";
$GLOBALS['strEnableAuditForZoneLinking'] = "Bölge bağlama ekranında Denetim İznini etkinleştirin (büyük miktarda bölgeyi bağlamak büyük performans gerektirir)";

// Debug Logging Settings
$GLOBALS['strDebug'] = "";
$GLOBALS['strEnableDebug'] = "";
$GLOBALS['strDebugMethodNames'] = "Hata ayıklama günlüğüne yöntem adları ekleyin";
$GLOBALS['strDebugLineNumbers'] = "Satır numaralarını hata ayıklama günlüğüne ekle";
$GLOBALS['strDebugType'] = "Hata Ayıklama Günlüğü Türü";
$GLOBALS['strDebugTypeFile'] = "Dosya";
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
$GLOBALS['strDeliveryPath'] = "";
$GLOBALS['strImagePath'] = "";
$GLOBALS['strDeliverySslPath'] = "";
$GLOBALS['strImageSslPath'] = "";
$GLOBALS['strImageStore'] = "";
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
$GLOBALS['strTypeFTPErrorDir'] = "";
$GLOBALS['strTypeFTPErrorConnect'] = "FTP Sunucusuna bağlanılamadı, Giriş veya Parola doğru değil";
$GLOBALS['strTypeFTPErrorNoSupport'] = "PHP kurulumunuz FTP'yi desteklemez.";
$GLOBALS['strTypeFTPErrorUpload'] = "FTP Sunucusuna dosya yüklenemedi, Ana Dizin için uygun hakları ayarlayın kontrol edin";
$GLOBALS['strTypeFTPErrorHost'] = "";
$GLOBALS['strDeliveryFilenames'] = "";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Reklam Tıklaması";
$GLOBALS['strDeliveryFilenamesSignedAdClick'] = "";
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
$GLOBALS['strP3PSettings'] = "P3P Gizlilik Politikaları";
$GLOBALS['strUseP3P'] = "P3P Politikalarını kullan";
$GLOBALS['strP3PCompactPolicy'] = "P3P Yoğunlaştırılmış politika";
$GLOBALS['strP3PPolicyLocation'] = "P3P Politika yeri";
$GLOBALS['strPrivacySettings'] = "";
$GLOBALS['strDisableViewerId'] = "";
$GLOBALS['strAnonymiseIp'] = "";

// General Settings
$GLOBALS['generalSettings'] = "Global Genel Sistem Ayarları";
$GLOBALS['uiEnabled'] = "Kullanıcı Arayüzü Etkin";
$GLOBALS['defaultLanguage'] = "Varsayılan Sistem Dili<br/>(Her kullanıcı kendi dilini seçebilir)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "";
$GLOBALS['strGeotargeting'] = "";
$GLOBALS['strGeotargetingType'] = "";
$GLOBALS['strGeoShowUnavailable'] = "";

// Interface Settings
$GLOBALS['strInventory'] = "Envanter";
$GLOBALS['strShowCampaignInfo'] = "<i>Kampanya önizleme</i> sayfasında ekstra kampanya bigilerini göster";
$GLOBALS['strShowBannerInfo'] = "<i>Banner önizleme</i> sayfasında ekstra banner bilgilerini göster";
$GLOBALS['strShowCampaignPreview'] = "<i>Banner önizleme</i> sayfasında tüm bannerları göster";
$GLOBALS['strShowBannerHTML'] = "HTML banner önizlemede düz HTML kodlu bannerlar haricindeki asıl bannerları göster";
$GLOBALS['strShowBannerPreview'] = "Sayfanın en üstünde uyan banner önizlemeyi göster";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "";
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
$GLOBALS['strInvocationDefaults'] = "";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "";
$GLOBALS['strLogAdRequests'] = "";
$GLOBALS['strLogAdImpressions'] = "";
$GLOBALS['strLogAdClicks'] = "";
$GLOBALS['strReverseLookup'] = "DNS geri besleme";
$GLOBALS['strProxyLookup'] = "Proxy izleme";
$GLOBALS['strPreventLogging'] = "";
$GLOBALS['strIgnoreHosts'] = "Sunuculara önem verme";
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
$GLOBALS['strDefaultTrackerStatus'] = "";
$GLOBALS['strDefaultTrackerType'] = "";
$GLOBALS['strSSLSettings'] = "";
$GLOBALS['requireSSL'] = "Kullanıcı Arabiriminde SSL Erişimini Zorla";
$GLOBALS['sslPort'] = "";
$GLOBALS['strDashboardSettings'] = "";
$GLOBALS['strMyLogo'] = "";
$GLOBALS['strGuiHeaderForegroundColor'] = "";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Başlık arka planının rengi";
$GLOBALS['strGuiActiveTabColor'] = "Etkin sekmenin rengi";
$GLOBALS['strGuiHeaderTextColor'] = "Başlıktaki metnin rengi";
$GLOBALS['strGuiSupportLink'] = "";
$GLOBALS['strGzipContentCompression'] = "Sıkıştırma için GZIP içeriğini kullan";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "";
$GLOBALS['strNewPlatformHash'] = "";
$GLOBALS['strPlatformHashInsertingError'] = "";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "";
$GLOBALS['strEnableNewPlugins'] = "";
$GLOBALS['strUseMergedFunctions'] = "";
