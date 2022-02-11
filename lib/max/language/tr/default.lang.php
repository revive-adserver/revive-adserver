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
$GLOBALS['strWhenCheckingForUpdates'] = "Güncelleştirmeleri denetlerken";
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
$GLOBALS['strBack'] = "Geri";
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
$GLOBALS['strAll'] = "tümü";
$GLOBALS['strAverage'] = "Ortalama";
$GLOBALS['strOverall'] = "Tüm";
$GLOBALS['strTotal'] = "Toplam";
$GLOBALS['strFrom'] = "-den/-dan";
$GLOBALS['strTo'] = "-e/-a";
$GLOBALS['strAdd'] = "Ekle";
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
$GLOBALS['strValue'] = "Değer";
$GLOBALS['strWarning'] = "Uyarı";
$GLOBALS['strNotice'] = "Uyarı";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "Panel gösterilemiyor";
$GLOBALS['strNoCheckForUpdates'] = "Güncellemeleri kontrol etme etkin olmadıkça panel gösterilemiyor.";
$GLOBALS['strEnableCheckForUpdates'] = "Lütfen <a href='account-settings-update.php' target='_top'>güncelleme ayarları</a> sayfasından <br/><a href='account-settings-update.php' target='_top'>güncellemeleri kontrol et</a> ayarını etkinleştirin.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "kod";
$GLOBALS['strDashboardSystemMessage'] = "Sistem mesajı";
$GLOBALS['strDashboardErrorHelp'] = "Bu hata tekrarlanırsa lütfen sorununuzu ayrıntılı olarak açıklayın ve şuraya gönderin. <a href='http://forum.revive-adserver.com/'>forum.revive-adserver.com/</a>.";

// Priority
$GLOBALS['strPriority'] = "Öncelik";
$GLOBALS['strPriorityLevel'] = "Öncelik düzeyi";
$GLOBALS['strOverrideAds'] = "Kampanya Reklamlarını Geçersiz Kılma";
$GLOBALS['strHighAds'] = "Sözleşmeli Kampanya Reklamları";
$GLOBALS['strECPMAds'] = "eBGBM Kampanya Reklamı";
$GLOBALS['strLowAds'] = "Boşta Kalan Gösterim Kampanyası";
$GLOBALS['strLimitations'] = "Teslimat kuralları";
$GLOBALS['strNoLimitations'] = "Teslimat kuralı yok";
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
$GLOBALS['strWorkingAs'] = "Olarak çalışıyor";
$GLOBALS['strWorkingAs'] = "Olarak çalışıyor";
$GLOBALS['strNoAccountWithXInNameFound'] = "\"%s\" adında hiçbir hesap bulunamadı";
$GLOBALS['strRecentlyUsed'] = "Son zamanlarda kullanılmış";
$GLOBALS['strLinkUser'] = "Kullanıcı ekle";
$GLOBALS['strUsernameToLink'] = "Eklenecek kullanıcının kullanıcı adı";
$GLOBALS['strNewUserWillBeCreated'] = "Yeni kullanıcı oluşturulacak";
$GLOBALS['strToLinkProvideEmail'] = "Kullanıcı eklemek için, kullanıcının mailini sağlayın";
$GLOBALS['strToLinkProvideUsername'] = "Kullanıcı eklemek için, kullanıcı adı sağlayın";
$GLOBALS['strUserAccountUpdated'] = "Kullanıcı hesabı güncellendi";
$GLOBALS['strUserWasDeleted'] = "Kullanıcı silindi";
$GLOBALS['strUserNotLinkedWithAccount'] = "Bu kullanıcının ilişkili bir hesabı bulunmuyor.";
$GLOBALS['strLinkUserHelpUser'] = "Kullanıcı Adı";
$GLOBALS['strLinkUserHelpEmail'] = "email adresi";
$GLOBALS['strLastLoggedIn'] = "Son oturum açma";
$GLOBALS['strDateLinked'] = "Bağlantı tarihi";

