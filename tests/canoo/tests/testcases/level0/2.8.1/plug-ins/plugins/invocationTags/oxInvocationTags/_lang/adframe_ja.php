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
$Id: adframe_ja.php 33995 2009-03-18 23:04:15Z chris.nutting $
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
