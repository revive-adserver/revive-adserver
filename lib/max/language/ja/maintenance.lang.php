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

// Main strings
$GLOBALS['strChooseSection'] = "セクションの選択";
$GLOBALS['strAppendCodes'] = "コードを追加する";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>過去数時間の間、定期メンテナンス行われていません。設定を確認してください。</b>";

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "自動メンテナンスが有効ですが、動作していないようです。自動メンテナンスは、{$PRODUCT_NAME}がバナーを配信するときのみ動作します。 配信性能をベストな状態にするためには、<a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>定期メンテナンス</a>を設定してください。";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "自動メンテナンスは現在無効です。 {$PRODUCT_NAME}が配信したとしても、自動メンテナンスは起動しません。 ベストな状態を保つためには、<a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>定期メンテナンス</a>を有効にして下さい。しかし、もし<a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>定期メンテナンス</a>を有効にしないならば、<i>必ず</i> <a href='account-settings-maintenance.php'>自動メンテナンスを有効</a>にし、{$PRODUCT_NAME}が正常に動作するかを確認してください。'";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "自動メンテナンスが有効ですが、動作していないようです。自動メンテナンスは、{$PRODUCT_NAME}がバナーを配信するときのみ動作します。 配信性能をベストな状態にするためには、<a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>定期メンテナンス</a>を設定してください。";

$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "自動メンテナンスが無効となっています。 {$PRODUCT_NAME}が正常に動作することを保障するためには、<a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>定期メンテナンス</a>もしくは<a href='account-settings-maintenance.php'>自動メンテナンスを再開</a>して下さい。<br><br>ベストな状態を保つためには、 <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>定期メンテナンス</a>が必要です。";

$GLOBALS['strScheduledMantenaceRunning'] = "<b>定期メンテナンスは正常に動作しています。</b>";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>自動メンテナンスは正常に動作しています。</b>";

$GLOBALS['strAutoMantenaceEnabled'] = "自動メンテナンスが動作しています。ベストな状態を保つためには、<a href='account-settings-maintenance.php'>自動メンテナンスを無効</a>にして下さい。";

// Priority
$GLOBALS['strRecalculatePriority'] = "優先度の再計算";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "バナーキャッシュの構築";
$GLOBALS['strBannerCacheErrorsFound'] = "バナーキャッシュデータにエラーが検出されました。エラーを手作業で回復するまで、対象バナーは正しく動作しません。";
$GLOBALS['strBannerCacheOK'] = "バナーキャッシュデータにエラーは検出されませんでした。バナーキャッシュは最新に保たれています。";
$GLOBALS['strBannerCacheDifferencesFound'] = "バナーキャッシュデータに最新でなく再構築が必要なデータが検出されました。キャッシュを自動的に更新するには、ここをクリックしてください。";
$GLOBALS['strBannerCacheRebuildButton'] = "再構築";
$GLOBALS['strRebuildDeliveryCache'] = "バナーキャッシュの再構築";
$GLOBALS['strBannerCacheExplaination'] = "　　　　バナーキャッシュは、バナーの配信速度向上のために使用します。<br />
　　　　バナーキャッシュの更新タイミングは以下のとおりです:
    <ul>
        <li>{$PRODUCT_NAME}のバージョンアップ時</li>
        <li>{$PRODUCT_NAME}のサーバ移転時</li>
    </ul>";

// Cache
$GLOBALS['strCache'] = "配信キャッシュ";
$GLOBALS['strDeliveryCacheSharedMem'] = "	配信キャッシュの保存用に'共有メモリ'を使用しています。";
$GLOBALS['strDeliveryCacheDatabase'] = "	配信キャッシュの保存用に'データベース'を使用しています。";
$GLOBALS['strDeliveryCacheFiles'] = "	配信キャッシュの保存用に'ファイル'を使用しています。";

// Storage
$GLOBALS['strStorage'] = "画像ストレージ";
$GLOBALS['strMoveToDirectory'] = "画像の保存先をデータベースからディレクトリに変更する";
$GLOBALS['strStorageExplaination'] = "	バナー用の画像は、データベースかディレクトリに保存します。
	画像をディレクトリに保存すると、CPU負荷が低下し、配信スピードが向上します。";

