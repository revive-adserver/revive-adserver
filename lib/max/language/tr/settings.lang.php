<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

// Installer translation strings
$GLOBALS['strInstall']				= "Kurulum";
$GLOBALS['strChooseInstallLanguage']		= "Kurulum sürecinde kullanacağnız dili seçiniz";
$GLOBALS['strLanguageSelection']		= "Dil Seçimi";
$GLOBALS['strDatabaseSettings']			= "Veritabanı Ayarları";
$GLOBALS['strAdminSettings']			= "Yönetici Ayarları";
$GLOBALS['strAdvancedSettings']			= "Gelişmiş Ayarlar";
$GLOBALS['strOtherSettings']			= "Diğer Ayarlar";

$GLOBALS['strWarning']				= "Uyarı";
$GLOBALS['strFatalError']			= "Tehlikeli hata oluştu";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname." programı bu sistemde zaten kurulu. Ayarları düzenlemek istiyorsanız <a href='settings-index.php'>ayarlar bölümüne</a> gidiniz";
$GLOBALS['strCouldNotConnectToDB']		= "Veritabanına bağlanılamadı, lütfen belirtmiş olduğunuz ayarları kontrol ediniz";
$GLOBALS['strCreateTableTestFailed']		= "Belirtmiş olduğunuz kullanıcı veritabanı yapısına ekleme yapma iznine sahip değil, veritabanı yöneticinizle irtibata geçiniz.";
$GLOBALS['strUpdateTableTestFailed']		= "Belirtmiş olduğunuz kullanıcı veritabanı yapısını değiştirme iznine sahip değil, veritabanı yöneticinizle irtibata geçiniz.";
$GLOBALS['strTablePrefixInvalid']		= "Tablo önadları geçersiz karakter içeriyor";
$GLOBALS['strTableInUse']			= "Belirtmiş olduğunuz önadlar ".$phpAds_productname." programı tarafından kullanılıyor, lütfen farklı önad tanımlayın, veya klavuzu okuyunuz.";
$GLOBALS['strMayNotFunction']			= "Devam etmeden önce aşağıdaki problemleri düzeltiniz:";
$GLOBALS['strIgnoreWarnings']			= "Hataları yoksay";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." programı PHP 4.0 ve üzeri sürümleri daha iyi çalışması için destekler. şu anda PHPnin {php_version} sürümünü kullanıyorsunuz.";
$GLOBALS['strWarningRegisterGlobals']		= "PHP ayarlarındaki register_globals değişkeni <b>on</b> olmalıdır.";
$GLOBALS['strWarningMagicQuotesGPC']		= "PHP ayarlarındaki magic_quotes_gpc değişkeni <b>on</b> olmalıdır.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "PHP ayarlarındaki magic_quotes_runtime değişkeni <b>off</b> olmalıdır.";
$GLOBALS['strWarningFileUploads']		= "PHP ayarlarındaki file_uploads değişkeni <b>on</b> olmalıdır.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." programı <b>config.inc.php</b> dosyasının güncellenemediğini tespit etti.<br> Dosyanın izinlerini değiştirmeden kurulum işlemini gerçekleştiremezsiniz. <br>Bunun nasıl yapılacağını bilmiyorsanız lütfen klavuzu okuyunuz.";
$GLOBALS['strCantUpdateDB']  			= "Şu anda veritabanını güncelleme izni yok. Eğer devam etmek istiyorsanız, tüm bannerlar, istatistikler ve reklamlarsilinecek.";
$GLOBALS['strTableNames']			= "Tablo isimleri";
$GLOBALS['strTablesPrefix']			= "Tablo isim önadları";
$GLOBALS['strTablesType']			= "Tablo tipleri";

$GLOBALS['strInstallWelcome']			= "Hoşgeldiniz ".$phpAds_productname;
$GLOBALS['strInstallMessage']			= $phpAds_productname." programı kullnmaya başlamadan önce ayarlanması ve <br> veritabanının oluşturulması gerekiyor. Devam etmek için <b>İlerleye</b> tıklayınyz.";
$GLOBALS['strInstallSuccess']			= "<b>".$phpAds_productname." kurulumu tamamlandı.</b><br><br>".$phpAds_productname." programının düzgün çalışması için bakım programının
						   her saat çalışması gerekmektedir. Bu konuyla ilgili detaylı bilgiyi dökümanlarda bulabilirsiniz.
						   <br><br>Ayarlama sayfasına gitmek için <b>İleri</b>yi tıklayınız. <br>
						   Lütfen işlemlerinizi bitirdikten sonra config.inc.php dosyasının değişiklik iznini kilitleyiniz.";
