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

require_once MAX_PATH . '/lib/OA/Task.php';

/**
 * A class for storing a collection of tasks, and then running those tasks
 * (in order) when requested.
 *
 * @package    OpenX
 * @subpackage Tasks
 * @author     Demian Turner <demian@m3.net>
 * @author     James Floyd <james@m3.net>
 */
class OA_Task_Runner
{

    /**
     * The collection of Task objects
     * @var array
     */
    var $aTasks;

    /**
     * A method to run the run() method of each task in the collection,
     * in the registered order.
     *
     * @todo We should really make OA_Task::run return a boolean we can check.
     */
    function runTasks()
    {
        // Remove tasks from the queue and unset them when done to prevent
        // useless memory consumption
        while ($oTask = array_shift($this->aTasks)) {
            $oTask->run();
            unset($oTask);
        }
    }

    /**
     * A method to register a new Task object in the collection of tasks.
     *
     * @param OA_Task $oTask An object that implements the OA_Task interface.
     * @param string $after An optional string specifying the class name of a task
     *                       already in the collection, which this task is to be inserted
     *                       to run just after.
     * @param string $replace An optional string specifying the class name of a task
     *                        already in the collection, which this task is to replace.
     * @return boolean Returns true on add success, false on failure.
     */
    function addTask($oTask, $after = null, $replace = null)
    {
        if (!is_null($after)) {
            if (!is_null($replace)) {
                // Can't run after and replace.
                return false;
            }
            // Try to locate the task supplied
            foreach ($this->aTasks as $key => $oExistingTask) {
                if (is_a($oExistingTask, $after)) {
                    // Insert the new task after this item
                    $this->aTasks = array_merge(
                        array_slice($this->aTasks, 0, $key + 1),
                        array($oTask),
                        array_slice($this->aTasks, $key + 1)
                    );
                    return true;
                }
            }
            // The existing task specified was not found
            return false;
        }

        if (!is_null($replace)) {
            foreach($this->aTasks as $key => $oExistingTask) {
                if (is_a($oExistingTask, $replace)) {
                    $this->aTasks[$key] = $oTask;
                    return true;
                }
            }
            return false;
        }

        if (is_a($oTask, 'OA_Task')) {
            $this->aTasks[] =& $oTask;
            return true;
        }
        return false;
    }

}

?>
