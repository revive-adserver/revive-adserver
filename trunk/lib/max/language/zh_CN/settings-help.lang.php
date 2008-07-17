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
        ��ָ����Ҫl�ӵ�".$phpAds_dbmsname."��ݿ������������.
		";
		
$GLOBALS['phpAds_hlp_dbport'] = "
        ��ָ����Ҫl�ӵ�".$phpAds_dbmsname."��ݿ������Ķ˿ں�. 
		".$phpAds_dbmsname."�������ȱʡ�˿ں���<i>".
		($phpAds_dbmsname == 'MySQL' ? '3306' : '5432')."</i>.
		";
		
$GLOBALS['phpAds_hlp_dbuser'] = "
        ��ָ��".$phpAds_productname."��4��ȡ".$phpAds_dbmsname."��ݿ��������û���.
		";
		
$GLOBALS['phpAds_hlp_dbpassword'] = "
        ��ָ��".$phpAds_productname."��4��ȡ".$phpAds_dbmsname."��ݿ�����������.
		";
		
$GLOBALS['phpAds_hlp_dbname'] = "
        ��ָ��".$phpAds_productname."��".$phpAds_dbmsname."��ݿ����������4�����ݵ���ݿ���.
		��Ҫע���������ݿ�������ϴ���ݿ�����Ѿ�����.
		������ݿⲻ���ڵĻ�,".$phpAds_productname."��<b>����</b>�Զ���������ݿ�.
		";
		
$GLOBALS['phpAds_hlp_persistent_connections'] = "
        �>�l�ӵ�ʹ�ÿ��Ժܴ�����".$phpAds_productname."���ٶȺͼ�С������ĸ��ء� 
		������һ��ȱ�㣬�����һ��������վ�㣬��ô������ĸ��ػ��ʹ����ͨl��Ҫ��ӵĿ죬��ܿ�ﵽ���صĸ��ء�
		ʹ����ͨl�ӻ����>�l��Ҫ������վ��ķ�����Ӳ�����4���
		���".$phpAds_productname."ʹ����̫�����Դ����Ӧ���Ȳ鿴������á�
		";
		
$GLOBALS['phpAds_hlp_compatibility_mode'] = "
        ����������".$phpAds_productname."����������Ʒ��ʱ�������⣬��ѡ����ܰ��������ݿ�ļ���ģʽ��
		���������ʹ�ñ��ص���ģʽ������ݿ�ļ���ģʽ�Ѿ��򿪣� 
		".$phpAds_productname."Ӧ�ñ�����ݿ�l��״̬��".$phpAds_productname."����ǰһ�¡� 
		��ѡ����һЩ���С������ȱʡ״̬�ǹرյġ�
		";
		
$GLOBALS['phpAds_hlp_table_prefix'] = "
        ���".$phpAds_productname."ʹ�õ���ݿ������������������,����ݿ��һ��ǰ׺��һ��ȽϺõ�ѡ��
		�������ͬһ����ݿ���ʹ��".$phpAds_productname."�Ķ��װ�汾����Ҫ��֤���ǰ׺�����еİ�װ�汾����Ψһ�ġ�
		";
		
$GLOBALS['phpAds_hlp_table_type'] = "
        ".$phpAds_dbmsname."֧�ֶ�����ݱ����͡�ÿ����ݿⶼ�ж��е���������е��ܹ��ܴ����".$phpAds_productname."�������ٶȡ�
		MyISAM��ȱʡ����ݱ����Ͳ��ҿ�����".$phpAds_dbmsname."�����а�װ�汾��ʹ�á��������͵���ݱ���ܲ�������ķ�������ʹ�á�
		";
		
$GLOBALS['phpAds_hlp_url_prefix'] = "
        ".$phpAds_productname."��Ҫ֪�����Լ�����ҳ�������λ�ò�������������ṩ".$phpAds_productname."��װĿ¼��URL��ַ�� 
        ���磺  http://www.your-url.com/".$phpAds_productname.".
		";
		
