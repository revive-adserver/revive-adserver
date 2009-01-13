<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
class Test_postscript_2_3_36_beta_rc1 extends UnitTestCase
{
    var $prefix;

    /**
     * The constructor method.
     */
    function Test_OA_Upgrade()
    {
        $this->UnitTestCase();
        $this->prefix  = 'oaTest_';
    }

    function test_runScript()
    {
        $GLOBALS['_MAX']['CONF']['table']['prefix'] = $this->prefix;
        $oUpgrade  = new OA_Upgrade();
        $oUpgrade->initDatabaseConnection();
        $oDbh = & $oUpgrade->oDbh;

        $oTable = new OA_DB_Table();
        $testfile  = MAX_PATH."/etc/changes/tests/data/schema_tables_core_dashboard.xml";
        $oTable->init($testfile);

        $table = 'preference';
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        if (in_array($this->prefix.$table,$aExistingTables))
        {
            $this->assertTrue($oTable->dropTable($this->prefix.$table),'error dropping '.$this->prefix.$table);
        }
        $this->assertTrue($oTable->createTable($table),'error creating '.$this->prefix.$table);
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertTrue(in_array($this->prefix.$table, $aExistingTables), $this->prefix.$table.' table not found');

        $this->assertTrue($oUpgrade->runScript('postscript_openads_upgrade_2.3.36-beta-rc1.php'));

        $aExistingColumns = $oDbh->manager->listTableFields($this->prefix.$table);
        $aColumns = array(
                          'ad_clicks_sum',
                          'ad_views_sum',
                          'ad_clicks_per_second',
                          'ad_views_per_second',
                          'ad_cs_data_last_sent',
                          'ad_cs_data_last_sent',
                          'ad_cs_data_last_received',
                        );
        foreach ($aColumns AS $column)
        {
            $this->assertFalse(in_array($column, $aExistingColumns, $column.' found in column list'));
        }

        TestEnv::restoreConfig();
        TestEnv::restoreEnv();
    }

}

?>
