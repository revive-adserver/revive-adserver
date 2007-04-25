<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
/* Turkish Translation by :												*/
/* 		Metin AKTAÞ (metin@yapayzeka.net)								*/
/* 		Bünyamin VICIL (bunyamin@yapayzeka.net)					        */
/*----------------------------------------------------------------------*/


// Settings help translation strings
$GLOBALS['phpAds_hlp_dbhost'] = 
		$phpAds_dbmsname." veritabanýnýn veritabaný sunucusunu belirtiniz.
		";
		
$GLOBALS['phpAds_hlp_dbuser'] = 
		$phpAds_productname." programýnýn ".$phpAds_dbmsname." veritabanýna baðlanmasý için kullanýcý adýný belirtiniz.
		";
		
$GLOBALS['phpAds_hlp_dbpassword'] = 
		$phpAds_productname." programýnýn ".$phpAds_dbmsname." veritabanýna baðlanmasý için parolanýzý belirtiniz.
		";
		
$GLOBALS['phpAds_hlp_dbname'] = 
		$phpAds_productname." programýnýn verilerini saklayacaðý veritabanýný belirtiniz.
		";
		
$GLOBALS['phpAds_hlp_persistent_connections'] = "
		Ýnatçý baðlantýlarý kullanýrsanýz ".$phpAds_productname." programý hýzlanýr ve sunucuya 
		yükünü azaltýr. Buna raðmen çok kullanýcýnýn ziyaret ettiði sitelerde server yükü fazlalaþacaðýndan 
		hatta normal zamanlardaki baðlantýlardan daha fazla olacaðýndan dolayý dezavantajý vardýr.
		Düzenli baðlantýlarý veya inatçý baðlantýlarý ziyaretçi sayýnýz ve donanýmýnýz destekliyorsa 
		kullanabilirsiniz. Eðer ".$phpAds_productname." programý çok fazla kaynak harcýyorsa ilk olarak
		bakacaðýnýz ayar burasýdýr.
		";
		
$GLOBALS['phpAds_hlp_insert_delayed'] = "
        ".$phpAds_dbmsname." veritabaný veri girilirken tablolarý kilitlesin. Çok sayýda ziyaretçiniz varsa
		".$phpAds_productname." programý yeni veri giriþi esnasýnda bekler, çünkü veritabaný kilitlidir.
		Veri ekleme gecikmesi kullanýrsanýz, beklemezsiniz ve yeni veri daha tablonun açýk olduðu sýrada
		sonra da eklenebilir.
		";
		
$GLOBALS['phpAds_hlp_compatibility_mode'] = "
		Eðer ".$phpAds_productname." ile üçüncü parti bir programýn bir bütün olarak çalýþmasýnda
		problem yaþýyorsanýz, veritabaný uyum modunu kullanabilirsiniz. Eðer yerel sistem kullanýyorsanýz
		ve veritabaný uyum modu açýk ise ".$phpAds_productname." programý veritabaný durumunu çalýþmadan
		önceki durumu gibi teslim eder. Bu özellik sistemi biraz yavaþlatabilir. Bundan dolayý öntanýmlý
		olarak kapatýlmýþtýr.
		";
		
$GLOBALS['phpAds_hlp_table_prefix'] = "
		".$phpAds_productname." veritabaný birden fazla programla kullanýlýyorsa tablolara önad koymak 
		akýllýca olur. ".$phpAds_productname." programýnýn birden fazla kopyasýný ayný veritabanýnda 
		kullanýyorsanýz, bu önadlarýn farklý olmasýný istersiniz.
		";
		
$GLOBALS['phpAds_hlp_tabletype'] = "
        ".$phpAds_dbmsname." veritabaný farklý tablo yapýlarýný destekler. Her tablo türü kendine has
		özelliklere sahiptir ve bazýlarý ".$phpAds_productname." programýný hatrý sayýlýr derecede 
		hýzlandýrabilir. MyISAM öntanýmlý tablo yapýsýdýr ve ".$phpAds_dbmsname." veritabanýnýn
		tüm kurulumlarý içerir. Diðer tablo yapýlarý sunucunuz tarafýndan desteklenmeyebilir.
		";
		
