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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/AllocateZoneImpressions.php';
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

    /** @var array array of addMaintenancePriorityTask components. */
    private $aComponents;

    /**
     * The constructor method.
     */
    function OA_Maintenance_Priority_AdServer()
    {
        $this->aComponents = OX_Component::getListOfRegisteredComponentsForHook('addMaintenancePriorityTask');

        // addMaintenancePriorityTask hook
        if (!empty($this->aComponents) && is_array($this->aComponents)) {
            foreach ($this->aComponents as $componentId) {
                if ($obj = OX_Component::factoryByComponentIdentifier($componentId)) {
                    $obj->beforeMpe();
                }
            }
        }

        // Create the task runner object, for running the MPE tasks
        $this->oTaskRunner = new OA_Task_Runner();
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
        if (!empty($this->aComponents) && is_array($this->aComponents)) {
            foreach ($this->aComponents as $componentId) {
                if ($obj = OX_Component::factoryByComponentIdentifier($componentId)) {
                    $this->oTaskRunner->addTask($obj->addMaintenancePriorityTask(), $obj->getExistingClassName(), $obj->getOrder());
                }
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

        // addMaintenancePriorityTask hook
        if (!empty($this->aComponents) && is_array($this->aComponents)) {
            foreach ($this->aComponents as $componentId) {
                if ($obj = OX_Component::factoryByComponentIdentifier($componentId)) {
                    $obj->afterMpe();
                }
            }
        }
    }

}

?>
