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
$GLOBALS['strChooseInstallLanguage']		= "Kurulum s�recinde kullanaca�n�z dili se�iniz";
$GLOBALS['strLanguageSelection']		= "Dil Se�imi";
$GLOBALS['strDatabaseSettings']			= "Veritaban� Ayarlar�";
$GLOBALS['strAdminSettings']			= "Y�netici Ayarlar�";
$GLOBALS['strAdvancedSettings']			= "Geli�mi� Ayarlar";
$GLOBALS['strOtherSettings']			= "Di�er Ayarlar";

$GLOBALS['strWarning']				= "Uyar�";
$GLOBALS['strFatalError']			= "Tehlikeli hata olu�tu";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname." program� bu sistemde zaten kurulu. Ayarlar� d�zenlemek istiyorsan�z <a href='settings-index.php'>ayarlar b�l�m�ne</a> gidiniz";
$GLOBALS['strCouldNotConnectToDB']		= "Veritaban�na ba�lan�lamad�, l�tfen belirtmi� oldu�unuz ayarlar� kontrol ediniz";
$GLOBALS['strCreateTableTestFailed']		= "Belirtmi� oldu�unuz kullan�c� veritaban� yap�s�na ekleme yapma iznine sahip de�il, veritaban� y�neticinizle irtibata ge�iniz.";
$GLOBALS['strUpdateTableTestFailed']		= "Belirtmi� oldu�unuz kullan�c� veritaban� yap�s�n� de�i�tirme iznine sahip de�il, veritaban� y�neticinizle irtibata ge�iniz.";
$GLOBALS['strTablePrefixInvalid']		= "Tablo �nadlar� ge�ersiz karakter i�eriyor";
$GLOBALS['strTableInUse']			= "Belirtmi� oldu�unuz �nadlar ".$phpAds_productname." program� taraf�ndan kullan�l�yor, l�tfen farkl� �nad tan�mlay�n, veya klavuzu okuyunuz.";
$GLOBALS['strMayNotFunction']			= "Devam etmeden �nce a�a��daki problemleri d�zeltiniz:";
$GLOBALS['strIgnoreWarnings']			= "Hatalar� yoksay";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." program� PHP 4.0 ve �zeri s�r�mleri daha iyi �al��mas� i�in destekler. �u anda PHPnin {php_version} s�r�m�n� kullan�yorsunuz.";
$GLOBALS['strWarningRegisterGlobals']		= "PHP ayarlar�ndaki register_globals de�i�keni <b>on</b> olmal�d�r.";
$GLOBALS['strWarningMagicQuotesGPC']		= "PHP ayarlar�ndaki magic_quotes_gpc de�i�keni <b>on</b> olmal�d�r.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "PHP ayarlar�ndaki magic_quotes_runtime de�i�keni <b>off</b> olmal�d�r.";
$GLOBALS['strWarningFileUploads']		= "PHP ayarlar�ndaki file_uploads de�i�keni <b>on</b> olmal�d�r.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." program� <b>config.inc.php</b> dosyas�n�n g�ncellenemedi�ini tespit etti.<br> Dosyan�n izinlerini de�i�tirmeden kurulum i�lemini ger�ekle�tiremezsiniz. <br>Bunun nas�l yap�laca��n� bilmiyorsan�z l�tfen klavuzu okuyunuz.";
$GLOBALS['strCantUpdateDB']  			= "�u anda veritaban�n� g�ncelleme izni yok. E�er devam etmek istiyorsan�z, t�m bannerlar, istatistikler ve reklamlarsilinecek.";
$GLOBALS['strTableNames']			= "Tablo isimleri";
$GLOBALS['strTablesPrefix']			= "Tablo isim �nadlar�";
$GLOBALS['strTablesType']			= "Tablo tipleri";

$GLOBALS['strInstallWelcome']			= "Ho�geldiniz ".$phpAds_productname;
$GLOBALS['strInstallMessage']			= $phpAds_productname." program� kullnmaya ba�lamadan �nce ayarlanmas� ve <br> veritaban�n�n olu�turulmas� gerekiyor. Devam etmek i�in <b>�lerleye</b> t�klay�nyz.";
$GLOBALS['strInstallSuccess']			= "<b>".$phpAds_productname." kurulumu tamamland�.</b><br><br>".$phpAds_productname." program�n�n d�zg�n �al��mas� i�in bak�m program�n�n
						   her saat �al��mas� gerekmektedir. Bu konuyla ilgili detayl� bilgiyi d�k�manlarda bulabilirsiniz.
						   <br><br>Ayarlama sayfas�na gitmek i�in <b>�leri</b>yi t�klay�n�z. <br>
						   L�tfen i�lemlerinizi bitirdikten sonra config.inc.php dosyas�n�n de�i�iklik iznini kilitleyiniz.";
