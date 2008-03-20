<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

// Installer translation strings
$GLOBALS['strInstall']				= "Instal";
$GLOBALS['strChooseInstallLanguage']		= "Silakan pilih bahasa untuk digunakan dalam proses instalasi";
$GLOBALS['strLanguageSelection']		= "Pilihan Bahasa";
$GLOBALS['strDatabaseSettings']			= "Penyetelan Database";
$GLOBALS['strAdminSettings']			= "Penyetelan Administrator";
$GLOBALS['strAdvancedSettings']			= "Penyetelan Lanjut";
$GLOBALS['strOtherSettings']			= "Penyetelan Lainnya";

$GLOBALS['strWarning']				= "Peringatan";
$GLOBALS['strFatalError']			= "Telah terjadi Error yang fatal";
$GLOBALS['strUpdateError']			= "Telah terjadi kesalahan sewaktu meng-update";
$GLOBALS['strUpdateDatabaseError']		= "Disebabkan oleh masalah yang tidak jelas update dari struktur database tidak berhasil. Disarankan untuk klick <b>Retry updating</b> untuk mencoba membenarkan masalah ini. Bila Anda yakin bahwa masalah ini tidak akan berpengaruh fungsi-fungsi dari ".$phpAds_productname.", silakan klick <b>Ignore errors</b> untuk melanjutkan. Abaikan masalah ini mampuh untuk mengakibatkan masalah yang serius dan maka dengan itu tidak disarankan!";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname." telah terinstal di sistem ini. Bila Anda ingin mengubah konfigurasi silakan pindah ke <a href='settings-index.php'>Halaman Konfigurasi</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Gagal menghubungi database. Mohon periksa ulang penyetelan yang telah dilakukan";
$GLOBALS['strCreateTableTestFailed']		= "Pengguna yang ditentukan oleh Anda tidak memiliki hak untuk membuat atau update struktur dari database. Mohon hubungi administrator database.";
$GLOBALS['strUpdateTableTestFailed']		= "Pengguna yang ditentukan oleh Anda tidak memiliki hak untuk membuat atau update struktur dari database. Mohon hubungi administrator database.";
$GLOBALS['strTablePrefixInvalid']		= "Prefix dari tabel mengandung karakter yang tidak valid";
$GLOBALS['strTableInUse']			= "Database yang dipilih oleh Anda telah digunakan untuk ".$phpAds_productname.". Mohon gunakan prefix tabel yang berbeda atau bacalah buku pemandu untuk mengetahui instruksi Upgrade.";
$GLOBALS['strTableWrongType']			= "Jenis tabel yang dipilih tidak didukung oleh instalasi Anda dari ".$phpAds_dbmsname;
$GLOBALS['strMayNotFunction']			= "Sebelum Anda lanjut mohon perbaiki masalah berikut:";
$GLOBALS['strIgnoreWarnings']			= "Abaikan Peringatan";
$GLOBALS['strWarningDBavailable']		= "Versi PHP yang digunakan oleh Anda tidak mendukung koneksi ke database server ".$phpAds_dbmsname.". Anda perlu mengaktifkan ekstensi PHP ".$phpAds_dbmsname." sebelum melanjutkan.";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." membutuhkan veri PHP 4.0 atau lebih tinggi untuk berfungsi dengan baik. Pada saat ini Anda mengunakan {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "Variabel register_globals dalam konfigurasi perlu diubah ke posisi On.";
$GLOBALS['strWarningMagicQuotesGPC']		= "Variabel magic_quotes_gpc dalam konfigurasi perlu diubah ke posisi On.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "Variabel magic_quotes_runtime dalam konfigurasi perlu diubah ke posisi Off.";
$GLOBALS['strWarningFileUploads']		= "Variabel file_uploads dalam konfigurasi perlu diubah ke posisi On.";
$GLOBALS['strWarningTrackVars']			= "Variabel track_vars dalam konfigurasi perlu diubah ke posisi On.";
$GLOBALS['strWarningPREG']			= "Versi PHP yang digunakan oleh Anda tidak mendukung PERL compatible regular expressions. Anda perlu mengaktifkan ekstensi PREG sebelum melanjutkan.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." telah deteksi bahwa file <b>config.inc.php</b> tidak bisa ditulis oleh server.<br /> Anda tidak bisa melanjutkan sebelum hak terhadap file tersebut belum diubah. <br />Silakan belajari dokumentasi yang berkaitan bila Anda belum memahaminya.";
$GLOBALS['strCantUpdateDB']  			= "Pada saat ini update database tidak bisa dilakukan. Bila Anda tetap memutuskan untuk melanjutkan, seluruh banner, statistik dan pemasang iklan akan terhapus.";
$GLOBALS['strIgnoreErrors']			= "Abaikan Error";
$GLOBALS['strRetryUpdate']			= "Coba ulang meng-update";
$GLOBALS['strTableNames']			= "Nama Tabel";
$GLOBALS['strTablesPrefix']			= "Prefix Nama Tabel";
$GLOBALS['strTablesType']			= "Jenis Tabel";

