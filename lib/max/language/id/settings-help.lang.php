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

// Settings help translation strings
$GLOBALS['phpAds_hlp_dbhost'] = "
        Menetapkan nama Host untuk ".$phpAds_dbmsname." database server yang ingin digunakan untuk koneksi.
		";
		
$GLOBALS['phpAds_hlp_dbport'] = "
        Menetapkan nomor dari port database server yang ingin digunakan untuk koneksi ke ".$phpAds_dbmsname.".  
		Nomor port Default untuk database ".$phpAds_dbmsname." adalah <i>".
		($phpAds_dbmsname == 'MySQL' ? '3306' : '5432')."</i>.
		";

$GLOBALS['phpAds_hlp_dbuser'] = "
        Menetapkan nama user yang digunakan oleh ".$phpAds_productname." untuk mengakses ".$phpAds_dbmsname." database server.
		";
		
$GLOBALS['phpAds_hlp_dbpassword'] = "
        Menetapkan kata sandi yang digunakan oleh ".$phpAds_productname." untuk mengakses database server ".$phpAds_dbmsname.".
		";
		
$GLOBALS['phpAds_hlp_dbname'] = "
        Menetapkan nama database yang digunakan oleh ".$phpAds_productname." untuk menyimpan data. 
		Penting: Database harus sudah dibuat pada database server. ".$phpAds_productname." <b>tidak</b> 
		membuat database dengan sendirinya bila database tersebut belu tersedia.
		";
		
$GLOBALS['phpAds_hlp_persistent_connections'] = "
	Penggunaan koneksi persistent sangat mempercepatkan ".$phpAds_productname." dan 
		meringankan beban pada server. Tetapi hal ini ada kekurangan, yaitu bilamana situs Anda 
		dikunjungi oleh banyak pengunjung justru beban pada server bisa meningkat lebih drastis 
		dibandingkan dengan pengunaan koneksi biasa. Pertimbangan apakah sebaiknya Anda mengunakan 
		koneksi biasa atau koneksi persistant tergantung pada jumlah pengunjung dan pada Hardware 
		yang dipakai. Bila ".$phpAds_productname." mengunakan tenaga server yang berkelebihan, 
		disarankan untuk periksa penyetelan ini paling pertama. 
		";
		
$GLOBALS['phpAds_hlp_compatibility_mode'] = "
	Bila Anda mengalami masalah dalam integrasi ".$phpAds_productname." dengan sebuah produk lain 
		cobalah aktivasikan Database Compatibility Mode. Bila Anda mengunakan invokasi Local Mode 
		sedangkan posisi dari Compatibility Mode berada dalam posisi On, ".$phpAds_productname." 
		akan membiarkan status pada koneksi ke database dalam keadaan seperti sebelum 
		".$phpAds_productname." dijalankan. Stelan ini agak lebih lambat (hanya sedikit) dan soal 
		itu dalam posisi Off secara Default. 
		";
		
$GLOBALS['phpAds_hlp_table_prefix'] = "
	Bilamana database yang digunakan oleh ".$phpAds_productname." dibagi bersama-sama produk software yang 
		lain, lebih arif kalau Anda menggunakan sebuah <i>Prefix</i> untuk nama tabel. Bila Anda menggunakan lebih dari 
		satu instalasi dari ".$phpAds_productname." dalam database yang sama perlu dipastikan, bahwa Prefix 
		yang digunakan untuk setiap instalasi adalah unik.
		";

$GLOBALS['phpAds_hlp_table_type'] = "
        ".$phpAds_dbmsname." mendukung berberapa jenis tabel. Setiap jenis tabel memiliki khas tersendiri dan diantaranya 
		ada berberapa jenis yang mampu untuk amat mempercepat ".$phpAds_productname." Jenis tabel MyISAM adalah jenis 
		Default dan tersedia pada semua instalasi dari ".$phpAds_dbmsname.". Ada kemungkinan bahwa jenis tabel yang 
		lain tidak tersedia pada server Anda
		";

$GLOBALS['phpAds_hlp_url_prefix'] = "
        Untuk befungsi dengan baik ".$phpAds_productname." harus mengenal lokasi dirinya pada web server. 
		Anda perlu menetapkan URL ke direktori penyimpanan ".$phpAds_productname.", seb. contoh: 
		http://www.url-anda.com/".$phpAds_productname.".
		";
		
