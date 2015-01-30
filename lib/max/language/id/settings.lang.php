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
$GLOBALS['strAdminSettings'] = "Penyetelan Administrator";
$GLOBALS['strAdminAccount'] = "Administrator Account";
$GLOBALS['strAdvancedSettings'] = "Penyetelan Lanjut";
$GLOBALS['strWarning'] = "Peringatan";
$GLOBALS['strBtnContinue'] = "Lanjut &raquo;";
$GLOBALS['strBtnRecover'] = "Bangkitkan kembali &raquo;";
$GLOBALS['strBtnStartAgain'] = "Ulangi proses upgrade &raquo;";
$GLOBALS['strBtnGoBack'] = "&laquo; Kembali";
$GLOBALS['strBtnAgree'] = "Saya setuju &raquo;";
$GLOBALS['strBtnDontAgree'] = "« Saya tidak setuju";
$GLOBALS['strBtnRetry'] = "Coba kembali";
$GLOBALS['strWarningRegisterArgcArv'] = "Variabel register_argc_argv dalam konfigurasi PHP harus berada dalam posisi ON untuk jalankan pemeliharaan dari Command Line.";
$GLOBALS['strTablesType'] = "Jenis Tabel";


$GLOBALS['strRecoveryRequiredTitle'] = "Proses upgrade semula mengalami sebuah Error";
$GLOBALS['strRecoveryRequired'] = "Telah terjadi sebuah Error pada saat memproses upgrade yang sebelumnya dan {$PRODUCT_NAME} perlu membangkitkan proses upgrade terlebih dahulu. Mohon klik tombol Bangkitkan dibawah.";

$GLOBALS['strOaUpToDate'] = "Database dan struktur file dari {$PRODUCT_NAME} sudah menggunakan versi yang terbaru. Maka dengan itu upgrade untuk sementara waktu tidak diperlukan. Mohon klik Lanjut untuk diantar ke panel administrasi dari {$PRODUCT_NAME}.";
$GLOBALS['strOaUpToDateCantRemove'] = "Perhatian: File UPGRADE masih berada dalam direktori var. Kami tidak dapat menghapus file tersebut disebabkan oleh permission yang tidak cukup. Mohon hapuskan file tersebut secara manual.";
$GLOBALS['strRemoveUpgradeFile'] = "Anda harus menghapus file UPGRADE dari direktori var.";
$GLOBALS['strInstallSuccess'] = "<strong>Selamat! Anda telah berhasil menginstal program Openads</strong>
<p>Selamat datang di komunitas Openads! Untuk memperlancar penggunaan aplikasi Openads masih tertinggal dua langkah lagi yang perlu ditempuhkan.</p>

<p><strong>Maintenance</strong><br>
Openads telah dikonfigurasikan untuk menjalankan berberapa tugas pemeliharaan pada setiap jam selama melayani penyediaan iklan. Untuk memperlancar penyampaian Anda dapat menyetel proses ini untuk memanggil file pemeliharaan secara otomatis pada setiap jam (seumpamana dengan sebuah cron job). Hal ini tidak diwajibkan tetapi sangat disarankan. Untuk informasi lebih lanjut silakan belajari dokumentasi pada <a href='http://{$PRODUCT_DOCSURL}' target='_blank'><strong>documentation</strong></a>.</p>

<p><strong>Security</strong><br>
Instalasi Openads membutuhkan file konfigurasi yang dapat ditulis/diubah oleh server. Segera setelah Anda melakukan perubahan pada file konfigurasi tersebut kami anjurkan dengan tegas untuk ubah permission dari file konigurasi menjadi read-only untuk mencapai tingkat keamanan yang tinggi. Untuk informasi lebih lanjut silakan belajari pedoman tentang hal ini pada <a href='http://{$PRODUCT_DOCSURL}' target='_blank'><strong>documentation</strong></a>.</p>

