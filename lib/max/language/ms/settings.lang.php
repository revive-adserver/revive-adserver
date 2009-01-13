<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$Id: translation.php 28570 2008-11-06 16:21:37Z chris.nutting $
*/



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strInventory'] = "Inventori";
$GLOBALS['strBasicInformation'] = "Maklumat Asas";
$GLOBALS['strWarning'] = "Amaran";
$GLOBALS['strTypeFTPUsername'] = "Log Masuk";
$GLOBALS['strTypeFTPPassword'] = "Kata Laluan";
$GLOBALS['strAdminSettings'] = "Konfigurasi Pentadbir";
$GLOBALS['strAdministratorSettings'] = "Konfigurasi Pentadbir";
$GLOBALS['strChooseSection'] = "Pilih bahagian";
$GLOBALS['strInstall'] = "Pasang";
$GLOBALS['strLanguageSelection'] = "Pilihan Bahasa";
$GLOBALS['strDatabaseSettings'] = "Konfigurasi Pengkalan Data";
$GLOBALS['strAdminAccount'] = "Akaun Pentadbir";
$GLOBALS['strAdvancedSettings'] = "Konfigurasi yang lebih mendalam";
$GLOBALS['strSpecifySyncSettings'] = "Konfigurasi Sikronisasi";
$GLOBALS['strOpenadsIdYour'] = "OpenX ID anda";
$GLOBALS['strOpenadsIdSettings'] = "Konfigurasi OpenX ID";
$GLOBALS['strBtnContinue'] = "Seterusnya »";
$GLOBALS['strBtnRecover'] = "Pulihkan »";
$GLOBALS['strBtnStartAgain'] = "Mulakan pembaharuan semula »";
$GLOBALS['strBtnGoBack'] = "« Kembali";
$GLOBALS['strBtnAgree'] = "Saya Setuju »";
$GLOBALS['strBtnRetry'] = "Cuba lagi";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Sila perbetulkan semua kesilapan sebelum meneruskan proses.";
$GLOBALS['strWarningRegisterArgcArv'] = "Konfigurasi PHP bagi pembolehubah register_argc_argv perlu diubah kepada on untuk membolehkan proses pemulihan dan pemantauan dijalankan dari command line.";
$GLOBALS['strRecoveryRequiredTitle'] = "Cubaan pembaharuan anda yang terdahulu tidak berjaya";
$GLOBALS['strRecoveryRequired'] = "Terdapat kesilapan semasa memproses pembaharuan anda terdahulu dan ".MAX_PRODUCT_NAME." mesti mencuba untuk memulihkan proses pembaharuan itu. Sila klik butang Pulih dibawah";
$GLOBALS['strDbSetupTitle'] = "Konfigurasi Pengkalan Data";
$GLOBALS['strOaUpToDate'] = "Pengkalan data ".MAX_PRODUCT_NAME." anda dan juga struktur failnya, adalah versi terkini, maka dengan ini tiada pembaharuan diperlukan. Sila klik Seterusnya untuk ke panel pentadbiran OpenX.";
$GLOBALS['strOaUpToDateCantRemove'] = "Amaran: fail Pembaharuan masih lagi terdapat didalam direktori var anda. Kami tidak dapat memadamkan fail ini disebabkan kekurangan hak keatasnya. Sila padamkan fail ini sendiri.";
$GLOBALS['strRemoveUpgradeFile'] = "Anda perlu memadamkan fail pembaharuan yang terdapat didalam direktori var";
$GLOBALS['strSystemCheck'] = "Pemeriksaan sistem";
$GLOBALS['strAdminUrlPrefix'] = "URL sistem muka pentadbir";
$GLOBALS['strDeliveryUrlPrefix'] = "Enjin Penghantaran";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "Enjin Penghantaran";
$GLOBALS['strImagesUrlPrefix'] = "URL stor imej";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL (SSL) stor imej";
$GLOBALS['strAdminUsername'] = "Kata nama Pentadbir";
$GLOBALS['strAdminPassword'] = "Kata Laluan Pentadbir";
$GLOBALS['strInvalidUsername'] = "Kata nama tidak sah";
$GLOBALS['strAdminFullName'] = "Nama penuh Pentadbir";
$GLOBALS['strAdminEmail'] = "Alamat emel Pentadbir";
$GLOBALS['strAdministratorEmail'] = "Alamat emel Pentadbir";
$GLOBALS['strCompanyName'] = "Nama Syarikat";
$GLOBALS['strUserlogEmail'] = "Log kesemua mesej emel keluar";
$GLOBALS['strTimezone'] = "Zon Waktu";
$GLOBALS['strTimezoneEstimated'] = "Zon waktu anggaran";
$GLOBALS['strTimezoneGuessedValue'] = "Zon waktu server tidak disetkan dengan tepat di PHP";
$GLOBALS['strTimezoneDocumentation'] = "Dokumentasi";
$GLOBALS['strLoginSettingsTitle'] = "Login Pentadbir";
$GLOBALS['strDatabaseServer'] = "Ciri-ciri global server pengkalan data";
$GLOBALS['strDbType'] = "Jenis pengkalan data";
$GLOBALS['strDbHost'] = "Nama host pengkalan data";
$GLOBALS['strDbPort'] = "Nombor port pengkalan data";
$GLOBALS['strDbUser'] = "Nama pengguna pengkalan data";
$GLOBALS['strDbPassword'] = "Kata laluan pengkalan data";
$GLOBALS['strDbName'] = "Nama pengkalan data";
$GLOBALS['strDatabaseOptimalisations'] = "Ciri-ciri untuk mengoptimumkan pengkalan data";
$GLOBALS['strPersistentConnections'] = "Gunakan hubungan yang kekal";
$GLOBALS['strCantConnectToDb'] = "Tidak dapat berhubung dengan pengkalan data";
$GLOBALS['strDemoDataInstall'] = "Masukkan data demo";
$GLOBALS['strProduction'] = "Server Produksi";
$GLOBALS['strDebugTypeSql'] = "Pengkalan Data SQL";
$GLOBALS['strDeliverySettings'] = "Ciri-ciri penghantaran";
$GLOBALS['strImageStore'] = "Folder imej-imej";
$GLOBALS['strTypeWebMode'] = "Cara menyimpan";
$GLOBALS['strTypeWebModeLocal'] = "Direktori Tempatan";
$GLOBALS['strTypeWebDir'] = "Direktori Tempatan";
$GLOBALS['strTypeWebModeFtp'] = "FTP Server Luar";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Maklumat iklan";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Imej Iklan";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Log Iklan";
$GLOBALS['strNovice'] = "Tindakan untuk memadam memerlukan maklum balas diatas tujuan keselamatan untuk mengelakkan kesilapan";
?>