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
 * A class for testing the Plugins_DeliveryLimitations_Time_Date class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Time_Date extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Plugins_TestOfPlugins_DeliveryLimitations_Time_Date()
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
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Time', 'Date');
        $result = $oPlugin->_getSqlLimitation('==', '00000000');
        $this->assertTrue($result);
        $result = $oPlugin->_getSqlLimitation('==', '20061013');
        $this->assertEqual($result, "DATE_FORMAT(date_time, '%Y%m%d') = '20061013'");
        $result = $oPlugin->_getSqlLimitation('>=', '20061013');
        $this->assertEqual($result, "DATE_FORMAT(date_time, '%Y%m%d') >= '20061013'");
        $result = $oPlugin->_getSqlLimitation('<', '20061013');
        $this->assertEqual($result, "DATE_FORMAT(date_time, '%Y%m%d') < '20061013'");
        $result = $oPlugin->_getSqlLimitation('!=', '20061013');
        $this->assertEqual($result, "DATE_FORMAT(date_time, '%Y%m%d') != '20061013'");
    }

    function testCompile()
    {
        $current_quotes_runtime = get_magic_quotes_runtime();
        set_magic_quotes_runtime(1);

        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Time', 'Date');
        $oPlugin->init(array('comparison' => '=='));
        $this->assertEqual('MAX_checkTime_Date(\'00000000\', \'==\')', $oPlugin->compile());
        $rawData = '20061113';
        $oPlugin->init(array('data' => $rawData, 'comparison' => '=='));
        $this->assertEqual('MAX_checkTime_Date(\'20061113\', \'==\')', $oPlugin->compile());
        $this->assertEqual($rawData, $oPlugin->getData());

        set_magic_quotes_runtime($current_quotes_runtime);
    }

    /**
     * A method to test the overlap() method.
     *
     * Requirements:
     * Test with '00000000' as the data in either, and both, comparisons, and ensure
     * true is returned.
     */
    function testOverlapEmptyDate()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Time', 'Date');

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '00000000'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '00000000'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '00000000'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '00000000'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);
    }

    /**
     * A method to test the overlap() method.
     *
     * Requirements:
     * Test all possible combinations with the first date an '==' comparison, and
     * ensure the correct values are returned.
     */
    function testOverlapEqualFirst()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Time', 'Date');

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<=',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<=',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<=',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>=',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>=',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);
    }

    /**
     * A method to test the overlap() method.
     *
     * Requirements:
     * Test all possible comninations with the first date a '!=' comparison, and
     * ensure the correct values are returned.
     */
    function testOverlapNotEqualFirst()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Time', 'Date');

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<=',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<=',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<=',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>=',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>=',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);
    }

    /**
     * A method to test the overlap() method.
     *
     * Requirements:
     * Test all possible comninations with the first date a '<' comparison, and
     * ensure the correct values are returned.
     */
    function testOverlapLessThanFirst()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Time', 'Date');

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<=',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<=',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<=',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>=',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>=',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);
    }

    /**
     * A method to test the overlap() method.
     *
     * Requirements:
     * Test all possible comninations with the first date a '<=' comparison, and
     * ensure the correct values are returned.
     */
    function testOverlapLessThanEqualFirst()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Time', 'Date');

        $aLimitation1 = array(
            'comparison' => '<=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<=',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<=',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<=',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>=',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>=',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);
    }

    /**
     * A method to test the overlap() method.
     *
     * Requirements:
     * Test all possible comninations with the first date a '>' comparison, and
     * ensure the correct values are returned.
     */
    function testOverlapGreaterThanFirst()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Time', 'Date');

        $aLimitation1 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<=',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<=',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<=',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>=',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>=',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);
    }

    /**
     * A method to test the overlap() method.
     *
     * Requirements:
     * Test all possible comninations with the first date a '>=' comparison, and
     * ensure the correct values are returned.
     */
    function testOverlapGreaterThanEqualFirst()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Time', 'Date');

        $aLimitation1 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '==',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '!=',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<=',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, false);

        $aLimitation1 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<=',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '<=',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>=',
            'data'       => '20061029'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);

        $aLimitation1 = array(
            'comparison' => '>=',
            'data'       => '20061030'
        );
        $aLimitation2 = array(
            'comparison' => '>=',
            'data'       => '20061031'
        );
        $result = $oPlugin->overlap($aLimitation1, $aLimitation2);
        $this->assertEqual($result, true);
    }

}

?>
