<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/OA.php';

require_once LIB_PATH . '/Maintenance/Statistics/Task.php';

/**
 * The MSE process task class that summarises any statistics table
 * (i.e. OpenX 2.6-style data_intermediate_% table) data into the
 * OpenX 2.6-style data_sumamry_% tables.
 *
 * @TODO Deprecate class once the data_sumamry_% tables are removed,
 *       and all access to statistics is from new statistics tables
 *       only.
 *
 * @package    OpenXMaintenance
 * @subpackage Statistics
 */
class OX_Maintenance_Statistics_Task_SummariseFinal extends OX_Maintenance_Statistics_Task
{
    /**
     * The constructor method.
     *
     * @return OX_Maintenance_Statistics_Task_SummariseFinal
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The implementation of the OA_Task::run() method that performs
     * the required task of migrating data_intermediate_% table data
     * into the data_summary_% tables.
     */
    public function run()
    {
        if ($this->oController->updateIntermediate || $this->oController->updateFinal) {
            $message = '- Saving request, impression, click and conversion data into the final tables.';
            $this->oController->report .= $message . "\n";
            OA::debug($message, PEAR_LOG_DEBUG);
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
     * at least one hour is complete.
     *
     * @access private
     * @param PEAR::Date $oStartDate The start date of the complete hour(s).
     * @param PEAR::Date $oEndDate The end date of the complete hour(s).
     */
    public function _saveSummary($oStartDate, $oEndDate)
    {
        $message = '- Updating the data_summary_ad_hourly table for data after ' .
                   $oStartDate->format('%Y-%m-%d %H:%M:%S') . ' ' . $oStartDate->tz->getShortName();
        ;
        $this->oController->report .= $message . ".\n";
        OA::debug($message, PEAR_LOG_DEBUG);
        $oServiceLocator = OA_ServiceLocator::instance();
        $oDal = &$oServiceLocator->get('OX_Dal_Maintenance_Statistics');
        $aTypes = [
            'types' => [
                0 => 'request',
                1 => 'impression',
                2 => 'click'
            ],
            'connections' => [
                1 => MAX_CONNECTION_AD_IMPRESSION,
                2 => MAX_CONNECTION_AD_CLICK
            ]
        ];
        $oDal->saveSummary($oStartDate, $oEndDate, $aTypes, 'data_intermediate_ad', 'data_summary_ad_hourly');
    }
}
