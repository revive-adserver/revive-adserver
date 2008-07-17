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
        Specify the hostname of the ".$phpAds_dbmsname." database server to which you are trying to connect.
		";

$GLOBALS['phpAds_hlp_dbport'] = "
        Specify the number of the port of the ".$phpAds_dbmsname." database server to which you are trying to
		connect. The default port number for a ".$phpAds_dbmsname." database is <i>".
		($phpAds_dbmsname == 'MySQL' ? '3306' : '5432')."</i>.
		";

$GLOBALS['phpAds_hlp_dbuser'] = "
        Specify the username which ".$phpAds_productname." must use to gain access to the ".$phpAds_dbmsname." database server.
		";

$GLOBALS['phpAds_hlp_dbpassword'] = "
        Specify the password which ".$phpAds_productname." must use to gain access to the ".$phpAds_dbmsname." database server.
		";

$GLOBALS['phpAds_hlp_dbname'] = "
        Specify the name of the database on the database server where ".$phpAds_productname." must store its data.
		Important the database must already be created on the database server. ".$phpAds_productname." will <b>not</b> create
		this database if it does not exist yet.
		";

$GLOBALS['phpAds_hlp_persistent_connections'] = "
        The use of persistent connection can speed up ".$phpAds_productname." considerably
		and may even decrease the load on the server. There is a drawback however, on sites with
		a lot of visitors the load on the server can increase and become larger then when using normal
		connections. Whether you should use regular connections or persistant connections depends on the
		number of visitors and the hardware your are using. If ".$phpAds_productname." is using too many resources,
		you should take a look at this setting first.
		";

$GLOBALS['phpAds_hlp_insert_delayed'] = "
        ".$phpAds_dbmsname." locks the table when it is inserting data. If have many visitors to your site,
		it could be possible ".$phpAds_productname." must wait before inserting a new row, because the database
		is still locked. When you use insert delayed, you don't have to wait and the row will
		be inserted at a later time when the table is not in use by any other thread.
		";

$GLOBALS['phpAds_hlp_compatibility_mode'] = "
        If you are having problem integrating ".$phpAds_productname." with another thirth-party product it
		might help to turn on the database compatibility mode. If you are using local mode
		invocation and the database compatibility is turned on ".$phpAds_productname." should leave
		the state of the database connection exectly the same as it was before ".$phpAds_productname." ran.
		This option is a bit slower (only slightly) and therefore turned off by default.
		";

$GLOBALS['phpAds_hlp_table_prefix'] = "
        If the database ".$phpAds_productname." is using is shared by multiple software products, it is wise
		to add a prefix to names of the tables. If you are using multiple installations of ".$phpAds_productname."
		in the same database, you need to make sure this prefix is unique for all installations.
		";

$GLOBALS['phpAds_hlp_table_type'] = "
        ".$phpAds_dbmsname." supports multiple table types. Each type of table has unique properties and some
		can speed up ".$phpAds_productname." considerable. MyISAM is the default table type and is available
		in all installations of ".$phpAds_dbmsname.". Other table types may not be available on your server.
		";

$GLOBALS['phpAds_hlp_url_prefix'] = "
        ".$phpAds_productname." needs to know where it is located on the web server in order
        to work correctly. You must specify the URL to the directory where ".$phpAds_productname."
        is installed, for example: <i>http://www.your-url.com/".$phpAds_productname."</i>.
		";

$GLOBALS['phpAds_hlp_ssl_url_prefix'] = "
        ".$phpAds_productname." needs to know where it is located on the web server in order
        to work correctly. Sometimes the SSL prefix is different than the regular URL prefix.
		You must specify the URL to the directory where ".$phpAds_productname."
        is installed, for example: <i>https://www.your-url.com/".$phpAds_productname."</i>.
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

$GLOBALS['phpAds_hlp_log_beacon'] = "
		Beacons are small invisible images which are placed on the page where the banner
		also is displayed. If you turn this feature on ".$phpAds_productname." will use this beacon image
		to count the number of impressions the banner has recieved. If you turn this feature
		off the impression will be counted during delivery, but this is not entirely accurate,
		because a delivered banner doesnďż˝t always have to be displayed on the screen.
		";

$GLOBALS['phpAds_hlp_compact_stats'] = "
        Traditionally ".$phpAds_productname." used rather extensive logging, which was very
        detailed but was also very demanding on the database server. This could
        be a big problem on sites with a lot of visitors. To overcome this problem
		".$phpAds_productname." also supports a new kind of statistics, the compact statistics,
		which is less demanding on the database server, but also less detailed.
		The compact statistics collects AdViews, AdClicks, and AdConversions for each hour, if you need
		more detail you can turn the compact statistics off.
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
		shown to the same visitor in the last 5 minutes. This feature only works the browser accepts cookies.
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

