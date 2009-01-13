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

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']  		= "ltr";
$GLOBALS['phpAds_TextAlignRight'] 		= "right";
$GLOBALS['phpAds_TextAlignLeft']  		= "left";

$GLOBALS['phpAds_DecimalPoint']			= '.';
$GLOBALS['phpAds_ThousandsSeperator']		= ',';


// Date & time configuration
$GLOBALS['date_format']				= "%m/%d/%Y";
$GLOBALS['time_format']				= "%H:%i:%S";
$GLOBALS['minute_format']			= "%H:%M";
$GLOBALS['month_format']			= "%m/%Y";
$GLOBALS['day_format']				= "%m/%d";
$GLOBALS['week_format']				= "%W/%Y";
$GLOBALS['weekiso_format']			= "%V/%G";



/*-------------------------------------------------------*/
/* Translations                                          */
/*-------------------------------------------------------*/

$GLOBALS['strHome'] 				= "Ana Sayfa";
$GLOBALS['strHelp']				= "Yardım";
$GLOBALS['strNavigation'] 			= "Neredeyim";
$GLOBALS['strShortcuts'] 			= "Kısayollar";
$GLOBALS['strAdminstration'] 			= "Envanter";
$GLOBALS['strMaintenance']			= "Bakım";
$GLOBALS['strProbability']			= "Olasılık";
$GLOBALS['strInvocationcode']			= "Çağırma kodu";
$GLOBALS['strBasicInformation'] 		= "Temel Bilgiler";
$GLOBALS['strContractInformation'] 		= "Sözleşme Bilgileri";
$GLOBALS['strLoginInformation'] 		= "Giriş bilgileri";
$GLOBALS['strOverview']				= "Genel Görünüm";
$GLOBALS['strSearch']				= "Arama";
$GLOBALS['strHistory']				= "Geçmiş";
$GLOBALS['strPreferences'] 			= "Tercihler";
$GLOBALS['strDetails']				= "Ayrıntılar";
$GLOBALS['strCompact']				= "Yoğunlaştırılmış";
$GLOBALS['strVerbose']				= "Gereksiz sözcükler";
$GLOBALS['strUser']				= "Kullanıcı";
$GLOBALS['strEdit']				= "Değiştir";
$GLOBALS['strCreate']				= "Yarat";
$GLOBALS['strDuplicate']			= "Çoğalt";
$GLOBALS['strMoveTo']				= "Taşı";
$GLOBALS['strDelete'] 				= "Sil";
$GLOBALS['strActivate']				= "Etkinleştir";
$GLOBALS['strDeActivate'] 			= "Etkinliğini kaldır";
$GLOBALS['strConvert']				= "Dönüştür";
$GLOBALS['strRefresh']				= "Yenile";
$GLOBALS['strSaveChanges']		 	= "Değişiklikleri Kaydet";
$GLOBALS['strUp'] 				= "Yukarı";
$GLOBALS['strDown'] 				= "Aşağı";
$GLOBALS['strSave'] 				= "Kaydet";
$GLOBALS['strCancel']				= "İptal";
$GLOBALS['strPrevious'] 			= "Önceki";
$GLOBALS['strNext'] 				= "Sonraki";
$GLOBALS['strYes']				= "Evet";
$GLOBALS['strNo']				= "Hayır";
$GLOBALS['strNone'] 				= "Hiçbiri";
$GLOBALS['strCustom']				= "Özel";
$GLOBALS['strDefault'] 				= "Varsayılan";
$GLOBALS['strOther']				= "Diğer";
$GLOBALS['strUnknown']				= "Bilinmeyen";
$GLOBALS['strUnlimited'] 			= "Sınırsız";
$GLOBALS['strUntitled']				= "Başlıksız";
$GLOBALS['strAll'] 				= "tümü";
$GLOBALS['strAvg'] 				= "Ort.";
$GLOBALS['strAverage']				= "Ortalama";
$GLOBALS['strOverall'] 				= "Tüm";
$GLOBALS['strTotal'] 				= "Toplam";
$GLOBALS['strActive'] 				= "etkin";
$GLOBALS['strFrom']				= "-den/-dan";
$GLOBALS['strTo']				= "-e/-a";
$GLOBALS['strLinkedTo'] 			= "bağlanmış";
$GLOBALS['strDaysLeft'] 			= "Kalan gün";
$GLOBALS['strCheckAllNone']			= "Tümünü / Hiçbirini Seç";
$GLOBALS['strKiloByte']				= "KB";
$GLOBALS['strExpandAll']			= "Hepsini Aç";
$GLOBALS['strCollapseAll']			= "Hepsini Kapat";
$GLOBALS['strShowAll']				= "Hepsini Göster";
$GLOBALS['strNoAdminInteface']			= "Yönetim ekranı, bakım amacıyla kapatılmıştır. Bu durum kampanyalarınızın çalışmasını etkilemez.";
$GLOBALS['strFilterBySource']			= "kaynağa göre filtrele";
$GLOBALS['strFieldContainsErrors']		= "Aşağıdaki alanlar hata içeriyor:";
$GLOBALS['strFieldFixBeforeContinue1']		= "Devam etmeden önce ";
$GLOBALS['strFieldFixBeforeContinue2']		= "bu hataları düzeltmeniz gerekiyor.";
$GLOBALS['strDelimiter']			= "Ayraç";



// Properties
$GLOBALS['strName']				= "İsim";
$GLOBALS['strSize']				= "Boyut";
$GLOBALS['strWidth'] 				= "Genişlik";
$GLOBALS['strHeight'] 				= "Yükseklik";
$GLOBALS['strURL2']				= "URL";
$GLOBALS['strTarget']				= "Hedef";
$GLOBALS['strLanguage'] 			= "Dil";
$GLOBALS['strDescription'] 			= "Tanımlama";
$GLOBALS['strID']				= "ID";


// Login & Permissions
$GLOBALS['strAuthentification'] 		= "Kimlik Doğrulama";
$GLOBALS['strWelcomeTo']			= "Hoşgeldiniz ";
$GLOBALS['strEnterUsername']			= "Giriş yapabilmek için kullanıcı adınızı ve parolanızı giriniz";
$GLOBALS['strEnterBoth']			= "Lütfen kullanıcı adınızı ve parolanızı birlikte giriniz";
$GLOBALS['strEnableCookies']			= $phpAds_productname." programını çalıştırmak için lütfen cookie özelliğini açınız";
$GLOBALS['strLogin'] 				= "Giriş";
$GLOBALS['strLogout'] 				= "Çıkış";
$GLOBALS['strUsername'] 			= "Kullanıcı Adı";
$GLOBALS['strPassword']				= "Parola";
$GLOBALS['strAccessDenied']			= "Erişim reddedildi";
$GLOBALS['strPasswordWrong']			= "Parola geçersiz";
$GLOBALS['strNotAdmin']				= "Yeterli önceliğiniz yok";
$GLOBALS['strDuplicateClientName']		= "Girdiğiniz kullanıcı adı başkası tarafından kullanılıyor. Lütfen başka bir kullanıcı adıyla yeniden deneyiniz.";


// General advertising
$GLOBALS['strImpressions'] 			=
$GLOBALS['strViews'] 				= "Görüntülenme";
$GLOBALS['strClicks']				= "Tıklamalar";
$GLOBALS['strCTRShort'] 			= "TGO";
$GLOBALS['strCTR'] 				= "TGO";
$GLOBALS['strTotalViews'] 			= "Toplam Görüntülenme";
$GLOBALS['strTotalClicks'] 			= "Toplam Tıklama";
$GLOBALS['strViewCredits'] 			= "Gösterim Alacakları";
$GLOBALS['strClickCredits'] 			= "Tıklama Alacakları";


// Time and date related
$GLOBALS['strDate'] 				= "Tarih";
$GLOBALS['strToday'] 				= "Bugün";
$GLOBALS['strDay']				= "Gün";
$GLOBALS['strDays']				= "Günler";
$GLOBALS['strLast7Days']			= "Son 7 Gün";
$GLOBALS['strWeek'] 				= "Hafta";
$GLOBALS['strWeeks']				= "Haftalar";
$GLOBALS['strMonths']				= "Aylar";
$GLOBALS['strThisMonth'] 			= "Bu Ay";
$GLOBALS['strMonth'][0] = "Ocak";
$GLOBALS['strMonth'][1] = "Şubat";
$GLOBALS['strMonth'][2] = "Mart";
$GLOBALS['strMonth'][3] = "Nisan";
$GLOBALS['strMonth'][4] = "Mayıs";
$GLOBALS['strMonth'][5] = "Haziran";
$GLOBALS['strMonth'][6] = "Temmuz";
$GLOBALS['strMonth'][7] = "Ağustos";
$GLOBALS['strMonth'][8] = "Eylül";
$GLOBALS['strMonth'][9] = "Ekim";
$GLOBALS['strMonth'][10] = "Kasım";
$GLOBALS['strMonth'][11] = "Aralık";

$GLOBALS['strDayShortCuts'][0] = "Pazar";
$GLOBALS['strDayShortCuts'][1] = "Pazartesi";
$GLOBALS['strDayShortCuts'][2] = "Salı";
$GLOBALS['strDayShortCuts'][3] = "Çarşamba";
$GLOBALS['strDayShortCuts'][4] = "Perşembe";
$GLOBALS['strDayShortCuts'][5] = "Cuma";
$GLOBALS['strDayShortCuts'][6] = "Ct";