// Login & Permissions
$GLOBALS['strUserAccess'] = "Kullanıcı Erişimi";
$GLOBALS['strAdminAccess'] = "Yönetici Erişimi";
$GLOBALS['strUserProperties'] = "Banner özellikleri";
$GLOBALS['strPermissions'] = "İzinler";
$GLOBALS['strAuthentification'] = "Kimlik Doğrulama";
$GLOBALS['strWelcomeTo'] = "Hoşgeldiniz ";
$GLOBALS['strEnterUsername'] = "Giriş yapabilmek için kullanıcı adınızı ve parolanızı giriniz";
$GLOBALS['strEnterBoth'] = "Lütfen kullanıcı adınızı ve parolanızı birlikte giriniz";
$GLOBALS['strEnableCookies'] = "{$PRODUCT_NAME} kullanmaya başlamadan önce tarayıcı (browser) ayarlarınızı çerezleri (cookie) kabul edecek şekilde değiştirmelisiniz.";
$GLOBALS['strSessionIDNotMatch'] = "Oturum çerezi hatası, lütfen oturum aç";
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
$GLOBALS['strInvalidPassword'] = "Bu şifre geçersiz. Lütfen farklı bir şifre girin.";
$GLOBALS['strInvalidEmail'] = "E-posta doğru biçimde biçimlendirilmedi, lütfen doğru bir e-posta adresi verin.";
$GLOBALS['strNotSamePasswords'] = "Yazdığınız iki şifre aynı değil";
$GLOBALS['strRepeatPassword'] = "Şifreyi Tekrarla";
$GLOBALS['strDeadLink'] = "Bağlantı geçersiz.";
$GLOBALS['strNoPlacement'] = "Seçilen kampanya mevcut değil. Yerine bu <a href='{link}'>baglantı</a>' yı deneyin";

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
$GLOBALS['strTrackerImageTag'] = "Görüntü Etiketi";
$GLOBALS['strTrackerJsTag'] = "Javascript Etiketi";
$GLOBALS['strBanners'] = "Bannerlar";
$GLOBALS['strCampaigns'] = "Kampanya";
$GLOBALS['strCampaignID'] = "Kampanya ID";
$GLOBALS['strCampaignName'] = "Kampanya Adı";
$GLOBALS['strCountry'] = "Ülke";
$GLOBALS['strStatsAction'] = "Eylem";
$GLOBALS['strWindowDelay'] = "Pencere gecikmesi";
$GLOBALS['strStatsVariables'] = "Değişkenler";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Aylık Kiralama";
$GLOBALS['strFinanceCTR'] = "TGO";
$GLOBALS['strFinanceCR'] = "CR";

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
    $GLOBALS['strDayFullNames'] = [];
}
$GLOBALS['strDayFullNames'][0] = 'Pazar';
$GLOBALS['strDayFullNames'][1] = 'Pazartesi';
$GLOBALS['strDayFullNames'][2] = 'Salı';
$GLOBALS['strDayFullNames'][3] = 'Çarşamba';
$GLOBALS['strDayFullNames'][4] = 'Perşembe';
$GLOBALS['strDayFullNames'][5] = 'Cuma';
$GLOBALS['strDayFullNames'][6] = 'Cumartesi';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = [];
}
$GLOBALS['strDayShortCuts'][0] = 'Pa';
$GLOBALS['strDayShortCuts'][1] = 'Pt';
$GLOBALS['strDayShortCuts'][2] = 'Sa';
$GLOBALS['strDayShortCuts'][3] = 'Ça';
$GLOBALS['strDayShortCuts'][4] = 'Pe';
$GLOBALS['strDayShortCuts'][5] = 'Cu';
$GLOBALS['strDayShortCuts'][6] = 'Ct';

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
$GLOBALS['strClientHistory'] = "Reklamcı İstatistikleri";
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
$GLOBALS['strAdvertiserLimitation'] = "Bu reklamverenden yalnızca bir web sayfasında afiş görüntüleme";
$GLOBALS['strAllowAuditTrailAccess'] = "Bu kullanıcının denetim izine erişimine izin ver";

// Campaign
$GLOBALS['strCampaign'] = "Kampanya";
$GLOBALS['strCampaigns'] = "Kampanya";
$GLOBALS['strAddCampaign'] = "Yeni kampanya ekle";
$GLOBALS['strAddCampaign_Key'] = "Ye<u>n</u>i kampanya ekle";
$GLOBALS['strCampaignForAdvertiser'] = "reklamcı için";
$GLOBALS['strLinkedCampaigns'] = "Bağlı kampanyalar";
$GLOBALS['strCampaignProperties'] = "Kampanya Bilgileri";
$GLOBALS['strCampaignOverview'] = "Kampanya Özeti";
$GLOBALS['strCampaignHistory'] = "Kampanya İstatistikleri";
$GLOBALS['strNoCampaigns'] = "Henüz tanımlanmış Kampanya yok";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "Şu anda tanımlı kampanya yok, çünkü reklamcı yok. Kampanya oluşturmak için, öncelikle <a href='advertiser-edit.php'>yeni bir reklamcı ekleyin</a>.";
$GLOBALS['strConfirmDeleteCampaign'] = "Bu kampanyayı silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Bu kampanyayı silmek istediğinize emin misiniz?";
$GLOBALS['strShowParentAdvertisers'] = "Üst reklamverenleri göster";
$GLOBALS['strHideParentAdvertisers'] = "Üst reklamverenleri gizle";
$GLOBALS['strHideInactiveCampaigns'] = "Etkin olmayan kampanyaları gizle";
$GLOBALS['strInactiveCampaignsHidden'] = "Etkin olmayan kampanya(lar) gizlendi";
$GLOBALS['strPriorityInformation'] = "Diğer kampanyalara göre öncelik";
$GLOBALS['strECPMInformation'] = "eCPM önceliklendirme";
$GLOBALS['strRemnantEcpmDescription'] = "eBGBM, bu kampanyanın performansına dayalı olarak otomatik olarak hesaplanır. <br/> Bu, Kalıntı kampanyalarına birbirine göre öncelik vermede kullanılacaktır.";
$GLOBALS['strHiddenCampaign'] = "Kampanya";
$GLOBALS['strHiddenAd'] = "Reklam";
$GLOBALS['strHiddenAdvertiser'] = "Reklamveren";
$GLOBALS['strHiddenTracker'] = "İzleyici";
$GLOBALS['strHiddenWebsite'] = "Web sitesi";
$GLOBALS['strHiddenZone'] = "Alan";
$GLOBALS['strCompanionPositioning'] = "Klavuz yerleştirme";
$GLOBALS['strSelectUnselectAll'] = "Tümünü Seç / Seçme";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "Tüm kampanyalar için hesaplandı";
$GLOBALS['strCalculatedForThisCampaign'] = "Bu kampanya için hesaplandı";
$GLOBALS['strZonesSearch'] = "Ara";
$GLOBALS['strZonesSearchTitle'] = "Bölgeleri ve websiteleri isme göre ara";
$GLOBALS['strNoWebsitesAndZones'] = "Website ve bölge yok";
$GLOBALS['strAvailable'] = "Kullanılabilir";
$GLOBALS['strShowing'] = "Gösteriliyor";
$GLOBALS['strEditZone'] = "Bölgeyi Düzenle";
$GLOBALS['strEditWebsite'] = "Web sitesini düzenle";


