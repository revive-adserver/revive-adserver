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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/XmlCache.php';
require_once MAX_PATH . '/lib/pear/Date.php';
require_once 'MDB2.php';
require_once 'MDB2/Schema.php';

/**
 * An abstract class defining the interface for creating OpenX database tables.
 *
 * Note that only permanent tables are created with the table prefix defined in the
 * configuration .ini file - temporary tables do NOT use the table prefix. This is
 * because temporary tables are not defined in the table array in the configuration
 * .ini file, and as such, must be referenced in the Data Abstraction Layer code
 * directly, and this is easier to do if the prefix doesn't have to be prepended
 * in order to do so.
 *
 * @package    OpenXDB
 * @subpackage Table
 */
class OA_DB_Table
{

    /**
     * An instance of the OA_DB class.
     *
     * @var OA_DB
     */
    var $oDbh;

    /**
     * An instance of the MDB2_Schema class.
     *
     * @var MDB2_Schema
     */
    var $oSchema;

    /**
     * An array containing the database definition, as parsed from
     * the XML schema file.
     *
     * @var array
     */
    var $aDefinition;

    /**
     * Should the tables be created as temporary tables?
     *
     * @var boolean
     */
    var $temporary = false;

    var $cached_definition = true;

    /**
     * The class constructor method.
     */
    function __construct()
    {
        $this->oDbh =& $this->_getDbConnection();
    }

    /**
     * A private method to manage creation of the utilised Openads_Dal class.
     *
     * @access private
     * @return mixed Reference to an MDB2 connection resource, or PEAR_Error
     *               on failure to connect.
     */
    function &_getDbConnection()
    {
        return OA_DB::singleton();
    }

    /**
     * A method to initialise the class by parsing a database XML schema file, so that
     * the class will be ready to create/drop tables for the supplied schema.
     *
     * @todo Better handling of cache files
     *
     * @param string $file     The name of the database XML schema file to parse for
     *                         the table definitions.
     * @param bool   $useCache If true definitions are loaded from the cache file
     * @return boolean True if the class was initialised correctly, false otherwise.
     */
    function init($file, $useCache = true)
    {
        // Ensure that the schema XML file can be read
        if (!is_readable($file)) {
            OA::debug('Unable to read the database XML schema file: ' . $file, PEAR_LOG_ERR);
            return false;
        }
        // Create an instance of MDB2_Schema to parse the schema file
        $options = array('force_defaults'=>false);
        $this->oSchema =& MDB2_Schema::factory($this->oDbh, $options);

        if ($useCache) {
            $oCache = new OA_DB_XmlCache();
            $this->aDefinition = $oCache->get($file);
            $this->cached_definition = true;
        } else {
            $this->aDefinition = false;
        }

        if (!$this->aDefinition) {
            $this->cached_definition = false;
            // Parse the schema file
            $this->aDefinition = $this->oSchema->parseDatabaseDefinitionFile($file);
            if (PEAR::isError($this->aDefinition)) {
                OA::debug('Error parsing the database XML schema file: ' . $file, PEAR_LOG_ERR);
                return false;
            }

            // On-the fly cache writing disabled
            //if ($useCache) {
            //    $oCache->save($this->aDefinition, $file);
            //}
        }
        return true;
    }

    /**
     * A private method to test if the class has been correctly initialised with a
     * valid database XML schema file.
     *
     * @return boolean True if the class has been correctly initialised, false otherwise.
     */
    function _checkInit()
    {
        if (is_null($this->aDefinition)) {
            OA::debug('No database XML schema file parsed, cannot create table', PEAR_LOG_ERR);
            return false;
        } else if (PEAR::isError($this->aDefinition)) {
            OA::debug('Previous error parsing the database XML schema file', PEAR_LOG_ERR);
            return false;
        }
        return true;
    }

    /**
     * return an array of tables in currently connected database
     * ensuring case is preserved
     * and that only tables with OpenX configured prefix are listed
     * optional 2nd prefix 'like' for narrowing the filter
     * this 'like' must be a simple string, no reg ex type stuff
     * e.g. $like= 'data_summary_'
     *
     * @param string $like
     * @return array
     */
    function listOATablesCaseSensitive($like='')
    {
        OA_DB::setCaseSensitive();
        $oDbh = OA_DB::singleton();
        $aDBTables = $oDbh->manager->listTables(null, $GLOBALS['_MAX']['CONF']['table']['prefix'].$like);
        OA_DB::disableCaseSensitive();
        sort($aDBTables);
        return $aDBTables;
    }

