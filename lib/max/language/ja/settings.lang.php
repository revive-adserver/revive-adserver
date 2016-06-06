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

// Installer translation strings
$GLOBALS['strInstall'] = "インストール";
$GLOBALS['strDatabaseSettings'] = "データベース設定";
$GLOBALS['strAdminAccount'] = "管理者アカウント";
$GLOBALS['strAdvancedSettings'] = "高度な設定";
$GLOBALS['strWarning'] = "警告";
$GLOBALS['strBtnContinue'] = "続行する »";
$GLOBALS['strBtnRecover'] = "復旧する »";
$GLOBALS['strBtnAgree'] = "承認する »";
$GLOBALS['strBtnRetry'] = "再試行する";
$GLOBALS['strWarningRegisterArgcArv'] = "PHPの設定値[register_argc_argv]を'on'にしてください";
$GLOBALS['strTablesType'] = "テーブルタイプ";

$GLOBALS['strRecoveryRequiredTitle'] = "前回のアップデートでエラーが発生";
$GLOBALS['strRecoveryRequired'] = "前回のアップデートプロセスでエラーが発生しています。{$PRODUCT_NAME} は、アップデートプロセスの回復を試みます。以下の\\'復旧する\\'ボタンをクリックしてください。";

$GLOBALS['strOaUpToDate'] = "あなたの{$PRODUCT_NAME}は最新です！次へボタンを押して、{$PRODUCT_NAME}の管理画面へと進んでください。";
$GLOBALS['strOaUpToDateCantRemove'] = "警告:アップデートファイルが、varディレクトリに残っています。十分な権限がないため、アップデートファイルを削除できませんでした。このファイルを自分自身の手で削除してください。";
$GLOBALS['strErrorWritePermissions'] = "ファイルのパーミッションエラーが検出されました。継続するには、指定ファイルのパーミッションを変更してください。<br />Linux系のシステムでは、以下のコマンドを入力してください。:";

$GLOBALS['strErrorWritePermissionsWin'] = "ファイルのパーミッションエラーが検出されました。継続するには、指定ファイルのパーミッションを変更してください。";
$GLOBALS['strCheckDocumentation'] = "詳細な情報に関しては、 <a href='{$PRODUCT_DOCSURL}'>{$PRODUCT_NAME} こちら</a>をご覧下さい。";

$GLOBALS['strAdminUrlPrefix'] = "管理者画面URL";
$GLOBALS['strDeliveryUrlPrefix'] = "配信エンジンURL";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "配信エンジンURL(SSL)";
$GLOBALS['strImagesUrlPrefix'] = "画像ストレージURL";
$GLOBALS['strImagesUrlPrefixSSL'] = "画像ストレージURL(SSL)";



/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "セクションの選択";
$GLOBALS['strUnableToWriteConfig'] = "設定ファイルに書き込む事ができませんでした。";
$GLOBALS['strUnableToWritePrefs'] = "データベースに設定を反映できませんでした。";
$GLOBALS['strImageDirLockedDetected'] = "指定した<b>画像ストレージ</b>への書き込みができません。<br>ディレクトリのパーミッションを変更するか、新しくディレクトリを作成してください。";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "設定";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "管理者  ユーザ名";
$GLOBALS['strAdminPassword'] = "管理者  パスワード";
$GLOBALS['strInvalidUsername'] = "ユーザ名が不正です";
$GLOBALS['strBasicInformation'] = "基本情報";
$GLOBALS['strAdministratorEmail'] = "管理者メールアドレス";
$GLOBALS['strAdminCheckUpdates'] = "アップデートの確認";
$GLOBALS['strNovice'] = "アクションを削除する前に確認する";
$GLOBALS['strUserlogEmail'] = "全ての送信メールの内容をログに取る";
$GLOBALS['strEnableDashboard'] = "ダッシュボードを有効にする";
$GLOBALS['strEnableDashboardSyncNotice'] = "ダッシュボードを使用するには、<a href='account-settings-update.php'>アップデートのチェック</a>を有効にしてください。";
$GLOBALS['strTimezone'] = "タイムゾーン";
$GLOBALS['strEnableAutoMaintenance'] = "定期メンテナンスが設定されていない場合、配信中に定期的なメンテナンスを自動実行する。";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "データベース設定";
$GLOBALS['strDatabaseServer'] = "グローバルデータベースサーバ設定";
$GLOBALS['strDbLocal'] = "ソケットを使う";
$GLOBALS['strDbType'] = "データベースのタイプ";
$GLOBALS['strDbHost'] = "データベースのホスト名";
$GLOBALS['strDbSocket'] = "データベースソケット";
$GLOBALS['strDbPort'] = "データベースのポート番号";
$GLOBALS['strDbUser'] = "データベースのユーザ名";
$GLOBALS['strDbPassword'] = "データベースのパスワード";
$GLOBALS['strDbName'] = "データベース名";
$GLOBALS['strDbNameHint'] = "もしない場合、データベースが自動で作成されます。";
$GLOBALS['strDatabaseOptimalisations'] = "データベース最適化設定";
$GLOBALS['strPersistentConnections'] = "持続的にデータベースに接続する";
$GLOBALS['strCantConnectToDb'] = "データベースに接続できません";

