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
require_once MAX_PATH . '/lib/max/Maintenance/Priority/AdServer/Task/GetRequiredAdImpressionsType1.php';

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once 'Date.php';

/**
 * A class for testing the GetRequiredAdImpressionsType1 class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 * @author     James Floyd <james@m3.net>
 */
class TestOfPriorityAdserverGetRequiredAdImpressionsType1 extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function TestOfPriorityAdserverGetRequiredAdImpressionsType1()
    {
        $this->UnitTestCase();
        Mock::generate('MAX_Dal_Entities');
        Mock::generate('OA_Dal_Maintenance_Priority');
        Mock::generate('OA_DB_Table_Priority');
    }

    /**
     * A private method for the test class that creates an instance
     * of the mocked DAL class (MAX_Dal_Maintenance), the mocked
     * table creation class (Openads_Table_Priority), registers the
     * mocked classes in the ServiceLocator, and then returns an
     * instance of the GetRequiredAdImpressionsType1 class to use
     * in testing.
     *
     * @access private
     * @return GetRequiredAdImpressionsType1
     */
    function &_getCurrentTask()
    {
        $oServiceLocator = &ServiceLocator::instance();
        $oDal   = new MockMAX_Dal_Entities($this);
        $oServiceLocator->register('MAX_Dal_Entities', $oDal);
        $oDal   = new MockOA_Dal_Maintenance_Priority($this);
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);
        $oTable = new MockOA_DB_Table_Priority($this);
        $oServiceLocator->register('OA_DB_Table_Priority',  $oTable);
        return new GetRequiredAdImpressionsType1();
    }

    /**
     * A method to test the _getDate() method.
     *
     * Test 1: Test with no date in the ServiceLocator, and ensure that the
     *         current date/time is returned.
     * Test 2: Test with a date in the ServiceLocator, and ensure that the
     *         correct date/time is returned.
     * Test 3: Test with a date passed in as a parameter, and ensure that the
     *         correct date/time is returned.
     */
    function test_getDate()
    {
        $oGetRequiredAdImpressionsType1 = &$this->_getCurrentTask();

        // Test 1
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->remove('now');
        $oDate1 = $oGetRequiredAdImpressionsType1->_getDate();
        $oDate2 = $oServiceLocator->get('now');
        $this->assertTrue(is_a($oDate1, 'Date'));
        $this->assertTrue(is_a($oDate2, 'Date'));
        $this->assertTrue($oDate1->equals($oDate2));

        // Test 2
        $oDate1 = new Date();
        $oServiceLocator->register('now', $oDate1);
        $oDate2 = $oGetRequiredAdImpressionsType1->_getDate();
        $this->assertTrue(is_a($oDate2, 'Date'));
        $this->assertTrue($oDate1->equals($oDate2));

        // Test 3
        $oDate1 = new Date('2005-12-08 13:55:00');
        $oDate2 = $oGetRequiredAdImpressionsType1->_getDate($oDate1->format('%Y-%m-%d %H:%M:%S'));
        $this->assertTrue(is_a($oDate2, 'Date'));
        $this->assertTrue($oDate1->equals($oDate2));
    }

    /**
     * A method to test the _getAllPlacements() method.
     *
     * For each test, sets the return value of the mocked DAL object's
     * getPlacements() method, and then ensure that the returned value
     * from a call to the getAllPlacements() method is correct.
     *
     * Test 1: Tests when no data is returned from the DAL.
     * Test 2: Tests where data is returned from the DAL.
     */
    function test_getAllPlacements()
    {
        $oGetRequiredAdImpressionsType1 = &$this->_getCurrentTask();

        // Test 1
        $oGetRequiredAdImpressionsType1->oDal->setReturnValueAt(0, 'getPlacements', array());
        $oResult = $oGetRequiredAdImpressionsType1->_getAllPlacements();
        $this->assertTrue(is_array($oResult));
        $this->assertEqual(count($oResult), 0);

        // Test 2
        $oGetRequiredAdImpressionsType1->oDal->setReturnValueAt(
            1,
            'getPlacements',
            array(
                array(
                    'campaignid'        => 1,
                    'expire'            => '2005-12-08 13:55:00',
                    'views'             => 10,
                    'clicks'            => 20,
                    'conversions'       => 30,
                    'target_impression' => 5,
                    'target_click'      => 6,
                    'target_conversion' => 7,
                    'priority'          => 3
                ),
                array(
                    'campaignid'        => 2,
                    'expire'            => '2005-12-08 13:55:01',
                    'views'             => 11,
                    'clicks'            => 21,
                    'conversions'       => 31,
                    'target_impression' => 6,
                    'target_click'      => 7,
                    'target_conversion' => 8,
                    'priority'          => 4
                )
            )
        );
        $oResult = $oGetRequiredAdImpressionsType1->_getAllPlacements();
        $this->assertTrue(is_array($oResult));
        $this->assertEqual(count($oResult), 2);
        $this->assertTrue(is_a($oResult[0], 'MAX_Entity_Placement'));
        $this->assertEqual($oResult[0]->id, 1);
        $this->assertEqual($oResult[0]->expire, '2005-12-08 13:55:00');
        $this->assertEqual($oResult[0]->impressionTargetTotal, 10);
        $this->assertEqual($oResult[0]->clickTargetTotal, 20);
        $this->assertEqual($oResult[0]->conversionTargetTotal, 30);
        $this->assertEqual($oResult[0]->impressionTargetDaily, 5);
        $this->assertEqual($oResult[0]->clickTargetDaily, 6);
        $this->assertEqual($oResult[0]->conversionTargetDaily, 7);
        $this->assertEqual($oResult[0]->priority, 3);
        $this->assertTrue(is_a($oResult[1], 'MAX_Entity_Placement'));
        $this->assertEqual($oResult[1]->id, 2);
        $this->assertEqual($oResult[1]->expire, '2005-12-08 13:55:01');
        $this->assertEqual($oResult[1]->impressionTargetTotal, 11);
        $this->assertEqual($oResult[1]->clickTargetTotal, 21);
        $this->assertEqual($oResult[1]->conversionTargetTotal, 31);
        $this->assertEqual($oResult[1]->impressionTargetDaily, 6);
        $this->assertEqual($oResult[1]->clickTargetDaily, 7);
        $this->assertEqual($oResult[1]->conversionTargetDaily, 8);
        $this->assertEqual($oResult[1]->priority, 4);
    }

    /**
     * A method to test the _getValidPlacements() method.
     *
     * Test 1: Sets the "current" time in the ServiceLocator, and then
     *         uses a the mocked DAL class to ensure that the
     *         _getValidPlacements() method forms the correct "where"
     *         statements, and that these are passed in via the
     *         getAllPlacements() method.
     */
    function test_getValidPlacements()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $table = $aConf['table']['prefix'] . $aConf['table']['campaigns'];
        $oGetRequiredAdImpressionsType1 = &$this->_getCurrentTask();

        // Test 1
        $oServiceLocator = &ServiceLocator::instance();
        $oDate = new Date('2005-12-08 13:55:00');
        $oServiceLocator->register('now', $oDate);
        $oGetRequiredAdImpressionsType1->oDal->setReturnValue('getPlacements', array());
        $oGetRequiredAdImpressionsType1->oDal->expectOnce(
            'getPlacements',
            array(
                array(),
                array(
                    array("($table.activate " . OA_Dal::equalNoDateString() . " OR $table.activate <= '" . $oDate->format('%Y-%m-%d') . "')", 'AND'),
                    array("$table.expire >= '" . $oDate->format('%Y-%m-%d') . "'", 'AND'),
                    array("$table.priority >= 1", 'AND'),
                    array("$table.active = 't'", 'AND'),
                    array("($table.views > 0 OR $table.clicks > 0 OR $table.conversions > 0)", 'AND')
                )
            )
        );
        $oResult = $oGetRequiredAdImpressionsType1->_getValidPlacements();
        $this->assertTrue(is_array($oResult));
        $this->assertEqual(count($oResult), 0);
    }

    /**
     * A method to test the _getInventoryImpressionsRequired() method.
     *
     * Test 1: Test with no inventory required, and ensure that 0 is returned.
     * Test 2: Test with inventory required, but no past data, and ensure that
     *         the default ratio is used correctly.
     * Test 3: Test with inventory required, but no past data, and ensure that
     *         the default ratio is used correctly, and that values are rounded
     *         up.
     * Test 4: Test with past data, and ensure that real ratio is calculated
     *         and used correctly.
     */
    function test_getInventoryImpressionsRequired()
    {
        $oGetRequiredAdImpressionsType1 = &$this->_getCurrentTask();

        // Test 1
        $inventory = 0;
        $defaultRatio = 0.1;
        $result = $oGetRequiredAdImpressionsType1->_getInventoryImpressionsRequired($inventory, $defaultRatio);
        $this->assertEqual($result, 0);

        // Test 2
        $inventory = 1;
        $defaultRatio = 0.1;
        $result = $oGetRequiredAdImpressionsType1->_getInventoryImpressionsRequired($inventory, $defaultRatio);
        $this->assertEqual($result, 10);

        // Test 3
        $inventory = 1;
        $defaultRatio = 0.3;
        $result = $oGetRequiredAdImpressionsType1->_getInventoryImpressionsRequired($inventory, $defaultRatio);
        $this->assertEqual($result, 4);

        // Test 4
        $inventory = 1;
        $defaultRatio = 0.3;
        $inventoryToDate = 100;
        $impressionsToDate = 100000;
        $result = $oGetRequiredAdImpressionsType1->_getInventoryImpressionsRequired(
            $inventory,
            $defaultRatio,
            $inventoryToDate,
            $impressionsToDate
        );
        $this->assertEqual($result, 1000);
    }

    /**
     * A method to test the _getSmallestNonZeroInteger() method.
     */
    function test_getSmallestNonZeroInteger()
    {
        $oGetRequiredAdImpressionsType1 = &$this->_getCurrentTask();
        $this->assertEqual(0, $oGetRequiredAdImpressionsType1->_getSmallestNonZeroInteger(array(0,0,0)));
        $this->assertEqual(1, $oGetRequiredAdImpressionsType1->_getSmallestNonZeroInteger(array(1,0,0)));
        $this->assertEqual(1, $oGetRequiredAdImpressionsType1->_getSmallestNonZeroInteger(array(-1,1,1)));
        $this->assertEqual(1, $oGetRequiredAdImpressionsType1->_getSmallestNonZeroInteger(array(1,1,1)));
        $this->assertEqual(0, $oGetRequiredAdImpressionsType1->_getSmallestNonZeroInteger(array(-1,-1,-1)));
        $this->assertEqual(4, $oGetRequiredAdImpressionsType1->_getSmallestNonZeroInteger(array(32,18,4)));
        $this->assertEqual(0, $oGetRequiredAdImpressionsType1->_getSmallestNonZeroInteger(array(-1,'what','string')));
        $this->assertEqual(0, $oGetRequiredAdImpressionsType1->_getSmallestNonZeroInteger('foo'));
        $this->assertEqual(0, $oGetRequiredAdImpressionsType1->_getSmallestNonZeroInteger(5000));
        $this->assertEqual(0, $oGetRequiredAdImpressionsType1->_getSmallestNonZeroInteger());
        $this->assertEqual(748, $oGetRequiredAdImpressionsType1->_getSmallestNonZeroInteger(array(748,849,35625)));
    }

    /**
     * A method to test the getPlacementImpressionInventoryRequirement() method.
     */
    function testGetPlacementImpressionInventoryRequirement()
    {
        // Generate a partial mock of the Placement class, and override
        // the setSummaryStatisticsToDate() method, so that it doesn't
        // actually call the DAL when the
        // getPlacementImpressionInventoryRequirement() is called
        Mock::generatePartial(
            'MAX_Entity_Placement',
            'MockPartialMAX_Entity_Placement_GetRequiredAdImpressions',
            array('setSummaryStatisticsToDate')
        );
        $oPlacement = new MockPartialMAX_Entity_Placement_GetRequiredAdImpressions($this);
        $oPlacement->MAX_Entity_Placement(array('placement_id' => 1));

        // Manually set the remaining inventory that would normally be
        // set by the mocked setSummaryStatisticsToDate() method above
        $oPlacement->deliveredImpressions = 10000;
        $oPlacement->deliveredClicks      = 100;
        $oPlacement->deliveredConversions = 10;

        // Set the target impressions, clicks and conversions
        $oPlacement->clickTargetTotal      = 10;
        $oPlacement->conversionTargetTotal = 0;

        // Test the method
        $oGetRequiredAdImpressionsType1 = &$this->_getCurrentTask();
        $oGetRequiredAdImpressionsType1->getPlacementImpressionInventoryRequirement($oPlacement);
        $this->assertEqual(1000, $oPlacement->requiredImpressions);
    }

    /**
     * A method to test the _getPlacementAdWeightTotal() method.
     */
    function test_getPlacementAdWeightTotal()
    {
        // Create a test Placement object with no Ads
        $oPlacement = new MAX_Entity_Placement(array('placement_id' => 1));
        // Test the returned sum is unity
        $oGetRequiredAdImpressionsType1 = &$this->_getCurrentTask();
        $this->assertEqual(1, $oGetRequiredAdImpressionsType1->_getPlacementAdWeightTotal($oPlacement));

        // Create some test Ad objects
        $oAd1 = new MAX_Entity_Ad(array('ad_id' => 1, 'active' => true, 'type' => 'sql', 'weight' => 2));
        $oAd2 = new MAX_Entity_Ad(array('ad_id' => 2, 'active' => true, 'type' => 'sql', 'weight' => 1));
        $oAd3 = new MAX_Entity_Ad(array('ad_id' => 3, 'active' => true, 'type' => 'sql', 'weight' => 0));
        $oAd4 = new MAX_Entity_Ad(array('ad_id' => 4, 'active' => true, 'type' => 'sql', 'weight' => 3));
        $oAd5 = new MAX_Entity_Ad(array('ad_id' => 5, 'active' => true, 'type' => 'sql', 'weight' => -10));
        $oAd6 = new MAX_Entity_Ad(array('ad_id' => 6, 'active' => false, 'type' => 'sql', 'weight' => 100));
        // Create a test Placement object
        $oPlacement = new MAX_Entity_Placement(array('placement_id' => 1));
        // Add the Ads to the Placement
        $oPlacement->aAds[] = $oAd1;
        $oPlacement->aAds[] = $oAd2;
        $oPlacement->aAds[] = $oAd3;
        $oPlacement->aAds[] = $oAd4;
        $oPlacement->aAds[] = $oAd5;
        $oPlacement->aAds[] = $oAd6;
        // Test the returned sum is correct
        $this->assertEqual(6, $oGetRequiredAdImpressionsType1->_getPlacementAdWeightTotal($oPlacement));
    }

    /**
     * A method to test the distributePlacementImpressions() method.
     *
     * The test is carried out by ensuring that the correct values for the required
     * impressions are sent to the DAL's saveRequiredAdImpressions() method.
     */
    function testDistributePlacementImpressions()
    {
        $oGetRequiredAdImpressionsType1 = &$this->_getCurrentTask();
        $aPlacements = array();

        // Set the current date/time
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->remove('now');
        $oDate = new Date('2005-12-09 12:00:01');
        $oServiceLocator->register('now', $oDate);

        // Create a "normal" placement to test with
        $oPlacement = new MAX_Entity_Placement(
            array(
                'campaignid' => 1,
                'activate'   => '2005-11-09',
                'expire'     => '2005-12-09'
            )
        );
        $oPlacement->impressionTargetTotal = 5000;
        $oPlacement->requiredImpressions = 24;
        $oAd = new MAX_Entity_Ad(array('ad_id' => 1, 'weight' => 1, 'active' => 't', 'type' => 'sql'));
        $oPlacement->aAds[] = $oAd;
        $oAd = new MAX_Entity_Ad(array('ad_id' => 2, 'weight' => 1, 'active' => 't', 'type' => 'sql'));
        $oPlacement->aAds[] = $oAd;
        $oAd = new MAX_Entity_Ad(array('ad_id' => 3, 'weight' => 1, 'active' => 'f', 'type' => 'sql'));
        $oPlacement->aAds[] = $oAd;
        $aPlacements[] = $oPlacement;

        // Create a "daily limit" placement to test with
        $oPlacement = new MAX_Entity_Placement(
            array(
                'campaignid' => 2,
                'expire'     => '0000-00-00'
            )
        );
        $oPlacement->impressionTargetDaily = 24;
        $oPlacement->requiredImpressions = 24;
        $oAd = new MAX_Entity_Ad(array('ad_id' => 4, 'weight' => 1, 'active' => 't', 'type' => 'sql'));
        $oPlacement->aAds[] = $oAd;
        $oAd = new MAX_Entity_Ad(array('ad_id' => 5, 'weight' => 1, 'active' => 'f', 'type' => 'sql'));
        $oPlacement->aAds[] = $oAd;
        $aPlacements[] = $oPlacement;

        // Set the DAL saveRequiredAdImpressions() method to expect the
        // desired input from the distributePlacementImpressions() method.
        $oGetRequiredAdImpressionsType1->oDal->expectOnce(
            'saveRequiredAdImpressions',
            array(
                array(
                    array(
                        'ad_id'                => 1,
                        'required_impressions' => (double) 1
                    ),
                    array(
                        'ad_id'                => 2,
                        'required_impressions' => (double) 1
                    ),
                    array(
                        'ad_id'                => 4,
                        'required_impressions' => (double) 2
                    )
                )
            )
        );

        // Test
        $oGetRequiredAdImpressionsType1->distributePlacementImpressions($aPlacements);
    }

    /**
     * A method to test the distributePlacementImpressionsByZonePattern() method.
     *
     * The test is carried out by ensuring that the correct values for the required
     * impressions are sent to the DAL's saveRequiredAdImpressions() method.
     *
     * The test uses equal cumulative zone forecasts for each operation interval,
     * and the advertisements are not delivery limited, so that the expected
     * required impression results are the same as those in the test above.
     */
    function testDistributePlacementImpressionsByZonePattern()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;

        $oGetRequiredAdImpressionsType1 = &$this->_getCurrentTask();
        $aPlacements = array();

        // Set the current date/time
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->remove('now');
        $oDate = new Date('2006-02-12 12:00:01');
        $oServiceLocator->register('now', $oDate);

        // Create a "normal" placement to test with
        $oPlacement = new MAX_Entity_Placement(
            array(
                'campaignid' => 1,
                'activate'   => '2006-01-12',
                'expire'     => '2006-02-12'
            )
        );
        $oPlacement->impressionTargetTotal = 5000;
        $oPlacement->requiredImpressions = 24;
        $oAd = new MAX_Entity_Ad(array('ad_id' => 1, 'weight' => 1, 'active' => 't', 'type' => 'sql'));
        $oPlacement->aAds[] = $oAd;
        $oAd = new MAX_Entity_Ad(array('ad_id' => 2, 'weight' => 1, 'active' => 't', 'type' => 'sql'));
        $oPlacement->aAds[] = $oAd;
        $oAd = new MAX_Entity_Ad(array('ad_id' => 3, 'weight' => 1, 'active' => 'f', 'type' => 'sql'));
        $oPlacement->aAds[] = $oAd;
        $aPlacements[] = $oPlacement;

        // Create a "daily limit" placement to test with
        $oPlacement = new MAX_Entity_Placement(
            array(
                'campaignid' => 2,
                'expire'     => '0000-00-00'
            )
        );
        $oPlacement->impressionTargetDaily = 24;
        $oPlacement->requiredImpressions = 24;
        $oAd = new MAX_Entity_Ad(array('ad_id' => 4, 'weight' => 1, 'active' => 't', 'type' => 'sql'));
        $oPlacement->aAds[] = $oAd;
        $oAd = new MAX_Entity_Ad(array('ad_id' => 5, 'weight' => 1, 'active' => 'f', 'type' => 'sql'));
        $oPlacement->aAds[] = $oAd;
        $aPlacements[] = $oPlacement;

        // Set the zones that each ad is linked to
        for ($i = 1; $i <= 5; $i++) {
            $aReturn = array(
                $i => array(
                    0 => array(
                        'zone_id' => $i
                    )
                )
            );
            $oGetRequiredAdImpressionsType1->oDal->setReturnValue(
                'getAdZoneAssociationsByAds',
                $aReturn,
                array(
                    array($i)
                )
            );
        }

        // Set the number of zone forecast impressions in each operation interval
        for ($i = 1; $i <= 5; $i++) {
            $aReturn = array();
            for ($interval = 12; $interval <= 23; $interval++) {
                $aReturn[$interval] = array(
                    'zone_id'               => $i,
                    'forecast_impressions'  => 10,
                    'operation_interval_id' => $interval
                );
            }
            $oGetRequiredAdImpressionsType1->oDal->setReturnValue(
                'getPreviousWeekZoneForcastImpressions',
                $aReturn,
                array($i)
            );
        }

        // Set the DAL saveRequiredAdImpressions() method to expect the
        // desired input from the distributePlacementImpressions() method.
        $oGetRequiredAdImpressionsType1->oDal->expectOnce(
            'saveRequiredAdImpressions',
            array(
                array(
                    array(
                        'ad_id'                => 1,
                        'required_impressions' => (double) 1
                    ),
                    array(
                        'ad_id'                => 2,
                        'required_impressions' => (double) 1
                    ),
                    array(
                        'ad_id'                => 4,
                        'required_impressions' => (double) 2
                    )
                )
            )
        );

        // Test
        $oGetRequiredAdImpressionsType1->distributePlacementImpressionsByZonePattern($aPlacements);

        TestEnv::restoreConfig();
    }

    /**
     * A method to test the _getAdImpressionsByZonePattern() method.
     *
     * Test 1: Test with invalid parameters, and ensure that zero impressions are
     *         allocated.
     * Test 2: Test with an advertisement that is currently blocked, and ensure
     *         that zero impressions are allocated.
     * Test 3: Test with an advertisement that is not currently blocked, but with
     *         no impressions in the cumulative zone forecast, and ensure that
     *         zero impressions are allocated.
     * Test 4: Test with a simple, single operation interval cumulative zone forecast,
     *         and a blocking delivery limitation, and ensure that the correct number
     *         of impressions are allocated.
     * Test 5: Test with a simple, even operation interval cumulative zone forecast,
     *         and a blocking delivery limitation, and ensure that the correct number
     *         of impressions are allocated.
     * Test 6: Test with an uneven operation interval cumulative zone forecast, and
     *         a blocking delivery limitation, and ensure that the correct number of
     *         impressions are allocated.
     */
    function test_getAdImpressionsByZonePattern()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;

        Mock::generatePartial(
            'MAX_Entity_Ad',
            'PartialMockMAX_Entity_Ad',
            array('getDeliveryLimitations')
        );
        Mock::generatePartial(
            'GetRequiredAdImpressionsType1',
            'PartialMockGetRequiredAdImpressionsType1',
            array('_getCumulativeZoneForecast')
        );

        // Test 1
        $oAd = new MAX_Entity_Ad(array('ad_id' => 1, 'weight' => 1, 'active' => 't', 'type' => 'sql'));
        $totalRequiredAdImpressions = 10;
        $oDate = new Date();
        $oPlacementExpiryDate = new Date();
        $oGetRequiredAdImpressionsType1 = &$this->_getCurrentTask();
        $result = $oGetRequiredAdImpressionsType1->_getAdImpressionsByZonePattern(
            'foo',
            $totalRequiredAdImpressions,
            $oDate,
            $oPlacementExpiryDate
        );
        $this->assertEqual($result, 0);
        $result = $oGetRequiredAdImpressionsType1->_getAdImpressionsByZonePattern(
            $oAd,
            'foo',
            $oDate,
            $oPlacementExpiryDate
        );
        $this->assertEqual($result, 0);
        $result = $oGetRequiredAdImpressionsType1->_getAdImpressionsByZonePattern(
            $oAd,
            $totalRequiredAdImpressions,
            'foo',
            $oPlacementExpiryDate
        );
        $this->assertEqual($result, 0);
        $result = $oGetRequiredAdImpressionsType1->_getAdImpressionsByZonePattern(
            $oAd,
            $totalRequiredAdImpressions,
            $oDate,
            'foo'
        );
        $this->assertEqual($result, 0);

        // Test 2
        $oAd = new PartialMockMAX_Entity_Ad($this);
        $aParam = array('ad_id' => 1, 'weight' => 1, 'active' => 't', 'type' => 'sql');
        $oAd->setReturnValue(
            'getDeliveryLimitations',
            array(
                array(
                    'ad_id'          => 1,
                    'logical'        => 'and',
                    'type'           => 'Time:Hour',
                    'comparison'     => '!~',
                    'data'           => '12',
                    'executionorder' => 0
                )
            )
        );
        $oAd->Max_Entity_Ad($aParam);
        $totalRequiredAdImpressions = 120;
        $oDate = new Date('2006-02-15 12:07:01');
        $oPlacementExpiryDate = new Date('2006-12-15 23:59:59');
        $oGetRequiredAdImpressionsType1 = &$this->_getCurrentTask();
        $result = $oGetRequiredAdImpressionsType1->_getAdImpressionsByZonePattern(
            $oAd,
            $totalRequiredAdImpressions,
            $oDate,
            $oPlacementExpiryDate
        );
        $this->assertEqual($result, 0);

        // Test 3
        $oAd = new PartialMockMAX_Entity_Ad($this);
        $aParam = array('ad_id' => 1, 'weight' => 1, 'active' => 't', 'type' => 'sql');
        $oAd->setReturnValue(
            'getDeliveryLimitations',
            array(
                array(
                    'ad_id'          => 1,
                    'logical'        => 'and',
                    'type'           => 'Time:Hour',
                    'comparison'     => '!~',
                    'data'           => '15',
                    'executionorder' => 0
                )
            )
        );
        $oAd->Max_Entity_Ad($aParam);
        $totalRequiredAdImpressions = 110;
        $oDate = new Date('2006-02-15 12:07:01');
        $oPlacementExpiryDate = new Date('2006-02-15 23:59:59');
        $oGetRequiredAdImpressionsType1 = new PartialMockGetRequiredAdImpressionsType1($this);
        $oGetRequiredAdImpressionsType1->setReturnValue(
            '_getCumulativeZoneForecast',
            array()
        );
        $oGetRequiredAdImpressionsType1->GetRequiredAdImpressionsType1();
        $result = $oGetRequiredAdImpressionsType1->_getAdImpressionsByZonePattern(
            $oAd,
            $totalRequiredAdImpressions,
            $oDate,
            $oPlacementExpiryDate
        );
        $this->assertEqual($result, 0);

        // Test 4
        $oAd = new PartialMockMAX_Entity_Ad($this);
        $aParam = array('ad_id' => 1, 'weight' => 1, 'active' => 't', 'type' => 'sql');
        $oAd->setReturnValue(
            'getDeliveryLimitations',
            array(
                array(
                    'ad_id'          => 1,
                    'logical'        => 'and',
                    'type'           => 'Time:Hour',
                    'comparison'     => '!~',
                    'data'           => '15',
                    'executionorder' => 0
                )
            )
        );
        $oAd->Max_Entity_Ad($aParam);
        $totalRequiredAdImpressions = 110;
        $oDate = new Date('2006-02-15 12:07:01');
        $oPlacementExpiryDate = new Date('2006-02-15 23:59:59');
        $oGetRequiredAdImpressionsType1 = new PartialMockGetRequiredAdImpressionsType1($this);
        $aCumulativeZoneForecast = array();
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 12:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $oGetRequiredAdImpressionsType1->setReturnValue(
            '_getCumulativeZoneForecast',
            $aCumulativeZoneForecast
        );
        $oGetRequiredAdImpressionsType1->GetRequiredAdImpressionsType1();
        $result = $oGetRequiredAdImpressionsType1->_getAdImpressionsByZonePattern(
            $oAd,
            $totalRequiredAdImpressions,
            $oDate,
            $oPlacementExpiryDate
        );
        $this->assertEqual($result, 110);

        // Test 5
        $oAd = new PartialMockMAX_Entity_Ad($this);
        $aParam = array('ad_id' => 1, 'weight' => 1, 'active' => 't', 'type' => 'sql');
        $oAd->setReturnValue(
            'getDeliveryLimitations',
            array(
                array(
                    'ad_id'          => 1,
                    'logical'        => 'and',
                    'type'           => 'Time:Hour',
                    'comparison'     => '!~',
                    'data'           => '15',
                    'executionorder' => 0
                )
            )
        );
        $oAd->Max_Entity_Ad($aParam);
        $totalRequiredAdImpressions = 110;
        $oDate = new Date('2006-02-15 12:07:01');
        $oPlacementExpiryDate = new Date('2006-02-15 23:59:59');
        $oGetRequiredAdImpressionsType1 = new PartialMockGetRequiredAdImpressionsType1($this);
        $aCumulativeZoneForecast = array();
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 12:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 13:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 14:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 15:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 16:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 17:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 18:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 19:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 20:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 21:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 22:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 23:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $oGetRequiredAdImpressionsType1->setReturnValue(
            '_getCumulativeZoneForecast',
            $aCumulativeZoneForecast
        );
        $oGetRequiredAdImpressionsType1->GetRequiredAdImpressionsType1();
        $result = $oGetRequiredAdImpressionsType1->_getAdImpressionsByZonePattern(
            $oAd,
            $totalRequiredAdImpressions,
            $oDate,
            $oPlacementExpiryDate
        );
        $this->assertEqual($result, 10);

        // Test 6
        $oAd = new PartialMockMAX_Entity_Ad($this);
        $aParam = array('ad_id' => 1, 'weight' => 1, 'active' => 't', 'type' => 'sql');
        $oAd->setReturnValue(
            'getDeliveryLimitations',
            array(
                array(
                    'ad_id'          => 1,
                    'logical'        => 'and',
                    'type'           => 'Time:Hour',
                    'comparison'     => '!~',
                    'data'           => '15',
                    'executionorder' => 0
                )
            )
        );
        $oAd->Max_Entity_Ad($aParam);
        $totalRequiredAdImpressions = 110;
        $oDate = new Date('2006-02-15 12:07:01');
        $oPlacementExpiryDate = new Date('2006-02-15 23:59:59');
        $oGetRequiredAdImpressionsType1 = new PartialMockGetRequiredAdImpressionsType1($this);
        $aCumulativeZoneForecast = array();
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 12:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 10;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 13:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 20;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 14:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 30;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 15:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 40;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 16:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 17:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 60;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 18:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 19:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 40;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 20:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 30;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 21:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 20;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 22:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 10;
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 23:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 10;
        $oGetRequiredAdImpressionsType1->setReturnValue(
            '_getCumulativeZoneForecast',
            $aCumulativeZoneForecast
        );
        $oGetRequiredAdImpressionsType1->GetRequiredAdImpressionsType1();
        $result = $oGetRequiredAdImpressionsType1->_getAdImpressionsByZonePattern(
            $oAd,
            $totalRequiredAdImpressions,
            $oDate,
            $oPlacementExpiryDate
        );
        $this->assertEqual($result, 3);

        TestEnv::restoreConfig();
    }

    /**
     * A method to test the _getCumulativeZoneForecast() method.
     *
     * Test 1: Test with a non-integer ad ID, and ensure false is returned.
     * Test 2: Test with no data in the database, and ensure an array with zero for
     *         each operation interval ID is returned.
     * Test 3: Test with basic, single operation interval past data, and ensure an
     *         array with the past data is returned.
     * Test 4: Test with complex, multiple operation interval past data, and ensure
     *         an array with the past data is returned.
     * Test 5: Re-test, with different return values, and ensure caching works.
     */
    function test_getCumulativeZoneForecast()
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;

        // Test 1
        $oGetRequiredAdImpressionsType1 = &$this->_getCurrentTask();
        $result = $oGetRequiredAdImpressionsType1->_getCumulativeZoneForecast('foo');
        $this->assertFalse($result);

        // Test 2
        $oGetRequiredAdImpressionsType1 = &$this->_getCurrentTask();
        $oGetRequiredAdImpressionsType1->oDal->expectOnce(
            'getAdZoneAssociationsByAds',
            array(
                array(1)
            )
        );
        $oGetRequiredAdImpressionsType1->oDal->setReturnValue(
            'getAdZoneAssociationsByAds',
            array(),
            array(
                array(1)
            )
        );
        $oGetRequiredAdImpressionsType1->oDal->expectNever('getPreviousWeekZoneForcastImpressions');
        $result = $oGetRequiredAdImpressionsType1->_getCumulativeZoneForecast(1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), MINUTES_PER_WEEK / 60);
        for ($i = 0; $i < (MINUTES_PER_WEEK / 60); $i++) {
            $this->assertEqual($result[$i], 0);
        }

        // Test 3
        $oGetRequiredAdImpressionsType1 = &$this->_getCurrentTask();
        $oGetRequiredAdImpressionsType1->oDal->expectOnce(
            'getAdZoneAssociationsByAds',
            array(
                array(1)
            )
        );
        $oGetRequiredAdImpressionsType1->oDal->setReturnValue(
            'getAdZoneAssociationsByAds',
            array(
                1 => array(
                    0 => array(
                        'zone_id' => 1
                    )
                )
            ),
            array(
                array(1)
            )
        );
        $oGetRequiredAdImpressionsType1->oDal->expectOnce(
            'getPreviousWeekZoneForcastImpressions',
            array(1)
        );
        $oGetRequiredAdImpressionsType1->oDal->setReturnValue(
            'getPreviousWeekZoneForcastImpressions',
            array(
                14 => array(
                    'zone_id'               => 1,
                    'forecast_impressions'  => 1,
                    'operation_interval_id' => 14
                )
            ),
            array(1)
        );
        $result = $oGetRequiredAdImpressionsType1->_getCumulativeZoneForecast(1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), MINUTES_PER_WEEK / 60);
        for ($i = 0; $i < (MINUTES_PER_WEEK / 60); $i++) {
            if ($i == 14) {
                $this->assertEqual($result[$i], 1);
            } else {
                $this->assertEqual($result[$i], 0);
            }
        }

        // Test 4
        $oGetRequiredAdImpressionsType1 = &$this->_getCurrentTask();
        $oGetRequiredAdImpressionsType1->oDal->expectOnce(
            'getAdZoneAssociationsByAds',
            array(
                array(1)
            )
        );
        $oGetRequiredAdImpressionsType1->oDal->setReturnValue(
            'getAdZoneAssociationsByAds',
            array(
                1 => array(
                    0 => array(
                        'zone_id' => 1
                    ),
                    1 => array(
                        'zone_id' => 3
                    ),
                    2 => array(
                        'zone_id' => 7
                    )
                )
            ),
            array(
                array(1)
            )
        );
        $oGetRequiredAdImpressionsType1->oDal->expectArgumentsAt(
            0,
            'getPreviousWeekZoneForcastImpressions',
            array(1)
        );
        $oGetRequiredAdImpressionsType1->oDal->setReturnValueAt(
            0,
            'getPreviousWeekZoneForcastImpressions',
            array(
                14 => array(
                    'zone_id'               => 1,
                    'forecast_impressions'  => 10,
                    'operation_interval_id' => 14
                )
            ),
            array(1)
        );
        $oGetRequiredAdImpressionsType1->oDal->expectArgumentsAt(
            1,
            'getPreviousWeekZoneForcastImpressions',
            array(3)
        );
        $oGetRequiredAdImpressionsType1->oDal->setReturnValueAt(
            1,
            'getPreviousWeekZoneForcastImpressions',
            array(
                14 => array(
                    'zone_id'               => 3,
                    'forecast_impressions'  => 10,
                    'operation_interval_id' => 14
                )
            ),
            array(3)
        );
        $oGetRequiredAdImpressionsType1->oDal->expectArgumentsAt(
            2,
            'getPreviousWeekZoneForcastImpressions',
            array(7)
        );
        $oGetRequiredAdImpressionsType1->oDal->setReturnValueAt(
            2,
            'getPreviousWeekZoneForcastImpressions',
            array(
                14 => array(
                    'zone_id'               => 7,
                    'forecast_impressions'  => 10,
                    'operation_interval_id' => 14
                ),
                72 => array(
                    'zone_id'               => 7,
                    'forecast_impressions'  => 50,
                    'operation_interval_id' => 72
                )
            ),
            array(7)
        );
        $result = $oGetRequiredAdImpressionsType1->_getCumulativeZoneForecast(1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), MINUTES_PER_WEEK / 60);
        for ($i = 0; $i < (MINUTES_PER_WEEK / 60); $i++) {
            if ($i == 14) {
                $this->assertEqual($result[$i], 30);
            } elseif ($i == 72) {
                $this->assertEqual($result[$i], 50);
            } else {
                $this->assertEqual($result[$i], 0);
            }
        }

        // Test 5
        $oGetRequiredAdImpressionsType1->oDal->expectOnce(
            'getAdZoneAssociationsByAds',
            array(
                array(1)
            )
        );
        $oGetRequiredAdImpressionsType1->oDal->setReturnValue(
            'getAdZoneAssociationsByAds',
            array(
                1 => array(
                    0 => array(
                        'zone_id' => 1
                    ),
                    1 => array(
                        'zone_id' => 3
                    ),
                    2 => array(
                        'zone_id' => 7
                    )
                )
            ),
            array(
                array(1)
            )
        );
        $oGetRequiredAdImpressionsType1->oDal->expectArgumentsAt(
            0,
            'getPreviousWeekZoneForcastImpressions',
            array(1)
        );
        $oGetRequiredAdImpressionsType1->oDal->setReturnValueAt(
            0,
            'getPreviousWeekZoneForcastImpressions',
            array(
                14 => array(
                    'zone_id'               => 1,
                    'forecast_impressions'  => 15,
                    'operation_interval_id' => 14
                )
            ),
            array(1)
        );
        $oGetRequiredAdImpressionsType1->oDal->expectArgumentsAt(
            1,
            'getPreviousWeekZoneForcastImpressions',
            array(3)
        );
        $oGetRequiredAdImpressionsType1->oDal->setReturnValueAt(
            1,
            'getPreviousWeekZoneForcastImpressions',
            array(
                14 => array(
                    'zone_id'               => 3,
                    'forecast_impressions'  => 15,
                    'operation_interval_id' => 14
                )
            ),
            array(3)
        );
        $oGetRequiredAdImpressionsType1->oDal->expectArgumentsAt(
            2,
            'getPreviousWeekZoneForcastImpressions',
            array(7)
        );
        $oGetRequiredAdImpressionsType1->oDal->setReturnValueAt(
            2,
            'getPreviousWeekZoneForcastImpressions',
            array(
                14 => array(
                    'zone_id'               => 7,
                    'forecast_impressions'  => 15,
                    'operation_interval_id' => 14
                ),
                72 => array(
                    'zone_id'               => 7,
                    'forecast_impressions'  => 65,
                    'operation_interval_id' => 72
                )
            ),
            array(7)
        );
        $result = $oGetRequiredAdImpressionsType1->_getCumulativeZoneForecast(1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), MINUTES_PER_WEEK / 60);
        for ($i = 0; $i < (MINUTES_PER_WEEK / 60); $i++) {
            if ($i == 14) {
                $this->assertEqual($result[$i], 30); // Not sum of above, use cached values
            } elseif ($i == 72) {
                $this->assertEqual($result[$i], 50); // Not sum of above, use cached values
            } else {
                $this->assertEqual($result[$i], 0);
            }
        }
        TestEnv::restoreConfig();
    }

}

?>