$GLOBALS['strHour']				= "Saat";
$GLOBALS['strSeconds']				= "saniye";
$GLOBALS['strMinutes']				= "dakika";
$GLOBALS['strHours']				= "saat";
$GLOBALS['strTimes']				= "zamanlar";


// Advertiser
$GLOBALS['strClient']				= "Reklamveren";
$GLOBALS['strClients'] 				= "Reklamverenler";
$GLOBALS['strClientsAndCampaigns']		= "Reklamverenler ve Kampanyalar";
$GLOBALS['strAddClient'] 			= "Yeni reklamveren ekle";
$GLOBALS['strTotalClients'] 			= "Tüm reklamverenler";
$GLOBALS['strClientProperties']			= "Reklamveren Bilgileri";
$GLOBALS['strClientHistory']			= "Reklamveren Geçmişi";
$GLOBALS['strNoClients']			= "Henüz hiç reklamveren tanımlanmamış. Bir kampanya yaratabilmek için öncelikle <a href='advertiser-edit.php'>yeni bir reklamveren yarat</a>malısınız.";
$GLOBALS['strConfirmDeleteClient'] 		= "Bu reklamvereni silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmResetClientStats']		= "Bu reklamcıya ait tüm istatistikleri silmek istediğinize emin misiniz?";
$GLOBALS['strHideInactiveAdvertisers']		= "Etkin olmayan reklamverenleri gizle";
$GLOBALS['strInactiveAdvertisersHidden']	= "Etkin olmayan reklamveren(ler) gizlendi";


// Advertisers properties
$GLOBALS['strContact'] 				= "İletişim";
$GLOBALS['strEMail'] 				= "Eposta";
$GLOBALS['strSendAdvertisingReport']		= "Kampanya teslimat raporlarını epostayla gönder";
$GLOBALS['strNoDaysBetweenReports']		= "Teslimat raporları arasındaki gün sayısı";
$GLOBALS['strSendDeactivationWarning']  	= "Bir kampanya otomatik olarak etkin olduğunda ya da etkinliği kalktığında eposta gönder";
$GLOBALS['strAllowClientModifyInfo'] 		= "Bu kullanıcı kendi ayarlarını düzenleyebilsin";
$GLOBALS['strAllowClientModifyBanner'] 		= "Bu kullanıcı kendi bannerlarını düzenleyebilsin";
$GLOBALS['strAllowClientAddBanner'] 		= "Bu kullanıcı kendi bannerlarını ekleyebilsin";
$GLOBALS['strAllowClientDisableBanner'] 	= "Bu kullanıcı kendi bannerlarının etkinliğini kaldırabilsin";
$GLOBALS['strAllowClientActivateBanner'] 	= "Bu kullanıcı kendi bannerlarını etkinleştirebilsin";


// Campaign
$GLOBALS['strCampaign']				= "Kampanya";
$GLOBALS['strCampaigns']			= "Kampanya";
$GLOBALS['strTotalCampaigns'] 			= "Tüm kampanyalar";
$GLOBALS['strActiveCampaigns'] 			= "Etkin kampanyalar";
$GLOBALS['strAddCampaign'] 			= "Yeni kampanya ekle";
$GLOBALS['strCreateNewCampaign']		= "Yeni Kampanya Oluştur";
$GLOBALS['strModifyCampaign']			= "Kampanyayı düzenle";
$GLOBALS['strMoveToNewCampaign']		= "Yeni Kampanyaya Taşı";
$GLOBALS['strBannersWithoutCampaign']		= "Bannersız Kampanyalar";
$GLOBALS['strDeleteAllCampaigns']		= "Tüm kampanyaları sil";
$GLOBALS['strCampaignStats']			= "Kampanya İstatistikleri";
$GLOBALS['strCampaignProperties']		= "Kampanya Bilgileri";
$GLOBALS['strCampaignOverview']			= "Kampanya Özeti";
$GLOBALS['strCampaignHistory']			= "Kampanya Geçmişi";
$GLOBALS['strNoCampaigns']			= "Henüz tanımlanmış Kampanya yok";
$GLOBALS['strConfirmDeleteAllCampaigns']	= "Bu reklamverene ait tüm kampayaları silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmDeleteCampaign']		= "Bu kampanyayı silmek istediğinize emin misiniz?";
$GLOBALS['strHideInactiveCampaigns']		= "Etkin olmayan kampanyaları gizle";
$GLOBALS['strInactiveCampaignsHidden']		= "Etkin olmayan kampanya(lar) gizlendi";


// Campaign properties
$GLOBALS['strDontExpire']			= "Bu kampanyayı belirli bir tarihte bitirme";
$GLOBALS['strActivateNow'] 			= "Bu kampanyayı hemen aktif et";
$GLOBALS['strLow']				= "Düşük";
$GLOBALS['strHigh']				= "Yüksek";
$GLOBALS['strExpirationDate']			= "Bitiş Tarihi";
$GLOBALS['strActivationDate']			= "Başlama Tarihi";
$GLOBALS['strImpressionsPurchased'] 	=
$GLOBALS['strViewsPurchased'] 			= "Kalan Görüntülenme";
$GLOBALS['strClicksPurchased'] 			= "Kalan Tıklama";
$GLOBALS['strCampaignWeight']			= "Kampanya Ağırlığı";
$GLOBALS['strHighPriority']			= "Bu kampanyadaki bannerları yüksek öncelikli belirle.<br>Eğer bu özelliği seçerseniz program kısa sürede görüntüleme kredisini dolduracaktır.";
$GLOBALS['strLowPriority']			= "Bu kampanyadaki bannerları düşük öncelikli belirle.<br>Bu kampanya yüksek öncelikli kampanyalardan fırsat bulduğu zaman görüntülenecektir.";
$GLOBALS['strTargetLimitAdviews']		= "Görüntülenme limiti";
$GLOBALS['strTargetPerDay']			= "günlük.";
$GLOBALS['strPriorityAutoTargeting']		= "Otomatik - Kalan gösterimi kalan günlere uygun şekilde dağıt.";



// Banners (General)
$GLOBALS['strBanner'] 				= "Banner";
$GLOBALS['strBanners'] 				= "Bannerlar";
$GLOBALS['strAddBanner'] 			= "Yeni banner ekle";
$GLOBALS['strModifyBanner'] 			= "Banner düzenle";
$GLOBALS['strActiveBanners'] 			= "Etkin bannerlar";
$GLOBALS['strTotalBanners'] 			= "Tüm bannerlar";
$GLOBALS['strShowBanner']			= "Banneri göster";
$GLOBALS['strShowAllBanners']	 		= "Tüm Bannerları göster";
$GLOBALS['strShowBannersNoAdClicks']		= "Tıklanmayan bannerları göster";
$GLOBALS['strShowBannersNoAdViews']		= "Görüntülemeyen Bannerları göster";
$GLOBALS['strDeleteAllBanners']	 		= "Tüm bannerları sil";
$GLOBALS['strActivateAllBanners']		= "Tüm bannerları etkinleştir";
$GLOBALS['strDeactivateAllBanners']		= "Tüm bannerların etkinliğini kaldır";
$GLOBALS['strBannerOverview']			= "Banner Genel Görünüm";
$GLOBALS['strBannerProperties']			= "Banner Özellikleri";
$GLOBALS['strBannerHistory']			= "Banner Geçmişi";
$GLOBALS['strBannerNoStats'] 			= "Bu bannera ait istatistik yok";
$GLOBALS['strNoBanners']			= "Tanımlanmış Banner Yok";
$GLOBALS['strConfirmDeleteBanner']		= "Bu bannerı silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmDeleteAllBanners']		= "Bu kampanyaya ait tüm bannerları silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmResetBannerStats']		= "Bu bannera ait tüm istatistikleri silmek istediğinize emin misiniz?";
$GLOBALS['strShowParentCampaigns']		= "Üst kampanyaları göster";
$GLOBALS['strHideParentCampaigns']		= "Üst kampanyaları gizle";
$GLOBALS['strHideInactiveBanners']		= "Etkin olmayan bannerları gizle";
$GLOBALS['strInactiveBannersHidden']		= "Etkin olmayan banner(lar) gizlendi";



// Banner (Properties)
$GLOBALS['strChooseBanner'] 			= "Lütfen banner tipini seçiniz";
$GLOBALS['strMySQLBanner'] 			= "Yerel banner (SQL)";
$GLOBALS['strWebBanner'] 			= "Yerel banner (Webserver)";
$GLOBALS['strURLBanner'] 			= "Harici banner";
$GLOBALS['strHTMLBanner'] 			= "HTML banner";
$GLOBALS['strTextBanner'] 			= "Yazı Olarak Reklam";
$GLOBALS['strAutoChangeHTML']			= "HTML kodunu tıklamaları izleyecek şekilde değiştir";
$GLOBALS['strUploadOrKeep']			= "Varolan resmi korumak mı, <br />yoksa yeni bir tane mi <br />yüklemek istersiniz?";
$GLOBALS['strNewBannerFile'] 			= "Bu banner için kullanacağınız <br/>resmi seçiniz<br /><br />";
$GLOBALS['strNewBannerURL'] 			= "Resim URL (http:// dahil yazın)";
$GLOBALS['strURL'] 				= "Hedef URL (http:// dahil yazın)";
$GLOBALS['strHTML'] 				= "HTML";
$GLOBALS['strTextBelow'] 			= "Resim altına gelen yazı";
$GLOBALS['strKeyword'] 				= "Anahtar Kelimeler";
$GLOBALS['strWeight'] 				= "Ağırlığı";
$GLOBALS['strAlt'] 				= "Alt(ernatif) yazı";
$GLOBALS['strStatusText']			= "Durum yazısı";
$GLOBALS['strBannerWeight']			= "Banner ağırlığı";


