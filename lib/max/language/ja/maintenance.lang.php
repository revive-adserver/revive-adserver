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

// Main strings
$GLOBALS['strChooseSection']				= "セクションの選択";


// Priority
$GLOBALS['strRecalculatePriority']			= "優先度の再計算";
$GLOBALS['strHighPriorityCampaigns']		= "高優先キャンペーン";
$GLOBALS['strAdViewsAssigned']				= "割当ビュー数";
$GLOBALS['strLowPriorityCampaigns']			= "低優先キャンペーン";
$GLOBALS['strPredictedAdViews']				= "予測ビュー数";
$GLOBALS['strPriorityDaysRunning']			= "" . MAX_PRODUCT_NAME."が日別予測の算出に利用可能な{days}日間の統計データがあります。";
$GLOBALS['strPriorityBasedLastWeek']		= "今週と先週のデータを使用して日別推移を予測しています。";
$GLOBALS['strPriorityBasedLastDays']		= "数日間のデータを使用して日別推移を予測しています。";
$GLOBALS['strPriorityBasedYesterday']		= "昨日のデータを使用して日別推移を予測しています。";
$GLOBALS['strPriorityNoData']				= "本日のインプレッション数を予測するのに十分なデータがありません。直近の統計結果に基づき優先度を割り当てます。";
$GLOBALS['strPriorityEnoughAdViews']		= "対象ゾーンには、全ての高優先キャンペーンを完全に満たすための一定以上のビュー数が必要です。";
$GLOBALS['strPriorityNotEnoughAdViews']		= "対象ゾーンには、全ての高優先キャンペーンを満たすための十分なビュー数がありませんでした。";


// Banner cache
$GLOBALS['strCheckBannerCache']				= "バナーキャッシュの構築";
$GLOBALS['strRebuildBannerCache']			= "バナーキャッシュの再構築";
$GLOBALS['strBannerCacheErrorsFound'] 		= "バナーキャッシュデータにエラーが検出されました。エラーを手作業で回復するまで、対象バナーは正しく動作しません。";
$GLOBALS['strBannerCacheOK'] 				= "バナーキャッシュデータにエラーは検出されませんでした。バナーキャッシュは最新に保たれています。";
$GLOBALS['strBannerCacheDifferencesFound'] 	= "バナーキャッシュデータに最新でなく再構築が必要なデータが検出されました。キャッシュを自動的に更新するには、ここをクリックしてください。";
$GLOBALS['strBannerCacheFixed'] 			= "バナーキャッシュの再構築が正常終了しました。バナーキャッシュは最新に保たれています。";
$GLOBALS['strBannerCacheRebuildButton'] 	= "再構築";
$GLOBALS['strRebuildDeliveryCache']			= "バナーキャッシュの再構築";
$GLOBALS['strBannerCacheExplaination']		= "
　　　　バナーキャッシュは、バナーの配信速度向上のために使用します。<br />
　　　　バナーキャッシュの更新タイミングは以下のとおりです:
    <ul>
        <li>".MAX_PRODUCT_NAME."のバージョンアップ時</li>
        <li>".MAX_PRODUCT_NAME."のサーバ移転時</li>
    </ul>
";

// Cache
$GLOBALS['strCache']						= "配信キャッシュ";
$GLOBALS['strAge']							= "キャッシュ寿命";
$GLOBALS['strDeliveryCacheSharedMem']		= "
	配信キャッシュの保存用に'共有メモリ'を使用しています。
";
$GLOBALS['strDeliveryCacheDatabase']		= "
	配信キャッシュの保存用に'データベース'を使用しています。
";
$GLOBALS['strDeliveryCacheFiles']			= "
	配信キャッシュの保存用に'ファイル'を使用しています。
";


// Storage
$GLOBALS['strStorage']						= "画像ストレージ";
$GLOBALS['strMoveToDirectory']				= "画像の保存先をデータベースからディレクトリに変更する";
$GLOBALS['strStorageExplaination']			= "
	バナー用の画像は、データベースかディレクトリに保存します。
	画像をディレクトリに保存すると、CPU負荷が低下し、配信スピードが向上します。
";

// Encoding
$GLOBALS['strEncoding']                 	= "エンコード形式";
$GLOBALS['strEncodingExplaination']     	= "" . MAX_PRODUCT_NAME . 'は、UTF-8形式でデータベースに保存します。<br />
    　　また、データは可能な限りUTF-8形式に自動変換されます。<br />
    　　バージョンアップ後に文字化けが生じた場合、変換前のエンコード形式を指定することで、UTF-8形式に強制的に変換できます。';
