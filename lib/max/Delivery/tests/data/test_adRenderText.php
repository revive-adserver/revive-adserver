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

/**
 * @package    MaxDelivery
 * @subpackage TestSuite Data
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
$conf = $GLOBALS['_MAX']['CONF'];

$aBanner    =   array(
    'ad_id' => 5,
    'placement_id' => 1,
    'active' => 't',
    'name' => 'Text ad',
    'type' => 'txt',
    'contenttype' => 'txt',
    'pluginversion' => 0,
    'filename' => '',
    'imageurl' => '',
    'htmltemplate' => '',
    'htmlcache' =>  '',
    'width' => 0,
    'height' => 0,
    'weight' => 1,
    'seq' => 0,
    'target' => '_blank',
    'url' => 'http://www.m3.net',
    'alt' => '',
    'status' => '',
    'bannertext' => 'm3 media services',
    'adserver' => '',
    'block' => 0,
    'capping' => 0,
    'session_capping' => 0,
    'compiledlimitation' => true,
    'append' => '',
    'prepend' => '',
    'bannertype' => 0,
    'alt_filename' => '',
    'alt_imageurl' => '',
    'alt_contenttype' => '',
);

$expectNoBeacon =
"<a href='http://{$GLOBALS['_MAX']['CONF']['webpath']['delivery']}/{$GLOBALS['_MAX']['CONF']['file']['click']}?{$conf['var']['params']}=2__{$conf['var']['adId']}=5__{$conf['var']['zoneId']}=0__{$conf['var']['cacheBuster']}={random}__{$conf['var']['dest']}=http%3A%2F%2Fwww.m3.net' target='_blank'>m3 media services</a>";
$expect = $expectNoBeacon .
"<div id='beacon_{random}' style='position: absolute; left: 0px; top: 0px; visibility: hidden;'><img src='http://{$GLOBALS['_MAX']['CONF']['webpath']['delivery']}/{$GLOBALS['_MAX']['CONF']['file']['log']}?{$conf['var']['adId']}=5&amp;campaignid=1&amp;{$conf['var']['zoneId']}=0&amp;referer=http%3A%2F%2Fsome.referrer.com%2F&amp;cb={random}' width='0' height='0' alt='' style='width: 0px; height: 0px;' /></div>";

?>
