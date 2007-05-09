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

require_once MAX_PATH . '/etc/changes/migration_tables_core_129.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';

/**
 * Test for migration class #129.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openads.org>
 */
class Migration_129Test extends UnitTestCase
{
    function testMigrateData()
    {
        $oTable = new OA_DB_Table();
        $oTable->init(MAX_PATH . '/etc/changes/schema_tables_core_128.xml');
        $oTable->createTable('adstats');
        $oTable->truncateTable('adstats');
        $oTable->createTable('data_raw_ad_impression');
        $oTable->truncateTable('data_raw_ad_impression');
        $oTable->createTable('data_raw_ad_click');
        $oTable->truncateTable('data_raw_ad_click');

        $oDbh = OA_DB::singleton();
        $migration = new Migration_129();
        $migration->init($oDbh);

        $day1 = date('Y-m-d', time() - 86400*2);
        $day2 = date('Y-m-d', time() - 86400);

        $aValues = array('bannerid' => 1, 'zoneid' => 0, 'day' => $day1, 'hour' => 0, 'views' => 10, 'clicks' => 2);
        $sql = OA_DB_Sql::sqlForInsert('adstats', $aValues);
        $oDbh->exec($sql);

        $aValues['hour'] = 1;
        $sql = OA_DB_Sql::sqlForInsert('adstats', $aValues);
        $oDbh->exec($sql);

        $aValues['day'] = $day2;
        $sql = OA_DB_Sql::sqlForInsert('adstats', $aValues);
        $oDbh->exec($sql);

        $migration->migrateData();

        $rsDRAI = DBC::NewRecordSet("SELECT COUNT(*) AS cnt FROM data_raw_ad_impression WHERE date_time = '{$day1} 00:00:00'");
        $rsDRAI->find();
        $this->assertTrue($rsDRAI->fetch());
        $aDataDRAI = $rsDRAI->toArray();
        $this->assertEqual($aDataDRAI['cnt'], 10);

        $rsDRAI = DBC::NewRecordSet("SELECT COUNT(*) AS cnt FROM data_raw_ad_impression WHERE date_time = '{$day1} 01:00:00'");
        $rsDRAI->find();
        $this->assertTrue($rsDRAI->fetch());
        $aDataDRAI = $rsDRAI->toArray();
        $this->assertEqual($aDataDRAI['cnt'], 10);

        $rsDRAI = DBC::NewRecordSet("SELECT COUNT(*) AS cnt FROM data_raw_ad_impression WHERE date_time = '{$day2} 01:00:00'");
        $rsDRAI->find();
        $this->assertTrue($rsDRAI->fetch());
        $aDataDRAI = $rsDRAI->toArray();
        $this->assertEqual($aDataDRAI['cnt'], 10);

        $rsDRAC = DBC::NewRecordSet("SELECT COUNT(*) AS cnt FROM data_raw_ad_click WHERE date_time = '{$day1} 00:00:00'");
        $rsDRAC->find();
        $this->assertTrue($rsDRAC->fetch());
        $aDataDRAC = $rsDRAC->toArray();
        $this->assertEqual($aDataDRAC['cnt'], 2);


        $oTable->dropAllTables();
    }
}