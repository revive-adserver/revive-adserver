<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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

// require_once MAX_PATH . '/lib/Max.php';
// require_once 'PEAR.php';

$GLOBALS['_MAX']['PAN'] = array();


/**
 * Check if the MySQL PHP extension is available
 */
function phpAds_dbAvailable()
{
    _raise_deprecated_db_api_warning();

	return (function_exists('mysql_connect'));
}

/**
 * Open a connection to the database.
 *
 * @return True if connection was successful, false otherwise.
 * @deprecated 0.3.30 - 15-Nov-2006
 */
function phpAds_dbConnect()
{
    _raise_deprecated_db_api_warning();

    $GLOBALS['_MAX']['PAN']['DB'] = &OA_DB::singleton();
    return !PEAR::isError($GLOBALS['_MAX']['PAN']['DB']);
}


/**
 * Execute a query against the configured database.
 *
 * This function doesn't require an active connection to be present;
 * it will create a connection if none are available.
 *
 * @param string  $query   An SQL query.
 * @param enum    $db      (Deprecated.)
 * @deprecated v0.3.30 - 15-Nov-2006 - Use MAX DB calls (from a DAL!) instead.
 */
function phpAds_dbQuery($query)
{
    _raise_deprecated_db_api_warning();

    $query = trim($query);
    $queryType = strtoupper(substr($query, 0, 6));
    if ("SELECT" == $queryType) {
        $GLOBALS['_MAX']['PAN']['DB'] = &DBC::NewRecordSet($query);
        if (PEAR::isError($GLOBALS['_MAX']['PAN']['DB'])) {
            return false;
        }
        return $GLOBALS['_MAX']['PAN']['DB']->find();
    }
    else {
        $dbh = &OA_DB::singleton();
        if (PEAR::isError($dbh)) {
            $GLOBALS['_MAX']['PAN']['DB'] = $dbh;
            return false;
        }
        $cRows = $dbh->exec($query);
        $GLOBALS['_MAX']['PAN']['DB'] = $cRows;
        return !PEAR::isError($cRows);
    }
}

/**
 * Get the number of rows returned.
 *
 * @param resource $res A MySQL result resource.
 * @return int
 * @deprecated 0.3.30 - 15-Nov-2006
 */
function phpAds_dbNumRows($res)
{
    _raise_deprecated_db_api_warning();

    if (PEAR::isError($GLOBALS['_MAX']['PAN']['DB'])) {
        return false;
    }
    return $GLOBALS['_MAX']['PAN']['DB']->getRowCount();
}

/**
 * Get next row as an array with keys
 * @param resource $res A MySQL result resource.
 * @return array  (string 'field' => mixed)
 * @deprecated 0.3.30 - 15-Nov-2006
 */

function phpAds_dbFetchArray($res)
{
    _raise_deprecated_db_api_warning();
    if (PEAR::isError($GLOBALS['_MAX']['PAN']['DB'])) {
        return false;
    }
    if ($GLOBALS['_MAX']['PAN']['DB']->fetch()) {
        return $GLOBALS['_MAX']['PAN']['DB']->toArray();
    }
    return false;
}


/**
 * Return the number of affected rows
 * @param   resource $res A MySQL result resource.
 * @return  int
 * @deprecated 0.3.30 - 15-Nov-2006
 */
function phpAds_dbAffectedRows($db = phpAds_adminDb)
{
    _raise_deprecated_db_api_warning();
    if (PEAR::isError($GLOBALS['_MAX']['PAN']['DB'])) {
        return false;
    }
	return $GLOBALS['_MAX']['PAN']['DB'];
}

/**
 * Get the ID of the last inserted row
 * @param   enum    $db (Deprecated.)
 * @return  int
 * @deprecated 0.3.30 - 15-Nov-2006
 */
function phpAds_dbInsertID($db = phpAds_adminDb)
{
    _raise_deprecated_db_api_warning();
    $dbh = &OA_DB::singleton();
    $id = $dbh->lastInsertID();
    if (PEAR::isError($id)) {
        return false;
    }
    return $id;
}

/**
 * Get the error message if something went wrong
 *
 * @todo Used a hack, it's deprecated, I reckon it doesn't need to be properly handled
 */
function phpAds_dbError ($db = phpAds_adminDb)
{
    _raise_deprecated_db_api_warning();
    $dbConn = $GLOBALS['_MAX']['PAN']['DB']->getConnection();
    if ($GLOBALS['_MAX']['PAN']['DB']->connected_dsn['phptype'] == 'pgsql') {
        return pg_errormessage($dbConn);
    }
    return mysql_error($dbConn);
}

/**
 * Get the error code if something went wrong
 *
 * @todo Used a hack, it's deprecated, I reckon it doesn't need to be properly handled
 */
function phpAds_dbErrorNo ($db = phpAds_adminDb)
{
    _raise_deprecated_db_api_warning();
    $dbConn = $GLOBALS['_MAX']['PAN']['DB']->getConnection();
    if ($GLOBALS['_MAX']['PAN']['DB']->connected_dsn['phptype'] == 'pgsql') {
        return -1;
    }
    return mysql_errno($dbConn);
}

/**
 * Raise a warning to help us find and remove code which still uses this API.
 *
 * @return void
 * @private
 */
function _raise_deprecated_db_api_warning()
{
    $depreciation_warning =& new PEAR_Error("The old phpAds_db* API has been deprecated. New code should be in a DAL.");
    MAX::debug($depreciation_warning, PEAR_LOG_WARNING);
}
?>
