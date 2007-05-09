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

require_once MAX_PATH . '/etc/changes/migration_tables_core_130.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';

/**
 * Test for migration class #130.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openads.org>
 */
class Migration_130Test extends UnitTestCase
{
    function testMigrateData()
    {
        $oTable = new OA_DB_Table();
        $oTable->init(MAX_PATH . '/etc/changes/schema_tables_core_129.xml');
        $oTable->createTable('adviews');
        $oTable->truncateTable('adviews');
        $oTable->createTable('data_raw_ad_impression');
        $oTable->truncateTable('data_raw_ad_impression');

        $oDbh = OA_DB::singleton();
        $migration = new Migration_130();
        $migration->init($oDbh);

        $t_stamp1 = date('Y-m-d', time() - 86400*2 + mt_rand(0, 86399));
        $t_stamp2 = date('Y-m-d', time() - 86400 + mt_rand(0, 86399));

        $aValues = array('bannerid' => 1, 'zoneid' => 0, 't_stamp' => $t_stamp1);
        $sql = OA_DB_Sql::sqlForInsert('adviews', $aValues);
        for ($i = 0; $i < 10; $i++) {
            $oDbh->exec($sql);
        }

        $aValues['t_stamp'] = $t_stamp2;
        $sql = OA_DB_Sql::sqlForInsert('adviews', $aValues);
        for ($i = 0; $i < 8; $i++) {
            $oDbh->exec($sql);
        }

        $migration->migrateData();

        $rsDRAI = DBC::NewRecordSet("SELECT COUNT(*) AS cnt FROM data_raw_ad_impression WHERE date_time = '{$t_stamp1}'");
        $rsDRAI->find();
        $this->assertTrue($rsDRAI->fetch());
        $aDataDRAI = $rsDRAI->toArray();
        $this->assertEqual($aDataDRAI['cnt'], 10);

        $rsDRAI = DBC::NewRecordSet("SELECT COUNT(*) AS cnt FROM data_raw_ad_impression WHERE date_time = '{$t_stamp2}'");
        $rsDRAI->find();
        $this->assertTrue($rsDRAI->fetch());
        $aDataDRAI = $rsDRAI->toArray();
        $this->assertEqual($aDataDRAI['cnt'], 8);


        $oTable->dropAllTables();
    }
}