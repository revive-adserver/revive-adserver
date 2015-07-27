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

// Set text direction and characterset

$GLOBALS['phpAds_DecimalPoint'] = ".";
$GLOBALS['phpAds_ThousandsSeperator'] = ",";

// Date & time configuration
$GLOBALS['date_format'] = "%m/%d/%Y";
$GLOBALS['time_format'] = "%H:%i:%S";
$GLOBALS['minute_format'] = "%H:%M";
$GLOBALS['month_format'] = "%m/%Y";
$GLOBALS['day_format'] = "%m/%d";
$GLOBALS['week_format'] = "%W/%Y";
$GLOBALS['weekiso_format'] = "%V/%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "Ana Sayfa";
$GLOBALS['strHelp'] = "Yardım";
$GLOBALS['strStartOver'] = "Baştan başla";
$GLOBALS['strShortcuts'] = "Kısayollar";
$GLOBALS['strActions'] = "Eylem";
$GLOBALS['strAndXMore'] = "ve %s daha fazla";
$GLOBALS['strAdminstration'] = "Envanter";
$GLOBALS['strMaintenance'] = "Bakım";
$GLOBALS['strProbability'] = "Olasılık";
$GLOBALS['strInvocationcode'] = "Çağırma kodu";
$GLOBALS['strBasicInformation'] = "Temel Bilgiler";
$GLOBALS['strAppendTrackerCode'] = "İzleme kodunu ekle";
$GLOBALS['strOverview'] = "Genel Görünüm";
$GLOBALS['strSearch'] = "Arama";
$GLOBALS['strDetails'] = "Ayrıntılar";
$GLOBALS['strUpdateSettings'] = "Ayarları Güncelle";
$GLOBALS['strCheckForUpdates'] = "Güncellemeleri Kontrol Et";
$GLOBALS['strCompact'] = "Yoğunlaştırılmış";
$GLOBALS['strUser'] = "Kullanıcı";
$GLOBALS['strDuplicate'] = "Çoğalt";
$GLOBALS['strCopyOf'] = "Kopyası";
$GLOBALS['strMoveTo'] = "Taşı";
$GLOBALS['strDelete'] = "Sil";
$GLOBALS['strActivate'] = "Etkinleştir";
$GLOBALS['strConvert'] = "Dönüştür";
$GLOBALS['strRefresh'] = "Yenile";
$GLOBALS['strSaveChanges'] = "Değişiklikleri Kaydet";
$GLOBALS['strUp'] = "Yukarı";
$GLOBALS['strDown'] = "Aşağı";
$GLOBALS['strSave'] = "Kaydet";
$GLOBALS['strCancel'] = "İptal";
$GLOBALS['strPrevious'] = "Önceki";
$GLOBALS['strNext'] = "Sonraki";
$GLOBALS['strYes'] = "Evet";
$GLOBALS['strNo'] = "Hayır";
$GLOBALS['strNone'] = "Hiçbiri";
$GLOBALS['strCustom'] = "Özel";
$GLOBALS['strDefault'] = "Varsayılan";
$GLOBALS['strUnknown'] = "Bilinmeyen";
$GLOBALS['strUnlimited'] = "Sınırsız";
$GLOBALS['strUntitled'] = "Başlıksız";
$GLOBALS['strAverage'] = "Ortalama";
$GLOBALS['strOverall'] = "Tüm";
$GLOBALS['strTotal'] = "Toplam";
$GLOBALS['strFrom'] = "-den/-dan";
$GLOBALS['strTo'] = "-e/-a";
$GLOBALS['strLinkedTo'] = "bağlanmış";
$GLOBALS['strDaysLeft'] = "Kalan gün";
$GLOBALS['strCheckAllNone'] = "Tümünü / Hiçbirini Seç";
$GLOBALS['strKiloByte'] = "KB";
$GLOBALS['strExpandAll'] = "Hepsini Aç";
$GLOBALS['strCollapseAll'] = "Hepsini Kapat";
$GLOBALS['strShowAll'] = "Hepsini Göster";
$GLOBALS['strNoAdminInterface'] = "Servis müsait değil...";
$GLOBALS['strFieldContainsErrors'] = "Aşağıdaki alanlar hata içeriyor:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Devam etmeden önce ";
$GLOBALS['strFieldFixBeforeContinue2'] = "bu hataları düzeltmeniz gerekiyor.";
$GLOBALS['strMiscellaneous'] = "Çeşitli";
$GLOBALS['strCollectedAllStats'] = "Tüm istatistikler";
$GLOBALS['strCollectedToday'] = "Bugün";
$GLOBALS['strCollectedYesterday'] = "Dün";
$GLOBALS['strCollectedThisWeek'] = "Bu hafta";
$GLOBALS['strCollectedLastWeek'] = "Geçen hafta";
$GLOBALS['strCollectedThisMonth'] = "Bu ay";
$GLOBALS['strCollectedLastMonth'] = "Geçen ay";
$GLOBALS['strCollectedLast7Days'] = "Son 7 gün";
$GLOBALS['strCollectedSpecificDates'] = "Belirli tarihler";
$GLOBALS['strNotice'] = "Uyarı";

// Dashboard
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "kod";

