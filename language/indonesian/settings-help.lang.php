<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* Translation by Rachim Tamsjadi. Please send corrections              */
/* to tamsjadi@icqmail.com                                              */
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
        Tentukan username untuk dipakai oleh phpAdsNew untuk akses MySQL database server.
		";
		
$GLOBALS['phpAds_hlp_dbpassword'] = "
        Tentukan kata sandi yang dipakai oleh program phpAdsNew untuk mengakses MySQL database server.
		";
		
$GLOBALS['phpAds_hlp_dbname'] = "
        Tentukan nama database yang dipakai oleh phpAdsNew untuk menyimpan datanya.
		";
		
$GLOBALS['phpAds_hlp_persistent_connections'] = "
        Pemakaian koneksi persistent bisa menambah kecepatan kerja pada program phpAdsNew 
		sampai dengan efek meringankan daya load pada server. Ada kelemahannya, iaitu pada site yang 
		banyak dikunjungi oleh tamu daya load pada server bisa bertambah dan menbengkak dibandingkan dengan 
		stelan konfigurasi koneksi normal. Keputusan untuk memakai koneksi normal atau koneksi persistant tergantung 
		pada jumlah tamu pada site Anda dan perangkat keras yang digunakan untuk server. Bila phpAdsNew menyerap 
		tenaga server secara berkelebihan periksa setingan ini.
		";
		
$GLOBALS['phpAds_hlp_insert_delayed'] = "
        MySQL mengunci table selama proses penambahan data. Bila banyak tamu kunjungi site ada kemungkinan bisa 
		terjadi, phpAdsNew harus menunggu sebelum menambah baris baru pada table sehubungan database 
		masih terkunci. Bila insert delayed dipakai tidak terjadi hambatan tunggu dan baris tersebut akan 
		ditambah kepada table pada waktu sistem tidak dipakai oleh thread lain. 
		";
		
$GLOBALS['phpAds_hlp_table_prefix'] = "
        Jika database yang dipakai oleh phpAdsNew digunakan secara paralel dengan produk software yang lain keputusan pintar
		adalah menambah sebuah prefix kepada nama seluruh table. Jika lebih dari satu instalasi proram phpAdsNew dipakai
		dalam database yang sama perlu diperhatikan bahwa seluruh prefix untuk setiap instalasi harus unik.
		";
		
$GLOBALS['phpAds_hlp_tabletype'] = "
        MySQL support bermacam tipe table. Setiap tipe table mempunyai khas yang unik dan ada berberapa
		yang mampu mempercepat kinerja kerja program phpAdsNew. MyISAM adalah tipe table default yang tersedia
		pada semua instalasi database MySQL. Tipe table lain dari MyISAM dengan kemungkinan besar tidak tersedia pada server Anda.
		";
		
$GLOBALS['phpAds_hlp_url_prefix'] = "
        Untuk berfungsi dengan baik phpAdsNew perlu dibertahui dimana filenya tersimpan
        pada webserver. Silakan spesifikasikan URL direktori instalasi phpAdsNew,  
        seb. contoh: http://www.url-anda.com/phpAdsNew.
		";
		
$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
        Silakan isi disini path yang menunjuk kepada header files (e.g.: /home/login/www/header.htm) 
        untuk miliki sebuah header dan/atau footer di setiap halaman pada interface Admin. 
        Silakan pilih jenis text atau html (jika Anda menginginkan kode html dalam 
        salah satu atau dalam kedua file, jangan mengunakan tags seperti <body> atau <html>).
		";
		
$GLOBALS['phpAds_hlp_language'] = "
        Silakan tentukan disini bahasa awal yang dipakai oleh program phpAdsNew. Bahasa yang ditentukan
        disini akan dipakai sebagai bahasa awal pada interface Admin dan interface client. Perhatian: 
        Diperbolehkan untuk pakai bahasa yang berbeda untuk setiap Client diatur oleh interface Admin 
        dan memperbolehkan Client untuk memilih sendiri bahasa yang ditampilkan pada interface.
		";
		
$GLOBALS['phpAds_hlp_name'] = "
        Silakan tentukan sendiri nama yang dipakai untuk aplikasi ini. String yang dipakai 
        disini akan ditampilkan pada semua halaman di interface Admin dan interface Client. 
        Jika dikosongkan (default) logo program phpAdsNew akan tertampil pada layar.
		";
		
$GLOBALS['phpAds_hlp_company_name'] = "
        Nama yang dipakai disini akan tertampil pada e-mail yang dikirim secara otomatis 
	oleh program phpAdsNew.
		";
		
