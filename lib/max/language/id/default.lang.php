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
$GLOBALS['strUserLinkedToAccount'] = "Pengguna telah ditambahkan ke akun";
$GLOBALS['strUserAccountUpdated'] = "Akun pengguna diperbarui";
$GLOBALS['strUserUnlinkedFromAccount'] = "Pengguna telah dihapus dari akun";
$GLOBALS['strUserWasDeleted'] = "Pengguna telah dihapus";
$GLOBALS['strUserNotLinkedWithAccount'] = "Pengguna tersebut tidak terkait dengan akun";
$GLOBALS['strCantDeleteOneAdminUser'] = "Anda tidak dapat menghapus pengguna. Setidaknya satu pengguna perlu dihubungkan dengan akun admin.";
$GLOBALS['strLinkUserHelpUser'] = "Nama Pengguna";
$GLOBALS['strLinkUserHelpEmail'] = "alamat email";
$GLOBALS['strLastLoggedIn'] = "Terakhir masuk";

// Login & Permissions
$GLOBALS['strUserProperties'] = "Properties dari Banner";
$GLOBALS['strAuthentification'] = "Autentifikasi";
$GLOBALS['strWelcomeTo'] = "Selamat Datang di";
$GLOBALS['strEnterUsername'] = "Silakan masukan Nama dan Kata Sandi Anda untuk Login";
$GLOBALS['strEnterBoth'] = "Silakan masukan Nama <i>dan</i> Kata Sandi";
$GLOBALS['strEnableCookies'] = "Anda harus mengaktifkan cookies sebelum bisa menggunakannya {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "Kesalahan cookie sesi, masuk lagi";
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
$GLOBALS['strNoAdvertiser'] = "Pengiklan pilihan tidak ada. Coba <a href='{link}'>link</a> ini";

// General advertising
$GLOBALS['strRequests'] = "Permintaan";
$GLOBALS['strImpressions'] = "Kesan";
$GLOBALS['strClicks'] = "AdClick";
$GLOBALS['strConversions'] = "Konversi";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "Jumlah AdClick";
$GLOBALS['strTotalConversions'] = "Jumlah Konversi";
$GLOBALS['strDateTime'] = "Tanggal Waktu";
$GLOBALS['strTrackerID'] = "ID Pelacak";
$GLOBALS['strTrackerName'] = "Nama Pelacak";
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
$GLOBALS['strFinanceMT'] = "Sewa menyewa bulanan";

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
    $GLOBALS['strDayFullNames'] = array();
}

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = array();
}

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
$GLOBALS['strNoClients'] = "Saat ini tidak ada pengiklan yang ditentukan. Untuk membuat kampanye, <a href='advertiser-edit.php'>tambahkan pengiklan baru</a> terlebih dulu.";
$GLOBALS['strConfirmDeleteClient'] = "Apakah Anda benar ingin hapus Pemasang Iklan yang ini?";
$GLOBALS['strConfirmDeleteClients'] = "Apakah Anda benar ingin hapus Pemasang Iklan yang ini?";
$GLOBALS['strHideInactive'] = "Sembunyikan yang tidak aktif";
$GLOBALS['strInactiveAdvertisersHidden'] = "Pemasang Iklan yang tidak aktif disembunyikan";
$GLOBALS['strAdvertiserSignup'] = "Daftar Pengiklan";
$GLOBALS['strAdvertiserCampaigns'] = "Pemasang Iklan & Kampanye";

