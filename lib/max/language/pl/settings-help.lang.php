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
        Specify the hostname of the ".$phpAds_dbmsname." database server.
		";
		
$GLOBALS['phpAds_hlp_dbuser'] = "
        Specify the username which ".$phpAds_productname." must use to gain access to the ".$phpAds_dbmsname." database server.
		";
		
$GLOBALS['phpAds_hlp_dbpassword'] = "
        Specify the password which ".$phpAds_productname." must use to gain access to the ".$phpAds_dbmsname." database server.
		";
		
$GLOBALS['phpAds_hlp_dbname'] = "
        Specify the name of the database where ".$phpAds_productname." must store its data.
		";
		
$GLOBALS['phpAds_hlp_persistent_connections'] = "
        The use of persistent connection can speed up ".$phpAds_productname." considerably 
		and may even decrease the load on the server. There is a drawback however, on sites with 
		a lot of visitors the load on the server can increase and become larger then when using normal 
		connections. Whether you should use regular connections or persistant connections depends on the 
		number of visitors and the hardware your are using. If ".$phpAds_productname." is using too many resources, 
		you should take a look at this setting first.
		";
		
$GLOBALS['phpAds_hlp_compatibility_mode'] = "
        If you are having problem integrating ".$phpAds_productname." with another thirth-party product it 
		might help to turn on the database compatibility mode. If you are using local mode 
		invocation and the database compatibility is turned on ".$phpAds_productname." should leave 
		the state of the database connection exectly the same as it was before ".$phpAds_productname." ran. 
		This option is a bit slower (only slightly) and therefore turned off by default.
		";
		
$GLOBALS['phpAds_hlp_table_prefix'] = "
        If the database ".$phpAds_productname." is using is shared by mutiple software products, it is wise
		to add a prefix to names of the tables. If you are using multiple installations of ".$phpAds_productname."
		in the same database, you need to make sure this prefix is unique for all installations.
		";
		
$GLOBALS['phpAds_hlp_tabletype'] = "
        ".$phpAds_dbmsname." supports multiple table types. Each type of table has unique properties and some
		can speed up ".$phpAds_productname." considerable. MyISAM is the default table type and is available
		in all installations of ".$phpAds_dbmsname.". Other table types may not be available on your server
		";
		
$GLOBALS['phpAds_hlp_url_prefix'] = "
        ".$phpAds_productname." needs to know where it is located on the web server in order 
        to work correctly. You must specify the URL to the directory where ".$phpAds_productname." 
        is installed, for example: http://www.your-url.com/".$phpAds_productname.".
		";
		
$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
        You should put here the path to the header files (e.g.: /home/login/www/header.htm) 
        to have a header and/or footer on each page in the admin interface. You 
        can put either text or html in these files (if you want to use html in 
        one or both of these files do not use tags like <body> or <html>).
		";
		
$GLOBALS['phpAds_hlp_content_gzip_compression'] = "
		By enabling GZIP content compression you will get a big decrease of the data which 
		is sent to the browser each time a page of the administrator interface is opened. 
		To enable this feature you need to have at least PHP 4.0.5 with the GZIP extention installed.
		";
		
$GLOBALS['phpAds_hlp_language'] = "
        Specify the default language ".$phpAds_productname." should use. This language will 
        be used as a default for the admin and advertiser interface. Please note: 
        you can set a different language for each advertiser from the admin interface 
        and allow advertisers to change their language themselves.
		";
		
$GLOBALS['phpAds_hlp_name'] = "
        Specify the name you want to use for this application. This string will 
        be displayed on all pages in the admin and advertiser interface. If you leave 
        this setting empty (default) a logo of ".$phpAds_productname." will be displayed instead.
		";
		
$GLOBALS['phpAds_hlp_company_name'] = "
        This name is used in the e-mail sent by ".$phpAds_productname.".
		";
		
$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
        ".$phpAds_productname." usually detects if the GD library is installed and which image 
        format is supported by the installed version of GD. However it is possible 
        the detection is not accurate or false, some versions of PHP do not allow 
        the detection of the supported image formats. If ".$phpAds_productname." fails to auto-detect 
        the right image format you can specify the right image format. Possible 
        values are: none, png, jpeg, gif.
		";
		
$GLOBALS['phpAds_hlp_p3p_policies'] = "
        If you want to enable ".$phpAds_productname."' P3P Privacy Policies you must turn this 
        option on. 
		";
		
$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
        The compact policy which is sent together with cookies. The default setting 
        is: 'CUR ADM OUR NOR STA NID', which will allow Internet Explorer 6 to 
        accept the cookies used by ".$phpAds_productname.". If you want you can alter these 
        settings to match your own privacy statement.
		";
		
