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

require_once MAX_PATH . '/lib/Max.php';

require_once LIB_PATH . '/Maintenance/Statistics/Task.php';
require_once OX_PATH . '/lib/OX.php';

/**
 * The MSE process task class that de-duplicates conversions and rejects
 * conversions that have empty variable values (where a variable value
 * is set to be required).
 *
 * @abstract
 * @package    OpenXMaintenance
 * @subpackage Statistics
 * @author     Andrew Hill <andrew.hill@openx.org>
 *
 *
 */
class OX_Maintenance_Statistics_Task_DeDuplicateConversions extends OX_Maintenance_Statistics_Task
{

    /**
     * The constructor method.
     *
     * @return OX_Maintenance_Statistics_Task_DeDuplicateConversions
     */
    function OX_Maintenance_Statistics_Task_DeDuplicateConversions()
    {
        parent::OX_Maintenance_Statistics_Task();
    }

    /**
     * The implementation of the OA_Task::run() method that performs
     * the required task of de-duplicating and rejecting conversions.
     */
    function run()
    {
        if ($this->oController->updateIntermediate) {

            // Preapre the start date for the de-duplication/rejection
            $oStartDate = new Date();
            $oStartDate->copy($this->oController->oLastDateIntermediate);
            $oStartDate->addSeconds(1);

            // Get the MSE DAL to perform the de-duplication
            $oServiceLocator =& OA_ServiceLocator::instance();
            $oDal =& $oServiceLocator->get('OX_Dal_Maintenance_Statistics');

            // De-duplicate conversions
            $oDal->deduplicateConversions($oStartDate, $this->oController->oUpdateIntermediateToDate);

            // Reject empty variable conversions
            $oDal->rejectEmptyVarConversions($oStartDate, $this->oController->oUpdateIntermediateToDate);

        }
    }

}

?>
