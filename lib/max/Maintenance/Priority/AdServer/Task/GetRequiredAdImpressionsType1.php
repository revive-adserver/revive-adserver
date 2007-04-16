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

require_once MAX_PATH . '/lib/max/Maintenance/Priority/AdServer/Task/GetRequiredAdImpressions.php';

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once 'Date.php';

/**
 * A class used to calculate the number of required advertisements in the next
 * operation interval for each ad, such that the ad will meet its delivery
 * requirements.
 *
 * This class is for advertisements in campaigns with Inventory Requirements and
 * a Campaign Expiration Date. The required impressions are calculated using the
 * following algorithm:
 *
 * - If the advertisement is in a campaign that has Click and/or Connection/Conversion
 *   Inventory Requirements, then calculate the campaign's Click Through Ratio and/or
 *   Connection/Conversion Ratio as required, and convert the campaign's remaining
 *   Click and/or Connection/Conversion Inventory Requirements into an equivalent
 *   Impression Inventory Requirement.
 * - Using the smallest of the real or calculated Impression Inventory Requirement values,
 *   distribute the required impressions between the campaign's advertisements, on the
 *   basis of the campaign's advertisement's weights.
 * - For each advertisement, divide the number of impressions allocated equally between
 *   the available operation intervals remaining in the day(s) before the end of the
 *   campaign. Do not include any operation intervals where the advertisement has been
 *   blocked from delivering (ie. a Day, Time, or Date Delivery Limitation exists). The
 *   number of impressions for each remaining operation interval will be the number of
 *   impressions required for the next operation interval, unless the advertisement is
 *   blocked from delivering in the next operation interval, in which case the required
 *   impressions for the next operation interval will be zero.
 *
 * @package    MaxMaintenance
 * @subpackage Priority
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Demian Turner <demian@m3.net>
 * @author     James Floyd <james@m3.net>
 */
class GetRequiredAdImpressionsType1 extends MAX_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressions
{

    /**
     * A variable for storing a local instance of the
     * Openads_Table_Priority class.
     *
     * @var Openads_Table_Priority
     */
    var $oTable;

    /**
     * For storing weekly zone impression forecasts, if zone patterning
     * is used, to save on database queries.
     *
     * @var array
     */
    var $aZoneForecasts;

    /**
     * The class constructor method.
     *
     * @return GetRequiredAdImpressionsType1
     */
    function GetRequiredAdImpressionsType1()
    {
        parent::MAX_Maintenance_Priority_Common_Task_GetRequiredAdImpressions();
    }

    /**
     * A method that uses the getAllPlacements() method to obtain all placements
     * that meet the requirements of this class. That is:
     *
     * - The placement has an expiration date (that is not already passed); and
     * - As a result of the above, the placement must have an activation date that has
     *   passed, or has the default fake activation date; and
     * - The placement is active, and has a priority of at least 1; and
     * - The placement has inventory requirements for the duration of its activation.
     *
     * @access private
     * @return array An array of {@link MAX_Entity_Placement} objects.
     */
    function _getValidPlacements()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        // Get current date
        $oDate = $this->_getDate();
        $dateYMD = $oDate->format('%Y-%m-%d');
        $table = $conf['table']['prefix'] . $conf['table']['campaigns'];
        $aWheres = array(
            array("($table.activate " . OA_Dal::equalNoDateString() . " OR $table.activate <= '$dateYMD')", 'AND'),
            array("$table.expire >= '$dateYMD'", 'AND'),
            array("$table.priority >= 1", 'AND'),
            array("$table.active = 't'", 'AND'),
            array("($table.views > 0 OR $table.clicks > 0 OR $table.conversions > 0)", 'AND')
        );
        return $this->_getAllPlacements(array(), $aWheres);
    }

    /**
     * Method to estimate the impressions required to fulfill a given
     * placement lifetime impression, click, or conversion requirement. If
     * more than one requirement exists the smallest calculated impression
     * requirement will be returned.
     *
     * The $oPlacement parameter is passed by reference and will have
     * the calculated impression requirement added to it in the position
     * $oPlacement->requiredImpressions
     *
     * @param MAX_Entity_Placement $oPlacement
     */
    function getPlacementImpressionInventoryRequirement(&$oPlacement)
    {
        parent::getPlacementImpressionInventoryRequirement($oPlacement, 'total');
    }

}

?>
