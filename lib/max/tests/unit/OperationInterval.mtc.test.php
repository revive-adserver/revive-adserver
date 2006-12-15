<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/DB.php';
require_once MAX_PATH . '/lib/max/Table/Core.php';
require_once MAX_PATH . '/lib/max/OperationInterval.php';
require_once 'Date.php';

/**
 * A class for testing the MAX_OperationInterval class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Maintenance_TestOfMaxOperationIntveral extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMaxOperationIntveral()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the checkOperationIntervalValue() method.
     *
     * @TODO Not implemented
     */
    function testCheckOperationIntervalValue()
    {

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
        $result = MAX_OperationInterval::convertDateRangeToOperationIntervalID($start, $end, 60);
        $this->assertEqual($result, 0);
        // Test the same range with a new operation interval of 30 minutes to make
        // sure that the range is recognised as spanning two operation interval IDs
        $result = MAX_OperationInterval::convertDateRangeToOperationIntervalID($start, $end, 30);
        $this->assertFalse($result);
        // Test the second operation interval ID range in the week the test was written,
        // using an operation interval of 30 minutes, and a non-definative date range
        $start = new Date('2004-08-15 00:35:00');
        $end = new Date('2004-08-15 00:40:00');
        $result = MAX_OperationInterval::convertDateRangeToOperationIntervalID($start, $end, 30);
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
        $result = MAX_OperationInterval::convertDateToOperationIntervalID($date, 60);
        $this->assertEqual($result, 0);
        // Test a date in the last operation interval ID in the week before the test was
        // written, using an operation interval of 30 minutes
        $date = new Date('2004-08-14 23:40:00');
        $result = MAX_OperationInterval::convertDateToOperationIntervalID($date, 30);
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
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($date, 60);
        $this->assertEqual($aDates['start'], new Date('2004-08-08 00:00:00'));
        $this->assertEqual($aDates['end'], new Date('2004-08-08 00:59:59'));
        // Test the same date, but with an operation interval of 30 minutes
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($date, 30);
        $this->assertEqual($aDates['start'], new Date('2004-08-08 00:30:00'));
        $this->assertEqual($aDates['end'], new Date('2004-08-08 00:59:59'));
    }

    /**
     * A method to test the convertDateToPreviousOperationIntervalStartAndEndDates() method.
     */
    function testConvertDateToPreviousOperationIntervalStartAndEndDates()
    {
        // Test a date in the first operation interval ID in the week before the test was
        // written, using a default operation interval of 60 minutes
        $date = new Date('2004-08-08 00:40:00');
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($date, 60);
        $this->assertEqual($aDates['start'], new Date('2004-08-07 23:00:00'));
        $this->assertEqual($aDates['end'], new Date('2004-08-07 23:59:59'));
        // Test the same date, but with an operation interval of 30 minutes
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($date, 30);
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
        $aDates = MAX_OperationInterval::convertDateToNextOperationIntervalStartAndEndDates($date, 60);
        $this->assertEqual($aDates['start'], new Date('2004-08-08 01:00:00'));
        $this->assertEqual($aDates['end'], new Date('2004-08-08 01:59:59'));
        // Test the same date, but with an operation interval of 30 minutes
        $aDates = MAX_OperationInterval::convertDateToNextOperationIntervalStartAndEndDates($date, 30);
        $this->assertEqual($aDates['start'], new Date('2004-08-08 01:00:00'));
        $this->assertEqual($aDates['end'], new Date('2004-08-08 01:29:59'));
    }

    /**
     * A method to test the previousOperationIntervalID() method.
     */
    function testPreviousOperationIntervalID()
    {
        $operationIntervalID = 1;
        $operationInterval = 60;
        $operationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 0);
        $operationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 167);
        $operationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 166);
        $operationIntervalID = 1;
        $operationInterval = 30;
        $operationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 0);
        $operationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 335);
        $operationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 334);
    }

    /**
     * A method to test the nextOperationIntervalID() method.
     */
    function testNextOperationIntervalID()
    {
        $operationIntervalID = 166;
        $operationInterval = 60;
        $operationIntervalID = MAX_OperationInterval::nextOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 167);
        $operationIntervalID = MAX_OperationInterval::nextOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 0);
        $operationIntervalID = MAX_OperationInterval::nextOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 1);
        $operationIntervalID = 334;
        $operationInterval = 30;
        $operationIntervalID = MAX_OperationInterval::nextOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 335);
        $operationIntervalID = MAX_OperationInterval::nextOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 0);
        $operationIntervalID = MAX_OperationInterval::nextOperationIntervalID($operationIntervalID, $operationInterval);
        $this->assertEqual($operationIntervalID, 1);
    }

    /**
     * A method to test the checkDatesInSameHour() method.
     */
    function testCheckDatesInSameHour()
    {
        $start = new Date('2004-09-11 19:00:00');
        $end   = new Date('2004-09-11 19:00:00');
        $return = MAX_OperationInterval::checkDatesInSameHour($start, $end);
        $this->assertTrue($return);
        $start = new Date('2004-09-11 19:59:59');
        $end   = new Date('2004-09-11 19:59:59');
        $return = MAX_OperationInterval::checkDatesInSameHour($start, $end);
        $this->assertTrue($return);
        $start = new Date('2004-09-11 19:00:00');
        $end   = new Date('2004-09-11 19:00:01');
        $return = MAX_OperationInterval::checkDatesInSameHour($start, $end);
        $this->assertTrue($return);
        $start = new Date('2004-09-11 19:00:00');
        $end   = new Date('2004-09-11 19:59:59');
        $return = MAX_OperationInterval::checkDatesInSameHour($start, $end);
        $this->assertTrue($return);
        $start = new Date('2004-09-11 19:59:59');
        $end   = new Date('2004-09-11 20:00:00');
        $return = MAX_OperationInterval::checkDatesInSameHour($start, $end);
        $this->assertFalse($return);
        $start = new Date('2004-09-11 18:00:00');
        $end   = new Date('2004-09-12 18:00:00');
        $return = MAX_OperationInterval::checkDatesInSameHour($start, $end);
        $this->assertFalse($return);
        $start = new Date('2004-08-11 18:00:00');
        $end   = new Date('2004-09-11 18:00:00');
        $return = MAX_OperationInterval::checkDatesInSameHour($start, $end);
        $this->assertFalse($return);
        $start = new Date('2003-09-11 18:00:00');
        $end   = new Date('2004-09-11 18:00:00');
        $return = MAX_OperationInterval::checkDatesInSameHour($start, $end);
        $this->assertFalse($return);
    }

    /**
     * A method to test the checkIntervalDates() method.
     */
    function testCheckIntervalDates()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        // Set the operation interval
        $conf['maintenance']['operationInterval'] = 30;
        // Test less than one operation interval
        $start = new Date('2004-09-26 00:00:00');
        $end = new Date('2004-09-26 00:15:00');
        $this->assertFalse(MAX_OperationInterval::checkIntervalDates($start, $end));
        // Test more than one operation inteterval
        $start = new Date('2004-09-26 00:00:00');
        $end = new Date('2004-09-26 00:45:00');
        $this->assertFalse(MAX_OperationInterval::checkIntervalDates($start, $end));
        // Test exactly one operation interval
        $start = new Date('2004-09-26 00:00:00');
        $end = new Date('2004-09-26 00:29:59');
        $this->assertTrue(MAX_OperationInterval::checkIntervalDates($start, $end));
        // Set the operation interval
        $conf['maintenance']['operationInterval'] = 60;
        // Test less than one operation interval/hour
        $start = new Date('2004-09-26 00:00:00');
        $end = new Date('2004-09-26 00:30:00');
        $this->assertFalse(MAX_OperationInterval::checkIntervalDates($start, $end));
        // Test more than one operation inteterval/hour
        $start = new Date('2004-09-26 00:00:00');
        $end = new Date('2004-09-26 01:15:00');
        $this->assertFalse(MAX_OperationInterval::checkIntervalDates($start, $end));
        // Test exactly one operation interval/hour
        $start = new Date('2004-09-26 00:00:00');
        $end = new Date('2004-09-26 00:59:59');
        $this->assertTrue(MAX_OperationInterval::checkIntervalDates($start, $end));
        // Set the operation interval
        $conf['maintenance']['operationInterval'] = 120;
        // Test less than one hour
        $start = new Date('2004-09-26 00:00:00');
        $end = new Date('2004-09-26 00:15:00');
        $this->assertFalse(MAX_OperationInterval::checkIntervalDates($start, $end));
        // Test more than one hour
        $start = new Date('2004-09-26 00:00:00');
        $end = new Date('2004-09-26 04:00:00');
        $this->assertFalse(MAX_OperationInterval::checkIntervalDates($start, $end));
        // Test exactly one hour
        $start = new Date('2004-09-26 00:00:00');
        $end = new Date('2004-09-26 00:59:59');
        $this->assertTrue(MAX_OperationInterval::checkIntervalDates($start, $end));
    }

    /**
     * A method to test the getOperationInterval() method.
     */
    function testGetOperationInterval() {
        $this->assertEqual(
            MAX_OperationInterval::getOperationInterval(),
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