$GLOBALS['strUpdateSuccess']			= "<b> ".$phpAds_productname." g�ncellemeleri ba�ar�yla y�klendi.</b><br><br>".$phpAds_productname." program�n�n d�zenli olarak �al��mas� i�in
						   her saat bak�m program�n� �al��t�r�n�z (Daha �nceki s�r�mlerde bu g�nde bir defa idi). Bu konuyla ilgili detayl� bilgiyi d�k�manlarda bulabilirsiniz.
						   <br><br>Y�netici paneline gitmek i�in <b>�leri</b>yi t�klay�n�z. L�tfen i�lemlerinizi bitirdikten sonra config.inc.php dosyas�n�n de�i�iklik iznini kilitleyiniz.";
$GLOBALS['strInstallNotSuccessful']		= "<b>".$phpAds_productname." kurulumu ger�ekle�tirilemedi.</b><br><br>Kurulum s�recinin baz� b�l�mleri �al��amad�.
						   Bu problemler ge�ici olabilir, kurulumun ilk ad�m�na d�nmek i�in <b>�leri</b>yi t�klay�n�z. A�a��daki hatalar�n ne manaya geldi�ini ��renmek ve ��zmek istiyorsan�z,
						   d�k�manlara ba�vurunuz.";
$GLOBALS['strErrorOccured']			= "A�a��daki hatalar olu�tu:";
$GLOBALS['strErrorInstallDatabase']		= "Veritaban� yap�s� olu�turulam�yor.";
$GLOBALS['strErrorInstallConfig']		= "Ayar dosyas� veya veritaban� d�zenlenemiyor.";
$GLOBALS['strErrorInstallDbConnect']		= "Veritaban�na ba�lant� sa�lanam�yor.";

$GLOBALS['strUrlPrefix']			= "URL �nad�";

$GLOBALS['strProceed']				= "�leri &gt;";
$GLOBALS['strRepeatPassword']			= "Parola Tekrar�";
$GLOBALS['strNotSamePasswords']			= "Parolalar uyu�muyor";
$GLOBALS['strInvalidUserPwd']			= "Ge�ersiz kullan�c� ad� veya parolas�";

$GLOBALS['strUpgrade']				= "G�ncelle";
$GLOBALS['strSystemUpToDate']			= "Sisteminiz g�ncellenmi�tir, yeniden g�ncelleme gerekmemektedir. <br>Ana Sayfaya d�nmek i�in <b>�leri</b>yi t�klay�n�z.";
$GLOBALS['strSystemNeedsUpgrade']		= "Veritaban� yap�s� ve ayar dosyas� d�zg�n �al��mas� i�in g�ncellenmesi i�in gerekiyor. G�ncelleme i�in <b>�leriyi</b> t�klay�n�z. <br>G�ncelleme bir ka� dakika s�rebilir l�tfen sab�rl� olun.";
$GLOBALS['strSystemUpgradeBusy']		= "Sistem g�ncelleniyor, l�tfen bekleyiniz...";
$GLOBALS['strSystemRebuildingCache']		= "Haf�za tekrar olu�turuluyor, l�tfen bekleyiniz...";
$GLOBALS['strServiceUnavalable']		= "Siste ge�ici olarak �al��m�yor. Sistem g�ncelemesi devam ediyor";

$GLOBALS['strConfigNotWritable']		= "config.inc.php dosyas� yaz�lam�yor";





/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']			= "B�l�m Se�iniz";
$GLOBALS['strDayFullNames'] 			= array("Pazar","Pazartesi","Sal�","�ar�amba","Per�embe","Cuma","Cumartesi");
$GLOBALS['strEditConfigNotPossible']   		= "Ayarlar� d�zenleyemiyorsunuz. ��nk� ayar dosyan�z g�venlik nedeniyle kilitlenmi�.<br> ".
										  "D�zenleme yapman�z i�in, config.inc.php dosyas�n�n kilidini a��n�z.";
$GLOBALS['strEditConfigPossible']		= "T�m d�zenleme i�lemlerini yapabilirsiniz ��nk� ayar dosyas� kilitli de�il, ama bu g�venlik a��kl�klar�na sebep olabilir.<br> ".
										  "Sisteminizi korumak istiyorsan�z, config.inc.php dosyas�n� kilitleyiniz.";