// Priority
$GLOBALS['strPriority'] = "Öncelik";
$GLOBALS['strPriorityLevel'] = "Öncelik düzeyi";
$GLOBALS['strECPMAds'] = "eBGBM Kampanya Reklamı";
$GLOBALS['strLowAds'] = "Boşta Kalan Gösterim Kampanyası";
$GLOBALS['strLimitations'] = "Kısıtlamalar";
$GLOBALS['strNoLimitations'] = "Kısıtlama yok";
$GLOBALS['strCapping'] = "Başlıklamak";

// Properties
$GLOBALS['strName'] = "İsim";
$GLOBALS['strSize'] = "Boyut";
$GLOBALS['strWidth'] = "Genişlik";
$GLOBALS['strHeight'] = "Yükseklik";
$GLOBALS['strTarget'] = "Hedef";
$GLOBALS['strLanguage'] = "Dil";
$GLOBALS['strDescription'] = "Tanımlama";
$GLOBALS['strVariables'] = "Değişkenler";
$GLOBALS['strID'] = "ID [Sıra No]";
$GLOBALS['strComments'] = "Yorumlar";

// User access
$GLOBALS['strUserNotLinkedWithAccount'] = "Bu kullanıcının ilişkili bir hesabı bulunmuyor.";
$GLOBALS['strCantDeleteOneAdminUser'] = "En az bir Yönetici hesabı olması gerektiğinden kullanıcıyı silemezsiniz.";
$GLOBALS['strLinkUserHelpUser'] = "Kullanıcı Adı";

// Login & Permissions
$GLOBALS['strUserProperties'] = "Banner özellikleri";
$GLOBALS['strAuthentification'] = "Kimlik Doğrulama";
$GLOBALS['strWelcomeTo'] = "Hoşgeldiniz ";
$GLOBALS['strEnterUsername'] = "Giriş yapabilmek için kullanıcı adınızı ve parolanızı giriniz";
$GLOBALS['strEnterBoth'] = "Lütfen kullanıcı adınızı ve parolanızı birlikte giriniz";
$GLOBALS['strLogin'] = "Giriş";
$GLOBALS['strLogout'] = "Çıkış";
$GLOBALS['strUsername'] = "Kullanıcı Adı";
$GLOBALS['strPassword'] = "Parola";
$GLOBALS['strPasswordRepeat'] = "Parola Tekrarı";
$GLOBALS['strAccessDenied'] = "Erişim reddedildi";
$GLOBALS['strUsernameOrPasswordWrong'] = "Girmiş olduğunuz kullanıcı adı ve/veya parola geçerli değil. Lütfen tekrar deneyiniz.";
$GLOBALS['strPasswordWrong'] = "Parola geçersiz";
$GLOBALS['strNotAdmin'] = "Yeterli önceliğiniz yok";
$GLOBALS['strDuplicateClientName'] = "Girdiğiniz kullanıcı adı başkası tarafından kullanılıyor. Lütfen başka bir kullanıcı adıyla yeniden deneyiniz.";

// General advertising
$GLOBALS['strRequests'] = "İstekler";
$GLOBALS['strImpressions'] = "Gösterimler";
$GLOBALS['strClicks'] = "Tıklamalar";
$GLOBALS['strConversions'] = "Dönüşümler";
$GLOBALS['strCTRShort'] = "TGO";
$GLOBALS['strCNVRShort'] = "Dn";
$GLOBALS['strCTR'] = "TGO";
$GLOBALS['strTotalClicks'] = "Toplam Tıklama";
$GLOBALS['strTotalConversions'] = "Toplam Dönüşüm";
$GLOBALS['strDateTime'] = "Tarih Saat";
$GLOBALS['strTrackerID'] = "İzleme ID";
$GLOBALS['strTrackerName'] = "İzleme Adı";
$GLOBALS['strBanners'] = "Bannerlar";
$GLOBALS['strCampaigns'] = "Kampanya";
$GLOBALS['strCampaignID'] = "Kampanya ID";
$GLOBALS['strCampaignName'] = "Kampanya Adı";
$GLOBALS['strCountry'] = "Ülke";
$GLOBALS['strStatsAction'] = "Eylem";
$GLOBALS['strWindowDelay'] = "Pencere gecikmesi";
$GLOBALS['strStatsVariables'] = "Değişkenler";

// Finance
$GLOBALS['strFinanceMT'] = "Aylık Kiralama";
$GLOBALS['strFinanceCTR'] = "TGO";

// Time and date related
$GLOBALS['strDate'] = "Tarih";
$GLOBALS['strDay'] = "Gün";
$GLOBALS['strDays'] = "Günler";
$GLOBALS['strWeek'] = "Hafta";
$GLOBALS['strWeeks'] = "Haftalar";
$GLOBALS['strSingleMonth'] = "Ay";
$GLOBALS['strMonths'] = "Aylar";
$GLOBALS['strDayOfWeek'] = "Haftanın günü";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = array();
}

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = array();
}

$GLOBALS['strHour'] = "Saat";
$GLOBALS['strSeconds'] = "saniye";
$GLOBALS['strMinutes'] = "dakika";
$GLOBALS['strHours'] = "saat";

