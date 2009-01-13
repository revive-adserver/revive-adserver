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
$GLOBALS['strAlreadyInstalled']             		= "". MAX_PRODUCT_NAME ." は既にインストールされています。設定したい場合は<a href='account-index.php'>設定インターフェース</a>に行ってください";
$GLOBALS['strCouldNotConnectToDB']          		= "データベースに接続できませんでした。データベース設定を再確認してください。";
$GLOBALS['strCreateTableTestFailed']        		= "指定されたユーザーは、データベースの作成もしくは更新権限がありません。データベース管理者に連絡してください。";
$GLOBALS['strUpdateTableTestFailed']        		= "指定されたユーザーは、データベースの更新権限を持っていません。データベース管理者に連絡してください。";
$GLOBALS['strTablePrefixInvalid']           		= "指定したテーブルプリフィックスには、無効な文字が含まれています。";
$GLOBALS['strTableInUse']                   		= "指定したデータベースは、".MAX_PRODUCT_NAME."で既に使用されています。異なるテーブルプリフィックスを使用するか、アップグレードするか、アップグレード手順を記載したUPGRADE.txtを読んでください。";
$GLOBALS['strNoVersionInfo']                		= "指定したデータベースバージョンは選択できません！";
$GLOBALS['strInvalidVersionInfo']           		= "指定したデータベースのバージョンが特定できません！";
$GLOBALS['strInvalidMySqlVersion']          		= "" . MAX_PRODUCT_NAME."を正しく機能するには、MySQL 4.0以上が必要です。異なるデータベースサーバを選択してください。";
$GLOBALS['strTableWrongType']               		= "選択したテーブルタイプは、".phpAds_dbmsname."のインストールでサポートされていません。";
$GLOBALS['strMayNotFunction']               		= "継続するには、潜在的な問題を修正してください:";
$GLOBALS['strFixProblemsBefore']            		= "" . MAX_PRODUCT_NAME."をインストールする前に、次の項目を修正してください。このエラーメッセージについて何か疑問がある場合は、ダウンロードパッケージ中の<i>管理者ガイド(Administrator's Guide)</i>を読んでください。";
$GLOBALS['strFixProblemsAfter']             		= "前述の問題を修正できない場合、サーバの管理者に連絡して、".MAX_PRODUCT_NAME."のインストールで発生した問題点を伝えてください。サーバ管理者から適切な解決方法を教えてもらえるかもしれません。";
$GLOBALS['strIgnoreWarnings']               		= "警告を無視する";
$GLOBALS['strFixErrorsBeforeContinuing']    		= "継続するにはすべてのエラー内容を修正してください。";
$GLOBALS['strWarningDBavailable']           		= "使用中のPHPバージョンは、".$phpAds_dbmsname." データベースサーバへの接続をサポートしていません。次に進む前に、PHPの".$phpAds_dbmsname." 拡張を有効にしてください。";
$GLOBALS['strWarningPHPversion']            		= "" . MAX_PRODUCT_NAME."が正常に機能するには、PHP4.3.6以上が必要です。現在バージョンは、{php_version} です。";
$GLOBALS['strWarningRegisterGlobals']       		= "PHPの設定値[register_globals]を'on'にしてください";
$GLOBALS['strWarningMagicQuotesGPC']        		= "PHPの設定値[magic_quotes_gpc]を'on'にしてください";
$GLOBALS['strWarningRegisterArgcArv']       		= "PHPの設定値[register_argc_argv]を'on'にしてください";
$GLOBALS['strWarningMagicQuotesRuntime']    		= "PHPの設定値[magic_quotes_runtime]を'off'にしてください";
$GLOBALS['strWarningFileUploads']           		= "PHPの設定値[file_uploads]を'on'にしてください";
$GLOBALS['strWarningTrackVars']             		= "PHPの設定値[track_vars]を'on'にしてください";
$GLOBALS['strWarningPREG']                  		= "使用中のPHPバージョンは、Perl互換正規表現(PREG)をサポートしていません。継続するには PREG拡張を有効にしてください。";
$GLOBALS['strConfigLockedDetected']         		= "" . MAX_PRODUCT_NAME."は、<b>max.conf.ini</b>に対する書き込み権限がないことを検出しました。'var'ディレクトリに対する書き込み権限が設定されるまで、継続できません。書き込み権限の変更方法がわからない場合、提供したドキュメントを読んでください。";
$GLOBALS['strCantUpdateDB']                 		= "データベース更新ができません。 このまま継続すると、すべての既存のバナー、統計、および広告主は削除される可能性があります。";
$GLOBALS['strIgnoreErrors']                 		= "警告を無視する";
$GLOBALS['strRetryUpdate']                  		= "更新を再実行する";
$GLOBALS['strTableNames']                   		= "テーブル名";
$GLOBALS['strTablesPrefix']                 		= "テーブルプリフィックス";
$GLOBALS['strTablesType']                   		= "テーブルタイプ";

