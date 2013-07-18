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
    'Popup Tag' => 'ポップアップタグ',
    'Allow Popup Tags' => 'ポップアップタグを許可する',

    'Third Party Comment' => "
  -- この広告が他社Adサーバを通して配信される場合、'Insert_Clicktrack_URL_Here'の
  -- テキスト部分をクリック追跡URLと入れ替えるのを忘れないでください。
  --
  --
  -- この広告が他社Adサーバを通して配信される場合、'Insert_Random_Number_Here'の
  -- テキスト部分をクリック追跡URLと入れ替えるのを忘れないでください。
  --
  --",

    'Comment' => "
  -- このタグは非SSLページで使用するために生成されました。
  -- このタグがSSLページに配置される場合、以下のように変更してください。
  -- 変更前）  'http://{$conf['webpath']['delivery']}/...'
  -- 
  -- 変更後）  'https://{$conf['webpath']['deliverySSL']}/...'
  --"
);

?>
