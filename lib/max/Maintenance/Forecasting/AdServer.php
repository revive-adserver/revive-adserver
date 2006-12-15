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
$Id$
*/

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/core/Task/Runner.php';
require_once MAX_PATH . '/lib/max/Maintenance/Forecasting/AdServer/Task/SetUpdateRequirements.php';
require_once MAX_PATH . '/lib/max/Maintenance/Forecasting/AdServer/Task/SummariseChannels.php';
require_once MAX_PATH . '/lib/max/Maintenance/Forecasting/AdServer/Task/ForecastChannels.php';
require_once MAX_PATH . '/lib/max/Maintenance/Forecasting/AdServer/Task/LogCompletion.php';

/**
 * A class for defining and running the maintenance forecasting tasks for the
 * 'AdServer' module.
 *
 * @package    MaxMaintenance
 * @subpackage Forecasting
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Maintenance_Forecasting_AdServer
{

    /**
     * The date/time that the forecasts were last updated.
     *
     * @var PEAR::Date
     */
    var $oLastUpdateDate;

    /**
     * Should the forecasts be updated?
     *
     * @var boolean
     */
    var $update;

    /**
     * The date/time to update the forecast values to, if appropriate.
     *
     * @var PEAR::Date
     */
    var $oUpdateToDate;

    /**
     * The local instance of the task runner
     *
     * @var MAX_Core_Task_Runner
     */
    var $oTaskRunner;

    /**
     * The constructor method.
     *
     * @TODO Needs to include a task that will forecast channel impressions,
     *       once written.
     */
    function MAX_Maintenance_Forecasting_AdServer()
    {
        // Create the task runner object, for running the MPE tasks
        $this->oTaskRunner = new MAX_Core_Task_Runner();
        // Register this object as the controlling class for the process
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->register('Maintenance_Forecasting_Controller', $this);
        // Add a task to set the update requirements
        $oSetUpdateRequirements = new MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements();
        $this->oTaskRunner->addTask($oSetUpdateRequirements);
        // Add a task to update the channel-based summary data
        $oSummariseChannels = new MAX_Maintenance_Forecasting_AdServer_Task_SummariseChannels();
        $this->oTaskRunner->addTask($oSummariseChannels);
        // Add a task to log the completion of the task
        $oLogCompletion = new MAX_Maintenance_Forecasting_AdServer_Task_LogCompletion();
        $this->oTaskRunner->addTask($oLogCompletion);
    }

    /**
     * The method to run the Maintenance Forecasting process.
     */
    function updateForecasts()
    {
        // Run the required tasks
        $this->oTaskRunner->runTasks();
    }

}

?>
