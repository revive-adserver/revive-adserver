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
$Id: DaySpan.sdh.test.php 5637 2006-10-09 19:38:18Z scott@m3.net $
*/

require_once MAX_PATH . '/lib/max/DaySpan.php';
require_once 'Date.php';

class DaySpanTest extends UnitTestCase
{
    function testSetSpanDays()
    {
        $date1 = new Date('1987-04-12 15:10:11');
        $date2 = new Date('2004-10-12 23:59:59');
        
        $oDaySpan = new DaySpan();
        $oDaySpan->setSpanDays($date1, $date2);

        $this->assertEqual($oDaySpan->getStartDate(), $date1);
        $this->assertEqual($oDaySpan->getEndDate(), $date2);
    }
    
    // TODO:  Test other presets
    function testSpanToday()
    {
        $today = new Date();
        $oDaySpan = new DaySpan('today');
        $this->assertEqual($oDaySpan->getStartDate(), $today);
        $this->assertEqual($oDaySpan->getEndDate(), $today);
    }
    function testSetStartDateEndDate()
    {
        $date1 = new Date('1994-12-31 00:00:00');
        $date2 = new Date('1999-12-31 00:00:00');
        
        $oDaySpan = new DaySpan();
        $oDaySpan->setSpanDays($date1,$date2);
        $this->assertEqual($oDaySpan->getStartDate(), $date1);
        $this->assertEqual($oDaySpan->getEndDate(), $date2);
        
        // Dates should work backward as well
        $oDaySpan->setSpanDays($date2,$date1);
        $this->assertEqual($oDaySpan->getStartDate(), $date2);
        $this->assertEqual($oDaySpan->getEndDate(), $date1);
    }
    function testGetDateString()
    {
        $date1 = new Date('1994-12-31 12:34:56');
        $date2 = new Date('1999-01-31 12:43:32');
        
        $oDaySpan = new DaySpan();
        $oDaySpan->setSpanDays($date1,$date2);
        $this->assertEqual($oDaySpan->getStartDateString('%Y-%m-%d'), '1994-12-31');
        $this->assertEqual($oDaySpan->getEndDateString('%Y-%m-%d'),'1999-01-31');
    }
    function testGetDaysInSpan()
    {
        $date1 = new Date('1999-12-31 12:34:56');
        $date2 = new Date('2000-01-01 12:43:32');
        
        $oDaySpan = new DaySpan();
        $oDaySpan->setSpanDays($date1,$date2);
        $this->assertEqual($oDaySpan->getDaysInSpan(), 1);
        $oDaySpan->setSpanDays($date2,$date1);
        $this->assertEqual($oDaySpan->getDaysInSpan(), -1);
    }
    function testGetDayOfWeekCount()
    {
        $date1 = new Date('2006-09-26');
        $date2 = new Date('2006-10-03');
        $aResults = array(1,1,2,1,1,1,1);
        $oDaySpan = new DaySpan();
        $oDaySpan->setSpanDays($date1,$date2);
        $this->assertEqual($oDaySpan->getDayOfWeekCount(), $aResults);
        $date1 = new Date('2006-09-26');
        $date2 = new Date('2006-09-26');
        $aResults = array(0,0,1,0,0,0,0);
        $oDaySpan->setSpanDays($date1,$date2);
        $this->assertEqual($oDaySpan->getDayOfWeekCount(), $aResults);
    }
    function testGetDayArray()
    {
        $date1 = new Date('2006-09-26');
        $date2 = new Date('2006-10-03');
        $aResults = array('2006-09-26','2006-09-27','2006-09-28','2006-09-29','2006-09-30','2006-10-01','2006-10-02','2006-10-03');
        $oDaySpan = new DaySpan();
        $oDaySpan->setSpanDays($date1,$date2);
        $this->assertEqual($oDaySpan->getDayArray(), $aResults);
        $date1 = new Date('2006-09-26');
        $date2 = new Date('2006-09-26');
        $aResults = array('2006-09-26');
        $oDaySpan->setSpanDays($date1,$date2);
        $this->assertEqual($oDaySpan->getDayArray(), $aResults);
    }
    function testGetIntersection()
    {
        // Test one span outside second span
        $date1 = new Date('2006-09-26');
        $date2 = new Date('2006-10-03');
        $oDaySpan1 = new DaySpan();
        $oDaySpan1->setSpanDays($date1,$date2);
        $date3 = new Date('2006-09-25');
        $date4 = new Date('2006-10-04');
        $oDaySpan2 = new DaySpan();
        $oDaySpan2->setSpanDays($date3,$date4);
        $this->assertEqual($oDaySpan1->getIntersection($oDaySpan2), $oDaySpan1);
        // Test one span inside second span
        $date3 = new Date('2006-09-27');
        $date4 = new Date('2006-10-02');
        $oDaySpan2 = new DaySpan();
        $oDaySpan2->setSpanDays($date3,$date4);
        $this->assertEqual($oDaySpan1->getIntersection($oDaySpan2), $oDaySpan2);
        // Test one span overlapping second span
        $date3 = new Date('2006-09-25');
        $date4 = new Date('2006-10-02');
        $oDaySpan2 = new DaySpan();
        $oDaySpan2->setSpanDays($date3,$date4);
        $oDaySpan = new DaySpan();
        $oDaySpan->setSpanDays($date1,$date4);
        $this->assertEqual($oDaySpan1->getIntersection($oDaySpan2), $oDaySpan);
        // Test one span overlapping second span (other way)
        $date3 = new Date('2006-09-27');
        $date4 = new Date('2006-10-04');
        $oDaySpan2 = new DaySpan();
        $oDaySpan2->setSpanDays($date3,$date4);
        $oDaySpan = new DaySpan();
        $oDaySpan->setSpanDays($date3,$date2);
        $this->assertEqual($oDaySpan1->getIntersection($oDaySpan2), $oDaySpan);
        // Test one span not overlapping second span
        $date3 = new Date('2006-10-04');
        $date4 = new Date('2006-10-06');
        $oDaySpan2 = new DaySpan();
        $oDaySpan2->setSpanDays($date3,$date4);
        $this->assertEqual($oDaySpan1->getIntersection($oDaySpan2), false);
    }
}

?>
