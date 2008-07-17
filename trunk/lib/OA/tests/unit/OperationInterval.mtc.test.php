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

require_once MAX_PATH . '/lib/Max.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/OperationInterval.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A class for testing the OA_OperationInterval class.
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_OperationIntveral extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_OperationIntveral()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the checkOperationIntervalValue() method.
     *
     */
    function testCheckOperationIntervalValue()
    {
        OA::disableErrorHandling();
        for ($i = -1; $i <= 61; $i++) {
            $result = OA_OperationInterval::checkOperationIntervalValue($i);
            if (
                $i == 1  ||
                $i == 2  ||
                $i == 3  ||
                $i == 4  ||
                $i == 5  ||
                $i == 6  ||
                $i == 10 ||
                $i == 12 ||
                $i == 15 ||
                $i == 20 ||
                $i == 30 ||
                $i == 60
            ) {
                $this->assertTrue($result);
            } else {
                $this->assertTrue(PEAR::isError($result));
            }
            $result = OA_OperationInterval::checkOperationIntervalValue(120);
            $this->assertTrue(PEAR::isError($result));
        }
        OA::enableErrorHandling();
    }

    /**
     * A method to test the convertDateRangeToOperationIntervalID() method.
     */
    function testConvertDateRangeToOperationIntervalID()
    {
        // Test the first operation interval ID range in the week the test was written,
        // using a default operation interval of 60 minutes
        $start = new Date('2004-08-15 00:00:00');
        $end = new Date('2004-08-15 00:59:59');
        $result = OA_OperationInterval::convertDateRangeToOperationIntervalID($start, $end, 60);
        $this->assertEqual($result, 0);
        // Test the same range with a new operation interval of 30 minutes to make
        // sure that the range is recognised as spanning two operation interval IDs
        $result = OA_OperationInterval::convertDateRangeToOperationIntervalID($start, $end, 30);
        $this->assertFalse($result);
        // Test the second operation interval ID range in the week the test was written,
        // using an operation interval of 30 minutes, and a non-definative date range
        $start = new Date('2004-08-15 00:35:00');
        $end = new Date('2004-08-15 00:40:00');
        $result = OA_OperationInterval::convertDateRangeToOperationIntervalID($start, $end, 30);
        $this->assertEqual($result, 1);
    }

    /**
     * A method to test the convertDateToOperationIntervalID() method.
     */
    function testConvertDateToOperationIntervalID()
    {
        // Test a date in the first operation interval ID in the week before the test was
        // written, using a default operation interval of 60 minutes
        $date = new Date('2004-08-08 00:40:00');
        $result = OA_OperationInterval::convertDateToOperationIntervalID($date, 60);
        $this->assertEqual($result, 0);
        // Test a date in the last operation interval ID in the week before the test was
        // written, using an operation interval of 30 minutes
        $date = new Date('2004-08-14 23:40:00');
        $result = OA_OperationInterval::convertDateToOperationIntervalID($date, 30);
        $this->assertEqual($result, 335);
    }

    /**
     * A method to test the convertDateToOperationIntervalStartAndEndDates() method.
     */
    function testConvertDateToOperationIntervalStartAndEndDates()
    {
        // Test a date in the first operation interval ID in the week before the test was
        // written, using a default operation interval of 60 minutes
        $date = new Date('2004-08-08 00:40:00');
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($date, 60);
        $this->assertEqual($aDates['start'], new Date('2004-08-08 00:00:00'));
        $this->assertEqual($aDates['end'], new Date('2004-08-08 00:59:59'));
        // Test the same date, but with an operation interval of 30 minutes
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($date, 30);
        $this->assertEqual($aDates['start'], new Date('2004-08-08 00:30:00'));
        $this->assertEqual($aDates['end'], new Date('2004-08-08 00:59:59'));
    }

    function testAddOperationIntervalTimeSpan()
    {
        $date = new Date('2004-08-08 00:40:00');
        $nextDate = OA_OperationInterval::addOperationIntervalTimeSpan($date, 60);
        $this->assertEqual($nextDate, new Date('2004-08-08 01:40:00'));
        // Test the same date, but with an operation interval of 30 minutes
        $nextDate = OA_OperationInterval::addOperationIntervalTimeSpan($date, 30);
        $this->assertEqual($nextDate, new Date('2004-08-08 01:10:00'));
    }

    /**
     * A method to test the convertDateToPreviousOperationIntervalStartAndEndDates() method.
     */
    function testConvertDateToPreviousOperationIntervalStartAndEndDates()
    {
        // Test a date in the first operation interval ID in the week before the test was
        // written, using a default operation interval of 60 minutes
        $date = new Date('2004-08-08 00:40:00');
        $aDates = OA_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($date, 60);
        $this->assertEqual($aDates['start'], new Date('2004-08-07 23:00:00'));
        $this->assertEqual($aDates['end'], new Date('2004-08-07 23:59:59'));
        // Test the same date, but with an operation interval of 30 minutes
        $aDates = OA_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($date, 30);
        $this->assertEqual($aDates['start'], new Date('2004-08-08 00:00:00'));
        $this->assertEqual($aDates['end'], new Date('2004-08-08 00:29:59'));
    }

    /**
     * A method to test the convertDateToNextOperationIntervalStartAndEndDates() method.
     */
    function testConvertDateToNextOperationIntervalStartAndEndDates()
    {
        // Test a date in the first operation interval ID in the week before the test was
        // written, using a default operation interval of 60 minutes
        $date = new Date('2004-08-08 00:40:00');
        $aDates = OA_OperationInterval::convertDateToNextOperationIntervalStartAndEndDates($date, 60);
        $this->assertEqual($aDates['start'], new Date('2004-08-08 01:00:00'));
        $this->assertEqual($aDates['end'], new Date('2004-08-08 01:59:59'));
        // Test the same date, but with an operation interval of 30 minutes
        $aDates = OA_OperationInterval::convertDateToNextOperationIntervalStartAndEndDates($date, 30);
        $this->assertEqual($aDates['start'], new Date('2004-08-08 01:00:00'));
        $this->assertEqual($aDates['end'], new Date('2004-08-08 01:29:59'));
    }

    /**
     * A method to test the previousOperationIntervalID() method.
     */
    function testPreviousOperationIntervalID()
    {
        $operationIntervalID = 1;
        $operationInterval   = 60;
        $operationIntervalID = OA_OperationInterval::previousOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 0);
        $operationIntervalID = OA_OperationInterval::previousOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 167);
        $operationIntervalID = OA_OperationInterval::previousOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 166);

        $operationIntervalID = 1;
        $operationInterval   = 60;
        $intervals           = 3;
        $operationIntervalID = OA_OperationInterval::previousOperationIntervalID($operationIntervalID, $operationInterval, $intervals);
        $this->assertEqual($operationIntervalID, 166);
        $operationIntervalID = OA_OperationInterval::previousOperationIntervalID($operationIntervalID, $operationInterval, $intervals);
        $this->assertEqual($operationIntervalID, 163);

        $operationIntervalID = 1;
        $operationInterval   = 30;
        $operationIntervalID = OA_OperationInterval::previousOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 0);
        $operationIntervalID = OA_OperationInterval::previousOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 335);
        $operationIntervalID = OA_OperationInterval::previousOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 334);

        $operationIntervalID = 1;
        $operationInterval   = 30;
        $intervals           = 3;
        $operationIntervalID = OA_OperationInterval::previousOperationIntervalID($operationIntervalID, $operationInterval, $intervals);
        $this->assertEqual($operationIntervalID, 334);
        $operationIntervalID = OA_OperationInterval::previousOperationIntervalID($operationIntervalID, $operationInterval, $intervals);
        $this->assertEqual($operationIntervalID, 331);
    }

    /**
     * A method to test the nextOperationIntervalID() method.
     */
    function testNextOperationIntervalID()
    {
        $operationIntervalID = 166;
        $operationInterval   = 60;
        $operationIntervalID = OA_OperationInterval::nextOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 167);
        $operationIntervalID = OA_OperationInterval::nextOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 0);
        $operationIntervalID = OA_OperationInterval::nextOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 1);

        $operationIntervalID = 166;
        $operationInterval   = 60;
        $intervals           = 3;
        $operationIntervalID = OA_OperationInterval::nextOperationIntervalID($operationIntervalID, $operationInterval, $intervals);
        $this->assertEqual($operationIntervalID, 1);

        $operationIntervalID = 334;
        $operationInterval   = 30;
        $operationIntervalID = OA_OperationInterval::nextOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 335);
        $operationIntervalID = OA_OperationInterval::nextOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 0);
        $operationIntervalID = OA_OperationInterval::nextOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 1);

        $operationIntervalID = 334;
        $operationInterval   = 30;
        $intervals           = 3;
        $operationIntervalID = OA_OperationInterval::nextOperationIntervalID($operationIntervalID, $operationInterval, $intervals);
        $this->assertEqual($operationIntervalID, 1);
    }

    /**
     * A method to test the checkDatesInSameHour() method.
     */
    function testCheckDatesInSameHour()
    {
        $start = new Date('2004-09-11 19:00:00');
        $end   = new Date('2004-09-11 19:00:00');
        $return = OA_OperationInterval::checkDatesInSameHour($start, $end);
        $this->assertTrue($return);
        $start = new Date('2004-09-11 19:59:59');
        $end   = new Date('2004-09-11 19:59:59');
        $return = OA_OperationInterval::checkDatesInSameHour($start, $end);
        $this->assertTrue($return);
        $start = new Date('2004-09-11 19:00:00');
        $end   = new Date('2004-09-11 19:00:01');
        $return = OA_OperationInterval::checkDatesInSameHour($start, $end);
        $this->assertTrue($return);
        $start = new Date('2004-09-11 19:00:00');
        $end   = new Date('2004-09-11 19:59:59');
        $return = OA_OperationInterval::checkDatesInSameHour($start, $end);
        $this->assertTrue($return);
        $start = new Date('2004-09-11 19:59:59');
        $end   = new Date('2004-09-11 20:00:00');
        $return = OA_OperationInterval::checkDatesInSameHour($start, $end);
        $this->assertFalse($return);
        $start = new Date('2004-09-11 18:00:00');
        $end   = new Date('2004-09-12 18:00:00');
        $return = OA_OperationInterval::checkDatesInSameHour($start, $end);
        $this->assertFalse($return);
        $start = new Date('2004-08-11 18:00:00');
        $end   = new Date('2004-09-11 18:00:00');
        $return = OA_OperationInterval::checkDatesInSameHour($start, $end);
        $this->assertFalse($return);
        $start = new Date('2003-09-11 18:00:00');
        $end   = new Date('2004-09-11 18:00:00');
        $return = OA_OperationInterval::checkDatesInSameHour($start, $end);
        $this->assertFalse($return);
    }

    /**
     * A method to test the checkIntervalDates() method.
     */
    function testCheckIntervalDates()
    {
        $conf =& $GLOBALS['_MAX']['CONF'];
        // Set the operation interval
        $conf['maintenance']['operationInterval'] = 30;
        // Test less than one operation interval
        $start = new Date('2004-09-26 00:00:00');
        $end = new Date('2004-09-26 00:15:00');
        $this->assertFalse(OA_OperationInterval::checkIntervalDates($start, $end));
        // Test more than one operation inteterval
        $start = new Date('2004-09-26 00:00:00');
        $end = new Date('2004-09-26 00:45:00');
        $this->assertFalse(OA_OperationInterval::checkIntervalDates($start, $end));
        // Test exactly one operation interval
        $start = new Date('2004-09-26 00:00:00');
        $end = new Date('2004-09-26 00:29:59');
        $this->assertTrue(OA_OperationInterval::checkIntervalDates($start, $end));
        // Set the operation interval
        $conf['maintenance']['operationInterval'] = 60;
        // Test less than one operation interval/hour
        $start = new Date('2004-09-26 00:00:00');
        $end = new Date('2004-09-26 00:30:00');
        $this->assertFalse(OA_OperationInterval::checkIntervalDates($start, $end));
        // Test more than one operation inteterval/hour
        $start = new Date('2004-09-26 00:00:00');
        $end = new Date('2004-09-26 01:15:00');
        $this->assertFalse(OA_OperationInterval::checkIntervalDates($start, $end));
        // Test exactly one operation interval/hour
        $start = new Date('2004-09-26 00:00:00');
        $end = new Date('2004-09-26 00:59:59');
        $this->assertTrue(OA_OperationInterval::checkIntervalDates($start, $end));
        // Set the operation interval
        $conf['maintenance']['operationInterval'] = 120;
        // Test less than one hour
        $start = new Date('2004-09-26 00:00:00');
        $end = new Date('2004-09-26 00:15:00');
        $this->assertFalse(OA_OperationInterval::checkIntervalDates($start, $end));
        // Test more than one hour
        $start = new Date('2004-09-26 00:00:00');
        $end = new Date('2004-09-26 04:00:00');
        $this->assertFalse(OA_OperationInterval::checkIntervalDates($start, $end));
        // Test exactly one hour
        $start = new Date('2004-09-26 00:00:00');
        $end = new Date('2004-09-26 00:59:59');
        $this->assertTrue(OA_OperationInterval::checkIntervalDates($start, $end));
    }

    /**
     * A method to test the getOperationInterval() method.
     */
    function testGetOperationInterval() {
        $this->assertEqual(
            OA_OperationInterval::getOperationInterval(),
            $GLOBALS['_MAX']['CONF']['maintenance']['operationInterval']
        );
    }

    /**
     * A method to test the secondsPerOperationInterval() method.
     *
     * @TODO Not implemented.
     */
    function testSecondsPerOperationInterval()
    {

    }

    /**
     * A method to test the operationIntervalsPerDay() method.
     *
     * @TODO Not implemented.
     */
    function testOperationIntervalsPerDay()
    {

    }

    /**
     * A method to test the operationIntervalsPerWeek() method.
     *
     * @TODO Not implemented.
     */
    function testOperationIntervalsPerWeek()
    {

    }

    /**
     * A method to test the getIntervalsRemaining() method.
     *
     * @TODO Not implemented.
     */
    function testGetIntervalsRemaining()
    {

    }

}

?>
