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











$GLOBALS['phpAds_hlp_my_header'] = $GLOBALS['phpAds_hlp_my_footer'] = "Anda harus meletakkan di sini jalan ke file header (e.g.: /home/login/www/header.htm) untuk memiliki header dan/atau footer pada setiap halaman di antarmuka admin. Anda bisa meletakkan teks atau html di file ini (jika Anda ingin menggunakan html di salah satu atau kedua file ini tidak menggunakan tag seperti <body> atau <html>).";

$GLOBALS['phpAds_hlp_my_logo'] = "Anda harus meletakkan di sini nama file logo kustom yang ingin Anda tampilkan sebagai pengganti logo default. Logo harus ditempatkan di direktori admin/images sebelum menyetel nama file di sini.";

$GLOBALS['phpAds_hlp_gui_header_foreground_color'] = "Anda harus meletakkan di sini warna kustom yang akan digunakan untuk tab, bilah pencarian, dan beberapa teks tebal.";

$GLOBALS['phpAds_hlp_gui_header_background_color'] = "Anda harus meletakkan di sini warna kustom yang akan digunakan untuk latar belakang header.";

$GLOBALS['phpAds_hlp_gui_header_active_tab_color'] = "Anda harus meletakkan di sini warna kustom yang akan digunakan untuk tab utama yang dipilih saat ini.";

$GLOBALS['phpAds_hlp_gui_header_text_color'] = "Anda harus meletakkan di sini warna kustom yang akan digunakan untuk teks di header.";

$GLOBALS['phpAds_hlp_content_gzip_compression'] = "Dengan mengaktifkan kompresi konten GZIP Anda akan mendapatkan penurunan besar dari data yang dikirim ke browser setiap kali halaman antarmuka administrator dibuka. Untuk mengaktifkan fitur ini, Anda harus memasang ekstensi GZIP.";







$GLOBALS['phpAds_hlp_p3p_policy_location'] = "Jika Anda ingin menggunakan kebijakan privasi lengkap, Anda dapat menentukan lokasi kebijakan.";


$GLOBALS['phpAds_hlp_log_adviews'] = "Biasanya semua AdViews dicatat, jika Anda tidak ingin mengumpulkan statistik tentang AdView, Anda dapat menonaktifkannya.";


$GLOBALS['phpAds_hlp_log_adclicks'] = "Biasanya semua akun AdClicks dicatat, jika Anda tidak ingin mengumpulkan statistik tentang AdClicks, Anda dapat menonaktifkannya.";


$GLOBALS['phpAds_hlp_log_adconversions'] = "Biasanya semua pendaftaran AdConversions dicatat, jika Anda tidak ingin mengumpulkan statistik tentang AdConversions, Anda dapat menonaktifkannya.";


$GLOBALS['phpAds_hlp_geotracking_stats'] = "Jika Anda menggunakan database penargetan geo, Anda juga dapat menyimpan informasi geografis di database. Jika Anda telah mengaktifkan opsi ini, Anda akan dapat melihat statistik tentang lokasi pengunjung Anda dan bagaimana setiap banner tampil di berbagai negara. Pilihan ini hanya akan tersedia untuk Anda jika Anda menggunakan statistik verbose.";

$GLOBALS['phpAds_hlp_reverse_lookup'] = "Nama host biasanya ditentukan oleh server web, namun dalam beberapa kasus ini mungkin dimatikan. Jika Anda ingin menggunakan hostname pengunjung di dalam peraturan pengiriman dan / atau menyimpan statistik tentang hal ini dan server tidak menyediakan informasi ini, Anda harus mengaktifkan opsi ini. Menentukan nama host pengunjung memang memakan waktu lama; itu akan memperlambat pengiriman spanduk turun.";


$GLOBALS['phpAds_hlp_obfuscate'] = "Tidak ada disini....";

$GLOBALS['phpAds_hlp_auto_clean_tables'] = $GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "Jika Anda mengaktifkan fitur ini, statistik yang dikumpulkan akan otomatis dihapus setelah periode yang Anda tentukan di bawah kotak centang ini dilewati. Misalnya, jika Anda menetapkan ini menjadi 5 minggu, statistik yang lebih tua dari 5 minggu akan dihapus secara otomatis.";

$GLOBALS['phpAds_hlp_auto_clean_userlog'] = $GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "Fitur ini secara otomatis akan menghapus entri dari userlog yang lebih tua dari jumlah minggu yang ditentukan di bawah kotak centang ini.";




$GLOBALS['phpAds_hlp_ignore_hosts'] = "Jika Anda tidak ingin menghitung penayangan, klik, dan konversi dari komputer tertentu, Anda dapat menambahkannya ke daftar ini. Jika Anda telah mengaktifkan lookup reverse, Anda dapat menambahkan kedua nama domain dan alamat IP, jika tidak, Anda hanya dapat menggunakan alamat IP. Anda juga bisa menggunakan wildcard (yaitu '*.altavista.com' atau '192.168. *').";

$GLOBALS['phpAds_hlp_begin_of_week'] = "Bagi kebanyakan orang seminggu dimulai pada hari Senin, tapi jika anda ingin memulai setiap minggu pada hari Minggu Anda bisa.";

$GLOBALS['phpAds_hlp_percentage_decimals'] = "Menentukan jumlah desimal yang akan ditampilkan di halaman statistik.";








$GLOBALS['phpAds_hlp_type_web_mode'] = "Jika anda ingin menggunakan spanduk yang tersimpan di server web, Anda perlu mengkonfigurasi pengaturan ini. Jika anda ingin menyimpan spanduk di direktori lokal, setel opsi ini ke <i>Direktori lokal</i>. Jika anda ingin menyimpan banner di server FTP eksternal, setel opsi ini ke <i>server FTP Eksternal</i>. Pada server web tertentu anda mungkin ingin menggunakan opsi FTP bahkan di server web lokal.";











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
