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

require_once MAX_PATH . '/lib/max/Delivery/adSelect.php';


/*
 * test function that allows us to control mt_rand output in _adSelect
 */
function test_mt_rand ($low, $high) {
  return $GLOBALS['rand_val'] * $high;
}

/*
 * test function that allows us to override MAX_cacheGetAd
 */
$GLOBALS['test_MAX_cacheGetAd_val'] = array();
function test_MAX_cacheGetAd ($ad_id) {
    if (isset ($GLOBALS['test_MAX_cacheGetAd_val'][$ad_id])) {
        return $GLOBALS['test_MAX_cacheGetAd_val'][$ad_id];
    }
    return array();
}


/**
 * A class for testing the ad.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author
 *
 */
class Test_DeliveryAdSelect extends UnitTestCase {

    /**
     * The constructor method.
     */
    function __construct()
    {
        $this->UnitTestCase();
    }

    function tearDown()
    {
        // Clean up so as not to interfere with the following test classes.
        global $source;
        $source = '';
    }

    /**
     * @todo calls functions that calls database/cache retrieval methods
     *     cannot mock database
     *     need to decide where/how to test this
     *
     * This library contains the functions to select and generate the HTML for an ad
     *
     */
    function test_MAX_adSelect()
    {
        $this->sendMessage('test_adSelect');

        require_once MAX_PATH . '/lib/max/Delivery/common.php';

        $what         =	'zone:1';
        $campaignid   = '';
        $target       = 'http://www.target.com';
        $source       = 'http://www.source.com';
        $withText	  =	false;
        $charset      = '';
        $context	  =	array();
        $richMedia    = true;
        $ct0		  =	'';
        $loc		  =	0;
        $referer	  = 'http://some.referrer.com/';

        $return       = MAX_adSelect($what, $campaignid, $target, $source, $withtext, $charset, $context, $richmedia, $ct0, $loc, $referer);

        $this->assertTrue(TRUE);
    }

    /**
     * @todo calls functions that calls database/cache retrieval methods
     *     cannot mock database
     *     need to decide where/how to test this
     *
     */
    function test_adSelectDirect()
    {
        $this->sendMessage('test_adSelectDirect');

        require_once MAX_PATH . '/lib/max/Delivery/common.php';

        $what         = '';
        $context      = array();
        $source       = 'http://www.source.com';
        $richMedia    = true;
        $ret          = _adSelectDirect($what, $campaignid = 1,$context, $source, $richMedia);
        $this->assertTrue(TRUE);
    }

    /**
     * @todo calls functions that calls database/cache retrieval methods
     *     cannot mock database
     *     need to decide where/how to test this
     *
     */
    function test_adSelectZone()
    {
        $this->sendMessage('test_adSelectZone');

        require_once MAX_PATH . '/lib/max/Delivery/common.php';

        $zoneId       = 0;
        $context      = array();
        $source       = 'http://www.source.com';
        $richMedia    = true;
        $ret          = _adSelectZone($zoneId, $context, $source, $richMedia);
        $this->assertTrue(TRUE);
    }