// Advertisers properties
$GLOBALS['strContact'] = "Alamat";
$GLOBALS['strEMail'] = "Alamat E-mail";
$GLOBALS['strSendAdvertisingReport'] = "Kirim laporan iklan lewat E-mail";
$GLOBALS['strNoDaysBetweenReports'] = "Jumlah hari antara laporan";
$GLOBALS['strSendDeactivationWarning'] = "Kirim peringatan bila kampanye tidak aktif";
$GLOBALS['strAllowClientModifyBanner'] = "Izinkan pengguna ini untuk merubah banner yang dimiliki";
$GLOBALS['strAllowClientDisableBanner'] = "Izinkan pengguna ini untuk hentikan banner yang dimiliki";
$GLOBALS['strAllowClientActivateBanner'] = "Izinkan pengguna ini untuk aktifkan banner yang dimiliki";
$GLOBALS['strAllowCreateAccounts'] = "Izinkan pengguna ini membuat akun baru";
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
$GLOBALS['strHiddenCampaign'] = "Kampanye";
$GLOBALS['strHiddenAd'] = "Iklan";
$GLOBALS['strHiddenAdvertiser'] = "Pemasang Iklan";
$GLOBALS['strHiddenTracker'] = "Pelacak";
$GLOBALS['strHiddenWebsite'] = "Penerbit";
$GLOBALS['strHiddenZone'] = "Zona";
$GLOBALS['strCampaignDelivery'] = "Pelayanan Kampanye";
$GLOBALS['strCompanionPositioning'] = "Iklan yang bermitra";
$GLOBALS['strSelectUnselectAll'] = "Pilih / Batalkan Pilihan";

// Campaign-zone linking page


// Campaign properties
$GLOBALS['strDontExpire'] = "Jangan menghembuskan kampanye ini pada tanggal tertentu";
$GLOBALS['strActivateNow'] = "Aktifkan kampanye ini segera";
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
$GLOBALS['strCampaignStatusInactive'] = "aktif";
$GLOBALS['strCampaignStatusPaused'] = "Istirahat";
$GLOBALS['strCampaignStatusRestarted'] = "Restart";
$GLOBALS['strCampaignStatusDeleted'] = "Hapus";
$GLOBALS['strCampaignType'] = "Nama Kampanye";
$GLOBALS['strType'] = "Jenis";
$GLOBALS['strContract'] = "Alamat";
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
$GLOBALS['strRemnantInfo'] = "Jenis kampanye default. Kampanye tersisa memiliki banyak perbedaan
    pilihan pengiriman, dan sebaiknya Anda selalu memiliki setidaknya satu kampanye tersisa yang terkait dengan setiap zona, untuk memastikannya
    selalu ada sesuatu untuk ditunjukkan. Gunakan kampanye Sisa untuk menampilkan spanduk rumah, spanduk iklan-jaringan, atau bahkan
    periklanan langsung yang telah terjual, namun dimana tidak ada persyaratan kinerja time-critical untuk
    kampanye untuk mematuhi.";

// Tracker
$GLOBALS['strTracker'] = "Pelacak";
$GLOBALS['strTrackers'] = "Pelacak";
$GLOBALS['strAddTracker'] = "Tambah pelacak baru";
$GLOBALS['strTrackerForAdvertiser'] = "untuk pengiklan";
$GLOBALS['strNoTrackers'] = "Pada saat ini belum ada pelacak yang ditetapkan";
$GLOBALS['strConfirmDeleteTrackers'] = "Apakah Anda sudah yakin ingin menghapus seluruh pelacak?";
$GLOBALS['strConfirmDeleteTracker'] = "Apakah Anda sudah yakin ingin menghapus seluruh pelacak?";
$GLOBALS['strTrackerProperties'] = "Ciri-ciri dari Pelacak";
$GLOBALS['strDefaultStatus'] = "Keadaan Default";
$GLOBALS['strStatus'] = "Keadaan";
$GLOBALS['strLinkedTrackers'] = "Pelacak yang terikat";
$GLOBALS['strConversionWindow'] = "Pandangan konversi";
$GLOBALS['strUniqueWindow'] = "Window unik";
$GLOBALS['strClick'] = "Klik";
$GLOBALS['strView'] = "Pandangan";
$GLOBALS['strConversionType'] = "Jenis konversi";
$GLOBALS['strLinkCampaignsByDefault'] = "Hubungkan kampanye baru secara Default";
$GLOBALS['strIPAddress'] = "Alamat IP";

// Banners (General)
$GLOBALS['strBanners'] = "Banner";
$GLOBALS['strAddBanner'] = "Tambah banner baru";
$GLOBALS['strAddBanner_Key'] = "Tambah banner <u>b</u>aru";
$GLOBALS['strBannerToCampaign'] = "Kampanye Anda";
$GLOBALS['strShowBanner'] = "Tampilkan banner";
$GLOBALS['strBannerProperties'] = "Properties dari Banner";
$GLOBALS['strNoBanners'] = "Pada saat ini tidak ada banner yang ditentukan";
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

