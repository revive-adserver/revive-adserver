<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/DeliveryLimitation/Common.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A class that is used to store and manipulate individual dDelivery limitations
 * for ads, where the delivery limitation is of the Time:Day type.
 *
 * @package    OpenXMaintenance
 * @subpackage Priority
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Priority_DeliveryLimitation_Day extends OA_Maintenance_Priority_DeliveryLimitation_Common
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
     *                                       [comparison]        => =~
     *                                       [data]              => 1,7,18,23
     *                                       [executionorder]    => 1
     *                                   )
     * @return OA_Maintenance_Priority_DeliveryLimitation_Day
     */
    function OA_Maintenance_Priority_DeliveryLimitation_Day($aDeliveryLimitation)
    {
        parent::OA_Maintenance_Priority_DeliveryLimitation_Common($aDeliveryLimitation);
    }

    /**
     * A method to convert delivery limitations into negative form (i.e. when
     * NOT to deliver ad, as opposed to when to deliver).
     *
     * Time:Day delivery limitations can only be stored in terms of =~, or !~,
     * so conversion is only required if the comparison type stored is =~.
     *
     * @return mixed Void, or a PEAR::Error.
     */
    function calculateNonDeliveryDeliveryLimitation() {
        if ($this->comparison == '=~') {
            // Alternate the day values stored
            $fullWeek = range(0,6);
            foreach ($this->data as $val) {
                $key = array_search($val, $fullWeek);
                unset($fullWeek[$key]);
            }
            $this->data = $fullWeek;
            // Convert the comparison type
            $this->comparison = $this->_getNonDeliveryOperator($this->comparison);
        }
    }

    /**
     * A method to return the number of minutes each delivery limitation covers.
     *
     * @return mixed An integer, giving the number of minutes the limitation covers,
     *               or a PEAR::Error.
     */
    function minutesPerTimePeriod() {
        // Return the number of minutes in a week
        return 10080;
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
    function deliveryBlocked($oDate)
    {
        if (!is_a($oDate, 'Date')) {
            return MAX::raiseError(
                'Parameter passed to OA_Maintenance_Priority_DeliveryLimitation_Day is not a PEAR::Date object',
                MAX_ERROR_INVALIDARGS
            );
        }
        $val = (in_array($oDate->getDayOfWeek(), $this->data)) ? 1 : 0;
        switch($this->comparison)
        {
            case '=~':  return !$val;
            case '!~':  return $val;
        }
    }

}

?>
