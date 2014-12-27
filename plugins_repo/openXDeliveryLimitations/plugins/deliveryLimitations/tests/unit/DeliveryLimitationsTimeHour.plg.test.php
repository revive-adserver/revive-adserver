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
require_once dirname(dirname(dirname(__FILE__))) . '/Time/Hour.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Time_Hour class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Time_Hour extends UnitTestCase
{
    function testCheckTimeHour()
    {
        OA_setTimeZoneUTC();

        // =~ and !~ - Single value
        $this->assertTrue(MAX_checkTime_Hour('3',      '=~', array('timestamp' => mktime(3, 0, 0, 7, 1, 2009))));
        $this->assertTrue(MAX_checkTime_Hour('3',      '!~', array('timestamp' => mktime(4, 0, 0, 7, 1, 2009))));

        // =~ and !~ - Multiple value
        $this->assertTrue(MAX_checkTime_Hour('1,3,4',  '=~', array('timestamp' => mktime(1, 0, 0, 7, 1, 2009))));
        $this->assertTrue(MAX_checkTime_Hour('1,3,4',  '=~', array('timestamp' => mktime(4, 0, 0, 7, 1, 2009))));
        $this->assertTrue(MAX_checkTime_Hour('1,3,4',  '!~', array('timestamp' => mktime(5, 0, 0, 7, 1, 2009))));
        $this->assertFalse(MAX_checkTime_Hour('1,3,4', '!~', array('timestamp' => mktime(3, 0, 0, 7, 1, 2009))));

        // =~ and !~ - Single value with TZ
        $this->assertTrue(MAX_checkTime_Hour('5@Europe/Rome',      '=~', array('timestamp' => mktime(3, 0, 0, 7, 1, 2009))));
        $this->assertTrue(MAX_checkTime_Hour('5@Europe/Rome',      '!~', array('timestamp' => mktime(4, 0, 0, 7, 1, 2009))));

        // =~ and !~ - Multiple value with TZ
        $this->assertTrue(MAX_checkTime_Hour('3,5,6@Europe/Rome',  '=~', array('timestamp' => mktime(1, 0, 0, 7, 1, 2009))));
        $this->assertTrue(MAX_checkTime_Hour('3,5,6@Europe/Rome',  '=~', array('timestamp' => mktime(4, 0, 0, 7, 1, 2009))));
        $this->assertTrue(MAX_checkTime_Hour('3,5,6@Europe/Rome',  '!~', array('timestamp' => mktime(5, 0, 0, 7, 1, 2009))));
        $this->assertFalse(MAX_checkTime_Hour('3,5,6@Europe/Rome', '!~', array('timestamp' => mktime(3, 0, 0, 7, 1, 2009))));

        OA_setTimeZoneLocal();
    }
}

?>
