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

// Settings help translation strings
$GLOBALS['phpAds_hlp_dbhost'] = "Menentukan nama host dari server database {$phpAds_dbmsname} yang Anda mencoba untuk menyambung.";

$GLOBALS['phpAds_hlp_dbport'] = "Tentukan jumlah pelabuhan {$phpAds_dbmsname} database server yang Anda mencoba untuk menyambung.";

$GLOBALS['phpAds_hlp_dbuser'] = "Tentukan nama pengguna {$PRODUCT_NAME} yang harus gunakan untuk mendapatkan akses ke {$phpAds_dbmsname} database server.";

$GLOBALS['phpAds_hlp_dbpassword'] = "Tentukan password {$PRODUCT_NAME} yang harus menggunakan untuk mendapatkan akses ke {$phpAds_dbmsname} database server.";

$GLOBALS['phpAds_hlp_dbname'] = "Menentukan nama database pada server database yang mana {$PRODUCT_NAME} harus menyimpan datanya. Penting database harus sudah dibuat pada database server. {$PRODUCT_NAME} akan <b>tidak</b> membuat database ini jika tidak ada lagi.";

$GLOBALS['phpAds_hlp_persistent_connections'] = "Penggunaan koneksi terus-menerus dapat mempercepat {$PRODUCT_NAME} jauh dan bahkan dapat menurunkan beban pada server. Ada kelemahan namun, di situs dengan banyak pengunjung beban pada server dapat meningkatkan dan menjadi lebih besar kemudian ketika menggunakan koneksi normal. Apakah Anda harus menggunakan sambungan reguler atau sambungan gigih tergantung pada jumlah pengunjung dan perangkat keras Anda menggunakan. Jika {$PRODUCT_NAME} yang menggunakan terlalu banyak sumber daya, Anda harus mengambil melihat pengaturan ini pertama.";

$GLOBALS['phpAds_hlp_compatibility_mode'] = "Jika Anda mengalami masalah mengintegrasikan {$PRODUCT_NAME} dengan produk memakmurkan pihak lain mungkin membantu untuk mengaktifkan modus kompatibilitas database. Jika Anda menggunakan mode lokal doa dan database Kompatibilitas diaktifkan {$PRODUCT_NAME} harus meninggalkan negara exectly koneksi database yang sama seperti itu sebelum {$PRODUCT_NAME} berlari. Pilihan ini sedikit lebih lambat (hanya sedikit) dan karena itu dimatikan secara default.";

$GLOBALS['phpAds_hlp_table_prefix'] = "Jika database {$PRODUCT_NAME} menggunakan dibagi oleh beberapa perangkat lunak produk, bijaksana untuk menambahkan awalan nama tabel. Jika Anda menggunakan beberapa instalasi dari {$PRODUCT_NAME} pada database yang sama, Anda perlu memastikan bahwa awalan ini unik untuk semua instalasi.";

$GLOBALS['phpAds_hlp_table_type'] = "MySQL mendukung beberapa tabel jenis. Setiap jenis tabel memiliki sifat unik dan beberapa dapat mempercepat {$PRODUCT_NAME} cukup besar. MyISAM default tabel jenis dan tersedia dalam semua instalasi MySQL. Jenis tabel lain mungkin tidak tersedia pada server Anda.";

$GLOBALS['phpAds_hlp_url_prefix'] = "{$PRODUCT_NAME} perlu tahu di mana itu berada di web server untuk bekerja dengan benar. Anda harus menentukan URL untuk direktori mana {$PRODUCT_NAME} terinstal, misalnya: <i>http://www.your-url.com/ads</i>.";

$GLOBALS['phpAds_hlp_ssl_url_prefix'] = "{$PRODUCT_NAME} perlu tahu di mana itu berada di web server untuk bekerja dengan benar. Kadang-kadang awalan SSL berbeda daripada biasa URL awalan. Anda harus menentukan URL untuk direktori mana {$PRODUCT_NAME} terinstal, misalnya: <i>https://www.your-url.com/ads</i>.";









































