    /**
     * A method for creating a table from the currently parsed database XML schema file.
     *
     * @param string $table The name of the table to create, excluding table prefix.
     * @param Date $oDate An optional date for creating split tables. Will use current
     *                    date if the date is required for creation, but not supplied.
     * @param boolean $suppressTempTableError When true, do not produce an error debugging
     *                                        message if trying to create a temporary table
     *                                        that already exists.
     * @return mixed The name of the table created, or false if the table was not able
     *               to be created.
     */
    function createTable($table, $oDate = null, $suppressTempTableError = false)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if (!$this->_checkInit()) {
            return false;
        }
        // Does the table exist?
        if (!is_array($this->aDefinition['tables'][$table])) {
            OA::debug('Cannot find table ' . $table . ' in the XML schema file', PEAR_LOG_ERR);
            return false;
        }
        $tableName = $this->_generateTableName($table, $oDate);
        // Prepare the options array
        $aOptions = array();
        if ($this->temporary) {
            $aOptions['temporary'] = true;
        }
        $aOptions['type'] = $aConf['table']['type'];
        // Merge any primary keys into the options array
        if (isset($this->aDefinition['tables'][$table]['indexes'])) {
            if (is_array($this->aDefinition['tables'][$table]['indexes'])) {
                foreach ($this->aDefinition['tables'][$table]['indexes'] as $key => $aIndex) {
                    if (isset($aIndex['primary']) && $aIndex['primary']) {
                        $aOptions['primary'] = $aIndex['fields'];
                        $indexName = $tableName.'_pkey';
                    } else {
                        // Eventually strip the leading table name prefix from the index and
                        // add the currently generated table name. This should ensure that
                        // index names are unique database-wide, required at least by PgSQL
                        //
                        // The index name is cut at 64 chars
                        //
                        $indexName = $this->_generateIndexName($tableName, $key);
                    }
                    // Does the index name need to be udpated to match either
                    // the prefixed table name, or the the split table name, or
                    // simply it has a wrong name in the xml definition?
                    if ($key != $indexName) {
                        // Eventually strip the hardcoded leading table name and add the
                        // correct prefix to the index name
                        $this->aDefinition['tables'][$table]['indexes'][$indexName] =
                            $this->aDefinition['tables'][$table]['indexes'][$key];
                        unset($this->aDefinition['tables'][$table]['indexes'][$key]);
                    }
                }
            }
        }
        // Create the table
        OA::debug('Creating the ' . $tableName . ' table', PEAR_LOG_DEBUG);
        OA::disableErrorHandling();
        OA_DB::setCaseSensitive();
        $result = $this->oSchema->createTable($tableName, $this->aDefinition['tables'][$table], false, $aOptions);
        OA_DB::disableCaseSensitive();
        OA::enableErrorHandling();
        if (PEAR::isError($result) || (!$result)) {
            $showError = true;
            if ($this->temporary && $suppressTempTableError) {
                $showError = false;
            }
            if ($showError)
            {
                OA::debug('Unable to create the table ' . $table, PEAR_LOG_ERR);
                if (PEAR::isError($result))
                {
                    OA::debug($result->getUserInfo(), PEAR_LOG_ERR);
                }
            }
            return false;
        }
        return $tableName;
    }

    /**
     * A method for creating all tables from the currently parsed database XML schema file.
     *
     * @param Date $oDate An optional date for creating split tables. Will use current
     *                    date if the date is required for creation, but not supplied.
     * @return boolean True if all tables created successfuly, false otherwise.
     */
    function createAllTables($oDate = null)
    {
        if (!$this->_checkInit()) {
            return false;
        }
        foreach ($this->aDefinition['tables'] as $tableName => $aTable) {
            $result = $this->createTable($tableName, $oDate);
            if (PEAR::isError($result) || (!$result)) {
                return false;
            }
        }
        return true;
    }

    /**
     * A method for creating a table, and all other tables it relies on, based on the
     * "foriegn keys" the table has (actually taken from the DB_DataObjects .ini file).
     *
     * @param string $table The name of the (primary) table to create, excluding table prefix.
     * @param Date $oDate An optional date for creating split tables. Will use current
     *                    date if the date is required for creation, but not supplied.
     * @return boolean True if all required tables created successfuly, false otherwise.
     */
    function createRequiredTables($table, $oDate = null)
    {
        if (!$this->_checkInit()) {
            return false;
        }
        $aTableNames = $this->_getRequiredTables($table);
        $result = $this->createTable($table, $oDate);
        if (!$result) {
            return false;
        }
        foreach ($aTableNames as $tableName) {
            $result = $this->createTable($tableName, $oDate);
            if (!$result) {
                return false;
            }
        }
        return true;
    }

     /**
     * A method to check if a table exists
     *
     * @param string $table The full name of the table, i.e. with prefix if required.
     * @return boolean True if exists, false otherwise.
     */
    function extistsTable($table)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $tableName = preg_replace("/^{$aConf['table']['prefix']}/", '', $table);
        $aResult = $this->listOATablesCaseSensitive($tableName);
        if (is_array($aResult) && in_array($table, $aResult)) {
            return true;
        }
        return false;
    }

     /**
     * A method to check if a temporary table exists
     * temporary tables are hidden from SHOW TABLES statement
     *
     * @param string $table The full name of the table, i.e. with prefix if required.
     * @return boolean True if exists, false otherwise.
     */
    function existsTemporaryTable($table)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        OA::debug('Checking for temporary table ' . $table, PEAR_LOG_DEBUG);
        $query = "SELECT * FROM ".$this->oDbh->quoteIdentifier($table,true);
        OA::disableErrorHandling();
        $result = $this->oDbh->exec($query);
        OA::enableErrorHandling();
        if (PEAR::isError($result)) {
            OA::debug('Temporary table exists ' . $table, PEAR_LOG_ERR);
            return false;
        }
        OA::debug('Not found ' . $table, PEAR_LOG_ERR);
        return true;
    }

    /**
     * A method to easily drop a table.
     *
     * @param string $table The table name to drop. Must be the complete table name in use,
     *                      as no prefix or data values will be added before dropping the table.
     * @return boolean True if table dropped, false otherwise.
     */
    function dropTable($table)
    {
        OA::debug('Dropping table ' . $table, PEAR_LOG_DEBUG);
        OA::disableErrorHandling();
        $result = $this->oDbh->manager->dropTable($table);
        OA::enableErrorHandling();
        if (PEAR::isError($result)) {
            OA::debug('Unable to drop table ' . $table, PEAR_LOG_ERR);
            return false;
        }
        if (!$this->dropSequence($table))
        {
            // some sequences need to be dropped
            // e.g. if they were created independently of a table
            // if there is a dependency we don't necessarily want to
            // cascade the drop
            // therefore, not being able to drop a sequence might not
            // be an error
            //return false;
        }
        return true;
    }

    /**
     * A method for dropping all tables from the currently parsed database XML schema file.
     *
     * @return boolean True if all tables dropped successfuly, false otherwise.
     */
    function dropAllTables()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if (!$this->_checkInit()) {
            return false;
        }
        $allTablesDropped = true;
        foreach ($this->aDefinition['tables'] as $tableName => $aTable) {
            OA::debug('Dropping the ' . $tableName . ' table', PEAR_LOG_DEBUG);
            $result = $this->dropTable($aConf['table']['prefix'].$tableName);
            if (PEAR::isError($result) || (!$result)) {
                OA::debug('Unable to drop the table ' . $tableName, PEAR_LOG_ERR);
                $allTablesDropped = false;
            }
        }
        return $allTablesDropped;
    }

    /**
     * A method to TRUNCATE a table.  If the DB is mysql it also sets autoincrement to 1.
     *
     * @param string $table the name of the table to truncate
     * @return boolean True if table truncated, false otherwise
     */
    function truncateTable($table)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        OA::debug('Truncating table ' . $table, PEAR_LOG_DEBUG);
        OA::disableErrorHandling();
        $query = "TRUNCATE TABLE ".$this->oDbh->quoteIdentifier($table,true);
        $result = $this->oDbh->exec($query);
        OA::enableErrorHandling();
        if (PEAR::isError($result)) {
            OA::debug('Unable to truncate table ' . $table, PEAR_LOG_ERR);
            return false;
        }
        if ($aConf['database']['type'] == 'mysql') {
            OA::disableErrorHandling();
            $result = $this->oDbh->exec("ALTER TABLE $table AUTO_INCREMENT = 1" );
            OA::enableErrorHandling();
            if (PEAR::isError($result)) {
                OA::debug('Unable to set mysql auto_increment to 1', PEAR_LOG_ERR);
                return false;
            }
        }
        return true;
    }

    /**
     * A method for truncating all tables from the currently parsed database XML
     * schema file, including any split versions of these tables, if they exist
     * in the database.
     *
     * @return boolean True if all tables truncated successfuly, false otherwise.
     */
    function truncateAllTables()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if (!$this->_checkInit()) {
            return false;
        }
        $allTablesTruncated = true;
        // Iterate over each known table, and truncate
        foreach ($this->aDefinition['tables'] as $tableName => $aTable) {
            OA::debug('Truncating the ' . $tableName . ' table', PEAR_LOG_DEBUG);
            $result = $this->truncateTable($aConf['table']['prefix'].$tableName);
            if (PEAR::isError($result)) {
                OA::debug('Unable to truncate the table ' . $tableName, PEAR_LOG_ERR);
                $allTablesTruncated = false;
            }
        }
        return $allTablesTruncated;
    }

    /**
     * Drops a (postgresql) sequence for a given table
     *
     *
     * @param string $table the name of the table that owns the sequence (must be prefixed)
     * @return boolean true on success, false otherwise
     */
    function dropSequence($table)
    {
        if ($this->oDbh->dbsyntax == 'pgsql')
        {
            $aConf = $GLOBALS['_MAX']['CONF'];
            OA_DB::setCaseSensitive();
            $aSequences = $this->oDbh->manager->listSequences();
            OA_DB::disableCaseSensitive();
            foreach ($aSequences as $sequence)
            {
                if (strpos($sequence, $table.'_') === 0)
                {
                    $sequence.= '_seq';
                    OA::debug('Dropping sequence ' . $sequence, PEAR_LOG_DEBUG);
                    OA::disableErrorHandling();
                    $result = $this->oDbh->exec("DROP SEQUENCE \"$sequence\"");
                    OA::enableErrorHandling();
                    if (PEAR::isError($result))
                    {
                        OA::debug('Unable to drop the sequence ' . $sequence, PEAR_LOG_ERR);
                        return false;
                    }
                    break;
                }
            }
        }
        return true;
    }

    /**
     * Resets a (postgresql) sequence to a value
     *
     * Note: the value parameter is ignored on MySQL. Autoincrements will always be resetted
     * to 1 or the highest value already present in the table.
     *
     * @param string $sequence the name of the sequence to reset
     * @param int    $value    the sequence value for the next entry
     * @return boolean true on success, false otherwise
     */
    function resetSequence($sequence, $value = 1)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        OA::debug('Resetting sequence ' . $sequence, PEAR_LOG_DEBUG);
        OA::disableErrorHandling(null);

        if ($aConf['database']['type'] == 'pgsql') {
            if ($value < 1) {
                $value = 1;
            } else {
                $value = (int)$value;
            }

            $sequence = $this->oDbh->quoteIdentifier($sequence,true);
            $result = $this->oDbh->exec("SELECT setval('$sequence', {$value}, false)");
            OA::enableErrorHandling();
            if (PEAR::isError($result)) {
                OA::debug('Unable to reset sequence ' . $sequence, PEAR_LOG_ERR);
                return false;
            }
        }
        else if ($aConf['database']['type'] == 'mysql')
        {
            $result = $this->oDbh->exec("ALTER TABLE {$GLOBALS['_MAX']['CONF']['table']['prefix']}{$sequence} AUTO_INCREMENT = 1");
            OA::enableErrorHandling();
            if (PEAR::isError($result)) {
                OA::debug('Unable to reset auto increment on table ' . $sequence, PEAR_LOG_ERR);
                return false;
            }
        }
        return true;
    }

    /**
     * Resets all sequences
     *
     * @return boolean true on success, false otherwise
     */
    function resetAllSequences()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if (!$this->_checkInit()) {
            return false;
        }
        $allSequencesReset = true;
        OA_DB::setCaseSensitive();
        $aSequences = $this->oDbh->manager->listSequences();
        OA_DB::disableCaseSensitive();
        if (is_array($aSequences)) {
            $aTables = $this->aDefinition['tables'];
            if ($this->oDbh->dbsyntax == 'pgsql')
            {
                foreach ($aSequences as $sequence) {
                    $match = false;
                    foreach (array_keys($this->aDefinition['tables']) as $tableName) {
                        $tableName = substr($aConf['table']['prefix'].$tableName, 0, 29).'_';
                        if (strpos($sequence, $tableName) === 0) {
                            $match = true;
                            break;
                        }
                    }
                    if (!$match) {
                        continue;
                    }
                    // listSequences returns sequence names without trailing '_seq'
                    $sequence .= '_seq';
                    OA::debug('Resetting the ' . $sequence . ' sequence', PEAR_LOG_DEBUG);
                	if (!$this->resetSequence($sequence)) {
                	    OA::debug('Unable to reset the sequence ' . $sequence, PEAR_LOG_ERR);
                	    $allSequencesReset = false;
                	}
                }
            }
            else if ($this->oDbh->dbsyntax == 'mysql')
            {
                foreach (array_keys($this->aDefinition['tables']) as $tableName)
                {
                	if (!$this->resetSequence($tableName))
                	{
                	    OA::debug('Unable to reset the auto-increment for ' . $tableName, PEAR_LOG_ERR);
                	    $allSequencesReset = false;
                	}
                }
            }
        }
        return $allSequencesReset;
    }

    /**
     * A method to get all the required tables to create another table.
     *
     * @param string  $table  The table to check for.
     * @param array   $aLinks The links array, if already loaded.
     * @param array   $aSkip  The table(s) to skip (already checked).
     * @param integer $level  Recursion level.
     * @return array The required tables array.
     */
    function _getRequiredTables($table, $aLinks = null, $aSkip = null, $level = 0)
    {
        if (is_null($aLinks)) {
            require_once MAX_PATH . '/lib/OA/Dal/Links.php';
            $aLinks = Openads_Links::readLinksDotIni(MAX_PATH . '/lib/max/Dal/DataObjects/db_schema.links.ini');
        }
        $aTables = array();
        if (isset($aLinks[$table])) {
            foreach ($aLinks[$table] as $aLink) {
                $refTable = $aLink['table'];
                $aTables[$refTable] = $level;
                foreach (array_keys($aTables) as $refTable) {
                    if (!isset($aSkip[$refTable])) {
                        $aTables = $this->_getRequiredTables($refTable, $aLinks, $aTables, $level + 1) + $aTables;
                    }
                }
            }
        }
        if (!$level) {
            arsort($aTables);
            return array_keys($aTables);
        } else {
            return $aTables;
        }
    }

    /**
     * A method for generating a table name, adding prefix as required.
     *
     * @param string $table The original name of the table.
     * @return string The name of the table.
     */
    function _generateTableName($table)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $tableName = $table;
        // Does a table prefix need to be added to the table name?
        if ($aConf['table']['prefix'] && !$this->temporary) {
            $tableName = $aConf['table']['prefix'] . $tableName;
        }
        return $tableName;
    }

    /**
     * A method for generating an index name, adding the table name as prefix
     *
     * Note: The resulting index name is truncated to 64 characters
     *
     * @param string $table The name of the table.
     * @param string $table The original name of the index.
     * @return string The name of the index
     */
    function _generateIndexName($table, $index)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $tableName = $table;
        $origTable = substr($table, strlen($aConf['table']['prefix']));
        return substr($tableName . '_' . preg_replace("/^{$origTable}_/", '', $index), 0, 63);
    }

    /**
     * Resets the sequence value for a given table and its id field to the
     * maximum value currently in the table. This way after upgrade the
     * sequence should be ready to use for inserting new campaigns, websites...
     * This function have effect only on PostgreSQL. It does nothing when
     * called on a different database.
     *
     * On database error the function logs an error and returns false.
     *
     * @param string $table Name of the table (without prefix)
     * @param string $field Name of the id field (eg. affiliateid, campaignid)
     * @return PEAR_Error True on success, PEAR_Error object on failure.
     */
    function resetSequenceByData($table, $field)
    {
        if ($this->oDbh->dbsyntax == 'pgsql') {
            $prefix = $this->getPrefix();
            $tableName = $prefix . $table;
            $sequenceName = OA_DB::getSequenceName($this->oDbh, $table, $field);
            $qSeq = $this->oDbh->quoteIdentifier($sequenceName, true);
            $qFld = $this->oDbh->quoteIdentifier($field, true);
            $qTbl = $this->oDbh->quoteIdentifier($tableName, true);
            $sql = "SELECT setval(".$this->oDbh->quote($qSeq).", MAX({$qFld})) FROM {$qTbl}";
            $result = $this->oDbh->exec($sql);
            if (PEAR::isError($result)) {
                return $result;
            }
        }
        return true;
    }

    /**
     * Returns a prefix used for prefixing database tables.
     *
     * @return string
     */
    function getPrefix()
    {
        return $GLOBALS['_MAX']['CONF']['table']['prefix'];
    }

    function checkTable($tableName)
    {
        $aConf      = $GLOBALS['_MAX']['CONF']['table'];
        $oDbh       = OA_DB::singleton();
        $tableName  = $oDbh->quoteIdentifier($aConf['prefix'].($aConf[$tableName] ? $aConf[$tableName] : $tableName),true);
        $aResult = $oDbh->manager->checkTable($tableName);
        if ($aResult['msg_text']!=='OK')
        {
            OA::debug('PROBLEM WITH TABLE '.$tableName. ': '.$aResult['msg_text'], PEAR_LOG_ERR);
            return false;
        }
        OA::debug($tableName. ': Status = OK');
        return true;
    }
}

?>