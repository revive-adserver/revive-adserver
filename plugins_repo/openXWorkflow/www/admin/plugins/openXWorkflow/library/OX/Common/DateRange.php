<?php

/**
 * A flexible date range that supports a number of options for defining the start and
 * end date of the range.
 */
final class OX_Common_DateRange
{
    const DATE_RANGE_TODAY = "today";
    const DATE_RANGE_YESTERDAY = "yesterday";
    const DATE_RANGE_LAST_7_DAYS = "last-7-days";
    const DATE_RANGE_LAST_30_DAYS = "last-30-days";
    const DATE_RANGE_LAST_3_MONTHS = "last-3-months";
    const DATE_RANGE_LAST_YEAR = "last-year";
    const DATE_RANGE_ALL_TIME = "all-time";
    
    /**
     * The actual start date for the range.
     * 
     * @var Zend_Date
     */
    private $startDate;
    
    /**
     * The actual end date for the range.
     * 
     * @var Zend_Date
     */
    private $endDate;
    
    /**
     * Name of the current date range or null.
     */
    private $range;
    
    private static $ranges;


    /**
     * Creates an empty range that has all range, start and end dates set to null.
     */
    public function __construct($rangeSpec = null)
    {
        $this->setRange($rangeSpec);
    }


    /**
     * @return Zend_Date
     */
    public function getStartDate()
    {
        return $this->startDate;
    }


    /**
     * @return Zend_Date
     */
    public function getEndDate()
    {
        return $this->endDate;
    }


    public function setRange($rangeSpec)
    {
        $range = OX_Common_StringUtils::nullOrValue($rangeSpec);
        if ($range) {
            switch ($range) {
                case self::DATE_RANGE_TODAY :
                    $this->startDate = $this->dateWithDaysOffset(0);
                    $this->endDate = $this->dateWithDaysOffset(0, true);
                    break;
                
                case self::DATE_RANGE_YESTERDAY :
                    $this->startDate = $this->dateWithDaysOffset(-1);
                    $this->endDate = $this->dateWithDaysOffset(-1, true);
                    break;
                
                case self::DATE_RANGE_LAST_7_DAYS :
                    $this->startDate = $this->dateWithDaysOffset(-7);
                    $this->endDate = $this->dateWithDaysOffset(-1, true);
                    break;
                
                case self::DATE_RANGE_LAST_30_DAYS :
                    $this->startDate = $this->dateWithDaysOffset(-30);
                    $this->endDate = $this->dateWithDaysOffset(-1, true);
                    break;
                
                case self::DATE_RANGE_LAST_3_MONTHS :
                    $this->startDate = $this->dateWithDaysOffset(-90);
                    $this->endDate = $this->dateWithDaysOffset(-1, true);
                    break;
                
                case self::DATE_RANGE_LAST_YEAR :
                    $this->startDate = $this->dateWithDaysOffset(-365);
                    $this->endDate = $this->dateWithDaysOffset(-1, true);
                    break;
                
                case self::DATE_RANGE_ALL_TIME :
                    $this->startDate = null;
                    $this->endDate = null;
                    break;
                
                default :
                    throw new Exception("Unknown date range:" . $range);
            }
            $this->range = $rangeSpec;
        }
        else {
            $this->range = null;
        }
    }


    public function isPredefinedRange()
    {
        return $this->range !== null;
    }


    public function getRangeId()
    {
        return $this->range;
    }


    private function dateWithDaysOffset($daysOffset, $setEndOfDay = false)
    {
        $today = Zend_Date::now();
        if (!$setEndOfDay) {
            return OX_Common_DateUtils::setTimeToBeginningOfTheDay($today->addDay($daysOffset));
        } else {
            return OX_Common_DateUtils::setTimeToEndOfTheDay($today->addDay($daysOffset));
        }
    }


    public function setStartDate(Zend_Date $startDate = null)
    {
        if ($startDate) {
            $this->startDate = OX_Common_DateUtils::setTimeToBeginningOfTheDay($startDate);
        }
        else {
            $this->startDate = null;
        }
        $this->range = null;
    }


    public function setEndDate(Zend_Date $endDate = null)
    {
        if ($endDate) {
            $this->endDate = OX_Common_DateUtils::setTimeToEndOfTheDay($endDate);
        }
        else {
            $this->endDate = null;
        }
        $this->range = null;
    }


    public function getName()
    {
        return self::getRangeName($this->range);
    }



    public function swapIfEndBeforeStart()
    {
        if ($this->startDate && $this->endDate && $this->startDate->isLater($this->endDate)) {
            $tmp = $this->startDate;
            $this->startDate = $this->endDate;
            $this->endDate = $tmp;
        }
    }


    public static function getRanges($ids = null)
    {
        if (!self::$ranges) {
            self::$ranges = array (
                    self::DATE_RANGE_TODAY => 'Today', 
                    self::DATE_RANGE_YESTERDAY => 'Yesterday', 
                    self::DATE_RANGE_LAST_7_DAYS => 'Last 7 days', 
                    self::DATE_RANGE_LAST_30_DAYS => 'Last 30 days', 
                    self::DATE_RANGE_LAST_3_MONTHS => 'Last 3 months', 
                    self::DATE_RANGE_LAST_YEAR => 'Last year', 
                    self::DATE_RANGE_ALL_TIME => 'All time');
        }
        
        if ($ids) {
            $result = array ();
            foreach (self::$ranges as $id => $value) {
                if (in_array($id, $ids)) {
                    $result[$id] = $value;
                }
            }
            
            return $result;
        }
        else {
            return self::$ranges;
        }
    }


    public static function getRangeIds()
    {
        return array_keys(self::getRanges());
    }


    public static function getRangeName($rangeId)
    {
        self::getRanges(); // need this to initialize the array if needed
        return self::$ranges[$rangeId];
    }
}
