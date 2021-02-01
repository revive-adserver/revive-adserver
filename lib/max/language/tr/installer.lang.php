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

/** status messages * */
$GLOBALS['strInstallStatusRecovery'] = 'Recovering Revive Adserver %s';
$GLOBALS['strInstallStatusInstall'] = 'Installing Revive Adserver %s';
$GLOBALS['strInstallStatusUpgrade'] = 'Upgrading to Revive Adserver %s';
$GLOBALS['strInstallStatusUpToDate'] = 'Detected Revive Adserver %s';

/** welcome step * */
$GLOBALS['strWelcomeTitle'] = "{$PRODUCT_NAME} 'e hoş geldiniz";
$GLOBALS['strInstallIntro'] = "{$PRODUCT_NAME} ürününü seçtiğiniz için teşekkür ederiz. Bu sihirbaz, {$PRODUCT_NAME} ürününü yükleme işlemi boyunca size rehberlik edecektir.";
$GLOBALS['strUpgradeIntro'] = "{$PRODUCT_NAME} ürününü seçtiğiniz için teşekkür ederiz. Bu sihirbaz size {$PRODUCT_NAME} ürününü geliştirme süreci boyunca rehberlik edecektir.";
$GLOBALS['strInstallerHelpIntro'] = "To help you with the {$PRODUCT_NAME} installation process, please see the <a href='{$PRODUCT_DOCSURL}' target='_blank'>Documentation</a>.";
$GLOBALS['strTermsIntro'] = "{$PRODUCT_NAME}, bir Açık Kaynak lisansı, GNU Genel Kamu Lisansı uyarınca özgürce dağıtılır. Kuruluma devam etmek için lütfen aşağıdaki belgeleri inceleyin ve kabul edin.";

/** check step * */
$GLOBALS['strSystemCheck'] = "Sistem kontrolü";
$GLOBALS['strSystemCheckIntro'] = "Yükleme sihirbazı, yükleme işleminin başarıyla tamamlanabildiğinden emin olmak için web sunucusu ayarlarınıza yönelik bir kontrol gerçekleştirdi.<br>Yükleme işlemini tamamlamak için lütfen vurguladığınız sorunları kontrol edin.";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Configuration of your webserver does not meet the requirements of the {$PRODUCT_NAME}.
                                                   <br>In order to proceed with installation, please fix all errors.
                                                   For help, please see our <a href='{$PRODUCT_DOCSURL}'>documentation</a> and <a href='http://{$PRODUCT_URL}/faq'>FAQs</a>";

$GLOBALS['strAppCheckErrors'] = "{$PRODUCT_NAME} ürününün önceki kurulumlarını tespit ederken hatalar bulundu";
$GLOBALS['strAppCheckDbIntegrityError'] = "Veritabanınızla ilgili bütünlük sorunları tespit ettik. Bu, veritabanınızın düzeninin beklediğimizden farklı olduğunu gösterir. Bu, veritabanınızın özelleştirilmesinden kaynaklanıyor olabilir.";

$GLOBALS['strSyscheckProgressMessage'] = "Sistem parametreleri denetleniyor...";
$GLOBALS['strError'] = "Hata";
$GLOBALS['strWarning'] = "Uyarı";
$GLOBALS['strOK'] = "Tamam";
$GLOBALS['strSyscheckName'] = "Ismi kontrol et";
$GLOBALS['strSyscheckValue'] = "Şu anki değer";
$GLOBALS['strSyscheckStatus'] = "Durum";
$GLOBALS['strSyscheckSeeFullReport'] = "Ayrıntılı sistem kontrolünü göster";
$GLOBALS['strSyscheckSeeShortReport'] = "Yalnızca hataları ve uyarıları göster";
$GLOBALS['strBrowserCookies'] = 'Tarayıcı Çerezleri';
$GLOBALS['strPHPConfiguration'] = 'PHP Yapılandırması';
$GLOBALS['strCheckError'] = 'hata';
$GLOBALS['strCheckErrors'] = 'hata';
$GLOBALS['strCheckWarning'] = 'uyarı';
$GLOBALS['strCheckWarnings'] = 'uyarı';

/** admin login step * */
$GLOBALS['strAdminLoginTitle'] = "Lütfen {$PRODUCT_NAME} yöneticisi olarak giriş yapın";
$GLOBALS['strAdminLoginIntro'] = "Devam etmek için lütfen {$PRODUCT_NAME} sistem yöneticisi hesabının oturum açma bilgilerinizi girin.";
$GLOBALS['strLoginProgressMessage'] = 'Oturum açılıyor...';

/** database step * */
$GLOBALS['strDbSetupTitle'] = "Provide your database";
$GLOBALS['strDbSetupIntro'] = "Provide the details to connect to your {$PRODUCT_NAME} database.";
$GLOBALS['strDbUpgradeTitle'] = "Veritabanınız tespit edildi";
$GLOBALS['strDbUpgradeIntro'] = "{$PRODUCT_NAME} ürününü yüklediğinizde aşağıdaki veritabanı tespit edildi. Lütfen bunun doğru olduğunu onaylayın ve devam etmek için \"Devam et\" seçeneğini tıklayın.";
$GLOBALS['strDbProgressMessageInstall'] = 'Veritabanı yükleniyor...';
$GLOBALS['strDbProgressMessageUpgrade'] = 'Veritabanı yükseltiliyor...';
$GLOBALS['strDbSeeMoreFields'] = 'See more database fields...';
$GLOBALS['strDbTimeZoneWarning'] = "<p>As of this version {$PRODUCT_NAME} stores dates in UTC time rather than in server time.</p>
                                                   <p>If you want historical statistics to be displayed with the correct timezone, upgrade your data manually.  Learn more <a target='help' href='%s'>here</a>.
                                                      Your statistics values will remain accurate even if you leave your data untouched.
                                                   </p>";
