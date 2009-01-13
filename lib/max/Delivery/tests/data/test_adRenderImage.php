<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
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
    'appendtype' => 0,
    'bannertype' => 0,
    'alt_filename' => '',
    'alt_imageurl' => '',
    'alt_contenttype' => ''
);

$expect = "<a href='http://" . $GLOBALS['_MAX']['CONF']['webpath']['delivery'] .
    "/ck.php?{$conf['var']['params']}=2__{$conf['var']['adId']}=7__{$conf['var']['zoneId']}=0__cb={random}__{$conf['var']['dest']}=http://www.m3.net' target='{target}'>" .
    "<img src='http://" . $GLOBALS['_MAX']['CONF']['webpath']['images'] .
    "/m3_test_468x60_blue.gif' width='468' height='60' alt='' title='' border='0' /></a>" .
    "<div id='beacon_{random}' style='position: absolute; left: 0px; top: 0px; visibility: hidden;'>" .
    "<img src='http://" . $GLOBALS['_MAX']['CONF']['webpath']['delivery'] .
    "/lg.php?{$conf['var']['adId']}=7&amp;campaignid=2&amp;{$conf['var']['zoneId']}=0&amp;{$conf['var']['blockAd']}=60&amp;" .
    "referer=http%3A%2F%2Fsome.referrer.com%2F&amp;cb={random}' width='0' height='0' alt='' " .
    "style='width: 0px; height: 0px;' /></div>";

?>