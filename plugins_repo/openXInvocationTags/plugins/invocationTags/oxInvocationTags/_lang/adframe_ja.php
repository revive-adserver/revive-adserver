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
    'iFrame Tag' => 'iFrameタグ',
    'Allow iFrame Tags' => 'iFrameタグを許可する',

    'Comment' => "
  * iFrameがクライアントのブラウザでサポートされていない場合、このタグはイメージバナーだけを表示
  * します。その際、表示するイメージバナーは幅か高さが指定されないため、イメージバナー表示用に
  * このタグを配置する場合、<img>タグ内で幅や高さを必ず指定してください。
  * ",

    'Placement Comment' => "コードを</body>タグの直前に挿入してください"
);

?>