<p>Anda sudah siap untuk menggunakan aplikasi Openads. Klik Lanjut akan mengantar Anda ke versi terbaru dari Openads.</p>
<p>Sebelum Anda mulai menggunakan Openads kami sarankan untuk me-review penyetelan konfigurasi dari aplikasi yang dapat ditemukan pada bagian \"Penyetelan\".";
$GLOBALS['strInstallNotSuccessful'] = "<b>Instalasi {$PRODUCT_NAME} tidak berhasil</b><br /><br />Ada berberapa bagian dari proses instalasi yang tidak dapat diselesaikan.
Ada kemungkinan bahwah masal ini hanya bersifat sementara saja. Bila memang begitu Anda dapat mengklik <b>Lanjut</b> untuk diantar kembali ke
langka pertama dari proses instalasi. Bila Anda ingin mengetahui secara lebih mendalam tentang Error Message dibawah ini dan caranya untuk mengatasi masalah ini,
silakan belajari kembali pedoman aplikasi yang disediakan.";
$GLOBALS['strDbSuccessIntro'] = "Database untuk berhasil dibuat. Silakan klik tombol 'Lanjut' untuk mengatur konfigurasi Administrator dari {$PRODUCT_NAME} dan penyetelan penyampaian iklan.";
$GLOBALS['strDbSuccessIntroUpgrade'] = "Database untuk  berhasil di-update. Silakan klik tombol 'Lanjut' untuk me-review  Penyetelan Administrator dan Penyampaian iklan.";
$GLOBALS['strErrorOccured'] = "Error yang dialami sbb.:";
$GLOBALS['strErrorInstallDatabase'] = "Struktur database gagal dibangun.";
$GLOBALS['strErrorInstallPrefs'] = "Preferensi pengguna Administrator gagal ditulis dalam database.";
$GLOBALS['strErrorInstallVersion'] = "Nomor versi dari {$PRODUCT_NAME} gagal ditulis dalam database.";
$GLOBALS['strErrorUpgrade'] = 'Instalasi dari database yang sudah ada gagal di-upgrade.';
$GLOBALS['strErrorInstallDbConnect'] = "Gagal membuka koneksi ke database.";

$GLOBALS['strErrorWritePermissions'] = "Error pada File permission terdeteksi. Masalah ini harus diperbaiki terlebih dahulu sebelum melanjut.<br />To fix the errors on a Linux system, try typing in the following command(s):";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod a+w %s</i>";

$GLOBALS['strErrorWritePermissionsWin'] = "Error pada File permission terdeteksi. Masalah ini harus diperbaiki terlebih dahulu sebelum melanjut.";
$GLOBALS['strCheckDocumentation'] = "Pertolongan untuk mengatasi masalah ini dapat ditemukan pada <a href='http://{$PRODUCT_DOCSURL}'>Dokumentasi {$PRODUCT_NAME}</a>.";

