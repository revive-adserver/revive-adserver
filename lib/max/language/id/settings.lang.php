<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                          |
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


//indonesian
// Installer translation strings
$GLOBALS['strInstall']				= "Instal";
$GLOBALS['strChooseInstallLanguage']		= "Silakan pilih bahasa untuk digunakan dalam proses instalasi";
$GLOBALS['strLanguageSelection']		= "Pilihan Bahasa";
$GLOBALS['strDatabaseSettings']			= "Penyetelan Database";
$GLOBALS['strAdminSettings']			= "Penyetelan Administrator";
$GLOBALS['strAdminAccount']                 	= "Administrator Account";
$GLOBALS['strAdministrativeSettings']       	= "Administrative Settings";
$GLOBALS['strAdvancedSettings']			= "Penyetelan Lanjut";
$GLOBALS['strOtherSettings']			= "Penyetelan Lainnya";
$GLOBALS['strSpecifySyncSettings']          	= "Penyetelan Sinkronisasi";
$GLOBALS['strLicenseInformation']           	= "Informasi Lisensi";
$GLOBALS['strOpenadsIdYour']                	= "ID Openads Anda";
$GLOBALS['strOpenadsIdSettings']            	= "Penyetelan ID Openads";
$GLOBALS['strWarning']				= "Peringatan";
$GLOBALS['strFatalError']			= "Telah terjadi Error yang fatal";
$GLOBALS['strUpdateError']			= "Telah terjadi kesalahan pada saat meng-update";
$GLOBALS['strBtnContinue']                  	= "Lanjut &raquo;";
$GLOBALS['strBtnRecover']                   	= "Bangkitkan kembali &raquo;";
$GLOBALS['strBtnStartAgain']                   	= "Ulangi proses upgrade &raquo;";
$GLOBALS['strBtnGoBack']                    	= "&laquo; Kembali";
$GLOBALS['strBtnAgree']                     	= "Saya setuju &raquo;";
$GLOBALS['strBtnDontAgree']                 	= "&laquo; Saya tidak setuju";
$GLOBALS['strBtnRetry']                     	= "Coba kembali";
$GLOBALS['strUpdateDatabaseError']		= "Disebabkan oleh masalah yang tidak jelas update dari struktur database tidak berhasil. Disarankan untuk klick <b>Retry updating</b> untuk mencoba membenarkan masalah ini. Bila Anda yakin bahwa masalah ini tidak akan berpengaruh fungsi-fungsi dari ".$phpAds_productname.", silakan klick <b>Ignore errors</b> untuk melanjutkan. Abaikan masalah ini mampuh untuk mengakibatkan masalah yang serius dan maka dengan itu tidak disarankan!";
$GLOBALS['strAlreadyInstalled']			= "" . MAX_PRODUCT_NAME." telah terinstal di sistem ini. Bila Anda ingin mengubah konfigurasi silakan pindah ke <a href='settings-index.php'>Halaman Konfigurasi</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Koneksi ke database gagal. Mohon periksa ulang penyetelan yang telah dilakukan";
$GLOBALS['strCreateTableTestFailed']		= "Pengguna yang ditentukan oleh Anda tidak memiliki hak untuk membuat atau update struktur dari database. Mohon hubungi administrator database.";
$GLOBALS['strUpdateTableTestFailed']		= "Pengguna yang ditentukan oleh Anda tidak memiliki hak untuk membuat atau update struktur dari database. Mohon hubungi administrator database.";
$GLOBALS['strTablePrefixInvalid']		= "Prefix dari tabel mengandung karakter yang tidak valid";
$GLOBALS['strTableInUse']			= "Database yang dipilih oleh Anda telah digunakan untuk ".$phpAds_productname.". Mohon gunakan prefix tabel yang berbeda atau bacalah buku pemandu untuk mengetahui instruksi Upgrade.";
$GLOBALS['strNoVersionInfo']                	= "Tidak dapat memilih versi database";
$GLOBALS['strInvalidVersionInfo']           	= "Versi database tidak dapat diketahui";
$GLOBALS['strInvalidMySqlVersion']          	= "" . MAX_PRODUCT_NAME." butuh versi MySQL 4.0 atau versi yang lebih baru untuk berfungsi dengan baik. Mohon pilih server database yang lain.";
$GLOBALS['strTableWrongType']			= "Jenis tabel yang dipilih tidak didukung oleh instalasi Anda dari ".$phpAds_dbmsname;
$GLOBALS['strMayNotFunction']			= "Sebelum Anda lanjut mohon perbaiki masalah berikut:";
$GLOBALS['strFixProblemsBefore']            	= "Masalah berikut ini perlu diatasi terlebih dulu sebelum ".MAX_PRODUCT_NAME." dapat di-instal. Bila ada pertanyaan tentang Error Message ini silakan belajari dokumentasi <i>Administrator Guide</i> yang Anda telah ikut download dengan program ini.";
$GLOBALS['strFixProblemsAfter']             	= "Bila Anda tidak dapat memperbaiki masalah yang diuraikan diatas ini silakan hubungi Administrator dari server yang digunakan untuk meng-instal ".MAX_PRODUCT_NAME.". Adiministrator dari Server mungkin dapat menolong Anda.";
$GLOBALS['strIgnoreWarnings']			= "Abaikan Peringatan";
$GLOBALS['strFixErrorsBeforeContinuing']    	= "Mohon perbaiki semua kesalahan sebelum Anda lanjut.";
$GLOBALS['strWarningDBavailable']		= "Versi PHP yang digunakan oleh Anda tidak mendukung koneksi ke database server ".$phpAds_dbmsname.". Anda perlu mengaktifkan ekstensi PHP ".$phpAds_dbmsname." sebelum melanjutkan.";