// Advertiser
$GLOBALS['strClient'] = "Reklamveren";
$GLOBALS['strClients'] = "Reklamverenler";
$GLOBALS['strClientsAndCampaigns'] = "Reklamverenler ve Kampanyalar";
$GLOBALS['strAddClient'] = "Yeni reklamveren ekle";
$GLOBALS['strClientProperties'] = "Reklamveren Bilgileri";
$GLOBALS['strClientHistory'] = "Reklamveren Geçmişi";
$GLOBALS['strNoClients'] = "Henüz hiç reklamveren tanımlanmamış. Bir kampanya yaratabilmek için öncelikle <a href='advertiser-edit.php'>yeni bir reklamveren yarat</a>malısınız.";
$GLOBALS['strConfirmDeleteClient'] = "Bu reklamvereni silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmDeleteClients'] = "Bu reklamvereni silmek istediğinize emin misiniz?";
$GLOBALS['strInactiveAdvertisersHidden'] = "Etkin olmayan reklamveren(ler) gizlendi";
$GLOBALS['strAdvertiserCampaigns'] = "Reklamverenler ve Kampanyalar";

// Advertisers properties
$GLOBALS['strContact'] = "İletişim";
$GLOBALS['strEMail'] = "Eposta";
$GLOBALS['strSendAdvertisingReport'] = "Kampanya teslimat raporlarını epostayla gönder";
$GLOBALS['strNoDaysBetweenReports'] = "Teslimat raporları arasındaki gün sayısı";
$GLOBALS['strSendDeactivationWarning'] = "Bir kampanya otomatik olarak etkin olduğunda ya da etkinliği kalktığında eposta gönder";
$GLOBALS['strAllowClientModifyBanner'] = "Bu kullanıcı kendi bannerlarını düzenleyebilsin";
$GLOBALS['strAllowClientDisableBanner'] = "Bu kullanıcı kendi bannerlarının etkinliğini kaldırabilsin";
$GLOBALS['strAllowClientActivateBanner'] = "Bu kullanıcı kendi bannerlarını etkinleştirebilsin";

// Campaign
$GLOBALS['strCampaign'] = "Kampanya";
$GLOBALS['strCampaigns'] = "Kampanya";
$GLOBALS['strAddCampaign'] = "Yeni kampanya ekle";
$GLOBALS['strAddCampaign_Key'] = "Ye<u>n</u>i kampanya ekle";
$GLOBALS['strLinkedCampaigns'] = "Bağlı kampanyalar";
$GLOBALS['strCampaignProperties'] = "Kampanya Bilgileri";
$GLOBALS['strCampaignOverview'] = "Kampanya Özeti";
$GLOBALS['strCampaignHistory'] = "Kampanya Geçmişi";
$GLOBALS['strNoCampaigns'] = "Henüz tanımlanmış Kampanya yok";
$GLOBALS['strConfirmDeleteCampaign'] = "Bu kampanyayı silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Bu kampanyayı silmek istediğinize emin misiniz?";
$GLOBALS['strShowParentAdvertisers'] = "Üst reklamverenleri göster";
$GLOBALS['strHideParentAdvertisers'] = "Üst reklamverenleri gizle";
$GLOBALS['strHideInactiveCampaigns'] = "Etkin olmayan kampanyaları gizle";
$GLOBALS['strInactiveCampaignsHidden'] = "Etkin olmayan kampanya(lar) gizlendi";
$GLOBALS['strPriorityInformation'] = "Diğer kampanyalara göre öncelik";
$GLOBALS['strHiddenCampaign'] = "Kampanya";
$GLOBALS['strHiddenAd'] = "Reklam";
$GLOBALS['strHiddenAdvertiser'] = "Reklamveren";
$GLOBALS['strHiddenTracker'] = "İzleyici";
$GLOBALS['strHiddenWebsite'] = "Web sitesi";
$GLOBALS['strHiddenZone'] = "Alan";
$GLOBALS['strCompanionPositioning'] = "Klavuz yerleştirme";
$GLOBALS['strSelectUnselectAll'] = "Tümünü Seç / Seçme";

// Campaign-zone linking page


// Campaign properties
$GLOBALS['strDontExpire'] = "Bu kampanyayı belirli bir tarihte bitirme";
$GLOBALS['strActivateNow'] = "Bu kampanyayı hemen aktif et";
$GLOBALS['strLow'] = "Düşük";
$GLOBALS['strHigh'] = "Yüksek";
$GLOBALS['strExpirationDate'] = "Bitiş Tarihi";
$GLOBALS['strExpirationDateComment'] = "Kampanya bu günün sonunda bitecek";
$GLOBALS['strActivationDate'] = "Başlama Tarihi";
$GLOBALS['strActivationDateComment'] = "Kampanya bu tarihte başlayacak";
$GLOBALS['strImpressionsRemaining'] = "Kalan Gösterimler";
$GLOBALS['strClicksRemaining'] = "Kalan Tıklamalar";
$GLOBALS['strConversionsRemaining'] = "Kalan Dönüşümler";
$GLOBALS['strImpressionsBooked'] = "Ayırtılmış Gösterimler";
$GLOBALS['strClicksBooked'] = "Ayırtılmış Tıklamalar";
$GLOBALS['strConversionsBooked'] = "Ayırtılmış Dönüşümler";
$GLOBALS['strCampaignWeight'] = "Kampanya Ağırlığı";
$GLOBALS['strAnonymous'] = "Bu kampanyanın reklamverenini ve web sitesini gizle ";
$GLOBALS['strTargetPerDay'] = "günlük.";
$GLOBALS['strCampaignStatusPending'] = "Beklemede";
$GLOBALS['strCampaignStatusInactive'] = "etkin";
$GLOBALS['strCampaignStatusPaused'] = "Duraklat";
$GLOBALS['strCampaignStatusRestarted'] = "Yeniden başlat";
$GLOBALS['strCampaignStatusDeleted'] = "Sil";
$GLOBALS['strCampaignType'] = "Kampanya Adı";
$GLOBALS['strType'] = "Tip";
$GLOBALS['strContract'] = "İletişim";
$GLOBALS['strStandardContract'] = "İletişim";

