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

// Set text direction and characterset

$GLOBALS['phpAds_DecimalPoint'] = ",";
$GLOBALS['phpAds_ThousandsSeperator'] = ".";

// Date & time configuration
$GLOBALS['day_format'] = "%d-%m";

// Formats used by PEAR Spreadsheet_Excel_Writer packate

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "Rumah";
$GLOBALS['strHelp'] = "Bantuan";
$GLOBALS['strStartOver'] = "Mulai dari semula";
$GLOBALS['strShortcuts'] = "Jalan Pintas";
$GLOBALS['strActions'] = "Aksi";
$GLOBALS['strAndXMore'] = "dan %s lebih";
$GLOBALS['strAdminstration'] = "Inventori";
$GLOBALS['strMaintenance'] = "Pemeliharaan";
$GLOBALS['strProbability'] = "Kemungkinan";
$GLOBALS['strInvocationcode'] = "Invokasi Kode";
$GLOBALS['strBasicInformation'] = "Informasi Dasar";
$GLOBALS['strAppendTrackerCode'] = "Tempelkan kode pelacak";
$GLOBALS['strOverview'] = "Pandangan Menyeluruh";
$GLOBALS['strSearch'] = "<u>C</u>ari";
$GLOBALS['strDetails'] = "Perincian";
$GLOBALS['strUpdateSettings'] = "Perbarui Setelan";
$GLOBALS['strCheckForUpdates'] = "Periksa adanya Update";
$GLOBALS['strWhenCheckingForUpdates'] = "Saat memeriksa pembaruan";
$GLOBALS['strCompact'] = "Kompak";
$GLOBALS['strUser'] = "Pengguna";
$GLOBALS['strDuplicate'] = "Mendobelkan";
$GLOBALS['strCopyOf'] = "Salinan dari";
$GLOBALS['strMoveTo'] = "Pindahkan ke";
$GLOBALS['strDelete'] = "Hapus";
$GLOBALS['strActivate'] = "Aktifkan";
$GLOBALS['strConvert'] = "Tukarkan";
$GLOBALS['strRefresh'] = "Menyegarkan";
$GLOBALS['strSaveChanges'] = "Simpan Perubahan";
$GLOBALS['strUp'] = "Keatas";
$GLOBALS['strDown'] = "Kebawah";
$GLOBALS['strSave'] = "Simpan";
$GLOBALS['strCancel'] = "Batal";
$GLOBALS['strBack'] = "Kembali";
$GLOBALS['strPrevious'] = "Sebelumnya";
$GLOBALS['strNext'] = "Berikutnya";
$GLOBALS['strYes'] = "Ya";
$GLOBALS['strNo'] = "Tidak";
$GLOBALS['strNone'] = "Belum ditentukan";
$GLOBALS['strCustom'] = "Langgam";
$GLOBALS['strDefault'] = "Kegagalan";
$GLOBALS['strUnknown'] = "Tidak diketahui";
$GLOBALS['strUnlimited'] = "Tidak terbatas";
$GLOBALS['strUntitled'] = "Tanpa nama";
$GLOBALS['strAll'] = "semua";
$GLOBALS['strAverage'] = "Rata-rata";
$GLOBALS['strOverall'] = "Seluruhnya";
$GLOBALS['strTotal'] = "Jumlah";
$GLOBALS['strFrom'] = "Dari";
$GLOBALS['strTo'] = "ke";
$GLOBALS['strAdd'] = "Menambahkan";
$GLOBALS['strLinkedTo'] = "dihubungkan pada";
$GLOBALS['strDaysLeft'] = "Hari yang tersisa";
$GLOBALS['strCheckAllNone'] = "Pilih semua / tdk satupun";
$GLOBALS['strKiloByte'] = "KB";
$GLOBALS['strExpandAll'] = "<u>M</u>eluaskan semua";
$GLOBALS['strCollapseAll'] = "<u>M</u>elipatkan semua";
$GLOBALS['strShowAll'] = "Tampilkan semua";
$GLOBALS['strNoAdminInterface'] = "Pelayanan tidak dapat dicapai...";
$GLOBALS['strFieldStartDateBeforeEnd'] = "'Dari' tanggal pasti lebih awal dari tanggal 'To'";
$GLOBALS['strFieldContainsErrors'] = "Kotak berikut berisi kesalahan:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Sebelum melanjut Anda perlu";
$GLOBALS['strFieldFixBeforeContinue2'] = "perbaiki kesalahan tersebut.";
$GLOBALS['strMiscellaneous'] = "Lain-Lain";
$GLOBALS['strCollectedAllStats'] = "Kumpulan seluruh statistik";
$GLOBALS['strCollectedToday'] = "Statistik hari ini saja";
$GLOBALS['strCollectedYesterday'] = "Kemarin";
$GLOBALS['strCollectedThisWeek'] = "Minggu ini";
$GLOBALS['strCollectedLastWeek'] = "Minggu terakhir";
$GLOBALS['strCollectedThisMonth'] = "Bulan ini";
$GLOBALS['strCollectedLastMonth'] = "Bulan terakhir";
$GLOBALS['strCollectedLast7Days'] = "7 hari terakhir";
$GLOBALS['strCollectedSpecificDates'] = "Tanggal-tanggal tertentu";
$GLOBALS['strValue'] = "Nilai";
$GLOBALS['strWarning'] = "Peringatan";
$GLOBALS['strNotice'] = "Untuk diperhatikan";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "Dasbor tidak dapat ditampilkan";
$GLOBALS['strNoCheckForUpdates'] = "Dashboard tidak dapat ditampilkan kecuali <br/> cek untuk pengaturan update diaktifkan.";
$GLOBALS['strEnableCheckForUpdates'] = "Aktifkan setelan <a href='akun-pengaturan-pembaruan.php' target='_top'>periksa pembaruan</a> di target<br/><a href='akun-settings-update.php' ='_top'>pengaturan pembaruan</a> halaman.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "kode";
$GLOBALS['strDashboardSystemMessage'] = "Pesan sistem";
$GLOBALS['strDashboardErrorHelp'] = "Jika kesalahan ini terulang, jelaskan masalah Anda secara mendetail dan kirimkan di <a href='http://forum.revive-adserver.com/'> forum.revive-adserver.com/ </a>.";

// Priority
$GLOBALS['strPriority'] = "Prioritas";
$GLOBALS['strPriorityLevel'] = "Tingkat Prioritas";
$GLOBALS['strOverrideAds'] = "Tangguhkan Iklan Promosi";
$GLOBALS['strHighAds'] = "Iklan dengan prioritas tinggi";
$GLOBALS['strECPMAds'] = "eCPM Iklan Kampanye";
$GLOBALS['strLowAds'] = "Iklan dengan prioritas rendah";
$GLOBALS['strLimitations'] = "Aturan pengiriman";
$GLOBALS['strNoLimitations'] = "Tidak ada aturan pengiriman";
$GLOBALS['strCapping'] = "Pemangkasan";

// Properties
$GLOBALS['strName'] = "Nama";
$GLOBALS['strSize'] = "Ukuran";
$GLOBALS['strWidth'] = "Lebar";
$GLOBALS['strHeight'] = "Tinggi";
$GLOBALS['strTarget'] = "Target";
$GLOBALS['strLanguage'] = "Bahasa";
$GLOBALS['strDescription'] = "Deskripsi";
$GLOBALS['strVariables'] = "Variabel";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "Komentar";

// User access
$GLOBALS['strWorkingAs'] = "Bekerja sebagai";
$GLOBALS['strWorkingAs_Key'] = "<u>W</u>bekerja sebagai";
$GLOBALS['strWorkingAs'] = "Bekerja sebagai";
$GLOBALS['strSwitchTo'] = "Beralih ke";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "Gunakan kotak telusur pengalih untuk menemukan lebih banyak akun";
$GLOBALS['strWorkingFor'] = "%s untuk...";
$GLOBALS['strNoAccountWithXInNameFound'] = "Tidak ada akun dengan nama \" %s \" yang ditemukan";
$GLOBALS['strRecentlyUsed'] = "Baru - baru ini digunakan";
$GLOBALS['strLinkUser'] = "Tambahkan pengguna";
$GLOBALS['strLinkUser_Key'] = "Tambahkan <u>u</u> ser";
$GLOBALS['strUsernameToLink'] = "Username pengguna untuk ditambahkan";
$GLOBALS['strNewUserWillBeCreated'] = "Pengguna baru akan dibuat";
$GLOBALS['strToLinkProvideEmail'] = "Untuk menambahkan pengguna, berikan email pengguna";
$GLOBALS['strToLinkProvideUsername'] = "Untuk menambahkan pengguna, berikan username";
$GLOBALS['strUserAccountUpdated'] = "Akun pengguna diperbarui";
$GLOBALS['strUserWasDeleted'] = "Pengguna telah dihapus";
$GLOBALS['strUserNotLinkedWithAccount'] = "Pengguna tersebut tidak terkait dengan akun";
$GLOBALS['strLinkUserHelp'] = "Untuk menambahkan <b> pengguna yang ada </b>, ketik%1\$s dan klik%2\$s <br/> Untuk menambahkan<b>pengguna baru </b>, ketik%1\$s dan klik%2\$s";
$GLOBALS['strLinkUserHelpUser'] = "Nama Pengguna";
$GLOBALS['strLinkUserHelpEmail'] = "alamat email";
$GLOBALS['strLastLoggedIn'] = "Terakhir masuk";
$GLOBALS['strDateLinked'] = "Tanggal terkait";

// Login & Permissions
$GLOBALS['strUserAccess'] = "User Access";
$GLOBALS['strAdminAccess'] = "Admin Access";
$GLOBALS['strUserProperties'] = "Properties dari Banner";
$GLOBALS['strPermissions'] = "Izin";
$GLOBALS['strAuthentification'] = "Autentifikasi";
$GLOBALS['strWelcomeTo'] = "Selamat Datang di";
$GLOBALS['strEnterUsername'] = "Silakan masukan Nama dan Kata Sandi Anda untuk Login";
$GLOBALS['strEnterBoth'] = "Silakan masukan Nama <i>dan</i> Kata Sandi";
$GLOBALS['strEnableCookies'] = "Anda harus mengaktifkan cookies sebelum bisa menggunakannya {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "Kesalahan cookie sesi, masuk lagi";
$GLOBALS['strLogin'] = "Masuk";
$GLOBALS['strLogout'] = "Keluar";
$GLOBALS['strUsername'] = "Nama Pengguna";
$GLOBALS['strPassword'] = "Kata Sandi";
$GLOBALS['strPasswordRepeat'] = "Ulangi Kata Sandi";
$GLOBALS['strAccessDenied'] = "Akses ditolak";
$GLOBALS['strUsernameOrPasswordWrong'] = "Nama pengguna atau kata sandi salah. Mohon diulangi.";
$GLOBALS['strPasswordWrong'] = "Kata Sandi salah";
$GLOBALS['strNotAdmin'] = "Kemungkinan privilese Anda kurang";
$GLOBALS['strDuplicateClientName'] = "Nama Pengguna yang dipilih sudah ada. Silakan gunakan nama pengguna yang lain.";
$GLOBALS['strInvalidPassword'] = "Kata Sandi Anda tidak berlaku. Silakan gunakan kata sandi lain.";
$GLOBALS['strInvalidEmail'] = "Email tidak diformat dengan benar, harap cantumkan alamat email yang benar.";
$GLOBALS['strNotSamePasswords'] = "Pasangan Kata Sandi tidak sesuai";
$GLOBALS['strRepeatPassword'] = "Ulangi Kata Sandi";
$GLOBALS['strDeadLink'] = "Tautan Anda tidak valid.";
$GLOBALS['strNoPlacement'] = "Kampanye yang dipilih tidak ada. Coba <a href='{link}'> tautan </a> ini";
$GLOBALS['strNoAdvertiser'] = "Pengiklan pilihan tidak ada. Coba <a href='{link}'>link</a> ini";

