<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
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
 */
class OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime extends OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressions
{

    /**
     * The class constructor method.
     *
     * @return OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime
     */
    function __construct()
    {
        parent::__construct();
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
        $oDate = new Date($this->_getDate());
        $oDate->toUTC();
        $dateYMD = $oDate->getDate(DATE_FORMAT_ISO);
        $oDbh = $this->oDal->_getDbConnection();
        $table = $oDbh->quoteIdentifier($conf['table']['prefix'] . $conf['table']['campaigns'],true);

        $aWheres = array(
            array("$table.priority >= 1", 'AND'),
            array("$table.status = ".OA_ENTITY_STATUS_RUNNING, 'AND'),
            array("$table.expire_time >= '$dateYMD'", 'AND'),
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
    function getCampaignImpressionInventoryRequirement($oCampaign, $type = 'total', $ignorePast = false)
    {
        parent::getCampaignImpressionInventoryRequirement($oCampaign, 'total');
    }

}

?>