$GLOBALS['strUpdateSuccess']			= "<b> ".$phpAds_productname." güncellemeleri başarıyla yüklendi.</b><br><br>".$phpAds_productname." programının düzenli olarak çalışması için
						   her saat bakım programını çalıştırınız (Daha önceki sürümlerde bu günde bir defa idi). Bu konuyla ilgili detaylı bilgiyi dökümanlarda bulabilirsiniz.
						   <br><br>Yönetici paneline gitmek için <b>İleri</b>yi tıklayınız. Lütfen işlemlerinizi bitirdikten sonra config.inc.php dosyasının değişiklik iznini kilitleyiniz.";
$GLOBALS['strInstallNotSuccessful']		= "<b>".$phpAds_productname." kurulumu gerçekleştirilemedi.</b><br><br>Kurulum sürecinin bazı bölümleri çalışamadı.
						   Bu problemler geçici olabilir, kurulumun ilk adımına dönmek için <b>İleri</b>yi tıklayınız. Aşağıdaki hataların ne manaya geldiğini öğrenmek ve çözmek istiyorsanız,
						   dökümanlara başvurunuz.";
$GLOBALS['strErrorOccured']			= "Aşağıdaki hatalar oluştu:";
$GLOBALS['strErrorInstallDatabase']		= "Veritabanı yapısı oluşturulamıyor.";
$GLOBALS['strErrorInstallConfig']		= "Ayar dosyası veya veritabanı düzenlenemiyor.";
$GLOBALS['strErrorInstallDbConnect']		= "Veritabanına bağlantı sağlanamıyor.";

$GLOBALS['strUrlPrefix']			= "URL Önadı";

$GLOBALS['strProceed']				= "İleri >";
$GLOBALS['strRepeatPassword']			= "Parola Tekrarı";
$GLOBALS['strNotSamePasswords']			= "Parolalar uyuşmuyor";
$GLOBALS['strInvalidUserPwd']			= "Geçersiz kullanıcı adı veya parolası";

$GLOBALS['strUpgrade']				= "Güncelle";
$GLOBALS['strSystemUpToDate']			= "Sisteminiz güncellenmiştir, yeniden güncelleme gerekmemektedir. <br>Ana Sayfaya dönmek için <b>İleri</b>yi tıklayınız.";
$GLOBALS['strSystemNeedsUpgrade']		= "Veritabanı yapısı ve ayar dosyası düzgün çalışması için güncellenmesi için gerekiyor. Güncelleme için <b>İleriyi</b> tıklayınız. <br>Güncelleme bir kaç dakika sürebilir lütfen sabırlı olun.";
$GLOBALS['strSystemUpgradeBusy']		= "Sistem güncelleniyor, lütfen bekleyiniz...";
$GLOBALS['strSystemRebuildingCache']		= "Hafıza tekrar oluşturuluyor, lütfen bekleyiniz...";
$GLOBALS['strServiceUnavalable']		= "Siste geçici olarak çalışmıyor. Sistem güncelemesi devam ediyor";

$GLOBALS['strConfigNotWritable']		= "config.inc.php dosyası yazılamıyor";





/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']			= "Bölüm Seçiniz";
$GLOBALS['strDayFullNames'] 			= array("Pazar","Pazartesi","Salı","Çarşamba","Perşembe","Cuma","Cumartesi");
$GLOBALS['strEditConfigNotPossible']   		= "Ayarları düzenleyemiyorsunuz. çünkü ayar dosyanız güvenlik nedeniyle kilitlenmiş.<br> ".
										  "Düzenleme yapmanız için, config.inc.php dosyasının kilidini açınız.";
$GLOBALS['strEditConfigPossible']		= "Tüm düzenleme işlemlerini yapabilirsiniz çünkü ayar dosyası kilitli değil, ama bu güvenlik açıklıklarına sebep olabilir.<br> ".
										  "Sisteminizi korumak istiyorsanız, config.inc.php dosyasını kilitleyiniz.";



