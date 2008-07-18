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

require_once MAX_PATH . '/lib/OA/Admin/TimezonesDelivery.php';

/**
 * A class for testing the OA_Admin_TimezonesDelivery_getTimezone()
 * function..
 *
 * @package    OpenXDelivery
 * @subpackage TestSuite
 * @author     Alexander J. Tarachanowicz II <aj@seagullproject.org>
 */
class Test_OA_Admin_TimezonesDelivery extends UnitTestCase
{

    function testGetTimezone()
    {
        if (version_compare(phpversion(), '5.1.0', '>=')) {
            // Set & test environment variable
            date_default_timezone_set('America/Detroit');

            $aTimezone = OA_Admin_TimezonesDelivery_getTimezone();

            $this->assertTrue(is_array($aTimezone));
            $this->assertEqual(count($aTimezone), 2);
            $this->assertEqual('America/Detroit', $aTimezone['tz']);
            $this->assertEqual(false, $aTimezone['calculated']);
        } else {
            // This test is dependant upon the system clock
            // Clear any TZ env
            putenv("TZ=");
            if (is_callable('apache_setenv')) {
                apache_setenv('TZ', null);
            }

            $aTimezone = OA_Admin_TimezonesDelivery_getTimezone();
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
            $this->assertEqual(count($aTimezone), 0);

            putenv("TZ=America/Detroit");
            if (is_callable('apache_setenv')) {
                apache_setenv('TZ', 'America/Detroit');
            }

            $aTimezone = OA_Admin_TimezonesDelivery_getTimezone();
            $this->assertTrue(is_array($aTimezone));
            $this->assertEqual(count($aTimezone), 2);
            $this->assertEqual($aTimezone['tz'], 'America/Detroit');
            $this->assertEqual($aTimezone['calculated'], false);
        }
    }

}

?>