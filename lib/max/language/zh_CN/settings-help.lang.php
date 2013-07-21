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
$GLOBALS['phpAds_hlp_dbhost'] = "\n        ��ָ����Ҫl�ӵ�".$phpAds_dbmsname."��ݿ������������.\n		";

$GLOBALS['phpAds_hlp_dbport'] = "\n        ��ָ����Ҫl�ӵ�".$phpAds_dbmsname."��ݿ������Ķ˿ں�. \n		".$phpAds_dbmsname."�������ȱʡ�˿ں���<i>" . ($phpAds_dbmsname == 'MySQL' ? '3306' : '5432')."</i>.";

$GLOBALS['phpAds_hlp_dbuser'] = "\n        ��ָ��".MAX_PRODUCT_NAME."��4��ȡ".$phpAds_dbmsname."��ݿ��������û���.\n		";

$GLOBALS['phpAds_hlp_dbpassword'] = "\n        ��ָ��".MAX_PRODUCT_NAME."��4��ȡ".$phpAds_dbmsname."��ݿ�����������.\n		";

$GLOBALS['phpAds_hlp_dbname'] = "\n        ��ָ��".MAX_PRODUCT_NAME."��".$phpAds_dbmsname."��ݿ����������4�����ݵ���ݿ���.\n		��Ҫע���������ݿ�������ϴ���ݿ�����Ѿ�����.\n		������ݿⲻ���ڵĻ�,".MAX_PRODUCT_NAME."��<b>����</b>�Զ���������ݿ�.\n		";

$GLOBALS['phpAds_hlp_persistent_connections'] = "\n        �>�l�ӵ�ʹ�ÿ��Ժܴ�����".MAX_PRODUCT_NAME."���ٶȺͼ�С������ĸ��ء� \n		������һ��ȱ�㣬�����һ��������վ�㣬��ô������ĸ��ػ��ʹ����ͨl��Ҫ��ӵĿ죬��ܿ�ﵽ���صĸ��ء�\n		ʹ����ͨl�ӻ����>�l��Ҫ������վ��ķ�����Ӳ�����4���\n		���".MAX_PRODUCT_NAME."ʹ����̫�����Դ����Ӧ���Ȳ鿴������á�\n		";

$GLOBALS['phpAds_hlp_compatibility_mode'] = "\n        ����������".MAX_PRODUCT_NAME."����������Ʒ��ʱ�������⣬��ѡ����ܰ��������ݿ�ļ���ģʽ��\n		���������ʹ�ñ��ص���ģʽ������ݿ�ļ���ģʽ�Ѿ��򿪣� \n		".MAX_PRODUCT_NAME."Ӧ�ñ�����ݿ�l��״̬��".MAX_PRODUCT_NAME."����ǰһ�¡� \n		��ѡ����һЩ���С������ȱʡ״̬�ǹرյġ�\n		";

$GLOBALS['phpAds_hlp_table_prefix'] = "\n        ���".MAX_PRODUCT_NAME."ʹ�õ���ݿ������������������,����ݿ��һ��ǰ׺��һ��ȽϺõ�ѡ��\n		�������ͬһ����ݿ���ʹ��".MAX_PRODUCT_NAME."�Ķ��װ�汾����Ҫ��֤���ǰ׺�����еİ�װ�汾����Ψһ�ġ�\n		";

$GLOBALS['phpAds_hlp_table_type'] = "\n        ".$phpAds_dbmsname."֧�ֶ�����ݱ����͡�ÿ����ݿⶼ�ж��е���������е��ܹ��ܴ����".MAX_PRODUCT_NAME."�������ٶȡ�\n		MyISAM��ȱʡ����ݱ����Ͳ��ҿ�����".$phpAds_dbmsname."�����а�װ�汾��ʹ�á��������͵���ݱ���ܲ�������ķ�������ʹ�á�\n		";

$GLOBALS['phpAds_hlp_url_prefix'] = "\n        ".MAX_PRODUCT_NAME."��Ҫ֪�����Լ�����ҳ�������λ�ò�������������ṩ".MAX_PRODUCT_NAME."��װĿ¼��URL��ַ�� \n        ���磺  http://www.your-url.com/".MAX_PRODUCT_NAME.".\n		";