// Campaign properties
$GLOBALS['strDontExpire'] = "Bu kampanyayı belirli bir tarihte bitirme";
$GLOBALS['strActivateNow'] = "Bu kampanyayı hemen aktif et";
$GLOBALS['strSetSpecificDate'] = "Belirli bir tarihi ayarla";
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
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "Bu kampanyanın türü Remnant olarak ayarlandı, ancak ağırlık sıfır olarak ayarlandı veya belirtilmedi. Bu, kampanya devre dışı bırakılana ve ağırlığı geçerli bir sayıya ayarlanıncaya kadar afişler teslim edilmeyecektir.
Devam etmek istediğine emin misin?";
$GLOBALS['strCampaignWarningEcpmNoRevenue'] = "Bu kampanya, eBGBM optimizasyonunu kullanıyor ancak \"gelir\" sıfır olarak ayarlanmış veya belirtilmemiş.
Bu, kampanyanın devre dışı bırakılmasına ve gelirinin geçerli bir sayıya ayarlanmasına kadar afişlerin teslim edilmemesine neden olur.

Devam etmek istediğine emin misin?";
$GLOBALS['strCampaignWarningOverrideNoWeight'] = "Bu kampanyanın türü Geçersiz Kılma olarak ayarlanmış ancak ağırlık sıfır olarak ayarlanmış veya belirtilmemiş. Bu, kampanyanın devre dışı bırakılmasına ve ağırlık geçerli bir sayıya ayarlanmasına kadar afişlerin teslim edilmemesine neden olur.

Devam etmek istediğine emin misin?";
$GLOBALS['strCampaignWarningNoTarget'] = "Bu kampanyanın türü Sözleşme olarak ayarlandı, ancak gün başına sınır belirtilmedi.
Bu, kampanyanın devre dışı bırakılmasına neden olur ve afişleri, geçerli bir Gün başına sınır ayarlanıncaya kadar teslim edilmez.

Devam etmek istediğine emin misin?";
$GLOBALS['strCampaignStatusPending'] = "Beklemede";
$GLOBALS['strCampaignStatusInactive'] = "etkin";
$GLOBALS['strCampaignStatusRunning'] = "Çalışıyor";
$GLOBALS['strCampaignStatusPaused'] = "Duraklat";
$GLOBALS['strCampaignStatusAwaiting'] = "Bekleniyor";
$GLOBALS['strCampaignStatusExpired'] = "Tamamlandı";
$GLOBALS['strCampaignStatusApproval'] = "Onay bekleniyor »";
$GLOBALS['strCampaignStatusRejected'] = "Reddedildi";
$GLOBALS['strCampaignStatusAdded'] = "Eklendi";
$GLOBALS['strCampaignStatusStarted'] = "Başlatıldı";
$GLOBALS['strCampaignStatusRestarted'] = "Yeniden başlat";
$GLOBALS['strCampaignStatusDeleted'] = "Sil";
$GLOBALS['strCampaignType'] = "Kampanya Adı";
$GLOBALS['strType'] = "Tip";
$GLOBALS['strContract'] = "Sözleşme";
$GLOBALS['strOverride'] = "Geçersiz kıl";
$GLOBALS['strOverrideInfo'] = "Geçersiz kılma kampanyaları, Kalıntı ve Sözleşme kampanyalarını geçersiz kılmak (yani öncelikli olmak için) özel bir kampanya türüdür. Geçersiz kılma kampanyaları genellikle, belirli bir tanıtımın parçası olarak kampanya afişlerinin belirli yerlerde, belirli kullanıcılarda ve belki de belirli bir sayıda gösterildiğinden emin olmak için belirli hedefleme ve / veya üst sınır kurallarıyla birlikte kullanılır. (Bu kampanya türü daha önce 'Sözleşme (Münhasır)' olarak biliniyordu.)";
$GLOBALS['strStandardContract'] = "Sözleşme";
$GLOBALS['strStandardContractInfo'] = "Sözleşme kampanyaları, belirli bir zaman kritik performans gereksinimi elde etmek için gereken gösterimleri sorunsuz bir şekilde sunmak içindir. Yani, Sözleşme kampanyaları, bir reklamverenin belli bir sayıda gösterim, tıklama ve / veya dönüşüm elde etmesini ya iki tarih ya da günlük olarak gerçekleştirilmesini sağlar.";
$GLOBALS['strRemnantInfo'] = "Varsayılan kampanya türü. Kalıntı kampanyalarda çok sayıda farklı dağıtım seçeneği bulunur ve her zaman göstermek için bir şeyler olduğundan emin olmak için ideal olarak her bölgeye bağlı en az bir Kalıcı kampanya oluşturmalısınız. Evdeki afişleri, reklam ağı afişlerini veya satılan doğrudan reklamları görüntülemek için kalıcı kampanyaları kullanın; ancak kampanyanın uyması gereken zaman açısından kritik bir performans gereksinimi bulunmamaktadır.";
$GLOBALS['strECPMInfo'] = "Bu, bitiş tarihi veya belirli bir sınırla sınırlandırılabilen standart bir kampanyadır. Mevcut ayarlara göre, eBGBM'yi kullanarak önceliklendirilir.";
$GLOBALS['strPricing'] = "Fiyatlandırma";
$GLOBALS['strPricingModel'] = "Fiyatlandırma modeli";
$GLOBALS['strSelectPricingModel'] = "-- modeli seçiniz --";
$GLOBALS['strRatePrice'] = "Oran / Değer";
$GLOBALS['strMinimumImpressions'] = "Minimum günlük izlenimler";
$GLOBALS['strLimit'] = "Limit";
$GLOBALS['strLowExclusiveDisabled'] = "Bu kampanyayı hem Randevu hem de Ayrıcalıklı olarak değiştiremezsiniz, çünkü hem bir bitiş tarihi hem de gösterim / tıklama / dönüşüm sınırı belirlenmiştir. <br> Türünü değiştirmek için son kullanma tarihi ayarlamanız veya sınırları kaldırmanız gerekir.";
$GLOBALS['strCannotSetBothDateAndLimit'] = "Hem Bir bitiş tarihi hem de Ayrı bir kampanya için bir bitiş tarihi ve limiti ayarlayamazsınız. <br> Bitiş tarihini ve sınırlamaları / tıklamaları / dönüşümleri sınırlamanız gerekiyorsa lütfen sınırlı olmayan bir Sözleşme kampanyası kullanın.";
$GLOBALS['strWhyDisabled'] = "neden devre dışı?";
$GLOBALS['strBackToCampaigns'] = "Kampanyalara Geri Dön";
$GLOBALS['strCampaignBanners'] = "Kampanyanın afişleri";
$GLOBALS['strCookies'] = "Çerezler";

