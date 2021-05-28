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











$GLOBALS['phpAds_hlp_my_header'] = $GLOBALS['phpAds_hlp_my_footer'] = "Yönetici arayüzündeki her sayfada üstbilgi ve / veya altbilgi olması için üstbilgi dosyalarının yolunu buraya yerleştirmelisiniz (ör. /home/login/www/header.htm). Bu dosyalara metin veya html koyabilirsiniz (bu dosyalardan birinde veya her ikisinde html kullanmak istiyorsanız <body> veya <html> gibi etiketleri kullanmayın).";

$GLOBALS['phpAds_hlp_my_logo'] = "Burada, varsayılan logo yerine, görüntülemek istediğiniz özel logo dosyasının adını girmelisiniz. Logo burada dosya adını ayarlamadan önce admin / images dizinine yerleştirilmelidir.";

$GLOBALS['phpAds_hlp_gui_header_foreground_color'] = "Buraya, sekmeler, arama çubuğu ve kalın metin için kullanılacak özel bir renk koymalısınız.";

$GLOBALS['phpAds_hlp_gui_header_background_color'] = "Burada, üstbilgi arka planı için kullanılacak özel bir renk koymalısınız.";

$GLOBALS['phpAds_hlp_gui_header_active_tab_color'] = "Burada seçili olan ana sekme için kullanılacak özel bir renk koymalısınız.";

$GLOBALS['phpAds_hlp_gui_header_text_color'] = "Burada, üstbilgideki metin için kullanılacak özel bir renk koymalısınız.";

$GLOBALS['phpAds_hlp_content_gzip_compression'] = "GZIP içerik sıkıştırmasını etkinleştirerek, yönetici arayüzünün her sayfası açıldığında tarayıcıya gönderilen verilerin büyük bir kısmının azalmasını sağlayabilirsiniz.
Bu özelliği etkinleştirmek için GZIP uzantısının yüklü olması gerekir.";







$GLOBALS['phpAds_hlp_p3p_policy_location'] = "Tam bir gizlilik politikası kullanmak istiyorsanız, ilkenin bulunduğu yeri belirtebilirsiniz.";


$GLOBALS['phpAds_hlp_log_adviews'] = "Normalde tüm ilan izlemeleri günlüğe kaydedilir; İlan izlemesi ile ilgili istatistikleri toplamak istemiyorsanız, bu özelliği kapatabilirsiniz.";






$GLOBALS['phpAds_hlp_geotracking_stats'] = "Bir coğrafi hedefleme veritabanı kullanıyorsanız coğrafi bilgileri veritabanında da saklayabilirsiniz. Bu seçeneği etkinleştirdiyseniz, ziyaretçilerinizin konumu ve farklı ülkelerin her afişin performansı hakkında istatistikleri görebilirsiniz.
Bu seçenek yalnızca ayrıntılı istatistikler kullanıyorsanız kullanılabilir.";

$GLOBALS['phpAds_hlp_reverse_lookup'] = "Ana makine adı genellikle web sunucusu tarafından belirlenir, ancak bazı durumlarda bu kapatılabilir. Ziyaretçi kurallarının içinde ziyaretçi ana makine adını kullanmak ve / veya bununla ilgili istatistikleri tutmak ve aynı zamanda sunucu bu bilgiyi sağlamıyorsa, bu seçeneği etkinleştirebilirsiniz. Ziyaretçinin ana makine adının belirlenmesi biraz zaman alabilir; Afiş teslimatını yavaşlatacaktır.";


$GLOBALS['phpAds_hlp_obfuscate'] = "Burada hiçbir şey yok....";

$GLOBALS['phpAds_hlp_auto_clean_tables'] = $GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "Bu özelliği etkinleştirirseniz, bu onay kutusunun altındaki belirlediğiniz süre geçtikten sonra toplanan istatistikler otomatik olarak silinir. Örneğin, bunu 5 haftaya ayarlarsanız, 5 haftadan daha eski istatistikler otomatik olarak silinir.";

