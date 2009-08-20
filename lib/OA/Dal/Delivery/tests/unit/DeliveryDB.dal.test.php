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


require_once MAX_PATH . '/lib/max/Dal/Delivery.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';
require_once 'Log.php';

// pgsql execution time before refactor: 132.33s
// pgsql execution time after refactor: 20.217s

/**
 * A class for testing the Delivery Engine DAL class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Unknown!
 *
 *
 * this method combines and replaces the previously separate mysql and pgsql tests
 *
 */
class Test_OA_Dal_DeliveryDB extends UnitTestCase
{
    var $oDbh;
    var $prefix;
    var $aIds;

    function Test_OA_Dal_DeliveryDB()
    {
        $this->UnitTestCase();
        $this->oDbh = OA_DB::singleton();
        $this->prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $this->aIds = TestEnv::loadData('delivery_001','mdb2schema');

        // Disable caching
        $GLOBALS['OA_Delivery_Cache']['expiry'] = -1;

        MAX_Dal_Delivery_Include();
    }

    /**
     * A private method to close delivery connection after tests are run
     *
     */
    function _testCloseConnection()
    {
        if ($this->oDbh->dbsyntax == 'pgsql')
        {
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
    function test_OA_Dal_Delivery_connect()
    {
        $GLOBALS['_MAX']['ADMIN_DB_LINK'] = OA_Dal_Delivery_connect();
        $this->assertNoErrors('test_OA_Dal_Delivery_query');
        $type = get_resource_type($GLOBALS['_MAX']['ADMIN_DB_LINK']);
        $this->assertEqual($type, $this->oDbh->dbsyntax.' link');
    }

    function _getTableName($table)
    {
        return $this->oDbh->quoteIdentifier($this->prefix.$table, true);
    }

    /**
     * executes a sql query
     *
     */
    function test_OA_Dal_Delivery_query()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $res = OA_Dal_Delivery_query("SELECT * FROM ".$this->_getTableName('banners')." limit 1");
        $this->assertTrue($res);
        $row = OA_Dal_Delivery_fetchAssoc($res);
        $this->assertTrue($row);
        $this->assertNoErrors('test_OA_Dal_Delivery_query');
    }

    /**
     * returns an array of properties for a zone
     *
     */
    function test_OA_Dal_Delivery_getZoneInfo()
    {
        $zoneid     = $this->aIds['zones'][61];
        $aReturn    = OA_Dal_Delivery_getZoneInfo($zoneid);
        //$prn        = var_export($aReturn, TRUE);
        $this->assertIsA($aReturn, 'array');
        $this->assertEqual($zoneid, $aReturn['zone_id']);
    }

    /**
     * return an array of zone properties and arrays of linked ads for a given zone
     *
     */
    function test_OA_Dal_Delivery_getZoneLinkedAds()
    {
        $zoneid     = $this->aIds['zones'][61];
        $aReturn    = OA_Dal_Delivery_getZoneLinkedAds($zoneid);

        $this->assertIsA($aReturn, 'array');
        $this->assertEqual($zoneid, $aReturn['zone_id']);
        $this->assertEqual($aReturn['default_banner_image_url'], "http://www.openx.org/themes/openx/images/header_logo.png");
        $this->assertEqual($aReturn['default_banner_destination_url'], "http://www.openx.org/");
        $this->assertIsA($aReturn['xAds'], 'array');
        $this->assertIsA($aReturn['cAds'], 'array');
        $this->assertIsA($aReturn['clAds'], 'array');
        $this->assertIsA($aReturn['ads'], 'array');
        $this->assertIsA($aReturn['lAds'], 'array');
        $this->assertIsA($aReturn['count_active'], 'integer');
        $this->assertIsA($aReturn['zone_companion'], 'boolean');
        $this->assertIsA($aReturn['priority'], 'array');
        $this->assertIsA($aReturn['priority']['xAds']   , 'integer');
        $this->assertIsA($aReturn['priority']['cAds']   , 'array');
        $this->assertIsA($aReturn['priority']['clAds']  , 'integer');
        $this->assertIsA($aReturn['priority']['ads']    , 'array');
        $this->assertIsA($aReturn['priority']['lAds']   , 'integer');
    }

    /**
     * @todo needs more test cases
     *
     * return an array of ads that match a given search term
     *
     */
    function test_OA_Dal_Delivery_getLinkedAds()
    {
        $placementid = $this->aIds['campaigns'][1];
        $search     = 'campaignid:'.$placementid;
        $aReturn    = OA_Dal_Delivery_getLinkedAds($search);
        //$prn        = var_export($aReturn, TRUE);
        $this->assertIsA($aReturn, 'array');
        //$this->assertEqual($aReturn['count_active'], 2); // php/mysql 4 vs 5 issues
        foreach ($aReturn['lAds'] as $k => $v) {
            $this->assertEqual($v['placement_id'], $placementid);
        }

        $width      = 468;
        $height     = 60;
        $search     = "{$width}x{$height}";
        $aReturn    = OA_Dal_Delivery_getLinkedAds($search);
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
        $search     = 'foo/bar';
        $aReturn    = OA_Dal_Delivery_getLinkedAds($search);
        $this->assertIsA($aReturn, 'array');
        $this->assertEqual($aReturn['count_active'], 0);

        $search     = 'foo';
        $aReturn    = OA_Dal_Delivery_getLinkedAds($search);
        $this->assertIsA($aReturn, 'array');
        $this->assertEqual($aReturn['count_active'], 1);

        $search     = 'foo,+bar';
        $aReturn    = OA_Dal_Delivery_getLinkedAds($search);
        $this->assertIsA($aReturn, 'array');
        $this->assertEqual($aReturn['count_active'], 1);

        $search     = 'foo,+baz';
        $aReturn    = OA_Dal_Delivery_getLinkedAds($search);
        $this->assertIsA($aReturn, 'array');
        $this->assertEqual($aReturn['count_active'], 0);

        $search     = 'html';
        $aReturn    = OA_Dal_Delivery_getLinkedAds($search);
        $this->assertIsA($aReturn, 'array');
        //$this->assertEqual($aReturn['count_active'], 38); // php/mysql 4 vs 5 issues

        $search     = 'textad';
        $aReturn    = OA_Dal_Delivery_getLinkedAds($search);
        $this->assertIsA($aReturn, 'array');
        $this->assertEqual($aReturn['count_active'], 17);
	}

    /**
     * get an ad array formatted for render given an ad id
     *
     */
    function test_OA_Dal_Delivery_getAd()
    {
        $ad_id      = $this->aIds['banners'][1];
        $aReturn    = OA_Dal_Delivery_getAd($ad_id);
        $this->assertIsA($aReturn, 'array');
        $this->assertEqual($aReturn['ad_id'], $ad_id);
    }

    /**
     * get the plugins required and compiled limitations string for a given channel id
     *
     */
    function test_OA_Dal_Delivery_getChannelLimitations()
    {
        $channelid  = $this->aIds['channel'][1];
        $aReturn    = OA_Dal_Delivery_getChannelLimitations($channelid);
        //$prn        = var_export($aReturn, TRUE);
        $this->assertIsA($aReturn['acl_plugins'],'string');
        $this->assertEqual($aReturn['compiledlimitation'],'true');
    }

    /**
     * low-priority test
     * problem loading binary data from xml file
     **/
    function test_OA_Dal_Delivery_getCreative()
    {
//        $filename   = 'adOneTwoOneID.gif';
//        $aReturn    = OA_Dal_Delivery_getCreative($filename);
//        $prn        = var_export($aReturn, TRUE);
//        $this->assertIsA($aReturn, 'array');
//        $this->assertEqual($aReturn['filename'], 'adOneTwoOneID.gif');
    }

    /**
     * get tracker details
     *
     */
    function test_OA_Dal_Delivery_getTracker()
    {
        $trackerid  = $this->aIds['trackers'][1];
        $aReturn    = OA_Dal_Delivery_getTracker($trackerid);
        $this->assertEqual($aReturn['advertiser_id'],1);
        $this->assertEqual($aReturn['tracker_id'],1);
        $this->assertEqual($aReturn['name'],'Tracker 1');
        $this->assertEqual($aReturn['variablemethod'],'js');
        $this->assertEqual($aReturn['description'],'Tracker 1');
        $this->assertEqual($aReturn['viewwindow'],3600);
        $this->assertEqual($aReturn['clickwindow'],3600);
        $this->assertEqual($aReturn['blockwindow'],3600);
        $this->assertEqual($aReturn['appendcode'],'');
    }

    /**
     * @todo need better test case
     *
     * get tracker variables
     *
     */
    function test_OA_Dal_Delivery_getTrackerVariables()
    {
        $trackerid  = 1;
        $aReturn    = OA_Dal_Delivery_getTrackerVariables($trackerid);
        $this->assertEqual(count($aReturn), 2);
    }

    /**
     * proper low/exclusive prioritisation with campaign weight coming first
     *
     */
    function test_setPriorityFromWeights()
    {
        $aAds = array();
        $this->assertFalse(_setPriorityFromWeights($aAds));

        $aAds = array(
            array(
                'placement_id'    => 1,
                'weight'          => 0,
                'campaign_weight' => 1,
            ),
        );
        $this->assertFalse(_setPriorityFromWeights($aAds));

        $aAds = array(
            array(
                'placement_id'    => 1,
                'weight'          => 1,
                'campaign_weight' => 0,
            ),
        );
        $this->assertFalse(_setPriorityFromWeights($aAds));

        $aAds = array(
            array(
                'placement_id'    => 1,
                'weight'          => 1,
                'campaign_weight' => 1,
            ),
        );
        $this->assertTrue(_setPriorityFromWeights($aAds));
        $this->assertEqual($aAds[0]['priority'], 1);

        $aAds = array(
            array(
                'placement_id'    => 1,
                'weight'          => 1,
                'campaign_weight' => 1,
            ),
            array(
                'placement_id'    => 1,
                'weight'          => 1,
                'campaign_weight' => 1,
            ),
        );
        $this->assertTrue(_setPriorityFromWeights($aAds));
        $this->assertEqual($aAds[0]['priority'], 0.5);
        $this->assertEqual($aAds[1]['priority'], 0.5);

        $aAds = array(
            array(
                'placement_id'    => 1,
                'weight'          => 1,
                'campaign_weight' => 1,
            ),
            array(
                'placement_id'    => 1,
                'weight'          => 1,
                'campaign_weight' => 1,
            ),
            array(
                'placement_id'    => 2,
                'weight'          => 2,
                'campaign_weight' => 1,
            ),
        );
        $this->assertTrue(_setPriorityFromWeights($aAds));
        $this->assertEqual($aAds[0]['priority'], 0.25);
        $this->assertEqual($aAds[1]['priority'], 0.25);
        $this->assertEqual($aAds[2]['priority'], 0.5);

        $aAds = array(
            array(
                'placement_id'    => 1,
                'weight'          => 1,
                'campaign_weight' => 1,
            ),
            array(
                'placement_id'    => 1,
                'weight'          => 4,
                'campaign_weight' => 1,
            ),
            array(
                'placement_id'    => 2,
                'weight'          => 2,
                'campaign_weight' => 1,
            ),
        );
        $this->assertTrue(_setPriorityFromWeights($aAds));
        $this->assertEqual($aAds[0]['priority'], 0.1);
        $this->assertEqual($aAds[1]['priority'], 0.4);
        $this->assertEqual($aAds[2]['priority'], 0.5);

        $aAds = array(
            array(
                'placement_id'    => 1,
                'weight'          => 12,
                'campaign_weight' => 1,
            ),
            array(
                'placement_id'    => 1,
                'weight'          => 13,
                'campaign_weight' => 1,
            ),
            array(
                'placement_id'    => 2,
                'weight'          => 2,
                'campaign_weight' => 3,
            ),
        );
        $this->assertTrue(_setPriorityFromWeights($aAds));
        $this->assertEqual($aAds[0]['priority'], 0.12);
        $this->assertEqual($aAds[1]['priority'], 0.13);
        $this->assertEqual($aAds[2]['priority'], 0.75);

        $aAds = array(
            array(
                'placement_id'    => 1,
                'weight'          => 1,
                'campaign_weight' => 1,
            ),
            array(
                'placement_id'    => 1,
                'weight'          => 0,
                'campaign_weight' => 1,
            ),
            array(
                'placement_id'    => 2,
                'weight'          => 2,
                'campaign_weight' => 1,
            ),
        );
        $this->assertTrue(_setPriorityFromWeights($aAds));
        $this->assertEqual($aAds[0]['priority'], 0.5);
        $this->assertEqual($aAds[1]['priority'], 0);
        $this->assertEqual($aAds[2]['priority'], 0.5);

        $aAds = array(
            array(
                'placement_id'    => 1,
                'weight'          => 1,
                'campaign_weight' => 1,
            ),
            array(
                'placement_id'    => 1,
                'weight'          => 4,
                'campaign_weight' => 1,
            ),
            array(
                'placement_id'    => 2,
                'weight'          => 2,
                'campaign_weight' => 0,
            ),
        );
        $this->assertTrue(_setPriorityFromWeights($aAds));
        $this->assertEqual($aAds[0]['priority'], 0.2);
        $this->assertEqual($aAds[1]['priority'], 0.8);
        $this->assertEqual($aAds[2]['priority'], 0);

        $aAds = array(
            array(
                'placement_id'    => 1,
                'weight'          => 1,
                'campaign_weight' => 1,
            ),
            array(
                'placement_id'    => 1,
                'weight'          => 4,
                'campaign_weight' => 1,
            ),
            array(
                'placement_id'    => 2,
                'weight'          => 0,
                'campaign_weight' => 1,
            ),
        );
        $this->assertTrue(_setPriorityFromWeights($aAds));
        $this->assertEqual($aAds[0]['priority'], 0.2);
        $this->assertEqual($aAds[1]['priority'], 0.8);
        $this->assertEqual($aAds[2]['priority'], 0);
    }

    function test_getTotalPrioritiesByCP()
    {
        // Test an empty array
        $aAds = array();
        $aResult = _getTotalPrioritiesByCP($aAds, true);
        $aExpected = array();
        $this->assertEqual($aResult, $aExpected);
        $aResult = _getTotalPrioritiesByCP($aAds, false);
        $aExpected = array();
        $this->assertEqual($aResult, $aExpected);

        // Test a single ad at CP 5 with 0.5 priority and pf 1
        $aAds = array(
            5 => array(
                array('priority' => 0.5, 'priority_factor' => 1, 'to_be_delivered' => 1),
            ),
        );
        $aResult = _getTotalPrioritiesByCP($aAds, true);
        $aExpected = array(
            5 => 0.5,
        );
        $this->assertEqual($aResult, $aExpected);
        $aResult = _getTotalPrioritiesByCP($aAds, false);
        $aExpected = array(
            5 => 1,
        );
        $this->assertEqual($aResult, $aExpected);

        // Test two ads at CP 1/5 with 0.5 priority and pf 1
        $aAds = array(
            1 => array(
                array('priority' => 0.5, 'priority_factor' => 1, 'to_be_delivered' => 1),
            ),
            5 => array(
                array('priority' => 0.5, 'priority_factor' => 1, 'to_be_delivered' => 1),
            ),
        );
        $aResult = _getTotalPrioritiesByCP($aAds, true);
        $aExpected = array(
            1 => 1,
            5 => 0.5,
        );
        $this->assertEqual($aResult, $aExpected);
        $aResult = _getTotalPrioritiesByCP($aAds, false);
        $aExpected = array(
            1 => 1,
            5 => 0.5,
        );
        $this->assertEqual($aResult, $aExpected);

        // Test three ads at CP 1/5/10 with 0.5 priority and pf 1 (cp 1 not to be delivered)
        $aAds = array(
            1 => array(
                array('priority' => 0.5, 'priority_factor' => 1, 'to_be_delivered' => 0),
            ),
            5 => array(
                array('priority' => 0.5, 'priority_factor' => 1, 'to_be_delivered' => 1),
            ),
            10 => array(
                array('priority' => 0.5, 'priority_factor' => 1, 'to_be_delivered' => 1),
            ),
        );
        $aResult = _getTotalPrioritiesByCP($aAds, true);
        $aExpected = array(
            1  => 1,
            5  => 0.5 / 0.50001,
            10 => 0.5 / 1.00001,
        );
        $this->assertEqual($aResult, $aExpected);
        $aResult = _getTotalPrioritiesByCP($aAds, false);
        $aExpected = array(
            1  => 1,
            5  => 0.5 / 0.50001,
            10 => 0.5 / 1.00001,
        );
        $this->assertEqual($aResult, $aExpected);

        // Test three ads at CP 5 with 0.3 priority and pf 1,10,100
        $aAds = array(
            5 => array(
                array('priority' => 0.3, 'priority_factor' => 1, 'to_be_delivered' => 1),
                array('priority' => 0.3, 'priority_factor' => 10, 'to_be_delivered' => 1),
                array('priority' => 0.3, 'priority_factor' => 100, 'to_be_delivered' => 1),
            ),
        );
        $aResult = _getTotalPrioritiesByCP($aAds, true);
        $aExpected = array(
            5  => (0.3 + 3 + 30) / (0.1 + 0.3 + 3 + 30),
        );
        $this->assertEqual($aResult, $aExpected);
        $aResult = _getTotalPrioritiesByCP($aAds, false);
        $aExpected = array(
            5  => 1,
        );
        $this->assertEqual($aResult, $aExpected);

        // Test three ads at CP 1/5/10 with 0.5 priority and decreasing pf (cp 1 not to be delivered)
        $aAds = array(
            1 => array(
                array('priority' => 0.5, 'priority_factor' => 100, 'to_be_delivered' => 0),
            ),
            5 => array(
                array('priority' => 0.5, 'priority_factor' => 10, 'to_be_delivered' => 1),
            ),
            10 => array(
                array('priority' => 0.5, 'priority_factor' => 1, 'to_be_delivered' => 1),
            ),
        );
        $aResult = _getTotalPrioritiesByCP($aAds, true);
        $aExpected = array(
            1  => 1,
            5  => 5 / (5 + 0.00001),
            10 => 0.5 / (0.5 + 5 + 0.00001),
        );
        $this->assertEqual($aResult, $aExpected);
        $aResult = _getTotalPrioritiesByCP($aAds, false);
        $aExpected = array(
            1  => 1,
            5  => 5 / (5 + 0.00001),
            10 => 0.5 / (0.5 + 5 + 0.00001),
        );
        $this->assertEqual($aResult, $aExpected);

    }
}

?>
