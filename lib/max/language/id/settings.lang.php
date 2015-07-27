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

// Installer translation strings
$GLOBALS['strInstall'] = "Instal";
$GLOBALS['strDatabaseSettings'] = "Penyetelan Database";
$GLOBALS['strAdminAccount'] = "Administrator Account";
$GLOBALS['strAdvancedSettings'] = "Penyetelan Lanjut";
$GLOBALS['strWarning'] = "Peringatan";
$GLOBALS['strBtnContinue'] = "Lanjut &raquo;";
$GLOBALS['strBtnRecover'] = "Bangkitkan kembali &raquo;";
$GLOBALS['strBtnAgree'] = "Saya setuju &raquo;";
$GLOBALS['strBtnRetry'] = "Coba kembali";
$GLOBALS['strWarningRegisterArgcArv'] = "Variabel register_argc_argv dalam konfigurasi PHP harus berada dalam posisi ON untuk jalankan pemeliharaan dari Command Line.";
$GLOBALS['strTablesType'] = "Jenis Tabel";

$GLOBALS['strRecoveryRequiredTitle'] = "Proses upgrade semula mengalami sebuah Error";
$GLOBALS['strRecoveryRequired'] = "Telah terjadi sebuah Error pada saat memproses upgrade yang sebelumnya dan {$PRODUCT_NAME} perlu membangkitkan proses upgrade terlebih dahulu. Mohon klik tombol Bangkitkan dibawah.";

$GLOBALS['strOaUpToDate'] = "Database dan struktur file dari {$PRODUCT_NAME} sudah menggunakan versi yang terbaru. Maka dengan itu upgrade untuk sementara waktu tidak diperlukan. Mohon klik Lanjut untuk diantar ke panel administrasi dari {$PRODUCT_NAME}.";
$GLOBALS['strOaUpToDateCantRemove'] = "Perhatian: File UPGRADE masih berada dalam direktori var. Kami tidak dapat menghapus file tersebut disebabkan oleh permission yang tidak cukup. Mohon hapuskan file tersebut secara manual.";
$GLOBALS['strErrorWritePermissions'] = "Error pada File permission terdeteksi. Masalah ini harus diperbaiki terlebih dahulu sebelum melanjut.<br />To fix the errors on a Linux system, try typing in the following command(s):";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod a+w %s</i>";

$GLOBALS['strErrorWritePermissionsWin'] = "Error pada File permission terdeteksi. Masalah ini harus diperbaiki terlebih dahulu sebelum melanjut.";
$GLOBALS['strCheckDocumentation'] = "Pertolongan untuk mengatasi masalah ini dapat ditemukan pada <a href='http://{$PRODUCT_DOCSURL}'>Dokumentasi {$PRODUCT_NAME}</a>.";

