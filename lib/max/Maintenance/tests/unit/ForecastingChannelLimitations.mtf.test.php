<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: ForecastingChannelLimitations.mtf.test.php 6266 2006-12-12 12:19:48Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Dal/Maintenance/Forecasting.php';
require_once MAX_PATH . '/lib/max/Maintenance/Forecasting/Channel/Limitations.php';
require_once MAX_PATH . '/plugins/deliveryLimitations/DeliveryLimitations.php';

/**
 * A class for testing the MAX_Maintenance_Forecasting_Channel_Limitations class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Radek Maciaszek <radek@m3.net>
 */
class Maintenance_TestOfMAX_Maintenance_Forecasting_Channel_Limitations extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMAX_Maintenance_Forecasting_Channel_Limitations()
    {
        $this->UnitTestCase();
        Mock::generate('MAX_Dal_Maintenance_Forecasting');
        Mock::generatePartial(
            'MAX_Maintenance_Forecasting_Channel_Limitations',
            'PartialMockMAX_Maintenance_Forecasting_Channel_Limitations_test_buildLimitations',
            array(
                '_buildSqlLimitations'
            )
        );
        Mock::generatePartial(
            'MAX_Maintenance_Forecasting_Channel_Limitations',
            'PartialMockMAX_Maintenance_Forecasting_Channel_Limitations_test_buildSqlLimitations',
            array(
                '_getLimitationPlugin'
            )
        );
        Mock::generate('Plugins_DeliveryLimitations');
    }

    /**
     * A method for testing the buildLimitations() method.
     *
     * Requirements:
     * Test 1: Test with a channel ID that does not exist in the database, and ensure
     *         false is returned.
     * Test 2: Test with a simple channel ID that does exist in the database, and ensure
     *         the limitations stored correctly, calls to _buildSqlLimitations() happen
     *         correctly, and that return values from _buildSqlLimitations() are dealt
     *         with.
     * Test 3: As for Test 2, but with a more complex channel.
     */
    function testBuildLimitations()
    {
        $oServiceLocator = &ServiceLocator::instance();

        // Test 1
        $oDalMaintenanceForecasting = new MockMAX_Dal_Maintenance_Forecasting($this);
        $oDalMaintenanceForecasting->expectArgumentsAt(0, 'getAllDeliveryLimitationsByTypeId', array(1, 'channel'));
        $oDalMaintenanceForecasting->expectArgumentsAt(1, 'getAllDeliveryLimitationsByTypeId', array(1, 'channel'));
        $oDalMaintenanceForecasting->expectCallCount('getAllDeliveryLimitationsByTypeId', 2);
        $oDalMaintenanceForecasting->setReturnValueAt(0, 'getAllDeliveryLimitationsByTypeId', new PEAR_Error());
        $oDalMaintenanceForecasting->setReturnValueAt(1, 'getAllDeliveryLimitationsByTypeId', null);
        $oServiceLocator->register('MAX_Dal_Maintenance_Forecasting', $oDalMaintenanceForecasting);

        $oChannelLimitations = new MAX_Maintenance_Forecasting_Channel_Limitations();
        $result = $oChannelLimitations->buildLimitations(1);
        $this->assertFalse($result);

        $result = $oChannelLimitations->buildLimitations(1);
        $this->assertFalse($result);

        $oChannelLimitations->oDalMaintenanceForecasting->tally();

        // Test 2
        $oDalMaintenanceForecasting = new MockMAX_Dal_Maintenance_Forecasting($this);
        $oDalMaintenanceForecasting->expectArgumentsAt(0, 'getAllDeliveryLimitationsByTypeId', array(1, 'channel'));
        $oDalMaintenanceForecasting->expectArgumentsAt(1, 'getAllDeliveryLimitationsByTypeId', array(1, 'channel'));
        $oDalMaintenanceForecasting->expectCallCount('getAllDeliveryLimitationsByTypeId', 2);
        $aRawLimitations = array(
            0 => array(
                'channel_id'     => 3,
                'logical'        => "and",
                'type'           => "Time:Date",
                'comparison'     => "!=",
                'data'           => "2005-05-25",
                'executionorder' => 0
            ),
            1 => array(
                'channel_id'     => 3,
                'logical'        => "and",
                'type'           => "Geo:Country",
                'comparison'     => "==",
                'data'           => "GB",
                'executionorder' => 1
            )
        );
        $oDalMaintenanceForecasting->setReturnValueAt(
            0,
            'getAllDeliveryLimitationsByTypeId',
            $aRawLimitations
        );
        $oDalMaintenanceForecasting->setReturnValueAt(
            1,
            'getAllDeliveryLimitationsByTypeId',
            $aRawLimitations
        );
        $oServiceLocator->register('MAX_Dal_Maintenance_Forecasting', $oDalMaintenanceForecasting);

        $oChannelLimitations = new PartialMockMAX_Maintenance_Forecasting_Channel_Limitations_test_buildLimitations($this);
        $oChannelLimitations->expectArgumentsAt(0, '_buildSqlLimitations', array(0));
        $oChannelLimitations->expectArgumentsAt(1, '_buildSqlLimitations', array(0));
        $oChannelLimitations->expectCallCount('_buildSqlLimitations', 2);
        $oChannelLimitations->setReturnValueAt(0, '_buildSqlLimitations', true);
        $oChannelLimitations->setReturnValueAt(1, '_buildSqlLimitations', false);
        $oChannelLimitations->MAX_Maintenance_Forecasting_Channel_Limitations();

        $result = $oChannelLimitations->buildLimitations(1);
        $this->assertTrue($result);
        $this->assertEqual($oChannelLimitations->aLimitations[0], $aRawLimitations);

        $result = $oChannelLimitations->buildLimitations(1);
        $this->assertFalse($result);
        $this->assertEqual($oChannelLimitations->aLimitations[0], $aRawLimitations);

        $oChannelLimitations->tally();
        $oChannelLimitations->oDalMaintenanceForecasting->tally();

        // Test 3
        $oDalMaintenanceForecasting = new MockMAX_Dal_Maintenance_Forecasting($this);
        $oDalMaintenanceForecasting->expectArgumentsAt(0, 'getAllDeliveryLimitationsByTypeId', array(1, 'channel'));
        $oDalMaintenanceForecasting->expectArgumentsAt(1, 'getAllDeliveryLimitationsByTypeId', array(1, 'channel'));
        $oDalMaintenanceForecasting->expectCallCount('getAllDeliveryLimitationsByTypeId', 2);
        $aRawLimitations = array(
            0 => array(
                'channel_id'     => 3,
                'logical'        => "and",
                'type'           => "Time:Date",
                'comparison'     => "!=",
                'data'           => "2005-05-25",
                'executionorder' => 0
            ),
            1 => array(
                'channel_id'     => 3,
                'logical'        => "and",
                'type'           => "Geo:Country",
                'comparison'     => "==",
                'data'           => "GB",
                'executionorder' => 1
            ),
            2 => array(
                'channel_id'     => 3,
                'logical'        => "or",
                'type'           => "Time:Date",
                'comparison'     => "!=",
                'data'           => "2005-05-25",
                'executionorder' => 2
            ),
            3 => array(
                'channel_id'     => 3,
                'logical'        => "and",
                'type'           => "Geo:Country",
                'comparison'     => "==",
                'data'           => "GB",
                'executionorder' => 3
            ),
            4 => array(
                'channel_id'     => 3,
                'logical'        => "and",
                'type'           => "Time:Date",
                'comparison'     => "!=",
                'data'           => "2005-05-25",
                'executionorder' => 4
            ),
            5 => array(
                'channel_id'     => 3,
                'logical'        => "OR",
                'type'           => "Geo:Country",
                'comparison'     => "==",
                'data'           => "GB",
                'executionorder' => 5
            )
        );
        $oDalMaintenanceForecasting->setReturnValueAt(
            0,
            'getAllDeliveryLimitationsByTypeId',
            $aRawLimitations
        );
        $oDalMaintenanceForecasting->setReturnValueAt(
            1,
            'getAllDeliveryLimitationsByTypeId',
            $aRawLimitations
        );
        $oServiceLocator->register('MAX_Dal_Maintenance_Forecasting', $oDalMaintenanceForecasting);

        $oChannelLimitations = new PartialMockMAX_Maintenance_Forecasting_Channel_Limitations_test_buildLimitations($this);
        $oChannelLimitations->expectArgumentsAt(0, '_buildSqlLimitations', array(0));
        $oChannelLimitations->expectArgumentsAt(1, '_buildSqlLimitations', array(1));
        $oChannelLimitations->expectArgumentsAt(2, '_buildSqlLimitations', array(0));
        $oChannelLimitations->expectArgumentsAt(3, '_buildSqlLimitations', array(1));
        $oChannelLimitations->expectArgumentsAt(4, '_buildSqlLimitations', array(2));
        $oChannelLimitations->expectCallCount('_buildSqlLimitations', 5);
        $oChannelLimitations->setReturnValueAt(0, '_buildSqlLimitations', true);
        $oChannelLimitations->setReturnValueAt(1, '_buildSqlLimitations', false);
        $oChannelLimitations->setReturnValueAt(2, '_buildSqlLimitations', true);
        $oChannelLimitations->setReturnValueAt(3, '_buildSqlLimitations', true);
        $oChannelLimitations->setReturnValueAt(4, '_buildSqlLimitations', true);
        $oChannelLimitations->MAX_Maintenance_Forecasting_Channel_Limitations();

        $aResultLimitations = array(
            0 => array(
                0 => array(
                    'channel_id'     => 3,
                    'logical'        => "and",
                    'type'           => "Time:Date",
                    'comparison'     => "!=",
                    'data'           => "2005-05-25",
                    'executionorder' => 0
                ),
                1 => array(
                    'channel_id'     => 3,
                    'logical'        => "and",
                    'type'           => "Geo:Country",
                    'comparison'     => "==",
                    'data'           => "GB",
                    'executionorder' => 1
                )
            ),
            1 => array(
                0 => array(
                    'channel_id'     => 3,
                    'logical'        => "or",
                    'type'           => "Time:Date",
                    'comparison'     => "!=",
                    'data'           => "2005-05-25",
                    'executionorder' => 2
                ),
                1 => array(
                    'channel_id'     => 3,
                    'logical'        => "and",
                    'type'           => "Geo:Country",
                    'comparison'     => "==",
                    'data'           => "GB",
                    'executionorder' => 3
                ),
                2 => array(
                    'channel_id'     => 3,
                    'logical'        => "and",
                    'type'           => "Time:Date",
                    'comparison'     => "!=",
                    'data'           => "2005-05-25",
                    'executionorder' => 4
                )
            ),
            2 => array(
                0 => array(
                    'channel_id'     => 3,
                    'logical'        => "OR",
                    'type'           => "Geo:Country",
                    'comparison'     => "==",
                    'data'           => "GB",
                    'executionorder' => 5
                )
            )
        );

        $result = $oChannelLimitations->buildLimitations(1);
        $this->assertFalse($result);
        $this->assertEqual($oChannelLimitations->aLimitations, $aResultLimitations);

        $result = $oChannelLimitations->buildLimitations(1);
        $this->assertTrue($result);
        $this->assertEqual($oChannelLimitations->aLimitations, $aResultLimitations);

        $oChannelLimitations->tally();
        $oChannelLimitations->oDalMaintenanceForecasting->tally();
    }

    /**
     * A method for testing the _buildSqlLimitations() method.
     *
     * Requirements:
     * Test 1: Test with a bad plugin group number, and ensure false is returned.
     * Test 2: Test with a bad plugin type, and ensure false is returned.
     * Test 3: Test that the plugin's getAsSql() method is correctly called, and
     *         the valid result stored.
     * Test 4: Test that the plugin's getAsSql() method is correctly called, and
     *         the null result ensures false is returned.
     * Test 5: Test multiple plugins, and ensure the getAsSql() method results
     *         are correctly stored.
     */
    function test_buildSqlLimitations()
    {
        // Test 1
        $oChannelLimitations = new PartialMockMAX_Maintenance_Forecasting_Channel_Limitations_test_buildSqlLimitations($this);
        $oChannelLimitations->expectCallCount('_getLimitationPlugin', 0);
        $oChannelLimitations->MAX_Maintenance_Forecasting_Channel_Limitations();

        $result = $oChannelLimitations->_buildSqlLimitations(0);
        $this->assertFalse($result);
        $oChannelLimitations->tally();

        // Test 2
        $oChannelLimitations = new PartialMockMAX_Maintenance_Forecasting_Channel_Limitations_test_buildSqlLimitations($this);
        $oChannelLimitations->expectArgumentsAt(0, '_getLimitationPlugin', array("Foo:Bar"));
        $oChannelLimitations->expectCallCount('_getLimitationPlugin', 1);
        $oChannelLimitations->setReturnValueAt(0, '_getLimitationPlugin', false);
        $oChannelLimitations->MAX_Maintenance_Forecasting_Channel_Limitations();

        $oChannelLimitations->aLimitations = array(
            0 => array(
                0 => array(
                    'channel_id'     => 1,
                    'logical'        => "and",
                    'type'           => "Foo:Bar",
                    'comparison'     => "==",
                    'data'           => "somedata",
                    'executionorder' => 0
                )
            )
        );

        $result = $oChannelLimitations->_buildSqlLimitations(0);
        $this->assertFalse($result);
        $oChannelLimitations->tally();

        // Test 3
        $oPlugin = new MockPlugins_DeliveryLimitations($this);
        $oPlugin->expectArgumentsAt(0, 'getAsSql', array("==", "somedata"));
        $oPlugin->setReturnValueAt(0, 'getAsSql', "foo_bar LIKE '%somedata%'");

        $oChannelLimitations = new PartialMockMAX_Maintenance_Forecasting_Channel_Limitations_test_buildSqlLimitations($this);
        $oChannelLimitations->expectArgumentsAt(0, '_getLimitationPlugin', array("Foo:Bar"));
        $oChannelLimitations->expectCallCount('_getLimitationPlugin', 1);
        $oChannelLimitations->setReturnValueAt(0, '_getLimitationPlugin', $oPlugin);
        $oChannelLimitations->MAX_Maintenance_Forecasting_Channel_Limitations();

        $oChannelLimitations->aLimitations = array(
            0 => array(
                0 => array(
                    'channel_id'     => 1,
                    'logical'        => "and",
                    'type'           => "Foo:Bar",
                    'comparison'     => "==",
                    'data'           => "somedata",
                    'executionorder' => 0
                )
            )
        );

        $result = $oChannelLimitations->_buildSqlLimitations(0);
        $this->assertTrue($result);
        $aResult = array(
            0 => array(
                0 => "foo_bar LIKE '%somedata%'"
            )
        );
        $this->assertEqual($oChannelLimitations->aSqlLimitations, $aResult);
        $oChannelLimitations->tally();

        // Test 4
        $oPlugin = new MockPlugins_DeliveryLimitations($this);
        $oPlugin->expectArgumentsAt(0, 'getAsSql', array("==", "somedata"));
        $oPlugin->setReturnValueAt(0, 'getAsSql', null);

        $oChannelLimitations = new PartialMockMAX_Maintenance_Forecasting_Channel_Limitations_test_buildSqlLimitations($this);
        $oChannelLimitations->expectArgumentsAt(0, '_getLimitationPlugin', array("Foo:Bar"));
        $oChannelLimitations->expectCallCount('_getLimitationPlugin', 1);
        $oChannelLimitations->setReturnValueAt(0, '_getLimitationPlugin', $oPlugin);
        $oChannelLimitations->MAX_Maintenance_Forecasting_Channel_Limitations();

        $oChannelLimitations->aLimitations = array(
            0 => array(
                0 => array(
                    'channel_id'     => 1,
                    'logical'        => "and",
                    'type'           => "Foo:Bar",
                    'comparison'     => "==",
                    'data'           => "somedata",
                    'executionorder' => 0
                )
            )
        );

        $result = $oChannelLimitations->_buildSqlLimitations(0);
        $this->assertFalse($result);
        $oChannelLimitations->tally();

        // Test 5
        $oPlugin1 = new MockPlugins_DeliveryLimitations($this);
        $oPlugin1->expectArgumentsAt(0, 'getAsSql', array("==", "somedata0"));
        $oPlugin1->setReturnValueAt(0, 'getAsSql', "foo_bar LIKE '%somedata0%'");

        $oPlugin2 = new MockPlugins_DeliveryLimitations($this);
        $oPlugin2->expectArgumentsAt(0, 'getAsSql', array("!=", "somedata1"));
        $oPlugin2->setReturnValueAt(0, 'getAsSql', true);

        $oPlugin3 = new MockPlugins_DeliveryLimitations($this);
        $oPlugin3->expectArgumentsAt(0, 'getAsSql', array(">=", "somedata2"));
        $oPlugin3->setReturnValueAt(0, 'getAsSql', "foo_bar LIKE '%somedata2%'");

        $oPlugin4 = new MockPlugins_DeliveryLimitations($this);
        $oPlugin4->expectArgumentsAt(0, 'getAsSql', array("!=", "somedata3"));
        $oPlugin4->setReturnValueAt(0, 'getAsSql', false);

        $oChannelLimitations = new PartialMockMAX_Maintenance_Forecasting_Channel_Limitations_test_buildSqlLimitations($this);
        $oChannelLimitations->expectArgumentsAt(0, '_getLimitationPlugin', array("Foo:Bar"));
        $oChannelLimitations->expectArgumentsAt(1, '_getLimitationPlugin', array("Foo:Bar"));
        $oChannelLimitations->expectArgumentsAt(2, '_getLimitationPlugin', array("Foo:Bar"));
        $oChannelLimitations->expectArgumentsAt(3, '_getLimitationPlugin', array("Foo:Bar"));
        $oChannelLimitations->expectCallCount('_getLimitationPlugin', 4);
        $oChannelLimitations->setReturnValueAt(0, '_getLimitationPlugin', $oPlugin1);
        $oChannelLimitations->setReturnValueAt(1, '_getLimitationPlugin', $oPlugin2);
        $oChannelLimitations->setReturnValueAt(2, '_getLimitationPlugin', $oPlugin3);
        $oChannelLimitations->setReturnValueAt(3, '_getLimitationPlugin', $oPlugin4);
        $oChannelLimitations->MAX_Maintenance_Forecasting_Channel_Limitations();

        $oChannelLimitations->aLimitations = array(
            0 => array(
                0 => array(
                    'channel_id'     => 1,
                    'logical'        => "and",
                    'type'           => "Foo:Bar",
                    'comparison'     => "==",
                    'data'           => "somedata0",
                    'executionorder' => 0
                ),
                1 => array(
                    'channel_id'     => 1,
                    'logical'        => "and",
                    'type'           => "Foo:Bar",
                    'comparison'     => "!=",
                    'data'           => "somedata1",
                    'executionorder' => 1
                ),
                2 => array(
                    'channel_id'     => 1,
                    'logical'        => "and",
                    'type'           => "Foo:Bar",
                    'comparison'     => ">=",
                    'data'           => "somedata2",
                    'executionorder' => 2
                ),
                3 => array(
                    'channel_id'     => 1,
                    'logical'        => "and",
                    'type'           => "Foo:Bar",
                    'comparison'     => "!=",
                    'data'           => "somedata3",
                    'executionorder' => 3
                )
            )
        );

        $result = $oChannelLimitations->_buildSqlLimitations(0);
        $this->assertTrue($result);
        $aResult = array(
            0 => array(
                0 => "foo_bar LIKE '%somedata0%'",
                1 => "foo_bar LIKE '%somedata2%'",
                2 => false
            )
        );
        $this->assertEqual($oChannelLimitations->aSqlLimitations, $aResult);
        $oChannelLimitations->tally();
    }

}

?>