$GLOBALS['strInstallWelcome']			= "Selamat Datang ke ".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "Sebelum Anda bisa mengunakan ".$phpAds_productname.", program ini perlu dikonfigurasikan dan <br /> database perlu dibuat. Silakan klik <b>Lanjut</b> untuk melanjut.";
$GLOBALS['strInstallSuccess']			= "<b>Instalasi dari ".$phpAds_productname." telah selesai.</b><br /><br />Supaya ".$phpAds_productname." bisa berfungsi dengan baik, Anda perlu 
						   memastikan bahwa file Maintenance dijalankan pada setiap jam. Informasi lebih lanjut tentang hal ini bisa ditemukan dalam dokumentasi.
						   <br /><br />Klik <b>Lanjut</b> untuk pindah ke halaman konfigurasi,  dimana Anda bisa 
						   setup penyetelan yang lebih lengkap. Mohon jangan lupa untuk mengunci kembali file config.inc.php setelah Anda selesai untuk menghindar pelanggaran 
						   keamanan.";
$GLOBALS['strUpdateSuccess']			= "<b>Upgrade dari ".$phpAds_productname." telah selesai dengan sukses.</b><br /><br />Supaya ".$phpAds_productname." bisa berfungsi dengan baik, Anda perlu 
						   memastikan bahwa file Maintenance dijalankan pada setiap jam (dulunya file tersebut harus dijalankan setiap hari). Informasi lebih lanjut tentang hal ini bisa ditemukan dalam dokumentasi.
						   <br /><br />Klik <b>Lanjut</b> untuk pindah ke halaman konfigurasi. Mohon jangan lupa untuk mengunci kembali file config.inc.php setelah Anda selesai untuk menghindar pelanggaran  
						   keamanan.";
$GLOBALS['strInstallNotSuccessful']		= "<b>Instalasi dari ".$phpAds_productname." belum sukses</b><br /><br />Sebagian dari proses instalasi gagal diselesaikan.
						   Bisa jadi bahwa masalah ini hanya bersifat sementara. Bila demikian silakan klik <b>Lanjut</b> dan kembali ke
						   tingkat pertama dari proses instalasi. Untuk mengetahui lebih lanjut tentang arti dari Error Message dibawah ini dan bagimana caranya untuk mengatasinya, 
						   mohon pahami dokumentasi yang dilampirkan.";
$GLOBALS['strErrorOccured']			= "Telah terjadi Error sbb.:";
$GLOBALS['strErrorInstallDatabase']		= "Struktur database tidak bisa dibuat.";
$GLOBALS['strErrorUpgrade'] = 'The existing installation\'s database could not be upgraded.';
$GLOBALS['strErrorInstallConfig']		= "File konfigurasi atau database tidak bisa di-update.";
$GLOBALS['strErrorInstallDbConnect']		= "Gagal membuka koneksi ke database.";

$GLOBALS['strUrlPrefix']			= "Prefix URL";

$GLOBALS['strProceed']				= "Lanjut >";
$GLOBALS['strInvalidUserPwd']			= "Nama Pengguna atau Kata Sandi tidak benar";

$GLOBALS['strUpgrade']				= "Upgrade";
$GLOBALS['strSystemUpToDate']			= "Sistem Anda sudah aktual. Upgrade pada saat ini tidak diperlukan. <br />Klik <b>Lanjut</b> untuk melanjut ke halaman muka.";
$GLOBALS['strSystemNeedsUpgrade']		= "Struktur database dan file konfigurasi perlu di-upgrade untuk berfungsi dengan baik. Klik <b>Lanjut</b> untuk memulai proses upgrade. <br /><br />Tergantung pada versi yang di-upgrade dan pada jumlah statistik yang telah tersimpan pada database, proses ini dapat mengakibatkan beban yang tinggi pada database server. Mohon sabar, proses upgrade membutuhkan waktu berberapa menit.";
$GLOBALS['strSystemUpgradeBusy']		= "Upgrade sistem dalam proses, silakan tunggu...";
$GLOBALS['strSystemRebuildingCache']		= "Bangun ulang cache, silakan tunggu...";
$GLOBALS['strServiceUnavalable']		= "Fasilitas tidak tersedia. Upgrade sistem dalam proses";

