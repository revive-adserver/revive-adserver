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
require_once dirname(dirname(dirname(__FILE__))) . '/Time/Date.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Time_Date class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Time_Date extends UnitTestCase
{
    function testCheckTimeDay()
    {
        OA_setTimeZoneUTC();

        // All operators, active
        $this->assertTrue(MAX_checkTime_Date('20090701', '==', array('timestamp' => mktime(0, 0, 0, 7, 1, 2009))));
        $this->assertTrue(MAX_checkTime_Date('20090701', '!=', array('timestamp' => mktime(0, 0, 0, 6, 30, 2009))));
        $this->assertTrue(MAX_checkTime_Date('20090701', '!=', array('timestamp' => mktime(0, 0, 0, 7, 2, 2009))));
        $this->assertTrue(MAX_checkTime_Date('20090701', '<',  array('timestamp' => mktime(0, 0, 0, 6, 30, 2009))));
        $this->assertTrue(MAX_checkTime_Date('20090701', '>',  array('timestamp' => mktime(0, 0, 0, 7, 2, 2009))));
        $this->assertTrue(MAX_checkTime_Date('20090701', '<=', array('timestamp' => mktime(0, 0, 0, 7, 1, 2009))));
        $this->assertTrue(MAX_checkTime_Date('20090701', '<=', array('timestamp' => mktime(0, 0, 0, 6, 30, 2009))));
        $this->assertTrue(MAX_checkTime_Date('20090701', '>=', array('timestamp' => mktime(0, 0, 0, 7, 1, 2009))));
        $this->assertTrue(MAX_checkTime_Date('20090701', '>=', array('timestamp' => mktime(0, 0, 0, 7, 2, 2009))));

        // All operators, inactive
        $this->assertFalse(MAX_checkTime_Date('20090701', '==', array('timestamp' => mktime(0, 0, 0, 7, 2, 2009))));
        $this->assertFalse(MAX_checkTime_Date('20090701', '!=', array('timestamp' => mktime(0, 0, 0, 7, 1, 2009))));
        $this->assertFalse(MAX_checkTime_Date('20090701', '<',  array('timestamp' => mktime(0, 0, 0, 7, 1, 2009))));
        $this->assertFalse(MAX_checkTime_Date('20090701', '>',  array('timestamp' => mktime(0, 0, 0, 7, 1, 2009))));
        $this->assertFalse(MAX_checkTime_Date('20090701', '<=', array('timestamp' => mktime(0, 0, 0, 7, 2, 2009))));
        $this->assertFalse(MAX_checkTime_Date('20090701', '>=', array('timestamp' => mktime(0, 0, 0, 6, 30, 2009))));

        // All operators, active with TZ
        $this->assertTrue(MAX_checkTime_Date('20090701@Europe/Rome', '==', array('timestamp' => mktime(0, 0, 0, 7, 1, 2009))));
        $this->assertTrue(MAX_checkTime_Date('20090701@Europe/Rome', '!=', array('timestamp' => mktime(0, 0, 0, 6, 30, 2009))));
        $this->assertTrue(MAX_checkTime_Date('20090701@Europe/Rome', '!=', array('timestamp' => mktime(0, 0, 0, 7, 2, 2009))));
        $this->assertTrue(MAX_checkTime_Date('20090701@Europe/Rome', '<',  array('timestamp' => mktime(0, 0, 0, 6, 30, 2009))));
        $this->assertTrue(MAX_checkTime_Date('20090701@Europe/Rome', '>',  array('timestamp' => mktime(0, 0, 0, 7, 2, 2009))));
        $this->assertTrue(MAX_checkTime_Date('20090701@Europe/Rome', '<=', array('timestamp' => mktime(0, 0, 0, 7, 1, 2009))));
        $this->assertTrue(MAX_checkTime_Date('20090701@Europe/Rome', '<=', array('timestamp' => mktime(0, 0, 0, 6, 30, 2009))));
        $this->assertTrue(MAX_checkTime_Date('20090701@Europe/Rome', '>=', array('timestamp' => mktime(0, 0, 0, 7, 1, 2009))));
        $this->assertTrue(MAX_checkTime_Date('20090701@Europe/Rome', '>=', array('timestamp' => mktime(0, 0, 0, 7, 2, 2009))));

        // All operators, inactive with TZ
        $this->assertFalse(MAX_checkTime_Date('20090701@Europe/Rome', '==', array('timestamp' => mktime(0, 0, 0, 7, 2, 2009))));
        $this->assertFalse(MAX_checkTime_Date('20090701@Europe/Rome', '!=', array('timestamp' => mktime(0, 0, 0, 7, 1, 2009))));
        $this->assertFalse(MAX_checkTime_Date('20090701@Europe/Rome', '<',  array('timestamp' => mktime(0, 0, 0, 7, 1, 2009))));
        $this->assertFalse(MAX_checkTime_Date('20090701@Europe/Rome', '>',  array('timestamp' => mktime(0, 0, 0, 7, 1, 2009))));
        $this->assertFalse(MAX_checkTime_Date('20090701@Europe/Rome', '<=', array('timestamp' => mktime(0, 0, 0, 7, 2, 2009))));
        $this->assertFalse(MAX_checkTime_Date('20090701@Europe/Rome', '>=', array('timestamp' => mktime(0, 0, 0, 6, 30, 2009))));

        OA_setTimeZoneLocal();
    }
}

?>
