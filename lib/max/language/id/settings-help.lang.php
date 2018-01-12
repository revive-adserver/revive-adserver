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

$GLOBALS['phpAds_hlp_my_header'] = $GLOBALS['phpAds_hlp_my_footer'] = "Anda harus meletakkan di sini jalan ke file header (e.g.: /home/login/www/header.htm) untuk memiliki header dan/atau footer pada setiap halaman di antarmuka admin. Anda bisa meletakkan teks atau html di file ini (jika Anda ingin menggunakan html di salah satu atau kedua file ini tidak menggunakan tag seperti <body> atau <html>).";

$GLOBALS['phpAds_hlp_my_logo'] = "Anda harus meletakkan di sini nama file logo kustom yang ingin Anda tampilkan sebagai pengganti logo default. Logo harus ditempatkan di direktori admin/images sebelum menyetel nama file di sini.";

$GLOBALS['phpAds_hlp_gui_header_foreground_color'] = "Anda harus meletakkan di sini warna kustom yang akan digunakan untuk tab, bilah pencarian, dan beberapa teks tebal.";

$GLOBALS['phpAds_hlp_gui_header_background_color'] = "Anda harus meletakkan di sini warna kustom yang akan digunakan untuk latar belakang header.";

$GLOBALS['phpAds_hlp_gui_header_active_tab_color'] = "Anda harus meletakkan di sini warna kustom yang akan digunakan untuk tab utama yang dipilih saat ini.";

$GLOBALS['phpAds_hlp_gui_header_text_color'] = "Anda harus meletakkan di sini warna kustom yang akan digunakan untuk teks di header.";

$GLOBALS['phpAds_hlp_content_gzip_compression'] = "Dengan mengaktifkan kompresi konten GZIP Anda akan mendapatkan penurunan besar dari data yang dikirim ke browser setiap kali halaman antarmuka administrator dibuka. Untuk mengaktifkan fitur ini, Anda harus memasang ekstensi GZIP.";

$GLOBALS['phpAds_hlp_language'] = "Tetapkan bahasa standar {$PRODUCT_NAME} harus digunakan. Bahasa ini akan digunakan sebagai default untuk admin dan interface pengiklan. Harap diperhatikan: Anda dapat menetapkan bahasa yang berbeda untuk setiap pengiklan dari antarmuka admin dan mengizinkan pengiklan mengubah bahasa mereka sendiri.";

$GLOBALS['phpAds_hlp_name'] = "Tentukan nama yang ingin anda gunakan untuk aplikasi ini. String ini akan ditampilkan di semua halaman di admin dan antarmuka pengiklan. Jika Anda membiarkan setelan ini kosong (default), logo {$PRODUCT_NAME} akan ditampilkan.";

$GLOBALS['phpAds_hlp_company_name'] = "Nama ini digunakan dalam email yang dikirim oleh {$PRODUCT_NAME}.";

$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "{$PRODUCT_NAME} biasanya mendeteksi apakah perpustakaan GD terpasang dan format gambar mana yang didukung oleh versi GD yang terpasang. Namun kemungkinan pendeteksiannya tidak akurat atau salah, beberapa versi PHP tidak memungkinkan pendeteksian format gambar yang didukung. Jika {$PRODUCT_NAME} gagal mendeteksi secara otomatis format gambar yang tepat, Anda dapat menentukan format gambar yang tepat. Nilai yang mungkin adalah: none, png, jpeg, gif.";

$GLOBALS['phpAds_hlp_p3p_policies'] = "Jika Anda ingin mengaktifkan Kebijakan Privasi P3P {$PRODUCT_NAME}, Anda harus mengaktifkan opsi ini.";

$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "Kebijakan ringkas yang dikirim bersama dengan cookies. Setelan defaultnya adalah: 'CUR ADM NOR NOR STA NID', yang akan memungkinkan Internet Explorer 6 untuk menerima cookie yang digunakan oleh {$PRODUCT_NAME}. Jika Anda ingin Anda dapat mengubah setelan ini agar sesuai dengan pernyataan privasi Anda sendiri.";

$GLOBALS['phpAds_hlp_p3p_policy_location'] = "Jika Anda ingin menggunakan kebijakan privasi lengkap, Anda dapat menentukan lokasi kebijakan.";

