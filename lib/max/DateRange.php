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

/**
 * A period of time between two dates
 */
class DateRange
{
    /* The date/time considered to be 'now'
     *  @var Date */
    public $_now;

    /* @var Date */
    public $_start;

    /* @var Date */
    public $_end;

    /* @var int */
    public $_first_day_of_week;

    /**
     * PHP4-style constructor
     *
     * @param Date now
     */
    public function __construct($now = null)
    {
        if (is_null($now)) {
            // default to the current datetime
            $now = new Date();
        }
        $this->_now = $now;
        $this->_start = $now;
        $this->_end = $now;
    }

    /**
     * Factory method to produce a date range loaded with today's date.
     */
    public function newToday($now)
    {
        $range = new DateRange($now);
        $range->useToday();
        return $range;
    }

    public function useToday()
    {
        $today_start = $this->_midnight($this->_now);
        $today_end = $this->_add24Hours($today_start);

        $this->_start = $today_start;
        $this->_end = $today_end;
    }

    public function useYesterday()
    {
        $yesterday_end = $this->_midnight($this->_now);
        $yesterday_start = $this->_subtractDays($yesterday_end, 1);

        $this->_start = $yesterday_start;
        $this->_end = $yesterday_end;
    }

    public function useThisWeek()
    {
        $start_of_this_week = $this->startOfThisWeek();
        $start_of_next_week = $this->_addDays($start_of_this_week, 7);

        $this->_start = $start_of_this_week;
        $this->_end = $start_of_next_week;
    }

    /**
     * Set the date range to the previous Sunday-Sunday period.
     */
    public function useLastWeek()
    {
        $start_of_this_week = $this->startOfThisWeek();
        $start_of_previous_week = $this->_subtractDays($start_of_this_week, 7);

        $this->_start = $start_of_previous_week;
        $this->_end = $start_of_this_week;
    }

    /**
     * Set the date range to be the 7-day period ending yesterday.
     */
    public function useLast7Days()
    {
        $this->useLastDays(7);
    }

    public function useLastDays($number_of_days)
    {
        $week_end = $this->_midnight($this->_now);
        $week_start = $this->_subtractDays($week_end, $number_of_days);

        $this->_start = $week_start;
        $this->_end = $week_end;
    }

    /**
     * Set the date range to be from the first of last month to the last.
     */
    public function useLastMonth()
    {
        $this_month_start = $this->_startOfMonth($this->_now);
        $last_month_start = $this->_startOfPreviousMonth($this_month_start);

        $this->_start = $last_month_start;
        $this->_end = $this_month_start;
    }

    /**
     * Set the date range to be from the first of this month to the last of this month.
     *
     */
    public function useThisMonth()
    {
        $this_month_start = $this->_startOfMonth($this->_now);
        $next_month_sometime = $this->_addDays($this_month_start, 40);
        $next_month_start = $this->_startOfMonth($next_month_sometime);

        $this->_start = $this_month_start;
        $this->_end = $next_month_start;
    }

    /**
     * Set the date range to be from the first of next month to the last of next month.
     */
    public function useNextMonth()
    {
        $this_month_start = $this->_startOfMonth($this->_now);
        $next_month_start = $this->_startOfNextMonth($this_month_start);
        $following_month_start = $this->_startOfNextMonth($next_month_start);

        $this->_start = $next_month_start;
        $this->_end = $following_month_start;
    }

    public function useMonthRemainder()
    {
        $start_of_today = $this->_midnight($this->_now);
        $end_of_month = $this->_startOfNextMonth($start_of_today);

        $this->_start = $start_of_today;
        $this->_end = $end_of_month;
    }

    public function useTextSpecifier($specifier)
    {
        switch ($specifier) {
            case 'today':
                $this->useToday();
                break;
            case 'yesterday':
                $this->useYesterday();
                break;
            case 'lastmonth':
                $this->useLastMonth();
                break;
            case 'lastweek':
                $this->useLastWeek();
                break;
            case 'last7days':
                $this->useLast7Days();
                break;
            case 'thisweek':
                $this->useThisWeek();
                break;
            case 'thismonth':
                $this->useThisMonth();
                break;
            case 'allstats':
                $this->_start = null;
                $this->_end = null;
                break;
            default:
                trigger_error(PRODUCT_NAME . " encountered date range description that it didn't recognise: '$specifier'");
                break;
        }
    }

