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

require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Upgrade/Upgrade.php';

/**
 * 5.0.0-beta-rc1 upgrade test
 *
 * @package    OpenX Upgrade
 * @subpackage TestSuite
 */
class Test_postscript_5_0_0_beta_rc1 extends MigrationTest
{
    public function test_DatabaseMigration()
    {
        $prefix = $this->getPrefix();
        $this->initDatabase(623, ['acls', 'acls_channel']);

        $tblAcls = $this->oDbh->quoteIdentifier($prefix . 'acls', true);
        $tblAclsChannel = $this->oDbh->quoteIdentifier($prefix . 'acls_channel', true);

        $this->oDbh->exec("INSERT INTO {$tblAcls} (bannerid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'deliveryLimitations:Client:Browser', '==', 'test', 0)");
        $this->oDbh->exec("INSERT INTO {$tblAcls} (bannerid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'deliveryLimitations:Geo:Areacode', '==', 'test', 1)");
        $this->oDbh->exec("INSERT INTO {$tblAcls} (bannerid, logical, type, comparison, data, executionorder) VALUES (1, 'or', 'deliveryLimitations:Geo:Region', '==', 'IT|10,05', 2)");
        $this->oDbh->exec("INSERT INTO {$tblAcls} (bannerid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'deliveryLimitations:Site:Source', '==', 'test', 3)");
        $this->oDbh->exec("INSERT INTO {$tblAcls} (bannerid, logical, type, comparison, data, executionorder) VALUES (2, 'and', 'deliveryLimitations:Geo:Netspeed', '==', '1', 0)");
        $this->oDbh->exec("INSERT INTO {$tblAcls} (bannerid, logical, type, comparison, data, executionorder) VALUES (3, 'and', 'deliveryLimitations:Client:Browser', '==', 'test', 0)");
        $this->oDbh->exec("INSERT INTO {$tblAcls} (bannerid, logical, type, comparison, data, executionorder) VALUES (3, 'or', 'deliveryLimitations:Geo:Areacode', '==', 'test', 1)");
        $this->oDbh->exec("INSERT INTO {$tblAcls} (bannerid, logical, type, comparison, data, executionorder) VALUES (3, 'and', 'deliveryLimitations:Geo:Country', '==', 'IT', 2)");

        $this->oDbh->exec("INSERT INTO {$tblAclsChannel} (channelid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'deliveryLimitations:Client:Browser', '==', 'test', 0)");
        $this->oDbh->exec("INSERT INTO {$tblAclsChannel} (channelid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'deliveryLimitations:Geo:Region', '==', 'TW|01', 1)");
        $this->oDbh->exec("INSERT INTO {$tblAclsChannel} (channelid, logical, type, comparison, data, executionorder) VALUES (1, 'or', 'deliveryLimitations:Geo:Dma', '==', 'test', 2)");

        $oUpgrade = new OA_Upgrade();
        $oUpgrade->initDatabaseConnection();
        $this->assertTrue($oUpgrade->runScript('postscript_openads_upgrade_5.0.0-beta-rc1.php'));

        $this->assertEqual(
            $this->oDbh->queryAll("SELECT * FROM {$tblAcls} ORDER BY bannerid, executionorder"),
            $this->getAcls(),
        );

        $this->assertEqual(
            $this->oDbh->queryAll("SELECT * FROM {$tblAclsChannel} ORDER BY channelid, executionorder"),
            $this->getChannelAcls(),
        );
    }

    public function test_configMigration()
    {
        $migration = new RV_UpgradePostscript_5_0_0_beta_rc1();
        $migration->oUpgrade = new OA_Upgrade();

        $method = new \ReflectionMethod('RV_UpgradePostscript_5_0_0_beta_rc1', 'migrateConfiguration');

        // No geotargeting type change
        $GLOBALS['_MAX']['CONF']['geotargeting']['type'] = 'foo:bar';
        $method->invoke($migration);
        $this->assertEqual($GLOBALS['_MAX']['CONF']['geotargeting']['type'], 'foo:bar');

        // Geotargeting type changed if GeoIP
        $GLOBALS['_MAX']['CONF']['geotargeting']['type'] = 'geoTargeting:oxMaxMindGeoIP:oxMaxMindGeoIP';
        $method->invoke($migration);
        $this->assertEqual($GLOBALS['_MAX']['CONF']['geotargeting']['type'], 'geoTargeting:rvMaxMindGeoIP2:rvMaxMindGeoIP2');

        // Geotargeting type changed if ModGeoIP
        $GLOBALS['_MAX']['CONF']['geotargeting']['type'] = 'geoTargeting:oxMaxMindModGeoIP:oxMaxMindModGeoIP';
        $method->invoke($migration);
        $this->assertEqual($GLOBALS['_MAX']['CONF']['geotargeting']['type'], 'geoTargeting:rvMaxMindGeoIP2:rvMaxMindGeoIP2');

        // Check old plugin settings being removed
        $GLOBALS['_MAX']['CONF']['oxMaxMindGeoIP'] = ['foo' => 'bar'];
        $method->invoke($migration);
        $this->assertFalse(isset($GLOBALS['_MAX']['CONF']['oxMaxMindGeoIP']));
    }

    private function getAcls()
    {
        return [
            [
                'bannerid' => '1',
                'logical' => 'and',
                'type' => 'deliveryLimitations:Client:Browser',
                'comparison' => '==',
                'data' => 'test',
                'executionorder' => '0',
            ],
            [
                'bannerid' => '1',
                'logical' => 'and',
                'type' => 'deliveryLimitations:Geo:Subdivision1',
                'comparison' => '==',
                'data' => 'IT|45,57',
                'executionorder' => '1',
            ],
            [
                'bannerid' => '1',
                'logical' => 'and',
                'type' => 'deliveryLimitations:Site:Source',
                'comparison' => '==',
                'data' => 'test',
                'executionorder' => '2',
            ],
            [
                'bannerid' => '2',
                'logical' => 'and',
                'type' => 'deliveryLimitations:Geo:ConnectionType',
                'comparison' => '==',
                'data' => '1',
                'executionorder' => '0',
            ],
            [
                'bannerid' => '3',
                'logical' => 'and',
                'type' => 'deliveryLimitations:Client:Browser',
                'comparison' => '==',
                'data' => 'test',
                'executionorder' => '0',
            ],
            [
                'bannerid' => '3',
                'logical' => 'and',
                'type' => 'deliveryLimitations:Geo:Country',
                'comparison' => '==',
                'data' => 'IT',
                'executionorder' => '1',
            ],
        ];
    }

    private function getChannelAcls()
    {
        return [
            [
                'channelid' => '1',
                'logical' => 'and',
                'type' => 'deliveryLimitations:Client:Browser',
                'comparison' => '==',
                'data' => 'test',
                'executionorder' => '0',
            ],
            [
                'channelid' => '1',
                'logical' => 'and',
                'type' => 'deliveryLimitations:Geo:Subdivision1',
                'comparison' => '==',
                'data' => 'CN|FJ',
                'executionorder' => '1',
            ],
            [
                'channelid' => '1',
                'logical' => 'or',
                'type' => 'deliveryLimitations:Geo:UsMetro',
                'comparison' => '==',
                'data' => 'test',
                'executionorder' => '2',
            ],
        ];
    }
}
