<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/max/Maintenance/Priority/DeliveryLimitation.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/DeliveryLimitation/Empty.php';
require_once 'Date.php';

/**
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Delivery_TestOfPriorityDeliveryLimitationEmpty extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Delivery_TestOfPriorityDeliveryLimitationEmpty()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the minutesPerTimePeriod() method.
     */
    function testMinutesPerTimePeriod()
    {
        $this->assertEqual(MAX_Maintenance_Priority_DeliveryLimitation_Empty::minutesPerTimePeriod(), 0);
    }

    /**
     * A method to test the deliveryBlocked() method.
     */
    function testDeliveryBlocked()
    {
        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'Client:IP',
            'comparison'     => '==',
            'data'           => '192.168.0.1',
            'executionorder' => 1
        );
        $oLimitationDay = MAX_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);

        $oDate = new Date('2006-02-05');
        $this->assertFalse($oLimitationDay->deliveryBlocked($oDate));
    }

}

?>