// Email Settings
$GLOBALS['strEmailSettings'] = "Eメール設定";
$GLOBALS['strEmailAddresses'] = "Eメール  アドレス";
$GLOBALS['strEmailFromName'] = "Eメール  宛先名";
$GLOBALS['strEmailFromAddress'] = "Eメール  Eメールアドレス";
$GLOBALS['strEmailFromCompany'] = "Eメール  社用";
$GLOBALS['strQmailPatch'] = "Qメールパッチ";
$GLOBALS['strEnableQmailPatch'] = "Qmailパッチを適用する";
$GLOBALS['strEmailHeader'] = "Eメールヘッダ";
$GLOBALS['strEmailLog'] = "Eメールログ";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "追跡記録ログ";
$GLOBALS['strEnableAudit'] = "監査の追跡を有効にする";

// Debug Logging Settings
$GLOBALS['strDebug'] = "ログ検査方法の設定";
$GLOBALS['strEnableDebug'] = "ログの検査を有効にする";
$GLOBALS['strDebugMethodNames'] = "関数名を検査ログに含める";
$GLOBALS['strDebugLineNumbers'] = "検査ログに行番号を含める";
$GLOBALS['strDebugType'] = "検査ログのタイプ";
$GLOBALS['strDebugTypeFile'] = "ファイル";
$GLOBALS['strDebugTypeSql'] = "SQLデータベース";
$GLOBALS['strDebugTypeSyslog'] = "システムログ";
$GLOBALS['strDebugName'] = "ログ名、カレンダー、SQLテーブル<br />もしくはシスログを検査する";
$GLOBALS['strDebugPriority'] = "優先度を検査する";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - ほぼ全てをログに出力する";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - 通常の情報をログに出力する";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE - Noticeレベルの情報をログに出力する";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING - 警告レベルの情報をログに出力する";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR - エラーレベルの情報をログに出力する";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT- クリティカルレベルの情報をログに出力する";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT - アラートレベルの情報をログに出力する";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - 最も情報の少ないレベル";
$GLOBALS['strDebugIdent'] = "識別文字の検査";
$GLOBALS['strDebugUsername'] = "mCal, SQLサーバのユーザ名";
$GLOBALS['strDebugPassword'] = "mCal, SQLサーバのパスワード";
$GLOBALS['strProductionSystem'] = "プロダクションシステム";

