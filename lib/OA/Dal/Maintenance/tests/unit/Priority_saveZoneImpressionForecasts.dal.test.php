<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the saveZoneImpressionForecasts() method of the
 * non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Priority_saveZoneImpressionForecasts extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_saveZoneImpressionForecasts()
    {
        $this->UnitTestCase();
    }

    /**
     * The method to test the saveZoneImpressionForecasts() method.
     */
    function testSaveZoneImpressionForecasts()
    {
        $oDbh =& OA_DB::singleton();
        // Test data
        $aForecasts = array(
            1 => array(
                0 => array('forecast_impressions' => 100, 'interval_start' => '2005-05-20 00:00:00', 'interval_end' => '2005-05-20 00:59:59'),
                1 => array('forecast_impressions' => 200, 'interval_start' => '2005-05-20 01:00:00', 'interval_end' => '2005-05-20 01:59:59'),
                2 => array('forecast_impressions' => 300, 'interval_start' => '2005-05-20 02:00:00', 'interval_end' => '2005-05-20 02:59:59'),
            ),
            2 => array(
                0 => array('forecast_impressions' => 200, 'interval_start' => '2005-05-20 00:00:00', 'interval_end' => '2005-05-20 00:59:59'),
                1 => array('forecast_impressions' => 400, 'interval_start' => '2005-05-20 01:00:00', 'interval_end' => '2005-05-20 01:59:59'),
                2 => array('forecast_impressions' => 600, 'interval_start' => '2005-05-20 02:00:00', 'interval_end' => '2005-05-20 02:59:59'),
            )
        );

        // Run write method
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();
        $oMaxDalMaintenance->saveZoneImpressionForecasts($aForecasts);

        // Test keys
        $conf = $GLOBALS['_MAX']['CONF'];
        $query = 'SELECT * from ' . $oDbh->quoteIdentifier($conf['table']['prefix'] . 'data_summary_zone_impression_history',true);
        $rc = $oDbh->query($query);
        $aRows = $rc->fetchAll();
        $this->assertTrue(isset($aRows[0]['data_summary_zone_impression_history_id']));
        $this->assertTrue(isset($aRows[0]['operation_interval']));
        $this->assertTrue(isset($aRows[0]['operation_interval_id']));
        $this->assertTrue(isset($aRows[0]['interval_start']));
        $this->assertTrue(isset($aRows[0]['interval_end']));
        $this->assertTrue(isset($aRows[0]['zone_id']));
        $this->assertTrue(isset($aRows[0]['forecast_impressions']));

        // Test forecast values written
        foreach($aRows as $key => $aValues) {
            $this->assertTrue($aValues['forecast_impressions'] > 0);
            $this->assertTrue(!(empty($aValues['interval_start'])));
            $this->assertTrue(!(empty($aValues['interval_end'])));
            // Bit funny way to test value, done so I can test in loop
            $this->assertEqual($aValues['forecast_impressions'], (($aValues['operation_interval_id'] + 1) * ($aValues['zone_id'] * 100)));
        }
        DataGenerator::cleanUp(array('data_summary_zone_impression_history'));
    }

}

?>