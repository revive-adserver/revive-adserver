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
$GLOBALS['phpAds_hlp_dbhost'] = 
		$phpAds_dbmsname." veritaban�n�n veritaban� sunucusunu belirtiniz.
		";
		
$GLOBALS['phpAds_hlp_dbuser'] = 
		$phpAds_productname." program�n�n ".$phpAds_dbmsname." veritaban�na ba�lanmas� i�in kullan�c� ad�n� belirtiniz.
		";
		
$GLOBALS['phpAds_hlp_dbpassword'] = 
		$phpAds_productname." program�n�n ".$phpAds_dbmsname." veritaban�na ba�lanmas� i�in parolan�z� belirtiniz.
		";
		
$GLOBALS['phpAds_hlp_dbname'] = 
		$phpAds_productname." program�n�n verilerini saklayaca�� veritaban�n� belirtiniz.
		";
		
$GLOBALS['phpAds_hlp_persistent_connections'] = "
		�nat�� ba�lant�lar� kullan�rsan�z ".$phpAds_productname." program� h�zlan�r ve sunucuya 
		y�k�n� azalt�r. Buna ra�men �ok kullan�c�n�n ziyaret etti�i sitelerde server y�k� fazlala�aca��ndan 
		hatta normal zamanlardaki ba�lant�lardan daha fazla olaca��ndan dolay� dezavantaj� vard�r.
		D�zenli ba�lant�lar� veya inat�� ba�lant�lar� ziyaret�i say�n�z ve donan�m�n�z destekliyorsa 
		kullanabilirsiniz. E�er ".$phpAds_productname." program� �ok fazla kaynak harc�yorsa ilk olarak
		bakaca��n�z ayar buras�d�r.
		";
		
$GLOBALS['phpAds_hlp_insert_delayed'] = "
        ".$phpAds_dbmsname." veritaban� veri girilirken tablolar� kilitlesin. �ok say�da ziyaret�iniz varsa
		".$phpAds_productname." program� yeni veri giri�i esnas�nda bekler, ��nk� veritaban� kilitlidir.
		Veri ekleme gecikmesi kullan�rsan�z, beklemezsiniz ve yeni veri daha tablonun a��k oldu�u s�rada
		sonra da eklenebilir.
		";
		
$GLOBALS['phpAds_hlp_compatibility_mode'] = "
		E�er ".$phpAds_productname." ile ���nc� parti bir program�n bir b�t�n olarak �al��mas�nda
		problem ya��yorsan�z, veritaban� uyum modunu kullanabilirsiniz. E�er yerel sistem kullan�yorsan�z
		ve veritaban� uyum modu a��k ise ".$phpAds_productname." program� veritaban� durumunu �al��madan
		�nceki durumu gibi teslim eder. Bu �zellik sistemi biraz yava�latabilir. Bundan dolay� �ntan�ml�
		olarak kapat�lm��t�r.
		";
		
$GLOBALS['phpAds_hlp_table_prefix'] = "
		".$phpAds_productname." veritaban� birden fazla programla kullan�l�yorsa tablolara �nad koymak 
		ak�ll�ca olur. ".$phpAds_productname." program�n�n birden fazla kopyas�n� ayn� veritaban�nda 
		kullan�yorsan�z, bu �nadlar�n farkl� olmas�n� istersiniz.
		";
		
$GLOBALS['phpAds_hlp_tabletype'] = "
        ".$phpAds_dbmsname." veritaban� farkl� tablo yap�lar�n� destekler. Her tablo t�r� kendine has
		�zelliklere sahiptir ve baz�lar� ".$phpAds_productname." program�n� hatr� say�l�r derecede 
		h�zland�rabilir. MyISAM �ntan�ml� tablo yap�s�d�r ve ".$phpAds_dbmsname." veritaban�n�n
		t�m kurulumlar� i�erir. Di�er tablo yap�lar� sunucunuz taraf�ndan desteklenmeyebilir.
		";
		
