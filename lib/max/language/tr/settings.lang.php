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
$GLOBALS['strBtnRetry'] = "Yeniden Dene";
$GLOBALS['strWarningRegisterArgcArv'] = "Bakım komut satırında çalışmak için PHP yapılandırma değişkeni register_argc_argv açık olmalıdır.";
$GLOBALS['strTablesPrefix'] = "Tablo isim önadları";
$GLOBALS['strTablesType'] = "Tablo tipleri";

$GLOBALS['strRecoveryRequiredTitle'] = "Önceki yükseltme girişiminiz bir hatayla karşılaştı";
$GLOBALS['strRecoveryRequired'] = "Önceki yükseltmenizi işleme koyarken bir hata oluştu ve {$PRODUCT_NAME}, yükseltme işlemini kurtarmaya çalışmalıdır. Lütfen aşağıdaki İyileştir düğmesine tıklayın.";

$GLOBALS['strOaUpToDateCantRemove'] = "YÜKSELTME dosyası hala 'var' klasörünüzün içinde bulunuyor. İzinler nedeniyle bu dosyayı kaldıramıyoruz. Lütfen bu dosyayı kendiniz silin.";
$GLOBALS['strErrorWritePermissions'] = "Dosya izin hataları tespit edildi ve devam etmeden önce düzeltilmesi gerekiyor. <br/> Bir Linux sistemindeki hataları düzeltmek için aşağıdaki komutları yazmayı deneyin:";

$GLOBALS['strErrorWritePermissionsWin'] = "Dosya izin hataları tespit edildi ve devam etmeden önce düzeltilmesi gerekiyor.";
$GLOBALS['strSystemCheckBadPHPConfig'] = "Geçerli PHP yapılandırmanız {$PRODUCT_NAME} şartlarını karşılamıyor. Sorunları çözmek için lütfen 'php.ini' dosyanızdaki ayarları değiştirin.";

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
$GLOBALS['strUseManagerDetails'] = 'Raporları Reklamverene veya Web sitesi hesaplarına e-postayla gönderirken, sahibi olduğunuz hesabın yukarıdaki Adı, E-posta Adresi ve Şirket adı yerine Kişi, E-posta ve Adı\'nı kullanın.';
$GLOBALS['strQmailPatch'] = "qmail patchini kullanın";
$GLOBALS['strEnableQmailPatch'] = "qmail patchini kullanın";
$GLOBALS['strEmailHeader'] = "E-posta başlıkları";

// Audit Trail Settings
$GLOBALS['strEnableAuditForZoneLinking'] = "Bölge bağlama ekranında Denetim İznini etkinleştirin (büyük miktarda bölgeyi bağlamak büyük performans gerektirir)";

// Debug Logging Settings
$GLOBALS['strDebugMethodNames'] = "Hata ayıklama günlüğüne yöntem adları ekleyin";
$GLOBALS['strDebugLineNumbers'] = "Satır numaralarını hata ayıklama günlüğüne ekle";
$GLOBALS['strDebugType'] = "Hata Ayıklama Günlüğü Türü";
$GLOBALS['strDebugTypeFile'] = "Dosya";

// Delivery Settings
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
$GLOBALS['strTypeFTPErrorConnect'] = "FTP Sunucusuna bağlanılamadı, Giriş veya Parola doğru değil";
$GLOBALS['strTypeFTPErrorNoSupport'] = "PHP kurulumunuz FTP'yi desteklemez.";
$GLOBALS['strTypeFTPErrorUpload'] = "FTP Sunucusuna dosya yüklenemedi, Ana Dizin için uygun hakları ayarlayın kontrol edin";
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
$GLOBALS['strP3PSettings'] = "P3P Gizlilik Politikaları";
$GLOBALS['strUseP3P'] = "P3P Politikalarını kullan";
$GLOBALS['strP3PCompactPolicy'] = "P3P Yoğunlaştırılmış politika";
$GLOBALS['strP3PPolicyLocation'] = "P3P Politika yeri";

// General Settings
$GLOBALS['generalSettings'] = "Global Genel Sistem Ayarları";
$GLOBALS['uiEnabled'] = "Kullanıcı Arayüzü Etkin";
$GLOBALS['defaultLanguage'] = "Varsayılan Sistem Dili<br/>(Her kullanıcı kendi dilini seçebilir)";

// Geotargeting Settings

// Interface Settings
$GLOBALS['strInventory'] = "Envanter";
$GLOBALS['strShowCampaignInfo'] = "<i>Kampanya önizleme</i> sayfasında ekstra kampanya bigilerini göster";
$GLOBALS['strShowBannerInfo'] = "<i>Banner önizleme</i> sayfasında ekstra banner bilgilerini göster";
$GLOBALS['strShowCampaignPreview'] = "<i>Banner önizleme</i> sayfasında tüm bannerları göster";
$GLOBALS['strShowBannerHTML'] = "HTML banner önizlemede düz HTML kodlu bannerlar haricindeki asıl bannerları göster";
$GLOBALS['strShowBannerPreview'] = "Sayfanın en üstünde uyan banner önizlemeyi göster";
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

// Banner Delivery Settings

// Banner Logging Settings
$GLOBALS['strReverseLookup'] = "DNS geri besleme";
$GLOBALS['strProxyLookup'] = "Proxy izleme";
$GLOBALS['strIgnoreHosts'] = "Sunuculara önem verme";

// Banner Storage Settings

// Campaign ECPM settings

// Statistics & Maintenance Settings
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
$GLOBALS['requireSSL'] = "Kullanıcı Arabiriminde SSL Erişimini Zorla";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Başlık arka planının rengi";
$GLOBALS['strGuiActiveTabColor'] = "Etkin sekmenin rengi";
$GLOBALS['strGuiHeaderTextColor'] = "Başlıktaki metnin rengi";
$GLOBALS['strGzipContentCompression'] = "Sıkıştırma için GZIP içeriğini kullan";

// Regenerate Platfor Hash script

// Plugin Settings
