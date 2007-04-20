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

require_once MAX_PATH . '/lib/OA/Dal/Statistics.php';
require_once 'Date.php';

/**
 * A class for testing the non-DB specific OA_Dal_Statistics class.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Test_OA_Dal_Statistics extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Statistics()
    {
        $this->UnitTestCase();
    }

    /**
     * Test for the getPlacementOverviewTargetingStatistics() method.
     */
    function testGetPlacementOverviewTargetingStatistics()
    {

    }

    /**
     * Test for the getPlacementDailyTargetingStatistics() method.
     */
    function testGetPlacementDailyTargetingStatistics()
    {

    }

    /**
     * Test for the getAdTargetingStatistics() method.
     */
    function testGetAdTargetingStatistics()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;

        $oDal = new OA_Dal_Statistics();

        // Test 1: Test the method correctly identifies bad input
        $validAdId = 1;
        $oValidStartDate = new Date('2007-04-20 12:00:00');
        $oValidEndDate   = new Date('2007-04-20 12:59:59');
        $oInvalidEndDate = new Date('2007-04-20 12:59:58');

        $result = $oDal->getAdTargetingStatistics(null, $oValidStartDate, $oValidEndDate);
        $this->assertFalse($result);

        $result = $oDal->getAdTargetingStatistics($validAdId, null, $oValidEndDate);
        $this->assertFalse($result);

        $result = $oDal->getAdTargetingStatistics($validAdId, $oValidStartDate, null);
        $this->assertFalse($result);

        $result = $oDal->getAdTargetingStatistics($validAdId, $oValidStartDate, $oInvalidEndDate);
        $this->assertFalse($result);

    }

    /**
     * Test for the getZoneTargetingStatistics() method.
     */
    function testGetZoneTargetingStatistics()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;

        $oDal = new OA_Dal_Statistics();

        // Test 1: Test the method correctly identifies bad input
        $validZoneId = 1;
        $oValidStartDate = new Date('2007-04-20 12:00:00');
        $oValidEndDate   = new Date('2007-04-20 12:59:59');
        $oInvalidEndDate = new Date('2007-04-20 12:59:58');

        $result = $oDal->getZoneTargetingStatistics(null, $oValidStartDate, $oValidEndDate);
        $this->assertFalse($result);

        $result = $oDal->getZoneTargetingStatistics($validZoneId, null, $oValidEndDate);
        $this->assertFalse($result);

        $result = $oDal->getZoneTargetingStatistics($validZoneId, $oValidStartDate, null);
        $this->assertFalse($result);

        $result = $oDal->getZoneTargetingStatistics($validZoneId, $oValidStartDate, $oInvalidEndDate);
        $this->assertFalse($result);

    }

}

?>