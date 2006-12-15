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
$Id: Empty.php 5631 2006-10-09 18:21:43Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/max/Maintenance/Priority/DeliveryLimitation/Common.php';
require_once 'Date.php';

/**
 * A class that is used to store and manipulate individual delivery limitations
 * for ads, where the delivery limitation is NOT of the Time:Date, Time:Day or
 * Time:Hour type.
 *
 * @package    MaxMaintenance
 * @subpackage Priority
 * @author     Andrew Hill <andrew@m3.net>
 * @author     James Floyd <james@m3.net>
 */
class MAX_Maintenance_Priority_DeliveryLimitation_Empty extends MAX_Maintenance_Priority_DeliveryLimitation_Common
{

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
     * @return MAX_Maintenance_Priority_DeliveryLimitation_Empty
     */
    function MAX_Maintenance_Priority_DeliveryLimitation_Empty($aDeliveryLimitation)
    {
        parent::MAX_Maintenance_Priority_DeliveryLimitation_Common($aDeliveryLimitation);
    }

    /**
     * A method to convert delivery limitations into negative form (i.e. when
     * NOT to deliver ad, as opposed to when to deliver).
     *
     * @return mixed Void, or a PEAR::Error.
     */
    function calculateNonDeliveryDeliveryLimitation()
    {
        // Nothing to change in this class.
        return;
    }

    /**
     * A method to return the number of minutes each delivery limitation covers.
     *
     * @return mixed An integer, giving the number of minutes the limitation covers,
     *               or a PEAR::Error.
     */
    function minutesPerTimePeriod()
    {
        // It is not appropriate to talk about the number of minutes covered
        // by the ACLs represented by this class, so return zero
        return 0;
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
        if (!is_a($oDate, 'Date')) {
            return MAX::raiseError(
                'Parameter passed to MAX_Maintenance_Priority_DeliveryLimitation_Empty is not a PEAR::Date object',
                MAX_ERROR_INVALIDARGS
            );
        }
        // The delivery limitations represented by this class do not (ever) block
        // delivery, so return false
        return false;
    }

}

?>
