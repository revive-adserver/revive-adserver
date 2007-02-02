<?php // $Revision$

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

//  Translator: Tadashi Jokagi <elf2000@users.sourceforge.net>
//  EN-Revision: 2.6.2.18

// Installer translation strings
$GLOBALS['strInstall']				= "インストール";
$GLOBALS['strChooseInstallLanguage']		= "インストール手続きの言語を選択する";
$GLOBALS['strLanguageSelection']		= "言語選択";
$GLOBALS['strDatabaseSettings']			= "データベース設定";
$GLOBALS['strAdminSettings']			= "管理者設定";
$GLOBALS['strAdvancedSettings']			= "高度なデータベース設定";
$GLOBALS['strOtherSettings']			= "その他の設定";
$GLOBALS['strLicenseInformation']		= "ライセンス情報";
$GLOBALS['strAdministratorAccount']		= "管理者アカウント";
$GLOBALS['strDatabasePage']				= $phpAds_dbmsname." データベース";
$GLOBALS['strInstallWarning']			= "サーバーと完全な確認";
$GLOBALS['strCongratulations']			= "おめでとうございます!";
$GLOBALS['strInstallFailed']			= "インストールに失敗しました!";
$GLOBALS['strSpecifyAdmin']				= "管理者アカウントの設定";
$GLOBALS['strSpecifyLocaton']			= "サーバー上の ".$phpAds_productname." の場所の指定";

$GLOBALS['strWarning']				= "警告";
$GLOBALS['strFatalError']			= "致命的なエラーが発生しました。";
$GLOBALS['strUpdateError']			= "更新中にエラーが発生しました。";
$GLOBALS['strUpdateDatabaseError']	= "不明の理由により、データベース構造の更新は成功しませんでした。The recommended way to proceed is to click <b>更新を再実行する</b> to try to correct these potential problems. これらのエラーが ".$phpAds_productname." の機能性に影響しないと確信する場合、<b>警告を無視する</b>をクリックして、続けます。これらのエラーの無視は重大問題を引き起こすかもしれないし推奨されません!";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname." は既にこのシステムにインストールされていました。設定をしたい場合、「<a href='settings-index.php'>インターフェース設定</a>」に移動してください。";
$GLOBALS['strCouldNotConnectToDB']		= "
データベースに接続できませんでした。指定されている設定を再確認してください。
さらに既に指定している名前のデータベースがデータベースサーバーに存在することを確かめてください。".$phpAds_productname." はデータベースを作成しませんので、インストーラーを実行する前に手動で作成しなければなりません。";
$GLOBALS['strCreateTableTestFailed']		= "指定されたユーザーは、データベース構造の作成か更新をする権限をもっていません。データベース管理者に連絡してください。";
$GLOBALS['strUpdateTableTestFailed']		= "指定されたユーザーは、データベース構造の更新をする権限を持っていません。データベース管理者に連絡してください。";
$GLOBALS['strTablePrefixInvalid']		= "テーブル接頭語に無効な文字が含まれています。";
$GLOBALS['strTableInUse']			= "The database which you specified is already used for ".$phpAds_productname.", please use a different table prefix, or read the manual for upgrading instructions.";
$GLOBALS['strTableWrongType']		= "指定したテーブルの種類は、".$phpAds_dbmsname."のインストールでサポートされていません。";
$GLOBALS['strMayNotFunction']			= "継続する前に、これらの潜在的な問題を修正してください:";
$GLOBALS['strFixProblemsBefore']		= $phpAds_productname." をインストールする前に、次の項目を修正する必要があります。このエラーメッセージについて疑問を何か持っている場合は、ダウンロードしたパッケージの一部である<i>管理者ガイド</i>を読んでください。";
$GLOBALS['strFixProblemsAfter']			= "If you are not able to correct the problems listed above, please contact the administrator of the server you are trying to install ".$phpAds_productname." on. The administrator of the server may be able to help you.";
$GLOBALS['strIgnoreWarnings']			= "警告を無視する";
$GLOBALS['strWarningDBavailable']		= "使用中の PHP のバージョンは、".$phpAds_dbmsname." データベースサーバーへの接続をサポートしていません。次に進める前に、PHP ".$phpAds_dbmsname." 拡張を有効にする必要があります。";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." は正確に機能するには、 PHP バージョン 4.0.3 以上を要求します。現在バージョン {php_version} 使用中です。";
$GLOBALS['strWarningPHP5beta']			= "You trying to install ".$phpAds_productname." on a server running an early test version of PHP 5. These versions are not indended for production use and usually contain bugs. It is not recommended to run ".$phpAds_productname." on PHP 5, except for testing purposes.";
$GLOBALS['strWarningRegisterGlobals']		= "PHP の設定値「register_globals」を「on」にする必要があります。";
$GLOBALS['strWarningMagicQuotesGPC']		= "PHP の設定値「magic_quotes_gpc」を「on」にする必要があります。";
$GLOBALS['strWarningMagicQuotesRuntime']	= "PHP の設定値「magic_quotes_runtime」を「off」にする必要があります。";
$GLOBALS['strWarningMagicQuotesSybase']	= "PHP の設定値「magic_quotes_sybase」を「off」にする必要があります。";
$GLOBALS['strWarningFileUploads']		= "PHP の設定値「file_uploads」を「on」にする必要があります。";
$GLOBALS['strWarningTrackVars']			= "PHP の設定値「track_vars」を「on」にする必要があります。";
$GLOBALS['strWarningPREG']				= "使用している PHP のバージョンは Perl 互換正規表現(PCRE)をサポートしていません。進める前に PCRE 拡張を有効にする必要があります。";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." はサーバーから <b>config.inc.php</b> が書き込みできないことを検知しました。ファイルのパーミッションを変更するまで進むことができません。それをする方法が分からない場合、提供されたドキュメントを読んでください。";
$GLOBALS['strCacheLockedDetected']		= "You are using Files delivery caching and ".$phpAds_productname." has detected that the <b>cache</b> directory is not writeable by the server. You can't proceed until you change permissions of the folder. Read the supplied documentation if you don't know how to do that.";
$GLOBALS['strCantUpdateDB']  			= "It is currently not possible to update the database. If you decide to proceed, all existing banners, statistics and advertisers will be deleted.";
$GLOBALS['strIgnoreErrors']			= "エラーを無視する";
$GLOBALS['strRetry']				= "再実行する";
$GLOBALS['strRetryUpdate']			= "更新の再実行する";
$GLOBALS['strTableNames']			= "テーブル名";
$GLOBALS['strTablesPrefix']			= "テーブル名の接頭語";
$GLOBALS['strTablesType']			= "テーブルの種類";