// Tracker
$GLOBALS['strTracker'] = "İzleyici";
$GLOBALS['strTrackers'] = "İzleyici";
$GLOBALS['strAddTracker'] = "Yeni bir izleyici ekle";
$GLOBALS['strConfirmDeleteTrackers'] = "Bu izleyiciyi silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmDeleteTracker'] = "Bu izleyiciyi silmek istediğinize emin misiniz?";
$GLOBALS['strTrackerProperties'] = "İzleyici Özellikleri";
$GLOBALS['strDefaultStatus'] = "Varsayılan Durum";
$GLOBALS['strStatus'] = "Durum";
$GLOBALS['strLinkedTrackers'] = "Bağlı İzleyiciler";
$GLOBALS['strConversionWindow'] = "Dönüştürme penceresi";
$GLOBALS['strUniqueWindow'] = "Tekil pencere";
$GLOBALS['strClick'] = "Tıkla";
$GLOBALS['strView'] = "Görüntüle";
$GLOBALS['strConversionType'] = "Dönüşüm tipi";
$GLOBALS['strLinkCampaignsByDefault'] = "Yeni yaratılan kampanyaları doğrudan bağla";

// Banners (General)
$GLOBALS['strBanners'] = "Bannerlar";
$GLOBALS['strAddBanner'] = "Yeni banner ekle";
$GLOBALS['strAddBanner_Key'] = "Ye<u>n</u>i banner ekle";
$GLOBALS['strBannerToCampaign'] = "Kampanyanız";
$GLOBALS['strShowBanner'] = "Banneri göster";
$GLOBALS['strBannerProperties'] = "Banner Özellikleri";
$GLOBALS['strBannerHistory'] = "Banner Geçmişi";
$GLOBALS['strNoBanners'] = "Tanımlanmış Banner Yok";
$GLOBALS['strNoBannersAddAdvertiser'] = "Henüz tanımlı bir web sitesi yok. Bir alan yaratmak için öncelikle <a href='affiliate-edit.php'>yeni bir web sitesi yarat</a>malısınız.";
$GLOBALS['strConfirmDeleteBanner'] = "Bu bannerı silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmDeleteBanners'] = "Bu bannerı silmek istediğinize emin misiniz?";
$GLOBALS['strShowParentCampaigns'] = "Üst kampanyaları göster";
$GLOBALS['strHideParentCampaigns'] = "Üst kampanyaları gizle";
$GLOBALS['strHideInactiveBanners'] = "Etkin olmayan bannerları gizle";
$GLOBALS['strInactiveBannersHidden'] = "Etkin olmayan banner(lar) gizlendi";
$GLOBALS['strWarningMissing'] = "Uyarı, muhtemelen kayıp";
$GLOBALS['strWarningMissingClosing'] = "kapatma tag'i  \">\"";
$GLOBALS['strWarningMissingOpening'] = "açma tag'i \"<\"";
$GLOBALS['strSubmitAnyway'] = "Her şeye rağmen Gönder";

// Banner Preferences

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Lütfen banner tipini seçiniz";
$GLOBALS['strMySQLBanner'] = "Yerel banner (SQL)";
$GLOBALS['strWebBanner'] = "Yerel banner (Webserver)";
$GLOBALS['strURLBanner'] = "Harici banner";
$GLOBALS['strHTMLBanner'] = "HTML banner";
$GLOBALS['strTextBanner'] = "Yazı Olarak Reklam";
$GLOBALS['strUploadOrKeep'] = "Varolan resmi korumak mı, <br />yoksa yeni bir tane mi <br />yüklemek istersiniz?";
$GLOBALS['strNewBannerFile'] = "Bu banner için kullanacağınız <br/>resmi seçiniz<br /><br />";
$GLOBALS['strNewBannerFileAlt'] = "Tarayıcının zengin medya <br />desteklememesi halinde <br /> kullanmak istediğiniz yedek resmi seçiniz <br /><br />";
$GLOBALS['strNewBannerURL'] = "Resim URL (http:// dahil yazın)";
$GLOBALS['strURL'] = "Hedef URL (http:// dahil yazın)";
$GLOBALS['strKeyword'] = "Anahtar Kelimeler";
$GLOBALS['strTextBelow'] = "Resim altına gelen yazı";
$GLOBALS['strWeight'] = "Ağırlığı";
$GLOBALS['strAlt'] = "Alt(ernatif) yazı";
$GLOBALS['strStatusText'] = "Durum yazısı";
$GLOBALS['strBannerWeight'] = "Banner ağırlığı";
$GLOBALS['strAdserverTypeGeneric'] = "Jenerik HTML banner";
$GLOBALS['strGenericOutputAdServer'] = "Jenerik";
$GLOBALS['strSwfTransparency'] = "Şeffaf zemine izin ver";

// Banner (advanced)

// Banner (swf)
$GLOBALS['strCheckSWF'] = "Flash dosyaları içerisindeki sabit URL bağlantıları denetle";
$GLOBALS['strConvertSWFLinks'] = "Flash linklerini dönüştür";
$GLOBALS['strHardcodedLinks'] = "Elle girilmiş, sabit bağlantılar";
$GLOBALS['strCompressSWF'] = "Daha hızlı yüklenmesi için SWF dosyasını sıkıştır (Flash 6 player gerekli)";
$GLOBALS['strOverwriteSource'] = "Kaynak parametresinin üzerine yaz";