$GLOBALS['phpAds_hlp_compact_stats'] = "Secara tradisional {$PRODUCT_NAME} menggunakan logging yang agak luas, yang sangat rinci namun juga sangat menuntut pada server database. Ini bisa menjadi masalah besar di situs dengan banyak pengunjung. Untuk mengatasi masalah ini,
 {$PRODUCT_NAME} juga mendukung jenis statistik baru, statistik ringkas, yang kurang banyak menuntut di server basis data, namun juga tidak rinci. Statistik ringkas mengumpulkan AdViews, AdClicks, dan AdConversions untuk setiap jam, jika Anda membutuhkan lebih banyak detail, Anda dapat menonaktifkan statistik kompak.";

$GLOBALS['phpAds_hlp_log_adviews'] = "Biasanya semua AdViews dicatat, jika Anda tidak ingin mengumpulkan statistik tentang AdView, Anda dapat menonaktifkannya.";

$GLOBALS['phpAds_hlp_block_adviews'] = "Jika pengunjung memuat ulang laman, AdView akan masuk log oleh {$PRODUCT_NAME} setiap saat. Fitur ini digunakan untuk memastikan hanya satu AdView yang masuk untuk setiap spanduk unik untuk jumlah detik yang Anda tentukan. Misalnya: jika Anda menetapkan nilai ini menjadi 300 detik, {$PRODUCT_NAME} hanya akan mencatat AdView jika spanduk yang sama tidak ditampilkan kepada pengunjung yang sama dalam 5 menit terakhir. Fitur ini hanya berfungsi agar browser menerima cookies.";

$GLOBALS['phpAds_hlp_log_adclicks'] = "Biasanya semua akun AdClicks dicatat, jika Anda tidak ingin mengumpulkan statistik tentang AdClicks, Anda dapat menonaktifkannya.";

$GLOBALS['phpAds_hlp_block_adclicks'] = "Jika pengunjung mengklik beberapa kali pada spanduk, sebuah AdClick akan masuk log oleh {$PRODUCT_NAME} 
setiap saat. Fitur ini digunakan untuk memastikan hanya satu AdClick yang masuk untuk setiap spanduk unik untuk jumlah detik yang Anda tentukan. Misalnya: jika Anda menetapkan nilai ini menjadi 300 detik, {$PRODUCT_NAME} hanya akan mencatat AdClicks jika pengunjung tidak mengklik spanduk yang sama dalam 5 menit terakhir. Fitur ini hanya bekerja saat browser menerima cookies.";

$GLOBALS['phpAds_hlp_log_adconversions'] = "Biasanya semua pendaftaran AdConversions dicatat, jika Anda tidak ingin mengumpulkan statistik tentang AdConversions, Anda dapat menonaktifkannya.";

$GLOBALS['phpAds_hlp_block_adconversions'] = "Jika pengunjung memuat ulang laman dengan suar AdConversion, {$PRODUCT_NAME} akan mencatat AdConversion setiap saat. Fitur ini digunakan untuk memastikan hanya satu AdConversion yang masuk log untuk setiap konversi unik selama jumlah detik yang Anda tentukan. Misalnya: jika Anda menetapkan nilai ini menjadi 300 detik, {$PRODUCT_NAME} hanya akan mencatat AdConversions jika pengunjung tidak memuat halaman yang sama dengan suar AdConversion dalam 5 menit terakhir. Fitur ini hanya bekerja saat browser menerima cookies.";

$GLOBALS['phpAds_hlp_geotracking_stats'] = "Jika Anda menggunakan database penargetan geo, Anda juga dapat menyimpan informasi geografis di database. Jika Anda telah mengaktifkan opsi ini, Anda akan dapat melihat statistik tentang lokasi pengunjung Anda dan bagaimana setiap banner tampil di berbagai negara. Pilihan ini hanya akan tersedia untuk Anda jika Anda menggunakan statistik verbose.";

$GLOBALS['phpAds_hlp_reverse_lookup'] = "Nama host biasanya ditentukan oleh server web, namun dalam beberapa kasus ini mungkin dimatikan. Jika Anda ingin menggunakan hostname pengunjung di dalam peraturan pengiriman dan / atau menyimpan statistik tentang hal ini dan server tidak menyediakan informasi ini, Anda harus mengaktifkan opsi ini. Menentukan nama host pengunjung memang memakan waktu lama; itu akan memperlambat pengiriman spanduk turun.";

