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
$GLOBALS['phpAds_hlp_dbhost'] = "\n        Specify the hostname of the ".$phpAds_dbmsname." database server.\n		";
		
$GLOBALS['phpAds_hlp_dbuser'] = "\n        Specify the username which ".$phpAds_productname." must use to gain access to the ".$phpAds_dbmsname." database server.\n		";
		
$GLOBALS['phpAds_hlp_dbpassword'] = "\n        Specify the password which ".$phpAds_productname." must use to gain access to the ".$phpAds_dbmsname." database server.\n		";
		
$GLOBALS['phpAds_hlp_dbname'] = "\n        Specify the name of the database where ".$phpAds_productname." must store its data.\n		";
		
$GLOBALS['phpAds_hlp_persistent_connections'] = "\n        The use of persistent connection can speed up ".$phpAds_productname." considerably \n		and may even decrease the load on the server. There is a drawback however, on sites with \n		a lot of visitors the load on the server can increase and become larger then when using normal \n		connections. Whether you should use regular connections or persistant connections depends on the \n		number of visitors and the hardware your are using. If ".$phpAds_productname." is using too many resources, \n		you should take a look at this setting first.\n		";
		
$GLOBALS['phpAds_hlp_compatibility_mode'] = "\n        If you are having problem integrating ".$phpAds_productname." with another thirth-party product it \n		might help to turn on the database compatibility mode. If you are using local mode \n		invocation and the database compatibility is turned on ".$phpAds_productname." should leave \n		the state of the database connection exectly the same as it was before ".$phpAds_productname." ran. \n		This option is a bit slower (only slightly) and therefore turned off by default.\n		";
		
$GLOBALS['phpAds_hlp_table_prefix'] = "\n        If the database ".$phpAds_productname." is using is shared by mutiple software products, it is wise\n		to add a prefix to names of the tables. If you are using multiple installations of ".$phpAds_productname."\n		in the same database, you need to make sure this prefix is unique for all installations.\n		";
		
$GLOBALS['phpAds_hlp_tabletype'] = "\n        ".$phpAds_dbmsname." supports multiple table types. Each type of table has unique properties and some\n		can speed up ".$phpAds_productname." considerable. MyISAM is the default table type and is available\n		in all installations of ".$phpAds_dbmsname.". Other table types may not be available on your server\n		";
		
$GLOBALS['phpAds_hlp_url_prefix'] = "\n        ".$phpAds_productname." needs to know where it is located on the web server in order \n        to work correctly. You must specify the URL to the directory where ".$phpAds_productname." \n        is installed, for example: http://www.your-url.com/".$phpAds_productname.".\n		";
		
$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "\n        You should put here the path to the header files (e.g.: /home/login/www/header.htm) \n        to have a header and/or footer on each page in the admin interface. You \n        can put either text or html in these files (if you want to use html in \n        one or both of these files do not use tags like <body> or <html>).\n		";
		
$GLOBALS['phpAds_hlp_content_gzip_compression'] = "\n		By enabling GZIP content compression you will get a big decrease of the data which \n		is sent to the browser each time a page of the administrator interface is opened. \n		To enable this feature you need to have at least PHP 4.0.5 with the GZIP extention installed.\n		";
		
$GLOBALS['phpAds_hlp_language'] = "\n        Specify the default language ".$phpAds_productname." should use. This language will \n        be used as a default for the admin and advertiser interface. Please note: \n        you can set a different language for each advertiser from the admin interface \n        and allow advertisers to change their language themselves.\n		";
		
$GLOBALS['phpAds_hlp_name'] = "\n        Specify the name you want to use for this application. This string will \n        be displayed on all pages in the admin and advertiser interface. If you leave \n        this setting empty (default) a logo of ".$phpAds_productname." will be displayed instead.\n		";
		
$GLOBALS['phpAds_hlp_company_name'] = "Ta nazwa używana jest w e-mailu wysyłanym przez ". MAX_PRODUCT_NAME .".";
		
