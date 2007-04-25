<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/max/Delivery/common.php';
require_once MAX_PATH . '/lib/max/Delivery/limitations.php';

/**
 * A class for testing the limitations.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 * @author     Monique Szpak <monique.szpak@openads.org>
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
     * A method test the MAX_limitationsCheckAcl function.
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
     * A method to test the _limitationsIsAdBlocked function.
     */
    function test_limitationsIsAdBlocked()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        // Test 1: No blocking
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $adId   = 123;
        $block  = 0;
        $return = _limitationsIsAdBlocked($adId, $block);
        $this->assertFalse($return);

        // Test 2: 30 second block and "lastSeen" set to now()
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['blockAd']][$adId] = time();
        $adId   = 123;
        $block  = 30;
        $return = _limitationsIsAdBlocked($adId, $block);
        $this->assertTrue($return);

        // Test 3: 30 second block and "lastSeen" set to 60 seconds ago
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['blockAd']][$adId] = time()-60;
        $adId   = 123;
        $block  = 30;
        $return = _limitationsIsAdBlocked($adId, $block);
        $this->assertFalse($return);

        // Test 4: newViewerId cookie set
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = true;
        $_COOKIE[$conf['var']['blockAd']][$adId] = time()-60;
        $adId   = 123;
        $block  = 30;
        $return = _limitationsIsAdBlocked($adId, $block);
        $this->assertTrue($return);
    }

    /**
     * A method to test the _limitationsIsAdCapped function.
     */
    function test_limitationsIsAdCapped()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        // Test 1: No capping
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        unset($_COOKIE[$conf['var']['capAd']][$adId]);
        unset($_COOKIE[$conf['var']['sessionCapAd']][$adId]);
        $adId       = 123;
        $cap        = 0;
        $sessionCap = 0;
        $return = _limitationsIsAdCapped($adId, $cap, $sessionCap);
        $this->assertFalse($return);

        // Test 2: Cap of 3, not seen yet
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        unset($_COOKIE[$conf['var']['capAd']][$adId]);
        unset($_COOKIE[$conf['var']['sessionCapAd']][$adId]);
        $adId       = 123;
        $cap        = 3;
        $sessionCap = 0;
        $return = _limitationsIsAdCapped($adId, $cap, $sessionCap);
        $this->assertFalse($return);

        // Test 3: Cap of 3, seen two times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['capAd']][$adId] = 2;
        $adId       = 123;
        $cap        = 3;
        $sessionCap = 0;
        $return = _limitationsIsAdCapped($adId, $cap, $sessionCap);
        $this->assertFalse($return);

        // Test 4: Cap of 3, seen three times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['capAd']][$adId] = 3;
        $adId       = 123;
        $cap        = 3;
        $sessionCap = 0;
        $return = _limitationsIsAdCapped($adId, $cap, $sessionCap);
        $this->assertTrue($return);

        // Test 5: Cap of 3, seen four times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['capAd']][$adId] = 4;
        $adId       = 123;
        $cap        = 3;
        $sessionCap = 0;
        $return = _limitationsIsAdCapped($adId, $cap, $sessionCap);
        $this->assertTrue($return);

        // Test 6: Session cap of 3, not seen yet
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        unset($_COOKIE[$conf['var']['capAd']][$adId]);
        unset($_COOKIE[$conf['var']['sessionCapAd']][$adId]);
        $adId       = 123;
        $cap        = 0;
        $sessionCap = 3;
        $return = _limitationsIsAdCapped($adId, $cap, $sessionCap);
        $this->assertFalse($return);

        // Test 7: Session cap of 3, seen two times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['sessionCapAd']][$adId] = 2;
        $adId       = 123;
        $cap        = 0;
        $sessionCap = 3;
        $return = _limitationsIsAdCapped($adId, $cap, $sessionCap);
        $this->assertFalse($return);

        // Test 8: Session cap of 3, seen three times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['sessionCapAd']][$adId] = 3;
        $adId       = 123;
        $cap        = 0;
        $sessionCap = 3;
        $return = _limitationsIsAdCapped($adId, $cap, $sessionCap);
        $this->assertTrue($return);

        // Test 9: Session cap of 3, seen four times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['sessionCapAd']][$adId] = 4;
        $adId       = 123;
        $cap        = 0;
        $sessionCap = 3;
        $return = _limitationsIsAdCapped($adId, $cap, $sessionCap);
        $this->assertTrue($return);

        // Test 10: newViewerId cookie set
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = true;
        unset($_COOKIE[$conf['var']['capAd']][$adId]);
        unset($_COOKIE[$conf['var']['sessionCapAd']][$adId]);
        $adId       = 123;
        $cap        = 3;
        $sessionCap = 0;
        $return = _limitationsIsAdCapped($adId, $cap, $sessionCap);
        $this->assertTrue($return);

        // Test 11: newViewerId cookie set
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = true;
        unset($_COOKIE[$conf['var']['capAd']][$adId]);
        unset($_COOKIE[$conf['var']['sessionCapAd']][$adId]);
        $adId       = 123;
        $cap        = 0;
        $sessionCap = 3;
        $return = _limitationsIsAdCapped($adId, $cap, $sessionCap);
        $this->assertTrue($return);
    }

    /**
     * A method to test the _limitationsIsCampaignBlocked function.
     */
    function test_limitationsIsCampaignBlocked()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        // Test 1: No blocking
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $adId   = 123;
        $block  = 0;
        $return = _limitationsIsCampaignBlocked($adId, $block);
        $this->assertFalse($return);

        // Test 2: 30 second block and "lastSeen" set to now()
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['blockCampaign']][$adId] = time();
        $adId   = 123;
        $block  = 30;
        $return = _limitationsIsCampaignBlocked($adId, $block);
        $this->assertTrue($return);

        // Test 3: 30 second block and "lastSeen" set to 60 seconds ago
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['blockCampaign']][$adId] = time()-60;
        $adId   = 123;
        $block  = 30;
        $return = _limitationsIsCampaignBlocked($adId, $block);
        $this->assertFalse($return);

        // Test 4: newViewerId cookie set
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = true;
        $_COOKIE[$conf['var']['blockCampaign']][$adId] = time()-60;
        $adId   = 123;
        $block  = 30;
        $return = _limitationsIsCampaignBlocked($adId, $block);
        $this->assertTrue($return);
    }

    /**
     * A method to test the _limitationsIsCampaignCapped function.
     */
    function test_limitationsIsCampaignCapped()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        // Test 1: No capping
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        unset($_COOKIE[$conf['var']['capCampaign']][$adId]);
        unset($_COOKIE[$conf['var']['sessionCapCampaign']][$adId]);
        $adId       = 123;
        $cap        = 0;
        $sessionCap = 0;
        $return = _limitationsIsCampaignCapped($adId, $cap, $sessionCap);
        $this->assertFalse($return);

        // Test 2: Cap of 3, not seen yet
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        unset($_COOKIE[$conf['var']['capCampaign']][$adId]);
        unset($_COOKIE[$conf['var']['sessionCapCampaign']][$adId]);
        $adId       = 123;
        $cap        = 3;
        $sessionCap = 0;
        $return = _limitationsIsCampaignCapped($adId, $cap, $sessionCap);
        $this->assertFalse($return);

        // Test 3: Cap of 3, seen two times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['capCampaign']][$adId] = 2;
        $adId       = 123;
        $cap        = 3;
        $sessionCap = 0;
        $return = _limitationsIsCampaignCapped($adId, $cap, $sessionCap);
        $this->assertFalse($return);

        // Test 4: Cap of 3, seen three times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['capCampaign']][$adId] = 3;
        $adId       = 123;
        $cap        = 3;
        $sessionCap = 0;
        $return = _limitationsIsCampaignCapped($adId, $cap, $sessionCap);
        $this->assertTrue($return);

        // Test 5: Cap of 3, seen four times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['capCampaign']][$adId] = 4;
        $adId       = 123;
        $cap        = 3;
        $sessionCap = 0;
        $return = _limitationsIsCampaignCapped($adId, $cap, $sessionCap);
        $this->assertTrue($return);

        // Test 6: Session cap of 3, not seen yet
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        unset($_COOKIE[$conf['var']['capCampaign']][$adId]);
        unset($_COOKIE[$conf['var']['sessionCapCampaign']][$adId]);
        $adId       = 123;
        $cap        = 0;
        $sessionCap = 3;
        $return = _limitationsIsCampaignCapped($adId, $cap, $sessionCap);
        $this->assertFalse($return);

        // Test 7: Session cap of 3, seen two times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['sessionCapCampaign']][$adId] = 2;
        $adId       = 123;
        $cap        = 0;
        $sessionCap = 3;
        $return = _limitationsIsCampaignCapped($adId, $cap, $sessionCap);
        $this->assertFalse($return);

        // Test 8: Session cap of 3, seen three times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['sessionCapCampaign']][$adId] = 3;
        $adId       = 123;
        $cap        = 0;
        $sessionCap = 3;
        $return = _limitationsIsCampaignCapped($adId, $cap, $sessionCap);
        $this->assertTrue($return);

        // Test 9: Session cap of 3, seen four times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['sessionCapCampaign']][$adId] = 4;
        $adId       = 123;
        $cap        = 0;
        $sessionCap = 3;
        $return = _limitationsIsCampaignCapped($adId, $cap, $sessionCap);
        $this->assertTrue($return);

        // Test 10: newViewerId cookie set
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = true;
        unset($_COOKIE[$conf['var']['capCampaign']][$adId]);
        unset($_COOKIE[$conf['var']['sessionCapCampaign']][$adId]);
        $adId       = 123;
        $cap        = 3;
        $sessionCap = 0;
        $return = _limitationsIsCampaignCapped($adId, $cap, $sessionCap);
        $this->assertTrue($return);

        // Test 11: newViewerId cookie set
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = true;
        unset($_COOKIE[$conf['var']['capCampaign']][$adId]);
        unset($_COOKIE[$conf['var']['sessionCapCampaign']][$adId]);
        $adId       = 123;
        $cap        = 0;
        $sessionCap = 3;
        $return = _limitationsIsCampaignCapped($adId, $cap, $sessionCap);
        $this->assertTrue($return);
    }

    /**
     * A method to test the _limitationsIsZoneBlocked function.
     */
    function test_limitationsIsZoneBlocked()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        // Test 1: No blocking
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $zoneId = 123;
        $block  = 0;
        $return = _limitationsIsZoneBlocked($zoneId, $block);
        $this->assertFalse($return);

        // Test 2: 30 second block and "lastSeen" set to now()
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['blockZone']][$zoneId] = time();
        $zoneId = 123;
        $block  = 30;
        $return = _limitationsIsZoneBlocked($zoneId, $block);
        $this->assertTrue($return);

        // Test 3: 30 second block and "lastSeen" set to 60 seconds ago
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['blockZone']][$zoneId] = time()-60;
        $zoneId = 123;
        $block  = 30;
        $return = _limitationsIsZoneBlocked($zoneId, $block);
        $this->assertFalse($return);

        // Test 4: newViewerId cookie set
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = true;
        $_COOKIE[$conf['var']['blockZone']][$zoneId] = time()-60;
        $zoneId = 123;
        $block  = 30;
        $return = _limitationsIsZoneBlocked($zoneId, $block);
        $this->assertTrue($return);
    }

    /**
     * A method to test the _limitationsIsZoneCapped function.
     */
    function test_limitationsIsZoneCapped()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        // Test 1: No capping
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        unset($_COOKIE[$conf['var']['capZone']][$zoneId]);
        unset($_COOKIE[$conf['var']['sessionCapZone']][$zoneId]);
        $zoneId     = 123;
        $cap        = 0;
        $sessionCap = 0;
        $return = _limitationsIsZoneCapped($zoneId, $cap, $sessionCap);
        $this->assertFalse($return);

        // Test 2: Cap of 3, not seen yet
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        unset($_COOKIE[$conf['var']['capZone']][$zoneId]);
        unset($_COOKIE[$conf['var']['sessionCapZone']][$zoneId]);
        $zoneId     = 123;
        $cap        = 3;
        $sessionCap = 0;
        $return = _limitationsIsZoneCapped($zoneId, $cap, $sessionCap);
        $this->assertFalse($return);

        // Test 3: Cap of 3, seen two times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['capZone']][$zoneId] = 2;
        $zoneId     = 123;
        $cap        = 3;
        $sessionCap = 0;
        $return = _limitationsIsZoneCapped($zoneId, $cap, $sessionCap);
        $this->assertFalse($return);

        // Test 4: Cap of 3, seen three times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['capZone']][$zoneId] = 3;
        $zoneId     = 123;
        $cap        = 3;
        $sessionCap = 0;
        $return = _limitationsIsZoneCapped($zoneId, $cap, $sessionCap);
        $this->assertTrue($return);

        // Test 5: Cap of 3, seen four times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['capZone']][$zoneId] = 4;
        $zoneId     = 123;
        $cap        = 3;
        $sessionCap = 0;
        $return = _limitationsIsZoneCapped($zoneId, $cap, $sessionCap);
        $this->assertTrue($return);

        // Test 6: Session cap of 3, not seen yet
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        unset($_COOKIE[$conf['var']['capZone']][$zoneId]);
        unset($_COOKIE[$conf['var']['sessionCapZone']][$zoneId]);
        $zoneId     = 123;
        $cap        = 0;
        $sessionCap = 3;
        $return = _limitationsIsZoneCapped($zoneId, $cap, $sessionCap);
        $this->assertFalse($return);

        // Test 7: Session cap of 3, seen two times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['sessionCapZone']][$zoneId] = 2;
        $zoneId     = 123;
        $cap        = 0;
        $sessionCap = 3;
        $return = _limitationsIsZoneCapped($zoneId, $cap, $sessionCap);
        $this->assertFalse($return);

        // Test 8: Session cap of 3, seen three times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['sessionCapZone']][$zoneId] = 3;
        $zoneId     = 123;
        $cap        = 0;
        $sessionCap = 3;
        $return = _limitationsIsZoneCapped($zoneId, $cap, $sessionCap);
        $this->assertTrue($return);

        // Test 9: Session cap of 3, seen four times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$conf['var']['sessionCapZone']][$zoneId] = 4;
        $zoneId     = 123;
        $cap        = 0;
        $sessionCap = 3;
        $return = _limitationsIsZoneCapped($zoneId, $cap, $sessionCap);
        $this->assertTrue($return);

        // Test 10: newViewerId cookie set
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = true;
        unset($_COOKIE[$conf['var']['capZone']][$zoneId]);
        unset($_COOKIE[$conf['var']['sessionCapZone']][$zoneId]);
        $zoneId     = 123;
        $cap        = 3;
        $sessionCap = 0;
        $return = _limitationsIsZoneCapped($zoneId, $cap, $sessionCap);
        $this->assertTrue($return);

        // Test 11: newViewerId cookie set
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = true;
        unset($_COOKIE[$conf['var']['capZone']][$zoneId]);
        unset($_COOKIE[$conf['var']['sessionCapZone']][$zoneId]);
        $zoneId     = 123;
        $cap        = 0;
        $sessionCap = 3;
        $return = _limitationsIsZoneCapped($zoneId, $cap, $sessionCap);
        $this->assertTrue($return);
    }

}

?>