<?php // $Revision: 2.0 $

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Settings help translation strings
$GLOBALS['phpAds_hlp_dbhost'] = "
        请指定您要连接的".$phpAds_dbmsname."数据库服务器的主机名.
		";
		
$GLOBALS['phpAds_hlp_dbport'] = "
        请指定您要连接的".$phpAds_dbmsname."数据库服务器的端口号. 
		".$phpAds_dbmsname."服务器的缺省端口号是<i>".
		($phpAds_productname == 'phpAdsNew' ? '3306' : '5432')."</i>.
		";
		
$GLOBALS['phpAds_hlp_dbuser'] = "
        请指定".$phpAds_productname."用来存取".$phpAds_dbmsname."数据库服务器的用户名.
		";
		
$GLOBALS['phpAds_hlp_dbpassword'] = "
        请指定".$phpAds_productname."用来存取".$phpAds_dbmsname."数据库服务器的密码.
		";
		
$GLOBALS['phpAds_hlp_dbname'] = "
        请指定".$phpAds_productname."在".$phpAds_dbmsname."数据库服务器上用来存放数据的数据库名.
		需要注意的是在数据库服务器上此数据库必须已经存在.
		如果此数据库不存在的话,".$phpAds_productname."将<b>不会</b>自动创建此数据库.
		";
		
$GLOBALS['phpAds_hlp_persistent_connections'] = "
        永久连接的使用可以很大的提高".$phpAds_productname."的速度和减小服务器的负载。 
		但是有一个缺点，如果是一个大访问量的站点，那么服务器的负载会比使用普通连接要增加的快，会很快达到很重的负载。
		使用普通连接还是永久连接要根据你的站点的访问量和硬件条件来决定。
		如果".$phpAds_productname."使用了太多的资源，您应该先查看这个设置。
		";
		
$GLOBALS['phpAds_hlp_insert_delayed'] = "
        ".$phpAds_dbmsname." 在插入数据的时候要锁定数据库。如果站点有很多的访问者， 
		很可能".$phpAds_productname."必须等待很长的时间才能插入一行新数据，因为数据库仍然被锁定。 
		如果你使用延迟插入，你不需要等待，当一段时间之后，如果数据表没有其他线程使用，此新行会被插入到数据表中。 
		";
		
$GLOBALS['phpAds_hlp_compatibility_mode'] = "
        如果你在整合".$phpAds_productname."与其他第三方产品的时候有问题，此选项可能帮助你打开数据库的兼容模式。
		如果你正在使用本地调用模式并且数据库的兼容模式已经打开， 
		".$phpAds_productname."应该保持数据库连接状态和".$phpAds_productname."运行前一致。 
		此选项有一些慢（很小）所以缺省状态是关闭的。
		";
		
$GLOBALS['phpAds_hlp_table_prefix'] = "
        如果".$phpAds_productname."使用的数据库是与其他多个软件共用,给数据库加一个前缀是一个比较好的选择。
		如果你在同一个数据库中使用".$phpAds_productname."的多个安装版本，你要保证这个前缀在所有的安装版本里是唯一的。
		";
		
$GLOBALS['phpAds_hlp_table_type'] = "
        ".$phpAds_dbmsname."支持多种数据表类型。每种数据库都有独有的特征而且有的能够很大提高".$phpAds_productname."的运行速度。
		MyISAM是缺省的数据表类型并且可以在".$phpAds_dbmsname."的所有安装版本上使用。其他类型的数据表可能不能在你的服务器上使用。
		";
		
$GLOBALS['phpAds_hlp_url_prefix'] = "
        ".$phpAds_productname."需要知道它自己在网页服务器的位置才能正常工作。你必须提供".$phpAds_productname."安装目录的URL地址， 
        例如：  http://www.your-url.com/".$phpAds_productname.".
		";
		
$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
        填入网页的顶文件和底文件的路径(e.g.: /home/login/www/header.htm)可以在管理员界面的每个页面上添加顶和底文件。 
        你可以放文本或者html文件(如果你使用在文件中使用html代码，请不要使用象 &lt;body> or &lt;html>的标记)。
		";
		
