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
$Id: UpdateWebsites.php 40924 2009-08-04 12:30:06Z lukasz.wikierski $
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