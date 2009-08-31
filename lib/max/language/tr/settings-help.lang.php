<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
		MAX_PRODUCT_NAME." programının ".$phpAds_dbmsname." veritabanına bağlanması için kullanıcı adını belirtiniz.
		";

$GLOBALS['phpAds_hlp_dbpassword'] =
		MAX_PRODUCT_NAME." programının ".$phpAds_dbmsname." veritabanına bağlanması için parolanızı belirtiniz.
		";

$GLOBALS['phpAds_hlp_dbname'] =
		MAX_PRODUCT_NAME." programının verilerini saklayacağı veritabanını belirtiniz.
		";

$GLOBALS['phpAds_hlp_persistent_connections'] = "\n		İnatçı bağlantıları kullanırsanız ".MAX_PRODUCT_NAME." programı hızlanır ve sunucuya\n		yükünü azaltır. Buna rağmen çok kullanıcının ziyaret ettiği sitelerde server yükü fazlalaşacağından\n		hatta normal zamanlardaki bağlantılardan daha fazla olacağından dolayı dezavantajı vardır.\n		Düzenli bağlantıları veya inatçı bağlantıları ziyaretçi sayınız ve donanımınız destekliyorsa\n		kullanabilirsiniz. Eğer ".MAX_PRODUCT_NAME." programı çok fazla kaynak harcıyorsa ilk olarak\n		bakacağınız ayar burasıdır.\n		";

$GLOBALS['phpAds_hlp_insert_delayed'] = "\n        ".$phpAds_dbmsname." veritabanı veri girilirken tabloları kilitlesin. Çok sayıda ziyaretçiniz varsa\n		".MAX_PRODUCT_NAME." programı yeni veri girişi esnasında bekler, çünkü veritabanı kilitlidir.\n		Veri ekleme gecikmesi kullanırsanız, beklemezsiniz ve yeni veri daha tablonun açık olduğu sırada\n		sonra da eklenebilir.\n		";

$GLOBALS['phpAds_hlp_compatibility_mode'] = "\n		Eğer ".MAX_PRODUCT_NAME." ile üçüncü parti bir programın bir bütün olarak çalışmasında\n		problem yaşıyorsanız, veritabanı uyum modunu kullanabilirsiniz. Eğer yerel sistem kullanıyorsanız\n		ve veritabanı uyum modu açık ise ".MAX_PRODUCT_NAME." programı veritabanı durumunu çalışmadan\n		önceki durumu gibi teslim eder. Bu özellik sistemi biraz yavaşlatabilir. Bundan dolayı öntanımlı\n		olarak kapatılmıştır.\n		";

$GLOBALS['phpAds_hlp_table_prefix'] = "\n		".MAX_PRODUCT_NAME." veritabanı birden fazla programla kullanılıyorsa tablolara önad koymak\n		akıllıca olur. ".MAX_PRODUCT_NAME." programının birden fazla kopyasını aynı veritabanında\n		kullanıyorsanız, bu önadların farklı olmasını istersiniz.\n		";

$GLOBALS['phpAds_hlp_tabletype'] = "\n        ".$phpAds_dbmsname." veritabanı farklı tablo yapılarını destekler. Her tablo türü kendine has\n		özelliklere sahiptir ve bazıları ".MAX_PRODUCT_NAME." programını hatrı sayılır derecede\n		hızlandırabilir. MyISAM öntanımlı tablo yapısıdır ve ".$phpAds_dbmsname." veritabanının\n		tüm kurulumları içerir. Diğer tablo yapıları sunucunuz tarafından desteklenmeyebilir.\n		";

$GLOBALS['phpAds_hlp_url_prefix'] = "\n        ".MAX_PRODUCT_NAME." programı düzgün çalışabilmesi için sunucu üzerinde nerede\n		çalıştığını bilmelidir. ".MAX_PRODUCT_NAME." programının kurulu olduğu URLyi\n		tam olarak girmelisiniz mesela: http://your-url.com/".MAX_PRODUCT_NAME.".\n		";

