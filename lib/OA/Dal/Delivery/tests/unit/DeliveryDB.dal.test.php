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

require_once MAX_PATH . '/lib/max/Dal/Delivery.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';
require_once MAX_PATH . '/lib/pear/DB/DataObject/Cast.php';
require_once 'Log.php';

// pgsql execution time before refactor: 132.33s
// pgsql execution time after refactor: 20.217s

/**
 * A class for testing the Delivery Engine DAL class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 *
 * This method combines and replaces the previously separate mysql and pgsql tests
 */
class Test_OA_Dal_DeliveryDB extends UnitTestCase
{
    public $oDbh;
    public $prefix;
    public $aIds;

    public function __construct()
    {
        parent::__construct();
        $this->oDbh = OA_DB::singleton();
        $this->prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $this->aIds = TestEnv::loadData('delivery_001', 'mdb2schema');

        // Disable caching
        $GLOBALS['OA_Delivery_Cache']['expiry'] = -1;

        MAX_Dal_Delivery_Include();
    }

    /**
     * A private method to close delivery connection after tests are run
     *
     */
    public function _testCloseConnection()
    {
        if ($this->oDbh->dbsyntax == 'pgsql') {
            if (!empty($GLOBALS['_MAX']['ADMIN_DB_LINK'])) {
                pg_close($GLOBALS['_MAX']['ADMIN_DB_LINK']);
                unset($GLOBALS['_MAX']['ADMIN_DB_LINK']);
            }
        }
    }

    /**
     * establish a singleton connection to the database
     *
     */
    public function test_OA_Dal_Delivery_connect()
    {
        $GLOBALS['_MAX']['ADMIN_DB_LINK'] = OA_Dal_Delivery_connect();
        $this->assertNoErrors('test_OA_Dal_Delivery_query');
        if ($GLOBALS['_MAX']['CONF']['database']['type'] == 'mysqli') {
            $this->assertTrue($GLOBALS['_MAX']['ADMIN_DB_LINK'] instanceof mysqli);
        } else {
            // PHP 8.1+
            $this->assertTrue($GLOBALS['_MAX']['ADMIN_DB_LINK'] instanceof PgSql\Connection);
        }
    }

