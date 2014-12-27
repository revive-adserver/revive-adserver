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
class Test_OA_Maintenance_Priority_DeliveryLimitation_Day extends UnitTestCase
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
            'type'           => 'deliveryLimitations:Time:Day',
            'comparison'     => '=~',
            'data'           => '1,5,4,6',
            'executionorder' => 1
        );
        $oLimitationDay = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);

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

        // Test timezone
        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'deliveryLimitations:Time:Day',
            'comparison'     => '=~',
            'data'           => '1,5,4,6@America/New_York',
            'executionorder' => 1
        );
        $oLimitationDay = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);

        $oDate = new Date('2006-02-05'); // Sunday, but Saturday in GMT-5
        $this->assertFalse($oLimitationDay->deliveryBlocked($oDate));
        $oDate = new Date('2006-02-06'); // Monday, but Sunday in GMT-5
        $this->assertTrue($oLimitationDay->deliveryBlocked($oDate));
        $oDate = new Date('2006-02-07'); // Tuesday, but Monday in GMT-5
        $this->assertFalse($oLimitationDay->deliveryBlocked($oDate));
        $oDate = new Date('2006-02-08'); // Wednesday, but Tuesday in GMT-5
        $this->assertTrue($oLimitationDay->deliveryBlocked($oDate));
        $oDate = new Date('2006-02-09'); // Thursday, but Wednesday in GMT-5
        $this->assertTrue($oLimitationDay->deliveryBlocked($oDate));
        $oDate = new Date('2006-02-10'); // Friday, but Friday in GMT-5
        $this->assertFalse($oLimitationDay->deliveryBlocked($oDate));
        $oDate = new Date('2006-02-11'); // Saturday, but Friday in GMT-5
        $this->assertFalse($oLimitationDay->deliveryBlocked($oDate));

        OA_setTimeZoneLocal();
    }

}

?>