$GLOBALS['phpAds_hlp_url_prefix'] = "
        ".$phpAds_productname." programý düzgün çalýþabilmesi için sunucu üzerinde nerede
		çalýþtýðýný bilmelidir. ".$phpAds_productname." programýnýn kurulu olduðu URLyi
		tam olarak girmelisiniz mesela: http://your-url.com/".$phpAds_productname.".
		";
		
$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
		Buraya yönetici sayfasýndaki üstbilgi ve altbilgi içeren dosyalarýn yollarýný
		belirtebilirsiniz(ör: ../yonetici_paneli/ekstra/header.html). Buraya dosyalara 
		yazý veya HTML kodu girebilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_content_gzip_compression'] = "
		GZIP içerik sýkýþtýrmayý aktif ettiðiniz takdirde yönetici paneline her giriþteki 
		tarayýcýya gönderilen veri oranýnda büyük bir düþüþ olur. Bu özelliði aktif 
		edebilmeniz için en az GZIP eklentili PHP 4.0.5 sürümüne sahip olmanýz gerekiyor.
		";
		
$GLOBALS['phpAds_hlp_language'] = "
		".$phpAds_productname." programýnýn kullanacaðý öntanýmlý dili seçiniz. Bu dil
		yönetici ve reklamcýlar için öntanýmlý olacaktýr. 
		NOT: Herbir reklamcý için yönetici arabiriminden farklý bir dil seçebilirsiniz veya
		herbir reklamcýya kendi dilini deðiþtirme izni verebilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_name'] = "
		Bu uygulama için kullanacaðýnýz program ismini seçiniz. Bu isim tüm
		yönetici ve reklamcý sayfalarýnda görüntülenecektir. Bu ayarý boþ geçerseniz
		(öntanýmlý) ".$phpAds_productname." logosu görüntülenecektir.
		";
		
$GLOBALS['phpAds_hlp_company_name'] = "
		Bu isim ".$phpAds_productname." programý tarafýndan gönderilen e-maillerde kullanýlacaktýr.
		";
		
$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
		".$phpAds_productname." programý genellikle GD kütüphanesinin kurulu olup olmadýðýný 
		ve hangi resim formatlarýnýn desteklenip desteklenmediðini bulur. Herþeye raðmen
		bu sonuç kesin olarak doðrudur veya yanlýþtýr diyemeyiz, çünkü bazý PHP sürümleri
		desteklenen resim formatlarýnýn bulunmasýna izin vermez. Eðer ".$phpAds_productname."
		otomatik bulma sisteminde hata yaparsa doðru resim formatlarýný siz belirtmelisiniz.
		Olaðan formatlar: hiçbiri, png, jpeg, gif.
		";
		
$GLOBALS['phpAds_hlp_p3p_policies'] = "
		".$phpAds_productname." programýnýn P3P Gizlilik Politikalarýný kullanmasýný istiyorsanýz
		bu özelliði açýnýz.
		";
		
$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
		Cookielerle gönderilen yoðunlaþtýrýlmýþ politika. Öntanýmlý ayar: 'CUR ADM OUR NOR STA NID'
		Bu ayarlama ".$phpAds_productname." programýnýn Internet Explorer 6 üzerinde cookie
		göndermesine izin verir. Eðer isterseniz bu ayarlarý kendi Gizlilik durumunuza göre
		deðiþtirebilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
		Eðer tam gizlilik politikasý kullanmak istiyorsanýz, politikanýn tam yerini
		belirtebilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_log_beacon'] = "
		Yol göstericiler bannerlarýn gösterildiði sayfalarda küçük görünmez resimlerdir.
		Bu özelliði açarsanýz ".$phpAds_productname." programý bannerýn görüntülenme esnaýsýndaki
		sayýsýný hesaplar. Bu özelliði kapatýrsanýz banner görüntülenme sayýsý sadece teslimatta
		sayýlýr fakat bu sayý kesin sayý olmayabilir. Çünkü teslim edilmiþ banner her zaman ekranda
		görüntülenmeyebilir.
		";
		
