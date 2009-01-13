<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                            |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/GetRequiredAdImpressions.php';
require_once MAX_PATH . '/lib/OA/Dll.php';

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
 * @package    OpenXMaintenance
 * @subpackage Priority
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime extends OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressions
{

    /**
     * The class constructor method.
     *
     * @return OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime
     */
    function OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime()
    {
        parent::OA_Maintenance_Priority_Common_Task_GetRequiredAdImpressions();
        $this->type = 'campaign lifetime target(s) and end date are set';
    }

    /**
     * A method that uses the getAllCampaigns() method to obtain all campaigns
     * that meet the requirements of this class. That is:
     *
     * - The campaign has an expiration date (that is not already passed); and
     * - As a result of the above, the campaign must have an activation date that has
     *   passed, or has the default fake activation date; and
     * - The campaign is active, and has a priority of at least 1; and
     * - The campaign has inventory requirements for the duration of its activation.
     *
     * @access private
     * @return array An array of {@link OX_Maintenance_Priority_Campaign} objects.
     */
    function _getValidCampaigns()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        // Get current date
        $oDate = $this->_getDate();
        $dateYMD = $oDate->format('%Y-%m-%d');
        $oDbh = OA_DB::singleton();
        $table = $oDbh->quoteIdentifier($conf['table']['prefix'] . $conf['table']['campaigns'],true);

        $aWheres = array(
            array("($table.activate " . OA_Dal::equalNoDateString() . " OR $table.activate <= '$dateYMD')", 'AND'),
            array("$table.expire >= '$dateYMD'", 'AND'),
            array("$table.priority >= 1", 'AND'),
            array("$table.status = ".OA_ENTITY_STATUS_RUNNING, 'AND'),
            array("($table.views > 0 OR $table.clicks > 0 OR $table.conversions > 0)", 'AND')
        );
        return $this->_getAllCampaigns($aWheres);
    }

    /**
     * Method to estimate the impressions required to fulfill a given
     * campaign lifetime impression, click, or conversion requirement. If
     * more than one requirement exists the smallest calculated impression
     * requirement will be returned.
     *
     * The $oCampaign parameter is passed by reference and will have
     * the calculated impression requirement added to it in the position
     * $oCampaign->requiredImpressions
     *
     * @param OX_Maintenance_Priority_Campaign $oCampaign
     */
    function getCampaignImpressionInventoryRequirement(&$oCampaign)
    {
        parent::getCampaignImpressionInventoryRequirement($oCampaign, 'total');
    }

}

?>
