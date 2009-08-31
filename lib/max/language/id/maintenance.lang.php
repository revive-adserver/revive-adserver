<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

// Indonesian
// Main strings
$GLOBALS['strChooseSection']				= "Pilihan Bagian";


// Priority
$GLOBALS['strRecalculatePriority']			= "Ulangi kalkulasi prioritas";
$GLOBALS['strHighPriorityCampaigns']		= "Kampanye prioritas tinggi";
$GLOBALS['strAdViewsAssigned']				= "Memperuntukkan AdViews";
$GLOBALS['strLowPriorityCampaigns']			= "Kampanye prioritas rendah";
$GLOBALS['strPredictedAdViews']				= "Prediksi AdViews";
$GLOBALS['strPriorityDaysRunning']			= "Pada saat ini {days} hari tercatat dalam statistik pada ".MAX_PRODUCT_NAME." sebagai data dasar untuk memprediksikan statistik harian. ";
$GLOBALS['strPriorityBasedLastWeek']		= "Prediksi ini berdasar pada data minggu ini dan data minggu terakhir. ";
$GLOBALS['strPriorityBasedLastDays']		= "Prediksi ini berdasar pada data berberapa hari terakhir. ";
$GLOBALS['strPriorityBasedYesterday']		= "Prediksi ini berdasar pada data hari kemarin. ";
$GLOBALS['strPriorityNoData']				= "Data yang tersedia tidak cukup untuk memprediksikan secara akur berapa Impression yang akan diolah oleh Adserver pada hari ini. Memperuntukkan prioritas akan didasarkan oleh statisik Real Time. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Jumlah AdViews sudah cukup untuk mempenuhi target dari seluruh kampanye dengan prioritas tinggi. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Pada saat ini belum cukup jelas apakah jumlah AdViews telah cukup untuk mempenuhi target dari seluruh kampanye dengan prioritas tinggi. ";


// Banner cache
$GLOBALS['strCheckBannerCache']				= "Periksa banner cache";
$GLOBALS['strRebuildBannerCache']			= "Bangun ulang cache banner";
$GLOBALS['strBannerCacheErrorsFound'] 		= "The database banner cache check has found some errors. These banners will not work until you manually fix them.";
$GLOBALS['strBannerCacheOK'] 				= "There were no errors detected. Your database banner cache is up to date";
$GLOBALS['strBannerCacheDifferencesFound'] 	= "The database banner cache check has found that your cache is not up to date and requires rebuilding. Click here to automatically  update your cache.";
$GLOBALS['strBannerCacheFixed'] 			= "The database banner cache rebuild was successfully completed. Your database cache is now up to date.";
$GLOBALS['strBannerCacheRebuildButton'] 	= "Bangun ulang";
$GLOBALS['strRebuildDeliveryCache']			= "Bangun ulang database banner cache";
$GLOBALS['strBannerCacheExplaination']		= "\nCache ini perlu dibangun ulang bilamana:<br />\n<ul>\n<li>Versi dari OpenX di-upgrade</li>\n<li>Instalasi OpenX dipindahkan ke server lain</li>\n</ul>\n\n";

// Cache
$GLOBALS['strCache']						= "Cache penyampaian";
$GLOBALS['strAge']							= "Umur";
$GLOBALS['strDeliveryCacheSharedMem']		= "\nDatabase pada saat ini digunakan untuk menyimpan cache penyampaian.\n\n";
$GLOBALS['strDeliveryCacheDatabase']		= "\nDatabase pada saat ini digunakan untuk menyimpan cache penyampaian.\n\n";
$GLOBALS['strDeliveryCacheFiles']			= "\nCache penyampaian pada saat ini disimpan pada berberapa file yang berbeda di server Anda.\n\n";


// Storage
$GLOBALS['strStorage']						= "Tempat Penampungan";
$GLOBALS['strMoveToDirectory']				= "Pindahkan gambar yang ditampung dalam database kedalam direktori";
$GLOBALS['strStorageExplaination']			= "\nGambar-gambar yang digunakan oleh banner lokal tertampung pada database atau dalam direktori. Bila Anda menampung gambar\ndalam sebuah direktori, beban pada database berkurang yang mengakibatkan kecepatan yang lebih tinggi.\n\n";


// Storage
$GLOBALS['strStatisticsExplaination']		= "\nAnda telah aktifkan <i>Statistik Kompak</i> tetapi statistik yang lama masih dalam format Verbose (terperinci).\nApakah Anda ingin merubah statistik verbose ke dalam format kompak?\n\n";


// Product Updates
$GLOBALS['strSearchingUpdates']				= "Mencari Update. Silakan tunggu...";
$GLOBALS['strAvailableUpdates']				= "Update yang tersedia";
$GLOBALS['strDownloadZip']					= "Download (.zip)";
$GLOBALS['strDownloadGZip']					= "Download (.tar.gz)";

