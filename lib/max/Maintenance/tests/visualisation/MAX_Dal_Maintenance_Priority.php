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
$Id: MAX_Dal_Maintenance_Priority.php 5631 2006-10-09 18:21:43Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/max/Dal/Maintenance/Priority.php';

/**
 * An extended version of the MAX_Dal_Maintenance_Priority class with a modified
 * saveZoneImpressionForecasts() method, so that the results of zone
 * forecasts can be inspected without accessing the database.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Dal_Maintenance_TestOfForecastZoneImpressions extends MAX_Dal_Maintenance_Priority
{

    function MAX_Dal_Maintenance_TestOfForecastZoneImpressions()
    {
        parent::MAX_Dal_Maintenance_Priority();
    }

    /**
     * The overloaded saveZoneImpressionForecasts() method.
     */
    function saveZoneImpressionForecasts($aForecasts)
    {
        // Store the data so that it can be accessed once the forecast is complete
        $GLOBALS['_MAX']['TEST']['previousForecastResult'] = $GLOBALS['_MAX']['TEST']['forecastResult'];
        $GLOBALS['_MAX']['TEST']['forecastResult'] = $aForecasts;
        // Update the database, instead of inserting, as existing data already
        // exists
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        foreach ($aForecasts as $zoneId => $aOperationIntervals) {
            foreach ($aOperationIntervals as $id => $aValues) {
                $query = "
                    UPDATE
                        {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
                    SET
                        forecast_impressions = {$aValues['forecast_impressions']}
                    WHERE
                        zone_id = $zoneId
                        AND operation_interval = " . MAX_OperationInterval::getOperationInterval() . "
                        AND operation_interval_id = $id
                        AND interval_start = '" . $aValues['interval_start'] . "'
                        AND interval_end = '" . $aValues['interval_end'] . "'";
                $res = $dbh->query($query);
            }
        }
    }


}

?>
