<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* Translation by Rachim Tamsjadi. Please send corrections              */
/* to tamsjadi@icqmail.com      010402                                  */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Settings help translation strings
$GLOBALS['phpAds_hlp_dbhost'] = "
        Tentukan hostname dari MySQL database server.
		";
		
$GLOBALS['phpAds_hlp_dbuser'] = "
        Tentukan username untuk phpAdsNew guna mengakses MySQL database server.
		";
		
$GLOBALS['phpAds_hlp_dbpassword'] = "
        Tentukan kata sandi untuk phpAdsNew guna mengakses MySQL database server.
		";
		
$GLOBALS['phpAds_hlp_dbname'] = "
        Tentukan nama database untuk phpAdsNew guna menyimpan data.
		";
		
$GLOBALS['phpAds_hlp_persistent_connections'] = "
        Pemakaian koneksi persistent berpotensial untuk menambah kecepatan kerja pada program phpAdsNew 
		dan meringankan daya load pada server sekalian. Ada kelemahannya, iaitu pada site yang 
		banyak dikunjungi oleh tamu daya load pada server bisa bertambah dan menbengkak dibandingkan dengan 
		setingan konfigurasi koneksi yang normal. Keputusan untuk memakai koneksi normal atau koneksi persistant tergantung 
		pada jumlah tamu pada site dan perangkat keras (Hardware) yang digunakan untuk server. Bila phpAdsNew menyerap 
		tenaga server secara berkelebihan periksa setingan ini.
		";
		
$GLOBALS['phpAds_hlp_insert_delayed'] = "
        MySQL mengunci tabel selama proses penambahan data. Jika banyak tamu berkunjung kepada site ada kemungkinan 
		terjadinya efek, penambahan data baru pada tabel terhambat dan phpAdsNew terpaksa menunggu selama database 
		masih terkunci. Bila insert delayed dipakai tidak terjadi efek tersebut dan penambahan data baru kepada tabel
		akan dilakukan pada waktu sistem tidak sibuk dengan thread lain. 
		";
		
$GLOBALS['phpAds_hlp_table_prefix'] = "
        Jika database yang dipakai oleh phpAdsNew digunakan secara paralel dengan produk software yang lain keputusan pintar
		adalah menambah sebuah prefix kepada nama seluruh table. Jika lebih dari satu instalasi proram phpAdsNew dipakai
		dalam database yang sama perlu diperhatikan bahwa seluruh prefix untuk setiap instalasi harus unik.
		";
		
$GLOBALS['phpAds_hlp_tabletype'] = "
        MySQL support bermacam tipe tabel. Setiap tipe tabel memiliki tanda unik dan ada berberapa tipe
		yang mampu mempercepat kinerja kerja program phpAdsNew. MyISAM adalah tipe tabel default yang tersedia
		pada semua instalasi database MySQL. Tipe tabel selain tipe MyISAM kemungkinan besar tidak tersedia pada server Anda.
		";
		
$GLOBALS['phpAds_hlp_url_prefix'] = "
        Demi kelancaran proses kerja, phpAdsNew perlu diberi petunjuktentang tempat penyimpanan file-file
        induknya pada webserver. Silakan spesifikasikan URL direktori instalasi phpAdsNew,  
        seb. contoh: http://www.url-anda.com/phpAdsNew.
		";
		
$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
        Silakan isi path yang menunjuk kepada header files disini (Contoh: /home/login/www/header.htm) 
        guna untuk memiliki sebuah header dan/atau footer di setiap halaman pada interface Admin. 
        Silakan pilih jenis text atau html (Peringatan jika kode html dalam salah satu atau dalam kedua
        file dinginkan: Jangan gunakan Tags seperti <body> atau <html>).
		";
		
$GLOBALS['phpAds_hlp_language'] = "
        Silakan tentukan bahasa awal yang dipakai oleh program phpAdsNew. Bahasa yang ditentukan
        disini akan dipakai sebagai bahasa awal pada interface Admin dan interface Client. Perhatian: 
        Diperbolehkan untuk pakai bahasa yang berbeda untuk setiap Client. Hal ini diatur oleh interface Admin 
        dan diperbolehkan sekalian kepada Client untuk memilih sendiri bahasa yang digunkan pada interface.
		";
		
$GLOBALS['phpAds_hlp_name'] = "
        Silakan tentukan nama yang dipakai untuk aplikasi ini. String yang dipakai 
        akan ditampilkan pada semua halaman pada interface Admin dan interface Client. 
        Jika dikosongkan (default) logo program phpAdsNew akan tertampil pada layar.
		";
		
