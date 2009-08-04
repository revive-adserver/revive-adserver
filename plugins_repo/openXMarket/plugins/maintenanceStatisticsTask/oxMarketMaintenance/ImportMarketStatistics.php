<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
     * Market plugin
     * @var Plugins_admin_oxMarket_oxMarket
     */
    protected $oMarketComponent;
    
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
            $oPublisherConsoleApiClient = $this->getPublisherConsoleApiClient();
            $oAccount = OA_Dal::factoryDO('ext_market_assoc_data');
            $oAccount->find();
            while ($oAccount->fetch()) {
                $accountId = (int)$oAccount->account_id;
                $oPublisherConsoleApiClient->setWorkAsAccountId($accountId);                
                //is plugin active is checked per account
                if ($this->isPluginActive()) { 
                    $last_update = $this->getLastUpdateVersionNumber($accountId);
                    $aWebsitesIds = $this->getRegisteredWebsitesIds($accountId);
                    if (is_array($aWebsitesIds) && count($aWebsitesIds)>0) {
                        // Download statistics only if there are registered websites
                        do {
                            $data = $oPublisherConsoleApiClient->getStatistics($last_update, $aWebsitesIds);
                            $endOfData = $this->getStatisticFromString($data, $last_update, $accountId);
                        } while ($endOfData === false);
                    }
                }
            }
        } catch (Exception $e) {
            OA::debug('Following exception occured: [' . $e->getCode() .'] '. $e->getMessage());
        }
        // always clear workAsAccountId
        if (isset($oPublisherConsoleApiClient)) {
            $oPublisherConsoleApiClient->setWorkAsAccountId(null);
        }
        OA::debug('Finished oxMarket_ImportMarketStatistics');
    }

    
    /**
     * Get LastUpdate version number for given account
     *
     * @param int $accountId
     * @return string
     */
    function getLastUpdateVersionNumber($accountId)
    {
        $value = OA_Dal::factoryDO('ext_market_general_pref')
                 ->findAndGetValue($accountId, self::LAST_STATISTICS_VERSION_VARIABLE);
        return (isset($value)) ? $value : '0';
    }
    
    /**
     * Get array of website_id stored in database 
     * associated with given account
     *
     * @param int $accountId
     * @return array of strings (website Ids)
     */
    function getRegisteredWebsitesIds($accountId)
    {
        $oWebsites = OA_Dal::factoryDO('ext_market_website_pref');
        return $oWebsites->getRegisteredWebsitesIds($accountId);
    }
    
    /**
     * Insert data from getStatistics to database 
     *
     * @param string $data
     * @param int $last_update
     * @param int $accountId
     * @return bool Is end of data from Pub Console (always true for oxmStatistics)
     */
    protected function getStatisticFromString($data, &$last_update, $accountId)
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
                $last_update = $aFirstRow[0];
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
                $result = $oPluginSettings->insertOrUpdateValue($accountId, 
                            self::LAST_STATISTICS_VERSION_VARIABLE, $last_update);
                if ($result===false) {
                    throw new Exception('Cannot save last statistics version variable for account: '.$accountId);
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
        $this->initMarketComponent();
        return $this->oMarketComponent->getPublisherConsoleApiClient();
    }
    
    /**
     * Check if plugin is active (registered to the market)
     *
     * @return boolean
     */
    protected function isPluginActive()
    {
        $this->initMarketComponent();
        return $this->oMarketComponent->isActive();
    }
    
    /**
     * Initialize market component if needed
     */
    protected function initMarketComponent()
    {
        if (!isset($this->oMarketComponent)) {
            $this->oMarketComponent = OX_Component::factory('admin', 'oxMarket');
        }
    }
}

?>