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

require_once __DIR__ . '/rvMaxMindGeoIP2.delivery.php';
require_once __DIR__ . '/lib/MaxMindGeoLite2Downloader.php';

use RV_Plugins\geoTargeting\rvMaxMindGeoIP2\lib\MaxMindGeoIP2;
use RV_Plugins\geoTargeting\rvMaxMindGeoIP2\lib\MaxMindGeoLite2Downloader;

/**
 * Class to get GeoTargeting information from MaxMind GeoIP2 or GeoLite2 databases.
 *
 * @package    OpenXPlugin
 * @subpackage GeoTargeting
 */
class Plugins_GeoTargeting_rvMaxMindGeoIP2_RvMaxMindGeoIP2 extends OX_Component implements \RV\Extension\GeoTargetingComponentInterface
{
    /**
     * Return plugin name
     *
     * @return string A string describing the class.
     */
    public function getName()
    {
        return "MaxMind GeoIP2";
    }

    /**
     * {@inheritdoc}
     */
    public function getCapabilities()
    {
        return MaxMindGeoIP2::getCapabilities();
    }

    public function onEnable()
    {
        if (MaxMindGeoIP2::hasCustomConfig()) {
            return true;
        }

        try {
            $downloader = new MaxMindGeoLite2Downloader();
            $downloader->updateGeoLiteDatabase();
        } catch (\Exception $e) {
            OA::debug("An error occurred trying to download the latest GeoIP2 database: {$e->getMessage()}", PEAR_LOG_WARNING);
        }

        return true;
    }
}