// Display limitations
$GLOBALS['strModifyBannerAcl'] = "Teslimat Seçenekleri";
$GLOBALS['strACL'] = "Teslimat";
$GLOBALS['strACLAdd'] = "Yeni Sınırlama Ekle";
$GLOBALS['strNoLimitations'] = "Kısıtlama yok";
$GLOBALS['strApplyLimitationsTo'] = "Kısıtlamaları şunun için uygula:";
$GLOBALS['strRemoveAllLimitations'] = "Tüm kısıtlamaları kaldır";
$GLOBALS['strEqualTo'] = "eşittir";
$GLOBALS['strDifferentFrom'] = "farklıdır";
$GLOBALS['strGreaterThan'] = "daha fazladır";
$GLOBALS['strLessThan'] = "daha azdır";
$GLOBALS['strAND'] = "VE";                          // logical operator
$GLOBALS['strOR'] = "VEYA";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Bu bannerı yalnızca şu durumda göster:";
$GLOBALS['strWeekDays'] = "Haftaiçi";
$GLOBALS['strSource'] = "Kaynak";
$GLOBALS['strDeliveryLimitations'] = "Teslimat Kısıtlamaları";

$GLOBALS['strDeliveryCappingReset'] = "Görüntüleme sayaçlarını şundan sonra sıfırla:";
$GLOBALS['strDeliveryCappingTotal'] = "toplam";
$GLOBALS['strDeliveryCappingSession'] = "oturum başına";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['limit'] = "Banner gösterimlerini şununla sınırla:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['limit'] = "Kampanya gösterimlerini şununla sınırla:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['limit'] = "Alan gösterimlerini şununla sınırla:";

// Website
$GLOBALS['strAffiliate'] = "Web sitesi";
$GLOBALS['strAffiliates'] = "Web Siteleri ";
$GLOBALS['strAffiliatesAndZones'] = "Web Siteleri ve Alanlar";
$GLOBALS['strAddNewAffiliate'] = "Yeni web sitesi ekle";
$GLOBALS['strAffiliateProperties'] = "Web Sitesi Özellikleri";
$GLOBALS['strAffiliateHistory'] = "Web Sitesi Geçmişi";
$GLOBALS['strNoAffiliates'] = "Henüz tanımlı bir web sitesi yok. Bir alan yaratmak için öncelikle <a href='affiliate-edit.php'>yeni bir web sitesi yarat</a>malısınız.";
$GLOBALS['strConfirmDeleteAffiliate'] = "Bu web sitesini silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Bu web sitesini silmek istediğinize emin misiniz?";
$GLOBALS['strInactiveAffiliatesHidden'] = "Etkin olmayan web siteleri gizlendi";
$GLOBALS['strShowParentAffiliates'] = "Üst web sitelerini görüntüle ";
$GLOBALS['strHideParentAffiliates'] = "Üst web sitelerini gizle";

// Website (properties)
$GLOBALS['strWebsite'] = "Web sitesi";
$GLOBALS['strAllowAffiliateModifyZones'] = "Bu kullanıcının kendi alanlarını düzenlemesine izin ver";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Bu kullanıcının kendi alanlarına banner bağlamasına izin ver";
$GLOBALS['strAllowAffiliateAddZone'] = "Bu kullanıcının yeni alanlar tanımlamasına izin ver";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Bu kullanıcının varolan alanları silmesine izin ver";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Bu kullanıcının çağırma kodu oluşturmasına izin ver";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "Posta kodu";
$GLOBALS['strCountry'] = "Ülke";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Web Siteleri ve Alanlar";

// Zone
$GLOBALS['strZone'] = "Alan";
$GLOBALS['strZones'] = "Alanlar";
$GLOBALS['strAddNewZone'] = "Yeni alan ekle";
$GLOBALS['strAddNewZone_Key'] = "Ye<u>n</u>i alan ekle";
$GLOBALS['strZoneToWebsite'] = "Web sitesi yok";
$GLOBALS['strLinkedZones'] = "Bağlı alanlar";
$GLOBALS['strZoneProperties'] = "Alan Özellikleri";
$GLOBALS['strZoneHistory'] = "Alan Geçmişi";
$GLOBALS['strNoZones'] = "Henüz hiçbir alan tanımlanmamış";
$GLOBALS['strNoZonesAddWebsite'] = "Henüz tanımlı bir web sitesi yok. Bir alan yaratmak için öncelikle <a href='affiliate-edit.php'>yeni bir web sitesi yarat</a>malısınız.";
$GLOBALS['strConfirmDeleteZone'] = "Bu alanı silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmDeleteZones'] = "Bu alanı silmek istediğinize emin misiniz?";
$GLOBALS['strZoneType'] = "Alan tipi";
$GLOBALS['strBannerButtonRectangle'] = "Banner, Düğme veya Dikdörtgen";
$GLOBALS['strInterstitial'] = "Sayfa arası reklamı \"veya\" Yüzen reklam";
$GLOBALS['strPopup'] = "Açılır pencere (popup) reklam";
$GLOBALS['strTextAdZone'] = "Metin reklam";
$GLOBALS['strEmailAdZone'] = "Eposta/bülten alanı";
$GLOBALS['strShowMatchingBanners'] = "Eşleşen bannerları göster";
$GLOBALS['strHideMatchingBanners'] = "Eşleşen bannerları gizle";
$GLOBALS['strBannerLinkedAds'] = "Bu alana bağlı bannerlar";
$GLOBALS['strCampaignLinkedAds'] = "Bu alana bağlı kampanyalar";
$GLOBALS['strInactiveZonesHidden'] = "etkin olmayan alan(lar) gizlendi";
$GLOBALS['strWarnChangeZoneType'] = "Alan tipini metin ya da eposta'ya çevirmek, bu alan tiplerindeki kısıtlamalardan dolayı bağlantılı tüm banner/kampanyaların bağını keser
<ul>
<li>Metin alanları sadece metin reklamlara bağlanabilir</li>
<li>Eposta alanı kampanyalarında aynı anda sadece bir aktif banner olabilir</li>
</ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Alan ölçüsünü değiştirmek, yeni ölçüde olmayan bannerların alanla bağını keser ve bağlantılı kampanyalarda yer alan yeni ölçüdeki tüm bannerları alanla bağlantılandırır';


