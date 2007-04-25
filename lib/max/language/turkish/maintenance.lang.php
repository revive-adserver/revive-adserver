<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
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

// Main strings
$GLOBALS['strChooseSection']			= "Bölüm Seçiniz";


// Priority
$GLOBALS['strRecalculatePriority']		= "Öncelikleri hesapla";
$GLOBALS['strHighPriorityCampaigns']		= "Yüksek öncelikli kampanyalar";
$GLOBALS['strAdViewsAssigned']			= "Belirlenen görünme";
$GLOBALS['strLowPriorityCampaigns']		= "Düþük öncelikli kampanyalar";
$GLOBALS['strPredictedAdViews']			= "Önceden belirtilmiþ Görünme";
$GLOBALS['strPriorityDaysRunning']		= "There are currently {days} days worth of statistics available from where ".$phpAds_productname." can base its daily prediction on. ";
$GLOBALS['strPriorityBasedLastWeek']		= "Bu tahmin bu hafta ve geçen haftanýn istatistiklerinden hazýrlanmýþtýr. ";
$GLOBALS['strPriorityBasedLastDays']		= "Bu tahmin son iki günün istatistiklerinden hazýrlanmýþtýr. ";
$GLOBALS['strPriorityBasedYesterday']		= "Bu tahmin dünün istatistiklerinden hazýrlanmýþtýr. ";
$GLOBALS['strPriorityNoData']			= "Gerçeðe yakýn tahmin oluþturulmasý için yeterli istatistik bulunmamktadýr. Öncelikler gerçek zamanlý istatistikler için kullanýlabilir. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Yüksek öncelikli kampanyalarý memnun edebilmek için yeterli gösterim sayýsý olmalýdýr. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Bugün toplanan görüntilenmeler yüksek öncelikli kampanyanýn bilgisi için yeterli deðil. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Banner hafýzasýný tekrar oluþtur";
$GLOBALS['strBannerCacheExplaination']		= "
	Banner hafýzasý bannerý göstermek için HTML kodlarýný içerir. Banner hafýzasý kullanmanýz bannerýn her gösteriminde yeniden HTML 
	kodu üretmeyeceðinden dolayý görüntülenmesini hýzlandýrýr. Çünkü banner hafýzasý ".$phpAds_productname." programýnýn direk adresini(URL) 
	ve bannerý bünyesinde bulundurur.
";


// Zone cache
$GLOBALS['strZoneCache']			= "Alan Hafýzasý";
$GLOBALS['strAge']				= "Yaþ";
$GLOBALS['strRebuildZoneCache']			= "Alan Hafýzasýný tekrar oluþtur";
$GLOBALS['strZoneCacheExplaination']		= "
	Alan hafýzasý o alana ait bannerlarýn hýzlý açýlmasýný saðlar. Alan hafýzasý üzerinde bulunan tüm bannerlarýn kodlarýný içermektedir.
	Hafýza alan güncelleþtirildiðinde veya banner eklendiðinde deðiþmektedir, bu yüzden hafýza geçerliliðini kaybeder.
	Bu yüzden hafýza her {seconds} dakikada tekrar oluþturulmaktadýr, ama bu hafýza elle de yapýlabilmektedir.
";


// Storage
$GLOBALS['strStorage']				= "Depolama";
$GLOBALS['strMoveToDirectory']			= "Veritabanýnda depolanan resimleri bir dizine taþý";
$GLOBALS['strStorageExplaination']		= "
	Yerel bannerlarýn resimleri veritabanýnda veya bir klasör altýnda tutulabilir. Eðer resimleri
	bir klasörde tutarsanýz bu veritabanýnýn yükünü azaltýr ama sistemi yavaþlatýr.
";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	<i>Yoðunlaþtýrýlmýþ istatistikleri</i> aktif ettiniz, fakat eski istatistiklerinizin yapýsý gereksiz bilgileri de içeriyor. 
	Eski istatistiklerinizi düzenlemek ister misiniz?
";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "Güncellemeler kontrol ediliyor. Lütfen bekleyiniz...";
$GLOBALS['strAvailableUpdates']			= "Mevcut ürün güncellemeleri";
$GLOBALS['strDownloadZip']			= "Ýndir (.zip)";
$GLOBALS['strDownloadGZip']			= "Ýndir (.tar.gz)";

