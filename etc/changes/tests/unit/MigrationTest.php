<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/lib/OA/Upgrade/DB_Upgrade.php';
require_once MAX_PATH . '/lib/OA/Upgrade/DB_UpgradeAuditor.php';
require_once MAX_PATH . '/tests/testClasses/DbTestCase.php';

define('TEST_CONFIG_PATH', MAX_PATH . '/etc/changes/tests/data/config_2_0_12.inc.php');
define('CONFIG_PATH', MAX_PATH . '/var/config.inc.php');
define('TMP_CONFIG_PATH', MAX_PATH . '/var/config.inc.php.tmp');

/**
 * Test for migration class #127.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openads.org>
 */
class MigrationTest extends DbTestCase
{
    /**
     * The MDB2 driver handle.
     *
     * @var MDB2_Driver_Common
     */
    var $oDbh;
    
    function setUp()
    {
        $this->oDbh = &OA_DB::singleton();
    }
    
    
    function tearDown()
    {
        if (isset($this->oaTable)) {
            $this->oaTable->dropAllTables();
        }
    }
    
    function initDatabase($schemaVersion, $aTables)
    {
        $prefix = $this->getPrefix();
        $this->initOaTable("/etc/changes/schema_tables_core_{$schemaVersion}.xml");
        foreach($aTables as $table) {
            $this->oaTable->createTable($table);
            $this->oaTable->truncateTable($prefix . $table);
        }
    }
    
    function upgradeToVersion($version)
    {
        $upgrader = new OA_DB_Upgrade();
        $upgrader->initMDB2Schema();
        $auditor   = new OA_DB_UpgradeAuditor();
        $upgrader->oAuditor = &$auditor;
        $this->assertTrue($auditor->init($upgrader->oSchema->db), 'error initialising upgrade auditor, probable error creating database action table');
        $upgrader->init('constructive', 'tables_core', $version);
        $this->assertTrue($upgrader->upgrade());
    }
    
    function setupPanConfig()
    {
        if (file_exists(CONFIG_PATH)) {
            rename(CONFIG_PATH, TMP_CONFIG_PATH);
        }
        
        copy(TEST_CONFIG_PATH, CONFIG_PATH);
    }
    
    
    function restorePanConfig()
    {
        unlink(CONFIG_PATH);
        
        if (file_exists(TMP_CONFIG_PATH)) {
            rename(TMP_CONFIG_PATH, CONFIG_PATH);
        }
    }
}
?>