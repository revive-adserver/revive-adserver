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

require_once MAX_PATH . '/lib/OA/DB.php';
require_once 'DB/DataObject.php';

/**
 * The common Data Abstraction Layer (DAL) class.
 *
 * @package    OpenXDal
 */
class OA_Dal
{
    public static $batchInsertPath;

    /**
     * A local instance of the OA_DB created database handler.
     *
     * @var MDB2_Driver_Common
     */
    public $oDbh;

    /**
     * The constructor method.
     */
    public function __construct()
    {
        $this->oDbh = $this->_getDbh();
    }

    /**
     * A private method to return the database handler from
     * OA_DB.
     *
     * This private method allows the database handler to be
     * mocked during unit tests.
     *
     * @return MDB2_Driver_Common|PEAR_Error An MDB2 connection resource, or PEAR_Error
     *                            on failure to connect.
     */
    public function _getDbh()
    {
        return OA_DB::singleton();
    }

    /**
     * A factory method to obtain the appropriate DB_DataObject for a given
     * table name.
     *
     * @param  string $table The name of the table for which a DB_DataObject is required.
     * @return DB_DataObjectCommon|false The appropriate DB_DataObjectCommon implementaion,
     *                             or false on error.
     */
    public static function factoryDO($table)
    {
        self::_setupDataObjectOptions();
        $do = DB_DataObject::factory($table);
        if (is_a($do, 'DB_DataObjectCommon')) {
            $do->init();
            return $do;
        }
        return false;
    }

    public static function checkIfDoExists($table)
    {
        self::_setupDataObjectOptions();
        global $_DB_DATAOBJECT;
        if (!is_array($_DB_DATAOBJECT['CONFIG']['class_location'])) {
            $location = $_DB_DATAOBJECT['CONFIG']['class_location'];
            $fileExists = DB_DataObject::findTableFile($location, $table);
        } else {
            foreach ($_DB_DATAOBJECT['CONFIG']['class_location'] as $k => $location) {
                $fileExists = DB_DataObject::findTableFile($location, $table);
                if ($fileExists) {
                    break;
                }
            }
        }

        return $fileExists;
    }

    /**
     * A method to obtain an appropriate DB_DataObject for a given table name, pre-loaded
     * with the desired data, when possible.
     *
     * Example use:
     *   $doBanners = OA_Dal::staticGetDO("banners", 12);
     * Return the oject pre-loaded with the banner ID 12.
     *
     * Example use:
     *   $doClients = OA_Dal::staticGetDO("clients", "name", "fred");
     * Return the object pre-loaded with all clients where the "name" column is
     * equal to "fred".
     *
     * @static
     * @param string $table The name of the table for which a DB_DataObject is required.
     * @param string $k     Either the column name, if $v is supplied, otherwise the
     *                      value of the table's primary key.
     * @param string $v     An optional value when $k is a column name of the table.
     * @return DB_DataObjectCommon|false The appropriate DB_DataObjectCommon implementaion,
     *                             or false on error.
     */
    public static function staticGetDO($table, $k, $v = null)
    {
        self::_setupDataObjectOptions();
        $do = OA_Dal::factoryDO($table);
        if (PEAR::isError($do) || !$do) {
            return false;
        }
        if (!$do->get($k, $v)) {
            return false;
        }
        return $do;
    }

    /**
     * A method to duplicate an existing row
     *
     * Example use:
     *     $doBanners = OA_Dal::staticDuplicate('banners', 12, 1);
     *
     * @static
     * @param string $table The name of the table for which a DB_DataObject is required.
     * @param int $origId   The id of the row to copy
     * @param int $newId    The id to be assigned as the id of the row copied (optional)
     * @return mixed        Returns the restults returned from the duplicate method
     */
    public static function staticDuplicate($table, $origId, $newId = null)
    {
        self::_setupDataObjectOptions();
        $do = OA_Dal::factoryDO($table);
        if (PEAR::isError($do)) {
            return false;
        }
        if (!$result = $do->duplicate($origId, $newId)) {
            return false;
        }
        return $result;
    }

