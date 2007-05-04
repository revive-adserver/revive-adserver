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

require_once MAX_PATH . '/etc/changes/migration_tables_core_128.php';

/**
 * Test for migration class #127.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openads.org>
 */
class Migration_128Test extends UnitTestCase
{
    function testMigrateData()
    {
        $oTable = new OA_DB_Table();
        $oTable->init(MAX_PATH . '/etc/changes/schema_tables_core_127.xml');
        $oTable->createTable('config');
        $oTable->truncateTable('config');
        $oTable->createTable('preference');
        $oTable->truncateTable('preference');
        
        $oDbh = OA_DB::singleton();
        $migration = new Migration_128();
        $migration->init($oDbh);
        
        $aValues = array('gui_show_parents' => "t", 'updates_enabled' => "f");
        $sql = $migration->sqlForInsert('config', $aValues);
        $oDbh->exec($sql);
        
        $migration->migrateData();
        
        $rsPreference = DBC::NewRecordSet("SELECT * from preference");
        $rsPreference->find();
        $this->assertTrue($rsPreference->fetch());
        $aDataPreference = $rsPreference->toArray();
        foreach($aValues as $column => $value) {
            $this->assertEqual($value, $aDataPreference[$column]);
        }
        
        $oTable->dropAllTables();
    }
    
    
    function testSqlForInsert()
    {
        $migration = new Migration_128();
        $sql = $migration->sqlForInsert('zones', array('zonetype' => 1, 'name' => "120x72"));
        $this->assertEqual("INSERT INTO zones (zonetype,name) VALUES (1,'120x72')", $sql);
    }
}