$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "\n        ".$phpAds_productname." usually detects if the GD library is installed and which image \n        format is supported by the installed version of GD. However it is possible \n        the detection is not accurate or false, some versions of PHP do not allow \n        the detection of the supported image formats. If ".$phpAds_productname." fails to auto-detect \n        the right image format you can specify the right image format. Possible \n        values are: none, png, jpeg, gif.\n		";
		
$GLOBALS['phpAds_hlp_p3p_policies'] = "\n        If you want to enable ".$phpAds_productname."' P3P Privacy Policies you must turn this \n        option on. \n		";
		
$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "\n        The compact policy which is sent together with cookies. The default setting \n        is: 'CUR ADM OUR NOR STA NID', which will allow Internet Explorer 6 to \n        accept the cookies used by ".$phpAds_productname.". If you want you can alter these \n        settings to match your own privacy statement.\n		";
		
$GLOBALS['phpAds_hlp_p3p_policy_location'] = "\n        If you want to use a full privacy policy, you can specify the location \n        of the policy.\n		";
		
$GLOBALS['phpAds_hlp_compact_stats'] = "\n        Traditionally ".$phpAds_productname." used rather extensive logging, which was very \n        detailed but was also very demanding on the database server. This could \n        be a big problem on sites with a lot of visitors. To overcome this problem\n		".$phpAds_productname." also supports a new kind of statistics, the compact statistics, \n		which is less demanding on the database server, but also less detailed. \n		The compact statistics only logs daily statistics, if you need hourly statistics \n		you can turn the compact statistics off.\n		";
		
$GLOBALS['phpAds_hlp_log_adviews'] = "\n        Normally all AdViews are logged, if you don't want to gather statistics \n        about AdViews you can turn this off.\n		";
		
$GLOBALS['phpAds_hlp_block_adviews'] = "\n		If a visitor reloads a page an AdView will be logged by ".$phpAds_productname." every time. \n		This feature is used to make sure that only one AdView is logged for each unique \n		banner for the number of seconds you specify. For example: if you set this value \n		to 300 seconds, ".$phpAds_productname." will only log AdViews if the same banner isnďż˝t already \n		shown to the same visitor in the last 5 minutes. This feature only works when <i>Use \n		beacons to log AdViews</i> is enabled and if the browser accepts cookies.\n		";
		
$GLOBALS['phpAds_hlp_log_adclicks'] = "\n        Normally all AdClicks are logged, if you don't want to gather statistics \n        about AdClicks you can turn this off.\n		";
		
$GLOBALS['phpAds_hlp_block_adclicks'] = "\n		If a visitor clicks multiple times on a banner an AdClick will be logged by ".$phpAds_productname." \n		every time. This feature is used to make sure that only one AdClick is logged for each \n		unique banner for the number of seconds you specify. For example: if you set this value \n		to 300 seconds, ".$phpAds_productname." will only log AdClicks if the visitor didnďż˝t click on the same \n		banner in the last 5 minutes. This feature only works when the browser accepts cookies.\n		";
		
$GLOBALS['phpAds_hlp_reverse_lookup'] = "\n        ".$phpAds_productname." logs the IP address of each visitor by default. If you want \n        ".$phpAds_productname." to log domain names you should turn this on. Reverse lookup \n        does take some time; it will slow everything down.\n		";
		
$GLOBALS['phpAds_hlp_proxy_lookup'] = "\n		Some users are using a proxy server to access the internet. In that case \n		".$phpAds_productname." will log the IP address or the hostname of the proxy server \n		instead of the user. If you enable this feature ".$phpAds_productname." will try to \n		find the ip address or hostname of the user behind the proxy server. \n		If it is not possible to find the exact address of the user it will use \n		the address of the proxy server instead. This option is not enable by default, \n		because it will slow logging down.\n		";
		