$GLOBALS['strEncodingConvertFrom']      	= "変換元エンコード形式:";
$GLOBALS['strEncodingConvert']          	= "変換する";
$GLOBALS['strEncodingConvertTest']      	= "変換テスト";
$GLOBALS['strConvertThese']             	= "続行すると、エンコード形式が変更されます。";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	<i>コンパクト形式の統計</i>を有効にしましたが、過去の統計データは冗長形式で保存されています。
	過去の統計データを冗長形式からコンパクト形式に変換しますか？
";


// Product Updates
$GLOBALS['strSearchingUpdates']				= "アップデートを検索しています。しばらくお待ちください...";
$GLOBALS['strAvailableUpdates']				= "アップデートを有効にする";
$GLOBALS['strDownloadZip']					= "ダウンロードする(.zip)";
$GLOBALS['strDownloadGZip']					= "ダウンロードする(.tar.gz)";

$GLOBALS['strUpdateAlert']					= "" . MAX_PRODUCT_NAME."の新しいバージョンが利用可能です。                 \\n\\nアップデートに関する詳しい情報を入手しますか？";
$GLOBALS['strUpdateAlertSecurity']			= "" . MAX_PRODUCT_NAME."の新しいバージョンが利用可能です。                 \\n\\nできるだけ早くアップデートしてください。\\nいくつかのセキュリティフィックスがあります。";

$GLOBALS['strUpdateServerDown']				= "未知の理由によって、アップデート情報の照会ができません。<br>しばらくしてから再度アップデートを実行してください。";

$GLOBALS['strNoNewVersionAvailable']		= 
　　　　MAX_PRODUCT_NAME."は最新にアップデートされています。利用可能なアップデートはありません。
";

$GLOBALS['strNewVersionAvailable']			= "
	<b>最新バージョンの".MAX_PRODUCT_NAME."が利用可能です。</b><br />
	バグフィックスと最新機能追加のため、このアップデートをインストールすることを推奨します。<br />
	より詳しい情報はダウンロードファイルに含まれる以下のドキュメントを参照してください。
";

$GLOBALS['strSecurityUpdate']				= "
	<b>セキュリティフィックスのため、できるだけ速やかにこのアップデートをインストールすることを強く推奨します。</b>
	使用中の".MAX_PRODUCT_NAME."のバージョンは、特定のセキュリティアタックから攻撃を受けやすく、安全ではありません。
	より詳しい情報はダウンロードファイルに含まれる以下のドキュメントを参照してください。

";

$GLOBALS['strNotAbleToCheck']				= "
	<b>サーバのXML機能が利用できないため、".MAX_PRODUCT_NAME."は最新バージョン<br />
	が利用可能であるかどうかのチェックができません。</b>
";

$GLOBALS['strForUpdatesLookOnWebsite']		= "
	新バージョンが利用可能か確認したい場合、".MAX_PRODUCT_NAME."のサイトを訪問してください。
";

$GLOBALS['strClickToVisitWebsite']			= "" . MAX_PRODUCT_NAME."のサイトを訪問するにはここをクリック";
$GLOBALS['strCurrentlyUsing'] 				= "使用中のバージョン：";
$GLOBALS['strRunningOn']					= "動作環境";
$GLOBALS['strAndPlain']						= "および";


// Stats conversion
$GLOBALS['strConverting']					= "変換中";
$GLOBALS['strConvertingStats']				= "統計データを変換中です...";
$GLOBALS['strConvertStats']					= "統計データの変換";
$GLOBALS['strConvertAdViews']				= "ビュー数を変換しました...";
$GLOBALS['strConvertAdClicks']				= "クリック数を変換しました...";
$GLOBALS['strConvertAdConversions']			= "コンバージョン数を変換しました...";
$GLOBALS['strConvertNothing']				= "変換対象のデータはありません...";
$GLOBALS['strConvertFinished']				= "統計データの変換が終了しました...";

$GLOBALS['strConvertExplaination']			= "
	統計データは、コンパクト形式で保存されていますが、いくつかの冗長形式のデータが発見されました。<br />
	冗長形式をコンパクト形式に変換しない場合、その冗長形式のデータは、統計として適切に表示できません。<br />
	統計データを変換する前に、必ずデータベースをバックアップしてください！<br />
	冗長形式をコンパクト形式に変換しますか？<br />
";


$GLOBALS['strConvertingExplaination']		= "
	すべての冗長形式をコンパクト形式に変換しました。 <br />
	多くのデータ数が冗長形式で保存されているため、終了まであと数分間必要です。<br />
	このまま他のページに移動せず、変換が終了するまでしばらくお待ちください。<br />
	実施したすべての修正履歴は、以下で確認できます。<br />
";

$GLOBALS['strConvertFinishedExplaination']  = "
	冗長形式の統計データ変換が完了し、すべての統計データが利用可能になっています。<br />
	実施したすべての修正履歴は、以下で確認できます。<br />
";


?>