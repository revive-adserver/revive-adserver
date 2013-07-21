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

define('GEO_MIN_LATTITUDE', -89.9999);
define('GEO_MAX_LATTITUDE', 89.9999);
define('GEO_MIN_LONGITUDE', -179.9999);
define('GEO_MAX_LONGITUDE', 179.9999);


function MAX_geoGetLattitudeSouth($region)
{
    return $region[0];
}


function MAX_geoGetLattitudeNorth($region)
{
    return $region[1];
}


function MAX_geoGetLongitudeWest($region)
{
    return $region[2];
}


function MAX_geoGetLongitudeEast($region)
{
    return $region[3];
}


function MAX_geoIsPlaceInRegion($lattitude, $longitude, $region)
{
    $lattitudeSouth = $region[0];
    $lattitudeNorth = $region[1];
    $longitudeWest = $region[2];
    $longitudeEast = $region[3];

    return $lattitude >= $lattitudeSouth
        && $lattitude <= $lattitudeNorth
        && $longitude >= $longitudeWest
        && $longitude <= $longitudeEast;
}


function MAX_geoIsRegionPartlyWithinRegion($region1, $region2)
{
    $lattitudeSouth1 = $region1[0];
    $lattitudeNorth1 = $region1[1];
    $longitudeEast1 = $region1[2];
    $longitudeWest1 = $region1[3];

    return MAX_geoIsPlaceInRegion($lattitudeSouth1, $longitudeWest1, $region2)
        || MAX_geoIsPlaceInRegion($lattitudeSouth1, $longitudeEast1, $region2)
        || MAX_geoIsPlaceInRegion($lattitudeNorth1, $longitudeWest1, $region2)
        || MAX_geoIsPlaceInRegion($lattitudeNorth1, $longitudeEast1, $region2);
}


function MAX_geoDoRegionsHaveCommonPart($region1, $region2)
{
    return MAX_geoIsRegionPartlyWithinRegion($region1, $region2)
        || MAX_geoIsRegionPartlyWithinRegion($region2, $region1);
}


function MAX_geoIsRegionContainedInRegion($region1, $region2)
{
    $lattitudeSouth1 = $region1[0];
    $lattitudeNorth1 = $region1[1];
    $longitudeEast1 = $region1[2];
    $longitudeWest1 = $region1[3];

    return MAX_geoIsPlaceInRegion($lattitudeSouth1, $longitudeWest1, $region2)
        && MAX_geoIsPlaceInRegion($lattitudeSouth1, $longitudeEast1, $region2)
        && MAX_geoIsPlaceInRegion($lattitudeNorth1, $longitudeWest1, $region2)
        && MAX_geoIsPlaceInRegion($lattitudeNorth1, $longitudeEast1, $region2);
}


function MAX_geoDoesRegionSpanEntireLattitude($region)
{
    $lattitudeSouth = MAX_geoGetLattitudeSouth($region);
    $lattitudeNorth = MAX_geoGetLattitudeNorth($region);

    return $lattitudeSouth == GEO_MIN_LATTITUDE
        && $lattitudeNorth == GEO_MAX_LATTITUDE;
}


function MAX_geoDoesRegionSpanEntireLongitude($region)
{
    $longitudeWest = MAX_geoGetLongitudeWest($region);
    $longitudeEast = MAX_geoGetLongitudeEast($region);

    return $longitudeWest == GEO_MIN_LONGITUDE
        && $longitudeEast == GEO_MAX_LONGITUDE;
}


function MAX_geoDoesRegionSpanEntireWorld($region)
{
    return MAX_geoDoesRegionSpanEntireLattitude($region)
        && MAX_geoDoesRegionSpanEntireLongitude($region);
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


?>