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
$GLOBALS['strInstallStatusRecovery'] = 'Memulihkan menghidupkan kembali Adserver %s';
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
$GLOBALS['strFixErrorsBeforeContinuing'] = "Konfigurasi server web Anda tidak memenuhi persyaratan dari {$PRODUCT_NAME}.                                                    <br>Untuk melanjutkan dengan instalasi, harap memperbaiki semua kesalahan.                                                    Untuk bantuan, silakan lihat <a href='{$PRODUCT_DOCSURL}'> dokumentasi</a> dan <a href='http://{$PRODUCT_URL}/faq'> FAQ</a> kami";

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
$GLOBALS['strDbTimeZoneWarning'] = "<p>Pada versi ini {$PRODUCT_NAME} toko tanggal waktu UTC daripada waktu server.</p>                                                    <p>Jika Anda ingin sejarah statistik yang akan ditampilkan dengan zona waktu benar, upgrade data secara manual.  Pelajari lebih lanjut <a target='help' href='%s'> di sini</a>.                                                       Nilai-nilai statistik Anda akan tetap akurat bahkan jika Anda meninggalkan data Anda tidak tersentuh.                                                    </p>";
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


/** finish step * */


