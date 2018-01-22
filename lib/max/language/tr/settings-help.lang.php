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
$GLOBALS['phpAds_hlp_dbhost'] = "Bağlanmaya çalıştığınız {$phpAds_dbmsname} veritabanı sunucusunun ana makine adını belirtin.";

$GLOBALS['phpAds_hlp_dbport'] = "Bağlanmaya çalıştığınız {$phpAds_dbmsname} veritabanı sunucusunun bağlantı noktasının sayısını belirtin.";

$GLOBALS['phpAds_hlp_dbuser'] = "{$phpAds_dbmsname} veritabanı sunucusuna erişmek için {$PRODUCT_NAME} tarafından kullanılması gereken kullanıcı adını belirtin.";

$GLOBALS['phpAds_hlp_dbpassword'] = "{$phpAds_dbmsname} veritabanı sunucusuna erişmek için {$PRODUCT_NAME} ürününün kullanması gereken şifreyi belirtin.";

$GLOBALS['phpAds_hlp_dbname'] = "{$PRODUCT_NAME} ürününün veri depolaması gereken veritabanı sunucusunda veritabanının adını belirtin.
Önemli Veritabanı, veritabanı sunucusunda önceden oluşturulmuş olmalıdır. {$PRODUCT_NAME}, bu veritabanı <b> henüz </b> oluşturulmadıysa oluşturulur.";

$GLOBALS['phpAds_hlp_persistent_connections'] = "Sürekli bağlantı kullanılması {$PRODUCT_NAME} ürününü önemli ölçüde hızlandırabilir ve sunucu üzerindeki yükü düşürebilir. Bununla birlikte, bir çok dezavantajı vardır, ziyaretçiler çok fazla olan sitelerde normal bağlantıları kullanırken sunucudaki yük artabilir ve daha da büyür. Normal bağlantılar kullanmanız gerekip gerekmediğine bağlı olarak, ziyaretçilerin sayısına ve kullandığınız donanıma bağlıdır. {$PRODUCT_NAME} çok fazla kaynak kullanıyorsa, önce bu ayara göz atmanız gerekir.";

$GLOBALS['phpAds_hlp_compatibility_mode'] = "{$PRODUCT_NAME} ürününü başka bir üçüncü parti ürünle entegrasyonda sorun yaşıyorsanız, veritabanı uyumluluğu modunu açmanıza yardımcı olabilir. Yerel mod çağrısı kullanıyorsanız ve veritabanı uyumluluğu açıksa, {$PRODUCT_NAME}, veritabanı bağlantısının durumunu exterior olarak {$PRODUCT_NAME} 'nın çalıştığı zamanki gibi bırakmalıdır.
Bu seçenek biraz daha yavaştır (yalnızca biraz) ve bu nedenle varsayılan olarak kapalıdır.";

$GLOBALS['phpAds_hlp_table_prefix'] = "{$PRODUCT_NAME} adlı veritabanı birden fazla yazılım ürünü tarafından paylaşılıyorsa, tabloların adlarına ön ek eklemek akıllıca olur. Aynı veritabanında {$PRODUCT_NAME} ürününün birden fazla yüklemesini kullanıyorsanız, bu öneki tüm kurulumlar için benzersiz olduğundan emin olmanız gerekir.";

$GLOBALS['phpAds_hlp_table_type'] = "MySQL, birden çok tablo türünü desteklemektedir. Her tablo türü benzersiz özelliklere sahiptir ve bazıları {$PRODUCT_NAME} ürününü önemli ölçüde hızlandırabilir. MyISAM, varsayılan tablo türüdür ve MySQL'in tüm yüklemelerinde kullanılabilir. Diğer tablo türleri sunucunuzda bulunmayabilir.";

$GLOBALS['phpAds_hlp_url_prefix'] = "{$PRODUCT_NAME} ürününün doğru çalışması için web sunucusunda nerede olduğunu bilmemiz gerekir. {$PRODUCT_NAME} kurulumunun bulunduğu dizinin URL'sini belirtmelisiniz, örneğin: <i>http://www.your-url.com/ads</i>.";

$GLOBALS['phpAds_hlp_ssl_url_prefix'] = "{$PRODUCT_NAME} ürününün doğru çalışması için web sunucusunda nerede olduğunu bilmemiz gerekir. Bazen SSL önek normal URL önekten farklıdır.
{$PRODUCT_NAME} ürününün yüklü olduğu dizinin URL'sini belirtmelisiniz, örneğin: <i>https://www.your-url.com/ads</i>.";

