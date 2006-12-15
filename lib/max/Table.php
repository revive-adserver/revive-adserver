<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
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

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/DB.php';

/**
 * An abstract class defining the interface for creating Max database tables.
 *
 * Note that only permanent tables are created with the table prefix defined in the
 * configuration .ini file - temporary tables do NOT use the table prefix. This is
 * because temporary tables are not defined in the table array in the configuration
 * .ini file, and as such, must be referenced in the Data Access Layer code
 * directly, and this is easier to do if the prefix doesn't have to be prepended
 * in order to do so.
 *
 * @package    MaxDal
 * @subpackage Table
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Table
{
    var $tables;
    var $splitTables;

    /**
     * The class constructor method.
     */
    function MAX_Table()
    {
        $dbh = &$this->_createMaxDb();
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->register('MAX_DB', $dbh);
    }

    /**
     * A private method to manage creation of the utilised MAX_DB class.
     *
     * @access private
     * @return mixed An instance of the MAX_DB class.
     */
    function &_createMaxDb()
    {
        return MAX_DB::singleton();
    }

    /**
     * An initialisation method.
     *
     * @param string $file The name of the SQL file to parse for the table definitions.
     * @return boolean True if the class was initialised correctly, false otherwise.
     */
    function init($file)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        // Parse the SQL file
        if (!($fp = fopen($file, 'r'))) {
            MAX::debug('Unable to open the Max table definition file: ' . $file, PEAR_LOG_ERR);
            return false;
        }
        $sql = '';
        while (!feof($fp)) {
            $line = fgets($fp);
            $line = trim($line);
            if (preg_match('/^-- SPLIT TABLE (\w+);?/', $line, $matches)) {
                // Line is a comment defining that the table may be split
                $tableName = $matches[1];
                $this->splitTables[$tableName] = true;
                continue;
            }
            $comment = substr($line, 0, 2);
            if ($comment === '--') {
                // Line is a general comment, ignore
                continue;
            }
            $sql = $sql . $line;
            if (preg_match('/;$/', $sql)) {
                // The table create SQL has been completed, store it, with the
                // appropriate table prefix and TYPE definition
                if (preg_match('/^(CREATE TABLE IF NOT EXISTS )(\w+)(.*);/i', $sql, $matches)) {
                    $tableName = $matches[2];
                    $this->tables[$tableName] = $matches[1] . $conf['table']['prefix'] .
                        $matches[2] . $matches[3] . ' TYPE=' . $conf['table']['type'];
                    $sql = '';
                } elseif (preg_match('/^(CREATE TEMPORARY TABLE IF NOT EXISTS )(\w+)(.*);/i', $sql, $matches)) {
                    $tableName = $matches[2];
                    $this->tables[$tableName] = $matches[1] . $matches[2] . $matches[3] .
                        ' TYPE=' .$conf['table']['type'];
                    $sql = '';
                } else {
                    // Bad SQL, abort
                    MAX::debug('Bad SQL code:' . $sql, PEAR_LOG_ERR);
                    fclose($fp);
                    return false;
                }
            }
        }
        fclose($fp);
        return true;
    }

    /**
     * A method for creating tables.
     *
     * @param string $table The name of the table to create, excluding table prefix.
     * @param Date $date An optional date for creating split tables. Will use current
     *                   date if required and not supplied.
     * @return mixed The name of the table created, or false if the table was not able
     *               to be created.
     */
    function createTable($table, $date = NULL)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oServiceLocator = &ServiceLocator::instance();
        $dbh = &$oServiceLocator->get('MAX_DB');
        if (isset($this->tables[$table])) {
            // Are split tables in operation, and is the table designed to be split?
            if (($conf['table']['split']) && ($this->splitTables[$table])) {
                // Alter the SQL to create the appropriate split table
                if ($date == NULL) {
                    $date = new Date();
                }
                if (preg_match('/^(CREATE TABLE IF NOT EXISTS )(' . $conf['table']['prefix'] .
                        ')(\w+)(.*)/i', $this->tables[$table], $matches)) {
                    $tableName = $matches[2] . $matches[3] . '_' . $date->format('%Y%m%d');
                    $query = $matches[1] . $tableName  . $matches[4];
                } elseif (preg_match('/^(CREATE TEMPORARY TABLE IF NOT EXISTS )(\w+)(.*)/i',
                        $this->tables[$table], $matches)) {
                    $tableName = $matches[2] . '_' . $date->format('%Y%m%d');
                    $query = $matches[1] . $tableName  . $matches[3];
                }
            } else {
                // Use the default SQL
                $tableName = $conf['table']['prefix'].$table;
                $query = $this->tables[$table];
            }
            MAX::debug('Creating the ' . $tableName . ' table', PEAR_LOG_DEBUG);
            $result = $dbh->query($query);
            if (PEAR::isError($result)) {
                MAX::raiseError($result, MAX_ERROR_DBFAILURE);
                return false;
            }
            return $tableName;
        } else {
            // The table name requested does not exist
            MAX::debug('The table ' . $table . ' is not defined.', PEAR_LOG_ERR);
            return false;
        }
    }

    /**
     * A method for creating ALL defined tables.
     *
     * @param Date $date An optional date for creating split tables. Will use current
     *                   date if required and not supplied.
     * @return boolean True if all tables created successfuly, false otherwise.
     */
    function createAllTables($date = NULL)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oServiceLocator = &ServiceLocator::instance();
        $dbh = &$oServiceLocator->get('MAX_DB');
        $allTablesOkay = true;
        foreach ($this->tables as $tableName => $query) {
            if ($conf['table']['split']) {
                // If the table is listed as split, don't create
                if ($this->splitTables[$tableName]) {
                    continue;
                }
            }
            MAX::debug('Creating the ' . $tableName . ' table', PEAR_LOG_DEBUG);
            $result = $dbh->query($query);
            if (PEAR::isError($result)) {
                MAX::debug('Unable to create the table ' . $table, PEAR_LOG_ERROR);
                $allTablesOkay = false;
            }
        }
        if ($conf['table']['split']) {
            $date = new Date();
            foreach ($this->splitTables as $tableName => $query) {
                if (preg_match('/^(CREATE TABLE IF NOT EXISTS )(' . $conf['table_prefix'] .
                        ')(\w+)(.*)/i', $this->tables[$tableName], $matches)) {
                    $tableName = $matches[2] . $matches[3] . '_' . $date->format('%Y%m%d');
                    $query = $matches[1] . $tableName  . $matches[4];
                } elseif (preg_match('/^(CREATE TEMPORARY TABLE IF NOT EXISTS )(\w+)(.*)/i',
                        $this->tables[$tableName], $matches)) {
                    $tableName = $matches[2] . '_' . $date->format('%Y%m%d');
                    $query = $matches[1] . $tableName  . $matches[3];
                }
                MAX::debug('Creating the ' . $tableName . ' table', PEAR_LOG_DEBUG);
                $result = $dbh->query($query);
                if (PEAR::isError($result)) {
                    MAX::debug('Unable to create the table ' . $table, PEAR_LOG_ERROR);
                    $allTablesOkay = false;
                }
            }
        }
        return $allTablesOkay;
    }

    /**
     * A method for dropping ALL defined tables.
     *
     * @return boolean True if all tables created successfuly, false otherwise.
     */
    function dropAllTables()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oServiceLocator = &ServiceLocator::instance();
        $dbh = &$oServiceLocator->get('MAX_DB');
        $allTablesOkay = true;
        foreach ($this->tables as $tableName => $query) {
            if ($conf['table']['split']) {
                // If the table is listed as split, don't drop
                if ($this->splitTables[$tableName]) {
                    continue;
                }
            }
            MAX::debug('Dropping the ' . $tableName . ' table', PEAR_LOG_DEBUG);
            $result = $this->dropTable($conf['table']['prefix'].$tableName);
            if (PEAR::isError($result)) {
                MAX::debug('Unable to drop the table ' . $table, PEAR_LOG_ERROR);
                $allTablesOkay = false;
            }
        }
        return $allTablesOkay;
    }

    /**
     * A method for dropping tables.
     *
     * @param string $table The table name to drop. Use the table name WITH prefix
     *                      (i.e. obtained from parsing the configuration .ini file).
     * @return boolean True if table dropped correctly, false otherwise.
     */
    function dropTable($table)
    {
        $oServiceLocator = &ServiceLocator::instance();
        $dbh = &$oServiceLocator->get('MAX_DB');
        $query = 'DROP TABLE ' . $table;
        MAX::debug('Dropping table ' . $table, PEAR_LOG_DEBUG);
        $result = $dbh->query($query);
        if (PEAR::isError($result)) {
            MAX::debug('Unable to drop table ' . $table, PEAR_LOG_ERROR);
            return false;
        }
        return true;
    }

    /**
     * A method for dropping temporary tables.
     *
     * @param string $table The temporary table to drop.
     * @return boolean True if table dropped correctly, false otherwise.
     */
    function dropTempTable($table)
    {
        $oServiceLocator = &ServiceLocator::instance();
        $dbh = &$oServiceLocator->get('MAX_DB');
        $query = 'DROP TEMPORARY TABLE ' . $table;
        MAX::debug('Dropping temporary table ' . $table, PEAR_LOG_DEBUG);
        $result = $dbh->query($query);
        if (PEAR::isError($result)) {
            MAX::debug('Unable to drop temporary table ' . $table, PEAR_LOG_ERROR);
            return false;
        }
        return true;
    }
}

?>
