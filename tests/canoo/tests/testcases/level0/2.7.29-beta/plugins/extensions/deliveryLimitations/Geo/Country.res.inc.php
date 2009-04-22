<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
$Id: Country.res.inc.php 25933 2008-09-18 15:12:50Z chris.nutting $
*/

/**
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Chris Nutting <chris.nutting@openx.org>
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 *
 * @todo       The $this->translate calls below won't pull into the .pot files correctly...
 *             we need to look into how best to do these kinds of bulk translates
 */

if (!isset($GLOBALS['_MAX']['_GEOCACHE']['country'])) {
    $pathPlugins = MAX_PATH.$GLOBALS['_MAX']['CONF']['pluginPaths']['extensions'].'/deliveryLimitations/Geo/data/';
    require $pathPlugins.'res-iso3166.inc.php';

    $res = array();

    foreach ($OA_Geo_ISO3166 as $k => $v) {
        if (!in_array($k, $OA_Geo_ISO3166_Deprecated) && !in_array($k, $OA_Geo_ISO3166_MaxMind)) {
            $res[$k] = $this->translate($v);
        }
    }

    asort($res);

    foreach ($OA_Geo_ISO3166_MaxMind as $k => $v) {
        $res[$k] = $this->translate($v);
    }

    $GLOBALS['_MAX']['_GEOCACHE']['country'] = $res;
} else {
    $res = $GLOBALS['_MAX']['_GEOCACHE']['country'];
}

?>