$GLOBALS['phpAds_hlp_proxy_lookup'] = "Beberapa pengunjung menggunakan server proxy untuk mengakses internet. Dalam hal ini {$PRODUCT_NAME} akan mencatat alamat IP atau nama host dari server proxy alih-alih pengguna. Jika Anda mengaktifkan fitur ini {$PRODUCT_NAME} akan mencoba menemukan alamat IP atau nama host komputer pengunjung di belakang server proxy. Jika tidak memungkinkan untuk menemukan alamat yang tepat dari pengunjung maka akan menggunakan alamat dari server proxy. Pilihan ini tidak diaktifkan secara default, karena akan memperlambat pengiriman spanduk secara turun.";

$GLOBALS['phpAds_hlp_obfuscate'] = "Tidak ada disini....";

$GLOBALS['phpAds_hlp_auto_clean_tables'] = $GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "Jika Anda mengaktifkan fitur ini, statistik yang dikumpulkan akan otomatis dihapus setelah periode yang Anda tentukan di bawah kotak centang ini dilewati. Misalnya, jika Anda menetapkan ini menjadi 5 minggu, statistik yang lebih tua dari 5 minggu akan dihapus secara otomatis.";

$GLOBALS['phpAds_hlp_auto_clean_userlog'] = $GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "Fitur ini secara otomatis akan menghapus entri dari userlog yang lebih tua dari jumlah minggu yang ditentukan di bawah kotak centang ini.";

$GLOBALS['phpAds_hlp_geotracking_type'] = "Penargetan geografi mengizinkan {$PRODUCT_NAME} untuk mengubah alamat IP pengunjung menjadi informasi geografis. Berdasarkan informasi ini, Anda dapat menetapkan peraturan pengiriman atau Anda dapat menyimpan informasi ini untuk melihat negara mana yang menghasilkan banyak tayangan atau klik-thrus. Jika Anda ingin mengaktifkan penargetan geo, Anda harus memilih jenis database yang Anda miliki.
{$PRODUCT_NAME} saat ini mendukung <a href='http://hop.clickbank.net/?phpadsnew/ip2country' target='_blank'>IP2Country</a> 
dan <a href ='http://www.maxmind.com/?rId=phpadsnew 'target='_blank'>GeoIP</a> database.";

$GLOBALS['phpAds_hlp_geotracking_location'] = "Kecuali anda adalah modul Apache GeoIP, Anda harus memberi tahu {$PRODUCT_NAME} lokasi basis data penargetan geo. Selalu disarankan untuk menempatkan database di luar akar dokumen server web, karena jika tidak orang bisa mendownload database.";

$GLOBALS['phpAds_hlp_geotracking_cookie'] = "Mengkonversi alamat IP dalam informasi geografis membutuhkan waktu. Untuk mencegah
{$PRODUCT_NAME} agar tidak melakukan ini setiap kali spanduk dikirim, hasilnya dapat disimpan dalam cookie. Jika kuki ini hadir {$PRODUCT_NAME} akan menggunakan informasi ini alih-alih mengubah alamat IP.";

$GLOBALS['phpAds_hlp_ignore_hosts'] = "Jika Anda tidak ingin menghitung penayangan, klik, dan konversi dari komputer tertentu, Anda dapat menambahkannya ke daftar ini. Jika Anda telah mengaktifkan lookup reverse, Anda dapat menambahkan kedua nama domain dan alamat IP, jika tidak, Anda hanya dapat menggunakan alamat IP. Anda juga bisa menggunakan wildcard (yaitu '*.altavista.com' atau '192.168. *').";

$GLOBALS['phpAds_hlp_begin_of_week'] = "Bagi kebanyakan orang seminggu dimulai pada hari Senin, tapi jika anda ingin memulai setiap minggu pada hari Minggu Anda bisa.";

$GLOBALS['phpAds_hlp_percentage_decimals'] = "Menentukan jumlah desimal yang akan ditampilkan di halaman statistik.";

$GLOBALS['phpAds_hlp_warn_admin'] = "{$PRODUCT_NAME} dapat mengirimi Anda email jika hanya ada sedikit jumlah penayangan, klik, atau konversi yang tersisa. Ini dinyalakan secara default.";

$GLOBALS['phpAds_hlp_warn_client'] = "{$PRODUCT_NAME} dapat mengirim email pengiklan jika salah satu kampanye hanya memiliki jumlah penayangan, klik, atau konversi yang terbatas. Ini dinyalakan secara default.";

