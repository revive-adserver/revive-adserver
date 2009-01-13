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

require_once MAX_PATH . '/lib/max/Plugin.php';
// Using multi-dirname so that the tests can run from either plugins or plugins_repo
require_once dirname(dirname(dirname(__FILE__))) . '/Geo/Netspeed.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_Netspeed class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Geo_Netspeed extends UnitTestCase
{
    function testCheckGeoNetspeed()
    {
        // =~ and !~ - Single country
        $this->assertTrue(MAX_checkGeo_Netspeed('dialup',    '=~', array('netspeed' => 'dialup')));
        $this->assertTrue(MAX_checkGeo_Netspeed('dialup',    '!~', array('netspeed' => 'cabledsl')));

        // =~ and !~ - Multiple country
        $this->assertTrue(MAX_checkGeo_Netspeed('cabledsl,corporate',  '=~', array('netspeed' => 'cabledsl')));
        $this->assertTrue(MAX_checkGeo_Netspeed('cabledsl,corporate',  '=~', array('netspeed' => 'corporate')));
        $this->assertTrue(MAX_checkGeo_Netspeed('cabledsl,corporate',  '!~', array('netspeed' => 'unknown')));
        $this->assertFalse(MAX_checkGeo_Netspeed('cabledsl,corporate', '!~', array('netspeed' => 'cabledsl')));
    }
}

?>
