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

$conf = $GLOBALS['_MAX']['CONF'];

$words = array(
    'Interstitial or Floating DHTML Tag' => 'インタスティシャル／フローティングDHTMLタグ',
    'Allow Interstitial or Floating DHTML Tags' => 'インタスティシャル／フローティングDHTMLタグを許可する',
    'Third Party Comment' => "
  * この広告が他社Adサーバを通して配信される場合、｛clickurl｝のテキスト部分をクリック追跡URL
  * と入れ替えるのを忘れないでください。
  * 
  *",

    'Cache Buster Comment' => "
  * すべての{random}インスタンスを生成されたランダム番号（もしくはタイプスタンプ）と置き換えて
  * ください。
  *",

    'SSL Backup Comment' => "",

    'SSL Delivery Comment' => "
  * このタグは非SSLページで使用するために生成されました。
  * このタグがSSLページに配置される場合、以下のように変更してください。
  * 変更前）  'http://{$conf['webpath']['delivery']}/...'
  * 
  * 変更後）  'https://{$conf['webpath']['deliverySSL']}/...'
  *",
);

// The simple and geocities plugins require access to some images
if (isset($GLOBALS['layerstyle']) &&
    ($GLOBALS['layerstyle'] == 'geocities' || $GLOBALS['layerstyle'] == 'simple')) {
    $words['Comment'] = '
  *------------------------------------------------------------*
  * このインタスティシャル呼出コードは、以下のディレクトリ内の画像を必要とします：
  * /www/images/layerstyles/'.$GLOBALS['layerstyle'].'/...
  * HTTP(S)アクセスを可能にしてください: http(s)://' . $conf['webpath']['images'] . '/layerstyles/'.$GLOBALS['layerstyle'].'/...
  *------------------------------------------------------------*';
} else {
    $words['Comment'] = '';
}
?>
