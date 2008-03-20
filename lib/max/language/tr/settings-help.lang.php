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
		$phpAds_dbmsname." veritabanının veritabanı sunucusunu belirtiniz.
		";

$GLOBALS['phpAds_hlp_dbuser'] =
		$phpAds_productname." programının ".$phpAds_dbmsname." veritabanına bağlanması için kullanıcı adını belirtiniz.
		";

$GLOBALS['phpAds_hlp_dbpassword'] =
		$phpAds_productname." programının ".$phpAds_dbmsname." veritabanına bağlanması için parolanızı belirtiniz.
		";

$GLOBALS['phpAds_hlp_dbname'] =
		$phpAds_productname." programının verilerini saklayacağı veritabanını belirtiniz.
		";

$GLOBALS['phpAds_hlp_persistent_connections'] = "
		İnatçı bağlantıları kullanırsanız ".$phpAds_productname." programı hızlanır ve sunucuya
		yükünü azaltır. Buna rağmen çok kullanıcının ziyaret ettiği sitelerde server yükü fazlalaşacağından
		hatta normal zamanlardaki bağlantılardan daha fazla olacağından dolayı dezavantajı vardır.
		Düzenli bağlantıları veya inatçı bağlantıları ziyaretçi sayınız ve donanımınız destekliyorsa
		kullanabilirsiniz. Eğer ".$phpAds_productname." programı çok fazla kaynak harcıyorsa ilk olarak
		bakacağınız ayar burasıdır.
		";

$GLOBALS['phpAds_hlp_insert_delayed'] = "
        ".$phpAds_dbmsname." veritabanı veri girilirken tabloları kilitlesin. Çok sayıda ziyaretçiniz varsa
		".$phpAds_productname." programı yeni veri girişi esnasında bekler, çünkü veritabanı kilitlidir.
		Veri ekleme gecikmesi kullanırsanız, beklemezsiniz ve yeni veri daha tablonun açık olduğu sırada
		sonra da eklenebilir.
		";

$GLOBALS['phpAds_hlp_compatibility_mode'] = "
		Eğer ".$phpAds_productname." ile üçüncü parti bir programın bir bütün olarak çalışmasında
		problem yaşıyorsanız, veritabanı uyum modunu kullanabilirsiniz. Eğer yerel sistem kullanıyorsanız
		ve veritabanı uyum modu açık ise ".$phpAds_productname." programı veritabanı durumunu çalışmadan
		önceki durumu gibi teslim eder. Bu özellik sistemi biraz yavaşlatabilir. Bundan dolayı öntanımlı
		olarak kapatılmıştır.
		";

$GLOBALS['phpAds_hlp_table_prefix'] = "
		".$phpAds_productname." veritabanı birden fazla programla kullanılıyorsa tablolara önad koymak
		akıllıca olur. ".$phpAds_productname." programının birden fazla kopyasını aynı veritabanında
		kullanıyorsanız, bu önadların farklı olmasını istersiniz.
		";

$GLOBALS['phpAds_hlp_tabletype'] = "
        ".$phpAds_dbmsname." veritabanı farklı tablo yapılarını destekler. Her tablo türü kendine has
		özelliklere sahiptir ve bazıları ".$phpAds_productname." programını hatrı sayılır derecede
		hızlandırabilir. MyISAM öntanımlı tablo yapısıdır ve ".$phpAds_dbmsname." veritabanının
		tüm kurulumları içerir. Diğer tablo yapıları sunucunuz tarafından desteklenmeyebilir.
		";

$GLOBALS['phpAds_hlp_url_prefix'] = "
        ".$phpAds_productname." programı düzgün çalışabilmesi için sunucu üzerinde nerede
		çalıştığını bilmelidir. ".$phpAds_productname." programının kurulu olduğu URLyi
		tam olarak girmelisiniz mesela: http://your-url.com/".$phpAds_productname.".
		";

$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
		Buraya yönetici sayfasındaki üstbilgi ve altbilgi içeren dosyaların yollarını
		belirtebilirsiniz(ör: ../yonetici_paneli/ekstra/header.html). Buraya dosyalara
		yazı veya HTML kodu girebilirsiniz.
		";

$GLOBALS['phpAds_hlp_content_gzip_compression'] = "
		GZIP içerik sıkıştırmayı aktif ettiğiniz takdirde yönetici paneline her girişteki
		tarayıcıya gönderilen veri oranında büyük bir düşüş olur. Bu özelliği aktif
		edebilmeniz için en az GZIP eklentili PHP 4.0.5 sürümüne sahip olmanız gerekiyor.
		";