$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
        Biasanya terdeteksi sendiri oleh program phpAdsNew apakah GD library terinstal pada 
        server dan image format mana yang disuport oleh versi GD yang terinstal. Bagimanapun juga 
        tidak lepas dari kemungkinan terjadi deteksi yang tidak akurat atau salah. Ada juga versi 
        PHP yang tidak izinkan autodeteksi image format. Bila program phpAdsNew gagal autodeteksi 
        image format yang akur, silakan tentukan image format secara manual. Format yang didukung 
        adalah: none, png, jpeg atau gif.
		";
		
$GLOBALS['phpAds_hlp_p3p_policies'] = "
        Bila fungsi phpAdsNew' P3P Privacy Policies perlu diaktifkan silakan 
        pilih tanda On. 
		";
		
$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
        Policy Compact yang dikirim bersama dengan Cookie. Setingan default
        adalah: 'CUR ADM OUR NOR STA NID'. Setingan ini mengizinkan Internet Explorer 6 
        untuk terima Cookies yang digunakan oleh phpAdsNew. Bila Anda berminat silakan 
        ubah setingan disini sesuai dengan privacy statement perusahaan Anda.
		";
		
$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
        Bila full privacy policy diinginkan silakan tentukan lokasi 
        dari policy tersebut.
		";
		
$GLOBALS['phpAds_hlp_compact_stats'] = "
        Secara tradisional phpAdsNew mengunakan logging yang extensive dengan tingkat detail 
        yang sangat tinggi tetapi sistem ini memang membutuhukan banyak tenaga dari database server.
        Hal ini mampu untuk menjadi masalah bagi site dengan jumlah kunjungan tamu yang tinggi.
	Untuk mengatasi masalah ini phpAdsNew support tipe statistik yang baru, iaitu Compact Statistics. 
	Tipe ini juga lebih hemat pada database server tetapi disisi lainnya juga kurang dalam segi detail. 
	Tipe Compact Statistics hanya me-log statistik secara harian. Bila statistik dengan interval 60 menit 
	yang diperlukan, silakan ubah stelan Compact Statistics ke posisi Off.
		";
		
$GLOBALS['phpAds_hlp_log_adviews'] = "
        Biasanya setiap AdView di-log. Bila statistik tentang AdView tidak diinginkan 
        silakan ubah stelan ini ke posisi Off.
		";
		
$GLOBALS['phpAds_hlp_log_adclicks'] = "
        Biasanya setiap AdClick di-log. Bila statistik tentang AdClick tidak diinginkan 
        silakan ubah stelan ini ke posisi Off.
        	";
		
$GLOBALS['phpAds_hlp_reverse_lookup'] = "
        Program phpAdsNew me-log alamat IP dari setiap pengunjung secara default. Bila logging 
        domain names diinginkan silakan ubah stelan ini ke posisi On. Reverse lookup 
        perlu waktu; stelan ini mempengaruh kinerja kerja sistem.
		";
		
$GLOBALS['phpAds_hlp_ignore_hosts'] = "
        Bila Counting dari seluruh Clicks dan Views dari computer tertentu tidak diinginkan 
        silakan tambah computer tersebut kedalam array disini. Bila fungsi Reverse Lookup aktif 
        nama domain dan alamat IP diperbolehkan untuk diisi.  Bila fungsi Reverse Lookup tidak aktif 
        hanya alamat IP yang diperbolehkan untuk diisi disini. Silakan gunakan Wildcards
	(seperti '*.pintunet.com' or '192.168.*').
		";
		
$GLOBALS['phpAds_hlp_begin_of_week'] = "
        Pada umumnya awal minggu dianggap mulai pada setiap hari senin tetapi bila
        awal minggu perlu ditentukan pada hari minggu silakan gunakan stelan ini.
		";
		
$GLOBALS['phpAds_hlp_percentage_decimals'] = "
        Pilihan jumlah angka desimal yang ditampilkan pada halaman statistik.
		";
		
$GLOBALS['phpAds_hlp_warn_admin'] = "
        phpAdsNew can sent you e-mail if a client has only a limited number of 
        clicks or views left. This is turned on by default.
		";
		
$GLOBALS['phpAds_hlp_warn_client'] = "
        Program phpAdsNew mengirim e-mail kepada Client secara otomatis bila
        jumlah Clicks atau Views yang tertinggal mendekati Kosong.
	Fungsi ini dalam stelan On sebagai default.
		";
		
