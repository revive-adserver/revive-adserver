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

require_once MAX_PATH . '/lib/OA/Maintenance/Statistics/Common.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Statistics/AdServer/Task/SetUpdateRequirements.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Statistics/AdServer/Task/SummariseIntermediate.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Statistics/AdServer/Task/SummariseFinal.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Statistics/AdServer/Task/ManagePlacements.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Statistics/AdServer/Task/DeleteOldData.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Statistics/AdServer/Task/LogCompletion.php';

/**
 * A class for defining and running the maintenance statistics tasks for the
 * 'AdServer' module.
 *
 * @package    OpenXMaintenance
 * @subpackage Statistics
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Statistics_AdServer extends OA_Maintenance_Statistics_Common
{

    /**
     * The constructor method.
     */
    function OA_Maintenance_Statistics_AdServer()
    {
        parent::OA_Maintenance_Statistics_Common();
        // This is the AdServer module
        $this->module = 'AdServer';
        // Register this object as the controlling class for the process
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $this);
        // Add a task to set the update requirements
        $oSetUpdateRequirements = new OA_Maintenance_Statistics_AdServer_Task_SetUpdateRequirements();
        $this->oTaskRunner->addTask($oSetUpdateRequirements);
        // Add a task to summarise the raw statistics into intermediate form
        $oSummariseIntermediate = new OA_Maintenance_Statistics_AdServer_Task_SummariseIntermediate();
        $this->oTaskRunner->addTask($oSummariseIntermediate);
        // Add a task to summarise the intermediate statistics into final form
        $oSummariseFinal = new OA_Maintenance_Statistics_AdServer_Task_SummariseFinal();
        $this->oTaskRunner->addTask($oSummariseFinal);
        // Add a task to manage the placements (enable/disable)
        $oManagePlacements = new OA_Maintenance_Statistics_AdServer_Task_ManagePlacements();
        $this->oTaskRunner->addTask($oManagePlacements);
        // Add a task to delete old data
        $oDeleteOldData = new OA_Maintenance_Statistics_AdServer_Task_DeleteOldData();
        $this->oTaskRunner->addTask($oDeleteOldData);
        // Add a task to log the completion of the task
        $oLogCompletion = new OA_Maintenance_Statistics_AdServer_Task_LogCompletion();
        $this->oTaskRunner->addTask($oLogCompletion);
    }

}

?>