$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
        ������ҳ�Ķ��ļ��͵��ļ���·��(e.g.: /home/login/www/header.htm)�����ڹ���Ա�����ÿ��ҳ������Ӷ��͵��ļ��� 
        ����Է��ı�����html�ļ�(�����ʹ�����ļ���ʹ��html���룬�벻Ҫʹ���� <body> or <html>�ı��)��
		";
		
$GLOBALS['phpAds_hlp_content_gzip_compression'] = "
		����GZIP����ѹ��Ἣ��ļ�Сÿ�ι���Աҳ���ʱ���͸���������ݡ� 
		PHP�汾����4.0.5����װ��GZIP����ģ��������ô˹��ܡ�
		";
		
$GLOBALS['phpAds_hlp_language'] = "
        ѡ��".$phpAds_productname."ʹ�õ�ȱʡ���ԡ�������Խ����������Ա�Ϳͻ������ȱʡ���ԡ� 
        ��ע�⣺�����Ϊ�ӹ���Ա����Ϊÿһ��ͻ����ò�ͬ�����Ժ��Ƿ�����ͻ��޸������Լ����������á�
		";
		
$GLOBALS['phpAds_hlp_name'] = "
        ��ָ���˳��������. ���ַ��ڹ���Ա�Ϳͻ����������ҳ������ʾ. 
		���Ϊ��(ȱʡ),����ʾһ��".$phpAds_productname."��ͼ��.
		";
		
$GLOBALS['phpAds_hlp_company_name'] = "此名字将用于发送来自 \".MAX_PRODUCT_NAME.\" 的邮件。";
		
$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
        ".$phpAds_productname."ͨ��Ҫ���GD���Ƿ�װ��֧������ͼƬ��ʽ. ���Ǽ���п��ܲ�׼ȷ���ߴ���,
		һЩ�汾��PHP��������֧�ֵ�ͼƬ��ʽ. ���".$phpAds_productname."�Զ����ͼƬ��ʽʧ��,
		������ƶ���ȷ��ͼƬ��ʽ. ���ܵ�ֵ:none, png, jpeg, gif.
		";
		
$GLOBALS['phpAds_hlp_p3p_policies'] = "
        �����������".$phpAds_productname."'P3P��˽����',�����򿪴�ѡ��. 
		";
		
$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
        ���Բ����Ǻ�cookieһ���͵�. ȱʡ��������:'CUR ADM OUR NOR STA NID', 
		����Internet Explorer 6 ����".$phpAds_productname."ʹ�õ�cookie.
		����Ը�Ĵ������Է�����Լ�����˽����.
		";
		
$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
        �������ʹ��������˽����,������ƶ����Ե�λ��.
		";
		
$GLOBALS['phpAds_hlp_compact_stats'] = "
        ��ͳ��,".$phpAds_productname."ʹ�����൱�㷺�ļ�¼,�ǳ���ϸ���Ƕ���ݿ������Ҫ��ܸ�.
		����һ������ߺܶ��վ��,����һ��ܴ������. Ϊ�˽���������,".$phpAds_productname."Ҳ֧��һ���µ�ͳ�Ʒ�ʽ:
		���ͳ��ģʽ,����ݿ������Ҫ��СһЩ,���ǲ��Ǻ���ϸ.���ͳ��ģʽͳ��ÿСʱ�ķ�����͵����,
		�������Ҫ����ϸ����Ϣ,����Ҫ�رռ��ͳ��ģʽ.
		";
		
$GLOBALS['phpAds_hlp_log_adviews'] = "
        ͨ�����еķ������¼,��������ռ�����������,���Թرմ�ѡ��.
		";
		
$GLOBALS['phpAds_hlp_block_adviews'] = "
		���һ�������ˢ��ҳ��,ÿ��".$phpAds_productname."�����¼������. 
		��ѡ����4��֤����ָ����ʱ�����ڶ�һ����Ķ�η��ʽ��¼һ�η�����.
		��:��������ô�ֵΪ300��,".$phpAds_productname."��5�����ڴ˹��Դ˷�����û����ʾ��ż�¼�÷�����.
		��ѡ�����������cookies��ʱ���������.
		";
		