$GLOBALS['phpAds_hlp_company_name'] = "
        Nama yang ditulis disini akan tertampil pada setiap e-mail yang dikirim secara otomatis 
	oleh program phpAdsNew.
		";
		
$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
        Biasanya program phpAdsNew mendeteksi secara otomatis adanya GD library terinstal pada 
        server dan image format mana yang disuport oleh versi GD yang terinstal. Bagimanapun juga, 
        ada kemungkinan terjadi deteksi yang kurang akur atau salah. Ada juga versi 
        PHP yang tidak beri izin untuk autodeteksi image format. Bila program phpAdsNew gagal 
        meng-autodeteksi image format yang akur, silakan pilih image format secara manual. 
        Format yang didukung sbb.: none, png, jpeg atau gif.
		";
		
$GLOBALS['phpAds_hlp_p3p_policies'] = "
        Bila fungsi phpAdsNew' P3P Privacy Policies perlu diaktifkan silakan 
        pilih tanda On. 
		";
		
$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
        Compact Policy yang dikirim bersama dengan Cookie. Setingan default
        adalah: 'CUR ADM OUR NOR STA NID'. Setingan ini beri izin kepada Internet Explorer 6 
        untuk terima Cookies yang digunakan oleh phpAdsNew. Bila Anda berminat silakan 
        ubah setingan ini sesuai dengan privacy statement perusahaan Anda sendiri.
		";
		
$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
        Bila Full Privacy Policy diinginkan silakan tentukan lokasi 
        dari policy tersebut.
		";
		
$GLOBALS['phpAds_hlp_compact_stats'] = "
        Secara tradisional phpAdsNew mengunakan logging yang extensif dengan tingkat detail 
        yang sangat tinggi, tetapi fungsi ini membutuhukan banyak tenaga dari database server.
        Hal ini berpotensial untuk jadi masalah bagi site dengan jumlah kunjungan tamu yang tinggi.
	Untuk mengatasi masalah ini phpAdsNew support tipe statistik yang baru, iaitu Compact Statistics. 
	Tipe ini juga lebih hemat pada database server tetapi disisi lainnya kalah dalam segi detail. 
	Tipe Compact Statistics hanya me-log statistik secara harian. Bila statistik dengan interval 
	60 menit diperlukan, silakan ubah setingan Compact Statistics ke posisi Off.
		";
		
$GLOBALS['phpAds_hlp_log_adviews'] = "
        Pada stelan awal, setiap AdView di-log. Jika statistik tentang AdView tidak diperlukan, 
        silakan ubah setingan ini ke posisi Off.
		";
		
$GLOBALS['phpAds_hlp_log_adclicks'] = "
        Pada stelan awal, setiap AdKlik di-log. Jika statistik tentang AdKlik tidak diperlukan 
        silakan ubah stelan ini ke posisi Off.
        	";
		
$GLOBALS['phpAds_hlp_reverse_lookup'] = "
        Program phpAdsNew me-log alamat IP dari setiap pengunjung secara default. Bila Reverse Lookup 
        dan logging dari domain names diperlukan silakan ubah stelan ini ke posisi On. Reverse lookup 
        perlu waktu; stelan ini mempengaruh kinerja kerja sistem.
		";
		
$GLOBALS['phpAds_hlp_ignore_hosts'] = "
        Bila Counting dari Clicks dan Views dari computer tertentu tidak diinginkan 
        silakan tambahkan computer yang bersangkutan kedalam array disini. Bila fungsi 
        Reverse Lookup aktif, nama domain dan alamat IP dapat diisi.  Bila fungsi
        Reverse Lookup tidak aktif hanya alamat IP yang dapat diisi disini. Silakan
	gunakan Wildcards (seperti '*.pintunet.com' or '192.168.*').
		";
		
$GLOBALS['phpAds_hlp_begin_of_week'] = "
        Pada umumnya awal minggu dianggap mulai pada setiap hari senin, tetapi bila
        awal minggu perlu ditentukan pada hari minggu silakan gunakan stelan ini.
		";
		
$GLOBALS['phpAds_hlp_percentage_decimals'] = "
        Pilihan jumlah angka desimal yang ditampilkan pada halaman statistik.
		";
		
$GLOBALS['phpAds_hlp_warn_admin'] = "
        Program phpAdsNew mengirim e-mail kepada AdsAdministrator secara otomatis
        jika sisa Adklik atau AdView dari salah satu Client mulai terbatas.
	Setingan ini dalam posisi On sebagai default.
		";
		
