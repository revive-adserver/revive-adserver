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
$GLOBALS['strInstallStatusRecovery'] = 'Memulihkan kembali AdServer %s';
$GLOBALS['strInstallStatusInstall'] = 'Menginstal menghidupkan kembali Adserver %s';
$GLOBALS['strInstallStatusUpgrade'] = 'Upgrade untuk menghidupkan kembali Adserver %s';
$GLOBALS['strInstallStatusUpToDate'] = 'Terdeteksi menghidupkan kembali Adserver %s';

/** welcome step * */
$GLOBALS['strWelcomeTitle'] = "Selamat datang di {$PRODUCT_NAME}";
$GLOBALS['strInstallIntro'] = "Terima kasih telah memilih {$PRODUCT_NAME}. Wizard ini akan memandu Anda melalui proses instalasi {$PRODUCT_NAME}.";
$GLOBALS['strUpgradeIntro'] = "Terima kasih telah memilih {$PRODUCT_NAME}. Wizard ini akan memandu Anda melalui proses upgrade {$PRODUCT_NAME}.";
$GLOBALS['strInstallerHelpIntro'] = "Untuk membantu Anda dengan proses instalasi {$PRODUCT_NAME}, silakan lihat <a href='{$PRODUCT_DOCSURL}' target='_blank'> dokumentasi</a>.";
$GLOBALS['strTermsIntro'] = "{$PRODUCT_NAME} didistribusikan secara bebas di bawah sebuah lisensi Open Source, GNU General Public License. Harap meninjau dan menyetujui dokumen untuk melanjutkan penginstalan.";

/** check step * */
$GLOBALS['strSystemCheck'] = "Sistem cek";
$GLOBALS['strSystemCheckIntro'] = "Install wizard ditusuk memeriksa pengaturan server web untuk memastikan bahwa proses instalasi dapat menyelesaikan berhasil.                                                   <br>Silakan periksa apapun disorot masalah untuk menyelesaikan proses instalasi.";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Konfigurasi server web Anda tidak memenuhi persyaratan {$PRODUCT_NAME}.
                                                    <br> Untuk melanjutkan pemasangan, perbaiki semua kesalahan.
                                                    Untuk bantuan, lihat <a href='{$PRODUCT_DOCSURL}'> dokumentasi</a> dan <a href='http://{$PRODUCT_URL}/faq'>FAQ</a>kami";

$GLOBALS['strAppCheckErrors'] = "Kesalahan yang ditemukan ketika mendeteksi instalasi sebelumnya {$PRODUCT_NAME}";
$GLOBALS['strAppCheckDbIntegrityError'] = "Kami telah mendeteksi integritas masalah dengan database Anda. Ini berarti bahwa tata letak database Anda berbeda dari apa yang kami harapkan hal itu terjadi. Ini bisa disebabkan oleh penyesuaian database Anda.";

$GLOBALS['strSyscheckProgressMessage'] = "Memeriksa sistem parameter...";
$GLOBALS['strError'] = "Kesalahan";
$GLOBALS['strWarning'] = "Peringatan";
$GLOBALS['strOK'] = "Oke";
$GLOBALS['strSyscheckName'] = "Periksa nama";
$GLOBALS['strSyscheckValue'] = "Nilai saat ini";
$GLOBALS['strSyscheckStatus'] = "Keadaan";
$GLOBALS['strSyscheckSeeFullReport'] = "Tampilkan rinci sistem cek";
$GLOBALS['strSyscheckSeeShortReport'] = "Tampilkan hanya kesalahan dan peringatan";
$GLOBALS['strBrowserCookies'] = 'Kuki peramban';
$GLOBALS['strPHPConfiguration'] = 'Konfigurasi PHP';
$GLOBALS['strCheckError'] = 'kesalahan';
$GLOBALS['strCheckErrors'] = 'kesalahan';
$GLOBALS['strCheckWarning'] = 'peringatan';
$GLOBALS['strCheckWarnings'] = 'peringatan';

/** admin login step * */
$GLOBALS['strAdminLoginTitle'] = "Silahkan login sebagai {$PRODUCT_NAME} administrator";
$GLOBALS['strAdminLoginIntro'] = "Untuk melanjutkan, masukkan informasi login {$PRODUCT_NAME} sistem administrator account.";
$GLOBALS['strLoginProgressMessage'] = 'Logging di...';

/** database step * */
$GLOBALS['strDbSetupTitle'] = "Menyediakan database Anda";
$GLOBALS['strDbSetupIntro'] = "Memberikan rincian untuk koneksi ke {$PRODUCT_NAME} database.";
$GLOBALS['strDbUpgradeTitle'] = "Database Anda telah terdeteksi";
$GLOBALS['strDbUpgradeIntro'] = "Database berikut telah terdeteksi untuk instalasi {$PRODUCT_NAME}.                                                    Silakan memverifikasi bahwa ini benar, kemudian klik \"Lanjutkan\" untuk melanjutkan.";
$GLOBALS['strDbProgressMessageInstall'] = 'Instalasi database...';
$GLOBALS['strDbProgressMessageUpgrade'] = 'Upgrade database...';
$GLOBALS['strDbSeeMoreFields'] = 'Lihat lebih banyak bidang database...';
$GLOBALS['strDbTimeZoneWarning'] = "<p>Pada versi ini {$PRODUCT_NAME} menyimpan tanggal dalam waktu UTC daripada di waktu server.</p>
                                                    <p>Jika Anda ingin statistik historis ditampilkan dengan zona waktu yang benar, tingkatkan data Anda secara manual. Pelajari lebih lanjut <a target='help' href='%s'>di sini</a>.
                                                       Nilai statistik Anda akan tetap akurat meski Anda membiarkan data Anda tidak tersentuh.
                                                   </p>";
