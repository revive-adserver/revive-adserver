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
$Id$
*/

/**
 * @package    MaxDelivery
 * @subpackage TestSuite Data
 * @author     Monique Szpak <monique@m3.net>
 */

$zoneId		=	0;
$source		=	'';
$ct0		=	'';
$withText	=	false;
$logClick	=	true;
$logView	=	true;
$useAlt		=	false;
$loc		=	0;
$referer	= 	'http://some.referrer.com/';

$aBanner    =   array(
                    'ad_id' => 2,
                    'placement_id' => 1,
                    'active' => 't',
                    'name' => 'Flash web banner',
                    'type' => 'web',
                    'contenttype' => 'swf',
                    'pluginversion' => 6,
                    'filename' => 'm3-test-468x60.swf',
                    'imageurl' => '',
                    'htmltemplate' => '',
                    'htmlcache' => '',
                    'width' => 468,
                    'height' => 60,
                    'weight' => 1,
                    'seq' => 0,
                    'target' => '_blank',
                    'url' => 'http://www.m3.net',
                    'alt' => '',
                    'status' => '',
                    'bannertext' => '',
                    'adserver' => '',
                    'block' => 0,
                    'capping' => 0,
                    'session_capping' => 0,
                    'compiledlimitation' => 'true',
                    'append' => '',
                    'prepend' => '',
                    'bannertype' => 0,
                    'alt_filename' => 'm3_test_468x60.gif',
                    'alt_imageurl' => '',
                    'alt_contenttype' => 'gif'
                );


$expect =
'<div id=\'m3_051da95c5cb068cdd63cfbd10fa61fa9\' style=\'display: inline;\'><a href=\'http://'.$GLOBALS['_MAX']['CONF']['webpath']['delivery'].'/ck.php?maxparams=2__bannerid=2__zoneid=0__cb={random}\' target=\'{target}\'><img src=\'http://'.$GLOBALS['_MAX']['CONF']['webpath']['images'].'/'.$aBanner['alt_filename'].' width=\'468\' height=\'60\' alt=\'\' title=\'\' border=\'0\'></a></div>
<script type=\'text/javascript\'>
   var fo = new FlashObject(\'http://'.$GLOBALS['_MAX']['CONF']['webpath']['images'].'/'.$aBanner['filename'].'?clickTARGET=_blank&clickTAG=http://'.$GLOBALS['_MAX']['CONF']['webpath']['delivery'].'/ck.php?maxparams=2__bannerid=2__zoneid=0__cb={random}\', \'mymovie\', \'468\', \'60\', \'6\');
   //fo.addParam(\'wmode\',\'transparent\');
   fo.write(\'m3_051da95c5cb068cdd63cfbd10fa61fa9\');
</script><div id=\'beacon_2\' style=\'position: absolute; left: 0px; top: 0px; visibility: hidden;\'>
<img src=\'http://'.$GLOBALS['_MAX']['CONF']['webpath']['delivery'].'/lg.php?bannerid=2&amp;campaignid=1&amp;zoneid=0&amp;source=&amp;block=0&amp;capping=0&amp;session_capping=0&amp;loc=&amp;referer=0&amp;cb={random}\' width=\'0\' height=\'0\' alt=\'\' style=\'width: 0px; height: 0px;\'>
</div>';

$aPattern['pre']	= "<p>before<\/p>";
$aPattern['app']	= "<p>after<\/p>";

// break a known result structure down into individual elements
$aPattern['stru']   = '(?P<structure>(?P<divA><div (?P<divA_div_attrib>[\w\W\s]+)>'
                    .'(?P<divA_content>(?P<divA_href><a (?P<divA_href_attrib>[\w\W\s]+)>'
                    .'(?P<divA_img><img (?P<divA_img_attrib>[\w\W\s]+)>)'
                    .'<\/a>))'
                    .'<\/div>)[\s\W]*'
                    .'(?P<script><script (?P<script_attrib>[\w\W\s]+)>'
                    .'(?P<script_content>[\w\W\s]+)'
                    .'<\/script>)'
                    .'(?P<noscript_content><noscript>'
                    .'(?P<divB><div (?P<divB_attrib>[\w\W\s]+)>'
                    .'(?P<divB_content><img (?P<divB_img_attrib>[\w\W\s]+)>)'
                    .'<\/div>)'
                    .'))<\/noscript>';

//$aPattern[stru]     = '(?P<structure>'
//                    .'(?P<divA><div [\w\W\s]+<\/div>)[\s\W]'
//                    .'(?P<script><script [\w\W\s]+<\/script>)'
//                    .'(?P<divB><div [\w\W\s]+<\/div>)'
//                    .')';

// unused spares
$aPattern['div1']	= "<div id='m3_([\d\w]+)' style='display: inline;'><\/div>";
$aPattern['scr']	= "<script type='text\/javascript'>([\w\W\s]+)<\/script>";

$aPattern['obj']	= "var fo = new FlashObject(\'http://".$GLOBALS['_MAX']['CONF']['webpath']['images']."/".$aBanner['filename']."?clickTARGET=_blank&clickTAG=http://".$GLOBALS['_MAX']['CONF']['webpath']['delivery']."/ck.php?maxparams=2__bannerid=2__zoneid=0__cb={random}\', \'mymovie\', \'468\', \'60\', \'6\');";
$aPattern['par']	= "\/\/fo.addParam\('wmode','transparent'\);";
$aPattern['wri']	= "fo.write\('m3_([\d\w])+'\);";

$aPattern['url']	= "http(s)?:\/\/".$GLOBALS['_MAX']['CONF']['webpath']['delivery']."/\/lg.php\?bannerid=&amp;campaignid=&amp;zoneid=0&amp;source=&amp;block=&amp;capping=&amp;session_capping=&amp;loc=&amp;referer=0&amp;cb=\{random}";
$aPattern['div2']	= "<div id='beacon_' [\w\W\d\s]+><\/div>";


?>