// Banner Preferences

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Silakan pilih jenis banner";
$GLOBALS['strMySQLBanner'] = "Banner lokal (SQL)";
$GLOBALS['strWebBanner'] = "Banner lokal (Webserver)";
$GLOBALS['strURLBanner'] = "Banner eksternal";
$GLOBALS['strHTMLBanner'] = "Banner HTML";
$GLOBALS['strTextBanner'] = "Text ad";
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
$GLOBALS['strAdserverTypeGeneric'] = "Banner HTML Generik";
$GLOBALS['strGenericOutputAdServer'] = "Generik";
$GLOBALS['strSwfTransparency'] = "Background transparan (hanya Flash)";

// Banner (advanced)

// Banner (swf)
$GLOBALS['strCheckSWF'] = "Periksa hard-coded links dalam file Flash";
$GLOBALS['strConvertSWFLinks'] = "Menukarkan links dari Flash";
$GLOBALS['strCompressSWF'] = "Kompres file SWF untuk meng-download lebih cepat (Player Flash 6 dibutuhkan)";
$GLOBALS['strOverwriteSource'] = "Timpah parameter induk";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "Pilihan Penyampaian";
$GLOBALS['strACL'] = "Pilihan Penyampaian";
$GLOBALS['strEqualTo'] = "sama dengan";
$GLOBALS['strDifferentFrom'] = "lain dibandingkan dengan";
$GLOBALS['strGreaterThan'] = "lebih besar daripada";
$GLOBALS['strLessThan'] = "lebih kecil daripada";
$GLOBALS['strAND'] = "DAN";                          // logical operator
$GLOBALS['strOR'] = "ATAU";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Tampilkan banner ini hanya:";
$GLOBALS['strWeekDays'] = "Hari Kerja";
$GLOBALS['strSource'] = "Sumber";

$GLOBALS['strDeliveryCappingReset'] = "Reset hitungan AdViews setelah:";
$GLOBALS['strDeliveryCappingTotal'] = "jumlahnya";
$GLOBALS['strDeliveryCappingSession'] = "per sesi";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['limit'] = "Batasi penampilan banner pada:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['limit'] = "Batasi penampilan kampanye pada:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['limit'] = "Batasi penampilan zona pada:";

// Website
$GLOBALS['strAffiliate'] = "Penerbit";
$GLOBALS['strAffiliates'] = "Halaman web";
$GLOBALS['strAffiliatesAndZones'] = "Halaman web & Zona";
$GLOBALS['strAddNewAffiliate'] = "Tambah halaman web baru";
$GLOBALS['strAffiliateProperties'] = "Properties dari website";
$GLOBALS['strNoAffiliates'] = "Belum ada Penerbit yang ditentukan";
$GLOBALS['strConfirmDeleteAffiliate'] = "Apakah benar Anda ingin menghapus Penerbit ini?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Apakah benar Anda ingin menghapus Penerbit ini?";
$GLOBALS['strInactiveAffiliatesHidden'] = "penerbit yang tidak aktif disembunyikan";
$GLOBALS['strShowParentAffiliates'] = "Tampilkan penerbit induk";
$GLOBALS['strHideParentAffiliates'] = "Sembunyikan penerbit induk";