// Delivery Settings
$GLOBALS['strWebPathSimple'] = "Webパス";
$GLOBALS['strDeliveryPath'] = "配信パス";
$GLOBALS['strImagePath'] = "画像パス";
$GLOBALS['strDeliverySslPath'] = "配信パス（SSL)";
$GLOBALS['strImageSslPath'] = "画像パス（SSL)";
$GLOBALS['strImageStore'] = "画像ディレクトリ";
$GLOBALS['strTypeWebSettings'] = "画像のサーバ保存設定";
$GLOBALS['strTypeWebMode'] = "保存方法";
$GLOBALS['strTypeWebModeLocal'] = "ローカルディレクトリ";
$GLOBALS['strTypeDirError'] = "ウェブサーバがローカルディレクトリに書き込むことができません";
$GLOBALS['strTypeWebModeFtp'] = "外部FTPサーバ";
$GLOBALS['strTypeWebDir'] = "ローカルディレクトリ";
$GLOBALS['strTypeFTPHost'] = "FTPホスト";
$GLOBALS['strTypeFTPDirectory'] = "ホストディレクトリ";
$GLOBALS['strTypeFTPUsername'] = "ログイン";
$GLOBALS['strTypeFTPPassword'] = "パスワード";
$GLOBALS['strTypeFTPPassive'] = "パッシブFTPを使用";
$GLOBALS['strTypeFTPErrorDir'] = "FTPホストにディレクトリが存在しません";
$GLOBALS['strTypeFTPErrorConnect'] = "FTPサーバに接続できません。ログインかパスワードが間違っている可能性があります。";
$GLOBALS['strTypeFTPErrorNoSupport'] = "PHPの設定で、FTPをサポートする必要があります。";
$GLOBALS['strTypeFTPErrorUpload'] = "FTPサーバにファイルをアップロードすることができませんでした。ディレクトリの権限を確認してください。";
$GLOBALS['strTypeFTPErrorHost'] = "FTPホストが正しくありません";
$GLOBALS['strDeliveryFilenames'] = "配信ファイル名";
$GLOBALS['strDeliveryFilenamesAdClick'] = "広告クリック";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "広告コンバージョン値";
$GLOBALS['strDeliveryFilenamesAdContent'] = "広告内容";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "広告コンバージョン";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "広告コンバージョン(Javascript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "広告フレーム";
$GLOBALS['strDeliveryFilenamesAdImage'] = "広告画像";
$GLOBALS['strDeliveryFilenamesAdJS'] = "広告（Javascript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "広告レイヤー";
$GLOBALS['strDeliveryFilenamesAdLog'] = "広告ログ";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "広告ポップアップ";
$GLOBALS['strDeliveryFilenamesAdView'] = "広告ビュー";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "XML RPCで広告を生成する";
$GLOBALS['strDeliveryFilenamesLocal'] = "ローカルサーバより広告を生成する";
$GLOBALS['strDeliveryFilenamesFrontController'] = "フロントコントローラ";
$GLOBALS['strDeliveryFilenamesFlash'] = "FlashのURL（フルURL）";
$GLOBALS['strDeliveryCaching'] = "バナーキャッシュの設定";
$GLOBALS['strDeliveryCacheLimit'] = "バナーキャッシュの更新間隔";
$GLOBALS['strDeliveryAcls'] = "バナー配送毎に配信制限を確認する";
$GLOBALS['strDeliveryObfuscate'] = "バナー配信時にチャンネルを隠す";
$GLOBALS['strDeliveryExecPhp'] = "バナーの内容にPHPコードを許可する<br />(Warning: セキュリティリスクとなり得る)";
$GLOBALS['strDeliveryCtDelimiter'] = "サードパーティー製の、クリック追跡時用区切り文字";
$GLOBALS['strP3PSettings'] = "P3Pプライベートポリシー";
$GLOBALS['strUseP3P'] = "P3Pポリシーを使う";
$GLOBALS['strP3PCompactPolicy'] = "P3Pコンパクトポリシー";
$GLOBALS['strP3PPolicyLocation'] = "P3Pポリシーの場所";

// General Settings
$GLOBALS['generalSettings'] = "全般設定";
$GLOBALS['uiEnabled'] = "ユーザ画面を有効にする";
$GLOBALS['defaultLanguage'] = "デフォルト言語設定";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "ジオターゲティング設定";
$GLOBALS['strGeotargeting'] = "ジオターゲティング設定";
$GLOBALS['strGeotargetingType'] = "ジオターゲティングモジュールタイプ";
$GLOBALS['strGeoShowUnavailable'] = "GeoIPにデータがない場合でも、ジオターゲティングの配信制限を表示する";

// Interface Settings
$GLOBALS['strInventory'] = "インベントリ";
$GLOBALS['strShowCampaignInfo'] = "キャンペーンの追加情報を<i>キャンペーンの概要</i>に表示する";
$GLOBALS['strShowBannerInfo'] = "バナーの追加情報を<i>バナーの概要</i>に表示する";
$GLOBALS['strShowCampaignPreview'] = "全てのバナーのプレビューを<i>バナーの概要</i>に表示する";
$GLOBALS['strShowBannerHTML'] = "HTMLバナーの場合、HTMLタグではなく、実際のバナーを表示する";
$GLOBALS['strShowBannerPreview'] = "バナーが表示される画面に遷移した場合、バナーのプレビューを画面上部に表示する";
$GLOBALS['strHideInactive'] = "非アクティブなものを隠す";
$GLOBALS['strGUIShowMatchingBanners'] = "マッチするバナーを<i>関連済みバナー</i>で表示する";
$GLOBALS['strGUIShowParentCampaigns'] = "親キャンペーンを<i>関連済みバナー</i>で表示する";
$GLOBALS['strStatisticsDefaults'] = "統計";
$GLOBALS['strBeginOfWeek'] = "週の始まり";
$GLOBALS['strPercentageDecimals'] = "10進数のパーセンテージ";
$GLOBALS['strWeightDefaults'] = "デフォルトの重み";
$GLOBALS['strDefaultBannerWeight'] = "デフォルトのバナーの重み";
$GLOBALS['strDefaultCampaignWeight'] = "デフォルトのキャンペーンの重み";
$GLOBALS['strConfirmationUI'] = "ユーザインターフェースの確認";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "バナー生成タイプのデフォルト";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "サードパーティー製のクリック追跡をデフォルトで有効にする";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "バナーキャッシュの設定";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "バナーログのブロック設定";
$GLOBALS['strLogAdRequests'] = "バナー要求毎に'リクエスト'として記録する";
$GLOBALS['strLogAdImpressions'] = "バナー閲覧毎に'インプレッション'として記録する";
$GLOBALS['strLogAdClicks'] = "バナークリック毎に'クリック'として記録する";
$GLOBALS['strReverseLookup'] = "ホストネームが取得できない場合、逆引きを行う";
$GLOBALS['strProxyLookup'] = "プロキシサーバを経由している場合、本当のIPを取得する";
$GLOBALS['strPreventLogging'] = "バナーログのブロック設定";
$GLOBALS['strIgnoreHosts'] = "以下のIPに登録されているユーザはログを取得しない";
$GLOBALS['strIgnoreUserAgents'] = "以下の内容がUserAgentに含まれていた場合、ログを取得しない";
$GLOBALS['strEnforceUserAgents'] = "以下の内容がUserAgentに含まれている場合のみ、ログを取得する";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "バナーストレージ設定";