$GLOBALS['strConfigNotWritable']		= "File config.inc.php Anda tidak bisa ditulis";





/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']			= "Pilih Bagian";
$GLOBALS['strDayFullNames'] 			= array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$GLOBALS['strEditConfigNotPossible']   		= "Perubahan tidak diperbolehkan sehubungan file konfigurasi terkunci didasarkan alasan keamanan. ".
										  "Bila Anda ingin melakukan perubahan, Anda perlu membuka file config.inc.php terlebih dahulu.";
$GLOBALS['strEditConfigPossible']		= "File konfigurasi dapat diubah sehubungan file tersebut tidak terkunci. Hal ini memungkinkan kebobolan dalam segi keamanan. ".
										  "Bila Anda ingin mengamankan sistem, Anda perlu mengunci file config.inc.php.";



// Database
$GLOBALS['strDatabaseSettings']			= "Penyetelan Database";
$GLOBALS['strDatabaseServer']			= "Database Server";
$GLOBALS['strDbLocal']				= "Koneksi ke server lokal dengan menggunakan socket"; // Pg only
$GLOBALS['strDbHost']				= "Hostname Database";
$GLOBALS['strDbPort']				= "Port Number Database";
$GLOBALS['strDbUser']				= "Pengguna Database";
$GLOBALS['strDbPassword']			= "Kata Sandi Database";
$GLOBALS['strDbName']				= "Nama Database";

$GLOBALS['strDatabaseOptimalisations']		= "Optimalisasi Database";
$GLOBALS['strPersistentConnections']		= "Gunakan Koneksi Persistent";
$GLOBALS['strCompatibilityMode']		= "Gunakan Database Compatibility Mode";
$GLOBALS['strCantConnectToDb']			= "Koneksi ke Database gagal";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "Penyetelan Invokasi dan Penyampaian";

$GLOBALS['strAllowedInvocationTypes']		= "Jenis Invokasi yang diizinkan";
$GLOBALS['strAllowRemoteInvocation']		= "Izinkan Invokasi Remote";
$GLOBALS['strAllowRemoteJavascript']		= "Izinkan Invokasi Remote untuk Javascript";
$GLOBALS['strAllowRemoteFrames']		= "Izinkan Invokasi Remote untuk Frames";
$GLOBALS['strAllowRemoteXMLRPC']		= "Izinkan Invokasi Remote dengan mengunakan XML-RPC";
$GLOBALS['strAllowLocalmode']			= "Izinkan Local Mode";
$GLOBALS['strAllowInterstitial']		= "Izinkan Interstitials";
$GLOBALS['strAllowPopups']			= "Izinkan Popups";

$GLOBALS['strUseAcl']				= "Mengevaluasikan batas penyampaian selama menyampaian";

$GLOBALS['strDeliverySettings']			= "Penyetelan Penyampaian";
$GLOBALS['strCacheType']			= "Jenis Cache Penyampaian";
$GLOBALS['strCacheFiles']			= "File";
$GLOBALS['strCacheDatabase']			= "Database";
$GLOBALS['strCacheShmop']			= "Shared memory/Shmop";
$GLOBALS['strCacheSysvshm']			= "Shared memory/Sysvshm";
$GLOBALS['strExperimental']			= "Eksperimental";
$GLOBALS['strKeywordRetrieval']			= "Pencairan Kata Kunci";
$GLOBALS['strBannerRetrieval']			= "Metode Pencairan Banner";
$GLOBALS['strRetrieveRandom']			= "Pencairan banner secara serampangan (default)";
$GLOBALS['strRetrieveNormalSeq']		= "Pencairan banner secara sequental";
$GLOBALS['strWeightSeq']			= "Pencairan banner berdasar bobot";
$GLOBALS['strFullSeq']				= "Pencairan banner secara sequental penuh";
$GLOBALS['strUseConditionalKeys']		= "Izinkan operator logika bila memakai seleksi langsung";
$GLOBALS['strUseMultipleKeys']			= "Izinkan kata kunci perkalian bila memakai seleksi langsung";