$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "\n        ������ҳ�Ķ��ļ��͵��ļ���·��(e.g.: /home/login/www/header.htm)�����ڹ���Ա�����ÿ��ҳ������Ӷ��͵��ļ��� \n        ����Է��ı�����html�ļ�(�����ʹ�����ļ���ʹ��html���룬�벻Ҫʹ���� <body> or <html>�ı��)��\n		";

$GLOBALS['phpAds_hlp_content_gzip_compression'] = "如果开�?�GZIP，你的网站内容将被压缩，你的网页打开速度将会增加。你的系统环境必须支�?GZIP并开�?�。";

$GLOBALS['phpAds_hlp_language'] = "\n        ѡ��".MAX_PRODUCT_NAME."ʹ�õ�ȱʡ���ԡ�������Խ����������Ա�Ϳͻ������ȱʡ���ԡ� \n        ��ע�⣺�����Ϊ�ӹ���Ա����Ϊÿһ��ͻ����ò�ͬ�����Ժ��Ƿ�����ͻ��޸������Լ����������á�\n		";

$GLOBALS['phpAds_hlp_name'] = "\n        ��ָ���˳��������. ���ַ��ڹ���Ա�Ϳͻ����������ҳ������ʾ. \n		���Ϊ��(ȱʡ),����ʾһ��".MAX_PRODUCT_NAME."��ͼ��.\n		";

$GLOBALS['phpAds_hlp_company_name'] = "此�??字将用于�?��?�?�自 ". MAX_PRODUCT_NAME ." 的邮件。";

$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "\n        ".MAX_PRODUCT_NAME."ͨ��Ҫ���GD���Ƿ�װ��֧������ͼƬ��ʽ. ���Ǽ���п��ܲ�׼ȷ���ߴ���,\n		һЩ�汾��PHP��������֧�ֵ�ͼƬ��ʽ. ���".MAX_PRODUCT_NAME."�Զ����ͼƬ��ʽʧ��,\n		������ƶ���ȷ��ͼƬ��ʽ. ���ܵ�ֵ:none, png, jpeg, gif.\n		";

$GLOBALS['phpAds_hlp_p3p_policies'] = "\n        �����������".MAX_PRODUCT_NAME."'P3P��˽����',�����򿪴�ѡ��. \n		";

$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "\n        ���Բ����Ǻ�cookieһ���͵�. ȱʡ��������:'CUR ADM OUR NOR STA NID', \n		����Internet Explorer 6 ����".MAX_PRODUCT_NAME."ʹ�õ�cookie.\n		����Ը�Ĵ������Է�����Լ�����˽����.\n		";

$GLOBALS['phpAds_hlp_p3p_policy_location'] = "\n        �������ʹ��������˽����,������ƶ����Ե�λ��.\n		";

$GLOBALS['phpAds_hlp_compact_stats'] = "\n        ��ͳ��,".MAX_PRODUCT_NAME."ʹ�����൱�㷺�ļ�¼,�ǳ���ϸ���Ƕ���ݿ������Ҫ��ܸ�.\n		����һ������ߺܶ��վ��,����һ��ܴ������. Ϊ�˽���������,".MAX_PRODUCT_NAME."Ҳ֧��һ���µ�ͳ�Ʒ�ʽ:\n		���ͳ��ģʽ,����ݿ������Ҫ��СһЩ,���ǲ��Ǻ���ϸ.���ͳ��ģʽͳ��ÿСʱ�ķ�����͵����,\n		�������Ҫ����ϸ����Ϣ,����Ҫ�رռ��ͳ��ģʽ.\n		";

$GLOBALS['phpAds_hlp_log_adviews'] = "\n        ͨ�����еķ������¼,��������ռ�����������,���Թرմ�ѡ��.\n		";

$GLOBALS['phpAds_hlp_block_adviews'] = "\n		���һ�������ˢ��ҳ��,ÿ��".MAX_PRODUCT_NAME."�����¼������. \n		��ѡ����4��֤����ָ����ʱ�����ڶ�һ����Ķ�η��ʽ��¼һ�η�����.\n		��:��������ô�ֵΪ300��,".MAX_PRODUCT_NAME."��5�����ڴ˹��Դ˷�����û����ʾ��ż�¼�÷�����.\n		��ѡ�����������cookies��ʱ���������.\n		";

