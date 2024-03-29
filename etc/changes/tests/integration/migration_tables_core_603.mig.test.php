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

require_once MAX_PATH . '/etc/changes/migration_tables_core_603.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * Test for migration class #540.
 *
 * @package    changes
 * @subpackage TestSuite
 */
class Migration_601Test extends MigrationTest
{
    public function setUp()
    {
        parent::setUp();
        $this->host = $_SERVER['HTTP_HOST'];
        $_SERVER['HTTP_HOST'] = 'test1';

        $GLOBALS['_MAX']['CONF']['webpath']['delivery'] = OX_getHostName();
        if (file_exists(MAX_PATH . '/var/' . OX_getHostName() . '.conf.php')) {
            unlink(MAX_PATH . '/var/' . OX_getHostName() . '.conf.php');
        }
        // Tests in this class need to use the "real" configuration
        // file writing method, not the one reserved for the test
        // environment...
        $GLOBALS['override_TEST_ENVIRONMENT_RUNNING'] = true;

        $this->createConfigIfNotExists();
    }

    public function tearDown()
    {
        if (file_exists(MAX_PATH . '/var/' . OX_getHostName() . '.conf.php')) {
            @unlink(MAX_PATH . '/var/' . OX_getHostName() . '.conf.php');
        }
        $_SERVER['HTTP_HOST'] = $this->host;

        // Resume normal service with regards to the configuration file writer...
        unset($GLOBALS['override_TEST_ENVIRONMENT_RUNNING']);

        TestEnv::restoreConfig();

        parent::tearDown();
    }

