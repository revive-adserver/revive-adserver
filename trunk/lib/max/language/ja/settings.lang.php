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

// Installer translation strings
$GLOBALS['strInstall']                      		= "インストール";
$GLOBALS['strChooseInstallLanguage']        		= "インストール言語の選択";
$GLOBALS['strLanguageSelection']            		= "言語の選択";
$GLOBALS['strDatabaseSettings']             		= "データベースの設定";
$GLOBALS['strAdminSettings']                		= "管理者設定";
$GLOBALS['strAdminAccount']                 		= "管理者アカウント";
$GLOBALS['strAdministrativeSettings']       		= "管理者用設定";
$GLOBALS['strAdvancedSettings']             		= "高度な設定";
$GLOBALS['strOtherSettings']                		= "その他の設定";
$GLOBALS['strSpecifySyncSettings']          		= "同期設定";
$GLOBALS['strLicenseInformation']           		= "ライセンス情報";
$GLOBALS['strOpenadsIdYour']                		= "OpenX ID";
$GLOBALS['strOpenadsIdSettings']            		= "OpenX IDの設定";
$GLOBALS['strWarning']                      		= "警告";
$GLOBALS['strFatalError']                   		= "致命的なエラーが発生しました。";
$GLOBALS['strUpdateError']                  		= "更新中にエラーが発生しました。";
$GLOBALS['strBtnContinue']                  		= "続行する »";
$GLOBALS['strBtnRecover']                   		= "復旧する »";
$GLOBALS['strBtnStartAgain']                		= "アップデートを再開する »";
$GLOBALS['strBtnGoBack']                    		= "« 戻る";
$GLOBALS['strBtnAgree']                     		= "承認する »";
$GLOBALS['strBtnDontAgree']                 		= "« 承認しない";
$GLOBALS['strBtnRetry']                     		= "再試行する";
$GLOBALS['strUpdateDatabaseError']          		= "不明なエラーにより、データベース更新は成功しませんでした。潜在的な問題を引き続き修正するには、<b>更新を再実行する</b>をクリックしてください。不明なエラーが ".MAX_PRODUCT_NAME." の機能に影響しないと確信する場合のみ、<b>警告を無視する</b>をクリックしてください。重大問題を引き起こすかもしれないので、不明なエラーを無視することは推奨しません！";
$GLOBALS['strAlreadyInstalled']             		= MAX_PRODUCT_NAME."は、すでにインストールされています。継続するには、<a href='settings-index.php'>インターフェースの設定</a>に訪問してください。";
$GLOBALS['strCouldNotConnectToDB']          		= "データベースに接続できませんでした。データベース設定を再確認してください。";
$GLOBALS['strCreateTableTestFailed']        		= "指定されたユーザーは、データベースの作成もしくは更新権限がありません。データベース管理者に連絡してください。";
$GLOBALS['strUpdateTableTestFailed']        		= "指定されたユーザーは、データベースの更新権限を持っていません。データベース管理者に連絡してください。";
$GLOBALS['strTablePrefixInvalid']           		= "指定したテーブルプリフィックスには、無効な文字が含まれています。";
$GLOBALS['strTableInUse']                   		= "指定したデータベースは、".MAX_PRODUCT_NAME."で既に使用されています。異なるテーブルプリフィックスを使用するか、アップグレードするか、アップグレード手順を記載したUPGRADE.txtを読んでください。";
$GLOBALS['strNoVersionInfo']                		= "指定したデータベースバージョンは選択できません！";
$GLOBALS['strInvalidVersionInfo']           		= "指定したデータベースのバージョンが特定できません！";
$GLOBALS['strInvalidMySqlVersion']          		= MAX_PRODUCT_NAME."を正しく機能するには、MySQL 4.0以上が必要です。異なるデータベースサーバを選択してください。";
$GLOBALS['strTableWrongType']               		= "選択したテーブルタイプは、".phpAds_dbmsname."のインストールでサポートされていません。";
$GLOBALS['strMayNotFunction']               		= "継続するには、潜在的な問題を修正してください:";
$GLOBALS['strFixProblemsBefore']            		= MAX_PRODUCT_NAME."をインストールする前に、次の項目を修正してください。このエラーメッセージについて何か疑問がある場合は、ダウンロードパッケージ中の<i>管理者ガイド(Administrator's Guide)</i>を読んでください。";
$GLOBALS['strFixProblemsAfter']             		= "前述の問題を修正できない場合、サーバの管理者に連絡して、".MAX_PRODUCT_NAME."のインストールで発生した問題点を伝えてください。サーバ管理者から適切な解決方法を教えてもらえるかもしれません。";
$GLOBALS['strIgnoreWarnings']               		= "警告を無視する";
$GLOBALS['strFixErrorsBeforeContinuing']    		= "継続するにはすべてのエラー内容を修正してください。";
$GLOBALS['strWarningDBavailable']           		= "使用中のPHPバージョンは、".$phpAds_dbmsname." データベースサーバへの接続をサポートしていません。次に進む前に、PHPの".$phpAds_dbmsname." 拡張を有効にしてください。";
$GLOBALS['strWarningPHPversion']            		= MAX_PRODUCT_NAME."が正常に機能するには、PHP4.3.6以上が必要です。現在バージョンは、{php_version} です。";
$GLOBALS['strWarningRegisterGlobals']       		= "PHPの設定値[register_globals]を'on'にしてください";
$GLOBALS['strWarningMagicQuotesGPC']        		= "PHPの設定値[magic_quotes_gpc]を'on'にしてください";
$GLOBALS['strWarningRegisterArgcArv']       		= "PHPの設定値[register_argc_argv]を'on'にしてください";
$GLOBALS['strWarningMagicQuotesRuntime']    		= "PHPの設定値[magic_quotes_runtime]を'off'にしてください";
$GLOBALS['strWarningFileUploads']           		= "PHPの設定値[file_uploads]を'on'にしてください";
$GLOBALS['strWarningTrackVars']             		= "PHPの設定値[track_vars]を'on'にしてください";
$GLOBALS['strWarningPREG']                  		= "使用中のPHPバージョンは、Perl互換正規表現(PREG)をサポートしていません。継続するには PREG拡張を有効にしてください。";
$GLOBALS['strConfigLockedDetected']         		= MAX_PRODUCT_NAME."は、<b>max.conf.ini</b>に対する書き込み権限がないことを検出しました。'var'ディレクトリに対する書き込み権限が設定されるまで、継続できません。書き込み権限の変更方法がわからない場合、提供したドキュメントを読んでください。";
$GLOBALS['strCantUpdateDB']                 		= "データベース更新ができません。 このまま継続すると、すべての既存のバナー、統計、および広告主は削除される可能性があります。";
$GLOBALS['strIgnoreErrors']                 		= "警告を無視する";
$GLOBALS['strRetryUpdate']                  		= "更新を再実行する";
$GLOBALS['strTableNames']                   		= "テーブル名";
$GLOBALS['strTablesPrefix']                 		= "テーブルプリフィックス";
$GLOBALS['strTablesType']                   		= "テーブルタイプ";

