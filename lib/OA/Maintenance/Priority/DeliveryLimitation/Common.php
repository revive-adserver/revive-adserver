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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/DeliveryLimitation/Empty.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A class that defines the interface and some common methods for the
 * classes that store and manipulate individual delivery limitations for ads,
 * with the goal of determining when (if at all) the deliver limitation "blocks"
 * (as opposed to "filters") deliver of an advertisement.
 *
 * @abstract
 * @package    OpenXMaintenance
 * @subpackage Priority
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Priority_DeliveryLimitation_Common extends OA_Maintenance_Priority_DeliveryLimitation_Empty
{
    /**
     * A method to determine if the delivery limitation stored will prevent an
     * ad from delivering or not, given a time/date.
     *
     * @abstract
     * @param object $oDate PEAR:Date, represeting the time/date to test if the ACL would
     *                      block delivery at that point in time.
     * @return mixed A boolean (true if the ad is BLOCKED (i.e. will NOT deliver), false
     *               if the ad is NOT BLOCKED (i.e. WILL deliver), or a PEAR::Error.
     */
    function deliveryBlocked($oDate)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if (!is_a($oDate, 'Date')) {
            return MAX::raiseError(
                'Parameter passed to OA_Maintenance_Priority_DeliveryLimitation_Common is not a PEAR::Date object',
                MAX_ERROR_INVALIDARGS
            );
        }

        $aParts = OX_Component::parseComponentIdentifier($this->type);
        if (!empty($aParts) && count($aParts) == 3) {
            $fileName = MAX_PATH.$aConf['pluginPaths']['plugins'].join('/', $aParts).'.delivery.php';
            $funcName = "MAX_check{$aParts[1]}_{$aParts[2]}";
            $callable = function_exists($funcName);

            if (!$callable && file_exists($fileName)) {
                require_once $fileName;
                $callable = true;
            }

            $aParams = array(
                'timestamp' => $oDate->getDate(DATE_FORMAT_UNIXTIME)
            );

            if ($callable) {
                // Return non-delivery
                return !$funcName($this->data, $this->comparison, $aParams);
            }
        }

        return MAX::raiseError(
            'Limitation parameter passed to OA_Maintenance_Priority_DeliveryLimitation_Common is not correct',
            MAX_ERROR_INVALIDARGS
        );
    }

}

?>