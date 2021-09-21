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

function MAX_geoIsPointInsideRect($latitude, $longitude, $region)
{
    return $latitude >= $region[0]
        && $latitude <= $region[1]
        && $longitude >= $region[2]
        && $longitude <= $region[3];
}

/**
 * Replaces all empty strings in an array with a string
 * of '0.0000'. Returns the replaced string.
 *
 * @param array $aRegion
 * @return array
 */
function MAX_geoReplaceEmptyWithZero($aRegion)
{
    for ($i = 0; $i < count($aRegion); $i++) {
        if ($aRegion[$i] == '') {
            $aRegion[$i] = '0.0000';
        }
    }
    return $aRegion;
}
