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

require_once MAX_PATH . '/etc/changes/migration_tables_core_127.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';

/**
 * Test for migration class #127.
 *
 * @package    changes
 * @subpackage TestSuite
 */
class migration_tables_core_127Test extends MigrationTest
{
    public function testGetAdObjectIds()
    {
        $sIdHolders = "bannerid:3,bannerid:4,bannerid:5,bannerid:6";
        $aIdsExpected = [3, 4, 5, 6];
        $aIdsActual = OA_upgrade_getAdObjectIds($sIdHolders, 'bannerid');
        $this->assertEqual($aIdsExpected, $aIdsActual);

        $sIdHolders = "clientid:11";
        $aIdsExpected = [11];
        $aIdsActual = OA_upgrade_getAdObjectIds($sIdHolders, 'clientid');
        $this->assertEqual($aIdsExpected, $aIdsActual);

        $sIdHolders = "";
        $aIdsExpected = [];
        $aIdsActual = OA_upgrade_getAdObjectIds($sIdHolders, 'clientid');
        $this->assertEqual($aIdsExpected, $aIdsActual);
    }


    public function testMigrateData()
    {
        $prefix = $this->getPrefix();
        $this->initDatabase(126, ['zones', 'ad_zone_assoc', 'placement_zone_assoc', 'banners']);

        $aAValues = [
            ['zoneid' => 1, 'zonetype' => 0, 'what' => ''],
            ['zoneid' => 2, 'zonetype' => 0, 'what' => 'bannerid:3'],
            ['zoneid' => 3, 'zonetype' => 3, 'what' => 'clientid:3'],
            ['zoneid' => 4, 'zonetype' => 3, 'what' => 'clientid:5', 'delivery' => phpAds_ZoneText],
            ['zoneid' => 5, 'zonetype' => 3, 'what' => 'clientid:5', 'delivery' => phpAds_ZoneBanner, 'width' => 468, 'height' => 60],
            ['zoneid' => 6, 'zonetype' => 0, 'what' => 'bannerid:2,bannerid:3'],
            ['zoneid' => 7, 'zonetype' => 3, 'what' => 'clientid:3,clientid:4'],
            ['zoneid' => 8, 'zonetype' => 0, 'what' => 'bannerid:2,bannerid:3,bannerid:4,bannerid:5'],
            ['zoneid' => 9, 'zonetype' => 3, 'what' => 'clientid:,clientid:3'],
        ];
        foreach ($aAValues as $aValues) {
            // Set empty defaults for NOT NULL fields
            $aValues['chain'] = $aValues['prepend'] = $aValues['append'] = '';
            $sql = OA_DB_Sql::sqlForInsert('zones', $aValues);
            $this->oDbh->exec($sql);
        }

        $aABannerValues = [
            ['bannerid' => 1, 'campaignid' => 3],
            ['bannerid' => 2, 'campaignid' => 3],
            ['bannerid' => 3, 'campaignid' => 4],
            ['bannerid' => 4, 'campaignid' => 4],
            ['bannerid' => 5, 'campaignid' => 5, 'storagetype' => 'txt'],
            ['bannerid' => 6, 'campaignid' => 5, 'storagetype' => 'sql', 'width' => 468, 'height' => 60],
            ['bannerid' => 7, 'campaignid' => 5, 'storagetype' => 'sql', 'width' => 125, 'height' => 125],
        ];
        foreach ($aABannerValues as $aBannerValues) {
            // Set empty defaults for NOT NULL fields
            $aBannerValues['htmltemplate'] = $aBannerValues['htmlcache'] = $aBannerValues['bannertext'] =
                $aBannerValues['compiledlimitation'] = $aBannerValues['append'] = '';
            $sql = OA_DB_Sql::sqlForInsert('banners', $aBannerValues);
            $this->oDbh->exec($sql);
        }

        $this->upgradeToVersion(127);

        $aAssocTables = [
            "{$prefix}ad_zone_assoc WHERE link_type = 1" => 17,
            "{$prefix}ad_zone_assoc WHERE link_type = 0" => 7,
            "{$prefix}placement_zone_assoc" => 6];
        foreach ($aAssocTables as $assocTable => $cAssocs) {
            $rsCAssocs = DBC::NewRecordSet("SELECT count(*) AS cassocs FROM $assocTable");
            $this->assertTrue($rsCAssocs->find());
            $this->assertTrue($rsCAssocs->fetch());
            $this->assertEqual($cAssocs, $rsCAssocs->get('cassocs'), "%s: The table involved: $assocTable");
        }
    }
}