// Database
$GLOBALS['strDatabaseSettings']			= "Veritaban� ayarlar�";
$GLOBALS['strDatabaseServer']			= "Veritaban� server";
$GLOBALS['strDbHost']				= "Veritaban� sunucu";
$GLOBALS['strDbUser']				= "Veritaban� kullan�c� ad�";
$GLOBALS['strDbPassword']			= "Veritaban� parolas�";
$GLOBALS['strDbName']				= "Veritaban� ad�";

$GLOBALS['strDatabaseOptimalisations']		= "Veritaban� Uygunlu�u";
$GLOBALS['strPersistentConnections']		= "Israrl� ba�lant�lar� kullan";
$GLOBALS['strInsertDelayed']			= "Ertelemeli eklemeleri kullan";
$GLOBALS['strCompatibilityMode']		= "Veritaban� uyumluluk modunu kullan";
$GLOBALS['strCantConnectToDb']			= "Veritaban�na ba�lan�lam�yor";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "Invocation ve Teslimat Ayarlar�";

$GLOBALS['strAllowedInvocationTypes']		= "�zin verilen invocation tipleri";
$GLOBALS['strAllowRemoteInvocation']		= "Uzak Invocationlara izin ver";
$GLOBALS['strAllowRemoteJavascript']		= "Javascript i�in Uzak Invocation izin ver";
$GLOBALS['strAllowRemoteFrames']		= "Frameler i�in Uzak Invocation izin ver";
$GLOBALS['strAllowRemoteXMLRPC']		= "XML-RPC kullanan Uzak Invocation izin ver";
$GLOBALS['strAllowLocalmode']			= "Yerel Mod izni ver";
$GLOBALS['strAllowInterstitial']		= "Interstitial lara izin ver";
$GLOBALS['strAllowPopups']			= "Popuplara izin ver";

$GLOBALS['strUseAcl']				= "Teslimat s�n�rlamalar�n� kullan";
$GLOBALS['strGeotrackingType']			= "Co�rafi T�klama veritaban�n�n tipi";
$GLOBALS['strGeotrackingLocation'] 		= "Co�rafi T�klama veritaban�n�n yeri";

$GLOBALS['strKeywordRetrieval']			= "Anahtar kelime d�zeltmeleri";
$GLOBALS['strBannerRetrieval']			= "Banner d�zeltme metodu";
$GLOBALS['strRetrieveRandom']			= "Rastgele banner d�zeltme (�ntan�ml�)";
$GLOBALS['strRetrieveNormalSeq']		= "Normal s�ral� banner d�zeltme";
$GLOBALS['strWeightSeq']			= "A�arl�k tabanl� s�ral� banner d�zeltme";
$GLOBALS['strFullSeq']				= "Tam s�ral� banner d�zeltme";
$GLOBALS['strUseConditionalKeys']		= "�artl� anahtar kelimeleri kullan";
$GLOBALS['strUseMultipleKeys']			= "Birden fazla anahtar kullan";

$GLOBALS['strZonesSettings']			= "Alan D�zeltmeleri";
$GLOBALS['strZoneCache']			= "Alan haf�zas� kullan, alan kullan�l�rken h�z� artt�r�r";
$GLOBALS['strZoneCacheLimit']			= "Haf�za g�ncellemeleri aras�ndaki zaman (dakika olarak)";
$GLOBALS['strZoneCacheLimitErr']		= "Haf�za g�ncellemeleri aras�ndaki zaman pozitif tam say� olmal�d�r";

$GLOBALS['strP3PSettings']			= "P3P Gizlilik Politikalar�";
$GLOBALS['strUseP3P']				= "P3P Politikalar�n� kullan";
$GLOBALS['strP3PCompactPolicy']			= "P3P Yo�unla�t�r�lm�� politika";
$GLOBALS['strP3PPolicyLocation']		= "P3P Politika yeri";



// Banner Settings
$GLOBALS['strBannerSettings']			= "Banner ayarlar�";

$GLOBALS['strAllowedBannerTypes']		= "�zin verilen banner tipleri";
$GLOBALS['strTypeSqlAllow']			= "Yerel bannerlara izin ver (SQL)";
$GLOBALS['strTypeWebAllow']			= "Yerel bannerlara izin ver (Webserver)";
$GLOBALS['strTypeUrlAllow']			= "Harici bannerlara izin ver";
$GLOBALS['strTypeHtmlAllow']			= "HTML bannerlar�na izin ver";
$GLOBALS['strTypeTxtAllow']			= "Yaz� reklamlar�na banner ver";