$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
	Disini Anda perlu menetapkan <i>Path</i> ke file Header (contoh: /home/login/www/header.htm) 
		untuk mengadakan sebuah header dan/atau footer pada setiap halaman di Interface Admin. 
		Diperbolehkan untuk menggunakan teks atau html dalam file tersebut (bila Anda ingin
		menggunakan html dalam satu atau kedua filenya jangan menggunakan <i>Tags</i> seperti <body> 
		atau <html>).
		";
		
$GLOBALS['phpAds_hlp_content_gzip_compression'] = "
	Dengan membolehkan kompresi GZIP Anda akan dapat mengurangi data yang dikirim kepada browser 
		setiap kalinya Interface Administrator dibuka yang cukup besar. Untuk mengaktifkan 
		fasilitas ini minimal versi PHP 4.0.5 dengan ekstensi GZIP perlu terinstal pada 
		server Anda.
		";
		
$GLOBALS['phpAds_hlp_language'] = "
	Menentukan bahasa yang digunakan oleh ".$phpAds_productname." sebagai Default. Bahasa 
		yang dipilih disini menjadi bahasa yang Default untuk Interface Admin dan untuk 
		Interface Pemasang Iklan. Mohon perhatikan: Diperbolehkan untuk menentukan bahasa 
		yang berbeda untuk setiap Pemasang Iklan pada Interface Admin termasuk izin 
		kepada Pemasang Iklan untuk memilih bahasa sesuai selera sendiri.
		";
		
$GLOBALS['phpAds_hlp_name'] = "
	Menentukan nama yang digunakan untuk aplikasi ini. Kata-kata yang diisi disini akan 
		ditampilkan pada seluruh halaman di Interface Admin dan Interface Pemasang Iklan. 
		Bila kotak ini tidak diisi (default) maka sebuah lambang dari ".$phpAds_productname." 
		akan tertampil pada halaman-halaman tersebut.
		";
		
$GLOBALS['phpAds_hlp_company_name'] = "
	Nama ini akan digunakan dalam E-Mail yang dikirim oleh ".$phpAds_productname.".
		";
		
$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
	Pada umumnya ".$phpAds_productname." akan mendeteksi secara otomatis apakah GD Library 
		terintal pada server Anda dan format apa saja yang didukung oleh versi GD tersebut. 
		Tetapi tetap bisa terjadi bahwa deteksi tersebut kurang akurat atau salah sehubungan 
		beberapa versi PHP tidak mengizinkan deteksi format gambar apa saja yang didukung. 
		Bila ".$phpAds_productname." gagal mendeteksi format gambar yang akurat Anda bisa menentukan 
		format yang benar disini. Nilai yang diperbolehkan adalah: none, png, jpeg, gif.
		";
		
$GLOBALS['phpAds_hlp_p3p_policies'] = "
	Bila Anda ingin mengaktifkan P3P Privacy Policies dari ".$phpAds_productname.", Anda 
		perlu mengubah stelan ini ke posisi On.
		";
		
$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
	Policy Kompak yang dikirim bersamaan dengan Cookie. Stelan Default adalah: 
		'CUR ADM OUR NOR STA NID' yang mengizinkan Internet Explorer 6 untuk terima 
		Cookie yang digunakan oleh ".$phpAds_productname.". Anda diperbolehkan untuk 
		menentukan Privacy Statement lain sesuai dengan apa yang digunakan oleh webserver 
		Anda disini.
		";
		
$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
	Bila Anda ingin menggunakan Private Policy yang penuh, Anda bisa menentukan lokasi dari 
		Policy tersebut disini.
		";
		
$GLOBALS['phpAds_hlp_compact_stats'] = "
	Secara tradisional ".$phpAds_productname." melakukan pencatatan yang sangat luas dan terperinci 
		tetapi fasilitas ini mengakibatkan beban yang sangat besar pada database server. Hal ini 
		bisa membawa masalah pada situs dengan jumlah pengunjung yang tinggi. Untuk mengatasi masalah 
		tersebut ".$phpAds_productname." mendukung jenis statistik yang baru, yaitu Statistik Kompak 
		yang tidak terlalu membebankan database server tetapi tidak terlalu terperinci dalam catatannya. 
		Statistik Kompak mengkumpulkan jumlah AdViews dan jumlah AdClicks untuk setiap jam saja. Bila 
		Anda inginkan statistik yang terperinci, fungsi Statistik Kompak perlu dimatikan.
		";
		