    public function _startOfPreviousMonth($this_month_start)
    {
        $day = $this_month_start->getDay();
        $last_month_final_day = $this->_subtractDays($this_month_start, $day);
        $days_last_month = $last_month_final_day->getDay();

        $last_month_start = $this->_subtractDays($this_month_start, $days_last_month);

        return $last_month_start;
    }

    public function _startOfNextMonth($current_date)
    {
        $days_this_month = $current_date->getDaysInMonth();
        $current_day = $current_date->getDay();
        $days_till_end = $days_this_month - $current_day;
        $next_month_start = $this->_addDays($current_date, $days_till_end + 1);

        return $next_month_start;
    }

    public function _midnight($date)
    {
        $processed_date = new Date($date);
        $processed_date->setHour(0);
        $processed_date->setMinute(0);
        $processed_date->setSecond(0);
        return $processed_date;
    }

    public function _nextMidnight($date)
    {
        return $this->_add24Hours($this->_midnight($date));
    }

    public function _startOfMonth($date)
    {
        $processed_date = $this->_midnight($date);
        $processed_date->setDay(1);
        return $processed_date;
    }

    public function _add24Hours($base_date)
    {
        $modified_date = new Date($base_date);
        $modified_date->addSeconds(60 * 60 * 24);
        return $modified_date;
    }

    public function _subtractDays($base_date, $days)
    {
        $modified_date = new Date($base_date);
        $span = new Date_Span((string) $days, '%D');
        $modified_date->subtractSpan($span);
        return $modified_date;
    }

    public function _addDays($base_date, $days)
    {
        $modified_date = new Date($base_date);
        $span = new Date_Span((string) $days, '%D');
        $modified_date->addSpan($span);
        return $modified_date;
    }

    /**
     * The end of this range.
     *
     * @return Date A date object representing the start of the range
     */
    public function getStartDate()
    {
        return $this->_start;
    }

    /**
     * The end of this range.
     *
     * @return Date A date object representing the end of the range
     */
    public function getEndDate()
    {
        return $this->_end;
    }

    /**
     * Use the values from a $_GET-style array.
     *
     * @todo Extract some of the logic into separate methods
     */
    public function useValuesFromQueryArray($values, $base_key)
    {
        $preset_key = $base_key . '_preset';
        $start_key = $base_key . '_start';
        $end_key = $base_key . '_end';

        $preset_string = $values[$preset_key];
        if (!isset($preset_string)) {
            $preset_string = 'specific';
        }
        $start_string = $values[$start_key];
        $end_string = $values[$end_key];


        if ($preset_string == 'specific') {
            if (!($start_string && $end_string)) {
                trigger_error(PRODUCT_NAME . " was asked to generate a date range but wasn't given dates.");
            }
            $this->setDateRangeByNaturalHumanStrings($start_string, $end_string);
        } else {
            $this->useTextSpecifier($preset_string);
        }
    }

    public function setDateRangeByInclusiveDates($start_date, $end_date)
    {
        $internal_end_date = $this->_nextMidnight($end_date);
        $this->_start = $start_date;
        $this->_end = $internal_end_date;
    }

    /**
     * Set the start and end dates of this range from string representations of dates.
     */
    public function setDateRangeByNaturalHumanStrings($start_string, $end_string)
    {
        $start_date = new Date($start_string);
        $human_end_date = new Date($end_string);
        $this->setDateRangeByInclusiveDates($start_date, $human_end_date);
    }

    public function getStartSql()
    {
        $sql = $this->_start->format('%Y-%m-%d %H:%M:%S');
        return "'" . $sql . "'";
    }

    public function getEndSqlForComparingTimestamps()
    {
        $sql = $this->_end->format('%Y-%m-%d %H:%M:%S');
        return "'" . $sql . "'";
    }

