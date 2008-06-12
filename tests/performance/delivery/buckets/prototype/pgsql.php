<?php

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
        return @pg_query($GLOBALS['_MAX'][$dbName], $query);
    } else {
        return false;
    }
}


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
    $dbParams[] = 'port='.(isset($dbConf['port']) ? $dbConf['port'] : 5432);
    $dbParams[] = !empty($dbConf['protocol']) && $dbConf['protocol'] == 'unix' ? '' : 'host='.$dbConf['host'];
    $dbParams[] = empty($dbConf['username']) ? '' : 'user='.$dbConf['username'];
    $dbParams[] = empty($dbConf['password']) ? '' : 'password='.$dbConf['password'];
    $dbParams[] = 'dbname='.$dbConf['name'];
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
    return $dbLink;
}

function OA_bucket_affectedRows($resource)
{
    if (!is_resource($resource)) {
        return false;
    }
    return pg_affected_rows($resource);
}

function OA_bucketPrintError($database = 'database')
{
    $dbName = ($database == 'rawDatabase') ? 'RAW_DB_LINK' : 'ADMIN_DB_LINK';
    echo pg_last_error($GLOBALS['_MAX'][$dbName]);
}

?>