// General advertising
$GLOBALS['strRequests'] = "Permintaan";
$GLOBALS['strImpressions'] = "Kesan";
$GLOBALS['strClicks'] = "AdClick";
$GLOBALS['strConversions'] = "Konversi";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "Jumlah AdClick";
$GLOBALS['strTotalConversions'] = "Jumlah Konversi";
$GLOBALS['strDateTime'] = "Tanggal Waktu";
$GLOBALS['strTrackerID'] = "ID Pelacak";
$GLOBALS['strTrackerName'] = "Nama Pelacak";
$GLOBALS['strTrackerImageTag'] = "Menandai Gambar";
$GLOBALS['strTrackerJsTag'] = "Menandai Javascript";
$GLOBALS['strTrackerAlwaysAppend'] = "Selalu tampilkan kode yang ditambahkan, meskipun tidak ada konversi yang dicatat oleh pelacak?";
$GLOBALS['strBanners'] = "Banner";
$GLOBALS['strCampaigns'] = "Kampanye";
$GLOBALS['strCampaignID'] = "ID Kampanye";
$GLOBALS['strCampaignName'] = "Nama Kampanye";
$GLOBALS['strCountry'] = "Negara";
$GLOBALS['strStatsAction'] = "Aksi";
$GLOBALS['strWindowDelay'] = "Penundaan Jendela";
$GLOBALS['strStatsVariables'] = "Variabel";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Sewa menyewa bulanan";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strFinanceCR'] = "CR";

// Time and date related
$GLOBALS['strDate'] = "Tanggal";
$GLOBALS['strDay'] = "Hari";
$GLOBALS['strDays'] = "Hari";
$GLOBALS['strWeek'] = "Minggu";
$GLOBALS['strWeeks'] = "Minggu";
$GLOBALS['strSingleMonth'] = "Satu bulan";
$GLOBALS['strMonths'] = "Bulan";
$GLOBALS['strDayOfWeek'] = "Hari dalam minggu";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = [];
}
$GLOBALS['strDayFullNames'][0] = 'Sunday';
$GLOBALS['strDayFullNames'][1] = 'Monday';
$GLOBALS['strDayFullNames'][2] = 'Tuesday';
$GLOBALS['strDayFullNames'][3] = 'Wednesday';
$GLOBALS['strDayFullNames'][4] = 'Thursday';
$GLOBALS['strDayFullNames'][5] = 'Friday';
$GLOBALS['strDayFullNames'][6] = 'Saturday';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = [];
}
$GLOBALS['strDayShortCuts'][0] = 'Su';
$GLOBALS['strDayShortCuts'][1] = 'Mo';
$GLOBALS['strDayShortCuts'][2] = 'Tu';
$GLOBALS['strDayShortCuts'][3] = 'We';
$GLOBALS['strDayShortCuts'][4] = 'Th';
$GLOBALS['strDayShortCuts'][5] = 'Fr';
$GLOBALS['strDayShortCuts'][6] = 'Sa';

$GLOBALS['strHour'] = "Jam";
$GLOBALS['strSeconds'] = "Detik";
$GLOBALS['strMinutes'] = "Menit";
$GLOBALS['strHours'] = "Jam";

// Advertiser
$GLOBALS['strClient'] = "Pemasang Iklan";
$GLOBALS['strClients'] = "Pemasang Iklan";
$GLOBALS['strClientsAndCampaigns'] = "Pemasang Iklan & Kampanye";
$GLOBALS['strAddClient'] = "Tambah Pemasang Iklan baru";
$GLOBALS['strClientProperties'] = "Properties dari Pemasang Iklan";
$GLOBALS['strClientHistory'] = "Statistik pengiklan";
$GLOBALS['strNoClients'] = "Saat ini tidak ada pengiklan yang ditentukan. Untuk membuat kampanye, <a href='advertiser-edit.php'>tambahkan pengiklan baru</a> terlebih dulu.";
$GLOBALS['strConfirmDeleteClient'] = "Apakah Anda benar ingin hapus Pemasang Iklan yang ini?";
$GLOBALS['strConfirmDeleteClients'] = "Apakah Anda benar ingin hapus Pemasang Iklan yang ini?";
$GLOBALS['strHideInactive'] = "Sembunyikan yang tidak aktif";
$GLOBALS['strInactiveAdvertisersHidden'] = "Pemasang Iklan yang tidak aktif disembunyikan";
$GLOBALS['strAdvertiserSignup'] = "Daftar Pengiklan";
$GLOBALS['strAdvertiserCampaigns'] = "Pemasang Iklan & Kampanye";

// Advertisers properties
$GLOBALS['strContact'] = "Alamat";
$GLOBALS['strContactName'] = "Nama Kontak";
$GLOBALS['strEMail'] = "Alamat E-mail";
$GLOBALS['strSendAdvertisingReport'] = "Kirim laporan iklan lewat E-mail";
$GLOBALS['strNoDaysBetweenReports'] = "Jumlah hari antara laporan";
$GLOBALS['strSendDeactivationWarning'] = "Kirim peringatan bila kampanye tidak aktif";
$GLOBALS['strAllowClientModifyBanner'] = "Izinkan pengguna ini untuk merubah banner yang dimiliki";
$GLOBALS['strAllowClientDisableBanner'] = "Izinkan pengguna ini untuk hentikan banner yang dimiliki";
$GLOBALS['strAllowClientActivateBanner'] = "Izinkan pengguna ini untuk aktifkan banner yang dimiliki";
$GLOBALS['strAdvertiserLimitation'] = "Tampilkan hanya satu banner dari pengiklan ini di halaman web";
$GLOBALS['strAllowAuditTrailAccess'] = "Izinkan pengguna mengakses jejak audit";

// Campaign
$GLOBALS['strCampaign'] = "Kampanye";
$GLOBALS['strCampaigns'] = "Kampanye";
$GLOBALS['strAddCampaign'] = "Tambah kampanye baru";
$GLOBALS['strAddCampaign_Key'] = "Tambah kampanye <u>b</u>aru";
$GLOBALS['strCampaignForAdvertiser'] = "untuk pengiklan";
$GLOBALS['strLinkedCampaigns'] = "Kampanye yang diikat";
$GLOBALS['strCampaignProperties'] = "Properties dari Kampanye";
$GLOBALS['strCampaignOverview'] = "Rekapitulasi Kampanye";
$GLOBALS['strCampaignHistory'] = "Statistik Kampanye";
$GLOBALS['strNoCampaigns'] = "Pada saat ini tidak ada kampanye yang ditentukan";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "Saat ini tidak ada kampanye yang ditentukan, karena tidak ada pengiklan. Untuk membuat kampanye, <a href='advertiser-edit.php'>tambahkan pengiklan baru</a> terlebih dulu.";
$GLOBALS['strConfirmDeleteCampaign'] = "Apakah benar Anda ingin menghapus semua kampanye ini?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Apakah benar Anda ingin menghapus semua kampanye ini?";
$GLOBALS['strShowParentAdvertisers'] = "Tampilkan pemasang iklan induk";
$GLOBALS['strHideParentAdvertisers'] = "Sembunyikan pemasang iklan induk";
$GLOBALS['strHideInactiveCampaigns'] = "Sembunyikan kampanye yang tidak aktif";
$GLOBALS['strInactiveCampaignsHidden'] = "Kampanye yang tidak aktif tersembunyi";
$GLOBALS['strPriorityInformation'] = "Prioritas dalam relasi kampanye yang lain";
$GLOBALS['strECPMInformation'] = "prioritas Bpse";
$GLOBALS['strRemnantEcpmDescription'] = "bpse dihitung secara otomatis berdasarkan kinerja kampanye ini. <br/> Ini akan digunakan untuk memprioritaskan kampanye Sisa relatif terhadap satu sama lain.";
$GLOBALS['strEcpmMinImpsDescription'] = "Tetapkan ini ke basis minium yang Anda inginkan untuk menghitung Bpse kampanye ini.";
$GLOBALS['strHiddenCampaign'] = "Kampanye";
$GLOBALS['strHiddenAd'] = "Iklan";
$GLOBALS['strHiddenAdvertiser'] = "Pemasang Iklan";
$GLOBALS['strHiddenTracker'] = "Pelacak";
$GLOBALS['strHiddenWebsite'] = "Penerbit";
$GLOBALS['strHiddenZone'] = "Zona";
$GLOBALS['strCampaignDelivery'] = "Pelayanan Kampanye";
$GLOBALS['strCompanionPositioning'] = "Iklan yang bermitra";
$GLOBALS['strSelectUnselectAll'] = "Pilih / Batalkan Pilihan";
$GLOBALS['strCampaignsOfAdvertiser'] = "of"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'
$GLOBALS['strShowCappedNoCookie'] = "Tampilkan iklan yang ditandai jika cookie dinonaktifkan";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "Dihitung untuk semua kampanye";
$GLOBALS['strCalculatedForThisCampaign'] = "Dihitung untuk kampanye ini";
$GLOBALS['strLinkingZonesProblem'] = "Masalah terjadi saat menghubungkan zona";
$GLOBALS['strUnlinkingZonesProblem'] = "Masalah terjadi saat zona unlinking";
$GLOBALS['strZonesLinked'] = "zona(s) yang terkait";
$GLOBALS['strZonesUnlinked'] = "zona(s) yang tidak terpaut";
$GLOBALS['strZonesSearch'] = "Pencarian";
$GLOBALS['strZonesSearchTitle'] = "Cari zona dan situs web berdasarkan nama";
$GLOBALS['strNoWebsitesAndZones'] = "Tidak ada situs web dan zona";
$GLOBALS['strNoWebsitesAndZonesText'] = "dengan nama \"%s\"";
$GLOBALS['strToLink'] = "untuk link";
$GLOBALS['strToUnlink'] = "untuk membatalkan tautan";
$GLOBALS['strLinked'] = "Terkait";
$GLOBALS['strAvailable'] = "Tersedia";
$GLOBALS['strShowing'] = "Menampilkan";
$GLOBALS['strEditZone'] = "Sunting zona";
$GLOBALS['strEditWebsite'] = "Sunting situs web";