$GLOBALS['strInstallWelcome']               		= "ようこそ ".MAX_PRODUCT_NAME."へ";
$GLOBALS['strInstallMessage']               		= MAX_PRODUCT_NAME."を使用するには、システム設定とデータベースの作成が必要です。<br />継続するには、<b>進む</b> をクリックしてください。";
$GLOBALS['strInstallIntro']                 		= "<a href='http://".MAX_PRODUCT_URL."' target='_blank'><strong>".MAX_PRODUCT_NAME."</strong></a>を選んでいただきありがとうございます。
<p>".MAX_PRODUCT_NAME."ADサーバのインストール／アップグレードプロセスの実行に、このウィザードがお手伝いします。</p>
<p>インストールプロセスのお手伝いには、<a href='".OX_PRODUCT_DOCSURL."/wizard/qsg-install' target='_blank'>インストールクイックスタートガイド</a>がインストール開始から終了までお役に立ちます。
".MAX_PRODUCT_NAME."のインストール作業とサーバ設定のためのより詳しい情報は、 <a href='".OX_PRODUCT_DOCSURL."/wizard/admin-guide' target='_blank'>管理者ガイド</a>を参照してください。</p>";
$GLOBALS['strRecoveryRequiredTitle']    			= "前回のアップデートでエラーが発生";
$GLOBALS['strRecoveryRequired']         			= "前回のアップデートプロセスでエラーが発生しています。" . MAX_PRODUCT_NAME . "は、アップデートプロセスの回復を試みます。以下の'復旧する'ボタンをクリックしてください。";
$GLOBALS['strTermsTitle']               			= "利用条件";
$GLOBALS['strTermsIntro']               			= MAX_PRODUCT_NAME . "は、'Open Source license'と'GNU General Public License'のライセンス条件のもとに、無料で配布されます。";
$GLOBALS['strPolicyTitle']               			= "プライバシーポリシー";
$GLOBALS['strPolicyIntro']               			= "インストールを継続するには、次のドキュメントに記載されたプライバシーポリシーに承諾してください。";
$GLOBALS['strDbSetupTitle']               			= "データベース設定";
$GLOBALS['strDbSetupIntro']               			= "データベースに接続するための設定情報を入力してください。もし設定内容についてわからないことがあれば、サーバ管理者に問い合わせてください。
<p>次に、データベースを設定します。続けるには、‘続行する’をクリックしてください。</p>";
$GLOBALS['strDbUpgradeIntro']             			= MAX_PRODUCT_NAME . "のインストールに必要なデータベース設定情報は、以下のとおりです。設定情報に間違いがないかチェックしてください。
<p>次に、データベースを更新します。続けるには、‘続行する’をクリックしてください。</p>";
$GLOBALS['strOaUpToDate']               			= MAX_PRODUCT_NAME . "用のデータベースと各種ファイルは両方とも最新状態のため、現時点で更新は不要です。このまま、OpenX管理者パネルに移動しますので、'続行する'ボタンをクリックしてください。";
$GLOBALS['strOaUpToDateCantRemove']     			= "警告:アップデートファイルが、varディレクトリに残っています。十分な権限がないため、アップデートファイルを削除できませんでした。このファイルを自分自身の手で削除してください。";
$GLOBALS['strRemoveUpgradeFile']            		= "varディレクトリ内にあるUPGRADEファイルを削除してください。";
$GLOBALS['strInstallSuccess']               		= "'続行する'をクリックすると、自動的にログインします。
<p><strong>次にすべきことは？</strong></p>
<div class='psub'>
  <p><b>製品更新用サインアップ</b><br>
        製品の更新、セキュリティ警告及び新規リリース情報を得るには、<a href='".OX_PRODUCT_DOCSURL."/wizard/join' target='_blank'>".MAX_PRODUCT_NAME."メーリングリスト</a>に参加してください。
  </p>
  <p><b>最初の広告キャンペーン配信</b><br>
    <a href='".OX_PRODUCT_DOCSURL."/wizard/qsg-firstcampaign' target='_blank'>クイックスタートガイド</a>を利用してください。
  </p>
</div>
<p><strong>インストールオプション概要</strong></p>
<div class='psub'>
  <p><b>サーバ設定ファイルのロック</b><br>
  　　　セキュリティ対策のため、サーバ設定ファイルのパーミッションを変更してください。詳しくは、<a href='".OX_PRODUCT_DOCSURL."/wizard/lock-config' target='_blank'>こちら</a>。
  </p>
  <p><b>定期的メンテナンスタスクの設定</b><br>
        定期的なレポート送信と広告配信パフォーマンスを最高に保つためにメンテナンススクリプトを実行してください。詳しくは、<a href='".OX_PRODUCT_DOCSURL."/wizard/setup-cron' target='_blank'>こちら</a>。
  </p>
  <p><b>システム設定の再チェック</b><br>
    ".MAX_PRODUCT_NAME."で広告配信を開始する前に、'セッティング'タブをクリックしてシステム設定をチェックしてください。
  </p>
