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

require_once MAX_PATH . '/lib/max/other/lib-geo.inc.php';

/*
 * A class for testing the lib-geometry.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class LibGeometryTest extends UnitTestCase
{
     /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }


    function test_MAX_geoIsPlaceInRegion()
    {
        $this->assertTrue(MAX_geoIsPlaceInRegion('10.0000', '10.0000',
            $this->newRegion('5.0000', '15.0000', '5.0000', '15.0000')));
        $this->assertTrue(MAX_geoIsPlaceInRegion('-10.0000', '6.0000',
            $this->newRegion('-11.0000', '6.0000', '6.0000', '12.0000')));
        $this->assertFalse(MAX_geoIsPlaceInRegion('-10.0000', '6.0000',
            $this->newRegion('-9.0000', '6.0000', '6.0000', '12.0000')));
        $this->assertFalse(MAX_geoIsPlaceInRegion('-10.0000', '6.0000',
            $this->newRegion('-11.0000', '6.0000', '6.0001', '12.0000')));
    }


    function test_MAX_geoIsRegionPartlyWithinRegion()
    {
        $this->assertFalse(MAX_geoIsRegionPartlyWithinRegion(
            $this->newRegion(-10.0000, -4.0000, -3.0000, -2.0000),
            $this->newRegion(-3.0000, -2.0000, 4.000, 6.0000)));
        $this->assertTrue(MAX_geoIsRegionPartlyWithinRegion(
            $this->newRegion(-10.0000, -4.0000, -3.0000, -2.0000),
            $this->newRegion(-4.0000, -2.0000, -2.000, 6.0000)));
        $this->assertFalse(MAX_geoIsRegionPartlyWithinRegion(
            $this->newRegion(-10.0000, -4.0000, -3.0000, -2.0000),
            $this->newRegion(-8.0000, -6.0000, -2.6000, 1.3000)));
        $this->assertTrue(MAX_geoIsRegionPartlyWithinRegion(
            $this->newRegion(-8.0000, -6.0000, -2.6000, 1.3000),
            $this->newRegion(-10.0000, -4.0000, -3.0000, -2.0000)));
        $this->assertTrue(MAX_geoIsRegionPartlyWithinRegion(
            $this->newRegion(-8.0000, -6.0000, -2.6000, -2.3000),
            $this->newRegion(-10.0000, -4.0000, -3.0000, -2.0000)));
    }


    function test_MAX_geoDoRegionsHaveCommonPart()
    {
        $this->assertTrue(MAX_geoDoRegionsHaveCommonPart(
            $this->newRegion(-10.0000, -4.0000, -3.0000, -2.0000),
            $this->newRegion(-8.0000, -6.0000, -2.6000, 1.3000)));
        $this->assertTrue(MAX_geoDoRegionsHaveCommonPart(
            $this->newRegion(-20.0000,-10.0000,-40.000,40.0000),
            $this->newRegion(-15.0000, -5.0000, 30.0000, 40.0000)));
    }


    function test_MAX_geoIsRegionContainedInRegion()
    {
        $this->assertTrue(MAX_geoIsRegionContainedInRegion(
            $this->newRegion(-8.0000, -6.0000, -2.6000, -2.3000),
            $this->newRegion(-10.0000, -4.0000, -3.0000, -2.0000)));
        $this->assertFalse(MAX_geoIsRegionContainedInRegion(
            $this->newRegion(-10.0000, -4.0000, -3.0000, -2.0000),
            $this->newRegion(-8.0000, -6.0000, -2.6000, -2.3000)));
    }


    function test_MAX_geoDoesRegionSpanEntireWorld()
    {
        $this->assertTrue(MAX_geoDoesRegionSpanEntireWorld(
            $this->newRegion(GEO_MIN_LATTITUDE, GEO_MAX_LATTITUDE,
                GEO_MIN_LONGITUDE, GEO_MAX_LONGITUDE)));
        $this->assertFalse(MAX_geoDoesRegionSpanEntireWorld(
            $this->newRegion(-8.0000, -6.0000, -2.6000, -2.3000)));
    }


    function newRegion($lattitudeSouth, $lattitudeNorth, $longitudeWest, $longitudeEast)
    {
        return array($lattitudeSouth, $lattitudeNorth, $longitudeWest, $longitudeEast);
    }
}
?>