$GLOBALS['phpAds_hlp_my_header'] = $GLOBALS['phpAds_hlp_my_footer'] = "Yönetici arayüzündeki her sayfada üstbilgi ve / veya altbilgi olması için üstbilgi dosyalarının yolunu buraya yerleştirmelisiniz (ör. /home/login/www/header.htm). Bu dosyalara metin veya html koyabilirsiniz (bu dosyalardan birinde veya her ikisinde html kullanmak istiyorsanız <body> veya <html> gibi etiketleri kullanmayın).";

$GLOBALS['phpAds_hlp_my_logo'] = "Burada, varsayılan logo yerine, görüntülemek istediğiniz özel logo dosyasının adını girmelisiniz. Logo burada dosya adını ayarlamadan önce admin / images dizinine yerleştirilmelidir.";

$GLOBALS['phpAds_hlp_gui_header_foreground_color'] = "Buraya, sekmeler, arama çubuğu ve kalın metin için kullanılacak özel bir renk koymalısınız.";

$GLOBALS['phpAds_hlp_gui_header_background_color'] = "Burada, üstbilgi arka planı için kullanılacak özel bir renk koymalısınız.";

$GLOBALS['phpAds_hlp_gui_header_active_tab_color'] = "Burada seçili olan ana sekme için kullanılacak özel bir renk koymalısınız.";

$GLOBALS['phpAds_hlp_gui_header_text_color'] = "Burada, üstbilgideki metin için kullanılacak özel bir renk koymalısınız.";

$GLOBALS['phpAds_hlp_content_gzip_compression'] = "GZIP içerik sıkıştırmasını etkinleştirerek, yönetici arayüzünün her sayfası açıldığında tarayıcıya gönderilen verilerin büyük bir kısmının azalmasını sağlayabilirsiniz.
Bu özelliği etkinleştirmek için GZIP uzantısının yüklü olması gerekir.";

$GLOBALS['phpAds_hlp_language'] = "{$PRODUCT_NAME} kullanması gereken varsayılan dili belirtin. Bu dil, yönetici ve reklamveren arayüzü için varsayılan olarak kullanılacaktır. Lütfen unutmayın: Yönetici arayüzünden her reklamveren için farklı bir dil ayarlayabilir ve reklamverenlerin kendi dillerini değiştirmesine izin verebilirsiniz.";

$GLOBALS['phpAds_hlp_name'] = "Bu uygulama için kullanmak istediğiniz adı belirtin. Bu dizge, yönetici ve reklamveren arayüzündeki tüm sayfalarda görüntülenecektir. Bu ayarı boş (varsayılan) bırakırsanız onun yerine {$PRODUCT_NAME} bir logo görüntülenir.";

$GLOBALS['phpAds_hlp_company_name'] = "Bu ad, {$PRODUCT_NAME} tarafından gönderilen e-postada kullanılır.";

$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "{$PRODUCT_NAME} genellikle GD kitaplığının yüklü olup olmadığını ve hangi resim biçiminin GD'nin yüklü sürümüyle desteklendiğini algılar. Bununla birlikte, algılamanın doğru veya yanlış yapılmaması mümkündür, PHP'nin bazı sürümleri desteklenen resim biçimlerinin saptanmasına izin vermemektedir. {$PRODUCT_NAME} doğru resim biçimini otomatik algılayamazsa doğru resim biçimini belirleyebilirsiniz. Olası değerler şunlardır: none, png, jpeg, gif.";

$GLOBALS['phpAds_hlp_p3p_policies'] = "{$PRODUCT_NAME} 'P3P Gizlilik Politikası'nı etkinleştirmek istiyorsanız bu seçeneği etkinleştirmeniz gerekir.";

$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "Çerezlerle birlikte gönderilen kompakt politika. Varsayılan ayar: Internet Explorer 6'nın {$PRODUCT_NAME} tarafından kullanılan çerezleri kabul etmesini sağlayan 'CUM ADM OUR NOR STA NID' dır. İsterseniz, kendi gizlilik bildiriminizle eşleşecek şekilde bu ayarları değiştirebilirsiniz.";

