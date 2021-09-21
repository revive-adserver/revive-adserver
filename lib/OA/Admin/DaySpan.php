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

require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A class to deal with day-based spans, for use in statistics screens, etc.
 *
 * @package    OpenXAdmin
 */
class OA_Admin_DaySpan
{
    /**
     * The current date, ie. "now".
     *
     * @var Date
     */
    public $oNowDate;

    /**
     * The start date of the span.
     *
     * @var Date|null
     */
    public $oStartDate;

    /**
     * The end date of the span.
     *
     * @var Date|null
     */
    public $oEndDate;

    /**
     * Constructor
     *
     * @param string An optional preset value based on a 'pre-defined
     *               'friendly' value.
     *
     * See the {@link OA_Admin_DaySpan::setSpanPresetValue()} method
     * for the pre-defined values.
     */
    public function __construct($presetValue = 'today')
    {
        $this->oNowDate = new Date();
        $this->setSpanPresetValue($presetValue);
    }


    /**
     * A method to set the span according to specific dates.
     *
     * @param Date $oStartDate The start date of the span.
     * @param Date $oEndDate The end date of the span.
     */
    public function setSpanDays($oStartDate, $oEndDate)
    {
        $this->oStartDate = new Date();
        $this->oStartDate->copy($oStartDate);
        $this->_setStartDate($this->oStartDate);
        $this->oEndDate = new Date();
        $this->oEndDate->copy($oEndDate);
        $this->_setEndDate($this->oEndDate);
    }

    /**
     * A method to return the start day of the span.
     *
     * @return Date The start day of the span.
     */
    public function getStartDate()
    {
        return $this->oStartDate;
    }

    /**
     * A method to return the end day of the span.
     *
     * @return Date The end day of the span.
     */
    public function getEndDate()
    {
        return $this->oEndDate;
    }

    /**
     * A method to return the start day of the span.
     *
     * @param string $format An optional PEAR::Date compatible format string.
     * @return string The start day of the span.
     */
    public function getStartDateString($format = '%Y-%m-%d')
    {
        return $this->oStartDate->format($format);
    }

    /**
     * A method to return the end day of the span.
     *
     * @param string $format An optional PEAR::Date compatible format string.
     * @return string The end day of the span.
     */
    public function getEndDateString($format = '%Y-%m-%d')
    {
        return $this->oEndDate->format($format);
    }

    /**
     * A method to return the start day of the span in UTC (ISO)
     *
     * @param string $format An optional PEAR::Date compatible format string.
     * @return string The start day of the span.
     */
    public function getStartDateStringUTC($format = '%Y-%m-%d')
    {
        $oDate = new Date($this->oStartDate);
        $oDate->toUTC();
        return $oDate->getDate(DATE_FORMAT_ISO);
    }

    /**
     * A method to return the end day of the span in UTC (ISO
     *
     * @param string $format An optional PEAR::Date compatible format string.
     * @return string The end day of the span.
     */
    public function getEndDateStringUTC($format = '%Y-%m-%d')
    {
        $oDate = new Date($this->oEndDate);
        $oDate->toUTC();
        return $oDate->getDate(DATE_FORMAT_ISO);
    }

    /**
     * A method to obtain the begining of week, according to the user's preferences.
     *
     * @return integer The begining of week. (Sunday is 0, Monday is 1, etc.).
     */
    public static function getBeginOfWeek()
    {
        if (isset($GLOBALS['_MAX']['PREF']['ui_week_start_day'])) {
            return $GLOBALS['_MAX']['PREF']['ui_week_start_day'];
        }
        return 0;
    }

    /**
     * A method to set the span, based on a pre-defined 'friendly' value.
     *
     * The predefined values are:
     *
     *  today, yesterday, this_week, last_week, last_7_days, this_month,
     *  this_month_full, this_month_remainder, next_month, last_month,
     *  all_stats, specific.
     *
     * @param string $presetValue The preset value string.
     * @return void
     */
    public function setSpanPresetValue($presetValue)
    {
        $aDates = $this->_getSpanDates($presetValue);
        $this->setSpanDays($aDates['start'], $aDates['end']);
    }

