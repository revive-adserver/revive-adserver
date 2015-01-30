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
$GLOBALS['strAdminSettings'] = "Yönetici Ayarları";
$GLOBALS['strAdvancedSettings'] = "Gelişmiş Ayarlar";
$GLOBALS['strWarning'] = "Uyarı";
$GLOBALS['strTablesType'] = "Tablo tipleri";



$GLOBALS['strInstallSuccess'] = "<b>{$PRODUCT_NAME} kurulumu tamamlandı.</b><br><br>{$PRODUCT_NAME} programının düzgün çalışması için bakım programının
						   her saat çalışması gerekmektedir. Bu konuyla ilgili detaylı bilgiyi dökümanlarda bulabilirsiniz.
						   <br><br>Ayarlama sayfasına gitmek için <b>İleri</b>yi tıklayınız. <br>
						   Lütfen işlemlerinizi bitirdikten sonra config.inc.php dosyasının değişiklik iznini kilitleyiniz.";
$GLOBALS['strInstallNotSuccessful'] = "<b>{$PRODUCT_NAME} kurulumu gerçekleştirilemedi.</b><br /><br />Kurulum sürecinin bazı bölümleri çalışamadı.";
$GLOBALS['strErrorOccured'] = "Aşağıdaki hatalar oluştu:";
$GLOBALS['strErrorInstallDatabase'] = "Veritabanı yapısı oluşturulamıyor.";
$GLOBALS['strErrorInstallDbConnect'] = "Veritabanına bağlantı sağlanamıyor.";



$GLOBALS['strDeliveryUrlPrefix'] = "Teslimat Motoru";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "Teslimat Motoru";

$GLOBALS['strInvalidUserPwd'] = "Geçersiz kullanıcı adı veya parolası";

$GLOBALS['strUpgrade'] = "Güncelle";
$GLOBALS['strSystemUpToDate'] = "Sisteminiz güncellenmiştir, yeniden güncelleme gerekmemektedir. <br>Ana Sayfaya dönmek için <b>İleri</b>yi tıklayınız.";
$GLOBALS['strSystemNeedsUpgrade'] = "Veritabanı yapısı ve ayar dosyası düzgün çalışması için güncellenmesi için gerekiyor. Güncelleme için <b>İleriyi</b> tıklayınız. <br>Güncelleme bir kaç dakika sürebilir lütfen sabırlı olun.";
$GLOBALS['strSystemUpgradeBusy'] = "Sistem güncelleniyor, lütfen bekleyiniz...";
$GLOBALS['strSystemRebuildingCache'] = "Hafıza tekrar oluşturuluyor, lütfen bekleyiniz...";
$GLOBALS['strServiceUnavalable'] = "Siste geçici olarak çalışmıyor. Sistem güncelemesi devam ediyor";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Bölüm Seçiniz";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons. " .
    "If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues. " .
    "If you want to secure your system, you need to lock the configuration file for this installation.";

// Configuration Settings

// Administrator Settings
$GLOBALS['strAdministratorSettings'] = "Yönetici Ayarları";
$GLOBALS['strLoginCredentials'] = "Giriş güvenliği";
$GLOBALS['strAdminUsername'] = "Yönetici ismi";
$GLOBALS['strInvalidUsername'] = "Geçersiz Kullanıcı Adı";
$GLOBALS['strBasicInformation'] = "Temel Bilgiler";
$GLOBALS['strAdminFullName'] = "Yönetici Tam ismi";
$GLOBALS['strAdminEmail'] = "Yönetici e-mail adresi";
$GLOBALS['strCompanyName'] = "Firma İsmi";
$GLOBALS['strAdminCheckUpdates'] = "Güncellemeleri kontrol et";
$GLOBALS['strAdminCheckEveryLogin'] = "Her girişte";
$GLOBALS['strAdminCheckDaily'] = "Günlük";
$GLOBALS['strAdminCheckWeekly'] = "Haftalık";
$GLOBALS['strAdminCheckMonthly'] = "Aylık";
$GLOBALS['strAdminCheckNever'] = "Asla";
$GLOBALS['strUserlogEmail'] = "Tüm giden e-mailleri logla";


// Database Settings
$GLOBALS['strDatabaseSettings'] = "Veritabanı ayarları";
$GLOBALS['strDatabaseServer'] = "Veritabanı server";
$GLOBALS['strDbType'] = "Veritabanı adı";
$GLOBALS['strDbHost'] = "Veritabanı sunucu";
$GLOBALS['strDbUser'] = "Veritabanı kullanıcı adı";
$GLOBALS['strDbPassword'] = "Veritabanı parolası";
$GLOBALS['strDbName'] = "Veritabanı adı";
$GLOBALS['strDatabaseOptimalisations'] = "Veritabanı Uygunluğu";
$GLOBALS['strPersistentConnections'] = "Israrlı bağlantıları kullan";
$GLOBALS['strCantConnectToDb'] = "Veritabanına bağlanılamıyor";



// Email Settings
$GLOBALS['strEmailSettings'] = "Ana Ayarlar";
$GLOBALS['strQmailPatch'] = "qmail patchini kullanın";
$GLOBALS['strEnableQmailPatch'] = "qmail patchini kullanın";

// Audit Trail Settings

// Debug Logging Settings