// Campaign properties
$GLOBALS['strDontExpire'] = "Jangan menghembuskan kampanye ini pada tanggal tertentu";
$GLOBALS['strActivateNow'] = "Aktifkan kampanye ini segera";
$GLOBALS['strSetSpecificDate'] = "Tetapkan tanggal tertentu";
$GLOBALS['strLow'] = "Rendah";
$GLOBALS['strHigh'] = "Tinggi";
$GLOBALS['strExpirationDate'] = "Akhir pada tanggal";
$GLOBALS['strExpirationDateComment'] = "Kampanye akan berakhir pada ujung hari yang ditentukan";
$GLOBALS['strActivationDate'] = "Mulai dari tanggal";
$GLOBALS['strActivationDateComment'] = "Kampanye akan dimulai pada awal hari hari yang ditentukan";
$GLOBALS['strImpressionsRemaining'] = "AdViews yang tersisa";
$GLOBALS['strClicksRemaining'] = "AdKlik yang tersisa";
$GLOBALS['strConversionsRemaining'] = "Konversi yang tersisa";
$GLOBALS['strImpressionsBooked'] = "Jumlah AdViews yang dipesan";
$GLOBALS['strClicksBooked'] = "Jumlah AdKlik yang dipesan";
$GLOBALS['strConversionsBooked'] = "Jumlah konversi yang dipesan";
$GLOBALS['strCampaignWeight'] = "Bobot Kampanye";
$GLOBALS['strAnonymous'] = "Sembunyikan pemasang iklan dan penerbit dari kampanye ini.";
$GLOBALS['strTargetPerDay'] = "per hari.";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "Jenis kampanye ini telah ditetapkan ke Sisa,
tapi bobotnya diset ke nol atau belum
ditentukan. Ini akan menyebabkan kampanye menjadi
dinonaktifkan dan spanduknya tidak akan dikirim
sampai berat telah ditetapkan ke nomor yang valid.

Apakah anda yakin ingin melanjutkan?";
$GLOBALS['strCampaignWarningEcpmNoRevenue'] = "Kampanye ini menggunakan pengoptimalan eCPM
namun 'pendapatan' diset ke nol atau belum ditentukan.
Hal ini akan menyebabkan kampanye dinonaktifkan
dan spanduknya tidak akan dikirim sampai
pendapatan telah ditetapkan ke nomor yang valid.

Apakah anda yakin ingin melanjutkan?";
$GLOBALS['strCampaignWarningOverrideNoWeight'] = "Jenis kampanye ini telah disetel ke Override,
tapi bobotnya diset ke nol atau belum
ditentukan. Ini akan menyebabkan kampanye menjadi
dinonaktifkan dan spanduknya tidak akan dikirim
sampai berat telah ditetapkan ke nomor yang valid.

Apakah anda yakin ingin melanjutkan?";
$GLOBALS['strCampaignWarningNoTarget'] = "Jenis kampanye ini telah ditetapkan ke Kontrak,
tapi Batas per hari tidak ditentukan.
Hal ini akan menyebabkan kampanye dinonaktifkan dan
spanduknya tidak akan dikirim sampai batas yang valid per hari telah ditetapkan.

Apakah anda yakin ingin melanjutkan?";
$GLOBALS['strCampaignStatusPending'] = "Tertunda";
$GLOBALS['strCampaignStatusInactive'] = "aktif";
$GLOBALS['strCampaignStatusRunning'] = "Lari";
$GLOBALS['strCampaignStatusPaused'] = "Istirahat";
$GLOBALS['strCampaignStatusAwaiting'] = "Menunggu";
$GLOBALS['strCampaignStatusExpired'] = "Lengkap";
$GLOBALS['strCampaignStatusApproval'] = "Menunggu persetujuan »";
$GLOBALS['strCampaignStatusRejected'] = "Ditolak";
$GLOBALS['strCampaignStatusAdded'] = "Menambahkan";
$GLOBALS['strCampaignStatusStarted'] = "Memulai";
$GLOBALS['strCampaignStatusRestarted'] = "Restart";
$GLOBALS['strCampaignStatusDeleted'] = "Hapus";
$GLOBALS['strCampaignType'] = "Nama Kampanye";
$GLOBALS['strType'] = "Jenis";
$GLOBALS['strContract'] = "Alamat";
$GLOBALS['strOverride'] = "Mengesampingkan";
$GLOBALS['strOverrideInfo'] = "Mengabaikan kampanye adalah jenis kampanye khusus khusus untuk
    timpa (prioritas prioritas) kampanye Sisa dan Kontrak. Penimpaan kampanye umumnya digunakan bersama
    aturan penargetan dan / atau pembatasan tertentu untuk memastikan bahwa spanduk kampanye selalu ditampilkan secara pasti
    lokasi, untuk pengguna tertentu, dan mungkin beberapa kali, sebagai bagian dari promosi tertentu. (Kampanye ini
    tipe sebelumnya dikenal sebagai 'Kontrak (Eksklusif)'.)";
$GLOBALS['strStandardContract'] = "Alamat";
$GLOBALS['strStandardContractInfo'] = "Kampanye kontrak adalah untuk menyampaikan tayangan dengan lancar
    diperlukan untuk mencapai persyaratan kinerja kritis waktu tertentu. Artinya, kampanye Kontrak untuk kapan
    pengiklan telah membayar secara khusus untuk memberikan sejumlah tayangan, klik, dan / atau konversi
    dicapai antara dua tanggal, atau per hari.";
$GLOBALS['strRemnant'] = "Sisa";
$GLOBALS['strRemnantInfo'] = "Jenis kampanye default. Kampanye tersisa memiliki banyak perbedaan
    pilihan pengiriman, dan sebaiknya Anda selalu memiliki setidaknya satu kampanye tersisa yang terkait dengan setiap zona, untuk memastikannya
    selalu ada sesuatu untuk ditunjukkan. Gunakan kampanye Sisa untuk menampilkan spanduk rumah, spanduk iklan-jaringan, atau bahkan
    periklanan langsung yang telah terjual, namun dimana tidak ada persyaratan kinerja time-critical untuk
    kampanye untuk mematuhi.";
$GLOBALS['strECPMInfo'] = "Ini adalah kampanye standar yang dapat dibatasi dengan tanggal akhir atau batas tertentu. Berdasarkan pengaturan saat ini, akan diprioritaskan menggunakan eCPM.";
$GLOBALS['strPricing'] = "Harga";
$GLOBALS['strPricingModel'] = "Model harga";
$GLOBALS['strSelectPricingModel'] = "- pilih model -";
$GLOBALS['strRatePrice'] = "Tarif / Harga";
$GLOBALS['strMinimumImpressions'] = "Tayangan minimum setiap hari";
$GLOBALS['strLimit'] = "Batas";
$GLOBALS['strLowExclusiveDisabled'] = "Anda tidak dapat mengubah kampanye ini menjadi Sisa atau Eksklusif, karena batas tanggal akhir dan salah satu dari tayangan/klik/konversi ditetapkan. <br>Untuk mengubah jenis, Anda tidak perlu menetapkan tanggal kadaluwarsa atau menghapus batasan.";
$GLOBALS['strCannotSetBothDateAndLimit'] = "Anda tidak dapat menetapkan tanggal akhir dan batas untuk kampanye Sisa atau Eksklusif. <br>Jika Anda perlu menetapkan tanggal akhir dan membatasi tayangan/klik/konversi, gunakan kampanye Kontrak non-eksklusif.";
$GLOBALS['strWhyDisabled'] = "mengapa itu dinonaktifkan?";
$GLOBALS['strBackToCampaigns'] = "Kembali ke kampanye";
$GLOBALS['strCampaignBanners'] = "Spanduk kampanye";
$GLOBALS['strCookies'] = "Kue";

// Tracker
$GLOBALS['strTracker'] = "Pelacak";
$GLOBALS['strTrackers'] = "Pelacak";
$GLOBALS['strTrackerPreferences'] = "Preferensi Pelacak";
$GLOBALS['strAddTracker'] = "Tambah pelacak baru";
$GLOBALS['strTrackerForAdvertiser'] = "untuk pengiklan";
$GLOBALS['strNoTrackers'] = "Pada saat ini belum ada pelacak yang ditetapkan";
$GLOBALS['strConfirmDeleteTrackers'] = "Apakah Anda sudah yakin ingin menghapus seluruh pelacak?";
$GLOBALS['strConfirmDeleteTracker'] = "Apakah Anda sudah yakin ingin menghapus seluruh pelacak?";
$GLOBALS['strTrackerProperties'] = "Ciri-ciri dari Pelacak";
$GLOBALS['strDefaultStatus'] = "Keadaan Default";
$GLOBALS['strStatus'] = "Keadaan";
$GLOBALS['strLinkedTrackers'] = "Pelacak yang terikat";
$GLOBALS['strTrackerInformation'] = "Informasi Pelacak";
$GLOBALS['strConversionWindow'] = "Pandangan konversi";
$GLOBALS['strUniqueWindow'] = "Window unik";
$GLOBALS['strClick'] = "Klik";
$GLOBALS['strView'] = "Pandangan";
$GLOBALS['strArrival'] = "Kedatangan";
$GLOBALS['strManual'] = "Manual";
$GLOBALS['strImpression'] = "Kesan";
$GLOBALS['strConversionType'] = "Jenis konversi";
$GLOBALS['strLinkCampaignsByDefault'] = "Hubungkan kampanye baru secara Default";
$GLOBALS['strBackToTrackers'] = "Kembali ke pelacak";
$GLOBALS['strIPAddress'] = "Alamat IP";

