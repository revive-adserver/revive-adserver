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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/DeliveryLimitation.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/DeliveryLimitation/Hour.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Maintenance_Priority_DeliveryLimitation_Hour extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_OA_Maintenance_Priority_DeliveryLimitation_Hour()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the calculateNonDeliveryDeliveryLimitation() method.
     *
     * Test 1: Test with =~ comparison
     * Test 2: Test with !~ comparison
     */
    function testCalculateNonDeliveryRestrictions()
    {
        // Test 1
        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'Time:Hour',
            'comparison'     => '=~',
            'data'           => '1,7,18,23',
            'executionorder' => 1,
        );
        $oLimitationHour = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertEqual(count($oLimitationHour->data), 20);
        $this->assertTrue(isset($oLimitationHour->data[0]));
        $this->assertEqual($oLimitationHour->data[0], 0);
        $this->assertTrue(empty($oLimitationHour->data[1]));
        $this->assertTrue(isset($oLimitationHour->data[2]));
        $this->assertEqual($oLimitationHour->data[2], 2);
        $this->assertTrue(isset($oLimitationHour->data[3]));
        $this->assertEqual($oLimitationHour->data[3], 3);
        $this->assertTrue(isset($oLimitationHour->data[4]));
        $this->assertEqual($oLimitationHour->data[4], 4);
        $this->assertTrue(isset($oLimitationHour->data[5]));
        $this->assertEqual($oLimitationHour->data[5], 5);
        $this->assertTrue(isset($oLimitationHour->data[6]));
        $this->assertEqual($oLimitationHour->data[6], 6);
        $this->assertTrue(empty($oLimitationHour->data[7]));
        $this->assertTrue(isset($oLimitationHour->data[8]));
        $this->assertEqual($oLimitationHour->data[8], 8);
        $this->assertTrue(isset($oLimitationHour->data[9]));
        $this->assertEqual($oLimitationHour->data[9], 9);
        $this->assertTrue(isset($oLimitationHour->data[10]));
        $this->assertEqual($oLimitationHour->data[10], 10);
        $this->assertTrue(isset($oLimitationHour->data[11]));
        $this->assertEqual($oLimitationHour->data[11], 11);
        $this->assertTrue(isset($oLimitationHour->data[12]));
        $this->assertEqual($oLimitationHour->data[12], 12);
        $this->assertTrue(isset($oLimitationHour->data[13]));
        $this->assertEqual($oLimitationHour->data[13], 13);
        $this->assertTrue(isset($oLimitationHour->data[14]));
        $this->assertEqual($oLimitationHour->data[14], 14);
        $this->assertTrue(isset($oLimitationHour->data[15]));
        $this->assertEqual($oLimitationHour->data[15], 15);
        $this->assertTrue(isset($oLimitationHour->data[16]));
        $this->assertEqual($oLimitationHour->data[16], 16);
        $this->assertTrue(isset($oLimitationHour->data[17]));
        $this->assertEqual($oLimitationHour->data[17], 17);
        $this->assertTrue(empty($oLimitationHour->data[18]));
        $this->assertTrue(isset($oLimitationHour->data[19]));
        $this->assertEqual($oLimitationHour->data[19], 19);
        $this->assertTrue(isset($oLimitationHour->data[20]));
        $this->assertEqual($oLimitationHour->data[20], 20);
        $this->assertTrue(isset($oLimitationHour->data[21]));
        $this->assertEqual($oLimitationHour->data[21], 21);
        $this->assertTrue(isset($oLimitationHour->data[22]));
        $this->assertEqual($oLimitationHour->data[22], 22);
        $this->assertTrue(empty($oLimitationHour->data[23]));

        // Test 2
        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'Time:Hour',
            'comparison'     => '!~',
            'data'           => '1,7,18,23',
            'executionorder' => 1,
        );
        $oLimitationHour = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertEqual(count($oLimitationHour->data), 4);
        $this->assertTrue(isset($oLimitationHour->data[0]));
        $this->assertEqual($oLimitationHour->data[0], 1);
        $this->assertTrue(isset($oLimitationHour->data[1]));
        $this->assertEqual($oLimitationHour->data[1], 7);
        $this->assertTrue(isset($oLimitationHour->data[2]));
        $this->assertEqual($oLimitationHour->data[2], 18);
        $this->assertTrue(isset($oLimitationHour->data[3]));
        $this->assertEqual($oLimitationHour->data[3], 23);
    }

    /**
     * A method to test the minutesPerTimePeriod() method.
     */
    function testMinutesPerTimePeriod()
    {
        $this->assertEqual(OA_Maintenance_Priority_DeliveryLimitation_Hour::minutesPerTimePeriod(), 60);
    }

    /**
     * A method to test the deliveryBlocked() method.
     */
    function testDeliveryBlocked()
    {
        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'Time:Hour',
            'comparison'     => '=~',
            'data'           => '1, 5, 7, 20',
            'executionorder' => 1
        );
        $oLimitationHour = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $oDate = new Date('2006-02-07 23:15:45');
        for ($i = 0; $i < 24; $i++) {
            $oDate->addSeconds(SECONDS_PER_HOUR);
            if (($i == 1) || ($i == 5) || ($i == 7) || ($i == 20)) {
                $this->assertFalse($oLimitationHour->deliveryBlocked($oDate));
            } else {
                $this->assertTrue($oLimitationHour->deliveryBlocked($oDate));
            }
        }
    }
}

?>