$GLOBALS['strRevCorrupt']			= "ファイル <b>{filename}</b> は不正か修正されました。このファイルを修正していない場合、サーバーにこのファイルの新しいコピーをアップロードを再度行ってください。このファイルを自分自身で修正した場合、安全にこの警告を無視することができます。";
$GLOBALS['strRevTooOld']			= "The file <b>{filename}</b> is older than the one that is supposed to be used with this version of ".$phpAds_productname.". Please try to upload a new copy of this file to the server.";
$GLOBALS['strRevMissing']			= "The file <b>{filename}</b> could not be checked because it is missing. Please try to upload a new copy of this file to the server.";
$GLOBALS['strRevCVS']				= $phpAds_productname." のCVSのチェックアウトをインストールしようとしています。これは公式リリースではなく、そして不安定かもしれないし、機能しないかもしれません。本当に継続したいですか?";

$GLOBALS['strInstallWelcome']			= "ようこそ ".$phpAds_productname." へ";
$GLOBALS['strInstallMessage']			= "Before you can use ".$phpAds_productname." it needs to be configured and <br> the database needs to be created. <b>進む</b> をクリックして続けます。";
$GLOBALS['strInstallMessageCheck']		= $phpAds_productname." has checked the integrity of the files you uploaded to the server and has checked wether the server is capable of running ".$phpAds_productname.". 
継続する前に、次の項目を注意する必要があります。";
$GLOBALS['strInstallMessageAdmin']		= "継続する前に、セットアップで管理者アカウントを必要とします。You can use this account to log into the administrator interface and manage your inventory and view statistics.";
$GLOBALS['strInstallMessageDatabase']	= $phpAds_productname." uses a ".$phpAds_dbmsname." database store the inventory and all of the statistics. Before you can continue you need to tell us which server you want to use and which username and password ".$phpAds_productname." needs to use to contact the server. If you do not know which information you should provide here, please contact the administrator of your server.";
$GLOBALS['strInstallSuccess']			= "<b>".$phpAds_productname." のインsトールが完了しました。</b><br><br>In order for ".$phpAds_productname." to function correctly you also need
						   to make sure the maintenance file is run every hour. More information about this subject can be found in the documentation.
						   <br><br>Click <b>Proceed</b> to go the configuration page, where you can 
						   set up more settings. Please do not forget to lock the config.inc.php file when you are finished to prevent security
						   breaches.";
