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
            $oDB = OA_DB::singleton();
            $supports_transactions = $oDB->supports('transactions');
            $oMarketComponent = OX_Component::factory('admin', 'oxMarket');
            $oPublisherConsoleApiClient =
                $oMarketComponent->getPublisherConsoleApiClient();
            $oPluginSettings = OA_Dal::factoryDO('ext_market_general_pref');
            $oPluginSettings->get('name', self::LAST_STATISTICS_VERSION_VARIABLE);
            if (isset($oPluginSettings->value)) {
                $last_update = intval($oPluginSettings->value);
            }
            else {
                $last_update = 0;
            }
            $data = $oPublisherConsoleApiClient->oxmStatistics($last_update);
        } catch (Exception $e) {
            OA::debug('Following exception occured: [' . $e->getCode() .'] '. $e->getMessage());
        }
        if (!empty($data)) {
            if ($supports_transactions) {
                $oDB->beginTransaction();
            }
            try {
                $aLines = explode("\n", $data);
                $last_update = intval($aLines[0]);
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
                        OA::debug('Invalid amount of statistics items returned: ' .
                             $aLines[$i]);
                    }
                }
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
            }
            catch (Exception $e) {
                if ($supports_transactions) {
                    $oDB->rollback();
                }
                OA::debug('Following exception occured ' . $e->getMessage());
            }
        }
        OA::debug('Finished oxMarket_ImportMarketStatistics');
    }

}

?>