$GLOBALS['phpAds_hlp_warn_limit'] = "
        Limit yang ditentukan mulai kapan program phpAdsNew mengirim e-mail
        peringatan kepada Client. Default adalah 100.
		";
		
$GLOBALS['phpAds_hlp_retrieval_method'] = "
        Program phpAdsNew bisa mengunakan empat tipe untuk retrieval banner: Random banner 
        retrieval (default), Normal sequential banner retrieval, Weight 
        based sequential banner retrieval dan Full sequential banner retrieval.
      	Bila Anda mengunakan Zona, program phpAdsNew akan mengunakan sistem 
        random banner retrieval dan setingan disini dilewatkan.
		";
		
$GLOBALS['phpAds_hlp_con_key'] = "
        Program phpAdsNew mengunakan sebuah banner retrieval system yang sangat changgih.
        Untuk informasi lebih lanjut silakan baca bagian API pada dokumentasi. Dengan
	stelan ini fungsi Conditional Keywords diaktifkan.
	Fungsi ini aktif sebagai default.
		";
		
$GLOBALS['phpAds_hlp_mult_key'] = "
        Untuk setiap banner diperbolehkan untuk menentukan lebih dari satu Keyword.
        Stelan ini diperlukan bila lebih dari satu keyword digunakan.
        Fungsi ini aktif sebagai default.
		";
		
$GLOBALS['phpAds_hlp_acl'] = "
        Bila tidak ada limitasi dalam cara penampilan silakan disable 
        ACL Checking dengan parameter ini. Stelan ini mempengaruh kecepatan
	program phpAdsNew.
		";
		
$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = "
        Bila program phpAdsNew tidak sukses membangun koneksi ke database server,
	atau bila tidak diketemukan banner yang sesuai, seandainya setelah terjadi
	Crash atau penghapusan data pada database, tampilan pada halaman akan kosong.
	Berberapa User ingin menampilkan banner default jika hal tersebut terjadi. 
        Banner default yang ditentukan disini tidak tercatat dalam Log dan tidak
	ditampilkan jika masih ada banner lain yang aktif dalam database.
	Fungsi ini tidak aktif sebagai default.
		";
		
$GLOBALS['phpAds_hlp_zone_cache'] = "
        Bila Anda ingin mengunakan fungsi Zona, setting ini beri izin kepada program phpAdsNew
	untuk simpan Banner Information dalam Cache guna siap dipakai setiap waktu. 
        Fungsi ini akan mempengaruhi kecepatan program phpAdsNew secara positif,
	soalnya tidak perlu lagi mencari Zone Information dan mengakses Banner Information 
        untuk pada akhirnya memilih banner yang diperlukan. Program phpAdsNew tinggal
	perlu mengisi kembali Cache. Fungsi ini aktif sebagai default.
		";
		
$GLOBALS['phpAds_hlp_zone_cache_limit'] = "
        Bila Anda mengunakan Cached Zones, informasi dalam cache bisa kelewat kadaluarsa. 
        Dalam jangka waktu ke waktu program phpAdsNew perlu bangun kembali isi
        dari cache, guna untuk mengubah dan mengupdate isi dari cache tersebut. Setingan
        ini menentukan waktu untuk reload zona yang bersangkutan kedalam cache dengan
	mengisi jangka waktu maksimal dari Cached Zone tersebut. Contoh: Bila setting ini
	ditetapkan pada 600, isi cache akan di-rebuild jika Cached Zone lebih tua dari
	10 menit (600 detik).
		";
		
$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = "
        Program phpAdsNew bisa mengunakan tipe banner yang berbeda dan simpan 
        banner tersebut dengan cara yang berbeda. Pilihan kedua pertama digunakan
	untuk simpan banner di lokasi lokal. Silakan gunakan Interface Admin 
        untuk upload banner dan program phpAdsNew akan simpan banner dalam 
        database MySQL (pilihan 1) atau di webserver (pilihan 2). 
        Banner yang disimpan pada webserver lain siap dipakai begitupula (pilihan 3) 
        atau silakan mengunakan kode html untuk generate sebuah banner (pilihan 4).
	Seluruh tipe tersebut mudah di-nonaktifkan dengan ubah settingan yang bersangkutan.
        Sebagai default semua tipe banner berada dalam posisi aktif.
      	Bila tipe banner tertentu di-nonaktifkan sedangkan masih ada tipe banner sejenis
        dalam antrian, program phpAdsNew akan beri izin untuk tampilkan banner tersebut.
        Izin untuk membuat banner baru dari tipe banner ini tidak diberikan.
		";
		
