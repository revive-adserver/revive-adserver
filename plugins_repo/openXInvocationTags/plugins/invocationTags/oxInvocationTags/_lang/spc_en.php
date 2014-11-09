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
    'Single page call' => 'Single page call',
    'SPC Header script comment' => "      * {$name} JS include
      * To use single page call on your page, include the
      * following <script> code in your site's <head> tag
      *
      * Note: See the documentation for more advanced usage",
    'SPC codeblock comment' => "      * Each of the code blocks below refers to an individual ad placement zone,
      * to show the ad, just place the tag into your page HTML
      * at the position that you want the ad to show",
    'SPC Header script instrct' => "      To use single page call on your page include the
      following <script> code in your site's <head> tag",
    'SPC codeblock instrct' => "      Each of the code blocks below refers to an
        individual ad placement zone to show the ad, just place the tag into your
        page HTML at the position that you want the ad to show",
    'Option - noscript' => 'Include &lt;noscript&gt; tags',
    'Option - SSL' => 'Generate code for use on SSL pages',
);

?>