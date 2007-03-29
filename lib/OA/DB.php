<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once 'MDB2.php';

/**
 * A class for creating database connections. Currently uses PEAR::MDB2.
 *
 * @package    OpenadsDB
 * @author     Andrew Hill <andrew.hill@openads.org>
 * @author     Demian Turner <demian@m3.net>
 */
class OA_DB
{

    /**
     * A method to return a singleton database connection resource.
     *
     * Example usage:
     * $oDbh = &OA_DB::singleton();
     *
     * Warning: In order to work correctly, the singleton method must
     * be instantiated statically and by reference, as in the above
     * example.
     *
     * @static
     * @param string $dsn Optional database DSN details - connects to the
     *                    database defined by the configuration file otherwise.
     *                    See {@link OA_DB::getDsn()} for format.
     * @return MDB2_Driver_Common An MDB2 connection resource, or PEAR_Error
     *                            on failure to connect.
     */
    function &singleton($dsn = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Get the DSN, if not set
        $dsn = is_null($dsn) ? OA_DB::getDsn() : $dsn;
        // Create an MD5 checksum of the DSN
        $dsnMd5 = md5($dsn);
        // Does this database connection already exist?
        $aConnections = array_keys($GLOBALS['_OA']['CONNECTIONS']);
        if (!(count($aConnections) > 0) || !(in_array($dsnMd5, $aConnections))) {
            // Prepare options for a new database connection
            $aOptions = array();
            $aOptions['datatype_map'] = '';
            $aOptions['datatype_map_callback'] = '';
            $aOptions['nativetype_map_callback'] = '';
            // Set the index name format
            $aOptions['idxname_format'] = '%s';
            // Use 4 decimal places in DECIMAL nativetypes
            $aOptions['decimal_places'] = 4;
            // Set the portability options
            $aOptions['portability'] = MDB2_PORTABILITY_ALL ^ MDB2_PORTABILITY_EMPTY_TO_NULL;
            // Set the default table type, if appropriate
            if (!empty($aConf['table']['type'])) {
                $aOptions['default_table_type'] = $aConf['table']['type'];
            }
            // Set any custom MDB2 datatypes & nativetype mappings
            $customTypesInfoFile = MAX_PATH . '/lib/OA/DB/CustomDatatypes/' .
                               $aConf['database']['type'] . '_info.php';
            $customTypesFile = MAX_PATH . '/lib/OA/DB/CustomDatatypes/' .
                               $aConf['database']['type'] . '.php';
            if (is_readable($customTypesInfoFile) && is_readable($customTypesFile)) {
                include $customTypesInfoFile;
                require_once $customTypesFile;
                if (!empty($aDatatypes)) {
                    reset($aDatatypes);
                    while (list($key, $value) = each($aDatatypes)) {
                        $aOptions['datatype_map'] =
                            array_merge(
                                (array)$aOptions['datatype_map'],
                                array($key => $value)
                            );
                        $aOptions['datatype_map_callback'] =
                            array_merge(
                                (array)$aOptions['datatype_map_callback'],
                                array($key => 'datatype_' . $key . '_callback')
                            );
                    }
                }
                if (!empty($aNativetypes)) {
                    reset($aNativetypes);
                    while (list(,$value) = each($aNativetypes)) {
                        $aOptions['nativetype_map_callback'] =
                            array_merge(
                                (array)$aOptions['nativetype_map_callback'],
                                array($value => 'nativetype_' . $value . '_callback')
                            );
                    }
                }
            }
            // Create the new database connection
            $oDbh = &MDB2::singleton($dsn, $aOptions);
            if (PEAR::isError($oDbh)) {
                return $oDbh;
            }
            $success = $oDbh->connect();
            if (PEAR::isError($success)) {
                return $success;
            }
            // Set the fetchmode to be use used
            $oDbh->setFetchMode(MDB2_FETCHMODE_ASSOC);
            // Load modules that are likely to be needed
            $oDbh->loadModule('Extended');
            $oDbh->loadModule('Datatype');
            $oDbh->loadModule('Manager');
            // Prepare the format of the quoted "NO DATE" string
            $oDbh->noDateString         = "NULL";
            $oDbh->equalNoDateString    = "IS NULL";
            $oDbh->notEqualNoDateString = "IS NOT NULL";
            $oDbh->noDateValue          = null;
            if ($oDbh->dsn['phptype'] == 'mysql') {
                $oDbh->noDateString         = "'0000-00-00'";
                $oDbh->equalNoDateString    = "= '0000-00-00'";
                $oDbh->notEqualNoDateString = "!= '0000-00-00'";
                $oDbh->noDateValue          = '0000-00-00';
            }
            // Store the database connection
            $GLOBALS['_OA']['CONNECTIONS'][$dsnMd5] = &$oDbh;
        }
        return $GLOBALS['_OA']['CONNECTIONS'][$dsnMd5];
    }