$GLOBALS['strWarningPHPversion']		= "" . MAX_PRODUCT_NAME." membutuhkan PHP versi PHP 4.0 atau lebih tinggi untuk berfungsi dengan baik. Pada saat ini Anda mengunakan {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "Variabel register_globals dalam konfigurasi PHP perlu diubah ke posisi ON.";
$GLOBALS['strWarningRegisterArgcArv']       	= "Variabel register_argc_argv dalam konfigurasi PHP harus berada dalam posisi ON untuk jalankan pemeliharaan dari Command Line.";
$GLOBALS['strWarningMagicQuotesGPC']		= "Variabel magic_quotes_gpc dalam konfigurasi perlu diubah ke posisi ON.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "Variabel magic_quotes_runtime dalam konfigurasi perlu diubah ke posisi OFF.";
$GLOBALS['strWarningFileUploads']		= "Variabel file_uploads dalam konfigurasi perlu diubah ke posisi ON.";
$GLOBALS['strWarningTrackVars']			= "Variabel track_vars dalam konfigurasi perlu diubah ke posisi ON.";
$GLOBALS['strWarningPREG']			= "Versi PHP yang digunakan oleh Anda tidak mendukung PERL compatible regular expressions. Anda perlu mengaktifkan ekstensi PREG sebelum melanjutkan.";
$GLOBALS['strConfigLockedDetected']		= "" . MAX_PRODUCT_NAME." telah deteksi bahwa file <b>config.inc.php</b> tidak bisa ditulis oleh server.<br> Anda tidak bisa melanjutkan sebelum hak terhadap file tersebut belum diubah. <br>Silakan belajari dokumentasi yang berkaitan bila Anda belum memahaminya.";
$GLOBALS['strCantUpdateDB']  			= "Pada saat ini update database tidak bisa dilakukan. Bila Anda tetap memutuskan untuk melanjutkan, seluruh banner, statistik dan pemasang iklan akan terhapus.";
$GLOBALS['strIgnoreErrors']			= "Abaikan Error";
$GLOBALS['strRetryUpdate']			= "Coba ulang meng-update";
$GLOBALS['strTableNames']			= "Nama Tabel";
$GLOBALS['strTablesPrefix']			= "Prefix Nama Tabel";
$GLOBALS['strTablesType']			= "Jenis Tabel";

$GLOBALS['strInstallWelcome']			= "Selamat Datang di ".MAX_PRODUCT_NAME;
$GLOBALS['strInstallMessage']			= "Sebelum Anda dapat gunakan ".MAX_PRODUCT_NAME.", program ini perlu dikonfigurasikan dan <br> database perlu dibuat. Silakan klik <b>Lanjut</b> untuk melanjut.";
$GLOBALS['strInstallIntro']                 	= "Selamat Datang di <a href='http://".MAX_PRODUCT_URL."' target='_blank'><strong>".MAX_PRODUCT_NAME."</strong></a>! Segera Anda akan menjadi bagian dari komunitas Ad-Space terbesar di internet.
<p>Kami berusaha keras untuk membuat proses instalasi semudah mungkin. Silakan ikuti pedoman instalasi pada layar Anda. Bila Anda membutuhkan pertolongan mohon gunakan referensi di <a href='http://".MAX_PRODUCT_DOCSURL."' target='_blank'><strong>documentation</strong></a>.</p>
<p>Bila masih ada pertanyaan yang belum terjawab dalam dokumentasi silakan kunjungi bagian <a href='http://".MAX_PRODUCT_URL."/support/overview.html' target='_blank'><strong>support</strong></a> pada website kami dan <a href='http://".MAX_PRODUCT_FORUMURL."' target='_blank'><strong>Forum Komunitas</strong></a>.</p>
<p>Terima kasih Anda telah memilih Openads.</p>";
$GLOBALS['strRecoveryRequiredTitle']    	= "Proses upgrade semula mengalami sebuah Error";
$GLOBALS['strRecoveryRequired']         	= "Telah terjadi sebuah Error pada saat memproses upgrade yang sebelumnya dan Openads perlu membangkitkan proses upgrade terlebih dahulu. Mohon klik tombol Bangkitkan dibawah.";
$GLOBALS['strTermsTitle']               	= "Informasi Lisensi";
$GLOBALS['strTermsIntro']               	= "" . MAX_PRODUCT_NAME . " adalah sebuah open source adserver yang bebas dan didistribusikan dibawah lisensi GPL. Mohon lisensi tsb. dibelajari dan disetujui sebelum melanjutkan instalasi.";
$GLOBALS['strPolicyTitle']               	= "Ketentuan privasi dan pengunaan data";
$GLOBALS['strPolicyIntro']               	= "Mohon belajari Ketentuan privasi dan pengunaan data sebelum disetujui dan melanjut instalasi.";
$GLOBALS['strDbSetupTitle']               	= "Setup Database";
$GLOBALS['strDbSetupIntro']               	= "" . MAX_PRODUCT_NAME . " gunakan database MySQL untuk menyimpan semua data.  Mohon isi alamat dari server Anda berikut nama dari database, nama pengguna dan kata sandi. Bila Anda tidak hapal tentang data yang dibutuhkan disini mohon menghubungi Administrator dari server Anda.";
$GLOBALS['strDbUpgradeIntro']             	= "Dibawah ini dicantumkan perincian dari database yang terdeteksi untuk instalasi " . MAX_PRODUCT_NAME . ". Mohon diyakini kebenaran dari perincian tsb. terlebih dahulu sebelum melanjut. Setelah Anda klik Lanjut, " . MAX_PRODUCT_NAME . " akan melanjut dan melakukan upgrade terhadap data Anda. Mohon dipastikan bahwa Anda sudah memiliki backup dari seluruh data Anda sebelum melanjut.";

$GLOBALS['strOaUpToDate']               	= "Database dan struktur file dari Openads sudah menggunakan versi yang terbaru. Maka dengan itu upgrade untuk sementara waktu tidak diperlukan. Mohon klik Lanjut untuk diantar ke panel administrasi dari Openads.";
$GLOBALS['strOaUpToDateCantRemove']     	= "Perhatian: File UPGRADE masih berada dalam direktori var. Kami tidak dapat menghapus file tersebut disebabkan oleh permission yang tidak cukup. Mohon hapuskan file tersebut secara manual.";
$GLOBALS['strRemoveUpgradeFile']               	= "Anda harus menghapus file UPGRADE dari direktori var.";
$GLOBALS['strInstallSuccess']               	= "<strong>Selamat! Anda telah berhasil menginstal program Openads</strong>
<p>Selamat datang di komunitas Openads! Untuk memperlancar penggunaan aplikasi Openads masih tertinggal dua langkah lagi yang perlu ditempuhkan.</p>

<p><strong>Maintenance</strong><br>
Openads telah dikonfigurasikan untuk menjalankan berberapa tugas pemeliharaan pada setiap jam selama melayani penyediaan iklan. Untuk memperlancar penyampaian Anda dapat menyetel proses ini untuk memanggil file pemeliharaan secara otomatis pada setiap jam (seumpamana dengan sebuah cron job). Hal ini tidak diwajibkan tetapi sangat disarankan. Untuk informasi lebih lanjut silakan belajari dokumentasi pada <a href='http://".MAX_PRODUCT_DOCSURL."' target='_blank'><strong>documentation</strong></a>.</p>

