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

require_once MAX_PATH . '/lib/OX/Upgrade/MarketClientFactory.php';


/**
 * A class for testing the market client factory 
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_Upgrade_InstallConfigTest extends UnitTestCase 
{
    
    function testGetMarketClient()
    {
        $result = OX_Upgrade_MarketClientFactory::getMarketClient();
        $this->assertIsA($result, 'OX_Dal_Market_RegistrationClient');
    }
    
}

?>
