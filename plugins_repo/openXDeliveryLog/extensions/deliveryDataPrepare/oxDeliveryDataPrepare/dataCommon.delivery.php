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

###START_STRIP_DELIVERY
/**
 * Dependencies between the plugins - used to set the order in which the components
 * are executed by delivery engine when calling components to log the data.
 */
$GLOBALS['_MAX']['pluginsDependencies']['deliveryDataPrepare:ox_core:ox_core'] = array();
###END_STRIP_DELIVERY

// This code should be automatically compiled by code generator
MAX_Dal_Delivery_Include();

/**
 * Component prepares data which may be used by deliveryLog extensions
 * or other deliveryDataPrepare components as a base for their data preparations.
 * All data is stored in $GLOBALS['_MAX']['deliveryData']
 *
 * @param unknown_type $data
 */
function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCore($viewerId, $adId, $creativeId, $zoneId)
{
    // no need to set the same data twice
    static $executed;
    if ($executed) return;
    $executed = true;

    $GLOBALS['_MAX']['deliveryData']['creative_id'] = $adId;
    $GLOBALS['_MAX']['deliveryData']['zone_id'] = $zoneId;

    // calculate start date of current Operation Interval
    $time = !empty($GLOBALS['_MAX']['NOW']) ? $GLOBALS['_MAX']['NOW'] : time();
    $oi = $GLOBALS['_MAX']['CONF']['maintenance']['operationInterval'];
    $GLOBALS['_MAX']['deliveryData']['interval_start'] = gmdate('Y-m-d H:i:s', $time - $time % ($oi * 60));
}

function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCore_Delivery_logImpression($viewerId, $adId, $creativeId, $zoneId)
{
    Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCore($viewerId, $adId, $creativeId, $zoneId);
}

function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCore_Delivery_logRequest($viewerId, $adId, $creativeId, $zoneId)
{
    Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCore($viewerId, $adId, $creativeId, $zoneId);
}

function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCore_Delivery_logClick($viewerId, $adId, $creativeId, $zoneId)
{
    Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCore($viewerId, $adId, $creativeId, $zoneId);
}

?>