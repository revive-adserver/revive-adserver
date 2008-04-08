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

require_once 'MDB2.php';
require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/DB/Charset.php';

define('OA_DB_MDB2_DEFAULT_OPTIONS', MDB2_PORTABILITY_ALL ^ MDB2_PORTABILITY_EMPTY_TO_NULL);

/**
 * A class for creating database connections. Currently uses PEAR::MDB2.
 *
 * @package    OpenXDB
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Demian Turner <demian@m3.net>
 */
class OA_DB
{

    /**
     * A method to return a singleton database connection resource.
     *
     * Example usage:
     * $oDbh =& OA_DB::singleton();
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

        // Check that the parameter is a string, not an array
        if (is_array($dsn)) {
            return Max::raiseError('Bad argument: DSN should be a string', MAX_ERROR_INVALIDARGS);
        }

        // A hack to allow for installation on pgsql
        // If the configuration hasn't been defined prevent
        // loading mysql MDB2 driver.
        if (strpos($dsn, '//:@') !== false) {
            // Return a silent error
            return new PEAR_Error('Bad argument: Empty DSN');
        }

        // Create an MD5 checksum of the DSN
        $dsnMd5 = md5($dsn);
        // Does this database connection already exist?
        if (isset($GLOBALS['_OA']['CONNECTIONS'])) {
            $aConnections = array_keys($GLOBALS['_OA']['CONNECTIONS']);
        } else {
            $aConnections = array();
        }
        if (!(count($aConnections) > 0) || !(in_array($dsnMd5, $aConnections)))
        {
            // Prepare options for a new database connection
            $aOptions = array();
            // Sequence column name
            $aOptions['seqcol_name'] = 'id';
            // Set the index name format
            $aOptions['idxname_format'] = '%s';
            // Use 4 decimal places in DECIMAL nativetypes
            $aOptions['decimal_places'] = 4;
            // Set the portability options
            $aOptions['portability'] = OA_DB_MDB2_DEFAULT_OPTIONS;
            // Set the default table type for MySQL, if appropriate
            if (strcasecmp($aConf['database']['type'], 'mysql') === 0)
            {
                if (!empty($aConf['table']['type']))
                {
                    $aOptions['default_table_type'] = $aConf['table']['type'];
                    // Enable transaction support when using InnoDB tables
                    if (strcasecmp($aOptions['default_table_type'], 'innodb') === 0) {
                        // Enable transaction support
                        $aOptions['use_transactions'] = true;
                    }
                }
            } elseif (strcasecmp($aConf['database']['type'], 'pgsql') === 0) {
                $aOptions['quote_identifier'] = true;
	        }
	        // Add default charset - custom OpenX
	        if (defined('OA_DB_MDB2_DEFAULT_CHARSET')) {
	            $aOptions['default_charset'] = OA_DB_MDB2_DEFAULT_CHARSET;
	        } else {
    	        $aOptions['default_charset'] = 'utf8';
	        }
            // this will log select queries to a var/sql.log
            // currently used for analysis purposes
	        if (isset($aConf['debug']['logSQL']) && $aConf['debug']['logSQL'])
	        {
                $aOptions['log_statements'] = explode('|', $aConf['debug']['logSQL']);
                $aOptions['debug'] = true;
                $aOptions['debug_handler'] = 'logSQL';
	        }

            $aOptions += OA_DB::getDatatypeMapOptions();

            // Create the new database connection
            OA::disableErrorHandling();
            $oDbh =& MDB2::singleton($dsn, $aOptions);
            OA::enableErrorHandling();
            if (PEAR::isError($oDbh)) {
                return $oDbh;
            }
            OA::disableErrorHandling();
            $success = $oDbh->connect();
            OA::enableErrorHandling();
            if (PEAR::isError($success)) {
                return $success;
            }
            // Set charset if needed
            $success = OA_DB::setCharset($oDbh);
            if (PEAR::isError($success)) {
                return $success;
            }
            // Set schema if needed
            $success = OA_DB::setSchema($oDbh);
            if (PEAR::isError($success)) {
                return $success;
            }
            // Set the fetchmode to be use used
            $oDbh->setFetchMode(MDB2_FETCHMODE_ASSOC);
            // Load modules that are likely to be needed
            $oDbh->loadModule('Extended');
            $oDbh->loadModule('Datatype');
            $oDbh->loadModule('Manager');
            // Store the database connection
            $GLOBALS['_OA']['CONNECTIONS'][$dsnMd5] =& $oDbh;
            // Set MySQL 4 compatibility if needed
            if (strcasecmp($aConf['database']['type'], 'mysql') === 0 && !empty($aConf['database']['mysql4_compatibility'])) {
                $oDbh->exec("SET SESSION sql_mode='MYSQL40'");
            }
        }
        return $GLOBALS['_OA']['CONNECTIONS'][$dsnMd5];
    }

    /**
     * Set any custom MDB2 datatypes & nativetype mappings
     *
     * @return array
     * @static
     */
    function getDatatypeMapOptions()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        $aOptions = array();
        $aOptions['datatype_map'] = '';
        $aOptions['datatype_map_callback'] = '';
        $aOptions['nativetype_map_callback'] = '';

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

