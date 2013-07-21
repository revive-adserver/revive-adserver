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

require_once MAX_PATH . '/lib/OX/Upgrade/Util/PlatformHashManager.php';


/**
 * A class for testing the Platform Hash Manager
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_Upgrade_Util_PlatformHashManagerTest extends UnitTestCase 
{
    
    function testGetPlatformHash()
    {
        // try to read platform hash from database if it's upgrade
        $GLOBALS['_MAX']['CONF']['openads']['installed'] = false;
        $GLOBALS['_MAX']['CONF']['max']['installed'] = true;
        $oPhManager = new OX_Upgrade_Util_PlatformHashManager();
        $result = $oPhManager->getPlatformHash();
        $this->assertEqual($result, 'OXP_upgrade-unknown_platform_hash');
        
        // read cached results - remove all checked config/install files
        $GLOBALS['_MAX']['CONF']['openads']['installed'] = false;
        $GLOBALS['_MAX']['CONF']['max']['installed'] = false;
        @unlink(MAX_PATH.'/var/config.inc.php');
        @unlink(MAX_PATH.'/var/INSTALLED');
        
        $result = $oPhManager->getPlatformHash();
        $this->assertEqual($result, 'OXP_upgrade-unknown_platform_hash');
        
        // force procedure - will generate platform hash
        $result = $oPhManager->getPlatformHash(null, true);
        $this->assertNotEqual($result, 'OXP_upgrade-unknown_platform_hash');
        $this->assertPattern('/[0-9a-fA-F]{40}/', $result);
        $expected = $result;
        
        // Should return last generated platform hash
        $result = $oPhManager->getPlatformHash(null, true);
        $this->assertEqual($expected, $result);
        
        // Should ignore suggested if there is generated platform hash
        $result = $oPhManager->getPlatformHash('suggested', true);
        $this->assertEqual($expected, $result);
    }
    
}

?>