// Website (properties)
$GLOBALS['strWebsite'] = "Penerbit";
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
$GLOBALS['strZoneProperties'] = "Properties Zona";
$GLOBALS['strZoneHistory'] = "Sejarah Zona";
$GLOBALS['strNoZones'] = "Tidak ada zona yang ditentukan";
$GLOBALS['strConfirmDeleteZone'] = "Apakah benar Anda ingin menghapus zona ini?";
$GLOBALS['strConfirmDeleteZones'] = "Apakah benar Anda ingin menghapus zona ini?";
$GLOBALS['strZoneType'] = "Jenis Zona";
$GLOBALS['strBannerButtonRectangle'] = "Banner, Tombol atau Bujur Sangkar";
$GLOBALS['strInterstitial'] = "Interstitial atau Floating DHTML";
$GLOBALS['strEmailAdZone'] = "Zona Email/Newsletter";
$GLOBALS['strShowMatchingBanners'] = "Tampilkan banner sepadan";
$GLOBALS['strHideMatchingBanners'] = "Sembunyikan banner sepadan";
$GLOBALS['strBannerLinkedAds'] = "Banner yang dihubungkan pada zona";
$GLOBALS['strCampaignLinkedAds'] = "Kampanye yang dihubungkan pada zona";
$GLOBALS['strInactiveZonesHidden'] = "zona yang tidak aktif tersembunyi";


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
$GLOBALS['strStatusDuplicate'] = "Mendobelkan";
$GLOBALS['strConnectionType'] = "Jenis";
$GLOBALS['strShortcutEditStatuses'] = "Edit status";
$GLOBALS['strShortcutShowStatuses'] = "Tampilkan status";

// Statistics
$GLOBALS['strStats'] = "Statistik";
$GLOBALS['strNoStats'] = "Pada saat ini belum ada statistik yang tersedia";
$GLOBALS['strNoStatsForPeriod'] = "Statistik untuk periode %s s/d. %s pada saat ini belum tersedia ";
$GLOBALS['strTotalThisPeriod'] = "Jumlah dalam periode ini";
$GLOBALS['strPublisherDistribution'] = "Distribusi penerbit";
$GLOBALS['strCampaignDistribution'] = "Distribusi kampanye";
$GLOBALS['strViewBreakdown'] = "Tampilkan berdasarkan";
$GLOBALS['strBreakdownByDay'] = "Hari";
$GLOBALS['strBreakdownByWeek'] = "Minggu";
$GLOBALS['strBreakdownByMonth'] = "Satu bulan";
$GLOBALS['strBreakdownByDow'] = "Hari dalam minggu";
$GLOBALS['strBreakdownByHour'] = "Jam";
$GLOBALS['strShowGraphOfStatistics'] = "Tampilkan <u>G</u>rafik Statistik";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>kspor Statistik ke Excel";

// Expiration
$GLOBALS['strNoExpiration'] = "Tanggal masa berlaku tidak ditentukan";
$GLOBALS['strEstimated'] = "Perkiraan habisnya masa berlaku";
$GLOBALS['strCampaignStop'] = "Sejarah Kampanye";

// Reports
$GLOBALS['strPeriod'] = "Periode";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "Semua pemasang iklan";
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


// Errors
$GLOBALS['strNoMatchesFound'] = "Tidak ada sepadan yang ditemukan";
$GLOBALS['strErrorOccurred'] = "Telah terjadi Error";
$GLOBALS['strErrorDBPlain'] = "Telah terjadi Error sewaktu mengakses database";
$GLOBALS['strErrorDBSerious'] = "Terdeteksi masalah serius pada database";
$GLOBALS['strErrorDBCorrupt'] = "Tabel pada database rupanya rusak dan perlu perbaikan. Untuk informasi lebih lanjut tentang caranya memperbaiki tabel yang rusak mohon baca BAB <i>Troubleshooting</i> pada <i>Administrator Guide</i>.";
$GLOBALS['strErrorDBContact'] = "Mohon hubungi Administrator dari server ini dan beritahukan masalah ini.";
$GLOBALS['strUnableToLinkBanner'] = "Gagal menghubungkan banner: ";
$GLOBALS['strUnableToChangeZone'] = "Gagal melakukan perubahan ini disebabkan:";
$GLOBALS['strDatesConflict'] = "tanggal-tanggal berbentrokan dengan:";

//Validation

