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
 * The pgsql data access layer code the delivery engine.
 *
 * @package    OpenXDal
 * @subpackage Delivery
 * @author     Chris Nutting <chris.nutting@openx.org>
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */

/**
 * The function to open a database connection, or return the resource if already open
 *
 * @param string $database   The name of the database config to use
 *                           (Must match the database section name in the conf file)
 * @return resource|false    The PgSQL database resource
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
    $dbParams   = array();

    if ($dbConf['protocol'] == 'unix')
    {
        $dbConf['host'] = $dbConf['socket'];
    }
    else
    {
        $dbConf['port'] = (isset($dbConf['port']) ? $dbConf['port'] : 5432);
    }
    $dbParams[] = empty($dbConf['port']     ) ? '' : 'port='.$dbConf['port'];
    $dbParams[] = empty($dbConf['host']     ) ? '' : 'host='.$dbConf['host'];
    $dbParams[] = empty($dbConf['username'] ) ? '' : 'user='.$dbConf['username'];
    $dbParams[] = empty($dbConf['password'] ) ? '' : 'password='.$dbConf['password'];
    $dbParams[] = empty($dbConf['name']     ) ? '' : 'dbname='.$dbConf['name'];
    if ($dbConf['persistent']) {
        $dbLink = @pg_pconnect(join(' ', $dbParams));
    } else {
        $dbLink = @pg_connect(join(' ', $dbParams));
    }
    if ($dbLink && !empty($conf['databasePgsql']['schema'])) {
        @pg_query($dbLink, "SET search_path='{$conf['databasePgsql']['schema']}'");
    }
    if ($dbLink && !empty($conf['databaseCharset']['checkComplete']) && !empty($conf['databaseCharset']['clientCharset'])) {
        @pg_client_encoding($dbLink, $conf['databaseCharset']['clientCharset']);
    }
    if (!$dbLink) {
        $err = error_get_last();
        OX_Delivery_logMessage('DB connection error: ' . $err['message'], 4);
    }
    return $dbLink;
}

/**
 * The function to pass a query to a database link
 *
 * @param string $query    The SQL query to execute
 * @param string $database The database to use for this query
 *                         (Must match the database section name in the conf file)
 * @return resource|false  The PgSQL resource if the query suceeded
 *                          or false on failure
 */
function OA_Dal_Delivery_query($query, $database = 'database') {
    // Connect to the database if necessary
    $dbName = ($database == 'rawDatabase') ? 'RAW_DB_LINK' : 'ADMIN_DB_LINK';

    if (empty($GLOBALS['_MAX'][$dbName])) {
        $GLOBALS['_MAX'][$dbName] = OA_Dal_Delivery_connect($database);
    }
    if (is_resource($GLOBALS['_MAX'][$dbName])) {
        $result = @pg_query($GLOBALS['_MAX'][$dbName], $query);
        if (!$result) {
            OX_Delivery_logMessage('DB query error: ' . pg_last_error($GLOBALS['_MAX'][$dbName]), 4);
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
 * @param resource  The PgSQL resource
 * @return array
 */
function OA_Dal_Delivery_fetchAssoc($resource) {
    return pg_fetch_assoc($resource);
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
function OA_Dal_Delivery_insertId($database = 'database', $table, $column)
{
    $dbName = ($database == 'rawDatabase') ? 'RAW_DB_LINK' : 'ADMIN_DB_LINK';
    if (!isset($GLOBALS['_MAX'][$dbName]) || !(is_resource($GLOBALS['_MAX'][$dbName]))) {
        return false;
    }
    $seqName = substr($column, 0, 29).'_seq';
    $seqName = substr($table, 0, 62 - strlen($seqName)).'_'.$seqName;
    $query = "SELECT currval('\"".$seqName."\"')";
    return pg_fetch_result(pg_query($GLOBALS['_MAX'][$dbName], $query), 0, 0);
}

function OA_Dal_Delivery_numRows($result)
{
    return pg_num_rows($result);
}

function OA_Dal_Delivery_result($result, $row_number, $field_name)
{
    return pg_result($result, $row_number, $field_name);
}

function OX_escapeString($string)
{
    return pg_escape_string($string);
}

function OX_escapeIdentifier($string)
{
    return '"'.$string.'"';
}

function OX_unescapeBlob($blob)
{
    return pg_unescape_bytea($blob);
}

function OX_Dal_Delivery_regex($column, $regexp)
{
    return $column." ~* E'".$regexp."'";
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
    $args = implode(',', OX_bucket_quoteArgs($aQuery));
    $query = "SELECT bucket_update_{$tableName}({$args},1)";
    return $query;
}

function OX_bucket_quoteArgs($aArgs)
{
    $array = $aArgs;
    foreach ($array as &$value) {
        if (!is_integer($value)) {
            $value = "'" . OX_escapeString($value) . "'";
        }
    }
    return $array;
}

function OA_Dal_Delivery_getKeywordCondition($operator, $keyword)
{
    // Escape properly
    $keyword = OX_escapeString(stripslashes($keyword));

    $p1 = "(' ' || d.keyword || ' ')";
    $p2 = "ILIKE '% $keyword %'";

    if ($operator == 'OR') {
        return "OR {$p1} {$p2} ";
    } elseif ($operator == 'AND') {
        return "AND {$p1} {$p2} ";
    } else {
        return "AND {$p1} NOT {$p2} ";
    }
}

?>
