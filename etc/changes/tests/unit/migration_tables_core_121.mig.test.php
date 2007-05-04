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

require_once MAX_PATH . '/etc/changes/migration_tables_core_121.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';

/**
 * Test for migration class #121.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openads.org>
 */
class Migration_121Test extends UnitTestCase
{
    function testMigrateData()
    {
        $oTable = new OA_DB_Table();
        $oTable->init(MAX_PATH . '/etc/changes/schema_tables_core_121.xml');
        $oTable->createTable('acls');
        $oTable->truncateTable('acls');
        
        $oDbh = OA_DB::singleton();
        $migration = new Migration_121();
        $migration->init($oDbh);
        
        $aTestData = array(
            array('weekday', '==', '0,1')
        );
        $aExpectedData = array(
            array('Time:Day', '=~', '0,1')
        );
        
        $aValues = array();
        $idx = 0;
        foreach ($aTestData as $testData) {
            $aValues = array(
                'bannerid' => 1,
                'logical' => 'and',
                'type' => $testData[0],
                'comparison' => $testData[1],
                'data' => $testData[2],
                'executionorder' => $idx++);
            $sql = OA_DB_Sql::sqlForInsert('acls', $aValues);
            $oDbh->exec($sql);
        }
        $cLimitations = $idx;
        
        $migration->migrateData();
        
        $rsAcls = DBC::NewRecordSet("SELECT type, comparison, data FROM acls ORDER BY executionorder");
        $this->assertTrue($rsAcls->find());
        
        for ($idx = 0; $idx < $cLimitations; $idx++) {
            $this->assertTrue($rsAcls->fetch());
            $this->assertEqual($aExpectedData[$idx][0], $rsAcls->get('type'));
            $this->assertEqual($aExpectedData[$idx][1], $rsAcls->get('comparison'));
            $this->assertEqual($aExpectedData[$idx][2], $rsAcls->get('data'));
        }
        $this->assertFalse($rsAcls->fetch());
        
        $oTable->dropAllTables();
    }
}