// Banners (General)
$GLOBALS['strBanner'] = "Spanduk";
$GLOBALS['strBanners'] = "Banner";
$GLOBALS['strAddBanner'] = "Tambah banner baru";
$GLOBALS['strAddBanner_Key'] = "Tambah banner <u>b</u>aru";
$GLOBALS['strBannerToCampaign'] = "Kampanye Anda";
$GLOBALS['strShowBanner'] = "Tampilkan banner";
$GLOBALS['strBannerProperties'] = "Properties dari Banner";
$GLOBALS['strBannerHistory'] = "Statistik spanduk";
$GLOBALS['strNoBanners'] = "Pada saat ini tidak ada banner yang ditentukan";
$GLOBALS['strNoBannersAddCampaign'] = "Saat ini tidak ada spanduk yang ditentukan, karena tidak ada kampanye. Untuk membuat spanduk, <a href='campaign-edit.php?clientid=%s'>tambahkan kampanye baru</a> terlebih dulu.";
$GLOBALS['strNoBannersAddAdvertiser'] = "Saat ini tidak ada spanduk yang ditentukan, karena tidak ada pengiklan. Untuk membuat spanduk, <a href='advertiser-edit.php'>tambahkan pengiklan baru</a> terlebih dahulu.";
$GLOBALS['strConfirmDeleteBanner'] = "Apakah benar Anda ingin menghapus banner ini?";
$GLOBALS['strConfirmDeleteBanners'] = "Apakah benar Anda ingin menghapus banner ini?";
$GLOBALS['strShowParentCampaigns'] = "Tampilkan kampanye induk";
$GLOBALS['strHideParentCampaigns'] = "Sembunyikan kampanye induk";
$GLOBALS['strHideInactiveBanners'] = "Sembunyikan banner yang tidak aktif";
$GLOBALS['strInactiveBannersHidden'] = "Banner yang tidak aktif tesembunyi";
$GLOBALS['strWarningMissing'] = "Perhatian, kemungkinan ada kekurangan";
$GLOBALS['strWarningMissingClosing'] = "penutup ujung \\\">\\\"";
$GLOBALS['strWarningMissingOpening'] = "pembuka ujung \\\"<\\\"";
$GLOBALS['strSubmitAnyway'] = "Tetap menyerahi";
$GLOBALS['strBannersOfCampaign'] = "dalam"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "Preferensi Banner";
$GLOBALS['strCampaignPreferences'] = "Preferensi Kampanye";
$GLOBALS['strDefaultBanners'] = "Spanduk Default";
$GLOBALS['strDefaultBannerUrl'] = "URL gambar default";
$GLOBALS['strDefaultBannerDestination'] = "URL tujuan standar";
$GLOBALS['strAllowedBannerTypes'] = "Jenis Banner yang Diizinkan";
$GLOBALS['strTypeSqlAllow'] = "Izinkan Spanduk Lokal SQL";
$GLOBALS['strTypeWebAllow'] = "Izinkan Banner Lokal Webserver";
$GLOBALS['strTypeUrlAllow'] = "Izinkan Spanduk Eksternal";
$GLOBALS['strTypeHtmlAllow'] = "Izinkan Banner HTML";
$GLOBALS['strTypeTxtAllow'] = "Izinkan Iklan Teks";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Silakan pilih jenis banner";
$GLOBALS['strMySQLBanner'] = "Banner lokal (SQL)";
$GLOBALS['strWebBanner'] = "Banner lokal (Webserver)";
$GLOBALS['strURLBanner'] = "Banner eksternal";
$GLOBALS['strHTMLBanner'] = "Banner HTML";
$GLOBALS['strTextBanner'] = "Text ad";
$GLOBALS['strAlterHTML'] = "Alter HTML untuk mengaktifkan pelacakan klik untuk:";
$GLOBALS['strIframeFriendly'] = "Spanduk ini dapat ditampilkan dengan aman di dalam iframe (mis. Tidak dapat diperluas)";
$GLOBALS['strUploadOrKeep'] = "Apakah Anda ingin mempertahankan <br />gambar yang lama atau <br />Anda inging upload gambar baru?";
$GLOBALS['strNewBannerFile'] = "Silakan pilih gambar untuk <br />dipakai pada banner ini<br /><br />";
$GLOBALS['strNewBannerFileAlt'] = "Silakan pilih Backup Image <br />yang ingin digunakan <br />bila Browser pengguna tidak mendukung Rich Media <br /><br />";
$GLOBALS['strNewBannerURL'] = "URL gambar (termasuk http://)";
$GLOBALS['strURL'] = "URL tujuan (termasuk http://)";
$GLOBALS['strKeyword'] = "Kata Kunci";
$GLOBALS['strTextBelow'] = "Teks dibawah gambar";
$GLOBALS['strWeight'] = "Bobot";
$GLOBALS['strAlt'] = "Teks alternatif";
$GLOBALS['strStatusText'] = "Teks status";
$GLOBALS['strBannerWeight'] = "Bobot banner";
$GLOBALS['strAdserverTypeGeneric'] = "Spanduk HTML Generik";
$GLOBALS['strDoNotAlterHtml'] = "Jangan ubah HTML";
$GLOBALS['strGenericOutputAdServer'] = "Generik";
$GLOBALS['strBackToBanners'] = "Kembali ke spanduk";
$GLOBALS['strUseWyswygHtmlEditor'] = "Gunakan Editor HTML WYSIWYG";
$GLOBALS['strChangeDefault'] = "Ubah default";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "Always prepend the following HTML code to this banner";
$GLOBALS['strBannerAppendHTML'] = "Selalu tambahkan kode HTML berikut ke banner ini";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "Pilihan Penyampaian";
$GLOBALS['strACL'] = "Pilihan Penyampaian";
$GLOBALS['strACLAdd'] = "Tambahkan aturan pengiriman";
$GLOBALS['strApplyLimitationsTo'] = "Terapkan peraturan pengiriman ke";
$GLOBALS['strAllBannersInCampaign'] = "Semua spanduk dalam kampanye ini";
$GLOBALS['strRemoveAllLimitations'] = "Hapus semua aturan pengiriman";
$GLOBALS['strEqualTo'] = "sama dengan";
$GLOBALS['strDifferentFrom'] = "lain dibandingkan dengan";
$GLOBALS['strLaterThan'] = "adalah lebih dari";
$GLOBALS['strLaterThanOrEqual'] = "lebih dari atau sama dengan";
$GLOBALS['strEarlierThan'] = "lebih awal dari";
$GLOBALS['strEarlierThanOrEqual'] = "lebih awal dari atau sama dengan";
$GLOBALS['strContains'] = "mengandung";
$GLOBALS['strNotContains'] = "tidak mengandung";
$GLOBALS['strGreaterThan'] = "lebih besar daripada";
$GLOBALS['strLessThan'] = "lebih kecil daripada";
$GLOBALS['strGreaterOrEqualTo'] = "lebih besar atau sama dengan";
$GLOBALS['strLessOrEqualTo'] = "kurang atau sama dengan";
$GLOBALS['strAND'] = "DAN";                          // logical operator
$GLOBALS['strOR'] = "ATAU";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Tampilkan banner ini hanya:";
$GLOBALS['strWeekDays'] = "Hari Kerja";
$GLOBALS['strTime'] = "Waktu";
$GLOBALS['strDomain'] = "Domain";
$GLOBALS['strSource'] = "Sumber";
$GLOBALS['strBrowser'] = "Browser";
$GLOBALS['strOS'] = "OS";
$GLOBALS['strDeliveryLimitations'] = "Aturan Pengiriman";

$GLOBALS['strDeliveryCappingReset'] = "Reset hitungan AdViews setelah:";
$GLOBALS['strDeliveryCappingTotal'] = "jumlahnya";
$GLOBALS['strDeliveryCappingSession'] = "per sesi";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = [];
}
$GLOBALS['strCappingBanner']['title'] = "Pengiriman capping per pengunjung";
$GLOBALS['strCappingBanner']['limit'] = "Batasi penampilan banner pada:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = [];
}
$GLOBALS['strCappingCampaign']['title'] = "Pengiriman capping per pengunjung";
$GLOBALS['strCappingCampaign']['limit'] = "Batasi penampilan kampanye pada:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = [];
}
$GLOBALS['strCappingZone']['title'] = "Pengiriman capping per pengunjung";
$GLOBALS['strCappingZone']['limit'] = "Batasi penampilan zona pada:";

// Website
$GLOBALS['strAffiliate'] = "Penerbit";
$GLOBALS['strAffiliates'] = "Halaman web";
$GLOBALS['strAffiliatesAndZones'] = "Halaman web & Zona";
$GLOBALS['strAddNewAffiliate'] = "Tambah halaman web baru";
$GLOBALS['strAffiliateProperties'] = "Properties dari website";
$GLOBALS['strAffiliateHistory'] = "Statistik Situs Web";
$GLOBALS['strNoAffiliates'] = "Belum ada Penerbit yang ditentukan";
$GLOBALS['strConfirmDeleteAffiliate'] = "Apakah benar Anda ingin menghapus Penerbit ini?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Apakah benar Anda ingin menghapus Penerbit ini?";
$GLOBALS['strInactiveAffiliatesHidden'] = "penerbit yang tidak aktif disembunyikan";
$GLOBALS['strShowParentAffiliates'] = "Tampilkan penerbit induk";
$GLOBALS['strHideParentAffiliates'] = "Sembunyikan penerbit induk";

// Website (properties)
$GLOBALS['strWebsite'] = "Penerbit";
$GLOBALS['strWebsiteURL'] = "Website URL";
$GLOBALS['strAllowAffiliateModifyZones'] = "Izinkan pengguna ini untuk mengubah zona yang dimiliki";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Izinkan pengguna ini untuk me-link banner ke zona yang dimiliki";
$GLOBALS['strAllowAffiliateAddZone'] = "Izinkan pengguna ini untuk membuat zona baru";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Izinkan pengguna ini untuk  menghapus zona yang ada";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Izinkan pengguna ini untuk pengolah sendiri kode invokasi";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "Kode Pos";
$GLOBALS['strCountry'] = "Negara";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Halaman web & Zona";

// Zone
$GLOBALS['strZone'] = "Zona";
$GLOBALS['strZones'] = "Zona";
$GLOBALS['strAddNewZone'] = "Tambah zona baru";
$GLOBALS['strAddNewZone_Key'] = "Tambah zona <u>b</u>aru";
$GLOBALS['strZoneToWebsite'] = "Semua penerbit";
$GLOBALS['strLinkedZones'] = "Zona yang dihubungkan";
$GLOBALS['strAvailableZones'] = "Zona yang tersedia";
$GLOBALS['strLinkingNotSuccess'] = "Menghubungkan tidak berhasil, coba lagi";
$GLOBALS['strZoneProperties'] = "Properties Zona";
$GLOBALS['strZoneHistory'] = "Sejarah Zona";
$GLOBALS['strNoZones'] = "Tidak ada zona yang ditentukan";
$GLOBALS['strNoZonesAddWebsite'] = "Saat ini tidak ada zona yang ditentukan, karena tidak ada situs web. Untuk membuat zona, <a href='affiliate-edit.php'> tambahkan situs web baru </a> terlebih dahulu.";
$GLOBALS['strConfirmDeleteZone'] = "Apakah benar Anda ingin menghapus zona ini?";
$GLOBALS['strConfirmDeleteZones'] = "Apakah benar Anda ingin menghapus zona ini?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "Ada kampanye yang masih terkait dengan zona ini, jika Anda menghapusnya, ini tidak akan dapat berjalan dan Anda tidak akan dibayar untuk itu.";
$GLOBALS['strZoneType'] = "Jenis Zona";
$GLOBALS['strBannerButtonRectangle'] = "Banner, Tombol atau Bujur Sangkar";
$GLOBALS['strInterstitial'] = "Interstitial atau Floating DHTML";
$GLOBALS['strPopup'] = "Muncul";
$GLOBALS['strTextAdZone'] = "Iklan teks";
$GLOBALS['strEmailAdZone'] = "Zona Email/Newsletter";
$GLOBALS['strZoneVideoInstream'] = "Iklan video sebaris";
$GLOBALS['strZoneVideoOverlay'] = "Iklan video hamparan";
$GLOBALS['strShowMatchingBanners'] = "Tampilkan banner sepadan";
$GLOBALS['strHideMatchingBanners'] = "Sembunyikan banner sepadan";
$GLOBALS['strBannerLinkedAds'] = "Banner yang dihubungkan pada zona";
$GLOBALS['strCampaignLinkedAds'] = "Kampanye yang dihubungkan pada zona";
$GLOBALS['strInactiveZonesHidden'] = "zona yang tidak aktif tersembunyi";
$GLOBALS['strWarnChangeZoneType'] = "Mengubah jenis zona menjadi teks atau email akan membatalkan semua spanduk / kampanye karena pembatasan jenis zona ini
                                                <ul>
                                                    <li> Zona teks hanya dapat ditautkan ke iklan teks </li>
                                                    <li> Kampanye zona email hanya dapat memiliki satu spanduk aktif sekaligus </li>
                                                </ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Mengubah ukuran zona akan membatalkan tautan spanduk yang bukan ukuran baru, dan akan menambahkan spanduk dari kampanye tertaut yang merupakan ukuran baru';