// Tracker
$GLOBALS['strTracker'] = "İzleyici";
$GLOBALS['strTrackers'] = "İzleyici";
$GLOBALS['strTrackerPreferences'] = "Takipçi Tercihleri";
$GLOBALS['strAddTracker'] = "Yeni bir izleyici ekle";
$GLOBALS['strTrackerForAdvertiser'] = "reklamcı için";
$GLOBALS['strNoTrackers'] = "Bu reklamcı için şu anda tanımlı izleyici yok";
$GLOBALS['strConfirmDeleteTrackers'] = "Bu izleyiciyi silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmDeleteTracker'] = "Bu izleyiciyi silmek istediğinize emin misiniz?";
$GLOBALS['strTrackerProperties'] = "İzleyici Özellikleri";
$GLOBALS['strDefaultStatus'] = "Varsayılan Durum";
$GLOBALS['strStatus'] = "Durum";
$GLOBALS['strLinkedTrackers'] = "Bağlı İzleyiciler";
$GLOBALS['strTrackerInformation'] = "İzleyici Bilgisi";
$GLOBALS['strConversionWindow'] = "Dönüştürme penceresi";
$GLOBALS['strUniqueWindow'] = "Tekil pencere";
$GLOBALS['strClick'] = "Tıkla";
$GLOBALS['strView'] = "Görüntüle";
$GLOBALS['strArrival'] = "Varış";
$GLOBALS['strManual'] = "Elle";
$GLOBALS['strImpression'] = "İzlenim";
$GLOBALS['strConversionType'] = "Dönüşüm tipi";
$GLOBALS['strLinkCampaignsByDefault'] = "Yeni yaratılan kampanyaları doğrudan bağla";
$GLOBALS['strBackToTrackers'] = "İzleyicilere dön";
$GLOBALS['strIPAddress'] = "IP Adresi";

// Banners (General)
$GLOBALS['strBanner'] = "Afiş";
$GLOBALS['strBanners'] = "Bannerlar";
$GLOBALS['strAddBanner'] = "Yeni banner ekle";
$GLOBALS['strAddBanner_Key'] = "Ye<u>n</u>i banner ekle";
$GLOBALS['strBannerToCampaign'] = "Kampanyanız";
$GLOBALS['strShowBanner'] = "Banneri göster";
$GLOBALS['strBannerProperties'] = "Banner Özellikleri";
$GLOBALS['strBannerHistory'] = "Afiş İstatistikleri";
$GLOBALS['strNoBanners'] = "Tanımlanmış Banner Yok";
$GLOBALS['strNoBannersAddCampaign'] = "Şu anda tanımlı afiş yok, çünkü kampanya yok. Bir afiş oluşturmak için, öncelikle <a href='campaign-edit.php?clientid=%s'>bir yeni kampanya ekleyin</a>.";
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
$GLOBALS['strBannerPreferences'] = "Afiş Tercihleri";
$GLOBALS['strCampaignPreferences'] = "Kampanya Tercihleri";
$GLOBALS['strDefaultBanners'] = "Varsayılan Afişler";
$GLOBALS['strDefaultBannerUrl'] = "Varsayılan Görüntü URLsi";
$GLOBALS['strDefaultBannerDestination'] = "Varsayılan Hedef URLsi";
$GLOBALS['strAllowedBannerTypes'] = "İzin Verilen Afiş Tipleri";
$GLOBALS['strTypeSqlAllow'] = "SQL Yerel Afişlere İzin Ver";
$GLOBALS['strTypeWebAllow'] = "Webserver Yerel Afişlere İzin Ver";
$GLOBALS['strTypeUrlAllow'] = "Harici Afişlere İzin Ver";
$GLOBALS['strTypeHtmlAllow'] = "HTML Afişlere İzin Ver";
$GLOBALS['strTypeTxtAllow'] = "Metin Reklamlarına İzin Ver";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Lütfen banner tipini seçiniz";
$GLOBALS['strMySQLBanner'] = "Yerel banner (SQL)";
$GLOBALS['strWebBanner'] = "Yerel banner (Webserver)";
$GLOBALS['strURLBanner'] = "Harici banner";
$GLOBALS['strHTMLBanner'] = "HTML banner";
$GLOBALS['strTextBanner'] = "Yazı Olarak Reklam";
$GLOBALS['strIframeFriendly'] = "Bu afiş, bir iframe içine güvenle görüntülenebilir (ör. Genişletilemez)";
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
$GLOBALS['strDoNotAlterHtml'] = "HTML'yi değiştirmeyin";
$GLOBALS['strGenericOutputAdServer'] = "Jenerik";
$GLOBALS['strBackToBanners'] = "Afişlere dön";
$GLOBALS['strUseWyswygHtmlEditor'] = " WYSIWYG HTML Düzenleyici Kullan";
$GLOBALS['strChangeDefault'] = "Varsayılan değiştir";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "Aşağıdaki HTML kodunu bu reklam bandına her zaman ekleyin";
$GLOBALS['strBannerAppendHTML'] = "Bu reklam bandına aşağıdaki HTML kodunu her zaman ekleyin";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "Teslimat Seçenekleri";
$GLOBALS['strACL'] = "Teslimat Seçenekleri";
$GLOBALS['strACLAdd'] = "Teslimat kuralı ekle";
$GLOBALS['strAllBannersInCampaign'] = "Bu kampanyadaki tüm afişler";
$GLOBALS['strRemoveAllLimitations'] = "Tüm teslimat kurallarını kaldır";
$GLOBALS['strEqualTo'] = "eşittir";
$GLOBALS['strDifferentFrom'] = "farklıdır";
$GLOBALS['strLaterThan'] = "daha geçtir";
$GLOBALS['strLaterThanOrEqual'] = "daha geç ya da eşittir";
$GLOBALS['strEarlierThan'] = "daha erkendir ";
$GLOBALS['strEarlierThanOrEqual'] = "daha erken ya da eşittir";
$GLOBALS['strGreaterThan'] = "daha fazladır";
$GLOBALS['strLessThan'] = "daha azdır";
$GLOBALS['strAND'] = "VE";                          // logical operator
$GLOBALS['strOR'] = "VEYA";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Bu bannerı yalnızca şu durumda göster:";
$GLOBALS['strWeekDays'] = "Haftaiçi";
$GLOBALS['strTime'] = "Zaman";
$GLOBALS['strDomain'] = "Alan";
$GLOBALS['strSource'] = "Kaynak";
$GLOBALS['strBrowser'] = "Tarayıcı";
$GLOBALS['strOS'] = "OS";
$GLOBALS['strDeliveryLimitations'] = "Teslimat Kuralları";

