<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
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
 * A file that contains a number of entity classes used in the Maintenance Priority
 * process: Advert, Placement and Zone.
 */

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * An entity class used to represent zones.
 *
 * @package    MaxMaintenance
 * @subpackage Priority
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Demain Turner <demian@m3.net>
 * @author     James Floyd <james@m3.net>
 */
class Zone
{

    var $id;
    var $availableImpressions = 0;
    var $averageImpressions   = 0;
    var $aAdverts             = array();
    var $aOperationIntId      = array();
    var $pastActualImpressions;

    /**
     * The constructor method.
     *
     * @param array $aZone associative array of values to be assigned to
     *              object, array keys reflect database field names
     */
    function Zone($aZone = array())
    {
        $this->id = (int)$aZone['zoneid'];
    }

    /**
     * A method to add Advert objects to the Zone.
     *
     * @param Advert $oAdvert The Advert object to add.
     * @return void
     */
    function addAdvert($oAdvert)
    {
        $this->aAdverts[$oAdvert->id] = $oAdvert;
    }

    /**
     * Method to set the average impressions for a given
     * operation interval ID
     *
     * @param integer $intervalId
     * @param integer $impressions
     * @return void
     */
    function setIntervalIdImpressionAverage($intervalId, $impressions = 0)
    {
        if (isset($intervalId)) {
            $this->aOperationIntId[$intervalId]['averageImpressions'] = $impressions;
        }
    }

    /**
     * Method to set the forecast impressions for a given
     * operation interval ID
     *
     * @param integer $intervalId
     * @param integer $impressions
     * @return void
     */
    function setIntervalIdImpressionForecast($intervalId, $impressions = 0)
    {
        if (isset($intervalId)) {
            $this->aOperationIntId[$intervalId]['forecastImpressions'] = $impressions;
        }
    }

    /**
     * Method to set the actual impressions value for a given
     * operation interval ID
     *
     * @param integer $intervalId
     * @param integer $impressions
     * @return void
     */
    function setIntervalIdImpressionActual($intervalId, $impressions = 0)
    {
        if (isset($intervalId)) {
            $this->aOperationIntId[$intervalId]['actualImpressions'] = $impressions;
        }
    }

}

?>