$GLOBALS['phpAds_hlp_qmail_patch'] = "Beberapa versi qmail dipengaruhi oleh bug, yang menyebabkan email dikirim oleh
 {$PRODUCT_NAME} untuk menampilkan tajuk di dalam body email. Jika anda mengaktifkan setelan ini, {$PRODUCT_NAME} akan mengirim email dalam format yang kompatibel dengan qmail.";

$GLOBALS['phpAds_hlp_warn_limit'] = "Batas di mana {$PRODUCT_NAME} mulai mengirim email peringatan. Ini adalah 100 secara default.";

$GLOBALS['phpAds_hlp_acl'] = "Jika Anda tidak menggunakan aturan pengiriman, Anda dapat menonaktifkan opsi ini dengan parameter ini, ini akan mempercepat {$PRODUCT_NAME} sedikit.";

$GLOBALS['phpAds_hlp_default_banner_url'] = $GLOBALS['phpAds_hlp_default_banner_target'] = "Jika {$PRODUCT_NAME} tidak dapat terhubung ke server database, atau tidak dapat menemukan spanduk yang cocok sama sekali, misalnya saat database macet atau telah dihapus, tidak akan menampilkan apa pun. Beberapa pengguna mungkin ingin menentukan banner default, yang akan ditampilkan dalam situasi ini. Spanduk default yang ditentukan di sini tidak akan dicatat dan tidak akan digunakan jika masih ada spanduk aktif yang tersisa di database. Ini dimatikan secara default.";

$GLOBALS['phpAds_hlp_delivery_caching'] = "Untuk membantu mempercepat pengiriman {$PRODUCT_NAME} menggunakan tembolok yang mencakup semua informasi yang diperlukan untuk mengirimkan spanduk ke pengunjung situs web anda. Cache pengiriman disimpan secara default di database, namun untuk meningkatkan kecepatan lebih banyak lagi, mungkin juga menyimpan cache di dalam file atau di dalam memori bersama. Memori bersama paling cepat, File juga sangat cepat. Tidak disarankan mematikan cache pengiriman, karena ini akan sangat mempengaruhi kinerja.";

$GLOBALS['phpAds_hlp_type_web_mode'] = "Jika anda ingin menggunakan spanduk yang tersimpan di server web, Anda perlu mengkonfigurasi pengaturan ini. Jika anda ingin menyimpan spanduk di direktori lokal, setel opsi ini ke <i>Direktori lokal</i>. Jika anda ingin menyimpan banner di server FTP eksternal, setel opsi ini ke <i>server FTP Eksternal</i>. Pada server web tertentu anda mungkin ingin menggunakan opsi FTP bahkan di server web lokal.";

$GLOBALS['phpAds_hlp_type_web_dir'] = "Tentukan direktori tempat {$PRODUCT_NAME} perlu menyalin spanduk yang diunggah ke. Direktori ini perlu dapat ditulis oleh PHP, ini bisa berarti anda perlu memodifikasi izin UNIX untuk direktori ini (chmod). Direktori yang anda tentukan di sini perlu berada di akar dokumen server web, server web harus dapat menyajikan file secara langsung. Jangan tentukan garis miring (/). Anda hanya perlu mengkonfigurasi opsi ini jika anda telah menyetel metode penyimpanan ke <i>Direktori lokal</i>.";

$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "Jika Anda menetapkan metode penyimpanan ke <i> server FTP Eksternal </i> Anda perlu menentukan alamat IP atau nama domain server FTP tempat {$PRODUCT_NAME} perlu menyalin spanduk yang diunggah ke.";

$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "Jika Anda menetapkan metode penyimpanan ke <i>server FTP Eksternal</i> Anda perlu menentukan direktori di server FTP eksternal tempat {$PRODUCT_NAME} perlu menyalin spanduk yang diunggah ke.";

$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "Jika Anda menyetel metode penyimpanan ke <i>server FTP Eksternal</i> Anda perlu menentukan nama pengguna yang {$PRODUCT_NAME} harus gunakan untuk terhubung ke server FTP eksternal.";

$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "Jika Anda menyetel metode penyimpanan ke <i>Server FTP Eksternal</i> Anda harus menentukan kata sandi yang harus digunakan {$PRODUCT_NAME} agar bisa terhubung ke server FTP eksternal.";