$GLOBALS['strDeliveryCappingReset'] = "Görüntüleme sayaçlarını şundan sonra sıfırla:";
$GLOBALS['strDeliveryCappingTotal'] = "toplam";
$GLOBALS['strDeliveryCappingSession'] = "oturum başına";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = [];
}
$GLOBALS['strCappingBanner']['limit'] = "Banner gösterimlerini şununla sınırla:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = [];
}
$GLOBALS['strCappingCampaign']['limit'] = "Kampanya gösterimlerini şununla sınırla:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = [];
}
$GLOBALS['strCappingZone']['limit'] = "Alan gösterimlerini şununla sınırla:";

// Website
$GLOBALS['strAffiliate'] = "Web sitesi";
$GLOBALS['strAffiliates'] = "Web Siteleri ";
$GLOBALS['strAffiliatesAndZones'] = "Web Siteleri ve Alanlar";
$GLOBALS['strAddNewAffiliate'] = "Yeni web sitesi ekle";
$GLOBALS['strAffiliateProperties'] = "Web Sitesi Özellikleri";
$GLOBALS['strAffiliateHistory'] = "Website İstatistikleri";
$GLOBALS['strNoAffiliates'] = "Henüz tanımlı bir web sitesi yok. Bir alan yaratmak için öncelikle <a href='affiliate-edit.php'>yeni bir web sitesi yarat</a>malısınız.";
$GLOBALS['strConfirmDeleteAffiliate'] = "Bu web sitesini silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Bu web sitesini silmek istediğinize emin misiniz?";
$GLOBALS['strInactiveAffiliatesHidden'] = "Etkin olmayan web siteleri gizlendi";
$GLOBALS['strShowParentAffiliates'] = "Üst web sitelerini görüntüle ";
$GLOBALS['strHideParentAffiliates'] = "Üst web sitelerini gizle";

// Website (properties)
$GLOBALS['strWebsite'] = "Web sitesi";
$GLOBALS['strWebsiteURL'] = "Website URLsi";
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
$GLOBALS['strAvailableZones'] = "Mevcut Bölgeler";
$GLOBALS['strZoneProperties'] = "Alan Özellikleri";
$GLOBALS['strZoneHistory'] = "Alan Geçmişi";
$GLOBALS['strNoZones'] = "Henüz hiçbir alan tanımlanmamış";
$GLOBALS['strNoZonesAddWebsite'] = "Henüz tanımlı bir web sitesi yok. Bir alan yaratmak için öncelikle <a href='affiliate-edit.php'>yeni bir web sitesi yarat</a>malısınız.";
$GLOBALS['strConfirmDeleteZone'] = "Bu alanı silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmDeleteZones'] = "Bu alanı silmek istediğinize emin misiniz?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "Hâlâ bu bölgeyle bağlantılı kampanyalar var, silmeniz durumunda bu kampanyalar çalıştırılamayacak ve onlar için ödeme alınmayacak.";
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
$GLOBALS['strWarnBannerReadonly'] = 'Bu banner salt okunurdur, çünkü bir uzantı devre dışı bırakılmıştır. Daha fazla bilgi için sistem yöneticinize başvurun.';
$GLOBALS['strBackToZones'] = "Bölgelere dön";

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "IAB Tam Afiş (468 x 60)";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "IAB Gökdelen (120 x 600)";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "IAB Buton 1 (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "IAB Buton 2 (120 x 60)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "IAB Yarım Afiş (234 x 60)";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "IAB Micro Bar (88 x 31)";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "IAB Kare Buton (125 x 125)";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "IAB Dikdörtgen (180 x 150)";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "IAB Kare Pop-up (250 x 250)";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "IAB Dikey Afiş (120 x 240)";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "IAB Genüş Gökdelern (160 x 600)";

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
$GLOBALS['strSelectPublisher'] = "Website seç";
$GLOBALS['strSelectZone'] = "Bölge seç";
$GLOBALS['strStatusPending'] = "Beklemede";
$GLOBALS['strStatusApproved'] = "Onaylandı";
$GLOBALS['strStatusDisapproved'] = "Onaylanmadı";
$GLOBALS['strStatusDuplicate'] = "Çoğalt";
$GLOBALS['strStatusOnHold'] = "Tutulan";
$GLOBALS['strStatusIgnore'] = "Yoksay";
$GLOBALS['strConnectionType'] = "Tip";
$GLOBALS['strConnTypeSale'] = "Satış";
$GLOBALS['strConnTypeSignUp'] = "Kayıt";
$GLOBALS['strShortcutEditStatuses'] = "Durumları düzenle";
$GLOBALS['strShortcutShowStatuses'] = "Durumları göster";