$GLOBALS['strDbTimeZoneNoWarnings'] = "Jangan menampilkan zona peringatan di masa depan";
$GLOBALS['strDBInstallSuccess'] = "Database dibuat dengan sukses";
$GLOBALS['strDBUpgradeSuccess'] = "Database upgrade berhasil";

$GLOBALS['strDetectedVersion'] = "Versi terdeteksi {$PRODUCT_NAME}";

/** config step * */
$GLOBALS['strConfigureInstallTitle'] = "Mengkonfigurasi account administrator sistem lokal {$PRODUCT_NAME}";
$GLOBALS['strConfigureInstallIntro'] = "Harap memberikan informasi masukkan login untuk account administrator sistem {$PRODUCT_NAME} lokal.";
$GLOBALS['strConfigureUpgradeTitle'] = "Pengaturan konfigurasi";
$GLOBALS['strConfigureUpgradeIntro'] = "Menyediakan jalur ke instalasi {$PRODUCT_NAME} sebelumnya.";
$GLOBALS['strConfigSeeMoreFields'] = "Lihat lebih banyak konfigurasi bidang...";
$GLOBALS['strPreviousInstallTitle'] = "Instalasi sebelumnya";
$GLOBALS['strPathToPrevious'] = "Path ke instalasi {$PRODUCT_NAME} sebelumnya";
$GLOBALS['strPathToPreviousError'] = "Satu atau lebih file plugin tidak terdeteksi, memeriksa file install.log untuk informasi lebih lanjut";
$GLOBALS['strConfigureProgressMessage'] = "Konfigurasi {$PRODUCT_NAME}...";

/** jobs step * */
$GLOBALS['strJobsInstallTitle'] = "Melakukan tugas-tugas instalasi";
$GLOBALS['strJobsInstallIntro'] = "Installer sekarang adalah melakukan tugas-tugas akhir instalasi.";
$GLOBALS['strJobsUpgradeTitle'] = "Melakukan tugas-tugas upgrade";
$GLOBALS['strJobsUpgradeIntro'] = "Installer sekarang adalah melakukan tugas-tugas upgrade akhir.";
$GLOBALS['strJobsProgressInstallMessage'] = "Menjalankan tugas-tugas instalasi...";
$GLOBALS['strJobsProgressUpgradeMessage'] = "Menjalankan tugas upgrade...";

$GLOBALS['strPluginTaskChecking'] = "Memeriksa Plugin {$PRODUCT_NAME}";
$GLOBALS['strPluginTaskInstalling'] = "Memasang Plugin {$PRODUCT_NAME}";
$GLOBALS['strPostInstallTaskRunning'] = "Menjalankan tugas";

/** finish step * */
$GLOBALS['strFinishInstallTitle'] = "Anda {$PRODUCT_NAME} instalasi selesai.";
$GLOBALS['strFinishUpgradeWithErrorsTitle'] = "Anda {$PRODUCT_NAME} upgrade selesai. Silakan periksa masalah yang disorot.";
$GLOBALS['strFinishUpgradeTitle'] = "Anda {$PRODUCT_NAME} upgrade selesai.";
$GLOBALS['strFinishInstallWithErrorsTitle'] = "Anda {$PRODUCT_NAME} instalasi selesai. Silakan periksa masalah yang disorot.";
$GLOBALS['strDetailedTaskErrorList'] = "Daftar kesalahan terperinci ditemukan";
$GLOBALS['strPluginInstallFailed'] = "Pemasangan plugin \"%s\" gagal:";
$GLOBALS['strTaskInstallFailed'] = "Terjadi kesalahan saat menjalankan tugas instalasi \"%s\":";
$GLOBALS['strContinueToLogin'] = "Klik \"Lanjutkan\" untuk masuk ke instance {$PRODUCT_NAME} Anda.";

$GLOBALS['strUnableCreateConfFile'] = "Kami tidak dapat membuat file konfigurasi Anda. Harap periksa kembali izin dari map var {$PRODUCT_NAME}.";
$GLOBALS['strUnableUpdateConfFile'] = "Kami tidak dapat memperbarui file konfigurasi Anda. Harap periksa kembali izin dari map var {$PRODUCT_NAME}, dan periksa juga izin dari file konfigurasi install sebelumnya yang Anda salin ke dalam folder ini.";
$GLOBALS['strUnableToCreateAdmin'] = "Kami tidak dapat membuat akun administrator sistem, apakah database Anda dapat diakses?";
$GLOBALS['strTimezoneLocal'] = "{$PRODUCT_NAME} telah mendeteksi bahwa penginstalan PHP Anda mengembalikan \"System/Localtime\" sebagai zona waktu server Anda. Ini karena adanya patch untuk PHP yang diterapkan oleh beberapa distro Linux. Sayangnya, ini bukan zona waktu PHP yang valid. Silahkan edit file php.ini anda dan atur properti \"date.timezone\" ke nilai yang benar untuk server anda.";

$GLOBALS['strInstallNonBlockingErrors'] = "Terjadi kesalahan saat melakukan tugas instalasi. Silakan periksa <a class=\"show-errors\" href=\"#\">daftar kesalahan</a> dan pasang log di \\'%s\\' untuk rinciannya. Anda masih dapat masuk ke instance {$PRODUCT_NAME} Anda.";