$GLOBALS['phpAds_hlp_compact_stats'] = "
		Geleneksel olarak ".$phpAds_productname." programý çok detaylý ve bakým gerektiren
		geniþletilmiþ loglarý tercih eder. Bu çok ziyaretçili sitelerde büyük problemlere
		yol açabilir. Bu problemi halletmek için ".$phpAds_productname." programý az bakým
		gerektiren ama az detaylý yeni istatistik tipini destekler. Yoðunlaþtýrýlmýþ istatistikler
		saatlik görüntülenme ve týklanma sayýlarýný depolar. Daha fazla detaya ihtiyacýnýz varsa
		yoðunlaþtýrýlmýþ istatistikler özelliðini kapatabilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_log_adviews'] = "
		Normal durumda tüm görüntülenmeler depolanýr, ama görüntülenmeleri depolamak
		istemiyorsanýz bu özelliði kapatabilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_block_adviews'] = "
		Eðer bir ziyaretçi sayfayý yenilerse ".$phpAds_productname." her görüntülemeyi depolar.
		Bu özellik belirlediðiniz süre içerisinde görüntülenmelerden sadece birini depolar.
		Örneðin: bu özelliði 300 saniye yaparsanýz, ".$phpAds_productname." son 5 dakika içerisinde 
		ayný ziyaretçiye sadece tekrar gösterilmeyen bannerlarýn istatistiklerini depolar. Bu
		özellik sadece <i>Görüntülenmeleri loglamak için yol göstericileri kullan</i> seçeneði
		açýlmýþ ise ve tarayýcý cookieleri kabul ediyorsa kullanýlýr.
		";
		
$GLOBALS['phpAds_hlp_log_adclicks'] = "
		Normal durumda tüm týklanmalar depolanýr, ama týklanmalrý depolamak
		istemiyorsanýz bu özelliði kapatabilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_block_adclicks'] = "
		Eðer bir ziyaretçi bir bannera birden fazla týklarsa ".$phpAds_productname." programý her
		týklamayý kaydeder. Bu özellik belirlediðiniz süre içerisinde sadece bir týklamayý depolar.
		Örneðin: bu özelliði 300 saniye yaparsanýz, ".$phpAds_productname." son 5 dakika içerisinde 
		ayný ziyaretçinin sadece tekrar týklamadýðý bannerlarýn istatistiklerini depolar. Bu
		özellik sadece tarayýcý cookieleri kabul ediyorsa kullanýlabilýr.
		";
		
$GLOBALS['phpAds_hlp_reverse_lookup'] = "
		".$phpAds_productname." programý öntanýmlý olarak her ziyaretçinin IP adresini depolar.
		Eðer ".$phpAds_productname." programýnýn domain isimlerini depolamasýný istiyorsanýz 
		bu özelliði açabilirsiniz. Geri besleme biraz zaman alabilir ve tüm iþlemler biraz
		yavaþlar.
		";
		
$GLOBALS['phpAds_hlp_proxy_lookup'] = "
		Bazý kullanýcýlar internete eriþebilmek için proxy sunucular kullanýr. Bu durumda
		".$phpAds_productname." programý kullanýcýnýn deðilde proxy sunucunun Ip adresini
		veya sunucu adýný alýr. Eðer bu özelliði açarsanýz ".$phpAds_productname." programý
		proxy sunucu arkasýndaki kullanýcýnýn IP adresini veya sunucu adýný bulmaya çalýþýr.
		Eðer proxy sunucu kullanýlýyorsa kullanýcýnýn kesin adresini bulmak mümkün olmayabilir.
		Bu özellik öntanýmlý olarak kapalýdýr, çünkü depolama hýzýný düþürür.
		";
		