$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
        If you want to use a full privacy policy, you can specify the location 
        of the policy.
		";
		
$GLOBALS['phpAds_hlp_compact_stats'] = "
        Traditionally ".$phpAds_productname." used rather extensive logging, which was very 
        detailed but was also very demanding on the database server. This could 
        be a big problem on sites with a lot of visitors. To overcome this problem
		".$phpAds_productname." also supports a new kind of statistics, the compact statistics, 
		which is less demanding on the database server, but also less detailed. 
		The compact statistics only logs daily statistics, if you need hourly statistics 
		you can turn the compact statistics off.
		";
		
$GLOBALS['phpAds_hlp_log_adviews'] = "
        Normally all AdViews are logged, if you don't want to gather statistics 
        about AdViews you can turn this off.
		";
		
$GLOBALS['phpAds_hlp_block_adviews'] = "
		If a visitor reloads a page an AdView will be logged by ".$phpAds_productname." every time. 
		This feature is used to make sure that only one AdView is logged for each unique 
		banner for the number of seconds you specify. For example: if you set this value 
		to 300 seconds, ".$phpAds_productname." will only log AdViews if the same banner isnďż˝t already 
		shown to the same visitor in the last 5 minutes. This feature only works when <i>Use 
		beacons to log AdViews</i> is enabled and if the browser accepts cookies.
		";
		
$GLOBALS['phpAds_hlp_log_adclicks'] = "
        Normally all AdClicks are logged, if you don't want to gather statistics 
        about AdClicks you can turn this off.
		";
		
$GLOBALS['phpAds_hlp_block_adclicks'] = "
		If a visitor clicks multiple times on a banner an AdClick will be logged by ".$phpAds_productname." 
		every time. This feature is used to make sure that only one AdClick is logged for each 
		unique banner for the number of seconds you specify. For example: if you set this value 
		to 300 seconds, ".$phpAds_productname." will only log AdClicks if the visitor didnďż˝t click on the same 
		banner in the last 5 minutes. This feature only works when the browser accepts cookies.
		";
		
$GLOBALS['phpAds_hlp_reverse_lookup'] = "
        ".$phpAds_productname." logs the IP address of each visitor by default. If you want 
        ".$phpAds_productname." to log domain names you should turn this on. Reverse lookup 
        does take some time; it will slow everything down.
		";
		
$GLOBALS['phpAds_hlp_proxy_lookup'] = "
		Some users are using a proxy server to access the internet. In that case 
		".$phpAds_productname." will log the IP address or the hostname of the proxy server 
		instead of the user. If you enable this feature ".$phpAds_productname." will try to 
		find the ip address or hostname of the user behind the proxy server. 
		If it is not possible to find the exact address of the user it will use 
		the address of the proxy server instead. This option is not enable by default, 
		because it will slow logging down.
		";
		
$GLOBALS['phpAds_hlp_ignore_hosts'] = "
        If you don't want to count clicks and views from certain computer you 
        can add these to this array. If you have enabled reverse lookup you can 
        add both domain names and IP addresses, otherwise you can only use IP 
        addresses. You can also use wildcards (i.e. '*.altavista.com' or '192.168.*').
		";
		
$GLOBALS['phpAds_hlp_begin_of_week'] = "
        For most people a week starts on a Monday, but if you want to start each 
        week on a Sunday you can.
		";
		
$GLOBALS['phpAds_hlp_percentage_decimals'] = "
        Specifies how many decimal places to display on statistics pages.
		";
		
$GLOBALS['phpAds_hlp_warn_admin'] = "
        ".$phpAds_productname." can sent you e-mail if a campaign has only a limited number of 
        clicks or views left. This is turned on by default.
		";
		
$GLOBALS['phpAds_hlp_warn_client'] = "
        ".$phpAds_productname." can sent the advertiser e-mail if one of his campaigns has only a 
		limited number of clicks or views left. This is turned on by default.
		";
		
$GLOBALS['phpAds_hlp_qmail_patch'] = "
		Some versions of qmail are affected by a bug, which causes e-mail sent by 
		".$phpAds_productname." to show the headers inside the body of the e-mail. If you enable 
		this setting, ".$phpAds_productname." will send e-mail in a qmail compatible format.
		";
		
$GLOBALS['phpAds_hlp_warn_limit'] = "
        The limit on which ".$phpAds_productname." starts sending warning e-mails. This is 100 
        by default.
		";
		