$GLOBALS['phpAds_hlp_p3p_policy_location'] = "Tam bir gizlilik politikası kullanmak istiyorsanız, ilkenin bulunduğu yeri belirtebilirsiniz.";

$GLOBALS['phpAds_hlp_compact_stats'] = "Geleneksel olarak {$PRODUCT_NAME} oldukça ayrıntılı bir günlüğe kaydetme işlemi gerçekleştirdi; bu çok detaylıydı, ancak veritabanı sunucusunda da çok talepkardı. Bu, çok sayıda ziyaretçinin bulunduğu sitelerde büyük bir problem olabilir. Bu sorunun üstesinden gelmek için {$PRODUCT_NAME}, yeni bir istatistik türünü desteklemektedir; kompakt istatistikler, veritabanı sunucusunda daha az talep gerektirir, ancak aynı zamanda daha az detaylıdır.
Kompakt istatistikler, her saat için ilan izlemesi, ilan tıklaması ve ilan dönüşümleri toplar; daha fazla ayrıntıya ihtiyacınız varsa, sıkıştırılmış istatistikleri kapatabilirsiniz.";

$GLOBALS['phpAds_hlp_log_adviews'] = "Normalde tüm ilan izlemeleri günlüğe kaydedilir; İlan izlemesi ile ilgili istatistikleri toplamak istemiyorsanız, bu özelliği kapatabilirsiniz.";

$GLOBALS['phpAds_hlp_block_adviews'] = "Bir ziyaretçi bir sayfayı yeniden yüklerse, her daim {$PRODUCT_NAME} tarafından bir ilan izlemesi kaydedilir.
Bu özellik, belirlediğiniz saniye sayısı için her benzersiz afiş için yalnızca bir ilan izlemesinin kaydedildiğinden emin olmak için kullanılır. Örneğin: Bu değeri 300 saniyeye ayarlarsanız, {$PRODUCT_NAME} yalnızca aynı afişi son 5 dakika içinde aynı ziyaretçiye göstermediyse ilan izlemesi günlüğüne kaydeder. Bu özellik yalnızca çerezleri kabul eden tarayıcılarda çalışır.";


$GLOBALS['phpAds_hlp_block_adclicks'] = "Bir ziyaretçi bir afişe birden çok kez tıklarsa, her defasında {$PRODUCT_NAME} tarafından bir ilan tıklaması kaydedilecektir. Bu özellik, belirlediğiniz saniye sayısı için benzersiz her afiş için yalnızca bir ilan tıklaması kaydedildiğinden emin olmak için kullanılır. Örneğin: Bu değeri 300 saniyeye ayarlarsanız, {$PRODUCT_NAME}, ziyaretçinin son 5 dakikada aynı afişi tıklaması durumunda ilan tıklaması günlüğüne kaydeder. Bu özellik yalnızca tarayıcı çerezleri kabul ettiğinde çalışır.";


$GLOBALS['phpAds_hlp_block_adconversions'] = "Bir ziyaretçi bir ilan dönüştürme işaretçisine sahip bir sayfayı yeniden yüklerse {$PRODUCT_NAME} ilan dönüştürmeyi her seferinde günlüğe kaydeder. Bu özellik, belirttiğiniz saniye sayısı için yalnızca bir ilan dönüştürmeyi kaydettiğinden emin olmak için kullanılır. Örneğin: Bu değeri 300 saniyeye ayarlarsanız, {$PRODUCT_NAME}, ziyaretçinin ilan dönüştürme işaretçisiyle aynı sayfayı son 5 dakikada yüklememesi durumunda, yalnızca ilan dönüştürmeyi günlüğe kaydeder. Bu özellik yalnızca tarayıcı çerezleri kabul ettiğinde çalışır.";

$GLOBALS['phpAds_hlp_geotracking_stats'] = "Bir coğrafi hedefleme veritabanı kullanıyorsanız coğrafi bilgileri veritabanında da saklayabilirsiniz. Bu seçeneği etkinleştirdiyseniz, ziyaretçilerinizin konumu ve farklı ülkelerin her afişin performansı hakkında istatistikleri görebilirsiniz.
Bu seçenek yalnızca ayrıntılı istatistikler kullanıyorsanız kullanılabilir.";

