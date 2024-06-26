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

Language_Loader::load();

/**
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 */
class Test_OA_Maintenance_Priority_DeliveryLimitation_Date extends UnitTestCase
{
    public function setUp()
    {
        // Install the openXDeliveryLog plugin
        TestEnv::uninstallPluginPackage('openXDeliveryLimitations', false);
        TestEnv::installPluginPackage('openXDeliveryLimitations', false);
    }

    public function tearDown()
    {
        // Uninstall the openXDeliveryLog plugin
        TestEnv::uninstallPluginPackage('openXDeliveryLimitations', false);
    }

    /**
     * A method to test the deliveryBlocked() method.
     *
     * Test 1: Test date == delivery requirement
     * Test 2: Test date != delivery requirement
     * Test 3: Test date <= delivery requirement
     * Test 4: Test date >= delivery requirement
     * Test 5: Test date <  delivery requirement
     * Test 6: Test date >  delivery requirement
     * Test 7: Bad input, no date object passed to method
     */
    public function testDeliveryBlocked()
    {
        // Set timezone to UTC
        OA_setTimeZoneUTC();

        $oDate = new Date('2005-04-03');
        $oEarlierDate = new Date('2005-04-02');
        $oLaterDate = new Date('2005-04-04');

        $limitationData = $oDate->format('%Y%m%d@%Z');

        // Test 1
        $aDeliveryLimitation = [
            'ad_id' => 1,
            'logical' => 'and',
            'type' => 'deliveryLimitations:Time:Date',
            'comparison' => '==',
            'data' => $limitationData,
            'executionorder' => 1,
        ];
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        // Test with same date: false, ad is active
        $this->assertFalse($oLimitationDate->deliveryBlocked($oDate));
        // Test with ealier date: true, ad is inactive
        $this->assertTrue($oLimitationDate->deliveryBlocked($oEarlierDate));
        // Test with later date: true, ad is inactive
        $this->assertTrue($oLimitationDate->deliveryBlocked($oLaterDate));

        // Test 2
        $aDeliveryLimitation = [
            'ad_id' => 1,
            'logical' => 'and',
            'type' => 'deliveryLimitations:Time:Date',
            'comparison' => '!=',
            'data' => $limitationData,
            'executionorder' => 1,
        ];
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        // Test with same date: true, ad is inactive
        $this->assertTrue($oLimitationDate->deliveryBlocked($oDate));
        // Test with ealier date: false, ad is active
        $this->assertFalse($oLimitationDate->deliveryBlocked($oEarlierDate));
        // Test with later date: false, ad is active
        $this->assertFalse($oLimitationDate->deliveryBlocked($oLaterDate));

        // Test 3
        $aDeliveryLimitation = [
            'ad_id' => 1,
            'logical' => 'and',
            'type' => 'deliveryLimitations:Time:Date',
            'comparison' => '<=',
            'data' => $limitationData,
            'executionorder' => 1,
        ];
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        // Test with same date: false, ad is active
        $this->assertFalse($oLimitationDate->deliveryBlocked($oDate));
        // Test with ealier date: false, ad is active
        $this->assertFalse($oLimitationDate->deliveryBlocked($oEarlierDate));
        // Test with later date: true, ad is inactive
        $this->assertTrue($oLimitationDate->deliveryBlocked($oLaterDate));

        // Test 4
        $aDeliveryLimitation = [
            'ad_id' => 1,
            'logical' => 'and',
            'type' => 'deliveryLimitations:Time:Date',
            'comparison' => '>=',
            'data' => $limitationData,
            'executionorder' => 1,
        ];
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        // Test with same date: false, ad is active
        $this->assertFalse($oLimitationDate->deliveryBlocked($oDate));
        // Test with ealier date: true, ad is inactive
        $this->assertTrue($oLimitationDate->deliveryBlocked($oEarlierDate));
        // Test with later date: false, ad is active
        $this->assertFalse($oLimitationDate->deliveryBlocked($oLaterDate));

        // Test 5
        $aDeliveryLimitation = [
            'ad_id' => 1,
            'logical' => 'and',
            'type' => 'deliveryLimitations:Time:Date',
            'comparison' => '<',
            'data' => $limitationData,
            'executionorder' => 1,
        ];
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        // Test with same date: true, ad is inactive
        $this->assertTrue($oLimitationDate->deliveryBlocked($oDate));
        // Test with ealier date: false, ad is active
        $this->assertFalse($oLimitationDate->deliveryBlocked($oEarlierDate));
        // Test with later date: true, ad is inactive
        $this->assertTrue($oLimitationDate->deliveryBlocked($oLaterDate));

        // Test 6
        $aDeliveryLimitation = [
            'ad_id' => 1,
            'logical' => 'and',
            'type' => 'deliveryLimitations:Time:Date',
            'comparison' => '>',
            'data' => $limitationData,
            'executionorder' => 1,
        ];
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        // Test with same date: true, ad is inactive
        $this->assertTrue($oLimitationDate->deliveryBlocked($oDate));
        // Test with ealier date: true, ad is inactive
        $this->assertTrue($oLimitationDate->deliveryBlocked($oEarlierDate));
        // Test with later date: false, ad is active
        $this->assertFalse($oLimitationDate->deliveryBlocked($oLaterDate));

        // Test 7
        $aDeliveryLimitation = [
            'ad_id' => 1,
            'logical' => 'and',
            'type' => 'deliveryLimitations:Time:Date',
            'comparison' => '>',
            'data' => $limitationData,
            'executionorder' => 1,
        ];
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        PEAR::pushErrorHandling(null);
        $this->assertTrue(is_a($oLimitationDate->deliveryBlocked('not a date'), 'pear_error'));
        PEAR::popErrorHandling();

        // Test with PST timezone
        $limitationData = $oDate->format('%Y%m%d') . '@America/New_York';
        $aDeliveryLimitation = [
            'ad_id' => 1,
            'logical' => 'and',
            'type' => 'deliveryLimitations:Time:Date',
            'comparison' => '==',
            'data' => $limitationData,
            'executionorder' => 1,
        ];
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        // Test with same date (-1 day, 19pm in EST): true, ad is inactive
        $this->assertTrue($oLimitationDate->deliveryBlocked($oDate));
        // Test with ealier date (-2 days, 19pm in EST): true, ad is inactive
        $this->assertTrue($oLimitationDate->deliveryBlocked($oEarlierDate));
        // Test with later date (-0 days, 19pm in EST): false, ad is active
        $this->assertFalse($oLimitationDate->deliveryBlocked($oLaterDate));

        // Reset timezone
        OA_setTimeZoneLocal();
    }
}
