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

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * An extended version of the OA_Dal_Maintenance_Priority class with a modified
 * saveZoneImpressionForecasts() method, so that the results of zone
 * forecasts can be inspected without accessing the database.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Dal_Maintenance_Test_ForecastZoneImpressions extends OA_Dal_Maintenance_Priority
{

    function OA_Dal_Maintenance_Test_ForecastZoneImpressions()
    {
        parent::OA_Dal_Maintenance_Priority();
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
        $oDbh =& OA_DB::singleton();
        $table = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['data_summary_zone_impression_history'],true);
        foreach ($aForecasts as $zoneId => $aOperationIntervals) {
            foreach ($aOperationIntervals as $id => $aValues) {
                $query = "
                    UPDATE
                        {$table}
                    SET
                        forecast_impressions = {$aValues['forecast_impressions']}
                    WHERE
                        zone_id = $zoneId
                        AND operation_interval = " . OX_OperationInterval::getOperationInterval() . "
                        AND operation_interval_id = $id
                        AND interval_start = '" . $aValues['interval_start'] . "'
                        AND interval_end = '" . $aValues['interval_end'] . "'";
                $rows = $oDbh->exec($query);
            }
        }
    }


}

?>