// Statistics
$GLOBALS['strStats'] = "İstatistikler";
$GLOBALS['strNoStats'] = "Henüz istatistik bulunmamakta";
$GLOBALS['strNoStatsForPeriod'] = "Henüz %s - %s periyoduna ait istatistik bulunmamakta";
$GLOBALS['strGlobalHistory'] = "Global İstatistikler";
$GLOBALS['strDailyHistory'] = "Günlük İstatistikler";
$GLOBALS['strDailyStats'] = "Günlük İstatistikler";
$GLOBALS['strWeeklyHistory'] = "Haftalık İstatistikler";
$GLOBALS['strMonthlyHistory'] = "Aylık İstatistikler";
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
$GLOBALS['strDistributionHistoryCampaign'] = "Dağıtım İstatistikleri (Kampanya)";
$GLOBALS['strDistributionHistoryBanner'] = "Dağıtım İstatistikleri (Afiş)";
$GLOBALS['strDistributionHistoryWebsite'] = "Dağıtım İstatistikleri (Website)";
$GLOBALS['strDistributionHistoryZone'] = "Dağıtım İstatistikleri (Bölge)";
$GLOBALS['strShowGraphOfStatistics'] = "İstatistiklerin <u>G</u>rafiğini göster";
$GLOBALS['strExportStatisticsToExcel'] = "İstatistikleri <u>E</u>xcel'e aktar";
$GLOBALS['strGDnotEnabled'] = "Grafikleri görüntüleyebilmek için PHP'de GD'nin etkin olması gerekmektedir. <br/>Lütfen, GD'nin nasıl yükleneceğini de içeren şu sayfaya bakın: <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a>.";
$GLOBALS['strStatsArea'] = "Alan";

// Expiration
$GLOBALS['strNoExpiration'] = "Bitiş tarihi belirtilmemiş";
$GLOBALS['strEstimated'] = "Tahmini bitiş tarihi";
$GLOBALS['strNoExpirationEstimation'] = "Henüz tahmin edilen süre sonu yok";
$GLOBALS['strDaysAgo'] = "gün önce";
$GLOBALS['strCampaignStop'] = "Kampanya Geçmişi";

// Reports
$GLOBALS['strAdvancedReports'] = "Gelişmiş Raporlar";
$GLOBALS['strStartDate'] = "Başlangıç Tarihi";
$GLOBALS['strEndDate'] = "Bitiş Tarihi";
$GLOBALS['strPeriod'] = "Dönem";
$GLOBALS['strLimitations'] = "Teslimat Kuralları";
$GLOBALS['strWorksheets'] = "Çalışma Sayfaları";

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
$GLOBALS['strTrackercode'] = "İzleyici Kodu";
$GLOBALS['strBackToTheList'] = "Rapor listesine geri dön";
$GLOBALS['strCharset'] = "Karakter takımı";
$GLOBALS['strAutoDetect'] = "Otomatik-algılama";

// Errors
$GLOBALS['strErrorDatabaseConnection'] = "Veritabanı bağlantı hatası.";
$GLOBALS['strErrorCantConnectToDatabase'] = "Ciddi bir hata oluştu %1\$s, veritabanına bağlanılamıyor. Bu nedenle yönetici arayüzünü kullanmak şuan mümkün değil. Afişlerin teslimatı da bu durumdan etkilenebilir. Sorunun olası nedenleri şunlardır:
                                                    <ul>
                                                      <li> Şu anda veritabanı sunucusu çalışmıyor </li>
                                                      <li> Veritabanı sunucusunun yeri değişti </li>
                                                      <li> Veritabanı sunucusuyla iletişim kurmak için kullanılan kullanıcı adı veya şifre doğru değil </li>
                                                      <li> PHP, <i>%2\$s</i> uzantısını yüklemedi </li>
                                                    </ul>";
$GLOBALS['strNoMatchesFound'] = "Uygun kayıt bulunamadı";
$GLOBALS['strErrorOccurred'] = "Bir hata oluştu";
$GLOBALS['strErrorDBPlain'] = "Veritabanına erişilirken bir hata oluştu";
$GLOBALS['strErrorDBSerious'] = "Veritabanıyla ilgili ciddi bir problem tespit edildi";
$GLOBALS['strErrorDBNoDataPlain'] = "Veritabanındaki bir problemden dolayı {$PRODUCT_NAME} veriyi alamadı veya kaydedemedi. ";
$GLOBALS['strErrorDBNoDataSerious'] = "Veritabanındaki bir problemden dolayı {$PRODUCT_NAME} veriye erişemedi";
$GLOBALS['strErrorDBCorrupt'] = "Veritabanı tablosu muhtemelen bozuk ve onarılması gerekiyor. Bozulmuş tabloların onarımı hakkında daha fazla bilgi için lütfen <i>Yönetici klavuzu</i>'nun <i>Sorun Çözme</i> bölümünü okuyun.";
$GLOBALS['strErrorDBContact'] = "Lütfen bu sunucunun yöneticisiyle iletişime geçin ve problem hakkında bilgilendirin.";
$GLOBALS['strErrorDBSubmitBug'] = "Eğer problem yeniden oluşturulabiliyorsa, bu durum {$PRODUCT_NAME} içindeki bir bug'dan kaynaklanıyor olabilir. Lütfen aşağıdaki bilgileri {$PRODUCT_NAME} üreticilerine ulaştırın. Beraberinde hatanın oluşmasıyla sonuçlanan işlemlerinizi olabildiğince açık bir şekilde açıklamaya çalışın.";
$GLOBALS['strMaintenanceNotActive'] = "Bakım rutini son 24 saat içinde çalıştırılmadı.
Ürününün doğru çalışması için bakım rutininin
 her saat çalışması gerekir.

