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

/**
 * A class for summarising raw data into the final tables, for the
 * AdServer module.
 *
 * @package    OpenXMaintenance
 * @subpackage Statistics
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Statistics_AdServer_Task_SummariseFinal extends OA_Maintenance_Statistics_Common_Task
{

    /**
     * The constructor method.
     *
     * @return OA_Maintenance_Statistics_AdServer_Task_SummariseFinal
     */
    function OA_Maintenance_Statistics_AdServer_Task_SummariseFinal()
    {
        parent::OA_Maintenance_Statistics_Common_Task();
    }

    /**
     * The implementation of the OA_Task::run() method that performs
     * the task of this class.
     */
    function run()
    {
        // Prepare any maintenance plugins that may be installed
        $aPlugins = MAX_Plugin::getPlugins('Maintenance');
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($this->oController->updateIntermediate || $this->oController->updateFinal) {
            $message = 'Saving request, impression, click and connection data into the final tables';
            $this->oController->report .= $message . "\n";
            OA::debug($message, PEAR_LOG_DEBUG);
        }
        if ($this->oController->updateIntermediate) {
            // Update the zone impression history table
            $oStartDate = new Date();
            $oStartDate->copy($this->oController->oLastDateIntermediate);
            $oStartDate->addSeconds(1);

            $this->_saveHistory($oStartDate, $this->oController->oUpdateIntermediateToDate);
        }
        if ($this->oController->updateFinal) {
            // Update the hourly summary table
            $oStartDate = new Date();
            $oStartDate->copy($this->oController->oLastDateFinal);
            $oStartDate->addSeconds(1);
            $this->_saveSummary($oStartDate, $this->oController->oUpdateFinalToDate);
        }
    }

    /**
     * A private method for summarising data into the final tables when
     * at least one operation interval is complete.
     *
     * @access private
     * @param PEAR::Date $oStartDate The start date of the complete operation interval(s).
     * @param PEAR::Date $oEndDate The end date of the complete operation interval(s).
     */
    function _saveHistory($oStartDate, $oEndDate)
    {
        $message = '- Updating the data_summary_zone_impression_history table for data after ' .
                   $oStartDate->format('%Y-%m-%d %H:%M:%S') . ' ' . $oStartDate->tz->getShortName();
        $this->oController->report .= $message . ".\n";
        OA::debug($message, PEAR_LOG_DEBUG);
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDal =& $oServiceLocator->get('OA_Dal_Maintenance_Statistics_AdServer');
        $oDal->saveHistory($oStartDate, $oEndDate);
    }

    /**
     * A private method for summarising data into the final tables when
     * at least one hour is complete.
     *
     * @access private
     * @param PEAR::Date $oStartDate The start date of the complete hour(s).
     * @param PEAR::Date $oEndDate The end date of the complete hour(s).
     */
    function _saveSummary($oStartDate, $oEndDate)
    {
        $message = '- Updating the data_summary_ad_hourly table for data after ' .
                   $oStartDate->format('%Y-%m-%d %H:%M:%S') . ' ' . $oStartDate->tz->getShortName();;
        $this->oController->report .= $message . ".\n";
        OA::debug($message, PEAR_LOG_DEBUG);
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDal =& $oServiceLocator->get('OA_Dal_Maintenance_Statistics_AdServer');
        $aTypes = array(
            'types' => array(
                0 => 'request',
                1 => 'impression',
                2 => 'click'
            ),
            'connections' => array(
                1 => MAX_CONNECTION_AD_IMPRESSION,
                2 => MAX_CONNECTION_AD_CLICK
            )
        );
        $oDal->saveSummary($oStartDate, $oEndDate, $aTypes, 'data_intermediate_ad', 'data_summary_ad_hourly');
    }

}

?>
