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
 * This function logs the variable data passed in to a tracker impression
 *
 * @param array  $variables                     An array of the variable name=value data to be logged
 * @param int    $trackerId                     The tracker ID
 * @param int    $serverRawTrackerImpressionId  The associated tracker-impression ID for these values
 * @param string $serverRawIp                   The IP address of the raw database that logged the
 *                                              initial tracker-impression
 * @return bool True on success
 */
function Plugin_deliveryLog_oxLogConversion_logConversion_Delivery_logConversionVariable($variables, $trackerId, $serverRawTrackerImpressionId, $serverRawIp)
{
    $table = $GLOBALS['_MAX']['CONF']['table']['prefix'] . 'data_bkt_a_var';
    $aRows = array();
    foreach ($variables as $variable) {
        $aRows[] = "(
                        '{$serverRawTrackerImpressionId}',
                        '{$serverRawIp}',
                        '{$variable['variable_id']}',
                        '".OX_escapeString($variable['value'])."',
                        'date_time' => gmdate('Y-m-d H:i:s'),
                    )";
    }
    if (empty($aRows)) {
        return;
    }
    $query = "
        INSERT INTO
            {$table}
            (
                server_conv_id,
                server_ip,
                tracker_variable_id,
                value,
                date_time
            )
        VALUES " . implode(',', $aRows);

    return OA_Dal_Delivery_query($query, 'rawDatabase');
}

?>