$GLOBALS['phpAds_hlp_reverse_lookup'] = "Ana makine adı genellikle web sunucusu tarafından belirlenir, ancak bazı durumlarda bu kapatılabilir. Ziyaretçi kurallarının içinde ziyaretçi ana makine adını kullanmak ve / veya bununla ilgili istatistikleri tutmak ve aynı zamanda sunucu bu bilgiyi sağlamıyorsa, bu seçeneği etkinleştirebilirsiniz. Ziyaretçinin ana makine adının belirlenmesi biraz zaman alabilir; Afiş teslimatını yavaşlatacaktır.";

$GLOBALS['phpAds_hlp_proxy_lookup'] = "Bazı ziyaretçiler internete erişmek için bir proxy sunucusu kullanıyor. Bu durumda {$PRODUCT_NAME} kullanıcı yerine proxy sunucusunun IP adresini veya ana bilgisayar adını günlüğe kaydeder. Bu özelliği etkinleştirirseniz {$PRODUCT_NAME}, ziyaretçinin bilgisayarının proxy sunucusunun arkasındaki IP adresini veya ana makine adını bulmaya çalışacaktır. Ziyaretçinin tam adresini bulmak mümkün değilse bunun yerine proxy sunucusunun adresini kullanacaktır. Bu seçenek varsayılan olarak etkinleştirilmemiştir, çünkü afişlerin teslimatını önemli derecede yavaşlatacaktır.";

$GLOBALS['phpAds_hlp_obfuscate'] = "Burada hiçbir şey yok....";

$GLOBALS['phpAds_hlp_auto_clean_tables'] = $GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "Bu özelliği etkinleştirirseniz, bu onay kutusunun altındaki belirlediğiniz süre geçtikten sonra toplanan istatistikler otomatik olarak silinir. Örneğin, bunu 5 haftaya ayarlarsanız, 5 haftadan daha eski istatistikler otomatik olarak silinir.";

$GLOBALS['phpAds_hlp_auto_clean_userlog'] = $GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "Bu özellik, bu onay kutusunun altındaki belirtilen hafta sayısından daha eski girdileri otomatik olarak kullanıcı günlüğünden silecektir.";


$GLOBALS['phpAds_hlp_geotracking_location'] = "Coğrafi Apache modülüne sahip olmadığınız sürece {$PRODUCT_NAME}'e coğrafi hedefleme veritabanının konumunu bildirmeniz gerekir. Veritabanını web sunucuları belge kökü dışında kullanmak her zaman önerilir, aksi takdirde kullanıcılar veritabanını indirebilir.";

$GLOBALS['phpAds_hlp_geotracking_cookie'] = "IP adresini coğrafi bilgilerde dönüştürmek zaman almaktadır. {$PRODUCT_NAME} tarafından bir afiş gönderildiğinde bunu yapmak zorunda kalmamak için sonuç bir çerezde saklanabilir. Bu çerez varsa {$PRODUCT_NAME} IP adresini dönüştürmek yerine bu bilgiyi kullanacaktır.";

$GLOBALS['phpAds_hlp_ignore_hosts'] = "Bazı bilgisayarlardan görüntülemeleri, tıklamaları ve dönüşümleri saymak istemiyorsanız bunları bu listeye ekleyebilirsiniz. Geriye doğru aramayı etkinleştirdiyseniz hem alan adlarını hem de IP adreslerini ekleyebilirsiniz, aksi takdirde sadece IP adreslerini kullanabilirsiniz. Joker karakterleri de kullanabilirsiniz (ör. '*.altavista.com' veya '192.168. *').";

$GLOBALS['phpAds_hlp_begin_of_week'] = "Çoğu insan için hafta Pazartesi günü ile başlar, ancak Pazar günü ile başlamak isterseniz yapabilirsiniz.";

$GLOBALS['phpAds_hlp_percentage_decimals'] = "İstatistik sayfalarında kaç tane ondalık basamak gösterileceğini belirtir.";

$GLOBALS['phpAds_hlp_warn_admin'] = "{$PRODUCT_NAME}, bir kampanyada yalnızca sınırlı sayıda görüntüleme, tıklama veya dönüşüm kaldığında size e-posta gönderebilir. Bu varsayılan olarak açıktır.";

$GLOBALS['phpAds_hlp_warn_client'] = "{$PRODUCT_NAME}, kampanyalarından birinde yalnızca sınırlı sayıda görüntüleme, tıklama veya dönüşüm kaldığında reklamverenin e-postasını gönderdi. Bu varsayılan olarak açıktır.";

