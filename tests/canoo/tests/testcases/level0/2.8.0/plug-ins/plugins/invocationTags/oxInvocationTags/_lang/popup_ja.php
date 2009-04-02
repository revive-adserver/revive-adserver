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
$Id: popup_ja.php 33995 2009-03-18 23:04:15Z chris.nutting $
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
