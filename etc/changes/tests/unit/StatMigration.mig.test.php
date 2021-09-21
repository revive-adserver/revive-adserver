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

require_once MAX_PATH . '/etc/changes/StatMigration.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';


/**
 * Test for StatMigration class.
 *
 * @package    changes
 * @subpackage TestSuite
 */
class StatMigrationTest extends MigrationTest
{
    public $configPath;

    public function setUp()
    {
        parent::setUp();
        $this->initDatabase(108, ['adstats', 'adviews', 'adclicks', 'data_summary_ad_hourly', 'data_intermediate_ad']);
        $this->configPath = MAX_PATH . '/var/config.inc.php';
    }


    public function testMigrateCompactStats()
    {
        $oDbh = &$this->oDbh;

        $migration = new StatMigration();
        $migration->init($this->oDbh, MAX_PATH . '/var/DB_Upgrade.test.log');

        $cEntries = $this->prepareTestData($mapCImpressions, $mapCClicks, '_insertCompactStatsTestData');

        $this->assertTrue($migration->migrateCompactStats());

        $this->_checkDataTable('data_summary_ad_hourly', $cEntries, $mapCImpressions, $mapCClicks);
        $this->_checkDataTable('data_intermediate_ad', $cEntries, $mapCImpressions, $mapCClicks);
    }


    public function prepareTestData(&$mapCImpressions, &$mapCClicks, $functionInsertTestData)
    {
        $aBannerIds = [1, 2, 3];
        $aZoneIds = [1, 2, 3];
        $aDays = ["2007-05-10", "2007-05-11", "2007-05-12"];
        $aCImpressions = [5, 7, 12, 32, 4];
        $aCClicks = [8, 4, 15, 9, 2];


        foreach ($aBannerIds as $bannerId) {
            foreach ($aZoneIds as $zoneId) {
                foreach ($aDays as $day) {
                    for ($hour = 0; $hour < 24; $hour++) {
                        $mapCImpressions[$bannerId][$zoneId][$day][$hour] =
                            $aCImpressions[$hour % count($aCImpressions)];
                        $mapCClicks[$bannerId][$zoneId][$day][$hour] =
                            $aCClicks[$hour % count($aCClicks)];
                        $this->$functionInsertTestData($bannerId, $zoneId, $day, $hour, $mapCImpressions, $mapCClicks);
                    }
                }
            }
        }
        return count($aBannerIds) * count($aZoneIds) * count($aDays) * 24;
    }


    public function _insertCompactStatsTestData($bannerId, $zoneId, $day, $hour, $mapCImpressions, $mapCClicks)
    {
        $aValues = [
            'bannerid' => $bannerId,
            'zoneid' => $zoneId,
            'day' => $day,
            'hour' => $hour,
            'views' => $mapCImpressions[$bannerId][$zoneId][$day][$hour],
            'clicks' => $mapCClicks[$bannerId][$zoneId][$day][$hour]];
        $sql = OA_DB_Sql::sqlForInsert('adstats', $aValues);
        $this->oDbh->exec($sql);
    }


    public function _checkDataTable($table, $cEntries, $mapCImpressions, $mapCClicks)
    {
        $table = $this->oDbh->quoteIdentifier($this->getPrefix() . $table, true);
        $rsDsah = DBC::NewRecordSet("SELECT * FROM $table");
        $this->assertTrue($rsDsah->find());
        $this->assertEqual($cEntries, $rsDsah->getRowCount());
        while ($rsDsah->fetch()) {
            $bannerId = $rsDsah->get('ad_id');
            $zoneId = $rsDsah->get('zone_id');
            $day = $rsDsah->get('day');
            $hour = $rsDsah->get('hour');
            $this->assertEqual($mapCImpressions[$bannerId][$zoneId][$day][$hour], $rsDsah->get('impressions'));
            $this->assertEqual($mapCClicks[$bannerId][$zoneId][$day][$hour], $rsDsah->get('clicks'));
        }
    }


    public function _insertRawStatsTestData($bannerId, $zoneId, $day, $hour, $mapCImpressions, $mapCClicks)
    {
        $this->_insertRawStatsRows($bannerId, $zoneId, $day, $hour, 'adviews', $mapCImpressions);
        $this->_insertRawStatsRows($bannerId, $zoneId, $day, $hour, 'adclicks', $mapCClicks);
    }


    public function _insertRawStatsRows($bannerId, $zoneId, $day, $hour, $table, $mapCRows)
    {
        for ($idxRow = 0; $idxRow < $mapCRows[$bannerId][$zoneId][$day][$hour]; $idxRow++) {
            $minutes = mt_rand(0, 59);
            $seconds = mt_rand(0, 59);
            $timestamp = "$day $hour:$minutes:$seconds";
            $aValues = [
                'bannerid' => $bannerId,
                'zoneid' => $zoneId,
                't_stamp' => $timestamp];
            $sql = OA_DB_Sql::sqlForInsert($table, $aValues);
            $this->oDbh->exec($sql);
        }
    }


    public function testMigrateRawStats()
    {
        $oDbh = &$this->oDbh;
        $migration = new StatMigration();
        $migration->init($oDbh, MAX_PATH . '/var/DB_Upgrade.test.log');

        $cEntries = $this->prepareTestData($mapCImpressions, $mapCClicks, '_insertRawStatsTestData');

        $this->assertTrue($migration->migrateRawStats());

        $this->_checkDataTable('data_summary_ad_hourly', $cEntries, $mapCImpressions, $mapCClicks);
        $this->_checkDataTable('data_intermediate_ad', $cEntries, $mapCImpressions, $mapCClicks);
    }

    public function testStatsCompacted()
    {
        $migration = new StatMigration();
        $this->_initPanConfigStatsCompacted('true');
        $this->assertTrue($migration->statsCompacted());
        $this->_initPanConfigStatsCompacted('false');
        $this->assertFalse($migration->statsCompacted());
        unlink($this->configPath);
    }


    public function _initPanConfigStatsCompacted($value)
    {
        $fPanConfig = fopen($this->configPath, "wt");
        fwrite($fPanConfig, "<?php\n\$phpAds_config['compact_stats'] = $value;\n?>\n");
        fclose($fPanConfig);
    }
}