<p><strong>Security</strong><br>
Instalasi Openads membutuhkan file konfigurasi yang dapat ditulis/diubah oleh server. Segera setelah Anda melakukan perubahan pada file konfigurasi tersebut kami anjurkan dengan tegas untuk ubah permission dari file konigurasi menjadi read-only untuk mencapai tingkat keamanan yang tinggi. Untuk informasi lebih lanjut silakan belajari pedoman tentang hal ini pada <a href='http://".MAX_PRODUCT_DOCSURL."' target='_blank'><strong>documentation</strong></a>.</p>

<p>Anda sudah siap untuk menggunakan aplikasi Openads. Klik Lanjut akan mengantar Anda ke versi terbaru dari Openads.</p>
<p>Sebelum Anda mulai menggunakan Openads kami sarankan untuk me-review penyetelan konfigurasi dari aplikasi yang dapat ditemukan pada bagian \"Penyetelan\".";
$GLOBALS['strInstallNotSuccessful']         	= "<b>Instalasi ".MAX_PRODUCT_NAME." tidak berhasil</b><br /><br />Ada berberapa bagian dari proses instalasi yang tidak dapat diselesaikan.
                                                Ada kemungkinan bahwah masal ini hanya bersifat sementara saja. Bila memang begitu Anda dapat mengklik <b>Lanjut</b> untuk diantar kembali ke
                                                langka pertama dari proses instalasi. Bila Anda ingin mengetahui secara lebih mendalam tentang Error Message dibawah ini dan caranya untuk mengatasi masalah ini,
                                                silakan belajari kembali pedoman aplikasi yang disediakan.";
$GLOBALS['strSystemCheck']                  	= "Periksa sistem";
$GLOBALS['strSystemCheckIntro']             	= "" . MAX_PRODUCT_NAME . " memerlukan berberapa persyaratan dasar yang harus dipenuhi terlebih dahulu dan hal ini akan diperiksa segera. Kami akan memberitahukan kepada Anda bila ada penyetelan yang harus diubah.";
$GLOBALS['strDbSuccessIntro']               	= "Database untuk ".MAX_PRODUCT_NAME ." berhasil dibuat. Silakan klik tombol 'Lanjut' untuk mengatur konfigurasi Administrator dari Openads dan penyetelan penyampaian iklan.";
$GLOBALS['strDbSuccessIntroUpgrade']        	= "Database untuk ".MAX_PRODUCT_NAME ." berhasil di-update. Silakan klik tombol 'Lanjut' untuk me-review " . MAX_PRODUCT_NAME . " Penyetelan Administrator dan Penyampaian iklan.";
$GLOBALS['strErrorOccured']                 	= "Error yang dialami sbb.:";
$GLOBALS['strErrorInstallDatabase']         	= "Struktur database gagal dibangun.";
$GLOBALS['strErrorInstallPrefs']            	= "Preferensi pengguna Administrator gagal ditulis dalam database.";
$GLOBALS['strErrorInstallVersion']          	= "Nomor versi dari ".MAX_PRODUCT_NAME ." gagal ditulis dalam database.";
$GLOBALS['strErrorUpgrade']                 	= "Instalasi dari database yang sudah ada gagal di-upgrade.";
$GLOBALS['strErrorInstallDbConnect']        	= "Gagal membuka koneksi ke database.";

$GLOBALS['strErrorWritePermissions']        	= "Error pada File permission terdeteksi. Masalah ini harus diperbaiki terlebih dahulu sebelum melanjut.<br />To fix the errors on a Linux system, try typing in the following command(s):";
$GLOBALS['strErrorFixPermissionsCommand']   	= "<i>chmod -R a+w %s</i>";
$GLOBALS['strErrorWritePermissionsWin']     	= "Error pada File permission terdeteksi. Masalah ini harus diperbaiki terlebih dahulu sebelum melanjut.";
$GLOBALS['strCheckDocumentation']           	= "Pertolongan untuk mengatasi masalah ini dapat ditemukan pada <a href=\"http://".MAX_PRODUCT_DOCSURL."\">Dokumentasi Openads/>.";

$GLOBALS['strAdminUrlPrefix']               	= "URL tampilan untuk Admin";
$GLOBALS['strDeliveryUrlPrefix']            	= "URL tampilan untuk mesin penyampaian iklan";
$GLOBALS['strDeliveryUrlPrefixSSL']         	= "URL tampilan untuk mesin penyampaian iklan (SSL)";
$GLOBALS['strImagesUrlPrefix']              	= "URL penyimpanan gambar";
$GLOBALS['strImagesUrlPrefixSSL']           	= "URL penyimpanan gambar (SSL)";

$GLOBALS['strInvalidUserPwd']						= "Nama Pengguna atau Kata Sandi tidak benar";

$GLOBALS['strUpgrade']								= "Upgrade";
$GLOBALS['strSystemUpToDate']						= "Sistem Anda sudah aktual. Upgrade pada saat ini tidak diperlukan. <br>Klik <b>Lanjut</b> untuk melanjut ke halaman muka.";
$GLOBALS['strSystemNeedsUpgrade']					= "Struktur database dan file konfigurasi perlu di-upgrade untuk berfungsi dengan baik. Klik <b>Lanjut</b> untuk memulai proses upgrade. <br><br>Tergantung pada versi yang di-upgrade dan pada jumlah statistik yang telah tersimpan pada database, proses ini dapat mengakibatkan beban yang tinggi pada database server. Mohon sabar, proses upgrade membutuhkan waktu berberapa menit.";
$GLOBALS['strSystemUpgradeBusy']					= "Upgrade sistem dalam proses, silakan tunggu...";
$GLOBALS['strSystemRebuildingCache']				= "Bangun ulang cache, silakan tunggu...";
$GLOBALS['strServiceUnavalable']					= "Fasilitas tidak tersedia. Upgrade sistem dalam proses";

/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']						 = "Pilih Bagian";
$GLOBALS['strEditConfigNotPossible']   				 = " Perubahan tidak dapat dilakukan sehubungan file konfigurasi dikunci berdasarkan keamanan. ".
										  "Bila Anda ingin melakukan perubahan, silakan buka kembali file config.inc.php terlebih dahulu.";
$GLOBALS['strEditConfigPossible']					 = "File konfigurasi dapat diubah sehubungan file tersebut tidak dikunci. Penyetelan ini berbahaya dalam segi sekuriti. ".
										  "Bila Anda ingin mengamankan sistem, Anda perlu mengunci kembali file config.inc.php.";