    /**
     * @todo identify more test cases!!!!
     *
     * Test1: if there are exclusive ads with no limitations one is selected
     * Test2: if there are no exclusive ads then an ad is selected from the ['ads'] array
     * Test3: if no exclusive and one companion with 100% probability
     */
    function test_adSelect()
    {
        $this->sendMessage('test_adSelect');

        require_once MAX_PATH . '/lib/max/Delivery/common.php';
        require MAX_PATH . '/lib/max/Delivery/tests/data/test_adSelectZone.php';

        //        require_once MAX_PATH . '/lib/OA/Dal/Delivery/'.$GLOBALS['_MAX']['CONF']['database']['type'].'.php';
        //        OA_Dal_Delivery_connect();
        //        $aLinkedAds = (array)OA_Dal_Delivery_getZoneLinkedAds(61);
        //        $prn = var_export($aLinkedAds, TRUE);

        // Note: The total priority of 'ads' array is forcibly set to 1 instead of 0.98901098901 to ensure
        // the test is predictable and something is always delivered
        $aLinked_ads['priority']['ads'][5] = 1;

        // Test1
        //_adSelect(&$aLinkedAds, $context, $source, $richMedia, $companion, $adArrayVar = 'ads', $cp = null)
        $GLOBALS['test_MAX_cacheGetAd_val'] = $aLinked_xAds['xAds'];
        $return   = _adSelect($aLinked_xAds, $context, $source, $richMedia, $companion = false, 'xAds');
        $this->assertTrue($return && array_key_exists($return['ad_id'], $aLinked_xAds['xAds']));

        // Test2
        $GLOBALS['test_MAX_cacheGetAd_val'] = $aLinked_ads['ads'][5];
        $return   = _adSelect($aLinked_ads, $context, $source, $richMedia, $companion = false, 'ads', 5);
        $this->assertTrue($return && array_key_exists($return['ad_id'], $aLinked_ads['ads'][5]));

        // Test3:
        $GLOBALS['test_MAX_cacheGetAd_val'] = $aLinked_cAds['cAds'][5];
        $return   = _adSelect($aLinked_cAds, $context, $source, $richMedia, $companion = false, 'cAds', 5);
        $this->assertTrue($return && array_key_exists($return['ad_id'], $aLinked_cAds['cAds'][5]));

        // Test4
        $context = array(
                // when the banner is a companion banner, subsequent calls should try to show banners from the same campaign
                // here we set the campaign that was served as companion to a non existing campaign ID, to ensure
                // that when companion = true, no banner is served
                array('==' => 'companionid:148000') 
                );

        // companion disabled, banners are served as usual
        $GLOBALS['test_MAX_cacheGetAd_val'] = $aLinked_cAds['ads'][5];
        $return   = _adSelect($aLinked_cAds, $context, $source, $richMedia, $companion = false, 'ads', 5);
        $this->assertTrue($return && array_key_exists($return['ad_id'], $aLinked_cAds['ads'][5]));

        // companion enabled, no banner is served
        $before = $GLOBALS['_MAX']['DIRECT_SELECTION'];
        $GLOBALS['_MAX']['DIRECT_SELECTION'] = false;
        $return   = _adSelect($aLinked_cAds, $context, $source, $richMedia, $companion = true, 'ads', 5);
        $GLOBALS['_MAX']['DIRECT_SELECTION'] = $before;
        $this->assertEqual($return, false);

    }

