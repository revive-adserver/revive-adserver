<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
/* Turkish Translation by :												*/
/* 		Metin AKTAÞ (metin@yapayzeka.net)								*/
/* 		Bünyamin VICIL (bunyamin@yapayzeka.net)					        */
/*----------------------------------------------------------------------*/

// Installer translation strings
$GLOBALS['strInstall']				= "Kurulum";
$GLOBALS['strChooseInstallLanguage']		= "Kurulum sürecinde kullanacaðnýz dili seçiniz";
$GLOBALS['strLanguageSelection']		= "Dil Seçimi";
$GLOBALS['strDatabaseSettings']			= "Veritabaný Ayarlarý";
$GLOBALS['strAdminSettings']			= "Yönetici Ayarlarý";
$GLOBALS['strAdvancedSettings']			= "Geliþmiþ Ayarlar";
$GLOBALS['strOtherSettings']			= "Diðer Ayarlar";

$GLOBALS['strWarning']				= "Uyarý";
$GLOBALS['strFatalError']			= "Tehlikeli hata oluþtu";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname." programý bu sistemde zaten kurulu. Ayarlarý düzenlemek istiyorsanýz <a href='settings-index.php'>ayarlar bölümüne</a> gidiniz";
$GLOBALS['strCouldNotConnectToDB']		= "Veritabanýna baðlanýlamadý, lütfen belirtmiþ olduðunuz ayarlarý kontrol ediniz";
$GLOBALS['strCreateTableTestFailed']		= "Belirtmiþ olduðunuz kullanýcý veritabaný yapýsýna ekleme yapma iznine sahip deðil, veritabaný yöneticinizle irtibata geçiniz.";
$GLOBALS['strUpdateTableTestFailed']		= "Belirtmiþ olduðunuz kullanýcý veritabaný yapýsýný deðiþtirme iznine sahip deðil, veritabaný yöneticinizle irtibata geçiniz.";
$GLOBALS['strTablePrefixInvalid']		= "Tablo önadlarý geçersiz karakter içeriyor";
$GLOBALS['strTableInUse']			= "Belirtmiþ olduðunuz önadlar ".$phpAds_productname." programý tarafýndan kullanýlýyor, lütfen farklý önad tanýmlayýn, veya klavuzu okuyunuz.";
$GLOBALS['strMayNotFunction']			= "Devam etmeden önce aþaðýdaki problemleri düzeltiniz:";
$GLOBALS['strIgnoreWarnings']			= "Hatalarý yoksay";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." programý PHP 4.0 ve üzeri sürümleri daha iyi çalýþmasý için destekler. þu anda PHPnin {php_version} sürümünü kullanýyorsunuz.";
$GLOBALS['strWarningRegisterGlobals']		= "PHP ayarlarýndaki register_globals deðiþkeni <b>on</b> olmalýdýr.";
$GLOBALS['strWarningMagicQuotesGPC']		= "PHP ayarlarýndaki magic_quotes_gpc deðiþkeni <b>on</b> olmalýdýr.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "PHP ayarlarýndaki magic_quotes_runtime deðiþkeni <b>off</b> olmalýdýr.";
$GLOBALS['strWarningFileUploads']		= "PHP ayarlarýndaki file_uploads deðiþkeni <b>on</b> olmalýdýr.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." programý <b>config.inc.php</b> dosyasýnýn güncellenemediðini tespit etti.<br> Dosyanýn izinlerini deðiþtirmeden kurulum iþlemini gerçekleþtiremezsiniz. <br>Bunun nasýl yapýlacaðýný bilmiyorsanýz lütfen klavuzu okuyunuz.";
$GLOBALS['strCantUpdateDB']  			= "Þu anda veritabanýný güncelleme izni yok. Eðer devam etmek istiyorsanýz, tüm bannerlar, istatistikler ve reklamlarsilinecek.";
$GLOBALS['strTableNames']			= "Tablo isimleri";
$GLOBALS['strTablesPrefix']			= "Tablo isim önadlarý";
$GLOBALS['strTablesType']			= "Tablo tipleri";

$GLOBALS['strInstallWelcome']			= "Hoþgeldiniz ".$phpAds_productname;
$GLOBALS['strInstallMessage']			= $phpAds_productname." programý kullnmaya baþlamadan önce ayarlanmasý ve <br> veritabanýnýn oluþturulmasý gerekiyor. Devam etmek için <b>Ýlerleye</b> týklayýnyz.";
$GLOBALS['strInstallSuccess']			= "<b>".$phpAds_productname." kurulumu tamamlandý.</b><br><br>".$phpAds_productname." programýnýn düzgün çalýþmasý için bakým programýnýn
						   her saat çalýþmasý gerekmektedir. Bu konuyla ilgili detaylý bilgiyi dökümanlarda bulabilirsiniz.
						   <br><br>Ayarlama sayfasýna gitmek için <b>Ýleri</b>yi týklayýnýz. <br>
						   Lütfen iþlemlerinizi bitirdikten sonra config.inc.php dosyasýnýn deðiþiklik iznini kilitleyiniz.";