$GLOBALS['phpAds_hlp_log_adconversions'] = "
        Normally all AdConversions are logged, if you don't want to gather statistics
        about AdConversions you can turn this off.
		";

$GLOBALS['phpAds_hlp_block_adconversions'] = "
		If a visitor reloads a page with an AdConversion beacon, ".$phpAds_productname." will log the AdConversion
		every time. This feature is used to make sure that only one AdConversion is logged for each
		unique conversion for the number of seconds you specify. For example: if you set this value
		to 300 seconds, ".$phpAds_productname." will only log AdConversions if the visitor didnďż˝t load the same
		page with the AdConversion beacon in the last 5 minutes. This feature only works when the browser accepts cookies.
		";

$GLOBALS['phpAds_hlp_log_source'] = "
		If you are using the source parameter in the invocation code you can also store this information
		in the database so you will able to see statistics about how the different source
		parameters are performing. If you are not using the source parameter, or if you don't
		want to store information about this parameter you can safely turn this option off.
		";

$GLOBALS['phpAds_hlp_geotracking_stats'] = "
		If you are using a geotargeting database you can also store the geographical information
		in the database. If you have enabled this option you will be able to see statistics about the
		location of your visitors and how each banner is performing in the different countries.
		This option will only be available to you if you are using verbose statistics.
		";

$GLOBALS['phpAds_hlp_log_hostname'] = "
		If you want to store the hostname or IP address of each visitor in the statistics you can
		enable this feature. Storing this information will allow you to see which hosts are retrieving
		the most banners. This option is only available if you are using verbose statistics.
		";

$GLOBALS['phpAds_hlp_log_iponly'] = "
		Storing the hostname of the visitor takes a lot of space inside the database. If you enable
		this feature ".$phpAds_productname." will still store information about the host, but it will store the
		less space consuming IP address only. This option isnďż˝t available if the hostname isn't
		provided by the server or ".$phpAds_productname.", because in that case the IP address will always be
		stored.
		";

$GLOBALS['phpAds_hlp_reverse_lookup'] = "
		The hostname is usually determined by the web server, but in some cases this might be
		turned off. If you want to use the visitors hostname inside delivery limitations and/or
		keep statistics about this and the server doesn't provide this information you will need to
		turn this option on. Determining the hostname of the visitor does take some time; it will
		slow the delivery of banners down.
		";

$GLOBALS['phpAds_hlp_proxy_lookup'] = "
		Some visitors are using a proxy server to access the internet. In that case ".$phpAds_productname." will
		log the IP address or the hostname of the proxy server instead of the user. If you enable
		this feature ".$phpAds_productname." will try to find the IP address or hostname of the visitor's computer
		behind the proxy server. If it is not possible to find the exact address of the visitor
		it will use the address of the proxy server instead. This option is not enabled by default,
		because it will slow the delivery of banners down considerably.
		";

$GLOBALS['phpAds_hlp_obfuscate'] = "Nothing here....";

$GLOBALS['phpAds_hlp_auto_clean_tables'] =
$GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "
		If you enable this feature, the gathered statistics will be automatically deleted after the
		period you specify below this checkbox is passed. For example, if you set this to 5 weeks,
		statistics older than 5 weeks will be automatically deleted.
		";

$GLOBALS['phpAds_hlp_auto_clean_userlog'] =
$GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "
		This feature will automatically delete entries from the userlog which are older than the
		number of weeks specified below this checkbox.
		";

$GLOBALS['phpAds_hlp_geotracking_type'] = "
		Geotargeting allows ".$phpAds_productname." to convert the IP address of the visitor to geographical
		information. Based on this information you can set delivery limitations or you could store
		this information to see which country is generation the most impressions or click-thrus.
		If you want to enable geotargeting you need to choose which type of database you have.
		".$phpAds_productname." currently supports the <a href='http://hop.clickbank.net/?phpadsnew/ip2country' target='_blank'>IP2Country</a>
		and <a href='http://www.maxmind.com/?rId=phpadsnew' target='_blank'>GeoIP</a> database.
		";

$GLOBALS['phpAds_hlp_geotracking_location'] = "
		Unless you are the GeoIP Apache module, you should tell ".$phpAds_productname." the location of the
		geotargeting database. It is always recommended to place the database outside of the web
		servers document root, because otherwise people are able to download the database.
		";

$GLOBALS['phpAds_hlp_geotracking_cookie'] = "
		Converting the IP address in geographical information takes time. To prevent
		".$phpAds_productname." from having to do this every time a banner is delivered the result can be
		stored in a cookie. If this cookie is present ".$phpAds_productname." will use this information instead
		of converting the IP address.
		";

$GLOBALS['phpAds_hlp_ignore_hosts'] = "
        If you don't want to count views, clicks, and conversions from certain computer you
        can add these to this list. If you have enabled reverse lookup you can
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
        views, clicks, or conversions left. This is turned on by default.
		";