$GLOBALS['strUpdateAlert']					= "Tersedia versi baru dari .                 \n\nApakah Anda inginkan informasi yang lebih lanjut \ntentang Update yang tersedia?";
$GLOBALS['strUpdateAlertSecurity']			= "Tersedia versi baru dari .                 \n\nKami sarankan untuk meng-update \nsecepat mungkin \nsehubungan versi baru ini mengandung berberapa peningkatan dalam segi keamanan.";

$GLOBALS['strUpdateServerDown']				= "\nBerdasarkan alasan yang tidak jelas pada saat ini pengecheckan tentang<br>\nadanya Update gagal dilakukan. Silakan coba kembali pada lain waktu.\n\n";

$GLOBALS['strNoNewVersionAvailable']		= "\nAnda telah menggunakan versi ". MAX_PRODUCT_NAME ." yang terbaru. Pada saat ini belum ada Update untuk versi ini.\n\n";

$GLOBALS['strNewVersionAvailable']			= "\n<b>Ada versi baru untuk ". MAX_PRODUCT_NAME .".</b><br> Disarankan untuk meng-update sehubungan\nupdate tersebut memperbaiki berberapa masalah dan membawa fasilitas baru. Untuk informasi lebih lanjut\nbacalah	dokumentasi yang tersedia dalam file dibawah ini.\n\n";

$GLOBALS['strSecurityUpdate']				= "\n	<b>Disarankan untuk meng-update secepat mungkin sehubungan dalam update ini ada berberapa perbaikan\n	dalam segi keamanan.</b> Ada kemungkinan bahwa versi dari ". MAX_PRODUCT_NAME ." yang digunakan\noleh Anda mudah diserang dan sudah tidak aman lagi. Untuk informasi lebih lanjut bacalah dokumentasi\n	tentang caranya meng-update yang tersedia dalam file dibawah ini.\n\n";

$GLOBALS['strNotAbleToCheck']				= "\n<b>Sehubungan ekstensi XML tidak tersedia pada server Anda, maka ". MAX_PRODUCT_NAME ." tidak sanggup\nuntuk mencari ketersediaan versi baru.</b>\n\n";

$GLOBALS['strForUpdatesLookOnWebsite']		= "\n	Bila Anda ingin tahu apakah telah tersedia versi yang lebih baru silakan kunjungi website kami.\n\n";

$GLOBALS['strClickToVisitWebsite']			= "Klik disini untuk kunjungi website kami";
$GLOBALS['strCurrentlyUsing'] 				= "Anda gunakan";
$GLOBALS['strRunningOn']					= "yang bekerjasama dengan";
$GLOBALS['strAndPlain']						= "dan";

// Stats conversion
$GLOBALS['strConverting']					= "Menukarkan";
$GLOBALS['strConvertingStats']				= "Menukarkan statistik...";
$GLOBALS['strConvertStats']					= "Menukarkan statistik";
$GLOBALS['strConvertAdViews']				= "AdViews telah ditukarkan,";
$GLOBALS['strConvertAdClicks']				= "AdClicks telah ditukarkan...";
$GLOBALS['strConvertAdConversions']			= "AdConversions converted...";
$GLOBALS['strConvertNothing']				= "Tidak ada yang perlu ditukarkan...";
$GLOBALS['strConvertFinished']				= "Selesai...";

$GLOBALS['strConvertExplaination']			= "\n	Pada saat ini Anda menggunakan format kompak untuk menyimpan statistik Anda. Tetapi <br>\n	tetap masih ada statistik dalam format verbose (terperinci). Selama statistik verbose <br>\n	tidak diubah menjadi format kompak, statistik tersebut tidak digunakan untuk tampilan\n	di halaman-halaman tersebut.  <br>\n	Sebelum mengubah statistik Anda disarankan untuk meng-backup database Anda!  <br>\n	Apakah Anda ingin mengubah statistik Anda kedalam format kompak yang baru? <br>\n";

$GLOBALS['strConvertingExplaination']		= "\n	Seluruh statistik verbose (terperinci) yang tersisa akan diubah kedalam format kompak. <br>\n	Tergantung pada jumlah Impression yang tersimpan dalam format verbose, pengolahan ini  <br>\n	butuh waktu berberapa menit. Mohon tunggu sampai perubahaan ini selesai sebelum halaman <br>\n	lain dikunjungi. Dibawah ini akan tertampil seluruh perubahan yang dilakukan dalam database. <br>\n";

$GLOBALS['strConvertFinishedExplaination']  	= "\n	Perubahan dari statistik verbose telah selesai dengan sukses dan data-data bisa <br>\n	dipakai kembali seperti biasa. Dibawah ini akan tertampil seluruh perubahan yang <br>\n	dilakukan dalam	database. <br>\n";



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strEncodingConvert'] = "Tukarkan";
?>