        return $aOptions;
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
// this will ensure mysqli driver is used if no mysql extension loaded
//        if (strcasecmp($aConf['database']['type'], 'mysql') === 0)
//        {
//            if (extension_loaded('mysqli') && (!extension_loaded('mysql')))
//            {
//                $aConf['database']['type'] = 'mysqli';
//            }
//        }
        $dbType = $aConf['database']['type'];
        // only pan or mmmv0.1 will have a protocol set to unix
        // otherwise no protocol is set and therefore defaults to tcp
    	if (isset($aConf['database']['protocol']) && $aConf['database']['protocol']=='unix')
    	{
            $host = (!empty($aConf['database']['socket']))
                        ? $aConf['database']['protocol'] . '(' . $aConf['database']['socket'] .')'
                        : $aConf['database']['protocol'] . '+' . $aConf['database']['host'];
            $dsn = $dbType . '://' .
                $aConf['database']['username'] . ':' .
                $aConf['database']['password'] . '@' .
                $host . '/' .
                $aConf['database']['name'];
    	}
    	else
    	{
    	    $protocol = '';
    	    $port = !empty($aConf['database']['port']) ? ':' . $aConf['database']['port'] : '';
            $dsn = $dbType . '://' .
                $aConf['database']['username'] . ':' .
                $aConf['database']['password'] . '@' .
                $protocol .
                $aConf['database']['host'] .
                $port . '/' .
                $aConf['database']['name'];
    	}
        return $dsn;
    }

    /**
     * A method to use the existing default DSN information to connect
     * to the database server, but connect to a specified database name.
     *
     * Useful for talking to different databases on the OpenXdatabase
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
     * A method for creating a database. Connects to the database server using
     * the "default" database for that database server type, creates the database,
     * and sets up any defined functions for that database type, if any exist.
     *
     * @static
     * @param string $name The name of the database to create.
     * @return mixed True if the database was created correctly, PEAR_Error otherwise.
     */
    function createDatabase($name)
    {
        $dsn = OA_DB::_getDefaultDsn();
        $oDbh =& OA_DB::singleton($dsn);
        if (PEAR::isError($oDbh)) {
            return $oDbh;
        }
        OA::disableErrorHandling();
        $result = $oDbh->manager->createDatabase($name);
        OA::enableErrorHandling();
        if (PEAR::isError($result)) {
            return $result;
        }
        return true;
    }

    /**
     * This sets up all the required PL/SQL functions for the database.
     *
     * @return mixed True on success, PEAR_Error otherwise.
     */
    function createFunctions()
    {
        $oDbh =& OA_DB::singleton();
        if (PEAR::isError($oDbh)) {
            return $oDbh;
        }
        $functionsFile = MAX_PATH . '/etc/core.'.strtolower($oDbh->dbsyntax).'.php';
        if (is_readable($functionsFile)) {
            if ($oDbh->dsn['phptype'] == 'pgsql') {
                $result = OA_DB::_createLanguage();
                if (PEAR::isError($result)) {
                    return $result;
                }
            }
            include $functionsFile;
            OA_DB::disconnectAll();
            $oDbh =& OA_DB::singleton();
            foreach ($aCustomFunctions as $customFunction) {
                $rows = $oDbh->exec($customFunction);
                if (PEAR::isError($rows)) {
                    return $rows;
                }
            }
        }
        return true;
    }

    /**
     * Loads a new procedural language into the database.
     * This is postgresql specific.
     *
     * @static
     * @access private
     * @param string $lang the name of the language to load.
     * @return mixed true if the language is successfully loaded, otherwise PEAR_Error.
     */
    function _createLanguage($lang = 'plpgsql')
    {
        $oDbh =& OA_DB::singleton();

        // Check if the language has been loaded.
        $query = "SELECT COUNT(*) FROM pg_catalog.pg_language WHERE lanname = '$lang'";
        OA::disableErrorHandling();
        $result = $oDbh->queryOne($query);
        OA::enableErrorHandling();
        if (PEAR::isError($result)) {
            return $result;
        } elseif ($result) {
            return true;
        }

        // Otherwise load the language.
        $version = $oDbh->getOne("SELECT VERSION()");
        if (version_compare($version, '8.1', '>=')) {
            $query = 'CREATE LANGUAGE ' . $lang;
        } else {
            $query = "CREATE FUNCTION plpgsql_call_handler() RETURNS language_handler AS '\$libdir/plpgsql' LANGUAGE C; ";
            $query .= "CREATE LANGUAGE plpgsql HANDLER plpgsql_call_handler;";
        }
        OA::disableErrorHandling();
        $result = $oDbh->exec($query);
        OA::enableErrorHandling();
        if (PEAR::isError($result)) {
            return $result;
        }
        return true;
    }

    /**
     * A method for dropping a database. Connects to the database server using
     * the "default" database for that database server type, and attempts to
     * drop the database.
     *
     * @static
     * @param string $name The name of the database to drop.
     * @return boolean True if the database was dropped correctly, false otherwise.
     */
    function dropDatabase($name)
    {
        $dsn = OA_DB::_getDefaultDsn();
        $oDbh =& OA_DB::singleton($dsn);
        OA::disableErrorHandling();
        $result = $oDbh->manager->dropDatabase($name);
        OA::enableErrorHandling();
        if (PEAR::isError($result)) {
            return false;
        }
        // Throw away any connections to this database since it doesn't exist anymore
        unset($GLOBALS['_OA']['CONNECTIONS']);
        $GLOBALS['_MDB2_databases'] = array();
        return true;
    }

    /**
     * A method to get a DSN string for connecting to the DSN defined by the
     * configuration file, but where the database name has been converted
     * to the "default" database for that database server type.
     *
     * @static
     * @access private
     * @return string The default database DSN.
     */
    function _getDefaultDsn()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Prepare a new DSN array, without a database name, so that
        // a connection to the database server's default database can
        // be created
        $aDatabaseDSN = $aConf;
        $aDatabaseDSN['database']['name'] = '';
        $dsn = OA_DB::getDsn($aDatabaseDSN);
        return $dsn;
    }

    /**
     * A method to restore the PEAR::MDB2 options so that case portability
     * is disabled, so tables names will be extracted from the database
     * in a case sensitive fashion.
     *
     * @static
     * @return void
     */
    function setCaseSensitive()
    {
        $newOptionsValue = OA_DB_MDB2_DEFAULT_OPTIONS ^ MDB2_PORTABILITY_FIX_CASE;
        $oDbh =& OA_DB::singleton();
        $oDbh->setOption('portability',  $newOptionsValue);
        $oDbh->setOption('quote_identifier',  true);
    }

    /**
     * A method to restore the PEAR::MDB2 options so that case portability
     * is enabled, so tables names will be extracted from the database
     * in a case insensitive fashion.
     *
     * @static
     * @return void
     */
    function disableCaseSensitive()
    {
        $oDbh =& OA_DB::singleton();
        $oDbh->setOption('portability',  OA_DB_MDB2_DEFAULT_OPTIONS);
        OA_DB::setQuoteIdentifier();
    }

    /**
     * A method to set the default schema. The schema will be created if missing.
     *
     * @param MDB2_Driver_common $oDbh
     * @return mixed True on succes, PEAR_Error otherwise
     */
    function setSchema($oDbh)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        // Connect to PgSQL schema if needed
        if ($oDbh->dbsyntax == 'pgsql' &&!empty($oDbh->connected_database_name)) {
            if (empty($aConf['databasePgsql']['schema'])) {
                // No need to deal with schemas
                return true;
            }
            OA::disableErrorHandling();
            $result = $oDbh->exec("SET search_path = '{$aConf['databasePgsql']['schema']}'");
            OA::enableErrorHandling();
            if (PEAR::isError($result)) {
                // Schema not found, try to create it
                OA::disableErrorHandling();
                $schema = $oDbh->quoteIdentifier($aConf['databasePgsql']['schema'], true);
                $result = $oDbh->exec("CREATE SCHEMA {$schema}");
                OA::enableErrorHandling();
                if (PEAR::isError($result)) {
                    // Schema was not created, return error
                    return $result;
                }
                OA::disableErrorHandling();
                $result = $oDbh->exec("SET search_path = '{$aConf['databasePgsql']['schema']}'");
                OA::enableErrorHandling();
                if (PEAR::isError($result)) {
                    // Schema was created, but SET search_path failed...
                    return $result;
                }
                OA::disableErrorHandling();
                $result = OA_DB::createFunctions();
                OA::enableErrorHandling();
                if (PEAR::isError($result)) {
                    // Could not create functions
                    return $result;
                }
            }
        }

        return true;
    }

    /**
     * A method to set the client encoding.
     *
     * @param MDB2_Driver_common $oDbh
     * @return mixed True on succes, PEAR_Error otherwise
     */
    function setCharset($oDbh)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        $oDbc = OA_DB_Charset::factory($oDbh);
        if (!empty($aConf['databaseCharset']['checkComplete'])) {
            $charset = $aConf['databaseCharset']['clientCharset'];
        } else {
            $charset = $oDbc->getConfigurationValue();
        }
        return $oDbc->setClientCharset($charset);
    }

    /**
     * A method to set the PEAR::MDB2 quote_identifier option so that table/column
     * names will be quoted, so that tables definitions can be obtained in a case
     * sensitive fashion.
     *
     * @static
     * @return void
     */
    function setQuoteIdentifier()
    {
        $oDbh =& OA_DB::singleton();
        $quote = false;
        if ($oDbh->dsn['phptype'] == 'pgsql') {
            $quote = '"';
        }
        $oDbh->setOption('quote_identifier', $quote);
    }

    /**
     * A method to restore the PEAR::MDB2 quote_identifier so that tables definitions
     * are obtained in the defailt case insensitive fashion.
     *
     * @static
     * @return void
     */
    function disabledQuoteIdentifier()
    {
        $oDbh =& OA_DB::singleton();
        $oDbh->setOption('quote_identifier', false);
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
