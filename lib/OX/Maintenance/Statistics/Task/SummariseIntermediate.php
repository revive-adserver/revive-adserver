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

require_once LIB_PATH . '/Maintenance/Statistics/Task.php';
require_once LIB_PATH . '/Plugin/PluginManager.php';

/**
 * The MSE process task class that migrates any logged delivery data
 * from the plugin bucket tables (of either aggregate or raw type) into
 * the OpenX 2.6-style data_intermediate_% tables during the MSE run.
 *
 * @package    OpenXMaintenance
 * @subpackage Statistics
 */
class OX_Maintenance_Statistics_Task_MigrateBucketData extends OX_Maintenance_Statistics_Task
{

    /**
     * An array to store packages (plugins) which have been installed in OpenX.
     *
     * @var array
     */
    var $aPackages;

    /**
     * An array to store start/end dates of the operation intervals that need
     * to have logged data migrated.
     *
     * @var array
     */
    var $aRunDates;

    /**
     * The constructor method.
     *
     * @return OX_Maintenance_Statistics_Task_MigrateBucketData
     */
    function __construct()
    {
        parent::__construct();

        // Locate all plugins (packages) that have been installed
        $oPluginManager = new OX_PluginManager();
        $this->aPackages = $oPluginManager->getPackagesList();

    }

    /**
     * The implementation of the OA_Task::run() method that performs
     * the required task of migrating bucket-based logged data to the
     * statistics table(s) specified by the appropriate plugin
     * components.
     */
    function run()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($this->oController->updateIntermediate) {

            // Locate all plugin components which may require bucket data to be
            // migrated from bucket tables to statistics tables
            $aSummariseComponents = $this->_locateComponents();

            // Are there any components that require data to be migrated?
            if (empty($aSummariseComponents)) {
                OA::debug('There are no installed plugins that require data migration', PEAR_LOG_DEBUG);
                return;
            }

            $message = '- Migrating bucket-based logged data to the statistics tables.';
            $this->oController->report .= $message . "\n";

            // Get the MSE DAL to perform the data migration
            $oServiceLocator =& OA_ServiceLocator::instance();
            $oDal =& $oServiceLocator->get('OX_Dal_Maintenance_Statistics');

            // Prepare the "now" date
            $oNowDate =& $oServiceLocator->get('now');
            if (!$oNowDate) {
                $oNowDate = new Date();
            }

            // Prepare an array of possible start and end dates for the migration, unless they have been set already
            if (empty($this->aRunDates)) {
                $this->aRunDates = array();
                $oStartDate = new Date();
                $oStartDate->copy($this->oController->oLastDateIntermediate);
                $oStartDate->addSeconds(1);
                while (Date::compare($oStartDate, $this->oController->oUpdateIntermediateToDate) < 0) {
                    // Calcuate the end of the operation interval
                    $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oStartDate);
                    $oEndDate = new Date();
                    $oEndDate->copy($aDates['end']);
                    // Store the dates
                    $oStoreStartDate = new Date();
                    $oStoreStartDate->copy($oStartDate);
                    $oStoreEndDate = new Date();
                    $oStoreEndDate->copy($oEndDate);
                    $this->aRunDates[] = array(
                        'start' => $oStoreStartDate,
                        'end'   => $oStoreEndDate
                    );
                    // Go to the next operation interval
                    $oStartDate->copy($oEndDate);
                    $oStartDate->addSeconds(1);
                }
            }

            // Check to see if any historical raw data needs to be migrated,
            // post-upgrade, and if so, migrate the data; requires that the
            // default openXDeliveryLog plugin is installed, so the migration
            // will not be called if it is not
            if (key_exists('openXDeliveryLog', $this->aPackages)) {
                $this->_postUpgrade();
            }

