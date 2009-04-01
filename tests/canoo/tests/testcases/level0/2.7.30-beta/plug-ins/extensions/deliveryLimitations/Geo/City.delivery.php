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
$Id: City.delivery.php 30820 2009-01-13 19:02:17Z andrew.hill $
*/

/**
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Chris Nutting <chris@m3.net>
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */

require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';

/**
 * Check to see if this impression contains the valid city.
 *
 * @param string $limitation The city (or comma list of cities) limitation
 * @param string $op The operator (either '==' or '!=')
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's city passes this limitation's test.
 */
function MAX_checkGeo_City($limitation, $op, $aParams = array())
{
    if (empty($aParams)) {
        $aParams = $GLOBALS['_MAX']['CLIENT_GEO'];
    }
    if ($aParams && $aParams['city'] && $aParams['country_code']) {
        $aLimitation = array ( substr($limitation, 0, strpos($limitation, '|')),
                               substr($limitation, strpos($limitation, '|')+1)
                              );                               
        $sCities = $aLimitation[1];
        if (!empty($aLimitation[0])) {
            return MAX_limitationsMatchStringValue($aParams['country_code'], $aLimitation[0], '==')
                   && MAX_limitationsMatchArrayValue($aParams['city'], $sCities, $op);
        } else {
            return MAX_limitationsMatchArrayValue($aParams['city'], $sCities, $op);
        }
    } else {
        return false; // If client has no data about city, do not show the ad
    }
}

?>
