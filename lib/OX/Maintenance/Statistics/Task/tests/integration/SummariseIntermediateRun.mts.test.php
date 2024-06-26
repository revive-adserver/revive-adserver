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

require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once LIB_PATH . '/Dal/Maintenance/Statistics/Factory.php';
require_once LIB_PATH . '/Maintenance/Statistics.php';
require_once LIB_PATH . '/Maintenance/Statistics/Task/SummariseIntermediate.php';

Language_Loader::load();

/**
 * A class for testing the OX_Maintenance_Statistics_Task_MigrateBucketData class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 */
class Test_OX_Maintenance_Statistics_Task_MigrateBucketData extends UnitTestCase
{
    /**
     * A method to test the main run() method.
     */
    public function testRun()
    {
        $oDbh = OA_DB::singleton();
        $timestampCastString = $oDbh->dbsyntax == 'pgsql' ? '::timestamp' : '';

        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;
        $oServiceLocator = OA_ServiceLocator::instance();

        $oFactory = new OX_Dal_Maintenance_Statistics_Factory();
        $oDalMaintenanceStatsticsClassName = $oFactory->deriveClassName();

        // Test 1: Run, with the migration required but with no plugins installed
        $oNowDate = new Date('2008-08-28 09:01:00');
        $oServiceLocator->register('now', $oNowDate);

        $oMaintenanceStatistics = new OX_Maintenance_Statistics();
        $oMaintenanceStatistics->updateIntermediate = true;
        $oMaintenanceStatistics->oLastDateIntermediate = new Date('2008-08-28 07:59:59');
        $oMaintenanceStatistics->oUpdateIntermediateToDate = new Date('2008-08-28 08:59:59');

        Mock::generatePartial(
            $oDalMaintenanceStatsticsClassName,
            'MockOX_Dal_Maintenance_Statistics_Test_1',
            [
                'summariseBucketsRaw',
                'summariseBucketsRawSupplementary',
                'summariseBucketsAggregate',
                'migrateRawRequests',
                'migrateRawImpressions',
                'migrateRawClicks',
            ],
        );
        $oDal = new MockOX_Dal_Maintenance_Statistics_Test_1($this);

        $oDal->expectNever('summariseBucketsRaw');
        $oDal->expectNever('summariseBucketsRawSupplementary');
        $oDal->expectNever('summariseBucketsAggregate');
        $oDal->expectNever('migrateRawRequests');
        $oDal->expectNever('migrateRawImpressions');
        $oDal->expectNever('migrateRawClicks');

        (new ReflectionMethod($oDalMaintenanceStatsticsClassName, '__construct'))->invoke($oDal);

        $oServiceLocator->register('OX_Dal_Maintenance_Statistics', $oDal);
        $oSummariseIntermediate = new OX_Maintenance_Statistics_Task_MigrateBucketData();
        $oSummariseIntermediate->run();
        $oDal = $oServiceLocator->get('OX_Dal_Maintenance_Statistics');
        $oDal->tally();

        // Create the "application_variable" table required for installing the plugin
        $oTables = OA_DB_Table_Core::singleton();
        $oTables->createTable('application_variable');

        // Setup the default OpenX delivery logging plugin for the next test
        TestEnv::installPluginPackage('openXDeliveryLog', false);

        // Test 2: Run, with plugins installed, but with the migration not required
        $oNowDate = new Date('2008-08-28 09:01:00');
        $oServiceLocator->register('now', $oNowDate);

        $oMaintenanceStatistics = new OX_Maintenance_Statistics();
        $oMaintenanceStatistics->updateIntermediate = false;

        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);

        Mock::generatePartial(
            $oDalMaintenanceStatsticsClassName,
            'MockOX_Dal_Maintenance_Statistics_Test_2',
            [
                'summariseBucketsRaw',
                'summariseBucketsRawSupplementary',
                'summariseBucketsAggregate',
                'migrateRawRequests',
                'migrateRawImpressions',
                'migrateRawClicks',
            ],
        );
        $oDal = new MockOX_Dal_Maintenance_Statistics_Test_2($this);

        $oDal->expectNever('summariseBucketsRaw');
        $oDal->expectNever('summariseBucketsRawSupplementary');
        $oDal->expectNever('summariseBucketsAggregate');
        $oDal->expectNever('migrateRawRequests');
        $oDal->expectNever('migrateRawImpressions');
        $oDal->expectNever('migrateRawClicks');

