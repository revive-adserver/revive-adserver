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

require_once MAX_PATH . '/lib/OA/Admin/DaySpan.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A class for testing the OA_Admin_DaySpan class.
 *
 * @package    OpenXAdmin
 * @subpackage TestSuite
 */
class Test_OA_Admin_DaySpan extends UnitTestCase
{
    /**
     * A method to test the set/get methods:
     *  - setSpanDays()
     *  - getStartDate()
     *  - getEndDate()
     *  - getStartDateString()
     *  - getEndDateString()
     */
    public function testSetAndGet()
    {
        $oDaySpan = new OA_Admin_DaySpan();

        $oTestStartDate = new Date('1987-04-12 15:10:11');
        $oTestEndDate = new Date('2004-10-12 23:59:58');

        $oDaySpan->setSpanDays($oTestStartDate, $oTestEndDate);

        // Dates should not be equal, as span dates will be "rounded"
        $this->assertNotEqual($oDaySpan->getStartDate(), $oTestStartDate);
        $this->assertNotEqual($oDaySpan->getEndDate(), $oTestEndDate);

        // Round the test dates, and ensure they match!
        $oTestStartDate->setHour(0);
        $oTestStartDate->setMinute(0);
        $oTestStartDate->setSecond(0);
        $oTestEndDate->setHour(23);
        $oTestEndDate->setMinute(59);
        $oTestEndDate->setSecond(59);
        $this->assertEqual($oDaySpan->getStartDate(), $oTestStartDate);
        $this->assertEqual($oDaySpan->getEndDate(), $oTestEndDate);

        // Test the default format for the string methods
        $this->assertEqual($oDaySpan->getStartDateString(), '1987-04-12');
        $this->assertEqual($oDaySpan->getEndDateString(), '2004-10-12');

        // Test custom formats for the string methods
        $this->assertEqual($oDaySpan->getStartDateString('%d-%m-%Y'), '12-04-1987');
        $this->assertEqual($oDaySpan->getEndDateString('%d-%m-%y'), '12-10-04');
    }

    /**
     * A method to test the getBeginOfWeek() method.
     */
    public function testGetBeginOfWeek()
    {
        $oDaySpan = new OA_Admin_DaySpan();

        unset($GLOBALS['_MAX']['PREF']['ui_week_start_day']);
        $beginOfWeek = $oDaySpan->getBeginOfWeek();
        $this->assertEqual($beginOfWeek, 0);

        $GLOBALS['_MAX']['PREF']['ui_week_start_day'] = 0;
        $beginOfWeek = $oDaySpan->getBeginOfWeek();
        $this->assertEqual($beginOfWeek, 0);

        $GLOBALS['_MAX']['PREF']['ui_week_start_day'] = 1;
        $beginOfWeek = $oDaySpan->getBeginOfWeek();
        $this->assertEqual($beginOfWeek, 1);
    }

    /**
     * A method to test the dates returned by the _getSpanDates()
     * method when used with the 'friendly' preset "today".
     */
    public function test_getSpanDatesToday()
    {
        $oDaySpan = new OA_Admin_DaySpan();

        $oDaySpan->oNowDate = new Date('2007-05-09');

        $aDates = $oDaySpan->_getSpanDates('today');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-05-09');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-09');

        $oDaySpan->oNowDate = new Date('2007-05-10');