$GLOBALS['phpAds_hlp_language'] = "
		".$phpAds_productname." programının kullanacağı öntanımlı dili seçiniz. Bu dil
		yönetici ve reklamcılar için öntanımlı olacaktır.
		NOT: Herbir reklamcı için yönetici arabiriminden farklı bir dil seçebilirsiniz veya
		herbir reklamcıya kendi dilini değiştirme izni verebilirsiniz.
		";

$GLOBALS['phpAds_hlp_name'] = "
		Bu uygulama için kullanacağınız program ismini seçiniz. Bu isim tüm
		yönetici ve reklamcı sayfalarında görüntülenecektir. Bu ayarı boş geçerseniz
		(öntanımlı) ".$phpAds_productname." logosu görüntülenecektir.
		";

$GLOBALS['phpAds_hlp_company_name'] = "
		Bu isim ".$phpAds_productname." programı tarafından gönderilen e-maillerde kullanılacaktır.
		";

$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
		".$phpAds_productname." programı genellikle GD kütüphanesinin kurulu olup olmadığını
		ve hangi resim formatlarının desteklenip desteklenmediğini bulur. Herşeye rağmen
		bu sonuç kesin olarak doğrudur veya yanlıştır diyemeyiz, çünkü bazı PHP sürümleri
		desteklenen resim formatlarının bulunmasına izin vermez. Eğer ".$phpAds_productname."
		otomatik bulma sisteminde hata yaparsa doğru resim formatlarını siz belirtmelisiniz.
		Olağan formatlar: hiçbiri, png, jpeg, gif.
		";

$GLOBALS['phpAds_hlp_p3p_policies'] = "
		".$phpAds_productname." programının P3P Gizlilik Politikalarını kullanmasını istiyorsanız
		bu özelliği açınız.
		";

$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
		Cookielerle gönderilen yoğunlaştırılmış politika. Öntanımlı ayar: 'CUR ADM OUR NOR STA NID'
		Bu ayarlama ".$phpAds_productname." programının Internet Explorer 6 üzerinde cookie
		göndermesine izin verir. Eğer isterseniz bu ayarları kendi Gizlilik durumunuza göre
		değiştirebilirsiniz.
		";

$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
		Eğer tam gizlilik politikası kullanmak istiyorsanız, politikanın tam yerini
		belirtebilirsiniz.
		";

$GLOBALS['phpAds_hlp_log_beacon'] = "
		Yol göstericiler bannerların gösterildiği sayfalarda küçük görünmez resimlerdir.
		Bu özelliği açarsanız ".$phpAds_productname." programı bannerın görüntülenme esnaısındaki
		sayısını hesaplar. Bu özelliği kapatırsanız banner görüntülenme sayısı sadece teslimatta
		sayılır fakat bu sayı kesin sayı olmayabilir. Çünkü teslim edilmiş banner her zaman ekranda
		görüntülenmeyebilir.
		";

$GLOBALS['phpAds_hlp_compact_stats'] = "
		Geleneksel olarak ".$phpAds_productname." programı çok detaylı ve bakım gerektiren
		genişletilmiş logları tercih eder. Bu çok ziyaretçili sitelerde büyük problemlere
		yol açabilir. Bu problemi halletmek için ".$phpAds_productname." programı az bakım
		gerektiren ama az detaylı yeni istatistik tipini destekler. Yoğunlaştırılmış istatistikler
		saatlik görüntülenme ve tıklanma sayılarını depolar. Daha fazla detaya ihtiyacınız varsa
		yoğunlaştırılmış istatistikler özelliğini kapatabilirsiniz.
		";

$GLOBALS['phpAds_hlp_log_adviews'] = "
		Normal durumda tüm görüntülenmeler depolanır, ama görüntülenmeleri depolamak
		istemiyorsanız bu özelliği kapatabilirsiniz.
		";

$GLOBALS['phpAds_hlp_block_adviews'] = "
		Eğer bir ziyaretçi sayfayı yenilerse ".$phpAds_productname." her görüntülemeyi depolar.
		Bu özellik belirlediğiniz süre içerisinde görüntülenmelerden sadece birini depolar.
		Örneğin: bu özelliği 300 saniye yaparsanız, ".$phpAds_productname." son 5 dakika içerisinde
		aynı ziyaretçiye sadece tekrar gösterilmeyen bannerların istatistiklerini depolar. Bu
		özellik sadece <i>Görüntülenmeleri loglamak için yol göstericileri kullan</i> seçeneği
		açılmış ise ve tarayıcı cookieleri kabul ediyorsa kullanılır.
		";

