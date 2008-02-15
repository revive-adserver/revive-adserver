<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
$Id $
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
        $this->aIds = TestEnv::loadData('delivery_001');

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
        if ($this->oDbh->dbsyntax == 'mysql')
        {
            $this->assertEqual(get_resource_type($GLOBALS['_MAX']['ADMIN_DB_LINK']), 'mysql link');
        }
        else if ($this->oDbh->dbsyntax == 'pgsql')
        {
            $this->assertEqual(get_resource_type($GLOBALS['_MAX']['ADMIN_DB_LINK']), 'pgsql link');
        }
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
        if ($this->oDbh->dbsyntax == 'mysql')
        {
            $row = @mysql_fetch_array($res);
        }
        else if ($this->oDbh->dbsyntax == 'pgsql')
        {
            $row = @pg_fetch_array($res);
        }
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
     * test impression/click logging
     *
     */
    function test_OA_Dal_Delivery_logAction()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        $res = OA_Dal_Delivery_logAction(
            $this->prefix.'data_raw_ad_impression',
            '',
            1,
            0,
            1,
            array(),
            array(
                'scheme' => 0,
                'host'   => 'localhost',
                'path'   => '/',
                'query'  => ''
            ),
            '',
            0
        );
        $this->assertTrue($res);

        $res = OA_Dal_Delivery_logAction(
            $this->prefix.'data_raw_ad_click',
            '',
            1,
            0,
            1,
            array(),
            array(
                'scheme' => 0,
                'host'   => 'localhost',
                'path'   => '/',
                'query'  => ''
            ),
            '',
            0
        );
        $this->assertTrue($res);
    }

    /**
     * test tracker impression logging
     *
     */
    function test_OA_Dal_Delivery_logTracker()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $id = OA_Dal_Delivery_logTracker(
            $this->prefix.'data_raw_tracker_impression',
            '',
            1,
            '127.0.0.1',
            array(),
            array(
                'scheme' => 0,
                'host'   => 'localhost',
                'path'   => '/',
                'query'  => ''
            ),
            '',
            0
        );
        $this->assertEqual($id, 1);
    }

    /**
     * test tracker impression logging with variables
     *
     */
    function test_OA_Dal_Delivery_logVariableValues()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $id = OA_Dal_Delivery_logTracker(
            $this->prefix.'data_raw_tracker_impression',
            '',
            1,
            '127.0.0.1',
            array(),
            array(
                'scheme' => 0,
                'host'   => 'localhost',
                'path'   => '/',
                'query'  => ''
            ),
            '',
            0
        );
        $this->assertTrue($id > 0);

        $res = OA_Dal_Delivery_logVariableValues(
            array(
                array('variable_id' => 1, 'value' => '10'),
                array('variable_id' => 2, 'value' => '2007-01-01'),
            ),
            $id,
            '127.0.0.1'
        );
        $this->assertTrue($res);
    }
}

?>
