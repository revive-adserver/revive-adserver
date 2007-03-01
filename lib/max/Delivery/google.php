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
$Id$
*/

/**
 * @package    MaxDelivery
 * @subpackage google
 * @author     Matteo Beccati <matteo.beccati@openads.org>
 */

require_once MAX_PATH . '/lib/max/Delivery/common.php';

/**
 * This function outputs the javascript code to track Google Adsense banners
 *
 */
function MAX_googleGetJavaScript()
{
    $conf = $GLOBALS['_MAX']['CONF'];

    $ag = file_get_contents(MAX_PATH.'/lib/max/Delivery/templates/ag.js');

    $from  = array();
    $to    = array();
    foreach (array('click', 'frame') as $k) {
        $v = $conf['file'][$k];
        $k = strtoupper($k);
        $from[] = "@@F_{$k}@@";
        $to[]   = $v;
        $from[] = "@@F_{$k}_PREG@@";
        $to[]   = preg_quote($v);
    }
    foreach ($conf['var'] as $k => $v) {
        $k = strtoupper($k);
        $from[] = "@@V_{$k}@@";
        $to[]   = $v;
        $from[] = "@@V_{$k}_PREG@@";
        $to[]   = preg_quote($v);
    }

    $ag = str_replace($from, $to, $ag);

    return $ag;
}

?>