$GLOBALS['phpAds_hlp_log_adclicks'] = "\n        ͨ�����еĵ�����¼,��������ռ����������,���Թرմ�ѡ��.\n		";

$GLOBALS['phpAds_hlp_block_adclicks'] = "\n		���һ������ߵ��һ�����˶��,ÿ��".MAX_PRODUCT_NAME."�����¼�����.\n		��ѡ����4��֤����ָ����ʱ�����ڶ�һ����Ķ�ε����¼һ�ε����. \n		��:��������ô�ֵΪ300��,".MAX_PRODUCT_NAME."��5�����ڴ˷�����û�е���˹��ż�¼�õ����.\n		��ѡ�����������cookies��ʱ���������.\n		";

$GLOBALS['phpAds_hlp_geotracking_stats'] = "\n		���������ʹ��һ��geotargeting��ݿ�,����԰ѵ�����Ϣ������ݿ�.\n		i��������ô�ѡ��,�������ͳ������п�����ķ����ߵĵ���λ��\n		��ÿ�����ڲ�ͬ��ҷ��������.\n		��ѡ�����ʹ����ϸͳ�Ʒ�ʽ��ʱ�����ʹ��.\n		";

$GLOBALS['phpAds_hlp_reverse_lookup'] = "\n        	��ҳ����������Զ���⵽�����,����һЩ����´�ѡ���ǹرյ�.\n		��������ڷ���������ʹ�÷����ߵ��������Ϣ��/�򱣴��ͳ�����,\n		���ҷ�����û���ṩ����Ϣ,����Ҫ�򿪴�ѡ��.\n		���������ѯ��Ҫһ����ʱ��,���ܼ����淢�͵��ٶ�.\n		";

$GLOBALS['phpAds_hlp_proxy_lookup'] = "\n		һЩ�û�ʹ�ô��������4���ʻ�j��.�ڴ������,".MAX_PRODUCT_NAME."����¼����������IP��ַ���������,\n		�����û���. ��������ô�ѡ��,".MAX_PRODUCT_NAME."������ͨ����������������û�����ʵIP��ַ�������. \n		������ҵ��û�����ʵ��ַ,��ʹ�ô��������ĵ�ַ.��ѡ��ȱʡ��û������,��Ϊ���ܻ�����淢�͵��ٶ�.\n		";

$GLOBALS['phpAds_hlp_auto_clean_tables'] =
$GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "\n		��������ô�ѡ��,�������ڴ�ѡ�������ָ��ʱ���ͳ����ݽ����Զ�ɾ��.\n		����,���������Ϊ5������,��ô5������֮ǰ��ͳ����ݽ����Զ�ɾ��.\n		";

$GLOBALS['phpAds_hlp_auto_clean_userlog'] =
$GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "\n		��������ô�ѡ��,�������ڴ�ѡ�������ָ��ʱ����û���¼�����Զ�ɾ��.\n		����,���������Ϊ5������,��ô5������֮ǰ���û���¼�����Զ�ɾ��.\n		";

$GLOBALS['phpAds_hlp_geotracking_type'] = "\n		Geotargeting����".MAX_PRODUCT_NAME."�ѷ����ߵ�IP��ַת���ɵ�����Ϣ.\n		������ڴ���Ϣ�Ļ������÷�������,��������Ա������Ϣ4�鿴\n		�ĸ��������Ĺ�淢�ͺ͵����.\n		�����������geotargeting,����Ҫѡ�������е���ݿ�����.\n		".MAX_PRODUCT_NAME."����֧��<a href='http://hop.clickbank.net/?phpadsnew/ip2country' target='_blank'>IP2Country</a> \n		�� <a href='http://www.maxmind.com/?rId=phpadsnew' target='_blank'>GeoIP</a> ��ݿ�.\n		";

$GLOBALS['phpAds_hlp_geotracking_location'] = "\n		�����ʹ��GeoIP��Apacheģ��, ������Ӧ�ø���".MAX_PRODUCT_NAME."\n		geotargeting��ݿ��λ��. ǿ���Ƽ�Ѵ���ݿ�ŵ���ҳ��������ĵ�Ŀ¼����,\n		����Ļ������˿���ֱ�����ش���ݿ�.\n		";

