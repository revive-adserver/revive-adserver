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

/**
 * Test for migration class #127.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openads.org>
 */
class MigrationTest extends UnitTestCase
{
    /**
     * The MDB2 driver handle.
     *
     * @var MDB2_Driver_Common
     */
    var $oDbh;
    
    /**
     * The OA_DB_Table handle.
     *
     * @var OA_DB_Table
     */
    var $oTable;
    
    function setUp()
    {
        $this->oDbh = &OA_DB::singleton();
        $this->oTable = new OA_DB_Table();
    }
    
    
    function tearDown()
    {
        $this->oTable->dropAllTables();
    }
    
    function initDatabase($schemaVersion, $aTables)
    {
        $this->oTable->init(MAX_PATH . "/etc/changes/schema_tables_core_{$schemaVersion}.xml");
        foreach($aTables as $table) {
            $this->oTable->createTable($table);
            $this->oTable->truncateTable($table);
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
}
?>