$GLOBALS['phpAds_hlp_log_adviews'] = "
	Biasanya seluruh AdViews dicatat oleh ".$phpAds_productname.". Bila Anda tidak ingin mengetahui 
		statistik tentang AdViews, fungsi ini perlu dimatikan.
		";
		
$GLOBALS['phpAds_hlp_block_adviews'] = "
	Setiap kalinya seseorang pengunjung menampilkan ulang sebuah halaman, ".$phpAds_productname." akan 
		mencatat satu AdView. Fungsi ini menjaminkan, bahwa hanya satu AdView akan tercatat untuk 
		setiap banner unik dalam jangka waktu detik yang ditentukan oleh Anda. Sebagai contoh: 
		Bila Anda menentukan jangka waktu 300 detik, ".$phpAds_productname." hanya akan mencatat 
		AdViews bilamana banner yang sama belum ditampilkan kepada pengunjung yang bersangkutan 
		selama 5 menit terakhir. Fungsi ini hanya bekerja dengan cukup baik bila 
		browser pengunjung menerima Cookies.
		";
		
$GLOBALS['phpAds_hlp_log_adclicks'] = "
	Biasanya seluruh AdClicks dicatat oleh ".$phpAds_productname.". Bila Anda tidak ingin mengetahui 
		statistik tentang AdClicks, fungsi ini perlu dimatikan.
		";
		
$GLOBALS['phpAds_hlp_block_adclicks'] = "
	Bila seorang pengunjung meng-klik berulang-ulang sebuah banner, ".$phpAds_productname." akan 
		mencatat satu AdClick setiap kalinya. Fungsi ini menjaminkan, bahwa hanya satu AdClick 
		akan tercatat untuk setiap banner unik dalam jangka waktu detik yang ditentukan oleh Anda. 
		Sebagai contoh: Bila Anda menentukan jangka waktu 300 detik, ".$phpAds_productname." hanya 
		akan mencatat AdClicks bilamana banner yang sama belum di-klik oleh pengunjung yang bersangkutan 
		selama 5 menit terakhir. Fungsi ini hanya bekerja dengan cukup baik bila browser dari 
		pengunjung terima Cookies.
		";
				
$GLOBALS['phpAds_hlp_geotracking_stats'] = "
	Bila Anda menggunakan database untuk <i>Geotargeting</i>, Anda diperbolehkan untuk menyimpan informasi 
		geografis dalam database. Jika fungsi ini diaktifkan Anda dapat mengikuti statistik tentang 
		lokasi asal dari pengunjung dan performa dari setiap banner pada negara-negara berbeda. 
		Pilihan ini hanya tersedia bilamana Anda menggunakan statistik <i>Verbose</i>. 	
		";
		
$GLOBALS['phpAds_hlp_reverse_lookup'] = "
	Nama dari host pada umumnya ditentukan oleh web server tetapi kadang-kadang fasilitas ini tidak diaktifkan. 
		Bila Anda ingin menggunakan nama host dari pengunjung dalam batas penyampaian dan/atau ingin 
		mempertahankan statistik tentang ini tetapi server tidak menyediakan informasi tersebut, pilihan 
		ini perlu dimatikan. Penentuan nama host dari pengunjung membutuhkan waktu yang cukup lama; 
		hal ini akan memperlambat penyampaian banner.
		";
		
$GLOBALS['phpAds_hlp_proxy_lookup'] = "
	Beberapa pengunjung menggunakan proxy server untuk mengakses Internet. Dalam hal ini 
		".$phpAds_productname." akan mencatat nomor IP atau nama Host dari proxy server 
		tetapi bukan dari pengunjung. Bila fungsi ini diaktifkan, ".$phpAds_productname." 
		akan mencoba untuk temukan alamat pengunjung dibelakang proxy server. Bila alamat 
		sebenarnya tidak bisa ditemukan, akan tercatat alamat dari proxy server. Fungsi ini 
		tidak aktif secara default, sehubungan ia memperlambat pencatatan. 
		";
		
$GLOBALS['phpAds_hlp_auto_clean_tables'] = 
$GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "
	Bila Anda ingin gunakan fasilitas ini, statistik yang diperolehkan akan dihapus secara otomatis 
		setelah periode yang ditentukan pada kotak ini tercapai. Sebagai contoh: Bila Anda tentukan 
		jangka waktu 5 minggu, statistik yang melebihi jangka waktu 5 minggu akan dihapus secara 
		otomatis.	
		";
		