$GLOBALS['phpAds_hlp_ignore_hosts'] = "
		Eðer bazý bilgisayarlarýn týklama ve görüntüleme sayýlarýný depolamak
		istemiyorsanýz bu bilgisayarlarý bu listeye  ekleyebilirsiniz. Geri beslemeyi
		açarsanýz hem domain adýný hem de IP adresini ekleyebilirsiniz, aksi
		takdirde sadece IP adresini yazýnýz. Tanýmlamalarý kullanbilirsiniz (Örn:
		'*.altavista.com' veya '192.168.*').
		";
		
$GLOBALS['phpAds_hlp_begin_of_week'] = "
		Çoðu insan için hafta Pazartesi baþlar. Fakat isterseniz Pazar günü baþlatabilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_percentage_decimals'] = "
		Ýstatistik sayfalarýnda kaç tane ondalýk alaný olacaðýný belirtiniz.
		";
		
$GLOBALS['phpAds_hlp_warn_admin'] = "
		".$phpAds_productname." programý kampanyanýn belirli bir týklama veya görüntülenme
		sayýsý kaldýðýnda size e-mail atabilir. Bu özellik öntanýlý açýktýr.
		";
		
$GLOBALS['phpAds_hlp_warn_client'] = "
		".$phpAds_productname." programý bir kampanyanýn belirli bir týklama ve görütülenme
		sayýsý kaldýðýnda reklamcýya e-mail atabilir. Bu özellik öntanýmlý açýktýr.
		";
		
$GLOBALS['phpAds_hlp_qmail_patch'] = "
		Bazý qmail sürümleri ".$phpAds_productname." programý tarafýndan gönderilen maillerin
		içerisine mailin baþlýk kýsmýný gömmektedir. Bu ayarý açarsanýz ".$phpAds_productname."
		programý mailleri qmail uyumlu biçimde gönderecektir.
		";
		
$GLOBALS['phpAds_hlp_warn_limit'] = "
		".$phpAds_productname." programýnýn uyarý e-mailleri gönderme sýnýrlamasý. Bu öntanýmlý
		100dür.
		";
		
$GLOBALS['phpAds_hlp_allow_invocation_plain'] = 
$GLOBALS['phpAds_hlp_allow_invocation_js'] = 
$GLOBALS['phpAds_hlp_allow_invocation_frame'] = 
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] = 
$GLOBALS['phpAds_hlp_allow_invocation_local'] = 
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] = 
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "
		Bu ayarlar invocation tiplerine izin verdiðinizi belirtir. Bu biçimlerden
		birisi kapalý ise invocationcode ve bannercode içerisinde kullanýlabilir olmayacaktýr.
		ÖNEMLÝ: Seçilmeseler bile invocation metodlarý çalýþacaktýr. Sadece kod
		üretiminde kullanýlmayacaktýr.
		";
		
$GLOBALS['phpAds_hlp_con_key'] = "
		".$phpAds_productname." programý güçlü bir düzeltme modülüne sahiptir.
		Daha fazla bilgi için kullanýcý klavuzunu okuyunuz. Bu özellikler, durum
		anahtar kelimelerini kullanabilirsiniz. Öntanýmlý açýktýr.
		";
		
$GLOBALS['phpAds_hlp_mult_key'] = "
		Eðer banner göstermek için direk seçim yöntemini kullanýyorsanýz, bir yada
		birden fazla anahtar kelime seçebilirsiniz. Birden fazla anahtar kelime seçerseniz
		bu özellik açýlmalýdýr. Öntanýmlý olarak açýktýr.
		";
		
$GLOBALS['phpAds_hlp_acl'] = "
		Teslimat sýnýrlamalarý kullanmýyorsanýz bu özelliði bu parametreyi kullanýp kapatabilirsiniz.
		Bu ".$phpAds_productname." sistemini hýzlandýracaktýr.
		";
		
$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = "
		".$phpAds_productname." programý veritabanýna baðlanmazsa veya eþleþen bir banner bulamazsa
		mesela veritabanýnýn bozulmasý veya silinmesi durumunda, boþ sayfa basacaktýr.
		Bazý kullanýcýlar bu durumda öntanýmlý bir banner gösterilmesini isteyecektir.
		Bu bannerla ilgili hiçbir istatistik tutulmamaktadýr. Bu özellik öntanýmlý kapalýdýr.
		";
		
