<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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
require_once MAX_PATH . '/lib/max/Maintenance/Statistics/Common/Task.php';

/**
 * A abstract class, definine a common method for deleting old data for
 * maintenance statistics module classes.
 *
 * @abstract
 * @package    MaxMaintenance
 * @subpackage Statistics
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Maintenance_Statistics_Common_Task_DeleteOldData extends MAX_Maintenance_Statistics_Common_Task
{

    /**
     * The constructor method.
     *
     * @return MAX_Maintenance_Statistics_Common_Task_DeleteOldData
     */
    function MAX_Maintenance_Statistics_Common_Task_DeleteOldData()
    {
        parent::MAX_Maintenance_Statistics_Common_Task();
    }

    /**
     * The implementation of the MAX_Core_Task::run() method that performs
     * the task of this class. Intended to be inherited by childred of this
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
            $oSummarisedToDate->copy($this->oController->updateFinalToDate);
        } elseif (($this->oController->updateIntermediate) && (!$this->oController->updateUsingOI)) {
            // Have updated the intermediate table stats, and the operation interval is
            // more than an hour, so it's safe to delete the statistics that have been
            // summarised now
            $oSummarisedToDate = new Date();
            $oSummarisedToDate->copy($this->oController->updateIntermediateToDate);
        }
        if (is_null($oSummarisedToDate)) {
            // Statistics were not summarised, don't delete
            return;
        }
        // Prepare any maintenance plugins that may be installed
        $aPlugins = MAX_Plugin::getPlugins('Maintenance');
        // MSE PLUGIN HOOK: PRE- MSE_PLUGIN_HOOK_AdServer_deleteOldData
        $return = MAX_Plugin::callOnPluginsByHook(
            $aPlugins,
            'run',
            MAINTENANCE_PLUGIN_PRE,
            constant('MSE_PLUGIN_HOOK_' . $this->oController->module . '_deleteOldData'),
            array($oSummarisedToDate)
        );
        if ($return !== false) {
            $this->_deleteOldData($oSummarisedToDate);
        }
       // MSE PLUGIN HOOK: POST- MSE_PLUGIN_HOOK_AdServer_deleteOldData
        $return = MAX_Plugin::callOnPluginsByHook(
            $aPlugins,
            'run',
            MAINTENANCE_PLUGIN_POST,
            constant('MSE_PLUGIN_HOOK_' . $this->oController->module . '_deleteOldData'),
            array($oSummarisedToDate)
        );
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
        $time = time();
        $oServiceLocator = &ServiceLocator::instance();
        $oDal = &$oServiceLocator->get('OA_Dal_Maintenance_Statistics_' . $this->oController->module);
        $rows = $oDal->deleteOldData($oSummarisedToDate);
        $time = time() - $time;
        if ($conf['table']['split']) {
            $message = "Dropped $rows " . $this->oController->module .
                       " raw data tables of old data in $time seconds.";
            $this->report .= "\n$message\n";
            MAX::debug($message, PEAR_LOG_DEBUG);
        } else {
            $message = "Deleted $rows rows of old " . $this->oController->module .
                       " data in $time seconds.";
            $this->report .= "\n$message\n";
            MAX::debug($message, PEAR_LOG_DEBUG);
        }
    }

}

?>
