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
$Id: TestEnv.php 5982 2006-11-16 12:55:49Z roh@m3.net $
*/

/**
 */

require_once MAX_PATH . '/lib/max/DB.php';
require_once MAX_PATH . '/lib/max/Table/Core.php';
require_once MAX_PATH . '/tests/data/DefaultData.php';

/**
 * A class for setting up and tearing down the testing environment.
 *
 * @package    Max
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class TestEnv
{
    /**
     * A method for setting up a test database.
     */
    function setupDB()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        // Create a DSN to access the SQL server with
        $dbType = $conf['database']['type'];
        if ($dbType == 'mysql') {
            $dbType = 'mysql_SGL';
        }
    	$protocol = isset($conf['database']['protocol']) ? $conf['database']['protocol'] . '+' : '';
        $dsn = $dbType . '://' .
            $conf['database']['username'] . ':' .
            $conf['database']['password'] . '@' .
            $protocol .
            $conf['database']['host'];
        $dbh = &MAX_DB::singleton($dsn);
        $query = 'DROP DATABASE IF EXISTS ' . $conf['database']['name'];
        $result = $dbh->query($query);
        $query = 'CREATE DATABASE ' . $conf['database']['name'];
        $result = $dbh->query($query);
    }

    /**
     * A method for setting up the core Max tables in the test database.
     */
    function setupCoreTables()
    {
        MAX_Table_Core::destroy();
        $tables = MAX_Table_Core::singleton();
        $tables->createAllTables();
    }

    /**
     * A method for setting up the default data set for testing.
     */
    function setupDefaultData()
    {
        DefaultData::insertDefaultData();
    }

      /**
       * @todo construct xml_parser to deal with binary and html cdata
       *
       */
//    function getDataSQL($source, $mode)
//    {
//        global $parser;
//
//        require_once MAX_PATH . '/tests/data/MAX_TestData_XML_Parser_1.php';
//        $parser = new MAX_TestData_XML_Parser_1($mode);
//        $parser->setInput($source);
//        if (is_resource($parser->fp))
//        {
//            $error = $parser->parse();
//            if (!$error)
//            {
//                return $parser->aDataset;
//            }
//            else
//            {
//                return $error;
//            }
//        }
//        return 'error opening xml resource';
//    }

    /**
     * create an xml_parser resource
     * open the given resource
     * parse the resource
     *
     * @param string $source	The name of a dataset.
     * @param string $mode		Either 'insert' or 'text'.
     * @return array | false    An array of strings, each representing
     *                          a SQL DML query. False on error.
     * 
     * @todo Document the returned array format for 'text' mode.
     * @todo Document $mode option, or remove it
     * @todo Consider raising an error instead of returning false.
     */
    function getDataSQL($source, $mode)
    {

        require_once MAX_PATH . '/tests/testClasses/MAX_TestData_XML_Parser.php';
        $xml = new MAX_TestData_XML_Parser($mode);
        $xml->setInput($source);
        if (is_resource($xml->fp))
        {
            $res = $xml->parse();
            if ($res)
            {
                return $xml->aDataset;
            }
        }
        return false;
    }

    /**
     * read some test data from a resource (file)
     *
     * return a dataset array in 'text' mode
     * insert data in mysql db in 'insert' mode
     *
     * @todo get 'text' mode working
     * @todo consider separating the two modes into separate methods
     * @param string $source A filename
     * @param string $mode Either 'insert' or 'text'
     * @return void
     */
    function loadData($source, $mode)
    {
        $aDataset = TestEnv::getDataSQL($source, $mode);
        if ($aDataset)
        {
            foreach ($aDataset as $k => $v)
            {
                switch ($mode)
                {
                    case 'insert':
                        $dbh = &MAX_DB::singleton();
                        $res = $dbh->query($v);
                        if (!res || PEAR::isError($res))
                        {
                            MAX::raiseError($res);
                            return;
                        }
                        break;
                    case 'text':
                        // XXX: Why do we return the first key in the dataset?
                        return $aDataset;
                        break;
                }
            }
            return;
        }
        MAX::raiseError('loadData error: unable to open '.$source);
        return;
    }
    /**
     * A method for tearing down (dropping) the test database.
     */
    function teardownDB()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $query = 'DROP DATABASE ' . $conf['database']['name'];
        $result = $dbh->query($query);
    }

    /**
     * A method for re-parsing the testing environment configuration
     * file, to restore it in the event it needed to be changed
     * during a test.
     */
    function restoreConfig()
    {
        // Destroy cached table classes
        MAX_Table_Core::destroy();
        // Re-parse the config file
        $newConf = @parse_ini_file(MAX_PATH . '/var/test.conf.ini', true);
        foreach($newConf as $configGroup => $configGroupSettings) {
            foreach($configGroupSettings as $confName => $confValue) {
                $GLOBALS['_MAX']['CONF'][$configGroup][$confName] = $confValue;
            }
        }
    }

    /**
     * A method for restoring the testing environment database setup.
     * This method can normaly be avoided by using transactions to
     * rollback database changes during testing, but sometimes a
     * DROP TEMPORARY TABLE (for example) is used during testing,
     * causing any transaction to be committed. In this case, this
     * method is needed to re-set the testing database.
     */
    function restoreEnv()
    {
        // Disable transactions, so that setting up the test environment works
        $dbh = &MAX_DB::singleton();
        $query = 'SET AUTOCOMMIT=1';
        $result = $dbh->query($query);
        // Drop the database connection, so that temporary tables will be
        // removed (hack needed to overcome MySQL keeping temporary tables
        // if a database is dropped and re-created)
        $dbh->disconnect();
        $GLOBALS['_MAX']['CONNECTIONS'] = array();
        // Destroy cached table classes
        MAX_Table_Core::destroy();
        // Destroy the service locator
        $oServiceLocator = &ServiceLocator::instance();
        unset($oServiceLocator->aService);
        // Re-set up the test environment
        TestRunner::setupEnv($GLOBALS['_MAX']['TEST']['layerEnv']);
    }

    /**
     * A method for rebuilding the database sequences.
     */
    function rebuildSequences()
    {

    }

    /**
     * A method for starting a transaction when testing database code.
     */
    function startTransaction()
    {
        $dbh = &MAX_DB::singleton();
        $dbh->startTransaction();
    }

    /**
     * A method for ending a transaction when testing database code.
     */
    function rollbackTransaction()
    {
        $dbh = &MAX_DB::singleton();
        $dbh->rollback();
    }

}

?>