    public function getEndSqlForComparingDays()
    {
        $previous_day = $this->getHumanEndDate();
        $sql = $previous_day->format('%Y-%m-%d');
        return "'" . $sql . "'";
    }

    /**
     * Format the date representing the start of this range.
     *
     * @return string
     */
    public function getStartDateForDisplay()
    {
        $display = $this->formatDateForDisplay($this->_start);
        return $display;
    }

    /**
     * Format the date representing the end of this range.
     *
     * More complicated than simply formatting the end date object directly,
     * because the the internal representation of a date-time is quite different
     * from a human concept of the end of a day.
     *
     * @return string
     */
    public function getEndDateForDisplay()
    {
        $previous_day = $this->getHumanEndDate();
        $display = $this->formatDateForDisplay($previous_day);
        return $display;
    }

    public function formatDateForDisplay($date)
    {
        return $date->format('%d/%m/%Y');
    }

    public function formatDateForFilename($date)
    {
        return $date->format('%Y-%b-%d');
    }

    public function getStartDateForFilename()
    {
        $filename = $this->formatDateForFilename($this->_start);
        return $filename;
    }

    public function getEndDateForFilename()
    {
        $previous_day = $this->getHumanEndDate();
        $display = $this->formatDateForFilename($previous_day);
        return $display;
    }

    public function getHumanEndDate()
    {
        return $this->_subtractDays($this->_end, 1);
    }

    /**
     * How many whole days are covered by the range?
     *
     * @return int The number of whole days covered by the range.
     */
    public function countDays()
    {
        $start = $this->getStartDate();
        $end = $this->getEndDate();

        $days = Date_Calc::dateDiff(
            $start->getDay(),
            $start->getMonth(),
            $start->getYear(),
            $end->getDay(),
            $end->getMonth(),
            $end->getYear()
        );
        return $days;
    }

    /**
     * Count the number of times a certain weekday occurs with the range.
     *
     * By default, zero represents Sunday.
     *
     * @param int $weekday_number
     * @parma int $number_representing_sunday
     */
    public function countDayOfWeekOccurances($weekday_number, $number_representing_sunday = 0)
    {
        $active_day = $this->getStartDate();
        $end = $this->getEndDate();

        $occurances = 0;
        while ($active_day->before($end)) {
            $active_weekday = $active_day->getDayOfWeek();
            $zero_based_weekday = ($number_representing_sunday + $weekday_number) % 7;
            if ($active_weekday == $zero_based_weekday) {
                $occurances++;
            }
            $active_day = $this->_add24Hours($active_day);
        }
        return $occurances;
    }

    /**
     * Does another range end after this one does?
     *
     * @param DateRange $other_range
     * @return bool True if the other range ends after this one.
     */
    public function endsAfter($other_range)
    {
        $this_end = $this->getEndDate();
        $other_end = $other_range->getEndDate();
        return $this_end->after($other_end);
    }

    /**
     * Does another range start before this one does?
     *
     * @param DateRange $other_range
     * @return bool True if the other range starts before this one.
     */
    public function startsBefore($other_range)
    {
        $this_start = $this->getStartDate();
        $other_start = $other_range->getStartDate();
        return $this_start->before($other_start);
    }

    /**
     * Does this range end before it starts?
     *
     * In other words, is this an empty range?
     *
     * @return bool True if the range is empty.
     */
    public function endsBeforeStarts()
    {
        return $this->_end->before($this->_start);
    }

    /**
     * @param int $day_number
     */
    public function setStartOfWeek($day_number)
    {
        $this->_first_day_of_week = $day_number;
    }

    /**
     * A date for the first day of this week.
     *
     * The date returned is based on instance variables 'now' and 'first_day_of_week'.
     *
     * @return Date The first second of the current week
     */
    public function startOfThisWeek()
    {
        $base_date = $this->_now;
        $days_since_sunday = $base_date->getDayOfWeek();
        $days_since_start_of_week = $days_since_sunday - $this->_first_day_of_week;
        $start_of_week = $this->_midnight($base_date);
        $start_of_week = $this->_subtractDays($start_of_week, $days_since_start_of_week);

        return $start_of_week;
    }
}
