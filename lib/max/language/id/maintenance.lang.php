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

// Maintenance









// Priority
$GLOBALS['strRecalculatePriority'] = "Ulangi kalkulasi prioritas";
$GLOBALS['strHighPriorityCampaigns'] = "Kampanye prioritas tinggi";
$GLOBALS['strAdViewsAssigned'] = "Memperuntukkan AdViews";
$GLOBALS['strLowPriorityCampaigns'] = "Kampanye prioritas rendah";
$GLOBALS['strPredictedAdViews'] = "Prediksi AdViews";
$GLOBALS['strPriorityDaysRunning'] = "Pada saat ini {days} hari tercatat dalam statistik pada {$PRODUCT_NAME} sebagai data dasar untuk memprediksikan statistik harian. ";
$GLOBALS['strPriorityBasedLastWeek'] = "Prediksi ini berdasar pada data minggu ini dan data minggu terakhir. ";
$GLOBALS['strPriorityBasedLastDays'] = "Prediksi ini berdasar pada data berberapa hari terakhir. ";
$GLOBALS['strPriorityBasedYesterday'] = "Prediksi ini berdasar pada data hari kemarin. ";
$GLOBALS['strPriorityNoData'] = "Data yang tersedia tidak cukup untuk memprediksikan secara akur berapa Impression yang akan diolah oleh Adserver pada hari ini. Memperuntukkan prioritas akan didasarkan oleh statisik Real Time. ";
$GLOBALS['strPriorityEnoughAdViews'] = "Jumlah AdViews sudah cukup untuk mempenuhi target dari seluruh kampanye dengan prioritas tinggi. ";
$GLOBALS['strPriorityNotEnoughAdViews'] = "Pada saat ini belum cukup jelas apakah jumlah AdViews telah cukup untuk mempenuhi target dari seluruh kampanye dengan prioritas tinggi. ";


// Banner cache
$GLOBALS['strCheckBannerCache'] = "Periksa banner cache";
$GLOBALS['strRebuildBannerCache'] = "Bangun ulang cache banner";
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
$GLOBALS['strAge'] = "Umur";
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
$GLOBALS['strEncodingConvert'] = "Tukarkan";


// Storage
$GLOBALS['strStatisticsExplaination'] = "Anda telah aktifkan <i>Statistik Kompak</i> tetapi statistik yang lama masih dalam format Verbose (terperinci).
Apakah Anda ingin merubah statistik verbose ke dalam format kompak?
";


// Product Updates
$GLOBALS['strSearchingUpdates'] = "Mencari Update. Silakan tunggu...";
$GLOBALS['strAvailableUpdates'] = "Update yang tersedia";

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


// Stats conversion
$GLOBALS['strConverting'] = "Menukarkan";
$GLOBALS['strConvertingStats'] = "Menukarkan statistik...";
$GLOBALS['strConvertStats'] = "Menukarkan statistik";
$GLOBALS['strConvertAdViews'] = "AdViews telah ditukarkan,";
$GLOBALS['strConvertAdClicks'] = "AdClicks telah ditukarkan...";
$GLOBALS['strConvertNothing'] = "Tidak ada yang perlu ditukarkan...";
$GLOBALS['strConvertFinished'] = "Selesai...";

$GLOBALS['strConvertExplaination'] = "	Pada saat ini Anda menggunakan format kompak untuk menyimpan statistik Anda. Tetapi <br>
	tetap masih ada statistik dalam format verbose (terperinci). Selama statistik verbose <br>
	tidak diubah menjadi format kompak, statistik tersebut tidak digunakan untuk tampilan
	di halaman-halaman tersebut.  <br>
	Sebelum mengubah statistik Anda disarankan untuk meng-backup database Anda!  <br>
	Apakah Anda ingin mengubah statistik Anda kedalam format kompak yang baru? <br>";

$GLOBALS['strConvertingExplaination'] = "	Seluruh statistik verbose (terperinci) yang tersisa akan diubah kedalam format kompak. <br>
	Tergantung pada jumlah Impression yang tersimpan dalam format verbose, pengolahan ini  <br>
	butuh waktu berberapa menit. Mohon tunggu sampai perubahaan ini selesai sebelum halaman <br>
	lain dikunjungi. Dibawah ini akan tertampil seluruh perubahan yang dilakukan dalam database. <br>";

$GLOBALS['strConvertFinishedExplaination'] = "	Perubahan dari statistik verbose telah selesai dengan sukses dan data-data bisa <br>
	dipakai kembali seperti biasa. Dibawah ini akan tertampil seluruh perubahan yang <br>
	dilakukan dalam	database. <br>";

//  Maintenace

//  Deliver Limitations


//  Append codes


