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

/**
 * Class used to forecast data. The algorithm is as simple as possible. Just take the mean of the data
 * and multiply by number of intervals.
 *
 * @package    MaxForecast
 * @author     Radek Maciaszek <radek@m3.net>
 */
class MAX_Forecast_Algorithm_Simple
{

    /**
     * Sum data
     *
     * @param array $data  History data
     * @return int  Summed data values
     */
    function sum($data)
    {
        $sum = 0;
        foreach ($data as $num) {
            $sum += $num;
        }
        return (float) $sum;
    }

    /**
     * Forecast data as integer value. Sum of the forecast data
     *
     * @param array $data       History data. Plain array of history data
     * @param int   $intervals  Number of intervals to forecast
     * @return int  Forecasted value
     */
    function forecast($data, $intervals)
    {
        $mean = 0;
        if(!empty($data)) {
            $mean = $this->sum($data) / count($data);
        }
        $forecast = $mean * $intervals;

        return (int) $forecast;
    }

    /**
     * Forecast data separately for every interval.
     *
     * @param array $data       History data. Plain array of history data
     * @param int   $intervals  Number of intervals to forecast
     * @return array  Forecasted values for every interval
     */
    function forecastAsArray($data, $intervals)
    {
        $mean = 0;
        if(!empty($data)) {
            $mean = $this->sum($data) / count($data);
        }
        $forecast = array();
        for ($i = 0; $i < $intervals; $i++) {
            $forecast[] = (int) $mean;
        }
        return $forecast;
    }

}

?>
