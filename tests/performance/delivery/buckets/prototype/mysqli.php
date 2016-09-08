<?php

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
        return @mysqli_query($GLOBALS['_MAX'][$dbName], $query);
    } else {
        return false;
    }
}


/**
 * The function to open a database connection, or return the resource if already open
 *
 * @param string $database   The name of the database config to use
 *                           (Must match the database section name in the conf file)
 * @return mysqli|false    The MySQL database resource
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
        $dbLink = @mysqli_connect('p:' . $dbHost, $dbUser, $dbPassword);
    } else {
        $dbLink = @mysqli_connect($dbHost, $dbUser, $dbPassword);
    }
    if (@mysqli_select_db($dbLink, $dbName)) {
        if (!empty($dbConf['mysql4_compatibility'])) {
            @mysqli_query($dbLink, "SET SESSION sql_mode='MYSQL40'");
        }
        if (!empty($conf['databaseCharset']['checkComplete']) && !empty($conf['databaseCharset']['clientCharset'])) {
            @mysqli_query($dbLink, "SET NAMES '{$conf['databaseCharset']['clientCharset']}'");
        }

        return $dbLink;
    }
    return false;
}

function OA_bucket_affectedRows($resource)
{
    return mysqli_affected_rows($GLOBALS['_MAX']['RAW_DB_LINK']);
}

function OA_bucketPrintError($database = 'database')
{
    $dbName = ($database == 'rawDatabase') ? 'RAW_DB_LINK' : 'ADMIN_DB_LINK';
    echo mysqli_error($GLOBALS['_MAX'][$dbName]);
}

?>
