<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: LogCompletion.php 5631 2006-10-09 18:21:43Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Dal/Maintenance/Forecasting.php';
require_once MAX_PATH . '/lib/max/Maintenance/Forecasting/AdServer/Task.php';

/**
 * A class for logging the completion of the maintenance forecasting process
 * for the AdServer module.
 *
 * @package    MaxMaintenance
 * @subpackage Forecasting
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Maintenance_Forecasting_AdServer_Task_LogCompletion extends MAX_Maintenance_Forecasting_AdServer_Task
{

    /**
     * The constructor method.
     *
     * @return MAX_Maintenance_Forecasting_AdServer_Task_LogCompletion
     */
    function MAX_Maintenance_Forecasting_AdServer_Task_LogCompletion()
    {
        parent::MAX_Maintenance_Forecasting_AdServer_Task();
    }

    /**
     * The implementation of the MAX_Core_Task::run() method that performs
     * the task of this class.
     *
     * @param PEAR::Date $oEndDate Optional date/time representing the end of the tasks.
     */
    function run($oEndDate = null)
    {
        $oServiceLocator = &ServiceLocator::instance();
        $oNowDate = &$oServiceLocator->get('now');
        if (is_null($oEndDate)) {
            $oEndDate = new Date();
        }
        // Get instance of MAX_Dal_Maintenance_Forecasting
        $oDal = new MAX_Dal_Maintenance_Forecasting();
        if (($this->oController->update)) {
            $this->oDal->setMaintenanceForecastingLastRunInfo(
                $oNowDate,
                $oEndDate,
                $this->oController->oUpdateToDate
            );
        } else {
            MAX::debug(
                'Call to MAX_Maintenance_Forecasting_Task_LogCompletion::run() failed.',
                PEAR_LOG_DEBUG
            );
            return false;
        }
        return true;
    }

}

?>