// Banner (swf)
$GLOBALS['strCheckSWF']				= "Flash dosyaları içerisindeki sabit URL bağlantıları denetle";
$GLOBALS['strConvertSWFLinks']			= "Flash linklerini dönüştür";
$GLOBALS['strConvertSWF']			= "<br />Yüklediğiniz flash banner dosyası elle girilmiş sabit bağlantılar içeriyor. ". MAX_PRODUCT_NAME .", banner içindeki bu bağlantıları dönüştürmediğiniz sürece tıklama rakibi yapamayacaktır. Aşağıda Flash dosyası içindeki bağlantıları bulabilirsiniz. Bağlantı URL'lerini değiştirmek için, <b>Dönüştür</b>'e, aksi takdirde <b>iptal</b>'e tıklayınız.<br /><br />Dikkat edin: Eğer <b>dönüştür</b>'e tıklarsanız yüklediğiniz Flash dosyası fiziksel olarak değiştirilecektir.<br /> Lütfen özgün dosyanın bir yedeğini saklayınız. Dosyanın özgün hali hangi versiyonla yaratılmış olursa olsun, sonuçta yaratılacak dosyanın doğru şekilde görüntülenmesi için Flash 4 Player (veya üstü) gerekecektir.<br /><br />";
$GLOBALS['strCompressSWF']			= "Daha hızlı yüklenmesi için SWF dosyasını sıkıştır (Flash 6 player gerekli)";


// Banner (network)
$GLOBALS['strBannerNetwork']			= "HTML şablonu";
$GLOBALS['strChooseNetwork']			= "Kullanacağınız şablonu seçiniz";
$GLOBALS['strMoreInformation']			= "Daha fazla bilgi...";
$GLOBALS['strRichMedia']			= "Richmedia";
$GLOBALS['strTrackAdClicks']			= "Tıklamaları izle";


// Display limitations
$GLOBALS['strModifyBannerAcl'] 			= "Teslimat Seçenekleri";
$GLOBALS['strACL'] 				= "Teslimat";
$GLOBALS['strACLAdd'] 				= "Yeni Sınırlama Ekle";
$GLOBALS['strNoLimitations']			= "Kısıtlama yok";
$GLOBALS['strApplyLimitationsTo']		= "Kısıtlamaları şunun için uygula:";
$GLOBALS['strRemoveAllLimitations']		= "Tüm kısıtlamaları kaldır";
$GLOBALS['strEqualTo']				= "eşittir";
$GLOBALS['strDifferentFrom']			= "farklıdır";
$GLOBALS['strAND']				= "VE";  						// logical operator
$GLOBALS['strOR']				= "VEYA"; 						// logical operator
$GLOBALS['strOnlyDisplayWhen']			= "Bu bannerı yalnızca şu durumda göster:";
$GLOBALS['strWeekDay'] 				= "Haftaiçi";
$GLOBALS['strTime'] 				= "Zaman";
$GLOBALS['strUserAgent'] 			= "Kullanıcı Temsilcisi";
$GLOBALS['strDomain'] 				= "Alan";
$GLOBALS['strClientIP'] 			= "Müşteri IP";
$GLOBALS['strSource'] 				= "Kaynak";
$GLOBALS['strBrowser'] 				= "Tarayıcı";
$GLOBALS['strOS'] 				= "İşletim Sistemi";
$GLOBALS['strCountry'] 				= "Ülke";
$GLOBALS['strContinent'] 			= "Kıta";
$GLOBALS['strDeliveryLimitations']		= "Teslimat Kısıtlamaları";
$GLOBALS['strDeliveryCapping']			= "Ziyaretçi başına teslimat sınırlaması";
$GLOBALS['strTimeCapping']			= "Bu banner daha önceden gösterildi. Aynı bannerı aynı kullanıcı için gösterme:";
$GLOBALS['strImpressionCapping']		= "Aynı kullanıcıya bu banner defadan fazla gösterme:";


// Publisher
$GLOBALS['strAffiliate']			= "Web sitesi";
$GLOBALS['strAffiliates']			= "Web Siteleri ";
$GLOBALS['strAffiliatesAndZones']		= "Web Siteleri ve Alanlar";
$GLOBALS['strAddNewAffiliate']			= "Yeni web sitesi ekle";
$GLOBALS['strAddAffiliate']			= "Yayıncı Oluştur";
$GLOBALS['strAffiliateProperties']		= "Web Sitesi Özellikleri";
$GLOBALS['strAffiliateOverview']		= "Yayıncı Önizleme";
$GLOBALS['strAffiliateHistory']			= "Web Sitesi Geçmişi";
$GLOBALS['strZonesWithoutAffiliate']		= "Web Sitesi olmayan alanlar";
$GLOBALS['strMoveToNewAffiliate']		= "Yeni web sitesine taşı";
$GLOBALS['strNoAffiliates']			= "Henüz tanımlı bir web sitesi yok. Bir alan yaratmak için öncelikle <a href='affiliate-edit.php'>yeni bir web sitesi yarat</a>malısınız.";
$GLOBALS['strConfirmDeleteAffiliate']		= "Bu web sitesini silmek istediğinize emin misiniz?";
$GLOBALS['strMakePublisherPublic']		= "Bu web sitesine ait tüm alanları herkesçe erişilebilir yap";


// Publisher (properties)
$GLOBALS['strWebsite']				= "Web sitesi";
$GLOBALS['strAllowAffiliateModifyInfo'] 	= "Bu kullanıcı kendi ayarlarını düzenleyebilsin";
$GLOBALS['strAllowAffiliateModifyZones'] 	= "Bu kullanıcının kendi alanlarını düzenlemesine izin ver";
$GLOBALS['strAllowAffiliateLinkBanners'] 	= "Bu kullanıcının kendi alanlarına banner bağlamasına izin ver";
$GLOBALS['strAllowAffiliateAddZone'] 		= "Bu kullanıcının yeni alanlar tanımlamasına izin ver";
$GLOBALS['strAllowAffiliateDeleteZone'] 	= "Bu kullanıcının varolan alanları silmesine izin ver";


// Zone
$GLOBALS['strZone']				= "Alan";
$GLOBALS['strZones']				= "Alanlar";
$GLOBALS['strAddNewZone']			= "Yeni alan ekle";
$GLOBALS['strAddZone']				= "Alan Oluştur";
$GLOBALS['strModifyZone']			= "Alanı düzenle";
$GLOBALS['strLinkedZones']			= "Bağlı alanlar";
$GLOBALS['strZoneOverview']			= "Alan Genel Görünüş";
$GLOBALS['strZoneProperties']			= "Alan Özellikleri";
$GLOBALS['strZoneHistory']			= "Alan Geçmişi";
$GLOBALS['strNoZones']				= "Henüz hiçbir alan tanımlanmamış";
$GLOBALS['strConfirmDeleteZone']		= "Bu alanı silmek istediğinize emin misiniz?";
$GLOBALS['strZoneType']				= "Alan tipi";
$GLOBALS['strBannerButtonRectangle']		= "Banner, Düğme veya Dikdörtgen";
$GLOBALS['strInterstitial']			= "Sayfa arası reklamı \"veya\" Yüzen reklam";
$GLOBALS['strPopup']				= "Açılır pencere (popup) reklam";
$GLOBALS['strTextAdZone']			= "Metin reklam";
$GLOBALS['strShowMatchingBanners']		= "Eşleşen bannerları göster";
$GLOBALS['strHideMatchingBanners']		= "Eşleşen bannerları gizle";


// Advanced zone settings
$GLOBALS['strAdvanced']				= "Gelişmiş";
$GLOBALS['strChains']				= "Zincirler";
$GLOBALS['strChainSettings']			= "Zincir ayarları";
$GLOBALS['strZoneNoDelivery']			= "Bu alana ait hiçbir banner <br/>tanımlanmamışsa şunu dene...";
$GLOBALS['strZoneStopDelivery']			= "Gösterimi durdur ve banner gösterme";
$GLOBALS['strZoneOtherZone']			= "Yerine seçilen alanı göster";
$GLOBALS['strZoneUseKeywords']			= "Aşağıdaki anahtar cümlecikleri kullanan bannerları göster";
$GLOBALS['strZoneAppend']			= "Bu alanda gösterilen bannerlara her zaman aşağıdaki HTML kodunu ekle";
$GLOBALS['strAppendSettings']			= "Başına ve sonuna ekleme ayarları";
$GLOBALS['strZonePrependHTML']			= "Bu alanda gösterilen bannerların başına her zaman aşağıdaki HTML kodunu ekle";
$GLOBALS['strZoneAppendHTML']			= "Bu alanda gösterilen metin reklamların sonuna her zaman aşağıdaki HTML kodunu ekle";


