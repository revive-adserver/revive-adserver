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

function Plugins_deliveryLog_oxLogConversion_logConversion_Delivery_logConversion()
{
    $data = $GLOBALS['_MAX']['deliveryData'];
    $aQuery = array(
        'server_ip'   => $data['server_ip'],
        'tracker_id' => $data['tracker_id'],
        'date_time'     => $data['interval_start'],
        'action_date_time'     => $data['interval_start'],
        'creative_id'     => $data['creative_id'], // @todo - take it from cookie?
        'zone_id'     => $data['zone_id'], // @todo - take it from cookie?
        'ip_address'     => $data['ip_address'],
    );
    return OX_bucket_updateTable('data_bkt_c', $aQuery);
}

?>