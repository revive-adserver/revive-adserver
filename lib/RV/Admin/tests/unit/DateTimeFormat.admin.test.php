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

require_once MAX_PATH . '/lib/RV/Admin/DateTimeFormat.php';

/**
 * A class for testing the RV_Admin_DateTimeFormat class.
 *
 * @package    RV_Admin
 * @subpackage TestSuite
 */
class Test_RV_Admin_DateTimeFormat extends UnitTestCase
{

    function testFormatUTCDateTime()
    {
        // Create a UTC date/time string
        $sDateTime = '2017-09-06 00:00:00';

        // Set the user locale timezone to something unusual
        global $_DATE_TIMEZONE_DEFAULT;
        $_DATE_TIMEZONE_DEFAULT = 'Australia/Adelaide';

        // Set the user local date_format string to something unusual
        global $date_format;
        $date_format = '%m--%Y--%d';

        // Set the user local time_format string to something unusual
        global $time_format;
        $time_format = '%S::%H::%M';

        // Format the UTC date/time string based on the above
        $sFormattedDateTime = RV_Admin_DateTimeFormat::formatUTCDateTime($sDateTime);

        // Assert that the formatted date/time string is as expected
        $sExpectedDateTime = '09--2017--06 00::09::30';
        $this->assertEqual($sFormattedDateTime, $sExpectedDateTime);
    }

    function testFormatUTCDate()
    {
        // Create a UTC date/time string
        $sDateTime = '2017-09-06 00:00:00';

        // Set the user locale timezone to something unusual
        global $_DATE_TIMEZONE_DEFAULT;
        $_DATE_TIMEZONE_DEFAULT = 'Australia/Adelaide';

        // Set the user local date_format string to something unusual
        global $date_format;
        $date_format = '%m--%Y--%d';

        // Format the UTC date string based on the above
        $sFormattedDate = RV_Admin_DateTimeFormat::formatUTCDate($sDateTime);

        // Assert that the formatted date string is as expected
        $sExpectedDate = '09--2017--06';
        $this->assertEqual($sFormattedDate, $sExpectedDate);
    }

    function testFormatUTCTime()
    {
        // Create a UTC date/time string
        $sDateTime = '2017-09-06 00:00:00';

        // Set the user locale timezone to something unusual
        global $_DATE_TIMEZONE_DEFAULT;
        $_DATE_TIMEZONE_DEFAULT = 'Australia/Adelaide';

        // Set the user local time_format string to something unusual
        global $time_format;
        $time_format = '%S::%H::%M';

        // Format the UTC time string based on the above
        $sFormattedTime = RV_Admin_DateTimeFormat::formatUTCTime($sDateTime);

        // Assert that the formatted time string is as expected
        $sExpectedTime = '00::09::30';
        $this->assertEqual($sFormattedTime, $sExpectedTime);
    }

}

?>