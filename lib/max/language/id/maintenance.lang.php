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

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "	Pemeliharaan otomatis diaktifkan, namun belum dipicu. Pemeliharaan otomatis hanya dipicu bila {$PRODUCT_NAME} mengirimkan spanduk.
    Untuk kinerja terbaik, Anda harus menyiapkan <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>pemeliharaan terjadwal</a>.";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "	Pemeliharaan otomatis saat ini dinonaktifkan, jadi ketika {$PRODUCT_NAME} mengirimkan spanduk, perawatan otomatis tidak akan dipicu.
       Untuk kinerja terbaik, Anda harus menyiapkan <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>pemeliharaan terjadwal </a>.
    Namun, jika Anda tidak akan menyiapkan <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>pemeliharaan terjadwal </a>,
    maka <i>harus</i> <a href='account-settings-maintenance.php'>mengaktifkan pemeliharaan otomatis</a>untuk memastikan bahwa {$PRODUCT_NAME} bekerja dengan benar.";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "	Pemeliharaan otomatis diaktifkan dan akan dipicu, jika diperlukan, bila {$PRODUCT_NAME} mengirimkan spanduk. Namun, untuk kinerja terbaik, Anda harus menyiapkan <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>pemeliharaan terjadwal</a>.";

$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "	Namun, perawatan otomatis baru saja dinonaktifkan. Untuk memastikan bahwa {$PRODUCT_NAME} bekerja dengan benar, Anda harus menyiapkan akun <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>terjadwal pemeliharaan</a> atau
	 <a href ='-settings-maintenance.php'>mengaktifkan kembali pemeliharaan otomatis</a>.<br><br> 
	Untuk kinerja terbaik, Anda harus menyiapkan <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>pemeliharaan terjadwal</a>.";

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
$GLOBALS['strBannerCacheExplaination'] = "Cache ini perlu dibangun ulang bilamana:<br />
<ul>
<li>Versi dari OpenX di-upgrade</li>
<li>Instalasi OpenX dipindahkan ke server lain</li>
</ul>
";

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

// Security

// Encoding
$GLOBALS['strEncoding'] = "Pengkodean";
$GLOBALS['strEncodingExplaination'] = "{$PRODUCT_NAME} sekarang menyimpan semua data dalam database dalam format UTF-8.<br/>
     Bila memungkinkan, data Anda akan otomatis dikonversi ke pengkodean ini.<br/>
     Jika setelah mengupgrade karakter Anda yang korup, dan Anda tahu pengkodean yang digunakan, Anda dapat menggunakan alat ini untuk mengubah data dari format tersebut menjadi UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Konversikan dari pengkodean ini:";
$GLOBALS['strEncodingConvertTest'] = "Uji konversi";
$GLOBALS['strConvertThese'] = "Data berikut akan berubah jika Anda melanjutkan";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Mencari Update. Silakan tunggu...";
$GLOBALS['strAvailableUpdates'] = "Update yang tersedia";
$GLOBALS['strDownloadZip'] = "Download (.zip)";
$GLOBALS['strDownloadGZip'] = "Download (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "Tersedia versi baru dari .

Apakah Anda inginkan informasi yang lebih lanjut
tentang Update yang tersedia?";
$GLOBALS['strUpdateAlertSecurity'] = "Tersedia versi baru dari .

Kami sarankan untuk meng-update
secepat mungkin
sehubungan versi baru ini mengandung berberapa peningkatan dalam segi keamanan.";

$GLOBALS['strUpdateServerDown'] = "Berdasarkan alasan yang tidak jelas pada saat ini pengecheckan tentang<br>
adanya Update gagal dilakukan. Silakan coba kembali pada lain waktu.
";

$GLOBALS['strNoNewVersionAvailable'] = "Anda telah menggunakan versi {$PRODUCT_NAME} yang terbaru. Pada saat ini belum ada Update untuk versi ini.
";

$GLOBALS['strServerCommunicationError'] = "    <b>Komunikasi dengan server pembaruan habis waktunya, jadi {$PRODUCT_NAME} tidak
     dapat memeriksa apakah versi yang lebih baru tersedia pada tahap ini. Silakan coba lagi nanti.</b>";

$GLOBALS['strCheckForUpdatesDisabled'] = "    <b>Periksa pembaruan dinonaktifkan. Mohon aktifkan  via
    <a href='account-settings-update.php'>perbarui setelan</a> layar.</b>";

$GLOBALS['strNewVersionAvailable'] = "<b>Ada versi baru untuk {$PRODUCT_NAME}.</b><br> Disarankan untuk meng-update sehubungan
update tersebut memperbaiki berberapa masalah dan membawa fasilitas baru. Untuk informasi lebih lanjut
bacalah	dokumentasi yang tersedia dalam file dibawah ini.
";

$GLOBALS['strSecurityUpdate'] = "	<b>Disarankan untuk meng-update secepat mungkin sehubungan dalam update ini ada berberapa perbaikan
	dalam segi keamanan.</b> Ada kemungkinan bahwa versi dari {$PRODUCT_NAME} yang digunakan
oleh Anda mudah diserang dan sudah tidak aman lagi. Untuk informasi lebih lanjut bacalah dokumentasi
	tentang caranya meng-update yang tersedia dalam file dibawah ini.
";

$GLOBALS['strNotAbleToCheck'] = "<b>Sehubungan ekstensi XML tidak tersedia pada server Anda, maka {$PRODUCT_NAME} tidak sanggup
untuk mencari ketersediaan versi baru.</b>
";

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
$GLOBALS['strPluginsPrecis'] = "Diagnosa dan perbaiki masalah dengan plugin {$PRODUCT_NAME}";

$GLOBALS['strMenus'] = "Menu";
$GLOBALS['strMenusPrecis'] = "Membangun kembali cache menu";
$GLOBALS['strMenusCachedOk'] = "Menu cache telah dibangun kembali";

// Users