// Advanced zone settings
$GLOBALS['strAdvanced'] = "Gelişmiş";
$GLOBALS['strChainSettings'] = "Zincir ayarları";
$GLOBALS['strZoneNoDelivery'] = "Bu alana ait hiçbir banner <br/>tanımlanmamışsa şunu dene...";
$GLOBALS['strZoneStopDelivery'] = "Gösterimi durdur ve banner gösterme";
$GLOBALS['strZoneOtherZone'] = "Yerine seçilen alanı göster";
$GLOBALS['strZoneAppend'] = "Bu alanda gösterilen bannerlara her zaman aşağıdaki HTML kodunu ekle";
$GLOBALS['strAppendSettings'] = "Başına ve sonuna ekleme ayarları";
$GLOBALS['strZonePrependHTML'] = "Bu alanda gösterilen bannerların başına her zaman aşağıdaki HTML kodunu ekle";
$GLOBALS['strZoneAppendNoBanner'] = "Banner gösterilemese bile ekle";
$GLOBALS['strZoneAppendHTMLCode'] = "HTML kodu";
$GLOBALS['strZoneAppendZoneSelection'] = "Açılır pencere veya arada";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "Seçili alanla bağlantılı bannerlar şu anda aktif değil. <br />Takip edilecek alan zinciri şöyle:";
$GLOBALS['strZoneProbNullPri'] = "Bu alanla bağlantılı aktif banner yok.";
$GLOBALS['strZoneProbListChainLoop'] = "Alan zincirini takip etmek sonsuz bir döngüye yol açabilir. Bu alan için gösterim durduruldu.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Lütfen bu alana neyin bağlanacağını seçin";
$GLOBALS['strLinkedBanners'] = "Tek tek banner bağla";
$GLOBALS['strCampaignDefaults'] = "Bannerları ekli olduğu kampanyaya göre bağla";
$GLOBALS['strLinkedCategories'] = "Bannerları kategorisine göre bağla";
$GLOBALS['strRawQueryString'] = "Anahtar Kelime";
$GLOBALS['strIncludedBanners'] = "Bağlantılı bannerlar";
$GLOBALS['strMatchingBanners'] = "{count} uygun banner";
$GLOBALS['strNoCampaignsToLink'] = "Bu alana bağlanabilecek hiçbir kampanya bulunmamaktadır";
$GLOBALS['strNoTrackersToLink'] = "Bu kampanyaya bağlanabilecek hiçbir takipçi bulunmamaktadır";
$GLOBALS['strNoZonesToLinkToCampaign'] = "Bu kampanyanın bağlanabileceği alan bulunmamaktadır";
$GLOBALS['strSelectBannerToLink'] = "Bu alana bağlamak istediğiniz bannerı seçin:";
$GLOBALS['strSelectCampaignToLink'] = "Bu alana bağlamak istediğiniz kampanyayı seçin:";
$GLOBALS['strSelectAdvertiser'] = "Reklamveren Seçin";
$GLOBALS['strSelectPlacement'] = "Kampanya Seçin";
$GLOBALS['strSelectAd'] = "Banner Seçin";
$GLOBALS['strConnectionType'] = "Tip";
$GLOBALS['strStatusPending'] = "Beklemede";
$GLOBALS['strStatusDuplicate'] = "Çoğalt";
$GLOBALS['strConnectionType'] = "Tip";
$GLOBALS['strShortcutEditStatuses'] = "Durumları düzenle";
$GLOBALS['strShortcutShowStatuses'] = "Durumları göster";

