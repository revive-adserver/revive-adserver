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
    'Javascript Tag' => 'Javascriptタグ',
    'Allow Javascript Tags' => 'Javascriptタグを許可する',
    
    'SSL Delivery Comment' => '',
    
    'Comment' => "
  * このタグのnoscriptセクションはイメージバナーだけを表示します。その際、表示するイメージバナーは
  * 幅か高さが指定されないため、イメージバナー表示用にこのタグを配置する場合、<img>タグ内で幅や
  * 高さを必ず指定してください。
  * 
  *
  * もし、noscriptセクションの動作を無効にしたい場合、<noscript>タグそのものを削除してください。
  * noscriptタグは、平均して1%未満のインターネットユーザからリクエストされます。
  * 
  * ",

    'Insert click tracking URL here' => 'クリック追跡タグをここに挿入してください'
);

?>
