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
$Id: adjs_ja.php 33995 2009-03-18 23:04:15Z chris.nutting $
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
