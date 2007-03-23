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
 * @package    OpenadsDal
 * @author     Andrew Hill <andrew.hill@openads.org>
 * @author     Demian Turner <demian@m3.net>
 *
 * @TODO This class needs to be reviewed when the DAL is refactored,
 *       to determine if we are happy with it simply returning an MDB2
 *       object, or if we need to provide wrapper functions.
 */
class Openads_Dal
{

    /**
     * A method to return a singleton database connection resource.
     *
     * Example usage:
     * $db = &Openads_Dal::singleton();
     *
     * Warning: In order to work correctly, the singleton method must
     * be instantiated statically and by reference, as in the above
     * example.
     *
     * @static
     * @param string $dsn Optional database DSN details - connects to the
     *                    database defined by the configuration file otherwise.
     *                    See {@link Openads_Dal::parseDSN()} for format.
     * @return MDB2_Driver_Common An MDB2 connection resource, or PEAR_Error
     *                            on failure to connect.
     */
    function &singleton($dsn = null)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        // Get the DSN, if not set
        $dsn = ($dsn === null) ? Openads_Dal::getDsn() : $dsn;
        // Create an MD5 checksum of the DSN
        $dsnMd5 = md5($dsn);
        // Does this database connection already exist?
        $aConnections = array_keys($GLOBALS['_OA']['CONNECTIONS']);
        if (!(count($aConnections)) || !(in_array($dsnMd5, $aConnections))) {
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
            if (!empty($conf['table']['type'])) {
                $aOptions['default_table_type'] = $conf['table']['type'];
            }
            // Set any custom MDB2 datatypes & nativetype mappings
            $customTypesInfoFile = MAX_PATH . '/lib/openads/Dal/CustomDatatypes/' .
                               $conf['database']['type'] . '_info.php';
            $customTypesFile = MAX_PATH . '/lib/openads/Dal/CustomDatatypes/' .
                               $conf['database']['type'] . '.php';
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
            $GLOBALS['_OA']['CONNECTIONS'][$dsnMd5] = &MDB2::singleton($dsn, $aOptions);
            // Set the fetchmode to be use used
            $GLOBALS['_OA']['CONNECTIONS'][$dsnMd5]->setFetchMode(MDB2_FETCHMODE_ASSOC);
            // Load modules that are likely to be needed
            $GLOBALS['_OA']['CONNECTIONS'][$dsnMd5]->loadModule('Datatype');
            $GLOBALS['_OA']['CONNECTIONS'][$dsnMd5]->loadModule('Manager');
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
     *
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

}

?>