// Database
$GLOBALS['strDatabaseSettings']			= "Veritabanı ayarları";
$GLOBALS['strDatabaseServer']			= "Veritabanı server";
$GLOBALS['strDbHost']				= "Veritabanı sunucu";
$GLOBALS['strDbUser']				= "Veritabanı kullanıcı adı";
$GLOBALS['strDbPassword']			= "Veritabanı parolası";
$GLOBALS['strDbName']				= "Veritabanı adı";

$GLOBALS['strDatabaseOptimalisations']		= "Veritabanı Uygunluğu";
$GLOBALS['strPersistentConnections']		= "Israrlı bağlantıları kullan";
$GLOBALS['strInsertDelayed']			= "Ertelemeli eklemeleri kullan";
$GLOBALS['strCompatibilityMode']		= "Veritabanı uyumluluk modunu kullan";
$GLOBALS['strCantConnectToDb']			= "Veritabanına bağlanılamıyor";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "Invocation ve Teslimat Ayarları";

$GLOBALS['strAllowedInvocationTypes']		= "İzin verilen invocation tipleri";
$GLOBALS['strAllowRemoteInvocation']		= "Uzak Invocationlara izin ver";
$GLOBALS['strAllowRemoteJavascript']		= "Javascript için Uzak Invocation izin ver";
$GLOBALS['strAllowRemoteFrames']		= "Frameler için Uzak Invocation izin ver";
$GLOBALS['strAllowRemoteXMLRPC']		= "XML-RPC kullanan Uzak Invocation izin ver";
$GLOBALS['strAllowLocalmode']			= "Yerel Mod izni ver";
$GLOBALS['strAllowInterstitial']		= "Interstitial lara izin ver";
$GLOBALS['strAllowPopups']			= "Popuplara izin ver";

$GLOBALS['strUseAcl']				= "Teslimat sınırlamalarını kullan";
$GLOBALS['strGeotrackingType']			= "Coğrafi Tıklama veritabanının tipi";
$GLOBALS['strGeotrackingLocation'] 		= "Coğrafi Tıklama veritabanının yeri";

$GLOBALS['strKeywordRetrieval']			= "Anahtar kelime düzeltmeleri";
$GLOBALS['strBannerRetrieval']			= "Banner düzeltme metodu";
$GLOBALS['strRetrieveRandom']			= "Rastgele banner düzeltme (öntanımlı)";
$GLOBALS['strRetrieveNormalSeq']		= "Normal sıralı banner düzeltme";
$GLOBALS['strWeightSeq']			= "Ağarlık tabanlı sıralı banner düzeltme";
$GLOBALS['strFullSeq']				= "Tam sıralı banner düzeltme";
$GLOBALS['strUseConditionalKeys']		= "Şartlı anahtar kelimeleri kullan";
$GLOBALS['strUseMultipleKeys']			= "Birden fazla anahtar kullan";

$GLOBALS['strZonesSettings']			= "Alan Düzeltmeleri";
$GLOBALS['strZoneCache']			= "Alan hafızası kullan, alan kullanılırken hızı arttırır";
$GLOBALS['strZoneCacheLimit']			= "Hafıza güncellemeleri arasındaki zaman (dakika olarak)";
$GLOBALS['strZoneCacheLimitErr']		= "Hafıza güncellemeleri arasındaki zaman pozitif tam sayı olmalıdır";

$GLOBALS['strP3PSettings']			= "P3P Gizlilik Politikaları";
$GLOBALS['strUseP3P']				= "P3P Politikalarını kullan";
$GLOBALS['strP3PCompactPolicy']			= "P3P Yoğunlaştırılmış politika";
$GLOBALS['strP3PPolicyLocation']		= "P3P Politika yeri";



// Banner Settings
$GLOBALS['strBannerSettings']			= "Banner ayarları";

$GLOBALS['strAllowedBannerTypes']		= "İzin verilen banner tipleri";
$GLOBALS['strTypeSqlAllow']			= "Yerel bannerlara izin ver (SQL)";
$GLOBALS['strTypeWebAllow']			= "Yerel bannerlara izin ver (Webserver)";
$GLOBALS['strTypeUrlAllow']			= "Harici bannerlara izin ver";
$GLOBALS['strTypeHtmlAllow']			= "HTML bannerlarına izin ver";
$GLOBALS['strTypeTxtAllow']			= "Yazı reklamlarına banner ver";