$GLOBALS['strWarnChangeBannerSize'] = 'Mengubah ukuran banner akan membatalkan tautan panji-panji ini dari zona mana pun yang bukan ukurannya yang baru, dan jika <strong> kampanye </strong> banner ini ditautkan ke zona ukuran baru, spanduk ini akan dihubungkan secara otomatis';
$GLOBALS['strWarnBannerReadonly'] = 'Spanduk ini hanya bisa dibaca karena ekstensi telah dinonaktifkan. Hubungi administrator sistem Anda untuk informasi lebih lanjut.';
$GLOBALS['strZonesOfWebsite'] = 'dalam'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "Kembali ke zona";

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "Banner Penuh IAB (468 x 60)";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "Pencakar langit IAB (120 x 600)";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "Papan Utama IAB (728 x 90)";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "Tombol IAB 1 (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "Tombol IAB 2 (120 x 60)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "Setengah spanduk IAB (234 x 60)";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "IAB Micro Bar (88 x 31)";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "Tombol Kotak IAB (125 x 125)";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "Persegi IAB (180 x 150)";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "IAB Lapangan Pop-up (250 x 250)";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "Banner Vertikal IAB (120 x 240)";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "Kotak sedang IAB (300 x 250)";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "Kotak besar IAB (336 x 280)";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "IAB Vertical Rectangle (240 x 400)";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "Skyscraper Lebar IAB (160 x 600)";
$GLOBALS['strIab']['IAB_Pop-Under(720x300)'] = "IAB Pop-Under (720 x 300)";
$GLOBALS['strIab']['IAB_3:1Rectangle(300x100)'] = "IAB 3:1 persegi (300 x 100)";

// Advanced zone settings
$GLOBALS['strAdvanced'] = "Tingkat Lanjut";
$GLOBALS['strChainSettings'] = "Stelan Rantai";
$GLOBALS['strZoneNoDelivery'] = "Bila tidak ada banner dari zona ini yang dapat ditampilkan, coba untuk...";
$GLOBALS['strZoneStopDelivery'] = "Hentikan penyampaian dan jangan menampilkan banner";
$GLOBALS['strZoneOtherZone'] = "Tampilkan zona yang dipilih sebagai pengganti";
$GLOBALS['strZoneAppend'] = "Selalu menambahkan kode HTML berikut kepada banner yang ditampilkan di zona ini";
$GLOBALS['strAppendSettings'] = "Menambahkan dan mensisipkan didepan pada penyetelan";
$GLOBALS['strZonePrependHTML'] = "Selalu sisipkan kode HTML didepan text ads yang ditampilkan oleh zona ini";
$GLOBALS['strZoneAppendNoBanner'] = "Tetap tempelkan meskipun banner tidak terlayani";
$GLOBALS['strZoneAppendHTMLCode'] = "Kode HTML";
$GLOBALS['strZoneAppendZoneSelection'] = "Popup atau intersitial";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "Tidak ada banner aktif yang di-link kepada zona yang dipilih. <br />Ini adalah rantai zona yang akan diikuti:";
$GLOBALS['strZoneProbNullPri'] = "Seluruh banner yang di-link kepada zona yang dipilih pada saat ini dalam keadaan tidak aktif";
$GLOBALS['strZoneProbListChainLoop'] = "Ikuti rantai zona akan mengakibatkan liku sirkular. Penyampaian untuk zona ini dihentikan";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Silakan pilih jenis hubungan banner";
$GLOBALS['strLinkedBanners'] = "Hubungkan banner individual";
$GLOBALS['strCampaignDefaults'] = "Hubungkan banner berdasarkan kampanye induk";
$GLOBALS['strLinkedCategories'] = "Hubungkan banner berdasarkan kategori induk";
$GLOBALS['strWithXBanners'] = "%d spanduk(s)";
$GLOBALS['strRawQueryString'] = "Kata Kunci";
$GLOBALS['strIncludedBanners'] = "Banner yang di-link";
$GLOBALS['strMatchingBanners'] = "{count} banner sepadan";
$GLOBALS['strNoCampaignsToLink'] = "Pada saat ini tidak ada kampanye yang tersedia untuk di-link ke zona ini";
$GLOBALS['strNoTrackersToLink'] = "Pada saat ini tidak tersedia pelacak yang dapat dihubungkan dengan kampanye ini";
$GLOBALS['strNoZonesToLinkToCampaign'] = "Tidak ada zona yang tersedia untuk me-link kampanye ini";
$GLOBALS['strSelectBannerToLink'] = "Silakan pilih banner untuk di-link ke zona ini:";
$GLOBALS['strSelectCampaignToLink'] = "Silakan pilih kampanye untuk di-link ke zona ini:";
$GLOBALS['strSelectAdvertiser'] = "Pilih pemasang iklan";
$GLOBALS['strSelectPlacement'] = "Pilih kampanye";
$GLOBALS['strSelectAd'] = "Pilih banner";
$GLOBALS['strSelectPublisher'] = "Pilih Website";
$GLOBALS['strSelectZone'] = "Pilih zona";
$GLOBALS['strStatusPending'] = "Tertunda";
$GLOBALS['strStatusApproved'] = "Disetujui";
$GLOBALS['strStatusDisapproved'] = "Tidak disetujui";
$GLOBALS['strStatusDuplicate'] = "Mendobelkan";
$GLOBALS['strStatusOnHold'] = "Tertahan";
$GLOBALS['strStatusIgnore'] = "Mengabaikan";
$GLOBALS['strConnectionType'] = "Jenis";
$GLOBALS['strConnTypeSale'] = "Penjualan";
$GLOBALS['strConnTypeLead'] = "Memimpin";
$GLOBALS['strConnTypeSignUp'] = "Daftar";
$GLOBALS['strShortcutEditStatuses'] = "Edit status";
$GLOBALS['strShortcutShowStatuses'] = "Tampilkan status";

// Statistics
$GLOBALS['strStats'] = "Statistik";
$GLOBALS['strNoStats'] = "Pada saat ini belum ada statistik yang tersedia";
$GLOBALS['strNoStatsForPeriod'] = "Statistik untuk periode %s s/d. %s pada saat ini belum tersedia ";
$GLOBALS['strGlobalHistory'] = "Statistik Global";
$GLOBALS['strDailyHistory'] = "Statistik Harian";
$GLOBALS['strDailyStats'] = "Statistik Harian";
$GLOBALS['strWeeklyHistory'] = "Statistik mingguan";
$GLOBALS['strMonthlyHistory'] = "Statistik Bulanan";
$GLOBALS['strTotalThisPeriod'] = "Jumlah dalam periode ini";
$GLOBALS['strPublisherDistribution'] = "Distribusi penerbit";
$GLOBALS['strCampaignDistribution'] = "Distribusi kampanye";
$GLOBALS['strViewBreakdown'] = "Tampilkan berdasarkan";
$GLOBALS['strBreakdownByDay'] = "Hari";
$GLOBALS['strBreakdownByWeek'] = "Minggu";
$GLOBALS['strBreakdownByMonth'] = "Satu bulan";
$GLOBALS['strBreakdownByDow'] = "Hari dalam minggu";
$GLOBALS['strBreakdownByHour'] = "Jam";
$GLOBALS['strItemsPerPage'] = "Item per halaman";
$GLOBALS['strDistributionHistoryCampaign'] = "Statistik Distribusi (Kampanye)";
$GLOBALS['strDistributionHistoryBanner'] = "Statistik Distribusi (Spanduk)";
$GLOBALS['strDistributionHistoryWebsite'] = "Statistik Distribusi (SitusWeb)";
$GLOBALS['strDistributionHistoryZone'] = "Statistik Distribusi (Zona)";
$GLOBALS['strShowGraphOfStatistics'] = "Tampilkan <u>G</u>rafik Statistik";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>kspor Statistik ke Excel";
$GLOBALS['strGDnotEnabled'] = "Anda harus mengaktifkan GD di PHP untuk menampilkan grafik. <br /> Silakan lihat <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> untuk informasi lebih lanjut, termasuk bagaimana untuk menginstal GD di server Anda.";
$GLOBALS['strStatsArea'] = "Daerah";

// Expiration
$GLOBALS['strNoExpiration'] = "Tanggal masa berlaku tidak ditentukan";
$GLOBALS['strEstimated'] = "Perkiraan habisnya masa berlaku";
$GLOBALS['strNoExpirationEstimation'] = "Belum ada perkiraan kedaluwarsa";
$GLOBALS['strDaysAgo'] = "beberapa hari yang lalu";
$GLOBALS['strCampaignStop'] = "Sejarah Kampanye";

// Reports
$GLOBALS['strAdvancedReports'] = "Laporan Lanjutan";
$GLOBALS['strStartDate'] = "Mulai tanggal";
$GLOBALS['strEndDate'] = "Tanggal akhir";
$GLOBALS['strPeriod'] = "Periode";
$GLOBALS['strLimitations'] = "Aturan Pengiriman";
$GLOBALS['strWorksheets'] = "Lembar kerja";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "Semua pemasang iklan";
$GLOBALS['strAnonAdvertisers'] = "Pengiklan anonim";
$GLOBALS['strAllPublishers'] = "Semua penerbit";
$GLOBALS['strAnonPublishers'] = "Anonymous publishers";
$GLOBALS['strAllAvailZones'] = "Seluruh zona yang tersedia";