    /**
     * A method to return the default DSN specified by the configuration file.
     *
     * @static
     * @param array $aConf An optional array containing the database details,
     *                     specifically containing index "database" which is
     *                     an array containing:
     *                      type     - Database type, matching PEAR::MDB2 driver name
     *                      protocol - Optional communications protocol
     *                      port     - Optional database server port
     *                      username - Optional username
     *                      password - Optional password
     *                      host     - Database server hostname
     *                      name     - Optional database name
     * @return string An string containing the DSN.
     */
    function getDsn($aConf = null)
    {
        if (is_null($aConf)) {
            $aConf = $GLOBALS['_MAX']['CONF'];
        }
        $dbType = $aConf['database']['type'];
    	$protocol = isset($aConf['database']['protocol']) ? $aConf['database']['protocol'] . '+' : '';
    	$port = !empty($aConf['database']['port']) ? ':' . $aConf['database']['port'] : '';
        $dsn = $dbType . '://' .
            $aConf['database']['username'] . ':' .
            $aConf['database']['password'] . '@' .
            $protocol .
            $aConf['database']['host'] .
            $port . '/' .
            $aConf['database']['name'];
        return $dsn;
    }

    /**
     * A method to use the existing default DSN information to connect
     * to the database server, but connect to a specified database name.
     *
     * Useful for talking to different databases on the Openads database
     * server.
     *
     * @static
     * @param string $name The name of the database to connect to.
     * @return MDB2_Driver_Common An MDB2 connection resource, or PEAR_Error
     *                            on failure to connect.
     */
    function &changeDatabase($name)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Overwrite the database name
        $aConf['database']['name'] = $name;
        // Get the DSN
        $dsn = OA_DB::getDsn($aConf);
        // Return the database connection
        return OA_DB::singleton($dsn);
    }

    /**
     * A method to disconnect a database connection resource.
     *
     * @static
     * @param string $dsn Optional database DSN details - disconnects from the
     *                    database defined by the configuration file otherwise.
     *                    See {@link OA_DB::getDsn()} for format.
     * @return void
     */
    function disconnect($dsn)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Get the DSN, if not set
        $dsn = is_null($dsn) ? OA_DB::getDsn() : $dsn;
        // Create an MD5 checksum of the DSN
        $dsnMd5 = md5($dsn);
        // Does this database connection already exist?
        $aConnections = array_keys($GLOBALS['_OA']['CONNECTIONS']);
        if ((count($aConnections) > 0) && (in_array($dsnMd5, $aConnections))) {
            $GLOBALS['_OA']['CONNECTIONS'][$dsnMd5]->disconnect();
            unset($GLOBALS['_OA']['CONNECTIONS'][$dsnMd5]);
        }
    }

    /**
     * A method to disconnect any and all database connection resources.
     *
     * @static
     * @return void
     */
    function disconnectAll()
    {
        if (is_array($GLOBALS['_OA']['CONNECTIONS'])) {
            foreach ($GLOBALS['_OA']['CONNECTIONS'] as $key => $oDbh) {
                $GLOBALS['_OA']['CONNECTIONS'][$key]->disconnect();
                unset($GLOBALS['_OA']['CONNECTIONS'][$key]);
            }
        }
    }

}

?>
