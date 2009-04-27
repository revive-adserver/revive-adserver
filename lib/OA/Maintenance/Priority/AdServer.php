<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/AllocateZoneImpressions.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/ForecastZoneImpressions.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/GetRequiredAdImpressionsDaily.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/GetRequiredAdImpressionsLifetime.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/PriorityCompensation.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/ECPMforRemnant.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/ECPMforContract.php';
require_once MAX_PATH . '/lib/OA/Task/Runner.php';

/**
 * @package    OpenXMaintenance
 * @subpackage Priority
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Priority_AdServer
{

    /**
     * The local instance of the task runner
     *
     * @var OA_Task_Runner
     */
    var $oTaskRunner;

    /**
     * The constructor method.
     */
    function OA_Maintenance_Priority_AdServer()
    {
        // Create the task runner object, for running the MPE tasks
        $this->oTaskRunner = new OA_Task_Runner();
        // Add a task to update the zone impression forecasts
        $oForecastZoneImpressions = new OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
        $this->oTaskRunner->addTask($oForecastZoneImpressions);
        // Add tasks to get the required ad impressions
        $oGetRequiredAdImpressionsLifetime = new OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsLifetime();
        $this->oTaskRunner->addTask($oGetRequiredAdImpressionsLifetime);
        $oGetRequiredAdImpressionsDaily = new OA_Maintenance_Priority_AdServer_Task_GetRequiredAdImpressionsDaily();
        $this->oTaskRunner->addTask($oGetRequiredAdImpressionsDaily);
        // Add a task to allocate the ad impressions to zones
        $oAllocateZoneImpressions = new OA_Maintenance_Priority_AdServer_Task_AllocateZoneImpressions();
        $this->oTaskRunner->addTask($oAllocateZoneImpressions);
        // Add a task to compensate & save the priority values
        $oPriorityCompensation = new OA_Maintenance_Priority_AdServer_Task_PriorityCompensation();
        $this->oTaskRunner->addTask($oPriorityCompensation);
        // Add a task to update priority values for eCPM Contract campaigns
        $oPriorityEcpmContract = new OA_Maintenance_Priority_AdServer_Task_ECPMforContract();
        $this->oTaskRunner->addTask($oPriorityEcpmContract);
        // Add a task to update priority values for eCPM Remnant campaigns
        $oPriorityEcpmRemnant = new OA_Maintenance_Priority_AdServer_Task_ECPMforRemnant();
        $this->oTaskRunner->addTask($oPriorityEcpmRemnant);

        // addMaintenancePriorityTask hook
        $aPlugins = OX_Component::getListOfRegisteredComponentsForHook('addMaintenancePriorityTask');
        foreach ($aPlugins as $i => $id) {
            if ($obj = OX_Component::factoryByComponentIdentifier($id)) {
                $this->oTaskRunner->addTask($obj->addMaintenancePriorityTask(), $obj->getClassName(), $obj->replace());
            }
        }
    }

    /**
     * The method to run the Maintenance Priority process.
     *
     * @return boolean True if the MPE ran correctly, false otherwise.
     */
    function updatePriorities()
    {
        // Run the required tasks
        // TODO: OA_Task::run should really return a boolean we could check here.
        $this->oTaskRunner->runTasks();
    }

}

?>
