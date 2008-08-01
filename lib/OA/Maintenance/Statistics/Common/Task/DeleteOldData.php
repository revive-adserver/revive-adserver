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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Statistics/Common/Task.php';

require_once OX_PATH . '/lib/OX.php';

/**
 * A abstract class, definine a common method for deleting old data for
 * maintenance statistics module classes.
 *
 * @abstract
 * @package    OpenXMaintenance
 * @subpackage Statistics
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Statistics_Common_Task_DeleteOldData extends OA_Maintenance_Statistics_Common_Task
{

    /**
     * The constructor method.
     *
     * @return OA_Maintenance_Statistics_Common_Task_DeleteOldData
     */
    function OA_Maintenance_Statistics_Common_Task_DeleteOldData()
    {
        parent::OA_Maintenance_Statistics_Common_Task();
    }

    /**
     * The implementation of the OA_Task::run() method that performs
     * the task of this class. Intended to be inherited by children of this
     * class.
     */
    function run()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        if (!$conf['maintenance']['compactStats']) {
            // Old raw data are not to be deleted
            return;
        }
        // Calculate when the statistics have been summarised to
        if (($this->oController->updateFinal) && ($this->oController->updateUsingOI)) {
            // Have updated the final table stats, and the operation interval is less than
            // or equal to an hour, so it's safe to delete the statistics that have been
            // summarised now
            $oSummarisedToDate = new Date();
            $oSummarisedToDate->copy($this->oController->oUpdateFinalToDate);
        } elseif (($this->oController->updateIntermediate) && (!$this->oController->updateUsingOI)) {
            // Have updated the intermediate table stats, and the operation interval is
            // more than an hour, so it's safe to delete the statistics that have been
            // summarised now
            $oSummarisedToDate = new Date();
            $oSummarisedToDate->copy($this->oController->oUpdateIntermediateToDate);
        }
        if (empty($oSummarisedToDate)) {
            // Statistics were not summarised, don't delete
            return;
        }

        $this->_deleteOldData($oSummarisedToDate);        
    }

    /**
     * A private method for actually deleting the old data for a module.
     *
     * @access private
     * @param PEAR::Date $oSummarisedToDate The date to which the statistics have now
     *                                      been summarised.
     */
    function _deleteOldData($oSummarisedToDate)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $time = time();
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDal =& $oServiceLocator->get('OA_Dal_Maintenance_Statistics_' . $this->oController->module);
        $rows = $oDal->deleteOldData($oSummarisedToDate);
        $time = time() - $time;
        $this->report = !empty($this->report) ? $this->report : '';
        $message = "- Deleted $rows rows of old " . $this->oController->module .
                   " data in $time seconds";
        $this->report .= "\n$message\n";
        OA::debug($message, PEAR_LOG_DEBUG);
    }

}

?>