$GLOBALS['strUpdateAlert']			= $phpAds_productname." programýnýn yeni sürümü bulunmaktadýr.                 \\n\\nBu güncelleme ile ilgili daha\\nfazla bilgi ister misiniz?";
$GLOBALS['strUpdateAlertSecurity']		= $phpAds_productname." programýnýn yeni sürümü bulunmaktadýr.                 \\n\\nBu güncellemeyi yapmanýz \\ntavsiye ediliyor, çünklü bu sürüm \\ngüvenlik problemlerinin onarýlmýþ halini içeriyor.";

$GLOBALS['strUpdateServerDown']			= "
    Tanýmlanamayan bir nedenden dolayý mevcut olan ürün <br>
	güncellemelerine ulaþýlamýyor. Lütfen daha sonra tekrar deneyiniz.
";

$GLOBALS['strNoNewVersionAvailable']		= 
	$phpAds_productname." sürümünüz güncellenmiþ. þu anda mevcut bir güncelleme bulunmuyor.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>".$phpAds_productname." yeni sürümü bulunmaktadýr.</b><br> Bu güncellemeyi yüklemenizi tavsiye ederiz.
	Çünkü bu sürüm bazý problemleri çözebilir ve yeni özellikler ekleyebilir. Daha fazla bilgi için
	aþaðýdaki dosyada bulunan dökümanlarý okuyunuz.
";

$GLOBALS['strSecurityUpdate']			= "
	<b>Bu güncellemeyi yüklemeniz þiddetle tavsiye ediliyor. Çünkü bu sürüm bazý güvenlik açýklarýný onarýyor.
	.</b> Kullanmýþ olduðunuz ".$phpAds_productname." sürümü bazý saldýrýlara açýk olabilir. Daha fazla bilgi için
	aþaðýdaki dosyada bulunan dökümanlarý okuyunuz.
";


// Stats conversion
$GLOBALS['strConverting']			= "Dönüþtürülüyor";
$GLOBALS['strConvertingStats']			= "Ýstatistikler Dönüþtürülüyor...";
$GLOBALS['strConvertStats']			= "Ýstatistikleri dönüþtür";
$GLOBALS['strConvertAdViews']			= "Görüntülenme dönüþtür,";
$GLOBALS['strConvertAdClicks']			= "Týklanma dönüþtürlüyor...";
$GLOBALS['strConvertNothing']			= "Hiçbir þey dönüþtürülmedi...";
$GLOBALS['strConvertFinished']			= "Bitti...";

$GLOBALS['strConvertExplaination']		= "
	Þu anda istatistiklerinizi depolamak için yoðunlaþtýrýlmýþ biçimi kullanýyorsunuz. Ama <br>
	hala gereksiz içerikli istatistikleriniz bulunmakta. Bu gereksiz içerikli istatistikleriniz<br>
	yoðunlaþtýrýlmýþ istatistiklere dönüþtürülmeden bu sayfalarý göremezsiniz. <br>
	Ýstatistiklerinizi dönüstürmden veritabanýnýzý yedekleyiniz ! <br>
	Gereksiz içerikli istatistiklerinizi yoðunlaþtýrýlmýþ istatistik biçimine dönüþtürmek istermisiniz?<br>
";

$GLOBALS['strConvertingExplaination']		= "
	Kalan tüm gereksiz içerikli istatistikleriniz yoðunlaþtýrýlmýþ istatistiklere çevrildi.<br>
	Tüm kayýtlarýn dönüþtürülmesi biraz süre alacaktýr. ÝBu süre içerisinde lütfen baþka sayfalarý
	gezmeyiniz. Ýþlem sonunda size veritabaný üzerinde yapýlan deðiþikler ile ilgili rapor sunulacaktýr.
";

$GLOBALS['strConvertFinishedExplaination']  	= "
	Yoðunlaþtýrýlmýþ istatistiklere dönüþtürme iþlemi baþarýyla gerçekleþtirildi, <br>
	þu anda veriler tekrar kullanýlabilir halde. Aþaðýda veritabanýnda yapýlan tüm<br>
	deðiþiklikleri görebilirsiniz.<br>
";


?>