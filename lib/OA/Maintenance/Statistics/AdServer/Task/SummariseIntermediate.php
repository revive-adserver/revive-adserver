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

require_once MAX_PATH . '/lib/max/Plugin.php';

/**
 * A class for summarising raw data into the intermediate tables, for the
 * AdServer module.
 *
 * @package    OpenXMaintenance
 * @subpackage Statistics
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Statistics_AdServer_Task_SummariseIntermediate extends OA_Maintenance_Statistics_Common_Task
{

    /**
     * The constructor method.
     *
     * @return OA_Maintenance_Statistics_AdServer_Task_SummariseIntermediate
     */
    function OA_Maintenance_Statistics_AdServer_Task_SummariseIntermediate()
    {
        parent::OA_Maintenance_Statistics_Common_Task();
    }

    /**
     * The implementation of the OA_Task::run() method that performs
     * the task of this class.
     */
    function run()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Prepare any maintenance plugins that may be installed
        $aPlugins = MAX_Plugin::getPlugins('Maintenance');
        if (($this->oController->updateFinal) && (!$this->oController->updateUsingOI)) {
            // Summarise the intermediate stats by the hour
            $oStartDate = new Date();
            $oStartDate->copy($this->oController->oLastDateFinal);
            $oStartDate->addSeconds(1);
            while (Date::compare($oStartDate, $this->oController->oUpdateFinalToDate) < 0) {
                // Calculate the end of the hour
                $oEndDate = new Date();
                $oEndDate->copy($oStartDate);
                $oEndDate->addSeconds(SECONDS_PER_HOUR - 1); // Plus one hour
                // MSE PLUGIN HOOK: PRE- MSE_PLUGIN_HOOK_AdServer_summariseIntermediateRequests
                $return = MAX_Plugin::callOnPluginsByHook(
                    $aPlugins,
                    'run',
                    MAINTENANCE_PLUGIN_PRE,
                    MSE_PLUGIN_HOOK_AdServer_summariseIntermediateRequests,
                    array($oStartDate, $oEndDate)
                );
                if ($return !== false) {
                    // Summarise the requests
                    $this->_summariseIntermediateRequests($oStartDate, $oEndDate);
                }
                // MSE PLUGIN HOOK: POST- MSE_PLUGIN_HOOK_AdServer_summariseIntermediateRequests
                MAX_Plugin::callOnPluginsByHook(
                    $aPlugins,
                    'run',
                    MAINTENANCE_PLUGIN_POST,
                    MSE_PLUGIN_HOOK_AdServer_summariseIntermediateRequests,
                    array($oStartDate, $oEndDate)
                );
                // MSE PLUGIN HOOK: PRE- MSE_PLUGIN_HOOK_AdServer_summariseIntermediateImpressions
                $return = MAX_Plugin::callOnPluginsByHook(
                    $aPlugins,
                    'run',
                    MAINTENANCE_PLUGIN_PRE,
                    MSE_PLUGIN_HOOK_AdServer_summariseIntermediateImpressions,
                    array($oStartDate, $oEndDate)
                );
                if ($return !== false) {
                    // Summarise the impressions
                    $this->_summariseIntermediateImpressions($oStartDate, $oEndDate);
                }
                // MSE PLUGIN HOOK: POST- MSE_PLUGIN_HOOK_AdServer_summariseIntermediateImpressions
                MAX_Plugin::callOnPluginsByHook(
                    $aPlugins,
                    'run',
                    MAINTENANCE_PLUGIN_POST,
                    MSE_PLUGIN_HOOK_AdServer_summariseIntermediateImpressions,
                    array($oStartDate, $oEndDate)
                );
                // MSE PLUGIN HOOK: PRE- MSE_PLUGIN_HOOK_AdServer_summariseIntermediateClicks
                $return = MAX_Plugin::callOnPluginsByHook(
                    $aPlugins,
                    'run',
                    MAINTENANCE_PLUGIN_PRE,
                    MSE_PLUGIN_HOOK_AdServer_summariseIntermediateClicks,
                    array($oStartDate, $oEndDate)
                );
                if ($return !== false) {
                    // Summarise the clicks
                    $this->_summariseIntermediateClicks($oStartDate, $oEndDate);
                }
                // MSE PLUGIN HOOK: POST- MSE_PLUGIN_HOOK_AdServer_summariseIntermediateClicks
                MAX_Plugin::callOnPluginsByHook(
                    $aPlugins,
                    'run',
                    MAINTENANCE_PLUGIN_POST,
                    MSE_PLUGIN_HOOK_AdServer_summariseIntermediateClicks,
                    array($oStartDate, $oEndDate)
                );
                // MSE PLUGIN HOOK: PRE- MSE_PLUGIN_HOOK_AdServer_summariseIntermediateConnections
                $return = MAX_Plugin::callOnPluginsByHook(
                    $aPlugins,
                    'run',
                    MAINTENANCE_PLUGIN_PRE,
                    MSE_PLUGIN_HOOK_AdServer_summariseIntermediateConnections,
                    array($oStartDate, $oEndDate)
                );
                if ($return !== false) {
                    // Summarise the connections
                    $this->_summariseIntermediateConnections($oStartDate, $oEndDate);
                }
                // MSE PLUGIN HOOK: POST- MSE_PLUGIN_HOOK_AdServer_summariseIntermediateConnections
                MAX_Plugin::callOnPluginsByHook(
                    $aPlugins,
                    'run',
                    MAINTENANCE_PLUGIN_POST,
                    MSE_PLUGIN_HOOK_AdServer_summariseIntermediateConnections,
                    array($oStartDate, $oEndDate)
                );
                // MSE PLUGIN HOOK: PRE- MSE_PLUGIN_HOOK_AdServer_saveIntermediateSummaries
                $return = MAX_Plugin::callOnPluginsByHook(
                    $aPlugins,
                    'run',
                    MAINTENANCE_PLUGIN_PRE,
                    MSE_PLUGIN_HOOK_AdServer_saveIntermediateSummaries,
                    array($oStartDate, $oEndDate)
                );
                if ($return !== false) {
                    // Save the impressions/clicks/connections
                    $this->_saveIntermediateSummaries($oStartDate, $oEndDate);
                }
                // MSE PLUGIN HOOK: POST- MSE_PLUGIN_HOOK_AdServer_saveIntermediateSummaries
                MAX_Plugin::callOnPluginsByHook(
                    $aPlugins,
                    'run',
                    MAINTENANCE_PLUGIN_POST,
                    MSE_PLUGIN_HOOK_AdServer_saveIntermediateSummaries,
                    array($oStartDate, $oEndDate)
                );
                // Go to the next hour
                $oStartDate->addSeconds(3600);
            }
        } elseif (($this->oController->updateIntermediate) && ($this->oController->updateUsingOI)) {
            $oServiceLocator =& OA_ServiceLocator::instance();
            $counter = 0;
            // Summarise the intermediate stats by the operation interval
            $oStartDate = new Date();
            $oStartDate->copy($this->oController->oLastDateIntermediate);
            $oStartDate->addSeconds(1);
            while (Date::compare($oStartDate, $this->oController->oUpdateIntermediateToDate) < 0) {
                // Should bad operation interval dates be ignored?
                $oDal =& $oServiceLocator->get('OA_Dal_Maintenance_Statistics_AdServer');
                $oDal->ignoreBadOperationIntervals = false;
                if (($counter == 0) && (!$this->oController->sameOI)) {
                    $oDal->ignoreBadOperationIntervals = true;
                }
                // Calcuate the end of the operation interval
                $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oStartDate);
                $oEndDate = new Date();
                $oEndDate->copy($aDates['end']);
                // MSE PLUGIN HOOK: PRE- MSE_PLUGIN_HOOK_AdServer_summariseIntermediateRequests
                $return = MAX_Plugin::callOnPluginsByHook(
                    $aPlugins,
                    'run',
                    MAINTENANCE_PLUGIN_PRE,
                    MSE_PLUGIN_HOOK_AdServer_summariseIntermediateRequests,
                    array($oStartDate, $oEndDate)
                );
                if ($return !== false) {
                    // Summarise the requests
                    $this->_summariseIntermediateRequests($oStartDate, $oEndDate);
                }
                // MSE PLUGIN HOOK: POST- MSE_PLUGIN_HOOK_AdServer_summariseIntermediateRequests
                MAX_Plugin::callOnPluginsByHook(
                    $aPlugins,
                    'run',
                    MAINTENANCE_PLUGIN_POST,
                    MSE_PLUGIN_HOOK_AdServer_summariseIntermediateRequests,
                    array($oStartDate, $oEndDate)
                );
                // MSE PLUGIN HOOK: PRE- MSE_PLUGIN_HOOK_AdServer_summariseIntermediateImpressions
                $return = MAX_Plugin::callOnPluginsByHook(
                    $aPlugins,
                    'run',
                    MAINTENANCE_PLUGIN_PRE,
                    MSE_PLUGIN_HOOK_AdServer_summariseIntermediateImpressions,
                    array($oStartDate, $oEndDate)
                );
                if ($return !== false) {
                    // Summarise the impressions
                    $this->_summariseIntermediateImpressions($oStartDate, $oEndDate);
                }
                // MSE PLUGIN HOOK: POST- MSE_PLUGIN_HOOK_AdServer_summariseIntermediateImpressions
                MAX_Plugin::callOnPluginsByHook(
                    $aPlugins,
                    'run',
                    MAINTENANCE_PLUGIN_POST,
                    MSE_PLUGIN_HOOK_AdServer_summariseIntermediateImpressions,
                    array($oStartDate, $oEndDate)
                );
                // MSE PLUGIN HOOK: PRE- MSE_PLUGIN_HOOK_AdServer_summariseIntermediateClicks
                $return = MAX_Plugin::callOnPluginsByHook(
                    $aPlugins,
                    'run',
                    MAINTENANCE_PLUGIN_PRE,
                    MSE_PLUGIN_HOOK_AdServer_summariseIntermediateClicks,
                    array($oStartDate, $oEndDate)
                );
                if ($return !== false) {
                    // Summarise the clicks
                    $this->_summariseIntermediateClicks($oStartDate, $oEndDate);
                }
                // MSE PLUGIN HOOK: POST- MSE_PLUGIN_HOOK_AdServer_summariseIntermediateClicks
                MAX_Plugin::callOnPluginsByHook(
                    $aPlugins,
                    'run',
                    MAINTENANCE_PLUGIN_POST,
                    MSE_PLUGIN_HOOK_AdServer_summariseIntermediateClicks,
                    array($oStartDate, $oEndDate)
                );
                // MSE PLUGIN HOOK: PRE- MSE_PLUGIN_HOOK_AdServer_summariseIntermediateConnections
                $return = MAX_Plugin::callOnPluginsByHook(
                    $aPlugins,
                    'run',
                    MAINTENANCE_PLUGIN_PRE,
                    MSE_PLUGIN_HOOK_AdServer_summariseIntermediateConnections,
                    array($oStartDate, $oEndDate)
                );
                if ($return !== false) {
                    // Summarise the connections
                    $this->_summariseIntermediateConnections($oStartDate, $oEndDate);
                }
                // MSE PLUGIN HOOK: POST- MSE_PLUGIN_HOOK_AdServer_summariseIntermediateConnections
                MAX_Plugin::callOnPluginsByHook(
                    $aPlugins,
                    'run',
                    MAINTENANCE_PLUGIN_POST,
                    MSE_PLUGIN_HOOK_AdServer_summariseIntermediateConnections,
                    array($oStartDate, $oEndDate)
                );
                // MSE PLUGIN HOOK: PRE- MSE_PLUGIN_HOOK_AdServer_saveIntermediateSummaries
                $return = MAX_Plugin::callOnPluginsByHook(
                    $aPlugins,
                    'run',
                    MAINTENANCE_PLUGIN_PRE,
                    MSE_PLUGIN_HOOK_AdServer_saveIntermediateSummaries,
                    array($oStartDate, $oEndDate)
                );
                if ($return !== false) {
                    // Save the impressions/clicks/connections
                    $this->_saveIntermediateSummaries($oStartDate, $oEndDate);
                }
                // MSE PLUGIN HOOK: POST- MSE_PLUGIN_HOOK_AdServer_saveIntermediateSummaries
                MAX_Plugin::callOnPluginsByHook(
                    $aPlugins,
                    'run',
                    MAINTENANCE_PLUGIN_POST,
                    MSE_PLUGIN_HOOK_AdServer_saveIntermediateSummaries,
                    array($oStartDate, $oEndDate)
                );
                // Go to the next operation interval (done via the operation interval end
                // date to ensure that this works when using a non-standard range)
                $oStartDate->copy($oEndDate);
                $oStartDate->addSeconds(1);
                // Increment the counter
                $counter++;
            }
        }
    }

    /**
     * A private method to summarise the ad requests, ready for insertion into
     * intermediate statistics tables.
     *
     * @access private
     * @param PEAR::Date $oStartDate The start date of the data to summarise.
     * @param PEAR::Date $oEndDate The end date of the data to summarise.
     */
    function _summariseIntermediateRequests($oStartDate, $oEndDate)
    {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDal =& $oServiceLocator->get('OA_Dal_Maintenance_Statistics_AdServer');
        $startTime = time();
        $message = 'Summarising requests for the intermediate tables';
        $this->oController->report .= $message . "\n";
        OA::debug($message, PEAR_LOG_DEBUG);
        $message = '- Summarising requests between ' .
                   $oStartDate->format('%Y-%m-%d %H:%M:%S') . ' ' . $oStartDate->tz->getShortName() .
                   ' and ' . $oEndDate->format('%Y-%m-%d %H:%M:%S') . ' ' . $oEndDate->tz->getShortName();
        $this->oController->report .= $message . "\n";
        OA::debug($message, PEAR_LOG_DEBUG);
        $rows = $oDal->summariseRequests($oStartDate, $oEndDate);
        $runTime = time() - $startTime;
        $message = "- Summarised $rows request rows in $runTime seconds";
        $this->oController->report .= $message . "\n";
        OA::debug($message, PEAR_LOG_DEBUG);
    }

    /**
     * A private method to summarise the ad impressions, ready for insertion into
     * intermediate statistics tables.
     *
     * @access private
     * @param PEAR::Date $oStartDate The start date of the data to summarise.
     * @param PEAR::Date $oEndDate The end date of the data to summarise.
     */
    function _summariseIntermediateImpressions($oStartDate, $oEndDate)
    {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDal =& $oServiceLocator->get('OA_Dal_Maintenance_Statistics_AdServer');
        $startTime = time();
        $message = 'Summarising impressions for the intermediate tables';
        $this->oController->report .= $message . "\n";
        OA::debug($message, PEAR_LOG_DEBUG);
        $message = '- Summarising impressions between ' .
                   $oStartDate->format('%Y-%m-%d %H:%M:%S') . ' ' . $oStartDate->tz->getShortName() .
                   ' and ' . $oEndDate->format('%Y-%m-%d %H:%M:%S') . ' ' . $oEndDate->tz->getShortName();
        $this->oController->report .= $message . "\n";
        OA::debug($message, PEAR_LOG_DEBUG);
        $rows = $oDal->summariseImpressions($oStartDate, $oEndDate);
        $runTime = time() - $startTime;
        $message = "- Summarised $rows impression rows in $runTime seconds";
        $this->oController->report .= $message . "\n";
        OA::debug($message, PEAR_LOG_DEBUG);
    }

    /**
     * A private method to summarise the ad clicks, ready for insertion into
     * intermediate statistics tables.
     *
     * @access private
     * @param PEAR::Date $oStartDate The start date of the data to summarise.
     * @param PEAR::Date $oEndDate The end date of the data to summarise.
     */
    function _summariseIntermediateClicks($oStartDate, $oEndDate)
    {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDal =& $oServiceLocator->get('OA_Dal_Maintenance_Statistics_AdServer');
        $startTime = time();
        $message = 'Summarising clicks for the intermediate tables';
        $this->oController->report .= $message . "\n";
        OA::debug($message, PEAR_LOG_DEBUG);
        $message = '- Summarising clicks between ' .
                   $oStartDate->format('%Y-%m-%d %H:%M:%S') . ' ' . $oStartDate->tz->getShortName() .
                   ' and ' . $oEndDate->format('%Y-%m-%d %H:%M:%S') . ' ' . $oEndDate->tz->getShortName();
        $this->oController->report .= $message . "\n";
        OA::debug($message, PEAR_LOG_DEBUG);
        $rows = $oDal->summariseClicks($oStartDate, $oEndDate);
        $runTime = time() - $startTime;
        $message = "- Summarised $rows click rows in $runTime seconds";
        $this->oController->report .= $message . "\n";
        OA::debug($message, PEAR_LOG_DEBUG);
    }

    /**
     * A private method to summarise the ad connections, ready for insertion into
     * intermediate statistics tables.
     *
     * @access private
     * @param PEAR::Date $oStartDate The start date of the data to summarise.
     * @param PEAR::Date $oEndDate The end date of the data to summarise.
     */
    function _summariseIntermediateConnections($oStartDate, $oEndDate)
    {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDal =& $oServiceLocator->get('OA_Dal_Maintenance_Statistics_AdServer');
        $startTime = time();
        $message = 'Summarising connections for the intermediate tables';
        $this->oController->report .= $message . "\n";
        OA::debug($message, PEAR_LOG_DEBUG);
        $message = '- Summarising connections between ' .
                   $oStartDate->format('%Y-%m-%d %H:%M:%S') . ' ' . $oStartDate->tz->getShortName() .
                   ' and ' . $oEndDate->format('%Y-%m-%d %H:%M:%S') . ' ' . $oEndDate->tz->getShortName();
        $this->oController->report .= $message . "\n";
        OA::debug($message, PEAR_LOG_DEBUG);
        $rows = $oDal->summariseConnections($oStartDate, $oEndDate);
        $runTime = time() - $startTime;
        $message = "- Summarised $rows connection rows in $runTime seconds";
        $this->oController->report .= $message . "\n";
        OA::debug($message, PEAR_LOG_DEBUG);
    }

    /**
     * A private method to save the summarised request/impressions/clicks/connections
     * into the intermediate tables.
     *
     * @access private
     * @param PEAR::Date $oStartDate The start date of the data to save.
     * @param PEAR::Date $oEndDate The end date of the data to save.
     */
    function _saveIntermediateSummaries($oStartDate, $oEndDate)
    {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDal =& $oServiceLocator->get('OA_Dal_Maintenance_Statistics_AdServer');
        $aConf = $GLOBALS['_MAX']['CONF'];
        $message = 'Saving request, impression, click and connection data into the intermediate tables';
        $this->oController->report .= $message . "\n";
        OA::debug($message, PEAR_LOG_DEBUG);
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
        $oDal->saveIntermediate($oStartDate, $oEndDate, $aTypes);
    }

}

?>