$GLOBALS['phpAds_hlp_geotracking_cookie'] = "\n		��IP��ַת���ɵ�����Ϣ��Ҫһ����ʱ��.\n		Ϊ�˷�ֹ".MAX_PRODUCT_NAME."��ÿ���淢�͵�ʱ�򶼽���ת��,\n		���԰ѽ�����cookie��. ������cookie�Ѿ�����,\n		".MAX_PRODUCT_NAME."��ֱ��ʹ�ô���Ϣ������ת��IP.\n		";


$GLOBALS['phpAds_hlp_ignore_hosts'] = "\n        ��������¼�ض������ķ�����͵����,����԰����Ǽ�����б�. ����������˷��������ѯ,\n		�������������IP��ַ,������ֻ��ʹ��IP��ַ. ��Ҳ����ʹ��ͨ���(Ҳ����'*.altavista.com'����'192.168.*').\n		";

$GLOBALS['phpAds_hlp_begin_of_week'] = "\n        �Ժܶ���4˵����һ��һ�ܵĿ�ʼ,���������������������Ϊһ�ܵĿ�ʼ.\n		";

$GLOBALS['phpAds_hlp_percentage_decimals'] = "\n        ָ����ʾͳ����ݵ�ҳ�����ݾ�ȷ��С���֮��λ.\n		";

$GLOBALS['phpAds_hlp_warn_admin'] = "\n        ���һ����Ŀֻʣ�����޵ķ�����͵�����,".MAX_PRODUCT_NAME." �ܹ��������ʼ�4������.��ѡ��ȱʡ�Ǵ򿪵�.\n		";

$GLOBALS['phpAds_hlp_warn_client'] = "". MAX_PRODUCT_NAME ." 会给广告主�?��?邮件，如果他的广告项目�?�有一个";

$GLOBALS['phpAds_hlp_qmail_patch'] = "�?些版本的qmail�?�到一个程�?缺陷的影�?，此缺陷会导致�?��?自". MAX_PRODUCT_NAME ." 的电�?邮件首部显示在邮件正文当中。如果您�?�用这项设置，则 ". MAX_PRODUCT_NAME ." 会按照一�?与qmail兼容的格�?�?��?电�?邮件。";

$GLOBALS['phpAds_hlp_warn_limit'] = "". MAX_PRODUCT_NAME ." �?��?告警邮件的�?定�?�件。这是100";

$GLOBALS['phpAds_hlp_allow_invocation_plain'] =
$GLOBALS['phpAds_hlp_allow_invocation_js'] =
$GLOBALS['phpAds_hlp_allow_invocation_frame'] =
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] =
$GLOBALS['phpAds_hlp_allow_invocation_local'] =
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] =
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "\n		��Щ�����������������ʹ�õĵ��÷�ʽ.���ĳ����÷�ʽͣ��,�����ٳ����ڵ��ô���/���������ҳ��.\n		��Ҫ:���÷�ʽ���ͣ�ú󽫼�����,����˵ԭ�еĴ��뻹�ǿ��Լ���ʹ��,\n		ֻ���ڲ�����ô����ʱ����ʹ��.\n		";

$GLOBALS['phpAds_hlp_con_key'] = "\n        ".MAX_PRODUCT_NAME."��һ��ʹ��ֱ��ѡȡ��ʽ��ǿ��Ĺ��ѡ��ϵͳ.\n		�����ϸ����Ϣ��ο��û��ֲ�. ͨ���ѡ��,�������������ؼ���.���ѡ��ȱʡ�Ǵ򿪵�.\n		";

$GLOBALS['phpAds_hlp_mult_key'] = "\n        ���������ʹ��ֱ��ѡȡ��ʽ4��ʾ���,�����Ϊÿ����ָ��һ�����ؼ���.\n		��������ָ�����ؼ���,�������ô�ѡ��.���ѡ��ȱʡ�Ǵ򿪵�.\n		";

$GLOBALS['phpAds_hlp_acl'] = "\n        �����û��ʹ�÷�������ѡ��,����Թرմ�ѡ��,�⽫ʹ".MAX_PRODUCT_NAME."�ٶ���΢�ӿ�.\n		";