$GLOBALS['strUpdateSuccess']			= "<b> ".$phpAds_productname." güncellemeleri baþarýyla yüklendi.</b><br><br>".$phpAds_productname." programýnýn düzenli olarak çalýþmasý için 
						   her saat bakým programýný çalýþtýrýnýz (Daha önceki sürümlerde bu günde bir defa idi). Bu konuyla ilgili detaylý bilgiyi dökümanlarda bulabilirsiniz.
						   <br><br>Yönetici paneline gitmek için <b>Ýleri</b>yi týklayýnýz. Lütfen iþlemlerinizi bitirdikten sonra config.inc.php dosyasýnýn deðiþiklik iznini kilitleyiniz.";
$GLOBALS['strInstallNotSuccessful']		= "<b>".$phpAds_productname." kurulumu gerçekleþtirilemedi.</b><br><br>Kurulum sürecinin bazý bölümleri çalýþamadý.
						   Bu problemler geçici olabilir, kurulumun ilk adýmýna dönmek için <b>Ýleri</b>yi týklayýnýz. Aþaðýdaki hatalarýn ne manaya geldiðini öðrenmek ve çözmek istiyorsanýz, 
						   dökümanlara baþvurunuz.";
$GLOBALS['strErrorOccured']			= "Aþaðýdaki hatalar oluþtu:";
$GLOBALS['strErrorInstallDatabase']		= "Veritabaný yapýsý oluþturulamýyor.";
$GLOBALS['strErrorInstallConfig']		= "Ayar dosyasý veya veritabaný düzenlenemiyor.";
$GLOBALS['strErrorInstallDbConnect']		= "Veritabanýna baðlantý saðlanamýyor.";

$GLOBALS['strUrlPrefix']			= "URL Önadý";

$GLOBALS['strProceed']				= "Ýleri &gt;";
$GLOBALS['strRepeatPassword']			= "Parola Tekrarý";
$GLOBALS['strNotSamePasswords']			= "Parolalar uyuþmuyor";
$GLOBALS['strInvalidUserPwd']			= "Geçersiz kullanýcý adý veya parolasý";

$GLOBALS['strUpgrade']				= "Güncelle";
$GLOBALS['strSystemUpToDate']			= "Sisteminiz güncellenmiþtir, yeniden güncelleme gerekmemektedir. <br>Ana Sayfaya dönmek için <b>Ýleri</b>yi týklayýnýz.";
$GLOBALS['strSystemNeedsUpgrade']		= "Veritabaný yapýsý ve ayar dosyasý düzgün çalýþmasý için güncellenmesi için gerekiyor. Güncelleme için <b>Ýleriyi</b> týklayýnýz. <br>Güncelleme bir kaç dakika sürebilir lütfen sabýrlý olun.";
$GLOBALS['strSystemUpgradeBusy']		= "Sistem güncelleniyor, lütfen bekleyiniz...";
$GLOBALS['strSystemRebuildingCache']		= "Hafýza tekrar oluþturuluyor, lütfen bekleyiniz...";
$GLOBALS['strServiceUnavalable']		= "Siste geçici olarak çalýþmýyor. Sistem güncelemesi devam ediyor";

$GLOBALS['strConfigNotWritable']		= "config.inc.php dosyasý yazýlamýyor";





/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']			= "Bölüm Seçiniz";
$GLOBALS['strDayFullNames'] 			= array("Pazar","Pazartesi","Salý","Çarþamba","Perþembe","Cuma","Cumartesi");
$GLOBALS['strEditConfigNotPossible']   		= "Ayarlarý düzenleyemiyorsunuz. çünkü ayar dosyanýz güvenlik nedeniyle kilitlenmiþ.<br> ".
										  "Düzenleme yapmanýz için, config.inc.php dosyasýnýn kilidini açýnýz.";
$GLOBALS['strEditConfigPossible']		= "Tüm düzenleme iþlemlerini yapabilirsiniz çünkü ayar dosyasý kilitli deðil, ama bu güvenlik açýklýklarýna sebep olabilir.<br> ".
										  "Sisteminizi korumak istiyorsanýz, config.inc.php dosyasýný kilitleyiniz.";