// Campaign ECPM settings

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "メンテナンス設定";
$GLOBALS['strConversionTracking'] = "コンバージョン追跡設定";
$GLOBALS['strEnableConversionTracking'] = "コンバージョンの追跡を有効にする";
$GLOBALS['strBlockAdClicks'] = "特定の時間内に同じゾーンもしくは広告にアクセスするユーザがいた場合、その広告クリック数を取得しない";
$GLOBALS['strMaintenanceOI'] = "メンテナンス時間間隔(分）";
$GLOBALS['strPrioritySettings'] = "優先度設定";
$GLOBALS['strPriorityInstantUpdate'] = "優先度の変更を即反映する";
$GLOBALS['strDefaultImpConWindow'] = "デフォルトの広告インプレッション接続ウィンドウ（秒）";
$GLOBALS['strDefaultCliConWindow'] = "デフォルトの広告クリックウィンドウ（秒）";
$GLOBALS['strAdminEmailHeaders'] = "{$PRODUCT_NAME} が送るメールのヘッダに以下の情報を付与する";
$GLOBALS['strWarnLimit'] = "インプレッションの残数がここで指定する数値を下回った場合、警告Eメールを送信する";
$GLOBALS['strWarnLimitDays'] = "表示日数の残数がここで指定する数値を下回った場合、警告Eメールを送信する";
$GLOBALS['strWarnAdmin'] = "キャンペーンが終了しそうになったら、管理者宛てにメールを送る。";
$GLOBALS['strWarnClient'] = "キャンペーンが終了しそうになったら、広告主宛てにメールを送る。";
$GLOBALS['strWarnAgency'] = "キャンペーンが終了しそうになったら、媒体主宛てにメールを送る。";

// UI Settings
$GLOBALS['strGuiSettings'] = "ユーザインターフェース設定";
$GLOBALS['strGeneralSettings'] = "全般設定";
$GLOBALS['strAppName'] = "アプリケーション名";
$GLOBALS['strMyHeader'] = "ヘッダファイルの場所";
$GLOBALS['strMyFooter'] = "フッタファイルの場所";
$GLOBALS['strDefaultTrackerStatus'] = "デフォルトの追跡ステータス";
$GLOBALS['strDefaultTrackerType'] = "デフォルトの追跡タイプ";
$GLOBALS['strSSLSettings'] = "SSL設定";
$GLOBALS['requireSSL'] = "ユーザインターフェースへのアクセスを強制的にSSLを使う";
$GLOBALS['sslPort'] = "SSLポート番号";
$GLOBALS['strDashboardSettings'] = "ダッシュボード設定";
$GLOBALS['strMyLogo'] = "カスタムロゴファイル名";
$GLOBALS['strGuiHeaderForegroundColor'] = "ヘッダーのフロント色";
$GLOBALS['strGuiHeaderBackgroundColor'] = "ヘッダーの背景色";
$GLOBALS['strGuiActiveTabColor'] = "アクティブタブの色";
$GLOBALS['strGuiHeaderTextColor'] = "ヘッダーのテキスト色";
$GLOBALS['strGzipContentCompression'] = "GZIP圧縮をする";

// Regenerate Platfor Hash script

// Plugin Settings