$GLOBALS['strInstallWelcome']               		= "ようこそ ". MAX_PRODUCT_NAME ."へ";
$GLOBALS['strInstallMessage']               		= "" . MAX_PRODUCT_NAME."を使用するには、システム設定とデータベースの作成が必要です。<br />継続するには、<b>進む</b> をクリックしてください。";
$GLOBALS['strInstallIntro']                 		= "当製品を選んでいただき、ありがとうございます。\n<p>このウィザードでは広告サーバのインストール及びアップグレードについて説明いたします。</p><p>インストール手順に関しては、<a href='". OX_PRODUCT_DOCSURL ."/wizard/qsg-install' target='_blank'>クイックスタートガイド</a>をご覧ください。その他、設定など詳細に関しましては<a href='". OX_PRODUCT_DOCSURL ."/wizard/admin-guide' target='_blank'>管理者ガイド</a>をご覧ください。";
$GLOBALS['strRecoveryRequiredTitle']    			= "前回のアップデートでエラーが発生";
$GLOBALS['strRecoveryRequired']         			= "前回のアップデートプロセスでエラーが発生しています。". MAX_PRODUCT_NAME ." は、アップデートプロセスの回復を試みます。以下の\'復旧する\'ボタンをクリックしてください。";
$GLOBALS['strTermsTitle']               			= "使用方法及び個人情報保護について";
$GLOBALS['strTermsIntro']               			= "". MAX_PRODUCT_NAME ."はオープンソースプロジェクトとして、GNUライセンスの元に運営されています。インストールを続けるには、以下の文書内容を確認し、承認して下さい。";
$GLOBALS['strPolicyTitle']               			= "プライバシーポリシー";
$GLOBALS['strPolicyIntro']               			= "インストールを継続するには、以下の文書内容を承諾してください。";
$GLOBALS['strDbSetupTitle']               			= "データベースの設定";
$GLOBALS['strDbSetupIntro']               			= "データベースの接続情報を入力してくださいこの点に関してわからない場合は、サーバの管理者に問い合わせてください。<p>次のステップではデータベースを設定します。次へボタンを押して続けて下さい。</p>";
$GLOBALS['strDbUpgradeIntro']             			= "以下の接続情報を検知しました。この情報が正しいかどうか確認してください。<p>次のステップではデータベースを設定します。次へボタンを押して続けて下さい。</p>";
$GLOBALS['strOaUpToDate']               			= "あなたの". MAX_PRODUCT_NAME ."は最新です！次へボタンを押して、". MAX_PRODUCT_NAME ."の管理画面へと進んでください。";
$GLOBALS['strOaUpToDateCantRemove']     			= "警告:アップデートファイルが、varディレクトリに残っています。十分な権限がないため、アップデートファイルを削除できませんでした。このファイルを自分自身の手で削除してください。";
$GLOBALS['strRemoveUpgradeFile']            		= "varディレクトリ内にあるUPGRADEファイルを削除してください。";
$GLOBALS['strInstallSuccess']               		= "\'次へ'ボタンを押して、アドサーバーへログインしてください。	<p><strong>次にやることは？</strong></p>	<div class='psub'>	  <p><b></b><br>	    最新の情報を入手するために、<a href='". OX_PRODUCT_DOCSURL ."/wizard/join' target='_blank'>". MAX_PRODUCT_NAME ." メーリングリスト</a>に参加して下さい。 	  </p>	  <p><b>初めてのキャンペーンの作り方</b><br>	    <a href='". OX_PRODUCT_DOCSURL ."/wizard/qsg-firstcampaign' target='_blank'>クイックスタートガイド</a>を参照してください。	  </p>	</div>	<p><strong>インストール手順（補足）</strong></p>	<div class='psub'>	  <p><b>設定ファイルのロック</b><br>	    設定内容の書き換えを防ぐために、とても大切なことです。  <a href='". OX_PRODUCT_DOCSURL ."/wizard/lock-config' target='_blank'>詳細はこちら</a>.	  </p>	  <p><b>定期メンテナンス方法</b><br>	    ベストな配信状態、正確なレポートを作成するために、定期メンテナンスは必要です。  <a href='". OX_PRODUCT_DOCSURL ."/wizard/setup-cron' target='_blank'>詳細はこちら</a>	  </p>	  <p><b>設定をレビューする</b><br>	     ". MAX_PRODUCT_NAME ." を使う前に、設定内容を再確認することをお勧めします。	  </p>	</div>";
$GLOBALS['strInstallNotSuccessful']         		= "<b>". MAX_PRODUCT_NAME ."のインストールに失敗しました。</b><br /><br />いくつかの項目が完了しませんでした。\nもしこの問題が一時的なものであれば、<b>こちら</b>をクリックして、\n最初に戻ってください。 エラー内容の詳細及び解決策を知りたい場合は、\nドキュメントの確認をして下さい";

