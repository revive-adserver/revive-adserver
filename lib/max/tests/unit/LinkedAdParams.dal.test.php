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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/lib/max/other/common.php';

class Test_Admin_DA_LinkedAdParams extends UnitTestCase
{
    private function createRecord($table, $fields)
    {
        $do = OA_Dal::factoryDO($table);
        foreach ($fields as $key => $value) {
            $do->$key = $value;
        }
        $id = DataGenerator::generateOne($do, true);
        return OA_Dal::staticGetDO($table, $id);
    }

    public function tearDown()
    {
        DataGenerator::cleanUp(['ad_zone_assoc', 'placement_zone_assoc']);
    }

    public function testAgencyAndBannerRestrictions()
    {
        $ownAgency = $this->createRecord('agency', []);
        $foreignAgency = $this->createRecord('agency', []);
        $publisher = $this->createRecord('affiliates', ['agencyid' => $ownAgency->agencyid]);
        $campaigns = [];
        $bannerIds = [];
        $fixtures = [
            ['web', 468, 60], ['sql', 468, 60], ['url', 468, 60], ['html', 468, 60], ['txt', 468, 60],
            ['web', 300, 250], ['html', -1, -1], ['txt', -1, -1], ['web', 300, 60], ['web', 468, 250],
        ];
        foreach ([$ownAgency, $foreignAgency] as $i => $agency) {
            $client = $this->createRecord('clients', ['agencyid' => $agency->agencyid]);
            $campaign = $this->createRecord('campaigns', ['clientid' => $client->clientid, 'activate_time' => '2026-01-01 00:00:00', 'expire_time' => '2027-01-01 00:00:00']);
            $campaigns[$i] = [$client, $campaign];
            foreach ($fixtures as $j => [$type, $width, $height]) {
                $banner = $this->createRecord('banners', ['campaignid' => $campaign->campaignid, 'storagetype' => $type, 'contenttype' => 'gif', 'width' => $width, 'height' => $height]);
                $bannerIds[$i][$j] = $banner->bannerid;
            }
        }
        $matrix = [
            [phpAds_ZoneBanner, 468, 60, [0, 1, 2, 3, 6]],
            [phpAds_ZoneBanner, -1, 60, [0, 1, 2, 3, 6, 8]],
            [phpAds_ZoneBanner, 468, -1, [0, 1, 2, 3, 6, 9]],
            [phpAds_ZoneBanner, -1, -1, [0, 1, 2, 3, 5, 6, 8, 9]],
            [phpAds_ZoneText, 468, 60, [4, 7]],
            [MAX_ZoneEmail, 468, 60, [0, 1, 2]],
        ];
        foreach ($matrix as [$type, $width, $height, $allowed]) {
            $zone = $this->createRecord('zones', ['affiliateid' => $publisher->affiliateid, 'delivery' => $type, 'width' => $width, 'height' => $height]);
            $params = MAX_getLinkedAdParams($zone->zoneid);
            $this->assertIdentical(Admin_DA::getLinkedAdParams($zone->zoneid), $params, 'Both public entry points use identical restrictions');
            $this->assertEqual($params['agency_id'], $ownAgency->agencyid);
            $this->assertEqual(Admin_DA::getPlacements($params + ['advertiser_id' => $campaigns[1][0]->clientid]), []);
            $this->assertEqual(Admin_DA::getAds($params + ['placement_id' => $campaigns[1][1]->campaignid]), []);
            $this->assertTrue(isset(Admin_DA::getPlacements($params + ['advertiser_id' => $campaigns[0][0]->clientid])[$campaigns[0][1]->campaignid]), 'Own-agency campaigns remain selectable');
            $ads = Admin_DA::getAds($params + ['placement_id' => $campaigns[0][1]->campaignid]);
            $expected = array_map(static fn($j) => $bannerIds[0][$j], $allowed);
            $actual = array_keys($ads);
            sort($actual);
            sort($expected);
            $this->assertEqual($actual, $expected, 'Expected size and banner type selection');
            Admin_DA::addPlacementZone(['zone_id' => $zone->zoneid, 'placement_id' => $campaigns[0][1]->campaignid]);
            $linked = array_keys(Admin_DA::getAdZones(['zone_id' => $zone->zoneid], false, 'ad_id'));
            sort($linked);
            $this->assertEqual($linked, $expected, 'Campaign auto-link matches dropdown selection');
            $this->assertTrue(MAX_addLinkedAdsToZone($zone->zoneid, $campaigns[0][1]->campaignid));
            foreach (array_diff(array_keys($fixtures), $allowed) as $j) {
                $this->assertTrue(PEAR::isError(Admin_DA::addAdZone(['zone_id' => $zone->zoneid, 'ad_id' => $bannerIds[0][$j]])), 'Invalid size/type direct links remain rejected');
            }
            $this->assertTrue(PEAR::isError(Admin_DA::addAdZone(['zone_id' => $zone->zoneid, 'ad_id' => $bannerIds[1][0]])), 'Foreign direct links rejected');
        }
        $this->assertEqual(Admin_DA::getLinkedAdParams(99999999), []);
        $this->assertEqual(MAX_getLinkedAdParams(99999999), []);
    }
}
