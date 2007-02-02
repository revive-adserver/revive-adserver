<?php // $Revision: 2.1.2.3 $

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

//  Translator: Tadashi Jokagi <elf2000@users.sourceforge.net>
//  EN-Revision: 2.1.2.3

// This is by no means a complete list of all iso639-1 codes, but rather
// an unofficial list used by most browsers. If you have corrections or
// additions to this list, please send them to developers AT phpadsnew.com

$phpAds_ISO639['af'] = 'アフリカーンス語';
$phpAds_ISO639['sq'] = 'アルバニア語';
$phpAds_ISO639['eu'] = 'バスク語';
$phpAds_ISO639['bg'] = 'ブルガリア語';
$phpAds_ISO639['be'] = '白ロシア語';
$phpAds_ISO639['ca'] = 'カタロニア語';
$phpAds_ISO639['zh'] = '中国語';
$phpAds_ISO639['zh-cn'] = '- 中国語/中国';
$phpAds_ISO639['zh-tw'] = '- 中国語/台湾';
$phpAds_ISO639['hr'] = 'クロアチア語';
$phpAds_ISO639['cs'] = 'チェコ語';
$phpAds_ISO639['da'] = 'デンマーク語';
$phpAds_ISO639['nl'] = 'オランダ語';
$phpAds_ISO639['nl-be'] = '- オランダ語/ベルギー王国';
$phpAds_ISO639['en'] = '英語';
$phpAds_ISO639['en-gb'] = '- 英語/イギリス';
$phpAds_ISO639['en-us'] = '- 英語/アメリカ合衆国';
$phpAds_ISO639['fo'] = 'フェロー語';
$phpAds_ISO639['fi'] = 'フィンランド語';
$phpAds_ISO639['fr'] = 'フランス語';
$phpAds_ISO639['fr-be'] = '- フランス語/ベルギー王国';
$phpAds_ISO639['fr-ca'] = '- フランス語/カナダ';
$phpAds_ISO639['fr-fr'] = '- フランス語/フランス共和国';
$phpAds_ISO639['fr-ch'] = '- フランス語/スイス';
$phpAds_ISO639['gl'] = 'ガリシア語';
$phpAds_ISO639['de'] = 'ドイツ';
$phpAds_ISO639['de-au'] = '- ドイツ/オーストラリア共和国';
$phpAds_ISO639['de-de'] = '- ドイツ/ドイツ連邦共和国';
$phpAds_ISO639['de-ch'] = '- ドイツ/スイス';
$phpAds_ISO639['el'] = 'ギリシア語';
$phpAds_ISO639['hu'] = 'ハンガリー語';
$phpAds_ISO639['is'] = 'アイスランド語';
$phpAds_ISO639['id'] = 'インドネシア語';
$phpAds_ISO639['ga'] = 'アイルランド語';
$phpAds_ISO639['it'] = 'イタリア語';
$phpAds_ISO639['ja'] = '日本語';
$phpAds_ISO639['ko'] = '朝鮮語・韓国語';
$phpAds_ISO639['mk'] = 'マケドニア語';
$phpAds_ISO639['no'] = 'ノルウェー語';
$phpAds_ISO639['pl'] = 'ポーランド語';
$phpAds_ISO639['pt'] = 'ポルトガル語';
$phpAds_ISO639['pt-br'] = '- ポルトガル語/ブラジル';
$phpAds_ISO639['ro'] = 'ルーマニア語';
$phpAds_ISO639['ru'] = 'ロシア語';
$phpAds_ISO639['gd'] = 'スコットランドゲール語';
$phpAds_ISO639['sr'] = 'セルビア語';
$phpAds_ISO639['sk'] = 'スロバキア語';
$phpAds_ISO639['sl'] = 'スロベニア語';
$phpAds_ISO639['es'] = 'スペイン語';
$phpAds_ISO639['es-ar'] = '- スペイン語/アルゼンチン共和国';
$phpAds_ISO639['es-co'] = '- スペイン語/コロンビア共和国';
$phpAds_ISO639['es-mx'] = '- スペイン語/メキシコ合衆国';
$phpAds_ISO639['es-es'] = '- スペイン語/スペイン';
$phpAds_ISO639['sv'] = 'スウェーデン語';
$phpAds_ISO639['tr'] = 'トルコ語';
$phpAds_ISO639['uk'] = 'ウクライナ語'; 
$phpAds_ISO639['bs'] = 'ボスニア語';



// Load localized strings
if (file_exists(phpAds_path.'/language/'.$phpAds_config['language'].'/res-iso639.lang.php'))
	@include(phpAds_path.'/language/'.$phpAds_config['language'].'/res-iso639.lang.php');

?>