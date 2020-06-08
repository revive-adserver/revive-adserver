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

// Other
$GLOBALS['strCopyToClipboard'] = "クリップボードにコピーする";
$GLOBALS['strCopy'] = "コピー";
$GLOBALS['strChooseTypeOfInvocation'] = "バナーの呼出方法を選択してください";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "バナーの呼出方法を選択してください";

// Measures
$GLOBALS['strAbbrPixels'] = "ピクセル";
$GLOBALS['strAbbrSeconds'] = "秒";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "バナーの選択";
$GLOBALS['strInvocationCampaignID'] = "キャンペーン";
$GLOBALS['strInvocationTarget'] = "ターゲットフレーム";
$GLOBALS['strInvocationSource'] = "ソースパラメータ";
$GLOBALS['strInvocationWithText'] = "バナー直下にテキストを表示する";
$GLOBALS['strInvocationDontShowAgain'] = "同一ページにバナーを再表示しない";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "同一ページに同一キャンペーンを再表示しない";
$GLOBALS['strInvocationTemplate'] = "テンプレートととして利用可能なようにバナーを変数内に保存する";
$GLOBALS['strInvocationBannerID'] = "バナーID";
$GLOBALS['strInvocationComments'] = "コメントを含める";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "リフレッシュ時間";
$GLOBALS['strIframeResizeToBanner'] = "バナーサイズに応じてiframeをリサイズする";
$GLOBALS['strIframeMakeTransparent'] = "iframeを透過にする";
$GLOBALS['strIframeIncludeNetscape4'] = "Netscape4互換のilayerを含める";
$GLOBALS['strIframeGoogleClickTracking'] = "AdSenseのクリックを追跡するコードを含める";

// PopUp
$GLOBALS['strPopUpStyle'] = "ポップアップスタイル";
$GLOBALS['strPopUpStylePopUp'] = "ポップアップ";
$GLOBALS['strPopUpStylePopUnder'] = "ポップアンダー";
$GLOBALS['strPopUpCreateInstance'] = "ポップアップ作成時のインスタンス";
$GLOBALS['strPopUpImmediately'] = "直後";
$GLOBALS['strPopUpOnClose'] = "ページクローズ時";
$GLOBALS['strPopUpAfterSec'] = "秒後";
$GLOBALS['strAutoCloseAfter'] = "自動クローズ秒数";
$GLOBALS['strPopUpTop'] = "初期ポジション（トップ）";
$GLOBALS['strPopUpLeft'] = "初期ポジション（レフト）";
$GLOBALS['strWindowOptions'] = "ウィンドウオプション";
$GLOBALS['strShowToolbars'] = "ツールバー";
$GLOBALS['strShowLocation'] = "表示位置";
$GLOBALS['strShowMenubar'] = "メニューバー";
$GLOBALS['strShowStatus'] = "ステータス";
$GLOBALS['strWindowResizable'] = "サイズ可変";
$GLOBALS['strShowScrollbars'] = "スクロールバー";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "ホスト言語";
$GLOBALS['strXmlRpcProtocol'] = "XML-RPCサーバとHTTPSで通信する";
$GLOBALS['strXmlRpcTimeout'] = "XML-RPCタイムアウト秒数";

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack'] = "他社クリック追跡をサポートする";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "キャッシュ破棄コードを挿入する";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "警告";
$GLOBALS['strImgWithAppendWarning'] = "トラッカーコードを追加しました。追加コードは、<strong>Javescriptタグ</strong>で動作します。";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Warning:</strong> Local mode invocation will ONLY work if the site calling the code
is on the same physical machine as the adserver</span><br />
Check that the MAX_PATH defined in the code below points to the base directory of your MAX installation<br />
and that you have a config file for the domain of the site showing the ads (in MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Note:</b> Local Mode invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Note:</b> XML-RPC invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
