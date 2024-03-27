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
    public function test_MAX_geoIsPlaceInRegion()
    {
        $this->assertTrue(MAX_geoIsPointInsideRect(
            '10.0000',
            '10.0000',
            $this->newRegion('5.0000', '15.0000', '5.0000', '15.0000')
        ));
        $this->assertTrue(MAX_geoIsPointInsideRect(
            '-10.0000',
            '6.0000',
            $this->newRegion('-11.0000', '6.0000', '6.0000', '12.0000')
        ));
        $this->assertFalse(MAX_geoIsPointInsideRect(
            '-10.0000',
            '6.0000',
            $this->newRegion('-9.0000', '6.0000', '6.0000', '12.0000')
        ));
        $this->assertFalse(MAX_geoIsPointInsideRect(
            '-10.0000',
            '6.0000',
            $this->newRegion('-11.0000', '6.0000', '6.0001', '12.0000')
        ));
    }

    public function newRegion($lattitudeSouth, $lattitudeNorth, $longitudeWest, $longitudeEast)
    {
        return [$lattitudeSouth, $lattitudeNorth, $longitudeWest, $longitudeEast];
    }
}
