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

function Plugin_deliveryLog_oxLogConversion_logConversion_Delivery_logConversion($viewerId, $trackerId,
    $aTrackerImpression, $aConnection)
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    $table = $GLOBALS['_MAX']['CONF']['table']['prefix'] . 'data_bkt_a';

    $fields = array(
        'server_ip' => $aTrackerImpression['server_raw_ip'],
        'tracker_id' => $trackerId,
        'date_time' => gmdate('Y-m-d H:i:s'),
        'action_date_time' => gmdate('Y-m-d H:i:s', $aConnection['dt']),
        'creative_id' => $aConnection['cid'],
        'zone_id' => $aConnection['zid'],
        'ip_address' => $_SERVER['REMOTE_ADDR'],
        'action' => $aConnection['action_type'],
        'window' => $aConnection['window'],
        'status' => $aConnection['status']
    );

    array_walk($fields, 'OX_escapeString');

    $query = "
        INSERT INTO {$table}
            (" . implode(', ', array_keys($fields)) . ")
            VALUES ('" . implode("', '", $fields) . "')
    ";
    return OA_Dal_Delivery_query($query, 'rawDatabase');
}

?>