$GLOBALS['strUnableToWriteConfig']              	 = "Gagal menulis perubahan pada config file";
$GLOBALS['strUnableToWritePrefs']               	 = "Gagal mengirim preferensi kepada database";
$GLOBALS['strImageDirLockedDetected']	        	 = "<b>Direktori Gambar</b> yang diberikan tidak bisa ditulis oleh server. <br>Anda tidak dapat melanjut sebelum permissions dari direktori tersebut diubah atau direktori tersebut dibuatkan.";

// Configuration Settings
$GLOBALS['strConfigurationSetup']                    = 'Setup konfigurasi';
$GLOBALS['strConfigurationSettings']                 = 'Penyetelan konfigurasi';

// Administrator Settings
$GLOBALS['strAdministratorSettings']                 = 'Penyetelan Administrator';
$GLOBALS['strAdministratorAccount']                  = 'Account Administrator';
$GLOBALS['strLoginCredentials']                      = 'Data Login';
$GLOBALS['strAdminUsername']                         = 'Nama pengguna Administrator';
$GLOBALS['strAdminPassword']                         = 'Kata sandi Administrator';
$GLOBALS['strInvalidUsername']                       = 'Nama pengguna tidak berlaku';
$GLOBALS['strBasicInformation']                      = 'Informasi dasar';
$GLOBALS['strAdminFullName']                         = 'Nama lengkap Admin';
$GLOBALS['strAdminEmail']                            = 'Alamat E-Mail Admin';
$GLOBALS['strAdministratorEmail']                    = 'Alamat E-Mail Administrator';
$GLOBALS['strCompanyName']                           = 'Nama perusahaan';
$GLOBALS['strAdminCheckUpdates']                     = 'Cari Update';
$GLOBALS['strAdminCheckEveryLogin']                  = 'Setiap Login';
$GLOBALS['strAdminCheckDaily']                       = 'Setiap hari';
$GLOBALS['strAdminCheckWeekly']                      = 'Setiap minggu';
$GLOBALS['strAdminCheckMonthly']                     = 'Setiap bulan';
$GLOBALS['strAdminCheckNever']                       = 'tidak samasekali';
$GLOBALS['strAdminNovice']                           = 'Aksi menghapus oleh Admin diwajibkan untuk mengkonfirmasi terlebih dahulu demi keamanan';
$GLOBALS['strUserlogEmail']                          = 'Catat seluruh E-Mail yang dikirim';
$GLOBALS['strEnableDashboard']                       = "Aktifkan Dashboard";
$GLOBALS['strTimezoneInformation']                   = "Informasi zona waktu (perubahan akan mempengaruhi data statistik)";
$GLOBALS['strTimezone']                              = "Zona waktu";
$GLOBALS['strTimezoneEstimated']                     = "Perkiraan zona waktu";
$GLOBALS['strTimezoneGuessedValue']                  = "Zona waktu pada PHP tidak distel dengan benar";
$GLOBALS['strTimezoneSeeDocs']                       = "Silakan belajari %DOCS% tentang caranya mengatur variabel ini pada PHP.";
$GLOBALS['strTimezoneDocumentation']                 = "dokumentasi";
$GLOBALS['strLoginSettingsTitle']                    = "Login Administrator";
$GLOBALS['strLoginSettingsIntro']                    = "Untuk menjalankan proses upgrade silakan masukkan data login Administrator dari " . MAX_PRODUCT_NAME . ". Anda diwajibkan untuk login sebagai Administrator untuk menjalankan proses upgrade.";
$GLOBALS['strAdminSettingsTitle']                    = "Akun Administrator Anda";
$GLOBALS['strAdminSettingsIntro']                    = "Akun Administrator digunakan untuk login ke tampilan " . MAX_PRODUCT_NAME . " dan untuk mengatur inventori, statistik dan membuat tags. Silakan masukkan nama pengguna, kata sandi dan alamat E-Mail Administrator.";
$GLOBALS['strConfigSettingsIntro']                   = "Silakan periksa kembali penyetelan konfigurasi yang berikut ini dengan teliti, sehubungan penyetelan ini sangat penting untuk penggunaan dan performa aplikasi " . MAX_PRODUCT_NAME;

$GLOBALS['strEnableAutoMaintenance']	             = "Bila jadwal untuk pemeliharaan tidak di-set pada Cron, jalankan pemeliharaan dengan cara otomatis pada saat penyampaian iklan";

// Openads ID Settings
$GLOBALS['strOpenadsUsername']                       = "" . MAX_PRODUCT_NAME . " Nama Pengguna";
$GLOBALS['strOpenadsPassword']                       = "" . MAX_PRODUCT_NAME . " Kata Sandi";
$GLOBALS['strOpenadsEmail']                          = "" . MAX_PRODUCT_NAME . " Alamat E-Mail";

// Banner Settings
$GLOBALS['strBannerSettings']                        = 'Penyetelan Banner';
$GLOBALS['strDefaultBanners']                        = 'Banner anggapan';
$GLOBALS['strDefaultBannerUrl']                      = 'URL gambar anggapan';
$GLOBALS['strDefaultBannerDestination']              = 'Tujuan URL anggapan';
$GLOBALS['strAllowedBannerTypes']                    = 'Jenis banner yang diizinkan';
$GLOBALS['strTypeSqlAllow']                          = 'Izinkan banner lokal SQL';
$GLOBALS['strTypeWebAllow']                          = 'Izinkan banner lokal dari Webserver';
$GLOBALS['strTypeUrlAllow']                          = 'Izinkan banner eksternal';
$GLOBALS['strTypeHtmlAllow']                         = 'Izinkan banner HTML';
$GLOBALS['strTypeTxtAllow']                          = 'Izinkan Text Ads';
$GLOBALS['strTypeHtmlSettings']                      = 'Preferensi banner HTML';
$GLOBALS['strTypeHtmlAuto']                          = 'Mengubah banner HTML secara otomatis untuk memaksakan pelacakan Klik (Click Tracking)';
$GLOBALS['strTypeHtmlPhp']                           = 'Izinkan eksekusi ekspresi PHP dari dalam banner HTML';

