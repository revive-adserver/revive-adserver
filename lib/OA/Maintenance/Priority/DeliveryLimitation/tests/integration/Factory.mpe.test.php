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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/DeliveryLimitation/Factory.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A class for testing the Maintenance_Priority_DeliveryLimitation_Factory class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Maintenance_Priority_DeliveryLimitation_Factory extends UnitTestCase
{
    function setUp()
    {
        // Install the openXDeliveryLog plugin
        TestEnv::uninstallPluginPackage('openXDeliveryLimitations', false);
        TestEnv::installPluginPackage('openXDeliveryLimitations', false);

    }

    function tearDown()
    {
        // Uninstall the openXDeliveryLog plugin
        TestEnv::uninstallPluginPackage('openXDeliveryLimitations', false);
    }

    /**
     * A method to test the factory method.
     *
     * Test 1: Test Date object creation
     * Test 2: Test Day object creation
     * Test 3: Test Empty object creation
     * Test 4: Test Hour object creation
     */
    function testFactory()
    {
        // Test 1
        $aDeliveryLimitation = array(
            'ad_id'          => 3,
            'logical'        => 'or',
            'type'           => 'deliveryLimitations:Time:Date',
            'comparison'     => '>',
            'data'           => '20050505',
            'executionorder' => 1
        );
        $obj = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertIsA($obj, 'OA_Maintenance_Priority_DeliveryLimitation_Common');

        // Test 2
        $aDeliveryLimitation = array(
            'ad_id'          => 3,
            'logical'        => 'and',
            'type'           => 'deliveryLimitations:Time:Day',
            'comparison'     => '=~',
            'data'           => '0,6',
            'executionorder' => 7
        );
        $obj = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertIsA($obj, 'OA_Maintenance_Priority_DeliveryLimitation_Common');

        // Test 4
        $aDeliveryLimitation = array(
            'ad_id'          => 3,
            'logical'        => 'and',
            'type'           => 'deliveryLimitations:Time:Hour',
            'comparison'     => '=~',
            'data'           => '0,6,21',
            'executionorder' => 0
          );
        $obj = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertIsA($obj, 'OA_Maintenance_Priority_DeliveryLimitation_Common');

        // Test 4
        $aDeliveryLimitation = array(
            'ad_id'          => 3,
            'logical'        => 'and',
            'type'           => 'deliveryLimitations:Client:IP',
            'comparison'     => '=~',
            'data'           => '192.168.0.1',
            'executionorder' => 0
        );
        $obj = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertIsA($obj, 'OA_Maintenance_Priority_DeliveryLimitation_Empty');

        // Test 5
        $aDeliveryLimitation = array(
            'ad_id'          => 3,
            'logical'        => 'and',
            'type'           => 'Bogus',
            'comparison'     => '=~',
            'data'           => '192.168.0.1',
            'executionorder' => 0
        );
        $obj = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertIsA($obj, 'OA_Maintenance_Priority_DeliveryLimitation_Empty');
    }

}

?>
