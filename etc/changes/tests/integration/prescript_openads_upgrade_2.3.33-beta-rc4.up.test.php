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

require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';

/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    OpenX Upgrade
 * @subpackage TestSuite
 */
class Test_prescript_2_3_33_beta_rc4 extends UnitTestCase
{
    var $prefix;
    var $oConfiguration;
    var $configFile;

    /**
     * The constructor method.
     */
    function Test_OA_Upgrade()
    {
        parent::__construct();
        $this->prefix  = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $this->configFile = MAX_PATH.'/var/test.conf.php';
    }

    function test_runScript()
    {
        $oUpgrade  = new OA_Upgrade();
        $this->oConfiguration = $oUpgrade->oConfiguration;
        $oUpgrade->initDatabaseConnection();
        $oDbh = & $oUpgrade->oDbh;

        $oTable = new OA_DB_Table();
        $table = 'database_action';
        $testfile  = MAX_PATH."/lib/OA/Upgrade/tests/data/{$table}.xml";
        $oTable->init($testfile);
        $this->assertTrue($oTable->dropTable($this->prefix.$table),'error dropping '.$this->prefix.$table);
        $this->assertTrue($oTable->createTable($table),'error creating '.$this->prefix.$table);
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertTrue(in_array($this->prefix.$table, $aExistingTables), 'old database_action table not found');

        $this->assertTrue($oUpgrade->runScript('prescript_openads_upgrade_2.3.33-beta-rc4.php'));
        TestEnv::restoreConfig();
    }

}

?>