// Database Settings
$GLOBALS['strDatabaseSettings']						 = "Penyetelan Database";
$GLOBALS['strDatabaseServer']						 = "Database Server";
$GLOBALS['strDbLocal']								 = "Koneksi ke server lokal dengan menggunakan socket"; // Pg only
$GLOBALS['strDbType']                           	 = "Jenis Database";
$GLOBALS['strDbHost']								 = "Hostname Database";
$GLOBALS['strDbPort']								 = "Port Number Database";
$GLOBALS['strDbUser']								 = "Pengguna Database";
$GLOBALS['strDbPassword']							 = "Kata Sandi Database";
$GLOBALS['strDbName']								 = "Nama Database";
$GLOBALS['strDatabaseOptimalisations']				 = "Optimalisasi Database";
$GLOBALS['strPersistentConnections']				 = "Gunakan Koneksi Persistent";
$GLOBALS['strCantConnectToDb']						 = "Koneksi ke Database gagal";
$GLOBALS['strDemoDataInstall']                  	 = "Instal data Demo";
$GLOBALS['strDemoDataIntro']                    	 = 'Setup anggapan dapat diangkat ke " . MAX_PRODUCT_NAME . " untuk menolong Anda melayani periklanan secara online. Jenis banner yang paling umum berikut berberapa kampanye awal dapat diangkat dan dikonfigurasikan mula. Hal ini sangat disarankan untuk setiap instalasi baru.';

// Debug Logging Settings
$GLOBALS['strDebugSettings']                         = 'Debug Logging';
$GLOBALS['strDebug']                                 = 'Penyetelan Global Debug Logging';
$GLOBALS['strProduction']                            = 'Production server';
$GLOBALS['strEnableDebug']                           = 'Aktifkan Debug Logging';
$GLOBALS['strDebugMethodNames']                      = 'Mencakupkan nama metode pada debug log';
$GLOBALS['strDebugLineNumbers']                      = 'Mencakupkan nomor garis pada debug log';
$GLOBALS['strDebugType']                             = 'Jenis Debug Log';
$GLOBALS['strDebugTypeFile']                         = 'File';
$GLOBALS['strDebugTypeMcal']                         = 'mCal';
$GLOBALS['strDebugTypeSql']                          = 'SQL Database';
$GLOBALS['strDebugTypeSyslog']                       = 'Syslog';
$GLOBALS['strDebugName']                             = 'Debug Log Name, Calendar, SQL Table,<br />atau Syslog Facility';
$GLOBALS['strDebugPriority']                         = 'Debug Priority Level';
$GLOBALS['strPEAR_LOG_DEBUG']                        = 'PEAR_LOG_DEBUG - Most Information';
$GLOBALS['strPEAR_LOG_INFO']                         = 'PEAR_LOG_INFO - Informasi anggapan';
$GLOBALS['strPEAR_LOG_NOTICE']                       = 'PEAR_LOG_NOTICE';
$GLOBALS['strPEAR_LOG_WARNING']                      = 'PEAR_LOG_WARNING';
$GLOBALS['strPEAR_LOG_ERR']                          = 'PEAR_LOG_ERR';
$GLOBALS['strPEAR_LOG_CRIT']                         = 'PEAR_LOG_CRIT';
$GLOBALS['strPEAR_LOG_ALERT']                        = 'PEAR_LOG_ALERT';
$GLOBALS['strPEAR_LOG_EMERG']                        = 'PEAR_LOG_EMERG - Least Information';
$GLOBALS['strDebugIdent']                            = 'Debug Identification String';
$GLOBALS['strDebugUsername']                         = 'mCal, SQL Server Username';
$GLOBALS['strDebugPassword']                         = 'mCal, SQL Server Password';

// Delivery Settings
$GLOBALS['strDeliverySettings']						 = "Penyetelan Penyampaian";
$GLOBALS['strWebPath']                               = 'Global ' . MAX_PRODUCT_NAME . ' Server Access Paths';
$GLOBALS['strWebPathSimple']                         = 'Lintasan Web';
$GLOBALS['strDeliveryPath']                          = 'Lintasan penyampaian';
$GLOBALS['strImagePath']                             = 'Lintasan gambar';
$GLOBALS['strDeliverySslPath']                       = 'Lintasan SSL penyampaian';
$GLOBALS['strImageSslPath']                          = 'Lintasan SSL gambar';
$GLOBALS['strImageStore']                            = 'Folder gambar';
$GLOBALS['strTypeWebSettings']                       = 'Global Webserver Local Banner Storage Settings';
$GLOBALS['strTypeWebMode']                           = 'Metode Penyimpanan';
$GLOBALS['strTypeWebModeLocal']                      = 'Direktori lokal';
$GLOBALS['strTypeDirError']                          = 'The local directory cannot be written to by the web server';
$GLOBALS['strTypeWebModeFtp']                        = 'Server FTP eksternal';
$GLOBALS['strTypeWebDir']                            = 'Direktori lokal';
$GLOBALS['strTypeFTPHost']                           = 'Host FTP';
$GLOBALS['strTypeFTPDirectory']                      = 'Direktori Host';
$GLOBALS['strTypeFTPUsername']                       = 'Login';
$GLOBALS['strTypeFTPPassword']                       = 'Kata Sandi';
$GLOBALS['strTypeFTPPassive']                        = 'Gunakan FTP pasif';
$GLOBALS['strTypeFTPErrorDir']                       = 'Direktori dari hosti FTP tidak ada';
$GLOBALS['strTypeFTPErrorConnect']                   = 'Koneksi ke server FTP gagal. Nama login atau kata sandi salah';
$GLOBALS['strTypeFTPErrorHost']                      = 'Hosti FTP yang dipilih salah';
$GLOBALS['strDeliveryFilenames']                     = 'Nama-nama file dari Penyampaian Global';
$GLOBALS['strDeliveryFilenamesAdClick']              = 'Ad Click';
$GLOBALS['strDeliveryFilenamesAdConversionVars']     = 'Ad Conversion Variables';
$GLOBALS['strDeliveryFilenamesAdContent']            = 'Ad Content';
$GLOBALS['strDeliveryFilenamesAdConversion']         = 'Ad Conversion';
$GLOBALS['strDeliveryFilenamesAdConversionJS']       = 'Ad Conversion (JavaScript)';
$GLOBALS['strDeliveryFilenamesAdFrame']              = 'Ad Frame';
$GLOBALS['strDeliveryFilenamesAdImage']              = 'Ad Image';
$GLOBALS['strDeliveryFilenamesAdJS']                 = 'Ad (JavaScript)';
$GLOBALS['strDeliveryFilenamesAdLayer']              = 'Ad Layer';
$GLOBALS['strDeliveryFilenamesAdLog']                = 'Ad Log';
$GLOBALS['strDeliveryFilenamesAdPopup']              = 'Ad Popup';
$GLOBALS['strDeliveryFilenamesAdView']               = 'Ad View';
$GLOBALS['strDeliveryFilenamesXMLRPC']               = 'XML RPC Invocation';
$GLOBALS['strDeliveryFilenamesLocal']                = 'Invokasi lokal';
$GLOBALS['strDeliveryFilenamesFrontController']      = 'Kontrol depan';
$GLOBALS['strDeliveryFilenamesFlash']                = 'Pencakupan Flash (Alamat URL lengkap diizinkan)';
$GLOBALS['strDeliveryCaching']                       = 'Penyetelan global untuk caching penyampaian';
$GLOBALS['strDeliveryCacheEnable']                   = 'Aktifkan caching untuk penyampaian';
$GLOBALS['strDeliveryCacheType']                     = 'Jenis cache penyampaian';
$GLOBALS['strCacheFiles']                            = 'File';
$GLOBALS['strCacheDatabase']                         = 'Database';
$GLOBALS['strDeliveryCacheLimit']                    = 'Time Between Cache Updates (seconds)';

