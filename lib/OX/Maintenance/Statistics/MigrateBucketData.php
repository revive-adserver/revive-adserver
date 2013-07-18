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

require_once LIB_PATH . '/Plugin/Component.php';
require_once LIB_PATH . '/Plugin/PluginManager.php';
require_once LIB_PATH . '/Dal/Maintenance/Statistics/Factory.php';
require_once LIB_PATH . '/OperationInterval.php';
require_once OX_PATH . '/lib/OA/Dal.php';
require_once OX_PATH . '/lib/OA/DB/Table.php';


/**
 * A class that implements the functions used by the migrateBucketData.php script.
 *
 * @package    OpenXMaintenance
 * @subpackage Tools
 * @author     David Keen <david.keen@openx.org>
 */
class OX_Maintenance_Statistics_MigrateBucketData
{
    /**
     * Connection to the database.
     *
     * @var MDB2_Driver_Common
     */
    public $oDbh;
    private $aPackages;

    function __construct()
    {
        // Get a connection to the datbase
        $this->oDbh =& OA_DB::singleton();

        // Locate all plugins (packages) that have been installed
        $oPluginManager = new OX_PluginManager();
        $this->aPackages = $oPluginManager->getPackagesList();
    }

    /**
     * Summarise the data from the bucket tables into the stats tables.
     *
     * @param <type> $oStartDate
     * @param <type> $oEndDate
     */
    public function summarise($oStartDate, $oEndDate)
    {
//        $oComponent =& OX_Component::factory('deliveryLog', 'oxLogCountry', 'logImpressionCountry');
//        $statisticsTableName = $GLOBALS['_MAX']['CONF']['table']['prefix'] .
//            $oComponent->getStatisticsName();
//        $aMigrationMaps = array(
//            $oComponent->getStatisticsMigration());

        $aRunComponents = $this->prepareMaps($this->locateComponents());

        // TODO: make it work for a range of dates
        $aDates = array(
            'start' => $oStartDate,
            'end' => $oEndDate
        );

       // Prepare the DAL object
        $oFactory = new OX_Dal_Maintenance_Statistics_Factory();
        $oDalMaintenanceStatistics = $oFactory->factory();

        $oNowDate = new Date();

        foreach ($aRunComponents as $statisticsTable => $aMaps) {
            $result = $oDalMaintenanceStatistics->summariseBucketsAggregate($statisticsTable, $aMaps, $aDates);
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
    private function locateComponents()
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
     * NOTE: Only handles aggregate bucket types.
     *
     * @access private
     * @param array $aSummariseComponents An array of components from the
     *                                    OX_Maintenance_Statistics_Task_MigrateBucketData::_locateComponents()
     *                                    method.
     * @return array An array of migration maps.
     */
    private function prepareMaps($aSummariseComponents)
    {
        $aRunComponents = array();

        foreach ($aSummariseComponents as $statisticsTable => $aComponents) {
            foreach ($aComponents as $oComponent) {
                $aMap = $oComponent->getStatisticsMigration();
                if (!$oComponent->testStatisticsMigration($aMap)) {
                    continue;
                }
                if ($aMap['method'] == 'aggregate') {
                    // Nice! We can migrate aggregate data
                    $aRunComponents[$statisticsTable][get_class($oComponent)] = $aMap;
                }
            }
        }
        return $aRunComponents;
    }


}