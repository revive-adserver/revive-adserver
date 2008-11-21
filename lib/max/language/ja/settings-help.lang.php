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
$GLOBALS['phpAds_hlp_dbhost'] = "\n　　　　　　　 接続したい".phpAds_dbmsname."データベースサーバのホスト名を入力してください。\n		";

$GLOBALS['phpAds_hlp_dbport'] = "                接続したい".phpAds_dbmsname."データベースサーバのポートNoを入力してください。		デフォルトの".phpAds_dbmsname."データベースサーバのポートNoは、<i>" . (phpAds_dbmsname == 'MySQL' ? '3306' : '5432')."</i>です。		";

$GLOBALS['phpAds_hlp_dbuser'] = "\n                アクセスしたい".MAX_PRODUCT_NAME."用".phpAds_dbmsname."データベースサーバのユーザ名を入力してください。 \n		";

$GLOBALS['phpAds_hlp_dbpassword'] = "\n                アクセスしたい".MAX_PRODUCT_NAME."用".phpAds_dbmsname."データベースサーバのパスワードを入力してください。\n		";

$GLOBALS['phpAds_hlp_dbname'] = "" . MAX_PRODUCT_NAME."がデータ保存用に使用するデータベース名を入力してください。\n		データベースサーバ上にあらかじめデータベースを作成してください。"  .MAX_PRODUCT_NAME."は、指定したデータベースが存在しない場合、データベースを<b>自動作成しません</b>。\n		";

$GLOBALS['phpAds_hlp_persistent_connections'] = "\n                パーシスタント接続を使用すると、".MAX_PRODUCT_NAME."をかなりスピーディに動作させ、サーバ負荷を低減できます。\n		しかし欠点もあります。通常接続を使用する場合と比較して、多くの訪問者が訪れるサイトではサーバ負荷が上昇します。\n		通常接続にすべきかパーシスタント接続にすべきかは、訪問者数とハードウェアスペックに依存します。\n		もし、".MAX_PRODUCT_NAME."が多くのサーバリソースを食っている場合、この設定を最初に見直してください。\n		";



$GLOBALS['phpAds_hlp_compatibility_mode'] = "\n                もし、".MAX_PRODUCT_NAME."とサードパーティ製品との統合に問題がある場合、データベースの互換モードの変更が\n		役に立つかもしれません。ローカルモード呼出を使用し、データベース互換性が'ON'の場合、".MAX_PRODUCT_NAME."は\n		データベースの互換性を維持するようにデータベース接続状態を保ちます。\n		データベース互換モードを使用すると、若干動作が遅くなるので、デフォルトでは'OFF'にしています。\n		";


$GLOBALS['phpAds_hlp_table_prefix'] = "\n                もし、".MAX_PRODUCT_NAME."がデータベースを複数のソフトウェアと共有して使用する場合、テーブル名にプリフィックスを\n		追加してください。もし、同一データベースに複数の".MAX_PRODUCT_NAME."をインストールしている場合も同じように\n		異なるプリフィックスを追加して、各".MAX_PRODUCT_NAME."がユニークになるようにしてください。\n		";

$GLOBALS['phpAds_hlp_table_type'] = "\n        ".phpAds_dbmsname."は、複数のテーブルタイプをサポートしています。各々のテーブルタイプは異なる特性を有し、\n		いくつかのタイプは".MAX_PRODUCT_NAME."をかなりスピードアップさせます。MyISAMは、".phpAds_dbmsname."\n		のデフォルトテーブルタイプで、のすべてのインストールで利用可能です。他のテーブルタイプは、多くのサーバで利用できない\n		ケースがあります。";

$GLOBALS['phpAds_hlp_url_prefix'] = "\n        ".MAX_PRODUCT_NAME."は、Webサーバが正しく動作するように、Webサーバの場所を知っている必要があります。\n        ".MAX_PRODUCT_NAME."のインストールディレクトリを示すURLを入力してください。\n                入力例）<i>http://www.your-url.com/".MAX_PRODUCT_NAME."</i>\n		";