// Statistics
$GLOBALS['strStats'] = "İstatistikler";
$GLOBALS['strNoStats'] = "Henüz istatistik bulunmamakta";
$GLOBALS['strNoStatsForPeriod'] = "Henüz %s - %s periyoduna ait istatistik bulunmamakta";
$GLOBALS['strGlobalHistory'] = "Genel Geçmiş";
$GLOBALS['strDailyHistory'] = "Günlük Geçmiş";
$GLOBALS['strDailyStats'] = "Günlük istatistikler";
$GLOBALS['strWeeklyHistory'] = "Haftalık geçmiş";
$GLOBALS['strMonthlyHistory'] = "Aylık geçmiş";
$GLOBALS['strTotalThisPeriod'] = "Bu periyoda ait toplam";
$GLOBALS['strPublisherDistribution'] = "Web Sitesi Dağılımı";
$GLOBALS['strCampaignDistribution'] = "Kampanya Dağılımı";
$GLOBALS['strViewBreakdown'] = "Şuna göre görüntüle:";
$GLOBALS['strBreakdownByDay'] = "Gün";
$GLOBALS['strBreakdownByWeek'] = "Hafta";
$GLOBALS['strBreakdownByMonth'] = "Ay";
$GLOBALS['strBreakdownByDow'] = "Haftanın günü";
$GLOBALS['strBreakdownByHour'] = "Saat";
$GLOBALS['strItemsPerPage'] = "Sayfa başına öğe";
$GLOBALS['strShowGraphOfStatistics'] = "İstatistiklerin <u>G</u>rafiğini göster";
$GLOBALS['strExportStatisticsToExcel'] = "İstatistikleri <u>E</u>xcel'e aktar";
$GLOBALS['strGDnotEnabled'] = "Grafikleri görüntüleyebilmek için PHP'de GD'nin etkin olması gerekmektedir. <br/>Lütfen, GD'nin nasıl yükleneceğini de içeren şu sayfaya bakın: <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a>.";

// Expiration
$GLOBALS['strNoExpiration'] = "Bitiş tarihi belirtilmemiş";
$GLOBALS['strEstimated'] = "Tahmini bitiş tarihi";
$GLOBALS['strCampaignStop'] = "Kampanya Geçmişi";

// Reports
$GLOBALS['strLimitations'] = "Kısıtlamalar";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "Tüm reklamverenler";
$GLOBALS['strAnonAdvertisers'] = "İsimsiz reklamverenler";
$GLOBALS['strAllPublishers'] = "Tüm web siteleri";
$GLOBALS['strAnonPublishers'] = "İsimsiz web siteleri";
$GLOBALS['strAllAvailZones'] = "Tüm uygun alanlar";

// Userlog
$GLOBALS['strUserLog'] = "Kullanıcı kayıtları";
$GLOBALS['strUserLogDetails'] = "Kullanıcı kayıt detayları";
$GLOBALS['strDeleteLog'] = "Kayıtları Sil";
$GLOBALS['strAction'] = "Eylem";
$GLOBALS['strNoActionsLogged'] = "Kaydedilmiş aktivite yok";

// Code generation
$GLOBALS['strGenerateBannercode'] = "Direkt seçim";
$GLOBALS['strChooseInvocationType'] = "Lütfen banner çağırma tipini seçiniz";
$GLOBALS['strGenerate'] = "Oluştur";
$GLOBALS['strParameters'] = "Etiket ayarları";
$GLOBALS['strFrameSize'] = "Çerçeve boyutu";
$GLOBALS['strBannercode'] = "Banner kodu";
$GLOBALS['strBackToTheList'] = "Rapor listesine geri dön";


// Errors
$GLOBALS['strNoMatchesFound'] = "Uygun kayıt bulunamadı";
$GLOBALS['strErrorOccurred'] = "Bir hata oluştu";
$GLOBALS['strErrorDBPlain'] = "Veritabanına erişilirken bir hata oluştu";
$GLOBALS['strErrorDBSerious'] = "Veritabanıyla ilgili ciddi bir problem tespit edildi";
$GLOBALS['strErrorDBCorrupt'] = "Veritabanı tablosu muhtemelen bozuk ve onarılması gerekiyor. Bozulmuş tabloların onarımı hakkında daha fazla bilgi için lütfen <i>Yönetici klavuzu</i>'nun <i>Sorun Çözme</i> bölümünü okuyun.";
$GLOBALS['strErrorDBContact'] = "Lütfen bu sunucunun yöneticisiyle iletişime geçin ve problem hakkında bilgilendirin.";
$GLOBALS['strErrorLinkingBanner'] = "Belirtilen nedenle banner bu alana bağlanamadı:";
$GLOBALS['strUnableToLinkBanner'] = "Bu banner bağlanamıyor: _";
$GLOBALS['strUnableToChangeZone'] = "Belirtilen nedenle bu değişiklik uygulanamadı:";
$GLOBALS['strDatesConflict'] = "tarih çakışıyor: ";

//Validation

// Email
$GLOBALS['strSirMadam'] = "Bay/Bayan";
$GLOBALS['strMailSubject'] = "Reklamveren raporu";
$GLOBALS['strMailBannerStats'] = "{clientname} için banner istatistiklerini aşağıda bulacaksınız:";
$GLOBALS['strMailBannerActivatedSubject'] = "Kampanya aktifleştirildi";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Kampanya pasifleştirildi";
$GLOBALS['strMailBannerDeactivated'] = "Aşağıda gösterilen kampanyanız pasifleştirildi, çünkü";
$GLOBALS['strClientDeactivated'] = "Bu kampanya şu anda aktif değil, çünkü";
$GLOBALS['strBeforeActivate'] = "aktivasyon tarihine henüz ulaşılmadı";
$GLOBALS['strAfterExpire'] = "sona erme tarihine ulaşıldı";
$GLOBALS['strNoMoreImpressions'] = "gösterim kalmadı";
$GLOBALS['strNoMoreClicks'] = "tıklama kalmadı";
$GLOBALS['strNoMoreConversions'] = "satış hakkı kalmadı";
$GLOBALS['strWeightIsNull'] = "ağırlığı sıfıra ayarlı";
$GLOBALS['strNoViewLoggedInInterval'] = "Bu rapor süresince gösterim kaydedilmedi";
$GLOBALS['strNoClickLoggedInInterval'] = "Bu rapor süresince tıklama kaydedilmedi";
$GLOBALS['strNoConversionLoggedInInterval'] = "Bu rapor süresince dönüşüm kaydedilmedi";
$GLOBALS['strMailReportPeriod'] = "Bu rapor {startdate} tarihi ile {enddate} tarihleri arasındaki istatistikleri içerir.";
$GLOBALS['strMailReportPeriodAll'] = "Bu rapor {enddate} tarihine kadarki tüm istatistikleri içerir.";
$GLOBALS['strNoStatsForCampaign'] = "Bu kampanyaya ait istatistik bulunmuyor";
$GLOBALS['strImpendingCampaignExpiry'] = "Kampanya bitişi yakın";
$GLOBALS['strYourCampaign'] = "Kampanyanız";
$GLOBALS['strTheCampiaignBelongingTo'] = "{clientname} reklamverenine ait aşağıdaki kampanya";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{date} tarihinde bitiyor.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "Aşağıda gösterilen {clientname} {limit} değerinden az gösterim hakkına sahip.";