$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "\n		Buraya yönetici sayfasındaki üstbilgi ve altbilgi içeren dosyaların yollarını\n		belirtebilirsiniz(ör: ../yonetici_paneli/ekstra/header.html). Buraya dosyalara\n		yazı veya HTML kodu girebilirsiniz.\n		";

$GLOBALS['phpAds_hlp_content_gzip_compression'] = "\n		GZIP içerik sıkıştırmayı aktif ettiğiniz takdirde yönetici paneline her girişteki\n		tarayıcıya gönderilen veri oranında büyük bir düşüş olur. Bu özelliği aktif\n		edebilmeniz için en az GZIP eklentili PHP 4.0.5 sürümüne sahip olmanız gerekiyor.\n		";

$GLOBALS['phpAds_hlp_language'] = "\n		".MAX_PRODUCT_NAME." programının kullanacağı öntanımlı dili seçiniz. Bu dil\n		yönetici ve reklamcılar için öntanımlı olacaktır.\n		NOT: Herbir reklamcı için yönetici arabiriminden farklı bir dil seçebilirsiniz veya\n		herbir reklamcıya kendi dilini değiştirme izni verebilirsiniz.\n		";

$GLOBALS['phpAds_hlp_name'] = "\n		Bu uygulama için kullanacağınız program ismini seçiniz. Bu isim tüm\n		yönetici ve reklamcı sayfalarında görüntülenecektir. Bu ayarı boş geçerseniz\n		(öntanımlı) ".MAX_PRODUCT_NAME." logosu görüntülenecektir.\n		";

$GLOBALS['phpAds_hlp_company_name'] = "\n		Bu isim ".MAX_PRODUCT_NAME." programı tarafından gönderilen e-maillerde kullanılacaktır.\n		";

$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "\n		".MAX_PRODUCT_NAME." programı genellikle GD kütüphanesinin kurulu olup olmadığını\n		ve hangi resim formatlarının desteklenip desteklenmediğini bulur. Herşeye rağmen\n		bu sonuç kesin olarak doğrudur veya yanlıştır diyemeyiz, çünkü bazı PHP sürümleri\n		desteklenen resim formatlarının bulunmasına izin vermez. Eğer ".MAX_PRODUCT_NAME."\n		otomatik bulma sisteminde hata yaparsa doğru resim formatlarını siz belirtmelisiniz.\n		Olağan formatlar: hiçbiri, png, jpeg, gif.\n		";

$GLOBALS['phpAds_hlp_p3p_policies'] = "\n		".MAX_PRODUCT_NAME." programının P3P Gizlilik Politikalarını kullanmasını istiyorsanız\n		bu özelliği açınız.\n		";

$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "\n		Cookielerle gönderilen yoğunlaştırılmış politika. Öntanımlı ayar: 'CUR ADM OUR NOR STA NID'\n		Bu ayarlama ".MAX_PRODUCT_NAME." programının Internet Explorer 6 üzerinde cookie\n		göndermesine izin verir. Eğer isterseniz bu ayarları kendi Gizlilik durumunuza göre\n		değiştirebilirsiniz.\n		";

$GLOBALS['phpAds_hlp_p3p_policy_location'] = "\n		Eğer tam gizlilik politikası kullanmak istiyorsanız, politikanın tam yerini\n		belirtebilirsiniz.\n		";

$GLOBALS['phpAds_hlp_log_beacon'] = "\n		Yol göstericiler bannerların gösterildiği sayfalarda küçük görünmez resimlerdir.\n		Bu özelliği açarsanız ".MAX_PRODUCT_NAME." programı bannerın görüntülenme esnaısındaki\n		sayısını hesaplar. Bu özelliği kapatırsanız banner görüntülenme sayısı sadece teslimatta\n		sayılır fakat bu sayı kesin sayı olmayabilir. Çünkü teslim edilmiş banner her zaman ekranda\n		görüntülenmeyebilir.\n		";