$GLOBALS['phpAds_hlp_auto_clean_userlog'] = 
$GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "
	Pilihan ini akan menghapus semua catatan dari <i>Userlog</i> yang masa waktunya melebihi jumlah 
		minggu yang telah ditentukan pada kotak	dibawah ini.
		";
		
$GLOBALS['phpAds_hlp_geotracking_type'] = "
	<i>Geotargeting</i> mengizinkan ".$phpAds_productname." untuk mengubah alamat IP dari pengunjung ke 
		informasi geografis. Bedasarkan informasi ini Anda bisa menentukan batas penyampaian atau 
		menyimpan informasi guna untuk melihat negara yang mana yang memperoleh <i>Impressions</i> 
		atau <i>Click-trus</i> paling banyak. Bila Anda aktifkan <i>Geotargeting</i> Anda perlu 
		pilih jenis database yang digunakan. ".$phpAds_productname." pada saat ini mendukung database 
		<a href='http://hop.clickbank.net/?phpadsnew/ip2country' target='_blank'>IP2Country</a> 
		atau <a href='http://www.maxmind.com/?rId=phpadsnew' target='_blank'>GeoIP</a>.	
		";
		
$GLOBALS['phpAds_hlp_geotracking_location'] = "
	Kecuali kalau Anda menggunakan modul GeoIP Apache, Anda perlu beritahukan database <i>Geotargeting</i> 
		yang ingin digunakan kepada ".$phpAds_productname.". Disarankan untuk menyimpan database yang 
		digunakan diluar document root dari web server untuk menghindarkan database tersebut bisa di-
		download oleh pengguna. 
		";
		
$GLOBALS['phpAds_hlp_geotracking_cookie'] = "
	Ubah alamat IP ke informasi geografis akan membutuhkan waktu yang cukup lama. Untuk menghindarkan perubahan 
		ini dilakukan setiapkalinya sebuah banner disampaikan oleh ".$phpAds_productname.", hasil perubahan 
		bisa disimpan dalam sebuah <i>Cookie</i>. Bila Cookie tersebut ini tersedia, ".$phpAds_productname." 
		akan gunakan informasi ini dan tidak lagi perlu mengubah alamat IP.
		";
		
$GLOBALS['phpAds_hlp_ignore_hosts'] = "
	Bila Anda ingin menghindar perhitungan Clicks dan Views oleh komputer tertentu, komputer-
		komputer tersebut bisa dicatat pada daftar ini. Bila fasilitas <i>Reverse Lookup</i> diaktifkan, 
		Anda diperbolehkan untuk mencatat nama domain dan nomor IP disini. Bila fasilitas 
		<i>Reverse Lookup</i> tidak aktif, hanya nomor IP diperbolehkan disini. Anda boleh gunakan 
		Wildcards (contoh '*.altavista.com' or '192.168.*').
		";
		
$GLOBALS['phpAds_hlp_begin_of_week'] = "
	Pada umumnya sebuah minggu dimulai dengan hari senin. Bila Anda ingin memulai minggu 
		pada hari minggu, silakan tentukannya disini.
		";
		
$GLOBALS['phpAds_hlp_percentage_decimals'] = "
	Menentukan jumlah angka desimal pada halaman statistik.
		";
		
$GLOBALS['phpAds_hlp_warn_admin'] = "
	".$phpAds_productname." dapat mengirim E-mail, bilamana sisa Clicks atau sisa Views di 
	sebuah kampanye tinggal sedikit. Fasilitas ini aktif sebagai default.
		";
		
$GLOBALS['phpAds_hlp_warn_client'] = "
	".$phpAds_productname." dapat mengirim E-mail kepada Pemasang Iklan, bilamana sisa Clicks 
	atau sisa Views tinggal sedikit. Fasilitas ini aktif sebagai default.
		";
		
$GLOBALS['phpAds_hlp_qmail_patch'] = "
	Beberapa versi dari program qmail mengandung sebuah bug yang mengakibatkan ".$phpAds_productname." 
		tampilkan Headers dalam badan dari E-Mail. Bila Anda aktifkan fungsi ini, ".$phpAds_productname." 
		akan mengirimkan E-Mail dalam format yang kompatibel.
		";
		