$GLOBALS['strOrigin']                                = 'Gunakan server muasal remote';
$GLOBALS['strOriginType']                            = 'Jenis server muasal';
$GLOBALS['strOriginHost']                            = 'Nama host dari server muasal';
$GLOBALS['strOriginPort']                            = 'Nomor port dari database muasal';
$GLOBALS['strOriginScript']                          = 'Script file for origin database';
$GLOBALS['strOriginTypeXMLRPC']                      = 'XMLRPC';
$GLOBALS['strOriginTimeout']                         = 'Origin timeout (seconds)';
$GLOBALS['strOriginProtocol']                        = 'Origin server protocol';

$GLOBALS['strDeliveryBanner']                        = 'Penyetelan global penyampaian banner';
$GLOBALS['strDeliveryAcls']                          = 'Evaluasikan limitasi dari penyampaian banner pada saat penyampaian';
$GLOBALS['strDeliveryObfuscate']                     = 'Mengkaburkan saluran pada saat penyampaian iklan';
$GLOBALS['strDeliveryExecPhp']                       = 'Izinkan eksekusi kode PHP dalam iklan<br />(Perhatian: Resiko Keamanan)';
$GLOBALS['strDeliveryCtDelimiter']                   = '3rd Party Click Tracking Delimiter';
$GLOBALS['strP3PSettings']                           = 'Kebijaksanaan keleluasaan pribadi global P3P';
$GLOBALS['strUseP3P']                                = 'Gunakan kebijaksanaan P3P';
$GLOBALS['strP3PCompactPolicy']                      = 'P3P Compact Policy';
$GLOBALS['strP3PPolicyLocation']                     = 'Lokasi dari kebijaksanaan P3P';

// General Settings
$GLOBALS['generalSettings']                          = 'Penyetelan Global Umum';
$GLOBALS['uiEnabled']                                = 'Interface untuk pengguna diaktifkan';
$GLOBALS['defaultLanguage']                          = 'Anggapan Bahasa yang digunakan<br />(Setiap pengguna dapat memilih bahasa yang diinginkan)';
$GLOBALS['requireSSL']                               = 'Paksakan penggunaan SSL pada interface Pengguna';
$GLOBALS['sslPort']                                  = 'Port SSL yang digunakan oleh Web Server';

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings']                  = 'Geotargeting Settings';
$GLOBALS['strGeotargeting']                          = 'Penyetelan Global Geotargeting';
$GLOBALS['strGeotargetingType']                      = 'Jenis modul Geotargeting';
$GLOBALS['strGeotargetingGeoipCountryLocation']      = 'Lokasi dari database MaxMind GeoIP Country<br />(Tinggalkan kosong untuk menggunakan free database)';
$GLOBALS['strGeotargetingGeoipRegionLocation']       = 'Lokasi dari database MaxMind GeoIP Region';
$GLOBALS['strGeotargetingGeoipCityLocation']         = 'Lokasi dari database MaxMind GeoIP City';
$GLOBALS['strGeotargetingGeoipAreaLocation']         = 'Lokasi dari database MaxMind GeoIP Area';
$GLOBALS['strGeotargetingGeoipDmaLocation']          = 'Lokasi dari database MaxMind GeoIP DMA';
$GLOBALS['strGeotargetingGeoipOrgLocation']          = 'Lokasi dari database MaxMind GeoIP Organisation';
$GLOBALS['strGeotargetingGeoipIspLocation']          = 'Lokasi dari database MaxMind GeoIP ISP';
$GLOBALS['strGeotargetingGeoipNetspeedLocation']     = 'Lokasi dari database MaxMind GeoIP Netspeed';
$GLOBALS['strGeoSaveStats']                          = 'Simpan data dari GeoIP dalam database log';
$GLOBALS['strGeoShowUnavailable']                    = 'Tampilkan limitasi penyampaian dari geotargeting meskipun data GeoIP tidak tersedia';
$GLOBALS['strGeotrackingGeoipCountryLocationError']  = 'Database MaxMind GeoIP Country tidak ditemukan pada lokasi yang ditunjukkan';
$GLOBALS['strGeotrackingGeoipRegionLocationError']   = 'Database GeoIP Region tidak ditemukan pada lokasi yang ditunjukkan';
$GLOBALS['strGeotrackingGeoipCityLocationError']     = 'Database GeoIP City tidak ditemukan pada lokasi yang ditunjukkan';
$GLOBALS['strGeotrackingGeoipAreaLocationError']     = 'Database GeoIP Area tidak ditemukan pada lokasi yang ditunjukkan';
$GLOBALS['strGeotrackingGeoipDmaLocationError']      = 'Database GeoIP DMA tidak ditemukan pada lokasi yang ditunjukkan';
$GLOBALS['strGeotrackingGeoipOrgLocationError']      = 'Database GeoIP Organisation tidak ditemukan pada lokasi yang ditunjukkan';
$GLOBALS['strGeotrackingGeoipIspLocationError']      = 'Database GeoIP ISP tidak ditemukan pada lokasi yang ditunjukkan';
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = 'Database GeoIP Netspeed tidak ditemukan pada lokasi yang ditunjukkan';