$GLOBALS['phpAds_hlp_log_adclicks'] = "
        ͨ�����еĵ�����¼,��������ռ����������,���Թرմ�ѡ��.
		";
		
$GLOBALS['phpAds_hlp_block_adclicks'] = "
		���һ������ߵ��һ�����˶��,ÿ��".$phpAds_productname."�����¼�����.
		��ѡ����4��֤����ָ����ʱ�����ڶ�һ����Ķ�ε����¼һ�ε����. 
		��:��������ô�ֵΪ300��,".$phpAds_productname."��5�����ڴ˷�����û�е���˹��ż�¼�õ����.
		��ѡ�����������cookies��ʱ���������.
		";
		
$GLOBALS['phpAds_hlp_geotracking_stats'] = "
		���������ʹ��һ��geotargeting��ݿ�,����԰ѵ�����Ϣ������ݿ�.
		i��������ô�ѡ��,�������ͳ������п�����ķ����ߵĵ���λ��
		��ÿ�����ڲ�ͬ��ҷ��������.
		��ѡ�����ʹ����ϸͳ�Ʒ�ʽ��ʱ�����ʹ��.
		";
		
$GLOBALS['phpAds_hlp_reverse_lookup'] = "
        	��ҳ����������Զ���⵽�����,����һЩ����´�ѡ���ǹرյ�.
		��������ڷ���������ʹ�÷����ߵ��������Ϣ��/�򱣴��ͳ�����,
		���ҷ�����û���ṩ����Ϣ,����Ҫ�򿪴�ѡ��.
		���������ѯ��Ҫһ����ʱ��,���ܼ����淢�͵��ٶ�.
		";
		
$GLOBALS['phpAds_hlp_proxy_lookup'] = "
		һЩ�û�ʹ�ô��������4���ʻ�j��.�ڴ������,".$phpAds_productname."����¼����������IP��ַ���������,
		�����û���. ��������ô�ѡ��,".$phpAds_productname."������ͨ����������������û�����ʵIP��ַ�������. 
		������ҵ��û�����ʵ��ַ,��ʹ�ô��������ĵ�ַ.��ѡ��ȱʡ��û������,��Ϊ���ܻ�����淢�͵��ٶ�.
		";
				
$GLOBALS['phpAds_hlp_auto_clean_tables'] = 
$GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "
		��������ô�ѡ��,�������ڴ�ѡ�������ָ��ʱ���ͳ����ݽ����Զ�ɾ��.
		����,���������Ϊ5������,��ô5������֮ǰ��ͳ����ݽ����Զ�ɾ��.
		";
		
$GLOBALS['phpAds_hlp_auto_clean_userlog'] = 
$GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "
		��������ô�ѡ��,�������ڴ�ѡ�������ָ��ʱ����û���¼�����Զ�ɾ��.
		����,���������Ϊ5������,��ô5������֮ǰ���û���¼�����Զ�ɾ��.
		";
		
$GLOBALS['phpAds_hlp_geotracking_type'] = "
		Geotargeting����".$phpAds_productname."�ѷ����ߵ�IP��ַת���ɵ�����Ϣ.
		������ڴ���Ϣ�Ļ������÷�������,��������Ա������Ϣ4�鿴
		�ĸ��������Ĺ�淢�ͺ͵����.
		�����������geotargeting,����Ҫѡ�������е���ݿ�����.
		".$phpAds_productname."����֧��<a href='http://hop.clickbank.net/?phpadsnew/ip2country' target='_blank'>IP2Country</a> 
		�� <a href='http://www.maxmind.com/?rId=phpadsnew' target='_blank'>GeoIP</a> ��ݿ�.
		";
		
$GLOBALS['phpAds_hlp_geotracking_location'] = "
		�����ʹ��GeoIP��Apacheģ��, ������Ӧ�ø���".$phpAds_productname."
		geotargeting��ݿ��λ��. ǿ���Ƽ�Ѵ���ݿ�ŵ���ҳ��������ĵ�Ŀ¼����,
		����Ļ������˿���ֱ�����ش���ݿ�.
		";
		