// Database
$GLOBALS['strDatabaseSettings']			= "Veritabaný ayarlarý";
$GLOBALS['strDatabaseServer']			= "Veritabaný server";
$GLOBALS['strDbHost']				= "Veritabaný sunucu";
$GLOBALS['strDbUser']				= "Veritabaný kullanýcý adý";
$GLOBALS['strDbPassword']			= "Veritabaný parolasý";
$GLOBALS['strDbName']				= "Veritabaný adý";

$GLOBALS['strDatabaseOptimalisations']		= "Veritabaný Uygunluðu";
$GLOBALS['strPersistentConnections']		= "Israrlý baðlantýlarý kullan";
$GLOBALS['strInsertDelayed']			= "Ertelemeli eklemeleri kullan";
$GLOBALS['strCompatibilityMode']		= "Veritabaný uyumluluk modunu kullan";
$GLOBALS['strCantConnectToDb']			= "Veritabanýna baðlanýlamýyor";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "Invocation ve Teslimat Ayarlarý";

$GLOBALS['strAllowedInvocationTypes']		= "Ýzin verilen invocation tipleri";
$GLOBALS['strAllowRemoteInvocation']		= "Uzak Invocationlara izin ver";
$GLOBALS['strAllowRemoteJavascript']		= "Javascript için Uzak Invocation izin ver";
$GLOBALS['strAllowRemoteFrames']		= "Frameler için Uzak Invocation izin ver";
$GLOBALS['strAllowRemoteXMLRPC']		= "XML-RPC kullanan Uzak Invocation izin ver";
$GLOBALS['strAllowLocalmode']			= "Yerel Mod izni ver";
$GLOBALS['strAllowInterstitial']		= "Interstitial lara izin ver";
$GLOBALS['strAllowPopups']			= "Popuplara izin ver";

$GLOBALS['strUseAcl']				= "Teslimat sýnýrlamalarýný kullan";
$GLOBALS['strGeotrackingType']			= "Coðrafi Týklama veritabanýnýn tipi";
$GLOBALS['strGeotrackingLocation'] 		= "Coðrafi Týklama veritabanýnýn yeri";

$GLOBALS['strKeywordRetrieval']			= "Anahtar kelime düzeltmeleri";
$GLOBALS['strBannerRetrieval']			= "Banner düzeltme metodu";
$GLOBALS['strRetrieveRandom']			= "Rastgele banner düzeltme (öntanýmlý)";
$GLOBALS['strRetrieveNormalSeq']		= "Normal sýralý banner düzeltme";
$GLOBALS['strWeightSeq']			= "Aðarlýk tabanlý sýralý banner düzeltme";
$GLOBALS['strFullSeq']				= "Tam sýralý banner düzeltme";
$GLOBALS['strUseConditionalKeys']		= "Þartlý anahtar kelimeleri kullan";
$GLOBALS['strUseMultipleKeys']			= "Birden fazla anahtar kullan";

$GLOBALS['strZonesSettings']			= "Alan Düzeltmeleri";
$GLOBALS['strZoneCache']			= "Alan hafýzasý kullan, alan kullanýlýrken hýzý arttýrýr";
$GLOBALS['strZoneCacheLimit']			= "Hafýza güncellemeleri arasýndaki zaman (dakika olarak)";
$GLOBALS['strZoneCacheLimitErr']		= "Hafýza güncellemeleri arasýndaki zaman pozitif tam sayý olmalýdýr";

$GLOBALS['strP3PSettings']			= "P3P Gizlilik Politikalarý";
$GLOBALS['strUseP3P']				= "P3P Politikalarýný kullan";
$GLOBALS['strP3PCompactPolicy']			= "P3P Yoðunlaþtýrýlmýþ politika";
$GLOBALS['strP3PPolicyLocation']		= "P3P Politika yeri";



// Banner Settings
$GLOBALS['strBannerSettings']			= "Banner ayarlarý";

$GLOBALS['strAllowedBannerTypes']		= "Ýzin verilen banner tipleri";
$GLOBALS['strTypeSqlAllow']			= "Yerel bannerlara izin ver (SQL)";
$GLOBALS['strTypeWebAllow']			= "Yerel bannerlara izin ver (Webserver)";
$GLOBALS['strTypeUrlAllow']			= "Harici bannerlara izin ver";
$GLOBALS['strTypeHtmlAllow']			= "HTML bannerlarýna izin ver";
$GLOBALS['strTypeTxtAllow']			= "Yazý reklamlarýna banner ver";

