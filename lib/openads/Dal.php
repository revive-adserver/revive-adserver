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
     * @return mixed Reference to an MDB2 connection resource, or PEAR_Error
     *               on failure to connect.
     */
    function &singleton($dsn = null)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        // Get the DSN, if not set
        $dsn = ($dsn === null) ? Openads_Dal::getDsn(MAX_DSN_STRING) : $dsn;
        // Create an MD5 checksum of the DSN
        $dsnMd5 = md5($dsn);
        // Does this database connection already exist?
        $aConnections = array_keys($GLOBALS['_MAX']['CONNECTIONS']);
        if (!(count($aConnections)) || !(in_array($dsnMd5, $aConnections))) {
            // Prepare options for a new database connection
            $aOptions = array();
            $customTypesFile = MAX_PATH . '/lib/openads/Dal/CustomDatatypes/' .
                               $conf['database']['type'] . '.php';
            if (is_readable($customTypesFile)) {
                require_once $customTypesFile;
                if (!empty($aDatatypes)) {
                    reset($aDatatypes);
                    while (list($key, $value) = each($aDatatypes)) {
                        $aOptions['datatype_map'] =
                            array_merge(
                                $aOptions['datatype_map'],
                                array($key => $value)
                            );
                        $aOptions['datatype_map_callback'] =
                            array_merge(
                                $aOptions['datatype_map_callback'],
                                array($key => 'datatype_' . $key . '_callback')
                            );
                    }
                }
                if (!empty($aNativetypes)) {
                    reset($aNativetypes);
                    while (list(,$value) = each($aNativetypes)) {
                        $aOptions['nativetype_map_callback'] =
                            array_merge(
                                $aOptions['nativetype_map_callback'],
                                array($value => 'nativetype_' . $value . '_callback')
                            );
                    }
                }
            }
            // Create the new database connection
            $GLOBALS['_MAX']['CONNECTIONS'][$dsnMd5] = &MDB2::factory($dsn, $aOptions);
        }
        return $GLOBALS['_MAX']['CONNECTIONS'][$dsnMd5];
    }

    /**
     * A method to return the default DSN specified by the configuration file.
     *
     * @static
     * @param int $type A constant that specifies the return type, that is,
     *                  MAX_DSN_ARRAY for the DSN in array format, or
     *                  MAX_DSN_STRING for the DSN in string format.
     * @return mixed An array or string containing the DSN.
     */
    function getDsn($type = MAX_DSN_ARRAY, $overrideMysql = true)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbType = $conf['database']['type'];
        //  Return DSN as array or as string as specified
        if ($type == MAX_DSN_ARRAY) {
            $dsn = array(
                'phptype'  => $dbType,
                'username' => $conf['database']['username'],
                'password' => $conf['database']['password'],
                'protocol' => $conf['database']['protocol'],
                'hostspec' => $conf['database']['host'],
                'database' => $conf['database']['name'],
                'port'     => $conf['database']['port'],
            );
        } else {
        	$protocol = isset($conf['database']['protocol']) ? $conf['database']['protocol'] . '+' : '';
        	$port = !empty($conf['database']['port']) ? ':' . $conf['database']['port'] : '';
            $dsn = $dbType . '://' .
                $conf['database']['username'] . ':' .
                $conf['database']['password'] . '@' .
                $protocol .
                $conf['database']['host'] .
                $port . '/' .
                $conf['database']['name'];
        }
        return $dsn;
    }

}

?>
