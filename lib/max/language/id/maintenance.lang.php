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

// Main strings
$GLOBALS['strChooseSection']			= "Pilihan Bagian";


// Priority
$GLOBALS['strRecalculatePriority']		= "Ulangi kalkulasi prioritas";
$GLOBALS['strHighPriorityCampaigns']		= "Kampanye prioritas tinggi";
$GLOBALS['strAdViewsAssigned']			= "Memperuntukkan AdViews";
$GLOBALS['strLowPriorityCampaigns']		= "Kampanye prioritas rendah";
$GLOBALS['strPredictedAdViews']			= "Prediksi AdViews";
$GLOBALS['strPriorityDaysRunning']		= "Pada saat ini ada catatan untuk {days} hari dalam statistik bagi ".$phpAds_productname." sebagai dasar untuk memprediksikan statistik harian. ";
$GLOBALS['strPriorityBasedLastWeek']		= "Prediksi didasarkan data dari minggu ini dan dari minggu terakhir. ";
$GLOBALS['strPriorityBasedLastDays']		= "Prediksi didasarkan data dari berberapa hari terakhir. ";
$GLOBALS['strPriorityBasedYesterday']		= "Prediksi didasarkan data dari hari kemarin. ";
$GLOBALS['strPriorityNoData']			= "Data yang tersedia tidak cukup untuk memprediksikan secara akur berapa Impression yang akan diolah oleh Adserver pada hari ini. Memperuntukkan prioritas akan didasarkan oleh statisik Real Time. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Jumlah AdViews sudah cukup untuk mempenuhi target dari seluruh kampanye dengan prioritas tinggi. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Pada saat ini belum cukup jelas apakah jumlah AdViews telah cukup untuk mempenuhi target dari seluruh kampanye dengan prioritas tinggi. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Bangun ulang cache banner";
$GLOBALS['strBannerCacheExplaination']		= "
	Cache banner mengandung salinan dari kode HTML yang digunakan untuk penampilan banner tersebut. Pengunaan cache banner memungkinkan penambahan 
	kecepatan dalam pelayanan banner sehubungan kode HTML tidak perlu diolah perulang-ulang setiap kalinya banner tersebut disampaikan. 
	Sehubungan cache banner berisi Hard Coded URL ke lokasi ".$phpAds_productname." dan bannernya, cache perlu di-update setiap 
	".$phpAds_productname." dipindahkan ke lokasi lain didalam webserver. 
";


// Cache
$GLOBALS['strCache']				= "Cache penyampaian";
$GLOBALS['strAge']				= "Umur";
$GLOBALS['strRebuildDeliveryCache']		= "Bangun ulang cache penyampaian";
$GLOBALS['strDeliveryCacheExplaination']	= "
	Cache penyampaian digunakan untuk mempercepat penyampaian banner. Cache ini berisi salinan dari semua banner 
	yang di-link ke zona yang juga menyimpan berberapa query database untuk disampaikan kepada pengguna. Cache  
	tersebut biasanya dibangun ulang setiap jam tetapi pembangunan ulang cache tersebut bisa dilakukan secara manual.
";
$GLOBALS['strDeliveryCacheSharedMem']		= "
	Memori yang dibagi pada saat ini digunakan untuk menyimpan cache penyampaian.
";
$GLOBALS['strDeliveryCacheDatabase']		= "
	Database pada saat ini digunakan untuk menyimpan cache penyampaian.
";
$GLOBALS['strDeliveryCacheFiles']		= "
	Cache penyampaian pada saat ini disimpan pada berberapa file yang berbeda di server Anda.
";


// Storage
$GLOBALS['strStorage']				= "Tempat Penampungan";
$GLOBALS['strMoveToDirectory']			= "Pindahkan gambar yang ditampung dalam database kedalam direktori";
$GLOBALS['strStorageExplaination']		= "
	Gambar-gambar yang digunakan oleh banner lokal tertampung pada database atau dalam direktori. Bila Anda menampung gambar 
	dalam sebuah direktori, beban pada database berkurang yang mengakibatkan kecepatan yang lebih tinggi. 
";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	Anda telah aktifkan <i>Statistik Kompak</i> tetapi statistik yang lama masih dalam format Verbose (terperinci). 
	Apakah Anda ingin merubah statistik verbose ke dalam format kompak?
";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "Mencari Update. Silakan tunggu...";
$GLOBALS['strAvailableUpdates']			= "Update yang tersedia";
$GLOBALS['strDownloadZip']			= "Download (.zip)";
$GLOBALS['strDownloadGZip']			= "Download (.tar.gz)";

