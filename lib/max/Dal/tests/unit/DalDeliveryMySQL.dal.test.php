<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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

require_once MAX_PATH . '/lib/max/Dal/Delivery/mysql.php';
require_once MAX_PATH . '/tests/testClasses/SharedFixture.php';
require_once 'Log.php';

/**
 * A class for testing the MySQL version of the Delivery Engine DAL class.
 *
 * @package    MaxDal
 * @subpackage TestSuite
 * @author     Unknown!
 */
class Dal_TestOfDalDeliveryMySQL extends SharedFixtureTestCase
{

    function setUpFixture()
    {
        $error = TestEnv::loadData('0.3.27_delivery', 'insert');
    }

    function tearDownFixture()
    {
        TestEnv::restoreEnv();
    }

    /**
     * establish a singleton connection to the database
     *
     */
    function test_MAX_Dal_Delivery_connect()
    {
        $GLOBALS['_MAX']['ADMIN_DB_LINK'] = MAX_Dal_Delivery_connect();
        $this->assertNoErrors('test_MAX_Dal_Delivery_query');
        $this->assertEqual(get_resource_type($GLOBALS['_MAX']['ADMIN_DB_LINK']), 'mysql link');
    }

    /**
     * executes a sql query
     *
     */
    function test_MAX_Dal_Delivery_query()
    {
        $res = MAX_Dal_Delivery_query("SELECT * FROM banners limit 1");
        $this->assertTrue($res);
        $row = @mysql_fetch_array($res);
        $this->assertTrue($row);
        $this->assertNoErrors('test_MAX_Dal_Delivery_query');
    }

    /**
     * returns an array of properties for a zone
     *
     */
    function test_MAX_Dal_Delivery_getZoneInfo()
    {
        $zoneid     = 61;
        $aReturn    = MAX_Dal_Delivery_getZoneInfo($zoneid);
        //$prn        = var_export($aReturn, TRUE);
        $this->assertIsA($aReturn, 'array');
        $this->assertEqual($zoneid, $aReturn['zone_id']);
    }

    /**
     * return an array of zone properties and arrays of linked ads for a given zone
     *
     */
    function test_MAX_Dal_Delivery_getZoneLinkedAds()
    {
        $zoneid     = 61;
        $aReturn    = MAX_Dal_Delivery_getZoneLinkedAds($zoneid);

        $this->assertIsA($aReturn, 'array');
        $this->assertEqual($zoneid, $aReturn['zone_id']);
        $this->assertNull($aReturn['default_banner_url']);
        $this->assertNull($aReturn['default_banner_dest']);
        $this->assertIsA($aReturn['xAds'], 'array');
        $this->assertIsA($aReturn['cAds'], 'array');
        $this->assertIsA($aReturn['clAds'], 'array');
        $this->assertIsA($aReturn['ads'], 'array');
        $this->assertIsA($aReturn['lAds'], 'array');
        $this->assertIsA($aReturn['count_active'], 'integer');
        $this->assertIsA($aReturn['zone_companion'], 'boolean');
        $this->assertIsA($aReturn['priority'], 'array');
        $this->assertIsA($aReturn['priority']['xAds']   , 'integer');
        $this->assertIsA($aReturn['priority']['cAds']   , 'integer');
        $this->assertIsA($aReturn['priority']['clAds']  , 'integer');
        $this->assertIsA($aReturn['priority']['ads']    , 'integer');
        $this->assertIsA($aReturn['priority']['lAds']   , 'integer');
    }

    /**
     * @todo needs more test cases
     *
     * return an array of ads that match a given search term
     *
     */
    function test_MAX_Dal_Delivery_getLinkedAds()
    {
        $placementid = 1;
        $search     = 'campaignid:'.$placementid;
        $aReturn    = MAX_Dal_Delivery_getLinkedAds($search);
        //$prn        = var_export($aReturn, TRUE);
        $this->assertIsA($aReturn, 'array');
        foreach ($aReturn['ads'] as $k => $v)
        {
            $this->assertEqual($v['placement_id'], $placementid);
        }
    }

    /**
     * get an ad array formatted for render given an ad id
     *
     */
    function test_MAX_Dal_Delivery_getAd()
    {
        $ad_id      = 1;
        $aReturn    = MAX_Dal_Delivery_getAd($ad_id);
        $this->assertIsA($aReturn, 'array');
        $this->assertEqual($aReturn['ad_id'], $ad_id);
    }

    /**
     * get the plugins required and compiled limitations string for a given channel id
     *
     */
    function test_MAX_Dal_Delivery_getChannelLimitations()
    {
        $channelid  = 1;
        $aReturn    = MAX_Dal_Delivery_getChannelLimitations($channelid);
        //$prn        = var_export($aReturn, TRUE);
        $this->assertIsA($aReturn['acl_plugins'],'string');
        $this->assertEqual($aReturn['compiledlimitation'],'true');
    }

    /**
     * low-priority test
     * problem loading binary data from xml file
     **/
    function test_MAX_Dal_Delivery_getCreative()
    {
//        $filename   = 'adOneTwoOneID.gif';
//        $aReturn    = MAX_Dal_Delivery_getCreative($filename);
//        $prn        = var_export($aReturn, TRUE);
//        $this->assertIsA($aReturn, 'array');
//        $this->assertEqual($aReturn['filename'], 'adOneTwoOneID.gif');
    }

    /**
     * A hack method to restore the testing environment to its original
     * state, given that the above code does not do this (which it should!).
     *
     * @author Andrew Hill <andrew@m3.net>
     *
     * @TODO The original author of this test suite should remove this method
     *       once they have fixed the code!
     */
    function test_lastTest()
    {
        TestEnv::restoreEnv();
    }
}

?>