    /**
     * A method to return the pre-defined 'friendly' value based on the
     * span that has been set, if such a value exists - otherwise the
     * "specific" friendly will be returned.
     *
     * See the {@link OA_Admin_DaySpan::setSpanPresetValue()} method
     * for the pre-defined values.
     *
     * @return string The pre-defeined 'friendly' value, or the string
     *                "specific".
     */
    public function getPreset()
    {
        // Ensure the span has been set correctly, otherwise return "specific"
        if (
            null === $this->oStartDate || null === $this->oEndDate ||
            !is_a($this->oStartDate, 'Date') || !is_a($this->oEndDate, 'Date')
        ) {
            return 'specific';
        }
        // Does the span match "today"?
        $aDates = $this->_getSpanDates('today');
        if ($aDates['start'] == $this->oStartDate && $aDates['end'] == $this->oEndDate) {
            return 'today';
        }
        // Does the span match "yesterday"?
        $aDates = $this->_getSpanDates('yesterday');
        if ($aDates['start'] == $this->oStartDate && $aDates['end'] == $this->oEndDate) {
            return 'yesterday';
        }
        // Does the span match "this_week"?
        $aDates = $this->_getSpanDates('this_week');
        if ($aDates['start'] == $this->oStartDate && $aDates['end'] == $this->oEndDate) {
            return 'this_week';
        }
        // Does the span match "last_week"?
        $aDates = $this->_getSpanDates('last_week');
        if ($aDates['start'] == $this->oStartDate && $aDates['end'] == $this->oEndDate) {
            return 'last_week';
        }
        // Does the span match "last_7_days"?
        $aDates = $this->_getSpanDates('last_7_days');
        if ($aDates['start'] == $this->oStartDate && $aDates['end'] == $this->oEndDate) {
            return 'last_7_days';
        }
        // Does the span match "this_month"?
        $aDates = $this->_getSpanDates('this_month');
        if ($aDates['start'] == $this->oStartDate && $aDates['end'] == $this->oEndDate) {
            return 'this_month';
        }
        // Does the span match "this_month_full"?
        $aDates = $this->_getSpanDates('this_month_full');
        if ($aDates['start'] == $this->oStartDate && $aDates['end'] == $this->oEndDate) {
            return 'this_month_full';
        }
        // Does the span match "this_month_remainder"?
        $aDates = $this->_getSpanDates('this_month_remainder');
        if ($aDates['start'] == $this->oStartDate && $aDates['end'] == $this->oEndDate) {
            return 'this_month_remainder';
        }
        // Does the span match "next_month"?
        $aDates = $this->_getSpanDates('next_month');
        if ($aDates['start'] == $this->oStartDate && $aDates['end'] == $this->oEndDate) {
            return 'next_month';
        }
        // Does the span match "last_month"?
        $aDates = $this->_getSpanDates('last_month');
        if ($aDates['start'] == $this->oStartDate && $aDates['end'] == $this->oEndDate) {
            return 'last_month';
        }
        // Does not match any of the above
        return 'specific';
    }