$GLOBALS['phpAds_hlp_content_gzip_compression'] = "
		启用GZIP内容压缩，会极大的减小每次管理员页面打开时发送给浏览器的数据。 
		PHP版本高于4.0.5并安装了GZIP附加模块才能启用此功能。
		";
		
$GLOBALS['phpAds_hlp_language'] = "
        选择".$phpAds_productname."使用的缺省语言。这个语言将被用作管理员和客户界面的缺省语言。 
        请注意：你可以为从管理员界面为每一个客户设置不同的语言和是否允许客户修改他们自己的语言设置。
		";
		
$GLOBALS['phpAds_hlp_name'] = "
        您指定此程序的名字. 此字符串将在管理员和客户界面的所有页面上显示. 
		如果为空(缺省),将显示一个".$phpAds_productname."的图标.
		";
		
$GLOBALS['phpAds_hlp_company_name'] = "
        这个名字是".$phpAds_productname."发送电子的邮件的时候使用的。
		";
		
$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
        ".$phpAds_productname."通常要检测GD库是否安装和支持哪种图片格式. 但是检测有可能不准确或者错误,
		一些版本的PHP不允许检测支持的图片格式. 如果".$phpAds_productname."自动检测图片格式失败,
		你可以制定正确的图片格式. 可能的值:none, png, jpeg, gif.
		";
		
$GLOBALS['phpAds_hlp_p3p_policies'] = "
        如果你想启用".$phpAds_productname."'P3P隐私策略',你必须打开此选项. 
		";
		
$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
        缩略策略是和cookie一起发送的. 缺省的设置是:'CUR ADM OUR NOR STA NID', 
		允许Internet Explorer 6 接受".$phpAds_productname."使用的cookie.
		您可以更改此设置以符合您自己的隐私声明.
		";
		
$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
        如果您想使用完整隐私策略,您可以制定策略的位置.
		";
		
$GLOBALS['phpAds_hlp_log_beacon'] = "
		信号灯是小的不可见的图片,可以放置在广告显示的页面上.如果您打开了此选项,
		".$phpAds_productname."将使用此信号灯来计算广告显示的次数. 
		如果您关闭了此选项,广告的显示次数将在发送的时候计算, 但是这样不完全准确, 
		因为一个已经发送的广告不一定总是显示在屏幕上. 
		";
		
$GLOBALS['phpAds_hlp_compact_stats'] = "
        传统上,".$phpAds_productname."使用了相当广泛的记录,非常详细但是对数据库服务器要求很高.
		对于一个访问者很多的站点,这是一个很大的问题. 为了解决这个问题,".$phpAds_productname."也支持一种新的统计方式:
		简洁统计模式,对数据库服务器要求小一些,但是不是很详细.简介统计模式统计每小时的访问数和点击数,
		如果您需要更详细的信息,您需要关闭简洁统计模式.
		";
		
$GLOBALS['phpAds_hlp_log_adviews'] = "
        通常所有的访问数都被记录,如果您不想收集访问数的数据,可以关闭此选项.
		";
		
$GLOBALS['phpAds_hlp_block_adviews'] = "
		如果一个访问者刷新页面,每次".$phpAds_productname."都会记录访问数. 
		此选项用来保证在您指定的时间间隔内对一个广告的多次访问仅记录一次访问数.
		如:如果您设置此值为300秒,".$phpAds_productname."仅当5分钟内此广告对此访问者没有显示过才记录该访问数.
		此选项仅当浏览器接受cookies的时候才起作用.
		";
		
$GLOBALS['phpAds_hlp_log_adclicks'] = "
        通常所有的点击数都被记录,如果您不想收集点击数的数据,可以关闭此选项.
		";
		
$GLOBALS['phpAds_hlp_block_adclicks'] = "
		如果一个访问者点击一个广告了多次,每次".$phpAds_productname."都会记录点击数.
		此选项用来保证在您指定的时间间隔内对一个广告的多次点击仅记录一次点击数. 
		如:如果您设置此值为300秒,".$phpAds_productname."仅当5分钟内此访问者没有点击过此广告才记录该点击数.
		此选项仅当浏览器接受cookies的时候才起作用.
		";
			