$GLOBALS['strSystemCheck']                  		= "システムチェック";
$GLOBALS['strSystemCheckIntro']             		= "インストレーションウィザードはあなたのサーバの設定を確認しています。	<p>ハイライトされている箇所を確認し、最後まで完了して下さい。</p>";
$GLOBALS['strDbSuccessIntro']               		= "インストールウィザードは、プロセスが確実に完了するかどうかを確認しています。";
$GLOBALS['strDbSuccessIntroUpgrade']        		= "システムのアップグレードが成功しました。次の画面では、新しいアドサーバーの設定を説明します。";
$GLOBALS['strErrorOccured']                 		= "次のエラーが発生しました:";
$GLOBALS['strErrorInstallDatabase']         		= "データベースを構築できませんでした。";
$GLOBALS['strErrorInstallPrefs']            		= "管理者用ユーザプリファレンスをデータベースに保存できませんでした。";
$GLOBALS['strErrorInstallVersion']          		= "システムのバージョン番号をデータベースに保存できませんでした。";
$GLOBALS['strErrorUpgrade']                 		= '既存のデータベースをアップグレードできませんでした。';
$GLOBALS['strErrorInstallDbConnect']        		= "データベース接続を開始できませんでした。";

$GLOBALS['strErrorWritePermissions']        		= "ファイルのパーミッションエラーが検出されました。継続するには、指定ファイルのパーミッションを変更してください。<br />Linux系のシステムでは、以下のコマンドを入力してください。:";
$GLOBALS['strErrorFixPermissionsCommand']   		= "<i>chmod a+w %s</i>";
$GLOBALS['strErrorFixPermissionsRCommand']          = "<i>chmod -R a+w %s</i>";
$GLOBALS['strErrorWritePermissionsWin']     		= "ファイルのパーミッションエラーが検出されました。継続するには、指定ファイルのパーミッションを変更してください。";
$GLOBALS['strCheckDocumentation']           		= "詳細な情報に関しては、 <a href='". OX_PRODUCT_DOCSURL ."'>". MAX_PRODUCT_NAME ." こちら</a>をご覧下さい。";

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
$GLOBALS['strEditConfigNotPossible']                 = '設定ファイルがロックされているため、編集できません。インストール前に、設定ファイルに対し書き込み権限を付与して下さい。';
$GLOBALS['strEditConfigPossible']                    = '設定ファイルがロックされていないため、誰でも編集が可能となっています。セキュリティ上大変危険ですので、ロックするようお勧めします。';
$GLOBALS['strUnableToWriteConfig']                   = '設定ファイルに書き込む事ができませんでした。';
$GLOBALS['strUnableToWritePrefs']                    = 'データベースに設定を反映できませんでした。';
$GLOBALS['strImageDirLockedDetected']	             = "指定した<b>画像ストレージ</b>への書き込みができません。<br>ディレクトリのパーミッションを変更するか、新しくディレクトリを作成してください。";

// Configuration Settings
$GLOBALS['strConfigurationSetup']                    = '設定内容チェックリスト';
$GLOBALS['strConfigurationSettings']                 = '設定';

// Administrator Settings
$GLOBALS['strAdministratorSettings']                 = '管理者設定';
$GLOBALS['strAdministratorAccount']                  = '管理者アカウント';
$GLOBALS['strLoginCredentials']                      = 'ログインユーザ';
$GLOBALS['strAdminUsername']                         = '管理者  ユーザ名';
$GLOBALS['strAdminPassword']                         = '管理者  パスワード';
$GLOBALS['strInvalidUsername']                       = 'ユーザ名が不正です';
$GLOBALS['strBasicInformation']                      = '基本情報';
$GLOBALS['strAdminFullName']                         = '管理者氏名';
$GLOBALS['strAdminEmail']                            = '管理者メールアドレス';
$GLOBALS['strAdministratorEmail']                    = '管理者メールアドレス';
$GLOBALS['strCompanyName']                           = '会社名';
$GLOBALS['strAdminCheckUpdates']                     = 'アップデートの確認';
$GLOBALS['strAdminCheckEveryLogin']                  = 'ログイン毎';
$GLOBALS['strAdminCheckDaily']                       = '毎日';
$GLOBALS['strAdminCheckWeekly']                      = '毎週';
$GLOBALS['strAdminCheckMonthly']                     = '毎月';
$GLOBALS['strAdminCheckNever']                       = '更新しない';
$GLOBALS['strNovice']								 = 'アクションを削除する前に確認する';
$GLOBALS['strUserlogEmail']                          = '全ての送信メールの内容をログに取る';
$GLOBALS['strEnableDashboard']                       = "ダッシュボードを有効にする";
$GLOBALS['strTimezone']                              = "タイムゾーン";
$GLOBALS['strTimezoneEstimated']                     = "検出タイムゾーン";
$GLOBALS['strTimezoneGuessedValue']                  = "サーバのタイムゾーンがPHPで正しく設定されていません";
$GLOBALS['strTimezoneSeeDocs']                       = "PHPでタイムゾーンを設定するには%DOCS% を参照してください。";
$GLOBALS['strTimezoneDocumentation']                 = "ドキュメント";
$GLOBALS['strLoginSettingsTitle']                    = "管理者ログイン画面";
$GLOBALS['strLoginSettingsIntro']                    = "アップデートプロセスを継続するには ". MAX_PRODUCT_NAME ." 管理者ログイン画面にログインしてください。";
$GLOBALS['strAdminSettingsTitle']                    = "管理者アカウントの作成";
$GLOBALS['strAdminSettingsIntro']                    = "管理者アカウントを作成するためにフォームの入力を完了してください。";
$GLOBALS['strConfigSettingsIntro']                   = "下記設定内容を確認してください。もし明確でない場合は、デフォルトのままにしておいて下さい。";

