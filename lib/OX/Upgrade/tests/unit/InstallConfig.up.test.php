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
 */
class OX_Upgrade_InstallConfigTest extends UnitTestCase
{

    function testGetConfig()
    {
        $result = OX_Upgrade_InstallConfig::getConfig();
        $config = @parse_ini_file(MAX_PATH . '/etc/dist.conf.php', true);
        $this->assertEqual($result, $config['install']);
    }

}

?>