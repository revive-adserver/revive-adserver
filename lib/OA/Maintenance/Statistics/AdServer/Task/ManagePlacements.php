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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Statistics/Common/Task.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

/**
 * A class for managing (enabling/disabling) placements, for the AdServer module.
 *
 * @package    OpenXMaintenance
 * @subpackage Statistics
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Statistics_AdServer_Task_ManagePlacements extends OA_Maintenance_Statistics_Common_Task
{

    /**
     * The constructor method.
     *
     * @return OA_Maintenance_Statistics_AdServer_Task_ManagePlacements
     */
    function OA_Maintenance_Statistics_AdServer_Task_ManagePlacements()
    {
        parent::OA_Maintenance_Statistics_Common_Task();
    }

    /**
     * The implementation of the OA_Task::run() method that performs
     * the task of this class.
     */
    function run()
    {
        if ($this->oController->updateIntermediate) {
            $oServiceLocator =& OA_ServiceLocator::instance();
            $oDate =& $oServiceLocator->get('now');
            $oDal =& $oServiceLocator->get('OA_Dal_Maintenance_Statistics_AdServer');
            $message = 'Managing (activating/deactivating) placements';
            $this->oController->report .= "$message.\n";
            OA::debug($message);
            $this->report .= $oDal->managePlacements($oDate);
        }
    }

}

?>