$GLOBALS['phpAds_hlp_geotracking_cookie'] = "
		��IP��ַת���ɵ�����Ϣ��Ҫһ����ʱ��.
		Ϊ�˷�ֹ".$phpAds_productname."��ÿ���淢�͵�ʱ�򶼽���ת��,
		���԰ѽ�����cookie��. ������cookie�Ѿ�����,
		".$phpAds_productname."��ֱ��ʹ�ô���Ϣ������ת��IP.
		";
		

$GLOBALS['phpAds_hlp_ignore_hosts'] = "
        ��������¼�ض������ķ�����͵����,����԰����Ǽ�����б�. ����������˷��������ѯ,
		�������������IP��ַ,������ֻ��ʹ��IP��ַ. ��Ҳ����ʹ��ͨ���(Ҳ����'*.altavista.com'����'192.168.*').
		";
		
$GLOBALS['phpAds_hlp_begin_of_week'] = "
        �Ժܶ���4˵����һ��һ�ܵĿ�ʼ,���������������������Ϊһ�ܵĿ�ʼ.
		";
		
$GLOBALS['phpAds_hlp_percentage_decimals'] = "
        ָ����ʾͳ����ݵ�ҳ�����ݾ�ȷ��С���֮��λ.
		";
		
$GLOBALS['phpAds_hlp_warn_admin'] = "
        ���һ����Ŀֻʣ�����޵ķ�����͵�����,".$phpAds_productname." �ܹ��������ʼ�4������.��ѡ��ȱʡ�Ǵ򿪵�.
		";
		
$GLOBALS['phpAds_hlp_warn_client'] = "\".MAX_PRODUCT_NAME.\" 会给广告主发送邮件，如果他的广告项目只有一个";
		
$GLOBALS['phpAds_hlp_qmail_patch'] = "某些版本的qmail受到一个程序缺陷的影响，此缺陷会导致发送自\".MAX_PRODUCT_NAME.\" 的电子邮件首部显示在邮件正文当中。如果您启用这项设置，则 \".MAX_PRODUCT_NAME.\" 会按照一种与qmail兼容的格式发送电子邮件。";
		
$GLOBALS['phpAds_hlp_warn_limit'] = "\".MAX_PRODUCT_NAME.\" 发送告警邮件的限定条件。这是100";
		
$GLOBALS['phpAds_hlp_allow_invocation_plain'] = 
$GLOBALS['phpAds_hlp_allow_invocation_js'] = 
$GLOBALS['phpAds_hlp_allow_invocation_frame'] = 
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] = 
$GLOBALS['phpAds_hlp_allow_invocation_local'] = 
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] = 
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "
		��Щ�����������������ʹ�õĵ��÷�ʽ.���ĳ����÷�ʽͣ��,�����ٳ����ڵ��ô���/���������ҳ��.
		��Ҫ:���÷�ʽ���ͣ�ú󽫼�����,����˵ԭ�еĴ��뻹�ǿ��Լ���ʹ��,
		ֻ���ڲ�����ô����ʱ����ʹ��.
		";
		
$GLOBALS['phpAds_hlp_con_key'] = "
        ".$phpAds_productname."��һ��ʹ��ֱ��ѡȡ��ʽ��ǿ��Ĺ��ѡ��ϵͳ.
		�����ϸ����Ϣ��ο��û��ֲ�. ͨ���ѡ��,�������������ؼ���.���ѡ��ȱʡ�Ǵ򿪵�.
		";
		
$GLOBALS['phpAds_hlp_mult_key'] = "
        ���������ʹ��ֱ��ѡȡ��ʽ4��ʾ���,�����Ϊÿ����ָ��һ�����ؼ���.
		��������ָ�����ؼ���,�������ô�ѡ��.���ѡ��ȱʡ�Ǵ򿪵�.
		";
		
$GLOBALS['phpAds_hlp_acl'] = "
        �����û��ʹ�÷�������ѡ��,����Թرմ�ѡ��,�⽫ʹ".$phpAds_productname."�ٶ���΢�ӿ�.
		";
		