$GLOBALS['phpAds_hlp_log_source'] = "
		如果您正在广告调用代码中使用源参数,您可以把这个信息存到数据库中,
		这样您可以在统计数据中看到运行中的不同源参数信息.
		如果您没有使用源参数或者您不想使用此参数来保存信息,
		您可以安全的关闭此选项.
		";
		
$GLOBALS['phpAds_hlp_geotracking_stats'] = "
		如果您正在使用一个geotargeting数据库,您可以把地理信息存入数据库.
		i如果您启用此选项,您可以在统计数据中看到您的访问者的地理位置
		和每个广告在不同国家发布的情况.
		此选项仅当您使用详细统计方式的时候才能使用.
		";
		
$GLOBALS['phpAds_hlp_log_hostname'] = "
		如果您想保存每个访问者的主机名或者IP地址,您可以启用此选项.
		保存此信息您可以看到那些主机检索了最多的广告.
		此选项仅当您使用详细统计方式的时候才能使用.
		";
		
$GLOBALS['phpAds_hlp_log_iponly'] = "
		保存访问者的主机名会占用数据库很多的空间.
		如果您启用此选项,".$phpAds_productname."将还是保存主机的信息,
		但是仅保存占用空间少的IP地址信息.
		如果服务器不提供主机名或者".$phpAds_productname."设置问题,此选项不可用.
		因为此情况下总是记录IP地址.
		";
	
$GLOBALS['phpAds_hlp_reverse_lookup'] = "
        	网页服务器可以自动检测到主机名,但是一些情况下此选项是关闭的.
		如果您想在发送限制中使用访问者的主机名信息和/或保存此统计数据,
		并且服务器没有提供此信息,您需要打开此选项.
		反向域名查询需要一定的时间,可能减慢广告发送的速度.
		";
		
$GLOBALS['phpAds_hlp_proxy_lookup'] = "
		一些用户使用代理服务器来访问互联网.在此情况下,".$phpAds_productname."将记录代理服务器的IP地址或者主机名,
		而不是用户的. 如果您启用此选项,".$phpAds_productname."将查找通过代理服务器上网的用户的真实IP地址和主机名. 
		如果不能找到用户的真实地址,就使用代理服务器的地址.此选项缺省并没有启用,因为可能会减慢广告发送的速度.
		";
				
$GLOBALS['phpAds_hlp_auto_clean_tables'] = 
$GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "
		如果您启用此选项,超过您在此选择框下面指定时间的统计数据将被自动删除.
		例如,如果您设置为5个星期,那么5个星期之前的统计数据将被自动删除.
		";
		
$GLOBALS['phpAds_hlp_auto_clean_userlog'] = 
$GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "
		如果您启用此选项,超过您在此选择框下面指定时间的用户记录将被自动删除.
		例如,如果您设置为5个星期,那么5个星期之前的用户记录将被自动删除.
		";
		
$GLOBALS['phpAds_hlp_geotracking_type'] = "
		Geotargeting允许".$phpAds_productname."把访问者的IP地址转换成地理信息.
		您可以在此信息的基础上设置发送限制,或者您可以保存此信息来查看
		哪个国家有最多的广告发送和点击率.
		如果您想启用geotargeting,您需要选择您现有的数据库类型.
		".$phpAds_productname."现在支持<a href='http://hop.clickbank.net/?phpadsnew/ip2country' target='_blank'>IP2Country</a> 
		和 <a href='http://www.maxmind.com/?rId=phpadsnew' target='_blank'>GeoIP</a> 数据库.
		";
		
$GLOBALS['phpAds_hlp_geotracking_location'] = "
		除非您使用GeoIP的Apache模块, 否则您应该告诉".$phpAds_productname."
		geotargeting数据库的位置. 强烈推荐把此数据库放到网页服务器的文档目录外面,
		否则的话其他人可以直接下载此数据库.
		";
		
$GLOBALS['phpAds_hlp_geotracking_cookie'] = "
		把IP地址转换成地理信息需要一定的时间.
		为了防止".$phpAds_productname."在每个广告发送的时候都进行转换,
		可以把结果保存在cookie中. 如果这个cookie已经存在,
		".$phpAds_productname."将直接使用此信息而不用再转换IP.
		";
		

