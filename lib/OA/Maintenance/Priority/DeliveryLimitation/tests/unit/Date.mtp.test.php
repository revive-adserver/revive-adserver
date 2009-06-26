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
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/DeliveryLimitation/Date.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Maintenance_Priority_DeliveryLimitation_Date extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Maintenance_Priority_DeliveryLimitation_Date()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the calculateNonDeliveryDeliveryLimitation() method.
     *
     * Tests all possible valid inputs for the correct response, as well as an invalid input.
     */
    function testCalculateNonDeliveryDeliveryLimitation()
    {
        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'DeliveryLimitations:Time:Date',
            'comparison'     => '==',
            'data'           => '2005-05-05',
            'executionorder' => 1
        );
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertEqual($oLimitationDate->comparison, '!=');

        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'DeliveryLimitations:Time:Date',
            'comparison'     => '!=',
            'data'           => '2005-05-05',
            'executionorder' => 1
        );
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertEqual($oLimitationDate->comparison, '==');

        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'DeliveryLimitations:Time:Date',
            'comparison'     => '<=',
            'data'           => '2005-05-05',
            'executionorder' => 1
        );
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertEqual($oLimitationDate->comparison, '>');

        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'DeliveryLimitations:Time:Date',
            'comparison'     => '>=',
            'data'           => '2005-05-05',
            'executionorder' => 1
        );
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertEqual($oLimitationDate->comparison, '<');

        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'DeliveryLimitations:Time:Date',
            'comparison'     => '<',
            'data'           => '2005-05-05',
            'executionorder' => 1
        );
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertEqual($oLimitationDate->comparison, '>=');

        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'DeliveryLimitations:Time:Date',
            'comparison'     => '>',
            'data'           => '2005-05-05',
            'executionorder' => 1
        );
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        $this->assertEqual($oLimitationDate->comparison, '<=');

        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'DeliveryLimitations:Time:Date',
            'comparison'     => 'hello',
            'data'           => '2005-05-05',
            'executionorder' => 1
        );
        PEAR::pushErrorHandling(null);
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        PEAR::popErrorHandling();
        $this->assertTrue(is_a($oLimitationDate->comparison, 'pear_error'));
    }

    /**
     * A method to test the minutesPerTimePeriod() method.
     */
    function testMinutesPerTimePeriod()
    {
        $this->assertEqual(OA_Maintenance_Priority_DeliveryLimitation_Date::minutesPerTimePeriod(), 1440);
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
    function testDeliveryBlocked()
    {
        $oDate = new Date('2005-04-03');
        $oEarlierDate = new Date('2005-04-02');
        $oLaterDate = new Date('2005-04-04');

        // Test 1
        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'DeliveryLimitations:Time:Date',
            'comparison'     => '==',
            'data'           => $oDate->format('%Y-%m-%d'),
            'executionorder' => 1
        );
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        // Test with same date: false, ad is active
        $this->assertFalse($oLimitationDate->deliveryBlocked($oDate));
        // Test with ealier date: true, ad is inactive
        $this->assertTrue($oLimitationDate->deliveryBlocked($oEarlierDate));
        // Test with later date: true, ad is inactive
        $this->assertTrue($oLimitationDate->deliveryBlocked($oLaterDate));

        // Test 2
        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'DeliveryLimitations:Time:Date',
            'comparison'     => '!=',
            'data'           => $oDate->format('%Y-%m-%d'),
            'executionorder' => 1
        );
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        // Test with same date: true, ad is inactive
        $this->assertTrue($oLimitationDate->deliveryBlocked($oDate));
        // Test with ealier date: false, ad is active
        $this->assertFalse($oLimitationDate->deliveryBlocked($oEarlierDate));
        // Test with later date: false, ad is active
        $this->assertFalse($oLimitationDate->deliveryBlocked($oLaterDate));

        // Test 3
        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'DeliveryLimitations:Time:Date',
            'comparison'     => '<=',
            'data'           => $oDate->format('%Y-%m-%d'),
            'executionorder' => 1
        );
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        // Test with same date: false, ad is active
        $this->assertFalse($oLimitationDate->deliveryBlocked($oDate));
        // Test with ealier date: false, ad is active
        $this->assertFalse($oLimitationDate->deliveryBlocked($oEarlierDate));
        // Test with later date: true, ad is inactive
        $this->assertTrue($oLimitationDate->deliveryBlocked($oLaterDate));

        // Test 4
        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'DeliveryLimitations:Time:Date',
            'comparison'     => '>=',
            'data'           => $oDate->format('%Y-%m-%d'),
            'executionorder' => 1
        );
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        // Test with same date: false, ad is active
        $this->assertFalse($oLimitationDate->deliveryBlocked($oDate));
        // Test with ealier date: true, ad is inactive
        $this->assertTrue($oLimitationDate->deliveryBlocked($oEarlierDate));
        // Test with later date: false, ad is active
        $this->assertFalse($oLimitationDate->deliveryBlocked($oLaterDate));

        // Test 5
        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'DeliveryLimitations:Time:Date',
            'comparison'     => '<',
            'data'           => $oDate->format('%Y-%m-%d'),
            'executionorder' => 1
        );
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        // Test with same date: true, ad is inactive
        $this->assertTrue($oLimitationDate->deliveryBlocked($oDate));
        // Test with ealier date: false, ad is active
        $this->assertFalse($oLimitationDate->deliveryBlocked($oEarlierDate));
        // Test with later date: true, ad is inactive
        $this->assertTrue($oLimitationDate->deliveryBlocked($oLaterDate));

        // Test 6
        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'DeliveryLimitations:Time:Date',
            'comparison'     => '>',
            'data'           => $oDate->format('%Y-%m-%d'),
            'executionorder' => 1
        );
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        // Test with same date: true, ad is inactive
        $this->assertTrue($oLimitationDate->deliveryBlocked($oDate));
        // Test with ealier date: true, ad is inactive
        $this->assertTrue($oLimitationDate->deliveryBlocked($oEarlierDate));
        // Test with later date: false, ad is active
        $this->assertFalse($oLimitationDate->deliveryBlocked($oLaterDate));

        // Test 7
        $aDeliveryLimitation = array(
            'ad_id'          => 1,
            'logical'        => 'and',
            'type'           => 'DeliveryLimitations:Time:Date',
            'comparison'     => '>',
            'data'           => $oDate->format('%Y-%m-%d'),
            'executionorder' => 1
        );
        $oLimitationDate = OA_Maintenance_Priority_DeliveryLimitation_Factory::factory($aDeliveryLimitation);
        PEAR::pushErrorHandling(null);
        $this->assertTrue(is_a($oLimitationDate->deliveryBlocked('not a date'), 'pear_error'));
        PEAR::popErrorHandling();
    }

}

?>