    /**
     * executes a sql query
     *
     */
    public function test_OA_Dal_Delivery_query()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $res = OA_Dal_Delivery_query("SELECT * FROM " . $this->_getTableName('banners') . " limit 1");
        $this->assertTrue($res);
        $row = OA_Dal_Delivery_fetchAssoc($res);
        $this->assertTrue($row);
        $this->assertNoErrors('test_OA_Dal_Delivery_query');
    }

    public function _getTableName($table)
    {
        return $this->oDbh->quoteIdentifier($this->prefix . $table, true);
    }

    /**
     * returns an array of properties for a zone
     *
     */
    public function test_OA_Dal_Delivery_getZoneInfo()
    {
        $zoneid = $this->aIds['zones'][61];
        $aReturn = OA_Dal_Delivery_getZoneInfo($zoneid);
        //$prn        = var_export($aReturn, TRUE);
        $this->assertIsA($aReturn, 'array');
        $this->assertEqual($zoneid, $aReturn['zone_id']);
    }

    /**
     * return an array of zone properties and arrays of linked ads for a given zone
     *
     */
    public function test_OA_Dal_Delivery_getZoneLinkedAds()
    {
        $zoneid = $this->aIds['zones'][61];
        $aReturn = OA_Dal_Delivery_getZoneLinkedAds($zoneid);

        $this->assertIsA($aReturn, 'array');
        $this->assertEqual($zoneid, $aReturn['zone_id']);
        $this->assertEqual($aReturn['default_banner_image_url'], "http://www.openx.org/themes/openx/images/header_logo.png");
        $this->assertEqual($aReturn['default_banner_destination_url'], "http://www.openx.org/");
        $this->assertIsA($aReturn['xAds'], 'array');
        $this->assertIsA($aReturn['ads'], 'array');
        $this->assertIsA($aReturn['lAds'], 'array');
        $this->assertIsA($aReturn['count_active'], 'integer');
        $this->assertIsA($aReturn['zone_companion'], 'boolean');
        $this->assertIsA($aReturn['priority'], 'array');
        $this->assertIsA($aReturn['priority']['xAds'], 'integer');
        $this->assertIsA($aReturn['priority']['ads'], 'array');
        $this->assertIsA($aReturn['priority']['lAds'], 'integer');
    }

    /**
     * return an array of zone properties and arrays of linked ads for a given zone
     *
     */
    public function test_OA_Dal_Delivery_getZoneLinkedAdInfos()
    {
        $zoneid = $this->aIds['zones'][61];
        $aReturn = OA_Dal_Delivery_getZoneLinkedAdInfos($zoneid);

        $this->assertIsA($aReturn, 'array');
        $this->assertIsA($aReturn['xAds'], 'array');
        $this->assertIsA($aReturn['ads'], 'array');
        $this->assertIsA($aReturn['lAds'], 'array');
        $this->assertIsA($aReturn['count_active'], 'integer');
        $this->assertIsA($aReturn['zone_companion'], 'boolean');

        // Test for bug #352 (pgsql regex returns 't'/'f')
        $this->assertTrue(empty($aReturn['xAds'][227]['html_ssl_unsafe']));
        $this->assertTrue(empty($aReturn['xAds'][227]['url_ssl_unsafe']));
    }

    /**
     * @todo needs more test cases
     *
     * return an array of ads that match a given search term
     *
     */
    public function test_OA_Dal_Delivery_getLinkedAds()
    {
        $placementid = $this->aIds['campaigns'][1];
        $search = 'campaignid:' . $placementid;
        $aReturn = OA_Dal_Delivery_getLinkedAds($search);
        //$prn        = var_export($aReturn, TRUE);
        $this->assertIsA($aReturn, 'array');
        //$this->assertEqual($aReturn['count_active'], 2); // php/mysql 4 vs 5 issues
        foreach ($aReturn['lAds'] as $k => $v) {
            $this->assertEqual($v['placement_id'], $placementid);
        }

        $width = 468;
        $height = 60;
        $search = "{$width}x{$height}";
        $aReturn = OA_Dal_Delivery_getLinkedAds($search);
        $this->assertIsA($aReturn, 'array');
        //$this->assertEqual($aReturn['count_active'], 122); // php/mysql 4 vs 5 issues
        foreach ($aReturn['xAds'] as $k => $v) {
            $this->assertEqual($v['width'], $width);
            $this->assertEqual($v['height'], $height);
        }
        foreach ($aReturn['lAds'] as $k => $v) {
            $this->assertEqual($v['width'], $width);
            $this->assertEqual($v['height'], $height);
        }
        foreach ($aReturn['ads'] as $kcp => $vcp) {
            foreach ($vcp as $k => $v) {
                $this->assertEqual($v['width'], $width);
                $this->assertEqual($v['height'], $height);
            }
        }

        // This test doesn't return anything because search paths are supported at adSelect level
        $search = 'foo/bar';
        $aReturn = OA_Dal_Delivery_getLinkedAds($search);
        $this->assertIsA($aReturn, 'array');
        $this->assertEqual($aReturn['count_active'], 0);

        $search = 'foo';
        $aReturn = OA_Dal_Delivery_getLinkedAds($search);
        $this->assertIsA($aReturn, 'array');
        $this->assertEqual($aReturn['count_active'], 1);

        $search = 'foo,+bar';
        $aReturn = OA_Dal_Delivery_getLinkedAds($search);
        $this->assertIsA($aReturn, 'array');
        $this->assertEqual($aReturn['count_active'], 1);

        $search = 'foo,+baz';
        $aReturn = OA_Dal_Delivery_getLinkedAds($search);
        $this->assertIsA($aReturn, 'array');
        $this->assertEqual($aReturn['count_active'], 0);

        $search = 'html';
        $aReturn = OA_Dal_Delivery_getLinkedAds($search);
        $this->assertIsA($aReturn, 'array');
        //$this->assertEqual($aReturn['count_active'], 38); // php/mysql 4 vs 5 issues

        $search = 'textad';
        $aReturn = OA_Dal_Delivery_getLinkedAds($search);
        $this->assertIsA($aReturn, 'array');
        $this->assertEqual($aReturn['count_active'], 17);
    }

    /**
     * get an ad array formatted for render given an ad id
     *
     */
    public function test_OA_Dal_Delivery_getAd()
    {
        $ad_id = $this->aIds['banners'][1];
        $aReturn = OA_Dal_Delivery_getAd($ad_id);
        $this->assertIsA($aReturn, 'array');
        $this->assertEqual($aReturn['ad_id'], $ad_id);
    }

    /**
     * get the plugins required and compiled limitations string for a given channel id
     *
     */
    public function test_OA_Dal_Delivery_getChannelLimitations()
    {
        $channelid = $this->aIds['channel'][1];
        $aReturn = OA_Dal_Delivery_getChannelLimitations($channelid);
        //$prn        = var_export($aReturn, TRUE);
        $this->assertIsA($aReturn['acl_plugins'], 'string');
        $this->assertEqual($aReturn['compiledlimitation'], 'true');
    }

    /**
     * get SQL-stored creative
     **/
    public function test_OA_Dal_Delivery_getCreative()
    {
        // The images table is empty as there are problems with
        $filename = 'adOneTwoOneID.gif';
        $contents = "foobar\001\xFF";

        $doImage = OA_Dal::factoryDO('images');
        $doImage->filename = $filename;
        $doImage->contents = DB_DataObject_Cast::blob($contents);
        $doImage->insert();

        $aReturn = OA_Dal_Delivery_getCreative($filename);

        $this->assertIsA($aReturn, 'array');
        $this->assertEqual($aReturn['contents'], $contents);
    }

    /**
     * get tracker details
     *
     */
    public function test_OA_Dal_Delivery_getTracker()
    {
        $trackerid = $this->aIds['trackers'][1];
        $aReturn = OA_Dal_Delivery_getTracker($trackerid);
        $this->assertEqual($aReturn['advertiser_id'], 1);
        $this->assertEqual($aReturn['tracker_id'], 1);
        $this->assertEqual($aReturn['name'], 'Tracker 1');
        $this->assertEqual($aReturn['variablemethod'], 'js');
        $this->assertEqual($aReturn['description'], 'Tracker 1');
        $this->assertEqual($aReturn['viewwindow'], 3600);
        $this->assertEqual($aReturn['clickwindow'], 3600);
        $this->assertEqual($aReturn['blockwindow'], 3600);
        $this->assertEqual($aReturn['appendcode'], '');
    }

    /**
     * @todo need better test case
     *
     * get tracker variables
     *
     */
    public function test_OA_Dal_Delivery_getTrackerVariables()
    {
        $trackerid = 1;
        $aReturn = OA_Dal_Delivery_getTrackerVariables($trackerid);
        $this->assertEqual(count($aReturn), 2);
    }

    /**
     * proper low/override prioritisation with campaign weight coming first
     *
     */
    public function test_setPriorityFromWeights()
    {
        $aAds = [];
        $this->assertFalse(_setPriorityFromWeights($aAds));

        $aAds = [
            [
                'placement_id' => 1,
                'weight' => 0,
                'campaign_weight' => 1,
            ],
        ];
        $this->assertFalse(_setPriorityFromWeights($aAds));

        $aAds = [
            [
                'placement_id' => 1,
                'weight' => 1,
                'campaign_weight' => 0,
            ],
        ];
        $this->assertFalse(_setPriorityFromWeights($aAds));

        $aAds = [
            [
                'placement_id' => 1,
                'weight' => 1,
                'campaign_weight' => 1,
            ],
        ];
        $this->assertTrue(_setPriorityFromWeights($aAds));
        $this->assertEqual($aAds[0]['priority'], 1);

        $aAds = [
            [
                'placement_id' => 1,
                'weight' => 1,
                'campaign_weight' => 1,
            ],
            [
                'placement_id' => 1,
                'weight' => 1,
                'campaign_weight' => 1,
            ],
        ];
        $this->assertTrue(_setPriorityFromWeights($aAds));
        $this->assertEqual($aAds[0]['priority'], 0.5);
        $this->assertEqual($aAds[1]['priority'], 0.5);

        $aAds = [
            [
                'placement_id' => 1,
                'weight' => 1,
                'campaign_weight' => 1,
            ],
            [
                'placement_id' => 1,
                'weight' => 1,
                'campaign_weight' => 1,
            ],
            [
                'placement_id' => 2,
                'weight' => 2,
                'campaign_weight' => 1,
            ],
        ];
        $this->assertTrue(_setPriorityFromWeights($aAds));
        $this->assertEqual($aAds[0]['priority'], 0.25);
        $this->assertEqual($aAds[1]['priority'], 0.25);
        $this->assertEqual($aAds[2]['priority'], 0.5);

        $aAds = [
            [
                'placement_id' => 1,
                'weight' => 1,
                'campaign_weight' => 1,
            ],
            [
                'placement_id' => 1,
                'weight' => 4,
                'campaign_weight' => 1,
            ],
            [
                'placement_id' => 2,
                'weight' => 2,
                'campaign_weight' => 1,
            ],
        ];
        $this->assertTrue(_setPriorityFromWeights($aAds));
        $this->assertEqual($aAds[0]['priority'], 0.1);
        $this->assertEqual($aAds[1]['priority'], 0.4);
        $this->assertEqual($aAds[2]['priority'], 0.5);

        $aAds = [
            [
                'placement_id' => 1,
                'weight' => 12,
                'campaign_weight' => 1,
            ],
            [
                'placement_id' => 1,
                'weight' => 13,
                'campaign_weight' => 1,
            ],
            [
                'placement_id' => 2,
                'weight' => 2,
                'campaign_weight' => 3,
            ],
        ];
        $this->assertTrue(_setPriorityFromWeights($aAds));
        $this->assertEqual($aAds[0]['priority'], 0.12);
        $this->assertEqual($aAds[1]['priority'], 0.13);
        $this->assertEqual($aAds[2]['priority'], 0.75);

        $aAds = [
            [
                'placement_id' => 1,
                'weight' => 1,
                'campaign_weight' => 1,
            ],
            [
                'placement_id' => 1,
                'weight' => 0,
                'campaign_weight' => 1,
            ],
            [
                'placement_id' => 2,
                'weight' => 2,
                'campaign_weight' => 1,
            ],
        ];
        $this->assertTrue(_setPriorityFromWeights($aAds));
        $this->assertEqual($aAds[0]['priority'], 0.5);
        $this->assertEqual($aAds[1]['priority'], 0);
        $this->assertEqual($aAds[2]['priority'], 0.5);

        $aAds = [
            [
                'placement_id' => 1,
                'weight' => 1,
                'campaign_weight' => 1,
            ],
            [
                'placement_id' => 1,
                'weight' => 4,
                'campaign_weight' => 1,
            ],
            [
                'placement_id' => 2,
                'weight' => 2,
                'campaign_weight' => 0,
            ],
        ];
        $this->assertTrue(_setPriorityFromWeights($aAds));
        $this->assertEqual($aAds[0]['priority'], 0.2);
        $this->assertEqual($aAds[1]['priority'], 0.8);
        $this->assertEqual($aAds[2]['priority'], 0);

        $aAds = [
            [
                'placement_id' => 1,
                'weight' => 1,
                'campaign_weight' => 1,
            ],
            [
                'placement_id' => 1,
                'weight' => 4,
                'campaign_weight' => 1,
            ],
            [
                'placement_id' => 2,
                'weight' => 0,
                'campaign_weight' => 1,
            ],
        ];
        $this->assertTrue(_setPriorityFromWeights($aAds));
        $this->assertEqual($aAds[0]['priority'], 0.2);
        $this->assertEqual($aAds[1]['priority'], 0.8);
        $this->assertEqual($aAds[2]['priority'], 0);
    }

    public function test_getTotalPrioritiesByCP()
    {
        // Test an empty array
        $aAds = [];
        $aResult = _getTotalPrioritiesByCP($aAds, true);
        $aExpected = [];
        $this->assertEqual($aResult, $aExpected);
        $aResult = _getTotalPrioritiesByCP($aAds, false);
        $aExpected = [];
        $this->assertEqual($aResult, $aExpected);

        // Test a single ad at CP 5 with 0.5 priority and pf 1
        $aAds = [
            5 => [
                ['priority' => 0.5, 'priority_factor' => 1, 'to_be_delivered' => 1],
            ],
        ];
        $aResult = _getTotalPrioritiesByCP($aAds, true);
        $aExpected = [
            5 => 0.5,
        ];
        $this->assertEqual($aResult, $aExpected);
        $aResult = _getTotalPrioritiesByCP($aAds, false);
        $aExpected = [
            5 => 1,
        ];
        $this->assertEqual($aResult, $aExpected);

        // Test two ads at CP 1/5 with 0.5 priority and pf 1
        $aAds = [
            1 => [
                ['priority' => 0.5, 'priority_factor' => 1, 'to_be_delivered' => 1],
            ],
            5 => [
                ['priority' => 0.5, 'priority_factor' => 1, 'to_be_delivered' => 1],
            ],
        ];
        $aResult = _getTotalPrioritiesByCP($aAds, true);
        $aExpected = [
            1 => 1,
            5 => 0.5,
        ];
        $this->assertEqual($aResult, $aExpected);
        $aResult = _getTotalPrioritiesByCP($aAds, false);
        $aExpected = [
            1 => 1,
            5 => 0.5,
        ];
        $this->assertEqual($aResult, $aExpected);

        // Test three ads at CP 1/5/10 with 0.5 priority and pf 1 (cp 1 not to be delivered)
        $aAds = [
            1 => [
                ['priority' => 0.5, 'priority_factor' => 1, 'to_be_delivered' => 0],
            ],
            5 => [
                ['priority' => 0.5, 'priority_factor' => 1, 'to_be_delivered' => 1],
            ],
            10 => [
                ['priority' => 0.5, 'priority_factor' => 1, 'to_be_delivered' => 1],
            ],
        ];
        $aResult = _getTotalPrioritiesByCP($aAds, true);
        $aExpected = [
            1 => 1,
            5 => 0.5 / 0.50001,
            10 => 0.5 / 1.00001,
        ];
        $this->assertEqual($aResult, $aExpected);
        $aResult = _getTotalPrioritiesByCP($aAds, false);
        $aExpected = [
            1 => 1,
            5 => 0.5 / 0.50001,
            10 => 0.5 / 1.00001,
        ];
        $this->assertEqual($aResult, $aExpected);

        // Test three ads at CP 5 with 0.3 priority and pf 1,10,100
        $aAds = [
            5 => [
                ['priority' => 0.3, 'priority_factor' => 1, 'to_be_delivered' => 1],
                ['priority' => 0.3, 'priority_factor' => 10, 'to_be_delivered' => 1],
                ['priority' => 0.3, 'priority_factor' => 100, 'to_be_delivered' => 1],
            ],
        ];
        $aResult = _getTotalPrioritiesByCP($aAds, true);
        $aExpected = [
            5 => (0.3 + 3 + 30) / (0.1 + 0.3 + 3 + 30),
        ];
        $this->assertEqual($aResult, $aExpected);
        $aResult = _getTotalPrioritiesByCP($aAds, false);
        $aExpected = [
            5 => 1,
        ];
        $this->assertEqual($aResult, $aExpected);

        // Test three ads at CP 1/5/10 with 0.5 priority and decreasing pf (cp 1 not to be delivered)
        $aAds = [
            1 => [
                ['priority' => 0.5, 'priority_factor' => 100, 'to_be_delivered' => 0],
            ],
            5 => [
                ['priority' => 0.5, 'priority_factor' => 10, 'to_be_delivered' => 1],
            ],
            10 => [
                ['priority' => 0.5, 'priority_factor' => 1, 'to_be_delivered' => 1],
            ],
        ];
        $aResult = _getTotalPrioritiesByCP($aAds, true);
        $aExpected = [
            1 => 1,
            5 => 5 / (5 + 0.00001),
            10 => 0.5 / (0.5 + 5 + 0.00001),
        ];
        $this->assertEqual($aResult, $aExpected);
        $aResult = _getTotalPrioritiesByCP($aAds, false);
        $aExpected = [
            1 => 1,
            5 => 5 / (5 + 0.00001),
            10 => 0.5 / (0.5 + 5 + 0.00001),
        ];
        $this->assertEqual($aResult, $aExpected);
    }
}