$GLOBALS['phpAds_hlp_warn_client'] = "
	Program phpAdsNew mengirim e-mail kepada Client secara otomatis
        jika sisa Adklik atau AdView mulai terbatas.
	Setingan ini dalam posisi On sebagai default.
		";
		
$GLOBALS['phpAds_hlp_warn_limit'] = "
        Limit mulai kapan program phpAdsNew mengirim e-mail
        peringatan kepada Client. Setingan default adalah 100.
		";
		
$GLOBALS['phpAds_hlp_retrieval_method'] = "
        Program phpAdsNew mengunakan empat cara untuk retrieval banner: Random banner 
        retrieval (default), Normal sequential banner retrieval, Weight 
        based sequential banner retrieval dan Full sequential banner retrieval.
      	Jika Anda mengunakan Zona, program phpAdsNew akan gunakan sistem 
        random banner retrieval secara otomatis dan setingan ini dilewatkan.
		";
		
$GLOBALS['phpAds_hlp_con_key'] = "
        Program phpAdsNew mengunakan banner retrieval system yang sangat changgih.
        Untuk informasi lebih lanjut silakan baca bagian API pada dokumentasi. Dengan
	stelan ini fungsi Conditional Keywords diaktifkan.
	Fungsi ini aktif sebagai default.
		";
		
$GLOBALS['phpAds_hlp_mult_key'] = "
        Untuk setiap banner diperbolehkan untuk menentukan lebih dari satu Keyword.
        Setingan ini diperlukan jika lebih dari satu keyword digunakan.
        Fungsi ini aktif sebagai default.
		";
		
$GLOBALS['phpAds_hlp_acl'] = "
        Jika tidak ada limitasi dalam cara penampilan silakan disable fungsi 
        ACL Checking dengan parameter ini. Stelan ini mempengaruh kecepatan
	program phpAdsNew pada umumnya.
		";
		
$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = "
        Jika program phpAdsNew tidak sukses membangun koneksi ke database server,
	atau bila tidak ditemukan banner yang sesuai, seandainya setelah terjadi
	Crash atau penghapusan data pada database, tampilan pada halaman akan kosong.
	Berberapa User ingin menampilkan banner default jika hal tersebut terjadi. 
        Banner default yang ditentukan disini tidak tercatat dalam Log dan tidak
	ditampilkan jika masih ada banner lain yang aktif dalam database.
	Fungsi ini tidak aktif sebagai default.
		";
		
$GLOBALS['phpAds_hlp_zone_cache'] = "
        Bila Anda ingin mengunakan fungsi Zona, setingan ini beri izin kepada program phpAdsNew
	untuk simpan Informasi Banner dalam Cache guna siap dipakai kembali setiap waktu. 
        Fungsi ini akan mempengaruhi kecepatan program phpAdsNew secara positif,
	sehubungan Zone Information, akses ke Banner Information dan akhirnya pilihan banner
	dilakukan langsung dari data di Cache.
	Fungsi ini aktif sebagai default.
		";
		
$GLOBALS['phpAds_hlp_zone_cache_limit'] = "
        Jika Anda mengunakan Cached Zones, informasi dalam cache akan kadaluarsa. 
        Dalam periode yang ditentukan, program phpAdsNew akan bangun kembali isi
        dari cache, guna selalu menjamin data yang terbaru dalam cache tersebut.
	Setingan ini menentukan jangka waktu maksimal untuk reload data Zona dalam cache.
	Contoh: Bila setingan ini ditetapkan pada 600, isi cache akan di-rebuild
	jika umur Cached Zone lebih tua dari 10 menit (600 detik).
		";
		
$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = "
        Program phpAdsNew mengunakan tipe banner yang berbeda dan simpan 
        banner tersebut dengan cara yang berbeda. Pilihan pertama digunakan
	untuk simpan banner di lokasi lokal. Silakan gunakan Interface Admin 
        untuk upload banner. Program phpAdsNew akan simpan banner dalam 
        database MySQL (pilihan 1) atau di webserver (pilihan 2). 
        Banner yang disimpan pada webserver yang berbeda siap untuk dipakai
	begitupula (pilihan 3) atau silakan mengunakan kode html untuk generate
	banner baru (pilihan 4). Seluruh tipe banner mudah di-nonaktifkan
	dengan ubah setingan yang bersangkutan.
        Sebagai default seluruh tipe banner berada dalam posisi aktif.
      	Bila tipe banner tertentu di-nonaktifkan sedangkan masih ada tipe banner sejenis
        dalam antrian, program phpAdsNew tetap akan tampilkan banner tersebut.
        Izin untuk membuat banner baru dari tipe banner tersebut tidak diberikan.
		";
		