</div>";
$GLOBALS['strInstallNotSuccessful']         		= "<b>".MAX_PRODUCT_NAME."のインストールは失敗</b>しました。<br /><br />インストールプロセスのいくつかが正常に完了しませんでした。
　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　  　　　　　これらの問題は一時的なものと推定されるため、<b>続行する</b>をクリックし、インストールを再実行してください。
                                                                                                　　　　　表示されたエラーメッセージの内容の詳細と解決方法を調べたい場合、提供するドキュメントを熟読してください。";

$GLOBALS['strSystemCheck']                  		= "システムチェック";
$GLOBALS['strSystemCheckIntro']             		= "インストールウィザードは、インストールプロセスを確実に完了させるためのサーバ設定項目をチェックしました。
<p>インストールプロセスを完了するには、強調表示された項目をチェックしてください。</p>";
$GLOBALS['strDbSuccessIntro']               		= MAX_PRODUCT_NAME . "用のデータベースが作成されました。" . MAX_PRODUCT_NAME . "用の管理者設定と配信設定を継続するには、'続行する'ボタンをクリックしてください。";
$GLOBALS['strDbSuccessIntroUpgrade']        		= "システムのアップデートが完了しました。アップデート後のADサーバ設定変更のを続いて表示します。";
$GLOBALS['strErrorOccured']                 		= "次のエラーが発生しました:";
$GLOBALS['strErrorInstallDatabase']         		= "データベースを構築できませんでした。";
$GLOBALS['strErrorInstallPrefs']            		= "管理者用ユーザプリファレンスをデータベースに保存できませんでした。";
$GLOBALS['strErrorInstallVersion']          		= "システムのバージョン番号をデータベースに保存できませんでした。";
$GLOBALS['strErrorUpgrade']                 		= '既存のデータベースをアップグレードできませんでした。';
$GLOBALS['strErrorInstallDbConnect']        		= "データベース接続を開始できませんでした。";

$GLOBALS['strErrorWritePermissions']        		= "ファイルのパーミッションエラーが検出されました。継続するには、指定ファイルのパーミッションを変更してください。<br />Linux系のシステムでは、以下のコマンドを入力してください。:";
$GLOBALS['strErrorFixPermissionsCommand']   		= "<i>chmod a+w %s</i>";
$GLOBALS['strErrorWritePermissionsWin']     		= "ファイルのパーミッションエラーが検出されました。継続するには、指定ファイルのパーミッションを変更してください。";
$GLOBALS['strCheckDocumentation']           		= "詳しくは、<a href=\"".OX_PRODUCT_DOCSURL."\">" . MAX_PRODUCT_NAME . " ドキュメントa/>を参照してください。";

$GLOBALS['strAdminUrlPrefix']               		= "管理者画面URL";
$GLOBALS['strDeliveryUrlPrefix']            		= "配信エンジンURL";
$GLOBALS['strDeliveryUrlPrefixSSL']         		= "配信エンジンURL(SSL)";
$GLOBALS['strImagesUrlPrefix']              		= "画像ストレージURL";
$GLOBALS['strImagesUrlPrefixSSL']           		= "画像ストレージURL(SSL)";

$GLOBALS['strInvalidUserPwd']               		= "ユーザ名とパスワードが正しくありません。";

$GLOBALS['strUpgrade']                      		= "アップデート";
$GLOBALS['strSystemUpToDate']               		= "システムは最新情報に保たれているため、アップデートは不要です。<br />トップページに戻るには、<b>続行する</b>をクリックしてください。";
$GLOBALS['strSystemNeedsUpgrade']           		= "正常なシステム運用のために、データベース構造とシステム設定ファイルのアップデートが必要です。アップデートプロセスを開始するには、<b>続行する</b>をクリックしてください。<br /><br />バージョンアップ内容と統計データの変換処理量によって、サーバが高負荷状態になる場合があります。アップデートに数分を要する場合がありますが、しばらくお待ちください。";
$GLOBALS['strSystemUpgradeBusy']            		= "システムのアップデート中です。しばらくお待ちください...";
$GLOBALS['strSystemRebuildingCache']        		= "キャッシュの再構築中です。しばらくお待ちください...";
$GLOBALS['strServiceUnavalable']            		= "現在、システムのアップデート中のため、サービスは一時的に利用できません。";

/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']                         = 'セクションの選択';
$GLOBALS['strEditConfigNotPossible']                 = 'システム設定ファイルがセキュリティー上の理由でロックされているので、これらの項目は編集できません。' .
                                                       '編集するには最初にシステム設定ファイルのパーミッションを変更してください。';
$GLOBALS['strEditConfigPossible']                    = 'システム設定ファイルがロックされていないので全項目が編集できます。セキュリティ問題誘発の危険性があります。<br />' .
                                                       'システムを安全にしたければ、システム設定ファイルのパーミッションを書き込み不可にしてファイルをロックしてください。';
$GLOBALS['strUnableToWriteConfig']                   = 'システム設定ファイルが書き込み禁止になっています。';
$GLOBALS['strUnableToWritePrefs']                    = 'データベースにプリファレンス内容を反映できません。';
$GLOBALS['strImageDirLockedDetected']	             = "指定した<b>画像ストレージ</b>への書き込みができません。<br>ディレクトリのパーミッションを変更するか、新しくディレクトリを作成してください。";

// Configuration Settings
$GLOBALS['strConfigurationSetup']                    = 'システム設定チェックリスト';
$GLOBALS['strConfigurationSettings']                 = 'システム設定内容';