        (new ReflectionMethod($oDalMaintenanceStatsticsClassName, '__construct'))->invoke($oDal);

        $oServiceLocator->register('OX_Dal_Maintenance_Statistics', $oDal);
        $oSummariseIntermediate = new OX_Maintenance_Statistics_Task_MigrateBucketData();
        $oSummariseIntermediate->run();
        $oDal = $oServiceLocator->get('OX_Dal_Maintenance_Statistics');
        $oDal->tally();

        // Test 3: Run, with plugins installed and with the migration required for a single
        //         operation interval
        $oNowDate = new Date('2008-08-28 09:01:00');
        $oServiceLocator->register('now', $oNowDate);

        $oMaintenanceStatistics = new OX_Maintenance_Statistics();
        $oMaintenanceStatistics->updateIntermediate = true;
        $oMaintenanceStatistics->oLastDateIntermediate = new Date('2008-08-28 07:59:59');
        $oMaintenanceStatistics->oUpdateIntermediateToDate = new Date('2008-08-28 08:59:59');

        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);

        Mock::generatePartial(
            $oDalMaintenanceStatsticsClassName,
            'MockOX_Dal_Maintenance_Statistics_Test_3',
            [
                'summariseBucketsRaw',
                'summariseBucketsRawSupplementary',
                'summariseBucketsAggregate',
                'migrateRawRequests',
                'migrateRawImpressions',
                'migrateRawClicks',
            ],
        );
        $oDal = new MockOX_Dal_Maintenance_Statistics_Test_3($this);

        $oComponent = OX_Component::factory('deliveryLog', 'oxLogConversion', 'logConversion');
        $oStartDate = new Date('2008-08-28 07:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 09:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectOnce(
            'summariseBucketsRaw',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad_connection',
                $oComponent->getStatisticsMigration(),
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
            ],
        );

        $oComponent = OX_Component::factory('deliveryLog', 'oxLogConversion', 'logConversionVariable');
        $oStartDate = new Date('2008-08-28 07:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 09:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectOnce(
            'summariseBucketsRawSupplementary',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad_variable_value',
                $oComponent->getStatisticsMigration(),
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
            ],
        );

        $aMap = [];
        $oComponent = OX_Component::factory('deliveryLog', 'oxLogClick', 'logClick');
        $aMap[get_class($oComponent)] = $oComponent->getStatisticsMigration();
        $oComponent = OX_Component::factory('deliveryLog', 'oxLogImpression', 'logImpression');
        $aMap[get_class($oComponent)] = $oComponent->getStatisticsMigration();
        $oComponent = OX_Component::factory('deliveryLog', 'oxLogRequest', 'logRequest');
        $aMap[get_class($oComponent)] = $oComponent->getStatisticsMigration();
        $oStartDate = new Date('2008-08-28 07:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 09:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectOnce(
            'summariseBucketsAggregate',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad',
                $aMap,
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
                [
                    'operation_interval' => '60',
                    'operation_interval_id' => OX_OperationInterval::convertDateToOperationIntervalID($oStartDate),
                    'interval_start' => "'2008-08-28 08:00:00'{$timestampCastString}",
                    'interval_end' => "'2008-08-28 08:59:59'{$timestampCastString}",
                    'creative_id' => 0,
                    'updated' => "'2008-08-28 09:01:00'{$timestampCastString}",
                ],
            ],
        );

        $oDal->expectNever('migrateRawRequests');
        $oDal->expectNever('migrateRawImpressions');
        $oDal->expectNever('migrateRawClicks');

        (new ReflectionMethod($oDalMaintenanceStatsticsClassName, '__construct'))->invoke($oDal);

        $oServiceLocator->register('OX_Dal_Maintenance_Statistics', $oDal);
        $oSummariseIntermediate = new OX_Maintenance_Statistics_Task_MigrateBucketData();
        $oSummariseIntermediate->run();
        $oDal = $oServiceLocator->get('OX_Dal_Maintenance_Statistics');
        $oDal->tally();

        // Test 4: Run, with plugins installed and with the migration required for a single
        //         operation interval + migration of raw data set to occur
        $doApplication_variable = OA_Dal::factoryDO('application_variable');
        $doApplication_variable->name = 'mse_process_raw';
        $doApplication_variable->value = '1';
        $doApplication_variable->insert();

        $oNowDate = new Date('2008-08-28 09:01:00');
        $oServiceLocator->register('now', $oNowDate);

        $oMaintenanceStatistics = new OX_Maintenance_Statistics();
        $oMaintenanceStatistics->updateIntermediate = true;
        $oMaintenanceStatistics->oLastDateIntermediate = new Date('2008-08-28 07:59:59');
        $oMaintenanceStatistics->oUpdateIntermediateToDate = new Date('2008-08-28 08:59:59');

        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);

        Mock::generatePartial(
            $oDalMaintenanceStatsticsClassName,
            'MockOX_Dal_Maintenance_Statistics_Test_4',
            [
                'summariseBucketsRaw',
                'summariseBucketsRawSupplementary',
                'summariseBucketsAggregate',
                'migrateRawRequests',
                'migrateRawImpressions',
                'migrateRawClicks',
            ],
        );
        $oDal = new MockOX_Dal_Maintenance_Statistics_Test_4($this);

        $oComponent = OX_Component::factory('deliveryLog', 'oxLogConversion', 'logConversion');
        $oStartDate = new Date('2008-08-28 07:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 09:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectOnce(
            'summariseBucketsRaw',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad_connection',
                $oComponent->getStatisticsMigration(),
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
            ],
        );

        $oComponent = OX_Component::factory('deliveryLog', 'oxLogConversion', 'logConversionVariable');
        $oStartDate = new Date('2008-08-28 07:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 09:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectOnce(
            'summariseBucketsRawSupplementary',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad_variable_value',
                $oComponent->getStatisticsMigration(),
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
            ],
        );

        $aMap = [];
        $oComponent = OX_Component::factory('deliveryLog', 'oxLogClick', 'logClick');
        $aMap[get_class($oComponent)] = $oComponent->getStatisticsMigration();
        $oComponent = OX_Component::factory('deliveryLog', 'oxLogImpression', 'logImpression');
        $aMap[get_class($oComponent)] = $oComponent->getStatisticsMigration();
        $oComponent = OX_Component::factory('deliveryLog', 'oxLogRequest', 'logRequest');
        $aMap[get_class($oComponent)] = $oComponent->getStatisticsMigration();
        $oStartDate = new Date('2008-08-28 07:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 09:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectOnce(
            'summariseBucketsAggregate',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad',
                $aMap,
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
                [
                    'operation_interval' => '60',
                    'operation_interval_id' => OX_OperationInterval::convertDateToOperationIntervalID($oStartDate),
                    'interval_start' => "'2008-08-28 08:00:00'{$timestampCastString}",
                    'interval_end' => "'2008-08-28 08:59:59'{$timestampCastString}",
                    'creative_id' => 0,
                    'updated' => "'2008-08-28 09:01:00'{$timestampCastString}",
                ],
            ],
        );

        $oDal->expectOnce(
            'migrateRawRequests',
            [
                $oStartDate,
                $oEndDate,
            ],
        );

        $oDal->expectOnce(
            'migrateRawImpressions',
            [
                $oStartDate,
                $oEndDate,
            ],
        );

        $oDal->expectOnce(
            'migrateRawClicks',
            [
                $oStartDate,
                $oEndDate,
            ],
        );

        (new ReflectionMethod($oDalMaintenanceStatsticsClassName, '__construct'))->invoke($oDal);

        $oServiceLocator->register('OX_Dal_Maintenance_Statistics', $oDal);
        $oSummariseIntermediate = new OX_Maintenance_Statistics_Task_MigrateBucketData();
        $oSummariseIntermediate->run();
        $oDal = $oServiceLocator->get('OX_Dal_Maintenance_Statistics');
        $oDal->tally();

        $doApplication_variable = OA_Dal::factoryDO('application_variable');
        $doApplication_variable->name = 'mse_process_raw';
        $doApplication_variable->value = '1';
        $doApplication_variable->find();
        $rows = $doApplication_variable->getRowCount();
        $this->assertEqual($rows, 0);

        // Test 5: Run, with plugins installed and with the migration required for multiple
        //         operation intervals
        $oNowDate = new Date('2008-08-28 11:01:00');
        $oServiceLocator->register('now', $oNowDate);

        $oMaintenanceStatistics = new OX_Maintenance_Statistics();
        $oMaintenanceStatistics->updateIntermediate = true;
        $oMaintenanceStatistics->oLastDateIntermediate = new Date('2008-08-28 07:59:59');
        $oMaintenanceStatistics->oUpdateIntermediateToDate = new Date('2008-08-28 10:59:59');
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);

        Mock::generatePartial(
            $oDalMaintenanceStatsticsClassName,
            'MockOX_Dal_Maintenance_Statistics_Test_5',
            [
                'summariseBucketsRaw',
                'summariseBucketsRawSupplementary',
                'summariseBucketsAggregate',
                'migrateRawRequests',
                'migrateRawImpressions',
                'migrateRawClicks',
            ],
        );
        $oDal = new MockOX_Dal_Maintenance_Statistics_Test_5($this);

        $oDal->expectCallCount('summariseBucketsRaw', 3);
        $oDal->expectCallCount('summariseBucketsRawSupplementary', 3);
        $oDal->expectCallCount('summariseBucketsAggregate', 3);

        $oComponent = OX_Component::factory('deliveryLog', 'oxLogConversion', 'logConversion');
        $oStartDate = new Date('2008-08-28 07:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 09:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            0,
            'summariseBucketsRaw',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad_connection',
                $oComponent->getStatisticsMigration(),
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
            ],
        );
        $oStartDate = new Date('2008-08-28 08:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 10:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            1,
            'summariseBucketsRaw',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad_connection',
                $oComponent->getStatisticsMigration(),
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
            ],
        );
        $oStartDate = new Date('2008-08-28 09:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 11:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            2,
            'summariseBucketsRaw',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad_connection',
                $oComponent->getStatisticsMigration(),
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
            ],
        );

        $oComponent = OX_Component::factory('deliveryLog', 'oxLogConversion', 'logConversionVariable');
        $oStartDate = new Date('2008-08-28 07:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 09:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            0,
            'summariseBucketsRawSupplementary',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad_variable_value',
                $oComponent->getStatisticsMigration(),
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
            ],
        );
        $oStartDate = new Date('2008-08-28 08:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 10:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            1,
            'summariseBucketsRawSupplementary',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad_variable_value',
                $oComponent->getStatisticsMigration(),
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
            ],
        );
        $oStartDate = new Date('2008-08-28 09:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 11:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            2,
            'summariseBucketsRawSupplementary',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad_variable_value',
                $oComponent->getStatisticsMigration(),
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
            ],
        );

        $aMap = [];
        $oComponent = OX_Component::factory('deliveryLog', 'oxLogClick', 'logClick');
        $aMap[get_class($oComponent)] = $oComponent->getStatisticsMigration();
        $oComponent = OX_Component::factory('deliveryLog', 'oxLogImpression', 'logImpression');
        $aMap[get_class($oComponent)] = $oComponent->getStatisticsMigration();
        $oComponent = OX_Component::factory('deliveryLog', 'oxLogRequest', 'logRequest');
        $aMap[get_class($oComponent)] = $oComponent->getStatisticsMigration();
        $oStartDate = new Date('2008-08-28 07:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 09:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            0,
            'summariseBucketsAggregate',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad',
                $aMap,
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
                [
                    'operation_interval' => '60',
                    'operation_interval_id' => OX_OperationInterval::convertDateToOperationIntervalID($oStartDate),
                    'interval_start' => "'2008-08-28 08:00:00'{$timestampCastString}",
                    'interval_end' => "'2008-08-28 08:59:59'{$timestampCastString}",
                    'creative_id' => 0,
                    'updated' => "'2008-08-28 11:01:00'{$timestampCastString}",
                ],
            ],
        );
        $oStartDate = new Date('2008-08-28 08:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 10:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            1,
            'summariseBucketsAggregate',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad',
                $aMap,
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
                [
                    'operation_interval' => '60',
                    'operation_interval_id' => OX_OperationInterval::convertDateToOperationIntervalID($oStartDate),
                    'interval_start' => "'2008-08-28 09:00:00'{$timestampCastString}",
                    'interval_end' => "'2008-08-28 09:59:59'{$timestampCastString}",
                    'creative_id' => 0,
                    'updated' => "'2008-08-28 11:01:00'{$timestampCastString}",
                ],
            ],
        );
        $oStartDate = new Date('2008-08-28 09:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 11:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            2,
            'summariseBucketsAggregate',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad',
                $aMap,
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
                [
                    'operation_interval' => '60',
                    'operation_interval_id' => OX_OperationInterval::convertDateToOperationIntervalID($oStartDate),
                    'interval_start' => "'2008-08-28 10:00:00'{$timestampCastString}",
                    'interval_end' => "'2008-08-28 10:59:59'{$timestampCastString}",
                    'creative_id' => 0,
                    'updated' => "'2008-08-28 11:01:00'{$timestampCastString}",
                ],
            ],
        );

        $oDal->expectNever('migrateRawRequests');
        $oDal->expectNever('migrateRawImpressions');
        $oDal->expectNever('migrateRawClicks');

        (new ReflectionMethod($oDalMaintenanceStatsticsClassName, '__construct'))->invoke($oDal);

        $oServiceLocator->register('OX_Dal_Maintenance_Statistics', $oDal);
        $oSummariseIntermediate = new OX_Maintenance_Statistics_Task_MigrateBucketData();
        $oSummariseIntermediate->run();
        $oDal = $oServiceLocator->get('OX_Dal_Maintenance_Statistics');
        $oDal->tally();

        // Test 6: Run, with plugins installed and with the migration required for multiple
        //         operation intervals + migration of raw data set to occur
        $doApplication_variable = OA_Dal::factoryDO('application_variable');
        $doApplication_variable->name = 'mse_process_raw';
        $doApplication_variable->value = '1';
        $doApplication_variable->insert();

        $oNowDate = new Date('2008-08-28 11:01:00');
        $oServiceLocator->register('now', $oNowDate);

        $oMaintenanceStatistics = new OX_Maintenance_Statistics();
        $oMaintenanceStatistics->updateIntermediate = true;
        $oMaintenanceStatistics->oLastDateIntermediate = new Date('2008-08-28 07:59:59');
        $oMaintenanceStatistics->oUpdateIntermediateToDate = new Date('2008-08-28 10:59:59');
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);

        Mock::generatePartial(
            $oDalMaintenanceStatsticsClassName,
            'MockOX_Dal_Maintenance_Statistics_Test_6',
            [
                'summariseBucketsRaw',
                'summariseBucketsRawSupplementary',
                'summariseBucketsAggregate',
                'migrateRawRequests',
                'migrateRawImpressions',
                'migrateRawClicks',
            ],
        );
        $oDal = new MockOX_Dal_Maintenance_Statistics_Test_6($this);

        $oDal->expectCallCount('summariseBucketsRaw', 3);
        $oDal->expectCallCount('summariseBucketsRawSupplementary', 3);
        $oDal->expectCallCount('summariseBucketsAggregate', 3);

        $oComponent = OX_Component::factory('deliveryLog', 'oxLogConversion', 'logConversion');
        $oStartDate = new Date('2008-08-28 07:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 09:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            0,
            'summariseBucketsRaw',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad_connection',
                $oComponent->getStatisticsMigration(),
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
            ],
        );
        $oStartDate = new Date('2008-08-28 08:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 10:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            1,
            'summariseBucketsRaw',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad_connection',
                $oComponent->getStatisticsMigration(),
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
            ],
        );
        $oStartDate = new Date('2008-08-28 09:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 11:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            2,
            'summariseBucketsRaw',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad_connection',
                $oComponent->getStatisticsMigration(),
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
            ],
        );

        $oComponent = OX_Component::factory('deliveryLog', 'oxLogConversion', 'logConversionVariable');
        $oStartDate = new Date('2008-08-28 07:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 09:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            0,
            'summariseBucketsRawSupplementary',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad_variable_value',
                $oComponent->getStatisticsMigration(),
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
            ],
        );
        $oStartDate = new Date('2008-08-28 08:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 10:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            1,
            'summariseBucketsRawSupplementary',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad_variable_value',
                $oComponent->getStatisticsMigration(),
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
            ],
        );
        $oStartDate = new Date('2008-08-28 09:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 11:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            2,
            'summariseBucketsRawSupplementary',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad_variable_value',
                $oComponent->getStatisticsMigration(),
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
            ],
        );

        $aMap = [];
        $oComponent = OX_Component::factory('deliveryLog', 'oxLogClick', 'logClick');
        $aMap[get_class($oComponent)] = $oComponent->getStatisticsMigration();
        $oComponent = OX_Component::factory('deliveryLog', 'oxLogImpression', 'logImpression');
        $aMap[get_class($oComponent)] = $oComponent->getStatisticsMigration();
        $oComponent = OX_Component::factory('deliveryLog', 'oxLogRequest', 'logRequest');
        $aMap[get_class($oComponent)] = $oComponent->getStatisticsMigration();
        $oStartDate = new Date('2008-08-28 07:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 09:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            0,
            'summariseBucketsAggregate',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad',
                $aMap,
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
                [
                    'operation_interval' => '60',
                    'operation_interval_id' => OX_OperationInterval::convertDateToOperationIntervalID($oStartDate),
                    'interval_start' => "'2008-08-28 08:00:00'{$timestampCastString}",
                    'interval_end' => "'2008-08-28 08:59:59'{$timestampCastString}",
                    'creative_id' => 0,
                    'updated' => "'2008-08-28 11:01:00'{$timestampCastString}",
                ],
            ],
        );
        $oStartDate = new Date('2008-08-28 08:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 10:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            1,
            'summariseBucketsAggregate',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad',
                $aMap,
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
                [
                    'operation_interval' => '60',
                    'operation_interval_id' => OX_OperationInterval::convertDateToOperationIntervalID($oStartDate),
                    'interval_start' => "'2008-08-28 09:00:00'{$timestampCastString}",
                    'interval_end' => "'2008-08-28 09:59:59'{$timestampCastString}",
                    'creative_id' => 0,
                    'updated' => "'2008-08-28 11:01:00'{$timestampCastString}",
                ],
            ],
        );
        $oStartDate = new Date('2008-08-28 09:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 11:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            2,
            'summariseBucketsAggregate',
            [
                $aConf['table']['prefix'] . 'data_intermediate_ad',
                $aMap,
                [
                    'start' => $oStartDate,
                    'end' => $oEndDate,
                ],
                [
                    'operation_interval' => '60',
                    'operation_interval_id' => OX_OperationInterval::convertDateToOperationIntervalID($oStartDate),
                    'interval_start' => "'2008-08-28 10:00:00'{$timestampCastString}",
                    'interval_end' => "'2008-08-28 10:59:59'{$timestampCastString}",
                    'creative_id' => 0,
                    'updated' => "'2008-08-28 11:01:00'{$timestampCastString}",
                ],
            ],
        );

        $oStartDate = new Date('2008-08-28 07:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 09:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            0,
            'migrateRawRequests',
            [
                $oStartDate,
                $oEndDate,
            ],
        );
        $oDal->expectAt(
            0,
            'migrateRawImpressions',
            [
                $oStartDate,
                $oEndDate,
            ],
        );
        $oDal->expectAt(
            0,
            'migrateRawClicks',
            [
                $oStartDate,
                $oEndDate,
            ],
        );

        $oStartDate = new Date('2008-08-28 08:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 10:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            1,
            'migrateRawRequests',
            [
                $oStartDate,
                $oEndDate,
            ],
        );
        $oDal->expectAt(
            1,
            'migrateRawImpressions',
            [
                $oStartDate,
                $oEndDate,
            ],
        );
        $oDal->expectAt(
            1,
            'migrateRawClicks',
            [
                $oStartDate,
                $oEndDate,
            ],
        );

        $oStartDate = new Date('2008-08-28 09:59:59');
        $oStartDate->addSeconds(1);
        $oEndDate = new Date('2008-08-28 11:00:00');
        $oEndDate->subtractSeconds(1);
        $oDal->expectAt(
            2,
            'migrateRawRequests',
            [
                $oStartDate,
                $oEndDate,
            ],
        );
        $oDal->expectAt(
            2,
            'migrateRawImpressions',
            [
                $oStartDate,
                $oEndDate,
            ],
        );
        $oDal->expectAt(
            2,
            'migrateRawClicks',
            [
                $oStartDate,
                $oEndDate,
            ],
        );

        (new ReflectionMethod($oDalMaintenanceStatsticsClassName, '__construct'))->invoke($oDal);

        $oServiceLocator->register('OX_Dal_Maintenance_Statistics', $oDal);
        $oSummariseIntermediate = new OX_Maintenance_Statistics_Task_MigrateBucketData();
        $oSummariseIntermediate->run();
        $oDal = $oServiceLocator->get('OX_Dal_Maintenance_Statistics');
        $oDal->tally();

        $doApplication_variable = OA_Dal::factoryDO('application_variable');
        $doApplication_variable->name = 'mse_process_raw';
        $doApplication_variable->value = '1';
        $doApplication_variable->find();
        $rows = $doApplication_variable->getRowCount();
        $this->assertEqual($rows, 0);

        // Uninstall the installed plugins
        TestEnv::uninstallPluginPackage('openXDeliveryLog', false);

        // Reset the testing environment
        TestEnv::restoreEnv();
    }
}