$GLOBALS['phpAds_hlp_log_adclicks'] = "
		Normal durumda tüm tıklanmalar depolanır, ama tıklanmalrı depolamak
		istemiyorsanız bu özelliği kapatabilirsiniz.
		";

$GLOBALS['phpAds_hlp_block_adclicks'] = "
		Eğer bir ziyaretçi bir bannera birden fazla tıklarsa ".$phpAds_productname." programı her
		tıklamayı kaydeder. Bu özellik belirlediğiniz süre içerisinde sadece bir tıklamayı depolar.
		Örneğin: bu özelliği 300 saniye yaparsanız, ".$phpAds_productname." son 5 dakika içerisinde
		aynı ziyaretçinin sadece tekrar tıklamadığı bannerların istatistiklerini depolar. Bu
		özellik sadece tarayıcı cookieleri kabul ediyorsa kullanılabilır.
		";

$GLOBALS['phpAds_hlp_reverse_lookup'] = "
		".$phpAds_productname." programı öntanımlı olarak her ziyaretçinin IP adresini depolar.
		Eğer ".$phpAds_productname." programının domain isimlerini depolamasını istiyorsanız
		bu özelliği açabilirsiniz. Geri besleme biraz zaman alabilir ve tüm işlemler biraz
		yavaşlar.
		";

$GLOBALS['phpAds_hlp_proxy_lookup'] = "
		Bazı kullanıcılar internete erişebilmek için proxy sunucular kullanır. Bu durumda
		".$phpAds_productname." programı kullanıcının değilde proxy sunucunun Ip adresini
		veya sunucu adını alır. Eğer bu özelliği açarsanız ".$phpAds_productname." programı
		proxy sunucu arkasındaki kullanıcının IP adresini veya sunucu adını bulmaya çalışır.
		Eğer proxy sunucu kullanılıyorsa kullanıcının kesin adresini bulmak mümkün olmayabilir.
		Bu özellik öntanımlı olarak kapalıdır, çünkü depolama hızını düşürür.
		";

$GLOBALS['phpAds_hlp_ignore_hosts'] = "
		Eğer bazı bilgisayarların tıklama ve görüntüleme sayılarını depolamak
		istemiyorsanız bu bilgisayarları bu listeye  ekleyebilirsiniz. Geri beslemeyi
		açarsanız hem domain adını hem de IP adresini ekleyebilirsiniz, aksi
		takdirde sadece IP adresini yazınız. Tanımlamaları kullanbilirsiniz (Örn:
		'*.altavista.com' veya '192.168.*').
		";

$GLOBALS['phpAds_hlp_begin_of_week'] = "
		Çoğu insan için hafta Pazartesi başlar. Fakat isterseniz Pazar günü başlatabilirsiniz.
		";

$GLOBALS['phpAds_hlp_percentage_decimals'] = "
		İstatistik sayfalarında kaç tane ondalık alanı olacağını belirtiniz.
		";

$GLOBALS['phpAds_hlp_warn_admin'] = "
		".$phpAds_productname." programı kampanyanın belirli bir tıklama veya görüntülenme
		sayısı kaldığında size e-mail atabilir. Bu özellik öntanılı açıktır.
		";

$GLOBALS['phpAds_hlp_warn_client'] = "
		".$phpAds_productname." programı bir kampanyanın belirli bir tıklama ve görütülenme
		sayısı kaldığında reklamcıya e-mail atabilir. Bu özellik öntanımlı açıktır.
		";

$GLOBALS['phpAds_hlp_qmail_patch'] = "
		Bazı qmail sürümleri ".$phpAds_productname." programı tarafından gönderilen maillerin
		içerisine mailin başlık kısmını gömmektedir. Bu ayarı açarsanız ".$phpAds_productname."
		programı mailleri qmail uyumlu biçimde gönderecektir.
		";

$GLOBALS['phpAds_hlp_warn_limit'] = "
		".$phpAds_productname." programının uyarı e-mailleri gönderme sınırlaması. Bu öntanımlı
		100dür.
		";