$GLOBALS['phpAds_hlp_warn_client'] = "
        ".$phpAds_productname." can sent the advertiser e-mail if one of his campaigns has only a
		limited number of views, clicks, or conversions left. This is turned on by default.
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
$GLOBALS['phpAds_hlp_allow_invocation_plain_nocookies'] =
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

$GLOBALS['phpAds_hlp_delivery_caching'] = "
		To help speed up the delivery ".$phpAds_productname." uses a cache which includes all
		the information needed to delivery the banner to the visitor of your website. The delivery
		cache is stored by default in the database, but to increase the speed even more it is also
		possible to store the cache inside a file or inside shared memory. Shared memory is fastest,
		Files is also very fast. It is not recommended to turn the delivery cache off, because this
		will seriously affect the performance.
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
		stored on an external web server, or use HTML or a simple text to generate a banner.
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

$GLOBALS['phpAds_hlp_type_web_ssl_url'] = "
        If you store banners on a web server, ".$phpAds_productname." needs to know which public
        URL (SSL) corresponds with the directory you specified below. Do not specify
        a trailing slash (/).
		";

$GLOBALS['phpAds_hlp_type_html_auto'] = "
        If this option is turned on ".$phpAds_productname." will automatically alter HTML banners
        in order to allow the clicks to be logged. However even while this option
        is turned on, it will still be possible to disable this feature on a per banner
        basis.
		";

$GLOBALS['phpAds_hlp_type_html_php'] = "
        It is possible to let ".$phpAds_productname." execute PHP code embedded inside HTML
        banners. This feature is turned off by default.
		";

$GLOBALS['phpAds_hlp_admin'] = "
        Please enter the username of the administrator. With this username you can log into
		the administrator interface.
		";

$GLOBALS['phpAds_hlp_admin_pw'] =
$GLOBALS['phpAds_hlp_admin_pw2'] = "
        Please enter the password you want to use to log into the administrator interface.
		You need to enter it twice to prevent typing errors.
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
        If you want to recieve a warning before deleting advertisers, campaigns, banners,
		publishers and zones; set this option to true.
		";

$GLOBALS['phpAds_hlp_client_welcome'] = "
		If you turn this feature on a welcome message will be displayed on the first page an
		advertiser will see after loggin in. You can personalize this message by editing the
		welcome.html file location in the admin/templates directory. Things you might want to
		include are for example: Your company name, contact information, your company logo, a
		link a page with advertising rates, etc..
		";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
		Instead of editing the welcome.html file you can also specify a small text here. If you enter
		a text here, the welcome.html file will be ignored. It is allowed to use html tags.
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

$GLOBALS['phpAds_hlp_userlog_inventory'] = "
		To ensure the inventory calculation ran correctly, you can save a report about
		the hourly inventory calculation. This report includes the predicted profile and how much
		priority is assigned to all banners. This information might be useful if you
		want to submit a bugreport about the priority calculations. The reports are
		stored inside the userlog.
		";

$GLOBALS['phpAds_hlp_userlog_autoclean'] = "
		To ensure the database was pruned correctly, you can save a report about
		what exactly happened during the pruning. This information will be stored
		in the userlog.
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
		the number of AdClicks remaining, the number of AdConversions remaining, activation date,
		expiration date and the priority settings.
		";

$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
		If this option is enabled extra information about each banner will be shown on the
		<i>Banners</i> page. The extra information includes the destination URL, keywords,
		size and the banner weight.
		";

$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
		If this option is enabled a preview of all banners will be shown on the <i>Banners</i>
		page. If this option is disabled it is still possible to show a preview of each banner by click
		on the triangle next to each banner on the <i>Banners</i> page.
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

$GLOBALS['phpAds_hlp_gui_show_matching'] = "
		If this option is enabled the matching banner will be shown on the <i>Linked banners</i> page, if
		the <i>Campaign selection</i> method is chosen. This will allow you see exactly which banners are
		considered for delivery if the campaign is linked. It will also be possible to look at a preview
		of the matching banners.
		";

$GLOBALS['phpAds_hlp_gui_show_parents'] = "
		If this option is enabled the parent campaigns of the banners will be shown on the <i>Linked banners</i>
		page, if the <i>Banner selection</i> method is chosen. This will allow you to see which banner
		belongs to which campaign before the banner is linked. This also means that the banners are grouped
		by the parent campaigns and are no longer sorted alphabetically.
		";

$GLOBALS['phpAds_hlp_gui_link_compact_limit'] = "
		By default all of the available banners or campaigns are displayed on the <i>Linked banners</i> page.
		Because of this the page can become very long if there are a lot of different banners available in
		the inventory. This option will allow you to set the maximum number of items that are shown on the
		page. If there are more items and different way to link banners will be shown which will take much
		less space.
		";

?>