$GLOBALS['strUpdateSuccess']			= "<b>The upgrade of ".$phpAds_productname." was succesful.</b><br><br>In order for ".$phpAds_productname." to function correctly you also need
						   to make sure the maintenance file is run every hour (previously this was every day). More information about this subject can be found in the documentation.
						   <br><br>Click <b>Proceed</b> to go to the administration interface. Please do not forget to lock the config.inc.php file 
						   to prevent security breaches.";
$GLOBALS['strInstallNotSuccessful']		= "<b>The installation of ".$phpAds_productname." was not succesful</b><br><br>Some portions of the install process could not be completed.
						   It is possible these problems are only temporarily, in that case you can simply click <b>Proceed</b> and return to the
						   first step of the install process. If you want to know more on what the error message below means, and how to solve it, 
						   please consult the supplied documentation.";
$GLOBALS['strErrorOccured']			= "The following error occured:";
$GLOBALS['strErrorInstallDatabase']		= "データベース構造を作成できませんでした。";
$GLOBALS['strErrorInstallConfig']		= "設定ファイルかデータベースを更新できませんでした。";
$GLOBALS['strErrorInstallDbConnect']		= "It was not possible to open a connection to the database.";

$GLOBALS['strUrlPrefix']			= "URL 接頭語";

$GLOBALS['strProceed']				= "進む &gt;";
$GLOBALS['strInvalidUserPwd']			= "無効なユーザー名かパスワードです。";

$GLOBALS['strUpgrade']				= "アップグレードする";
$GLOBALS['strSystemUpToDate']			= "システムは既に最新です。アップグレードは今のところ必要ありません。<br><b>進む</b> をクリックするとホームページに移動します。";
$GLOBALS['strSystemNeedsUpgrade']		= "正確に機能するためにデータベース構造および設定ファイルをアップグレードする必要があります。<b>進む</b> をクリックすると、アップグレード処理を開始します。<br><br>Depending on which version you are upgrading from and how many statistics are already stored in the database, this process can cause high load on your database server. 我慢してください、アップグレイドは2、3分で使用することができます。";
$GLOBALS['strSystemUpgradeBusy']		= "システムアップグレードの処理中です。暫くお待ちください...";
$GLOBALS['strSystemRebuildingCache']		= "キャッシュを再構築中です。暫くお待ちください...";
$GLOBALS['strServiceUnavalable']		= "The service is temporarily unavailable. System upgrade in progress";

$GLOBALS['strConfigNotWritable']		= "ファイル「config.inc.php」が書き込めません";
$GLOBALS['strPhpBug20144']				= "Your PHP version is affected by a <a href='http://bugs.php.net/bug.php?id=20114' target='_blank'>bug</a> which will prevent ".$phpAds_productname." from running correctly.
							Upgrading to PHP 4.3.0+ is required before installing ".$phpAds_productname.".";