// Security

// Encoding
$GLOBALS['strEncoding'] = "エンコード形式";
$GLOBALS['strEncodingExplaination'] = "{$PRODUCT_NAME}  は全てのデータをUTF-8形式でデータベースに保存します。<br />可能な限り、使用者の入力内容はUTF-8に変換されます。<br />もしアップグレード後に文字化けが発生しているようであれば、こちらのツールを使用して、文字コードを変換して下さい。 ";
$GLOBALS['strEncodingConvertFrom'] = "変換元エンコード形式:";
$GLOBALS['strEncodingConvertTest'] = "変換テスト";
$GLOBALS['strConvertThese'] = "続行すると、エンコード形式が変更されます。";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "アップデートを検索しています。しばらくお待ちください...";
$GLOBALS['strAvailableUpdates'] = "アップデートを有効にする";
$GLOBALS['strDownloadZip'] = "ダウンロードする(.zip)";
$GLOBALS['strDownloadGZip'] = "ダウンロードする(.tar.gz)";

$GLOBALS['strUpdateAlert'] = "新しいバージョンの{$PRODUCT_NAME}がリリースされました。

アップデートしますか？";
$GLOBALS['strUpdateAlertSecurity'] = "新しいバージョンの{$PRODUCT_NAME}がリリースされました。

セキュリティ上のバグフィックスを含むため、アップデートを推薦します。";

$GLOBALS['strUpdateServerDown'] = "未知の理由によって、アップデート情報の照会ができません。<br>しばらくしてから再度アップデートを実行してください。";

$GLOBALS['strNoNewVersionAvailable'] = "あなたの{$PRODUCT_NAME}は最新です。現在のところ、新しいバージョンは存在しません。";



$GLOBALS['strNewVersionAvailable'] = "	<b>最新バージョンの{$PRODUCT_NAME}が利用可能です。</b><br />
	バグフィックスと最新機能追加のため、このアップデートをインストールすることを推奨します。<br />
	より詳しい情報はダウンロードファイルに含まれる以下のドキュメントを参照してください。";

$GLOBALS['strSecurityUpdate'] = "	<b>セキュリティフィックスのため、できるだけ速やかにこのアップデートをインストールすることを強く推奨します。</b>
	使用中の{$PRODUCT_NAME}のバージョンは、特定のセキュリティアタックから攻撃を受けやすく、安全ではありません。
	より詳しい情報はダウンロードファイルに含まれる以下のドキュメントを参照してください。
";

$GLOBALS['strNotAbleToCheck'] = "	<b>サーバのXML機能が利用できないため、{$PRODUCT_NAME}は最新バージョン<br />
	が利用可能であるかどうかのチェックができません。</b>";

$GLOBALS['strForUpdatesLookOnWebsite'] = "	新バージョンが利用可能か確認したい場合、{$PRODUCT_NAME}のサイトを訪問してください。";

$GLOBALS['strClickToVisitWebsite'] = "Webサイトへ";
$GLOBALS['strCurrentlyUsing'] = "使用中のバージョン：";
$GLOBALS['strRunningOn'] = "動作環境";
$GLOBALS['strAndPlain'] = "および";

//  Deliver Limitations
$GLOBALS['strErrorsFound'] = "エラーがあります";
$GLOBALS['strRepairCompiledLimitations'] = "いくつか内容に矛盾があります。下記のボタンを使用して問題を修正してください。この設定は、すべてのバナー及びチャンネルの再集計に対する上限値を設定し直します。<br />";
$GLOBALS['strRecompile'] = "再集計";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "何らかの状況下において、配信エンジンがトラックコードを拒否しました。以下のリンクをたどって修正をして下さい。";
$GLOBALS['strCheckAppendCodes'] = "追加コードを確認";
$GLOBALS['strAppendCodesRecompiled'] = "すべて追加コードの値が再集計されました。";
$GLOBALS['strAppendCodesResult'] = "追加コードのチェック集計結果";
$GLOBALS['strAppendCodesValid'] = "全ての追跡コードは正常です。";
$GLOBALS['strRepairAppenedCodes'] = "何らかの問題が見つかりました。以下のボタンを使用して修正してください。これは全ての追跡コードの値を再集計します。";



// Users
