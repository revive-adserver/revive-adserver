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
$Id: logConversionVariable.delivery.php 36131 2009-05-08 16:55:55Z chris.nutting $
*/

/**
 * @package    Plugin
 * @subpackage openxDeliveryLog
 */

MAX_Dal_Delivery_Include();

/**
 * This function logs the variable data passed in to a tracker impression
 *
 * @param array  $aVariables An array of the variable IDs and values to be logged.
 * @param int    $trackerId The tracker ID.
 * @param int    $serverConvId The associated conversion ID for these values.
 * @param string $serverRawIp The associated server identifier for these values.
 * @return bool True on success, false on failuer.
 */
function Plugin_deliveryLog_oxLogConversion_logConversionVariable_Delivery_logConversionVariable($aVariables, $trackerId, $serverConvId, $serverRawIp, $okToLog=true)
{
    if (!$okToLog) { return false; }
    // Initiate the connection to the database (before using mysql_real_escape_string) 
 	OA_Dal_Delivery_connect('rawDatabase');
 	
 	$table = $GLOBALS['_MAX']['CONF']['table']['prefix'] . 'data_bkt_a_var';

    if (empty($GLOBALS['_MAX']['NOW'])) {
        $GLOBALS['_MAX']['NOW'] = time();
    }
    $time = $GLOBALS['_MAX']['NOW'];

    $aRows = array();
    foreach ($aVariables as $aVariable) {
        $aRows[] = "(
                        '{$serverConvId}',
                        '{$serverRawIp}',
                        '{$aVariable['variable_id']}',
                        '".OX_escapeString($aVariable['value'])."',
                        '".gmdate('Y-m-d H:i:s', $time)."'
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
