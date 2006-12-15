<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once MAX_PATH . '/lib/Max.php';
require_once 'PEAR.php';
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
 * @param enum $db Deprecated.
 * @deprecated 0.3.30 - 15-Nov-2006
 */
function phpAds_dbConnect($db = phpAds_adminDb)
{
    _raise_deprecated_db_api_warning();
    
	$conf = $GLOBALS['_MAX']['CONF'];
	if ($db == phpAds_rawDb) {
	    // Does the connection already exist?
	    if (isset($GLOBALS['_MAX']['RAW_DB_LINK'])) {
	        return $GLOBALS['_MAX']['RAW_DB_LINK'];
	    }
	    // Connect to the raw database
	    if (isset($conf['rawDatabase'])) {
	       $dbport     = isset($conf['rawDatabase']['port']) ? $conf['rawDatabase']['port'] : 3306;
	       $dbhost     = $dbport != 3306 ? $conf['rawDatabase']['host'].':'.$dbport : $conf['rawDatabase']['host'];
	       $dbuser     = $conf['rawDatabase']['username'];
	       $dbpassword = $conf['rawDatabase']['password'];
	       $dbname     = $conf['rawDatabase']['name'];
	    } else {
	        // Use the admin database as the raw database - normal Max
	        // users will do this when connecting to the "raw" database
	       $dbport     = isset($conf['database']['port']) ? $conf['database']['port'] : 3306;
	       $dbhost     = $dbport != 3306 ? $conf['database']['host'].':'.$dbport : $conf['database']['host'];
	       $dbuser     = $conf['database']['username'];
	       $dbpassword = $conf['database']['password'];
	       $dbname     = $conf['database']['name'];
	    }
	    if ($conf['database']['persistent']) {
	        $phpAds_rawDb_link = @mysql_pconnect($dbhost, $dbuser, $dbpassword);
	    } else {
	        $phpAds_rawDb_link = @mysql_connect($dbhost, $dbuser, $dbpassword);
	    }
	    if (@mysql_select_db ($dbname, $phpAds_rawDb_link)) {
	        $GLOBALS['_MAX']['RAW_DB_LINK'] = $phpAds_rawDb_link;
	        return $phpAds_rawDb_link;
	    }
	} else {
	    // Does the connection already exist?
	    if (isset($GLOBALS['_MAX']['ADMIN_DB_LINK'])) {
	        return $GLOBALS['_MAX']['ADMIN_DB_LINK'];
	    }
	    // Connect to the admin database
	    $dbport     = isset($conf['database']['port']) ? $conf['database']['port'] : 3306;
	    $dbhost     = $dbport != 3306 ? $conf['database']['host'].':'.$dbport : $conf['database']['host'];
	    $dbuser     = $conf['database']['username'];
	    $dbpassword = $conf['database']['password'];
	    $dbname     = $conf['database']['name'];
	    if ($conf['database']['persistent']) {
	        $phpAds_db_link = @mysql_pconnect($dbhost, $dbuser, $dbpassword);
	    } else {
	        $phpAds_db_link = @mysql_connect($dbhost, $dbuser, $dbpassword);
	    }
	    if (@mysql_select_db($dbname, $phpAds_db_link)) {
	        $GLOBALS['_MAX']['ADMIN_DB_LINK'] = $phpAds_db_link;
	        return $phpAds_db_link;
	    }
	}
}

/*-------------------------------------------------------*/
/* Close the connection to the database			         */
/*-------------------------------------------------------*/

/*
function phpAds_dbClose($db = phpAds_adminDb)
{
	// Never close the database connection, because
	// it may interfere with other scripts which
	// share the same connection.
	global $phpAds_db_link, $phpAds_rawDb_link;
	switch($db) {
    case phpAds_rawDb: 
        // mysql_close($phpAds_rawDb_link);
        break;
    case phpAds_adminDb:
        // mysql_close($phpAds_db_link);
        break;
	default:
        break;
	}
}
*/

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
function phpAds_dbQuery($query, $db = phpAds_adminDb)
{
    _raise_deprecated_db_api_warning();
    
    global $phpAds_last_query;
    $phpAds_last_query = $query;
    if ($db == phpAds_rawDb) {        
	    if (!isset($GLOBALS['_MAX']['RAW_DB_LINK'])) {
	        phpAds_dbConnect(phpAds_rawDb);
	    }
	    return @mysql_query($query, $GLOBALS['_MAX']['RAW_DB_LINK']);
    } else {
	    if (!isset($GLOBALS['_MAX']['ADMIN_DB_LINK'])) {
	        phpAds_dbConnect(phpAds_adminDb);
	    }
	    return @mysql_query($query, $GLOBALS['_MAX']['ADMIN_DB_LINK']);
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
	return @mysql_num_rows($res);
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
	return @mysql_fetch_array($res, MYSQL_ASSOC);
}

/**
 * Get next row as an array
 * @param resource $res A MySQL result resource.
 * @return array  (string 'field' => mixed)
 * @deprecated 0.3.30 - 15-Nov-2006
 * @todo Remove this function entirely. It is not used anywhere in the codebase!
 */
function phpAds_dbFetchRow($res)
{
    _raise_deprecated_db_api_warning();
	return @mysql_fetch_row($res);
}

/**
 * Get a specific row and column
 * @param resource $res A MySQL result resource.
 * @return mixed A value from the result set.
 * @deprecated 0.3.30 - 15-Nov-2006
 */
function phpAds_dbResult($res, $row, $column)
{
    _raise_deprecated_db_api_warning();
	return @mysql_result($res, $row, $column);
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
	return @mysql_affected_rows($db == phpAds_adminDb ? $GLOBALS['_MAX']['ADMIN_DB_LINK'] : $GLOBALS['_MAX']['RAW_DB_LINK']);
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
	return @mysql_insert_id($db == phpAds_adminDb ? $GLOBALS['_MAX']['ADMIN_DB_LINK'] : $GLOBALS['_MAX']['RAW_DB_LINK']);
}

/**
 * Get the error message if something went wrong
 */
function phpAds_dbError ($db = phpAds_adminDb)
{
    _raise_deprecated_db_api_warning();
	return @mysql_error($db == phpAds_adminDb ? $GLOBALS['_MAX']['ADMIN_DB_LINK'] : $GLOBALS['_MAX']['RAW_DB_LINK']);
}

function phpAds_dbErrorNo ($db = phpAds_adminDb)
{
    _raise_deprecated_db_api_warning();
	return @mysql_errno($db == phpAds_adminDb ? $GLOBALS['_MAX']['ADMIN_DB_LINK'] : $GLOBALS['_MAX']['RAW_DB_LINK']);
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