    public function testMigrate603()
    {
        $prefix = $this->getPrefix();
        $this->initDatabase(602, ['acls', 'acls_channel', 'banners']);

        $tblAcls = $this->oDbh->quoteIdentifier($prefix . 'acls', true);
        $tblAclsChannel = $this->oDbh->quoteIdentifier($prefix . 'acls_channel', true);
        $tblBanners = $this->oDbh->quoteIdentifier($prefix . 'banners', true);

        // Setup some ACL records, some fields which will be changed, some fields that won't be recognised and should therefore be left unchanged
        $this->oDbh->exec("INSERT INTO {$tblAcls} (bannerid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'Client:Browser', '==', 'test', 0)");
        $this->oDbh->exec("INSERT INTO {$tblAcls} (bannerid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'Site:Source', '==', 'test', 1)");
        $this->oDbh->exec("INSERT INTO {$tblAcls} (bannerid, logical, type, comparison, data, executionorder) VALUES (1, 'or', 'Geo:Country', '==', 'test', 2)");
        $this->oDbh->exec("INSERT INTO {$tblAcls} (bannerid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'Time:Day', '==', 'test', 3)");
        $this->oDbh->exec("INSERT INTO {$tblAcls} (bannerid, logical, type, comparison, data, executionorder) VALUES (1, 'or', 'Dummy:Dummy', '==', 'test', 4)");

        // Same entries for the acls_channel table
        $this->oDbh->exec("INSERT INTO {$tblAclsChannel} (channelid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'Client:Browser', '==', 'test', 0)");
        $this->oDbh->exec("INSERT INTO {$tblAclsChannel} (channelid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'Site:Source', '==', 'test', 1)");
        $this->oDbh->exec("INSERT INTO {$tblAclsChannel} (channelid, logical, type, comparison, data, executionorder) VALUES (1, 'or', 'Geo:Country', '==', 'test', 2)");
        $this->oDbh->exec("INSERT INTO {$tblAclsChannel} (channelid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'Time:Day', '==', 'test', 3)");
        $this->oDbh->exec("INSERT INTO {$tblAclsChannel} (channelid, logical, type, comparison, data, executionorder) VALUES (1, 'or', 'Dummy:Dummy', '==', 'test', 4)");

        // Some entries for the ext_bannertype migration too...
        $this->oDbh->exec("INSERT INTO {$tblBanners} (bannerid, storagetype) VALUES (1, 'html')");
        $this->oDbh->exec("INSERT INTO {$tblBanners} (bannerid, storagetype) VALUES (2, 'txt')");
        $this->oDbh->exec("INSERT INTO {$tblBanners} (bannerid, storagetype) VALUES (3, 'web')");
        $this->oDbh->exec("INSERT INTO {$tblBanners} (bannerid, storagetype) VALUES (4, 'sql')");

        // Setup some fake config items
        // Geotargeting
        $GLOBALS['_MAX']['CONF']['geotargeting']['type'] = 'GeoIP';
        $GLOBALS['_MAX']['CONF']['geotargeting']['geoipCountryLocation'] = '/path/to/geoipCountryLocation.dat';
        $GLOBALS['_MAX']['CONF']['geotargeting']['geoipRegionLocation'] = '/path/to/geoipRegionLocation.dat';
        $GLOBALS['_MAX']['CONF']['geotargeting']['geoipCityLocation'] = '/path/to/geoipCityLocation.dat';
        $GLOBALS['_MAX']['CONF']['geotargeting']['geoipAreaLocation'] = '/path/to/geoipAreaLocation.dat';
        $GLOBALS['_MAX']['CONF']['geotargeting']['geoipDmaLocation'] = '/path/to/geoipDmaLocation.dat';
        $GLOBALS['_MAX']['CONF']['geotargeting']['geoipOrgLocation'] = '/path/to/geoipOrgLocation.dat';
        $GLOBALS['_MAX']['CONF']['geotargeting']['geoipIspLocation'] = '/path/to/geoipIspLocation.dat';
        $GLOBALS['_MAX']['CONF']['geotargeting']['geoipNetspeedLocation'] = '/path/to/geoipNetspeedLocation.dat';

        $GLOBALS['_MAX']['CONF']['allowedTags']['adlayer'] = 'true';

        // Migrate!
        $this->upgradeToVersion(603);

        $aAcls = $this->oDbh->queryAll("SELECT bannerid, logical, type, comparison, data, executionorder FROM {$tblAcls} ORDER BY bannerid, executionorder");
        $aExpectedAcls = [
            ['bannerid' => 1, 'comparison' => '==', 'data' => 'test', 'executionorder' => 0, 'logical' => 'and', 'type' => 'deliveryLimitations:Client:Browser'],
            ['bannerid' => 1, 'comparison' => '==', 'data' => 'test', 'executionorder' => 1, 'logical' => 'and', 'type' => 'deliveryLimitations:Site:Source'],
            ['bannerid' => 1, 'comparison' => '==', 'data' => 'test', 'executionorder' => 2, 'logical' => 'or',  'type' => 'deliveryLimitations:Geo:Country'],
            ['bannerid' => 1, 'comparison' => '==', 'data' => 'test', 'executionorder' => 3, 'logical' => 'and', 'type' => 'deliveryLimitations:Time:Day'],
            ['bannerid' => 1, 'comparison' => '==', 'data' => 'test', 'executionorder' => 4, 'logical' => 'or',  'type' => 'Dummy:Dummy'],
        ];
        $this->assertEqual($aAcls, $aExpectedAcls);

        $aAclsChannel = $this->oDbh->queryAll("SELECT channelid, logical, type, comparison, data, executionorder FROM {$tblAclsChannel} ORDER BY channelid, executionorder");
        $aExpectedAclsChannel = [
            ['channelid' => 1, 'comparison' => '==', 'data' => 'test', 'executionorder' => 0, 'logical' => 'and', 'type' => 'deliveryLimitations:Client:Browser'],
            ['channelid' => 1, 'comparison' => '==', 'data' => 'test', 'executionorder' => 1, 'logical' => 'and', 'type' => 'deliveryLimitations:Site:Source'],
            ['channelid' => 1, 'comparison' => '==', 'data' => 'test', 'executionorder' => 2, 'logical' => 'or',  'type' => 'deliveryLimitations:Geo:Country'],
            ['channelid' => 1, 'comparison' => '==', 'data' => 'test', 'executionorder' => 3, 'logical' => 'and', 'type' => 'deliveryLimitations:Time:Day'],
            ['channelid' => 1, 'comparison' => '==', 'data' => 'test', 'executionorder' => 4, 'logical' => 'or',  'type' => 'Dummy:Dummy'],
        ];
        $this->assertEqual($aAclsChannel, $aExpectedAclsChannel);

        $aBanners = $this->oDbh->queryAll("SELECT bannerid, storagetype, ext_bannertype FROM {$tblBanners} ORDER BY bannerid");
        $aExpectedBanners = [
            ['bannerid' => 1, 'storagetype' => 'html', 'ext_bannertype' => 'bannerTypeHtml:oxHtml:genericHtml'],
            ['bannerid' => 2, 'storagetype' => 'txt',  'ext_bannertype' => 'bannerTypeText:oxText:genericText'],
            ['bannerid' => 3, 'storagetype' => 'web',  'ext_bannertype' => null],
            ['bannerid' => 4, 'storagetype' => 'sql',  'ext_bannertype' => null],
        ];
        $this->assertEqual($aBanners, $aExpectedBanners);

        $aConf = parse_ini_file(MAX_PATH . '/var/' . OX_getHostName() . '.conf.php', true);
        $oxMaxMindGeoIP = [
            'geoipCountryLocation' => '/path/to/geoipCountryLocation.dat',
            'geoipRegionLocation' => '/path/to/geoipRegionLocation.dat',
            'geoipCityLocation' => '/path/to/geoipCityLocation.dat',
            'geoipAreaLocation' => '/path/to/geoipAreaLocation.dat',
            'geoipDmaLocation' => '/path/to/geoipDmaLocation.dat',
            'geoipOrgLocation' => '/path/to/geoipOrgLocation.dat',
            'geoipIspLocation' => '/path/to/geoipIspLocation.dat',
            'geoipNetspeedLocation' => '/path/to/geoipNetspeedLocation.dat',
        ];

        $this->assertEqual($oxMaxMindGeoIP, $aConf['oxMaxMindGeoIP']);

        $this->assertEqual($aConf['geotargeting']['type'], 'geoTargeting:oxMaxMindGeoIP:oxMaxMindGeoIP');
    }
    /**
     * This method creates config if it doesn't exist so test won't fail
     *
     */
    public function createConfigIfNotExists()
    {
        if (!(file_exists(MAX_PATH . '/var/' . OX_getHostName() . '.conf.php'))) {
            $oConfig = new OA_Upgrade_Config();
            $oConfig->writeConfig(true);
        }
    }

    /**
     * Checks if $testArray exists in $section in global config file
     *
     * @param string $testSection
     * @param array $testArray
     */
    public function checkGlobalConfigConsists($testSection, $testArray)
    {
        $host = OX_getHostName();
        $configPath = MAX_PATH . "/var/$host.conf.php";
        if ($this->assertTrue(file_exists($configPath), "File: '$configPath' should exist!")) {
            $aContents = parse_ini_file($configPath, true);
            foreach ($testArray as $key => $val) {
                $this->assertEqual($aContents[$testSection][$key], $val);
            }
        }
    }
}