$GLOBALS['phpAds_hlp_type_web_mode'] = "
        Untuk mengunakan banner yang tersimpan pada webserver, settingan ini
        perlu diperhatikan. Untuk simpan banner pada direktori lokal, silakan
	set setingan ini ke posisi 0. Bila Anda ingin simpan banner pada FTP server
	eksternal , silakan ubah setingan ini ke posisi 1.
	Ada webserver tertentu yang menawarkan pengunaan FTP, meskipun 
        webserver yang bersangkutan berada dalam jaringan lokal.
		";
		
$GLOBALS['phpAds_hlp_type_web_dir'] = "
        Tentukan disini nama dan tempat untuk direktori upload banner. 
        Direktori yang dipilih harus memiliki write-access untuk PHP. Hal ini
        dapat dihasilkan dengan perubahan permission di sistem operasi
	UNIX/Linux untuk direktori yang bersangkutan (chmod). Lokasi direktori yang
	dipilih disini harus berada dalam posisi Document Root di Webserver.
	Webserver harus memiliki hak secukupnya untuk melayani files secara langsung.
	Jangan gunakan slash (/) dibelakang. Pilihan ini hanya perlu diperhatikan
	jika metode penyimpanan ditetapkan pada posisi 'Local Mode'.
		";
		
$GLOBALS['phpAds_hlp_type_web_ftp'] = "
        Sebutkan nama dan alamat FTP server untuk digunakan oleh program
	phpAdsNew sebagai tempat penyimpanan banner yang diupload. Direktori yang
	ditunjuk disini harus berada dalam posisi Document Root di Webserver.
	Webserver harus memiliki hak bebas untuk melayani files secara
	langsung. Alamat URL yang dipakai disini bebas mengandung Username,
	Kata Sandi, nama server dan path. 
		";
      
$GLOBALS['phpAds_hlp_type_web_url'] = "
        Jika Anda ingin simpan banner di sebuah webserver, program phpAdsNew
	perlu informasi tentang URL publik mana yang berkorespondensi dengan 
        direktori yang ditentukan diatas ini. Jangan gunakan slash (/) dibelakang.
		";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "
        Jika pilihan ini aktif phpAdsNew akan mengolah banner HTML secara aktif guna 
        mengizinkan seluruh Klik di-log oleh program. Dengan aktifkan setingan ini 
        cara perhitungan Klik berdasarkan basis per banner tetap bisa di nonaktifkan. 
		";
		
$GLOBALS['phpAds_hlp_type_html_php'] = "
        Izinkan phpAdsNew untuk mengeksekusi kode PHP yang berada
	dalam banner HTML. Fungsi ini sebagai default tidak aktif.
		";
		
$GLOBALS['phpAds_hlp_admin'] = "
        Username dari Administrator.  Silakan terapkan username untuk dipakai 
        juka login ke interface Administrator.
		";
		
$GLOBALS['phpAds_hlp_admin_pw'] = "
        Kata Sandi dari Administrator. Silakan pilih kata sandi untuk dipakai
	jika login lewat interface Administrator.
		";
		
$GLOBALS['phpAds_hlp_admin_fullname'] = "
        Nama lengkap dari Administrator. Data ini digunakan untuk pengiriman
	data statistik melalui e-mail.
		";
		
$GLOBALS['phpAds_hlp_admin_email'] = "
        Alamat e-mail dari Administrator. Data ini digunakan untuk pengiriman
	data statistik lewat e-mail.
		";
		
$GLOBALS['phpAds_hlp_admin_email_headers'] = "
        Fungsi ini digunakan untuk memanipulasi header dari e-mail yang
	dikirim secara otomatis oleh program phpAdsNew.
		";
		
$GLOBALS['phpAds_hlp_admin_novice'] = "
        Dengan fungsi ini secara otomatis akan terkirim e-mail	kepada
	Administrator, jika sebuah Client, sebuah Kampanye atau
	sebuah Banner terhapus dari sistem.
	Terapkan setingan ini di posisi True!
		";
		
$GLOBALS['phpAds_hlp_client_welcome'] = 
$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
       Dengan fungsi ini aktif, halaman pertama setelah Login yang akan tertampil
	pada layar Client adalah sebuah Welcome Screen. Silakan ubah kabar yang ditampil
	dengan mengedit file 'welcome.html' dalam direktori 'admin/templates'. 
        Data untuk diisi sebagai contoh: nama perusahaan Anda, Informasi Relasi,
	lambang perusahaan, sebuah Link, sebuah halaman dengan tarif beriklan dll.
		";
		
?>
