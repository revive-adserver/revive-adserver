<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
$Id: OA_Admin_Timezones.admin.test.php 6351 2007-05-10 13:55:39Z aj@seagullproject.org $
*/

require_once MAX_PATH . '/lib/OA/Admin/Timezones.php';

/**
 * A class for testing the OA_Admin_Timezones class.
 *
 * @package    OpenXAdmin
 * @subpackage TestSuite
 * @author     Alexander J. Tarachanowicz II <aj@seagullproject.org>
 */
class Test_OA_Admin_Timezones extends UnitTestCase
{

    function testAvailableTimezones()
    {
        global $_DATE_TIMEZONE_DATA;

        //  get time zones
        $aTimezone = OA_Admin_Timezones::availableTimezones(true);

        //  test that it is an array, not empty and contains 448 items (447 + a blank)
        $this->assertTrue(is_array($aTimezone));
        $this->assertFalse(empty($aTimezone));
        $this->assertEqual(count($aTimezone), 448);

        //  remove blank element
        array_shift($aTimezone);

        //  check returned data against global array from PEAR::Date
        foreach ($aTimezone as $key => $value) {
            $this->assertTrue(array_key_exists($key, $_DATE_TIMEZONE_DATA));

            //  check label to ensure it was created properly
            $offset = OA_Admin_Timezones::_convertOffset($_DATE_TIMEZONE_DATA[$key]['offset']);
            $offset = ($_DATE_TIMEZONE_DATA[$key]['offset'] >=0) ? 'GMT+'. $offset : 'GMT-'. $offset;
            $this->assertEqual($value, "($offset) $key");
        }
    }

    function testGetTimezone()
    {
        if (version_compare(phpversion(), '5.1.0', '>=')) {
            //  set environment variable
            date_default_timezone_set('America/Detroit');

            $aTimezone = OA_Admin_Timezones::getTimezone();

            $this->assertTrue(is_array($aTimezone));
            $this->assertEqual(count($aTimezone), 2);
            $this->assertEqual('America/Detroit', $aTimezone['tz']);
            $this->assertEqual(false, $aTimezone['generated']);
        } else {
            //  this test is dependant upon the system clock
            // Clear any TZ env
            putenv("TZ=");
            if (is_callable('apache_setenv')) {
                apache_setenv('TZ', null);
            }

            $aTimezone = OA_Admin_Timezones::getTimezone();
            $diff = date('O');
            $diffSign = substr($diff, 0, 1);
            $diffHour = (int) substr($diff, 1, 2) + date('I'); // add 1 hour if date in DST
            $diffMin  = (int) substr($diff, 3, 2);
            $offset = (($diffHour * 60) + ($diffMin)) * 60 * 1000; // Milliseconds
            $offset = $diffSign . $offset;

            global $_DATE_TIMEZONE_DATA;
            reset($_DATE_TIMEZONE_DATA);
            foreach (array_keys($_DATE_TIMEZONE_DATA) as $key) {
                if ($_DATE_TIMEZONE_DATA[$key]['offset'] == $offset) {
                    $tz = $key;
                    break;
                }
            }
            $this->assertTrue(is_array($aTimezone));
            $this->assertEqual(count($aTimezone), 2);
            $this->assertEqual($aTimezone['tz'], $tz);
            $this->assertEqual($aTimezone['calculated'], true);

            putenv("TZ=America/Detroit");
            if (is_callable('apache_setenv')) {
                apache_setenv('TZ', 'America/Detroit');
            }

            $aTimezone = OA_Admin_Timezones::getTimezone();
            $this->assertTrue(is_array($aTimezone));
            $this->assertEqual(count($aTimezone), 2);
            $this->assertEqual($aTimezone['tz'], 'America/Detroit');
            $this->assertEqual($aTimezone['calculated'], false);
        }
    }

    function testGetConfigTimezoneValue()
    {
        $aConfigTimezone = array(
            'America/Detroit' => array(
                    'tz'        => 'Europe/London',
                    'generated' => false),
            'Europe/London' => array(
                    'tz'        => 'Europe/London',
                    'generated' => true),
            'America/Chicago' => array(
                    'tz'        => 'America/Chicago',
                    'generated' => false),
        );

        $aResult = array(
            'America/Detroit'   => 'America/Detroit',
            'Europe/London'     => 'Europe/London',
            'America/Chicago'   => ''
        );

        foreach ($aConfigTimezone as $tz => $aTimezone) {
            $this->assertEqual(OA_Admin_Timezones::getConfigTimezoneValue($tz, $aTimezone), $aResult[$tz]);
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
            $this->assertEqual(OA_Admin_Timezones::_convertOffset($offset), $result);
        }
    }
}

?>