$GLOBALS['strZonesSettings']			= "Pencairan Zona";
$GLOBALS['strZoneCache']			= "Zona Cache, ini seharusnya mempercepat prose bila mengunakan zona";
$GLOBALS['strZoneCacheLimit']			= "Waktu antara update cache (dalam detik)";
$GLOBALS['strZoneCacheLimitErr']		= "Waktu antara update cache harus integer positif";

$GLOBALS['strP3PSettings']			= "P3P Privacy Policies";
$GLOBALS['strUseP3P']				= "Gunakan P3P Policies";
$GLOBALS['strP3PCompactPolicy']			= "P3P Compact Policy";
$GLOBALS['strP3PPolicyLocation']		= "Lokasi P3P Policy"; 



// Banner Settings
$GLOBALS['strBannerSettings']			= "Penyetelan Banner";

$GLOBALS['strAllowedBannerTypes']		= "Jenis banner yang diizinkan";
$GLOBALS['strTypeSqlAllow']			= "Izinkan banner lokal (SQL)";
$GLOBALS['strTypeWebAllow']			= "Izinkan banner lokal (Webserver)";
$GLOBALS['strTypeUrlAllow']			= "Izinkan banner eksternal";
$GLOBALS['strTypeHtmlAllow']			= "Izinkan banner HTML";
$GLOBALS['strTypeTxtAllow']			= "Izinkan Text ads";

$GLOBALS['strTypeWebSettings']			= "Konfigurasi banner lokal (Webserver)";
$GLOBALS['strTypeWebMode']			= "Metode Penyimpanan";
$GLOBALS['strTypeWebModeLocal']			= "Direktori lokal";
$GLOBALS['strTypeWebModeFtp']			= "Server FTP eksternal";
$GLOBALS['strTypeWebDir']			= "Direktori lokal";
$GLOBALS['strTypeWebFtp']			= "Web Banner Server modus FTP";
$GLOBALS['strTypeWebUrl']			= "URL Umum";
$GLOBALS['strTypeWebSslUrl']			= "URL Umum (SSL)";
$GLOBALS['strTypeFTPHost']			= "Host FTP";
$GLOBALS['strTypeFTPDirectory']			= "Direktori Host";
$GLOBALS['strTypeFTPUsername']			= "Login";
$GLOBALS['strTypeFTPPassword']			= "Kata Sandi";
$GLOBALS['strTypeFTPErrorDir']			= "Direktori Host tidak eksis";
$GLOBALS['strTypeFTPErrorConnect']		= "Gagal menghubungi server FTP, Login atau Kata Sandi tidak benar";
$GLOBALS['strTypeFTPErrorHost']			= "Nama host dari server FTP tidak benar";
$GLOBALS['strTypeDirError']			= "Direktori lokal tidak eksis";



$GLOBALS['strDefaultBanners']			= "Banner Default";
$GLOBALS['strDefaultBannerUrl']			= "URL gambar default";
$GLOBALS['strDefaultBannerTarget']		= "Tujuan URL default";

$GLOBALS['strTypeHtmlSettings']			= "Pilihan banner HTML";
$GLOBALS['strTypeHtmlAuto']			= "Untuk memaksakan Click Tracking ubah banner HTML secara otomatis";
$GLOBALS['strTypeHtmlPhp']			= "Izinkan ekspresi PHP dijalankan dari dalam banner HTML";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']			= "Informasi Host dan Geotargeting";

$GLOBALS['strRemoteHost']			= "Remote host";
$GLOBALS['strReverseLookup']			= "Usahakan untuk menetapkan nama host dari pengunjung bila nama tidak diberikan oleh server";
$GLOBALS['strProxyLookup']			= "Usahakan untuk menetapkan nomor IP yang nyata bila pengunjung gunakan proxy server";

$GLOBALS['strGeotargeting']			= "Geotargeting";
$GLOBALS['strGeotrackingType']			= "Jenis database geotargeting";
$GLOBALS['strGeotrackingLocation'] 		= "Lokasi database geotargeting";
$GLOBALS['strGeotrackingLocationError'] 	= "Database geotargeting tidak berada dalam lokasi yang ditetapkan";
$GLOBALS['strGeoStoreCookie']			= "Simpan hasil dalam Cookie untuk referensi di masa depan";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Penyetelan Statistik";