$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = "
        ���".$phpAds_productname."����l�ӵ���ݿ������,���߲����ҵ���ϵĹ��,����ݿ��#���߱�ɾ��,
		������ʾ�κζ���.һЩ�û������������������4��ʾһ��ָ����ȱʡ���.��ָ����ȱʡ��潫������¼,
		�����ݿ����Ծ������õĹ��,��ָ����ȱʡ���Ҳ������ʹ��.���ѡ��ȱʡ�ǹرյ�.
		";
			
$GLOBALS['phpAds_hlp_delivery_caching'] = "
		Ϊ�˰�����߹�淢�͵��ٶ�,".$phpAds_productname."ʹ���˻���,uses a cache which includes all
		�����а��˷���һ����������վ�����ߵ�������Ҫ����Ϣ.he information needed to delivery the banner to the visitor of your website. The delivery
		����ͻ�����ȱʡ�Ǵ������ݿ���,Ϊ�˽�һ������ٶ�,
		��Ҳ���Դ����һ���ļ����߹����ڴ���.
		�����ڴ�������,�ļ�Ҳ�Ǻܿ��. ���鲻Ҫ�رմ˻�����, 
		��Ϊ�������Ӱ�켫��.
		";
		
$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = 
$GLOBALS['phpAds_hlp_type_txt_allow'] = "
        ".$phpAds_productname."����ʹ�ò�ͬ���͵Ĺ��,�ò�ͬ�ķ�ʽ��Ź��.ͷ}��ѡ����4�ڱ��ش�Ź��.
		�����ʹ�ù���Ա����4�ϴ����,".$phpAds_productname."����SQL��ݿ������ҳ�������ϴ�Ź��.
		��Ҳ���԰ѹ�������ⲿ��ҳ������,����ʹ��HTML�������4��ɹ��.
		";
		
$GLOBALS['phpAds_hlp_type_web_mode'] = "
        �������ʹ�ô������ҳ�������ϵĹ��,����Ҫ���ô�����.��������ڱ���Ŀ¼��Ź��,�Ѵ�ѡ������Ϊ<i>����Ŀ¼</i>.
		�������ѹ���ŵ����FTP��������,�Ѵ�ѡ������Ϊ<i>�ⲿFTP������</i>.
		��һЩ�ض�����ҳ��������,������������ڱ��ص���ҳ��������ʹ��FTPѡ��.
		";
		
$GLOBALS['phpAds_hlp_type_web_dir'] = "
        ָ��һ��Ŀ¼,".$phpAds_productname."��Ҫ���ϴ��Ĺ�渴�Ƶ���Ŀ¼.��Ŀ¼PHP������дȨ��,
		����˵�������Ҫ�޸Ĵ�Ŀ¼��UNIXȨ��(chmod).ָ����Ŀ¼��������ҳ�������'�ĵ���Ŀ¼'��,
		��ҳ������������ֱ�ӷ������ļ�.��Ҫָ����β��б��(/).����ڰѴ�ŷ�ʽ����Ϊ<i>����Ŀ¼</i>ʱ����Ҫ���ô�ѡ��.
		";
		
$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "
		��������ô�ŷ�ʽΪ<i>�ⲿFTP������</i>,����Ҫָ��FTP�������IP��ַ��������,��ʹ".$phpAds_productname."
		�ܹ����ϴ��Ĺ�渴�Ƶ��˷�������.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "
		��������ô�ŷ�ʽΪ<i>�ⲿFTP������</i>,����Ҫָ���ⲿFTP�������Ŀ¼,��ʹ".$phpAds_productname."
		�ܹ����ϴ��Ĺ�渴�Ƶ���Ŀ¼.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "
		��������ô�ŷ�ʽΪ<i>�ⲿFTP������</i>,����Ҫָ���ⲿFTP��������û���,��ʹ".$phpAds_productname."
		�ܹ�l�ӵ��ⲿFTP������.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "
		��������ô�ŷ�ʽΪ<i>�ⲿFTP������</i>,����Ҫָ���ⲿFTP�����������,��ʹ".$phpAds_productname."
		�ܹ�l�ӵ��ⲿFTP������.
		";
      