$GLOBALS['phpAds_hlp_ignore_hosts'] = "
        如果您不想记录特定计算机的访问数和点击数,您可以把他们加入此列表. 如果您启用了反向域名查询,
		您可以添加域名和IP地址,否则您只能使用IP地址. 您也可以使用通配符(也就是'*.altavista.com'或者'192.168.*').
		";
		
$GLOBALS['phpAds_hlp_begin_of_week'] = "
        对很多人来说星期一是一周的开始,但是您可以设置星期天作为一周的开始.
		";
		
$GLOBALS['phpAds_hlp_percentage_decimals'] = "
        指定显示统计数据的页面的数据精确到小数点之后几位.
		";
		
$GLOBALS['phpAds_hlp_warn_admin'] = "
        如果一个项目只剩下有限的访问数和点击数存量,".$phpAds_productname." 能够发电子邮件来提醒您.此选项缺省是打开的.
		";
		
$GLOBALS['phpAds_hlp_warn_client'] = "
        如果一个客户的某个项目只剩下有限的访问数和点击数存量".$phpAds_productname."能够发电子邮件来提醒客户.此选项缺省是打开的.
		";
		
$GLOBALS['phpAds_hlp_qmail_patch'] = "
		qmail的一些版本因为受到一个bug的影响,造成".$phpAds_productname."发送的电子邮件在邮件的内容里面显示邮件头.
		如果您启用此选项,".$phpAds_productname."将使用qmail兼容格式来发送电子邮件.
		";
		
$GLOBALS['phpAds_hlp_warn_limit'] = "
        ".$phpAds_productname."开始发送警告电子邮件的阀值,缺省是100.
		";
		
$GLOBALS['phpAds_hlp_allow_invocation_plain'] = 
$GLOBALS['phpAds_hlp_allow_invocation_js'] = 
$GLOBALS['phpAds_hlp_allow_invocation_frame'] = 
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] = 
$GLOBALS['phpAds_hlp_allow_invocation_local'] = 
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] = 
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "
		这些设置运行您控制允许使用的调用方式.如果某个调用方式停用,将不再出现在调用代码/广告代码产生页面.
		重要:调用方式如果停用后将继续工作,就是说原有的代码还是可以继续使用,
		只是在产生调用代码的时候不能使用.
		";
		
$GLOBALS['phpAds_hlp_con_key'] = "
        ".$phpAds_productname."包含一个使用直接选取方式的强大的广告选择系统.
		更多详细的信息请参考用户手册. 通过此选项,您可以启用条件关键字.这个选项缺省是打开的.
		";
		
$GLOBALS['phpAds_hlp_mult_key'] = "
        如果您正在使用直接选取方式来显示广告,您可以为每个广告指定一个或多个关键字.
		絮聒您想指定多个关键字,必须启用此选项.这个选项缺省是打开的.
		";
		
$GLOBALS['phpAds_hlp_acl'] = "
        如果您没有使用发送限制选项,您可以关闭此选项,这将使".$phpAds_productname."速度稍微加快.
		";
		
$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = "
        如果".$phpAds_productname."不能连接到数据库服务器,或者不能找到符合的广告,如数据库崩溃或者被删除,
		将不显示任何东西.一些用户可能想在这种情况下来显示一个指定的缺省广告.此指定的缺省广告将不被记录,
		如果数据库中仍旧有启用的广告,此指定的缺省广告也将不被使用.这个选项缺省是关闭的.
		";
			
$GLOBALS['phpAds_hlp_delivery_caching'] = "
		为了帮助提高广告发送的速度,".$phpAds_productname."使用了缓存,uses a cache which includes all
		缓存中包含了发送一个广告给你的网站访问者的所有需要的信息.he information needed to delivery the banner to the visitor of your website. The delivery
		这个发送缓存区缺省是存放在数据库里,为了进一步提高速度,
		它也可以存放在一个文件或者共享内存中.
		共享内存是最快的,文件也是很快的. 建议不要关闭此缓存区, 
		因为会对性能影响极大.
		";
		
$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = 
$GLOBALS['phpAds_hlp_type_txt_allow'] = "
        ".$phpAds_productname."可以使用不同类型的广告,用不同的方式存放广告.头两个选项用来在本地存放广告.
		您可以使用管理员界面来上传广告,".$phpAds_productname."将在SQL数据库或者网页服务器上存放广告.
		你也可以把广告存放在外部网页服务器,或者使用HTML或简单文字来生成广告.
		";
		