$GLOBALS['phpAds_hlp_compact_stats'] = "\n		Geleneksel olarak ".MAX_PRODUCT_NAME." programı çok detaylı ve bakım gerektiren\n		genişletilmiş logları tercih eder. Bu çok ziyaretçili sitelerde büyük problemlere\n		yol açabilir. Bu problemi halletmek için ".MAX_PRODUCT_NAME." programı az bakım\n		gerektiren ama az detaylı yeni istatistik tipini destekler. Yoğunlaştırılmış istatistikler\n		saatlik görüntülenme ve tıklanma sayılarını depolar. Daha fazla detaya ihtiyacınız varsa\n		yoğunlaştırılmış istatistikler özelliğini kapatabilirsiniz.\n		";

$GLOBALS['phpAds_hlp_log_adviews'] = "\n		Normal durumda tüm görüntülenmeler depolanır, ama görüntülenmeleri depolamak\n		istemiyorsanız bu özelliği kapatabilirsiniz.\n		";

$GLOBALS['phpAds_hlp_block_adviews'] = "\n		Eğer bir ziyaretçi sayfayı yenilerse ".MAX_PRODUCT_NAME." her görüntülemeyi depolar.\n		Bu özellik belirlediğiniz süre içerisinde görüntülenmelerden sadece birini depolar.\n		Örneğin: bu özelliği 300 saniye yaparsanız, ".MAX_PRODUCT_NAME." son 5 dakika içerisinde\n		aynı ziyaretçiye sadece tekrar gösterilmeyen bannerların istatistiklerini depolar. Bu\n		özellik sadece <i>Görüntülenmeleri loglamak için yol göstericileri kullan</i> seçeneği\n		açılmış ise ve tarayıcı cookieleri kabul ediyorsa kullanılır.\n		";

$GLOBALS['phpAds_hlp_log_adclicks'] = "\n		Normal durumda tüm tıklanmalar depolanır, ama tıklanmalrı depolamak\n		istemiyorsanız bu özelliği kapatabilirsiniz.\n		";

$GLOBALS['phpAds_hlp_block_adclicks'] = "\n		Eğer bir ziyaretçi bir bannera birden fazla tıklarsa ".MAX_PRODUCT_NAME." programı her\n		tıklamayı kaydeder. Bu özellik belirlediğiniz süre içerisinde sadece bir tıklamayı depolar.\n		Örneğin: bu özelliği 300 saniye yaparsanız, ".MAX_PRODUCT_NAME." son 5 dakika içerisinde\n		aynı ziyaretçinin sadece tekrar tıklamadığı bannerların istatistiklerini depolar. Bu\n		özellik sadece tarayıcı cookieleri kabul ediyorsa kullanılabilır.\n		";

$GLOBALS['phpAds_hlp_reverse_lookup'] = "\n		".MAX_PRODUCT_NAME." programı öntanımlı olarak her ziyaretçinin IP adresini depolar.\n		Eğer ".MAX_PRODUCT_NAME." programının domain isimlerini depolamasını istiyorsanız\n		bu özelliği açabilirsiniz. Geri besleme biraz zaman alabilir ve tüm işlemler biraz\n		yavaşlar.\n		";

$GLOBALS['phpAds_hlp_proxy_lookup'] = "\n		Bazı kullanıcılar internete erişebilmek için proxy sunucular kullanır. Bu durumda\n		".MAX_PRODUCT_NAME." programı kullanıcının değilde proxy sunucunun Ip adresini\n		veya sunucu adını alır. Eğer bu özelliği açarsanız ".MAX_PRODUCT_NAME." programı\n		proxy sunucu arkasındaki kullanıcının IP adresini veya sunucu adını bulmaya çalışır.\n		Eğer proxy sunucu kullanılıyorsa kullanıcının kesin adresini bulmak mümkün olmayabilir.\n		Bu özellik öntanımlı olarak kapalıdır, çünkü depolama hızını düşürür.\n		";

$GLOBALS['phpAds_hlp_ignore_hosts'] = "\n		Eğer bazı bilgisayarların tıklama ve görüntüleme sayılarını depolamak\n		istemiyorsanız bu bilgisayarları bu listeye  ekleyebilirsiniz. Geri beslemeyi\n		açarsanız hem domain adını hem de IP adresini ekleyebilirsiniz, aksi\n		takdirde sadece IP adresini yazınız. Tanımlamaları kullanbilirsiniz (Örn:\n		'*.altavista.com' veya '192.168.*').\n		";