Bakım rutini ayarları hakkında daha fazla bilgi için lütfen
Yönetici kılavuzunu okuyunuz.";
$GLOBALS['strErrorLinkingBanner'] = "Belirtilen nedenle banner bu alana bağlanamadı:";
$GLOBALS['strUnableToLinkBanner'] = "Bu banner bağlanamıyor: _";
$GLOBALS['strErrorEditingCampaignRevenue'] = "Gelir bilgisi alanında hatalı sayı biçimi";
$GLOBALS['strErrorEditingCampaignECPM'] = "ECPM Bilgisi alanında hatalı sayı biçimi";
$GLOBALS['strUnableToChangeZone'] = "Belirtilen nedenle bu değişiklik uygulanamadı:";
$GLOBALS['strDatesConflict'] = "tarih çakışıyor: ";
$GLOBALS['strEmailNoDates'] = "Eposta alanı kampanyaları için başlangıç ve bitiş tarihleri belirtilmelidir";
$GLOBALS['strWarningInaccurateStats'] = "Bu istatistiklerin bazıları UTC olmayan bir zaman diliminde günlüğe kaydedildi ve doğru saat diliminde gösterilmeyebilir.";
$GLOBALS['strWarningInaccurateReport'] = "Bu rapordaki istatistiklerin bir kısmı UTC olmayan bir saat diliminde günlüğe kaydedildi ve doğru zaman diliminde gösterilmeyebilir";

//Validation
$GLOBALS['strFormContainsErrors'] = "Formda hata var, lütfen işaretli alanları aşağıdaki gibi düzeltin.";
$GLOBALS['strXRequiredField'] = "%s gerekli";
$GLOBALS['strEmailField'] = "Lütfen geçerli bir e-posta girin";
$GLOBALS['strNumericField'] = "Lütfen bir numara girin (yalnızca rakamlara izin verilir)";
$GLOBALS['strGreaterThanZeroField'] = "0'dan büyük olmalıdır";
$GLOBALS['strInvalidWebsiteURL'] = "Geçersiz Website URLsi";

// Email
$GLOBALS['strSirMadam'] = "Bay/Bayan";
$GLOBALS['strMailSubject'] = "Reklamveren raporu";
$GLOBALS['strMailHeader'] = "Sayın {contact},";
$GLOBALS['strMailBannerStats'] = "{clientname} için banner istatistiklerini aşağıda bulacaksınız:";
$GLOBALS['strMailBannerActivatedSubject'] = "Kampanya aktifleştirildi";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Kampanya pasifleştirildi";
$GLOBALS['strMailBannerActivated'] = "Kampanya etkinleştirme tarihine ulaşıldığı için, aşağıda gösterilen kampanyanız etkinleştirildi.";
$GLOBALS['strMailBannerDeactivated'] = "Aşağıda gösterilen kampanyanız pasifleştirildi, çünkü";
$GLOBALS['strMailFooter'] = "Saygılar,
   {adminfullname}";
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
$GLOBALS['strImpendingCampaignExpiryBody'] = "Sonuç olarak kampanya yakında otomatik olarak devre dışı kalacak ve
belirtilen afişler de beraberinde pasif olacak:";

// Priority
$GLOBALS['strPriority'] = "Öncelik";
$GLOBALS['strSourceEdit'] = "Kaynakları Düzenle";

// Preferences
$GLOBALS['strPreferences'] = "Tercihler";
$GLOBALS['strUserPreferences'] = "Kullanıcı Tercihleri";
$GLOBALS['strChangePassword'] = "Şifre Değiştir";
$GLOBALS['strChangeEmail'] = "E-postayı değiştir";
$GLOBALS['strCurrentPassword'] = "Mevcut Şifre";
$GLOBALS['strChooseNewPassword'] = "Yeni bir parola seçin";
$GLOBALS['strReenterNewPassword'] = "Yeni Şifreyi Tekrar Girin";
$GLOBALS['strAccountPreferences'] = "Hesap Tercihleri";
$GLOBALS['strFullName'] = "Tam adı";
$GLOBALS['strEmailAddress'] = "E-posta adresi";
$GLOBALS['strUserDetails'] = "Kullanıcı Ayrıntıları";
$GLOBALS['strUserInterfacePreferences'] = "Kullanıcı Arabirim Tercihleri";
$GLOBALS['strColumnName'] = "Sütun adı";
$GLOBALS['strShowColumn'] = "Sütunu göster";
$GLOBALS['strCustomColumnName'] = "Özel sütun adı";
$GLOBALS['strColumnRank'] = "Sütun sırası";

// Long names
$GLOBALS['strRevenue'] = "Gelir";
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
$GLOBALS['strPendingConversions'] = "Bekleyen dönüşümler";
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
$GLOBALS['strImpressions_short'] = "Göst.";
$GLOBALS['strClicks_short'] = "Tıklamalar";
$GLOBALS['strCTR_short'] = "TGO";
$GLOBALS['strConversions_short'] = "Dön.";
$GLOBALS['strPendingConversions_short'] = "Bek. dön.";

// Global Settings
$GLOBALS['strConfiguration'] = "Yapılandırma";
$GLOBALS['strGlobalSettings'] = "Genel Ayarlar";
$GLOBALS['strGeneralSettings'] = "Genel Ayarlar";
$GLOBALS['strMainSettings'] = "Ana Ayarlar";
$GLOBALS['strPlugins'] = "Eklentiler";
$GLOBALS['strChooseSection'] = 'Bölüm seçin';