    /**
     * A factory method to load the appropriate MAX_Dal_Admin class for a
     * given table name.
     *
     * @static
     * @param string $table The name of the table for which a MAX_Dal_Admin class is
     *                      required.
     * @return MAX_Dal_Common The appropriate MAX_Dal_Common implementaion,
     *                        or false on error.
     */
    public static function factoryDAL($table)
    {
        include_once MAX_PATH . '/lib/max/Dal/Common.php';
        return MAX_Dal_Common::factory($table);
    }

    /**
     * Returns table prefix (see config [table][prefix]
     *
     * @return string  Table prefix
     */
    public static function getTablePrefix()
    {
        return $GLOBALS['_MAX']['CONF']['table']['prefix'];
    }

    /**
     * Clear the DataObject options cache
     *
     */
    public static function cleanCache()
    {
        self::_setupDataObjectOptions(false);
    }

    /**
     * Set up the required DB_DataObject options.
     * this method will add one location for all data-aware plugins
     */
    private static function _setupDataObjectOptions($fromCache = true)
    {
        static $needsSetup;
        if (isset($needsSetup) && $fromCache) {
            return;
        }
        $needsSetup = false;

        $aConf = $GLOBALS['_MAX']['CONF'];

        // Set DB_DataObject options

        // core dataobjects and schema
        $pathDataObjectsCore = MAX_PATH . '/lib/max/Dal/DataObjects';
        $aIniLocations[0] = $pathDataObjectsCore . '/db_schema.ini';
        $aLnkLocations[0] = $pathDataObjectsCore . '/db_schema.links.ini';
        $aDboLocations[0] = $pathDataObjectsCore;

        // plugin dataobjects and schemas
        $pathDataObjectsPlugin = MAX_PATH . $aConf['pluginPaths']['var'] . 'DataObjects';
        $aIniLocations[1] = $pathDataObjectsPlugin . '/db_schema.ini';
        $aLnkLocations[1] = $pathDataObjectsPlugin . '/db_schema.links.ini';
        $aDboLocations[1] = $pathDataObjectsPlugin;

        $dbname = $GLOBALS['_MAX']['CONF']['database']['name'];
        $options = &PEAR::getStaticProperty('DB_DataObject', 'options');
        $options = [
            'database' => OA_DB::getDsn(),
            'ini_' . $dbname => $aIniLocations,
            'links_' . $dbname => $aLnkLocations,
            'schema_location' => $pathDataObjectsCore, // only used by generator?
            'class_location' => $aDboLocations,
            'require_prefix' => $pathDataObjectsCore . '/', // only used by generator?
            'class_prefix' => 'DataObjects_',
            'debug' => 0,
            'production' => 0,
        ];
    }