$GLOBALS['phpAds_hlp_type_web_mode'] = "
        Bila Anda ingin mengunakan banner yang tersimpan pada webserver,
        Anda perlu perhatikan settingan ini. Untuk simpan banner pada
	direktori lokal, silakan set pilihan ini ke posisi 0. Jika Anda ingin
	simpan banner pada external FTP server, silakan set pilihan ini ke posisi 1.
	Ada webserver tertentu yang mengizinkan pengunaan pilihan FTP, meskipun 
        webserver yang bersangkutan berada dalam jaringan lokal.
		";
		
$GLOBALS['phpAds_hlp_type_web_dir'] = "
        Sebutkan nama direktori dan tempat sebagai direktori Upload banner. 
        Direktori yang dipilih harus memiliki write-access untuk PHP. Hal ini
        biasanya diatasi dengan ubah permission pada UNIX/Linux dan untuk direktori
        yang bersangkutan (chmod). Direktori yang ditunjuk disini perlu berada
	dalam posisi document root webserver. Webserver harus bebas untuk melayani
	files secara langsung. Jangan gunakan slash (/) dibelakang. Pilihan ini
	hanya perlu diperhatikan jika metode penyimpanan ditetapkan pada posisi
	'Local Mode'.
		";
		
$GLOBALS['phpAds_hlp_type_web_ftp'] = "
        Sebutkan nama dan alamat FTP server yang digunakan oleh program
	phpAdsNew sebagai penyimpanan banner yang diupload. Direktori yang
	ditunjuk disini perlu berada dalam posisi document root webserver.
	Webserver harus mempunyai hak bebas untuk melayani files secara
	langsung. Alamat URL yang dipakai disini bebas mengandung Username,
	Kata Sandi, nama server dan path. 
		";
      
$GLOBALS['phpAds_hlp_type_web_url'] = "
        Bila Anda ingin simpan banner di sebuah webserver program phpAdsNew
	perlu informasi tentang URL publik mana yang berkorespondensi dengan 
        direktori yang ditentukan diatas ini. Jangan gunakan slash (/) dibelakang.
		";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "
        Jika pilihan ini aktif phpAdsNew akan mengolah banner HTML secara aktif guna 
        mengizinkan seluruh Clicks di-log oleh program. Dengan aktifkan pilihan ini 
        cara perhitungan Clicks bedasarkan basis per banner tetap bisa di nonaktifkan. 
		";
		
$GLOBALS['phpAds_hlp_type_html_php'] = "
        Beri izin kepada program phpAdsNew untuk eksekusi kode PHP yang berada dalam
	banner HTML. Fungsi ini tidak aktif sebagai default.
		";
		
$GLOBALS['phpAds_hlp_admin'] = "
        Username Administrator;  silakan terapkan username yang dipakai sewaktu 
        login ke interface administrator.
		";
		
$GLOBALS['phpAds_hlp_admin_pw'] = "
        Kata Sandi Administrator; silakan pilih kata sandi untuk dipakai
	sewaktu login lewat interface administrator.
		";
		
$GLOBALS['phpAds_hlp_admin_fullname'] = "
        Nama lengkap dari Administrator sistem ini. Data ini diperlukan untuk mengirim
	data statistik lewat e-mail.
		";
		
$GLOBALS['phpAds_hlp_admin_email'] = "
        Alamat e-mail dari Administrator. Data ini diperlukan untuk mengirim
	data statistik lewat e-mail.
		";
		
$GLOBALS['phpAds_hlp_admin_email_headers'] = "
        Fungsi ini untuk manipulasi header dari e-mail yang dikirim oleh phpAdsNew.
		";
		
$GLOBALS['phpAds_hlp_admin_novice'] = "
        Bila Anda ingin terima Peringatan sebelum Client, Kampanye atau Banner
	dihapus terapkan pilihan ini di posisi True.
		";
		
$GLOBALS['phpAds_hlp_client_welcome'] = 
$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
       Bila fungsi ini aktif halaman pertama setelah Login yang akan tertampil pada
	Client adalah sebuah Welcome Message. Silakan ubah kabar tersebut dengan
	mengedit file 'welcome.html' dalam direktori 'admin/templates'. 
        Data untuk diisi sebagai contoh: nama perusahaan Anda, Informasi Relasi,
	lambang perusahaan, sebuah Link, sebuah halaman dengan tarif beriklan dll.
		";
		
?>
