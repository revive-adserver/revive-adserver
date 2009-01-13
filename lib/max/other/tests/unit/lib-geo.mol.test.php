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

require_once MAX_PATH . '/lib/max/other/lib-geo.inc.php';

/*
 * A class for testing the lib-geometry.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class LibGeometryTest extends UnitTestCase
{
     /**
     * The constructor method.
     */
    function LibGeometryTest()
    {
        $this->UnitTestCase();
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