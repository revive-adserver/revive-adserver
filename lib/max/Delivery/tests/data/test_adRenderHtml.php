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

$zoneId = 0;
$source = '';
$ct0 = '';
$withText = false;
$logClick = true;
$logView = true;
$useAlt = false;
$loc = 0;
$referer = 'http://some.referrer.com/';

$aBanner = [
    'ad_id' => 4,
    'placement_id' => 1,
    'active' => 't',
    'name' => 'Test HTML (1)',
    'type' => 'html',
    'contenttype' => '',
    'pluginversion' => 0,
    'filename' => '',
    'imageurl' => '',
    'width' => 468,
    'height' => 60,
    'weight' => 1,
    'seq' => 0,
    'target' => '',
    'url' => '',
    'alt' => '',
    'status' => '',
    'bannertext' => 'bannertext',
    'adserver' => '',
    'block' => 0,
    'capping' => 0,
    'session_capping' => 0,
    'compiledlimitation' => 'true',
    'append' => 'append',
    'prepend' => 'prepend',
    'bannertype' => 0,
    'alt_filename' => '',
    'alt_imageurl' => '',
    'alt_contenttype' => '',
    'htmltemplate' => '<a href="https://www.example.com/">Foobar</a>',
    'htmlcache' => '<a href="{clickurl_html}https://www.example.com/">Foobar</a>',
];

$expect = 'prepend<a href="{clickurl_html}https://www.example.com/">Foobar</a>append';