$GLOBALS['phpAds_hlp_type_web_mode'] = "
        如果您想使用存放在网页服务器上的广告,您需要配置此设置.如果您想在本地目录存放广告,把此选项设置为<i>本地目录</i>.
		如果您想把广告存放到外边FTP服务器上,把此选项设置为<i>外部FTP服务器</i>.
		在一些特定的网页服务器上,您可能甚至想在本地的网页服务器上使用FTP选项.
		";
		
$GLOBALS['phpAds_hlp_type_web_dir'] = "
        指定一个目录,".$phpAds_productname."需要把上传的广告复制到此目录.此目录PHP必须有写权限,
		就是说您可能需要修改此目录的UNIX权限(chmod).指定的目录必须在网页服务器的'文档根目录'下,
		网页服务器必须可以直接发布此文件.不要指定结尾的斜线(/).您仅在把存放方式设置为<i>本地目录</i>时才需要配置此选项.
		";
		
$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "
		如果您设置存放方式为<i>外部FTP服务器</i>,您需要指定FTP服务器的IP地址或者域名,以使".$phpAds_productname."
		能够把上传的广告复制到此服务器上.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "
		如果您设置存放方式为<i>外部FTP服务器</i>,您需要指定外部FTP服务器的目录,以使".$phpAds_productname."
		能够把上传的广告复制到此目录.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "
		如果您设置存放方式为<i>外部FTP服务器</i>,您需要指定外部FTP服务器的用户名,以使".$phpAds_productname."
		能够连接到外部FTP服务器.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "
		如果您设置存放方式为<i>外部FTP服务器</i>,您需要指定外部FTP服务器的密码,以使".$phpAds_productname."
		能够连接到外部FTP服务器.
		";
      
$GLOBALS['phpAds_hlp_type_web_url'] = "
        如果您在网页服务器上存放广告,".$phpAds_productname."需要知道下面您指定的目录的公开的访问地址.
		不要指定结尾的斜线(/).
		";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "
        如果打开此选项,".$phpAds_productname."将自动修改HTML广告代码以记录点击数.
		但是即使此选项打开,仍然可以对每个广告停用此功能. 
		";
		
$GLOBALS['phpAds_hlp_type_html_php'] = "
        可以使".$phpAds_productname."在HTML广告代码中执行PHP代码,此选项缺省是关闭的.
		";
		
$GLOBALS['phpAds_hlp_admin'] = "
        请输入管理员的用户名. 通过此用户名您可以登录到管理员界面.
		";
		
$GLOBALS['phpAds_hlp_admin_pw'] =
$GLOBALS['phpAds_hlp_admin_pw2'] = "
        请输入管理员的密码. 通过此用户名您可以登录到管理员界面.您需要输入两次以免输入错误.
		";
		
$GLOBALS['phpAds_hlp_pwold'] = 
$GLOBALS['phpAds_hlp_pw'] = 
$GLOBALS['phpAds_hlp_pw2'] = "
        修改旧密码,您需要在上面输入旧密码. 你也需要输入新密码两次,以避免输入错误.
		";
		
$GLOBALS['phpAds_hlp_admin_fullname'] = "
        指定管理员的全名,用来通过电子邮件发送统计报表.
		";
		
$GLOBALS['phpAds_hlp_admin_email'] = "
        管理员的电子邮件地址,用来作为发信人地址通过电子邮件发送统计报表.
		";
		
$GLOBALS['phpAds_hlp_admin_email_headers'] = "
        您可以修改".$phpAds_productname."发送电子邮件的邮件头.
		";
		
$GLOBALS['phpAds_hlp_admin_novice'] = "
        如果您想在删除客户,项目,广告,发布者和版位的时候得到一个警告信息,设置此选项为true.
		";
		
$GLOBALS['phpAds_hlp_client_welcome'] = "
		如果打开此选项,每个客户登录后的首页将显示一个欢迎信息.您可以通过修改admin/templates目录下的
		welcome.html文件来修改此信息.您可能想要包括的信息如:您公司的名字,联系信息,您公司的图标,一个广告价格页面链接等.
		";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
		代替编辑welcome.html文件,您可以在这里指定一些文字.如果您在这里输入了文字,welcome.html文件将被忽略.
		这里允许输入html标记.
		";
		
