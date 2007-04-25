<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
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

require_once MAX_PATH . '/plugins/reports/publisher/channelAvailability.plugin.php';

/**
 * A class for testing the Plugins_Reports_Publisher_ChannelAvailability class.
 *
 * @package    MaxPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Plugins_TestOfPlugins_Reports_Publisher_ChannelAvailability extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Plugins_TestOfPlugins_Reports_Publisher_ChannelAvailability()
    {
        $this->UnitTestCase();
        Mock::generate('MAX_Dal_Entities');
        Mock::generate('MAX_Dal_Statistics');
        Mock::generate('OA_Dal_Maintenance_Priority');
        Mock::generate('MAX_Dal_Reporting_Proprietary');
        Mock::generatePartial(
            'Plugins_Reports_Publisher_ChannelAvailability',
            'MockPartialPlugins_Reports_Publisher_ChannelAvailability',
            array('_getAdLimitationType')
        );
    }

    /**
     * A method run before all tests. Creates default mock data access
     * layer objects, and registers then with the service locator.
     */
    function setUp()
    {
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oMaxDalStatistics = new MockMAX_Dal_Statistics($this);
        $oServiceLocator->register('MAX_Dal_Statistics', $oMaxDalStatistics);
        $oMaxDalMaintenancePriority = new MockOA_Dal_Maintenance_Priority($this);
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oMaxDalMaintenancePriority);
        $MaxDalReportingProprietary = new MockMAX_Dal_Reporting_Proprietary($this);
        $oServiceLocator->register('MAX_Dal_Reporting_Proprietary', $MaxDalReportingProprietary);
    }

    /**
     * A method run after all tests. Removes mocked data access layer
     * objects from the service locator.
     */
    function tearDown()
    {
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->remove('MAX_Dal_Entities');
        $oServiceLocator->remove('MAX_Dal_Statistics');
        $oServiceLocator->remove('OA_Dal_Maintenance_Priority');
        $oServiceLocator->remove('MAX_Dal_Reporting_Proprietary');
    }

    /**
     * A method to test the _setZones() method.
     *
     * Requirements:
     * Test 1: Test with an empty array.
     * Test 2: Test with a set zone ID.
     */
    function test_setZones()
    {
        $oError = new PEAR_Error();

        // Test 1
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllZonesIdsByPublisherId', $oError);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllZonesIdsByPublisherId', array(2));
        $oMaxDalEntities->expectCallCount('getAllZonesIdsByPublisherId', 1);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->publisherId = 2;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aZoneDetails);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_setZones(array());
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aZoneIds, $oError);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aZoneDetails);
        $this->assertEqual($oPlugin->error, 'Error retrieving zones IDs for publisher ID 2.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();

        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllZonesIdsByPublisherId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllZonesIdsByPublisherId', array(2));
        $oMaxDalEntities->expectCallCount('getAllZonesIdsByPublisherId', 1);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->publisherId = 2;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aZoneDetails);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_setZones(array());
        $this->assertFalse($result);
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aZoneDetails);
        $this->assertEqual($oPlugin->error, 'Publisher ID 2 does not have any zones.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();

        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllZonesIdsByPublisherId', array(1, 2, 3));
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllZonesIdsByPublisherId', array(2));
        $oMaxDalEntities->expectCallCount('getAllZonesIdsByPublisherId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', $oError);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array(array(1, 2, 3)));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->publisherId = 2;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aZoneDetails);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_setZones(array());
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aZoneIds, array(1, 2, 3));
        $this->assertEqual($oPlugin->zoneName, 'All Zones');
        $this->assertEqual($oPlugin->aZoneDetails, $oError);
        $this->assertEqual($oPlugin->error, 'Error retrieving zones details for zone IDs 1, 2, 3.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();

        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllZonesIdsByPublisherId', array(1, 2, 3));
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllZonesIdsByPublisherId', array(2));
        $oMaxDalEntities->expectCallCount('getAllZonesIdsByPublisherId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array(array(1, 2, 3)));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->publisherId = 2;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aZoneDetails);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_setZones(array());
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aZoneIds, array(1, 2, 3));
        $this->assertEqual($oPlugin->zoneName, 'All Zones');
        $this->assertNull($oPlugin->aZoneDetails);
        $this->assertEqual($oPlugin->error, 'Error retrieving zones details for zone IDs 1, 2, 3.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();

        $aZoneDetails = array(
            1 => array(
                'zonename' => 'Zone ID 1'
            ),
            2 => array(
                'zonename' => 'Zone ID 2'
            ),
            3 => array(
                'zonename' => 'Zone ID 3'
            )
        );
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllZonesIdsByPublisherId', array(1, 2, 3));
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllZonesIdsByPublisherId', array(2));
        $oMaxDalEntities->expectCallCount('getAllZonesIdsByPublisherId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', $aZoneDetails);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array(array(1, 2, 3)));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->publisherId = 2;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aZoneDetails);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_setZones(array());
        $this->assertTrue($result);
        $this->assertEqual($oPlugin->aZoneIds, array(1, 2, 3));
        $this->assertEqual($oPlugin->zoneName, 'All Zones');
        $this->assertEqual($oPlugin->aZoneDetails, $aZoneDetails);
        $this->assertNull($oPlugin->error);
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();

        // Test 2
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', $oError);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array(array(1)));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->publisherId = 2;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_setZones(array(1));
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aZoneIds, array(1));
        $this->assertNull($oPlugin->zoneName);
        $this->assertEqual($oPlugin->error, 'Error retrieving zone information for zone IDs 1.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();

        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array(array(1)));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->publisherId = 2;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_setZones(array(1));
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aZoneIds, array(1));
        $this->assertNull($oPlugin->zoneName);
        $this->assertEqual($oPlugin->error, 'Zone IDs 1 had no information.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();

        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', array(1 => array('zonename' => 'Zone Name')));
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array(array(1)));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->publisherId = 2;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_setZones(array(1));
        $this->assertTrue($result);
        $this->assertEqual($oPlugin->aZoneIds, array(1));
        $this->assertEqual($oPlugin->zoneName, 'Zone Name');
        $this->assertNull($oPlugin->error);
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();
    }

    /**
     * A method to test the _setPlacementAds() method.
     *
     * Requirements:
     * Test 1: Test with no active parent placements, ensure nothing set.
     * Test 2: Test with no childred ads, ensure only placements set.
     * Test 3: Test with active parent placements, and ensure values are set.
     */
    function test_setPlacementAds()
    {
        $oError = new PEAR_Error();
        $aAdIds = array(1, 2, 3);
        $aPeriod = array(
            'start' => new Date('2006-12-01'),
            'end'   => new Date('2006-12-31')
        );
        $aPlacements = array(
            1 => array(
                'placement_id'            => 1,
                'placement_name'          => 'Placement 1',
                'active'                  => 't',
                'weight'                  => 1,
                'placement_start'         => '0000-00-00',
                'placement_end'           => '0000-00-00',
                'priority'                => 5,
                'impression_target_total' => 1000000,
                'click_target_total'      => -1,
                'conversion_target_total' => -1,
                'impression_target_daily' => -1,
                'click_target_daily'      => -1,
                'conversion_target_daily' => -1
            ),
            2 => array(
                'placement_id'            => 1,
                'placement_name'          => 'Placement 1',
                'active'                  => 't',
                'weight'                  => 1,
                'placement_start'         => '0000-00-00',
                'placement_end'           => '0000-00-00',
                'priority'                => 5,
                'impression_target_total' => 1000000,
                'click_target_total'      => -1,
                'conversion_target_total' => -1,
                'impression_target_daily' => -1,
                'click_target_daily'      => -1,
                'conversion_target_daily' => -1
            ),
            3 => array(
                'placement_id'            => 5,
                'placement_name'          => 'Placement 3',
                'active'                  => 't',
                'weight'                  => 1,
                'placement_start'         => '0000-00-00',
                'placement_end'           => '0000-00-00',
                'priority'                => -1,
                'impression_target_total' => 1000000,
                'click_target_total'      => -1,
                'conversion_target_total' => -1,
                'impression_target_daily' => -1,
                'click_target_daily'      => -1,
                'conversion_target_daily' => -1
            )
        );
        $aPlacementAds = array(
            1 => array(
                1 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                ),
                2 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                )
            ),
            5 => array(
                3 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                ),
                4 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                )
            )
        );

        // Test 1
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActivePlacementsByAdIdsPeriod', $oError);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActivePlacementsByAdIdsPeriod', array($aAdIds, $aPeriod));
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 1);
        $oMaxDalEntities->expectNever('getAllActiveAdsDeliveryLimitationsByPlacementIds');
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->aAdIds = $aAdIds;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_setPlacementAds();
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aPlacements, $oError);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertEqual($oPlugin->error, 'Error retrieving parent placements for ads.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();

        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActivePlacementsByAdIdsPeriod', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActivePlacementsByAdIdsPeriod', array($aAdIds, $aPeriod));
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 1);
        $oMaxDalEntities->expectNever('getAllActiveAdsDeliveryLimitationsByPlacementIds');
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->aAdIds = $aAdIds;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_setPlacementAds();
        $this->assertFalse($result);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertEqual($oPlugin->error, 'Error retrieving parent placements for ads.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();

        // Test 2
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActivePlacementsByAdIdsPeriod', $aPlacements);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActivePlacementsByAdIdsPeriod', array($aAdIds, $aPeriod));
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', $oError);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', array(array(1, 5)));
        $oMaxDalEntities->expectCallCount('getAllActiveAdsDeliveryLimitationsByPlacementIds', 1);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->aAdIds = $aAdIds;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_setPlacementAds();
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aPlacements, $aPlacements);
        $this->assertEqual($oPlugin->aPlacementAds, $oError);
        $this->assertEqual($oPlugin->error, 'Error retrieving placement details, ads and delivery limitations.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();

        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActivePlacementsByAdIdsPeriod', $aPlacements);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActivePlacementsByAdIdsPeriod', array($aAdIds, $aPeriod));
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', array(array(1, 5)));
        $oMaxDalEntities->expectCallCount('getAllActiveAdsDeliveryLimitationsByPlacementIds', 1);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->aAdIds = $aAdIds;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_setPlacementAds();
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aPlacements, $aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertEqual($oPlugin->error, 'Error retrieving placement details, ads and delivery limitations.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();

        // Test 3
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActivePlacementsByAdIdsPeriod', $aPlacements);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActivePlacementsByAdIdsPeriod', array($aAdIds, $aPeriod));
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', $aPlacementAds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', array(array(1, 5)));
        $oMaxDalEntities->expectCallCount('getAllActiveAdsDeliveryLimitationsByPlacementIds', 1);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->aAdIds = $aAdIds;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_setPlacementAds();
        $this->assertTrue($result);
        $this->assertEqual($oPlugin->aPlacements, $aPlacements);
        $this->assertEqual($oPlugin->aPlacementAds, $aPlacementAds);
        $this->assertNull($oPlugin->error);
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();
    }

    /**
     * A method to test the _setAdZoneLinks() method.
     *
     * Requirements:
     * Test 1: Test with no placements/ads, and ensure no links set.
     * Test 2: Test with no ad/zone links, and ensure no values set.
     * Test 3: Test with ad/zone links, and ensure values are set.
     */
    function test_setAdZoneLinks()
    {
        $oError = new PEAR_Error();
        $aPlacementAds = array(
            1 => array(
                1 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                ),
                2 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                )
            ),
            5 => array(
                3 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                ),
                4 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                )
            )
        );
        $aAdZoneIds = array(
            1 => array(1, 2),
            2 => array(1, 2),
            3 => array(1, 2),
            4 => array(2)
        );

        // Test 1
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->expectNever('getLinkedZonesIdsByAdIds');
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_setAdZoneLinks();
        $this->assertFalse($result);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->error);
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();

        // Test 2
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedZonesIdsByAdIds', $oError);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedZonesIdsByAdIds', array(array(1, 2, 3, 4)));
        $oMaxDalEntities->expectCallCount('getLinkedZonesIdsByAdIds', 1);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->error);
        $oPlugin->aPlacementAds = $aPlacementAds;
        $result = $oPlugin->_setAdZoneLinks();
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aAdZoneIds, $oError);
        $this->assertEqual($oPlugin->error, 'Error retrieving ad/zone links.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();

        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedZonesIdsByAdIds', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedZonesIdsByAdIds', array(array(1, 2, 3, 4)));
        $oMaxDalEntities->expectCallCount('getLinkedZonesIdsByAdIds', 1);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->error);
        $oPlugin->aPlacementAds = $aPlacementAds;
        $result = $oPlugin->_setAdZoneLinks();
        $this->assertFalse($result);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertEqual($oPlugin->error, 'Error retrieving ad/zone links.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();

        // Test 3
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedZonesIdsByAdIds', $aAdZoneIds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedZonesIdsByAdIds', array(array(1, 2, 3, 4)));
        $oMaxDalEntities->expectCallCount('getLinkedZonesIdsByAdIds', 1);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->error);
        $oPlugin->aPlacementAds = $aPlacementAds;
        $result = $oPlugin->_setAdZoneLinks();
        $this->assertTrue($result);
        $this->assertEqual($oPlugin->aAdZoneIds, $aAdZoneIds);
        $this->assertNull($oPlugin->error);
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();
    }

    /**
     * A method to test the _prepareRawData() method.
     *
     * Doesn't bother mocking private methods called within the class,
     * even though they are tested above, for simplicity.
     *
     * Requirements:
     * Test 1:  Test specific zone, error on getting zone information.
     * Test 2:  Test specific zone, but with no zone information.
     * Test 3:  Test specific zone, with zone information, error on getting channel
     *          forecast data.
     * Test 4:  Test specific zone, with zone information, no channel forecast data.
     *
     * Test 5:  Test specific zone, with zone information, channel forecast data,
     *          error on getting ad/zone links.
     * Test 6:  Test specific zone, with zone information, channel forecast data,
     *          no ad/zone links.
     * Test 7:  Test specific zone, with zone information, channel forecast data,
     *          ad/zone links, error on getting parent placements.
     * Test 8:  Test specific zone, with zone information, channel forecast data,
     *          ad/zone links, no parent placements.
     * Test 9:  Test specific zone, with zone information, channel forecast data,
     *          ad/zone links, parent placements, error on getting placement ads.
     * Test 10: Test specific zone, with zone information, channel forecast data,
     *          ad/zone links, parent placements, no placement ads.
     * Test 11: Test specific zone, with zone information, channel forecast data,
     *          ad/zone links, parent placements, placement ads, error getting
     *          ad/zone links.
     * Test 12: Test specific zone, with zone information, channel forecast data,
     *          ad/zone links, parent placements, placement ads, no ad/zone links.
     * Test 13: Test specific zone, with zone information, channel forecast data,
     *          ad/zone links, parent placements, placement ads, ad/zone links,
     *          error on getting zone forecast data.
     * Test 14: Test specific zone, with zone information, channel forecast data,
     *          ad/zone links, parent placements, placement ads, ad/zone links,
     *          no zone forecast data.
     * Test 15: Test specific zone, with zone information, channel forecast data,
     *          ad/zone links, parent placements, placement ads, ad/zone links,
     *          zone forecast data, error setting the channel limitation.
     * Test 16: Test specific zone, with zone information, channel forecast data,
     *          ad/zone links, parent placements, placement ads, ad/zone links,
     *          zone forecast data, channel limitation set.
     */
    function test_prepareRawData()
    {
        $oError = new PEAR_Error();
        $aZoneIds = array(1);
        $aZoneInfo = array(
            1 => array(
                'zonename' => 'Test Zone'
            )
        );
        $aPeriod = array(
            'start' => new Date('2006-11-01'),
            'end'   => new Date('2006-11-03')
        );
        $aChannelForecastDaily = array(
            1 => array(
                '2006-11-01' => array(
                    'impressions' => 50,
                    'clicks'      => 1
                ),
                '2006-11-02' => array(
                    'impressions' => 50,
                    'clicks'      => 1
                ),
                '2006-11-03' => array(
                    'impressions' => 50,
                    'clicks'      => 1
                )
            )
        );
        $aAverageZoneForecasts = array(
            1 => 500
        );
        $aZoneAdIds = array(
            1 => array(1, 2, 3)
        );
        $aAdIds = array(
            1 => 1,
            2 => 2,
            3 => 3
        );
        $aPlacements = array(
            1 => array(
                'placement_id'            => 1,
                'placement_name'          => 'Placement 1',
                'active'                  => 't',
                'weight'                  => 1,
                'placement_start'         => '0000-00-00',
                'placement_end'           => '0000-00-00',
                'priority'                => 5,
                'impression_target_total' => 1000000,
                'click_target_total'      => -1,
                'conversion_target_total' => -1,
                'impression_target_daily' => -1,
                'click_target_daily'      => -1,
                'conversion_target_daily' => -1
            ),
            2 => array(
                'placement_id'            => 1,
                'placement_name'          => 'Placement 1',
                'active'                  => 't',
                'weight'                  => 1,
                'placement_start'         => '0000-00-00',
                'placement_end'           => '0000-00-00',
                'priority'                => 5,
                'impression_target_total' => 1000000,
                'click_target_total'      => -1,
                'conversion_target_total' => -1,
                'impression_target_daily' => -1,
                'click_target_daily'      => -1,
                'conversion_target_daily' => -1
            ),
            3 => array(
                'placement_id'            => 5,
                'placement_name'          => 'Placement 3',
                'active'                  => 't',
                'weight'                  => 1,
                'placement_start'         => '0000-00-00',
                'placement_end'           => '0000-00-00',
                'priority'                => -1,
                'impression_target_total' => 1000000,
                'click_target_total'      => -1,
                'conversion_target_total' => -1,
                'impression_target_daily' => -1,
                'click_target_daily'      => -1,
                'conversion_target_daily' => -1
            )
        );
        $aPlacementAds = array(
            1 => array(
                1 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                ),
                2 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                )
            ),
            5 => array(
                3 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                ),
                4 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                )
            )
        );
        $aAdZoneIds = array(
            1 => array(1, 2),
            2 => array(1, 2),
            3 => array(1, 2),
            4 => array(2)
        );
        $aZoneIdsFromAds = array(1, 2);
        $aChannelLimitationData = array(
            0 => array(
                'logical'    => 'and',
                'type'       => 'Time:Hour',
                'comparison' => '=~',
                'data'       => 12
            )
        );

        // Test 1
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', $oError);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oMaxDalEntities->expectCallCount('getLinkedActiveAdIdsByZoneIds', 0);
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 0);
        $oMaxDalEntities->expectCallCount('getAllActiveAdsDeliveryLimitationsByPlacementIds', 0);
        $oMaxDalEntities->expectCallCount('getLinkedZonesIdsByAdIds', 0);
        $oMaxDalEntities->expectCallCount('getDeliveryLimitationsByChannelId', 0);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oMaxDalStatistics = new MockMAX_Dal_Statistics($this);
        $oMaxDalStatistics->expectCallCount('getChannelDailyInventoryForecastByChannelZoneIds', 0);
        $oMaxDalStatistics->expectCallCount('getRecentAverageZoneForecastByZoneIds', 0);
        $oServiceLocator->register('MAX_Dal_Statistics', $oMaxDalStatistics);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->channelId = 1;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aChannelForecastsDaily);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_prepareRawData($aZoneIds);
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aZoneIds, $aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aChannelForecastsDaily);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertEqual($oPlugin->error, 'Error retrieving zone information for zone IDs 1.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();
        $oMaxDalStatistics = &$oServiceLocator->get('MAX_Dal_Statistics');
        $oMaxDalStatistics->tally();

        // Test 2
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oMaxDalEntities->expectCallCount('getLinkedActiveAdIdsByZoneIds', 0);
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 0);
        $oMaxDalEntities->expectCallCount('getAllActiveAdsDeliveryLimitationsByPlacementIds', 0);
        $oMaxDalEntities->expectCallCount('getLinkedZonesIdsByAdIds', 0);
        $oMaxDalEntities->expectCallCount('getDeliveryLimitationsByChannelId', 0);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oMaxDalStatistics = new MockMAX_Dal_Statistics($this);
        $oMaxDalStatistics->expectCallCount('getChannelDailyInventoryForecastByChannelZoneIds', 0);
        $oMaxDalStatistics->expectCallCount('getRecentAverageZoneForecastByZoneIds', 0);
        $oServiceLocator->register('MAX_Dal_Statistics', $oMaxDalStatistics);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->channelId = 1;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aChannelForecastsDaily);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_prepareRawData($aZoneIds);
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aZoneIds, $aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aChannelForecastsDaily);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertEqual($oPlugin->error, 'Zone IDs 1 had no information.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();
        $oMaxDalStatistics = &$oServiceLocator->get('MAX_Dal_Statistics');
        $oMaxDalStatistics->tally();

        // Test 3
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', $aZoneInfo);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oMaxDalEntities->expectCallCount('getLinkedActiveAdIdsByZoneIds', 0);
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 0);
        $oMaxDalEntities->expectCallCount('getAllActiveAdsDeliveryLimitationsByPlacementIds', 0);
        $oMaxDalEntities->expectCallCount('getLinkedZonesIdsByAdIds', 0);
        $oMaxDalEntities->expectCallCount('getDeliveryLimitationsByChannelId', 0);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oMaxDalStatistics = new MockMAX_Dal_Statistics($this);
        $oMaxDalStatistics->setReturnValueAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', $oError);
        $oMaxDalStatistics->expectArgumentsAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', array(1, $aZoneIds, $aPeriod, true));
        $oMaxDalStatistics->expectCallCount('getChannelDailyInventoryForecastByChannelZoneIds', 1);
        $oMaxDalStatistics->expectCallCount('getRecentAverageZoneForecastByZoneIds', 0);
        $oServiceLocator->register('MAX_Dal_Statistics', $oMaxDalStatistics);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->channelId = 1;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aChannelForecastsDaily);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_prepareRawData($aZoneIds);
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aZoneIds, $aZoneIds);
        $this->assertEqual($oPlugin->zoneName, 'Test Zone');
        $this->assertEqual($oPlugin->aChannelForecastsDaily, $oError);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertEqual($oPlugin->error, 'Error retrieving channel/zone inventory forecasts.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();
        $oMaxDalStatistics = &$oServiceLocator->get('MAX_Dal_Statistics');
        $oMaxDalStatistics->tally();

        // Test 4
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', $aZoneInfo);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oMaxDalEntities->expectCallCount('getLinkedActiveAdIdsByZoneIds', 0);
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 0);
        $oMaxDalEntities->expectCallCount('getAllActiveAdsDeliveryLimitationsByPlacementIds', 0);
        $oMaxDalEntities->expectCallCount('getLinkedZonesIdsByAdIds', 0);
        $oMaxDalEntities->expectCallCount('getDeliveryLimitationsByChannelId', 0);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oMaxDalStatistics = new MockMAX_Dal_Statistics($this);
        $oMaxDalStatistics->setReturnValueAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', null);
        $oMaxDalStatistics->expectArgumentsAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', array(1, $aZoneIds, $aPeriod, true));
        $oMaxDalStatistics->expectCallCount('getChannelDailyInventoryForecastByChannelZoneIds', 1);
        $oMaxDalStatistics->expectCallCount('getRecentAverageZoneForecastByZoneIds', 0);
        $oServiceLocator->register('MAX_Dal_Statistics', $oMaxDalStatistics);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->channelId = 1;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aChannelForecastsDaily);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_prepareRawData($aZoneIds);
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aZoneIds, $aZoneIds);
        $this->assertEqual($oPlugin->zoneName, 'Test Zone');
        $this->assertNull($oPlugin->aChannelForecastsDaily);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertEqual($oPlugin->error, 'No channel/zone inventory forecast data found.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();
        $oMaxDalStatistics = &$oServiceLocator->get('MAX_Dal_Statistics');
        $oMaxDalStatistics->tally();

        // Test 5
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', $aZoneInfo);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedActiveAdIdsByZoneIds', $oError);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedActiveAdIdsByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getLinkedActiveAdIdsByZoneIds', 1);
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 0);
        $oMaxDalEntities->expectCallCount('getAllActiveAdsDeliveryLimitationsByPlacementIds', 0);
        $oMaxDalEntities->expectCallCount('getLinkedZonesIdsByAdIds', 0);
        $oMaxDalEntities->expectCallCount('getDeliveryLimitationsByChannelId', 0);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oMaxDalStatistics = new MockMAX_Dal_Statistics($this);
        $oMaxDalStatistics->setReturnValueAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', $aChannelForecastDaily);
        $oMaxDalStatistics->expectArgumentsAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', array(1, $aZoneIds, $aPeriod, true));
        $oMaxDalStatistics->expectCallCount('getChannelDailyInventoryForecastByChannelZoneIds', 1);
        $oMaxDalStatistics->expectCallCount('getRecentAverageZoneForecastByZoneIds', 0);
        $oServiceLocator->register('MAX_Dal_Statistics', $oMaxDalStatistics);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->channelId = 1;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aChannelForecastsDaily);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_prepareRawData($aZoneIds);
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aZoneIds, $aZoneIds);
        $this->assertEqual($oPlugin->zoneName, 'Test Zone');
        $this->assertEqual($oPlugin->aChannelForecastsDaily, $aChannelForecastDaily);
        $this->assertEqual($oPlugin->aZoneAdIds, $oError);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertEqual($oPlugin->error, 'Error retrieving ads linked to zone IDs 1.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();
        $oMaxDalStatistics = &$oServiceLocator->get('MAX_Dal_Statistics');
        $oMaxDalStatistics->tally();

        // Test 6
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', $aZoneInfo);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedActiveAdIdsByZoneIds', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedActiveAdIdsByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getLinkedActiveAdIdsByZoneIds', 1);
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 0);
        $oMaxDalEntities->expectCallCount('getAllActiveAdsDeliveryLimitationsByPlacementIds', 0);
        $oMaxDalEntities->expectCallCount('getLinkedZonesIdsByAdIds', 0);
        $oMaxDalEntities->expectCallCount('getDeliveryLimitationsByChannelId', 0);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oMaxDalStatistics = new MockMAX_Dal_Statistics($this);
        $oMaxDalStatistics->setReturnValueAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', $aChannelForecastDaily);
        $oMaxDalStatistics->expectArgumentsAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', array(1, $aZoneIds, $aPeriod, true));
        $oMaxDalStatistics->expectCallCount('getChannelDailyInventoryForecastByChannelZoneIds', 1);
        $oMaxDalStatistics->expectCallCount('getRecentAverageZoneForecastByZoneIds', 0);
        $oServiceLocator->register('MAX_Dal_Statistics', $oMaxDalStatistics);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->channelId = 1;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aChannelForecastsDaily);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_prepareRawData($aZoneIds);
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aZoneIds, $aZoneIds);
        $this->assertEqual($oPlugin->zoneName, 'Test Zone');
        $this->assertEqual($oPlugin->aChannelForecastsDaily, $aChannelForecastDaily);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertEqual($oPlugin->error, 'No ads found linked to zone IDs 1.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();
        $oMaxDalStatistics = &$oServiceLocator->get('MAX_Dal_Statistics');
        $oMaxDalStatistics->tally();

        // Test 7
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', $aZoneInfo);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedActiveAdIdsByZoneIds', $aZoneAdIds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedActiveAdIdsByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getLinkedActiveAdIdsByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActivePlacementsByAdIdsPeriod', $oError);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActivePlacementsByAdIdsPeriod', array($aAdIds, $aPeriod));
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 1);
        $oMaxDalEntities->expectCallCount('getAllActiveAdsDeliveryLimitationsByPlacementIds', 0);
        $oMaxDalEntities->expectCallCount('getLinkedZonesIdsByAdIds', 0);
        $oMaxDalEntities->expectCallCount('getDeliveryLimitationsByChannelId', 0);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oMaxDalStatistics = new MockMAX_Dal_Statistics($this);
        $oMaxDalStatistics->setReturnValueAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', $aChannelForecastDaily);
        $oMaxDalStatistics->expectArgumentsAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', array(1, $aZoneIds, $aPeriod, true));
        $oMaxDalStatistics->expectCallCount('getChannelDailyInventoryForecastByChannelZoneIds', 1);
        $oMaxDalStatistics->expectCallCount('getRecentAverageZoneForecastByZoneIds', 0);
        $oServiceLocator->register('MAX_Dal_Statistics', $oMaxDalStatistics);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->channelId = 1;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aChannelForecastsDaily);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_prepareRawData($aZoneIds);
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aZoneIds, $aZoneIds);
        $this->assertEqual($oPlugin->zoneName, 'Test Zone');
        $this->assertEqual($oPlugin->aChannelForecastsDaily, $aChannelForecastDaily);
        $this->assertEqual($oPlugin->aZoneAdIds, $aZoneAdIds);
        $this->assertEqual($oPlugin->aAdIds, $aAdIds);
        $this->assertEqual($oPlugin->aPlacements, $oError);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertEqual($oPlugin->error, 'Error retrieving parent placements for ads.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();
        $oMaxDalStatistics = &$oServiceLocator->get('MAX_Dal_Statistics');
        $oMaxDalStatistics->tally();

        // Test 8
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', $aZoneInfo);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedActiveAdIdsByZoneIds', $aZoneAdIds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedActiveAdIdsByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getLinkedActiveAdIdsByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActivePlacementsByAdIdsPeriod', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActivePlacementsByAdIdsPeriod', array($aAdIds, $aPeriod));
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 1);
        $oMaxDalEntities->expectCallCount('getAllActiveAdsDeliveryLimitationsByPlacementIds', 0);
        $oMaxDalEntities->expectCallCount('getLinkedZonesIdsByAdIds', 0);
        $oMaxDalEntities->expectCallCount('getDeliveryLimitationsByChannelId', 0);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oMaxDalStatistics = new MockMAX_Dal_Statistics($this);
        $oMaxDalStatistics->setReturnValueAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', $aChannelForecastDaily);
        $oMaxDalStatistics->expectArgumentsAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', array(1, $aZoneIds, $aPeriod, true));
        $oMaxDalStatistics->expectCallCount('getChannelDailyInventoryForecastByChannelZoneIds', 1);
        $oMaxDalStatistics->expectCallCount('getRecentAverageZoneForecastByZoneIds', 0);
        $oServiceLocator->register('MAX_Dal_Statistics', $oMaxDalStatistics);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->channelId = 1;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aChannelForecastsDaily);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_prepareRawData($aZoneIds);
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aZoneIds, $aZoneIds);
        $this->assertEqual($oPlugin->zoneName, 'Test Zone');
        $this->assertEqual($oPlugin->aChannelForecastsDaily, $aChannelForecastDaily);
        $this->assertEqual($oPlugin->aZoneAdIds, $aZoneAdIds);
        $this->assertEqual($oPlugin->aAdIds, $aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertEqual($oPlugin->error, 'Error retrieving parent placements for ads.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();
        $oMaxDalStatistics = &$oServiceLocator->get('MAX_Dal_Statistics');
        $oMaxDalStatistics->tally();

        // Test 9
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', $aZoneInfo);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedActiveAdIdsByZoneIds', $aZoneAdIds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedActiveAdIdsByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getLinkedActiveAdIdsByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActivePlacementsByAdIdsPeriod', $aPlacements);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActivePlacementsByAdIdsPeriod', array($aAdIds, $aPeriod));
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', $oError);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', array(array(1, 5)));
        $oMaxDalEntities->expectCallCount('getAllActiveAdsDeliveryLimitationsByPlacementIds', 1);
        $oMaxDalEntities->expectCallCount('getLinkedZonesIdsByAdIds', 0);
        $oMaxDalEntities->expectCallCount('getDeliveryLimitationsByChannelId', 0);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oMaxDalStatistics = new MockMAX_Dal_Statistics($this);
        $oMaxDalStatistics->setReturnValueAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', $aChannelForecastDaily);
        $oMaxDalStatistics->expectArgumentsAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', array(1, $aZoneIds, $aPeriod, true));
        $oMaxDalStatistics->expectCallCount('getChannelDailyInventoryForecastByChannelZoneIds', 1);
        $oMaxDalStatistics->expectCallCount('getRecentAverageZoneForecastByZoneIds', 0);
        $oServiceLocator->register('MAX_Dal_Statistics', $oMaxDalStatistics);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->channelId = 1;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aChannelForecastsDaily);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_prepareRawData($aZoneIds);
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aZoneIds, $aZoneIds);
        $this->assertEqual($oPlugin->zoneName, 'Test Zone');
        $this->assertEqual($oPlugin->aChannelForecastsDaily, $aChannelForecastDaily);
        $this->assertEqual($oPlugin->aZoneAdIds, $aZoneAdIds);
        $this->assertEqual($oPlugin->aAdIds, $aAdIds);
        $this->assertEqual($oPlugin->aPlacements, $aPlacements);
        $this->assertEqual($oPlugin->aPlacementAds, $oError);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertEqual($oPlugin->error, 'Error retrieving placement details, ads and delivery limitations.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();
        $oMaxDalStatistics = &$oServiceLocator->get('MAX_Dal_Statistics');
        $oMaxDalStatistics->tally();

        // Test 10
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', $aZoneInfo);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedActiveAdIdsByZoneIds', $aZoneAdIds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedActiveAdIdsByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getLinkedActiveAdIdsByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActivePlacementsByAdIdsPeriod', $aPlacements);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActivePlacementsByAdIdsPeriod', array($aAdIds, $aPeriod));
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', array(array(1, 5)));
        $oMaxDalEntities->expectCallCount('getAllActiveAdsDeliveryLimitationsByPlacementIds', 1);
        $oMaxDalEntities->expectCallCount('getLinkedZonesIdsByAdIds', 0);
        $oMaxDalEntities->expectCallCount('getDeliveryLimitationsByChannelId', 0);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oMaxDalStatistics = new MockMAX_Dal_Statistics($this);
        $oMaxDalStatistics->setReturnValueAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', $aChannelForecastDaily);
        $oMaxDalStatistics->expectArgumentsAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', array(1, $aZoneIds, $aPeriod, true));
        $oMaxDalStatistics->expectCallCount('getChannelDailyInventoryForecastByChannelZoneIds', 1);
        $oMaxDalStatistics->expectCallCount('getRecentAverageZoneForecastByZoneIds', 0);
        $oServiceLocator->register('MAX_Dal_Statistics', $oMaxDalStatistics);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->channelId = 1;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aChannelForecastsDaily);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_prepareRawData($aZoneIds);
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aZoneIds, $aZoneIds);
        $this->assertEqual($oPlugin->zoneName, 'Test Zone');
        $this->assertEqual($oPlugin->aChannelForecastsDaily, $aChannelForecastDaily);
        $this->assertEqual($oPlugin->aZoneAdIds, $aZoneAdIds);
        $this->assertEqual($oPlugin->aAdIds, $aAdIds);
        $this->assertEqual($oPlugin->aPlacements, $aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertEqual($oPlugin->error, 'Error retrieving placement details, ads and delivery limitations.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();
        $oMaxDalStatistics = &$oServiceLocator->get('MAX_Dal_Statistics');
        $oMaxDalStatistics->tally();

        // Test 11
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', $aZoneInfo);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedActiveAdIdsByZoneIds', $aZoneAdIds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedActiveAdIdsByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getLinkedActiveAdIdsByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActivePlacementsByAdIdsPeriod', $aPlacements);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActivePlacementsByAdIdsPeriod', array($aAdIds, $aPeriod));
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', $aPlacementAds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', array(array(1, 5)));
        $oMaxDalEntities->expectCallCount('getAllActiveAdsDeliveryLimitationsByPlacementIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedZonesIdsByAdIds', $oError);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedZonesIdsByAdIds', array(array(1, 2, 3, 4)));
        $oMaxDalEntities->expectCallCount('getLinkedZonesIdsByAdIds', 1);
        $oMaxDalEntities->expectCallCount('getDeliveryLimitationsByChannelId', 0);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oMaxDalStatistics = new MockMAX_Dal_Statistics($this);
        $oMaxDalStatistics->setReturnValueAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', $aChannelForecastDaily);
        $oMaxDalStatistics->expectArgumentsAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', array(1, $aZoneIds, $aPeriod, true));
        $oMaxDalStatistics->expectCallCount('getChannelDailyInventoryForecastByChannelZoneIds', 1);
        $oMaxDalStatistics->expectCallCount('getRecentAverageZoneForecastByZoneIds', 0);
        $oServiceLocator->register('MAX_Dal_Statistics', $oMaxDalStatistics);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->channelId = 1;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aChannelForecastsDaily);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_prepareRawData($aZoneIds);
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aZoneIds, $aZoneIds);
        $this->assertEqual($oPlugin->zoneName, 'Test Zone');
        $this->assertEqual($oPlugin->aChannelForecastsDaily, $aChannelForecastDaily);
        $this->assertEqual($oPlugin->aZoneAdIds, $aZoneAdIds);
        $this->assertEqual($oPlugin->aAdIds, $aAdIds);
        $this->assertEqual($oPlugin->aPlacements, $aPlacements);
        $this->assertEqual($oPlugin->aPlacementAds, $aPlacementAds);
        $this->assertEqual($oPlugin->aAdZoneIds, $oError);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertEqual($oPlugin->error, 'Error retrieving ad/zone links.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();
        $oMaxDalStatistics = &$oServiceLocator->get('MAX_Dal_Statistics');
        $oMaxDalStatistics->tally();

        // Test 12
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', $aZoneInfo);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedActiveAdIdsByZoneIds', $aZoneAdIds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedActiveAdIdsByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getLinkedActiveAdIdsByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActivePlacementsByAdIdsPeriod', $aPlacements);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActivePlacementsByAdIdsPeriod', array($aAdIds, $aPeriod));
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', $aPlacementAds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', array(array(1, 5)));
        $oMaxDalEntities->expectCallCount('getAllActiveAdsDeliveryLimitationsByPlacementIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedZonesIdsByAdIds', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedZonesIdsByAdIds', array(array(1, 2, 3, 4)));
        $oMaxDalEntities->expectCallCount('getLinkedZonesIdsByAdIds', 1);
        $oMaxDalEntities->expectCallCount('getDeliveryLimitationsByChannelId', 0);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oMaxDalStatistics = new MockMAX_Dal_Statistics($this);
        $oMaxDalStatistics->setReturnValueAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', $aChannelForecastDaily);
        $oMaxDalStatistics->expectArgumentsAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', array(1, $aZoneIds, $aPeriod, true));
        $oMaxDalStatistics->expectCallCount('getChannelDailyInventoryForecastByChannelZoneIds', 1);
        $oMaxDalStatistics->expectCallCount('getRecentAverageZoneForecastByZoneIds', 0);
        $oServiceLocator->register('MAX_Dal_Statistics', $oMaxDalStatistics);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->channelId = 1;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aChannelForecastsDaily);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_prepareRawData($aZoneIds);
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aZoneIds, $aZoneIds);
        $this->assertEqual($oPlugin->zoneName, 'Test Zone');
        $this->assertEqual($oPlugin->aChannelForecastsDaily, $aChannelForecastDaily);
        $this->assertEqual($oPlugin->aZoneAdIds, $aZoneAdIds);
        $this->assertEqual($oPlugin->aAdIds, $aAdIds);
        $this->assertEqual($oPlugin->aPlacements, $aPlacements);
        $this->assertEqual($oPlugin->aPlacementAds, $aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertEqual($oPlugin->error, 'Error retrieving ad/zone links.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();
        $oMaxDalStatistics = &$oServiceLocator->get('MAX_Dal_Statistics');
        $oMaxDalStatistics->tally();

        // Test 13
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', $aZoneInfo);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedActiveAdIdsByZoneIds', $aZoneAdIds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedActiveAdIdsByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getLinkedActiveAdIdsByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActivePlacementsByAdIdsPeriod', $aPlacements);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActivePlacementsByAdIdsPeriod', array($aAdIds, $aPeriod));
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', $aPlacementAds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', array(array(1, 5)));
        $oMaxDalEntities->expectCallCount('getAllActiveAdsDeliveryLimitationsByPlacementIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedZonesIdsByAdIds', $aAdZoneIds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedZonesIdsByAdIds', array(array(1, 2, 3, 4)));
        $oMaxDalEntities->expectCallCount('getLinkedZonesIdsByAdIds', 1);
        $oMaxDalEntities->expectCallCount('getDeliveryLimitationsByChannelId', 0);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oMaxDalStatistics = new MockMAX_Dal_Statistics($this);
        $oMaxDalStatistics->setReturnValueAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', $aChannelForecastDaily);
        $oMaxDalStatistics->expectArgumentsAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', array(1, $aZoneIds, $aPeriod, true));
        $oMaxDalStatistics->expectCallCount('getChannelDailyInventoryForecastByChannelZoneIds', 1);
        $oMaxDalStatistics->setReturnValueAt(0, 'getRecentAverageZoneForecastByZoneIds', $oError);
        $oMaxDalStatistics->expectArgumentsAt(0, 'getRecentAverageZoneForecastByZoneIds', array($aZoneIdsFromAds));
        $oMaxDalStatistics->expectCallCount('getRecentAverageZoneForecastByZoneIds', 1);
        $oServiceLocator->register('MAX_Dal_Statistics', $oMaxDalStatistics);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->channelId = 1;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aChannelForecastsDaily);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_prepareRawData($aZoneIds);
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aZoneIds, $aZoneIds);
        $this->assertEqual($oPlugin->zoneName, 'Test Zone');
        $this->assertEqual($oPlugin->aChannelForecastsDaily, $aChannelForecastDaily);
        $this->assertEqual($oPlugin->aZoneAdIds, $aZoneAdIds);
        $this->assertEqual($oPlugin->aAdIds, $aAdIds);
        $this->assertEqual($oPlugin->aPlacements, $aPlacements);
        $this->assertEqual($oPlugin->aPlacementAds, $aPlacementAds);
        $this->assertEqual($oPlugin->aAdZoneIds, $aAdZoneIds);
        $this->assertEqual($oPlugin->aAverageZoneForecasts, $oError);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertEqual($oPlugin->error, 'Error retrieving zone inventory forecasts.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();
        $oMaxDalStatistics = &$oServiceLocator->get('MAX_Dal_Statistics');
        $oMaxDalStatistics->tally();

        // Test 14
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', $aZoneInfo);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedActiveAdIdsByZoneIds', $aZoneAdIds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedActiveAdIdsByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getLinkedActiveAdIdsByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActivePlacementsByAdIdsPeriod', $aPlacements);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActivePlacementsByAdIdsPeriod', array($aAdIds, $aPeriod));
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', $aPlacementAds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', array(array(1, 5)));
        $oMaxDalEntities->expectCallCount('getAllActiveAdsDeliveryLimitationsByPlacementIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedZonesIdsByAdIds', $aAdZoneIds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedZonesIdsByAdIds', array(array(1, 2, 3, 4)));
        $oMaxDalEntities->expectCallCount('getLinkedZonesIdsByAdIds', 1);
        $oMaxDalEntities->expectCallCount('getDeliveryLimitationsByChannelId', 0);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oMaxDalStatistics = new MockMAX_Dal_Statistics($this);
        $oMaxDalStatistics->setReturnValueAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', $aChannelForecastDaily);
        $oMaxDalStatistics->expectArgumentsAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', array(1, $aZoneIds, $aPeriod, true));
        $oMaxDalStatistics->expectCallCount('getChannelDailyInventoryForecastByChannelZoneIds', 1);
        $oMaxDalStatistics->setReturnValueAt(0, 'getRecentAverageZoneForecastByZoneIds', null);
        $oMaxDalStatistics->expectArgumentsAt(0, 'getRecentAverageZoneForecastByZoneIds', array($aZoneIdsFromAds));
        $oMaxDalStatistics->expectCallCount('getRecentAverageZoneForecastByZoneIds', 1);
        $oServiceLocator->register('MAX_Dal_Statistics', $oMaxDalStatistics);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->channelId = 1;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aChannelForecastsDaily);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_prepareRawData($aZoneIds);
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aZoneIds, $aZoneIds);
        $this->assertEqual($oPlugin->zoneName, 'Test Zone');
        $this->assertEqual($oPlugin->aChannelForecastsDaily, $aChannelForecastDaily);
        $this->assertEqual($oPlugin->aZoneAdIds, $aZoneAdIds);
        $this->assertEqual($oPlugin->aAdIds, $aAdIds);
        $this->assertEqual($oPlugin->aPlacements, $aPlacements);
        $this->assertEqual($oPlugin->aPlacementAds, $aPlacementAds);
        $this->assertEqual($oPlugin->aAdZoneIds, $aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertEqual($oPlugin->error, 'No zone inventory forecast data found.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();
        $oMaxDalStatistics = &$oServiceLocator->get('MAX_Dal_Statistics');
        $oMaxDalStatistics->tally();

        // Test 15
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', $aZoneInfo);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedActiveAdIdsByZoneIds', $aZoneAdIds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedActiveAdIdsByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getLinkedActiveAdIdsByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActivePlacementsByAdIdsPeriod', $aPlacements);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActivePlacementsByAdIdsPeriod', array($aAdIds, $aPeriod));
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', $aPlacementAds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', array(array(1, 5)));
        $oMaxDalEntities->expectCallCount('getAllActiveAdsDeliveryLimitationsByPlacementIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedZonesIdsByAdIds', $aAdZoneIds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedZonesIdsByAdIds', array(array(1, 2, 3, 4)));
        $oMaxDalEntities->expectCallCount('getLinkedZonesIdsByAdIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getDeliveryLimitationsByChannelId', false);
        $oMaxDalEntities->expectArgumentsAt(0, 'getDeliveryLimitationsByChannelId', array(1));
        $oMaxDalEntities->expectCallCount('getDeliveryLimitationsByChannelId', 1);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oMaxDalStatistics = new MockMAX_Dal_Statistics($this);
        $oMaxDalStatistics->setReturnValueAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', $aChannelForecastDaily);
        $oMaxDalStatistics->expectArgumentsAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', array(1, $aZoneIds, $aPeriod, true));
        $oMaxDalStatistics->expectCallCount('getChannelDailyInventoryForecastByChannelZoneIds', 1);
        $oMaxDalStatistics->setReturnValueAt(0, 'getRecentAverageZoneForecastByZoneIds', $aAverageZoneForecasts);
        $oMaxDalStatistics->expectArgumentsAt(0, 'getRecentAverageZoneForecastByZoneIds', array($aZoneIdsFromAds));
        $oMaxDalStatistics->expectCallCount('getRecentAverageZoneForecastByZoneIds', 1);
        $oServiceLocator->register('MAX_Dal_Statistics', $oMaxDalStatistics);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->channelId = 1;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aChannelForecastsDaily);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_prepareRawData($aZoneIds);
        $this->assertFalse($result);
        $this->assertEqual($oPlugin->aZoneIds, $aZoneIds);
        $this->assertEqual($oPlugin->zoneName, 'Test Zone');
        $this->assertEqual($oPlugin->aChannelForecastsDaily, $aChannelForecastDaily);
        $this->assertEqual($oPlugin->aZoneAdIds, $aZoneAdIds);
        $this->assertEqual($oPlugin->aAdIds, $aAdIds);
        $this->assertEqual($oPlugin->aPlacements, $aPlacements);
        $this->assertEqual($oPlugin->aPlacementAds, $aPlacementAds);
        $this->assertEqual($oPlugin->aAdZoneIds, $aAdZoneIds);
        $this->assertEqual($oPlugin->aAverageZoneForecasts, $aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertEqual($oPlugin->error, 'Error setting the overlap limitations for channel ID 1.');
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();
        $oMaxDalStatistics = &$oServiceLocator->get('MAX_Dal_Statistics');
        $oMaxDalStatistics->tally();

        // Test 16
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getZonesByZoneIds', $aZoneInfo);
        $oMaxDalEntities->expectArgumentsAt(0, 'getZonesByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getZonesByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedActiveAdIdsByZoneIds', $aZoneAdIds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedActiveAdIdsByZoneIds', array($aZoneIds));
        $oMaxDalEntities->expectCallCount('getLinkedActiveAdIdsByZoneIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActivePlacementsByAdIdsPeriod', $aPlacements);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActivePlacementsByAdIdsPeriod', array($aAdIds, $aPeriod));
        $oMaxDalEntities->expectCallCount('getAllActivePlacementsByAdIdsPeriod', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', $aPlacementAds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveAdsDeliveryLimitationsByPlacementIds', array(array(1, 5)));
        $oMaxDalEntities->expectCallCount('getAllActiveAdsDeliveryLimitationsByPlacementIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getLinkedZonesIdsByAdIds', $aAdZoneIds);
        $oMaxDalEntities->expectArgumentsAt(0, 'getLinkedZonesIdsByAdIds', array(array(1, 2, 3, 4)));
        $oMaxDalEntities->expectCallCount('getLinkedZonesIdsByAdIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getDeliveryLimitationsByChannelId', $aChannelLimitationData);
        $oMaxDalEntities->expectArgumentsAt(0, 'getDeliveryLimitationsByChannelId', array(1));
        $oMaxDalEntities->expectCallCount('getDeliveryLimitationsByChannelId', 1);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);
        $oMaxDalStatistics = new MockMAX_Dal_Statistics($this);
        $oMaxDalStatistics->setReturnValueAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', $aChannelForecastDaily);
        $oMaxDalStatistics->expectArgumentsAt(0, 'getChannelDailyInventoryForecastByChannelZoneIds', array(1, $aZoneIds, $aPeriod, true));
        $oMaxDalStatistics->expectCallCount('getChannelDailyInventoryForecastByChannelZoneIds', 1);
        $oMaxDalStatistics->setReturnValueAt(0, 'getRecentAverageZoneForecastByZoneIds', $aAverageZoneForecasts);
        $oMaxDalStatistics->expectArgumentsAt(0, 'getRecentAverageZoneForecastByZoneIds', array($aZoneIdsFromAds));
        $oMaxDalStatistics->expectCallCount('getRecentAverageZoneForecastByZoneIds', 1);
        $oServiceLocator->register('MAX_Dal_Statistics', $oMaxDalStatistics);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->channelId = 1;
        $oPlugin->aPeriod = $aPeriod;
        $this->assertNull($oPlugin->aZoneIds);
        $this->assertNull($oPlugin->zoneName);
        $this->assertNull($oPlugin->aChannelForecastsDaily);
        $this->assertNull($oPlugin->aZoneAdIds);
        $this->assertNull($oPlugin->aAdIds);
        $this->assertNull($oPlugin->aPlacements);
        $this->assertNull($oPlugin->aPlacementAds);
        $this->assertNull($oPlugin->aAdZoneIds);
        $this->assertNull($oPlugin->aAverageZoneForecasts);
        $this->assertNull($oPlugin->reportPeriodDays);
        $this->assertNull($oPlugin->error);
        $result = $oPlugin->_prepareRawData($aZoneIds);
        $this->assertTrue($result);
        $this->assertEqual($oPlugin->aZoneIds, $aZoneIds);
        $this->assertEqual($oPlugin->zoneName, 'Test Zone');
        $this->assertEqual($oPlugin->aChannelForecastsDaily, $aChannelForecastDaily);
        $this->assertEqual($oPlugin->aZoneAdIds, $aZoneAdIds);
        $this->assertEqual($oPlugin->aAdIds, $aAdIds);
        $this->assertEqual($oPlugin->aPlacements, $aPlacements);
        $this->assertEqual($oPlugin->aPlacementAds, $aPlacementAds);
        $this->assertEqual($oPlugin->aAdZoneIds, $aAdZoneIds);
        $this->assertEqual($oPlugin->aAverageZoneForecasts, $aAverageZoneForecasts);
        $this->assertEqual($oPlugin->reportPeriodDays, 3);
        $this->assertNull($oPlugin->error);
        $oMaxDalEntities = &$oServiceLocator->get('MAX_Dal_Entities');
        $oMaxDalEntities->tally();
        $oMaxDalStatistics = &$oServiceLocator->get('MAX_Dal_Statistics');
        $oMaxDalStatistics->tally();
    }

    /**
     * A method to test the _setChannelZoneInventoryForecasts() method.
     *
     * Requirements:
     * Test 1: Test that the daily channel forecasts are correctly converted
     *         into the report period forecasts.
     */
    function test_setChannelZoneInventoryForecasts()
    {
        $aDailyForecasts = array(
            1 => array(
                '2006-11-01' => 9000,
                '2006-11-02' => 9000,
                '2006-11-03' => 9000
            ),
            5 => array(
                '2006-11-01' => 12340,
                '2006-11-02' => 12340,
                '2006-11-03' => 12340
            ),
            7 => array(
                '2006-11-01' => 10,
                '2006-11-02' => 10,
                '2006-11-03' => 10
            )
        );
        $aPeriodForecasts = array(
            1 => 27000,
            5 => 37020
        );

        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->aChannelForecastsDaily = $aDailyForecasts;
        $oPlugin->threshold = 1000;
        $this->assertNull($oPlugin->aChannelForecastsPeriod);
        $oPlugin->_setChannelZoneInventoryForecasts();
        $this->assertEqual($oPlugin->aChannelForecastsPeriod, $aPeriodForecasts);
    }

    /**
     * A method to test the _setZoneInventoryForecasts() method.
     *
     * Requirements:
     * Test 1: Test that the average zone forecasts are correctly converted
     *         into the report period forecasts.
     */
    function test_setZoneInventoryForecasts()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['maintenance']['operationInterval'] = 60;
        $aAverageZoneForecasts = array(
            1 => 5000,
            5 => 1200,
            7 => 50
        );
        $aZoneForecasts = array(
            1 => 3600000,
            5 => 864000,
            7 => 36000
        );

        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->aAverageZoneForecasts = $aAverageZoneForecasts;
        $oPlugin->reportPeriodDays = 30;
        $this->assertNull($oPlugin->aZoneForecastsPeriod);
        $oPlugin->_setZoneInventoryForecasts();
        $this->assertEqual($oPlugin->aZoneForecastsPeriod, $aZoneForecasts);

        TestEnv::restoreConfig();
    }

    /**
     * A method to test the _getPlacementRunFraction() method.
     *
     * Requirements:
     * Test 1: Test with a placement with a start and end date inside the report period,
     *         and ensure 1 is returned.
     * Test 2: Test with a placement with a start date before the report period, but an
     *         end date inside the report period, and ensure the correct fraction is
     *         returned.
     * Test 3: Test with a placement with a start date inside the report period, but an
     *         end date after the report period, and ensure the correct fraction is
     *         returned.
     * Test 4: Test with a placement with a start date before the report period, and an
     *         end date after the report period, and ensure the correct fraction is
     *         returned.
     * Test 5: Test with no start date.
     * Test 6: Test with no end date.
     */
    function test_getPlacementRunFraction()
    {
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->aPeriod = array(
            'start' => new Date('2006-11-01'),
            'end'   => new Date('2006-11-30')
        );

        // Test 1
        $aPlacement = array(
            'placement_id'    => 1,
            'placement_start' => '2006-11-02',
            'placement_end'   => '2006-11-29'
        );
        $result = $oPlugin->_getPlacementRunFraction($aPlacement);
        $this->assertEqual($result, 1);

        $aPlacement = array(
            'placement_id'    => 1,
            'placement_start' => '2006-11-01',
            'placement_end'   => '2006-11-30'
        );
        $result = $oPlugin->_getPlacementRunFraction($aPlacement);
        $this->assertEqual($result, 1);

        // Test 2
        $aPlacement = array(
            'placement_id'    => 1,
            'placement_start' => '2006-10-30',
            'placement_end'   => '2006-11-02'
        );
        $result = $oPlugin->_getPlacementRunFraction($aPlacement);
        $this->assertEqual($result, 2/4);

        $aPlacement = array(
            'placement_id'    => 1,
            'placement_start' => '2006-10-31',
            'placement_end'   => '2006-11-01'
        );
        $result = $oPlugin->_getPlacementRunFraction($aPlacement);
        $this->assertEqual($result, 1/2);

        $aPlacement = array(
            'placement_id'    => 1,
            'placement_start' => '2006-10-01',
            'placement_end'   => '2006-11-01'
        );
        $result = $oPlugin->_getPlacementRunFraction($aPlacement);
        $this->assertEqual($result, 1/32);

        $aPlacement = array(
            'placement_id'    => 1,
            'placement_start' => '2006-10-01',
            'placement_end'   => '2006-11-15'
        );
        $result = $oPlugin->_getPlacementRunFraction($aPlacement);
        $this->assertEqual($result, 15/46);

        // Test 3
        $aPlacement = array(
            'placement_id'    => 1,
            'placement_start' => '2006-11-29',
            'placement_end'   => '2006-12-02'
        );
        $result = $oPlugin->_getPlacementRunFraction($aPlacement);
        $this->assertEqual($result, 2/4);

        $aPlacement = array(
            'placement_id'    => 1,
            'placement_start' => '2006-11-30',
            'placement_end'   => '2006-12-01'
        );
        $result = $oPlugin->_getPlacementRunFraction($aPlacement);
        $this->assertEqual($result, 1/2);

        $aPlacement = array(
            'placement_id'    => 1,
            'placement_start' => '2006-11-30',
            'placement_end'   => '2006-12-31'
        );
        $result = $oPlugin->_getPlacementRunFraction($aPlacement);
        $this->assertEqual($result, 1/32);

        $aPlacement = array(
            'placement_id'    => 1,
            'placement_start' => '2006-11-16',
            'placement_end'   => '2006-12-31'
        );
        $result = $oPlugin->_getPlacementRunFraction($aPlacement);
        $this->assertEqual($result, 15/46);

        // Test 4
        $aPlacement = array(
            'placement_id'    => 1,
            'placement_start' => '2006-10-31',
            'placement_end'   => '2006-12-01'
        );
        $result = $oPlugin->_getPlacementRunFraction($aPlacement);
        $this->assertEqual($result, 30/32);

        // Test 5
        $oDate = new Date('2006-10-31');
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalStatistics = new MockMAX_Dal_Statistics($this);
        $oMaxDalStatistics->setReturnValueAt(0, 'getPlacementFirstStatsDate', $oDate);
        $oMaxDalStatistics->expectArgumentsAt(0, 'getPlacementFirstStatsDate', array(1));
        $oMaxDalStatistics->expectCallCount('getPlacementFirstStatsDate', 1);
        $oServiceLocator->register('MAX_Dal_Statistics', $oMaxDalStatistics);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->aPeriod = array(
            'start' => new Date('2006-11-01'),
            'end'   => new Date('2006-11-30')
        );

        $aPlacement = array(
            'placement_id'    => 1,
            'placement_start' => '0000-00-00',
            'placement_end'   => '2006-11-01'
        );
        $result = $oPlugin->_getPlacementRunFraction($aPlacement);
        $this->assertEqual($result, 1/2);

        $oMaxDalStatistics = &$oServiceLocator->get('MAX_Dal_Statistics');
        $oMaxDalStatistics->tally();

        $oDate = new Date('2006-10-31');
        $oServiceLocator = &ServiceLocator::instance();
        $oMaxDalStatistics = new MockMAX_Dal_Statistics($this);
        $oMaxDalStatistics->setReturnValueAt(0, 'getPlacementFirstStatsDate', $oDate);
        $oMaxDalStatistics->expectArgumentsAt(0, 'getPlacementFirstStatsDate', array(1));
        $oMaxDalStatistics->expectCallCount('getPlacementFirstStatsDate', 1);
        $oServiceLocator->register('MAX_Dal_Statistics', $oMaxDalStatistics);
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->aPeriod = array(
            'start' => new Date('2006-11-01'),
            'end'   => new Date('2006-11-30')
        );

        $aPlacement = array(
            'placement_id'    => 1,
            'placement_end'   => '2006-11-01'
        );
        $result = $oPlugin->_getPlacementRunFraction($aPlacement);
        $this->assertEqual($result, 1/2);

        $oMaxDalStatistics = &$oServiceLocator->get('MAX_Dal_Statistics');
        $oMaxDalStatistics->tally();

        // Test 6
        $oDate = new Date('2006-11-01');
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->aPeriod = array(
            'start' => new Date('2006-11-01'),
            'end'   => new Date('2006-11-30')
        );

        $aPlacement = array(
            'placement_id'    => 1,
            'placement_start' => '2006-10-31',
            'placement_end'   => '0000-00-00'
        );
        $result = $oPlugin->_getPlacementRunFraction($aPlacement);
        $this->assertEqual($result, 30/31);

        $aPlacement = array(
            'placement_id'    => 1,
            'placement_start' => '2006-10-31'
        );
        $result = $oPlugin->_getPlacementRunFraction($aPlacement);
        $this->assertEqual($result, 30/31);
    }

    /**
     * A method to test the _getAdWeightSum() method.
     *
     * Requirements:
     * Test 1: Test that ad weights are summed correctly.
     */
    function test_getAdWeightSum()
    {
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');

        // Test 1
        $aAds = array(
            1 => array(
                'weight' => 1
            ),
            2 => array(
                'weight' => 1
            ),
            3 => array(
                'weight' => 1
            ),
            4 => array(
                'weight' => 1
            ),
            5 => array(
                'weight' => 2
            )
        );
        $result = $oPlugin->_getAdWeightSum($aAds);
        $this->assertEqual($result, 6);
    }

    /**
     * A method to test the _bookLimitedAds() method.
     *
     * Requirements:
     * Test 1:  Test with no booked ad info, and ensure nothing booked.
     * Test 2:  Test with a low-priority placement, and ensure nothing booked.
     * Test 3:  Test with an exclusive placement with an ad that has no
     *          impressions booked, and ensure nothing booked.
     * Test 4:  Test with an exclusive placement with an ad that has unlimited
     *          impressions booked, and ensure nothing booked.
     * Test 5:  Test with an ad with impressions booked, but an error on
     *          returning limitations type, and ensure nothing booked.
     * Test 6:  Test with an ad with impressions booked, no limitations,
     *          and no zone data, and ensure the correct "even delivery"
     *          impressions are booked.
     * Test 7:  Test with an ad with impressions booked, no limitations,
     *          and no zone data, only one zone in the report, and ensure
     *          the correct "even delivery" impressions are booked.
     * Test 8:  Test with an ad with impressions booked, no limitations,
     *          and zone data, and ensure the correct impressions are booked.
     * Test 9:  Test with an ad with impressions booked, no limitations,
     *          zone data, and channel/zone period data, and ensure the correct
     *          impressions are booked.
     * Test 10: Test with an ad with impressions booked, matching channel limitations,
     *          zone data, and channel/zone period data, and ensure the correct
     *          impressions are booked.
     * Test 11: Test with an ad with impressions booked, overlap channel limitations,
     *          zone data, and channel/zone period data, and ensure the correct
     *          impressions are booked.
     */
    function test_bookLimitedAds()
    {
        // Test 1
        $aBookingInfo = array();
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->aBookingInfo = $aBookingInfo;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookLimitedAds('exclusive');
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        // Test 2
        $aPlacements = array(
            1 => array(
                'priority' => 0
            )
        );
        $aBookingInfo = array(
            1 => array(
                'adBooked' => array(
                    1 => array(
                        'impressions' => 1000
                    )
                ),
                'placementBooked' => array(
                    'impressions' => 1000
                )
            )
        );
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aBookingInfo = $aBookingInfo;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookLimitedAds('exclusive');
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        // Test 3
        $aPlacements = array(
            1 => array(
                'priority' => -1
            )
        );
        $aBookingInfo = array(
            1 => array(
                'adBooked' => array(
                    1 => array(
                        'impressions' => 0
                    )
                ),
                'placementBooked' => array(
                    'impressions' => 0
                )
            )
        );
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aBookingInfo = $aBookingInfo;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookLimitedAds('exclusive');
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        // Test 4
        $aPlacements = array(
            1 => array(
                'priority' => -1
            )
        );
        $aBookingInfo = array(
            1 => array(
                'adBooked' => array(
                    1 => array(
                        'impressions' => -1
                    )
                ),
                'placementBooked' => array(
                    'impressions' => -1
                )
            )
        );
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aBookingInfo = $aBookingInfo;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookLimitedAds('exclusive');
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        // Test 5
        $aPlacements = array(
            1 => array(
                'priority' => -1
            )
        );
        $aBookingInfo = array(
            1 => array(
                'adBooked' => array(
                    1 => array(
                        'impressions' => 1000
                    )
                ),
                'placementBooked' => array(
                    'impressions' => 1000
                )
            )
        );
        $oPlugin = new MockPartialPlugins_Reports_Publisher_ChannelAvailability($this);
        $oPlugin->setReturnValueAt(0, '_getAdLimitationType', '');
        $oPlugin->expectArgumentsAt(0, '_getAdLimitationType', array(1, 1));
        $oPlugin->expectCallCount('_getAdLimitationType', 1);
        $oPlugin->Plugins_Reports_Publisher_ChannelAvailability();
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aBookingInfo = $aBookingInfo;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookLimitedAds('exclusive');
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        $oPlugin->tally();

        // Test 6
        $aZoneIds = array(5, 6);
        $aAdZoneIds = array(
            1 => array(5, 6)
        );
        $oPlugin = new MockPartialPlugins_Reports_Publisher_ChannelAvailability($this);
        $oPlugin->setReturnValueAt(0, '_getAdLimitationType', 'none');
        $oPlugin->expectArgumentsAt(0, '_getAdLimitationType', array(1, 1));
        $oPlugin->expectCallCount('_getAdLimitationType', 1);
        $oPlugin->Plugins_Reports_Publisher_ChannelAvailability();
        $oPlugin->aZoneIds = $aZoneIds;
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aBookingInfo = $aBookingInfo;
        $oPlugin->aAdZoneIds = $aAdZoneIds;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookLimitedAds('exclusive');
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 1);
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings[1]), 2);
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[1][5], 500);
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[1][6], 500);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        $oPlugin->tally();

        // Test 7
        $aZoneIds = array(5);
        $oPlugin = new MockPartialPlugins_Reports_Publisher_ChannelAvailability($this);
        $oPlugin->setReturnValueAt(0, '_getAdLimitationType', 'none');
        $oPlugin->expectArgumentsAt(0, '_getAdLimitationType', array(1, 1));
        $oPlugin->expectCallCount('_getAdLimitationType', 1);
        $oPlugin->Plugins_Reports_Publisher_ChannelAvailability();
        $oPlugin->aZoneIds = $aZoneIds;
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aBookingInfo = $aBookingInfo;
        $oPlugin->aAdZoneIds = $aAdZoneIds;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookLimitedAds('exclusive');
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 1);
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings[1]), 1);
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[1][5], 500);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        $oPlugin->tally();

        // Test 8
        $aZoneIds = array(5, 6);
        $aAverageZoneForecasts = array(
            5 => 30000,
            6 => 10000
        );
        $oPlugin = new MockPartialPlugins_Reports_Publisher_ChannelAvailability($this);
        $oPlugin->setReturnValueAt(0, '_getAdLimitationType', 'none');
        $oPlugin->expectArgumentsAt(0, '_getAdLimitationType', array(1, 1));
        $oPlugin->expectCallCount('_getAdLimitationType', 1);
        $oPlugin->Plugins_Reports_Publisher_ChannelAvailability();
        $oPlugin->aZoneIds = $aZoneIds;
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aBookingInfo = $aBookingInfo;
        $oPlugin->aAdZoneIds = $aAdZoneIds;
        $oPlugin->aAverageZoneForecasts = $aAverageZoneForecasts;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookLimitedAds('exclusive');
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 1);
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings[1]), 2);
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[1][5], 750);
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[1][6], 250);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        $oPlugin->tally();

        // Test 9
        $aChannelForecastsPeriod = array(
            5 => 100000,
            6 => 10000
        );
        $aZoneForecastsPeriod = array(
            5 => 1000000,
            6 => 1000000
        );
        $oPlugin = new MockPartialPlugins_Reports_Publisher_ChannelAvailability($this);
        $oPlugin->setReturnValueAt(0, '_getAdLimitationType', 'none');
        $oPlugin->expectArgumentsAt(0, '_getAdLimitationType', array(1, 1));
        $oPlugin->expectCallCount('_getAdLimitationType', 1);
        $oPlugin->Plugins_Reports_Publisher_ChannelAvailability();
        $oPlugin->aZoneIds = $aZoneIds;
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aBookingInfo = $aBookingInfo;
        $oPlugin->aAdZoneIds = $aAdZoneIds;
        $oPlugin->aAverageZoneForecasts = $aAverageZoneForecasts;
        $oPlugin->aChannelForecastsPeriod = $aChannelForecastsPeriod;
        $oPlugin->aZoneForecastsPeriod = $aZoneForecastsPeriod;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookLimitedAds('exclusive');
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 1);
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings[1]), 2);
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[1][5], 75);
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[1][6], 3);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        $oPlugin->tally();

        $aPlacements = array(
            1 => array(
                'priority' => 5
            )
        );
        $oPlugin = new MockPartialPlugins_Reports_Publisher_ChannelAvailability($this);
        $oPlugin->setReturnValueAt(0, '_getAdLimitationType', 'none');
        $oPlugin->expectArgumentsAt(0, '_getAdLimitationType', array(1, 1));
        $oPlugin->expectCallCount('_getAdLimitationType', 1);
        $oPlugin->Plugins_Reports_Publisher_ChannelAvailability();
        $oPlugin->aZoneIds = $aZoneIds;
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aBookingInfo = $aBookingInfo;
        $oPlugin->aAdZoneIds = $aAdZoneIds;
        $oPlugin->aAverageZoneForecasts = $aAverageZoneForecasts;
        $oPlugin->aChannelForecastsPeriod = $aChannelForecastsPeriod;
        $oPlugin->aZoneForecastsPeriod = $aZoneForecastsPeriod;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookLimitedAds('high-priority');
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 1);
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings[1]), 2);
        $this->assertEqual($oPlugin->aHighPriorityPlacementsRunOfSiteBookings[1][5], 75);
        $this->assertEqual($oPlugin->aHighPriorityPlacementsRunOfSiteBookings[1][6], 3);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        $oPlugin->tally();

        // Test 10
        $aPlacements = array(
            1 => array(
                'priority' => -1
            )
        );
        $oPlugin = new MockPartialPlugins_Reports_Publisher_ChannelAvailability($this);
        $oPlugin->setReturnValueAt(0, '_getAdLimitationType', 'matches');
        $oPlugin->expectArgumentsAt(0, '_getAdLimitationType', array(1, 1));
        $oPlugin->expectCallCount('_getAdLimitationType', 1);
        $oPlugin->Plugins_Reports_Publisher_ChannelAvailability();
        $oPlugin->aZoneIds = $aZoneIds;
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aBookingInfo = $aBookingInfo;
        $oPlugin->aAdZoneIds = $aAdZoneIds;
        $oPlugin->aAverageZoneForecasts = $aAverageZoneForecasts;
        $oPlugin->aChannelForecastsPeriod = $aChannelForecastsPeriod;
        $oPlugin->aZoneForecastsPeriod = $aZoneForecastsPeriod;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookLimitedAds('exclusive');
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 1);
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings[1]), 2);
        $this->assertEqual($oPlugin->aExclusivePlacementsChannelBookings[1][5], 750);
        $this->assertEqual($oPlugin->aExclusivePlacementsChannelBookings[1][6], 250);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        $oPlugin->tally();

        $aPlacements = array(
            1 => array(
                'priority' => 5
            )
        );
        $oPlugin = new MockPartialPlugins_Reports_Publisher_ChannelAvailability($this);
        $oPlugin->setReturnValueAt(0, '_getAdLimitationType', 'matches');
        $oPlugin->expectArgumentsAt(0, '_getAdLimitationType', array(1, 1));
        $oPlugin->expectCallCount('_getAdLimitationType', 1);
        $oPlugin->Plugins_Reports_Publisher_ChannelAvailability();
        $oPlugin->aZoneIds = $aZoneIds;
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aBookingInfo = $aBookingInfo;
        $oPlugin->aAdZoneIds = $aAdZoneIds;
        $oPlugin->aAverageZoneForecasts = $aAverageZoneForecasts;
        $oPlugin->aChannelForecastsPeriod = $aChannelForecastsPeriod;
        $oPlugin->aZoneForecastsPeriod = $aZoneForecastsPeriod;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookLimitedAds('high-priority');
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 1);
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings[1]), 2);
        $this->assertEqual($oPlugin->aHighPriorityPlacementsChannelBookings[1][5], 750);
        $this->assertEqual($oPlugin->aHighPriorityPlacementsChannelBookings[1][6], 250);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        $oPlugin->tally();

        // Test 11
        $aPlacements = array(
            1 => array(
                'priority' => -1
            )
        );
        $oPlugin = new MockPartialPlugins_Reports_Publisher_ChannelAvailability($this);
        $oPlugin->setReturnValueAt(0, '_getAdLimitationType', 'overlap');
        $oPlugin->expectArgumentsAt(0, '_getAdLimitationType', array(1, 1));
        $oPlugin->expectCallCount('_getAdLimitationType', 1);
        $oPlugin->Plugins_Reports_Publisher_ChannelAvailability();
        $oPlugin->aZoneIds = $aZoneIds;
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aBookingInfo = $aBookingInfo;
        $oPlugin->aAdZoneIds = $aAdZoneIds;
        $oPlugin->aAverageZoneForecasts = $aAverageZoneForecasts;
        $oPlugin->aChannelForecastsPeriod = $aChannelForecastsPeriod;
        $oPlugin->aZoneForecastsPeriod = $aZoneForecastsPeriod;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookLimitedAds('exclusive');
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 1);
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings[1]), 2);
        $this->assertEqual($oPlugin->aExclusivePlacementsTargetedBookings[1][5], 750);
        $this->assertEqual($oPlugin->aExclusivePlacementsTargetedBookings[1][6], 250);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        $oPlugin->tally();

        $aPlacements = array(
            1 => array(
                'priority' => 1
            )
        );
        $oPlugin = new MockPartialPlugins_Reports_Publisher_ChannelAvailability($this);
        $oPlugin->setReturnValueAt(0, '_getAdLimitationType', 'overlap');
        $oPlugin->expectArgumentsAt(0, '_getAdLimitationType', array(1, 1));
        $oPlugin->expectCallCount('_getAdLimitationType', 1);
        $oPlugin->Plugins_Reports_Publisher_ChannelAvailability();
        $oPlugin->aZoneIds = $aZoneIds;
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aBookingInfo = $aBookingInfo;
        $oPlugin->aAdZoneIds = $aAdZoneIds;
        $oPlugin->aAverageZoneForecasts = $aAverageZoneForecasts;
        $oPlugin->aChannelForecastsPeriod = $aChannelForecastsPeriod;
        $oPlugin->aZoneForecastsPeriod = $aZoneForecastsPeriod;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookLimitedAds('high-priority');
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 1);
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings[1]), 2);
        $this->assertEqual($oPlugin->aHighPriorityPlacementsTargetedBookings[1][5], 750);
        $this->assertEqual($oPlugin->aHighPriorityPlacementsTargetedBookings[1][6], 250);

        $oPlugin->tally();
    }

    /**
     * A method to test the _setPlacementAdWeight() method.
     *
     * Requirements:
     * Test 1: Test that the placement weight is correctly set for those ads that
     *         require it to be set.
     */
    function test_setPlacementAdWeight()
    {
        $aPlacements = array(
            1 => array(
                'weight' => 2
            ),
            2 => array(
                'weight' => 3
            )
        );
        $aPlacementAds = array(
            1 => array(
                3 => array(
                    'weight' => 4
                )
            )
        );
        $aBookingInfo = array(
            1 => array(
                'adBooked' => array(
                    1 => array(
                        'impressions' => 1000
                    ),
                    2 => array(
                        'impressions' => -1
                    ),
                    3 => array(
                        'impressions' => -1
                    )
                )
            )
        );
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aPlacementAds = $aPlacementAds;
        $oPlugin->aBookingInfo = $aBookingInfo;

        $this->assertNull($oPlugin->aBookingInfo[1]['adBooked'][1]['weight']);
        $oPlugin->_setPlacementAdWeight(1, 1);
        $this->assertNull($oPlugin->aBookingInfo[1]['adBooked'][1]['weight']);

        $this->assertNull($oPlugin->aBookingInfo[1]['adBooked'][2]['weight']);
        $oPlugin->_setPlacementAdWeight(1, 2);
        $this->assertEqual($oPlugin->aBookingInfo[1]['adBooked'][2]['weight'], 1);

        $this->assertNull($oPlugin->aBookingInfo[1]['adBooked'][3]['weight']);
        $oPlugin->_setPlacementAdWeight(1, 3);
        $this->assertEqual($oPlugin->aBookingInfo[1]['adBooked'][3]['weight'], 8);
    }

    /**
     * A method to test the _getBookedZoneInventory() method.
     *
     * Requirements:
     * Test 1: Test that booked inventory is correctly summed.
     */
    function test_getBookedZoneInventory()
    {
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');

        $aExclusivePlacementsRunOfSiteBookings = array(
            1 => array(
                1 => 1000,
                2 => 1000
            ),
            2 => array(
                1 => 1000,
                4 => 5000
            )
        );
        $oPlugin->aExclusivePlacementsRunOfSiteBookings = $aExclusivePlacementsRunOfSiteBookings;
        $aResult = array();
        $oPlugin->_getBookedZoneInventory($aResult);
        $this->assertEqual($aResult[1], 2000);
        $this->assertEqual($aResult[2], 1000);
        $this->assertEqual($aResult[4], 5000);

        $aExclusivePlacementsChannelBookings = array(
            1 => array(
                1 => 1000,
                2 => 1000
            ),
            2 => array(
                1 => 1000,
                4 => 5050
            )
        );
        $oPlugin->aExclusivePlacementsChannelBookings = $aExclusivePlacementsChannelBookings;
        $aResult = array();
        $oPlugin->_getBookedZoneInventory($aResult);
        $this->assertEqual($aResult[1], 4000);
        $this->assertEqual($aResult[2], 2000);
        $this->assertEqual($aResult[4], 10050);

        $aExclusivePlacementsTargetedBookings = array(
            1 => array(
                1 => 100,
                2 => 100
            ),
            2 => array(
                1 => 100,
                4 => 500
            )
        );
        $oPlugin->aExclusivePlacementsTargetedBookings = $aExclusivePlacementsTargetedBookings;
        $aResult = array();
        $oPlugin->_getBookedZoneInventory($aResult);
        $this->assertEqual($aResult[1], 4200);
        $this->assertEqual($aResult[2], 2100);
        $this->assertEqual($aResult[4], 10550);
    }

    /**
     * A method to test the _storeUnlimitedExclusive() method.
     *
     * Requirements:
     * Test 1: Test that data is correctly stored in the final report arrays.
     */
    function test_storeUnlimitedExclusive()
    {
        $aData = array(
            1 => array(
                1 => array(
                    1 => 100,
                    2 => 100
                )
            )
        );

        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');

        $this->assertNull($oPlugin->aExclusivePlacementsRunOfSiteBookings[1][1]);
        $this->assertNull($oPlugin->aExclusivePlacementsChannelBookings[1][1]);
        $this->assertNull($oPlugin->aExclusivePlacementsTargetedBookings[1][1]);
        $oPlugin->_storeUnlimitedExclusive($aData, 'ROS');
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[1][1], 200);
        $this->assertNull($oPlugin->aExclusivePlacementsChannelBookings[1][1]);
        $this->assertNull($oPlugin->aExclusivePlacementsTargetedBookings[1][1]);

        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[1][1], 200);
        $this->assertNull($oPlugin->aExclusivePlacementsChannelBookings[1][1]);
        $this->assertNull($oPlugin->aExclusivePlacementsTargetedBookings[1][1]);
        $oPlugin->_storeUnlimitedExclusive($aData, 'Channel');
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[1][1], 200);
        $this->assertEqual($oPlugin->aExclusivePlacementsChannelBookings[1][1], 200);
        $this->assertNull($oPlugin->aExclusivePlacementsTargetedBookings[1][1]);

        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[1][1], 200);
        $this->assertEqual($oPlugin->aExclusivePlacementsChannelBookings[1][1], 200);
        $this->assertNull($oPlugin->aExclusivePlacementsTargetedBookings[1][1]);
        $oPlugin->_storeUnlimitedExclusive($aData, 'Targeted');
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[1][1], 200);
        $this->assertEqual($oPlugin->aExclusivePlacementsChannelBookings[1][1], 200);
        $this->assertEqual($oPlugin->aExclusivePlacementsTargetedBookings[1][1], 200);
    }

    /**
     * A method to test the _bookUnlimitedExclusiveAds() method.
     *
     * Requirements:
     * Test 1:  Test with no booked ad info, and ensure nothing booked.
     * Test 2:  Test with a high-priority placement, and ensure nothing booked.
     * Test 3:  Test with an exclusive placement with an ad that has no
     *          impressions booked, and ensure nothing booked.
     * Test 4:  Test with an exclusive placement with an ad that has limited
     *          impressions booked, and ensure nothing booked.
     * Test 5:  Test with an exclusive ad with unlimited impressions booked, but
     *          an error on returning limitations type, and ensure nothing booked.
     * Test 6:  Test with an exclusive ad with unlimited impressions booked, no
     *          limitations, and a runFraction of 1, and ensure the all remaining
     *          inventory is booked.
     * Test 7:  Test with an exclusive ad with unlimited impressions booked, no
     *          limitations, and a runFraction of 0.5, and ensure half the remaining
     *          inventory is booked.
     * Test 8:  Test with multiple exclusive ads in multiple placements, and ensure
     *          the correct inventory is booked.
     */
    function test_bookUnlimitedExclusiveAds()
    {
        // Test 1
        $aChannelForecastsPeriod = array();
        $aBookingInfo = array();
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->aChannelForecastsPeriod = $aChannelForecastsPeriod;
        $oPlugin->aBookingInfo = $aBookingInfo;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookUnlimitedExclusiveAds();
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        // Test 2
        $aPlacements = array(
            1 => array(
                'priority' => 0
            )
        );
        $aBookingInfo = array(
            1 => array(
                'adBooked' => array(
                    1 => array(
                        'impressions' => 1000
                    )
                ),
                'placementBooked' => array(
                    'impressions' => 1000
                )
            )
        );
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->aChannelForecastsPeriod = $aChannelForecastsPeriod;
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aBookingInfo = $aBookingInfo;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookUnlimitedExclusiveAds();
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        // Test 3
        $aPlacements = array(
            1 => array(
                'priority' => -1
            )
        );
        $aBookingInfo = array(
            1 => array(
                'adBooked' => array(
                    1 => array(
                        'impressions' => 0
                    )
                ),
                'placementBooked' => array(
                    'impressions' => 0
                )
            )
        );
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->aChannelForecastsPeriod = $aChannelForecastsPeriod;
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aBookingInfo = $aBookingInfo;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookUnlimitedExclusiveAds();
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        // Test 4
        $aBookingInfo = array(
            1 => array(
                'adBooked' => array(
                    1 => array(
                        'impressions' => 1000
                    )
                ),
                'placementBooked' => array(
                    'impressions' => 1000
                )
            )
        );
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');
        $oPlugin->aChannelForecastsPeriod = $aChannelForecastsPeriod;
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aBookingInfo = $aBookingInfo;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookUnlimitedExclusiveAds();
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        // Test 5
        $aBookingInfo = array(
            1 => array(
                'adBooked' => array(
                    1 => array(
                        'impressions' => -1
                    )
                ),
                'placementBooked' => array(
                    'impressions' => -1
                )
            )
        );
        $oPlugin = new MockPartialPlugins_Reports_Publisher_ChannelAvailability($this);
        $oPlugin->setReturnValueAt(0, '_getAdLimitationType', '');
        $oPlugin->expectArgumentsAt(0, '_getAdLimitationType', array(1, 1));
        $oPlugin->expectCallCount('_getAdLimitationType', 1);
        $oPlugin->Plugins_Reports_Publisher_ChannelAvailability();
        $oPlugin->aChannelForecastsPeriod = $aChannelForecastsPeriod;
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aBookingInfo = $aBookingInfo;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookUnlimitedExclusiveAds();
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        $oPlugin->tally();

        // Test 6
        $aZoneIds = array(5, 6);
        $aChannelForecastsPeriod = array(
            5 => 5000000,
            6 => 1000000
        );
        $aBookingInfo = array(
            1 => array(
                'adBooked' => array(
                    1 => array(
                        'impressions' => -1
                    )
                ),
                'placementBooked' => array(
                    'impressions' => -1,
                    'runFraction' => 1
                )
            )
        );
        $aAdZoneIds = array(
            1 => array(5, 6)
        );
        $oPlugin = new MockPartialPlugins_Reports_Publisher_ChannelAvailability($this);
        $oPlugin->setReturnValueAt(0, '_getAdLimitationType', 'none');
        $oPlugin->expectArgumentsAt(0, '_getAdLimitationType', array(1, 1));
        $oPlugin->expectCallCount('_getAdLimitationType', 1);
        $oPlugin->Plugins_Reports_Publisher_ChannelAvailability();
        $oPlugin->aZoneIds = $aZoneIds;
        $oPlugin->aChannelForecastsPeriod = $aChannelForecastsPeriod;
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aAdZoneIds = $aAdZoneIds;
        $oPlugin->aBookingInfo = $aBookingInfo;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookUnlimitedExclusiveAds();
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 1);
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings[1]), 2);
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[1][5], 5000000);
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[1][6], 1000000);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        $oPlugin->tally();

        // Test 7
        $aExclusivePlacementsChannelBookings = array(
            1 => array(
                6 => 500000
            )
        );
        $aBookingInfo = array(
            1 => array(
                'adBooked' => array(
                    1 => array(
                        'impressions' => -1
                    )
                ),
                'placementBooked' => array(
                    'impressions' => -1,
                    'runFraction' => 0.5
                )
            )
        );
        $oPlugin = new MockPartialPlugins_Reports_Publisher_ChannelAvailability($this);
        $oPlugin->setReturnValueAt(0, '_getAdLimitationType', 'none');
        $oPlugin->expectArgumentsAt(0, '_getAdLimitationType', array(1, 1));
        $oPlugin->expectCallCount('_getAdLimitationType', 1);
        $oPlugin->Plugins_Reports_Publisher_ChannelAvailability();
        $oPlugin->aZoneIds = $aZoneIds;
        $oPlugin->aChannelForecastsPeriod = $aChannelForecastsPeriod;
        $oPlugin->aExclusivePlacementsChannelBookings = $aExclusivePlacementsChannelBookings;
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aAdZoneIds = $aAdZoneIds;
        $oPlugin->aBookingInfo = $aBookingInfo;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 1);
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings[1]), 1);
        $this->assertEqual($oPlugin->aExclusivePlacementsChannelBookings[1][6], 500000);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookUnlimitedExclusiveAds();
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 1);
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings[1]), 2);
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[1][5], 2500000);
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[1][6], 250000);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 1);
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings[1]), 1);
        $this->assertEqual($oPlugin->aExclusivePlacementsChannelBookings[1][6], 500000);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        $oPlugin->tally();

        // Test 8
        $aZoneIds = array(5, 6);
        $aPlacements = array(
            1 => array(
                'priority' => -1,
                'weight'   => 1
            ),
            2 => array(
                'priority' => -1,
                'weight'   => 3
            ),
            3 => array(
                'priority' => 5,
                'weight'   => 1
            )
        );
        $aPlacementAds = array(
            1 => array(
                1 => array(
                    'weight' => 1
                ),
                2 => array(
                    'weight' => 1
                )
            ),
            2 => array(
                3 => array(
                    'weight' => 1
                ),
                4 => array(
                    'weight' => 2
                ),
                5 => array(
                    'weight' => 1
                )
            ),
            3 => array(
                6 => array(
                    'weight' => 1
                ),
                7 => array(
                    'weight' => 1
                )
            ),
        );
        $aAdZoneIds = array(
            1 => array(5),
            2 => array(6),
            3 => array(5, 6, 7),
            4 => array(5, 6, 8),
            5 => array(5, 6, 9),
            6 => array(5, 6),
            7 => array(5, 6)
        );
        $aExclusivePlacementsChannelBookings = array(
            1 => array(
                6 => 500000
            )
        );
        $aChannelForecastsPeriod = array(
            5 => 5000000,
            6 => 1000000,
            7 => 1000000,
            8 => 1000000,
            9 => 1000000
        );
        $aBookingInfo = array(
            1 => array(
                'adBooked' => array(
                    1 => array(
                        'impressions' => -1
                    ),
                    2 => array(
                        'impressions' => -1
                    )
                ),
                'placementBooked' => array(
                    'impressions' => -1,
                    'runFraction' => 1
                )
            ),
            2 => array(
                'adBooked' => array(
                    3 => array(
                        'impressions' => -1
                    ),
                    4 => array(
                        'impressions' => -1
                    ),
                    5 => array(
                        'impressions' => -1
                    )
                ),
                'placementBooked' => array(
                    'impressions' => -1,
                    'runFraction' => 0.5
                )
            ),
            3 => array(
                'adBooked' => array(
                    6 => array(
                        'impressions' => 50000
                    ),
                    7 => array(
                        'impressions' => 50000
                    )
                ),
                'placementBooked' => array(
                    'impressions' => 1000000,
                    'runFraction' => 1
                )
            )
        );
        $oPlugin = new MockPartialPlugins_Reports_Publisher_ChannelAvailability($this);
        $oPlugin->setReturnValueAt(0, '_getAdLimitationType', 'overlap');
        $oPlugin->setReturnValueAt(1, '_getAdLimitationType', 'overlap');
        $oPlugin->setReturnValueAt(2, '_getAdLimitationType', 'overlap');
        $oPlugin->setReturnValueAt(3, '_getAdLimitationType', 'overlap');
        $oPlugin->setReturnValueAt(4, '_getAdLimitationType', 'none');
        $oPlugin->expectArgumentsAt(0, '_getAdLimitationType', array(1, 1));
        $oPlugin->expectArgumentsAt(1, '_getAdLimitationType', array(1, 2));
        $oPlugin->expectArgumentsAt(2, '_getAdLimitationType', array(2, 3));
        $oPlugin->expectArgumentsAt(3, '_getAdLimitationType', array(2, 4));
        $oPlugin->expectArgumentsAt(4, '_getAdLimitationType', array(2, 5));
        $oPlugin->expectCallCount('_getAdLimitationType', 5);
        $oPlugin->Plugins_Reports_Publisher_ChannelAvailability();
        $oPlugin->aZoneIds = $aZoneIds;
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aPlacementAds = $aPlacementAds;
        $oPlugin->aAdZoneIds = $aAdZoneIds;
        $oPlugin->aExclusivePlacementsChannelBookings = $aExclusivePlacementsChannelBookings;
        $oPlugin->aChannelForecastsPeriod = $aChannelForecastsPeriod;
        $oPlugin->aBookingInfo = $aBookingInfo;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 1);
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings[1]), 1);
        $this->assertEqual($oPlugin->aExclusivePlacementsChannelBookings[1][6], 500000);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);
        $oPlugin->_bookUnlimitedExclusiveAds();
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 1);
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings[1]), 0);
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings[2]), 2);
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[1][5], 0);
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[1][6], 0);
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[2][5], round(5000000 * 3/13 * 0.5));
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[2][6], round(500000 * 3/13 * 0.5));

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 1);
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings[1]), 1);
        $this->assertEqual($oPlugin->aExclusivePlacementsChannelBookings[1][6], 500000);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 2);
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings[1]), 2);
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings[2]), 2);
        $this->assertEqual($oPlugin->aExclusivePlacementsTargetedBookings[1][5], round(5000000 * 1/13));
        $this->assertEqual($oPlugin->aExclusivePlacementsTargetedBookings[1][6], round(500000 * 1/13));
        $this->assertEqual($oPlugin->aExclusivePlacementsTargetedBookings[2][5], round(5000000 * 9/13 * 0.5));
        $this->assertEqual($oPlugin->aExclusivePlacementsTargetedBookings[2][6], round(500000 * 9/13 * 0.5));

        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        $oPlugin->tally();
    }

    /**
     * A method to test the _setBookedInventory() method.
     *
     * Requirements:
     * Test 1: Test with relatively simple data, and ensure that the
     *         correct booked data is generated. The data set is:
     *      - Publisher ID 9
     *      - Channel ID 5
     *      - All zones selected, in this case zone ID 1 and ID 2
     *      - Report period of 2006/11/01 to 2006/11/30
     *      - Threshold of 1000
     *
     *      - There are six placements that are active in the report
     *        period and with ads linked to either zone ID 1 or zone
     *        ID 2 (or both):
     *          - Placement ID 12 is an exclusive placement with
     *            start and end dates outside the report period, booked
     *            for 1M impressions => Requires 500k impressions in the
     *            report period.
     *          - Placement ID 13 is an exlusive placement with
     *            start and end dates inside the report period, booked
     *            for 5k clicks => Requires 10k impressions in the
     *            report period, given a default click through ratio
     *            of 0.5.
     *          - Placement ID 14 is an exclusive placement with
     *            no start and end dates, and no inventory requirements
     *            => Requires all remaining inventory in the report
     *            period after the above have been booked in.
     *          - Placement ID 15 is a high-priority placement with
     *            start and end dates outside the report period, booked
     *            for 1M impressions => Requires 500k impressions in the
     *            report period.
     *          - Placement ID 16 is a high-priority placement with
     *            start and end dates outside the report period, booked
     *            for 5k impressions per day => Requires 150k impressions
     *            in the report period.
     *          - Placement ID 17 is a low-priority placement with
     *            start and end dates outside the report period, booked
     *            for 5M impressions => Requires no impressions in the
     *            report period (it's low-priority).
     *      - Each of the above placements have three children ads each,
     *        one linked to two zones - some to the two zones in the
     *        report, and some to one zone in the report, and one other
     *        zone.
     *
     *      - The channel (ID 5) has the following forecast inventory
     *        in zone IDs 1, 2 and 3:
     *          - Zone ID 1: 10,000,000
     *          - Zone ID 2: 50,000,000
     *          - Zone ID 3: 20,000,000
     *
     *      - On average, the zones have the following forecast impression
     *        inventory:
     *          - Zone ID 1:  5,000
     *          - Zone ID 2: 15,000
     *          - Zone ID 3:  5,000
     *
     *      - Over the report period, the zones have the following total
     *        forecast imperssion inventory:
     *          - Zone ID 1:  50,000,000
     *          - Zone ID 2: 150,000,000
     *          - Zone ID 3:  50,000,000
     *
     * @TODO Extend to include an overlapping channel type!
     */
    function test_setBookedInventory()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['priority']['defaultClickRatio'] = 0.5;

        // Prepare data required for test
        $publisherId = 9;
        $channelId = 5;
        $aPeriod = array(
            'start' => new Date('2006-11-01'),
            'end'   => new Date('2006-11-30')
        );
        $threshold = 1000;
        $aZoneIds = array(1, 2);
        $aPlacements = array(
            12 => array(
                'placement_id'            => 12,
                'placement_name'          => 'Placement 12',
                'active'                  => 'f',
                'weight'                  => 1,
                'placement_start'         => '2006-11-01',
                'placement_end'           => '2006-12-30',
                'priority'                => -1,
                'impression_target_total' => 1000000,
                'click_target_total'      => -1,
                'conversion_target_total' => -1,
                'impression_target_daily' => -1,
                'click_target_daily'      => -1,
                'conversion_target_daily' => -1
            ),
            13 => array(
                'placement_id'            => 13,
                'placement_name'          => 'Placement 13',
                'active'                  => 'f',
                'weight'                  => 1,
                'placement_start'         => '2006-11-01',
                'placement_end'           => '2006-11-30',
                'priority'                => -1,
                'impression_target_total' => -1,
                'click_target_total'      => 5000,
                'conversion_target_total' => -1,
                'impression_target_daily' => -1,
                'click_target_daily'      => -1,
                'conversion_target_daily' => -1
            ),
            14 => array(
                'placement_id'            => 14,
                'placement_name'          => 'Placement 14',
                'active'                  => 'f',
                'weight'                  => 1,
                'placement_start'         => '2006-10-31',
                'placement_end'           => '2006-12-01',
                'priority'                => -1,
                'impression_target_total' => -1,
                'click_target_total'      => -1,
                'conversion_target_total' => -1,
                'impression_target_daily' => -1,
                'click_target_daily'      => -1,
                'conversion_target_daily' => -1
            ),
            15 => array(
                'placement_id'            => 15,
                'placement_name'          => 'Placement 15',
                'active'                  => 'f',
                'weight'                  => 1,
                'placement_start'         => '2006-11-01',
                'placement_end'           => '2006-12-30',
                'priority'                => 10,
                'impression_target_total' => 1000000,
                'click_target_total'      => -1,
                'conversion_target_total' => -1,
                'impression_target_daily' => -1,
                'click_target_daily'      => -1,
                'conversion_target_daily' => -1
            ),
            16 => array(
                'placement_id'            => 16,
                'placement_name'          => 'Placement 16',
                'active'                  => 'f',
                'weight'                  => 1,
                'placement_start'         => '2006-11-01',
                'placement_end'           => '2006-12-30',
                'priority'                => 10,
                'impression_target_total' => -1,
                'click_target_total'      => -1,
                'conversion_target_total' => -1,
                'impression_target_daily' => 5000,
                'click_target_daily'      => -1,
                'conversion_target_daily' => -1
            ),
            17 => array(
                'placement_id'            => 17,
                'placement_name'          => 'Placement 17',
                'active'                  => 'f',
                'weight'                  => 1,
                'placement_start'         => '2006-11-01',
                'placement_end'           => '2006-12-30',
                'priority'                => 0,
                'impression_target_total' => 5000000,
                'click_target_total'      => -1,
                'conversion_target_total' => -1,
                'impression_target_daily' => -1,
                'click_target_daily'      => -1,
                'conversion_target_daily' => -1
            )
        );
        $aPlacementAds = array(
            12 => array(
                121 => array(
                    'active' => 't',
                    'weight' => 2,
                    'deliveryLimitations' => array()
                ),
                122 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                ),
                123 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                )
            ),
            13 => array(
                131 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                ),
                132 => array(
                    'active' => 't',
                    'weight' => 2,
                    'deliveryLimitations' => array()
                ),
                133 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                )
            ),
            14 => array(
                141 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                ),
                142 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array(
                        0 => array(
                            'logical'        => 'and',
                            'type'           => 'Site:Channel',
                            'comparison'     => '=~',
                            'data'           => 5,
                        )
                    )
                ),
                143 => array(
                    'active' => 't',
                    'weight' => 2,
                    'deliveryLimitations' => array()
                )
            ),
            15 => array(
                151 => array(
                    'active' => 't',
                    'weight' => 2,
                    'deliveryLimitations' => array()
                ),
                152 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                ),
                153 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                )
            ),
            16 => array(
                161 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                ),
                162 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                ),
                163 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                )
            ),
            17 => array(
                171 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                ),
                172 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                ),
                173 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                )
            )
        );
        $aAdZoneIds = array(
            121 => array(1, 2),
            122 => array(1, 2),
            123 => array(1, 3),
            131 => array(1, 2),
            132 => array(1, 2),
            133 => array(1, 3),
            141 => array(1, 2),
            142 => array(1, 2),
            143 => array(1, 3),
            151 => array(1, 2),
            152 => array(1, 2),
            153 => array(1, 3),
            161 => array(1, 2),
            162 => array(1, 2),
            163 => array(1, 3),
            171 => array(1, 2),
            172 => array(1, 2),
            173 => array(1, 3)
        );
        $aChannelLimitations = array(
            0 => array(
                'logical'        => 'and',
                'type'           => 'Time:Hour',
                'comparison'     => '!~',
                'data'           => 12,
            )
        );
        $aChannelForecastsPeriod = array(
            1 => 10000000,
            2 => 50000000,
            3 => 20000000
        );
        $aAverageZoneForecasts = array(
            1 => 5000,
            2 => 15000,
            3 => 5000
        );
        $aZoneForecastsPeriod = array(
            1 => 50000000,
            2 => 150000000,
            3 => 50000000
        );

        // Prepare plugin
        $oPlugin = &MAX_Plugin::factory('reports', 'publisher', 'channelAvailability');

        // Set data normally set in execute()
        $oPlugin->publisherId = $publisherId;
        $oPlugin->channelId = $channelId;
        $oPlugin->aPeriod = $aPeriod;
        $oPlugin->threshold = $threshold;

        // Set data normally set in _prepareRawData()
        $oPlugin->aZoneIds = $aZoneIds;
        $oPlugin->zoneName = 'All Zones';
        /* $oPlugin->aChannelForecastsDaily not set, as not required */
        $oPlugin->aAverageZoneForecasts = $aAverageZoneForecasts;
        /* $oPlugin->aAdIds not set, as not required */
        $oPlugin->aPlacements = $aPlacements;
        $oPlugin->aPlacementAds = $aPlacementAds;
        $oPlugin->aAdZoneIds = $aAdZoneIds;
        $oPlugin->oMaxPluginDeliveryLimitationsMatchOverlap->setLimitationsByChannelArray($channelId, $aChannelLimitations);
        $oPlugin->reportPeriodDays = 30;

        // Set data normally set in _setChannelZoneInventoryForecasts()
        $oPlugin->aChannelForecastsPeriod = $aChannelForecastsPeriod;

        // Set data normally set in _setZoneInventoryForecasts()
        $oPlugin->aZoneForecastsPeriod = $aZoneForecastsPeriod;

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        // Run the booking method
        $oPlugin->_setBookedInventory();

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings), 3);
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings[12]), 2);
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings[13]), 2);
        $this->assertEqual(count($oPlugin->aExclusivePlacementsRunOfSiteBookings[14]), 2);

        // Impressions in Placement ID 12, Zone ID 1, from Ad ID 121
        $p12z1a121 = 500000 * (2/4) * (5000/20000) * (10000000/50000000);
        // Impressions in Placement ID 12, Zone ID 1, from Ad ID 122
        $p12z1a122 = 500000 * (1/4) * (5000/20000) * (10000000/50000000);
        // Impressions in Placement ID 12, Zone ID 1, from Ad ID 123
        $p12z1a123 = 500000 * (1/4) * (5000/10000) * (10000000/50000000);
        // All ads in Placement ID 12, Zone ID 1
        $p12z1 = $p12z1a121 + $p12z1a122 + $p12z1a123;
        // Check impressions booked from Placement ID 12, Zone ID 1
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[12][1], $p12z1);

        // Impressions in Placement ID 12, Zone ID 2, from Ad ID 121
        $p12z2a121 = 500000 * (2/4) * (15000/20000) * (50000000/150000000);
        // Impressions in Placement ID 12, Zone ID 2, from Ad ID 122
        $p12z2a122 = 500000 * (1/4) * (15000/20000) * (50000000/150000000);
        // All ads in Placement ID 12, Zone ID 2
        $p12z2 = $p12z2a121 + $p12z2a122;
        // Check impressions booked from Placement ID 12, Zone ID 2
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[12][2], $p12z2);

        // Impressions in Placement ID 13, Zone ID 1, from Ad ID 131
        $p13z1a131 = 10000 * (1/4) * (5000/20000) * (10000000/50000000);
        // Impressions in Placement ID 13, Zone ID 1, from Ad ID 132
        $p13z1a132 = 10000 * (2/4) * (5000/20000) * (10000000/50000000);
        // Impressions in Placement ID 13, Zone ID 1, from Ad ID 133
        $p13z1a133 = 10000 * (1/4) * (5000/10000) * (10000000/50000000);
        // All ads in Placement ID 13, Zone ID 1
        $p13z1 = $p13z1a131 + $p13z1a132 + $p13z1a133;
        // Check impressions booked from Placement ID 13, Zone ID 1
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[13][1], $p13z1);

        // Impressions in Placement ID 13, Zone ID 2, from Ad ID 131
        $p13z2a131 = 10000 * (1/4) * (15000/20000) * (50000000/150000000);
        // Impressions in Placement ID 13, Zone ID 2, from Ad ID 132
        $p13z2a132 = 10000 * (2/4) * (15000/20000) * (50000000/150000000);
        // All ads in Placement ID 13, Zone ID 2
        $p13z2 = $p13z2a131 + $p13z2a132;
        // Check impressions booked from Placement ID 13, Zone ID 2
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[13][2], $p13z2);

        // Remaining impressions
        $remainingImpressionsInChannel5Zone1 = 10000000 - $p12z1 - $p13z1;
        $remainingImpressionsInChannel5Zone2 = 50000000 - $p12z2 - $p13z2;

        // Impressions in Placement ID 14, Zone ID 1, from Ad ID 141
        $p14z1a141 = round($remainingImpressionsInChannel5Zone1 * (1/4) * 0.9375);
        // Impressions in Placement ID 14, Zone ID 1, from Ad ID 143
        $p14z1a143 = round($remainingImpressionsInChannel5Zone1 * (2/4) * 0.9375);
        // All ads in Placement ID 14, Zone ID 1
        $p14z1 = $p14z1a141 + $p14z1a143;
        // Check impressions booked from Placement ID 14, Zone ID 1
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[14][1], $p14z1);

        // Impressions in Placement ID 14, Zone ID 2, from Ad ID 141
        $p14z2a141 = round($remainingImpressionsInChannel5Zone2 * (1/2) * 0.9375);
        // All ads in Placement ID 14, Zone ID 1
        $p14z2 = $p14z2a141;
        // Check impressions booked from Placement ID 14, Zone ID 2
        $this->assertEqual($oPlugin->aExclusivePlacementsRunOfSiteBookings[14][2], $p14z2);

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings), 1);
        $this->assertEqual(count($oPlugin->aExclusivePlacementsChannelBookings[14]), 2);

        // Impressions in Placement ID 14, Zone ID 1, from Ad ID 142
        $p14z1a142 = round($remainingImpressionsInChannel5Zone1 * (1/4) * 0.9375);
        // All ads in Placement ID 14, Zone ID 1
        $p14z1 = $p14z1a142;
        // Check impressions booked from Placement ID 14, Zone ID 1
        $this->assertEqual($oPlugin->aExclusivePlacementsChannelBookings[14][1], $p14z1);

        // Impressions in Placement ID 14, Zone ID 2, from Ad ID 142
        $p14z2a142 = round($remainingImpressionsInChannel5Zone2 * (1/2) * 0.9375);
        // All ads in Placement ID 14, Zone ID 1
        $p14z2 = $p14z2a142;
        // Check impressions booked from Placement ID 13, Zone ID 2
        $this->assertEqual($oPlugin->aExclusivePlacementsChannelBookings[14][2], $p14z2);

        $this->assertTrue(is_array($oPlugin->aExclusivePlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aExclusivePlacementsTargetedBookings), 0);

        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsRunOfSiteBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings), 2);
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings[15]), 2);
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsRunOfSiteBookings[16]), 2);

        // Impressions in Placement ID 15, Zone ID 1, from Ad ID 151
        $p15z1a151 = 500000 * (2/4) * (5000/20000) * (10000000/50000000);
        // Impressions in Placement ID 15, Zone ID 1, from Ad ID 152
        $p15z1a152 = 500000 * (1/4) * (5000/20000) * (10000000/50000000);
        // Impressions in Placement ID 15, Zone ID 1, from Ad ID 153
        $p15z1a153 = 500000 * (1/4) * (5000/10000) * (10000000/50000000);
        // All ads in Placement ID 15, Zone ID 1
        $p15z1 = $p15z1a151 + $p15z1a152 + $p15z1a153;
        // Check impressions booked from Placement ID 15, Zone ID 1
        $this->assertEqual($oPlugin->aHighPriorityPlacementsRunOfSiteBookings[15][1], $p15z1);

        // Impressions in Placement ID 15, Zone ID 2, from Ad ID 151
        $p15z2a151 = 500000 * (2/4) * (15000/20000) * (50000000/150000000);
        // Impressions in Placement ID 15, Zone ID 2, from Ad ID 152
        $p15z2a152 = 500000 * (1/4) * (15000/20000) * (50000000/150000000);
        // All ads in Placement ID 15, Zone ID 2
        $p15z2 = $p15z2a151 + $p15z2a152;
        // Check impressions booked from Placement ID 15, Zone ID 2
        $this->assertEqual($oPlugin->aHighPriorityPlacementsRunOfSiteBookings[15][2], $p15z2);

        // Impressions in Placement ID 16, Zone ID 1, from Ad ID 161
        $p16z1a161 = 150000 * (1/3) * (5000/20000) * (10000000/50000000);
        // Impressions in Placement ID 16, Zone ID 1, from Ad ID 162
        $p16z1a162 = 150000 * (1/3) * (5000/20000) * (10000000/50000000);
        // Impressions in Placement ID 16, Zone ID 1, from Ad ID 163
        $p16z1a163 = 150000 * (1/3) * (5000/10000) * (10000000/50000000);
        // All ads in Placement ID 16, Zone ID 1
        $p16z1 = $p16z1a161 + $p16z1a162 + $p16z1a163;
        // Check impressions booked from Placement ID 16, Zone ID 1
        $this->assertEqual($oPlugin->aHighPriorityPlacementsRunOfSiteBookings[16][1], $p16z1);

        // Impressions in Placement ID 16, Zone ID 2, from Ad ID 161
        $p16z2a161 = 150000 * (1/3) * (15000/20000) * (50000000/150000000);
        // Impressions in Placement ID 16, Zone ID 2, from Ad ID 162
        $p16z2a162 = 150000 * (1/3) * (15000/20000) * (50000000/150000000);
        // All ads in Placement ID 16, Zone ID 2
        $p16z2 = $p16z2a161 + $p16z2a162;
        // Check impressions booked from Placement ID 16, Zone ID 2
        $this->assertEqual($oPlugin->aHighPriorityPlacementsRunOfSiteBookings[16][2], $p16z2);

        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsChannelBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsChannelBookings), 0);
        $this->assertTrue(is_array($oPlugin->aHighPriorityPlacementsTargetedBookings));
        $this->assertEqual(count($oPlugin->aHighPriorityPlacementsTargetedBookings), 0);

        TestEnv::restoreConfig();

    }

}

?>