$GLOBALS['strEnableAutoMaintenance']	             = "定期メンテナンスが設定されていない場合、配信中に定期的なメンテナンスを自動実行する。";

// OpenX ID Settings
$GLOBALS['strOpenadsUsername']                       = "". MAX_PRODUCT_NAME ." ユーザ名";
$GLOBALS['strOpenadsPassword']                       = "". MAX_PRODUCT_NAME ." パスワード";
$GLOBALS['strOpenadsEmail']                          = "". MAX_PRODUCT_NAME ." Eメール";

// Database Settings
$GLOBALS['strDatabaseSettings']                      = 'データベース設定';
$GLOBALS['strDatabaseServer']                        = 'グローバルデータベースサーバ設定';
$GLOBALS['strDbLocal']                               = 'ソケットを使う'; // Pg only
$GLOBALS['strDbType']                                = 'データベースのタイプ';
$GLOBALS['strDbHost']                                = 'データベースのホスト名';
$GLOBALS['strDbSocket']                              = 'データベースソケット';
$GLOBALS['strDbPort']                                = 'データベースのポート番号';
$GLOBALS['strDbUser']                                = 'データベースのユーザ名';
$GLOBALS['strDbPassword']                            = 'データベースのパスワード';
$GLOBALS['strDbName']                                = 'データベース名';
$GLOBALS['strDatabaseOptimalisations']               = 'データベース最適化設定';
$GLOBALS['strPersistentConnections']                 = '持続的にデータベースに接続する';
$GLOBALS['strCantConnectToDb']                       = 'データベースに接続できません';
$GLOBALS['strDemoDataInstall']                       = 'デモデータをインストールする';
$GLOBALS['strDemoDataIntro']                         = '設定のサンプルデータを". '.MAX_PRODUCT_NAME.' ."にインストールすることができます。通常使用されるキャンペーン及びバナーも設定できるので、インストールすることを薦めます。';

// Email Settings
$GLOBALS['strEmailSettings']                         = 'Eメール設定';
$GLOBALS['strEmailAddresses']                        = 'Eメール  アドレス';
$GLOBALS['strEmailFromName']                         = 'Eメール  宛先名';
$GLOBALS['strEmailFromAddress']                      = 'Eメール  Eメールアドレス';
$GLOBALS['strEmailFromCompany']                      = 'Eメール  社用';
$GLOBALS['strQmailPatch']                            = 'Qメールパッチ';
$GLOBALS['strEnableQmailPatch']                      = 'Qmailパッチを適用する';
$GLOBALS['strEmailHeader']                           = 'Eメールヘッダ';
$GLOBALS['strEmailLog']                              = 'Eメールログ';

// Audit Trail Settings
$GLOBALS['strAudit']                                 = '追跡記録ログ';
$GLOBALS['strEnableAudit']                           = '監査の追跡を有効にする';

// Debug Logging Settings
$GLOBALS['strDebug']                                 = 'ログ検査方法の設定';
$GLOBALS['strProduction']                            = '広告配信サーバ';
$GLOBALS['strEnableDebug']                           = 'ログの検査を有効にする';
$GLOBALS['strDebugMethodNames']                      = '関数名を検査ログに含める';
$GLOBALS['strDebugLineNumbers']                      = '検査ログに行番号を含める';
$GLOBALS['strDebugType']                             = '検査ログのタイプ';
$GLOBALS['strDebugTypeFile']                         = 'ファイル';
$GLOBALS['strDebugTypeMcal']                         = 'mCal';
$GLOBALS['strDebugTypeSql']                          = 'SQLデータベース';
$GLOBALS['strDebugTypeSyslog']                       = 'システムログ';
$GLOBALS['strDebugName']                             = 'ログ名、カレンダー、SQLテーブル<br />もしくはシスログを検査する';
$GLOBALS['strDebugPriority']                         = '優先度を検査する';
$GLOBALS['strPEAR_LOG_DEBUG']                        = 'PEAR_LOG_DEBUG - ほぼ全てをログに出力する';
$GLOBALS['strPEAR_LOG_INFO']                         = 'PEAR_LOG_INFO - 通常の情報をログに出力する';
$GLOBALS['strPEAR_LOG_NOTICE']                       = 'PEAR_LOG_NOTICE - Noticeレベルの情報をログに出力する';
$GLOBALS['strPEAR_LOG_WARNING']                      = 'PEAR_LOG_WARNING - 警告レベルの情報をログに出力する';
$GLOBALS['strPEAR_LOG_ERR']                          = 'PEAR_LOG_ERR - エラーレベルの情報をログに出力する';
$GLOBALS['strPEAR_LOG_CRIT']                         = 'PEAR_LOG_CRIT- クリティカルレベルの情報をログに出力する';
$GLOBALS['strPEAR_LOG_ALERT']                        = 'PEAR_LOG_ALERT - アラートレベルの情報をログに出力する';
$GLOBALS['strPEAR_LOG_EMERG']                        = 'PEAR_LOG_EMERG - 最も情報の少ないレベル';
$GLOBALS['strDebugIdent']                            = '識別文字の検査';
$GLOBALS['strDebugUsername']                         = 'mCal, SQLサーバのユーザ名';
$GLOBALS['strDebugPassword']                         = 'mCal, SQLサーバのパスワード';

