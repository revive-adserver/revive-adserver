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
