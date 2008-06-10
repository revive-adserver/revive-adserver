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

require MAX_PATH . '/lib/OA/Dal/Delivery/mysql.php';

/**
 * The mysql bucket (experimental) data access layer code the delivery engine.
 * This is a prototype designed to test updates and inserts in mysql in-memory buckets
 *
 * @package    OpenXDal
 * @subpackage Delivery
 * @author     Chris Nutting <chris.nutting@openx.org>
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */

if(!extension_loaded("runkit") || !RUNKIT_FEATURE_MANIPULATION) {
    echo "Error: runkit module is not loaded";
    exit();
}

// replace logAction implementation with custom OA_Dal_Delivery_logAction_BucketUpdate
runkit_function_remove('OA_Dal_Delivery_logAction');
runkit_function_copy('OA_Dal_Delivery_logAction_BucketUpdate', 'OA_Dal_Delivery_logAction');

/**
 * A function to insert ad requests, ad impressions, ad clicks
 * and tracker clicks into the raw tables. Does NOT work with
 * tracker impressions.
 *
 * @param string  $table        The raw table name to insert into.
 * @param string  $viewerId     The viewer ID.
 * @param integer $adId         The advertisement ID.
 * @param integer $creativeId   The creative ID (currently unused).
 * @param integer $zoneId       The zone ID.
 * @param array   $geotargeting An array holding the viewer's geotargeting info.
 * @param array   $zoneInfo     An array to store information about the URL
 *                              the viewer used to access the page containing the zone.
 * @param array   $userAgentInfo An array to store information about the
 *                               viewer's web browser and operating system.
 * @param integer $maxHttps     An integer to store if the call to OpenXwas
 *                              performed using HTTPS or not.
 */
function OA_Dal_Delivery_logAction_BucketUpdate($table, $viewerId, $adId, $creativeId, $zoneId,
                        $geotargeting, $zoneInfo, $userAgentInfo, $maxHttps)
{
    return OA_log_data_bucket_impression($table, $viewerId, $adId, $creativeId, $zoneId,
                        $geotargeting, $zoneInfo, $userAgentInfo, $maxHttps);
}

function OA_log_data_bucket_impression($table, $viewerId, $adId, $creativeId, $zoneId,
                        $geotargeting, $zoneInfo, $userAgentInfo, $maxHttps)
{
    if ($table != '') {
        // ignore
    }
    $aQuery = array(
        'interval_start' => gmdate('Y-m-d H:i:s'),
        'creative_id' => $adId,
        'zone_id' => $zoneId,
    );
    $result = OA_bucket_updateTable('data_bucket_impression', $aQuery);
    return $result;
}

function OA_bucket_buildUpdateQuery($tableName, $aQuery, $counter)
{
    $query = "UPDATE {$tableName} SET $counter = $counter + 1 WHERE ";
    $and = '';
    foreach ($aQuery as $column => $value) {
        if (!is_integer($value)) {
            $value = "'" . $value . "'";
        }
        $query .= $and . $column . ' = ' . $value;
        $and = ' AND ';
    }
    return $query;
}

function OA_bucket_buildInsertQuery($tableName, $aQuery, $counter)
{
    $insert = 'INSERT INTO {$tableName} (';
    $values = 'VALUES (';
    $comma = '';
    foreach ($aQuery as $column => $value) {
        if (!is_integer($value)) {
            $value = "'" . $value . "'";
        }
        $query .= $comma . $column . ', ';
        $values .= $comma . $value;
        $comma = ', ';
    }
    $query = $insert . $comma . $counter . ') ' . $values . ', 1)';
    return $query;
}

function OA_bucket_affectedRows($result)
{
    return mysql_affected_rows($GLOBALS['_MAX'][$dbName]);
}

function OA_bucket_updateTable($tableName, $aQuery, $counter = 'counter')
{
    // triple update/insert/update - for performance reasons
    $updateQuery = OA_bucket_buildUpdateQuery($tableName, $aQuery, $counter);
    $result = OA_Dal_Delivery_query(
        $updateQuery,
        'rawDatabase'
    );
    if (!OA_bucket_affectedRows($result)) {
        $insertQuery = OA_bucket_buildInsertQuery($tableName, $aQuery, $counter);
        $result = OA_Dal_Delivery_query(
            $insertQuery,
            'rawDatabase'
        );
        if (!$result) {
            $result = OA_Dal_Delivery_query(
                $updateQuery,
                'rawDatabase'
            );
            // create tables?
            require 'mysql_buckets.php';
            OA_createBuckets();
        }
    }

    return (bool)$result;
}


?>
