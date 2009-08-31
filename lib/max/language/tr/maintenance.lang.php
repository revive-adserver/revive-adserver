<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

// Main strings
$GLOBALS['strChooseSection']			= "Bölüm Seçiniz";


// Priority
$GLOBALS['strRecalculatePriority']		= "Öncelikleri hesapla";
$GLOBALS['strHighPriorityCampaigns']		= "Yüksek öncelikli kampanyalar";
$GLOBALS['strAdViewsAssigned']			= "Belirlenen görünme";
$GLOBALS['strLowPriorityCampaigns']		= "Düşük öncelikli kampanyalar";
$GLOBALS['strPredictedAdViews']			= "Önceden belirtilmiş Görünme";
$GLOBALS['strPriorityDaysRunning']		= "There are currently {days} days worth of statistics available from where ".MAX_PRODUCT_NAME." can base its daily prediction on. ";
$GLOBALS['strPriorityBasedLastWeek']		= "Bu tahmin bu hafta ve geçen haftanın istatistiklerinden hazırlanmıştır. ";
$GLOBALS['strPriorityBasedLastDays']		= "Bu tahmin son iki günün istatistiklerinden hazırlanmıştır. ";
$GLOBALS['strPriorityBasedYesterday']		= "Bu tahmin dünün istatistiklerinden hazırlanmıştır. ";
$GLOBALS['strPriorityNoData']			= "Gerçeğe yakın tahmin oluşturulması için yeterli istatistik bulunmamktadır. Öncelikler gerçek zamanlı istatistikler için kullanılabilir. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Yüksek öncelikli kampanyaları memnun edebilmek için yeterli gösterim sayısı olmalıdır. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Bugün toplanan görüntilenmeler yüksek öncelikli kampanyanın bilgisi için yeterli değil. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Banner hafızasını tekrar oluştur";
$GLOBALS['strBannerCacheExplaination']		= "\n	Banner hafızası bannerı göstermek için HTML kodlarını içerir. Banner hafızası kullanmanız bannerın her gösteriminde yeniden HTML\n	kodu üretmeyeceğinden dolayı görüntülenmesini hızlandırır. Çünkü banner hafızası ".MAX_PRODUCT_NAME." programının direk adresini(URL)\n	ve bannerı bünyesinde bulundurur.\n";


// Zone cache
$GLOBALS['strZoneCache']			= "Alan Hafızası";
$GLOBALS['strAge']				= "Yaş";
$GLOBALS['strRebuildZoneCache']			= "Alan Hafızasını tekrar oluştur";
$GLOBALS['strZoneCacheExplaination']		= "\n	Alan hafızası o alana ait bannerların hızlı açılmasını sağlar. Alan hafızası üzerinde bulunan tüm bannerların kodlarını içermektedir.\n	Hafıza alan güncelleştirildiğinde veya banner eklendiğinde değişmektedir, bu yüzden hafıza geçerliliğini kaybeder.\n	Bu yüzden hafıza her {seconds} dakikada tekrar oluşturulmaktadır, ama bu hafıza elle de yapılabilmektedir.\n";


// Storage
$GLOBALS['strStorage']				= "Depolama";
$GLOBALS['strMoveToDirectory']			= "Veritabanında depolanan resimleri bir dizine taşı";
$GLOBALS['strStorageExplaination']		= "\n";


// Storage
$GLOBALS['strStatisticsExplaination']		= "\n";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "Güncellemeler kontrol ediliyor. Lütfen bekleyiniz...";
$GLOBALS['strAvailableUpdates']			= "Mevcut ürün güncellemeleri";
$GLOBALS['strDownloadZip']			= "İndir (.zip)";
$GLOBALS['strDownloadGZip']			= "İndir (.tar.gz)";

$GLOBALS['strUpdateAlert']			= MAX_PRODUCT_NAME." programının yeni sürümü bulunmaktadır.                 \\n\\nBu güncelleme ile ilgili daha\\nfazla bilgi ister misiniz?";
$GLOBALS['strUpdateAlertSecurity']		= MAX_PRODUCT_NAME." programının yeni sürümü bulunmaktadır.                 \\n\\nBu güncellemeyi yapmanız \\ntavsiye ediliyor, çünklü bu sürüm \\ngüvenlik problemlerinin onarılmış halini içeriyor.";

$GLOBALS['strUpdateServerDown']			= "\n";

$GLOBALS['strNoNewVersionAvailable']		=
	MAX_PRODUCT_NAME." sürümünüz güncellenmiş. şu anda mevcut bir güncelleme bulunmuyor.
";

$GLOBALS['strNewVersionAvailable']		= "\n	<b>".MAX_PRODUCT_NAME." yeni sürümü bulunmaktadır.</b><br> Bu güncellemeyi yüklemenizi tavsiye ederiz.\n	Çünkü bu sürüm bazı problemleri çözebilir ve yeni özellikler ekleyebilir. Daha fazla bilgi için\n	aşağıdaki dosyada bulunan dökümanları okuyunuz.\n";

$GLOBALS['strSecurityUpdate']			= "\n	<b>Bu güncellemeyi yüklemeniz şiddetle tavsiye ediliyor. Çünkü bu sürüm bazı güvenlik açıklarını onarıyor.\n	.</b> Kullanmış olduğunuz ".MAX_PRODUCT_NAME." sürümü bazı saldırılara açık olabilir. Daha fazla bilgi için\n	aşağıdaki dosyada bulunan dökümanları okuyunuz.\n";


// Stats conversion
$GLOBALS['strConverting']			= "Dönüştürülüyor";
$GLOBALS['strConvertingStats']			= "İstatistikler Dönüştürülüyor...";
$GLOBALS['strConvertStats']			= "İstatistikleri dönüştür";
$GLOBALS['strConvertAdViews']			= "Görüntülenme dönüştür,";
$GLOBALS['strConvertAdClicks']			= "Tıklanma dönüştürlüyor...";
$GLOBALS['strConvertNothing']			= "Hiçbir şey dönüştürülmedi...";
$GLOBALS['strConvertFinished']			= "Bitti...";

$GLOBALS['strConvertExplaination']		= "\n	Şu anda istatistiklerinizi depolamak için yoğunlaştırılmış biçimi kullanıyorsunuz. Ama <br>\n	hala gereksiz içerikli istatistikleriniz bulunmakta. Bu gereksiz içerikli istatistikleriniz<br>\n	yoğunlaştırılmış istatistiklere dönüştürülmeden bu sayfaları göremezsiniz. <br>\n	İstatistiklerinizi dönüstürmden veritabanınızı yedekleyiniz ! <br>\n	Gereksiz içerikli istatistiklerinizi yoğunlaştırılmış istatistik biçimine dönüştürmek istermisiniz?<br>\n";

$GLOBALS['strConvertingExplaination']		= "\n	Kalan tüm gereksiz içerikli istatistikleriniz yoğunlaştırılmış istatistiklere çevrildi.<br>\n	Tüm kayıtların dönüştürülmesi biraz süre alacaktır. İBu süre içerisinde lütfen başka sayfaları\n	gezmeyiniz. İşlem sonunda size veritabanı üzerinde yapılan değişikler ile ilgili rapor sunulacaktır.\n";

$GLOBALS['strConvertFinishedExplaination']  	= "\n	Yoğunlaştırılmış istatistiklere dönüştürme işlemi başarıyla gerçekleştirildi, <br>\n	şu anda veriler tekrar kullanılabilir halde. Aşağıda veritabanında yapılan tüm<br>\n	değişiklikleri görebilirsiniz.<br>\n";




// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strEncodingConvert'] = "Dönüştür";
?>