// Delivery Settings
$GLOBALS['strDeliverySettings']                      = '配信設定';
$GLOBALS['strWebPath']                               = "" . MAX_PRODUCT_NAME . 'へのアクセスパス';
$GLOBALS['strWebPathSimple']                         = 'Webパス';
$GLOBALS['strDeliveryPath']                          = '配信パス';
$GLOBALS['strImagePath']                             = '画像パス';
$GLOBALS['strDeliverySslPath']                       = '配信パス（SSL)';
$GLOBALS['strImageSslPath']                          = '画像パス（SSL)';
$GLOBALS['strImageStore']                            = '画像ディレクトリ';
$GLOBALS['strTypeWebSettings']                       = '画像のサーバ保存設定';
$GLOBALS['strTypeWebMode']                           = '保存方法';
$GLOBALS['strTypeWebModeLocal']                      = 'ローカルディレクトリ';
$GLOBALS['strTypeDirError']                          = 'ウェブサーバがローカルディレクトリに書き込むことができません';
$GLOBALS['strTypeWebModeFtp']                        = '外部FTPサーバ';
$GLOBALS['strTypeWebDir']                            = 'ローカルディレクトリ';
$GLOBALS['strTypeFTPHost']                           = 'FTPホスト';
$GLOBALS['strTypeFTPDirectory']                      = 'ホストディレクトリ';
$GLOBALS['strTypeFTPUsername']                       = 'ログイン';
$GLOBALS['strTypeFTPPassword']                       = 'パスワード';
$GLOBALS['strTypeFTPPassive']                        = 'パッシブFTPを使用';
$GLOBALS['strTypeFTPErrorDir']                       = 'FTPホストにディレクトリが存在しません';
$GLOBALS['strTypeFTPErrorConnect']                   = 'FTPサーバに接続できません。ログインかパスワードが間違っている可能性があります。';
$GLOBALS['strTypeFTPErrorNoSupport']                 = 'PHPの設定で、FTPをサポートする必要があります。';
$GLOBALS['strTypeFTPErrorHost']                      = 'FTPホストが正しくありません';
$GLOBALS['strDeliveryFilenames']                     = '配信ファイル名';
$GLOBALS['strDeliveryFilenamesAdClick']              = '広告クリック';
$GLOBALS['strDeliveryFilenamesAdConversionVars']     = '広告コンバージョン値';
$GLOBALS['strDeliveryFilenamesAdContent']            = '広告内容';
$GLOBALS['strDeliveryFilenamesAdConversion']         = '広告コンバージョン';
$GLOBALS['strDeliveryFilenamesAdConversionJS']       = '広告コンバージョン(Javascript)';
$GLOBALS['strDeliveryFilenamesAdFrame']              = '広告フレーム';
$GLOBALS['strDeliveryFilenamesAdImage']              = '広告画像';
$GLOBALS['strDeliveryFilenamesAdJS']                 = '広告（Javascript)';
$GLOBALS['strDeliveryFilenamesAdLayer']              = '広告レイヤー';
$GLOBALS['strDeliveryFilenamesAdLog']                = '広告ログ';
$GLOBALS['strDeliveryFilenamesAdPopup']              = '広告ポップアップ';
$GLOBALS['strDeliveryFilenamesAdView']               = '広告ビュー';
$GLOBALS['strDeliveryFilenamesXMLRPC']               = 'XML RPCで広告を生成する';
$GLOBALS['strDeliveryFilenamesLocal']                = 'ローカルサーバより広告を生成する';
$GLOBALS['strDeliveryFilenamesFrontController']      = 'フロントコントローラ';
$GLOBALS['strDeliveryFilenamesFlash']                = 'FlashのURL（フルURL）';
$GLOBALS['strDeliveryCaching']                       = 'バナーキャッシュの設定';
$GLOBALS['strDeliveryCacheLimit']                    = 'バナーキャッシュの更新間隔';

$GLOBALS['strOrigin']                                = 'リモートサーバを使用';
$GLOBALS['strOriginType']                            = 'リモートサーバのタイプ';
$GLOBALS['strOriginHost']                            = 'リモートサーバのホスト名';
$GLOBALS['strOriginPort']                            = 'リモートサーバのポート番号';
$GLOBALS['strOriginScript']                          = 'リモートデータベースのスクリプト';
$GLOBALS['strOriginTypeXMLRPC']                      = 'XMLRPC通信';
$GLOBALS['strOriginTimeout']                         = 'リモートサーバのタイムアウト（秒）';
$GLOBALS['strOriginProtocol']                        = 'リモートサーバのプロトコル';