$GLOBALS['phpAds_hlp_url_prefix'] = "
        ".$phpAds_productname." program� d�zg�n �al��abilmesi i�in sunucu �zerinde nerede
		�al��t���n� bilmelidir. ".$phpAds_productname." program�n�n kurulu oldu�u URLyi
		tam olarak girmelisiniz mesela: http://your-url.com/".$phpAds_productname.".
		";
		
$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
		Buraya y�netici sayfas�ndaki �stbilgi ve altbilgi i�eren dosyalar�n yollar�n�
		belirtebilirsiniz(�r: ../yonetici_paneli/ekstra/header.html). Buraya dosyalara 
		yaz� veya HTML kodu girebilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_content_gzip_compression'] = "
		GZIP i�erik s�k��t�rmay� aktif etti�iniz takdirde y�netici paneline her giri�teki 
		taray�c�ya g�nderilen veri oran�nda b�y�k bir d���� olur. Bu �zelli�i aktif 
		edebilmeniz i�in en az GZIP eklentili PHP 4.0.5 s�r�m�ne sahip olman�z gerekiyor.
		";
		
$GLOBALS['phpAds_hlp_language'] = "
		".$phpAds_productname." program�n�n kullanaca�� �ntan�ml� dili se�iniz. Bu dil
		y�netici ve reklamc�lar i�in �ntan�ml� olacakt�r. 
		NOT: Herbir reklamc� i�in y�netici arabiriminden farkl� bir dil se�ebilirsiniz veya
		herbir reklamc�ya kendi dilini de�i�tirme izni verebilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_name'] = "
		Bu uygulama i�in kullanaca��n�z program ismini se�iniz. Bu isim t�m
		y�netici ve reklamc� sayfalar�nda g�r�nt�lenecektir. Bu ayar� bo� ge�erseniz
		(�ntan�ml�) ".$phpAds_productname." logosu g�r�nt�lenecektir.
		";
		
$GLOBALS['phpAds_hlp_company_name'] = "
		Bu isim ".$phpAds_productname." program� taraf�ndan g�nderilen e-maillerde kullan�lacakt�r.
		";
		
$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
		".$phpAds_productname." program� genellikle GD k�t�phanesinin kurulu olup olmad���n� 
		ve hangi resim formatlar�n�n desteklenip desteklenmedi�ini bulur. Her�eye ra�men
		bu sonu� kesin olarak do�rudur veya yanl��t�r diyemeyiz, ��nk� baz� PHP s�r�mleri
		desteklenen resim formatlar�n�n bulunmas�na izin vermez. E�er ".$phpAds_productname."
		otomatik bulma sisteminde hata yaparsa do�ru resim formatlar�n� siz belirtmelisiniz.
		Ola�an formatlar: hi�biri, png, jpeg, gif.
		";
		
$GLOBALS['phpAds_hlp_p3p_policies'] = "
		".$phpAds_productname." program�n�n P3P Gizlilik Politikalar�n� kullanmas�n� istiyorsan�z
		bu �zelli�i a��n�z.
		";
		
$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
		Cookielerle g�nderilen yo�unla�t�r�lm�� politika. �ntan�ml� ayar: 'CUR ADM OUR NOR STA NID'
		Bu ayarlama ".$phpAds_productname." program�n�n Internet Explorer 6 �zerinde cookie
		g�ndermesine izin verir. E�er isterseniz bu ayarlar� kendi Gizlilik durumunuza g�re
		de�i�tirebilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
		E�er tam gizlilik politikas� kullanmak istiyorsan�z, politikan�n tam yerini
		belirtebilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_log_beacon'] = "
		Yol g�stericiler bannerlar�n g�sterildi�i sayfalarda k���k g�r�nmez resimlerdir.
		Bu �zelli�i a�arsan�z ".$phpAds_productname." program� banner�n g�r�nt�lenme esna�s�ndaki
		say�s�n� hesaplar. Bu �zelli�i kapat�rsan�z banner g�r�nt�lenme say�s� sadece teslimatta
		say�l�r fakat bu say� kesin say� olmayabilir. ��nk� teslim edilmi� banner her zaman ekranda
		g�r�nt�lenmeyebilir.
		";
		
