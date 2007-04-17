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

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';
require_once MAX_PATH . '/lib/max/Dal/db/db.inc.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/Table/Core.php';
require_once MAX_PATH . '/lib/OA/DB/Table/Priority.php';
require_once MAX_PATH . '/lib/OA/DB/Table/Statistics.php';

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
     *
     * @param bool $ignore_errors True if setup errors should be ignored.
     */
    function setupDB($ignore_errors = false)
    {
        $oDbh = &OA_DB::singleton();
        if (PEAR::isError($oDbh)) {
            $aConf = $GLOBALS['_MAX']['CONF'];
            $result = OA_DB::createDatabase($aConf['database']['name']);
            if (PEAR::isError($result) && !$ignore_errors) {
                PEAR::raiseError("TestEnv unable to create the {$aConf['database']['name']} test database.", PEAR_LOG_ERR);
                die();
            }
        }
    }

    /**
     * A method for setting up the core Max tables in the test database.
     */
    function setupCoreTables()
    {
        OA_DB_Table_Core::destroy();
        $oTable = &OA_DB_Table_Core::singleton();
        $oTable->createAllTables();
    }

    /**
     * A method for setting up the default data set for testing.
     */
    function setupDefaultData()
    {
        DefaultData::insertDefaultData();
    }

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
                        $oDbh = &OA_DB::singleton();
                        $res = $oDbh->query($v);
                        if (!$res || PEAR::isError($res))
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
        $aConf = $GLOBALS['_MAX']['CONF'];
        $result = OA_DB::dropDatabase($aConf['database']['name']);
    }

    /**
     * A method for re-parsing the testing environment configuration
     * file, to restore it in the event it needed to be changed
     * during a test.
     */
    function restoreConfig()
    {
        // Destroy cached table classes
        OA_DB_Table_Core::destroy();
        // Re-parse the config file
        $newConf = TestEnv::parseConfigFile();
        foreach($newConf as $configGroup => $configGroupSettings) {
            foreach($configGroupSettings as $confName => $confValue) {
                $GLOBALS['_MAX']['CONF'][$configGroup][$confName] = $confValue;
            }
        }
    }

    /**
     * @todo The way we are importing test.conf.ini has to be rethink. Now
     * it is included in init-parse.php file and here. It should be defined only in one place.
     *
     * @return array Return parsed config ini file
     */
    function parseConfigFile()
    {
        if (isset($_SERVER['SERVER_NAME'])) {
            // If test runs from web-client first check if host test config exists
            // This could be used to have different tests for different configurations
            if (!empty($_SERVER['HTTP_HOST'])) {
                $host = explode(':', $_SERVER['HTTP_HOST']);
                $host = $host[0];
            } else {
                $host = explode(':', $_SERVER['SERVER_NAME']);
            	$host = $host[0];
            }
            $testFilePath = MAX_PATH . '/var/'.$host.'.test.conf.ini';
            if (file_exists($testFilePath)) {
                return @parse_ini_file($testFilePath, true);
            }
        }
        // Look into default location
        $testFilePath = MAX_PATH . '/var/test.conf.ini';
        if (file_exists($testFilePath)) {
            return @parse_ini_file($testFilePath, true);
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
        // Rollback any transactions that have not been closed
        // (Naughty, naughty test!)
        $oDbh = &OA_DB::singleton();
        while ($oDbh->inTransaction(true) || $oDbh->inTransaction()) {
            TestEnv::rollbackTransaction();
        }
        // Truncate & drop all known temporary tables
        $oTable = &OA_DB_Table_Priority::singleton();
        foreach ($oTable->aDefinition['tables'] as $tableName => $aTable) {
            $oTable->truncateTable($tableName);
            $oTable->dropTable($tableName);
        }
        $oTable = &OA_DB_Table_Statistics::singleton();
        foreach ($oTable->aDefinition['tables'] as $tableName => $aTable) {
            $oTable->truncateTable($tableName);
            $oTable->dropTable($tableName);
        }
        // Truncate all known core tables
        $oTable = &OA_DB_Table_Core::singleton();
        $oTable->truncateAllTables();
        // Reset all database sequences
        $oTable->resetAllSequences();
        // Destroy the service locator
        $oServiceLocator = &ServiceLocator::instance();
        unset($oServiceLocator->aService);
        // Re-set up the test environment
        TestRunner::setupEnv($GLOBALS['_MAX']['TEST']['layerEnv'], true);
    }

    /**
     * A method for starting a transaction when testing database code.
     */
    function startTransaction()
    {
        $oDbh = &OA_DB::singleton();
        $oDbh->beginTransaction();
    }

    /**
     * A method for ending a transaction when testing database code.
     */
    function rollbackTransaction()
    {
        $oDbh = &OA_DB::singleton();
        $oDbh->rollback();
    }

    /**
     * Empties all tables and resets all sequences.
     * Note: this method is not transaction safe - it is conceiveable another process could
     * insert data into the tables after they have been truncated but before the sequence is reset.
     *
     */
    function truncateAllTables()
    {
        $oTable = &OA_DB_Table_Core::singleton();
        $oTable->truncateAllTables();
        $oTable->resetAllSequences();

    }

}

?>
