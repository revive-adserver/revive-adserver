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

$conf = $GLOBALS['_MAX']['CONF'];

$zoneId		=	0;
$source		=	'';
$ct0		=	'';
$withText	=	false;
$logClick	=	true;
$logView	=	true;
$useAlt		=	false;
$richMedia  =   true;
$loc		=	0;
$referer	= 	'http://some.referrer.com/';
$useAppend  =   true;

$aBanner = array (
    'ad_id' => 7,
    'placement_id' => 2,
    'client_id' => 3,
    'active' => 't',
    'name' => 'Blue - Capped 1 per min',
    'type' => 'web',
    'contenttype' => 'gif',
    'pluginversion' => 0,
    'filename' => 'm3_test_468x60_blue.gif',
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
    'block_ad' => 60,
    'cap_ad' => 0,
    'session_cap_ad' => 0,
    'compiledlimitation' => 'true',
    'append' => '',
    'prepend' => '',
    'bannertype' => 0,
    'alt_filename' => '',
    'alt_imageurl' => '',
    'alt_contenttype' => ''
);

$expect = "<a href='{clickurl_html}' target='{target}'>" .
    "<img src='http://" . $GLOBALS['_MAX']['CONF']['webpath']['images'] .
    "/m3_test_468x60_blue.gif' width='468' height='60' alt='' title='' border='0' /></a>" .
    "<div id='beacon_{random}' style='position: absolute; left: 0px; top: 0px; visibility: hidden;'>" .
    "<img src='http://" . $GLOBALS['_MAX']['CONF']['webpath']['delivery'] .
    "/lg.php?{$conf['var']['adId']}=7&amp;campaignid=2&amp;{$conf['var']['zoneId']}=0&amp;{$conf['var']['blockAd']}=60&amp;" .
    "referer=http%3A%2F%2Fsome.referrer.com%2F&amp;cb={random}' width='0' height='0' alt='' " .
    "style='width: 0px; height: 0px;' /></div>";

?>