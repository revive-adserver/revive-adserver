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
require_once LIB_PATH . '/Plugin/Component.php';

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
    
    const LAST_IMPORT_STATS_DATE = 'last_import_stats_date';

    /**
     * Market plugin
     * @var Plugins_admin_oxMarket_oxMarket
     */
    protected $oMarketComponent;
    
    /**
     * Was script initiated from separate (dedicated) maintenance script?
     * @var bool
     */
    private $calledFromSeparateMaintenace;
    
    
    /**
     * Array of active accounts returned by getActiveAccounts method
     * @var array
     */
    protected $aActiveAccounts;
    
    /**
     * The constructor method.
     *
     * @param unknown_type $calledFromSeparateMaintenace
     */
    function __construct($calledFromSeparateMaintenace = false)
    {
        $this->calledFromSeparateMaintenace = $calledFromSeparateMaintenace;
        parent::OX_Maintenance_Statistics_Task();
    }

    /**
     * The implementation of the OA_Task::run() method that 
     * downloads statistics from publisher console
     */
    function run()
    {
        // check if it's allowed to run this task in given maintenance (common, or separate script)
        if (!$this->canRunTask()) {
            return false;
        }
        OA::debug('Started oxMarket_ImportMarketStatistics');
        try {
            $oPublisherConsoleApiClient = $this->getPublisherConsoleApiClient();
            // select only registered and active accounts (skip isPluginActive() method)
            $oAccount = OA_Dal::factoryDO('ext_market_assoc_data');
            $oAccount->status = 0;  
            $oAccount->whereAdd('api_key IS NOT NULL');
            $oAccount->find();
            while ($oAccount->fetch()) {
                try {
                    $accountId = (int)$oAccount->account_id;
                    $oPublisherConsoleApiClient->setWorkAsAccountId($accountId);                
                    $last_update = $this->getLastUpdateVersionNumber($accountId);
                    $aWebsitesIds = $this->getRegisteredWebsitesIds($accountId);
                    if (is_array($aWebsitesIds) && count($aWebsitesIds)>0
                        && !$this->shouldSkipAccount($accountId)) {
                        // Download statistics only if there are registered websites
                        // and account is locally active  
                        do {
                            $data = $oPublisherConsoleApiClient->getStatistics($last_update, $aWebsitesIds);
                            $endOfData = $this->getStatisticFromString($data, $last_update, $accountId);
                        } while ($endOfData === false);
                        $this->setLastUpdateDate($accountId);
                    }
                } catch (Exception $e) {
                    OA::debug('Following exception occured for account ['. $oAccount->account_id .']: [' 
                              . $e->getCode() .'] '. $e->getMessage());
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
        return true;
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
    
    /**
     * Check if it is allowed to run task in maintenance or separate script
     *
     * @return bool true if it's allowed
     */
    public function canRunTask()
    {
        return ($this->calledFromSeparateMaintenace ==
                (bool)$GLOBALS['_MAX']['CONF']['oxMarket']['separateImportStatsScript']);
    }
    
    
    /**
     * Check if given account could be ommited during statistics update (
     *
     * @param int $accountId
     * @return bool true if account doesn't have local stats and can be skipped
     */
    protected function shouldSkipAccount($accountId)
    {
        $this->initMarketComponent();
        // check if this is multiple account mode and skipping account is allowed
        // are statistics collected
        if($this->oMarketComponent->isMultipleAccountsMode() && 
           $this->oMarketComponent->getConfigValue('allowSkipAccountsInImportStats') == '1') {
            $aActiveAccounts = $this->getActiveAccounts();
            // check if account is inactive
            if (!isset($aActiveAccounts[$accountId])) {
                // get date of last stats update for this account 
                $value = OA_Dal::factoryDO('ext_market_general_pref')
                 ->findAndGetValue($accountId, self::LAST_IMPORT_STATS_DATE);
                if (isset($value)) {
                    $oCurrDate = new Date();
                    $oUserDate = new Date($value);
                    $span = new Date_Span();
                    $span->setFromDateDiff($oCurrDate, $oUserDate);
                    // if last update was in past x days, skip this account
                    $skipDays = $this->oMarketComponent->getConfigValue('maxSkippingPeriodInDays');
                    if ($span->toDays()<$skipDays) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
    
    
    /**
     * Get array of active accounts
     * Active account has any local stats in last 7 days period
     *
     * @return array array of active accounts
     */
    protected function getActiveAccounts()
    {
        /**
         * TODO: orginal query based on data_summary_ad_hourly is very slow
         * should be refactored to use last login date - something like that:
         * 
         *  select max(`date_last_login`) from ox_users u 
         *  inner join ox_account_user_assoc aua on aua.user_id = u.user_id
         *  inner join ox_accounts ac on aua.account_id = ac.account_id
         *  where ac.account_type = 'MANAGER'
         *  group by ac.account_id
         *
         * Or use active column in agency (how and when is it set/unset?)
         */
        
        if (!isset($this->aActiveAccounts)) {
            $oSumAdHourly = OA_Dal::factoryDO('data_summary_ad_hourly');
            $oBanners = OA_Dal::factoryDO('banners');
            $oCampaigns = OA_Dal::factoryDO('campaigns');
            $oClients = OA_Dal::factoryDO('clients');
            $oAgency = OA_Dal::factoryDO('agency');
            $oClients->joinAdd($oAgency);
            $oCampaigns->joinAdd($oClients);
            $oBanners->joinAdd($oCampaigns);
            $oSumAdHourly->joinAdd($oBanners);
            // check activity one week before now
            $oDate = new Date();
            $oDateSpan = new Date_Span();
            $oDateSpan->setFromDays(7); 
            $oDate->subtractSpan($oDateSpan); 
            $oDbh = OA_DB::singleton();
            $oSumAdHourly->whereAdd('date_time > '.
                $oDbh->quote($oDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp'));
            $oSumAdHourly->selectAdd();
            $oSumAdHourly->selectAdd($oAgency->tableName().'.account_id');
            $oSumAdHourly->groupBy($oAgency->tableName().'.account_id');
            $oSumAdHourly->find();
            $this->aActiveAccounts = array();
            while($oSumAdHourly->fetch()) {
                $this->aActiveAccounts[$oSumAdHourly->account_id] = $oSumAdHourly->account_id;
            }
        }
        return $this->aActiveAccounts;
    }
    
    
    /**
     * Set last import statistics update date to now
     *
     * @param int $accountId
     */
    protected function setLastUpdateDate($accountId)
    {
        $oCurrDate = new Date();
        $oPluginSettings = OA_Dal::factoryDO('ext_market_general_pref');
        $oPluginSettings->insertOrUpdateValue($accountId, 
                            self::LAST_IMPORT_STATS_DATE, $oCurrDate->getDate());
    }
}
?>