// Administrator Settings
$GLOBALS['strAdministratorSettings']                 = '管理者設定';
$GLOBALS['strAdministratorAccount']                  = '管理者アカウント';
$GLOBALS['strLoginCredentials']                      = 'ログイン情報';
$GLOBALS['strAdminUsername']                         = '管理者名';
$GLOBALS['strAdminPassword']                         = '管理者パスワード';
$GLOBALS['strInvalidUsername']                       = 'ユーザ名が無効です。';
$GLOBALS['strBasicInformation']                      = '基本情報';
$GLOBALS['strAdminFullName']                         = 'フルネーム';
$GLOBALS['strAdminEmail']                            = 'メールアドレス';
$GLOBALS['strAdministratorEmail']                    = 'システム管理者のメールアドレス';
$GLOBALS['strCompanyName']                           = '法人名';
$GLOBALS['strAdminCheckUpdates']                     = 'アップデートの確認';
$GLOBALS['strAdminCheckEveryLogin']                  = 'ログイン毎';
$GLOBALS['strAdminCheckDaily']                       = '毎日';
$GLOBALS['strAdminCheckWeekly']                      = '毎週';
$GLOBALS['strAdminCheckMonthly']                     = '毎月';
$GLOBALS['strAdminCheckNever']                       = '更新しない';
$GLOBALS['strNovice']								 = '管理者を削除する場合必ず確認する';
$GLOBALS['strUserlogEmail']                          = '電子メールの送信をロギングする';
$GLOBALS['strEnableDashboard']                       = "ダッシュボードを有効にする";
$GLOBALS['strTimezone']                              = "タイムゾーン";
$GLOBALS['strTimezoneEstimated']                     = "検出タイムゾーン";
$GLOBALS['strTimezoneGuessedValue']                  = "サーバのタイムゾーンがPHPで正しく設定されていません";
$GLOBALS['strTimezoneSeeDocs']                       = "PHPでタイムゾーンを設定するには%DOCS% を参照してください。";
$GLOBALS['strTimezoneDocumentation']                 = "ドキュメント";
$GLOBALS['strLoginSettingsTitle']                    = "管理者ログイン画面";
$GLOBALS['strLoginSettingsIntro']                    = "アップデートプロセスを継続するには" . MAX_PRODUCT_NAME . "管理者ログイン画面にログインしてください。";
$GLOBALS['strAdminSettingsTitle']                    = "管理者アカウントの作成";
$GLOBALS['strAdminSettingsIntro']                    = "管理者アカウントを作成するためにこのフォーム入力を完了してください。";
$GLOBALS['strConfigSettingsIntro']                   = "システム設定内容を変更し、アップデート継続に必要な設定変更を行ってください。";

$GLOBALS['strEnableAutoMaintenance']	             = "定期メンテナンスが設定されていない場合、配信中に定期的なメンテナンスを自動実行する。";

// OpenX ID Settings
$GLOBALS['strOpenadsUsername']                       = MAX_PRODUCT_NAME . " ユーザ名";
$GLOBALS['strOpenadsPassword']                       = MAX_PRODUCT_NAME . " パスワード";
$GLOBALS['strOpenadsEmail']                          = MAX_PRODUCT_NAME . " メールアドレス";

// Database Settings
$GLOBALS['strDatabaseSettings']                      = 'データベース設定';
$GLOBALS['strDatabaseServer']                        = 'データベースサーバ設定';
$GLOBALS['strDbLocal']                               = 'ソケットを使用してローカルサーバーに接続'; // Pg only
$GLOBALS['strDbType']                                = 'データベースタイプ';
$GLOBALS['strDbHost']                                = 'ホスト名';
$GLOBALS['strDbSocket']                              = 'DBソケット';
$GLOBALS['strDbPort']                                = 'ポートNo';
$GLOBALS['strDbUser']                                = 'ユーザ名';
$GLOBALS['strDbPassword']                            = 'パスワード';
$GLOBALS['strDbName']                                = 'データベース名';
$GLOBALS['strDatabaseOptimalisations']               = 'データベース最適化設定';
$GLOBALS['strPersistentConnections']                 = 'パーシスタント接続';
$GLOBALS['strCantConnectToDb']                       = 'データベースに接続できません';
$GLOBALS['strDemoDataInstall']                       = 'デモデータのインストール';
$GLOBALS['strDemoDataIntro']                         = 'オンライン広告配信サービス開始時に' . MAX_PRODUCT_NAME . 'のデモデータをインストールします。 テストキャンペーン用にいくつかのバナータイプがインストール＆設定されます。初回インストールの場合、デモインストールすることを強くお勧めします。';

// Email Settings
$GLOBALS['strEmailSettings']                         = 'メール設定';
$GLOBALS['strEmailAddresses']                        = '住所';
$GLOBALS['strEmailFromName']                         = '"From"氏名';
$GLOBALS['strEmailFromAddress']                      = '"From"メールアドレス';
$GLOBALS['strEmailFromCompany']                      = '"From"会社名';
$GLOBALS['strQmailPatch']                            = 'qmailパッチ';
$GLOBALS['strEnableQmailPatch']                      = 'qmailパッチを有効にする';
$GLOBALS['strEmailHeader']                           = 'メールヘッダー';
$GLOBALS['strEmailLog']                              = 'メールログ';

// Audit Trail Settings
$GLOBALS['strAudit']                                 = '追跡記録設定';
$GLOBALS['strEnableAudit']                           = '追跡記録を有効にする';

