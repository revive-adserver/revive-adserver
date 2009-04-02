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
$Id: spc_ja.php 33995 2009-03-18 23:04:15Z chris.nutting $
*/

$conf = $GLOBALS['_MAX']['CONF'];
$name = (!empty($GLOBALS['_MAX']['PREF']['name'])) ? $GLOBALS['_MAX']['PREF']['name'] : MAX_PRODUCT_NAME;
$varprefix = $conf['var']['prefix'];

$words = array(
    'Single page call' => '単一ページ呼出',
    'SPC Header script comment' => "
      * {$name} JS インクルード
      * ページ内で単一ページ呼出を使用するには、次のコードを<head>タグ内に
      * インクルードしてください。
      *
      * 注意：詳しい使用方法は、ドキュメントを参照してください。
    ",
    'SPC codeblock comment' => "
      * 以下の各コードブロックは個々の広告ゾーンに対応しています。
      * 広告を表示するには、このタグを表示したい場所のHTMLに配置するだけです。
      *
    ",
    'SPC Header script instrct' => "
            ページ内で単一ページ呼出を使用するには、<head>タグ内で次の<script>
            タグをインストールしてください。
    ",
    'SPC codeblock instrct' => "
                 以下の各コードブロックは個々の広告ゾーンに対応しています。
                 広告を表示するには、このタグを表示したい場所のHTMLに配置するだけです。
    ",

    'Option - noscript' => '&lt;noscript&gt;タグをインクルードする',
    'Option - SSL' => 'SSLページ用のコードを生成する',
);
?>