// Delivery Settings
$GLOBALS['strWebPath'] = "$PRODUCT_NAME Server Access Paths";
$GLOBALS['strTypeWebSettings'] = "Yerel banner (Webserver) ayarları";
$GLOBALS['strTypeWebMode'] = "Depolama metodu";
$GLOBALS['strTypeWebModeLocal'] = "Yerel Klasörler";
$GLOBALS['strTypeWebModeFtp'] = "Harici FTP sunucu";
$GLOBALS['strTypeWebDir'] = "Yerel Klasörler";
$GLOBALS['strTypeFTPHost'] = "FTP Sunucu";
$GLOBALS['strTypeFTPDirectory'] = "Sunucu klasörü";
$GLOBALS['strTypeFTPUsername'] = "Giriş";
$GLOBALS['strTypeFTPPassword'] = "Parola";



$GLOBALS['strP3PSettings'] = "P3P Gizlilik Politikaları";
$GLOBALS['strUseP3P'] = "P3P Politikalarını kullan";
$GLOBALS['strP3PCompactPolicy'] = "P3P Yoğunlaştırılmış politika";
$GLOBALS['strP3PPolicyLocation'] = "P3P Politika yeri";

// General Settings

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
$GLOBALS['strStatisticsDefaults'] = "İstatistikler";
$GLOBALS['strBeginOfWeek'] = "Haftanın Başlangıcı";
$GLOBALS['strPercentageDecimals'] = "Yüzdelik Basamağı";
$GLOBALS['strWeightDefaults'] = "öntanımlı ağırlık";
$GLOBALS['strDefaultBannerWeight'] = "öntanımlı banner ağırlığı";
$GLOBALS['strDefaultCampaignWeight'] = "öntanımlı kampanya ağırlığı";
$GLOBALS['strDefaultBannerWErr'] = "öntanımlı banner ağırlığı pozitif tamsayı olmalıdır";
$GLOBALS['strDefaultCampaignWErr'] = "öntanımlı kampanya ağırlığı pozitif tamsayı olmalıdır";

$GLOBALS['strModesOfPayment'] = "Ödeme tipi";
$GLOBALS['strHelpFiles'] = "Yardım dosyası";
$GLOBALS['strHasTaxID'] = "Vergi numarası";

// CSV Import Settings
$GLOBALS['strDefaultConversionStatus'] = "Varsayılan dönüştürme kuralları";
$GLOBALS['strDefaultConversionType'] = "Varsayılan dönüştürme kuralları";

/**
 * @todo remove strBannerSettings if banner is only configurable as a preference
 *       rename // Banner Settings to  // Banner Preferences
 */
// Invocation Settings
$GLOBALS['strAllowedInvocationTypes'] = "İzin verilen invocation tipleri";

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
$GLOBALS['strWarnLimitErr'] = "Uyarı limiti pozitif tamsayı olmalıdır";
$GLOBALS['strWarnAdmin'] = "Uyarı Yöneticisi";
$GLOBALS['strWarnClient'] = "Reklamcıya uyarı";
$GLOBALS['strWarnAgency'] = "Reklamcıya uyarı";

// UI Settings
$GLOBALS['strGuiSettings'] = "Kullanıcı arabirimi ayarları";
$GLOBALS['strGeneralSettings'] = "Genel Ayarlar";
$GLOBALS['strAppName'] = "Uygulama Adı";
$GLOBALS['strMyHeader'] = "Altbilgi";
$GLOBALS['strMyFooter'] = "Altbilgi";


$GLOBALS['strGzipContentCompression'] = "Sıkıştırma için GZIP içeriğini kullan";
$GLOBALS['strClientInterface'] = "Reklamcı arayüzü ayarları";
$GLOBALS['strClientWelcomeEnabled'] = "Reklamcıya hoşgeldiniz mesajı";
$GLOBALS['strClientWelcomeText'] = "Hoşgeldiniz mesajı<br>(HTML taglarına izin veriliyor)";


// Regenerate Platfor Hash script

// Plugin Settings

/* ------------------------------------------------------- */
/* Unknown (unused?) translations                        */
/* ------------------------------------------------------- */

$GLOBALS['strKeywordRetrieval'] = "Anahtar kelime düzeltmeleri";
$GLOBALS['strBannerRetrieval'] = "Banner düzeltme metodu";
$GLOBALS['strRetrieveRandom'] = "Rastgele banner düzeltme (öntanımlı)";
$GLOBALS['strRetrieveNormalSeq'] = "Normal sıralı banner düzeltme";
$GLOBALS['strWeightSeq'] = "Ağarlık tabanlı sıralı banner düzeltme";
$GLOBALS['strFullSeq'] = "Tam sıralı banner düzeltme";
$GLOBALS['strUseConditionalKeys'] = "Şartlı anahtar kelimeleri kullan";
$GLOBALS['strUseMultipleKeys'] = "Birden fazla anahtar kullan";

$GLOBALS['strTableBorderColor'] = "Tablo Çerçeve rengi";
$GLOBALS['strTableBackColor'] = "Tablo Zemin Rengi";
$GLOBALS['strTableBackColorAlt'] = "Tablo Zemin Rengi (Alternatif)";
$GLOBALS['strMainBackColor'] = "Ana Zemin Rengi";
$GLOBALS['strTimeZone'] = "Zaman Alanı";