$GLOBALS['strPhpBug24652']				= "You trying to install ".$phpAds_productname." on a server running an early test version of PHP 5.
										   These versions are not indended for production use and usually contain bugs.
										   One of these bugs prevents ".$phpAds_productname." from running correctly.
										   This <a href='http://bugs.php.net/bug.php?id=24652' target='_blank'>bug</a> is already fixed
										   and the final version of PHP 5 is not affected by this bug.";





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= "セクション選択";
$GLOBALS['strDayFullNames'] 			= array("日曜日","月曜日","火曜日","水曜日","木曜日","金曜日","土曜日");
$GLOBALS['strEditConfigNotPossible']   		= "設定ファイルがセキュリティー理由でロックされるので、これらの設定を編集することはできません。".
										  "変更したければ、最初にファイル config.inc.php のロックを解除する必要があります。";
$GLOBALS['strEditConfigPossible']		= "構成ファイルがロックされないので、設定をすべて編集することはできます。しかし、これは機密の漏洩に通じるかもしれません。".
										  "システムを安全にしたければ、ファイル config.inc.php をロックする必要があります。";



// Database
$GLOBALS['strDatabaseSettings']			= "データベース設定";
$GLOBALS['strDatabaseServer']			= "データベースサーバー";
$GLOBALS['strDbLocal']				= "ソケットを用いてローカルサーバーに接続する"; // Pg only
$GLOBALS['strDbHost']				= "データベースホスト名";
$GLOBALS['strDbPort']				= "データベースポート番号";
$GLOBALS['strDbUser']				= "データベースユーザー名";
$GLOBALS['strDbPassword']			= "データベースパスワード";
$GLOBALS['strDbName']				= "データベース名";

$GLOBALS['strDatabaseOptimalisations']		= "データベースの最適化";
$GLOBALS['strPersistentConnections']		= "持続性接続を使用する";
$GLOBALS['strInsertDelayed']			= "遅延 INSERT を使用する";
$GLOBALS['strCompatibilityMode']		= "データベース互換モードを使用する";
$GLOBALS['strCantConnectToDb']			= "データベースに接続できません";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "Invocation and delivery settings";

$GLOBALS['strAllowedInvocationTypes']		= "Allowed invocation types";
$GLOBALS['strAllowRemoteInvocation']		= "Allow Remote Invocation";
$GLOBALS['strAllowRemoteJavascript']		= "Allow Remote Invocation for Javascript";
$GLOBALS['strAllowRemoteFrames']		= "Allow Remote Invocation for Frames";
$GLOBALS['strAllowRemoteXMLRPC']		= "Allow Remote Invocation using XML-RPC";
$GLOBALS['strAllowLocalmode']			= "ローカルモードを許可する";
$GLOBALS['strAllowInterstitial']		= "Allow Interstitials";
$GLOBALS['strAllowPopups']			= "ポップアップを許可する";

$GLOBALS['strUseAcl']				= "Evaluate delivery limitations during delivery";

$GLOBALS['strDeliverySettings']			= "配送設定";
$GLOBALS['strCacheType']				= "配送キャッシュの種類";
$GLOBALS['strCacheFiles']				= "ファイル";
$GLOBALS['strCacheDatabase']			= "データベース";
$GLOBALS['strCacheShmop']				= "共有メモリ/Shmop";
$GLOBALS['strCacheSysvshm']				= "共有メモリ/Sysvshm";
$GLOBALS['strExperimental']				= "実験";
$GLOBALS['strKeywordRetrieval']			= "キーワード取得";
$GLOBALS['strBannerRetrieval']			= "バナー取得方法";
$GLOBALS['strRetrieveRandom']			= "ランダムバナー取得 (デフォルト)";
$GLOBALS['strRetrieveNormalSeq']		= "普通の順次バナー取得";
$GLOBALS['strWeightSeq']			= "重みベースの順次バナー取得";
$GLOBALS['strFullSeq']				= "完全な順次バナー取得";
$GLOBALS['strUseConditionalKeys']		= "Allow logical operators when using direct selection";
$GLOBALS['strUseMultipleKeys']			= "Allow multiple keywords when using direct selection";

