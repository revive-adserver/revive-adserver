<?php

require_once MAX_PATH . '/lib/max/Delivery/common.php';
require_once MAX_PATH . '/lib/max/Delivery/limitations.php';

/**
 * A class for testing the limitations.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author
 *
 */
class test_DeliveryLimitations extends UnitTestCase
{

    var $tmpCookie;

    /**
     * The constructor method.
     */
    function test_DeliveryLimitations()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        MAX_commonInitVariables();
        $this->tmpCookie = $_COOKIE;
        $_COOKIE = array();
    }

    function tearDown()
    {
        $_COOKIE = $this->tmpCookie;
    }

    /**
     * This function checks the "compiledlimitation" of an ad and returns
     *   true - This limitation passed (so the ad can be shown)
     *   false - One or more of the delivery limitations failed, so this ad cannot be shown
     *
     * @param array $row The row from the delivery engine Dal for this ad
     * @param string $source Optional The value passed in to the ad-call via the "source" parameter
     *
     * @return boolean True if the ACL passes, false otherwise
     */
    function test_MAX_limitationsCheckAcl()
    {
        $source = '';

        $row['compiledlimitation']  = 'false';
        $row['acl_plugins']         = '';
        $return = MAX_limitationsCheckAcl($row, $source);
        $this->assertFalse($return);

        $row['compiledlimitation']  = 'true';
        $row['acl_plugins']         = '';
        $return = MAX_limitationsCheckAcl($row, $source);
        $this->assertTrue($return);

        // test for site channel limitation
        // both channels should be logged in global
        $row['compiledlimitation']  = '(MAX_checkSite_Channel(\'1\', \'==\')) and (MAX_checkSite_Channel(\'2\', \'==\'))';
        $row['acl_plugins']         = 'Site:Channel';
        $return = MAX_limitationsCheckAcl($row, $source);
        $this->assertTrue($return);
        $expect = MAX_DELIVERY_MULTIPLE_DELIMITER.'1'.MAX_DELIVERY_MULTIPLE_DELIMITER.'2'.MAX_DELIVERY_MULTIPLE_DELIMITER;
        $this->assertEqual($GLOBALS['_MAX']['CHANNELS'], $expect);

        // test for site channel limitation
        // first channel should be logged in global
        $row['compiledlimitation']  = '(MAX_checkSite_Channel(\'1\', \'==\')) or (MAX_checkSite_Channel(\'2\', \'==\'))';
        $row['acl_plugins']         = 'Site:Channel';
        $return = MAX_limitationsCheckAcl($row, $source);
        $this->assertTrue($return);
        $expect = MAX_DELIVERY_MULTIPLE_DELIMITER.'1'.MAX_DELIVERY_MULTIPLE_DELIMITER;
        $this->assertEqual($GLOBALS['_MAX']['CHANNELS'], $expect);
    }

    /**
     * This function first checks to see if a viewerId is present
     *   This is so that we don't show blocked ads to a user who won't let us set cookies
     * Then it checks if there is a "last seen" timestamp for this ad present, if so it compares
     * that against the current time, and only
     *
     * @param integer $bannerid The ID of the banner being checked
     * @param integer $block The number of seconds that must pass before this ad can be seen again
     *
     * @return boolean True if the ad IS blocked (and so can't be shown) false if the ad is not blocked
     *                 and so can be shown.
     */
    function test_MAX_limitationsIsAdBlocked()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        // Blocking is disabled for clients, if we had no viewerId passed in
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;

        // Test 1 - $block = 0 so no block on this ad
        $bannerid   = 123;
        $block      = 0;
        $return     = MAX_limitationsIsAdBlocked($bannerid, $block);
        $this->assertFalse($return);

        // Test 2 - 30 second block and "lastSeen" set to now()
        $bannerid   = 123;
        $block      = 30;
        $_COOKIE[$conf['var']['blockAd']][$bannerid] = time();
        $return     = MAX_limitationsIsAdBlocked($bannerid, $block);
        $this->assertTrue($return);

        // Test 3 - 30 second block and "lastSeen" set to 60seconds ago
        $bannerid   = 123;
        $block      = 30;
        $_COOKIE[$conf['var']['blockAd']][$bannerid] = time()-60;
        $return     = MAX_limitationsIsAdBlocked($bannerid, $block);
        $this->assertFalse($return);

        // Test 4 - NewViewerID so ad should be blocked regardless
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = true;
        $bannerid   = 123;
        $block      = 30;
        $_COOKIE[$conf['var']['blockAd']][$bannerid] = time()-60;
        $return     = MAX_limitationsIsAdBlocked($bannerid, $block);
        $this->assertTrue($return);
    }


    /**
     * This function first checks to see if a viewerId is present
     *   This is so that we don't show capped ads to a user who won't let us set cookies
     * Then it checks if there is a "number of times seen" count for this ad present,
     *   if so it compares that against the maximum times to show this ad
     *
     * @param integer $bannerid
     * @param integer $capping
     * @param integer $session_capping
     *
     * @return boolean True - This ad has already been seen the maximum number of times
     *                 False - This ad can be seen
     */
    function test_MAX_limitationsIsAdCapped()
    {
        // Capping is disabled for clients, if we had no viewerId passed in
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;

        $conf = $GLOBALS['_MAX']['CONF'];

        // Test 1 - No capping
        $bannerid           = 123;
        $capping            = 0;
        $session_capping    = 0;
        $return = MAX_limitationsIsAdCapped($bannerid, $capping, $session_capping);
        $this->assertFalse($return);

        // Test 2 - Session capping of 3 "timesSeen" not set
        $bannerid           = 123;
        $capping            = 0;
        $session_capping    = 3;
        $return = MAX_limitationsIsAdCapped($bannerid, $capping, $session_capping);
        $this->assertFalse($return);

        // Test 3 - Session capping of 3 and "timesSeen" set to 3
        $bannerid           = 123;
        $capping            = 0;
        $session_capping    = 3;
        $_COOKIE[$conf['var']['sessionCapAd']][$bannerid] = 3;
        $return = MAX_limitationsIsAdCapped($bannerid, $capping, $session_capping);
        $this->assertTrue($return);

        // Test 4 - Capping of 3 and "timesSeen" not set
        $bannerid           = 123;
        $capping            = 3;
        $session_capping    = 0;
        unset($_COOKIE[$conf['var']['capAd']][$bannerid]);
        $return = MAX_limitationsIsAdCapped($bannerid, $capping, $session_capping);
        $this->assertFalse($return);

        // Test 5 - Capping of 3 and "timesSeen" set to 3
        $bannerid           = 123;
        $capping            = 3;
        $session_capping    = 0;
        $_COOKIE[$conf['var']['capAd']][$bannerid] = 3;
        $return = MAX_limitationsIsAdCapped($bannerid, $capping, $session_capping);
        $this->assertTrue($return);

        // Now pretend this is a viewer with no viewerId passed in
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = true;

        // Test 6 - newViewerId set to true - session capping should return true regardless
        $bannerid           = 123;
        $capping            = 0;
        $session_capping    = 3;
        unset($_COOKIE[$conf['var']['sessionCapAd']][$bannerid]);
        $return = MAX_limitationsIsAdCapped($bannerid, $capping, $session_capping);
        $this->assertTrue($return);

        // Test 7 - newViewerId set to true - capping should return true regardless
        $bannerid           = 123;
        $capping            = 3;
        $session_capping    = 0;
        unset($_COOKIE[$conf['var']['capAd']][$bannerid]);
        $return = MAX_limitationsIsAdCapped($bannerid, $capping, $session_capping);
        $this->assertTrue($return);
    }


    function test_MAX_limitationsIsZoneBlocked()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        // Blocking is disabled for clients, if we had no viewerId passed in
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $zoneId   = 123;

        // Test 1 - $block = 0 so no block on this ad
        $this->assertFalse(MAX_limitationsIsZoneBlocked($zoneId, 0));

        // Test 2 - 30 second block and "lastSeen" set to now()
        $_COOKIE[$conf['var']['blockZone']][$zoneId] = time();
        $this->assertTrue(MAX_limitationsIsZoneBlocked($zoneId, 30));

        // Test 3 - 30 second block and "lastSeen" set to 60seconds ago
        $_COOKIE[$conf['var']['blockZone']][$zoneId] = time()-60;
        $this->assertFalse(MAX_limitationsIsZoneBlocked($zoneId, 30));

        // Test 4 - NewViewerID so ad should be blocked regardless
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = true;
        $_COOKIE[$conf['var']['blockZone']][$zoneId] = time()-60;
        $this->assertTrue(MAX_limitationsIsZoneBlocked($zoneId, 30));
    }
}

?>