$GLOBALS['strTypeWebSettings']			= "Yerel banner (Webserver) ayarlar�";
$GLOBALS['strTypeWebMode']			= "Depolama metodu";
$GLOBALS['strTypeWebModeLocal']			= "Yerel Klas�rler";
$GLOBALS['strTypeWebModeFtp']			= "Harici FTP sunucu";
$GLOBALS['strTypeWebDir']			= "Yerel Klas�rler";
$GLOBALS['strTypeWebFtp']			= "FTP modunda Web banner sunucusu";
$GLOBALS['strTypeWebUrl']			= "Umumi URL";
$GLOBALS['strTypeFTPHost']			= "FTP Sunucu";
$GLOBALS['strTypeFTPDirectory']			= "Sunucu klas�r�";
$GLOBALS['strTypeFTPUsername']			= "Giri�";
$GLOBALS['strTypeFTPPassword']			= "Parola";

$GLOBALS['strDefaultBanners']			= "�ntan�ml� bannerlar";
$GLOBALS['strDefaultBannerUrl']			= "�ntan�ml� resim URL";
$GLOBALS['strDefaultBannerTarget']		= "�ntan�ml� hedef URL";

$GLOBALS['strTypeHtmlSettings']			= "HTML banner ayarlar�";
$GLOBALS['strTypeHtmlAuto']			= "HTML Bannerlar�n� otomatik olarak t�klama izlemek i�in zorla";
$GLOBALS['strTypeHtmlPhp']			= "PHP ifadelerinin HTML i�erisinde �al��mas�na izin ver";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "�statistik Ayarlar�";

$GLOBALS['strStatisticsFormat']			= "�statistik Bi�imi";
$GLOBALS['strLogBeacon']			= "G�r�nt�lenmeyi saklamak i�in yol g�sterici kullan";
$GLOBALS['strCompactStats']			= "Yo�unla�t�r�lm�� istatistik kullan";
$GLOBALS['strLogAdviews']			= "G�r�nt�lenme logu";
$GLOBALS['strBlockAdviews']			= "Birden fazla log korumas� (dk.)";
$GLOBALS['strLogAdclicks']			= "T�klanma logu";
$GLOBALS['strBlockAdclicks']			= "Birden fazla log korumas� (dk.)";

$GLOBALS['strEmailWarnings']			= "E-mail uyar�lar�";
$GLOBALS['strAdminEmailHeaders']		= "G�nl�k raporlar i�in g�nderici tan�mlama mail ba�l���";
$GLOBALS['strWarnLimit']			= "Uyar� S�n�r�";
$GLOBALS['strWarnLimitErr']			= "Uyar� limiti pozitif tamsay� olmal�d�r";
$GLOBALS['strWarnAdmin']			= "Uyar� Y�neticisi";
$GLOBALS['strWarnClient']			= "Reklamc�ya uyar�";
$GLOBALS['strQmailPatch']			= "qmail patchini kullan�n";

$GLOBALS['strRemoteHosts']			= "Uzak sunucu";
$GLOBALS['strIgnoreHosts']			= "Sunuculara �nem verme";
$GLOBALS['strReverseLookup']			= "DNS geri besleme";
$GLOBALS['strProxyLookup']			= "Proxy izleme";

$GLOBALS['strAutoCleanTables']			= "Veritaban� budama";
$GLOBALS['strAutoCleanStats']			= "Budama istatistikleri";
$GLOBALS['strAutoCleanUserlog']			= "Kullan�c� loglar�n� buda";
$GLOBALS['strAutoCleanStatsWeeks']		= "En fazla istatistik s�resi<br>(en az 3 hafta)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "En fazla kullan�c� loglar� s�resi<br>(en az 3 hafta)";
$GLOBALS['strAutoCleanErr']			= "En fazla s�re en az 3 hafta olmal�d�r";
$GLOBALS['strAutoCleanVacuum']			= "Her gece tablolar� VACUUM ANALYZE yap"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Y�netici Ayarlar�";

$GLOBALS['strLoginCredentials']			= "Giri� g�venli�i";
$GLOBALS['strAdminUsername']			= "Y�netici ismi";
$GLOBALS['strOldPassword']			= "Eski Parola";
$GLOBALS['strNewPassword']			= "Yeni Parola";
$GLOBALS['strInvalidUsername']			= "Ge�ersiz Kullan�c� Ad�";
$GLOBALS['strInvalidPassword']			= "Ge�ersiz Parola";

$GLOBALS['strBasicInformation']			= "Temel Bilgiler";
$GLOBALS['strAdminFullName']			= "Y�netici Tam ismi";
$GLOBALS['strAdminEmail']			= "Y�netici e-mail adresi";
$GLOBALS['strCompanyName']			= "Firma �smi";

