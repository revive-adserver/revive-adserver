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
$Id: PriorityDeliveryLimitationDay.mtp.test.php 5631 2006-10-09 18:21:43Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/max/Maintenance/Priority/DeliveryLimitation.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/DeliveryLimitation/Day.php';
require_once 'Date.php';

/**
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 * @author     James Floyd <james@m3.net>
 */
class Delivery_TestOfPriorityDeliveryLimitationDay extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Delivery_TestOfPriorityDeliveryLimitationDay()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the calculateNonDeliveryDeliveryLimitation() method.
     *
     * Test 1: Test with == comparison
     * Test 2: Test with != comparison
     */
    function testCalculateNonDeliveryDeliveryLimitation()
    {
        // Test 1
        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'Time:Day',
            'comparison'     => '==',
            'data'           => '0,2,5',
            'executionorder' => 1
        );
        $oLimitationDay = MAX_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertTrue(count($oLimitationDay->data) == 4);
        $this->assertTrue(empty($oLimitationDay->data[0]));
        $this->assertTrue(isset($oLimitationDay->data[1]));
        $this->assertEqual($oLimitationDay->data[1], 1);
        $this->assertTrue(empty($oLimitationDay->data[2]));
        $this->assertTrue(isset($oLimitationDay->data[3]));
        $this->assertEqual($oLimitationDay->data[3], 3);
        $this->assertTrue(isset($oLimitationDay->data[4]));
        $this->assertEqual($oLimitationDay->data[4], 4);
        $this->assertTrue(empty($oLimitationDay->data[5]));
        $this->assertTrue(isset($oLimitationDay->data[6]));
        $this->assertEqual($oLimitationDay->data[6], 6);

        // Test 2
        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'Time:Day',
            'comparison'     => '!=',
            'data'           => '0,2,5',
            'executionorder' => 1
        );
        $oLimitationDay = MAX_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertTrue(count($oLimitationDay->data) == 3);
        $this->assertTrue(isset($oLimitationDay->data[0]));
        $this->assertEqual($oLimitationDay->data[0], 0);
        $this->assertTrue(isset($oLimitationDay->data[1]));
        $this->assertEqual($oLimitationDay->data[1], 2);
        $this->assertTrue(isset($oLimitationDay->data[2]));
        $this->assertEqual($oLimitationDay->data[2], 5);
    }

    /**
     * A method to test the minutesPerTimePeriod() method.
     */
    function testMinutesPerTimePeriod()
    {
        $this->assertEqual(MAX_Maintenance_Priority_DeliveryLimitation_Day::minutesPerTimePeriod(), 10080);
    }

    /**
     * A method to test the deliveryBlocked() method.
     */
    function testDeliveryBlocked()
    {
        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'Time:Day',
            'comparison'     => '==',
            'data'           => '1, 5, 4, 6',
            'executionorder' => 1
        );
        $oLimitationDay = MAX_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);

        $oDate = new Date('2006-02-05'); // Sunday
        $this->assertTrue($oLimitationDay->deliveryBlocked($oDate));
        $oDate = new Date('2006-02-06'); // Monday
        $this->assertFalse($oLimitationDay->deliveryBlocked($oDate));
        $oDate = new Date('2006-02-07'); // Tuesday
        $this->assertTrue($oLimitationDay->deliveryBlocked($oDate));
        $oDate = new Date('2006-02-08'); // Wednesday
        $this->assertTrue($oLimitationDay->deliveryBlocked($oDate));
        $oDate = new Date('2006-02-09'); // Thursday
        $this->assertFalse($oLimitationDay->deliveryBlocked($oDate));
        $oDate = new Date('2006-02-10'); // Friday
        $this->assertFalse($oLimitationDay->deliveryBlocked($oDate));
        $oDate = new Date('2006-02-11'); // Saturday
        $this->assertFalse($oLimitationDay->deliveryBlocked($oDate));
    }

}

?>