$GLOBALS['phpAds_hlp_qmail_patch'] = "Qmail'in bazı sürümleri, {$PRODUCT_NAME} tarafından e-postanın gövdesinde başlıkları göstermek için gönderilen bir hatadan etkilenir. Bu ayarı etkinleştirirseniz {$PRODUCT_NAME}, e-postayı qmail uyumlu bir biçimde gönderir.";

$GLOBALS['phpAds_hlp_warn_limit'] = "{$PRODUCT_NAME} ürününün uyarı e-postaları göndermeye başlama limiti. Varsayılan olarak bu 100'dür.";


$GLOBALS['phpAds_hlp_default_banner_url'] = $GLOBALS['phpAds_hlp_default_banner_target'] = "{$PRODUCT_NAME} veritabanı sunucusuna bağlanamazsa veya eşleşen herhangi bir afiş bulamazsa, veritabanı çöktüğünde veya silindiğinde herhangi bir şey görüntülenmez. Bazı kullanıcılar, bu durumlarda gösterilecek varsayılan bir afiş belirlemek isteyebilir. Burada belirtilen varsayılan afiş kaydedilmeyecek ve veritabanında hala etkin afişler kalmışsa kullanılamayacaktır. Bu varsayılan olarak kapalıdır.";

$GLOBALS['phpAds_hlp_delivery_caching'] = "İletimin hızlandırılmasına yardımcı olmak için {$PRODUCT_NAME}, web sitenizin ziyaretçisine afiş göndermek için gereken tüm bilgileri içeren bir önbellek kullanır. Teslimat önbelleği varsayılan olarak veritabanında saklanır, ancak hızı daha da artırmak için önbellek dosyanın içinde veya paylaşılan bellekte saklamak da mümkündür. Paylaşılan bellek en hızlı yöntemdir, Dosyalar da çok hızlıdır. Teslimat önbelleğini kapatmanız önerilmez çünkü bu performansı ciddi şekilde etkiler.";

$GLOBALS['phpAds_hlp_type_web_mode'] = "Web sunucusunda saklanan afişleri kullanmak istiyorsanız, bu ayarı yapılandırmanız gerekir. Afişleri yerel bir dizinde saklamak isterseniz, bu seçeneği <i> Yerel dizin </i> olarak ayarlayın. Banner'ı harici bir FTP sunucusunda saklamak isterseniz, bu seçeneği <i> Harici FTP sunucusu </i> olarak ayarlayın. Bazı web sunucularında, FTP seçeneklerini yerel web sunucusunda bile kullanmak isteyebilirsiniz.";

$GLOBALS['phpAds_hlp_type_web_dir'] = "{$PRODUCT_NAME} ürününün, yüklenen afişleri kopyalaması gereken dizini belirtin. Bu dizinin PHP tarafından yazılabilir olması gerekir; bu, bu dizin için UNIX izinlerini değiştirmeniz gerektiği anlamına gelebilir (chmod). Burada belirttiğiniz dizinin web sunucusunun belge kökünde olması gerekir, web sunucusu dosyalara doğrudan hizmet edebilmelidir. Arka bir eğik çizgi (/) belirtmeyin. Depolama yöntemini <i> Yerel dizin </i> olarak ayarladıysanız, yalnızca bu seçeneği yapılandırmanız yeterlidir.";

$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "Depolama yöntemini <i> Harici FTP sunucusu </i> olarak ayarlarsanız, {$PRODUCT_NAME}'e ürününün yüklenen afişleri kopyalaması gereken FTP sunucusunun IP adresini veya alan adını belirtmeniz gerekir.";





$GLOBALS['phpAds_hlp_type_web_url'] = "Bir web sunucusuna afişler depolarsanız, {$PRODUCT_NAME} aşağıdaki genel URL'yi aşağıda belirttiğiniz dizine karşılık geldiğini bilmelidir. Arka bir eğik çizgi (/) belirtmeyin.";

$GLOBALS['phpAds_hlp_type_web_ssl_url'] = "Bir web sunucusunda afişler depolarsanız, {$PRODUCT_NAME} aşağıdaki genel URL'nin (SSL) aşağıda belirttiğiniz dizine karşılık geldiğini bilmelidir. Arka bir eğik çizgi (/) belirtmeyin.";

