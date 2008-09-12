<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OX_Maintenance_Statistics_Task extends OA_Task
{

    /**
     * The "module" name of the maintenance statistics tasks
     *
     * @var string
     */
    var $module;

    /**
     * A reference to the object (that extends the
     * OA_Maintenance_Statistics_Common class) that is running the task.
     *
     * @var OA_Maintenance_Statistics_Common
     */
    var $oController;

    /**
     * A variable to store report information about MSE runs.
     *
     * @var string
     */
    var $report;

    /**
     * The abstract class constructor, to be used by classes implementing
     * this class.
     */
    function OX_Maintenance_Statistics_Task()
    {
        // Set the local reference to the class which is controlling this task
        $oServiceLocator =& OA_ServiceLocator::instance();
        $this->oController =& $oServiceLocator->get('Maintenance_Statistics_Controller');
    }

}

?>