$GLOBALS['phpAds_hlp_allow_invocation_plain'] =
$GLOBALS['phpAds_hlp_allow_invocation_js'] =
$GLOBALS['phpAds_hlp_allow_invocation_frame'] =
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] =
$GLOBALS['phpAds_hlp_allow_invocation_local'] =
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] =
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "
		Bu ayarlar invocation tiplerine izin verdiğinizi belirtir. Bu biçimlerden
		birisi kapalı ise invocationcode ve bannercode içerisinde kullanılabilir olmayacaktır.
		ÖNEMLİ: Seçilmeseler bile invocation metodları çalışacaktır. Sadece kod
		üretiminde kullanılmayacaktır.
		";

$GLOBALS['phpAds_hlp_con_key'] = "
		".$phpAds_productname." programı güçlü bir düzeltme modülüne sahiptir.
		Daha fazla bilgi için kullanıcı klavuzunu okuyunuz. Bu özellikler, durum
		anahtar kelimelerini kullanabilirsiniz. Öntanımlı açıktır.
		";

$GLOBALS['phpAds_hlp_mult_key'] = "
		Eğer banner göstermek için direk seçim yöntemini kullanıyorsanız, bir yada
		birden fazla anahtar kelime seçebilirsiniz. Birden fazla anahtar kelime seçerseniz
		bu özellik açılmalıdır. Öntanımlı olarak açıktır.
		";

$GLOBALS['phpAds_hlp_acl'] = "
		Teslimat sınırlamaları kullanmıyorsanız bu özelliği bu parametreyi kullanıp kapatabilirsiniz.
		Bu ".$phpAds_productname." sistemini hızlandıracaktır.
		";

$GLOBALS['phpAds_hlp_default_banner_url'] =
$GLOBALS['phpAds_hlp_default_banner_target'] = "
		".$phpAds_productname." programı veritabanına bağlanmazsa veya eşleşen bir banner bulamazsa
		mesela veritabanının bozulması veya silinmesi durumunda, boş sayfa basacaktır.
		Bazı kullanıcılar bu durumda öntanımlı bir banner gösterilmesini isteyecektir.
		Bu bannerla ilgili hiçbir istatistik tutulmamaktadır. Bu özellik öntanımlı kapalıdır.
		";

$GLOBALS['phpAds_hlp_zone_cache'] = "
        Eğer alanları kullanıyorsanız ".$phpAds_productname." programı banner bilgilerini daha
		sonra kullanılması için hafızada tutabilir. Bu ".$phpAds_productname." programının hızlı
		çalışmasını sağlar. Program çalışırken Alan bilgisini almak için ve bannerın bilgisini
		almak için ve doğru banneı seçmek için ".$phpAds_productname." programı sadece hafıza
		yükler. Bu özellik öntanımlı açıktır.
		";

$GLOBALS['phpAds_hlp_zone_cache_limit'] = "
        Hafızalanmış alanlar kullanıyorsanız, hafıza içerisindeki bilgiler güncellenebilir.
		".$phpAds_productname." programı hafızayı yeniden oluşturduğu zaman, alana eklenen
		yeni bannerlarda hafıza alınır. Bu ayar size hafızanın ne kadar sürede tazeleneceğini
		ve en fazla yaşama süresini belirtir. Örneğin: Bu ayarı 600 olarak ayarlarsanız,
		hafıza her 10 dakikada bir yenilenir.
		";

$GLOBALS['phpAds_hlp_type_sql_allow'] =
$GLOBALS['phpAds_hlp_type_web_allow'] =
$GLOBALS['phpAds_hlp_type_url_allow'] =
$GLOBALS['phpAds_hlp_type_html_allow'] =
$GLOBALS['phpAds_hlp_type_txt_allow'] = "
        ".$phpAds_productname." programı farklı tiplerde bannerları destekler ve bunları
		farklı yollarla kaydeder. İlk iki seçim yerel depolama için kullanılır. Yönetici
		arabiriminden banner yükleyebilirsiniz ve ".$phpAds_productname." programı bunları
		SQL veritabanına veya web sunucuya kaydeder. Harici web sunucudaki bannerları da
		kullanabilirsiniz veya HTML kullanabilirsiniz veya basit bir yazı ile de banner
		oluşturabilirsiniz.
		";

$GLOBALS['phpAds_hlp_type_web_mode'] = "
        Eğer bannerların web sunucuda saklanmasını seçerseniz, bu ayarları yapmak
		zorundasınız. Bannerları yerel klasörde saklamak istiyorsanız bu ayarları
		<i>Yerel Klasör</i> olarak ayarlayınız. Eğer bannerlarınızı harici web sunucu
		üzerinde saklamak istiyorsanız bu ayarları <i>Harici FTP Sunucu</i> olarak
		ayarlayınız. Yerel sunucu haricindeki sunucularda FTP ayarlarını kullanmanız
		gerekmektedir.
		";