$GLOBALS['phpAds_hlp_type_html_auto'] = "Bu seçenek açıksa, {$PRODUCT_NAME} tıklamaların günlüğe kaydedilmesini sağlamak için HTML afişlerini otomatik olarak değiştirir. Ancak bu seçenek etkinleştirildiğinde bile, afiş bazında devre dışı bırakma özelliği yine de mümkün olacaktır.";

$GLOBALS['phpAds_hlp_type_html_php'] = "HTML afişlerine yerleştirilen PHP kodunu {$PRODUCT_NAME}'n çalıştırmasına izin vermek mümkündür. Bu özellik varsayılan olarak kapalıdır.";

$GLOBALS['phpAds_hlp_admin'] = "Lütfen yönetici kullanıcı adını giriniz. Bu kullanıcı adı ile yönetici arayüzüne giriş yapabilirsiniz.";

$GLOBALS['phpAds_hlp_admin_pw'] = $GLOBALS['phpAds_hlp_admin_pw2'] = "Lütfen yönetici arayüzüne giriş yapmak için kullanmak istediğiniz şifreyi girin.
Yazım hatalarını önlemek için iki kez girmeniz gerekir.";

$GLOBALS['phpAds_hlp_pwold'] = $GLOBALS['phpAds_hlp_pw'] = $GLOBALS['phpAds_hlp_pw2'] = "Yönetici şifresini değiştirmek için, yukarıdaki eski şifreyi belirtmeniz gerekebilir. Ayrıca, yazım hatalarını önlemek için yeni parolayı iki kez belirtmeniz gerekir.";

$GLOBALS['phpAds_hlp_admin_fullname'] = "Yöneticinin tam adını belirtin. Bu istatistikler e-posta ile gönderilirken kullanılır.";

$GLOBALS['phpAds_hlp_admin_email'] = "Yöneticinin e-posta adresi. Bu, e-posta yoluyla istatistik gönderirken gönderen adresi olarak kullanılır.";

$GLOBALS['phpAds_hlp_admin_novice'] = "Reklamverenleri, kampanyaları, afişleri, web sitelerini ve bölgeleri silmeden önce bir uyarı almak istiyorsanız; Bu seçeneği doğru olarak ayarlayın.";

$GLOBALS['phpAds_hlp_client_welcome'] = "Bu özelliği açarsanız hoş geldiniz mesajı, giriş yaptıktan sonra bir reklamverenin göreceği ilk sayfada görüntülenir. Admin / templates dizininde welcome.html dosya konumunu düzenleyerek bu mesajı kişiselleştirebilirsiniz. Eklemek isteyebileceğiniz şeyler şunlardır: Şirketinizin adı, iletişim bilgileri, şirket logonuz, özel bir sayfa ile reklamcılık oranları vb..";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "Welcome.html dosyasını düzenlemek yerine, burada küçük bir metin de belirleyebilirsiniz. Burada bir metin girerseniz, welcome.html dosyası yok sayılır. Html etiketlerini kullanmasına izin verilir.";

$GLOBALS['phpAds_hlp_updates_frequency'] = "{$PRODUCT_NAME} ürününün yeni sürümlerini kontrol etmek istiyorsanız bu özelliği etkinleştirebilirsiniz.
{$PRODUCT_NAME} ürününün güncelleme sunucusu ile bağlantı kurduğu süreyi belirtmek mümkündür. Yeni bir sürüm bulunursa, güncelleme ile ilgili ek bilgi içeren bir iletişim kutusu açılır.";

$GLOBALS['phpAds_hlp_userlog_email'] = "Giden tüm e-posta iletilerinin bir kopyasını {$PRODUCT_NAME} tarafından saklanmasını istiyorsanız bu özelliği etkinleştirebilirsiniz. E-posta mesajları kullanıcı günlüğünde saklanır.";

$GLOBALS['phpAds_hlp_userlog_inventory'] = "Envanter hesaplamasının doğru şekilde çalıştığından emin olmak için saatlik envanter hesaplamasına ilişkin bir raporu kaydedebilirsiniz. Bu rapor, öngörülen profili ve tüm bannerlara ne kadar öncelik atanmış olduğunu içerir. Bu bilgi, öncelik hesaplamaları hakkında bir hata raporu göndermek isterseniz yararlı olabilir. Raporlar, kullanıcı logusunun içinde saklanır.";

