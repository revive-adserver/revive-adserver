<?php // $Id: $

/************************************************************************/
/* phpPgAds                                                             */
/* ========                                                             */
/*                                                                      */
/* Copyright (c) 2001 by the phpPgAds developers                        */
/* http://sourceforge.net/projects/phppgads                             */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Settings help translation strings
$GLOBALS['phpAds_hlp_dbhost'] = "
        Specify the hostname of the PostgreSQL database server.
		";
		
$GLOBALS['phpAds_hlp_dbuser'] = "
        Specify the username which phpAdsNew must use to gain access to the PostgreSQL database server.
		";
		
$GLOBALS['phpAds_hlp_dbpassword'] = "
        Specify the password which phpAdsNew must use to gain access to the PostgreSQL database server.
		";
		
$GLOBALS['phpAds_hlp_dbname'] = "
        Specify the name of the database where phpAdsNew must store its data.
		";
		
$GLOBALS['phpAds_hlp_persistent_connections'] = "
        The use of persistent connection can speed up phpAdsNew considerably 
		and may even decrease the load on the server. There is a drawback however, on sites with 
		a lot of visitors the load on the server can increase and become larger then when using normal 
		connections. Whether you should use regular connections or persistant connections depends on the 
		number of visitors and the hardware your are using. If phpAdsNew is using too many resources, 
		you should take a look at this setting first.
		";
		
$GLOBALS['phpAds_hlp_insert_delayed'] = "
        PostgreSQL locks the table when it is inserting data. If have many visitors to your site, 
		it could be possible phpAdsNew must wait before inserting a new row, because the database 
		is still locked. When you use insert delayed, you don't have to wait and the row will 
		be inserted at a later time when the table is not in use by any other thread. 
		";
		
$GLOBALS['phpAds_hlp_tbl_prefix'] = "
        If the database phpAdsNew is using is shared by mutiple software products, it is wise
		to add a prefix to names of the tables. If you are using multiple installations of phpAdsNew
		in the same database, you need to make sure this prefix is unique for all installations.
		";
		
$GLOBALS['phpAds_hlp_tabletype'] = "
        PostgreSQL supports multiple table types. Each type of table has unique properties and some
		can speed up phpAdsNew considerable. MyISAM is the default table type and is available
		in all installations of PostgreSQL. Other table types may not be available on your server
		";
		
$GLOBALS['phpAds_hlp_url_prefix'] = "
        phpAdsNew needs to know where it is located on the web server in order 
        to work correctly. You must specify the URL to the directory where phpAdsNew 
        is installed, for example: http://www.your-url.com/phpAdsNew.
		";
		
$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
        You should put here the path to the header files (e.g.: /home/login/www/header.htm) 
        to have a header and/or footer on each page in the admin interface. You 
        can put either text or html in these files (if you want to use html in 
        one or both of these files do not use tags like <body> or <html>).
		";
		
$GLOBALS['phpAds_hlp_language'] = "
        Specify the default language phpAdsNew should use. This language will 
        be used as a default for the admin and client interface. Please note: 
        you can set a different language for each client from the admin interface 
        and allow clients to change their language themselves.
		";
		
$GLOBALS['phpAds_hlp_name'] = "
        Specify the name you want to use for this application. This string will 
        be displayed on all pages in the admin and client interface. If you leave 
        this setting empty (default) a logo of phpAdsNew will be displayed instead.
		";
		
$GLOBALS['phpAds_hlp_company_name'] = "
        This name is used in the e-mail sent by phpAdsNew.
		";
		
$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
        phpAdsNew usually detects if the GD library is installed and which image 
        format is supported by the installed version of GD. However it is possible 
        the detection is not accurate or false, some versions of PHP do not allow 
        the detection of the supported image formats. If phpAdsNew fails to auto-detect 
        the right image format you can specify the right image format. Possible 
        values are: none, png, jpeg, gif.
		";
		
