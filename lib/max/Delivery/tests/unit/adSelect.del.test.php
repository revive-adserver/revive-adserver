<?php

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
		$target       = 'http://www.target.com';
		$source       = 'http://www.source.com';
		$withText	  =	false;
		$context	  =	0;
		$richMedia    = true;
		$ct0		  =	'';
		$loc		  =	0;
		$referer	  = 'http://some.referrer.com/';

	    $return       = MAX_adSelect($what, $target, $source, $withtext, $context, $richmedia, $ct0, $loc, $referer);

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
        require_once MAX_PATH . '/lib/max/Delivery/tests/data/test_adSelectZone.php';

//        require_once MAX_PATH . '/lib/max/Dal/Delivery/mysql.php';
//        MAX_Dal_Delivery_connect();
//        $aLinkedAds = (array)MAX_Dal_Delivery_getZoneLinkedAds(61);
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

	function test_adSelectBuildCompanionContext()
	{
		$this->sendMessage('test_adSelectBuildCompanionContext');

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
		$ret = _adSelectBuildCompanionContext($aBanner, $context);
		$this->assertIsA($ret, 'array');
		$this->assertIsA($ret[0], 'array');
        $this->assertEqual($ret[0]['!='], 'companionid:55');

        $aBanner['placement_id'] = '55';
		$ret = _adSelectBuildCompanionContext($aBanner, $context);
		$this->assertIsA($ret[0], 'array');
        $this->assertEqual($ret[0]['=='], 'companionid:55');
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