// Priority
$GLOBALS['strPriority'] = "Öncelik";
$GLOBALS['strSourceEdit'] = "Kaynakları Düzenle";

// Preferences
$GLOBALS['strPreferences'] = "Tercihler";

// Long names
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
$GLOBALS['strImpressionSR'] = "Gösterimler";

// Short names
$GLOBALS['strERPM_short'] = "CPM";
$GLOBALS['strERPC_short'] = "CPC";
$GLOBALS['strERPS_short'] = "CPM";
$GLOBALS['strEIPM_short'] = "CPM";
$GLOBALS['strEIPC_short'] = "CPC";
$GLOBALS['strEIPS_short'] = "CPM";
$GLOBALS['strECPM_short'] = "CPM";
$GLOBALS['strECPC_short'] = "CPC";
$GLOBALS['strECPS_short'] = "CPM";
$GLOBALS['strID_short'] = "ID [Sıra No]";
$GLOBALS['strClicks_short'] = "Tıklamalar";
$GLOBALS['strCTR_short'] = "TGO";

// Global Settings
$GLOBALS['strGlobalSettings'] = "Genel Ayarlar";
$GLOBALS['strGeneralSettings'] = "Genel Ayarlar";
$GLOBALS['strMainSettings'] = "Ana Ayarlar";

// Product Updates
$GLOBALS['strProductUpdates'] = "Ürün Güncellemeleri";
$GLOBALS['strViewPastUpdates'] = "Eski Güncelleme ve Yedekleri Yönet";

// Agency
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

// Channels
$GLOBALS['strChannel'] = "Hedefleme Kanalı";
$GLOBALS['strChannels'] = "Hedefleme Kanalları";
$GLOBALS['strChannelManagement'] = "Hedefleme Kanalı Yönetimi";
$GLOBALS['strAddNewChannel'] = "Yeni hedefleme kanalı ekle";
$GLOBALS['strAddNewChannel_Key'] = "Ye<u>n</u>i hedefleme kanalı ekle";
$GLOBALS['strChannelToWebsite'] = "Web sitesi yok";
$GLOBALS['strNoChannels'] = "Tanımlanmış hedefleme kanalı yok";
$GLOBALS['strNoChannelsAddWebsite'] = "Henüz tanımlı bir web sitesi yok. Bir alan yaratmak için öncelikle <a href='affiliate-edit.php'>yeni bir web sitesi yarat</a>malısınız.";
$GLOBALS['strEditChannelLimitations'] = "Hedefleme kanalı kısıtlamalarını düzenle";
$GLOBALS['strChannelProperties'] = "Hedefleme Kanalı özellikleri";
$GLOBALS['strChannelLimitations'] = "Teslimat Seçenekleri";
$GLOBALS['strConfirmDeleteChannel'] = "Bu hedefleme kanalını silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmDeleteChannels'] = "Bu hedefleme kanalını silmek istediğinize emin misiniz?";

// Tracker Variables
$GLOBALS['strVariableName'] = "Değişken Adı";
$GLOBALS['strVariableDescription'] = "Tanımlama";
$GLOBALS['strVariableDataType'] = "Veri Tipi";
$GLOBALS['strVariablePurpose'] = "Amaç";
$GLOBALS['strGeneric'] = "Jenerik";
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

// Password recovery
$GLOBALS['strForgotPassword'] = "Şifrenizi mi unuttunuz?";
$GLOBALS['strPasswordRecovery'] = "Şifre yenileme";
$GLOBALS['strEmailRequired'] = "Eposta alanı gereklidir";
$GLOBALS['strPwdRecEmailNotFound'] = "Eposta adresi bulunamadı";
$GLOBALS['strPwdRecWrongId'] = "Yanlış ID";
$GLOBALS['strPwdRecEnterEmail'] = "Eposta adresinizi girin";
$GLOBALS['strPwdRecEnterPassword'] = "Yeni şifrenizi girin";
$GLOBALS['strPwdRecResetLink'] = "Şifre yenileme bağlantısı";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "%s şifre yenilemesi";

// Audit

// Widget - Audit

// Widget - Campaign



//confirmation messages










// Report error messages

/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyNextItem'] = ".";
$GLOBALS['keyPreviousItem'] = ",";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