$GLOBALS['phpAds_hlp_compact_stats'] = "
		Geleneksel olarak ".$phpAds_productname." program� �ok detayl� ve bak�m gerektiren
		geni�letilmi� loglar� tercih eder. Bu �ok ziyaret�ili sitelerde b�y�k problemlere
		yol a�abilir. Bu problemi halletmek i�in ".$phpAds_productname." program� az bak�m
		gerektiren ama az detayl� yeni istatistik tipini destekler. Yo�unla�t�r�lm�� istatistikler
		saatlik g�r�nt�lenme ve t�klanma say�lar�n� depolar. Daha fazla detaya ihtiyac�n�z varsa
		yo�unla�t�r�lm�� istatistikler �zelli�ini kapatabilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_log_adviews'] = "
		Normal durumda t�m g�r�nt�lenmeler depolan�r, ama g�r�nt�lenmeleri depolamak
		istemiyorsan�z bu �zelli�i kapatabilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_block_adviews'] = "
		E�er bir ziyaret�i sayfay� yenilerse ".$phpAds_productname." her g�r�nt�lemeyi depolar.
		Bu �zellik belirledi�iniz s�re i�erisinde g�r�nt�lenmelerden sadece birini depolar.
		�rne�in: bu �zelli�i 300 saniye yaparsan�z, ".$phpAds_productname." son 5 dakika i�erisinde 
		ayn� ziyaret�iye sadece tekrar g�sterilmeyen bannerlar�n istatistiklerini depolar. Bu
		�zellik sadece <i>G�r�nt�lenmeleri loglamak i�in yol g�stericileri kullan</i> se�ene�i
		a��lm�� ise ve taray�c� cookieleri kabul ediyorsa kullan�l�r.
		";
		
$GLOBALS['phpAds_hlp_log_adclicks'] = "
		Normal durumda t�m t�klanmalar depolan�r, ama t�klanmalr� depolamak
		istemiyorsan�z bu �zelli�i kapatabilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_block_adclicks'] = "
		E�er bir ziyaret�i bir bannera birden fazla t�klarsa ".$phpAds_productname." program� her
		t�klamay� kaydeder. Bu �zellik belirledi�iniz s�re i�erisinde sadece bir t�klamay� depolar.
		�rne�in: bu �zelli�i 300 saniye yaparsan�z, ".$phpAds_productname." son 5 dakika i�erisinde 
		ayn� ziyaret�inin sadece tekrar t�klamad��� bannerlar�n istatistiklerini depolar. Bu
		�zellik sadece taray�c� cookieleri kabul ediyorsa kullan�labil�r.
		";
		
$GLOBALS['phpAds_hlp_reverse_lookup'] = "
		".$phpAds_productname." program� �ntan�ml� olarak her ziyaret�inin IP adresini depolar.
		E�er ".$phpAds_productname." program�n�n domain isimlerini depolamas�n� istiyorsan�z 
		bu �zelli�i a�abilirsiniz. Geri besleme biraz zaman alabilir ve t�m i�lemler biraz
		yava�lar.
		";
		
$GLOBALS['phpAds_hlp_proxy_lookup'] = "
		Baz� kullan�c�lar internete eri�ebilmek i�in proxy sunucular kullan�r. Bu durumda
		".$phpAds_productname." program� kullan�c�n�n de�ilde proxy sunucunun Ip adresini
		veya sunucu ad�n� al�r. E�er bu �zelli�i a�arsan�z ".$phpAds_productname." program�
		proxy sunucu arkas�ndaki kullan�c�n�n IP adresini veya sunucu ad�n� bulmaya �al���r.
		E�er proxy sunucu kullan�l�yorsa kullan�c�n�n kesin adresini bulmak m�mk�n olmayabilir.
		Bu �zellik �ntan�ml� olarak kapal�d�r, ��nk� depolama h�z�n� d���r�r.
		";
		