$GLOBALS['phpAds_hlp_allow_invocation_plain'] = 
$GLOBALS['phpAds_hlp_allow_invocation_js'] = 
$GLOBALS['phpAds_hlp_allow_invocation_frame'] = 
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] = 
$GLOBALS['phpAds_hlp_allow_invocation_local'] = 
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] = 
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "
		These settings allows you to control which invocation types are allowed.
		If one of these invocation types are disabled they will not be available
		in the invocationcode / bannercode generator. Important: the invocation methods
		will still work if disabled, but they are not available for generation.
		";
		
$GLOBALS['phpAds_hlp_con_key'] = "
        ".$phpAds_productname." includes a powerful retrieval system using direct selection. 
		For more information, please read the user guide. With this option, you 
		can activate conditional keywords. This is turned on by default.
		";
		
$GLOBALS['phpAds_hlp_mult_key'] = "
        If you are using direct selection to display banners, you can specify one 
		or more keywords for each banner. This option needs to be enabled if you want 
		to specify more than one keyword. This is turned on by default.
		";
		
$GLOBALS['phpAds_hlp_acl'] = "
        If you are not using delivery limitations you can disable this option with this parameter, 
        this will speed up ".$phpAds_productname." a bit.
		";
		
$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = "
        If ".$phpAds_productname." can't connect to the database server, or can't find any matching 
        banners at all, for example when the database crashed or was deleted, 
        it won't display anything. Some users may want to specify a default banner, 
        which will be displayed in these situations. The default banner specified 
        here will not be logged and won't be used if there are still active banners 
        left in the database. This is turned off by default.
		";
		
$GLOBALS['phpAds_hlp_zone_cache'] = "
        If you are using zones this setting allows ".$phpAds_productname." to store the banner 
        information inside a cache which will be used later on. The will speed 
        up ".$phpAds_productname." a bit, because instead of retrieving the zone information 
        and retrieving the banner information and selecting the right banner, 
        ".$phpAds_productname." only needs to load the cache. This feature is turned on by default.
		";
		
$GLOBALS['phpAds_hlp_zone_cache_limit'] = "
        If you are using cached zones, the information inside the cache can become 
        outdated. Once in a while ".$phpAds_productname." needs to rebuild the cache, so new 
        banners will be included in the cache. This setting lets you decide when 
        a cached zone will be reloaded, by specifing the maximum lifetime of the 
        cached zone. For example: if you set this setting to 600, the cache will 
        be rebuild if the cached zone is older than 10 minutes (600 seconds).
		";
		
$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = 
$GLOBALS['phpAds_hlp_type_txt_allow'] = "
        ".$phpAds_productname." can use different types of banners and store them in different 
        ways. The first two options are used for local storage of banners. You 
        can use the admin interface to upload a banner and ".$phpAds_productname." will store 
        the banner in the SQL database or on a web server. You can also use a banner 
		stored on an external web server or use HTML to generate a banner.
		";
		
$GLOBALS['phpAds_hlp_type_web_mode'] = "
        If you want to use banners stored on the web server, you need to configure 
        this setting. If you want to store the banners in a local directory set 
        this option to <i>Local directory</i>. If you want to store the banner on an 
		external FTP server set this option to <i>External FTP server</i>. On certain 
		web servers you may want to use the FTP option even on the local web server.
		";
		
$GLOBALS['phpAds_hlp_type_web_dir'] = "
        Specify the directory where ".$phpAds_productname." needs to copy the uploaded banners 
        to. This directory needs to be writable by PHP, this could mean you need 
        to modify the UNIX permissions for this directory (chmod). The directory 
        you specify here needs to be in the web server' document root, the web 
        server must be able to serve the files directly. Do not specify a trailing 
        slash (/). You only need to configure this option if you have set the storing
		method to <i>Local directory</i>.
		";
		
$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "
		If you set the storing method to <i>External FTP server</i> you need to
        specify the IP address or domain name of the FTP server where ".$phpAds_productname." needs 
		to copy the uploaded banners to.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "
		If you set the storing method to <i>External FTP server</i> you need to
        specify the directory on the external FTP server where ".$phpAds_productname." needs 
		to copy the uploaded banners to.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "
		If you set the storing method to <i>External FTP server</i> you need to
        specify the username which ".$phpAds_productname." must use in order to connect to the
		external FTP server.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "
		If you set the storing method to <i>External FTP server</i> you need to
        specify the password which ".$phpAds_productname." must use in order to connect to the
		external FTP server.
		";
      
$GLOBALS['phpAds_hlp_type_web_url'] = "
        If you store banners on a web server, ".$phpAds_productname." needs to know which public 
        URL corresponds with the directory you specified below. Do not specify 
        a trailing slash (/).
		";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "
        If this option is turned on ".$phpAds_productname." will automatically alter HTML banners 
        in order to allow the clicks to be logged. However even if this option 
        is turned it will be possible to disable this feature on a per banner 
        basis. 
		";
		
