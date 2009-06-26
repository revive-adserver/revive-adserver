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

    /**
     * The constructor method.
     */
    function Test_OA_Maintenance_Priority_DeliveryLimitation_Factory()
    {
        $this->UnitTestCase();
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
            'type'           => 'DeliveryLimitations:Time:Date',
            'comparison'     => '>',
            'data'           => '2005-05-05',
            'executionorder' => 1
        );
        $obj = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertIsA($obj, 'OA_Maintenance_Priority_DeliveryLimitation_Date');
        $this->assertEqual($obj->logical, 'or');
        $this->assertEqual($obj->type, 'DeliveryLimitations:Time:Date');
        $this->assertEqual($obj->comparison, '<=');
        $this->assertEqual($obj->data[0], '2005-05-05');
        $this->assertEqual($obj->executionOrder, 1);
        $this->assertTrue(is_a($obj->date, 'date'));
        $this->assertEqual($obj->date->format('%Y-%m-%d %H:%M:%S'), '2005-05-05 00:00:00');
        unset($obj);

        // Test 2
        $aDeliveryLimitation = array(
            'ad_id'          => 3,
            'logical'        => 'and',
            'type'           => 'DeliveryLimitations:Time:Day',
            'comparison'     => '=~',
            'data'           => '0,6',
            'executionorder' => 7
        );
        $obj = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertIsA($obj, 'OA_Maintenance_Priority_DeliveryLimitation_Day');
        $this->assertEqual($obj->logical, 'and');
        $this->assertEqual($obj->type, 'DeliveryLimitations:Time:Day');
        $this->assertEqual($obj->comparison, '!~');
        $this->assertEqual($obj->data[1], 1);
        $this->assertEqual($obj->data[2], 2);
        $this->assertEqual($obj->data[3], 3);
        $this->assertEqual($obj->data[4], 4);
        $this->assertEqual($obj->data[5], 5);
        $this->assertEqual($obj->executionOrder, 7);
        unset($obj);

        // Test 3
        $aDeliveryLimitation = array(
            'ad_id'          => 3,
            'logical'        => 'and',
            'type'           => 'Client:IP',
            'comparison'     => '=~',
            'data'           => '192.168.0.1',
            'executionorder' => 0
        );
        $obj = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertIsA($obj, 'OA_Maintenance_Priority_DeliveryLimitation_Empty');
        unset($obj);

        // Test 4
        $aDeliveryLimitation = array(
            'ad_id'          => 3,
            'logical'        => 'and',
            'type'           => 'DeliveryLimitations:Time:Hour',
            'comparison'     => '=~',
            'data'           => '0,6,21',
            'executionorder' => 0
          );
        $obj = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertIsA($obj, 'OA_Maintenance_Priority_DeliveryLimitation_Hour');
        $this->assertEqual($obj->logical, 'and');
        $this->assertEqual($obj->type, 'DeliveryLimitations:Time:Hour');
        $this->assertEqual($obj->comparison, '!~');
        $this->assertTrue(!isset($obj->data[0]));
        $this->assertEqual($obj->data[1], 1);
        $this->assertEqual($obj->data[2], 2);
        $this->assertEqual($obj->data[3], 3);
        $this->assertEqual($obj->data[4], 4);
        $this->assertEqual($obj->data[5], 5);
        $this->assertTrue(!isset($obj->data[6]));
        $this->assertEqual($obj->data[7], 7);
        $this->assertEqual($obj->data[8], 8);
        $this->assertEqual($obj->data[9], 9);
        $this->assertEqual($obj->data[10], 10);
        $this->assertEqual($obj->data[11], 11);
        $this->assertEqual($obj->data[12], 12);
        $this->assertEqual($obj->data[13], 13);
        $this->assertEqual($obj->data[14], 14);
        $this->assertEqual($obj->data[15], 15);
        $this->assertEqual($obj->data[16], 16);
        $this->assertEqual($obj->data[17], 17);
        $this->assertEqual($obj->data[18], 18);
        $this->assertEqual($obj->data[19], 19);
        $this->assertEqual($obj->data[20], 20);
        $this->assertTrue(!isset($obj->data[21]));
        $this->assertEqual($obj->data[22], 22);
        $this->assertEqual($obj->data[23], 23);
        $this->assertTrue(!isset($obj->data[24]));
        $this->assertEqual($obj->executionOrder, 0);
        unset($obj);
    }

}

?>