$GLOBALS['phpAds_hlp_begin_of_week'] = "\n		Çoğu insan için hafta Pazartesi başlar. Fakat isterseniz Pazar günü başlatabilirsiniz.\n		";

$GLOBALS['phpAds_hlp_percentage_decimals'] = "\n		İstatistik sayfalarında kaç tane ondalık alanı olacağını belirtiniz.\n		";

$GLOBALS['phpAds_hlp_warn_admin'] = "\n		".MAX_PRODUCT_NAME." programı kampanyanın belirli bir tıklama veya görüntülenme\n		sayısı kaldığında size e-mail atabilir. Bu özellik öntanılı açıktır.\n		";

$GLOBALS['phpAds_hlp_warn_client'] = "\n		".MAX_PRODUCT_NAME." programı bir kampanyanın belirli bir tıklama ve görütülenme\n		sayısı kaldığında reklamcıya e-mail atabilir. Bu özellik öntanımlı açıktır.\n		";

$GLOBALS['phpAds_hlp_qmail_patch'] = "\n		Bazı qmail sürümleri ".MAX_PRODUCT_NAME." programı tarafından gönderilen maillerin\n		içerisine mailin başlık kısmını gömmektedir. Bu ayarı açarsanız ".MAX_PRODUCT_NAME."\n		programı mailleri qmail uyumlu biçimde gönderecektir.\n		";

$GLOBALS['phpAds_hlp_warn_limit'] = "\n		".MAX_PRODUCT_NAME." programının uyarı e-mailleri gönderme sınırlaması. Bu öntanımlı\n		100dür.\n		";

$GLOBALS['phpAds_hlp_allow_invocation_plain'] =
$GLOBALS['phpAds_hlp_allow_invocation_js'] =
$GLOBALS['phpAds_hlp_allow_invocation_frame'] =
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] =
$GLOBALS['phpAds_hlp_allow_invocation_local'] =
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] =
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "\n		Bu ayarlar invocation tiplerine izin verdiğinizi belirtir. Bu biçimlerden\n		birisi kapalı ise invocationcode ve bannercode içerisinde kullanılabilir olmayacaktır.\n		ÖNEMLİ: Seçilmeseler bile invocation metodları çalışacaktır. Sadece kod\n		üretiminde kullanılmayacaktır.\n		";

$GLOBALS['phpAds_hlp_con_key'] = "\n		".MAX_PRODUCT_NAME." programı güçlü bir düzeltme modülüne sahiptir.\n		Daha fazla bilgi için kullanıcı klavuzunu okuyunuz. Bu özellikler, durum\n		anahtar kelimelerini kullanabilirsiniz. Öntanımlı açıktır.\n		";

$GLOBALS['phpAds_hlp_mult_key'] = "\n		Eğer banner göstermek için direk seçim yöntemini kullanıyorsanız, bir yada\n		birden fazla anahtar kelime seçebilirsiniz. Birden fazla anahtar kelime seçerseniz\n		bu özellik açılmalıdır. Öntanımlı olarak açıktır.\n		";

$GLOBALS['phpAds_hlp_acl'] = "\n		Teslimat sınırlamaları kullanmıyorsanız bu özelliği bu parametreyi kullanıp kapatabilirsiniz.\n		Bu ".MAX_PRODUCT_NAME." sistemini hızlandıracaktır.\n		";

$GLOBALS['phpAds_hlp_default_banner_url'] =
$GLOBALS['phpAds_hlp_default_banner_target'] = "\n		".MAX_PRODUCT_NAME." programı veritabanına bağlanmazsa veya eşleşen bir banner bulamazsa\n		mesela veritabanının bozulması veya silinmesi durumunda, boş sayfa basacaktır.\n		Bazı kullanıcılar bu durumda öntanımlı bir banner gösterilmesini isteyecektir.\n		Bu bannerla ilgili hiçbir istatistik tutulmamaktadır. Bu özellik öntanımlı kapalıdır.\n		";