$GLOBALS['phpAds_hlp_type_web_url'] = "
        ���������ҳ�������ϴ�Ź��,".$phpAds_productname."��Ҫ֪��������ָ����Ŀ¼�Ĺ����ķ��ʵ�ַ.
		��Ҫָ����β��б��(/).
		";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "
        ���򿪴�ѡ��,".$phpAds_productname."���Զ��޸�HTML�������Լ�¼�����.
		���Ǽ�ʹ��ѡ���,��Ȼ���Զ�ÿ����ͣ�ô˹���. 
		";
		
$GLOBALS['phpAds_hlp_type_html_php'] = "
        ����ʹ".$phpAds_productname."��HTML��������ִ��PHP����,��ѡ��ȱʡ�ǹرյ�.
		";
		
$GLOBALS['phpAds_hlp_admin'] = "
        ���������Ա���û���. ͨ����û�������Ե�¼������Ա����.
		";
		
$GLOBALS['phpAds_hlp_admin_pw'] =
$GLOBALS['phpAds_hlp_admin_pw2'] = "
        ���������Ա������. ͨ����û�������Ե�¼������Ա����.����Ҫ����}�������������.
		";
		
$GLOBALS['phpAds_hlp_pwold'] = 
$GLOBALS['phpAds_hlp_pw'] = 
$GLOBALS['phpAds_hlp_pw2'] = "
        �޸ľ�����,����Ҫ���������������. ��Ҳ��Ҫ����������}��,�Ա����������.
		";
		
$GLOBALS['phpAds_hlp_admin_fullname'] = "
        ָ������Ա��ȫ��,��4ͨ������ʼ�����ͳ�Ʊ���.
		";
		
$GLOBALS['phpAds_hlp_admin_email'] = "
        ����Ա�ĵ����ʼ���ַ,��4��Ϊ�����˵�ַͨ������ʼ�����ͳ�Ʊ���.
		";
		
$GLOBALS['phpAds_hlp_admin_email_headers'] = "
        ������޸�".$phpAds_productname."���͵����ʼ����ʼ�ͷ.
		";
		
$GLOBALS['phpAds_hlp_admin_novice'] = "如果您希望在删除广告主、项目、广告、网站和版位时收到警告，请将这个选项设置为True";
		
