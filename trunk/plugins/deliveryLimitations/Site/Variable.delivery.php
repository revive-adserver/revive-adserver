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
$Id: Variable.plugin.php 8911 2007-08-10 09:47:46Z andrew.hill@openads.org $
*/

require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';

/**
 * Check if a value passed into the ad request (through $_REQUEST (so GET/POST/COOKIE)
 * via a name=value pair matches the limitation configured
 *
 * @param string $limitation The variable limitation
 * @param string $op The operator
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's channel passes this limitation's test.
 * @author     Chris Nutting <chris.nutting@openx.org>
 * @author Mohammed El-Hakim
 */
function MAX_checkSite_Variable($limitation, $op, $aParams = array())
{
    if (empty($aParams)) {
        $aParams = $_REQUEST;
    }
    list($key,$value) = explode('|', $limitation);
    if (!isset($limitation) || !isset($aParams[$key])) {
        // To be safe, unless the paramters passed in, and configured are avaiable,
        // return depending on if the $op is considered a 'positive' test
        return !MAX_limitationsIsOperatorPositive($op);
    } else if (MAX_limitationsIsOperatorNumeric($op)) {
        return MAX_limitationMatchNumeric($key, $value, $op, $aParams);
    } else {
        return MAX_limitationsMatchString($key, $value, $op, $aParams);
    }
}

?>