$GLOBALS['phpAds_hlp_ignore_hosts'] = "\n        If you don't want to count clicks and views from certain computer you \n        can add these to this array. If you have enabled reverse lookup you can \n        add both domain names and IP addresses, otherwise you can only use IP \n        addresses. You can also use wildcards (i.e. '*.altavista.com' or '192.168.*').\n		";
		
$GLOBALS['phpAds_hlp_begin_of_week'] = "\n        For most people a week starts on a Monday, but if you want to start each \n        week on a Sunday you can.\n		";
		
$GLOBALS['phpAds_hlp_percentage_decimals'] = "\n        Specifies how many decimal places to display on statistics pages.\n		";
		
$GLOBALS['phpAds_hlp_warn_admin'] = "\n        ".$phpAds_productname." can sent you e-mail if a campaign has only a limited number of \n        clicks or views left. This is turned on by default.\n		";
		
$GLOBALS['phpAds_hlp_warn_client'] = "". MAX_PRODUCT_NAME ." może wysłać e-mail do reklamodawcy, jeśli jedna z jego kampanii ma tylko";
		
$GLOBALS['phpAds_hlp_qmail_patch'] = "tNiektóre wersje qmail zawierają błędy, które sprawiają, że w treści e-maila wysłanego przez \n". MAX_PRODUCT_NAME ." widnieje nagłówek. Jeśli uaktywnisz \nto ustawienie, ". MAX_PRODUCT_NAME ." wyśle e-mail w formacie kompatybilnym z qmail.";
		
$GLOBALS['phpAds_hlp_warn_limit'] = "Limit, od którego ". MAX_PRODUCT_NAME ." zaczyna wysyłać e-maile z ostrzeżeniem. Domyślnie 100";
		
$GLOBALS['phpAds_hlp_allow_invocation_plain'] = 
$GLOBALS['phpAds_hlp_allow_invocation_js'] = 
$GLOBALS['phpAds_hlp_allow_invocation_frame'] = 
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] = 
$GLOBALS['phpAds_hlp_allow_invocation_local'] = 
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] = 
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "\n		These settings allows you to control which invocation types are allowed.\n		If one of these invocation types are disabled they will not be available\n		in the invocationcode / bannercode generator. Important: the invocation methods\n		will still work if disabled, but they are not available for generation.\n		";
		
$GLOBALS['phpAds_hlp_con_key'] = "\n        ".$phpAds_productname." includes a powerful retrieval system using direct selection. \n		For more information, please read the user guide. With this option, you \n		can activate conditional keywords. This is turned on by default.\n		";
		
$GLOBALS['phpAds_hlp_mult_key'] = "\n        If you are using direct selection to display banners, you can specify one \n		or more keywords for each banner. This option needs to be enabled if you want \n		to specify more than one keyword. This is turned on by default.\n		";
		
$GLOBALS['phpAds_hlp_acl'] = "\n        If you are not using delivery limitations you can disable this option with this parameter, \n        this will speed up ".$phpAds_productname." a bit.\n		";
		
$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = "\n        If ".$phpAds_productname." can't connect to the database server, or can't find any matching \n        banners at all, for example when the database crashed or was deleted, \n        it won't display anything. Some users may want to specify a default banner, \n        which will be displayed in these situations. The default banner specified \n        here will not be logged and won't be used if there are still active banners \n        left in the database. This is turned off by default.\n		";
		
$GLOBALS['phpAds_hlp_zone_cache'] = "\n        If you are using zones this setting allows ".$phpAds_productname." to store the banner \n        information inside a cache which will be used later on. The will speed \n        up ".$phpAds_productname." a bit, because instead of retrieving the zone information \n        and retrieving the banner information and selecting the right banner, \n        ".$phpAds_productname." only needs to load the cache. This feature is turned on by default.\n		";
		
$GLOBALS['phpAds_hlp_zone_cache_limit'] = "\n        If you are using cached zones, the information inside the cache can become \n        outdated. Once in a while ".$phpAds_productname." needs to rebuild the cache, so new \n        banners will be included in the cache. This setting lets you decide when \n        a cached zone will be reloaded, by specifing the maximum lifetime of the \n        cached zone. For example: if you set this setting to 600, the cache will \n        be rebuild if the cached zone is older than 10 minutes (600 seconds).\n		";
		