// Userlog
$GLOBALS['strUserLog'] = "User log";
$GLOBALS['strUserLogDetails'] = "Perincian User log";
$GLOBALS['strDeleteLog'] = "Hapus log";
$GLOBALS['strAction'] = "Aksi";
$GLOBALS['strNoActionsLogged'] = "Tidak ada tindakan yang di-log";

// Code generation
$GLOBALS['strGenerateBannercode'] = "Pembuatan Langsung";
$GLOBALS['strChooseInvocationType'] = "Silakan pilih jenis invokasi banner";
$GLOBALS['strGenerate'] = "Buat   ";
$GLOBALS['strParameters'] = "Parameter";
$GLOBALS['strFrameSize'] = "Ukuran Frame";
$GLOBALS['strBannercode'] = "Kode Banner";
$GLOBALS['strTrackercode'] = "Kode Pelacakan";
$GLOBALS['strBackToTheList'] = "Kembali ke daftar laporan";
$GLOBALS['strCharset'] = "Set karakter";
$GLOBALS['strAutoDetect'] = "Deteksi otomatis";
$GLOBALS['strCacheBusterComment'] = "  * Ganti semua contoh {random} dengan
   * nomor acak yang dihasilkan (atau timestamp).
   *";

// Errors
$GLOBALS['strErrorDatabaseConnection'] = "Kesalahan koneksi database.";
$GLOBALS['strErrorCantConnectToDatabase'] = "Kesalahan fatal terjadi %1\$s tidak dapat terhubung ke database. Karena
                                                   Ini tidak mungkin menggunakan antarmuka administrator. Pengiriman
                                                   spanduk juga mungkin terpengaruh Kemungkinan alasan untuk masalah ini adalah:
                                                   <ul>
                                                     <li>Server database tidak berfungsi saat ini</li>
                                                     <li>Lokasi server database telah berubah</li>
                                                     <li>Username atau password yang digunakan untuk menghubungi database server tidak benar</li>
                                                     <li>PHP belum memuat <i>%2\$s</i> perpanjangan</li>
                                                   </ul>";
$GLOBALS['strNoMatchesFound'] = "Tidak ada sepadan yang ditemukan";
$GLOBALS['strErrorOccurred'] = "Telah terjadi Error";
$GLOBALS['strErrorDBPlain'] = "Telah terjadi Error sewaktu mengakses database";
$GLOBALS['strErrorDBSerious'] = "Terdeteksi masalah serius pada database";
$GLOBALS['strErrorDBNoDataPlain'] = "Karena masalah pada database {$PRODUCT_NAME} tidak dapat mengambil atau menyimpan data. ";
$GLOBALS['strErrorDBNoDataSerious'] = "Karena masalah serius dengan database, {$PRODUCT_NAME} tidak dapat mengambil data";
$GLOBALS['strErrorDBCorrupt'] = "Tabel pada database rupanya rusak dan perlu perbaikan. Untuk informasi lebih lanjut tentang caranya memperbaiki tabel yang rusak mohon baca BAB <i>Troubleshooting</i> pada <i>Administrator Guide</i>.";
$GLOBALS['strErrorDBContact'] = "Mohon hubungi Administrator dari server ini dan beritahukan masalah ini.";
$GLOBALS['strErrorDBSubmitBug'] = "Jika masalah ini dapat direproduksi, hal itu mungkin disebabkan oleh bug di {$PRODUCT_NAME}. Harap laporkan informasi berikut ke pembuat {$PRODUCT_NAME}. Juga coba gambarkan tindakan yang menyebabkan kesalahan ini sejelas mungkin.";
$GLOBALS['strMaintenanceNotActive'] = "Script pemeliharaan belum dijalankan dalam 24 jam terakhir.
Agar aplikasi berfungsi dengan benar maka perlu dijalankan
setiap jam.

Silakan baca panduan Administrator untuk informasi lebih lanjut
tentang konfigurasi script pemeliharaan.";
$GLOBALS['strErrorLinkingBanner'] = "Tidak mungkin menautkan banner ini ke zona ini karena:";
$GLOBALS['strUnableToLinkBanner'] = "Gagal menghubungkan banner: ";
$GLOBALS['strErrorEditingCampaignRevenue'] = "format angka yang salah di bidang Informasi Pendapatan";
$GLOBALS['strErrorEditingCampaignECPM'] = "format nomor salah di bidang Informasi BPTM";
$GLOBALS['strErrorEditingZone'] = "Kesalahan saat memperbarui zona:";
$GLOBALS['strUnableToChangeZone'] = "Gagal melakukan perubahan ini disebabkan:";
$GLOBALS['strDatesConflict'] = "tanggal-tanggal berbentrokan dengan:";
$GLOBALS['strEmailNoDates'] = "Kampanye yang tertaut ke Zona Email harus memiliki tanggal mulai dan tanggal akhir. {$PRODUCT_NAME} memastikan bahwa pada tanggal tertentu, hanya satu banner aktif yang terhubung ke Zona Email. Pastikan bahwa kampanye yang sudah tertaut ke zona tidak memiliki tanggal yang tumpang tindih dengan kampanye yang ingin Anda tautkan.";
$GLOBALS['strWarningInaccurateStats'] = "Beberapa statistik ini masuk dalam zona waktu non-UTC, dan mungkin tidak ditampilkan di zona waktu yang benar.";
$GLOBALS['strWarningInaccurateReadMore'] = "Baca lebih lanjut tentang ini";
$GLOBALS['strWarningInaccurateReport'] = "Beberapa statistik dalam laporan ini masuk dalam zona waktu non-UTC, dan mungkin tidak ditampilkan di zona waktu yang benar";

//Validation
$GLOBALS['strRequiredFieldLegend'] = "menunjukkan bidang yang diperlukan";
$GLOBALS['strFormContainsErrors'] = "Formulir berisi kesalahan, perbaiki bidang yang ditandai di bawah ini.";
$GLOBALS['strXRequiredField'] = "%s dibutuhkan";
$GLOBALS['strEmailField'] = "Tolong masukkan email yang benar";
$GLOBALS['strNumericField'] = "Harap masukkan nomor (hanya angka yang diperbolehkan)";
$GLOBALS['strGreaterThanZeroField'] = "Harus lebih besar dari 0";
$GLOBALS['strXGreaterThanZeroField'] = "%s harus lebih besar dari 0";
$GLOBALS['strXPositiveWholeNumberField'] = "%s harus bilangan bulat positif";
$GLOBALS['strInvalidWebsiteURL'] = "URL Situs Web tidak valid";

// Email
$GLOBALS['strSirMadam'] = "Ibu/Bpk";
$GLOBALS['strMailSubject'] = "Laporan untuk Pemasang Iklan";
$GLOBALS['strMailHeader'] = "Dear {contact},";
$GLOBALS['strMailBannerStats'] = "Bersama E-mail ini kami kirimkan data statistik dari iklan banner untuk {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Kampanye diaktifkan";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Kampanye dihentikan";
$GLOBALS['strMailBannerActivated'] = "Kampanye Anda yang ditunjukkan di bawah ini telah diaktifkan karena
tanggal aktivasi kampanye telah tercapai.";
$GLOBALS['strMailBannerDeactivated'] = "Kampanye yang dibawah ini telah dihentikan berdasarkan";
$GLOBALS['strMailFooter'] = "Salam,
    {adminfullname}";
$GLOBALS['strClientDeactivated'] = "Kampanye ini pada saat sekarang tidak aktif sehubungan";
$GLOBALS['strBeforeActivate'] = "tanggal aktivasi belum tercapai";
$GLOBALS['strAfterExpire'] = "waktu habisnya sudah tercapai";
$GLOBALS['strNoMoreImpressions'] = "tidak ada impresi yang tertinggal";
$GLOBALS['strNoMoreClicks'] = "tidak ada AdKlik yang tertinggal";
$GLOBALS['strNoMoreConversions'] = "tidak ada sisa penjualan";
$GLOBALS['strWeightIsNull'] = "bobotnya ditetapkan pada angka nol";
$GLOBALS['strRevenueIsNull'] = "pendapatannya diset ke nol";
$GLOBALS['strTargetIsNull'] = "targetnya ditetapkan pada angka nol";
$GLOBALS['strNoViewLoggedInInterval'] = "Tidak ada impresi yang tercatat pada jangka waktu laporan ini";
$GLOBALS['strNoClickLoggedInInterval'] = "Tidak ada AdKlik yang tercatat pada jangka waktu laporan ini";
$GLOBALS['strNoConversionLoggedInInterval'] = "Tidak ada konversi yang tercatat pada jangka waktu laporan ini";
$GLOBALS['strMailReportPeriod'] = "Laporan ini mencakup statistik tentang performa banner Anda di situs kami terhitung dari tanggal {startdate} s/d. tanggal {enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "Laporan ini mencakup seluruh statistik tentang performa banner Anda di situs kami terhitung s/d. tanggal {enddate}..";
$GLOBALS['strNoStatsForCampaign'] = "Untuk kampanye ini tidak ada statistik yang tersedia";
$GLOBALS['strImpendingCampaignExpiry'] = "Waktu berakhirnya kampanye dalam waktu dekat";
$GLOBALS['strYourCampaign'] = "Kampanye Anda";
$GLOBALS['strTheCampiaignBelongingTo'] = "Kampanye ini dimiliki oleh";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} dibawah ini akan berakhir pada tanggal {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} dibawah ini impresinya yang tersisa lebih kurang dari {limit}.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "Akibatnya, kampanye akan segera dinonaktifkan secara otomatis, dan
Berikut spanduk dalam kampanye juga akan dinonaktifkan:";

// Priority
$GLOBALS['strPriority'] = "Prioritas";
$GLOBALS['strSourceEdit'] = "Edit Sumber";

// Preferences
$GLOBALS['strPreferences'] = "Preferensi";
$GLOBALS['strUserPreferences'] = "Preferensi Pengguna";
$GLOBALS['strChangePassword'] = "Ganti kata sandi";
$GLOBALS['strChangeEmail'] = "Ganti E-mail";
$GLOBALS['strCurrentPassword'] = "Kata sandi saat ini";
$GLOBALS['strChooseNewPassword'] = "Pilih kata sandi baru";
$GLOBALS['strReenterNewPassword'] = "Masukkan kembali kata sandi baru";
$GLOBALS['strNameLanguage'] = "Nama & bahasa";
$GLOBALS['strAccountPreferences'] = "Preferensi Account";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Preferensi Laporan email kampanye";
$GLOBALS['strTimezonePreferences'] = "Preferensi Zona Waktu";
$GLOBALS['strAdminEmailWarnings'] = "Peringatan email administrator sistem";
$GLOBALS['strAgencyEmailWarnings'] = "Peringatan email akun";
$GLOBALS['strAdveEmailWarnings'] = "Peringatan email pengiklan";
$GLOBALS['strFullName'] = "Nama lengkap";
$GLOBALS['strEmailAddress'] = "Alamat email";
$GLOBALS['strUserDetails'] = "Rincian pengguna";
$GLOBALS['strUserInterfacePreferences'] = "Preferensi Antarmuka Pengguna";
$GLOBALS['strPluginPreferences'] = "Preferensi Plugin";
$GLOBALS['strColumnName'] = "Nama kolom";
$GLOBALS['strShowColumn'] = "Tampilkan Kolom";
$GLOBALS['strCustomColumnName'] = "Nama kolom khusus";
$GLOBALS['strColumnRank'] = "Peringkat kolom";