// Email
$GLOBALS['strSirMadam'] = "Ibu/Bpk";
$GLOBALS['strMailSubject'] = "Laporan untuk Pemasang Iklan";
$GLOBALS['strMailBannerStats'] = "Bersama E-mail ini kami kirimkan data statistik dari iklan banner untuk {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Kampanye diaktifkan";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Kampanye dihentikan";
$GLOBALS['strMailBannerDeactivated'] = "Kampanye yang dibawah ini telah dihentikan berdasarkan";
$GLOBALS['strClientDeactivated'] = "Kampanye ini pada saat sekarang tidak aktif sehubungan";
$GLOBALS['strBeforeActivate'] = "tanggal aktivasi belum tercapai";
$GLOBALS['strAfterExpire'] = "waktu habisnya sudah tercapai";
$GLOBALS['strNoMoreImpressions'] = "tidak ada impresi yang tertinggal";
$GLOBALS['strNoMoreClicks'] = "tidak ada AdKlik yang tertinggal";
$GLOBALS['strWeightIsNull'] = "bobotnya ditetapkan pada angka nol";
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

// Priority
$GLOBALS['strPriority'] = "Prioritas";
$GLOBALS['strSourceEdit'] = "Edit Sumber";

// Preferences
$GLOBALS['strPreferences'] = "Preferensi";

// Long names
$GLOBALS['strERPM'] = "CPM";
$GLOBALS['strERPC'] = "CPC";
$GLOBALS['strERPS'] = "CPM";
$GLOBALS['strEIPM'] = "CPM";
$GLOBALS['strEIPC'] = "CPC";
$GLOBALS['strEIPS'] = "CPM";
$GLOBALS['strECPM'] = "CPM";
$GLOBALS['strECPC'] = "CPC";
$GLOBALS['strECPS'] = "CPM";
$GLOBALS['strImpressionSR'] = "AdView";

// Short names
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
$GLOBALS['strClicks_short'] = "AdClick";

// Global Settings
$GLOBALS['strGlobalSettings'] = "Penyetelan Umum";
$GLOBALS['strGeneralSettings'] = "Penyetelan Umum";
$GLOBALS['strMainSettings'] = "Penyetelan Utama";

// Product Updates
$GLOBALS['strProductUpdates'] = "Update Produk";
$GLOBALS['strViewPastUpdates'] = "Atur seluruh Update dan Backup yang pernah dilakukan";

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

// Channels
$GLOBALS['strChannelToWebsite'] = "Semua penerbit";
$GLOBALS['strChannelLimitations'] = "Pilihan Penyampaian";

// Tracker Variables
$GLOBALS['strVariableName'] = "Nama dari Variabel";
$GLOBALS['strVariableDescription'] = "Deskripsi";
$GLOBALS['strVariableDataType'] = "Jenis Data";
$GLOBALS['strVariablePurpose'] = "Guna";
$GLOBALS['strGeneric'] = "Generik";
$GLOBALS['strNumber'] = "Nomor";
$GLOBALS['strString'] = "Perangkaian";
$GLOBALS['strTrackFollowingVars'] = "Lacak variabel yang berikut ini";
$GLOBALS['strAddVariable'] = "Tambahkan Variabel";
$GLOBALS['strNoVarsToTrack'] = "Tidak ada variabel untuk dilacak.";
$GLOBALS['strVariableRejectEmpty'] = "Tolak bilamana kosong?";
$GLOBALS['strTrackingSettings'] = "Pengaturan Pelacak";
$GLOBALS['strTrackerType'] = "Jenis Pelacak";
$GLOBALS['strTrackerTypeJS'] = "Lacak variabel JavaScript";
$GLOBALS['strVariableCode'] = "Kode pelacak berbasis Javascript";

// Password recovery
$GLOBALS['strForgotPassword'] = "Lupa kata sandi Anda?";
$GLOBALS['strEmailRequired'] = "Pengisian alamat E-mail diwajibkan!";
$GLOBALS['strPwdRecWrongId'] = "ID tidak dikenal";
$GLOBALS['strPwdRecEnterEmail'] = "Silakan masukkan alamat E-Mail Anda dibawah ini";
$GLOBALS['strPwdRecEnterPassword'] = "Silakan masukkan alamat E-Mail baru yang terhubung dengan kata sandi Anda dibawah ini";
$GLOBALS['strProceed'] = "Lanjut &gt;";

// Audit

// Widget - Audit

// Widget - Campaign



//confirmation messages










// Report error messages

/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyNextItem'] = ",";
$GLOBALS['keyPreviousItem'] = ".";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