// Linked banners/campaigns
$GLOBALS['strSelectZoneType']			= "Lütfen bu alana neyin bağlanacağını seçin";
$GLOBALS['strBannerSelection']			= "Banner tercihleri";
$GLOBALS['strCampaignSelection']		= "Kanpanya tercihleri";
$GLOBALS['strInteractive']			= "Interaktif";
$GLOBALS['strRawQueryString']			= "Anahtar Kelime";
$GLOBALS['strIncludedBanners']			= "Bağlantılı bannerlar";
$GLOBALS['strLinkedBannersOverview']		= "İlişkili banner önizleme";
$GLOBALS['strLinkedBannerHistory']		= "İlişkili banner geçmişi";
$GLOBALS['strNoZonesToLink']			= "Bu bannerın bağlanabileceği herhangi bir alan bulunmamaktadır";
$GLOBALS['strNoBannersToLink']			= "Bu alana ilişkilendirilecek uygun banner bulunmamaktadır";
$GLOBALS['strNoLinkedBanners']			= "Bu alana ilişkilnedirilecek herhangi bir banner bulunmamktadır";
$GLOBALS['strMatchingBanners']			= "{count} uygun banner";
$GLOBALS['strNoCampaignsToLink']		= "Bu alana bağlanabilecek hiçbir kampanya bulunmamaktadır";
$GLOBALS['strNoZonesToLinkToCampaign']  	= "Bu kampanyanın bağlanabileceği alan bulunmamaktadır";
$GLOBALS['strSelectBannerToLink']		= "Bu alana bağlamak istediğiniz bannerı seçin:";
$GLOBALS['strSelectCampaignToLink']		= "Bu alana bağlamak istediğiniz kampanyayı seçin:";


// Statistics
$GLOBALS['strStats'] 				= "İstatistikler";
$GLOBALS['strNoStats']				= "Henüz istatistik bulunmamakta";
$GLOBALS['strConfirmResetStats']		= "Mevcut tüm istatistikleri silmek istediğinize emin misiniz?";
$GLOBALS['strGlobalHistory']			= "Genel Geçmiş";
$GLOBALS['strDailyHistory']			= "Günlük Geçmiş";
$GLOBALS['strDailyStats'] 			= "Günlük istatistikler";
$GLOBALS['strWeeklyHistory']			= "Haftalık geçmiş";
$GLOBALS['strMonthlyHistory']			= "Aylık geçmiş";
$GLOBALS['strCreditStats'] 			= "Kredi istatistikleri";
$GLOBALS['strDetailStats'] 			= "Detaylı istatistikler";
$GLOBALS['strTotalThisPeriod']			= "Bu periyoda ait toplam";
$GLOBALS['strAverageThisPeriod']		= "Bu dönemde ortalama";
$GLOBALS['strDistribution']			= "Dağıtım";
$GLOBALS['strResetStats'] 			= "İstatistikleri temizle";
$GLOBALS['strSourceStats']			= "Kaynak istatistikler";
$GLOBALS['strSelectSource']			= "Görmek istediğiniz kaynağı seçiniz:";


// Hosts
$GLOBALS['strHosts']				= "Sunucular";
$GLOBALS['strTopTenHosts'] 			= "İstekte bulunan TOP 10 Sunucu";


// Expiration
$GLOBALS['strExpired']				= "Süresi dolmuş";
$GLOBALS['strExpiration'] 			= "Bitiş";
$GLOBALS['strNoExpiration'] 			= "Bitiş tarihi belirtilmemiş";
$GLOBALS['strEstimated'] 			= "Tahmini bitiş tarihi";


// Reports
$GLOBALS['strReports']				= "Raporlar";
$GLOBALS['strSelectReport']			= "Üreteceğiniz rapor tipini seçiniz";


// Userlog
$GLOBALS['strUserLog']				= "Kullanıcı kayıtları";
$GLOBALS['strUserLogDetails']			= "Kullanıcı kayıt detayları";
$GLOBALS['strDeleteLog']			= "Kayıtları Sil";
$GLOBALS['strAction']				= "Eylem";
$GLOBALS['strNoActionsLogged']			= "Kaydedilmiş aktivite yok";


// Code generation
$GLOBALS['strGenerateBannercode']		= "Direkt seçim";
$GLOBALS['strChooseInvocationType']		= "Lütfen banner çağırma tipini seçiniz";
$GLOBALS['strGenerate']				= "Oluştur";
$GLOBALS['strParameters']			= "Etiket ayarları";
$GLOBALS['strFrameSize']			= "Çerçeve boyutu";
$GLOBALS['strBannercode']			= "Banner kodu";


// Errors
$GLOBALS['strMySQLError'] 			= "SQL Hatası:";
$GLOBALS['strLogErrorClients'] 			= "[phpAds] Veritabanından reklamverenleri alırken bir hata oluştu.";
$GLOBALS['strLogErrorBanners'] 			= "[phpAds] Veritabanından bannerları alırken bir hata oluştu.";
$GLOBALS['strLogErrorViews'] 			= "[phpAds] Veritabanından gösterimleri alırken bir hata oluştu.";
$GLOBALS['strLogErrorClicks'] 			= "[phpAds] Veritabanından tıklamaları alırken bir hata oluştu.";
$GLOBALS['strErrorViews'] 			= "Gösterim sayısını belirtmelisiniz veya sınırsız seçeneğini işaretlemelisiniz!";
$GLOBALS['strErrorNegViews'] 			= "Negatif gösterim sayıları geçersizdir";
$GLOBALS['strErrorClicks'] 			= "Tıklanma sayısını belirtmelisiniz veya sınırsız seçeneğini işaretlemelisiniz!";
$GLOBALS['strErrorNegClicks'] 			= "Negatif tıklanma sayıları geçersizdir";
$GLOBALS['strNoMatchesFound']			= "Uygun kayıt bulunamadı";
$GLOBALS['strErrorOccurred']			= "Bir hata oluştu";
$GLOBALS['strErrorUploadSecurity']		= "Olası bir güvenlik problemi saptandı, yükleme durduruldu!";
$GLOBALS['strErrorUploadBasedir']		= "Muhtemelen safemode ya da open_basedir kısıtlamalarından dolayı yüklenen dosyaya ulaşılamadı";
$GLOBALS['strErrorUploadUnknown']		= "Bilinmeyen bir nedenden dolayı yüklenen dosyaya ulaşılamadı. Lütfen PHP ayarlarınızı kontrol edin";
$GLOBALS['strErrorStoreLocal']			= "Yerel klasöre bannerı kaydederken hata oluştu. Yerel dizin ayarlarının yanlış yapıldığından dolayı olabilir.";
$GLOBALS['strErrorStoreFTP']			= "Banner FTP sunucuya gönderilirken hata oluıştu. Bu sunucunun uygun olmadığından veya FTP sunucunun ayarlarının yanlış yapıldığından dolayı olabilir";


// E-mail
$GLOBALS['strMailSubject'] 			= "Reklamveren raporu";
$GLOBALS['strAdReportSent']			= "Reklamcı Raporu Gönderildi";
$GLOBALS['strMailSubjectDeleted'] 		= "Pasif Bannerlar";
$GLOBALS['strMailHeader'] 			= "Sayın {contact},\n";
$GLOBALS['strMailBannerStats'] 			= "{clientname} için banner istatistiklerini aşağıda bulacaksınız:";
$GLOBALS['strMailFooter'] 			= "Saygılar,\n   {adminfullname}";
$GLOBALS['strMailClientDeactivated'] 		= "Aşağıdaki bannerlar kapatıldı çünkü";
$GLOBALS['strMailNothingLeft'] 			= "Sitemizde reklam yayınlamaya devam etmek istiyorsanız, lütfen bizimle iletişime geçin.\nİletişime geçmeniz bizi memnun eder.";
$GLOBALS['strClientDeactivated']		= "Bu kampanya şu anda aktif değil, çünkü";
$GLOBALS['strBeforeActivate']			= "aktivasyon tarihine henüz ulaşılmadı";
$GLOBALS['strAfterExpire']			= "sona erme tarihine ulaşıldı";
$GLOBALS['strNoMoreClicks']			= "tıklama kalmadı";
$GLOBALS['strNoMoreViews']			= "görünütülenme kredisi kalmadı";
$GLOBALS['strWarnClientTxt']			= "Bannerlarınız için kalan Gösterim, Tıklama veya Dönüşüm sayıları {limit} altına düşüyor. \nGösterim, Tıklama veya Dönüşümü biten bannerlarınız pasifleştirilecektir. ";
$GLOBALS['strImpressionsClicksLow']		=
$GLOBALS['strViewsClicksLow']			= "Gösterim/Tıklanama Kredisi az Kaldı";
$GLOBALS['strNoViewLoggedInInterval']   	= "Bu rapor süresince gösterim kaydedilmedi";
$GLOBALS['strNoClickLoggedInInterval']  	= "Bu rapor süresince tıklama kaydedilmedi";
$GLOBALS['strMailReportPeriod']			= "Bu rapor {startdate} tarihi ile {enddate} tarihleri arasındaki istatistikleri içerir.";
$GLOBALS['strMailReportPeriodAll']		= "Bu rapor {enddate} tarihine kadarki tüm istatistikleri içerir.";
$GLOBALS['strNoStatsForCampaign'] 		= "Bu kampanyaya ait istatistik bulunmuyor";


// Priority
$GLOBALS['strPriority']				= "Öncelik";


// Settings
$GLOBALS['strSettings'] 			= "Ayarlar";
$GLOBALS['strGeneralSettings']			= "Genel Ayarlar";
$GLOBALS['strMainSettings']			= "Ana Ayarlar";
$GLOBALS['strAdminSettings']			= "Yönetici Ayarları";


