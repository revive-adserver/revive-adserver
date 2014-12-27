<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/DeliveryLimitation.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * @package    OpenXMaintenance
 * @subpackage TestSuite
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
