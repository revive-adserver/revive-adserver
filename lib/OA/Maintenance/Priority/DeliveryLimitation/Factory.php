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

/**
 * A class for creating {@link OA_Maintenance_Priority_DeliveryLimitation_Common}
 * subclass objects, depending on the delivery limitation passed in.
 *
 * @static
 * @package    OpenXMaintenance
 * @subpackage Priority
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Priority_DeliveryLimitation_Factory
{

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
        // Define an array naming the 3 date/time delivery limitations associated
        // with the OA_Maintenance_Priority_DeliveryLimitation_Date,
        // OA_Maintenance_Priority_DeliveryLimitation_Day
        // and OA_Maintenance_Priority_DeliveryLimitation_Hour classes
        $dateTimeClasses = array(
            'time:date',
            'time:day',
            'time:hour'
        );
        // If the delivery limitations properties passed in have a type that matches
        // one of the date/time delivery limitations, set the $class variable so that
        // the appropriate class can be instantiated, otherwise, set $class so that
        // the OA_Maintenance_Priority_DeliveryLimitation_Empty class can be
        // instantiated
        if (in_array(strtolower($aDeliveryLimitation['type']), $dateTimeClasses)) {
            $class = ucfirst(substr($aDeliveryLimitation['type'], 5));
        } else {
            $class = 'Empty';
        }
        // Prepare the OA_Maintenance_Priority_DeliveryLimitation subclass name
        $className = 'OA_Maintenance_Priority_DeliveryLimitation_' . $class;
        // Instantiate the appropriate delivery limitation class
        $file = MAX_PATH . '/lib/OA/Maintenance/Priority/DeliveryLimitation/' . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            if (class_exists($className)) {
                return new $className($aDeliveryLimitation);
            }
        }
    }

}

?>
