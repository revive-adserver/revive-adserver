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
 * The MSE process task class that update websites data on OpenX Market
 *
 * @package    OpenXPlugin
 * @subpackage oxMarket
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_UpdateWebsites extends OX_Maintenance_Statistics_Task
{

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::OX_Maintenance_Statistics_Task();
    }

    /**
     * The implementation of the OA_Task::run() method that
     * - check new account status
     * - run update websites
     */
    function run()
    {
        OA::debug('Started oxMarket_UpdateWebsites');
        try {
            $oMarketComponent = $this->getMarketPlugin();
            $oAccount = OA_Dal::factoryDO('ext_market_assoc_data');
            $oAccount->find();
            while ($oAccount->fetch()) {
                $oMarketComponent->setWorkAsAccountId((int)$oAccount->account_id);
                if ($oMarketComponent->isRegistered()) {
                    try {
                        $oMarketComponent->updateAccountStatus(); // updateAccountStatus first
                    } catch (Exception $e) {
                        // Catch exception from updateAccountStatus separately to updateAllWebsites
                        OA::debug('Following exception occured: [' . $e->getCode() .'] '. $e->getMessage());
                    }
                    if ($oMarketComponent->isActive()) {
                        $oMarketComponent->updateAllWebsites(true); //updateAllWebsites skip synchronized
                    }
                }
            }
        } catch (Exception $e) {
            OA::debug('Following exception occured: [' . $e->getCode() .'] '. $e->getMessage());
        }
        if (isset($oMarketComponent)) {
            $oMarketComponent->setWorkAsAccountId(null);
        }
        OA::debug('Finished oxMarket_UpdateWebsites');
    }

    protected function getMarketPlugin()
    {
        return OX_Component::factory('admin', 'oxMarket');
    }
}

?>