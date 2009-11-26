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

require_once MAX_PATH . '/lib/max/Delivery/common.php';
require_once MAX_PATH . '/lib/max/Delivery/limitations.php';

/**
 * A class for testing the limitations.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Monique Szpak <monique.szpak@openx.org>
 */
class Test_DeliveryLimitations extends UnitTestCase
{

    var $tmpCookie;

    /**
     * The constructor method.
     */
    function __construct()
    {
        $this->UnitTestCase();
    }

    /**
     * This setUp method is being used to install a package which contains (at the moment only one)
     * test (Dummy) plugins which are then used by the test scripts to test the extension point integrations.
     *
     */
    function setUp()
    {
        //install the package of test (dummy) plugins for testing the extension points
        unset($GLOBALS['_MAX']['CONF']['plugins']['openXTests']);
        unset($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['Dummy']);

        TestEnv::installPluginPackage('openXTests');

        MAX_commonInitVariables();
        $this->tmpCookie = $_COOKIE;
        $_COOKIE = array();
    }

    function tearDown()
    {
        $_COOKIE = $this->tmpCookie;
        // Uninstall
        TestEnv::uninstallPluginPackage('openXTests');
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

        // Test of dummy deliveryLimitation plugin
        $row['compiledlimitation']  = '(MAX_checkDummy_Dummy(\'1\', \'==\')) and (MAX_checkDummy_Dummy(\'2\', \'==\'))';
        $row['acl_plugins']         = 'deliveryLimitations:Dummy:Dummy';
        $return = MAX_limitationsCheckAcl($row, $source);
        $this->assertTrue($return);
    }

    /**
     * A method to test the _limitationsIsAdCapped function.
     *
     * @TODO Needs to be update to test ad capping & blocking.
     */
    function test_limitationsIsAdCapped()
    {
        $this->_testIsThingCapped('Ad');
    }

    /**
     * A method to test the _limitationsIsCampaignCapped function.
     *
     * @TODO Needs to be update to test campaign capping & blocking.
     */
    function test_limitationsIsCampaignCapped()
    {
        $this->_testIsThingCapped('Campaign');
    }

    /**
     * A method to test the _limitationsIsZoneCapped function.
     *
     * @TODO Needs to be update to test zone capping & blocking.
     */
    function broken_test_limitationsIsZoneCapped()
    {
        $this->_testIsThingCapped('Zone');
    }