$GLOBALS['phpAds_hlp_ignore_hosts'] = "
		E�er baz� bilgisayarlar�n t�klama ve g�r�nt�leme say�lar�n� depolamak
		istemiyorsan�z bu bilgisayarlar� bu listeye  ekleyebilirsiniz. Geri beslemeyi
		a�arsan�z hem domain ad�n� hem de IP adresini ekleyebilirsiniz, aksi
		takdirde sadece IP adresini yaz�n�z. Tan�mlamalar� kullanbilirsiniz (�rn:
		'*.altavista.com' veya '192.168.*').
		";
		
$GLOBALS['phpAds_hlp_begin_of_week'] = "
		�o�u insan i�in hafta Pazartesi ba�lar. Fakat isterseniz Pazar g�n� ba�latabilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_percentage_decimals'] = "
		�statistik sayfalar�nda ka� tane ondal�k alan� olaca��n� belirtiniz.
		";
		
$GLOBALS['phpAds_hlp_warn_admin'] = "
		".$phpAds_productname." program� kampanyan�n belirli bir t�klama veya g�r�nt�lenme
		say�s� kald���nda size e-mail atabilir. Bu �zellik �ntan�l� a��kt�r.
		";
		
$GLOBALS['phpAds_hlp_warn_client'] = "
		".$phpAds_productname." program� bir kampanyan�n belirli bir t�klama ve g�r�t�lenme
		say�s� kald���nda reklamc�ya e-mail atabilir. Bu �zellik �ntan�ml� a��kt�r.
		";
		
$GLOBALS['phpAds_hlp_qmail_patch'] = "
		Baz� qmail s�r�mleri ".$phpAds_productname." program� taraf�ndan g�nderilen maillerin
		i�erisine mailin ba�l�k k�sm�n� g�mmektedir. Bu ayar� a�arsan�z ".$phpAds_productname."
		program� mailleri qmail uyumlu bi�imde g�nderecektir.
		";
		
$GLOBALS['phpAds_hlp_warn_limit'] = "
		".$phpAds_productname." program�n�n uyar� e-mailleri g�nderme s�n�rlamas�. Bu �ntan�ml�
		100d�r.
		";
		
$GLOBALS['phpAds_hlp_allow_invocation_plain'] = 
$GLOBALS['phpAds_hlp_allow_invocation_js'] = 
$GLOBALS['phpAds_hlp_allow_invocation_frame'] = 
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] = 
$GLOBALS['phpAds_hlp_allow_invocation_local'] = 
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] = 
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "
		Bu ayarlar invocation tiplerine izin verdi�inizi belirtir. Bu bi�imlerden
		birisi kapal� ise invocationcode ve bannercode i�erisinde kullan�labilir olmayacakt�r.
		�NEML�: Se�ilmeseler bile invocation metodlar� �al��acakt�r. Sadece kod
		�retiminde kullan�lmayacakt�r.
		";
		
$GLOBALS['phpAds_hlp_con_key'] = "
		".$phpAds_productname." program� g��l� bir d�zeltme mod�l�ne sahiptir.
		Daha fazla bilgi i�in kullan�c� klavuzunu okuyunuz. Bu �zellikler, durum
		anahtar kelimelerini kullanabilirsiniz. �ntan�ml� a��kt�r.
		";
		
$GLOBALS['phpAds_hlp_mult_key'] = "
		E�er banner g�stermek i�in direk se�im y�ntemini kullan�yorsan�z, bir yada
		birden fazla anahtar kelime se�ebilirsiniz. Birden fazla anahtar kelime se�erseniz
		bu �zellik a��lmal�d�r. �ntan�ml� olarak a��kt�r.
		";
		
$GLOBALS['phpAds_hlp_acl'] = "
		Teslimat s�n�rlamalar� kullanm�yorsan�z bu �zelli�i bu parametreyi kullan�p kapatabilirsiniz.
		Bu ".$phpAds_productname." sistemini h�zland�racakt�r.
		";
		
$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = "
		".$phpAds_productname." program� veritaban�na ba�lanmazsa veya e�le�en bir banner bulamazsa
		mesela veritaban�n�n bozulmas� veya silinmesi durumunda, bo� sayfa basacakt�r.
		Baz� kullan�c�lar bu durumda �ntan�ml� bir banner g�sterilmesini isteyecektir.
		Bu bannerla ilgili hi�bir istatistik tutulmamaktad�r. Bu �zellik �ntan�ml� kapal�d�r.
		";
		
