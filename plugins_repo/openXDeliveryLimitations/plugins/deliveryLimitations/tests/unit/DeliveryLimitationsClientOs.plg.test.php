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

require_once MAX_PATH . '/lib/max/Plugin.php';
// Using multi-dirname so that the tests can run from either plugins or plugins_repo
require_once dirname(dirname(dirname(__FILE__))) . '/Client/Os.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Client_Os class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Client_Os extends UnitTestCase
{
    function testMAX_checkClient_Os()
    {
        $this->assertTrue(MAX_checkClient_Os('xp,2k', '=~', array('os' => 'xp')));
    }
}

?>