$GLOBALS['strAdminCheckUpdates']		= "G�ncellemeleri kontrol et";
$GLOBALS['strAdminCheckEveryLogin']		= "Her giri�te";
$GLOBALS['strAdminCheckDaily']			= "G�nl�k";
$GLOBALS['strAdminCheckWeekly']			= "Haftal�k";
$GLOBALS['strAdminCheckMonthly']		= "Ayl�k";
$GLOBALS['strAdminCheckNever']			= "Asla";

$GLOBALS['strAdminNovice']			= "Y�neticinin silme hareketi g�venlik a��s�ndan onaya tabi olsun";
$GLOBALS['strUserlogEmail']			= "T�m giden e-mailleri logla";
$GLOBALS['strUserlogPriority']			= "�ncelik hesalar�n� saatlik logla";
$GLOBALS['strUserlogAutoClean']			= "Veritaban�ndan otomatik silmeleri logla";


// User interface settings
$GLOBALS['strGuiSettings']			= "Kullan�c� arabirimi ayarlar�";

$GLOBALS['strGeneralSettings']			= "Genel Ayarlar";
$GLOBALS['strAppName']				= "Uygulama Ad�";
$GLOBALS['strMyHeader']				= "Ba�l�k";
$GLOBALS['strMyFooter']				= "Altbilgi";
$GLOBALS['strGzipContentCompression']		= "S�k��t�rma i�in GZIP i�eri�ini kullan";

$GLOBALS['strClientInterface']			= "Reklamc� aray�z� ayarlar�";
$GLOBALS['strClientWelcomeEnabled']		= "Reklamc�ya ho�geldiniz mesaj�";
$GLOBALS['strClientWelcomeText']		= "Ho�geldiniz mesaj�<br>(HTML taglar�na izin veriliyor)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "�ntan�ml� arabirim";

$GLOBALS['strInventory']			= "Envanter";
$GLOBALS['strShowCampaignInfo']			= "<i>Kampanya �nizleme</i> sayfas�nda ekstra kampanya bigilerini g�ster";
$GLOBALS['strShowBannerInfo']			= "<i>Banner �nizleme</i> sayfas�nda ekstra banner bilgilerini g�ster";
$GLOBALS['strShowCampaignPreview']		= "<i>Banner �nizleme</i> sayfas�nda t�m bannerlar� g�ster";
$GLOBALS['strShowBannerHTML']			= "HTML banner �nizlemede d�z HTML kodlu bannerlar haricindeki as�l bannerlar� g�ster";
$GLOBALS['strShowBannerPreview']		= "Sayfan�n en �st�nde uyan banner �nizlemeyi g�ster";
$GLOBALS['strHideInactive']			= "T�m �nizleme sayfalar�nda pasif bile�enleri gizle";
$GLOBALS['strGUIShowMatchingBanners']		= "<i>�li�kili Bannerlar</i> sayfalar�nda uyan bannerlar� g�ster";
$GLOBALS['strGUIShowParentCampaigns']		= "<i>ili�kili Bannerlar</i> sayfas�nda ebeveyn bannerlar� g�ster";
$GLOBALS['strGUILinkCompactLimit']		= "<i>�li�kili Bannerlar</i> sayfas�nda ili�kilendirilmemi� kampanyalar veya bannerlar� ....dan fazla ise gizle";

$GLOBALS['strStatisticsDefaults'] 		= "�statistikler";
$GLOBALS['strBeginOfWeek']			= "Haftan�n Ba�lang�c�";
$GLOBALS['strPercentageDecimals']		= "Y�zdelik Basama��";

$GLOBALS['strWeightDefaults']			= "�ntan�ml� a��rl�k";
$GLOBALS['strDefaultBannerWeight']		= "�ntan�ml� banner a��rl���";
$GLOBALS['strDefaultCampaignWeight']		= "�ntan�ml� kampanya a��rl���";
$GLOBALS['strDefaultBannerWErr']		= "�ntan�ml� banner a��rl��� pozitif tamsay� olmal�d�r";
$GLOBALS['strDefaultCampaignWErr']		= "�ntan�ml� kampanya a��rl��� pozitif tamsay� olmal�d�r";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "Tablo �er�eve rengi";
$GLOBALS['strTableBackColor']			= "Tablo Zemin Rengi";
$GLOBALS['strTableBackColorAlt']		= "Tablo Zemin Rengi (Alternatif)";
$GLOBALS['strMainBackColor']			= "Ana Zemin Rengi";
$GLOBALS['strOverrideGD']			= "Override GD Imageformat";
$GLOBALS['strTimeZone']				= "Zaman Alan�";

?>