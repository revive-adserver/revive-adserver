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

require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/DB/Charset.php';

require_once MAX_PATH . '/lib/pear/MDB2.php';

define('OA_DB_MDB2_DEFAULT_OPTIONS', MDB2_PORTABILITY_ALL ^ MDB2_PORTABILITY_EMPTY_TO_NULL);

/**
 * A class for creating database connections. Currently uses PEAR::MDB2.
 *
 * @package    OpenXDB
 */
class OA_DB
{

    /**
     * A method to return a singleton database connection resource.
     *
     * Example usage:
     * $oDbh = OA_DB::singleton();
     *
     * Warning: In order to work correctly, the singleton method must
     * be instantiated statically and by reference, as in the above
     * example.
     *
     * @static
     *
     * @param string $dsn Optional database DSN details - connects to the
     *                    database defined by the configuration file otherwise.
     *                    See {@link OA_DB::getDsn()} for format.
     *
     * @param array  $aDriverOptions An optional array of driver options. Currently
     *                              supported options are:
     *                  - For MySQL:
     *                      ['ssl']      = false|true Perform connection over SSL?
     *                      ['ca']       = Name of CA file, if "ssl" true
     *                      ['capath']   = Path to CA file above, is "ssl" true
     *                      ['compress'] = false|true Use client compression?
     *
     * @return MDB2_Driver_Common An MDB2 connection resource, or PEAR_Error
     *                            on failure to connect.
     */
    static function singleton($dsn = null, $aDriverOptions = array())
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        // Get the driver options, if not set
        if (!is_array($aDriverOptions) || (is_null($dsn) && empty($aDriverOptions))) {
            $aDriverOptions = OA_DB::getDsnOptions();
        }

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

        // Get the database type in use from the DNS, not from the
        // configuration file
        $aDSN = MDB2::parseDSN($dsn);
        $databaseType = $aDSN['phptype'];

        // Is this a MySQL database connection that should happen via SSL?
        if ((strcasecmp($databaseType, 'mysql') === 0 || strcasecmp($databaseType, 'mysqli') === 0) && (@$aDriverOptions['ssl'])) {
            // Modify the DSN string to include the required CA and CAPATH options
            if (!empty($aDriverOptions['ca']) && !empty($aDriverOptions['capath'])) {
                $dsn .= "?ca={$aDriverOptions['ca']}&capth={$aDriverOptions['capath']}";
            }
        }

