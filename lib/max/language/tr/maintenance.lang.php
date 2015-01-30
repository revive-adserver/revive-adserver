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

// Main strings
$GLOBALS['strChooseSection'] = "Bölüm Seçiniz";

// Maintenance









// Priority
$GLOBALS['strRecalculatePriority'] = "Öncelikleri hesapla";
$GLOBALS['strHighPriorityCampaigns'] = "Yüksek öncelikli kampanyalar";
$GLOBALS['strAdViewsAssigned'] = "Belirlenen görünme";
$GLOBALS['strLowPriorityCampaigns'] = "Düşük öncelikli kampanyalar";
$GLOBALS['strPredictedAdViews'] = "Önceden belirtilmiş Görünme";
$GLOBALS['strPriorityBasedLastWeek'] = "Bu tahmin bu hafta ve geçen haftanın istatistiklerinden hazırlanmıştır. ";
$GLOBALS['strPriorityBasedLastDays'] = "Bu tahmin son iki günün istatistiklerinden hazırlanmıştır. ";
$GLOBALS['strPriorityBasedYesterday'] = "Bu tahmin dünün istatistiklerinden hazırlanmıştır. ";
$GLOBALS['strPriorityNoData'] = "Gerçeğe yakın tahmin oluşturulması için yeterli istatistik bulunmamktadır. Öncelikler gerçek zamanlı istatistikler için kullanılabilir. ";
$GLOBALS['strPriorityEnoughAdViews'] = "Yüksek öncelikli kampanyaları memnun edebilmek için yeterli gösterim sayısı olmalıdır. ";
$GLOBALS['strPriorityNotEnoughAdViews'] = "Bugün toplanan görüntilenmeler yüksek öncelikli kampanyanın bilgisi için yeterli değil. ";


// Banner cache
$GLOBALS['strRebuildBannerCache'] = "Banner hafızasını tekrar oluştur";
$GLOBALS['strBannerCacheExplaination'] = "	Banner hafızası bannerı göstermek için HTML kodlarını içerir. Banner hafızası kullanmanız bannerın her gösteriminde yeniden HTML
	kodu üretmeyeceğinden dolayı görüntülenmesini hızlandırır. Çünkü banner hafızası {$PRODUCT_NAME} programının direk adresini(URL)
	ve bannerı bünyesinde bulundurur.";

// Cache
$GLOBALS['strAge'] = "Yaş";


// Storage
$GLOBALS['strStorage'] = "Depolama";
$GLOBALS['strMoveToDirectory'] = "Veritabanında depolanan resimleri bir dizine taşı";

// Encoding
$GLOBALS['strEncodingConvert'] = "Dönüştür";


// Storage


// Product Updates
$GLOBALS['strSearchingUpdates'] = "Güncellemeler kontrol ediliyor. Lütfen bekleyiniz...";
$GLOBALS['strAvailableUpdates'] = "Mevcut ürün güncellemeleri";
$GLOBALS['strDownloadZip'] = "İndir (.zip)";
$GLOBALS['strDownloadGZip'] = "İndir (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "{$PRODUCT_NAME} programının yeni sürümü bulunmaktadır.                 \\n\\nBu güncelleme ile ilgili daha\\nfazla bilgi ister misiniz?";
$GLOBALS['strUpdateAlertSecurity'] = "{$PRODUCT_NAME} programının yeni sürümü bulunmaktadır.                 \\n\\nBu güncellemeyi yapmanız \\ntavsiye ediliyor, çünklü bu sürüm \\ngüvenlik problemlerinin onarılmış halini içeriyor.";


$GLOBALS['strNoNewVersionAvailable'] = "{$PRODUCT_NAME} sürümünüz güncellenmiş. şu anda mevcut bir güncelleme bulunmuyor.";



$GLOBALS['strNewVersionAvailable'] = "	<b>{$PRODUCT_NAME} yeni sürümü bulunmaktadır.</b><br> Bu güncellemeyi yüklemenizi tavsiye ederiz.
	Çünkü bu sürüm bazı problemleri çözebilir ve yeni özellikler ekleyebilir. Daha fazla bilgi için
	aşağıdaki dosyada bulunan dökümanları okuyunuz.";

$GLOBALS['strSecurityUpdate'] = "	<b>Bu güncellemeyi yüklemeniz şiddetle tavsiye ediliyor. Çünkü bu sürüm bazı güvenlik açıklarını onarıyor.
	.</b> Kullanmış olduğunuz {$PRODUCT_NAME} sürümü bazı saldırılara açık olabilir. Daha fazla bilgi için
	aşağıdaki dosyada bulunan dökümanları okuyunuz.";





// Stats conversion
$GLOBALS['strConverting'] = "Dönüştürülüyor";
$GLOBALS['strConvertingStats'] = "İstatistikler Dönüştürülüyor...";
$GLOBALS['strConvertStats'] = "İstatistikleri dönüştür";
$GLOBALS['strConvertAdViews'] = "Görüntülenme dönüştür,";
$GLOBALS['strConvertAdClicks'] = "Tıklanma dönüştürlüyor...";
$GLOBALS['strConvertNothing'] = "Hiçbir şey dönüştürülmedi...";
$GLOBALS['strConvertFinished'] = "Bitti...";

$GLOBALS['strConvertExplaination'] = "	Şu anda istatistiklerinizi depolamak için yoğunlaştırılmış biçimi kullanıyorsunuz. Ama <br>
	hala gereksiz içerikli istatistikleriniz bulunmakta. Bu gereksiz içerikli istatistikleriniz<br>
	yoğunlaştırılmış istatistiklere dönüştürülmeden bu sayfaları göremezsiniz. <br>
	İstatistiklerinizi dönüstürmden veritabanınızı yedekleyiniz ! <br>
	Gereksiz içerikli istatistiklerinizi yoğunlaştırılmış istatistik biçimine dönüştürmek istermisiniz?<br>";

$GLOBALS['strConvertingExplaination'] = "	Kalan tüm gereksiz içerikli istatistikleriniz yoğunlaştırılmış istatistiklere çevrildi.<br>
	Tüm kayıtların dönüştürülmesi biraz süre alacaktır. İBu süre içerisinde lütfen başka sayfaları
	gezmeyiniz. İşlem sonunda size veritabanı üzerinde yapılan değişikler ile ilgili rapor sunulacaktır.";

$GLOBALS['strConvertFinishedExplaination'] = "	Yoğunlaştırılmış istatistiklere dönüştürme işlemi başarıyla gerçekleştirildi, <br>
	şu anda veriler tekrar kullanılabilir halde. Aşağıda veritabanında yapılan tüm<br>
	değişiklikleri görebilirsiniz.<br>";

//  Maintenace

//  Deliver Limitations


//  Append codes


