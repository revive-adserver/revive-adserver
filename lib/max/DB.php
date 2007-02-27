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
require_once 'DB.php';

/**
 * Class for handling DB resources.
 *
 * @package    MaxDal
 * @author     Demian Turner <demian@m3.net>
 */
class MAX_DB
{
    
    /**
     * Constructor.
     */
    function MAX_DB()
    {
        MAX::debug(null, PEAR_LOG_DEBUG);
    }

    /**
     * Returns the default DSN specified in the global config.
     *
     * @static
     * @param int $type A constant that specifies the return type, ie, array or string.
     * @return mixed A string or array containing the data source name.
     */
    function getDsn($type = MAX_DSN_ARRAY, $overrideMysql = true)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbType = $conf['database']['type'];
        if ($dbType == 'mysql' && $overrideMysql) {
            $dbType = 'mysql_SGL';
        }
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

    /**
     * Returns a singleton DB handle.
     *
     * example usage:
     * $dbh =& MAX_DB::singleton();
     * Warning: In order to work correctly, DB handle singleton must be
     * instantiated statically and by reference.
     *
     * @static
     * @param string $dsn The datasource details if supplied: see {@link DB::parseDSN()} for format
     * @return mixed Reference to DB resource or false on failure to connect
     */
    function &singleton($dsn = null)
    {
        $dsn = ($dsn === null) ? MAX_DB::getDsn(MAX_DSN_STRING) : $dsn;
        $dsnMd5 = md5($dsn);
        $aConnections = array_keys($GLOBALS['_MAX']['CONNECTIONS']);
        if (!(count($aConnections)) || !(in_array($dsnMd5, $aConnections))) {
            $conf = $GLOBALS['_MAX']['CONF'];
            $GLOBALS['_MAX']['CONNECTIONS'][$dsnMd5] = DB::connect($dsn);
            //  If DB connect fails and we're installing, return error
            if (DB::isError($GLOBALS['_MAX']['CONNECTIONS'][$dsnMd5])) {
                // Check for typical MySql user error
                if (($conf['database']['type'] == 'mysql') && (!function_exists('mysql_connect'))) {
                    MAX::debug('You don\'t appear to have the MySql extension installed, exiting...',
                               MAX_ERROR_DBFAILURE);
                } else {
                    MAX::debug('Cannot connect to DB, check your credentials', MAX_ERROR_DBFAILURE);
                    // MAX::raiseError($GLOBALS['_MAX']['CONNECTIONS'][$dsnMd5], MAX_ERROR_DBFAILURE);                    
                }
                return false;
            }
            $GLOBALS['_MAX']['CONNECTIONS'][$dsnMd5]->setFetchMode(DB_FETCHMODE_ASSOC);            
        }
        return $GLOBALS['_MAX']['CONNECTIONS'][$dsnMd5];
    }
    
    /**
     * Factory DataObject by it's table name
     *
     * @param  string  $table  tablename (use blank to create a new instance of the same class.)
     * @access pblic
     * @return DataObject|PEAR_Error 
     */
    function factoryDO($table)
    {
        include_once 'DB/DataObject.php';
        $do = DB_DataObject::factory($table);
        if (is_a($do, 'DB_DataObjectCommon')) {
            $do->init();
        }
        return $do;
    }
    
    /**
     * Factory DAL model class by it's table name
     *
     * @param string $table
     * @return MAX_Dal_Common|false
     */
    function factoryDAL($table)
    {
        include_once MAX_PATH . '/lib/max/Dal/Common.php';
        return MAX_Dal_Common::factory($table);
    }
    
    function getInsertId()
    {
        //  mysql only!
        $dbh = & MAX_DB::singleton();
        $id = @mysql_insert_id($dbh->connection);
        return $id;
    }
    
    //////////////////  DELETE FROM HERE DOWNWARDS  ///////////////////
    
    /**
     * A method for executing SQL statements.
     *
     * Aborts execution of the entire PHP script if the SQL statement
     * results in an error from MySQL.
     *
     * @param text $sql The SQL statement to execute.
     * @param resource $result A reference to the MySQL result resouce.
     */
    function execute($sql, &$result)
    {
        $dbh = & MAX_DB::singleton();
        $result = $dbh->query($sql);
        
        if (DB::isError($result)) {
            debug('Error executing SQL: ' . $result->getInfo() . ': ', PEAR_LOG_ERR);
            debug('Aborting script execution', PEAR_LOG_ERR);
            exit();
        }
#        $result = @mysql_query($sql, $this->dbConnection);
#        if (!$result) {
#            debug('Error executing SQL: ' . $sql . ': ' . mysql_error($this->dbConnection), PEAR_LOG_ERR);
#            debug('Aborting script execution', PEAR_LOG_ERR);
#            exit();
#        }
    }
    
    /**
     * A method for executing SQL statements that might cause non-fatal
     * errors.
     *
     * Aborts execution of the entire PHP script if the SQL statement
     * results in an error from MySQL, unless the MySQL error code
     * is found in the array of supplied error codes.
     *
     * @param text $sql The SQL statement to execute.
     * @param resource $result A reference to the MySQL result resouce.
     * @param array $error An optional array of integer MySQL error codes
     *                     that will be ignored (ie. won't halt the execution
     *                     of the PHP script). If not supplied, will ignore
     *                     all possible errors.
     * @return integer The error number ignored, if executed with errors, or 0 if
     *                 there were no errors.
     */
    function executeIgnoreErrors($sql, &$result, $errors = NULL) {
        $returnValue = 0;
        $result = @mysql_query($sql, $this->dbConnection);
        if (!$result) {
            $returnedError = mysql_errno($this->dbConnection);
            if (is_null($errors)) {
                return $returnedError;
            }
            // Is the MySQL error code permitted to be ignored?
            $halt = true;
            foreach ($errors as $errorCode) {
                if ($returnedError == $errorCode) {
                    $halt = false;
                    $returnValue = $errorCode;
                    break;
                }
            }
            if ($halt) {
                // Did not find the error was safe to ignore, so abort
                debug('Error executing SQL: ' . $sql . ': ' . mysql_error($this->dbConnection), PEAR_LOG_ERR);
                debug('Aborting script execution', PEAR_LOG_ERR);
                exit();
            } else {
                // The error may be safely ignored
                debug('Safely ignored MySQL error code ' . $returnedError, PEAR_LOG_DEBUG);
            }
        }
        return $returnValue;
    }
    
    /**
     * A method for fetching the number of rows returned by a SQL statement.
     *
     * @param resource result $result A MySQL resource result.
     * @return integer The number of rows in the resource result.
     */
    function numberOfRows($result)
    {
#        return mysql_num_rows($result);
        return $dbh->numRows();
    }
    
    /**
     * A method for fetching the data returned by a SQL statement into an array.
     *
     * @param resource result $result A MySQL resource result.
     * @return array An array of the data in the resource result.
     */
    function fetchResultAsArray($result)
    {
        $array = mysql_fetch_array($result);
        return $array;
    }
    
    /**
     * A method for returning the number of rows affected by a SQL statement
     * executed (immediately) previously.
     *
     * @return integer The number of rows affected by the previous query.
     */
    function affectedRows()
    {
        return mysql_affected_rows($this->dbConnection);
    }    
}

?>
