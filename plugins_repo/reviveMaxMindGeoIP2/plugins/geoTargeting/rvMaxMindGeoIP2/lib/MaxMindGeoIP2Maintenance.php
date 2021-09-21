<?php

namespace RV_Plugins\geoTargeting\rvMaxMindGeoIP2\lib;

require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once LIB_PATH . '/Maintenance.php';
require_once LIB_PATH . '/Maintenance/Statistics/Task.php';

class MaxMindGeoIP2Maintenance extends \OX_Maintenance_Statistics_Task
{
    public function run()
    {
        $oServiceLocator = \OA_ServiceLocator::instance();

        /** @var \OX_Maintenance $oMaint */
        $oMaint = $oServiceLocator->get('Maintenance_Controller');
        if (!$oMaint->isMidnightMaintenance()) {
            \OA::debug("- Waiting for next midnight maintenance");
            return true;
        }

        try {
            $downloader = new MaxMindGeoLite2Downloader();

            if ($downloader->updateGeoLiteDatabase()) {
                \OA::debug("- Downloaded latest GeoLite2 database");
            } else {
                \OA::debug("- Latest GeoLite2 database already installed");
            }
        } catch (\Exception $e) {
            \OA::debug("- An error occurred: {$e->getMessage()}", PEAR_LOG_WARNING);
        }

        return true;
    }
}