$GLOBALS['strStatisticsFormat']			= "Format Statistik";
$GLOBALS['strCompactStats']			= "Format Statistik";
$GLOBALS['strLogAdviews']			= "Catat AdView setiap kali sebuah banner disampaikan";
$GLOBALS['strLogAdclicks']			= "Catat AdClick setiap kali seorang pengunjung meng-klik sebuah banner";
$GLOBALS['strLogSource']			= "Catat parameter sumber yang ditetapkan sewaktu invokasi";
$GLOBALS['strGeoLogStats']			= "Catat negara asal dari pengunjung dalam statistik";
$GLOBALS['strLogHostnameOrIP']			= "Catat nama host dan nomor IP dari pengunjung";
$GLOBALS['strLogIPOnly']			= "Hanya catat nomor IP dari pengunjung meskipun nama host diketahui";
$GLOBALS['strLogIP']				= "Catat nomor IP dari pengunjung";
$GLOBALS['strLogBeacon']			= "Gunakan rambu kecil untuk mencatat AdView guna memastikan, hanya banner yang benar-benar disampaikan tercatat";

$GLOBALS['strRemoteHosts']			= "Host Remote";
$GLOBALS['strIgnoreHosts']			= "Jangan simpan statistik dari pengunjung dengan nomor IP atau nama Host sbb.";
$GLOBALS['strBlockAdviews']			= "Jangan simpan AdViews bila banner yang sama telah tertampil di browser pengunjung dalam batas jangka waktu detik yang telah ditentukan";
$GLOBALS['strBlockAdclicks']			= "Jangan simpan AdClicks bila pengunjung telah meng-click banner yang sama dalam batas jangka waktu detik yang telah ditentukan";


$GLOBALS['strEmailWarnings']			= "Peringatan E-mail";
$GLOBALS['strAdminEmailHeaders']		= "Tambahkan Header berikut dalam setiap E-Mail yang dikirim oleh ".$phpAds_productname;
$GLOBALS['strWarnLimit']			= "Kirim peringatan bila jumlah Impression yang tersedia dibawah jumlah yang yang ditentukan disini";
$GLOBALS['strWarnLimitErr']			= "Batas peringatan harus angka positif";
$GLOBALS['strWarnAdmin']			= "Kirim peringatan kepada Administrator setiap kalinya sebuah kampanye mendekati batas berlaku";
$GLOBALS['strWarnClient']			= "Kirim peringatan kepada Pemasang Iklan setiap kalinya sebuah kampanye mendekati batas berlaku";
$GLOBALS['strQmailPatch']			= "Gunakan patch untuk qmail";

$GLOBALS['strAutoCleanTables']			= "Pemangkasan Database";
$GLOBALS['strAutoCleanStats']			= "Pangkas Statistik";
$GLOBALS['strAutoCleanUserlog']			= "Pangkas User Log";
$GLOBALS['strAutoCleanStatsWeeks']		= "Batas umur maksimum Statistik <br />(minimal 3 minggu)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "Batas umur maksimum User Log <br />(minimal 3 minggu)";
$GLOBALS['strAutoCleanErr']			= "Batas umur maksimum diharuskan sedikitnya 3 minggu";
$GLOBALS['strAutoCleanVacuum']			= "VACUUM ANALYZE tabel setiap malam"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Penyetelan Administrator";

$GLOBALS['strLoginCredentials']			= "Informasi Dasar Admin";
$GLOBALS['strAdminUsername']			= "Nama pengguna Admin";
$GLOBALS['strInvalidUsername']			= "Nama Pengguna salah";

$GLOBALS['strBasicInformation']			= "Informasi Dasar";
$GLOBALS['strAdminFullName']			= "Nama lengkap Admin";
$GLOBALS['strAdminEmail']			= "Alamat E-mail Admin";
$GLOBALS['strCompanyName']			= "Nama Perusahaan";

$GLOBALS['strAdminCheckUpdates']		= "Cari Update";
$GLOBALS['strAdminCheckEveryLogin']		= "Setiap login";
$GLOBALS['strAdminCheckDaily']			= "Setiap hari";
$GLOBALS['strAdminCheckWeekly']			= "Setiap minggu";
$GLOBALS['strAdminCheckMonthly']		= "Setiap bulan";
$GLOBALS['strAdminCheckNever']			= "Jangan cari Update";

