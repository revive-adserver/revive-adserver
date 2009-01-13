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

require_once MAX_PATH . '/etc/changes/StatMigration.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';


/**
 * Test for StatMigration class.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openx.org>
 */
class StatMigrationTest extends MigrationTest
{
    var $configPath;

    function setUp()
    {
        parent::setUp();
        $this->initDatabase(108, array('adstats', 'adviews', 'adclicks', 'data_summary_ad_hourly', 'data_intermediate_ad'));
        $this->configPath = MAX_PATH . '/var/config.inc.php';
    }


    function testMigrateCompactStats()
    {
        $oDbh = &$this->oDbh;

        $migration = new StatMigration();
        $migration->init($this->oDbh, MAX_PATH.'/var/DB_Upgrade.test.log');

        $cEntries = $this->prepareTestData($mapCImpressions, $mapCClicks, '_insertCompactStatsTestData');

        $this->assertTrue($migration->migrateCompactStats());

        $this->_checkDataTable('data_summary_ad_hourly', $cEntries, $mapCImpressions, $mapCClicks);
        $this->_checkDataTable('data_intermediate_ad', $cEntries, $mapCImpressions, $mapCClicks);
    }


    function prepareTestData(&$mapCImpressions, &$mapCClicks, $functionInsertTestData)
    {
        $aBannerIds = array(1,2,3);
        $aZoneIds = array(1,2,3);
        $aDays = array("2007-05-10", "2007-05-11", "2007-05-12");
        $aCImpressions = array(5, 7, 12, 32, 4);
        $aCClicks = array(8, 4, 15, 9, 2);


        foreach ($aBannerIds as $bannerId) {
            foreach ($aZoneIds as $zoneId) {
                foreach($aDays as $day) {
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


    function _insertCompactStatsTestData($bannerId, $zoneId, $day, $hour, $mapCImpressions, $mapCClicks)
    {

        $aValues = array(
            'bannerid' => $bannerId,
            'zoneid' => $zoneId,
            'day' => $day,
            'hour' => $hour,
            'views' => $mapCImpressions[$bannerId][$zoneId][$day][$hour],
            'clicks' => $mapCClicks[$bannerId][$zoneId][$day][$hour]);
        $sql = OA_DB_Sql::sqlForInsert('adstats', $aValues);
        $this->oDbh->exec($sql);
    }


    function _checkDataTable($table, $cEntries, $mapCImpressions, $mapCClicks)
    {
        $table = $this->oDbh->quoteIdentifier($this->getPrefix().$table,true);
        $rsDsah = DBC::NewRecordSet("SELECT * FROM $table");
        $this->assertTrue($rsDsah->find());
        $this->assertEqual($cEntries, $rsDsah->getRowCount());
        while($rsDsah->fetch()) {
            $bannerId = $rsDsah->get('ad_id');
            $zoneId = $rsDsah->get('zone_id');
            $day = $rsDsah->get('day');
            $hour = $rsDsah->get('hour');
            $this->assertEqual($mapCImpressions[$bannerId][$zoneId][$day][$hour], $rsDsah->get('impressions'));
            $this->assertEqual($mapCClicks[$bannerId][$zoneId][$day][$hour], $rsDsah->get('clicks'));
        }

    }


    function _insertRawStatsTestData($bannerId, $zoneId, $day, $hour, $mapCImpressions, $mapCClicks)
    {
        $this->_insertRawStatsRows($bannerId, $zoneId, $day, $hour, 'adviews', $mapCImpressions);
        $this->_insertRawStatsRows($bannerId, $zoneId, $day, $hour, 'adclicks', $mapCClicks);
    }


    function _insertRawStatsRows($bannerId, $zoneId, $day, $hour, $table, $mapCRows)
    {
        for ($idxRow = 0; $idxRow < $mapCRows[$bannerId][$zoneId][$day][$hour]; $idxRow++) {
            $minutes = mt_rand(0, 59);
            $seconds = mt_rand(0, 59);
            $timestamp = "$day $hour:$minutes:$seconds";
            $aValues = array(
                'bannerid' => $bannerId,
                'zoneid' => $zoneId,
                't_stamp' => $timestamp);
            $sql = OA_DB_Sql::sqlForInsert($table, $aValues);
            $this->oDbh->exec($sql);
        }
    }


    function testMigrateRawStats()
    {
        $oDbh = &$this->oDbh;
        $migration = new StatMigration();
        $migration->init($oDbh, MAX_PATH.'/var/DB_Upgrade.test.log');

        $cEntries = $this->prepareTestData($mapCImpressions, $mapCClicks, '_insertRawStatsTestData');

        $this->assertTrue($migration->migrateRawStats());

        $this->_checkDataTable('data_summary_ad_hourly', $cEntries, $mapCImpressions, $mapCClicks);
        $this->_checkDataTable('data_intermediate_ad', $cEntries, $mapCImpressions, $mapCClicks);
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