$GLOBALS['phpAds_hlp_zone_cache'] = "
        Eðer alanlarý kullanýyorsanýz ".$phpAds_productname." programý banner bilgilerini daha
		sonra kullanýlmasý için hafýzada tutabilir. Bu ".$phpAds_productname." programýnýn hýzlý
		çalýþmasýný saðlar. Program çalýþýrken Alan bilgisini almak için ve bannerýn bilgisini 
		almak için ve doðru banneý seçmek için ".$phpAds_productname." programý sadece hafýza
		yükler. Bu özellik öntanýmlý açýktýr.
		";
		
$GLOBALS['phpAds_hlp_zone_cache_limit'] = "
        Hafýzalanmýþ alanlar kullanýyorsanýz, hafýza içerisindeki bilgiler güncellenebilir.
		".$phpAds_productname." programý hafýzayý yeniden oluþturduðu zaman, alana eklenen
		yeni bannerlarda hafýza alýnýr. Bu ayar size hafýzanýn ne kadar sürede tazeleneceðini
		ve en fazla yaþama süresini belirtir. Örneðin: Bu ayarý 600 olarak ayarlarsanýz,
		hafýza her 10 dakikada bir yenilenir.
		";
		
$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = 
$GLOBALS['phpAds_hlp_type_txt_allow'] = "
        ".$phpAds_productname." programý farklý tiplerde bannerlarý destekler ve bunlarý
		farklý yollarla kaydeder. Ýlk iki seçim yerel depolama için kullanýlýr. Yönetici
		arabiriminden banner yükleyebilirsiniz ve ".$phpAds_productname." programý bunlarý
		SQL veritabanýna veya web sunucuya kaydeder. Harici web sunucudaki bannerlarý da 
		kullanabilirsiniz veya HTML kullanabilirsiniz veya basit bir yazý ile de banner
		oluþturabilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_type_web_mode'] = "
        Eðer bannerlarýn web sunucuda saklanmasýný seçerseniz, bu ayarlarý yapmak 
		zorundasýnýz. Bannerlarý yerel klasörde saklamak istiyorsanýz bu ayarlarý
		<i>Yerel Klasör</i> olarak ayarlayýnýz. Eðer bannerlarýnýzý harici web sunucu
		üzerinde saklamak istiyorsanýz bu ayarlarý <i>Harici FTP Sunucu</i> olarak 
		ayarlayýnýz. Yerel sunucu haricindeki sunucularda FTP ayarlarýný kullanmanýz
		gerekmektedir.
		";
		
$GLOBALS['phpAds_hlp_type_web_dir'] = "
		".$phpAds_productname." programýnýn gönderilen bannerlarý nereye kopyalayacaðýný
		(hangi klasöre) belirtiniz. Bu klasör PHP tarafýndan yazýlabilir olmalýdýr. Bu 
		klasörün UNIX izinlerinin ayarlanmasýný gerektirir(chmod). Burada belirttiðiniz
		klasör web sunucu üzerinde web paylaþýmý olan (web sunucu web hizmeti verebilmelidir)
		yerde olmalýdýr. Son (/)ý yazmayýnýz. Depolamak için <i>Yerel Klasör</i> metodunu 
		seçtiyseniz bu ayarlarý yapmalýsýnýz.
		";
		