$GLOBALS['phpAds_hlp_ssl_url_prefix'] = "\n        ".MAX_PRODUCT_NAME."は、Webサーバが正しく動作するように、Webサーバの場所を知っている必要があります。\n                時として、 SSLプリフィックスは、標準URLのプリフィックスと異なります。\n        ".MAX_PRODUCT_NAME."のインストールディレクトリを示すURLを入力してください。\n                入力例）<i>https://www.your-url.com/".MAX_PRODUCT_NAME."</i>.\n		";

$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "\n                管理者インタフェース内の各々のページがヘッダーやフッターを持つように、各ファイルへのパスを入力してください。\n                入力例） /home/login/www/header.htm\n                これらのファイルには、テキストもしくはHTMLを入力できます（HTML使用時は、<body>タグと<html>タグは\n                不要です)。\n		";

$GLOBALS['phpAds_hlp_my_logo'] = "\n                デフォルトロゴに代えて表示したいカスタムロゴのファイル名を入力してください。\n                ロゴファイル名を入力する前に、admin/imagesディレクトリに必ずロゴファイルをアップロードしてください。\n        ";


$GLOBALS['phpAds_hlp_gui_header_foreground_color'] = "\n                タブ、サーチバーおよび強調文字で使用する文字色を入力してください。\n        ";


$GLOBALS['phpAds_hlp_gui_header_background_color'] = "\n                ヘッダー背景に使用する背景色を入力してください。\n        ";

$GLOBALS['phpAds_hlp_gui_header_active_tab_color'] = "\n                選択中のメインタブに使用する背景色を入力してください。\n        ";

$GLOBALS['phpAds_hlp_gui_header_text_color'] = "\n                ヘッダー内のテキストに使用する文字色を入力してください。\n        ";

$GLOBALS['phpAds_hlp_content_gzip_compression'] = "\n		By enabling GZIP content compression you will get a big decrease of the data which\n		is sent to the browser each time a page of the administrator interface is opened.\n		To enable this feature you need to have at least PHP 4.0.5 with the GZIP extention installed.\n		";

$GLOBALS['phpAds_hlp_language'] = "\n        Specify the default language ".MAX_PRODUCT_NAME." should use. This language will\n        be used as a default for the admin and advertiser interface. Please note:\n        you can set a different language for each advertiser from the admin interface\n        and allow advertisers to change their language themselves.\n		";

$GLOBALS['phpAds_hlp_name'] = "\n        Specify the name you want to use for this application. This string will\n        be displayed on all pages in the admin and advertiser interface. If you leave\n        this setting empty (default) a logo of ".MAX_PRODUCT_NAME." will be displayed instead.\n		";

$GLOBALS['phpAds_hlp_company_name'] = "このメールは ". MAX_PRODUCT_NAME ." により送信されています。 ";

$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "\n        ".MAX_PRODUCT_NAME." usually detects if the GD library is installed and which image\n        format is supported by the installed version of GD. However it is possible\n        the detection is not accurate or false, some versions of PHP do not allow\n        the detection of the supported image formats. If ".MAX_PRODUCT_NAME." fails to auto-detect\n        the right image format you can specify the right image format. Possible\n        values are: none, png, jpeg, gif.\n		";

$GLOBALS['phpAds_hlp_p3p_policies'] = "\n        If you want to enable ".MAX_PRODUCT_NAME."' P3P Privacy Policies you must turn this\n        option on.\n		";

$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "\n        The compact policy which is sent together with cookies. The default setting\n        is: 'CUR ADM OUR NOR STA NID', which will allow Internet Explorer 6 to\n        accept the cookies used by ".MAX_PRODUCT_NAME.". If you want you can alter these\n        settings to match your own privacy statement.\n		";

$GLOBALS['phpAds_hlp_p3p_policy_location'] = "\n        If you want to use a full privacy policy, you can specify the location\n        of the policy.\n		";

$GLOBALS['phpAds_hlp_compact_stats'] = "\n        Traditionally ".MAX_PRODUCT_NAME." used rather extensive logging, which was very\n        detailed but was also very demanding on the database server. This could\n        be a big problem on sites with a lot of visitors. To overcome this problem\n		".MAX_PRODUCT_NAME." also supports a new kind of statistics, the compact statistics,\n		which is less demanding on the database server, but also less detailed.\n		The compact statistics collects AdViews, AdClicks, and AdConversions for each hour, if you need\n		more detail you can turn the compact statistics off.\n		";

