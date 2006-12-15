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

require_once ("Date.php");

/**
 * A class which contains a span of days (start date and end date), to be used in statistics and reporting functions.
 *
 * @package    Max
 * @author     Scott Switzer <scott@switzer.org>
 */
class DaySpan
{
    /* @var Date */
    var $_startDate;

    /* @var Date */
    var $_endDate;

    /* @var Name */
    var $_spanName;

    /**
     * PHP5-style constructor
     *
     * @param string an initial preset value based on a 'friendly' date span.
     */
    function __construct($presetValue = 'today')
    {
        $this->setSpanPresetValue($presetValue);
    }

    /**
     * PHP4-style constructor
     *
     * @param string an initial preset value based on a 'friendly' date span.
     */
    function DaySpan($presetValue = 'today')
    {
        $this->__construct($presetValue);
    }
    
    /**
     * A method to set the span according to one of the pre-defined 'friendly' dates.
     * The predefined values are:
     *     today, yesterday, this_week, last_week, last_7_days, this_month, last_maonth,
     *     this_month_remainder, next_month
     *
     * @param string $presetValue The preset value string.
     */
   function setSpanPresetValue($presetValue)
    {
        switch ($presetValue) {
            case 'today' :
                $dateStart = & new Date();
                $dateEnd   = & new Date();
                $this->setSpanDays($dateStart, $dateEnd);
                break;
            case 'yesterday' :
                $dateStart = & new Date(Date_Calc::prevDay());
                $dateEnd   = & new Date(Date_Calc::prevDay());
                $this->setSpanDays($dateStart, $dateEnd);
                break;
            case 'last_7_days' :
                $dateStart = & new Date();
                $dateStart->subtractSpan(new Date_Span('7, 0, 0, 0'));
                $dateEnd   = & new Date();
                $dateEnd->subtractSpan(new Date_Span('1, 0, 0, 0'));
                $this->setSpanDays($dateStart, $dateEnd);
                break;
            case 'this_week' :
                $beginOfWeek = DaySpan::getBeginOfWeek();
                $dateToday   = & new Date();
                $dateStart = & new Date(Date_Calc::beginOfWeek());
                if ($beginOfWeek > 0) {
                    $dateStart->addSpan(new Date_Span($beginOfWeek.', 0, 0, 0'));
                    if ($dateToday->getDayOfWeek() < $beginOfWeek) {
                        $dateStart->subtractSpan(new Date_Span('7, 0, 0, 0'));
                    }
                }
                $dateEnd   = & new Date();
                $this->setSpanDays($dateStart, $dateEnd);
                break;
            case 'last_week' :
                $beginOfWeek = DaySpan::getBeginOfWeek();
                $dateToday   = & new Date();
                $dateStart = & new Date(Date_Calc::beginOfPrevWeek());
                if ($beginOfWeek > 0) {
                    $dateStart->addSpan(new Date_Span($beginOfWeek.', 0, 0, 0'));
                    if ($dateToday->getDayOfWeek() < $beginOfWeek) {
                        $dateStart->subtractSpan(new Date_Span('7, 0, 0, 0'));
                    }
                }
                $dateEnd   = & new Date($dateStart);
                $dateEnd->addSpan(new Date_Span('6, 0, 0, 0'));
                $this->setSpanDays($dateStart, $dateEnd);
                break;
            case 'this_month' : 
                $dateStart = & new Date(Date_Calc::beginOfMonth());
                $dateEnd   = & new Date();
                $this->setSpanDays($dateStart, $dateEnd);
                break;
            case 'this_month_full' : 
                $dateStart = & new Date(Date_Calc::beginOfMonth());
                $dateEnd   = & new Date(Date_Calc::beginOfNextMonth());
                $dateEnd->subtractSpan(new Date_Span('1, 0, 0, 0'));
                $this->setSpanDays($dateStart, $dateEnd);
                break;
            case 'this_month_remainder' : 
                $dateStart = & new Date();
                $dateEnd   = & new Date(Date_Calc::beginOfNextMonth());
                $dateEnd->subtractSpan(new Date_Span('1, 0, 0, 0'));
                $this->setSpanDays($dateStart, $dateEnd);
                break;
            case 'next_month' :
                $dateStart = & new Date(Date_Calc::beginOfNextMonth());
                $dateEnd   = & new Date(Date_Calc::endOfNextMonth());
                $this->setSpanDays($dateStart, $dateEnd);
                break;
            case 'last_month' :
                $dateStart = & new Date(Date_Calc::beginOfPrevMonth());
                $dateEnd   = & new Date(Date_Calc::beginOfMonth());
                $dateEnd->subtractSpan(new Date_Span("1, 0, 0, 0"));
                $this->setSpanDays($dateStart, $dateEnd);
                break;
        }
    }

    /**
     * A method to set the span according to specific dates.
     *
     * @param Date $oStartDate The start date.
     * @param Date $oEndDate The end date.
     */
    function setSpanDays($oStartDate, $oEndDate)
    {
        $this->_startDate = $oStartDate;
        $this->_endDate = $oEndDate;
    }
    