$GLOBALS['phpAds_hlp_zone_cache'] = "\n        Eğer alanları kullanıyorsanız ".MAX_PRODUCT_NAME." programı banner bilgilerini daha\n		sonra kullanılması için hafızada tutabilir. Bu ".MAX_PRODUCT_NAME." programının hızlı\n		çalışmasını sağlar. Program çalışırken Alan bilgisini almak için ve bannerın bilgisini\n		almak için ve doğru banneı seçmek için ".MAX_PRODUCT_NAME." programı sadece hafıza\n		yükler. Bu özellik öntanımlı açıktır.\n		";

$GLOBALS['phpAds_hlp_zone_cache_limit'] = "\n        Hafızalanmış alanlar kullanıyorsanız, hafıza içerisindeki bilgiler güncellenebilir.\n		".MAX_PRODUCT_NAME." programı hafızayı yeniden oluşturduğu zaman, alana eklenen\n		yeni bannerlarda hafıza alınır. Bu ayar size hafızanın ne kadar sürede tazeleneceğini\n		ve en fazla yaşama süresini belirtir. Örneğin: Bu ayarı 600 olarak ayarlarsanız,\n		hafıza her 10 dakikada bir yenilenir.\n		";

$GLOBALS['phpAds_hlp_type_sql_allow'] =
$GLOBALS['phpAds_hlp_type_web_allow'] =
$GLOBALS['phpAds_hlp_type_url_allow'] =
$GLOBALS['phpAds_hlp_type_html_allow'] =
$GLOBALS['phpAds_hlp_type_txt_allow'] = "\n        ".MAX_PRODUCT_NAME." programı farklı tiplerde bannerları destekler ve bunları\n		farklı yollarla kaydeder. İlk iki seçim yerel depolama için kullanılır. Yönetici\n		arabiriminden banner yükleyebilirsiniz ve ".MAX_PRODUCT_NAME." programı bunları\n		SQL veritabanına veya web sunucuya kaydeder. Harici web sunucudaki bannerları da\n		kullanabilirsiniz veya HTML kullanabilirsiniz veya basit bir yazı ile de banner\n		oluşturabilirsiniz.\n		";

$GLOBALS['phpAds_hlp_type_web_mode'] = "\n        Eğer bannerların web sunucuda saklanmasını seçerseniz, bu ayarları yapmak\n		zorundasınız. Bannerları yerel klasörde saklamak istiyorsanız bu ayarları\n		<i>Yerel Klasör</i> olarak ayarlayınız. Eğer bannerlarınızı harici web sunucu\n		üzerinde saklamak istiyorsanız bu ayarları <i>Harici FTP Sunucu</i> olarak\n		ayarlayınız. Yerel sunucu haricindeki sunucularda FTP ayarlarını kullanmanız\n		gerekmektedir.\n		";

$GLOBALS['phpAds_hlp_type_web_dir'] = "\n		".MAX_PRODUCT_NAME." programının gönderilen bannerları nereye kopyalayacağını\n		(hangi klasöre) belirtiniz. Bu klasör PHP tarafından yazılabilir olmalıdır. Bu\n		klasörün UNIX izinlerinin ayarlanmasını gerektirir(chmod). Burada belirttiğiniz\n		klasör web sunucu üzerinde web paylaşımı olan (web sunucu web hizmeti verebilmelidir)\n		yerde olmalıdır. Son (/)ı yazmayınız. Depolamak için <i>Yerel Klasör</i> metodunu\n		seçtiyseniz bu ayarları yapmalısınız.\n		";

$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "\n		Depolama metodunu <i>Harici FTP sunucusu</i> olarak belirlediyseniz, ".MAX_PRODUCT_NAME."\n		programının bannerları göndereceği harici FTP sunucunun IP Adresi veya domain adını\n		belirtmelisiniz.\n		";

$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "\n		Depolama metodunu <i>Harici FTP sunucusu</i> olarak belirlediyseniz, ".MAX_PRODUCT_NAME."\n		programının harici FTP sunucuda bannerları göndereceği klasör ismini belirtmelisiniz.\n		";