$GLOBALS['phpAds_hlp_warn_limit'] = "
	Batas yang memerintah ".$phpAds_productname." untuk mengirim E-mail Peringatan. Angka 
	default adalah 100.
		";
		
$GLOBALS['phpAds_hlp_allow_invocation_plain'] = 
$GLOBALS['phpAds_hlp_allow_invocation_js'] = 
$GLOBALS['phpAds_hlp_allow_invocation_frame'] = 
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] = 
$GLOBALS['phpAds_hlp_allow_invocation_local'] = 
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] = 
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "
	Dengan penyetelan ini Anda tentukan jenis invokasi yang diperbolehkan. Jenis invokasi 
		yang di-tidakaktifkan disini tidak akan tersedia dalam fungsi pembuatan kode invokasi 
		/ kode banner secara otomatis. Penting: Metode-metode invokasi tetap berfungsi bila 
		di-tidakaktifkan tetapi tidak lagi tersedia untuk di-generate.
		";
		
$GLOBALS['phpAds_hlp_con_key'] = "
	".$phpAds_productname." memiliki sistem pencarian yang sangat kuat dengan menggunakan 
		seleksi langsung. Untuk informasi lebih lanjut mohon konsultasikan buku pedoman. Dengan 
		opsi ini Anda menghidupkan fungsi Kata Kunci Konditional. Stelan ini berada dalam 
		posisi On secara Default.
		";
		
$GLOBALS['phpAds_hlp_mult_key'] = "
	Bila Anda gunakan seleksi langsung untuk menampilkan banner Anda diperbolehkan untuk 
		menggunakan satu atau lebih kata kunci untuk setiap banner. Opsi ini harus di 
		posisi On bila Anda ingin menentukan lebih dari satu kata kunci. Stelan ini berada 
		dalam posisi On secara Default.
		";
		
$GLOBALS['phpAds_hlp_acl'] = "
	Bila Anda tidak menggunakan pembatasan penyampaian silakan matikan opsi ini dengan parameter 
		ini. Stelan yang berada dalam posisi Off akan meningkatkan kecepatan dari 
		".$phpAds_productname.".
        	";
		
$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = "
	Bila ".$phpAds_productname." gagal menghubungi database server atau tidak bisa temukan banner 
		yang sesuai didasarkan database <i>crashed</i> atau terhapus, ia tidak akan menampilkan 
		apapun. Berberapa pengguna ingin menentukan banner default yang tertampil bila terjadinya 
		serupa. Banner default yang ditentukan disini tidak akan dicatat dan tidak ditampilkan 
		selama masih ada banner yang aktif dalam database. Stelan ini berada dalam posisi Off 
		secara Default.
		";
		
$GLOBALS['phpAds_hlp_delivery_caching'] = "
	Guna untuk mempercepat penyampaian, ".$phpAds_productname." menggunakan sebuah Cache yang berisi 
		seluruh informasi yang diperlukan untuk menyampaikan banner kepada pengunjung halam web 
		Anda. Cache penyampaian ini secara default akan disimpan pada database. Untuk meningkatkan 
		kecepatan diperbolehkan untuk menyimpan Cache tersebut dalam file atau dalam <i>shared 
		memory</i>. Shared memory adalah yang paling cepat, penyimpanan dalam file juga cukup 
		cepat. Tidak disarankan untuk mematikan Cache penyampaian sehubungan hal ini akan benar-
		benar berpengaruh pada performa.
		";
		
$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = 
$GLOBALS['phpAds_hlp_type_txt_allow'] = "
        ".$phpAds_productname." siap untuk mengolah jenis banner yang berbeda dengan cara 
		yang berbeda. Penyetelan pertama dan kedua digunakan untuk penyimpanan banner 
		secara lokal. Silakan gunakan Interface Administrator untuk meng-upload banner, 
		".$phpAds_productname." akan menyimpan banner tersebut dalam database SQL atau 
		di web server. Menyimpan banner di sebuah web server eksternal diperbolehkan, 
		silakan gunakan HTML atau teks biasa untuk membuat banner.
		";
		