// Debug Logging Settings
$GLOBALS['strDebug']                                 = 'デバッグ用ロギング設定';
$GLOBALS['strProduction']                            = '製品版サーバ';
$GLOBALS['strEnableDebug']                           = 'デバッグ記録を有効にする';
$GLOBALS['strDebugMethodNames']                      = 'デバッグログにメソッド名を含める';
$GLOBALS['strDebugLineNumbers']                      = 'デバッグログに行番号を含める';
$GLOBALS['strDebugType']                             = 'デバッグログタイプ';
$GLOBALS['strDebugTypeFile']                         = 'ファイル';
$GLOBALS['strDebugTypeMcal']                         = 'mCal';
$GLOBALS['strDebugTypeSql']                          = 'SQLデータベース';
$GLOBALS['strDebugTypeSyslog']                       = 'SYSLOG';
$GLOBALS['strDebugName']                             = '保存ファイル名';
$GLOBALS['strDebugPriority']                         = 'デバッグレベル';
$GLOBALS['strPEAR_LOG_DEBUG']                        = 'PEAR_LOG_DEBUG（明細）';
$GLOBALS['strPEAR_LOG_INFO']                         = 'PEAR_LOG_INFO（デフォルト）';
$GLOBALS['strPEAR_LOG_NOTICE']                       = 'PEAR_LOG_NOTICE';
$GLOBALS['strPEAR_LOG_WARNING']                      = 'PEAR_LOG_WARNING';
$GLOBALS['strPEAR_LOG_ERR']                          = 'PEAR_LOG_ERR';
$GLOBALS['strPEAR_LOG_CRIT']                         = 'PEAR_LOG_CRIT';
$GLOBALS['strPEAR_LOG_ALERT']                        = 'PEAR_LOG_ALERT';
$GLOBALS['strPEAR_LOG_EMERG']                        = 'PEAR_LOG_EMERG（簡易）';
$GLOBALS['strDebugIdent']                            = 'デバッグ識別情報';
$GLOBALS['strDebugUsername']                         = 'ユーザ名(mCal,SQL)';
$GLOBALS['strDebugPassword']                         = 'パスワード(mCal,SQL)';

// Delivery Settings
$GLOBALS['strDeliverySettings']                      = '配信設定';
$GLOBALS['strWebPath']                               = MAX_PRODUCT_NAME . 'へのアクセスパス';
$GLOBALS['strWebPathSimple']                         = 'Webアクセス';
$GLOBALS['strDeliveryPath']                          = '配信アクセス';
$GLOBALS['strImagePath']                             = '画像アクセス';
$GLOBALS['strDeliverySslPath']                       = '配信アクセス（SSL）';
$GLOBALS['strImageSslPath']                          = '画像アクセス（SSL）';
$GLOBALS['strImageStore']                            = '画像ストレージ用ディレクトリ';
$GLOBALS['strTypeWebSettings']                       = 'ローカルバナー保存設定';
$GLOBALS['strTypeWebMode']                           = '保存方法';
$GLOBALS['strTypeWebModeLocal']                      = 'ローカルディレクトリ';
$GLOBALS['strTypeDirError']                          = '指定ディレクトリに対する書き込み権限がありません';
$GLOBALS['strTypeWebModeFtp']                        = '外部FTPサーバ';
$GLOBALS['strTypeWebDir']                            = 'ローカルディレクトリ';
$GLOBALS['strTypeFTPHost']                           = 'FTPホスト名';
$GLOBALS['strTypeFTPDirectory']                      = 'ホストディレクトリ';
$GLOBALS['strTypeFTPUsername']                       = 'FTPログイン名';
$GLOBALS['strTypeFTPPassword']                       = 'FTPパスワード';
$GLOBALS['strTypeFTPPassive']                        = 'パッシブ接続を使用する';
$GLOBALS['strTypeFTPErrorDir']                       = '指定ホスト内に指定ディレクトリは存在しません。';
$GLOBALS['strTypeFTPErrorConnect']                   = '指定サーバに接続できません。ログイン名かパスワードが間違っています。';
$GLOBALS['strTypeFTPErrorNoSupport']                 = 'PHPがFTPをサポートしていません。';
$GLOBALS['strTypeFTPErrorHost']                      = '指定ホストに接続できません。';
$GLOBALS['strDeliveryFilenames']                     = '配信チェックファイル';
$GLOBALS['strDeliveryFilenamesAdClick']              = 'クリック';
$GLOBALS['strDeliveryFilenamesAdConversionVars']     = 'コンバージョン変数';
$GLOBALS['strDeliveryFilenamesAdContent']            = 'コンテンツ';
$GLOBALS['strDeliveryFilenamesAdConversion']         = 'コンバージョン';
$GLOBALS['strDeliveryFilenamesAdConversionJS']       = 'コンバージョン(JavaScript)';
$GLOBALS['strDeliveryFilenamesAdFrame']              = 'iFrame';
$GLOBALS['strDeliveryFilenamesAdImage']              = '画像';
$GLOBALS['strDeliveryFilenamesAdJS']                 = 'JavaScript';
$GLOBALS['strDeliveryFilenamesAdLayer']              = 'レイヤー';
$GLOBALS['strDeliveryFilenamesAdLog']                = 'ログ';
$GLOBALS['strDeliveryFilenamesAdPopup']              = 'ポップアップ';
$GLOBALS['strDeliveryFilenamesAdView']               = 'ビュー';
$GLOBALS['strDeliveryFilenamesXMLRPC']               = 'XML-RPC呼出';
$GLOBALS['strDeliveryFilenamesLocal']                = 'ローカル呼出';
$GLOBALS['strDeliveryFilenamesFrontController']      = 'フロントコントローラー';
$GLOBALS['strDeliveryFilenamesFlash']                = 'Flashインクルード(URL指定可)';
$GLOBALS['strDeliveryCaching']                       = '配信キャッシュ設定';
$GLOBALS['strDeliveryCacheLimit']                    = 'キャッシュ更新間隔(秒)';