$GLOBALS['strZonesSettings']			= "ゾーン取得";
$GLOBALS['strZoneCache']			= "Cache zones, this should speed things up when using zones";
$GLOBALS['strZoneCacheLimit']			= "Time between cache updates (in seconds)";
$GLOBALS['strZoneCacheLimitErr']		= "Time between cache updates should be a positive integer";

$GLOBALS['strP3PSettings']			= "P3P プライバシーポリシー";
$GLOBALS['strUseP3P']				= "P3P ポリシーを使う";
$GLOBALS['strP3PCompactPolicy']			= "P3P コンパクトポリシー";
$GLOBALS['strP3PPolicyLocation']		= "P3P 所在地ポリシー"; 



// Banner Settings
$GLOBALS['strBannerSettings']			= "バナー設定";

$GLOBALS['strAllowedBannerTypes']		= "バナーの種類を許可する";
$GLOBALS['strTypeSqlAllow']			= "ローカルバナー(SQL)を許可する";
$GLOBALS['strTypeWebAllow']			= "ローカルバナー(ウェブサーバー)を許可する";
$GLOBALS['strTypeUrlAllow']			= "外部バナーを許可する";
$GLOBALS['strTypeHtmlAllow']			= "HTML バナーを許可する";
$GLOBALS['strTypeTxtAllow']			= "テキスト広告を許可する";

$GLOBALS['strTypeWebSettings']			= "ローカルバナー(ウェブサーバー)設定";
$GLOBALS['strTypeWebMode']			= "ソート方法";
$GLOBALS['strTypeWebModeLocal']			= "ローカルディレクトリ";
$GLOBALS['strTypeWebModeFtp']			= "外部 FTP サーバー";
$GLOBALS['strTypeWebDir']			= "ローカルディレクトリ";
$GLOBALS['strTypeWebFtp']			= "FTP モードウェブバナーサーバー";
$GLOBALS['strTypeWebUrl']			= "公開 URL";
$GLOBALS['strTypeFTPHost']			= "FTP ホスト";
$GLOBALS['strTypeFTPDirectory']			= "ホストディレクトリ";
$GLOBALS['strTypeFTPUsername']			= "ログイン名";
$GLOBALS['strTypeFTPPassword']			= "パスワード";
$GLOBALS['strTypeFTPErrorDir']			= "ホストのディレクトリが存在しません。";
$GLOBALS['strTypeFTPErrorConnect']		= "FTP サーバーに接続できません。ログイン名かパスワードが正しくありません。";
$GLOBALS['strTypeFTPErrorHost']			= "FTPサーバーのホスト名が正確ではありません。";
$GLOBALS['strTypeDirError']				= "ローカルディレクトリが存在しません。";

$GLOBALS['strDefaultBanners']			= "デフォルトバナー";
$GLOBALS['strDefaultBannerUrl']			= "デフォルト画像 URL";
$GLOBALS['strDefaultBannerTarget']		= "Default destination URL";

$GLOBALS['strTypeHtmlSettings']			= "HTML バナーオプション";
$GLOBALS['strTypeHtmlAuto']			= "Automatically alter HTML banners in order to force click tracking";
$GLOBALS['strTypeHtmlPhp']			= "Allow PHP expressions to be executed from within a HTML banner";

$GLOBALS['strCookieSettings']			= "Cookie 設定";
$GLOBALS['strPackCookies']				= "Pack cookies to avoid cookie overpopulation";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']				= "Host information and Geotargeting";

$GLOBALS['strRemoteHost']				= "リモートホスト";
$GLOBALS['strReverseLookup']			= "Try to determine the hostname of the visitor if it is not supplied by the server";
$GLOBALS['strProxyLookup']				= "Try to determine the real IP address of the visitor if he is using a proxy server";

$GLOBALS['strGeotargeting']				= "Geotargeting";
$GLOBALS['strGeotrackingType']			= "Type of geotargeting database";
$GLOBALS['strGeotrackingLocation'] 		= "Geotargeting database location";
$GLOBALS['strGeotrackingLocationError'] = "The geotargeting database does not exist in the location you specified";
$GLOBALS['strGeotrackingLocationNoHTTP']	= "The location you supplied is not a local directory on the hard drive of the server, but an URL to a file on a webserver. The location should look similar to this: <i>{example}</i>. The actual location depends on where you copied the database.";
$GLOBALS['strGeotrackingUnsupportedDB'] = "The geotargeting database supplied is not supported by this plug-in";
$GLOBALS['strGeoStoreCookie']			= "将来の参照用に Cookie に結果を保存する";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "統計設定";

