<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/Ad.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/GetRequiredAdImpressionsLifetime.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A class for testing the OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime()
    {
        $this->UnitTestCase();
        Mock::generate('MAX_Dal_Entities');
        Mock::generate('OA_Dal_Maintenance_Priority');
        Mock::generate('OA_DB_Table_Priority');
    }

    /**
     * Set up database
     */
    function setUp()
    {
        TestEnv::teardownDB();
        TestEnv::setupDB();
        return parent::setUp();
    }

    /**
     * A private method for the test class that creates an instance of the mocked
     * DAL class (MAX_Dal_Maintenance), the mocked table creation class
     * (OA_DB_Table_Priority), registers the mocked classes in the OA_ServiceLocator,
     * and then returns an instance of the
     * OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime class
     * to use in testing.
     *
     * @access private
     * @return OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime
     */
    function &_getCurrentTask()
    {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDal   = new MockMAX_Dal_Entities($this);
        $oServiceLocator->register('MAX_Dal_Entities', $oDal);
        $oDal   = new MockOA_Dal_Maintenance_Priority($this);
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);
        $oTable = new MockOA_DB_Table_Priority($this);
        $oServiceLocator->register('OA_DB_Table_Priority',  $oTable);
        return new OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime();
    }

    /**
     * A method to test the _getDate() method.
     *
     * Test 1: Test with no date in the OA_ServiceLocator, and ensure that the
     *         current date/time is returned.
     * Test 2: Test with a date in the OA_ServiceLocator, and ensure that the
     *         correct date/time is returned.
     * Test 3: Test with a date passed in as a parameter, and ensure that the
     *         correct date/time is returned.
     */
    function test_getDate()
    {
        $oGetRequiredAdImpressionsLifetime =& $this->_getCurrentTask();

        // Test 1
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->remove('now');
        $oDate1 = $oGetRequiredAdImpressionsLifetime->_getDate();
        $oDate2 = $oServiceLocator->get('now');
        $this->assertTrue(is_a($oDate1, 'Date'));
        $this->assertTrue(is_a($oDate2, 'Date'));
        $this->assertTrue($oDate1->equals($oDate2));

        // Test 2
        $oDate1 = new Date();
        $oServiceLocator->register('now', $oDate1);
        $oDate2 = $oGetRequiredAdImpressionsLifetime->_getDate();
        $this->assertTrue(is_a($oDate2, 'Date'));
        $this->assertTrue($oDate1->equals($oDate2));

        // Test 3
        $oDate1 = new Date('2005-12-08 13:55:00');
        $oDate2 = $oGetRequiredAdImpressionsLifetime->_getDate($oDate1->format('%Y-%m-%d %H:%M:%S'));
        $this->assertTrue(is_a($oDate2, 'Date'));
        $this->assertTrue($oDate1->equals($oDate2));
    }

    /**
     * A method to test the _getAllCampaigns() method.
     *
     * For each test, sets the return value of the mocked DAL object's
     * getPlacements() method, and then ensure that the returned value
     * from a call to the getAllCampaigns() method is correct.
     *
     * Test 1: Tests when no data is returned from the DAL.
     * Test 2: Tests where data is returned from the DAL.
     */
    function test_getAllCampaigns()
    {
        $oGetRequiredAdImpressionsLifetime =& $this->_getCurrentTask();

        // Test 1
        $oGetRequiredAdImpressionsLifetime->oDal->setReturnValueAt(0, 'getPlacements', array());
        $oResult = $oGetRequiredAdImpressionsLifetime->_getAllCampaigns();
        $this->assertTrue(is_array($oResult));
        $this->assertEqual(count($oResult), 0);

        // Test 2
        $oGetRequiredAdImpressionsLifetime->oDal->setReturnValueAt(
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
        $oResult = $oGetRequiredAdImpressionsLifetime->_getAllCampaigns();
        $this->assertTrue(is_array($oResult));
        $this->assertEqual(count($oResult), 2);
        $this->assertTrue(is_a($oResult[0], 'OX_Maintenance_Priority_Campaign'));
        $this->assertEqual($oResult[0]->id, 1);
        $this->assertEqual($oResult[0]->expire, '2005-12-08 13:55:00');
        $this->assertEqual($oResult[0]->impressionTargetTotal, 10);
        $this->assertEqual($oResult[0]->clickTargetTotal, 20);
        $this->assertEqual($oResult[0]->conversionTargetTotal, 30);
        $this->assertEqual($oResult[0]->impressionTargetDaily, 5);
        $this->assertEqual($oResult[0]->clickTargetDaily, 6);
        $this->assertEqual($oResult[0]->conversionTargetDaily, 7);
        $this->assertEqual($oResult[0]->priority, 3);
        $this->assertTrue(is_a($oResult[1], 'OX_Maintenance_Priority_Campaign'));
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
     * A method to test the _getValidCampaigns() method.
     *
     * Test 1: Sets the "current" time in the OA_ServiceLocator, and then
     *         uses a the mocked DAL class to ensure that the
     *         _getValidCampaigns() method forms the correct "where"
     *         statements, and that these are passed in via the
     *         getAllCampaigns() method.
     */
    function test_getValidCampaigns()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $table = $aConf['table']['prefix'] . $aConf['table']['campaigns'];
        $oGetRequiredAdImpressionsLifetime =& $this->_getCurrentTask();

        // Test 1
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDate = new Date('2005-12-08 13:55:00');
        $oServiceLocator->register('now', $oDate);
        $oGetRequiredAdImpressionsLifetime->oDal->setReturnValue('getPlacements', array());
        $oDbh = OA_DB::singleton();
        $table = $oDbh->quoteIdentifier($table, true);
        $oGetRequiredAdImpressionsLifetime->oDal->expectOnce(
            'getPlacements',
            array(
                array(),
                array(
                    array("($table.activate " . OA_Dal::equalNoDateString() . " OR $table.activate <= '" . $oDate->format('%Y-%m-%d') . "')", 'AND'),
                    array("$table.expire >= '" . $oDate->format('%Y-%m-%d') . "'", 'AND'),
                    array("$table.priority >= 1", 'AND'),
                    array("$table.status = " . OA_ENTITY_STATUS_RUNNING, 'AND'),
                    array("($table.views > 0 OR $table.clicks > 0 OR $table.conversions > 0)", 'AND')
                )
            )
        );
        $oResult = $oGetRequiredAdImpressionsLifetime->_getValidCampaigns();
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
        $oGetRequiredAdImpressionsLifetime =& $this->_getCurrentTask();

        // Test 1
        $inventory = 0;
        $defaultRatio = 0.1;
        $result = $oGetRequiredAdImpressionsLifetime->_getInventoryImpressionsRequired($inventory, $defaultRatio);
        $this->assertEqual($result, 0);

        // Test 2
        $inventory = 1;
        $defaultRatio = 0.1;
        $result = $oGetRequiredAdImpressionsLifetime->_getInventoryImpressionsRequired($inventory, $defaultRatio);
        $this->assertEqual($result, 10);

        // Test 3
        $inventory = 1;
        $defaultRatio = 0.3;
        $result = $oGetRequiredAdImpressionsLifetime->_getInventoryImpressionsRequired($inventory, $defaultRatio);
        $this->assertEqual($result, 4);

        // Test 4
        $inventory = 1;
        $defaultRatio = 0.3;
        $inventoryToDate = 100;
        $impressionsToDate = 100000;
        $result = $oGetRequiredAdImpressionsLifetime->_getInventoryImpressionsRequired(
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
        $oGetRequiredAdImpressionsLifetime =& $this->_getCurrentTask();
        $this->assertEqual(0, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger(array(0,0,0)));
        $this->assertEqual(1, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger(array(1,0,0)));
        $this->assertEqual(1, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger(array(-1,1,1)));
        $this->assertEqual(1, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger(array(1,1,1)));
        $this->assertEqual(0, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger(array(-1,-1,-1)));
        $this->assertEqual(4, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger(array(32,18,4)));
        $this->assertEqual(0, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger(array(-1,'what','string')));
        $this->assertEqual(0, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger('foo'));
        $this->assertEqual(0, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger(5000));
        $this->assertEqual(0, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger());
        $this->assertEqual(748, $oGetRequiredAdImpressionsLifetime->_getSmallestNonZeroInteger(array(748,849,35625)));
    }

    /**
     * A method to test the getCampaignImpressionInventoryRequirement() method.
     */
    function testGetCampaignImpressionInventoryRequirement()
    {
        // Generate a partial mock of the Campaign class, and override
        // the setSummaryStatisticsToDate() method, so that it doesn't
        // actually call the DAL when the
        // getCampaignImpressionInventoryRequirement() is called
        Mock::generatePartial(
            'OX_Maintenance_Priority_Campaign',
            'MockPartialOX_Maintenance_Priority_Campaign_GetRequiredAdImpressions',
            array('setSummaryStatisticsToDate')
        );
        $oCampaign = new MockPartialOX_Maintenance_Priority_Campaign_GetRequiredAdImpressions($this);
        $oCampaign->OX_Maintenance_Priority_Campaign(array('placement_id' => 1));

        // Manually set the remaining inventory that would normally be
        // set by the mocked setSummaryStatisticsToDate() method above
        $oCampaign->deliveredImpressions = 10000;
        $oCampaign->deliveredClicks      = 100;
        $oCampaign->deliveredConversions = 10;

        // Set the target impressions, clicks and conversions
        $oCampaign->clickTargetTotal      = 10;
        $oCampaign->conversionTargetTotal = 0;

        // Test the method
        $oGetRequiredAdImpressionsLifetime =& $this->_getCurrentTask();
        $oGetRequiredAdImpressionsLifetime->getCampaignImpressionInventoryRequirement($oCampaign);
        $this->assertEqual(1000, $oCampaign->requiredImpressions);
    }

    /**
     * A method to test the distributeCampaignImpressions() method.
     *
     * The test is carried out by ensuring that the correct values for the required
     * impressions are sent to the DAL's saveRequiredAdImpressions() method.
     *
     * The test uses equal cumulative zone forecasts for each operation interval,
     * and the advertisements are not delivery limited, so that the expected
     * required impression results are the same as those in the test above.
     */
    function testDistributeCampaignImpressions()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;

        $oGetRequiredAdImpressionsLifetime =& $this->_getCurrentTask();
        $aCampaigns = array();

        // Set the current date/time
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->remove('now');
        $oDate = new Date('2006-02-12 12:00:01');
        $oServiceLocator->register('now', $oDate);

        // Create a "normal" placement to test with
        $oCampaign = new OX_Maintenance_Priority_Campaign(
            array(
                'campaignid' => 1,
                'activate'   => '2006-01-12',
                'expire'     => '2006-02-12'
            )
        );
        $oCampaign->impressionTargetTotal = 5000;
        $oCampaign->requiredImpressions = 24;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1, 'weight' => 1, 'status' => OA_ENTITY_STATUS_RUNNING, 'type' => 'sql'));
        $oCampaign->aAds[] = $oAd;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 2, 'weight' => 1, 'status' => OA_ENTITY_STATUS_RUNNING, 'type' => 'sql'));
        $oCampaign->aAds[] = $oAd;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 3, 'weight' => 1, 'status' => OA_ENTITY_STATUS_AWAITING, 'type' => 'sql'));
        $oCampaign->aAds[] = $oAd;
        $aCampaigns[] = $oCampaign;

        // Create a "daily limit" placement to test with
        $oCampaign = new OX_Maintenance_Priority_Campaign(
            array(
                'campaignid' => 2,
                'expire'     => OA_Dal::noDateValue()
            )
        );
        $oCampaign->impressionTargetDaily = 24;
        $oCampaign->requiredImpressions = 24;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 4, 'weight' => 1, 'status' => OA_ENTITY_STATUS_RUNNING, 'type' => 'sql'));
        $oCampaign->aAds[] = $oAd;
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 5, 'weight' => 1, 'status' => OA_ENTITY_STATUS_AWAITING, 'type' => 'sql'));
        $oCampaign->aAds[] = $oAd;
        $aCampaigns[] = $oCampaign;

        // Set the zones that each ad is linked to
        for ($i = 1; $i <= 5; $i++) {
            $aReturn = array(
                $i => array(
                    0 => array(
                        'zone_id' => $i
                    )
                )
            );
            $oGetRequiredAdImpressionsLifetime->oDal->setReturnValue(
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
            $oGetRequiredAdImpressionsLifetime->oDal->setReturnValue(
                'getPreviousWeekZoneForcastImpressions',
                $aReturn,
                array($i)
            );
        }

        // Set the DAL saveRequiredAdImpressions() method to expect the
        // desired input from the distributeCampaignImpressions() method.
        $oGetRequiredAdImpressionsLifetime->oDal->expectOnce(
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
        $oGetRequiredAdImpressionsLifetime->distributeCampaignImpressions($aCampaigns);

        TestEnv::restoreConfig();
    }

    /**
     * A method to test the _getAdImpressions() method.
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
    function test_getAdImpressions()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;

        Mock::generatePartial(
            'OA_Maintenance_Priority_Ad',
            'PartialMockOA_Maintenance_Priority_Ad',
            array('getDeliveryLimitations')
        );
        Mock::generatePartial(
            'OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime',
            'PartialMockOA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime',
            array('_getCumulativeZoneForecast')
        );

        // Test 1
        $oAd = new OA_Maintenance_Priority_Ad(array('ad_id' => 1, 'weight' => 1, 'status' => OA_ENTITY_STATUS_RUNNING, 'type' => 'sql'));
        $totalRequiredAdImpressions = 10;
        $oDate = new Date();
        $oCampaignExpiryDate = new Date();
        $oGetRequiredAdImpressionsLifetime =& $this->_getCurrentTask();
        $oDeliveryLimitaions = new OA_Maintenance_Priority_DeliveryLimitation(null);
        $aAdZones = array();
        $result = $oGetRequiredAdImpressionsLifetime->_getAdImpressions(
            'foo',
            $totalRequiredAdImpressions,
            $oDate,
            $oCampaignExpiryDate,
            $oDeliveryLimitaions,
            $aAdZones
        );
        $this->assertEqual($result, 0);
        $result = $oGetRequiredAdImpressionsLifetime->_getAdImpressions(
            $oAd,
            'foo',
            $oDate,
            $oCampaignExpiryDate,
            $oDeliveryLimitaions,
            $aAdZones
        );
        $this->assertEqual($result, 0);
        $result = $oGetRequiredAdImpressionsLifetime->_getAdImpressions(
            $oAd,
            $totalRequiredAdImpressions,
            'foo',
            $oCampaignExpiryDate,
            $oDeliveryLimitaions,
            $aAdZones
        );
        $this->assertEqual($result, 0);
        $result = $oGetRequiredAdImpressionsLifetime->_getAdImpressions(
            $oAd,
            $totalRequiredAdImpressions,
            $oDate,
            'foo',
            $oDeliveryLimitaions,
            $aAdZones
        );
        $this->assertEqual($result, 0);
        $result = $oGetRequiredAdImpressionsLifetime->_getAdImpressions(
            $oAd,
            $totalRequiredAdImpressions,
            $oDate,
            $oCampaignExpiryDate,
            'foo',
            $aAdZones
        );
        $this->assertEqual($result, 0);
        $result = $oGetRequiredAdImpressionsLifetime->_getAdImpressions(
            $oAd,
            $totalRequiredAdImpressions,
            $oDate,
            $oCampaignExpiryDate,
            $oDeliveryLimitaions,
            'foo'
        );
        $this->assertEqual($result, 0);

        // Test 2
        $oAd = new PartialMockOA_Maintenance_Priority_Ad($this);
        $aParam = array('ad_id' => 1, 'weight' => 1, 'status' => OA_ENTITY_STATUS_RUNNING, 'type' => 'sql');
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
        $oAd->OA_Maintenance_Priority_Ad($aParam);
        $totalRequiredAdImpressions = 120;
        $oDate = new Date('2006-02-15 12:07:01');
        $oCampaignExpiryDate = new Date('2006-12-15 23:59:59');
        $oGetRequiredAdImpressionsLifetime =& $this->_getCurrentTask();
        $oDeliveryLimitaions = new OA_Maintenance_Priority_DeliveryLimitation($oAd->getDeliveryLimitations());
        $aAdZones = array(array('zone_id' => 1));
        $result = $oGetRequiredAdImpressionsLifetime->_getAdImpressions(
            $oAd,
            $totalRequiredAdImpressions,
            $oDate,
            $oCampaignExpiryDate,
            $oDeliveryLimitaions,
            $aAdZones
        );
        $this->assertEqual($result, 0);

        // Test 3
        $oAd = new PartialMockOA_Maintenance_Priority_Ad($this);
        $aParam = array('ad_id' => 1, 'weight' => 1, 'status' => OA_ENTITY_STATUS_RUNNING, 'type' => 'sql');
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
        $oAd->OA_Maintenance_Priority_Ad($aParam);
        $totalRequiredAdImpressions = 110;
        $oDate = new Date('2006-02-15 12:07:01');
        $oCampaignExpiryDate = new Date('2006-02-15 23:59:59');
        $oGetRequiredAdImpressionsLifetime = new PartialMockOA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime($this);
        $oGetRequiredAdImpressionsLifetime->setReturnValue(
            '_getCumulativeZoneForecast',
            array()
        );
        $oGetRequiredAdImpressionsLifetime->OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime();
        $oDeliveryLimitaions = new OA_Maintenance_Priority_DeliveryLimitation($oAd->getDeliveryLimitations());
        $aAdZones = array(array('zone_id' => 1));
        $result = $oGetRequiredAdImpressionsLifetime->_getAdImpressions(
            $oAd,
            $totalRequiredAdImpressions,
            $oDate,
            $oCampaignExpiryDate,
            $oDeliveryLimitaions,
            $aAdZones
        );
        $this->assertEqual($result, 0);

        // Test 4
        $oAd = new PartialMockOA_Maintenance_Priority_Ad($this);
        $aParam = array('ad_id' => 1, 'weight' => 1, 'status' => OA_ENTITY_STATUS_RUNNING, 'type' => 'sql');
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
        $oAd->OA_Maintenance_Priority_Ad($aParam);
        $totalRequiredAdImpressions = 110;
        $oDate = new Date('2006-02-15 12:07:01');
        $oCampaignExpiryDate = new Date('2006-02-15 23:59:59');
        $oGetRequiredAdImpressionsLifetime = new PartialMockOA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime($this);
        $aCumulativeZoneForecast = array();
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 12:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $aCumulativeZoneForecast = $this->_fillForecastArray($aCumulativeZoneForecast);
        $oGetRequiredAdImpressionsLifetime->setReturnValue(
            '_getCumulativeZoneForecast',
            $aCumulativeZoneForecast
        );
        $oGetRequiredAdImpressionsLifetime->OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime();
        $oDeliveryLimitaions = new OA_Maintenance_Priority_DeliveryLimitation($oAd->getDeliveryLimitations());
        $remainingOIs = OA_OperationInterval::getIntervalsRemaining($oDate, $oCampaignExpiryDate);
        $oDeliveryLimitaions->getActiveAdOperationIntervals($remainingOIs, $oDate, $oCampaignExpiryDate);
        $aAdZones = array(array('zone_id' => 1));
        $result = $oGetRequiredAdImpressionsLifetime->_getAdImpressions(
            $oAd,
            $totalRequiredAdImpressions,
            $oDate,
            $oCampaignExpiryDate,
            $oDeliveryLimitaions,
            $aAdZones
        );
        $this->assertEqual($result, 110);

        // Test 5
        $oAd = new PartialMockOA_Maintenance_Priority_Ad($this);
        $aParam = array('ad_id' => 1, 'weight' => 1, 'status' => OA_ENTITY_STATUS_RUNNING, 'type' => 'sql');
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
        $oAd->OA_Maintenance_Priority_Ad($aParam);
        $totalRequiredAdImpressions = 110;
        $oDate = new Date('2006-02-15 12:07:01');
        $oCampaignExpiryDate = new Date('2006-02-15 23:59:59');
        $oGetRequiredAdImpressionsLifetime = new PartialMockOA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime($this);
        $aCumulativeZoneForecast = array();
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 12:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 13:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 14:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 15:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 16:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 17:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 18:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 19:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 20:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 21:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 22:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 23:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $aCumulativeZoneForecast = $this->_fillForecastArray($aCumulativeZoneForecast);
        $oGetRequiredAdImpressionsLifetime->setReturnValue(
            '_getCumulativeZoneForecast',
            $aCumulativeZoneForecast
        );
        $oGetRequiredAdImpressionsLifetime->OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime();
        $oDeliveryLimitaions = new OA_Maintenance_Priority_DeliveryLimitation($oAd->getDeliveryLimitations());
        $remainingOIs = OA_OperationInterval::getIntervalsRemaining($oDate, $oCampaignExpiryDate);
        $oDeliveryLimitaions->getActiveAdOperationIntervals($remainingOIs, $oDate, $oCampaignExpiryDate);
        $aAdZones = array(array('zone_id' => 1));
        $result = $oGetRequiredAdImpressionsLifetime->_getAdImpressions(
            $oAd,
            $totalRequiredAdImpressions,
            $oDate,
            $oCampaignExpiryDate,
            $oDeliveryLimitaions,
            $aAdZones
        );
        $this->assertEqual($result, 10);

        // Test 6
        $oAd = new PartialMockOA_Maintenance_Priority_Ad($this);
        $aParam = array('ad_id' => 1, 'weight' => 1, 'status' => OA_ENTITY_STATUS_RUNNING, 'type' => 'sql');
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
        $oAd->OA_Maintenance_Priority_Ad($aParam);
        $totalRequiredAdImpressions = 110;
        $oDate = new Date('2006-02-15 12:07:01');
        $oCampaignExpiryDate = new Date('2006-02-15 23:59:59');
        $oGetRequiredAdImpressionsLifetime = new PartialMockOA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime($this);
        $aCumulativeZoneForecast = array();
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 12:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 10;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 13:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 20;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 14:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 30;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 15:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 40;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 16:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 17:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 60;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 18:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 50;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 19:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 40;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 20:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 30;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 21:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 20;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 22:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 10;
        $intervalID = OA_OperationInterval::convertDateToOperationIntervalID(new Date('2006-02-15 23:00:01'));
        $aCumulativeZoneForecast[$intervalID] = 10;
        $aCumulativeZoneForecast = $this->_fillForecastArray($aCumulativeZoneForecast);
        $oGetRequiredAdImpressionsLifetime->setReturnValue(
            '_getCumulativeZoneForecast',
            $aCumulativeZoneForecast
        );
        $oGetRequiredAdImpressionsLifetime->OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime();
        $oDeliveryLimitaions = new OA_Maintenance_Priority_DeliveryLimitation($oAd->getDeliveryLimitations());
        $remainingOIs = OA_OperationInterval::getIntervalsRemaining($oDate, $oCampaignExpiryDate);
        $oDeliveryLimitaions->getActiveAdOperationIntervals($remainingOIs, $oDate, $oCampaignExpiryDate);
        $aAdZones = array(array('zone_id' => 1));
        $result = $oGetRequiredAdImpressionsLifetime->_getAdImpressions(
            $oAd,
            $totalRequiredAdImpressions,
            $oDate,
            $oCampaignExpiryDate,
            $oDeliveryLimitaions,
            $aAdZones
        );
        $this->assertEqual($result, 3);

        TestEnv::restoreConfig();
    }

    /**
     * A private method to fill an array of ZIF data with 0 as the default forecast
     * for and operation interval that is not yet set.
     *
     * @param array $aArray
     */
    function _fillForecastArray($aArray)
    {
        $intervalsPerWeek = OA_OperationInterval::operationIntervalsPerWeek();
        for ($counter = 0; $counter < $intervalsPerWeek; $counter++) {
            if (empty($aArray[$counter])) {
                $aArray[$counter] = 0;
            }
        }
        return $aArray;
    }

    /**
     * A method to test the _getCumulativeZoneForecast() method.
     *
     * Test 1: Test with a incorrect parameters, and ensure false is returned.
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
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;

        // Test 1
        $oGetRequiredAdImpressionsLifetime =& $this->_getCurrentTask();
        $aAdZones = array(array('zone_id' => 1));
        $result = $oGetRequiredAdImpressionsLifetime->_getCumulativeZoneForecast('foo', $aAdZones);
        $this->assertFalse($result);
        $result = $oGetRequiredAdImpressionsLifetime->_getCumulativeZoneForecast(1, 'foo');
        $this->assertFalse($result);

        // Test 2
        $oGetRequiredAdImpressionsLifetime =& $this->_getCurrentTask();
        $aAdZones = array();
        $oGetRequiredAdImpressionsLifetime->oDal->expectNever('getPreviousWeekZoneForcastImpressions');
        $result = $oGetRequiredAdImpressionsLifetime->_getCumulativeZoneForecast(1, $aAdZones);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), MINUTES_PER_WEEK / 60);
        for ($i = 0; $i < (MINUTES_PER_WEEK / 60); $i++) {
            $this->assertEqual($result[$i], 0);
        }
        $oGetRequiredAdImpressionsLifetime->oDal->tally();

        // Test 3
        $oGetRequiredAdImpressionsLifetime =& $this->_getCurrentTask();
        $aAdZones = array(array('zone_id' => 1));
        $oGetRequiredAdImpressionsLifetime->oDal->expectOnce(
            'getPreviousWeekZoneForcastImpressions',
            array(1)
        );
        $oGetRequiredAdImpressionsLifetime->oDal->setReturnValue(
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
        $result = $oGetRequiredAdImpressionsLifetime->_getCumulativeZoneForecast(1, $aAdZones);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), MINUTES_PER_WEEK / 60);
        for ($i = 0; $i < (MINUTES_PER_WEEK / 60); $i++) {
            if ($i == 14) {
                $this->assertEqual($result[$i], 1);
            } else {
                $this->assertEqual($result[$i], 0);
            }
        }
        $oGetRequiredAdImpressionsLifetime->oDal->tally();


        // Test 4
        $oGetRequiredAdImpressionsLifetime =& $this->_getCurrentTask();
        $aAdZones = array(
            array('zone_id' => 1),
            array('zone_id' => 3),
            array('zone_id' => 7)
        );
        $oGetRequiredAdImpressionsLifetime->oDal->expectArgumentsAt(
            0,
            'getPreviousWeekZoneForcastImpressions',
            array(1)
        );
        $oGetRequiredAdImpressionsLifetime->oDal->setReturnValueAt(
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
        $oGetRequiredAdImpressionsLifetime->oDal->expectArgumentsAt(
            1,
            'getPreviousWeekZoneForcastImpressions',
            array(3)
        );
        $oGetRequiredAdImpressionsLifetime->oDal->setReturnValueAt(
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
        $oGetRequiredAdImpressionsLifetime->oDal->expectArgumentsAt(
            2,
            'getPreviousWeekZoneForcastImpressions',
            array(7)
        );
        $oGetRequiredAdImpressionsLifetime->oDal->setReturnValueAt(
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
        $result = $oGetRequiredAdImpressionsLifetime->_getCumulativeZoneForecast(1, $aAdZones);
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
        $oGetRequiredAdImpressionsLifetime->oDal->tally();

        // Test 5
        $aAdZones = array(
            array('zone_id' => 1),
            array('zone_id' => 3),
            array('zone_id' => 7)
        );
        $oGetRequiredAdImpressionsLifetime->oDal->expectArgumentsAt(
            0,
            'getPreviousWeekZoneForcastImpressions',
            array(1)
        );
        $oGetRequiredAdImpressionsLifetime->oDal->setReturnValueAt(
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
        $oGetRequiredAdImpressionsLifetime->oDal->expectArgumentsAt(
            1,
            'getPreviousWeekZoneForcastImpressions',
            array(3)
        );
        $oGetRequiredAdImpressionsLifetime->oDal->setReturnValueAt(
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
        $oGetRequiredAdImpressionsLifetime->oDal->expectArgumentsAt(
            2,
            'getPreviousWeekZoneForcastImpressions',
            array(7)
        );
        $oGetRequiredAdImpressionsLifetime->oDal->setReturnValueAt(
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
        $result = $oGetRequiredAdImpressionsLifetime->_getCumulativeZoneForecast(1, $aAdZones);
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
        $oGetRequiredAdImpressionsLifetime->oDal->tally();
        TestEnv::restoreConfig();
    }

}

?>