$GLOBALS['strOrigin']                                = 'リモートサーバの使用';
$GLOBALS['strOriginType']                            = 'サーバタイプ';
$GLOBALS['strOriginHost']                            = 'ホスト名';
$GLOBALS['strOriginPort']                            = 'ポートNo';
$GLOBALS['strOriginScript']                          = 'スクリプト名(グローバルパス)';
$GLOBALS['strOriginTypeXMLRPC']                      = 'XMLRPC';
$GLOBALS['strOriginTimeout']                         = 'タイムアウト時間(秒)';
$GLOBALS['strOriginProtocol']                        = '接続プロトコル';

$GLOBALS['strDeliveryAcls']                          = '広告配信中のバナー配信フィルタリングを実施する';
$GLOBALS['strDeliveryObfuscate']                     = '広告配信中のチャネル制御を行わない';
$GLOBALS['strDeliveryExecPhp']                       = '配信バナーに実行可能なPHPコードを許容する<br />(警告:セキュリティリスクを伴います)';
$GLOBALS['strDeliveryCtDelimiter']                   = '他社クリック追跡用デリミタ';
$GLOBALS['strP3PSettings']                           = 'P3Pプライバシポリシー';
$GLOBALS['strUseP3P']                                = 'P3Pポリシーを使用する';
$GLOBALS['strP3PCompactPolicy']                      = 'P3Pコンパクトポリシー';
$GLOBALS['strP3PPolicyLocation']                     = 'P3Pポリシーロケーション';

// General Settings
$GLOBALS['generalSettings']                          = '全般設定';
$GLOBALS['uiEnabled']                                = 'ユーザ画面を有効にする';
$GLOBALS['defaultLanguage']                          = 'デフォルト言語設定';

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings']                  = '地域特定設定';
$GLOBALS['strGeotargeting']                          = '地域特定設定';
$GLOBALS['strGeotargetingType']                      = '地域特定用モジュールタイプ';
$GLOBALS['strGeotargetingUseBundledCountryDb']       = 'バンドル済のMaxMind GeoLite国別データベースを使用する';
$GLOBALS['strGeotargetingGeoipCountryLocation']      = 'MaxMind GeoIP 国データベース保存先';
$GLOBALS['strGeotargetingGeoipRegionLocation']       = 'MaxMind GeoIP 地域データベース保存先';
$GLOBALS['strGeotargetingGeoipCityLocation']         = 'MaxMind GeoIP 都市データベース保存先';
$GLOBALS['strGeotargetingGeoipAreaLocation']         = 'MaxMind GeoIP エリアデータベース保存先';
$GLOBALS['strGeotargetingGeoipDmaLocation']          = 'MaxMind GeoIP DMAデータベース保存先';
$GLOBALS['strGeotargetingGeoipOrgLocation']          = 'MaxMind GeoIP 組織データベース保存先';
$GLOBALS['strGeotargetingGeoipIspLocation']          = 'MaxMind GeoIP ISPデータベース保存先';
$GLOBALS['strGeotargetingGeoipNetspeedLocation']     = 'MaxMind GeoIP ネット速度データベース保存先';
$GLOBALS['strGeoSaveStats']                          = 'ログファイルに地域特定結果を保存する';
$GLOBALS['strGeoShowUnavailable']                    = 'GeoIPデータが存在しなくても地域特定による配信制限を実行する';
$GLOBALS['strGeotrackingGeoipCountryLocationError']  = 'MaxMind GeoIP 国データベースが指定ディレクトリに存在しません。';
$GLOBALS['strGeotrackingGeoipRegionLocationError']   = 'MaxMind GeoIP 地域データベースが指定ディレクトリに存在しません。';
$GLOBALS['strGeotrackingGeoipCityLocationError']     = 'MaxMind GeoIP 都市データベースが指定ディレクトリに存在しません。';
$GLOBALS['strGeotrackingGeoipAreaLocationError']     = 'MaxMind GeoIP エリアデータベースが指定ディレクトリに存在しません。';
$GLOBALS['strGeotrackingGeoipDmaLocationError']      = 'MaxMind GeoIP DMAデータベースが指定ディレクトリに存在しません。';
$GLOBALS['strGeotrackingGeoipOrgLocationError']      = 'MaxMind GeoIP 組織データベースが指定ディレクトリに存在しません。';
$GLOBALS['strGeotrackingGeoipIspLocationError']      = 'MaxMind GeoIP ISPデータベースが指定ディレクトリに存在しません。';
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = 'MaxMind GeoIP ネット速度データベースが指定ディレクトリに存在しません。';

// Interface Settings
$GLOBALS['strInventory']                             = '広告在庫';
$GLOBALS['strUploadConversions']                     = 'コンバージョンのアップロード';
$GLOBALS['strShowCampaignInfo']                      = '<i>キャンペーン概要</i>のページにキャンペーン明細情報を表示する';
$GLOBALS['strShowBannerInfo']                        = '<i>バナー概要</i>ページにバナー明細情報を表示する';
$GLOBALS['strShowCampaignPreview']                   = '<i>バナー概要</i>ページにバナープレビューを表示する';
$GLOBALS['strShowBannerHTML']                        = 'HTMLバナーはHTMLコードに代えてプレビューを表示する';
$GLOBALS['strShowBannerPreview']                     = 'バナープレビューをページトップに表示する';
$GLOBALS['strHideInactive']                          = '概要ページで未活動アイテムを隠す';
$GLOBALS['strGUIShowMatchingBanners']                = '<i>リンク済バナー</i>ページではリンク先バナーを表示する';
$GLOBALS['strGUIShowParentCampaigns']                = '<i>リンク済バナー</i>ページでは親キャンペーンを表示する';
$GLOBALS['strGUIAnonymousCampaignsByDefault']        = 'デフォルトキャンペーンを任意にする';
$GLOBALS['strStatisticsDefaults']                    = '統計';
$GLOBALS['strBeginOfWeek']                           = '週の開始曜日';
$GLOBALS['strPercentageDecimals']                    = '％の小数点表示桁数';
$GLOBALS['strWeightDefaults']                        = 'デフォルト配信ウェイト';
$GLOBALS['strDefaultBannerWeight']                   = 'バナー用配信ウェイト';
$GLOBALS['strDefaultCampaignWeight']                 = 'キャンペーン用配信ウェイト';
$GLOBALS['strDefaultBannerWErr']                     = 'バナー用配信ウェイトには正の整数を入力してください。';
$GLOBALS['strDefaultCampaignWErr']                   = 'キャンペーン用配信ウェイトには正の整数を入力してください。';
$GLOBALS['strConfirmationUI']                        = '変更の確認';