            // Prepare arrays of all of the migration maps of raw migrations
            $aRunComponents = $this->_prepareMaps($aSummariseComponents, 'raw');
            // Run each migration map separately, even if it's for the same table
            foreach ($aRunComponents as $statisticsTable => $aMaps) {
                foreach ($aMaps as $componentClassName => $aMigrationDetails) {
                    foreach ($this->aRunDates as $aDates) {
                        $message = "- Migrating raw bucket data from the '{$aMigrationDetails['bucketTable']}' bucket table";
                        OA::debug($message, PEAR_LOG_DEBUG);
                        $message = "  to the '$statisticsTable' table, for operation interval range";
                        OA::debug($message, PEAR_LOG_DEBUG);
                        $message = '  ' . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . ' ' . $aDates['start']->tz->getShortName() .
                                   ' to ' . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . ' ' . $aDates['end']->tz->getShortName();
                        OA::debug($message, PEAR_LOG_DEBUG);
                        $result = $oDal->summariseBucketsRaw($statisticsTable, $aMigrationDetails, $aDates);
                        if (PEAR::isError($result)) {
                            // Oh noz! The bucket data could not be migrated
                            // Tell the user all about it, but then just keep on truckin'...
                            $message = "   ERROR: Could not migrate raw bucket data from the '{$aMigrationDetails['bucketTable']}' bucket table";
                            OA::debug($message, PEAR_LOG_ERR);
                            $message = "   Error message was: {$result->message}";
                            OA::debug($message, PEAR_LOG_ERR);
                        } else {
                            $message = "  - Migrated $result row(s)";
                            OA::debug($message, PEAR_LOG_DEBUG);
                            $pruneResult = $aSummariseComponents[$statisticsTable][$componentClassName]->pruneBucket($aDates['end'], $aDates['start']);
                            if (PEAR::isError($pruneResult)) {
                                // Oh noz! The bucket data could not be pruned, and this is
                                // critical - if we can't prune the data, we'll end up double
                                // counting, so exit with a critical error...
                                $message = "   ERROR: Could not prune aggregate bucket data from the '" .
                                           $aSummariseComponents[$statisticsTable][$componentClassName]->getBucketName() . "' bucket table";
                                OA::debug($message, PEAR_LOG_CRIT);
                                $message = "   Error message was: {$pruneResult->message}";
                                OA::debug($message, PEAR_LOG_CRIT);
                                $message = "   Aborting maintenance execution";
                                OA::debug($message, PEAR_LOG_CRIT);
                                exit();
                            } else {
                                $message = "  - Pruned $pruneResult row(s)";
                                OA::debug($message, PEAR_LOG_DEBUG);
                            }
                        }
                    }
                }
            }

            // Prepare arrays of all of the migration maps of supplementary raw migrations
            $aRunComponents = $this->_prepareMaps($aSummariseComponents, 'rawSupplementary');
            // Run each migration map separately, even if it's for the same table
            foreach ($aRunComponents as $statisticsTable => $aMaps) {
                foreach ($aMaps as $componentClassName => $aMigrationDetails) {
                    foreach ($this->aRunDates as $aDates) {
                        $message = "- Migrating supplementary raw bucket data from the '{$aMigrationDetails['bucketTable']}' bucket table";
                        OA::debug($message, PEAR_LOG_DEBUG);
                        $message = "  to the '$statisticsTable' table, for operation interval range";
                        OA::debug($message, PEAR_LOG_DEBUG);
                        $message = '  ' . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . ' ' . $aDates['start']->tz->getShortName() .
                                   ' to ' . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . ' ' . $aDates['end']->tz->getShortName();
                        OA::debug($message, PEAR_LOG_DEBUG);
                        $result = $oDal->summariseBucketsRawSupplementary($statisticsTable, $aMigrationDetails, $aDates);
                        if (PEAR::isError($result)) {
                            // Oh noz! The bucket data could not be migrated
                            // Tell the user all about it, but then just keep on truckin'...
                            $message = "   ERROR: Could not migrate supplementary raw bucket data from the '{$aMigrationDetails['bucketTable']}' bucket table";
                            OA::debug($message, PEAR_LOG_ERR);
                            $message = "   Error message was: {$result->message}";
                            OA::debug($message, PEAR_LOG_ERR);
                        } else {
                            $message = "  - Migrated $result row(s)";
                            OA::debug($message, PEAR_LOG_DEBUG);
                            $pruneResult = $aSummariseComponents[$statisticsTable][$componentClassName]->pruneBucket($aDates['end'], $aDates['start']);
                            if (PEAR::isError($pruneResult)) {
                                // Oh noz! The bucket data could not be pruned, and this is
                                // critical - if we can't prune the data, we'll end up double
                                // counting, so exit with a critical error...
                                $message = "   ERROR: Could not prune aggregate bucket data from the '" .
                                           $aSummariseComponents[$statisticsTable][$componentClassName]->getBucketName() . "' bucket table";
                                OA::debug($message, PEAR_LOG_CRIT);
                                $message = "   Error message was: {$pruneResult->message}";
                                OA::debug($message, PEAR_LOG_CRIT);
                                $message = "   Aborting maintenance execution";
                                OA::debug($message, PEAR_LOG_CRIT);
                                exit();
                            } else {
                                $message = "  - Pruned $pruneResult row(s)";
                                OA::debug($message, PEAR_LOG_DEBUG);
                            }
                        }
                    }
                }
            }