$GLOBALS['strUpdateAlert']			= "Versi baru dari ".$phpAds_productname." tersedia.                 \\n\\nApakah Anda ingin informasi yang lebih lanjut \\ntentang Update yang tersedia?";
$GLOBALS['strUpdateAlertSecurity']		= "Versi baru dari ".$phpAds_productname." tersedia.                 \\n\\nKami sarankan untuk meng-update \\nsecepat mungkin \\nsehubungan versi baru mengandung berberapa peningkatan keamanan.";

$GLOBALS['strUpdateServerDown']			= "
	Berdasarkan alasan yang tidak jelas pada saat ini pengecheckan tentang<br />
	adanya Update gagal dilakukan. Silakan coba kembali pada lain waktu.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	Versi ".$phpAds_productname." yang digunakan sudah paling aktual. Pada saat ini belum ada Update yang baru. 
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>Versi baru dari ".$phpAds_productname." telah tersedia.</b><br /> Disarankan untuk meng-update sehubungan 
	update tersebut memperbaiki berberapa masalah dan mengandung fasilitas baru. Untuk informasi lebih lanjut 
	bacalah	dokumentasi yang tersedia dalam file dibawah ini.
";

$GLOBALS['strSecurityUpdate']			= "
	<b>Disarankan untuk meng-update secepat mungkin sehubungan update ini mengandung berberapa perbaikan 
	dalam segi keamanan.</b> Ada kemungkinan bahwa versi dari ".$phpAds_productname." yang digunakan 
	oleh Anda mudah diserang dan sudah tidak aman lagi. Untuk informasi lebih lanjut bacalah dokumentasi 
	tentang caranya meng-update yang tersedia dalam file dibawah ini.
";

$GLOBALS['strNotAbleToCheck']			= "
	<b>Sehubungan ekstensi XML tidak tersedia pada server Anda, maka ".$phpAds_productname." tidak sanggup 
	untuk mencari ketersediaan versi baru.</b>
";

$GLOBALS['strForUpdatesLookOnWebsite']	= "
	Bila Anda ingin tahu apakah telah tersedia versi yang lebih baru silakan kunjungi website kami. 
";

$GLOBALS['strClickToVisitWebsite']		= "Klik disini untuk kunjungi website kami";
$GLOBALS['strCurrentlyUsing'] 			= "Pada saat ini Anda mengunakan";
$GLOBALS['strRunningOn']			= "dijalankan pada";
$GLOBALS['strAndPlain']				= "dan";

// Stats conversion
$GLOBALS['strConverting']			= "Menukarkan";
$GLOBALS['strConvertingStats']			= "Menukarkan statistik...";
$GLOBALS['strConvertStats']			= "Menukarkan statistik";
$GLOBALS['strConvertAdViews']			= "AdViews telah ditukarkan,";
$GLOBALS['strConvertAdClicks']			= "AdClicks telah ditukarkan...";
$GLOBALS['strConvertNothing']			= "Tidak ada yang perlu ditukarkan...";
$GLOBALS['strConvertFinished']			= "Selesai...";

$GLOBALS['strConvertExplaination']		= "
	Pada saat ini Anda menggunakan format kompak untuk menyimpan statistik Anda. Tetapi <br />
	tetap masih ada statistik dalam format verbose (terperinci). Selama statistik verbose <br />
	tidak diubah menjadi format kompak, statistik tersebut tidak digunakan untuk tampilan 
	di halaman-halaman tersebut.  <br />
	Sebelum mengubah statistik Anda disarankan untuk meng-backup database Anda!  <br />
	Apakah Anda ingin mengubah statistik Anda kedalam format kompak yang baru? <br />
";

$GLOBALS['strConvertingExplaination']		= "
	Seluruh statistik verbose (terperinci) yang tersisa akan diubah kedalam format kompak. <br />
	Tergantung pada jumlah Impression yang tersimpan dalam format verbose, pengolahan ini  <br />
	butuh waktu berberapa menit. Mohon tunggu sampai perubahaan ini selesai sebelum halaman <br />
	lain dikunjungi. Dibawah ini akan tertampil seluruh perubahan yang dilakukan dalam database. <br />
";

$GLOBALS['strConvertFinishedExplaination']  	= "
	Perubahan dari statistik verbose telah selesai dengan sukses dan data-data bisa <br />
	dipakai kembali seperti biasa. Dibawah ini akan tertampil seluruh perubahan yang <br />
	dilakukan dalam	database. <br />
";


?>
