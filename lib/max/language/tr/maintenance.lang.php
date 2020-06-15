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
$GLOBALS['strAppendCodes'] = "Append codes";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>Scheduled maintenance hasn't run in the past hour. This may mean that you have not set it up correctly.</b>";

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "	Automatic maintenance is enabled, but it has not been triggered. Automatic maintenance is triggered only when {$PRODUCT_NAME} delivers banners.
    For the best performance, you should set up <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>scheduled maintenance</a>.";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "	Automatic maintenance is currently disabled, so when {$PRODUCT_NAME} delivers banners, automatic maintenance will not be triggered.
	For the best performance, you should set up <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>scheduled maintenance</a>.
    However, if you are not going to set up <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>scheduled maintenance</a>,
    then you <i>must</i> <a href='account-settings-maintenance.php'>enable automatic maintenance</a> to ensure that {$PRODUCT_NAME} works correctly.";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "	Automatic maintenance is enabled and will be triggered, as required, when {$PRODUCT_NAME} delivers banners.
	However, for the best performance, you should set up <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>scheduled maintenance</a>.";

$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "	However, automatic maintenance has recently been disabled. To ensure that {$PRODUCT_NAME} works correctly, you should
	either set up <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>scheduled maintenance</a> or
	<a href='account-settings-maintenance.php'>re-enable automatic maintenance</a>.
	<br><br>
	For the best performance, you should set up <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>scheduled maintenance</a>.";

$GLOBALS['strScheduledMantenaceRunning'] = "<b>Scheduled maintenance is running correctly.</b>";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>Otomatik bakım doğru çalışıyor.</b>";

$GLOBALS['strAutoMantenaceEnabled'] = "Ancak, otomatik bakım hala etkin durumdadır. En iyi performans için <a href='account-settings-maintenance.php'>otomatik bakımı devre dışı bırak</a>malısınız.";

// Priority
$GLOBALS['strRecalculatePriority'] = "Öncelikleri hesapla";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "Check banner cache";
$GLOBALS['strBannerCacheErrorsFound'] = "Veritabanı şeridinin önbellek kontrolü bazı hatalar buldu. Bu afişler elle düzeltene kadar çalışmaz.";
$GLOBALS['strBannerCacheOK'] = "There were no errors detected. Your database banner cache is up to date";
$GLOBALS['strBannerCacheDifferencesFound'] = "Veritabanı afiş önbellek kontrolü, önbelleğinizin güncel olmadığını ve yeniden oluşturulmasını gerektirdiğini tespit etti. Önbelleğinizi otomatik olarak güncellemek için burayı tıklayın.";
$GLOBALS['strBannerCacheRebuildButton'] = "Yeniden oluştur";
$GLOBALS['strRebuildDeliveryCache'] = "Rebuild database banner cache";
$GLOBALS['strBannerCacheExplaination'] = "	Banner hafızası bannerı göstermek için HTML kodlarını içerir. Banner hafızası kullanmanız bannerın her gösteriminde yeniden HTML
	kodu üretmeyeceğinden dolayı görüntülenmesini hızlandırır. Çünkü banner hafızası {$PRODUCT_NAME} programının direk adresini(URL)
	ve bannerı bünyesinde bulundurur.";

// Cache
$GLOBALS['strCache'] = "Delivery cache";
$GLOBALS['strDeliveryCacheSharedMem'] = "Paylaşılan bellek şu anda teslimat önbelleğini saklamak için kullanılmaktadır.";
$GLOBALS['strDeliveryCacheDatabase'] = "Veritabanı şu anda teslimat önbelleklerinin saklanması için kullanılmaktadır.";
$GLOBALS['strDeliveryCacheFiles'] = "Teslim ön belleği şu anda sunucunuzdaki birden çok dosyaya depolanıyor.";

// Storage
$GLOBALS['strStorage'] = "Depolama";
$GLOBALS['strMoveToDirectory'] = "Veritabanında depolanan resimleri bir dizine taşı";
$GLOBALS['strStorageExplaination'] = "Yerel pankartlar tarafından kullanılan resimler veritabanında saklanır veya bir dizinde saklanır. Görüntüleri bir dizine yerleştirirseniz, veritabanındaki yük azaltılacak ve bu hızın artmasına neden olacaktır.";

// Encoding
$GLOBALS['strEncoding'] = "Encoding";
$GLOBALS['strEncodingExplaination'] = "{$PRODUCT_NAME} şimdi tüm verileri veritabanında UTF-8 biçiminde saklar. <br/>
     Mümkün olduğunda verileriniz otomatik olarak bu kodlamaya dönüştürülür. <br/>
     Yükselttikten sonra bozuk karakterler bulursanız ve kullanılan kodlamayı biliyorsanız, verileri bu formattan UTF-8'e dönüştürmek için bu aracı kullanabilirsiniz";
$GLOBALS['strEncodingConvertFrom'] = "Convert from this encoding:";
$GLOBALS['strEncodingConvertTest'] = "Test conversion";
$GLOBALS['strConvertThese'] = "The following data will be changed if you continue";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Güncellemeler kontrol ediliyor. Lütfen bekleyiniz...";
$GLOBALS['strAvailableUpdates'] = "Mevcut ürün güncellemeleri";
$GLOBALS['strDownloadZip'] = "İndir (.zip)";
$GLOBALS['strDownloadGZip'] = "İndir (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "{$PRODUCT_NAME} programının yeni sürümü bulunmaktadır.                 \n\nBu güncelleme ile ilgili daha\nfazla bilgi ister misiniz?";
$GLOBALS['strUpdateAlertSecurity'] = "{$PRODUCT_NAME} programının yeni sürümü bulunmaktadır.                 \n\nBu güncellemeyi yapmanız \ntavsiye ediliyor, çünklü bu sürüm \ngüvenlik problemlerinin onarılmış halini içeriyor.";

