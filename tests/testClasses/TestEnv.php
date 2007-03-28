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

/**
 */

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';
require_once MAX_PATH . '/lib/max/Dal/db/db.inc.php';
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
     */
    function setupDB()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Prepare a new array of the database details, without the
        // database name, so that a connection to the database server
        // can be created, but so the database itself is not in use
        // (eg. PostgreSQL will not allow a database to be dropped
        // while a connection to the database exists)
        $aDatabaseDSN = $aConf;
        // The "test" database exists in MySQL and PostgreSQL, may
        // required tweaking for other database types!
        $aDatabaseDSN['database']['name'] = 'test';
        $dsn = OA_DB::getDsn($aDatabaseDSN);
        $oDbh = &OA_DB::singleton($dsn);
        // Ignore errors when dropping database - it may not exist
        PEAR::pushErrorHandling(null);
        $result = $oDbh->manager->dropDatabase($aConf['database']['name']);
        PEAR::popErrorHandling();
        $result = $oDbh->manager->createDatabase($aConf['database']['name']);
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
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $result = $oDbh->manager->dropDatabase($aConf['database']['name']);
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
        $oDbh = &OA_DB::singleton();
        $query = 'SET AUTOCOMMIT=1';
        $result = $oDbh->exec($query);
        // Drop all known temporary tables
        $oTable = &OA_DB_Table_Priority::singleton();
        foreach ($oTable->aDefinition['tables'] as $tableName => $aTable) {
            $oTable->dropTable($tableName);
        }
        $oTable = &OA_DB_Table_Statistics::singleton();
        foreach ($oTable->aDefinition['tables'] as $tableName => $aTable) {
            $oTable->dropTable($tableName);
        }
        // Drop all database connections
        OA_DB::disconnectAll();
        // Destroy any DataObject connection
        DB_DataObjectCommon::disconnect();
        // Destroy any DAL connection
        DBC::disconnect();
        // Destroy any Delivery Engine database connections
        unset($GLOBALS['_MAX']['ADMIN_DB_LINK']);
        unset($GLOBALS['_MAX']['RAW_DB_LINK']);
        // Destroy any cached table classes
        OA_DB_Table_Core::destroy();
        OA_DB_Table_Priority::destroy();
        OA_DB_Table_Statistics::destroy();
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

}

?>
