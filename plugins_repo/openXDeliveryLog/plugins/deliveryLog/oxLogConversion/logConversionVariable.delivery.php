<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
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
function Plugin_deliveryLog_oxLogConversion_logConversionVariable_Delivery_logConversionVariable($aVariables, $trackerId, $serverConvId, $serverRawIp, $okToLog = true)
{
    if (!$okToLog) {
        return false;
    }
    // Initiate the connection to the database (before using mysql_real_escape_string)
    OA_Dal_Delivery_connect('rawDatabase');
    
    $table = $GLOBALS['_MAX']['CONF']['table']['prefix'] . 'data_bkt_a_var';

    if (empty($GLOBALS['_MAX']['NOW'])) {
        $GLOBALS['_MAX']['NOW'] = time();
    }
    $time = $GLOBALS['_MAX']['NOW'];

    $aRows = [];
    foreach ($aVariables as $aVariable) {
        $aRows[] = "(
                        '" . OX_escapeString($serverConvId) . "',
                        '" . OX_escapeString($serverRawIp) . "',
                        '{$aVariable['variable_id']}',
                        '" . OX_escapeString($aVariable['value']) . "',
                        '" . gmdate('Y-m-d H:i:s', $time) . "'
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