$GLOBALS['strTypeWebSettings']			= "Yerel banner (Webserver) ayarlarý";
$GLOBALS['strTypeWebMode']			= "Depolama metodu";
$GLOBALS['strTypeWebModeLocal']			= "Yerel Klasörler";
$GLOBALS['strTypeWebModeFtp']			= "Harici FTP sunucu";
$GLOBALS['strTypeWebDir']			= "Yerel Klasörler";
$GLOBALS['strTypeWebFtp']			= "FTP modunda Web banner sunucusu";
$GLOBALS['strTypeWebUrl']			= "Umumi URL";
$GLOBALS['strTypeFTPHost']			= "FTP Sunucu";
$GLOBALS['strTypeFTPDirectory']			= "Sunucu klasörü";
$GLOBALS['strTypeFTPUsername']			= "Giriþ";
$GLOBALS['strTypeFTPPassword']			= "Parola";

$GLOBALS['strDefaultBanners']			= "Öntanýmlý bannerlar";
$GLOBALS['strDefaultBannerUrl']			= "Öntanýmlý resim URL";
$GLOBALS['strDefaultBannerTarget']		= "Öntanýmlý hedef URL";

$GLOBALS['strTypeHtmlSettings']			= "HTML banner ayarlarý";
$GLOBALS['strTypeHtmlAuto']			= "HTML Bannerlarýný otomatik olarak týklama izlemek için zorla";
$GLOBALS['strTypeHtmlPhp']			= "PHP ifadelerinin HTML içerisinde çalýþmasýna izin ver";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Ýstatistik Ayarlarý";

$GLOBALS['strStatisticsFormat']			= "Ýstatistik Biçimi";
$GLOBALS['strLogBeacon']			= "Görüntülenmeyi saklamak için yol gösterici kullan";
$GLOBALS['strCompactStats']			= "Yoðunlaþtýrýlmýþ istatistik kullan";
$GLOBALS['strLogAdviews']			= "Görüntülenme logu";
$GLOBALS['strBlockAdviews']			= "Birden fazla log korumasý (dk.)";
$GLOBALS['strLogAdclicks']			= "Týklanma logu";
$GLOBALS['strBlockAdclicks']			= "Birden fazla log korumasý (dk.)";

$GLOBALS['strEmailWarnings']			= "E-mail uyarýlarý";
$GLOBALS['strAdminEmailHeaders']		= "Günlük raporlar için gönderici tanýmlama mail baþlýðý";
$GLOBALS['strWarnLimit']			= "Uyarý Sýnýrý";
$GLOBALS['strWarnLimitErr']			= "Uyarý limiti pozitif tamsayý olmalýdýr";
$GLOBALS['strWarnAdmin']			= "Uyarý Yöneticisi";
$GLOBALS['strWarnClient']			= "Reklamcýya uyarý";
$GLOBALS['strQmailPatch']			= "qmail patchini kullanýn";

$GLOBALS['strRemoteHosts']			= "Uzak sunucu";
$GLOBALS['strIgnoreHosts']			= "Sunuculara önem verme";
$GLOBALS['strReverseLookup']			= "DNS geri besleme";
$GLOBALS['strProxyLookup']			= "Proxy izleme";

$GLOBALS['strAutoCleanTables']			= "Veritabaný budama";
$GLOBALS['strAutoCleanStats']			= "Budama istatistikleri";
$GLOBALS['strAutoCleanUserlog']			= "Kullanýcý loglarýný buda";
$GLOBALS['strAutoCleanStatsWeeks']		= "En fazla istatistik süresi<br>(en az 3 hafta)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "En fazla kullanýcý loglarý süresi<br>(en az 3 hafta)";
$GLOBALS['strAutoCleanErr']			= "En fazla süre en az 3 hafta olmalýdýr";
$GLOBALS['strAutoCleanVacuum']			= "Her gece tablolarý VACUUM ANALYZE yap"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Yönetici Ayarlarý";

$GLOBALS['strLoginCredentials']			= "Giriþ güvenliði";
$GLOBALS['strAdminUsername']			= "Yönetici ismi";
$GLOBALS['strOldPassword']			= "Eski Parola";
$GLOBALS['strNewPassword']			= "Yeni Parola";
$GLOBALS['strInvalidUsername']			= "Geçersiz Kullanýcý Adý";
$GLOBALS['strInvalidPassword']			= "Geçersiz Parola";

$GLOBALS['strBasicInformation']			= "Temel Bilgiler";
$GLOBALS['strAdminFullName']			= "Yönetici Tam ismi";
$GLOBALS['strAdminEmail']			= "Yönetici e-mail adresi";
$GLOBALS['strCompanyName']			= "Firma Ýsmi";

