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
$Id: Region.res.inc.php 33995 2009-03-18 23:04:15Z chris.nutting $
*/

/**
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Chris Nutting <chris.nutting@openx.org>
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */

if (!isset($GLOBALS['_MAX']['_GEOCACHE']['region'])) {
    $pathPlugins = dirname(__FILE__) . '/data/';
    require $pathPlugins.'res-iso3166.inc.php';
    require $pathPlugins.'res-iso3166-2.inc.php';
    require $pathPlugins.'res-fips.inc.php';

    foreach ($OA_Geo_FIPS as $k => $v) {
        if ($k == 'US' || $k == 'CA') {
            $v = $OA_Geo_ISO3166_2[$k];
        }
        $res[$k] = array($OA_Geo_ISO3166[$k]) + $v;
    }

    uasort($res, create_function('$a,$b', 'return strcmp($a[0], $b[0]);'));

    $GLOBALS['_MAX']['_GEOCACHE']['region'] = $res;
} else {
    $res = $GLOBALS['_MAX']['_GEOCACHE']['region'];
}

?>