    /**
     * The start day of the DaySpan.
     * @return Date A date object representing the start of the span
     */
    function getStartDate()
    {
        return $this->_startDate;
    }

    /**
     * The end day of the DaySpan.
     * @return Date A date object representing the end of the span
     */
    function getEndDate()
    {
        return $this->_endDate;
    }

    /**
     * A string representation of the start day of the DaySpan.
     * @param string $format The format of the string (see format rules in Pear::Date->format)
     * @return Date A date object representing the start of the span
     */
    function getStartDateString($format = '%Y-%m-%d')
    {
        
        return $this->_startDate->format($format);
    }

    /**
     * A string representation of the end day of the DaySpan.
     * @param string $format The format of the string (see format rules in Pear::Date->format)
     * @return Date A date object representing the end of the span
     */
    function getEndDateString($format = '%Y-%m-%d')
    {
        return $this->_endDate->format($format);
    }
    
    /**
     * A method to return the number of days in the span (including the start and end date)
     * @return integer The number of days covered by the span (inclusive).
     */
    function getDaysInSpan()
    {
        $startDate = strtotime($this->getStartDateString());
        $endDate   = strtotime($this->getEndDateString());
        
        return floor(($endDate - $startDate) / 86400);
    }
    
    /**
     * A method to return the number of instances of each day of week (0=Sunday, 1=Monday, etc.)
     * @return array The number of instances of each day of week (0=Sunday, 1=Monday, etc.)
     */
    function getDayOfWeekCount()
    {
        $aDayOfWeek = array(
            0 => 0,
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
        );
        
        $startDay = $this->getStartDate();
        $endDay = $this->getEndDate();
        $oneDay = new Date_Span();
        $oneDay->setFromDays(1);

        $activeDay = new Date($startDay);
        
        while (!$activeDay->after($endDay))
        {
            $dayOfWeek = $activeDay->getDayOfWeek();
            $aDayOfWeek[$dayOfWeek]++;
            $activeDay->addSpan($oneDay);
        }
        return $aDayOfWeek;
        
    }
    
    /**
     * A method to return an array with the days of the span.
     */
    function getDayArray($format = '%Y-%m-%d')
    {
        $aDays = array();
        $startDay = $this->getStartDate();
        $endDay = $this->getEndDate();
        $oneDay = new Date_Span();
        $oneDay->setFromDays(1);

        $activeDay = new Date($startDay);
        
        while (!$activeDay->after($endDay))
        {
            $aDays[] = $activeDay->format($format);
            $activeDay->addSpan($oneDay);
        }
        
        return $aDays;
        
    }
    
    /**
     * Figure out the intersection of start days and end days with another dayspan.  If there
     * is no intersection, this method returns false.
     *
     * @param DaySpan $oDaySpan
     * @return DaySpan
     */
    function getIntersection($oDaySpan)
    {
        $thisStartDate = $this->getStartDate();
        $thisEndDate = $this->getEndDate();
        $thatStartDate = $oDaySpan->getStartDate();
        $thatEndDate = $oDaySpan->getEndDate();
        
        if (Date_Calc::compareDates(
            $thisStartDate->getDay(),
            $thisStartDate->getMonth(),
            $thisStartDate->getYear(),
            $thatStartDate->getDay(),
            $thatStartDate->getMonth(),
            $thatStartDate->getYear()
            ) == 1) {
            $startDate = new Date($thisStartDate);
        } else {
            $startDate = new Date($thatStartDate);
        }
        
        if (Date_Calc::compareDates(
            $thisEndDate->getDay(),
            $thisEndDate->getMonth(),
            $thisEndDate->getYear(),
            $thatEndDate->getDay(),
            $thatEndDate->getMonth(),
            $thatEndDate->getYear()
            ) == -1) {
            $endDate = new Date($thisEndDate);
        } else {
            $endDate = new Date($thatEndDate);
        }
        
        if (Date_Calc::compareDates(
            $startDate->getDay(),
            $startDate->getMonth(),
            $startDate->getYear(),
            $endDate->getDay(),
            $endDate->getMonth(),
            $endDate->getYear()
            ) == 1) {
            $intersectionSpan = false;
        } else {
            $intersectionSpan = new DaySpan();
            $intersectionSpan->setSpanDays($startDate, $endDate);
        }
        
        return $intersectionSpan;
    }
    
    /**
     * A method to return the begin of week according to user preferences (0=Sunday, 1=Monday, etc.)
     * @return array The begin of week according to user preferences (0=Sunday, 1=Monday, etc.)
     */
    function getBeginOfWeek()
    {
        if (isset($GLOBALS['_MAX']['PREF']['begin_of_week'])) {
            return $GLOBALS['_MAX']['PREF']['begin_of_week'];
        }
        
        return 0;
    }