$GLOBALS['phpAds_hlp_p3p_policies'] = "
        If you want to enable phpAdsNew' P3P Privacy Policies you must turn this 
        option on. 
		";
		
$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
        The compact policy which is sent together with cookies. The default setting 
        is: 'CUR ADM OUR NOR STA NID', which will allow Internet Explorer 6 to 
        accept the cookies used by phpAdsNew. If you want you can alter these 
        settings to match your own privacy statement.
		";
		
$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
        If you want to use a full privacy policy, you can specify the location 
        of the policy.
		";
		
$GLOBALS['phpAds_hlp_compact_stats'] = "
        Traditionally phpAdsNew used rather extensive logging, which was very 
        detailed but was also very demanding on the database server. This could 
        be a big problem on sites with a lot of visitors. To overcome this problem
		phpAdsNew also supports a new kind of statistics, the compact statistics, 
		which is less demanding on the database server, but also less detailed. 
		The compact statistics only logs daily statistics, if you need hourly statistics 
		you can turn the compact statistics off.
		";
		
$GLOBALS['phpAds_hlp_log_adviews'] = "
        Normally all AdViews are logged, if you don't want to gather statistics 
        about AdViews you can turn this off.
		";
		
$GLOBALS['phpAds_hlp_log_adclicks'] = "
        Normally all AdClicks are logged, if you don't want to gather statistics 
        about AdClicks you can turn this off.
		";
		
$GLOBALS['phpAds_hlp_reverse_lookup'] = "
        phpAdsNew logs the IP address of each visitor by default. If you want 
        phpAdsNew to log domain names you should turn this on. Reverse lookup 
        does take some time; it will slow everything down.
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
        phpAdsNew can sent you e-mail if a client has only a limited number of 
        clicks or views left. This is turned on by default.
		";
		
$GLOBALS['phpAds_hlp_warn_client'] = "
        phpAdsNew can sent the client e-mail if he has only a limited number of 
        clicks or views left. This is turned on by default.
		";
		
$GLOBALS['phpAds_hlp_warn_limit'] = "
        The limit on which phpAdsNew starts sending warning e-mails. This is 100 
        by default.
		";
		
$GLOBALS['phpAds_hlp_random_retrieve'] = "
        phpAdsNew can use four different types of banner retrieval: Random banner 
        retrieval (default), Normal sequential banner retrieval, Weight 
        based sequential banner retrieval and Full sequential banner retrieval.
      	If you are using Zones, phpAdsNew will always use random banner retrieval 
        and this setting will be ignored.
		";
		
$GLOBALS['phpAds_hlp_con_key'] = "
        phpAdsNew includes a powerful banner retrieval system. For more information, 
        please read the API section. With this option, you can activate conditional 
        keywords. This is turned on by default.
		";
		
$GLOBALS['phpAds_hlp_mult_key'] = "
        For each banner, you can specify one or more keywords. This option is 
        needed if you want to specify more than one keyword. This is turned on 
        by default.
		";
		
$GLOBALS['phpAds_hlp_acl'] = "
        If you are not using display limitations you can disable ACL checking with this parameter, 
        this will speed up phpAdsNew.
		";
		
$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = "
        If phpAdsNew can't connect to the database server, or can't find any matching 
        banners at all, for example when the database crashed or was deleted, 
        it won't display anything. Some users may want to specify a default banner, 
        which will be displayed in these situations. The default banner specified 
        here will not be logged and won't be used if there are still active banners 
        left in the database. This is turned off by default.
		";
		
$GLOBALS['phpAds_hlp_zone_cache'] = "
        If you are using zones this setting allows phpAdsNew to store the banner 
        information inside a cache which will be used later on. The will speed 
        up phpAdsNew a bit, because instead of retrieving the zone information 
        and retrieving the banner information and selecting the right banner, 
        phpAdsNew only needs to load the cache. This feature is turned on by default.
		";
		