// Product Updates
$GLOBALS['strProductUpdates'] = "Ürün Güncellemeleri";
$GLOBALS['strViewPastUpdates'] = "Eski Güncelleme ve Yedekleri Yönet";
$GLOBALS['strClickViewBackupDetails'] = "yedek detaylarını görüntülemek için tıkla";
$GLOBALS['strClickHideBackupDetails'] = "yedek detaylarını gizlemek için tıkla";
$GLOBALS['strShowBackupDetails'] = "Veri yedek detaylarını göster";
$GLOBALS['strHideBackupDetails'] = "Veri yedekleme ayrıntıları gizle";
$GLOBALS['strBackupDeleteConfirm'] = "Bu güncellemeden yaratılan tüm yedeklemeleri gerçekten silmek istiyor musunuz?";
$GLOBALS['strDeleteArtifacts'] = "Eserleri Sil";
$GLOBALS['strArtifacts'] = "Eserler";
$GLOBALS['strBackupDbTables'] = "Yedek veritabanı tabloları";
$GLOBALS['strLogFiles'] = "Günlük dosyaları";
$GLOBALS['strUpdatedDbVersionStamp'] = "Güncellenmiş veritabanı sürüm damgası";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "YÜKSELTMEYİ TAMAMLA";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "YÜKSELTME BAŞARISIZ";

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
$GLOBALS['strSwitchAccount'] = "Bu hesaba geç";
$GLOBALS['strAgencyStatusInactive'] = "etkin";

// Channels
$GLOBALS['strChannelToWebsite'] = "Web sitesi yok";
$GLOBALS['strChannelLimitations'] = "Teslimat Seçenekleri";
$GLOBALS['strConfirmDeleteChannel'] = "Bu teslimat kuralı kümesini gerçekten silmek istiyor musunuz?";
$GLOBALS['strConfirmDeleteChannels'] = "Seçilen teslimat kuralı kümelerini gerçekten silmek istiyor musunuz?";

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
$GLOBALS['strEmailRequired'] = "Eposta alanı gereklidir";
$GLOBALS['strPwdRecEnterEmail'] = "Eposta adresinizi girin";
$GLOBALS['strPwdRecEnterPassword'] = "Yeni şifrenizi girin";

// Password recovery - Default


// Password recovery - Welcome email

// Password recovery - Hash update

// Password reset warning

// Audit
$GLOBALS['strBinaryData'] = "İkili veri";
$GLOBALS['strAuditTrailDisabled'] = "Denetim İzi, sistem yöneticisi tarafından devre dışı bırakıldı. Başka olay kaydedilmez ve Denetim İzi listesinde gösterilir.";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "Seçtiğiniz zaman aralığında hiçbir kullanıcı etkinliği kaydedilmedi.";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Kampanyalar sayfasına git";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>Görüntülenecek hiçbir kampanya etkinliği yok.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "Seçtiğiniz zaman aralığında başlamış veya bitmiş hiçbir kampanya yok";
$GLOBALS['strCampaignAuditNotActivated'] = "<li> Seçtiğiniz zaman aralığında başlayan veya bitmiş kampanyaları görüntülemek için Denetim İzi etkinleştirilmelidir. </li>
         <li> Denetim İzini etkinleştirmediyseniz bu iletiyi görüyorsunuz </li>";


//confirmation messages


$GLOBALS['strTrackersHaveBeenDeleted'] = "Seçilen tüm izleyiciler silindi";


$GLOBALS['strBannerAclHasBeenUpdated'] = "Reklam bandı <a href='%s'>%s</a> için dağıtım seçenekleri güncellendi";
$GLOBALS['strBannersHaveBeenDeleted'] = "Tüm seçilen afişler silindi";


$GLOBALS['strWebsitesHaveBeenDeleted'] = "Seçilen tüm web siteleri silindi";

$GLOBALS['strZoneAdvancedHasBeenUpdated'] = "<a href='%s'>%s</a> bölgesi için gelişmiş ayarlar güncellendi";
$GLOBALS['strZoneHasBeenDeleted'] = "<b>%s</b> bölgesi silindi";
$GLOBALS['strZonesHaveBeenDeleted'] = "Seçilen tüm bölgeler silindi";
$GLOBALS['strZoneHasBeenDuplicated'] = "<a href='%s'>%s</a> bölgesi <a href='%s'>%s</a>'e kopyalanmış";
$GLOBALS['strZoneHasBeenMoved'] = "<b>%s</b> bölgesi <b>%s</b> web sitesine taşındı";
$GLOBALS['strZoneLinkedBanner'] = "Reklam bandı <a href='%s'>%s</a> bölgesi ile bağlantılı";
$GLOBALS['strZoneLinkedCampaign'] = "Kampanya <a href='%s'>%s</a> bölgesi ile bağlantılı";


$GLOBALS['strEmailChanged'] = "E-mailiniz değiştirildi";
$GLOBALS['strPasswordChanged'] = "Şifreniz değiştirildi";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "<b>%s</b> güncellendi";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "<b>%s</b> güncellendi";
$GLOBALS['strTZPreferencesWarning'] = "Bununla birlikte, ne kampanya etkinleştirme ve geçerlilik süresi, ne de zaman esaslı banner dağıtım kuralları güncellenemedi. <br/> Yeni saat dilimini kullanmalarını isterseniz bunları elle olarak güncellemeniz gerekecek";

// Report error messages
$GLOBALS['strReportErrorMissingSheets'] = "Rapor için seçilen çalışma kağıdı yok";
$GLOBALS['strReportErrorUnknownCode'] = "Bilinmeyen hata kodu #";

/* ------------------------------------------------------- */
/* Password strength                                       */
/* ------------------------------------------------------- */


if (!isset($GLOBALS['strPasswordScore'])) {
    $GLOBALS['strPasswordScore'] = [];
}



/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyUp'] = "u";
$GLOBALS['keyNextItem'] = ".";
$GLOBALS['keyPreviousItem'] = ",";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch'] = "s";
$GLOBALS['keyCollapseAll'] = "c";
$GLOBALS['keyExpandAll'] = "e";
$GLOBALS['keyAddNew'] = "n";
$GLOBALS['keyNext'] = "n";
$GLOBALS['keyPrevious'] = "p";
$GLOBALS['keyLinkUser'] = "u";
