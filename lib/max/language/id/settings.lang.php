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
$GLOBALS['strTablesPrefix'] = "Awalan nama tabel";
$GLOBALS['strTablesType'] = "Jenis Tabel";

$GLOBALS['strRecoveryRequiredTitle'] = "Proses upgrade semula mengalami sebuah Error";
$GLOBALS['strRecoveryRequired'] = "Telah terjadi sebuah Error pada saat memproses upgrade yang sebelumnya dan {$PRODUCT_NAME} perlu membangkitkan proses upgrade terlebih dahulu. Mohon klik tombol Bangkitkan dibawah.";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} sudah terbaru";
$GLOBALS['strOaUpToDate'] = "Database dan struktur file dari {$PRODUCT_NAME} sudah menggunakan versi yang terbaru. Maka dengan itu upgrade untuk sementara waktu tidak diperlukan. Mohon klik Lanjut untuk diantar ke panel administrasi dari {$PRODUCT_NAME}.";
$GLOBALS['strOaUpToDateCantRemove'] = "Perhatian: File UPGRADE masih berada dalam direktori var. Kami tidak dapat menghapus file tersebut disebabkan oleh permission yang tidak cukup. Mohon hapuskan file tersebut secara manual.";
$GLOBALS['strErrorWritePermissions'] = "Error pada File permission terdeteksi. Masalah ini harus diperbaiki terlebih dahulu sebelum melanjut.<br />To fix the errors on a Linux system, try typing in the following command(s):";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod a+w %s</i>";
$GLOBALS['strNotWriteable'] = "TIDAK bisa ditulisi";
$GLOBALS['strDirNotWriteableError'] = "Direktori harus dapat ditulisi";

$GLOBALS['strErrorWritePermissionsWin'] = "Error pada File permission terdeteksi. Masalah ini harus diperbaiki terlebih dahulu sebelum melanjut.";
$GLOBALS['strCheckDocumentation'] = "Pertolongan untuk mengatasi masalah ini dapat ditemukan pada <a href='http://{$PRODUCT_DOCSURL}'>Dokumentasi {$PRODUCT_NAME}</a>.";
$GLOBALS['strSystemCheckBadPHPConfig'] = "Konfigurasi PHP anda saat ini tidak memenuhi persyaratan {$PRODUCT_NAME}. Untuk mengatasi masalah, mohon modifikasi setting di file 'php.ini' Anda.";

