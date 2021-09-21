<?php

require_once LIB_PATH . '/Extension/maintenanceStatisticsTask/MaintenanceStatisticsTask.php';

require_once __DIR__ . '/../../geoTargeting/rvMaxMindGeoIP2/lib/MaxMindGeoIP2.php';
require_once __DIR__ . '/../../geoTargeting/rvMaxMindGeoIP2/lib/MaxMindGeoIP2Maintenance.php';

use RV_Plugins\geoTargeting\rvMaxMindGeoIP2\lib\MaxMindGeoIP2;
use RV_Plugins\geoTargeting\rvMaxMindGeoIP2\lib\MaxMindGeoIP2Maintenance;

class Plugins_MaintenanceStatisticsTask_rvMaxMindGeoIP2Maintenance_rvMaxMindGeoIP2Maintenance extends Plugins_MaintenanceStatisticsTask
{
    public function addMaintenanceStatisticsTask()
    {
        if (MaxMindGeoIP2::hasCustomConfig()) {
            \OA::debug("MaxMind GeoIP2 custom configuration detected, skipping auto-update", PEAR_LOG_INFO);

            return null;
        }

        if (!MaxMindGeoIP2::getLicenseKey()) {
            \OA::debug("MaxMind GeoIP2 license key missing, skipping auto-update", PEAR_LOG_INFO);

            return null;
        }

        return new MaxMindGeoIP2Maintenance();
    }
}