$GLOBALS['phpAds_hlp_client_welcome'] = "
		���򿪴�ѡ��,ÿ��ͻ���¼�����ҳ����ʾһ��ӭ��Ϣ.�����ͨ���޸�admin/templatesĿ¼�µ�
		welcome.html�ļ�4�޸Ĵ���Ϣ.�������Ҫ��(����Ϣ��:��˾������,jϵ��Ϣ,��˾��ͼ��,һ����۸�ҳ��t�ӵ�.
		";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
		����༭welcome.html�ļ�,�����������ָ��һЩ����.���������������������,welcome.html�ļ���������.
		������������html���.
		";
		
$GLOBALS['phpAds_hlp_updates_frequency'] = "
		�������鿴".$phpAds_productname."�İ汾,��������ô�ѡ��.����ָ��".$phpAds_productname."l���������
		�������ʱ����.����ҵ��°汾,�������˴�����Ϣ��һ��Ի��� 
		";
		
$GLOBALS['phpAds_hlp_userlog_email'] = "
		������뱣��".$phpAds_productname."���͵����е����ʼ���Ϣ��һ���,��������ô�ѡ��.�����ʼ���Ϣ���������û���¼��.
		";
		
$GLOBALS['phpAds_hlp_userlog_priority'] = "
		Ϊ�˱�֤����Ȩ�������ȷ,�����Ϊÿ��Сʱ�ļ��㱣��һ�ݱ���. �����(Ԥ�5�����ÿ������������Ȩ.
		�����Ϣ�������ύһ��bug�����ʱ��Ƚ�����. ���������û���¼��.
		";
				
$GLOBALS['phpAds_hlp_userlog_autoclean'] = "
		Ϊ�˱�֤��ݿ���ȷɾ��,
		����Ա���һ�ݹ���ɾ���ڼ����з������ı���.
		�����Ϣ���������û���¼��.
		";
		
$GLOBALS['phpAds_hlp_default_banner_weight'] = "
		�������ʹ��һ��ȱʡ��ߵĹ��Ȩֵ,�����������ָ���������Ȩֵ.���ѡ��ȱʡ����Ϊ1.
		";
		
$GLOBALS['phpAds_hlp_default_campaign_weight'] = "
		�������ʹ��һ��ȱʡ��ߵ���ĿȨֵ,�����������ָ���������Ȩֵ.���ѡ��ȱʡ����Ϊ1.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "
		���򿪴�ѡ��,ÿ����Ŀ�Ķ������Ϣ����<i>��Ŀ����</i>ҳ������ʾ. ������Ϣ��(������Ĵ�,�����Ĵ�,
		��������,ʧЧ���ں�Ȩֵ����.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
		���򿪴�ѡ��,ÿ����Ķ������Ϣ����<i>�������</i>ҳ������ʾ. ������Ϣ��(Ŀ��URL,�ؼ���,�ߴ��Ȩֵ.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
		���򿪴�ѡ��,<i>�������</i>ҳ�潫��ʾ���й���Ԥ��.���رմ�ѡ��,��<i>�������</i>ҳ����
		ÿ�����������ͼ��,Ҳ������ʾÿ�����Ԥ��.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "
		����ʾʵ�ʵ�HTML���,����HTML����.��ѡ��ȱʡ�ǹرյ�,��ΪHTML���������û��Ľ����ͻ.
		���رմ�ѡ��,���HTML��������<i>��ʾ���</i>��ť,Ҳ������ʾʵ�ʵ�HTML���.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "
		���򿪴�ѡ��,��<i>�������</i>,<i>����ѡ��</i>��<i>l�ӹ��</i>ҳ��,����ʾ����Ԥ��.
		���رմ�ѡ��,���ҳ�涥����<i>��ʾ���</i>��ť,Ҳ���Կ�������Ԥ��.
		";
		
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "
		������ô�ѡ��,����ͣ�õĹ��,��Ŀ,�ͻ�����<i>�ͻ�&��Ŀ</i>��<i>��Ŀ����</i>ҳ�汻����. 
		�����ô�ѡ��,���Ծɿ��Ե��ҳ��ײ���<i>��ʾ����</i>��ť4�鿴���ص���Ŀ.
		";
		
$GLOBALS['phpAds_hlp_gui_show_matching'] = "
		������ô�ѡ��,Ȼ��ѡ��<i>��Ŀѡ��</i>ģʽ,
		��ô�������Ĺ�潫��<i>l�ӹ��</i>ҳ����ʾ.
		��������׼ȷ֪�����t�ӵ�����Ŀ,��Щ�����Է���.
		��Ҳ����Ԥ��һ�·������Ĺ��.
		";
		
$GLOBALS['phpAds_hlp_gui_show_parents'] = "
		������ô�ѡ��,Ȼ��ѡ��<i>���ѡ��</i>ģʽ,
		���ĸ���Ŀ����ʾ��<i>l�ӹ��</i>ҳ��.
		��������֪���ڴ˹��ǰ�ĸ���Ŀ���ĸ����Ѿ�l����.
		����ζ�Ź���ݸ���Ŀ4����,��������ǰ�����ĸ˳������.
		";
		
$GLOBALS['phpAds_hlp_gui_link_compact_limit'] = "
		ȱʡ���п��õĹ�����Ŀ����<i>l�ӹ��</i>ҳ����ʾ.
		�������Ŀ¼���кܶ಻ͬ�Ŀ��ù��Ļ�,���ҳ����ķǳ���.
		���ѡ�����������ô�ҳ�������ʾ����Ŀ.
		����и����Ŀ�Ͳ�ͬl�ӷ�ʽ,����ʾռ�ÿռ����ٵĹ��.
		";
		
?>