$GLOBALS['strStatisticsFormat']			= "統計の形式";
$GLOBALS['strCompactStats']				= "統計の形式";
$GLOBALS['strLogAdviews']				= "バナーを配送するたびに adView を記録する";
$GLOBALS['strLogAdclicks']				= "バナーを訪問者がクリックするたびに AdClick を記録する";
$GLOBALS['strLogSource']				= "Log the source parameter specified during invocation";
$GLOBALS['strGeoLogStats']				= "統計の訪問者の国を記録する";
$GLOBALS['strLogHostnameOrIP']			= "訪問者の IP アドレスまたはホスト名を記録する";
$GLOBALS['strLogIPOnly']				= "ホスト名が分かっても訪問者の IP アドレスのみ記録する";
$GLOBALS['strLogIP']					= "訪問者の IP アドレスを記録する";
$GLOBALS['strLogBeacon']				= "Use a small beacon image to log AdViews to ensure only delivered banners are logged";

$GLOBALS['strRemoteHosts']				= "リモートホスト";
$GLOBALS['strIgnoreHosts']				= "Don't store statistics for visitors using one of the following IP addresses or hostnames";
$GLOBALS['strBlockAdviews']				= "Don't log AdViews if the visitor already seen the same banner within the specified number of seconds";
$GLOBALS['strBlockAdclicks']			= "Don't log AdClicks if the visitor already clicked on the same banner within the specified number of seconds";


$GLOBALS['strPreventLogging']			= "ログの記録の妨害";
$GLOBALS['strEmailWarnings']			= "電子メールの警告";
$GLOBALS['strAdminEmailHeaders']		= "Add the following headers to each e-mail message sent by ".$phpAds_productname;
$GLOBALS['strWarnLimit']				= "Send a warning when the number of impressions left are less than specified here";
$GLOBALS['strWarnLimitErr']				= "制限は正数でなければならないと警告する";
$GLOBALS['strWarnAdmin']				= "Send a warning to the administrator every time a campaign is almost expired";
$GLOBALS['strWarnClient']				= "Send a warning to the advertiser every time a campaign is almost expired";
$GLOBALS['strQmailPatch']				= "qmail パッチを有効にする";

$GLOBALS['strAutoCleanTables']			= "データベースの除去";
$GLOBALS['strAutoCleanStats']			= "統計を除去する";
$GLOBALS['strAutoCleanUserlog']			= "ユーザーのログを除去する";
$GLOBALS['strAutoCleanStatsWeeks']		= "統計の最大期間 <br>(最小 3 週間)";
$GLOBALS['strAutoCleanUserlogWeeks']	= "ユーザーログの最大期間 <br>(最小 3 週間)";
$GLOBALS['strAutoCleanErr']				= "最大期間は、少なくとも 3 週間なければなりません。";
$GLOBALS['strAutoCleanVacuum']			= "毎晩テーブルを VACUUM ANALYZE する"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "管理者設定";

$GLOBALS['strLoginCredentials']			= "Login credentials";
$GLOBALS['strAdminUsername']			= "管理者のユーザー名";
$GLOBALS['strInvalidUsername']			= "無効なユーザー名";

$GLOBALS['strBasicInformation']			= "基本情報";
$GLOBALS['strAdminFullName']			= "フルネーム";
$GLOBALS['strAdminEmail']			= "電子メールアドレス";
$GLOBALS['strCompanyName']			= "企業名";

$GLOBALS['strAdminCheckUpdates']		= "アップデートを確認する";
$GLOBALS['strAdminCheckEveryLogin']		= "ログイン毎";
$GLOBALS['strAdminCheckDaily']			= "毎日";
$GLOBALS['strAdminCheckWeekly']			= "毎週";
$GLOBALS['strAdminCheckMonthly']		= "毎月";
$GLOBALS['strAdminCheckNever']			= "しない";
$GLOBALS['strAdminCheckDevBuilds']		= "新規リリースされた開発バージョンのプロンプト";