// Product Updates
$GLOBALS['strProductUpdates']			= "Ürün Güncellemeleri";



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strStartOver'] = "Baştan başla";
$GLOBALS['strTrackerVariables'] = "İzleme değişkenleri";
$GLOBALS['strLogoutURL'] = "Çıkışta yönlendirilecek URL. <br />Varsayılan için boş bırakın";
$GLOBALS['strAppendTrackerCode'] = "İzleme kodunu ekle";
$GLOBALS['strStatusDuplicate'] = "Çoğalt";
$GLOBALS['strMiscellaneous'] = "Çeşitli";
$GLOBALS['strPriorityOptimisation'] = "Çeşitli";
$GLOBALS['strCollectedAllStats'] = "Tüm istatistikler";
$GLOBALS['strCollectedToday'] = "Bugün";
$GLOBALS['strCollectedYesterday'] = "Dün";
$GLOBALS['strCollectedThisWeek'] = "Bu hafta";
$GLOBALS['strCollectedLastWeek'] = "Geçen hafta";
$GLOBALS['strCollectedThisMonth'] = "Bu ay";
$GLOBALS['strCollectedLastMonth'] = "Geçen ay";
$GLOBALS['strCollectedLast7Days'] = "Son 7 gün";
$GLOBALS['strCollectedSpecificDates'] = "Belirli tarihler";
$GLOBALS['strAdmin'] = "Yönetici";
$GLOBALS['strNotice'] = "Uyarı";
$GLOBALS['strPriorityLevel'] = "Öncelik düzeyi";
$GLOBALS['strPriorityTargeting'] = "Dağıtım";
$GLOBALS['strLimitations'] = "Kısıtlamalar";
$GLOBALS['strCapping'] = "Başlıklamak";
$GLOBALS['strVariableDescription'] = "Tanımlama";
$GLOBALS['strVariables'] = "Değişkenler";
$GLOBALS['strStatsVariables'] = "Değişkenler";
$GLOBALS['strComments'] = "Yorumlar";
$GLOBALS['strUsernameOrPasswordWrong'] = "Girmiş olduğunuz kullanıcı adı ve/veya parola geçerli değil. Lütfen tekrar deneyiniz.";
$GLOBALS['strDuplicateAgencyName'] = "Girdiğiniz kullanıcı adı başkası tarafından kullanılıyor. Lütfen başka bir kullanıcı adıyla yeniden deneyiniz.";
$GLOBALS['strRequests'] = "İstekler";
$GLOBALS['strImpressions'] = "Gösterimler";
$GLOBALS['strConversions'] = "Dönüşümler";
$GLOBALS['strCNVRShort'] = "Dn";
$GLOBALS['strCNVR'] = "Satış Oranı";
$GLOBALS['strTotalConversions'] = "Toplam Dönüşüm";
$GLOBALS['strConversionCredits'] = "Dönüşüm Alacakları";
$GLOBALS['strDateTime'] = "Tarih Saat";
$GLOBALS['strTrackerID'] = "İzleme ID";
$GLOBALS['strTrackerName'] = "İzleme Adı";
$GLOBALS['strCampaignID'] = "Kampanya ID";
$GLOBALS['strCampaignName'] = "Kampanya Adı";
$GLOBALS['strStatsAction'] = "Eylem";
$GLOBALS['strWindowDelay'] = "Pencere gecikmesi";
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Aylık Kiralama";
$GLOBALS['strBreakdownByDay'] = "Gün";
$GLOBALS['strBreakdownByWeek'] = "Hafta";
$GLOBALS['strSingleMonth'] = "Ay";
$GLOBALS['strBreakdownByMonth'] = "Ay";
$GLOBALS['strDayOfWeek'] = "Haftanın günü";
$GLOBALS['strBreakdownByDow'] = "Haftanın günü";
$GLOBALS['strBreakdownByHour'] = "Saat";
$GLOBALS['strHiddenAdvertiser'] = "Reklamveren";
$GLOBALS['strAddClient_Key'] = "Ye<u>n</u>i reklamveren ekle";
$GLOBALS['strChars'] = "karakter";
$GLOBALS['strAllowClientViewTargetingStats'] = "Bu kullanıcı hedefleme istatistiklerini görebilsin";
$GLOBALS['strCsvImportConversions'] = "Bu kullanıcı çevrimdışı dönüşümleri içe aktarabilsin";
$GLOBALS['strHiddenCampaign'] = "Kampanya";
$GLOBALS['strAddCampaign_Key'] = "Ye<u>n</u>i kampanya ekle";
$GLOBALS['strLinkedCampaigns'] = "Bağlı kampanyalar";
$GLOBALS['strShowParentAdvertisers'] = "Üst reklamverenleri göster";
$GLOBALS['strHideParentAdvertisers'] = "Üst reklamverenleri gizle";
$GLOBALS['strContractDetails'] = "Sözleşme ayrıntıları";
$GLOBALS['strInventoryDetails'] = "Envanter ayrıntıları";
$GLOBALS['strPriorityInformation'] = "Diğer kampanyalara göre öncelik";
$GLOBALS['strPriorityHigh'] = "Ücretli kampanyalar";
$GLOBALS['strPriorityLow'] = "Ücretsiz veya kendine ait kampanyalar";
$GLOBALS['strHiddenAd'] = "Reklam";
$GLOBALS['strHiddenTracker'] = "İzleyici";
$GLOBALS['strTracker'] = "İzleyici";
$GLOBALS['strHiddenZone'] = "Alan";
$GLOBALS['strCompanionPositioning'] = "Klavuz yerleştirme";
$GLOBALS['strSelectUnselectAll'] = "Tümünü Seç / Seçme";
$GLOBALS['strExclusive'] = "Ayrıcalıklı";
$GLOBALS['strExpirationDateComment'] = "Kampanya bu günün sonunda bitecek";
$GLOBALS['strActivationDateComment'] = "Kampanya bu tarihte başlayacak";
$GLOBALS['strRevenueInfo'] = "Gelir Bilgisi";
$GLOBALS['strImpressionsRemaining'] = "Kalan Gösterimler";
$GLOBALS['strClicksRemaining'] = "Kalan Tıklamalar";
$GLOBALS['strConversionsRemaining'] = "Kalan Dönüşümler";
$GLOBALS['strImpressionsBooked'] = "Ayırtılmış Gösterimler";
$GLOBALS['strClicksBooked'] = "Ayırtılmış Tıklamalar";
$GLOBALS['strConversionsBooked'] = "Ayırtılmış Dönüşümler";
$GLOBALS['strOptimise'] = "Optimize et";
$GLOBALS['strAnonymous'] = "Bu kampanyanın reklamverenini ve web sitesini gizle ";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "Bu kampanyanın önceliği düşük olarak ayarlanmış,\nancak ağırlığı 0 ya da ayarlanmamış.\nBu durum, kampanya ağırlığına geçerli bir değer verilene kadar kampanyanın etkinliğinin kaldırılmasına\nve bağlı bannerların gösteriminin durdurulmasına \nneden olacak.\n\nDevam etmek istediğinize emin misiniz?";
$GLOBALS['strCampaignWarningExclusiveNoWeight'] = "Bu kampanyanın önceliği düşük olarak ayarlanmış,\nancak ağırlığı 0 ya da ayarlanmamış.\nBu durum, kampanya ağırlığına geçerli bir değer verilene kadar kampanyanın etkinliğinin kaldırılmasına\nve bağlı bannerların gösteriminin durdurulmasına \nneden olacak.\n\nDevam etmek istediğinize emin misiniz?";
$GLOBALS['strCampaignWarningNoTarget'] = "Bu kampanyanın önceliği yüksek olarak ayarlanmış,\nancak hedeflenen gösterim sayısı belirlenmemiş.\nBu durum, geçerli bir hedef gösterim sayısı verilene kadar kampanyanın etkinliğinin kaldırılmasına\nve bağlı bannerların gösteriminin durdurulmasına \nneden olacak.\n\nDevam etmek istediğinize emin misiniz?";
$GLOBALS['strTrackerOverview'] = "İzleyici Genel Görünümü";
$GLOBALS['strAddTracker'] = "Yeni bir izleyici ekle";
$GLOBALS['strAddTracker_Key'] = "Ye<u>n</u>i bir izleyici ekle";
$GLOBALS['strConfirmDeleteAllTrackers'] = "Bu reklamverene ait tüm izleyicileri silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmDeleteTracker'] = "Bu izleyiciyi silmek istediğinize emin misiniz?";
$GLOBALS['strDeleteAllTrackers'] = "Tüm izleyicileri sil";
$GLOBALS['strTrackerProperties'] = "İzleyici Özellikleri";
$GLOBALS['strModifyTracker'] = "İzleyiciyi düzenle";
$GLOBALS['strLog'] = "Kayda alınsın mı?";
$GLOBALS['strDefaultStatus'] = "Varsayılan Durum";
$GLOBALS['strStatus'] = "Durum";
$GLOBALS['strLinkedTrackers'] = "Bağlı İzleyiciler";
$GLOBALS['strConversionWindow'] = "Dönüştürme penceresi";
$GLOBALS['strUniqueWindow'] = "Tekil pencere";
$GLOBALS['strClick'] = "Tıkla";
$GLOBALS['strView'] = "Görüntüle";
$GLOBALS['strLinkCampaignsByDefault'] = "Yeni yaratılan kampanyaları doğrudan bağla";
$GLOBALS['strConversionType'] = "Dönüşüm tipi";
$GLOBALS['strAddBanner_Key'] = "Ye<u>n</u>i banner ekle";
$GLOBALS['strAppendTextAdNotPossible'] = "Metin reklamlara başka banner eklemeniz olanaklı değildir.";
$GLOBALS['strWarningMissing'] = "Uyarı, muhtemelen kayıp";
$GLOBALS['strWarningMissingClosing'] = "kapatma tag'i  \">\"";
$GLOBALS['strWarningMissingOpening'] = "açma tag'i \"<\"";
$GLOBALS['strSubmitAnyway'] = "Her şeye rağmen Gönder";
$GLOBALS['strUploadOrKeepAlt'] = "Varolan yedek resmi korumak mı, <br /> yoksa yeni bir tane mi <br />yüklemek istersiniz? ";
$GLOBALS['strNewBannerFileAlt'] = "Tarayıcının zengin medya <br />desteklememesi halinde <br /> kullanmak istediğiniz yedek resmi seçiniz <br /><br />";
$GLOBALS['strAdserverTypeGeneric'] = "Jenerik HTML banner";
$GLOBALS['strGenericOutputAdServer'] = "Jenerik";
$GLOBALS['strGeneric'] = "Jenerik";
$GLOBALS['strSwfTransparency'] = "Şeffaf zemine izin ver";
$GLOBALS['strHardcodedLinks'] = "Elle girilmiş, sabit bağlantılar";
$GLOBALS['strOverwriteSource'] = "Kaynak parametresinin üzerine yaz";
$GLOBALS['strChannelLimitations'] = "Teslimat Seçenekleri";
$GLOBALS['strLaterThan'] = "daha geçtir";
$GLOBALS['strLaterThanOrEqual'] = "daha geç ya da eşittir";
$GLOBALS['strEarlierThan'] = "daha erkendir ";
$GLOBALS['strEarlierThanOrEqual'] = "daha erken ya da eşittir";
$GLOBALS['strGreaterThan'] = "daha fazladır";
$GLOBALS['strLessThan'] = "daha azdır";
$GLOBALS['strWeekDays'] = "Haftaiçi";
$GLOBALS['strCity'] = "İl";
$GLOBALS['strDeliveryCappingReset'] = "Görüntüleme sayaçlarını şundan sonra sıfırla:";
$GLOBALS['strDeliveryCappingTotal'] = "toplam";
$GLOBALS['strDeliveryCappingSession'] = "oturum başına";
$GLOBALS['strAddNewAffiliate_Key'] = "Ye<u>n</u>i web sitesi ekle";
$GLOBALS['strAffiliateInvocation'] = "Çağırma Kodu";
$GLOBALS['strTotalAffiliates'] = "Tüm web siteleri";
$GLOBALS['strInactiveAffiliatesHidden'] = "Etkin olmayan web siteleri gizlendi";
$GLOBALS['strShowParentAffiliates'] = "Üst web sitelerini görüntüle ";
$GLOBALS['strHideParentAffiliates'] = "Üst web sitelerini gizle";
$GLOBALS['strMnemonic'] = "Anımsatıcı";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Bu kullanıcının çağırma kodu oluşturmasına izin ver";
$GLOBALS['strAllowAffiliateZoneStats'] = "Bu kullanıcının alan istatistiklerini görüntülemesine izin ver";
$GLOBALS['strAllowAffiliateApprPendConv'] = "Bu kullanıcının yalnızca onaylanmış ya da beklemede duran dönüşümleri görüntülemesine izin ver";
$GLOBALS['strPaymentInformation'] = "Ödeme bilgileri";
$GLOBALS['strAddress'] = "Adres";
$GLOBALS['strPostcode'] = "Posta kodu";
$GLOBALS['strPhone'] = "Telefon";
$GLOBALS['strFax'] = "Belgegeçer";
$GLOBALS['strAccountContact'] = "Hesap aracısı";
$GLOBALS['strPayeeName'] = "Ödeme alıcısının adı";
$GLOBALS['strTaxID'] = "Vergi numarası";
$GLOBALS['strModeOfPayment'] = "Ödeme tipi";
$GLOBALS['strPaymentChequeByPost'] = "Posta ile çek";
$GLOBALS['strCurrency'] = "Para birimi";
$GLOBALS['strCurrencyGBP'] = "GBP";
$GLOBALS['strOtherInformation'] = "Diğer bilgiler";
$GLOBALS['strUniqueUsersMonth'] = "Aylık tekil kullanıcı";
$GLOBALS['strUniqueViewsMonth'] = "Aylık tekil gösterim";
$GLOBALS['strPageRank'] = "Page Rank";
$GLOBALS['strCategory'] = "Kategori";
$GLOBALS['strHelpFile'] = "Yardım dosyası";
$GLOBALS['strAddNewZone_Key'] = "Ye<u>n</u>i alan ekle";
$GLOBALS['strEmailAdZone'] = "Eposta/bülten alanı";
$GLOBALS['strZoneClick'] = "Tıklama izleyen alan";
$GLOBALS['strBannerLinkedAds'] = "Bu alana bağlı bannerlar";
$GLOBALS['strCampaignLinkedAds'] = "Bu alana bağlı kampanyalar";
$GLOBALS['strTotalZones'] = "Tüm alanlar";
$GLOBALS['strCostInfo'] = "Medya maliyeti";
$GLOBALS['strTechnologyCost'] = "Teknoloji maliyeti";
$GLOBALS['strInactiveZonesHidden'] = "etkin olmayan alan(lar) gizlendi";
$GLOBALS['strWarnChangeZoneType'] = "Alan tipini metin ya da eposta'ya çevirmek, bu alan tiplerindeki kısıtlamalardan dolayı bağlantılı tüm banner/kampanyaların bağını keser\n<ul>\n<li>Metin alanları sadece metin reklamlara bağlanabilir</li>\n<li>Eposta alanı kampanyalarında aynı anda sadece bir aktif banner olabilir</li>\n</ul>";
$GLOBALS['strWarnChangeZoneSize'] = "Alan ölçüsünü değiştirmek, yeni ölçüde olmayan bannerların alanla bağını keser ve bağlantılı kampanyalarda yer alan yeni ölçüdeki tüm bannerları alanla bağlantılandırır";
$GLOBALS['strZoneForecasting'] = "Alan Tahmini ayarları";
$GLOBALS['strZoneAppendNoBanner'] = "Banner gösterilemese bile ekle";
$GLOBALS['strZoneAppendType'] = "Ekleme tipi";
$GLOBALS['strZoneAppendHTMLCode'] = "HTML kodu";
$GLOBALS['strZoneAppendZoneSelection'] = "Açılır pencere veya arada";
$GLOBALS['strZoneAppendSelectZone'] = "Bu alan tarafından gösterilen tüm bannerlara aşağıdaki açılır pencere veya ara kodunu ekle";
$GLOBALS['strZoneProbListChain'] = "Seçili alanla bağlantılı bannerlar şu anda aktif değil. <br />Takip edilecek alan zinciri şöyle:";
$GLOBALS['strZoneProbNullPri'] = "Bu alanla bağlantılı aktif banner yok.";
$GLOBALS['strZoneProbListChainLoop'] = "Alan zincirini takip etmek sonsuz bir döngüye yol açabilir. Bu alan için gösterim durduruldu.";
$GLOBALS['strLinkedBanners'] = "Tek tek banner bağla";
$GLOBALS['strCampaignDefaults'] = "Bannerları ekli olduğu kampanyaya göre bağla";
$GLOBALS['strLinkedCategories'] = "Bannerları kategorisine göre bağla";
$GLOBALS['strNoTrackersToLink'] = "Bu kampanyaya bağlanabilecek hiçbir takipçi bulunmamaktadır";
$GLOBALS['strSelectAdvertiser'] = "Reklamveren Seçin";
$GLOBALS['strSelectPlacement'] = "Kampanya Seçin";
$GLOBALS['strSelectAd'] = "Banner Seçin";
$GLOBALS['strStatusPending'] = "Beklemede";
$GLOBALS['strStatusApproved'] = "Onaylandı";
$GLOBALS['strStatusDisapproved'] = "Onaylanmadı";
$GLOBALS['strStatusOnHold'] = "Tutuluyor";
$GLOBALS['strStatusIgnore'] = "Yok say";
$GLOBALS['strConnectionType'] = "Tip";
$GLOBALS['strType'] = "Tip";
$GLOBALS['strConnTypeSale'] = "Satış";
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Kayıt";
$GLOBALS['strShortcutEditStatuses'] = "Durumları düzenle";
$GLOBALS['strShortcutShowStatuses'] = "Durumları göster";
$GLOBALS['strNoTargetingStats'] = "Henüz hiç hedefleme istatistiği bulunmamakta";
$GLOBALS['strNoStatsForPeriod'] = "Henüz %s - %s periyoduna ait istatistik bulunmamakta";
$GLOBALS['strNoTargetingStatsForPeriod'] = "Henüz %s - %s periyoduna ait hedefleme istatistiği bulunmamakta";
$GLOBALS['strPublisherDistribution'] = "Web Sitesi Dağılımı";
$GLOBALS['strCampaignDistribution'] = "Kampanya Dağılımı";
$GLOBALS['strTargetStats'] = "Hedefleme İstatistikleri";
$GLOBALS['strViewBreakdown'] = "Şuna göre görüntüle:";
$GLOBALS['strItemsPerPage'] = "Sayfa başına öğe";
$GLOBALS['strDistributionHistory'] = "Dağılım geçmişi";
$GLOBALS['strShowGraphOfStatistics'] = "İstatistiklerin <u>G</u>rafiğini göster";
$GLOBALS['strExportStatisticsToExcel'] = "İstatistikleri <u>E</u>xcel'e aktar";
$GLOBALS['strGDnotEnabled'] = "Grafikleri görüntüleyebilmek için PHP'de GD'nin etkin olması gerekmektedir. <br/>Lütfen, GD'nin nasıl yükleneceğini de içeren şu sayfaya bakın: <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a>.";
$GLOBALS['strStartDate'] = "Başlama Tarihi";
$GLOBALS['strEndDate'] = "Bitiş Tarihi";
$GLOBALS['strAllAdvertisers'] = "Tüm reklamverenler";
$GLOBALS['strAnonAdvertisers'] = "İsimsiz reklamverenler";
$GLOBALS['strAllPublishers'] = "Tüm web siteleri";
$GLOBALS['strAnonPublishers'] = "İsimsiz web siteleri";
$GLOBALS['strAllAvailZones'] = "Tüm uygun alanlar";
$GLOBALS['strBackToTheList'] = "Rapor listesine geri dön";
$GLOBALS['strLogErrorConversions'] = "[phpAds] Veritabanından dönüşümleri alırken bir hata oluştu.";
$GLOBALS['strErrorDBPlain'] = "Veritabanına erişilirken bir hata oluştu";
$GLOBALS['strErrorDBSerious'] = "Veritabanıyla ilgili ciddi bir problem tespit edildi";
$GLOBALS['strErrorDBNoDataPlain'] = "Veritabanındaki bir problemden dolayı ". MAX_PRODUCT_NAME ." veriyi alamadı veya kaydedemedi";
$GLOBALS['strErrorDBNoDataSerious'] = "Veritabanındaki bir problemden dolayı ". MAX_PRODUCT_NAME ." veriye erişemedi";
$GLOBALS['strErrorDBCorrupt'] = "Veritabanı tablosu muhtemelen bozuk ve onarılması gerekiyor. Bozulmuş tabloların onarımı hakkında daha fazla bilgi için lütfen <i>Yönetici klavuzu</i>'nun <i>Sorun Çözme</i> bölümünü okuyun.";
$GLOBALS['strErrorDBContact'] = "Lütfen bu sunucunun yöneticisiyle iletişime geçin ve problem hakkında bilgilendirin.";
$GLOBALS['strErrorDBSubmitBug'] = "Eğer problem yeniden oluşturulabiliyorsa, bu durum ". MAX_PRODUCT_NAME ." içindeki bir bug'dan kaynaklanıyor olabilir. Lütfen aşağıdaki bilgileri ". MAX_PRODUCT_NAME ." üreticilerine ulaştırın. Beraberinde hatanın oluşmasıyla sonuçlanan işlemlerinizi olabildiğince açık bir şekilde açıklamaya çalışın.";
$GLOBALS['strMaintenanceNotActive'] = "Bakım rutini son 24 saat içinde çalıştırılmadı. \n". MAX_PRODUCT_NAME ." ürününün doğru çalışması için bakım rutininin \n her saat çalışması gerekir. \n\nBakım rutini ayarları hakkında daha fazla bilgi için lütfen \nYönetici kılavuzunu okuyunuz.";
$GLOBALS['strErrorLinkingBanner'] = "Belirtilen nedenle banner bu alana bağlanamadı:";
$GLOBALS['strUnableToLinkBanner'] = "Bu banner bağlanamıyor: _";
$GLOBALS['strErrorEditingCampaign'] = "Kampanya güncellenirken hata:";
$GLOBALS['strUnableToChangeCampaign'] = "Belirtilen nedenle bu değişiklik uygulanamadı:";
$GLOBALS['strDatesConflict'] = "tarih çakışıyor: ";
$GLOBALS['strEmailNoDates'] = "Eposta alanı kampanyaları için başlangıç ve bitiş tarihleri belirtilmelidir";
$GLOBALS['strSirMadam'] = "Bay/Bayan";
$GLOBALS['strMailBannerActivatedSubject'] = "Kampanya aktifleştirildi";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Kampanya pasifleştirildi";
$GLOBALS['strMailBannerActivated'] = "Başlangıç tarihine erişildiği için aşağıdaki kampanyanız aktifleştirildi.";
$GLOBALS['strMailBannerDeactivated'] = "Aşağıda gösterilen kampanyanız pasifleştirildi, çünkü";
$GLOBALS['strNoMoreImpressions'] = "gösterim kalmadı";
$GLOBALS['strNoMoreConversions'] = "satış hakkı kalmadı";
$GLOBALS['strWeightIsNull'] = "ağırlığı sıfıra ayarlı";
$GLOBALS['strImpressionsClicksConversionsLow'] = "Gösterim/Tıklanma/Dönüşüm düşük";
$GLOBALS['strNoConversionLoggedInInterval'] = "Bu rapor süresince dönüşüm kaydedilmedi";
$GLOBALS['strImpendingCampaignExpiry'] = "Kampanya bitişi yakın";
$GLOBALS['strYourCampaign'] = "Kampanyanız";
$GLOBALS['strTheCampiaignBelongingTo'] = "{clientname} reklamverenine ait aşağıdaki kampanya";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{date} tarihinde bitiyor.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "Aşağıda gösterilen {clientname} {limit} değerinden az gösterim hakkına sahip.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "Sonuç olarak kampanya yakında otomatik olarak pasifleştirilecek ve \nbelirtilen bannerlar da beraberinde pasif olacak.";
$GLOBALS['strSourceEdit'] = "Kaynakları Düzenle";
$GLOBALS['strViewPastUpdates'] = "Eski Güncelleme ve Yedekleri Yönet";
$GLOBALS['strAgencyManagement'] = "Hesap Yönetimi";
$GLOBALS['strAgency'] = "Hesap";
$GLOBALS['strAddAgency'] = "Yeni hesap ekle";
$GLOBALS['strAddAgency_Key'] = "Ye<u>n</u>i hesap ekle";
$GLOBALS['strTotalAgencies'] = "Tüm hesaplar";
$GLOBALS['strAgencyProperties'] = "Hesap özellikleri";
$GLOBALS['strNoAgencies'] = "Henüz hiçbir hesap tanımlanmamış";
$GLOBALS['strConfirmDeleteAgency'] = "Bu hesabı silmek istediğinize emin misiniz?";
$GLOBALS['strHideInactiveAgencies'] = "Etkin olmayan hesapları gizle";
$GLOBALS['strInactiveAgenciesHidden'] = "etkin olmayan hesap(lar) gizlendi";
$GLOBALS['strAllowAgencyEditConversions'] = "Bu kullanıcının dönüşümleri düzenlemesine izin ver";
$GLOBALS['strAllowMoreReports'] = "\'Daha fazla Rapor' düğmesine izin ver";
$GLOBALS['strChannel'] = "Hedefleme Kanalı";
$GLOBALS['strChannels'] = "Hedefleme Kanalları";
$GLOBALS['strChannelOverview'] = "Hedefleme Kanallarına Genel Bakış";
$GLOBALS['strChannelManagement'] = "Hedefleme Kanalı Yönetimi";
$GLOBALS['strAddNewChannel'] = "Yeni hedefleme kanalı ekle";
$GLOBALS['strAddNewChannel_Key'] = "Ye<u>n</u>i hedefleme kanalı ekle";
$GLOBALS['strNoChannels'] = "Tanımlanmış hedefleme kanalı yok";
$GLOBALS['strEditChannelLimitations'] = "Hedefleme kanalı kısıtlamalarını düzenle";
$GLOBALS['strChannelProperties'] = "Hedefleme Kanalı özellikleri";
$GLOBALS['strConfirmDeleteChannel'] = "Bu hedefleme kanalını silmek istediğinize emin misiniz?";
$GLOBALS['strVariableName'] = "Değişken Adı";
$GLOBALS['strVariableDataType'] = "Veri Tipi";
$GLOBALS['strVariablePurpose'] = "Amaç";
$GLOBALS['strBasketValue'] = "Sepet değeri";
$GLOBALS['strNumItems'] = "Öğe sayısı";
$GLOBALS['strVariableIsUnique'] = "Mükerrer dönüşümleri birleştir?";
$GLOBALS['strNumber'] = "Sayı";
$GLOBALS['strString'] = "Karakter Dizisi";
$GLOBALS['strTrackFollowingVars'] = "Takip eden değişleni izle";
$GLOBALS['strAddVariable'] = "Değişken Ekle";
$GLOBALS['strNoVarsToTrack'] = "İzlenecek değişken yok";
$GLOBALS['strVariableRejectEmpty'] = "Boş ise reddedilsin mi?";
$GLOBALS['strTrackingSettings'] = "İzleme ayarları";
$GLOBALS['strTrackerType'] = "İzleyici tipi";
$GLOBALS['strTrackerTypeJS'] = "Javascript değişkenlerini izle";
$GLOBALS['strTrackerTypeDefault'] = "Javascript değişkenlerini izle (geriye dönük uyumlu, escape karakterleri gerekir)";
$GLOBALS['strTrackerTypeDOM'] = "HTML öğelerini DOM kullanarak izle";
$GLOBALS['strTrackerTypeCustom'] = "Özel JS kodu";
$GLOBALS['strVariableCode'] = "Javascript izleme kodu";
$GLOBALS['strForgotPassword'] = "Şifrenizi mi unuttunuz?";
$GLOBALS['strPasswordRecovery'] = "Şifre yenileme";
$GLOBALS['strEmailRequired'] = "Eposta alanı gereklidir";
$GLOBALS['strPwdRecEmailNotFound'] = "Eposta adresi bulunamadı";
$GLOBALS['strPwdRecPasswordSaved'] = "Şifre kaydedildi. <a href='index.php'>Giriş</a> adresinden devam edin.";
$GLOBALS['strPwdRecWrongId'] = "Yanlış ID";
$GLOBALS['strPwdRecEnterEmail'] = "Eposta adresinizi girin";
$GLOBALS['strPwdRecEnterPassword'] = "Yeni şifrenizi girin";
$GLOBALS['strPwdRecResetLink'] = "Şifre yenileme bağlantısı";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "%s şifre yenilemesi";
$GLOBALS['strCampaignStatusPaused'] = "Duraklat";
$GLOBALS['strCampaignApprove'] = "Onaylandı";
$GLOBALS['strCampaignPause'] = "Duraklat";
$GLOBALS['strUserProperties'] = "Banner özellikleri";
$GLOBALS['strNoAdminInterface'] = "Servis müsait değil...";
$GLOBALS['strOverallAdvertisers'] = "Reklamcılar";
$GLOBALS['strImpression'] = "Gösterimler";
$GLOBALS['strLinkUserHelpUser'] = "Kullanıcı Adı";
$GLOBALS['strPasswordRepeat'] = "Parola Tekrarı";
$GLOBALS['strCampaignStatusRestarted'] = "Yeniden başlat";
$GLOBALS['strPercentBasketValue'] = "Sepet değeri";
$GLOBALS['strCampaignStatusPending'] = "Beklemede";
$GLOBALS['strCampaignStatusDeleted'] = "Sil";
$GLOBALS['strTrackers'] = "İzleyici";
$GLOBALS['strTrackerCodeSubject'] = "İzleme kodunu ekle";
$GLOBALS['strCampaignStop'] = "Kampanya Geçmişi";
$GLOBALS['strUnableToChangeZone'] = "Belirtilen nedenle bu değişiklik uygulanamadı:";
$GLOBALS['strNumberOfItems'] = "Öğe sayısı";
$GLOBALS['strERPM'] = "CPM";
$GLOBALS['strERPC'] = "CPC";
$GLOBALS['strERPS'] = "CPM";
$GLOBALS['strEIPM'] = "CPM";
$GLOBALS['strEIPC'] = "CPC";
$GLOBALS['strEIPS'] = "CPM";
$GLOBALS['strECPM'] = "CPM";
$GLOBALS['strECPC'] = "CPC";
$GLOBALS['strECPS'] = "CPM";
$GLOBALS['strEPPM'] = "CPM";
$GLOBALS['strEPPC'] = "CPC";
$GLOBALS['strEPPS'] = "CPM";
$GLOBALS['strCheckForUpdates'] = "Güncellemeleri Kontrol Et";
$GLOBALS['strAgencies'] = "Hesap";
$GLOBALS['strModifychannel'] = "Yeni hedefleme kanalı ekle";
$GLOBALS['strAccount'] = "Hesap";
$GLOBALS['strImpressionSR'] = "Gösterimler";
$GLOBALS['strGlobalSettings'] = "Genel Ayarlar";
$GLOBALS['strActions'] = "Eylem";
$GLOBALS['strFinanceCTR'] = "TGO";
$GLOBALS['strNoClientsForBanners'] = "Henüz hiç reklamveren tanımlanmamış. Bir kampanya yaratabilmek için öncelikle <a href='advertiser-edit.php'>yeni bir reklamveren yarat</a>malısınız.";
$GLOBALS['strAdvertiserCampaigns'] = "Reklamverenler ve Kampanyalar";
$GLOBALS['strCampaignStatusInactive'] = "etkin";
$GLOBALS['strCampaignType'] = "Kampanya Adı";
$GLOBALS['strContract'] = "İletişim";
$GLOBALS['strStandardContract'] = "İletişim";
$GLOBALS['strBannerToCampaign'] = "Kampanyanız";
$GLOBALS['strWebsiteZones'] = "Web Siteleri ve Alanlar";
$GLOBALS['strZoneToWebsite'] = "Web sitesi yok";
$GLOBALS['strNoZonesAddWebsite'] = "Henüz tanımlı bir web sitesi yok. Bir alan yaratmak için öncelikle <a href='affiliate-edit.php'>yeni bir web sitesi yarat</a>malısınız.";
$GLOBALS['strERPM_short'] = "CPM";
$GLOBALS['strERPC_short'] = "CPC";
$GLOBALS['strERPS_short'] = "CPM";
$GLOBALS['strEIPM_short'] = "CPM";
$GLOBALS['strEIPC_short'] = "CPC";
$GLOBALS['strEIPS_short'] = "CPM";
$GLOBALS['strECPM_short'] = "CPM";
$GLOBALS['strECPC_short'] = "CPC";
$GLOBALS['strECPS_short'] = "CPM";
$GLOBALS['strEPPM_short'] = "CPM";
$GLOBALS['strEPPC_short'] = "CPC";
$GLOBALS['strEPPS_short'] = "CPM";
$GLOBALS['strChannelToWebsite'] = "Web sitesi yok";
$GLOBALS['strConfirmDeleteClients'] = "Bu reklamvereni silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Bu kampanyayı silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmDeleteTrackers'] = "Bu izleyiciyi silmek istediğinize emin misiniz?";
$GLOBALS['strNoBannersAddAdvertiser'] = "Henüz tanımlı bir web sitesi yok. Bir alan yaratmak için öncelikle <a href='affiliate-edit.php'>yeni bir web sitesi yarat</a>malısınız.";
$GLOBALS['strConfirmDeleteBanners'] = "Bu bannerı silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Bu web sitesini silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmDeleteZones'] = "Bu alanı silmek istediğinize emin misiniz?";
$GLOBALS['strActualImpressions'] = "Gösterimler";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strClicks_short'] = "Tıklamalar";
$GLOBALS['strCTR_short'] = "TGO";
$GLOBALS['strNoChannelsAddWebsite'] = "Henüz tanımlı bir web sitesi yok. Bir alan yaratmak için öncelikle <a href='affiliate-edit.php'>yeni bir web sitesi yarat</a>malısınız.";
$GLOBALS['strConfirmDeleteChannels'] = "Bu hedefleme kanalını silmek istediğinize emin misiniz?";
$GLOBALS['strSite'] = "Boyut";
$GLOBALS['strHiddenWebsite'] = "Web sitesi";
$GLOBALS['strYouHaveNoCampaigns'] = "Reklamverenler ve Kampanyalar";
$GLOBALS['strSyncSettings'] = "Senkronizasyon Ayarları";
$GLOBALS['strEnableCookies'] = "". MAX_PRODUCT_NAME ." kullanmaya başlamadan önce tarayıcı (browser) ayarlarınızı çerezleri (cookie) kabul edecek şekilde değiştirmelisiniz.";
$GLOBALS['strHideInactiveOverview'] = "Etkin olmayan öğeleri tüm genel bakış sayfalarında gizle";
$GLOBALS['strHiddenPublisher'] = "Web sitesi";
$GLOBALS['strDefaultConversionRules'] = "Varsayılan dönüştürme kuralları";
$GLOBALS['strClickWindow'] = "Tıklama penceresi";
$GLOBALS['strViewWindow'] = "Pencereyi görüntüle";
$GLOBALS['strAppendNewTag'] = "Yeni etiket ekle";
$GLOBALS['strMoveUp'] = "Yukarı çıkar";
$GLOBALS['strMoveDown'] = "Aşağı indir";
$GLOBALS['strRestart'] = "Yeniden başlat";
$GLOBALS['strRegexMatch'] = "DüzgünDeyim (Regular Expression) eşleşmesi";
$GLOBALS['strRegexNotMatch'] = "DüzgünDeyim (Regular Expression) eşleşmemesi";
$GLOBALS['strIsAnyOf'] = "Herhangi biri";
$GLOBALS['strIsNotAnyOf'] = "Herhangi biri değil";
$GLOBALS['strCappingBanner']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingBanner']['limit'] = "Banner gösterimlerini şununla sınırla:";
$GLOBALS['strCappingCampaign']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingCampaign']['limit'] = "Kampanya gösterimlerini şununla sınırla:";
$GLOBALS['strCappingZone']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingZone']['limit'] = "Alan gösterimlerini şununla sınırla:";
$GLOBALS['strPickCategory'] = "\- kategori seçiniz -";
$GLOBALS['strPickCountry'] = "\- ülke seçiniz -";
$GLOBALS['strPickLanguage'] = "\- dil seçiniz -";
$GLOBALS['strKeywordStatistics'] = "Anahtar Kelime İstatistikleri";
$GLOBALS['strNoWebsites'] = "Web sitesi yok";
$GLOBALS['strSomeWebsites'] = "Bazı web siteleri";
$GLOBALS['strVariableHiddenTo'] = "Değişken şuna gizlendi:";
$GLOBALS['strHide'] = "Gizle:";
$GLOBALS['strShow'] = "Göster:";
$GLOBALS['strNewWindow'] = "Pencereyi görüntüle";
$GLOBALS['strClick-ThroughRatio'] = "Tıklama / Görüntülenme Oranı";
$GLOBALS['strImpressionSRShort'] = "Gösterimler";
$GLOBALS['strClicksShort'] = "Tıklanma";
$GLOBALS['strImpressionsShort'] = "Gösterimler";
$GLOBALS['strVariable'] = "Değişkenler";
$GLOBALS['strPreference'] = "Ayarlar";
$GLOBALS['strDeliveryLimitation'] = "Teslimat Sınırlamaları";
$GLOBALS['str_ID'] = "ID";
$GLOBALS['str_Requests'] = "İstekler";
$GLOBALS['str_Impressions'] = "Gösterimler";
$GLOBALS['str_Clicks'] = "Tıklamalar";
$GLOBALS['str_CTR'] = "TGO";
$GLOBALS['str_BasketValue'] = "Sepet değeri";
$GLOBALS['str_TechnologyCost'] = "Teknoloji maliyeti";
?>