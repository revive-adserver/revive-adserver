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

require_once MAX_PATH . '/etc/changes/migration_tables_core_108.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Upgrade/Configuration.php';
require_once MAX_PATH . '/lib/util/file/file.php';

define('TMP_GEOCONFIG_PATH', GEOCONFIG_PATH . '.tmp');

/**
 * Test for migration class #108.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openx.org>
 */
class Migration_tables_core_108Test extends MigrationTest
{
    function testMigrateData()
    {
        $prefix = $this->getPrefix();
        $this->initDatabase(108, array('config', 'preference'));

        $this->setupPanConfig();

        $migration = new Migration_108();
        $migration->init($this->oDbh, MAX_PATH.'/var/DB_Upgrade.test.log');

        $aValues = array(
            'gui_show_parents'   => 't',
            'updates_enabled'    => 'f',
            'client_welcome_msg' => '',
            'updates_cache'      => ''
        );
        $sql = OA_DB_Sql::sqlForInsert('config', $aValues);
        $this->oDbh->exec($sql);

        $aValues += array(
            'warn_admin' => 't',
            'warn_limit' => '100'
        );

        $migration->migrateData();
        $table = $this->oDbh->quoteIdentifier($prefix.'preference',true);

        $rsPreference = DBC::NewRecordSet("SELECT * from {$table}");
        $rsPreference->find();
        $this->assertTrue($rsPreference->fetch());
        $aDataPreference = $rsPreference->toArray();
        foreach($aValues as $column => $value) {
            $this->assertEqual($value, $aDataPreference[$column]);
        }

        $this->restorePanConfig();
    }


    function testCreateGeoTargetingConfiguration()
    {
        if (file_exists(GEOCONFIG_PATH)) {
            rename(GEOCONFIG_PATH, TMP_GEOCONFIG_PATH);
        }

        $upgradeConfig = new OA_Upgrade_Config();
        $host = getHostName();

        $migration = new Migration_108();
        $migration->init($this->oDbh, MAX_PATH.'/var/DB_Upgrade.test.log');

        $this->checkNoGeoTargeting($migration, $host);
        $this->checkGeoIp($migration, $host);
        $this->checkModGeoIP($migration, $host);

        Util_File_remove(GEOCONFIG_PATH);

        if (file_exists(TMP_GEOCONFIG_PATH)) {
            rename(TMP_GEOCONFIG_PATH, GEOCONFIG_PATH);
        }
    }

    /**
     * @param Migration_108 $migration
     * @param string $host
     */
    function checkNoGeoTargeting(&$migration, $host)
    {
        $geotracking_type = '';
        $geotracking_location = '';
        $geotracking_stats = false;
        $geotracking_conf = '';
        $this->assertTrue($migration->createGeoTargetingConfiguration(
            $geotracking_type, $geotracking_location, $geotracking_stats, $geotracking_conf));
        $this->checkGeoPluginConfig('"none"', $geotracking_stats, '', $host);
    }


    function checkGeoIp(&$migration, $host)
    {
        $geotracking_type = 'geoip';
        $geotracking_location = MAX_PATH . '/tests/data/FreeGeoIPCountry.dat';
        $geotracking_stats = true;
        $geotracking_conf = '';

        $this->assertTrue($migration->createGeoTargetingConfiguration(
            $geotracking_type, $geotracking_location, $geotracking_stats, $geotracking_conf));

        $configContent = "[geotargeting]\ntype=GeoIP\ngeoipCountryLocation={$geotracking_location}\n";
        $this->checkGeoPluginConfig('GeoIP', $geotracking_stats, $configContent, $host);
    }


    function checkGeoIpWrongPath(&$migration, $host)
    {
        $geotracking_type = 'geoip';
        $geotracking_location = MAX_PATH . '/plugins/geotargeting/foo.dat';
        $geotracking_stats = true;
        $geotracking_conf = '';

        $this->assertTrue($migration->createGeoTargetingConfiguration(
            $geotracking_type, $geotracking_location, $geotracking_stats, $geotracking_conf));

        $this->checkGeoPluginConfig('"none"', $geotracking_stats, '', $host);
    }


    function checkGeoIpIp2Country(&$migration, $host)
    {
        $geotracking_type = 'ip2country';
        $geotracking_location = MAX_PATH . '/plugins/geotargeting/foo.dat';
        $geotracking_stats = true;
        $geotracking_conf = '';

        $this->assertTrue($migration->createGeoTargetingConfiguration(
            $geotracking_type, $geotracking_location, $geotracking_stats, $geotracking_conf));

        $this->checkGeoPluginConfig('"none"', $geotracking_stats, '', $host);
    }


    function checkModGeoIP(&$migration, $host)
    {
        $geotracking_type = 'mod_geoip';
        $geotracking_location = '';
        $geotracking_stats = false;
        $geotracking_conf = '';

        $this->assertTrue($migration->createGeoTargetingConfiguration(
            $geotracking_type, $geotracking_location, $geotracking_stats, $geotracking_conf));

        $this->checkGeoPluginConfig('ModGeoIP', $geotracking_stats, "[geotargeting]\ntype=ModGeoIP\n", $host);
    }


    function checkGeoPluginConfig($type, $geotracking_stats, $configContent = '', $host)
    {
        $saveStats = $geotracking_stats ? 'true' : 'false';
        $pluginConfigPath = MAX_PATH . "/var/plugins/config/geotargeting/$host.plugin.conf.php";
        $pluginConfigContents = "[geotargeting]\ntype=$type\nsaveStats=$saveStats\nshowUnavailable=false";
        $this->checkFileContents($pluginConfigPath, $pluginConfigContents);

        if (!empty($configContent)) {
            $configPath = MAX_PATH . "/var/plugins/config/geotargeting/$type/$host.plugin.conf.php";
            $this->checkFileContents($configPath, $configContent);
        }
    }

    function checkFileContents($filename, $contents)
    {
        if ($this->assertTrue(file_exists($filename), "File: '$filename' should exist!")) {
            $actualContents = file_get_contents($filename);
            $this->assertEqual($contents, $actualContents);
        }
    }

}
