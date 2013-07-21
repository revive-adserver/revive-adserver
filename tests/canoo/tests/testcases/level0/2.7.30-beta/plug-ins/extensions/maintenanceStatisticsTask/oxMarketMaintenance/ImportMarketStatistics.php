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

/**
 * The MSE process task class that import statistics data from Publisher Console
 * during the MSE run.
 *
 * @package    OpenXPlugin
 * @subpackage oxMarket
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics extends OX_Maintenance_Statistics_Task
{
    const LAST_STATISTICS_VERSION_VARIABLE = 'last_statistics_version';

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::OX_Maintenance_Statistics_Task();
    }

    /**
     * The implementation of the OA_Task::run() method that
     * downloads statistics from publisher console
     */
    function run()
    {
        OA::debug('Started oxMarket_ImportMarketStatistics');
        try {
            $oPublisherConsoleApiClient =
                $this->getPublisherConsoleApiClient();
            $oPluginSettings = OA_Dal::factoryDO('ext_market_general_pref');
            $oPluginSettings->get('name', self::LAST_STATISTICS_VERSION_VARIABLE);
            if (isset($oPluginSettings->value)) {
                $last_update = intval($oPluginSettings->value);
            }
            else {
                $last_update = 0;
            }
            try {
                do {
                    $data = $oPublisherConsoleApiClient->oxmStatisticsLimited($last_update);
                    //var_dump($data);
                    $endOfData = $this->getStatisticFromString($data, $last_update, $oPluginSettings);
                } while ($endOfData === false);
            } catch (Exception $e) {
                if ($e->getCode() == 620) {
                    $data = $oPublisherConsoleApiClient->oxmStatistics($last_update);
                    $this->getStatisticFromString($data, $last_update, $oPluginSettings);
                } else {
                    throw $e;
                }
            }
        } catch (Exception $e) {
            OA::debug('Following exception occured: [' . $e->getCode() .'] '. $e->getMessage());
        }
        OA::debug('Finished oxMarket_ImportMarketStatistics');
    }

    /**
     * Insert data from oxmStatistics/oxmStatisticsLimited to database
     *
     * @param string $data
     * @param int $last_update
     * @return bool Is end of data from Pub Console (always true for oxmStatistics)
     */
    protected function getStatisticFromString($data, &$last_update)
    {
        if (!empty($data)) {
            try {
                $oDB = OA_DB::singleton();
                $supports_transactions = $oDB->supports('transactions');
                if ($supports_transactions) {
                    $oDB->beginTransaction();
                }

                $aLines = explode("\n", $data);
                $aFirstRow = explode("\t", $aLines[0]);
                $last_update = intval($aFirstRow[0]);
                $endOfData = true;
                if (array_key_exists(1,$aFirstRow)) {
                    $endOfData = (intval($aFirstRow[1])==1);
                }
                $count = count($aLines) - 1;

                for ($i = 1; $i < $count; $i++) {
                    $aRow = explode("\t", $aLines[$i]);
                    if (count($aRow) > 5) {
                        $oWebsiteStat = OA_Dal::factoryDO('ext_market_web_stats');
                        $oWebsiteStat->p_website_id = $aRow[0];
                        $oWebsiteStat->height = $aRow[1];
                        $oWebsiteStat->width = $aRow[2];
                        $oWebsiteStat->date_time = $aRow[3];
                        $oWebsiteStat->impressions = $aRow[4];
                        $oWebsiteStat->revenue = $aRow[5];
                        $oWebsiteStat->insert();
                    }
                    else {
                        throw new Exception('Invalid amount of statistics items returned: ' . $aLines[$i]);
                    }
                }
                // Update last statistics version serial number in same DB transaction
                $oPluginSettings = OA_Dal::factoryDO('ext_market_general_pref');
                $oPluginSettings->get('name', self::LAST_STATISTICS_VERSION_VARIABLE);
                $oPluginSettings->value = $last_update;
                if (0 < $oPluginSettings->getRowCount()) {
                    $oPluginSettings->update();
                }
                else {
                    $oPluginSettings->insert();
                }
                if ($supports_transactions) {
                    $oDB->commit();
                }
                return $endOfData;
            }
            catch (Exception $e) {
                if ($supports_transactions) {
                    $oDB->rollback();
                }
                OA::debug('Following exception occured ' . $e->getMessage());
                throw $e;
            }
        }
        return true;
    }

    /**
     * get Publisher Console Api Client from Market Plugin
     * used in tests to set client mockup
     *
     * @return Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient
     */
    protected function getPublisherConsoleApiClient()
    {
        $oMarketComponent = OX_Component::factory('admin', 'oxMarket');
        return $oMarketComponent->getPublisherConsoleApiClient();
    }
}

?>