$GLOBALS['phpAds_hlp_type_web_mode'] = "
	Bila Anda ingin menggunakan banner yang disimpan pada web server, penyetelan disini perlu 
		dilakukan. Untuk simpan banner dalam direktori lokal penyetelan ini harus ditetapkan 
		pada posisi <i>Direktori Lokal</i>. Bila Anda ingin simpan banner pada FTP 
		Server eksternal, penyetelan ini harus berada pada posisi <i>FTP Server 
		Eksternal</i>. Pada web server tertentu Anda ingin menggunakan penyimpanan FTP, 
		meskipun di web server lokal.
		";
		
$GLOBALS['phpAds_hlp_type_web_dir'] = "
	Menetapkan direktori yang akan digunakan oleh ".$phpAds_productname." untuk meng-upload 
		banner. PHP harus diberi izin untuk menulis dalam direktori tersebut yang berarti, 
		Anda kemungkinan perlu ubah hak Unix (chmod) untuk direktori ini. Direktori yang 
		ditepatkan disini harus terletak dalam <i>Document Root</i> sehubungan web server 
		harus melayani file-file yang bersangkutan secara langsung. Tidak diperbolehkan 
		tanda <i>Slash</i> (/) di ujung. Anda diharuskan untuk mengkonfigurasikan 
		fungsi ini bila metode penyimpanan yang digunakan di <i>Direktori Lokal</i>.
		";
		
$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "
	Bila Anda menetapkan metode penyimpanan pada <i>Server FTP Eksternal</i>, Anda perlu 
		tepatkan alamat IP atau nama domain dari Server FTP Eksternal tersebut, yang akan 
		digunakan oleh ".$phpAds_productname." untuk meng-upload banner.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "
	Bila Anda menetapkan metode penyimpanan pada <i>Server FTP Eksternal</i>, Anda perlu 
		tepatkan sebuah direktori dari Server FTP Eksternal tersebut, yang akan digunakan 
		oleh ".$phpAds_productname." untuk meng-upload banner.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "
	Bila Anda menetapkan metode penyimpanan pada <i>Server FTP Eksternal</i>, Anda perlu 
		berikan nama pengguna yang akan digunakan oleh ".$phpAds_productname." untuk buka 
		koneksi ke Server FTP Eksternal yang bersangkutan.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "
	Bila Anda menetapkan metode penyimpanan pada <i>Server FTP Eksternal</i>, Anda perlu 
		berikan kata sandi yang akan digunakan oleh ".$phpAds_productname." untuk buka 
		koneksi ke Server FTP Eksternal yang bersangkutan.
		";
      
$GLOBALS['phpAds_hlp_type_web_url'] = "
	Bila Anda menyimpan banner dalam web server ".$phpAds_productname." perlu diberitahui, 
		URL umum mana yang berkorespondensi dengan direkori yang ditepatkan dibawah ini. 
		Tidak diperbolehkan tanda <i>Slash</i> (/) di ujung URL yang ditepatkan disini.
		";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "
	Bila fungsi ini ditepatkan pada posisi ON, ".$phpAds_productname." akan mengubah banner 
		HTML guna mencatat Clicks pada banner tersebut. Meskipun fasilitas ini berada dalam 
		posisi On, Anda tetap diperbolehkan untuk tentukannya atas dasar per banner. 
		";
		
$GLOBALS['phpAds_hlp_type_html_php'] = "
	".$phpAds_productname." memungkinkan untuk mengeksekusi kode PHP yang terletak dalam 
		banner HTML. Fungsi ini ditepatkan dalam posisi OFF secara default.
		";
		
$GLOBALS['phpAds_hlp_admin'] = "
	Silakan isi nama pengguna dari Administrator. Dengan nama pengguna tersebut Anda 
		diperbolehkan untuk me-login ke Interface Administrator.
		";
		
$GLOBALS['phpAds_hlp_admin_pw'] =
$GLOBALS['phpAds_hlp_admin_pw2'] = "
	Silakan ketik kata sandi yang ingin digunakan untuk me-login ke Interface Administrator.
		Kata sandi perlu diketik berulang dua kali untuk menghindar kekeliruan pengetetikan.
		";
		
$GLOBALS['phpAds_hlp_pwold'] = 
$GLOBALS['phpAds_hlp_pw'] = 
$GLOBALS['phpAds_hlp_pw2'] = "
	Untuk mengubah kata sandi dari Administrator, Anda perlu sebutkan kata sandi yang lama 
		diatas. Kata sandi yang baru perlu diketik berulang dua kali untuk hindari kekeliruan 
		sewaktu penggantian kata sandi.
		";
		
