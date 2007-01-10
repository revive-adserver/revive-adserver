<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
*/

/**
 * @package    Delivery
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
            'autohtml' => 'f',
            'adserver' => '',
            'block' => 60,
            'capping' => 0,
            'session_capping' => 0,
            'compiledlimitation' => 'true',
            'append' => '',
            'appendtype' => 0,
            'bannertype' => 0,
            'alt_filename' => '',
            'alt_imageurl' => '',
            'alt_contenttype' => ''
            );


$expect     = "<a href='http://".$GLOBALS['_MAX']['CONF']['webpath']['delivery']."/ck.php?maxparams=2__bannerid=7__zoneid=0__cb={random}__maxdest=http://www.m3.net' target='{target}'><img src='http://".$GLOBALS['_MAX']['CONF']['webpath']['images']."/m3_test_468x60_blue.gif' width='468' height='60' alt='' title='' border='0'></a><div id='beacon_7' style='position: absolute; left: 0px; top: 0px; visibility: hidden;'><img src='http://".$GLOBALS['_MAX']['CONF']['webpath']['delivery']."/lg.php?bannerid=7&amp;campaignid=2&amp;zoneid=0&amp;source=&amp;block=60&amp;capping=0&amp;session_capping=0&amp;channel_ids=&amp;MAXZBLOCK=&amp;MAXZCAP=&amp;MAXSZCAP=&amp;loc=0&amp;referer=http%3A%2F%2Fsome.referrer.com%2F&amp;cb={random}' width='0' height='0' alt='' style='width: 0px; height: 0px;'></div>";
//$sPattern   = "http(s)?:\/\/".$GLOBALS['_MAX']['CONF']['webpath']['delivery']."/\/lg.php\?bannerid=&amp;campaignid=&amp;zoneid=0&amp;source=&amp;block=&amp;capping=&amp;session_capping=&amp;loc=&amp;referer=0&amp;cb=\{random}";
?>