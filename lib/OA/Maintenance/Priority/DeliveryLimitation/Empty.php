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

/**
 * A class that is used to store and manipulate individual delivery limitations
 * for ads, where the delivery limitation is NOT of the Time:Date, Time:Day or
 * Time:Hour type.
 *
 * @package    OpenXMaintenance
 * @subpackage Priority
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Priority_DeliveryLimitation_Empty
{

    /**
     * Logical operator: and, or
     * @var string
     */
    var $logical;

    /**
     * Delivery limitation type
     * @var string
     */
    var $type;

    /**
     * Delivery limitation comparison: ==, !=, >=, <=, >, <
     * @var string
     */
    var $comparison;

    /**
     * Delivery limitation data
     * @var string
     */
    var $data;

    /**
     * Order delivery limitation should be executed in: 0-n
     * @var integer
     */
    var $executionOrder;

    /**
     * Constructor method.
     *
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
     * @return OA_Maintenance_Priority_DeliveryLimitation_Empty
     */
    function __construct($aDeliveryLimitation)
    {
        // Store the logical, type, comparison, data and execution order
        // items of the delivery limitation
        $this->logical        = $aDeliveryLimitation['logical'];
        $this->type           = $aDeliveryLimitation['type'];
        $this->comparison     = $aDeliveryLimitation['comparison'];
        $this->data           = $aDeliveryLimitation['data'];
        $this->executionOrder = $aDeliveryLimitation['executionorder'];
    }

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
    function deliveryBlocked($oDate) {
        // The delivery limitations represented by this class do not (ever) block
        // delivery, so return false
        return false;
    }
}

?>