$GLOBALS['phpAds_hlp_zone_cache_limit'] = "
        If you are using cached zones, the information inside the cache can become 
        outdated. Once in a while phpAdsNew needs to rebuild the cache, so new 
        banners will be included in the cache. This setting lets you decide when 
        a cached zone will be reloaded, by specifing the maximum lifetime of the 
        cached zone. For example: if you set this setting to 600, the cache will 
        be rebuild if the cached zone is older than 10 minutes (600 seconds).
		";
		
$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = "
        phpAdsNew can use different types of banners and store them in different 
        ways. The first two options are used for local storage of banners. You 
        can use the admin interface to upload a banner and phpAdsNew will store 
        the banner in the SQL database (option 1) or on a web server (option 2). 
        You can also use a banner stored on a different web server (option 3) 
        or use html to generate a banner (option 4). You can disable any one of 
        these types by altering these settings. By default all banner types are 
        turned on.
      	If you disable a certain banner type while there are still banners available 
        of the this type, phpAdsNew will allow the use of these banners, but will 
        not allow the creation of new banners of this type.
		";
		
$GLOBALS['phpAds_hlp_type_web_mode'] = "
        If you want to use banners stored on the web server, you need to configure 
        this setting. If you want to store the banners in a local directory set 
        this option to 0. If you want to store the banner on an external FTP server 
        set this option to 1. On certain web servers you may want to use the FTP 
        option even on the local web server.
		";
		
$GLOBALS['phpAds_hlp_type_web_dir'] = "
        Specify the directory where phpAdsNew needs to copy the uploaded banners 
        to. This directory needs to be writable by PHP, this could mean you need 
        to modify the UNIX permissions for this directory (chmod). The directory 
        you specify here needs to be in the web server' document root, the web 
        server must be able to serve the files directly. Do not specify a trailing 
        slash (/). You only need to configure this option if you have set the store
		method to 'Local mode'.
		";
		
$GLOBALS['phpAds_hlp_type_web_ftp'] = "
        Specify the FTP server where phpAdsNew needs to copy the uploaded banners 
        to. The directory you specify here needs to be in the web server' document 
        root, the web server must be able to serve the files directly. The URL 
        you specify here can include a username, a password, the server name and 
        the path. 
		";
      
$GLOBALS['phpAds_hlp_type_web_url'] = "
        If you store banners on a web server, phpAdsNew needs to know which public 
        URL corresponds with the directory you specified above. Do not specify 
        a trailing slash (/).
		";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "
        If this option is turned on phpAdsNew will automatically alter HTML banners 
        in order to allow the clicks to be logged. However even if this option 
        is turned it will be possible to disable this feature on a per banner 
        basis. 
		";
		
$GLOBALS['phpAds_hlp_type_html_php'] = "
        It is possible to let phpAdsNew execute PHP code embedded inside HTML 
        banners. This feature is turned off by default.
		";
		
$GLOBALS['phpAds_hlp_admin'] = "
        The administrator username, you can specify the username that you can 
        use to log into the administrator interface.
		";
		
$GLOBALS['phpAds_hlp_admin_pw'] = "
        The administrator password, you can specify the password that you can 
        use to log into the administrator interface.
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
        You can alter the e-mail headers used by the e-mails which phpAdsNew sends.
		";
		
$GLOBALS['phpAds_hlp_admin_novice'] = "
        If you want to recieve a warning before deleting clients, campaigns or 
        banners; set this option to true.
		";
		
$GLOBALS['phpAds_hlp_client_welcome'] = 
$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
       If you turn this feature on a welcome message will be displayed on the 
        first page a client will see after loggin in. You can personalize this 
        message by editing the 'welcome.html' file location in the 'admin/templates' 
        directory. Things you might want to include are for example: Your company 
        name, contact information, your company logo, a link a page with advertising 
        rates, etc..
		";
		
?>