$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "\n		Depolama metodunu <i>Harici FTP sunucusu</i> olarak belirlediyseniz, ".MAX_PRODUCT_NAME."\n		programının harici FTP sunucuya ulaşması için kullanacağı kullanıcı adını belirtmelisiniz.\n		";

$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "\n		Depolama metodunu <i>Harici FTP sunucusu</i> olarak belirlediyseniz, ".MAX_PRODUCT_NAME."\n		programının harici FTP sunucuya ulaşması için kullanacağı parolayı belirtmelisiniz.\n		";

$GLOBALS['phpAds_hlp_type_web_url'] = "\n		Eğer bannerlarınızı web sunucusu üzerinde tutuyorsanız, ".MAX_PRODUCT_NAME." programı\n		bannerları sakladığınız klasörün umumi konumunu bilmek zorundadır. (En son / ı koymayınız.)\n		";

$GLOBALS['phpAds_hlp_type_html_auto'] = "\n		Eğer bu özellik açık ise ".MAX_PRODUCT_NAME." programı HTML banner kodu içerisine otomatik olarak tıklanma\n		izleme kodunu gönderir. Ama bu özellik açık olduğu zaman bannerdaki bu özellik açık ise\n		banner özlelliğini yok sayar.\n		";

$GLOBALS['phpAds_hlp_type_html_php'] = MAX_PRODUCT_NAME."
		programının HTML bannerları içerisndeki PHP kodlarını çalıştırmasına izin ver.
		Bu özellik öntanımlı olarak kapalıdır.
		";

$GLOBALS['phpAds_hlp_admin'] = "\n		Site yöneticisi kullanıcı adı, yönetici arabirimindeki loglarda kullanılacak\n		kullanıcı adını belirtebilirsiniz.\n		";

$GLOBALS['phpAds_hlp_pwold'] =
$GLOBALS['phpAds_hlp_pw'] =
$GLOBALS['phpAds_hlp_pw2'] = "\n		Yönetici parolasını değiştirmek için, eski parolayı girmeniz gerekiyor.\n		Yeni parolayı da yazım hatalarına karşı güvenli olsun diye iki defa\n		girmeniz gerekmektedir.\n		";

$GLOBALS['phpAds_hlp_admin_fullname'] = "\n		Site Yöneticisinin tam ismini belirtiniz. Bu istatistik mailleri gönderilirken\n		kullanılacaktır.\n		";

$GLOBALS['phpAds_hlp_admin_email'] = "\n		Site yöneticisinin e-mail adresini belirtiniz. Bu e-mail hesabı gönderilen\n		istatistik maillerinin kimden kısmına yazılacaktır.\n		";

$GLOBALS['phpAds_hlp_admin_email_headers'] = MAX_PRODUCT_NAME."
		programı tarafından gönderilen e-maillere e-mail başlıkları ekleyebilirsiniz.
		";

$GLOBALS['phpAds_hlp_admin_novice'] = "\n		Herhangi reklamcı, kampanya, banner, yayıncı ve/veya alan silerken uyarı verilmesini\n		istiyorsanız bu özelliği açınız.\n		";

$GLOBALS['phpAds_hlp_client_welcome'] = "\n		Eğer bu özelliği aktif ederseniz, reklamcı giriş yaptıktan sonra ilk sayfada hoşgeldiniz\n		mesajı görüntülenecektir. Bu mesajı welcome.html dosyasını (admin/templates klasöründe)\n		düzenleyerek kişiselleştirebilirsiniz. Eklemek isteyebileceğiniz veriler: Firma isminiz,\n		irtibat bilgileri, firma logonuz, reklam oranları ile ilgili sayfa linki....\n		";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "\n		Welcome.html dosyasını değiştirmenin yanında buradaki ufak alana da belirtebilirsiniz.\n		Eğer buraya bir yazı girerseniz, welcome.html dosyası yok sayılacaktır. html etiketleri\n		kulanılabilir.\n		";