$GLOBALS['phpAds_hlp_zone_cache'] = "
        E�er alanlar� kullan�yorsan�z ".$phpAds_productname." program� banner bilgilerini daha
		sonra kullan�lmas� i�in haf�zada tutabilir. Bu ".$phpAds_productname." program�n�n h�zl�
		�al��mas�n� sa�lar. Program �al���rken Alan bilgisini almak i�in ve banner�n bilgisini 
		almak i�in ve do�ru banne� se�mek i�in ".$phpAds_productname." program� sadece haf�za
		y�kler. Bu �zellik �ntan�ml� a��kt�r.
		";
		
$GLOBALS['phpAds_hlp_zone_cache_limit'] = "
        Haf�zalanm�� alanlar kullan�yorsan�z, haf�za i�erisindeki bilgiler g�ncellenebilir.
		".$phpAds_productname." program� haf�zay� yeniden olu�turdu�u zaman, alana eklenen
		yeni bannerlarda haf�za al�n�r. Bu ayar size haf�zan�n ne kadar s�rede tazelenece�ini
		ve en fazla ya�ama s�resini belirtir. �rne�in: Bu ayar� 600 olarak ayarlarsan�z,
		haf�za her 10 dakikada bir yenilenir.
		";
		
$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = 
$GLOBALS['phpAds_hlp_type_txt_allow'] = "
        ".$phpAds_productname." program� farkl� tiplerde bannerlar� destekler ve bunlar�
		farkl� yollarla kaydeder. �lk iki se�im yerel depolama i�in kullan�l�r. Y�netici
		arabiriminden banner y�kleyebilirsiniz ve ".$phpAds_productname." program� bunlar�
		SQL veritaban�na veya web sunucuya kaydeder. Harici web sunucudaki bannerlar� da 
		kullanabilirsiniz veya HTML kullanabilirsiniz veya basit bir yaz� ile de banner
		olu�turabilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_type_web_mode'] = "
        E�er bannerlar�n web sunucuda saklanmas�n� se�erseniz, bu ayarlar� yapmak 
		zorundas�n�z. Bannerlar� yerel klas�rde saklamak istiyorsan�z bu ayarlar�
		<i>Yerel Klas�r</i> olarak ayarlay�n�z. E�er bannerlar�n�z� harici web sunucu
		�zerinde saklamak istiyorsan�z bu ayarlar� <i>Harici FTP Sunucu</i> olarak 
		ayarlay�n�z. Yerel sunucu haricindeki sunucularda FTP ayarlar�n� kullanman�z
		gerekmektedir.
		";
		
$GLOBALS['phpAds_hlp_type_web_dir'] = "
		".$phpAds_productname." program�n�n g�nderilen bannerlar� nereye kopyalayaca��n�
		(hangi klas�re) belirtiniz. Bu klas�r PHP taraf�ndan yaz�labilir olmal�d�r. Bu 
		klas�r�n UNIX izinlerinin ayarlanmas�n� gerektirir(chmod). Burada belirtti�iniz
		klas�r web sunucu �zerinde web payla��m� olan (web sunucu web hizmeti verebilmelidir)
		yerde olmal�d�r. Son (/)� yazmay�n�z. Depolamak i�in <i>Yerel Klas�r</i> metodunu 
		se�tiyseniz bu ayarlar� yapmal�s�n�z.
		";
		
$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "
		Depolama metodunu <i>Harici FTP sunucusu</i> olarak belirlediyseniz, ".$phpAds_productname." 
		program�n�n bannerlar� g�nderece�i harici FTP sunucunun IP Adresi veya domain ad�n� 
		belirtmelisiniz.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "
		Depolama metodunu <i>Harici FTP sunucusu</i> olarak belirlediyseniz, ".$phpAds_productname." 
		program�n�n harici FTP sunucuda bannerlar� g�nderece�i klas�r ismini belirtmelisiniz.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "
		Depolama metodunu <i>Harici FTP sunucusu</i> olarak belirlediyseniz, ".$phpAds_productname." 
		program�n�n harici FTP sunucuya ula�mas� i�in kullanaca�� kullan�c� ad�n� belirtmelisiniz.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "
		Depolama metodunu <i>Harici FTP sunucusu</i> olarak belirlediyseniz, ".$phpAds_productname." 
		program�n�n harici FTP sunucuya ula�mas� i�in kullanaca�� parolay� belirtmelisiniz.
		";
      
