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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/OA/Task/Runner.php';

require_once LIB_PATH . '/Dal/Maintenance/Statistics/Factory.php';
require_once LIB_PATH . '/Maintenance/Statistics/Task/SetUpdateRequirements.php';
require_once LIB_PATH . '/Maintenance/Statistics/Task/SummariseIntermediate.php';
require_once LIB_PATH . '/Maintenance/Statistics/Task/DeduplicateConversions.php';
require_once LIB_PATH . '/Maintenance/Statistics/Task/ManageConversions.php';
require_once LIB_PATH . '/Maintenance/Statistics/Task/SummariseFinal.php';
require_once LIB_PATH . '/Maintenance/Statistics/Task/ManageCampaigns.php';
require_once LIB_PATH . '/Maintenance/Statistics/Task/LogCompletion.php';

require_once LIB_PATH . '/Plugin/Component.php';

/**
 * A class for preparing the tasks that need to be run as part of the
 * Maintenance Statistics Engine process.
 *
 * @static
 * @package    OpenXMaintenance
 * @subpackage Statistics
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OX_Maintenance_Statistics
{

    /**
     * Text report of the details logged by the run tasks.
     *
     * @var string
     */
    var $report;

    /**
     * The date/time that the intermediate tables were last updated.
     *
     * @var PEAR::Date
     */
    var $oLastDateIntermediate;

    /**
     * Should the intermediate tables be updated?
     *
     * @var boolean
     */
    var $updateIntermediate;

    /**
     * Did the operation interval remain the same since the last run?
     * Set to false when the OI changes, and a non-standard OI calculation
     * needs to be performed.
     *
     * @var boolean
     */
    var $sameOI = true;

    /**
     * The date/time to update the intermediate tables to, if appropriate.
     *
     * @var PEAR::Date
     */
    var $oUpdateIntermediateToDate;

    /**
     * The date/time that the final tables were last updated.
     *
     * @var PEAR::Date
     */
    var $oLastDateFinal;

    /**
     * Should the final tables be updated?
     *
     * @var boolean
     */
    var $updateFinal;

    /**
     * The date/time to update the intermediate tables to, if appropriate.
     *
     * @var PEAR::Date
     */
    var $oUpdateFinalToDate;

    /**
     * An OA_Task_Runner instance to store the MSE tasks.
     *
     * @var OA_Task_Runner
     */
    var $oTaskRunner;

    /** @var array array of addMaintenanceStatisticsTask components. */
    private $aComponents;

    /**
     * The method to run the Maintenance Statistics Engine process.
     *
     * @static
     */
    function run()
    {
        OA::switchLogIdent('maintenance');

        // Get the configuration
        $aConf = $GLOBALS['_MAX']['CONF'];

        // Log the start of the process
        OA::debug('Running Maintenance Statistics Engine', PEAR_LOG_INFO);

        // Set longer time out, and ignore user abort
        if (!ini_get('safe_mode')) {
            @set_time_limit($aConf['maintenance']['timeLimitScripts']);
            @ignore_user_abort(true);
        }

        // Run the following code as the "Maintenance" user
        OA_Permission::switchToSystemProcessUser('Maintenance');

        // Ensure the the current time is registered with the OA_ServiceLocator
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDate = &$oServiceLocator->get('now');
        if (!$oDate) {
            // Record the current time, and register with the OA_ServiceLocator
            $oDate = new Date();
            $oServiceLocator->register('now', $oDate);
        }

        $this->aComponents = OX_Component::getListOfRegisteredComponentsForHook('addMaintenanceStatisticsTask');

        // addMaintenanceStatisticsTask hook
        if (!empty($this->aComponents) && is_array($this->aComponents)) {
            foreach ($this->aComponents as $componentId) {
                if ($obj = OX_Component::factoryByComponentIdentifier($componentId)) {
                    $obj->beforeMse();
                }
            }
        }

        // Initialise the task runner object, for storing/running the tasks
        $this->oTaskRunner = new OA_Task_Runner();

        // Register this object as the controlling class for the process,
        // so that tasks run by the task runner can locate this class to
        // update the report, etc.
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $this);

        // Create and register an instance of the OA_Dal_Maintenance_Statistics DAL
        // class for the following tasks to use
        if (!$oServiceLocator->get('OX_Dal_Maintenance_Statistics')) {
            $oFactory = new OX_Dal_Maintenance_Statistics_Factory();
            $oDal = $oFactory->factory();
            $oServiceLocator->register('OX_Dal_Maintenance_Statistics', $oDal);
        }

        // Add the task to set the update requirements
        $oSetUpdateRequirements = new OX_Maintenance_Statistics_Task_SetUpdateRequirements();
        $this->oTaskRunner->addTask($oSetUpdateRequirements);

        // Add the task to migrate the bucket data into the statistics tables
        $oSummariseIntermediate = new OX_Maintenance_Statistics_Task_MigrateBucketData();
        $this->oTaskRunner->addTask($oSummariseIntermediate);

        // Add the task to handle the de-duplication and rejection of empty conversions
        $oDeDuplicateConversions = new OX_Maintenance_Statistics_Task_DeDuplicateConversions();
        $this->oTaskRunner->addTask($oDeDuplicateConversions);

        // Add the task to handle the updating of "intermediate" statistics with
        // conversion information, as a legacy issue until all code obtains
        // conversion data from the standard conversion statistics tables
        $oManageConversions = new OX_Maintenance_Statistics_Task_ManageConversions();
        $this->oTaskRunner->addTask($oManageConversions);

        // Add the task to summarise the intermediate statistics into final form
        $oSummariseFinal = new OX_Maintenance_Statistics_Task_SummariseFinal();
        $this->oTaskRunner->addTask($oSummariseFinal);

        // Add the task to log the completion of the task
        $oLogCompletion = new OX_Maintenance_Statistics_Task_LogCompletion();
        $this->oTaskRunner->addTask($oLogCompletion);

        // Add the task to manage (enable/disable) campaigns
        $oManageCampaigns = new OX_Maintenance_Statistics_Task_ManageCampaigns();
        $this->oTaskRunner->addTask($oManageCampaigns);

        // addMaintenanceStatisticsTask hook
        if (!empty($this->aComponents) && is_array($this->aComponents)) {
            foreach ($this->aComponents as $componentId) {
                if ($obj = OX_Component::factoryByComponentIdentifier($componentId)) {
                    $this->oTaskRunner->addTask($obj->addMaintenanceStatisticsTask(), $obj->getExistingClassName(), $obj->getOrder());
                }
            }
        }

        // Run the MSE process tasks
        $this->oTaskRunner->runTasks();

        // addMaintenanceStatisticsTask hook
        if (!empty($this->aComponents) && is_array($this->aComponents)) {
            foreach ($this->aComponents as $componentId) {
                if ($obj = OX_Component::factoryByComponentIdentifier($componentId)) {
                    $obj->afterMse();
                }
            }
        }

        // Return to the "normal" user
        OA_Permission::switchToSystemProcessUser();

        // Log the end of the process
        OA::debug('Maintenance Statistics Engine Completed (Started at ' . $oDate->format('%Y-%m-%d %H:%M:%S') . ' ' . $oDate->tz->getShortName() . ')', PEAR_LOG_INFO);
        OA::switchLogIdent();
    }

}

?>
