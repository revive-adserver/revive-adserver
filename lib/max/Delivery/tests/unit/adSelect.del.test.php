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
$Id$
*/

require_once MAX_PATH . '/lib/max/Delivery/adSelect.php';

/**
 * A class for testing the ad.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author
 *
 */
class test_DeliveryAdSelect extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function test_DeliveryAdSelect()
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
		$context	  =	0;
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
		$ret          = _adSelectDirect($what, $context, $source, $richMedia);
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

        // Test1
		$return   = _adSelect($aLinked_xAds, $context, $source, $richMedia, 'xAds');
		$this->assertTrue(array_key_exists($return['ad_id'], $aLinked_xAds['xAds']));

        // Test2
		$return   = _adSelect($aLinked_ads, $context, $source, $richMedia, 'ads');
		$this->assertTrue(array_key_exists($return['ad_id'], $aLinked_ads['ads']));

		// Test3:
		$return   = _adSelect($aLinked_cAds, $context, $source, $richMedia, 'cAds');
		$this->assertTrue(array_key_exists($return['ad_id'], $aLinked_cAds['cAds']));

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
		$context	= '';
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
