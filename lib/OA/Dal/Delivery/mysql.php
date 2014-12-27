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
 * The mysql data access layer code the delivery engine.
 *
 * @package    OpenXDal
 * @subpackage Delivery
 */

/**
 * The function to open a database connection, or return the resource if already open
 *
 * @param string $database   The name of the database config to use
 *                           (Must match the database section name in the conf file)
 * @return resource|false    The MySQL database resource
 *                           or false on failure
 */
function OA_Dal_Delivery_connect($database = 'database') {
    // If a connection already exists, then return that
    if ($database == 'database' && isset($GLOBALS['_MAX']['ADMIN_DB_LINK']) && is_resource($GLOBALS['_MAX']['ADMIN_DB_LINK'])) {
        return $GLOBALS['_MAX']['ADMIN_DB_LINK'];
    } elseif ($database == 'rawDatabase' && isset($GLOBALS['_MAX']['RAW_DB_LINK']) && is_resource($GLOBALS['_MAX']['RAW_DB_LINK'])) {
        return $GLOBALS['_MAX']['RAW_DB_LINK'];
    }
    // No connection exists, so create one
    $conf = $GLOBALS['_MAX']['CONF'];
    if (!empty($conf[$database])) {
        $dbConf = $conf[$database];
    } else {
        $dbConf = $conf['database'];
    }
    $dbPort     = isset($dbConf['port']) ? $dbConf['port'] : 3306;
    $dbHost     = $dbPort != 3306 ? $dbConf['host'].':'.$dbPort : $dbConf['host'];
    if ($dbConf['protocol'] == 'unix' && !empty($dbConf['socket'])) {
        $dbHost = ':' . $dbConf['socket'];
    }
    $dbUser     = $dbConf['username'];
    $dbPassword = $dbConf['password'];
    $dbName     = $dbConf['name'];
    if ($dbConf['persistent']) {
        $dbLink = @mysql_pconnect($dbHost, $dbUser, $dbPassword);
    } else {
        $dbLink = @mysql_connect($dbHost, $dbUser, $dbPassword);
    }
    if (@mysql_select_db($dbName, $dbLink)) {
        if (!empty($dbConf['mysql4_compatibility'])) {
            @mysql_query("SET SESSION sql_mode='MYSQL40'");
        }
        if (!empty($conf['databaseCharset']['checkComplete']) && !empty($conf['databaseCharset']['clientCharset'])) {
            @mysql_query("SET NAMES '{$conf['databaseCharset']['clientCharset']}'");
        }

        return $dbLink;
    }
    OX_Delivery_logMessage('DB connection error: ' . mysql_error(), 4);
    return false;
}

/**
 * The function to pass a query to a database link
 *
 * @param string $query    The SQL query to execute
 * @param string $database The database to use for this query
 *                         (Must match the database section name in the conf file)
 * @return resource|false  The MySQL resource if the query suceeded
 *                          or false on failure
 */
function OA_Dal_Delivery_query($query, $database = 'database') {
    // Connect to the database if necessary
    $dbName = ($database == 'rawDatabase') ? 'RAW_DB_LINK' : 'ADMIN_DB_LINK';

    if (empty($GLOBALS['_MAX'][$dbName])) {
        $GLOBALS['_MAX'][$dbName] = OA_Dal_Delivery_connect($database);
    }
    if (is_resource($GLOBALS['_MAX'][$dbName])) {
        $result = @mysql_query($query, $GLOBALS['_MAX'][$dbName]);
        if (!$result) {
            OX_Delivery_logMessage('DB query error: ' . mysql_error(), 4);
            OX_Delivery_logMessage(' - failing query: ' . $query, 5);
        }
        return $result;
    } else {
        return false;
    }
}

/**
 * The function to fetch a result from a database resource
 *
 * @param resource  The MySQL resource
 * @return array
 */
function OA_Dal_Delivery_fetchAssoc($resource) {
    return mysql_fetch_assoc($resource);
}

/**
 * The function to retrieve the last-insert-id from the database
 *
 * @param string $database The name of the database config to use
 *                         (Must match the database section name in the conf file)
 * @param string $table    The name of the table we need to get the ID from
 * @param string $column   The name of the column we need to get the ID from
 * @return int|false       The last insert ID (zero if last query didn't generate an ID)
 *                         or false on failure
 */
function OA_Dal_Delivery_insertId($database = 'database', $table = '', $column = '')
{
    $dbName = ($database == 'rawDatabase') ? 'RAW_DB_LINK' : 'ADMIN_DB_LINK';
    if (!isset($GLOBALS['_MAX'][$dbName]) || !(is_resource($GLOBALS['_MAX'][$dbName]))) {
        return false;
    }
    return mysql_insert_id($GLOBALS['_MAX'][$dbName]);
}

function OA_Dal_Delivery_numRows($result)
{
    return mysql_num_rows($result);
}

function OA_Dal_Delivery_result($result, $row_number, $field_name)
{
    return mysql_result($result, $row_number, $field_name);
}

function OX_escapeString($string)
{
    // Initiate the connection to the database (before using mysql_real_escape_string)
    static $connected;
    if (!isset($connected)) {
        $connected = true;
        OA_Dal_Delivery_connect('rawDatabase');
    }
    return mysql_real_escape_string($string);
}

function OX_unescapeBlob($blob)
{
    return $blob;
}

function OX_escapeIdentifier($string)
{
    return '`'.$string.'`';
}

function OX_Dal_Delivery_regex($column, $regexp)
{
    return $column." REGEXP '".$regexp."'";
}

function OX_bucket_updateTable($tableName, $aQuery, $increment = true, $counter = 'count')
{
    $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
    $query = OX_bucket_prepareUpdateQuery($prefix . $tableName, $aQuery, $increment, $counter);

    $result = OA_Dal_Delivery_query(
        $query,
        'rawDatabase'
    );
    return $result;
}

function OX_bucket_prepareUpdateQuery($tableName, $aQuery, $increment = true, $counter = 'count')
{
    // Initiate the connection to the database (before using mysql_real_escape_string)
 	OA_Dal_Delivery_connect('rawDatabase');

    $aQuery = array_map('OX_escapeString', $aQuery);
    if ($increment) {
    $aQuery[$counter] = 1;
    } else {
        $aQuery[$counter] = -1;
    }
    $query = "
        INSERT INTO {$tableName}
            (" . implode(', ', array_keys($aQuery)) . ")
            VALUES ('" . implode("', '", $aQuery) . "')
    ";
    $query .= " ON DUPLICATE KEY UPDATE $counter = $counter + {$aQuery[$counter]}";
    return $query;
}

function OA_Dal_Delivery_getKeywordCondition($operator, $keyword)
{
    // Escape properly
    $keyword = OX_escapeString(stripslashes($keyword));

    $p1 = "CONCAT(' ',d.keyword,' ')";
    $p2 = "LIKE '% $keyword %'";

    if ($operator == 'OR') {
        return "OR {$p1} {$p2} ";
    } elseif ($operator == 'AND') {
        return "AND {$p1} {$p2} ";
    } else {
        return "AND {$p1} NOT {$p2} ";
    }
}

?>