$GLOBALS['strTypeWebSettings']			= "Yerel banner (Webserver) ayarları";
$GLOBALS['strTypeWebMode']			= "Depolama metodu";
$GLOBALS['strTypeWebModeLocal']			= "Yerel Klasörler";
$GLOBALS['strTypeWebModeFtp']			= "Harici FTP sunucu";
$GLOBALS['strTypeWebDir']			= "Yerel Klasörler";
$GLOBALS['strTypeWebFtp']			= "FTP modunda Web banner sunucusu";
$GLOBALS['strTypeWebUrl']			= "Umumi URL";
$GLOBALS['strTypeFTPHost']			= "FTP Sunucu";
$GLOBALS['strTypeFTPDirectory']			= "Sunucu klasörü";
$GLOBALS['strTypeFTPUsername']			= "Giriş";
$GLOBALS['strTypeFTPPassword']			= "Parola";

$GLOBALS['strDefaultBanners']			= "Öntanımlı bannerlar";
$GLOBALS['strDefaultBannerUrl']			= "Öntanımlı resim URL";
$GLOBALS['strDefaultBannerTarget']		= "Öntanımlı hedef URL";

$GLOBALS['strTypeHtmlSettings']			= "HTML banner ayarları";
$GLOBALS['strTypeHtmlAuto']			= "HTML Bannerlarını otomatik olarak tıklama izlemek için zorla";
$GLOBALS['strTypeHtmlPhp']			= "PHP ifadelerinin HTML içerisinde çalışmasına izin ver";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "İstatistik Ayarları";

$GLOBALS['strStatisticsFormat']			= "İstatistik Biçimi";
$GLOBALS['strLogBeacon']			= "Görüntülenmeyi saklamak için yol gösterici kullan";
$GLOBALS['strCompactStats']			= "Yoğunlaştırılmış istatistik kullan";
$GLOBALS['strLogAdviews']			= "Görüntülenme logu";
$GLOBALS['strBlockAdviews']			= "Birden fazla log koruması (dk.)";
$GLOBALS['strLogAdclicks']			= "Tıklanma logu";
$GLOBALS['strBlockAdclicks']			= "Birden fazla log koruması (dk.)";

$GLOBALS['strEmailWarnings']			= "E-mail uyarıları";
$GLOBALS['strAdminEmailHeaders']		= "Günlük raporlar için gönderici tanımlama mail başlığı";
$GLOBALS['strWarnLimit']			= "Uyarı Sınırı";
$GLOBALS['strWarnLimitErr']			= "Uyarı limiti pozitif tamsayı olmalıdır";
$GLOBALS['strWarnAdmin']			= "Uyarı Yöneticisi";
$GLOBALS['strWarnClient']			= "Reklamcıya uyarı";
$GLOBALS['strQmailPatch']			= "qmail patchini kullanın";

$GLOBALS['strRemoteHosts']			= "Uzak sunucu";
$GLOBALS['strIgnoreHosts']			= "Sunuculara önem verme";
$GLOBALS['strReverseLookup']			= "DNS geri besleme";
$GLOBALS['strProxyLookup']			= "Proxy izleme";

$GLOBALS['strAutoCleanTables']			= "Veritabanı budama";
$GLOBALS['strAutoCleanStats']			= "Budama istatistikleri";
$GLOBALS['strAutoCleanUserlog']			= "Kullanıcı loglarını buda";
$GLOBALS['strAutoCleanStatsWeeks']		= "En fazla istatistik süresi<br>(en az 3 hafta)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "En fazla kullanıcı logları süresi<br>(en az 3 hafta)";
$GLOBALS['strAutoCleanErr']			= "En fazla süre en az 3 hafta olmalıdır";
$GLOBALS['strAutoCleanVacuum']			= "Her gece tabloları VACUUM ANALYZE yap"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Yönetici Ayarları";

$GLOBALS['strLoginCredentials']			= "Giriş güvenliği";
$GLOBALS['strAdminUsername']			= "Yönetici ismi";
$GLOBALS['strOldPassword']			= "Eski Parola";
$GLOBALS['strNewPassword']			= "Yeni Parola";
$GLOBALS['strInvalidUsername']			= "Geçersiz Kullanıcı Adı";
$GLOBALS['strInvalidPassword']			= "Geçersiz Parola";

$GLOBALS['strBasicInformation']			= "Temel Bilgiler";
$GLOBALS['strAdminFullName']			= "Yönetici Tam ismi";
$GLOBALS['strAdminEmail']			= "Yönetici e-mail adresi";
$GLOBALS['strCompanyName']			= "Firma İsmi";