    /**
     * @todo Fix this test to not rely on apd:override_function
     *
     */
    function test_adSelect2()
    {
        $this->sendMessage('test_adSelect2');

        require_once MAX_PATH . '/lib/max/Delivery/common.php';
        require MAX_PATH . '/lib/max/Delivery/tests/data/test_adSelectZone.php';

        // set up a small test data set
        $context      = array();
        $test_ads = $aLinked_ads;
        $test_ads['ads'][4][1122] = $test_ads['ads'][5][1022];
        $test_ads['ads'][4][1124] = $test_ads['ads'][5][1024];
        $test_ads['ads'][5] = array();
        $test_ads['ads'][5][1022] = $test_ads['ads'][4][1122];
        $test_ads['ads'][5][1024] = $test_ads['ads'][4][1124];
        $test_ads['ads'][4][1122]['ad_id'] = '1122';
        $test_ads['ads'][4][1124]['ad_id'] = '1124';

        // case 1: cp5, 2 ads both 0.7
        $ads_copy = $test_ads;
        $ads_copy['ads'][5][1022]['priority'] = 0.7;
        $ads_copy['ads'][5][1024]['priority'] = 0.7;
        $GLOBALS['test_MAX_cacheGetAd_val'] = $ads_copy['ads'][5];

        // this should pick the first one
        $GLOBALS['rand_val'] = 0.49;
        $return   = _adSelect($ads_copy, $context, $source, $richMedia, false, 'ads', 5);
        $this->assertTrue(array_key_exists($return['ad_id'], $ads_copy['ads'][5]));
        $this->assertTrue($ads_copy['priority_used']['ads'][5] >= 1);

        // case 2: cp5, 2 ads both 0.7
        $prev_return = $return;
        $ads_copy = $test_ads;
        $ads_copy['ads'][5][1022]['priority'] = 0.7;
        $ads_copy['ads'][5][1024]['priority'] = 0.7;

        // this should pick the second one
        $GLOBALS['rand_val'] = 0.51;
        $return   = _adSelect($ads_copy, $context, $source, $richMedia, false, 'ads', 5);
        $this->assertTrue(array_key_exists($return['ad_id'], $ads_copy['ads'][5]));
        $this->assertNotEqual ($return['ad_id'], $prev_return['ad_id']);

        // case 3: cp5, 2 ads both 0.4, cp4, 2 ads both 0.3
        $ads_copy = $test_ads;
        $ads_copy['ads'][5][1022]['priority'] = 0.4;
        $ads_copy['ads'][5][1024]['priority'] = 0.4;
        $ads_copy['ads'][4][1122]['priority'] = 0.3;
        $ads_copy['ads'][4][1124]['priority'] = 0.3;

        // this should not pick a cp5 ad
        $GLOBALS['rand_val'] = 0.81;
        $return   = _adSelect($ads_copy, $context, $source, $richMedia, false, 'ads', 5);
        $this->assertNull($return);

        // this should choose the first ad
        $GLOBALS['rand_val'] = 0.49;
        $GLOBALS['test_MAX_cacheGetAd_val'] = $ads_copy['ads'][4];
        $return   = _adSelect($ads_copy, $context, $source, $richMedia, false, 'ads', 4);
        $this->assertTrue(array_key_exists($return['ad_id'], $ads_copy['ads'][4]));
        $this->assertEqual($ads_copy['priority_used']['ads'][5], 0.8);
        $this->assertEqual($ads_copy['priority_used']['ads'][4], 0.6);

        // case 4: cp5, 2 ads both 0.4, cp4, 2 ads both 0.3
        $ads_copy = $test_ads;
        $prev_return = $return;
        $ads_copy['ads'][5][1022]['priority'] = 0.4;
        $ads_copy['ads'][5][1024]['priority'] = 0.4;
        $ads_copy['ads'][4][1122]['priority'] = 0.3;
        $ads_copy['ads'][4][1124]['priority'] = 0.3;

        // this should not pick a cp5 ad
        $GLOBALS['rand_val'] = 0.81;
        $return   = _adSelect($ads_copy, $context, $source, $richMedia, false, 'ads', 5);
        $this->assertNull($return);

        // this should choose the second ad
        $GLOBALS['rand_val'] = 0.51;
        $GLOBALS['test_MAX_cacheGetAd_val'] = $ads_copy['ads'][4];
        $return   = _adSelect($ads_copy, $context, $source, $richMedia, false, 'ads', 4);
        $this->assertTrue(array_key_exists($return['ad_id'], $ads_copy['ads'][4]));
        $this->assertEqual($ads_copy['priority_used']['ads'][5], 0.8);
        $this->assertEqual($ads_copy['priority_used']['ads'][4], 0.6);
        // make sure it's not the same ad
        $this->assertNotEqual ($return['ad_id'], $prev_return['ad_id']);

        // case 5: cp5, 2 ads both 0.2, cp4, 2 ads both 0.2
        $ads_copy = $test_ads;
        $prev_return = $return;
        $ads_copy['ads'][5][1022]['priority'] = 0.2;
        $ads_copy['ads'][5][1024]['priority'] = 0.2;
        $ads_copy['ads'][4][1122]['priority'] = 0.2;
        $ads_copy['ads'][4][1124]['priority'] = 0.2;

        // this will not pick from cp5 or cp4
        $GLOBALS['rand_val'] = 0.41;
        $return   = _adSelect($ads_copy, $context, $source, $richMedia, false, 'ads', 5);
        $this->assertNull($return);
        $GLOBALS['rand_val'] = 0.67;
        $return   = _adSelect($ads_copy, $context, $source, $richMedia, false, 'ads', 4);
        $this->assertNull($return);
        $this->assertEqual($ads_copy['priority_used']['ads'][5], 0.4);
        $this->assertEqual($ads_copy['priority_used']['ads'][4], 0.4);

        // case 6: cp5, 2 ads both 0.5, cp4, 2 ads both 0.2
        // one of the cp5 ads will be filtered out
        $ads_copy = $test_ads;
        $ads_copy['ads'][5][1022]['priority'] = 0.5;
        $ads_copy['ads'][5][1024]['priority'] = 0.5;
        $ads_copy['ads'][4][1122]['priority'] = 0.2;
        $ads_copy['ads'][4][1124]['priority'] = 0.2;
        $context = array (array('!=' => 'bannerid:1024'));

        // this will not pick from cp5 due to the ad exclusion
        $GLOBALS['rand_val'] = 0.51;
        $return   = _adSelect($ads_copy, $context, $source, $richMedia, false, 'ads', 5);
        $this->assertNull($return);
        $GLOBALS['rand_val'] = 0.79;
        $return   = _adSelect($ads_copy, $context, $source, $richMedia, false, 'ads', 4);
        $this->assertNotNull($return);
        $this->assertEqual($ads_copy['priority_used']['ads'][5], 0.5);
        $this->assertEqual($ads_copy['priority_used']['ads'][4], 0.4);

        // case 7: all ads get filtered out
        $ads_copy = $test_ads;
        unset ($ads_copy['ads'][5][1022]);
        $ads_copy['ads'][5][1024]['priority'] = 0.5;
        $context = array (array('!=' => 'bannerid:1024'));

        // just expect null response
        $GLOBALS['rand_val'] = 0.51;
        $return   = _adSelect($ads_copy, $context, $source, $richMedia, false, 'ads', 5);
        $this->assertNull($return);
        $this->assertTrue(!isset($ads_copy['priority_used']['ads'][5]));
        $context = "";

        // case 8: priority_used limit reached
        $ads_copy = $test_ads;
        $ads_copy['priority_used']['ads'][9] = 0.5;
        $ads_copy['priority_used']['ads'][8] = 0.3;
        $ads_copy['priority_used']['ads'][6] = 0.3;

        // this will return -1, since we've already used the entire priority space
        $GLOBALS['rand_val'] = 0.51;
        $return   = _adSelect($ads_copy, $context, $source, $richMedia, false, 'ads', 5);
        $this->assertEqual($return, $GLOBALS['OX_adSelect_SkipOtherPriorityLevels']);
        $this->assertTrue(!isset($ads_copy['priority_used']['ads'][5]));

        // case 9: cp5, 2 ads both 0.5, cp4, 2 ads both 0.2
        // one of the cp5 ads will be filtered out
        $ads_copy = $test_ads;
        $ads_copy['ads'][5][1022]['priority'] = 0;
        $ads_copy['ads'][5][1024]['priority'] = 0;

        // this will not pick from cp5 due to the ad exclusion
        $GLOBALS['rand_val'] = 0.51;
        $return   = _adSelect($ads_copy, $context, $source, $richMedia, false, 'ads', 5);
        $this->assertNull($return);
        $this->assertEqual($ads_copy['priority_used']['ads'][5], 0);

        // case 10: cp5, 2 ads both 0.7, cp4, 2 ads both 0.2
        // cp5 ad will win, but confirm that the cp4 ads will be filtered
        $ads_copy = $test_ads;
        $ads_copy['ads'][5][1022]['priority'] = 0.7;
        $ads_copy['ads'][5][1024]['priority'] = 0.7;
        $ads_copy['ads'][4][1122]['priority'] = 0.2;
        $ads_copy['ads'][4][1124]['priority'] = 0.2;
        $context = array (array('!=' => 'bannerid:1124'));
        $GLOBALS['_MAX']['considered_ads'] = array ();

        // this will not pick from cp5 due to the ad exclusion
        $GLOBALS['rand_val'] = 0.51;
        $GLOBALS['test_MAX_cacheGetAd_val'] = $ads_copy['ads'][5];
        $return  = _adSelectCommon($ads_copy, $context, $source, $richMedia);
        $this->assertNotNull($return);
        $ads_ret = &$GLOBALS['_MAX']['considered_ads'][0];
        $this->assertEqual($ads_ret['priority_used']['ads'][5], (float) 1.4);
        $this->assertFalse(isset($ads_ret['ads'][4][1124]));
        $this->assertTrue(isset($ads_ret['ads'][4][1122]));

        // case 11: cp5, 2 ads both 0.7, ecpm enabled
        $GLOBALS['_MAX']['CONF']['delivery']['ecpmSelectionRate'] = 1;
        $ads_copy = $test_ads;
        $ads_copy['ads'][6] = $ads_copy['ads'][5];
        $ads_copy['ads'][6][1022]['priority'] = 0.7;
        $ads_copy['ads'][6][1022]['ecpm_enabled'] = 1;
        $ads_copy['ads'][6][1022]['ecpm'] = 2.0;
        $ads_copy['ads'][6][1024]['priority'] = 0.7;
        $ads_copy['ads'][6][1024]['ecpm_enabled'] = 1;
        $ads_copy['ads'][6][1024]['ecpm'] = 0.5;
        $GLOBALS['test_MAX_cacheGetAd_val'] = $ads_copy['ads'][6];
        $context = '';

        // after ecpm optimization, the priorities should be
        //   [1022] = 0.7 => 0.7
        //   [1024] = 0.7 => 0.3
        //
        // this should pick the first one
        $GLOBALS['rand_val'] = 0.49;
        $return   = _adSelect($ads_copy, $context, $source, $richMedia, false, 'ads', 6);
        $this->assertTrue(array_key_exists($return['ad_id'], $ads_copy['ads'][6]));
        $this->assertEqual($return['ad_id'], 1022);
        $this->assertTrue($ads_copy['priority_used']['ads'][6] >= 1);

        $ads_copy = $test_ads;
        $ads_copy['ads'][6] = $ads_copy['ads'][5];
        $ads_copy['ads'][6][1022]['priority'] = 0.7;
        $ads_copy['ads'][6][1022]['ecpm_enabled'] = 1;
        $ads_copy['ads'][6][1022]['ecpm'] = 2.0;
        $ads_copy['ads'][6][1024]['priority'] = 0.7;
        $ads_copy['ads'][6][1024]['ecpm_enabled'] = 1;
        $ads_copy['ads'][6][1024]['ecpm'] = 0.5;
        $GLOBALS['test_MAX_cacheGetAd_val'] = $ads_copy['ads'][6];

        // this should pick the second one
        $GLOBALS['rand_val'] = 0.71;
        $return   = _adSelect($ads_copy, $context, $source, $richMedia, false, 'ads', 6);
        $this->assertTrue(array_key_exists($return['ad_id'], $ads_copy['ads'][6]));
        $this->assertEqual($return['ad_id'], 1024);
        $this->assertTrue($ads_copy['priority_used']['ads'][6] >= 1);

        // case 12: cp5, 2 ads both 0.7, ecpm enabled
        $GLOBALS['_MAX']['CONF']['delivery']['ecpmSelectionRate'] = 1;
        $ads_copy = $test_ads;
        $ads_copy['ads'][6] = $ads_copy['ads'][5];
        $ads_copy['ads'][6][1122] = $ads_copy['ads'][5][1022];
        $ads_copy['ads'][6][1124] = $ads_copy['ads'][5][1024];
        $ads_copy['ads'][6][1222] = $ads_copy['ads'][5][1222];
        $ads_copy['ads'][6][1022]['priority'] = 0.2;
        $ads_copy['ads'][6][1022]['ecpm_enabled'] = 1;
        $ads_copy['ads'][6][1022]['ecpm'] = 2.0;
        $ads_copy['ads'][6][1024]['priority'] = 0.5;
        $ads_copy['ads'][6][1024]['ecpm_enabled'] = 1;
        $ads_copy['ads'][6][1024]['ecpm'] = 0.5;
        $ads_copy['ads'][6][1122]['ad_id'] = 1122;
        $ads_copy['ads'][6][1122]['priority'] = 0.7;
        $ads_copy['ads'][6][1122]['ecpm_enabled'] = 1;
        $ads_copy['ads'][6][1122]['ecpm'] = 2.0;
        $ads_copy['ads'][6][1124]['ad_id'] = 1124;
        $ads_copy['ads'][6][1124]['priority'] = 0.7;
        $ads_copy['ads'][6][1124]['ecpm_enabled'] = 1;
        $ads_copy['ads'][6][1124]['ecpm'] = 0.5;
        $ads_copy['ads'][6][1222]['ad_id'] = 1222;
        $ads_copy['ads'][6][1222]['priority'] = 0.7;
        $ads_copy['ads'][6][1222]['ecpm_enabled'] = 1;
        $ads_copy['ads'][6][1222]['ecpm'] = 0.4;
        $GLOBALS['test_MAX_cacheGetAd_val'] = $ads_copy['ads'][6];

        // this should result in the following
        // [1022] = 0.2
        // [1024] = 0.5 * (1-(0.2+0.7)) / (0.5+0.7) = 0.0417
        // [1122] = 0.7
        // [1124] = 0.7 * (1-(0.2+0.7)) / (0.5+0.7) = 0.0583
        // [1222] = 0.0
        // this should pick 1024
        $GLOBALS['rand_val'] = 0.22;
        $return   = _adSelect($ads_copy, $context, $source, $richMedia, false, 'ads', 6);
        $this->assertTrue(array_key_exists($return['ad_id'], $ads_copy['ads'][6]));
        $this->assertEqual($return['ad_id'], 1024);
        $this->assertTrue($ads_copy['priority_used']['ads'][6] >= 1);
        $this->assertEqual($ads_copy['ads'][6][1022]['priority'], 0.2); //unchanged
        $this->assertNotEqual($ads_copy['ads'][6][1024]['priority'], 0.5); //scaled
        $this->assertEqual($ads_copy['ads'][6][1222]['priority'], 0); //zeroed
        $this->assertEqual($ads_copy['ads'][6][1022]['priority'] +
                $ads_copy['ads'][6][1024]['priority'] +
                $ads_copy['ads'][6][1122]['priority'] +
                $ads_copy['ads'][6][1124]['priority'],
                1);

        $ads_copy = $test_ads;
        $ads_copy['eAds'][-2] = $ads_copy['ads'][5];
        $ads_copy['eAds'][-2][1022]['priority'] = 0.2;
        $ads_copy['eAds'][-2][1022]['ecpm_enabled'] = 1;
        $ads_copy['eAds'][-2][1022]['ecpm'] = 2.0;
        $ads_copy['eAds'][-2][1024]['priority'] = 0.1;
        $ads_copy['eAds'][-2][1024]['ecpm_enabled'] = 1;
        $ads_copy['eAds'][-2][1024]['ecpm'] = 2.0;
        $GLOBALS['test_MAX_cacheGetAd_val'] = $ads_copy['eAds'][-2];

        // this should pick the second one
        $GLOBALS['rand_val'] = 0.51;
        $return   = _adSelect($ads_copy, $context, $source, $richMedia, false, 'eAds', -2);
        $this->assertTrue(array_key_exists($return['ad_id'], $ads_copy['eAds'][-2]));
        $this->assertEqual($return['ad_id'], 1024);

        $ads_copy = $test_ads;
        $ads_copy['eAds'][-2] = $ads_copy['ads'][5];
        $ads_copy['eAds'][-2][1022]['priority'] = 0.7;
        $ads_copy['eAds'][-2][1022]['ecpm_enabled'] = 1;
        $ads_copy['eAds'][-2][1022]['ecpm'] = 1.0;
        $ads_copy['eAds'][-2][1024]['priority'] = 0.1;
        $ads_copy['eAds'][-2][1024]['ecpm_enabled'] = 1;
        $ads_copy['eAds'][-2][1024]['ecpm'] = 2.0;
        $GLOBALS['test_MAX_cacheGetAd_val'] = $ads_copy['eAds'][-2];

        // this should pick the second one
        $GLOBALS['rand_val'] = 0.01;
        $return   = _adSelect($ads_copy, $context, $source, $richMedia, false, 'eAds', -2);
        $this->assertTrue(array_key_exists($return['ad_id'], $ads_copy['eAds'][-2]));
        $this->assertEqual($return['ad_id'], 1024);

        // case 13: cp6, 4 ads 2 0.7, 2 0.9, ecpm enabled
        $GLOBALS['_MAX']['CONF']['delivery']['ecpmSelectionRate'] = 0.001;
        $GLOBALS['_MAX']['CONF']['delivery']['enableControlOnPureCPM'] = 0;
        $ads_copy = $test_ads;
        $ads_copy['ads'][6] = $ads_copy['ads'][5];
        $ads_copy['ads'][6][1122] = $ads_copy['ads'][5][1022];
        $ads_copy['ads'][6][1124] = $ads_copy['ads'][5][1024];
        $ads_copy['ads'][6][1122]['ad_id'] = 1122;
        $ads_copy['ads'][6][1124]['ad_id'] = 1124;
        $ads_copy['ads'][6][1022]['priority'] = 0.7;
        $ads_copy['ads'][6][1022]['ecpm_enabled'] = 1;
        $ads_copy['ads'][6][1022]['ecpm'] = 2.0;
        $ads_copy['ads'][6][1022]['revenue_type'] = 1;
        $ads_copy['ads'][6][1024]['priority'] = 0.9;
        $ads_copy['ads'][6][1024]['ecpm_enabled'] = 1;
        $ads_copy['ads'][6][1024]['ecpm'] = 0.5;
        $ads_copy['ads'][6][1024]['revenue_type'] = 1;
        $ads_copy['ads'][6][1122]['priority'] = 0.7;
        $ads_copy['ads'][6][1122]['ecpm_enabled'] = 1;
        $ads_copy['ads'][6][1122]['ecpm'] = 2.0;
        $ads_copy['ads'][6][1122]['revenue_type'] = 1;
        $ads_copy['ads'][6][1124]['priority'] = 0.9;
        $ads_copy['ads'][6][1124]['ecpm_enabled'] = 1;
        $ads_copy['ads'][6][1124]['ecpm'] = 0.5;
        $ads_copy['ads'][6][1124]['revenue_type'] = 1;
        $GLOBALS['test_MAX_cacheGetAd_val'] = $ads_copy['ads'][6];
        $context = '';

        // if control were enabled, 1124 would be picked.
        // this should pick the 1122 after ecpm optimization
        $GLOBALS['rand_val'] = 0.99;
        $return   = _adSelect($ads_copy, $context, $source, $richMedia, false, 'ads', 6);
        $this->assertTrue(array_key_exists($return['ad_id'], $ads_copy['ads'][6]));
        $this->assertEqual($return['ad_id'], 1122);
        $this->assertTrue($ads_copy['priority_used']['ads'][6] >= 1);

        $this->assertEqual (_controlTrafficEnabled ($ads_copy['ads'][6]), false);
        $GLOBALS['_MAX']['CONF']['delivery']['enableControlOnPureCPM'] = 1;
        $this->assertEqual (_controlTrafficEnabled ($ads_copy['ads'][6]), true);
        $ads_copy['ads'][6][1124]['revenue_type'] = 0;
        $this->assertEqual (_controlTrafficEnabled ($ads_copy['ads'][6]), true);

    }

