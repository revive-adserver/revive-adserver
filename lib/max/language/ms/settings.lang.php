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
$GLOBALS['strInstall'] = "Pasang";
$GLOBALS['strDatabaseSettings'] = "Konfigurasi Pengkalan Data";
$GLOBALS['strAdminSettings'] = "Konfigurasi Pentadbir";
$GLOBALS['strAdminAccount'] = "Akaun Pentadbir";
$GLOBALS['strAdvancedSettings'] = "Konfigurasi yang lebih mendalam";
$GLOBALS['strWarning'] = "Amaran";
$GLOBALS['strBtnContinue'] = "Seterusnya »";
$GLOBALS['strBtnRecover'] = "Pulihkan »";
$GLOBALS['strBtnStartAgain'] = "Mulakan pembaharuan semula »";
$GLOBALS['strBtnGoBack'] = "« Kembali";
$GLOBALS['strBtnAgree'] = "Saya Setuju »";
$GLOBALS['strBtnRetry'] = "Cuba lagi";
$GLOBALS['strWarningRegisterArgcArv'] = "Konfigurasi PHP bagi pembolehubah register_argc_argv perlu diubah kepada on untuk membolehkan proses pemulihan dan pemantauan dijalankan dari command line.";


$GLOBALS['strRecoveryRequiredTitle'] = "Cubaan pembaharuan anda yang terdahulu tidak berjaya";
$GLOBALS['strRecoveryRequired'] = "Terdapat kesilapan semasa memproses pembaharuan anda terdahulu dan {$PRODUCT_NAME} mesti mencuba untuk memulihkan proses pembaharuan itu. Sila klik butang Pulih dibawah";

$GLOBALS['strOaUpToDate'] = "Pengkalan data {$PRODUCT_NAME} anda dan juga struktur failnya, adalah versi terkini, maka dengan ini tiada pembaharuan diperlukan. Sila klik Seterusnya untuk ke panel pentadbiran OpenX.";
$GLOBALS['strOaUpToDateCantRemove'] = "Amaran: fail Pembaharuan masih lagi terdapat didalam direktori var anda. Kami tidak dapat memadamkan fail ini disebabkan kekurangan hak keatasnya. Sila padamkan fail ini sendiri.";
$GLOBALS['strRemoveUpgradeFile'] = "Anda perlu memadamkan fail pembaharuan yang terdapat didalam direktori var";



$GLOBALS['strAdminUrlPrefix'] = "URL sistem muka pentadbir";
$GLOBALS['strDeliveryUrlPrefix'] = "Enjin Penghantaran";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "Enjin Penghantaran";
$GLOBALS['strImagesUrlPrefix'] = "URL stor imej";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL (SSL) stor imej";



/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Pilih bahagian";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons. " .
    "If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues. " .
    "If you want to secure your system, you need to lock the configuration file for this installation.";

// Configuration Settings

// Administrator Settings
$GLOBALS['strAdministratorSettings'] = "Konfigurasi Pentadbir";
$GLOBALS['strAdminUsername'] = "Kata nama Pentadbir";
$GLOBALS['strAdminPassword'] = "Kata Laluan Pentadbir";
$GLOBALS['strInvalidUsername'] = "Kata nama tidak sah";
$GLOBALS['strBasicInformation'] = "Maklumat Asas";
$GLOBALS['strAdminFullName'] = "Nama penuh Pentadbir";
$GLOBALS['strAdminEmail'] = "Alamat emel Pentadbir";
$GLOBALS['strAdministratorEmail'] = "Alamat emel Pentadbir";
$GLOBALS['strCompanyName'] = "Nama Syarikat";
$GLOBALS['strNovice'] = "Tindakan untuk memadam memerlukan maklum balas diatas tujuan keselamatan untuk mengelakkan kesilapan";
$GLOBALS['strUserlogEmail'] = "Log kesemua mesej emel keluar";
$GLOBALS['strTimezone'] = "Zon Waktu";
$GLOBALS['strTimezoneEstimated'] = "Zon waktu anggaran";
$GLOBALS['strTimezoneGuessedValue'] = "Zon waktu server tidak disetkan dengan tepat di PHP";
$GLOBALS['strTimezoneDocumentation'] = "Dokumentasi";


// Database Settings
$GLOBALS['strDatabaseSettings'] = "Konfigurasi Pengkalan Data";
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



// Email Settings

// Audit Trail Settings

// Debug Logging Settings
$GLOBALS['strProduction'] = "Server Produksi";
$GLOBALS['strDebugTypeSql'] = "Pengkalan Data SQL";

// Delivery Settings
$GLOBALS['strDeliverySettings'] = "Ciri-ciri penghantaran";
$GLOBALS['strWebPath'] = "$PRODUCT_NAME Server Access Paths";
$GLOBALS['strImageStore'] = "Folder imej-imej";
$GLOBALS['strTypeWebMode'] = "Cara menyimpan";
$GLOBALS['strTypeWebModeLocal'] = "Direktori Tempatan";
$GLOBALS['strTypeWebModeFtp'] = "FTP Server Luar";
$GLOBALS['strTypeWebDir'] = "Direktori Tempatan";
$GLOBALS['strTypeFTPUsername'] = "Log Masuk";
$GLOBALS['strTypeFTPPassword'] = "Kata Laluan";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Maklumat iklan";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Imej Iklan";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Log Iklan";




// General Settings

// Geotargeting Settings

// Interface Settings
$GLOBALS['strInventory'] = "Inventori";


// CSV Import Settings

/**
 * @todo remove strBannerSettings if banner is only configurable as a preference
 *       rename // Banner Settings to  // Banner Preferences
 */
// Invocation Settings

// Banner Delivery Settings

// Banner Logging Settings

// Banner Storage Settings

// Campaign ECPM settings

// Statistics & Maintenance Settings

// UI Settings




// Regenerate Platfor Hash script

// Plugin Settings

/* ------------------------------------------------------- */
/* Unknown (unused?) translations                        */
/* ------------------------------------------------------- */