$GLOBALS['strDeliveryAcls']                          = 'バナー配送毎に配信制限を確認する';
$GLOBALS['strDeliveryObfuscate']                     = 'バナー配信時にチャンネルを隠す';
$GLOBALS['strDeliveryExecPhp']                       = 'バナーの内容にPHPコードを許可する<br />(Warning: セキュリティリスクとなり得る)';
$GLOBALS['strDeliveryCtDelimiter']                   = 'サードパーティー製の、クリック追跡時用区切り文字';
$GLOBALS['strP3PSettings']                           = 'P3Pプライベートポリシー';
$GLOBALS['strUseP3P']                                = 'P3Pポリシーを使う';
$GLOBALS['strP3PCompactPolicy']                      = 'P3Pコンパクトポリシー';
$GLOBALS['strP3PPolicyLocation']                     = 'P3Pポリシーの場所';

// General Settings
$GLOBALS['generalSettings']                          = '全般設定';
$GLOBALS['uiEnabled']                                = 'ユーザ画面を有効にする';
$GLOBALS['defaultLanguage']                          = 'デフォルト言語設定';

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings']                  = 'ジオターゲティング設定';
$GLOBALS['strGeotargeting']                          = 'ジオターゲティング設定';
$GLOBALS['strGeotargetingType']                      = 'ジオターゲティングモジュールタイプ';
$GLOBALS['strGeotargetingUseBundledCountryDb']       = '付属のMaxMind GeoLiteCountryデータベースを使用する';
$GLOBALS['strGeotargetingGeoipCountryLocation']      = 'MaxMind製GeoIP国別データベースの場所';
$GLOBALS['strGeotargetingGeoipRegionLocation']       = 'MaxMind製GeoIP地方・領域データベースの場所';
$GLOBALS['strGeotargetingGeoipCityLocation']         = 'MaxMind製GeoIP市区町村データベースの場所';
$GLOBALS['strGeotargetingGeoipAreaLocation']         = 'MaxMind製GeoIP地域・区域データベースの場所';
$GLOBALS['strGeotargetingGeoipDmaLocation']          = 'MaxMind製GeoIP地域・区域データベースの場所';
$GLOBALS['strGeotargetingGeoipOrgLocation']          = 'MaxMind製GeoIP企業データベースの場所';
$GLOBALS['strGeotargetingGeoipIspLocation']          = 'MaxMind製GeoIP ISPデータベースの場所';
$GLOBALS['strGeotargetingGeoipNetspeedLocation']     = 'MaxMind製GeoIP 回線速度データベースの場所';
$GLOBALS['strGeoSaveStats']                          = 'GeoIPデータをログに保存する';
$GLOBALS['strGeoShowUnavailable']                    = 'GeoIPにデータがない場合でも、ジオターゲティングの配信制限を表示する';
$GLOBALS['strGeotrackingGeoipCountryLocationError']  = 'MaxMind製GeoIPの国別データベースが見つかりません';
$GLOBALS['strGeotrackingGeoipRegionLocationError']   = 'MaxMind製GeoIPの地方・領域別データベースが見つかりません';
$GLOBALS['strGeotrackingGeoipCityLocationError']     = 'MaxMind製GeoIPの市区町村別データベースが見つかりません';
$GLOBALS['strGeotrackingGeoipAreaLocationError']     = 'MaxMind製GeoIPの地域別データベースが見つかりません';
$GLOBALS['strGeotrackingGeoipDmaLocationError']      = 'MaxMind製GeoIPのDMAデータベースが見つかりません';
$GLOBALS['strGeotrackingGeoipOrgLocationError']      = 'MaxMind製GeoIPの企業別データベースが見つかりません';
$GLOBALS['strGeotrackingGeoipIspLocationError']      = 'MaxMind製GeoIPのISP別データベースが見つかりません';
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = 'MaxMind製GeoIPの回線速度別データベースが見つかりません';

// Interface Settings
$GLOBALS['strInventory']                             = 'インベントリ';
$GLOBALS['strUploadConversions']                     = 'コンバージョンのアップロード';
$GLOBALS['strShowCampaignInfo']                      = 'キャンペーンの追加情報を<i>キャンペーンの概要</i>に表示する';
$GLOBALS['strShowBannerInfo']                        = 'バナーの追加情報を<i>バナーの概要</i>に表示する';
$GLOBALS['strShowCampaignPreview']                   = '全てのバナーのプレビューを<i>バナーの概要</i>に表示する';
$GLOBALS['strShowBannerHTML']                        = 'HTMLバナーの場合、HTMLタグではなく、実際のバナーを表示する';
$GLOBALS['strShowBannerPreview']                     = 'バナーが表示される画面に遷移した場合、バナーのプレビューを画面上部に表示する';
$GLOBALS['strHideInactive']                          = '非アクティブなものを隠す';
$GLOBALS['strGUIShowMatchingBanners']                = 'マッチするバナーを<i>関連済みバナー</i>で表示する';
$GLOBALS['strGUIShowParentCampaigns']                = '親キャンペーンを<i>関連済みバナー</i>で表示する';
$GLOBALS['strGUIAnonymousCampaignsByDefault']        = 'デフォルトキャンペーンを匿名にする';
$GLOBALS['strStatisticsDefaults']                    = '統計';
$GLOBALS['strBeginOfWeek']                           = '週の始まり';
$GLOBALS['strPercentageDecimals']                    = '10進数のパーセンテージ';
$GLOBALS['strWeightDefaults']                        = 'デフォルトの重み';
$GLOBALS['strDefaultBannerWeight']                   = 'デフォルトのバナーの重み';
$GLOBALS['strDefaultCampaignWeight']                 = 'デフォルトのキャンペーンの重み';
$GLOBALS['strDefaultBannerWErr']                     = 'バナー用配信ウェイトには正の整数を入力してください。';
$GLOBALS['strDefaultCampaignWErr']                   = 'キャンペーン用配信ウェイトには正の整数を入力してください。';
$GLOBALS['strConfirmationUI']                        = 'ユーザインターフェースの確認';