    /**
     * A method to set the span according to one of the pre-defined 'friendly' dates.
     * The predefined values are:
     *     today, yesterday, this_week, last_week, last_7_days, this_month, last_maonth,
     *     this_month_remainder, next_month
     *
     * @param string $presetValue The preset value string.
     */
   function setSpanName($sd, $ed)
   {
      $this->_startDate = $sd;
      $this->_endDate = $ed;


      $dateStart = & new Date();
      $dateEnd   = & new Date();
      $this->_roundDate(& $dateStart);
      $this->_roundDate(& $dateEnd);
      $this->_fixDate(& $dateStart);
      $this->_fixDate(& $dateEnd);


      if($dateStart == $this->_startDate && $dateEnd == $this->_endDate) {
            return 'today';
      }
      
      $dateStart = & new Date(Date_Calc::prevDay());
      $dateEnd = & new Date(Date_Calc::prevDay());

      if($dateStart == $this->_startDate && $dateEnd == $this->_endDate) {
            return 'yesterday';
      }      

      $dateStart = & new Date();
      $dateStart->subtractSpan(new Date_Span( Date::getDayOfWeek() - 1 . ',0, 0, 0'));

      $dateEnd   = & new Date();
      $dateEnd->subtractSpan(new Date_Span('0, 0, 0, 0'));

      $this->_roundDate(& $dateStart);
      $this->_roundDate(& $dateEnd);
      $this->_fixDate(& $dateStart);
      $this->_fixDate(& $dateEnd);

      if($dateStart == $this->_startDate && $dateEnd == $this->_endDate) {
            return 'this_week';
      }      


      $dateStart = & new Date();
      $dateStart->subtractSpan(new Date_Span('7, 0, 0, 0'));
      $dateEnd   = & new Date(); 
      $dateEnd->subtractSpan(new Date_Span('1, 0, 0, 0'));

      $this->_roundDate(& $dateStart);
      $this->_roundDate(& $dateEnd);
      $this->_fixDate(& $dateStart);
      $this->_fixDate(& $dateEnd);

      if($dateStart == $this->_startDate && $dateEnd == $this->_endDate) {
            return 'last_7_days';
      }      


      $beginOfWeek = DaySpan::getBeginOfWeek();
      $dateToday   = & new Date();
      $dateStart = & new Date(Date_Calc::beginOfPrevWeek());
          if ($beginOfWeek > 0) {
              $dateStart->addSpan(new Date_Span($beginOfWeek.', 0, 0, 0'));
              if ($dateToday->getDayOfWeek() < $beginOfWeek) {
                  $dateStart->subtractSpan(new Date_Span('7, 0, 0, 0'));
              }
          }
      $dateEnd   = & new Date($dateStart);
      $dateEnd->addSpan(new Date_Span('6, 0, 0, 0'));




      if($dateStart == $this->_startDate && $dateEnd == $this->_endDate) {
            return 'last_week';
      }      


      $dateStart = & new Date(Date_Calc::beginOfMonth());
      $dateEnd   = & new Date();

      $this->_roundDate(& $dateStart);
      $this->_roundDate(& $dateEnd);
      $this->_fixDate(& $dateStart);
      $this->_fixDate(& $dateEnd);

      if($dateStart == $this->_startDate && $dateEnd == $this->_endDate) {
            return 'this_month';
      }      


      $dateStart = & new Date(Date_Calc::beginOfMonth());
      $dateEnd   = & new Date(Date_Calc::beginOfNextMonth());
      $dateEnd->subtractSpan(new Date_Span('1, 0, 0, 0'));

      if($dateStart == $this->_startDate && $dateEnd == $this->_endDate) {
            return 'this_month_full';
      }      


      $dateStart = & new Date();
      $dateEnd   = & new Date(Date_Calc::beginOfNextMonth());
      $dateEnd->subtractSpan(new Date_Span('1, 0, 0, 0'));

      if($dateStart == $this->_startDate && $dateEnd == $this->_endDate) {
            return 'this_month_remainder';
      }      


      $dateStart = & new Date(Date_Calc::beginOfNextMonth());
      $dateEnd   = & new Date(Date_Calc::EndOfNextMonth());

      if($dateStart == $this->_startDate && $dateEnd == $this->_endDate) {
            return 'next_month';
      }      

      
      $dateStart = & new Date(Date_Calc::beginOfPrevMonth());
      $dateEnd   = & new Date(Date_Calc::beginOfMonth());
      $dateEnd->subtractSpan(new Date_Span("1, 0, 0, 0"));

      if($dateStart == $this->_startDate && $dateEnd == $this->_endDate) {
            return 'last_month';
      }      

      //special rule - 1995 - hidden year for finding all stats
      if(strlen($sd->year == 1995)) {
          return 'all_stats';
      }

      return 'specific';

   }

  

    
    function _roundDate($object)
    {
    
        $object->hour = 0;
        $object->minute = 0;
        $object->second = 0;    
    
    }

    function _fixDate($object)
    {
    
        $object->hour = 0;
        $object->minute = 0;
        $object->second = 0;    
 
        if(strlen($object->month) == 1) {
            $object->month = "0" . $object->month; 
        }
        if(strlen($object->day) == 1) {
            $object->day = "0" . $object->day; 
        }
    
    }


}

?>