$GLOBALS['strUpdateServerDown'] = "Due to an unknown reason it isn't possible to retrieve <br>information about possible updates. Please try again later.";

$GLOBALS['strNoNewVersionAvailable'] = "{$PRODUCT_NAME} sürümünüz güncellenmiş. şu anda mevcut bir güncelleme bulunmuyor.";

$GLOBALS['strServerCommunicationError'] = "    <b> Güncelleme sunucusu ile olan iletişim zaman aşımına uğradı, bu nedenle {$PRODUCT_NAME}, bu aşamada daha yeni bir sürümün mevcut olup olmadığını kontrol edemiyor. Lütfen daha sonra tekrar deneyin. </b>";

$GLOBALS['strCheckForUpdatesDisabled'] = "    <b>Check for updates is disabled. Please enable via the
    <a href='account-settings-update.php'>update settings</a> screen.</b>";

$GLOBALS['strNewVersionAvailable'] = "	<b>{$PRODUCT_NAME} yeni sürümü bulunmaktadır.</b><br> Bu güncellemeyi yüklemenizi tavsiye ederiz.
	Çünkü bu sürüm bazı problemleri çözebilir ve yeni özellikler ekleyebilir. Daha fazla bilgi için
	aşağıdaki dosyada bulunan dökümanları okuyunuz.";

$GLOBALS['strSecurityUpdate'] = "	<b>Bu güncellemeyi yüklemeniz şiddetle tavsiye ediliyor. Çünkü bu sürüm bazı güvenlik açıklarını onarıyor.
	.</b> Kullanmış olduğunuz {$PRODUCT_NAME} sürümü bazı saldırılara açık olabilir. Daha fazla bilgi için
	aşağıdaki dosyada bulunan dökümanları okuyunuz.";

$GLOBALS['strNotAbleToCheck'] = "<b> XML uzantısı sunucunuzda mevcut olmadığından {$PRODUCT_NAME} daha yeni bir sürümün mevcut olup olmadığını kontrol edemiyor. </b>";

$GLOBALS['strForUpdatesLookOnWebsite'] = "Mevcut daha yeni bir sürüm olup olmadığını bilmek istiyorsanız, lütfen web sitemize bir göz atın.";

$GLOBALS['strClickToVisitWebsite'] = "Web sitemizi ziyaret etmek için tıklayın";
$GLOBALS['strCurrentlyUsing'] = "Kullanmakta olduğunuz";
$GLOBALS['strRunningOn'] = "running on";
$GLOBALS['strAndPlain'] = "ve";

//  Deliver Limitations
$GLOBALS['strDeliveryLimitations'] = "Teslimat Kuralları";
$GLOBALS['strAllBannerChannelCompiled'] = "All banner/delivery rule set compiled delivery rule values have been recompiled";
$GLOBALS['strBannerChannelResult'] = "Here are the results of the banner/delivery rule set compiled delivery rule validation";
$GLOBALS['strChannelCompiledLimitationsValid'] = "All compiled delivery rules for delivery rule sets are valid";
$GLOBALS['strBannerCompiledLimitationsValid'] = "Afişler için derlenmiş teslimat kuralları geçerlidir";
$GLOBALS['strErrorsFound'] = "Hatalar bulundu";
$GLOBALS['strRepairCompiledLimitations'] = "Yukarıda bazı tutarsızlıklar bulundu, bunları aşağıdaki düğmeyi kullanarak onarabilirsiniz; bu derlenmiş sınırlamayı sistemdeki her afiş / yayınlama kuralı için derleyecektir <br/>";
$GLOBALS['strRecompile'] = "Recompile";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "Bazı durumlarda dağıtım motoru, afişler ve teslimat kuralı setleri için saklanan teslimat kurallarıyla aynı fikirde olamaz, veritabanındaki teslimat kurallarını doğrulamak için aşağıdaki bağlantıyı kullanın";
$GLOBALS['strCheckACLs'] = "Check delivery rules";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "Bazı durumlarda, teslim motoru izleyiciler için depolanmış ek kodları ile anlaşamaz, veritabanındaki ek kodlarını doğrulamak için aşağıdaki link kullanılır";
$GLOBALS['strCheckAppendCodes'] = "Check Append codes";
$GLOBALS['strAppendCodesRecompiled'] = "All compiled append codes values have been recompiled";
$GLOBALS['strAppendCodesResult'] = "Aşağıda, derlenmiş ek kodlarının doğrulanmasının sonuçları verilmiştir";
$GLOBALS['strAppendCodesValid'] = "All tracker compiled appendcodes are valid";
$GLOBALS['strRepairAppenedCodes'] = "Yukarıda bazı tutarsızlıklar bulundu, bunları aşağıdaki düğmeyi kullanarak onarabilirsiniz, bu sistemdeki her izci için ek kodlarını derleyecektir";

$GLOBALS['strPlugins'] = "Eklentiler";
$GLOBALS['strPluginsPrecis'] = "Diagnose and repair problems with {$PRODUCT_NAME} plugins";

$GLOBALS['strMenus'] = "Menüler";
$GLOBALS['strMenusPrecis'] = "Rebuild the menu cache";
$GLOBALS['strMenusCachedOk'] = "Menu cache has been rebuilt";
