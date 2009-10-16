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
$Id: PlatformHashManager.up.test.php 42754 2009-09-07 13:19:02Z lukasz.wikierski $
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
