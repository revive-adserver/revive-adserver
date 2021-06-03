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
require_once dirname(dirname(dirname(__FILE__))) . '/Time/Day.delivery.php';

Language_Loader::load();

/**
 * A class for testing the Plugins_DeliveryLimitations_Time_Day class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Time_Day extends UnitTestCase
{
    function testCheckTimeDay()
    {
        OA_setTimeZoneUTC();

        // =~ and !~ - Single value
        $this->assertTrue(MAX_checkTime_Day('3',      '=~', array('timestamp' => mktime(0, 0, 0, 7, 1, 2009)))); // Wed
        $this->assertTrue(MAX_checkTime_Day('3',      '!~', array('timestamp' => mktime(0, 0, 0, 7, 2, 2009)))); // Thu

        // =~ and !~ - Multiple value
        $this->assertTrue(MAX_checkTime_Day('1,3,4',  '=~', array('timestamp' => mktime(0, 0, 0, 7, 6, 2009)))); // Mon
        $this->assertTrue(MAX_checkTime_Day('1,3,4',  '=~', array('timestamp' => mktime(0, 0, 0, 7, 2, 2009)))); // Thu
        $this->assertTrue(MAX_checkTime_Day('1,3,4',  '!~', array('timestamp' => mktime(0, 0, 0, 7, 3, 2009)))); // Fri
        $this->assertFalse(MAX_checkTime_Day('1,3,4', '!~', array('timestamp' => mktime(0, 0, 0, 7, 1, 2009)))); // Wed

        // =~ and !~ - Single value with TZ
        $this->assertTrue(MAX_checkTime_Day('2@America/New_York',      '=~', array('timestamp' => mktime(0, 0, 0, 7, 1, 2009)))); // Wed
        $this->assertTrue(MAX_checkTime_Day('2@America/New_York',      '!~', array('timestamp' => mktime(0, 0, 0, 7, 2, 2009)))); // Thu

        // =~ and !~ - Multiple value with TZ
        $this->assertTrue(MAX_checkTime_Day('0,2,3@America/New_York',  '=~', array('timestamp' => mktime(0, 0, 0, 7, 6, 2009)))); // Mon
        $this->assertTrue(MAX_checkTime_Day('0,2,3@America/New_York',  '=~', array('timestamp' => mktime(0, 0, 0, 7, 2, 2009)))); // Thu
        $this->assertTrue(MAX_checkTime_Day('0,2,3@America/New_York',  '!~', array('timestamp' => mktime(0, 0, 0, 7, 3, 2009)))); // Fri
        $this->assertFalse(MAX_checkTime_Day('0,2,3@America/New_York', '!~', array('timestamp' => mktime(0, 0, 0, 7, 1, 2009)))); // Wed

        OA_setTimeZoneLocal();
    }
}

?>
