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
$Id: ja.php 33995 2009-03-18 23:04:15Z chris.nutting $
*/

$conf = $GLOBALS['_MAX']['CONF'];

$words = array(
    'Please choose the type of banner invocation' => 'バナー呼出タイプを選択してください',

    // Other
    'Copy to clipboard' => 'クリップボードにコピーする',
    'copy' => 'コピー',

    // Measures
    'px' => 'ピクセル',
    'sec' => '秒',

    // Common Invocation Parameters
    'Banner selection' => 'バナー選択',
    'Advertiser' => '広告主',
    'Campaign' => 'キャンペーン',
    'Target frame' => 'ターゲットフレーム',
    'Source' => 'ソース',
    'Show text below banner' => 'バナー直下にテキストを表示する',
    'Don\'t show the banner again on the same page' => '同一ページ内にバナーを表示しない',
    'Don\'t show a banner from the same campaign again on the same page' => '同一ページ内に同じキャンペーンのバナーを表示しない',
    'Store the banner inside a variable so it can be used in a template' => 'テンプレートとして再利用可能なようにバナーを変数に格納する',
    'Banner ID' => 'バナーID',
    'No Zones Available!' => '有効なゾーンがありません',
    'Include comments' => 'コメントを含める',

    // AdLayer
    'Style' => 'スタイル',
    'Alignment' => '位置あわせ',
    'Horizontal alignment' => '水平方向',
    'Left' => '左寄せ',
    'Center' => '中寄せ',
    'Right' => '右寄せ',
    'Vertical alignment' => '垂直方向',
    'Top' => '上配置',
    'Middle' => '中配置',
    'Bottom' => '下配置',
    'Automatically collapse after' => '自動消滅秒数',
    'Close text' => 'クローズ用テキスト',
    '[Close]' => '[閉じる]',
    'Banner padding' => 'バナー用パディング文字',
    'Horizontal shift' => '水平方向にシフト',
    'Vertical shift' => '垂直方向にシフト',
    'Show close button' => 'クローズボタンを表示',
    'Background color' => '背景色',
    'Border color' => '境界色',
    'Direction' => '移動方向',
    'Left to right' => '左から右',
    'Right to left' => '右から左',
    'Looping' => 'ループ状',
    'Always active' => '常にアクティブ',
    'Speed' => 'スピード',
    'Pause' => '一時停止',
    'Limited' => '制限条件',
    'Left margin' => '左マージン',
    'Right margin' => '右マージン',
    'Transparent background' => '背景の透過',
    'Smooth movement' => 'スムースに移動',
    'Hide the banner when the cursor is not moving' => 'カーソル停止時はバナーを隠す',
    'Delay before banner is hidden' => 'バナー消滅までの遅延時間',
    'Transparancy of the hidden banner' => '消滅バナーの透過度',
    'Support 3rd Party Server Clicktracking' => '他社クリック追跡をサポートする',

    // Iframe
    'Refresh after' => 'リフレッシュ時間',
    'Resize iframe to banner dimensions' => 'バナーサイズに応じてiframeをリサイズする',
    'Make the iframe transparent' => 'iframeを透過にする',
    'Include Netscape 4 compatible ilayer' => 'Netscape4互換のilayerを含める',

    // PopUp
    'Pop-up type' => 'ポップアップスタイル',
    'Pop-up' => 'ポップアップ',
    'Pop-under' => 'ポップアンダー',
    'Instance when the pop-up is created' => 'ポップアップ作成時のインスタンス',
    'Immediately' => '直後',
    'When the page is closed' => 'ページクローズ時',
    'After' => '秒後',
    'Automatically close after' => '自動クローズ秒数',
    'Initial position (top)' => '初期ポジション（トップ）',
    'Initial position (left)' => '初期ポジション（レフト）',
    'Window options' => 'ウィンドウオプション',
    'Toolbars' => 'ツールバー',
    'Location' => '表示位置',
    'Menubar' => 'メニューバー',
    'Status' => 'ステータス',
    'Resizable' => 'サイズ可変',
    'Scrollbars' => 'スクロールバー',

    // XML-RPC
    'Host Language' => 'ホスト言語',
    'Use HTTPS to contact XML-RPC Server' => 'XML-RPCサーバとHTTPSで通信する',
    'XML-RPC Timeout (Seconds)' => 'XML-RPCタイムアウト秒数',

    // Default invocation comments
    // These can be over-ridden (or blanked out completely) by setting them in the individual packages
    'Third Party Comment' => "
  * この広告が他社Adサーバを通して配信される場合、｛clickurl｝のテキスト部分をクリック追跡URL
  * と入れ替えるのを忘れないでください。
  *",



    'Cache Buster Comment' => "
  * すべての{random}インスタンスを生成されたランダム番号（もしくはタイプスタンプ）と置き換えて
  * ください。
  *",

    'SSL Backup Comment' => "
  * このタグの予備イメージセクションは、非SSLページで使用するために生成されました。
  * このタグがSSLページに配置される場合、以下のように変更してください。
  * 変更前）  'http://{$conf['webpath']['delivery']}/...'
  *
  * 変更後）  'https://{$conf['webpath']['deliverySSL']}/...'
  *",

    'SSL Delivery Comment' => "
  * このタグは非SSLページで使用するために生成されました。
  * このタグがSSLページに配置される場合、以下のように変更してください。
  * 変更前）  'http://{$conf['webpath']['delivery']}/...'
  * 
  * 変更後）  'https://{$conf['webpath']['deliverySSL']}/...'
  *",
);

?>