$GLOBALS['strAdminUrlPrefix'] = "URL tampilan untuk Admin";
$GLOBALS['strDeliveryUrlPrefix'] = "URL tampilan untuk mesin penyampaian iklan";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL tampilan untuk mesin penyampaian iklan (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL penyimpanan gambar";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL penyimpanan gambar (SSL)";

$GLOBALS['strInvalidUserPwd'] = "Nama Pengguna atau Kata Sandi tidak benar";

$GLOBALS['strSystemUpToDate'] = "Sistem Anda sudah aktual. Upgrade pada saat ini tidak diperlukan. <br>Klik <b>Lanjut</b> untuk melanjut ke halaman muka.";
$GLOBALS['strSystemNeedsUpgrade'] = "Struktur database dan file konfigurasi perlu di-upgrade untuk berfungsi dengan baik. Klik <b>Lanjut</b> untuk memulai proses upgrade. <br><br>Tergantung pada versi yang di-upgrade dan pada jumlah statistik yang telah tersimpan pada database, proses ini dapat mengakibatkan beban yang tinggi pada database server. Mohon sabar, proses upgrade membutuhkan waktu berberapa menit.";
$GLOBALS['strSystemUpgradeBusy'] = "Upgrade sistem dalam proses, silakan tunggu...";
$GLOBALS['strSystemRebuildingCache'] = "Bangun ulang cache, silakan tunggu...";
$GLOBALS['strServiceUnavalable'] = "Fasilitas tidak tersedia. Upgrade sistem dalam proses";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Pilih Bagian";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons. " .
    "If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues. " .
    "If you want to secure your system, you need to lock the configuration file for this installation.";
$GLOBALS['strUnableToWriteConfig'] = "Gagal menulis perubahan pada config file";
$GLOBALS['strUnableToWritePrefs'] = "Gagal mengirim preferensi kepada database";
$GLOBALS['strImageDirLockedDetected'] = "<b>Direktori Gambar</b> yang diberikan tidak bisa ditulis oleh server. <br>Anda tidak dapat melanjut sebelum permissions dari direktori tersebut diubah atau direktori tersebut dibuatkan.";

// Configuration Settings
$GLOBALS['strConfigurationSetup'] = "Setup konfigurasi";
$GLOBALS['strConfigurationSettings'] = "Penyetelan konfigurasi";

// Administrator Settings
$GLOBALS['strAdministratorSettings'] = "Penyetelan Administrator";
$GLOBALS['strAdministratorAccount'] = "Account Administrator";
$GLOBALS['strLoginCredentials'] = "Data Login";
$GLOBALS['strAdminUsername'] = "Nama pengguna Administrator";
$GLOBALS['strAdminPassword'] = "Kata sandi Administrator";
$GLOBALS['strInvalidUsername'] = "Nama pengguna tidak berlaku";
$GLOBALS['strBasicInformation'] = "Informasi Dasar";
$GLOBALS['strAdminFullName'] = "Nama lengkap Admin";
$GLOBALS['strAdminEmail'] = "Alamat E-Mail Admin";
$GLOBALS['strAdministratorEmail'] = "Alamat E-Mail Administrator";
$GLOBALS['strCompanyName'] = "Nama perusahaan";
$GLOBALS['strAdminCheckUpdates'] = "Cari Update";
$GLOBALS['strAdminCheckEveryLogin'] = "Setiap Login";
$GLOBALS['strAdminCheckDaily'] = "Setiap hari";
$GLOBALS['strAdminCheckWeekly'] = "Setiap minggu";
$GLOBALS['strAdminCheckMonthly'] = "Setiap bulan";
$GLOBALS['strAdminCheckNever'] = "tidak samasekali";
$GLOBALS['strUserlogEmail'] = "Catat seluruh E-Mail yang dikirim";
$GLOBALS['strEnableDashboard'] = "Aktifkan Dashboard";
$GLOBALS['strTimezone'] = "Zona waktu";
$GLOBALS['strTimezoneEstimated'] = "Perkiraan zona waktu";
$GLOBALS['strTimezoneGuessedValue'] = "Zona waktu pada PHP tidak distel dengan benar";
$GLOBALS['strTimezoneSeeDocs'] = "Silakan belajari %DOCS% tentang caranya mengatur variabel ini pada PHP.";
$GLOBALS['strTimezoneDocumentation'] = "dokumentasi";
$GLOBALS['strAdminSettingsTitle'] = "Akun Administrator Anda";
$GLOBALS['strAdminSettingsIntro'] = "Akun Administrator digunakan untuk login ke tampilan  dan untuk mengatur inventori, statistik dan membuat tags. Silakan masukkan nama pengguna, kata sandi dan alamat E-Mail Administrator.";
$GLOBALS['strConfigSettingsIntro'] = "Silakan periksa kembali penyetelan konfigurasi yang berikut ini dengan teliti, sehubungan penyetelan ini sangat penting untuk penggunaan dan performa aplikasi {$PRODUCT_NAME}";

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
$GLOBALS['strDemoDataInstall'] = "Instal data Demo";
$GLOBALS['strDemoDataIntro'] = "Setup anggapan dapat diangkat ke {$PRODUCT_NAME} untuk menolong Anda melayani periklanan secara online. Jenis banner yang paling umum berikut berberapa kampanye awal dapat diangkat dan dikonfigurasikan mula. Hal ini sangat disarankan untuk setiap instalasi baru.";



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
$GLOBALS['strDeliverySettings'] = "Penyetelan Penyampaian";
$GLOBALS['strWebPath'] = "$PRODUCT_NAME Server Access Paths";
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


$GLOBALS['strOrigin'] = "Gunakan server muasal remote";
$GLOBALS['strOriginType'] = "Jenis server muasal";
$GLOBALS['strOriginHost'] = "Nama host dari server muasal";
$GLOBALS['strOriginPort'] = "Nomor port dari database muasal";

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
$GLOBALS['strGeotargetingGeoipCountryLocation'] = "Lokasi dari database MaxMind GeoIP Country<br />(Tinggalkan kosong untuk menggunakan free database)";
$GLOBALS['strGeotargetingGeoipRegionLocation'] = "Lokasi dari database MaxMind GeoIP Region";
$GLOBALS['strGeotargetingGeoipCityLocation'] = "Lokasi dari database MaxMind GeoIP City";
$GLOBALS['strGeotargetingGeoipAreaLocation'] = "Lokasi dari database MaxMind GeoIP Area";
$GLOBALS['strGeotargetingGeoipDmaLocation'] = "Lokasi dari database MaxMind GeoIP DMA";
$GLOBALS['strGeotargetingGeoipOrgLocation'] = "Lokasi dari database MaxMind GeoIP Organisation";
$GLOBALS['strGeotargetingGeoipIspLocation'] = "Lokasi dari database MaxMind GeoIP ISP";
$GLOBALS['strGeotargetingGeoipNetspeedLocation'] = "Lokasi dari database MaxMind GeoIP Netspeed";
$GLOBALS['strGeoShowUnavailable'] = "Tampilkan limitasi penyampaian dari geotargeting meskipun data GeoIP tidak tersedia";
$GLOBALS['strGeotrackingGeoipCountryLocationError'] = "Database MaxMind GeoIP Country tidak ditemukan pada lokasi yang ditunjukkan";
$GLOBALS['strGeotrackingGeoipRegionLocationError'] = "Database GeoIP Region tidak ditemukan pada lokasi yang ditunjukkan";
$GLOBALS['strGeotrackingGeoipCityLocationError'] = "Database GeoIP City tidak ditemukan pada lokasi yang ditunjukkan";
$GLOBALS['strGeotrackingGeoipAreaLocationError'] = "Database GeoIP Area tidak ditemukan pada lokasi yang ditunjukkan";
$GLOBALS['strGeotrackingGeoipDmaLocationError'] = "Database GeoIP DMA tidak ditemukan pada lokasi yang ditunjukkan";
$GLOBALS['strGeotrackingGeoipOrgLocationError'] = "Database GeoIP Organisation tidak ditemukan pada lokasi yang ditunjukkan";
$GLOBALS['strGeotrackingGeoipIspLocationError'] = "Database GeoIP ISP tidak ditemukan pada lokasi yang ditunjukkan";
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = "Database GeoIP Netspeed tidak ditemukan pada lokasi yang ditunjukkan";

// Interface Settings
$GLOBALS['strInventory'] = "Inventori";
$GLOBALS['strUploadConversions'] = "Upload Konversi";
$GLOBALS['strShowCampaignInfo'] = "Tampilkan informasi tambahan tentang kampanya pada halaman <i>Peninjauan Luas Kampanye</i>";
$GLOBALS['strShowBannerInfo'] = "Tampilkan informasi tambahan tentang banner pada halaman <i>Peninjauan Luas Banner</i>";
$GLOBALS['strShowCampaignPreview'] = "Tampilkan pertunjukan pendahuluan dari seluruh banner pada halaman <i>Peninjauan Luas Banner</i>";
$GLOBALS['strHideInactive'] = "Sembunyikan yang tidak aktif";
$GLOBALS['strStatisticsDefaults'] = "Statistik";
$GLOBALS['strPercentageDecimals'] = "Presentase dari angka desimal";
$GLOBALS['strWeightDefaults'] = "Bobot anggapan";
$GLOBALS['strDefaultBannerWeight'] = "Bobot anggapan untuk banner";
$GLOBALS['strDefaultCampaignWeight'] = "Bobot anggapan untuk kamanye";

$GLOBALS['strPublisherDefaults'] = "Anggapan untuk Penerbit";
$GLOBALS['strModesOfPayment'] = "Cara pembayaran";
$GLOBALS['strCurrencies'] = "Mata uang";
$GLOBALS['strCategories'] = "Kategori";
$GLOBALS['strHelpFiles'] = "File Bantuan";
$GLOBALS['strHasTaxID'] = "NPWP";
$GLOBALS['strDefaultApproved'] = "Kotak tick Persetujuan";

// CSV Import Settings
$GLOBALS['strChooseAdvertiser'] = "Pilih Pemasang Iklan";
$GLOBALS['strChooseCampaign'] = "Pilih Kampanye";
$GLOBALS['strChooseCampaignBanner'] = "Pilih Banner";
$GLOBALS['strChooseTracker'] = "Pilih Pelacak";
$GLOBALS['strDefaultConversionStatus'] = "Aturan konversi Deafault";
$GLOBALS['strDefaultConversionType'] = "Aturan konversi Deafault";
$GLOBALS['strCSVTemplateSettings'] = "Penyetelan template CSV";
$GLOBALS['strIncludeCountryInfo'] = "Mengikutkan informasi tentang negara";
$GLOBALS['strIncludeBrowserInfo'] = "Mengikutkan informasi tentang Browser";
$GLOBALS['strIncludeOSInfo'] = "Mengikutkan informasi tentang sistem operasi";
$GLOBALS['strIncludeSampleRow'] = "Mengikutkan barisan contoh";
$GLOBALS['strCSVTemplateAdvanced'] = "Template mengedepan";
$GLOBALS['strCSVTemplateIncVariables'] = "Mengikutkan informasi tentang variabel dari Pelacak";

/**
 * @todo remove strBannerSettings if banner is only configurable as a preference
 *       rename // Banner Settings to  // Banner Preferences
 */
// Invocation Settings
$GLOBALS['strAllowedInvocationTypes'] = "Jenis Invokasi yang diizinkan";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Aktifkan Pelacak Klik (Clicktracking) dari pihak ketiga secara anggapan";

// Banner Delivery Settings

// Banner Logging Settings
$GLOBALS['strLogAdRequests'] = "Log an Ad Request every time an advertisement is requested";
$GLOBALS['strLogAdImpressions'] = "Log an Ad Impression every time an advertisement is viewed";
$GLOBALS['strLogAdClicks'] = "Log an Ad Click every time a viewer clicks on an advertisement";
$GLOBALS['strLogTrackerImpressions'] = "Log a Tracker Impression every time a tracker beacon viewed";
$GLOBALS['strPreventLogging'] = "Global Prevent Statistics Logging Settings";
$GLOBALS['strIgnoreHosts'] = "Don't store statistics for viewers using one of the following IP addresses or hostnames";

// Banner Storage Settings

// Campaign ECPM settings

// Statistics & Maintenance Settings
$GLOBALS['strBlockAdViews'] = "Don't log an Ad Impression if the viewer has seen the same ad within the specified time (seconds)";
$GLOBALS['strBlockAdClicks'] = "Don't log an Ad Click if the viewer has clicked on the same ad within the specified time (seconds)";
$GLOBALS['strPrioritySettings'] = "Penyetelan prioritas secara global";
$GLOBALS['strAdminEmailHeaders'] = "Tambahkan header berikut pada semua E-Mail yang dikirimkan oleh {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Kirimkan pemberitahuan bilamana jumlah impresi yang tersisa kurang dari jumlah impresi yang ditentukan disini";
$GLOBALS['strWarnLimitErr'] = "Pemberitahuan batas harus dalam angka positiv";
$GLOBALS['strWarnLimitDays'] = "Kirimkan pemberitahuan bilamana jumlah hari yang tersisa kurang dari jumlah hari yang ditentukan disini";
$GLOBALS['strWarnLimitDaysErr'] = "Pemberitahuan tentang jumlah hari yang tersisa harus dalam angka positiv";
$GLOBALS['strAllowEmail'] = "Izinkan pengiriman E-Mail secara umum";
$GLOBALS['strEmailAddressName'] = "Company or personal name to sign off e-mail with";
$GLOBALS['strWarnAgency'] = "Send a warning to the agency every time a campaign is almost expired";

// UI Settings
$GLOBALS['strGuiSettings'] = "Penyetelan Interface Pengguna";
$GLOBALS['strGeneralSettings'] = "Penyetelan Umum";
$GLOBALS['strAppName'] = "Nama Aplikasi";
$GLOBALS['strMyHeader'] = "Lokasi dari file Header";
$GLOBALS['strMyHeaderError'] = "File header tidak ditemukan dalam lokasi yang ditunjuk oleh Anda";
$GLOBALS['strMyFooter'] = "Lokasi dari file Footer";
$GLOBALS['strMyFooterError'] = "File footer tidak ditemukan dalam lokasi yang ditunjuk oleh Anda";
$GLOBALS['strDefaultTrackerStatus'] = "Anggapan Status dari pelacak";
$GLOBALS['strDefaultTrackerType'] = "Jenis pelacak anggapan";
$GLOBALS['requireSSL'] = "Paksakan penggunaan SSL pada interface Pengguna";
$GLOBALS['sslPort'] = "Port SSL yang digunakan oleh Web Server";

$GLOBALS['strMyLogo'] = "Nama dari file lambang kegaliban";
$GLOBALS['strMyLogoError'] = "Nama dari file lambang tidak ditemukan dalam direktori admin/images";
$GLOBALS['strGuiHeaderForegroundColor'] = "Warna dari header pada latar depan";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Warna dari header pada latar belakang";
$GLOBALS['strGuiActiveTabColor'] = "Warna dari tab yang aktif";
$GLOBALS['strGuiHeaderTextColor'] = "Warna dari teks dalam header";
$GLOBALS['strColorError'] = "Silakan masukkan warna dalam format RGB, seperti '0066CC'";

$GLOBALS['strGzipContentCompression'] = "Gunakan GZIP Content Compression";
$GLOBALS['strClientInterface'] = "Interface Pemasang Iklan";
$GLOBALS['strReportsInterface'] = "Interface Laporan";
$GLOBALS['strClientWelcomeEnabled'] = "Aktifkan pesan Selamat Datang untuk pemasang iklan";
$GLOBALS['strClientWelcomeText'] = "Pesan Selamat Datang<br />(Tag HTML diizinkan)";

$GLOBALS['strPublisherInterface'] = "Interface Penerbit";
$GLOBALS['strPublisherAgreementEnabled'] = "Aktifkan pengendalian Login untuk penerbit yang belum mengsetujui Tata Tertip dan Persyaratan";
$GLOBALS['strPublisherAgreementText'] = "Pesan yang ditampilkan pada saat Login (Tag HTML diizinkan)";

// Regenerate Platfor Hash script

// Plugin Settings

/* ------------------------------------------------------- */
/* Unknown (unused?) translations                        */
/* ------------------------------------------------------- */


$GLOBALS['strTimeZone'] = "Zona Waktu";
