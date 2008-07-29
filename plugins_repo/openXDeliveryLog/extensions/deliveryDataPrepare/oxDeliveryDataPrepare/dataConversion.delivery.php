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

MAX_Dal_Delivery_Include();

/**
 * Component prepares data which may be used by deliveryLog extensions
 * or other deliveryDataPrepare components as a base for their data preparations.
 * All data is stored in $GLOBALS['_MAX']['deliveryData']
 *
 * @param int $viewerId
 * @param int $trackerId
 */
function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_Conversion($viewerId, $trackerId)
{
    // prevent from running twice
    static $executed;
    if ($executed) return;
    $executed = true;

    $GLOBALS['_MAX']['deliveryData']['tracker_ip'] = $trackerId;
    $GLOBALS['_MAX']['deliveryData']['viewer_ip'] = $viewerId;

    if (isset($aConf['rawDatabase']['serverConversion'])) {
        $serverConversion = $GLOBALS['_MAX']['CONF']['rawDatabase']['serverConversion'];
    } else {
        $serverConversion = $GLOBALS['_MAX']['CONF']['rawDatabase']['host'];
    }
    $GLOBALS['_MAX']['deliveryData']['server_ip'] = $serverConversion;
}

// Followig methods are required due to functions names limitations
function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_Conversion_Delivery_logImpression($viewerId, $trackerId)
{
    Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_Conversion($viewerId, $trackerId);
}

function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_Conversion_Delivery_logRequest($viewerId, $trackerId)
{
    Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_Conversion($viewerId, $trackerId);
}

function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_Conversion_Delivery_logClick($viewerId, $trackerId)
{
    Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_Conversion($viewerId, $trackerId);
}

function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_Conversion_Delivery_logConversion($viewerId, $trackerId)
{
    Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_Conversion($viewerId, $trackerId);
}

?>