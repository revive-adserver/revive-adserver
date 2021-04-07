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
$GLOBALS['strChooseSection'] = "Pilihan Bagian";
$GLOBALS['strAppendCodes'] = "Tambahkan kode";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>Pemeliharaan terjadwal belum berjalan dalam satu jam terakhir. Ini mungkin berarti Anda belum mengaturnya dengan benar. </b>";





$GLOBALS['strScheduledMantenaceRunning'] = "<b>Pemeliharaan terjadwal berjalan dengan benar.</b>";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>Pemeliharaan otomatis berjalan dengan benar.</b>";

$GLOBALS['strAutoMantenaceEnabled'] = "Namun, perawatan otomatis masih dimungkinkan. Untuk kinerja terbaik, sebaiknya <a href='account-settings-maintenance.php'>nonaktifkan pemeliharaan otomatis</a>.";

// Priority
$GLOBALS['strRecalculatePriority'] = "Ulangi kalkulasi prioritas";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "Periksa banner cache";
$GLOBALS['strBannerCacheErrorsFound'] = "Cek tembolok spanduk database telah menemukan beberapa kesalahan. Spanduk ini tidak akan bekerja sampai Anda memperbaikinya secara manual.";
$GLOBALS['strBannerCacheOK'] = "Tidak ada kesalahan yang terdeteksi. Cache banner database Anda up to date";
$GLOBALS['strBannerCacheDifferencesFound'] = "Cek cache banner database telah menemukan bahwa cache Anda tidak up to date dan memerlukan pembangunan kembali. Klik di sini untuk memperbarui cache Anda secara otomatis.";
$GLOBALS['strBannerCacheRebuildButton'] = "Bangun ulang";
$GLOBALS['strRebuildDeliveryCache'] = "Bangun ulang database banner cache";

// Cache
$GLOBALS['strCache'] = "Cache penyampaian";
$GLOBALS['strDeliveryCacheSharedMem'] = "Database pada saat ini digunakan untuk menyimpan cache penyampaian.
";
$GLOBALS['strDeliveryCacheDatabase'] = "Database pada saat ini digunakan untuk menyimpan cache penyampaian.
";
$GLOBALS['strDeliveryCacheFiles'] = "Cache penyampaian pada saat ini disimpan pada berberapa file yang berbeda di server Anda.
";

// Storage
$GLOBALS['strStorage'] = "Tempat Penampungan";
$GLOBALS['strMoveToDirectory'] = "Pindahkan gambar yang ditampung dalam database kedalam direktori";
$GLOBALS['strStorageExplaination'] = "Gambar-gambar yang digunakan oleh banner lokal tertampung pada database atau dalam direktori. Bila Anda menampung gambar
dalam sebuah direktori, beban pada database berkurang yang mengakibatkan kecepatan yang lebih tinggi.
";

// Encoding
$GLOBALS['strEncoding'] = "Pengkodean";
$GLOBALS['strEncodingConvertFrom'] = "Konversikan dari pengkodean ini:";
$GLOBALS['strEncodingConvertTest'] = "Uji konversi";
$GLOBALS['strConvertThese'] = "Data berikut akan berubah jika Anda melanjutkan";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Mencari Update. Silakan tunggu...";
$GLOBALS['strAvailableUpdates'] = "Update yang tersedia";
$GLOBALS['strDownloadZip'] = "Download (.zip)";
$GLOBALS['strDownloadGZip'] = "Download (.tar.gz)";


$GLOBALS['strUpdateServerDown'] = "Berdasarkan alasan yang tidak jelas pada saat ini pengecheckan tentang<br>
adanya Update gagal dilakukan. Silakan coba kembali pada lain waktu.
";



$GLOBALS['strCheckForUpdatesDisabled'] = "    <b>Periksa pembaruan dinonaktifkan. Mohon aktifkan  via
    <a href='account-settings-update.php'>perbarui setelan</a> layar.</b>";




$GLOBALS['strForUpdatesLookOnWebsite'] = "	Bila Anda ingin tahu apakah telah tersedia versi yang lebih baru silakan kunjungi website kami.
";

$GLOBALS['strClickToVisitWebsite'] = "Klik disini untuk kunjungi website kami";
$GLOBALS['strCurrentlyUsing'] = "Anda gunakan";
$GLOBALS['strRunningOn'] = "yang bekerjasama dengan";
$GLOBALS['strAndPlain'] = "dan";

//  Deliver Limitations
$GLOBALS['strDeliveryLimitations'] = "Aturan Pengiriman";
$GLOBALS['strAllBannerChannelCompiled'] = "Semua aturan banner/pengiriman menetapkan nilai aturan pengiriman terkompilasi telah dikompilasi ulang";
$GLOBALS['strBannerChannelResult'] = "Berikut adalah hasil dari aturan banner/delivery yang mengatur validasi aturan pengiriman";
$GLOBALS['strChannelCompiledLimitationsValid'] = "Semua aturan pengiriman yang dikompilasi untuk aturan pengiriman berlaku";
$GLOBALS['strBannerCompiledLimitationsValid'] = "Semua aturan pengiriman yang disatukan untuk banner berlaku";
$GLOBALS['strErrorsFound'] = "Kesalahan ditemukan";
$GLOBALS['strRepairCompiledLimitations'] = "Beberapa ketidakkonsistenan ditemukan di atas, Anda dapat memperbaiki ini dengan menggunakan tombol di bawah ini, ini akan mengkompilasi ulang batasan yang dikompilasi untuk setiap aturan banner/pengiriman yang diatur dalam sistem<br/>";
$GLOBALS['strRecompile'] = "Kompilasi ulang";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "Dalam keadaan tertentu, mesin pengiriman tidak dapat menyetujui peraturan pengiriman yang tersimpan untuk spanduk dan rangkaian aturan pengiriman, gunakan tautan berikut untuk memvalidasi aturan pengiriman di basis data";
$GLOBALS['strCheckACLs'] = "Periksa aturan pengiriman";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "Dalam keadaan tertentu, mesin pengiriman tidak dapat menyetujui kode tambahan yang tersimpan untuk pelacak, gunakan tautan folowing untuk memvalidasi kode tambahan di database";
$GLOBALS['strCheckAppendCodes'] = "Periksa kode Append";
$GLOBALS['strAppendCodesRecompiled'] = "Semua nilai kode append yang dikompilasi telah dikompilasi ulang";
$GLOBALS['strAppendCodesResult'] = "Berikut adalah hasil dari validasi kode append yang dikompilasi";
$GLOBALS['strAppendCodesValid'] = "Semua appendcode yang dilacak tracker valid";
$GLOBALS['strRepairAppenedCodes'] = "Beberapa ketidakkonsistenan ditemukan di atas, Anda dapat memperbaiki ini dengan menggunakan tombol di bawah ini, ini akan mengkompilasi ulang kode tambahan untuk setiap pelacak di sistem";

$GLOBALS['strPlugins'] = "Plugin";

$GLOBALS['strMenus'] = "Menu";
$GLOBALS['strMenusPrecis'] = "Membangun kembali cache menu";
$GLOBALS['strMenusCachedOk'] = "Menu cache telah dibangun kembali";