    /**
     * This test tests the companion context building
     */
    function test_adSelectBuildContext_companion()
    {
        $this->sendMessage('test_adSelectBuildContext');

        $aBanner	= array('placement_id' => '56',
                'zone_companion' => array (
                    0 => '55',
                    ),
                'priority' =>
                array (
                    'xAds' => 0,
                    'cAds' => 1,
                    'clAds' => 0,
                    'ads' => 1,
                    'lAds' => 6,
                    )
                );
        $context	= array();
        $ret = _adSelectBuildContext($aBanner, $context);
        $this->assertIsA($ret, 'array');
        $this->assertIsA($ret[0], 'array');
        $this->assertEqual($ret[0]['!='], 'companionid:55');

        $aBanner['placement_id'] = '55';
        $ret = _adSelectBuildContext($aBanner, $context);
        $this->assertIsA($ret[0], 'array');
        $this->assertEqual($ret[0]['=='], 'companionid:55');

        // Check that if the advertiser_limitation is enabled, that the return array includes the correct exclusion
        $aBanner	= array('placement_id' => '56', 'client_id' => '1', 'advertiser_limitation' => '1');
        $context	= array();
        $ret = _adSelectBuildContext($aBanner, $context);
        $this->assertIsA($ret, 'array');
        $this->assertIsA($ret[0], 'array');
        $this->assertEqual($ret[0]['!='], 'clientid:1');

        // And if the advertiser_limitation is not enabled...
        $aBanner	= array('placement_id' => '56', 'client_id' => '1', 'advertiser_limitation' => '0');
        $context	= array();
        $ret = _adSelectBuildContext($aBanner, $context);
        $this->assertEqual($ret, array());

    }

    function test_getNextZone()
    {
        $arrZone['chain'] = false;

        $this->assertEqual(10, _getNextZone(10, $arrZone));

        $arrZone['chain'] = 'zone:15';
        $this->assertEqual(15, _getNextZone(10, $arrZone));

        $arrZone['chain'] = 'blabla:15';
        $this->assertEqual(10, _getNextZone(10, $arrZone));
    }
}

?>