$GLOBALS['strDbTimeZoneNoWarnings'] = "Do not display timezone warnings in the future";
$GLOBALS['strDBInstallSuccess'] = "Veritabanı başarıyla oluşturuldu";
$GLOBALS['strDBUpgradeSuccess'] = "Veritabanı başarıyla yükseltildi";

$GLOBALS['strDetectedVersion'] = "{$PRODUCT_NAME} sürümü tespit edildi";

/** config step * */
$GLOBALS['strConfigureInstallTitle'] = "Configure your local {$PRODUCT_NAME} system administrator account";
$GLOBALS['strConfigureInstallIntro'] = "Lütfen yerel {$PRODUCT_NAME} sistem yönetici hesabınız için istenen oturum açma bilgilerini girin.";
$GLOBALS['strConfigureUpgradeTitle'] = "Yapılandırma Ayarları";
$GLOBALS['strConfigureUpgradeIntro'] = "Önceki {$PRODUCT_NAME} yükleme yolunu belirtin.";
$GLOBALS['strConfigSeeMoreFields'] = "Daha fazla yapılandırma alanına bakın...";
$GLOBALS['strPreviousInstallTitle'] = "Önceki kurulum";
$GLOBALS['strPathToPrevious'] = "Önceki {$PRODUCT_NAME} yükleme yolu";
$GLOBALS['strPathToPreviousError'] = "Bir veya daha fazla eklenti dosyası bulunamadı, daha fazla bilgi için install.log dosyasını kontrol edin";
$GLOBALS['strConfigureProgressMessage'] = "{$PRODUCT_NAME} 'i yapılandırma...";

/** jobs step * */
$GLOBALS['strJobsInstallTitle'] = "Performing installation tasks";
$GLOBALS['strJobsInstallIntro'] = "Installer is now performing final installation tasks.";
$GLOBALS['strJobsUpgradeTitle'] = "Performing upgrade tasks";
$GLOBALS['strJobsUpgradeIntro'] = "Installer is now performing final upgrade tasks.";
$GLOBALS['strJobsProgressInstallMessage'] = "Running installation tasks...";
$GLOBALS['strJobsProgressUpgradeMessage'] = "Running upgrade tasks...";

$GLOBALS['strPluginTaskChecking'] = "Checking {$PRODUCT_NAME} Plugin";
$GLOBALS['strPluginTaskInstalling'] = "Installing {$PRODUCT_NAME} Plugin";
$GLOBALS['strPostInstallTaskRunning'] = "Running task";

/** finish step * */
$GLOBALS['strFinishInstallTitle'] = "{$PRODUCT_NAME} kurulumunuz tamamlandı.";
$GLOBALS['strFinishUpgradeWithErrorsTitle'] = "{$PRODUCT_NAME} güncellemeniz tamamlandı. Lütfen vurgulanan sorunları kontrol edin.";
$GLOBALS['strFinishUpgradeTitle'] = "{$PRODUCT_NAME} güncellemeniz tamamlandı.";
$GLOBALS['strFinishInstallWithErrorsTitle'] = "{$PRODUCT_NAME} kurulumunuz tamamlandı. Lütfen vurgulanan sorunları kontrol edin.";
$GLOBALS['strDetailedTaskErrorList'] = "Bulunan hataların ayrıntılı listesi";
$GLOBALS['strPluginInstallFailed'] = "Eklenti kurulumu \"%s\" başarısız oldu:";
$GLOBALS['strTaskInstallFailed'] = "Error occurred when running installation task \"%s\":";
$GLOBALS['strContinueToLogin'] = "{$PRODUCT_NAME} örneğinize giriş yapmak için \"Devam Et\" i tıklayın.";

$GLOBALS['strUnableCreateConfFile'] = "Yapılandırma dosyanızı oluşturamıyoruz. Lütfen {$PRODUCT_NAME} var klasörünün izinlerini tekrar kontrol edin.";
$GLOBALS['strUnableUpdateConfFile'] = "Yapılandırma dosyanızı güncelleyemiyoruz. Lütfen {$PRODUCT_NAME} var klasörünün izinlerini tekrar kontrol edin ve ayrıca bu klasöre kopyaladığınız önceki kurulumun yapılandırma dosyasının izinlerini kontrol edin.";
$GLOBALS['strUnableToCreateAdmin'] = "Sistem yöneticisi hesabı oluşturamıyoruz, veritabanınız erişilebilir mi?";
$GLOBALS['strTimezoneLocal'] = "{$PRODUCT_NAME}, PHP yüklemenizin sunucunuzun saat dilimi olan \"Sistem / Yerel Zaman\" değerini döndürdüğünü tespit etti. Bu, bazı Linux dağıtımları tarafından uygulanan bir PHP yaması yüzünden.
Ne yazık ki, bu geçerli bir PHP zaman dilimi değil. Lütfen php.ini dosyanızı düzenleyin ve \"date.timezone\" özelliğini sunucunuz için doğru değere ayarlayın.";

$GLOBALS['strInstallNonBlockingErrors'] = "An error occurred when performing installation tasks. Please check the 
<a class=\"show-errors\" href=\"#\">error list</a> and install log at \\'%s\\' for details.
You will still be able to login to your {$PRODUCT_NAME} instance.";