$GLOBALS['phpAds_hlp_admin_fullname'] = "
	Nama lengkap dari Administrator. Nama yang tercantum disini digunakan untuk mengirim statistik 
		melalui E-Mail.
		";
		
$GLOBALS['phpAds_hlp_admin_email'] = "
	Alamat E-Mail dari Administrator. Alamat ini digunakan sebagai alamat dari pengirim 
		setiap kalinya E-Mail tentang statistik dikirim.
		";
		
$GLOBALS['phpAds_hlp_admin_email_headers'] = "
	Anda diperbolehkan untuk mengubah header dari E-Mail yang dikirim oleh ".$phpAds_productname.".
		";
		
$GLOBALS['phpAds_hlp_admin_novice'] = "
	Bila Anda ingin menerima peringatan sebelum menghapus Pemasang Iklan, kampanye, banner, 
		penerbit dan zona tepatkan penyetelan ini ke <i>True</i>.
		";
		
$GLOBALS['phpAds_hlp_client_welcome'] = "
	Bila fasilitas ini ditepatkan pada posisi On, sebuah kabar Selamat Datang akan ditampilkan 
		pada halaman pembuka setelah Pemasang Iklan login. Anda diperbolehkan untuk ubah 
		kabar ini sesuai keinginan Anda dengan meng-edit file welcome.html yang terletak pada 
		direktori admin/templates. Mungkin Anda ingin menambahkan nama perusahaan, informasi 
		tentang alamat, lambang perusahaan, sebuah link ke halaman harga untuk beriklan di 
		situs Anda dll..
		";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
	Daripada meng-edit file welcome.html, Anda diperbolehkan untuk mengisi kabar disini. Bila Anda 
		tulis teks disini, file welcome.html akan diabaikan. Diperbolehkan untuk menggunakan 
		<i>HTML Tags</i> disini.
		";
		
$GLOBALS['phpAds_hlp_updates_frequency'] = "
	Bila Anda ingin tahu apakah sudah tersedia versi baru dari ".$phpAds_productname.", fungsi ini 
		harus ditepatkan pada  posisi On. Diperbolehkan untuk menentukan jarak waktu yang berulang, 
		".$phpAds_productname." akan membuka koneksi ke update server tersendiri. Jika ditemukan 
		versi yang baru, sebuah kabar akan muncul untuk memberikan informasi tambahan tentang 
		update tersebut.
		";
		
$GLOBALS['phpAds_hlp_userlog_email'] = "
	Bila Anda ingin simpan salinan dari seluruh E-Mail yang dikirim oleh ".$phpAds_productname.", 
		fungsi ini harus ditepatkan pada posisi On. Seluruh E-Mail akan tersimpan dalam 
		<i>Userlog</i>.
		";
		
$GLOBALS['phpAds_hlp_userlog_priority'] = "
	Untuk memastikan bahwa kalkulasi prioriti sudah berjalan dengan baik, Anda bisa menyimpan laporan 
		tentang kalkulasi setiap jam. Laporan ini berisi ramalan profil dan jumlah prioriti yang 
		ditetapkan pada seluruh banner. Informasi ini bernilai jika Anda ingin mengirimkan sebuah 
		<i>Bugreport</i> tentang kalkulasi prioriti. Seluruh Laporan akan tersimpan dalam 
		<i>Userlog</i>. 
		";
		
$GLOBALS['phpAds_hlp_userlog_autoclean'] = "
	Untuk memastikan bahwa database telah dipangkas secara benar, Anda bisa simpan sebuah laporan 
		tentang apa saja yang terjadi sewaktu pemangkasan tersebut dijalankan. Informasi ini 
		akan tersimpan pada Userlog.
		";
		
$GLOBALS['phpAds_hlp_default_banner_weight'] = "
	Bila Anda ingin menggunakan bobot banner yang lebih tinggi sebagai default, silakan tentukan bobot 
		yang diinginkan disini. Stelan 1 adalah penyetelan default.
		";
		