$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "
		Depolama metodunu <i>Harici FTP sunucusu</i> olarak belirlediyseniz, ".$phpAds_productname." 
		programýnýn bannerlarý göndereceði harici FTP sunucunun IP Adresi veya domain adýný 
		belirtmelisiniz.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "
		Depolama metodunu <i>Harici FTP sunucusu</i> olarak belirlediyseniz, ".$phpAds_productname." 
		programýnýn harici FTP sunucuda bannerlarý göndereceði klasör ismini belirtmelisiniz.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "
		Depolama metodunu <i>Harici FTP sunucusu</i> olarak belirlediyseniz, ".$phpAds_productname." 
		programýnýn harici FTP sunucuya ulaþmasý için kullanacaðý kullanýcý adýný belirtmelisiniz.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "
		Depolama metodunu <i>Harici FTP sunucusu</i> olarak belirlediyseniz, ".$phpAds_productname." 
		programýnýn harici FTP sunucuya ulaþmasý için kullanacaðý parolayý belirtmelisiniz.
		";
      
$GLOBALS['phpAds_hlp_type_web_url'] = "
		Eðer bannerlarýnýzý web sunucusu üzerinde tutuyorsanýz, ".$phpAds_productname." programý
		bannerlarý sakladýðýnýz klasörün umumi konumunu bilmek zorundadýr. (En son / ý koymayýnýz.)
		";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "
		Eðer bu özellik açýk ise ".$phpAds_productname." programý HTML banner kodu içerisine otomatik olarak týklanma
		izleme kodunu gönderir. Ama bu özellik açýk olduðu zaman bannerdaki bu özellik açýk ise
		banner özlelliðini yok sayar.
		";
		
$GLOBALS['phpAds_hlp_type_html_php'] = $phpAds_productname."
		programýnýn HTML bannerlarý içerisndeki PHP kodlarýný çalýþtýrmasýna izin ver.
		Bu özellik öntanýmlý olarak kapalýdýr.
		";
		
$GLOBALS['phpAds_hlp_admin'] = "
		Site yöneticisi kullanýcý adý, yönetici arabirimindeki loglarda kullanýlacak
		kullanýcý adýný belirtebilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_pwold'] = 
$GLOBALS['phpAds_hlp_pw'] = 
$GLOBALS['phpAds_hlp_pw2'] = "
		Yönetici parolasýný deðiþtirmek için, eski parolayý girmeniz gerekiyor.
		Yeni parolayý da yazým hatalarýna karþý güvenli olsun diye iki defa
		girmeniz gerekmektedir.
		";
		
$GLOBALS['phpAds_hlp_admin_fullname'] = "
		Site Yöneticisinin tam ismini belirtiniz. Bu istatistik mailleri gönderilirken
		kullanýlacaktýr.
		";
		
$GLOBALS['phpAds_hlp_admin_email'] = "
		Site yöneticisinin e-mail adresini belirtiniz. Bu e-mail hesabý gönderilen 
		istatistik maillerinin kimden kýsmýna yazýlacaktýr.
		";
		
$GLOBALS['phpAds_hlp_admin_email_headers'] = $phpAds_productname."
		programý tarafýndan gönderilen e-maillere e-mail baþlýklarý ekleyebilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_admin_novice'] = "
		Herhangi reklamcý, kampanya, banner, yayýncý ve/veya alan silerken uyarý verilmesini
		istiyorsanýz bu özelliði açýnýz.
		";
		
$GLOBALS['phpAds_hlp_client_welcome'] = "
		Eðer bu özelliði aktif ederseniz, reklamcý giriþ yaptýktan sonra ilk sayfada hoþgeldiniz
		mesajý görüntülenecektir. Bu mesajý welcome.html dosyasýný (admin/templates klasöründe)
		düzenleyerek kiþiselleþtirebilirsiniz. Eklemek isteyebileceðiniz veriler: Firma isminiz,
		irtibat bilgileri, firma logonuz, reklam oranlarý ile ilgili sayfa linki....
		";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
		Welcome.html dosyasýný deðiþtirmenin yanýnda buradaki ufak alana da belirtebilirsiniz.
		Eðer buraya bir yazý girerseniz, welcome.html dosyasý yok sayýlacaktýr. html etiketleri
		kulanýlabilir.
		";
		
$GLOBALS['phpAds_hlp_updates_frequency'] = $phpAds_productname."
		programýnýn yeni sürümlerini kontrol etmek istiyorsanýz bu seçeneði aktif edebilirsiniz.
		".$phpAds_productname." programýnýn sunucu ile baðlanmasýný saðlar. Eðer yeni bir sürüm 
		bulunursa açýlan kutu içerisinde bilgi verilecektir.
		";
		