$GLOBALS['strAdminCheckUpdates']		= "Güncellemeleri kontrol et";
$GLOBALS['strAdminCheckEveryLogin']		= "Her giriþte";
$GLOBALS['strAdminCheckDaily']			= "Günlük";
$GLOBALS['strAdminCheckWeekly']			= "Haftalýk";
$GLOBALS['strAdminCheckMonthly']		= "Aylýk";
$GLOBALS['strAdminCheckNever']			= "Asla";

$GLOBALS['strAdminNovice']			= "Yöneticinin silme hareketi güvenlik açýsýndan onaya tabi olsun";
$GLOBALS['strUserlogEmail']			= "Tüm giden e-mailleri logla";
$GLOBALS['strUserlogPriority']			= "Öncelik hesalarýný saatlik logla";
$GLOBALS['strUserlogAutoClean']			= "Veritabanýndan otomatik silmeleri logla";


// User interface settings
$GLOBALS['strGuiSettings']			= "Kullanýcý arabirimi ayarlarý";

$GLOBALS['strGeneralSettings']			= "Genel Ayarlar";
$GLOBALS['strAppName']				= "Uygulama Adý";
$GLOBALS['strMyHeader']				= "Baþlýk";
$GLOBALS['strMyFooter']				= "Altbilgi";
$GLOBALS['strGzipContentCompression']		= "Sýkýþtýrma için GZIP içeriðini kullan";

$GLOBALS['strClientInterface']			= "Reklamcý arayüzü ayarlarý";
$GLOBALS['strClientWelcomeEnabled']		= "Reklamcýya hoþgeldiniz mesajý";
$GLOBALS['strClientWelcomeText']		= "Hoþgeldiniz mesajý<br>(HTML taglarýna izin veriliyor)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Öntanýmlý arabirim";

$GLOBALS['strInventory']			= "Envanter";
$GLOBALS['strShowCampaignInfo']			= "<i>Kampanya önizleme</i> sayfasýnda ekstra kampanya bigilerini göster";
$GLOBALS['strShowBannerInfo']			= "<i>Banner önizleme</i> sayfasýnda ekstra banner bilgilerini göster";
$GLOBALS['strShowCampaignPreview']		= "<i>Banner önizleme</i> sayfasýnda tüm bannerlarý göster";
$GLOBALS['strShowBannerHTML']			= "HTML banner önizlemede düz HTML kodlu bannerlar haricindeki asýl bannerlarý göster";
$GLOBALS['strShowBannerPreview']		= "Sayfanýn en üstünde uyan banner önizlemeyi göster";
$GLOBALS['strHideInactive']			= "Tüm önizleme sayfalarýnda pasif bileþenleri gizle";
$GLOBALS['strGUIShowMatchingBanners']		= "<i>Ýliþkili Bannerlar</i> sayfalarýnda uyan bannerlarý göster";
$GLOBALS['strGUIShowParentCampaigns']		= "<i>iliþkili Bannerlar</i> sayfasýnda ebeveyn bannerlarý göster";
$GLOBALS['strGUILinkCompactLimit']		= "<i>Ýliþkili Bannerlar</i> sayfasýnda iliþkilendirilmemiþ kampanyalar veya bannerlarý ....dan fazla ise gizle";

$GLOBALS['strStatisticsDefaults'] 		= "Ýstatistikler";
$GLOBALS['strBeginOfWeek']			= "Haftanýn Baþlangýcý";
$GLOBALS['strPercentageDecimals']		= "Yüzdelik Basamaðý";

$GLOBALS['strWeightDefaults']			= "öntanýmlý aðýrlýk";
$GLOBALS['strDefaultBannerWeight']		= "öntanýmlý banner aðýrlýðý";
$GLOBALS['strDefaultCampaignWeight']		= "öntanýmlý kampanya aðýrlýðý";
$GLOBALS['strDefaultBannerWErr']		= "öntanýmlý banner aðýrlýðý pozitif tamsayý olmalýdýr";
$GLOBALS['strDefaultCampaignWErr']		= "öntanýmlý kampanya aðýrlýðý pozitif tamsayý olmalýdýr";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "Tablo Çerçeve rengi";
$GLOBALS['strTableBackColor']			= "Tablo Zemin Rengi";
$GLOBALS['strTableBackColorAlt']		= "Tablo Zemin Rengi (Alternatif)";
$GLOBALS['strMainBackColor']			= "Ana Zemin Rengi";
$GLOBALS['strOverrideGD']			= "Override GD Imageformat";
$GLOBALS['strTimeZone']				= "Zaman Alaný";

?>