$GLOBALS['phpAds_hlp_type_web_url'] = "
		E�er bannerlar�n�z� web sunucusu �zerinde tutuyorsan�z, ".$phpAds_productname." program�
		bannerlar� saklad���n�z klas�r�n umumi konumunu bilmek zorundad�r. (En son / � koymay�n�z.)
		";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "
		E�er bu �zellik a��k ise ".$phpAds_productname." program� HTML banner kodu i�erisine otomatik olarak t�klanma
		izleme kodunu g�nderir. Ama bu �zellik a��k oldu�u zaman bannerdaki bu �zellik a��k ise
		banner �zlelli�ini yok sayar.
		";
		
$GLOBALS['phpAds_hlp_type_html_php'] = $phpAds_productname."
		program�n�n HTML bannerlar� i�erisndeki PHP kodlar�n� �al��t�rmas�na izin ver.
		Bu �zellik �ntan�ml� olarak kapal�d�r.
		";
		
$GLOBALS['phpAds_hlp_admin'] = "
		Site y�neticisi kullan�c� ad�, y�netici arabirimindeki loglarda kullan�lacak
		kullan�c� ad�n� belirtebilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_pwold'] = 
$GLOBALS['phpAds_hlp_pw'] = 
$GLOBALS['phpAds_hlp_pw2'] = "
		Y�netici parolas�n� de�i�tirmek i�in, eski parolay� girmeniz gerekiyor.
		Yeni parolay� da yaz�m hatalar�na kar�� g�venli olsun diye iki defa
		girmeniz gerekmektedir.
		";
		
$GLOBALS['phpAds_hlp_admin_fullname'] = "
		Site Y�neticisinin tam ismini belirtiniz. Bu istatistik mailleri g�nderilirken
		kullan�lacakt�r.
		";
		
$GLOBALS['phpAds_hlp_admin_email'] = "
		Site y�neticisinin e-mail adresini belirtiniz. Bu e-mail hesab� g�nderilen 
		istatistik maillerinin kimden k�sm�na yaz�lacakt�r.
		";
		
$GLOBALS['phpAds_hlp_admin_email_headers'] = $phpAds_productname."
		program� taraf�ndan g�nderilen e-maillere e-mail ba�l�klar� ekleyebilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_admin_novice'] = "
		Herhangi reklamc�, kampanya, banner, yay�nc� ve/veya alan silerken uyar� verilmesini
		istiyorsan�z bu �zelli�i a��n�z.
		";
		
$GLOBALS['phpAds_hlp_client_welcome'] = "
		E�er bu �zelli�i aktif ederseniz, reklamc� giri� yapt�ktan sonra ilk sayfada ho�geldiniz
		mesaj� g�r�nt�lenecektir. Bu mesaj� welcome.html dosyas�n� (admin/templates klas�r�nde)
		d�zenleyerek ki�iselle�tirebilirsiniz. Eklemek isteyebilece�iniz veriler: Firma isminiz,
		irtibat bilgileri, firma logonuz, reklam oranlar� ile ilgili sayfa linki....
		";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
		Welcome.html dosyas�n� de�i�tirmenin yan�nda buradaki ufak alana da belirtebilirsiniz.
		E�er buraya bir yaz� girerseniz, welcome.html dosyas� yok say�lacakt�r. html etiketleri
		kulan�labilir.
		";
		
$GLOBALS['phpAds_hlp_updates_frequency'] = $phpAds_productname."
		program�n�n yeni s�r�mlerini kontrol etmek istiyorsan�z bu se�ene�i aktif edebilirsiniz.
		".$phpAds_productname." program�n�n sunucu ile ba�lanmas�n� sa�lar. E�er yeni bir s�r�m 
		bulunursa a��lan kutu i�erisinde bilgi verilecektir.
		";
		