$GLOBALS['phpAds_hlp_type_html_php'] = "
        It is possible to let ".$phpAds_productname." execute PHP code embedded inside HTML 
        banners. This feature is turned off by default.
		";
		
$GLOBALS['phpAds_hlp_admin'] = "
        The administrator username, you can specify the username that you can 
        use to log into the administrator interface.
		";
		
$GLOBALS['phpAds_hlp_pwold'] = 
$GLOBALS['phpAds_hlp_pw'] = 
$GLOBALS['phpAds_hlp_pw2'] = "
        To change the administrator password, you can need to specify the old
		password above. Also you need to specify the new password twice, to
		prevent typing errors.
		";
		
$GLOBALS['phpAds_hlp_admin_fullname'] = "
        Specify the administrator's full name. This used when sending statistics 
        via email.
		";
		
$GLOBALS['phpAds_hlp_admin_email'] = "
        The administrator's e-mail address. This is used as from-address when 
        sending statistics via email.
		";
		
$GLOBALS['phpAds_hlp_admin_email_headers'] = "
        You can alter the e-mail headers used by the e-mails which ".$phpAds_productname." sends.
		";
		
$GLOBALS['phpAds_hlp_admin_novice'] = "
        If you want to recieve a warning before deleting advertisers, campaigns or 
        banners; set this option to true.
		";
		
$GLOBALS['phpAds_hlp_client_welcome'] = 
$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
       If you turn this feature on a welcome message will be displayed on the 
        first page an advertiser will see after logging in. You can personalize this 
        message by editing the 'welcome.html' file location in the 'admin/templates' 
        directory. Things you might want to include are for example: Your company 
        name, contact information, your company logo, a link a page with advertising 
        rates, etc..
		";
		
$GLOBALS['phpAds_hlp_updates_frequency'] = "
		If you want to check for new versions of ".$phpAds_productname." you can enable this feature. 
		It is possible the specify the interval in which ".$phpAds_productname." makes a connection to 
		the update server. If a new version is found a dialog box will pop up with additional 
		information about the update.
		";
		
$GLOBALS['phpAds_hlp_userlog_email'] = "
		If you want to keep a copy of all outgoing e-mail messages send by ".$phpAds_productname." you 
		can enable this feature. The e-mail messages are stored in the userlog.
		";
		
$GLOBALS['phpAds_hlp_userlog_priority'] = "
		To ensure the priority calculation ran correct, you can save a report about 
		the hourly calculation. This report includes the predicted profile and how much 
		priority is assigned to all banners. This information might be useful if you 
		want to submit a bugreport about the priority calculations. The reports are 
		stored inside the userlog.
		";
		
$GLOBALS['phpAds_hlp_default_banner_weight'] = "
		If you want to use a higher default banner weight you can specify the desired weight here. 
		This settings is 1 by default.
		";
		
$GLOBALS['phpAds_hlp_default_campaign_weight'] = "
		If you want to use a higher default campaign weight you can specify the desired weight here. 
		This settings is 1 by default.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "
		If this option is enabled extra information about each campain will be shown on the 
		<i>Campaigns</i> page. The extra information includes the number of AdViews remaining, 
		the number of AdClicks remaining, activation date, expiration date and the priority settings.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
		If this option is enabled extra information about each banner will be shown on the 
		<i>Banner overview</i> page. The extra information includes the destination URL, keywords, 
		size and the banner weight.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
		If this option is enabled a preview of all banners will be shown on the <i>Banner overview</i> 
		page. If this option is disabled it is still possible to show a preview of each banner by click 
		on the triangle next to each banner on the <i>Banner overview</i> page.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "
		If this option is enabled the actual HTML banner will be shown instead of the HTML code. This 
		option is disabled by default, because the HTML banners might conflict with the user interface. 
		If this option is disabled it is still possible to view the actual HTML banner, by clicking on 
		the <i>Show banner</i> button next to the HTML code.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "
		If this option is enabled a preview will be shown at the top of the <i>Banner properties</i>, 
		<i>Delivery option</i> and <i>Linked zones</i> pages. If this option is disabled it is still 
		possible to view the banner, by clicking on the <i>Show banner</i> button at the top of the pages.
		";
		
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "
		If this option is enabled all inactive banners, campaigns and advertisers will be hidden from the
		<i>Advertisers & Campaigns</i> and <i>Campaigns</i> pages. If this option is enabled it is
		still possible to view the hidden items, by clicking on the <i>Show all</i> button on the bottom
		of the page.
		";
		
?>