$GLOBALS['strPublisherDefaults']                     = 'Webサイトのデフォルト';
$GLOBALS['strModesOfPayment']                        = '支払方法';
$GLOBALS['strCurrencies']                            = '通貨';
$GLOBALS['strCategories']                            = 'カテゴリ';
$GLOBALS['strHelpFiles']                             = 'ヘルプファイル';
$GLOBALS['strHasTaxID']                              = '税金ID';
$GLOBALS['strDefaultApproved']                       = '承認済みのチェックボックス';

// CSV Import Settings
$GLOBALS['strChooseAdvertiser']                      = '広告主';
$GLOBALS['strChooseCampaign']                        = 'キャンペーン';
$GLOBALS['strChooseCampaignBanner']                  = 'バナー';
$GLOBALS['strChooseTracker']                         = 'トラッカー';
$GLOBALS['strDefaultConversionStatus']               = 'デフォルト コンバージョンルール';
$GLOBALS['strDefaultConversionType']                 = 'デフォルト コンバージョンルール';
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
$GLOBALS['strAllowedInvocationTypes']                = '許可されたバナー生成タイプ';
$GLOBALS['strInvocationDefaults']                    = 'バナー生成タイプのデフォルト';
$GLOBALS['strEnable3rdPartyTrackingByDefault']       = 'サードパーティー製のクリック追跡をデフォルトで有効にする';

// Banner Delivery Settings
$GLOBALS['strBannerDelivery']                        = 'バナーキャッシュの設定';

// Banner Logging Settings
$GLOBALS['strBannerLogging']                         = 'バナーログのブロック設定';
$GLOBALS['strLogAdRequests']                         = "バナー要求毎に'リクエスト'として記録する";
$GLOBALS['strLogAdImpressions']                      = "バナー閲覧毎に'インプレッション'として記録する";
$GLOBALS['strLogAdClicks']                           = "バナークリック毎に'クリック'として記録する";
$GLOBALS['strLogTrackerImpressions']                 = "追跡用ビーコン参照毎に'追跡インプレッション'として記録する";
$GLOBALS['strReverseLookup']                         = 'ホストネームが取得できない場合、逆引きを行う';
$GLOBALS['strProxyLookup']                           = 'プロキシサーバを経由している場合、本当のIPを取得する';
$GLOBALS['strPreventLogging']                        = 'バナーログのブロック設定';
$GLOBALS['strIgnoreHosts']                           = '以下のIPに登録されているユーザはログを取得しない';
$GLOBALS['strIgnoreUserAgents']                      = '以下の内容がUserAgentに含まれていた場合、ログを取得しない';
$GLOBALS['strEnforceUserAgents']                     = '以下の内容がUserAgentに含まれている場合のみ、ログを取得する';

// Banner Storage Settings
$GLOBALS['strBannerStorage']                         = 'バナーストレージ設定';

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings']                   = 'メンテナンス設定';
$GLOBALS['strConversionTracking']                    = 'コンバージョン追跡設定';
$GLOBALS['strEnableConversionTracking']              = 'コンバージョンの追跡を有効にする';
$GLOBALS['strCsvImport']                             = 'オフラインでのコンバージョンをアップロードすることを許可する';
$GLOBALS['strBlockAdViews']                          = '特定の時間内に同じゾーンもしくは広告にアクセスするユーザがいた場合、そのインプレッション数を取得しない';
$GLOBALS['strBlockAdViewsError']                     = 'インプレッションのブロック数は正数を入力してください';
$GLOBALS['strBlockAdClicks']                         = '特定の時間内に同じゾーンもしくは広告にアクセスするユーザがいた場合、その広告クリック数を取得しない';
$GLOBALS['strBlockAdClicksError']                    = 'クリックのブロック数は正数を入力してください';
$GLOBALS['strMaintenanceOI']                         = 'メンテナンス時間間隔(分）';
$GLOBALS['strMaintenanceOIError']                    = 'メンテナンスの時間間隔が不正です。正しい値に関してはドキュメントを確認してください。';
$GLOBALS['strMaintenanceCompactStats']               = '集計後、統計情報の元データを削除しますか';
$GLOBALS['strMaintenanceCompactStatsGrace']          = '統計情報を削除するまでの猶予期間(秒)';
$GLOBALS['strPrioritySettings']                      = '優先度設定';
$GLOBALS['strPriorityInstantUpdate']                 = '優先度の変更を即反映する';
$GLOBALS['strWarnCompactStatsGrace']                 = '猶予期間の値は正数を入力してください';
$GLOBALS['strDefaultImpConWindow']                   = 'デフォルトの広告インプレッション接続ウィンドウ（秒）';
$GLOBALS['strDefaultImpConWindowError']              = 'デフォルトの広告インプレッション接続ウィンドウは、正数を入力してください';
$GLOBALS['strDefaultCliConWindow']                   = 'デフォルトの広告クリックウィンドウ（秒）';
$GLOBALS['strDefaultCliConWindowError']              = 'デフォルトの広告クリックウィンドウは、正数を入力してください';
$GLOBALS['strAdminEmailHeaders']                     = '". '.MAX_PRODUCT_NAME.' ."が送るメールのヘッダに以下の情報を付与する';
$GLOBALS['strWarnLimit']                             = 'インプレッションの残数がここで指定する数値を下回った場合、警告Eメールを送信する';
$GLOBALS['strWarnLimitErr']                          = '残数は正数を入力してください';
$GLOBALS['strWarnLimitDays']                         = '表示日数の残数がここで指定する数値を下回った場合、警告Eメールを送信する';
$GLOBALS['strWarnLimitDaysErr']                      = '残数は正数を入力してください';
$GLOBALS['strAllowEmail']                            = 'メール送信を共通して許可する';
$GLOBALS['strEmailAddressFrom']                      = 'メール送信時の送り主アドレス';
$GLOBALS['strEmailAddressName']                      = 'Eメールに含める、送信者名';
$GLOBALS['strWarnAdmin']                             = 'キャンペーンが終了しそうになったら、管理者宛てにメールを送る。';
$GLOBALS['strWarnClient']                            = 'キャンペーンが終了しそうになったら、広告主宛てにメールを送る。';
$GLOBALS['strWarnAgency']                            = 'キャンペーンが終了しそうになったら、媒体主宛てにメールを送る。';