$GLOBALS['phpAds_hlp_default_campaign_weight'] = "
	Bila Anda ingin menggunakan bobot kampanye yang lebih tinggi sebagai default, silakan tentukan bobot 
		yang diinginkan disini. Stelan 1 adalah penyetelan default.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "
	Bila penyetelan ini diaktifkan, sebuah informasi khusus tentang setiap kampanye akan ditampilkan 
		pada halaman <i>Ikhtisar dari Kampanye</i>. Informasi khusus tersebut berisi jumlah AdViews yang 
		tersisa, jumlah AdClicks yang tersisa, tanggal aktivasi, waktu berakhir dan penyetelan 
		prioritas. 
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
	Bila penyetelan ini diaktifkan, sebuah informasi khusus tentang setiap banner akan ditampilkan 
		pada halaman <i>Pandangan Banner</i>. Informasi khusus tersebut berisi URL tujuan, 
		kata kunci, ukuran dan bobot dari banner-banner yang bersangkutan.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
	Bila penyetelan ini diaktifkan, sebuah <i>Preview</i> dari semua banner akan ditampilkan pada halaman 
		<i>Pandangan Banner</i>. Bila penyetelan ini tidak aktif, sebuah <i>Preview</i> dari 
		seluruh banner tetap ditampilkan jika Anda men-klik segitiga yang berlokasi di sebelahnya 
		setiap banner pada halaman <i>Pandangan Banner</i>.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "
	Bila penyetelan ini diaktifkan, banner yang sebenarnya akan ditampilkan dan bukan kode HTML. Penyetelan 
		ini tidak aktif sebagai default, sehubungan banner HTML mampu untuk berkonflik dengan interface 
		dari pengguna. Bila penyetalan ini tidak aktif, banner yang sebenarnya tetap bisa dimunculkan 
		dengan cara menggunakan	tombol <i>Tampilkan Banner</i> yang terletak di sebelah kode HTML.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "
	Bila penyetelan ini diaktifkan, sebuah <i>Preview</i> akan ditampilkan pada halaman <i>Properties dari 
		Banner</i>, <i>Pilihan Penyampaian</i> dan halaman <i>Zona yang di-link</i>. Bila penyetalan ini 
		tidak aktif, hal-hal yang tersembunyi tetap ditampilkan dengan cara menggunakan 
		tombol <i>Tampilkan Banner</i> yang terletak pada bagian atas dari halaman yang bersangkutan.
		";
		
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "
	Bila penyetelan ini diaktifkan, seluruh banner, kampanye dan Pemasang Iklan akan disembunyikan 
		dari halaman <i>Pemasang Iklan & Kampanye</i> dan dari halaman <i>Ikhtisar Kampanye</i>. 
		Bila penyetalan ini aktif, hal-hal yang tersembunyi tetap ditampilkan dengan cara menggunakan 
		tombol <i>Tampilkan Semua</i> yang terletak pada bagian bawah dari halaman yang bersangkutan.
		";
		
$GLOBALS['phpAds_hlp_gui_show_matching'] = "
	Bila pilihan ini diaktifkan banner sebanding akan tertampil pada halaman <i>Linked banners</i> jika 
		metode <i>Campaign selection</i> dipilihkan. Hal ini mengizinkan Anda untuk melihat secara 
		pasti banner yang mana saja ditentukan untuk disampaikan kalau sebuah kampanye di-link. 
		Memungkinkan juga untuk melihat banner sebanding dalam <i>Preview</i>.
		";
		
$GLOBALS['phpAds_hlp_gui_show_parents'] = "
	Bila pilihan ini diaktifkan kampanye induk dari banner akan tertampil pada halaman <i>Linked banners</i> 
		jika metode <i>Banner selection</i> dipilihkan. Hal ini mengizinkan Anda untuk memastikan banner 
		mana dimiliki oleh kampanye yang mana sebelum banner yang bersangkutan di-link. Hal ini juga berarti 
		bahwa banner dikelompokkan oleh kampanye induknya dan tidak lagi diurut bedasarkan abjad.
		";
		
$GLOBALS['phpAds_hlp_gui_link_compact_limit'] = "
	Secara Default seluruh banner dan kampanye yang tersedia ditampilkan pada halaman <i>Linked banners</i>.
		Sehubungan begitu, halaman yang ditampilkan bisa menjadi besar sekali jika macam-macam banner 
		yang berbeda tersimpan pada inventori. Pilihan ini mengizinkan Anda untuk menetapkan jumlah maksimal 
		yang akan ditampilkan pada satu halaman. Bila jumlahnya dan caranya banner-banner di-link berbeda, 
		metode yang membutuhkan ruang paling sedikit akan digunakan. 
		";
		
?>