$GLOBALS['phpAds_hlp_log_adviews'] = "\n        Normally all AdViews are logged, if you don't want to gather statistics\n        about AdViews you can turn this off.\n		";

$GLOBALS['phpAds_hlp_block_adviews'] = "\n		If a visitor reloads a page an AdView will be logged by ".MAX_PRODUCT_NAME." every time.\n		This feature is used to make sure that only one AdView is logged for each unique\n		banner for the number of seconds you specify. For example: if you set this value\n		to 300 seconds, ".MAX_PRODUCT_NAME." will only log AdViews if the same banner isn�t already\n		shown to the same visitor in the last 5 minutes. This feature only works the browser accepts cookies.\n		";

$GLOBALS['phpAds_hlp_log_adclicks'] = "\n        Normally all AdClicks are logged, if you don't want to gather statistics\n        about AdClicks you can turn this off.\n		";

$GLOBALS['phpAds_hlp_block_adclicks'] = "\n		If a visitor clicks multiple times on a banner an AdClick will be logged by ".MAX_PRODUCT_NAME."\n		every time. This feature is used to make sure that only one AdClick is logged for each\n		unique banner for the number of seconds you specify. For example: if you set this value\n		to 300 seconds, ".MAX_PRODUCT_NAME." will only log AdClicks if the visitor didn�t click on the same\n		banner in the last 5 minutes. This feature only works when the browser accepts cookies.\n		";

$GLOBALS['phpAds_hlp_log_adconversions'] = "\n        Normally all AdConversions are logged, if you don't want to gather statistics\n        about AdConversions you can turn this off.\n		";

$GLOBALS['phpAds_hlp_block_adconversions'] = "\n		If a visitor reloads a page with an AdConversion beacon, ".MAX_PRODUCT_NAME." will log the AdConversion\n		every time. This feature is used to make sure that only one AdConversion is logged for each\n		unique conversion for the number of seconds you specify. For example: if you set this value\n		to 300 seconds, ".MAX_PRODUCT_NAME." will only log AdConversions if the visitor didn�t load the same\n		page with the AdConversion beacon in the last 5 minutes. This feature only works when the browser accepts cookies.\n		";

$GLOBALS['phpAds_hlp_geotracking_stats'] = "\n		If you are using a geotargeting database you can also store the geographical information\n		in the database. If you have enabled this option you will be able to see statistics about the\n		location of your visitors and how each banner is performing in the different countries.\n		This option will only be available to you if you are using verbose statistics.\n		";

$GLOBALS['phpAds_hlp_reverse_lookup'] = "\n		The hostname is usually determined by the web server, but in some cases this might be\n		turned off. If you want to use the visitors hostname inside delivery limitations and/or\n		keep statistics about this and the server doesn't provide this information you will need to\n		turn this option on. Determining the hostname of the visitor does take some time; it will\n		slow the delivery of banners down.\n		";

$GLOBALS['phpAds_hlp_proxy_lookup'] = "\n		Some visitors are using a proxy server to access the internet. In that case ".MAX_PRODUCT_NAME." will\n		log the IP address or the hostname of the proxy server instead of the user. If you enable\n		this feature ".MAX_PRODUCT_NAME." will try to find the IP address or hostname of the visitor's computer\n		behind the proxy server. If it is not possible to find the exact address of the visitor\n		it will use the address of the proxy server instead. This option is not enabled by default,\n		because it will slow the delivery of banners down considerably.\n		";

$GLOBALS['phpAds_hlp_obfuscate'] = "Nothing here....";

$GLOBALS['phpAds_hlp_auto_clean_tables'] =
$GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "\n		If you enable this feature, the gathered statistics will be automatically deleted after the\n		period you specify below this checkbox is passed. For example, if you set this to 5 weeks,\n		statistics older than 5 weeks will be automatically deleted.\n		";

$GLOBALS['phpAds_hlp_auto_clean_userlog'] =
$GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "\n		This feature will automatically delete entries from the userlog which are older than the\n		number of weeks specified below this checkbox.\n		";

