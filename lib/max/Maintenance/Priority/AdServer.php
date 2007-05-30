<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/max/core/Task/Runner.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/AdServer/Task/ForecastZoneImpressions.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/AdServer/Task/GetRequiredAdImpressionsType1.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/AdServer/Task/GetRequiredAdImpressionsType2.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/AdServer/Task/AllocateZoneImpressions.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/AdServer/Task/PriorityCompensation.php';

/**
 * @package    MaxMaintenance
 * @subpackage Priority
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Maintenance_Priority_AdServer
{

    /**
     * The local instance of the task runner
     *
     * @var MAX_Core_Task_Runner
     */
    var $oTaskRunner;

    /**
     * The constructor method.
     */
    function MAX_Maintenance_Priority_AdServer()
    {
        // Create the task runner object, for running the MPE tasks
        $this->oTaskRunner = new MAX_Core_Task_Runner();
        // Add a task to update the zone impression forecasts
        $oForecastZoneImpressions = new ForecastZoneImpressions();
        $this->oTaskRunner->addTask($oForecastZoneImpressions);
        // Add tasks to get the required ad impressions
        $oGetRequiredAdImpressionsType1 = new GetRequiredAdImpressionsType1();
        $this->oTaskRunner->addTask($oGetRequiredAdImpressionsType1);
        $oGetRequiredAdImpressionsType2 = new GetRequiredAdImpressionsType2();
        $this->oTaskRunner->addTask($oGetRequiredAdImpressionsType2);
        // Add a task to allocate the ad impressions to zones
        $oAllocateZoneImpressions = new AllocateZoneImpressions();
        $this->oTaskRunner->addTask($oAllocateZoneImpressions);
        // Add a task to compensate & save the priority values
        $oPriorityCompensation = new PriorityCompensation();
        $this->oTaskRunner->addTask($oPriorityCompensation);
    }

    /**
     * The method to run the Maintenance Priority process.
     *
     * @return boolean True if the MPE ran correctly, false otherwise.
     */
    function updatePriorities()
    {
        // Run the required tasks
        $result = $this->oTaskRunner->runTasks();
        return $result;
    }

}

?>