$GLOBALS['strAdminNovice']			= "Tindakan menghapus oleh Admin memerlukan konfirmasi demi keamanan";
$GLOBALS['strUserlogEmail']			= "Catat seluruh E-Mail yang dikirim";
$GLOBALS['strUserlogPriority']			= "Catat kalkulasi prioritas yang dijalankan setiap jam";
$GLOBALS['strUserlogAutoClean']			= "Catat pembersihan database otomatis";


// User interface settings
$GLOBALS['strGuiSettings']			= "Penyetelan Interface untuk Pengguna";

$GLOBALS['strGeneralSettings']			= "Penyetelan Umum";
$GLOBALS['strAppName']				= "Nama aplikasi";
$GLOBALS['strMyHeader']				= "Lokasi dari Header file";
$GLOBALS['strMyHeaderError']			= "File Header tidak ditemukan pada tempat yang ditetapkan oleh Anda";
$GLOBALS['strMyFooter']				= "Lokasi dari Footer file";
$GLOBALS['strMyFooterError']			= "File Footer tidak ditemukan pada tempat yang ditetapkan oleh Anda";
$GLOBALS['strGzipContentCompression']		= "Gunakan kompresi GZIP";

$GLOBALS['strClientInterface']			= "Interface untuk Pemasang Iklan";
$GLOBALS['strClientWelcomeEnabled']		= "Memperolehkan kabar Selamat Datang untuk Pemasang Iklan";
$GLOBALS['strClientWelcomeText']		= "Kabar Selamat Datang<br />(HTML tags diperbolehkan)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Penyetelan Interface";

$GLOBALS['strInventory']			= "Inventaris";
$GLOBALS['strShowCampaignInfo']			= "Tampilkan informasi khusus tentang kampanye pada halaman <i>Pandangan Umum Kampanye</i>";
$GLOBALS['strShowBannerInfo']			= "Tampilkan informasi khusus tentang banner pada halaman <i>Pandangan Umum Banner</i>";
$GLOBALS['strShowCampaignPreview']		= "Tampilkan <i>Preview</i> dari semua banner pada halaman <i>Pandangan Umum Banner</i>";
$GLOBALS['strShowBannerHTML']			= "Tampilkan banner tetapi bukan kode HTML untuk <i>Preview</i> banner HTML";
$GLOBALS['strShowBannerPreview']		= "Tampilkan <i>Preview</i> di bagian atas pada seluruh halaman yang bersangkutan dengan banner";
$GLOBALS['strHideInactive']			= "Sembunyikan seluruh instansi yang tidak aktif pada halaman <i>Preview</i>";
$GLOBALS['strGUIShowMatchingBanners']		= "Tampilkan banner yang sebanding pada halaman <i>Linked banner</i>";
$GLOBALS['strGUIShowParentCampaigns']		= "Tampilkan kampanye induk pada halaman <i>Linked banner</i>";
$GLOBALS['strGUILinkCompactLimit']		= "Sembunyikan kampanye atau banner yang tidak di-link pada halaman <i>Linked banner</i> bila jumlahnya lebih dari";

$GLOBALS['strStatisticsDefaults'] 		= "Statistik";
$GLOBALS['strBeginOfWeek']			= "Hari pertama dari minggu";
$GLOBALS['strPercentageDecimals']		= "Desimal Presentase";

$GLOBALS['strWeightDefaults']			= "Bobot Default";
$GLOBALS['strDefaultBannerWeight']		= "Bobot Default dari Banner";
$GLOBALS['strDefaultCampaignWeight']		= "Bobot Default dari kampanye";
$GLOBALS['strDefaultBannerWErr']		= "Bobot Default dari banner harus angka integer yang positif";
$GLOBALS['strDefaultCampaignWErr']		= "Bobot Default dari kampanye harus angka integer yang positif";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "Warna batas dari Table";
$GLOBALS['strTableBackColor']			= "Warna induk dari Table";
$GLOBALS['strTableBackColorAlt']		= "Warna induk dari Table (Alternatif)";
$GLOBALS['strMainBackColor']			= "Warna Induk";
$GLOBALS['strOverrideGD']			= "Sampingkan GD Imageformat";
$GLOBALS['strTimeZone']				= "Zona Waktu";

?>