$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = 
$GLOBALS['phpAds_hlp_type_txt_allow'] = "\n        ".$phpAds_productname." can use different types of banners and store them in different \n        ways. The first two options are used for local storage of banners. You \n        can use the admin interface to upload a banner and ".$phpAds_productname." will store \n        the banner in the SQL database or on a web server. You can also use a banner \n		stored on an external web server or use HTML to generate a banner.\n		";
		
$GLOBALS['phpAds_hlp_type_web_mode'] = "\n        If you want to use banners stored on the web server, you need to configure \n        this setting. If you want to store the banners in a local directory set \n        this option to <i>Local directory</i>. If you want to store the banner on an \n		external FTP server set this option to <i>External FTP server</i>. On certain \n		web servers you may want to use the FTP option even on the local web server.\n		";
		
$GLOBALS['phpAds_hlp_type_web_dir'] = "\n        Specify the directory where ".$phpAds_productname." needs to copy the uploaded banners \n        to. This directory needs to be writable by PHP, this could mean you need \n        to modify the UNIX permissions for this directory (chmod). The directory \n        you specify here needs to be in the web server' document root, the web \n        server must be able to serve the files directly. Do not specify a trailing \n        slash (/). You only need to configure this option if you have set the storing\n		method to <i>Local directory</i>.\n		";
		
$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "\n		If you set the storing method to <i>External FTP server</i> you need to\n        specify the IP address or domain name of the FTP server where ".$phpAds_productname." needs \n		to copy the uploaded banners to.\n		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "\n		If you set the storing method to <i>External FTP server</i> you need to\n        specify the directory on the external FTP server where ".$phpAds_productname." needs \n		to copy the uploaded banners to.\n		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "\n		If you set the storing method to <i>External FTP server</i> you need to\n        specify the username which ".$phpAds_productname." must use in order to connect to the\n		external FTP server.\n		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "\n		If you set the storing method to <i>External FTP server</i> you need to\n        specify the password which ".$phpAds_productname." must use in order to connect to the\n		external FTP server.\n		";
      
$GLOBALS['phpAds_hlp_type_web_url'] = "\n        If you store banners on a web server, ".$phpAds_productname." needs to know which public \n        URL corresponds with the directory you specified below. Do not specify \n        a trailing slash (/).\n		";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "\n        If this option is turned on ".$phpAds_productname." will automatically alter HTML banners \n        in order to allow the clicks to be logged. However even if this option \n        is turned it will be possible to disable this feature on a per banner \n        basis. \n		";
		
$GLOBALS['phpAds_hlp_type_html_php'] = "\n        It is possible to let ".$phpAds_productname." execute PHP code embedded inside HTML \n        banners. This feature is turned off by default.\n		";
		
$GLOBALS['phpAds_hlp_admin'] = "\n        The administrator username, you can specify the username that you can \n        use to log into the administrator interface.\n		";
		
$GLOBALS['phpAds_hlp_pwold'] = 
$GLOBALS['phpAds_hlp_pw'] = 
$GLOBALS['phpAds_hlp_pw2'] = "\n        To change the administrator password, you can need to specify the old\n		password above. Also you need to specify the new password twice, to\n		prevent typing errors.\n		";
		
$GLOBALS['phpAds_hlp_admin_fullname'] = "\n        Specify the administrator's full name. This used when sending statistics \n        via email.\n		";
		
$GLOBALS['phpAds_hlp_admin_email'] = "Adres administratora. Jest używany w formularzu, gdy";
		
$GLOBALS['phpAds_hlp_admin_email_headers'] = "\n        You can alter the e-mail headers used by the e-mails which ".$phpAds_productname." sends.\n		";
		