// Interface Settings
$GLOBALS['strInterfaceDefaults']                     = 'Interface anggapan';
$GLOBALS['strInventory']                             = 'Inventori';
$GLOBALS['strUploadConversions']                     = 'Upload Konversi';
$GLOBALS['strShowCampaignInfo']                      = 'Tampilkan informasi tambahan tentang kampanya pada halaman <i>Peninjauan Luas Kampanye</i>';
$GLOBALS['strShowBannerInfo']                        = 'Tampilkan informasi tambahan tentang banner pada halaman <i>Peninjauan Luas Banner</i>';
$GLOBALS['strShowCampaignPreview']                   = 'Tampilkan pertunjukan pendahuluan dari seluruh banner pada halaman <i>Peninjauan Luas Banner</i>';
$GLOBALS['strShowBannerHTML']                        = 'Show actual banner instead of plain HTML code for HTML banner preview';
$GLOBALS['strShowBannerPreview']                     = 'Show banner preview at the top of pages which deal with banners';
$GLOBALS['strHideInactive']                          = 'Mengumpetkan item-item yang tidak aktif pada seluruh halaman peninjauan luas';
$GLOBALS['strGUIShowMatchingBanners']                = 'Show matching banners on the <i>Linked banner</i> pages';
$GLOBALS['strGUIShowParentCampaigns']                = 'Show parent campaigns on the <i>Linked banner</i> pages';
$GLOBALS['strGUIAnonymousCampaignsByDefault']        = 'Default Campaigns to Anonymous';
$GLOBALS['strStatisticsDefaults']                    = 'Statistik';
$GLOBALS['strBeginOfWeek']                           = 'Beginning of Week';
$GLOBALS['strPercentageDecimals']                    = 'Presentase dari angka desimal';
$GLOBALS['strWeightDefaults']                        = 'Bobot anggapan';
$GLOBALS['strDefaultBannerWeight']                   = 'Bobot anggapan untuk banner';
$GLOBALS['strDefaultCampaignWeight']                 = 'Bobot anggapan untuk kamanye';
$GLOBALS['strDefaultBannerWErr']                     = 'Default banner weight should be a positive integer';
$GLOBALS['strDefaultCampaignWErr']                   = 'Default campaign weight should be a positive integer';

$GLOBALS['strPublisherDefaults']                     = 'Anggapan untuk Penerbit';
$GLOBALS['strModesOfPayment']                        = 'Cara pembayaran';
$GLOBALS['strCurrencies']                            = 'Mata uang';
$GLOBALS['strCategories']                            = 'Kategori';
$GLOBALS['strHelpFiles']                             = 'File bantuan';
$GLOBALS['strHasTaxID']                              = 'NPWP (Tax ID)';
$GLOBALS['strDefaultApproved']                       = 'Kotak tick Persetujuan';

// CSV Import Settings
$GLOBALS['strChooseAdvertiser']                      = 'Pilih Pemasang Iklan';
$GLOBALS['strChooseCampaign']                        = 'Pilih Kampanye';
$GLOBALS['strChooseCampaignBanner']                  = 'Pilih Banner';
$GLOBALS['strChooseTracker']                         = 'Pilih Pelacak';
$GLOBALS['strDefaultConversionStatus']               = 'Status anggapan konversi';
$GLOBALS['strDefaultConversionType']                 = 'Jenis anggapan konversi';
$GLOBALS['strCSVTemplateSettings']                   = 'Penyetelan template CSV';
$GLOBALS['strIncludeCountryInfo']                    = 'Mengikutkan informasi tentang negara';
$GLOBALS['strIncludeBrowserInfo']                    = 'Mengikutkan informasi tentang Browser';
$GLOBALS['strIncludeOSInfo']                         = 'Mengikutkan informasi tentang sistem operasi';
$GLOBALS['strIncludeSampleRow']                      = 'Mengikutkan barisan contoh';
$GLOBALS['strCSVTemplateAdvanced']                   = 'Template mengedepan';
$GLOBALS['strCSVTemplateIncVariables']               = 'Mengikutkan informasi tentang variabel dari Pelacak';

// Invocation Settings
$GLOBALS['strInvocationAndDelivery']                 = 'Penyetelan Invokasi';
$GLOBALS['strAllowedInvocationTypes']                = 'Jenis Invokasi yang diizinkan';
$GLOBALS['strIncovationDefaults']                    = 'Invokasi anggapan';
$GLOBALS['strEnable3rdPartyTrackingByDefault']       = 'Aktifkan Pelacak Klik (Clicktracking) dari pihak ketiga secara anggapan';

// Statistics & Maintenance Settings
$GLOBALS['strStatisticsSettings']                    = 'Penyetelan Statistik dan Pemeliharaan';
$GLOBALS['strStatisticsLogging']                     = 'Penyetelan logging statistik secara global';
$GLOBALS['strCsvImport']                             = 'Allow upload of offline conversions';
$GLOBALS['strLogAdRequests']                         = 'Log an Ad Request every time an advertisement is requested';
$GLOBALS['strLogAdImpressions']                      = 'Log an Ad Impression every time an advertisement is viewed';
$GLOBALS['strLogAdClicks']                           = 'Log an Ad Click every time a viewer clicks on an advertisement';
$GLOBALS['strLogTrackerImpressions']                 = 'Log a Tracker Impression every time a tracker beacon viewed';
$GLOBALS['strReverseLookup']                         = 'Reverse lookup the hostnames of viewers when not supplied';
$GLOBALS['strProxyLookup']                           = 'Try to determine the real IP address of viewers behind a proxy server';
$GLOBALS['strPreventLogging']                        = 'Global Prevent Statistics Logging Settings';
$GLOBALS['strIgnoreHosts']                           = 'Don\'t store statistics for viewers using one of the following IP addresses or hostnames';
$GLOBALS['strBlockAdViews']                          = 'Don\'t log an Ad Impression if the viewer has seen the same ad within the specified time (seconds)';
$GLOBALS['strBlockAdViewsError']                     = 'Ad Impression block value must be a non-negative integer';
$GLOBALS['strBlockAdClicks']                         = 'Don\'t log an Ad Click if the viewer has clicked on the same ad within the specified time (seconds)';
$GLOBALS['strBlockAdClicksError']                    = 'Ad Click block value must be a non-negative integer';
$GLOBALS['strBlockAdConversions']                    = 'Don\'t log a Tracker Impression if the viewer has seen the page with the tracker beacon within the specified time (seconds)';
$GLOBALS['strBlockAdConversionsError']               = 'Tracker Impression block value must be a non-negative integer';
$GLOBALS['strMaintenaceSettings']                    = 'Penyetelan pemeliharaan secara global';
$GLOBALS['strMaintenanceAdServerInstalled']          = 'Process Statistics for AdServer Module';
$GLOBALS['strMaintenanceTrackerInstalled']           = 'Process Statistics for Tracker Module';
$GLOBALS['strMaintenanceOI']                         = 'Maintenance Operation Interval (minutes)';
$GLOBALS['strMaintenanceOIError']                    = 'The Maintenace Operation Interval is not valid - see documentation for valid values';
$GLOBALS['strMaintenanceCompactStats']               = 'Hapuskan statistik mentah setelah diolah?';
$GLOBALS['strMaintenanceCompactStatsGrace']          = 'Grace period before deleting processed statistics (seconds)';
$GLOBALS['strPrioritySettings']                      = 'Penyetelan prioritas secara global';
$GLOBALS['strPriorityInstantUpdate']                 = 'Update advertisement priorities immediately when changes made in the UI';
$GLOBALS['strWarnCompactStatsGrace']                 = 'The Compact Stats Grace period must be a positive integer';
$GLOBALS['strDefaultImpConWindow']                   = 'Default Ad Impression Connection Window (seconds)';
$GLOBALS['strDefaultImpConWindowError']              = 'If set, the Default Ad Impression Connection Window must be a positive integer';
$GLOBALS['strDefaultCliConWindow']                   = 'Default Ad Click Connection Window (seconds)';
$GLOBALS['strDefaultCliConWindowError']              = 'If set, the Default Ad Click Connection Window must be a positive integer';
$GLOBALS['strEmailWarnings']                         = 'Pemberitahuan melalui E-Mail';
$GLOBALS['strAdminEmailHeaders']                     = 'Tambahkan header berikut pada semua E-Mail yang dikirimkan oleh ' . MAX_PRODUCT_NAME;
$GLOBALS['strWarnLimit']                             = 'Kirimkan pemberitahuan bilamana jumlah impresi yang tersisa kurang dari jumlah impresi yang ditentukan disini';
$GLOBALS['strWarnLimitErr']                          = 'Pemberitahuan batas harus dalam angka positiv';
$GLOBALS['strWarnLimitDays']                         = 'Kirimkan pemberitahuan bilamana jumlah hari yang tersisa kurang dari jumlah hari yang ditentukan disini';
$GLOBALS['strWarnLimitDaysErr']                      = 'Pemberitahuan tentang jumlah hari yang tersisa harus dalam angka positiv';
$GLOBALS['strAllowEmail']                            = 'Izinkan pengiriman E-Mail secara umum';
$GLOBALS['strEmailAddress']                          = 'Alamat PENGIRIM untuk E-Mail laporan';
$GLOBALS['strEmailAddressName']                      = 'Company or personal name to sign off e-mail with';
$GLOBALS['strWarnAdmin']                             = 'Send a warning to the administrator every time a campaign is almost expired';
$GLOBALS['strWarnClient']                            = 'Send a warning to the advertiser every time a campaign is almost expired';
$GLOBALS['strWarnAgency']                            = 'Send a warning to the agency every time a campaign is almost expired';
$GLOBALS['strQmailPatch']                            = 'Aktifkan qmail patch';