    function _testIsThingCapped($thing) {
        $conf = $GLOBALS['_MAX']['CONF'];
        $now = MAX_commonGetTimeNow();

        switch($thing) {
            case 'Ad':
                $functionName           = '_limitationsIsAdCapped';
                $capCookieName          = $conf['var']['capAd'];
                $sessionCapCookieName   = $conf['var']['sessionCapAd'];
                $blockCookieName        = $conf['var']['blockAd'];
                break;
            case 'Campaign':
                $functionName           = '_limitationsIsCampaignCapped';
                $capCookieName          = $conf['var']['capCampaign'];
                $sessionCapCookieName   = $conf['var']['sessionCapCampaign'];
                $blockCookieName        = $conf['var']['blockCampaign'];
                break;
            case 'Zone':
                $functionName           = '_limitationsIsZoneCapped';
                $capCookieName          = $conf['var']['capZone'];
                $sessionCapCookieName   = $conf['var']['sessionCapZone'];
                $blockCookieName        = $conf['var']['blockZone'];
        }

        // Test 1: No capping
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $id         = 123;
        $cap        = 0;
        $sessionCap = 0;
        $block      = 0;
        $showCappedNoCookie = 0;
        unset($_COOKIE[$capCookieName][$id]);
        unset($_COOKIE[$sessionCapCookieName][$id]);
        $return = $functionName($id, $cap, $sessionCap, $block, $showCappedNoCookie);
        $this->assertFalse($return);

        // Test 2: Cap of 3, not seen yet
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $id       = 123;
        $cap        = 3;
        $sessionCap = 0;
        $block      = 0;
        $showCappedNoCookie = 0;
        unset($_COOKIE[$capCookieName][$id]);
        unset($_COOKIE[$sessionCapCookieName][$id]);
        $return = $functionName($id, $cap, $sessionCap, $block, $showCappedNoCookie);
        $this->assertFalse($return);

        // Test 3: Cap of 3, seen two times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $id       = 123;
        $cap        = 3;
        $sessionCap = 0;
        $block      = 0;
        $showCappedNoCookie = 0;
        $_COOKIE[$capCookieName][$id] = 2;
        $return = $functionName($id, $cap, $sessionCap, $block, $showCappedNoCookie);
        $this->assertFalse($return);

        // Test 4: Cap of 3, seen three times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $id       = 123;
        $cap        = 3;
        $sessionCap = 0;
        $block      = 0;
        $showCappedNoCookie = 0;
        $_COOKIE[$capCookieName][$id] = 3;
        $return = $functionName($id, $cap, $sessionCap, $block, $showCappedNoCookie);
        $this->assertTrue($return);

        // Test 5: Cap of 3, seen four times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $id       = 123;
        $cap        = 3;
        $sessionCap = 0;
        $block      = 0;
        $showCappedNoCookie = 0;
        $_COOKIE[$capCookieName][$id] = 4;
        $return = $functionName($id, $cap, $sessionCap, $block, $showCappedNoCookie);
        $this->assertTrue($return);

        // Test 6: Session cap of 3, not seen yet
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $id       = 123;
        $cap        = 0;
        $sessionCap = 3;
        $block      = 0;
        $showCappedNoCookie = 0;
        unset($_COOKIE[$capCookieName][$id]);
        unset($_COOKIE[$sessionCapCookieName][$id]);
        $return = $functionName($id, $cap, $sessionCap, $block, $showCappedNoCookie);
        $this->assertFalse($return);

        // Test 7: Session cap of 3, seen two times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $id       = 123;
        $cap        = 0;
        $sessionCap = 3;
        $block      = 0;
        $showCappedNoCookie = 0;
        $_COOKIE[$sessionCapCookieName][$id] = 2;
        $return = $functionName($id, $cap, $sessionCap, $block, $showCappedNoCookie);
        $this->assertFalse($return);

        // Test 8: Session cap of 3, seen three times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $id       = 123;
        $cap        = 0;
        $sessionCap = 3;
        $block      = 0;
        $showCappedNoCookie = 0;
        $_COOKIE[$sessionCapCookieName][$id] = 3;
        $return = $functionName($id, $cap, $sessionCap, $block, $showCappedNoCookie);
        $this->assertTrue($return);

        // Test 9: Session cap of 3, seen four times
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $id       = 123;
        $cap        = 0;
        $sessionCap = 3;
        $block      = 0;
        $showCappedNoCookie = 0;
        $_COOKIE[$sessionCapCookieName][$id] = 4;
        $return = $functionName($id, $cap, $sessionCap, $block, $showCappedNoCookie);
        $this->assertTrue($return);

        // Test 10: First impression (cap = 2, block = 60s)
        $id       = 123;
        $cap        = 0;
        $sessionCap = 2;
        $block      = 60;
        $showCappedNoCookie = 0;
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        unset($_COOKIE[$sessionCapCookieName][$id]);
        unset($_COOKIE[$blockCookieName][$id]);
        $return = $functionName($id, $cap, $sessionCap, $block, $showCappedNoCookie);
        $this->assertFalse($return);

        // Test 11: Second impression (cap = 2, block 60s)
        $id       = 123;
        $cap        = 0;
        $sessionCap = 2;
        $block      = 60;
        $showCappedNoCookie = 0;
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$sessionCapCookieName][$id] = 1;
        $_COOKIE[$blockCookieName][$id] = $now - ($block - 1);
        $return = $functionName($id, $cap, $sessionCap, $block, $showCappedNoCookie);
        $this->assertFalse($return);

        // Test 12: Third impression within block (cap = 2, block 60s)
        $id       = 123;
        $cap        = 0;
        $sessionCap = 2;
        $block      = 60;
        $showCappedNoCookie = 0;
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$sessionCapCookieName][$id] = 2;
        $_COOKIE[$blockCookieName][$id] = $now - ($block - 1);
        $return = $functionName($id, $cap, $sessionCap, $block, $showCappedNoCookie);
        $this->assertTrue($return);

        // Test 13: Third impression outside block (cap = 2, block = 60s)
        $id       = 123;
        $cap        = 0;
        $sessionCap = 2;
        $block      = 60;
        $showCappedNoCookie = 0;
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = false;
        $_COOKIE[$sessionCapCookieName][$id] = 2;
        $_COOKIE[$blockCookieName][$id] = $now - ($block + 1);
        $return = $functionName($id, $cap, $sessionCap, $block, $showCappedNoCookie);
        $this->assertFalse($return);

        // Test 10: newViewerId cookie set
        $id       = 123;
        $cap        = 3;
        $sessionCap = 0;
        $block      = 0;
        $showCappedNoCookie = 0;
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = true;
        unset($_COOKIE[$capCookieName][$id]);
        unset($_COOKIE[$sessionCapCookieName][$id]);
        $return = $functionName($id, $cap, $sessionCap, $block, $showCappedNoCookie);
        $this->assertTrue($return);
    }
}

?>