$GLOBALS['phpAds_hlp_admin_novice'] = "Jeśli chcesz otrzymywać ostrzeżenia przed usunięciem reklamodawców, kampanii, banerów, wydawców i stref, potwierdź tutaj.";
		
$GLOBALS['phpAds_hlp_client_welcome'] = 
$GLOBALS['phpAds_hlp_client_welcome_msg'] = "\n       If you turn this feature on a welcome message will be displayed on the \n        first page an advertiser will see after logging in. You can personalize this \n        message by editing the 'welcome.html' file location in the 'admin/templates' \n        directory. Things you might want to include are for example: Your company \n        name, contact information, your company logo, a link a page with advertising \n        rates, etc..\n		";
		
$GLOBALS['phpAds_hlp_updates_frequency'] = "\n		If you want to check for new versions of ".$phpAds_productname." you can enable this feature. \n		It is possible the specify the interval in which ".$phpAds_productname." makes a connection to \n		the update server. If a new version is found a dialog box will pop up with additional \n		information about the update.\n		";
		
$GLOBALS['phpAds_hlp_userlog_email'] = "\n		If you want to keep a copy of all outgoing e-mail messages send by ".$phpAds_productname." you \n		can enable this feature. The e-mail messages are stored in the userlog.\n		";
		
$GLOBALS['phpAds_hlp_userlog_priority'] = "\n		To ensure the priority calculation ran correct, you can save a report about \n		the hourly calculation. This report includes the predicted profile and how much \n		priority is assigned to all banners. This information might be useful if you \n		want to submit a bugreport about the priority calculations. The reports are \n		stored inside the userlog.\n		";
		
$GLOBALS['phpAds_hlp_default_banner_weight'] = "\n		If you want to use a higher default banner weight you can specify the desired weight here. \n		This settings is 1 by default.\n		";
		
$GLOBALS['phpAds_hlp_default_campaign_weight'] = "\n		If you want to use a higher default campaign weight you can specify the desired weight here. \n		This settings is 1 by default.\n		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "Jeśli ta opcja jest włączona dodatkowe informacje na temat każdej kampanii będą wyświetlane na stronie <i>Kampanie</i>. Dodatkowe informacje zawierają liczbę pozostałych wyświetleń reklam (AdViews), liczbę pozostałych kliknięć (AdClicks), liczbę pozostałych konwersji (AdConversions), daty aktywacji, datę ważności i pierwszeństwa ustawień.";
		
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "Jeśli ta opcja jest włączona, na stronie <i>Banery</i> będą wyświetlane dodatkowe informacje na temat każdego banera . Dodatkowe informacje zawierają docelowy adres URL, słowa kluczowe, rozmiar i wagę banera.";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "Jeśli ta opcja jest włączona podgląd wszystkich banerów będzie dostępny na stronie <i>Banery</i>. Jeśli opcja ta jest wyłączona wciąż można pokazać podgląd każdego banera przez kliknięcie w trójkąt obok każdego z banerów na stronie <i>Banery</i>.";
		
$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "\n		If this option is enabled the actual HTML banner will be shown instead of the HTML code. This \n		option is disabled by default, because the HTML banners might conflict with the user interface. \n		If this option is disabled it is still possible to view the actual HTML banner, by clicking on \n		the <i>Show banner</i> button next to the HTML code.\n		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "\n		If this option is enabled a preview will be shown at the top of the <i>Banner properties</i>, \n		<i>Delivery option</i> and <i>Linked zones</i> pages. If this option is disabled it is still \n		possible to view the banner, by clicking on the <i>Show banner</i> button at the top of the pages.\n		";
		
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "Jeśli ta opcja jest włączona wszystkie banery nieaktywne, kampanie i reklamodawcy będą widoczni na stronach <i>Reklamodawcy i Kampanie</i> i <i>Kampanie</i>. Jeśli ta opcja jest włączona, można wyświetlić ukryte elementy klikając na przycisk <i>Pokaż wszystkie</i> na dole strony.";
		
?>