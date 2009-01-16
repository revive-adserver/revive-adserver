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
$Id$
*/

require_once MAX_PATH . '/lib/OX/Admin/Timezones.php';

/**
 * A class for testing the OX_Admin_Timezones class.
 *
 * @package    OpenXAdmin
 * @subpackage TestSuite
 * @author     Alexander J. Tarachanowicz II <aj@seagullproject.org>
 */
class Test_OX_Admin_Timezones extends UnitTestCase
{

    function testAvailableTimezones()
    {
        global $_DATE_TIMEZONE_DATA;

        // Get time zones
        $aTimezone = OX_Admin_Timezones::availableTimezones(true);

        // Test that it is an array, not empty and contains 449 items (448 + a blank)
        $this->assertTrue(is_array($aTimezone));
        $this->assertFalse(empty($aTimezone));
        $this->assertEqual(count($aTimezone), 449);

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