    /**
     * A method to return the SQL required to create a temporary
     * table when prepended to a SELECT statement, depending on
     * the database type in use.
     *
     * @static
     * @param string $table The name of the temporary table to create.
     * @return string The SQL code to prepend to a SELECT statement to
     *                create the temporary table.
     */
    public static function createTemporaryTableFromSelect($table)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh = OA_DB::singleton();
        if ($oDbh->dsn['phptype'] == 'pgsql') {
            $sql = "
                CREATE TEMPORARY TABLE
                    $table
                AS";
        } else {
            $sql = "
                CREATE TEMPORARY TABLE
                    $table
                ENGINE={$aConf['table']['type']}";
        }
        return $sql;
    }

    /**
     * A method to return the SQL required to obtain an INTERVAL
     * value, depending on the datbase type in use.
     *
     * For example, in MySQL:
     *  INTERVAL 30 DAY;
     *
     * For example, in PostgreSQL:
     *  (30 DAY)::interval
     *
     * @static
     * @param string $interval The INTERVAL field or integer value. For example,
     *                         "30", or "table.column".
     * @param string $type     The INTERVAL length. For example, "DAY".
     * @return string The SQL code required to obtain the INTERVAL value.
     */
    public static function quoteInterval($interval, $type)
    {
        $oDbh = OA_DB::singleton();
        if ($oDbh->dsn['phptype'] == 'pgsql') {
            return "($interval || ' $type')::interval";
        }
        return "INTERVAL $interval $type";
    }

    /**
     * Returns true if $sqlDate is not an 'empty' date, false otherwise.
     *
     * @static
     * @param string $sqlDate
     */
    public static function isValidDate($sqlDate)
    {
        $dbh = OA_DB::singleton();
        return !empty($sqlDate) && preg_match('#^\d\d\d\d-\d\d-\d\d$#D', $sqlDate);
    }

    /**
     * Returns true if the $sqlDate represents 'empty' OpenX date,
     * false otherwise.
     *
     * @static
     * @param string $sqlDate
     */
    public static function isNullDate($sqlDate)
    {
        return !OA_Dal::isValidDate($sqlDate);
    }

    /**
     * Performs a batch insert using either LOAD DATA INFILE or COPY FROM, eventually
     * falling back to batchInsertPlain (plain INSERTs) on failure. On MySQL LOAD DATA
     * INFILE is 20x faster than plain single inserts
     *
     * @param string $tableName The unquoted table name
     * @param array  $aFields   The array of unquoted field names
     * @param array  $aValues   The array of data to be inserted
     * @param bool $replace Should the data be UPDATEd when the primary key or unique key is already present in the table?
     *
     * @return int|PEAR_Error   The number of rows inserted or PEAR_Error on failure
     */
    public static function batchInsert($tableName, $aFields, $aValues, $replace = false, $primaryKey = [])
    {
        if (!is_array($aFields) || !is_array($aValues)) {
            return MAX::raiseError('$aFields and $aValues must be arrays', PEAR_ERROR_RETURN);
        }

        $oDbh = OA_DB::singleton();

        // Quote table name
        $qTableName = $oDbh->quoteIdentifier($tableName);

        // Quote fields list
        $fieldList = '(' . implode(',', array_map([$oDbh, 'quoteIdentifier'], $aFields)) . ')';

        // Database custom stuff
        if ($oDbh->dbsyntax == 'mysql' || $oDbh->dbsyntax == 'mysqli') {
            $result = self::_batchInsertMySQL($qTableName, $fieldList, $aValues, $replace);
        } else {
            $result = self::_batchInsertPgSQL($qTableName, $fieldList, $aValues, $replace, $primaryKey);
        }

        if (PEAR::isError($result)) {
            OA::debug('LOAD DATA INFILE / COPY failed or not supported, falling back to INSERTing data by looping over each record...', PEAR_LOG_INFO);
            $result = self::batchInsertPlain($tableName, $aFields, $aValues);
        }

        return $result;
    }

    private static function _batchInsertMySQL($qTableName, $fieldList, $aValues, $replace)
    {
        $oDbh = OA_DB::singleton();

        // File path defaults to var/cache
        if (!isset(self::$batchInsertPath)) {
            self::$batchInsertPath = MAX_PATH . '/var/cache';
        }

        // Create file path using hostname and table name
        $filePath = self::$batchInsertPath . '/' . OX_getHostName() . '-batch-' . $qTableName . '.csv';
        if (DIRECTORY_SEPARATOR == '\\') {
            // On windows, MySQL expects slashes as directory separators
            $filePath = str_replace('\\', '/', $filePath);
        }
        $replace = $replace ? ' REPLACE ' : '';
        // Set up CSV delimiters, quotes, etc
        $delim = "\t";
        $quote = '"';
        $eol = "\n";
        $null = 'NULL';

        // Disable error handler
        RV::disableErrorHandling();

        $fp = fopen($filePath, 'wb');
        if (!$fp) {
            return MAX::raiseError('Error creating the tmp file ' . $filePath . ' containing the batch INSERTs.', PEAR_ERROR_RETURN);
        }

        // ensure that when maintenance is run in crontab, as root eg.
        // the file can still be overwritten by maintenance ran from the UI
        @chmod($filePath, 0777);

        foreach ($aValues as $aRow) {
            // Stringify row
            $row = '';
            foreach ($aRow as $value) {
                if (!isset($value) || is_null($value) || $value === false) {
                    $row .= $null . $delim;
                } else {
                    $row .= $quote . $value . $quote . $delim;
                }
            }
            // Replace delim with eol
            $row[strlen($row) - 1] = $eol;
            // Append
            $ret = fwrite($fp, $row);
            if (!$ret) {
                fclose($fp);
                unlink($filePath);
                return MAX::raiseError('Error writing to the tmp file ' . $filePath . ' containing the batch INSERTs.', PEAR_ERROR_RETURN);
            }
        }
        fclose($fp);
        $query = "
            LOAD DATA LOCAL INFILE
                '$filePath'
                $replace
            INTO TABLE
                $qTableName
            FIELDS TERMINATED BY
                " . $oDbh->quote($delim) . "
            ENCLOSED BY
                " . $oDbh->quote($quote) . "
            ESCAPED BY
                ''
            LINES TERMINATED BY
                " . $oDbh->quote($eol) . "
        	$fieldList
        ";

        self::enableLoadDataInfile($oDbh, true);

        $result = $oDbh->exec($query);

        self::enableLoadDataInfile($oDbh, false);

        @unlink($filePath);

        // Enable error handler again
        RV::enableErrorHandling();

        return $result;
    }

    /**
     * Performs a batch insert using plain INSERTs
     *
     * @see OA_Dal::batchInsert()
     *
     * @param string $tableName The unquoted table name
     * @param array  $aFields   The array of unquoted field names
     * @param array  $aValues   The array of data to be inserted
     * @param bool $replace Should the primary key be replaced when already present?
     * @return int   The number of rows inserted or PEAR_Error on failure
     */
    private static function _batchInsertPgSQL($qTableName, $fieldList, $aValues, $replace, $primaryKey)
    {
        $oDbh = OA_DB::singleton();

        $delim = "\t";
        $eol = "\n";
        $null = '\\N';

        // Disable error handler
        RV::disableErrorHandling();

        // we start by manually deleting conflicting unique rows
        foreach ($aValues as $aRow) {
            // because Postgresql doesn't have the REPLACE keyword,
            // we manually delete the rows with the primary key first
            if ($replace) {
                $where = '';
                foreach ($primaryKey as $fieldName) {
                    $where .= $fieldName . ' = \'' . $aRow[$fieldName] . '\'  AND ';
                }
                $where = substr($where, 0, strlen($where) - 5);
                $oDbh->query('DELETE FROM ' . $qTableName . ' WHERE ' . $where);
            }
        }
        $pg = $oDbh->getConnection();
        $result = $oDbh->exec("
            COPY
                $qTableName $fieldList
            FROM
                STDIN
        ");
        if (PEAR::isError($result)) {
            return MAX::raiseError('Error issuing the COPY query for the batch INSERTs.', PEAR_ERROR_RETURN);
        }
        foreach ($aValues as $aRow) {
            // Stringify row
            $row = '';
            foreach ($aRow as $value) {
                if (!isset($value) || $value === false) {
                    $row .= $null . $delim;
                } else {
                    $row .= $value . $delim;
                }
            }
            // Replace delim with eol
            $row[strlen($row) - 1] = $eol;
            // Send line
            $ret = pg_put_line($pg, $row);
            if (!$ret) {
                return MAX::raiseError('Error COPY-ing data: ' . pg_errormessage($pg), PEAR_ERROR_RETURN);
            }
        }
        $result = pg_put_line($pg, '\.' . $eol) && pg_end_copy($pg);
        $result = $result ? count($aValues) : new PEAR_Error('Error at the end of the COPY: ' . pg_errormessage($pg));

        // Enable error handler again
        RV::enableErrorHandling();

        return $result;
    }

    public static function batchInsertPlain($tableName, $aFields, $aValues)
    {
        if (!is_array($aFields) || !is_array($aValues)) {
            return MAX::raiseError('$aFields and $aData must be arrays', PEAR_ERROR_RETURN);
        }

        $oDbh = OA_DB::singleton();

        // Quote table name
        $tableName = $oDbh->quoteIdentifier($tableName);

        // Quote fields list
        $fieldList = '(' . implode(',', array_map([$oDbh, 'quoteIdentifier'], $aFields)) . ')';

        foreach ($aValues as $aRow) {
            $values = implode(', ', array_map([$oDbh, 'quote'], $aRow));
            $query = "INSERT INTO $tableName $fieldList VALUES ($values)";
            $result = $oDbh->exec($query);
            if (PEAR::isError($result)) {
                return $result;
            }
        }

        return count($aValues);
    }

    /**
     * Enable or disable LOAD DATA INFILE on MYSQL.
     *
     * @param MDB2_Driver_Common $oDbh
     * @param bool $enabled
     */
    private static function enableLoadDataInfile(MDB2_Driver_Common $oDbh, bool $enabled)
    {
        if ('mysqli' !== $oDbh->dbsyntax) {
            return;
        }

        mysqli_options($oDbh->getConnection(), MYSQLI_OPT_LOCAL_INFILE, $enabled);
    }
}