$GLOBALS['phpAds_hlp_userlog_email'] = $phpAds_productname."
		programý tarafýndan gönderilen tüm mailleri depolamak istiyorsanýz bu özelliði
		aktif etmelisiniz. Bu e-mail mesajlarý kullanýcý loglarý içerisinde depolanacaktýr.
		";
		
$GLOBALS['phpAds_hlp_userlog_priority'] = "
		Öncelik hesabýnýn doðru olarak hesaplandýðýndan emin olmak için, saatlik
		hesaplamalarý raporlayabilirsiniz. Bu rapor olasýlýk profilini ve tüm bannelarýn
		önceliklerini içerir. Bu bilgileri olasýlýk hesaplamalarý ile ilgili bir problemi 
		bildirmek için kullanabilirsiniz. Bu bilgileri kullanýcý loglarý içerisinde depolar.
		";
		
$GLOBALS['phpAds_hlp_default_banner_weight'] = "
		Eðer yüksek öneme sahip öntanýmlý banner kullanmak istiyorsanýz önem ayarýný buradan
		yapabilirsiniz. Öntanýmlý olarak bu deðer 1dir.
		";
		
$GLOBALS['phpAds_hlp_default_campaign_weight'] = "
		Eðer yüksek öneme sahip öntanýmlý kampanya kullanmak istiyorsanýz önem ayarýný buradan 
		yapabilirsiniz. Öntanýmlý olarak bu deðer 1dir.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "
		Eðer bu seçenek seçili ise kampanyalar hakkýnda ekstra bilgiler <i>Kampanya Önizleme</i>
		sayfasýnda gösterilir. Ekstra bilgi kalan görüntülenme sayýsýný, kalan týklama sayýsýný,
		aktivasyon tarihini, bitiþ tarihini ve öncelik ayarlarýný içerir.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
		Eðer bu seçenek seçilmiþ ise banner hakkýndaki ekstra bilgiler <i>Banner Özellikleri</i>
		sayfasýnda gösterilir. Ekstra bilgi hedef URL, anahtar kelimeler, boyut ve banner önemini
		içerir.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
		Eðer bu seçenek seçili ise <i>Banner Önizleme</i> sayfasýnda tüm bannerlarýn önizlemesi
		görüntülenir. Eðer bu seçenek seçili deðil ise <i>Banner Önizleme</i> sayfasýnda bannerlarýn
		yanýndaki üçgenlere basarak bannerlar görüntülenebilir.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "
		Eðer bu seçenek seçilmiþ ise HTML Bannerlarý HTMLsiz olarak gösterilir. Bu özellik öntanýmlý
		olarak seçilmemiþtir, çünkü HTML Bannerý kullanýcý arayüzü ile çakýþabilir. Bu seçenek seçili
		deðilken bile HTML banner, <i>Banner Göster</i> butonuna týklanarak görüntülenebilir.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "
		Eðer bu seçenek seçilmiþ ise önizleme <i>Banner Özellikleri</i>, <i>Teslimat Ayarlarý</i> ve 
		<i>Ýliþkilendirilmiþ Alanlar</i> sayfalarýnýn en üstünde görüntülenecektir. Bu seçenek seçilmemeiþ
		ise bannerlarý görüntülemek için sayfalarýn en üstünde bulunan <i>Banner Göster</i> butonuna
		basabilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "
		Eðer bu seçenek seçilmiþ ise tüm pasif bannerlar, kampanyalar ve reklamcýlar <i>Reklamcýlar & 
		Kampanyalar</i> ve <i>Kampanya Önizleme</i> sayfalarýnda gizlenecektir. Eðer bu seçenek seçilmiþ
		ise tüm gizlenmiþ öðeler sayfanýn altýnda bulunan <i>Hepsini Göster</i> butonu ile görüntülenebilir.
		";
		
?>