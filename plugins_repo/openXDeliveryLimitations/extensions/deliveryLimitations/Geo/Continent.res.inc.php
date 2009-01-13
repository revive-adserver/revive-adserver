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

require_once MAX_PATH . $GLOBALS['_MAX']['CONF']['pluginPaths']['extensions'].'/deliveryLimitations/Geo/data/res-continent.inc.php';

/**
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Chris Nutting <chris.nutting@openx.org>
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
if (!isset($GLOBALS['_MAX']['_GEOCACHE']['continent'])) {
    global $OA_Geo_continent, $OA_Geo_cont_name;
    $res = array();

    foreach ($OA_Geo_cont_name as $k => $v) {
        $res[$k] = array($v);
    }

    foreach ($OA_Geo_continent as $k => $v) {
        $res[$v][] = $k;
    }

    $GLOBALS['_MAX']['_GEOCACHE']['continent'] = $res;
} else {
    $res = $GLOBALS['_MAX']['_GEOCACHE']['continent'];
}

?>
