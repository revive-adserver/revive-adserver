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
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

require_once LIB_PATH . '/Maintenance/Statistics/Task.php';

/**
 * The MSE process task class that manages (enables/disables) campaigns, as
 * required, during the MSE run.
 *
 * @package    OpenXMaintenance
 * @subpackage Statistics
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OX_Maintenance_Statistics_Task_ManageCampaigns extends OX_Maintenance_Statistics_Task
{

    /**
     * The constructor method.
     *
     * @return OX_Maintenance_Statistics_Task_ManageCampaigns
     */
    function OX_Maintenance_Statistics_Task_ManageCampaigns()
    {
        parent::OX_Maintenance_Statistics_Task();
    }

    /**
     * The implementation of the OA_Task::run() method that performs
     * the required task of activating/deactivating campaigns.
     */
    function run()
    {
        if ($this->oController->updateIntermediate) {
            $oServiceLocator =& OA_ServiceLocator::instance();
            $oDate =& $oServiceLocator->get('now');
            $oDal =& $oServiceLocator->get('OX_Dal_Maintenance_Statistics');
            $message = '- Managing (activating/deactivating) campaigns';
            $this->oController->report .= "$message.\n";
            OA::debug($message);
            $this->report .= $oDal->manageCampaigns($oDate);
        }
    }

}

?>