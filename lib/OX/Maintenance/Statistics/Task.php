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

require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/OA/Task.php';

require_once LIB_PATH . '/Dal/Maintenance/Statistics/Factory.php';

/**
 * A abstract class, defining an interface for Maintenance Statistics Common
 * Task objects, to be collected and run using the OA_Task_Runner class.
 *
 * @abstract
 * @package    OpenXMaintenance
 * @subpackage Statistics
 */
class OX_Maintenance_Statistics_Task extends OA_Task
{
    /**
     * The "module" name of the maintenance statistics tasks
     *
     * @var string
     */
    public $module;

    /**
     * A reference to the object (that extends the
     * OA_Maintenance_Statistics_Common class) that is running the task.
     *
     * @var OX_Maintenance_Statistics
     */
    public $oController;

    /**
     * A variable to store report information about MSE runs.
     *
     * @var string
     */
    public $report;

    /**
     * The abstract class constructor, to be used by classes implementing
     * this class.
     */
    public function __construct()
    {
        // Set the local reference to the class which is controlling this task
        $oServiceLocator = OA_ServiceLocator::instance();
        $this->oController = $oServiceLocator->get('Maintenance_Statistics_Controller');
    }
}