        $aDates = $oDaySpan->_getSpanDates('today');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-05-10');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-10');
    }

    /**
     * A method to test the dates returned by the _getSpanDates()
     * method when used with the 'friendly' preset "yesterday".
     */
    public function test_getSpanDatesYesterday()
    {
        $oDaySpan = new OA_Admin_DaySpan();

        $oDaySpan->oNowDate = new Date('2007-05-09');

        $aDates = $oDaySpan->_getSpanDates('yesterday');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-05-08');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-08');

        $oDaySpan->oNowDate = new Date('2007-05-10');

        $aDates = $oDaySpan->_getSpanDates('yesterday');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-05-09');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-09');
    }

    /**
     * A method to test the dates returned by the _getSpanDates()
     * method when used with the 'friendly' preset "this_week".
     */
    public function test_getSpanDatesThisWeek()
    {
        $oDaySpan = new OA_Admin_DaySpan();

        // Test with start of week on Sunday
        $GLOBALS['_MAX']['PREF']['ui_week_start_day'] = 0;

        $oDaySpan->oNowDate = new Date('2007-05-09');

        $aDates = $oDaySpan->_getSpanDates('this_week');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-05-06');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-09'); // Only shows to today, not real "end of week".

        $oDaySpan->oNowDate = new Date('2007-05-10');

        $aDates = $oDaySpan->_getSpanDates('this_week');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-05-06');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-10'); // Only shows to today, not real "end of week".

        // Special test on a Sunday!
        $oDaySpan->oNowDate = new Date('2007-05-06');

        $aDates = $oDaySpan->_getSpanDates('this_week');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-05-06');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-06'); // Only shows to today, not real "end of week".

        // Special test on a Monday!
        $oDaySpan->oNowDate = new Date('2007-05-07');

        $aDates = $oDaySpan->_getSpanDates('this_week');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-05-06');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-07'); // Only shows to today, not real "end of week".

        // Test with start of week on Monday
        $GLOBALS['_MAX']['PREF']['ui_week_start_day'] = 1;

        $oDaySpan->oNowDate = new Date('2007-05-09');

        $aDates = $oDaySpan->_getSpanDates('this_week');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-05-07');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-09'); // Only shows to today, not real "end of week".

        $oDaySpan->oNowDate = new Date('2007-05-10');

        $aDates = $oDaySpan->_getSpanDates('this_week');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-05-07');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-10'); // Only shows to today, not real "end of week".

        // Special test on a Sunday!
        $oDaySpan->oNowDate = new Date('2007-05-06');

        $aDates = $oDaySpan->_getSpanDates('this_week');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-04-30');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-06'); // Only shows to today, not real "end of week".

        // Special test on a Monday!
        $oDaySpan->oNowDate = new Date('2007-05-07');

        $aDates = $oDaySpan->_getSpanDates('this_week');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-05-07');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-07'); // Only shows to today, not real "end of week".
    }

    /**
     * A method to test the dates returned by the _getSpanDates()
     * method when used with the 'friendly' preset "last_week".
     */
    public function test_getSpanDatesLastWeek()
    {
        $oDaySpan = new OA_Admin_DaySpan();

        // Test with start of week on Sunday
        $GLOBALS['_MAX']['PREF']['ui_week_start_day'] = 0;

        $oDaySpan->oNowDate = new Date('2007-05-09');

        $aDates = $oDaySpan->_getSpanDates('last_week');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-04-29');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-05');

        $oDaySpan->oNowDate = new Date('2007-05-10');

        $aDates = $oDaySpan->_getSpanDates('last_week');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-04-29');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-05');

        // Special test on a Sunday!
        $oDaySpan->oNowDate = new Date('2007-05-06');

        $aDates = $oDaySpan->_getSpanDates('last_week');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-04-29');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-05');

        // Special test on a Monday!
        $oDaySpan->oNowDate = new Date('2007-05-07');

        $aDates = $oDaySpan->_getSpanDates('last_week');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-04-29');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-05');

        // Test with start of week on Monday
        $GLOBALS['_MAX']['PREF']['ui_week_start_day'] = 1;

        $oDaySpan->oNowDate = new Date('2007-05-09');

        $aDates = $oDaySpan->_getSpanDates('last_week');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-04-30');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-06');

        $oDaySpan->oNowDate = new Date('2007-05-10');

        $aDates = $oDaySpan->_getSpanDates('last_week');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-04-30');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-06');

        // Special test on a Sunday!
        $oDaySpan->oNowDate = new Date('2007-05-06');

        $aDates = $oDaySpan->_getSpanDates('last_week');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-04-23');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-04-29');

        // Special test on a Monday!
        $oDaySpan->oNowDate = new Date('2007-05-07');

        $aDates = $oDaySpan->_getSpanDates('last_week');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-04-30');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-06');
    }

    /**
     * A method to test the dates returned by the _getSpanDates()
     * method when used with the 'friendly' preset "last_7_days".
     */
    public function test_getSpanDatesLast7Days()
    {
        $oDaySpan = new OA_Admin_DaySpan();

        $oDaySpan->oNowDate = new Date('2007-05-09');

        $aDates = $oDaySpan->_getSpanDates('last_7_days');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-05-02');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-08');

        $oDaySpan->oNowDate = new Date('2007-05-10');

        $aDates = $oDaySpan->_getSpanDates('last_7_days');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-05-03');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-09');
    }

    /**
     * A method to test the dates returned by the _getSpanDates()
     * method when used with the 'friendly' preset "this_month".
     */
    public function test_getSpanDatesThisMonth()
    {
        $oDaySpan = new OA_Admin_DaySpan();

        $oDaySpan->oNowDate = new Date('2007-05-09');

        $aDates = $oDaySpan->_getSpanDates('this_month');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-05-01');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-09');  // Only shows to today, not real "end of month".

        $oDaySpan->oNowDate = new Date('2007-05-10');

        $aDates = $oDaySpan->_getSpanDates('this_month');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-05-01');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-10');  // Only shows to today, not real "end of month".
    }

    /**
     * A method to test the dates returned by the _getSpanDates()
     * method when used with the 'friendly' preset "this_month_full".
     */
    public function test_getSpanDatesThisMonthFull()
    {
        $oDaySpan = new OA_Admin_DaySpan();

        $oDaySpan->oNowDate = new Date('2007-05-09');

        $aDates = $oDaySpan->_getSpanDates('this_month_full');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-05-01');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-31');

        $oDaySpan->oNowDate = new Date('2007-05-10');

        $aDates = $oDaySpan->_getSpanDates('this_month_full');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-05-01');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-31');
    }

    /**
     * A method to test the dates returned by the _getSpanDates()
     * method when used with the 'friendly' preset "this_month_remainder".
     */
    public function test_getSpanDatesThisMonthRemainder()
    {
        $oDaySpan = new OA_Admin_DaySpan();

        $oDaySpan->oNowDate = new Date('2007-05-09');

        $aDates = $oDaySpan->_getSpanDates('this_month_remainder');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-05-09'); // Only shows from today, not real "start of month".
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-31');

        $oDaySpan->oNowDate = new Date('2007-05-10');

        $aDates = $oDaySpan->_getSpanDates('this_month_remainder');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-05-10'); // Only shows from today, not real "start of month".
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-05-31');
    }

    /**
     * A method to test the dates returned by the _getSpanDates()
     * method when used with the 'friendly' preset "next_month".
     */
    public function test_getSpanDatesNextMonth()
    {
        $oDaySpan = new OA_Admin_DaySpan();

        $oDaySpan->oNowDate = new Date('2007-05-09');

        $aDates = $oDaySpan->_getSpanDates('next_month');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-06-01');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-06-30');

        $oDaySpan->oNowDate = new Date('2007-05-10');

        $aDates = $oDaySpan->_getSpanDates('next_month');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-06-01');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-06-30');
    }

    /**
     * A method to test the dates returned by the _getSpanDates()
     * method when used with the 'friendly' preset "last_month".
     */
    public function test_getSpanDatesLastMonth()
    {
        $oDaySpan = new OA_Admin_DaySpan();

        $oDaySpan->oNowDate = new Date('2007-05-09');

        $aDates = $oDaySpan->_getSpanDates('last_month');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-04-01');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-04-30');

        $oDaySpan->oNowDate = new Date('2007-05-10');

        $aDates = $oDaySpan->_getSpanDates('last_month');
        $this->assertEqual($aDates['start']->format('%Y-%m-%d'), '2007-04-01');
        $this->assertEqual($aDates['end']->format('%Y-%m-%d'), '2007-04-30');
    }

    /**
     * A method to test the setSpanPresetValue() method.
     */
    public function testSetSpanPresetValue()
    {
        $oDaySpan = new OA_Admin_DaySpan();

        $oDaySpan->oNowDate = new Date('2007-05-09');

        $oDaySpan->setSpanPresetValue('today');
        $this->assertEqual($oDaySpan->getStartDateString(), '2007-05-09');
        $this->assertEqual($oDaySpan->getEndDateString(), '2007-05-09');

        $oDaySpan->oNowDate = new Date('2007-05-10');

        $oDaySpan->setSpanPresetValue('today');
        $this->assertEqual($oDaySpan->getStartDateString(), '2007-05-10');
        $this->assertEqual($oDaySpan->getEndDateString(), '2007-05-10');
    }

    /**
     * A method to test the getPreset() method.
     */
    public function testGetPreset()
    {
        // Test with no dates set
        $oDaySpan = new OA_Admin_DaySpan();
        $oDaySpan->oStartDate = null;
        $oDaySpan->oEndDate = null;
        $result = $oDaySpan->getPreset();
        $this->assertNull($oDaySpan->oStartDate);
        $this->assertNull($oDaySpan->oEndDate);
        $this->assertEqual($result, 'specific');

        // Test with "today"
        $oDaySpan = new OA_Admin_DaySpan();
        $result = $oDaySpan->getPreset();
        $this->assertEqual($result, 'today');

        // Test with specific range
        $oDaySpan = new OA_Admin_DaySpan();
        $oTestStartDate = new Date('1987-04-12 15:10:11');
        $oTestEndDate = new Date('2004-10-12 23:59:59');
        $oDaySpan->setSpanDays($oTestStartDate, $oTestEndDate);
        $result = $oDaySpan->getPreset();
        $this->assertEqual($result, 'specific');
    }

    /**
     * A method to test the the getDaysInSpan() method.
     */
    public function testGetDaysInSpan()
    {
        $oDaySpan = new OA_Admin_DaySpan();

        $oTestStartDate = new Date('1999-12-31 12:34:56');
        $oDaySpan->setSpanDays($oTestStartDate, $oTestStartDate);
        $this->assertEqual($oDaySpan->getDaysInSpan(), 1);

        $oTestStartDate = new Date('1999-12-31 12:34:56');
        $oTestEndDate = new Date('2000-01-01 12:43:32');
        $oDaySpan->setSpanDays($oTestStartDate, $oTestEndDate);
        $this->assertEqual($oDaySpan->getDaysInSpan(), 2);

        $oTestStartDate = new Date('1999-12-31 12:34:56');
        $oTestEndDate = new Date('2000-03-01 12:43:32');
        $oDaySpan->setSpanDays($oTestStartDate, $oTestEndDate);
        $this->assertEqual($oDaySpan->getDaysInSpan(), 1 + 31 + 29 + 1); // 31st of Dec + All of Jan + All of Feb (leap year!) + 1st of Mar
    }

    /**
     * A method to test the getDayArray() method.
     */
    public function testGetDayArray()
    {
        $oDaySpan = new OA_Admin_DaySpan();

        $oTestStartDate = new Date('2006-09-26');
        $oTestEndDate = new Date('2006-09-26');
        $aExpectedResult = ['2006-09-26'];
        $oDaySpan->setSpanDays($oTestStartDate, $oTestEndDate);
        $this->assertEqual($oDaySpan->getDayArray(), $aExpectedResult);

        $oTestStartDate = new Date('2006-09-26');
        $oTestEndDate = new Date('2006-10-03');
        $aExpectedResult = [
            '2006-09-26',
            '2006-09-27',
            '2006-09-28',
            '2006-09-29',
            '2006-09-30',
            '2006-10-01',
            '2006-10-02',
            '2006-10-03',
        ];
        $oDaySpan->setSpanDays($oTestStartDate, $oTestEndDate);
        $this->assertEqual($oDaySpan->getDayArray(), $aExpectedResult);
    }
}