$GLOBALS['phpAds_hlp_auto_clean_userlog'] = $GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "Bu özellik, bu onay kutusunun altındaki belirtilen hafta sayısından daha eski girdileri otomatik olarak kullanıcı günlüğünden silecektir.";




$GLOBALS['phpAds_hlp_ignore_hosts'] = "Bazı bilgisayarlardan görüntülemeleri, tıklamaları ve dönüşümleri saymak istemiyorsanız bunları bu listeye ekleyebilirsiniz. Geriye doğru aramayı etkinleştirdiyseniz hem alan adlarını hem de IP adreslerini ekleyebilirsiniz, aksi takdirde sadece IP adreslerini kullanabilirsiniz. Joker karakterleri de kullanabilirsiniz (ör. '*.altavista.com' veya '192.168. *').";

$GLOBALS['phpAds_hlp_begin_of_week'] = "Çoğu insan için hafta Pazartesi günü ile başlar, ancak Pazar günü ile başlamak isterseniz yapabilirsiniz.";

$GLOBALS['phpAds_hlp_percentage_decimals'] = "İstatistik sayfalarında kaç tane ondalık basamak gösterileceğini belirtir.";








$GLOBALS['phpAds_hlp_type_web_mode'] = "Web sunucusunda saklanan afişleri kullanmak istiyorsanız, bu ayarı yapılandırmanız gerekir. Afişleri yerel bir dizinde saklamak isterseniz, bu seçeneği <i> Yerel dizin </i> olarak ayarlayın. Banner'ı harici bir FTP sunucusunda saklamak isterseniz, bu seçeneği <i> Harici FTP sunucusu </i> olarak ayarlayın. Bazı web sunucularında, FTP seçeneklerini yerel web sunucusunda bile kullanmak isteyebilirsiniz.";











$GLOBALS['phpAds_hlp_admin'] = "Lütfen yönetici kullanıcı adını giriniz. Bu kullanıcı adı ile yönetici arayüzüne giriş yapabilirsiniz.";

$GLOBALS['phpAds_hlp_admin_pw'] = $GLOBALS['phpAds_hlp_admin_pw2'] = "Lütfen yönetici arayüzüne giriş yapmak için kullanmak istediğiniz şifreyi girin.
Yazım hatalarını önlemek için iki kez girmeniz gerekir.";

$GLOBALS['phpAds_hlp_pwold'] = $GLOBALS['phpAds_hlp_pw'] = $GLOBALS['phpAds_hlp_pw2'] = "Yönetici şifresini değiştirmek için, yukarıdaki eski şifreyi belirtmeniz gerekebilir. Ayrıca, yazım hatalarını önlemek için yeni parolayı iki kez belirtmeniz gerekir.";

$GLOBALS['phpAds_hlp_admin_fullname'] = "Yöneticinin tam adını belirtin. Bu istatistikler e-posta ile gönderilirken kullanılır.";

$GLOBALS['phpAds_hlp_admin_email'] = "Yöneticinin e-posta adresi. Bu, e-posta yoluyla istatistik gönderirken gönderen adresi olarak kullanılır.";

$GLOBALS['phpAds_hlp_admin_novice'] = "Reklamverenleri, kampanyaları, afişleri, web sitelerini ve bölgeleri silmeden önce bir uyarı almak istiyorsanız; Bu seçeneği doğru olarak ayarlayın.";

$GLOBALS['phpAds_hlp_client_welcome'] = "Bu özelliği açarsanız hoş geldiniz mesajı, giriş yaptıktan sonra bir reklamverenin göreceği ilk sayfada görüntülenir. Admin / templates dizininde welcome.html dosya konumunu düzenleyerek bu mesajı kişiselleştirebilirsiniz. Eklemek isteyebileceğiniz şeyler şunlardır: Şirketinizin adı, iletişim bilgileri, şirket logonuz, özel bir sayfa ile reklamcılık oranları vb..";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "Welcome.html dosyasını düzenlemek yerine, burada küçük bir metin de belirleyebilirsiniz. Burada bir metin girerseniz, welcome.html dosyası yok sayılır. Html etiketlerini kullanmasına izin verilir.";



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
