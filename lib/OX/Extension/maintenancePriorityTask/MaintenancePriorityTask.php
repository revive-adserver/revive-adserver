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
require_once LIB_PATH . '/Plugin/Component.php';

/**
 * An abstract class for every maintenancePriorityTask plugin.
 *
 * @package    OpenXPlugin
 * @subpackage MaintenancePriorityTask
 * @author     David Keen <david.keen@openx.org>
 * @abstract
 */
abstract class Plugins_MaintenancePriorityTask extends OX_Component
{
    /**
     * Constructor method
     */
    function __construct($extension, $group, $component) {
    }

    /**
     * Method returns OX_Maintenance_Priority_Task
     * to run in the Maintenance Priority Engine
     * Implements hook 'addMaintenancePriorityTask'
     *
     * @abstract
     * @return OX_Maintenance_Priority_Task
     */
    abstract function addMaintenancePriorityTask();

    /**
     * Returns the class name of the task this task should run after.
     * To add to the end of the task list, return null.
     *
     * @return string the name of the task to run after.
     */
    public function getAfterClassName()
    {
        return null;
    }

    /**
     * Returns the class name of the task this task should replace.
     * To add to the end of the task list, return null.
     *
     * @return string the name of the task to replace.
     */
    public function getReplacementClassName()
    {
        return null;
    }
}

?>