$GLOBALS['phpAds_hlp_type_web_ftp_passive'] = "Beberapa server FTP dan firewall memerlukan transfer untuk menggunakan Passive Mode (PASV). Jika {$PRODUCT_NAME} perlu menggunakan Mode Pasif untuk terhubung ke server FTP anda, maka aktifkan opsi ini.";

$GLOBALS['phpAds_hlp_type_web_url'] = "Jika anda menyimpan spanduk di server web, {$PRODUCT_NAME} perlu mengetahui URL publik yang sesuai dengan direktori yang anda tentukan di bawah ini. Jangan tentukan garis miring (/).";

$GLOBALS['phpAds_hlp_type_web_ssl_url'] = "Jika anda menyimpan spanduk di server web, {$PRODUCT_NAME} perlu mengetahui URL publik (SSL) mana yang sesuai dengan direktori yang anda tentukan di bawah ini. Jangan tentukan garis miring (/).";

$GLOBALS['phpAds_hlp_type_html_auto'] = "Jika opsi ini diaktifkan {$PRODUCT_NAME} akan secara otomatis mengubah spanduk HTML agar klik dapat dicatat. Namun meskipun opsi ini diaktifkan, masih dimungkinkan untuk menonaktifkan fitur ini secara per banner.";

$GLOBALS['phpAds_hlp_type_html_php'] = "Anda dapat membiarkan {$PRODUCT_NAME} menjalankan kode PHP yang disematkan di dalam spanduk HTML. Fitur ini dimatikan secara default.";

$GLOBALS['phpAds_hlp_admin'] = "Harap masukkan nama pengguna administrator. Dengan username ini anda bisa login
antarmuka administrator.";

$GLOBALS['phpAds_hlp_admin_pw'] = $GLOBALS['phpAds_hlp_admin_pw2'] = "Masukkan kata sandi yang ingin Anda gunakan untuk masuk ke antarmuka administrator.
Anda perlu memasukkannya dua kali untuk mencegah kesalahan pengetikan.";

$GLOBALS['phpAds_hlp_pwold'] = $GLOBALS['phpAds_hlp_pw'] = $GLOBALS['phpAds_hlp_pw2'] = "Untuk mengganti kata sandi administrator, Anda bisa menentukan yang lama
password diatas Anda juga perlu menentukan kata sandi baru dua kali, untuk
mencegah kesalahan pengetikan.";

$GLOBALS['phpAds_hlp_admin_fullname'] = "Tentukan nama lengkap administrator. Ini digunakan saat mengirim statistik
melalui email.";

$GLOBALS['phpAds_hlp_admin_email'] = "Alamat email administrator Ini digunakan sebagai dari-alamat kapan
mengirim statistik melalui email.";

$GLOBALS['phpAds_hlp_admin_novice'] = "Jika Anda ingin menerima peringatan sebelum menghapus pengiklan, kampanye, spanduk,
situs web dan zona; atur opsi ini ke benar.";

$GLOBALS['phpAds_hlp_client_welcome'] = "Jika Anda mengaktifkan fitur ini pada pesan pembuka akan ditampilkan di halaman pertama yang akan dilihat pengiklan setelah masuk loggin. Anda dapat mempersonalisasi pesan ini dengan mengedit lokasi file selamat datang.html di direktori admin/templates. Hal-hal yang mungkin ingin Anda sertakan antara lain: Nama perusahaan, informasi kontak, logo perusahaan Anda, tautan halaman dengan tarif iklan, dll..";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "Alih-alih mengedit file welcome.html Anda juga dapat menentukan teks kecil di sini. Jika Anda memasukkan teks di sini, file welcome.html akan diabaikan. Hal ini diperbolehkan untuk menggunakan tag html.";

$GLOBALS['phpAds_hlp_updates_frequency'] = "Jika Anda ingin memeriksa versi baru {$PRODUCT_NAME}, Anda dapat mengaktifkan fitur ini. Mungkin saja menentukan interval di mana {$PRODUCT_NAME} membuat koneksi ke server pembaruan. Jika versi baru ditemukan kotak dialog akan muncul dengan informasi tambahan tentang update.";

$GLOBALS['phpAds_hlp_userlog_email'] = "Jika Anda ingin menyimpan salinan semua pesan email keluar yang dikirim oleh {$PRODUCT_NAME} Anda dapat mengaktifkan fitur ini. Pesan email disimpan di userlog.";

