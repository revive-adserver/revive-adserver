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

require_once LIB_PATH . '/Extension/maintenanceStatisticsTask/MaintenanceStatisticsTask.php';
require_once 'ImportMarketStatistics.php';

/**
 * Class implementing addMaintenanceStatisticsTask hook for oxMarket statistics
 *
 * @package    OpenXPlugin
 * @subpackage oxMarket
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_MaintenanceStatisticsTask_oxMarketMaintenance_oxMarketMaintenance extends Plugins_MaintenanceStatisticsTask
{
    /**
     * Method returns OX_Maintenance_Statistics_Task
     * to run in the Maintenance Statistics Engine
     * Implements hook 'addMaintenanceStatisticsTask'
     *
     * @return OX_Maintenance_Statistics_Task
     */
    function addMaintenanceStatisticsTask()
    {
        return new Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics();
    }
}
?>