<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: PriorityDeliveryLimitation.mtp.test.php 4346 2006-03-06 16:43:19Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/max/Maintenance/Priority/DeliveryLimitation/Factory.php';
require_once 'Date.php';

/**
 * A class for testing the Maintenance_Priority_DeliveryLimitation_Factory class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 * @author     James Floyd <james@m3.net>
 */
class Maintenance_TestOfPriorityDeliveryLimitationFactory extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfPriorityDeliveryLimitationFactory()
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
            'type'           => 'Time:Date',
            'comparison'     => '>',
            'data'           => '2005-05-05',
            'executionorder' => 1
        );
        $obj = MAX_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertIsA($obj, 'MAX_Maintenance_Priority_DeliveryLimitation_Date');
        $this->assertTrue($obj->logical == 'or');
        $this->assertTrue($obj->type == 'Time:Date');
        $this->assertTrue($obj->comparison == '<=');
        $this->assertTrue($obj->data[0] == '2005-05-05');
        $this->assertTrue($obj->executionOrder == 1);
        $this->assertTrue(is_a($obj->date, 'date'));
        $this->assertEqual($obj->date->format('%Y-%m-%d %H:%M:%S'), '2005-05-05 00:00:00');
        unset($obj);

        // Test 2
        $aDeliveryLimitation = array(
            'ad_id'          => 3,
            'logical'        => 'and',
            'type'           => 'Time:Day',
            'comparison'     => '==',
            'data'           => '0,6',
            'executionorder' => 7
        );
        $obj = MAX_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertIsA($obj, 'MAX_Maintenance_Priority_DeliveryLimitation_Day');
        $this->assertTrue($obj->logical == 'and');
        $this->assertTrue($obj->type == 'Time:Day');
        $this->assertTrue($obj->comparison == '!=');
        $this->assertTrue($obj->data[1] == 1);
        $this->assertTrue($obj->data[2] == 2);
        $this->assertTrue($obj->data[3] == 3);
        $this->assertTrue($obj->data[4] == 4);
        $this->assertTrue($obj->data[5] == 5);
        $this->assertTrue($obj->executionOrder == 7);
        unset($obj);

        // Test 3
        $aDeliveryLimitation = array(
            'ad_id'          => 3,
            'logical'        => 'and',
            'type'           => 'Client:IP',
            'comparison'     => '==',
            'data'           => '192.168.0.1',
            'executionorder' => 0
        );
        $obj = MAX_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertIsA($obj, 'MAX_Maintenance_Priority_DeliveryLimitation_Empty');
        unset($obj);

        // Test 4
        $aDeliveryLimitation = array(
            'ad_id'          => 3,
            'logical'        => 'and',
            'type'           => 'Time:Hour',
            'comparison'     => '==',
            'data'           => '0,6,21',
            'executionorder' => 0
          );
        $obj = MAX_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertIsA($obj, 'MAX_Maintenance_Priority_DeliveryLimitation_Hour');
        $this->assertTrue($obj->logical == 'and');
        $this->assertTrue($obj->type == 'Time:Hour');
        $this->assertTrue($obj->comparison == '!=');
        $this->assertTrue(!isset($obj->data[0]));
        $this->assertTrue($obj->data[1] == 1);
        $this->assertTrue($obj->data[2] == 2);
        $this->assertTrue($obj->data[3] == 3);
        $this->assertTrue($obj->data[4] == 4);
        $this->assertTrue($obj->data[5] == 5);
        $this->assertTrue(!isset($obj->data[6]));
        $this->assertTrue($obj->data[7] == 7);
        $this->assertTrue($obj->data[8] == 8);
        $this->assertTrue($obj->data[9] == 9);
        $this->assertTrue($obj->data[10] == 10);
        $this->assertTrue($obj->data[11] == 11);
        $this->assertTrue($obj->data[12] == 12);
        $this->assertTrue($obj->data[13] == 13);
        $this->assertTrue($obj->data[14] == 14);
        $this->assertTrue($obj->data[15] == 15);
        $this->assertTrue($obj->data[16] == 16);
        $this->assertTrue($obj->data[17] == 17);
        $this->assertTrue($obj->data[18] == 18);
        $this->assertTrue($obj->data[19] == 19);
        $this->assertTrue($obj->data[20] == 20);
        $this->assertTrue(!isset($obj->data[21]));
        $this->assertTrue($obj->data[22] == 22);
        $this->assertTrue($obj->data[23] == 23);
        $this->assertTrue(!isset($obj->data[24]));
        $this->assertTrue($obj->executionOrder == 0);
        unset($obj);
    }

}

?>