$GLOBALS['phpAds_hlp_userlog_inventory'] = "Untuk memastikan perhitungan inventaris berjalan dengan benar, Anda dapat menyimpan laporan tentang
perhitungan persediaan per jam. Laporan ini mencakup profil yang diprediksi dan berapa jumlahnya
prioritas ditugaskan ke semua spanduk. Informasi ini mungkin berguna jika Anda
ingin mengirimkan laporan bug tentang perhitungan prioritas. Laporannya adalah
disimpan di dalam userlog.";

$GLOBALS['phpAds_hlp_userlog_autoclean'] = "Untuk memastikan database dipangkas dengan benar, Anda dapat menyimpan laporan tentang apa yang sebenarnya terjadi selama pemangkasan. Informasi ini akan disimpan di userlog.";

$GLOBALS['phpAds_hlp_default_banner_weight'] = "Jika Anda ingin menggunakan bobot banner default yang lebih tinggi, Anda dapat menentukan bobot yang diinginkan di sini. Pengaturan ini adalah 1 secara default.";

$GLOBALS['phpAds_hlp_default_campaign_weight'] = "Jika Anda ingin menggunakan bobot kampanye default yang lebih tinggi, Anda dapat menentukan bobot yang diinginkan di sini. Pengaturan ini adalah 1 secara default.";

$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "Jika opsi ini diaktifkan, informasi tambahan tentang setiap campain akan ditampilkan di halaman
 <i>Campaigns</i>. Informasi tambahan mencakup jumlah sisa AdViews, jumlah sisa AdClicks, jumlah sisa AdConversions, tanggal aktivasi, tanggal kedaluwarsa dan pengaturan prioritas.";

$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "Jika opsi ini diaktifkan, informasi tambahan tentang setiap banner akan ditampilkan di halaman
 <i>Banner</i>. Informasi tambahan mencakup URL tujuan, kata kunci, ukuran dan bobot banner.";

$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "Jika opsi ini diaktifkan, pratinjau semua spanduk akan ditampilkan di laman <i>Banners</i>. Jika opsi ini dinonaktifkan, masih memungkinkan untuk menampilkan pratinjau setiap banner dengan klik pada segitiga di samping setiap banner di halaman <i>Banner</i>.";

$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "Jika opsi ini diaktifkan, spanduk HTML sebenarnya akan ditampilkan alih-alih kode HTML. Pilihan ini dinonaktifkan secara default, karena spanduk HTML mungkin bertentangan dengan antarmuka pengguna. Jika opsi ini dinonaktifkan, masih mungkin untuk melihat spanduk HTML yang sebenarnya, dengan mengeklik tombol <i>Show banner</i> di samping kode HTML.";

$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "Jika opsi ini diaktifkan pratinjau akan ditampilkan di bagian atas <i>properti Banner</i>,<i> opsi Pengiriman</i> dan <i> zona Linked</i>. Jika opsi ini dinonaktifkan, masih mungkin untuk melihat spanduk, dengan mengklik tombol <i>Show banner</i> di bagian atas halaman.";

$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "Jika opsi ini diaktifkan, semua spanduk, kampanye, dan pengiklan yang tidak aktif akan disembunyikan dari halaman
 <i>Pengiklan & Kampanye</i> dan <i>Kampanye</i>. Jika opsi ini diaktifkan, masih mungkin untuk melihat item tersembunyi, dengan mengklik tombol <i>Show all</i> di bagian bawah halaman.";

$GLOBALS['phpAds_hlp_gui_show_matching'] = "Jika opsi ini diaktifkan, banner yang cocok akan ditampilkan di halaman <i>Linked spanduk</i>, jika pilihan <i>Pemilihan kampanye</i> dipilih. Ini akan memungkinkan anda melihat spanduk mana yang dianggap tepat untuk pengiriman jika kampanye dikaitkan. Ini juga memungkinkan untuk melihat pratinjau spanduk yang cocok.";

$GLOBALS['phpAds_hlp_gui_show_parents'] = "Jika opsi ini diaktifkan, kampanye induk spanduk akan ditampilkan di laman <i>Spanduk yang ditautkan</i>, jika opsi <i>pemilihan Banner</i> dipilih. Ini akan memungkinkan anda melihat panji-panji mana yang menjadi tujuan kampanye sebelum spanduk ditautkan. Ini juga berarti bahwa spanduk dikelompokkan menurut kampanye orang tua dan tidak lagi diurutkan berdasarkan abjad.";