$GLOBALS['strAdminCheckUpdates']		= "Güncellemeleri kontrol et";
$GLOBALS['strAdminCheckEveryLogin']		= "Her girişte";
$GLOBALS['strAdminCheckDaily']			= "Günlük";
$GLOBALS['strAdminCheckWeekly']			= "Haftalık";
$GLOBALS['strAdminCheckMonthly']		= "Aylık";
$GLOBALS['strAdminCheckNever']			= "Asla";

$GLOBALS['strAdminNovice']			= "Yöneticinin silme hareketi güvenlik açısından onaya tabi olsun";
$GLOBALS['strUserlogEmail']			= "Tüm giden e-mailleri logla";
$GLOBALS['strUserlogPriority']			= "Öncelik hesalarını saatlik logla";
$GLOBALS['strUserlogAutoClean']			= "Veritabanından otomatik silmeleri logla";


// User interface settings
$GLOBALS['strGuiSettings']			= "Kullanıcı arabirimi ayarları";

$GLOBALS['strGeneralSettings']			= "Genel Ayarlar";
$GLOBALS['strAppName']				= "Uygulama Adı";
$GLOBALS['strMyHeader']				= "Başlık";
$GLOBALS['strMyFooter']				= "Altbilgi";
$GLOBALS['strGzipContentCompression']		= "Sıkıştırma için GZIP içeriğini kullan";

$GLOBALS['strClientInterface']			= "Reklamcı arayüzü ayarları";
$GLOBALS['strClientWelcomeEnabled']		= "Reklamcıya hoşgeldiniz mesajı";
$GLOBALS['strClientWelcomeText']		= "Hoşgeldiniz mesajı<br>(HTML taglarına izin veriliyor)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Öntanımlı arabirim";

$GLOBALS['strInventory']			= "Envanter";
$GLOBALS['strShowCampaignInfo']			= "<i>Kampanya önizleme</i> sayfasında ekstra kampanya bigilerini göster";
$GLOBALS['strShowBannerInfo']			= "<i>Banner önizleme</i> sayfasında ekstra banner bilgilerini göster";
$GLOBALS['strShowCampaignPreview']		= "<i>Banner önizleme</i> sayfasında tüm bannerları göster";
$GLOBALS['strShowBannerHTML']			= "HTML banner önizlemede düz HTML kodlu bannerlar haricindeki asıl bannerları göster";
$GLOBALS['strShowBannerPreview']		= "Sayfanın en üstünde uyan banner önizlemeyi göster";
$GLOBALS['strHideInactive']			= "Tüm önizleme sayfalarında pasif bileşenleri gizle";
$GLOBALS['strGUIShowMatchingBanners']		= "<i>İlişkili Bannerlar</i> sayfalarında uyan bannerları göster";
$GLOBALS['strGUIShowParentCampaigns']		= "<i>ilişkili Bannerlar</i> sayfasında ebeveyn bannerları göster";
$GLOBALS['strGUILinkCompactLimit']		= "<i>İlişkili Bannerlar</i> sayfasında ilişkilendirilmemiş kampanyalar veya bannerları ....dan fazla ise gizle";

$GLOBALS['strStatisticsDefaults'] 		= "İstatistikler";
$GLOBALS['strBeginOfWeek']			= "Haftanın Başlangıcı";
$GLOBALS['strPercentageDecimals']		= "Yüzdelik Basamağı";

$GLOBALS['strWeightDefaults']			= "öntanımlı ağırlık";
$GLOBALS['strDefaultBannerWeight']		= "öntanımlı banner ağırlığı";
$GLOBALS['strDefaultCampaignWeight']		= "öntanımlı kampanya ağırlığı";
$GLOBALS['strDefaultBannerWErr']		= "öntanımlı banner ağırlığı pozitif tamsayı olmalıdır";
$GLOBALS['strDefaultCampaignWErr']		= "öntanımlı kampanya ağırlığı pozitif tamsayı olmalıdır";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "Tablo Çerçeve rengi";
$GLOBALS['strTableBackColor']			= "Tablo Zemin Rengi";
$GLOBALS['strTableBackColorAlt']		= "Tablo Zemin Rengi (Alternatif)";
$GLOBALS['strMainBackColor']			= "Ana Zemin Rengi";
$GLOBALS['strOverrideGD']			= "Override GD Imageformat";
$GLOBALS['strTimeZone']				= "Zaman Alanı";

?>