$GLOBALS['strPublisherDefaults']                     = 'Webサイトデフォルト設定';
$GLOBALS['strModesOfPayment']                        = '支払モード';
$GLOBALS['strCurrencies']                            = '現金';
$GLOBALS['strCategories']                            = 'カテゴリ';
$GLOBALS['strHelpFiles']                             = 'ヘルプファイルロケーション(契約条件)';
$GLOBALS['strHasTaxID']                              = '納税者番号';
$GLOBALS['strDefaultApproved']                       = 'チェックボックスを承諾済みにする';

// CSV Import Settings
$GLOBALS['strChooseAdvertiser']                      = '広告主';
$GLOBALS['strChooseCampaign']                        = 'キャンペーン';
$GLOBALS['strChooseCampaignBanner']                  = 'バナー';
$GLOBALS['strChooseTracker']                         = 'トラッカー';
$GLOBALS['strDefaultConversionStatus']               = 'デフォルトコンバージョンステータス';
$GLOBALS['strDefaultConversionType']                 = 'デフォルトコンバージョンタイプ';
$GLOBALS['strCSVTemplateSettings']                   = 'CSVテンプレート設定';
$GLOBALS['strIncludeCountryInfo']                    = '国別情報';
$GLOBALS['strIncludeBrowserInfo']                    = 'ブラウザ情報';
$GLOBALS['strIncludeOSInfo']                         = 'OS情報';
$GLOBALS['strIncludeSampleRow']                      = 'サンプル行';
$GLOBALS['strCSVTemplateAdvanced']                   = '拡張テンプレート';
$GLOBALS['strCSVTemplateIncVariables']               = 'トラッカー変数';

/**
 * @todo remove strBannerSettings if banner is only configurable as a preference
 *       rename // Banner Settings to  // Banner Preferences
 */
// Invocation Settings
$GLOBALS['strAllowedInvocationTypes']                = '許容呼出タイプ';
$GLOBALS['strInvocationDefaults']                    = 'デフォルト呼出設定';
$GLOBALS['strEnable3rdPartyTrackingByDefault']       = 'デフォルトで他社クリック追跡を有効にする';

// Banner Delivery Settings
$GLOBALS['strBannerDelivery']                        = 'バナー配信設定';

// Banner Logging Settings
$GLOBALS['strBannerLogging']                         = 'バナー設定';
$GLOBALS['strLogAdRequests']                         = "バナー要求毎に'リクエスト'として記録する";
$GLOBALS['strLogAdImpressions']                      = "バナー閲覧毎に'インプレッション'として記録する";
$GLOBALS['strLogAdClicks']                           = "バナークリック毎に'クリック'として記録する";
$GLOBALS['strLogTrackerImpressions']                 = "追跡用ビーコン参照毎に'追跡インプレッション'として記録する";
$GLOBALS['strReverseLookup']                         = 'ホスト情報が得られない場合、ホスト情報を逆引きする';
$GLOBALS['strProxyLookup']                           = 'プロキシサーバ経由の場合、実IPアドレスを探索する';
$GLOBALS['strSniff']                                 = 'phpShiffを使用して、OSやブラウザの情報を解析する';
$GLOBALS['strPreventLogging']                        = 'バナー記録制限設定';
$GLOBALS['strIgnoreHosts']                           = '指定IPアドレスや指定ホストからのアクセス結果を記録しない';
$GLOBALS['strIgnoreUserAgents']                      = 'ユーザエージェント内に指定キーワード（1行内）がある場合記録しない';
$GLOBALS['strEnforceUserAgents']                     = 'ユーザエージェント内に指定キーワード（1行内）がある場合のみ記録する';

// Banner Storage Settings
$GLOBALS['strBannerStorage']                         = 'バナーストレージ設定';

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings']                   = 'メンテナンス設定';
$GLOBALS['strConversionTracking']                    = 'コンバージョン追跡設定';
$GLOBALS['strEnableConversionTracking']              = 'コンバージョン追跡を有効にする';
$GLOBALS['strCsvImport']                             = 'オフラインコンバージョンのアップロードを許可する';
$GLOBALS['strBlockAdViews']                          = '指定秒数内のビューはインプレッション数にカウントしない(秒)';
$GLOBALS['strBlockAdViewsError']                     = 'インプレッションのブロック秒数に負の整数は使用できません。';
$GLOBALS['strBlockAdClicks']                         = '指定秒数内のクリックはクリック数にカウントしない(秒)';
$GLOBALS['strBlockAdClicksError']                    = 'クリックのブロック秒数に負の整数は使用できません。';
$GLOBALS['strMaintenanceOI']                         = 'メンテナンスオペレーション間隔(分)';
$GLOBALS['strMaintenanceOIError']                    = 'メンテナンスオペレーション間隔が正しくありません - 正しい値はドキュメントを参照してください。';
$GLOBALS['strMaintenanceCompactStats']               = '統計処理後はデータを削除する';
$GLOBALS['strMaintenanceCompactStatsGrace']          = '統計データ削除までの猶予時間(秒)';
$GLOBALS['strPrioritySettings']                      = '優先度の設定';
$GLOBALS['strPriorityInstantUpdate']                 = '優先度の変更と同時に広告の優先度も更新する';
$GLOBALS['strWarnCompactStatsGrace']                 = '統計データ削除猶予時間には正の整数を入力してください';
$GLOBALS['strDefaultImpConWindow']                   = 'デフォルトインプレッションカウント秒数(秒)';
$GLOBALS['strDefaultImpConWindowError']              = 'デフォルトインプレッションカウント秒数には正の整数を入力してください。';
$GLOBALS['strDefaultCliConWindow']                   = 'デフォルトクリックカウント秒数(秒)';
$GLOBALS['strDefaultCliConWindowError']              = 'デフォルトクリックカウント秒数には正の整数を入力してください。';
$GLOBALS['strAdminEmailHeaders']                     = 'リポート送信メールの先頭に以下のメッセージを追加する';
$GLOBALS['strWarnLimit']                             = 'インプレッション残数が一定以上の場合、警告メールを送信する';
$GLOBALS['strWarnLimitErr']                          = '警告メール送信時のインプレッション残数は正の整数を入力してください。';
$GLOBALS['strWarnLimitDays']                         = '到来期日以内になると警告メールを送信する';
$GLOBALS['strWarnLimitDaysErr']                      = '警告メール送信時の到来期日は、正の整数を入力してください。';
$GLOBALS['strAllowEmail']                            = 'メールの送信を全体的に許可する';
$GLOBALS['strEmailAddressFrom']                      = 'レポート送信時のFromメールアドレス';
$GLOBALS['strEmailAddressName']                      = 'メール送信時に追記する会社名か個人名';
$GLOBALS['strWarnAdmin']                             = 'キャンペーン終了間際に管理者に警告メールを送信する';
$GLOBALS['strWarnClient']                            = 'キャンペーン終了間際に広告主に警告メールを送信する';
$GLOBALS['strWarnAgency']                            = 'キャンペーン終了間際に代理店に警告メールを送信する';

