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

/**
 * A class for creating {@link OA_Maintenance_Priority_DeliveryLimitation_Common}
 * subclass objects, depending on the delivery limitation passed in.
 *
 * @static
 * @package    OpenXMaintenance
 * @subpackage Priority
 */
class OA_Maintenance_Priority_DeliveryLimitation_Factory
{
    static $aPlugins;

    /**
     * A factory method to return the appropriate
     * OA_Maintenance_Priority_DeliveryLimitation_Common
     * subclass object (one of OA_Maintenance_Priority_DeliveryLimitation_Date,
     * OA_Maintenance_Priority_DeliveryLimitation_Day,
     * OA_Maintenance_Priority_DeliveryLimitation_Empty or
     * OA_Maintenance_Priority_DeliveryLimitation_Hour), depending on the data
     * provided.
     *
     * @static
     * @param array $aDeliveryLimitation An array containing the details of a delivery limitation
     *                                   associated with an ad. For example:
     *                                   array(
     *                                       [ad_id]             => 1
     *                                       [logical]           => and
     *                                       [type]              => Time:Hour
     *                                       [comparison]        => ==
     *                                       [data]              => 1,7,18,23
     *                                       [executionorder]    => 1
     *                                   )
     * @return object OA_Maintenance_Priority_DeliveryLimitation_Common
     */
    function &factory($aDeliveryLimitation)
    {
        // Load plugins if not already in cache
        if (!isset(self::$aPlugins)) {
            self::$aPlugins = OX_Component::getComponents('deliveryLimitations', null, false);
        }

        // Return instance of the MPE DL class
        if (isset(self::$aPlugins[$aDeliveryLimitation['type']])) {
            return self::$aPlugins[$aDeliveryLimitation['type']]->getMpeClassInstance($aDeliveryLimitation);
        }

        // Unknown plugin? Return the empty MPE DL class
        return new OA_Maintenance_Priority_DeliveryLimitation_Empty($aDeliveryLimitation);
    }

}

?>