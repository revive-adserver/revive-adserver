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

require_once MAX_PATH . '/lib/OX/Admin/Timezones.php';

/**
 * A class for testing the OX_Admin_Timezones class.
 *
 * @package    OpenXAdmin
 * @subpackage TestSuite
 */
class Test_OX_Admin_Timezones extends UnitTestCase
{

    function testAvailableTimezones()
    {
        global $_DATE_TIMEZONE_DATA;

        // Get time zones
        $aTimezone = OX_Admin_Timezones::availableTimezones(true);

        // Test that it is an array, not empty and contains some items + a blank
        $this->assertTrue(is_array($aTimezone));
        $this->assertTrue(count($aTimezone) > 2);
        $this->assertEqual($aTimezone[0], '');

        // Remove blank element
        array_shift($aTimezone);

        // Check returned data against global array from PEAR::Date
        foreach ($aTimezone as $key => $value) {
            $this->assertTrue(array_key_exists($key, $_DATE_TIMEZONE_DATA));

            // Check label to ensure it was created properly
            $offset = OX_Admin_Timezones::_convertOffset($_DATE_TIMEZONE_DATA[$key]['offset']);
            $offset = ($_DATE_TIMEZONE_DATA[$key]['offset'] >=0) ? 'GMT+'. $offset : 'GMT-'. $offset;
            $this->assertEqual($value, "($offset) $key");
        }
    }

    function testGetTimezone()
    {
        // Set environment variable
        date_default_timezone_set('America/Detroit');
        $timezone = OX_Admin_Timezones::getTimezone();
        $this->assertEqual('America/Detroit', $timezone);
    }

    function testGetConfigTimezoneValue()
    {
        $aConfigTimezone = array(
            'America/Detroit' => 'Europe/London',
            'Europe/London' => 'Europe/London'
        );

        $aResult = array(
            'America/Detroit'   => 'America/Detroit',
            'Europe/London'     => ''
        );

        foreach ($aConfigTimezone as $tz => $aTimezone) {
            $this->assertEqual(OX_Admin_Timezones::getConfigTimezoneValue($tz, $aTimezone), $aResult[$tz]);
        }
    }

    function test_convertOffset()
    {
        $aOffset = array (
            '18000000' => '0500',
            '11224000' => '0307',
            '34200000' => '0930',
            '45900000' => '1245'
        );

        foreach ($aOffset as $offset => $result) {
            $this->assertEqual(OX_Admin_Timezones::_convertOffset($offset), $result);
        }
    }
}

?>