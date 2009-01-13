<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
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

require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * An abstract class that defines the interface and some common methods for the
 * classes that store and manipulate individual delivery limitations for ads,
 * with the goal of determining when (if at all) the deliver limitation "blocks"
 * (as opposed to "filters") deliver of an advertisement.
 *
 * @abstract
 * @package    OpenXMaintenance
 * @subpackage Priority
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Priority_DeliveryLimitation_Common
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
     * @var array
     */
    var $data = array();

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
     * @return OA_Maintenance_Priority_DeliveryLimitation_Common
     */
    function OA_Maintenance_Priority_DeliveryLimitation_Common($aDeliveryLimitation)
    {
        // Store the logical, type, comparison, data and execution order
        // items of the delivery limitation
        $this->logical        = $aDeliveryLimitation['logical'];
        $this->type           = $aDeliveryLimitation['type'];
        $this->comparison     = $aDeliveryLimitation['comparison'];
        $this->data           = explode(',',$aDeliveryLimitation['data']);
        $this->executionOrder = $aDeliveryLimitation['executionorder'];
        // Manipulate all delivery limitations to be expressed in terms of when
        // NOT to deliver the ad, as opposed to when to deliver
        $this->calculateNonDeliveryDeliveryLimitation();
    }

    /**
     * A method to convert delivery limitations into negative form (i.e. when
     * NOT to deliver ad, as opposed to when to deliver).
     *
     * @abstract
     * @return mixed Void, or a PEAR::Error.
     */
    function calculateNonDeliveryDeliveryLimitation() {
        return MAX::raiseError(
            'OA_Maintenance_Priority_DeliveryLimitation::calculateNonDeliveryDeliveryLimitation() is abstract!',
            MAX_ERROR_NOMETHOD
        );
    }

    /**
     * A method to return the number of minutes each delivery limitation covers.
     *
     * @abstract
     * @return mixed An integer, giving the number of minutes the limitation covers,
     *               or a PEAR::Error.
     */
    function minutesPerTimePeriod()
    {
        return MAX::raiseError(
            'OA_Maintenance_Priority_DeliveryLimitation::minutesPerTimePeriod() is abstract!',
            MAX_ERROR_NOMETHOD
        );
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
        return MAX::raiseError(
            'OA_Maintenance_Priority_DeliveryLimitation::deliveryBlocked() is abstract!',
            MAX_ERROR_NOMETHOD
        );
    }

    /**
     * A private method to return the appropriate operator to use when
     * evaulating delivery limitations in terms of when NOT to deliver as
     * opposed to when to deliver.
     *
     * For example, the delivery condition to deliver on a specific date
     * would be "Time:Date == 20050403". The same condition in terms of when
     * not to deliver will be "Time:Date != 20050403"; that is, the operator
     * changes from "==" to "!=".
     *
     * @access private
     * @param string $operator Operator, one of: ==, !=, >, >=, <, <=
     * @return mixed The appropriate (changed) delivery operator, or a
     *               PEAR::error object
     */
    function _getNonDeliveryOperator($operator)
    {
        if ($operator == '!=') {
            return '==';
        } elseif ($operator == '==') {
            return '!=';
        } elseif ($operator == '!~') {
            return '=~';
        } elseif ($operator == '=~') {
            return '!~';
        } elseif ($operator == '>') {
            return '<=';
        } elseif ($operator == '>=') {
            return '<';
        } elseif ($operator == '<') {
            return '>=';
        } elseif ($operator == '<=') {
            return '>';
        }
        return MAX::raiseError(
            'Illegal operator passed to ' . __CLASS__ . '::' . __FUNCTION__ ,
            MAX_ERROR_INVALIDARGS
        );
    }

}

?>
