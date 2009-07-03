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