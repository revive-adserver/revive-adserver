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

// Encoding
$GLOBALS['strEncoding'] = "エンコード形式";
$GLOBALS['strEncodingConvertFrom'] = "変換元エンコード形式:";
$GLOBALS['strEncodingConvertTest'] = "変換テスト";
$GLOBALS['strConvertThese'] = "続行すると、エンコード形式が変更されます。";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "アップデートを検索しています。しばらくお待ちください...";
$GLOBALS['strAvailableUpdates'] = "アップデートを有効にする";
$GLOBALS['strDownloadZip'] = "ダウンロードする(.zip)";
$GLOBALS['strDownloadGZip'] = "ダウンロードする(.tar.gz)";


$GLOBALS['strUpdateServerDown'] = "未知の理由によって、アップデート情報の照会ができません。<br>しばらくしてから再度アップデートを実行してください。";







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


