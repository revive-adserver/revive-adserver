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
$Id: spc_en.php 33995 2009-03-18 23:04:15Z chris.nutting $
*/

$conf = $GLOBALS['_MAX']['CONF'];
$name = (!empty($GLOBALS['_MAX']['PREF']['name'])) ? $GLOBALS['_MAX']['PREF']['name'] : MAX_PRODUCT_NAME;
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
