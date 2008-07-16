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

require_once MAX_PATH . '/lib/max/Plugin.php';
// Using multi-dirname so that the tests can run from either plugins or plugins_repo
require_once dirname(dirname(dirname(__FILE__))) . '/Geo/Areacode.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_Areacode class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Geo_Areacode extends UnitTestCase
{
    /**
     * This test tests the checkGeo areacode function, see here for the codes:
     * @link http://www.maxmind.com/app/metro_code
     *
     */
    function testMAX_checkGeoAreacode()
    {
        // == and !=
        $this->assertTrue(MAX_checkGeo_Areacode('502', '==', array('area_code' => '502')));
        $this->assertFalse(MAX_checkGeo_Areacode('502', '!=', array('area_code' => '502')));
        $this->assertFalse(MAX_checkGeo_Areacode('502', '==', array('area_code' => '501')));
        $this->assertTrue(MAX_checkGeo_Areacode('502', '!=', array('area_code' => '501')));

        // =~ and !~
        $this->assertTrue(MAX_checkGeo_Areacode('02', '=~', array('area_code' => '502')));
        $this->assertFalse(MAX_checkGeo_Areacode('02', '!~', array('area_code' => '502')));
        $this->assertFalse(MAX_checkGeo_Areacode('02', '=~', array('area_code' => '501')));
        $this->assertTrue(MAX_checkGeo_Areacode('02', '!~', array('area_code' => '501')));

        // =x and !x
        $this->assertTrue(MAX_checkGeo_Areacode('5[0-9]2', '=x', array('area_code' => '502')));
        $this->assertFalse(MAX_checkGeo_Areacode('5[0-9]2', '!x', array('area_code' => '502')));
        $this->assertFalse(MAX_checkGeo_Areacode('5[1-9]2', '=x', array('area_code' => '501')));
        $this->assertTrue(MAX_checkGeo_Areacode('5[1-9]2', '!x', array('area_code' => '501')));
    }
}

?>