$GLOBALS['phpAds_hlp_geotracking_type'] = "\n		Geotargeting allows ".MAX_PRODUCT_NAME." to convert the IP address of the visitor to geographical\n		information. Based on this information you can set delivery limitations or you could store\n		this information to see which country is generation the most impressions or click-thrus.\n		If you want to enable geotargeting you need to choose which type of database you have.\n		".MAX_PRODUCT_NAME." currently supports the <a href='http://hop.clickbank.net/?phpadsnew/ip2country' target='_blank'>IP2Country</a>\n		and <a href='http://www.maxmind.com/?rId=phpadsnew' target='_blank'>GeoIP</a> database.\n		";

$GLOBALS['phpAds_hlp_geotracking_location'] = "\n		Unless you are the GeoIP Apache module, you should tell ".MAX_PRODUCT_NAME." the location of the\n		geotargeting database. It is always recommended to place the database outside of the web\n		servers document root, because otherwise people are able to download the database.\n		";

$GLOBALS['phpAds_hlp_geotracking_cookie'] = "\n		Converting the IP address in geographical information takes time. To prevent\n		".MAX_PRODUCT_NAME." from having to do this every time a banner is delivered the result can be\n		stored in a cookie. If this cookie is present ".MAX_PRODUCT_NAME." will use this information instead\n		of converting the IP address.\n		";

$GLOBALS['phpAds_hlp_ignore_hosts'] = "\n        If you don't want to count views, clicks, and conversions from certain computer you\n        can add these to this list. If you have enabled reverse lookup you can\n        add both domain names and IP addresses, otherwise you can only use IP\n        addresses. You can also use wildcards (i.e. '*.altavista.com' or '192.168.*').\n		";

$GLOBALS['phpAds_hlp_begin_of_week'] = "\n        For most people a week starts on a Monday, but if you want to start each\n        week on a Sunday you can.\n		";

$GLOBALS['phpAds_hlp_percentage_decimals'] = "\n        Specifies how many decimal places to display on statistics pages.\n		";

$GLOBALS['phpAds_hlp_warn_admin'] = "\n        ".MAX_PRODUCT_NAME." can sent you email if a campaign has only a limited number of\n        views, clicks, or conversions left. This is turned on by default.\n		";

$GLOBALS['phpAds_hlp_warn_client'] = "もしキャンペーンが１つでも以下の状態の場合、". MAX_PRODUCT_NAME ." は広告主宛てにメールを送信することが出来ます。";

$GLOBALS['phpAds_hlp_qmail_patch'] = "あるバージョンのQmailにはバグがあります。たとえばヘッダ情報を全て表示します。この設定をオンにした場合、". MAX_PRODUCT_NAME ." はQmailに対応したフォーマットでメールを送信します。";

$GLOBALS['phpAds_hlp_warn_limit'] = "". MAX_PRODUCT_NAME ." が警告を送信し始める閾値は100です。";

$GLOBALS['phpAds_hlp_acl'] = "\n        If you are not using delivery limitations you can disable this option with this parameter,\n        this will speed up ".MAX_PRODUCT_NAME." a bit.\n		";

$GLOBALS['phpAds_hlp_default_banner_url'] =
$GLOBALS['phpAds_hlp_default_banner_target'] = "\n        If ".MAX_PRODUCT_NAME." can't connect to the database server, or can't find any matching\n        banners at all, for example when the database crashed or was deleted,\n        it won't display anything. Some users may want to specify a default banner,\n        which will be displayed in these situations. The default banner specified\n        here will not be logged and won't be used if there are still active banners\n        left in the database. This is turned off by default.\n		";

$GLOBALS['phpAds_hlp_delivery_caching'] = "\n		To help speed up the delivery ".MAX_PRODUCT_NAME." uses a cache which includes all\n		the information needed to delivery the banner to the visitor of your website. The delivery\n		cache is stored by default in the database, but to increase the speed even more it is also\n		possible to store the cache inside a file or inside shared memory. Shared memory is fastest,\n		Files is also very fast. It is not recommended to turn the delivery cache off, because this\n		will seriously affect the performance.\n		";

$GLOBALS['phpAds_hlp_type_web_mode'] = "\n        If you want to use banners stored on the web server, you need to configure\n        this setting. If you want to store the banners in a local directory set\n        this option to <i>Local directory</i>. If you want to store the banner on an\n		external FTP server set this option to <i>External FTP server</i>. On certain\n		web servers you may want to use the FTP option even on the local web server.\n		";

