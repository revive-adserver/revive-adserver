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
 * This class is for advertisements in campaigns with a Manual Daily Limit.
 * The required impressions are calculated using the following algorithm:
 *
 * - If the advertisement is in a campaign that has Manual Daily Click and/or Manual Daily
 *   Connection/Conversion Limit, then calculate the campaign's Click Through Ratio and/or
 *   Connection/Conversion Ratio as required, and convert the campaign's remaining
 *   Manual Daily Click and/or Connection/Conversion Limits into an equivalent Manual
 *   Daily Impression Inventory Limit.
 * - Using the smallest of the real or calculated Manual Daily Impression Limit values,
 *   distribute the required impressions between the campaign's advertisements, on the
 *   basis of the campaign's advertisement's weights.
 * - For each advertisement, divide the number of impressions allocated equally between
 *   the available operation intervals remaining in the day. Do not include any operation
 *   intervals where the advertisement has been blocked from delivering (ie. a Day, Time,
 *   or Date Delivery Limitation exists). The number of impressions for each remaining
 *   operation interval will be the number of impressions required for the next operation
 *   interval, unless the advertisement is blocked from delivering in the next operation
 *   interval, in which case the required impressions for the next operation interval will
 *   be zero.
 *
 * @package    OpenXMaintenance
 * @subpackage Priority
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsDaily extends OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressions
{

    /**
     * The class constructor method.
     *
     * @return OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsDaily
     */
    function OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsDaily()
    {
        parent::OA_Maintenance_Priority_Common_Task_GetRequiredAdImpressions();
        $this->type = 'a daily target is set';
    }

    /**
     * A method that uses the getAllCampaigns() method to obtain all campaigns
     * that meet the requirements of this class. That is:
     *
     * - The campaign is active, and has a priority of at least 1; and
     * - The campaign has daily inventory requirements.
     *
     * @access private
     * @return array An array of {@link OX_Maintenance_Priority_Campaign} objects.
     */
    function _getValidCampaigns()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = OA_DB::singleton();
        $table = $oDbh->quoteIdentifier($conf['table']['prefix'] . $conf['table']['campaigns'],true);
        $aWheres = array(
            array("$table.priority >= 1", 'AND'),
            array("$table.status = ".OA_ENTITY_STATUS_RUNNING, 'AND'),
            array("($table.target_impression > 0 OR $table.target_click > 0 OR $table.target_conversion > 0)", 'AND'),
            array("($table.expire_time IS NULL OR ($table.views = -1 AND $table.clicks = -1 AND $table.conversions = -1))", 'AND'),
        );
        return $this->_getAllCampaigns($aWheres);
    }

    /**
     * Method to estimate the impressions required to fulfill a given
     * campaign daily impression, click, or conversion requirement. If more
     * than one requirement exists the smallest calculated impression
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
        parent::getCampaignImpressionInventoryRequirement($oCampaign, 'daily');
    }

}

?>
