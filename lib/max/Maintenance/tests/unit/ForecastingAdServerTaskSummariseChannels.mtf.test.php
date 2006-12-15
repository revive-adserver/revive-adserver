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
$Id$
*/

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Maintenance/Forecasting/AdServer.php';
require_once MAX_PATH . '/lib/max/Maintenance/Forecasting/AdServer/Task/SummariseChannels.php';
require_once 'Date.php';

/**
 * A class for testing the MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Maintenance_TestOfMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels()
    {
        $this->UnitTestCase();
        Mock::generate('MAX_Dal_Maintenance_Forecasting');
        Mock::generate('MAX_Dal_Entities');
        Mock::generate('MAX_Maintenance_Forecasting_Channel_Limitations');
        Mock::generatePartial(
            'MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels',
            'MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_run',
            array(
                '_summarise'
            )
        );
        Mock::generatePartial(
            'MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels',
            'MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise',
            array(
                '_summariseByChannel'
            )
        );
        Mock::generatePartial(
            'MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels',
            'MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summariseByChannel',
            array(
                '_getChannelLimitation',
                '_summariseBySqlLimitations'
            )
        );
    }

    /**
     * Test the creation of the class.
     */
    function testCreate()
    {
        $oServiceLocator = &ServiceLocator::instance();

        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oMaxDalMaintenanceForecasting = new MockMAX_Dal_Maintenance_Forecasting($this);
        $oServiceLocator->register('MAX_Dal_Maintenance_Forecasting', $oMaxDalMaintenanceForecasting);

        $oSummariseChannels = new MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $this->assertTrue(is_a($oSummariseChannels, 'MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels'));
    }

    /**
     * A method to test the run() method.
     *
     * Requirements:
     * Test 1: Test not updating.
     * Test 2: Test summarising a single day.
     * Test 3: Test summarising multiple days.
     */
    function testRun()
    {
        $oServiceLocator = &ServiceLocator::instance();

        // Test 1
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->update = false;
        $oServiceLocator->register('Maintenance_Forecasting_Controller', $oMaintenanceForecasting);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_run($this);
        $oSummariseChannels->expectNever('_summarise');
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();

        $oSummariseChannels->run();
        $oSummariseChannels->tally();

        // Test 2
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->update = true;
        $oMaintenanceForecasting->oLastUpdateDate = new Date('2006-10-12 23:59:59');
        $oMaintenanceForecasting->oUpdateToDate   = new Date('2006-10-13 23:59:59');
        $oServiceLocator->register('Maintenance_Forecasting_Controller', $oMaintenanceForecasting);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_run($this);
        $oStartDate = new Date('2006-10-13 00:00:01');
        $oStartDate->subtractSeconds(1);
        $oSummariseChannels->expectArgumentsAt(0, '_summarise', array($oStartDate, new Date('2006-10-13 23:59:59')));
        $oSummariseChannels->expectCallCount('_summarise', 1);
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();

        $oSummariseChannels->run();
        $oSummariseChannels->tally();

        // Test 3
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oMaintenanceForecasting->update = true;
        $oMaintenanceForecasting->oLastUpdateDate = new Date('2006-10-11 23:59:59');
        $oMaintenanceForecasting->oUpdateToDate   = new Date('2006-10-13 23:59:59');
        $oServiceLocator->register('Maintenance_Forecasting_Controller', $oMaintenanceForecasting);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_run($this);
        $oStartDate = new Date('2006-10-12 00:00:01');
        $oStartDate->subtractSeconds(1);
        $oEndDate = new Date('2006-10-12 23:59:58');
        $oEndDate->addSeconds(1);
        $oSummariseChannels->expectArgumentsAt(0, '_summarise', array($oStartDate, $oEndDate));
        $oStartDate = new Date('2006-10-13 00:00:01');
        $oStartDate->subtractSeconds(1);
        $oEndDate = new Date('2006-10-13 23:59:58');
        $oEndDate->addSeconds(1);
        $oSummariseChannels->expectArgumentsAt(1, '_summarise', array($oStartDate, $oEndDate));
        $oSummariseChannels->expectCallCount('_summarise', 2);
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();

        $oSummariseChannels->run();
        $oSummariseChannels->tally();
    }

    /**
     * A method to test the _summarise() method.
     *
     * Requirements:
     * Test 1:  Test when error on getting active admin channels.
     * Test 2:  Test when no admin channels, error on getting admin
     *          owned publishers.
     * Test 3:  Test when no admin channels, no admin owned publishers,
     *          error on getting active agencies.
     * Test 4:  Test when no admin channels, admin owned publishers,
     *          error on getting channels owned by publishers.
     * Test 5:  Test when no admin channels, admin owned publishers,
     *          no channels owned by publishers, error on getting
     *          active agencies.
     * Test 6:  Test when admin channels, admin owned publishers,
     *          no channels owned by publishers, error on getting the
     *          channel forecast zones.
     * Test 7:  Test when no admin channels, admin owned publishers,
     *          publisher channels, error on getting the channel forecast
     *          zones.
     * Test 8:  Test when no admin channels, admin owned publishers,
     *          no publisher channels for first publisher, publisher
     *          channels for second publisher, error on getting the
     *          channel forecast zones.
     * Test 9:  Test when admin channels, admin owned publishers,
     *          no publisher channels, channel forecast zones, no
     *          channel forecast zones for the first two publishers,
     *          error on getting the channel forecast zones for the
     *          third publisher.
     * Test 10: Test when admin channels, admin owned publishers,
     *          no publisher channels, channel forecast zones, no
     *          channel forecast zones for the first publisher,
     *          channel forecast zones for the other publishers,
     *          error getting active agencies.
     *
     * Next set of tests assume no admin channels, no admin owned channels.
     *
     * Test 11: Test when error on getting active agencies.
     * Test 12: Test when no active agencies.
     * Test 13: Test when active agencies, but error on getting agency
     *          channels.
     * Test 14: Test when active agencies, no agency channels, and
     *          error on getting agency's publishers.
     * Test 15: Test when active agencies, no agency channels, and
     *          no agency publishers.
     * Test 16: Test when active agencies, no agency channels, agency
     *          publishers and error on getting publisher channels.
     *
     * Test 17: Test when active agencies, no agency channels, agency
     *          publishers and no publisher channels.
     * Test 18: Test when active agencies, no agency channels, agency
     *          publishers, publisher channels, and error on
     *          getting the publisher zones.
     * Test 19: Test when active agencies, no agency channels, agency
     *          publishers, publisher channels, and no publisher zones.
     * Test 20: Test when active agencies, agency channels, agency
     *          publishers, publisher channels, and publisher zones.
     */
    function test_summarise()
    {
        $oServiceLocator = &ServiceLocator::instance();

        $oStartDate = new Date('2006-10-13 00:00:00');
        $oEndDate = new Date('2006-10-13 23:59:59');
        $oError = new PEAR_Error();

        $oMaxDalMaintenanceForecasting = new MockMAX_Dal_Maintenance_Forecasting($this);
        $oServiceLocator->register('MAX_Dal_Maintenance_Forecasting', $oMaxDalMaintenanceForecasting);

        // Test 1
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyId', $oError);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyId', 1);
        $oMaxDalEntities->expectNever('getAllPublisherIdsByAgencyId');
        $oMaxDalEntities->expectNever('getAllActiveChannelIdsByAgencyPublisherId');
        $oMaxDalEntities->expectNever('getAllChannelForecastZonesIdsByPublisherId');
        $oMaxDalEntities->expectNever('getAllActiveAgencyIds');
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise($this);
        $oSummariseChannels->expectNever('_summariseByChannel');
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $oSummariseChannels->_summarise($oStartDate, $oEndDate);

        $oSummariseChannels->tally();
        $oSummariseChannels->oDalEntities->tally();

        // Test 2
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllPublisherIdsByAgencyId', $oError);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllPublisherIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllPublisherIdsByAgencyId', 1);
        $oMaxDalEntities->expectNever('getAllActiveChannelIdsByAgencyPublisherId');
        $oMaxDalEntities->expectNever('getAllChannelForecastZonesIdsByPublisherId');
        $oMaxDalEntities->expectNever('getAllActiveAgencyIds');
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise($this);
        $oSummariseChannels->expectNever('_summariseByChannel');
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $oSummariseChannels->_summarise($oStartDate, $oEndDate);

        $oSummariseChannels->tally();
        $oSummariseChannels->oDalEntities->tally();

        // Test 3
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllPublisherIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllPublisherIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllPublisherIdsByAgencyId', 1);
        $oMaxDalEntities->expectNever('getAllActiveChannelIdsByAgencyPublisherId');
        $oMaxDalEntities->expectNever('getAllChannelForecastZonesIdsByPublisherId');
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAgencyIds', $oError);
        $oMaxDalEntities->expectCallCount('getAllActiveAgencyIds', 1);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise($this);
        $oSummariseChannels->expectNever('_summariseByChannel');
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $oSummariseChannels->_summarise($oStartDate, $oEndDate);

        $oSummariseChannels->tally();
        $oSummariseChannels->oDalEntities->tally();

        // Test 4
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllPublisherIdsByAgencyId', array(1, 2, 3));
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllPublisherIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllPublisherIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', $oError);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', array(0, 1));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyPublisherId', 1);
        $oMaxDalEntities->expectNever('getAllChannelForecastZonesIdsByPublisherId');
        $oMaxDalEntities->expectNever('getAllActiveAgencyIds');
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise($this);
        $oSummariseChannels->expectNever('_summariseByChannel');
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $oSummariseChannels->_summarise($oStartDate, $oEndDate);

        $oSummariseChannels->tally();
        $oSummariseChannels->oDalEntities->tally();

        // Test 5
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllPublisherIdsByAgencyId', array(1, 2, 3));
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllPublisherIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllPublisherIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', array(0, 1));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllActiveChannelIdsByAgencyPublisherId', null);
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllActiveChannelIdsByAgencyPublisherId', array(0, 2));
        $oMaxDalEntities->setReturnValueAt(2, 'getAllActiveChannelIdsByAgencyPublisherId', null);
        $oMaxDalEntities->expectArgumentsAt(2, 'getAllActiveChannelIdsByAgencyPublisherId', array(0, 3));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyPublisherId', 3);
        $oMaxDalEntities->expectNever('getAllChannelForecastZonesIdsByPublisherId');
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAgencyIds', $oError);
        $oMaxDalEntities->expectCallCount('getAllActiveAgencyIds', 1);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise($this);
        $oSummariseChannels->expectNever('_summariseByChannel');
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $oSummariseChannels->_summarise($oStartDate, $oEndDate);

        $oSummariseChannels->tally();
        $oSummariseChannels->oDalEntities->tally();

        // Test 6
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyId', array(5));
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllPublisherIdsByAgencyId', array(1, 2, 3));
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllPublisherIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllPublisherIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', array(0, 1));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyPublisherId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllChannelForecastZonesIdsByPublisherId', $oError);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllChannelForecastZonesIdsByPublisherId', array(1));
        $oMaxDalEntities->expectCallCount('getAllChannelForecastZonesIdsByPublisherId', 1);
        $oMaxDalEntities->expectNever('getAllActiveAgencyIds');
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise($this);
        $oSummariseChannels->expectNever('_summariseByChannel');
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $oSummariseChannels->_summarise($oStartDate, $oEndDate);

        $oSummariseChannels->tally();
        $oSummariseChannels->oDalEntities->tally();

        // Test 7
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllPublisherIdsByAgencyId', array(1, 2, 3));
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllPublisherIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllPublisherIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', array(5));
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', array(0, 1));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyPublisherId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllChannelForecastZonesIdsByPublisherId', $oError);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllChannelForecastZonesIdsByPublisherId', array(1));
        $oMaxDalEntities->expectCallCount('getAllChannelForecastZonesIdsByPublisherId', 1);
        $oMaxDalEntities->expectNever('getAllActiveAgencyIds');
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise($this);
        $oSummariseChannels->expectNever('_summariseByChannel');
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $oSummariseChannels->_summarise($oStartDate, $oEndDate);

        $oSummariseChannels->tally();
        $oSummariseChannels->oDalEntities->tally();

        // Test 8
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllPublisherIdsByAgencyId', array(1, 2, 3));
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllPublisherIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllPublisherIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', array(0, 1));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllActiveChannelIdsByAgencyPublisherId', array(5));
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllActiveChannelIdsByAgencyPublisherId', array(0, 2));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyPublisherId', 2);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllChannelForecastZonesIdsByPublisherId', $oError);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllChannelForecastZonesIdsByPublisherId', array(2));
        $oMaxDalEntities->expectCallCount('getAllChannelForecastZonesIdsByPublisherId', 1);
        $oMaxDalEntities->expectNever('getAllActiveAgencyIds');
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise($this);
        $oSummariseChannels->expectNever('_summariseByChannel');
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $oSummariseChannels->_summarise($oStartDate, $oEndDate);

        $oSummariseChannels->tally();
        $oSummariseChannels->oDalEntities->tally();

        // Test 9
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyId', array(5));
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllPublisherIdsByAgencyId', array(1, 2, 3));
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllPublisherIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllPublisherIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', array(6));
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', array(0, 1));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllActiveChannelIdsByAgencyPublisherId', array(7));
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllActiveChannelIdsByAgencyPublisherId', array(0, 2));
        $oMaxDalEntities->setReturnValueAt(2, 'getAllActiveChannelIdsByAgencyPublisherId', array(8));
        $oMaxDalEntities->expectArgumentsAt(2, 'getAllActiveChannelIdsByAgencyPublisherId', array(0, 3));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyPublisherId', 3);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllChannelForecastZonesIdsByPublisherId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllChannelForecastZonesIdsByPublisherId', array(1));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllChannelForecastZonesIdsByPublisherId', null);
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllChannelForecastZonesIdsByPublisherId', array(2));
        $oMaxDalEntities->setReturnValueAt(2, 'getAllChannelForecastZonesIdsByPublisherId', $oError);
        $oMaxDalEntities->expectArgumentsAt(2, 'getAllChannelForecastZonesIdsByPublisherId', array(3));
        $oMaxDalEntities->expectCallCount('getAllChannelForecastZonesIdsByPublisherId', 3);
        $oMaxDalEntities->expectNever('getAllActiveAgencyIds');
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise($this);
        $oSummariseChannels->expectNever('_summariseByChannel');
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $oSummariseChannels->_summarise($oStartDate, $oEndDate);

        $oSummariseChannels->tally();
        $oSummariseChannels->oDalEntities->tally();

        // Test 10
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyId', array(5));
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllPublisherIdsByAgencyId', array(1, 2, 3));
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllPublisherIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllPublisherIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', array(6));
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', array(0, 1));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllActiveChannelIdsByAgencyPublisherId', array(7));
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllActiveChannelIdsByAgencyPublisherId', array(0, 2));
        $oMaxDalEntities->setReturnValueAt(2, 'getAllActiveChannelIdsByAgencyPublisherId', array(8));
        $oMaxDalEntities->expectArgumentsAt(2, 'getAllActiveChannelIdsByAgencyPublisherId', array(0, 3));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyPublisherId', 3);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllChannelForecastZonesIdsByPublisherId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllChannelForecastZonesIdsByPublisherId', array(1));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllChannelForecastZonesIdsByPublisherId', array(12, 13));
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllChannelForecastZonesIdsByPublisherId', array(2));
        $oMaxDalEntities->setReturnValueAt(2, 'getAllChannelForecastZonesIdsByPublisherId', array(14, 15));
        $oMaxDalEntities->expectArgumentsAt(2, 'getAllChannelForecastZonesIdsByPublisherId', array(3));
        $oMaxDalEntities->expectCallCount('getAllChannelForecastZonesIdsByPublisherId', 3);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAgencyIds', $oError);
        $oMaxDalEntities->expectCallCount('getAllActiveAgencyIds', 1);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise($this);
        $oSummariseChannels->expectArgumentsAt(0, '_summariseByChannel', array($oStartDate, $oEndDate, 5, array(12, 13)));
        $oSummariseChannels->expectArgumentsAt(1, '_summariseByChannel', array($oStartDate, $oEndDate, 7, array(12, 13)));
        $oSummariseChannels->expectArgumentsAt(2, '_summariseByChannel', array($oStartDate, $oEndDate, 5, array(14, 15)));
        $oSummariseChannels->expectArgumentsAt(3, '_summariseByChannel', array($oStartDate, $oEndDate, 8, array(14, 15)));
        $oSummariseChannels->expectCallCount('_summariseByChannel', 4);
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $oSummariseChannels->_summarise($oStartDate, $oEndDate);

        $oSummariseChannels->tally();
        $oSummariseChannels->oDalEntities->tally();

        // Test 11
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllPublisherIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllPublisherIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllPublisherIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAgencyIds', $oError);
        $oMaxDalEntities->expectCallCount('getAllActiveAgencyIds', 1);
        $oMaxDalEntities->expectNever('getAllActiveChannelIdsByAgencyPublisherId');
        $oMaxDalEntities->expectNever('getAllChannelForecastZonesIdsByPublisherId');
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise($this);
        $oSummariseChannels->expectNever('_summariseByChannel');
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $oSummariseChannels->_summarise($oStartDate, $oEndDate);

        $oSummariseChannels->tally();
        $oSummariseChannels->oDalEntities->tally();

        // Test 12
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllPublisherIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllPublisherIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllPublisherIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAgencyIds', null);
        $oMaxDalEntities->expectCallCount('getAllActiveAgencyIds', 1);
        $oMaxDalEntities->expectNever('getAllActiveChannelIdsByAgencyPublisherId');
        $oMaxDalEntities->expectNever('getAllChannelForecastZonesIdsByPublisherId');
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise($this);
        $oSummariseChannels->expectNever('_summariseByChannel');
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $oSummariseChannels->_summarise($oStartDate, $oEndDate);

        $oSummariseChannels->tally();
        $oSummariseChannels->oDalEntities->tally();

        // Test 13
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyId', array(0));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllActiveChannelIdsByAgencyId', $oError);
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllActiveChannelIdsByAgencyId', array(1));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyId', 2);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllPublisherIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllPublisherIdsByAgencyId', array(0));
        $oMaxDalEntities->expectCallCount('getAllPublisherIdsByAgencyId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAgencyIds', array(1, 2));
        $oMaxDalEntities->expectCallCount('getAllActiveAgencyIds', 1);
        $oMaxDalEntities->expectNever('getAllActiveChannelIdsByAgencyPublisherId');
        $oMaxDalEntities->expectNever('getAllChannelForecastZonesIdsByPublisherId');
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise($this);
        $oSummariseChannels->expectNever('_summariseByChannel');
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $oSummariseChannels->_summarise($oStartDate, $oEndDate);

        $oSummariseChannels->tally();
        $oSummariseChannels->oDalEntities->tally();

        // Test 14
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyId', array(0));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllActiveChannelIdsByAgencyId', array(1));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyId', 2);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllPublisherIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllPublisherIdsByAgencyId', array(0));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllPublisherIdsByAgencyId', $oError);
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllPublisherIdsByAgencyId', array(1));
        $oMaxDalEntities->expectCallCount('getAllPublisherIdsByAgencyId', 2);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAgencyIds', array(1, 2));
        $oMaxDalEntities->expectCallCount('getAllActiveAgencyIds', 1);
        $oMaxDalEntities->expectNever('getAllActiveChannelIdsByAgencyPublisherId');
        $oMaxDalEntities->expectNever('getAllChannelForecastZonesIdsByPublisherId');
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise($this);
        $oSummariseChannels->expectNever('_summariseByChannel');
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $oSummariseChannels->_summarise($oStartDate, $oEndDate);

        $oSummariseChannels->tally();
        $oSummariseChannels->oDalEntities->tally();

        // Test 15
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyId', array(0));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllActiveChannelIdsByAgencyId', array(1));
        $oMaxDalEntities->setReturnValueAt(2, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(2, 'getAllActiveChannelIdsByAgencyId', array(2));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyId', 3);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllPublisherIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllPublisherIdsByAgencyId', array(0));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllPublisherIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllPublisherIdsByAgencyId', array(1));
        $oMaxDalEntities->setReturnValueAt(2, 'getAllPublisherIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(2, 'getAllPublisherIdsByAgencyId', array(2));
        $oMaxDalEntities->expectCallCount('getAllPublisherIdsByAgencyId', 3);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAgencyIds', array(1, 2));
        $oMaxDalEntities->expectCallCount('getAllActiveAgencyIds', 1);
        $oMaxDalEntities->expectNever('getAllActiveChannelIdsByAgencyPublisherId');
        $oMaxDalEntities->expectNever('getAllChannelForecastZonesIdsByPublisherId');
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise($this);
        $oSummariseChannels->expectNever('_summariseByChannel');
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $oSummariseChannels->_summarise($oStartDate, $oEndDate);

        $oSummariseChannels->tally();
        $oSummariseChannels->oDalEntities->tally();

        // Test 16
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyId', array(0));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllActiveChannelIdsByAgencyId', array(1));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyId', 2);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllPublisherIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllPublisherIdsByAgencyId', array(0));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllPublisherIdsByAgencyId', array(3, 4));
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllPublisherIdsByAgencyId', array(1));
        $oMaxDalEntities->expectCallCount('getAllPublisherIdsByAgencyId', 2);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAgencyIds', array(1, 2));
        $oMaxDalEntities->expectCallCount('getAllActiveAgencyIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', $oError);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', array(1, 3));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyPublisherId', 1);
        $oMaxDalEntities->expectNever('getAllChannelForecastZonesIdsByPublisherId');
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise($this);
        $oSummariseChannels->expectNever('_summariseByChannel');
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $oSummariseChannels->_summarise($oStartDate, $oEndDate);

        $oSummariseChannels->tally();
        $oSummariseChannels->oDalEntities->tally();

        // Test 17
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyId', array(0));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllActiveChannelIdsByAgencyId', array(1));
        $oMaxDalEntities->setReturnValueAt(2, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(2, 'getAllActiveChannelIdsByAgencyId', array(2));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyId', 3);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllPublisherIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllPublisherIdsByAgencyId', array(0));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllPublisherIdsByAgencyId', array(3, 4));
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllPublisherIdsByAgencyId', array(1));
        $oMaxDalEntities->setReturnValueAt(2, 'getAllPublisherIdsByAgencyId', array(5, 6));
        $oMaxDalEntities->expectArgumentsAt(2, 'getAllPublisherIdsByAgencyId', array(2));
        $oMaxDalEntities->expectCallCount('getAllPublisherIdsByAgencyId', 3);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAgencyIds', array(1, 2));
        $oMaxDalEntities->expectCallCount('getAllActiveAgencyIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', array(1, 3));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllActiveChannelIdsByAgencyPublisherId', null);
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllActiveChannelIdsByAgencyPublisherId', array(1, 4));
        $oMaxDalEntities->setReturnValueAt(2, 'getAllActiveChannelIdsByAgencyPublisherId', null);
        $oMaxDalEntities->expectArgumentsAt(2, 'getAllActiveChannelIdsByAgencyPublisherId', array(2, 5));
        $oMaxDalEntities->setReturnValueAt(3, 'getAllActiveChannelIdsByAgencyPublisherId', null);
        $oMaxDalEntities->expectArgumentsAt(3, 'getAllActiveChannelIdsByAgencyPublisherId', array(2, 6));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyPublisherId', 4);
        $oMaxDalEntities->expectNever('getAllChannelForecastZonesIdsByPublisherId');
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise($this);
        $oSummariseChannels->expectNever('_summariseByChannel');
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $oSummariseChannels->_summarise($oStartDate, $oEndDate);

        $oSummariseChannels->tally();
        $oSummariseChannels->oDalEntities->tally();

        // Test 18
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyId', array(0));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllActiveChannelIdsByAgencyId', array(1));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyId', 2);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllPublisherIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllPublisherIdsByAgencyId', array(0));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllPublisherIdsByAgencyId', array(3, 4));
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllPublisherIdsByAgencyId', array(1));
        $oMaxDalEntities->expectCallCount('getAllPublisherIdsByAgencyId', 2);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAgencyIds', array(1, 2));
        $oMaxDalEntities->expectCallCount('getAllActiveAgencyIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', array(5, 6));
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', array(1, 3));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyPublisherId', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllChannelForecastZonesIdsByPublisherId', $oError);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllChannelForecastZonesIdsByPublisherId', array(3));
        $oMaxDalEntities->expectCallCount('getAllChannelForecastZonesIdsByPublisherId', 1);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise($this);
        $oSummariseChannels->expectNever('_summariseByChannel');
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $oSummariseChannels->_summarise($oStartDate, $oEndDate);

        $oSummariseChannels->tally();
        $oSummariseChannels->oDalEntities->tally();

        // Test 19
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyId', array(0));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllActiveChannelIdsByAgencyId', array(1));
        $oMaxDalEntities->setReturnValueAt(2, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(2, 'getAllActiveChannelIdsByAgencyId', array(2));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyId', 3);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllPublisherIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllPublisherIdsByAgencyId', array(0));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllPublisherIdsByAgencyId', array(3, 4));
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllPublisherIdsByAgencyId', array(1));
        $oMaxDalEntities->setReturnValueAt(2, 'getAllPublisherIdsByAgencyId', array(5, 6));
        $oMaxDalEntities->expectArgumentsAt(2, 'getAllPublisherIdsByAgencyId', array(2));
        $oMaxDalEntities->expectCallCount('getAllPublisherIdsByAgencyId', 3);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAgencyIds', array(1, 2));
        $oMaxDalEntities->expectCallCount('getAllActiveAgencyIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', array(10));
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', array(1, 3));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllActiveChannelIdsByAgencyPublisherId', array(11));
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllActiveChannelIdsByAgencyPublisherId', array(1, 4));
        $oMaxDalEntities->setReturnValueAt(2, 'getAllActiveChannelIdsByAgencyPublisherId', array(12));
        $oMaxDalEntities->expectArgumentsAt(2, 'getAllActiveChannelIdsByAgencyPublisherId', array(2, 5));
        $oMaxDalEntities->setReturnValueAt(3, 'getAllActiveChannelIdsByAgencyPublisherId', array(13, 14));
        $oMaxDalEntities->expectArgumentsAt(3, 'getAllActiveChannelIdsByAgencyPublisherId', array(2, 6));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyPublisherId', 4);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllChannelForecastZonesIdsByPublisherId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllChannelForecastZonesIdsByPublisherId', array(3));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllChannelForecastZonesIdsByPublisherId', null);
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllChannelForecastZonesIdsByPublisherId', array(4));
        $oMaxDalEntities->setReturnValueAt(2, 'getAllChannelForecastZonesIdsByPublisherId', null);
        $oMaxDalEntities->expectArgumentsAt(2, 'getAllChannelForecastZonesIdsByPublisherId', array(5));
        $oMaxDalEntities->setReturnValueAt(3, 'getAllChannelForecastZonesIdsByPublisherId', null);
        $oMaxDalEntities->expectArgumentsAt(3, 'getAllChannelForecastZonesIdsByPublisherId', array(6));
        $oMaxDalEntities->expectCallCount('getAllChannelForecastZonesIdsByPublisherId', 4);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise($this);
        $oSummariseChannels->expectNever('_summariseByChannel');
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $oSummariseChannels->_summarise($oStartDate, $oEndDate);

        $oSummariseChannels->tally();
        $oSummariseChannels->oDalEntities->tally();

        // Test 20
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyId', array(0));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllActiveChannelIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllActiveChannelIdsByAgencyId', array(1));
        $oMaxDalEntities->setReturnValueAt(2, 'getAllActiveChannelIdsByAgencyId', array(15));
        $oMaxDalEntities->expectArgumentsAt(2, 'getAllActiveChannelIdsByAgencyId', array(2));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyId', 3);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllPublisherIdsByAgencyId', null);
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllPublisherIdsByAgencyId', array(0));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllPublisherIdsByAgencyId', array(3, 4));
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllPublisherIdsByAgencyId', array(1));
        $oMaxDalEntities->setReturnValueAt(2, 'getAllPublisherIdsByAgencyId', array(5, 6));
        $oMaxDalEntities->expectArgumentsAt(2, 'getAllPublisherIdsByAgencyId', array(2));
        $oMaxDalEntities->expectCallCount('getAllPublisherIdsByAgencyId', 3);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveAgencyIds', array(1, 2));
        $oMaxDalEntities->expectCallCount('getAllActiveAgencyIds', 1);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', array(10));
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllActiveChannelIdsByAgencyPublisherId', array(1, 3));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllActiveChannelIdsByAgencyPublisherId', array(11));
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllActiveChannelIdsByAgencyPublisherId', array(1, 4));
        $oMaxDalEntities->setReturnValueAt(2, 'getAllActiveChannelIdsByAgencyPublisherId', array(12));
        $oMaxDalEntities->expectArgumentsAt(2, 'getAllActiveChannelIdsByAgencyPublisherId', array(2, 5));
        $oMaxDalEntities->setReturnValueAt(3, 'getAllActiveChannelIdsByAgencyPublisherId', array(13, 14));
        $oMaxDalEntities->expectArgumentsAt(3, 'getAllActiveChannelIdsByAgencyPublisherId', array(2, 6));
        $oMaxDalEntities->expectCallCount('getAllActiveChannelIdsByAgencyPublisherId', 4);
        $oMaxDalEntities->setReturnValueAt(0, 'getAllChannelForecastZonesIdsByPublisherId', array(110));
        $oMaxDalEntities->expectArgumentsAt(0, 'getAllChannelForecastZonesIdsByPublisherId', array(3));
        $oMaxDalEntities->setReturnValueAt(1, 'getAllChannelForecastZonesIdsByPublisherId', array(111));
        $oMaxDalEntities->expectArgumentsAt(1, 'getAllChannelForecastZonesIdsByPublisherId', array(4));
        $oMaxDalEntities->setReturnValueAt(2, 'getAllChannelForecastZonesIdsByPublisherId', array(112));
        $oMaxDalEntities->expectArgumentsAt(2, 'getAllChannelForecastZonesIdsByPublisherId', array(5));
        $oMaxDalEntities->setReturnValueAt(3, 'getAllChannelForecastZonesIdsByPublisherId', array(113, 114));
        $oMaxDalEntities->expectArgumentsAt(3, 'getAllChannelForecastZonesIdsByPublisherId', array(6));
        $oMaxDalEntities->expectCallCount('getAllChannelForecastZonesIdsByPublisherId', 4);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summarise($this);
        $oSummariseChannels->expectArgumentsAt(0, '_summariseByChannel', array($oStartDate, $oEndDate, 10, array(110)));
        $oSummariseChannels->expectArgumentsAt(1, '_summariseByChannel', array($oStartDate, $oEndDate, 11, array(111)));
        $oSummariseChannels->expectArgumentsAt(2, '_summariseByChannel', array($oStartDate, $oEndDate, 12, array(112)));
        $oSummariseChannels->expectArgumentsAt(3, '_summariseByChannel', array($oStartDate, $oEndDate, 15, array(112)));
        $oSummariseChannels->expectArgumentsAt(4, '_summariseByChannel', array($oStartDate, $oEndDate, 13, array(113, 114)));
        $oSummariseChannels->expectArgumentsAt(5, '_summariseByChannel', array($oStartDate, $oEndDate, 14, array(113, 114)));
        $oSummariseChannels->expectArgumentsAt(6, '_summariseByChannel', array($oStartDate, $oEndDate, 15, array(113, 114)));
        $oSummariseChannels->expectCallCount('_summariseByChannel', 7);
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $oSummariseChannels->_summarise($oStartDate, $oEndDate);

        $oSummariseChannels->tally();
        $oSummariseChannels->oDalEntities->tally();
    }

    /**
     * A method to test the _summariseByChannel() method.
     *
     * Requirements:
     * Test 1: Test that when the SQL limitations cannot be created,
     *         no action it taken.
     * Test 2: Test that when the SQL limitations can be created, the
     *         correct action is taken.
     */
    function test_summariseByChannel()
    {
        $oServiceLocator = &ServiceLocator::instance();

        $oStartDate = new Date('2006-10-13 00:00:00');
        $oEndDate = new Date('2006-10-13 23:59:59');
        $channelId = 1;
        $aZoneIds = array(
            0 => 7,
            1 => 9
        );

        // Test 1
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oMaxDalMaintenanceForecasting = new MockMAX_Dal_Maintenance_Forecasting($this);
        $oServiceLocator->register('MAX_Dal_Maintenance_Forecasting', $oMaxDalMaintenanceForecasting);

        $oChannelLimitations = new MockMAX_Maintenance_Forecasting_Channel_Limitations($this);
        $oChannelLimitations->expectArgumentsAt(0, 'buildLimitations', array(1));
        $oChannelLimitations->expectCallCount('buildLimitations', 1);
        $oChannelLimitations->setReturnValueAt(0, 'buildLimitations', false);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summariseByChannel($this);
        $oSummariseChannels->expectCallCount('_getChannelLimitation', 1);
        $oSummariseChannels->setReturnValueAt(0, '_getChannelLimitation', $oChannelLimitations);
        $oSummariseChannels->expectNever('_summariseBySqlLimitations');
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();

        $oSummariseChannels->_summariseByChannel($oStartDate, $oEndDate, $channelId, $aZoneIds);

        $oSummariseChannels->tally();
        $oSummariseChannels->oChannelLimitations->tally();

        // Test 2
        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oMaxDalMaintenanceForecasting = new MockMAX_Dal_Maintenance_Forecasting($this);
        $oMaxDalMaintenanceForecasting->expectArgumentsAt(0, 'saveChannelSummaryForZones', array($oStartDate, $channelId, array('impressions' => 5)));
        $oMaxDalMaintenanceForecasting->expectCallCount('saveChannelSummaryForZones', 1);
        $oServiceLocator->register('MAX_Dal_Maintenance_Forecasting', $oMaxDalMaintenanceForecasting);

        $oChannelLimitations = new MockMAX_Maintenance_Forecasting_Channel_Limitations($this);
        $oChannelLimitations->expectArgumentsAt(0, 'buildLimitations', array(1));
        $oChannelLimitations->expectCallCount('buildLimitations', 1);
        $oChannelLimitations->setReturnValueAt(0, 'buildLimitations', true);

        $oSummariseChannels = new MockMAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels_test_summariseByChannel($this);
        $oSummariseChannels->expectCallCount('_getChannelLimitation', 1);
        $oSummariseChannels->setReturnValueAt(0, '_getChannelLimitation', $oChannelLimitations);
        $oSummariseChannels->expectArgumentsAt(0, '_summariseBySqlLimitations', array($oStartDate, $oEndDate, $aZoneIds));
        $oSummariseChannels->expectCallCount('_summariseBySqlLimitations', 1);
        $oSummariseChannels->setReturnValueAt(0, '_summariseBySqlLimitations', array('impressions' => 5));
        $oSummariseChannels->MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();

        $oSummariseChannels->_summariseByChannel($oStartDate, $oEndDate, $channelId, $aZoneIds);

        $oSummariseChannels->tally();
        $oSummariseChannels->oChannelLimitations->tally();
        $oSummariseChannels->oDal->tally();
    }

    /**
     * A method to test the _summariseBySqlLimitations() method.
     *
     * Requirements:
     * Test 1: Test with no values in $conf['maintenance']['channelForecasting']
     *         and ensure an empty array is returned, with no calls to the DAL
     *         made.
     * Test 2: Test with values in $conf['maintenance']['channelForecasting'],
     *         non-split tables, and ensure the correct calls are made to the
     *         DAL, and that the returned values are stored correctly.
     * Test 2: Test with values in $conf['maintenance']['channelForecasting'],
     *         split tables, and ensure the correct calls are made to the
     *         DAL, and that the returned values are stored correctly.
     */
    function test_summariseBySqlLimitations()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oServiceLocator = &ServiceLocator::instance();

        $oStartDate = new Date('2006-10-13 00:00:00');
        $oEndDate = new Date('2006-10-13 23:59:59');
        $aZoneIds = array(
            0 => 7,
            1 => 9
        );

        // Test 1
        $conf['maintenance']['channelForecasting'] = false;

        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oMaxDalMaintenanceForecasting = new MockMAX_Dal_Maintenance_Forecasting($this);
        $oMaxDalMaintenanceForecasting->expectNever('summariseRecordsInZonesBySqlLimitations');
        $oServiceLocator->register('MAX_Dal_Maintenance_Forecasting', $oMaxDalMaintenanceForecasting);
        $oSummariseChannels = new MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $aResult = $oSummariseChannels->_summariseBySqlLimitations($oStartDate, $oEndDate, $aZoneIds);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        $oSummariseChannels->oDal->tally();

        // Test 2
        $conf['maintenance']['channelForecasting'] = true;
        $conf['table']['split'] = false;

        $impressionTable = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];

        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oMaxDalMaintenanceForecasting = new MockMAX_Dal_Maintenance_Forecasting($this);
        $oMaxDalMaintenanceForecasting->expectArgumentsAt(0, 'summariseRecordsInZonesBySqlLimitations', array(null, $oStartDate, $oEndDate, $aZoneIds, $impressionTable));
        $oMaxDalMaintenanceForecasting->expectCallCount('summariseRecordsInZonesBySqlLimitations', 1);
        $oMaxDalMaintenanceForecasting->setReturnValueAt(0, 'summariseRecordsInZonesBySqlLimitations', array(1 => 500));
        $oServiceLocator->register('MAX_Dal_Maintenance_Forecasting', $oMaxDalMaintenanceForecasting);

        $oSummariseChannels = new MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $aResult = $oSummariseChannels->_summariseBySqlLimitations($oStartDate, $oEndDate, $aZoneIds);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[1], 500);
        $oSummariseChannels->oDal->tally();

        // Test 3
        $conf['maintenance']['channelForecasting'] = true;
        $conf['table']['split'] = true;

        $impressionTable = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'] . '_20061013';

        $oMaxDalEntities = new MockMAX_Dal_Entities($this);
        $oServiceLocator->register('MAX_Dal_Entities', $oMaxDalEntities);

        $oMaxDalMaintenanceForecasting = new MockMAX_Dal_Maintenance_Forecasting($this);
        $oMaxDalMaintenanceForecasting->expectArgumentsAt(0, 'summariseRecordsInZonesBySqlLimitations', array(null, $oStartDate, $oEndDate, $aZoneIds, $impressionTable));
        $oMaxDalMaintenanceForecasting->expectCallCount('summariseRecordsInZonesBySqlLimitations', 1);
        $oMaxDalMaintenanceForecasting->setReturnValueAt(0, 'summariseRecordsInZonesBySqlLimitations', array(1 => 500));
        $oServiceLocator->register('MAX_Dal_Maintenance_Forecasting', $oMaxDalMaintenanceForecasting);

        $oSummariseChannels = new MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $aResult = $oSummariseChannels->_summariseBySqlLimitations($oStartDate, $oEndDate, $aZoneIds);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[1], 500);
        $oSummariseChannels->oDal->tally();

        TestEnv::restoreConfig();
    }

}

?>
