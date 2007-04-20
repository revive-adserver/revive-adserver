<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
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

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Entity/Ad.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/AdServer/Task/AllocateZoneImpressions.php';
require_once 'Date.php';

/**
 * A class for testing the Maintenance_Priority_AdServer_AdvertisementZoneImpressionAllocation class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Demian Turner <demian@m3.net>
 */
class TestOfPriorityAdserverAllocateZoneImpressions extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function TestOfPriorityAdserverAllocateZoneImpressions()
    {
        $this->UnitTestCase();
        Mock::generate('MAX_Dal_Entities');
        Mock::generate('OA_Dal_Maintenance_Priority');
        Mock::generate('OA_DB_Table_Priority');
    }

    /**
     * A method to be called before every test to store default
     * mocked data access layers in the service locator.
     */
    function setUp()
    {
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntites = new MockMAX_Dal_Entities($this);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntites);
        $oMaxDalMaintenancePriority = new MockOA_Dal_Maintenance_Priority($this);
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oMaxDalMaintenancePriority);
        $oTable = new MockOA_DB_Table_Priority($this);
        $oServiceLocator->register('OA_DB_Table_Priority', $oTable);
    }

    /**
     * A method to be called after every test to remove the
     * mocked data access layers from the service locator.
     *
     */
    function tearDown()
    {
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->remove('MAX_Dal_Entities');
        $oServiceLocator->remove('OA_Dal_Maintenance_Priority');
        $oServiceLocator->remove('OA_DB_Table_Priority');
    }

    /**
     * A method to test the _setZoneForecasts() method.
     *
     * Test 1: Test that both arrays used to store zone impression data are
     *         correctly stored when no zone impression forecast data is
     *         returned from the data access layer.
     * Test 2: Test that both arrays used to store zone impression data are
     *         correctly stored when zone impression forecast data is
     *         returned from the data access layer.
     */
    function test_setZoneForecasts()
    {
        // Prepare the DAL return values for the tests
        $oServiceLocator = &ServiceLocator::instance();
        $oDal = $oServiceLocator->get('OA_Dal_Maintenance_Priority');
        $oDal->setReturnValueAt(0, 'getZoneImpressionForecasts', array());
        $oDal->setReturnValueAt(1, 'getZoneImpressionForecasts', array(1 => 5, 2 => 7, 9 => 9));
        $oDal->expectCallCount('getZoneImpressionForecasts', 2);
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);

        // Prepare the AllocateZoneImpressions object for testing
        $allocateZoneImpressions = new AllocateZoneImpressions();

        // Test 1
        $allocateZoneImpressions->_setZoneForecasts();
        $this->assertTrue(is_array($allocateZoneImpressions->aAvailableForecastZoneImpressions));
        $this->assertTrue(empty($allocateZoneImpressions->aAvailableForecastZoneImpressions));
        $this->assertTrue(is_array($allocateZoneImpressions->aOverSubscribedZones));
        $this->assertTrue(empty($allocateZoneImpressions->aOverSubscribedZones));

        // Test 2
        $allocateZoneImpressions->_setZoneForecasts();
        $this->assertTrue(is_array($allocateZoneImpressions->aAvailableForecastZoneImpressions));
        $this->assertTrue(!empty($allocateZoneImpressions->aAvailableForecastZoneImpressions));
        $this->assertEqual(count($allocateZoneImpressions->aAvailableForecastZoneImpressions), 3);
        $this->assertEqual($allocateZoneImpressions->aAvailableForecastZoneImpressions[1], 4);
        $this->assertEqual($allocateZoneImpressions->aAvailableForecastZoneImpressions[2], 6);
        $this->assertEqual($allocateZoneImpressions->aAvailableForecastZoneImpressions[9], 8);
        $this->assertTrue(is_array($allocateZoneImpressions->aOverSubscribedZones));
        $this->assertTrue(!empty($allocateZoneImpressions->aOverSubscribedZones));
        $this->assertEqual(count($allocateZoneImpressions->aOverSubscribedZones), 3);
        $this->assertTrue(is_array($allocateZoneImpressions->aOverSubscribedZones[1]));
        $this->assertEqual($allocateZoneImpressions->aOverSubscribedZones[1]['zoneId'], 1);
        $this->assertEqual($allocateZoneImpressions->aOverSubscribedZones[1]['availableImpressions'], 4);
        $this->assertEqual($allocateZoneImpressions->aOverSubscribedZones[1]['desiredImpressions'], 0);
        $this->assertTrue(!empty($allocateZoneImpressions->aOverSubscribedZones[1]));
        $this->assertTrue(is_array($allocateZoneImpressions->aOverSubscribedZones[2]));
        $this->assertEqual($allocateZoneImpressions->aOverSubscribedZones[2]['zoneId'], 2);
        $this->assertEqual($allocateZoneImpressions->aOverSubscribedZones[2]['availableImpressions'], 6);
        $this->assertEqual($allocateZoneImpressions->aOverSubscribedZones[2]['desiredImpressions'], 0);
        $this->assertTrue(!empty($allocateZoneImpressions->aOverSubscribedZones[2]));
        $this->assertTrue(is_array($allocateZoneImpressions->aOverSubscribedZones[9]));
        $this->assertTrue(!empty($allocateZoneImpressions->aOverSubscribedZones[9]));
        $this->assertEqual($allocateZoneImpressions->aOverSubscribedZones[9]['zoneId'], 9);
        $this->assertEqual($allocateZoneImpressions->aOverSubscribedZones[9]['availableImpressions'], 8);
        $this->assertEqual($allocateZoneImpressions->aOverSubscribedZones[9]['desiredImpressions'], 0);
    }

    /**
     * A method to test the _getAllPlacements() method.
     *
     * Test 1: Test with no placements returned from the DAL.
     * Test 2: Test with placements in the DAL.
     */
    function test_getAllPlacements()
    {
        // Prepare the DAL return values for the tests
        $oServiceLocator = &ServiceLocator::instance();
        $oDal = $oServiceLocator->get('OA_Dal_Maintenance_Priority');
        $oDal->setReturnValueAt(0, 'getPlacements', array());
        $oDal->setReturnValueAt(1, 'getPlacements',
            array(
                array(
                    'campaignid'        => 1,
                    'views'             => 1000,
                    'clicks'            => 0,
                    'conversions'       => 0,
                    'expire'            => '2006-01-27',
                    'target_impression' => 0,
                    'target_click'      => 0,
                    'target_conversion' => 0,
                    'priority'          => 5
                ),
                array(
                    'campaignid'        => 2,
                    'views'             => 0,
                    'clicks'            => 0,
                    'conversions'       => 0,
                    'expire'            => '0000-00-00',
                    'target_impression' => 1000,
                    'target_click'      => 0,
                    'target_conversion' => 0,
                    'priority'          => 4
                )
            )
        );
        $oDal->expectCallCount('getPlacements', 2);
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);

        // Prepare the AllocateZoneImpressions object for testing
        $allocateZoneImpressions = new AllocateZoneImpressions();

        // Test 1
        $aPlacements = $allocateZoneImpressions->_getAllPlacements();
        $this->assertTrue(is_array($aPlacements));
        $this->assertTrue(empty($aPlacements));

        // Test 2
        $aPlacements = $allocateZoneImpressions->_getAllPlacements();
        $this->assertTrue(is_array($aPlacements));
        $this->assertTrue(!empty($aPlacements));
        $this->assertEqual(count($aPlacements), 2);
        $this->assertIsA($aPlacements[0], 'MAX_Entity_Placement');
        $this->assertEqual($aPlacements[0]->id, 1);
        $this->assertEqual($aPlacements[0]->impressionTargetTotal, 1000);
        $this->assertEqual($aPlacements[0]->clickTargetTotal, 0);
        $this->assertEqual($aPlacements[0]->conversionTargetTotal, 0);
        $this->assertEqual($aPlacements[0]->impressionTargetDaily, 0);
        $this->assertEqual($aPlacements[0]->clickTargetDaily, 0);
        $this->assertEqual($aPlacements[0]->conversionTargetDaily, 0);
        $this->assertEqual($aPlacements[0]->priority, 5);
        $this->assertIsA($aPlacements[1], 'MAX_Entity_Placement');
        $this->assertEqual($aPlacements[1]->id, 2);
        $this->assertEqual($aPlacements[1]->impressionTargetTotal, 0);
        $this->assertEqual($aPlacements[1]->clickTargetTotal, 0);
        $this->assertEqual($aPlacements[1]->conversionTargetTotal, 0);
        $this->assertEqual($aPlacements[1]->impressionTargetDaily, 1000);
        $this->assertEqual($aPlacements[1]->clickTargetDaily, 0);
        $this->assertEqual($aPlacements[1]->conversionTargetDaily, 0);
        $this->assertEqual($aPlacements[1]->priority, 4);
    }

    /**
     * A method to test the _setRequiredImpressions() method.
     *
     * Test 1: Test with an empty array passed in.
     * Test 2: Test with an array of Adverts passed in, but no required impressions set
     *         in the database.
     * Test 3: Test with an array of Adverts passed in, and required impressions set
     *         in the database.
     */
    function test_setRequiredImpressions()
    {
        // Prepare the DAL return values for the tests
        $oServiceLocator = &ServiceLocator::instance();
        $oDal = $oServiceLocator->get('OA_Dal_Maintenance_Priority');
        $oDal->setReturnValueAt(0, 'getRequiredAdImpressions', array());
        $oDal->setReturnValueAt(1, 'getRequiredAdImpressions', array(1 => 1, 3 => 10));
        $oDal->expectCallCount('getRequiredAdImpressions', 2);
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);

        // Prepare the AllocateZoneImpressions object for testing
        $allocateZoneImpressions = new AllocateZoneImpressions();

        // Test 1
        $aAdverts = array();
        $allocateZoneImpressions->_setRequiredImpressions($aAdverts);
        $this->assertTrue(is_array($aAdverts));
        $this->assertTrue(empty($aAdverts));

        // Test 2
        $aAdverts = array();
        $aAdParams = array(
            'ad_id'  => 1,
            'active' => 't',
            'type'   => 'sql',
            'weight' => 1
        );
        $oAd = new MAX_Entity_Ad($aAdParams);
        $aAdverts[] = $oAd;
        $aAdParams = array(
            'ad_id'  => 2,
            'active' => 't',
            'type'   => 'sql',
            'weight' => 1
        );
        $oAd = new MAX_Entity_Ad($aAdParams);
        $aAdverts[] = $oAd;
        $aAdParams = array(
            'ad_id'  => 3,
            'active' => 't',
            'type'   => 'sql',
            'weight' => 1
        );
        $oAd = new MAX_Entity_Ad($aAdParams);
        $aAdverts[] = $oAd;
        $allocateZoneImpressions->_setRequiredImpressions($aAdverts);
        $this->assertTrue(is_array($aAdverts));
        $this->assertTrue(!empty($aAdverts));
        $this->assertEqual(count($aAdverts), 3);
        $this->assertTrue(isset($aAdverts[0]));
        $this->assertIsA($aAdverts[0], 'MAX_Entity_Ad');
        $this->assertEqual($aAdverts[0]->id, 1);
        $this->assertEqual($aAdverts[0]->requiredImpressions, 0);
        $this->assertTrue(isset($aAdverts[1]));
        $this->assertIsA($aAdverts[1], 'MAX_Entity_Ad');
        $this->assertEqual($aAdverts[1]->id, 2);
        $this->assertEqual($aAdverts[1]->requiredImpressions, 0);
        $this->assertTrue(isset($aAdverts[2]));
        $this->assertIsA($aAdverts[2], 'MAX_Entity_Ad');
        $this->assertEqual($aAdverts[2]->id, 3);
        $this->assertEqual($aAdverts[2]->requiredImpressions, 0);

        // Test 3
        $allocateZoneImpressions->_setRequiredImpressions($aAdverts);
        $this->assertTrue(is_array($aAdverts));
        $this->assertTrue(!empty($aAdverts));
        $this->assertEqual(count($aAdverts), 3);
        $this->assertTrue(isset($aAdverts[0]));
        $this->assertIsA($aAdverts[0], 'MAX_Entity_Ad');
        $this->assertEqual($aAdverts[0]->id, 1);
        $this->assertEqual($aAdverts[0]->requiredImpressions, 1);
        $this->assertTrue(isset($aAdverts[1]));
        $this->assertIsA($aAdverts[1], 'MAX_Entity_Ad');
        $this->assertEqual($aAdverts[1]->id, 2);
        $this->assertEqual($aAdverts[1]->requiredImpressions, 0);
        $this->assertTrue(isset($aAdverts[2]));
        $this->assertIsA($aAdverts[2], 'MAX_Entity_Ad');
        $this->assertEqual($aAdverts[2]->id, 3);
        $this->assertEqual($aAdverts[2]->requiredImpressions, 10);
    }

    /**
     * A method to test the _setPlacements() method.
     *
     * Test 1: Run a combination test of the tests used in testing the
     *         _getAllPlacements() and _setRequiredImpressions() method
     *         tests above, and ensure that the methods work when used
     *         together.
     */
    function test_setPlacements()
    {
        // Prepare the DAL return values for the tests
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalMaintenancePriority = $oServiceLocator->get('OA_Dal_Maintenance_Priority');
        $oMaxDalMaintenancePriority->setReturnValueAt(0, 'getPlacements',
            array(
                array(
                    'campaignid'        => 1,
                    'views'             => 1000,
                    'clicks'            => 0,
                    'conversions'       => 0,
                    'expire'            => '2006-01-27',
                    'target_impression' => 0,
                    'target_click'      => 0,
                    'target_conversion' => 0,
                    'priority'          => 5
                ),
                array(
                    'campaignid'        => 2,
                    'views'             => 0,
                    'clicks'            => 0,
                    'conversions'       => 0,
                    'expire'            => '0000-00-00',
                    'target_impression' => 1000,
                    'target_click'      => 0,
                    'target_conversion' => 0,
                    'priority'          => 4
                )
            )
        );
        $oMaxDalMaintenancePriority->expectCallCount('getPlacements', 1);
        $oMaxDalMaintenancePriority->setReturnValueAt(0, 'getRequiredAdImpressions', array(1 => 1, 2 => 9));
        $oMaxDalMaintenancePriority->setReturnValueAt(1, 'getRequiredAdImpressions', array(3 => 5, 4 => 0));
        $oMaxDalMaintenancePriority->expectCallCount('getRequiredAdImpressions', 2);
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oMaxDalMaintenancePriority);

        $oMaxDalEntities = $oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->setReturnValue('getAdsByPlacementId',
            array(
                array(
                    'ad_id'  => 1,
                    'type'   => 'web',
                    'weight' => 1,
                    'active' => 't'
                ),
                array(
                    'ad_id'  => 2,
                    'type'   => 'web',
                    'weight' => 1,
                    'active' => 't'
                )
            ),
            array(1)
        );
        $oMaxDalEntities->setReturnValue('getAdsByPlacementId',
            array(
                array(
                    'ad_id'  => 3,
                    'type'   => 'web',
                    'weight' => 1,
                    'active' => 't'
                ),
                array(
                    'ad_id'  => 4,
                    'type'   => 'web',
                    'weight' => 2,
                    'active' => 'f'
                )
            ),
            array(2)
        );
        $oMaxDalEntities->expectCallCount('getAdsByPlacementId', 2);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        // Prepare the AllocateZoneImpressions object for testing
        $allocateZoneImpressions = new AllocateZoneImpressions();

        // Test 1
        $allocateZoneImpressions->_setPlacements();
        $this->assertTrue(is_array($allocateZoneImpressions->aPlacements));
        $this->assertTrue(!empty($allocateZoneImpressions->aPlacements));
        $this->assertEqual(count($allocateZoneImpressions->aPlacements), 2);
        $this->assertIsA($allocateZoneImpressions->aPlacements[0], 'MAX_Entity_Placement');
        $this->assertEqual($allocateZoneImpressions->aPlacements[0]->id, 1);
        $this->assertEqual($allocateZoneImpressions->aPlacements[0]->impressionTargetTotal, 1000);
        $this->assertEqual($allocateZoneImpressions->aPlacements[0]->clickTargetTotal, 0);
        $this->assertEqual($allocateZoneImpressions->aPlacements[0]->conversionTargetTotal, 0);
        $this->assertEqual($allocateZoneImpressions->aPlacements[0]->impressionTargetDaily, 0);
        $this->assertEqual($allocateZoneImpressions->aPlacements[0]->clickTargetDaily, 0);
        $this->assertEqual($allocateZoneImpressions->aPlacements[0]->conversionTargetDaily, 0);
        $this->assertEqual($allocateZoneImpressions->aPlacements[0]->priority, 5);

        $this->assertTrue(is_array($allocateZoneImpressions->aPlacements[0]->aAds));
        $this->assertTrue(!empty($allocateZoneImpressions->aPlacements[0]->aAds));
        $this->assertEqual(count($allocateZoneImpressions->aPlacements[0]->aAds), 2);
        $this->assertTrue(isset($allocateZoneImpressions->aPlacements[0]->aAds[0]));
        $this->assertIsA($allocateZoneImpressions->aPlacements[0]->aAds[0], 'MAX_Entity_Ad');
        $this->assertEqual($allocateZoneImpressions->aPlacements[0]->aAds[0]->id, 1);
        $this->assertEqual($allocateZoneImpressions->aPlacements[0]->aAds[0]->requiredImpressions, 1);
        $this->assertTrue(isset($allocateZoneImpressions->aPlacements[0]->aAds[1]));
        $this->assertIsA($allocateZoneImpressions->aPlacements[0]->aAds[1], 'MAX_Entity_Ad');
        $this->assertEqual($allocateZoneImpressions->aPlacements[0]->aAds[1]->id, 2);
        $this->assertEqual($allocateZoneImpressions->aPlacements[0]->aAds[1]->requiredImpressions, 9);

        $this->assertIsA($allocateZoneImpressions->aPlacements[1], 'MAX_Entity_Placement');
        $this->assertEqual($allocateZoneImpressions->aPlacements[1]->id, 2);
        $this->assertEqual($allocateZoneImpressions->aPlacements[1]->impressionTargetTotal, 0);
        $this->assertEqual($allocateZoneImpressions->aPlacements[1]->clickTargetTotal, 0);
        $this->assertEqual($allocateZoneImpressions->aPlacements[1]->conversionTargetTotal, 0);
        $this->assertEqual($allocateZoneImpressions->aPlacements[1]->impressionTargetDaily, 1000);
        $this->assertEqual($allocateZoneImpressions->aPlacements[1]->clickTargetDaily, 0);
        $this->assertEqual($allocateZoneImpressions->aPlacements[1]->conversionTargetDaily, 0);
        $this->assertEqual($allocateZoneImpressions->aPlacements[1]->priority, 4);

        $this->assertTrue(is_array($allocateZoneImpressions->aPlacements[1]->aAds));
        $this->assertTrue(!empty($allocateZoneImpressions->aPlacements[1]->aAds));
        $this->assertEqual(count($allocateZoneImpressions->aPlacements[1]->aAds), 2);
        $this->assertTrue(isset($allocateZoneImpressions->aPlacements[1]->aAds[0]));
        $this->assertIsA($allocateZoneImpressions->aPlacements[1]->aAds[0], 'MAX_Entity_Ad');
        $this->assertEqual($allocateZoneImpressions->aPlacements[1]->aAds[0]->id, 3);
        $this->assertEqual($allocateZoneImpressions->aPlacements[1]->aAds[0]->requiredImpressions, 5);
        $this->assertTrue(isset($allocateZoneImpressions->aPlacements[1]->aAds[1]));
        $this->assertIsA($allocateZoneImpressions->aPlacements[1]->aAds[1], 'MAX_Entity_Ad');
        $this->assertEqual($allocateZoneImpressions->aPlacements[1]->aAds[1]->id, 4);
        $this->assertEqual($allocateZoneImpressions->aPlacements[1]->aAds[1]->requiredImpressions, 0);
    }

    /**
     * A method to test the _setAdZoneAssociations() method.
     *
     * Test 1: Test with no Placements set in the AllocateZoneImpressions object.
     * Test 2: Test with a Placement, but no Advert objects.
     * Test 3: Test with a Placement and Advert objects, but no ad/zone associations.
     * Test 4: Test with a Placement and Advert objects, and ad/zone associations.
     */
    function test_setAdZoneAssociations()
    {
        // Prepare the DAL return values for the tests
        $oServiceLocator = &ServiceLocator::instance();
        $oDal = $oServiceLocator->get('OA_Dal_Maintenance_Priority');
        $oDal->setReturnValueAt(0, 'getAdZoneAssociationsByAds', array());
        $oDal->setReturnValueAt(1, 'getAdZoneAssociationsByAds',
            array(
                1 => array(
                         array('zone_id' => 5),
                         array('zone_id' => 6),
                         array('zone_id' => 7)
                     ),
                2 => array(
                         array('zone_id' => 5)
                     )
            )
        );
        $oDal->expectCallCount('getAdZoneAssociationsByAds', 2);
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);

        // Prepare the AllocateZoneImpressions object for testing
        $allocateZoneImpressions = new AllocateZoneImpressions();

        // Test 1
        $allocateZoneImpressions->_setAdZoneAssociations();
        $this->assertTrue(is_array($allocateZoneImpressions->aAdZoneAssociations));
        $this->assertTrue(empty($allocateZoneImpressions->aAdZoneAssociations));

        // Test 2
        $oPlacement = new MAX_Entity_Placement(
            array(
                'campaignid'        => 1,
                'views'             => 1000,
                'clicks'            => 0,
                'conversions'       => 0,
                'expire'            => '2006-01-27',
                'target_impression' => 0,
                'target_click'      => 0,
                'target_conversion' => 0,
                'priority'          => 5
            )
        );
        $allocateZoneImpressions->aPlacements[] = $oPlacement;
        $allocateZoneImpressions->_setAdZoneAssociations();
        $this->assertTrue(is_array($allocateZoneImpressions->aAdZoneAssociations));
        $this->assertTrue(empty($allocateZoneImpressions->aAdZoneAssociations));

        // Test 3
        $aAdverts = array();
        $oAd = new MAX_Entity_Ad(array('ad_id' => 1));
        $aAdverts[] = $oAd;
        $oAd = new MAX_Entity_Ad(array('ad_id' => 2));
        $aAdverts[] = $oAd;
        $allocateZoneImpressions->aPlacements[0]->aAds = $aAdverts;
        $allocateZoneImpressions->_setAdZoneAssociations();
        $this->assertTrue(is_array($allocateZoneImpressions->aAdZoneAssociations));
        $this->assertTrue(empty($allocateZoneImpressions->aAdZoneAssociations));

        // Test 4
        $allocateZoneImpressions->_setAdZoneAssociations();
        $this->assertTrue(is_array($allocateZoneImpressions->aAdZoneAssociations));
        $this->assertTrue(!empty($allocateZoneImpressions->aAdZoneAssociations));
        $this->assertEqual(count($allocateZoneImpressions->aAdZoneAssociations), 1);
        $this->assertTrue(isset($allocateZoneImpressions->aAdZoneAssociations[1]));
        $this->assertTrue(is_array($allocateZoneImpressions->aAdZoneAssociations[1]));
        $this->assertTrue(!empty($allocateZoneImpressions->aAdZoneAssociations[1]));
        $this->assertTrue(isset($allocateZoneImpressions->aAdZoneAssociations[1][1]));
        $this->assertTrue(is_array($allocateZoneImpressions->aAdZoneAssociations[1][1]));
        $this->assertTrue(!empty($allocateZoneImpressions->aAdZoneAssociations[1][1]));
        $this->assertTrue(isset($allocateZoneImpressions->aAdZoneAssociations[1][1][0]));
        $this->assertTrue(is_array($allocateZoneImpressions->aAdZoneAssociations[1][1][0]));
        $this->assertTrue(!empty($allocateZoneImpressions->aAdZoneAssociations[1][1][0]));
        $this->assertTrue(isset($allocateZoneImpressions->aAdZoneAssociations[1][1][0]['zone_id']));
        $this->assertEqual($allocateZoneImpressions->aAdZoneAssociations[1][1][0]['zone_id'], 5);
        $this->assertTrue(isset($allocateZoneImpressions->aAdZoneAssociations[1][1][1]));
        $this->assertTrue(is_array($allocateZoneImpressions->aAdZoneAssociations[1][1][1]));
        $this->assertTrue(!empty($allocateZoneImpressions->aAdZoneAssociations[1][1][1]));
        $this->assertTrue(isset($allocateZoneImpressions->aAdZoneAssociations[1][1][1]['zone_id']));
        $this->assertEqual($allocateZoneImpressions->aAdZoneAssociations[1][1][1]['zone_id'], 6);
        $this->assertTrue(isset($allocateZoneImpressions->aAdZoneAssociations[1][1][2]));
        $this->assertTrue(is_array($allocateZoneImpressions->aAdZoneAssociations[1][1][2]));
        $this->assertTrue(!empty($allocateZoneImpressions->aAdZoneAssociations[1][1][2]));
        $this->assertTrue(isset($allocateZoneImpressions->aAdZoneAssociations[1][1][2]['zone_id']));
        $this->assertEqual($allocateZoneImpressions->aAdZoneAssociations[1][1][2]['zone_id'], 7);
        $this->assertTrue(isset($allocateZoneImpressions->aAdZoneAssociations[1][2]));
        $this->assertTrue(is_array($allocateZoneImpressions->aAdZoneAssociations[1][2]));
        $this->assertTrue(!empty($allocateZoneImpressions->aAdZoneAssociations[1][2]));
        $this->assertTrue(isset($allocateZoneImpressions->aAdZoneAssociations[1][2][0]));
        $this->assertTrue(is_array($allocateZoneImpressions->aAdZoneAssociations[1][2][0]));
        $this->assertTrue(!empty($allocateZoneImpressions->aAdZoneAssociations[1][2][0]));
        $this->assertTrue(isset($allocateZoneImpressions->aAdZoneAssociations[1][2][0]['zone_id']));
        $this->assertEqual($allocateZoneImpressions->aAdZoneAssociations[1][2][0]['zone_id'], 5);
    }

}

?>