    /**
     * A private method that returns the start and end dates
     * that bound the span, based based on a pre-defined 'friendly'
     * value.
     *
     * See the {@link OA_Admin_DaySpan::setSpanPresetValue()} method
     * for the pre-defined values.
     *
     * @param string $presetValue The preset value string.
     * @return array An array of two elements, "start" and "end",
     *               representing the start and end dates of
     *               the span, respectively.
     */
    public function _getSpanDates($presetValue)
    {
        switch ($presetValue) {
            case 'today':
                $oDateStart = new Date($this->oNowDate->format('%Y-%m-%d'));
                $oDateEnd = new Date($this->oNowDate->format('%Y-%m-%d'));
                break;
            case 'yesterday':
                $oDateStart = new Date(Date_Calc::prevDay($this->oNowDate->format('%d'), $this->oNowDate->format('%m'), $this->oNowDate->format('%Y')));
                $oDateEnd = new Date(Date_Calc::prevDay($this->oNowDate->format('%d'), $this->oNowDate->format('%m'), $this->oNowDate->format('%Y')));
                break;
            case 'this_week':
                $oDateStart = new Date(Date_Calc::beginOfWeek($this->oNowDate->format('%d'), $this->oNowDate->format('%m'), $this->oNowDate->format('%Y')));
                $oSixDaySpan = new Date_Span();
                $oSixDaySpan->setFromDays(6);
                $oSevenDaySpan = new Date_Span();
                $oSevenDaySpan->setFromDays(7);
                // Now have week start and end when week starts on Sunday
                // Does the user want to start on a different day?
                $beginOfWeek = OA_Admin_DaySpan::getBeginOfWeek();
                if ($beginOfWeek > 0) {
                    $oRequiredDaysSpan = new Date_Span();
                    $oRequiredDaysSpan->setFromDays($beginOfWeek);
                    $oDateStart->addSpan($oRequiredDaysSpan);
                    $oDateToday = new Date($this->oNowDate->format('%Y-%m-%d'));
                    if ($oDateToday->getDayOfWeek() < $beginOfWeek) {
                        $oDateStart->subtractSpan($oSevenDaySpan);
                    }
                }
                $oDateEnd = new Date($this->oNowDate->format('%Y-%m-%d'));
                break;
            case 'last_week':
                $oDateStart = new Date(Date_Calc::beginOfPrevWeek($this->oNowDate->format('%d'), $this->oNowDate->format('%m'), $this->oNowDate->format('%Y')));
                $oSixDaySpan = new Date_Span();
                $oSixDaySpan->setFromDays(6);
                $oSevenDaySpan = new Date_Span();
                $oSevenDaySpan->setFromDays(7);
                // Now have week start and end when week starts on Sunday
                // Does the user want to start on a different day?
                $beginOfWeek = OA_Admin_DaySpan::getBeginOfWeek();
                if ($beginOfWeek > 0) {
                    $oRequiredDaysSpan = new Date_Span();
                    $oRequiredDaysSpan->setFromDays($beginOfWeek);
                    $oDateStart->addSpan($oRequiredDaysSpan);
                    $oDateToday = new Date($this->oNowDate->format('%Y-%m-%d'));
                    if ($oDateToday->getDayOfWeek() < $beginOfWeek) {
                        $oDateStart->subtractSpan($oSevenDaySpan);
                    }
                }
                $oDateEnd = new Date($this->oNowDate->format('%Y-%m-%d'));
                $oDateEnd->copy($oDateStart);
                $oDateEnd->addSpan($oSixDaySpan);
                break;
            case 'last_7_days':
                $oDateStart = new Date($this->oNowDate->format('%Y-%m-%d'));
                $oDateEnd = new Date($this->oNowDate->format('%Y-%m-%d'));
                $oOneDaySpan = new Date_Span();
                $oOneDaySpan->setFromDays(1);
                $oSevenDaySpan = new Date_Span();
                $oSevenDaySpan->setFromDays(7);
                $oDateStart->subtractSpan($oSevenDaySpan);
                $oDateEnd->subtractSpan($oOneDaySpan);
                break;
            case 'this_month':
                $oDateStart = new Date(Date_Calc::beginOfMonth($this->oNowDate->format('%m'), $this->oNowDate->format('%Y')));
                $oDateEnd = new Date($this->oNowDate->format('%Y-%m-%d'));
                break;
            case 'this_month_full':
                $oDateStart = new Date(Date_Calc::beginOfMonth($this->oNowDate->format('%m'), $this->oNowDate->format('%Y')));
                $oDateEnd = new Date(Date_Calc::beginOfNextMonth($this->oNowDate->format('%d'), $this->oNowDate->format('%m'), $this->oNowDate->format('%Y')));
                $oOneDaySpan = new Date_Span();
                $oOneDaySpan->setFromDays(1);
                $oDateEnd->subtractSpan($oOneDaySpan);
                break;
            case 'this_month_remainder':
                $oDateStart = new Date($this->oNowDate->format('%Y-%m-%d'));
                $oDateEnd = new Date(Date_Calc::beginOfNextMonth($this->oNowDate->format('%d'), $this->oNowDate->format('%m'), $this->oNowDate->format('%Y')));
                $oOneDaySpan = new Date_Span();
                $oOneDaySpan->setFromDays(1);
                $oDateEnd->subtractSpan($oOneDaySpan);
                break;
            case 'next_month':
                $oDateStart = new Date(Date_Calc::beginOfNextMonth($this->oNowDate->format('%d'), $this->oNowDate->format('%m'), $this->oNowDate->format('%Y')));
                $oDateEnd = new Date(Date_Calc::endOfNextMonth($this->oNowDate->format('%d'), $this->oNowDate->format('%m'), $this->oNowDate->format('%Y')));
                break;
            case 'last_month':
                $oDateStart = new Date(Date_Calc::beginOfPrevMonth($this->oNowDate->format('%d'), $this->oNowDate->format('%m'), $this->oNowDate->format('%Y')));
                $oDateEnd = new Date(Date_Calc::beginOfMonth($this->oNowDate->format('%m'), $this->oNowDate->format('%Y')));
                $oOneDaySpan = new Date_Span();
                $oOneDaySpan->setFromDays(1);
                $oDateEnd->subtractSpan($oOneDaySpan);
                break;
            case 'all_stats':
                $oDateStart = null;
                $oDateEnd = null;
                break;
            case 'specific':
                $startDate = MAX_getStoredValue('startDate', date('Y-m-d'));
                $oDateStart = new Date($startDate);
                $endDate = MAX_getStoredValue('endDate', date('Y-m-d'));
                $oDateEnd = new Date($endDate);
                break;
        }
        $this->_setStartDate($oDateStart);
        $this->_setEndDate($oDateEnd);
        return [
            'start' => $oDateStart,
            'end' => $oDateEnd
        ];
    }