$GLOBALS['phpAds_hlp_type_web_dir'] = "
		".$phpAds_productname." programının gönderilen bannerları nereye kopyalayacağını
		(hangi klasöre) belirtiniz. Bu klasör PHP tarafından yazılabilir olmalıdır. Bu
		klasörün UNIX izinlerinin ayarlanmasını gerektirir(chmod). Burada belirttiğiniz
		klasör web sunucu üzerinde web paylaşımı olan (web sunucu web hizmeti verebilmelidir)
		yerde olmalıdır. Son (/)ı yazmayınız. Depolamak için <i>Yerel Klasör</i> metodunu
		seçtiyseniz bu ayarları yapmalısınız.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "
		Depolama metodunu <i>Harici FTP sunucusu</i> olarak belirlediyseniz, ".$phpAds_productname."
		programının bannerları göndereceği harici FTP sunucunun IP Adresi veya domain adını
		belirtmelisiniz.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "
		Depolama metodunu <i>Harici FTP sunucusu</i> olarak belirlediyseniz, ".$phpAds_productname."
		programının harici FTP sunucuda bannerları göndereceği klasör ismini belirtmelisiniz.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "
		Depolama metodunu <i>Harici FTP sunucusu</i> olarak belirlediyseniz, ".$phpAds_productname."
		programının harici FTP sunucuya ulaşması için kullanacağı kullanıcı adını belirtmelisiniz.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "
		Depolama metodunu <i>Harici FTP sunucusu</i> olarak belirlediyseniz, ".$phpAds_productname."
		programının harici FTP sunucuya ulaşması için kullanacağı parolayı belirtmelisiniz.
		";

$GLOBALS['phpAds_hlp_type_web_url'] = "
		Eğer bannerlarınızı web sunucusu üzerinde tutuyorsanız, ".$phpAds_productname." programı
		bannerları sakladığınız klasörün umumi konumunu bilmek zorundadır. (En son / ı koymayınız.)
		";

$GLOBALS['phpAds_hlp_type_html_auto'] = "
		Eğer bu özellik açık ise ".$phpAds_productname." programı HTML banner kodu içerisine otomatik olarak tıklanma
		izleme kodunu gönderir. Ama bu özellik açık olduğu zaman bannerdaki bu özellik açık ise
		banner özlelliğini yok sayar.
		";

$GLOBALS['phpAds_hlp_type_html_php'] = $phpAds_productname."
		programının HTML bannerları içerisndeki PHP kodlarını çalıştırmasına izin ver.
		Bu özellik öntanımlı olarak kapalıdır.
		";

$GLOBALS['phpAds_hlp_admin'] = "
		Site yöneticisi kullanıcı adı, yönetici arabirimindeki loglarda kullanılacak
		kullanıcı adını belirtebilirsiniz.
		";

$GLOBALS['phpAds_hlp_pwold'] =
$GLOBALS['phpAds_hlp_pw'] =
$GLOBALS['phpAds_hlp_pw2'] = "
		Yönetici parolasını değiştirmek için, eski parolayı girmeniz gerekiyor.
		Yeni parolayı da yazım hatalarına karşı güvenli olsun diye iki defa
		girmeniz gerekmektedir.
		";

$GLOBALS['phpAds_hlp_admin_fullname'] = "
		Site Yöneticisinin tam ismini belirtiniz. Bu istatistik mailleri gönderilirken
		kullanılacaktır.
		";

$GLOBALS['phpAds_hlp_admin_email'] = "
		Site yöneticisinin e-mail adresini belirtiniz. Bu e-mail hesabı gönderilen
		istatistik maillerinin kimden kısmına yazılacaktır.
		";

$GLOBALS['phpAds_hlp_admin_email_headers'] = $phpAds_productname."
		programı tarafından gönderilen e-maillere e-mail başlıkları ekleyebilirsiniz.
		";

$GLOBALS['phpAds_hlp_admin_novice'] = "
		Herhangi reklamcı, kampanya, banner, yayıncı ve/veya alan silerken uyarı verilmesini
		istiyorsanız bu özelliği açınız.
		";