// UI Settings
$GLOBALS['strGuiSettings']                           = 'ユーザ画面設定';
$GLOBALS['strGeneralSettings']                       = '全般設定';
$GLOBALS['strAppName']                               = 'アプリケーション名';
$GLOBALS['strMyHeader']                              = 'ヘッダーファイルの保存場所';
$GLOBALS['strMyHeaderError']                         = '指定した保存場所にヘッダーファイルが存在しません。';
$GLOBALS['strMyFooter']                              = 'フッターファイルの保存場所';
$GLOBALS['strMyFooterError']                         = '指定した保存場所にフッターファイルが存在しません。';
$GLOBALS['strDefaultTrackerStatus']                  = 'デフォルトトラッカーステータス';
$GLOBALS['strDefaultTrackerType']                    = 'デフォルトトラッカータイプ';
$GLOBALS['strSSLSettings']                           = 'SSL設定';
$GLOBALS['requireSSL']                               = 'ユーザ画面利用時は強制的にSSLにする';
$GLOBALS['sslPort']                                  = 'SSL用ポートNo';

$GLOBALS['strMyLogo']                                = 'カスタムロゴファイルのファイル名';
$GLOBALS['strMyLogoError']                           = 'admin/imagesディレクトリに指定したロゴファイルが存在しません。';
$GLOBALS['strGuiHeaderForegroundColor']              = 'ヘッダーの前景色';
$GLOBALS['strGuiHeaderBackgroundColor']              = 'ヘッダーの背景色';
$GLOBALS['strGuiActiveTabColor']                     = 'アクティブタグの強調色';
$GLOBALS['strGuiHeaderTextColor']                    = 'ヘッダー内の文字色';
$GLOBALS['strColorError']                            = '色指定は、RGBフォーマットで入力してください。例：\'0066CC\'';

$GLOBALS['strGzipContentCompression']                = 'GZIPコンテンツ圧縮を使用する';
$GLOBALS['strClientInterface']                       = '広告主用画面表示';
$GLOBALS['strReportsInterface']                      = 'レポート用画面表示';
$GLOBALS['strClientWelcomeEnabled']                  = '広告主用ウェルカムメッセージを有効にする';
$GLOBALS['strClientWelcomeText']                     = 'ウェルカムメッセージテキスト<br />(HTMLタグも有効)';

$GLOBALS['strPublisherInterface']                    = 'サイトオーナー用画面表示';
$GLOBALS['strPublisherAgreementEnabled']             = '契約条件を承認していないサイトオーナーにもログイン制御を許可する';
$GLOBALS['strPublisherAgreementText']                = 'ログイン時のメッセージテキスト(HTMLタグも有効)';


/*-------------------------------------------------------*/
/* Unknown (unused?) translations                        */
/*-------------------------------------------------------*/

$GLOBALS['strExperimental']                 = "実験中";
$GLOBALS['strKeywordRetrieval']             = "キーワード検索";
$GLOBALS['strBannerRetrieval']              = "バナー検索メソッド";
$GLOBALS['strRetrieveRandom']               = "ランダムバナー検索 (default)";
$GLOBALS['strRetrieveNormalSeq']            = "ノーマルなシーケンシャルバナー検索";
$GLOBALS['strWeightSeq']                    = "ウェイトベースのシーケンシャルバナー検索";
$GLOBALS['strFullSeq']                      = "フルシーケンシャルバナー検索";
$GLOBALS['strUseKeywords']                  = "バナー選択用キーワードを使用する";
$GLOBALS['strUseConditionalKeys']           = "ダイレクト選択使用時に論理式を許可する";
$GLOBALS['strUseMultipleKeys']              = "ダイレクト選択使用時にマルチキーワードを許容する";

$GLOBALS['strTableBorderColor']             = "テーブルの境界色";
$GLOBALS['strTableBackColor']               = "テーブルの背景色";
$GLOBALS['strTableBackColorAlt']            = "テーブルの背景色（代替）";
$GLOBALS['strMainBackColor']                = "メイン背景色";
$GLOBALS['strOverrideGD']                   = "GDイメージフォーマットを上書きする";
$GLOBALS['strTimeZone']                     = "タイムゾーン";

?>