    /**
     * A method to return the number of days in the span, including the start and end days.
     *
     * @return integer The number of days in the span.
     */
    public function getDaysInSpan()
    {
        $oSpan = new Date_Span();
        $oSpan->setFromDateDiff($this->oStartDate, $this->oEndDate);
        return (int) floor($oSpan->toDays()) + 1;
    }

    /**
     * A method to return an array containing the days in the span, including the start
     * and end days, where each day in the array is formatted as a string.
     *
     * @param string $format An optional PEAR::Date compatible format string.
     * @return array An array of the days in the span.
     */
    public function getDayArray($format = '%Y-%m-%d')
    {
        $aDays = [];
        $oDate = new Date();
        $oDate->copy($this->oStartDate);
        while (!$oDate->after($this->oEndDate)) {
            $aDays[] = $oDate->format($format);
            $oDate->addSeconds(SECONDS_PER_DAY);
        }
        return $aDays;
    }

    /**
     * A method to convert the object's start and end dates into UTC format.
     */
    public function toUTC()
    {
        $this->oStartDate->toUTC();
        $this->oEndDate->toUTC();
    }

    /**
     * A private method to set a PEAR::Date object to have the time set to
     * 00:00:00, where the date is at the start of a day.
     *
     * @param PEAR::Date $oDate The date to "round".
     * @return void
     */
    public function _setStartDate(&$oDate)
    {
        if (is_a($oDate, 'date')) {
            $oDate->setHour(0);
            $oDate->setMinute(0);
            $oDate->setSecond(0);
        }
    }

    /**
     * A private method to set a PEAR::Date object to have the time set to
     * 23:59:59, where the date is at the end of a day.
     *
     * @param PEAR::Date $oDate The date to "round".
     * @return void
     */
    public function _setEndDate(&$oDate)
    {
        if (is_a($oDate, 'date')) {
            $oDate->setHour(23);
            $oDate->setMinute(59);
            $oDate->setSecond(59);
        }
    }
}
