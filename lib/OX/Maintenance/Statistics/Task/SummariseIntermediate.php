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

require_once LIB_PATH . '/Maintenance/Statistics/Task.php';

/**
 * The MSE process task class that migrates any logged delivery data
 * from the plugin bucket tables (of either aggregate or raw type) into
 * the OpenX 2.6-style data_intermediate_% tables during the MSE run.
 *
 * @package    OpenXMaintenance
 * @subpackage Statistics
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OX_Maintenance_Statistics_Task_MigrateBucketData extends OX_Maintenance_Statistics_Task
{

    /**
     * The constructor method.
     *
     * @return OX_Maintenance_Statistics_Task_MigrateBucketData
     */
    function OX_Maintenance_Statistics_Task_MigrateBucketData()
    {
        parent::OX_Maintenance_Statistics_Task();
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

            // Prepare an array of possible start and end dates for the migration
            $aRunDates = array();
            $oStartDate = new Date();
            $oStartDate->copy($this->oController->oLastDateIntermediate);
            $oStartDate->addSeconds(1);
            while (Date::compare($oStartDate, $this->oController->oUpdateIntermediateToDate) < 0) {
                // Calcuate the end of the operation interval
                $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oStartDate);
                $oEndDate = new Date();
                $oEndDate->copy($aDates['end']);
                // Store the dates
                $oStoreStartDate = new Date();
                $oStoreStartDate->copy($oStartDate);
                $oStoreEndDate = new Date();
                $oStoreEndDate->copy($oEndDate);
                $aRunDates[] = array(
                    'start' => $oStoreStartDate,
                    'end'   => $oStoreEndDate
                );
                // Go to the next operation interval
                $oStartDate->copy($oEndDate);
                $oStartDate->addSeconds(1);
            }

            // Prepare arrays of all of the migration maps of raw migrations
            $aRunComponents = $this->_prepareMaps($aSummariseComponents, 'raw');
            // Run each migration map separately, even if it's for the same table
            foreach ($aRunComponents as $statisticsTable => $aMaps) {
                foreach ($aMaps as $componentClassName => $aMigrationDetails) {
                    foreach ($aRunDates as $aDates) {
                        $message = "- Migrating raw bucket data from the '{$aMigrationDetails['bucketTable']}' bucket table";
                        OA::debug($message, PEAR_LOG_DEBUG);
                        $message = "  to the '$statisticsTable' table, for operation interval range";
                        OA::debug($message, PEAR_LOG_DEBUG);
                        $message = '  ' . $aDates['start']->format('%Y-%m%d %H:%M:%S') . ' ' . $aDates['start']->tz->getShortName() .
                                   ' to ' . $aDates['end']->format('%Y-%m%d %H:%M:%S') . ' ' . $aDates['end']->tz->getShortName();
                        OA::debug($message, PEAR_LOG_DEBUG);
                        $result = $oDal->summariseBucketsRaw($statisticsTable, $aMigrationDetails, $aDates);
                        if (PEAR::isError($result)) {
                            // Oh noz! The bucket data could not be migrated
                            // Tell the user all about it, but then just keep on truckin'...
                            $message = "   ERROR: Could not migrate raw bucket data from the '{$aMigrationDetails['bucketTable']}' bucket table.";
                            OA::debug($message, PEAR_LOG_ERR);
                            $message = "   Error message was: {$result->message}.";
                            OA::debug($message, PEAR_LOG_ERR);
                        } else {
                            $aSummariseComponents[$statisticsTable][$componentClassName]->pruneBucket($aDates['end'], $aDates['start']);
                        }
                    }
                }
            }

            // Prepare arrays of all of the migration maps of supplementary raw migrations
            $aRunComponents = $this->_prepareMaps($aSummariseComponents, 'rawSupplementary');
            // Run each migration map separately, even if it's for the same table
            foreach ($aRunComponents as $statisticsTable => $aMaps) {
                foreach ($aMaps as $componentClassName => $aMigrationDetails) {
                    foreach ($aRunDates as $aDates) {
                        $message = "- Migrating supplementary raw bucket data from the '{$aMigrationDetails['bucketTable']}' bucket table";
                        OA::debug($message, PEAR_LOG_DEBUG);
                        $message = "  to the '$statisticsTable' table, for operation interval range";
                        OA::debug($message, PEAR_LOG_DEBUG);
                        $message = '  ' . $aDates['start']->format('%Y-%m%d %H:%M:%S') . ' ' . $aDates['start']->tz->getShortName() .
                                   ' to ' . $aDates['end']->format('%Y-%m%d %H:%M:%S') . ' ' . $aDates['end']->tz->getShortName();
                        OA::debug($message, PEAR_LOG_DEBUG);
                        $result = $oDal->summariseBucketsRawSupplementary($statisticsTable, $aMigrationDetails, $aDates);
                        if (PEAR::isError($result)) {
                            // Oh noz! The bucket data could not be migrated
                            // Tell the user all about it, but then just keep on truckin'...
                            $message = "   ERROR: Could not migrate supplementary raw bucket data from the '{$aMigrationDetails['bucketTable']}' bucket table.";
                            OA::debug($message, PEAR_LOG_ERR);
                            $message = "   Error message was: {$result->message}.";
                            OA::debug($message, PEAR_LOG_ERR);
                        } else {
                            $aSummariseComponents[$statisticsTable][$componentClassName]->pruneBucket($aDates['end'], $aDates['start']);
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
                foreach ($aRunDates as $aDates) {
                    $aExtras = array();
                    // Is this the data_intermeidate_ad statistics table? It's special!
                    if ($statisticsTable == $aConf['table']['prefix'] . 'data_intermediate_ad') {
                        $aExtras = array(
                            'operation_interval'    => $aConf['maintenance']['operationInterval'],
                            'operation_interval_id' => OA_OperationInterval::convertDateToOperationIntervalID($aDates['start']),
                            'interval_start'        => $oDal->oDbh->quote($aDates['start']->format('%Y-%m-%d %H:%M:%S'), 'timestamp'),
                            'interval_end'          => $oDal->oDbh->quote($aDates['end']->format('%Y-%m-%d %H:%M:%S'), 'timestamp'),
                            'creative_id'           => 0,
                            'updated'               => $oDal->oDbh->quote($oNowDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp'),
                        );
                    }
                    $message = "- Migrating aggregate bucket data from the '" . implode("', '", $aBucketTables) . "' bucket table(s)";
                    OA::debug($message, PEAR_LOG_DEBUG);
                    $message = "  to the '$statisticsTable' table, for operation interval range";
                    OA::debug($message, PEAR_LOG_DEBUG);
                    $message = '  ' . $aDates['start']->format('%Y-%m%d %H:%M:%S') . ' ' . $aDates['start']->tz->getShortName() .
                               ' to ' . $aDates['end']->format('%Y-%m%d %H:%M:%S') . ' ' . $aDates['end']->tz->getShortName();
                    OA::debug($message, PEAR_LOG_DEBUG);
                    $result = $oDal->summariseBucketsAggregate($statisticsTable, $aMaps, $aDates, $aExtras);
                    if (PEAR::isError($result)) {
                        // Oh noz! The bucket data could not be migrated
                        // Tell the user all about it, but then just keep on truckin'...
                        $message = "   ERROR: Could not migrate aggregate bucket data from the '" . implode("', '", $aBucketTables) . "' bucket table(s)";
                        OA::debug($message, PEAR_LOG_ERR);
                        $message = "   Error message was: {$result->message}.";
                        OA::debug($message, PEAR_LOG_ERR);
                    } else {
                        foreach ($aMaps as $componentClassName => $aMap) {
                            $aSummariseComponents[$statisticsTable][$componentClassName]->pruneBucket($aDates['end'], $aDates['start']);
                        }
                    }
                }
            }
        }
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
        $oPluginManager = new OX_PluginManager();
        $aPlugins = $oPluginManager->getPackagesList();
        foreach ($aPlugins as $aPluginInfo) {
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
     * @param array $aSummariseComponents An array of components from the
     *                                    OX_Maintenance_Statistics_Task_MigrateBucketData::_locateComponents()
     *                                    method.
     * @param string $type The type of map required - one of "raw",
     *                     "rawSupplementary" or "aggregate".
     * @return array An array of migration maps.
     */
    function _prepareMaps($aSummariseComponents, $type)
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
        }
        return $aRunComponents;
    }
}

?>