$GLOBALS['phpAds_hlp_type_web_dir'] = "\n        Specify the directory where ".MAX_PRODUCT_NAME." needs to copy the uploaded banners\n        to. This directory needs to be writable by PHP, this could mean you need\n        to modify the UNIX permissions for this directory (chmod). The directory\n        you specify here needs to be in the web server' document root, the web\n        server must be able to serve the files directly. Do not specify a trailing\n        slash (/). You only need to configure this option if you have set the storing\n		method to <i>Local directory</i>.\n		";

$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "\n		If you set the storing method to <i>External FTP server</i> you need to\n        specify the IP address or domain name of the FTP server where ".MAX_PRODUCT_NAME." needs\n		to copy the uploaded banners to.\n		";

$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "\n		If you set the storing method to <i>External FTP server</i> you need to\n        specify the directory on the external FTP server where ".MAX_PRODUCT_NAME." needs\n		to copy the uploaded banners to.\n		";

$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "\n		If you set the storing method to <i>External FTP server</i> you need to\n        specify the username which ".MAX_PRODUCT_NAME." must use in order to connect to the\n		external FTP server.\n		";

$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "\n		If you set the storing method to <i>External FTP server</i> you need to\n        specify the password which ".MAX_PRODUCT_NAME." must use in order to connect to the\n		external FTP server.\n		";

$GLOBALS['phpAds_hlp_type_web_ftp_passive'] = "\n 	    Some FTP servers and firewalls require transfers to use Passive Mode (PASV).\n 	    If " . MAX_PRODUCT_NAME . " will need to use Passive Mode to connect to your\n 	    FTP server, then enable this option.\n 	    ";

$GLOBALS['phpAds_hlp_type_web_url'] = "\n        If you store banners on a web server, ".MAX_PRODUCT_NAME." needs to know which public\n        URL corresponds with the directory you specified below. Do not specify\n        a trailing slash (/).\n		";

$GLOBALS['phpAds_hlp_type_web_ssl_url'] = "\n        If you store banners on a web server, ".MAX_PRODUCT_NAME." needs to know which public\n        URL (SSL) corresponds with the directory you specified below. Do not specify\n        a trailing slash (/).\n		";

$GLOBALS['phpAds_hlp_type_html_auto'] = "\n        If this option is turned on ".MAX_PRODUCT_NAME." will automatically alter HTML banners\n        in order to allow the clicks to be logged. However even while this option\n        is turned on, it will still be possible to disable this feature on a per banner\n        basis.\n		";

$GLOBALS['phpAds_hlp_type_html_php'] = "\n        It is possible to let ".MAX_PRODUCT_NAME." execute PHP code embedded inside HTML\n        banners. This feature is turned off by default.\n		";

$GLOBALS['phpAds_hlp_admin'] = "\n        Please enter the username of the administrator. With this username you can log into\n		the administrator interface.\n		";

$GLOBALS['phpAds_hlp_admin_pw'] =
$GLOBALS['phpAds_hlp_admin_pw2'] = "\n        Please enter the password you want to use to log into the administrator interface.\n		You need to enter it twice to prevent typing errors.\n		";

$GLOBALS['phpAds_hlp_pwold'] =
$GLOBALS['phpAds_hlp_pw'] =
$GLOBALS['phpAds_hlp_pw2'] = "\n        To change the administrator password, you can need to specify the old\n		password above. Also you need to specify the new password twice, to\n		prevent typing errors.\n		";

$GLOBALS['phpAds_hlp_admin_fullname'] = "\n        Specify the administrator's full name. This used when sending statistics\n        via email.\n		";

$GLOBALS['phpAds_hlp_admin_email'] = "管理者のEメールアドレスです。これは以下の場合にFROMアドレスとして使用されます。";

$GLOBALS['phpAds_hlp_admin_novice'] = "広告主、キャンペーン、広告、Webサイト等を削除する前に確認画面をポップアップするようにしたい場合は、こちらの機能を有効にして下さい。";