$GLOBALS['phpAds_hlp_default_banner_url'] =
$GLOBALS['phpAds_hlp_default_banner_target'] = "\n        ���".MAX_PRODUCT_NAME."����l�ӵ���ݿ������,���߲����ҵ���ϵĹ��,����ݿ��#���߱�ɾ��,\n		������ʾ�κζ���.һЩ�û������������������4��ʾһ��ָ����ȱʡ���.��ָ����ȱʡ��潫������¼,\n		�����ݿ����Ծ������õĹ��,��ָ����ȱʡ���Ҳ������ʹ��.���ѡ��ȱʡ�ǹرյ�.\n		";

$GLOBALS['phpAds_hlp_delivery_caching'] = "\n		Ϊ�˰�����߹�淢�͵��ٶ�,".MAX_PRODUCT_NAME."ʹ���˻���,uses a cache which includes all\n		�����а��˷���һ����������վ�����ߵ�������Ҫ����Ϣ.he information needed to delivery the banner to the visitor of your website. The delivery\n		����ͻ�����ȱʡ�Ǵ������ݿ���,Ϊ�˽�һ������ٶ�,\n		��Ҳ���Դ����һ���ļ����߹����ڴ���.\n		�����ڴ�������,�ļ�Ҳ�Ǻܿ��. ���鲻Ҫ�رմ˻�����, \n		��Ϊ�������Ӱ�켫��.\n		";

$GLOBALS['phpAds_hlp_type_sql_allow'] =
$GLOBALS['phpAds_hlp_type_web_allow'] =
$GLOBALS['phpAds_hlp_type_url_allow'] =
$GLOBALS['phpAds_hlp_type_html_allow'] =
$GLOBALS['phpAds_hlp_type_txt_allow'] = "\n        ".MAX_PRODUCT_NAME."����ʹ�ò�ͬ���͵Ĺ��,�ò�ͬ�ķ�ʽ��Ź��.ͷ}��ѡ����4�ڱ��ش�Ź��.\n		�����ʹ�ù���Ա����4�ϴ����,".MAX_PRODUCT_NAME."����SQL��ݿ������ҳ�������ϴ�Ź��.\n		��Ҳ���԰ѹ�������ⲿ��ҳ������,����ʹ��HTML�������4��ɹ��.\n		";

$GLOBALS['phpAds_hlp_type_web_mode'] = "\n        �������ʹ�ô������ҳ�������ϵĹ��,����Ҫ���ô�����.��������ڱ���Ŀ¼��Ź��,�Ѵ�ѡ������Ϊ<i>����Ŀ¼</i>.\n		�������ѹ���ŵ����FTP��������,�Ѵ�ѡ������Ϊ<i>�ⲿFTP������</i>.\n		��һЩ�ض�����ҳ��������,������������ڱ��ص���ҳ��������ʹ��FTPѡ��.\n		";

$GLOBALS['phpAds_hlp_type_web_dir'] = "\n        ָ��һ��Ŀ¼,".MAX_PRODUCT_NAME."��Ҫ���ϴ��Ĺ�渴�Ƶ���Ŀ¼.��Ŀ¼PHP������дȨ��,\n		����˵�������Ҫ�޸Ĵ�Ŀ¼��UNIXȨ��(chmod).ָ����Ŀ¼��������ҳ�������'�ĵ���Ŀ¼'��,\n		��ҳ������������ֱ�ӷ������ļ�.��Ҫָ����β��б��(/).����ڰѴ�ŷ�ʽ����Ϊ<i>����Ŀ¼</i>ʱ����Ҫ���ô�ѡ��.\n		";

$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "\n		��������ô�ŷ�ʽΪ<i>�ⲿFTP������</i>,����Ҫָ��FTP�������IP��ַ��������,��ʹ".MAX_PRODUCT_NAME."\n		�ܹ����ϴ��Ĺ�渴�Ƶ��˷�������.\n		";

$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "\n		��������ô�ŷ�ʽΪ<i>�ⲿFTP������</i>,����Ҫָ���ⲿFTP�������Ŀ¼,��ʹ".MAX_PRODUCT_NAME."\n		�ܹ����ϴ��Ĺ�渴�Ƶ���Ŀ¼.\n		";