        // Create an MD5 checksum of the DSN
        $dsnMd5 = md5($dsn);
        // Does this database connection already exist?
        if (isset($GLOBALS['_OA']['CONNECTIONS'])) {
            $aConnections = array_keys($GLOBALS['_OA']['CONNECTIONS']);
        } else {
            $aConnections = array();
        }
        if (!(count($aConnections) > 0) || !(in_array($dsnMd5, $aConnections))) {
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
            if (strcasecmp($databaseType, 'mysql') === 0 || strcasecmp($databaseType, 'mysqli') === 0) {
                if (!empty($aConf['table']['type'])) {
                    $aOptions['default_table_type'] = $aConf['table']['type'];
                    // Enable transaction support when using InnoDB tables
                    if (strcasecmp($aOptions['default_table_type'], 'innodb') === 0) {
                        // Enable transaction support
                        $aOptions['use_transactions'] = true;
                    }
                }
            } elseif (strcasecmp($databaseType, 'pgsql') === 0) {
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
            if (isset($aConf['debug']['logSQL']) && $aConf['debug']['logSQL']) {
                $aOptions['log_statements'] = explode('|', $aConf['debug']['logSQL']);
                $aOptions['debug'] = true;
                $aOptions['debug_handler'] = 'logSQL';
            }

            $aOptions += OA_DB::getDatatypeMapOptions();

            // Is this a MySQL database connection?
            if (strcasecmp($databaseType, 'mysql') === 0 || strcasecmp($databaseType, 'mysqli') === 0) {
                // Should this connection happen over SSL?
                if (@$aDriverOptions['ssl']) {
                    $aOptions['ssl'] = true;
                }
            }

            // Create the new database connection
            RV::disableErrorHandling();
            $oDbh = MDB2::singleton($dsn, $aOptions);
            RV::enableErrorHandling();
            if (PEAR::isError($oDbh)) {
                return $oDbh;
            }

            // Is this a MySQL database connection?
            if (strcasecmp($databaseType, 'mysql') === 0) {
                $client_flags = 0;
                // Should this connection happen over SSL?
                if (@$aDriverOptions['ssl']) {
                    $client_flags = $client_flags | MYSQL_CLIENT_SSL;
                }
                // Should this connection use compression?
                if (@$aDriverOptions['compress']) {
                    $client_flags = $client_flags | MYSQL_CLIENT_COMPRESS;
                }
                // Are there any MySQL connection flags to set?
                if ($client_flags != 0) {
                    $oDbh->dsn['client_flags'] = $client_flags;
                }
            }

            // Is this a MySQLi database connection?
            if (strcasecmp($databaseType, 'mysqli') === 0) {
                $client_flags = 0;
                // Should this connection happen over SSL?
                if (@$aDriverOptions['ssl']) {
                    $client_flags = $client_flags | MYSQLI_CLIENT_SSL;
                }
                // Should this connection use compression?
                if (@$aDriverOptions['compress']) {
                    $client_flags = $client_flags | MYSQLI_CLIENT_COMPRESS;
                }
                // Are there any MySQL connection flags to set?
                if ($client_flags != 0) {
                    $oDbh->dsn['client_flags'] = $client_flags;
                }
            }

            RV::disableErrorHandling();
            $success = $oDbh->connect();
            RV::enableErrorHandling();
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
            $GLOBALS['_OA']['CONNECTIONS'][$dsnMd5] = $oDbh;
            // Set MySQL 4 compatibility if needed
            if ((strcasecmp($databaseType, 'mysql') === 0 || strcasecmp($databaseType, 'mysqli') === 0) && !empty($aConf['database']['mysql4_compatibility'])) {
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
    static function getDatatypeMapOptions()
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
                while (list(, $value) = each($aNativetypes)) {
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
     *
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
    static function getDsn($aConf = null)
    {
        if (is_null($aConf)) {
            $aConf = $GLOBALS['_MAX']['CONF'];
        }
        $dbType = $aConf['database']['type'];
        if (isset($aConf['database']['protocol']) && $aConf['database']['protocol'] == 'unix') {
            $socket = $aConf['database']['socket'];

            // Pgsql socket connection: unix(:5432)
            if ($dbType == 'pgsql') {
                if (!empty($aConf['database']['port'])) {
                    $socket .= ':' . $aConf['database']['port'];
                }
            }

            $dsn = $dbType . '://' .
                $aConf['database']['username'] . ':' .
                $aConf['database']['password'] . '@' .
                $aConf['database']['protocol'] . '(' . $socket . ')' . '/' .
                $aConf['database']['name'];
        } else {
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
     * A method to return an array of driver specific options as described
     * in the OA_DB::singleton method.
     *
     * @static
     *
     * @param array $aConf An optional array containing the database details,
     *                     specifically containing index "database" which is
     *                     an array containing:
     *                      type     - Database type, matching PEAR::MDB2 driver name
     *                      ssl      - Optional boolean value; should MySQL connect over SSL?
     *                      ca       - Optional string; is using SSL, what is the CA filename?
     *                      capath   - Optional string; is using SSL, what is path to the the CA file?
     *                      compress - Optional boolean value; should MySQL connect using compression?
     *
     * @return array An array of driver specific options suitable for passing into
     *               the OA_DB::singleton method call.
     */
    static function getDsnOptions($aConf = null)
    {
        $aDriverOptions = array();
        if (is_null($aConf)) {
            $aConf = $GLOBALS['_MAX']['CONF'];
        }
        $dbType = $aConf['database']['type'];
        if (strcasecmp($dbType, 'mysql') === 0 || strcasecmp($dbType, 'mysqli') === 0) {
            if ($aConf['database']['ssl'] && !empty($aConf['database']['ca']) && !empty($aConf['database']['capath'])) {
                $aDriverOptions['ssl'] = true;
                $aDriverOptions['ca'] = $aConf['database']['ca'];
                $aDriverOptions['capath'] = $aConf['database']['capath'];
            }
            if ($aConf['database']['compress']) {
                $aDriverOptions['compress'] = true;
            }
        }
        return $aDriverOptions;
    }

    /**
     * A method to use the existing default DSN information to connect
     * to the database server, but connect to a specified database name.
     *
     * Useful for talking to different databases on the OpenXdatabase
     * server.
     *
     * @static
     *
     * @param string $name The name of the database to connect to.
     *
     * @return MDB2_Driver_Common An MDB2 connection resource, or PEAR_Error
     *                            on failure to connect.
     */
    static function changeDatabase($name)
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
     *
     * @param string $name The name of the database to create.
     *
     * @return mixed True if the database was created correctly, PEAR_Error otherwise.
     */
    static function createDatabase($name)
    {
        $dsn = OA_DB::_getDefaultDsn();
        $oDbh = OA_DB::singleton($dsn);
        if (PEAR::isError($oDbh)) {
            return $oDbh;
        }
        RV::disableErrorHandling();
        $result = $oDbh->manager->validateDatabaseName($name);
        RV::enableErrorHandling();
        if (PEAR::isError($result)) {
            return $result;
        }
        RV::disableErrorHandling();
        // ideally this quote identifier would be global
        // but there are problems with MAX_Dal_Common
        if ($oDbh->dsn['phptype'] == 'mysql' || $oDbh->dsn['phptype'] == 'mysqli') {
            $quote = '`';
            $oDbh->setOption('quote_identifier', $quote);
        }
        $oDbh->setOption('quote_identifier', true);
        $result = $oDbh->manager->createDatabase($name);
        $oDbh->setOption('quote_identifier', false);
        // we need to remove this quote identifier now
        if ($oDbh->dsn['phptype'] == 'mysql' || $oDbh->dsn['phptype'] == 'mysqli') {
            $quote = '';
            $oDbh->setOption('quote_identifier', $quote);
        }
        RV::enableErrorHandling();
        if (PEAR::isError($result)) {
            return $result;
        }
        return true;
    }

    /**
     * This sets up all the required PL/SQL functions for the database.
     *
     * @param  boolean Install only backup related functions
     *
     * @return mixed True on success, PEAR_Error otherwise.
     */
    static function createFunctions($onlyBackup = false)
    {
        $oDbh = OA_DB::singleton();
        if (PEAR::isError($oDbh)) {
            return $oDbh;
        }
        $functionsFile = MAX_PATH . '/etc/core.' . strtolower($oDbh->dbsyntax) . '.php';
        if (is_readable($functionsFile)) {
            if ($oDbh->dsn['phptype'] == 'pgsql') {
                $result = OA_DB::_createLanguage();
                if (PEAR::isError($result)) {
                    return $result;
                }
            }
            include $functionsFile;
            OA_DB::disconnectAll();
            $oDbh = OA_DB::singleton();
            $aFunctions = $onlyBackup ? $aBackupFunctions : $aCustomFunctions;
            foreach ($aFunctions as $customFunction) {
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
     *
     * @param string $lang the name of the language to load.
     *
     * @return mixed true if the language is successfully loaded, otherwise PEAR_Error.
     */
    static function _createLanguage($lang = 'plpgsql')
    {
        $oDbh = OA_DB::singleton();

        // Check if the language has been loaded.
        $query = "SELECT COUNT(*) FROM pg_catalog.pg_language WHERE lanname = '$lang'";
        RV::disableErrorHandling();
        $result = $oDbh->queryOne($query);
        RV::enableErrorHandling();
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
        RV::disableErrorHandling();
        $result = $oDbh->exec($query);
        RV::enableErrorHandling();
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
     *
     * @param string $name The name of the database to drop.
     *
     * @return boolean True if the database was dropped correctly, false otherwise.
     */
    static function dropDatabase($name)
    {
        $dsn = OA_DB::_getDefaultDsn();
        $oDbh = OA_DB::singleton($dsn);
        RV::disableErrorHandling();
        $result = $oDbh->manager->dropDatabase($name);
        RV::enableErrorHandling();
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
    static function _getDefaultDsn()
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
    static function setCaseSensitive()
    {
        $newOptionsValue = OA_DB_MDB2_DEFAULT_OPTIONS ^ MDB2_PORTABILITY_FIX_CASE;
        $oDbh = OA_DB::singleton();
        $oDbh->setOption('portability', $newOptionsValue);
        $oDbh->setOption('quote_identifier', true);
    }

    /**
     * A method to restore the PEAR::MDB2 options so that case portability
     * is enabled, so tables names will be extracted from the database
     * in a case insensitive fashion.
     *
     * @static
     * @return void
     */
    static function disableCaseSensitive()
    {
        $oDbh = OA_DB::singleton();
        $oDbh->setOption('portability', OA_DB_MDB2_DEFAULT_OPTIONS);
        OA_DB::setQuoteIdentifier();
    }

    /**
     * A method to set the default schema. The schema will be created if missing.
     *
     * @param MDB2_Driver_common $oDbh
     *
     * @return mixed True on succes, PEAR_Error otherwise
     */
    static function setSchema($oDbh)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        // Connect to PgSQL schema if needed
        if ($oDbh->dbsyntax == 'pgsql' && !empty($oDbh->connected_database_name)) {
            if (empty($aConf['databasePgsql']['schema'])) {
                // No need to deal with schemas
                return true;
            }
            RV::disableErrorHandling();
            $result = $oDbh->exec("SET search_path = '{$aConf['databasePgsql']['schema']}'");
            RV::enableErrorHandling();
            if (PEAR::isError($result)) {
                // Schema not found, try to create it
                RV::disableErrorHandling();
                $schema = $oDbh->quoteIdentifier($aConf['databasePgsql']['schema'], true);
                $result = $oDbh->exec("CREATE SCHEMA {$schema}");
                RV::enableErrorHandling();
                if (PEAR::isError($result)) {
                    // Schema was not created, return error
                    return $result;
                }
                RV::disableErrorHandling();
                $result = $oDbh->exec("SET search_path = '{$aConf['databasePgsql']['schema']}'");
                RV::enableErrorHandling();
                if (PEAR::isError($result)) {
                    // Schema was created, but SET search_path failed...
                    return $result;
                }
                RV::disableErrorHandling();
                $result = OA_DB::createFunctions();
                RV::enableErrorHandling();
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
     *
     * @return mixed True on succes, PEAR_Error otherwise
     */
    static function setCharset($oDbh)
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
     * Creates and returns a sequence name for a given table and field.
     *
     * When used to get the parameter for MDB2::nextId(), set $appendSuffix to false
     *
     * Note: On MySQL the method will return the table name as-is
     *
     * @param MDB2_Driver_Common $oDbh
     * @param string             $table
     * @param string             $field
     * @param bool               $appendSuffix PgSQL only
     *
     * @return string Sequence name
     */
    static function getSequenceName($oDbh, $table, $field, $appendSuffix = true)
    {
        if ($oDbh->dbsyntax == 'pgsql') {
            $tableName = $GLOBALS['_MAX']['CONF']['table']['prefix'] . $table;
            $fieldName = $field;

            // Hint: (max length) - (chars needed for '_' and '_seq') = 63 - 5 = 58
            if (strlen($tableName) + strlen($fieldName) > 58) {
                if (strlen($fieldName) < 29) {
                    $tableName = substr($tableName, 0, 58 - strlen($fieldName));
                } elseif (strlen($tableName) < 29) {
                    $fieldName = substr($fieldName, 0, 58 - strlen($tableName));
                } else {
                    $tableName = substr($tableName, 0, 29);
                    $fieldName = substr($fieldName, 0, 29);
                }
            }
            return $tableName . '_' . $fieldName . ($appendSuffix ? '_seq' : '');
        }

        return $table;
    }

    /**
     * A method to set the PEAR::MDB2 quote_identifier option so that table/column
     * names will be quoted, so that tables definitions can be obtained in a case
     * sensitive fashion.
     *
     * @static
     * @return void
     */
    static function setQuoteIdentifier()
    {
        $oDbh = OA_DB::singleton();
        $quote = false;
        if ($oDbh->dsn['phptype'] == 'pgsql') {
            $quote = '"';
        }
        /*      //we can't do this until we refactor out AdminDa / MAX_Dal_Common
                // which does require_once 'DB/QueryTool.php';
                // which breaks on the metadata method
                // because of the backticked table name
                 else if ($oDbh->dsn['phptype'] == 'mysql')
                {
                    $quote = '`';
                }*/
        $oDbh->setOption('quote_identifier', $quote);
    }

    /**
     * A method to restore the PEAR::MDB2 quote_identifier so that tables definitions
     * are obtained in the defailt case insensitive fashion.
     *
     * @static
     * @return void
     */
    static function disabledQuoteIdentifier()
    {
        $oDbh = OA_DB::singleton();
        $oDbh->setOption('quote_identifier', false);
    }

    /**
     * A method to disconnect a database connection resource.
     *
     * @static
     *
     * @param string $dsn Optional database DSN details - disconnects from the
     *                    database defined by the configuration file otherwise.
     *                    See {@link OA_DB::getDsn()} for format.
     *
     * @return void
     */
    static function disconnect($dsn)
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
    static function disconnectAll()
    {
        if (is_array($GLOBALS['_OA']['CONNECTIONS'])) {
            foreach ($GLOBALS['_OA']['CONNECTIONS'] as $key => $oDbh) {
                $GLOBALS['_OA']['CONNECTIONS'][$key]->disconnect();
                unset($GLOBALS['_OA']['CONNECTIONS'][$key]);
            }
        }
    }


    /**
     * A method to validate table name
     *
     * @param string $name
     *
     * @return true if valid PEAR error otherwise
     */
    static function validateTableName($name)
    {
        /*if ( !preg_match( '/^([a-zA-z_])([a-zA-z0-9_])*$/', $name) )
        {
            $result = false;
        }
        else if (preg_match( '/(\\\\|\/|\"|\\\'| |\(|\)|\:|\;|\`|\[|\]|\^)/', $name))
        {
            $result = false;
        }*/
        $result = true;
        RV::disableErrorHandling();
        $pattern = '/(?P<found>[\\x00-\\x23]|[\\x25-\\x29]|[\\x2a-\\x2f]|[\\x3a-\\x3f]|[\\x40]|[\\x5b-\\x5e]|[\\x60]|[\\x7b-\\x7e]|[\\x9c]|[\\xff])/U';
        if (preg_match($pattern, $name, $aMatches)) {
            $msg = 'Illegal character in table name ' . $aMatches['found'] . ' chr(' . ord($aMatches['found']) . ')';
            $result = PEAR::raiseError($msg);
        }
        if (PEAR::isError($result)) {
            RV::enableErrorHandling();
            $msg = 'Table names may not contain any of ! " # % & \' ( ) * + , - . \/ : ; < = > ? @ [ \\ ] ^ ` { | } ~ £ nor any non-printing characters';
            return $result;
        }
        $oDbh = OA_DB::singleton();
        if (PEAR::isError($oDbh)) {
            RV::enableErrorHandling();
            return $oDbh;
        }
        $result = $oDbh->manager->validateTableName($name);
        RV::enableErrorHandling();
        if (PEAR::isError($result)) {
            return $result;
        }
        return true;
    }


}

?>