$GLOBALS['phpAds_hlp_updates_frequency'] = MAX_PRODUCT_NAME."
		programının yeni sürümlerini kontrol etmek istiyorsanız bu seçeneği aktif edebilirsiniz.
		".MAX_PRODUCT_NAME." programının sunucu ile bağlanmasını sağlar. Eğer yeni bir sürüm
		bulunursa açılan kutu içerisinde bilgi verilecektir.
		";

$GLOBALS['phpAds_hlp_userlog_email'] = MAX_PRODUCT_NAME."
		programı tarafından gönderilen tüm mailleri depolamak istiyorsanız bu özelliği
		aktif etmelisiniz. Bu e-mail mesajları kullanıcı logları içerisinde depolanacaktır.
		";

$GLOBALS['phpAds_hlp_userlog_priority'] = "\n		Öncelik hesabının doğru olarak hesaplandığından emin olmak için, saatlik\n		hesaplamaları raporlayabilirsiniz. Bu rapor olasılık profilini ve tüm banneların\n		önceliklerini içerir. Bu bilgileri olasılık hesaplamaları ile ilgili bir problemi\n		bildirmek için kullanabilirsiniz. Bu bilgileri kullanıcı logları içerisinde depolar.\n		";

$GLOBALS['phpAds_hlp_default_banner_weight'] = "\n		Eğer yüksek öneme sahip öntanımlı banner kullanmak istiyorsanız önem ayarını buradan\n		yapabilirsiniz. Öntanımlı olarak bu değer 1dir.\n		";

$GLOBALS['phpAds_hlp_default_campaign_weight'] = "\n		Eğer yüksek öneme sahip öntanımlı kampanya kullanmak istiyorsanız önem ayarını buradan\n		yapabilirsiniz. Öntanımlı olarak bu değer 1dir.\n		";

$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "\n		Eğer bu seçenek seçili ise kampanyalar hakkında ekstra bilgiler <i>Kampanya Önizleme</i>\n		sayfasında gösterilir. Ekstra bilgi kalan görüntülenme sayısını, kalan tıklama sayısını,\n		aktivasyon tarihini, bitiş tarihini ve öncelik ayarlarını içerir.\n		";

$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "\n		Eğer bu seçenek seçilmiş ise banner hakkındaki ekstra bilgiler <i>Banner Özellikleri</i>\n		sayfasında gösterilir. Ekstra bilgi hedef URL, anahtar kelimeler, boyut ve banner önemini\n		içerir.\n		";

$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "\n		Eğer bu seçenek seçili ise <i>Banner Önizleme</i> sayfasında tüm bannerların önizlemesi\n		görüntülenir. Eğer bu seçenek seçili değil ise <i>Banner Önizleme</i> sayfasında bannerların\n		yanındaki üçgenlere basarak bannerlar görüntülenebilir.\n		";

$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "\n		Eğer bu seçenek seçilmiş ise HTML Bannerları HTMLsiz olarak gösterilir. Bu özellik öntanımlı\n		olarak seçilmemiştir, çünkü HTML Bannerı kullanıcı arayüzü ile çakışabilir. Bu seçenek seçili\n		değilken bile HTML banner, <i>Banner Göster</i> butonuna tıklanarak görüntülenebilir.\n		";

$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "\n		Eğer bu seçenek seçilmiş ise önizleme <i>Banner Özellikleri</i>, <i>Teslimat Ayarları</i> ve\n		<i>İlişkilendirilmiş Alanlar</i> sayfalarının en üstünde görüntülenecektir. Bu seçenek seçilmemeiş\n		ise bannerları görüntülemek için sayfaların en üstünde bulunan <i>Banner Göster</i> butonuna\n		basabilirsiniz.\n		";

$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "\n		Eğer bu seçenek seçilmiş ise tüm pasif bannerlar, kampanyalar ve reklamcılar <i>Reklamcılar &\n		Kampanyalar</i> ve <i>Kampanya Önizleme</i> sayfalarında gizlenecektir. Eğer bu seçenek seçilmiş\n		ise tüm gizlenmiş öğeler sayfanın altında bulunan <i>Hepsini Göster</i> butonu ile görüntülenebilir.\n		";

?>