// UI Settings
$GLOBALS['strGuiSettings']                           = 'ユーザインターフェース設定';
$GLOBALS['strGeneralSettings']                       = '全般設定';
$GLOBALS['strAppName']                               = 'アプリケーション名';
$GLOBALS['strMyHeader']                              = 'ヘッダファイルの場所';
$GLOBALS['strMyHeaderError']                         = 'ヘッダファイルが見つかりません。';
$GLOBALS['strMyFooter']                              = 'フッタファイルの場所';
$GLOBALS['strMyFooterError']                         = 'フッタファイルが見つかりません';
$GLOBALS['strDefaultTrackerStatus']                  = 'デフォルトの追跡ステータス';
$GLOBALS['strDefaultTrackerType']                    = 'デフォルトの追跡タイプ';
$GLOBALS['strSSLSettings']                           = 'SSL設定';
$GLOBALS['requireSSL']                               = 'ユーザインターフェースへのアクセスを強制的にSSLを使う';
$GLOBALS['sslPort']                                  = 'SSLポート番号';

$GLOBALS['strMyLogo']                                = 'カスタムロゴファイル名';
$GLOBALS['strMyLogoError']                           = 'ロゴファイルがadmin/imagesディレクトリに存在しません';
$GLOBALS['strGuiHeaderForegroundColor']              = 'ヘッダーのフロント色';
$GLOBALS['strGuiHeaderBackgroundColor']              = 'ヘッダーの背景色';
$GLOBALS['strGuiActiveTabColor']                     = 'アクティブタブの色';
$GLOBALS['strGuiHeaderTextColor']                    = 'ヘッダーのテキスト色';
$GLOBALS['strColorError']                            = 'RGBフォーマットで色を指定してください(e.g. 0066CC)';

$GLOBALS['strGzipContentCompression']                = 'GZIP圧縮をする';
$GLOBALS['strClientInterface']                       = '広告主インターフェース';
$GLOBALS['strReportsInterface']                      = 'レポートインターフェース';
$GLOBALS['strClientWelcomeEnabled']                  = '広告主のウェルカムメッセージを有効にする';
$GLOBALS['strClientWelcomeText']                     = 'ウェルカムテキスト<br />（HTMLタグ使用可）';

$GLOBALS['strPublisherInterface']                    = 'Webサイトインターフェース';
$GLOBALS['strPublisherAgreementEnabled']             = 'Terms and Conditionsを受諾しなかったユーザに対し、ログインコントロールをする';
$GLOBALS['strPublisherAgreementText']                = 'ログインテキスト（HTMLタグ使用可）';


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



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strWebPath'] = "". MAX_PRODUCT_NAME ." サーバアクセスパス'";
$GLOBALS['strAuditTrailSettings'] = "追跡記録ログ";
$GLOBALS['strDbNameHint'] = "もしない場合、データベースが自動で作成されます。";
$GLOBALS['strProductionSystem'] = "プロダクションシステム";
$GLOBALS['strTypeFTPErrorUpload'] = "FTPサーバにファイルをアップロードすることができませんでした。ディレクトリの権限を確認してください。";
$GLOBALS['strEnableDashboardSyncNotice'] = "ダッシュボードを使用するには、<a href='account-settings-update.php'>アップデートのチェック</a>を有効にしてください。";
$GLOBALS['strDashboardSettings'] = "ダッシュボード設定";
?>