$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "\n		��������ô�ŷ�ʽΪ<i>�ⲿFTP������</i>,����Ҫָ���ⲿFTP��������û���,��ʹ".MAX_PRODUCT_NAME."\n		�ܹ�l�ӵ��ⲿFTP������.\n		";

$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "\n		��������ô�ŷ�ʽΪ<i>�ⲿFTP������</i>,����Ҫָ���ⲿFTP�����������,��ʹ".MAX_PRODUCT_NAME."\n		�ܹ�l�ӵ��ⲿFTP������.\n		";

$GLOBALS['phpAds_hlp_type_web_url'] = "\n        ���������ҳ�������ϴ�Ź��,".MAX_PRODUCT_NAME."��Ҫ֪��������ָ����Ŀ¼�Ĺ����ķ��ʵ�ַ.\n		��Ҫָ����β��б��(/).\n		";

$GLOBALS['phpAds_hlp_type_html_auto'] = "\n        ���򿪴�ѡ��,".MAX_PRODUCT_NAME."���Զ��޸�HTML�������Լ�¼�����.\n		���Ǽ�ʹ��ѡ���,��Ȼ���Զ�ÿ����ͣ�ô˹���. \n		";

$GLOBALS['phpAds_hlp_type_html_php'] = "\n        ����ʹ".MAX_PRODUCT_NAME."��HTML��������ִ��PHP����,��ѡ��ȱʡ�ǹرյ�.\n		";

$GLOBALS['phpAds_hlp_admin'] = "\n        ���������Ա���û���. ͨ����û�������Ե�¼������Ա����.\n		";

$GLOBALS['phpAds_hlp_admin_pw'] =
$GLOBALS['phpAds_hlp_admin_pw2'] = "\n        ���������Ա������. ͨ����û�������Ե�¼������Ա����.����Ҫ����}�������������.\n		";

$GLOBALS['phpAds_hlp_pwold'] =
$GLOBALS['phpAds_hlp_pw'] =
$GLOBALS['phpAds_hlp_pw2'] = "\n        �޸ľ�����,����Ҫ���������������. ��Ҳ��Ҫ����������}��,�Ա����������.\n		";

$GLOBALS['phpAds_hlp_admin_fullname'] = "\n        ָ������Ա��ȫ��,��4ͨ������ʼ�����ͳ�Ʊ���.\n		";

$GLOBALS['phpAds_hlp_admin_email'] = "管�?�员的电�?邮件地�?�。用�?�“�?��?方地�?��?";

$GLOBALS['phpAds_hlp_admin_email_headers'] = "\n        ������޸�".MAX_PRODUCT_NAME."���͵����ʼ����ʼ�ͷ.\n		";

$GLOBALS['phpAds_hlp_admin_novice'] = "如果您希望在删除广告主�?项目�?广告�?网站和版�?时收到警告，请将这个选项设置为True";

$GLOBALS['phpAds_hlp_client_welcome'] = "\n		���򿪴�ѡ��,ÿ��ͻ���¼�����ҳ����ʾһ��ӭ��Ϣ.�����ͨ���޸�admin/templatesĿ¼�µ�\n		welcome.html�ļ�4�޸Ĵ���Ϣ.�������Ҫ��(����Ϣ��:��˾������,jϵ��Ϣ,��˾��ͼ��,һ����۸�ҳ��t�ӵ�.\n		";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "\n		����༭welcome.html�ļ�,�����������ָ��һЩ����.���������������������,welcome.html�ļ���������.\n		������������html���.\n		";

$GLOBALS['phpAds_hlp_updates_frequency'] = "\n		�������鿴".MAX_PRODUCT_NAME."�İ汾,��������ô�ѡ��.����ָ��".MAX_PRODUCT_NAME."l���������\n		�������ʱ����.����ҵ��°汾,�������˴�����Ϣ��һ��Ի��� \n		";

$GLOBALS['phpAds_hlp_userlog_email'] = "\n		������뱣��".MAX_PRODUCT_NAME."���͵����е����ʼ���Ϣ��һ���,��������ô�ѡ��.�����ʼ���Ϣ���������û���¼��.\n		";

