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

require_once LIB_PATH . '/Plugin/Component.php';
require_once MAX_PATH . '/lib/OA/Task/Runner.php';

/**
 * Plugins_MaintenanceStatisticsTask is an abstract class for every maintenanceStatisticsTask plugin
 *
 * @package    OpenXPlugin
 * @subpackage MaintenaceStatisticsTask
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 * @abstract
 */
abstract class Plugins_MaintenanceStatisticsTask extends OX_Component
{
    /**
     * Constructor method
     */
    function __construct($extension, $group, $component) {
    }

    /**
     * Method returns OX_Maintenance_Statistics_Task 
     * to run in the Maintenance Statistics Engine
     * Implements hook 'addMaintenanceStatisticsTask'
     * 
     * @abstract 
     * @return OX_Maintenance_Statistics_Task
     */
    abstract function addMaintenanceStatisticsTask();

    /**
     * Returns the class name of the task this task should run after or replace.
     * To add to the end of the task list, return null.
     *
     * @return string the name of the task to run after or replace.
     */
    public function getExistingClassName()
    {
        return null;
    }

    /**
     * Whether the task should replace the class specified in getExistingClassName.
     * Use class constants defined in OA_Task_Runner.
     *
     * @return integer -1 if the task should run before the specified class,
     *                 0 if the task should replace the specified class,
     *                 1 if the task should run after the specified class.
     */
    public function getOrder()
    {
        return OA_Task_Runner::TASK_ORDER_AFTER;
    }

    /**
     * Run before the MSE tasks.
     *
     * @return boolean true on success, false on failure.
     */
    public function beforeMse()
    {
        return true;
    }

    /**
     * Run after the MSE tasks.
     *
     * @return boolean true on successm false on failure.
     */
    public function afterMse()
    {
        return true;
    }
}

?>