            // Prepare arrays of all of the migration maps of aggregate migrations
            $aRunComponents = $this->_prepareMaps($aSummariseComponents, 'aggregate');
            // Run each migration map by statistics table
            foreach ($aRunComponents as $statisticsTable => $aMaps) {
                $aBucketTables = array();
                foreach ($aMaps as $aMap) {
                    $aBucketTables[] = $aMap['bucketTable'];
                }
                foreach ($this->aRunDates as $aDates) {
                    $aExtras = array();
                    // Is this the data_intermeidate_ad statistics table? It's special!
                    if ($statisticsTable == $aConf['table']['prefix'] . 'data_intermediate_ad') {
                        $aExtras = array(
                            'operation_interval'    => $aConf['maintenance']['operationInterval'],
                            'operation_interval_id' => OX_OperationInterval::convertDateToOperationIntervalID($aDates['start']),
                            'interval_start'        => $oDal->oDbh->quote($aDates['start']->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . $oDal->timestampCastString,
                            'interval_end'          => $oDal->oDbh->quote($aDates['end']->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . $oDal->timestampCastString,
                            'creative_id'           => 0,
                            'updated'               => $oDal->oDbh->quote($oNowDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . $oDal->timestampCastString,
                        );
                    }
                    $message = "- Migrating aggregate bucket data from the '" . implode("', '", $aBucketTables) . "' bucket table(s)";
                    OA::debug($message, PEAR_LOG_DEBUG);
                    $message = "  to the '$statisticsTable' table, for operation interval range";
                    OA::debug($message, PEAR_LOG_DEBUG);
                    $message = '  ' . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . ' ' . $aDates['start']->tz->getShortName() .
                               ' to ' . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . ' ' . $aDates['end']->tz->getShortName();
                    OA::debug($message, PEAR_LOG_DEBUG);
                    $result = $oDal->summariseBucketsAggregate($statisticsTable, $aMaps, $aDates, $aExtras);
                    if (PEAR::isError($result)) {
                        // Oh noz! The bucket data could not be migrated
                        // Tell the user all about it, but then just keep on truckin'...
                        $message = "   ERROR: Could not migrate aggregate bucket data from the '" . implode("', '", $aBucketTables) . "' bucket table(s)";
                        OA::debug($message, PEAR_LOG_ERR);
                        $message = "   Error message was: {$result->message}";
                        OA::debug($message, PEAR_LOG_ERR);
                    } else {
                        $message = "  - Migrated $result row(s)";
                        OA::debug($message, PEAR_LOG_DEBUG);
                        foreach ($aMaps as $componentClassName => $aMap) {
                            $pruneResult = $aSummariseComponents[$statisticsTable][$componentClassName]->pruneBucket($aDates['end'], $aDates['start']);
                            if (PEAR::isError($pruneResult)) {
                                // Oh noz! The bucket data could not be pruned, and this is
                                // critical - if we can't prune the data, we'll end up double
                                // counting, so exit with a critical error...
                                $message = "   ERROR: Could not prune aggregate bucket data from the '" .
                                           $aSummariseComponents[$statisticsTable][$componentClassName]->getBucketName() . "' bucket table";
                                OA::debug($message, PEAR_LOG_CRIT);
                                $message = "   Error message was: {$pruneResult->message}";
                                OA::debug($message, PEAR_LOG_CRIT);
                                $message = "   Aborting maintenance execution";
                                OA::debug($message, PEAR_LOG_CRIT);
                                exit();
                            } else {
                                $message = "  - Pruned $pruneResult row(s)";
                                OA::debug($message, PEAR_LOG_DEBUG);
                            }
                        }
                    }
                }
            }

            // Prepare arrays of all of the migration maps of custom migrations
            // (If we refactor stats this will be the one and only method.)
            $aRunComponents = $this->_prepareMaps($aSummariseComponents, 'custom');

            // Run each migration map by statistics table
            foreach ($aRunComponents as $statisticsTable => $aMaps) {
                $aBucketTables = array();
                foreach ($aMaps as $aMap) {
                    $aBucketTables[] = $aMap['bucketTable'];
                }
                foreach ($this->aRunDates as $aDates) {
                    $aExtras = array();

                    $message = "- Migrating aggregate bucket data from the '" . implode("', '", $aBucketTables) . "' bucket table(s)";
                    OA::debug($message, PEAR_LOG_DEBUG);
                    $message = "  to the '$statisticsTable' table, for operation interval range";
                    OA::debug($message, PEAR_LOG_DEBUG);
                    $message = '  ' . $aDates['start']->format('%Y-%m%d %H:%M:%S') . ' ' . $aDates['start']->tz->getShortName() .
                               ' to ' . $aDates['end']->format('%Y-%m%d %H:%M:%S') . ' ' . $aDates['end']->tz->getShortName();
                    OA::debug($message, PEAR_LOG_DEBUG);

                    // Call the components migrateStats method.
                    foreach ($aMaps as $componentClassName => $aMap) {
                        $result = $aSummariseComponents[$statisticsTable][$componentClassName]->migrateStatistics($aDates['end']);
                        if (PEAR::isError($result)) {
                            // Oh noz! The bucket data could not be migrated
                            // Tell the user all about it, but then just keep on truckin'...
                            $message = "   ERROR: Could not migrate aggregate bucket data from the '" . implode("', '", $aBucketTables) . "' bucket table(s)";
                            OA::debug($message, PEAR_LOG_ERR);
                            $message = "   Error message was: {$result->message}.";
                            OA::debug($message, PEAR_LOG_ERR);
                        } else {
                            // Only prune the bucket if we migrated the stats successfully.
                            $aSummariseComponents[$statisticsTable][$componentClassName]->pruneBucket($aDates['end'], $aDates['start']);
                        }
                    }
                }
            }
        }
        $this->aRunDates = array();
    }

    /**
     * A private method to locate and instantiate all components that
     * use the deliveryLog extension, and are in installed plugins, storing
     * them in an array, grouped by the component's destination statistics
     * table -- this will provide all of the plugin components that use
     * the deliveryLog extension (i.e. have bucket-based delivery data that
     * needs to be migrated to statistics tables), grouped by the detsination
     * statistics tables (so that all components that have data migrated to
     * the same table can be migrated in the one call).
     *
     * @access private
     * @return array An array of plugins components, as described above.
     */
    function _locateComponents()
    {
        $aSummariseComponents = array();
        foreach ($this->aPackages as $aPluginInfo) {
            foreach ($aPluginInfo['contents'] as $aContents) {
                if ($aContents['extends'] == 'deliveryLog') {
                    foreach ($aContents['components'] as $aComponent) {
                        $oComponent =& OX_Component::factory('deliveryLog', $aContents['name'], $aComponent['name']);
                        if ($oComponent->enabled) {
                            $destinationTable = $oComponent->getStatisticsTableName();
                            $aSummariseComponents[$destinationTable][get_class($oComponent)] = $oComponent;
                        }
                    }
                }
            }
        }
        return $aSummariseComponents;
    }

    /**
     * A private method to take the output of the
     * OX_Maintenance_Statistics_Task_MigrateBucketData::_locateComponents()
     * method, and convert it into an array of migration maps suitable for the
     * required migration type.
     *
     * @access private
     * @param array $aSummariseComponents An array of components from the
     *                                    OX_Maintenance_Statistics_Task_MigrateBucketData::_locateComponents()
     *                                    method.
     * @param string $type The type of map required - one of "raw",
     *                     "rawSupplementary" or "aggregate".
     * @return array An array of migration maps.
     */
    private function _prepareMaps($aSummariseComponents, $type)
    {
        $aRunComponents = array();
        if ($type == 'raw' || $type == 'rawSupplementary') {
            foreach ($aSummariseComponents as $statisticsTable => $aComponents) {
                foreach ($aComponents as $componentClassName => $oComponent) {
                    $aMap = $oComponent->getStatisticsMigration();
                    if (!$oComponent->testStatisticsMigration($aMap)) {
                        continue;
                    }
                    if ($aMap['method'] == 'aggregate') {
                        // Error! Cannot migrate raw/raw supplementary and aggregate
                        // values into the same statistics table, so re-set this
                        // statistics table and continue with the next table
                        unset($aRunComponents[$statisticsTable]);
                        break;
                    } else if ($aMap['method'] == $type) {
                        // Nice! We can migrate the raw or raw supplementary data
                        $aRunComponents[$statisticsTable][$componentClassName] = $aMap;
                    }
                }
            }
        } else if ($type == 'aggregate') {
            foreach ($aSummariseComponents as $statisticsTable => $aComponents) {
                foreach ($aComponents as $oComponent) {
                    $aMap = $oComponent->getStatisticsMigration();
                    if (!$oComponent->testStatisticsMigration($aMap)) {
                        continue;
                    }
                    if ($aMap['method'] == $type) {
                        // Nice! We can migrate aggregate data
                        $aRunComponents[$statisticsTable][get_class($oComponent)] = $aMap;
                    }
                }
            }
        } else if ($type == 'custom') {
            foreach ($aSummariseComponents as $statisticsTable => $aComponents) {
                foreach ($aComponents as $oComponent) {
                    $aMap = $oComponent->getStatisticsMigration();
                    if (!$oComponent->testStatisticsMigration($aMap)) {
                        continue;
        }
                    if ($aMap['method'] == $type) {
                        // Nice! We can migrate aggregate data
                        $aRunComponents[$statisticsTable][get_class($oComponent)] = $aMap;
                    }
                }
            }
        }
        return $aRunComponents;
    }

    /**
     * A private method to address the migration of any old raw data that
     * exists following an upgrade to (or beyond) OpenX 2.8.
     *
     * @access private
     */
    private function _postUpgrade()
    {
        // Check to see if the "mse_process_raw" application variable
        // flag has been set
        $doApplication_variable = OA_Dal::factoryDO('application_variable');
        $doApplication_variable->name  = 'mse_process_raw';
        $doApplication_variable->value = '1';
        $doApplication_variable->find();
        if ($doApplication_variable->getRowCount() > 0) {

            // The "mse_process_raw" application variable flag has been set
            $message = "- The " . PRODUCT_NAME . " maintenance process has detected that it is running immediately after";
            OA::debug($message, PEAR_LOG_INFO);
            $message = "  an upgrade from " . PRODUCT_NAME . " with version less than 2.8. As a result, there may be old";
            OA::debug($message, PEAR_LOG_INFO);
            $message = "  format raw data logged that needs to be processed. This data will now be processed...";
            OA::debug($message, PEAR_LOG_INFO);

            // Migrate the raw data from the old tables, into the bucket tables
            // Note that conversions are not handled; this is simply not feasible,
            // due to the major alteration of the way conversion tracking is
            // handled in OpenX between <= OpenX 2.6 and >= OpenX 2.8.
            foreach ($this->aRunDates as $aDates) {
                $this->_migrateRawRequests($aDates['start'], $aDates['end']);
                $this->_migrateRawImpressions($aDates['start'], $aDates['end']);
                $this->_migrateRawClicks($aDates['start'], $aDates['end']);
            }

            // Unset the "mse_process_raw" application variable flag
            $message = "- Deleting the 'mse_process_raw' application variable flag.";
            OA::debug($message, PEAR_LOG_DEBUG);
            $doApplication_variable->delete();

        }
    }

    /**
     * A private function to migrate raw format requests into bucket format
     * requests, post-upgrade to (or beyond) OpenX 2.8.
     *
     * @access private
     * @param PEAR::Date $oStart The start date of the operation interval
     *                           to migrate.
     * @param PEAR::Date $oEnd The end date of the operation interval to
     *                         migrate.
     */
    private function _migrateRawRequests($oStart, $oEnd)
    {
        $message = "   - Migrating raw requests into the new bucket table, for the operation interval";
        OA::debug($message, PEAR_LOG_DEBUG);
        $message = "     starting " . $oStart->format('%Y-%m-%d %H:%M:%S') . ' ' . $oStart->tz->getShortName() .
                   " and ending " . $oEnd->format('%Y-%m-%d %H:%M:%S') . ' ' . $oEnd->tz->getShortName() . ".";
        OA::debug($message, PEAR_LOG_DEBUG);

        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDal =& $oServiceLocator->get('OX_Dal_Maintenance_Statistics');
        $oDal->migrateRawRequests($oStart, $oEnd);
    }

    /**
     * A private function to migrate raw format impressions into bucket format
     * impressions, post-upgrade to (or beyond) OpenX 2.8.
     *
     * @access private
     * @param PEAR::Date $oStart The start date of the operation interval
     *                           to migrate.
     * @param PEAR::Date $oEnd The end date of the operation interval to
     *                         migrate.
     */
    private function _migrateRawImpressions($oStart, $oEnd)
    {
        $message = "   - Migrating raw impressions into the new bucket table, for the operation interval";
        OA::debug($message, PEAR_LOG_DEBUG);
        $message = "     starting " . $oStart->format('%Y-%m-%d %H:%M:%S') . ' ' . $oStart->tz->getShortName() .
                   " and ending " . $oEnd->format('%Y-%m-%d %H:%M:%S') . ' ' . $oEnd->tz->getShortName() . ".";
        OA::debug($message, PEAR_LOG_DEBUG);

        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDal =& $oServiceLocator->get('OX_Dal_Maintenance_Statistics');
        $oDal->migrateRawImpressions($oStart, $oEnd);
    }

    /**
     * A private function to migrate raw format clicks into bucket format
     * clicks, post-upgrade to (or beyond) OpenX 2.8.
     *
     * @access private
     * @param PEAR::Date $oStart The start date of the operation interval
     *                           to migrate.
     * @param PEAR::Date $oEnd The end date of the operation interval to
     *                         migrate.
     */
    private function _migrateRawClicks($oStart, $oEnd)
    {
        $message = "   - Migrating raw clicks into the new bucket table, for the operation interval";
        OA::debug($message, PEAR_LOG_DEBUG);
        $message = "     starting " . $oStart->format('%Y-%m-%d %H:%M:%S') . ' ' . $oStart->tz->getShortName() .
                   " and ending " . $oEnd->format('%Y-%m-%d %H:%M:%S') . ' ' . $oEnd->tz->getShortName() . ".";
        OA::debug($message, PEAR_LOG_DEBUG);

        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDal =& $oServiceLocator->get('OX_Dal_Maintenance_Statistics');
        $oDal->migrateRawClicks($oStart, $oEnd);
    }

}

?>