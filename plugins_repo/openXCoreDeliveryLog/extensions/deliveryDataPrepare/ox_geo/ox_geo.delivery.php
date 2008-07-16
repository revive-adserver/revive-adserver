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
$Id$
*/

// if (isset($aConf['geotargeting']['saveStats'])

// Dependencies
###START_STRIP_DELIVERY
$GLOBALS['_MAX']['pluginsDependencies']['deliveryDataPrepare:ox_geo:ox_geo'] = array(
    'deliveryDataPrepare:ox_core:ox_core',
);
###END_STRIP_DELIVERY

// @todo - move geotargeting into here - it seems to be included by delivery right now, should it be moved in here?
function OA_Plugins_deliveryDataPrepare_ox_geo(&$data)
{
    if (!empty($GLOBALS['_MAX']['CLIENT_GEO'])) {
        $data['geo'] = $GLOBALS['_MAX']['CLIENT_GEO'];
    } else {
        $data['geo'] = array(
            'country_code'  => null,
            'region'        => null,
            'city'          => null,
            'postal_code'   => null,
            'latitude'      => null,
            'longitude'     => null,
            'dma_code'      => null,
            'area_code'     => null,
            'organisation'  => null,
            'netspeed'      => null,
            'continent'     => null
        );
    }
}

?>