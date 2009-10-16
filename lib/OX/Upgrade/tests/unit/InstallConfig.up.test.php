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
$Id: InstallConfig.up.test.php 42753 2009-09-07 12:33:35Z lukasz.wikierski $
*/

require_once MAX_PATH . '/lib/OX/Upgrade/InstallConfig.php';


/**
 * A class for testing the Install Config
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_Upgrade_InstallConfigTest extends UnitTestCase 
{
    
    function testGetConfig()
    {
        $GLOBALS['_MAX']['Conf']['install']['marketPcApiHost'] = 'test';
        $result = OX_Upgrade_InstallConfig::getConfig();
        $config = @parse_ini_file(MAX_PATH . '/etc/dist.conf.php', true);
        $this->assertEqual($result, $config['install']);
        $this->assertTrue(array_key_exists('marketPcApiHost', $result));
        $this->assertNotEqual('test', $results['marketPcApiHost']);
        $this->assertTrue(array_key_exists('fallbackPcApiHost', $result));
        $this->assertTrue(array_key_exists('marketPublicApiUrl', $result));
        $this->assertTrue(array_key_exists('marketCaptchaUrl', $result));
        
        $GLOBALS['_MAX']['Conf']['install']['marketPcApiHost'] = $config['install']['marketPcApiHost'].'123';
        $result = OX_Upgrade_InstallConfig::getConfig();
        $this->assertEqual($result['marketPcApiHost'], $config['install']['marketPcApiHost']);

    }
    
}

?>