$GLOBALS['strAdminUrlPrefix'] = "URL tampilan untuk Admin";
$GLOBALS['strDeliveryUrlPrefix'] = "URL tampilan untuk mesin penyampaian iklan";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL tampilan untuk mesin penyampaian iklan (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL penyimpanan gambar";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL penyimpanan gambar (SSL)";



/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Pilih Bagian";
$GLOBALS['strUnableToWriteConfig'] = "Gagal menulis perubahan pada config file";
$GLOBALS['strUnableToWritePrefs'] = "Gagal mengirim preferensi kepada database";
$GLOBALS['strImageDirLockedDetected'] = "<b>Direktori Gambar</b> yang diberikan tidak bisa ditulis oleh server. <br>Anda tidak dapat melanjut sebelum permissions dari direktori tersebut diubah atau direktori tersebut dibuatkan.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Penyetelan konfigurasi";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Nama pengguna Administrator";
$GLOBALS['strAdminPassword'] = "Kata sandi Administrator";
$GLOBALS['strInvalidUsername'] = "Nama pengguna tidak berlaku";
$GLOBALS['strBasicInformation'] = "Informasi Dasar";
$GLOBALS['strAdministratorEmail'] = "Alamat E-Mail Administrator";
$GLOBALS['strAdminCheckUpdates'] = "Cari Update";
$GLOBALS['strUserlogEmail'] = "Catat seluruh E-Mail yang dikirim";
$GLOBALS['strEnableDashboard'] = "Aktifkan Dashboard";
$GLOBALS['strTimezone'] = "Zona waktu";
$GLOBALS['strEnableAutoMaintenance'] = "Bila jadwal untuk pemeliharaan tidak di-set pada Cron, jalankan pemeliharaan dengan cara otomatis pada saat penyampaian iklan";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Penyetelan Database";
$GLOBALS['strDatabaseServer'] = "Database Server";
$GLOBALS['strDbLocal'] = "Koneksi ke server lokal dengan menggunakan socket";
$GLOBALS['strDbType'] = "Jenis Database";
$GLOBALS['strDbHost'] = "Hostname Database";
$GLOBALS['strDbPort'] = "Port Number Database";
$GLOBALS['strDbUser'] = "Pengguna Database";
$GLOBALS['strDbPassword'] = "Kata Sandi Database";
$GLOBALS['strDbName'] = "Nama Database";
$GLOBALS['strDatabaseOptimalisations'] = "Optimalisasi Database";
$GLOBALS['strPersistentConnections'] = "Gunakan Koneksi Persistent";
$GLOBALS['strCantConnectToDb'] = "Koneksi ke Database gagal";

// Email Settings
$GLOBALS['strEmailSettings'] = "Penyetelan Utama";
$GLOBALS['strQmailPatch'] = "Aktifkan qmail patch";

// Audit Trail Settings

// Debug Logging Settings
$GLOBALS['strDebug'] = "Penyetelan Global Debug Logging";
$GLOBALS['strEnableDebug'] = "Aktifkan Debug Logging";
$GLOBALS['strDebugMethodNames'] = "Mencakupkan nama metode pada debug log";
$GLOBALS['strDebugLineNumbers'] = "Mencakupkan nomor garis pada debug log";
$GLOBALS['strDebugType'] = "Jenis Debug Log";
$GLOBALS['strDebugName'] = "Debug Log Name, Calendar, SQL Table,<br />atau Syslog Facility";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Informasi anggapan";

// Delivery Settings
$GLOBALS['strWebPathSimple'] = "Lintasan Web";
$GLOBALS['strDeliveryPath'] = "Cache penyampaian";
$GLOBALS['strImagePath'] = "Lintasan gambar";
$GLOBALS['strDeliverySslPath'] = "Cache penyampaian";
$GLOBALS['strImageSslPath'] = "Lintasan SSL gambar";
$GLOBALS['strImageStore'] = "Folder gambar";
$GLOBALS['strTypeWebSettings'] = "Global Webserver Local Banner Storage Settings";
$GLOBALS['strTypeWebMode'] = "Metode Penyimpanan";
$GLOBALS['strTypeWebModeLocal'] = "Direktori lokal";
$GLOBALS['strTypeWebModeFtp'] = "Server FTP eksternal";
$GLOBALS['strTypeWebDir'] = "Direktori lokal";
$GLOBALS['strTypeFTPHost'] = "Host FTP";
$GLOBALS['strTypeFTPDirectory'] = "Direktori Host";
$GLOBALS['strTypeFTPPassword'] = "Kata Sandi";
$GLOBALS['strTypeFTPPassive'] = "Gunakan FTP pasif";
$GLOBALS['strTypeFTPErrorDir'] = "Direktori dari hosti FTP tidak ada";
$GLOBALS['strTypeFTPErrorConnect'] = "Koneksi ke server FTP gagal. Nama login atau kata sandi salah";
$GLOBALS['strTypeFTPErrorHost'] = "Hosti FTP yang dipilih salah";
$GLOBALS['strDeliveryFilenames'] = "Nama-nama file dari Penyampaian Global";
$GLOBALS['strDeliveryFilenamesLocal'] = "Invokasi lokal";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Kontrol depan";
$GLOBALS['strDeliveryFilenamesFlash'] = "Pencakupan Flash (Alamat URL lengkap diizinkan)";
$GLOBALS['strDeliveryCaching'] = "Penyetelan global untuk caching penyampaian";
$GLOBALS['strDeliveryCacheLimit'] = "Time Between Cache Updates (seconds)";
$GLOBALS['strDeliveryAcls'] = "Evaluasikan limitasi dari penyampaian banner pada saat penyampaian";
$GLOBALS['strDeliveryObfuscate'] = "Mengkaburkan saluran pada saat penyampaian iklan";
$GLOBALS['strDeliveryExecPhp'] = "Izinkan eksekusi kode PHP dalam iklan<br />(Perhatian: Resiko Keamanan)";
$GLOBALS['strP3PSettings'] = "Kebijaksanaan keleluasaan pribadi global P3P";
$GLOBALS['strUseP3P'] = "Gunakan kebijaksanaan P3P";
$GLOBALS['strP3PPolicyLocation'] = "Lokasi dari kebijaksanaan P3P";

// General Settings
$GLOBALS['generalSettings'] = "Penyetelan Global Umum";
$GLOBALS['uiEnabled'] = "Interface untuk pengguna diaktifkan";
$GLOBALS['defaultLanguage'] = "Anggapan Bahasa yang digunakan<br />(Setiap pengguna dapat memilih bahasa yang diinginkan)";

// Geotargeting Settings
$GLOBALS['strGeotargeting'] = "Penyetelan Global Geotargeting";
$GLOBALS['strGeotargetingType'] = "Jenis modul Geotargeting";
$GLOBALS['strGeoShowUnavailable'] = "Tampilkan limitasi penyampaian dari geotargeting meskipun data GeoIP tidak tersedia";

// Interface Settings
$GLOBALS['strInventory'] = "Inventori";
$GLOBALS['strShowCampaignInfo'] = "Tampilkan informasi tambahan tentang kampanya pada halaman <i>Peninjauan Luas Kampanye</i>";
$GLOBALS['strShowBannerInfo'] = "Tampilkan informasi tambahan tentang banner pada halaman <i>Peninjauan Luas Banner</i>";
$GLOBALS['strShowCampaignPreview'] = "Tampilkan pertunjukan pendahuluan dari seluruh banner pada halaman <i>Peninjauan Luas Banner</i>";
$GLOBALS['strHideInactive'] = "Sembunyikan yang tidak aktif";
$GLOBALS['strStatisticsDefaults'] = "Statistik";
$GLOBALS['strPercentageDecimals'] = "Presentase dari angka desimal";
$GLOBALS['strWeightDefaults'] = "Bobot anggapan";
$GLOBALS['strDefaultBannerWeight'] = "Bobot anggapan untuk banner";
$GLOBALS['strDefaultCampaignWeight'] = "Bobot anggapan untuk kamanye";

// Invocation Settings
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Aktifkan Pelacak Klik (Clicktracking) dari pihak ketiga secara anggapan";

// Banner Delivery Settings

// Banner Logging Settings
$GLOBALS['strLogAdRequests'] = "Log an Ad Request every time an advertisement is requested";
$GLOBALS['strLogAdImpressions'] = "Log an Ad Impression every time an advertisement is viewed";
$GLOBALS['strLogAdClicks'] = "Log an Ad Click every time a viewer clicks on an advertisement";
$GLOBALS['strPreventLogging'] = "Global Prevent Statistics Logging Settings";
$GLOBALS['strIgnoreHosts'] = "Don't store statistics for viewers using one of the following IP addresses or hostnames";

// Banner Storage Settings

// Campaign ECPM settings

// Statistics & Maintenance Settings
$GLOBALS['strBlockAdClicks'] = "Don't log an Ad Click if the viewer has clicked on the same ad within the specified time (seconds)";
$GLOBALS['strPrioritySettings'] = "Penyetelan prioritas secara global";
$GLOBALS['strAdminEmailHeaders'] = "Tambahkan header berikut pada semua E-Mail yang dikirimkan oleh {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Kirimkan pemberitahuan bilamana jumlah impresi yang tersisa kurang dari jumlah impresi yang ditentukan disini";
$GLOBALS['strWarnLimitDays'] = "Kirimkan pemberitahuan bilamana jumlah hari yang tersisa kurang dari jumlah hari yang ditentukan disini";
$GLOBALS['strWarnAgency'] = "Send a warning to the agency every time a campaign is almost expired";

// UI Settings
$GLOBALS['strGuiSettings'] = "Penyetelan Interface Pengguna";
$GLOBALS['strGeneralSettings'] = "Penyetelan Umum";
$GLOBALS['strAppName'] = "Nama Aplikasi";
$GLOBALS['strMyHeader'] = "Lokasi dari file Header";
$GLOBALS['strMyFooter'] = "Lokasi dari file Footer";
$GLOBALS['strDefaultTrackerStatus'] = "Anggapan Status dari pelacak";
$GLOBALS['strDefaultTrackerType'] = "Jenis pelacak anggapan";
$GLOBALS['requireSSL'] = "Paksakan penggunaan SSL pada interface Pengguna";
$GLOBALS['sslPort'] = "Port SSL yang digunakan oleh Web Server";
$GLOBALS['strMyLogo'] = "Nama dari file lambang kegaliban";
$GLOBALS['strGuiHeaderForegroundColor'] = "Warna dari header pada latar depan";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Warna dari header pada latar belakang";
$GLOBALS['strGuiActiveTabColor'] = "Warna dari tab yang aktif";
$GLOBALS['strGuiHeaderTextColor'] = "Warna dari teks dalam header";
$GLOBALS['strGzipContentCompression'] = "Gunakan GZIP Content Compression";

// Regenerate Platfor Hash script

// Plugin Settings