// Long names
$GLOBALS['strRevenue'] = "Pendapatan";
$GLOBALS['strNumberOfItems'] = "Jumlah barang";
$GLOBALS['strRevenueCPC'] = "BPK Revenue";
$GLOBALS['strERPM'] = "CPM";
$GLOBALS['strERPC'] = "CPC";
$GLOBALS['strERPS'] = "CPM";
$GLOBALS['strEIPM'] = "CPM";
$GLOBALS['strEIPC'] = "CPC";
$GLOBALS['strEIPS'] = "CPM";
$GLOBALS['strECPM'] = "CPM";
$GLOBALS['strECPC'] = "CPC";
$GLOBALS['strECPS'] = "CPM";
$GLOBALS['strPendingConversions'] = "Konversi tertunda";
$GLOBALS['strImpressionSR'] = "AdView";
$GLOBALS['strClickSR'] = "Klik SR";

// Short names
$GLOBALS['strRevenue_short'] = "Putaran.";
$GLOBALS['strBasketValue_short'] = "BV";
$GLOBALS['strNumberOfItems_short'] = "Angka Item";
$GLOBALS['strRevenueCPC_short'] = "Wahyu BPK";
$GLOBALS['strERPM_short'] = "CPM";
$GLOBALS['strERPC_short'] = "CPC";
$GLOBALS['strERPS_short'] = "CPM";
$GLOBALS['strEIPM_short'] = "CPM";
$GLOBALS['strEIPC_short'] = "CPC";
$GLOBALS['strEIPS_short'] = "CPM";
$GLOBALS['strECPM_short'] = "CPM";
$GLOBALS['strECPC_short'] = "CPC";
$GLOBALS['strECPS_short'] = "CPM";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strRequests_short'] = "Req.";
$GLOBALS['strImpressions_short'] = "Impr.";
$GLOBALS['strClicks_short'] = "AdClick";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "Konv.";
$GLOBALS['strPendingConversions_short'] = "Pendampingan.";
$GLOBALS['strImpressionSR_short'] = "Impr. SR";
$GLOBALS['strClickSR_short'] = "Klik SR";

// Global Settings
$GLOBALS['strConfiguration'] = "Konfigurasi";
$GLOBALS['strGlobalSettings'] = "Penyetelan Umum";
$GLOBALS['strGeneralSettings'] = "Penyetelan Umum";
$GLOBALS['strMainSettings'] = "Penyetelan Utama";
$GLOBALS['strPlugins'] = "Plugin";
$GLOBALS['strChooseSection'] = 'Pilih bagian';

// Product Updates
$GLOBALS['strProductUpdates'] = "Update Produk";
$GLOBALS['strViewPastUpdates'] = "Atur seluruh Update dan Backup yang pernah dilakukan";
$GLOBALS['strFromVersion'] = "Dari versi";
$GLOBALS['strToVersion'] = "Ke versi";
$GLOBALS['strToggleDataBackupDetails'] = "Toggle data backup details";
$GLOBALS['strClickViewBackupDetails'] = "klik untuk melihat rincian cadangan";
$GLOBALS['strClickHideBackupDetails'] = "klik untuk menyembunyikan rincian cadangan";
$GLOBALS['strShowBackupDetails'] = "Tampilkan rincian backup data";
$GLOBALS['strHideBackupDetails'] = "Sembunyikan rincian backup data";
$GLOBALS['strBackupDeleteConfirm'] = "Apakah Anda benar-benar ingin menghapus semua backup yang dibuat dari upgrade ini?";
$GLOBALS['strDeleteArtifacts'] = "Hapus Artefak";
$GLOBALS['strArtifacts'] = "Artefak";
$GLOBALS['strBackupDbTables'] = "Backup tabel database";
$GLOBALS['strLogFiles'] = "Berkas log";
$GLOBALS['strConfigBackups'] = "Konf backup";
$GLOBALS['strUpdatedDbVersionStamp'] = "Stempel versi database yang diperbarui";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "UPGRADE LENGKAP";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "UPGRADE GAGAL";

// Agency
$GLOBALS['strAgencyManagement'] = "Agency Management";
$GLOBALS['strAgency'] = "Agency";
$GLOBALS['strAddAgency'] = "Add new agency";
$GLOBALS['strAddAgency_Key'] = "Tambah zona <u>b</u>aru";
$GLOBALS['strTotalAgencies'] = "Total agencies";
$GLOBALS['strAgencyProperties'] = "Agency properties";
$GLOBALS['strNoAgencies'] = "Tidak ada zona yang ditentukan";
$GLOBALS['strConfirmDeleteAgency'] = "Apakah benar Anda ingin menghapus zona ini?";
$GLOBALS['strHideInactiveAgencies'] = "Hide inactive agencies";
$GLOBALS['strInactiveAgenciesHidden'] = "zona yang tidak aktif tersembunyi";
$GLOBALS['strSwitchAccount'] = "Beralih ke akun ini";
$GLOBALS['strAgencyStatusInactive'] = "aktif";

// Channels
$GLOBALS['strChannel'] = "Set Aturan Pengiriman";
$GLOBALS['strChannels'] = "Delivery Rule Sets";
$GLOBALS['strChannelManagement'] = "Manajemen Pengaturan Aturan Pengiriman";
$GLOBALS['strAddNewChannel'] = "Tambahkan Set Aturan Pengiriman baru";
$GLOBALS['strAddNewChannel_Key'] = "Tambahkan <u>n</u>ew Aturan Pengiriman";
$GLOBALS['strChannelToWebsite'] = "Semua penerbit";
$GLOBALS['strNoChannels'] = "Saat ini tidak ada aturan pengiriman ditetapkan";
$GLOBALS['strNoChannelsAddWebsite'] = "Saat ini tidak ada aturan pengiriman ditetapkan, karena tidak ada situs web. Untuk membuat aturan pengiriman, <a href='affiliate-edit.php'>menambahkan situs web baru</a> terlebih dahulu.";
$GLOBALS['strEditChannelLimitations'] = "Edit aturan pengiriman untuk aturan pengiriman";
$GLOBALS['strChannelProperties'] = "Aturan Pengiriman Set Properties";
$GLOBALS['strChannelLimitations'] = "Pilihan Penyampaian";
$GLOBALS['strConfirmDeleteChannel'] = "Apakah Anda benar-benar ingin menghapus aturan pengiriman ini?";
$GLOBALS['strConfirmDeleteChannels'] = "Apakah Anda benar-benar ingin menghapus kumpulan aturan pengiriman yang dipilih?";
$GLOBALS['strChannelsOfWebsite'] = 'dalam'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "Nama dari Variabel";
$GLOBALS['strVariableDescription'] = "Deskripsi";
$GLOBALS['strVariableDataType'] = "Jenis Data";
$GLOBALS['strVariablePurpose'] = "Guna";
$GLOBALS['strGeneric'] = "Generik";
$GLOBALS['strBasketValue'] = "Nilai keranjang";
$GLOBALS['strNumItems'] = "Jumlah barang";
$GLOBALS['strVariableIsUnique'] = "Dedup konversi?";
$GLOBALS['strNumber'] = "Nomor";
$GLOBALS['strString'] = "Perangkaian";
$GLOBALS['strTrackFollowingVars'] = "Lacak variabel yang berikut ini";
$GLOBALS['strAddVariable'] = "Tambahkan Variabel";
$GLOBALS['strNoVarsToTrack'] = "Tidak ada variabel untuk dilacak.";
$GLOBALS['strVariableRejectEmpty'] = "Tolak bilamana kosong?";
$GLOBALS['strTrackingSettings'] = "Pengaturan Pelacak";
$GLOBALS['strTrackerType'] = "Jenis Pelacak";
$GLOBALS['strTrackerTypeJS'] = "Lacak variabel JavaScript";
$GLOBALS['strTrackerTypeDefault'] = "Melacak variabel JavaScript (kompatibel mundur, lolos diperlukan)";
$GLOBALS['strTrackerTypeDOM'] = "Melacak elemen HTML menggunakan DOM";
$GLOBALS['strTrackerTypeCustom'] = "Kode JS khusus";
$GLOBALS['strVariableCode'] = "Kode pelacak berbasis Javascript";

// Password recovery
$GLOBALS['strForgotPassword'] = "Lupa kata sandi Anda?";
$GLOBALS['strEmailRequired'] = "Pengisian alamat E-mail diwajibkan!";
$GLOBALS['strPwdRecEnterEmail'] = "Silakan masukkan alamat E-Mail Anda dibawah ini";
$GLOBALS['strPwdRecEnterPassword'] = "Silakan masukkan alamat E-Mail baru yang terhubung dengan kata sandi Anda dibawah ini";
$GLOBALS['strProceed'] = "Lanjut &gt;";

// Password recovery - Default


// Password recovery - Welcome email

// Password recovery - Hash update

// Password reset warning

// Audit
$GLOBALS['strAdditionalItems'] = "dan item tambahan";
$GLOBALS['strFor'] = "untuk";
$GLOBALS['strHas'] = "telah";
$GLOBALS['strBinaryData'] = "Data biner";
$GLOBALS['strAuditTrailDisabled'] = "Jejak Audit telah dinonaktifkan oleh administrator sistem. Tidak ada acara lebih lanjut yang dicatat dan ditampilkan di daftar Audit Trail.";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "Tidak ada aktivitas pengguna yang tercatat selama jangka waktu yang telah Anda pilih.";
$GLOBALS['strAuditTrail'] = "Jejak audit";
$GLOBALS['strAuditTrailSetup'] = "Setup Audit Trail hari ini";
$GLOBALS['strAuditTrailGoTo'] = "Buka halaman Audit Trail";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Jejak Audit memungkinkan Anda melihat siapa yang melakukan apa dan kapan. Atau dengan kata lain, itu melacak perubahan sistem di dalamnya{$PRODUCT_NAME}</li>
        <li>Anda melihat pesan ini, karena Anda belum mengaktifkan Jejak Audit </li>
        <li>Tertarik belajar lebih banyak? Baca <a<a href='{$PRODUCT_DOCSURL}/admin/settings/auditTrail' class='site-link' target='help' >Dokumentasi Audit Trail </a></li>";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Buka halaman Kampanye";
