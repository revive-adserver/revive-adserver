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

/**
 * A class for testing the Plugins_DeliveryLimitations_Time_Day class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Time_Day extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Plugins_TestOfPlugins_DeliveryLimitations_Time_Day()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the _getSqlLimitation() method.
     *
     * @TODO Needs to be changed to deal with databases other than MySQL.
     */
    function test_getSqlLimitation()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Time', 'Day');
        $result = $oPlugin->_getSqlLimitation('==', '0');
        $this->assertEqual($result, "LOWER(DAYOFWEEK(date_time)) IN ('1')");
        $result = $oPlugin->_getSqlLimitation('!=', '0,3,5');
        $this->assertEqual($result, "LOWER(DAYOFWEEK(date_time)) NOT IN ('1','4','6')");
    }

    /**
     * A method to test the overlap() method.
     */
    function testOverlap()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Time', 'Day');

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '1'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '1'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '1'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '2'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '1,2'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '2,3'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '1,2'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '3,4'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '1'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '1'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '1'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '2'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '1,2'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '2,3'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '1,2'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '3,4'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '1'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '1'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '1'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '2'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '1,2'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '2,3'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '1,2'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '3,4'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);
    }

}

?>