$GLOBALS['strAdminUrlPrefix'] = "URL tampilan untuk Admin";
$GLOBALS['strDeliveryUrlPrefix'] = "URL tampilan untuk mesin penyampaian iklan";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL tampilan untuk mesin penyampaian iklan (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL penyimpanan gambar";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL penyimpanan gambar (SSL)";


$GLOBALS['strUpgrade'] = "Meningkatkan";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Pilih bagian";
$GLOBALS['strEditConfigNotPossible'] = "Tidak mungkin mengedit semua pengaturan karena file konfigurasi terkunci karena alasan keamanan.
     Jika Anda ingin melakukan perubahan, Anda mungkin perlu membuka file konfigurasi untuk penginstalan ini terlebih dahulu.";
$GLOBALS['strEditConfigPossible'] = "Hal ini dimungkinkan untuk mengedit semua pengaturan karena file konfigurasi tidak terkunci, namun hal ini dapat menyebabkan masalah keamanan.
     Jika Anda ingin mengamankan sistem Anda, Anda perlu mengunci file konfigurasi untuk penginstalan ini.";
$GLOBALS['strUnableToWriteConfig'] = "Gagal menulis perubahan pada config file";
$GLOBALS['strUnableToWritePrefs'] = "Gagal mengirim preferensi kepada database";
$GLOBALS['strImageDirLockedDetected'] = "<b>Direktori Gambar</b> yang diberikan tidak bisa ditulis oleh server. <br>Anda tidak dapat melanjut sebelum permissions dari direktori tersebut diubah atau direktori tersebut dibuatkan.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Pengaturan konfigurasi";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Nama pengguna Administrator";
$GLOBALS['strAdminPassword'] = "Kata sandi Administrator";
$GLOBALS['strInvalidUsername'] = "Nama pengguna tidak berlaku";
$GLOBALS['strBasicInformation'] = "Informasi Dasar";
$GLOBALS['strAdministratorEmail'] = "Alamat E-Mail Administrator";
$GLOBALS['strAdminCheckUpdates'] = "Cari Update";
$GLOBALS['strAdminShareStack'] = "Bagikan informasi teknis dengan Tim {$PRODUCT_NAME} untuk membantu pengembangan dan pengujian.";
$GLOBALS['strNovice'] = "Hapus tindakan memerlukan konfirmasi keamanan";
$GLOBALS['strUserlogEmail'] = "Catat seluruh E-Mail yang dikirim";
$GLOBALS['strEnableDashboard'] = "Aktifkan Dashboard";
$GLOBALS['strEnableDashboardSyncNotice'] = "Aktifkan <a href='account-settings-update.php'>periksa pembaruan</a> untuk menggunakan dasbor.";
$GLOBALS['strTimezone'] = "Zona waktu";
$GLOBALS['strEnableAutoMaintenance'] = "Bila jadwal untuk pemeliharaan tidak di-set pada Cron, jalankan pemeliharaan dengan cara otomatis pada saat penyampaian iklan";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Penyetelan Database";
$GLOBALS['strDatabaseServer'] = "Database Server";
$GLOBALS['strDbLocal'] = "Koneksi ke server lokal dengan menggunakan socket";
$GLOBALS['strDbType'] = "Jenis Database";
$GLOBALS['strDbHost'] = "Hostname Database";
$GLOBALS['strDbSocket'] = "Soket basis data";
$GLOBALS['strDbPort'] = "Port Number Database";
$GLOBALS['strDbUser'] = "Pengguna Database";
$GLOBALS['strDbPassword'] = "Kata Sandi Database";
$GLOBALS['strDbName'] = "Nama Database";
$GLOBALS['strDbNameHint'] = "Database akan dibuat jika tidak ada";
$GLOBALS['strDatabaseOptimalisations'] = "Optimalisasi Database";
$GLOBALS['strPersistentConnections'] = "Gunakan Koneksi Persistent";
$GLOBALS['strCantConnectToDb'] = "Koneksi ke Database gagal";
$GLOBALS['strCantConnectToDbDelivery'] = 'Tidak dapat terhubung ke database untuk pengiriman';

// Email Settings
$GLOBALS['strEmailSettings'] = "Penyetelan Utama";
$GLOBALS['strEmailAddresses'] = "Email 'Dari' Alamat";
$GLOBALS['strEmailFromName'] = "Email 'Dari' Nama";
$GLOBALS['strEmailFromAddress'] = "Email 'Dari' Alamat Email";
$GLOBALS['strEmailFromCompany'] = "Email 'Dari' Perusahaan";
$GLOBALS['strUseManagerDetails'] = 'Gunakan Kontak, Email dan Nama pemiliknya, bukan Nama, Alamat Email dan Perusahaan di atas saat mengirim laporan melalui email ke akun Pengiklan atau Situs Web.';
$GLOBALS['strQmailPatch'] = "Aktifkan qmail patch";
$GLOBALS['strEnableQmailPatch'] = "Aktifkan patch qmail";
$GLOBALS['strEmailHeader'] = "Header email";
$GLOBALS['strEmailLog'] = "Log email";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Pengaturan Jejak Audit";
$GLOBALS['strEnableAudit'] = "Aktifkan Jejak Audit";
$GLOBALS['strEnableAuditForZoneLinking'] = "Aktifkan Trail Audit untuk layar Zona Menghubungkan (memperkenalkan hukuman kinerja yang sangat besar saat menghubungkan sejumlah besar zona)";

// Debug Logging Settings
$GLOBALS['strDebug'] = "Penyetelan Global Debug Logging";
$GLOBALS['strEnableDebug'] = "Aktifkan Debug Logging";
$GLOBALS['strDebugMethodNames'] = "Mencakupkan nama metode pada debug log";
$GLOBALS['strDebugLineNumbers'] = "Mencakupkan nomor garis pada debug log";
$GLOBALS['strDebugType'] = "Jenis Debug Log";
$GLOBALS['strDebugTypeFile'] = "Mengajukan";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "Database SQL";
$GLOBALS['strDebugTypeSyslog'] = "Syslog";
$GLOBALS['strDebugName'] = "Debug Log Name, Calendar, SQL Table,<br />atau Syslog Facility";
$GLOBALS['strDebugPriority'] = "Tingkat Prioritas Debug";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Sebagian besar informasi";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Informasi anggapan";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - Informasi Paling Sedikit";
$GLOBALS['strDebugIdent'] = "String Identifikasi Debug";
$GLOBALS['strDebugUsername'] = "mCal, nama pengguna SQL Server";
$GLOBALS['strDebugPassword'] = "mCal, SQL Server Password";
$GLOBALS['strProductionSystem'] = "Sistem produksi";

// Delivery Settings
$GLOBALS['strWebPath'] = "{$PRODUCT_NAME} Jalur Akses Server";
$GLOBALS['strWebPathSimple'] = "Lintasan Web";
$GLOBALS['strDeliveryPath'] = "Cache penyampaian";
$GLOBALS['strImagePath'] = "Lintasan gambar";
$GLOBALS['strDeliverySslPath'] = "Cache penyampaian";
$GLOBALS['strImageSslPath'] = "Lintasan SSL gambar";
$GLOBALS['strImageStore'] = "Folder gambar";
$GLOBALS['strTypeWebSettings'] = "Global Webserver Local Banner Storage Settings";
$GLOBALS['strTypeWebMode'] = "Metode Penyimpanan";
$GLOBALS['strTypeWebModeLocal'] = "Direktori lokal";
$GLOBALS['strTypeDirError'] = "Direktori lokal tidak dapat ditulis oleh server web";
$GLOBALS['strTypeWebModeFtp'] = "Server FTP eksternal";
$GLOBALS['strTypeWebDir'] = "Direktori lokal";
$GLOBALS['strTypeFTPHost'] = "Host FTP";
$GLOBALS['strTypeFTPDirectory'] = "Direktori Host";
$GLOBALS['strTypeFTPUsername'] = "Masuk";
$GLOBALS['strTypeFTPPassword'] = "Kata Sandi";
$GLOBALS['strTypeFTPPassive'] = "Gunakan FTP pasif";
$GLOBALS['strTypeFTPErrorDir'] = "Direktori dari hosti FTP tidak ada";
$GLOBALS['strTypeFTPErrorConnect'] = "Koneksi ke server FTP gagal. Nama login atau kata sandi salah";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Instalasi PHP Anda tidak mendukung FTP.";
$GLOBALS['strTypeFTPErrorUpload'] = "Tidak dapat mengunggah berkas ke Server FTP, centang hak yang sesuai dengan Direktori Tuan Rumah";
$GLOBALS['strTypeFTPErrorHost'] = "Hosti FTP yang dipilih salah";
$GLOBALS['strDeliveryFilenames'] = "Nama-nama file dari Penyampaian Global";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Klik iklan";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "Variabel Konversi Iklan";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Konten Iklan";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "Konversi Iklan";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "Konversi Iklan (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Bingkai Iklan";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Gambar iklan";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Iklan (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Lapisan iklan";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Log Iklan";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Iklan Popup";
$GLOBALS['strDeliveryFilenamesAdView'] = "Tampilan iklan";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "Perintah XML RPC";
$GLOBALS['strDeliveryFilenamesLocal'] = "Invokasi lokal";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Kontrol depan";
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "Panggilan Halaman Tunggal";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "Panggilan Laman Tunggal (JavaScript)";
$GLOBALS['strDeliveryCaching'] = "Penyetelan global untuk caching penyampaian";
$GLOBALS['strDeliveryCacheLimit'] = "Time Between Cache Updates (seconds)";
$GLOBALS['strDeliveryCacheStore'] = "Banner Delivery Cache Store Type";
$GLOBALS['strDeliveryAcls'] = "Evaluasi aturan pengiriman banner selama pengiriman";
$GLOBALS['strDeliveryAclsDirectSelection'] = "Evaluasi aturan pengiriman banner untuk iklan pilihan langsung";
$GLOBALS['strDeliveryObfuscate'] = "Aturan pengiriman yang tidak jelas ditetapkan saat mengirim iklan";
$GLOBALS['strP3PSettings'] = "Kebijaksanaan keleluasaan pribadi global P3P";
$GLOBALS['strUseP3P'] = "Gunakan kebijaksanaan P3P";
$GLOBALS['strP3PCompactPolicy'] = "Kebijakan P3P Compact";
$GLOBALS['strP3PPolicyLocation'] = "Lokasi dari kebijaksanaan P3P";

// General Settings
$GLOBALS['generalSettings'] = "Penyetelan Global Umum";
$GLOBALS['uiEnabled'] = "Interface untuk pengguna diaktifkan";
$GLOBALS['defaultLanguage'] = "Anggapan Bahasa yang digunakan<br />(Setiap pengguna dapat memilih bahasa yang diinginkan)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Pengaturan Penargetan Geografis";
$GLOBALS['strGeotargeting'] = "Pengaturan Penargetan Geografis";
$GLOBALS['strGeotargetingType'] = "Jenis modul Geotargeting";
$GLOBALS['strGeoShowUnavailable'] = "Tampilkan aturan pengiriman geotargeting meskipun data GeoIP tidak tersedia";

// Interface Settings
$GLOBALS['strInventory'] = "Inventori";
$GLOBALS['strShowCampaignInfo'] = "Tampilkan informasi tambahan tentang kampanya pada halaman <i>Peninjauan Luas Kampanye</i>";
$GLOBALS['strShowBannerInfo'] = "Tampilkan informasi tambahan tentang banner pada halaman <i>Peninjauan Luas Banner</i>";
$GLOBALS['strShowCampaignPreview'] = "Tampilkan pertunjukan pendahuluan dari seluruh banner pada halaman <i>Peninjauan Luas Banner</i>";
$GLOBALS['strShowBannerHTML'] = "Tampilkan spanduk sebenarnya bukan kode HTML biasa untuk pratinjau banner HTML";
$GLOBALS['strShowBannerPreview'] = "Tampilkan pratinjau banner di bagian atas halaman yang membahas spanduk";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "Gunakan WYSIWYG HTML Editor secara default saat membuat atau mengedit spanduk HTML";
$GLOBALS['strHideInactive'] = "Sembunyikan yang tidak aktif";
$GLOBALS['strGUIShowMatchingBanners'] = "Tampilkan spanduk yang cocok pada halaman <i>Linked banner</i>";
$GLOBALS['strGUIShowParentCampaigns'] = "Tampilkan kampanye orang tua di laman <i>Linked banner</i>";
$GLOBALS['strShowEntityId'] = "Tampilkan pengenal entitas";
$GLOBALS['strStatisticsDefaults'] = "Statistik";
$GLOBALS['strBeginOfWeek'] = "Awal Seminggu";
$GLOBALS['strPercentageDecimals'] = "Presentase dari angka desimal";
$GLOBALS['strWeightDefaults'] = "Bobot anggapan";
$GLOBALS['strDefaultBannerWeight'] = "Bobot anggapan untuk banner";
$GLOBALS['strDefaultCampaignWeight'] = "Bobot anggapan untuk kamanye";
$GLOBALS['strConfirmationUI'] = "Konfirmasi di antarmuka Pengguna";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "Default panggilan";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Aktifkan Pelacak Klik (Clicktracking) dari pihak ketiga secara anggapan";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Pengaturan Pengiriman Banner";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Pengaturan Pembatalan Banner";
$GLOBALS['strLogAdRequests'] = "Log an Ad Request every time an advertisement is requested";
$GLOBALS['strLogAdImpressions'] = "Log an Ad Impression every time an advertisement is viewed";
$GLOBALS['strLogAdClicks'] = "Log an Ad Click every time a viewer clicks on an advertisement";
$GLOBALS['strReverseLookup'] = "Reverse lookup nama host pemirsa bila tidak diberikan";
$GLOBALS['strProxyLookup'] = "Cobalah untuk menentukan alamat IP sebenarnya dari pemirsa di balik server proxy";
$GLOBALS['strPreventLogging'] = "Global Prevent Statistics Logging Settings";
$GLOBALS['strIgnoreHosts'] = "Don't store statistics for viewers using one of the following IP addresses or hostnames";
$GLOBALS['strIgnoreUserAgents'] = "<b>Jangan</b> statistik log dari klien dengan string berikut di agen pengguna mereka (satu per baris)";
$GLOBALS['strEnforceUserAgents'] = "<b>Hanya</b> statistik log dari klien dengan string berikut di agen pengguna mereka (satu per baris)";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "Pengaturan Penyimpanan Banner";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "Gunakan prioritas optimalisasi Bpse dan bukan prioritas tertimbang sisa-sisa";
$GLOBALS['strEnableContractECPM'] = "Gunakan prioritas optimalisasi Bpse dan bukan prioritas kontrak standar";
$GLOBALS['strEnableECPMfromRemnant'] = "(Jika Anda mengaktifkan fitur ini, semua kampanye tersisa Anda akan dinonaktifkan, Anda harus memperbaruinya secara manual untuk mengaktifkannya kembali)";
$GLOBALS['strEnableECPMfromECPM'] = "(Jika Anda menonaktifkan fitur ini beberapa kampanye eCPM aktif Anda akan dinonaktifkan, Anda harus memperbaruinya secara manual untuk mengaktifkannya kembali)";
$GLOBALS['strInactivatedCampaigns'] = "Daftar kampanye yang menjadi tidak aktif karena perubahan preferensi:";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "Pengaturan Pemeliharaan";
$GLOBALS['strConversionTracking'] = "Setelan Pelacakan Konversi";
$GLOBALS['strEnableConversionTracking'] = "Aktifkan Pelacakan Konversi";
$GLOBALS['strBlockInactiveBanners'] = "Jangan hitung tayangan iklan, klik atau arahkan kembali pengguna ke URL target jika pemirsa mengklik banner yang tidak aktif";
$GLOBALS['strBlockAdClicks'] = "Jangan hitung klik iklan jika pemirsa mengeklik pasangan iklan / zona yang sama dalam waktu yang ditentukan (detik)";
$GLOBALS['strMaintenanceOI'] = "Interval Operasi Pemeliharaan (menit)";
$GLOBALS['strPrioritySettings'] = "Penyetelan prioritas secara global";
$GLOBALS['strPriorityInstantUpdate'] = "Perbarui prioritas iklan segera saat perubahan dilakukan di UI";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "Secara sengaja over-deliver Contract Campaigns<br />(% over-delivery)";
$GLOBALS['strDefaultImpConvWindow'] = "Jendela Konversi Tayangan Iklan Default (detik)";
$GLOBALS['strDefaultCliConvWindow'] = "Jendela Konversi Klik Iklan Default (detik)";
$GLOBALS['strAdminEmailHeaders'] = "Tambahkan header berikut pada semua E-Mail yang dikirimkan oleh {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Kirimkan pemberitahuan bilamana jumlah impresi yang tersisa kurang dari jumlah impresi yang ditentukan disini";
$GLOBALS['strWarnLimitDays'] = "Kirimkan pemberitahuan bilamana jumlah hari yang tersisa kurang dari jumlah hari yang ditentukan disini";
$GLOBALS['strWarnAdmin'] = "Kirim peringatan kepada administrator setiap kali kampanye hampir kedaluwarsa";
$GLOBALS['strWarnClient'] = "Kirim peringatan kepada pengiklan setiap kali kampanye hampir kedaluwarsa";
$GLOBALS['strWarnAgency'] = "Send a warning to the agency every time a campaign is almost expired";

// UI Settings
$GLOBALS['strGuiSettings'] = "Penyetelan Interface Pengguna";
$GLOBALS['strGeneralSettings'] = "Penyetelan Umum";
$GLOBALS['strAppName'] = "Nama Aplikasi";
$GLOBALS['strMyHeader'] = "Lokasi dari file Header";
$GLOBALS['strMyFooter'] = "Lokasi dari file Footer";
$GLOBALS['strDefaultTrackerStatus'] = "Anggapan Status dari pelacak";
$GLOBALS['strDefaultTrackerType'] = "Jenis pelacak anggapan";
$GLOBALS['strSSLSettings'] = "Pengaturan SSL";
$GLOBALS['requireSSL'] = "Paksakan penggunaan SSL pada interface Pengguna";
$GLOBALS['sslPort'] = "Port SSL yang digunakan oleh Web Server";
$GLOBALS['strDashboardSettings'] = "Setelan Dasbor";
$GLOBALS['strMyLogo'] = "Nama dari file lambang kegaliban";
$GLOBALS['strGuiHeaderForegroundColor'] = "Warna dari header pada latar depan";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Warna dari header pada latar belakang";
$GLOBALS['strGuiActiveTabColor'] = "Warna dari tab yang aktif";
$GLOBALS['strGuiHeaderTextColor'] = "Warna dari teks dalam header";
$GLOBALS['strGuiSupportLink'] = "URL khusus untuk tautan 'Dukungan' di tajuk";
$GLOBALS['strGzipContentCompression'] = "Gunakan GZIP Content Compression";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "Platform Hash Regenerate";
$GLOBALS['strNewPlatformHash'] = "Hash Platform baru Anda adalah:";
$GLOBALS['strPlatformHashInsertingError'] = "Kesalahan memasukkan Platform Hash ke dalam database";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "Pengaturan Plugin";
$GLOBALS['strEnableNewPlugins'] = "Aktifkan plugin yang baru diinstal";
$GLOBALS['strUseMergedFunctions'] = "Gunakan file fungsi pengiriman gabungan";