$GLOBALS['phpAds_hlp_userlog_email'] = $phpAds_productname."
		program� taraf�ndan g�nderilen t�m mailleri depolamak istiyorsan�z bu �zelli�i
		aktif etmelisiniz. Bu e-mail mesajlar� kullan�c� loglar� i�erisinde depolanacakt�r.
		";
		
$GLOBALS['phpAds_hlp_userlog_priority'] = "
		�ncelik hesab�n�n do�ru olarak hesapland���ndan emin olmak i�in, saatlik
		hesaplamalar� raporlayabilirsiniz. Bu rapor olas�l�k profilini ve t�m bannelar�n
		�nceliklerini i�erir. Bu bilgileri olas�l�k hesaplamalar� ile ilgili bir problemi 
		bildirmek i�in kullanabilirsiniz. Bu bilgileri kullan�c� loglar� i�erisinde depolar.
		";
		
$GLOBALS['phpAds_hlp_default_banner_weight'] = "
		E�er y�ksek �neme sahip �ntan�ml� banner kullanmak istiyorsan�z �nem ayar�n� buradan
		yapabilirsiniz. �ntan�ml� olarak bu de�er 1dir.
		";
		
$GLOBALS['phpAds_hlp_default_campaign_weight'] = "
		E�er y�ksek �neme sahip �ntan�ml� kampanya kullanmak istiyorsan�z �nem ayar�n� buradan 
		yapabilirsiniz. �ntan�ml� olarak bu de�er 1dir.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "
		E�er bu se�enek se�ili ise kampanyalar hakk�nda ekstra bilgiler <i>Kampanya �nizleme</i>
		sayfas�nda g�sterilir. Ekstra bilgi kalan g�r�nt�lenme say�s�n�, kalan t�klama say�s�n�,
		aktivasyon tarihini, biti� tarihini ve �ncelik ayarlar�n� i�erir.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
		E�er bu se�enek se�ilmi� ise banner hakk�ndaki ekstra bilgiler <i>Banner �zellikleri</i>
		sayfas�nda g�sterilir. Ekstra bilgi hedef URL, anahtar kelimeler, boyut ve banner �nemini
		i�erir.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
		E�er bu se�enek se�ili ise <i>Banner �nizleme</i> sayfas�nda t�m bannerlar�n �nizlemesi
		g�r�nt�lenir. E�er bu se�enek se�ili de�il ise <i>Banner �nizleme</i> sayfas�nda bannerlar�n
		yan�ndaki ��genlere basarak bannerlar g�r�nt�lenebilir.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "
		E�er bu se�enek se�ilmi� ise HTML Bannerlar� HTMLsiz olarak g�sterilir. Bu �zellik �ntan�ml�
		olarak se�ilmemi�tir, ��nk� HTML Banner� kullan�c� aray�z� ile �ak��abilir. Bu se�enek se�ili
		de�ilken bile HTML banner, <i>Banner G�ster</i> butonuna t�klanarak g�r�nt�lenebilir.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "
		E�er bu se�enek se�ilmi� ise �nizleme <i>Banner �zellikleri</i>, <i>Teslimat Ayarlar�</i> ve 
		<i>�li�kilendirilmi� Alanlar</i> sayfalar�n�n en �st�nde g�r�nt�lenecektir. Bu se�enek se�ilmemei�
		ise bannerlar� g�r�nt�lemek i�in sayfalar�n en �st�nde bulunan <i>Banner G�ster</i> butonuna
		basabilirsiniz.
		";
		
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "
		E�er bu se�enek se�ilmi� ise t�m pasif bannerlar, kampanyalar ve reklamc�lar <i>Reklamc�lar & 
		Kampanyalar</i> ve <i>Kampanya �nizleme</i> sayfalar�nda gizlenecektir. E�er bu se�enek se�ilmi�
		ise t�m gizlenmi� ��eler sayfan�n alt�nda bulunan <i>Hepsini G�ster</i> butonu ile g�r�nt�lenebilir.
		";
		
?>