$GLOBALS['phpAds_hlp_userlog_priority'] = "\n		Ϊ�˱�֤����Ȩ�������ȷ,�����Ϊÿ��Сʱ�ļ��㱣��һ�ݱ���. �����(Ԥ�5�����ÿ������������Ȩ.\n		�����Ϣ�������ύһ��bug�����ʱ��Ƚ�����. ���������û���¼��.\n		";

$GLOBALS['phpAds_hlp_userlog_autoclean'] = "\n		Ϊ�˱�֤��ݿ���ȷɾ��,\n		����Ա���һ�ݹ���ɾ���ڼ����з������ı���.\n		�����Ϣ���������û���¼��.\n		";

$GLOBALS['phpAds_hlp_default_banner_weight'] = "\n		�������ʹ��һ��ȱʡ��ߵĹ��Ȩֵ,�����������ָ���������Ȩֵ.���ѡ��ȱʡ����Ϊ1.\n		";

$GLOBALS['phpAds_hlp_default_campaign_weight'] = "\n		�������ʹ��һ��ȱʡ��ߵ���ĿȨֵ,�����������ָ���������Ȩֵ.���ѡ��ȱʡ����Ϊ1.\n		";

$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "这是一个�?外的选项，�?�以使�?个广告活动显示在<i>广告活动</i>页中。�?外的信�?�包括广告剩余数�?，广告点击数�?，广告转化数�?，有效期�?�优先设定";

$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "这是一个�?外的选项，�?�以使�?个广告活动显示在<i>广告</i>页中。�?外的信�?�包括目标URL，关键字，尺寸以�?�广告文件大�?。";

$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "这个选项�?�以让你在<i>广告</i>页中查看所有的广告。如果该选项被关闭，系统�?然�?�能显示广告总览。";

$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "\n		����ʾʵ�ʵ�HTML���,����HTML����.��ѡ��ȱʡ�ǹرյ�,��ΪHTML���������û��Ľ����ͻ.\n		���رմ�ѡ��,���HTML��������<i>��ʾ���</i>��ť,Ҳ������ʾʵ�ʵ�HTML���.\n		";

$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "\n		���򿪴�ѡ��,��<i>�������</i>,<i>����ѡ��</i>��<i>l�ӹ��</i>ҳ��,����ʾ����Ԥ��.\n		���رմ�ѡ��,���ҳ�涥����<i>��ʾ���</i>��ť,Ҳ���Կ�������Ԥ��.\n		";

$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "这个选项�?�以在<i>广告&活动</i> 和 <i>活动</i>页中�?�?所有未激活的广告，活动和广告主。如果改选项被开�?�，任然有�?�能通过<i>查看所有</i>按钮�?�查看那些未显示的�?�目。";

$GLOBALS['phpAds_hlp_gui_show_matching'] = "\n		������ô�ѡ��,Ȼ��ѡ��<i>��Ŀѡ��</i>ģʽ,\n		��ô�������Ĺ�潫��<i>l�ӹ��</i>ҳ����ʾ.\n		��������׼ȷ֪�����t�ӵ�����Ŀ,��Щ�����Է���.\n		��Ҳ����Ԥ��һ�·������Ĺ��.\n		";

$GLOBALS['phpAds_hlp_gui_show_parents'] = "\n		������ô�ѡ��,Ȼ��ѡ��<i>���ѡ��</i>ģʽ,\n		���ĸ���Ŀ����ʾ��<i>l�ӹ��</i>ҳ��.\n		��������֪���ڴ˹��ǰ�ĸ���Ŀ���ĸ����Ѿ�l����.\n		����ζ�Ź���ݸ���Ŀ4����,��������ǰ�����ĸ˳������.\n		";

$GLOBALS['phpAds_hlp_gui_link_compact_limit'] = "\n		ȱʡ���п��õĹ�����Ŀ����<i>l�ӹ��</i>ҳ����ʾ.\n		�������Ŀ¼���кܶ಻ͬ�Ŀ��ù��Ļ�,���ҳ����ķǳ���.\n		���ѡ�����������ô�ҳ�������ʾ����Ŀ.\n		����и����Ŀ�Ͳ�ͬl�ӷ�ʽ,����ʾռ�ÿռ����ٵĹ��.\n		";

?>
