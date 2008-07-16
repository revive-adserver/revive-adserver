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

require_once MAX_PATH . '/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/Table/Core.php';
require_once MAX_PATH . '/lib/OA/DB/Table/Priority.php';
require_once MAX_PATH . '/lib/OA/DB/Table/Statistics.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/wact/db/db.inc.php';
require_once MAX_PATH . '/lib/OA/Plugin/PluginManager.php';
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
                PEAR::raiseError(
                    "TestEnv unable to create the {$aConf['database']['name']} test database."
                    . $result->getUserInfo(), PEAR_LOG_ERR);
                die(1);
            }
            $result = OA_DB::createFunctions();
            if (PEAR::isError($result) && !$ignore_errors) {
                PEAR::raiseError("TestEnv unable to create the required functions."
                    . $result->getUserInfo(), PEAR_LOG_ERR);
                die(1);
            }
        }
    }

    /**
     * A method for setting up the core OpenX tables in the test database.
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

    function getPluginPackageManager($mock)
    {
        if ($mock)
        {
            Mock::generatePartial(  'OX_PluginManager',
                                    $mockPkgMgrClass = 'MOX_PluginManager'.rand(),
                                    array(
                                            '_auditInit',
                                            '_auditSetKeys',
                                            '_auditStart',
                                            '_auditUpdate',
                                            '_auditSetID',
                                            '_checkDatabaseEnvironment',
                                            '_registerSchema',
                                            '_registerPreferences',
                                            '_registerPluginVersion',
                                            '_unregisterSchema',
                                            '_unregisterPreferences',
                                            '_unregisterPluginVersion',
                                         )
                                 );
            $oPkgMgr = new $mockPkgMgrClass();
            // install tasks
            $oPkgMgr->setReturnValue('_auditInit', true);
            $oPkgMgr->setReturnValue('_auditSetKeys', true);
            $oPkgMgr->setReturnValue('_auditStart', true);
            $oPkgMgr->setReturnValue('_auditUpdate', true);
            $oPkgMgr->setReturnValue('_checkDatabaseEnvironment', true);
            //$oPkgMgr->setReturnValue('_runScript', true);
            //$oPkgMgr->setReturnValue('_checkDependenciesForInstallOrEnable', true);
            //$oPkgMgr->setReturnValue('_checkFiles', true);
            //$oPkgMgr->setReturnValue('_checkMenus', true);
            $oPkgMgr->setReturnValue('_registerSchema', true);
            $oPkgMgr->setReturnValue('_registerPreferences', true);
            //$oPkgMgr->setReturnValue('_registerSettings', true);
            $oPkgMgr->setReturnValue('_registerPluginVersion', true);

            // uninstall tasks
            //$oPkgMgr->setReturnValue('_checkDependenciesForUninstallOrDisable', true);
            $oPkgMgr->setReturnValue('_unregisterPluginVersion', true);
            $oPkgMgr->setReturnValue('_unregisterPreferences', true);
            //$oPkgMgr->setReturnValue('_unregisterSettings', true);
            $oPkgMgr->setReturnValue('_unregisterSchema', true);
            //$oPkgMgr->setReturnValue('_removeFiles', true);
        }
        else
        {
            $oPkgMgr = new OX_PluginManager();
        }
        $oPkgMgr->init();
        return $oPkgMgr;
    }

    function installPluginPackage($pkgName, $zipName, $zipPath, $noDb = true)
    {
        $oPkgMgr = & TestEnv::getPluginPackageManager($noDb);
        $result = $oPkgMgr->installPackage(array('tmp_name' => MAX_PATH . $zipPath.$zipName.'.zip', 'name'=>$zipName.'.zip'));
        if (!$result)
        {
            $errormsg = 'TestEnv unable to install plugins in '.MAX_PATH . $zipPath.$zipName.'.zip';
            foreach ($oPkgMgr->aErrors AS $i => $msg)
            {
                $errormsg.= '</br>'.$msg;
            }
            PEAR::raiseError($errormsg, PEAR_LOG_ERR);
            die(1);
        }
        $oPkgMgr->enablePackage($pkgName);
        return $result;
    }

    function uninstallPluginPackage($pkgName, $noDb= true)
    {
        $oPkgMgr = & TestEnv::getPluginPackageManager($noDb);

        $result = $oPkgMgr->uninstallPackage($pkgName);
        /*if (!$result)
        {
            $errormsg = 'TestEnv unable to uninstall plugins in '.$pkgName;
            foreach ($oPkgMgr->aErrors AS $i => $msg)
            {
                $errormsg.= '</br>'.$msg;
            }
            PEAR::raiseError($errormsg, PEAR_LOG_WARNING);
        }*/
        return true;
    }

    /**
     * use children of the OA_Test_Data class
     * to load a dataset using either dataobjects or mdb2_schema
     *
     * @param string $source : file identifier
     * @param string $type : type identifier : 'dataobjects' or 'mdb2schema'
     * @return array $aIds : array of inserted entity ids
     */
    function loadData($source, $type='dataobjects')
    {
        $file = MAX_PATH . '/tests/datasets/'.$type.'/test_'.$source.'.php';
        if (file_exists($file))
        {
            $classname = 'OA_Test_Data_'.str_replace('.','_',$source);
            require_once($file);
            if (class_exists($classname))
            {
                $obj = new $classname;
                if (!$obj->generateTestData())
                {
                    MAX::raiseError('loadData error: generating Test Data '.$classname);
                }
                return $obj->aIds;
            }
            MAX::raiseError('loadData error: unable to find classname '.$classname);
        }
        MAX::raiseError('loadData error: unable to find data source file '.$file);
        return false;
    }

    /**
     * A method for tearing down (dropping) the test database.
     */
    function teardownDB()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $result = OA_DB::dropDatabase($aConf['database']['name']);
        unset($GLOBALS['_OA']['CONNECTIONS']);
        $GLOBALS['_MDB2_databases'] = array();
    }

    /**
     * A method for re-parsing the testing environment configuration
     * file, to restore it in the event it needed to be changed
     * during a test.
     *
     * @todo Remove the audit hack
     */
    function restoreConfig()
    {
        // Destroy cached table classes
        OA_DB_Table_Core::destroy();
        // Restore and Re-parse the config file
        $backupConfigFilename = $GLOBALS['_MAX']['TEST']['backupConfigFilename'];
        if (!empty($backupConfigFilename) && is_readable($backupConfigFilename)) {
            $configFile = TestEnv::getConfigFilename();
            copy($backupConfigFilename, $configFile);
        } else {
            OA::debug("Could not restore config file from backup: {$backupConfigFilename}");
        }
        $newConf = TestEnv::parseConfigFile();
        foreach($newConf as $configGroup => $configGroupSettings) {
            foreach($configGroupSettings as $confName => $confValue) {
                $GLOBALS['_MAX']['CONF'][$configGroup][$confName] = $confValue;
            }
        }

        // Switch off audit
        $GLOBALS['_MAX']['CONF']['audit']['enabled'] = false;
    }

    /**
     * @todo The way we are importing test.conf.php has to be rethink. Now
     * it is included in init-parse.php file and here. It should be defined only in one place.
     *
     * @return array Return parsed config ini file
     */
    function parseConfigFile()
    {
        $configFile = TestEnv::getConfigFilename();
        if (file_exists($configFile)) {
            return @parse_ini_file($configFile, true);
        }
    }

    function getConfigFilename()
    {
        if (isset($_SERVER['SERVER_NAME'])) {
            // If test runs from web-client first check if host test config exists
            // This could be used to have different tests for different configurations
            $host = getHostName();
            $testFilePath = MAX_PATH . '/var/'.$host.'.test.conf.php';
            if (file_exists($testFilePath)) {
                return $testFilePath;
            }
        }
        // Look into default location
        $testFilePath = MAX_PATH . '/var/test.conf.php';
        if (file_exists($testFilePath)) {
            return $testFilePath;
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
    function restoreEnv($dropTmpTables='false')
    {
        $oDbh = &OA_DB::singleton();
        // Rollback any transactions that have not been closed
        // (Naughty, naughty test!)
        while ($oDbh->inTransaction(true) || $oDbh->inTransaction()) {
            TestEnv::rollbackTransaction();
        }
        if ($dropTmpTables)
        {
            TestEnv::dropTempTables();
        }
        // Truncate all known core tables
        $oTable = &OA_DB_Table_Core::singleton();
        $oTable->truncateAllTables();
        // Reset all database sequences
        $oTable->resetAllSequences();
        // Destroy the service locator
        $oServiceLocator =& OA_ServiceLocator::instance();
        unset($oServiceLocator->aService);
        // Re-set up the test environment
        TestRunner::setupEnv($GLOBALS['_MAX']['TEST']['layerEnv'], true);
    }

    function dropTempTables()
    {
        $oDbh = &OA_DB::singleton();
        // Truncate & drop all existing temporary tables
        $oTable = &OA_DB_Table_Priority::singleton();
        foreach ($oTable->aDefinition['tables'] as $tableName => $aTable) {
            if ($oTable->existsTemporaryTable($tableName))
            {
                $oTable->truncateTable($tableName);
                $oTable->dropTable($tableName);
            }
        }
        $oTable = &OA_DB_Table_Statistics::singleton();
        foreach ($oTable->aDefinition['tables'] as $tableName => $aTable) {
            if ($oTable->existsTemporaryTable($tableName))
            {
                $oTable->truncateTable($tableName);
                $oTable->dropTable($tableName);
            }
        }
    }

    /**
     * A method for starting a transaction when testing database code.
     *
     * DEPRECATED! DO NOT USE.
     */
    function startTransaction()
    {
    }

    /**
     * A method for ending a transaction when testing database code.
     *
     * DEPRECATED! DO NOT USE.
     */
    function rollbackTransaction()
    {
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

    /**
     * This function makes a backup copy of the config file to ensure that tests which write change
     * to the config file are able to roll-back their changes by calling restoreConfig
     *
     */
    function backupConfig()
    {
        $backupConfigFilename =& $GLOBALS['_MAX']['TEST']['backupConfigFilename'];
        if (empty($backupConfigFilename)) {
            $backupConfigFilename = MAX_PATH . '/var/' . uniqid('backup') . '.conf.php';
        }
        $configFile = TestEnv::getConfigFilename();

        // Backup user's original config file
        if (file_exists($configFile)) {
            return (@copy($configFile, $backupConfigFilename));
        }
        return false;
    }

    function removeBackupConfig()
    {
        $backupConfigFilename = $GLOBALS['_MAX']['TEST']['backupConfigFilename'];
        if (!empty($backupConfigFilename) && file_exists($backupConfigFilename)) {
            unlink($backupConfigFilename);
        }
    }

    // POSSIBLY DEPRECATED
    // MIGHT YET BE USEFUL
    // DO NOT REMOVE JUST YET
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
	// XML files are loaded from a cache, if available
	if (@include(MAX_PATH . "/tests/data/testData_{$source}.php")) {
		return isset($aDataset) && is_array($aDataset) ? $aDataset : false;
	}

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
     * utility for refactoring sql to dataobjects
     *
     * read some test data from a resource (file)
     * convert SQL statements into dataobject calls
     *
     * @param string $source A filename
     * @param string $mode 'insert / update / delete'
     * @return void
     */
    function convertDataSQLtoDBO($source, $mode)
    {
        $aDataset   = TestEnv::getDataSQL($source, $mode);
        $pattern    = "INSERT INTO (?P<table>[\w\W]+) \((?P<columns>[\w\W\s]+)\) VALUES \((?P<values>[\W\w\S]+)\);";
        foreach ($aDataset as $k => $v)
        {
            switch ($mode)
            {
                case 'insert':
                    if (preg_match("/{$pattern}/U",$v, $aMatches))
                    {
                        $aColumns   = explode(',',$aMatches['columns']);
                        $aValues    = explode(",",$aMatches['values']);
                        $aTables[$aMatches['table']][]  = array('columns' => $aColumns, 'values' => $aValues);
                    }
                    break;
            }
        }
        $fh = fopen(MAX_PATH . "/var/testdata.php", 'w');
        fwrite($fh, "<?php\n\n");
        $stat1  = '$a%s[\'%s\'] = %s;';
        $stat2  = "\$id%s%s = \$this->_insert%s(\$a%s);";
        foreach ($aTables AS $tableRaw => $array)
        {
            $i = 0;
            $tableBits  = explode('_',$tableRaw);
            $tableCamel = '';
            foreach ($tableBits as $val)
            {
                $tableCamel.= ucfirst($val);
            }
            foreach ($array AS $k => $v)
            {
                $i++;
                foreach ($v['columns'] AS $k => $column)
                {
                    $line = sprintf($stat1, $tableCamel, $column, $v['values'][$k])."\n";
                    fwrite($fh, $line);
                }
                $line = sprintf($stat2, $tableCamel, $i, $tableCamel, $tableCamel)."\n\n";
                fwrite($fh, $line);
            }
        }
        fwrite($fh, "?>\n\n");
        fclose($fh);
        return;
    }

    /**
     *
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
    function loadDataSQL($source, $mode)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $aDataset = TestEnv::getDataSQL($source, $mode);
        if ($aDataset)
        {
            foreach ($aDataset as $k => $v)
            {
                switch ($mode)
                {
                    case 'insert':
                        $oDbh = &OA_DB::singleton();
                        $query = '';
                        if (preg_match('/INSERT INTO (?P<table>[\w\W]+) (?P<query>\([\w\W\s]+\);)/U',$v, $aMatches))
                        {
                            $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].$aMatches['table'],true);
                            $query = 'INSERT INTO '.$table.' '.$aMatches['query'];
                        }
                        $res = $oDbh->query($query);
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
        MAX::raiseError('loadDataSQL error: unable to open '.$source);
        return;
    }

}

?>