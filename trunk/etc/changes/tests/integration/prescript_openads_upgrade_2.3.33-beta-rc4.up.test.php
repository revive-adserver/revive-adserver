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


require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';

/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    OpenX Upgrade
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
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
        $this->UnitTestCase();
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