$GLOBALS['phpAds_hlp_updates_frequency'] = "
		如果您想查看".$phpAds_productname."的版本,您可以启用此选项.可以指定".$phpAds_productname."连到升级服务器
		进行升级的时间间隔.如果找到新版本,将弹出包含此次升级信息的一个对话框 
		";
		
$GLOBALS['phpAds_hlp_userlog_email'] = "
		如果您想保存".$phpAds_productname."发送的所有电子邮件信息的一个副本,您可以启用此选项.电子邮件信息将保存在用户记录里.
		";
		
$GLOBALS['phpAds_hlp_userlog_priority'] = "
		为了保证优先权计算的正确,您可以为每个小时的计算保存一份报表. 这个报表包括预估的情况和每个广告分配的优先权.
		这个信息在您想提交一个bug报告的时候比较有用. 这个报表存放在用户记录里.
		";
				
$GLOBALS['phpAds_hlp_userlog_autoclean'] = "
		为了保证数据库正确删减,
		您可以保存一份关于删减期间所有发生情况的报告.
		这个信息将保存在用户记录中.
		";
		
$GLOBALS['phpAds_hlp_default_banner_weight'] = "
		如果您想使用一个缺省更高的广告权值,您可以在这里指定您期望的权值.这个选项缺省设置为1.
		";
		
$GLOBALS['phpAds_hlp_default_campaign_weight'] = "
		如果您想使用一个缺省更高的项目权值,您可以在这里指定您期望的权值.这个选项缺省设置为1.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "
		如果打开此选项,每个项目的额外的信息将在<i>项目总览</i>页面上显示. 额外信息包括访问数的存量,点击数的存量,
		启用日期,失效日期和权值设置.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
		如果打开此选项,每个广告的额外的信息将在<i>广告总览</i>页面上显示. 额外信息包括目标URL,关键字,尺寸和权值.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
		如果打开此选项,<i>广告总览</i>页面将显示所有广告的预览.如果关闭此选项,在<i>广告总览</i>页面点击
		每个广告后面的三角图标,也可以显示每个广告的预览.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "
		将显示实际的HTML广告,而不是HTML代码.此选项缺省是关闭的,因为HTML广告可能与用户的界面冲突.
		如果关闭此选项,点击HTML代码后面的<i>显示广告</i>按钮,也可以显示实际的HTML广告.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "
		如果打开此选项,在<i>广告属性</i>,<i>发送选项</i>和<i>连接广告</i>页面,将显示广告的预览.
		如果关闭此选项,点击页面顶部的<i>显示广告</i>按钮,也可以看到广告的预览.
		";
		
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "
		如果启用此选项,所有停用的广告,项目,客户将在<i>客户&项目</i>和<i>项目总览</i>页面被隐藏. 
		当启用此选项,您仍旧可以点击页面底部的<i>显示所有</i>按钮来查看隐藏的条目.
		";
		
$GLOBALS['phpAds_hlp_gui_show_matching'] = "
		如果启用此选项,然后选定<i>项目选择</i>模式,
		那么符合条件的广告将在<i>连接广告</i>页面显示.
		这允许您准确知道如果链接到此项目,那些广告可以发送.
		您也可以预览一下符合条件的广告.
		";
		
$GLOBALS['phpAds_hlp_gui_show_parents'] = "
		如果启用此选项,然后选定<i>广告选择</i>模式,
		广告的父项目将显示在<i>连接广告</i>页面.
		这允许您知道在此广告前哪个项目的哪个广告已经连接了.
		这意味着广告根据父项目来分组,而不是象以前根据字母顺序排序.
		";
		
$GLOBALS['phpAds_hlp_gui_link_compact_limit'] = "
		缺省所有可用的广告和项目都在<i>连接广告</i>页面显示.
		所以如果目录中有很多不同的可用广告的话,这个页面会变的非常长.
		这个选项允许您设置此页面最多显示的条目.
		如果有更多条目和不同连接方式,将显示占用空间最少的广告.
		";
		
?>
