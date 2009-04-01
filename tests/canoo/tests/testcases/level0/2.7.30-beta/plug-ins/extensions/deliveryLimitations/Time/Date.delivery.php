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
$Id: Date.delivery.php 30820 2009-01-13 19:02:17Z andrew.hill $
*/

/**
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Chris Nutting <chris@m3.net>
 */

/**
 * Check to see if this impression contains the valid date.
 *
 * @param string $limitation The date limitation
 * @param string $op The operator (either '==' or '!=')
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's date passes this limitation's test.
 */
function MAX_checkTime_Date($limitation, $op, $aParams = array())
{
    if ($limitation == '' && $limitation == '00000000') {
        return true;
    }
    OA_setTimeZoneLocal();
    $date = empty($aParams) ? date('Ymd') : $aParams['date'];
    OA_setTimeZoneUTC();
    switch ($op) {
        case '==': return ($date == $limitation); break;
        case '!=': return ($date != $limitation); break;
        case '<=': return ($date <= $limitation); break;
        case '>=': return ($date >= $limitation); break;
        case '<':  return ($date <  $limitation);  break;
        case '>':  return ($date >  $limitation);  break;
    }
    return true;
}

?>