$GLOBALS['phpAds_hlp_userlog_autoclean'] = "Veritabanının doğru budandığinden emin olmak için, budama sırasında tam olarak ne olduğunu anlatan bir raporu kaydedebilirsiniz. Bu bilgiler kullanıcı günlüğünde saklanır.";

$GLOBALS['phpAds_hlp_default_banner_weight'] = "Daha yüksek bir varsayılan banner ağırlığı kullanmak isterseniz, burada istediğiniz ağırlığı belirtebilirsiniz.
Bu ayar varsayılan olarak 1'dir.";

$GLOBALS['phpAds_hlp_default_campaign_weight'] = "Daha yüksek bir varsayılan kampanya ağırlığı kullanmak istiyorsanız, burada istediğiniz ağırlığı belirtebilirsiniz.
Bu ayar varsayılan olarak 1'dir.";

$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "Bu seçenek etkinleştirilirse, her kampanyaya ilişkin ek bilgi <i> Kampanyalar </i> sayfasında gösterilir. Ekstra bilgi, kalan ilan görüntüleme sayısını, kalan ilan tıklama sayısını, kalan ilan dönüşümleri sayısını, etkinleştirme tarihini, son kullanma tarihini ve öncelik ayarlarını içerir.";

$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "Bu seçenek etkinleştirilirse, her afiş ile ilgili ek bilgi <i> Afişler </i> sayfasında gösterilir. Ekstra bilgi, hedef URL'yi, anahtar kelimeleri, boyutu ve afişin ağırlığını içerir.";

$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "Bu seçenek etkinleştirilirse, tüm afişlerin bir önizlemesi <i> Afişler </i> sayfasında gösterilir. Bu seçenek devre dışı bırakılırsa, her afişin önizlemesini tıklama ile gösterebilirsiniz
<i> Afişler </i> sayfasındaki her bir afişin yanındaki üçgene tıklayın.";

$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "Bu seçenek etkinleştirilirse, HTML kodu yerine gerçek HTML afişi gösterilir. Bu seçenek varsayılan olarak devre dışıdır, çünkü HTML afişleri kullanıcı arayüzü ile çakışabilir.
Bu seçenek devre dışı bırakılırsa, HTML kodunun yanındaki <i> Afişi göster </i> düğmesini tıklayarak asıl HTML afişlerini görüntülemek yine de mümkündür.";

$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "Bu seçenek etkinleştirilirse, <i> Afiş özellikleri </i>, <i> Teslimat seçeneği </i> ve <i> Bağlantılı bölgeler </i> sayfalarının üst kısmında bir önizleme gösterilir. Bu seçenek devre dışı bırakılırsa, sayfaların üst kısmındaki <i> Afiş göster </i> düğmesini tıklayarak afişi görüntülemek yine de mümkündür.";

$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "Bu seçenek etkinleştirilirse, etkin olmayan tüm afişler, kampanyalar ve reklamverenler <i> Reklamverenler ve Kampanyalar </i> ve <i> Kampanyalar </i> sayfalarından gizlenecektir. Bu seçenek etkinleştirilirse, sayfanın altındaki <i> Tümünü göster </i> düğmesini tıklayarak gizli öğeleri görmek yine de mümkündür.";

$GLOBALS['phpAds_hlp_gui_show_matching'] = "Bu seçenek etkinleştirilirse, eşleşen afiş, <i> Kampanya seçimi </i> yöntemi ile seçilirse, <i> Bağlantılı afişler</i> sayfasında gösterilir. Kampanyaya bağlıysa, tam olarak hangi afişlerin yayınlanması için kabul edildiğini görmenizi sağlar. Eşleşen afişlerin bir önizlemesine bakmakta mümkün.";

$GLOBALS['phpAds_hlp_gui_show_parents'] = "Bu seçenek etkinleştirilirse, afişlerin üst kampanyaları <i> Afiş seçimi </i> yöntemi ile seçilirse <i> Bağlantılı afişler </i> sayfasında gösterilir. Bu, afiş bağlanmadan önce hangi afişlerin hangi kampanyaya ait olduğunu görmenizi sağlayacaktır. Bu aynı zamanda, afişlerin ana kampanyalar tarafından gruplandırıldığı ve artık alfabetik olarak sıralanmadığı anlamına gelir.";
