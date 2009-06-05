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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/PriorityCompensation.php';

/**
 * A class for testing the OA_Maintenance_Priority_AdServer_Task_PriorityCompensation class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Maintenance_Priority_AdServer_Task_PriorityCompensation extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Maintenance_Priority_AdServer_Task_PriorityCompensation()
    {
        $this->UnitTestCase();
        Mock::generate(
            'OA_Dal_Maintenance_Priority',
            $this->mockDal = 'MockOA_Dal_Maintenance_Priority'.rand()
        );
        Mock::generatePartial(
            'OA_Maintenance_Priority_AdServer_Task_PriorityCompensation',
            'PartialMock_OA_Maintenance_Priority_AdServer_Task_PriorityCompensation',
            array('_getDal', '_getOperationIntUtils','_getMaxEntityAdObject')
        );
        Mock::generatePartial(
            'OA_Maintenance_Priority_Ad',
            'PartialOA_Maintenance_Priority_Ad',
            array()
        );
    }

    /**
     * A method to test the _buildClasses method.
     *
     * Requirements
     * Test 1: Test with a selection of ads/zones, and ensure the correct objects
     *         are created.
     */
    function test_buildClasses()
    {
        // Mock the OA_Dal_Maintenance_Priority class used in the constructor method
        $oDal = new $this->mockDal($this);
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);

        // Partially mock the OA_Maintenance_Priority_AdServer_Task_PriorityCompensation class
        $oPriorityCompensation = new PartialMock_OA_Maintenance_Priority_AdServer_Task_PriorityCompensation($this);
        $oPriorityCompensation->setReturnReference('_getDal', $oDal);
        $oPriorityCompensation->setReturnReference('_getOperationIntUtils', $oOperationInterval);
        $oPriorityCompensation->OA_Maintenance_Priority_AdServer_Task();

        // Test 1
        $returnGetAllZonesImpInv = array(
            array(
                'zone_id' => 1,
                'forecast_impressions' => 100,
                'actual_impressions' => 50
            ),
            array(
                'zone_id' => 2,
                'forecast_impressions' => 200,
                'actual_impressions' => 100
            ),
            array(
                'zone_id' => 3,
                'forecast_impressions' => 300,
                'actual_impressions' => 150
            ),
            array(
                'zone_id' => 4,
                'forecast_impressions' => 400,
                'actual_impressions' => 200
            ),
            array(
                'zone_id' => 5,
                'forecast_impressions' => 500,
                'actual_impressions' => 250
            )
        );
        $oDal->setReturnReference('getAllZonesImpInv', $returnGetAllZonesImpInv);
        $oDal->expectOnce('getAllZonesImpInv');
        $returnGetAllDeliveryLimitationChangedCreatives = array(
            1 => '0000-00-00 00:00:00',
            2 => '2006-04-27 12:00:05'
        );
        $oDal->setReturnReference('getAllDeliveryLimitationChangedCreatives', $returnGetAllDeliveryLimitationChangedCreatives);
        $oDal->expectOnce('getAllDeliveryLimitationChangedCreatives');
        $returnGetAllZonesWithAllocInv = array(
            array(
                'zone_id' => 1,
                'ad_id' => 1,
                'required_impressions' => 1,
                'requested_impressions' => 1
            ),
            array(
                'zone_id' => 2,
                'ad_id' => 1,
                'required_impressions' => 2,
                'requested_impressions' => 2
            ),
            array(
                'zone_id' => 3,
                'ad_id' => 1,
                'required_impressions' => 3,
                'requested_impressions' => 3
            ),
            array(
                'zone_id' => 4,
                'ad_id' => 1,
                'required_impressions' => 4,
                'requested_impressions' => 4
            ),
            array(
                'zone_id' => 5,
                'ad_id' => 1,
                'required_impressions' => 5,
                'requested_impressions' => 5
            ),
            array(
                'zone_id' => 1,
                'ad_id' => 2,
                'required_impressions' => 21,
                'requested_impressions' => 21
            ),
            array(
                'zone_id' => 2,
                'ad_id' => 2,
                'required_impressions' => 22,
                'requested_impressions' => 22
            ),
            array(
                'zone_id' => 3,
                'ad_id' => 2,
                'required_impressions' => 23,
                'requested_impressions' => 23
            ),
            array(
                'zone_id' => 4,
                'ad_id' => 2,
                'required_impressions' => 24,
                'requested_impressions' => 24
            ),
            array(
                'zone_id' => 5,
                'ad_id' => 2,
                'required_impressions' => 25,
                'requested_impressions' => 25
            ),
            array(
                'zone_id' => 3,
                'ad_id' => 3,
                'required_impressions' => 33,
                'requested_impressions' => 33
            )
        );
        $oDal->setReturnReference('getAllZonesWithAllocInv', $returnGetAllZonesWithAllocInv);
        $oDal->expectOnce('getAllZonesWithAllocInv');
        $returnGetPreviousAdDeliveryInfo = array(
            1 => array(
                1 => array(
                    'ad_id' => 1,
                    'zone_id' => 1,
                    'required_impressions' => 5,
                    'requested_impressions' => 5,
                    'priority_factor' => 0.5,
                    'past_zone_traffic_fraction' => 0.1,
                    'impressions' => 10)
                )
            );
        $oDal->setReturnReference('getPreviousAdDeliveryInfo', $returnGetPreviousAdDeliveryInfo);
        $oDal->expectOnce('getPreviousAdDeliveryInfo');

        $oPriorityCompensation->expectCallCount('_getMaxEntityAdObject', 11);
        for ($i=0;$i<5;$i++)
        {
            $oAdObject = new PartialOA_Maintenance_Priority_Ad($this);
            $oAdObject->OA_Maintenance_Priority_Ad(array('ad_id' => 1));
            //$oAdObject->setReturnValue('isActiveHighPriority', true);
            $oPriorityCompensation->setReturnValueAt($i, '_getMaxEntityAdObject', $oAdObject);
        }
        for ($i=5;$i<10;$i++)
        {
            $oAdObject = new PartialOA_Maintenance_Priority_Ad($this);
            $oAdObject->OA_Maintenance_Priority_Ad(array('ad_id' => 2));
            //$oAdObject->setReturnValue('isActiveHighPriority', true);
            $oPriorityCompensation->setReturnValueAt($i, '_getMaxEntityAdObject', $oAdObject);
        }
        $oAdObject = new PartialOA_Maintenance_Priority_Ad($this);
        $oAdObject->OA_Maintenance_Priority_Ad(array('ad_id' => 3));
        //$oAdObject->setReturnValue('isActiveHighPriority', true);
        $oPriorityCompensation->setReturnValueAt(10, '_getMaxEntityAdObject', $oAdObject);

        $aZones = $oPriorityCompensation->_buildClasses();
        $oDal->tally();
        $oPriorityCompensation->tally();

        $this->assertEqual(strtolower(get_class($aZones[1])), strtolower('OX_Maintenance_Priority_Zone'));
        $oZone = $aZones[1];
        $this->assertEqual($oZone->id, 1);
        $this->assertEqual($oZone->availableImpressions, 100);
        $this->assertEqual($oZone->pastActualImpressions, 50);
        $this->assertEqual(count($oZone->aAdverts), 2);
        $oAd = $oZone->aAdverts[1];
        $this->assertEqual($oAd->id, 1);
        $this->assertEqual($oAd->requiredImpressions, 1);
        $this->assertEqual($oAd->requestedImpressions, 1);
        $this->assertEqual($oAd->pastRequiredImpressions, 5);
        $this->assertEqual($oAd->pastRequestedImpressions, 5);
        $this->assertEqual($oAd->pastActualImpressions, 10);
        $this->assertEqual($oAd->pastAdZonePriorityFactor, 0.5);
        $this->assertEqual($oAd->pastZoneTrafficFraction, 0.1);
        $this->assertNull($oAd->deliveryLimitationChanged);
        $oAd = $oZone->aAdverts[2];
        $this->assertEqual($oAd->id, 2);
        $this->assertEqual($oAd->requiredImpressions, 21);
        $this->assertEqual($oAd->requestedImpressions, 21);
        $this->assertNull($oAd->pastRequiredImpressions);
        $this->assertNull($oAd->pastRequestedImpressions);
        $this->assertNull($oAd->pastActualImpressions);
        $this->assertNull($oAd->pastAdZonePriorityFactor);
        $this->assertNull($oAd->pastZoneTrafficFraction);
        $this->assertTrue($oAd->deliveryLimitationChanged);

        $this->assertEqual(strtolower(get_class($aZones[2])), strtolower('OX_Maintenance_Priority_Zone'));
        $oZone = $aZones[2];
        $this->assertEqual($oZone->id, 2);
        $this->assertEqual($oZone->availableImpressions, 200);
        $this->assertEqual($oZone->pastActualImpressions, 100);
        $this->assertEqual(count($oZone->aAdverts), 2);
        $oAd = $oZone->aAdverts[1];
        $this->assertEqual($oAd->id, 1);
        $this->assertEqual($oAd->requiredImpressions, 2);
        $this->assertEqual($oAd->requestedImpressions, 2);
        $this->assertNull($oAd->pastRequiredImpressions);
        $this->assertNull($oAd->pastRequestedImpressions);
        $this->assertNull($oAd->pastActualImpressions);
        $this->assertNull($oAd->pastAdZonePriorityFactor);
        $this->assertNull($oAd->pastZoneTrafficFraction);
        $this->assertNull($oAd->deliveryLimitationChanged);
        $oAd = $oZone->aAdverts[2];
        $this->assertEqual($oAd->id, 2);
        $this->assertEqual($oAd->requiredImpressions, 22);
        $this->assertEqual($oAd->requestedImpressions, 22);
        $this->assertNull($oAd->pastRequiredImpressions);
        $this->assertNull($oAd->pastRequestedImpressions);
        $this->assertNull($oAd->pastActualImpressions);
        $this->assertNull($oAd->pastAdZonePriorityFactor);
        $this->assertNull($oAd->pastZoneTrafficFraction);
        $this->assertTrue($oAd->deliveryLimitationChanged);

        $this->assertEqual(strtolower(get_class($aZones[3])), strtolower('OX_Maintenance_Priority_Zone'));
        $oZone = $aZones[3];
        $this->assertEqual($oZone->id, 3);
        $this->assertEqual($oZone->availableImpressions, 300);
        $this->assertEqual($oZone->pastActualImpressions, 150);
        $this->assertEqual(count($oZone->aAdverts), 3);
        $oAd = $oZone->aAdverts[1];
        $this->assertEqual($oAd->id, 1);
        $this->assertEqual($oAd->requiredImpressions, 3);
        $this->assertEqual($oAd->requestedImpressions, 3);
        $this->assertNull($oAd->pastRequiredImpressions);
        $this->assertNull($oAd->pastRequestedImpressions);
        $this->assertNull($oAd->pastActualImpressions);
        $this->assertNull($oAd->pastAdZonePriorityFactor);
        $this->assertNull($oAd->pastZoneTrafficFraction);
        $this->assertNull($oAd->deliveryLimitationChanged);
        $oAd = $oZone->aAdverts[2];
        $this->assertEqual($oAd->id, 2);
        $this->assertEqual($oAd->requiredImpressions, 23);
        $this->assertEqual($oAd->requestedImpressions, 23);
        $this->assertNull($oAd->pastRequiredImpressions);
        $this->assertNull($oAd->pastRequestedImpressions);
        $this->assertNull($oAd->pastActualImpressions);
        $this->assertNull($oAd->pastAdZonePriorityFactor);
        $this->assertNull($oAd->pastZoneTrafficFraction);
        $this->assertTrue($oAd->deliveryLimitationChanged);
        $oAd = $oZone->aAdverts[3];
        $this->assertEqual($oAd->id, 3);
        $this->assertEqual($oAd->requiredImpressions, 33);
        $this->assertEqual($oAd->requestedImpressions, 33);
        $this->assertNull($oAd->pastRequiredImpressions);
        $this->assertNull($oAd->pastRequestedImpressions);
        $this->assertNull($oAd->pastActualImpressions);
        $this->assertNull($oAd->pastAdZonePriorityFactor);
        $this->assertNull($oAd->pastZoneTrafficFraction);
        $this->assertNull($oAd->deliveryLimitationChanged);

        $this->assertEqual(strtolower(get_class($aZones[4])), strtolower('OX_Maintenance_Priority_Zone'));
        $oZone = $aZones[4];
        $this->assertEqual($oZone->id, 4);
        $this->assertEqual($oZone->availableImpressions, 400);
        $this->assertEqual($oZone->pastActualImpressions, 200);
        $this->assertEqual(count($oZone->aAdverts), 2);
        $oAd = $oZone->aAdverts[1];
        $this->assertEqual($oAd->id, 1);
        $this->assertEqual($oAd->requiredImpressions, 4);
        $this->assertEqual($oAd->requestedImpressions, 4);
        $this->assertNull($oAd->pastRequiredImpressions);
        $this->assertNull($oAd->pastRequestedImpressions);
        $this->assertNull($oAd->pastActualImpressions);
        $this->assertNull($oAd->pastAdZonePriorityFactor);
        $this->assertNull($oAd->pastZoneTrafficFraction);
        $this->assertNull($oAd->deliveryLimitationChanged);
        $oAd = $oZone->aAdverts[2];
        $this->assertEqual($oAd->id, 2);
        $this->assertEqual($oAd->requiredImpressions, 24);
        $this->assertEqual($oAd->requestedImpressions, 24);
        $this->assertNull($oAd->pastRequiredImpressions);
        $this->assertNull($oAd->pastRequestedImpressions);
        $this->assertNull($oAd->pastActualImpressions);
        $this->assertNull($oAd->pastAdZonePriorityFactor);
        $this->assertNull($oAd->pastZoneTrafficFraction);
        $this->assertTrue($oAd->deliveryLimitationChanged);

        $this->assertEqual(strtolower(get_class($aZones[5])), strtolower('OX_Maintenance_Priority_Zone'));
        $oZone = $aZones[5];
        $this->assertEqual($oZone->id, 5);
        $this->assertEqual($oZone->availableImpressions, 500);
        $this->assertEqual($oZone->pastActualImpressions, 250);
        $this->assertEqual(count($oZone->aAdverts), 2);
        $oAd = $oZone->aAdverts[1];
        $this->assertEqual($oAd->id, 1);
        $this->assertEqual($oAd->requiredImpressions, 5);
        $this->assertEqual($oAd->requestedImpressions, 5);
        $this->assertNull($oAd->pastRequiredImpressions);
        $this->assertNull($oAd->pastRequestedImpressions);
        $this->assertNull($oAd->pastActualImpressions);
        $this->assertNull($oAd->pastAdZonePriorityFactor);
        $this->assertNull($oAd->pastZoneTrafficFraction);
        $this->assertNull($oAd->deliveryLimitationChanged);
        $oAd = $oZone->aAdverts[2];
        $this->assertEqual($oAd->id, 2);
        $this->assertEqual($oAd->requiredImpressions, 25);
        $this->assertEqual($oAd->requestedImpressions, 25);
        $this->assertNull($oAd->pastRequiredImpressions);
        $this->assertNull($oAd->pastRequestedImpressions);
        $this->assertNull($oAd->pastActualImpressions);
        $this->assertNull($oAd->pastAdZonePriorityFactor);
        $this->assertNull($oAd->pastZoneTrafficFraction);
        $this->assertTrue($oAd->deliveryLimitationChanged);
    }

    /**
     * A method to test the scalePriorities() method.
     *
     * Requirements
     * Test 1: Test with all zero values, ensure initial all zero values returned.
     * Test 2: Test with zero advertisement values, positive blank value, ensure
     *         all zero values returned for advertisements, 1 for blank.
     * Test 3: Test with a mix of values, and ensure they are correctly scaled.
     */
    function testScalePriorities()
    {
        // Mock the OA_Dal_Maintenance_Priority class used in the constructor method
        $oDal = new $this->mockDal($this);
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);

        // Partially mock the OA_Maintenance_Priority_AdServer_Task_PriorityCompensation class
        $oPriorityCompensation = new PartialMock_OA_Maintenance_Priority_AdServer_Task_PriorityCompensation($this);
        $oPriorityCompensation->setReturnReference('_getDal', $oDal);
        $oPriorityCompensation->setReturnReference('_getOperationIntUtils', $oOperationInterval);
        $oPriorityCompensation->OA_Maintenance_Priority_AdServer_Task();

        // Test 1
        $aData = array(
            'ads' => array(
                0 => array('priority' => 0),
                1 => array('priority' => 0),
                2 => array('priority' => 0),
                9 => array('priority' => 0)
            ),
            'blank' => 0
        );
        $oPriorityCompensation->scalePriorities($aData);
        $this->assertEqual($aData['ads'][0]['priority'], 0);
        $this->assertEqual($aData['ads'][1]['priority'], 0);
        $this->assertEqual($aData['ads'][2]['priority'], 0);
        $this->assertEqual($aData['ads'][9]['priority'], 0);
        $this->assertEqual($aData['blank'], 0);

        // Test 2
        $aData = array(
            'ads' => array(
                0 => array('priority' => 0),
                1 => array('priority' => 0),
                2 => array('priority' => 0),
                9 => array('priority' => 0)
            ),
            'blank' => 37
        );
        $oPriorityCompensation->scalePriorities($aData);
        $this->assertEqual($aData['ads'][0]['priority'], 0);
        $this->assertEqual($aData['ads'][1]['priority'], 0);
        $this->assertEqual($aData['ads'][2]['priority'], 0);
        $this->assertEqual($aData['ads'][9]['priority'], 0);
        $this->assertEqual($aData['blank'], 1);

        // Test 3
        $aData = array(
            'ads' => array(
                0 => array('priority' => 10),
                1 => array('priority' => 20),
                2 => array('priority' => 30),
                9 => array('priority' => 40)
            ),
            'blank' => 0
        );
        $oPriorityCompensation->scalePriorities($aData);
        $this->assertEqual($aData['ads'][0]['priority'], 0.1);
        $this->assertEqual($aData['ads'][1]['priority'], 0.2);
        $this->assertEqual($aData['ads'][2]['priority'], 0.3);
        $this->assertEqual($aData['ads'][9]['priority'], 0.4);
        $this->assertEqual($aData['blank'], 0);
        $aData = array(
            'ads' => array(
                0 => array('priority' =>  5),
                1 => array('priority' => 20),
                2 => array('priority' => 30),
                9 => array('priority' => 40)
            ),
            'blank' => 5
        );
        $oPriorityCompensation->scalePriorities($aData);
        $this->assertEqual($aData['ads'][0]['priority'], 0.05);
        $this->assertEqual($aData['ads'][1]['priority'], 0.2);
        $this->assertEqual($aData['ads'][2]['priority'], 0.3);
        $this->assertEqual($aData['ads'][9]['priority'], 0.4);
        $this->assertEqual($aData['blank'], 0.05);
    }

    /**
     * A method to test the initialPriorities() method.
     *
     * Requirements
     * Test 1: Test with a zone of zero available impressions, and no linked ads, and
     *         ensure the returned ads array is empty, and the initial blank impression
     *         is one.
     * Test 2: Test with a zone of > zero available impressions, and no linked ads, and
     *         ensure the returned ads array is empty, and the initial blank impression
     *         is one.
     * Test 3: Test with a zone of zero available impressions, and linked ads with zero
     *         required impressions, and ensure the returned ads array has zero for all
     *         ad priorities, and the initial blank impression is one.
     * Test 4: Test with a zone of > zero available impressions, and linked ads with zero
     *         required impressions, and ensure the returned ads array has zero for all
     *         ad priorities, and the initial blank impression is one.
     * Test 5: Test with a zone of zero available impressions, and linked ads with > zero
     *         required impressions, and ensure the returned ads array has zero for all
     *         ad priorities, and the initial blank impression is one.
     * Test 6: Test with a zone of > zero available impressions, and linked ads with > zero
     *         required impressions, and ensure the returned priorities are correctly
     *         calculcated and scaled.
     */
    function testInitialPriorities()
    {
        // Mock the OA_Dal_Maintenance_Priority class used in the constructor method
        $oDal = new $this->mockDal($this);
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);

        // Partially mock the OA_Maintenance_Priority_AdServer_Task_PriorityCompensation class
        $oPriorityCompensation = new PartialMock_OA_Maintenance_Priority_AdServer_Task_PriorityCompensation($this);
        $oPriorityCompensation->setReturnReference('_getDal', $oDal);
        $oPriorityCompensation->setReturnReference('_getOperationIntUtils', $oOperationInterval);
        $oPriorityCompensation->OA_Maintenance_Priority_AdServer_Task();

        // Test 1
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 0;
        $result = $oPriorityCompensation->initialPriorities($oZone);
        $this->assertEqual(count($result['ads']), 0);
        $this->assertEqual($result['blank'], 1);

        // Test 2
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 100;
        $result = $oPriorityCompensation->initialPriorities($oZone);
        $this->assertEqual(count($result['ads']), 0);
        $this->assertEqual($result['blank'], 1);

        // Test 3
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 0;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 2));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 3));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 9));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oZone->addAdvert($oAd);
        $result = $oPriorityCompensation->initialPriorities($oZone);
        $this->assertEqual(count($result['ads']), 4);
        $this->assertEqual($result['ads'][1]['ad_id'], 1);
        $this->assertEqual($result['ads'][1]['zone_id'], 1);
        $this->assertEqual($result['ads'][1]['priority'], 0);
        $this->assertEqual($result['ads'][1]['required_impressions'], 0);
        $this->assertEqual($result['ads'][1]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][1]['priority_factor'], 1);
        $this->assertFalse($result['ads'][1]['priority_factor_limited']);
        $this->assertNull($result['ads'][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][2]['ad_id'], 2);
        $this->assertEqual($result['ads'][2]['zone_id'], 1);
        $this->assertEqual($result['ads'][2]['priority'], 0);
        $this->assertEqual($result['ads'][2]['required_impressions'], 0);
        $this->assertEqual($result['ads'][2]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][2]['priority_factor'], 1);
        $this->assertFalse($result['ads'][2]['priority_factor_limited']);
        $this->assertNull($result['ads'][2]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][3]['ad_id'], 3);
        $this->assertEqual($result['ads'][3]['zone_id'], 1);
        $this->assertEqual($result['ads'][3]['priority'], 0);
        $this->assertEqual($result['ads'][3]['required_impressions'], 0);
        $this->assertEqual($result['ads'][3]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][3]['priority_factor'], 1);
        $this->assertFalse($result['ads'][3]['priority_factor_limited']);
        $this->assertNull($result['ads'][3]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][9]['ad_id'], 9);
        $this->assertEqual($result['ads'][9]['zone_id'], 1);
        $this->assertEqual($result['ads'][9]['priority'], 0);
        $this->assertEqual($result['ads'][9]['required_impressions'], 0);
        $this->assertEqual($result['ads'][9]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][9]['priority_factor'], 1);
        $this->assertFalse($result['ads'][9]['priority_factor_limited']);
        $this->assertNull($result['ads'][9]['past_zone_traffic_fraction']);
        $this->assertEqual($result['blank'], 1);

        // Test 4
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 100;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 2));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 3));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 9));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oZone->addAdvert($oAd);
        $result = $oPriorityCompensation->initialPriorities($oZone);
        $this->assertEqual(count($result['ads']), 4);
        $this->assertEqual($result['ads'][1]['ad_id'], 1);
        $this->assertEqual($result['ads'][1]['zone_id'], 1);
        $this->assertEqual($result['ads'][1]['priority'], 0);
        $this->assertEqual($result['ads'][1]['required_impressions'], 0);
        $this->assertEqual($result['ads'][1]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][1]['priority_factor'], 1);
        $this->assertFalse($result['ads'][1]['priority_factor_limited']);
        $this->assertNull($result['ads'][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][2]['ad_id'], 2);
        $this->assertEqual($result['ads'][2]['zone_id'], 1);
        $this->assertEqual($result['ads'][2]['priority'], 0);
        $this->assertEqual($result['ads'][2]['required_impressions'], 0);
        $this->assertEqual($result['ads'][2]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][2]['priority_factor'], 1);
        $this->assertFalse($result['ads'][2]['priority_factor_limited']);
        $this->assertNull($result['ads'][2]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][3]['ad_id'], 3);
        $this->assertEqual($result['ads'][3]['zone_id'], 1);
        $this->assertEqual($result['ads'][3]['priority'], 0);
        $this->assertEqual($result['ads'][3]['required_impressions'], 0);
        $this->assertEqual($result['ads'][3]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][3]['priority_factor'], 1);
        $this->assertFalse($result['ads'][3]['priority_factor_limited']);
        $this->assertNull($result['ads'][3]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][9]['ad_id'], 9);
        $this->assertEqual($result['ads'][9]['zone_id'], 1);
        $this->assertEqual($result['ads'][9]['priority'], 0);
        $this->assertEqual($result['ads'][9]['required_impressions'], 0);
        $this->assertEqual($result['ads'][9]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][9]['priority_factor'], 1);
        $this->assertFalse($result['ads'][9]['priority_factor_limited']);
        $this->assertNull($result['ads'][9]['past_zone_traffic_fraction']);
        $this->assertEqual($result['blank'], 1);

        // Test 5
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 0;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1));
        $oAd->requiredImpressions = 10;
        $oAd->requestedImpressions = 10;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 2));
        $oAd->requiredImpressions = 20;
        $oAd->requestedImpressions = 20;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 3));
        $oAd->requiredImpressions = 30;
        $oAd->requestedImpressions = 30;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 9));
        $oAd->requiredImpressions = 40;
        $oAd->requestedImpressions = 40;
        $oZone->addAdvert($oAd);
        $result = $oPriorityCompensation->initialPriorities($oZone);
        $this->assertEqual(count($result['ads']), 4);
        $this->assertEqual($result['ads'][1]['ad_id'], 1);
        $this->assertEqual($result['ads'][1]['zone_id'], 1);
        $this->assertEqual($result['ads'][1]['priority'], 0);
        $this->assertEqual($result['ads'][1]['required_impressions'], 10);
        $this->assertEqual($result['ads'][1]['requested_impressions'], 10);
        $this->assertEqual($result['ads'][1]['priority_factor'], 1);
        $this->assertFalse($result['ads'][1]['priority_factor_limited']);
        $this->assertNull($result['ads'][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][2]['ad_id'], 2);
        $this->assertEqual($result['ads'][2]['zone_id'], 1);
        $this->assertEqual($result['ads'][2]['priority'], 0);
        $this->assertEqual($result['ads'][2]['required_impressions'], 20);
        $this->assertEqual($result['ads'][2]['requested_impressions'], 20);
        $this->assertEqual($result['ads'][2]['priority_factor'], 1);
        $this->assertFalse($result['ads'][2]['priority_factor_limited']);
        $this->assertNull($result['ads'][2]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][3]['ad_id'], 3);
        $this->assertEqual($result['ads'][3]['zone_id'], 1);
        $this->assertEqual($result['ads'][3]['priority'], 0);
        $this->assertEqual($result['ads'][3]['required_impressions'], 30);
        $this->assertEqual($result['ads'][3]['requested_impressions'], 30);
        $this->assertEqual($result['ads'][3]['priority_factor'], 1);
        $this->assertFalse($result['ads'][3]['priority_factor_limited']);
        $this->assertNull($result['ads'][3]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][9]['ad_id'], 9);
        $this->assertEqual($result['ads'][9]['zone_id'], 1);
        $this->assertEqual($result['ads'][9]['priority'], 0);
        $this->assertEqual($result['ads'][9]['required_impressions'], 40);
        $this->assertEqual($result['ads'][9]['requested_impressions'], 40);
        $this->assertEqual($result['ads'][9]['priority_factor'], 1);
        $this->assertFalse($result['ads'][9]['priority_factor_limited']);
        $this->assertNull($result['ads'][9]['past_zone_traffic_fraction']);
        $this->assertEqual($result['blank'], 1);

        // Test 6
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 100;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1));
        $oAd->requiredImpressions = 10;
        $oAd->requestedImpressions = 10;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 2));
        $oAd->requiredImpressions = 20;
        $oAd->requestedImpressions = 20;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 3));
        $oAd->requiredImpressions = 30;
        $oAd->requestedImpressions = 30;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 9));
        $oAd->requiredImpressions = 40;
        $oAd->requestedImpressions = 40;
        $oZone->addAdvert($oAd);
        $result = $oPriorityCompensation->initialPriorities($oZone);
        $this->assertEqual(count($result['ads']), 4);
        $this->assertEqual($result['ads'][1]['ad_id'], 1);
        $this->assertEqual($result['ads'][1]['zone_id'], 1);
        $this->assertEqual($result['ads'][1]['priority'], 0.1);
        $this->assertEqual($result['ads'][1]['required_impressions'], 10);
        $this->assertEqual($result['ads'][1]['requested_impressions'], 10);
        $this->assertEqual($result['ads'][1]['priority_factor'], 1);
        $this->assertFalse($result['ads'][1]['priority_factor_limited']);
        $this->assertNull($result['ads'][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][2]['ad_id'], 2);
        $this->assertEqual($result['ads'][2]['zone_id'], 1);
        $this->assertEqual($result['ads'][2]['priority'], 0.2);
        $this->assertEqual($result['ads'][2]['required_impressions'], 20);
        $this->assertEqual($result['ads'][2]['requested_impressions'], 20);
        $this->assertEqual($result['ads'][2]['priority_factor'], 1);
        $this->assertFalse($result['ads'][2]['priority_factor_limited']);
        $this->assertNull($result['ads'][2]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][3]['ad_id'], 3);
        $this->assertEqual($result['ads'][3]['zone_id'], 1);
        $this->assertEqual($result['ads'][3]['priority'], 0.3);
        $this->assertEqual($result['ads'][3]['required_impressions'], 30);
        $this->assertEqual($result['ads'][3]['requested_impressions'], 30);
        $this->assertEqual($result['ads'][3]['priority_factor'], 1);
        $this->assertFalse($result['ads'][3]['priority_factor_limited']);
        $this->assertNull($result['ads'][3]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][9]['ad_id'], 9);
        $this->assertEqual($result['ads'][9]['zone_id'], 1);
        $this->assertEqual($result['ads'][9]['priority'], 0.4);
        $this->assertEqual($result['ads'][9]['required_impressions'], 40);
        $this->assertEqual($result['ads'][9]['requested_impressions'], 40);
        $this->assertEqual($result['ads'][9]['priority_factor'], 1);
        $this->assertFalse($result['ads'][9]['priority_factor_limited']);
        $this->assertNull($result['ads'][9]['past_zone_traffic_fraction']);
        $this->assertEqual($result['blank'], 0);

        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 200;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1));
        $oAd->requiredImpressions = 10;
        $oAd->requestedImpressions = 10;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 2));
        $oAd->requiredImpressions = 20;
        $oAd->requestedImpressions = 20;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 3));
        $oAd->requiredImpressions = 30;
        $oAd->requestedImpressions = 30;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 9));
        $oAd->requiredImpressions = 40;
        $oAd->requestedImpressions = 40;
        $oZone->addAdvert($oAd);
        $result = $oPriorityCompensation->initialPriorities($oZone);
        $this->assertEqual(count($result['ads']), 4);
        $this->assertEqual($result['ads'][1]['ad_id'], 1);
        $this->assertEqual($result['ads'][1]['zone_id'], 1);
        $this->assertEqual($result['ads'][1]['priority'], 0.05);
        $this->assertEqual($result['ads'][1]['required_impressions'], 10);
        $this->assertEqual($result['ads'][1]['requested_impressions'], 10);
        $this->assertEqual($result['ads'][1]['priority_factor'], 1);
        $this->assertFalse($result['ads'][1]['priority_factor_limited']);
        $this->assertNull($result['ads'][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][2]['ad_id'], 2);
        $this->assertEqual($result['ads'][2]['zone_id'], 1);
        $this->assertEqual($result['ads'][2]['priority'], 0.1);
        $this->assertEqual($result['ads'][2]['required_impressions'], 20);
        $this->assertEqual($result['ads'][2]['requested_impressions'], 20);
        $this->assertEqual($result['ads'][2]['priority_factor'], 1);
        $this->assertFalse($result['ads'][2]['priority_factor_limited']);
        $this->assertNull($result['ads'][2]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][3]['ad_id'], 3);
        $this->assertEqual($result['ads'][3]['zone_id'], 1);
        $this->assertEqual($result['ads'][3]['priority'], 0.15);
        $this->assertEqual($result['ads'][3]['required_impressions'], 30);
        $this->assertEqual($result['ads'][3]['requested_impressions'], 30);
        $this->assertEqual($result['ads'][3]['priority_factor'], 1);
        $this->assertFalse($result['ads'][3]['priority_factor_limited']);
        $this->assertNull($result['ads'][3]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][9]['ad_id'], 9);
        $this->assertEqual($result['ads'][9]['zone_id'], 1);
        $this->assertEqual($result['ads'][9]['priority'], 0.2);
        $this->assertEqual($result['ads'][9]['required_impressions'], 40);
        $this->assertEqual($result['ads'][9]['requested_impressions'], 40);
        $this->assertEqual($result['ads'][9]['priority_factor'], 1);
        $this->assertFalse($result['ads'][9]['priority_factor_limited']);
        $this->assertNull($result['ads'][9]['past_zone_traffic_fraction']);
        $this->assertEqual($result['blank'], 0.5);
    }

    /**
     * A method to test the compensatedPriorities() method.
     *
     * Requirements - NO PAST AD INFO
     * Test 1: Test with a zone of zero available impressions, and no linked ads, and
     *         ensure the returned ads array is empty, and the initial blank impression
     *         is one.
     * Test 2: Test with a zone of > zero available impressions, and no linked ads, and
     *         ensure the returned ads array is empty, and the initial blank impression
     *         is one.
     * Test 3: Test with a zone of zero available impressions, and linked ads with zero
     *         required impressions, and ensure the returned ads array has zero for all
     *         ad priorities, and the initial blank impression is one.
     * Test 4: Test with a zone of > zero available impressions, and linked ads with zero
     *         required impressions, and ensure the returned ads array has zero for all
     *         ad priorities, and the initial blank impression is one.
     * Test 5: Test with a zone of zero available impressions, and linked ads with > zero
     *         required impressions, and ensure the returned ads array has zero for all
     *         ad priorities, and the initial blank impression is one.
     * Test 6: Test with a zone of > zero available impressions, and linked ads with > zero
     *         required impressions, and ensure the returned priorities are correctly
     *         calculcated and scaled.
     *
     * Requirements - WITH PAST AD INFO
     * Test 7: Test with a zone of zero available impressions, and linked ads with zero
     *         required impressions, and ensure the returned ads array has zero for all
     *         ad priorities, and the initial blank impression is one.
     * Test 8: Test with a zone of > zero available impressions, and linked ads with zero
     *         required impressions, and ensure the returned ads array has zero for all
     *         ad priorities, and the initial blank impression is one.
     * Test 9: Test with a zone of zero available impressions, and linked ads with > zero
     *         required impressions, and ensure the returned ads array has zero for all
     *         ad priorities, and the initial blank impression is one.
     * Test 10: Test with a zone of > zero available impressions, and linked ads with > zero
     *          required impressions, but no past zone information, and ensure the returned
     *          priorities are correctly calculcated and scaled.
     * Test 11: Test with a zone of > zero available impressions, and linked ads with > zero
     *          required impressions, with past zone information, and ensure the returned
     *          priorities are correctly calculcated and scaled.
     * Test 12: Test with a factor that will be limited.
     * Test 13: Test with a factor that would be limited, but with deliveryLimitationChanged
     *          set and ensure that the priority factor is reset
     */
    function testCompensatedPriorities()
    {
        // Mock the OA_Dal_Maintenance_Priority class used in the constructor method
        $oDal = new $this->mockDal($this);
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);

        // Partially mock the OA_Maintenance_Priority_AdServer_Task_PriorityCompensation class
        $oPriorityCompensation = new PartialMock_OA_Maintenance_Priority_AdServer_Task_PriorityCompensation($this);
        $oPriorityCompensation->setReturnReference('_getDal', $oDal);
        $oPriorityCompensation->setReturnReference('_getOperationIntUtils', $oOperationInterval);
        $oPriorityCompensation->OA_Maintenance_Priority_AdServer_Task();

        // Test 1
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 0;
        $result = $oPriorityCompensation->compensatedPriorities($oZone);
        $this->assertEqual(count($result['ads']), 0);
        $this->assertEqual($result['blank'], 1);

        // Test 2
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 100;
        $result = $oPriorityCompensation->compensatedPriorities($oZone);
        $this->assertEqual(count($result['ads']), 0);
        $this->assertEqual($result['blank'], 1);

        // Test 3
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 0;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 2));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 3));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 9));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oZone->addAdvert($oAd);
        $result = $oPriorityCompensation->compensatedPriorities($oZone);
        $this->assertEqual(count($result['ads']), 4);
        $this->assertEqual($result['ads'][1]['ad_id'], 1);
        $this->assertEqual($result['ads'][1]['zone_id'], 1);
        $this->assertEqual($result['ads'][1]['priority'], 0);
        $this->assertEqual($result['ads'][1]['required_impressions'], 0);
        $this->assertEqual($result['ads'][1]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][1]['priority_factor'], 1);
        $this->assertFalse($result['ads'][1]['priority_factor_limited']);
        $this->assertNull($result['ads'][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][2]['ad_id'], 2);
        $this->assertEqual($result['ads'][2]['zone_id'], 1);
        $this->assertEqual($result['ads'][2]['priority'], 0);
        $this->assertEqual($result['ads'][2]['required_impressions'], 0);
        $this->assertEqual($result['ads'][2]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][2]['priority_factor'], 1);
        $this->assertFalse($result['ads'][2]['priority_factor_limited']);
        $this->assertNull($result['ads'][2]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][3]['ad_id'], 3);
        $this->assertEqual($result['ads'][3]['zone_id'], 1);
        $this->assertEqual($result['ads'][3]['priority'], 0);
        $this->assertEqual($result['ads'][3]['required_impressions'], 0);
        $this->assertEqual($result['ads'][3]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][3]['priority_factor'], 1);
        $this->assertFalse($result['ads'][3]['priority_factor_limited']);
        $this->assertNull($result['ads'][3]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][9]['ad_id'], 9);
        $this->assertEqual($result['ads'][9]['zone_id'], 1);
        $this->assertEqual($result['ads'][9]['priority'], 0);
        $this->assertEqual($result['ads'][9]['required_impressions'], 0);
        $this->assertEqual($result['ads'][9]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][9]['priority_factor'], 1);
        $this->assertFalse($result['ads'][9]['priority_factor_limited']);
        $this->assertNull($result['ads'][9]['past_zone_traffic_fraction']);
        $this->assertEqual($result['blank'], 1);

        // Test 4
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 100;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 2));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 3));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 9));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oZone->addAdvert($oAd);
        $result = $oPriorityCompensation->compensatedPriorities($oZone);
        $this->assertEqual(count($result['ads']), 4);
        $this->assertEqual($result['ads'][1]['ad_id'], 1);
        $this->assertEqual($result['ads'][1]['zone_id'], 1);
        $this->assertEqual($result['ads'][1]['priority'], 0);
        $this->assertEqual($result['ads'][1]['required_impressions'], 0);
        $this->assertEqual($result['ads'][1]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][1]['priority_factor'], 1);
        $this->assertFalse($result['ads'][1]['priority_factor_limited']);
        $this->assertNull($result['ads'][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][2]['ad_id'], 2);
        $this->assertEqual($result['ads'][2]['zone_id'], 1);
        $this->assertEqual($result['ads'][2]['priority'], 0);
        $this->assertEqual($result['ads'][2]['required_impressions'], 0);
        $this->assertEqual($result['ads'][2]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][2]['priority_factor'], 1);
        $this->assertFalse($result['ads'][2]['priority_factor_limited']);
        $this->assertNull($result['ads'][2]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][3]['ad_id'], 3);
        $this->assertEqual($result['ads'][3]['zone_id'], 1);
        $this->assertEqual($result['ads'][3]['priority'], 0);
        $this->assertEqual($result['ads'][3]['required_impressions'], 0);
        $this->assertEqual($result['ads'][3]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][3]['priority_factor'], 1);
        $this->assertFalse($result['ads'][3]['priority_factor_limited']);
        $this->assertNull($result['ads'][3]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][9]['ad_id'], 9);
        $this->assertEqual($result['ads'][9]['zone_id'], 1);
        $this->assertEqual($result['ads'][9]['priority'], 0);
        $this->assertEqual($result['ads'][9]['required_impressions'], 0);
        $this->assertEqual($result['ads'][9]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][9]['priority_factor'], 1);
        $this->assertFalse($result['ads'][9]['priority_factor_limited']);
        $this->assertNull($result['ads'][9]['past_zone_traffic_fraction']);
        $this->assertEqual($result['blank'], 1);
        $this->assertEqual($result['blank'], 1);

        // Test 5
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 0;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1));
        $oAd->requiredImpressions = 10;
        $oAd->requestedImpressions = 10;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 2));
        $oAd->requiredImpressions = 20;
        $oAd->requestedImpressions = 20;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 3));
        $oAd->requiredImpressions = 30;
        $oAd->requestedImpressions = 30;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 9));
        $oAd->requiredImpressions = 40;
        $oAd->requestedImpressions = 40;
        $oZone->addAdvert($oAd);
        $result = $oPriorityCompensation->compensatedPriorities($oZone);
        $this->assertEqual(count($result['ads']), 4);
        $this->assertEqual($result['ads'][1]['ad_id'], 1);
        $this->assertEqual($result['ads'][1]['zone_id'], 1);
        $this->assertEqual($result['ads'][1]['priority'], 0);
        $this->assertEqual($result['ads'][1]['required_impressions'], 10);
        $this->assertEqual($result['ads'][1]['requested_impressions'], 10);
        $this->assertEqual($result['ads'][1]['priority_factor'], 1);
        $this->assertFalse($result['ads'][1]['priority_factor_limited']);
        $this->assertNull($result['ads'][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][2]['ad_id'], 2);
        $this->assertEqual($result['ads'][2]['zone_id'], 1);
        $this->assertEqual($result['ads'][2]['priority'], 0);
        $this->assertEqual($result['ads'][2]['required_impressions'], 20);
        $this->assertEqual($result['ads'][2]['requested_impressions'], 20);
        $this->assertEqual($result['ads'][2]['priority_factor'], 1);
        $this->assertFalse($result['ads'][2]['priority_factor_limited']);
        $this->assertNull($result['ads'][2]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][3]['ad_id'], 3);
        $this->assertEqual($result['ads'][3]['zone_id'], 1);
        $this->assertEqual($result['ads'][3]['priority'], 0);
        $this->assertEqual($result['ads'][3]['required_impressions'], 30);
        $this->assertEqual($result['ads'][3]['requested_impressions'], 30);
        $this->assertEqual($result['ads'][3]['priority_factor'], 1);
        $this->assertFalse($result['ads'][3]['priority_factor_limited']);
        $this->assertNull($result['ads'][3]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][9]['ad_id'], 9);
        $this->assertEqual($result['ads'][9]['zone_id'], 1);
        $this->assertEqual($result['ads'][9]['priority'], 0);
        $this->assertEqual($result['ads'][9]['required_impressions'], 40);
        $this->assertEqual($result['ads'][9]['requested_impressions'], 40);
        $this->assertEqual($result['ads'][9]['priority_factor'], 1);
        $this->assertFalse($result['ads'][9]['priority_factor_limited']);
        $this->assertNull($result['ads'][9]['past_zone_traffic_fraction']);
        $this->assertEqual($result['blank'], 1);

        // Test 6
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 100;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1));
        $oAd->requiredImpressions = 10;
        $oAd->requestedImpressions = 10;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 2));
        $oAd->requiredImpressions = 20;
        $oAd->requestedImpressions = 20;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 3));
        $oAd->requiredImpressions = 30;
        $oAd->requestedImpressions = 30;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 9));
        $oAd->requiredImpressions = 40;
        $oAd->requestedImpressions = 40;
        $oZone->addAdvert($oAd);
        $result = $oPriorityCompensation->compensatedPriorities($oZone);
        $this->assertEqual(count($result['ads']), 4);
        $this->assertEqual($result['ads'][1]['ad_id'], 1);
        $this->assertEqual($result['ads'][1]['zone_id'], 1);
        $this->assertEqual($result['ads'][1]['priority'], 0.1);
        $this->assertEqual($result['ads'][1]['required_impressions'], 10);
        $this->assertEqual($result['ads'][1]['requested_impressions'], 10);
        $this->assertEqual($result['ads'][1]['priority_factor'], 1);
        $this->assertFalse($result['ads'][1]['priority_factor_limited']);
        $this->assertNull($result['ads'][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][2]['ad_id'], 2);
        $this->assertEqual($result['ads'][2]['zone_id'], 1);
        $this->assertEqual($result['ads'][2]['priority'], 0.2);
        $this->assertEqual($result['ads'][2]['required_impressions'], 20);
        $this->assertEqual($result['ads'][2]['requested_impressions'], 20);
        $this->assertEqual($result['ads'][2]['priority_factor'], 1);
        $this->assertFalse($result['ads'][2]['priority_factor_limited']);
        $this->assertNull($result['ads'][2]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][3]['ad_id'], 3);
        $this->assertEqual($result['ads'][3]['zone_id'], 1);
        $this->assertEqual($result['ads'][3]['priority'], 0.3);
        $this->assertEqual($result['ads'][3]['required_impressions'], 30);
        $this->assertEqual($result['ads'][3]['requested_impressions'], 30);
        $this->assertEqual($result['ads'][3]['priority_factor'], 1);
        $this->assertFalse($result['ads'][3]['priority_factor_limited']);
        $this->assertNull($result['ads'][3]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][9]['ad_id'], 9);
        $this->assertEqual($result['ads'][9]['zone_id'], 1);
        $this->assertEqual($result['ads'][9]['priority'], 0.4);
        $this->assertEqual($result['ads'][9]['required_impressions'], 40);
        $this->assertEqual($result['ads'][9]['requested_impressions'], 40);
        $this->assertEqual($result['ads'][9]['priority_factor'], 1);
        $this->assertFalse($result['ads'][9]['priority_factor_limited']);
        $this->assertNull($result['ads'][9]['past_zone_traffic_fraction']);
        $this->assertEqual($result['blank'], 0);

        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 200;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1));
        $oAd->requiredImpressions = 10;
        $oAd->requestedImpressions = 10;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 2));
        $oAd->requiredImpressions = 20;
        $oAd->requestedImpressions = 20;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 3));
        $oAd->requiredImpressions = 30;
        $oAd->requestedImpressions = 30;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 9));
        $oAd->requiredImpressions = 40;
        $oAd->requestedImpressions = 40;
        $oZone->addAdvert($oAd);
        $result = $oPriorityCompensation->compensatedPriorities($oZone);
        $this->assertEqual(count($result['ads']), 4);
        $this->assertEqual($result['ads'][1]['ad_id'], 1);
        $this->assertEqual($result['ads'][1]['zone_id'], 1);
        $this->assertEqual($result['ads'][1]['priority'], 0.05);
        $this->assertEqual($result['ads'][1]['required_impressions'], 10);
        $this->assertEqual($result['ads'][1]['requested_impressions'], 10);
        $this->assertEqual($result['ads'][1]['priority_factor'], 1);
        $this->assertFalse($result['ads'][1]['priority_factor_limited']);
        $this->assertNull($result['ads'][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][2]['ad_id'], 2);
        $this->assertEqual($result['ads'][2]['zone_id'], 1);
        $this->assertEqual($result['ads'][2]['priority'], 0.1);
        $this->assertEqual($result['ads'][2]['required_impressions'], 20);
        $this->assertEqual($result['ads'][2]['requested_impressions'], 20);
        $this->assertEqual($result['ads'][2]['priority_factor'], 1);
        $this->assertFalse($result['ads'][2]['priority_factor_limited']);
        $this->assertNull($result['ads'][2]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][3]['ad_id'], 3);
        $this->assertEqual($result['ads'][3]['zone_id'], 1);
        $this->assertEqual($result['ads'][3]['priority'], 0.15);
        $this->assertEqual($result['ads'][3]['required_impressions'], 30);
        $this->assertEqual($result['ads'][3]['requested_impressions'], 30);
        $this->assertEqual($result['ads'][3]['priority_factor'], 1);
        $this->assertFalse($result['ads'][3]['priority_factor_limited']);
        $this->assertNull($result['ads'][3]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][9]['ad_id'], 9);
        $this->assertEqual($result['ads'][9]['zone_id'], 1);
        $this->assertEqual($result['ads'][9]['priority'], 0.2);
        $this->assertEqual($result['ads'][9]['required_impressions'], 40);
        $this->assertEqual($result['ads'][9]['requested_impressions'], 40);
        $this->assertEqual($result['ads'][9]['priority_factor'], 1);
        $this->assertFalse($result['ads'][9]['priority_factor_limited']);
        $this->assertNull($result['ads'][9]['past_zone_traffic_fraction']);
        $this->assertEqual($result['blank'], 0.5);

        // Test 7
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 0;
        $oZone->pastActualImpressions = 100;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oAd->pastRequiredImpressions = 0;
        $oAd->pastActualImpressions = 5;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 2));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oAd->pastRequiredImpressions = 0;
        $oAd->pastActualImpressions = 5;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 3));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oAd->pastRequiredImpressions = 0;
        $oAd->pastActualImpressions = 5;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 9));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oAd->pastRequiredImpressions = 0;
        $oAd->pastActualImpressions = 5;
        $oZone->addAdvert($oAd);
        $result = $oPriorityCompensation->compensatedPriorities($oZone);
        $this->assertEqual(count($result['ads']), 4);
        $this->assertEqual($result['ads'][1]['ad_id'], 1);
        $this->assertEqual($result['ads'][1]['zone_id'], 1);
        $this->assertEqual($result['ads'][1]['priority'], 0);
        $this->assertEqual($result['ads'][1]['required_impressions'], 0);
        $this->assertEqual($result['ads'][1]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][1]['priority_factor'], 1);
        $this->assertFalse($result['ads'][1]['priority_factor_limited']);
        $this->assertNull($result['ads'][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][2]['ad_id'], 2);
        $this->assertEqual($result['ads'][2]['zone_id'], 1);
        $this->assertEqual($result['ads'][2]['priority'], 0);
        $this->assertEqual($result['ads'][2]['required_impressions'], 0);
        $this->assertEqual($result['ads'][2]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][2]['priority_factor'], 1);
        $this->assertFalse($result['ads'][2]['priority_factor_limited']);
        $this->assertNull($result['ads'][2]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][3]['ad_id'], 3);
        $this->assertEqual($result['ads'][3]['zone_id'], 1);
        $this->assertEqual($result['ads'][3]['priority'], 0);
        $this->assertEqual($result['ads'][3]['required_impressions'], 0);
        $this->assertEqual($result['ads'][3]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][3]['priority_factor'], 1);
        $this->assertFalse($result['ads'][3]['priority_factor_limited']);
        $this->assertNull($result['ads'][3]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][9]['ad_id'], 9);
        $this->assertEqual($result['ads'][9]['zone_id'], 1);
        $this->assertEqual($result['ads'][9]['priority'], 0);
        $this->assertEqual($result['ads'][9]['required_impressions'], 0);
        $this->assertEqual($result['ads'][9]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][9]['priority_factor'], 1);
        $this->assertFalse($result['ads'][9]['priority_factor_limited']);
        $this->assertNull($result['ads'][9]['past_zone_traffic_fraction']);
        $this->assertEqual($result['blank'], 1);

        // Test 8
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 100;
        $oZone->pastActualImpressions = 100;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastActualImpressions = 0;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 2));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastActualImpressions = 0;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 3));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastActualImpressions = 0;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 9));
        $oAd->requiredImpressions = 0;
        $oAd->requestedImpressions = 0;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastActualImpressions = 0;
        $oZone->addAdvert($oAd);
        $result = $oPriorityCompensation->compensatedPriorities($oZone);
        $this->assertEqual(count($result['ads']), 4);
        $this->assertEqual($result['ads'][1]['ad_id'], 1);
        $this->assertEqual($result['ads'][1]['zone_id'], 1);
        $this->assertEqual($result['ads'][1]['priority'], 0);
        $this->assertEqual($result['ads'][1]['required_impressions'], 0);
        $this->assertEqual($result['ads'][1]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][1]['priority_factor'], 1);
        $this->assertFalse($result['ads'][1]['priority_factor_limited']);
        $this->assertNull($result['ads'][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][2]['ad_id'], 2);
        $this->assertEqual($result['ads'][2]['zone_id'], 1);
        $this->assertEqual($result['ads'][2]['priority'], 0);
        $this->assertEqual($result['ads'][2]['required_impressions'], 0);
        $this->assertEqual($result['ads'][2]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][2]['priority_factor'], 1);
        $this->assertFalse($result['ads'][2]['priority_factor_limited']);
        $this->assertNull($result['ads'][2]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][3]['ad_id'], 3);
        $this->assertEqual($result['ads'][3]['zone_id'], 1);
        $this->assertEqual($result['ads'][3]['priority'], 0);
        $this->assertEqual($result['ads'][3]['required_impressions'], 0);
        $this->assertEqual($result['ads'][3]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][3]['priority_factor'], 1);
        $this->assertFalse($result['ads'][3]['priority_factor_limited']);
        $this->assertNull($result['ads'][3]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][9]['ad_id'], 9);
        $this->assertEqual($result['ads'][9]['zone_id'], 1);
        $this->assertEqual($result['ads'][9]['priority'], 0);
        $this->assertEqual($result['ads'][9]['required_impressions'], 0);
        $this->assertEqual($result['ads'][9]['requested_impressions'], 0);
        $this->assertEqual($result['ads'][9]['priority_factor'], 1);
        $this->assertFalse($result['ads'][9]['priority_factor_limited']);
        $this->assertNull($result['ads'][9]['past_zone_traffic_fraction']);
        $this->assertEqual($result['blank'], 1);

        // Test 9
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 0;
        $oZone->pastActualImpressions = 100;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1));
        $oAd->requiredImpressions = 10;
        $oAd->requestedImpressions = 10;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastActualImpressions = 0;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 2));
        $oAd->requiredImpressions = 20;
        $oAd->requestedImpressions = 20;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastActualImpressions = 0;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 3));
        $oAd->requiredImpressions = 30;
        $oAd->requestedImpressions = 30;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastActualImpressions = 0;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 9));
        $oAd->requiredImpressions = 40;
        $oAd->requestedImpressions = 40;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastActualImpressions = 0;
        $oZone->addAdvert($oAd);
        $result = $oPriorityCompensation->compensatedPriorities($oZone);
        $this->assertEqual(count($result['ads']), 4);
        $this->assertEqual($result['ads'][1]['ad_id'], 1);
        $this->assertEqual($result['ads'][1]['zone_id'], 1);
        $this->assertEqual($result['ads'][1]['priority'], 0);
        $this->assertEqual($result['ads'][1]['required_impressions'], 10);
        $this->assertEqual($result['ads'][1]['requested_impressions'], 10);
        $this->assertEqual($result['ads'][1]['priority_factor'], 1);
        $this->assertFalse($result['ads'][1]['priority_factor_limited']);
        $this->assertNull($result['ads'][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][2]['ad_id'], 2);
        $this->assertEqual($result['ads'][2]['zone_id'], 1);
        $this->assertEqual($result['ads'][2]['priority'], 0);
        $this->assertEqual($result['ads'][2]['required_impressions'], 20);
        $this->assertEqual($result['ads'][2]['requested_impressions'], 20);
        $this->assertEqual($result['ads'][2]['priority_factor'], 1);
        $this->assertFalse($result['ads'][2]['priority_factor_limited']);
        $this->assertNull($result['ads'][2]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][3]['ad_id'], 3);
        $this->assertEqual($result['ads'][3]['zone_id'], 1);
        $this->assertEqual($result['ads'][3]['priority'], 0);
        $this->assertEqual($result['ads'][3]['required_impressions'], 30);
        $this->assertEqual($result['ads'][3]['requested_impressions'], 30);
        $this->assertEqual($result['ads'][3]['priority_factor'], 1);
        $this->assertFalse($result['ads'][3]['priority_factor_limited']);
        $this->assertNull($result['ads'][3]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][9]['ad_id'], 9);
        $this->assertEqual($result['ads'][9]['zone_id'], 1);
        $this->assertEqual($result['ads'][9]['priority'], 0);
        $this->assertEqual($result['ads'][9]['required_impressions'], 40);
        $this->assertEqual($result['ads'][9]['requested_impressions'], 40);
        $this->assertEqual($result['ads'][9]['priority_factor'], 1);
        $this->assertFalse($result['ads'][9]['priority_factor_limited']);
        $this->assertNull($result['ads'][9]['past_zone_traffic_fraction']);
        $this->assertEqual($result['blank'], 1);

        // Test 10
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 100;
        $oZone->pastActualImpressions = null;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1));
        $oAd->requiredImpressions = 10;
        $oAd->requestedImpressions = 10;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastRequestedImpressions = 10;
        $oAd->pastActualImpressions = 5;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 2));
        $oAd->requiredImpressions = 20;
        $oAd->requestedImpressions = 20;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastRequestedImpressions = 10;
        $oAd->pastActualImpressions = 5;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 3));
        $oAd->requiredImpressions = 30;
        $oAd->requestedImpressions = 30;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastRequestedImpressions = 10;
        $oAd->pastActualImpressions = 5;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 9));
        $oAd->requiredImpressions = 40;
        $oAd->requestedImpressions = 40;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastRequestedImpressions = 10;
        $oAd->pastActualImpressions = 5;
        $oZone->addAdvert($oAd);
        $result = $oPriorityCompensation->compensatedPriorities($oZone);
        $this->assertEqual(count($result['ads']), 4);
        $this->assertEqual($result['ads'][1]['ad_id'], 1);
        $this->assertEqual($result['ads'][1]['zone_id'], 1);
        $this->assertEqual($result['ads'][1]['priority'], 0.1);
        $this->assertEqual($result['ads'][1]['required_impressions'], 10);
        $this->assertEqual($result['ads'][1]['requested_impressions'], 10);
        $this->assertEqual($result['ads'][1]['priority_factor'], 2);
        $this->assertFalse($result['ads'][1]['priority_factor_limited']);
        $this->assertNull($result['ads'][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][2]['ad_id'], 2);
        $this->assertEqual($result['ads'][2]['zone_id'], 1);
        $this->assertEqual($result['ads'][2]['priority'], 0.2);
        $this->assertEqual($result['ads'][2]['required_impressions'], 20);
        $this->assertEqual($result['ads'][2]['requested_impressions'], 20);
        $this->assertEqual($result['ads'][2]['priority_factor'], 2);
        $this->assertFalse($result['ads'][2]['priority_factor_limited']);
        $this->assertNull($result['ads'][2]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][3]['ad_id'], 3);
        $this->assertEqual($result['ads'][3]['zone_id'], 1);
        $this->assertEqual($result['ads'][3]['priority'], 0.3);
        $this->assertEqual($result['ads'][3]['required_impressions'], 30);
        $this->assertEqual($result['ads'][3]['requested_impressions'], 30);
        $this->assertEqual($result['ads'][3]['priority_factor'], 2);
        $this->assertFalse($result['ads'][3]['priority_factor_limited']);
        $this->assertNull($result['ads'][3]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][9]['ad_id'], 9);
        $this->assertEqual($result['ads'][9]['zone_id'], 1);
        $this->assertEqual($result['ads'][9]['priority'], 0.4);
        $this->assertEqual($result['ads'][9]['required_impressions'], 40);
        $this->assertEqual($result['ads'][9]['requested_impressions'], 40);
        $this->assertEqual($result['ads'][9]['priority_factor'], 2);
        $this->assertFalse($result['ads'][9]['priority_factor_limited']);
        $this->assertNull($result['ads'][9]['past_zone_traffic_fraction']);
        $this->assertEqual($result['blank'], 0);

        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 400;
        $oZone->pastActualImpressions = null;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1));
        $oAd->requiredImpressions = 10;
        $oAd->requestedImpressions = 10;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastRequestedImpressions = 10;
        $oAd->pastActualImpressions = 5;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 2));
        $oAd->requiredImpressions = 20;
        $oAd->requestedImpressions = 20;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastRequestedImpressions = 10;
        $oAd->pastActualImpressions = 5;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 3));
        $oAd->requiredImpressions = 30;
        $oAd->requestedImpressions = 30;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastRequestedImpressions = 10;
        $oAd->pastActualImpressions = 5;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 9));
        $oAd->requiredImpressions = 40;
        $oAd->requestedImpressions = 40;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastRequestedImpressions = 10;
        $oAd->pastActualImpressions = 5;
        $oZone->addAdvert($oAd);
        $result = $oPriorityCompensation->compensatedPriorities($oZone);
        $this->assertEqual(count($result['ads']), 4);
        $this->assertEqual($result['ads'][1]['ad_id'], 1);
        $this->assertEqual($result['ads'][1]['zone_id'], 1);
        $this->assertEqual($result['ads'][1]['priority'], 0.025);
        $this->assertEqual($result['ads'][1]['required_impressions'], 10);
        $this->assertEqual($result['ads'][1]['requested_impressions'], 10);
        $this->assertEqual($result['ads'][1]['priority_factor'], 2);
        $this->assertFalse($result['ads'][1]['priority_factor_limited']);
        $this->assertNull($result['ads'][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][2]['ad_id'], 2);
        $this->assertEqual($result['ads'][2]['zone_id'], 1);
        $this->assertEqual($result['ads'][2]['priority'], 0.05);
        $this->assertEqual($result['ads'][2]['required_impressions'], 20);
        $this->assertEqual($result['ads'][2]['requested_impressions'], 20);
        $this->assertEqual($result['ads'][2]['priority_factor'], 2);
        $this->assertFalse($result['ads'][2]['priority_factor_limited']);
        $this->assertNull($result['ads'][2]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][3]['ad_id'], 3);
        $this->assertEqual($result['ads'][3]['zone_id'], 1);
        $this->assertEqual($result['ads'][3]['priority'], 0.075);
        $this->assertEqual($result['ads'][3]['required_impressions'], 30);
        $this->assertEqual($result['ads'][3]['requested_impressions'], 30);
        $this->assertEqual($result['ads'][3]['priority_factor'], 2);
        $this->assertFalse($result['ads'][3]['priority_factor_limited']);
        $this->assertNull($result['ads'][3]['past_zone_traffic_fraction']);
        $this->assertEqual($result['ads'][9]['ad_id'], 9);
        $this->assertEqual($result['ads'][9]['zone_id'], 1);
        $this->assertEqual($result['ads'][9]['priority'], 0.1);
        $this->assertEqual($result['ads'][9]['required_impressions'], 40);
        $this->assertEqual($result['ads'][9]['requested_impressions'], 40);
        $this->assertEqual($result['ads'][9]['priority_factor'], 2);
        $this->assertFalse($result['ads'][9]['priority_factor_limited']);
        $this->assertNull($result['ads'][9]['past_zone_traffic_fraction']);
        $this->assertEqual($result['blank'], 0.75);

        // Test 11
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 100;
        $oZone->pastActualImpressions = 100;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1));
        $oAd->requiredImpressions = 10;
        $oAd->requestedImpressions = 10;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastRequestedImpressions = 10;
        $oAd->pastActualImpressions = 5;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 2));
        $oAd->requiredImpressions = 20;
        $oAd->requestedImpressions = 20;
        $oAd->pastRequiredImpressions = 20;
        $oAd->pastRequestedImpressions = 20;
        $oAd->pastActualImpressions = 10;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 3));
        $oAd->requiredImpressions = 30;
        $oAd->requestedImpressions = 30;
        $oAd->pastRequiredImpressions = 30;
        $oAd->pastRequestedImpressions = 30;
        $oAd->pastActualImpressions = 15;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 9));
        $oAd->requiredImpressions = 40;
        $oAd->requestedImpressions = 40;
        $oAd->pastRequiredImpressions = 40;
        $oAd->pastRequestedImpressions = 40;
        $oAd->pastActualImpressions = 20;
        $oZone->addAdvert($oAd);
        $result = $oPriorityCompensation->compensatedPriorities($oZone);
        $this->assertEqual(count($result['ads']), 4);
        $this->assertEqual($result['ads'][1]['ad_id'], 1);
        $this->assertEqual($result['ads'][1]['zone_id'], 1);
        $this->assertEqual($result['ads'][1]['priority'], 0.1);
        $this->assertEqual($result['ads'][1]['required_impressions'], 10);
        $this->assertEqual($result['ads'][1]['requested_impressions'], 10);
        $this->assertEqual($result['ads'][1]['priority_factor'], 2);
        $this->assertFalse($result['ads'][1]['priority_factor_limited']);
        $this->assertEqual($result['ads'][1]['past_zone_traffic_fraction'], 0.05);
        $this->assertEqual($result['ads'][2]['ad_id'], 2);
        $this->assertEqual($result['ads'][2]['zone_id'], 1);
        $this->assertEqual($result['ads'][2]['priority'], 0.2);
        $this->assertEqual($result['ads'][2]['required_impressions'], 20);
        $this->assertEqual($result['ads'][2]['requested_impressions'], 20);
        $this->assertEqual($result['ads'][2]['priority_factor'], 2);
        $this->assertFalse($result['ads'][2]['priority_factor_limited']);
        $this->assertEqual($result['ads'][2]['past_zone_traffic_fraction'], 0.1);
        $this->assertEqual($result['ads'][3]['ad_id'], 3);
        $this->assertEqual($result['ads'][3]['zone_id'], 1);
        $this->assertEqual($result['ads'][3]['priority'], 0.3);
        $this->assertEqual($result['ads'][3]['required_impressions'], 30);
        $this->assertEqual($result['ads'][3]['requested_impressions'], 30);
        $this->assertEqual($result['ads'][3]['priority_factor'], 2);
        $this->assertFalse($result['ads'][3]['priority_factor_limited']);
        $this->assertEqual($result['ads'][3]['past_zone_traffic_fraction'], 0.15);
        $this->assertEqual($result['ads'][9]['ad_id'], 9);
        $this->assertEqual($result['ads'][9]['zone_id'], 1);
        $this->assertEqual($result['ads'][9]['priority'], 0.4);
        $this->assertEqual($result['ads'][9]['required_impressions'], 40);
        $this->assertEqual($result['ads'][9]['requested_impressions'], 40);
        $this->assertEqual($result['ads'][9]['priority_factor'], 2);
        $this->assertFalse($result['ads'][9]['priority_factor_limited']);
        $this->assertEqual($result['ads'][9]['past_zone_traffic_fraction'], 0.2);
        $this->assertEqual($result['blank'], 0);

        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = 400;
        $oZone->pastActualImpressions = 100;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1));
        $oAd->requiredImpressions = 10;
        $oAd->requestedImpressions = 10;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastRequestedImpressions = 10;
        $oAd->pastActualImpressions = 5;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 2));
        $oAd->requiredImpressions = 20;
        $oAd->requestedImpressions = 20;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastRequestedImpressions = 10;
        $oAd->pastActualImpressions = 5;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 3));
        $oAd->requiredImpressions = 30;
        $oAd->requestedImpressions = 30;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastRequestedImpressions = 10;
        $oAd->pastActualImpressions = 5;
        $oZone->addAdvert($oAd);
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 9));
        $oAd->requiredImpressions = 40;
        $oAd->requestedImpressions = 40;
        $oAd->pastRequiredImpressions = 10;
        $oAd->pastRequestedImpressions = 10;
        $oAd->pastActualImpressions = 5;
        $oZone->addAdvert($oAd);
        $result = $oPriorityCompensation->compensatedPriorities($oZone);
        $this->assertEqual(count($result['ads']), 4);
        $this->assertEqual($result['ads'][1]['ad_id'], 1);
        $this->assertEqual($result['ads'][1]['zone_id'], 1);
        $this->assertEqual($result['ads'][1]['priority'], 0.025);
        $this->assertEqual($result['ads'][1]['required_impressions'], 10);
        $this->assertEqual($result['ads'][1]['requested_impressions'], 10);
        $this->assertEqual($result['ads'][1]['priority_factor'], 2);
        $this->assertFalse($result['ads'][1]['priority_factor_limited']);
        $this->assertEqual($result['ads'][1]['past_zone_traffic_fraction'], 0.05);
        $this->assertEqual($result['ads'][2]['ad_id'], 2);
        $this->assertEqual($result['ads'][2]['zone_id'], 1);
        $this->assertEqual($result['ads'][2]['priority'], 0.05);
        $this->assertEqual($result['ads'][2]['required_impressions'], 20);
        $this->assertEqual($result['ads'][2]['requested_impressions'], 20);
        $this->assertEqual($result['ads'][2]['priority_factor'], 2);
        $this->assertFalse($result['ads'][2]['priority_factor_limited']);
        $this->assertEqual($result['ads'][2]['past_zone_traffic_fraction'], 0.05);
        $this->assertEqual($result['ads'][3]['ad_id'], 3);
        $this->assertEqual($result['ads'][3]['zone_id'], 1);
        $this->assertEqual($result['ads'][3]['priority'], 0.075);
        $this->assertEqual($result['ads'][3]['required_impressions'], 30);
        $this->assertEqual($result['ads'][3]['requested_impressions'], 30);
        $this->assertEqual($result['ads'][3]['priority_factor'], 2);
        $this->assertFalse($result['ads'][3]['priority_factor_limited']);
        $this->assertEqual($result['ads'][3]['past_zone_traffic_fraction'], 0.05);
        $this->assertEqual($result['ads'][9]['ad_id'], 9);
        $this->assertEqual($result['ads'][9]['zone_id'], 1);
        $this->assertEqual($result['ads'][9]['priority'], 0.1);
        $this->assertEqual($result['ads'][9]['required_impressions'], 40);
        $this->assertEqual($result['ads'][9]['requested_impressions'], 40);
        $this->assertEqual($result['ads'][9]['priority_factor'], 2);
        $this->assertFalse($result['ads'][9]['priority_factor_limited']);
        $this->assertEqual($result['ads'][9]['past_zone_traffic_fraction'], 0.05);
        $this->assertEqual($result['blank'], 0.75);

        // Test 12
        $value = 1.2 * mt_getrandmax();
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = $value;
        $oZone->pastActualImpressions = $value;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1));
        $oAd->requiredImpressions = $value;
        $oAd->requestedImpressions = $value;
        $oAd->pastRequiredImpressions = $value;
        $oAd->pastRequestedImpressions = $value;
        $oAd->pastActualImpressions = 1;
        $oAd->pastZoneTrafficFraction = 0;
        $oAd->pastAdZonePriorityFactor = 1;
        $oZone->addAdvert($oAd);
        $result = $oPriorityCompensation->compensatedPriorities($oZone);
        $this->assertEqual(count($result['ads']), 1);
        $this->assertEqual($result['ads'][1]['ad_id'], 1);
        $this->assertEqual($result['ads'][1]['zone_id'], 1);
        $this->assertEqual($result['ads'][1]['priority'], 1);
        $this->assertEqual($result['ads'][1]['required_impressions'], $value);
        $this->assertEqual($result['ads'][1]['requested_impressions'], $value);
        $this->assertEqual($result['ads'][1]['priority_factor'], 1 + ((mt_getrandmax() - 1) / 2));
        $this->assertTrue($result['ads'][1]['priority_factor_limited']);
        $this->assertEqual($result['ads'][1]['past_zone_traffic_fraction'], 1 / $value);
        $this->assertEqual($result['blank'], 0);

        // Test 13
        $value = 1.2 * mt_getrandmax();
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->availableImpressions = $value;
        $oZone->pastActualImpressions = $value;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1));
        $oAd->deliveryLimitationChanged = true;
        $oAd->requiredImpressions = $value;
        $oAd->requestedImpressions = $value;
        $oAd->pastRequiredImpressions = $value;
        $oAd->pastRequestedImpressions = $value;
        $oAd->pastActualImpressions = 1;
        $oAd->pastZoneTrafficFraction = 0;
        $oAd->pastAdZonePriorityFactor = 1;
        $oZone->addAdvert($oAd);
        $result = $oPriorityCompensation->compensatedPriorities($oZone);
        $this->assertEqual(count($result['ads']), 1);
        $this->assertEqual($result['ads'][1]['ad_id'], 1);
        $this->assertEqual($result['ads'][1]['zone_id'], 1);
        $this->assertEqual($result['ads'][1]['priority'], 1);
        $this->assertEqual($result['ads'][1]['required_impressions'], $value);
        $this->assertEqual($result['ads'][1]['requested_impressions'], $value);
        $this->assertEqual($result['ads'][1]['priority_factor'], 1);
        $this->assertFalse($result['ads'][1]['priority_factor_limited']);
        $this->assertNull($result['ads'][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result['blank'], 0);
    }

}

?>
