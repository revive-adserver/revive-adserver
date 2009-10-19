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
$Id: adlayer_ja.php 33995 2009-03-18 23:04:15Z chris.nutting $
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
