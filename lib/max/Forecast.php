<?php
/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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
 * Class used to forecast history data using one of
 * the implemented forecast algorithms
 *
 * @package    Max
 * @author     Radek Maciaszek <radek@m3.net>
 */
class MAX_Forecast
{
    var $_oAlgorithm;
    var $_historyData;

    /**
     * Set hisotory data
     *
     * @param array $data  History data
     */
    function setHistoryData($historyData)
    {
        $this->_historyData = $historyData;
    }

    /**
     * Factory algorithm and set as a private variable
     *
     * @param string $algorithmName  Algorithm name
     */
    function setAlgorithm($algorithmName)
    {
        $this->_oAlgorithm = $this->factoryAlgorithm($algorithmName);
    }

    /**
     * Forecast history data using forecasting algorithm
     *
     * @param int $intervals     Amount of intervals to forecast
     * @return int  Sum of forecasted for every interval values
     */
    function forecast($intervals)
    {
        if(!is_object($this->_oAlgorithm)) {
            return false;
        }
        return $this->_oAlgorithm->forecast($this->_historyData, $intervals);
    }

    /**
     * Forecast history data using forecasting algorithm
     *
     * @param int $intervals  Amount of intervals
     * @return array  Array of forecasted values - one entry for every interval
     */
    function forecastAsArray($intervals)
    {
        if(!is_object($this->_oAlgorithm)) {
            return false;
        }
        return $this->_oAlgorithm->forecastAsArray($this->_historyData, $intervals);
    }
}

?>