$GLOBALS['strCampaignSetUp'] = "Buat Kampanye hari ini";
$GLOBALS['strCampaignNoRecords'] = "<li>Kampanye memungkinkan Anda mengelompokkan sejumlah iklan spanduk, dari ukuran apa pun, yang berbagi persyaratan periklanan umum </li>
        <li>Hemat waktu dengan mengelompokkan spanduk dalam kampanye dan tidak lagi menentukan setelan pengiriman untuk setiap iklan secara terpisah </li>
        <li>Periksa<a class='site-link' target='help' href='{$PRODUCT_DOCSURL}/user/inventory/advertisersAndCampaigns/campaigns'>Dokumentasi kampanye </a>! </li>";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>Tidak ada aktivitas kampanye yang ditampilkan. </li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "Tidak ada kampanye yang dimulai atau selesai selama jangka waktu yang telah Anda pilih";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>Untuk melihat kampanye yang telah dimulai atau selesai selama jangka waktu yang telah Anda pilih, Jejak Audit harus diaktifkan </li>
        <li>Anda melihat pesan ini karena Anda tidak mengaktifkan Jejak Audit </li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Aktifkan Trail Audit untuk mulai melihat Kampanye";

$GLOBALS['strUnsavedChanges'] = "Anda memiliki perubahan yang belum disimpan di halaman ini, pastikan Anda menekan &quot; Simpan Perubahan &quot; saat selesai";
$GLOBALS['strDeliveryLimitationsDisagree'] = "PERINGATAN: Aturan pengiriman dalam cache <strong> JANGAN SETUJU </strong> dengan aturan pengiriman yang ditunjukkan di bawah ini <br/> Tolong tekan simpan perubahan untuk memperbarui aturan pengiriman tembolok";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Beberapa peraturan pengiriman melaporkan nilai yang salah:";

//confirmation messages
$GLOBALS['strYouAreNowWorkingAsX'] = "Anda sekarang bekerja sebagai <b>%s</b>";
$GLOBALS['strYouDontHaveAccess'] = "Anda tidak memiliki akses ke halaman itu. Anda telah diarahkan kembali.";

$GLOBALS['strAdvertiserHasBeenAdded'] = "Pemasang iklan <a href='%s'>%s</a>telah ditambahkan,<a href='%s'>tambahkan kampanye</a>";
$GLOBALS['strAdvertiserHasBeenUpdated'] = "Pemasang iklan <a href='%s'>%s</a>telah diperbarui";
$GLOBALS['strAdvertiserHasBeenDeleted'] = "Pemasang iklan <b>%s</b> sudah dihapus";
$GLOBALS['strAdvertisersHaveBeenDeleted'] = "Semua pengiklan terpilih telah dihapus";

$GLOBALS['strTrackerHasBeenAdded'] = "Pelacak <a href='%s'>%s</a> telah ditambahkan";
$GLOBALS['strTrackerHasBeenUpdated'] = "Pelacak <a href='%s'>%s</a> telah diperbarui";
$GLOBALS['strTrackerVarsHaveBeenUpdated'] = "Variabel pelacak <a href='%s'>%s</a> telah diperbarui";
$GLOBALS['strTrackerCampaignsHaveBeenUpdated'] = "Kampanye pelacak yang dilacak <a href='%s'>%s</a> telah diperbarui";
$GLOBALS['strTrackerAppendHasBeenUpdated'] = "Tambahkan kode pelacak pelacak <a href='%s'>%s</a> telah diperbarui";
$GLOBALS['strTrackerHasBeenDeleted'] = "Tracker <b>%s</b> telah dihapus";
$GLOBALS['strTrackersHaveBeenDeleted'] = "Semua pelacak terpilih telah dihapus";
$GLOBALS['strTrackerHasBeenDuplicated'] = "Tracker <a href='%s'>%s</a> telah disalin ke <a href='%s'>%s</a>";
$GLOBALS['strTrackerHasBeenMoved'] = "Pelacak <b>%s</b> telah dipindahkan ke pengiklan <b>%s</b>";

$GLOBALS['strCampaignHasBeenAdded'] = "Kampanye <a href='%s'>%s</a> telah ditambahkan, <a href='%s'>tambahkan spanduk</a>";
$GLOBALS['strCampaignHasBeenUpdated'] = "Kampanye <a href='%s'>%s</a>telah diperbarui";
$GLOBALS['strCampaignTrackersHaveBeenUpdated'] = "Pelacak penelusuran kampanye <a href='%s'>%s</a> telah diperbarui";
$GLOBALS['strCampaignHasBeenDeleted'] = "Kampanye <b>%s</b> telah dihapus";
$GLOBALS['strCampaignsHaveBeenDeleted'] = "Semua kampanye terpilih telah dihapus";
$GLOBALS['strCampaignHasBeenDuplicated'] = "Kampanye <a href='%s'>%s</a> telah disalin ke <a href='%s'>%s</a>";
$GLOBALS['strCampaignHasBeenMoved'] = "Pelacak <b>%s</b> telah dipindahkan ke pengiklan <b>%s</b>";

$GLOBALS['strBannerHasBeenAdded'] = "Spanduk <a href='%s'>%s</a> telah ditambahkan";
$GLOBALS['strBannerHasBeenUpdated'] = "Spanduk <a href='%s'>%s</a> telah diperbarui";
$GLOBALS['strBannerAdvancedHasBeenUpdated'] = "Setelan lanjutan untuk spanduk <a href='%s'>%s</a> telah diperbarui";
$GLOBALS['strBannerAclHasBeenUpdated'] = "Pilihan pengiriman untuk spanduk <a href='%s'>%s</a> telah diperbarui";
$GLOBALS['strBannerAclHasBeenAppliedTo'] = "Opsi pengiriman untuk spanduk <a href='%s'>%s</a> telah diterapkan ke %d spanduk";
$GLOBALS['strBannerHasBeenDeleted'] = "Spanduk <b>%s</b> sudah dihapus";
$GLOBALS['strBannersHaveBeenDeleted'] = "Semua spanduk yang dipilih telah dihapus";
$GLOBALS['strBannerHasBeenDuplicated'] = "Spanduk <a href='%s'>%s</a> telah disalin kes<a href='%s'>%s</a>";
$GLOBALS['strBannerHasBeenMoved'] = "Spanduk <b>%s</b> telah dipindahkan ke kampanye <b>%s</b>";
$GLOBALS['strBannerHasBeenActivated'] = "Banner <a href='%s'>%s</a> telah diaktifkan";
$GLOBALS['strBannerHasBeenDeactivated'] = "Banner <a href='%s'>%s</a> telah dinonaktifkan";

$GLOBALS['strXZonesLinked'] = "<b>%s</b>zona(s) yang terkait";
$GLOBALS['strXZonesUnlinked'] = "<b>%s</b>zona(s) yang tidak terpaut";

$GLOBALS['strWebsiteHasBeenAdded'] = "Website <a href='%s'>%s</a> telah ditambahkan, <a href='%s'>tambahkan zona</a>";
$GLOBALS['strWebsiteHasBeenUpdated'] = "Situs web <a href='%s'>%s</a> telah diperbarui";
$GLOBALS['strWebsiteHasBeenDeleted'] = "Situs web <b>%s</b> sudah dihapus";
$GLOBALS['strWebsitesHaveBeenDeleted'] = "Semua situs web yang dipilih telah dihapus";

$GLOBALS['strZoneHasBeenAdded'] = "Zona <a href='%s'>%s</a> telah ditambahkan";
$GLOBALS['strZoneHasBeenUpdated'] = "Zona <a href='%s'>%s</a> telah diperbarui";
$GLOBALS['strZoneAdvancedHasBeenUpdated'] = "Setelan lanjutan untuk zona <a href='%s'>%s</a> telah diperbarui";
$GLOBALS['strZoneHasBeenDeleted'] = "Zana <b>%s</b> sudah dihapus";
$GLOBALS['strZonesHaveBeenDeleted'] = "Semua zona terpilih telah dihapus";
$GLOBALS['strZoneHasBeenDuplicated'] = "Zona <a href='%s'>%s</a> telah disalin ke <a href='%s'>%s</a>";
$GLOBALS['strZoneHasBeenMoved'] = "Zona <<b>%s</b> telah dipindahkan ke situs web <b>%s</b>";
$GLOBALS['strZoneLinkedBanner'] = "Spanduk telah dikaitkan dengan zona <a href='%s'>%s</a>";
$GLOBALS['strZoneLinkedCampaign'] = "Kampanye telah dikaitkan dengan zona <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedBanner'] = "Spanduk telah dibatalkan dari zona <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedCampaign'] = "Kampanye telah dibatalkan dari zona <a href='%s'>%s</a>";

$GLOBALS['strChannelHasBeenAdded'] = "Aturan pengiriman ditetapkan <a href='%s'>%s</a> telah ditambahkan. <a href='%s'>Tetapkan aturan pengiriman.</a>";
$GLOBALS['strChannelHasBeenUpdated'] = "Aturan pengiriman ditetapkan <a href='%s'>%s</a> telah diperbarui";
$GLOBALS['strChannelHasBeenDeleted'] = "Aturan pengiriman ditetapkan <b>%s</b> sudah dihapus";
$GLOBALS['strChannelsHaveBeenDeleted'] = "Semua kumpulan aturan pengiriman yang dipilih telah dihapus";
$GLOBALS['strChannelHasBeenDuplicated'] = "Aturan pengiriman ditetapkan <a href='%s'>%s</a> telah disalin ke <a href='%s'>%s</a>";

$GLOBALS['strUserPreferencesUpdated'] = "Preferensi <b>%s</b> Anda telah diperbarui";
$GLOBALS['strEmailChanged'] = "E-mail Anda telah diubah";
$GLOBALS['strPasswordChanged'] = "Kata sandi Anda telah diubah";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "<b>%s</b> telah diperbarui";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "<b>%s</b> telah diperbarui";
$GLOBALS['strTZPreferencesWarning'] = "Namun, aktivasi dan kadaluarsa kampanye tidak diperbarui, atau aturan pengiriman spanduk berbasis waktu.<br />Anda perlu memperbaruinya secara manual jika anda ingin mereka menggunakan zona waktu yang baru";

// Report error messages
$GLOBALS['strReportErrorMissingSheets'] = "Tidak ada lembar kerja yang dipilih untuk dilaporkan";
$GLOBALS['strReportErrorUnknownCode'] = "Kode kesalahan tidak diketahui #";

/* ------------------------------------------------------- */
/* Password strength                                       */
/* ------------------------------------------------------- */


if (!isset($GLOBALS['strPasswordScore'])) {
    $GLOBALS['strPasswordScore'] = [];
}



/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyUp'] = "u";
$GLOBALS['keyNextItem'] = ",";
$GLOBALS['keyPreviousItem'] = ".";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch'] = "s";
$GLOBALS['keyCollapseAll'] = "c";
$GLOBALS['keyExpandAll'] = "e";
$GLOBALS['keyAddNew'] = "n";
$GLOBALS['keyNext'] = "n";
$GLOBALS['keyPrevious'] = "p";
$GLOBALS['keyLinkUser'] = "u";