$GLOBALS['strAdminNovice']			= "管理者の削除アクションは、安全性のための確認を必要とする";
$GLOBALS['strUserlogEmail']			= "すべての電子メールメッセージの送信を記録する";
$GLOBALS['strUserlogPriority']			= "一時間毎に優先度の計算を記録する";
$GLOBALS['strUserlogAutoClean']			= "自動でデータベースのクリーニングを記録する";


// User interface settings
$GLOBALS['strGuiSettings']			= "ユーザーインターフェース設定";

$GLOBALS['strGeneralSettings']			= "一般設定";
$GLOBALS['strAppName']				= "アプリケーション名";
$GLOBALS['strMyHeader']				= "ヘッダーファイルの場所";
$GLOBALS['strMyHeaderError']		= "指定の場所にヘッダーファイルは存在しません。";
$GLOBALS['strMyFooter']				= "フッターファイルの場所";
$GLOBALS['strMyFooterError']		= "指定の場所にフッターファイルは存在しません。";
$GLOBALS['strGzipContentCompression']		= "コンテンツの GZIP 圧縮を使用する";

$GLOBALS['strClientInterface']			= "広告主インターフェース";
$GLOBALS['strClientWelcomeEnabled']		= "広告主歓迎メッセージを有効にする";
$GLOBALS['strClientWelcomeText']		= "歓迎メッセージ<br>(HTML タグは許可されます)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "インターフェースのデフォルト";

$GLOBALS['strInventory']			= "Inventory";
$GLOBALS['strShowCampaignInfo']			= "<i>キャンペーン概要</i>ページのその他のキャンペーン情報を表示する";
$GLOBALS['strShowBannerInfo']			= "<i>バナー概要</i>ページのその他のバナー情報を表示する";
$GLOBALS['strShowCampaignPreview']		= "<i>バナー概要</i>ページのすべてのバナーのプレビューを表示する";
$GLOBALS['strShowBannerHTML']			= "HTML バナープレビューのために普通の HTML コードの変わりに実際のバナーを表示する";
$GLOBALS['strShowBannerPreview']		= "バナーを関係するページの一番上のバナーでプレビューする";
$GLOBALS['strHideInactive']			= "すべての概要ページからアクティブでない項目を隠す";
$GLOBALS['strGUIShowMatchingBanners']		= "<i>リンク済バナー</i>ページのバナーの一致を表示する";
$GLOBALS['strGUIShowParentCampaigns']		= "<i>リンク済バナー</i>ページの親キャンペーンを表示する";
$GLOBALS['strGUILinkCompactLimit']		= "Hide non-linked campaigns or banners on the <i>Linked banner</i> pages when there are more than";

$GLOBALS['strStatisticsDefaults'] 		= "統計";
$GLOBALS['strBeginOfWeek']			= "週の開始";
$GLOBALS['strPercentageDecimals']		= "Percentage Decimals";

$GLOBALS['strWeightDefaults']			= "デフォルトの重み";
$GLOBALS['strDefaultBannerWeight']		= "バナーのデフォルトの重み";
$GLOBALS['strDefaultCampaignWeight']		= "キャンペーンのデフォルトの重み";
$GLOBALS['strDefaultBannerWErr']		= "バナーのデフォルトの重みは整数でなければなりません。";
$GLOBALS['strDefaultCampaignWErr']		= "キャンペーンのデフォルトの重みは整数でなければなりません。";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "テーブルの境界線色";
$GLOBALS['strTableBackColor']			= "テーブルの背景色";
$GLOBALS['strTableBackColorAlt']		= "テーブルの背景色 (切り替え)";
$GLOBALS['strMainBackColor']			= "メイン背景色";
$GLOBALS['strOverrideGD']			= "GD Imageformat を上書きする";
$GLOBALS['strTimeZone']				= "タイムゾーン";

?>