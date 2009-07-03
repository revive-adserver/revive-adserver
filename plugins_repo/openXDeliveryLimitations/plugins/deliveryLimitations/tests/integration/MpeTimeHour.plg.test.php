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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/DeliveryLimitation.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Maintenance_Priority_DeliveryLimitation_Hour extends UnitTestCase
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
     * A method to test the deliveryBlocked() method.
     */
    function testDeliveryBlocked()
    {
        OA_setTimeZoneUTC();

        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'deliveryLimitations:Time:Hour',
            'comparison'     => '=~',
            'data'           => '1,5,7,20',
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

        // Test timezone
        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'deliveryLimitations:Time:Hour',
            'comparison'     => '=~',
            'data'           => '1,5,7,20@Europe/Rome',
            'executionorder' => 1
        );
        $oLimitationHour = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $oDate = new Date('2006-02-07 23:15:45');
        for ($i = 0; $i < 24; $i++) {
            $oDate->addSeconds(SECONDS_PER_HOUR);
            if (($i == 0) || ($i == 4) || ($i == 6) || ($i == 19)) {
                $this->assertFalse($oLimitationHour->deliveryBlocked($oDate));
            } else {
                $this->assertTrue($oLimitationHour->deliveryBlocked($oDate));
            }
        }

        OA_setTimeZoneLocal();
    }
}

?>