// UI Settings
$GLOBALS['strGuiSettings']                           = 'Penyetelan Interface Pengguna';
$GLOBALS['strGeneralSettings']                       = 'Penyetelan Umum';
$GLOBALS['strAppName']                               = 'Nama Aplikasi';
$GLOBALS['strMyHeader']                              = 'Lokasi dari file Header';
$GLOBALS['strMyHeaderError']                         = 'File header tidak ditemukan dalam lokasi yang ditunjuk oleh Anda';
$GLOBALS['strMyFooter']                              = 'Lokasi dari file Footer';
$GLOBALS['strMyFooterError']                         = 'File footer tidak ditemukan dalam lokasi yang ditunjuk oleh Anda';
$GLOBALS['strDefaultTrackerStatus']                  = 'Anggapan Status dari pelacak';
$GLOBALS['strDefaultTrackerType']                    = 'Jenis pelacak anggapan';

$GLOBALS['strMyLogo']                                = 'Nama dari file lambang kegaliban';
$GLOBALS['strMyLogoError']                           = 'Nama dari file lambang tidak ditemukan dalam direktori admin/images';
$GLOBALS['strGuiHeaderForegroundColor']              = 'Warna dari header pada latar depan';
$GLOBALS['strGuiHeaderBackgroundColor']              = 'Warna dari header pada latar belakang';
$GLOBALS['strGuiActiveTabColor']                     = 'Warna dari tab yang aktif';
$GLOBALS['strGuiHeaderTextColor']                    = 'Warna dari teks dalam header';
$GLOBALS['strColorError']                            = 'Silakan masukkan warna dalam format RGB, seperti \'0066CC\'';

$GLOBALS['strGzipContentCompression']                = 'Gunakan GZIP Content Compression';
$GLOBALS['strClientInterface']                       = 'Interface Pemasang Iklan';
$GLOBALS['strReportsInterface']                      = 'Interface Laporan';
$GLOBALS['strClientWelcomeEnabled']                  = 'Aktifkan pesan Selamat Datang untuk pemasang iklan';
$GLOBALS['strClientWelcomeText']                     = 'Pesan Selamat Datang<br />(Tag HTML diizinkan)';

$GLOBALS['strPublisherInterface']                    = 'Interface Penerbit';
$GLOBALS['strPublisherAgreementEnabled']             = 'Aktifkan pengendalian Login untuk penerbit yang belum mengsetujui Tata Tertip dan Persyaratan';
$GLOBALS['strPublisherAgreementText']                = 'Pesan yang ditampilkan pada saat Login (Tag HTML diizinkan)';


/*-------------------------------------------------------*/
/* Unknown (unused?) translations                        */
/*-------------------------------------------------------*/

$GLOBALS['strExperimental']                 = "Experimental";
$GLOBALS['strKeywordRetrieval']             = "Keyword retrieval";
$GLOBALS['strBannerRetrieval']              = "Banner retrieval method";
$GLOBALS['strRetrieveRandom']               = "Random banner retrieval (default)";
$GLOBALS['strRetrieveNormalSeq']            = "Normal sequental banner retrieval";
$GLOBALS['strWeightSeq']                    = "Weight based sequential banner retrieval";
$GLOBALS['strFullSeq']                      = "Full sequential banner retrieval";
$GLOBALS['strUseKeywords']                  = "Use keywords to select banners";
$GLOBALS['strUseConditionalKeys']           = "Allow logical operators when using direct selection";
$GLOBALS['strUseMultipleKeys']              = "Allow multiple keywords when using direct selection";

$GLOBALS['strTableBorderColor']             = "Table Border Color";
$GLOBALS['strTableBackColor']               = "Table Back Color";
$GLOBALS['strTableBackColorAlt']            = "Table Back Color (Alternative)";
$GLOBALS['strMainBackColor']                = "Main Back Color";
$GLOBALS['strOverrideGD']                   = "Override GD Imageformat";
$GLOBALS['strTimeZone']                     = "Zona Waktu";

?>