$GLOBALS['phpAds_hlp_client_welcome'] = "\n		If you turn this feature on a welcome message will be displayed on the first page an\n		advertiser will see after loggin in. You can personalize this message by editing the\n		welcome.html file location in the admin/templates directory. Things you might want to\n		include are for example: Your company name, contact information, your company logo, a\n		link a page with advertising rates, etc..\n		";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "\n		Instead of editing the welcome.html file you can also specify a small text here. If you enter\n		a text here, the welcome.html file will be ignored. It is allowed to use html tags.\n		";

$GLOBALS['phpAds_hlp_updates_frequency'] = "\n		If you want to check for new versions of ".MAX_PRODUCT_NAME." you can enable this feature.\n		It is possible the specify the interval in which ".MAX_PRODUCT_NAME." makes a connection to\n		the update server. If a new version is found a dialog box will pop up with additional\n		information about the update.\n		";

$GLOBALS['phpAds_hlp_userlog_email'] = "\n		If you want to keep a copy of all outgoing email messages send by ".MAX_PRODUCT_NAME." you\n		can enable this feature. The email messages are stored in the userlog.\n		";

$GLOBALS['phpAds_hlp_userlog_inventory'] = "\n		To ensure the inventory calculation ran correctly, you can save a report about\n		the hourly inventory calculation. This report includes the predicted profile and how much\n		priority is assigned to all banners. This information might be useful if you\n		want to submit a bugreport about the priority calculations. The reports are\n		stored inside the userlog.\n		";

$GLOBALS['phpAds_hlp_userlog_autoclean'] = "\n		To ensure the database was pruned correctly, you can save a report about\n		what exactly happened during the pruning. This information will be stored\n		in the userlog.\n		";

$GLOBALS['phpAds_hlp_default_banner_weight'] = "\n		If you want to use a higher default banner weight you can specify the desired weight here.\n		This settings is 1 by default.\n		";

$GLOBALS['phpAds_hlp_default_campaign_weight'] = "\n		If you want to use a higher default campaign weight you can specify the desired weight here.\n		This settings is 1 by default.\n		";

$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "このオプションが有効になった場合、キャンペーンのより詳細な情報方が<i>キャンペーン</i>ページに表示されます。詳細情報とは、インプレッション残数、クリック残数、コンバージョン残数、開始日、期限日、優先度を含みます。";

$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "このオプションが有効になった場合、バナーのより詳細な情報が<i>バナー</i>ページに表示されます。詳細情報とは、クリック先URL、キーワード、サイズ、重さを含みます。";

$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "このオプションが有効になった場合、<i>バナー</i>ページにプレビューが表示されるようになります。無効になった場合でも、<i>バナー</i>横にある三角ボタンをクリックすれば、プレビューは表示されるようになります。";

$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "\n		If this option is enabled the actual HTML banner will be shown instead of the HTML code. This\n		option is disabled by default, because the HTML banners might conflict with the user interface.\n		If this option is disabled it is still possible to view the actual HTML banner, by clicking on\n		the <i>Show banner</i> button next to the HTML code.\n		";

$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "\n		If this option is enabled a preview will be shown at the top of the <i>Banner properties</i>,\n		<i>Delivery option</i> and <i>Linked zones</i> pages. If this option is disabled it is still\n		possible to view the banner, by clicking on the <i>Show banner</i> button at the top of the pages.\n		";

$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "このオプションが有効になった場合、全ての無効なバナー、キャンペーン、そして広告主は<i>広告主とキャンペーン</i>のページ上から隠されます。有効になった後でも、<i>すべてを表示</i>ボタンを押せば、表示されるようになります。";

$GLOBALS['phpAds_hlp_gui_show_matching'] = "\n		If this option is enabled the matching banner will be shown on the <i>Linked banners</i> page, if\n		the <i>Campaign selection</i> method is chosen. This will allow you see exactly which banners are\n		considered for delivery if the campaign is linked. It will also be possible to look at a preview\n		of the matching banners.\n		";

$GLOBALS['phpAds_hlp_gui_show_parents'] = "\n		If this option is enabled the parent campaigns of the banners will be shown on the <i>Linked banners</i>\n		page, if the <i>Banner selection</i> method is chosen. This will allow you to see which banner\n		belongs to which campaign before the banner is linked. This also means that the banners are grouped\n		by the parent campaigns and are no longer sorted alphabetically.\n		";
?>