$GLOBALS['phpAds_hlp_client_welcome'] = "
		Eğer bu özelliği aktif ederseniz, reklamcı giriş yaptıktan sonra ilk sayfada hoşgeldiniz
		mesajı görüntülenecektir. Bu mesajı welcome.html dosyasını (admin/templates klasöründe)
		düzenleyerek kişiselleştirebilirsiniz. Eklemek isteyebileceğiniz veriler: Firma isminiz,
		irtibat bilgileri, firma logonuz, reklam oranları ile ilgili sayfa linki....
		";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
		Welcome.html dosyasını değiştirmenin yanında buradaki ufak alana da belirtebilirsiniz.
		Eğer buraya bir yazı girerseniz, welcome.html dosyası yok sayılacaktır. html etiketleri
		kulanılabilir.
		";

$GLOBALS['phpAds_hlp_updates_frequency'] = $phpAds_productname."
		programının yeni sürümlerini kontrol etmek istiyorsanız bu seçeneği aktif edebilirsiniz.
		".$phpAds_productname." programının sunucu ile bağlanmasını sağlar. Eğer yeni bir sürüm
		bulunursa açılan kutu içerisinde bilgi verilecektir.
		";

$GLOBALS['phpAds_hlp_userlog_email'] = $phpAds_productname."
		programı tarafından gönderilen tüm mailleri depolamak istiyorsanız bu özelliği
		aktif etmelisiniz. Bu e-mail mesajları kullanıcı logları içerisinde depolanacaktır.
		";

$GLOBALS['phpAds_hlp_userlog_priority'] = "
		Öncelik hesabının doğru olarak hesaplandığından emin olmak için, saatlik
		hesaplamaları raporlayabilirsiniz. Bu rapor olasılık profilini ve tüm banneların
		önceliklerini içerir. Bu bilgileri olasılık hesaplamaları ile ilgili bir problemi
		bildirmek için kullanabilirsiniz. Bu bilgileri kullanıcı logları içerisinde depolar.
		";

$GLOBALS['phpAds_hlp_default_banner_weight'] = "
		Eğer yüksek öneme sahip öntanımlı banner kullanmak istiyorsanız önem ayarını buradan
		yapabilirsiniz. Öntanımlı olarak bu değer 1dir.
		";

$GLOBALS['phpAds_hlp_default_campaign_weight'] = "
		Eğer yüksek öneme sahip öntanımlı kampanya kullanmak istiyorsanız önem ayarını buradan
		yapabilirsiniz. Öntanımlı olarak bu değer 1dir.
		";

$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "
		Eğer bu seçenek seçili ise kampanyalar hakkında ekstra bilgiler <i>Kampanya Önizleme</i>
		sayfasında gösterilir. Ekstra bilgi kalan görüntülenme sayısını, kalan tıklama sayısını,
		aktivasyon tarihini, bitiş tarihini ve öncelik ayarlarını içerir.
		";

$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
		Eğer bu seçenek seçilmiş ise banner hakkındaki ekstra bilgiler <i>Banner Özellikleri</i>
		sayfasında gösterilir. Ekstra bilgi hedef URL, anahtar kelimeler, boyut ve banner önemini
		içerir.
		";

$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
		Eğer bu seçenek seçili ise <i>Banner Önizleme</i> sayfasında tüm bannerların önizlemesi
		görüntülenir. Eğer bu seçenek seçili değil ise <i>Banner Önizleme</i> sayfasında bannerların
		yanındaki üçgenlere basarak bannerlar görüntülenebilir.
		";

$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "
		Eğer bu seçenek seçilmiş ise HTML Bannerları HTMLsiz olarak gösterilir. Bu özellik öntanımlı
		olarak seçilmemiştir, çünkü HTML Bannerı kullanıcı arayüzü ile çakışabilir. Bu seçenek seçili
		değilken bile HTML banner, <i>Banner Göster</i> butonuna tıklanarak görüntülenebilir.
		";

$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "
		Eğer bu seçenek seçilmiş ise önizleme <i>Banner Özellikleri</i>, <i>Teslimat Ayarları</i> ve
		<i>İlişkilendirilmiş Alanlar</i> sayfalarının en üstünde görüntülenecektir. Bu seçenek seçilmemeiş
		ise bannerları görüntülemek için sayfaların en üstünde bulunan <i>Banner Göster</i> butonuna
		basabilirsiniz.
		";

$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "
		Eğer bu seçenek seçilmiş ise tüm pasif bannerlar, kampanyalar ve reklamcılar <i>Reklamcılar &
		Kampanyalar</i> ve <i>Kampanya Önizleme</i> sayfalarında gizlenecektir. Eğer bu seçenek seçilmiş
		ise tüm gizlenmiş öğeler sayfanın altında bulunan <i>Hepsini Göster</i> butonu ile görüntülenebilir.
		";

?>