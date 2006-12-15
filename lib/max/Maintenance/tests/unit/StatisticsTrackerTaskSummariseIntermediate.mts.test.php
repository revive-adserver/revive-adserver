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
$Id: StatisticsTrackerTaskSummariseIntermediate.mts.test.php 4388 2006-03-09 13:31:34Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/max/Maintenance/Statistics/Tracker/Task/SummariseIntermediate.php';

/**
 * A class for testing the MAX_Maintenance_Statistics_Tracker_Task_SummariseIntermediate class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Maintenance_TestOfMAX_Maintenance_Statistics_Tracker_Task_SummariseIntermediate extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMAX_Maintenance_Statistics_Tracker_Task_SummariseIntermediate()
    {
        $this->UnitTestCase();
    }

    /**
     * Test the creation of the class.
     */
    function testCreate()
    {
        $oSummariseIntermediate = new MAX_Maintenance_Statistics_Tracker_Task_SummariseIntermediate();
        $this->assertTrue(is_a($oSummariseIntermediate, 'MAX_Maintenance_Statistics_Tracker_Task_SummariseIntermediate'));
    }

}

?>
