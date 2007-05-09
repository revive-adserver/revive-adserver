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

require_once MAX_PATH . '/etc/changes/StatMigration.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';

/**
 * Test for StatMigration class.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openads.org>
 */
class StatMigrationTest extends MigrationTest
{
    var $configPath;
    
    function setUp()
    {
        parent::setUp();
        $this->initDatabase(128, array('adstats', 'adviews', 'adclicks', 'data_raw_ad_impression', 'data_raw_ad_click'));
        $this->configPath = MAX_PATH . '/var/config.inc.php';
    }
    
    
    function testMigrateCompactStats()
    {
        $oDbh = &$this->oDbh;

        $migration = new StatMigration();
        $migration->init($this->oDbh);

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

        $this->assertTrue($migration->migrateCompactStats());

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
    }
    
    
    function testMigrateImpressions()
    {
        $oDbh = &$this->oDbh;
        $migration = new StatMigration();
        $migration->init($oDbh);

        $t_stamp1 = date('Y-m-d', $this->_getRandomTimeFromDay());
        $t_stamp2 = date('Y-m-d', $this->_getRandomTimeFromDay(-1));

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

        $this->assertTrue($migration->migrateImpressions());

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
    }
    
    
    function testMigrateClicks()
    {
        $oDbh = $this->oDbh;

        $migration = new StatMigration();
        $migration->init($oDbh);

        $t_stamp1 = date('Y-m-d', $this->_getRandomTimeFromDay());
        $t_stamp2 = date('Y-m-d', $this->_getRandomTimeFromDay(-1));

        $aValues = array('bannerid' => 1, 'zoneid' => 0, 't_stamp' => $t_stamp1);
        $sql = OA_DB_Sql::sqlForInsert('adclicks', $aValues);
        for ($i = 0; $i < 10; $i++) {
            $oDbh->exec($sql);
        }

        $aValues['t_stamp'] = $t_stamp2;
        $sql = OA_DB_Sql::sqlForInsert('adclicks', $aValues);
        for ($i = 0; $i < 8; $i++) {
            $oDbh->exec($sql);
        }

        $this->assertTrue($migration->migrateClicks());

        $rsDRAC = DBC::NewRecordSet("SELECT COUNT(*) AS cnt FROM data_raw_ad_click WHERE date_time = '{$t_stamp1}'");
        $rsDRAC->find();
        $this->assertTrue($rsDRAC->fetch());
        $aDataDRAC = $rsDRAC->toArray();
        $this->assertEqual($aDataDRAC['cnt'], 10);

        $rsDRAC = DBC::NewRecordSet("SELECT COUNT(*) AS cnt FROM data_raw_ad_click WHERE date_time = '{$t_stamp2}'");
        $rsDRAC->find();
        $this->assertTrue($rsDRAC->fetch());
        $aDataDRAC = $rsDRAC->toArray();
        $this->assertEqual($aDataDRAC['cnt'], 8);
    }
    
    
    function _getRandomTimeFromDay($idxDay = 0)
    {
        $secondsPerDay = 24 * 60 * 60;
        $time = time();
        return $time - $time % $secondsPerDay + $idxDay * $secondsPerDay + mt_rand(0, 86399);
    }
    
    function testStatsCompacted()
    {
        $migration = new StatMigration();
        $this->_initPanConfigStatsCompacted('true');
        $this->assertTrue($migration->statsCompacted());
        $this->_initPanConfigStatsCompacted('false');
        $this->assertFalse($migration->statsCompacted());
        unlink($this->configPath);
    }
    
    
    function _initPanConfigStatsCompacted($value)
    {
        $fPanConfig = fopen($this->configPath, "wt");
        fwrite($fPanConfig, "<?php\n\$phpAds_config['compact_stats'] = $value;\n?>\n");
        fclose($fPanConfig);
    }
}
?>