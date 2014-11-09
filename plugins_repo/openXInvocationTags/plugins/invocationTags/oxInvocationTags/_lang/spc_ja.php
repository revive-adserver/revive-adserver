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